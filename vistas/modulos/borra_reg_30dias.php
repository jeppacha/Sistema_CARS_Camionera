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

/*===========================================================*/

	//BORRA REGISTROS DE CARS Tabla "tb_cars"

	$fechahoy = date("Y-m-d");
	$fecha = strtotime('-45 day', strtotime($fechahoy));
	$fecha = date('Y-m-d', $fecha);
	$directorio = "/var/www/html/cars";

	//echo($fecha);

	$sqlcar = $con->prepare("SELECT * FROM tb_cars WHERE fdeliv<='$fecha'");
				    		
	$sqlcar ->execute();

	$resultacar = $sqlcar -> fetchall();

	for($i=0;$i<count($resultacar);$i++){

		//echo "CARS " .$i. ": " .$resultacar[$i][0];
		//unlink($directorio."/".$resultacar[$i][10]);
		$nguia = $resultacar[$i][4];
		$id = $resultacar[$i][0];

		$stmtcar = $con->prepare("DELETE FROM tb_cars WHERE id = '$id' AND nguia = '$nguia'");

		if($stmtcar->execute()){

			echo 'Registro TB_CARS Guia: '.$resultacar[$i][4].' Borrado';

	    }else{

			echo 'Registro TB_CARS Guia: '.$resultacar[$i][4].' NO Borrado';
	    }
		
	}

	$sqlcar1 = $con->prepare("SELECT * FROM tb_cars WHERE frecib<='$fecha'");
				    		
	$sqlcar1 ->execute();

	$resultacar1 = $sqlcar1 -> fetchall();

	for($i=0;$i<count($resultacar1);$i++){

		if($resultacar1[$i][10] == null){

			echo "    CARS " .$i. ": " .$resultacar1[$i][4];

			$nguia = $resultacar1[$i][4];
			$id = $resultacar1[$i][0];

			$stmtcar = $con->prepare("DELETE FROM tb_cars WHERE id = '$id' AND nguia = '$nguia'");
	
			if($stmtcar->execute()){

				echo 'Registro TB_CARS Guia: '.$resultacar1[$i][4].' Borrado';

		    }else{

				echo 'Registro TB_CARS Guia: '.$resultacar1[$i][4].' NO Borrado';
		    }

		}
	
	}

/*===========================================================*/

	//BORRA REGISTROS DE GUIAS Tabla "repartos"

	$fechag = strtotime('-20 day', strtotime($fechahoy));
	$fechag = date('Y-m-d', $fechag);

	$sqlguia = $con->prepare("SELECT * FROM repartos WHERE fecdeliv<='$fechag'");
			    		
	$sqlguia ->execute();

	$resultaguia = $sqlguia -> fetchall();

	for($i=0;$i<count($resultaguia);$i++){

		//echo "   Guia " .$i. ": " .$resultaguia[$i][5];
		//unlink($directorio."/".$resultacar[$i][10]);
		$reparto = $resultaguia[$i][3];
		$nguia = $resultaguia[$i][5];
		$id = $resultaguia[$i][0];

		$stmtguia = $con->prepare("DELETE FROM repartos WHERE id = '$id' AND repnro = '$reparto' AND nguia = '$nguia'");

		if($stmtguia->execute()){

			echo 'Registro TB_CARS Guia: '.$resultaguia[$i][5].' Borrado';

	    }else{

			echo 'Registro TB_CARS Guia: '.$resultaguia[$i][5].' NO Borrado';
	    }
	
	}

	$sqlguia = $con->prepare("SELECT * FROM repartos WHERE repfec<='$fechag'");
			    		
	$sqlguia ->execute();

	$resultaguia = $sqlguia -> fetchall();

	for($i=0;$i<count($resultaguia);$i++){

		//echo "   Guia " .$i. ": " .$resultaguia[$i][5];
		//unlink($directorio."/".$resultacar[$i][10]);
		if($resultaguia[$i][7] == 0){
			
			$reparto = $resultaguia[$i][3];
			$nguia = $resultaguia[$i][5];
			$id = $resultaguia[$i][0];

			$stmtguia = $con->prepare("DELETE FROM repartos WHERE id = '$id' AND repnro = '$reparto' AND nguia = '$nguia'");

			if($stmtguia->execute()){

				echo 'Registro TB_CARS Guia: '.$resultaguia[$i][5].' Borrado';

		    }else{

				echo 'Registro TB_CARS Guia: '.$resultaguia[$i][5].' NO Borrado';
		    }

		}

		if($resultaguia[$i][7] == null){
			
			$reparto = $resultaguia[$i][3];
			$nguia = $resultaguia[$i][5];
			$id = $resultaguia[$i][0];

			$stmtguia = $con->prepare("DELETE FROM repartos WHERE id = '$id' AND repnro = '$reparto' AND nguia = '$nguia'");

			if($stmtguia->execute()){

				echo 'Registro TB_CARS Guia: '.$resultaguia[$i][5].' Borrado';

		    }else{

				echo 'Registro TB_CARS Guia: '.$resultaguia[$i][5].' NO Borrado';
		    }

		}		    
	
	}

/*===========================================================*/

	//BORRA REGISTROS DE REPARTOS Tabla "hrepartos"

	$fecharep = strtotime('-20 day', strtotime($fechahoy));
	$fecharep = date('Y-m-d', $fecharep);

	$sqlrep = $con->prepare("SELECT * FROM hrepartos WHERE frendir<='$fecharep'");
			    		
	$sqlrep ->execute();

	$resultarep = $sqlrep -> fetchall();

	for($i=0;$i<count($resultarep);$i++){

		//echo "   Guia " .$i. ": " .$resultaguia[$i][5];
		//unlink($directorio."/".$resultacar[$i][10]);
		$reparto = $resultarep[$i][3];
		$rendido = 1;
		$id = $resultarep[$i][0];

		$stmtrep = $con->prepare("DELETE FROM hrepartos WHERE id = '$id' AND repnum = '$reparto' AND rendido = '$rendido'");

		if($stmtrep->execute()){

			echo 'Registro HREPARTOS Reparto: '.$resultarep[$i][3].' Borrado';

	    }else{

			echo 'Registro HREPARTOS Reparto: '.$resultarep[$i][3].' NO Borrado';
	    }
	
	}


?>