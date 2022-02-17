<?php

	include("m/funciones.php");

	$universidad =$_POST['universidad'];
	$nivel =$_POST['nivel'];
	$carreras = getCarrerasUNAM($universidad, $nivel);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($carreras as $s) {
		
		
		
?>
		<option value='<?= utf8_encode($s['NombreCarrera']) ?>'><?= utf8_encode($s['NombreCarrera']) ?></option>
<?php


	}
?>
