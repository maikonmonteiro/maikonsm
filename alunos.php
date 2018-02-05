<?php
session_start();
if(!isset($_SESSION['login']) and !isset($_SESSION['senha'])){
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
  <legend class="legenda">Alunos</legend>
  <div>
  
  <?php
  
  if(!isset($_GET['funcao'])=="editar")
  {
  
  ?>
  
  <form method="post" class="form-inline" action="funcoes/alunos_f.php?f=cadastrar">

  <div>
   
    <label for="nome" >Nome</label>
    <input class="form-control" name="nome" id="nome" type="text" size="30"/><span style="color:red;">*</span> 
  
    <label for="cpf" >CPF</label>
    <input class="form-control" maxlength="14" onkeypress="formatar_mascara(this,'###.###.###-##')" name="cpf" id="cpf" type="text" size="13"/><span style="color:red;">*</span>

    <label for="rg" >RG</label>
    <input class="form-control" maxlength="9" onkeypress="formatar_mascara(this,'#######-#')" name="rg" id="rg" type="text" size="8"/><span style="color:red;">*</span>
  
    <label for="nascimento" >Nascimento</label>
    <input class="form-control" maxlength="10" onkeypress="formatar_mascara(this,'##/##/####')" name="nascimento" id="nascimento" type="text" size="8"/><span style="color:red;">*</span>

    <label for="telefone" >Telefone</label>
    <input class="form-control" maxlength="13" onkeypress="formatar_mascara(this,'##-#####-####')" name="telefone" id="telefone" type="text" size="13"/><span style="color:red;">*</span> </br>

    <label for="cep" >CEP</label>
    <input class="form-control" maxlength="10" onkeypress="formatar_mascara(this,'##.###-###')" style="margin-top: 1%;" name="cep" id="cep" type="text" size="10"/><span style="color:red;">*</span>

    <label for="logradouro" >Logradouro</label>
    <input class="form-control" style="margin-top: 1%;" name="logradouro" id="logradouro" type="text" size="30"/>

    <label for="bairro" >Bairro</label>
    <input class="form-control" style="margin-top: 1%;" name="bairro" id="bairro" type="text" size="20"/>

    <label style="margin-left: 1%;" for="cidade" >Cidade</label>
    <input class="form-control" style="margin-top: 1%;" name="cidade" id="cidade" type="text" size="20"/> </br>

    <label for="uf" >UF</label>
    <input class="form-control" style="margin-top: 1%;" name="uf" id="uf" type="text" size="3"/>
  
    <label for="sexo" style="margin-top: 1%; margin-left: 1%;" >Sexo</label>
    <select style="margin-top: 1%; width: 15%;" class="form-control" name="sexo" id="sexo">
        <option value="masculino">Masculino</option>
        <option value="feminino">Feminino</option>
        </select>

        <label for="estado_civil" style="margin-top: 1%;" >Estado Civil</label>
    <select style="margin-top: 1%;" class="form-control" name="estado_civil" id="estado_civil">
        <option value="solteiro">Solteiro</option>
        <option value="casado">Casado</option>
        <option value="divorciado">Divorciado</option>
        <option value="viuvo">Viúvo</option>
        </select>

        <label for="curso" style="margin-top: 1%; margin-left: 1%;">Curso</label>
    <select style="margin-top: 1%;" class="form-control" name="curso" id="curso">   

      <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarcurso = $pdo->query("SELECT * FROM curso");

      
      while($ln = $listarcurso->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar1){

         ?>
         <option value="<?=$listar1->idcurso;?>"><?=$listar1->curso_descricao;?></option>

         <?php
       }}
       ?>

     </select>

    <label for="turma" style="margin-top: 1%; margin-left: 1%;">Turma</label>
    <select style="margin-top: 1%; width: 15%;" class="form-control" name="turma" id="turma"> 

     <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      // buscar o primeiro curso
      $listarC = $pdo->query("SELECT * FROM curso LIMIT 1");
      $result = $listarC->fetch(PDO::FETCH_ASSOC);

      $listarT = $pdo->query("SELECT * FROM turma WHERE curso_idcurso = '".$result["idcurso"]."'");
      while($ln = $listarT->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar2){

         ?>
         <option value="<?=$listar2->idturma;?>"><?=$listar2->turma_descricao;?></option>

         <?php
       }}
       ?>

        </select>
      </br>

    <label for="email" >Email</label>
    <input class="form-control" style="margin-top: 1%;" name="email" id="email" type="text" size="24"/>

    <label for="situacao" style="margin-top: 1%; margin-left: 1%;" >Situação</label>
    <select style="margin-top: 1%; width: 130px;" class="form-control" name="situacao" id="situacao">
        <option value="Cursando">Cursando</option>
        <option value="Formado">Formado</option>
        <option value="Desistente">Desistente</option>
        </select>
 
    <label for="acesso" style="margin-top: 1%; margin-left: 1%;" >Acesso</label>
    <select style="margin-top: 1%; width: 80px;" class="form-control" name="acesso" id="acesso">
        <option value="sim">sim</option>
        <option value="não">não</option>
        </select>
     </div>

      <div align="right" style="margin-right: 1%;">
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
  $buscarcliente = $pdo->prepare("SELECT * FROM aluno a, turma t, curso c WHERE a.idaluno = :id AND a.turma_idturma = t.idturma AND t.curso_idcurso = c.idcurso");
  $buscarcliente->bindValue(":id",$_GET['id']);
  $buscarcliente->execute();

  $ln = $buscarcliente->fetchALL(PDO::FETCH_OBJ);

  foreach($ln as $listar){
      
  ?>
  
  <form method="post" class="form-inline" action="funcoes/alunos_f.php?f=editar&id=<?=$listar->idaluno?>">

  <div >
   
    <label for="nome" >Nome</label>
    <input class="form-control" name="nome" id="nome" type="text" size="30" value="<?=$listar->nome?>"/><span style="color:red;">*</span> 
  
    <label for="cpf" >CPF</label>
    <input class="form-control" maxlength="14" onkeypress="formatar_mascara(this,'###.###.###-##')" name="cpf" id="cpf" type="text" size="13" value="<?=$listar->cpf?>"/><span style="color:red;">*</span>

    <label for="rg" >RG</label>
    <input class="form-control" maxlength="9" onkeypress="formatar_mascara(this,'#######-#')" name="rg" id="rg" type="text" size="8" value="<?=$listar->rg?>"/>
  
    <label for="nascimento" >Nascimento</label>
    <input class="form-control" maxlength="10" onkeypress="formatar_mascara(this,'##/##/####')" name="nascimento" id="nascimento" type="text" size="8" value="<?=$listar->nascimento?>"/><span style="color:red;">*</span>

    <label for="telefone" >Telefone</label>
    <input class="form-control" maxlength="13" onkeypress="formatar_mascara(this,'##-#####-####')" name="telefone" id="telefone" type="text" size="10" value="<?=$listar->telefone?>"/><span style="color:red;">*</span> </br>

    <label for="cep" >CEP</label>
    <input class="form-control" maxlength="10" onkeypress="formatar_mascara(this,'##.###-###')" style="margin-top: 1%;" name="cep" id="cep" type="text" size="10" value="<?=$listar->cep?>"/><span style="color:red;">*</span>

    <label for="logradouro" >Logradouro</label>
    <input class="form-control" style="margin-top: 1%;" name="logradouro" id="logradouro" type="text" size="30" value="<?=$listar->logradouro?>"/> 

    <label for="bairro" >Bairro</label>
    <input class="form-control" style="margin-top: 1%;" name="bairro" id="bairro" type="text" size="20" value="<?=$listar->bairro?>"/>

    <label for="cidade" >Cidade</label>
    <input class="form-control" style="margin-top: 1%;" name="cidade" id="cidade" type="text" size="20" value="<?=$listar->cidade?>"/> </br>

    <label for="uf" >UF</label>
    <input class="form-control" style="margin-top: 1%;" name="uf" id="uf" type="text" size="3" value="<?=$listar->uf?>"/>
  
    <label for="sexo" style="margin-top: 1%; margin-left: 1%;" >Sexo</label>
    <select style="margin-top: 1%; width: 15%;" class="form-control" name="sexo" id="sexo">
        <option value="<?=$listar->sexo?>"><?=$listar->sexo?></option>
        <option value="masculino">Masculino</option>
        <option value="feminino">Feminino</option>
        </select>

        <label for="estado_civil" style="margin-top: 1%;" >Estado Civil</label>
    <select style="margin-top: 1%;" class="form-control" name="estado_civil" id="estado_civil">
        <option value="<?=$listar->estado_civil?>"><?=$listar->estado_civil?></option>
        <option value="solteiro">Solteiro</option>
        <option value="casado">Casado</option>
        <option value="divorciado">Divorciado</option>
        <option value="viuvo">Viúvo</option>
        </select>

         <label for="curso" style="margin-top: 1%; margin-left: 1%;">Curso</label>
    <select style="margin-top: 1%;" class="form-control" name="curso" id="curso">   
       <option value="<?=$listar->idcurso?>"><?=$listar->curso_descricao?></option>
      <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarcurso = $pdo->query("SELECT * FROM curso");

      while($ln = $listarcurso->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar1){

         ?>
         <option value="<?=$listar1->idcurso;?>"><?=$listar1->curso_descricao;?></option>

         <?php
       }}
       ?>

     </select>

    <label for="turma" style="margin-top: 1%; margin-left: 1%;">Turma</label>
    <select style="margin-top: 1%;" class="form-control" name="turma" id="turma">  
    <option value="<?=$listar->idturma?>"><?=$listar->turma_descricao?></option>   

    <?php
      include_once "funcoes/conexao.php";
      $pdo=conectar();
      $listarTC = $pdo->query("SELECT * FROM turma WHERE curso_idcurso = '$listar->idcurso'");

      while($ln = $listarTC->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar3){

         ?>
         <option value="<?=$listar3->idturma;?>"><?=$listar3->turma_descricao;?></option>

         <?php
       }}
       ?>   
        </select>
        </br>

    <label for="email" >Email</label>
    <input class="form-control" style="margin-top: 1%;" name="email" id="email" type="text" size="24" value="<?=$listar->email?>"/>
 
    <label for="situacao" style="margin-top: 1%; margin-left: 1%;" >Situação</label>
    <select style="margin-top: 1%; width: 130px;" class="form-control" name="situacao" id="situacao">
      <option value="<?=$listar->situacao?>"><?=$listar->situacao?></option>
        <option value="Cursando">Cursando</option>
        <option value="Formado">Formado</option>
        <option value="Desistente">Desistente</option>
        </select>

    <label for="acesso" style="margin-top: 1%;" >Acesso</label>
    <select style="margin-top: 1%; width: 80px;" class="form-control" name="acesso" id="acesso">
        <option value="<?=$listar->acesso?>"><?=$listar->acesso?></option>
        <option value="sim">sim</option>
        <option value="não">não</option>
        </select>
 
     </div>
     
       <div align="right" style="margin-right: 1%;">
  <button type="submit" class="btn btn-default" name="atualizar" >
  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Atualizar
