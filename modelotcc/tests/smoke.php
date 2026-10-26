<?php
/**
 * Teste de fumaça do SOCEA: schema, seed, CRUD básico, agenda e anexos.
 * Usa banco e pasta de upload temporários; não toca nos dados reais.
 *
 * Uso: php tests/smoke.php
 */

$dbTemp = tempnam(sys_get_temp_dir(), 'socea_db_');
if ($dbTemp === false) {
    fwrite(STDERR, "Não foi possível criar o banco temporário.\n");
    exit(1);
}
@unlink($dbTemp);

$uploadTemp = sys_get_temp_dir() . '/socea_uploads_' . getmypid();
putenv('SOCEA_DB=' . $dbTemp);
putenv('SOCEA_UPLOAD_DIR=' . $uploadTemp);
putenv('SOCEA_ADMIN_EMAIL=teste@socea.local');
putenv('SOCEA_ADMIN_SENHA=SenhaTeste123');

require __DIR__ . '/../Scripts/Conexao.php';

$falhas = 0;

function checar(bool $condicao, string $mensagem): void
{
    global $falhas;
    if ($condicao) {
        echo "ok - {$mensagem}\n";
        return;
    }
    $falhas++;
    echo "FALHOU - {$mensagem}\n";
}

$pdo = db();
checar($pdo instanceof PDO, 'conexão PDO com SQLite');

$tabelas = ['perfilusuario', 'perfilcliente', 'processo', 'Agendamento', 'anexo'];
foreach ($tabelas as $tabela) {
    $existe = $pdo->query(
        "SELECT 1 FROM sqlite_master WHERE type = 'table' AND name = " . $pdo->quote($tabela)
    )->fetchColumn();
    checar($existe !== false, "tabela {$tabela} criada");
}

$admin = db_one('SELECT * FROM perfilusuario WHERE Login = ?', ['teste@socea.local']);
checar($admin !== null, 'administrador inicial criado');
checar(
    $admin !== null && password_verify('SenhaTeste123', (string) $admin['Senha']),
    'senha do administrador usa password_hash'
);

$clienteId = db_insert(
    'INSERT INTO perfilcliente (Nome, SobreNome, CPF) VALUES (?, ?, ?)',
    ['Cliente', 'Teste', '000.000.000-00']
);
checar($clienteId > 0, 'cliente inserido');

$processoId = db_insert(
    'INSERT INTO processo (CodCliente, NumProcesso, ObjetoDeAcao) VALUES (?, ?, ?)',
    [$clienteId, '1234/2026', 'Cobrança']
);
checar($processoId > 0, 'processo inserido');

$processo = db_one('SELECT * FROM processo WHERE codProcesso = ?', [$processoId]);
checar($processo !== null && (int) $processo['CodCliente'] === $clienteId, 'processo vinculado ao cliente');

$agendamentoId = db_insert(
    'INSERT INTO Agendamento (AgendamentoDe, Descricao, HrAgendamento, DataAgendamento)
     VALUES (?, ?, ?, ?)',
    [(int) $admin['CodUsuario'], 'Reunião de teste', '14:00', '2026-12-01']
);
checar($agendamentoId > 0, 'agendamento inserido');

$agenda = agenda_do_usuario((int) $admin['CodUsuario']);
checar(count($agenda) === 1 && $agenda[0]['Descricao'] === 'Reunião de teste', 'agenda do usuário');

checar(db_exec('UPDATE perfilcliente SET Cidade = ? WHERE CodCliente = ?', ['Porto Alegre', $clienteId]) === 1, 'update preparado');

$anexoId = db_insert(
    'INSERT INTO anexo (nomeArquivo, dataUpload, realNome, codProcesso) VALUES (?, ?, ?, ?)',
    ['abc.txt', '2026-12-01 10:00:00', 'documento.txt', $processoId]
);
checar($anexoId > 0 && is_dir(socea_upload_dir()), 'anexo registrado e pasta de upload criada');

checar(e('<script>alert(1)</script>') === '&lt;script&gt;alert(1)&lt;/script&gt;', 'escape de HTML');
checar(post_str('inexistente', 'padrao') === 'padrao', 'post_str com valor padrão');

// limpeza
foreach ([$dbTemp, $dbTemp . '-shm', $dbTemp . '-wal'] as $arquivo) {
    if (is_file($arquivo)) {
        @unlink($arquivo);
    }
}
if (is_dir($uploadTemp)) {
    foreach (glob($uploadTemp . '/*') ?: [] as $arquivo) {
        @unlink($arquivo);
    }
    @rmdir($uploadTemp);
}

echo $falhas === 0 ? "\nTodos os testes passaram.\n" : "\n{$falhas} teste(s) falharam.\n";
exit($falhas === 0 ? 0 : 1);
