<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	include_once "../config/connection.class.php";

	function ConsultaConfig($campo){
		global $con;

		$confSQL = $con->query("SELECT $campo FROM config");
		$conf = $con->fetch_object($confSQL);
		return $conf->$campo;
	}
	
	$bank_number = '';
	$creditcard = '';
	$select_transacoes = $con->query("SELECT * FROM users_payement WHERE id_transacao IS NOT NULL AND status = 'Pendente'");

	while($transacoes	= $con->fetch_object($select_transacoes)){
		$url = 'https://ws.pagseguro.uol.com.br/v2/transactions/'.$transacoes->id_transacao.'/?email=it.brazil@actionaid.org&token=82B972E35FEA48FC9FEED31767645298';	

		$curl = curl_init($url);
	 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$xml= curl_exec($curl);
		curl_close($curl);

		$transaction = simplexml_load_string($xml);

		$data_usually_array = explode('-', $transaction->lastEventDate);
		
		$dia = strstr($data_usually_array[2], 'T', true);
		
		$data_usually = $dia.'/'.$data_usually_array[1].'/'.$data_usually_array[0];
		
		$forma_pagamento = $transaction->paymentMethod->type;
		
		$codigo_pagamento = $transaction->paymentMethod->code;		
		
		$forename = strstr($transaction->sender->name, ' ', true);

		$surname = strstr($transaction->sender->name, ' ');		
		
		if ($forma_pagamento == '1') {
			$forma_pagamento = 'CC';
		}
		
		if ($forma_pagamento == '2') {
			$forma_pagamento = 'Postalgiro';
		}	
		
		if ($codigo_pagamento == '304') {
			$forma_pagamento = 'DD 001';
		}
		
		if ($codigo_pagamento == '301') {
			$forma_pagamento = 'DD 237';
		}	

		if ($codigo_pagamento == '302') {
			$forma_pagamento = 'DD 341';
		}	


		$forename = strtolower($forename);	
		$forename = ucfirst($forename);
		$forename = utf8_decode($forename);		
		$forename = str_replace('Ô', 'ô', $forename);
		$surname = strtolower($surname);	
		$surname = ucwords($surname);
		$surname = utf8_decode($surname);		
		$surname = str_replace('Ô', 'ô', $surname);				
		echo $forename;
		echo '<br /><br />';
		echo $surname;
		echo '<br /><br />';		
		echo $data_usually;
		echo '<br /><br />';	
		echo $forma_pagamento;
		echo '<br /><br />';
		if ($forma_pagamento == 'CC') {
			if ($codigo_pagamento == '101') {
				$creditcard = 'Visa';
				echo $creditcard;
				echo '<br /><br />';
			}
			if ($codigo_pagamento == '102') {
				$creditcard = 'MasterCard';
				echo $creditcard;
				echo '<br /><br />';
			}	
			if ($codigo_pagamento == '103') {
				$creditcard = 'American Express';
				echo $creditcard;
				echo '<br /><br />';
			}					
			if ($codigo_pagamento == '105') {
				$creditcard = 'Hipercard';
				echo $creditcard;
				echo '<br /><br />';
			}				
		} 
		if (($forma_pagamento == 'DD 341') || ($forma_pagamento == 'DD 237') || ($forma_pagamento == 'DD 001')) {
			$forma_pagamento_array = explode(' ', $forma_pagamento);
			$bank_number = $forma_pagamento_array[1];
			echo $bank_number;
			echo '<br /><br />';
		}		
		if ($transaction->status == '1') {
			$status = 'Aguardando pagamento';
		}
		if ($transaction->status == '2') {
			$status = 'Em analise';
		}
		if ($transaction->status == '3') {
			$status = 'Pago';
		}
		if ($transaction->status == '6') {
			$status = 'Devolvida';
		}	
		if ($transaction->status == '7') {
			$status = 'Cancelada';
		}
		
		$update_transacao = $con->query("UPDATE users_payement SET status = '".$status."' WHERE id_transacao = '".$transacoes->id_transacao."'");
		// echo "UPDATE users_payement SET usually = '".$data_usually."', forma_pagamento = '".$forma_pagamento."', bandeira = '".$creditcard."', numero_banco = '".$bank_number."', forename = '".$forename."', surname = '".$surname."'  WHERE id_transacao = '".$transacoes->id_transacao."'";
		// echo "<br /><br />";
	}
?>