<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa			       	  |
// | 																	                                    |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares						            |
// +----------------------------------------------------------------------+

//adicionar boleto ao aluno
session_start();
include_once "funcoes/conexao.php";
$pdo = conectar();

if ($_GET['funcao']=="gerar") {

$buscarB = $pdo->prepare("SELECT * FROM boleto WHERE aluno_idaluno = :idaluno AND data_vencimento = :venc AND valor_boleto = :valor");
	$buscarB->bindValue(":idaluno", $_GET['idaluno']);
	$buscarB->bindValue(":venc", $_GET['vencimento']);
	$buscarB->bindValue(":valor", $_GET['valor']);
	$buscarB->execute();

	if($buscarB->rowCount()>0){
		echo "<meta http-equiv='refresh' content='0; URL=../financeiro.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Boleto já existe para o aluno!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
	}else{

		if($_GET['vencimento']=="" || $_GET['valor']==""){

			echo "<meta http-equiv='refresh' content='0; URL=../financeiro.php'>
		<script type=\"text/javascript\">
		alert(\"Erro: Preencha a data de vencimento e o valor!\");
		</script>";
		
		return die; // a página morre! não executa mais o restante dos códigos
		}else{

	// gerar nova matrícula
	$BuscarNumBoleto = $pdo->query("SELECT * FROM num_boleto WHERE idnum_boleto = 1 LIMIT 1");    
    $NumBoleto = $BuscarNumBoleto->fetch(PDO::FETCH_ASSOC);
    $novo_num = $NumBoleto['numero_bol'] + 1;

  			// atualiza o novo número de matrícula
    $editarNumBoleto = $pdo->prepare("UPDATE num_boleto SET numero_bol = :numero WHERE idnum_boleto = :id");
	$editarNumBoleto->bindValue(":numero", $novo_num);
	$editarNumBoleto->bindValue(":id", 1);
	$editarNumBoleto->execute();

	// inserir novo boleto
	$inserirBoleto = $pdo->prepare("INSERT INTO boleto (data_vencimento, data_documento, data_processamento, numero_boleto, valor_boleto, aluno_idaluno, arq_remessa) VALUES (:data, :data_documento, :data_processamento,  :num, :valor_boleto, :idaluno, :arq_remessa)");
	$inserirBoleto->bindValue(":data", $_GET['vencimento']);
	$inserirBoleto->bindValue(":data_documento", date("d/m/Y"));
	$inserirBoleto->bindValue(":data_processamento", date("d/m/Y"));
	$inserirBoleto->bindValue(":num", $novo_num);
	$inserirBoleto->bindValue(":valor_boleto", $_GET['valor']);
	$inserirBoleto->bindValue(":idaluno", $_GET['idaluno']);
	$inserirBoleto->bindValue(":arq_remessa", "nao");
	$inserirBoleto->execute();

}}}
if ($_GET['funcao']=="buscar") {

	$idB = $_GET['id_boleto'];

// buscar boleto
	$BuscarBoleto = $pdo->query("SELECT * FROM boleto b, aluno a WHERE b.idboleto = '$idB' AND b.aluno_idaluno = a.idaluno LIMIT 1");    
    $boleto = $BuscarBoleto->fetch(PDO::FETCH_ASSOC);


}
	

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0;

if ($_GET['funcao']=="buscar") {

$data_venc = $boleto['data_vencimento']; //date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $boleto['valor_boleto']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal

}else {

$data_venc = $_GET['vencimento']; //date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $_GET['valor']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal

}

$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = "37040018785";  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!

if ($_GET['funcao']=="buscar") {
$dadosboleto["numero_documento"] = $boleto['numero_boleto'];
}else{
$dadosboleto["numero_documento"] = $novo_num;	
}

$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA

if ($_GET['funcao']=="buscar") {
$dadosboleto["data_documento"] = $boleto['data_documento']; // Data de emissão do Boleto
$dadosboleto["data_processamento"] = $boleto['data_processamento']; // Data de processamento do boleto (opcional)

}else{

$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)

}
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE

if ($_GET['funcao']=="buscar") {

$dadosboleto["sacado"] = $boleto['nome'];
$dadosboleto["endereco1"] = "CPF: ".$boleto['cpf'];
$dadosboleto["endereco2"] = "Endereço: ".$boleto['logradouro'];

}else{

$dadosboleto["sacado"] = $_GET['nome'];
$dadosboleto["endereco1"] = "CPF: ".$_GET['cpf'];
$dadosboleto["endereco2"] = "Endereço: ".$_GET['logradouro'];

}
// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento do boleto em todas agências do Bradesco ou Lotérica";
$dadosboleto["demonstrativo2"] = "Pagamento de mensalidade <br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "CEI - http://www.ceiita.com.br";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento e 0,60 R$ por dia de atraso";
$dadosboleto["instrucoes2"] = "- Receber até 6 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: cei.itacoatiara2017@zipmail.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = "3704"; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = "4"; // Digito do Num da agencia
$dadosboleto["conta"] = "0018785"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = "0102003"; // ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"] = "4"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "09";  // Código da Carteira: pode ser 06 ou 03

// SEUS DADOS
$dadosboleto["identificacao"] = "CENTRO EDUCACIONAL DE ITACOATIARA - CEI";
$dadosboleto["cpf_cnpj"] = "18.811.163/0001-10";
$dadosboleto["endereco"] = "Rua Borba, 2670 - Bairro Iraci - (px. Mercadinho Helen)";
$dadosboleto["cidade_uf"] = "Itacoatiara / Amazonas";
$dadosboleto["cedente"] = "ROZENDO E MAIA LTDA - ME";

// NÃO ALTERAR!
include("boleto/include/funcoes_bradesco.php");
include("boleto/include/layout_bradesco.php");



?>
