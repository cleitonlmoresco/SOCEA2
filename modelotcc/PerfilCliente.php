<?php require_once __DIR__ . '/Scripts/Seguranca.php'; protegePagina(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <meta charset="UTF-8">
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
$codCliente = get_int('Cliente');
$cliente = $codCliente > 0
    ? db_one('SELECT * FROM perfilcliente WHERE CodCliente = ?', [$codCliente])
    : null;

if ($cliente === null) {
    http_response_code(404);
    exit('Cliente não encontrado.');
}

$processos = db_all(
    'SELECT * FROM processo WHERE CodCliente = ? ORDER BY codProcesso DESC',
    [$codCliente]
);
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
    
    <div id="templatemo_content">
    
    	<div class="col_w620_w2col">
         	<div class="col_w620_content"> 
			 
	            
            <?php render_mensagens(); ?>
            <h3>Cliente: <?php echo e($cliente['Nome'] . ' ' . $cliente['SobreNome']); ?></h3>
            <div class="TabelaLetras">
          <table style="width: 100%;" border="1">
            <tbody>
              <tr>
                
                  <br>
                </td>
                <td>Nome: <?php echo e($cliente['Nome']).' '.e($cliente['SobreNome']);?><br>

                  <br>
                </td>
                <td>Data de nascimento <br>
                  <?php echo e($cliente['Nascimento']);?><br>
                </td>
                <td>Telefone:<br>
                 <?php echo e($cliente['TelContato1']);
                  echo'<br>';
                 echo e($cliente['TelContato2']);?>
                </td>
              </tr>
              <tr>
                <td>CPF:<br>
                 <?php echo e($cliente['CPF']);?>
                </td>
                <td>RG:<br>
                 <?php echo e($cliente['RG']);?>
                </td>
                <td>E-mail:<br>
                 <?php echo e($cliente['Email1']);
                 echo'<br>';
                 echo e($cliente['Email2']);?>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <script language="JavaScript">
                      function ver(num){
                               var id="conteudo_"+num;
                            	var obj=document.getElementById(id);
	                            var status=obj.style.display;
	                                if(status=="none"){obj.style.display="inline"}
                                     else{obj.style.display="none";}
                                                                    }

</script>
<span id="titulo_1" class="titulo"><img src="images/Baixo.png" onClick="ver('1')"width="120" height="50"</span>
<span id="conteudo_1" class="conteudo" style="display: none;">
    <table border ="1">
    <tr>
        <td>
            Endereço: 
            <br>
            <?php echo e($cliente['Endereco']);?>
        </td>
        <td>
             Bairro:
             <br>
             <?php echo e($cliente['Bairro']);?>
            
        </td>
        <td>
            Cidade: 
            <br>
            <?php echo e($cliente['Cidade']);?>
        </td>
        <td>UF: 
            <br>
            <?php echo e($cliente['UF']);?>
        
        </td>
    </tr>
    <tr>
        <td>  CEP:
    <br>
    <?php echo e($cliente['CEP']);?>
        
    </td>
    <td>Estado civil:<br>
    <?php echo e($cliente['EstadoCivil']);?>
    </td>
    <td>Nacionalidade:<br>
    <?php echo e($cliente['Nacionalidade']);?>
    </td>
    <td>
        Profissao:<br>
    <?php echo e($cliente['Profissao']);?>
    </td>
    </tr>
    <tr>
    <td>
        PIS:<br>
    <?php echo e($cliente['PIS']);?>
    </td>
    <td>Grupo: <br>
    <?php echo e($cliente['Grupo']);?>
    </td>
    <td>Perfil:<br>
    <?php echo e($cliente['Perfil']);?>
    </td>
    <td>Fax:<br>
        <?php echo e($cliente['Fax']);?>
    </td>
    </tr><tr>
    <td>Contato:<br>
    <?php echo e($cliente['Contato']);?>
    </td>
        <!--Icone para abir a caixa de ediçao de perfil de cliente-->
        <td colspan="3"><input type="image"  src="images/Agenda.png" id = "toggleDivEdiçao"  width="30" height="35"></td>
    </tr>
    </table>
</span>
            

                </td>

              </tr>
            </tbody>
          </table>
                

          <br><br><br>
          <table border = '1'>
                  <tr>
                  <th colspan = '3'> <center>Processos </center>
                  </th>
                  </tr>

                  <tr>
                  <td colspan = "2"><?php
                   $link="CadastroProcesso.php?codCliente=".$codCliente;
                 echo("<a href='{$link}'>Cadastrar processo</a>");    ?></td>

                     <td><form  action="PesquisaProcesso.php" method="get">
            <input autocomplete="on" value="Pesquisa" name="Pesquisa" type="search">
            <input name="Pesquisar" value="Pesquisar" type="submit">
                    </form></td>

                  </tr>
                  <tr><th colspan = '3'>Lista de Processos</th></tr>
                    <?php if ($processos === []): ?>
                        <tr><td colspan="3">Nenhum processo cadastrado.</td></tr>
                    <?php else: ?>
                        <tr><td>Numero de Processo</td><td>Objeto de ação</td><td>Localizador</td></tr>
                        <?php foreach ($processos as $processo): ?>
                            <?php $linkp = 'Processo.php?cdp=' . (int) $processo['codProcesso']; ?>
                            <tr>
                                <td><a href="<?php echo e($linkp); ?>"><?php echo e($processo['NumProcesso']); ?></a></td>
                                <td><a href="<?php echo e($linkp); ?>"><?php echo e($processo['ObjetoDeAcao']); ?></a></td>
                                <td><a href="<?php echo e($linkp); ?>"><?php echo e($processo['Localizador']); ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                  
          </table>	</div>	
    		</div>        
        </div>
        
       
             
        
        
       	<div class="col_w300 col_last">
		
            
            <form  action="PesquisaCliente.php" method="get">
            <input autocomplete="on" value="Pesquisa" name="Pesquisa" type="search">
            <input name="Pesquisar" value="Pesquisar" type="submit"> </form>	
            
             <!--Caixa para ediçao do cliente -->
             <script type="text/javascript">
         $(document).ready(function(){
             $("#toggleDivEdiçao").click(toggleDivEdiçao);
         });
         function toggleDivEdiçao(){
             $("#CaixadeEdiçao").toggle();
             
         }</script>
             <div id="CaixadeEdiçao">
                   <input type="image"  src="images/fechar.png" id = "toggleDivEdiçao"  width="60" height="40"></td>
                   <form method="POST" action="Scripts/EditarCliente.php?Cl=<?php echo (int) $codCliente; ?>" name="EditarCliente">
                   <?php echo csrf_input(); ?>
                 
          <table border="1">
            <tbody>
              <tr>
                <td>
                    Nome<br><input name="nome" value="<?php echo e($cliente['Nome'])?>" type="text"><br>
                  Sobre Nome<br><input name="sobNome" value="<?php echo e($cliente['SobreNome'])?>" type="text"><br>
                  Data de Nascimento <br><input name="nascimento" value="<?php echo e($cliente['Nascimento'])?>" type="date"><br>
                  CPF <br><input name="CPF" value="<?php echo e($cliente['CPF'])?>" type="text"><br>
                  RG <br><input name="RG" value="<?php echo e($cliente['RG'])?>" type="text"><br>
                  Estado Civil<br><input name="estCivil" value="<?php echo e($cliente['EstadoCivil'])?>" type="text"><br>
                  Endereço <br><input name="Endereco" value="<?php echo e($cliente['Endereco'])?>" type="text"><br>
                  Bairro <br><input name="bairro" value="<?php echo e($cliente['Bairro'])?>" type="text"><br>
                  Cidade <br><input name="cidade" value="<?php echo e($cliente['Cidade'])?>" type="text"><br>
                  UF <br><input name="UF" value="<?php echo e($cliente['UF'])?>"  type="text"><br>
                  CEP <br><input name="CEP" value="<?php echo e($cliente['CEP'])?>"  type="text"><br>
                </td>
                <td> Telefone 1 <br><input name="tel1" value="<?php echo e($cliente['TelContato1'])?>"  type="text"><br>
                  Telefone 2<br><input name="tel2" value="<?php echo e($cliente['TelContato2'])?>"  type="text"><br>
                  Email 1<br> <input name="email1" value="<?php echo e($cliente['Email1'])?>"  type="text"><br>
                  Email 2<br> <input name="email2" value="<?php echo e($cliente['Email2'])?>"  type="text"><br>
                  Fax <br><input name="fax" value="<?php echo e($cliente['Fax'])?>"  type="text"><br>
                  Grupo <br><input name="grupo" value="<?php echo e($cliente['Grupo'])?>"  type="text"><br>
                  Nacionalidade <br><input name="nacionalidade" value="<?php echo e($cliente['Nacionalidade'])?>"  type="text"><br>
                  Perfil <br><input name="perfil" value="<?php echo e($cliente['Perfil'])?>"  type="text"><br>
                  Contato <br><input name="contato" value="<?php echo e($cliente['Contato'])?>"  type="text"><br>
                  Profissao<br> <input name="profissao" value="<?php echo e($cliente['Profissao'])?>"  type="text"><br>
                  PIS <br><input name="PIS" value="<?php echo e($cliente['PIS'])?>"  type="text"><br><br>
                  <input name="Salvar" value="Salvar" type="submit">
                </td>
              </tr>
            </tbody>
          </table>
        </form>
             </div>
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