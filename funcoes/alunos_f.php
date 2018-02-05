<?php
//inicia a sessão
session_start();
// inicia a conexão com o banco
include_once "conexao.php";
$pdo = conectar();

// função cadastrar aluno
if($_GET['f'] == "cadastrar"){

	$cpf = $pdo->prepare("SELECT * FROM aluno WHERE cpf = :cpf");
	$cpf->bindValue(":cpf", $_POST['cpf']);
	$cpf->execute();

	if($cpf->rowCount()>0){
		echo "<meta http-equiv='refresh' content='0; URL=../alunos.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: CPF ja existe!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
	}else{
		
		if($_POST['nome']=="" || $_POST['cpf']=="" || $_POST['rg']=="" || $_POST['nascimento']=="" || $_POST['telefone']=="" || $_POST['cep']=="" || $_POST['logradouro']=="" || $_POST['bairro']=="" || $_POST['cidade']=="" || $_POST['uf']=="" || $_POST['turma']==""){

			// if($_POST['nome']==""){

			echo "<meta http-equiv='refresh' content='0; URL=../alunos.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{

			// gerar nova matrícula
			$BuscarMatricula = $pdo->query("SELECT * FROM numero_matricula WHERE idnumero_matricula = 1 LIMIT 1");    
  $matricula = $BuscarMatricula->fetch(PDO::FETCH_ASSOC);
  $nova_matricula = $matricula['numero'] + 1;

  // criptografar senha
			$senha_criptografada = base64_encode($nova_matricula);

  			// atualiza o novo número de matrícula

  $editarmatricula = $pdo->prepare("UPDATE numero_matricula SET numero = :numero WHERE idnumero_matricula = :id");
	$editarmatricula->bindValue(":numero", $nova_matricula);
	$editarmatricula->bindValue(":id", 1);
	$editarmatricula->execute();

	$inseriraluno = $pdo->prepare("INSERT INTO aluno (nome, cpf, rg, nascimento, matricula, telefone, cep, logradouro, bairro, cidade, uf, sexo, estado_civil, senha, email, turma_idturma, acesso, situacao) VALUES (:nome, :cpf, :rg, :nascimento, :matricula, :telefone, :cep, :logradouro, :bairro, :cidade, :uf, :sexo, :estado_civil, :senha, :email, :turma, :acesso, :situacao)");
	$inseriraluno->bindValue(":nome", $_POST['nome']);
	$inseriraluno->bindValue(":cpf", $_POST['cpf']);
	$inseriraluno->bindValue(":rg", $_POST['rg']);
	$inseriraluno->bindValue(":nascimento", $_POST['nascimento']);
	$inseriraluno->bindValue(":matricula", $nova_matricula);
	$inseriraluno->bindValue(":telefone", $_POST['telefone']);
	$inseriraluno->bindValue(":cep", $_POST['cep']);
	$inseriraluno->bindValue(":logradouro", $_POST['logradouro']);
	$inseriraluno->bindValue(":bairro", $_POST['bairro']);
	$inseriraluno->bindValue(":cidade", $_POST['cidade']);
	$inseriraluno->bindValue(":uf", $_POST['uf']);
	$inseriraluno->bindValue(":sexo", $_POST['sexo']);
	$inseriraluno->bindValue(":estado_civil", $_POST['estado_civil']);
	$inseriraluno->bindValue(":senha", $senha_criptografada);
	$inseriraluno->bindValue(":email", $_POST['email']);
	$inseriraluno->bindValue(":turma", $_POST['turma']);
	$inseriraluno->bindValue(":acesso", $_POST['acesso']);
	$inseriraluno->bindValue(":situacao", $_POST['situacao']);
	$inseriraluno->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../alunos.php'>
		<script type=\"text/javascript\">
		alert(\"Aluno Cadastrado com sucesso!\");
		</script>";
		}
}
}

// função editar Aluno
if($_GET['f'] == "editar"){ 


	if($_POST['nome']=="" || $_POST['cpf']=="" || $_POST['rg']=="" || $_POST['nascimento']=="" || $_POST['telefone']=="" || $_POST['cep']=="" || $_POST['logradouro']=="" || $_POST['bairro']=="" || $_POST['cidade']=="" || $_POST['uf']=="" || $_POST['turma']==""){
			echo "<meta http-equiv='refresh' content='0; URL=../alunos.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{  

	
	$editaraluno = $pdo->prepare("UPDATE aluno SET nome = :nome, cpf = :cpf, rg = :rg, nascimento = :nascimento, telefone = :telefone, cep = :cep, logradouro = :logradouro, bairro = :bairro, cidade = :cidade, uf = :uf, sexo = :sexo, estado_civil = :estado_civil, email = :email, turma_idturma = :turma, acesso = :acesso, situacao = :situacao WHERE idaluno = :id");

	$editaraluno->bindValue(":nome", $_POST['nome']);
	$editaraluno->bindValue(":cpf", $_POST['cpf']);
	$editaraluno->bindValue(":rg", $_POST['rg']);
	$editaraluno->bindValue(":nascimento", $_POST['nascimento']);
	$editaraluno->bindValue(":telefone", $_POST['telefone']);
	$editaraluno->bindValue(":cep", $_POST['cep']);
	$editaraluno->bindValue(":logradouro", $_POST['logradouro']);
	$editaraluno->bindValue(":bairro", $_POST['bairro']);
	$editaraluno->bindValue(":cidade", $_POST['cidade']);
	$editaraluno->bindValue(":uf", $_POST['uf']);
	$editaraluno->bindValue(":sexo", $_POST['sexo']);
	$editaraluno->bindValue(":estado_civil", $_POST['estado_civil']);
	$editaraluno->bindValue(":email", $_POST['email']);
	$editaraluno->bindValue(":turma", $_POST['turma']);
	$editaraluno->bindValue(":acesso", $_POST['acesso']);
	$editaraluno->bindValue(":situacao", $_POST['situacao']);
	$editaraluno->bindValue(":id", $_GET['id']);
	$editaraluno->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../alunos.php'>
		<script type=\"text/javascript\">
		alert(\"Aluno Editado com sucesso!\");
		</script>";	
		}
}


// função excluir Aluno
if($_GET['f'] == "excluir"){   
	
	$excluiraluno = $pdo->prepare("DELETE FROM aluno WHERE idaluno = :id");
	$excluiraluno->bindValue(":id", $_GET['id']);
	$excluiraluno->execute();
	
	echo "<meta http-equiv='refresh' content='0; URL=../alunos.php'>
		<script type=\"text/javascript\">
		alert(\"Aluno excluido com sucesso!\");
		</script>";	
}

// função mudar senha do aluno
if($_GET['f'] == "mudar_senha"){   

	if ($_POST['senha_antiga']=="" || $_POST['nova_senha']=="") {

		echo "<meta http-equiv='refresh' content='0; URL=../senha_aluno.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha todos os campos obrigatorios (*)!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{
		

	$senha = base64_encode($_POST['senha_antiga']);

	$aluno = $pdo->prepare("SELECT * FROM aluno WHERE idaluno = :idaluno AND senha = :senha");
	$aluno->bindValue(":idaluno", $_GET['id']);
	$aluno->bindValue(":senha", $senha);
	$aluno->execute();

	if($aluno->rowCount()>0){

		$nova_senha = base64_encode($_POST['nova_senha']);

	$editarsenha = $pdo->prepare("UPDATE aluno SET senha = :senha WHERE idaluno = :idaluno");
	$editarsenha->bindValue(":idaluno", $_GET['id']);
	$editarsenha->bindValue(":senha", $nova_senha);
	$editarsenha->execute();
		
		echo "<meta http-equiv='refresh' content='0; URL=../senha_aluno.php'>
		<script type=\"text/javascript\">
		alert(\"Senha editada com sucesso!\");
		</script>";	
	
	}else{

		echo "<meta http-equiv='refresh' content='0; URL=../senha_aluno.php'>
		<script type=\"text/javascript\">
		alert(\"Senha invalida!\");
		</script>";

		return die; // a página morre! não executa mais o restante dos códigos

	}
}

}

?>