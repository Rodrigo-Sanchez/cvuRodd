<?php

	include("m/funciones.php");

	$nt = $_POST['nt'];
	$entidad = $_POST['entUNAM2'];
	$c_planEstudios = $_POST['codigoPlan'];
	$nivel = $_POST['nivelCursoNuevo'];
	$c_grupo = $_POST['codigoGrupo'];
	$c_programa = $_POST['codigoPrograma'];
	$semestre = $_POST['nombreSemestre'];
	$materia = $_POST['nombreMateria'];
	$alumnos = $_POST['numeroAlumnos'];
	$c_asignatura = $_POST['codigoAsignatura'];
	

	$fecha = date("Y-m-d h:m:s");
	
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 1; $i <= 35; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
	
	
	//NumeroEmpleado, folio, nombreAsignatura, codigoAsignatura, CodigoGrupo,	nivel, numeroAlumnos, SemestreImparticion, codigoEntidad, CodigoPlanEstudios, CodigoPrograma, idGrupoSIIA, fechaSolicitud, Observaciones, NombreInstitucionExterna
	
	$idGrupoSIIA="0000";
	$observaciones = "EL academico quiere agregar un curso nuevo que no existe";
	$externa = "NO";
	
	
	insertNuevoGrupo($nt, $randomString, $materia, $c_asignatura, $c_grupo, $nivel, $alumnos, $semestre, $entidad, $c_planEstudios, $c_programa, $idGrupoSIIA, $fecha, $observaciones, $externa);
	
	$entidadNombresDGEI = getNombreEntidad($entidad);
	$enNomDGEI = $entidadNombresDGEI[0]['Nombre'];


?>

<li>
<?= utf8_encode($enNomDGEI)?>, <?= ($c_asignatura) ?> - <?= $materia  ?>, Grupo: <?= $c_grupo?>, <?= $semestre ?>
</li>