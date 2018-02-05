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
  <legend class="legenda">Notas</legend>
  <div>
  
  <?php
  
  if(!isset($_GET['funcao'])=="editar")
  {
  
  ?>
  
  <form method="post" class="form-inline" action="funcoes/notas_f.php?f=cadastrar">

  <div>
   
    <label for="curso">Curso</label>
    <select class="form-control" name="curso" id="curso" style="width: 20%;">   

      <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarcurso = $pdo->query("SELECT * FROM curso");
      
      while($ln = $listarcurso->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar1){

         ?>
         <option value="<?=$listar1->idcurso;?>"><?=$listar1->curso_descricao;?></option>

         <?php
       }}
       ?>

 </select>

 <label for="disciplina" style="margin-left: 1%;">Disciplina</label>
    <select class="form-control" style="width: 20%;" name="disciplina" id="disciplina"> 

     <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();

      $listarC = $pdo->query("SELECT * FROM curso LIMIT 1"); // buscar o primeiro curso
      $pcurso = $listarC->fetch(PDO::FETCH_ASSOC);

      $listarD = $pdo->query("SELECT * FROM disciplina WHERE curso_idcurso = '".$pcurso["idcurso"]."'");
      while($ln = $listarD->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar4){

         ?>
         <option value="<?=$listar4->iddisciplina;?>"><?=$listar4->descricao_disciplina;?></option>

         <?php
       }}
       ?>

        </select>

    <label for="turma" style="margin-left: 1%;">Turma</label>
    <select style="width: 13%;" class="form-control" name="turma" id="turma"> 

     <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();

      $listarT = $pdo->query("SELECT * FROM turma WHERE curso_idcurso = '".$pcurso["idcurso"]."'");
      while($ln = $listarT->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar2){

         ?>
         <option value="<?=$listar2->idturma;?>"><?=$listar2->turma_descricao;?></option>

         <?php
       }}
       ?>

        </select>


         <label for="aluno" style="margin-left: 1%;">Aluno</label>
    <select style="width: 20%;" class="form-control" name="aluno" id="aluno"> 

     <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarTurma = $pdo->query("SELECT * FROM turma LIMIT 1"); // buscar a primeira turma
      $pturma = $listarTurma->fetch(PDO::FETCH_ASSOC);

      $listarA = $pdo->query("SELECT * FROM aluno WHERE turma_idturma = '".$pturma["idturma"]."'");
      while($ln = $listarA->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar3){

         ?>
         <option value="<?=$listar3->idaluno;?>"><?=$listar3->nome;?></option>

         <?php
       }}
       ?>

        </select>

         
         </br> 


    <!--Frequência-->
<div class="panel panel-success" style="width: 30%; margin-top: 2%; float: left;">
  <div class="panel-heading">FREQUÊNCIA</div>
  <div class="panel-body">
    
<input class="form-control" style="" maxlength="10" onkeypress="formatar_mascara(this,'##/##/####')" name="data1" id="data1" type="text" size="10" placeholder="Data 1" /> <span> - </span>
<input class="form-control" style="" name="freq1" id="freq1" type="text" size="1" placeholder="P/F" /> </br>

<input class="form-control" style="margin-top: 2px;" maxlength="10" onkeypress="formatar_mascara(this,'##/##/####')" name="data2" id="data2" type="text" size="10" placeholder="Data 2" /> <span> - </span>
<input class="form-control" style="margin-top: 2px;" name="freq2" id="freq2" type="text" size="1" placeholder="P/F" /> </br>

<input class="form-control" style="margin-top: 2px;"maxlength="10" onkeypress="formatar_mascara(this,'##/##/####')" name="data3" id="data3" type="text" size="10" placeholder="Data 3" /> <span> - </span>
<input class="form-control" style="margin-top: 2px;" name="freq3" id="freq3" type="text" size="1" placeholder="P/F" /> 

  </div>
</div>

 <!--Notas-->
<div class="panel panel-success" style="width: 35%; margin-top: 2%; float: left; margin-left: 4%;">
  <div class="panel-heading">NOTAS</div>
  <div class="panel-body">
    
<input class="form-control" style="" name="nota1" id="nota1" type="text" size="3" placeholder="Nota 1" />
<input class="form-control" style="" name="nota2" id="nota2" type="text" size="3" placeholder="Nota 2" />
<input class="form-control" style="" name="nota3" id="nota3" type="text" size="3" placeholder="Nota 3" /> </br>
<button class="btn btn-primary btn-xs" type="button" onclick="javascript:calculo_media();" style="margin-top: 10px;">Calcular</button>

<div style="margin-left: 17%; margin-top: 5px;">
<label for="media">Média</label>
<input class="form-control" name="media" id="media" type="text" size="3" value="0"/>
</div>

  </div>
