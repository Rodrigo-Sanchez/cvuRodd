<?php

	include("m/funciones.php");
	//$nt = $_GET['nt'];
	session_start();
	$nt = $_SESSION['nt'];
	
	$datos = getInfoPersonalAcademico($nt);
	
	$entidades = getEntidadesDGEI();
	
	$arr = array();
	
	foreach($entidades as $e) {
		$arr[] = utf8_encode($e['NombreInstitucion']);
	}
	
	
	
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
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>
		  $( function() {
			var availableTags = <?php echo json_encode($arr);?>;
			$( "#tags" ).autocomplete({
			  source: availableTags,
			  appendTo : "#mi-modal2"
			});
			
		  } );
		</script>
	
		
		

		<style>
			body {
				background-color:#fff;
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
				color: #FFFFFF;
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
			
			.ui-menu-item  {
				background: #ffffff !important;
				color: #000000 !important;
			} 
			
		</style>
		
		<script>
			function abreRegistroNuevo() {
				$("#mi-modal2").modal('hide');
				
			}
		</script>
		
		<script>
			function abreAgregar2() {
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
				//alert(dataPubs);
				
				$.ajax({  
					url:"agregarTesis.php",  
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
									$(cadena).html("<p id='parrafoConf_"+indice+"' style='color:blue;'>Tesis en revisión para desvincular</p><button id='botonConf_"+indice+"' onclick='revierteDes(" + indice + "," + idPub + ")'>Revertir esta acción</button>");
								} else {
									$(cadena).html("<p id='parrafoDes_"+indice+"' style='color:blue;'>Tesis validada por el académico</p><button id='botonDesv_"+indice+"' onclick='revierteConf(" + indice + "," + idPub + ")'>Revertir esta acción</button>");
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
			function abrePendientes() {
				$("#mi-modalPendientes").modal('show');	
			}
		
		</script>
		

	</head>
	<body>
	<!-- Modal confirmación de validación -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">¿Confirmas aplicar los cambios?</h4>
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
							<p>Agregar Estudios</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p>Proporcione la siguiente información</p>
					
					<form id="paraBuscar">
						<div class="form-group">
						
							<div class="row">
								<div class="col-sm-12">
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Nivel obtenido<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-4">
										<input type="hidden" name="numeroEmpleado" value="<?= $nt ?>" />
										
										<select id="nivel" class="form-control" name="nivel" >
											<option value="0">Seleccionar</option>
											<option value="1"><?= 'Técnico Superior Universitario' ?></option>
											<option value="2"><?= utf8_decode('Licencia Profesional') ?></option>
											<option value="3"><?= utf8_decode('Licenciatura') ?></option>
											<option value="4"><?= utf8_decode('Especialidad') ?></option>
											<option value="5"><?= 'Maestría' ?></option>
											<option value="6"><?= utf8_decode('Doctorado') ?></option>
										</select>
										
									</div>
									<div class="col-sm-2">
										<label for="sel1">Fecha examen<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-4">
										<input type="date" class="form-control" name="fechaexamen"  />
									</div>
									
								</div>
								
								

								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Universidad<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-10">
										<input type="text" onchange="ponCarreras()" class="form-control" id="tags" name="tags" placeholder="Escriba el nombre de la institución o un segmento representativo" />	
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Carrera<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-10">
										<select id="carreraName" type="text" class="form-control" name="carreraName"  />
											<option value="0">Seleccionar</option>
										
										</select>
										
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Título de la tesis<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="tituloTesis" />	
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Mención honorífica<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-10">
										<input type="checkbox" class="form-check-input" id="exampleCheck0">
										<label class="form-check-label" for="exampleCheck1">Sí</label>
										<input type="checkbox" style="margin-left:20px;" class="form-check-input" id="exampleCheck1">
										<label class="form-check-label" for="exampleCheck1">No</label>
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Observaciones:</label>
									</div>
									<div class="col-sm-10">
										<textarea  style="resize: none;" class="form-control" id="w3review"  name="w3review" rows="4" ></textarea>
										
									</div>
								</div>
								
								<p><span style="color:red;">(*) Campos obligatorios</span></p>
								<div class="row" style="margin-top:15px;">
									<div class="col-sm-2">
									</div>
									<div class="col-sm-10">
										<button type="button" class="btn btn-primary" onclick="agregarPubs()">Agregar</button>
									</div>
								</div>
								
								<br>
								<p>Si la universidad y carrera que desea añadir a su lista no se localizó a través de la búsqueda, de click <button type="button" onclick="abreAgregar2()" class="btn btn-info" > aquí </button>
								
								</div>
								
								
							</div>
							
						</div>
					</form>
					
					
				</div>
				<!--<div class="modal-footer">
					<p>pie</p>
				</div>-->							
			</div>
		</div>
	</div>
	
	
	<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="mi-modal3">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background-color:#1F618D; color:white;">
					<div class="row">
						<div class="col-sm-10">
							<p>Agregar estudios</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				
				<div class="modal-body">
					<p>Proporcione la siguiente información</p>
					
					<form id="paraBuscar">
						<div class="form-group">
						
							<div class="row">
								<div class="col-sm-12">
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Nivel obtenido<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-4">
										<input type="hidden" name="numeroEmpleado" value="<?= $nt ?>" />
										
										<select id="nivel" class="form-control" name="nivel" >
											<option value="0">Seleccionar</option>
											<option value="1"><?= 'Técnico Superior Universitario' ?></option>
											<option value="2"><?= utf8_decode('Licencia Profesional') ?></option>
											<option value="3"><?= utf8_decode('Licenciatura') ?></option>
											<option value="4"><?= utf8_decode('Especialidad') ?></option>
											<option value="5"><?= 'Maestría' ?></option>
											<option value="6"><?= utf8_decode('Doctorado') ?></option>
										</select>
										
									</div>
									<div class="col-sm-2">
										<label for="sel1">Fecha examen<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-4">
										<input type="date" class="form-control" name="fechaexamen"  />
									</div>
									
								</div>
								
								

								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Institución<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="uni" id="uniNameNew"  />
									
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Carrera<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="carreraNameNew"  />
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Título de la tesis<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="tituloTesis" />	
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Mención honorífica<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-10">
										<input type="checkbox" class="form-check-input" id="exampleCheck0">
										<label class="form-check-label" for="exampleCheck1">Sí</label>
										<input type="checkbox" style="margin-left:20px;" class="form-check-input" id="exampleCheck1">
										<label class="form-check-label" for="exampleCheck1">No</label>
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Observaciones:</label>
									</div>
									<div class="col-sm-10">
										<textarea  style="resize: none;" class="form-control" id="w3review"  name="w3review" rows="4" ></textarea>
										
									</div>
								</div>
								
								<p><span style="color:red;">(*) Campos obligatorios</span></p>
								<div class="row" style="margin-top:15px;">
									<div class="col-sm-2">
									</div>
									<div class="col-sm-10">
										<button type="button" class="btn btn-primary" onclick="agregarPubs()">Agregar</button>
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
							<p>Estímulos SNI en revisión para agregarse a tu lista</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">

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
			<div  style="background-color:#F1F1F1; margin-left:-15px !important; margin-right:-15px !important; padding-top:10px; padding-bottom:10px;">
			
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
					<center><h4><b><?= $datos[0]['NombreCompleto'] ?></b></h4><h4>Formación académica - <i>Estudios realizados</i> </h4></center>
					<p onclick="abrePendientes()" style="float:right;">En proceso de validación <img width="40px" src="imagenes/buying-books.png" />
					</p>
					<br>
					
                    <hr style="margin-bottom:0px;">
					
				</div>
			</div>
			
			<?php
				$lista = 0;
				
				if($lista!=0) {
			?>
			<div class="row">
				
				<div class="col-md-12" style="height: 500px; overflow: auto;"  >
			
				
				<form id="paraBorrar" >
					<input type="hidden" name="nt" value="<?= $nt ?>" />

						<table id="example" style="font-size:12px;  " class="display" cellspacing="0" >
				
							<thead>
								<tr>
									<th>#</th>
									<th>Estímulo otorgado</th>
									<th>Área</th>
									<th>Fecha inicio</th>
									<th>Fecha fin</th>
									<th>Confirmar/Desvincular</th>			
								</tr>
							</thead>
 
							<tbody>
									
							<?php
									
							$contador = 1;
							foreach($lista as $l) {
								
								$fi = explode(' ',$l['FechaDesde']);
								$fbien = explode('-',$fi[0]);
								
								$fi2 = explode(' ',$l['FechaHasta']);
								$fbien2 = explode('-',$fi2[0]);
								
								$ne = getNombreEntidad($l['Dependencia']);
								
								
								?>
								<tr>
									<td><?= $contador ?></td>
									<td><?= utf8_encode($l['EstimuloOtorgado']) ?></td>
									<td><?= utf8_encode($l['GranArea']) ?></td>
									<td><?= utf8_encode($fbien[2].'-'.$fbien[1].'-'.$fbien[0]) ?></td>
									<td><?= utf8_encode($fbien2[2].'-'.$fbien2[1].'-'.$fbien2[0]) ?></td>
									
								<?php
												
								if(in_array($id, $arrValidadas)) { ?>
													
									<td>
										<div id="opcion_<?=$contador?>">
											<p id="parrafoDes_<?= $contador ?>" style="color:blue;">Estímulo validado por el académico</p><button id="botonDesv_<?= $contador ?>" onclick="revierteConf(<?= $contador ?>, <?=  $id ?>)">Revertir esta acción</button>
										</div>
									</td>
									<?php		
								} else if (in_array($id, $arrPorBorrar)) { ?>				
									<td>
										<div id="opcion_<?=$contador?>">
											<p id="parrafoConf_<?= $contador ?>" style="color:blue;">Estímulo en revisión para desvincular </p><button id="botonConf_<?= $contador ?>" onclick="revierteDes(<?= $contador ?>, <?=  $id ?>)">Revertir esta acción</button>
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
			
			
			<?php
			
			} else {
				
			?>
			
				<center><p style="color:red;">No se encontraron resultados</p></center>
			
			<?php
			
			}
			?>
			
			
			<div class="row" style="margin-top:20px;">
				<div class="col-md-12">
				
					
				
					<button type="button" onclick="abreAgregar()" class="btn btn-info" style="float:right; margin-left:50px;" ><span class="glyphicon glyphicon-plus"></span> Agregar Estudios </button>
					
					<button type="button" class="btn btn-success" onclick="guardarCambios()">Aplicar cambios</button>
				</div>
			</div>
			
		</div>	
	</div>	
</div>


<?php
	include("footer.php");
?>

	</body>
	
<script>
	function ponCarreras() {
		var uni = $( "#tags" ).val();
		var niv = $( "#nivel" ).val();
		$.ajax({
			type: 'POST',
			url: 'carrerasEstudios.php',
			data: {universidad:uni, nivel:niv},
			success:function(data) {  
				$('#carreraName').html(data);  
			}
		});
	}
</script>
	
	
</html>