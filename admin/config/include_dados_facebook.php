<?php
header('P3P: CP="CAO PSA OUR"');
set_time_limit(9999999);
ini_set('session.gc_maxlifetime', 30*60);

include_once "config/connection.class.php";

function ConsultaConfig($campo){
	global $con;

	$confSQL = $con->query("SELECT $campo FROM config");
	$conf = $con->fetch_object($confSQL);
	return $conf->$campo;
}


/*$app_id     = "493079590703469";
$app_secret = "17d4912b9e05165e168e53d3bbd33acb";*/

$app_id     = "1480329455534696";
$app_secret = "b74f36d85d2f7d089f802f56c7dba7b7";

require 'facebook/facebook.php';

$_SESSION["link_aplicativo"] = "https://www.facebook.com/pages/Kleiton-Dias/309826482515617?id=309826482515617&sk=app_" . $app_id;
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
'req_perms' => 'user_birthday, email, read_stream, publish_stream, photo_upload, user_photos, friends_photos, user_photo_video_tags, friends_photo_video_tags',
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
?>