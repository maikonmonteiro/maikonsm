<?php
session_start();
if(!isset($_SESSION['cpf']) and !isset($_SESSION['senha'])){
header("Location: index.php");
exit; 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CEI</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
     <!-- Bootstrap -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

  <!--imagem título-->
    <link rel="shortcut icon" href="img/icone.ico"/> 
</head>

<body>

<fieldset class="form-inline" style="margin-left: 5%; margin-top: 1%;">
<legend class="legenda">Usuários</legend>
  <div>
  
  <?php
  
  if(!isset($_GET['funcao'])=="editar")
  {
  
  ?>
  <form method="post" class="form-inline" action="funcoes/usuarios_f.php?f=cadastrar">

  <div>
   
    <label for="nome" >Nome</label>
    <input class="form-control" style="width: 300px;" name="nome" id="nome" type="text" size="30"/><span style="color:red;">*</span> 
  
    <label style="margin-left: 1%;" for="cpf" >CPF</label>
    <input maxlength="14" onkeypress="formatar_mascara(this,'###.###.###-##')" class="form-control" name="cpf" id="cpf" type="text" size="13"/><span style="color:red;">*</span>
  
    <label for="telefone" >Telefone</label>
    <input maxlength="13" onkeypress="formatar_mascara(this,'##-#####-####')" class="form-control" name="telefone" id="telefone" type="text" size="13"/><span style="color:red;">*</span>  </br>

    <label for="email" >Email</label>
    <input style="margin-top: 1%;" class="form-control" name="email" id="email" type="text" size="26"/><span style="color:red;">*</span>
    
    <label for="senha" >Senha</label>
    <input style="margin-top: 1%;" name="senha" class="form-control" id="senha" type="text" size="20"/><span style="color:red;">*</span></br>
    
    <label for="endereco" >Endereco</label>
    <input style="margin-top: 1%;" class="form-control" name="endereco" id="endereco" type="text" size="58"/><span style="color:red;">*</span>

  </div>
   
     
        <div align="right" style="margin-top: 3%; margin-right: 18%;">
  <button type="submit" class="btn btn-default" name="salvar" >
  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Salvar
</button>

<button type="button" class="btn btn-default" name="limpar" onclick="teste()">
  <span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Limpar
</button>

  </div> 
  
  </form>
   
    <?php
     
  }else{

    include_once "funcoes/conexao.php";
     $pdo=conectar();
  $buscarusuario = $pdo->prepare("SELECT * FROM usuario WHERE idusuario = :id");
  $buscarusuario->bindValue(":id",$_GET['id']);
  $buscarusuario->execute();

  $ln = $buscarusuario->fetchALL(PDO::FETCH_OBJ);

  foreach($ln as $listar){
      
  ?>
  
  <form method="post" class="form-inline" action="funcoes/usuarios_f.php?f=editar&id=<?=$listar->idusuario?>">
   <div>
  
   <label for="nome" >Nome</label>
    <input class="form-control" style="width: 300px;" name="nome" id="nome" type="text" size="30" value="<?=$listar->nome?>"/><span style="color:red;">*</span> 
  
    <label style="margin-left: 1%;" for="cpf" >CPF</label>
    <input maxlength="14" onkeypress="formatar_mascara(this,'###.###.###-##')" class="form-control" name="cpf" id="cpf" type="text" size="13" value="<?=$listar->cpf?>"/><span style="color:red;">*</span>
  
    <label for="telefone" >Telefone</label>
    <input maxlength="13" onkeypress="formatar_mascara(this,'##-#####-####')" class="form-control" name="telefone" id="telefone" type="text" size="13" value="<?=$listar->telefone?>"/><span style="color:red;">*</span> </br>

    <label for="email" >Email</label>
    <input style="margin-top: 1%;" class="form-control" name="email" id="email" type="text" size="26" value="<?=$listar->email?>"/><span style="color:red;">*</span>
    
    <label for="senha" >Senha</label>
    <input style="margin-top: 1%;" name="senha" class="form-control" id="senha" type="text" size="20" value="<?=base64_decode($listar->senha)?>"/><span style="color:red;">*</span> </br>
    
    <label for="endereco" >Endereco</label>
    <input style="margin-top: 1%;" class="form-control" name="endereco" id="endereco" type="text" size="58" value="<?=$listar->endereco?>"/><span style="color:red;">*</span>

  </div>

     
       <div align="right" style="margin-top: 3%; margin-right: 18%;">
  <button type="submit" class="btn btn-default" name="atualizar" >
  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Atualizar
</button>

<button type="button" class="btn btn-default" name="limpar" onclick="teste()">
  <span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Limpar
</button>

</div>
  
  </form>
  
   <?php
  }}
      
  ?>
    
  </div>


  <label for="pesquisar">Pesquisar</label>
        <input style="width: 20%;" type="text" class="form-control" id="pesquisar" name="pesquisar" />

 <div style="border: 1px solid #777; margin-top: 1%; width: 850px;">
   <table>
   <thead>
  <tr style="background-color: #eee; height: 30px;">
    <th style="width: 80px; text-align: center;">Ações</th>
    <th style="width: 250px; text-align: center;">Nome</th>
    <th style="width: 150px; text-align: center;">CPF</th>
    <th style="width: 120px; text-align: center;">Telefone</th>
    <th style="width: 260px; text-align: center;">Email</th>
  </tr>
  </thead>
  </table>

<div style="height: 190px; overflow: auto;">
  <table class="table table-striped">

  <tbody>

    <?php 
  include_once "funcoes/conexao.php";
  $pdo=conectar();
  $listarusuarios = $pdo->query("SELECT * FROM usuario ORDER BY nome");

  while($ln = $listarusuarios->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar){
  ?>
  <tr>
  <td style="width: 80px; text-align: center;">
    <a href="funcoes/usuarios_f.php?f=excluir&id=<?=$listar->idusuario;?>"><img src="img/deletar.png" width="16" height="16"/></a>
    <a href="usuarios.php?funcao=editar&id=<?=$listar->idusuario;?>"><img src="img/editar.png" width="16" height="16" /></a>    
    </td>

    <td style="width: 250px;"><?=$listar->nome;?></td>
    <td style="width: 150px; text-align: center;"><?=$listar->cpf;?></td>
    <td style="width: 120px; text-align: center;"><?=$listar->telefone;?></td>
    <td style="width: 260px;"><?=$listar->email;?></td>
  </tr>

<?php
  }}
?>
</tbody>
</table>
</div>
</div>
</fieldset>

</body>
</html>

<script type="text/javascript">

// criar máscara conforme o campo
function formatar_mascara(src, mascara) {
 var campo = src.value.length;
 var saida = mascara.substring(0,1);
 var texto = mascara.substring(campo);
 if(texto.substring(0,1) != saida) {
 src.value += texto.substring(0,1);
 }
}

$('#pesquisar').keydown(function(){
        var encontrou = false;
        var termo = $(this).val().toLowerCase();
        $('table > tbody > tr').each(function(){
          $(this).find('td').each(function(){
            if($(this).text().toLowerCase().indexOf(termo) > -1) encontrou = true;
          });
          if(!encontrou) $(this).hide();
          else $(this).show();
          encontrou = false;
        });
      });

function teste(){
  document.getElementById("nome").value = "";
  document.getElementById("cpf").value = "";
  document.getElementById("telefone").value = "";
  document.getElementById("email").value = "";
  document.getElementById("senha").value = "";  
  document.getElementById("endereco").value = "";
}
</script>