<?php
require_once __DIR__ . '/Seguranca.php';

protegePagina();

exigir_post();
csrf_validar();

$codCliente = get_int('Cl');
if ($codCliente <= 0) {
    http_response_code(400);
    exit('Cliente inválido.');
}

$nome = post_str('nome');
if ($nome === '') {
    redirecionar('../PerfilCliente.php?Cliente=' . $codCliente . '&erro=nome');
}

$dados = [
    'Nome' => $nome,
    'SobreNome' => post_str('sobNome'),
    'Grupo' => post_str('grupo'),
    'Perfil' => post_str('perfil'),
    'Profissao' => post_str('profissao'),
    'CEP' => post_str('CEP'),
    'Endereco' => post_str('Endereco'),
    'Cidade' => post_str('cidade'),
    'UF' => post_str('UF'),
    'CPF' => post_str('CPF'),
    'RG' => post_str('RG'),
    'PIS' => post_str('PIS'),
    'Nascimento' => post_str('nascimento'),
    'Fax' => post_str('fax'),
    'Nacionalidade' => post_str('nacionalidade'),
    'EstadoCivil' => post_str('estCivil'),
    'Bairro' => post_str('bairro'),
    'Email1' => post_str('email1'),
    'Email2' => post_str('email2'),
    'Contato' => post_str('contato'),
    'TelContato1' => post_str('tel1'),
    'TelContato2' => post_str('tel2'),
];

$sets = [];
foreach (array_keys($dados) as $coluna) {
    $sets[] = "`{$coluna}` = ?";
}
$parametros = array_values($dados);
$parametros[] = $codCliente;

db_exec(
    'UPDATE perfilcliente SET ' . implode(', ', $sets) . ' WHERE CodCliente = ?',
    $parametros
);

redirecionar('../PerfilCliente.php?Cliente=' . $codCliente . '&ok=1');
