<?php


	require("Query.php");

	function getInfoPersonalAcademico($nt) {
		$query = "SELECT * FROM Personas where NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function calculaAntiguedadAcademica($nt) {
		$query =  utf8_decode("select final.NumeroEmpleado, final.NombreCompleto, final.semilla+final.antig as totalDias,
		(final.semilla+final.antig) / 365 as anios,
		cast((( ((final.semilla+final.antig) / 365.0) - ((final.semilla+final.antig) / 365)) * 12) AS INT) as meses,
		CAST(
		(
		(( ((final.semilla+final.antig) / 365.0) - ((final.semilla+final.antig) / 365)) * 12.0)
		-
		round((((final.semilla+final.antig) / 365.0) - ((final.semilla+final.antig) / 365)) * 12,0,1)
		) * 30  AS INT )
		as dias
		from (
		SELECT per.NumeroEmpleado, per.NombreCompleto, antiguedad.SUMA  AS antig,
		CASE WHEN per.Antiguedad IS NULL THEN 0
		ELSE per.Antiguedad END  as semilla
		FROM (
		SELECT per.NumeroEmpleado,SUM(historia.DIAS) AS SUMA
		 FROM (
		select per.NumeroEmpleado, pp.FechaDesde,
		pp.FechaHasta, CASE WHEN Dias IS NULL THEN DATEDIFF(DAY,FechaDesde,CONVERT(varchar,GETDATE(),23))
		ELSE Dias END as DIAS
		from PersonasPeriodos as pp, Personas as per
		where per.Identificador = pp.RefPersona
		AND per.NumeroEmpleado
		IN ( '$nt') 
		) as historia, Personas as per
		where per.NumeroEmpleado = historia.NumeroEmpleado
		GROUP BY per.NumeroEmpleado
		) AS antiguedad, Personas as per
		where per.NumeroEmpleado= Antiguedad.NumeroEmpleado
		) as final");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getNombramientos($nt) {
		$query = "select * from Nombramientos where NumeroEmpleado='$nt' order by FechaHasta DESC, CodigoCategoria DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getOrcid($nt) {
		$query = "SELECT 
					DISTINCT Orcid
					FROM PublicacionesRevistas 
					JOIN PublicRevistasAutores ON PublicacionesRevistas.Identificador = PublicRevistasAutores.RefPublicacion
					JOIN PublicRevistasFuentes ON PublicRevistasFuentes.RefPublicacion = PublicacionesRevistas.Identificador
					JOIN Personas ON PublicRevistasAutores.NumeroEmpleado = Personas.NumeroEmpleado
					WHERE PublicRevistasAutores.NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getScopusId($nt) {
		$query = "SELECT  PersonasScopusId .ScopusId FROM Personas 
				LEFT JOIN PersonasScopusId ON PersonasScopusId.NumeroEmpleado = Personas.NumeroEmpleado WHERE Personas.NumeroEmpleado ='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}

	function getFirmas($nt) {
		$query = "select DISTINCT(Firma) from PublicRevistasAutores where NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPublicacionesParaIndiceH($nt) {
		$query = "WITH tabla AS (
		SELECT CitasRecibidas, Fuente FROM PublicacionesFuentes WHERE RefPublicacion IN
		(SELECT
		distinct PublicacionesRevistas.Identificador
		FROM PublicacionesRevistas JOIN PublicRevistasAutores
		ON PublicacionesRevistas.Identificador = PublicRevistasAutores.RefPublicacion
		JOIN PublicRevistasFuentes
		ON PublicRevistasFuentes.RefPublicacion = PublicacionesRevistas.Identificador
		WHERE PublicRevistasAutores.NumeroEmpleado='$nt' 
		AND Localizador IS NOT NULL
		AND (CodigoFuente ='000' OR CodigoFuente='010')))
		SELECT * FROM tabla WHERE Fuente='SCOPUS(SJR)'
		AND CitasRecibidas>0
		ORDER BY CitasRecibidas DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	//Sólo ARTICULOS wos, scopus, pubmed
	function getListaPublicaciones($nt) {
		$query = "SELECT
		distinct PublicacionesRevistas.Identificador,RevistaTitulo, Titulo, YEAR(FechaPublicacion) AS anio
		FROM PublicacionesRevistas JOIN PublicRevistasAutores
		ON PublicacionesRevistas.Identificador = PublicRevistasAutores.RefPublicacion
		JOIN PublicRevistasFuentes
		ON PublicRevistasFuentes.RefPublicacion = PublicacionesRevistas.Identificador
		WHERE PublicRevistasAutores.NumeroEmpleado='$nt' 
		AND Localizador IS NOT NULL
		AND (CodigoFuente ='000' OR CodigoFuente='010' OR CodigoFuente='015')
		AND CodigoAlcance='ART'
		ORDER BY YEAR(FechaPublicacion) DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Sólo LIBROS COMPLETOS wos, scopus, pubmed
	function getListaPublicacionesLibrosInd($nt) {
		$query = "SELECT
		distinct  PublicacionesObras.Identificador, ObraIsbn, ObraTitulo, YEAR(FechaPublicacion) AS anio
		FROM PublicacionesObras JOIN PublicObrasAutores
		ON PublicacionesObras.Identificador = PublicObrasAutores.RefPublicacion
		JOIN PublicObrasFuentes
		ON PublicObrasFuentes.RefPublicacion = PublicacionesObras.Identificador
		WHERE PublicObrasAutores.NumeroEmpleado='$nt' 
		AND Localizador IS NOT NULL
		AND (CodigoFuente ='000' OR CodigoFuente='010' OR CodigoFuente='015')
		AND (CodigoAlcance='BOO' OR CodigoAlcance='COM')
		ORDER BY YEAR(FechaPublicacion) DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Sólo CAPS DE LIBROS wos, scopus, pubmed
	function getListaPublicacionesLibrosIndCaps($nt) {
		$query = "SELECT
		distinct  PublicacionesObras.Identificador, ObraIsbn, ObraTitulo, Titulo, YEAR(FechaPublicacion) AS anio
		FROM PublicacionesObras JOIN PublicObrasAutores
		ON PublicacionesObras.Identificador = PublicObrasAutores.RefPublicacion
		JOIN PublicObrasFuentes
		ON PublicObrasFuentes.RefPublicacion = PublicacionesObras.Identificador
		WHERE PublicObrasAutores.NumeroEmpleado='$nt' 
		AND Localizador IS NOT NULL
		AND (CodigoFuente ='000' OR CodigoFuente='010' OR CodigoFuente='015')
		AND (CodigoAlcance='CAP' OR CodigoAlcance='CA2' OR CodigoAlcance='LIB')
		ORDER BY YEAR(FechaPublicacion) DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//CUALQUIER COSA NO ART, CAP O LIBRO EN wos, scopus, pubmed
	function getListaPublicacionesIndOtroTipo($idPersona) {
		$query = "SELECT
		DISTINCT Publicaciones.Identificador, Titulo, Alcance, YEAR(FechaPublicacion) as anio
		FROM Publicaciones JOIN PublicacionesAutores
		ON Publicaciones.Identificador = PublicacionesAutores.RefPublicacion
		JOIN PublicacionesFuentes
		ON PublicacionesFuentes.RefPublicacion = Publicaciones.Identificador
		WHERE RefPersona='$idPersona'
		AND Localizador IS NOT NULL
		AND (CodigoFuente ='000' OR CodigoFuente='010' OR CodigoFuente='015')
		AND CodigoAlcance NOT IN ('ART','BOO', 'COM','CAP', 'CA2')
		ORDER BY YEAR(FechaPublicacion) DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Articulos no indexados
	function getListaPublicacionesNoIndArt($refP) {
		$query = "select pr.Identificador as id, titulo , pr.RevistaIssn as issn, pr.RevistaTitulo,
		 YEAR(pr.FechaPublicacion) as anno
		 from PublicacionesRevistas as pr
		left join
		(select count(tab.Identificador) as num, tab.Identificador
		from (
		select distinct p.identificador, pf.localizador from PublicacionesRevistas as p
		left join PublicacionesFuentes as pf
		on pf.RefPublicacion = p.Identificador
		where localizador is not null
		) as tab
		group by tab.Identificador) as gt
		on gt.Identificador = pr.Identificador
		join PublicRevistasAutores as pa
		on pa.RefPublicacion = pr.Identificador
		where num is null
		AND RefPersona='$refP'
		and Alcance='Article'
		ORDER BY anno DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	
	function getCapsNoInd($refP) {
		$query = "select pr.Identificador as Identificador, Titulo, Alcance, YEAR(FechaPublicacion) as anio, pr.ObraIsbn as isbn, pr.ObraEditorial as Editorial
		 from PublicacionesObras as pr
		left join
		(select count(tab.Identificador) as num, tab.Identificador
		from (
		select distinct p.identificador, pf.localizador from PublicacionesObras as p
		left join PublicacionesFuentes as pf
		on pf.RefPublicacion = p.Identificador
		where localizador is not null
		) as tab
		group by tab.Identificador) as gt
		on gt.Identificador = pr.Identificador
		join PublicObrasAutores as pa
		on pa.RefPublicacion = pr.Identificador
		where num is null
		AND RefPersona='$refP'
		and ( CodigoAlcance='CAP' OR CodigoAlcance='CA2')
		ORDER BY anio DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Otros productos no indexados
	function getListaPublicacionesNoIndOtros($ref) {
		$query = "select pr.Identificador, Titulo, Alcance, YEAR(FechaPublicacion) as anio
		 from PublicacionesRevistas as pr
		left join
		(select count(tab.Identificador) as num, tab.Identificador
		from (
		select distinct p.identificador, pf.localizador from PublicacionesRevistas as p
		left join PublicacionesFuentes as pf
		on pf.RefPublicacion = p.Identificador
		where localizador is not null
		) as tab
		group by tab.Identificador) as gt
		on gt.Identificador = pr.Identificador
		join PublicRevistasAutores as pa
		on pa.RefPublicacion = pr.Identificador
		where num is null
		AND RefPersona='$ref'
		and Alcance!='Article'
		ORDER BY anio DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Autores de Articulos
	function getAutores($pub) {
		$query = "select * from PublicRevistasAutores
		WHERE RefPublicacion='$pub'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Autores de Libros completos
	function getAutoresLibrosCompletos($pub) {
		$query = "select * from PublicObrasAutores
		WHERE RefPublicacion='$pub'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Autores de cualquier tipo de pub indexada 
	function getAutoresLoDemas($pub) {
		$query = "select * from PublicacionesAutores JOIN Personas ON PublicacionesAutores.RefPersona=Personas.Identificador where RefPublicacion='$pub'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	//Autores de una pub Humanindex
	function getAutoresHumanindex($pub) {
		$query = "select NombreCompleto from UNAM_DGEI_DB.dbo.Articulos_Autor_HX
			JOIN Personas ON Personas.NumeroEmpleado COLLATE Modern_Spanish_CS_AS = UNAM_DGEI_DB.dbo.Articulos_Autor_HX.NUMEMPLEADO
			WHERE UNAM_DGEI_DB.dbo.Articulos_Autor_HX.ID='$pub' ";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getCapitulosHumanindex($nt) {
		$query = "SELECT  UNAM_DGEI_DB.dbo.Capitulos_HX.id_fuente as Identificador, isbn, anno, editorial,
		titulo_libro, titulo_capitulo
		FROM UNAM_DGEI_DB.dbo.Capitulos_HX
		JOIN UNAM_DGEI_DB.dbo.Capitulos_Autores_HX ON UNAM_DGEI_DB.dbo.Capitulos_HX.id_fuente =  UNAM_DGEI_DB.dbo.Capitulos_Autores_HX.ID
		WHERE NUMEMPLEADO='$nt'
		ORDER BY anno Desc";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	//Autores de una pub no indexada
	function getAutoresNoIndexadas($pub) {
		$query = "SELECT NombreCompleto FROM PublicRevistasAutores WHERE RefPublicacion='$pub'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	
	function getPonenciasHumanindex($nt) {
		$query = "select titulo, memoria, isbn, editorial, compilador, anno from UNAM_DGEI_DB.dbo.Ponencias_HX
		JOIN UNAM_DGEI_DB.dbo.Ponencias_Autor_HX
		ON UNAM_DGEI_DB.dbo.Ponencias_HX.id_fuente = UNAM_DGEI_DB.dbo.Ponencias_Autor_HX.ID WHERE NUMEMPLEADO='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Autores de una pub Humanindex
	function getAutoresCapsHumanindex($pub) {
		$query = "select NombreCompleto from UNAM_DGEI_DB.dbo.Capitulos_Autores_HX JOIN Personas ON Personas.NumeroEmpleado COLLATE Modern_Spanish_CS_AS = UNAM_DGEI_DB.dbo.Capitulos_Autores_HX.NUMEMPLEADO WHERE UNAM_DGEI_DB.dbo.Capitulos_Autores_HX.ID='$pub'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Autores de un libro Humanindex
	function getAutoresLibrosHumanindex($pub) {
		$query = "select NombreCompleto from UNAM_DGEI_DB.dbo.Libros_Autor_HX
			JOIN Personas ON Personas.NumeroEmpleado COLLATE Modern_Spanish_CS_AS = UNAM_DGEI_DB.dbo.Libros_Autor_HX.NumEmpleado
			WHERE UNAM_DGEI_DB.dbo.Libros_Autor_HX.id_fuente='$pub'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Autores de un libro no indexado
	function getAutoresLibrosNoIndexados($pub) {
		$query = "select NombreCompleto from PublicObrasAutores WHERE refPublicacion='$pub'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	//Fuentes y citas de Articulos
	function getFuentesYCitas($pub) {
		$query = "SELECT * FROM PublicRevistasFuentes
		WHERE RefPublicacion='$pub';";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	//Fuentes y citas de Libros completos
	function getFuentesYCitasLibrosCompletos($pub) {
		$query = "SELECT * FROM PublicObrasFuentes
		WHERE RefPublicacion='$pub';";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	//Fuentes y citas de otras cosas indexadas
	function getFuentesYCitasLoDemas($pub) {
		$query = "SELECT * FROM Publicaciones JOIN PublicacionesFuentes ON Publicaciones.Identificador=PublicacionesFuentes.RefPublicacion WHERE RefPublicacion ='$pub'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	
	function getSNI($nt) {
		$query = "select EstimuloOtorgado, FechaDesde, FechaHasta from EstimulosSni WHERE NumeroEmpleado='$nt' ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getPRIDE($nt) {
		$query = "select EstimuloOtorgado, FechaDesde, FechaHasta, FechaCreacion from EstimulosPride WHERE NumeroEmpleado='$nt'  ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getPEPASIG($nt) {
		$query = "select EstimuloOtorgado, NumeroHorasSemana ,FechaDesde, FechaHasta from  EstimulosPepasig WHERE NumeroEmpleado='$nt'  ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getPASPA($nt) {
		$query = "select EstimuloOtorgado, FechaDesde, FechaHasta from EstimulosPaspa WHERE NumeroEmpleado='$nt' ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getHONORIS($nt) {
		$query = "select EstimuloOtorgado, FechaDesde, FechaHasta from EstimulosHonorisCausa WHERE NumeroEmpleado='$nt' ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getCATEDRA($nt) {
		$query = "SELECT EstimuloOtorgado, FechaDesde, FechaHasta  FROM EstimulosCatedra WHERE NumeroEmpleado='$nt' ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getESPECIALES($nt) {
		$query = "select EstimuloOtorgado, FechaDesde, FechaHasta from EstimulosEspeciales WHERE NumeroEmpleado='$nt'  ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getRDUNJA($nt) {
		$query = "select EstimuloOtorgado, FechaDesde, FechaHasta from EstimulosRdunja WHERE NumeroEmpleado='$nt' ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getPUN($nt) {
		$query = "select EstimuloOtorgado, FechaDesde, FechaHasta from EstimulosPun WHERE NumeroEmpleado='$nt'  ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getSNCA($nt) {
		$query = "select EstimuloOtorgado, FechaDesde, FechaHasta from EstimulosSnca WHERE NumeroEmpleado='$nt' ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEQUIVALENCIA($nt) {
		$query = "select EstimuloOtorgado, FechaDesde, FechaHasta from EstimulosEquivalencia WHERE NumeroEmpleado='$nt' ORDER BY FechaDesde DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAreasConocimiento($nt) {
		$query = "WITH tabla as (
					SELECT DISTINCT CategoriaJcr, CategoriaSjr FROM PublicRevistasAutores JOIN PublicacionesRevistas 
					ON PublicacionesRevistas.Identificador = PublicRevistasAutores.RefPublicacion WHERE NumeroEmpleado='$nt' 
					AND ( (CategoriaJcr IS NOT NULL) OR (CategoriaSjr IS NOT NULL)))
					SELECT distinct CASE WHEN CategoriaJcr IS NOT NULL THEN CategoriaJcr 
								 WHEN CategoriaSjr IS NOT NULL THEN CategoriaSjr
							END
					AS categoria
					FROM tabla
					ORDER BY categoria";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getRevistasHaPublicado($nt) {
		$query = "WITH tabla as (
				SELECT distinct RevistaTitulo, RevistaPaisEdicion, YEAR(FechaPublicacion) AS anio
				FROM PublicacionesRevistas JOIN PublicRevistasAutores
				ON PublicacionesRevistas.Identificador = PublicRevistasAutores.RefPublicacion
				WHERE PublicRevistasAutores.NumeroEmpleado='$nt' 
				)
				SELECT RevistaTitulo, RevistaPaisEdicion,
				STRING_AGG(anio, ', ') as anio from tabla
				GROUP BY RevistaTitulo, RevistaPaisEdicion
				ORDER BY RevistaTitulo";
		$consulta = Query::selectLibre($query);	
		return $consulta;

	}
	
	
	function colabs1($nt) {
		$query = "SELECT DISTINCT(Entidad)
					FROM PublicacionesRevistas JOIN PublicRevistasAutores
					ON PublicacionesRevistas.Identificador = PublicRevistasAutores.RefPublicacion
					JOIN Adscripciones on PublicRevistasAutores.NumeroEmpleado=Adscripciones.NumeroEmpleado
					WHERE PublicRevistasAutores.NumeroEmpleado='$nt' 
					AND ((FechaPublicacion>= FechaDesde AND FechaPublicacion <= FechaHasta) OR  (FechaPublicacion>= FechaDesde 
					AND FechaHasta is null))";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function colabs2($nt) {
		$query = "SELECT distinct(Institucion)
					FROM Tesis JOIN TesisParticipantes 
					ON Tesis.Identificador = TesisParticipantes.RefTesis
					WHERE NumeroEmpleado='$nt'
					AND Institucion IS NOT NULL
					AND Institucion != ''";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	
	//CVU funciones
	function getFirmaByNTNP($nt, $np) {
		$query = "select Firma from PublicRevistasAutores where RefPublicacion ='$np' AND NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function desligarArticulo($nt, $np, $firma, $fecha) {
		$query = "INSERT INTO CVU_proto.dbo.desvinculacionPublicacion (NumeroEmpleado, idPublicacionSIIA, firma, fechaDesvinculacion, estadoRevision) VALUES('$nt', '$np', '$firma', '$fecha', '1')";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function desligarTesis($nt, $np, $fecha) {
		$query = "INSERT INTO CVU_proto.dbo.desvinculacionTesis (NumeroEmpleado, idTesisSIIA, fechaDesvinculacion, estadoRevision) VALUES('$nt', '$np', '$fecha', '1')";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function desvinculacionDocencia($nt, $np, $fecha) {
		$query = "INSERT INTO CVU_proto.dbo.desvinculacionDocencia (NumeroEmpleado, idGrupoSIIA, fechaDesvinculacion, estadoRevision) VALUES('$nt', '$np', '$fecha', '1')";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function BorrarDesligarArticulo($id, $nt) {
		$query = "DELETE FROM CVU_proto.dbo.desvinculacionPublicacion WHERE idPublicacionSIIA='$id' AND NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	

	function BorrarDesligarDocencia($id, $nt) {
		$query = "DELETE FROM CVU_proto.dbo.desvinculacionDocencia WHERE idGrupoSIIA='$id' AND NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function BorrarConfirmarArticulo($id, $nt) {
		$query = "DELETE FROM CVU_proto.dbo.validacionPublicacion WHERE idPublicacionSIIA='$id' AND NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function BorrarConfirmarTesis($id, $nt) {
		$query = "DELETE FROM CVU_proto.dbo.validacionTesis WHERE idTesisSIIA='$id' AND NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function BorrarDesligarTesis($id, $nt) {
		$query = "DELETE FROM CVU_proto.dbo.desvinculacionTesis WHERE idTesisSIIA='$id' AND NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function BorrarConfirmarDocencia($id, $nt) {
		$query = "DELETE FROM CVU_proto.dbo.validacionDocencia WHERE idGrupoSIIA='$id' AND NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function revisaBaja($nt, $np) {
		$query = "select * from CVU_proto.dbo.desvinculacionPublicacion WHERE NumeroEmpleado='$nt' AND idPublicacionSIIA='$np'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function confirmarArticulo($nt, $np, $fecha) {
		$query = "INSERT INTO CVU_proto.dbo.validacionPublicacion(NumeroEmpleado, idPublicacionSIIA, fechaValidacion) VALUES('$nt', '$np', '$fecha')";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function confirmarTesis($nt, $np, $fecha) {
		$query = "INSERT INTO CVU_proto.dbo.validacionTesis(NumeroEmpleado, idTesisSIIA, fechaValidacion) VALUES('$nt', '$np', '$fecha')";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function confirmarDocencia($nt, $np, $fecha) {
		$query = "INSERT INTO CVU_proto.dbo.validacionDocencia(NumeroEmpleado, idGrupoSIIA, fechaValidacion) VALUES('$nt', '$np', '$fecha')";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function limpiaTabla() {
		$query = "DELETE FROM validacionPublicacion WHERE idPublicacionSIIA=0";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function limpiaTabla2() {
		$query = "DELETE FROM CVU_proto.dbo.desvinculacionPublicacion WHERE idPublicacionSIIA=0";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function limpiaTablaTesis() {
		$query = "DELETE FROM CVU_proto.dbo.desvinculacionTesis WHERE idTesisSIIA=0";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function limpiaTablaTesis2() {
		$query = "DELETE FROM CVU_proto.dbo.desvinculacionTesis WHERE idTesisSIIA=0";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function limpiaTablaDocencia() {
		$query = "DELETE FROM CVU_proto.dbo.validacionDocencia WHERE idGrupoSIIA=0";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function limpiaTablaDocencia2() {
		$query = "DELETE FROM CVU_proto.dbo.desvinculacionDocencia WHERE idGrupoSIIA=0";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getValidadas($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.validacionPublicacion WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getValidadasTesis($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.validacionTesis WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getValidadasDocencia($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.validacionDocencia WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getPorBorrar($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.desvinculacionPublicacion WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getPorBorrarTesis($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.desvinculacionTesis WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPorBorrarDocencia($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.desvinculacionDocencia WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getPubsByTitulo($titulo) {
		$query = utf8_decode("SELECT * FROM PublicacionesRevistas WHERE Titulo like '%$titulo%' AND CodigoAlcance='ART' ORDER BY Titulo");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPubsByScopusID($id) {
		$query = "SELECT * FROM PublicacionesRevistas WHERE ScopusId='$id' AND CodigoAlcance='ART'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getPubsByWosID($id) {
		$query = "SELECT * FROM PublicacionesRevistas WHERE WosId='$id' AND CodigoAlcance='ART'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getPubsByPubMedId($id) {
		$query = "SELECT * FROM PublicacionesRevistas WHERE PubMedId='$id' AND CodigoAlcance='ART'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getInfoArticuloById($id) {
		$query = "SELECT * FROM PublicacionesRevistas WHERE Identificador='$id'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function requestAgregarPublicacion($nt, $pub, $f) {
		$query = "INSERT INTO CVU_proto.dbo.contenidoPublicacion(NumeroEmpleado, idPublicacionSIIA, fechaSolicitud, tipoAclaracion, observaciones, estadoRevision) VALUES ('$nt', '$pub', '$f', 1, 'El academico quiere agregar una publicacion que no tiene', 0)";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function requestAgregarTesis($nt, $pub, $f, $c) {
		$query = "INSERT INTO CVU_proto.dbo.contenidoTesis(NumeroEmpleado, idTesisSIIA, fechaSolicitud, tipoAclaracion, observaciones, estadoRevision) VALUES ('$nt', '$pub', '$f', 1, '$c', 0)";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function requestAgregarDocencia($nt, $pub, $f, $obs) {
		$query = utf8_decode("INSERT INTO CVU_proto.dbo.contenidoDocencia(NumeroEmpleado, idGrupoSIIA, fechaSolicitud, tipoAclaracion, observaciones, estadoRevision) VALUES ('$nt', '$pub', '$f', '1', '$obs', '0')");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function requestAgregarPublicacionPorIndexarHumanindex($nt, $pub, $f) {
		$query = "INSERT INTO CVU_proto.dbo.contenidoPublicacion(NumeroEmpleado, idPublicacionSIIA, fechaSolicitud, tipoAclaracion, observaciones, estadoRevision) VALUES ('$nt', '$pub', '$f', 1, 'Indexacion Humanindex', 0)";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getSolicitudesAlta($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.contenidoPublicacion WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getSolicitudesAltaTesis($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.contenidoTesis WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getSolicitudesAltaDocencia($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.contenidoDocencia WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getDetallesQuiereAgregar($nt) {
		$query = "select *  from CVU_proto.dbo.contenidoPublicacion JOIN PublicacionesRevistas ON  CVU_proto.dbo.contenidoPublicacion.idPublicacionSIIA=PublicacionesRevistas.Identificador WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getDetallesQuiereAgregarTesis($nt) {
		$query = "SELECT * FROM Tesis JOIN CVU_proto.dbo.contenidoTesis ON Tesis.Identificador=CVU_proto.dbo.contenidoTesis.idTesisSIIA WHERE CVU_proto.dbo.contenidoTesis.NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getDetallesQuiereAgregarTesisExternasDir($nt) {
		$query = utf8_decode("select * from  CVU_proto.dbo.agregacionTesis where NumeroEmpleado='$nt' AND CAST( entidadExamenProfesional as varchar )='Externa' AND rol='Director'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getDetallesQuiereAgregarTesisExternasTut($nt) {
		$query = utf8_decode("select * from  CVU_proto.dbo.agregacionTesis where NumeroEmpleado='$nt' AND CAST( entidadExamenProfesional as varchar )='Externa' AND rol!='Director'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getDetallesQuiereAgregarDocencia($nt) {
		$query = utf8_decode("SELECT DISTINCT Entidad, Asignatura, CodigoAsignatura, 
			CodigoGrupo, PeriodoImparte, fechaSolicitud FROM DocenciaImpartida JOIN 
			CVU_proto.dbo.contenidoDocencia ON 
			DocenciaImpartida.CodigoAsignatura= contenidoDocencia.idGrupoSIIA 
			WHERE CVU_proto.dbo.contenidoDocencia.NumeroEmpleado='$nt'
			and  
			CONVERT(varchar,CVU_proto.dbo.contenidoDocencia.observaciones) 
			COLLATE Modern_Spanish_CS_AS=DocenciaImpartida.PeriodoImparte
			ORDER BY fechaSolicitud");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getDetallesQuiereAgregarDocenciaNOSIIA($nt) {
		$query = "SELECT * FROM Entidades JOIN CVU_proto.dbo.agregacionDocencia ON Entidades.Codigo COLLATE Modern_Spanish_CS_AS = CVU_proto.dbo.agregacionDocencia.codigoEntidad WHERE CVU_proto.dbo.agregacionDocencia.NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getDetallesQuiereAgregarNOSIIA($nt) {
		$query = "select * from CVU_proto.dbo.agregacionPublicacion WHERE NumeroEmpleado='$nt' AND estadoRevision=0";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getDetallesQuiereAgregarNOSIIATesis($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.agregacionTesis WHERE NumeroEmpleado='$nt' AND estadoRevision='0' AND rol='Director'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getDetallesQuiereAgregarNOSIIATesis2($nt) {
		$query = "SELECT * FROM CVU_proto.dbo.agregacionTesis WHERE NumeroEmpleado='$nt' AND estadoRevision='0' AND rol='Asesor'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function insertNuevaPublicacion($nt, $fi, $folio, $tit, $issn, $eid, $wos, $fecha) {
		$query = utf8_decode("INSERT INTO CVU_proto.dbo.agregacionPublicacion(NumeroEmpleado, firma, folio, tituloPublicacion, alcance, issn, añoPublicacion, tituloRevista, eid, wosid, estadoRevision, fechaSolicitud, Observaciones) VALUES ('$nt', '$fi', '$folio', '$tit', null, '$issn', null, null, '$eid', '$wos', 0, '$fecha', null)");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function insertNuevaTesis($nt, $randomString, $titulo, $nivel, $rol, $entidad, $url, $obs, $autor, $f_examen, $fecha, $estado, $idSIIA) {
		$query = utf8_decode("INSERT INTO CVU_proto.dbo.agregacionTesis(NumeroEmpleado, folio, tituloTesis, nivelTesis, rol, entidadExamenProfesional, url, observaciones, autor, añoExamen, fechaSolicitud, estadoRevision, idTesisSIIA, codigoDgei_Sies, claveInstitucion_Sies, clavePantel_Sies, codigoCarrera_Sies) VALUES ('$nt', '$randomString', '$titulo', '$nivel', '$rol', '$entidad', '$url', '$obs', '$autor', '$f_examen', '$fecha', '$estado', '$idSIIA', null, null, null, null)");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function insertNuevaTesisExterna($nt, $randomString, $titulo, $nivel, $rol, $entidad, $url, $obs, $autor, $f_examen, $fecha, $estado, $idSIIA, $c1, $c2, $c3, $c4) {
		$query = utf8_decode("INSERT INTO CVU_proto.dbo.agregacionTesis(NumeroEmpleado, folio, tituloTesis, nivelTesis, rol, entidadExamenProfesional, url, observaciones, autor, añoExamen, fechaSolicitud, estadoRevision, idTesisSIIA, codigoDgei_Sies, claveInstitucion_Sies, clavePantel_Sies, codigoCarrera_Sies) VALUES ('$nt', '$randomString', '$titulo', '$nivel', '$rol', '$entidad', '$url', '$obs', '$autor', '$f_examen', '$fecha', '$estado', '$idSIIA', '$c1', '$c2', '$c3', '$c4')");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function insertNuevoGrupo($nt, $randomString, $materia, $c_asignatura, $c_grupo, $nivel, $alumnos, $semestre, $entidad, $c_planEstudios, $c_programa, $idGrupoSIIA, $fecha, $observaciones, $externa) {
		$query = utf8_decode("INSERT INTO CVU_proto.dbo.agregacionDocencia (NumeroEmpleado, folio, nombreAsignatura, codigoAsignatura, CodigoGrupo,	nivel, numeroAlumnos, SemestreImparticion, codigoEntidad, CodigoPlanEstudios, CodigoPrograma, idGrupoSIIA, fechaSolicitud, Observaciones, NombreInstitucionExterna, codigoDgei_Sies, claveInstitucion_Sies, clavePantel_Sies, codigoCarrera_Sies) VALUES('$nt', '$randomString', '$materia', '$c_asignatura', '$c_grupo', '$nivel', '$alumnos', '$semestre', '$entidad', '$c_planEstudios', '$c_programa', '$idGrupoSIIA', '$fecha', '$observaciones', '$externa', null, null, null, null)");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function ligarPubHumanindex($nt, $fi, $folio, $tit, $eid, $wos, $fecha) {
		$query = utf8_decode("INSERT INTO CVU_proto.dbo.agregacionPublicacion(NumeroEmpleado, firma, folio, tituloPublicacion, alcance, issn, añoPublicacion, tituloRevista, eid, wosid, estadoRevision, fechaSolicitud, Observaciones) VALUES ('$nt', '$fi', '$folio', '$tit', null, 'Humanindex', null, null, '$eid', '$wos', 0, '$fecha', 'Ligar Humanindex')");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function LibrosCompletosNoIndexados($refP) {
		$query = utf8_decode("select pr.Identificador, Titulo, Alcance, YEAR(FechaPublicacion) as anio, pr.ObraIsbn as isbn, pr.ObraEditorial as Editorial
		 from PublicacionesObras as pr
		left join
		(select count(tab.Identificador) as num, tab.Identificador
		from (
		select distinct p.identificador, pf.localizador from PublicacionesObras as p
		left join PublicacionesFuentes as pf
		on pf.RefPublicacion = p.Identificador
		where localizador is not null
		) as tab
		group by tab.Identificador) as gt
		on gt.Identificador = pr.Identificador
		join PublicObrasAutores as pa
		on pa.RefPublicacion = pr.Identificador
		where num is null
		AND RefPersona='$refP'
		and CodigoAlcance='COM'
		ORDER BY anio DESC");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function ponenciasNoIndexados($refP) {
		$query = utf8_decode("select pr.Identificador, Titulo, Alcance, YEAR(FechaPublicacion) as anio, pr.ObraIsbn as isbn, pr.ObraEditorial as Editorial
		 from PublicacionesObras as pr
		left join
		(select count(tab.Identificador) as num, tab.Identificador
		from (
		select distinct p.identificador, pf.localizador from PublicacionesObras as p
		left join PublicacionesFuentes as pf
		on pf.RefPublicacion = p.Identificador
		where localizador is not null
		) as tab
		group by tab.Identificador) as gt
		on gt.Identificador = pr.Identificador
		join PublicObrasAutores as pa
		on pa.RefPublicacion = pr.Identificador
		where num is null
		AND RefPersona='$refP'
		and CodigoAlcance='CFP'
		ORDER BY anio DESC");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function esHumanindex($nt) {
		$query = "select * from Nombramientos JOIN Entidades ON Entidades.Identificador=Nombramientos.RefEntidad WHERE NumeroEmpleado='$nt' AND FechaHasta IS NULL";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getReportesTecnicos($nt) {
		$query = "select ReportesTecnicos.Identificador,Titulo, EntidadSolicita, YEAR(FechaPublicacion) as anio from ReportesTecnicos JOIN ReportesAutores ON ReportesTecnicos.Identificador=ReportesAutores.RefReporte where NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAutoresReportesTecnicos($id) {
		$query = "select * from ReportesAutores where RefReporte='$id'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getArticulosHumanindex($nt) {
		$query = "SELECT UNAM_DGEI_DB.dbo.Articulos_Autor_HX.ID AS Identificador, titulo, revista, issn, anno FROM UNAM_DGEI_DB.dbo.Articulos_Autor_HX
		JOIN UNAM_DGEI_DB.dbo.Articulos_HX ON UNAM_DGEI_DB.dbo.Articulos_HX.id_fuente =  UNAM_DGEI_DB.dbo.Articulos_Autor_HX.ID
		WHERE NUMEMPLEADO='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getLibrosAutoriaHumanindex($nt) {
		$query = "SELECT UNAM_DGEI_DB.dbo.Libros_HX.id_fuente as Identificador, titulo, isbn, anno, editorial FROM UNAM_DGEI_DB.dbo.Libros_HX
		JOIN UNAM_DGEI_DB.dbo.Libros_Autor_HX ON UNAM_DGEI_DB.dbo.Libros_HX.id_fuente =  UNAM_DGEI_DB.dbo.Libros_Autor_HX.id_fuente
		WHERE NUMEMPLEADO='$nt'
		AND producto='Libro'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getLibrosCompiladosHumanindex($nt) {
		$query = "SELECT UNAM_DGEI_DB.dbo.Libros_HX.id_fuente as Identificador, titulo, isbn, anno, editorial FROM UNAM_DGEI_DB.dbo.Libros_HX
		JOIN UNAM_DGEI_DB.dbo.Libros_Autor_HX ON UNAM_DGEI_DB.dbo.Libros_HX.id_fuente =  UNAM_DGEI_DB.dbo.Libros_Autor_HX.id_fuente
		WHERE NUMEMPLEADO='$nt'
		AND producto='Libro compilado'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getLibrosCoordinadosHumanindex($nt) {
		$query = "SELECT UNAM_DGEI_DB.dbo.Libros_HX.id_fuente as Identificador, titulo, isbn, anno, editorial FROM UNAM_DGEI_DB.dbo.Libros_HX
		JOIN UNAM_DGEI_DB.dbo.Libros_Autor_HX ON UNAM_DGEI_DB.dbo.Libros_HX.id_fuente =  UNAM_DGEI_DB.dbo.Libros_Autor_HX.id_fuente
		WHERE NUMEMPLEADO='$nt'
		AND producto='Libro coordinado'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getLibrosEditadosHumanindex($nt) {
		$query = "SELECT UNAM_DGEI_DB.dbo.Libros_HX.id_fuente as Identificador, titulo, isbn, anno, editorial FROM UNAM_DGEI_DB.dbo.Libros_HX
		JOIN UNAM_DGEI_DB.dbo.Libros_Autor_HX ON UNAM_DGEI_DB.dbo.Libros_HX.id_fuente =  UNAM_DGEI_DB.dbo.Libros_Autor_HX.id_fuente
		WHERE NUMEMPLEADO='$nt'
		AND producto='Libro editado'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getLibrosTraducidosHumanindex($nt) {
		$query = "SELECT UNAM_DGEI_DB.dbo.Libros_HX.id_fuente as Identificador, titulo, isbn, anno, editorial FROM UNAM_DGEI_DB.dbo.Libros_HX
		JOIN UNAM_DGEI_DB.dbo.Libros_Autor_HX ON UNAM_DGEI_DB.dbo.Libros_HX.id_fuente =  UNAM_DGEI_DB.dbo.Libros_Autor_HX.id_fuente
		WHERE NUMEMPLEADO='$nt'
		AND producto='Libro traducido'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getTodoHumanindex($nt) {
		$query = " with tabla as (
			(
			SELECT UNAM_DGEI_DB.dbo.Articulos_Autor_HX.ID AS Identificador, 'Artículo' as tipo,  titulo, concat('Revista:',revista, ' ','\nISSN:', issn) AS info, anno
			FROM UNAM_DGEI_DB.dbo.Articulos_Autor_HX
			JOIN UNAM_DGEI_DB.dbo.Articulos_HX ON UNAM_DGEI_DB.dbo.Articulos_HX.id_fuente =  UNAM_DGEI_DB.dbo.Articulos_Autor_HX.ID
			WHERE NUMEMPLEADO='$nt')
			union all
			SELECT UNAM_DGEI_DB.dbo.Libros_Autor_HX.id_fuente AS Identificador,  'Libro completo' AS tipo, titulo,  concat('ISBN:',isbn, ' ', 'Editorial:', editorial) AS info, anno
			FROM UNAM_DGEI_DB.dbo.Libros_HX
			JOIN UNAM_DGEI_DB.dbo.Libros_Autor_HX ON UNAM_DGEI_DB.dbo.Libros_HX.id_fuente= UNAM_DGEI_DB.dbo.Libros_Autor_HX.id_fuente
			WHERE NUMEMPLEADO='$nt'
			union all
			SELECT UNAM_DGEI_DB.dbo.Capitulos_Autores_HX.ID AS Identificador,  'Capítulo de libro' AS tipo, titulo_capitulo,  concat('Libro', titulo_libro, ' ', 'ISBN:',isbn, ' ', 'Editorial:', editorial) AS info, anno
			FROM UNAM_DGEI_DB.dbo.Capitulos_HX
			JOIN UNAM_DGEI_DB.dbo.Capitulos_Autores_HX ON UNAM_DGEI_DB.dbo.Capitulos_HX.id_fuente = UNAM_DGEI_DB.dbo.Capitulos_Autores_HX.ID
			WHERE NUMEMPLEADO='$nt')
			SELECT * FROM tabla ORDER BY anno DESC, titulo";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPendientesIndexar($nt) {
		$query = "select tituloPublicacion FROM CVU_proto.dbo.agregacionPublicacion WHERE NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getDocencia($nt) {
		$query = "SELECT Identificador, Asignatura, NivelTitulacion, Entidad, PeriodoImparte, YEAR(FechaDesde) as anio FROM DocenciaImpartida WHERE NumeroEmpleado='$nt' and CodigoNivelTitulacion IN ('75','5','15','10', '19') ORDER BY anio DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getDocenciaEspecial($nt) {
		$query = "SELECT Identificador, Asignatura, NivelTitulacion, Entidad, PeriodoImparte, YEAR(FechaDesde) as anio FROM DocenciaImpartida WHERE NumeroEmpleado='$nt' and CodigoNivelTitulacion IN ('01', '04') ORDER BY anio DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	
	function getTesisDirigidas($nt) {
		$query = "SELECT Tesis.Identificador, Titulo, TipoTesis, YEAR(FechaExamen) as anio, Institucion, Url FROM Tesis JOIN TesisParticipantes ON Tesis.Identificador=TesisParticipantes.RefTesis WHERE NumeroEmpleado='$nt' AND (CodigoCalidadDe='DI' OR CodigoCalidadDe='TU')  ORDER BY anio DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}

	function getTesisTutoradas($nt) {
		$query = "SELECT Tesis.Identificador, Titulo, TipoTesis, YEAR(FechaExamen) as anio, Institucion, Url FROM Tesis JOIN TesisParticipantes ON Tesis.Identificador=TesisParticipantes.RefTesis WHERE NumeroEmpleado='$nt' AND  CodigoCalidadDe='AS'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}

	
	function getTutoresTesis($id) {
		$query = "SELECT * FROM TesisParticipantes WHERE RefTesis='$id' AND ((CodigoCalidadDe='DI' OR CodigoCalidadDe='TU'))";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAsesoresTesis($id) {
		$query = "SELECT * FROM TesisParticipantes WHERE RefTesis='$id' AND CodigoCalidadDe='AS'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAutoresTesis($id) {
		$query = "SELECT * FROM TesisParticipantes WHERE RefTesis='$id' AND CodigoCalidadDe='AU'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getEntidades() {
		$query = "SELECT distinct CodigoEntidad, Entidad FROM DocenciaImpartida where CodigoEntidad != '99900' and NumeroAlumnos !=0 and Entidad!='Entidad no identificada' ORDER BY Entidad";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEntidadesLICUNAM() {
		$query = "select distinct  NombrePlantel from Execum.dbo.CatalogoPlantelCarreras JOIN Execum.dbo.CatalogoPlanteles on Execum.dbo.CatalogoPlanteles.CodigoDgei = Execum.dbo.CatalogoPlantelCarreras.CodigoDgei where Execum.dbo.CatalogoPlantelCarreras.CodigoDgei='1101' ORDER BY NombrePlantel";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getEntidadesCursosEspeciales() {
		$query = " SELECT DISTINCT Entidad FROM DocenciaImpartida WHERE CodigoNivelTitulacion IN ('01', '04') AND Entidad!='Entidad no identificada' ORDER BY Entidad";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getSemestresByEntidad($entidad) {
		$query = "SELECT distinct PeriodoImparte FROM DocenciaImpartida WHERE PeriodoImparte IS NOT NULL AND CodigoEntidad='$entidad' ORDER BY PeriodoImparte DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getAniosEspecialesByEntidad($entidad) {
		$query = utf8_decode("SELECT distinct(YEAR(FechaHasta)) AS anio FROM DocenciaImpartida WHERE CodigoNivelTitulacion IN ('01', '04') AND Entidad='$entidad' ORDER BY YEAR(FechaHasta)");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getAsignaturas($entidad, $semestre) {
		$query = "SELECT DISTINCT  Asignatura FROM DocenciaImpartida where CodigoEntidad = '$entidad' and PeriodoImparte='$semestre' ORDER BY Asignatura";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAsignaturasEspeciales($entidad, $semestre) {
		$query = utf8_decode("SELECT DISTINCT  Asignatura FROM DocenciaImpartida where Entidad = '$entidad' and YEAR(FechaHasta)='$semestre' AND CodigoNivelTitulacion IN ('01', '04') ORDER BY Asignatura");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getGrupos($entidad, $semestre, $asignatura) {
		$query = utf8_decode("SELECT DISTINCT  CodigoGrupo FROM DocenciaImpartida where CodigoEntidad = '$entidad' and PeriodoImparte='$semestre' AND Asignatura='$asignatura' ORDER BY CodigoGrupo");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getGruposEspeciales($entidad, $semestre, $asignatura) {
		$query = utf8_decode("SELECT DISTINCT  CodigoGrupo FROM DocenciaImpartida where Entidad = '$entidad' and YEAR(FechaHasta)='$semestre' AND Asignatura='$asignatura' ORDER BY CodigoGrupo");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAniosTesis($inst, $tipo) {
		$query = "SELECT distinct(YEAR(FechaExamen)) as anio FROM Tesis WHERE CodigoInstitucion='$inst' AND CodigoTipoTesis='$tipo' ORDER BY YEAR(FechaExamen) DESC";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEntidadByTipoTesis($tipo) {
		$query = "SELECT distinct CodigoInstitucion, Institucion FROM Tesis WHERE CodigoInstitucion IS NOT NULL AND CodigoTipoTesis='$tipo' ORDER BY Institucion";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getTesisNombres($nivel, $entidad, $anio) {
		$query = "SELECT Identificador, Titulo FROM Tesis WHERE CodigoTipoTesis='$nivel' AND CodigoInstitucion='$entidad' AND YEAR(FechaExamen)='$anio' ORDER BY Titulo";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getInfoDocenciaByDatos($entidad, $semestre, $nombre, $grupo) {
		$query = utf8_decode("SELECT * FROM DocenciaImpartida WHERE CodigoEntidad='$entidad' AND PeriodoImparte='$semestre' AND Asignatura='$nombre' AND CodigoGrupo='$grupo'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getListadoSemestres() {
		$query = utf8_decode("select distinct PeriodoImparte from DocenciaImpartida where PeriodoImparte is not null order by PeriodoImparte desc");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getNombreEntidad($c) {
		$query = utf8_decode("select * from Entidades where Codigo='$c'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getInfoTesisById($id) {
		$query = utf8_decode("select * from Tesis where Identificador='$id'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getEntidadesDGEI() {
		$query = utf8_decode("select * from Execum.dbo.CatalogoDGEI WHERE CodigoDgei!=0 order by NombreInstitucion");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPlantelesSIES($uni) {
		$query = utf8_decode("select distinct NombrePlantel from Execum.dbo.CatalogoPlanteles WHERE NombreInstitucionDGEI='$uni' ORDER BY Execum.dbo.CatalogoPlanteles.NombrePlantel;");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getNivelesSIES($uni, $plantel) {
		$query = "SELECT distinct Nivel  FROM  Execum.dbo.CatalogoPlantelCarreras JOIN Execum.dbo.CatalogoPlanteles ON  Execum.dbo.CatalogoPlantelCarreras.ClavePlantel=Execum.dbo.CatalogoPlanteles.ClavePlantel WHERE  Execum.dbo.CatalogoPlantelCarreras.NombreInstitucionDgei='$uni' AND NombrePlantel='$plantel'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getCarrerasSIES($uni, $plantel, $nivel) {
		$query = utf8_decode("SELECT distinct NombreCarrera  FROM  Execum.dbo.CatalogoPlantelCarreras
		JOIN Execum.dbo.CatalogoPlanteles ON 	Execum.dbo.CatalogoPlantelCarreras.ClavePlantel=Execum.dbo.CatalogoPlanteles.ClavePlantel WHERE  Execum.dbo.CatalogoPlantelCarreras.NombreInstitucionDgei='$uni'
		AND Nivel LIKE '$nivel%'
		AND NombrePlantel='$plantel'
		order by  NombreCarrera");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getCodigosSIES($uni, $plantel, $nivel, $carrera) {
		$query = utf8_decode("with tabla AS (
			select CodigoDgei, Nivel, NombreCarrera, CodigoCarrera from Execum.dbo.Matricula
			UNION ALL
			select CodigoDgei, Nivel, NombreCarrera, CodigoCarrera from Execum.dbo.MatriculaPosgrado
			)
			SELECT * FROM tabla
			JOIN Execum.dbo.CatalogoPlanteles on
			Execum.dbo.CatalogoPlanteles.CodigoDgei = tabla.CodigoDgei
			WHERE NombreInstitucionDGEI='$uni'
			AND NombrePlantel='$plantel'
			AND Nivel like '$nivel%'
			AND NombreCarrera='$carrera'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getNombreEntidadSIES($id) {
		$query = utf8_decode("select * from Execum.dbo.CatalogoDGEI WHERE CodigoDgei='$id'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getSNIS($nt) {
		$query = utf8_decode("select * from EstimulosSni where NumeroEmpleado='$nt' order by CodigoEstimuloOtorgado desc");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getCatedras($nt) {
		$query = utf8_decode("select * from EstimulosCatedra where NumeroEmpleado='$nt' order by FechaDesde desc");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getListadoEcatedra() {
		$query = utf8_decode("select distinct(EstimuloOtorgado) from EstimulosCatedra order by EstimuloOtorgado");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEEspeciales($nt) {
		$query = utf8_decode("select * from EstimulosEspeciales where NumeroEmpleado='$nt' order by FechaDesde desc");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}

	function getListadoEEspeciales() {
		$query = utf8_decode("select distinct(EstimuloOtorgado) from EstimulosEspeciales order by EstimuloOtorgado");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}


	function getEHonoris($nt) {
		$query = utf8_decode("select * from EstimulosHonorisCausa where NumeroEmpleado='$nt' order by FechaDesde desc");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAreas() {
		$query = utf8_decode("select distinct(granArea) from EstimulosHonorisCausa order by granArea ");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEPASPA($nt) {
		$query = utf8_decode("select * from EstimulosPaspa where NumeroEmpleado='$nt' order by FechaDesde desc;");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEstimulosNombrePASPA() {
		$query = utf8_decode("select distinct EstimuloOtorgado from EstimulosPaspa order by EstimuloOtorgado");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getGranAreasPASPA() {
		$query = utf8_decode("select distinct GranArea from EstimulosPaspa order by GranArea");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAreasPASPA() {
		$query = utf8_decode("select distinct Area from EstimulosPaspa order by Area");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	

	function getEPEPASIG($nt) {
		$query = utf8_decode("select * from EstimulosPepasig where NumeroEmpleado='$nt' order by FechaDesde desc");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEPRIDE($nt) {
		$query = utf8_decode("select * from EstimulosPride where NumeroEmpleado='$nt' order by FechaDesde desc");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getEPUN($nt) {
		$query = utf8_decode("select * from EstimulosPun WHERE NumeroEmpleado='$nt' order by FechaDesde DESC");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEstimulosPUN() {
		$query = utf8_decode("select distinct CodigoEstimuloOtorgado, EstimuloOtorgado from EstimulosPun ORDER BY EstimuloOtorgado");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getERDUNJA($nt) {
		$query = utf8_decode("select * from EstimulosRdunja WHERE NumeroEmpleado='$nt' order by FechaDesde DESC");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEstimulosRDUNJA() {
		$query = utf8_decode("select distinct CodigoEstimuloOtorgado, EstimuloOtorgado from EstimulosRdunja ORDER BY EstimuloOtorgado");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getESNCA($nt) {
		$query = utf8_decode("select * from EstimulosSnca WHERE NumeroEmpleado='$nt' order by FechaDesde DESC");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getEstimulosSNCA() {
		$query = utf8_decode("select distinct CodigoEstimuloOtorgado, EstimuloOtorgado from EstimulosSnca ORDER BY EstimuloOtorgado");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getGranAreaSNCA() {
		$query = utf8_decode("select distinct GranArea from EstimulosSnca WHERE GranArea is not null ORDER BY GranArea ");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAreaSNCA() {
		$query = utf8_decode("select distinct Area from EstimulosSnca WHERE Area is not null ORDER BY Area");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getProyectosSISEPRO($nt) {
		$query = utf8_decode("select * from ProyectosPersonas JOIN Proyectos ON ProyectosPersonas.RefProyecto=Proyectos.Identificador WHERE NumeroEmpleado='$nt' ORDER BY FechaInicio DESC");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getParticipantesProyectosSISEPRO($id) {
		$query = utf8_decode("select * from ProyectosPersonas WHERE RefProyecto='$id'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAreasByConv($id) {
		$query = utf8_decode("select distinct Area, CodigoArea  from Proyectos where CodigoConvocatoria='$id' and Area is not null ORDER BY Area");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getProyectosByConvArea($id, $a) {
		$query = utf8_decode("select distinct Nombre, Identificador FROM Proyectos where CodigoConvocatoria='$id' and CodigoArea='$a' ORDER BY Nombre");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getAreasAllProyectos() {
		$query = utf8_decode("select distinct Area, CodigoArea from Proyectos WHERE Area is not null ORDER BY Area");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getRedesTematicas($nt) {
		$query = utf8_decode("select distinct
		Execum.dbo.RedesTematicas.NumProyecto, CampoConocimiento, Disciplina, AñoApoyo as anio, Titulo,
		MontoAutorizado from Execum.dbo.MiembrosRedesTematicas
		JOIN Nombramientos
		ON Nombramientos.NombreCompleto=Execum.dbo.MiembrosRedesTematicas.NombreCompleto 
		collate Traditional_Spanish_CI_AI
		JOIN Execum.dbo.RedesTematicas on Execum.dbo.RedesTematicas.NumProyecto=Execum.dbo.MiembrosRedesTematicas.NumProyecto
		WHERE NumeroEmpleado='$nt'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getTitulosRedesTematicas() {
		$query = utf8_decode("select distinct Titulo from Execum.dbo.MiembrosRedesTematicas JOIN Nombramientos
		ON Nombramientos.NombreCompleto=Execum.dbo.MiembrosRedesTematicas.NombreCompleto 
		collate Traditional_Spanish_CI_AI
		JOIN Execum.dbo.RedesTematicas on Execum.dbo.RedesTematicas.NumProyecto=Execum.dbo.MiembrosRedesTematicas.NumProyecto");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getReportesTecnicosCIC($nt) {
		$query = utf8_decode("select EntidadSolicita, Titulo, YEAR(FechaPublicacion) as anio, CalidadDe from ReportesTecnicos JOIN ReportesAutores On ReportesTecnicos.Identificador=ReportesAutores.RefReporte WHERE NumeroEmpleado='$nt'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAniosReportes() {
		$query = utf8_decode("select distinct YEAR(FechaPublicacion) as anio from ReportesTecnicos JOIN ReportesAutores On ReportesTecnicos.Identificador=ReportesAutores.RefReporte ORDER BY anio");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getEntidadesReportesByAnio($anio) {
		$query = utf8_decode("select distinct EntidadSolicita, CodigoEntidadSolicita from ReportesTecnicos JOIN ReportesAutores On ReportesTecnicos.Identificador=ReportesAutores.RefReporte WHERE YEAR(FechaPublicacion) ='$anio' ORDER BY EntidadSolicita");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getTitulosReportesByAnioEntidad($anio, $entidad) {
		$query = utf8_decode("select distinct Titulo, ReportesTecnicos.Identificador  from ReportesTecnicos JOIN ReportesAutores On ReportesTecnicos.Identificador=ReportesAutores.RefReporte WHERE YEAR(FechaPublicacion)='$anio' AND CodigoEntidadSolicita='$entidad' ORDER BY Titulo");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPatentesSolACademico($nombre) {
		$query = utf8_decode("select distinct Execum.dbo.Patentes.NumeroSolicitud, Titulo, Año as anio, Inventores from Execum.dbo.Patentes JOIN  Execum.dbo.ParticipantesPatentes ON Execum.dbo.Patentes.NumeroSolicitud = Execum.dbo.ParticipantesPatentes.NumeroSolicitud WHERE Inventores LIKE '%$nombre%'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPatentesOtoAcademico($nombre) {
		$query = utf8_decode("select distinct Execum.dbo.PatentesOtorgadas.NumeroSolicitud, Titulo, Año as anio, Inventores from Execum.dbo.PatentesOtorgadas JOIN  Execum.dbo.ParticipantesPatentesOtorgadas ON Execum.dbo.PatentesOtorgadas.NumeroSolicitud = Execum.dbo.ParticipantesPatentesOtorgadas.NumeroSolicitud WHERE Inventores LIKE '%$nombre%'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getDetallesPatentesSolByNum($ns) {
		$query = utf8_decode("select * from Execum.dbo.Patentes WHERE NumeroSolicitud='$ns'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getEntidadesConPatentes() {
		$query = utf8_decode("select distinct NombreInstitucion from Execum.dbo.ParticipantesPatentes JOIN Execum.dbo.CatalogoDGEI ON  Execum.dbo.ParticipantesPatentes.CodigoDgei=Execum.dbo.CatalogoDGEI.CodigoDgei;");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEntidadesConPatentesOtorgadas() {
		$query = utf8_decode("select distinct NombreInstitucion from Execum.dbo.ParticipantesPatentesOtorgadas JOIN Execum.dbo.CatalogoDGEI ON  Execum.dbo.ParticipantesPatentesOtorgadas.CodigoDgei=Execum.dbo.CatalogoDGEI.CodigoDgei;");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAniosPlantelesBYEntidad($uni) {
		$query = utf8_decode("select distinct Año as anio from Execum.dbo.Patentes
		JOIN Execum.dbo.ParticipantesPatentes
		ON Execum.dbo.Patentes.NumeroSolicitud=Execum.dbo.Patentes.NumeroSolicitud
		JOIN Execum.dbo.CatalogoDGEI
		On Execum.dbo.CatalogoDGEI.CodigoDgei = Execum.dbo.ParticipantesPatentes.CodigoDgei
		WHERE Execum.dbo.CatalogoDGEI.NombreInstitucion='$uni'
		ORDER BY anio");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getAniosPlantelesBYEntidadSol($uni) {
		$query = utf8_decode("select distinct Año as anio from Execum.dbo.PatentesOtorgadas
		JOIN Execum.dbo.ParticipantesPatentesOtorgadas
		ON Execum.dbo.PatentesOtorgadas.NumeroSolicitud=Execum.dbo.PatentesOtorgadas.NumeroSolicitud
		JOIN Execum.dbo.CatalogoDGEI
		On Execum.dbo.CatalogoDGEI.CodigoDgei = Execum.dbo.ParticipantesPatentesOtorgadas.CodigoDgei
		WHERE Execum.dbo.CatalogoDGEI.NombreInstitucion='$uni'
		ORDER BY anio");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getTitulosPatentesSolByUniAnio($uni, $anio) {
		$query = utf8_decode("select DISTINCT Titulo from Execum.dbo.ParticipantesPatentes
		JOIN Execum.dbo.CatalogoDGEI ON Execum.dbo.CatalogoDGEI.CodigoDgei=Execum.dbo.ParticipantesPatentes.CodigoDgei
		JOIN Execum.dbo.Patentes ON Execum.dbo.Patentes.NumeroSolicitud=Execum.dbo.ParticipantesPatentes.NumeroSolicitud where  NombreInstitucion='$uni' AND Año='$anio' ORDER BY Titulo");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getTitulosPatentesOtoByUniAnio($uni, $anio) {
		$query = utf8_decode("select DISTINCT Titulo from Execum.dbo.ParticipantesPatentesOtorgadas
		JOIN Execum.dbo.CatalogoDGEI ON Execum.dbo.CatalogoDGEI.CodigoDgei=Execum.dbo.ParticipantesPatentesOtorgadas.CodigoDgei
		JOIN Execum.dbo.PatentesOtorgadas ON Execum.dbo.PatentesOtorgadas.NumeroSolicitud=Execum.dbo.ParticipantesPatentesOtorgadas.NumeroSolicitud where  NombreInstitucion='$uni' AND Año='$anio' ORDER BY Titulo");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPatentesRegistroPersona($nombre) {
		$query = utf8_decode("select DISTINCT Execum.dbo.Patentes.NumeroSolicitud,  
		Inventores, Titulo
		from Execum.dbo.ParticipantesPatentes
		JOIN Execum.dbo.CatalogoDGEI
		ON Execum.dbo.CatalogoDGEI.CodigoDgei=Execum.dbo.ParticipantesPatentes.CodigoDgei
		JOIN Execum.dbo.Patentes ON 	Execum.dbo.Patentes.NumeroSolicitud=Execum.dbo.ParticipantesPatentes.NumeroSolicitud where  Inventores LIKE '%$nombre%'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPatentesOtoRegistroPersona($nombre) {
		$query = utf8_decode("select DISTINCT Execum.dbo.PatentesOtorgadas.NumeroSolicitud,  
		Inventores, Titulo
		from Execum.dbo.ParticipantesPatentesOtorgadas
		JOIN Execum.dbo.CatalogoDGEI
		ON Execum.dbo.CatalogoDGEI.CodigoDgei=Execum.dbo.ParticipantesPatentesOtorgadas.CodigoDgei
		JOIN Execum.dbo.PatentesOtorgadas ON 	Execum.dbo.PatentesOtorgadas.NumeroSolicitud=Execum.dbo.ParticipantesPatentesOtorgadas.NumeroSolicitud where  Inventores LIKE '%$nombre%'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getEntidadFederativa() {
		$query = utf8_decode("select * from Execum.dbo.CatalogoEstadosMexico");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getCarrerasByInstNivel($uni, $nivel) {
		$query = utf8_decode("select  distinct NombreCarrera   from Execum.dbo.CatalogoPlantelCarreras WHERE NombreInstitucionDgei='$uni' and Nivel like '$nivel' ORDER BY NombreCarrera");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getNivelesByTutPos($uni) {
		$query = utf8_decode("select distinct Nivel from Execum.dbo.MatriculaPosgrado join Execum.dbo.CatalogoDGEI ON Execum.dbo.MatriculaPosgrado.CodigoDgei=Execum.dbo.CatalogoDGEI.CodigoDgei WHERE NombreInstitucion='$uni'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getProgramasTutoriasPos($uni, $niv) {
		$query = utf8_decode("select distinct NombreCarrera from Execum.dbo.MatriculaPosgrado join Execum.dbo.CatalogoDGEI
		ON Execum.dbo.MatriculaPosgrado.CodigoDgei=Execum.dbo.CatalogoDGEI.CodigoDgei
		WHERE NombreInstitucion='$uni' AND Nivel LIKE '$niv' ORDER BY NombreCarrera");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getNivelesByTutLic($uni) {
		$query = utf8_decode("select distinct Nivel from Execum.dbo.Matricula  join Execum.dbo.CatalogoDGEI ON  Execum.dbo.Matricula.CodigoDgei=Execum.dbo.CatalogoDGEI.CodigoDgei WHERE NombreInstitucion='$uni'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getProgramasTutoriasLic($uni, $niv) {
		$query = utf8_decode("select distinct NombreCarrera from Execum.dbo.Matricula join Execum.dbo.CatalogoDGEI
		ON Execum.dbo.Matricula.CodigoDgei=Execum.dbo.CatalogoDGEI.CodigoDgei
		WHERE NombreInstitucion='$uni' AND Nivel LIKE '$niv' ORDER BY NombreCarrera");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getNivelesByTutAmbos($uni) {
		$query = utf8_decode("with tabla as (
		select distinct Nivel, CodigoDgei  from Execum.dbo.Matricula 
		UNION ALL 
		select distinct Nivel, CodigoDgei from Execum.dbo.MatriculaPosgrado )
		SELECT distinct Nivel FROM tabla
		join Execum.dbo.CatalogoDGEI ON 
		tabla.CodigoDgei=Execum.dbo.CatalogoDGEI.CodigoDgei 
		WHERE NombreInstitucion='$uni'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getProgramasTutoriasAmbos($uni, $niv) {
		$query = utf8_decode("with tabla as (
		select distinct Nivel, CodigoDgei, NombreCarrera  from Execum.dbo.Matricula 
		UNION ALL 
		select distinct Nivel, CodigoDgei, NombreCarrera from Execum.dbo.MatriculaPosgrado )
		SELECT distinct NombreCarrera FROM tabla
		join Execum.dbo.CatalogoDGEI ON 
		tabla.CodigoDgei=Execum.dbo.CatalogoDGEI.CodigoDgei 
		WHERE NombreInstitucion='$uni'
		AND Nivel='$niv' ORDER BY NombreCarrera");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getPlantelesBachillerato() {
		$query = utf8_decode("select * from Entidades WHERE CodigoCoordinacion='BAC' AND Codigo NOT IN('45101','47201') order by Codigo");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getNivelesUNAM($uni) {
		$query = utf8_decode("with tabla as(
		select distinct NombreCarrera, ClavePlantel, Nivel from Execum.dbo.Matricula
		UNION ALL 
		select distinct NombreCarrera, ClavePlantel, Nivel from Execum.dbo.MatriculaPosgrado
		)
		SELECT distinct Nivel from tabla
		JOIN Execum.dbo.CatalogoPlanteles
		on Execum.dbo.CatalogoPlanteles.ClavePlantel=tabla.ClavePlantel
		AND NombrePlantel='$uni'
		ORDER BY Nivel");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	
	function getCarrerasUNAM($uni, $niv) {
		$query = utf8_decode("with tabla as(
		select distinct NombreCarrera, ClavePlantel, Nivel from Execum.dbo.Matricula
		UNION ALL 
		select distinct NombreCarrera, ClavePlantel, Nivel from Execum.dbo.MatriculaPosgrado
		) SELECT distinct NombreCarrera from tabla
		JOIN Execum.dbo.CatalogoPlanteles
		on Execum.dbo.CatalogoPlanteles.ClavePlantel=tabla.ClavePlantel
		AND NombrePlantel='$uni' WHERE Nivel='$niv'
		ORDER BY NombreCarrera");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function institucionesSS() {
		$query = utf8_decode("select distinct Institucion from Sostenibilidad.dbo.ServicioSocial_Programas WHERE Institucion!='' ORDER BY Institucion");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getDependenciasSS($inst) {
		$query = utf8_decode("select distinct Depedencia from Sostenibilidad.dbo.ServicioSocial_Programas WHERE Institucion='$inst' ORDER BY Depedencia");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	
	function getProgramasSS($inst, $dep) {
		$query = utf8_decode("select distinct ClavePrograma, NombrePrograma from Sostenibilidad.dbo.ServicioSocial_Programas WHERE Institucion='$inst' AND Depedencia='$dep'");
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	//revisar si el usuario esta registrado
	function getUsuarioCVU($noEmpleado)
	{
		//número de trabajador a 8 caracteres
		/*$long=strlen($noEmpleado);
		$faltan=8-$long;

		for($i=0;$i<$faltan;$i++)
			$noEmpleado='0'.$noEmpleado;*/

		$query = "select * from CVU_proto.dbo.usuarios where NumeroEmpleado='$noEmpleado'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	//insertar usuario
	function insertUsuarioCVU($noEmpleado){
		//número de trabajador a 8 caracteres
		/*$long=strlen($noEmpleado);
		$faltan=8-$long;

		for($i=0;$i<$faltan;$i++)
			$noEmpleado='0'.$noEmpleado;*/
		

		$query = "INSERT INTO CVU_proto.dbo.usuarios(NumeroEmpleado, password) VALUES ('$noEmpleado','dgei')";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}
	//Validar usuario
	function validarUsuario($nt) {
		$query = "SELECT Identificador FROM Personas where NumeroEmpleado='$nt'";
		$consulta = Query::selectLibre($query);	
		return $consulta;
	}


?>