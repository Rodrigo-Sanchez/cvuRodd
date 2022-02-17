<?php

	//$nt = $_GET['nt'];
	session_start();
	$nt = $_SESSION['nt'];
	
	$hum=0;
	$cic=0;
	$res = esHumanindex($nt);
	
	foreach($res as $r) {
		if($r['CodigoCoordinacion']=="CHH") {
			$hum++;
		}
		if($r['CodigoCoordinacion']=="CIC") {
			$cic++;
		}

		if($hum!=0)
			$esHumanindex = $_SESSION['esHumanindex'];
	}
	


?>


<ul class="accordion">
	<li>
		<a id="top" class="toggle" onclick="redirige(1)">
		<!--<span style="color:#00375F;"> &#9679; </span> -->
		<img src = "imagenes/man-user.png" />
		<b>Datos  personales</b></a>
	</li>
	
	<li>
		<a id="top" class="toggle" onclick="redirige(1)">
		<!--<span style="color:#00375F;"> &#9679; </span>-->
		<img src = "imagenes/books.png"  />
		<b>Formación académica </b></a>
		<li style="padding-left:20px;">
			<a href="#" onclick="redirige(42)" class="toggle"><span style="color:#00375F;"> &#9632; </span>Estudios realizados</a>  
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(36)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Participación en cursos especiales</a>  
		</li>
		<li style="padding-left:20px;">
			<a  onclick="redirige(43)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Seminarios</a>  
		</li>

	</li>
	
	<li>
		<a class="toggle" href="#">
		<!--<span style="color:#00375F;"> &#9679; </span> -->
		<img src = "imagenes/teacher-at-the-blackboard.png" />
		<b>Docencia</b> </a>
			
		<li style="padding-left:20px;">
			<a href="#" onclick="redirige(61)" class="toggle"><span style="color:#00375F;"> &#9632; </span>Apoyo académico </a> 
		</li>
			
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Docencia impartida <i class="fa fa-chevron-down"></i></a>  
			<ul class="inner">
				<li>
					<a onclick="redirige(20)" href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Grupos atendidos en la UNAM (actas)</a>  
				</li>
				<li>
					<a onclick="redirige(41)" href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Grupos atendidos en otras instituciones </a>  
				</li>
				<li>
					<a href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Cursos como ponentes DGAPA</a>  
				</li> 
			</ul>
		</li>
		
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Tutorías <i class="fa fa-chevron-down"></i></a>  
			<ul class="inner">
				<li>
					<a onclick="redirige(44)" href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Posgrado</a>  
				</li>
				<li>
					<a onclick="redirige(45)" href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Licenciatura</a>  
				</li>
			</ul>
		</li>
		
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Comités de Tesis <i class="fa fa-chevron-down"></i></a>  
			<ul class="inner">
				<li>
					<a href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>TesiUNAM <i class="fa fa-chevron-down"></i></a> 
					<ul class="inner">
						<li>
							<a onclick="redirige(21)"  href="#" class="toggle">- Tesis dirigidas</a>  
						</li>
						<li>
							<a onclick="redirige(22)" href="#" class="toggle">- Tesis tutoradas</a>  
						</li>
					</ul>
				</li>
				
				
				<li>
					<a onclick="redirige(46)" href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Actividades de apoyo a la titulación </a> 
				</li>
				
				<li>
					<a href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Tesis en otras instituciones <i class="fa fa-chevron-down"></i></a> 
					<ul class="inner">
						<li>
							<a onclick="redirige(23)"  href="#" class="toggle">- Tesis dirigidas</a>   
						</li>
						<li>
							<a onclick="redirige(24)"  href="#" class="toggle">- Tesis tutoradas</a>  
						</li>
					</ul>					
				</li>
			</ul>
		</li>
			
	</li>
	
	<li>
		<a class="toggle" href="#">
		<!--<span style="color:#00375F;"> &#9679; </span>-->
		<img src = "imagenes/half-full-flask.png" />
		<b>Investigación</b> </a>
		
		<li style="padding-left:20px;">
			<a onclick="redirige(57)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Formación en la investigación</a> 
		</li>
	
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Publicaciones <i class="fa fa-chevron-down"></i></a> 
			
			<ul class="inner">
				<li>
					<a href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Documentos Indexados (Wos y Scopus. Pubmed) <i class="fa fa-chevron-down"></i></a> 
					<ul class="inner">
						<li>
							<a onclick="redirige(2)" href="#" class="toggle">- Artículos</a>  
						</li>
						<li>
							<a onclick="redirige(3)" href="#" class="toggle">- Libros </a>  
						</li>
						<li>
							<a onclick="redirige(4)" href="#" class="toggle">- Capítulos de libro</a>  
						</li>
						<li>
							<a onclick="redirige(5)" href="#" class="toggle">- Otros documentos (ensayos, memorias, antologías, conference papers)</a>  
						</li>
					</ul>
				</li>
				
				<?php
				
				//if(!$hum!=0) { 
				if (!isset($_SESSION['esHumanindex'])) { ?>
				
				<li>
					<a href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Documentos No indexados <i class="fa fa-chevron-down"></i></a> 
					<ul class="inner">
						<li>
							<a onclick="redirige(14)" href="#" class="toggle">- Artículos</a>  
						</li>
						<li>
							<a onclick="redirige(15)" href="#" class="toggle">- Libros</a>  
						</li>
						<li>
							<a onclick="redirige(16)" href="#" class="toggle">- Capítulos de libro</a>  
						</li>
						<li>
							<a onclick="redirige(17)" href="#" class="toggle">- Ponencias en memoria de Congresos</a>  
						</li>
						<li>
							<a onclick="redirige(18)" href="#" class="toggle">- Reportes técnicos</a>  
						</li>
						<li>
							<a onclick="redirige(19)" href="#" class="toggle">- Otras Obras (partituras, obras de arte, etc.)</a>  
						</li>
					</ul>
				</li>
				
				
				<?php
				
				}
				
				?>
				
				
				<?php
				
				//if($hum!=0) { 
				if (!isset($_SESSION['esHumanindex'])) { ?>
				<li>
					<a href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Producción Humanindex <i class="fa fa-chevron-down"></i></a> 
					<ul class="inner">
						<li>
							<a onclick="redirige(6)" href="#" class="toggle">- Artículos</a>  
						</li>
						<li>
							<a href="#" class="toggle">- Libros</a>  
						</li>
						<li style="margin-left:20px;">
							<a onclick="redirige(7)" href="#" class="toggle">- Autoría propia (Libro)</a>  
						</li>
						<li style="margin-left:20px;">
							<a onclick="redirige(8)" href="#" class="toggle">- Compilados</a>  
						</li>
						<li style="margin-left:20px;">
							<a onclick="redirige(9)" href="#" class="toggle">- Coordinados</a>  
						</li>
						<li style="margin-left:20px;">
							<a onclick="redirige(10)" href="#" class="toggle">- Editados</a>  
						</li>
						<li style="margin-left:20px;">
							<a onclick="redirige(11)" href="#" class="toggle">- Traducidos</a>  
						</li>
						
						<li>
							<a onclick="redirige(12)" href="#" class="toggle">- Capítulos de libro </a>  
						</li>
						<li>
							<a onclick="redirige(13)" href="#" class="toggle">- Ponencias en memoria de Congreso </a>  
						</li>
						
					</ul>
				</li>
				
				<?php
				
				}
				
				
				?>
			</ul>
			
		</li>
		
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Proyectos <i class="fa fa-chevron-down"></i></a> 
			
			<ul class="inner">
				<li>
					<a onclick="redirige(35)" href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Reportados en SISEPRO-UNAM</a> 
				</li>
				<li>
					<a onclick="redirige(48)" href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Otros proyectos </a> 
				</li>
			</ul>
			
		</li>
		
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Redes de investigación <i class="fa fa-chevron-down"></i></a> 
			<ul class="inner">
				<li>
					<a onclick="redirige(37)" href="#" class="toggle"><span style="color:#00375F;"> &#9674; </span>Redes Conacyt</a> 
				</li>
				
			</ul>
		</li>
		
		<li style="padding-left:20px;">
			<a onclick="redirige(29)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Estancias de investigación (paspa, coordinaciones, dgeci) </a> 
		</li>

	</li>
	
	
	
	<li>
		<a class="toggle" href="#">
		<!--<span style="color:#00375F;"> &#9679; </span>-->
		<img src = "imagenes/megaphone2.png" />
		<b>Divulgación</b> </a>
	
		<li style="padding-left:20px;">
			<a onclick="redirige(49)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Conferencias </a>
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(50)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Ferias de la Ciencia </a>
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(51)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Organización de actividades </a>
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(52)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Presentaciones multimedia </a>
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(53)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Programas de radio y televisión </a>
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(54)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Reuniones académicas colectivas </a>
		</li>

		
	</li>
	
	
	
	
	<li>
		<a id="top" class="toggle" onclick="redirige(1)">
		<!--<span style="color:#00375F;"> &#9679; </span>-->
		<img src = "imagenes/badge.png" />
		<b>Estímulos, programas, premios y reconocimientos obtenidos</b></a>
		<li style="padding-left:20px;">
			<a onclick="redirige(25)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Sistema Nacional de Investigadores </a> 
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(26)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Cátedras especiales</a> 
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(27)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Estímulos especiales</a> 
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(28)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Honoris causa</a> 
		</li>
		
		<li style="padding-left:20px;">
			<a onclick="redirige(30)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>PEPASIG</a> 
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(31)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>PRIDE</a> 
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(32)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>PUN</a> 
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(33)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>RDUNJA</a> 
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(34)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>SNCA</a> 
		</li>
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Otros</a> 
		</li>
	
	</li>
	
	<li>
		<a id="top" class="toggle" onclick="redirige(1)">
		<!--<span style="color:#00375F;"> &#9679; </span>-->
		<img src = "imagenes/settings2.png"  />
		<b>Propiedad Industrial</b></a>
		<li style="padding-left:20px;">
			<a onclick="redirige(38)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Solicitud de Patentes </a> 
		</li>
		<li style="padding-left:20px;">
			<a onclick="redirige(39)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Patentes otorgadas </a> 
		</li>
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Modelo de utilidad </a> 
		</li>
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Diseños industriales </a> 
		</li>	
			
	</li>
	
	
	<?php
				
		if($cic!=0) { ?>
	
	<li>
		<a id="top" class="toggle" onclick="redirige(1)">
		<!--<span style="color:#00375F;"> &#9679; </span>-->
		<img src = "imagenes/newspaper.png"  />
		<b>Reportes Técnicos </b></a>
		<li style="padding-left:20px;">
			<a onclick="redirige(40)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>CIC </a> 
		</li>
		<li style="padding-left:20px;">
			<a href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Otras entidades </a> 
		</li>
	
	</li>
	
	<?php
		}
	?>
	
	
	
	<li>
		<a id="top" class="toggle" onclick="redirige(58)">
		<!--<span style="color:#00375F;"> &#9679; </span>-->
		<img src = "imagenes/monitor.png"  />
		<b>Desarrollo de software</b></a>
		<li style="padding-left:20px;">
			<a onclick="redirige(58)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Desarrollo web</a>  
		</li>
	</li>
	
	
	<!--<li>
		<a id="top" class="toggle" onclick="redirige(1)">
		<!--<span style="color:#00375F;"> &#9679; </span>
		<img src = "imagenes/robot3.png"  />
		<b>Desarrollos tecnológicos</b></a>
	</li>
	-->

	<li>
		<a id="top" class="toggle" onclick="redirige(1)">
		<!--<span style="color:#00375F;"> &#9679; </span>-->
		<img src = "imagenes/bulb2.png"  />
		<b>Otras actividades por reportar </b></a>
		
			<li style="padding-left:20px;">
				<a onclick="redirige(64)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Asesorías</a>  
			</li>
		
		
			<li style="padding-left:20px;">
				<a onclick="redirige(55)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Comisiones evaluadoras</a>  
			</li>
			<li style="padding-left:20px;">
				<a onclick="redirige(56)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Coordinación de Servicio Social</a>  
			</li>
			
			
			<li style="padding-left:20px;">
				<a onclick="redirige(59)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Elaboración de Material Didáctico</a>  
			</li>
			<li style="padding-left:20px;">
				<a onclick="redirige(60)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Idiomas</a>  
			</li>
			<li style="padding-left:20px;">
				<a onclick="redirige(63)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Órganos asesores</a>  
			</li>
			<li style="padding-left:20px;">
				<a onclick="redirige(62)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Órganos colegiados</a>  
			</li>
			<li style="padding-left:20px;">
				<a onclick="redirige(65)" href="#" class="toggle"><span style="color:#00375F;"> &#9632; </span>Servicios a la comunidad</a>  
			</li>
		
	</li>
	
	
	
	
	
        
