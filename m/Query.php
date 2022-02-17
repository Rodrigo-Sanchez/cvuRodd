<?php
class Query {
	
	private static $connection;			
	private static $isInitialized = false;
	private function __construct(){}
	private static function connect(){		
		if(self::$isInitialized){return self::$connection;}
		try{			
			self::$connection = new \PDO(
        		sprintf(
            		"dblib:host=%s;dbname=%s",
            		"132.247.28.97",
            		"UNAM_Fundanet_DWM"
        		),
        		"admuser",
        		"1234ab$5"
    		);
    		self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if(self::$connection === false ){
				print "<p>No es posible conectarse al servidor.</p>";
			}else{
				self::$connection->query('SET TEXTSIZE 2147483647');
				ini_set ( 'mssql.textlimit' , '2147483647' );
				ini_set ( 'mssql.textsize' , '2147483647' );
			}		
		}catch(PDOException $e){
			if(DEBUG_MODE){
				print "<span class='span_error'>No se pudo conectar: ".$e->getMessage()."<br/>".$e->getCode()."</span>";
			}	
			return false;
		}
		self::$isInitialized = true;
		foreach (glob("modelos/*.php") as $filename){									//All models are included dinamycally
			if($filename!="modelos/Query.php"){
				include_once $filename;
			}
		}
	}	
	private static function runQuery($sql){
		self::connect();
        if(self::$isInitialized){
			try{
				$result = self::$connection->query($sql);							
			}catch(PDOException $e){
				//if(DEBUG_MODE){
					echo "<p><b>ERROR:</b></p>";
					echo $e->getMessage()."<br/>";
					echo "</p><textarea style='width:100%;height:500px;'>$sql</textarea>";
				//}
				return false;
			}	
        	return $result;
		}
    }
	private static function select($sql){
		$rows = array();		
		$result = self::runQuery($sql);				
		if($result === false){												// If query failed, return `false`
			return false;
		}				
		try{
			while($row = $result->fetch(PDO::FETCH_ASSOC)){						// If query was successful, retrieve all the rows into an array (it will return an array even if it's only one result.')
				$rows[] = $row;
			}
		}catch(PDOException $pdoe){
			print "No se encontraron resultados, refina tus criterios de búsqueda";
			print "<script>console.log(".$e->getMessage().")</script>";
		}
		if($rows === false){
   		 	$error = db_error();											// Handle error - inform administrator, log to file, show error page, etc.
			return false;
		}
		return $rows;
	}

	
	public static function selectLibre($query){
		$q = strip_tags($query);
		$rows = self::select($q);		
		return $rows;
	}

		
}
?>