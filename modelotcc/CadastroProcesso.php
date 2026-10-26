<?php
require_once __DIR__ . '/Scripts/Seguranca.php';
protegePagina();

$codCliente = get_int('codCliente');
$cliente = $codCliente > 0
    ? db_one('SELECT CodCliente, Nome, SobreNome FROM perfilcliente WHERE CodCliente = ?', [$codCliente])
    : null;

if ($cliente === null) {
    http_response_code(404);
    exit('Cliente não encontrado.');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SOCEA</title>

<meta name="keywords" content="" />
<meta name="description" content="" />
<!-- templatemo 329 blue urban -->
<!-- 
Blue Urban Template 
http://www.templatemo.com/preview/templatemo_329_blue_urban
-->
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<script src="jquery-3.7.1.min.js"></script>
<link href="Style.css" rel="stylesheet" type="text/css" />

</head>
<body><br><br>

<div id="templatemo_wrapper">
	
    <div id="templatemo_header">
    
   		<div id="site_title">
            <h1><a href="#">SOCEA</a></h1>
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
    
    	<div class="col_w620_content"> 
                    <div class="TabelaLetras">
            
          	      
            <h3>Cadastrar Processo</h3>
            <p>
                Cliente:
                <a href="PerfilCliente.php?Cliente=<?php echo (int) $codCliente; ?>">
                    <?php echo e($cliente['Nome'] . ' ' . $cliente['SobreNome']); ?>
                </a>
            </p>
            <?php render_mensagens(); ?>
            <form method="POST" action="Scripts/CadastrarProcesso.php?codCliente=<?php echo (int) $codCliente; ?>" name="CadastroProcesso">
                <?php echo csrf_input(); ?>
          <table border="1" width="100%">
            <tbody>
              <tr>
                  
              
                <td style="margin-left: 164px;">
                    Numero do Processo<br><input name="NumProcesso" type="text"><br>
                  Numero do CNJ<br><input name="NumeroCNJ" type="text"><br>
                  Status Processual <br><input name="StatusProcessual" type="text"><br>
                  Area de atuação<br> <input name="AreaAtuacao" type="text"><br>
                  Objeto de ação <br><input name="ObjetoDeAcao" type="text"><br>
                  Assunto<br><input name="Assunto" type="text"><br>
                  Grupo<br><input name="Grupo" type="text"><br>
                  Detalhes<br> <input name="Detalhes" type="text"><br>
                  Prognosticos<br> <input name="Prognosticos" type="text"><br>
                  Campo Livre 1 <br><input name="CampoLivre1" type="text"><br>
                  Campo Livre 2 <br><input name="CampoLivre2" type="text"><br>
                  Pasta <br><input name="Pasta" type="text"><br>
                  Etiqueta <br><input name="Etiqueta" type="text"><br>
                  Local de Tramite<br><input name="LocalTramite" type="text"><br>
                  Comarca <br><input name="Comarca" type="text"><br>
                  Fase <br><input name="Fase" type="text"><br>
                </td>
                <td> 
                  Localizador <br><input name="Localizador" type="text"><br>
                  Responsavel<br> <input name="Responsavel" type="text"><br>
                  Parceiro <br><input name="Parceiro" type="text"><br>
                  Origem <br><input name="Origem" type="text"><br>
                  Data Contratação <br><input name="DataContratacao" type="date"><br>
                  Data Encerramento<br> <input name="DataEncerraqmento" type="date"><br>
                  Data de Transito Julgado<br> <input name="DataTransitoJulgado" type="date"><br>
                  Data de Distribuiçao <br><input name="DataDistribuicao" type="date"><br>
                  Data de Sentença <br><input name="DataSetenca" type="date"><br>
                  Data de Execução <br><input name="DataExecucao" type="date"><br>
                  Valor da Causa <br><input name="ValorCausa" type="text"><br>
                  Outro Valor <br><input name="OutroValor" type="text"><br>
                  Contingencia <br><input name="Contingencia" type="text"><br>
                  Pedido <br><input name="Pedido" type="text"><br>
                  Observações <br><textarea name="Observacoes"></textarea><br>
                     

                  <input name="Cadastrar" value="Cadastrar" type="submit">
                </td>
              </tr>
            </tbody>
          </table>
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
                     <td><h4><a href="#">SOCEA</a></h4></td>
             
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