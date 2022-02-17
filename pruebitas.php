<?php
//número de trabajador a 8 caracteres
		/*$noEmpleado='8309';
		$long=strlen($noEmpleado);
		$faltan=8-$long;
		echo "original: ".$noEmpleado;
		echo "<br>faltan: ".$faltan;

		for($i=0;$i<$faltan;$i++)
			$noEmpleado='0'.$noEmpleado;

		echo "<br>nuevo: ".$noEmpleado;*/
		include("m/funciones.php");

			$usr = '00008609';
			
			$registrado =getUsuarioCVU($usr);
			
			/*if($registrado[0]=='') 
			{
				insertUsuarioCVU($usr);
				echo "usuario nuevo registrado";
			} 
			else 
			{
				echo "usuario ya existente";
			}*/
		}
		?>