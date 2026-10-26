<?php
/**
 * Conexão e helpers de banco do SOCEA.
 *
 * O sistema original dependia de um MySQL remoto com credenciais embutidas no
 * código. Para rodar localmente (e em qualquer ambiente de demonstração) usamos
 * SQLite via PDO, com schema criado automaticamente na primeira execução.
 *
 * Variáveis de ambiente:
 *   SOCEA_DB           caminho do arquivo SQLite (padrão: ../dados/socea.sqlite)
 *   SOCEA_ADMIN_EMAIL  login do administrador inicial
 *   SOCEA_ADMIN_SENHA  senha do administrador inicial (troque depois!)
 */

function socea_db_path(): string
{
    $caminho = getenv('SOCEA_DB');
    if ($caminho === false || trim($caminho) === '') {
        $caminho = __DIR__ . '/../../dados/socea.sqlite';
    }
    return $caminho;
}

/**
 * Diretório de anexos, fora da raiz pública do site.
 * Pode ser trocado por SOCEA_UPLOAD_DIR.
 */
function socea_upload_dir(): string
{
    $dir = getenv('SOCEA_UPLOAD_DIR');
    if ($dir === false || trim($dir) === '') {
        $dir = __DIR__ . '/../../dados/arquivos';
    }
    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
        throw new RuntimeException("Não foi possível criar o diretório de anexos: {$dir}");
    }
    return rtrim(str_replace('\\', '/', $dir), '/');
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $caminho = socea_db_path();
    $diretorio = dirname($caminho);
    if (!is_dir($diretorio) && !mkdir($diretorio, 0775, true) && !is_dir($diretorio)) {
        throw new RuntimeException("Não foi possível criar o diretório do banco: {$diretorio}");
    }

    $pdo = new PDO('sqlite:' . $caminho, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    $pdo->exec('PRAGMA foreign_keys = ON');
    $pdo->exec('PRAGMA journal_mode = WAL');
    $pdo->exec('PRAGMA busy_timeout = 5000');

    garantir_esquema($pdo);
    return $pdo;
}

