<?php
session_start();
if(!isset($_SESSION['login']) and !isset($_SESSION['senha'])){
header("Location: index.php");
exit; 
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

<fieldset class="form-inline" style="margin-left: 5%; margin-top: 3%; width: 90%;">
  <legend class="legenda">Histórico de Pagamentos do Aluno</legend>

<?php

include_once "funcoes/conexao.php";
$pdo=conectar();

$id = $_GET['idaluno'];

// buscar aluno
      $listarA = $pdo->query("SELECT * FROM aluno a, turma t, curso c WHERE a.idaluno = '$id' AND a.turma_idturma = t.idturma AND t.curso_idcurso = c.idcurso LIMIT 1");
      $result = $listarA->fetch(PDO::FETCH_ASSOC);

      if ($result>0) {
?>

<p style="font-size: 12px;">
Nome: <b><?=$result["nome"]?></b>  &nbsp;&nbsp;&nbsp;&nbsp; Número de matrícula: <b><?=$result["matricula"]?></b> &nbsp;&nbsp;&nbsp;&nbsp; Curso: <b><?=$result["curso_descricao"]?></b> &nbsp;&nbsp;&nbsp;&nbsp; Turma: <b><?=$result["turma_descricao"]?></b> </br></br>
CPF: <b><?=$result["cpf"]?></b> &nbsp;&nbsp;&nbsp;&nbsp; RG: <b><?=$result["rg"]?></b> &nbsp;&nbsp;&nbsp;&nbsp; Nascimento: <b><?=$result["nascimento"]?></b> &nbsp;&nbsp;&nbsp;&nbsp; Telefone: <b><?=$result["telefone"]?></b> &nbsp;&nbsp;&nbsp;&nbsp; Email: <b><?=$result["email"]?></b>

</p>

<?php
}
?>


<div style="margin-top: 3%;">
  <label for="pesquisar" >Pesquisar</label>
  <input style="width: 200px;" type="text" class="form-control" id="pesquisar" name="pesquisar" />


  <div style="border: 1px solid #777; margin-top: 1%; width: 810px;">
   <table>
   <thead>
  <tr style="background-color: #eee; height: 30px;">
    <th style="width: 70px; text-align: center;">Item</th>
    <th style="width: 150px; text-align: center;">Núm. Boleto</th>
    <th style="width: 140px; text-align: center;">Vencimento</th>
    <th style="width: 130px; text-align: center;">Valor</th>
    <th style="width: 100px; text-align: center;">Pago</th>
    <th style="width: 110px; text-align: center;">Boleto</th>
    <th style="width: 110px; text-align: center;">Remessa</th>
  </tr>
  </thead>
</table>

  <div style="overflow: auto; height: 220px;">
   <table cellspacing="0" class="table table-striped">
  
  <tbody>
  
    <?php 
  include_once "funcoes/conexao.php";
  $pdo=conectar();
  $cont = 0;
  $listarBoletos = $pdo->query("SELECT * FROM boleto WHERE aluno_idaluno = '$id'");

  while($ln = $listarBoletos->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar){

  ?>
    <tr>
    <td style="width: 70px; text-align: center;"><?=$cont+1?></td>
    <td style="width: 150px; text-align: center;"><?=$listar->numero_boleto?></td>
    <td style="width: 140px; text-align: center;"><?=$listar->data_vencimento?></td>
    <td style="width: 130px; text-align: center;"><?=$listar->valor_boleto?></td>
    <td style="width: 100px; text-align: center; color: red;">não</td>
    <td style="width: 110px; text-align: center;"> <a type="button" id="novo" onclick="pegar('buscar', '<?=$listar->idboleto?>')" target="_blank" class="btn btn-primary btn-xs">exibir</a> </td>

    <?php
  if($listar->arq_remessa == "sim"){
?>

    <td style="width: 110px; text-align: center;"> <a type="button" disabled="true" id="novo" href="#" class="btn btn-primary btn-xs">enviar</a> </td>

<?php
  }else{
?>

<td style="width: 110px; text-align: center;"> <a type="button" id="novo" href="arquivo_remessa/teste.php?id=<?=$listar->idboleto;?>" class="btn btn-primary btn-xs">enviar</a> </td>

<?php
  }
?>

  </tr>

<?php
  $cont++; }}
?>
</tbody>
</table>
</div>
</div>
</div>


<a type="button" class="btn btn-primary" style="margin-top: 1%" href="financeiro.php">Voltar</a>
  
</fieldset>

</body>
</html>

<script type="text/javascript">

  function pegar(f, id){
//w=document.getElementById("vencimento").value;
 window.open('gerar_boleto.php?funcao='+f+'&id_boleto='+id, '_blank');
}

</script>

