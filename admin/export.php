<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	include_once "config/connection.class.php";

	function ConsultaConfig($campo){
		global $con;

		$confSQL = $con->query("SELECT $campo FROM config");
		$conf = $con->fetch_object($confSQL);
		return $conf->$campo;
	}
	
	function bdToHtm($str) {
	   $str = str_replace('&amp;', '&', $str);
	   $str = str_replace('&#039;', '\'', $str);
	   $str = str_replace('&quot;', '"', $str);
	   $str = str_replace('&lt;', '<', $str);
	   $str = str_replace('&gt;', '>', $str);
	   //    $str = str_replace ( chr(10), "<BR/>", $str );
	   return $str;
	}

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"usuarios.xls\"");

$user_id = $_GET['id'];
/*$arquivo = 'usuarios.xls';

$html = '';
$html .= '<table>';
$html .= '<tr>';
$html .= '<td colspan="3">Lista de Usuários</tr>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td><b>Nome</b></td>';
$html .= '<td><b>Login</b></td>';
$html .= '<td><b>E-mail</b></td>';
$html .= '<td><b>RG</b></td>';
$html .= '<td><b>CPF</b></td>';
$html .= '<td><b>Telefone</b></td>';
$html .= '<td><b>Celular</b></td>';
$html .= '<td><b>Endereço</b></td>';
$html .= '<td><b>Complemento</b></td>';
$html .= '<td><b>Bairro</b></td>';
$html .= '<td><b>Cidade</b></td>';
$html .= '<td><b>Estado</b></td>';
$html .= '<td><b>CEP</b></td>';
$html .= '</tr>';
$sqloprf = $con->query("SELECT * FROM profile ORDER BY prf_nome");
$nprf = $con->num_rows($sqloprf);
while($cynprf = $con->fetch_object($sqloprf)){
	$html .= '<tr>';
	$html .= '<td>' .$cynprf->prf_nome.        '</td>';
	$html .= '<td>' .$cynprf->prf_login.       '</td>';
	$html .= '<td>' .$cynprf->prf_email.       '</td>';
	$html .= '<td>' .$cynprf->prf_rg.          '</td>'; 
	$html .= '<td>' .$cynprf->prf_cpf.         '</td>';  
	$html .= '<td>' .$cynprf->prf_telefone.    '</td>';  
	$html .= '<td>' .$cynprf->prf_celular.     '</td>';  
	$html .= '<td>' .$cynprf->prf_endereco.    '</td>';  	
	$html .= '<td>' .$cynprf->prf_complemento. '</td>';  	
	$html .= '<td>' .$cynprf->prf_bairro.      '</td>';  
	$html .= '<td>' .$cynprf->prf_cidade.      '</td>'; 
	$html .= '<td>' .$cynprf->prf_estado.      '</td>';  
	$html .= '<td>' .$cynprf->prf_cep.         '</td>';  			 							   	                                            
	$html .= '</tr>';
} 
$html .= '</table>';
echo $html;*/


