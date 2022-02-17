<?php

	include("m/funciones.php");

	$anio =$_POST['anio'];
	$entidad =$_POST['entidad'];
	
	$titulos = getTitulosReportesByAnioEntidad($anio, $entidad);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($titulos as $s) {
?>
		<option value='<?= utf8_encode($s['Identificador']) ?>'><?= utf8_encode($s['Titulo']) ?></option>
<?php

	}
?>