</button>

<button type="button" class="btn btn-default" name="limpar" onclick="teste()">
  <span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Limpar
</button>

</div>
  
  </form>
  
   <?php
  }
  }
      
  ?>
  
  </div> 

  <label for="pesquisar">Pesquisar</label>
  <input style="width: 20%;" type="text" class="form-control" id="pesquisar" name="pesquisar" />
  
  <div style="border: 1px solid #777; margin-top: 1%; width: 1030px;">
   <table>
   <thead>
  <tr style="background-color: #eee; height: 30px;">
    <th style="width: 80px; text-align: center;">Ações</th>
    <th style="width: 320px; text-align: center;">Nome</th>
    <th style="width: 70px; text-align: center;">Matrícula</th>
    <th style="width: 170px; text-align: center;">Curso</th>
    <th style="width: 120px; text-align: center;">CPF</th>
    <th style="width: 120px; text-align: center;">Telefone</th>
    <th style="width: 70px;">Ficha</th>
    <th style="width: 80px;">Boletim</th>
  </tr>
  </thead>
</table>

  <div style="overflow: auto; height: 160px;">
   <table cellspacing="0" class="table table-striped">
  
  <tbody>
  
    <?php 
    include_once "funcoes/conexao.php";
  $pdo=conectar();
  $qtd_alunos = 0;
  
  $ListaAlunos = $pdo->query("SELECT * FROM aluno a, turma t, curso c WHERE a.turma_idturma = t.idturma AND t.curso_idcurso = c.idcurso ORDER BY a.nome");       
  
  while($ln = $ListaAlunos->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar){

  ?>
    <tr>
    <td style="width: 80px; text-align: center;">
    <a style="margin-right: 8%;" href="funcoes/alunos_f.php?f=excluir&id=<?=$listar->idaluno;?>"><img src="img/deletar.png" width="16" height="16"/></a>
    <a href="alunos.php?funcao=editar&id=<?=$listar->idaluno;?>"><img src="img/editar.png" width="16" height="16" /></a>    
    </td>
    
    <td style="width: 320px;"><?=$listar->nome?></td>
    <td style="width: 70px; text-align: center;"><?=$listar->matricula?></td>
    <td style="width: 170px; text-align: center;"><?=$listar->curso_descricao?></td>
    <td style="width: 120px; text-align: center;"><?=$listar->cpf?></td>
    <td style="width: 120px; text-align: center;"><?=$listar->telefone?></td>

    <!--

    <td style="width: 70px; text-align: center;"> <a type="button" id="novo" class="btn btn-primary btn-xs" onclick="dados()">gerar</a> </td>
     -->

      <td style="width: 70px; text-align: center;"> <a type="button" id="novo" class="btn btn-primary btn-xs" onclick="dados('<?php echo $listar->idaluno; ?>')">gerar</a> </td>

   
    <td style="width: 80px; text-align: center;"> <a type="button" id="novo" class="btn btn-primary btn-xs" onclick="boletim('<?php echo $listar->idaluno; ?>')">gerar</a> </td>
  </tr>

<?php
$qtd_alunos++;
  }}
?>
</tbody>
</table>
</div>
</div>

<h5> <?=$qtd_alunos?> Alunos cadastrados</h5>

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
  document.getElementById("rg").value = "";
  document.getElementById("nascimento").value = ""; 
  document.getElementById("telefone").value = ""; 
  document.getElementById("cep").value = ""; 
  document.getElementById("logradouro").value = "";
  document.getElementById("bairro").value = "";
  document.getElementById("cidade").value = "";
  document.getElementById("uf").value = "";
  document.getElementById("email").value = "";
  document.getElementById("senha").value = "";

}
// carregar as turmas conforme a seleção do curso
 $(document).ready(function() {
        $('#curso').change(function(e) {
            var selecao = $(this).val();

            $.post('funcoes/listar.php', {
           id: selecao,
           funcao: "turmas"
       }, function(response){
           $('#turma').empty().append(response);

       });
            
        });
    });

 // carregar o endereço do aluno ao digitar o cep
 $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#logradouro").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#logradouro").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#logradouro").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });


function dados(novo){
  var idc = novo; 
window.open("ficha.php?id="+idc);
}


function boletim(novo){
  var idc = novo; 
window.open("boletim.php?id="+idc);
}

</script>

