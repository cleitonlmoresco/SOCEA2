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
<body>
<br><br>
<div id="templatemo_wrapper">
	
    <div id="templatemo_header">
    
   		<div id="site_title">
            <h1><a href="#">SOCEA</span></a></h1>
        </div> <!-- end of site_title -->
        
        <div id="templatemo_menu">
            <ul>
                <li><a href="Cliente.php" class="current">Cliente</a></li>
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
    
    	<div class="col_w620_w2col">
            
         	<div class="col_w620_content"> 
                    <!-- inicia a div Tabela De letras para pesquisar clientes-->
                    <div class="TabelaLetras">
                    <a href="CadastroCliente.php">Cadastrar Cliente</a><br>
                    <br>
                       <?php $letras = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", 
    "N", "O", "P", "Q", "R", "S", "U", "V", "W", "Y", "X", "Y", "Z");
          $Pesq = '';
         if (isset($_GET["pesquisa"])){
         $Pesq = $_GET["pesquisa"];}             
        $QuerrLinha = mysqli_query($conexao,"SELECT * FROM `perfilcliente` WHERE `Nome` LIKE '".$Pesq."%' ORDER BY `Nome` ASC")or die(mysql_error());
         $RowLinha = mysqli_num_rows($QuerrLinha);

    echo"<table border = '1'><tr>";
//Tabela onde indica as letras para pesquisar
    for ($in = 0;$in<=25;$in++){
             $QuerrNome = mysqli_query($conexao ,"SELECT * FROM `perfilcliente` WHERE `Nome` LIKE '".$letras[$in]."%' ORDER BY `Nome` ASC")or die(mysql_error());
   $RowNome = mysqli_num_rows($QuerrNome);
                  
if($RowNome>0){   
                  echo "<td> <a href = 'Cliente.php?pesquisa={$letras[$in]}'>{$letras[$in]}</td>";
             
    }  else {echo "<td> <p>{$letras[$in]}</p></td>";
        
    }}

echo '</tr></table><br>';
echo '<table border = "1">';
 echo'<tr>';
                echo'<td>';
                echo "Nome";
            
                echo'</td>';
                echo'<td>Telefone';
                echo'</td>' ;
                echo'<td>CPF' ;
                 echo'</td>'     ;
              echo'</tr>';

  while($LinhaNome = mysqli_fetch_array($QuerrLinha)){
          $nome = $LinhaNome['Nome'];
          $Sobnome = $LinhaNome['SobreNome'];
          $Tel = $LinhaNome['TelContato1'];
          $CPF = $LinhaNome['CPF'];
          $link = 'PerfilCliente.php?Cliente='.$LinhaNome['CodCliente'];
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
          echo'</table>' ;
          
                ?>
                    
	            
                        </div>	
    		</div>        
        </div>
        
       	<div class="col_w300 col_last">
		
            
            <form  action="PesquisaCliente.php" method="get">
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