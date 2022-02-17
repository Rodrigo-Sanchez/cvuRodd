<link rel='stylesheet prefetch' href='https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css'>

<p><b>Resultados encontrados</b></p>
<?php

	include("m/funciones.php");

	$scopus = $_POST['scopusId'];
	$wos = $_POST['wosId'];
	$pubmed = $_POST['pubmedId'];
	$tit = $_POST['titulo'];
	$ne = $_POST['numeroEmpleado'];
	
	if($tit=="" && $scopus=="" && $wos=="" && $pubmed=="") { ?>
	
		<p>Debes introducir un campo de búsqueda</p>
	
<?php

	} else if( ($tit!="" && $scopus!="") || ($tit!="" && $wos!="") || ($tit!="" && $pubmed !="") || ($scopus!="" && $wos!="") || ($scopus!="" && $pubmed!="") || ($pubmed!="" && $wos!="") || ($tit!="" && $scopus!="" && $wos!="") || ($tit!="" && $scopus!="" && $wos!="" && $pubmed!="") ) { ?>
	
		<p>Debes introducir sólo un campo de búsqueda</p>
	
	<?php
	} else {
	
	
		if( $tit!="" ) {
			$resultado = getPubsByTitulo($tit); 	
		}
		if( $scopus!="" ) {
			$resultado = getPubsByScopusID($scopus); 	
		}
		if( $wos!="" ) {
			$resultado = getPubsByWosID($wos); 	
		}
		
		if( $pubmed!="" ) {
			$resultado = getPubsByPubMedId($pubmed); 	
		}
		
		?>
		
		<form id="publicaciones">
		<table id="example" style="font-size:12px;" class="display" cellspacing="0" >
		
			<thead>
				<tr>
					<th>#</th>
					<th>Añadir</th>
					<th>Título</th>
				</tr>
			</thead>
			
			<tbody>
		
<?php		

		$contador=1;
		foreach($resultado as $r) {  
		
			$id = $r['Identificador'];
			$rev = $r['RevistaTitulo'];
			$f = explode("-", $r['FechaPublicacion']);
			
		
		?>
			<tr>
				<td><?= $contador ?>
				<td><input class="form-check-input" type="checkbox" name="seleccionada[]" value="<?= $id ?>" >
				<br>
				<br>
				<span onclick="muestraInfoExtra(<?= $id ?>)" style="font-size:11px; color:blue" >- Ver detalles </span>
				
				</td>
				</td>
				<td><a href="https://produccion.siia.unam.mx/Publicaciones/ProdCientif/PublicacionFrw.aspx?scopus=0&id=<?= $id ?>" target="_blank" ><?= utf8_encode($r['Titulo']) ?></a>; <?= utf8_encode($rev) ?>, <?= $f[0] ?></td>
			</tr>
			
<?php
			
			$contador++;

		}
?>		
			</tbody>
		</table>
		
		<input type="hidden" name="numeroEmpleado" value="<?= $ne ?>" />
		
		<button type="button" class="btn btn-info" onclick="agregarPubs()">Agregar a mi lista</button>
		
		</form>
		<script src='funciones_pag.js'></script>
		<script>  
			$(document).ready(function() {
				$('#example').DataTable();
			} );
		</script>

<?php		
		
	}
	
?>