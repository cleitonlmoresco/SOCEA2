<?php
 include('Conexao.php'); 





 
 $email = $_POST['Email'];
 $senha = $_POST['Senha'];
 $ConfSenha = $_POST['ConfSenha'];
 $nome = $_POST['Nome'];
 $sobNome = $_POST['SobNome'];
 $telefone = $_POST['Telefone'];
 $CPF = $_POST['CPF'];
 $RG = $_POST['RG'];
 $Funçao = $_POST['Funcao'];

 $sql = mysqli_query($conexao,"INSERT INTO `perfilusuario` (`Login`, `Senha`, `Nome`, `SobreNome`, `Telefone`, `CPF`, `RG`, `Funcao`) VALUES"
         . "('$email', '$senha', '$nome', '$sobNome', '$telefone', '$CPF', '$RG', '$Funçao');")or die("INSERT INTO `perfilcliente` (`Login`, `Senha`, `Nome`, `SobreNome`, `Telefone`, `CPF`, `RG`, `Funcao`) 
 VALUES ('$email', '$senha', '$nome', '$sobNome', '$telefone', '$CPF', '$RG', '$Funçao');");

 echo('<p>cadastro efetuado com sucesso</p>');

 header("Location:http:../index.php ");
 ?>
