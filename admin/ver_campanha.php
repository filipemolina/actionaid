<?php
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');

session_start();

if(!isset($_SESSION['admin_logado'])){
	
	header("Location: login.php");
	exit();	

}

include_once "config/connection.class.php";

function geraTimestamp($data) {
$partes = explode('/', $data);
return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}

$user_id = $_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel de Controle - Act!onAid</title>
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/blue/styles.css" rel="stylesheet" type="text/css" />
<link href="css/wysiwyg.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/uploadify.css" />
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="css/tablesorter/style.css" />

<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
</head>

<body>
<script type="text/javascript">
$(document).ready(function(){
	$("#listaDoadores").tablesorter(); 
});
</script>
<body id="homepage">
	<div id="header">
    	<a href="index.php" title=""><img src="images/cp_logo.png" alt="Control Panel" class="logo" /></a>
    </div><!-- Top Breadcrumb Start -->
	<?php 
		$sqlcampanha = $con->query("SELECT * FROM users WHERE user_id = '".$user_id."'");
		$campanha = $con->fetch_object($sqlcampanha);	
	
	?>
    <div id="rightside"><!-- Right Side/Main Content Start -->
		<!-- Alternative Content Box Start -->
         <div class="contentcontainer">
            <div class="headings" style="text-align: center;">
			<?php
				$select_apoiadores = $con->query("SELECT * FROM users_payement WHERE user_id = '".$user_id."' AND id_transacao IS NOT NULL AND status='Pago' ");
				$apoiadores = $con->num_rows($select_apoiadores);

				$valor_arrecadado = $con->query("SELECT SUM(valor_doacao) AS total FROM users_payement WHERE user_id = '".$user_id."' AND id_transacao IS NOT NULL AND status='Pago'");
				$doacao = $con->fetch_object($valor_arrecadado);

				$data_hoje = date('d/m/Y',strtotime(date('Y-m-d'))); 
				$data_inicial =   $campanha->data_inicio;
				$data_final   =   $campanha->data_fim;
				
				$time_hoje = geraTimestamp($data_hoje);
				$time_inicial = geraTimestamp($data_inicial);
				$time_final = geraTimestamp($data_final);
				if ($time_inicial > $time_hoje) {
					$diferenca = $time_final - $time_inicial; 
				} else {
					$diferenca = $time_final - $time_hoje;
				}
				// Calcula a diferença de dias
				$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias				
			?>
                <h2><?php echo $campanha->nome; ?> - Campanha <?php echo $campanha->campanha;?></h2>
            </div>
			<div class="informacao" style="background-color: rgb(242, 242, 242); width: 100%;">
				<div style="margin: 0px auto; width: 25%; float: left; text-align: center; padding: 15px 0px;">
					<b style="color: rgb(223, 10, 36); top: 10%; font-size: 35px;"><?php echo $apoiadores; ?></b>
					<p style="font-size: 22px;">N&uacute;mero de apoiadores</p>				
				</div>
				<div style="margin: 0px auto; width: 25%; float: left; text-align: center; padding: 15px 0px;">
					<b style="color: rgb(223, 10, 36); top: 10%; font-size: 35px;"><?php echo 'R$ ' . number_format($campanha->valor_arrecadado, 2, ',', '.'); ?></b>
					<p style="font-size: 22px;">Meta da campanha </p>
				</div>
				<div style="margin: 0px auto; width: 25%; float: left; text-align: center; padding: 15px 0px;">
					<b style="color: rgb(223, 10, 36); top: 10%; font-size: 35px;"><?php echo 'R$ ' . number_format($doacao->total, 2, ',', '.'); ?></b>
					<p style="font-size: 22px;">Valor total arrecadado </p>
				</div>
				<div style="margin: 0px auto; width: 25%; float: left; text-align: center; padding: 15px 0px;">
					<b style="color: rgb(223, 10, 36); top: 10%; font-size: 35px;"><?php echo $dias; ?> dias</b>
					<p style="font-size: 22px;">Dias restantes </p>
				</div>
			</div>			
            <div class="contentbox">
            	<table width="100%" id="listaDoadores" class="tablesorter">
                	<thead>
					
						<?php
						$sqldoadores = $con->query("SELECT * FROM users_payement WHERE user_id = '".$user_id."' AND id_transacao IS NOT NULL");
						$ndoadores = $con->num_rows($sqldoadores);
						if($ndoadores>0){ ?>
                    	<tr>
                        	<th>ID</th>
                        	<th>ID da transa&ccedil;&atilde;o</th>	
							<th>C&oacute;digo da transa&ccedil;&atilde;o</th>	
							<th>Status</th>							
                            <th>Nome</th>
                            <th>Email</th>
							<th>CEP</th>
							<th>Endere&ccedil;o</th>  
							<th>N&uacute;mero</th> 
							<th>Complemento</th> 
							<th>Bairro</th>  
							<th>Cidade</th> 
							<th>Estado</th> 
							<th>Telefone</th> 
							<th>Celular</th>
							<th>Valor</th>
							<th>Criado em:</th>    							
                        </tr>
						<?php }?>
                    </thead>
                    <tbody>
						<?php
							if($ndoadores<=0){

								echo "<h2>Nenhum doador at&eacute; o momento</h2>";
								
							}else{
							while($cydoadores = $con->fetch_object($sqldoadores)){
						?>
						<tr>
							<td><?php echo $cydoadores->id;?></td>
							<td><?php echo $cydoadores->id_transacao;?></td>
							<td><?php echo $cydoadores->cod_transacao;?></td>
							<td><?php echo $cydoadores->status;?></td>							
							<td><?php echo $cydoadores->nome;?></td>
							<td><?php echo $cydoadores->email;?></td>							
							<td><?php echo $cydoadores->cep;?></td>	
							<td><?php echo $cydoadores->endereco;?></td>
							<td><?php echo $cydoadores->numero;?></td>
							<td><?php echo $cydoadores->complemento;?></td>
							<td><?php echo $cydoadores->bairro;?></td>
							<td><?php echo $cydoadores->cidade;?></td>
							<td><?php echo $cydoadores->estado;?></td>
							<td><?php echo $cydoadores->telefone;?></td>
							<td><?php echo $cydoadores->celular;?></td>
							<td><?php echo 'R$ ' . number_format($cydoadores->valor_doacao, 2, ',', '.');?></td>
							<td><?php echo $cydoadores->created;?></td>							
						</tr>
						<?php }}?>

					</tbody>
                </table>
                   
                <div class="clear"></div>
            </div>
        </div>
        <!-- Alternative Content Box End -->  
        <div id="footer">
        	&copy; Copyright <?php echo date("d/m/Y");?> <a href="http://www.doeumfuturodepresente.org.br" target="_blank">Act!onAid</a>
        </div> 
          
    </div><!-- Right Side/Main Content End -->
    
	

  
    
	<script type="text/javascript" src="http://dwpe.googlecode.com/svn/trunk/_shared/EnhanceJS/enhance.js"></script>	
	<script type="text/javascript" src="http://dwpe.googlecode.com/svn/trunk/charting/js/excanvas.js"></script>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>-->
	<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="js/visualize.jQuery.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script> 	
	<script type="text/javascript" src="js/functions.js"></script>

    <!--[if IE 6]>
    <script type='text/javascript' src='scripts/png_fix.js'></script>
    <script type='text/javascript'>
      DD_belatedPNG.fix('img, .notifycount, .selected');
    </script>
    <![endif]--> 
	
</body>
</html>
