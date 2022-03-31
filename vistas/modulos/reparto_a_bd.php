<?php

	require_once "../../modelos/conexion.php";
 

	class Hreparto{

		static public function muestraCabezReparto($tabla, $item1, $valor1, $item2, $valor2){
			//var_dump($valor1);
			//var_dump($valor2);
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2");

			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

			$stmt -> execute();
			
			return $stmt -> fetch();
			//var_dump($stmt);
			$stmt -> close();

			$stmt = null;

		}

		/*=============================================
		SUBE ARCHIVO DE CABECERA DE REPARTO
		=============================================*/

		static public function mdlIngresaHreparto($tabla, $datos){
			//var_dump($datos);
			$stmt = Conecta::conectadb()->prepare("INSERT INTO $tabla(codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES (:codoff, :cuitfle, :repnum, :frepar, :cantg, :rendido)"); 

			//$stmt->bindParam(":id", $datos[0], PDO::PARAM_STR);
			$stmt->bindParam(":codoff", $datos[1], PDO::PARAM_STR);
			$stmt->bindParam(":cuitfle", $datos[2], PDO::PARAM_STR);
			$stmt->bindParam(":repnum", $datos[3], PDO::PARAM_STR);
			$stmt->bindParam(":frepar", $datos[4], PDO::PARAM_STR);
			$stmt->bindParam(":cantg", $datos[5], PDO::PARAM_STR);
			$stmt->bindParam(":rendido", $datos[6], PDO::PARAM_STR);
			//$stmt->bindParam(":frendir", $datos[7], PDO::PARAM_STR);
			
			//var_dump($stmt);
			if($stmt->execute()){

				return "ok";

			}else{

				return "error";

			}
			//var_dump($stmt);
			$stmt -> close();

			$stmt = null;

		}

		/*=============================================
		BORRA REGISTRO DE TABLA CABECERA REPARTOS
		=============================================*/

		static public function BorraCabezReparto($tabla, $item1, $datos1, $item2, $datos2){

			$stmt = Conecta::conectadb()->prepare("DELETE FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2");

			$stmt -> bindParam(":".$item1, $datos1, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $datos2, PDO::PARAM_STR);
			
			if($stmt->execute()){

				return "ok";

			}else{

				return "error";

			}

			$stmt -> close();

			$stmt = null;

		}

	}


	/*=============================================
	SUBE ARCHIVO DE REPARTOS DE MENDOZA A BASE DE DATOS
	=============================================*/
	
	// try{

	// 	$base = new PDO('mysql:host=localhost;dbname=cars;charset=utf8mb4', 'jorge', 'Jepers121346');

	// 	$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// 	echo 'Conexión OK';

	// }catch (Exception $e){

	// 	echo 'Error en Conexión ';
	// }finally{

	// 	$dbase = null;
	// }
	

	$base = new PDO("mysql:host=localhost;dbname=cars","root","");

	$directorio_base = "c:/xampp/htdocs/cars/vistas/archivos/suberepar/M" ;

	$dir_handle = opendir($directorio_base);

	while(($archivo = readdir($dir_handle)) !== false) {
  		
  		$ruta = $directorio_base . '/' . $archivo;
  		//echo $ruta . PHP_EOL;
  		if(is_file($ruta)) {
     	
     		$ext = pathinfo($ruta, PATHINFO_EXTENSION);
     	
     		$name = pathinfo($ruta, PATHINFO_FILENAME);
      	
      		if($ext === 'zip') {
       			//var_dump($name);
      			$subnamerep = substr($name, 3,1);
      			//extraigo la letra de la sucursal en el nombre del archivo
      			$subrepnum = substr($name, 4);
      			//extraido el numero del reparto 
      			$repname = $name.".".$ext;

      			$directorio = "c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep;

      			$archirep = $directorio."/".$repname;
      			//var_dump($archirep);
      			$existe = 0;
				$existeh = 0;

      			if(file_exists($archirep)){

					$archexis = $name;

    				$archexish = "h".$name;

    				unlink($directorio."/".$repname); //Archivo zip

    				if(file_exists($directorio."/".$archexis.".asc")){
    					unlink($directorio."/".$archexis.".asc"); //repM123456
    				}
    				if(file_exists($directorio."/".$archexish.".asc")){
    					unlink($directorio."/".$archexish.".asc"); //hrepM123456
    				}
    				if(file_exists($directorio."/subecars".$subnamerep.".asc")){
    					unlink($directorio."/subecars".$subnamerep.".asc"); //subecarsM
    				}
    				if(file_exists($directorio."/fleteros".$subnamerep.".asc")){
    					unlink($directorio."/fleteros".$subnamerep.".asc"); //fleterosM
					}
    				if(file_exists($directorio."clientes".$subnamerep.".asc")){
    					unlink($directorio."/clientes".$subnamerep.".asc"); //clientesM
    				}
    				$existe = 1;
    				$existeh = 1;

      			}

      			copy($directorio_base.'/'.$archivo, $directorio.'/'.$archivo);

      			$archRepDestino = "c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/".$repname;

      			chmod($archRepDestino,0777);

      			if(file_exists($archRepDestino)){

      				//$conectar = mysqli_connect("localhost","root","","cars");

      				$zip = new ZipArchive;
 
					$res = $zip->open($archRepDestino);

					if ($res === TRUE) {

						$zip->extractTo($directorio);
									  	
					  	$zip->close();

					  	chmod("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/h".$name.".asc",0777);

					  	// $archrep = $name.".asc";

					  	// $archead = $nomrepart.".asc";

					  	$cabezarep = fopen("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/h".$name.".asc", "r");

					  	while ($datahrep = fgetcsv($cabezarep, 1000, ",")){
					    	//var_dump($datahrep);
					    	if(isset($datahrep[0])){

					    		//var_dump($datahrep);

					    		$tablah = "hreparto";
					    		$itemh1 = "codoff";
					    		$itemh2 = "repnum";
					    		$valorh1 = $datahrep[1];
					    		$valorh2 = $datahrep[3];

					    		$exishrep = Hreparto::muestraCabezReparto($tablah, $itemh1, $valorh1, $itemh2, $valorh2); 

					    		print_r($exishrep);
					    		//var_dump($exishrep);
					    		// $exishrep = $base->prepare("SELECT * FROM $tablah WHERE codoff = ? AND repnum = ?");
					    		// $exishrep -> execute(array($valorh1, $valorh2));
					    		if($exishrep != ""){

					    			$itemhrep1 = "codoff";
									$itemhrep2 = "repnum";
									$datoreph1 = $datahrep[1];
									$datoreph2 = $datahrep[3];

					    			$borrareph = Hreparto::BorraCabezReparto($tablah,$itemhrep1,$datoreph1,$itemhrep2,$datoreph2);

					    			//var_dump($borrareph);
						    		if($borrareph == "Ok"){

						    			echo "Exito";
						    		}

					    			// $borrareph = $base->prepare("DELETE FROM $tablah WHERE codoff = ? AND repnum = ? ");
					    			// $borrareph -> execute(array($valorh1, $valorh2));
					    		}
					    		
					    		// }else{

					    		// 	echo "Error";
					    		// }
					    		// $sql = "SELECT * FROM $tablah WHERE $itemh1 = $valorh1 AND $itemh2 = $valorh2";

					    		// $exishrep=$conectado->query($sql);

					    		
					    		//$exishrep = Hreparto::mdlMuestraRegistroH($tablah, $itemh1, $valorh1, $itemh2, $valorh2);
					    		
					    		//Conexion::conectar()->prepare("SELECT * FROM hrepartos WHERE $itemh1 = $valorh1 AND $itemh2 = $valorh2");
					    		
					    		//$exishrep -> execute();
					    		
					    // 		if($exishrep != ""){
					    // 			//var_dump($exishrep);
									// $itemhrep1 = "codoff";
									// $itemhrep2 = "repnum";
									// $datoreph1 = $datahrep[1];
									// $datoreph2 = $datahrep[3];

									// $borrareph = Hreparto::mdlEliminaHreparto($tablah,$itemhrep1,$datoreph1,$itemhrep2,$datoreph2);
									// var_dump($borrareph);
							  // 		//$borrareph = Conexion::conectar()->prepare("DELETE FROM hrepartos WHERE $itemhrep1 = $datoreph1 AND $itemhrep2 = $datoreph2");
							  		
							  // 		//$borrareph -> execute();

							  // 		$respuestah = Hreparto::mdlIngresaHreparto($tablah,$datahrep);

							  // 		//$respuestah = Conexion::conectar()->prepare("INSERT INTO hrepartos (codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES ($datahrep[1], $datahrep[2], $datahrep[3], $datahrep[4], $datahrep[5], $datahrep[6])");

							  // 		//$respuestah -> execute();

					    // 		}else{

					    // 			$sqlin = "INSERT INTO `hrepartos`(`codoff`, `cuitfle`, `repnum`, `frepar`, `cantg`, `rendido`) VALUES ($datahrep[1],$datahrep[2],$datahrep[3],$datahrep[4],$datahrep[5],$datahrep[6])";

					    // 			$respuestah=$conectado->query($sqlin);


					    // 			//$respuestah = Hreparto::mdlIngresaHreparto($tablah,$datahrep);
					    // 			//var_dump($respuestah);
					    // 			//$respuestah = Conexion::conectar()->prepare("INSERT INTO hrepartos (codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES ($datahrep[1], $datahrep[2], $datahrep[3], $datahrep[4], $datahrep[5], $datahrep[6])");

					    // 			//$respuestah -> execute();

					    // 		}

					    	}

					    }

					}									

      			}
      	
      		}
	
		}

	}

	closedir($dir_handle);

?>
