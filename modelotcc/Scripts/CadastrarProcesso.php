<?php
require_once __DIR__ . '/Seguranca.php';

protegePagina();

exigir_post();
csrf_validar();

$codCliente = get_int('codCliente');
if ($codCliente <= 0 || db_one('SELECT 1 FROM perfilcliente WHERE CodCliente = ?', [$codCliente]) === null) {
    http_response_code(400);
    exit('Cliente inválido para o cadastro do processo.');
}

$dados = [
    'CodCliente' => $codCliente,
    'NumProcesso' => post_str('NumProcesso'),
    'Grupo' => post_str('Grupo'),
    'NumeroCNJ' => post_str('NumeroCNJ'),
    'StatusProcessual' => post_str('StatusProcessual'),
    'AreaAtuacao' => post_str('AreaAtuacao'),
    'ObjetoDeAcao' => post_str('ObjetoDeAcao'),
    'Assunto' => post_str('Assunto'),
    'Detalhes' => post_str('Detalhes'),
    'Prognosticos' => post_str('Prognosticos'),
    'CampoLivre1' => post_str('CampoLivre1'),
    'CampoLivre2' => post_str('CampoLivre2'),
    'Pasta' => post_str('Pasta'),
    'Etiqueta' => post_str('Etiqueta'),
    'LocalTramite' => post_str('LocalTramite'),
    'Comarca' => post_str('Comarca'),
    'Fase' => post_str('Fase'),
    'Localizador' => post_str('Localizador'),
    'Responsavel' => post_str('Responsavel'),
    'Parceiro' => post_str('Parceiro'),
    'Origem' => post_str('Origem'),
    'DataContratacao' => post_str('DataContratacao'),
    'DataEncerraqmento' => post_str('DataEncerraqmento'),
    'DataDistribuicao' => post_str('DataDistribuicao'),
    'DataTransitoJulgado' => post_str('DataTransitoJulgado'),
    'DataSetenca' => post_str('DataSetenca'),
    'DataExecucao' => post_str('DataExecucao'),
    'ValorCausa' => post_str('ValorCausa'),
    'OutroValor' => post_str('OutroValor'),
    'Contingencia' => post_str('Contingencia'),
    'Pedido' => post_str('Pedido'),
    'Observacoes' => post_str('Observacoes'),
];

$colunas = array_keys($dados);
$sql = 'INSERT INTO processo (`' . implode('`, `', $colunas) . '`) VALUES ('
    . implode(', ', array_fill(0, count($colunas), '?')) . ')';

db_insert($sql, array_values($dados));

redirecionar('../PerfilCliente.php?Cliente=' . $codCliente . '&ok=processo');
