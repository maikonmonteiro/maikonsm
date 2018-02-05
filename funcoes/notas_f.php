<?php
//inicia a sessão
session_start();
// inicia a conexão com o banco
include_once "conexao.php";
$pdo = conectar();

// função cadastrar nota do aluno
if($_GET['f'] == "cadastrar"){

	$nom = $pdo->prepare("SELECT * FROM nota WHERE idaluno = :aluno AND disciplina = :disciplina");
	$nom->bindValue(":aluno", $_POST['aluno']);
	$nom->bindValue(":disciplina", $_POST['disciplina']);
	$nom->execute();

	if($nom->rowCount()>0){
		echo "<meta http-equiv='refresh' content='0; URL=../notas.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Disciplina ja lancada para o aluno!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
	}else{
		
		if($_POST['aluno']=="" || $_POST['disciplina']==""){

			echo "<meta http-equiv='refresh' content='0; URL=../notas.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha os campos aluno e disciplina!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{

	$inserirnota = $pdo->prepare("INSERT INTO nota (data1, data2, data3, freq1, freq2, freq3, nota1, nota2, nota3, media, aluno_idaluno, disciplina_iddisciplina) VALUES (:data1, :data2, :data3, :freq1, :freq2, :freq3, :nota1, :nota2, :nota3, :media, :aluno, :disciplina_iddisciplina)");
	
	$inserirnota->bindValue(":data1", $_POST['data1']);
	$inserirnota->bindValue(":data2", $_POST['data2']);
	$inserirnota->bindValue(":data3", $_POST['data3']);
	$inserirnota->bindValue(":freq1", $_POST['freq1']);
	$inserirnota->bindValue(":freq2", $_POST['freq2']);
	$inserirnota->bindValue(":freq3", $_POST['freq3']);
	$inserirnota->bindValue(":nota1", $_POST['nota1']);
	$inserirnota->bindValue(":nota2", $_POST['nota2']);
	$inserirnota->bindValue(":nota3", $_POST['nota3']);
	$inserirnota->bindValue(":media", $_POST['media']);
	$inserirnota->bindValue(":aluno", $_POST['aluno']);
	$inserirnota->bindValue(":disciplina_iddisciplina", $_POST['disciplina']);
	$inserirnota->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../notas.php'>
		<script type=\"text/javascript\">
		alert(\"Notas na disciplina lancadas com sucesso!\");
		</script>";
		}
}
}

// função editar notas
if($_GET['f'] == "editar"){ 

	
	
	$editarnota = $pdo->prepare("UPDATE nota SET data1 = :data1, data2 = :data2, data3 = :data3, freq1 = :freq1, freq2 = :freq2, freq3 = :freq3, nota1 = :nota1, nota2 = :nota2, nota3 = :nota3, media = :media WHERE idnota = :id");

	
	$editarnota->bindValue(":data1", $_POST['data1']);
	$editarnota->bindValue(":data2", $_POST['data2']);
	$editarnota->bindValue(":data3", $_POST['data3']);
	$editarnota->bindValue(":freq1", $_POST['freq1']);
	$editarnota->bindValue(":freq2", $_POST['freq2']);
	$editarnota->bindValue(":freq3", $_POST['freq3']);
	$editarnota->bindValue(":nota1", $_POST['nota1']);
	$editarnota->bindValue(":nota2", $_POST['nota2']);
	$editarnota->bindValue(":nota3", $_POST['nota3']);
	$editarnota->bindValue(":media", $_POST['media']);
	$editarnota->bindValue(":id", $_GET['id']);
	$editarnota->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../notas.php'>
		<script type=\"text/javascript\">
		alert(\"Notas Editadas com sucesso!\");
		</script>";
		
}

// função excluir Notas do aluno na referida disciplina
if($_GET['f'] == "excluir"){   
	
	$excluirnotas = $pdo->prepare("DELETE FROM nota WHERE idnota = :id");
	$excluirnotas->bindValue(":id", $_GET['id']);
	$excluirnotas->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../notas.php'>
		<script type=\"text/javascript\">
		alert(\"Notas do aluno excluidas com sucesso!\");
		</script>";	
}

?>