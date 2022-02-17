<?php

	include("m/funciones.php");

	$institucion =$_POST['institucion'];
	$dependencia =$_POST['dependencia'];
	$deps = getProgramasSS($institucion, $dependencia);

?>	
	<option value='0'>Seleccionar</option>
<?php	
	foreach($deps as $s) {
?>
		<option value='<?= $s['ClavePrograma'] ?>'><?= utf8_encode($s['NombrePrograma']) ?></option>
<?php
	}
?>
	<option value="9">Otra</option>