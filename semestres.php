<?php

	include("m/funciones.php");

	$entidad =$_POST['entidadUNAM'];
	$semestres = getSemestresByEntidad($entidad);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($semestres as $s) {
?>
		<option value='<?= $s['PeriodoImparte'] ?>'><?= $s['PeriodoImparte'] ?></option>
<?php

	}
?>


