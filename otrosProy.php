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
					<p>Agregue el Proyecto en el que participó</p>
					
					<form id="paraBuscar">
						<div class="form-group">
						
							<div class="row">
								<div class="col-sm-12">

								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Nombre del proyecto <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" />
									</div>
								</div>
								
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Clave presupuestal:</label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" />
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Enfoque <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-4">
										<div class="radio">
											<label><input type="radio">Disciplinario</label>
										</div>
										<div class="radio">
											<label><input type="radio">Interdisciplinario</label>
										</div>
										<div class="radio">
											<label><input type="radio">Multidisciplinario</label>
										</div>
									</div>
									
									<div class="col-sm-1">
									<label for="sel1">Tipo <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-4">
										<div class="radio">
											<label><input type="radio">Principal</label>
										</div>
										<div class="radio">
											<label><input type="radio">Derivado</label>
										</div>
										<div class="radio">
											<label><input type="radio">Secundario</label>
										</div>
									</div>
									
									
									
								</div>
								
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Disciplina principal <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-4">
										<select id="disc" class="form-control" name="disc" name="disc" onchange="habilitaA()">
											<option value="">Seleccionar </option><option value="DISC-117"> Abundancia y distribución  
</option><option value="DISC-216"> Acabados  
</option><option value="DISC-028"> Acústica  
</option><option value="DISC-274"> Administración  
</option><option value="DISC-233"> Administración de hospitales  
</option><option value="DISC-275"> Administración de la producción  
</option><option value="DISC-296"> Administración de proyectos  
</option><option value="DISC-357"> Administración de sistemas educativos  
</option><option value="DISC-212"> Administración industrial  
</option><option value="DISC-302"> Administración pública  
</option><option value="DISC-146"> Aerodinámica  
</option><option value="DISC-147"> Aeródromos  
</option><option value="DISC-090"> Agricultura en zonas áridas  
</option><option value="DISC-091"> Agricultura en zonas templadas  
</option><option value="DISC-092"> Agricultura en zonas tropicales  
</option><option value="DISC-089"> Agronomía  
</option><option value="DISC-177"> Aire acondicionado y refrigeración  
</option><option value="DISC-417"> Alfabetización y sistemas de escritura  
</option><option value="DISC-070"> Algebra  
</option><option value="DISC-071"> Análisis y análisis funcional  
</option><option value="DISC-006"> Anatomía  
</option><option value="DISC-234"> Anatomía patológica  
</option><option value="DISC-235"> Anestesiología  
</option><option value="DISC-109"> Anestesiología  
</option><option value="DISC-236"> Angiología  
</option><option value="DISC-282"> Antropología  
</option><option value="DISC-283"> Antropología estructural  
</option><option value="DISC-284"> Antropología física  
</option><option value="DISC-285"> Antropología social  
</option><option value="DISC-286"> Antropometría  
</option><option value="DISC-178"> Aparatos y dispositivos térmicos  
</option><option value="DISC-123"> Apicultura  
</option><option value="DISC-419"> Aplicaciones mecanizadas  
</option><option value="DISC-385"> Archivistica  
</option><option value="DISC-291"> Archivonomía  
</option><option value="DISC-386"> Archivos económicos  
</option><option value="DISC-287"> Arqueología  
</option><option value="DISC-221"> Arquitectura  
</option><option value="DISC-473"> Artes plásticas  
</option><option value="DISC-429"> Asesoramiento y orientación  
</option><option value="DISC-001"> Astrofísica  
</option><option value="DISC-000"> Astronomía  
</option><option value="DISC-304"> Auditoria  
</option><option value="DISC-309"> Aumento y disminución de la población  
</option><option value="DISC-163"> Automatización y control  
</option><option value="DISC-124"> Avicultura  
</option><option value="DISC-472"> Bellas artes  
</option><option value="DISC-420"> Bibliografía  
</option><option value="DISC-292"> Bibliología  
</option><option value="DISC-293"> Bibliotecnia  
</option><option value="DISC-294"> Bibliotecología  
</option><option value="DISC-290"> Biblioteconomía  
</option><option value="DISC-007"> Biofísica  
</option><option value="DISC-005"> Biología  
</option><option value="DISC-011"> Biología celular  
</option><option value="DISC-237"> Biología de la reproducción humana  
</option><option value="DISC-008"> Biología marina  
</option><option value="DISC-025"> Biología molecular  
</option><option value="DISC-118"> Biología pesquera  
</option><option value="DISC-009"> Bioquímica  
</option><option value="DISC-107"> Bioquímica agronómica  
</option><option value="DISC-138"> Biotecnología  
</option><option value="DISC-144"> Biotecnología agrícola  
</option><option value="DISC-139"> Biotecnología ambiental  
</option><option value="DISC-142"> Biotecnología animal  
</option><option value="DISC-143"> Biotecnología de alimentos  
</option><option value="DISC-141"> Biotecnología marina  
</option><option value="DISC-140"> Biotecnología vegetal  
</option><option value="DISC-010"> Botánica  
</option><option value="DISC-093"> Botánica agronómica  
</option><option value="DISC-125"> Bovinocultura  
</option><option value="DISC-445"> Cambio social  
</option><option value="DISC-459"> Caracterización de materiales  
</option><option value="DISC-238"> Cardiología  
</option><option value="DISC-421"> Catálogos  
</option><option value="DISC-463"> Cerámicos  
</option><option value="DISC-295"> Ciencia política  
</option><option value="DISC-046"> Ciencias atmosféricas  
</option><option value="DISC-226"> Ciencias de la salud  
</option><option value="DISC-227"> Ciencias de la salud y ambiente  
</option><option value="DISC-458"> Ciencias de materiales  
</option><option value="DISC-362"> Ciencias del aprendizaje  
</option><option value="DISC-228"> Ciencias y servicios de la salud  
</option><option value="DISC-110"> Cirugía  
</option><option value="DISC-268"> Cirugía maxilo-facial  
</option><option value="DISC-276"> Comercialización  
</option><option value="DISC-465"> Compositos  
</option><option value="DISC-158"> Computación  
</option><option value="DISC-411"> Comunicación  
</option><option value="DISC-159"> Comunicaciones  
</option><option value="DISC-412"> Comunicaciones masivas  
</option><option value="DISC-151"> Construcción  
</option><option value="DISC-303"> Contabilidad  
</option><option value="DISC-305"> Contabilidad administrativa  
</option><option value="DISC-306"> Contabilidad financiera  
</option><option value="DISC-307"> Contabilidad fiscal  
</option><option value="DISC-160"> Control  
</option><option value="DISC-470"> Corrosión  
</option><option value="DISC-002"> Cosmología y cosmogenia  
</option><option value="DISC-126"> Cunicultura  
</option><option value="DISC-094"> Dasotomía (producción forestal)  
</option><option value="DISC-308"> Demografía  
</option><option value="DISC-318"> Derecho administrativo  
</option><option value="DISC-319"> Derecho aeronáutico y espacial  
</option><option value="DISC-320"> Derecho agrario y minero  
</option><option value="DISC-321"> Derecho civil  
</option><option value="DISC-322"> Derecho comparado  
</option><option value="DISC-323"> Derecho constitucional  
</option><option value="DISC-324"> Derecho del transporte y transito  
</option><option value="DISC-325"> Derecho financiero  
</option><option value="DISC-326"> Derecho fiscal  
</option><option value="DISC-327"> Derecho internacional  
</option><option value="DISC-328"> Derecho laboral  
</option><option value="DISC-329"> Derecho marítimo  
</option><option value="DISC-330"> Derecho mercantil  
</option><option value="DISC-331"> Derecho notarial  
</option><option value="DISC-332"> Derecho penal  
</option><option value="DISC-333"> Derecho político  
</option><option value="DISC-334"> Derecho procesal  
</option><option value="DISC-335"> Derecho romano  
</option><option value="DISC-336"> Derecho social  
</option><option value="DISC-317"> Derecho y jurisprudencia  
</option><option value="DISC-239"> Dermatología  
</option><option value="DISC-297"> Desarrollo de la comunidad  
</option><option value="DISC-338"> Desarrollo económico  
</option><option value="DISC-339"> Desarrollo económico regional  
</option><option value="DISC-474"> Dibujo  
</option><option value="DISC-358"> Didáctica (c. de la enseñanza)  
</option><option value="DISC-119"> Dinámica de población  
</option><option value="DISC-298"> Diplomacia  
</option><option value="DISC-169"> Diseño  
</option><option value="DISC-199"> Diseño de componentes de reactores  
</option><option value="DISC-222"> Diseño y proyecto  
</option><option value="DISC-095"> Divulgación y extensión agrícola  
</option><option value="DISC-012"> Ecología  
</option><option value="DISC-337"> Economía  
</option><option value="DISC-340"> Economía agrícola  
</option><option value="DISC-359"> Economía de la educación  
</option><option value="DISC-341"> Economía del sector público  
</option><option value="DISC-342"> Economía del trabajo  
</option><option value="DISC-355"> Economía forestal  
</option><option value="DISC-343"> Economía industrial  
</option><option value="DISC-344"> Economía pesquera  
</option><option value="DISC-345"> Economía política  
</option><option value="DISC-026" > Edafología  
</option><option value="DISC-356"> Educación  
</option><option value="DISC-170"> Eficiencia  
</option><option value="DISC-223"> Ejecución de la obra  
</option><option value="DISC-029"> Electromagnetismo  
</option><option value="DISC-161"> Electrónica  
</option><option value="DISC-200"> Elementos combustibles para reactores  
</option><option value="DISC-013"> Embriología  
</option><option value="DISC-240"> Endocrinología y nutriología  
</option><option value="DISC-269"> Endodoncia  
</option><option value="DISC-418"> Enseñanza social  
</option><option value="DISC-096"> Entomología agrícola  
</option><option value="DISC-480"> Epistemología  
</option><option value="DISC-047"> Espacio exterior  
</option><option value="DISC-072"> Estadística  
</option><option value="DISC-310"> Estadística de la población  
</option><option value="DISC-097"> Estadística y calculo aplicados a la agronomía  
</option><option value="DISC-311"> Estado físico de la población  
</option><option value="DISC-481"> Estética  
</option><option value="DISC-059"> Estratigrafía  
</option><option value="DISC-152"> Estructuras  
</option><option value="DISC-447"> Estudios de la comunidad  
</option><option value="DISC-346"> Estudios de mercados  
</option><option value="DISC-370"> Ética  
</option><option value="DISC-288"> Etnología  
</option><option value="DISC-446"> Etología humana  
</option><option value="DISC-347"> Evaluación de proyectos  
</option><option value="DISC-014"> Evolución  
</option><option value="DISC-270"> Exodoncia  
</option><option value="DISC-208"> Exploración  
</option><option value="DISC-048"> Exploración geofísica  
</option><option value="DISC-209"> Explotación  
</option><option value="DISC-189"> Explotación de minas  
</option><option value="DISC-229"> Farmacia  
</option><option value="DISC-230"> Farmacobiologia  
</option><option value="DISC-479"> Farmacología  
</option><option value="DISC-477"> Farmacología y toxicología  
</option><option value="DISC-427"> Filología  
</option><option value="DISC-369"> Filosofía  
</option><option value="DISC-371"> Filosofía antigua  
</option><option value="DISC-372"> Filosofía contemporánea  
</option><option value="DISC-373"> Filosofía de la ciencia  
</option><option value="DISC-360"> Filosofía de la educación  
</option><option value="DISC-374"> Filosofía de la historia  
</option><option value="DISC-482"> Filosofía de la mente  
</option><option value="DISC-375"> Filosofía de las religiones  
</option><option value="DISC-376"> Filosofía del conocimiento  
</option><option value="DISC-377"> Filosofía del derecho  
</option><option value="DISC-378"> Filosofía del lenguaje  
</option><option value="DISC-379"> Filosofía medieval  
</option><option value="DISC-380"> Filosofía moderna  
</option><option value="DISC-381"> Filosofía política  
</option><option value="DISC-277"> Finanzas  
</option><option value="DISC-027"> Física  
</option><option value="DISC-030"> Física atómica y molecular  
</option><option value="DISC-031"> Física de fluidos  
</option><option value="DISC-032"> Física del espacio  
</option><option value="DISC-033"> Física del estado sólido  
</option><option value="DISC-049"> Física del interior de la tierra  
</option><option value="DISC-034"> Física medica  
</option><option value="DISC-035"> Física nuclear  
</option><option value="DISC-036"> Física teórica  
</option><option value="DISC-037"> Física térmica o termofísica  
</option><option value="DISC-044"> Fisicoquímica  
</option><option value="DISC-015"> Fisiología  
</option><option value="DISC-098"> Fisiología vegetal en agronomía  
</option><option value="DISC-099"> Fitopatología en agronomía  
</option><option value="DISC-100"> Fitotecnia  
</option><option value="DISC-422"> Fonética  
</option><option value="DISC-132"> Forrajes  
</option><option value="DISC-241"> Gastroenterología  
</option><option value="DISC-164"> Generación  
</option><option value="DISC-016"> Genética  
</option><option value="DISC-101"> Genética agronómica  
</option><option value="DISC-242"> Genética medica  
</option><option value="DISC-050"> Geodesia  
</option><option value="DISC-045"> Geofísica  
</option><option value="DISC-051"> Geofísica marina  
</option><option value="DISC-054"> Geografía  
</option><option value="DISC-055"> Geografía económica  
</option><option value="DISC-056"> Geografía física  
</option><option value="DISC-057"> Geografía humana  
</option><option value="DISC-060"> Geohidrologia  
</option><option value="DISC-058"> Geología  
</option><option value="DISC-061"> Geología económica  
</option><option value="DISC-190"> Geología estructural  
</option><option value="DISC-062"> Geología marina  
</option><option value="DISC-052"> Geomagnetismo  
</option><option value="DISC-073"> Geometría  
</option><option value="DISC-063"> Geomorfología  
</option><option value="DISC-064"> Geoquímica  
</option><option value="DISC-243"> Ginecología y obstetricia  
</option><option value="DISC-244"> Hematología  
</option><option value="DISC-111"> Higiene veterinaria y salud publica  
</option><option value="DISC-217"> Hilatura  
</option><option value="DISC-017"> Histología  
</option><option value="DISC-384"> Historia  
</option><option value="DISC-387"> Historia antigua  
</option><option value="DISC-388"> Historia contemporánea  
</option><option value="DISC-483"> Historia de la cultura  
</option><option value="DISC-361"> Historia de la educación  
</option><option value="DISC-389"> Historia de la filosofía  
</option><option value="DISC-484"> Historia de la historiografía  
</option><option value="DISC-390"> Historia de las ciencias  
</option><option value="DISC-299"> Historia de las doctrinas políticas  
</option><option value="DISC-391"> Historia de las etapas coloniales  
</option><option value="DISC-392"> Historia de las ideas  
</option><option value="DISC-393"> Historia de las instituciones  
</option><option value="DISC-394"> Historia de las religiones  
</option><option value="DISC-395"> Historia del arte  
</option><option value="DISC-396"> Historia del derecho  
</option><option value="DISC-397"> Historia diplomática  
</option><option value="DISC-398"> Historia económica  
</option><option value="DISC-399"> Historia medieval  
</option><option value="DISC-400"> Historia militar  
</option><option value="DISC-401"> Historia moderna  
</option><option value="DISC-485"> Historia política  
</option><option value="DISC-486"> Historia regional  
</option><option value="DISC-402"> Historia social  
</option><option value="DISC-403"> Historias continentales regionales  
</option><option value="DISC-404"> Historias nacionales regionales  
</option><option value="DISC-106"> Hortalizas  
</option><option value="DISC-405"> Iconografía  
</option><option value="DISC-245"> Infectología  
</option><option value="DISC-414"> Información  
</option><option value="DISC-145"> Ingeniería aeronáutica  
</option><option value="DISC-102"> Ingeniería agronómica  
</option><option value="DISC-469"> Ingeniería ambiental  
</option><option value="DISC-150"> Ingeniería civil  
</option><option value="DISC-173"> Ingeniería costera  
</option><option value="DISC-157"> Ingeniería de com. elect. y control  
</option><option value="DISC-120"> Ingeniería de los recursos pesqueros  
</option><option value="DISC-461"> Ingeniería de materiales  
</option><option value="DISC-466"> Ingeniería de procesos  
</option><option value="DISC-201"> Ingeniería de reactores nucleares  
</option><option value="DISC-162"> Ingeniería eléctrica  
</option><option value="DISC-168"> Ingeniería industrial  
</option><option value="DISC-172"> Ingeniería marina y portuaria  
</option><option value="DISC-176"> Ingeniería mecánica  
</option><option value="DISC-188"> Ingeniería minera  
</option><option value="DISC-174"> Ingeniería naval  
</option><option value="DISC-198"> Ingeniería nuclear  
</option><option value="DISC-207"> Ingeniería petrolera  
</option><option value="DISC-175"> Ingeniería portuaria  
</option><option value="DISC-211"> Ingeniería química  
</option><option value="DISC-191"> Ingeniería química metalúrgica  
</option><option value="DISC-202"> Ingeniería química nuclear  
</option><option value="DISC-153"> Ingeniería sanitaria  
</option><option value="DISC-215"> Ingeniería textil  
</option><option value="DISC-018"> Inmunología  
</option><option value="DISC-246"> Inmunología clínica y alergias  
</option><option value="DISC-165"> Instalaciones eléctricas e iluminación  
</option><option value="DISC-003"> Instrumentación  
</option><option value="DISC-112"> Instrumentación control y normas  
</option><option value="DISC-103"> Instrumentación en agronomía  
</option><option value="DISC-203"> Instrumentación nuclear  
</option><option value="DISC-179"> Instrumentación y control  
</option><option value="DISC-300"> Integración regional  
</option><option value="DISC-348"> Integración y bloques de comercio  
</option><option value="DISC-460"> Interfases y superficies  
</option><option value="DISC-278"> Investigación de operaciones  
</option><option value="DISC-247"> Laboratorio clínico  
</option><option value="DISC-487"> Lenguajes en relación con otros campos  
</option><option value="DISC-416"> Lingüística  
</option><option value="DISC-289"> Lingüística antropológica  
</option><option value="DISC-423"> Lingüística descriptiva  
</option><option value="DISC-488"> Lingüística histórica  
</option><option value="DISC-424"> Lingüística histórica y comparada  
</option><option value="DISC-426"> Literatura  
</option><option value="DISC-489"> Literatura, filosofía y bellas artes  
</option><option value="DISC-382"> Lógica  
</option><option value="DISC-133"> Manejo de pastizales  
</option><option value="DISC-180"> Mantenimiento  
</option><option value="DISC-166"> Maquinas eléctricas  
</option><option value="DISC-181"> Maquinas térmicas  
</option><option value="DISC-069"> Matemáticas  
</option><option value="DISC-074"> Matemáticas de la utilización de recursos  
</option><option value="DISC-467"> Materiales funcionales  
</option><option value="DISC-004"> Mecánica celeste  
</option><option value="DISC-038"> Mecánica clásica  
</option><option value="DISC-182"> Mecánica de fluidos  
</option><option value="DISC-183"> Mecánica de materiales  
</option><option value="DISC-192"> Mecánica de rocas  
</option><option value="DISC-154"> Mecánica de suelos  
</option><option value="DISC-184"> Mecánica del formado y corte de metales  
</option><option value="DISC-040"> Mecánica estadística  
</option><option value="DISC-039"> Mecánica quántica  
</option><option value="DISC-232"> Medicina  
</option><option value="DISC-248"> Medicina de rehabilitación  
</option><option value="DISC-249"> Medicina del trabajo  
</option><option value="DISC-250"> Medicina nuclear  
</option><option value="DISC-108"> Medicina veterinaria  
</option><option value="DISC-415"> Medios de comunicación  
</option><option value="DISC-363"> Medios educativos  
</option><option value="DISC-134"> Mejoramiento genético  
</option><option value="DISC-383"> Metafísica  
</option><option value="DISC-462"> Metales  
</option><option value="DISC-193"> Metalurgia  
</option><option value="DISC-448"> Metodología  
</option><option value="DISC-349"> Metodología y métodos  
</option><option value="DISC-019"> Microbiología  
</option><option value="DISC-194"> Mineralogía  
</option><option value="DISC-471"> Modelación  
</option><option value="DISC-113"> Morfología  
</option><option value="DISC-312"> Mortalidad  
</option><option value="DISC-475"> Música  
</option><option value="DISC-313"> Natalidad  
</option><option value="DISC-251"> Nefrología  
</option><option value="DISC-252"> Neumología  
</option><option value="DISC-266"> Neurociencias  
</option><option value="DISC-253"> Neurología  
</option><option value="DISC-406"> Numismática  
</option><option value="DISC-314"> Nupcialidad  
</option><option value="DISC-135"> Nutrición y alimentación  
</option><option value="DISC-114"> Obstetricia  
</option><option value="DISC-078"> Oceanografía  
</option><option value="DISC-082"> Oceanografía biológica  
</option><option value="DISC-079"> Oceanografía descriptiva  
</option><option value="DISC-080"> Oceanografía física  
</option><option value="DISC-081"> Oceanografía química  
</option><option value="DISC-267"> Odontología  
</option><option value="DISC-254"> Oftalmología  
</option><option value="DISC-255"> Ontología  
</option><option value="DISC-204"> Operación y mantenimiento de reactores  
</option><option value="DISC-041"> Óptica  
</option><option value="DISC-449"> Organización social estructura e instituciones  
</option><option value="DISC-271"> Ortodoncia  
</option><option value="DISC-256"> Otorrinolaringología  
</option><option value="DISC-127"> Ovinocultura  
</option><option value="DISC-407"> Paleografía  
</option><option value="DISC-020"> Paleontología  
</option><option value="DISC-272"> Paradoncia  
</option><option value="DISC-430"> Parasicología  
</option><option value="DISC-021"> Parasitología  
</option><option value="DISC-257"> Parasitología medica  
</option><option value="DISC-042"> Partículas elementales  
</option><option value="DISC-265"> Patología  
</option><option value="DISC-364"> Pedagogía  
</option><option value="DISC-258"> Pediatría medica  
</option><option value="DISC-431"> Personalidad  
</option><option value="DISC-116"> Pesca  
</option><option value="DISC-065"> Petrográfica  
</option><option value="DISC-066"> Petrología  
</option><option value="DISC-128"> Piscicultura  
</option><option value="DISC-490"> Planeación urbana  
</option><option value="DISC-155"> Planeación y sistemas  
</option><option value="DISC-350"> Plantación económica  
</option><option value="DISC-351"> Plantación rural  
</option><option value="DISC-352"> Plantación urbana  
</option><option value="DISC-185"> Plantas hidráulicas  
</option><option value="DISC-205"> Plantas nucleares  
</option><option value="DISC-186"> Plantas térmicas  
</option><option value="DISC-043"> Plasmas  
</option><option value="DISC-450"> Población  
</option><option value="DISC-464"> Polímeros  
</option><option value="DISC-365"> Política educativa  
</option><option value="DISC-425"> Políticas del lenguaje  
</option><option value="DISC-129"> Porcinocultura  
</option><option value="DISC-224"> Prefabricación e industrialización en construcción  
</option><option value="DISC-408"> Prehistoria  
</option><option value="DISC-218"> Preparación para el tejido  
</option><option value="DISC-075"> Probabilidad  
</option><option value="DISC-353"> Problemas de economía internacional  
</option><option value="DISC-451"> Problemas sociales, desorganización social  
</option><option value="DISC-213"> Proceso  
</option><option value="DISC-315"> Procesos migratorios  
</option><option value="DISC-187"> Producción y manufactura  
</option><option value="DISC-279"> Promoción y desarrollo de organizaciones  
</option><option value="DISC-121"> Prospección de recursos  
</option><option value="DISC-195"> Prospección minera  
</option><option value="DISC-273"> Prótesis  
</option><option value="DISC-214"> Proyectos  
</option><option value="DISC-443"> Psicoanálisis  
</option><option value="DISC-428"> Psicología  
</option><option value="DISC-432"> Psicología clínica  
</option><option value="DISC-433"> Psicología criminal  
</option><option value="DISC-434"> Psicología cultural  
</option><option value="DISC-435"> Psicología de la ingeniería  
</option><option value="DISC-436"> Psicología del desarrollo  
</option><option value="DISC-437"> Psicología educacional  
</option><option value="DISC-366"> Psicología educativa  
</option><option value="DISC-438"> Psicología en medicina  
</option><option value="DISC-439"> Psicología escolar  
</option><option value="DISC-440"> Psicología experimental comparada fisiológica  
</option><option value="DISC-441"> Psicología industrial y laboral  
</option><option value="DISC-452"> Psicología social  
</option><option value="DISC-442"> Psicometría  
</option><option value="DISC-259"> Psiquiatría  
</option><option value="DISC-413"> Publicidad  
</option><option value="DISC-083"> Química  
</option><option value="DISC-084"> Química analítica  
</option><option value="DISC-086"> Química de polímetros  
</option><option value="DISC-087"> Química inorgánica  
</option><option value="DISC-088"> Química nuclear  
</option><option value="DISC-085"> Química orgánica  
</option><option value="DISC-022"> Radiobiología  
</option><option value="DISC-260"> Radiodiagnóstico  
</option><option value="DISC-115"> Radiología  
</option><option value="DISC-280"> Recursos humanos  
</option><option value="DISC-210"> Refinación  
</option><option value="DISC-367"> Reforma educativa  
</option><option value="DISC-301"> Relaciones internacionales  
</option><option value="DISC-316"> Reparto y composición de la población  
</option><option value="DISC-136"> Reproducción  
</option><option value="DISC-261"> Reumatología  
</option><option value="DISC-262"> Salud publica  
</option><option value="DISC-067"> Sedimentología  
</option><option value="DISC-409"> Sigilografía  
</option><option value="DISC-196"> Simulación de yacimientos  
</option><option value="DISC-468"> Síntesis  
</option><option value="DISC-053"> Sismología  
</option><option value="DISC-171"> Sistemas  
</option><option value="DISC-281"> Sistemas de información  
</option><option value="DISC-148"> Sistemas de propulsión  
</option><option value="DISC-167"> Sistemas eléctricos de potencia  
</option><option value="DISC-453"> Sociografía  
</option><option value="DISC-444"> Sociología  
</option><option value="DISC-457"> Sociología de cultura  
</option><option value="DISC-368"> Sociología de la educación  
</option><option value="DISC-456"> Sociología política  
</option><option value="DISC-454"> Sociología rural  
</option><option value="DISC-455"> Sociología urbana  
</option><option value="DISC-023"> Taxonomía  
</option><option value="DISC-476"> Teatro  
</option><option value="DISC-130"> Tecnología de alimentos  
</option><option value="DISC-104"> Tecnología de alimentos  
</option><option value="DISC-137"> Tecnología de productos pecuarios  
</option><option value="DISC-231"> Tecnología farmacéutica  
</option><option value="DISC-068"> Tectónica  
</option><option value="DISC-219"> Tejido  
</option><option value="DISC-220"> Tejido de punto  
</option><option value="DISC-410"> Teoría de documentos  
</option><option value="DISC-491"> Teoría de la historia  
</option><option value="DISC-076"> Teoría de los números  
</option><option value="DISC-492"> Teoría del conocimiento  
</option><option value="DISC-354"> Teoría económica  
</option><option value="DISC-197"> Topografía de minas  
</option><option value="DISC-077"> Topología  
</option><option value="DISC-478"> Toxicología  
</option><option value="DISC-206"> Transferencia térmica en reactores  
</option><option value="DISC-149"> Transporte aéreo  
</option><option value="DISC-263"> Traumatología y ortopedia  
</option><option value="DISC-225"> Urbanismo  
</option><option value="DISC-264"> Urología  
</option><option value="DISC-156"> Vías terrestres  
</option><option value="DISC-024"> Zoología  
</option><option value="DISC-122"> Zootecnia  
</option><option value="DISC-105"> Zootecnia en agronomía  
</option><option value="DISC-131"> Zootecnia general
</option>
</option><option value="9"> Otra
</option>
										</select>
									</div>
									
									<div class="col-sm-1">
									<label for="sel1">Otra:</label>
									</div>
									<div class="col-sm-4">
										<input type="input" class="form-control" name="otro1" id="otro1" disabled />
									</div>
									
									
								</div>
											
								
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Descripción del proyecto <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
										<textarea class="form-control" rows="4">
										
										</textarea>
									</div>
								</div>
								
						
								<div class="row" style="margin-top:6px;">
									<div class="col-sm-3">
									<label for="sel1">Fecha de inicio <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-4">
										<input type="date" class="form-control" />
									</div>
									
									
									<div class="col-sm-1">
										<label for="sel1">Fecha fin:</label>
									</div>
									
									<div class="col-sm-4">
										<input type="date" class="form-control" />
									</div>
									
									
								</div>
							
								
								<div class="row" style="margin-top:6px;">
									<div class="col-sm-3">
									<label for="sel1">Tipo de apoyo <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
										<select id="calidad" class="form-control" name="calidad">
											<option value="0">Seleccionar</option>
											<option value="D">Apoyo CONACyT</option>
											<option value="C1">Apoyo nacional gubernamental</option>
											<option value="SR">Apoyo nacional no gubernamental</option>
											<option value="R1">Apoyo internacional gubernamental</option>
											<option value="R2">Apoyo internacional no gubernamental</option>
										</select>
									</div>
								</div>
								
								
								<div class="row" style="margin-top:6px;">
									<div class="col-sm-3">
									<label for="sel1">No. alumnos UNAM:</label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" />
									</div>
									
								</div>
								
								<div class="row" style="margin-top:6px;">
									<div class="col-sm-3">
									<label for="sel1">No. alumnos externos:</label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" />
									</div>
									
								</div>
								
								<br>
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Observaciones:</label>
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
										<button type="button" class="btn btn-primary" onclick="agregarPubs()">Aceptar</button>
									</div>
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
					<p>Proporciona los siguientes datos</p>
					<form id="paraAgregarNuevoArt">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-2">
									<label for="sel1">Convocatoria:</label>
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
									<label for="sel1">Área:</label>
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
											<label for="sel1">Nombre:</label>
										</div>
										<div class="col-sm-10">
											<input type="text" class="form-control"  />
										</div>
									</div>
								
								</div>
								
								<div class="row" style="margin-top:7px;">
									<div class="col-sm-12">
										<div class="col-sm-2">
											<label for="sel1">Rol:</label>
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
											<label for="sel1">Fecha inicio:</label>
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
					<center><h4><b><?= $datos[0]['NombreCompleto'] ?></b></h4><h4>Proyectos - <i>Otros proyectos</i> </h4></center>
					<p onclick="abrePendientes()" style="float:right;">En proceso de validación <img width="40px" src="imagenes/buying-books.png" />
					</p>
					<br>
					
                    <hr style="margin-bottom:0px;">
					
				</div>
			</div>
			
			<?php
				//$lista = getProyectosSISEPRO($nt);
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



<script>
	function habilitaA() {
		tipo=$("#disc").val();
		if(tipo==9) {
			$("#otro1").attr('disabled', false);
		} else {
			$("#otro1").val("");
			$("#otro1").attr('disabled', true);
		}
	}
</script>


<?php
	include("footer.php");
?>

	</body>
</html>