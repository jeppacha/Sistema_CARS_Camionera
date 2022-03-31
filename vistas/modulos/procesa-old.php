<?php 

	define('DB_SERVER', "localhost");
   	define('DB_USERNAME', "root");
   	define('DB_PASSWORD', '');
   	define('DB_DATABASE', 'cars');
   	$con=mysqli_connect('localhost','jorge','Jepers121346','cars');

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
					echo "<br />".$directorio;

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

				    		$sqlhrep = "SELECT * FROM hrepartos WHERE codoff = '$datahrep[1]' AND repnum = '$datahrep[3]'";
				    		$result = mysqli_query($con, $sqlhrep);

				    		$crow = mysqli_fetch_assoc($result);
				    		
				    		if($crow  != ""){

				    			//echo "<br />".'Hay registro cabecera';

				    			$stmt = $con->prepare("DELETE FROM hrepartos WHERE codoff = '$datahrep[1]' AND repnum = '$datahrep[3]'");

				    			$stmt->execute();

				    			if ($stmt->error)
								{
									//echo "<br />".'Registro HREPARTOS NO Borrado';
							    }
							    else
							    {
									//echo "<br />".'Registro HREPARTOS Borrado';
							    }
								
								$stmt->close();

								$stmt = null;

								$stmt = $con->prepare("INSERT INTO hrepartos (codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES (?,?,?,?,?,?)");

								$stmt->bind_param('isidii',$datahrep[1],$datahrep[2],$datahrep[3],$datahrep[4],$datahrep[5],$datahrep[6]);

								$stmt->execute();

				    			if ($stmt->error)
								{
									//echo "<br />".'Registro HREPARTOS NO AGREGADO';
							    }
							    else
							    {
									//echo "<br />".'Registro HREPARTOS AGREGADO CON EXITO despues de borrar';
							    }
								
								$stmt->close();

								$stmt = null;

				    		}else{

				    			$stmt = $con->prepare("INSERT INTO hrepartos (codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES (?,?,?,?,?,?)");
								
								$stmt->bind_param('isidii',$datahrep[1],$datahrep[2],$datahrep[3],$datahrep[4],$datahrep[5],$datahrep[6]);

								$stmt->execute();

				    			if ($stmt->error)
								{
									////////echo "<br />".'Registro HREPARTOS NO AGREGADO';
							    }
							    else
							    {
									//echo "<br />".'Registro HREPARTOS AGREGADO CON EXITO';
							    }
								
								$stmt->close();

								$stmt = null;

				    		}

				    	}

				    }

				    unlink($directorio."/h".$name.".asc");

//Archivo DREPARTO
				  	chmod($directorio."/".$name.".asc",0777);

				  	$dreparto = fopen($directorio."/".$name.".asc", "r");

				  	while ($datadrep = fgetcsv($dreparto, 1000, ",")){
				    	//var_dump($datahrep);
				    	if(isset($datadrep[0])){

				    		//var_dump($datahrep);

		    				$sqldrep = "SELECT * FROM repartos WHERE codoff = '$datadrep[1]' AND repnro = '$datadrep[3]' AND nguia = '$datadrep[5]'";
			    		
		    				$resultrep = mysqli_query($con, $sqldrep);

				    		$crowrep = mysqli_fetch_assoc($resultrep);
			    		
				    		if($crowrep  != ""){

				    			//echo "<br />".'Hay registro Detalle Reparto';

				    			$stmt = $con->prepare("DELETE FROM repartos WHERE codoff = '$datadrep[1]' AND repnro = '$datadrep[3]' AND nguia = '$datadrep[5]'");

				    			$stmt->execute();

				    			if ($stmt->error)
								{
									//echo "<br />".'Registro DREPARTO NO Borrado';
							    }
							    else
							    {
									//echo "<br />".'Registro DREPARTO Borrado';
							    }
							
								$stmt->close();

								$stmt = null;

								$stmt = $con->prepare("INSERT INTO repartos (codoff, cuitfle, repnro, repfec, nguia, codcli) VALUES (?,?,?,?,?,?)");

								$stmt->bind_param('isidis',$datadrep[1],$datadrep[2],$datadrep[3],$datadrep[4],$datadrep[5],$datadrep[6]);

								$stmt->execute();

				    			if ($stmt->error)
								{
									//echo "<br />".'Registro DREPARTO NO AGREGADO';
							    }
							    else
							    {
									//echo "<br />".'Registro DETALLE REPARTO AGREGADO CON EXITO';
							    }
							
								$stmt->close();

								$stmt = null;

				    		}else{

				    			$stmt = $con->prepare("INSERT INTO repartos (codoff, cuitfle, repnro, repfec, nguia, codcli) VALUES (?,?,?,?,?,?)");

								$stmt->bind_param('isidis',$datadrep[1],$datadrep[2],$datadrep[3],$datadrep[4],$datadrep[5],$datadrep[6]);

								$stmt->execute();

				    			if ($stmt->error)
								{
									//echo "<br />".'Registro DREPARTO NO AGREGADO';
							    }
							    else
							    {
									//echo "<br />".'Registro DETALLE REPARTO AGREGADO CON EXITO';
							    }
						
								$stmt->close();

								$stmt = null;

 					    	}	

				    	}

				    }

				    unlink($directorio."/".$name.".asc");