</div>
  

        </div>
     
  <div align="right" style="margin-top: 20%; margin-right: 5%;">
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
  $buscarnota = $pdo->prepare("SELECT * FROM nota n, aluno a, turma t, curso c, disciplina d WHERE idnota = :id AND n.aluno_idaluno = a.idaluno AND a.turma_idturma = t.idturma AND t.curso_idcurso = c.idcurso AND n.disciplina_iddisciplina = d.iddisciplina");
  $buscarnota->bindValue(":id",$_GET['id']);
  $buscarnota->execute();

  $ln = $buscarnota->fetchALL(PDO::FETCH_OBJ);

  foreach($ln as $listar){
      
  ?>
  
  <form method="post" class="form-inline" action="funcoes/notas_f.php?f=editar&id=<?=$listar->idnota?>">

   <div style="margin-left: 3%;">
   
    <label for="curso">Curso</label>
    <select class="form-control" name="curso" id="curso" style="width: 20%;" disabled="true">   
    <option value="<?=$listar->idcurso?>"><?=$listar->curso_descricao?></option>
      <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarcurso = $pdo->query("SELECT * FROM curso");
      
      while($ln = $listarcurso->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar1){

         ?>
         <option value="<?=$listar1->idcurso;?>"><?=$listar1->curso_descricao;?></option>

         <?php
       }}
       ?>

 </select>

 <label for="disciplina" style="margin-left: 1%;">Disciplina</label>
    <select class="form-control" style="width: 20%;" name="disciplina" id="disciplina" disabled="true">
    <option value="<?=$listar->iddisciplina?>"><?=$listar->descricao_disciplina?></option> 

     <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();

      $listarC = $pdo->query("SELECT * FROM curso LIMIT 1"); // buscar o primeiro curso
      $pcurso = $listarC->fetch(PDO::FETCH_ASSOC);

      $listarD = $pdo->query("SELECT * FROM disciplina WHERE curso_idcurso = '".$pcurso["idcurso"]."'");
      while($ln = $listarD->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar4){

         ?>
         <option value="<?=$listar4->iddisciplina;?>"><?=$listar4->descricao_disciplina;?></option>

         <?php
       }}
       ?>

        </select>

    <label for="turma" style="margin-left: 1%;">Turma</label>
    <select style="width: 13%;" class="form-control" name="turma" id="turma" disabled="true"> 
      <option value="<?=$listar->idturma?>"><?=$listar->turma_descricao?></option>
     <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();

      $listarT = $pdo->query("SELECT * FROM turma WHERE curso_idcurso = '$listar->idcurso'");
      while($ln = $listarT->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar2){

         ?>
         <option value="<?=$listar2->idturma;?>"><?=$listar2->turma_descricao;?></option>

         <?php
       }}
       ?>

        </select>


         <label for="aluno" style="margin-left: 1%;">Aluno</label>
    <select style="width: 20%;" class="form-control" name="aluno" id="aluno" disabled="true"> 
    <option value="<?=$listar->idaluno?>"><?=$listar->nome?></option>
     <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();

      $listarA = $pdo->query("SELECT * FROM aluno WHERE turma_idturma = '$listar->idturma'");
      while($ln = $listarA->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar3){

         ?>
         <option value="<?=$listar3->idaluno;?>"><?=$listar3->nome;?></option>

         <?php
       }}
       ?>

        </select>

         </br> 


    <!--Frequência-->
<div class="panel panel-success" style="width: 30%; margin-top: 2%; float: left;">
  <div class="panel-heading">FREQUÊNCIA</div>
  <div class="panel-body">
    
<input class="form-control" style="" maxlength="10" onkeypress="formatar_mascara(this,'##/##/####')" name="data1" id="data1" type="text" size="10" placeholder="Data 1" value="<?=$listar->data1?>"/> <span> - </span>
<input class="form-control" style="" name="freq1" id="freq1" type="text" size="1" placeholder="P/F" value="<?=$listar->freq1?>"/> </br>

<input class="form-control" style="margin-top: 2px;" maxlength="10" onkeypress="formatar_mascara(this,'##/##/####')" name="data2" id="data2" type="text" size="10" placeholder="Data 2" value="<?=$listar->data2?>"/> <span> - </span>
<input class="form-control" style="margin-top: 2px;" name="freq2" id="freq2" type="text" size="1" placeholder="P/F" value="<?=$listar->freq2?>"/> </br>

<input class="form-control" style="margin-top: 2px;" maxlength="10" onkeypress="formatar_mascara(this,'##/##/####')" name="data3" id="data3" type="text" size="10" placeholder="Data 3" value="<?=$listar->data3?>"/> <span> - </span>
<input class="form-control" style="margin-top: 2px;" name="freq3" id="freq3" type="text" size="1" placeholder="P/F" value="<?=$listar->freq3?>"/> 

  </div>
</div>

 <!--Notas-->
<div class="panel panel-success" style="width: 35%; margin-top: 2%; float: left; margin-left: 4%;">
  <div class="panel-heading">NOTAS</div>
  <div class="panel-body">
    
