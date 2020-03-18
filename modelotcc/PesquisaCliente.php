<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SOCEA - Cliente </title>
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
    <?php #puxa a conexao  com o banco de dados
 include('Scripts/Conexao.php');
 
 
#Pesquisa no banco de dados o nome , sobre nome, CPF ou Numero de telefone do cliente
$Pesquisas = $_GET['Pesquisa'];
$Pesquisador = "SELECT * FROM `$banco`.`perfilcliente` WHERE (CONVERT(`Nome` USING utf8) LIKE '%$Pesquisas%'
OR CONVERT(`SobreNome` USING utf8) LIKE '%$Pesquisas%' OR CONVERT(`CPF` USING utf8) LIKE '%$Pesquisas%'
OR CONVERT(`TelContato1` USING utf8) LIKE '%$Pesquisas%' OR CONVERT(`TelContato2` USING utf8) LIKE '%$Pesquisas%' 
OR CONVERT(`CodCliente` USING utf8) LIKE '%$Pesquisas%')";

#envia os comando a ser pesquisado para o banco de  dados
$Querry = mysqli_query($conexao,$Pesquisador) or die(mysql_error());

#conta quantos resultados teve na pesquisa
$Row = mysqli_num_rows($Querry);
?>

<div id="templatemo_wrapper">
	
    <div id="templatemo_header">
    
   		<div id="site_title">
            <h1><a href="#">SOCEA</span></a></h1>
        </div> <!-- end of site_title -->
        
        <div id="templatemo_menu">
            <ul>
                <li><a href="Cliente.php.php" class="current">Cliente</a></li>
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
    
    
    	<div class="col_w620_w2col">
         	<div class="col_w620_content"> 
                    <div class="TabelaLetras">
	            
                <?php
          #Valida os resultados e imprime echo $Pesquisa;
          if($Row> 0){
              echo  "<table border='1'";
              echo'<tr>';
                echo'<td>';
               
                echo "Nome";
                
                echo'</td>';
                echo'<td>Telefone';
                echo'</td>' ;
                echo'<td>CPF';
                 echo'</td>'     ;
              echo'</tr>';
              
              
              
              
           while($linha = mysqli_fetch_array($Querry)){
          $nome = $linha['Nome'];
          $Sobnome = $linha['SobreNome'];
          $Tel = $linha['TelContato1'];
          $CPF = $linha['CPF'];
          $link = 'PerfilCliente.php?Cliente='.$linha['CodCliente'];

          

              echo'<tr>';
                echo'<td>';
                echo "<a href='{$link}'>";
                echo $nome.' '.$Sobnome;
                echo'</a>';
                echo'</td>';
                echo'<td>'.$Tel;
                echo'</td>' ;
                echo'<td>'.$CPF ;
                 echo'</td>'     ;
              echo'</tr>';
           }
          echo'</table>' ;}
        ?> 		</div>
    		</div>        
        </div>
        
       	<div class="col_w300 col_last">
		
            
            <form  action="PesquisaCliente.html" method="get">
            <input autocomplete="on" value="Pesquisa" name="Pesquisa" type="search">
            <input name="Pesquisar" value="Pesquisar" type="submit"> </form>	
        </div>
    
    	<div class="cleaner"></div>
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