</ul>
	
	
	
    

	<script>
	
	$('.toggle').click(function(e) {
		e.preventDefault();

		var $this = $(this);

		if ($this.next().hasClass('show')) {
			$this.next().removeClass('show');
		} else {
			$this.parent().parent().find('li .inner').removeClass('show');
			$this.next().toggleClass('show');
		}

		$("li a.toggle").not(this).removeClass('expanded'); //if clicking off from this toggle, will collapse all other list items
		$this.parents('.inner').siblings('a.toggle').addClass("expanded"); // ensures all ancestors of this class will also remain expanded
		$this.toggleClass("expanded"); // to expand or collapse arrow on click (toggle)


	});

	</script>
	
	<script>
		function redirige(variable) {
			
			if(variable==1) {
				window.location.href = "https://web.siia.unam.mx/cvu2/?nt=<?= $nt ?>";
			} else if(variable==2) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulos.php?nt=<?= $nt ?>";
			} else if(variable==3) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulos2.php?nt=<?= $nt ?>";
			} else if(variable==4) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulos3.php?nt=<?= $nt ?>";
			} else if(variable==5) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulos4.php?nt=<?= $nt ?>";
			} else if(variable==6) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosH.php?nt=<?= $nt ?>";
			} else if(variable==7) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosH2.php?nt=<?= $nt ?>";
			} else if(variable==8) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosH3.php?nt=<?= $nt ?>";
			} else if(variable==9) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosH4.php?nt=<?= $nt ?>";
			} else if(variable==10) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosH5.php?nt=<?= $nt ?>";
			} else if(variable==11) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosH6.php?nt=<?= $nt ?>";
			} else if(variable==12) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosH7.php?nt=<?= $nt ?>";
			} else if(variable==13) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosH8.php?nt=<?= $nt ?>";
			} else if(variable==14) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosNI.php?nt=<?= $nt ?>";
			} else if(variable==15) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosNI2.php?nt=<?= $nt ?>";
			} else if(variable==16) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosNI3.php?nt=<?= $nt ?>";
			} else if(variable==17) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosNI4.php?nt=<?= $nt ?>";
			} else if(variable==18) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosNI5.php?nt=<?= $nt ?>";
			} else if(variable==19) {
				window.location.href = "https://web.siia.unam.mx/cvu2/articulosNI6.php?nt=<?= $nt ?>";
			} else if(variable==20) {
				window.location.href = "https://web.siia.unam.mx/cvu2/docencia.php?nt=<?= $nt ?>";
			} else if(variable==21) {
				window.location.href = "https://web.siia.unam.mx/cvu2/dirigidas.php?nt=<?= $nt ?>";
			} else if(variable==22) {
				window.location.href = "https://web.siia.unam.mx/cvu2/tutoradas.php?nt=<?= $nt ?>";
			} else if(variable==23) {
				window.location.href = "https://web.siia.unam.mx/cvu2/texternas.php?nt=<?= $nt ?>";
			} else if(variable==24) {
				window.location.href = "https://web.siia.unam.mx/cvu2/texternas2.php?nt=<?= $nt ?>";
			} else if(variable==25) {
				//window.location.href = "https://web.siia.unam.mx/cvu2/sni.php?nt=<?= $nt ?>";
				window.location.href = "https://web.siia.unam.mx/cvu2/sni.php";
			} else if(variable==26) {
				window.location.href = "https://web.siia.unam.mx/cvu2/catedras.php?nt=<?= $nt ?>";
			} else if(variable==27) {
				window.location.href = "https://web.siia.unam.mx/cvu2/eespeciales.php?nt=<?= $nt ?>";
			} else if(variable==28) {
				window.location.href = "https://web.siia.unam.mx/cvu2/honoris.php?nt=<?= $nt ?>";
			} else if(variable==29) {
				window.location.href = "https://web.siia.unam.mx/cvu2/paspa.php?nt=<?= $nt ?>";
			} else if(variable==30) {
				window.location.href = "https://web.siia.unam.mx/cvu2/pepasig.php?nt=<?= $nt ?>";
			} else if(variable==31) {
				window.location.href = "https://web.siia.unam.mx/cvu2/pride.php?nt=<?= $nt ?>";
			} else if(variable==32) {
				window.location.href = "https://web.siia.unam.mx/cvu2/pun.php?nt=<?= $nt ?>";
			} else if(variable==33) {
				window.location.href = "https://web.siia.unam.mx/cvu2/rdunja.php?nt=<?= $nt ?>";
			} else if(variable==34) {
				window.location.href = "https://web.siia.unam.mx/cvu2/snca.php?nt=<?= $nt ?>";
			} else if(variable==35) {
				window.location.href = "https://web.siia.unam.mx/cvu2/proyectos.php?nt=<?= $nt ?>";
			} else if(variable==36) {
				window.location.href = "https://web.siia.unam.mx/cvu2/cursosEsp.php?nt=<?= $nt ?>";
			} else if(variable==37) {
				window.location.href = "https://web.siia.unam.mx/cvu2/redes.php?nt=<?= $nt ?>";
			} else if(variable==38) {
				window.location.href = "https://web.siia.unam.mx/cvu2/patentesSol.php?nt=<?= $nt ?>";
			} else if(variable==39) {
				window.location.href = "https://web.siia.unam.mx/cvu2/patentesOto.php?nt=<?= $nt ?>";
			} else if(variable==40) {
				window.location.href = "https://web.siia.unam.mx/cvu2/reportes.php?nt=<?= $nt ?>";
			} else if(variable==41) {
				window.location.href = "https://web.siia.unam.mx/cvu2/docenciaExt.php?nt=<?= $nt ?>";
			} else if(variable==42) {
				window.location.href = "https://web.siia.unam.mx/cvu2/estudios.php?nt=<?= $nt ?>";
			} else if(variable==43) {
				window.location.href = "https://web.siia.unam.mx/cvu2/seminarios.php?nt=<?= $nt ?>";
			} else if(variable==44) {
				window.location.href = "https://web.siia.unam.mx/cvu2/tutPosgrado.php?nt=<?= $nt ?>";
			} else if(variable==45) {
				window.location.href = "https://web.siia.unam.mx/cvu2/tutLicenciatura.php?nt=<?= $nt ?>";
			}  else if(variable==46) {
				window.location.href = "https://web.siia.unam.mx/cvu2/apoyo.php?nt=<?= $nt ?>";
			} else if(variable==47) {
				window.location.href = "https://web.siia.unam.mx/cvu2/comites.php?nt=<?= $nt ?>";
			} else if(variable==48) {
				window.location.href = "https://web.siia.unam.mx/cvu2/otrosProy.php?nt=<?= $nt ?>";
			} else if(variable==49) {
				window.location.href = "https://web.siia.unam.mx/cvu2/conferencias.php?nt=<?= $nt ?>";
			} else if(variable==50) {
				window.location.href = "https://web.siia.unam.mx/cvu2/ferias.php?nt=<?= $nt ?>";
			} else if(variable==51) {
				window.location.href = "https://web.siia.unam.mx/cvu2/organizacion.php?nt=<?= $nt ?>";
			} else if(variable==52) {
				window.location.href = "https://web.siia.unam.mx/cvu2/multimedia.php?nt=<?= $nt ?>";
			} else if(variable==53) {
				window.location.href = "https://web.siia.unam.mx/cvu2/radiotev.php?nt=<?= $nt ?>";
			} else if(variable==54) {
				window.location.href = "https://web.siia.unam.mx/cvu2/reuniones.php?nt=<?= $nt ?>";
			} else if(variable==55) {
				window.location.href = "https://web.siia.unam.mx/cvu2/comisiones.php?nt=<?= $nt ?>";
			} else if(variable==56) {
				window.location.href = "https://web.siia.unam.mx/cvu2/ss.php?nt=<?= $nt ?>";
			} else if(variable==57) {
				window.location.href = "https://web.siia.unam.mx/cvu2/formacion.php?nt=<?= $nt ?>";
			} else if(variable==58) {
				window.location.href = "https://web.siia.unam.mx/cvu2/software.php?nt=<?= $nt ?>";
			} else if(variable==59) {
				window.location.href = "https://web.siia.unam.mx/cvu2/material.php?nt=<?= $nt ?>";
			} else if(variable==60) {
				window.location.href = "https://web.siia.unam.mx/cvu2/idiomas.php?nt=<?= $nt ?>";
			} else if(variable==61) {
				window.location.href = "https://web.siia.unam.mx/cvu2/apoyoD.php?nt=<?= $nt ?>";
			} else if(variable==62) {
				window.location.href = "https://web.siia.unam.mx/cvu2/organos.php?nt=<?= $nt ?>";
			} else if(variable==63) {
				window.location.href = "https://web.siia.unam.mx/cvu2/organosA.php?nt=<?= $nt ?>";
			} else if(variable==64) {
				window.location.href = "https://web.siia.unam.mx/cvu2/asesorias.php?nt=<?= $nt ?>";
			} else if(variable==65) {
				window.location.href = "https://web.siia.unam.mx/cvu2/serviciosCom.php?nt=<?= $nt ?>";
			}
			
			
			
		}
	
	</script>