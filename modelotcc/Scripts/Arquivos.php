<?php
include 'Conexao.php';

$cod = $_GET['cdg'];
$query = mysqli_query($conexao, "SELECT * FROM `anexo` WHERE `codArquivo` = '".$cod."'");
$linha = mysqli_fetch_array($query);
echo $linha['nomeArquivo'];
echo "<iframe src='Arquivos/".$linha['nomeArquivo']."' width='1000' height='600' style='border: none;'></iframe>";
	