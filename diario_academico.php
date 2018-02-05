<?php 
 include("MPDF57/mpdf.php");

include_once "funcoes/conexao.php";
  $pdo=conectar();

  $rodape = "
  <div style='margin-left: 1%;'>
  <p style='font-size: 10px; color: green;'>___________________________________________________________________________________________________________________________________________________</p>
<p style='font-size: 9px; color: green; text-align: center;'>Rua Borba, 2670 - Bairro Iraci - (px. Mercadinho Helen) - Itacoatiara-AM</p>
<p style='font-size: 9px; color: green; text-align: center;'>Email: cei.itacoatiara@zipmail.com - Contato: (91) 3014-0499 / 99500-1498</p>
</div>
  ";

  $lista = "";

 if (isset($_GET['t']) && isset($_GET['d']) && isset($_GET['tipo'])) {
    $idT = $_GET['t'];
    $idD = $_GET['d'];
    $t_desc = $_GET['t_desc'];
    $d_desc = $_GET['d_desc'];
    $tipo = $_GET['tipo'];
    $instituicao = $_GET['institu'].".png";
    $cont = 1;

     // professor
     $listarProfessor = $pdo->query("SELECT * FROM disciplina d, professor p WHERE iddisciplina = '$idD' AND d.professor_idprofessor = p.idprofessor");
     $professor = $listarProfessor->fetch(PDO::FETCH_ASSOC);

     // professor
     $listarDisciplina = $pdo->query("SELECT * FROM disciplina WHERE iddisciplina = '$idD'");
     $disciplina = $listarDisciplina->fetch(PDO::FETCH_ASSOC);

    if ($tipo == "notas") {

        // notas
     $listarAlunosDatas = $pdo->query("SELECT * FROM nota n, aluno a, disciplina d WHERE n.aluno_idaluno = a.idaluno AND n.disciplina_iddisciplina = d.iddisciplina AND a.turma_idturma = '$idT' AND n.disciplina_iddisciplina = '$idD' LIMIT 1");

      while($ln1 = $listarAlunosDatas->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln1 as $listar1){

        $lista .= "

        <p style='font-size: 10px; font-weight:bold; color: green;'>DADOS DA DISCIPLINA E TURMA</p>
<p style='font-size: 10px; color: green;'>___________________________________________________________________________________________________________________________________________________</p>

<div style='font-size: 10px;'>
<span style='font-weight:bold;'>Disciplina: </span> $d_desc  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <span style='font-weight:bold;'>Professor: </span> $professor[nome] / <span style='font-weight:bold;'>Maior Titulação: </span> $professor[titulacao] <br/><br/>
<span style='font-weight:bold;'>Turma: </span> $t_desc &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style='font-weight:bold;'>Datas das aulas: </span> $listar1->data1 | $listar1->data2 | $listar1->data3 &nbsp; <br/><br/>
<span style='font-weight:bold;'>Ementa: </span> $listar1->ementa

</div>

<p style='font-size: 10px; color: green;'>___________________________________________________________________________________________________________________________________________________</p>

        <table width='665' style='font-size: 9px; font-weight:bold; text-align: center; color: white;'>

    <tr>
        <td style='border: 0.5px solid green; text-align: center; width: 40px; background-color: #2E8B57;'>Ordem</td>
        <td style='border: 0.5px solid green; text-align: center; width: 60px; background-color: #2E8B57;'>Matrícula</td>
        <td style='border: 0.5px solid green; width: 210px; background-color: #2E8B57;'>Nome</td>
        <td style='border: 0.5px solid green; text-align: center; width: 50px; background-color: #2E8B57; font-size: 7px;'>$listar1->data1</td>
        <td style='border: 0.5px solid green; text-align: center; width: 50px; background-color: #2E8B57; font-size: 7px;'>$listar1->data2</td>
        <td style='border: 0.5px solid green; text-align: center; width: 50px; background-color: #2E8B57; font-size: 7px;'>$listar1->data3</td>
        <td style='border: 0.5px solid green; text-align: center; width: 35px; background-color: #2E8B57;'>N1</td>
        <td style='border: 0.5px solid green; text-align: center; width: 35px; background-color: #2E8B57;'>N2</td>
        <td style='border: 0.5px solid green; text-align: center; width: 35px; background-color: #2E8B57;'>N3</td>
        <td style='border: 0.5px solid green; text-align: center; width: 35px; background-color: #2E8B57;'>Média</td>
        <td style='border: 0.5px solid green; text-align: center; background-color: #2E8B57;'>Situação</td>
   </tr></table>";
}}

   // notas
     $listarAlunosNotas = $pdo->query("SELECT * FROM nota n, aluno a, disciplina d WHERE n.aluno_idaluno = a.idaluno AND a.situacao = 'cursando' AND n.disciplina_iddisciplina = d.iddisciplina AND  a.turma_idturma = '$idT' AND n.disciplina_iddisciplina = '$idD' ORDER BY a.nome");

     while($ln = $listarAlunosNotas->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar){

        $lista .= "

        <table width='665' style='font-size: 10px;'>

    <tr>
        <td style='border: 0.5px solid green; text-align: center; width: 40px;'>$cont</td>
        <td style='border: 0.5px solid green; text-align: center; width: 60px;'>$listar->matricula</td>
        <td style='border: 0.5px solid green; width: 210px;'>$listar->nome</td>
        <td style='border: 0.5px solid green; text-align: center; width: 50px;'>$listar->freq1</td>
        <td style='border: 0.5px solid green; text-align: center; width: 50px;'>$listar->freq2</td>
        <td style='border: 0.5px solid green; text-align: center; width: 50px;'>$listar->freq3</td>
        <td style='border: 0.5px solid green; text-align: center; width: 35px;'>$listar->nota1</td>
        <td style='border: 0.5px solid green; text-align: center; width: 35px;'>$listar->nota2</td>
        <td style='border: 0.5px solid green; text-align: center; width: 35px;'>$listar->nota3</td>
        <td style='border: 0.5px solid green; text-align: center; width: 35px; font-weight:bold;'>$listar->media</td>";
        
        if($listar->media >= 7){
              
        $lista .= "<td style='border: 0.5px solid green; text-align: center; color: blue;'>aprovado</td>";
        
    }else{
        
         $lista .= "<td style='border: 0.5px solid green; text-align: center; color: red;'>reprovado</td>";
       
    }

     $lista .= "</tr></table>";
     $cont++;

       }

   }
 }
 else{

    $lista .= "

    <p style='font-size: 10px; font-weight:bold; color: green;'>DADOS DA DISCIPLINA E TURMA</p>
<p style='font-size: 10px; color: green;'>___________________________________________________________________________________________________________________________________________________</p>

<div style='font-size: 10px;'>
<span style='font-weight:bold;'>Disciplina: </span> $d_desc  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <span style='font-weight:bold;'>Professor: </span> $professor[nome] / <span style='font-weight:bold;'>Maior Titulação: </span> $professor[titulacao] <br/><br/>
<span style='font-weight:bold;'>Turma: </span> $t_desc &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style='font-weight:bold;'>Datas das aulas: </span> ____/____/______&nbsp;,&nbsp;____/____/______&nbsp;,&nbsp;____/____/______ <br/><br/>
<span style='font-weight:bold;'>Ementa: </span> $disciplina[ementa]
</div>

<p style='font-size: 10px; color: green;'>___________________________________________________________________________________________________________________________________________________</p>

        <table width='640' style='font-size: 9px; font-weight:bold; text-align: center; color: white;'>

    <tr>
        <td style='border: 0.5px solid green; text-align: center; width: 40px; background-color: #2E8B57;'>Ordem</td>
        <td style='border: 0.5px solid green; text-align: center; width: 50px; background-color: #2E8B57;'>Matrícula</td>
        <td style='border: 0.5px solid green; width: 220px; background-color: #2E8B57;'>Nome</td>
        <td style='border: 0.5px solid green; text-align: center; width: 60px; background-color: #2E8B57;'>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
        <td style='border: 0.5px solid green; text-align: center; width: 60px; background-color: #2E8B57;'>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
        <td style='border: 0.5px solid green; text-align: center; width: 60px; background-color: #2E8B57;'>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
        <td style='border: 0.5px solid green; text-align: center; width: 40px; background-color: #2E8B57;'>N1</td>
        <td style='border: 0.5px solid green; text-align: center; width: 40px; background-color: #2E8B57;'>N2</td>
        <td style='border: 0.5px solid green; text-align: center; width: 40px; background-color: #2E8B57;'>N3</td>
        <td style='border: 0.5px solid green; text-align: center; width: 50px; background-color: #2E8B57;'>Média</td>
   </tr></table>";

// notas
     $listarAlunos = $pdo->query("SELECT * FROM aluno WHERE turma_idturma = '$idT' AND situacao = 'cursando' ORDER BY nome");
     $cont = 1;
     while($ln = $listarAlunos->fetchALL(PDO::FETCH_OBJ)){

       foreach($ln as $listar){

        $lista .= "

        <table width='640' style='font-size: 10px;'>

    <tr>
        <td style='border: 0.5px solid green; text-align: center; width: 40px;'>$cont</td>
        <td style='border: 0.5px solid green; text-align: center; width: 50px; font-weight:bold;'>$listar->matricula</td>
        <td style='border: 0.5px solid green; width: 220px;'>$listar->nome</td>
        <td style='border: 0.5px solid green; width: 60px;'></td>
        <td style='border: 0.5px solid green; width: 60px;'></td>
        <td style='border: 0.5px solid green; width: 60px;'></td>
        <td style='border: 0.5px solid green; width: 40px;'></td>
        <td style='border: 0.5px solid green; width: 40px;'></td>
        <td style='border: 0.5px solid green; width: 40px;'></td>
        <td style='border: 0.5px solid green; width: 50px;'></td>
       </tr></table>";
      
       $cont++;
       }

   }
 }
}

 $mpdf=new mPDF(); 
 $mpdf->SetDisplayMode('fullpage');
 $mpdf->SetHTMLFooter($rodape);
 $mpdf->WriteHTML("

<style>

</style>
  
<img id='img' name='img' style='width: 10%; margin-left: 1%; float: left;' src='img/instituicoes/$instituicao'/>

<p style='font-size: 8px; text-align: center; margin-top: 5%;'>CENTRO DE ENSINO DE ITACOATIARA - CEI</p>
<h4 style='text-align: center;'>DIÁRIO ACADÊMICO</h4>

<div style='margin-left: 1%;'>

$lista

</div>

 ");

$anotacoes = "";
for ($i=0; $i < 25; $i++) { 
   $anotacoes .= "
   <tr>
   <td style='border: 0.5px solid green;'>&nbsp;</td>
   </tr>
   <tr>
   <td style='border: 0.5px solid green; background-color: #cde4c5;'>&nbsp;</td>
   </tr>
   ";
}
 

 $mpdf->AddPage();

 $mpdf->WriteHTML("

    <br/><br/>

<table width='670' style='font-size: 11px; color: white; border-spacing: 0px;'>

    <tr>
        <th style='border: 0.5px solid green; text-align: center; background-color: #2E8B57;'>Detalhes do Conteúdo</th>

    </tr>    

        $anotacoes


</table>



 ");

 $mpdf->Output();

 exit;