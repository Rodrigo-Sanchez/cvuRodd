<?php

	include("m/funciones.php");

	$uni =$_POST['universidad'];

	$niveles = getNivelesByTutAmbos($uni);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($niveles as $s) {
		
		if($s['Nivel'] != "TECNICO SUPERIOR" && $s['Nivel'] != "MAESTRIA" ) {
?>
		<option value='<?= utf8_encode($s['Nivel']) ?>'><?= utf8_encode($s['Nivel']) ?></option>
<?php

		}

	}
?>