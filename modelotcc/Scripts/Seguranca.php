<?php
/**
 * Autenticação, sessão e proteções HTTP do SOCEA.
 *
 * Correções em relação ao original:
 * - não guarda a senha na sessão;
 * - usa password_verify/password_hash (com migração de senhas antigas);
 * - regenera o ID da sessão no login (session fixation);
 * - cookie HttpOnly/SameSite e timeout por inatividade;
 * - CSRF nos formulários e endpoints de escrita;
 * - redirecionamento de login correto para páginas da raiz e de Scripts/.
 */

require_once __DIR__ . '/Conexao.php';

const SOCEA_SESSAO_NOME = 'SOCEASESSID';
const SOCEA_SESSAO_TIMEOUT = 7200; // 2 horas

function iniciar_sessao(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['SERVER_PORT'] ?? '') === '443');

    if (!headers_sent()) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $https,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: same-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
        header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; "
            . "style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline'; "
            . "object-src 'none'; base-uri 'self'; form-action 'self'");
        if ($https) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }

    ini_set('session.use_strict_mode', '1');
    session_name(SOCEA_SESSAO_NOME);
    session_start();
}

iniciar_sessao();

function url_login(): string
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    return str_contains($script, '/Scripts/') ? '../index.php' : 'index.php';
}

function validaUsuario(string $email, string $senha): bool
{
    $email = trim($email);
    if ($email === '' || $senha === '' || strlen($email) > 190 || strlen($senha) > 4096) {
        return false;
    }

    $usuario = db_one(
        'SELECT CodUsuario, Login, Senha, Nome, Funcao
         FROM perfilusuario WHERE Login = ? LIMIT 1',
        [$email]
    );
    if ($usuario === null) {
        return false;
    }

    $hash = (string) $usuario['Senha'];
    $valido = password_verify($senha, $hash);

    // Compatibilidade com a base antiga, que guardava a senha em texto puro.
    // Após o primeiro login bem-sucedido o hash é atualizado.
    if (!$valido && $hash !== '' && $hash[0] !== '$' && hash_equals($hash, $senha)) {
        $valido = true;
        db_exec(
            'UPDATE perfilusuario SET Senha = ? WHERE CodUsuario = ?',
            [password_hash($senha, PASSWORD_DEFAULT), (int) $usuario['CodUsuario']]
        );
    } elseif ($valido && password_needs_rehash($hash, PASSWORD_DEFAULT)) {
        db_exec(
            'UPDATE perfilusuario SET Senha = ? WHERE CodUsuario = ?',
            [password_hash($senha, PASSWORD_DEFAULT), (int) $usuario['CodUsuario']]
        );
    }

    if (!$valido) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['usuarioID'] = (int) $usuario['CodUsuario'];
    $_SESSION['usuarioNome'] = $usuario['Nome'];
    $_SESSION['Funcao'] = $usuario['Funcao'];
    $_SESSION['usuarioLogin'] = $usuario['Login'];
    $_SESSION['ultimo_acesso'] = time();
    return true;
}

function protegePagina(): void
{
    if (empty($_SESSION['usuarioID'])) {
        expulsaVisitante();
    }

    $agora = time();
    if (!empty($_SESSION['ultimo_acesso'])
        && ($agora - (int) $_SESSION['ultimo_acesso']) > SOCEA_SESSAO_TIMEOUT) {
        expulsaVisitante();
    }

    $usuario = db_one(
        'SELECT CodUsuario, Login, Nome, Funcao FROM perfilusuario WHERE CodUsuario = ? LIMIT 1',
        [(int) $_SESSION['usuarioID']]
    );
    if ($usuario === null) {
        expulsaVisitante();
    }

    $_SESSION['usuarioNome'] = $usuario['Nome'];
    $_SESSION['Funcao'] = $usuario['Funcao'];
    $_SESSION['usuarioLogin'] = $usuario['Login'];
    $_SESSION['ultimo_acesso'] = $agora;
}

function expulsaVisitante(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    redirecionar(url_login());
}

function usuario_logado(): ?array
{
    if (empty($_SESSION['usuarioID'])) {
        return null;
    }
    return [
        'id' => (int) $_SESSION['usuarioID'],
        'nome' => $_SESSION['usuarioNome'] ?? '',
        'login' => $_SESSION['usuarioLogin'] ?? '',
        'funcao' => $_SESSION['Funcao'] ?? '',
    ];
}

function usuario_admin(): bool
{
    return ($_SESSION['Funcao'] ?? '') === 'Admin';
}

function exigir_admin(): void
{
    protegePagina();
    if (!usuario_admin()) {
        http_response_code(403);
        exit('Acesso restrito ao administrador.');
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_input(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_validar(): void
{
    $enviado = $_POST['csrf_token'] ?? '';
    $sessao = $_SESSION['csrf_token'] ?? '';
    if (!is_string($enviado) || $sessao === '' || !hash_equals($sessao, $enviado)) {
        http_response_code(403);
        exit('Sessão expirada ou token de segurança inválido. Recarregue a página.');
    }
}

function exigir_post(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        http_response_code(405);
        header('Allow: POST');
        exit('Método não permitido.');
    }
}
