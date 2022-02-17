<?php

	include("m/funciones.php");

	$universidad =$_POST['entidad'];
	$anios = getAniosPlantelesBYEntidad($universidad);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($anios as $s) {
			
?>
		<option value='<?= utf8_encode($s['anio']) ?>'><?= utf8_encode($s['anio']) ?></option>
<?php

	}
?>


