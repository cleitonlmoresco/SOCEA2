<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SOCEA</title>
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
<?php include("Scripts/Seguranca.php"); // Inclui o arquivo com o sistema de segurança
		protegePagina(); // Chama a função que protege a página?>

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
        </div> 
    
    </div>
    
    <div id="templatemo_middle">
    
    	<h1>SOCEA</h1>
        <p>Sistema de Organização e Cobrança de 
Escritório de Advocacia.</p>
        
    
    </div>
    
    <div id="templatemo_content">
    
    	<div class="col_w300">
		
            
            <div class="image_wrapper"></div>
          	
               
                    
        </div>
    
        <div class="col_w300">
            <h3>Cadastro de Usuario</h3>
            <br>
		
            <form id="Cadastro" name="Cadastro" method="post" action="Scripts/Cadastrar.php" onsubmit="return validaCampo(this); ">

           <table width="625" border="0">
    <tr>
      <td width="69">
          E-mail</td>
      <td width="546"><input name="Email" id='Email' type="text">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>Senha</td>
      <td><input name="Senha" id="Senha" type="password">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>confirma senha:</td>
      <td><input name="ConfSenha" id="ConfSenha" type="password">

   
      <span class="style1">*</span>
    </tr>
    <tr>
      <td>nome:</td>
      <td><input name="Nome" id="Nome" type="text">
                 <span class="style1">*</span> </td>
         </tr>
       <tr>
           <td>sobre nome</td>
           <td><input name="SobNome" id="SobNome" type="text">
                   <span class="style1">*</span> </td>
         
    </tr>
    <tr>
      <td>telefone</td>
      <td><input name="Telefone" id="Telefone" type="text">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>CPF</td>
      <td><input name="CPF" id="CPF" type="text">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td> RG</td>
      <td><input name="RG" id="RG" type="text">
        <span class="style1">*      </span></td>
    </tr>
    <tr>
      <td>Função</td>
      <td>
          <select id="Funcao">
              <option name = 'Secretario'>Secretario</option>
              <option name = 'advogado'>Advogado</option>
              <option name = 'Admin'>Advogado/Administrador</option>
          </select>
          </td>
    </tr>

    <tr>
      <td colspan="2"><p>
              Campos com * são obrigatórios!<br>
        <input value="Cadastrar" name="Cadastrar" type="submit">


         

          <span class="style1">           </span></p>
      <p>  </p></td>
       
    </tr>
  </table>
               
                
                <br><br>
  
  <script type="text/javascript" language="javascript">
function validaCampo (){
if(document.getElementById("Email").value.length < 3){
alert('Por favor, preencha o campo  E-mail');
document.getElementById("Email").focus();
return false
} else
if(document.getElementById("Senha").value.length < 3){
alert('Por favor, preencha o campo Senha');
document.getElementById("Senha").focus();
return false
}
else
if(document.getElementById("ConfSenha").value.length < 3){
alert('Por favor, preencha o campo confirma senha');
document.getElementById("ConfSenha").focus();
return false
}
else
if(document.getElementById("Nome").value.length < 3){
alert('Por favor, preencha o campo nome');
document.getElementById("Nome").focus();
return false
}
else
if(document.getElementById("SobNome").value.length < 3){
alert('Por favor, preencha o campo sobre nome');
document.getElementById("SobNome").focus();
return false
}else
if(document.getElementById("Telefone").value.length < 3){
alert('Por favor, preencha o campo Telefone');
document.getElementById("Telefone").focus();
return false
}else
if(document.getElementById("CPF").value.length < 3){
alert('Por favor, preencha o campo CPF');
document.getElementById("CPF").focus();
return false
}else
if(document.getElementById("RG").value.length < 3){
alert('Por favor, preencha o campo RG');
document.getElementById("RG").focus();
return false
}else
if(document.getElementById("Funcao").value.length < 3){
alert('Por favor, preencha o campo Fun�ao');
document.getElementById("Funcao").focus();
return false
}
}
</script>
                  </form>
			
            <div class="cleaner"></div>
	</div><div class="cleaner"></div>
    </div>
    
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