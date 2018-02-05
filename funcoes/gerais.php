<?php
session_start();
include "conexao.php";
$pdo=conectar();

// função logar
if($_GET['f'] == "logar"){
	
	if($_POST['cpf']!="" && $_POST['senha']!=""){ //verifica se os campos estão nulos
	$perfil = "";

// administrador		
if($_POST['perfil']=="administrador"){

$buscarusuario = $pdo->prepare("SELECT * FROM usuario WHERE cpf = :cpf LIMIT 1");
$buscarusuario->bindValue(":cpf",$_POST['cpf']);
$buscarusuario->execute();
$perfil = "adm";

}else{ // aluno

	$buscarusuario = $pdo->prepare("SELECT * FROM aluno WHERE cpf = :cpf LIMIT 1");
$buscarusuario->bindValue(":cpf",$_POST['cpf']);
$buscarusuario->execute();
$perfil = "aluno";
}

if($buscarusuario->rowCount()>0){
		
	$ln = $buscarusuario->fetchALL(PDO::FETCH_OBJ);
	foreach($ln as $listar){
		if (base64_decode($listar->senha)==$_POST['senha']) {

if ($perfil=="aluno") {

	if ($listar->acesso == "sim") {
		$_SESSION['idaluno'] = $listar->idaluno;
	$_SESSION['cpf'] = $listar->cpf;
	$_SESSION['senha'] = $listar->senha;
	$_SESSION['nome'] = $listar->nome;
	$_SESSION['perfil'] = $perfil;

	header("Location: ../home.php");
	
	}else{
		echo "<meta http-equiv='refresh' content='0; URL=../index.php'>
		<script type=\"text/javascript\">
		alert(\"Aluno bloqueado!\");
		</script>";
	}

}else{

	$_SESSION['cpf'] = $listar->cpf;
	$_SESSION['senha'] = $listar->senha;
	$_SESSION['nome'] = $listar->nome;
	$_SESSION['perfil'] = $perfil;

	header("Location: ../home.php");
	}

}else{
	echo "<meta http-equiv='refresh' content='0; URL=../index.php'>
		<script type=\"text/javascript\">
		alert(\"Senha invalida\");
		</script>";
}

}}else{
echo "<meta http-equiv='refresh' content='0; URL=../index.php'>
		<script type=\"text/javascript\">
		alert(\"CPF nao cadastrado\");
		</script>";
}

}

else{
	echo "<meta http-equiv='refresh' content='0; URL=../index.php'>
		<script type=\"text/javascript\">
		alert(\"Preencha todos os campos!\");
		</script>";
}

}

// função sair
if($_GET['f'] == "sair"){		
unset($_SESSION['cpf']);
unset($_SESSION['senha']);
unset($_SESSION['nome']);
unset($_SESSION['lista_alunos']);
header("Location: ../index.php");
}


?>