<input class="form-control" style="" name="nota1" id="nota1" type="text" size="3" placeholder="Nota 1" value="<?=$listar->nota1?>"/>
<input class="form-control" style="" name="nota2" id="nota2" type="text" size="3" placeholder="Nota 2" value="<?=$listar->nota2?>"/>
<input class="form-control" style="" name="nota3" id="nota3" type="text" size="3" placeholder="Nota 3" value="<?=$listar->nota3?>"/> </br>
<button class="btn btn-primary btn-xs" type="button" onclick="javascript:calculo_media();" style="margin-top: 10px;">Calcular</button>

<div style="margin-left: 17%; margin-top: 5px;">
<label for="media">Média</label>
<input class="form-control" name="media" id="media" type="text" size="3" value="<?=$listar->media?>"/>
</div>

  </div>
</div>
  

        </div>
     
  <div align="right" style="margin-top: 20%; margin-right: 5%;">
  <button type="submit" class="btn btn-default" name="salvar" >
  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Salvar
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

<div>
  <label for="pesquisar">Pesquisar</label>
  <input type="text" class="form-control" id="pesquisar" name="pesquisar" />


  <div style="border: 1px solid #777; margin-top: 1%; width: 1020px;">
   <table>
   <thead>
  <tr style="background-color: #eee; height: 30px;">
    <th style="width: 80px; text-align: center;">Ações</th>
    <th style="width: 320px; text-align: center;">Aluno</th>
    <th style="width: 130px; text-align: center;">Curso</th>
    <th style="width: 180px; text-align: center;">Turma</th>
    <th style="width: 310px; text-align: center;">Disciplina</th>
  </tr>
  </thead>
</table>

  <div style="overflow: auto; height: 110px;">
   <table cellspacing="0" class="table table-striped">
  
  <tbody>
  
    <?php 
  include_once "funcoes/conexao.php";
  $pdo=conectar();
  $listarnotas = $pdo->query("SELECT * FROM nota n, aluno a, turma t, curso c, disciplina d WHERE n.aluno_idaluno = a.idaluno AND a.turma_idturma = t.idturma AND t.curso_idcurso = c.idcurso AND n.disciplina_iddisciplina = d.iddisciplina ORDER BY a.nome");

  while($ln = $listarnotas->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar4){

  ?>
    <tr>
    <td style="width: 80px; text-align: center;">
    <a style="margin-right: 8%;" href="funcoes/notas_f.php?f=excluir&id=<?=$listar4->idnota;?>"><img src="img/deletar.png" width="16" height="16"/></a>
    <a href="notas.php?funcao=editar&id=<?=$listar4->idnota;?>"><img src="img/editar.png" width="16" height="16" /></a>    
    </td>    
    <td style="width: 320px;"><?=$listar4->nome?></td>
    <td style="width: 130px; text-align: center;"><?=$listar4->curso_descricao?></td>
    <td style="width: 180px; text-align: center;"><?=$listar4->turma_descricao?></td>
    <td style="width: 310px;"><?=$listar4->descricao_disciplina?></td>
    
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

// criar máscara conforme o campo
function formatar_mascara(src, mascara) {
 var campo = src.value.length;
 var saida = mascara.substring(0,1);
 var texto = mascara.substring(campo);
 if(texto.substring(0,1) != saida) {
 src.value += texto.substring(0,1);
 }
}


 $(document).ready(function() {

  // carregar as disciplinas conforme a seleção do curso
        $('#curso').change(function(e) {
            var selecao = $(this).val();

            $.post('funcoes/listar.php', {
           id: selecao,
           funcao: "disciplinas"
       }, function(response){
           $('#disciplina').empty().append(response);

       });
            
        });


  // carregar as turmas conforme a seleção do curso
        $('#curso').change(function(e) {
            var selecao = $(this).val();

            $.post('funcoes/listar.php', {
           id: selecao,
           funcao: "turmas"
       }, function(response){
           $('#turma').empty().append(response);

       });
        $('#aluno').empty();
            
        });

// carregar os alunos conforme a seleção das turmas
         $('#turma').change(function(e) {
            var selecao = $(this).val();

            $.post('funcoes/listar.php', {
           id: selecao,
           funcao: "alunos"
       }, function(response){
           $('#aluno').empty().append(response);

       });
            
        });

    });


// pesquisa dinâmica
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

// calcula a média dinamicamente
function calculo_media(){
  if (document.getElementById("nota1").value != "" && document.getElementById("nota2").value != ""){
        var n1 = parseFloat(document.getElementById("nota1").value);
        var n2 = parseFloat(document.getElementById("nota2").value);
        var n3 = parseFloat(document.getElementById("nota3").value);
        var media = parseFloat((n1+n2+n3)/3);
        document.getElementById("media").value = media.toFixed(1);
       }
      };

function teste(){
  document.getElementById("disciplina").value = "";
  document.getElementById("data1").value = "";
  document.getElementById("data2").value = "";
  document.getElementById("data3").value = "";
  document.getElementById("freq1").value = "";
  document.getElementById("freq2").value = "";
  document.getElementById("freq3").value = "";
  document.getElementById("nota1").value = "";
  document.getElementById("nota2").value = "";
  document.getElementById("nota3").value = "";
  document.getElementById("media").value = "0";

}

</script>

