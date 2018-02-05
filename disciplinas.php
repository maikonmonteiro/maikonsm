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
  <legend class="legenda">Disciplinas</legend>
  <div>
  
  <?php
  
  if(!isset($_GET['funcao'])=="editar")
  {
  
  ?>
  
  <form method="post" class="form-inline" action="funcoes/disciplinas_f.php?f=cadastrar">

  <div style="">

  <label for="curso" style="margin-top: 1%; margin-left: 1%;">Curso</label>
    <select style="margin-top: 1%; width: 230px;" class="form-control" name="curso" id="curso">   

      <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarcurso = $pdo->query("SELECT * FROM curso");

      while($ln = $listarcurso->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar){

         ?>
         <option value="<?=$listar->idcurso;?>"><?=$listar->curso_descricao;?></option>

         <?php
       }}
       ?>

     </select>

     <label for="professor" style="margin-top: 1%; margin-left: 1%;">Professor</label>
    <select style="margin-top: 1%; width: 250px;" class="form-control" name="professor" id="professor">   

      <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarProfessores = $pdo->query("SELECT * FROM professor");

      while($ln = $listarProfessores->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar2){

         ?>
         <option value="<?=$listar2->idprofessor;?>"><?=$listar2->nome;?></option>

         <?php
       }}
       ?>

     </select> 
   
    <label for="descricao" style="margin-top: 1%; margin-left: 1%;">Descrição</label>
    <input class="form-control" style="width: 300px; margin-top: 1%;" name="descricao" id="descricao" type="text" size="30"/><span style="color:red;">*</span> </br>

    <label for="ementa" style="">Ementa</label>
    <textarea style="margin-top: 2%; width: 500px; resize: none;" name="ementa" id="ementa" rows="2"></textarea>
  
     
  <button type="submit" class="btn btn-default" name="salvar" style="margin-left: 4%;">
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
  $buscardisciplinas = $pdo->prepare("SELECT * FROM disciplina d, curso c, professor p WHERE d.iddisciplina = :id AND d.curso_idcurso = c.idcurso AND d.professor_idprofessor = p.idprofessor");
  $buscardisciplinas->bindValue(":id",$_GET['id']);
  $buscardisciplinas->execute();

  $ln = $buscardisciplinas->fetchALL(PDO::FETCH_OBJ);

  foreach($ln as $listar3){
      
  ?>
  
  <form method="post" class="form-inline" action="funcoes/disciplinas_f.php?f=editar&id=<?=$listar3->iddisciplina?>">

  <div style="">

  <label for="curso" style="margin-top: 1%; margin-left: 1%;">Curso</label>
    <select style="margin-top: 1%; width: 230px;" class="form-control" name="curso" id="curso">   
      <option value="<?=$listar3->idcurso?>"><?=$listar3->curso_descricao?></option>
      <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarcurso = $pdo->query("SELECT * FROM curso");

      while($ln = $listarcurso->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar4){

         ?>
         <option value="<?=$listar4->idcurso;?>"><?=$listar4->curso_descricao;?></option>

         <?php
       }}
       ?>

     </select>

     <label for="professor" style="margin-top: 1%; margin-left: 1%;">Professor</label>
    <select style="margin-top: 1%; width: 250px;" class="form-control" name="professor" id="professor">   
      <option value="<?=$listar3->idprofessor?>"><?=$listar3->nome?></option>
      <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarProfessores = $pdo->query("SELECT * FROM professor");

      while($ln = $listarProfessores->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar5){

         ?>
         <option value="<?=$listar5->idprofessor;?>"><?=$listar5->nome;?></option>

         <?php
       }}
       ?>

     </select> 
   
    <label for="descricao" style="margin-top: 1%; margin-left: 1%;">Descrição</label>
    <input class="form-control" style="width: 300px; margin-top: 1%;" name="descricao" id="descricao" type="text" size="30" value="<?=$listar3->descricao_disciplina?>"/><span style="color:red;">*</span> </br>

    <label for="ementa" style="">Ementa</label>
    <textarea style="margin-top: 2%; width: 500px; resize: none;" name="ementa" id="ementa" rows="2"><?=$listar3->ementa?></textarea>
  
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

<div style="margin-top: 5%; margin-left: 10%;">
  <label for="pesquisar" >Pesquisar</label>
  <input style="width: 25%;" type="text" class="form-control" id="pesquisar" name="pesquisar" />


  <div style="border: 1px solid #777; margin-top: 1%; width: 700px;">
   <table>
   <thead>
  <tr style="background-color: #eee; height: 30px;">
    <th style="width: 90px; text-align: center;">Ações</th>
    <th style="width: 220px; text-align: center;">Descrição</th>
    <th style="width: 200px; text-align: center;">Curso</th>
    <th style="width: 190px; text-align: center;">Professor</th>
  </tr>
  </thead>
</table>

  <div style="overflow: auto; height: 190px;">
   <table cellspacing="0" class="table table-striped">
  
  <tbody>
  
    <?php 
  include_once "funcoes/conexao.php";
  $pdo=conectar();
  $listardisciplinas = $pdo->query("SELECT * FROM disciplina d, curso c, professor p WHERE d.curso_idcurso = c.idcurso AND d.professor_idprofessor = p.idprofessor");

  while($ln = $listardisciplinas->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar){

  ?>
    <tr>
    <td style="width: 90px; text-align: center;">
    <a style="margin-right: 10%;" href="funcoes/disciplinas_f.php?f=excluir&id=<?=$listar->iddisciplina;?>"><img src="img/deletar.png" width="16" height="16"/></a>
    <a href="disciplinas.php?funcao=editar&id=<?=$listar->iddisciplina;?>"><img src="img/editar.png" width="16" height="16" /></a>    
    </td>
    
    <td style="width: 220px;"><?=$listar->descricao_disciplina?></td>
    <td style="width: 220;"><?=$listar->curso_descricao?></td>
    <td style="width: 190;"><?=$listar->nome?></td>
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
   document.getElementById("ementa").value = "";

}

</script>