function esquema_sql(): string
{
    return <<<'SQL'
CREATE TABLE IF NOT EXISTS perfilusuario (
    CodUsuario INTEGER PRIMARY KEY AUTOINCREMENT,
    Login      TEXT NOT NULL UNIQUE,
    Senha      TEXT NOT NULL,
    Nome       TEXT NOT NULL,
    SobreNome  TEXT,
    Telefone   TEXT,
    CPF        TEXT,
    RG         TEXT,
    Funcao     TEXT NOT NULL DEFAULT 'Secretario'
);

CREATE TABLE IF NOT EXISTS perfilcliente (
    CodCliente     INTEGER PRIMARY KEY AUTOINCREMENT,
    Nome           TEXT NOT NULL,
    SobreNome      TEXT,
    Grupo          TEXT,
    Perfil         TEXT,
    Profissao      TEXT,
    CEP            TEXT,
    Endereco       TEXT,
    Cidade         TEXT,
    UF             TEXT,
    CPF            TEXT,
    RG             TEXT,
    PIS            TEXT,
    Nascimento     TEXT,
    Fax            TEXT,
    Nacionalidade  TEXT,
    EstadoCivil    TEXT,
    Bairro         TEXT,
    Email1         TEXT,
    Email2         TEXT,
    Contato        TEXT,
    TelContato1    TEXT,
    TelContato2    TEXT
);

CREATE TABLE IF NOT EXISTS processo (
    codProcesso           INTEGER PRIMARY KEY AUTOINCREMENT,
    CodCliente            INTEGER NOT NULL REFERENCES perfilcliente(CodCliente) ON DELETE CASCADE,
    NumProcesso           TEXT,
    Grupo                 TEXT,
    NumeroCNJ             TEXT,
    StatusProcessual      TEXT,
    AreaAtuacao           TEXT,
    ObjetoDeAcao          TEXT,
    Assunto               TEXT,
    Detalhes              TEXT,
    Prognosticos          TEXT,
    CampoLivre1           TEXT,
    CampoLivre2           TEXT,
    Pasta                 TEXT,
    Etiqueta              TEXT,
    LocalTramite          TEXT,
    Comarca               TEXT,
    Fase                  TEXT,
    Localizador           TEXT,
    Responsavel           TEXT,
    Parceiro              TEXT,
    Origem                TEXT,
    DataContratacao       TEXT,
    DataEncerraqmento     TEXT,
    DataDistribuicao      TEXT,
    DataTransitoJulgado   TEXT,
    DataSetenca           TEXT,
    DataExecucao          TEXT,
    ValorCausa            TEXT,
    OutroValor            TEXT,
    Contingencia          TEXT,
    Pedido                TEXT,
    Observacoes           TEXT
);

CREATE TABLE IF NOT EXISTS Agendamento (
    CodAgendamento   INTEGER PRIMARY KEY AUTOINCREMENT,
    AgendamentoDe    INTEGER NOT NULL REFERENCES perfilusuario(CodUsuario) ON DELETE CASCADE,
    Descricao        TEXT,
    OutroAgendamento TEXT,
    HrAgendamento    TEXT,
    DataAgendamento  TEXT
);

CREATE TABLE IF NOT EXISTS anexo (
    codArquivo   INTEGER PRIMARY KEY AUTOINCREMENT,
    nomeArquivo  TEXT NOT NULL,
    dataUpload   TEXT NOT NULL,
    realNome     TEXT NOT NULL,
    codProcesso  INTEGER NOT NULL REFERENCES processo(codProcesso) ON DELETE CASCADE,
    Descricao    TEXT
);

CREATE INDEX IF NOT EXISTS idx_processo_cliente ON processo(CodCliente);
CREATE INDEX IF NOT EXISTS idx_anexo_processo ON anexo(codProcesso);
CREATE INDEX IF NOT EXISTS idx_agenda_usuario ON Agendamento(AgendamentoDe);
SQL;
}

function garantir_esquema(PDO $pdo): void
{
    $existe = $pdo->query(
        "SELECT 1 FROM sqlite_master WHERE type = 'table' AND name = 'perfilusuario'"
    )->fetchColumn();

    if (!$existe) {
        $pdo->exec(esquema_sql());
    }

    $total = (int) $pdo->query('SELECT COUNT(*) FROM perfilusuario')->fetchColumn();
    if ($total === 0) {
        $email = getenv('SOCEA_ADMIN_EMAIL') ?: 'admin@socea.local';
        $senha = getenv('SOCEA_ADMIN_SENHA') ?: 'Admin@12345';
        $stmt = $pdo->prepare(
            'INSERT INTO perfilusuario (Login, Senha, Nome, SobreNome, Telefone, CPF, RG, Funcao)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $email,
            password_hash($senha, PASSWORD_DEFAULT),
            'Administrador',
            'SOCEA',
            '',
            '',
            '',
            'Admin',
        ]);
        error_log(
            '[SOCEA] Administrador inicial criado. Troque a senha padrão e defina SOCEA_ADMIN_SENHA.'
        );
    }
}

function db_all(string $sql, array $parametros = []): array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($parametros);
    return $stmt->fetchAll();
}

function db_one(string $sql, array $parametros = []): ?array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($parametros);
    $linha = $stmt->fetch();
    return $linha === false ? null : $linha;
}

function db_exec(string $sql, array $parametros = []): int
{
    $stmt = db()->prepare($sql);
    $stmt->execute($parametros);
    return $stmt->rowCount();
}

function db_insert(string $sql, array $parametros = []): int
{
    db_exec($sql, $parametros);
    return (int) db()->lastInsertId();
}

function agenda_do_usuario(int $codUsuario): array
{
    return db_all(
        'SELECT * FROM Agendamento WHERE AgendamentoDe = ?
         ORDER BY DataAgendamento ASC, HrAgendamento ASC',
        [$codUsuario]
    );
}

