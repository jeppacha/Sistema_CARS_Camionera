<?php

	class Conexion{

		static public function conectar(){

			$link = new PDO("mysql:host=localhost;dbname=cars","jorge","Jepers121346");

			$link->exec("set names utf-8");

			return $link;

		}

	} 

	/*=============================================
	SUBE ARCHIVO DE REPARTOS DE MENDOZA A BASE DE DATOS
	=============================================*/
	
	$directorio_base = "/var/www/html/cars/vistas/archivos/suberepar/M" ;

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

      			$directorio = "/var/www/html/cars/vistas/archivos/repartos/".$subnamerep;

      			$archirep = $directorio."/".$repname;

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

      			$archRepDestino = "/var/www/html/cars/vistas/archivos/repartos/".$subnamerep."/".$repname;

      			chmod($archRepDestino,0777);

      			if(file_exists($archRepDestino)){

      				//$conectar = mysqli_connect("localhost","root","","cars");

      				$zip = new ZipArchive;
 
					$res = $zip->open($archRepDestino);

					if ($res === TRUE) {

						$zip->extractTo($directorio);
									  	
					  	$zip->close();

					  	chmod("/var/www/html/cars/vistas/archivos/repartos/".$subnamerep."/h".$name.".asc",0777);

					  	// $archrep = $name.".asc";

					  	// $archead = $nomrepart.".asc";

					  	$cabezarep = fopen("/var/www/html/cars/vistas/archivos/repartos/".$subnamerep."/h".$name.".asc", "r");

					  	while ($datahrep = fgetcsv($cabezarep, 1000, ",")){
					    	
					    	if(isset($datahrep[0])){

					    		$itemh1 = "codoff";
					    		$itemh2 = "repnum";
					    		$valorh1 = $datahrep[1];
					    		$valorh2 = $datahrep[3];

					    		$exishrep = Conexion::conectar()->prepare("SELECT * FROM hrepartos WHERE $itemh1 = $valorh1 AND $itemh2 = $valorh2");
					    		
					    		$exishrep -> execute();
					    		
					    		if($exishrep != ""){

									$itemhrep1 = "codoff";
									$itemhrep2 = "repnum";
									$datoreph1 = $datahrep[1];
									$datoreph2 = $datahrep[3];

							  		$borrareph = Conexion::conectar()->prepare("DELETE FROM hrepartos WHERE $itemhrep1 = $datoreph1 AND $itemhrep2 = $datoreph2");
							  		
							  		$borrareph -> execute();

							  		$respuestah = Conexion::conectar()->prepare("INSERT INTO hrepartos (codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES ($datahrep[1], $datahrep[2], $datahrep[3], $datahrep[4], $datahrep[5], $datahrep[6])");

							  		$respuestah -> execute();

					    		}else{

					    			$respuestah = Conexion::conectar()->prepare("INSERT INTO hrepartos (codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES ($datahrep[1], $datahrep[2], $datahrep[3], $datahrep[4], $datahrep[5], $datahrep[6])");

					    			$respuestah -> execute();

					    		}

					    	}

					    }

					    $rep = fopen("/var/www/html/cars/vistas/archivos/repartos/".$subnamerep."/".$name.".asc", "r"); 

					    $subio = 0;

				    	while ($datarep = fgetcsv($rep, 1000, ",")){
				    		
				    		if(isset($datarep[0])){

				    			$item1 = "codoff";
					    		$item2 = "repnro";
					    		$item3 = "nguia";
					    		$valor1 = $datarep[1];
					    		$valor2 = $datarep[3];
					    		$valor3 = $datarep[5];

					    		$exisrep = Conexion::conectar()->prepare("SELECT * FROM repartos WHERE $item1 = $valor1 AND $item2 = $valor2 AND $item3 = $valor3");

					    		$exisrep -> execute();

					    		if($exisrep != ""){

									$itemrep1 = "codoff";
									$itemrep2 = "repnro";
									$itemrep3 = "nguia";
									$datorep1 = $datarep[1];
									$datorep2 = $datarep[3];
									$datorep3 = $datarep[5];

							  		$borrarep = Conexion::conectar()->prepare("DELETE FROM repartos WHERE $itemrep1 = $datorep1 AND $itemrep2 = $datorep2 AND $itemrep3 = $datorep3");

							  		$borrarep -> execute();
							  		
							  		$respuesta = Conexion::conectar()->prepare("INSERT INTO repartos (codoff, cuitfle, repnro, repfec, nguia, codcli) VALUES ($datarep[1], $datarep[2], $datarep[3], $datarep[4], $datarep[5], $datarep[6])");

							  		$respuesta -> execute();
							  		
							  		if($respuesta == "ok"){

							    		$subio++;

							    	}

					    		}else{
						    		
						    		$respuesta = Conexion::conectar()->prepare("INSERT INTO $tabla(codoff, cuitfle, repnro, repfec, nguia, codcli) VALUES ($datarep[1], $datarep[2], $datarep[3], $datarep[4], $datarep[5], $datarep[6])");

						    		$respuesta -> execute();

					    			if($respuesta == "ok"){

							    		$subio++;

							    	}

							    }

				    		}

						}

						if(file_exists($directorio."/clientes".$subnamerep.".asc")){
											
							$clientes = fopen("/var/www/html/cars/vistas/archivos/repartos/".$subnamerep."/clientes".$subnamerep.".asc", "r");

							while ($datacli = fgetcsv($clientes, 1000, ",")) {
									
								if(isset($datacli[0])){

									$itemclie = "codcli";
									$datoscli = $datacli[1];

									$exiscli = Conexion::conectar()->prepare("SELECT * FROM clientes WHERE $itemclie = $datoscli");

									$exiscli -> execute();

									if($exiscli != ""){

										$canticar = Conexion::conectar()->prepare("SELECT totalcars FROM clientes WHERE $itemclie = $datoscli");
										$canticar -> execute();

										$borracli = Conexion::conectar()->prepare("DELETE FROM clientes WHERE $itemclie = $datoscli");

										$borracli -> execute();

										$respuestacli = Conexion::conectar()->prepare("INSERT INTO clientes (codcli, sucadm, nombre, password, email1, email2, email3, cuit, usuario, foto) VALUES ($datacli[1], $datacli[2], $datacli[3], $datacli[4], $datacli[5], $datacli[6], $datacli[7], $datacli[8], $datacli[9], $datacli[10])");

										$respuestacli -> execute();

								    	$item1 = "totalcars";
								    	$valor1 = print_r($canticar,TRUE);
								    	$valorcli = $datacli[1];

								    	$totcarcli = Conexion::conectar()->prepare("UPDATE clientes SET $item1 = $valor1 WHERE codcli = $datacli[1]");

								    	$totcarcli -> execute();										

									}else{

										$respuestacli = Conexion::conectar()->prepare("INSERT INTO clientes (codcli, sucadm, nombre, password, email1, email2, email3, cuit, usuario, foto) VALUES ($datacli[1], $datacli[2], $datacli[3], $datacli[4], $datacli[5], $datacli[6], $datacli[7], $datacli[8], $datacli[9], $datacli[10])");

										$respuestacli -> execute();

									}

								}

							}
						
						}

						if(file_exists($directorio."/fleteros".$subnamerep.".asc")){
											
							$fleteros = fopen("/var/www/html/cars/vistas/archivos/repartos/".$subnamerep."/fleteros".$subnamerep.".asc", "r");

							while ($dataflet = fgetcsv($fleteros, 1000, ",")) {

								if(isset($dataflet[0])){

									$itemfle = "cuitfle";
									$datosfle = $dataflet[1];

									$exisfle = Conexion::conectar()->prepare("SELECT * FROM fleteros WHERE $itemfle = $datosfle");

									$exisfle -> execute();
												
									if($exisfle != ""){

									 	$borrafle = Conexion::conectar()->prepare("DELETE FROM fleteros WHERE $itemfle = $datosfle");

									 	$borrafle -> execute();

										$respuestafle = Conexion::conectar()->prepare("INSERT INTO fleteros (cuitfle, nombre, usuario, sucadm, password, estado, perfil, foto) VALUES ($dataflet[1], $dataflet[2], $dataflet[3], $dataflet[4], $dataflet[5], $dataflet[6], $dataflet[7], $dataflet[8])");

										$respuestafle -> execute();

									}else{

									 	$respuestafle = Conexion::conectar()->prepare("INSERT INTO fleteros (cuitfle, nombre, usuario, sucadm, password, estado, perfil, foto) VALUES ($dataflet[1], $dataflet[2], $dataflet[3], $dataflet[4], $dataflet[5], $dataflet[6], $dataflet[7], $dataflet[8])");

									 	$respuestafle -> execute();

									}

								}	
												
							}

						}

						if(file_exists($directorio."/subecars".$subnamerep.".asc")){

							$car = fopen("/var/www/html/cars/vistas/archivos/repartos/".$subnamerep."/subecars".$subnamerep.".asc", "r");

							$tabla = "tb_cars";
					    	
					    	$subiocar = 0;
					    	
					    	while ($datacar = fgetcsv($car, 1000, ",")){
					    		//var_dump($datacar);
					    		if(isset($datacar[0])){

					    			$item1 = "codcli";
					    			$item2 = "nguia";
					    			$item3 = "reparto";
					    			$valor1 = $datacar[1];
					    			$valor2 = $datacar[4];
					    			$valor3 = $datacar[11];
					    			
					    			$revisa = Conexion::conectar()->prepare("SELECT * FROM tb_cars WHERE $item1 = $valor1 AND $item2 = $valor2 AND $item3 = $valor3");

					    			$revisa -> execute();
					    			//var_dump($revisa);
					    			if($revisa != ""){

					    				$borraCar = Conexion::conectar()->prepare("DELETE FROM tb_cars WHERE $item1 = $valor1 AND $item2 = $valor2 AND $item3 = $valor3");

					    				$borraCar -> execute();

					    				$respuestacar = Conexion::conectar()->prepare("INSERT INTO tb_cars (codcli, id_sucadm, nombre, nguia, org, dst, nomrem, nomdes, frecib, pdf, reparto) VALUES ($datacar[1], $datacar[2], $datacar[3], $datacar[4], $datacar[5], $datacar[6], $datacar[7], $datacar[8], $datacar[9], $datacar[10], $datacar[11])");

					    				$respuestacar -> execute();

					    			}else{
					    				
					    				$respuestacar = Conexion::conectar()->prepare("INSERT INTO tb_cars (codcli, id_sucadm, nombre, nguia, org, dst, nomrem, nomdes, frecib, pdf, reparto) VALUES ($datacar[1], $datacar[2], $datacar[3], $datacar[4], $datacar[5], $datacar[6], $datacar[7], $datacar[8], $datacar[9], $datacar[10], $datacar[11])");

					    				$respuestacar -> execute();

					    			}

					    		}

					  		}

					  	}

					}									

      			}
      	
      		}

      		
			$archexis = $name;

			$archexish = "h".$name;

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

      		unlink($directorio_base.'/'.$archivo);

  		}

	}

	closedir($dir_handle);

?>
