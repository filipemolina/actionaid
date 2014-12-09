<?php

//Conexão com o banco de dados
include_once "../config/connection.class.php";

//Incluindo o arquivo que contém a função sendNvpRequest
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
  
    //URL da PayPal para redirecionamento, não deve ser modificada
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
} else {
    //credenciais da API para produção
    $user = 'apostolos.michalas_api1.actionaid.org';
    $pswd = 'V64VGGUVTNDGKGZL';
    $signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31ASV9agEO4tkat-f4LLDUzcDJ2O7K';
  
    //URL da PayPal para redirecionamento, não deve ser modificada
    $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
}

//Retirar "R$", vírgulas e espaços vazios, e substituir "," por "." para gravar no banco de dados e enviar
$outroValor = str_replace(array('R$', ' ', '.', ','), array('', '', '', '.'), $_POST['OutroValor']);

//Caso o campo "valorDoacao" não esteja definido, usar "Outro valor"
$valorDoacao = isset($_POST['valorDoacao']) ? $_POST['valorDoacao'] : $outroValor;

//Obter os dados da doação para salvar no banco de dados

$dados['UserId']            = isset($_POST['UserId']) ? $_POST['UserId'] : "";
$dados['NomeDoador']        = isset($_POST['NomeDoador']) ? $_POST['NomeDoador'] : "";
$dados['EmailDoador']       = isset($_POST['EmailDoador']) ? $_POST['EmailDoador'] : "";
$dados['DataAniversario']   = isset($_POST['DataAniversario']) ? $_POST['DataAniversario'] : "";
$dados['CEPDoador']         = isset($_POST['CEPDoador']) ? $_POST['CEPDoador'] : "";
$dados['EnderecoDoador']    = isset($_POST['EnderecoDoador']) ? $_POST['EnderecoDoador'] : "";
$dados['NumeroDoador']      = isset($_POST['NumeroDoador']) ? $_POST['NumeroDoador'] : "";
$dados['ComplementoDoador'] = isset($_POST['ComplementoDoador']) ? $_POST['ComplementoDoador'] : "";
$dados['BairroDoador']      = isset($_POST['BairroDoador']) ? $_POST['BairroDoador'] : "";
$dados['CidadeDoador']      = isset($_POST['CidadeDoador']) ? $_POST['CidadeDoador'] : "";
$dados['EstadoDoador']      = isset($_POST['EstadoDoador']) ? $_POST['EstadoDoador'] : "";
$dados['TelefoneDoador']    = isset($_POST['TelefoneDoador']) ? $_POST['TelefoneDoador'] : "";
$dados['CelularDoador']     = isset($_POST['CelularDoador']) ? $_POST['CelularDoador'] : "";
$dados['AceitoEmail']       = isset($_POST['AceitoEmail']) ? $_POST['AceitoEmail'] : "";
$dados['AceitoPolitica']    = isset($_POST['AceitoPolitica']) ? $_POST['AceitoPolitica'] : "";
$dados['AceitoCelular']     = isset($_POST['AceitoCelular']) ? $_POST['AceitoCelular'] : "";
$dados['valorDoacao']       = $valorDoacao;

//Campos da requisição da operação SetExpressCheckout, como ilustrado acima.
$requestNvp = array(
    'USER' => $user,
    'PWD' => $pswd,
    'SIGNATURE' => $signature,
  
    'VERSION' => '108.0',
    'METHOD'=> 'SetExpressCheckout',
  
    'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
    'PAYMENTREQUEST_0_AMT' => $valorDoacao,
    'PAYMENTREQUEST_0_CURRENCYCODE' => 'BRL',
    'PAYMENTREQUEST_0_ITEMAMT' => $valorDoacao,
  
    'L_PAYMENTREQUEST_0_NAME0' => 'Doação',
    'L_PAYMENTREQUEST_0_DESC0' => 'Doação no valor de R$ '.$valorDoacao,
    'L_PAYMENTREQUEST_0_AMT0' => $valorDoacao,
    'L_PAYMENTREQUEST_0_QTY0' => '1',
  
    'RETURNURL' => 'http://www.doeumfuturodepresente.org.br/campanha/retorno_paypal.php',
    'CANCELURL' => 'http://PayPalPartner.com.br/CancelaFrete',
    'BUTTONSOURCE' => 'BR_EC_EMPRESA'
);
  
//Envia a requisição e obtém a resposta do PayPal
$responseNvp = sendNvpRequest($requestNvp, $sandbox);

//////////////////////////////TODO:

//Inserir no banco de dados
$insert = $con->query(
    "INSERT INTO users_payement (
        user_id, nome, email, cep, endereco, numero, complemento, bairro, cidade, estado, telefone, celular, 
        data_aniversario, valor_doacao, status, forma_pagamento, cod_transacao, newsletter_email, newsletter_celular, created
        ) 
    VALUES (
        '".$dados['UserId']."', 
        '".$dados['NomeDoador']."', 
        '".$dados['EmailDoador']."', 
        '".$dados['CEPDoador']."', 
        '".$dados['EnderecoDoador']."', 
        '".$dados['NumeroDoador']."', 
        '".$dados['ComplementoDoador']."', 
        '".$dados['BairroDoador']."', 
        '".$dados['CidadeDoador']."', 
        '".$dados['EstadoDoador']."', 
        '".$dados['TelefoneDoador']."', 
        '".$dados['CelularDoador']."', 
        '".$dados['DataAniversario']."', 
        '".$dados['valorDoacao']."', 
        'Pendente',
        'Paypal',
        '".$responseNvp['TOKEN']."', 
        '".$dados['AceitoEmail']."', 
        '".$dados['AceitoCelular']."', NOW())");

//Obter o ID dessa transação

//Gravar o ID na sessão para usá-lo como número de pedido

//////////////////////////////TODO:
  
//Se a operação tiver sido bem sucedida, redirecionamos o cliente para o
//ambiente de pagamento.
if (isset($responseNvp['ACK']) && $responseNvp['ACK'] == 'Success') {
    $query = array(
        'cmd'    => '_express-checkout',
        'token'  => $responseNvp['TOKEN']
    );
  
    $redirectURL = sprintf('%s?%s', $paypalURL, http_build_query($query));
    echo $redirectURL;
    //header('Location: ' . $redirectURL);
} else {
    //Opz, alguma coisa deu errada.
    //Verifique os logs de erro para depuração.
}