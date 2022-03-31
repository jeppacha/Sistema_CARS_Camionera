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

	$directorio_base = "/var/www/html/cars/vistas/archivos/bajarepar/J";
	$directorio_arch = "/home/jorge";

	//unlink($directorio_arch."/reparcompM.txt");

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

  		unlink($directorio_base."/".$files[$i]);

  	}

  	$stmt = $con->prepare("DELETE FROM rindehreparJ");

	if($stmt->execute()){

		echo "<br />".'Registro HREPARTOS Borrado';

    }else{

		echo "<br />".'Registro HREPARTOS NO Borrado';
    }

	$sqlhrep = $con->prepare("SELECT * FROM hrepartos WHERE codoff = '6' AND cantg = guiarend AND enviado is null" );
				    		
	$sqlhrep ->execute();

	$resultahrep = $sqlhrep -> fetchAll();

	//var_dump($resultahrep1);
	$completo = 1;

	foreach ($resultahrep as $key => $value) {

		//var_dump($value);
		$stmt = $con->prepare("INSERT INTO rindehreparJ (codoff, cuitfle, repnro, completo) VALUES (:codoff,:cuitfle,:repnro,:completo)");
		$stmt->bindParam(':codoff',$value[1], PDO::PARAM_STR);
		$stmt->bindParam(':cuitfle',$value[2], PDO::PARAM_STR);
		$stmt->bindParam(':repnro',$value[3], PDO::PARAM_STR);
		$stmt->bindParam(':completo',$completo, PDO::PARAM_STR);

		if($stmt->execute()){

			echo "<br />".'Registro RINDE HREPARTOS AGREGADO CON EXITO';
			
	    }else{
			
			echo "<br />".'Registro Rinde HREPARTOS NO AGREGADO';
	    }

	}

	$sqlrinde = $con->prepare("SELECT * FROM rindehreparJ" );
				    		
	$sqlrinde ->execute();

	$rindehrep = $sqlrinde -> fetchAll();
	//var_dump($rindehrep);
	//$file = "reparcompM.txt"; //le doy un nombre al archivo
	//$filedest = "reparcompM.txt";

	//file_put_contents($file, "" . PHP_EOL); //creamos el archivo

	//$fp = fopen($file, 'w');

	$separa = "\t";
	$jump = "\n";
	

	foreach($rindehrep as $value){

		$file = "compJ".$value["repnro"].".txt"; //le doy un nombre al archivo
		$filedest = "compJ".$value["repnro"].".txt";

		file_put_contents($file, "" . PHP_EOL); //creamos el archivo

		$fp = fopen($file, 'w');

		$registro = $value["codoff"].$separa.$value["cuitfle"].$separa.$value["repnro"].$separa.$value["completo"].$jump;

		fwrite($fp, $registro); 

		fclose($fp);
		
		chmod($file, 0777);

		if(filesize($file) > 0){
  			echo "El archivo tiene contenido";

  			$exito = copy($directorio_arch."/".$file, $directorio_base."/".$filedest);

			//echo "scp -B /home/jorge/compM".$value["repnro"].".txt jorgeweb@192.168.2.145:/home/lcm/repartos/bajados/";
		}else{
 			echo "El archivo esta vacio";
 
 			echo "Archivo NO Copiado";			
		}

		$stmt = $con->prepare("UPDATE hrepartos SET enviado = :enviado WHERE codoff = :codoff AND cuitfle = :cuitfle AND repnum = :repnum");
		$stmt->bindParam(':codoff',$value["codoff"], PDO::PARAM_STR);
		$stmt->bindParam(':cuitfle',$value["cuitfle"], PDO::PARAM_STR);
		$stmt->bindParam(':repnum',$value["repnro"], PDO::PARAM_STR);
		$stmt->bindParam(':enviado',$completo, PDO::PARAM_STR);

		if($stmt->execute()){									

			echo "<br/>".'Registro HREPARTOS Actualizado';
			
	    }else{
			
			echo "<br/>".'Registro HREPARTOS NO Actualizado';
	    }
	}

	if (file_exists($file)) { //verifico que el archivo haya sido creado
		//header('Content-Description: File Transfer');
		//header('Content-Type: application/octet-stream');
		//header('Content-Disposition: attachment; filename='.basename($file));
		//header('Content-Transfer-Encoding: binary');
		//header('Expires: 0');
		//header('Cache-Control: must-revalidate');
		//header('Pragma: public');
		//header('Content-Length: ' . filesize($file));
		//ob_clean();
		//flush();
		//readfile($file);			
	}else{
		//en caso no se haya creado el archivo, muestro un mensaje
		echo "Hubo un error al momento de crear el archivo, verifique los permisos de las carpetas del servidor.";
	}

	//fclose($fp);
	//chmod($file, 0777);

	if(filesize($file) > 0){
  		//echo "El archivo tiene contenido";
  		//$exito = copy($directorio_arch."/".$file, $directorio_base."/".$filedest);

		//chmod($directorio_base."/".$filedest, 0777);

		//echo "Archivo Copiado";

 	} else {
 		//echo "El archivo esta vacio";

 		//echo "Archivo NO Copiado";
 	}

	
?> 