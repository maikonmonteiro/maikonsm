<?php
	session_start();
	if(!isset($_SESSION['cpf']) and !isset($_SESSION['senha'])){
	header("Location: index.php");
	exit;
	}else{
        
        $nome = str_split($_SESSION['nome']);
        $nome_novo = "";
       foreach ($nome as $char){
        if ($char==" ") {
            break;
        }else{
            $nome_novo = $nome_novo.$char;
        }
   }
        
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CEI</title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
    <!--imagem título-->
    <link rel="shortcut icon" href="img/icone.ico"/> 

     <!-- Bootstrap -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
    
</head>
<body>

    <div class="topo" style="height: 80px; width: auto; background-image: url(img/bg_topo.png);">
        <div style="color: white; position: absolute; margin-left: 5%;">
        <h4>CENTRO DE ENSINO DE ITACOATIARA - CEI</h4>
        <p style="font-size: 11px;">Empresa Especializada em Prestação de Serviços Educacionais</p>
        </div>

        <span id="logado">
    Bem Vindo, <span id="usuario"><?php echo $nome_novo;?></span> |<a id="sair" href="funcoes/gerais.php?f=sair"> Sair</a>
    </span>

    </div>
   

    <div class="menu">
       
    <?php
    if (isset($_SESSION['perfil'])) {
        
        if ($_SESSION['perfil'] == "aluno"){
    
    ?>
    <li><a href="home_inicio_alunos.php" target="frame"> <span>Home</span> </a> </li>
    <li><a href="notas_aluno.php" target="frame"><span>Notas</span></a></li>
    <li><a href="senha_aluno.php" target="frame"><span>Mudar Senha</span></a></li>

    <?php
}else{
    ?>


        <li><a href="home_inicio.php" target="frame"> <span>Home</span> </a> </li>
        <li><a href="professores.php" target="frame"><span>Professores</span></a></li>
        <li><a href="alunos.php" target="frame"><span>Alunos</span></a></li>
        <li><a href="cursos.php" target="frame"><span>Cursos</span></a></li>
        <li><a href="disciplinas.php" target="frame"><span>Disciplinas</span></a></li>
        <li><a href="turmas.php" target="frame"><span>Turmas</span></a></li>
        <li><a href="notas.php" target="frame"><span>Notas</span></a></li>
             
        <li><a href="financeiro.php" target="frame"><span>Financeiro</span></a></li>      
        
        <li><a href="listas.php" target="frame"><span>Listas</span></a></li>
        <li><a href="usuarios.php" target="frame"><span>Usuários</span></a></li>

        <?php
    }}
        ?>  

        <li><a href="sobre.php" target="frame"><span>Sobre</span></a> </li>   

    </div>
    
 
    
    <!--Frame onde são carregadas as telas-->


    <?php
    if (isset($_SESSION['perfil'])) {
        
        if ($_SESSION['perfil'] == "aluno"){
    
    ?>
        <iframe name="frame" 
        style="margin-left: 1%; width: 80%; height: 545px;" src="home_inicio_alunos.php" 
        frameborder="0" scrolling="yes"></iframe>

         <?php
}else{
    ?>

    <iframe name="frame" 
        style="margin-left: 1%; width: 80%; height: 545px;" src="home_inicio.php" 
        frameborder="0" scrolling="yes" ></iframe>

     <?php
    }}
        ?>   


     <footer id="rodape">
       <span>CEI - CENTRO DE ENSINO DE ITACOATIARA <br> Todos os direitos reservados</span>
        <span style="font-weight:bold;"><br>cei.itacoatiara2017@zipmail.com.br</span>
    </footer>

</body>
</html>
