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
    
    
    <body><br><br>
   
    
      
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
                    
                    
                    <div class="TabelaLetras">  
                        
                                <table border="1"><tr>
                                        <td><h3><a href="CadastroAgendamento.php">Novo agendamento</a></h3></td>
                           
                                        <td colspan="2"> <form  action="PesquisaCliente.php" method="get">
            <input autocomplete="on" value="Pesquisa" name="Pesquisa" type="search">
            <input name="Pesquisar" value="Pesquisar" type="submit"> </form></td>
                                    </tr>
                                    <tr><th colspan="2">Seus Agendamentos</th></tr>
                                    <tr>
                                        
                                        <th>Data e hora</th>
                                        <th>Descrição</th>
                                    </tr>
                                    <script type="text/javascript">
$(document).ready(function(){
   $("#btn-apagar").click( function(event) {
      var apagar = confirm('Deseja realmente excluir este agendamento?');
      if (apagar){
	// aqui vai a instrução para apagar registro			
      }else{
         event.preventDefault();
      }	
   });
});
</script>
                                    
                                    
        <?php
        
         if($_SESSION['Funcao']=='Admin'||$_SESSION['Funcao']=='advogado'){
        $codUsuario = $_SESSION['usuarioID'];
        
        $queryAgendtable = mysqli_query($conexao,"SELECT * FROM `Agendamento` WHERE `AgendamentoDe` = ".$codUsuario);
        $rowAgenda = mysqli_num_rows($queryAgendtable);
     if($rowAgenda >0){
         while ($linhaAgend =mysqli_fetch_array($queryAgendtable)){
           
            echo '<tr><td>'.$linhaAgend['DataAgendamento'].' '.$linhaAgend['HrAgendamento'].'</td>'
                    . '<td>'.$linhaAgend['Descricao'].'</td>';
         
                    echo '<td><input type="image"  src="images/Anotaçoes.png" title= "Anoteções." id = "MostrarJconfAgenda'.$linhaAgend['CodAgendamento'].'"  width="30" height="35"></td>';
            
            echo '<script type="text/javascript">'
             . ' $(document).ready(function(){'
         
             . '  $("#MostrarJconfAgenda'.$linhaAgend['CodAgendamento'].'").click(MostrarJconfAgenda'.$linhaAgend['CodAgendamento'].');'
           
             . ' $("#FecharJconfAgenda'.$linhaAgend['CodAgendamento'].'").click(FecharJconfAgenda'.$linhaAgend['CodAgendamento'].');});'
             
       . ' function MostrarJconfAgenda'.$linhaAgend['CodAgendamento'].'(){'
             . '        $("#EditConfAgenda'.$linhaAgend['CodAgendamento'].'").show();'
                    
             . '    }'
        . 'function FecharJconfAgenda'.$linhaAgend['CodAgendamento'].'(){'
             . '        $("#EditConfAgenda'.$linhaAgend['CodAgendamento'].'").hide();'
                    
             . '    }</script>'//Fim Script
        //Janela ediçao  de anotaçoes
             . '<div id="EditConfAgenda'.$linhaAgend['CodAgendamento'].'" style="display:none">'
        . '<div id="JEditComent">'
          . '<input type="image"  src="images/fechar.png" title= "Anoteções." id = "FecharJconfAgenda'.$linhaAgend['CodAgendamento'].'"  width="60" height="40"></td>'
        
        . "<form id = 'EditComentario' action = 'Scripts/EditConfAgenda.php?ca=".$linhaAgend['CodAgendamento']."' method = 'post'>"
       . '<span>Descrição</span><br><textarea name = "EditarComentario" cols="40" rows="5" >'.$linhaAgend['Descricao'].'</textarea>'
           
                           .' <br>'
                   .' <span>Data do agendamento</span><br><input type="date" value="'.$linhaAgend['DataAgendamento'].'" name="DataAgendamento">'
                        .'<br>'
                    .'<span>Hora do agendamento</span><br><input type="time" value = "'.$linhaAgend['HrAgendamento'].'" name="HoraAgendamento">' 
                            .'<br>'
                            
                                  . '<input type="submit" name="Enviar" value="Alterar">'
                    . '<input type="submit" name="Enviar" value="Excuir" />'
        . '</form>'
        . '</div></div></tr>';        
            
            
            
            
            
                    echo '</tr>';
     }
         } else {
             echo '<tr><td colspan="3">Nenhum Agndamento Disponivel.</td></tr>';
        }}
                
         ?></table></div></div>
        </div>
         <div class="col_w300">
            
             <br> 
        </div>
    
    	<div class="cleaner"></div>
        
    </div>

    <div id="templatemo_footer">
    <!--Div Rodape do sistema-->
    	<?php include 'Scripts/Versao.php'; ?>
    	 <a href="#">SOCEA </a> V. <?php echo $Versao;?>
         
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
    
</div>

</body>
</html>