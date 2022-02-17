<?php

	include("m/funciones.php");

	$institucion =$_POST['institucion'];
	$deps = getDependenciasSS($institucion);

?>		
	<option value='0'>Seleccionar</option>	
<?php	
	foreach($deps as $s) {
?>
		<option value='<?= $s['Depedencia'] ?>'><?= utf8_encode($s['Depedencia']) ?></option>
<?php
	}
?>
	<option value="9">Otra</option>
