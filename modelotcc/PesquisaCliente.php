<?php require_once __DIR__ . '/Scripts/Seguranca.php'; protegePagina(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SOCEA - Cliente </title>

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
    <?php
$pesquisa = '';
if (isset($_GET['Pesquisa']) && is_string($_GET['Pesquisa'])) {
    $pesquisa = trim($_GET['Pesquisa']);
}

$clientes = [];
if ($pesquisa !== '') {
    $termo = '%' . $pesquisa . '%';
    $clientes = db_all(
        'SELECT * FROM perfilcliente
         WHERE Nome LIKE ? OR SobreNome LIKE ? OR CPF LIKE ?
            OR TelContato1 LIKE ? OR TelContato2 LIKE ?
            OR CAST(CodCliente AS TEXT) LIKE ?
         ORDER BY Nome ASC',
        [$termo, $termo, $termo, $termo, $termo, $termo]
    );
}
?>

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
    
    
    	<div class="col_w620_w2col">
         	<div class="col_w620_content"> 
                    <div class="TabelaLetras">
	            
                <?php
                if ($pesquisa === '') {
                    echo '<p>Digite um nome, CPF, telefone ou código do cliente.</p>';
                } elseif ($clientes === []) {
                    echo '<p>Nenhum cliente encontrado para "' . e($pesquisa) . '".</p>';
                } else {
                    echo '<table border="1">';
                    echo '<tr><td>Nome</td><td>Telefone</td><td>CPF</td></tr>';
                    foreach ($clientes as $cliente) {
                        $link = 'PerfilCliente.php?Cliente=' . (int) $cliente['CodCliente'];
                        echo '<tr><td><a href="' . e($link) . '">'
                            . e($cliente['Nome'] . ' ' . $cliente['SobreNome'])
                            . '</a></td><td>' . e($cliente['TelContato1'])
                            . '</td><td>' . e($cliente['CPF']) . '</td></tr>';
                    }
                    echo '</table>';
                }
                ?>
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
        
            
        <?php render_agenda_menu(); ?>
          
            </div>
    

        </div>
</div>

</body>
</html>