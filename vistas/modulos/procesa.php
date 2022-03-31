<?php 

	//define('DB_SERVER', "localhost");
   	//define('DB_USERNAME', "root");
   	//define('DB_PASSWORD', '');
   	//define('DB_DATABASE', 'cars');
   	//$con=mysqli_connect('localhost','jorge','Jepers121346','cars');

   	$servername = "localhost";
	$username = "jorge";
	$password = "Jepers121346";

   	try {
	  $con = new PDO("mysql:host=$servername;dbname=cars", $username, $password);
	  // set the PDO error mode to exception
	  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  echo "Connected successfully";
	} catch(PDOException $e) {
	  echo "Connection failed: " . $e->getMessage();
	}

	$directorio_base = "/var/www/html/cars/vistas/archivos/suberepar/M" ;

	$dir_handle = opendir($directorio_base);

	$files = array();

	while($archivo = readdir($dir_handle)) {

		if($archivo != "." && $archivo != ".."){

			if(!is_dir($dir_handle.$archivo)) {
                
                $files[] = $archivo;

            }

		}
  		
  	}

  	for($i=0; $i<count( $files ); $i++){
    
        //echo '<li>'.$files[$i]."</li>";
    
		$subnamerep = substr($files[$i], 3,1);
		//echo "<br />".$subnamerep;
		//extraigo la letra de la sucursal en el nombre del archivo
		$subrepnum = substr($files[$i], 4,-4);
		//echo "<br />".$subrepnum;
		// extraigo el numero del reparto
		$name = substr($files[$i], 0,-4);
		//echo "<br />".$name;
		// extraigo el nombre del archivo sin extensión
		$ext = substr($files[$i], -3);
		//echo "<br />".$ext;
		// extraigo la extensión del archivo
		
		$repname = $files[$i];
		//echo "<br />".$repname;
		// nombre completo del archivo

		$directorio = "/var/www/html/cars/vistas/archivos/repartos/".$subnamerep;
		//echo "<br />".$directorio;
		$archirep = $directorio."/".$repname; 
		//echo "<br />".$archirep;

		if($ext === 'zip') {

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

  			copy($directorio_base.'/'.$files[$i], $directorio.'/'.$files[$i]);

  			$archRepDestino = $directorio."/".$repname;

  			//echo "<br />".$archRepDestino;

     		chmod($archRepDestino,0777);

     		if(file_exists($archRepDestino)){

     			$zip = new ZipArchive;

				if ($zip->open($archRepDestino) === TRUE) {

					chmod($directorio,0777);
					//echo "<br />".$directorio;

					$zip->extractTo($directorio);
									  	
				  	$zip->close();

//Archivo HREPARTO
				  	chmod($directorio."/h".$name.".asc",0777);

				  	// $archrep = $name.".asc";

				  	// $archead = $nomrepart.".asc";

				  	$cabezarep = fopen($directorio."/h".$name.".asc", "r");

				  	while ($datahrep = fgetcsv($cabezarep, 1000, ",")){
				    	//var_dump($datahrep);
				    	if(isset($datahrep[0])){

				    		//var_dump($datahrep);

				    		$sqlhrep = $con->prepare("SELECT * FROM hrepartos WHERE codoff = '$datahrep[1]' AND repnum = '$datahrep[3]'");
				    		
				    		$sqlhrep ->execute();

				    		if($sqlhrep -> fetch() != ""){
				    		
				    			$stmt = $con->prepare("DELETE FROM hrepartos WHERE codoff = '$datahrep[1]' AND repnum = '$datahrep[3]'");

				    			if($stmt->execute()){

									//echo "<br />".'Registro HREPARTOS Borrado';

							    }else{

									//echo "<br />".'Registro HREPARTOS NO Borrado';
							    }
								
								$stmt = $con->prepare("INSERT INTO hrepartos (codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES (:codoff,:cuitfle,:repnum,:frepar,:cantg,:rendido)");
								
								$stmt->bindParam(':codoff',$datahrep[1], PDO::PARAM_INT);
								$stmt->bindParam(':cuitfle',$datahrep[2], PDO::PARAM_STR);
								$stmt->bindParam(':repnum',$datahrep[3], PDO::PARAM_STR);
								$stmt->bindParam(':frepar',$datahrep[4], PDO::PARAM_STR);
								$stmt->bindParam(':cantg',$datahrep[5], PDO::PARAM_STR);
								$stmt->bindParam(':rendido',$datahrep[6], PDO::PARAM_STR);

								if($stmt->execute()){

				    				//echo "<br />".'Registro HREPARTOS AGREGADO CON EXITO Despues de Borrar';
									
							    }else{
									//echo "<br />".'Registro HREPARTOS NO AGREGADO Despues de borrar';
							    }
								

				    		}else{

				    			//echo 'LLEGUE HASTA ACA';

				    			$stmt = $con->prepare("INSERT INTO hrepartos (codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES (:codoff,:cuitfle,:repnum,:frepar,:cantg,:rendido)");
								
								$stmt->bindParam(':codoff',$datahrep[1], PDO::PARAM_INT);
								$stmt->bindParam(':cuitfle',$datahrep[2], PDO::PARAM_STR);
								$stmt->bindParam(':repnum',$datahrep[3], PDO::PARAM_STR);
								$stmt->bindParam(':frepar',$datahrep[4], PDO::PARAM_STR);
								$stmt->bindParam(':cantg',$datahrep[5], PDO::PARAM_STR);
								$stmt->bindParam(':rendido',$datahrep[6], PDO::PARAM_STR);

								if($stmt->execute()){

				    				//echo "<br />".'Registro HREPARTOS AGREGADO CON EXITO';
									
							    }else{
									//echo "<br />".'Registro HREPARTOS NO AGREGADO';
							    }
																
				    		}

				    	}

				    }

				    unlink($directorio."/h".$name.".asc");				

//Archivo DETALLE REPARTO
				  	
				  	chmod($directorio."/".$name.".asc",0777);

				  	// $archrep = $name.".asc";

				  	// $archead = $nomrepart.".asc";

				  	$detallerep = fopen($directorio."/".$name.".asc", "r");

				  	while ($datadrep = fgetcsv($detallerep, 1000, ",")){
				    	//var_dump($datahrep);
				    	if(isset($datadrep[0])){

				    		//var_dump($datahrep);

				    		$sqldrep = $con->prepare("SELECT * FROM repartos WHERE codoff = '$datadrep[1]' AND repnro = '$datadrep[3]' AND nguia = '$datadrep[5]'");
				    		
				    		$sqldrep ->execute();

				    		if($sqldrep -> fetch() != ""){
				    		
				    			$stmt = $con->prepare("DELETE FROM repartos WHERE codoff = '$datadrep[1]' AND repnro = '$datadrep[3]' AND nguia = '$datadrep[5]'");

				    			if($stmt->execute()){

									//echo "<br />".'Registro DETALLE REPARTOS Borrado';

							    }else{

									//echo "<br />".'Registro DETALLE REPARTOS NO Borrado';
							    }
								
								$stmt = $con->prepare("INSERT INTO repartos (codoff, cuitfle, repnro, repfec, nguia, codcli) VALUES (:codoff,:cuitfle,:repnro,:repfec,:nguia,:codcli)");
								
								$stmt->bindParam(':codoff',$datadrep[1], PDO::PARAM_INT);
								$stmt->bindParam(':cuitfle',$datadrep[2], PDO::PARAM_STR);
								$stmt->bindParam(':repnro',$datadrep[3], PDO::PARAM_STR);
								$stmt->bindParam(':repfec',$datadrep[4], PDO::PARAM_STR);
								$stmt->bindParam(':nguia',$datadrep[5], PDO::PARAM_STR);
								$stmt->bindParam(':codcli',$datadrep[6], PDO::PARAM_STR);

								if($stmt->execute()){

				    				//echo "<br />".'Registro DETALLE REPARTOS AGREGADO CON EXITO Despues de Borrar';
									
							    }else{
									//echo "<br />".'Registro DETALLE REPARTOS NO AGREGADO Despues de borrar';
							    }
								

				    		}else{

				    			$stmt = $con->prepare("INSERT INTO repartos (codoff, cuitfle, repnro, repfec, nguia, codcli) VALUES (:codoff,:cuitfle,:repnro,:repfec,:nguia,:codcli)");
								
								$stmt->bindParam(':codoff',$datadrep[1], PDO::PARAM_INT);
								$stmt->bindParam(':cuitfle',$datadrep[2], PDO::PARAM_STR);
								$stmt->bindParam(':repnro',$datadrep[3], PDO::PARAM_STR);
								$stmt->bindParam(':repfec',$datadrep[4], PDO::PARAM_STR);
								$stmt->bindParam(':nguia',$datadrep[5], PDO::PARAM_STR);
								$stmt->bindParam(':codcli',$datadrep[6], PDO::PARAM_STR);

								if($stmt->execute()){

				    				//echo "<br />".'Registro DETALLE REPARTOS AGREGADO CON EXITO';
									
							    }else{
									//echo "<br />".'Registro DETALLE REPARTOS NO AGREGADO';
							    }
																
				    		}

				    	}

				    }

				    unlink($directorio."/".$name.".asc");

//Archivo FLETEROS

				    if(file_exists($directorio."/fleteros".$subnamerep.".asc")){
				  	
					  	chmod($directorio."/fleteros".$subnamerep.".asc",0777);

					  	$fletero = fopen($directorio."/fleteros".$subnamerep.".asc", "r");

					  	while ($dataflet = fgetcsv($fletero, 1000, ",")){
					    	//var_dump($datahrep);
					    	if(isset($dataflet[0])){

					    		//var_dump($datahrep);

					    		$sqlflet = $con->prepare("SELECT * FROM fleteros WHERE cuitfle = '$dataflet[1]'");
					    		
					    		$sqlflet ->execute();
					    		
					    		if($sqlflet -> fetch() != ""){
					    		
					    			$stmt = $con->prepare("DELETE FROM fleteros WHERE cuitfle = '$dataflet[1]' ");

					    			if($stmt->execute()){

										//echo "<br />".'Registro DETALLE REPARTOS Borrado';

								    }else{

										//echo "<br />".'Registro DETALLE REPARTOS NO Borrado';
								    }
									
									$stmt = $con->prepare("INSERT INTO fleteros (cuitfle, nombre, usuario, sucadm, password, estado, perfil,foto,fecha_alta,ultimo_login) VALUES (:cuitfle,:nombre,:usuario,:sucadm,:password,:estado,:perfil,:foto,:fecha_alta,:ultimo_login)");
									
									$stmt->bindParam(':cuitfle',$dataflet[1], PDO::PARAM_STR);
									$stmt->bindParam(':nombre',$dataflet[2], PDO::PARAM_STR);
									$stmt->bindParam(':usuario',$dataflet[3], PDO::PARAM_STR);
									$stmt->bindParam(':sucadm',$dataflet[4], PDO::PARAM_STR);
									$stmt->bindParam(':password',$sqlflet[5], PDO::PARAM_STR);
									$stmt->bindParam(':estado',$dataflet[6], PDO::PARAM_STR);
									$stmt->bindParam(':perfil',$dataflet[7], PDO::PARAM_STR);
									$stmt->bindParam(':foto',$sqlflet[8], PDO::PARAM_STR);
									$stmt->bindParam(':fecha_alta',$sqlflet[9], PDO::PARAM_STR);
									$stmt->bindParam(':ultimo_login',$sqlflet[10], PDO::PARAM_STR);
									
									if($stmt->execute()){

					    				echo "<br />".'Registro DETALLE REPARTOS AGREGADO CON EXITO Despues de Borrar';
										
								    }else{
										echo "<br />".'Registro DETALLE REPARTOS NO AGREGADO Despues de borrar';
								    }
									

					    		}else{

					    			if($dataflet[1] != null){

					    				if($dataflet[5] != null){

					    					$encriptar = crypt($dataflet[5], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					    				}else{

					    					$encriptar = $dataflet[5];
					    				}

						    			$stmt = $con->prepare("INSERT INTO fleteros (cuitfle, nombre, usuario, sucadm, password, estado, perfil) VALUES (:cuitfle,:nombre,:usuario,:sucadm,:password,:estado,:perfil)");
										
										$stmt->bindParam(':cuitfle',$dataflet[1], PDO::PARAM_STR);
										$stmt->bindParam(':nombre',$dataflet[2], PDO::PARAM_STR);
										$stmt->bindParam(':usuario',$dataflet[3], PDO::PARAM_STR);
										$stmt->bindParam(':sucadm',$dataflet[4], PDO::PARAM_STR);
										$stmt->bindParam(':password',$encriptar, PDO::PARAM_STR);
										$stmt->bindParam(':estado',$dataflet[6], PDO::PARAM_STR);
										$stmt->bindParam(':perfil',$dataflet[7], PDO::PARAM_STR);

										if($stmt->execute()){

						    				//echo "<br />".'Registro Fletero AGREGADO CON EXITO';
											
									    }else{
											//echo "<br />".'Registro Fletero NO AGREGADO';
									    }

									}
																	
					    		}

					    	}

					    }

					    unlink($directorio."/fleteros".$subnamerep.".asc");

					}

//Archivo CLIENTES

				    if(file_exists($directorio."/clientes".$subnamerep.".asc")){
				  	
					  	chmod($directorio."/clientes".$subnamerep.".asc",0777);

					  	$cliente = fopen($directorio."/clientes".$subnamerep.".asc", "r");

					  	while ($datacli = fgetcsv($cliente, 1000, ",")){
					    	//var_dump($datahrep);
					    	if(isset($datacli[0])){

					    		//var_dump($datahrep);

					    		$sqlcli = $con->prepare("SELECT * FROM clientes WHERE codcli = '$datacli[1]'");
					    		
					    		$sqlcli ->execute();

					    		if($sqlcli -> fetch() != ""){
					    		
					    			$stmt = $con->prepare("DELETE FROM clientes WHERE codcli = '$datacli[1]'");

					    			if($stmt->execute()){

										echo "<br />".'Registro Cliente Borrado';

								    }else{

										echo "<br />".'Registro Cliente NO Borrado';
								    }
									
									$stmt = $con->prepare("INSERT INTO clientes (codcli, sucadm, nombre, password, email1, email2, email3, cuit, usuario) VALUES (:codcli,:sucadm,:nombre,:password,:email1,:email2,:email3,:cuit,:usuario)");
									
									$stmt->bindParam(':codcli',$datacli[1], PDO::PARAM_INT);
									$stmt->bindParam(':sucadm',$datacli[2], PDO::PARAM_STR);
									$stmt->bindParam(':nombre',$datacli[3], PDO::PARAM_STR);
									$stmt->bindParam(':password',$sqlcli[4], PDO::PARAM_STR);
									$stmt->bindParam(':email1',$datacli[5], PDO::PARAM_STR);
									$stmt->bindParam(':email2',$datacli[6], PDO::PARAM_STR);
									$stmt->bindParam(':email3',$datacli[7], PDO::PARAM_STR);
									$stmt->bindParam(':cuit',$datacli[8], PDO::PARAM_STR);
									$stmt->bindParam(':usuario',$datacli[9], PDO::PARAM_STR);

									if($stmt->execute()){

					    				echo "<br />".'Registro CLIENTES AGREGADO CON EXITO Despues de Borrar';
										
								    }else{
										echo "<br />".'Registro CLIENTES NO AGREGADO Despues de borrar';
								    }
									
					    		}else{

					    			if($datacli[1] != null){

					    				if($datacli[4] != null){

					    					$encriptar = crypt($datacli[4], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					    				}else{

					    					$encriptar = $datacli[4];

					    				}

						    			$stmt = $con->prepare("INSERT INTO clientes (codcli, sucadm, nombre, password, email1, email2, email3, cuit, usuario) VALUES (:codcli,:sucadm,:nombre,:password,:email1,:email2,:email3,:cuit,:usuario)");
										
										$stmt->bindParam(':codcli',$datacli[1], PDO::PARAM_STR);
										$stmt->bindParam(':sucadm',$datacli[2], PDO::PARAM_STR);
										$stmt->bindParam(':nombre',$datacli[3], PDO::PARAM_STR);
										$stmt->bindParam(':password',$encriptar, PDO::PARAM_STR);
										$stmt->bindParam(':email1',$datacli[5], PDO::PARAM_STR);
										$stmt->bindParam(':email2',$datacli[6], PDO::PARAM_STR);
										$stmt->bindParam(':email3',$datacli[7], PDO::PARAM_STR);
										$stmt->bindParam(':cuit',$datacli[8], PDO::PARAM_STR);
										$stmt->bindParam(':usuario',$datacli[9], PDO::PARAM_STR);

										if($stmt->execute()){

						    				echo "<br />".'Registro Cliente AGREGADO CON EXITO';
											
									    }else{
											echo "<br />".'Registro Cliente NO AGREGADO';
									    }

									}
																	
					    		}

					    	}

					    }

					    unlink($directorio."/clientes".$subnamerep.".asc");

					}

//Archivo CARS

				    if(file_exists($directorio."/subecars".$subnamerep.".asc")){
				  	
					  	chmod($directorio."/subecars".$subnamerep.".asc",0777);

					  	$cars = fopen($directorio."/subecars".$subnamerep.".asc", "r");

					  	while ($datacar = fgetcsv($cars, 1000, ",")){
					    	//var_dump($datahrep);
					    	if(isset($datacar[0])){

					    		//var_dump($datahrep);

					    		$sqlcar = $con->prepare("SELECT * FROM tb_cars WHERE codcli = '$datacar[1]' AND nguia = '$datacar[4]' AND reparto = '$datacar[11]'");
					    		
					    		$sqlcar ->execute();

					    		if($sqlcar -> fetch() != ""){

					    			if($sqlcar[13] == null){
					    		
						    			$stmt = $con->prepare("DELETE FROM tb_cars WHERE codcli = '$datacar[1]' AND nguia = '$datacar[4]' AND reparto = '$datacar[11]'");

						    			if($stmt->execute()){

											echo "<br />".'Registro CARS Borrado';

									    }else{

											echo "<br />".'Registro CARS NO Borrado';
									    }
										
										$stmt = $con->prepare("INSERT INTO tb_cars (codcli, id_sucadm, nombre, nguia, org, dst, nomrem, nomdes, frecib, pdf, reparto) VALUES (:codcli,:id_sucadm,:nombre,:nguia,:org,:dst,:nomrem,:nomdes,:frecib,:pdf,:reparto)");
										
										$stmt->bindParam(':codcli',$datacar[1], PDO::PARAM_INT);
										$stmt->bindParam(':id_sucadm',$datacar[2], PDO::PARAM_STR);
										$stmt->bindParam(':nombre',$datacar[3], PDO::PARAM_STR);
										$stmt->bindParam(':nguia',$datacar[4], PDO::PARAM_STR);
										$stmt->bindParam(':org',$datacar[5], PDO::PARAM_STR);
										$stmt->bindParam(':dst',$datacar[6], PDO::PARAM_STR);
										$stmt->bindParam(':nomrem',$datacar[7], PDO::PARAM_STR);
										$stmt->bindParam(':nomdes',$datacar[8], PDO::PARAM_STR);
										$stmt->bindParam(':frecib',$datacar[9], PDO::PARAM_STR);
										$stmt->bindParam(':pdf',$datacar[10], PDO::PARAM_STR);
										$stmt->bindParam(':reparto',$datacar[11], PDO::PARAM_STR);

										if($stmt->execute()){

						    				echo "<br />".'Registro CARS AGREGADO CON EXITO Despues de Borrar';
											
									    }else{
											
											echo "<br />".'Registro CARS NO AGREGADO Despues de borrar';
									    
									    }

									}else{

										if($sqlcar[13] === 0){

											if($sqlcar[11] != $datacar[11]){

												$stmt = $con->prepare("DELETE FROM tb_cars WHERE codcli = '$datacar[1]' AND nguia = '$datacar[4]' AND reparto = '$datacar[11]'");

								    			if($stmt->execute()){

													echo "<br />".'Registro CARS Borrado';

											    }else{

													echo "<br />".'Registro CARS NO Borrado';
											    }
												
												$stmt = $con->prepare("INSERT INTO tb_cars (codcli, id_sucadm, nombre, nguia, org, dst, nomrem, nomdes, frecib, pdf, reparto) VALUES (:codcli,:id_sucadm,:nombre,:nguia,:org,:dst,:nomrem,:nomdes,:frecib,:pdf,:reparto)");
												
												$stmt->bindParam(':codcli',$datacar[1], PDO::PARAM_INT);
												$stmt->bindParam(':id_sucadm',$datacar[2], PDO::PARAM_STR);
												$stmt->bindParam(':nombre',$datacar[3], PDO::PARAM_STR);
												$stmt->bindParam(':nguia',$datacar[4], PDO::PARAM_STR);
												$stmt->bindParam(':org',$datacar[5], PDO::PARAM_STR);
												$stmt->bindParam(':dst',$datacar[6], PDO::PARAM_STR);
												$stmt->bindParam(':nomrem',$datacar[7], PDO::PARAM_STR);
												$stmt->bindParam(':nomdes',$datacar[8], PDO::PARAM_STR);
												$stmt->bindParam(':frecib',$datacar[9], PDO::PARAM_STR);
												$stmt->bindParam(':pdf',$datacar[10], PDO::PARAM_STR);
												$stmt->bindParam(':reparto',$datacar[11], PDO::PARAM_STR);

												if($stmt->execute()){

								    				echo "<br />".'Registro CARS AGREGADO CON EXITO Despues de Borrar';
													
											    }else{
													
													echo "<br />".'Registro CARS NO AGREGADO Despues de borrar';
											    
											    }
												
											}

										}

									}
									
					    		}else{

					    			if($datacar[1] != null){

						    			$stmt = $con->prepare("INSERT INTO tb_cars (codcli, id_sucadm, nombre, nguia, org, dst, nomrem, nomdes, frecib, pdf, reparto) VALUES (:codcli,:id_sucadm,:nombre,:nguia,:org,:dst,:nomrem,:nomdes,:frecib,:pdf,:reparto)");
										
										$stmt->bindParam(':codcli',$datacar[1], PDO::PARAM_STR);
										$stmt->bindParam(':id_sucadm',$datacar[2], PDO::PARAM_STR);
										$stmt->bindParam(':nombre',$datacar[3], PDO::PARAM_STR);
										$stmt->bindParam(':nguia',$datacar[4], PDO::PARAM_STR);
										$stmt->bindParam(':org',$datacar[5], PDO::PARAM_STR);
										$stmt->bindParam(':dst',$datacar[6], PDO::PARAM_STR);
										$stmt->bindParam(':nomrem',$datacar[7], PDO::PARAM_STR);
										$stmt->bindParam(':nomdes',$datacar[8], PDO::PARAM_STR);
										$stmt->bindParam(':frecib',$datacar[9], PDO::PARAM_STR);
										$stmt->bindParam(':pdf',$datacar[10], PDO::PARAM_STR);
										$stmt->bindParam(':reparto',$datacar[11], PDO::PARAM_STR);

										if($stmt->execute()){

						    				echo "<br />".'Registro CARS AGREGADO CON EXITO';
											
									    }else{
											echo "<br />".'Registro CARS NO AGREGADO';
									    }

									}
																	
					    		}

					    	}

					    }

					    unlink($directorio."/subecars".$subnamerep.".asc");

					}										

				}				

			}

		}

	}

?>
