<?php
require_once __DIR__ . '/Seguranca.php';

protegePagina();

$codArquivo = get_int('cdg');
if ($codArquivo <= 0) {
    http_response_code(400);
    exit('Arquivo inválido.');
}

$anexo = db_one('SELECT * FROM anexo WHERE codArquivo = ?', [$codArquivo]);
if ($anexo === null) {
    http_response_code(404);
    exit('Arquivo não encontrado.');
}

$nomeArmazenado = basename((string) $anexo['nomeArquivo']);
$caminho = socea_upload_dir() . '/' . $nomeArmazenado;
if (!is_file($caminho)) {
    http_response_code(404);
    exit('Arquivo não encontrado no armazenamento.');
}

$extensao = strtolower(pathinfo($nomeArmazenado, PATHINFO_EXTENSION));
$inline = in_array($extensao, ['pdf', 'png', 'jpg', 'jpeg', 'txt'], true);
$disposicao = $inline ? 'inline' : 'attachment';

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($caminho) ?: 'application/octet-stream';

$nome = str_replace(["\r", "\n", '"'], '', basename((string) $anexo['realNome']));
if ($nome === '') {
    $nome = $nomeArmazenado;
}
$nomeAscii = preg_replace('/[^A-Za-z0-9._-]/', '_', $nome) ?: 'arquivo';

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($caminho));
header(
    'Content-Disposition: ' . $disposicao
    . '; filename="' . $nomeAscii . '"'
    . "; filename*=UTF-8''" . rawurlencode($nome)
);
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-store');
readfile($caminho);
