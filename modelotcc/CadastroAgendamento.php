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
<link href="Style.css" rel="stylesheet" type="text/css" />
<script src="jquery-3.1.1.min.js"></script>
</head>
    
    
<body>
   
    <br><br>
      
<div id="templatemo_wrapper">
	 
 <div id="templatemo_header">
    
   		 <!-- end of site_title -->
        
        <div id="templatemo_menu">
            <ul>
                <li><a href="Agenda.php" class="current">Agenda</a></li>
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
    
    
    
    	
<div id="templatemo_wrapper">
	
    
    
     <div id="templatemo_content">
    
    	<div class="col_w620_w2col">
            
            <div class="col_w620_content"> 
                
                <h2>Novo agendamento.</h2>
            
                
            
            <div class="TabControl">
	<div id="header">
		<ul class="abas">
			<li>
				<div class="aba">
					<span>Agendamento com advogado</span>
				</div>
			</li>
			<li>
				<div class="aba">
					<span>Outros Agendamento</span>
				</div>
			</li>
			
		</ul>
	</div>
	<div id="content">
		<div class="conteudo">
             	<form method="POST" action="Scripts/CadastrarAgendamento.php" name="CadastroAgendamento">
                    
                    <span>Data do agendamento</span><br><input type="date" name="DataAgendamento">
                        <br>
                    <span>Hora do agendamento</span><br><input type="time" name="HoraAgendamento"> 
                            <br>
                            
                                <span>Descriçao</span><br><textarea name= "Descricao"  style="width: 450px; height: 130px;" ></textarea>
                            <br>
                    <span>Nome Advogado</span><br>
                        <select name="CodADV">
                           
                        <?php 
                        $query = mysqli_query($conexao, "SELECT * FROM `perfilusuario` WHERE `Funcao` LIKE '%ad%'");
                      
                        while ($row = mysqli_fetch_array($query)) {
                            echo '<option >'.$row['Nome']." ".$row['SobreNome']." .".$row['CodUsuario'].'</option>';
                            
                        }
                        
                        ?>
                        </select>
                    <br>
                        <br>
                    <input type="submit" value="Agendar">     
                </form>
                    
		</div>
		<div class="conteudo">
		
                    <span>*Este agendamento será publicado soente para secretarios.</span>
                           <form method="POST" action="Scripts/CadastrarAgendamento.php" name="CadastrarAgendamento">
                  
                               
                    <span>Agendamento</span><br><input type="text" name="Agendamento">
                            
                            <br>
                    <span>Data do agendamento</span><br><input type="date" name="DataAgendamento">
                        <br>
                    <span>Hora do agendamento</span><br><input type="time" name="HoraAgendamento"> 
                            <br>
                            
                                <span>Descriçao</span><br><textarea name="Descricao"  style="width: 450px; height: 130px;" ></textarea>
                            <br>
                                <input type="submit" value="Agendar">
                        </select>
                    
                    
                </form>
			
		</div>
		
	</div>
</div>
                <style>
                    body{font-family:Calibri, Tahoma, Arial}
	.TabControl{ width:100%; overflow:hidden; height:400px}
	.TabControl #header{ width:100%; border: solid 1px; overflow:hidden; cursor:hand}
	.TabControl #content{ width:100%; border: solid 1px;overflow:hidden; height:100%; }
	.TabControl .abas{display:inline;}
	.TabControl .abas li{float:left}
	.aba{width:100px; height:40px; border:solid 1px; border-radius:5px 5px 0 0;
		text-align:center; padding-top:5px; background:#c6c6c6}
	.ativa{width:100px; height:40px; border:solid 1 px; border-radius:5px 5px 0 0;
		text-align:center; padding-top:5px; background:#dfdfdf;}
	.ativa span, .selected span{color:#31515e   }
	.TabControl #content{background:#dfdfdf}
	.TabControl .conteudo{width:100%;  background:#dfdfdf; display:none; height:100%;color:#97b2b9}
	.selected{width:100px; height:40px; border:solid 1 px; border-radius:5px 5px 0 0;
		text-align:center; padding-top:5px; background:#dfdfdf}

                </style>          
                
<script type="text/javascript">
 	$(document).ready(function(){
 		$("#content div:nth-child(1)").show();
 		$(".abas li:first div").addClass("selected");		
 		$(".aba").click(function(){
 			$(".aba").removeClass("selected");
 			$(this).addClass("selected");
 			var indice = $(this).parent().index();
 			indice++;
 			$("#content div").hide();
 			$("#content div:nth-child("+indice+")").show();
		});
 		
 		$(".aba").hover(
 			function(){$(this).addClass("ativa")},
 			function(){$(this).removeClass("ativa")}
 		);				
 	});
 </script>
            
            </div></div>
        
        
       
    
    	<div class="cleaner"></div>
        
    </div>

    <div id="templatemo_footer">
    <!--Div Rodape do sistema-->
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