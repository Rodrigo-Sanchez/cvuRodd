<?php

	include("m/funciones.php");

	$uni =$_POST['universidad'];
	$nivel =$_POST['nivel'];
	
	if($nivel==1) {
		$cadena = "T%";
	} else if($nivel==2) {
		$cadena = "LICENCIA PRO";
	} else if($nivel==3) {
		$cadena = "LICENCIATURA%";
	} else if($nivel==4) {
		$cadena = "ESPE%";
	} else if($nivel==5) {
		$cadena = "MAE%";
	} else if($nivel==6) {
		$cadena = "DOC%";
	} 
	
	$carreras = getCarrerasByInstNivel($uni, $cadena);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($carreras as $s) {
?>
		<option value='<?= utf8_encode($s['NombreCarrera']) ?>'><?= utf8_encode($s['NombreCarrera']) ?></option>
<?php

	}
?>


