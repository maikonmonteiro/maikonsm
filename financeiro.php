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

<fieldset class="form-inline" style="margin-left: 5%; margin-top: 3%; width: 90%;">
  <legend class="legenda">Financeiro</legend>

  <label for="pesquisar">Pesquisar</label>
  <input style="width: 20%;" type="text" class="form-control" id="pesquisar" name="pesquisar" />
  
  <div style="border: 1px solid #777; margin-top: 1%;">
   <table>
   <thead>
  <tr style="background-color: #eee; height: 30px;">
  <th style="width: 40px; text-align: center;">Item</th>
    <th style="width: 180px; text-align: center;">Nome</th>
    <th style="width: 80px; text-align: center;">Matrícula</th>
    <th style="width: 130px; text-align: center;">Curso</th>
    <th style="width: 120px; text-align: center;">CPF</th>
    <th style="width: 130px; text-align: center;">Vencimento</th>
    <th style="width: 90px; text-align: center;">Valor</th>
    <th style="width: 80px; text-align: center;">Boleto</th>
    <th style="width: 50px; text-align: center;">Hist.</th>
    <th style="width: 90px; text-align: center;">Pag. Manual</th>
  </tr>
  </thead>
</table>

  <div style="overflow: auto; height: 350px;">
   <table cellspacing="0" class="table table-striped">
  
  <tbody>
  
    <?php 
  include_once "funcoes/conexao.php";
  $pdo=conectar();
  $listaralunos = $pdo->query("SELECT * FROM aluno a, turma t, curso c WHERE a.turma_idturma = t.idturma AND t.curso_idcurso = c.idcurso");
  $cont = 0;

  while($ln = $listaralunos->fetchALL(PDO::FETCH_OBJ)){

  foreach($ln as $listar){

  ?>
    <tr>
    <td style="width: 40px; text-align: center;"><?=$cont+1?></td>
    <td style="width: 180px;"><?=$listar->nome?></td>
    <td style="width: 80px; text-align: center;"><?=$listar->matricula?></td>
    <td style="width: 130px; text-align: center;"><?=$listar->curso_descricao?></td>
    <td style="width: 130px; text-align: center;"><?=$listar->cpf?></td>

    <td style="width: 130px; text-align: center;"><input class="form-control" placeholder="dd/mm/aaaa" name="vencimento" id="<?php echo 'vencimento'.$cont; ?>" type="text" maxlength="10" onkeypress="formatar_mascara(this,'##/##/####')" size="8"/></td>
    

    <td style="width: 90px; text-align: center;"><input class="form-control" placeholder="0,00" name="valor" id="<?php echo 'valor'.$cont; ?>" type="text" size="3"/></td>

    <td style="text-align: center;"> <a type="button" id="novo" onclick="pegar('gerar',document.getElementById('<?php echo 'vencimento'.$cont; ?>').value, document.getElementById('<?php echo 'valor'.$cont; ?>').value, '<?=$listar->idaluno;?>', '<?=$listar->nome;?>', '<?=$listar->cpf;?>', '<?=$listar->logradouro." - ".$listar->bairro." - ".$listar->cidade."/".$listar->uf;?>')" target="_blank" class="btn btn-primary btn-xs">gerar</a> </td>

    <td style="text-align: center;"> <a type="button" id="historico" class="btn btn-primary btn-xs" href="boletos_aluno.php?idaluno=<?=$listar->idaluno;?>">abrir</a> </td>

    <td style="text-align: center;"> <a type="button" id="historico" class="btn btn-success btn-xs" href="boletos_aluno.php?idaluno=<?=$listar->idaluno;?>">pagar</a> </td>

  </tr>

<?php
$cont++;
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
           desc: selecao,
           funcao: "turmas"
       }, function(response){
           $('#turma').empty().append(response);

       });
            
        });
    });
/*
function dados(novo){
  var idc = novo; 
window.open("ficha.php?id="+idc);
}
*/

function boletim(novo){
  var idc = novo; 
window.open("boletim.php?id="+idc);
}

function pegar(f, venc, val, idal, nom, cpf, log){
//w=document.getElementById("vencimento").value;
 window.open('gerar_boleto.php?funcao='+f+'&vencimento='+venc+'&valor='+val+'&idaluno='+idal+'&nome='+nom+'&cpf='+cpf+'&logradouro='+log, '_blank');
}

</script>

