<?php

include_once "../config/connection.class.php";

function ConsultaConfig($campo){
	global $con;

	$confSQL = $con->query("SELECT $campo FROM config");
	$conf = $con->fetch_object($confSQL);
	return $conf->$campo;
}

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';

	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;

	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
	$rand = mt_rand(1, $len);
	$retorno .= $caracteres[$rand-1];
	}
	return $retorno;
}


    /*[OutroValor] => 
    [NomeDoador] => 
    [EmailDoador] => 
    [CEPDoador] => 
    [EnderecoDoador] => 
    [NumeroDoador] => 
    [ComplementoDoador] => 
    [BairroDoador] => 
    [CidadeDoador] => 
    [EstadoDoador] => 
    [TelefoneDoador] => 
    [CelularDoador] => */

$separa = explode(" ", $_POST['TelefoneDoador']);
$telefone_pagseguro = str_replace("-","", $separa[1]);
$texto = array(
'(' => '',
')' => '');

$user_id = $_POST['UserId'];
$nome = $_POST['NomeDoador'];
$email = $_POST['EmailDoador'];
$aniversario = $_POST['DataAniversario'];
$cep = $_POST['CEPDoador'];
$endereco = $_POST['EnderecoDoador'];
$numero = $_POST['NumeroDoador'];
$complemento = $_POST['ComplementoDoador'];
$bairro = $_POST['BairroDoador'];
$cidade = $_POST['CidadeDoador'];
$estado = $_POST['EstadoDoador'];
$telefone = $_POST['TelefoneDoador'];
$celular = $_POST['CelularDoador'];
$valor_doacao = $_POST['valorDoacao'];
$outro_valor = $_POST['OutroValor'];
$newsletter_email = $_POST['AceitoEmail'];
$newsletter_celular = $_POST['AceitoCelular'];
$status = 'Pendente';
$cod_transacao = geraSenha(6, true, true);	
$layout = $_POST['Layout'];
if($outro_valor != '') {
	$outro_valor = str_replace('R$ ', '', $outro_valor);
	$valor_doacao = $outro_valor;
}
if ($newsletter_email != 'on') {
	$newsletter_email = 'Nao';
} else {
	$newsletter_email = 'Sim';
}

if ($newsletter_celular != 'on') {
	$newsletter_celular = 'Nao';
} else {
	$newsletter_celular = 'Sim';
}

$nome = utf8_decode($nome);
$endereco = utf8_decode($endereco);
$cidade = utf8_decode($cidade);
$complemento = utf8_decode($complemento);
$bairro = utf8_decode($bairro);
$cep_pagseguro = str_replace('.','',$cep);
$cep_pagseguro = str_replace('-','',$cep_pagseguro);

$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';
$codigo_area = strtr("$separa[0]", $texto);

//$data = 'email=seuemail@dominio.com.br&amp;token=95112EE828D94278BD394E91C4388F20&amp;currency=BRL&amp;itemId1=0001&amp;itemDescription1=Notebook Prata&amp;itemAmount1=24300.00&amp;itemQuantity1=1&amp;itemWeight1=1000&amp;itemId2=0002&amp;itemDescription2=Notebook Rosa&amp;itemAmount2=25600.00&amp;itemQuantity2=2&amp;itemWeight2=750&amp;reference=REF1234&amp;senderName=Jose Comprador&amp;senderAreaCode=11&amp;senderPhone=56273440&amp;senderEmail=comprador@uol.com.br&amp;shippingType=1&amp;shippingAddressStreet=Av. Brig. Faria Lima&amp;shippingAddressNumber=1384&amp;shippingAddressComplement=5o andar&amp;shippingAddressDistrict=Jardim Paulistano&amp;shippingAddressPostalCode=01452002&amp;shippingAddressCity=Sao Paulo&amp;shippingAddressState=SP&amp;shippingAddressCountry=BRA';
/*
Caso utilizar o formato acima remova todo código abaixo até instrução $data = http_build_query($data);
*/

$data['email'] = 'it.brazil@actionaid.org';  
$data['token'] = '82B972E35FEA48FC9FEED31767645298';  
$data['currency'] = 'BRL';
$data['itemId1'] = '0001'; 
$data['itemDescription1'] = utf8_decode('Doação para a campanha'); // Definir nome da campanha
$data['itemAmount1'] = $valor_doacao; // Valor da doação
$data['itemQuantity1'] = '1';
$data['itemWeight1'] = '0';
$data['reference'] = $cod_transacao;
$data['senderName'] = $nome; // Nome do comprador
$data['senderAreaCode'] = $codigo_area; // Codigo de area do comprador
$data['senderPhone'] = $telefone_pagseguro; // Telefone do comprador
$data['senderEmail'] = $email; // Email do comprador
$data['shippingType'] = '3';
$data['shippingAddressStreet'] = $endereco; // Endereço do comprador
$data['shippingAddressNumber'] = $numero; // Número da casa, apt, etc. do comprador
$data['shippingAddressComplement'] = $complemento; // Complemento do comprador
$data['shippingAddressDistrict'] = $bairro; // Bairro do comprador
$data['shippingAddressPostalCode'] = $cep_pagseguro; // CEP do comprador
$data['shippingAddressCity'] = $cidade; // Cidade do comprador
$data['shippingAddressState'] = $estado; // UF do comprador
$data['redirectURL'] = 'http://www.doeumfuturodepresente.com.br/campanha/retorno.php';
$data = http_build_query($data);
 
$curl = curl_init($url);
 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
$xml= curl_exec($curl);
 
if($xml == 'Unauthorized'){
//Insira seu código de prevenção a erros
 
header('Location: erro.php?tipo=autenticacao');
exit;//Mantenha essa linha
}
curl_close($curl);
 
$xml= simplexml_load_string($xml);
if(count($xml -> error) > 0){

var_dump($xml->error);
//Insira seu código de tratamento de erro, talvez seja útil enviar os códigos de erros.
echo $xml->code;

//header('Location: erro.php?tipo=dadosInvalidos');
exit;
}
$insert = $con->query("INSERT INTO users_payement (user_id, nome, email, cep, endereco, numero, complemento, bairro, cidade, estado, telefone, celular, data_aniversario, valor_doacao, status, cod_transacao, newsletter_email, newsletter_celular, created) VALUES ('".$user_id."', '".$nome."', '".$email."', '".$cep."', '".$endereco."', '".$numero."', '".$complemento."', '".$bairro."', '".$cidade."', '".$estado."', '".$telefone."', '".$celular."', '".$aniversario."', '".$valor_doacao."', '".$status."', '".$cod_transacao."', '".$newsletter_email."', '".$newsletter_email."', NOW())");
echo $xml->code;
//header('Location: https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $xml -> code);