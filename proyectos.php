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
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
	
		
		

		<style>
			body {
				background-color:#EDEDED;
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
							<p>Agregar Proyecto</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p>Busque el Proyecto en el que participó</p>
					
					<form id="paraBuscar">
						<div class="form-group">
						
							<div class="row">
								<div class="col-sm-12">
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Convocatoria <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
									
									<select id="convocatoria" class="form-control changeStatus" name="convocatoria" >
										<option value="0">Seleccionar</option>
										<option value="3">CONACYT</option>
										<option value="4">INFOCAB</option>
										<option value="1">PAPIIT</option>
										<option value="2">PAPIME</option>
									</select>
									</div>
								</div>
								
								
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Área <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
									
									<select id="areaC" class="form-control" name="areaC" onchange="ponNombresProyectos()" >
										<option value="0">Seleccionar</option>
									</select>
									
									</div>
								</div>
								
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Nombre <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
									
									<select id="nomProy" class="form-control" name="nomProy" >
										<option value="0">Seleccionar</option>
										<input type="hidden" name="numeroEmpleado" value="<?= $nt ?>" />
									</select>
									
									</div>
								</div>
						
								
							
								
								<div class="row" style="margin-top:6px;">
									<div class="col-sm-3">
									<label for="sel1">Tipo de participación <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-3">
										<select id="calidad" class="form-control" name="calidad">
											<option value="0">Seleccionar</option>
											<option value="D">Responsable</option>
											<option value="C1">Co-Responsable</option>
											<option value="SR">Segundo responsable</option>
											<option value="R1">Responsable asociado 1</option>
											<option value="R2">Responsable asociado 2</option>
											<option value="9">Otro</option>
										</select>
									</div>
									
									
									<div class="col-sm-1">
										<label for="sel1">Otra:</label>
									</div>
									
									<div class="col-sm-5">
										<input type="text" class="form-control" />
									</div>
									
									
									
									
								</div>
								
								<div class="row" style="margin-top:7px;">
									<div class="col-sm-3">
											<label for="sel1">Observaciones: </label>
										</div>
										<div class="col-sm-9">
											<textarea  class="form-control" rows="4">
										
										</textarea>
										</div>
								</div>
								
								
								<p><span style="color:red;">(*) Campos obligatorios</span></p>
								
								<div class="row" style="margin-top:15px;">
									<div class="col-sm-3">
									</div>
									<div class="col-sm-9">
										<button type="button" class="btn btn-info" onclick="agregarPubs()">Aceptar</button>
									</div>
								</div>
								
								<br>
								<div class="row" style="margin-top:12px;">
									<span> Si el proyecto que buscaba no apareció, de click 
									<button type="button" onclick="abreAgregar2()" class="btn btn-info"> aquí </button>
									
									
									</span>
								
								</div>
							
								</div>
								
								
							</div>
							
						</div>
					</form>
					
					<div id="datosExtraPub">
					
					
					</div>
					
					
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
							<p>Agregar proyecto nuevo</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p>Proporcione los siguientes datos</p>
					<form id="paraAgregarNuevoArt">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Convocatoria <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-10">
										<select id="convocatoria" class="form-control" name="convocatoria" >
											<option value="0">Seleccionar</option>
											<option value="3">CONACYT</option>
											<option value="4">INFOCAB</option>
											<option value="1">PAPIIT</option>
											<option value="2">PAPIME</option>
										</select>
									
									</div>
									</div>
								</div>
								
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Área <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-5">
									
									<?php
									
										$ap = getAreasAllProyectos();
									
									?>
									
									
									
										<select id="convocatoria" class="form-control" name="convocatoria" >
											<option value="0">Seleccionar</option>
											
									<?php
									
										foreach($ap as $a) { ?>
											
											
											<option value="<?= $a['CodigoArea'] ?>"><?= $a['Area'] ?></option>
											
									<?php

										}
									?>
											
											<option>Otra </option>
										</select>
									
									</div>
									<div class="col-sm-1">
									<label for="sel1">Otra:</label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control"  />
									</div>
									
									
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="col-sm-2">
											<label for="sel1">Nombre <span style="color:red;">*</span>:</label>
										</div>
										<div class="col-sm-10">
											<input type="text" class="form-control"  />
										</div>
									</div>
								
								</div>
								
								<div class="row" style="margin-top:7px;">
									<div class="col-sm-12">
										<div class="col-sm-2">
											<label for="sel1">Rol <span style="color:red;">*</span>:</label>
										</div>
										<div class="col-sm-5">
											<select id="calidad" class="form-control" name="calidad">
											<option value="0">Seleccionar</option>
											<option value="D">Responsable</option>
											<option value="C1">Co-Responsable</option>
											<option value="SR">Segundo responsable</option>
											<option value="R1">Responsable asociado 1</option>
											<option value="R2">Responsable asociado 2</option>
											</select>
										</div>
										<div class="col-sm-1">
											<label for="sel1">Código:</label>
										</div>
										<div class="col-sm-4">
											<input type="text" class="form-control"  />
										</div>
									</div>
								
								</div>
								
								<div class="row" style="margin-top:7px;">
									<div class="col-sm-12">
										<div class="col-sm-2">
											<label for="sel1">Fecha inicio <span style="color:red;">*</span>:</label>
										</div>
										<div class="col-sm-5">
											<input type="date" class="form-control" />
										</div>
										<div class="col-sm-1">
											<label for="sel1">Fecha fin:</label>
										</div>
										<div class="col-sm-4">
											<input type="date" class="form-control" />
										</div>
										
									</div>
								
								</div>
								
								
								<div class="row" style="margin-top:7px;">
									<div class="col-sm-12">
										<div class="col-sm-2">
											<label for="sel1">Observaciones: </label>
										</div>
										<div class="col-sm-10">
											<textarea  class="form-control" rows="4">
										
										</textarea>
										</div>
										
										
									</div>
								
								</div>
								
								
								
								
							</div>
							
							
							
							<br>
							<p><span style="color:red;">(*) Campos obligatorios</span></p>
							<center>
							<button type="button" class="btn btn-primary" onclick="enviarRegistro()">Aceptar </button>
							</center>
							
							
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
							<p>Tesis en revisión para agregarse a tu lista</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
				
					 
					
					<?php
					
						$publicacionesQuiereAgregar = getDetallesQuiereAgregarTesis($nt); ?>
						
						<span style="color:red;">Tesis SIIA  </span>
						
						
						<ol id="nuevas">
						
					<?php	
						foreach($publicacionesQuiereAgregar as $p) {
									
							$obs =  $p['observaciones']; 
							
							if($obs=="El academico quiere agregar una tesis SIIA en calidad de Tutor" || $obs=="El academico quiere agregar una tesis SIIA en calidad de Director" ) {
							
							?>
							<li><?= utf8_encode($p['Titulo']) ?>, <a href="<?= $p['Url'] ?>" target="_blank" />Ver detalles </a></li>
									
							<?php
							
							}
							
						}
					
					
					?>
						</ol>
						
						
						<span style="color:red;">Tesis proporcionadas por el académico </span>
						
						
						<ol id="nuevas2" >
					<?php

						$pubsQuiere2 = getDetallesQuiereAgregarNOSIIATesis($nt);
						
						foreach($pubsQuiere2 as $p) { ?>
						<li>
						Título: <?= utf8_encode($p['tituloTesis']) ?>, Autor(es):<?= utf8_encode($p['autor']) ?>
						
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
					<center><h4><b><?= $datos[0]['NombreCompleto'] ?></b></h4><h4>Proyectos - <i>Reportados en SISEPRO-UNAM</i> </h4></center>
					<p onclick="abrePendientes()" style="float:right;">En proceso de validación <img width="40px" src="imagenes/buying-books.png" />
					</p>
					<br>
					
                    <hr style="margin-bottom:0px;">
					
				</div>
			</div>
			
			<?php
				$lista = getProyectosSISEPRO($nt);
			?>
			<div class="row">
				
				<div class="col-md-12" style="height: 500px; overflow: auto;"  >
			
				
				<form id="paraBorrar" >
					<input type="hidden" name="nt" value="<?= $nt ?>" />

						<table id="example" style="font-size:12px;  " class="display" cellspacing="0" >
				
							<thead>
								<tr>
									<th>#</th>
									<th>Convocatoria</th>
									<th>Nombre</th>
									<th>Rol</th>
									<th>Participantes</th>
									<th>Fecha inicio</th>
									<th>Fecha fin</th>
									<th>Confirmar/Desvincular</th>			
								</tr>
							</thead>
 
							<tbody>
									
							<?php
									
							$contador = 1;
							foreach($lista as $l) {
								
								//Obtener directores
								$id = $l['RefProyecto'];
								
								$cadenaParticipantes="";
								
								$autores = getParticipantesProyectosSISEPRO($id);
								foreach($autores as $d) {
									$cadenaParticipantes .= $d['NombreCompleto']. ", ";
								}
								
								$fi = explode(' ',$l['FechaInicio']);
								$fbien = explode('-',$fi[0]);
								
								$fi2 = explode(' ',$l['FechaFin']);
								$fbien2 = explode('-',$fi2[0]);
								
								
								
								?>
								<tr>
									<td><?= $contador ?></td>
									<td><?= utf8_encode($l['Convocatoria']) ?></td>
									<td><?= utf8_encode($l['Nombre']) ?></td>
									<td><?= utf8_encode($l['TipoParticipacion']) ?></td>
									<td><?= utf8_encode($cadenaParticipantes) ?></td>
									<td><?= utf8_encode($fbien[2].'-'.$fbien[1].'-'.$fbien[0]) ?></td>
									<td><?= utf8_encode($fbien2[2].'-'.$fbien2[1].'-'.$fbien2[0]) ?></td>
									
											
								<?php
												
								if(in_array($id, $arrValidadas)) { ?>
													
									<td>
										<div id="opcion_<?=$contador?>">
											<p id="parrafoDes_<?= $contador ?>" style="color:blue;">Proyecto validado por el académico</p><button id="botonDesv_<?= $contador ?>" onclick="revierteConf(<?= $contador ?>, <?=  $id ?>)">Revertir esta acción</button>
										</div>
									</td>
									<?php		
								} else if (in_array($id, $arrPorBorrar)) { ?>				
									<td>
										<div id="opcion_<?=$contador?>">
											<p id="parrafoConf_<?= $contador ?>" style="color:blue;">Proyecto en revisión para desvincular </p><button id="botonConf_<?= $contador ?>" onclick="revierteDes(<?= $contador ?>, <?=  $id ?>)">Revertir esta acción</button>
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
			
			
			<div class="row" style="margin-top:20px;">
				<div class="col-md-12">
				
					
				
					<button type="button" onclick="abreAgregar()" class="btn btn-info" style="float:right; margin-left:50px;" ><span class="glyphicon glyphicon-plus"></span> Agregar Proyecto </button>
					
					<button type="button" class="btn btn-success" onclick="guardarCambios()">Aplicar cambios</button>
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


<script>
$('select.changeStatus').change(function(){
	var conv = $( "#convocatoria option:selected" ).val();
	$.ajax({
		type: 'POST',
		url: 'areasProyectos.php',
		data: {convocatoria:conv},
		success:function(data) {  
			$('#areaC').html(data);  
		}
    });
	
});
</script>

<script>
	function ponNombresProyectos() {
		var conv = $( "#convocatoria option:selected" ).val();
		var a = $( "#areaC option:selected" ).val();
		$.ajax({
			type: 'POST',
			url: 'nombresProyectos.php',
			data: {convocatoria:conv, area: a},
			success:function(data) {  
				$('#nomProy').html(data);  
			}
		});
	}
</script>





<?php
	include("footer.php");
?>

	</body>
</html>