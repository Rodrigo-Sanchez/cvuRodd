<?php

	include("m/funciones.php");

	$uni =$_POST['entidad'];
	$anio =$_POST['anio'];
	
	$titulosPatentes = getTitulosPatentesSolByUniAnio($uni, $anio);

?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($titulosPatentes as $s) {
?>
		<option value='<?= $s['Titulo'] ?>'><?= utf8_encode($s['Titulo']) ?></option>
<?php

	}
?>