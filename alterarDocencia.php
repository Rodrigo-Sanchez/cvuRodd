<?php

	include("m/funciones.php");
	
	$nt = $_POST['nt'];
	$totales = $_POST['contador'];
	$fecha = date("Y-m-d h:m:s");
	
	$i=1;
	while($i < $totales) {
		
		$np = $_POST['ids_'.$i];
		$pub = explode("-",$np);
		$num_p = $pub[0];
		$opcion = $pub[1];
		
		if($opcion==1) {
			confirmarDocencia($nt, $num_p ,$fecha);
		} else {
			desvinculacionDocencia($nt, $num_p, $fecha);
		}
	
		$i++;
	}
	
	limpiaTablaDocencia();
	limpiaTablaDocencia2();



?>