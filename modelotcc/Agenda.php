<?php require_once __DIR__ . '/Scripts/Seguranca.php'; protegePagina(); ?>
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
                                    
                                    
        <?php render_mensagens(); ?>
        <?php
        $codUsuario = (int) $_SESSION['usuarioID'];
        $agendamentos = agenda_do_usuario($codUsuario);

        if ($agendamentos === []) {
            echo '<tr><td colspan="3">Nenhum agendamento disponível.</td></tr>';
        }

        foreach ($agendamentos as $linhaAgend) {
            $cod = (int) $linhaAgend['CodAgendamento'];
            $data = e($linhaAgend['DataAgendamento']);
            $hora = e($linhaAgend['HrAgendamento']);
            $descricao = e($linhaAgend['Descricao']);

            echo '<tr><td>' . $data . ' ' . $hora . '</td>'
                . '<td>' . $descricao . '</td>'
                . '<td><input type="image" src="images/Anotaçoes.png" title="Anotações" '
                . 'id="MostrarJconfAgenda' . $cod . '" width="30" height="35"></td></tr>';

            echo '<tr><td colspan="3"><div id="EditConfAgenda' . $cod . '" style="display:none">'
                . '<div id="JEditComent">'
                . '<input type="image" src="images/fechar.png" title="Fechar" '
                . 'id="FecharJconfAgenda' . $cod . '" width="60" height="40">'
                . '<form id="EditComentario' . $cod . '" action="Scripts/EditConfAgenda.php?ca=' . $cod . '" method="post">'
                . csrf_input()
                . '<span>Descrição</span><br><textarea name="EditarComentario" cols="40" rows="5">' . $descricao . '</textarea><br>'
                . '<span>Data do agendamento</span><br><input type="date" value="' . $data . '" name="DataAgendamento"><br>'
                . '<span>Hora do agendamento</span><br><input type="time" value="' . $hora . '" name="HoraAgendamento"><br>'
                . '<input type="submit" name="Enviar" value="Alterar">'
                . '<input type="submit" name="Enviar" value="Excluir">'
                . '</form></div></div></td></tr>';

            echo '<script type="text/javascript">'
                . '$(document).ready(function(){'
                . '$("#MostrarJconfAgenda' . $cod . '").click(function(){$("#EditConfAgenda' . $cod . '").show();});'
                . '$("#FecharJconfAgenda' . $cod . '").click(function(){$("#EditConfAgenda' . $cod . '").hide();});'
                . '});</script>';
        }
        ?>
        </table></div></div>
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
        
            
        <?php render_agenda_menu(); ?>
          
            </div>
    

        </div>
    </div>
    
</div>

</body>
</html>