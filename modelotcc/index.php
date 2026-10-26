<?php require_once __DIR__ . '/Scripts/Seguranca.php'; if (usuario_logado()) { redirecionar('Inicio.php'); } ?>
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

</head>
<body>

<div id="templatemo_wrapper">
	
    <div id="templatemo_header">
    
   		<div id="site_title">
            <h1><a href="#">SOCEA</a></h1>
        </div> <!-- end of site_title -->
    
    </div>
    
    <div id="templatemo_middle">
    
    	<h1>SOCEA</h1>
        <p>Sistema de Organização e Cobrança de 
Escritório de Advocacia.</p>
        
    
    </div>
    
    <div id="templatemo_content">
    
    	<div class="col_w300">
		
            
            <div class="image_wrapper"></div>
          	
               
                    
        </div>
    
        <div class="col_w300">
		
            <h3><center>Efetue o seu Login.</center></h3>
            <?php render_mensagens(); ?>
            <form action="Scripts/Valida.php" method="post" name="Login">
                <?php echo csrf_input(); ?>
                <p><center>E-mail</center></p>
                      <center> &nbsp;<input size="30" name="Email" type="text">&nbsp;
                              <p>&nbsp;Senha</p><br>
                        <p style="margin-top: -17px; margin-left: 6px;"> <input
                            size="15" name="Senha" type="password"></p>
                        <p><a href="RecuperarSenha.php">Alterar senha</a></p>
                        <input value="Entrar" id="Entrar" name="Entrar" type="submit">
                    
            
      </center></form>
			
            <div class="cleaner"></div>
	</div><div class="cleaner"></div>
    </div>
    
    <div id="templatemo_footer">
    
    	  <?php include 'Scripts/Versao.php'; ?>
    	 <a href="#">SOCEA </a> V. <?php echo $Versao;?>
         
    </div>
    
</div>

</body>
</html>