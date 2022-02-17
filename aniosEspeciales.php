<?php

	include("m/funciones.php");

	$entidad =$_POST['entidadUNAM'];
	$semestres = getAniosEspecialesByEntidad($entidad);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($semestres as $s) {
?>
		<option value='<?= $s['anio'] ?>'><?= $s['anio'] ?></option>
<?php

	}
?>