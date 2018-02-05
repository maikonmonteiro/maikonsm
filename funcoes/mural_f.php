<?php
//inicia a sessão
session_start();
// inicia a conexão com o banco
include_once "conexao.php";
$pdo = conectar();

// função cadastrar professor
if($_GET['f'] == "salvar"){

	$text = $pdo->prepare("SELECT * FROM mural WHERE idmural = :id");
	$text->bindValue(":id", 1);
	$text->execute();

	if($text->rowCount()>0){

		$editartexto = $pdo->prepare("UPDATE mural SET texto_mural = :texto WHERE idmural = :id");

	$editartexto->bindValue(":texto", $_POST['texto']);
	$editartexto->bindValue(":id", 1);
	$editartexto->execute();

	echo "<meta http-equiv='refresh' content='0; URL=../home_inicio.php'>
		<script type=\"text/javascript\">
		alert(\"Texto salvo com sucesso!\");
		</script>";
		
	}else{

	$inserirtexto = $pdo->prepare("INSERT INTO mural (texto_mural) VALUES (:texto)");
	$inserirtexto->bindValue(":texto", $_POST['texto']);
	$inserirtexto->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../home_inicio.php'>
		<script type=\"text/javascript\">
		alert(\"Texto salvo com sucesso!\");
		</script>";
		}
}

?>