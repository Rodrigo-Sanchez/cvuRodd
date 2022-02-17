<?php

	include("m/funciones.php");

	$uni =$_POST['universidad'];
	$niv =$_POST['nivel'];
	
	if($niv=="MAESTRÍA") {
		$cad = "MAE%";
	} else {
		$cad = $niv;
	}

	$programas = getProgramasTutoriasPos($uni, $cad);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($programas as $s) {
		

?>
		<option value='<?= utf8_encode($s['NombreCarrera']) ?>'><?= utf8_encode($s['NombreCarrera']) ?></option>
<?php


	}
?>
