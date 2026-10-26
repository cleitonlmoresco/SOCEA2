<?php
require_once __DIR__ . '/Scripts/Seguranca.php';
protegePagina();

$pesquisa = '';
if (isset($_GET['Pesquisa']) && is_string($_GET['Pesquisa'])) {
    $pesquisa = trim($_GET['Pesquisa']);
}

$processos = [];
if ($pesquisa !== '') {
    $termo = '%' . $pesquisa . '%';
    $processos = db_all(
        'SELECT p.codProcesso, p.NumProcesso, p.NumeroCNJ, p.ObjetoDeAcao, p.Localizador,
                c.CodCliente, c.Nome, c.SobreNome
         FROM processo p
         JOIN perfilcliente c ON c.CodCliente = p.CodCliente
         WHERE p.NumProcesso LIKE ? OR p.NumeroCNJ LIKE ? OR p.ObjetoDeAcao LIKE ?
            OR p.Localizador LIKE ? OR c.Nome LIKE ? OR c.SobreNome LIKE ?
         ORDER BY p.codProcesso DESC',
        [$termo, $termo, $termo, $termo, $termo, $termo]
    );
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SOCEA - Processos</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<script src="jquery-3.1.1.min.js"></script>
<link href="Style.css" rel="stylesheet" type="text/css" />
</head>
<body><br><br>
<div id="templatemo_wrapper">

    <div id="templatemo_header">
        <div id="site_title">
            <h1><a href="Inicio.php">SOCEA</a></h1>
        </div>
        <div id="templatemo_menu">
            <ul>
                <li><a href="Cliente.php">Cliente</a></li>
                <li><a href="Inicio.php">Inicio</a></li>
                <li><a href="Cliente.php" class="current">Cliente</a></li>
                <li><a href="Agenda.php">Agenda</a></li>
                <li><a href="Publicacoes.php">Publicações</a></li>
            </ul>
        </div>
    </div>

    <div id="templatemo_middle">
        <h1>SOCEA</h1>
        <p>Sistema de Organização e Cobrança de Escritório de Advocacia.</p>
    </div>

    <div id="templatemo_content">
        <div class="col_w620_w2col">
            <div class="col_w620_content">
                <h3>Pesquisar processos</h3>
                <form action="PesquisaProcesso.php" method="get">
                    <input value="<?php echo e($pesquisa); ?>" name="Pesquisa" type="search">
                    <input name="Pesquisar" value="Pesquisar" type="submit">
                    &nbsp; <a href="Cliente.php">Voltar aos clientes</a>
                </form>
                <div class="TabelaLetras">
                    <?php if ($pesquisa === ''): ?>
                        <p>Digite o número do processo, CNJ, objeto, localizador ou nome do cliente.</p>
                    <?php elseif ($processos === []): ?>
                        <p>Nenhum processo encontrado para "<?php echo e($pesquisa); ?>".</p>
                    <?php else: ?>
                        <table border="1">
                            <tr>
                                <th>Processo</th>
                                <th>Cliente</th>
                                <th>Objeto</th>
                                <th>Localizador</th>
                            </tr>
                            <?php foreach ($processos as $processo): ?>
                                <tr>
                                    <td>
                                        <a href="Processo.php?cdp=<?php echo (int) $processo['codProcesso']; ?>">
                                            <?php echo e($processo['NumProcesso'] !== '' ? $processo['NumProcesso'] : $processo['NumeroCNJ']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="PerfilCliente.php?Cliente=<?php echo (int) $processo['CodCliente']; ?>">
                                            <?php echo e($processo['Nome'] . ' ' . $processo['SobreNome']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo e($processo['ObjetoDeAcao']); ?></td>
                                    <td><?php echo e($processo['Localizador']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col_w300 col_last">
            <h3>Atalhos</h3>
            <ul>
                <li><a href="Cliente.php">Clientes</a></li>
                <li><a href="Agenda.php">Agenda</a></li>
            </ul>
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
