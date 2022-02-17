<?php

	include("m/funciones.php");
	
	$c =$_POST['convocatoria'];
	
	$areas = getAreasByConv($c);

?>	

	<option value='0'>Seleccionar</option>
	
	
<?php	
	foreach($areas as $s) {
?>
		<option value='<?= utf8_encode($s['CodigoArea']) ?>'><?= utf8_encode($s['Area']) ?></option>
<?php

	}
?>