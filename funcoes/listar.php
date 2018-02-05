<?php
//inicia a sessão
session_start();
// inicia a conexão com o banco
include_once "conexao.php";
$pdo = conectar();

// listar todas as disciplinas
if ($_POST['funcao']=="disciplinas") {
	
$curs = $_POST['id'];

$listarD = $pdo->query("SELECT * FROM disciplina WHERE curso_idcurso = '$curs'");

  while($ln = $listarD->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar){

echo "<option value='".$listar->iddisciplina."'>".$listar->descricao_disciplina."</option>";

}}
}

// listar todas as turmas
if ($_POST['funcao']=="turmas") {
	
$curs = $_POST['id'];

$listarT = $pdo->query("SELECT * FROM turma WHERE curso_idcurso = '$curs'");

  while($ln = $listarT->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar){

echo "<option value='".$listar->idturma."'>".$listar->turma_descricao."</option>";

}}
}

// listar todos os alunos
if ($_POST['funcao']=="alunos") {
	
$turma = $_POST['id'];

$listarA = $pdo->query("SELECT * FROM aluno WHERE turma_idturma = '$turma'");

  while($ln = $listarA->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar2){

echo "<option value='".$listar2->idaluno."'>".$listar2->nome."</option>";

}}
}



?>