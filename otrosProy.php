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
							<p>Agregar Proyecto</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p>Agregue el Proyecto en el que particip??</p>
					
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
											<option value="">Seleccionar </option><option value="DISC-117"> Abundancia y distribuci??n  
</option><option value="DISC-216"> Acabados  
</option><option value="DISC-028"> Ac??stica  
</option><option value="DISC-274"> Administraci??n  
</option><option value="DISC-233"> Administraci??n de hospitales  
</option><option value="DISC-275"> Administraci??n de la producci??n  
</option><option value="DISC-296"> Administraci??n de proyectos  
</option><option value="DISC-357"> Administraci??n de sistemas educativos  
</option><option value="DISC-212"> Administraci??n industrial  
</option><option value="DISC-302"> Administraci??n p??blica  
</option><option value="DISC-146"> Aerodin??mica  
</option><option value="DISC-147"> Aer??dromos  
</option><option value="DISC-090"> Agricultura en zonas ??ridas  
</option><option value="DISC-091"> Agricultura en zonas templadas  
</option><option value="DISC-092"> Agricultura en zonas tropicales  
</option><option value="DISC-089"> Agronom??a  
</option><option value="DISC-177"> Aire acondicionado y refrigeraci??n  
</option><option value="DISC-417"> Alfabetizaci??n y sistemas de escritura  
</option><option value="DISC-070"> Algebra  
</option><option value="DISC-071"> An??lisis y an??lisis funcional  
</option><option value="DISC-006"> Anatom??a  
</option><option value="DISC-234"> Anatom??a patol??gica  
</option><option value="DISC-235"> Anestesiolog??a  
</option><option value="DISC-109"> Anestesiolog??a  
</option><option value="DISC-236"> Angiolog??a  
</option><option value="DISC-282"> Antropolog??a  
</option><option value="DISC-283"> Antropolog??a estructural  
</option><option value="DISC-284"> Antropolog??a f??sica  
</option><option value="DISC-285"> Antropolog??a social  
</option><option value="DISC-286"> Antropometr??a  
</option><option value="DISC-178"> Aparatos y dispositivos t??rmicos  
</option><option value="DISC-123"> Apicultura  
</option><option value="DISC-419"> Aplicaciones mecanizadas  
</option><option value="DISC-385"> Archivistica  
</option><option value="DISC-291"> Archivonom??a  
</option><option value="DISC-386"> Archivos econ??micos  
</option><option value="DISC-287"> Arqueolog??a  
</option><option value="DISC-221"> Arquitectura  
</option><option value="DISC-473"> Artes pl??sticas  
</option><option value="DISC-429"> Asesoramiento y orientaci??n  
</option><option value="DISC-001"> Astrof??sica  
</option><option value="DISC-000"> Astronom??a  
</option><option value="DISC-304"> Auditoria  
</option><option value="DISC-309"> Aumento y disminuci??n de la poblaci??n  
</option><option value="DISC-163"> Automatizaci??n y control  
</option><option value="DISC-124"> Avicultura  
</option><option value="DISC-472"> Bellas artes  
</option><option value="DISC-420"> Bibliograf??a  
</option><option value="DISC-292"> Bibliolog??a  
</option><option value="DISC-293"> Bibliotecnia  
</option><option value="DISC-294"> Bibliotecolog??a  
</option><option value="DISC-290"> Biblioteconom??a  
</option><option value="DISC-007"> Biof??sica  
</option><option value="DISC-005"> Biolog??a  
</option><option value="DISC-011"> Biolog??a celular  
</option><option value="DISC-237"> Biolog??a de la reproducci??n humana  
</option><option value="DISC-008"> Biolog??a marina  
</option><option value="DISC-025"> Biolog??a molecular  
</option><option value="DISC-118"> Biolog??a pesquera  
</option><option value="DISC-009"> Bioqu??mica  
</option><option value="DISC-107"> Bioqu??mica agron??mica  
</option><option value="DISC-138"> Biotecnolog??a  
</option><option value="DISC-144"> Biotecnolog??a agr??cola  
</option><option value="DISC-139"> Biotecnolog??a ambiental  
</option><option value="DISC-142"> Biotecnolog??a animal  
</option><option value="DISC-143"> Biotecnolog??a de alimentos  
</option><option value="DISC-141"> Biotecnolog??a marina  
</option><option value="DISC-140"> Biotecnolog??a vegetal  
</option><option value="DISC-010"> Bot??nica  
</option><option value="DISC-093"> Bot??nica agron??mica  
</option><option value="DISC-125"> Bovinocultura  
</option><option value="DISC-445"> Cambio social  
</option><option value="DISC-459"> Caracterizaci??n de materiales  
</option><option value="DISC-238"> Cardiolog??a  
</option><option value="DISC-421"> Cat??logos  
</option><option value="DISC-463"> Cer??micos  
</option><option value="DISC-295"> Ciencia pol??tica  
</option><option value="DISC-046"> Ciencias atmosf??ricas  
</option><option value="DISC-226"> Ciencias de la salud  
</option><option value="DISC-227"> Ciencias de la salud y ambiente  
</option><option value="DISC-458"> Ciencias de materiales  
</option><option value="DISC-362"> Ciencias del aprendizaje  
</option><option value="DISC-228"> Ciencias y servicios de la salud  
</option><option value="DISC-110"> Cirug??a  
</option><option value="DISC-268"> Cirug??a maxilo-facial  
</option><option value="DISC-276"> Comercializaci??n  
</option><option value="DISC-465"> Compositos  
</option><option value="DISC-158"> Computaci??n  
</option><option value="DISC-411"> Comunicaci??n  
</option><option value="DISC-159"> Comunicaciones  
</option><option value="DISC-412"> Comunicaciones masivas  
</option><option value="DISC-151"> Construcci??n  
</option><option value="DISC-303"> Contabilidad  
</option><option value="DISC-305"> Contabilidad administrativa  
</option><option value="DISC-306"> Contabilidad financiera  
</option><option value="DISC-307"> Contabilidad fiscal  
</option><option value="DISC-160"> Control  
</option><option value="DISC-470"> Corrosi??n  
</option><option value="DISC-002"> Cosmolog??a y cosmogenia  
</option><option value="DISC-126"> Cunicultura  
</option><option value="DISC-094"> Dasotom??a (producci??n forestal)  
</option><option value="DISC-308"> Demograf??a  
</option><option value="DISC-318"> Derecho administrativo  
</option><option value="DISC-319"> Derecho aeron??utico y espacial  
</option><option value="DISC-320"> Derecho agrario y minero  
</option><option value="DISC-321"> Derecho civil  
</option><option value="DISC-322"> Derecho comparado  
</option><option value="DISC-323"> Derecho constitucional  
</option><option value="DISC-324"> Derecho del transporte y transito  
</option><option value="DISC-325"> Derecho financiero  
</option><option value="DISC-326"> Derecho fiscal  
</option><option value="DISC-327"> Derecho internacional  
</option><option value="DISC-328"> Derecho laboral  
</option><option value="DISC-329"> Derecho mar??timo  
</option><option value="DISC-330"> Derecho mercantil  
</option><option value="DISC-331"> Derecho notarial  
</option><option value="DISC-332"> Derecho penal  
</option><option value="DISC-333"> Derecho pol??tico  
</option><option value="DISC-334"> Derecho procesal  
</option><option value="DISC-335"> Derecho romano  
</option><option value="DISC-336"> Derecho social  
</option><option value="DISC-317"> Derecho y jurisprudencia  
</option><option value="DISC-239"> Dermatolog??a  
</option><option value="DISC-297"> Desarrollo de la comunidad  
</option><option value="DISC-338"> Desarrollo econ??mico  
</option><option value="DISC-339"> Desarrollo econ??mico regional  
</option><option value="DISC-474"> Dibujo  
</option><option value="DISC-358"> Did??ctica (c. de la ense??anza)  
</option><option value="DISC-119"> Din??mica de poblaci??n  
</option><option value="DISC-298"> Diplomacia  
</option><option value="DISC-169"> Dise??o  
</option><option value="DISC-199"> Dise??o de componentes de reactores  
</option><option value="DISC-222"> Dise??o y proyecto  
</option><option value="DISC-095"> Divulgaci??n y extensi??n agr??cola  
</option><option value="DISC-012"> Ecolog??a  
</option><option value="DISC-337"> Econom??a  
</option><option value="DISC-340"> Econom??a agr??cola  
</option><option value="DISC-359"> Econom??a de la educaci??n  
</option><option value="DISC-341"> Econom??a del sector p??blico  
</option><option value="DISC-342"> Econom??a del trabajo  
</option><option value="DISC-355"> Econom??a forestal  
</option><option value="DISC-343"> Econom??a industrial  
</option><option value="DISC-344"> Econom??a pesquera  
</option><option value="DISC-345"> Econom??a pol??tica  
</option><option value="DISC-026" > Edafolog??a  
</option><option value="DISC-356"> Educaci??n  
</option><option value="DISC-170"> Eficiencia  
</option><option value="DISC-223"> Ejecuci??n de la obra  
</option><option value="DISC-029"> Electromagnetismo  
</option><option value="DISC-161"> Electr??nica  
</option><option value="DISC-200"> Elementos combustibles para reactores  
</option><option value="DISC-013"> Embriolog??a  
</option><option value="DISC-240"> Endocrinolog??a y nutriolog??a  
</option><option value="DISC-269"> Endodoncia  
</option><option value="DISC-418"> Ense??anza social  
</option><option value="DISC-096"> Entomolog??a agr??cola  
</option><option value="DISC-480"> Epistemolog??a  
</option><option value="DISC-047"> Espacio exterior  
</option><option value="DISC-072"> Estad??stica  
</option><option value="DISC-310"> Estad??stica de la poblaci??n  
</option><option value="DISC-097"> Estad??stica y calculo aplicados a la agronom??a  
</option><option value="DISC-311"> Estado f??sico de la poblaci??n  
</option><option value="DISC-481"> Est??tica  
</option><option value="DISC-059"> Estratigraf??a  
</option><option value="DISC-152"> Estructuras  
</option><option value="DISC-447"> Estudios de la comunidad  
</option><option value="DISC-346"> Estudios de mercados  
</option><option value="DISC-370"> ??tica  
</option><option value="DISC-288"> Etnolog??a  
</option><option value="DISC-446"> Etolog??a humana  
</option><option value="DISC-347"> Evaluaci??n de proyectos  
</option><option value="DISC-014"> Evoluci??n  
</option><option value="DISC-270"> Exodoncia  
</option><option value="DISC-208"> Exploraci??n  
</option><option value="DISC-048"> Exploraci??n geof??sica  
</option><option value="DISC-209"> Explotaci??n  
</option><option value="DISC-189"> Explotaci??n de minas  
</option><option value="DISC-229"> Farmacia  
</option><option value="DISC-230"> Farmacobiologia  
</option><option value="DISC-479"> Farmacolog??a  
</option><option value="DISC-477"> Farmacolog??a y toxicolog??a  
</option><option value="DISC-427"> Filolog??a  
</option><option value="DISC-369"> Filosof??a  
</option><option value="DISC-371"> Filosof??a antigua  
</option><option value="DISC-372"> Filosof??a contempor??nea  
</option><option value="DISC-373"> Filosof??a de la ciencia  
</option><option value="DISC-360"> Filosof??a de la educaci??n  
</option><option value="DISC-374"> Filosof??a de la historia  
</option><option value="DISC-482"> Filosof??a de la mente  
</option><option value="DISC-375"> Filosof??a de las religiones  
</option><option value="DISC-376"> Filosof??a del conocimiento  
</option><option value="DISC-377"> Filosof??a del derecho  
</option><option value="DISC-378"> Filosof??a del lenguaje  
</option><option value="DISC-379"> Filosof??a medieval  
</option><option value="DISC-380"> Filosof??a moderna  
</option><option value="DISC-381"> Filosof??a pol??tica  
</option><option value="DISC-277"> Finanzas  
</option><option value="DISC-027"> F??sica  
</option><option value="DISC-030"> F??sica at??mica y molecular  
</option><option value="DISC-031"> F??sica de fluidos  
</option><option value="DISC-032"> F??sica del espacio  
</option><option value="DISC-033"> F??sica del estado s??lido  
</option><option value="DISC-049"> F??sica del interior de la tierra  
</option><option value="DISC-034"> F??sica medica  
</option><option value="DISC-035"> F??sica nuclear  
</option><option value="DISC-036"> F??sica te??rica  
</option><option value="DISC-037"> F??sica t??rmica o termof??sica  
</option><option value="DISC-044"> Fisicoqu??mica  
</option><option value="DISC-015"> Fisiolog??a  
</option><option value="DISC-098"> Fisiolog??a vegetal en agronom??a  
</option><option value="DISC-099"> Fitopatolog??a en agronom??a  
</option><option value="DISC-100"> Fitotecnia  
</option><option value="DISC-422"> Fon??tica  
</option><option value="DISC-132"> Forrajes  
</option><option value="DISC-241"> Gastroenterolog??a  
</option><option value="DISC-164"> Generaci??n  
</option><option value="DISC-016"> Gen??tica  
</option><option value="DISC-101"> Gen??tica agron??mica  
</option><option value="DISC-242"> Gen??tica medica  
</option><option value="DISC-050"> Geodesia  
</option><option value="DISC-045"> Geof??sica  
</option><option value="DISC-051"> Geof??sica marina  
</option><option value="DISC-054"> Geograf??a  
</option><option value="DISC-055"> Geograf??a econ??mica  
</option><option value="DISC-056"> Geograf??a f??sica  
</option><option value="DISC-057"> Geograf??a humana  
</option><option value="DISC-060"> Geohidrologia  
</option><option value="DISC-058"> Geolog??a  
</option><option value="DISC-061"> Geolog??a econ??mica  
</option><option value="DISC-190"> Geolog??a estructural  
</option><option value="DISC-062"> Geolog??a marina  
</option><option value="DISC-052"> Geomagnetismo  
</option><option value="DISC-073"> Geometr??a  
</option><option value="DISC-063"> Geomorfolog??a  
</option><option value="DISC-064"> Geoqu??mica  
</option><option value="DISC-243"> Ginecolog??a y obstetricia  
</option><option value="DISC-244"> Hematolog??a  
</option><option value="DISC-111"> Higiene veterinaria y salud publica  
</option><option value="DISC-217"> Hilatura  
</option><option value="DISC-017"> Histolog??a  
</option><option value="DISC-384"> Historia  
</option><option value="DISC-387"> Historia antigua  
</option><option value="DISC-388"> Historia contempor??nea  
</option><option value="DISC-483"> Historia de la cultura  
</option><option value="DISC-361"> Historia de la educaci??n  
</option><option value="DISC-389"> Historia de la filosof??a  
</option><option value="DISC-484"> Historia de la historiograf??a  
</option><option value="DISC-390"> Historia de las ciencias  
</option><option value="DISC-299"> Historia de las doctrinas pol??ticas  
</option><option value="DISC-391"> Historia de las etapas coloniales  
</option><option value="DISC-392"> Historia de las ideas  
</option><option value="DISC-393"> Historia de las instituciones  
</option><option value="DISC-394"> Historia de las religiones  
</option><option value="DISC-395"> Historia del arte  
</option><option value="DISC-396"> Historia del derecho  
</option><option value="DISC-397"> Historia diplom??tica  
</option><option value="DISC-398"> Historia econ??mica  
</option><option value="DISC-399"> Historia medieval  
</option><option value="DISC-400"> Historia militar  
</option><option value="DISC-401"> Historia moderna  
</option><option value="DISC-485"> Historia pol??tica  
</option><option value="DISC-486"> Historia regional  
</option><option value="DISC-402"> Historia social  
</option><option value="DISC-403"> Historias continentales regionales  
</option><option value="DISC-404"> Historias nacionales regionales  
</option><option value="DISC-106"> Hortalizas  
</option><option value="DISC-405"> Iconograf??a  
</option><option value="DISC-245"> Infectolog??a  
</option><option value="DISC-414"> Informaci??n  
</option><option value="DISC-145"> Ingenier??a aeron??utica  
</option><option value="DISC-102"> Ingenier??a agron??mica  
</option><option value="DISC-469"> Ingenier??a ambiental  
</option><option value="DISC-150"> Ingenier??a civil  
</option><option value="DISC-173"> Ingenier??a costera  
</option><option value="DISC-157"> Ingenier??a de com. elect. y control  
</option><option value="DISC-120"> Ingenier??a de los recursos pesqueros  
</option><option value="DISC-461"> Ingenier??a de materiales  
</option><option value="DISC-466"> Ingenier??a de procesos  
</option><option value="DISC-201"> Ingenier??a de reactores nucleares  
</option><option value="DISC-162"> Ingenier??a el??ctrica  
</option><option value="DISC-168"> Ingenier??a industrial  
</option><option value="DISC-172"> Ingenier??a marina y portuaria  
</option><option value="DISC-176"> Ingenier??a mec??nica  
</option><option value="DISC-188"> Ingenier??a minera  
</option><option value="DISC-174"> Ingenier??a naval  
</option><option value="DISC-198"> Ingenier??a nuclear  
</option><option value="DISC-207"> Ingenier??a petrolera  
</option><option value="DISC-175"> Ingenier??a portuaria  
</option><option value="DISC-211"> Ingenier??a qu??mica  
</option><option value="DISC-191"> Ingenier??a qu??mica metal??rgica  
</option><option value="DISC-202"> Ingenier??a qu??mica nuclear  
</option><option value="DISC-153"> Ingenier??a sanitaria  
</option><option value="DISC-215"> Ingenier??a textil  
</option><option value="DISC-018"> Inmunolog??a  
</option><option value="DISC-246"> Inmunolog??a cl??nica y alergias  
</option><option value="DISC-165"> Instalaciones el??ctricas e iluminaci??n  
</option><option value="DISC-003"> Instrumentaci??n  
</option><option value="DISC-112"> Instrumentaci??n control y normas  
</option><option value="DISC-103"> Instrumentaci??n en agronom??a  
</option><option value="DISC-203"> Instrumentaci??n nuclear  
</option><option value="DISC-179"> Instrumentaci??n y control  
</option><option value="DISC-300"> Integraci??n regional  
</option><option value="DISC-348"> Integraci??n y bloques de comercio  
</option><option value="DISC-460"> Interfases y superficies  
</option><option value="DISC-278"> Investigaci??n de operaciones  
</option><option value="DISC-247"> Laboratorio cl??nico  
</option><option value="DISC-487"> Lenguajes en relaci??n con otros campos  
</option><option value="DISC-416"> Ling????stica  
</option><option value="DISC-289"> Ling????stica antropol??gica  
</option><option value="DISC-423"> Ling????stica descriptiva  
</option><option value="DISC-488"> Ling????stica hist??rica  
</option><option value="DISC-424"> Ling????stica hist??rica y comparada  
</option><option value="DISC-426"> Literatura  
</option><option value="DISC-489"> Literatura, filosof??a y bellas artes  
</option><option value="DISC-382"> L??gica  
</option><option value="DISC-133"> Manejo de pastizales  
</option><option value="DISC-180"> Mantenimiento  
</option><option value="DISC-166"> Maquinas el??ctricas  
</option><option value="DISC-181"> Maquinas t??rmicas  
</option><option value="DISC-069"> Matem??ticas  
</option><option value="DISC-074"> Matem??ticas de la utilizaci??n de recursos  
</option><option value="DISC-467"> Materiales funcionales  
</option><option value="DISC-004"> Mec??nica celeste  
</option><option value="DISC-038"> Mec??nica cl??sica  
</option><option value="DISC-182"> Mec??nica de fluidos  
</option><option value="DISC-183"> Mec??nica de materiales  
</option><option value="DISC-192"> Mec??nica de rocas  
</option><option value="DISC-154"> Mec??nica de suelos  
</option><option value="DISC-184"> Mec??nica del formado y corte de metales  
</option><option value="DISC-040"> Mec??nica estad??stica  
</option><option value="DISC-039"> Mec??nica qu??ntica  
</option><option value="DISC-232"> Medicina  
</option><option value="DISC-248"> Medicina de rehabilitaci??n  
</option><option value="DISC-249"> Medicina del trabajo  
</option><option value="DISC-250"> Medicina nuclear  
</option><option value="DISC-108"> Medicina veterinaria  
</option><option value="DISC-415"> Medios de comunicaci??n  
</option><option value="DISC-363"> Medios educativos  
</option><option value="DISC-134"> Mejoramiento gen??tico  
</option><option value="DISC-383"> Metaf??sica  
</option><option value="DISC-462"> Metales  
</option><option value="DISC-193"> Metalurgia  
</option><option value="DISC-448"> Metodolog??a  
</option><option value="DISC-349"> Metodolog??a y m??todos  
</option><option value="DISC-019"> Microbiolog??a  
</option><option value="DISC-194"> Mineralog??a  
</option><option value="DISC-471"> Modelaci??n  
</option><option value="DISC-113"> Morfolog??a  
</option><option value="DISC-312"> Mortalidad  
</option><option value="DISC-475"> M??sica  
</option><option value="DISC-313"> Natalidad  
</option><option value="DISC-251"> Nefrolog??a  
</option><option value="DISC-252"> Neumolog??a  
</option><option value="DISC-266"> Neurociencias  
</option><option value="DISC-253"> Neurolog??a  
</option><option value="DISC-406"> Numism??tica  
</option><option value="DISC-314"> Nupcialidad  
</option><option value="DISC-135"> Nutrici??n y alimentaci??n  
</option><option value="DISC-114"> Obstetricia  
</option><option value="DISC-078"> Oceanograf??a  
</option><option value="DISC-082"> Oceanograf??a biol??gica  
</option><option value="DISC-079"> Oceanograf??a descriptiva  
</option><option value="DISC-080"> Oceanograf??a f??sica  
</option><option value="DISC-081"> Oceanograf??a qu??mica  
</option><option value="DISC-267"> Odontolog??a  
</option><option value="DISC-254"> Oftalmolog??a  
</option><option value="DISC-255"> Ontolog??a  
</option><option value="DISC-204"> Operaci??n y mantenimiento de reactores  
</option><option value="DISC-041"> ??ptica  
</option><option value="DISC-449"> Organizaci??n social estructura e instituciones  
</option><option value="DISC-271"> Ortodoncia  
</option><option value="DISC-256"> Otorrinolaringolog??a  
</option><option value="DISC-127"> Ovinocultura  
</option><option value="DISC-407"> Paleograf??a  
</option><option value="DISC-020"> Paleontolog??a  
</option><option value="DISC-272"> Paradoncia  
</option><option value="DISC-430"> Parasicolog??a  
</option><option value="DISC-021"> Parasitolog??a  
</option><option value="DISC-257"> Parasitolog??a medica  
</option><option value="DISC-042"> Part??culas elementales  
</option><option value="DISC-265"> Patolog??a  
</option><option value="DISC-364"> Pedagog??a  
</option><option value="DISC-258"> Pediatr??a medica  
</option><option value="DISC-431"> Personalidad  
</option><option value="DISC-116"> Pesca  
</option><option value="DISC-065"> Petrogr??fica  
</option><option value="DISC-066"> Petrolog??a  
</option><option value="DISC-128"> Piscicultura  
</option><option value="DISC-490"> Planeaci??n urbana  
</option><option value="DISC-155"> Planeaci??n y sistemas  
</option><option value="DISC-350"> Plantaci??n econ??mica  
</option><option value="DISC-351"> Plantaci??n rural  
</option><option value="DISC-352"> Plantaci??n urbana  
</option><option value="DISC-185"> Plantas hidr??ulicas  
</option><option value="DISC-205"> Plantas nucleares  
</option><option value="DISC-186"> Plantas t??rmicas  
</option><option value="DISC-043"> Plasmas  
</option><option value="DISC-450"> Poblaci??n  
</option><option value="DISC-464"> Pol??meros  
</option><option value="DISC-365"> Pol??tica educativa  
</option><option value="DISC-425"> Pol??ticas del lenguaje  
</option><option value="DISC-129"> Porcinocultura  
</option><option value="DISC-224"> Prefabricaci??n e industrializaci??n en construcci??n  
</option><option value="DISC-408"> Prehistoria  
</option><option value="DISC-218"> Preparaci??n para el tejido  
</option><option value="DISC-075"> Probabilidad  
</option><option value="DISC-353"> Problemas de econom??a internacional  
</option><option value="DISC-451"> Problemas sociales, desorganizaci??n social  
</option><option value="DISC-213"> Proceso  
</option><option value="DISC-315"> Procesos migratorios  
</option><option value="DISC-187"> Producci??n y manufactura  
</option><option value="DISC-279"> Promoci??n y desarrollo de organizaciones  
</option><option value="DISC-121"> Prospecci??n de recursos  
</option><option value="DISC-195"> Prospecci??n minera  
</option><option value="DISC-273"> Pr??tesis  
</option><option value="DISC-214"> Proyectos  
</option><option value="DISC-443"> Psicoan??lisis  
</option><option value="DISC-428"> Psicolog??a  
</option><option value="DISC-432"> Psicolog??a cl??nica  
</option><option value="DISC-433"> Psicolog??a criminal  
</option><option value="DISC-434"> Psicolog??a cultural  
</option><option value="DISC-435"> Psicolog??a de la ingenier??a  
</option><option value="DISC-436"> Psicolog??a del desarrollo  
</option><option value="DISC-437"> Psicolog??a educacional  
</option><option value="DISC-366"> Psicolog??a educativa  
</option><option value="DISC-438"> Psicolog??a en medicina  
</option><option value="DISC-439"> Psicolog??a escolar  
</option><option value="DISC-440"> Psicolog??a experimental comparada fisiol??gica  
</option><option value="DISC-441"> Psicolog??a industrial y laboral  
</option><option value="DISC-452"> Psicolog??a social  
</option><option value="DISC-442"> Psicometr??a  
</option><option value="DISC-259"> Psiquiatr??a  
</option><option value="DISC-413"> Publicidad  
</option><option value="DISC-083"> Qu??mica  
</option><option value="DISC-084"> Qu??mica anal??tica  
</option><option value="DISC-086"> Qu??mica de pol??metros  
</option><option value="DISC-087"> Qu??mica inorg??nica  
</option><option value="DISC-088"> Qu??mica nuclear  
</option><option value="DISC-085"> Qu??mica org??nica  
</option><option value="DISC-022"> Radiobiolog??a  
</option><option value="DISC-260"> Radiodiagn??stico  
</option><option value="DISC-115"> Radiolog??a  
</option><option value="DISC-280"> Recursos humanos  
</option><option value="DISC-210"> Refinaci??n  
</option><option value="DISC-367"> Reforma educativa  
</option><option value="DISC-301"> Relaciones internacionales  
</option><option value="DISC-316"> Reparto y composici??n de la poblaci??n  
</option><option value="DISC-136"> Reproducci??n  
</option><option value="DISC-261"> Reumatolog??a  
</option><option value="DISC-262"> Salud publica  
</option><option value="DISC-067"> Sedimentolog??a  
</option><option value="DISC-409"> Sigilograf??a  
</option><option value="DISC-196"> Simulaci??n de yacimientos  
</option><option value="DISC-468"> S??ntesis  
</option><option value="DISC-053"> Sismolog??a  
</option><option value="DISC-171"> Sistemas  
</option><option value="DISC-281"> Sistemas de informaci??n  
</option><option value="DISC-148"> Sistemas de propulsi??n  
</option><option value="DISC-167"> Sistemas el??ctricos de potencia  
</option><option value="DISC-453"> Sociograf??a  
</option><option value="DISC-444"> Sociolog??a  
</option><option value="DISC-457"> Sociolog??a de cultura  
</option><option value="DISC-368"> Sociolog??a de la educaci??n  
</option><option value="DISC-456"> Sociolog??a pol??tica  
</option><option value="DISC-454"> Sociolog??a rural  
</option><option value="DISC-455"> Sociolog??a urbana  
</option><option value="DISC-023"> Taxonom??a  
</option><option value="DISC-476"> Teatro  
</option><option value="DISC-130"> Tecnolog??a de alimentos  
</option><option value="DISC-104"> Tecnolog??a de alimentos  
</option><option value="DISC-137"> Tecnolog??a de productos pecuarios  
</option><option value="DISC-231"> Tecnolog??a farmac??utica  
</option><option value="DISC-068"> Tect??nica  
</option><option value="DISC-219"> Tejido  
</option><option value="DISC-220"> Tejido de punto  
</option><option value="DISC-410"> Teor??a de documentos  
</option><option value="DISC-491"> Teor??a de la historia  
</option><option value="DISC-076"> Teor??a de los n??meros  
</option><option value="DISC-492"> Teor??a del conocimiento  
</option><option value="DISC-354"> Teor??a econ??mica  
</option><option value="DISC-197"> Topograf??a de minas  
</option><option value="DISC-077"> Topolog??a  
</option><option value="DISC-478"> Toxicolog??a  
</option><option value="DISC-206"> Transferencia t??rmica en reactores  
</option><option value="DISC-149"> Transporte a??reo  
</option><option value="DISC-263"> Traumatolog??a y ortopedia  
</option><option value="DISC-225"> Urbanismo  
</option><option value="DISC-264"> Urolog??a  
</option><option value="DISC-156"> V??as terrestres  
</option><option value="DISC-024"> Zoolog??a  
</option><option value="DISC-122"> Zootecnia  
</option><option value="DISC-105"> Zootecnia en agronom??a  
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
									<label for="sel1">Descripci??n del proyecto <span style="color:red;">*</span>:</label>
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
									<label for="sel1">??rea:</label>
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
											<label for="sel1">C??digo:</label>
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
							<p>Tesis en revisi??n para agregarse a tu lista</p>
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
						
						
						<span style="color:red;">Tesis proporcionadas por el acad??mico </span>
						
						
						<ol id="nuevas2" >
					<?php

						$pubsQuiere2 = getDetallesQuiereAgregarNOSIIATesis($nt);
						
						foreach($pubsQuiere2 as $p) { ?>
						<li>
						T??tulo: <?= utf8_encode($p['tituloTesis']) ?>, Autor(es):<?= utf8_encode($p['autor']) ?>
						
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
					<p onclick="abrePendientes()" style="float:right;">En proceso de validaci??n <img width="40px" src="imagenes/buying-books.png" />
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
											<p id="parrafoDes_<?= $contador ?>" style="color:blue;">Proyecto validado por el acad??mico</p><button id="botonDesv_<?= $contador ?>" onclick="revierteConf(<?= $contador ?>, <?=  $id ?>)">Revertir esta acci??n</button>
										</div>
									</td>
									<?php		
								} else if (in_array($id, $arrPorBorrar)) { ?>				
									<td>
										<div id="opcion_<?=$contador?>">
											<p id="parrafoConf_<?= $contador ?>" style="color:blue;">Proyecto en revisi??n para desvincular </p><button id="botonConf_<?= $contador ?>" onclick="revierteDes(<?= $contador ?>, <?=  $id ?>)">Revertir esta acci??n</button>
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