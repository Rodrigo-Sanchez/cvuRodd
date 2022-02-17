<?php

	include("m/funciones.php");

	$anio =$_POST['anioReporte'];
	
	$entidades = getEntidadesReportesByAnio($anio);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($entidades as $s) {
?>
		<option value='<?= utf8_encode($s['CodigoEntidadSolicita']) ?>'><?= utf8_encode($s['EntidadSolicita']) ?></option>
<?php

	}
?>


