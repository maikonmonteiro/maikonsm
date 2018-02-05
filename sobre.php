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

<!--imagem título-->
    <link rel="shortcut icon" href="img/icone.ico"/> 
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CEI</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <style>

/*
     .destaque {
                 
            -webkit-perspective: 400; 
        }

    .destaque img {
           
            -webkit-box-shadow:0px 0px 80px rgba(0,0,0,0.2);
            -webkit-transition:0.4s;
            
            -webkit-transform: rotateY(-30deg);

        }

        .destaque:hover img {
            -webkit-transition:0.4s;
            -webkit-transform: rotateY(0deg);
        }

        */

    .efeito {
    width: 300px;
    height: 100px;
    position: relative;
    -webkit-animation-name: example; /* Chrome, Safari, Opera */
    -webkit-animation-duration: 2s; /* Chrome, Safari, Opera */
    animation-name: example;
    animation-duration: 1s;
	margin-left: 28%;
}

/* Chrome, Safari, Opera */
@-webkit-keyframes example {
    0%   {left:0%;}
    25%  {left:10%;}
    50%  {left:0%;}
}

/* Standard syntax */
@keyframes example {
    0%   {left:0%;}
    25%  {left:10%;}
    50%  {left:0%;}
}


</style>

</head>

<body>

<div style="text-align:center; margin-top: 5%;">

<div style="margin-bottom: 3%;">
<section class="destaque">
<img id="img" name="img" style="width: 30%;" src="img/logo.png"/>
</section>
</div>

<h5 style="width: 57%; margin-left: 20%;">Este sistema foi criado pelo desenvolvedor Maikon Monteiro (contato: 92 99218-1483 - maikonsm7@gmail.com), para atender 
as atividades administrativas da empresa CEI, relacionadas ao controle de Alunos e Professores e suas respectivas turmas - Portal do Aluno e Professor. </h5>
</div>

<div style="text-align: center; margin-left: 12%; margin-top: 5%;">
    <h5 style="font-size: 10px;">ENDEREÇO / CONTATO</h5>
    <h5 style="font-size: 10px;">Rua Borba, 2670 - Bairro Iraci - (px. Mercadinho Helen) - Itacoatiara-AM / Fone de contato: (92) 3014-0499 / 99500-1498</h5>
</div>

</body>
</html>