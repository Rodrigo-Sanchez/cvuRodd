
<head>
	<!--Fuente CVU-->
	<link href="https://fonts.googleapis.com/css2?family=Birthstone&display=swap" rel="stylesheet">
</head>

<div class="container-fluid">

	<div class="row" style="background-color:#FFFFFF; " >
		
		<div class="col-sm-1">
			<img style="margin-left:40px; padding-top:5px;" src="imagenes/logo-unam.png" width="70%"/>
		</div>
		<div class="col-sm-8">
			<br>
			<span style="font-family: 'Birthstone', cursive; font-size:40px; color:#C5911E; "><b>Currículum Vitae Único</span><!--</b></span><span style="font-size:30px; color:#00375F;">urrículum</span>
			<span style="font-size:30px; color:#C5911E; margin-left:5px;"><b>V</b></span><span style="font-size:30px; color:#00375F;">itae</span>
			<span style="font-size:30px; color:#C5911E; margin-left:5px;"><b>Ú</b></span><span style="font-size:30px; color:#00375F;">nico</span>-->
			
			<button type="button" onclick="window.open('https://web.siia.unam.mx/c/crear_pdf.php?nt=<?=$nt?>', '_blank')" class="btn btn-light" style="float:right;" ><span class="glyphicon glyphicon-download-alt"></span> Descargar CVU</button>
		</div>
		
		
		<div class="col-sm-3">
			<img style="margin-left:60px;"  src="imagenes/unam.jpg" width="60%"/>
		</div>
		
	</div>
	
	<div class="row" style="background-color:#303C64;" >
		<div class="col-sm-12">
			<span style="float:left; font-size:15px; color:#FFFFFF;"><img onclick="actualizarCorreo()" src="imagenes/gmail.png" /> <img  onclick="actualizarImagen()" src="imagenes/photo-camera.png" />&nbsp;&nbsp;&nbsp;<a href="logout.php" style="color:#ffffff;">Cerrar Sesión</a></span>
		
			<span style="font-size:18px; color:#FFFFFF; float:right; ">Universidad Nacional Autónoma de México</span>
		</div>
	</div>
	
</div>


<script>
	function actualizarCorreo() {
		$("#mi-modalCorreo").modal('show');
		
	}
</script>

<script>
	function actualizarImagen() {
		$("#mi-modalImagen").modal('show');
		
	}
</script>


<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="mi-modalCorreo">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#1F618D; color:white;">
				<div class="row">
					<div class="col-sm-10">
						<p>Correo electrónico</p>
					</div>
					<div class="col-sm-2">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				
				<form id="paraBuscar">
					<div class="form-group">
						
						<p style="color:blue;" >Correo electrónico actual: abc@gmail.com</p>
						<br>
						<p>Cambiar mi correo electrónico </p>
					
						<div class="row">
							<div class="col-sm-3">
								<label>Correo electrónico <span style="color:red;">*</span>:</label>
							</div>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="correo"  />
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
							</div>
							<div class="col-sm-9">
								<button type="button" class="btn btn-primary">Aceptar</button>
							</div>
						</div>
						
						<hr>
						<p>Cambiar mi contraseña</p>
						<div class="row">
							<div class="col-sm-3">
								<label>Contraseña nueva <span style="color:red;">*</span>:</label>
							</div>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="correo"  />
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Repetir Contraseña <span style="color:red;">*</span>:</label>
							</div>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="correo"  />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-sm-3">
							</div>
							<div class="col-sm-9">
								<button type="button" class="btn btn-primary">Aceptar</button>
							</div>
						</div>
						
						<p><span style="color:red;">(*) Campos obligatorios</span></p>
						
					</div>
				</form>

			</div>						
		</div>
	</div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="mi-modalImagen">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#1F618D; color:white;">
				<div class="row">
					<div class="col-sm-10">
						<p>Foto de perfil</p>
					</div>
					<div class="col-sm-2">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				
				<form id="paraBuscar">
					<div class="form-group">
						
						<p>Actualiza tu fotografía</p>
						
						<div class="row">
							<div class="col-sm-3">
								<label>Selecciona el archivo <span style="color:red;">*</span>:</label>
							</div>
							<div class="col-sm-9">
								<input type="file" class="form-control" name="foto"  />
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
							</div>
							<div class="col-sm-9">
								<button type="button" class="btn btn-primary">Aceptar</button>
							</div>
						</div>
						
						<p><span style="color:red;">(*) Campos obligatorios</span></p>
						
					</div>
				</form>

			</div>						
		</div>
	</div>
</div>