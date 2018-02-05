<?php 
 include("MPDF57/mpdf.php");

 include_once "funcoes/conexao.php";
  $pdo=conectar();

 if (isset($_GET['id'])) {
    $idc = $_GET['id'];
     $listarAluno = $pdo->query("SELECT * FROM aluno a, turma t, curso c WHERE idaluno = '$idc' AND a.turma_idturma = t.idturma AND t.curso_idcurso = c.idcurso");
     $aluno = $listarAluno->fetch(PDO::FETCH_ASSOC);

 }

 $mpdf=new mPDF(); 
 $mpdf->SetDisplayMode('fullpage');
 $mpdf->WriteHTML("

<style type='text/css'>
    
</style>
 	

<img id='img' name='img' style='width: 10%; margin-left: 5%;' src='img/logo.png'/>

<p style='font-size: 10px; text-align: center;'>CENTRO DE ENSINO DE ITACOATIARA - CEI</p>
<h4 style='text-align: center;'>FICHA DE CADASTRO INDIVIDUAL DO ALUNO</h4>

<div style='margin-left: 5%;'>

<p style='font-size: 11px; font-weight:bold; color: green;'>1. DADOS PESSOAIS</p>
<p style='font-size: 11px; color: green;'>__________________________________________________________________________________________________________________________</p>

<div style='font-size: 13px;'>
<span style='font-weight:bold;'>Nome: </span> $aluno[nome] <br/><br/>	
<span style='font-weight:bold;'>CPF: </span> $aluno[cpf] &nbsp;
<span style='font-weight:bold;'>RG: </span> $aluno[rg] &nbsp;
<span style='font-weight:bold;'>Nascimento: </span> $aluno[nascimento] &nbsp;
<span style='font-weight:bold;'>Telefone: </span> $aluno[telefone] <br/><br/>
<span style='font-weight:bold;'>Sexo: </span> $aluno[sexo] &nbsp;
<span style='font-weight:bold;'>Estado civil: </span> $aluno[estado_civil] &nbsp;
<span style='font-weight:bold;'>Email: </span> $aluno[email] <br/><br/><br/>
</div>
<p style='font-size: 11px; font-weight:bold; color: green;'>2. ENDEREÇO RESIDENCIAL</p>
<p style='font-size: 11px; color: green;'>__________________________________________________________________________________________________________________________</p>

<div style='font-size: 13px;'>
<span style='font-weight:bold;'>CEP: </span> $aluno[cep] &nbsp; &nbsp;	
<span style='font-weight:bold;'>Logradouro: </span> $aluno[logradouro] <br/><br/>
<span style='font-weight:bold;'>Bairro: </span> $aluno[bairro] &nbsp; &nbsp;
<span style='font-weight:bold;'>Cidade: </span> $aluno[cidade] &nbsp; &nbsp;
<span style='font-weight:bold;'>UF: </span> $aluno[uf] <br/><br/><br/>
</div>
<p style='font-size: 11px; font-weight:bold; color: green;'>3. DADOS ACADÊMICOS</p>
<p style='font-size: 11px; color: green;'>__________________________________________________________________________________________________________________________</p>

<div style='font-size: 13px;'>
<span style='font-weight:bold;'>Número de matrícula: </span> $aluno[matricula] <br/><br/>	
<span style='font-weight:bold;'>Curso: </span> $aluno[curso_descricao] <br/><br/>
<span style='font-weight:bold;'>Turma: </span> $aluno[turma_descricao] <br/><br/>
</div>

<p style='font-size: 11px; color: green; margin-top: 45%;'>__________________________________________________________________________________________________________________________</p>
<p style='font-size: 9px; color: green; text-align: center;'>Rua Borba, 2670 - Bairro Iraci - (px. Mercadinho Helen) - Itacoatiara-AM</p>
<p style='font-size: 9px; color: green; text-align: center;'>Email: cei.itacoatiara@zipmail.com - Contato: (91) 3014-0499 / 99500-1498</p>


</div>

 ");
 $mpdf->Output();

 exit;