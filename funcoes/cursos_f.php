<?php
//inicia a sessão
session_start();
// inicia a conexão com o banco
include_once "conexao.php";
$pdo = conectar();

// função cadastrar curso
if($_GET['f'] == "cadastrar"){

	$desc = $pdo->prepare("SELECT * FROM curso WHERE curso_descricao = :descricao");
	$desc->bindValue(":descricao", $_POST['descricao']);
	$desc->execute();

	if($desc->rowCount()>0){
		echo "<meta http-equiv='refresh' content='0; URL=../cursos.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Curso ja existe!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
	}else{
		
		if($_POST['descricao']==""){

			echo "<meta http-equiv='refresh' content='0; URL=../cursos.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{

	$inserircurso = $pdo->prepare("INSERT INTO curso (curso_descricao) VALUES (:descricao)");
	$inserircurso->bindValue(":descricao", $_POST['descricao']);
	$inserircurso->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../cursos.php'>
		<script type=\"text/javascript\">
		alert(\"Curso Cadastrado com sucesso!\");
		</script>";
		}
}
}

// função editar Curso
if($_GET['f'] == "editar"){ 

	if($_POST['descricao']==""){
			echo "<meta http-equiv='refresh' content='0; URL=../cursos.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{  
	
	$editarcurso = $pdo->prepare("UPDATE curso SET curso_descricao = :descricao WHERE idcurso = :id");

	$editarcurso->bindValue(":descricao", $_POST['descricao']);
	$editarcurso->bindValue(":id", $_GET['id']);
	$editarcurso->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../cursos.php'>
		<script type=\"text/javascript\">
		alert(\"Curso Editado com sucesso!\");
		</script>";	
		}
}

// função excluir Curso
if($_GET['f'] == "excluir"){   
	
	$excluircurso = $pdo->prepare("DELETE FROM curso WHERE idcurso = :id");
	$excluircurso->bindValue(":id", $_GET['id']);
	$excluircurso->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../cursos.php'>
		<script type=\"text/javascript\">
		alert(\"Curso excluido com sucesso!\");
		</script>";	
}

?>