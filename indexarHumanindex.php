<?php

	include("m/funciones.php");

	$id_Pub = $_POST['bookId'];
	$nt = $_POST['numT'];
	$wos = $_POST['wosid'];
	$scopus = $_POST['scopusid'];
	$firma = $_POST['firma'];
	
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 1; $i <= 35; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
	
	
	$fecha = date("Y-m-d h:m:s");
	
	/*echo $nt;
	echo "<br>";
	echo $firma;
	echo "<br>";
	echo $randomString;
	echo "<br>";
	echo $id_Pub;
	echo "<br>";
	echo $scopus;
	echo "<br>";
	echo $wos;
	echo "<br>";
	echo $fecha;
	echo "<br>";*/
	
	ligarPubHumanindex($nt, $firma, $randomString, $id_Pub, $scopus, $wos, $fecha);

	
	
	
	
?>