<?php
//inicia a sessão
session_start();
// inicia a conexão com o banco
include_once "conexao.php";
$pdo = conectar();

// função cadastrar disciplina
if($_GET['f'] == "cadastrar"){

	$desc = $pdo->prepare("SELECT * FROM disciplina WHERE descricao_disciplina = :descricao AND curso_idcurso = :curso AND professor_idprofessor = :professor");
	$desc->bindValue(":descricao", $_POST['descricao']);
	$desc->bindValue(":curso", $_POST['curso']);
	$desc->bindValue(":professor", $_POST['professor']);
	$desc->execute();

	if($desc->rowCount()>0){
		echo "<meta http-equiv='refresh' content='0; URL=../disciplinas.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Disciplina ja existe nesse curso com o mesmo professor!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
	}else{
		
		if($_POST['descricao']==""){

			echo "<meta http-equiv='refresh' content='0; URL=../disciplinas.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{

	$inserirturma = $pdo->prepare("INSERT INTO disciplina (descricao_disciplina, curso_idcurso, professor_idprofessor, ementa) VALUES (:descricao, :curso, :professor, :ementa)");
	$inserirturma->bindValue(":descricao", $_POST['descricao']);
	$inserirturma->bindValue(":curso", $_POST['curso']);
	$inserirturma->bindValue(":professor", $_POST['professor']);
	$inserirturma->bindValue(":ementa", $_POST['ementa']);
	$inserirturma->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../disciplinas.php'>
		<script type=\"text/javascript\">
		alert(\"Disciplina Cadastrada com sucesso!\");
		</script>";
		}
}
}

// função editar disciplina
if($_GET['f'] == "editar"){ 

	if($_POST['descricao']==""){
			echo "<meta http-equiv='refresh' content='0; URL=../disciplinas.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{  
	
	$editarturma = $pdo->prepare("UPDATE disciplina SET descricao_disciplina = :descricao, curso_idcurso = :curso, professor_idprofessor = :professor, ementa = :ementa WHERE iddisciplina = :id");

	$editarturma->bindValue(":descricao", $_POST['descricao']);
	$editarturma->bindValue(":curso", $_POST['curso']);
	$editarturma->bindValue(":professor", $_POST['professor']);
	$editarturma->bindValue(":ementa", $_POST['ementa']);
	$editarturma->bindValue(":id", $_GET['id']);
	$editarturma->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../disciplinas.php'>
		<script type=\"text/javascript\">
		alert(\"Disciplina Editada com sucesso!\");
		</script>";	
		}
}

// função excluir Turma
if($_GET['f'] == "excluir"){   
	
	$excluircurso = $pdo->prepare("DELETE FROM disciplina WHERE iddisciplina = :id");
	$excluircurso->bindValue(":id", $_GET['id']);
	$excluircurso->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../disciplinas.php'>
		<script type=\"text/javascript\">
		alert(\"Disciplina excluida com sucesso!\");
		</script>";	
}


?>