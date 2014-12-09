<?php
session_start();
setlocale (LC_ALL, 'pt_BR');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$DBHOST     = "localhost";
$DBUSER     = "agenciaf_color";
$DBPASSWORD = "C0ncr3t3";
$DBNAME     = "agenciaf_colorama_look";

$_SESSION["PREFIXO"] = "look_";
?>