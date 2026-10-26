<?php
require_once __DIR__ . '/Seguranca.php';

protegePagina();

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST' || !isset($_POST['enviar'])) {
    redirecionar('../Cliente.php');
}

csrf_validar();

$codProcesso = get_int('cdp');
if ($codProcesso <= 0 || db_one('SELECT 1 FROM processo WHERE codProcesso = ?', [$codProcesso]) === null) {
    http_response_code(400);
    exit('Processo inválido para o upload.');
}

$destinoErro = '../Processo.php?cdp=' . $codProcesso . '&upload=erro';

if (!isset($_FILES['arquivo']) || !is_array($_FILES['arquivo']['name'] ?? null)) {
    redirecionar($destinoErro);
}

$limite = (int) (getenv('SOCEA_UPLOAD_MAX') ?: 10 * 1024 * 1024);
$permitidos = [
    'pdf' => ['application/pdf'],
    'png' => ['image/png'],
    'jpg' => ['image/jpeg'],
    'jpeg' => ['image/jpeg'],
    'txt' => ['text/plain'],
    'doc' => ['application/msword', 'application/x-ole-storage', 'application/CDFV2'],
    'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
    'xls' => ['application/vnd.ms-excel', 'application/x-ole-storage', 'application/CDFV2'],
    'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
    'ppt' => ['application/vnd.ms-powerpoint', 'application/x-ole-storage', 'application/CDFV2'],
    'pptx' => ['application/vnd.openxmlformats-officedocument.presentationml.presentation'],
];

$pasta = socea_upload_dir();

$finfo = new finfo(FILEINFO_MIME_TYPE);
$total = count($_FILES['arquivo']['name']);

for ($i = 0; $i < $total; $i++) {
    $erro = (int) ($_FILES['arquivo']['error'][$i] ?? UPLOAD_ERR_NO_FILE);
    if ($erro === UPLOAD_ERR_NO_FILE) {
        continue;
    }
    if ($erro !== UPLOAD_ERR_OK) {
        redirecionar($destinoErro);
    }

    $nomeOriginal = basename((string) ($_FILES['arquivo']['name'][$i] ?? ''));
    $tmp = (string) ($_FILES['arquivo']['tmp_name'][$i] ?? '');
    $tamanho = (int) ($_FILES['arquivo']['size'][$i] ?? 0);
    $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

    if ($nomeOriginal === '' || !is_uploaded_file($tmp) || $tamanho <= 0 || $tamanho > $limite) {
        redirecionar($destinoErro);
    }
    if (!isset($permitidos[$extensao])) {
        redirecionar($destinoErro);
    }

    $mime = $finfo->file($tmp) ?: '';
    if (!in_array($mime, $permitidos[$extensao], true)) {
        redirecionar($destinoErro);
    }

    $novoNome = bin2hex(random_bytes(16)) . '.' . $extensao;
    $caminho = $pasta . '/' . $novoNome;

    if (!move_uploaded_file($tmp, $caminho)) {
        redirecionar($destinoErro);
    }

    try {
        db_insert(
            'INSERT INTO anexo (nomeArquivo, dataUpload, realNome, codProcesso)
             VALUES (?, ?, ?, ?)',
            [$novoNome, date('Y-m-d H:i:s'), $nomeOriginal, $codProcesso]
        );
    } catch (Throwable $exc) {
        @unlink($caminho);
        error_log('[SOCEA] Falha ao registrar anexo: ' . $exc->getMessage());
        redirecionar($destinoErro);
    }
}

redirecionar('../Processo.php?cdp=' . $codProcesso . '&upload=ok');
