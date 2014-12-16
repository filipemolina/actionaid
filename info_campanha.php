<?php


include_once "config/connection.class.php";
require_once("vendor/Email.php");

function ConsultaConfig($campo){
	global $con;

	$confSQL = $con->query("SELECT $campo FROM config");
	$conf = $con->fetch_object($confSQL);
	return $conf->$campo;
}



//include_once "config/inc_settings.php";

/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();*/

    //print_r($_POST);
    //print_r($_FILES);
$valor_arrecadado = '';
$user_id = $_POST['UserId'];
$nome = $_POST['Nome'];
$causa = $_POST['Causa'];
$email = $_POST['Email'];
$foto_facebook = $_POST['ProfilePicture'];
$usar_foto = $_POST['fotoPerfil'];
$campanha = $_POST['NomeCampanha'];
$data_fim = $_POST['DataFim'];
$valor_arrecadado = $_POST['valorArrecadado'];
$outro_valor = $_POST['OutroValor'];
$descricao = $_POST['Descricao'];
$layout = $_POST['Layout'];
$foto = $_POST['foto_campanha'];
//$data = explode("/", $nascimento);
//$data_extc = $data[2] ."-". $data[1] ."-". $data[0];
$nome = utf8_decode($nome);
$campanha = utf8_decode($campanha);
$descricao = utf8_decode($descricao);
if($valor_arrecadado == '') {
	$outro_valor = str_replace('R$ ', '', $outro_valor);
	$valor_arrecadado = floatval($outro_valor);
}

if ($usar_foto != 'on') {
	$file = $_FILES["FotoCampanha"]["tmp_name"];
	$file_name = $_FILES["FotoCampanha"]["name"];
	$file_name = substr(md5(date("YmdHis")),0 ,30).'.jpg';

	$caminho="uploads/";
	$caminho=$caminho.$file_name;

	/* Defina aqui o tipo de foto suportado */
	if (!preg_match('/^image\/(jpeg|png|gif|pjpeg|jpg)$/', $file_name)) {
	copy($file,$caminho);
	}
} else {
	$file_name = $foto_facebook;
}
	$verifica_usuario = $con->query("SELECT * FROM users WHERE user_id = '".$user_id."'");
	$total  = $con->num_rows($verifica_usuario);
	

$caminho_layout = "images/previews/preview".$layout.".jpg";
$caminho_foto_causa = "images/causas/causa".$causa.".png";
if ($usar_foto != 'on') {
	$caminho_foto = "uploads/".$file_name;
} else {
	$caminho_foto = $foto_facebook."?type=large";
}
?>
<div id="cb_exemplo_aniversario" style="position: absolute; background-image: url(<?php echo $caminho_layout;?>); height: 286px; color: rgb(255, 255, 255); background-repeat: no-repeat; top: 116px; left: 37px; width: 583px;">
	<img src="<?php echo $caminho_foto_causa;?>" style="width: 130px; height: 155px; position: absolute; top: 81px; left: 15px; z-index: 9999;" />
	<div style="background-image: url(images/tela-3-monitor-foto-perfil.png); width: 130px; height: 155px; position: absolute; top: 29px; left: 131px;">
		<img src="<?php echo $caminho_foto;?>" style="position: absolute; top: 12px; left: 15px; -webkit-transform: rotate(3deg); -moz-transform: rotate(3deg); -o-transform:rotate(3deg); -ms-transform:rotate(3deg); filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1.5); width: 105px; height: 109px;" />
	</div>
	<div class="texto" style="margin-left: 295px; padding: 23px 0; width: 270px;">
		<h1 style="font-family: gabrielaregular; font-size: 28px; text-transform: uppercase;"><?php echo utf8_encode($campanha); ?></h1>
		<p style="font-family: Gotham-Bold; border-top: 1px solid rgba(255, 255, 255, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 7px; font-size: 10px;" class="usuario">por <?php echo utf8_encode(strtoupper($nome));?></p>
		<p style="font-family: gabrielaregular; font-size: 13px; margin-top: 5px;" class="descricao"><?php echo utf8_encode($descricao);?></p>
	</div>
</div>