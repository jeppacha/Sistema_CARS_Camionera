<?php

require_once "conexion.php";

////////////////////////////////////////////////////
// Convierte fecha de español a mysql
////////////////////////////////////////////////////
function cambiarFormatoAMysql($fecha){
    preg_match( '/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2,4})/', $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}

class ModeloCars{

	/*=============================================
	MOSTRAR CARS
	=============================================*/

	static public function mdlMostrarCars($tabla, $item, $valor, $orden){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $orden DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt ->execute();

			return $stmt -> fetch();

			$stmt -> close();

			$stmt = null;

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden");

			$stmt ->execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;

		}

	}

	/*=============================================
	RANGO CARS
	=============================================*/

	static public function mdlRangoCars($tabla, $item, $valor, $orden){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $orden DESC");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt ->execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	BUSCAR CARS
	=============================================*/

	static public function mdlBuscarCarsRep($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		$stmt ->execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE CARS DE CLIENTE
	=============================================*/

	static public function mdlIngresarCars($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codcli, nombre, nguia, org, dst, nomrem, nomdes, frecib, fdeliv, pdf) VALUES (:codcli, :nombre, :nguia, :org, :dst, :nomrem, :nomdes, :frecib, :fdeliv, :pdf)"); 

		$stmt->bindParam(":codcli", $datos["codcli"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":nguia", $datos["nguia"], PDO::PARAM_INT);
		$stmt->bindParam(":org", $datos["org"], PDO::PARAM_INT);
		$stmt->bindParam(":dst", $datos["dst"], PDO::PARAM_INT);
		$stmt->bindParam(":nomrem", $datos["nomrem"], PDO::PARAM_STR);
		$stmt->bindParam(":nomdes", $datos["nomdes"], PDO::PARAM_STR);
		$stmt->bindParam(":frecib", cambiarFormatoAMysql($datos["frecib"]), PDO::PARAM_STR);
		$stmt->bindParam(":fdeliv", cambiarFormatoAMysql($datos["fdeliv"]), PDO::PARAM_STR);
		$stmt->bindParam(":pdf", $datos["pdf"], PDO::PARAM_STR);
		// var_dump($datos["foto"]);
		// var_dump($datos["codcli_legajo"]);
		// var_dump($datos["email"]);
		// var_dump($datos["cuit"]);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR CARS
	=============================================*/

	static public function mdlEditarCar($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codcli = :codcli, nombre = :nombre, nomrem = :nomrem, nomdes = :nomdes, frecib = :frecib, fdeliv = :fdeliv, pdf = :pdf WHERE nguia = :nguia");  

		$stmt->bindParam(":codcli", $datos["codcli"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":nguia", $datos["nguia"], PDO::PARAM_INT);
		$stmt->bindParam(":nomrem", $datos["nomrem"], PDO::PARAM_STR);
		$stmt->bindParam(":nomdes", $datos["nomdes"], PDO::PARAM_STR);
		$stmt->bindParam(":frecib", cambiarFormatoAMysql($datos["frecib"]), PDO::PARAM_STR);
		$stmt->bindParam(":fdeliv", cambiarFormatoAMysql($datos["fdeliv"]), PDO::PARAM_STR);
		$stmt->bindParam(":pdf", $datos["pdf"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	=            BORRAR CAR                 =
	=============================================*/

	static public function mdlBorrarCar($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}	

	/*=============================================
	=            BORRAR CAR DESDE USUARIOS               =
	=============================================*/

	static public function mdlBorrarCarsUs($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE codcli = :codcli");

		$stmt -> bindParam(":codcli", $datos, PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}	

	/*=============================================
	SUMA TOTAL DE CARS 
	=============================================*/

	static public function mdlSumaTotalCars($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(codcli) AS totcar FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;	
	}

	/*=============================================
	SUMA TOTAL DE CARS de UN CLIENTE
	=============================================*/

	static public function mdlSumaCarsCli($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(nguia) AS totcar FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;	
	}
	
	/*=============================================
	MOSTRAR CARS EN CARS-CLIENTES
	=============================================*/

	static public function mdlMostrarCarsCl($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt ->execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;

		}

	}
	/*=============================================
	RANGO DE FECHAS
	=============================================*/	

	static public function mdlRangoFechasCars($tabla, $fechaInicial, $fechaFinal,$sucursal,$codcli){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fdeliv DESC");

			$stmt ->execute();

			return $stmt -> fetchAll();

		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fdeliv like '%$fechaFinal%' AND id_sucadm = $sucursal AND codcli = $codcli ORDER BY fdeliv");

			$stmt -> bindParam(":fdeliv", $fechaFinal,PDO::PARAM_STR);

			$stmt ->execute();

			return $stmt -> fetchAll();

		}else{

			$fechaActual = new DateTime();
			$fechaActual -> add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 -> add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_sucadm = $sucursal AND codcli = $codcli AND fdeliv BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY fdeliv");

			}else{

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_sucadm = $sucursal AND codcli = $codcli AND fdeliv BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY fdeliv");

			}

			$stmt ->execute();

			return $stmt -> fetchAll();

		}

	}

	/*=============================================
	BUSCA CARS YA SUBIDOS PARA QUE NO VUELVA A SUBIR
	=============================================*/

	static public function mdlBuscarCars($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		//var_dump($valor);

		$stmt ->execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	= ACTUALIZA FOTO Y FECHA DE CARS DE GUIA      =
	=============================================*/
	
	static public function mdlActualizaCar($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codcli = :codcli, id_sucadm = :id_sucadm,nombre = :nombre, org = :org, dst = :dst, nomrem = :nomrem, nomdes = :nomdes, frecib = :frecib, pdf = :pdf, estado = :estado, fdeliv = :fdeliv WHERE nguia = :nguia AND reparto = :reparto");  

		$stmt->bindParam(":codcli", $datos["codcli"], PDO::PARAM_INT);
		$stmt->bindParam(":id_sucadm", $datos["id_sucadm"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":org", $datos["org"], PDO::PARAM_INT);
		$stmt->bindParam(":dst", $datos["dst"], PDO::PARAM_INT);
		$stmt->bindParam(":nomrem", $datos["nomrem"], PDO::PARAM_STR);
		$stmt->bindParam(":nomdes", $datos["nomdes"], PDO::PARAM_STR);
		$stmt->bindParam(":frecib", $datos["frecib"], PDO::PARAM_STR);
		$stmt->bindParam(":pdf", $datos["pdf"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":fdeliv", $datos["fdeliv"], PDO::PARAM_STR);
		$stmt->bindParam(":nguia", $datos["nguia"], PDO::PARAM_INT);
		$stmt->bindParam(":reparto", $datos["reparto"], PDO::PARAM_STR);
		
		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	=  BORRAR CAR SUBIDO POR ARCHIVO REPARTO      =
	=============================================*/

	static public function mdlBorrarCarArch($tabla, $item1, $datos1, $item2, $datos2, $item3, $datos3){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2 AND $item3 = :$item3");

		$stmt -> bindParam(":".$item1, $datos1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $datos2, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item3, $datos3, PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

}