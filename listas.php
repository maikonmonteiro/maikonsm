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
  <legend class="legenda">Listas</legend>
  <div>
  
  
  <form method="post" class="form-inline">

  <div style="margin-left: 5%;">

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


    <label for="turma" style="margin-left: 1%;">Turma</label>
    <select style="width: 13%;" class="form-control" name="turma" id="turma"> 

     <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();


      $listarC = $pdo->query("SELECT * FROM curso LIMIT 1"); // buscar o primeiro curso
      $pcurso = $listarC->fetch(PDO::FETCH_ASSOC);

      $listarT = $pdo->query("SELECT * FROM turma WHERE curso_idcurso = '".$pcurso["idcurso"]."'");
      while($ln = $listarT->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar2){

         ?>
         <option value="<?=$listar2->idturma;?>"><?=$listar2->turma_descricao;?></option>

         <?php
       }}
       ?>

        </select>

        <label for="disciplina" style="margin-left: 1%;">Disciplina</label>
    <select class="form-control" style="width: 20%;" name="disciplina" id="disciplina"> 

     <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();

      $listarD = $pdo->query("SELECT * FROM disciplina WHERE curso_idcurso = '".$pcurso["idcurso"]."'");
      while($ln = $listarD->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar4){

         ?>
         <option value="<?=$listar4->iddisciplina;?>"><?=$listar4->descricao_disciplina;?></option>

         <?php
       }}
       ?>

        </select>

        <label for="instituicao" style="margin-left: 1%;">Instituição</label>
    <select style="width: 130px;" class="form-control" name="instituicao" id="instituicao"> 
         <option value="acao">Ação</option>
         <option value="afirmativo">Afirmativo</option>
         <option value="ebs">EBS</option>
         <option value="facel">Facel</option>
         <option value="fama">Fama</option>
         <option value="fasvipa">Fasvipa</option>
         <option value="fatesf">Fatesf</option>
         <option value="spei">Spei</option>
        </select>

        </br>

        <div style="margin-top: 10%; margin-left: 18%;">


        <!--		
        
        <a type="button" id="novo" class="btn btn-primary btn-xs" onclick="lista_por_turma(document.getElementById('curso').options[document.getElementById('curso').selectedIndex].text)">Lista por turma</a>
    -->
       	<a type="button" id="novo" class="btn btn-primary" onclick="diario_academico(document.getElementById('turma').value, document.getElementById('disciplina').value, 'branco', document.getElementById('turma').options[document.getElementById('turma').selectedIndex].text, document.getElementById('disciplina').options[document.getElementById('disciplina').selectedIndex].text, document.getElementById('instituicao').value)">Gerar Diário Acadêmico em branco</a>

       	<a type="button" id="novo" class="btn btn-primary" style="margin-left: 3%;" onclick="diario_academico(document.getElementById('turma').value, document.getElementById('disciplina').value, 'notas', document.getElementById('turma').options[document.getElementById('turma').selectedIndex].text, document.getElementById('disciplina').options[document.getElementById('disciplina').selectedIndex].text, document.getElementById('instituicao').value)">Gerar Diário Acadêmico com notas</a>
        
        </div>

        </div>

  </form>
</fieldset>

</body>
</html>

<script type="text/javascript">

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

function diario_academico(turma, disciplina, tipo, t_desc, d_desc, inst){ 
window.open("diario_academico.php?t="+turma+"&d="+disciplina+"&tipo="+tipo+"&t_desc="+t_desc+"&d_desc="+d_desc+"&institu="+inst);
}


</script>

