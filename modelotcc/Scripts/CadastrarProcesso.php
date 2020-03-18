
<?php
include('Conexao.php');


 $CodCliente = $_GET['codCliente'];
 $NumProcesso = $_POST['NumProcesso'];
 $Grupo = $_POST['Grupo'];
 $NumeroCNJ = $_POST['NumeroCNJ'];
 $StatusProcessual = $_POST['StatusProcessual'];
 $AreaAtuacao = $_POST['AreaAtuacao'];
 $ObjetoDeAcao = $_POST['ObjetoDeAçao'];
 $Detalhes= $_POST['Detalhes'];
 $Prognosticos= $_POST['Prognosticos'];
 $CampoLivre1= $_POST['CampoLivre1'];
 $CampoLivre2= $_POST['CampoLivre2'];

 $Pasta= $_POST['Pasta'];
 $Etiqueta= $_POST['Etiqueta'];
 $LocalTramite= $_POST['LocalTramite'];
 $Comarca= $_POST['Comarca'];
 $Fase= $_POST['Fase'];
 $Localizador= $_POST['Localizador'];
 $Responsavel= $_POST['Responsavel'];
 $Parceiro= $_POST['Parceiro'];
 $Origem= $_POST['Origem'];
 $DataContratacao= $_POST['DataContrataçao'];
 $DataEncerraqmento= $_POST['DataEncerraqmento'];
 $DataDistribuicao= $_POST['DataDistribuiçao'];
 $DataTransitoJulgado= $_POST['DataTransitoJulgado'];
 $DataSetenca= $_POST['DataSetença'];
 $DataExecucao= $_POST['DataExecuçao'];
 $ValorCausa= $_POST['ValorCausa'];
 $OutroValor= $_POST['OutroValor'];
 $Contingencia= $_POST['Contingencia'];
 $Pedido= $_POST['Pedido'];
  $Observacoes= $_POST['Observaçoes'];
  $Assunto= $_POST['Assunto'];


$insert = "INSERT INTO `processo` ( `CodCliente`, `Grupo`, `NumeroCNJ`, `StatusProcessual`, `AreaAtuacao`,
`ObjetoDeAcao`, `Assunto`, `Detalhes`, `Prognosticos`, `CampoLivre1`, `CampoLivre2`, `Pasta`, `Etiqueta`, `LocalTramite`,
 `Comarca`, `Fase`, `Localizador`, `Responsavel`, `Parceiro`, `Origem`, `DataContratacao`, `DataEncerraqmento`,
  `DataDistribuicao`, `DataTransitoJulgado`, `DataSetenca`, `DataExecucao`, `ValorCausa`, `OutroValor`, `Contingencia`,
  `Pedido`, `Observacoes`)
  VALUES ( '$CodCliente', '$Grupo', '$NumeroCNJ', '$StatusProcessual', '$AreaAtuacao', '$ObjetoDeAcao', '$Assunto', '$Detalhes', '$Prognosticos', '$CampoLivre1',
   '$CampoLivre2', '$Pasta', '$Etiqueta', '$LocalTramite', '$Comarca', '$Fase', '$Localizador', '$Responsavel', '$Parceiro', '$Origem', '$DataContratacao',
    '$DataEncerraqmento', '$DataDistribuicao', '$DataTransitoJulgado', '$DataSetenca', '$DataExecucao', '$ValorCausa', '$OutroValor', '$Contingencia', '$Pedido', '$Observacoes');";
$sql = mysqli_query($conexao,$insert);

echo ('Cadastrado com sucesso');

header("Location:http:../PerfilCliente.php?Cliente=".$CodCliente);