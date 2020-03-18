.<?php
include('Conexao.php');



 $nome = $_POST['nome'];
 $sobNome = $_POST['sobNome'];
 $nascimento = $_POST['nascimento'];
 $CPF = $_POST['CPF'];
 $RG = $_POST['RG'];
 $estadoCiv = $_POST['estCivil'];
 $endereco= $_POST['Endereco'];
 $bairro= $_POST['bairro'];
 $cidade= $_POST['cidade'];
 $UF= $_POST['UF'];
 $CEP= $_POST['CEP'];
 $tel1= $_POST['tel1'];
 $tel2= $_POST['tel2'];
 $email1= $_POST['email1'];
 $email2= $_POST['email2'];
 $fax= $_POST['fax'];
 $grupo= $_POST['grupo'];
 $nacionalidade= $_POST['nacionalidade'];
 $perfil= $_POST['perfil'];
 $contato= $_POST['contato'];
 $profissao= $_POST['profissao'];
 $PIS= $_POST['PIS'];
$insert = "INSERT INTO `perfilcliente` (`Nome`, `SobreNome`, `Grupo`, `Perfil`, `Profissao`, `CEP`, `Endereco`, `Cidade`, `UF`, `CPF`, `RG`, `PIS`, `Nascimento`, `Fax`, `Nacionalidade`, `EstadoCivil`, `Bairro`, `Email1`, `Email2`, `Contato`, `TelContato1`, `TelContato2`) 
VALUES ('$nome', '$sobNome', '$grupo', '$perfil', '$profissao', '$CEP', '$endereco', '$cidade', '$UF', '$CPF', '$RG', '$PIS', '$nascimento', '$fax', '$nacionalidade', '$estadoCiv', '$bairro', '$email1', '$email2', '$contato', '$tel1', '$tel2')";

$sql = mysqli_query($conexao ,$insert)or die("erro ao inserir dados");


header("Location:http:../Cliente.php ");