<?php

	include("m/funciones.php");

	$nt = $_POST['nt'];
	$entidad = $_POST['entUNAM'];
	$nivel = $_POST['nivelTesisNueva'];
	$autor = $_POST['autor'];
	$url = $_POST['url'];
	$titulo = $_POST['tituloTesis'];
	$f_examen = $_POST['anioExamen'];
	

	$fecha = date("Y-m-d h:m:s");
	
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 1; $i <= 35; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
	
	$rol="Asesor";
	$obs="Tesis no SIIA";
	$estado=0;
	$idSIIA=0;
	insertNuevaTesis($nt, $randomString, $titulo, $nivel, $rol, $entidad, $url, $obs, $autor, $f_examen, $fecha, $estado, $idSIIA);


?>

<li>
	Título: <?= $titulo ?>, Autor(es):<?= $autor ?>						
</li>