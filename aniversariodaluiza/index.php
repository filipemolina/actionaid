<?php 
	require_once 'Mobile_Detect.php';
	$detect = new Mobile_Detect;
	 
	// Any mobile device (phones or tablets).

	require_once ("PagSeguroLibrary/PagSeguroLibrary.php");
	//use PagSeguroLibrary/PagSeguroLibrary.php;
	
	date_default_timezone_set("America/Sao_Paulo");		
	include_once "../config/connection.class.php";

	function ConsultaConfig($campo){
		global $con;

		$confSQL = $con->query("SELECT $campo FROM config");
		$conf = $con->fetch_object($confSQL);
		return $conf->$campo;
	}
	
	$select_usuario = $con->query("SELECT * FROM users WHERE user_id = '1391292311159873' ");
	while($usuario	= $con->fetch_object($select_usuario)){
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<?php if ( $detect->isMobile() ) { ?>
		<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" style="background-color: #df0a24;">
	<?php } else { ?>
		<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
	<?php } ?>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" /
	<meta property="og:title" content="Doe um futuro de presente"/>
	<meta property="og:type" content="website"/>
	<meta property="og:url" content="http://www.doeumfuturodepresente.org.br/campanha/aniversariodaluiza"/>
	<meta property="og:image" content="http://www.renoi.de/images/lg.jpg"/>
	<meta property="og:site_name" content="My Site Name"/>
	<meta property="og:email" content="hello@mywebaddress.com"/>
	<meta property="og:description" content="Esse deve ter sido o melhor presente que eu já dei na vida, afinal não é todo dia que dou um futuro para alguém. Venha você também ajudar nessa causa!"/>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no">
  	<title>Aniversário da Luiza</title>	
	
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	
	<link rel="stylesheet" type="text/css" href="stylesheets/base.css" />
	<link rel="stylesheet" type="text/css" href="stylesheets/sexyalertbox.css" />		
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	
	<link rel="stylesheet" href="stylesheets/ezmark.css" media="all">	
	<script type="text/javascript" language="Javascript" src="javascripts/jquery.ezmark.min.js"></script>
	<script type="text/javascript" language="Javascript" src="../javascripts/jquery.maskMoney.js"></script>
	<!--<script type="text/javascript" language="Javascript" src="javascripts/jquery.maskedinput-1.1.4.pack.js"/></script>-->
	<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script> 
	<script type="text/javascript" language="Javascript" src="javascripts/jquery.easing.1.3.js"></script>		
	<script type="text/javascript" language="Javascript" src="javascripts/sexyalertbox.v1.2.jquery.js"></script>		
	<script type="text/javascript" language="javascript">

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

			$("#formDoacao").submit(function(e)
			{
			
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
			    }	

			   if (document.formDoacao.EmailDoador.value == "") {
				 Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Preencha o seu email.</p>');
				 return false;
			   } else {
				 if (document.formDoacao.EmailDoador.value.indexOf('@') <= -1) {
				   Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Email inválido.</p>');
				   return false;
				 }
			   }			    

			    if (document.formDoacao.CEPDoador.value == "") {
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
				
					var formData = new FormData(this);
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
											Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Erro ao efeutar a doação.</p>');
										}
									});							
								return false;
							} else {
							
							}
						}
					});
				
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
	<?php if ( $detect->isMobile() ) { ?>
	<div style="height: auto; position: relative;">
		<div id="container_header" style="height: 200px; background-color: #C80A24; background-image: none;">
			<div id="header">
				<img src="images/mobile/top.png" style="/* width: 166px; */ /* height: 22px; */ position:absolute; top:50%; left:50%; margin-top: -100px; margin-left: -320px;"/>		
			</div>
		</div>	
		<div id="container" style="background-color: #df0a24;">
			<div id="content" style="width: 100%;">		
				<div style="padding: 35% 0 145px 0; background-color: #df0a24; width: 980px; position: relative; /* margin-top: 100px; */ /* text-align: center; */ color: #fff; font-size: 4em; margin: 0 auto;">
					<p style="text-align: center; padding: 0 70px;">Prezado doador,</p>
					<br />
					<p  style="text-align: center; padding: 0 70px;">O sistema de doação ainda não está disponível para dispositivos móveis por motivos de segurança.</p>
					<br />
					<p  style="text-align: center; padding: 0 70px;">Atenciosamente,</p>
					<br />
					<p  style="text-align: center; padding: 0 70px;">ActionAid Brasil</p>
				</div>
			</div>
		</div>	
	<?php } else { ?>
	<img src="images/Web-Banner.jpg" style="display: none;"/>
	<div id="container_header">
			<div id="header">	
				<h1><a href="index.php" class="replace lb-actionaid"><strong>ActionAid</strong></a></h1>
				<h2 class="replace lb-doeumfuturodepresente"><strong>ActionAid</strong></h1>
			</div>
	</div>
	<div id="container">
		<div id="content">
			<div style="display: none; z-index: 99999; background-color: #191919; position: fixed; height: 100%; margin: 0px auto; opacity: 0.95; width: 1201px;" class="loading">
				<div style="width: 715px; height: 575px; background-color: rgb(255, 255, 255); margin: 40px auto 0px; position: relative;">
					<div style="width: 485px; margin: 0px auto;">
						<h1 style="font-family: Gotham-Light; font-size: 45px; padding: 80px 155px 40px;">VALEU!</h1>
						<p style="font-family: Gotham-Book; font-size: 13px; padding: 0px 41px; 0px;">Esse deve ter sido o melhor presente que você já deu na vida.</p>
						<p style="font-family: Gotham-Book; font-size: 13px; padding: 0px 75px 30px;">Afinal, não é todo dia que alguém ganha um futuro.</p>
						<p style="font-family: Gotham-Medium; font-size: 15px; padding: 0px 100px 35px; color: #494949;">Obrigado por me ajudar nessa causa!</p>
						<a onClick="window.open('https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.doeumfuturodepresente.org.br%2Faniversariodaluiza','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)" style="display: block; border: 0px none; background-color: transparent; cursor: pointer; position: relative; margin: 0px; width: 490px; height: 71px; margin-bottom: 60px;">
							<span style="font-family: Gotham-Medium; font-size: 22px; display: block; position: absolute; left: 0px; top: 0px; width: 430px; padding: 20px 30px;" class="bt-green">COMPARTILHAR NA MINHA TIMELINE</span>
						</a>
						<p style="font-family: Gotham-Book; font-size: 13px; padding: 0px 95px 0px;">Aproveite, crie uma campanha você também.</p>
						<p style="font-family: Gotham-Book; font-size: 13px; padding: 0px 97px 40px;">Ajuda para mudar o mundo nunca é demais.</p>
						<a href="/" style="padding: 0 115px;">
							<img src="images/btn_criar_minha_campanha.png" />
						</a>
					</div>
				</div>
			</div>		
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
								$select_apoiadores = $con->query("SELECT * FROM users_payement WHERE user_id = '1391292311159873' AND id_transacao IS NOT NULL AND status='Pago' ");
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
										$valor_arrecadado = $con->query("SELECT SUM(valor_doacao) AS total FROM users_payement WHERE user_id = '1391292311159873' AND id_transacao IS NOT NULL AND status='Pago'");
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
								echo $dias; 
							?>
							</span>
							<span class="label-campanha lb-dias_restantes">Dias restantes</span>
						</div>
					</li>
				</ul>
			</div>
			<form id="formDoacao" style="float:left;clear:both;margin:0px 0px 0px 130px;" action="" method="POST" enctype="multipart/form-data" name="formDoacao">
				<input type="hidden" name="UserId" value="1391292311159873" />
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
								<div style="float:left">
									<label>Cidade</label>
									<input type="text" name="CidadeDoador" value="" placeholder="Cidade" style="width:198px;" />
								</div>
								<div style="float:left;margin-left:32px;">
									<label style="width:auto">Estado</label>
									<input type="text" name="EstadoDoador" value="" placeholder="Exemplo: RJ" style="width:198px;float:left; text-transform: uppercase;" maxlength="2" />
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
							
							<div id="subsection_dados_pagamento_termos" style="margin-left:212px;margin-top:50px;clear:both;float:left">
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
							<button style="border: 0px none; background-color: transparent; margin-left: 320px; cursor: pointer; position: relative; margin-top: 35px; width: 294px; height: 62px;" type="submit">
							<span class="bt-green" style="width: 89px; font-family: Gotham-Medium; font-size: 22px; display: block; padding: 15px 100px; position: absolute; left: 0px; top: 0px;">DOAR</span>			
							</button>
						
						</div>
					</div>
				</div>
			</form>
			
		</div>
		

	</div>
	<div id="footer">
		<div id="footer_content">
			<img src="images/txt-footer.png" alt="" style="margin:37px 0px 0px 120px;float:left;" />
			<a href="http://www.actionaid.com.br/" class="replace footer-actionaid" style="float:left;margin-top:28px;margin-left:100px"><strong>actionaid</strong></a>
		</div>
	</div>			
</body>
</html>
<?php }} ?>