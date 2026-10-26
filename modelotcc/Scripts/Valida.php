<?php
require_once __DIR__ . '/Seguranca.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    redirecionar(url_login());
}

csrf_validar();

$email = post_str('Email');
$senha = isset($_POST['Senha']) && is_string($_POST['Senha']) ? $_POST['Senha'] : '';

if (validaUsuario($email, $senha)) {
    redirecionar('../Inicio.php');
}

redirecionar(url_login() . '?erro=1');
