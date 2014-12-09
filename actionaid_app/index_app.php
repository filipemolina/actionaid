<?php 
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
	FacebookSession::setDefaultApplication( '1480329455534696','c1b6488a2ac584e4a2c765bb7ccd7818' );
	 
	// login helper with redirect_uri
	$helper = new FacebookRedirectLoginHelper( 'http://www.doeumfuturodepresente.org.br/actionaid_app/index_app.php' );
	 
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
		echo $ex->message;
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
	  echo '<pre>'.print_r( $graphObject, 1).'</pre>';
	  
	  // print logout url using session and redirect_uri (logout.php page should destroy the session)
	  echo '<a href="' . $helper->getLogoutUrl( $session, 'http://yourwebsite.com/app/logout.php' ) . '">Logout</a>';
	  
	} else {
	  // show login url
	  echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends', 'user_about_me' ) ) . '">Login</a>';
		  //echo $_SESSION['fb_token'];
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no">
  	<title>Aplicativo ActionAid</title>	
	
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="stylesheets/colorbox.css" />
	<link rel="stylesheet" type="text/css" href="stylesheets/base.css" />	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	
	<link rel="stylesheet" href="stylesheets/ezmark.css" media="all">	
	<script type="text/javascript" language="Javascript" src="javascripts/jquery.ezmark.min.js"></script>	
	
	<script src="javascripts/jquery.colorbox-min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>	
	<script type="text/javascript" language="Javascript" src="javascripts/ui.datepicker-pt-BR.js"></script>	
	<script type="text/javascript" language="javascript">
		$(document).ready(function (){
		
			$( ".input_calendar" ).datepicker();
			$('.numbersOnly').keyup(function () { 
				this.value = this.value.replace(/[^0-9\.]/g,'');
			});
			$('.upload').change(function() {
				$('#uploadFile').val($(this).val());
			});	
			
			$(function(){
				$('input,textarea').focus(function(){
					$(this).attr('placeholder','');
				});				
			});
			
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
				$(this).parent().hide();
				var next_step = $(this).attr('to');
				
				$('body, html').animate({scrollTop:0},600);
				
				if(next_step == '2') {
					$('.step-bar-vermelho_2').animate({
						'width' : '+=136px'
					}, 1000, function() {
						$('.step-bar_2').addClass('step-bar-ativo');
						$('#step_'+next_step).fadeIn();
					});
				}
				if(next_step == '3') {
					$('.step-bar-vermelho_3').animate({
						'width' : '+=136px'
					}, 1000, function() {
						$('.step-bar_3').addClass('step-bar-ativo');
						$('#step_'+next_step).fadeIn();
					});
				}
				if(next_step == '4') {
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
							$(this).parent().removeClass('item-estilo-ativo');
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
				/*$.post('includes/salvar_vela.php', {
				  idsanto: $('input[name="idsanto"]').val(),
				  nome: $('input[name="nome"]').val(),
				  email: $('input[name="email"]').val(),		
				  nascimento: $('input[name="nascimento"]').val(),
				  cidade: $('input[name="cidade"]').val(),		  
				  estado: $('select[name="estado"]').val(),	
				  intencao: $('input[name="intencao"]').val(),	
				  newsletter: $('input[name="newsletter"]').val(),			  
				}, function (resposta) {

					if (resposta)
					{
						$.blockUI({ 
							message: $('.acender_vela_sucesso'), 
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
						}, 60000); 		  
						return false;
					}
				});*/
				
				$.ajax({
					type: "POST",
					url: "salvar_dados.php",
					data: {
					  idsanto: $('input[name=""]:checked').val(),
					  nome: $('input[name="nome"]').val(),
					  email: $('input[name="email"]').val(),		
					  nascimento: $('input[name="nascimento"]').val(),
					  cidade: $('input[name="cidade"]').val(),		  
					  estado: $('select[name="estado"]').val(),	
					  intencao: $('input[name="intencao"]').val(),	
					  newsletter: $('input[name="newsletter"]').val()		
					},
					success: function (resposta) {
						if (resposta) {
							$("#resultado").html(resposta);
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
							}, 60000); 		  
							return false;
						}
					}
				});

				return false;

			});					
			
						
		});	
	</script>	
