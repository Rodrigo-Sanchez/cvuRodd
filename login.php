<?php
	session_start();
	ob_start();
	include("m/funciones.php");

	if(isset($_GET['ingresar']))
	{
		$usr = addslashes($_POST['nt']);
		$psswrd = addslashes($_POST['pswd']);
		
		//echo $usr;
		$long=strlen($usr);
		$faltan=8-$long;

		for($i=0;$i<$faltan;$i++)
			$usr='0'.$usr;
		
		$_SESSION['nt'] = $usr;
		//echo $usr;
		$registrado = getUsuarioCVU($usr);
		$valido = validarUsuario($usr);
		
		if($valido[0]['Identificador']=='')
		{
			/*echo'
			<div class="alert">
			  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
			  Número de trabajador no válido. Intente nuevamente.
			</div>';*/
			//echo'Número de trabajador no válido';
			$msgErr = "Número de trabajador no válido. Intente nuevamente.";
		}
		else if ($psswrd!="dgei") {
			$msgErr = "Contraseña incorrecta. Intente nuevamente.";
		}
		else
		{	
			if($registrado[0]['NumeroEmpleado']=='') 
			{
				//echo "NO esta registrado";
				insertUsuarioCVU($usr);
				header('location: index.php');
			} 
			else 
			{
				//echo "Esta registrado";
				header('location: index.php');
			}
		}	
	}
?>

<!DOCTYPE html>

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>CVU UNAM</title>
        <!--Login-->
		<link rel="stylesheet" type="text/css" href="css/login.css" />
        <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
		<link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Montserrat:400,700'>
		<!--Favicon-->
		<link rel="shortcut icon" href="imgs/favicon.ico" type="image/x-icon">
		<link rel="icon" href="imgs/favicon.ico" type="image/x-icon"> 

		<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Birthstone&display=swap" rel="stylesheet">
		
    </head>
    <!--<body oncontextmenu="return false"> -->
    	<body background="imagenes/campusBN.jpg" oncontextmenu="return false">
		<!--<center><img src="imagenes/cu.jpg"></center>-->
		<div class="header">
			
				<img src="imagenes/unamLogo.png">
				<!--<img width="450" align = "right" src="imagenes/dgeiHorizontal.png">-->
			
		</div>
		<div class="container">
	  <div class="info">
		<!--<h1>Bienvenido</h1>-->
		<span>Currículum Vitae Único</span>
	  </div>
	</div>
	<div class="form">
	  <div class="thumbnail"><img src="imagenes/cvuInicio.png"/></div>
	  <form class="login-form" method="post" action="login.php?ingresar=true">
		<input type="text" placeholder="número de trabajador" id="nt" name="nt" required="required" autofocus="autofocus"/>
		<input type="password" placeholder="contrase&ntilde;a" id="pswd" name="pswd" value="" required="required"/>
		<button type="submit" id="entrar">Ingresar</button>
		<p class="message"><font color = "#E3E3E3"><?php echo $msgErr; ?></font></p>
		<br>
		<img src="imagenes/dgei-128px.png" width = "30" >
	  </form>
	</div>
		
			<!--Hecho en M&eacute;xico, Universidad Nacional Aut&oacute;noma de M&eacute;xico (UNAM), todos los derechos reservados 2014. Esta p&aacute;gina puede ser reproducida con fines no lucrativos,
			siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica. De otra forma, requiere permiso previo por escrito de la institución. Cr&eacute;ditos.-->
		
	</body>
</html>