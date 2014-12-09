<?php 
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    //error_reporting(E_ALL);
    ini_set('display_errors', 0);
	session_start(); 
	require_once ("PagSeguroLibrary/PagSeguroLibrary.php");
	//use PagSeguroLibrary/PagSeguroLibrary.php;
	$user_id = $_GET['id'];
	
	date_default_timezone_set("America/Sao_Paulo");		
	include_once "../config/connection.class.php";

	require_once( '../Facebook/FacebookHttpable.php' );
	require_once( '../Facebook/FacebookCurl.php' );
	require_once( '../Facebook/FacebookCurlHttpClient.php' );
	 
	// added in v4.0.0
	require_once( '../Facebook/FacebookSession.php' );
	require_once( '../Facebook/FacebookRedirectLoginHelper.php' );
	require_once( '../Facebook/FacebookRequest.php' );
	require_once( '../Facebook/FacebookResponse.php' );
	require_once( '../Facebook/FacebookSDKException.php' );
	require_once( '../Facebook/FacebookRequestException.php' );	
	require_once( '../Facebook/FacebookServerException.php' );
	require_once( '../Facebook/FacebookOtherException.php' );
	require_once( '../Facebook/FacebookAuthorizationException.php' );
	require_once( '../Facebook/GraphObject.php' );
	require_once( '../Facebook/GraphSessionInfo.php' );
	require_once( '../Facebook/facebook.php' );
	 
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
	// init app with app id and secret
	FacebookSession::setDefaultApplication( '157072264463451','0b4dce1ab02180b3792f6dc240426710' );
	 
	// login helper with redirect_uri
	$helper = new FacebookRedirectLoginHelper( 'https://www.doeumfuturodepresente.org.br/campanha/'.$user_id); 
	$my_url = "https://www.doeumfuturodepresente.org.br/campanha/".$user_id;
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
	  
	  //echo "INSERT INTO doadores_img (user_id, user_id_doador) VALUES ('".$user_id."', '".$graphObject['id']."'";
	  
	  // print profile data
	  //echo '<pre>'.print_r( $graphObject, 1).'</pre>';
	  
	  // print logout url using session and redirect_uri (logout.php page should destroy the session)
	  //echo '<a href="' . $helper->getLogoutUrl( $session, 'http://yourwebsite.com/app/logout.php' ) . '">Logout</a>';
	  
	} else {
	  // show login url
	  //echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends', 'user_about_me' ) ) . '">Login</a>';
		  //echo $_SESSION['fb_token'];
	}
	
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $parts = parse_url($actual_link);
    parse_str($parts['query'], $query);
    $code = $query['code'];
	if (isset($code)) {
		$token_url = "https://graph.facebook.com/oauth/access_token?"
		   . "client_id=157072264463451&redirect_uri=" . $my_url
		   . "&client_secret=0b4dce1ab02180b3792f6dc240426710&code=" . $code;
		 $response = @file_get_contents($token_url);
		 $params = null;
		 parse_str($response, $params);

		 $graph_url = "https://graph.facebook.com/me?access_token=" 
		   . $params['access_token'];

		 $user = json_decode(file_get_contents($graph_url));
		 if (isset($user->id)) {
			$insert = $con->query("INSERT INTO doadores_img (user_id, user_id_doador, nome_doador) VALUES ('".$user_id."', '".$user->id."', '".$user->name."')");
		}		 
	}
	
	function ConsultaConfig($campo){
		global $con;

		$confSQL = $con->query("SELECT $campo FROM config");
		$conf = $con->fetch_object($confSQL);
		return $conf->$campo;
	}

	function existeDoacao($token)
	{
		global $con;

		
	}
	
	//echo "INSERT INTO doadores_img (user_id, user_id_doador) VALUES ('".$user_id."', '".$graphObject['id']."'";
	$select_usuario = $con->query("SELECT * FROM users WHERE user_id = '".$user_id."'");
	while($usuario	= $con->fetch_object($select_usuario)){
	
?><!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE10" >	
    <meta http-equiv="imagetoolbar" content="no">
	<meta property="og:title" content="Doe um futuro de presente"/>
	<meta property="og:type" content="website"/>
	<meta property="og:url" content="http://www.doeumfuturodepresente.org.br/campanha/<?php echo $user_id;?>"/>
	<meta property="og:image" content="http://www.renoi.de/images/lg.jpg"/>
	<meta property="og:site_name" content="My Site Name"/>
	<meta property="og:email" content="hello@mywebaddress.com"/>
	<meta property="og:description" content="Esse deve ter sido o melhor presente que eu já dei na vida, afinal não é todo dia que dou um futuro para alguém. Venha você também ajudar nessa causa!"/>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no">
  	<title>Act!onAid</title>	
	
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	
	<link rel="stylesheet" type="text/css" href="stylesheets/base.css" />
	<link rel="stylesheet" type="text/css" href="stylesheets/sexyalertbox.css" />
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>	
	<script type="text/javascript" language="Javascript" src="javascripts/ui.datepicker-pt-BR.js"></script>		
	<link rel="stylesheet" href="stylesheets/ezmark.css" media="all">	
	<script type="text/javascript" language="Javascript" src="javascripts/jquery.ezmark.min.js"></script>
	<script type="text/javascript" language="Javascript" src="../javascripts/jquery.maskMoney.js"></script>
	<!--<script type="text/javascript" language="Javascript" src="javascripts/jquery.maskedinput-1.1.4.pack.js"/></script>-->
	<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
	<!--script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>-->
	<script type="text/javascript" language="Javascript" src="javascripts/jquery.easing.1.3.js"></script>		
	<script type="text/javascript" language="Javascript" src="javascripts/sexyalertbox.v1.2.jquery.js"></script>
	<script type="text/javascript" language="Javascript" src="javascripts/jquery.DOMWindow.js"></script>		
	<script type="text/javascript" language="Javascript" src="../javascripts/jquery.mask.js"></script>
	<script type="text/javascript" src="http://cidades-estados-js.googlecode.com/files/cidades-estados-1.2-utf8.js"></script>	
	<script type="text/javascript" language="javascript">
		
		function countWords(s){
			s = s.replace(/(^\s*)|(\s*$)/gi,"");
			s = s.replace(/[ ]{2,}/gi," ");
			s = s.replace(/\n /,"\n");
			return s.split(' ').length;
		}


		function mascaraGeral(o,f) {  
			v_obj_geral=o; 
			v_fun_geral=f;
			setTimeout("execmascaraGeral()",1);
		}

		function execmascaraGeral(){  
			v_obj_geral.value=v_fun_geral(v_obj_geral.value);
		}

		function mtel(v){  
		   if(/(\(11\)9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])).+/i.test(v)){}

			v=v.replace(/\D/g,""); 
			v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos  
			v=v.replace(/^(\d)(\d{5})/g,"$1-$2");
			v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos  
			return v;  
		}		
		$(document).ready(function (){
			new dgCidadesEstados({
		    estado: $('#estado').get(0),
		    cidade: $('#cidade').get(0)
		   	});
			
	    $('.teste_animate').hover(function(){
			$(this).animate({
				color: '#ffffff'
			}, 1500);
		});	
	
			//$('input[name="CEPDoador"]').mask("99.999-999");
			
			$('input').ezMark();	

			$("#OutroValor").maskMoney({showSymbol:true, symbol:"R$ ", decimal:".", thousands:""});			
						
			$('#bt_doar_agora').click(function() {
				$('body, html').animate({scrollTop:900},600);
			});			
			
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
			
			$("#OutroValor").click(function(){
				$(".ez-radio").removeClass('ez-selected');
				$('input[name="valorDoacao"]').attr('checked', false);				
			});			
			
			$('input[name="valorDoacao"]').click(function(){
				$("#OutroValor").val('');			
			});	

			//$( "#DataAniversario" ).datepicker();
			$( "#DataAniversario" ).mask('00/00/0000');

			$('input[name="CEPDoador"]').keydown(function(event) {
				//teclas permitidas na ordem de código abaixo (tab,delete,backspace,setas direita e esquerda)
				TeclasPermitidas = new Array(8,9,37,39,46);
				//Adicionando os numeros de 0 a 9 do teclado alfanumerico
				for(x=48;x<=57;x++){
				TeclasPermitidas.push(x);
				}
				//adicionando os numeros de 0 a 9 do teclado numerico
				for(x=96;x<=105;x++){
				TeclasPermitidas.push(x);
				}
				//Pega a tecla digitada dentro do input
				var CodigoTecla = (window.event) ? event.keyCode : event.which;
				//Verifica se a tecla digitada é permitida
				if ($.inArray(CodigoTecla,TeclasPermitidas) != -1){
				return true;
				}
				return false;
			}); 

			function getDoc(frame) {
				 var doc = null;
				 
				 // IE8 cascading access check
				 try {
					 if (frame.contentWindow) {
						 doc = frame.contentWindow.document;
					 }
				 } catch(err) {
				 }

				 if (doc) { // successful getting content
					 return doc;
				 }

				 try { // simply checking may throw in ie8 under ssl or mismatched protocol
					 doc = frame.contentDocument ? frame.contentDocument : frame.document;
				 } catch(err) {
					 // last attempt
					 doc = frame.document;
				 }
				 return doc;
			 }
			var ButtonValue;
			$('button[type=submit]').click(function (e) {
				ButtonValue = $(this).attr('id');
			});

			$("#formDoacao").submit(function(e)
			{
					
				//var botao = $(this).attr('id');
				//return false;
				if ((document.formDoacao.OutroValor.value == "") || (document.formDoacao.OutroValor.value == "R$ 0.00")) {
			    	if (!$('input[name="valorDoacao"]').is(':checked')) {
						Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha com o valor da doação.</p>');
						$('body, html').animate({scrollTop:200},600);	
						return false;			    		
			    	}
			    }

				if ($('input[name="valorDoacao"]').is(':checked')) {
					valor = $('input[name="valorDoacao"]').val();
				} else {
					valor = $('input[name="OutroValor"]').val();
					valor = valor.replace('R$ ','');
				}


			    if (document.formDoacao.NomeDoador.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu nome.</p>');
					$('input[name="NomeDoador"]').focus();
					return false;
			    } else {
			    	if(countWords(document.formDoacao.NomeDoador.value) <= 1)
			    	{
				    	Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu sobrenome.</p>');
						$('input[name="NomeDoador"]').focus();
						return false;
			    	}
			    }	

			   if (document.formDoacao.EmailDoador.value == "") {
				 Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu email.</p>');
				 return false;
			   }
			   else {
					 if (document.formDoacao.EmailDoador.value.indexOf('@') <= -1) {
					   Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Email inválido.</p>');
					   return false;
					 }
			  	}
			  	if(document.formDoacao.DataAniversario.value.length <= 9){
			  		Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Data inválida.</p>');
					 return false;
			  	}	    

			    if (document.formDoacao.CEPDoador.value.length != 8) {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu CEP.</p>');
					$('input[name="CEPDoador"]').focus();
					return false;
			    }

			    if (document.formDoacao.EnderecoDoador.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu endereço.<p>');
					$('input[name="EnderecoDoador"]').focus();
					return false;
			    }			    

			    if (document.formDoacao.EnderecoDoador.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu endereço.</p>');
					$('input[name="EnderecoDoador"]').focus();
					return false;
			    }	

			    if (document.formDoacao.NumeroDoador.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o campo número.</p>');
					$('input[name="NumeroDoador"]').focus();
					return false;
			    }

			    if (document.formDoacao.BairroDoador.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu bairro.</p>');
					$('input[name="BairroDoador"]').focus();
					return false;
			    }

			    if (document.formDoacao.CidadeDoador.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha a sua cidade.</p>');
					$('input[name="CidadeDoador"]').focus();
					return false;
			    }	

			    if (document.formDoacao.EstadoDoador.value == "") {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu estado.</p>');
					$('input[name="EstadoDoador"]').focus();
					return false;
			    }

			    if (document.formDoacao.TelefoneDoador.value == "") {
			    	if (document.formDoacao.CelularDoador.value == "") { 
						Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu telefone.</p>');
						$('input[name="TelefoneDoador"]').focus();
						return false;
					}
			    }	

			    if (!$('input[name="AceitoPolitica"]').is(':checked')) {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Aceite os termos de Política de Privacidade primeiro antes de enviar o formulário.</p>');
					return false;
			    }						
				var formObj = $(this);
				//var formURL = formObj.attr("action");

				if(window.FormData !== undefined)  // for HTML5 browsers
				{
					//Obter os dados do formulário
					var formData = new FormData(this);

					//Testar se é PagSeguro ou Paypal
				    if(ButtonValue == 'btn_pagseguro') {
						$.ajax({
							url: "checkout.php",				
							type: "POST",	
							data: formData,
							mimeType:"multipart/form-data",					
							contentType: false,						
							cache: false,				
							processData: false,			
							success: function (resposta) {
								if (resposta) {
									/*$("#preview_campanha").html('');
									$("#preview_campanha").append(resposta);
									$('.step-bar-vermelho_3').animate({
										'width' : '+=136px'
									}, 1000, function() {
										$('.step-bar_3').addClass('step-bar-ativo');
										$('#step_3').fadeIn();
										$('#step_2').fadeOut();
										$('.loading').fadeOut();									
									});	*/
									console.log(resposta);
									PagSeguroLightbox({
										code: resposta
										}, {
											success : function(transactionCode) {
												$.ajax({
													type: "POST",
													url: "retorno.php",
													data: {
														code: transactionCode,
													},
													dataType: "html",				
													success: function () {
														$('.loading').fadeIn();
													}
												});
													
											},
											abort : function() {
												Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Erro ao efetuar a doação.</p>');
											}
										});							
									return false;
								} else {
								
								}
							}
						});
					} else {
						$.ajax({
							url: "checkout_paypal.php",				
							type: "POST",	
							data: formData,
							mimeType:"multipart/form-data",					
							contentType: false,						
							cache: false,				
							processData: false,			
							success: function (resposta) {
								if (resposta) {
									/*$("#preview_campanha").html('');
									$("#preview_campanha").append(resposta);
									$('.step-bar-vermelho_3').animate({
										'width' : '+=136px'
									}, 1000, function() {
										$('.step-bar_3').addClass('step-bar-ativo');
										$('#step_3').fadeIn();
										$('#step_2').fadeOut();
										$('.loading').fadeOut();									
									});	*/

									console.log("Resposta:");
									console.log(resposta);

									$.openDOMWindow({
										borderSize:0,
										borderColor:'transparent',
										height:544, 
										width:827, 
										positionType:'absolute', 
										positionTop:100, 
										positionLeft:($(window).width()/2 - 408),  
										loader:1, 
										loaderImagePath:'/landing/den/images/sw-denver/loading.gif', 
										loaderHeight:16, 
										loaderWidth:17,
										windowPadding:0,
										windowSource:'iframe', 
										windowHTTPType:'get',
										windowSourceURL: resposta			
									});

								} else {
								
								}
							}
						});	

					}
				e.preventDefault();				
			   }
			   else  //for olden browsers
				{
					//generate a random id
					var  iframeId = "unique" + (new Date().getTime());

					//create an empty iframe
					var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');

					//hide it
					iframe.hide();

					//set form target to iframe
					formObj.attr("target",iframeId);

					//Add iframe to body
					iframe.appendTo("body");
					iframe.load(function(e)
					{
						var doc = getDoc(iframe[0]);
						var docRoot = doc.body ? doc.body : doc.documentElement;
						var data = docRoot.innerHTML;
						//data return from server.
						
					});
				
				}

			});
			//$("#formDoacao").submit();			
		});	
	</script>	
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=157072264463451&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
	<img src="images/Web-Banner.jpg" style="display: none;"/>
	<div id="container_header">
			<div id="header">	
				<h1><a href="index.php" class="replace lb-actionaid"><strong>ActionAid</strong></a></h1>
				<h2 class="replace lb-doeumfuturodepresente"><strong>ActionAid</strong></h1>
			</div>
	</div>
	<div id="container">
		<div class="loading" style="display: none; z-index: 99999; background-color: rgba(25, 25, 25, 0.7); position: absolute; height: 100%; width: 100%; top: 0; left: 0;">
				<div style="width: 715px; height: 575px; background-color: rgb(255, 255, 255); margin: 40px auto 0px; position: relative;">
					<div style="margin: 0px auto; width: 100%;">
						<h1 style="font-family: Gotham-Light; font-size: 45px; margin: 0px auto; text-align: center;">VALEU!</h1>
						<p style="font-family: Gotham-Book; font-size: 13px; text-align: center;">Esse deve ter sido o melhor presente que você já deu na vida.</p>
						<p style="font-family: Gotham-Book; font-size: 13px; padding: 0px 0px 15px; text-align: center;">Afinal, não é todo dia que alguém ganha um futuro.</p>
						<p style="font-family: Gotham-Medium; font-size: 15px; color: rgb(73, 73, 73); padding: 0px 0px 35px; text-align: center;">Obrigado por me ajudar nessa causa!</p>
													<!--<a style="display: block; border: 0px none; background-color: transparent; cursor: pointer; position: relative; margin: 0px; width: 490px; height: 71px; margin-bottom: 15px;" href="https://www.facebook.com/v2.0/dialog/oauth?client_id=157072264463451&redirect_uri=https%3A%2F%2Fwww.doeumfuturodepresente.org.br%2Fcampanha%2F764079350289209&state=26fb9bb33e82ffe5ed919aef13d54a2f&sdk=php-sdk-4.0.6&scope=email%2Cpublic_profile"> <span class="bt-green without-select-text" style="margin-left:100px;margin-top:41px;font-family:Gotham-Medium;font-size:20px; margin-left: 240px;">Login</span></a>-->						
						<?php echo '<a style="display: block; border: 0px none; background-color: transparent; cursor: pointer; position: relative; width: 490px; height: 71px; margin: 0px auto 60px" href="' . $helper->getLoginUrl( array( 'email', 'public_profile' ) ) . '">'; ?>
							<span style="font-family: Gotham-Medium; font-size: 22px; display: block; position: absolute; left: 0px; top: 0px; width: 430px; padding: 20px 30px;" class="bt-green">USAR MINHA FOTO COMO DOADOR</span>
						</a>
						<h1 style="font-family: Gotham-Light; font-size: 30px; text-align: center; margin-bottom: 15px;">OU</h1>						
						<a onClick="window.open('https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.doeumfuturodepresente.org.br%2Fcampanha%2F<?php echo $user_id;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)" style="display: block; border: 0px none; background-color: transparent; cursor: pointer; position: relative; width: 490px; height: 71px; margin: 0 auto 60px;">
							<span style="font-family: Gotham-Medium; font-size: 22px; display: block; position: absolute; left: 0px; top: 0px; width: 430px; padding: 20px 30px;" class="bt-green">COMPARTILHAR NA MINHA TIMELINE</span>
						</a>						
						<div style="background-color: rgb(223, 10, 36); border-top: 5px solid rgb(178, 4, 25); height: 146px; color: white; margin-top: 15px;">
							<p style="font-family: Gotham-Book; font-size: 13px; text-align: center; margin-top: 15px;">Aproveite, crie uma campanha você também.</p>
							<p style="font-family: Gotham-Book; font-size: 13px; text-align: center; padding: 0px 0px 35px;">Ajuda para mudar o mundo nunca é demais.</p>

							<a style="display: block; padding: 0px; width: 230px; margin: 0px auto;" href="/">
								<img src="images/btn_criar_minha_campanha.png">
							</a>
						</div>
					</div>
				</div>
			</div>	
		<div id="content">				
			<div id="intro" style="background-image: url(images/backgrounds/<?php echo $usuario->layout;?>.png); position: relative;">
				<!--<div class="box-foto_causa">
					<div class="container-foto_causa">
					</div>
					<span class="lb-causa">CAUSA</span>
					<span class="lb-titulo_causa"><?php echo $usuario->layout;?></span>
				</div>-->
				<img src="../images/causas/causa<?php echo $usuario->causa; ?>.png" style="position: absolute; top: 230px; left: 123px; z-index: 9998;"/>
				<div style="background-image: url(images/foto-perfil.png); position: absolute; width: 242px; height: 290px; left: 325px; top: 140px;">
				<?php 
					$pos = stripos($usuario->foto_campanha, "https://");
				if ($pos !== false) { ?>
					<img src="<?php echo $usuario->foto_campanha;?>?type=large" style="position: absolute; width: 197px; top: 20px; left: 23px; -webkit-transform: rotate(3deg); -moz-transform: rotate(3deg); -o-transform:rotate(3deg); -ms-transform:rotate(3deg); filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1.5); height: 202px;" />
				<?php } else { ?>
					<img src="../uploads/<?php echo $usuario->foto_campanha;?>" style="position: absolute; width: 197px; top: 20px; left: 23px; -webkit-transform: rotate(3deg); -moz-transform: rotate(3deg); -o-transform:rotate(3deg); -ms-transform:rotate(3deg); filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1.5); height: 202px;" />			
				<?php } ?>
				</div>				
				<!--<div class="box-foto_autor">
					<div class="container-foto_autor">
					</div>
				</div>-->
				<div class="texto" style="margin-left: 655px; width: 475px; padding-top: 145px;">
					<h1 style="font-family: Gabriela-Regular; font-size: 50px; text-transform: uppercase;"><?php echo utf8_encode($usuario->campanha); ?></h1>
					<p style="font-family: Gotham-Bold; border-top: 1px solid rgba(255, 255, 255, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 7px; font-size: 16px;" class="usuario">por <?php echo utf8_encode(strtoupper($usuario->nome));?></p>
					<p style="font-family: Gabriela-Regular; font-size: 22px; margin-top: 5px;" class="descricao"><?php echo utf8_encode($usuario->descricao);?></p>
				</div>			
				<span id="bt_doar_agora" target="form_doacao" class="bt-green">DOAR AGORA</span>			
			</div>
			<div id="andamento_da_campanha" class="break">
				<span class="mask-andamento_da_campanha">
					<h2 class="lb-andamento_da_campanha">ANDAMENTO DA CAMPANHA</h2>
				</span>
				<ul id="lista_itens_campanha">
					<li style="margin-left:212px">
						<img class="obj-info-campanha" src="images/obj-apoiadores.png" alt="">
						<div class="info-campanha">
							<span class="numeros-campanha numero-apoiadores">
							<?php 
								$select_apoiadores = $con->query("SELECT * FROM users_payement WHERE user_id = '".$user_id."' AND id_transacao IS NOT NULL AND status='Pago' ");
								$apoiadores = $con->num_rows($select_apoiadores);
								echo $apoiadores;
							?>
							</span>
							<span class="label-campanha lb-apoiadores">Apoiadores</span>
						</div>
					</li>
					<li>
						<img class="obj-info-campanha" src="images/obj-atingidos.png" alt="">
						<div class="info-campanha">
							<div style="float:left">
								<span class="rscifrao-info-campanha">R$</span>
								<span class="numeros-campanha numero-atingidos" style="width: 150px;">
									<?php 
										$valor_arrecadado = $con->query("SELECT SUM(valor_doacao) AS total FROM users_payement WHERE user_id = '".$user_id."' AND id_transacao IS NOT NULL AND status='Pago'");
										$doacao = $con->fetch_object($valor_arrecadado);
										if ($doacao->total) {
											echo $doacao->total;
										} else {
											echo '0';			
										}
									?>								
								</span>
							</div>
							<span class="label-campanha lb-atingidos">Atingidos de <?php echo 'R$ ' . number_format($usuario->valor_arrecadado, 2, ',', '.');?></span>
						</div>
					</li>
					<li>
						<img class="obj-info-campanha" src="images/obj-dias_restantes.png" alt="">
						<div class="info-campanha">
							<span class="numeros-campanha numero-dias_restantes">
							<?php 								
								$data_hoje = date('d/m/Y',strtotime(date('Y-m-d'))); 
								$data_inicial = $usuario->data_inicio;
								$data_final = $usuario->data_fim;
								
								function geraTimestamp($data) {
								$partes = explode('/', $data);
								return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
								}
								
								$time_hoje = geraTimestamp($data_hoje);
								$time_inicial = geraTimestamp($data_inicial);
								$time_final = geraTimestamp($data_final);
								if ($time_inicial > $time_hoje) {
									$diferenca = $time_final - $time_inicial; 
								} else {
									$diferenca = $time_final - $time_hoje;
								}
								// Calcula a diferença de dias
								$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
								if ($dias < 0)
								{
									$dias = 0;
								} 
								echo $dias;
							?>
							</span>
							<span class="label-campanha lb-dias_restantes">Dias restantes</span>
						</div>
					</li>
				</ul>
			</div>
			<?php $select_doadores = $con->query("SELECT * FROM doadores_img WHERE user_id = '".$user_id."'");
				$num_doadores = $con->num_rows($select_doadores);
				if ($num_doadores > 0) {
				?>
				<div style="width: 1200px; float: left; margin-bottom: 60px;">
					<div style="float: left; width: 1200px;">
						<span class="line-titulo" style="margin-top:14px;width:320px;height:1px;background:#e1e4e9;float:left; margin-left: 70px;"></span>
							<label style="float:left;font-family:Gotham-Medium;font-size:24px;margin:0px 12px;">QUEM JÁ FEZ SUA DOAÇÃO</label>
						<span class="line-titulo" style="margin-top:14px;width:320px;height:1px;background:#e1e4e9;float:left;"></span>
					</div>
					<div style="float: left; width: 950px; margin-left: 120px; margin-top: 15px;">
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
			<pre></pre>
			<form id="formDoacao" style="float:left;clear:both;margin:0px 0px 0px 130px;" action="" method="POST" enctype="multipart/form-data" name="formDoacao">
				<input type="hidden" name="UserId" value="<?php echo $user_id;?>" />
				<div id="step-valor-da-doacao" style="display:block;margin-bottom:48px;height:132px;width:880px;padding:20px 0px;text-align:center;border-radius:4px;-webkit-border-radius:4px;border:1px solid #e2e2e2;">
					<label class="break" style="font-size:24px;font-family:Gotham-Medium;width:882px;">VALOR DA DOAÇÃO</label>
					<div class="break" style="margin-top:48px;text-align:center;width:882px;display:block">
						<div style="float:left;margin-left:80px;width:90px;">
							<input type="radio" name="valorDoacao" class="OpcaoValorDoacao" style="float:left;" value="15.00" />
							<label for="valorDoacao" class="label-box without-select-text">R$ 15,00</label>
						</div>
						<div style="float:left;margin-left:16px;width:90px;">
							<input type="radio" name="valorDoacao" class="OpcaoValorDoacao" style="float:left;" value="30.00" />
							<label for="valorDoacao" class="label-box without-select-text">R$ 30,00</label>
						</div>
						<div style="float:left;margin-left:16px;width:90px;">
							<input type="radio" name="valorDoacao" class="OpcaoValorDoacao" style="float:left;" value="45.00" />
							<label for="valorDoacao" class="label-box without-select-text">R$ 45,00</label>
						</div>
						<div style="float:left;margin-left:16px;width:90px;">
							<input type="radio" name="valorDoacao" class="OpcaoValorDoacao" style="float:left;" value="60.00" />
							<label for="valorDoacao" class="label-box without-select-text">R$ 60,00</label>
						</div>
						<div style="float:left;margin-left:16px;width:100px;">
							<input type="radio" name="valorDoacao" class="OpcaoValorDoacao" style="float:left;" value="100.00"/>
							<label for="ValorDoacao" class="label-box without-select-text">R$ 100,00</label>
						</div>
						<input type="text" name="OutroValor" id="OutroValor" value="" placeholder="Outro Valor" style="width:196px;margin:-16px 0px 0px 32px;float:left" />
					</div>
				</div>
				<div id="step-dados_pessoais">
					<div id="titulo-dados_pessoais">
						<span class="line-titulo" style="margin-top:14px;width:320px;height:1px;background:#e1e4e9;float:left;"></span>
							<label style="float:left;font-family:Gotham-Medium;font-size:24px;margin:0px 12px;">DADOS PESSOAIS</label>
						<span class="line-titulo" style="margin-top:14px;width:320px;height:1px;background:#e1e4e9;float:left;"></span>
						
						<div style="margin-top:6px;/*margin-bottom:85px;*/clear:both;float:left;margin-left:112px;" id="section_dados_pessoais">
							<div class="break label-break">
								<label>Nome</label>
								<input type="text" name="NomeDoador" value="" placeholder="Nome e Sobrenome" style="width:525px;" />
							</div>
							<div class="break label-break">
								<label>E-mail</label>
								<input type="text" name="EmailDoador" value="" placeholder="seu@email.com" style="width:525px;" />
							</div>
							<div class="break label-break">
								<label>Data de aniversário</label>
								<input type="text" value="" style="float: left;" class="input_calendar" placeholder="Aniversário" name="DataAniversario" id="DataAniversario" />
								<span style="float:left;margin-left:35px;margin-top:16px;">Formato: DD/MM/YYYY</span>
							</div>							
							<div class="break label-break">
								<label>CEP</label>
								<input type="text" name="CEPDoador" value="" placeholder="somente números" style="width:155px;float:left;" />
								<span style="float:left;margin-left:35px;margin-top:16px;">Não sabe seu CEP? Consulte <a href="http://www.buscacep.correios.com.br/" target="_blank">aqui</a> (site dos correios)</span>
							</div>
							<div class="break label-break">
								<div style="float:left">
									<label>Endereço</label>
									<input type="text" name="EnderecoDoador" value="" placeholder="Rua, Avenida, Praça, outros" style="width:348px;" />
								</div>
								<div style="float:left;margin-left:10px;">
									<label style="width:auto">Número</label>
									<input type="text" name="NumeroDoador" value="" placeholder="Número" style="width:59px;float:left;" />
								</div>
							</div>
							<div class="break label-break">
								<div style="float:left">
									<label>Complemento</label>
									<input type="text" name="ComplementoDoador" value="" placeholder="Complemento" style="width:198px;" />
								</div>
								<div style="float:left;margin-left:40px;">
									<label style="width:auto">Bairro</label>
									<input type="text" name="BairroDoador" value="" placeholder="Bairro" style="width:198px;float:left;" />
								</div>
							</div>
							<div class="break label-break">
								<div style="float:left; margin-left:60px;">
								<label style="width:auto">Estado</label>
									<select  id="estado" name="EstadoDoador"  placeholder="Exemplo: RJ" style="width: 228px;float: left;padding: 5px;height: 45px;text-transform: uppercase;" ></select>
								</div>
								<div style="float:left;margin-left:-4px;">
								<label style="width: 98px;">Cidade</label>
								<select  name="CidadeDoador" id="cidade" style="width: 225px; padding: 5px; height: 45px;" ></select>
								</div>
							</div>
							<div class="break label-break">
								<div style="float:left">
									<label>Telefone</label>
									<input type="text" name="TelefoneDoador" value="" placeholder="(xx) xxxx-xxxx" onkeypress="mascaraGeral(this, mtel);" style="width:198px;" />
								</div>
								<div style="float:left;margin-left:32px;">
									<label style="width:auto">Celular</label>
									<input type="text" name="CelularDoador" value="" placeholder="(xx) xxxxx-xxxx" onkeypress="mascaraGeral(this, mtel);" style="width:198px;float:left;" />
								</div>
							</div>							
						</div>
					</div>
				</div>
				
				<div id="step-dados_pagamento">
					<div id="titulo-dados_pagamento">
						<!--<span class="line-titulo" style="margin-top:14px;width:320px;height:1px;background:#e1e4e9;float:left;"></span>
							<label style="float:left;font-family:Gotham-Medium;font-size:24px;margin:0px 12px;">DADOS DE PAGAMENTO</label>
						<span class="line-titulo" style="margin-top:14px;width:320px;height:1px;background:#e1e4e9;float:left;"></span>-->
						
						<div style="/*margin-top:40px;*/margin-bottom:85px;clear:both;float:left;" id="section_dados_pagamento">
						
							<!--<div>
								<div class="break" style="margin:0px;text-align:center;width:882px;display:block">
									<div style="float:left;margin-left:150px;width:198px;">
										<input type="radio" name="OpcaoFormaPagamento" class="OpcaoFormaPagamento" value="DebitoAutomatico" style="float:left;" />
										<label class="without-select-text label-OpcaoFormaPagamento">Débito Automático</label>
									</div>
									<div style="float:left;margin-left:48px;width:186px;">
										<input type="radio" name="OpcaoFormaPagamento" class="OpcaoFormaPagamento" value="CartaoCredito" checked style="float:left;" />
										<label class="without-select-text label-OpcaoFormaPagamento">Cartão de Crédito</label>
									</div>
									<div style="float:left;margin-left:48px;width:170px;">
										<input type="radio" name="OpcaoFormaPagamento" class="OpcaoFormaPagamento" value="BoletoBancario" style="float:left;" />
										<label class="without-select-text label-OpcaoFormaPagamento">Boleto Bancário</label>
									</div>
								</div>
								<div class="break" style="margin-left:215px;margin-top:36px">
									<div style="float:left;width:100px;">
										<input type="radio" name="OpcaoCartaoCredito" class="OpcaoFormaPagamento" value="Visa" style="float:left;" />
										<div style="float:right;text-align:center;margin-top:-12px;">
											<img src="images/selo-visa.png" alt="" style="float:left;clear:both" /><br />
											<label class="label-box without-select-text" style="display:block;float:left;clear:both;margin-left:23px;">Visa</label>
										</div>
									</div>
									<div style="float:left;margin-left:60px;width:100px;">
										<input type="radio" name="OpcaoCartaoCredito" class="OpcaoFormaPagamento" value="MasterCard" checked style="float:left;" />
										<div style="float:right;text-align:center;margin-top:-12px;">
											<img src="images/selo-mastercard.png" alt="" style="float:left;clear:both" /><br />
											<label class="label-box without-select-text" style="display:block;float:left;clear:both;margin-left:0px;">MasterCard</label>
										</div>
									</div>
									<div style="float:left;margin-left:60px;width:100px;">
										<input type="radio" name="OpcaoCartaoCredito" class="OpcaoFormaPagamento" value="Amex" style="float:left;" />
										<div style="float:right;text-align:center;margin-top:-12px;">
											<img src="images/selo-amex.png" alt="" style="float:left;clear:both" /><br />
											<label class="label-box without-select-text" style="display:block;float:left;clear:both;margin-left:18px">Amex</label>
										</div>								
									</div>								
									<div style="float:left;margin-left:60px;width:100px;">
										<input type="radio" name="OpcaoCartaoCredito" class="OpcaoFormaPagamento" value="Diners" style="float:left;" />
										<div style="float:right;text-align:center;margin-top:-12px;">
											<img src="images/selo-diners.png" alt="" style="float:left;clear:both" />
											<label class="label-box without-select-text" style="display:block;float:left;clear:both;margin-left:18px">Diners</label>
										</div>								
									</div>								
								</div>
							</div>
							
							<div id="subsection_dados_pagamento">
								<div class="break label-break">
									<label>Nome do Titular do Cartão</label>
									<input type="text" name="NomeTitularCartaoDoador" value="" placeholder="Nome e Sobrenome" style="width:525px;" />
								</div>
								<div class="break label-break">
									<label>Número do Cartão</label>
									<input type="text" name="NumeroCartaoDoador" value="" placeholder="xxxx xxxx xxxx xxxx" style="width:525px;" />
								</div>
								<div class="break label-break">
									<div style="float:left">
										<label>Código de Segurança</label>
										<input type="text" name="CVVDoador" value="" placeholder="Código de segurança" style="width:228px;" />
										<span class="bt-duvida-codigo_de_seguranca" style="cursor:pointer;border-radius:32px;-webkit-border-radius:32px;width:6px;height:11px;display:inline-block;background:#6c6c6c;color:#fff;font-size:10px;font-family:Gotham-Book;padding:4px;">?</span>
									</div>
									<div style="float:left;margin-left:32px;">
										<label style="width:auto">Validade</label>
										<input type="text" name="MesValidadeCartaoDoador" value="" placeholder="Mês" style="width:48px;float:left;" />
										<input type="text" name="AnoValidadeCartaoDoador" value="" placeholder="Ano" style="width:48px;float:left;margin-left:10px" />
									</div>
								</div>
								<div class="break label-break" style="margin-left:351px">
									<img src="images/certisign.png" alt="" style="float:left" />
									<img src="images/verisign.png" alt="" style="float:left;margin-left:50px" />
								</div>
							</div>-->
							
							<div id="subsection_dados_pagamento_termos" style="margin-left:212px;margin-top:50px;clear:both;float:left; width: 100%;">
									<div class="break" style="margin-top:12px;">
										<input type="checkbox" name="AceitoEmail" id="AceitoEmail" style="float:left;" />
										<label for="AceitoEmail" class="label-box without-select-text">Aceito receber informações sobre a ActionAid por e-mail.</label>
									</div>							
									<div class="break" style="margin-top:12px;">
										<input type="checkbox" name="AceitoCelular" id="AceitoCelular" style="float:left;" />
										<label for="AceitoCelular" class="label-box without-select-text">Aceito receber informações sobre a ActionAid por celular.</label>
									</div>							
									<div class="break" style="margin-top:12px;">
										<input type="checkbox" name="AceitoPolitica" id="AceitoPolitica" style="float:left;" />
										<label for="AceitoPolitica" class="label-box without-select-text">Li e estou de acordo com a <a href="http://www.actionaid.org.br/politica-de-privacidade" target="_blank" style="text-decoration: underline;">política de privacidade.</a></label>
									</div>							
							</div>
							<button style="border: 0px none; background-color: transparent; margin-left: 110px; cursor: pointer; position: relative; margin-top: 35px; width: 295px; height: 62px;" type="submit" id="btn_pagseguro">
								<span class="bt-green" style="width: 226px; font-family: Gotham-Medium; font-size: 22px; display: block; padding: 15px 31px; position: absolute; left: 0; top: 0px;">DOAR</span>			
							</button>
							<button style="border: 0px none; background-color: transparent; margin-left: 110px; cursor: pointer; position: relative; margin-top: 35px; width: 295px; height: 62px;" type="submit" id="btn_paypal">
								<span class="bt-green" style="width: 226px; display:none; font-family: Gotham-Medium; font-size: 22px; display: block; padding: 15px 31px; position: absolute; left: 0px; top: 0px;">DOAR Paypal</span>			
							</button>
						</div>					
					</div>					
				</div>
			</form>
			<div style="border: 1px solid #DCDCDC; position: relative; float: left; padding: 35px; width: 1100px; margin-bottom: 30px; border-radius: 5px;">
				<span class="mask-andamento_da_campanha" style="width: auto; margin-left: 0px;">
					<h2 class="lb-andamento_da_campanha">COMENTÁRIOS</h2>
				</span>			
				<div class="fb-comments" data-href="<?php echo $actual_link; ?>" data-width="1100" data-colorscheme="light"></div>			
			</div>
		</div>
		

	</div>
	<div id="footer">
		<div id="footer_content">
			<img src="images/txt-footer.png" alt="" style="margin:37px 0px 0px 120px;float:left;" />
			<a href="http://www.actionaid.com.br/" class="replace footer-actionaid" style="float:left;margin-top:28px;margin-left:100px"><strong>actionaid</strong></a>
		</div>
	</div>			
	<?php } ?>
</body>
</html>
