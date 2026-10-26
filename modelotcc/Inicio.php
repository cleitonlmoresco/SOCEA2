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
<body>
  <br><br>
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
    
    	<div class="col_w620_w2col">
            <?php
            render_mensagens();

            $totalClientes = (int) db_one('SELECT COUNT(*) AS total FROM perfilcliente')['total'];
            $totalProcessos = (int) db_one('SELECT COUNT(*) AS total FROM processo')['total'];
            $totalAgendamentos = (int) db_one(
                'SELECT COUNT(*) AS total FROM Agendamento WHERE AgendamentoDe = ?',
                [(int) $_SESSION['usuarioID']]
            )['total'];
            $proximos = db_all(
                'SELECT DataAgendamento, HrAgendamento, Descricao FROM Agendamento
                 WHERE AgendamentoDe = ? AND DataAgendamento >= ?
                 ORDER BY DataAgendamento ASC, HrAgendamento ASC LIMIT 5',
                [(int) $_SESSION['usuarioID'], date('Y-m-d')]
            );
            ?>
            <div class="TextoInicio">
                <h3>Bem-vindo(a), <?php echo e($_SESSION['usuarioNome']); ?>.</h3>
                <span>Painel rápido do escritório.</span>
            </div>

            <div class="painel">
                <div class="cartao">
                    <span class="numero"><?php echo $totalClientes; ?></span>
                    <span class="rotulo">Clientes</span>
                </div>
                <div class="cartao">
                    <span class="numero"><?php echo $totalProcessos; ?></span>
                    <span class="rotulo">Processos</span>
                </div>
                <div class="cartao">
                    <span class="numero"><?php echo $totalAgendamentos; ?></span>
                    <span class="rotulo">Seus agendamentos</span>
                </div>
            </div>

            <h3>Próximos compromissos</h3>
            <?php if ($proximos === []): ?>
                <p>Nenhum compromisso futuro. <a href="CadastroAgendamento.php">Criar agendamento</a>.</p>
            <?php else: ?>
                <table border="1">
                    <tr><th>Data</th><th>Hora</th><th>Descrição</th></tr>
                    <?php foreach ($proximos as $compromisso): ?>
                        <tr>
                            <td><?php echo e($compromisso['DataAgendamento']); ?></td>
                            <td><?php echo e($compromisso['HrAgendamento']); ?></td>
                            <td><?php echo e($compromisso['Descricao']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    
        
        
        <div class="col_w300 col_last">
            <h3>Atalhos</h3>
            <ul>
                <li><a href="CadastroCliente.php">Cadastrar cliente</a></li>
                <li><a href="CadastroAgendamento.php">Novo agendamento</a></li>
                <li><a href="Cliente.php">Consultar clientes</a></li>
                <li><a href="RecuperarSenha.php">Alterar minha senha</a></li>
            </ul>
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
        
            
        <?php render_agenda_menu(); ?>
          
            </div>
    

        </div>
</div>

    
</body>
</html>