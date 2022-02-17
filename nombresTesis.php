<?php

	include("m/funciones.php");

	$tipo =$_POST['nivelTesis'];
	$entidad =$_POST['entidadUNAM'];
	$anio =$_POST['anioTesis'];
	
	$nombresTesis = getTesisNombres($tipo, $entidad, $anio);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($nombresTesis as $s) {
?>
		<option value='<?= $s['Identificador'] ?>'><?= utf8_encode($s['Titulo']) ?></option>
<?php

	}
?>