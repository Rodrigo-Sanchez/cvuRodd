<?php

	include("m/funciones.php");

	$nombre = $_POST['nombre'];
	$apat = $_POST['apat'];
	$amat = $_POST['amat'];
	
	if($amat!="") {
		$cadena = $nombre . " ".$apat." ".$amat;
	} else {
		$cadena = $nombre . " ".$apat;
	}
	
	$resultado = getPatentesOtoRegistroPersona($cadena);
	
	$contador=0;

	foreach($resultado as $s) { 
	
		$contador++;
	?>
		
		<div class="checkbox">
			<label><input type="checkbox" value="">
			<a href="descripcionPatentes.php?id=<?= $s['NumeroSolicitud'] ?>" onclick="window.open(this.href, 'mywin', 'left=20,top=20,width=700,height=600,toolbar=1,resizable=0'); return false;" ><?= $s['NumeroSolicitud'] ?></a><span>, <?=utf8_encode($s['Titulo'] )?></span></label>
		</div>
<?php		
	}
	
	if($contador==0) { 
?>
		<p>Sin resultados</p>

<?php

	} else {
	
?>

	<button type="button" class="btn btn-primary" onclick="agregg()">Agregar </button>


<?php

	}
	
?>
