<?php

/*
 ************************************************************************
 PagSeguro Config File
 ************************************************************************
 */

$PagSeguroConfig = array();

//$PagSeguroConfig['environment'] = array();
$PagSeguroConfig['environment'] = "production"; // production, sandbox

$PagSeguroConfig['credentials'] = array();
$PagSeguroConfig['credentials']['email'] = "it.brazil@actionaid.org";
$PagSeguroConfig['credentials']['token']['production'] = "82B972E35FEA48FC9FEED31767645298";
$PagSeguroConfig['credentials']['token']['sandbox'] = "your_sandbox_pagseguro_token";

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = false;
$PagSeguroConfig['log']['fileLocation'] = "";
