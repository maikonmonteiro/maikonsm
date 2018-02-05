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

<fieldset class="form-inline" style="margin-left: 5%; margin-top: 3%; width: 90%;">
  <legend class="legenda">Notas</legend>
  <div style="padding: 0% 2% 2% 2%;">

  <?php
if (isset($_SESSION['idaluno'])) {
  
  ?>

 <a type="button" style="margin-left: 5%; margin-top: 5%;" id="novo" class="btn btn-primary" onclick="boletim('<?php echo $_SESSION['idaluno']; ?>')">Gerar meu boletim</a>

 <?php
}else{
  echo "Erro ao carregar o Id do Aluno!";
}
 ?>

  </div>


</fieldset>

</body>
</html>

<script type="text/javascript">

function boletim(novo){
  var idc = novo; 
window.open("boletim.php?id="+idc);
}

</script>