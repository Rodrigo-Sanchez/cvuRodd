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
			
			.ui-menu-item  {
				background: #ffffff !important;
				color: #000000 !important;
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
					url:"borrarDocenciaDirecto.php",  
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
					url:"borrarDocenciaDirecto2.php",  
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
			function agregarDocencia() {
				
				var numT = "<?php echo $nt; ?>";
				var entidad = $( "#entidadUNAM" ).val();
				var semestre = $( "#semestre" ).val();
				var nombreCurso = $( "#asignatura" ).val();
				var grupo = $( "#grupo" ).val();

				$.ajax({  
					url:"agregarDocencia.php",  
					method:"post",  
					data: {idEntidad: entidad, sem: semestre, curso:nombreCurso, gru:grupo, nt:numT}, 
					success:function(data) {  
						alert("Grupo agregado exitosamente");	
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
					url:"agregarNuevoGrupo.php",  
					method:"post",  
					data:$('#paraAgregarNuevoArt').serialize(),  
					success:function(data) {  
						alert("Grupo registrado exitosamente");	
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
						url:"alterarDocencia.php",  
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
									$(cadena).html("<p id='parrafoConf_"+indice+"' style='color:blue;'>Grupo en revisi??n para desvincular</p><button id='botonConf_"+indice+"' onclick='revierteDes(" + indice + "," + idPub + ")'>Revertir esta acci??n</button>");
								} else {
									$(cadena).html("<p id='parrafoDes_"+indice+"' style='color:blue;'>Grupo validado por el acad??mico</p><button id='botonDesv_"+indice+"' onclick='revierteConf(" + indice + "," + idPub + ")'>Revertir esta acci??n</button>");
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
							<p>Agregar conferencia</p>
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
									<div class="col-sm-3">
									<label for="sel1">T??tulo de la conferencia <span style="color:red;">*</span>: </label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" />	
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Por invitaci??n <span style="color:red;">*</span>: </label>
									</div>
									<div class="col-sm-9">
										<label><input type="radio" name="optradio" >S?? </label>
										<label>&nbsp; &nbsp;&nbsp;<input type="radio" name="optradio" >No</label>
									</div>
								</div>
								
								<p>Lugar donde se imparti?? </p>
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Pa??s <span style="color:red;">*</span>: </label>
									</div>
									<div class="col-sm-9">
										<select name="pais" class="form-control">
<option value="Elegir" id="AF">Seleccionar</option>
<option value="Afganist??n" id="AF">Afganist??n</option>
<option value="Albania" id="AL">Albania</option>
<option value="Alemania" id="DE">Alemania</option>
<option value="Andorra" id="AD">Andorra</option>
<option value="Angola" id="AO">Angola</option>
<option value="Anguila" id="AI">Anguila</option>
<option value="Ant??rtida" id="AQ">Ant??rtida</option>
<option value="Antigua y Barbuda" id="AG">Antigua y Barbuda</option>
<option value="Antillas holandesas" id="AN">Antillas holandesas</option>
<option value="Arabia Saud??" id="SA">Arabia Saud??</option>
<option value="Argelia" id="DZ">Argelia</option>
<option value="Argentina" id="AR">Argentina</option>
<option value="Armenia" id="AM">Armenia</option>
<option value="Aruba" id="AW">Aruba</option>
<option value="Australia" id="AU">Australia</option>
<option value="Austria" id="AT">Austria</option>
<option value="Azerbaiy??n" id="AZ">Azerbaiy??n</option>
<option value="Bahamas" id="BS">Bahamas</option>
<option value="Bahrein" id="BH">Bahrein</option>
<option value="Bangladesh" id="BD">Bangladesh</option>
<option value="Barbados" id="BB">Barbados</option>
<option value="B??lgica" id="BE">B??lgica</option>
<option value="Belice" id="BZ">Belice</option>
<option value="Ben??n" id="BJ">Ben??n</option>
<option value="Bermudas" id="BM">Bermudas</option>
<option value="Bhut??n" id="BT">Bhut??n</option>
<option value="Bielorrusia" id="BY">Bielorrusia</option>
<option value="Birmania" id="MM">Birmania</option>
<option value="Bolivia" id="BO">Bolivia</option>
<option value="Bosnia y Herzegovina" id="BA">Bosnia y Herzegovina</option>
<option value="Botsuana" id="BW">Botsuana</option>
<option value="Brasil" id="BR">Brasil</option>
<option value="Brunei" id="BN">Brunei</option>
<option value="Bulgaria" id="BG">Bulgaria</option>
<option value="Burkina Faso" id="BF">Burkina Faso</option>
<option value="Burundi" id="BI">Burundi</option>
<option value="Cabo Verde" id="CV">Cabo Verde</option>
<option value="Camboya" id="KH">Camboya</option>
<option value="Camer??n" id="CM">Camer??n</option>
<option value="Canad??" id="CA">Canad??</option>
<option value="Chad" id="TD">Chad</option>
<option value="Chile" id="CL">Chile</option>
<option value="China" id="CN">China</option>
<option value="Chipre" id="CY">Chipre</option>
<option value="Ciudad estado del Vaticano" id="VA">Ciudad estado del Vaticano</option>
<option value="Colombia" id="CO">Colombia</option>
<option value="Comores" id="KM">Comores</option>
<option value="Congo" id="CG">Congo</option>
<option value="Corea" id="KR">Corea</option>
<option value="Corea del Norte" id="KP">Corea del Norte</option>
<option value="Costa del Marf??l" id="CI">Costa del Marf??l</option>
<option value="Costa Rica" id="CR">Costa Rica</option>
<option value="Croacia" id="HR">Croacia</option>
<option value="Cuba" id="CU">Cuba</option>
<option value="Dinamarca" id="DK">Dinamarca</option>
<option value="Djibouri" id="DJ">Djibouri</option>
<option value="Dominica" id="DM">Dominica</option>
<option value="Ecuador" id="EC">Ecuador</option>
<option value="Egipto" id="EG">Egipto</option>
<option value="El Salvador" id="SV">El Salvador</option>
<option value="Emiratos Arabes Unidos" id="AE">Emiratos Arabes Unidos</option>
<option value="Eritrea" id="ER">Eritrea</option>
<option value="Eslovaquia" id="SK">Eslovaquia</option>
<option value="Eslovenia" id="SI">Eslovenia</option>
<option value="Espa??a" id="ES">Espa??a</option>
<option value="Estados Unidos" id="US">Estados Unidos</option>
<option value="Estonia" id="EE">Estonia</option>
<option value="c" id="ET">Etiop??a</option>
<option value="Ex-Rep??blica Yugoslava de Macedonia" id="MK">Ex-Rep??blica Yugoslava de Macedonia</option>
<option value="Filipinas" id="PH">Filipinas</option>
<option value="Finlandia" id="FI">Finlandia</option>
<option value="Francia" id="FR">Francia</option>
<option value="Gab??n" id="GA">Gab??n</option>
<option value="Gambia" id="GM">Gambia</option>
<option value="Georgia" id="GE">Georgia</option>
<option value="Georgia del Sur y las islas Sandwich del Sur" id="GS">Georgia del Sur y las islas Sandwich del Sur</option>
<option value="Ghana" id="GH">Ghana</option>
<option value="Gibraltar" id="GI">Gibraltar</option>
<option value="Granada" id="GD">Granada</option>
<option value="Grecia" id="GR">Grecia</option>
<option value="Groenlandia" id="GL">Groenlandia</option>
<option value="Guadalupe" id="GP">Guadalupe</option>
<option value="Guam" id="GU">Guam</option>
<option value="Guatemala" id="GT">Guatemala</option>
<option value="Guayana" id="GY">Guayana</option>
<option value="Guayana francesa" id="GF">Guayana francesa</option>
<option value="Guinea" id="GN">Guinea</option>
<option value="Guinea Ecuatorial" id="GQ">Guinea Ecuatorial</option>
<option value="Guinea-Bissau" id="GW">Guinea-Bissau</option>
<option value="Hait??" id="HT">Hait??</option>
<option value="Holanda" id="NL">Holanda</option>
<option value="Honduras" id="HN">Honduras</option>
<option value="Hong Kong R. A. E" id="HK">Hong Kong R. A. E</option>
<option value="Hungr??a" id="HU">Hungr??a</option>
<option value="India" id="IN">India</option>
<option value="Indonesia" id="ID">Indonesia</option>
<option value="Irak" id="IQ">Irak</option>
<option value="Ir??n" id="IR">Ir??n</option>
<option value="Irlanda" id="IE">Irlanda</option>
<option value="Isla Bouvet" id="BV">Isla Bouvet</option>
<option value="Isla Christmas" id="CX">Isla Christmas</option>
<option value="Isla Heard e Islas McDonald" id="HM">Isla Heard e Islas McDonald</option>
<option value="Islandia" id="IS">Islandia</option>
<option value="Islas Caim??n" id="KY">Islas Caim??n</option>
<option value="Islas Cook" id="CK">Islas Cook</option>
<option value="Islas de Cocos o Keeling" id="CC">Islas de Cocos o Keeling</option>
<option value="Islas Faroe" id="FO">Islas Faroe</option>
<option value="Islas Fiyi" id="FJ">Islas Fiyi</option>
<option value="Islas Malvinas Islas Falkland" id="FK">Islas Malvinas Islas Falkland</option>
<option value="Islas Marianas del norte" id="MP">Islas Marianas del norte</option>
<option value="Islas Marshall" id="MH">Islas Marshall</option>
<option value="Islas menores de Estados Unidos" id="UM">Islas menores de Estados Unidos</option>
<option value="Islas Palau" id="PW">Islas Palau</option>
<option value="Islas Salom??n" d="SB">Islas Salom??n</option>
<option value="Islas Tokelau" id="TK">Islas Tokelau</option>
<option value="Islas Turks y Caicos" id="TC">Islas Turks y Caicos</option>
<option value="Islas V??rgenes EE.UU." id="VI">Islas V??rgenes EE.UU.</option>
<option value="Islas V??rgenes Reino Unido" id="VG">Islas V??rgenes Reino Unido</option>
<option value="Israel" id="IL">Israel</option>
<option value="Italia" id="IT">Italia</option>
<option value="Jamaica" id="JM">Jamaica</option>
<option value="Jap??n" id="JP">Jap??n</option>
<option value="Jordania" id="JO">Jordania</option>
<option value="Kazajist??n" id="KZ">Kazajist??n</option>
<option value="Kenia" id="KE">Kenia</option>
<option value="Kirguizist??n" id="KG">Kirguizist??n</option>
<option value="Kiribati" id="KI">Kiribati</option>
<option value="Kuwait" id="KW">Kuwait</option>
<option value="Laos" id="LA">Laos</option>
<option value="Lesoto" id="LS">Lesoto</option>
<option value="Letonia" id="LV">Letonia</option>
<option value="L??bano" id="LB">L??bano</option>
<option value="Liberia" id="LR">Liberia</option>
<option value="Libia" id="LY">Libia</option>
<option value="Liechtenstein" id="LI">Liechtenstein</option>
<option value="Lituania" id="LT">Lituania</option>
<option value="Luxemburgo" id="LU">Luxemburgo</option>
<option value="Macao R. A. E" id="MO">Macao R. A. E</option>
<option value="Madagascar" id="MG">Madagascar</option>
<option value="Malasia" id="MY">Malasia</option>
<option value="Malawi" id="MW">Malawi</option>
<option value="Maldivas" id="MV">Maldivas</option>
<option value="Mal??" id="ML">Mal??</option>
<option value="Malta" id="MT">Malta</option>
<option value="Marruecos" id="MA">Marruecos</option>
<option value="Martinica" id="MQ">Martinica</option>
<option value="Mauricio" id="MU">Mauricio</option>
<option value="Mauritania" id="MR">Mauritania</option>
<option value="Mayotte" id="YT">Mayotte</option>
<option value="M??xico" id="MX">M??xico</option>
<option value="Micronesia" id="FM">Micronesia</option>
<option value="Moldavia" id="MD">Moldavia</option>
<option value="M??naco" id="MC">M??naco</option>
<option value="Mongolia" id="MN">Mongolia</option>
<option value="Montserrat" id="MS">Montserrat</option>
<option value="Mozambique" id="MZ">Mozambique</option>
<option value="Namibia" id="NA">Namibia</option>
<option value="Nauru" id="NR">Nauru</option>
<option value="Nepal" id="NP">Nepal</option>
<option value="Nicaragua" id="NI">Nicaragua</option>
<option value="N??ger" id="NE">N??ger</option>
<option value="Nigeria" id="NG">Nigeria</option>
<option value="Niue" id="NU">Niue</option>
<option value="Norfolk" id="NF">Norfolk</option>
<option value="Noruega" id="NO">Noruega</option>
<option value="Nueva Caledonia" id="NC">Nueva Caledonia</option>
<option value="Nueva Zelanda" id="NZ">Nueva Zelanda</option>
<option value="Om??n" id="OM">Om??n</option>
<option value="Panam??" id="PA">Panam??</option>
<option value="Papua Nueva Guinea" id="PG">Papua Nueva Guinea</option>
<option value="Paquist??n" id="PK">Paquist??n</option>
<option value="Paraguay" id="PY">Paraguay</option>
<option value="Per??" id="PE">Per??</option>
<option value="Pitcairn" id="PN">Pitcairn</option>
<option value="Polinesia francesa" id="PF">Polinesia francesa</option>
<option value="Polonia" id="PL">Polonia</option>
<option value="Portugal" id="PT">Portugal</option>
<option value="Puerto Rico" id="PR">Puerto Rico</option>
<option value="Qatar" id="QA">Qatar</option>
<option value="Reino Unido" id="UK">Reino Unido</option>
<option value="Rep??blica Centroafricana" id="CF">Rep??blica Centroafricana</option>
<option value="Rep??blica Checa" id="CZ">Rep??blica Checa</option>
<option value="Rep??blica de Sud??frica" id="ZA">Rep??blica de Sud??frica</option>
<option value="Rep??blica Democr??tica del Congo Zaire" id="CD">Rep??blica Democr??tica del Congo Zaire</option>
<option value="Rep??blica Dominicana" id="DO">Rep??blica Dominicana</option>
<option value="Reuni??n" id="RE">Reuni??n</option>
<option value="Ruanda" id="RW">Ruanda</option>
<option value="Rumania" id="RO">Rumania</option>
<option value="Rusia" id="RU">Rusia</option>
<option value="Samoa" id="WS">Samoa</option>
<option value="Samoa occidental" id="AS">Samoa occidental</option>
<option value="San Kitts y Nevis" id="KN">San Kitts y Nevis</option>
<option value="San Marino" id="SM">San Marino</option>
<option value="San Pierre y Miquelon" id="PM">San Pierre y Miquelon</option>
<option value="San Vicente e Islas Granadinas" id="VC">San Vicente e Islas Granadinas</option>
<option value="Santa Helena" id="SH">Santa Helena</option>
<option value="Santa Luc??a" id="LC">Santa Luc??a</option>
<option value="Santo Tom?? y Pr??ncipe" id="ST">Santo Tom?? y Pr??ncipe</option>
<option value="Senegal" id="SN">Senegal</option>
<option value="Serbia y Montenegro" id="YU">Serbia y Montenegro</option>
<option value="Sychelles" id="SC">Seychelles</option>
<option value="Sierra Leona" id="SL">Sierra Leona</option>
<option value="Singapur" id="SG">Singapur</option>
<option value="Siria" id="SY">Siria</option>
<option value="Somalia" id="SO">Somalia</option>
<option value="Sri Lanka" id="LK">Sri Lanka</option>
<option value="Suazilandia" id="SZ">Suazilandia</option>
<option value="Sud??n" id="SD">Sud??n</option>
<option value="Suecia" id="SE">Suecia</option>
<option value="Suiza" id="CH">Suiza</option>
<option value="Surinam" id="SR">Surinam</option>
<option value="Svalbard" id="SJ">Svalbard</option>
<option value="Tailandia" id="TH">Tailandia</option>
<option value="Taiw??n" id="TW">Taiw??n</option>
<option value="Tanzania" id="TZ">Tanzania</option>
<option value="Tayikist??n" id="TJ">Tayikist??n</option>
<option value="Territorios brit??nicos del oc??ano Indico" id="IO">Territorios brit??nicos del oc??ano Indico</option>
<option value="Territorios franceses del sur" id="TF">Territorios franceses del sur</option>
<option value="Timor Oriental" id="TP">Timor Oriental</option>
<option value="Togo" id="TG">Togo</option>
<option value="Tonga" id="TO">Tonga</option>
<option value="Trinidad y Tobago" id="TT">Trinidad y Tobago</option>
<option value="T??nez" id="TN">T??nez</option>
<option value="Turkmenist??n" id="TM">Turkmenist??n</option>
<option value="Turqu??a" id="TR">Turqu??a</option>
<option value="Tuvalu" id="TV">Tuvalu</option>
<option value="Ucrania" id="UA">Ucrania</option>
<option value="Uganda" id="UG">Uganda</option>
<option value="Uruguay" id="UY">Uruguay</option>
<option value="Uzbekist??n" id="UZ">Uzbekist??n</option>
<option value="Vanuatu" id="VU">Vanuatu</option>
<option value="Venezuela" id="VE">Venezuela</option>
<option value="Vietnam" id="VN">Vietnam</option>
<option value="Wallis y Futuna" id="WF">Wallis y Futuna</option>
<option value="Yemen" id="YE">Yemen</option>
<option value="Zambia" id="ZM">Zambia</option>
<option value="Zimbabue" id="ZW">Zimbabue</option>
</select>
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Ciudad <span style="color:red;">*</span>: </label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" />	
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Instituci??n <span style="color:red;">*</span>: </label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" />	
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Facultad o escuela <span style="color:red;">*</span>: </label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" />	
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Fecha <span style="color:red;">*</span>: </label>
									</div>
									<div class="col-sm-9">
										<input type="date" class="form-control" />	
									</div>
								</div>
								
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Observaciones: </label>
									</div>
									<div class="col-sm-9">
										<textarea style="resize: none;" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
									</div>
								</div>
								
								
								<p><span style="color:red;">(*) Campos obligatorios</span></p>
								
								<div class="row">
									<div class="col-sm-3">
									</div>
									<div class="col-sm-9">
									<br>
									<button type="button" class="btn btn-primary" onclick="agregarDocencia()">Agregar </button>
									</div>
								</div>

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
							<p>Agregar grupo nuevo</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p>Si no encontraste la red que quer??as agregar en el cat??logo del SIIA,  proporciona los siguientes datos</p>
					<form id="paraAgregarNuevoArt">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
								<?php
								
									$listaEntidades = getEntidades();
									
								?>
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Entidad <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
									
									<select id="entidadUNAM2" class="form-control" name="entUNAM2" >
										<option value="0">Seleccionar</option>
									<?php
										foreach($listaEntidades as $e) { ?>
											<option value="<?= $e['CodigoEntidad']?>"><?= utf8_encode($e['Entidad']) ?></option>
									<?php
										}
									?>
									</select>
									</div>
								</div>
								</div>
								
								<div class="col-sm-6">
									<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">N??mero de proyecto<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="codigoPlan" />
										<input type="hidden" class="form-control" name="nt" value="<?= $nt ?>" />
									</div>
									</div>
								</div>

							</div>
							<div class="row">
								
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">T??tulo<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="codigoGrupo" />
									
									</div>
								</div>
								</div>
								
								<div class="col-sm-6">
									<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">A??o <span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="codigoGrupo" />
									</div>
									</div>
								</div>
								
								
							</div>
							
							
							<div class="row">
								<div class="col-sm-6">
									<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Campo de conocimiento<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="codigoPrograma" />
									</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Disciplina <span style="color:red;">*</span>:</label>
									</div>
									
									<div class="col-sm-9">
									<input type="text" class="form-control" name="codigoPrograma" />
									</div>
									
									
									</div>
								</div>
							</div>
							
							
							<div class="row">
							
								<div class="col-sm-6">
								<div class="row" style="margin-bottom:7px;">
									<div class="col-sm-3">
									<label for="sel1">Monto<span style="color:red;">*</span>:</label>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="nombreMateria" />
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
							<p>Grupos en revisi??n para agregarse a tu lista</p>
						</div>
						<div class="col-sm-2">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
				
					 
					
					<?php
					
						$publicacionesQuiereAgregar = getDetallesQuiereAgregarDocencia($nt); ?>
						
						<span style="color:red;">Grupos en el SIIA  </span>
						
						
						<ol id="nuevas">
						
					<?php	
						foreach($publicacionesQuiereAgregar as $p) {
									
							?>
							<li><?= utf8_encode($p['Entidad']) ?>, <?= ($p['CodigoAsignatura']) ?> - <?=  utf8_encode($p['Asignatura']) ?>, Grupo: <?= $p['CodigoGrupo'] ?>, <?= $p['PeriodoImparte'] ?>
							
							
							</li>
									
							<?php
							
						}
					
					?>
						</ol>
						
						
						<span style="color:red;">Grupos proporcionados por el acad??mico </span>
						
						
						<ol id="nuevas2" >
					<?php

						$pubsQuiere2 = getDetallesQuiereAgregarDocenciaNOSIIA($nt);
						
						foreach($pubsQuiere2 as $p) { ?>
						
						<li>
						<?= utf8_encode($p['Nombre'])?>, <?= ($p['codigoAsignatura']) ?> - <?= utf8_encode($p['nombreAsignatura']) ?>, Grupo: <?= $p['CodigoGrupo']?>, <?= $p['SemestreImparticion'] ?>
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
					<center><h4><b><?= $datos[0]['NombreCompleto'] ?></b></h4><h4>Divulgaci??n - <i>Conferencias aisladas</i> </h4></center>
					<p onclick="abrePendientes()" style="float:right;">En proceso de validaci??n <img width="40px" src="imagenes/buying-books.png" />
					</p>
					<br>
					
                    <hr style="margin-bottom:0px;">
					
				</div>
			</div>
			
			<?php
				//$lista = getRedesTematicas($nt);
			?>
			<div class="row">
				
				<div class="col-md-12" style="height: 500px; overflow: auto;"  >
			
					<center><p style="color:red;" >No se encontraron resultados </p></center>
				
				</div>
				
			</div>
			
			
			<div class="row" style="margin-top:20px;">
				<div class="col-md-12">

					
					
					
					
					<button type="button" onclick="abreAgregar()" class="btn btn-info" style="float:right; margin-left:50px;" ><span class="glyphicon glyphicon-plus"></span> Agregar conferencia</button>
					
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