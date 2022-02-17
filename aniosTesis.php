<?php

	include("m/funciones.php");

	$tipo =$_POST['nivelTesis'];
	$entidad =$_POST['entidadUNAM'];
	$anios = getAniosTesis($entidad, $tipo);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($anios as $s) {
?>
		<option value='<?= $s['anio'] ?>'><?= $s['anio'] ?></option>
<?php

	}
?>