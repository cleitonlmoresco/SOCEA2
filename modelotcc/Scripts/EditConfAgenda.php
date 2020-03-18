<?php
include 'Conexao.php';
$codAgendamento = $_GET['ca'];

If($_POST['Enviar']=="Alterar") {
    
          $Data=$_POST["DataAgendamento"];
          $hora =$_POST['HoraAgendamento'];
          $Descriçao=$_POST["EditarComentario"];
          $querry = "UPDATE `Agendamento` SET `Descricao` = '".$Descriçao."', `DataAgendamento` = '".$Data."', `HrAgendamento` = '".$hora."' 
                     WHERE `Agendamento`.`CodAgendamento` = ".$codAgendamento.";";
          mysqli_query($conexao, $querry);
          header("Location: ".'../Agenda.php');
}

elseif ($_POST['Enviar']=="Excuir") {
        mysqli_query($conexao, "DELETE FROM `Agendamento` WHERE `Agendamento`.`CodAgendamento` =".$codAgendamento);
header("Location: ".'../Agenda.php');


        //no action sent
}
?>



