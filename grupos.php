<?php

	include("m/funciones.php");

	$entidad =$_POST['idEntidad'];
	$semestre =$_POST['semestre'];
	$asignatura =$_POST['asignatura'];
	
	$grupos = getGrupos($entidad, $semestre, $asignatura);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($grupos as $s) {
?>
		<option  value='<?= $s['CodigoGrupo'] ?>'><?= $s['CodigoGrupo'] ?></option>
<?php

	}
?>