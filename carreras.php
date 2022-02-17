<?php

	include("m/funciones.php");

	$uni =$_POST['universidad'];
	$plantel =$_POST['plantel'];
	$nivel =$_POST['nivel'];
	
	
	if($nivel=="MAESTRIA") {
		$cadena = "MAE";
	} else if($nivel=="TSU") {
		$cadena = "TEC";
	} else {
		$cadena = $nivel;
	}
	
	
	$carreras = getCarrerasSIES($uni, $plantel, $cadena);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($carreras as $s) {
?>
		<option value='<?= utf8_encode($s['NombreCarrera']) ?>'><?= utf8_encode($s['NombreCarrera']) ?></option>
<?php

	}
?>


