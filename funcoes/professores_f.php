<?php
//inicia a sessão
session_start();
// inicia a conexão com o banco
include_once "conexao.php";
$pdo = conectar();

// função cadastrar professor
if($_GET['f'] == "cadastrar"){

	$nom = $pdo->prepare("SELECT * FROM professor WHERE nome = :nome AND titulacao = :titulacao");
	$nom->bindValue(":nome", $_POST['nome']);
	$nom->bindValue(":titulacao", $_POST['titulacao']);
	$nom->execute();

	if($nom->rowCount()>0){
		echo "<meta http-equiv='refresh' content='0; URL=../professores.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Nome com titulacao ja existe!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
	}else{
		
		if($_POST['nome']=="" && $_POST['titulacao']==""){

			echo "<meta http-equiv='refresh' content='0; URL=../professores.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{

	$inserirprofessor = $pdo->prepare("INSERT INTO professor (nome, titulacao) VALUES (:nome, :titulacao)");
	$inserirprofessor->bindValue(":nome", $_POST['nome']);
	$inserirprofessor->bindValue(":titulacao", $_POST['titulacao']);
	$inserirprofessor->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../professores.php'>
		<script type=\"text/javascript\">
		alert(\"Professor Cadastrado com sucesso!\");
		</script>";
		}
}
}

// função editar Professor
if($_GET['f'] == "editar"){ 

	if($_POST['nome']=="" && $_POST['titulacao']==""){
			echo "<meta http-equiv='refresh' content='0; URL=../professores.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{  
	
	$editarprofessor = $pdo->prepare("UPDATE professor SET nome = :nome, titulacao = :titulacao WHERE idprofessor = :id");

	$editarprofessor->bindValue(":nome", $_POST['nome']);
	$editarprofessor->bindValue(":titulacao", $_POST['titulacao']);
	$editarprofessor->bindValue(":id", $_GET['id']);
	$editarprofessor->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../professores.php'>
		<script type=\"text/javascript\">
		alert(\"Professor Editado com sucesso!\");
		</script>";	
		}
}

// função excluir Professor
if($_GET['f'] == "excluir"){   
	
	$excluirprofessor = $pdo->prepare("DELETE FROM professor WHERE idprofessor = :id");
	$excluirprofessor->bindValue(":id", $_GET['id']);
	$excluirprofessor->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../professores.php'>
		<script type=\"text/javascript\">
		alert(\"Professor excluido com sucesso!\");
		</script>";	
}

?>