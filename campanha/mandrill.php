<?php

require_once('../vendor/Email.php');
require_once("../config/connection.class.php");

$cod_transacao = "8G7CMU";

$query = $con->query("SELECT users.causa FROM users, users_payement WHERE users.user_id = users_payement.user_id AND users_payement.cod_transacao = '$cod_transacao';");

$resultado = $con->fetch_object($query);
echo "<pre>";
print_r($resultado->causa);