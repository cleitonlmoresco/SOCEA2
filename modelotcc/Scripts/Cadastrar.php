<?php
require_once __DIR__ . '/Seguranca.php';

exigir_post();
csrf_validar();
exigir_admin();

$email = post_str('Email');
$senha = isset($_POST['Senha']) && is_string($_POST['Senha']) ? $_POST['Senha'] : '';
$confirmacao = isset($_POST['ConfSenha']) && is_string($_POST['ConfSenha']) ? $_POST['ConfSenha'] : '';
$nome = post_str('Nome');
$sobrenome = post_str('SobNome');
$telefone = post_str('Telefone');
$cpf = post_str('CPF');
$rg = post_str('RG');
$funcao = post_str('Funcao');

$funcoes_validas = ['Admin', 'advogado', 'Secretario'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirecionar('../Cadastro.php?erro=email');
}
if (strlen($senha) < 8) {
    redirecionar('../Cadastro.php?erro=senha');
}
if (!hash_equals($senha, $confirmacao)) {
    redirecionar('../Cadastro.php?erro=confirmacao');
}
if ($nome === '') {
    redirecionar('../Cadastro.php?erro=nome');
}
if (!in_array($funcao, $funcoes_validas, true)) {
    $funcao = 'Secretario';
}
if (db_one('SELECT 1 FROM perfilusuario WHERE Login = ?', [$email]) !== null) {
    redirecionar('../Cadastro.php?erro=duplicado');
}

db_insert(
    'INSERT INTO perfilusuario (Login, Senha, Nome, SobreNome, Telefone, CPF, RG, Funcao)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
    [
        $email,
        password_hash($senha, PASSWORD_DEFAULT),
        $nome,
        $sobrenome,
        $telefone,
        $cpf,
        $rg,
        $funcao,
    ]
);

redirecionar('../Cadastro.php?ok=1');
