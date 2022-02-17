<?php

	include("m/funciones.php");

	$entidad =$_POST['idEntidad'];
	$semestre =$_POST['semestre'];
	$asignaturas = getAsignaturasEspeciales($entidad, $semestre);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($asignaturas as $s) {
?>
		<option  value='<?=  utf8_encode($s['Asignatura']) ?>'><?= utf8_encode($s['Asignatura']) ?></option>
<?php

	}
?>