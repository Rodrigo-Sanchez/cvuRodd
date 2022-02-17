<?php

	include("m/funciones.php");

	$uni =$_POST['universidad'];
	$niv =$_POST['nivel'];
	
	if($niv=="TÉCNICO SUPERIOR UNIVERSITARIO") {
		$cad = "T%";
	} else if($niv=="MAESTRÍA") {
		$cad = "MAE%";
	} else {
		$cad = $niv;
	}

	$programas = getProgramasTutoriasAmbos($uni, $cad);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($programas as $s) {
		

?>
		<option value='<?= utf8_encode($s['NombreCarrera']) ?>'><?= utf8_encode($s['NombreCarrera']) ?></option>
<?php


	}
?>
