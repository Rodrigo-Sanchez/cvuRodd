<?php

	include("m/funciones.php");

	$nt = $_POST['nt'];
	$issn = $_POST['issn'];
	$titulo = $_POST['titulo'];
	$eid = $_POST['eID'];
	$firma = $_POST['firma'];
	$wos = $_POST['wosID'];
	$scopus = $_POST['scopusID'];

	$fecha = date("Y-m-d h:m:s");
	
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 1; $i <= 35; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
	
	insertNuevaPublicacion($nt, $firma, $randomString, $titulo, $issn, $eid, $wos, $fecha);


?>

<li><?= utf8_encode($titulo) ?> </li>