//Archivo FLETERO
				    if(file_exists($directorio."/fleteros".$subnamerep.".asc")){

				    	chmod($directorio."/fleteros".$subnamerep.".asc",0777);

				    	$fletero = fopen($directorio."/fleteros".$subnamerep.".asc", "w+");

				    	while ($dataflet = fgetcsv($fletero, 1000, ",")){

				    		if(isset($dataflet[0])){

				    			$sqlflet = "SELECT * FROM fleteros WHERE cuitfle = '$dataflet[1]'";
				    			//echo "<br />".$dataflet[1], $dataflet[2];
					    		$resultflet = mysqli_query($con, $sqlflet);

					    		$crowfle = mysqli_fetch_assoc($resultflet);
					    		
					    		if($crowfle  != ""){

					    			echo "<br />".'Hay registro FLETERO '.$dataflet[2];

					    			$stmt = $con->prepare("DELETE FROM fleteros WHERE cuitfle = '$dataflet[1]'");

					    			$stmt->execute();

					    			if ($stmt->error)
									{
										echo "<br />".'Registro Fletero NO Borrado';
								    }
								    else
								    {
										echo "<br />".'Registro Fletero Borrado';
								    }
									
									$stmt->close();

									$stmt = null;

									$stmt = $con->prepare("INSERT INTO fleteros (cuitfle, nombre, usuario, sucadm, password, estado, perfil) VALUES (?,?,?,?,?,?,?)");

									$stmt->bind_param('sssisis',$dataflet[1],$dataflet[2],$dataflet[3],$dataflet[4],$dataflet[5],$dataflet[6],$dataflet[7]);

									$stmt->execute();

					    			if ($stmt->error)
									{
										echo "<br />".'Registro Fletero NO AGREGADO';
								    }
								    else
								    {
										echo "<br />".'Registro Fletero AGREGADO CON EXITO';
								    }
									
									$stmt->close();

									$stmt = null;

					    		}else{

					    			$stmt = $con->prepare("INSERT INTO fleteros (cuitfle, nombre, usuario, sucadm, password, estado, perfil) VALUES (?,?,?,?,?,?,?)");

									$stmt->bind_param('sssisis',$dataflet[1],$dataflet[2],$dataflet[3],$dataflet[4],$dataflet[5],$dataflet[6],$dataflet[7]);

									$stmt->execute();

					    			if ($stmt->error)
									{
										echo "<br />".'Registro Fleteros NO AGREGADO';
								    }
								    else
								    {
										echo "<br />".'Registro Fleteros '.$dataflet[2].' AGREGADO CON EXITO';
								    }
									
									$stmt->close();

									$stmt = null;

					    		}

				    		}

				    	}

				    }

		    		//unlink($directorio."/fleteros".$subnamerep.".asc"); //fleterosM

				}

     		}

		}

	}

// //Archivo FLETERO
// 					    if(file_exists("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/fleteros".$subnamerep.".asc")){

// 					    	chmod("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/fleteros".$subnamerep.".asc",0777);

// 					    	$fletero = fopen("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/fleteros".$subnamerep.".asc", "r");

// 					    	while ($dataflet = fgetcsv($fletero, 1000, ",")){

// 					    		if(isset($dataflet[0])){

// 					    			$sqlflet = "SELECT * FROM fleteros WHERE cuitfle = '$dataflet[1]'";
// 					    			echo "<br />".$dataflet[1], $dataflet[2];
// 						    		$resultflet = mysqli_query($con, $sqlflet);

// 						    		$crowfle = mysqli_fetch_assoc($resultflet);
						    		
// 						    		if($crowfle  != ""){

