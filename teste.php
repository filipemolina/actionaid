<?php

session_start();

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

FacebookSession::setDefaultApplication('1480329455534696', 'b74f36d85d2f7d089f802f56c7dba7b7');

$helper = new FacebookRedirectLoginHelper('http://wwww.doeumfuturodepresente.org.br/');

// Now you have the session
$session = $helper->getSessionFromRedirect();

?>