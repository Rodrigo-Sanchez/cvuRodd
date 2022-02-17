<?php

	include("m/funciones.php");
	
	$nt = $_POST["numeroEmpleado"];
	
	
	//Revisar si ya quiso agregar esa publicación antes
	$publicacionesQuiereAgregar = getSolicitudesAlta($nt);
	$pqa = array();
	foreach($publicacionesQuiereAgregar as $p) {
		$pqa[] = $p['idPublicacionSIIA'];
	}

	foreach ($_POST['seleccionada'] as $s) { 
	
		$res = getInfoArticuloById($s);
		$id =  $res[0]['Identificador'];
		
		if(in_array($id, $pqa)==false) {
			
			//Agregar a la base
			$fecha = date("Y-m-d h:m:s");
			requestAgregarPublicacion($nt, $id, $fecha);
	
	?>
		
		
		<li><a href="https://produccion.siia.unam.mx/Publicaciones/ProdCientif/PublicacionFrw.aspx?scopus=0&id=<?=$id?>" target="_blank"><?= utf8_encode($res[0]['Titulo']) ?></a> - </li>
		
		
<?php		

		}
		
	}

?>