<?
function openDBConn()
{
	global $DBNAME, $DBHOST, $DBUSER, $DBPASSWORD;
	$conexao = mysqli_connect('br254.hostgator.com.br', 'doeum083_admin', 'G1020304050', 'doeum083_app');
	//mysql_select_db($DBNAME, $conexao) or die("Erro na escolha da tabela!");
}

function closeDBConn()
{
	unset($conexao);
}

openDBConn();
echo $DBHOST;
?>