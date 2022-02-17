<?php

	include("m/funciones.php");

	$planteles = getPlantelesBachillerato();


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($planteles as $s) {
		
		
?>
		<option value='<?= utf8_encode($s['Codigo']) ?>'><?= utf8_encode($s['Nombre']) ?></option>
<?php


	}
?>
