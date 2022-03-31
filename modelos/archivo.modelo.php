<?php

require_once "conexion.php";

class ModeloArchivo{

	/*=============================================
	SUBE ARCHIVO DE CLIENTES
	=============================================*/
	static public function mdlSubirClientes($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id, codcli, sucadm, nombre, password, email, cuit, usuario, foto, ultimo_login) VALUES (:id, :codcli, :sucadm, :nombre, :password, :email, :cuit, :usuario, :foto, :ultimo_login)"); 

		$stmt->bindParam(":id", $datos[0], PDO::PARAM_STR);
		$stmt->bindParam(":codcli", $datos[1], PDO::PARAM_STR);
		$stmt->bindParam(":sucadm", $datos[2], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos[3], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos[4], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos[5], PDO::PARAM_STR);
		$stmt->bindParam(":cuit", $datos[6], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos[7], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos[8], PDO::PARAM_STR);
		$stmt->bindParam(":ultimo_login", $datos[9], PDO::PARAM_STR);

		//var_dump($stmt);
		if($stmt->execute()){

			return "ok";

			$stmt -> close();

			$stmt = null;

		}else{

			return "error";

			$stmt -> close();

			$stmt = null;
		}

		

	}

	/*=============================================
				SUBE ARCHIVO DE CARS
	=============================================*/
	static public function mdlSubirCars($tabla, $datos){
		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codcli, id_sucadm, nombre, nguia, org, dst, nomrem, nomdes, frecib, pdf, reparto) VALUES (:codcli, :id_sucadm, :nombre, :nguia, :org, :dst, :nomrem, :nomdes, :frecib, :pdf, :reparto)"); 

		//$stmt->bindParam(":id", $datos[0], PDO::PARAM_STR);
		$stmt->bindParam(":codcli", $datos[1], PDO::PARAM_STR);
		$stmt->bindParam(":id_sucadm", $datos[2], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos[3], PDO::PARAM_STR);
		$stmt->bindParam(":nguia", $datos[4], PDO::PARAM_STR);
		$stmt->bindParam(":org", $datos[5], PDO::PARAM_STR);
		$stmt->bindParam(":dst", $datos[6], PDO::PARAM_STR);
		$stmt->bindParam(":nomrem", $datos[7], PDO::PARAM_STR);
		$stmt->bindParam(":nomdes", $datos[8], PDO::PARAM_STR);
		$stmt->bindParam(":frecib", $datos[9], PDO::PARAM_STR);
		$stmt->bindParam(":pdf", $datos[11], PDO::PARAM_STR);
		$stmt->bindParam(":reparto", $datos[12], PDO::PARAM_STR);
		
		//$stmt->bindParam(":estado", $datos[12], PDO::PARAM_STR);
		//$stmt->bindParam(":fdeliv", $datos[13], PDO::PARAM_STR);
		//var_dump($stmt);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	SUBE ARCHIVO DE CABECERA DE REPARTO
	=============================================*/

	static public function mdlSubirHreparto($tabla, $datos){
		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codoff, cuitfle, repnum, frepar, cantg, rendido) VALUES (:codoff, :cuitfle, :repnum, :frepar, :cantg, :rendido)"); 

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

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	SUBE ARCHIVO DE REPARTO
	=============================================*/

	static public function mdlSubirReparto($tabla, $datos){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codoff, cuitfle, repnro, repfec, nguia, codcli) VALUES (:codoff, :cuitfle, :repnro, :repfec, :nguia, :codcli)"); 

		//$stmt->bindParam(":id", $datos[0], PDO::PARAM_STR);
		$stmt->bindParam(":codoff", $datos[1], PDO::PARAM_STR);
		$stmt->bindParam(":cuitfle", $datos[2], PDO::PARAM_STR);
		$stmt->bindParam(":repnro", $datos[3], PDO::PARAM_STR);
		$stmt->bindParam(":repfec", $datos[4], PDO::PARAM_STR);
		$stmt->bindParam(":nguia", $datos[5], PDO::PARAM_STR);
		$stmt->bindParam(":codcli", $datos[6], PDO::PARAM_STR);
		//$stmt->bindParam(":deliv", $datos[7], PDO::PARAM_STR);
		//$stmt->bindParam(":fotocar", $datos[8], PDO::PARAM_STR);
		//$stmt->bindParam(":motivo", $datos[9], PDO::PARAM_STR);
		//$stmt->bindParam(":fecdeliv", $datos[10], PDO::PARAM_STR);
		
		//var_dump($stmt);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	
	/*=============================================
	BORRA REGISTRO DE TABLA DETERMINADA
	=============================================*/

	static public function mdlBorrarRegistro($tabla, $item1, $datos1, $item2, $datos2, $item3, $datos3){

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

	/*=============================================
	BORRA REGISTRO DE TABLA CABECERA
	=============================================*/

	static public function mdlBorrarRegistroh($tabla, $item1, $datos1, $item2, $datos2){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2");

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


	/*=============================================
	SUBE ARCHIVO DE FLETEROS
	=============================================*/
	static public function mdlSubirFleteros($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id, cuitfle, nombre, usuario, sucadm, password, estado, perfil, foto, fecha_alta, ultimo_login) VALUES (:id, :cuitfle, :nombre, :usuario, :sucadm, :password, :estado, :perfil, :foto, :fecha_alta, :ultimo_login)"); 

		$stmt->bindParam(":id", $datos[0], PDO::PARAM_STR);
		$stmt->bindParam(":cuitfle", $datos[1], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos[2], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos[3], PDO::PARAM_STR);
		$stmt->bindParam(":sucadm", $datos[4], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos[5], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos[6], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos[7], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos[8], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_alta", $datos[9], PDO::PARAM_STR);
		$stmt->bindParam(":ultimo_login", $datos[10], PDO::PARAM_STR);

		//var_dump($stmt);
		if($stmt->execute()){

			return "ok";

			$stmt -> close();

			$stmt = null;

		}else{

			return "error";

			$stmt -> close();

			$stmt = null;
		}

	}

	/*=============================================
	MOSTRAR REGISTRO DE UNA TABLA
	=============================================*/

	static public function mdlMostrarRegistro($tabla, $item, $valor, $item1, $valor1, $item2, $valor2){
		//var_dump($valor);
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1 = :$item1 AND $item2 = :$item2");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR REGISTRO DE UNA TABLA CABECERA
	=============================================*/

	static public function mdlMostrarRegistroH($tabla, $item, $valor, $item1, $valor1){
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
	BUSCA CARS YA SUBIDOS PARA ACTUALIZALOS
	=============================================*/

	static public function mdlBuscarCarsArch($tabla, $item1, $valor1, $item2, $valor2, $item3, $valor3){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2 AND $item3 = :$item3");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item3, $valor3, PDO::PARAM_STR);

		//var_dump($valor);

		$stmt ->execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

}