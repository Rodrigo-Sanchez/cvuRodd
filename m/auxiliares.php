
	
<?php


function tiempoTranscurridoFechas($fechaInicio,$fechaFin) {
			$fecha1 = new DateTime($fechaInicio);
			$fecha2 = new DateTime($fechaFin);
			$fecha = $fecha1->diff($fecha2);
			$tiempo = "";
         
			//años
			if($fecha->y > 0) {
				$tiempo .= $fecha->y;
				if($fecha->y == 1)
					$tiempo .= " año, ";
				else
					$tiempo .= " años, ";
			}
         
			//meses
			if($fecha->m > 0) {
				$tiempo .= $fecha->m;  
				if($fecha->m == 1)
					$tiempo .= " mes, ";
				else
					$tiempo .= " meses, ";
			}
         
			//dias
			if($fecha->d > 0) {
				$tiempo .= $fecha->d;
					 
				if($fecha->d == 1)
					$tiempo .= " día, ";
				else
					$tiempo .= " días, ";
			}
         
			//horas
			if($fecha->h > 0) {
				$tiempo .= $fecha->h;
					 
				if($fecha->h == 1)
					$tiempo .= " hora, ";
				else
					$tiempo .= " horas, ";
			}
         
			//minutos
			if($fecha->i > 0) {
				$tiempo .= $fecha->i;
					 
				if($fecha->i == 1)
					$tiempo .= " minuto";
				else
					$tiempo .= " minutos";
			}
   
			return $tiempo;
		}
		
		function calculaEdad($fechaInicio,$fechaFin) {
			$fecha1 = new DateTime($fechaInicio);
			$fecha2 = new DateTime($fechaFin);
			$fecha = $fecha1->diff($fecha2);
			$tiempo = "";
         
			//años
			if($fecha->y > 0) {
				$tiempo .= $fecha->y;
				if($fecha->y == 1)
					$tiempo .= " año, ";
				else
					$tiempo .= " años ";
			}
			return $tiempo;
		}
		
		
		
function ponFechaBien($fecharara) {

	$fecha = explode(" ", $fecharara);
	$f = $fecha[0];
	$fecha_b = explode("-", $f);
	$fecha_bien = $fecha_b[2]."-".$fecha_b[1]."-".$fecha_b[0];
	return $fecha_bien;

}	
		
	
?>

