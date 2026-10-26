<?php
require_once __DIR__ . '/Seguranca.php';

protegePagina();

exigir_post();
csrf_validar();

$codAgendamento = get_int('ca');
if ($codAgendamento <= 0) {
    http_response_code(400);
    exit('Agendamento inválido.');
}

$agendamento = db_one(
    'SELECT CodAgendamento, AgendamentoDe FROM Agendamento WHERE CodAgendamento = ?',
    [$codAgendamento]
);
if ($agendamento === null) {
    http_response_code(404);
    exit('Agendamento não encontrado.');
}
if (!usuario_admin() && (int) $agendamento['AgendamentoDe'] !== (int) $_SESSION['usuarioID']) {
    http_response_code(403);
    exit('Você não pode alterar este agendamento.');
}

$acao = post_str('Enviar');

if ($acao === 'Excluir' || $acao === 'Excuir') {
    db_exec('DELETE FROM Agendamento WHERE CodAgendamento = ?', [$codAgendamento]);
    redirecionar('../Agenda.php?ok=excluido');
}

$data = post_str('DataAgendamento');
$hora = post_str('HoraAgendamento');
$descricao = post_str('EditarComentario');

$dataObj = DateTime::createFromFormat('Y-m-d', $data);
$horaObj = DateTime::createFromFormat('H:i', $hora);
if (!$horaObj) {
    $horaObj = DateTime::createFromFormat('H:i:s', $hora);
}
if (!$dataObj || $dataObj->format('Y-m-d') !== $data || !$horaObj) {
    redirecionar('../Agenda.php?erro=data');
}

db_exec(
    'UPDATE Agendamento SET Descricao = ?, DataAgendamento = ?, HrAgendamento = ?
     WHERE CodAgendamento = ?',
    [$descricao, $dataObj->format('Y-m-d'), $horaObj->format('H:i'), $codAgendamento]
);

redirecionar('../Agenda.php?ok=alterado');
