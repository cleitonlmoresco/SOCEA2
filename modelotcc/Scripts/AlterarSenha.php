<?php
require_once __DIR__ . '/Seguranca.php';

exigir_post();
csrf_validar();
protegePagina();

$atual = isset($_POST['SenhaAtual']) && is_string($_POST['SenhaAtual']) ? $_POST['SenhaAtual'] : '';
$nova = isset($_POST['NovaSenha']) && is_string($_POST['NovaSenha']) ? $_POST['NovaSenha'] : '';
$confirmacao = isset($_POST['ConfNovaSenha']) && is_string($_POST['ConfNovaSenha']) ? $_POST['ConfNovaSenha'] : '';

$usuario = db_one(
    'SELECT CodUsuario, Senha FROM perfilusuario WHERE CodUsuario = ?',
    [(int) $_SESSION['usuarioID']]
);

if ($usuario === null || !password_verify($atual, (string) $usuario['Senha'])) {
    redirecionar('../RecuperarSenha.php?erro=senha_atual');
}
if (strlen($nova) < 8) {
    redirecionar('../RecuperarSenha.php?erro=senha');
}
if (!hash_equals($nova, $confirmacao)) {
    redirecionar('../RecuperarSenha.php?erro=confirmacao');
}

db_exec(
    'UPDATE perfilusuario SET Senha = ? WHERE CodUsuario = ?',
    [password_hash($nova, PASSWORD_DEFAULT), (int) $usuario['CodUsuario']]
);

redirecionar('../RecuperarSenha.php?ok=senha');
