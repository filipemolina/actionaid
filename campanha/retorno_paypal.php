<?php 

//Conexão com o banco de dados
include_once "../config/connection.class.php";

//Inclui o arquivo que contém a função sendNvpRequest
require 'sendNvpRequest.php';

//Vai usar o Sandbox, ou produção?
$sandbox = true;

//Baseado no ambiente, sandbox ou produção, definimos as credenciais
//e URLs da API.
if ($sandbox) {

    //credenciais da API para o Sandbox
    $user = 'conta-business_api1.test.com';
    $pswd = '1365001380';
    $signature = 'AiPC9BjkCyDFQXbSkoZcgqH3hpacA-p.YLGfQjc0EobtODs.fMJNajCx';

} else {

    //credenciais da API para produção
    $user = 'apostolos.michalas_api1.actionaid.org';
    $pswd = 'V64VGGUVTNDGKGZL';
    $signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31ASV9agEO4tkat-f4LLDUzcDJ2O7K';

}

//Token da transação e ID do usuário que efetuou a doação
$token   = $_GET['token'];
$payerId = $_GET['PayerID'];

//Campos da operação GetExpressCheckoutDetails
$requestNvp = array
(
	'USER' => $user,
    'PWD' => $pswd,
    'SIGNATURE' => $signature,
  
    'VERSION' => '108.0',
    'METHOD' => 'GetExpressCheckoutDetails',
    'TOKEN' => $token
);

//Obter os detalhes da transação
$responseNvp = sendNvpRequest($requestNvp, $sandbox);

$valorDoacao = $responseNvp['AMT'];

//Campos da operação DoExpressCheckoutPayment
$requestNvp = array
(
	'USER' => $user,
    'PWD' => $pswd,
    'SIGNATURE' => $signature,
  
    'VERSION'                        => '108.0',
    'METHOD'                         => 'DoExpressCheckoutPayment',
    'TOKEN'                          => $token,
	'PAYERID'                        => $payerId,

	'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
	'PAYMENTREQUEST_0_AMT'           => $valorDoacao,
	'PAYMENTREQUEST_0_CURRENCYCODE'  => 'BRL',
	'PAYMENTREQUEST_0_ITEMAMT'       => $valorDoacao,

	'L_PAYMENTREQUEST_0_NAME0'       => 'Doação',
	'L_PAYMENTREQUEST_0_DESC0'       => 'Doação no valor de '.$valorDoacao,
	'L_PAYMENTREQUEST_0_AMT0'        => $valorDoacao,
	'L_PAYMENTREQUEST_0_QTY0'        => '1',
);

$responseNvp = sendNvpRequest($requestNvp, $sandbox);

/*
	Status
	---------

	None – No Status.
	Canceled-Reversal – A reversal has been canceled; for example, when you win a dispute and the funds for the reversal have been returned to you.
	Completed – The payment has been completed, and the funds have been added successfully to your account balance.
	Denied – You denied the payment. This happens only if the payment was previously pending because of possible reasons described for the PendingReason element.
	Expired – the authorization period for this payment has been reached.
	Failed – The payment has failed. This happens only if the payment was made from your buyer's bank account.
	In-Progress – The transaction has not terminated, e.g. an authorization may be awaiting completion.
	Partially-Refunded – The payment has been partially refunded.
	Pending – The payment is pending. See the PendingReason field for more information.
	Refunded – You refunded the payment.
	Reversed – A payment was reversed due to a chargeback or other type of reversal. The funds have been removed from your account balance and returned to the buyer. The reason for the reversal is specified in the ReasonCode element.
	Processed – A payment has been accepted.
	Voided – An authorization for this transaction has been voided.
	Completed-Funds-Held – The payment has been completed, and the funds have been added successfully to your pending balance. 

	-Caso o status seja "Denied ou Pending", verificar o campo 'PAYMENTINFO_0_PENDINGREASON'.
	-Caso o status seja "Reversed", verificar o campo 'PAYMENTINFO_0_REASONCODE'.

*/

//Informações sobre a transação

$transacao['ack']       = $responseNvp['ACK'];
$transacao['status']    = $responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'];
$transacao['amt']       = $responseNvp['PAYMENTINFO_0_AMT'];
$transacao['errorcode'] = $responseNvp['PAYMENTINFO_n_ERRORCODE'];

//Testar se a transação foi bem sucedida

if($transacao['ack'] == "Success" && $transacao['status'] == "Completed")
{
	//Atualizar o status da transação para "Pago"

	$query = $con->query("UPDATE users_payement SET status = 'Pago' WHERE cod_transacao = '".$token."';");	

	echo "<h1>Transação Efetuada com Sucesso! Token: $token</h1>";

	//Criar uma função que verifica se o token existe na tabela de pagamentos, caso verdadeiro abrir o popup para a foto
	//Escrevendo nesse arquivo para fins de teste

	$query = $con->query("SELECT * FROM users_payement WHERE cod_transacao = '$token'");

	$numero  = $con->num_rows($query);

	echo "<p>Número de transações encontradas: $numero</p>";
}
else
{
	echo $transacao['status']." -> ".$transacao['errorcode']." -> ".$responseNvp['PAYMENTINFO_0_PENDINGREASON']."<br/>";
}