<?php
	include("m/funciones.php");
	
	session_start();
	$nt = $_SESSION['nt'];

	if (!isset($_SESSION['nt']))
	{
		header('location:login.php');
	}

	//echo "num: ".$nt;
	//$nt = $_GET['nt'];
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<!--viñetas-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		<link rel='stylesheet prefetch' href='https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css'>
		
	
		
		<style>
			body {
				background-color:#FFF;
			}
	
			#estimulos td:nth-child(1){	
				width:300px;
			}
				
			#estimulos td:nth-child(2){
				padding-left:10px;
				text-align:right;
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
				/*color: #00375F;*/
				color: #FFFFFF;
				font-size:13px;
					
				
			}
			
			ul li a:hover {
				text-decoration:none;
				/*color: #00375F;*/
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
			
	</head>
	<body>
<?php
	include("header.php");
	include("m/auxiliares.php");
	
	$datos = getInfoPersonalAcademico($nt);
	$antiguedad = calculaAntiguedadAcademica($nt);
	
	if($antiguedad[0]['anios']==1) {
		$cadAnios=" año, ";
	} else {
		$cadAnios=" años, ";
	}

	
	if($antiguedad[0]['meses']==1) {
		$cadMeses=" mes, ";
	} else {
		$cadMeses=" meses, ";
	}
	
	if($antiguedad[0]['dias']==1) {
		$cadDias=" día";
	} else {
		$cadDias=" días";
	}
	
	$noms = getNombramientos($nt);
	$nombramientos="";
	$nombramientos_anteriores = "";
		
	//Aún labora en la UNAM
	$vigente=0;
	foreach($noms as $n) {
		if($n['FechaHasta']=="") {
			$vigente++;
			if($n['Perfil']!="OTROS") {
				$nombramientos.=utf8_encode($n['Perfil'])." ";
				$nombramientos.=utf8_encode($n['Categoria'])." ";	
			}
			$nombramientos.=utf8_encode($n['CategoriaEspecifica'])." ";
			$nombramientos.=$n['CodigoDedicacion']." ";
			$nombramientos.=$n['SituacionContractual']."<br>";
			$nombramientos.=utf8_encode($n['Entidad'])."<br>";
			$f = ponFechaBien($n['FechaDesde']);
			$nombramientos.="Desde ". $f;
			$nombramientos.="<br>";
		} else {
				
			if($n['Perfil']!="OTROS") {
				$nombramientos_anteriores.=utf8_encode($n['Perfil'])." ";
				$nombramientos_anteriores.=utf8_encode($n['Categoria'])." ";
			}
			$nombramientos_anteriores.=utf8_encode($n['CategoriaEspecifica'])." ";
			$nombramientos_anteriores.=$n['CodigoDedicacion']." ";
			$nombramientos_anteriores.=$n['SituacionContractual']."<br>";
			$nombramientos_anteriores.=utf8_encode($n['Entidad'])."<br>";
			$f1=ponFechaBien($n['FechaDesde']);
			$f2=ponFechaBien($n['FechaHasta']);
				
			if($f1!="01-01-2008") {
				$nombramientos_anteriores.="De ". $f1." hasta ".$f2;
			} else {
				$nombramientos_anteriores.= "Hasta ".$f2;
			}				
					
			$nombramientos_anteriores.="<br>";
		}
	}
		
		
	//Ya no labora en la UNAM
	$fecha_referencia="";
	$indice=0;
	if($vigente==0) {
		foreach($noms as $n) {
			$fecha = $n['FechaHasta'];
			if($indice==0) {
				if($n['Perfil']!="OTROS") {
					$nombramientos.=utf8_encode($n['Perfil'])." ";
					$nombramientos.=utf8_encode($n['Categoria'])." ";	
				}
					
				$nombramientos.=utf8_encode($n['CategoriaEspecifica'])." ";
				$nombramientos.=$n['CodigoDedicacion']." ";
				$nombramientos.=$n['SituacionContractual']."<br>";
				$nombramientos.=utf8_encode($n['Entidad']);
				$nombramientos.="<br>";
				$indice++;
				$fecha_referencia = $fecha;
					
			} else {
				
				if($fecha == $fecha_referencia) {
		
					if($n['Perfil']!="OTROS") {
						$nombramientos.=utf8_encode($n['Perfil'])." ";
						$nombramientos.=$n['Categoria']." ";	
					}
					$nombramientos.=$n['CategoriaEspecifica']." ";
					$nombramientos.=$n['CodigoDedicacion']." ";
					$nombramientos.=$n['SituacionContractual']."<br>";
					$nombramientos.=utf8_encode($n['Entidad']);
					$nombramientos.="<br>";
					$fecha_referencia = $fecha;
						
				} else {
					break;
				}
			}
		}
	}
	
	
	//SNI
	$estimuloSNI = getSNI($nt);
	
	//PRIDE
	$estimuloPRIDE = getPRIDE($nt);
	
	//PEPASIG
	$estimulosPEPASIG = getPEPASIG($nt);
	
	//PASPA
	$estimulosPASPA = getPASPA($nt);
	
	//HONORIS
	$estimulosHONORIS = getHONORIS($nt);
	
	//CATEDRA
	$estimulosCATEDRA = getCATEDRA($nt);
	
	//CATEDRA
	$estimulosESPECIALES = getESPECIALES($nt);
	
	//RDUNJA
	$estimulosRDUNJA = getRDUNJA($nt);
	
	//PUN
	$estimulosPUN = getPUN($nt);
	
	//SNCA
	$estimulosSNCA = getSNCA($nt);
	
	//EQUIVALENCIA
	$estimulosEQUIVALENCIA = getEQUIVALENCIA($nt);
	
	//AREAS
	$areas = getAreasConocimiento($nt);
	
	//REVISTAS
	$revistas = getRevistasHaPublicado($nt);
	
	$col1 = colabs1($nt);
	$col2 = colabs2($nt);
	
?>
	<div class="container-fluid" style="background-color:#fff; border-left: 50px #EDEDED solid; border-right: 50px #EDEDED solid;">
	<div class="row">
        <!--Div Menu izquierda-->
        <!--<div class="col-md-3" style="background-color:#52A4B7;" >-->
        <!--<div class="col-md-3" style="background-color:#00375F;" >	-->
        <div class="col-md-3" style="background-color:#303C64;" >	
		
			<!--<div  style="background-color:#0C667E; margin-left:-15px !important; margin-right:-15px !important; padding-top:10px; padding-bottom:10px;">-->

			<!--Div container de avatar-->
			<div  style="background-color:#F1F1F1; margin-left:-15px !important; margin-right:-15px !important; padding-top:10px; padding-bottom:10px;">
			
			<?php
				if($datos[0]['CodigoGenero']=="M") {
			?>
				<div style="padding-top:10px;">
					<center>
						<img src="imagenes/avatar.jpg" width="20%" style="border-radius: 50%; background-color:white;" />
					</center>
				</div>

			<?php
				} else {
			?>	

				<div style="padding-top:10px;">
					<center>
						<img src="imagenes/avatar.jpg" width="20%" style="border-radius: 50%; background-color:white;" />
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
		
		<div class="col-md-9" style="background-color:white; padding-bottom:50px;">
			
			<div class="row">
				<div class="col-md-12">
					<center><h4><b><?= $datos[0]['NombreCompleto'] ?></b></h4><h4>Datos generales</h4></center>
                    <hr style="margin-bottom:0px;">
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-md-4">
				<?php
					$f_nacimiento = $datos[0]['FechaNacimiento'];
					$f_n = explode(" ", $f_nacimiento);
					$f_nac = $f_n[0];
					$fecha_bien = explode("-", $f_nac);
					$fecha_nac = $fecha_bien[2]."-".$fecha_bien[1]."-".$fecha_bien[0];
									
					//Edad
					$hoy = date("Y-m-d");
					$edad = calculaEdad($f_nac, $hoy);				
				?>
							
					<br>
					<div style="width:100%; border-bottom-style: double; border-bottom-color: #EEA845;">
						<center>
						<!--<span style="font-size:17px; color:#337AB7;"><b>INFORMACIÓN PERSONAL </b></span>-->
						<span style="font-size:17px; color:#00375F;"><b>INFORMACIÓN PERSONAL </b></span>
						</center>
					</div>
					<br>
					<p><b>CURP:</b> <?= $datos[0]['Curp'] ?></p>
					<p><b>RFC:</b> <?= $datos[0]['Rfc'] ?></p>
					<p><b>Género:</b> <?= $datos[0]['Genero'] ?></p>
					<p><b>Nacionalidad:</b> <?= $datos[0]['Nacionalidad'] ?></p>
					<p><b>Máximo nivel de estudios:</b> <?= utf8_encode($datos[0]['GradoAcademico']) ?></p>
					<p><b>Fecha de nacimiento:</b> <?= $fecha_nac ?></p>
					<p><b>Edad:</b> <?= $edad ?></p>
				</div>
				
				<div class="col-md-8">
					<br>
					<div style="width:100%; border-bottom-style: double; border-bottom-color: #EEA845;">
						<center>
						<span style="font-size:17px; color:#00375F;"><b>INFORMACIÓN ACADÉMICA </b></span>
						</center>
					</div>
					<br>
								
					<div class="row">		
						<div class="col-md-6">
							<p><b>Número de trabajador:</b> <?= $datos[0]['NumeroEmpleado'] ?></p>
							<p><b>Antigüedad académica en la UNAM:</b></p>
							<p><?= $antiguedad[0]['anios'].$cadAnios.$antiguedad[0]['meses'].$cadMeses.$antiguedad[0]['dias'].$cadDias ?></p>
							<?php 
								if($vigente) {
							?>
								<p><b>Nombramiento Vigente: </b></p>
							<?php 
								} else {		
							?>
								<p><b>Último Nombramiento: </b></p>
							<?php	
								}
							?>
							<div> <?= $nombramientos ?></div>
						</div>
						
						<div class="col-md-6">
							<p><b>Nombramientos Anteriores: </b></p>
							<div style="height: 200px; overflow-y: auto;" >
								<?= $nombramientos_anteriores ?>
							</div>	
						</div>	
					</div>
				</div>
			</div>
			
			<br>
			<div class="row">
				<div class="col-md-12">
					<center>
					<span style="font-size:17px; color:#00375F;"><b>ESTÍMULOS, PROGRAMAS, PREMIOS Y RECONOCIMIENTOS </b></span>
					</center>
					<div style="width:100%; border-top-style: double; border-top-color: #EEA845;">		
						<table id='estimulos'>
							<br>
							<?php
							if(count($estimuloSNI )!=0) {
								foreach($estimuloSNI as $sni) {
									if(substr(ponFechaBien($sni['FechaDesde']), 6) == substr(ponFechaBien($sni['FechaHasta']), 6)) {
										if(  substr(ponFechaBien($sni['FechaDesde']), 6) == "2020"  ) {
											echo "<tr><td><b>SNI " . utf8_encode($sni['EstimuloOtorgado'])."</b></td><td>". "VIGENTE". "</td></tr>";
										} else {
											echo "<tr><td><b>SNI " . utf8_encode($sni['EstimuloOtorgado'])."</b></td><td>".substr(ponFechaBien($sni['FechaDesde']), 6). "</td></tr>";
										}
									} else {
										if(substr(ponFechaBien($sni['FechaDesde']), 6) == "2008"  ) {
											if( substr(ponFechaBien($sni['FechaHasta']), 6) == "2020" ) {
												echo "<tr><td><b>SNI " . utf8_encode($sni['EstimuloOtorgado'])."</b></td><td>". " - " . " VIGENTE ". "</td></tr>";	
											} else {
												echo "<tr><td><b>SNI " . utf8_encode($sni['EstimuloOtorgado'])."</b></td><td>". " - " .  substr(ponFechaBien($sni['FechaHasta']), 6)  . "</td></tr>";
											}
										} else {
											if( substr(ponFechaBien($sni['FechaHasta']), 6) == "2020" ) {
												echo "<tr><td><b>SNI " . utf8_encode($sni['EstimuloOtorgado'])."</b></td><td>".substr(ponFechaBien($sni['FechaDesde']), 6). " - " . "VIGENTE" . "</td></tr>";
											} else {
												echo "<tr><td><b>SNI " . utf8_encode($sni['EstimuloOtorgado'])."</b></td><td>".substr(ponFechaBien($sni['FechaDesde']), 6). " - " . substr(ponFechaBien($sni['FechaHasta']), 6)  . "</td></tr>";
											}
										}
									}	
								}
							}
									
							if(count($estimuloPRIDE)!=0) {
								foreach($estimuloPRIDE as $pride) {
									if(substr(ponFechaBien($pride['FechaDesde']), 6) == substr(ponFechaBien($pride['FechaHasta']), 6)) {
										if(  substr(ponFechaBien($pride['FechaDesde']), 6) == "2020"  ) {
											echo "<tr><td><b>PRIDE " . utf8_encode($pride['EstimuloOtorgado'])."</b></td><td>". "VIGENTE". "</td></tr>";
										} else {
											echo "<tr><td><b>PRIDE " . utf8_encode($pride['EstimuloOtorgado'])."</b></td><td>".substr(ponFechaBien($pride['FechaDesde']), 6). "</td></tr>";
										}
									} else {
										if(substr(ponFechaBien($pride['FechaDesde']), 6) == "2008"  ) {
											if( substr(ponFechaBien($pride['FechaHasta']), 6) == "2020" ) {
												echo "<tr><td><b>PRIDE " . utf8_encode($pride['EstimuloOtorgado'])."</b></td><td>". " - " . " VIGENTE ". "</td></tr>";	
											} else {
												echo "<tr><td><b>PRIDE " . utf8_encode($pride['EstimuloOtorgado'])."</b></td><td>". " - " .  substr(ponFechaBien($pride['FechaHasta']), 6)  . "</td></tr>";
											}
										} else {
											if( substr(ponFechaBien($pride['FechaHasta']), 6) == "2020" ) {
												echo "<tr><td><b>PRIDE " . utf8_encode($pride['EstimuloOtorgado'])."</b></td><td>".substr(ponFechaBien($pride['FechaDesde']), 6). " - " . "VIGENTE" . "</td></tr>";
											} else {
												echo "<tr><td><b>PRIDE " . utf8_encode($pride['EstimuloOtorgado'])."</b></td><td>".substr(ponFechaBien($pride['FechaDesde']), 6). " - " . substr(ponFechaBien($pride['FechaHasta']), 6)  . "</td></tr>";
											}
										}
									}	
								}
							}
								
								
							if(count($estimulosPEPASIG)!=0) {
								foreach($estimulosPEPASIG as $pepasig) {
									if(substr(ponFechaBien($pepasig['FechaDesde']), 6) == substr(ponFechaBien($pepasig['FechaHasta']), 6)) {
										echo "<tr><td><b>PEPASIG " . utf8_encode($pepasig['EstimuloOtorgado']) ."</b></td><td>". substr(ponFechaBien($pepasig['FechaDesde']),6). ", " .$pepasig['NumeroHorasSemana'] . " horas asignadas"."</td></tr>";
									} else {
										echo "<tr><td><b>PEPASIG " . utf8_encode($pepasig['EstimuloOtorgado']) ."</b></td><td>". substr(ponFechaBien($pepasig['FechaDesde']),6). " - " . substr(ponFechaBien($pepasig['FechaHasta']),6). ", " .$pepasig['NumeroHorasSemana'] . " horas asignadas"."</td></tr>";
									}
								}	
							}
								
							if(count($estimulosPASPA)!=0) {
								foreach($estimulosPASPA as $paspa) {
									if(substr(ponFechaBien($paspa['FechaDesde']), 6) == substr(ponFechaBien($paspa['FechaHasta']), 6)) {
										echo "<tr><td><b>PASPA " . utf8_encode($paspa['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($paspa['FechaDesde']), 6) . "</td></tr>";
									} else {
										echo "<tr><td><b>PASPA " . utf8_encode($paspa['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($paspa['FechaDesde']),6). " - " . substr(ponFechaBien($paspa['FechaHasta']),6) . "</td></tr>";
									}
								}	
							}
								
							if(count($estimulosHONORIS)!=0) {
								foreach($estimulosHONORIS as $honoris) {
									echo "<tr><td><b>HONORIS CAUSA " . $honoris['EstimuloOtorgado']."</b></td><td>". substr(ponFechaBien($honoris['FechaDesde']),6) . "</td></tr>";
								}	
							}
								
							if(count($estimulosCATEDRA)!=0) {
								foreach($estimulosCATEDRA as $catedra) {
									if(substr(ponFechaBien($catedra['FechaDesde']), 6) == substr(ponFechaBien($catedra['FechaHasta']), 6)) {
										echo "<tr><td><b>CATEDRA " . utf8_encode($catedra['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($catedra['FechaDesde']),6) . "</td></tr>";
									} else {
										echo "<tr><td><b>CATEDRA " . utf8_encode($catedra['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($catedra['FechaDesde']),6) . " - " . substr(ponFechaBien($catedra['FechaHasta']),6). "</td></tr>";
									}
								}	
							}
								
							if(count($estimulosESPECIALES)!=0) {
								foreach($estimulosESPECIALES as $especiales) {
									if(substr(ponFechaBien($especiales['FechaDesde']), 6) == substr(ponFechaBien($especiales['FechaHasta']), 6)) {
										echo "<tr><td><b>ESPECIALES " . utf8_encode($especiales['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($especiales['FechaDesde']),6). "</td></tr>";
									} else {
										echo "<tr><td><b>ESPECIALES " . utf8_encode($especiales['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($especiales['FechaDesde']),6) . " - " . substr(ponFechaBien($especiales['FechaHasta']),6) . "</td></tr>";
									}
								}	
							}
								
							if(count($estimulosRDUNJA)!=0) {
								foreach($estimulosRDUNJA as $rdunja) {
									echo "<tr><td><b>RDUNJA " . utf8_encode($rdunja['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($rdunja['FechaDesde']),6)."</td></tr>";	
								}	
							}
								
							if(count($estimulosPUN)!=0) {
								foreach($estimulosPUN as $pun) {
									echo "<tr><td><b>PUN " . utf8_encode($pun['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($pun['FechaDesde']),6). "</td></tr>";
								}	
							}
								
							if(count($estimulosSNCA)!=0) {
								foreach($estimulosSNCA as $snca) {
									if(substr(ponFechaBien($snca['FechaDesde']), 6) == substr(ponFechaBien($snca['FechaDesde']), 6)) {
										echo "<tr><td><b>SNCA " . utf8_encode($snca['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($snca['FechaDesde']),6). "</td></tr>";
									} else {
										echo "<tr><td><b>SNCA " . utf8_encode($snca['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($snca['FechaDesde']),6). " - " . substr(ponFechaBien($snca['FechaHasta']),6). "</td></tr>";
									}
								}	
							}
								
								
							if(count($estimulosEQUIVALENCIA)!=0) {
								foreach($estimulosEQUIVALENCIA as $equivalencia) {
									if(substr(ponFechaBien($euivalencia['FechaDesde']), 6) == substr(ponFechaBien($equivalencia['FechaHasta']), 6)) {
										echo "<tr><td><b>EQUIVALENCIA " . utf8_encode($equivalencia['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($equivalencia['FechaDesde']),6). "</td></tr>";
									} else {
										echo "<tr><td><b>EQUIVALENCIA " . utf8_encode($equivalencia['EstimuloOtorgado'])."</b></td><td>". substr(ponFechaBien($equivalencia['FechaDesde']),6). " - " . substr(ponFechaBien($equivalencia['FechaHasta']),6). "</td></tr>";
									}
								}	
							}

								
							?>
								
						</table>
					</div>
				</div>
			</div>
			
			<br>
			<div class="row">
				<div class="col-md-6">
					<br>
					<div style="width:100%; border-bottom-style: double; border-bottom-color: #EEA845; ">
						<center>
						<span style="font-size:17px; color:#00375F;"><b>REVISTAS EN QUE HA PUBLICADO</b></span>
						</center>
					</div>
					<br>
					<div style="height: 200px; overflow-y: auto;">
						<ol>
						<?php
						foreach($revistas as $r) { ?>
									
							<li><?= utf8_encode($r['RevistaTitulo'])  ?>, (<?= $r['anio'] ?>)</li>
								
						<?php
						}
						?>
						</ol>
					</div>
				</div>
				
				<div class="col-md-6">
					<br>
					<div style="width:100%; border-bottom-style: double; border-bottom-color: #EEA845;">
						<center>
						<span style="font-size:17px; color:#00375F;"><b>ÁREAS DE CONOCIMIENTO</b></span>
						</center>
					</div>
					<br>		
					<?php			
						foreach($areas as $a) { ?>					
							<span style='border: solid #C0C0C0 1px; border-radius: 25px; padding:0px 6px;  display: inline-block; margin-bottom:4px;'><?= $a['categoria'] ?></span>	
					<?php		
						}
					?>							
				</div>
			</div>
			
			<br>
			<div class="row">
				<?php
				$firmas = getFirmas($nt);		
	
				if(count($firmas)!=0) { ?>
							
					<div class="col-md-4">
								
						<br>
						<div style="width:100%; border-bottom-style: double; border-bottom-color: #EEA845;">
							<center>
							<span style="font-size:17px; color:#00375F;"><b>FIRMAS</b></span>
							</center>
						</div>
						<br>

						<?php
						foreach($firmas as $f ) { ?>
							<span style='border: solid #C0C0C0 1px; border-radius: 25px; padding:0px 6px;  display: inline-block; margin-bottom:4px;'><?=utf8_encode($f['Firma'])?></span>
								
						<?php
						}
						?>
					</div>
				<?php
				}
				?>
				
				<div class="col-md-4">
					<br>
					<div style="width:100%; border-bottom-style: double; border-bottom-color: #EEA845;">
						<center>
						<span style="font-size:17px; color:#00375F;"><b>COAUTORÍAS EN LA UNAM</b></span>
						</center>
					</div>
					<br>
					<ul>
						<?php

						$arr[] = array();
						foreach($col1 as $v1) {
							if(in_array($v1['Entidad'], $arr) == false ) {
								echo "<li>". utf8_encode($v1['Entidad'])."</li>";
								$arr[] = $v1['Entidad'];
							}
						}
						
						foreach($col2 as $v2) {
							if(in_array($v2['Institucion'], $arr) == false ) {
								echo "<li>". utf8_encode($v2['Institucion'])."</li>";
								$arr[] = $v2['Institucion'];
							}
						}	
						?>
					</ul>
				</div>
				
				<div class="col-md-4">

					<?php

					$idsS = getScopusId($nt);
					$orcid = getOrcid($nt);
								
					if($idsS[0]['ScopusId'] != "" || $orcid[0]['Orcid'] != "" ) {  ?>
									
						<br>
						<div style="width:100%; border-bottom-style: double; border-bottom-color: #EEA845;">
							<center>
							<span style="font-size:17px; color:#00375F;"><b>IDENTIFICADORES </b></span>
							</center>
						</div>
						<br>	
								
					<?php
					}
					
					if($idsS[0]['ScopusId'] != "" ) { ?>
						
						<div class="row">
							<div class="col-md-2">
								<p><img src="imagenes/scopusPeque.png"  style="float:right;" /></p>
								<br>
								<br>
							</div>
							<div class="col-md-10">
							<?php
								
								foreach($idsS as $iscopus ) {
												
									$ip = $iscopus['ScopusId']; ?>
									
									<span><a href='https://www.scopus.com/authid/detail.uri?authorId=<?=$ip?>' target='_blank'><?=utf8_encode($iscopus['ScopusId'])?></a>, </span>
							<?php
								}
							?>
							</div>
						</div>
				<?php	
					}
				?>									

						
					<div class="row">
						<?php
							$orcid = getOrcid($nt);	
							if($orcid[0]['Orcid'] != "") {  ?>
									
								<div class="col-md-2">
								<p><img src="imagenes/orcid.png" style="float:right;" /></p>
								</div>
								<div class="col-md-10">
						<?php
								
								foreach($orcid as $or ) {			
									$o = $or['Orcid']; ?>
									<span><a href='https://orcid.org/<?=$o?>' target='_blank'><?= utf8_encode($or['Orcid']) ?></a>, </span>
						<?php
								}
						?>
								</div>
						<?php	
							}
						?>									

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