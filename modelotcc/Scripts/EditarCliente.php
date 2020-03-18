<?php


include('Conexao.php');


 $codCliente = $_GET['Cl'];
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
$insert = "UPDATE `perfilcliente` SET `Nome` = '".$nome."', `Grupo` = '".$grupo."', "
        . "`Perfil` = '".$perfil."', `Profissao` = '".$profissao."', `CEP` = '".$CEP."', "
        . "`Endereco` = '".$endereco."', `Cidade` = '".$cidade."', `UF` = '".$UF."', "
        . "`CPF` = '".$CPF."', `RG` = '".$RG."', `PIS` = '".$PIS."', `"
        . "Nascimento` = '".$nascimento."', `Fax` = '".$fax."', `Nacionalidade` = '".$nacionalidade."',"
        . " `Contato` = '".$contato."', `TelContato1` = '".$tel1."', `TelContato2` = '".$tel2."' "
        . "WHERE `perfilcliente`.`CodCliente` = ".$codCliente."; ";

$sql = mysqli_query($conexao ,$insert)or die("erro ao inserir dados");
header("Location: ".'../PerfilCliente.php?Cliente='.$codCliente);
