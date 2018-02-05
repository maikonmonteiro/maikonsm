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
  <legend class="legenda">Mudar Senha</legend>
  <div style="padding: 0% 2% 2% 2%;">
  
  
   <!--mudar senha do aluno-->
<div class="panel panel-success" style="width: 40%; margin-top: 2%; margin-left: 30%;">
  <div class="panel-heading">Mudar minha senha</div>
  <div class="panel-body">
    
<form method="post" class="form-inline" action="funcoes/alunos_f.php?f=mudar_senha&id=<?=$_SESSION['idaluno']?>">

  <label for="senha_antiga" >Senha antiga</label>
    <input class="form-control" name="senha_antiga" id="senha_antiga" type="text" size="20"/><span style="color:red;">*</span> </br>

    <label for="nova_senha" style="margin-left: 7px;">Nova senha</label>
    <input class="form-control" style="margin-top: 2%;" name="nova_senha" id="nova_senha" type="text" size="20"/><span style="color:red;">*</span> </br>

    <div align="right" style="margin-top: 5%;">
  <button type="submit" class="btn btn-default" name="salvar" >
  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Salvar
</button>
</div>

</form>

  </div>
</div>
  
  
</div>

</fieldset>

</body>
</html>

<script type="text/javascript">

$('#pesquisar').keydown(function(){
        var encontrou = false;
        var termo = $(this).val().toLowerCase();
        $('table > tbody > tr').each(function(){
          $(this).find('td').each(function(){
            if($(this).text().toLowerCase().indexOf(termo) > -1) encontrou = true;
          });
          if(!encontrou) $(this).hide();
          else $(this).show();
          encontrou = false;
        });
      });

function teste(){
  document.getElementById("nome").value = "";

}

</script>

