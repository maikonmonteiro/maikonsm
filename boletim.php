<?php 
 include("MPDF57/mpdf.php");

include_once "funcoes/conexao.php";
  $pdo=conectar();

  $rodape = "
  <div style='margin-left: 5%;'>
  <p style='font-size: 10px; color: green;'>_______________________________________________________________________________________________________________________________________</p>
<p style='font-size: 9px; color: green; text-align: center;'>Rua Borba, 2670 - Bairro Iraci - (px. Mercadinho Helen) - Itacoatiara-AM</p>
<p style='font-size: 9px; color: green; text-align: center;'>Email: cei.itacoatiara@zipmail.com - Contato: (91) 3014-0499 / 99500-1498</p>
</div>
  ";

  $notas = "";

 if (isset($_GET['id'])) {
    $idc = $_GET['id'];

    // aluno
     $listarAluno = $pdo->query("SELECT * FROM aluno a, turma t, curso c WHERE idaluno = '$idc' AND a.turma_idturma = t.idturma AND t.curso_idcurso = c.idcurso");
     $aluno = $listarAluno->fetch(PDO::FETCH_ASSOC);
    
    // notas
     $listarNota = $pdo->query("SELECT * FROM nota n, disciplina d WHERE n.disciplina_iddisciplina = d.iddisciplina AND n.aluno_idaluno = '".$aluno['idaluno']."'");

     while($ln = $listarNota->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar){

        $notas .= "

        <table width='610' style='font-size: 10px; text-align: center;'>

        <tr>
        <td style='border: 0.5px solid green; text-align: center; background-color: #2E8B57; width: 210px; color: white;' ROWSPAN='2'>$listar->descricao_disciplina</td>
        <td style='border: 0.5px solid green; background-color: #2E8B57; width: 60px; color: white;'>$listar->data1</td>
         <td style='border: 0.5px solid green; background-color: #2E8B57; width: 60px; color: white;'>$listar->data2</td>
          <td style='border: 0.5px solid green; background-color: #2E8B57; width: 60px; color: white;'>$listar->data3</td>
         <td style='border: 0.5px solid green; background-color: #2E8B57; width: 30px; color: white;'>N1</td>
         <td style='border: 0.5px solid green; background-color: #2E8B57; width: 30px; color: white;'>N2</td>
         <td style='border: 0.5px solid green; background-color: #2E8B57; width: 30px; color: white;'>N3</td>
         <td style='border: 0.5px solid green; background-color: #2E8B57; width: 40px; color: white;'>Média</td>
         <td style='border: 0.5px solid green; background-color: #2E8B57; width: 40px; color: white;'>Situação</td>
    </tr>

    <tr>
        
        <td style='border: 0.5px solid green;'>$listar->freq1</td>
        <td style='border: 0.5px solid green;'>$listar->freq2</td>
        <td style='border: 0.5px solid green;'>$listar->freq3</td>
        <td style='border: 0.5px solid green;'>$listar->nota1</td>
        <td style='border: 0.5px solid green;'>$listar->nota2</td>
        <td style='border: 0.5px solid green;'>$listar->nota3</td>
        <td style='border: 0.5px solid green; font-weight: bold;'>$listar->media</td>";
        
    
     if($listar->media >= 7){
              
        $notas .= "<td style='border: 0.5px solid green; text-align: center; color: blue;'>aprovado</td>";
        
    }else{
        
         $notas .= "<td style='border: 0.5px solid green; text-align: center; color: red;'>reprovado</td>";
       
    }

     $notas .= "</tr></table>";

       }

   }
 }

 $mpdf=new mPDF(); 
 $mpdf->SetDisplayMode('fullpage');
 $mpdf->SetHTMLFooter($rodape);
 $mpdf->WriteHTML("

<style type='text/css'>
    
</style>
  

<img id='img' name='img' style='width: 10%; margin-left: 5%; float: left;' src='img/logo.png'/>

<p style='font-size: 8px; text-align: center;'>CENTRO DE ENSINO DE ITACOATIARA - CEI</p>
<h4 style='text-align: center;'>BOLETIM DE NOTAS DO ALUNO</h4>

<div style='margin-left: 5%;'>

<p style='font-size: 10px; font-weight:bold; color: green;'>DADOS DO ALUNO</p>
<p style='font-size: 10px; color: green;'>_______________________________________________________________________________________________________________________________________</p>

<div style='font-size: 10px;'>
<span style='font-weight:bold;'>Nome: </span> $aluno[nome] <br/><br/> 
<span style='font-weight:bold;'>CPF: </span> $aluno[cpf] &nbsp;
<span style='font-weight:bold;'>RG: </span> $aluno[rg] &nbsp;
<span style='font-weight:bold;'>Nascimento: </span> $aluno[nascimento] &nbsp;
<span style='font-weight:bold;'>Telefone: </span> $aluno[telefone] <br/><br/>
<span style='font-weight:bold;'>Sexo: </span> $aluno[sexo] &nbsp;
<span style='font-weight:bold;'>Estado civil: </span> $aluno[estado_civil] &nbsp;
<span style='font-weight:bold;'>Email: </span> $aluno[email] <br/><br/>
<span style='font-weight:bold;'>Curso: </span> $aluno[curso_descricao] &nbsp;
<span style='font-weight:bold;'>Turma: </span> $aluno[turma_descricao] <br/>

</div>

<p style='font-size: 10px; color: green;'>_______________________________________________________________________________________________________________________________________</p>

$notas

</div>

 ");
 $mpdf->Output();

 exit;