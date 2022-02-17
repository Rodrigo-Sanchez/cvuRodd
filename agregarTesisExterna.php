<?php

	include("m/funciones.php");
	
	$nt = $_POST["numeroEmpleado"];
	$autor = $_POST["autores"];
	$titulo = $_POST["titulo"];
	$anio = $_POST["anio"];
	$url = $_POST["url"];
	$calidad = $_POST["calidad"];
	
	
	//LO DEL SIES
	$universidad = $_POST["tags"];
	$plantel = $_POST["plantel"];
	$nivel = $_POST["niveles"];
	$carrera = $_POST["carrera"];
	
	if($nivel=="TSU") {
		$cadena = "TEC";
	} else if($nivel=="MAESTRIA") {
		$cadena = "MAE";
	} else {
		$cadena = $nivel;
	}
	
	//Obtener códigos
	$datos = getCodigosSIES($universidad, $plantel, $cadena, $carrera);
	$c1 = $datos[0]['CodigoDgei'];
	$c2 = $datos[0]['ClaveInstitucion'];
	$c3 = $datos[0]['ClavePlantel'];
	$c4 = $datos[0]['CodigoCarrera'];	
	
	$fecha = date("Y-m-d h:m:s");
	
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 1; $i <= 35; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
	
	$rol="Director";
	$obs="Tesis Otra Inst.";
	$entidad="Externa";
	$estado=0;
	$idSIIA=0;
	insertNuevaTesisExterna($nt, $randomString, $titulo, $nivel, $rol, $entidad, $url, $obs, $autor, $anio, $fecha, $estado, $idSIIA, $c1, $c2, $c3, $c4);
		

?>

<li>
	Universidad:<?= $universidad ?>, Título: <?= $titulo ?>, Autor(es):<?= $autor ?>, Año: <?=  $anio ?>						
</li>
