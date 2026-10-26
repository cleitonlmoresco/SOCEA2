<?php
require_once __DIR__ . '/Scripts/Seguranca.php';
protegePagina();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SOCEA - Alterar senha</title>
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
            <h1><a href="Inicio.php">SOCEA</a></h1>
        </div> <!-- end of site_title -->

    </div>

    <div id="templatemo_middle">

        <h1>SOCEA</h1>
        <p>Sistema de Organização e Cobrança de
Escritório de Advocacia.</p>

    </div>

    <div id="templatemo_content">

        <div class="col_w620_content">

            <h3>Alterar senha</h3>
            <?php render_mensagens(); ?>

            <form action="Scripts/AlterarSenha.php" method="post" name="AlterarSenha">
                <?php echo csrf_input(); ?>
                <table border="0" width="420">
                    <tr>
                        <td>Senha atual</td>
                        <td><input name="SenhaAtual" type="password" required></td>
                    </tr>
                    <tr>
                        <td>Nova senha</td>
                        <td><input name="NovaSenha" type="password" minlength="8" required></td>
                    </tr>
                    <tr>
                        <td>Confirmar nova senha</td>
                        <td><input name="ConfNovaSenha" type="password" minlength="8" required></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input value="Alterar senha" type="submit">
                            &nbsp; <a href="Inicio.php">Voltar</a>
                        </td>
                    </tr>
                </table>
            </form>

            <div class="cleaner"></div>
        </div>

        <div class="cleaner"></div>
    </div>

    <div id="templatemo_footer">

        <?php include 'Scripts/Versao.php'; ?>
        <a href="Inicio.php">SOCEA</a> V. <?php echo e($Versao); ?>

    </div>

</div>

</body>
</html>
