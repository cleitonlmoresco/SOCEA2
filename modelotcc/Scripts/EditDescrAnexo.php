<?php
include('Conexao.php');

$codProcesso = $_GET["cdp"];
$CodArq=$_GET["ca"];
$comentario = $_POST["EditarComentario"];
$insert = "UPDATE `anexo` SET `Descricao` = '".$comentario."' WHERE `anexo`.`codArquivo` = ".$CodArq.";";
$sql = mysqli_query($conexao ,$insert)or die("erro ao inserir dados");
header("Location:http:../Processo.php?cdp=".$codProcesso);