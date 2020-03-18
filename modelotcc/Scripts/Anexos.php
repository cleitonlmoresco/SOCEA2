<?php
 include('Conexao.php');
if(isset($_POST['enviar'])){
    $mensagem = ''; 
    $arquivo = $_FILES['arquivo'];
    
    $numfile = count($arquivo['tmp_name']);
    #arquivo
    $folder = 'Scripts/Arquivos/';
    #Permite
    $permite = array('text/plain');
    
    #menssagem
    $msg = array();
    $errorMSG = array(1=> "1; O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini. ",
        2 => "O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML.",
        3 => "O upload do arquivo foi feito parcialmente.",
        4 => "Nenhum arquivo foi enviado.");
    if($numfile <=0){
        echo 'Selecione o anexo';
    }  else {
        for($n = 0;$n<$numfile;$n++){
            //puxa o nome, tipo, tamanho, o nome do arquivo temporario e verifica se tem algum erro 
            $name = $arquivo['name'][$n];
            $type =$arquivo['type'][$n];
            $size = $arquivo['size'][$n];
            $error = $arquivo['error'][$n];
            $tmp = $arquivo['tmp_name'][$n];
            
            $extensao =@end(explode('.', $name));
            $novoNome = md5(time()).".{$extensao}";
            $diretorio = $folder.$novoNome;
          
        
        
        echo"<br>";
        if($error !=0){
            $msg[] =   '<b>{$name}: </b>'.$errorMSG[$error];
        }//inserir mais parametros de restriçoes  
        else {
            
                $mensagem = "Arrquivo enviado com sucesso";
                $codProcesso= $_GET['cdp'];
                $sql_code = "INSERT INTO `anexo` (`codArquivo`, `nomeArquivo`, `dataUpload`, `realNome`, `codProcesso`)
    VALUES (NULL, '".$novoNome."', NOW(), '".$name."', '".$codProcesso."')" ;
                $querryAr = mysqli_query($conexao,$sql_code) or die(mysqli_error());
            move_uploaded_file($tmp,$diretorio);
        }
        }
    }
    
   
}

