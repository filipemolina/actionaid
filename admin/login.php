<?php
session_start();
session_destroy();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Painel de Controle - Act!onAid</title>
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/sexyalertbox.css" />	
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>	
<script type="text/javascript" language="Javascript" src="js/sexyalertbox.v1.2.jquery.js"></script>
<link rel="shortcut icon" href="favicon.ico">

</head>
<body>
<script type="text/javascript">

$(document).ready(function (){
	$("#login").submit(function(e) {		
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "config/loginExe.php",
			data: new FormData( this ),
			processData: false,
			contentType: false,
			success: function (resposta) {
				if (resposta == 'erro') {
					Sexy.alert('<h1 style="float: left">Act!onAid </h1><p style="float: left; margin-left: 3px;"> diz:</p><br><br><p>Usuário ou senha inválidos</p>');
					return false;
				} else {
					window.location.href= 'index.php'
				}
			}
		});				
	});	
});
</script>
<div id="logincontainer">
    <div id="loginbox">
        <div id="loginheader">
           	<img src="images/cp_logo.png" style="margin:20px 0 0 0px" alt="Painel de Controle" />
		</div>
        <div id="innerlogin">
       		<form action="" method="POST" name="login" id="login">
		    	<p align="left">Login:</p>
		    	<input type="text" name="user" class="logininput" />
		    	<p align="left">Senha:</p>
		   		<input type="password" name="passwd" class="logininput" />
		               
		    	<input type="submit" class="loginbtn" value="Acessar" /><br />

        	</form>
        </div>
    </div>
    <img src="images/login_fade.png" alt="Fade" />
</div>

</body>
</html>
