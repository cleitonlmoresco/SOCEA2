<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SOCEA</title>
<?php include("Scripts/Seguranca.php"); // Inclui o arquivo com o sistema de segurança
		protegePagina(); // Chama a função que protege a página?>
<meta name="keywords" content="" />
<meta name="description" content="" />
<!-- templatemo 329 blue urban -->
<!-- 
Blue Urban Template 
http://www.templatemo.com/preview/templatemo_329_blue_urban
-->
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<script src="jquery-3.1.1.min.js"></script>
<link href="Style.css" rel="stylesheet" type="text/css" />

</head>
<body><br><br>

<div id="templatemo_wrapper">
	
    <div id="templatemo_header">
    
   		<div id="site_title">
            <h1><a href="#">SOCEA</span></a></h1>
        </div> <!-- end of site_title -->
        
        <div id="templatemo_menu">
            <ul>
                <li><a href="Inicio.php" class="current">Inicio</a></li>
                <li><a href="Inicio.php">Inicio</a></li>
                <li><a href="Cliente.php">Cliente</a></li>
                <li><a href="Agenda.php">Agenda</a></li>
                <li><a href="Publicacoes.php">Publicações</a></li>
            </ul>    	
        </div> <!-- end of templatemo_menu -->
    
    </div>
    
    <div id="templatemo_middle">
    
    	<h1>SOCEA</h1>
        <p>Sistema de Organização e Cobrança de 
Escritório de Advocacia.</p>
        
    
    </div>
    
    <div id="templatemo_content">
    
<div class="col_w620_content"> 
                    <div class="TabelaLetras">
    
       
            
                        <h3><center>Cadastrar Cliente.</center></h3>
            <div class="TabelaLetras">	      
            <form method="POST" action="Scripts/CadastrarCliente.php" name="CadastroCliente">
          <table border="1">
            <tbody>
              <tr>
                <td>
                  Nome<br><input name="nome" type="text"><br>
                  Sobre Nome<br><input name="sobNome" type="text"><br>
                  Data de Nascimento <br><input name="nascimento" type="date"><br>
                  CPF <br><input name="CPF" type="text"><br>
                  RG <br><input name="RG" type="text"><br>
                  Estado Civil<br><input name="estCivil" type="text"><br>
                  Endereço <br><input name="Endereco" type="text"><br>
                  Bairro <br><input name="bairro" type="text"><br>
                  Cidade <br><input name="cidade" type="text"><br>
                  UF <br><input name="UF" type="text"><br>
                  CEP <br><input name="CEP" type="text"><br>
                </td>
                <td> Telefone 1 <br><input name="tel1" type="text"><br>
                  Telefone 2<br><input name="tel2" type="text"><br>
                  Email 1<br> <input name="email1" type="text"><br>
                  Email 2<br> <input name="email2" type="text"><br>
                  Fax <br><input name="fax" type="text"><br>
                  Grupo <br><input name="grupo" type="text"><br>
                  Nacionalidade <br><input name="nacionalidade" type="text"><br>
                  Perfil <br><input name="perfil" type="text"><br>
                  Contato <br><input name="contato" type="text"><br>
                  Profissao<br> <input name="profissao" type="text"><br>
                  PIS <br><input name="PIS" type="text"><br><br>
                  <input name="Cadastrar" value="Cadastrar" type="submit">
                </td>
              </tr>
            </tbody>
          </table>
        </form>
            </div></div></div></div>
    
  <div id="templatemo_footer">
    
    	 <?php include 'Scripts/Versao.php'; ?>
    	 <a href="#">SOCEA </a> V. <?php echo $Versao;?>
    </div>
    
          <!--Menu suspenço do topo-->
          <div id ="MenuTopo"><center><table ><tr>
                     <td><h4><a href="#">SOCEA</span></a></h4></td>
             
             <td><img src="images/IconPefil.png" width="25" height="25"><?php echo   $_SESSION["usuarioNome"]?></td>
            <!--Icone da agenda-->         
         
            <td><input type="image"  src="images/Agenda.png" id = "toggleDivAgenda"  width="30" height="35"></td> 
         <!--Icone de escritorio-->
         <?php if($_SESSION['Funcao']=='Admin'){
     echo '<td><input type="image" src="images/IcoEscritorio.png" id="toggleDivEscritorio" width="30" height="35"></td>';
        
     echo '<!--Script toogle div escritorio--> '
     . '<script type="text/javascript">'
             . ' $(document).ready(function(){'
             . '  $("#toggleDivEscritorio").click(toggleDivEscritorio);});'
             . '     
         function toggleDivEscritorio(){'
             . '        $("#MenuSuspEscr").toggle();'
             . '    }</script>'
             . '<div id="MenuSuspEscr" style="display:none"> '
             . '<a href="Cadastro.php">Cadastrar Funcionário</a></div>'; }
?>
        
                    
         
        
      
     
             
        
         <!--Script toogle div Agenda-->
         <script type="text/javascript">
         $(document).ready(function(){
             $("#toggleDivAgenda").click(toggleDivAgenda);
         });
         function toggleDivAgenda(){
             $("#MenuSusAgenda").toggle();
             
         }</script>
             
      
         
    <div id="MenuSusAgenda" style="display:none"> 
        <a href="Agenda.php">Agenda</a> 
        
            
        <ul type="circle">
                 
        <?php 
        $codUsuario = $_SESSION['usuarioID'];
        $queryAgendtable = mysqli_query($conexao,"SELECT * FROM `Agendamento` WHERE `AgendamentoDe` = ".$codUsuario);
        $rowAgenda = mysqli_num_rows($queryAgendtable);
     if($rowAgenda >0){
         while ($linhaAgend =mysqli_fetch_array($queryAgendtable)){
            echo "<li>".$linhaAgend['CodAgendamento']."</li>";
            
     }
         }
        ?> 
        
             </ul>
          
            </div>
    

        </div>
</div>

</body>
</html>