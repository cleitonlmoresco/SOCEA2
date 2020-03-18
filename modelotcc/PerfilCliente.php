<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <meta charset="UTF-8">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link href="Style.css" rel="stylesheet" type="text/css" />

</head>
<body><br><br>
    <?php #puxa a conexao  com o banco de dados
 include('Scripts/Conexao.php');
 
 
#Pesquisa no banco de dados o nome , sobre nome, CPF ou Numero de telefone do cliente
$codCliente = $_GET['Cliente'];
       $Querry = mysqli_query($conexao, "SELECT * FROM `perfilcliente` WHERE `CodCliente` = ".$codCliente."") or die(mysql_error());
       $linha = mysqli_fetch_array($Querry);
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
			 
	            
            <h3>Cliente: <?php echo $codCliente?></h3>
            <div class="TabelaLetras">
          <table style="width: 100%;" border="1">
            <tbody>
              <tr>
                
                  <br>
                </td>
                <td>Nome: <?php echo $linha['Nome'].' '.$linha['SobreNome'];?><br>

                  <br>
                </td>
                <td>Data de nascimento <br>
                  <?php echo $linha['Nascimento'];?><br>
                </td>
                <td>Telefone:<br>
                 <?php echo $linha['TelContato1'];
                  echo'<br>';
                 echo $linha['TelContato2'];?>
                </td>
              </tr>
              <tr>
                <td>CPF:<br>
                 <?php echo $linha['CPF'];?>
                </td>
                <td>RG:<br>
                 <?php echo $linha['RG'];?>
                </td>
                <td>E-mail:<br>
                 <?php echo $linha['Email1'];
                 echo'<br>';
                 echo $linha['Email2'];?>
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
            <?php echo $linha['Endereco'];?>
        </td>
        <td>
             Bairro:
             <br>
             <?php echo $linha['Bairro'];?>
            
        </td>
        <td>
            Cidade: 
            <br>
            <?php echo $linha['Cidade'];?>
        </td>
        <td>UF: 
            <br>
            <?php echo $linha['UF'];?>
        
        </td>
    </tr>
    <tr>
        <td>  CEP:
    <br>
    <?php echo $linha['CEP'];?>
        
    </td>
    <td>Estado civil:<br>
    <?php echo $linha['EstadoCivil'];?>
    </td>
    <td>Nacionalidade:<br>
    <?php echo $linha['Nacionalidade'];?>
    </td>
    <td>
        Profissao:<br>
    <?php echo $linha['Profissao'];?>
    </td>
    </tr>
    <tr>
    <td>
        PIS:<br>
    <?php echo $linha['PIS'];?>
    </td>
    <td>Grupo: <br>
    <?php echo $linha['Grupo'];?>
    </td>
    <td>Perfil:<br>
    <?php echo $linha['Perfil'];?>
    </td>
    <td>Fax:<br>
        <?php echo $linha['Fax'];?>
    </td>
    </tr><tr>
    <td>Contato:<br>
    <?php echo $linha['Contato'];?>
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
                    <?php
                    #Operaçao que procura e seleciona os processo do cliente 
                    $QuerryP = mysqlI_query($conexao, "SELECT * FROM `processo` WHERE `CodCliente` = ".$codCliente."") or die(mysql_error());
                    $RowP = mysqlI_num_rows($QuerryP);
                    if($RowP>0){
                      echo "<tr><td>Numero de Processo</td><td>Objeto de ação</td><td>Localizador</td></tr>";
                      while($ln = mysqli_fetch_array($QuerryP)){
                        $numProcesso = $ln["NumProcesso"];
                        $ObjAçao = $ln["ObjetoDeAcao"];
                        $Localizador = $ln["Localizador"];
                        $linkp = "Processo.php?cdp=".$ln['codProcesso'];
                        echo '<tr><td>';
                        echo "<a href='{$linkp}'>".$numProcesso."</a>";
                        echo '</td><td>';
                        echo "<a href='{$linkp}'>".$ObjAçao."</a>";
                        echo '</td><td>';
                        echo "<a href='{$linkp}'>".$Localizador."</a>";
                        echo '</tr></td>';
                      }
                    }
                    
                    ?>
                  
          </table>	</div>	
    		</div>        
        </div>
        
       
             
        
        
       	<div class="col_w300 col_last">
		
            
            <form  action="PesquisaCliente.html" method="get">
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
                   <form method="POST" action="Scripts/EditarCliente.php?Cl=<?php echo $codCliente;?>" name="EditarCliente">
                 
          <table border="1">
            <tbody>
              <tr>
                <td>
                    Nome<br><input name="nome" value="<?php echo $linha['Nome']?>" type="text"><br>
                  Sobre Nome<br><input name="sobNome" value="<?php echo $linha['SobreNome']?>" type="text"><br>
                  Data de Nascimento <br><input name="nascimento" value="<?php echo $linha['Nascimento']?>" type="date"><br>
                  CPF <br><input name="CPF" value="<?php echo $linha['CPF']?>" type="text"><br>
                  RG <br><input name="RG" value="<?php echo $linha['RG']?>" type="text"><br>
                  Estado Civil<br><input name="estCivil" value="<?php echo $linha['EstadoCivil']?>" type="text"><br>
                  Endereço <br><input name="Endereco" value="<?php echo $linha['Endereco']?>" type="text"><br>
                  Bairro <br><input name="bairro" value="<?php echo $linha['Bairro']?>" type="text"><br>
                  Cidade <br><input name="cidade" value="<?php echo $linha['Cidade']?>" type="text"><br>
                  UF <br><input name="UF" value="<?php echo $linha['UF']?>"  type="text"><br>
                  CEP <br><input name="CEP" value="<?php echo $linha['CEP']?>"  type="text"><br>
                </td>
                <td> Telefone 1 <br><input name="tel1" value="<?php echo $linha['TelContato1']?>"  type="text"><br>
                  Telefone 2<br><input name="tel2" value="<?php echo $linha['TelContato2']?>"  type="text"><br>
                  Email 1<br> <input name="email1" value="<?php echo $linha['Email1']?>"  type="text"><br>
                  Email 2<br> <input name="email2" value="<?php echo $linha['Email2']?>"  type="text"><br>
                  Fax <br><input name="fax" value="<?php echo $linha['Fax']?>"  type="text"><br>
                  Grupo <br><input name="grupo" value="<?php echo $linha['Grupo']?>"  type="text"><br>
                  Nacionalidade <br><input name="nacionalidade" value="<?php echo $linha['Nacionalidade']?>"  type="text"><br>
                  Perfil <br><input name="perfil" value="<?php echo $linha['Perfil']?>"  type="text"><br>
                  Contato <br><input name="contato" value="<?php echo $linha['Contato']?>"  type="text"><br>
                  Profissao<br> <input name="profissao" value="<?php echo $linha['Profissao']?>"  type="text"><br>
                  PIS <br><input name="PIS" value="<?php echo $linha['PIS']?>"  type="text"><br><br>
                  <input name="Cadastrar"   value="Cadastrar" type="submit">
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