$resultados = "";
$resultados = $resultados . "<html xmlns:x='urn:schemas-microsoft-com:office:excel'><head>";
$resultados = $resultados . "</head><body>";
$resultados = $resultados . "<table border='1'>";
$resultados = $resultados . "<colgroup>";
$resultados = $resultados . "<col align='center'>";
$resultados = $resultados . "<col align='center'>";
$resultados = $resultados . "<col align='center'>";
$resultados = $resultados . "<col align='center'>";
$resultados = $resultados . "</colgroup>";
$resultados = $resultados . "<tr>";
$resultados = $resultados . "<th x:autofilter='all'>Status</th>";
$resultados = $resultados . "<th x:autofilter='all'>end_date</th>";
$resultados = $resultados . "<th x:autofilter='all'>Record Type</th>";
$resultados = $resultados . "<th x:autofilter='all'>ccstatus</th>";
$resultados = $resultados . "<th x:autofilter='all'>Trans Type</th>";
$resultados = $resultados . "<th x:autofilter='all'>Department</th>";
$resultados = $resultados . "<th x:autofilter='all'>Holder Name</th>";
$resultados = $resultados . "<th x:autofilter='all'>usually</th>";
$resultados = $resultados . "<th x:autofilter='all'>Mes</th>";
$resultados = $resultados . "<th x:autofilter='all'>Entrada</th>";
$resultados = $resultados . "<th x:autofilter='all'>start pp</th>";
$resultados = $resultados . "<th x:autofilter='all'>start date</th>";
$resultados = $resultados . "<th x:autofilter='all'>Forenames</th>";
$resultados = $resultados . "<th x:autofilter='all'>Surname</th>";
$resultados = $resultados . "<th x:autofilter='all'>gender</th>";
$resultados = $resultados . "<th x:autofilter='all'>e-mail</th>";
$resultados = $resultados . "<th x:autofilter='all'>address1</th>";
$resultados = $resultados . "<th x:autofilter='all'>address2</th>";
$resultados = $resultados . "<th x:autofilter='all'>address3</th>";
$resultados = $resultados . "<th x:autofilter='all'>address4</th>";
$resultados = $resultados . "<th x:autofilter='all'>address5</th>";
$resultados = $resultados . "<th x:autofilter='all'>Postcode</th>";
$resultados = $resultados . "<th x:autofilter='all'>area phone code</th>";
$resultados = $resultados . "<th x:autofilter='all'>home phone</th>";
$resultados = $resultados . "<th x:autofilter='all'>work phone</th>";
$resultados = $resultados . "<th x:autofilter='all'>mobile phone</th>";
$resultados = $resultados . "<th x:autofilter='all'>data of birth</th>";
$resultados = $resultados . "<th x:autofilter='all'>profession</th>";
$resultados = $resultados . "<th x:autofilter='all'>CPF</th>";
$resultados = $resultados . "<th x:autofilter='all'>payment method</th>";
$resultados = $resultados . "<th x:autofilter='all'>product</th>";
$resultados = $resultados . "<th x:autofilter='all'>price</th>";
$resultados = $resultados . "<th x:autofilter='all'>frequency</th>";
$resultados = $resultados . "<th x:autofilter='all'>bank number</th>";
$resultados = $resultados . "<th x:autofilter='all'>bank agency name</th>";
$resultados = $resultados . "<th x:autofilter='all'>Bank agency number</th>";
$resultados = $resultados . "<th x:autofilter='all'>Account number</th>";
$resultados = $resultados . "<th x:autofilter='all'>creditcard</th>";
$resultados = $resultados . "<th x:autofilter='all'>ccnumber</th>";
$resultados = $resultados . "<th x:autofilter='all'>secrity code</th>";
$resultados = $resultados . "<th x:autofilter='all'>expiration date</th>";
$resultados = $resultados . "<th x:autofilter='all'>source codes</th>";
$resultados = $resultados . "<th x:autofilter='all'>preferred contact</th>";
$resultados = $resultados . "<th x:autofilter='all'>response channel</th>";
$resultados = $resultados . "<th x:autofilter='all'>Aut SMS</th>";
$resultados = $resultados . "<th x:autofilter='all'>transaction reference</th>";
$resultados = $resultados . "<th x:autofilter='all'>Nr Boleto</th>";
$resultados = $resultados . "<th x:autofilter='all'>Nome Titular</th>";
$resultados = $resultados . "<th x:autofilter='all'>Media</th>";
$resultados = $resultados . "<th x:autofilter='all'>Media_Outro</th>";
$resultados = $resultados . "<th x:autofilter='all'>Total</th>";
$resultados = $resultados . "<th x:autofilter='all'>Concluido</th>";
$resultados = $resultados . "<th x:autofilter='all'>PaisDoacao</th>";
$resultados = $resultados . "<th x:autofilter='all'>FTF CODE</th>";
$resultados = $resultados . "<th x:autofilter='all'>Cod_doador</th>";
$resultados = $resultados . "<th x:autofilter='all'>Jasou</th>";
$resultados = $resultados . "<th x:autofilter='all'>EMAILOK</th>";
$resultados = $resultados . "<th x:autofilter='all'>SMSOK</th>";
$resultados = $resultados . "</tr>";

$query = "";
$query = $query . " SELECT * ";
$query = $query . "   FROM users_payement ";
$query = $query . " WHERE user_id = '".$user_id."'";
$query = $query . " AND id_transacao IS NOT NULL";
$query = $query . " ORDER BY nome DESC LIMIT 0,1000";

$resultado = mysql_query($query);
$total_colunas     = mysql_num_rows($resultado);


