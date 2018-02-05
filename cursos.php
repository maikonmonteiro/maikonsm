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

<fieldset class="form-inline" style="margin-left: 5%; margin-top: 1%;">
  <legend class="legenda">Cursos</legend>
  <div>
  
  <?php
  
  if(!isset($_GET['funcao'])=="editar")
  {
  
  ?>
  
  <form method="post" class="form-inline" action="funcoes/cursos_f.php?f=cadastrar">

  <div style="margin-left: 20%;">
   
    <label for="descricao" >Descrição</label>
    <input class="form-control" style="width: 300px;" name="descricao" id="descricao" type="text" size="30"/><span style="color:red;">*</span> 
  
     
  <button type="submit" class="btn btn-default" name="salvar" >
  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Salvar
</button>

<button type="button" class="btn btn-default" name="limpar" onclick="teste()">
  <span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Limpar
</button>
</div>

  </form>


   
    <?php
     
  }else{

  include_once "funcoes/conexao.php";
     $pdo=conectar();
  $buscarcurso = $pdo->prepare("SELECT * FROM curso WHERE idcurso = :id");
  $buscarcurso->bindValue(":id",$_GET['id']);
  $buscarcurso->execute();

  $ln = $buscarcurso->fetchALL(PDO::FETCH_OBJ);

  foreach($ln as $listar){
      
  ?>
  
  <form method="post" class="form-inline" action="funcoes/cursos_f.php?f=editar&id=<?=$listar->idcurso?>">

  <div style="margin-left: 20%;">
   
    <label for="descricao" >Descrição</label>
    <input class="form-control" style="width: 300px;" name="descricao" id="descricao" type="text" size="30" value="<?=$listar->curso_descricao?>"/><span style="color:red;">*</span> 
  
  <button type="submit" class="btn btn-default" name="atualizar" >
  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Atualizar
</button>

<button type="button" class="btn btn-default" name="limpar" onclick="teste()">
  <span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Limpar
</button>

</div>
  
  </form>
  
   <?php
  }
  }
      
  ?>
  
  </div> 

<div style="margin-top: 5%; margin-left: 22%;">
  <label for="pesquisar" >Pesquisar</label>
  <input style="width: 25%;" type="text" class="form-control" id="pesquisar" name="pesquisar" />


  <div style="border: 1px solid #777; margin-top: 1%; width: 500px;">
   <table>
   <thead>
  <tr style="background-color: #eee; height: 30px;">
    <th style="width: 90px; text-align: center;">Ações</th>
    <th style="width: 420px; text-align: center;">Descrição</th>
  </tr>
  </thead>
</table>

  <div style="overflow: auto; height: 190px;">
   <table cellspacing="0" class="table table-striped">
  
  <tbody>
  
    <?php 
  include_once "funcoes/conexao.php";
  $pdo=conectar();
  $listarcursos = $pdo->query("SELECT * FROM curso ORDER BY curso_descricao");

  while($ln = $listarcursos->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar){

  ?>
    <tr>
    <td style="width: 90px; text-align: center;">
    <a style="margin-right: 10%;" href="funcoes/cursos_f.php?f=excluir&id=<?=$listar->idcurso;?>"><img src="img/deletar.png" width="16" height="16"/></a>
    <a href="cursos.php?funcao=editar&id=<?=$listar->idcurso;?>"><img src="img/editar.png" width="16" height="16" /></a>    
    </td>
    
    <td style="width: 420px;"><?=$listar->curso_descricao?></td>
  </tr>

<?php
  }}
?>
</tbody>
</table>
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
  document.getElementById("descricao").value = "";

}

</script>

