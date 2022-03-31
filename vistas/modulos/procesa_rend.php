<?php 

	$servername = "localhost";
	$username = "jorge";
	$password = "Jepers121346";

   	try {
	  $con = new PDO("mysql:host=$servername;dbname=cars", $username, $password);
	  // set the PDO error mode to exception
	  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  echo "Connected successfully";
	} catch(PDOException $e) {
	  //echo "Connection failed: " . $e->getMessage();
	}

	$directorio_base = "/var/www/html/cars/vistas/archivos/suberinde";

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
  		//echo($files[$i]);
  		$subnamerep = substr($files[$i], 6,1);
		//echo "<br />".$subnamerep;
		//extraigo la letra de la sucursal en el nombre del archivo
		$subrepnum = substr($files[$i], 7,-4);
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

		$directorio = "/var/www/html/cars/vistas/archivos/rendidos/".$subnamerep;
		//echo "<br />".$directorio;
		$archirep = $directorio."/".$repname; 
		//echo "<br />".$archirep;

		if($ext === 'zip') {

			$existe = 0;
			$existeh = 0;

			if(file_exists($archirep)){

				$archexis = $name;

				unlink($directorio."/".$repname); //Archivo zip

				if(file_exists($directorio."/".$archexis.".asc")){
					unlink($directorio."/".$archexis.".asc"); //rinrepM123456
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
				  	chmod($directorio."/".$name.".asc",0777);

				  	// $archrep = $name.".asc";

				  	// $archead = $nomrepart.".asc";

				  	$cabezarep = fopen($directorio."/".$name.".asc", "r");

				  	while ($datahrep = fgetcsv($cabezarep, 1000, ",")){
				    	//var_dump($datahrep);
				    	if(isset($datahrep[0])){

				    		//var_dump($datahrep);

				    		$sqlhrep = $con->prepare("UPDATE hrepartos SET rendido = '$datahrep[6]', frendir = '$datahrep[7]' WHERE codoff = '$datahrep[1]' AND repnum = '$datahrep[3]'");
				    		
				    		if($sqlhrep ->execute()){

				    			echo "<br />".'Registro HREPARTOS Rendido';

				    		}else{

				    			echo "<br />".'Registro HREPARTOS NO Rendido';

				    		}

				    	}

				    }

				    unlink($directorio."/".$name.".asc");
				}

			}

		}

		echo "$directorio_base";

		echo "$files[$i]";

		unlink($directorio_base."/".$files[$i]);
		//unlink($directorio."/".$files[$i]);

  	}

 ?>