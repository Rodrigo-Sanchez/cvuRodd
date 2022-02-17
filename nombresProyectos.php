<?php

	include("m/funciones.php");
	
	$c =$_POST['convocatoria'];
	$a =$_POST['area'];
	
	$proyectos = getProyectosByConvArea($c, $a);

?>	

	<option value='0'>Seleccionar</option>
	
	
<?php	
	foreach($proyectos as $s) {
?>
		<option value='<?= utf8_encode($s['Identificador']) ?>'><?= utf8_encode($s['Nombre']) ?></option>
<?php

	}
?>