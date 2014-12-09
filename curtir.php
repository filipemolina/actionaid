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
	include_once "config/connection.class.php";

	function ConsultaConfig($campo){
		global $con;

		$confSQL = $con->query("SELECT $campo FROM config");
		$conf = $con->fetch_object($confSQL);
		return $conf->$campo;
	}
/*$app_id     = "493079590703469";
$app_secret = "17d4912b9e05165e168e53d3bbd33acb";*/

	$app_id     = "1480329755534666";
	$app_secret = "e03240f51a7bf23c7c96d2c84ebcd2fc";

	require 'Facebook/facebook.php';

	$_SESSION["link_aplicativo"] = "https://www.facebook.com/pages/Paciência/138759522886062?sk=app_" . $app_id;
	//$_SESSION["link_aplicativo"] = "http://www.agenciafrog-host.com.br/loreal/colorama/facebook_apps/look_colorama/";
	$_SESSION["link_real"]       = "http://www.doeumfuturodepresente.org.br";
	//$_SESSION["link_aplicativo"] = "http://loreal.agenciafrog.com.br/coloramaesmaltes/facebook/look_colorama/v0/";
	//$_SESSION["link_real"]       = "http://loreal.agenciafrog.com.br/coloramaesmaltes/facebook/look_colorama/v0/";

	$facebook = new Facebook(array(
	 'appId'  => $app_id,
	 'secret' => $app_secret,
	 'cookie' => true,
	));

	$session = $facebook->getSession();

	$me = null;
	if ($session) {
	 try {
	   $uid = $facebook->getUser();
	   $me = $facebook->api('/me');
	 } catch (FacebookApiException $e) {
	   error_log($e);
	 }
	}

	if ($me) {
	 $logoutUrl = $facebook->getLogoutUrl();
	} else {
	 $loginUrl = $facebook->getLoginUrl(array(
	'req_perms' => "'email', 'user_friends', 'user_about_me', 'publish_actions'",
	'next' => $_SESSION["link_aplicativo"],
	'cancel_url' => $_SESSION["link_aplicativo"]
	));
	}

	$naitik = $facebook->api('/naitik');

	$signed_request = $facebook->getSignedRequest();
	$like_status    = $signed_request["page"]["liked"];

	$url_completa = explode('/', $_SERVER['REQUEST_URI']);
	$url_completa = $url_completa[sizeof($url_completa)-1];
	$paginaAtual  = "";
	if ($url_completa != "")
	{    
	 list ($p1) = split ('[?]', $url_completa);
	 $paginaAtual = $p1;
	}

	$selfURL  = 'http://' . $_SERVER['HTTP_HOST'];
	$lastURL  = $_SERVER['REQUEST_URI'];
	$linkSEND = $selfURL . $lastURL;

	$linkSEND_explode = explode("/", $linkSEND);
	$size = count($linkSEND_explode);

	$link_dominio = "";

	for ($i=0; $i < $size-1; $i++)
	{
	 $link_dominio = $link_dominio . $linkSEND_explode[$i] . "/";
	}
	
if ($paginaAtual != "curtir.php")
{
 if ( ($paginaAtual == "") || ($paginaAtual == "index.php") )
 {
   /*
   $liked = "";

   if (!($me))
   {
     if (empty($like_status))
     {
       $liked = "N";
     }
     else
     {
       $liked = "S";
     }
   }
   else
   {
     $isFan = $facebook->api(array(
         "method"    => "pages.isFan",
         "page_id"   => "141153059326215",
         "uid"       => $me['id']
     ));

     if ($isFan === true)
     {
       $liked = "S";
     }
     else
     {
       $liked = "N";
     }
   }
   */

   if (empty($like_status))
   {
     $liked = "N";
   }
   else
   {
     $liked = "S";
   }

   $liked = "S";

   if ($liked == "N")
   {
     header('Location: curtir.php');
     die();
   }
   else
   {
     if (!($me))
     {
     ?>
     <script type="text/javascript">
       top.location.href = '<?php echo $loginUrl; ?>';
     </script>
     <?php

     die();
     }
   }
 }
}
?>
<<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
teste
</body>
</html>
