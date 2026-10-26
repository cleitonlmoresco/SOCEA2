<?php
require_once __DIR__ . '/Seguranca.php';

protegePagina();

exigir_post();
csrf_validar();

$data = post_str('DataAgendamento');
$hora = post_str('HoraAgendamento');
$descricao = post_str('Descricao');

$dataObj = DateTime::createFromFormat('Y-m-d', $data);
$horaObj = DateTime::createFromFormat('H:i', $hora);
if (!$dataObj || $dataObj->format('Y-m-d') !== $data) {
    redirecionar('../Agenda.php?erro=data');
}
if (!$horaObj) {
    $horaObj = DateTime::createFromFormat('H:i:s', $hora);
}
if (!$horaObj) {
    redirecionar('../Agenda.php?erro=hora');
}
if ($descricao === '') {
    redirecionar('../Agenda.php?erro=descricao');
}

$codAdv = (int) ($_SESSION['usuarioID'] ?? 0);
$selecionado = post_str('CodADV');
if ($selecionado !== '') {
    if (ctype_digit($selecionado)) {
        $codAdv = (int) $selecionado;
    } else {
        $partes = explode('.', $selecionado);
        $codAdv = (int) end($partes);
    }
}

$destino = db_one(
    "SELECT CodUsuario FROM perfilusuario
     WHERE CodUsuario = ? AND (Funcao = 'advogado' OR Funcao = 'Admin')",
    [$codAdv]
);
if ($destino === null) {
    redirecionar('../Agenda.php?erro=advogado');
}

db_insert(
    'INSERT INTO Agendamento (AgendamentoDe, Descricao, OutroAgendamento, HrAgendamento, DataAgendamento)
     VALUES (?, ?, ?, ?, ?)',
    [$codAdv, $descricao, '', $horaObj->format('H:i'), $dataObj->format('Y-m-d')]
);

redirecionar('../Agenda.php?ok=1');
