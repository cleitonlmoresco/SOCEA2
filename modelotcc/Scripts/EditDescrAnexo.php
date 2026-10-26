<?php
require_once __DIR__ . '/Seguranca.php';

protegePagina();

exigir_post();
csrf_validar();

$codProcesso = get_int('cdp');
$codArquivo = get_int('ca');
$comentario = post_str('EditarComentario');

if ($codProcesso <= 0 || $codArquivo <= 0) {
    http_response_code(400);
    exit('Anexo inválido.');
}

$anexo = db_one(
    'SELECT codArquivo FROM anexo WHERE codArquivo = ? AND codProcesso = ?',
    [$codArquivo, $codProcesso]
);
if ($anexo === null) {
    http_response_code(404);
    exit('Anexo não encontrado.');
}

db_exec('UPDATE anexo SET Descricao = ? WHERE codArquivo = ?', [$comentario, $codArquivo]);

redirecionar('../Processo.php?cdp=' . $codProcesso . '&ok=anexo');
