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
 include('Scripts/Anexos.php');
 
   $codProcesso = $_GET['cdp'];
      $querryP = mysqli_query($conexao,"SELECT * FROM `processo` WHERE `codProcesso` ='".$codProcesso."'")or die(mysql_error());
      $linhaP = mysqli_fetch_array($querryP);
      $querryC = mysqli_query($conexao,"SELECT * FROM `perfilcliente` WHERE `CodCliente` = ".$linhaP['CodCliente']."");
      $linhaC = mysqli_fetch_array($querryC);
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
    
    <div id="templatemo_content">
    
    	<div class="col_w620_w2col">
            
         	<div class="col_w620_content"> 
                    <div class="TabelaLetras">
	            
    <table border = '1'>
            <tr>
                <th colspan="3" ><h4>Arquivos</h4></th>
                
            </tr>
           
             <tr>
        <td >
        <?php
        echo "<form id = 'arquivo' action = '' method = 'post' enctype='multipart/form-data'>";?>
            Enviar arquivos: <input type = 'file' name = 'arquivo[]' multiple>
            <input type="submit" name = "enviar" value="enviar">
            <br>
            <?php if(isset($mensagem)){
            echo $mensagem;    
            }
            ?>
                </form></td>
            </tr>
            <tr><td colspan="3">Lista de Arquivos do Processo</td></tr>
        <?php
        $ComandoSql = "SELECT * FROM `anexo` WHERE `codProcesso` = '{$codProcesso}'";
        $queryArq = mysqli_query($conexao,$ComandoSql)or die("Erro no QurrryArq");
        $rowArq =mysqli_num_rows($queryArq)or die("Erro no QuryArq");
        
        
         if($rowArq > 0){
            echo "<tr><td> Nome do Arquivo </td>".
             "<td>Data de Envio</td>".
            "<td>Codigo do Arquivo</td></tr>";
     while ($linhaArq =mysqli_fetch_array($queryArq)){
           
     	$extensao =strtoupper(@end(explode('.', $linhaArq['realNome'])));
     	//executar arquivos em formato PDF
            if ($extensao=='PDF'){
              echo "<tr><td><a href='Scripts/Arquivos.php?cdg={$linhaArq['codArquivo']}' target='_blank'>{$linhaArq['realNome']}</td> "
            ."<td>{$linhaArq['dataUpload']}</td>".
             "<td>{$linhaArq['codArquivo']}</td>"
                 . '<td><input type="image"  src="images/Anotaçoes.png" title= "Anoteções." id = "toggleLinha'.$linhaArq['codArquivo'].'"  width="30" height="35">'
                                  
             . "</tr>";
             
             echo '<!--Script toogle  Anotaçoes--> '
     . '<script type="text/javascript">'
             . ' $(document).ready(function(){'
             . '  $("#toggleLinha'.$linhaArq['codArquivo'].'").click(toggleLinha'.$linhaArq['codArquivo'].');});'
             . '     
         function toggleLinha'.$linhaArq['codArquivo'].'(){'
             . '        $("#AnotProces'.$linhaArq['codArquivo'].'").toggle();'
             . '    }</script>'//Fim Script
             . '<tr id="AnotProces'.$linhaArq['codArquivo'].'" style="display:none"> '
        
             . '<td colspan = "3">'.$linhaArq['Descricao'].'</td>'
        //Mostrar Janela de ediçao de Cementarios
        . '<td><input type="image"  src="images/EditAnotaçoes.png" title= "Anoteções." id = "toggleJEditAnotaçoes'.$linhaArq['codArquivo'].'"  width="30" height="35"></td>'
        

//Script de Ediçao de anotaçoes
   . '<script type="text/javascript">'
             . ' $(document).ready(function(){'
             . '  $("#toggleJEditAnotaçoes'.$linhaArq['codArquivo'].'").click(toggleJEditAnotaçoes'.$linhaArq['codArquivo'].');});'
             . '     
         function toggleJEditAnotaçoes'.$linhaArq['codArquivo'].'(){'
             . '        $("#EditAnotaçoes'.$linhaArq['codArquivo'].'").toggle();'
             . '    }</script>'//Fim Script
        //Janela ediçao  de anotaçoes
             . '<div id="EditAnotaçoes'.$linhaArq['codArquivo'].'" style="display:none">'
        . '<div id="JEditComent">'
         . '<input type="image"  src="images/fechar.png" id = "toggleJEditAnotaçoes'.$linhaArq['codArquivo'].'"  width="60" height="35"></td>'
        
        
        . "<form id = 'EditComentario' action = 'Scripts/EditDescrAnexo.php?cdp=".$codProcesso."&ca=".$linhaArq['codArquivo']."' method = 'post'>"
        . '<textarea name = "EditarComentario" cols="40" rows="15" >'.$linhaArq['Descricao'].'</textarea>'
        . '<br>  <input type="submit" value="Salvar Comentario">'
        . '</form>'
        . '</div></div></tr>';
             
     	}else {
     	//executar outros formatos de arquivo
     		echo "<tr><td><a href='Scripts/Arquivos/{$linhaArq['nomeArquivo']}' target='_blank'>{$linhaArq['realNome']}</td> "
     		."<td>{$linhaArq['dataUpload']}". "</td>".
                        
                        
     				"<td>{$linhaArq['codArquivo']}</td>"
                                . '<td><input type="image"  src="images/Anotaçoes.png" title= "Anoteções." id = "toggleLinha'.$linhaArq['codArquivo'].'"  width="30" height="35">'
                                        . "</td></tr>";

//script mara mosrtrar comentarios dos arquivos                                
echo '<!--Script toogle  Anotaçoes--> '
     . '<script type="text/javascript">'
             . ' $(document).ready(function(){'
             . '  $("#toggleLinha'.$linhaArq['codArquivo'].'").click(toggleLinha'.$linhaArq['codArquivo'].');});'
             . '     
         function toggleLinha'.$linhaArq['codArquivo'].'(){'
             . '        $("#AnotProces'.$linhaArq['codArquivo'].'").toggle();'
             . '    }</script>'//Fim Script
             . '<tr id="AnotProces'.$linhaArq['codArquivo'].'" style="display:none"> '
        
             . '<td colspan = "3">'.$linhaArq['Descricao'].'</td>'
        //Mostrar Janela de ediçao de Cementarios
        . '<td><input type="image"  src="images/EditAnotaçoes.png" title= "Anoteções." id = "toggleJEditAnotaçoes'.$linhaArq['codArquivo'].'"  width="30" height="35"></td>'
        

//Script de Ediçao de anotaçoes
   . '<script type="text/javascript">'
             . ' $(document).ready(function(){'
             . '  $("#toggleJEditAnotaçoes'.$linhaArq['codArquivo'].'").click(toggleJEditAnotaçoes'.$linhaArq['codArquivo'].');});'
             . '     
         function toggleJEditAnotaçoes'.$linhaArq['codArquivo'].'(){'
             . '        $("#EditAnotaçoes'.$linhaArq['codArquivo'].'").toggle();'
             . '    }</script>'//Fim Script
        //Janela ediçao  de anotaçoes
             . '<div id="EditAnotaçoes'.$linhaArq['codArquivo'].'" style="display:none">'
        . '<div id="JEditComent">'
         . '<input type="image"  src="images/fechar.png" id = "toggleJEditAnotaçoes'.$linhaArq['codArquivo'].'"  width="60" height="35"></td>'
        
        
        . "<form id = 'EditComentario' action = 'Scripts/EditDescrAnexo.php?cdp=".$codProcesso."&ca=".$linhaArq['codArquivo']."' method = 'post'>"
       . '<textarea name = "EditarComentario" cols="40" rows="15" >'.$linhaArq['Descricao'].'</textarea>'
        . '<br>  <input type="submit" value="Salvar Comentario">'
        . '</form>'
        . '</div></div></tr>';
                                
     	}
         
            
           } }
        	
        ?>
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