if ($total_colunas != "0")
{
 for($i=0; $i<$total_colunas; $i++)
 {

   $status                = bdToHtm(mysql_result($resultado,$i,"status"));
   $end_date_ini          = bdToHtm(mysql_result($resultado,$i,"created"));
   $holder_name           = bdToHtm(mysql_result($resultado,$i,"nome"));
   $usually               = bdToHtm(mysql_result($resultado,$i,"usually"));   
   $forename              = bdToHtm(mysql_result($resultado,$i,"forename"));
   $surname               = bdToHtm(mysql_result($resultado,$i,"surname"));
   $email                 = bdToHtm(mysql_result($resultado,$i,"email"));   
   $address1              = bdToHtm(mysql_result($resultado,$i,"endereco"));  
   $numero                = bdToHtm(mysql_result($resultado,$i,"numero"));         
   $complemento           = bdToHtm(mysql_result($resultado,$i,"complemento"));
   $cidade                = bdToHtm(mysql_result($resultado,$i,"cidade"));
   $estado                = bdToHtm(mysql_result($resultado,$i,"estado")); 
   $postcode              = bdToHtm(mysql_result($resultado,$i,"cep"));
   $home_phone            = bdToHtm(mysql_result($resultado,$i,"telefone"));     
   $mobile_phone          = bdToHtm(mysql_result($resultado,$i,"celular"));   
   $payment_method        = bdToHtm(mysql_result($resultado,$i,"forma_pagamento"));  
   $price                 = bdToHtm(mysql_result($resultado,$i,"valor_doacao"));     
   $bank_number           = bdToHtm(mysql_result($resultado,$i,"numero_banco"));  
   $creditcard            = bdToHtm(mysql_result($resultado,$i,"bandeira")); 
   $emailok_ini           = bdToHtm(mysql_result($resultado,$i,"newsletter_email")); 
   $smsok_ini             = bdToHtm(mysql_result($resultado,$i,"newsletter_celular"));    
   
   $end_date_array        = explode('-', $end_date_ini);
   $dia                   = strstr($end_date_array[2], ' ', true);
   $end_date              = $dia.'/'.$end_date_array[1].'/2114';
   $entrada               = $dia.'/'.$end_date_array[1].'/'.$end_date_array[0];
   $start_date            = $entrada;
   
   $address2              = $numero.' '.$complemento;
   $address4              = $cidade.' - '.$estado; 

   $total                 = $price;
   
   if ($emailok_ini == 'Sim') {
	$emailok              = 'Y'; 
   } else {
	$emailok              = '';    
   }
   
   if ($smsok_ini == 'Sim') {
	$smsok                = 'Y'; 
   } else {
	$smsok                = '';    
   }   
   
   $resultados = $resultados . "<tr>";
   $resultados = $resultados . "<td>" . $status                . "</td>";
   $resultados = $resultados . "<td>" . $end_date              . "</td>";
   $resultados = $resultados . "<td>    INDIVIDUAL                </td>";      
   $resultados = $resultados . "<td>                              </td>";
   $resultados = $resultados . "<td>    DON_ONEOFF                </td>";
   $resultados = $resultados . "<td>    FUND                      </td>";
   $resultados = $resultados . "<td>" . $holder_name           . "</td>";
   $resultados = $resultados . "<td>" . $usually               . "</td>";
   $resultados = $resultados . "<td>                              </td>";   
   $resultados = $resultados . "<td>" . $entrada               . "</td>";
   $resultados = $resultados . "<td>                              </td>";   
   $resultados = $resultados . "<td>" . $start_date            . "</td>";
   $resultados = $resultados . "<td>" . $forename              . "</td>";
   $resultados = $resultados . "<td>" . $surname               . "</td>";  
   $resultados = $resultados . "<td>                              </td>";     
   $resultados = $resultados . "<td>" . $email                 . "</td>";  
   $resultados = $resultados . "<td>" . $address1              . "</td>";   
   $resultados = $resultados . "<td>" . $address2              . "</td>";   
   $resultados = $resultados . "<td>    .                         </td>";   
   $resultados = $resultados . "<td>" . $address4              . "</td>";    
   $resultados = $resultados . "<td>" . $postcode              . "</td>";  
   $resultados = $resultados . "<td>                              </td>";     
   $resultados = $resultados . "<td>" . $home_phone            . "</td>";  
   $resultados = $resultados . "<td>                              </td>";     
   $resultados = $resultados . "<td>" . $mobile_phone          . "</td>";   
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>                              </td>";    
   $resultados = $resultados . "<td>                              </td>";       
   $resultados = $resultados . "<td>" . $payment_method        . "</td>"; 
   $resultados = $resultados . "<td>    Single Gift               </td>"; 
   $resultados = $resultados . "<td>" . $price                 . "</td>"; 
   $resultados = $resultados . "<td>    1                         </td>"; 
   $resultados = $resultados . "<td>" . $bank_number           . "</td>";    
   $resultados = $resultados . "<td>                              </td>";   
   $resultados = $resultados . "<td>                              </td>"; 
   $resultados = $resultados . "<td>                              </td>";    
   $resultados = $resultados . "<td>" . $creditcard            . "</td>";  
   $resultados = $resultados . "<td>                              </td>";   
   $resultados = $resultados . "<td>                              </td>"; 
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>    SG14VGI                   </td>";  
   $resultados = $resultados . "<td>    PHONE                     </td>";  
   $resultados = $resultados . "<td>    OUTCALL                   </td>";  
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>    VG                        </td>";
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>" . $total                 . "</td>";  
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>    0                         </td>"; 
   $resultados = $resultados . "<td>                              </td>";  
   $resultados = $resultados . "<td>                              </td>";   
   $resultados = $resultados . "<td>" . $emailok               . "</td>";    
   $resultados = $resultados . "<td>" . $smsok                 . "</td>";     
   $resultados = $resultados . "</tr>";
 }
}

$resultados = $resultados . "</table>";
$resultados = $resultados . "</body>";
$resultados = $resultados . "</html>";
echo $resultados;
?>