// 						    			//echo 'Hay registro FLETERO';

// 						    			$stmt = $con->prepare("DELETE FROM fleteros WHERE cuitfle = '$dataflet[1]'");

// 						    			$stmt->execute();

// 						    			if ($stmt->error)
// 										{
// 											//echo 'Registro Fletero NO Borrado';
// 									    }
// 									    else
// 									    {
// 											//echo 'Registro Fletero Borrado';
// 									    }
										
// 										$stmt->close();

// 										$stmt = null;

// 										$stmt = $con->prepare("INSERT INTO fleteros (cuitfle, nombre, usuario, sucadm, password, estado, perfil) VALUES (?,?,?,?,?,?,?)");

// 										$stmt->bind_param('sssisis',$dataflet[1],$dataflet[2],$dataflet[3],$dataflet[4],$dataflet[5],$dataflet[6],$dataflet[7]);

// 										$stmt->execute();

// 						    			if ($stmt->error)
// 										{
// 											//echo 'Registro Fletero NO AGREGADO';
// 									    }
// 									    else
// 									    {
// 											//echo 'Registro Fletero AGREGADO CON EXITO';
// 									    }
										
// 										$stmt->close();

// 										$stmt = null;

// 						    		}else{

// 						    			$stmt = $con->prepare("INSERT INTO fleteros (cuitfle, nombre, usuario, sucadm, password, estado, perfil) VALUES (?,?,?,?,?,?,?)");

// 										$stmt->bind_param('sssisis',$dataflet[1],$dataflet[2],$dataflet[3],$dataflet[4],$dataflet[5],$dataflet[6],$dataflet[7]);

// 										$stmt->execute();

// 						    			if ($stmt->error)
// 										{
// 											//echo 'Registro Fleteros NO AGREGADO';
// 									    }
// 									    else
// 									    {
// 											//echo 'Registro Fleteros AGREGADO CON EXITO';
// 									    }
										
// 										$stmt->close();

// 										$stmt = null;

// 						    		}


// 					    		}

// 					    	}

// 					    }
// //Archivo CLIENTES
// 					    if(file_exists("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/clientes".$subnamerep.".asc")){

// 					    	chmod("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/clientes".$subnamerep.".asc",0777);

// 					    	$cliente = fopen("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/clientes".$subnamerep.".asc", "r");

// 					    	while ($datacli = fgetcsv($cliente, 1000, ",")){

// 					    		if(isset($datacli[0])){

// 					    			$sqlcli = "SELECT * FROM clientes WHERE codcli = '$datacli[1]'";

// 						    		$resultcli = mysqli_query($con, $sqlcli);

// 						    		$crowcli = mysqli_fetch_assoc($resultcli);
						    		
// 						    		if($crowcli  != ""){

// 						    			//echo 'Hay registro Cliente';

// 						    			$stmt = $con->prepare("DELETE FROM clientes WHERE codcli = '$datacli[1]'");

// 						    			$stmt->execute();

// 						    			if ($stmt->error)
// 										{
// 											//echo 'Registro Cientes NO Borrado';
// 									    }
// 									    else
// 									    {
// 											//echo 'Registro Clientes Borrado';
// 									    }
										
// 										$stmt->close();

// 										$stmt = null;

// 										$stmt = $con->prepare("INSERT INTO clientes (codcli, sucadm, nombre, password, email1, email2, email3, cuit, usuario, foto) VALUES (?,?,?,?,?,?,?,?,?,?)");

// 										$stmt->bind_param('isssssssss',$datacli[1],$datacli[2],$datacli[3],$datacli[4],$datacli[5],$datacli[6],$datacli[7],$datacli[8],$datacli[9],$datacli[10]);

// 										$stmt->execute();

// 						    			if ($stmt->error)
// 										{
// 											//echo 'Registro Clientes NO AGREGADO';
// 									    }
// 									    else
// 									    {
// 											//echo 'Registro Clientes AGREGADO CON EXITO';
// 									    }
										
// 										$stmt->close();

// 										$stmt = null;

// 						    		}else{

// 						    			$stmt = $con->prepare("INSERT INTO clientes (codcli, sucadm, nombre, password, email1, email2, email3, cuit, usuario, foto) VALUES (?,?,?,?,?,?,?,?,?,?)");

// 										$stmt->bind_param('isssssssss',$datacli[1],$datacli[2],$datacli[3],$datacli[4],$datacli[5],$datacli[6],$datacli[7],$datacli[8],$datacli[9],$datacli[10]);

