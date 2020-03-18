<?php
include 'Conexao.php';
$Agendamento = "";
$DataAgendamento = $_POST['DataAgendamento'];
$horaAgendamento = $_POST['HoraAgendamento'];
$Descricao = $_POST['Descricao'];
$CodAdv= '0'; 
if(isset($_POST['CodADV'])){
   
    $NomeAdv = $_POST['CodADV'];
    $CodAdv =strtoupper(@end(explode('.', $NomeAdv)));
    
}


$querry = "INSERT INTO `Agendamento` (`AgendamentoDe`, `Descricao`, `OutroAgendamento`, `HrAgendamento`, `DataAgendamento`) "
        . "VALUES('".$CodAdv."', '".$Descricao."', '".$Agendamento."', '".$horaAgendamento."', '".$DataAgendamento."')";
mysqli_query($conexao, $querry);
header("Location: ".'../Agenda.php');