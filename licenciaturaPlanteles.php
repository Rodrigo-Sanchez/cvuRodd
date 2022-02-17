<?php

	include("m/funciones.php");

	$planteles = getEntidadesDGEI();


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($planteles as $s) {
		
		
?>
		<option value='<?= utf8_encode($s['NombreInstitucion']) ?>'><?= utf8_encode($s['NombreInstitucion']) ?></option>
<?php


	}
?>
