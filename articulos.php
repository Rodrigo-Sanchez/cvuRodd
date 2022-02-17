<?php

	include("m/funciones.php");
	//$nt = $_GET['nt'];
	session_start();
	$nt = $_SESSION['nt'];
	$datos = getInfoPersonalAcademico($nt);
	$ptotales = count(getListaPublicaciones($nt));
	
	$pubsValidadas=getValidadas($nt);
	$arrValidadas = array();
	
	$pubsParaBorrar=getPorBorrar($nt);
	$arrPorBorrar = array();
	
	foreach($pubsValidadas as $p) {
		$arrValidadas[] = $p['idPublicacionSIIA'];
	}
	
	foreach($pubsParaBorrar as $p) {
		$arrPorBorrar[] = $p['idPublicacionSIIA'];
	}
	
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<link rel='stylesheet prefetch' href='https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css'>

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
					url:"borrarPubDirecto.php",  
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
					url:"borrarPubDirecto2.php",  
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
				var dataPubs = $('#publicaciones').serialize();
				//alert(dataPubs);
				$.ajax({  
					url:"agregarPublicaciones.php",  
					method:"post",  
					data:$('#publicaciones').serialize(),  
					success:function(data) {  
						alert("Publicación agregada exitosamente");	
						$("#nuevas").append(data);	
						$("#mi-modal2").modal('hide');//ocultamos el modal
						$('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
						$('.modal-backdrop').remove();//eliminamos el backdrop del modal						
						
					}  
				});	
			}
		</script>
		
		<script>
			function prueba() {
				event.preventDefault();

				$.ajax({  
					url:"busquedaPublicaciones.php",  
					method:"post",  
					data:$('#paraBuscar').serialize(),  
					success:function(data) {  
						$('#datos').html(data);						
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
					url:"agregarNuevaPub.php",  
					method:"post",  
					data:$('#paraAgregarNuevoArt').serialize(),  
					success:function(data) {  
						alert("Publicación agregada exitosamente");	
						$("#nuevas2").append(data);	
						$("#mi-modal3").modal('hide');//ocultamos el modal
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
						url:"alterarPublicaciones.php",  
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
									$(cadena).html("<p id='parrafoConf_"+indice+"' style='color:blue;'>Publicación en revisión para desvincular</p><button id='botonConf_"+indice+"' onclick='revierteDes(" + indice + "," + idPub + ")'>Revertir esta acción</button>");
								} else {
									$(cadena).html("<p id='parrafoDes_"+indice+"' style='color:blue;'>Publicación validada por el académico</p><button id='botonDesv_"+indice+"' onclick='revierteConf(" + indice + "," + idPub + ")'>Revertir esta acción</button>");
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
				
				window.open("https://produccion.siia.unam.mx/Publicaciones/ProdCientif/PublicacionFrw.aspx?scopus=0&id="+id, "ventana1", "width=900,height=750,scrollbars=YES");
				
				
				
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
							<p>Agregar publicación</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p>Llena alguno de los siguientes campos para buscar en la Base de datos del SIIA la publicación que quieres añadir a los artículos de tu autoría.</p>
					
					<form id="paraBuscar">
						<div class="form-group">
						
							<div class="row">
								<div class="col-sm-5">
						
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<span>ScopusId</span>
									</div>
									<div class="col-sm-9">
									<input type="text" name="scopusId" class="form-control" />
									</div>
								</div>
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<span>WosId</span>
									</div>
									<div class="col-sm-9">
									<input type="text" name="wosId" class="form-control" />
									</div>
								</div>
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<span>PubMedId</span>
									</div>
									<div class="col-sm-9">
									<input type="text" name="pubmedId" class="form-control" />
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3">
									<span>Título</span>
									</div>
									<div class="col-sm-9">
									<input type="text" name="titulo" class="form-control" />
									<input type="hidden" name="numeroEmpleado" value="<?= $nt ?>" />
									</div>
								</div>
							
								<div class="row">
									<div class="col-sm-3">
									</div>
									<div class="col-sm-9">
									<br>
									<button type="button" class="btn btn-primary" onclick="prueba()">Buscar </button>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
									<br>
									<p>Si la publicación que deseas añadir a tu lista no aparece a pesar de las búsquedas da click <button type="button" onclick="abreRegistroNuevo()" style="padding:2px;" class="btn btn-info">aquí</button> </p>
									</div>
								</div>
							
								</div>
								
								<div class="col-sm-7" style=" height: 350px; overflow-y: auto;">
									<div id="datos">
							
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
							<p>Agregar publicación nueva</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p>Proporciona los siguientes datos</p>
					<form id="paraAgregarNuevoArt">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<span>ISSN <span style="color:red;">*</span></span>
									</div>
									<div class="col-sm-10">
									<input type="text" name="issn" class="form-control" required />
									</div>
								</div>
								</div>
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<span>Título <span style="color:red;">*</span></span>
									</div>
									<div class="col-sm-10">
									<input type="text" name="titulo" class="form-control" required />
									</div>
								</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<span>Eid</span>
									</div>
									<div class="col-sm-10">
									<input type="text" name="eID" class="form-control" />
									</div>
								</div>
								</div>
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<span>Firma<span style="color:red;">*</span></span>
									</div>
									<div class="col-sm-10">
									<input type="text" name="firma" class="form-control" required />
									</div>
								</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<span>Revista</span>
									</div>
									<div class="col-sm-10">
									<input type="text" name="revistaPublicacion" class="form-control" />
									</div>
								</div>
								</div>
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-6">
									<span>Alcance</span>
									</div>
									<div class="col-sm-6">
									<select id="calidad" class="form-control" name="alcance">
										<option value="0">Seleccionar</option>
										<option value="ABR">Abstract Report</option>
										<option value="ART">Article</option>
										<option value="ARP">Article in press</option>
										<option value="BIB">Bibliography</option>
										<option value="BIO">Bibliographical-item</option>
										<option value="BOO">Book</option>
										<option value="CA2">Book Chapter</option>
										<option value="BRV">Book Review</option>
										<option value="BA1">Business Article</option>
										<option value="CAP">Capítulo de un libro</option>
										<option value="CFP">Conference Paper</option>
										<option value="CR1">Conference Review</option>
										<option value="CRC">Correction</option>
										<option value="ED1">Editorial</option>
										<option value="EDM">Editorial Material</option>
										<option value="ERR">Erratum</option>
										<option value="LET">Letter</option>
										<option value="COM">Libro completo</option>
										<option value="MTA">Meeting Abstract</option>
										<option value="NWI">News Item</option>
										<option value="NOT">Note</option>
										<option value="POE">Poetry</option>
										<option value="PRP">Proceedings Paper</option>
										<option value="RCR">Record Review</option>
										<option value="REP">Reprint</option>
										<option value="REV">Review</option>
										<option value="SS1">Short Survey</option>
									</select>
									
									</div>
								</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<span>Año</span>
									</div>
									<div class="col-sm-10">
									<input type="text" name="anioPublicacion" class="form-control" />
									</div>
								</div>
								</div>
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-5">
									<span>En calidad de</span>
									</div>
									<div class="col-sm-7">
									<select id="calidad" class="form-control" name="calidad">
										<option value="0">Seleccionar</option>
										<option value="1">Autor</option>
										<option value="2">Colaborador</option>
										<option value="3">Editor</option>
										<option value="4">Traductor</option>
									</select>
									<input type="hidden" name="numeroEmpleado" value="<?= $nt ?>" />
									</div>
								</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<span>WosId</span>
									</div>
									<div class="col-sm-10">
									<input type="text" name="wosID" class="form-control" />
									</div>
								</div>
								</div>
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<span>ScopusId</span>
									</div>
									<div class="col-sm-10">
									<input type="text" name="scopusID" class="form-control" />
									</div>
									<input type="hidden" name="nt" value="<?= $nt ?>" />
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
							<p>Publicaciones en revisión para agregarse a tu lista</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
				
					 
					
					<?php
					
						$publicacionesQuiereAgregar = getDetallesQuiereAgregar($nt); ?>
						
						<span style="color:red;">Publicaciones SIIA  </span>
						
						
						<ol id="nuevas">
						
					<?php	
						foreach($publicacionesQuiereAgregar as $p) {
									
							$id =  $p['Identificador']; ?>
							<li><a  href="https://produccion.siia.unam.mx/Publicaciones/ProdCientif/PublicacionFrw.aspx?scopus=0&id=<?=$id?>" target="_blank"><?= utf8_encode($p['Titulo']) ?></a></li>
									
							<?php
							
						}
					
					
					?>
						</ol>
						
						
						<span style="color:red;">Publicaciones proporcionadas por el académico </span>
						
						
						<ol id="nuevas2" >
					<?php

						$pubsQuiere2 = getDetallesQuiereAgregarNOSIIA($nt);
						
						foreach($pubsQuiere2 as $p) { ?>
						<li><?= utf8_encode($p['tituloPublicacion']) ?> </li>
								
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
					<center><h4><b><?= $datos[0]['NombreCompleto'] ?></b></h4><h4>Documentos indexados WoS, Scopus y Pubmed - <i>Artículos</i> </h4></center>
					<!--<p onclick="abrePendientes()" >Documentos agregados por el académico en proceso de validación <img width="40px" src="imagenes/buying-books.png" />
					</p>-->
					
					<!--<br>
					<button type="button" onclick="abrePendientes()" style="float:right;" class="btn btn-warning">  <span class="glyphicon glyphicon-eye-open"></span> Ver documentos en proceso de validación</button> -->
					
					
					<br>
					
                    <hr style="margin-bottom:0px;">
					
				</div>
			</div>
			
			<?php
				$lista = getListaPublicaciones($nt);
			?>
			<div class="row">
				
				<div class="col-md-12" style="height: 500px; overflow: auto;"  >
			
				<form id="paraBorrar" >
					<input type="hidden" name="nt" value="<?= $nt ?>" />

						<table id="example" style="font-size:12px;  " class="display" cellspacing="0" >
				
							<thead>
								<tr>
									<th>#</th>
									<th>Título</th>
									<th>Revista</th>
									<th>Autores</th>
									<th>Fuente</th>
									<th>Año</th>
									<th>Confirmar/Desvincular</th>			
								</tr>
							</thead>
 
							<tbody>
									
							<?php
									
							$contador = 1;
							foreach($lista as $l) {
											
								$identificador = $l['Identificador'];
								$autores = getAutores($identificador);			
								$cadenaAutores="";
								$cuentaAutores=1;
								
								foreach($autores as $a) {
									if($cuentaAutores<=3) {
										$cadenaAutores .= $a['NombreCompleto'].", ";
									} else {
										$cadenaAutores .= "et al.";
										break;
									}
									$cuentaAutores++;
								}
											
								$info = getFuentesYCitas($identificador);				
								$cadenaIDS="";
								$citasWos=0;
								$citasScopus=0;
											
								foreach($info as $i) {
									if($i['CodigoFuente']=="000") {
										$cadenaIDS .= "Wos-id: ".$i['Localizador']."<br>";
									}
									
									if($i['CodigoFuente']=="010") {
										$cadenaIDS .= "Scopus-id: ".$i['Localizador']."<br>";
									}
									
									if($i['CodigoFuente']=="015") {
										$cadenaIDS .= "PubMed-id: ".$i['Localizador'];
									}
									
								}
								?>
								<tr>
									<td><?= $contador ?></td>
									<!-- tenía $id en lugar de $identificador y no se abría la URL-->
									<td><p ><a href="https://produccion.siia.unam.mx/Publicaciones/ProdCientif/PublicacionFrw.aspx?scopus=0&id=<?=$identificador?>" target="_blank"><?= utf8_encode($l['Titulo']) ?></a></p> <p style="color:blue;" onclick="ponFrame(<?= $identificador ?>)" >- Ver detalles</p></td>
									<td><?= utf8_encode($l['RevistaTitulo']) ?></td>
									<td><?= utf8_encode($cadenaAutores) ?></td>
									<td><?= $cadenaIDS ?></td>
									<td><?= $l['anio'] ?></td>
											
								<?php
												
								if(in_array($identificador, $arrValidadas)) { ?>
													
									<td>
										<div id="opcion_<?=$contador?>">
											<p id="parrafoDes_<?= $contador ?>" style="color:blue;">Publicación validada por el académico</p><button id="botonDesv_<?= $contador ?>" onclick="revierteConf(<?= $contador ?>, <?=  $identificador ?>)">Revertir esta acción</button>
										</div>
									</td>
									<?php		
								} else if (in_array($identificador, $arrPorBorrar)) { ?>				
									<td>
										<div id="opcion_<?=$contador?>">
											<p id="parrafoConf_<?= $contador ?>" style="color:blue;">Publicación en revisión para desvincular </p><button id="botonConf_<?= $contador ?>" onclick="revierteDes(<?= $contador ?>, <?=  $identificador ?>)">Revertir esta acción</button>
										</div>
									</td>
											
								<?php
								} else { ?>

									<td>
										<div id="opcion_<?=$contador?>">
											<div class="radio">
												<label><input type="radio" name="ids_<?=$contador?>" value="<?= $identificador ?>-1">Confirmar</label>
											</div>
											<div class="radio">
												<label><input type="radio" name="ids_<?=$contador?>" value="<?= $identificador ?>-0">Desvincular</label>
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
					<button type="button" onclick="abreAgregar()" class="btn btn-info" style="float:right; margin-left:50px;" ><span class="glyphicon glyphicon-plus"></span> Agregar publicación SIIA</button>
					
					<button type="button" onclick="abrePendientes()" style="float:right;" class="btn btn-warning">  <span class="glyphicon glyphicon-eye-open"></span> Ver documentos en proceso de validación</button>
					
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

<?php
	include("footer.php");
?>

	</body>
</html>