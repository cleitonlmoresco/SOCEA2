<?php
/**
 * Inicializa o banco SQLite do SOCEA e, opcionalmente, dados de demonstração.
 *
 * Uso:
 *   php Scripts/init_db.php
 *   php Scripts/init_db.php --demo
 *   SOCEA_ADMIN_SENHA='nova-senha-forte' php Scripts/init_db.php --reset-admin
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Este script só pode ser executado pela linha de comando.');
}

require_once __DIR__ . '/Conexao.php';

$pdo = db();
echo 'Banco: ' . socea_db_path() . PHP_EOL;

if (in_array('--reset-admin', $argv, true)) {
    $email = getenv('SOCEA_ADMIN_EMAIL') ?: 'admin@socea.local';
    $senha = getenv('SOCEA_ADMIN_SENHA');
    if ($senha === false || strlen($senha) < 8) {
        fwrite(STDERR, "Defina SOCEA_ADMIN_SENHA com pelo menos 8 caracteres.\n");
        exit(1);
    }

    $hash = password_hash($senha, PASSWORD_DEFAULT);
    $admin = db_one('SELECT CodUsuario FROM perfilusuario WHERE Login = ?', [$email]);
    if ($admin !== null) {
        db_exec(
            'UPDATE perfilusuario SET Senha = ?, Funcao = ? WHERE CodUsuario = ?',
            [$hash, 'Admin', (int) $admin['CodUsuario']]
        );
        echo "Senha do administrador {$email} atualizada." . PHP_EOL;
    } else {
        db_insert(
            'INSERT INTO perfilusuario (Login, Senha, Nome, SobreNome, Telefone, CPF, RG, Funcao)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [$email, $hash, 'Administrador', 'SOCEA', '', '', '', 'Admin']
        );
        echo "Administrador {$email} criado." . PHP_EOL;
    }
    exit(0);
}

if (in_array('--demo', $argv, true)) {
    $clientes = (int) $pdo->query('SELECT COUNT(*) FROM perfilcliente')->fetchColumn();
    if ($clientes === 0) {
        $pdo->prepare(
            'INSERT INTO perfilcliente
             (Nome, SobreNome, CPF, Email1, TelContato1, Cidade, UF, Profissao)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        )->execute([
            'Cliente', 'Demonstração', '000.000.000-00',
            'cliente@exemplo.local', '(00) 00000-0000', 'Porto Alegre', 'RS', 'Empresário',
        ]);
        $codCliente = (int) $pdo->lastInsertId();

        $usuarios = db_all("SELECT CodUsuario, Funcao FROM perfilusuario");
        $advogado = null;
        foreach ($usuarios as $usuario) {
            if (in_array($usuario['Funcao'], ['advogado', 'Admin'], true)) {
                $advogado = (int) $usuario['CodUsuario'];
                break;
            }
        }

        $pdo->prepare(
            'INSERT INTO processo
             (CodCliente, NumProcesso, NumeroCNJ, StatusProcessual, AreaAtuacao, Assunto, ObjetoDeAcao)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        )->execute([
            $codCliente, '0001/2026', '0000000-00.0000.0.00.0000',
            'Em andamento', 'Cível', 'Cobrança', 'Cobrança de valores em atraso',
        ]);

        if ($advogado !== null) {
            $pdo->prepare(
                'INSERT INTO Agendamento
                 (AgendamentoDe, Descricao, OutroAgendamento, HrAgendamento, DataAgendamento)
                 VALUES (?, ?, ?, ?, ?)'
            )->execute([
                $advogado, 'Reunião inicial com o cliente', '',
                '14:00', date('Y-m-d', strtotime('+1 day')),
            ]);
        }
    }
    echo 'Dados de demonstração verificados.' . PHP_EOL;
}

foreach (['perfilusuario', 'perfilcliente', 'processo', 'Agendamento', 'anexo'] as $tabela) {
    $total = (int) $pdo->query('SELECT COUNT(*) FROM ' . $tabela)->fetchColumn();
    echo str_pad($tabela, 18) . $total . PHP_EOL;
}
