<?php
  session_start();
  if(!isset($_SESSION['login']) and !isset($_SESSION['senha']) and !isset($_SESSION['idaluno'])){
  header("Location: index.php");
  exit;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <!-- Bootstrap -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

<fieldset class="form-inline" style="margin-left: 5%; margin-top: 1%;">
  <legend class="legenda">Home</legend>
  <div>

  <!-- exemplos
<div class="panel panel-primary">...</div>
<div class="panel panel-success">...</div>
<div class="panel panel-info">...</div>
<div class="panel panel-warning">...</div>
<div class="panel panel-danger">...</div>

-->

  <!--Mural de notícias-->
<div class="panel panel-success" style="width: 600px; margin-top: 2%; position: absolute;">
  <div class="panel-heading">MURAL</div>
  <div class="panel-body">

  <form method="post" action="funcoes/mural_f.php?f=salvar">
    
<?php
include_once "funcoes/conexao.php";
     $pdo=conectar();
// buscar texto
      $BuscarTexto = $pdo->query("SELECT * FROM mural WHERE idmural = 1 LIMIT 1");    
  $texto = $BuscarTexto->fetch(PDO::FETCH_ASSOC);
  
  if($BuscarTexto->rowCount()>0){
?>
<p>

<?php 
$array = str_split($texto["texto_mural"]);
foreach ($array as $x) {
  if ($x == "-") {
    echo "<br />".$x;
  }else{
echo $x;
}
}
?> 

</p>
<?php
}else{
?>
<h5>  Adicione alguma informação</h5>
<?php
}
?>

</form>

  </div>
</div>


<!--Aniversariantes do mês-->
<div class="panel panel-info" style="width: 400px; margin-top: 2%; margin-left: 620px; position: absolute;">
  <div class="panel-heading">ANIVERSARIANTES DO MÊS</div>
  <div class="panel-body">

 <?php   
include_once "funcoes/conexao.php";
     $pdo=conectar();
 $buscaralunos = $pdo->prepare("SELECT * FROM aluno");
 $buscaralunos->execute();
 $data_atual = date("m");
 $nascimento = "";
 $cont = 0;

  $ln = $buscaralunos->fetchALL(PDO::FETCH_OBJ);

  foreach($ln as $listar1){
      
  ?>
<p>
  <?php
  $array1 = str_split($listar1->nascimento);
  foreach ($array1 as $x1) {
    if ($cont==3) {
      $nascimento = $nascimento.$x1;
    }
    if ($cont==4) {
      $nascimento = $nascimento.$x1;
      break;
    }
$cont++;
  }

  if ($nascimento==$data_atual) {
    echo "-> ".$listar1->nome." (".$listar1->nascimento.")";
  }
  $nascimento = "";
 $cont = 0;
  ?>

</p>
  <?php
}
  ?>

  </div>
</div>


  </div>


</fieldset>

</body>
</html>