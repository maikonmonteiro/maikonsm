<?php
//inicia a sessão
session_start();
// inicia a conexão com o banco
include_once "conexao.php";
$pdo = conectar();

// função cadastrar turma
if($_GET['f'] == "cadastrar"){

	$desc = $pdo->prepare("SELECT * FROM turma WHERE turma_descricao = :descricao AND curso_idcurso = :curso");
	$desc->bindValue(":descricao", $_POST['descricao']);
	$desc->bindValue(":curso", $_POST['curso']);
	$desc->execute();

	if($desc->rowCount()>0){
		echo "<meta http-equiv='refresh' content='0; URL=../turmas.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Turma ja existe nesse curso!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
	}else{
		
		if($_POST['descricao']==""){

			echo "<meta http-equiv='refresh' content='0; URL=../turmas.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{

	$inserirturma = $pdo->prepare("INSERT INTO turma (turma_descricao, curso_idcurso) VALUES (:descricao, :curso)");
	$inserirturma->bindValue(":descricao", $_POST['descricao']);
	$inserirturma->bindValue(":curso", $_POST['curso']);
	$inserirturma->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../turmas.php'>
		<script type=\"text/javascript\">
		alert(\"Turma Cadastrada com sucesso!\");
		</script>";
		}
}
}

// função editar turma
if($_GET['f'] == "editar"){ 

	if($_POST['descricao']==""){
			echo "<meta http-equiv='refresh' content='0; URL=../turmas.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{  
	
	$editarturma = $pdo->prepare("UPDATE turma SET turma_descricao = :descricao WHERE idturma = :id");

	$editarturma->bindValue(":descricao", $_POST['descricao']);
	$editarturma->bindValue(":id", $_GET['id']);
	$editarturma->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../turmas.php'>
		<script type=\"text/javascript\">
		alert(\"Turma Editada com sucesso!\");
		</script>";	
		}
}

// função excluir Turma
if($_GET['f'] == "excluir"){   
	
	$excluircurso = $pdo->prepare("DELETE FROM turma WHERE idturma = :id");
	$excluircurso->bindValue(":id", $_GET['id']);
	$excluircurso->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../turmas.php'>
		<script type=\"text/javascript\">
		alert(\"Turma excluida com sucesso!\");
		</script>";	
}


?>