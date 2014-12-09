<?php
session_start();

include "connection.class.php";

extract($_POST);

$loginsql = $con->query("SELECT * FROM users_admin WHERE user_login = '$user' AND user_pass= '$passwd'");
$rowslogin = $con->fetch_object($loginsql);

$resultado = $con->num_rows($loginsql);

if($resultado <= 0){
	echo 'nao foi';
} else {

	$admin_logado = $user;
	$tipo = "admin";
	$id = $rowslogin->id;

	$_SESSION['admin_logado'] = $admin_logado;
	$_SESSION['id'] = $id;
	$_SESSION['tipo'] = $tipo;
	echo 'logado';
	echo "<script language='javascript' type='text/javascript'>window.location.href='../index.php';</script>";	
}
?>
