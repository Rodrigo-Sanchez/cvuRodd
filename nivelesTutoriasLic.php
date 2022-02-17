<?php

	include("m/funciones.php");

	$uni =$_POST['universidad'];

	$niveles = getNivelesByTutLic($uni);


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	
	foreach($niveles as $s) {
		
		if($s['Nivel'] != "TECNICO SUPERIOR" ) {
?>
		<option value='<?= utf8_encode($s['Nivel']) ?>'><?= utf8_encode($s['Nivel']) ?></option>
<?php

		}

	}
?>
