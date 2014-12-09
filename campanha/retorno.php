<?php
include_once "../config/connection.class.php";

function ConsultaConfig($campo){
	global $con;

	$confSQL = $con->query("SELECT $campo FROM config");
	$conf = $con->fetch_object($confSQL);
	return $conf->$campo;
}

$transaction_id = $_POST['code'];
$url = 'https://ws.pagseguro.uol.com.br/v2/transactions/'.$transaction_id.'/?email=it.brazil@actionaid.org&token=82B972E35FEA48FC9FEED31767645298';
$curl = curl_init($url);
 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$xml= curl_exec($curl);
curl_close($curl);

$transaction = simplexml_load_string($xml);
// echo "UPDATE users_payement SET id_transacao = '".$transaction_id."' WHERE cod_transacao = '".$transaction->reference."'";
$update_transacao = $con->query("UPDATE users_payement SET id_transacao = '".$transaction_id."' WHERE cod_transacao = '".$transaction->reference."'");

?>