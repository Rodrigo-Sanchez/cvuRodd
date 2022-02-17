<?php

	include("m/funciones.php");
	
	$nt = $_POST["numeroEmpleado"];
	
	
	//Revisar si ya quiso agregar esa publicación antes
	$publicacionesQuiereAgregar = getSolicitudesAltaTesis($nt);
	$pqa = array();
	foreach($publicacionesQuiereAgregar as $p) {
		$pqa[] = $p['idTesisSIIA'];
	}

	$id = $_POST['tesis'];
	
	$c = "El academico quiere agregar una tesis SIIA en calidad de Asesor";
		

	if(in_array($id, $pqa)==false) {
			
		//Agregar a la base
		$fecha = date("Y-m-d h:m:s");
		requestAgregarTesis($nt, $id, $fecha, $c);
	
	}
	
	//Detalles de la tesis
	$datos = getInfoTesisById($id);

?>

<li><?= utf8_encode($datos[0]['Titulo']) ?>, <a href="<?= $datos[0]['Url'] ?>" target="_blank" >Ver detalles </a></li>