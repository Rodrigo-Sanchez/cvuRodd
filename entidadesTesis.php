<?php

	include("m/funciones.php");

	$tipo =$_POST['nivelTesis'];
	$entidades = getEntidadByTipoTesis($tipo);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($entidades as $s) {
?>
		<option value='<?= $s['CodigoInstitucion'] ?>'><?= utf8_encode($s['Institucion']) ?></option>
<?php

	}
?>