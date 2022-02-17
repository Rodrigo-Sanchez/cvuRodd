<?php

	include("m/funciones.php");

	$uni = $_POST['universidad'];
	$plantel = $_POST['plantel'];
	$niveles = getNivelesSIES($uni, utf8_decode($plantel));


?>	
	
	<option value='0'>Seleccionar</option>
	
<?php	

	$contador1=0;
	$contador2=0;
	
	foreach($niveles as $s) {
		
		if( (utf8_encode($s['Nivel'])=="MAESTRÍA" || $s['Nivel']=="MAESTRIA") && $contador1==0 ) {
			
			$contador1++;
			
?>
			<option value='MAESTRIA'> MAESTRÍA </option>
<?php

		} else if ( (utf8_encode($s['Nivel'])=="TÉCNICO SUPERIOR UNIVERSITARIO" || $s['Nivel']=="TECNICO SUPERIOR") && $contador2==0) {  
		
			$contador2++;
?>


			<option value='TSU'> TÉCNICO SUPERIOR UNIVERSITARIO </option>

<?php

		} else { 
			
			if( utf8_encode($s['Nivel'])!="MAESTRÍA" && $s['Nivel']!="MAESTRIA" && utf8_encode($s['Nivel'])!="TÉCNICO SUPERIOR UNIVERSITARIO" && $s['Nivel']!="TECNICO SUPERIOR") {
				?>
				
			<option value="<?= $s['Nivel'] ?>"><?= utf8_encode($s['Nivel']) ?></option>
<?php			
			}

		}

	}
	
	
?>


