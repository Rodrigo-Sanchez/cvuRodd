<?php

	include("m/funciones.php");

	$universidad =$_POST['universidad'];
	$planteles = getNivelesUNAM($universidad);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($planteles as $s) {
		
		
		
?>
		<option value='<?= utf8_encode($s['Nivel']) ?>'><?= utf8_encode($s['Nivel']) ?></option>
<?php


	}
?>


