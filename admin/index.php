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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
	$("#listaCampanhas").tablesorter(); 
});
</script>
<body id="homepage">
	<div id="header">
    	<a href="index.php" title=""><img src="images/cp_logo.png" alt="Control Panel" class="logo" /></a>
    </div><!-- Top Breadcrumb Start --> 
    <div id="rightside"><!-- Right Side/Main Content Start -->
		<!-- Alternative Content Box Start -->
         <div class="contentcontainer">
            <div class="headings">
                <h2>Lista de campanhas criadas</h2>
            </div>
            <div class="contentbox">
            	<table width="100%" id="listaCampanhas" class="tablesorter">
                	<thead>
                    	<tr>
                        	<th>ID</th>
                            <th>Nome no Facebook</th>
                            <th>Email</th>							
                            <th>Nome da campanha</th>						
                            <th>Tema</th>            
                            <th>Inicio da campanha</th>								
							<th>Status da Campanha</th>
							<th>Ultima intera&ccedil;&atilde;o</th>  
							<th colspan="2">A&ccedil;&otilde;es</th>  							
                        </tr>
                    </thead>
                    <tbody>
						<?php
							$sqlcampanhas = $con->query("SELECT * FROM users ORDER BY id");
							$ncampanhas = $con->num_rows($sqlcampanhas);
							if($ncampanhas<=0){

								echo "<h2>Nenhum campanha foi cadastrada</h2>";
								
							}else{
							while($cycampanhas = $con->fetch_object($sqlcampanhas)){
							if ($cycampanhas->causa == '1') {
								$causa = 'Um mundo sem fome.';
							}
							if ($cycampanhas->causa == '2') {
								$causa = 'Educação para todos.';
							}
							if ($cycampanhas->causa == '3') {
								$causa = 'Fim da violência contra as mulheres.';
							}
						?>
						<tr>
							<td><?php echo $cycampanhas->id;?></td>
						 	<td>
						 		<?php 
						 			echo $cycampanhas->nome;
						 		?>
						 	</td>
						 	<td>
						 		<?php 
						 			echo $cycampanhas->email;
						 		?>
						 	</td>							
						 	<td>
								<?php 
									echo utf8_encode($cycampanhas->campanha);
								?>
							</td>	
						 	<td>
								<?php 
									echo $causa;
								?>
							</td>	
						 	<td>
								<?php 
									echo $cycampanhas->data_inicio;
								?>
							</td>	                            
							<td>
								<?php 
									$data_inicial = date('d/m/Y',strtotime(date('Y-m-d'))); 
									$data_final = $cycampanhas->data_fim;
									$time_inicial = geraTimestamp($data_inicial);
									$time_final = geraTimestamp($data_final);
									$diferenca = $time_final - $time_inicial; 
									// Calcula a diferença de dias
									$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias	
									if ($dias > 0) {
										echo 'Em andamento';
									} else {
										echo 'Finalizada';
									}
								?>
							</td>
							
						 	<td>
								<?php 
									echo $cycampanhas->ultima_interacao;
								?>
							</td>
							<td>
								<a href="ver_campanha.php?id=<?php echo $cycampanhas->user_id?>">Ver campanha</a>
							</td>
							<td>
								<a href="export.php?id=<?php echo $cycampanhas->user_id?>">Gerar relatório</a>
							</td>							
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
