<?php
//inicia a sessão
session_start();
// inicia a conexão com o banco
include_once "conexao.php";
$pdo = conectar();


// função cadastrar usuário
if($_GET['f'] == "cadastrar"){
	
	$cpf = $pdo->prepare("SELECT * FROM usuario WHERE cpf = :cpf");
	$cpf->bindValue(":cpf", $_POST['cpf']);
	$cpf->execute();

	if($cpf->rowCount()>0){
		echo "<meta http-equiv='refresh' content='0; URL=../usuarios.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: CPF ja existe!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
	}else{
		
		if($_POST['nome']=="" || $_POST['cpf']=="" || $_POST['telefone']=="" || $_POST['email']=="" || $_POST['senha']=="" || $_POST['endereco']==""){
			echo "<meta http-equiv='refresh' content='0; URL=../usuarios.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{

			$senha_criptografada = base64_encode($_POST['senha']);

	$inserirusuario = $pdo->prepare("INSERT INTO usuario (nome, cpf, endereco, telefone, senha, email) VALUES (:nome, :cpf, :endereco, :telefone, :senha, :email)");
	$inserirusuario->bindValue(":nome", $_POST['nome']);
	$inserirusuario->bindValue(":cpf", $_POST['cpf']);
	$inserirusuario->bindValue(":endereco", $_POST['endereco']);
	$inserirusuario->bindValue(":telefone", $_POST['telefone']);
	$inserirusuario->bindValue(":senha", $senha_criptografada);
	$inserirusuario->bindValue(":email", $_POST['email']);
	$inserirusuario->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../usuarios.php'>
		<script type=\"text/javascript\">
		alert(\"Usuario Cadastrado com sucesso!\");
		</script>";
		}
}
}

// função editar usuario
if($_GET['f'] == "editar"){ 

	

	if($_POST['nome']=="" || $_POST['cpf']=="" || $_POST['telefone']=="" || $_POST['email']=="" || $_POST['senha']=="" || $_POST['endereco']==""){
			echo "<meta http-equiv='refresh' content='0; URL=../usuarios.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{  

			$senha_criptografada = base64_encode($_POST['senha']);
	
	$editarusuario = $pdo->prepare("UPDATE usuario SET nome = :nome, cpf = :cpf, endereco = :endereco, telefone = :telefone, senha = :senha, email = :email WHERE idusuario = :id");

	$editarusuario->bindValue(":nome", $_POST['nome']);
	$editarusuario->bindValue(":cpf", $_POST['cpf']);
	$editarusuario->bindValue(":endereco", $_POST['endereco']);
	$editarusuario->bindValue(":telefone", $_POST['telefone']);
	$editarusuario->bindValue(":senha", $senha_criptografada);
	$editarusuario->bindValue(":email", $_POST['email']);
	$editarusuario->bindValue(":id", $_GET['id']);
	$editarusuario->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../usuarios.php'>
		<script type=\"text/javascript\">
		alert(\"Usuario Editado com sucesso!\");
		</script>";	
		}
}


// função excluir usuario
if($_GET['f'] == "excluir"){   
	
	$excluirusuario = $pdo->prepare("DELETE FROM usuario WHERE idusuario = :id");
	$excluirusuario->bindValue(":id", $_GET['id']);
	$excluirusuario->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../usuarios.php'>
		<script type=\"text/javascript\">
		alert(\"Usuario excluido com sucesso!\");
		</script>";	
}

?>