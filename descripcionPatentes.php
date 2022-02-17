<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		
		<style>
			body {
				font-size:12px;
				
			}
		
		</style>
		
	</head>
	
	<body>
	
		<?php
			
			include("m/funciones.php");
			
			$id=$_GET['id'];
			$resultado = getDetallesPatentesSolByNum($id);
		
		?>
	
		<div class="row" style="background-color:#C0C0C0;" >
			<div class="col-sm-6" ></div>
			<div class="col-sm-6" ><img style="float:right;" src="imagenes/LOGOimpi.png" width="200px" /></div>
			
		</div>
		
		<h4 style="padding-left:30px;padding-right:30px; color:#007B2E;"><center><?= utf8_encode($resultado[0]['Titulo']) ?></center></h4>
		<hr>
	
		<br>
		<p style="padding-left:30px;padding-right:30px;"><b>Autores </b></p>
		<p style="padding-left:30px;padding-right:30px;"><?= utf8_encode($resultado[0]['Inventores']) ?></p>
		
		<br>
		<p style="padding-left:30px;padding-right:30px;"><b>Resumen </b></p>
		<p style="text-align:justify; padding-left:30px;padding-right:30px;"><?= utf8_encode($resultado[0]['Resumen']) ?></p>
	
		<div class="row" style="margin-bottom:20px;">
			<img style="padding-left:30px;padding-right:30px;" src="imagenes/foco.png" />
			<span><b>Número de solicitud:</b> <?= $resultado[0]['NumeroSolicitud'] ?>
			</span>
			
			
		</div>
	
	
	</body>
	
	
</html>	