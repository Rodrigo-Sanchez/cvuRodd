<?php

	include("m/funciones.php");
	//$nt = $_GET['nt'];
	session_start();
	$nt = $_SESSION['nt'];
	
	$datos = getInfoPersonalAcademico($nt);
	
	

	
	
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel='stylesheet prefetch' href='https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

		

		<style>
			body {
				background-color:#ffffff;
			}
			
			ul {
				list-style: none;
				padding: 0;
			}

			ul .inner {
				overflow: hidden;
				display: none;
			}

			ul li {
				margin: 0;
				padding-top: 0.2em !important;
			}

			ul li a {
				text-decoration:none;
				color: #f1f1f1;
				font-size:13px;
					
				
			}
			
			ul li a:hover {
				text-decoration:none;
				color: #EEA845;
			}


			ul.inner li>a {
				padding-left: 1em;
			}

			ul.inner .inner li>a {
				padding-left: 2em;
			}

			ul.inner .inner .inner li>a {
				padding-left: 3em;
			}
			

			
		</style>
		
		<script>
			function abreRegistroNuevo() {
				$("#mi-modal2").modal('hide');
				$("#mi-modal3").modal('show');	
			}
		</script>
		
		<script>
			function revierteDes(indice, idPub) {
				event.preventDefault();
				var numT = "<?php echo $nt; ?>";
				$.ajax({  
					url:"borrarTesisDirecto.php",  
					method:"post",  
					data:{indi:indice, pub:idPub, nt: numT},  
					success:function(data) {  
						$("#botonConf_"+indice).hide();
						$("#parrafoConf_"+indice).html("<div id='opcion_"+indice+"><div class='radio'><label style='color:black; font-style:normal'><input type='radio' name='ids_"+indice+"' value='"+idPub+"-1'> Confirmar</label></div><div class='radio'><label style='color:black;' ><input type='radio' name='ids_"+indice+"' value='"+idPub+"-0'> Desvincular</label></div></div>");						
					}  
				});		
			}
		</script>
		
		<script>
			function revierteConf(indice, idPub) {
				event.preventDefault();
				var numT = "<?php echo $nt; ?>";
				$.ajax({  
					url:"borrarTesisDirecto2.php",  
					method:"post",  
					data:{indi:indice, pub:idPub, nt: numT},  
					success:function(data) {  
						$("#botonDesv_"+indice).hide();
						$("#parrafoDes_"+indice).html("<div id='opcion_"+indice+"><div class='radio'><label style='color:black; font-style:normal'><input type='radio' name='ids_"+indice+"' value='"+idPub+"-1'> Confirmar</label></div><div class='radio'><label style='color:black;' ><input type='radio' name='ids_"+indice+"' value='"+idPub+"-0'> Desvincular</label></div></div>");						
					}  
				});		
			}
		</script>
		
		<script>
			function agregarPubs() {
				var dataPubs = $('#paraBuscar').serialize();
				$.ajax({  
					url:"agregarTesisExterna.php",  
					method:"post",  
					data:$('#paraBuscar').serialize(),  
					success:function(data) {  
						alert("Tesis agregada exitosamente");	
						$("#nuevas").append(data);	
						$("#mi-modal2").modal('hide');//ocultamos el modal
						$('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
						$('.modal-backdrop').remove();//eliminamos el backdrop del modal						
						
					}  
				});
								
			}
		</script>
		
		
		
		<script>
			function enviarRegistro() {
				event.preventDefault();
				var dataPubs = $('#paraAgregarNuevoArt').serialize();
				//alert(dataPubs);
				$.ajax({  
					url:"agregarNuevaTesis.php",  
					method:"post",  
					data:$('#paraAgregarNuevoArt').serialize(),  
					success:function(data) {  
						alert("Tesis agregada exitosamente");	
						$("#nuevas2").append(data);	
						$("#mi-modal3").modal('hide');//ocultamos el modal
						$("#mi-modal2").modal('hide');
						$('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
						$('.modal-backdrop').remove();//eliminamos el backdrop del modal							
					}  
				});
				
			}
		</script>
		
		<script>
			function abreAgregar() {
				$("#mi-modal2").modal('show');
			}
		</script>
		
		<script>
			function abreAgregar2() {
				$("#mi-modal3").modal('show');
			}
		</script>
		
		<script>
			function guardarCambios() {					

				$("#mi-modal").modal('show');
				
				var tot = <?= $ptotales ?>;
				
				var dataPubs = $('#paraBorrar').serialize();
				//alert(dataPubs);
				
				var paraQuitar;
				var i=1;
				var arreglosQuitar=[];
				var IDSModificar=[];
				var arreglosTipo=[];
				while(i<=tot) {
					paraQuitar = ($('input[name=ids_'+i+']:checked', '#paraBorrar').val());
					//alert(paraQuitar);
					if((paraQuitar===undefined)==false) {
						//alert("a ocultar");
						var deci = paraQuitar.split("-");
						IDSModificar.push(deci[0]);
						arreglosTipo.push(deci[1]);
						arreglosQuitar.push(i);  
					} else {
						//alert("dejar");
					}
					i++;
				}
				

				//Confirmamos de validar
				$("#modal-btn-si").on("click", function(){
					$("#mi-modal").modal('hide');
					$.ajax({  
						url:"alterarTesis.php",  
						method:"post",  
						data:$('#paraBorrar').serialize(),  
						success:function(data) {  
							//alert("bien");
							var j=0;
							while(j<arreglosQuitar.length) {
								var indice = arreglosQuitar[j];
								var idPub = IDSModificar[j];
								var cadena = "#opcion_"+indice;
								//alert("cadena: " + cadena);
								//alert("arreglosTipo: " + arreglosTipo[j]);
								if(arreglosTipo[j]==0) {
									$(cadena).html("<p id='parrafoConf_"+indice+"' style='color:blue;'>Tesis en revisi??n para desvincular</p><button id='botonConf_"+indice+"' onclick='revierteDes(" + indice + "," + idPub + ")'>Revertir esta acci??n</button>");
								} else {
									$(cadena).html("<p id='parrafoDes_"+indice+"' style='color:blue;'>Tesis validada por el acad??mico</p><button id='botonDesv_"+indice+"' onclick='revierteConf(" + indice + "," + idPub + ")'>Revertir esta acci??n</button>");
								}
								j++;
							}	
							arreglosTipo=[];
							arreglosQuitar=[];
							IDSModificar=[];
						}  
					});
					

				});

				//Cancelamos el validar
				$("#modal-btn-no").on("click", function(){
					$("#mi-modal").modal('hide');
				});
			}

		</script>
		
		<script>
			function ponFrame(id) {
				var link = "<iframe style='width:100%;height:150%; background-color:white;' src='https://produccion.siia.unam.mx/Publicaciones/ProdCientif/PublicacionFrw.aspx?scopus=0&id="+id+"'></iframe>";
				$("#abrir").html(link);
				
				
			}
		
		</script>
		
		<script>
			function abrePendientes() {
				//alert("aqui");
				$("#mi-modalPendientes").modal('show');	
				
			}
		
		</script>
		
		
		<script>
			function muestraInfoExtra(id) {
				var link = "<iframe style='width:100%;height:150%; background-color:white;' src='https://produccion.siia.unam.mx/Publicaciones/ProdCientif/PublicacionFrw.aspx?scopus=0&id="+id+"'></iframe>";
				$("#datosExtraPub").html(link);
	
			}
		
		</script>
		
		
	</head>
	<body>
	<!-- Modal confirmaci??n de validaci??n -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">??Confirmas aplicar los cambios?</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="modal-btn-si">Si</button>
					<button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
				</div>							
			</div>
		</div>
	</div>
	
	<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="mi-modal2">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background-color:#1F618D; color:white;">
					<div class="row">
						<div class="col-sm-10">
							<p>Agregar Seminario</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p>Proporcione la siguiente informaci??n</p>
					
					<form id="paraBuscar">
						<div class="form-group">
						
							<div class="row">
								<div class="col-sm-12">
								
								<div class="row" style="margin-bottom:7px;">
									
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-3">
												<label for="sel1">T??tulo<span style="color:red;">*</span>:</label>
											</div>
											<div class="col-sm-9">
												<input type="text" class="form-control" />	
											</div>
											
										</div>	
									</div>
									
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-3">
												<label for="sel1">Sede<span style="color:red;">*</span>:</label>
											</div>
											<div class="col-sm-9">
												<input type="text" class="form-control" />	
											</div>
											
										</div>	
									</div>
									
									
								</div>
								
								
								
								
								
								<div class="row" style="margin-bottom:7px;">
								
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-3">
												<label for="sel1">Fecha inicio<span style="color:red;">*</span>:</label>
											</div>
											<div class="col-sm-9">
												<input type="date" class="form-control" />	
											</div>
											
										</div>	
									</div>
									
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-3">
												<label for="sel1">Fecha fin<span style="color:red;">*</span>:</label>
											</div>
											<div class="col-sm-9">
												<input type="date" class="form-control" />	
											</div>
											
										</div>	
									</div>
										
								</div>
								
								
								<div class="row" style="margin-bottom:7px;">
								
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-3">
												<label for="sel1">Observaciones</label>
											</div>
											<div class="col-sm-9">
												<textarea style="resize: none;" class="form-control" id="w3review"  name="w3review" rows="4" ></textarea>
											</div>
											
										</div>	
									</div>
									
									
										
								</div>
								
								
								
								
								<p><span style="color:red;">(*) Campos obligatorios</span></p>
								<div class="row" style="margin-bottom:7px;">
								
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-3">
											</div>
											<div class="col-sm-9">
												<button type="button" class="btn btn-info" onclick="agregarPubs()">Agregar</button>
											</div>
											
										</div>	
									</div>
									
									
								</div>
								
								
							
								</div>
								
								
							</div>
							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	

	<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="mi-modalPendientes">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background-color:#1F618D; color:white;">
					<div class="row">
						<div class="col-sm-10">
							<p>Tesis en revisi??n para agregarse a tu lista</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
				
					 
					
					<?php
					
						$publicacionesQuiereAgregar = getDetallesQuiereAgregarTesisExternasDir($nt); ?>
						
					
						
						<ol id="nuevas">
						
					<?php	
						foreach($publicacionesQuiereAgregar as $p) {
									
							$obs =  $p['observaciones']; 
							
							$ne = getNombreEntidadSIES($p['codigoDgei_Sies']);
							$ent = $ne[0]['NombreInstitucion'];
							
							?>
							
							<li>Universidad:<?= $ent ?>, T??tulo: <?= $p['tituloTesis'] ?>, Autor(es):<?= $p['autor'] ?>, A??o: <?=  $p[utf8_decode('a??oExamen')] ?>		
							</li>
									
							<?php
							
							
							
						}
					
					
					?>
						</ol>

					
				</div>						
			</div>
		</div>
	</div>
	
	
	
	
<?php
	include("header.php");
?>

	<div class="container-fluid" style="background-color:#ffffff; border-left: 50px #EDEDED solid; border-right: 50px #EDEDED solid;">
	<div class="row">
        <div class="col-md-3" style="background-color:#303C64;">
			<div  style="background-color:#f1f1f1; margin-left:-15px !important; margin-right:-15px !important; padding-top:10px; padding-bottom:10px;">
			
			<?php
				if($datos[0]['CodigoGenero']=="M") {
			?>
				<div style="padding-top:10px;">
					<center>
						<img src="imagenes/hombre.png" width="20%" style="border-radius: 50%; background-color:white;" />
					</center>
				</div>

			<?php
				} else {
			?>	

				<div style="padding-top:10px;">
					<center>
						<img src="imagenes/mujer.png" width="20%" style="border-radius: 50%; background-color:white;" />
					</center>
				</div>
				
			<?php
				}
			?>
				<center><h5 style="color:#00375F;"><b><?= $datos[0]['NombreCompleto'] ?></h5></b></center>
				
			</div>

			<?php
			
				include("menubar.php");
			
			?>

		</div>
		
		<div class="col-md-9" style="background-color:white; padding-bottom:50px; ">
			
			<div class="row">
				<div class="col-md-12">
					<center><h4><b><?= $datos[0]['NombreCompleto'] ?></b></h4><h4>Formaci??n acad??mica - <i>Seminarios</i> </h4></center>
					<p onclick="abrePendientes()" style="float:right;">En proceso de validaci??n <img width="40px" src="imagenes/buying-books.png" />
					</p>
					<br>
					
                    <hr style="margin-bottom:0px;">
					
				</div>
			</div>
			
			<?php
				//$lista = getTesisDirigidas($nt);
			?>
			
			
			<center> 

			<p>Sin datos </p>

			</center>
			
			<!--
			<div class="row">
				
				<div class="col-md-12" style="height: 500px; overflow: auto;"  >
			
				
				<form id="paraBorrar" >
					<input type="hidden" name="nt" value="<?= $nt ?>" />

						<table id="example" style="font-size:12px;  " class="display" cellspacing="0" >
				
							<thead>
								<tr>
									<th>#</th>
									<th>T??tulo de la Tesis</th>
									<th>Nivel</th>
									<th>Director</th>
									<th>Sinodales</th>
									<th>Autor</th>
									<th>Entidad</th>
									<th>Url</th>
									<th>A??o</th>
									<th>Confirmar/Desvincular</th>			
								</tr>
							</thead>
 
							<tbody>
									
							<?php
									
							$contador = 1;
							foreach($lista as $l) {
								
								//Obtener directores
								$id = $l['Identificador'];
								
								$cadenaDirectores="";
								$cadenaAsesores="";
								$cadenaAutores="";
								
								$dirigidas = getTutoresTesis($id);
								foreach($dirigidas as $d) {
									$cadenaDirectores .= $d['NombreCompleto']. ", ";
								}
								
								$asesoradas = getAsesoresTesis($id);
								foreach($asesoradas as $d) {
									$cadenaAsesores .= $d['NombreCompleto']. ", ";
								}
								
								if($cadenaAsesores==""){
									$cadenaAsesores = $cadenaDirectores;
								}
								
								
								$autores = getAutoresTesis($id);
								foreach($autores as $d) {
									$cadenaAutores .= $d['NombreCompleto']. ", ";
								}
								
								
								
								?>
								<tr>
									<td><?= $contador ?></td>
									<td><?= utf8_encode($l['Titulo']) ?></td>
									<td><?= utf8_encode($l['TipoTesis']) ?></td>
									<td><?= utf8_encode($cadenaDirectores) ?></td>
									<td><?= utf8_encode($cadenaAsesores) ?></td>
									<td><?= utf8_encode($cadenaAutores) ?></td>
									<td><?= utf8_encode($l['Institucion']) ?></td>
									<td><a href="<?= $l['Url'] ?>" target="_blank" ><img src="imagenes/pdf.png" /></a></td>
									<td><?= $l['anio'] ?></td>
											
								<?php
												
								if(in_array($id, $arrValidadas)) { ?>
													
									<td>
										<div id="opcion_<?=$contador?>">
											<p id="parrafoDes_<?= $contador ?>" style="color:blue;">Tesis validada por el acad??mico</p><button id="botonDesv_<?= $contador ?>" onclick="revierteConf(<?= $contador ?>, <?=  $id ?>)">Revertir esta acci??n</button>
										</div>
									</td>
									<?php		
								} else if (in_array($id, $arrPorBorrar)) { ?>				
									<td>
										<div id="opcion_<?=$contador?>">
											<p id="parrafoConf_<?= $contador ?>" style="color:blue;">Tesis en revisi??n para desvincular </p><button id="botonConf_<?= $contador ?>" onclick="revierteDes(<?= $contador ?>, <?=  $id ?>)">Revertir esta acci??n</button>
										</div>
									</td>
											
								<?php
								} else { ?>

									<td>
										<div id="opcion_<?=$contador?>">
											<div class="radio">
												<label><input type="radio" name="ids_<?=$contador?>" value="<?= $id ?>-1">Confirmar</label>
											</div>
											<div class="radio">
												<label><input type="radio" name="ids_<?=$contador?>" value="<?= $id ?>-0">Desvincular</label>
											</div>
										</div>
									</td>
								<?php
								}
								?>
								</tr>
							<?php	
									$contador++;
							}
							?>
						
							</tbody>
						</table>
						<script src='funciones_pag.js'></script>
						<script>  
							$(document).ready(function() {
							$('#example').DataTable();
							} );
						</script>	

					<input type="hidden" name="contador" value="<?= $contador ?>" />

				</form>
				</div>
			</div>
			-->
			
			
			<div class="row" style="margin-top:20px;">
				<div class="col-md-12">
				
					
				
					<button type="button" onclick="abreAgregar()" class="btn btn-info" style="float:right; margin-left:50px;" ><span class="glyphicon glyphicon-plus"></span> Agregar Seminario </button>
					
					
					
					<!--<button type="button" class="btn btn-success" onclick="guardarCambios()">Aplicar cambios</button>-->
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-md-12">
					<div id="abrir" style="margin-top:20px;" >
						
					</div>
				</div>
			</div>
			
			
			
		</div>	
	</div>	
</div>




<?php
	include("footer.php");
?>

	</body>
</html>