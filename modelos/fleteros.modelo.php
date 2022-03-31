<?php

require_once "conexion.php";

class ModeloFleteros{

	/*=============================================
	MOSTRAR FLETEROS
	=============================================*/

	static public function mdlMostrarFleteros($tabla, $item, $valor){
		//var_dump($valor);
		if($item != null){
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

			$stmt -> close();

			$stmt = null;

		
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY nombre");

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;

		}

	}

	/*=============================================
	=            ACTUALIZAR FLETERO                 =
	=============================================*/

	static public function mdlActualizarFletero($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

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
	CREAR FLETERO
	=============================================*/
	
	static public function mdlIngresarFletero($tabla, $datos){
		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (cuitfle, nombre, usuario, sucadm, password, estado, perfil, foto) VALUES (:cuitfle, :nombre, :usuario, :sucadm, :password, :estado, :perfil, :foto)");

		$stmt->bindParam(":cuitfle", $datos["cuitfle"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":sucadm", $datos["sucadm"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	CREAR FLETERO DESDE ARCHIVO
	=============================================*/
	
	static public function mdlIngresarFleteros($tabla, $datos){
		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (cuitfle, nombre, usuario, sucadm, password, estado, perfil, foto) VALUES (:cuitfle, :nombre, :usuario, :sucadm, :password, :estado, :perfil, :foto)");

		$stmt->bindParam(":cuitfle", $datos[1], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos[2], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos[3], PDO::PARAM_STR);
		$stmt->bindParam(":sucadm", $datos[4], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos[5], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos[6], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos[7], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos[8], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;
	}
	/*=============================================
	EDITAR FLETEROS
	=============================================*/

	static public function mdlEditarFletero($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, usuario = :usuario, sucadm = :sucadm, password = :password, perfil = :perfil, foto = :foto WHERE cuitfle = :cuitfle");  

		$stmt->bindParam(":cuitfle", $datos["cuitfle"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":sucadm", $datos["sucadm"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	BORRAR FLETERO
	=============================================*/
	
	static public function mdlBorrarFletero($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

		/*=============================================
	BORRAR FLETERO
	=============================================*/
	
	static public function mdlBorrarFleteros($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE cuitfle = :cuitfle");

		$stmt->bindParam(":cuitfle", $datos, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

}

	