// 										$stmt->execute();

// 						    			if ($stmt->error)
// 										{
// 											//echo 'Registro Clientes NO AGREGADO';
// 									    }
// 									    else
// 									    {
// 											//echo 'Registro Clientes AGREGADO CON EXITO';
// 									    }
										
// 										$stmt->close();

// 										$stmt = null;

// 						    		}


// 					    		}

// 					    	}


// 					    }
// //Archivo CARS
// 					    if(file_exists("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/subecars".$subnamerep.".asc")){

// 					    	chmod("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/subecars".$subnamerep.".asc",0777);

// 					    	$cars = fopen("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/subecars".$subnamerep.".asc", "r");

// 					    	while ($datacars = fgetcsv($cars, 1000, ",")){

// 					    		if(isset($datacars[0])){

// 					    			$sqlcar = "SELECT * FROM tb_cars WHERE codcli = '$datacars[1]' AND nguia = '$datacars[4]' AND reparto = '$datacars[11]'";

// 						    		$resultcar = mysqli_query($con, $sqlcar);

// 						    		$crowcar = mysqli_fetch_assoc($resultcar);
						    		
// 						    		if($crowcar  != ""){

// 						    			//echo 'Hay registro CAR';

// 						    			$stmt = $con->prepare("DELETE FROM tb_cars WHERE codcli = '$datacars[1]' AND nguia = '$datacars[4]' AND reparto = '$datacars[11]'");

// 						    			$stmt->execute();

// 						    			if ($stmt->error)
// 										{
// 											//echo 'Registro CAR NO Borrado';
// 									    }
// 									    else
// 									    {
// 											//echo 'Registro CAR Borrado';
// 									    }
										
// 										$stmt->close();

// 										$stmt = null;

// 										$stmt = $con->prepare("INSERT INTO tb_cars (codcli, id_sucadm, nombre, nguia, org, dst, nomrem, nomdes, frecib, pdf, reparto) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

// 										$stmt->bind_param('iisiiissdsi',$datacars[1],$datacars[2],$datacars[3],$datacars[4],$datacars[5],$datacars[6],$datacars[7],$datacars[8],$datacars[9],$datacars[10],$datacars[11]);

// 										$stmt->execute();

// 						    			if ($stmt->error)
// 										{
// 											//echo 'Registro CARS NO AGREGADO';
// 									    }
// 									    else
// 									    {
// 											//echo 'Registro CARS AGREGADO CON EXITO';
// 									    }
										
// 										$stmt->close();

// 										$stmt = null;

// 						    		}else{

// 						    			$stmt = $con->prepare("INSERT INTO tb_cars (codcli, id_sucadm, nombre, nguia, org, dst, nomrem, nomdes, frecib, pdf, reparto) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

// 										$stmt->bind_param('iisiiissdsi',$datacars[1],$datacars[2],$datacars[3],$datacars[4],$datacars[5],$datacars[6],$datacars[7],$datacars[8],$datacars[9],$datacars[10],$datacars[11]);

// 										$stmt->execute();

// 						    			if ($stmt->error)
// 										{
// 											//echo 'Registro CARS NO AGREGADO';
// 									    }
// 									    else
// 									    {
// 											//echo 'Registro CARS AGREGADO CON EXITO';
// 									    }
										
// 										$stmt->close();

// 										$stmt = null;

// 						    		}


// 					    		}

// 					    	}

// 					    }

// 					    if(file_exists("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/h".$name.".asc")){
// 							unlink("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/h".$name.".asc"); //hrepM123456
// 						}

// 						if(file_exists("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/".$name.".asc")){
// 							unlink("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/".$name.".asc"); //repM123456
// 						}
						
// 						if(file_exists("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/subecars".$subnamerep.".asc")){
// 							unlink("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/subecars".$subnamerep.".asc"); //subecarsM
// 						}

// 						if(file_exists("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/fleteros".$subnamerep.".asc")){
// 							//unlink("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/fleteros".$subnamerep.".asc"); //fleterosM
// 						}

// 						if(file_exists("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/clientes".$subnamerep.".asc")){
// 							//unlink("c:/xampp/htdocs/cars/vistas/archivos/repartos/".$subnamerep."/clientes".$subnamerep.".asc"); //clientesM
// 						}

// 					}



// 				}



// 		  		//unlink("c:/xampp/htdocs/cars/vistas/archivos/suberepar/M/".$repname);

// 			}

		//}



	//}

	//closedir($dir_handle);




?>