</head>
<body>
  <div id="container">
		<div id="content">
			<div id="header">
				<h1 class="replace lb-header"><strong>ActionAid - Doe um futuro de presente</strong></h1>
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

			<!-- DOE UM FUTURO DE PRESENTE -->
			<?php	if ( !isset( $session ) ) { ?>
			<div class="content-step" id="intro" style="display:block">
				<img src="images/luiza_possi.png" alt="" style="position:absolute;left:528px;top:39px;" />
				<p style="margin-left: 22px;text-align: center;float: left;margin-top: 45px;clear: both;font-family: Gotham-Book;font-size: 18px;color: #494949;">
					<font style="font-size:35.95px;color:#6c6c6c;font-family:Gotham-Light;">DOE UM FUTURO<br/>DE PRESENTE!</font>
					<br /><br />
					Chegou a hora de ajudar a mudar o mundo. E pode<br />
					acreditar, isso é mais simples do que parece. É só você<br />
					trocar aqueles presentes sem graça por uma doação.
					<br /><br />
					Vale aproveitar o Natal, o aniversário, a Páscoa ou<br ;>
					qualquer outra data. O importante é ajudar uma das<br />
					causas da <font style="font-family:Gotham-Bold;font-size:14px;color:#c80a24">Act!onaind</font>.
					<br /><br />
					<font style="font-family:Gotham-Bold;font-size:18px;color:#494949;">CRIE JÁ SUA CAMPANHA DE DOAÇÃO.<BR />
					SEUS AMIGOS VÃO CURTIR ESSA IDÉIA!</font>
				</p>
				<?php echo '<a href="' . $helper->getLoginUrl() . '">' ?> <span class="bt-green bt-criar_minha_campanha without-select-text" style="margin-left:100px;margin-top:41px;font-family:Gotham-Medium;font-size:20px;">Criar minha campanha</span></a>
				
				<div id="como-funciona" style="margin-top:88px;width:800px;height:456px;background:url(images/bg-como-funciona.png);float:left;clear:both;">
					<h2 style="font-family:Gotham-ExtraLight;font-size:31px;margin:50px 0px 0px 243px">COMO FUNCIONA</h2>
					
					<div class="replace box-como-funciona">
						
						<a class="youtube" href="http://www.youtube.com/embed/5nUDZhLoVR4?rel=0&amp;wmode=transparent;autoplay=1">
							<span class="replace bt-play-como-funciona">
								<span class="arrow-right"></span>
							</span>
						</a>
					</div>
				</div>
				<div id="conheca-a-actionaid" style="width:800px;height:505px;background:#c80a24;float:left;clear:both;">
					<h2 style="background:#c80a24;font-family:Gotham-ExtraLight;font-size:31px;padding:41px 0px 34px 188px;color:#fff">CONHEÇA A ACTIONAID</h2>
					<p style="text-align:center;padding:65px 0px 0px 0px;height:335px;background:#c80a24 url(images/bg-conheca-a-actionaid.png) no-repeat top center;font-size:22px;font-family:Gotham-Light;color:#fff;line-height:32px;">Fundada em 1972, a <span style="font-family:Gotham-Bold;">ActionAid</span> é uma organização sem<br />
					fins lucrativos cujo trabalho atinge cerca de 20 milhões<br />
					de pessoas em 45 países.<br />
					<br />
					A <span style="font-family:Gotham-Bold;">ActionAid</span> está no Brasil desde 1999. Nossa atuação<br />
					já envolve 25 organizações parceiras em 13 estados,<br />
					beneficiando mais de 300 mil pessoas em cerca de<br />
					1.300 comunidades.
					</p>
				</div>				
			</div>
			<?php }?>
			<!-- -->
			
			<!-- ESCOLHA SUA CAUSA -->
			<?php	if ( !isset( $session ) ) { ?>
			<div class="content-step" id="step_1" style="display: none;">
			<?php } else { ?>
			<p id="name_for_facebook" style="text-transform: uppercase; display: none;"><?php echo $graphObject['name'];?></p>
			<div class="content-step" id="step_1" style="">
			<?php } ?>
				<div style="margin:40px 0px 0px 127px;text-align:center;width:530px">
				<font style="font-family:Gotham-Light;font-size:35.95px;">ESCOLHA SUA CAUSA</font>
				<font style="font-family:Gotham-Book;font-size:14.78px;margin-top:20px;display:block;clear:both;float:left">Você já começou a mudar o mundo. Só falta escolher uma boa causa!</font>
				</div>
				
				<ul id="lista_causas">
					<li style="margin-left:0px;">
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
					<li>
						<div class="box-foto-causa">
							<img src="images/causas/todas_as_criancas_na_sala_de_aula.jpg" alt="" />
							<div class="descricao-foto-causa">
								Embora, em 2010, o direito a alimentação tenha sido incluído na constituição, milhões de brasileiros continuam passando fome. Para fazer esse direito valer, a ActionAid investe em capacitação no meio rural, produção de conhecimento e mobilização pública.
							</div>
						</div>
						<span class="titulo-causa" style="width: 180px; margin-left: 25px;">Todas as crianças na sala de aula</span>

						<span class="arrow-bottom-right">
							<span class="button-descricao-causa" state="more">+</span>
						</span>
					</li>
					<li>
						<div class="box-foto-causa">
							<img src="images/causas/fim_da_violencia_contra_as_mulheres.jpg" alt="" />
							<div class="descricao-foto-causa">
								Embora, em 2010, o direito a alimentação tenha sido incluído na constituição, milhões de brasileiros continuam passando fome. Para fazer esse direito valer, a ActionAid investe em capacitação no meio rural, produção de conhecimento e mobilização pública.
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
				<span class="bt-green bt-next" to="2" style="width:149px;left:307px;top:745px;position:absolute;font-family:Gotham-Medium;font-size:18px;">
					PRÓXIMO
					<span class="line-button" style="display:block;width:1px;height:50px;background:#4eb138;position:absolute;top:0px;right:55px;"></span>
					<span class="arrow-right-small"></span>
				</span>				
			</div>
			<!-- -->
			
			<!-- PREENCHA OS DADOS -->
			<div class="content-step" id="step_2" style="display:none">
				<div style="margin:40px 0px 0px 127px;text-align:center;width:530px">
					<font style="font-family:Gotham-Light;font-size:35.95px;">PREENCHA OS DADOS</font>
					<font style="font-family:Gotham-Book;font-size:14.78px;margin-top:25px;display:block;clear:both;float:left">Se você vai mudar o mundo, é justo que receba os créditos por isso.<br />Então, dê o seu nome e a sua cara para a campanha.</font>
				</div>
				
				<form id="formCadastro" action="" method="POST" style="margin-top:50px;clear:both;float:left;margin-left:80px">
					<div class="div-field">
						<label>Nome da Campanha</label>
						<div class="break">
							<input type="text" name="NomeCampanha" id="NomeCampanha" value="" style="width:619px" placeholder="Dê um nome para a campanha" maxlength="19"/>
						</div>
					</div>
					<div class="div-field">
						<label>Período</label>
						<div class="break">
							<input type="text" value="" style="float:left;width:210px;" class="input_calendar" placeholder="Início" />
							<input type="text" value="" style="float:left;margin-left:10px;width:210px;" class="input_calendar" placeholder="Fim" />
							<span style="margin-top:10px;display:block;float:left;margin-left:12px;font-family:Gotham-Light;font-size:11px">A campanha deve ter no<br />máximo 1 mês de duração</span>
						</div>
					</div>
					<div class="div-field">
						<label>Foto</label>
						<div class="break" style="width: 595px;">
							<input id="uploadFile" placeholder="Fazer Upload de outra Foto" disabled="disabled" style="width: 216px; float: left;background-color: #FFF;opacity: 1;"/>
							<div class="fileUpload btn btn-primary" style="display: block; float: left; margin-top: 3px; margin-left: 10px; font-family: Gotham-Medium; font-size: 12px; background: #d3d3d3; color: #898989; padding: 15px; -webkit-border-radius: 4px; border-radius: 4px; cursor: pointer; font-family: Gotham-Medium; font-size: 11px; width: 93px; text-align: center;">
								<span>UPLOAD</span>
								<input type="file" class="upload" />
							</div>
							<!--<input type="file" name="Foto" id="Foto" value="Fazer Upload de outra Foto" style="width:286px;float:left;" />
							<input type="file" value="UPLOAD" name="Foto"  />-->
							<div style="float:left;margin-left:20px;padding-top:14px;">
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
					<div class="div-field">
						<label>Meta de Arrecadação</label>
						<div class="break">
							<div style="float:left">
								<input type="radio" name="valorArrecadado" id="valorArrecadado100" value="100" style="float:left;" />
								<label for="valorArrecadado100" class="label-box without-select-text">R$ 100,00</label>
							</div>
							<div style="float:left;margin-left:20px;">
								<input type="radio" name="valorArrecadado" id="valorArrecadado200" value="200" style="float:left;" />
								<label for="valorArrecadado200" class="label-box without-select-text">R$ 200,00</label>
							</div>
							<div style="float:left;margin-left:20px;">
								<input type="radio" name="valorArrecadado" id="valorArrecadado300" value="300" style="float:left;" />
								<label for="valorArrecadado300" class="label-box without-select-text">R$ 300,00</label>
							</div>
							<div style="float:left;margin-left:20px;">
								<input type="radio" name="valorArrecadado" id="valorArrecadado3000" value="3000" style="float:left;" />
								<label for="valorArrecadado3000" class="label-box without-select-text">R$ 3000,00</label>
							</div>
							<input type="text" name="OutroValor" id="OutroValor" placeholder="Outro Valor" style="width:155px;margin-left:38px;margin-top:-16px;" class="numbersOnly" />
						</div>
					</div>
					<div class="div-field">
						<label>Descrição</label>
						<div class="break">
							<div style="float:left">
								<textarea name="Descricao" id="Descricao" style="width:486px;height:69px;" placeholder="Escreva aqui uma breve descrição da sua campanha" maxlength="154"></textarea>
							</div>
							<div style="float:left">
								<span class="bt-cinza">EXEMPLO</span>
								<span class="bt-cinza">ESCREVA A SUA</span>
							</div>
						</div>
					</div>
					<div class="div-field">
					<!--Divs geradas par ao exemplo-->
						<div style="display: none;">
							<!-- Exemplo aniversário -->
						   <div id="cb_exemplo_aniversario" style="background-image: url(images/exemplos/exemplo-thumb-aniversario.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 35px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 2px solid #988a67; border-bottom: 2px solid #988a67; padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 17px" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>
							<!-- Exemplo páscoa -->
						   <div id="cb_exemplo_pascoa" style="background-image: url(images/exemplos/bg-pascoa-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 35px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 2px solid #988a67; border-bottom: 2px solid #988a67; padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 17px" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>
							<!-- Exemplo natal -->
						   <div id="cb_exemplo_natal" style="background-image: url(images/exemplos/bg-natal-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 35px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 2px solid #988a67; border-bottom: 2px solid #988a67; padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 17px" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>	
							<!-- Exemplo 1 -->
						   <div id="cb_exemplo_1" style="background-image: url(images/exemplos/bg-1-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 35px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 2px solid #988a67; border-bottom: 2px solid #988a67; padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 17px" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>								
							<!-- Exemplo 2 -->
						   <div id="cb_exemplo_2" style="background-image: url(images/exemplos/bg-3-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 35px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 2px solid #988a67; border-bottom: 2px solid #988a67; padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 17px" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>	
							<!-- Exemplo 3 -->
						   <div id="cb_exemplo_3" style="background-image: url(images/exemplos/bg-2-thumb.png); height: 286px; color: #FFF; background-repeat: no-repeat;">
								<div class="texto" style="margin-left: 45px; padding: 23px 0; width: 270px;">
									<h1 style="font-family: gabrielaregular; font-size: 35px; text-transform: uppercase;">NOME DA SUA CAMPANHA</h1>
									<p style="font-family: Gotham-Bold; border-top: 2px solid #988a67; border-bottom: 2px solid #988a67; padding: 10px 7px; font-size: 11px;" class="usuario">por SEU NOME</p>
									<p style="font-family: gabrielaregular; font-size: 17px" class="descricao">Aqui entra o texto de descrição da sua campanha. Esse texto é importante para chamar as pessoas para fazerem a doação pra Act!onaid.</p>
								</div>
							</div>								
							
						</div>					
						<label>Estilo</label>
						<div class="break">
							<div>
								<div class="estilo" style="margin-left:0px">								
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
								<div class="estilo">
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
								<div class="estilo">
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
								<div class="estilo" style="margin-left:0px">
									<img src="images/estilos_campanha/2.png" alt="" />
									<div class="ver-exemplo">
										<a href="#" id="exemplo_2"><img src="images/zoom-small.png" alt="" /></a><br />
										<span class="lb-ver-exemplo">VER EXEMPLO</span>
									</div>
									<div class="escolher">
										<img src="images/yes-small.png" alt="" /><br />
										<span class="lb-escolher">ESCOLHER</span>
									</div>
								</div>
								<div class="estilo">
									<img src="images/estilos_campanha/3.png" alt="" />
									<div class="ver-exemplo">
										<a href="#" id="exemplo_1"><img src="images/zoom-small.png" alt="" /></a><br />
										<span class="lb-ver-exemplo">VER EXEMPLO</span>
									</div>
									<div class="escolher">
										<img src="images/yes-small.png" alt="" /><br />
										<span class="lb-escolher">ESCOLHER</span>
									</div>
								</div>							
								<div class="estilo">
									<img src="images/estilos_campanha/6.png" alt="" />
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
				</form>
					<span class="bt-green bt-next" to="3" style="width:149px;margin-left:295px;margin-top:41px;font-family:Gotham-Medium;font-size:18px;">
						PRÓXIMO
						<span class="line-button" style="display:block;width:1px;height:50px;background:#4eb138;position:absolute;top:0px;right:55px;"></span>
						<span class="arrow-right-small"></span>
					</span>									
			</div>
			<!-- -->
			
			<!-- SUA CAMPANHA -->
			<div class="content-step" id="step_3" style="display:none;margin-left:80px;">
				<div style="margin-top:40px;text-align:center;width:638px;text-align:center;">
					<font style="font-family:Gotham-Light;font-size:35.95px;width:638px;text-align:center;">SUA CAMPANHA</font>
					<font style="color:#494949;font-family:Gotham-Book;font-size:12.78px;margin-top:25px;display:block;clear:both;float:left;width:638px;text-align:center;">É assim que vai ficar sua campanha.<br />Se não gostou, aproveite que dá tempo de mudar, é só <b style="cursor:pointer;" class="btn_voltar_2">voltar</b> e refazer.</font>
				</div>
				
				<div id="preview_campanha" style="margin-top:50px" class="break">
					<img src="images/sua_campanha/sua_campanha_preview.png" alt="" />
				</div>
				
				<font class="break" style="font-family:Gotham-Book;font-size:19.97px;margin-top:45px;width:638px;text-align:center;color:#494949;">Mas se você curtiu o visual, pronto, é só finalizar!</font>
				
				<span class="bt-green bt-next" to="4" style="width:149px;margin-left:214px;margin-top:50px;font-family:Gotham-Medium;font-size:18px;">
					PRÓXIMO
					<span class="line-button" style="display:block;width:1px;height:50px;background:#4eb138;position:absolute;top:0px;right:55px;"></span>
					<span class="arrow-right-small"></span>
				</span>													
			</div>
			<!-- -- >
			
			<!-- SUA CAMPANHA -->
			<div class="content-step" id="step_4" style="display:none;margin-left:80px;">
				<div style="margin-top:40px;text-align:center;width:638px;text-align:center;">
					<font style="font-family:Gotham-Light;font-size:35.95px;width:638px;text-align:center;" class="break">PARABÉNS</font>
					<img src="images/facelike.png" alt="" class="break" style="margin:50px 0px;margin-left:275px" />
					<font style="margin-bottom:45px;color:#494949;font-family:Gotham-Book;font-size:12.78px;margin-top:25px;display:block;clear:both;float:left;width:638px;text-align:center;">
						Se for seu aniversário, parabéns. Se não for , parabéns também! Com a sua<br />
						campanha você vai trocar presentes por um futuro melhor para quem precisa.<br /><br />
						<b style="font-family:Gotham-Medium;font-size:15.98px;">Agora, é só compartilhar e chamar a galera para participar!</b>
					</font>
					
					<span style="display:block;margin-left:121px;margin-top:45px;cursor:pointer" to="5" class="bt-green">Compartilhar na minha timeline</span>
				</div>
			</div>
			
			<!-- -->
		</div>
		

		<div id="footer">
		</div>			
	</div>
</body>
</html>
