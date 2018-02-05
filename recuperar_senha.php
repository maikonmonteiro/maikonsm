<?php

if(isset($_POST['enviar'])){

  if($_POST['cpf']==""){
    echo "<meta http-equiv='refresh' content='0; URL=../recuperar_senha.php'>
    <script type=\"text/javascript\">
    alert(\"Digite seu CPF!\");
    </script>";
    
    return die; // a página morre! não executa mais o restante dos códigos
  }else{

/*
    function enviar_mensagem($n, $e, $s, $t){

  // INICIO
function requisicaoApi($params, $endpoint){
    $url = "http://api.directcallsoft.com/{$endpoint}";
    $data = http_build_query($params);
    $ch =   curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($ch);
    curl_close($ch);
    // Converte os dados de JSON para ARRAY
    $dados = json_decode($return, true);
    return $dados;
}
 
// CLIENT_ID que é fornecido pela DirectCall (Seu e-mail)
$client_id = "maikonsm7@gmail.com";
// CLIENT_SECRET que é fornecido pela DirectCall (Código recebido por SMS)
$client_secret = "3068447";
// Faz a requisicao do access_token
$req = requisicaoApi(array('client_id'=>$client_id, 'client_secret'=>$client_secret), "request_token");
//Seta uma variavel com o access_token
$access_token = $req['access_token'];
// Enviadas via POST do nosso contato.html
$nome = $n;
$email = $e;
$mensagem = "Olá ".$n." ! Sua senha do sistema CEI eh: ".$s;
// Monta a mensagem
$SMS = "Contato de: {$nome} - <{$email}> - {$mensagem}";


// Array com os parametros para o envio
$data = array(
    'origem'=>"92992181483", // Seu numero que Ã© origem
    'destino'=>"92992181483", // E o numero de destino
    'tipo'=>"texto",
    'access_token'=>$access_token,
    'texto'=>$SMS
);
// realiza o envio
$req_sms = requisicaoApi($data, "sms/send");
echo "<meta http-equiv='refresh' content='0; URL=../recuperar_senha.php'>
    <script type=\"text/javascript\">
    alert(\"Mensagem enviada com sucesso!\");
    </script>";    
    return die; // a página morre! não executa mais o restante dos códigos
// FIM

}
*/

// função de enviar email (chega na caixa de SPAM)
function enviar_email($n, $e, $s){

ini_set('display_errors', 1);
 
error_reporting(E_ALL);
 
$from = "ozanira.cei2013@ceiita.com.br";
 
$to = $e;
 
$subject = "Recuperação de senha - CEI";
 
$message = "Olá ".$n." ! \nSua senha é: ".$s."\n \nEm caso de dúvidas acesse nosso site www.ceiita.com.br ou ligue (92) 3014-0499 / 99500-1498\nAtt,";
 
$headers = "De:". $from;

if(mail($to, $subject, $message, $headers)){
 
echo "<meta http-equiv='refresh' content='0; URL=../recuperar_senha.php'>
    <script type=\"text/javascript\">
    alert(\"Email enviado com sucesso!\");
    </script>";

}

}

    include_once "funcoes/conexao.php";
$pdo = conectar();

  $cpfA = $pdo->prepare("SELECT * FROM aluno WHERE cpf = :cpf LIMIT 1");
  $cpfA->bindValue(":cpf", $_POST['cpf']);
  $cpfA->execute();

  $cpfU = $pdo->prepare("SELECT * FROM usuario WHERE cpf = :cpf LIMIT 1");
  $cpfU->bindValue(":cpf", $_POST['cpf']);
  $cpfU->execute();

  if ($cpfA->rowCount()>0) {

   $aluno = $cpfA->fetch(PDO::FETCH_ASSOC);
   $senhaA = base64_decode($aluno['senha']);
   enviar_email($aluno['nome'], $aluno['email'], $senhaA);

  }elseif ($cpfU->rowCount()>0) {

    $usuario = $cpfU->fetch(PDO::FETCH_ASSOC);
   $senhaU = base64_decode($usuario['senha']);
   enviar_email($usuario['nome'], $usuario['email'], $senhaU);

  }else{
    echo "<meta http-equiv='refresh' content='0; URL=../recuperar_senha.php'>
    <script type=\"text/javascript\">
    alert(\"CPF nao encontrado!\");
    </script>";
    
    return die; // a página morre! não executa mais o restante dos códigos
  }



}

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CEI</title>
 <link rel="stylesheet" type="text/css" href="css/style.css"/>
    
  <!-- Bootstrap -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script> 

  <!--imagem título-->
    <link rel="shortcut icon" href="img/icone.ico"/> 
    
</head>

<body>

<div class="topo" style="height: 120px; width: auto; background-image: url(img/bg_topo.png);">
        <div style="color: white; position: absolute; margin-left: 5%;">
        <h3>CENTRO DE ENSINO DE ITACOATIARA - CEI</h3>
        <h5>Empresa Especializada em Prestação de Serviços Educacionais</h5>
        </div>

        <div style="text-align: right; margin-right: 5%;">
        <img src="img/balao.png" style="width: 120px;">
        </div>

    </div>

<fieldset class="form-inline" style="margin-left: 35%; margin-top: 5%; width: 30%;">
  <legend class="legenda">Recuperar Senha</legend>
 
  <form method="post" class="form-inline" action="recuperar_senha.php?enviar=ok">

  <div style="padding: 2% 2% 2% 2%;">
  <span style="font-size:14px;">Digite o número do seu CPF, e após clicar em "Enviar" será enviado uma mensagem para o email contido no seu cadastro.</span> </br></br>
   CPF
   <input style="width: 40%; margin-left: 1%;" maxlength="14" onkeypress="formatar_mascara(this,'###.###.###-##')" name="cpf" class="form-control" id="cpf" type="text" size="40"/>
   
<button type="submit" class="btn btn-default" name="enviar" >
    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Enviar
  </button>

    </br>
</div>
   </form>

   <a type="button" class="btn btn-primary" style="margin-top: 10%" href="index.php">Voltar</a>

    
</fieldset>

 <footer id="rodape" style="margin-top: 10%;">
       <span>CEI - CENTRO DE ENSINO DE ITACOATIARA <br> Todos os direitos reservados</span>
        <span style="font-weight:bold;"><br>cei.itacoatiara2017@zipmail.com.br</span>
    </footer>

</body>
</html>

<script type="text/javascript">

// criar máscara conforme o campo
function formatar_mascara(src, mascara) {
 var campo = src.value.length;
 var saida = mascara.substring(0,1);
 var texto = mascara.substring(campo);
 if(texto.substring(0,1) != saida) {
 src.value += texto.substring(0,1);
 }
}

</script>