/** Escapa texto para HTML (evita XSS armazenado). */
function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function post_str(string $chave, string $padrao = ''): string
{
    $valor = $_POST[$chave] ?? $padrao;
    return is_string($valor) ? trim($valor) : $padrao;
}

function get_int(string $chave, int $padrao = 0): int
{
    $valor = filter_input(INPUT_GET, $chave, FILTER_VALIDATE_INT);
    return $valor === false || $valor === null ? $padrao : (int) $valor;
}

function post_int(string $chave, int $padrao = 0): int
{
    $valor = filter_input(INPUT_POST, $chave, FILTER_VALIDATE_INT);
    return $valor === false || $valor === null ? $padrao : (int) $valor;
}

function redirecionar(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/** Lista os próximos agendamentos do usuário logado (menu lateral). */
function render_agenda_menu(): void
{
    $codUsuario = (int) ($_SESSION['usuarioID'] ?? 0);
    $agendamentos = $codUsuario > 0 ? agenda_do_usuario($codUsuario) : [];

    echo '<ul type="circle">';
    if ($agendamentos === []) {
        echo '<li>Nenhum agendamento.</li>';
    }
    foreach ($agendamentos as $agendamento) {
        echo '<li>' . e($agendamento['DataAgendamento']) . ' '
            . e($agendamento['HrAgendamento']) . ' - '
            . e($agendamento['Descricao']) . '</li>';
    }
    echo '</ul>';
}

/**
 * Mensagens de retorno via query string (?ok=... / ?erro=... / ?upload=...).
 * Centraliza o texto para não repetir HTML em cada página.
 */
function render_mensagens(): void
{
    $mapaOk = [
        '1' => 'Operação realizada com sucesso.',
        'cliente' => 'Cliente cadastrado com sucesso.',
        'processo' => 'Processo cadastrado com sucesso.',
        'excluido' => 'Agendamento excluído.',
        'alterado' => 'Agendamento atualizado.',
        'anexo' => 'Anotação do anexo atualizada.',
        'senha' => 'Senha alterada com sucesso.',
    ];
    $mapaErro = [
        '1' => 'E-mail ou senha inválidos.',
        'nome' => 'Informe o nome.',
        'email' => 'Informe um e-mail válido.',
        'senha' => 'A senha deve ter pelo menos 8 caracteres.',
        'senha_atual' => 'Senha atual incorreta.',
        'confirmacao' => 'As senhas não conferem.',
        'duplicado' => 'Já existe um usuário com este e-mail.',
        'data' => 'Data ou hora inválida.',
        'hora' => 'Hora inválida.',
        'descricao' => 'Informe a descrição.',
        'advogado' => 'Advogado inválido.',
    ];
    $mapaUpload = [
        'ok' => ['ok', 'Arquivo(s) enviado(s) com sucesso.'],
        'erro' => ['erro', 'Não foi possível enviar o arquivo. Verifique o formato e o tamanho.'],
    ];

    $ok = isset($_GET['ok']) && is_string($_GET['ok']) ? $_GET['ok'] : '';
    $erro = isset($_GET['erro']) && is_string($_GET['erro']) ? $_GET['erro'] : '';
    $upload = isset($_GET['upload']) && is_string($_GET['upload']) ? $_GET['upload'] : '';

    if ($ok !== '' && isset($mapaOk[$ok])) {
        echo '<div class="aviso aviso-ok">' . e($mapaOk[$ok]) . '</div>';
    }
    if ($erro !== '' && isset($mapaErro[$erro])) {
        echo '<div class="aviso aviso-erro">' . e($mapaErro[$erro]) . '</div>';
    }
    if ($upload !== '' && isset($mapaUpload[$upload])) {
        [$tipo, $texto] = $mapaUpload[$upload];
        echo '<div class="aviso aviso-' . e($tipo) . '">' . e($texto) . '</div>';
    }
}
