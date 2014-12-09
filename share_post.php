<?php

		require_once( 'Facebook/facebook.php' );

	    error_reporting(E_ALL);
	    ini_set('display_errors', 1);
		date_default_timezone_set("America/Sao_Paulo");		
		include_once "config/connection.class.php";



		function ConsultaConfig($campo){
			global $con;

			$confSQL = $con->query("SELECT $campo FROM config");
			$conf = $con->fetch_object($confSQL);
			return $conf->$campo;
		}
		$mensagem = '';
		$user_id = $_POST['userIDPost'];
		$app_id = $_POST['appIDPost'];
		$access_token = $_POST['tokenPost'];
		if (isset($_POST['mensagemPost'])) {					
			$mensagem = $_POST['mensagemPost'];
		}
		$select_usuario = $con->query("SELECT * FROM users WHERE user_id = '".$user_id."'");
		$usuario = $con->fetch_object($select_usuario);	
	
		//print_r($_SESSION); exit;
	
		if($mensagem != '') {	
			$message = $mensagem;
		} else {
			if ($user_id == '1391292311159873') {
				$message = 'Acabei de criar uma campanha para trocar meus presentes por doações. Assim, você pode doar um futuro para quem precisa. Participa, vai!'. chr(13).chr(10).chr(13).chr(10) . 'http://www.doeumfuturodepresente.org.br/campanha/aniversariodaluiza';
			} else {
				$message = 'Acabei de criar uma campanha para trocar meus presentes por doações. Assim, você pode doar um futuro para quem precisa. Participa, vai!'. chr(13).chr(10).chr(13).chr(10) . 'http://www.doeumfuturodepresente.org.br/campanha/'.$user_id.'';
			}		
		}

		if ($user_id == '1391292311159873') {
			$link = 'http://www.doeumfuturodepresente.org.br/campanha/aniversariodaluiza';
		} else {
			$link = 'http://www.doeumfuturodepresente.org.br/campanha/'.$user_id;
		}
		$picture = 'http://www.doeumfuturodepresente.org.br/images/fundo_post/'.$usuario->causa.$usuario->layout.'.jpg';	
		$config = array(
			'appId' => '1480329455534696',
			'secret' => 'b74f36d85d2f7d089f802f56c7dba7b7',
			'allowSignedRequest' => false, // optional but should be set to false for non-canvas apps
			'fileUpload' => false
		);

		$facebook = new Facebook($config);	
		
		/*$token_url = "https://graph.facebook.com/oauth/access_token?"
			   . "client_id=1480329455534696&redirect_uri=" . urlencode('https://www.doeumfuturodepresente.org.br/')
			   . "&client_secret=b74f36d85d2f7d089f802f56c7dba7b7&code=" . $_REQUEST['FBRLH_state'];
		 
		$response = file_get_contents($token_url);
		$params = null;
		parse_str($response, $params);

		print_r($params); exit;*/
		
		//$dados_usuario = $facebook->api('/me');
		
		//print_r($graphObject2); exit;
		//$access_token = $user->getAccessToken();
		
		$ret_obj = $facebook->api('/me/feed', 'POST',
            array(
                'access_token' => $access_token,
                'link' => $link,               
				'picture' => $picture,
				'caption' => 'Doe um futuro de presente',
                'message' => $message,
				'from' => '1480329455534696',
				'to' => $user_id
            ));

		$update = $con->query("UPDATE users SET ultima_interacao = NOW() WHERE user_id = '".$user_id."'");
		echo 'post enviado';
	  // get response

		//echo '<script type="text/javascript" language="javascript">alert("Seu post foi compartilhado com sucesso!")</script>';
?>