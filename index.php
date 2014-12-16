<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('X-Frame-Options: GOFORIT');  
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
	/*session_start();
	date_default_timezone_set('America/Sao_Paulo');
	 
	function facebookLoader($class) {
		require "Facebook/" . str_replace("\\", "/", $class) . ".php";
	}

	spl_autoload_register("facebookLoader");
	
	
	require_once( 'Facebook/FacebookSession.php' );
	require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
	require_once( 'Facebook/FacebookRequest.php' );
	require_once( 'Facebook/FacebookResponse.php' );
	require_once( 'Facebook/FacebookSDKException.php' );
	require_once( 'Facebook/FacebookRequestException.php' );
	require_once( 'Facebook/FacebookAuthorizationException.php' );
	require_once( 'Facebook/GraphObject.php' );
	
	include 'Facebook/FacebookSession.php';
	include 'Facebook/FacebookRedirectLoginHelper.php';
	include 'Facebook/FacebookRequest.php';
	include 'Facebook/FacebookResponse.php';
	include 'Facebook/FacebookSDKException.php';
	include 'Facebook/FacebookOtherException.php';
	include 'Facebook/FacebookRequestException.php';
	include 'Facebook/FacebookAuthorizationException.php';
	include 'Facebook/GraphObject.php';
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookOtherException;	
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	
	// init app with app id (APPID) and secret (SECRET)
	FacebookSession::setDefaultApplication('1480329755534666','e03240f51a7bf23c7c96d2c84ebcd2fc');
	 
	// login helper with redirect_uri
	$helper = new FacebookRedirectLoginHelper( 'http://www.doeumfuturodepresente.org.br/actionaid_app/index_app.php' );
	 
	try {
	  $session = $helper->getSessionFromRedirect();
	  $session = new FacebookSession($_SESSION['token']);
	} catch( FacebookRequestException $ex ) {
	  // When Facebook returns an error
	} catch( Exception $ex ) {
	  // When validation fails or other local issues
	}
	 
	// see if we have a session
	if ( isset( $session ) ) {
	  // graph api request for user data
	  $request = new FacebookRequest( $session, 'GET', '/me' );
	  $response = $request->execute();
	  // get response
	  $graphObject = $response->getGraphObject();
	   
	  // print data
	  echo  print_r( $graphObject, 1 );
	} else {
		echo $helper->getLoginUrl();
		//header($helper->getLoginUrl());
	  // show login url
	  //echo '<a href="' . $helper->getLoginUrl() . '">Login</a>';
	}*/
	date_default_timezone_set("America/Sao_Paulo");		
	include_once "config/connection.class.php";

	function ConsultaConfig($campo){
		global $con;

		$confSQL = $con->query("SELECT $campo FROM config");
		$conf = $con->fetch_object($confSQL);
		return $conf->$campo;
	}
	require_once( 'Facebook/FacebookHttpable.php' );
	require_once( 'Facebook/FacebookCurl.php' );
	require_once( 'Facebook/FacebookCurlHttpClient.php' );
	 
	// added in v4.0.0
	require_once( 'Facebook/FacebookSession.php' );
	require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
	require_once( 'Facebook/FacebookRequest.php' );
	require_once( 'Facebook/FacebookResponse.php' );
	require_once( 'Facebook/FacebookSDKException.php' );
	require_once( 'Facebook/FacebookRequestException.php' );	
	require_once( 'Facebook/FacebookServerException.php' );
	require_once( 'Facebook/FacebookOtherException.php' );
	require_once( 'Facebook/FacebookAuthorizationException.php' );
	require_once( 'Facebook/GraphObject.php' );
	require_once( 'Facebook/GraphSessionInfo.php' );
	require_once( 'Facebook/facebook.php' );
	 
	// added in v4.0.5
	use Facebook\FacebookHttpable;
	use Facebook\FacebookCurl;
	use Facebook\FacebookCurlHttpClient;
	 
	// added in v4.0.0
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;	
	use Facebook\FacebookServerException;	
	use Facebook\FacebookOtherException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\GraphSessionInfo;
	 
	// start session
	 session_start(); 
	// init app with app id and secret
	FacebookSession::setDefaultApplication( '1480329455534696','b74f36d85d2f7d089f802f56c7dba7b7' );
	 
	// login helper with redirect_uri
	$helper = new FacebookRedirectLoginHelper( 'https://www.doeumfuturodepresente.org.br/' );
	 
	// see if a existing session exists
	if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
	  // create new session from saved access_token
	  $session = new FacebookSession( $_SESSION['fb_token'] );
	  
	  // validate the access_token to make sure it's still valid
	  try {
		if ( !$session->validate() ) {
		  $session = null;
		}
	  } catch ( Exception $e ) {
		// catch any exceptions
		$session = null;
	  }
	  
	} else {
	  // no session exists
	  
	  try {
		$session = $helper->getSessionFromRedirect();
	  } catch( FacebookRequestException $ex ) {
		// When Facebook returns an error
	  } catch( Exception $ex ) {
		// When validation fails or other local issues
		//echo $ex->message;
	  }
	  
	}
	 
	// see if we have a session
	if ( isset( $session ) ) {
	  
	  // save the session
	  $_SESSION['fb_token'] = $session->getToken();
	  // create a session using saved token or the new one we generated at login
	  $session = new FacebookSession( $session->getToken() );
	  
	  // graph api request for user data
	  $request = new FacebookRequest( $session, 'GET', '/me' );
	  $response = $request->execute();
	  // get response
	  $graphObject = $response->getGraphObject()->asArray();

	  
	  
	  
	  // print profile data
	  //echo '<pre>'.print_r( $graphObject, 1).'</pre>';
	  
	  // print logout url using session and redirect_uri (logout.php page should destroy the session)
	  //echo '<a href="' . $helper->getLogoutUrl( $session, 'http://yourwebsite.com/app/logout.php' ) . '">Logout</a>';
	  
	} else {
	  // show login url
	  //echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends', 'user_about_me' ) ) . '">Login</a>';
		  //echo $_SESSION['fb_token'];
	}

	if(isset($_POST['submit'])) {	


	}

	if(isset($_POST['submit_campanha'])) {	
		$select_usuario = $con->query("SELECT * FROM users WHERE user_id = '".$graphObject['id']."'");
		$usuario = $con->fetch_object($select_usuario);	
		//print_r($_SESSION); exit;
	
		$message = 'Acabei de criar uma campanha para trocar meus presentes por doações. Assim, você pode doar um futuro para quem precisa. Participa, vai!'. chr(13).chr(10).chr(13).chr(10) . 'http://www.doeumfuturodepresente.org.br/campanha/'.$graphObject["id"].'';
		$link = 'http://www.doeumfuturodepresente.org.br/campanha/'.$graphObject["id"];
		$picture = 'http://www.doeumfuturodepresente.org.br/images/fundo_post/'.$usuario->causa.$usuario->layout.'.jpg';
		$config = array(
			'appId' => '1480329455534696',
			'secret' => 'b74f36d85d2f7d089f802f56c7dba7b7',
			'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
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
                'access_token' => $_SESSION['fb_token'],
                'link' => $link,
				'picture' => $picture,
				'caption' => 'Doe um futuro de presente',
                'message' => $message,
				'from' => '1480329455534696',
				'to' => $graphObject['id']
            ));

	?>

	<script type="text/javascript" language="javascript">Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Seu post foi compartilhado com sucesso!</p>');</script>
	<?php
		header("Location: https://www.doeumfuturodepresente.org.br");
	}

	function geraTimestamp($data) {
		$partes = explode('/', $data);
		return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
	}
		//print_r($_REQUEST);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no">
	<meta property="og:title" content="ActionAid"/>
	<meta property="og:type" content="product"/>
	<meta property="og:url" content="http://www.doeumfuturodepresente.org.br/"/>
	<meta property="og:image" content="http://www.renoi.de/images/lg.jpg"/>
	<meta property="og:site_name" content="Doe um futuro de presente"/>
	<meta property="og:description" content="Mudar o mundo é mais simples do que parece. Começa com você. Então por que não trocar aqueles presentes que você não precisa por uma causa? CRIE SUA CAMPANHA DE DOAÇÃO E APOIE A ACTIONAID. SEUS AMIGOS VÃO CURTIR ESSA IDÉIA!"/>		
  	<title>ActionAid - Doe Um Futuro de Presente</title>	
	
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="stylesheets/colorbox.css" />
	<link rel="stylesheet" type="text/css" href="stylesheets/base.css" />	
	<link rel="stylesheet" type="text/css" href="stylesheets/sexyalertbox.css" />
	<link rel="stylesheet" type="text/css" href="stylesheets/owl.carousel.css" />
	<link rel="stylesheet" type="text/css" href="stylesheets/owl.theme.css" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	
	<link rel="stylesheet" href="stylesheets/ezmark.css" media="all">	
	<script type="text/javascript" language="Javascript" src="javascripts/jquery.ezmark.min.js"></script>	
	
	<script src="javascripts/jquery.colorbox-min.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>	
	<script type="text/javascript" language="Javascript" src="javascripts/ui.datepicker-pt-BR.js"></script>	
	<script type="text/javascript" language="Javascript" src="javascripts/jquery.maskMoney.js"></script>	
	<script type="text/javascript" language="Javascript" src="javascripts/sexyalertbox.v1.2.jquery.js"></script>			
	<script type="text/javascript" language="Javascript" src="javascripts/owl.carousel.min.js"></script>
	<script type="text/javascript" language="javascript">
		/*function caixa_de_alerta(mensagem, campo)
		{
		 $.msgbox(mensagem, {
		   type: "alert",
		   buttons: [{
		     type: "cancel",
		     value: "OK"
		   }]
		 }, function () {
		   if (campo != "") {
		     $('#' + campo).focus();
		     $('#' + campo).val("");
		   }
		 });
		}

		function caixa_de_informacao(mensagem)
		{
		 $.msgbox(mensagem, {
		   type: "info",
		   buttons: [{
		     type: "cancel",
		     value: "OK"
		   }]
		 });
		}	*/
		/*function sem_acento(e,args)
		{		
			if (document.all){var evt=event.keyCode;} // caso seja IE
			else{var evt = e.charCode;}	// do contrário deve ser Mozilla
			var valid_chars = '0123456789abcdefghijlmnopqrstuvxzwykABCDEFGHIJLMNOPQRSTUVXZWYK-_'+args;	// criando a lista de teclas permitidas
			var chr= String.fromCharCode(evt);	// pegando a tecla digitada
			if (valid_chars.indexOf(chr)>-1 ){return true;}	// se a tecla estiver na lista de permissão permite-a
			// para permitir teclas como <BACKSPACE> adicionamos uma permissão para 
			// códigos de tecla menores que 09 por exemplo (geralmente uso menores que 20)
			if (valid_chars.indexOf(chr)>-1 || evt < 9){return true;}	// se a tecla estiver na lista de permissão permite-a
			return false;	// do contrário nega
		}*/
		
		$(document).ready(function (){

			// Countdown
			
		    $(".countdown").keyup(function(event){
		 
		        var target    = $(this).parent().parent().find('.target-countdown');
		        var max        = target.attr('title');
		        var len     = $(this).val().length;
		        var remain    = max - len;
		        if(len > max)
		        {
		            var val = $(this).val();
		            $(this).val(val.substr(0, max));
		            remain = 0;
		        }

		        if (remain <= 1) {
		        	target.html(remain + ' caracter restante');
		        } else {
		        	target.html(remain + ' caracteres restantes');		        	
		        }

		    });
		     
		    //Carrossel

		    $('.carrossel').owlCarousel({
		    	items          : 3,
		    	pagination     : false,
		    	navigation     : true,
		    	navigationText : ["ANTERIORES", "PRÓXIMAS"],
		    });
		    
			$( "#Fim" ).datepicker();
			$( "#Fim" ).datepicker('option', 'minDate', new Date());
			
			$('.submenu_admin .btn_apoiadores').click(function() {
				$('.apoiadores').show();
				$('.valor').hide();
				$('.tempo').hide();
			});	

			$('.submenu_admin .btn_apoiadores').hover(function() {
				$('.submenu_admin .btn_apoiadores img').attr('src', 'images/apoiadores_menu_on.png');
				$('.submenu_admin .btn_valor img').attr('src', 'images/valor_menu_off.png');
				$('.submenu_admin .btn_tempo img').attr('src', 'images/tempo_menu_off.png');				
			});	

			$('.submenu_admin .btn_valor').hover(function() {
				$('.submenu_admin .btn_valor img').attr('src', 'images/valor_menu_on.png');
				$('.submenu_admin .btn_apoiadores img').attr('src', 'images/apoiadores_menu_off.png');
				$('.submenu_admin .btn_tempo img').attr('src', 'images/tempo_menu_off.png');					
			});	

			$('.submenu_admin .btn_tempo').hover(function() {
				$('.submenu_admin .btn_tempo img').attr('src', 'images/tempo_menu_on.png');
				$('.submenu_admin .btn_apoiadores img').attr('src', 'images/apoiadores_menu_off.png');
				$('.submenu_admin .btn_valor img').attr('src', 'images/valor_menu_off.png');				
			});	
			
			$('.submenu_admin .btn_apoiadores').mouseout(function() {
				$('.submenu_admin .btn_tempo img').attr('src', 'images/tempo_menu_off.png');
				$('.submenu_admin .btn_apoiadores img').attr('src', 'images/apoiadores_menu_off.png');
				$('.submenu_admin .btn_valor img').attr('src', 'images/valor_menu_off.png');				
			});	
			
			$('.submenu_admin .btn_valor').mouseout(function() {
				$('.submenu_admin .btn_tempo img').attr('src', 'images/tempo_menu_off.png');
				$('.submenu_admin .btn_apoiadores img').attr('src', 'images/apoiadores_menu_off.png');
				$('.submenu_admin .btn_valor img').attr('src', 'images/valor_menu_off.png');				
			});		
			
			$('.submenu_admin .btn_tempo').mouseout(function() {
				$('.submenu_admin .btn_tempo img').attr('src', 'images/tempo_menu_off.png');
				$('.submenu_admin .btn_apoiadores img').attr('src', 'images/apoiadores_menu_off.png');
				$('.submenu_admin .btn_valor img').attr('src', 'images/valor_menu_off.png');				
			});					
			
			$('.submenu_admin .btn_valor').click(function() {
				$('.valor').show();
				$('.tempo').hide();
				$('.apoiadores').hide();
			});	
			
			$('.submenu_admin .btn_tempo').click(function() {
				$('.tempo').show();
				$('.valor').hide();
				$('.apoiadores').hide();
			});	
			
			$('#Ini').change(function(){
			    var d1 = $(this).datepicker("getDate");
				d1.setDate(d1.getDate() + 0);
				var d2 = $(this).datepicker("getDate");
				d2.setDate(d2.getDate() + 30);				
				$("#Fim").datepicker("setDate", null);
				$("#Fim").datepicker("option", "minDate", d1);
				$("#Fim").datepicker("option", "maxDate", d2);			
			});
			
			$('.upload').change(function() {
				$('#uploadFile').val($(this).val());
			});	
			
			$("#OutroValor").maskMoney({showSymbol:true, symbol:"R$ ", decimal:".", thousands:""});
	
			$('.teste_valor').click(function() {
				mensagem = 'Esse ano resolvi fazer uma comemoração diferente. Para isso, preciso que você me ajude fazendo uma doação para Act!onaid.';
				$('#Descricao').val($('#Descricao').val()+ mensagem);
				setTimeout($(".countdown").trigger('keyup'),2008); 
			});	
			
			$('.escreva_sua').click(function() {
				$('#Descricao').val(''); 
			});				
			
			$(".upload").click(function(){
				if ($('#fotoPerfil').is(':checked')) {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Desmarque a opção "Usar minha foto do perfil"</p>');
					return false;
				}
			});		
			
			
			$("#fotoPerfil").click(function(){
				$("#uploadFile").val('');
			});			
			
			$("#OutroValor").click(function(){
				$(".ez-radio").removeClass('ez-selected');
				$("input:radio").attr('checked', false);				
			});			
			
			$("input:radio").click(function(){
				$("#OutroValor").val('');			
			});
			
			/*$(function(){
				$('input,textarea').focus(function(){
					$(this).attr('placeholder','');
				});				
			});*/
			
			/* PLACEHOLDERS CROSSBROWSER */
			function add() {
				if($(this).val() == ''){
					$(this).val($(this).attr('placeholder')).addClass('placeholder');
				}
			}
			function remove() {
				if($(this).val() == $(this).attr('placeholder')){
					$(this).val('').removeClass('placeholder');
				}
			}
			if (!('placeholder' in $('<input>')[0])) { // Create a dummy element for feature detection
				$('input[placeholder], textarea[placeholder]').blur(add).focus(remove).each(add); // Select the elements that have a placeholder attribute
				$('form').submit(function(){$(this).find('input[placeholder], textarea[placeholder]').each(remove);}); // Remove the placeholder text before the form is submitted
			}
			/* */

			$('.bt-next').click(function() {
				var next_step = $(this).attr('to');				
				if(next_step == '2') {	
					$('body').css('overflow', 'none');
					$('html').css('overflow', 'none');
					//$('#content').css('height', '1280px');							
					if($('#lista_causas li').hasClass('item-causa-ativo')) {
						$(this).parent().hide();
						
						$('body, html').animate({scrollTop:0},600);							
						$('.step-bar-vermelho_2').animate({
							'width' : '+=136px'
						}, 1000, function() {
							$('.step-bar_2').addClass('step-bar-ativo');
							$('#step_'+next_step).fadeIn();
						});
						causa = $('.item-causa-ativo').attr('value');
						$('input[name="Causa"]').val(causa);
					} else {
						Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Selecione uma causa primeiro.</p>');
						return false;
					}
				}
				if(next_step == '3') {
					$('body').css('overflow', 'hidden');
					$('html').css('overflow', 'hidden');
					//$('#content').css('height', '800px');				
					$(this).parent().hide();
					
					$('body, html').animate({scrollTop:0},600);					
					$('.step-bar-vermelho_3').animate({
						'width' : '+=136px'
					}, 1000, function() {
						$('.step-bar_3').addClass('step-bar-ativo');
						$('#step_'+next_step).fadeIn();
					});
				}
				if(next_step == '4') {
					$(this).parent().hide();
					
					$('body, html').animate({scrollTop:0},600);										
					$('.step-bar-vermelho_4').animate({
						'width' : '+=136px'
					}, 1000, function() {
						$('.step-bar_4').addClass('step-bar-ativo');
						$('#step_'+next_step).fadeIn();
					});
				}
			});
			
			$('.button-step').click(function() {
				//$(this).parent().hide();
				var next_step = $(this).attr('to');
				
				$('body, html').animate({scrollTop:0},600);

				if(next_step == '1') {
					$('body').css('overflow', 'hidden');
					$('html').css('overflow', 'hidden');
					//$('#content').css('height', '800px');					
					$('.step-bar-vermelho_2').animate({
						'width' : '-=136px'
					}, 1000, function() {
						$('.step-bar_1').addClass('step-bar-ativo');
						$('#step_'+next_step).fadeIn();
						$('#step_2').fadeOut();
						$('.step-bar_2').removeClass('step-bar-ativo');						
					});
				}				
				if(next_step == '2') {
					$('.step-bar-vermelho_3').animate({
						'width' : '-=136px'
					}, 1000, function() {
						$('.step-bar_2').addClass('step-bar-ativo');
						$('#step_'+next_step).fadeIn();
						$('#step_3').fadeOut();
						$('.step-bar_3').removeClass('step-bar-ativo');							
					});
				}
				if(next_step == '3') {
					$('body').css('overflow', 'hidden');
					$('html').css('overflow', 'hidden');
					//$('#content').css('height', '800px');				
					$('.step-bar-vermelho_4').animate({
						'width' : '-=136px'
					}, 1000, function() {
						$('.step-bar_3').addClass('step-bar-ativo');
						$('#step_'+next_step).fadeIn();
						$('#step_4').fadeOut();
						$('.step-bar_4').removeClass('step-bar-ativo');	
					});
				}
			});	

			$('.btn_voltar_2').click(function(){ 
				$('.step-bar-vermelho_3').animate({
					'width' : '-=136px'
				}, 1000, function() {
					$('.step-bar_2').addClass('step-bar-ativo');
					$('#step_2').fadeIn();
					$('#step_3').fadeOut();
					$('.step-bar_3').removeClass('step-bar-ativo');							
				});				
			});			
			
			$('.bt-criar_minha_campanha').click(function() {
				$('#intro').hide();
				$('#container_step_bar').fadeIn();
				$('#step_1').fadeIn();
			});
			
			$('input').ezMark();
			
			$('#lista_causas li').hover(function() {
				$(this).css({'background':'#f4f4f4'});
			}, function() {
				$(this).css({'background':'#fff'});
			});
			
			$('#lista_causas li').click(function() {
				if($(this).hasClass('item-causa-ativo')) {
					$(this).animate({
						'margin-top': '+=18px'
					}, 100, function() {
						$(this).removeClass('item-causa-ativo');
						$(this).children('.titulo-causa').css({'text-decoration':'none'});
						$(this).css({
							'background':'#fff',
							'border':'2px solid #e3e4e8',
						});
						$('#lista_causas li').css({'opacity':'10'});	
					});
				} else {				
					if($('#lista_causas li').hasClass('item-causa-ativo')) {
						$('.item-causa-ativo').animate({
							'margin-top': '+=18px'
						}, 100, function() {
							$(this).removeClass('item-causa-ativo');
							$(this).children('.titulo-causa').css({'text-decoration':'none'});
							$(this).css({
								'background':'#fff',
								'border':'2px solid #e3e4e8',
							});
						});
					}
					$(this).animate({
						'margin-top': '-=18px'
					}, 100, function() {
						$('#lista_causas li').css({'opacity':'0.5'});
					
						$(this).addClass('item-causa-ativo');
						$(this).children('.titulo-causa').css({'text-decoration':'underline'});
						$(this).css({
							'background':'#f4f4f4',
							'border':'2px solid #bcbcbc',
							'opacity':'10'
						});
					});
				}
			});
			
						
			$('.button-descricao-causa').click(function(e) {	
				e.stopPropagation();
				if($(this).attr('state') == 'more') {
					$(this).attr('state', 'close');
					$(this).text('x');
					$(this).parent().prev().prev().children('.descricao-foto-causa').show();
				} else {
					$(this).attr('state', 'more');
					$(this).text('+');
					$(this).parent().prev().prev().children('.descricao-foto-causa').hide();
				}
			});
			
			$('.youtube').colorbox({iframe:true, innerWidth:640, innerHeight:390});
			
			 $("#exemplo_aniversario").colorbox({
				 width:"659px", 
				 height:"330px", 
				 inline:true, 
				 href:"#cb_exemplo_aniversario",
				 onOpen:function(){
					nome_campanha = $('#NomeCampanha').val();
					nome_usuario = $('#name_for_facebook').text().toUpperCase();
					descricao = $('#Descricao').val();
					if (nome_campanha != '') {
						$('#cb_exemplo_aniversario .texto h1').text(nome_campanha);	
					}
					if (descricao != '') {					
						$('#cb_exemplo_aniversario .texto .descricao').text(descricao);
					}
					$('#cb_exemplo_aniversario .texto .usuario').text('por ' + nome_usuario);		
				 }
			 });
			 
			 $("#exemplo_pascoa").colorbox({
				 width:"659px", 
				 height:"330px", 
				 inline:true, 
				 href:"#cb_exemplo_pascoa",
				 onOpen:function(){
					nome_campanha = $('#NomeCampanha').val();
					nome_usuario = $('#name_for_facebook').text().toUpperCase();
					descricao = $('#Descricao').val();
					if (nome_campanha != '') {
						$('#cb_exemplo_pascoa .texto h1').text(nome_campanha);	
					}
					if (descricao != '') {					
						$('#cb_exemplo_pascoa .texto .descricao').text(descricao);
					}
					$('#cb_exemplo_pascoa .texto .usuario').text('por ' + nome_usuario);		
				 }
			 });

			 $("#exemplo_natal").colorbox({
				 width:"659px", 
				 height:"330px", 
				 inline:true, 
				 href:"#cb_exemplo_natal",
				 onOpen:function(){
					nome_campanha = $('#NomeCampanha').val();
					nome_usuario = $('#name_for_facebook').text().toUpperCase();
					descricao = $('#Descricao').val();
					if (nome_campanha != '') {
						$('#cb_exemplo_natal .texto h1').text(nome_campanha);	
					}
					if (descricao != '') {					
						$('#cb_exemplo_natal .texto .descricao').text(descricao);
					}
					$('#cb_exemplo_natal .texto .usuario').text('por ' + nome_usuario);		
				 }
			 });

			 $("#exemplo_1").colorbox({
				 width:"659px", 
				 height:"330px", 
				 inline:true, 
				 href:"#cb_exemplo_1",
				 onOpen:function(){
					nome_campanha = $('#NomeCampanha').val();
					nome_usuario = $('#name_for_facebook').text().toUpperCase();
					descricao = $('#Descricao').val();
					if (nome_campanha != '') {
						$('#cb_exemplo_1 .texto h1').text(nome_campanha);	
					}
					if (descricao != '') {					
						$('#cb_exemplo_1 .texto .descricao').text(descricao);
					}
					$('#cb_exemplo_1 .texto .usuario').text('por ' + nome_usuario);		
				 }
			 });

			$("#exemplo_2").colorbox({
				 width:"659px", 
				 height:"330px", 
				 inline:true, 
				 href:"#cb_exemplo_2",
				 onOpen:function(){
					nome_campanha = $('#NomeCampanha').val();
					nome_usuario = $('#name_for_facebook').text().toUpperCase();
					descricao = $('#Descricao').val();
					if (nome_campanha != '') {
						$('#cb_exemplo_2 .texto h1').text(nome_campanha);	
					}
					if (descricao != '') {					
						$('#cb_exemplo_2 .texto .descricao').text(descricao);
					}
					$('#cb_exemplo_2 .texto .usuario').text('por ' + nome_usuario);		
				 }
			 });
			 
			 $("#exemplo_3").colorbox({
				 width:"659px", 
				 height:"330px", 
				 inline:true, 
				 href:"#cb_exemplo_3",
				 onOpen:function(){
					nome_campanha = $('#NomeCampanha').val();
					nome_usuario = $('#name_for_facebook').text().toUpperCase();
					descricao = $('#Descricao').val();
					if (nome_campanha != '') {
						$('#cb_exemplo_3 .texto h1').text(nome_campanha);	
					}
					if (descricao != '') {					
						$('#cb_exemplo_3 .texto .descricao').text(descricao);
					}
					$('#cb_exemplo_3 .texto .usuario').text('por ' + nome_usuario);		
				 }
			 });			 
				 
			$('.estilo').hover(function() {
				$(this).children('.ver-exemplo').show();
				$(this).children('.escolher').show();				
			}, function() {
				$(this).children('.ver-exemplo').hide();
				$(this).children('.escolher').hide();				
			});
			
			$('.ver-exemplo').hover(function() {
				$(this).css({'opacity':'0.8'});
			}, function() {
				$(this).css({'opacity':'0.5'});
			});
			$('.escolher').hover(function() {
				$(this).css({'opacity':'0.8'});
			}, function() {
				$(this).css({'opacity':'0.5'});
			});
			
			$('.escolher').click(function() {
				if($(this).hasClass('item-estilo-ativo')) { //SE CLICOU NA QUE JA ESTA SELECIONADA
					$(this).animate({
					}, 100, function() {
						$(this).parent().removeClass('item-estilo-ativo');
						$('.estilo').css({'opacity':'0.5'});	
					});
				} else {				
					if($('.estilo').hasClass('item-estilo-ativo')) { //SE JA TEM ALGUMA JA SELECIONADA
						$('.item-estilo-ativo').animate({
						}, 100, function() {
							$(this).parent().find('.item-estilo-ativo').removeClass('item-estilo-ativo');
						});
						$('.estilo').css({'opacity':'0.5'});							
					}
					$(this).animate({
					}, 100, function() {
						$('.estilo').css({'opacity':'0.5'});
						$(this).parent().addClass('item-estilo-ativo');
						$(this).parent().css({
							'opacity':'10'
						});
					});
				}
				layout = $('.item-estilo-ativo').attr('value');
				$('#Layout').val(layout);
			});			
			
			/*
			$('.estilo').hover(function() {
				$(this).css({'opacity':'10'});
			}, function() {
				$(this).css({'opacity':'0.5'});
			});
			*/
			
			$("#formCadastro").submit(function (e) {	
				e.preventDefault();
			    if (document.formCadastro.NomeCampanha.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o nome da campanha.</p>');
					$("#NomeCampanha").focus();
					return false;
			    }	

			    if (document.formCadastro.DataFim.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o término da campanha.</p>');
					$("#Fim").focus();
					return false;
			    }

			    if (document.formCadastro.DataFim.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o término da campanha.</p>');
					$("#Fim").focus();
					return false;
			    }	

			    if (document.formCadastro.uploadFile.value == "") {
			    	if (!$('#fotoPerfil').is(':checked')) {
						Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Faça upload de uma foto ou selecione a foto de perfil</p>');
						$('body, html').animate({scrollTop:200},600);	
						return false;			    		
			    	}
			    }

			    if ((document.formCadastro.OutroValor.value == "") || (document.formCadastro.OutroValor.value == "R$ 0.00")) {
			    	if (!$('input[name="valorArrecadado"]').is(':checked')) {
			    		Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha com o valor da arrecadação.</p>');			    		
						$('body, html').animate({scrollTop:200},600);	
						return false;			    		
			    	}
			    }

			    if (document.formCadastro.Descricao.value == "") {
			    	Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha a descrição da campanha.</p>');
					$("#Descricao").focus();
					return false;
			    }

			    if(!$('.estilo').hasClass('item-estilo-ativo')) {
			    	Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Escolha um fundo para a sua campanha.</p>');
					return false;
			    }			    			    			    		    
				$('body, html').animate({scrollTop:200},600);	
				$('.loading').fadeIn();
				var formData = new FormData($(this)[0]);
				if ($('#fotoPerfil').is(':checked')) {
					var foto = $('#photo_for_facebook').attr('src');
				} else {
					var foto = $('input[name="FotoCampanha"]').val();
				}
				
				if ($('input[name="valorArrecadado"]').is(':checked')) {
					valor = $('input[name="valorArrecadado"]').val();
				} else {
					valor = $('input[name="OutroValor"]').val();
					valor = valor.replace('R$ ','');
				}				
				
				$.ajax({
					type: "POST",
					url: "salvar_dados.php",
					data: new FormData( this ),
					processData: false,
					contentType: false,					
					success: function (resposta) {
						if (resposta) {
							$("#preview_campanha").html('');
							$("#preview_campanha").append(resposta);
							$('.step-bar-vermelho_3').animate({
								'width' : '+=136px'
							}, 1000, function() {
								$('.step-bar_3').addClass('step-bar-ativo');
								$('#step_3').fadeIn();
								$('#step_2').fadeOut();
								$('.loading').fadeOut();									
							});							
							/*$("#resultado").html(resposta);
							$("#resultado .acender_vela_sucesso").show();
							$.blockUI({ 
								message: $("#resultado"), 
								css: { top: '20%' } 
							}); 
							$('.blockOverlay').click( function() {
								$.unblockUI();
								window.location.href = '?pg=showvelas';
							}); 
							$('.btnok_vela').click( function() {
								$.unblockUI();
								window.location.href = '?pg=showvelas';
							}); 
							setTimeout( function() { 
								$.unblockUI();
								window.location.href = '?pg=showvelas';
							}, 60000);*/
							
							return false;
						} else {
						
						}
					}
				});

				return false;

			});	

			$("#sharePost").click(function() {		
				$(".textoCompartilhamento").fadeIn();
			});

			$("#registerForm").submit(function(e) {		
				$('.loading').fadeIn();
				e.preventDefault();
				$.ajax({
					type: "POST",
					url: "share_post.php",
					data: new FormData( this ),
					processData: false,
					contentType: false,

					success: function (resposta) {
						if (resposta) {
							$('.loading').fadeOut();
							$(".textoCompartilhamento").fadeOut();
							Sexy.info('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Post compartilhado com sucesso!</p>');
							//window.location.href = 'http://www.doeumfuturodepresente.org.br';
							return false;
						} else {
						
						}
					}
				});				
			});	

			$("#registerForm_campanha").submit(function(e) {		
				$('.loading').fadeIn();
				e.preventDefault();
				$.ajax({
					type: "POST",
					url: "share_post.php",
					data: new FormData( this ),
					processData: false,
					contentType: false,
					success: function (resposta) {
						if (resposta) {
							$('.loading').fadeOut();
							Sexy.info('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Post compartilhado com sucesso!</p>');
							window.location.href = 'http://www.doeumfuturodepresente.org.br';
							return false;
						} else {
						
						}
					}
				});				
			});						
		});	
	</script>	
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=1480329455534696&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
  <div id="container">
		<?php 
		$total = 0;
		if (isset($_SESSION['fb_token'])) {
			if (isset($graphObject['id'])) {
				$verifica_usuario = $con->query("SELECT * FROM users WHERE user_id = '".$graphObject['id']."'");
				$total  = $con->num_rows($verifica_usuario);	
			} else {
				unset($_SESSION['fb_token']);
			}
		}
			if ($total == '0') {
		?>
					<div id="header">
						
				<h1 class="replace lb-header"><img src="images/lb-header.jpg"><strong>ActionAid - Doe um futuro de presente</strong></h1>
				<?php if ( !isset( $session ) ) { ?>
				<div id="container_step_bar">
				<?php } else { ?>
				<div id="container_step_bar" style="display: block;">
				<?php } ?>
					<span class="step-bar step-bar_1 step-bar-ativo button-step" to="1" style="margin-left:0px;">1</span>
						<div class="box-bar">
							<span class="step-bar-cinza"></span>
							<span class="step-bar-vermelho step-bar-vermelho_2"></span>
						</div>
					<span class="step-bar step-bar_2 button-step" to="2">2</span>
						<div class="box-bar">
							<span class="step-bar-cinza"></span>
							<span class="step-bar-vermelho step-bar-vermelho_3 "></span>
						</div>
					<span class="step-bar step-bar_3 button-step"to="3" >3</span>
						<div class="box-bar">
							<span class="step-bar-cinza"></span>
							<span class="step-bar-vermelho step-bar-vermelho_4" ></span>
						</div>
					<span class="step-bar step-bar_4">4</span>
				</div>
			</div>
		<div id="content" style="width: 100%;">


			<!-- DOE UM FUTURO DE PRESENTE -->
			<?php	if ( !isset($_SESSION['fb_token']) ) { ?>
			<div class="content-step" id="intro" style="display:block">
				<p style="/* margin-left: 22px; */text-align: center;/* float: left; */margin-top: 45px;clear: both;font-family: Gotham-Book;font-size: 18px;color: #494949; /* width: 778px; */">
					<font style="font-size:35.95px;color:#6c6c6c;font-family:Gotham-Light;">DOE UM FUTURO<br/>DE PRESENTE!</font>
					<br /><br />
					Mudar o mundo é mais simples do que parece. Começa com você. Então por<br />
					que não trocar aqueles presentes que você não precisa por uma causa?<br />
					<br /><br />
					Pode ser Natal, aniversário, Páscoa ou qualquer data que seja importante para<br />
					você. Porque o mais importante é ajudar a mudar vidas.<br />
					<br /><br />
					<font style="font-family:Gotham-Bold;font-size:18px;color:#494949;">CRIE SUA CAMPANHA DE DOAÇÃO E APOIE A <span style="color:#c80a24">ACTIONAID</span>.<BR />
					SEUS AMIGOS VÃO CURTIR ESSA IDÉIA!</font>
				</p>
				<?php echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends', 'user_about_me', 'publish_actions' ) ) . '" style="text-decoration: none; margin: 0 auto; width: 345px; display: block;">' ?> <span class="bt-green without-select-text" style="/* margin-left:100px; */margin-top:41px;font-family:Gotham-Medium;font-size:20px; /* margin-left: 240px; *//* text-align: center; *//* margin: 0 auto; *//* width: 275px; */">Criar minha campanha</span></a>
				
				<div id="como-funciona" style="margin-top:88px;width: 100%;height:456px;background:url(images/bg-como-funciona.png);float:left;clear:both;">
					<h2 style="font-family:Gotham-Light;font-size:31px;margin:50px 0px 0px 243px;width: 295px;margin: 0 auto;margin-top: 50px;">COMO FUNCIONA</h2>
					
					<div class="replace box-como-funciona" style="margin: 0 auto; margin-top: 54px; margin-bottom: 162px;">
						
						<a class="youtube" href="http://www.youtube.com/embed/qwqfvjy52_8?rel=0&amp;wmode=transparent;autoplay=1">
							<span class="replace bt-play-como-funciona">
								<span class="arrow-right"></span>
							</span>
						</a>
					</div>
				</div>
				<div id="conheca-a-actionaid" style="width: 100%;height:468px;background:transparent;/* float:left; */clear:both;margin: 0 auto;">
					<h2 style="background:#c80a24;font-family:Gotham-Light;font-size:31px;padding: 41px 0px 34px 0px;color:#fff;text-align: center;">CONHEÇA A ACTIONAID</h2>
					<p style="text-align:center;padding:65px 0px 0px 0px;height:335px;background:transparent url(images/bg-conheca-actionaid.jpg) no-repeat top center;font-size:22px;font-family:Gotham-Light;color:#fff;line-height:32px;">Fundada em 1972, a <span style="font-family:Gotham-Bold;">ActionAid</span> é uma organização sem<br />
					fins lucrativos cujo trabalho atinge cerca de 20 milhões<br />
					de pessoas em 45 países.<br />
					<br />
					A <span style="font-family:Gotham-Bold;">ActionAid</span> está no Brasil desde 1999. Nossa atuação<br />
					já envolve 25 organizações parceiras em 13 estados,<br />
					beneficiando mais de 300 mil pessoas em cerca de<br />
					1.300 comunidades.
					</p>
				</div>	
				<div id="como-funciona" style="margin-top:0px;width: 100%;height:300px;background:url(images/bg-como-funciona.png);float:left;clear:both;">
					<h2 style="font-family:Gotham-Light;font-size:31px;margin:50px 0px 0px 243px;width: 540px;margin: 0 auto;margin-top: 50px;">ARRECADADO ATÉ O MOMENTO</h2>
					<div style="width: 800px; margin: 0 auto; padding-top: 50px;">
						<div class="valor">
							<img class="obj-info-campanha" src="campanha/images/obj-atingidos.png" alt="" style="float: left; margin-right: 16px;">
							<div class="info-campanha" style="float: left; line-height: 46px; position: relative; text-align: left; width: 340px;">
								<div style="float:left; width: 300px;">
									<span class="rscifrao-info-campanha" style="color: #C40A24; display: block; float: left; font-family: Gotham-Medium; font-size: 18px; line-height: 18px; margin-right: 6px; margin-top: -18px;">R$</span>
									<span class="numeros-campanha numero-atingidos" style="color: #C40A24; display: block; font-family: Gotham-Medium; font-size: 60px; margin-top: -18px;">
										<?php 
											$valor_arrecadado = $con->query("SELECT SUM(valor_doacao) AS total FROM users_payement WHERE id_transacao IS NOT NULL AND status='Pago' ");
											$doacao = $con->fetch_object($valor_arrecadado);
											if ($doacao->total) {
												echo number_format($doacao->total, 2, ',', '.');
											} else {
												echo '0';			
											}
										?>								
									</span>
								</div>
								<span class="label-campanha lb-atingidos" style="color: #828282; display: block; font-family: Gotham-Book; font-size: 14px;width: 275px;">Valor total arrecadado pela Actionaid</span>
							</div>
						</div>
						<div class="valor">
							<img class="obj-info-campanha" src="images/icon_apoiadores_home.png" alt="" style="float: left; margin-right: 16px;">
							<div class="info-campanha" style="float: left; line-height: 46px; position: relative; text-align: left; width: 250px;">
								<div style="float:left; width: 300px;">
									<span class="numeros-campanha numero-atingidos" style="color: #C40A24; display: block; font-family: Gotham-Medium; font-size: 60px;">
										<?php 
											$campanhas = $con->query("SELECT COUNT(user_id) AS total FROM users WHERE 1 = 1");
											$campanha = $con->fetch_object($campanhas);
											if ($campanha->total) {
												echo $campanha->total;
											} else {
												echo '0';			
											}
										?>								
									</span>
								</div>
								<span class="label-campanha lb-atingidos" style="color: #828282; display: block; font-family: Gotham-Book; font-size: 14px;width: 275px;">Total de campanhas já criadas</span>
							</div>
						</div>						
					</div>	
				</div>	
				<div id="como-funciona" style="margin-top:0px;width: 100%;float:left;clear:both;padding-bottom: 50px;">
					<h2 style="font-family:Gotham-Light;font-size:31px;margin:50px 0px 0px 243px;width: 295px;margin: 0 auto;margin-top: 50px;">TOP CAMPANHAS</h2>
					<div class="carrossel" style="width: 940px; margin: 0 auto;">
					<?php 

						$query_thumbnails = "SELECT users.*, SUM(users_payement.valor_doacao) AS total 
												FROM users, users_payement 

												WHERE users.user_id != 1391292311159873 
												AND users.user_id = users_payement.user_id 
												AND users_payement.status = 'Pago' 
												AND users_payement.id_transacao IS NOT NULL

												GROUP BY users.user_id 
												ORDER BY total DESC
												LIMIT 6;";

						$select_usuario = $con->query($query_thumbnails);
						while($usuario = $con->fetch_object($select_usuario)){
						
							$caminho_layout = "images/previews/preview".$usuario->layout."_home.jpg";
							$caminho_foto_causa = "images/causas/causa".$usuario->causa.".png";								
					?>
					<div class="campanha" style="float: left; position: relative;">
						<a target="_blank" style="position: absolute; top: 50px; height: 210px; width: 297px; left: 12px; z-index: 9999;"href="http://www.doeumfuturodepresente.org.br/campanha/<?php echo $usuario->user_id; ?>"></a>
						<div id="preview_campanha" style="margin-left: 12px; position: relative; margin-top:50px; background-image: url('images/preview_campanha_home.png'); width: 296px; height: 210px;">
						<div id="cb_exemplo_aniversario" style="position: absolute; background-image: url(<?php echo $caminho_layout;?>); height: 135px; color: rgb(255, 255, 255); background-repeat: no-repeat; top: 43px; left: 0px; width: 296px;">
							<?php		//echo "<h1 style='font-family: gabrielaregular; font-size: 7px; text-transform: uppercase;'>".utf8_encode($usuario->campanha)."</h1>"; ?>					
							<img src="<?php echo $caminho_foto_causa;?>" style="width: 65px; height: 80px; position: absolute; top: 30px; left: 5px; z-index: 9999;" />
							<div style="background-image: url(images/foto_perfil_home.png); width: 65px; height: 74px; position: absolute; top: 10px; left: 55px;">
								<?php $pos = stripos($usuario->foto_campanha, "https://");
								if ($pos !== false) { ?>
								<img src="<?php echo $usuario->foto_campanha;?>?type=large" style="position: absolute; width: 48px; top: 9px; left: 9px; -webkit-transform: rotate(3deg); -moz-transform: rotate(3deg); -o-transform:rotate(3deg); -ms-transform:rotate(3deg); filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1.5); height: 51px;" />
								<?php } else { ?>
								<img src="uploads/<?php echo $usuario->foto_campanha;?>" style="position: absolute; width: 48px; top: 9px; left: 9px; -webkit-transform: rotate(3deg); -moz-transform: rotate(3deg); -o-transform:rotate(3deg); -ms-transform:rotate(3deg); filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1.5); height: 51px;" />			
								<?php } ?>								
							</div>
							<div class="texto" style="margin-left: 142px; padding: 23px 0 0 0; width: 155px;height: 112px;">
								<h1 style="font-family: gabrielaregular; font-size: 9px; text-transform: uppercase;"><?php echo utf8_encode($usuario->campanha); ?></h1>
								<p style="font-family: Gotham-Bold; border-top: 1px solid rgba(255, 255, 255, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 0px; font-size: 6px;" class="usuario">por <?php echo utf8_encode(strtoupper($usuario->nome));?></p>
								<p style="font-family: gabrielaregular; font-size: 5px; margin-top: 5px;" class="descricao"><?php echo utf8_encode($usuario->descricao);?></p>
							</div>
							<h1 style="font-family: Gotham-Bold; font-size: 9px; text-transform: uppercase; text-align: center; margin-top: 10px;"><?php echo utf8_encode($usuario->campanha); ?> <span style="text-transform: none;">por</span> <?php echo utf8_encode(strtoupper($usuario->nome)); ?></h1>
						</div>					
						<!--<img src="images/sua_campanha/sua_campanha_preview.png" alt="" />-->
						</div>
						<div style="background-color: white; margin-left: 12px; width: 296px; position: relative;">
							<p style="height: 164px; font-family: Gotham-Book; color: #828282;margin-top: 12px;" class="descricao"><?php echo utf8_encode(str_replace(".", ".<br /><br />\n", $usuario->descricao));?></p>
							<?php 
								$select_doacao = $con->query("SELECT COUNT(t2.id) as apoiadores, t1.valor_arrecadado, SUM(t2.valor_doacao) as total_doacao FROM users t1 INNER JOIN users_payement t2 ON t1.user_id = t2.user_id WHERE t1.user_id = ".$usuario->user_id." AND t2.id_transacao IS NOT NULL AND t2.status='Pago' ORDER BY t1.valor_arrecadado DESC LIMIT 6");
								while($doacao = $con->fetch_object($select_doacao)){
								$porcentagem = round((($doacao->total_doacao / $usuario->valor_arrecadado) * 100), 1);
								?>
								<div class="status" style="width: 100%; color: #000;">
									<div class="padding" style="padding: 1.2em 0em;">
										<p class="progress-percent" style="font-family: Gotham-Medium; font-size: 13px; vertical-align: middle; margin: 0 0 0.8em;">
											<span><?php echo $porcentagem; ?>%</span> Financiado
										</p>
										<div class="progress-bar">
											<div id="progress_wrapper" style="height: 0.4em; border-radius: 6px; box-shadow: inset 0 0 4px #a6a6a6;">
												<div id="progress" style="height: 4px; width: <?php echo $porcentagem; ?>%; background: #00B22D; background-size: 100%; background-image: -moz-linear-gradient(90deg, #00cb33 0%, #00b22d 1%, #00cb33 100%, #00fe40 100%); background-image: -webkit-linear-gradient(90deg, #00cb33 0%, #00b22d 1%, #00cb33 100%, #00fe40 100%); background-image: linear-gradient(0deg, #00cb33 0%, #00b22d 1%, #00cb33 100%, #00fe40 100%);" ></div>
											</div>
										</div>
										<div style="padding-top: 10px;">
											<img src="images/icon_apoiadores_home_campanha.png" /><span style=" margin-left: 5px; font-family: Gotham-Book; font-size: 12px; color: #545454;">
											<?php 
												echo $doacao->apoiadores;
											?>
											 apoiadores
											</span>
											<img src="images/icon_tempo_home_campanha.png" style="margin-left: 15px; "/><span style=" margin-left: 5px; font-family: Gotham-Book; font-size: 12px; color: #545454;">
											<?php 								
												$data_hoje = date('d/m/Y',strtotime(date('Y-m-d'))); 
												//$data_inicial = $usuario->data_inicio;
												$data_final = $usuario->data_fim;
												
												$time_hoje = geraTimestamp($data_hoje);
												//$time_inicial = geraTimestamp($data_inicial);
												$time_final = geraTimestamp($data_final);
												//if ($time_inicial > $time_hoje) {
												//	$diferenca = $time_final - $time_inicial; 
												//} else {
													$diferenca = $time_final - $time_hoje;
												//}
												// Calcula a diferença de dias
												$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias	
												if ($dias < 0) {
													echo "Encerrada";
												} else {
													echo $dias." dias";
												}
											?></span> 
											<br />
											<img src="images/icon_arrecadado_home_campanha.png" /><span style=" margin-left: 5px; font-family: Gotham-Book; font-size: 12px; color: #545454;">R$ 
											<?php echo number_format($doacao->total_doacao, 2, ',', '.'); ?>
											</span>
										</div>
									</div>
								</div>									
								<?php } ?>						
						</div>
					</div>
					<?php } ?>
					</div>
					<!--<div style="width: 800px; margin: 0 auto; padding-top: 50px;">
						<div class="valor">
							<img class="obj-info-campanha" src="campanha/images/obj-atingidos.png" alt="" style="float: left; margin-right: 16px;">
							<div class="info-campanha" style="float: left; line-height: 46px; position: relative; text-align: left; width: 340px;">
								<div style="float:left; width: 300px;">
									<span class="rscifrao-info-campanha" style="color: #C40A24; display: block; float: left; font-family: Gotham-Medium; font-size: 18px; line-height: 18px; margin-right: 6px;">R$</span>
									<span class="numeros-campanha numero-atingidos" style="color: #C40A24; display: block; font-family: Gotham-Medium; font-size: 60px;">
										<?php 
											$valor_arrecadado = $con->query("SELECT SUM(valor_doacao) AS total FROM users_payement WHERE id_transacao IS NOT NULL AND status='Pago' ");
											$doacao = $con->fetch_object($valor_arrecadado);
											if ($doacao->total) {
												echo number_format($doacao->total, 2, ',', '.');
											} else {
												echo '0';			
											}
										?>								
									</span>
								</div>
								<span class="label-campanha lb-atingidos" style="color: #828282; display: block; font-family: Gotham-Book; font-size: 14px;width: 275px;">Valor total arrecadado pela Actionaid</span>
							</div>
						</div>
						<div class="valor">
							<img class="obj-info-campanha" src="images/icon_apoiadores_home.png" alt="" style="float: left; margin-right: 16px;">
							<div class="info-campanha" style="float: left; line-height: 46px; position: relative; text-align: left; width: 250px;">
								<div style="float:left; width: 300px;">
									<span class="numeros-campanha numero-atingidos" style="color: #C40A24; display: block; font-family: Gotham-Medium; font-size: 60px;">
										<?php 
											$campanhas = $con->query("SELECT COUNT(user_id) AS total FROM users WHERE 1 = 1");
											$campanha = $con->fetch_object($campanhas);
											if ($campanha->total) {
												echo $campanha->total;
											} else {
												echo '0';			
											}
										?>								
									</span>
								</div>
								<span class="label-campanha lb-atingidos" style="color: #828282; display: block; font-family: Gotham-Book; font-size: 14px;width: 275px;">Total de campanhas já criadas</span>
							</div>
						</div>						
					</div>-->	
				</div>					
			</div>
			<?php }?>
			<!-- -->
			
			<!-- ESCOLHA SUA CAUSA -->
			<?php	if ( !isset($_SESSION['fb_token']) ) { ?>
			<div class="content-step" id="step_1" style="display: none;">
			<?php } else { ?>
			<p id="name_for_facebook" style="text-transform: uppercase; display: none;"><?php echo $graphObject['name'];?></p>
			<p id="email_for_facebook" style="display: none;"><?php echo $graphObject['email'];?></p>	
			<p id="userid_for_facebook" style="display: none;"><?php echo $graphObject['id'];?></p>	
			<img src="https://graph.facebook.com/<?= $graphObject['id'] ?>/picture" style="display:none;" id="photo_for_facebook">			
			<div class="content-step" id="step_1" style="height: 650px;">
			<?php } ?>
				<div style="margin-top: 40px !important; margin: 0 auto; text-align:center;width:530px">
				<font style="font-family:Gotham-Light;font-size:35.95px;">ESCOLHA SUA CAUSA</font>
				<font style="font-family:Gotham-Book;font-size:14.78px;margin-top:20px;display:block;clear:both;float:left">Você já começou a mudar o mundo. Só falta escolher uma boa causa!</font>
				</div>
				
				<ul id="lista_causas" style="height: 395px;">
					<li style="margin-left:0px;" value="1">
						<div class="box-foto-causa">
							<img src="images/causas/um_mundo_sem_fome.jpg" alt="" />
							<div class="descricao-foto-causa">
								Embora, em 2010, o direito a alimentação tenha sido incluído na constituição, milhões de brasileiros continuam passando fome. Para fazer esse direito valer, a ActionAid investe em capacitação no meio rural, produção de conhecimento e mobilização pública.
							</div>
						</div>
						<span class="titulo-causa" style="width: 140px; margin-left: 45px;">Um mundo sem fome</span>
						
						<span class="arrow-bottom-right">
							<span class="button-descricao-causa" state="more">+</span>
						</span>
					</li>
					<li value="2">
						<div class="box-foto-causa">
							<img src="images/causas/todas_as_criancas_na_sala_de_aula.jpg" alt="" />
							<div class="descricao-foto-causa">
								Educação pública de qualidade é um direito. A ActionAid apoia a Campanha Nacional pelo Direito à Educação e financia atividades socioeducativas e de inclusão digital em áreas urbanas e rurais do país.
							</div>
						</div>
						<span class="titulo-causa" style="width: 180px; margin-left: 25px;">Todas as crianças na sala de aula</span>

						<span class="arrow-bottom-right">
							<span class="button-descricao-causa" state="more">+</span>
						</span>
					</li>
					<li value="3">
						<div class="box-foto-causa">
							<img src="images/causas/fim_da_violencia_contra_as_mulheres.jpg" alt="" />
							<div class="descricao-foto-causa">
								As mulheres jovens e negras do meio rural são a parcela da população que mais tem seus direitos violados. A ActionAid fortalece a luta pela defesa dos direitos das mulheres e apoia projetos de formação, geração de renda e inclusão digital voltados para elas.
							</div>
						</div>
						<span class="titulo-causa" style="width: 210px; margin-left: 10px;">Fim da violência contra as mulheres</span>

						<span class="arrow-bottom-right">
							<span class="button-descricao-causa" state="more">+</span>
						</span>
					</li>
					<!--<li>
						<div class="box-foto-causa">
							<img src="images/causas/participacao_democratica.jpg" alt="" />
							<div class="descricao-foto-causa">
								Embora, em 2010, o direito a alimentação tenha sido incluído na constituição, milhões de brasileiros continuam passando fome. Para fazer esse direito valer, a ActionAid investe em capacitação no meio rural, produção de conhecimento e mobilização pública.
							</div>
						</div>
						<span class="titulo-causa">Participação Democrática</span>

						<span class="arrow-bottom-right">
							<span class="button-descricao-causa" state="more">+</span>
						</span>
					</li>-->
				</ul>
				<span class="bt-green bt-next" to="2" style="width:149px;font-family:Gotham-Medium;font-size:18px;">
					PRÓXIMO
					<span class="line-button" style="display:block;width:1px;height:50px;background:#4eb138;position:absolute;top:0px;right:55px;"></span>
					<span class="arrow-right-small"></span>
				</span>				
			</div>
			<!-- -->
			
			<!-- PREENCHA OS DADOS -->
			<div class="content-step" id="step_2" style="display:none; height: 1000px ;margin: 0 auto; width: 800px;">
				<div style="display:none; background-color: rgb(238, 238, 238); position: relative; z-index: 999999; opacity: 0.9; width: 803px; margin: 0 auto; height: 1080px;" class="loading">
					<p style="position: absolute; font-family: Gotham-Book; left: 34%; top:30%; font-size: 50px; ">Aguarde...</p>
				</div>			
				<div style="margin: 0 auto; margin-top: 25px; text-align:center;width:530px">
					<font style="font-family:Gotham-Light;font-size:35.95px;">PREENCHA OS DADOS</font>
					<font style="font-family:Gotham-Book;font-size:14.78px;margin-top:25px;display:block;clear:both;float:left">Se você vai mudar o mundo, é justo que receba os créditos por isso.<br />Então, dê o seu nome e a sua cara para a campanha.</font>
				</div>
				<form id="formCadastro" action="" method="POST" enctype="multipart/form-data" name="formCadastro" style="margin-top:50px;clear:both;float:left;margin-left:80px">
					<input type="hidden" name="Causa" />
					<input type="hidden" name="Nome" style="text-transform: uppercase;" value="<?php echo $graphObject['name'];?>" />
					<input type="hidden" name="Email" value="<?php echo $graphObject['email'];?>" />	
					<input type="hidden" name="UserId" value="<?php echo $graphObject['id'];?>" />	
					<input name="ProfilePicture" type="hidden" value="https://graph.facebook.com/<?= $graphObject['id'] ?>/picture" />
					<div class="div-field" style="/* margin-bottom: 5px; */">
						<label style="float: none;">Nome da Campanha</label>
						<div class="break" style="float: none; margin-bottom: 5px;">
							<input type="text" name="NomeCampanha" id="NomeCampanha" class="countdown" value="" style="width:619px" placeholder="Dê um nome para a campanha" maxlength="25">
						</div>	
						<span class="target-countdown" title="25" style="width: 150px; padding-bottom: 25px;">25 caracteres restantes</span>		
					</div>						
					<div class="div-field">
						<div style="width: 250px;display: block;height: 73px;float: left;margin-right: 0;">		
							<label>Período</label>
							<div class="break">
								<!--<input type="text" value="" style="float:left;width: 165px;padding-left: 53px;" class="input_calendar" placeholder="Início" name="DataIni" id="Ini"/>-->
								<input type="text" value="" style="float:left;width: 165px;padding-left: 53px;margin-left: 0px;" class="input_calendar" placeholder="Fim" name="DataFim" id="Fim"/>
								<!--<span style="margin-top:10px;display:block;float:left;margin-left:12px;font-family:Gotham-Light;font-size:11px">A campanha deve ter no<br />máximo 1 mês de duração</span>-->
							</div>
						</div>
						<div style="width: 400px;float: left;">
							<label>Foto</label>
							<div class="break" style="width: 395px;float: left;">
								<input id="uploadFile" name="uploadFile" placeholder="Fazer Upload de outra Foto" disabled="disabled" style="width: 216px; float: left;background-color: #FFF;opacity: 1;"/>
								<div class="fileUpload btn btn-primary" style="display: block; float: left; margin-top: 0px; margin-left: 10px; font-family: Gotham-Medium; font-size: 12px; background: #d3d3d3; color: #898989; padding: 15px; -webkit-border-radius: 4px; border-radius: 4px; cursor: pointer; font-family: Gotham-Medium; font-size: 11px; width: 93px; text-align: center;">
									<span>UPLOAD</span>
									<input type="file" class="upload" name="FotoCampanha"/>
								</div>
								<!--<input type="file" name="Foto" id="Foto" value="Fazer Upload de outra Foto" style="width:286px;float:left;" />
								<input type="file" value="UPLOAD" name="Foto"  />-->
								<div style="float:left;margin-left: 0px;padding-top:14px;width: 169px;">
									<input type="checkbox" name="fotoPerfil" id="fotoPerfil" style="float:left;" />
									<label for="fotoPerfil" class="label-box without-select-text">Usar minha foto de Perfil</label>
								</div>
								<div style="display: none;">
									   <div id="test-content">
										<h1>Test Heading</h1>
										<p>
											This is just a test content that does not make any sense. This is just a test content that does not make any sense. This is just a test content that does not make any sense. This is just a test content that does not make any sense. This is just a test content that does not make any sense.
										</p>
									</div>
								</div>
								<!--<a href="#" id="test-link">Click Me</a>-->				
							</div>	
						</div>
					</div>
					<div class="div-field">
					</div>
					<div class="div-field">
						<label>Meta de Arrecadação</label>
						<div class="break">
							<div style="float:left; width: 82px;">
								<input type="radio" name="valorArrecadado" id="valorArrecadado100" value="100" style="float:left;" />
								<label for="valorArrecadado100" class="label-box without-select-text">R$ 100,00</label>
							</div>
							<div style="float:left;margin-left:20px; width: 85px;">
								<input type="radio" name="valorArrecadado" id="valorArrecadado200" value="200" style="float:left;" />
								<label for="valorArrecadado200" class="label-box without-select-text">R$ 200,00</label>
							</div>
							<div style="float:left;margin-left:20px; width: 85px;">
								<input type="radio" name="valorArrecadado" id="valorArrecadado300" value="300" style="float:left;" />
								<label for="valorArrecadado300" class="label-box without-select-text">R$ 300,00</label>
							</div>
							<div style="float:left;margin-left:20px; width: 93px;">
								<input type="radio" name="valorArrecadado" id="valorArrecadado3000" value="3000" style="float:left;" />
								<label for="valorArrecadado3000" class="label-box without-select-text">R$ 3000,00</label>
							</div>
							<input type="text" name="OutroValor" id="OutroValor" placeholder="Outro Valor" style="width:155px;margin-left:38px;margin-top:-16px;" class="numbersOnly" />
						</div>
					</div>
					<div class="div-field">
						<label>Descrição</label>
						<div class="break">
							<div style="float:left;width: 515px;">
								<textarea name="Descricao" id="Descricao" style="width:486px; height:69px;" class="countdown"placeholder="Escreva aqui uma breve descrição da sua campanha" maxlength="250"></textarea>
								<span class="target-countdown" title="250" style="width: 150px; padding-bottom: 0px; padding-top: 5px; float: left;">250 caracteres restantes</span>								
							</div>
							<div style="float:left">
								<span class="bt-cinza teste_valor" style="margin-top: 0px;">EXEMPLO</span>
								<span class="bt-cinza escreva_sua">ESCREVA A SUA</span>
							</div>						
						</div>
					</div>
					<div class="div-field">
					<!--Divs geradas par ao exemplo-->
						<div style="display: none;">
							<!-- Exemplo aniversário -->
						   <div id="cb_exemplo_aniversario" style="background-image: url(images/exemplos/exemplo-thumb-aniversario.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 28px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 1px solid rgba(255, 255, 255, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 13px; margin-top: 5px;" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>
							<!-- Exemplo páscoa -->
						   <div id="cb_exemplo_pascoa" style="background-image: url(images/exemplos/bg-pascoa-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 28px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 1px solid rgba(255, 255, 255, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 13px; margin-top: 5px;" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>
							<!-- Exemplo natal -->
						   <div id="cb_exemplo_natal" style="background-image: url(images/exemplos/bg-natal-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 28px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 1px solid rgba(255, 255, 255, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 13px; margin-top: 5px;" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>	
							<!-- Exemplo 1 -->
						   <div id="cb_exemplo_1" style="background-image: url(images/exemplos/bg-1-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 28px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 1px solid rgba(255, 255, 255, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 13px; margin-top: 5px;" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>								
							<!-- Exemplo 2 -->
						   <div id="cb_exemplo_2" style="background-image: url(images/exemplos/bg-3-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 28px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 1px solid rgba(255, 255, 255, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 13px; margin-top: 5px;" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>	
							<!-- Exemplo 3 -->
						   <div id="cb_exemplo_3" style="background-image: url(images/exemplos/bg-2-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 28px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 1px solid rgba(255, 255, 255, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 13px" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>								
							
						</div>					
						<label>Estilo</label>
						<div class="break">
							<div>
								<input type="hidden" name="Layout" id="Layout" />
								<div class="estilo" style="margin-left:0px" value="1">								
									<img src="images/estilos_campanha/1.png" alt="" />
									<div class="ver-exemplo">
										<a href="#" id="exemplo_pascoa"><img src="images/zoom-small.png" alt="" /></a><br />
										<span class="lb-ver-exemplo">VER EXEMPLO</span>
									</div>
									<div class="escolher">
										<img src="images/yes-small.png" alt="" /><br />
										<span class="lb-escolher">ESCOLHER</span>
									</div>
								</div>
								<div class="estilo" value="2">
									<img src="images/estilos_campanha/4.png" alt="" />
									<div class="ver-exemplo">
										<a href="#" id="exemplo_aniversario"><img src="images/zoom-small.png" alt="" /></a><br />
										<span class="lb-ver-exemplo">VER EXEMPLO</span>
									</div>
									<div class="escolher">
										<img src="images/yes-small.png" alt="" /><br />
										<span class="lb-escolher">ESCOLHER</span>
									</div>
								</div>
								<div class="estilo" value="3">
									<img src="images/estilos_campanha/5.png" alt="" />
									<div class="ver-exemplo">
										<a href="#" id="exemplo_natal"><img src="images/zoom-small.png" alt="" /></a><br />
										<span class="lb-ver-exemplo">VER EXEMPLO</span>
									</div>
									<div class="escolher">
										<img src="images/yes-small.png" alt="" /><br />
										<span class="lb-escolher">ESCOLHER</span>
									</div>
								</div>									
							</div>
							<div style="margin-top:15px" class="break">
								<div class="estilo" style="margin-left:0px" value="4">
									<img src="images/estilos_campanha/thumb-bg-3.jpg" alt="" />
									<div class="ver-exemplo">
										<a href="#" id="exemplo_2"><img src="images/zoom-small.png" alt="" /></a><br />
										<span class="lb-ver-exemplo">VER EXEMPLO</span>
									</div>
									<div class="escolher">
										<img src="images/yes-small.png" alt="" /><br />
										<span class="lb-escolher">ESCOLHER</span>
									</div>
								</div>
								<div class="estilo" value="5">
									<img src="images/estilos_campanha/thumb-bg-1.jpg" alt="" />
									<div class="ver-exemplo">
										<a href="#" id="exemplo_1"><img src="images/zoom-small.png" alt="" /></a><br />
										<span class="lb-ver-exemplo">VER EXEMPLO</span>
									</div>
									<div class="escolher">
										<img src="images/yes-small.png" alt="" /><br />
										<span class="lb-escolher">ESCOLHER</span>
									</div>
								</div>							
								<div class="estilo" value="6">
									<img src="images/estilos_campanha/thumb-bg-2.jpg" alt="" />
									<div class="ver-exemplo">
										<a href="#" id="exemplo_3"><img src="images/zoom-small.png" alt="" /></a><br />
										<span class="lb-ver-exemplo">VER EXEMPLO</span>
									</div>
									<div class="escolher">
										<img src="images/yes-small.png" alt="" /><br />
										<span class="lb-escolher">ESCOLHER</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" style="border: 0px none; background-color: transparent; margin-left: 215px; width: 221px; cursor: pointer; float: left;">
						<span class="bt-green" id="submit_form" style="width:149px;margin-left:0px;margin-top:41px;font-family:Gotham-Medium;font-size:18px;">
							PRÓXIMO
							<span class="line-button" style="display:block;width:1px;height:50px;background:#4eb138;position:absolute;top:0px;right:55px;"></span>
							<span class="arrow-right-small"></span>
						</span>	
					</button>
					<br />
					
				</form>								
			</div>
			<!-- -->
			
			<!-- SUA CAMPANHA -->
			<div class="content-step" id="step_3" style="display:none; margin: 0 auto; width: 650px;">
				<div style="margin-top:40px;text-align:center;width:638px;text-align:center;">
					<font style="font-family:Gotham-Light;font-size:35.95px;width:638px;text-align:center;">SUA CAMPANHA</font>
					<font style="color:#494949;font-family:Gotham-Book;font-size:12.78px;margin-top:25px;display:block;clear:both;float:left;width:638px;text-align:center;">É assim que vai ficar sua campanha.<br />Se não gostou, aproveite que dá tempo de mudar, é só <b style="cursor:pointer; text-decoration: underline;" class="btn_voltar_2">voltar</b> e refazer.</font>
				</div>
				
				<div id="preview_campanha" style="position: relative; margin-top:50px; background-image: url('images/tela-3-monitor.png'); width: 658px; height: 548px;" class="break">
					<?php 
						$select_usuario = $con->query("SELECT * FROM users WHERE user_id = '".$graphObject['id']."'");
						echo "SELECT * FROM users WHERE user_id = '".$graphObject['id']."'";
						while($usuario = $con->fetch_object($select_usuario)){
							echo "<h1 style='font-family: gabrielaregular; font-size: 35px; text-transform: uppercase;'>".utf8_encode($usuario->campanha)."</h1>";
						}
					?>
					<!--<img src="images/sua_campanha/sua_campanha_preview.png" alt="" />-->
				</div>
				
				<font class="break" style="font-family:Gotham-Book;font-size:19.97px;margin-top:45px;width:638px;text-align:center;color:#494949; margin-bottom: 30px;">Mas se você curtiu o visual, pronto, é só finalizar!</font>
				
				<span class="bt-green bt-next" to="4" style="width:149px;margin-top:50px;font-family:Gotham-Medium;font-size:18px; margin-bottom: 30px;">
					PRÓXIMO
					<span class="line-button" style="display:block;width:1px;height:50px;background:#4eb138;position:absolute;top:0px;right:55px;"></span>
					<span class="arrow-right-small"></span>
				</span>													
			</div>
			<!-- -- >
			
			<!-- SUA CAMPANHA -->
			<div class="content-step" id="step_4" style="display:none;margin: 0 auto; width: 620px;">
				<div style="margin-top:40px;text-align:center;width:620px;text-align:center;">
					<font style="font-family:Gotham-Light;font-size:35.95px;width:638px;text-align:center;" class="break">PARABÉNS</font>
					<img src="images/facelike.png" alt="" class="break" style="margin:50px 0px;margin-left:275px" />
					<font style="margin-bottom:45px;color:#494949;font-family:Gotham-Book;font-size:12.78px;margin-top:25px;display:block;clear:both;float:left;width:638px;text-align:center;">
						Se for seu aniversário, parabéns. Se não for , parabéns também! Com a sua<br />
						campanha você vai trocar presentes por um futuro melhor para quem precisa.<br /><br />
						<b style="font-family:Gotham-Medium;font-size:15.98px;">Agora, é só compartilhar e chamar a galera para participar!</b>
					</font>
					<a href="http://www.doeumfuturodepresente.org.br/campanha/<?php echo $graphObject['id'];?>" target="_blank" style="display: block; border: 0px none; background-color: transparent; cursor: pointer; position: relative;  width: 620px; height: 71px; padding-right: 0; float: left;margin: 0 auto; margin-bottom: 30px;">
						<span style="display:block; cursor:pointer; width: 320px;" to="5" class="bt-green">IR PARA A MINHA LANDING PAGE</span>
					</a>					
					<form action="" enctype="multipart/form-data" method="POST" id="registerForm_campanha" name="registerForm_campanha">
						<input type="hidden" value="<?php echo $graphObject['id'];?>" id="userIDPost" name="userIDPost"/>
						<input type="hidden" value=<?php echo $_SESSION['fb_token'];?> id="tokenPost" name="tokenPost"/>
						<input type="hidden" value="1480329455534696" id="appIDPost" name="appIDPost" />					
						<button type="submit" name="submit_campanha" style="display: block; border: 0px none; background-color: transparent; cursor: pointer; position: relative;  width: 388px; height: 71px; padding-right: 0; margin: 0 auto; margin-bottom: 30px;">
							<span style="display:block; cursor:pointer; width: 320px;" to="5" class="bt-green">COMPARTILHAR NA MINHA TIMELINE</span>
						</button>
					</form>
										
				</div>
			</div>
			
			<?php } else { ?>
			<div id="content" style="width: 100%; margin: 0 auto;">
				<div style="display:none; height: 100%; background-color: rgb(238, 238, 238); position: relative; z-index: 999999; opacity: 0.9; width: 803px;" class="loading">
					<p style="position: absolute; font-family: Gotham-Book; left: 34%; top: 30%; font-size: 50px; ">Aguarde...</p>
				</div>			
				<div class="textoCompartilhamento" style="left: 30%; display: none; z-index: 99999; background-color: rgb(25, 25, 25); position: fixed; height: 100%; margin: 0px auto; width: 800px;">
					<div style="width: 715px; background-color: rgb(255, 255, 255); margin: 150px auto 0px; position: relative; height: 350px;">
						<div style="width: 485px; margin: 0px auto;">
							<h1 style="font-family: Gotham-Light; font-size: 31px; padding: 12px 0px 40px;">Digite aqui o texto que deseja compartilhar na sua timeline.</h1>
							<form id="registerForm" name="registerForm" method="POST" action="" enctype="multipart/form-data" style="margin: 0px auto; width: 440px;">
								<input type="hidden" value="<?php echo $graphObject['id'];?>" id="userIDPost" name="userIDPost"/>
								<input type="hidden" value=<?php echo $_SESSION['fb_token'];?> id="tokenPost" name="tokenPost"/>
								<input type="hidden" value="1480329455534696" id="appIDPost" name="appIDPost" />
								<textarea placeholder="Escreva aqui o texto" style="height: 69px; width: 385px; margin: 0px auto;" id="mensagemPost" name="mensagemPost"></textarea>
								<button style="display: block; border: 0px none; background-color: transparent; cursor: pointer; position: relative; width: 150px; margin: 15px 130px 60px; height: 57px;" type="submit">
									<span class="bt-green" style="font-family: Gotham-Medium; font-size: 22px; display: block; position: absolute; left: 0px; top: 0px; width: 85px; padding: 10px 30px;">ENVIAR</span>
								</button>								
							</form>							
							
						</div>
					</div>
				</div>							
				<div id="header">
					<h1 class="replace lb-header"><img src="images/lb-header.jpg"><strong>ActionAid - Doe um futuro de presente</strong></h1>
				</div>
				<div style="margin-top: 50px; /* margin-left: 75px; */text-align: ce;width: 625px;margin: 0 auto;padding-top: 50px;">
					<p style="font-size: 28px; font-family: Gotham-Light;">OLÁ <span style="text-transform: uppercase;"><?php echo $graphObject['first_name']?></span></p>
					<p style="font-size: 12px; font-family: Gotham-Book; margin-top: 20px; width: 520px;">Aqui você pode acompanhar como sua campanha está indo na rede. Além disso, resolvemos te ajudar e preparamos algumas artes para você postar e dar uma bombada nas doações. Afinal, ninguém muda o mundo sozinho!</p>
				</div>
				<div style="/* margin-left: 40px; */ margin-top: 50px; background-color: #f7f6f6; width: 695px; height: 425px;margin: 50px auto 0;/* padding-top: 50px; */">
					<p style="font-family: Gotham-Book; font-size: 34.5px; color: #777; margin: 0 32px; padding: 30px 100px 20px; border-bottom: 1px solid #e9e8e8;">DADOS DA CAMPANHA</p>
					<div style="padding: 90px 45px 55px 105px; width: 280px; float: left;">
						<div class="apoiadores">
							<img class="obj-info-campanha" src="campanha/images/obj-apoiadores.png" alt="" style="float: left; margin-right: 16px;">
							<div class="info-campanha" style="float: left; line-height: 46px; position: relative; text-align: left;">
								<span class="numeros-campanha numero-apoiadores" style="color: #C40A24; display: block; font-family: Gotham-Medium; font-size: 60px;">
								<?php 
									$select_usuario = $con->query("SELECT * FROM users WHERE user_id = '".$graphObject['id']."'");
									$usuario = $con->fetch_object($select_usuario);	
									$select_apoiadores = $con->query("SELECT * FROM users_payement WHERE user_id = '".$graphObject['id']."' AND id_transacao IS NOT NULL AND status='Pago' ");
									$apoiadores = $con->num_rows($select_apoiadores);
									echo $apoiadores;
								?>
								</span>
								<span class="label-campanha lb-apoiadores" style="color: #828282; display: block; font-family: Gotham-Book; font-size: 14px;">Apoiadores</span>
							</div>
						</div>
						<div class="valor" style="display: none;">
							<img class="obj-info-campanha" src="campanha/images/obj-atingidos.png" alt="" style="float: left; margin-right: 16px;">
							<div class="info-campanha" style="float: left; line-height: 46px; position: relative; text-align: left; width: 185px;">
								<div style="float:left; width: 185px;">
									<span class="rscifrao-info-campanha" style="color: #C40A24; display: block; float: left; font-family: Gotham-Medium; font-size: 18px; line-height: 18px; margin-right: 6px;">R$</span>
									<span class="numeros-campanha numero-atingidos" style="color: #C40A24; display: block; font-family: Gotham-Medium; font-size: 60px;">
										<?php 
											$valor_arrecadado = $con->query("SELECT SUM(valor_doacao) AS total FROM users_payement WHERE user_id = '".$graphObject['id']."' AND id_transacao IS NOT NULL AND status='Pago' ");
											$doacao = $con->fetch_object($valor_arrecadado);
											if ($doacao->total) {
												echo $doacao->total;
											} else {
												echo '0';			
											}
										?>								
									</span>
								</div>
								<span class="label-campanha lb-atingidos" style="color: #828282; display: block; font-family: Gotham-Book; font-size: 14px;">Atingidos de <?php echo 'R$ ' . number_format($usuario->valor_arrecadado, 2, ',', '.');?></span>
							</div>
						</div>	
						<div class="tempo" style="display: none;">
							<img class="obj-info-campanha" src="campanha/images/obj-dias_restantes.png" alt="" style="float: left; margin-right: 16px;">
							<div class="info-campanha" style="float: left; line-height: 46px; position: relative; text-align: left;">
								<span class="numeros-campanha numero-apoiadores" style="color: #C40A24; display: block; font-family: Gotham-Medium; font-size: 60px;">
								<?php 								
									$data_hoje = date('d/m/Y',strtotime(date('Y-m-d'))); 
									//$data_inicial = $usuario->data_inicio;
									$data_final = $usuario->data_fim;
									
									$time_hoje = geraTimestamp($data_hoje);
									//$time_inicial = geraTimestamp($data_inicial);
									$time_final = geraTimestamp($data_final);
									//if ($time_inicial > $time_hoje) {
									//	$diferenca = $time_final - $time_inicial; 
									//} else {
										$diferenca = $time_final - $time_hoje;
									//}
									// Calcula a diferença de dias
									$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias	
									echo $dias; 
								?>
								</span>
								<span class="label-campanha lb-apoiadores" style="color: #828282; display: block; font-family: Gotham-Book; font-size: 14px;">Dias restantes</span>
							</div>
						</div>						
					</div>
					<div style="float: left;">
						<div style="background-image: url(campanha/images/submenu_admin.png); width: 240px; height: 165px; margin-top: 50px;">
							<ul style="padding-left: 25px; padding-top: 20px;" class="submenu_admin">
								<li style="margin-bottom: 20px;"><span style="cursor: pointer;" class="btn_apoiadores"><img src="images/apoiadores_menu_off.png" /></span></li>
								<li style="margin-bottom: 20px;"><span style="cursor: pointer;" class="btn_valor"><img src="images/valor_menu_off.png" /></span></li>
								<li><span style="cursor: pointer;" class="btn_tempo"><img src="images/tempo_menu_off.png" /></span></li>
							</ul>
						</div>
					</div>
					<div style="float: left; margin-left: 100px;">
						<span id="sharePost" style="font-family: Gotham-Medium; font-size: 22px; display: block; position: relative; margin: 0px; width: 430px; height: 25px; margin-bottom: 60px;" class="bt-green">COMPARTILHAR NA MINHA TIMELINE</span>
					</div>
					<?php $select_doadores = $con->query("SELECT * FROM doadores_img WHERE user_id = '".$graphObject['id']."'");
	
						$num_doadores = $con->num_rows($select_doadores);
						if ($num_doadores > 0) {
						?>
						<div style="width: 695px; float: left; margin-bottom: 60px;">
							<div style="float: left; width: 695px;">
								<p style="font-family: Gotham-Book; font-size: 34.5px; color: #777; margin: 0 32px; /* padding: 30px 100px 20px; */ border-bottom: 1px solid #e9e8e8;text-align: center;">DOADORES DA CAMPANHA</p>
							</div>
							<div style="float: left; width: 542px; margin-left: 85px; margin-top: 15px;">
							<?php while($doadores	= $con->fetch_object($select_doadores)){ ?>
								<div class="teste_doadores" style = 'background-image: url(https://graph.facebook.com/<?php echo $doadores->user_id_doador?>/picture?width=120&height=120); background-position: 50% 50%; background-repeat: no-repeat; border-radius: 50%; width: 65px; height: 65px; float: left; margin-left: 15px; margin-bottom: 15px;'>
									<div class="arrow_box">
										<h1 class="logo"><?php $nome = explode(' ', $doadores->nome_doador);
											echo $nome[0];
										?></h1>
									</div>
								</div>
								<!--<img style="-webkit-clip-path: circle(50%, 50%, 50%); clip-path: circle(50%, 50%, 50%);" src="https://graph.facebook.com/<?php echo $doadores->user_id_doador?>/picture?width=120&height=120" />-->
							<?php } ?>
							</div>
						</div>
					<?php }?>					
				</div>
			</div>
			<?php } ?>
			
			<!-- -->

		</div>

		<div id="footer">
			<p style="width: 160px; margin: 0 auto;"><a href="http://www.3aworldwide.com.br" target="blank"><img src="/images/assinatura.png"></a></p>
		</div>
		
	</div>
</body>
</html>
