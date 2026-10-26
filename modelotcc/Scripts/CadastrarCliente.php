<?php
require_once __DIR__ . '/Seguranca.php';

protegePagina();

exigir_post();
csrf_validar();

$nome = post_str('nome');
if ($nome === '') {
    redirecionar('../Cliente.php?erro=nome');
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

$colunas = array_keys($dados);
$marcadores = array_fill(0, count($colunas), '?');
$sql = 'INSERT INTO perfilcliente (`' . implode('`, `', $colunas) . '`) VALUES ('
    . implode(', ', $marcadores) . ')';

db_insert($sql, array_values($dados));

redirecionar('../Cliente.php?ok=1');
