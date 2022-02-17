<?php

	include("m/funciones.php");
	
	
	$nt = $_POST["nt"];
	$entidad = $_POST["idEntidad"];
	$semestre = $_POST["sem"];
	$materia = $_POST["curso"];
	$grupo = $_POST["gru"];
	
	
	//Obtener identificador del grupo 
	$res = getInfoDocenciaByDatos($entidad, $semestre, $materia, $grupo);
	$id =  $res[0]['CodigoAsignatura'];
	
	
	
			
		//Agregar a la base
		$fecha = date("Y-m-d h:m:s");		
		requestAgregarDocencia($nt, $id, $fecha, $semestre); ?>
		
		<li><?= utf8_encode($res[0]['Entidad']) ?>, <?= ($res[0]['CodigoAsignatura']) ?> - <?= utf8_encode($res[0]['Asignatura']) ?>, Grupo: <?= $res[0]['CodigoGrupo'] ?>, <?= $res[0]['PeriodoImparte'] ?>
		
