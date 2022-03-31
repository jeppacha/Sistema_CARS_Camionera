<?php 

require_once "conexion.php";

class ModeloRepartos{

	/*=============================================
	MOSTRAR REPARTOS
	=============================================*/

	static public function mdlMostrarRepartos($tabla, $item, $valor){
		//var_dump($valor);
		if($item != null){
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY frepar DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

			$stmt -> close();

			$stmt = null;
		
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY frepar DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;

		}

	}

	/*=============================================
	MOSTRAR GUIA
	=============================================*/

	static public function mdlMostrarGuia($tabla, $item, $valor, $item1, $valor1){
		//var_dump($valor);
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1 = :$item1");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	
	/*=============================================
	VER REPARTOS
	=============================================*/

	static public function mdlVerRepartos($tabla, $item, $valor){
		//var_dump($valor);
		if($item != null){
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND rendido = 0 ORDER BY frepar");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;
		
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY frepar");

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;

		}

	}

	/*=============================================
	SUMA TOTAL DE REPARTOS NO RENDIDOS
	=============================================*/

	static public function mdlSumaRepFle($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(repnum) AS totrep FROM $tabla WHERE $item = :$item AND rendido=0");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;	
	}

	/*=============================================
	ENTREGA DE GUIAS DE UN REPARTO
	=============================================*/

	static public function mdlEntregaReparto($tabla, $item, $valor, $item1){
//var_dump($valor);
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1 is null ORDER BY nguia");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

		$stmt -> execute();
		
		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;	
	}

	/*=============================================
	ENTREGA DE GUIAS DE UN REPARTO
	=============================================*/

	static public function mdlEntregaRepartoAdm($tabla, $item, $valor){
//var_dump($valor);
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY nguia");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

		$stmt -> execute();
		
		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;	
	}

	/*=============================================
	=            MODIFICA GUIA EN REPARTO
	=============================================*/

	static public function mdlModificaGuia($tabla, $item, $valor, $item1, $valor1, $item2, $valor2){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE $item1 = :$item1 AND $item2 = :$item2");

		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt->bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ENTREGA GUIAS CON CAR
	=============================================*/

	static public function mdlEntregaGuiacc($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codoff = :codoff, cuitfle = :cuitfle, repfec = :repfec, fecdeliv = :fecdeliv, codcli = :codcli, deliv = :deliv, fotocar = :fotocar, motivo = :motivo WHERE nguia = :nguia AND repnro = :repnro");  

		$stmt->bindParam(":codoff", $datos["codoff"], PDO::PARAM_STR);
		$stmt->bindParam(":cuitfle", $datos["cuitfle"], PDO::PARAM_STR);
		$stmt->bindParam(":repfec", $datos["repfec"], PDO::PARAM_STR);
		$stmt->bindParam(":fecdeliv", $datos["fecdeliv"], PDO::PARAM_STR);
		$stmt->bindParam(":codcli", $datos["codcli"], PDO::PARAM_STR);
		$stmt->bindParam(":deliv", $datos["deliv"], PDO::PARAM_STR);
		$stmt->bindParam(":fotocar", $datos["fotocar"], PDO::PARAM_STR);
		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
		$stmt->bindParam(":nguia", $datos["nguia"], PDO::PARAM_STR);
		$stmt->bindParam(":repnro", $datos["repnro"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	NO ENTREGA GUIAS CON CAR
	=============================================*/

	static public function mdlNoEntregaGuia($tabla, $datos){
		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET deliv = :deliv, motivo = :motivo WHERE nguia = :nguia AND repnro = :repnro");  

		
		$stmt->bindParam(":deliv", $datos["deliv"], PDO::PARAM_STR);
		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
		$stmt->bindParam(":nguia", $datos["nguia"], PDO::PARAM_STR);
		$stmt->bindParam(":repnro", $datos["repnro"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ENTREGA GUIAS SIN CAR
	=============================================*/

	static public function mdlEntregaGuiasc($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codoff = :codoff, cuitfle = :cuitfle, repfec = :repfec, fecdeliv = :fecdeliv, codcli = :codcli, deliv = :deliv, fotocar = :fotocar, motivo = :motivo WHERE nguia = :nguia AND repnro = :repnro");  

		$stmt->bindParam(":codoff", $datos["codoff"], PDO::PARAM_STR);
		$stmt->bindParam(":cuitfle", $datos["cuitfle"], PDO::PARAM_STR);
		$stmt->bindParam(":repfec", $datos["repfec"], PDO::PARAM_STR);
		$stmt->bindParam(":fecdeliv", $datos["fecdeliv"], PDO::PARAM_STR);
		$stmt->bindParam(":codcli", $datos["codcli"], PDO::PARAM_STR);
		$stmt->bindParam(":deliv", $datos["deliv"], PDO::PARAM_STR);
		$stmt->bindParam(":fotocar", $datos["fotocar"], PDO::PARAM_STR);
		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
		$stmt->bindParam(":nguia", $datos["nguia"], PDO::PARAM_STR);
		$stmt->bindParam(":repnro", $datos["repnro"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	VERIFICA CANTIDAD DE GUIAS ENTREGADAS
	=============================================*/

	static public function mdlMiraRinde($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		$stmt -> execute();
		
		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	
	}

	/*=============================================
	ACTUALIZA CANTIDAD DE GUIAS ENTREGADAS
	=============================================*/

	static public function mdlActualizaHreparto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET guiarend = :guiarend WHERE codoff = :codoff AND repnum = :repnum");  

		$stmt->bindParam(":codoff", $datos["codoff"], PDO::PARAM_STR);
		$stmt->bindParam(":repnum", $datos["repnum"], PDO::PARAM_STR);
		$stmt->bindParam(":guiarend", $datos["guiarend"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	VERIFICA SI SE RINDIO LA GUIA EN UN REPARTO
	=============================================*/

	static public function mdlRevisaGuia($tablag,$itemg1,$valorg1,$itemg2,$valorg2,$itemg3,$valorg3){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tablag WHERE $itemg1 = :$itemg1 AND $itemg2 = :$itemg2 AND $itemg3 = :$itemg3");

		$stmt -> bindParam(":".$itemg1, $valorg1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$itemg2, $valorg2, PDO::PARAM_STR);
		$stmt -> bindParam(":".$itemg3, $valorg3, PDO::PARAM_STR);

		$stmt -> execute();
		
		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	
	}

	/*=============================================
	ACTUALIZA GUIAS RENDIDA EN UN REPARTO
	=============================================*/

	static public function mdlActualizaGuia($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET guiarend = :guiarend WHERE codoff = :codoff AND repnum = :repnum");  

		$stmt->bindParam(":codoff", $datos["codoff"], PDO::PARAM_STR);
		$stmt->bindParam(":repnum", $datos["repnum"], PDO::PARAM_STR);
		$stmt->bindParam(":guiarend", $datos["guiarend"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	INGRESA GUIAS RENDIDA EN UN REPARTO
	=============================================*/

	static public function mdlIngresaGuia($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codoff, repnro, nguia, entrega) VALUES (:codoff, :repnro, :nguia, :entrega)");

		$stmt->bindParam(":codoff", $datos["codoff"], PDO::PARAM_STR);
		$stmt->bindParam(":repnro", $datos["repnro"], PDO::PARAM_STR);
		$stmt->bindParam(":nguia", $datos["nguia"], PDO::PARAM_STR);
		$stmt->bindParam(":entrega", $datos["entrega"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;
		
	}

	/*=============================================
	SUMA TOTAL DE GUIAS de UN FLETERO
	=============================================*/

	static public function mdlSumaGuiasFle($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(nguia) AS totguia FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;	
	}


}