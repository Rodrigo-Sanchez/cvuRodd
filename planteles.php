<?php

	include("m/funciones.php");

	$universidad =$_POST['universidad'];
	$planteles = getPlantelesSIES($universidad);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($planteles as $s) {
		
		if(utf8_encode($s['NombrePlantel']) != 'CENTRO DE CIENCIAS GENOMICAS DE LA UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO') {
		
?>
		<option value='<?= utf8_encode($s['NombrePlantel']) ?>'><?= utf8_encode($s['NombrePlantel']) ?></option>
<?php

		}

	}
?>


