<?php require_once __DIR__ . '/Scripts/Seguranca.php'; protegePagina(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SOCEA - Cliente </title>

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
    <?php
    $codProcesso = get_int('cdp');
    $processo = $codProcesso > 0
        ? db_one('SELECT * FROM processo WHERE codProcesso = ?', [$codProcesso])
        : null;

    if ($processo === null) {
        http_response_code(404);
        exit('Processo não encontrado.');
    }

    $cliente = db_one(
        'SELECT * FROM perfilcliente WHERE CodCliente = ?',
        [(int) $processo['CodCliente']]
    );
    $anexos = db_all(
        'SELECT * FROM anexo WHERE codProcesso = ? ORDER BY codArquivo DESC',
        [$codProcesso]
    );
    ?>

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
    
    	<div class="col_w620_w2col">
            
         	<div class="col_w620_content"> 
                <?php render_mensagens(); ?>
                <h3>Processo <?php echo e($processo['NumProcesso']); ?></h3>
                <p>
                    Cliente:
                    <?php if ($cliente !== null): ?>
                        <a href="PerfilCliente.php?Cliente=<?php echo (int) $cliente['CodCliente']; ?>">
                            <?php echo e($cliente['Nome'] . ' ' . $cliente['SobreNome']); ?>
                        </a>
                    <?php else: ?>
                        não encontrado
                    <?php endif; ?>
                    <?php if (trim((string) $processo['ObjetoDeAcao']) !== ''): ?>
                        | Objeto: <?php echo e($processo['ObjetoDeAcao']); ?>
                    <?php endif; ?>
                </p>
                    <div class="TabelaLetras">
	            
    <table border="1">
            <tr>
                <th colspan="4"><h4>Arquivos</h4></th>
            </tr>
            <tr>
                <td colspan="4">
                    <form id="arquivo" action="Scripts/Anexos.php?cdp=<?php echo (int) $codProcesso; ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_input(); ?>
                        Enviar arquivos: <input type="file" name="arquivo[]" multiple>
                        <input type="submit" name="enviar" value="Enviar">
                    </form>
                </td>
            </tr>
            <tr><td colspan="4">Lista de Arquivos do Processo</td></tr>
        <?php if ($anexos === []): ?>
            <tr><td colspan="4">Nenhum arquivo anexado.</td></tr>
        <?php else: ?>
            <tr>
                <td>Nome do Arquivo</td>
                <td>Data de Envio</td>
                <td>Código</td>
                <td>Ações</td>
            </tr>
            <?php foreach ($anexos as $anexo): ?>
                <?php
                $codArquivo = (int) $anexo['codArquivo'];
                $descricao = (string) $anexo['Descricao'];
                ?>
                <tr>
                    <td>
                        <a href="Scripts/Arquivos.php?cdg=<?php echo $codArquivo; ?>" target="_blank" rel="noopener">
                            <?php echo e($anexo['realNome']); ?>
                        </a>
                    </td>
                    <td><?php echo e($anexo['dataUpload']); ?></td>
                    <td><?php echo $codArquivo; ?></td>
                    <td>
                        <input type="image" src="images/Anotaçoes.png" title="Anotações"
                               id="toggleLinha<?php echo $codArquivo; ?>" width="30" height="35">
                    </td>
                </tr>
                <tr id="AnotProces<?php echo $codArquivo; ?>" style="display:none">
                    <td colspan="3"><?php echo nl2br(e($descricao)); ?></td>
                    <td>
                        <input type="image" src="images/EditAnotaçoes.png" title="Editar anotação"
                               id="toggleJEditAnotacoes<?php echo $codArquivo; ?>" width="30" height="35">
                    </td>
                </tr>
                <tr id="EditAnotacoes<?php echo $codArquivo; ?>" style="display:none">
                    <td colspan="4">
                        <form action="Scripts/EditDescrAnexo.php?cdp=<?php echo (int) $codProcesso; ?>&amp;ca=<?php echo $codArquivo; ?>" method="post">
                            <?php echo csrf_input(); ?>
                            <textarea name="EditarComentario" cols="60" rows="8"><?php echo e($descricao); ?></textarea>
                            <br>
                            <input type="submit" value="Salvar Comentário">
                        </form>
                    </td>
                </tr>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#toggleLinha<?php echo $codArquivo; ?>").click(function () {
                            $("#AnotProces<?php echo $codArquivo; ?>").toggle();
                        });
                        $("#toggleJEditAnotacoes<?php echo $codArquivo; ?>").click(function () {
                            $("#EditAnotacoes<?php echo $codArquivo; ?>").toggle();
                        });
                    });
                </script>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        
        
        
        
        
                    
                    </div>
    		</div>        
    		
        </div>
        
     
    
    	
        
     <div class="col_w300 col_last">
		
         <br>
             </div>
    
    	<div class="cleaner"></div>
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