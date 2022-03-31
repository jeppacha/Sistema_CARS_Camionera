<?php

require_once "conexion.php";

class ModeloClientes{

	/*=============================================
	CREAR CLIENTE DESDE CLIENTES
	=============================================*/
	
	static public function mdlIngresarCliente($tabla, $datos){

		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (codcli, sucadm, nombre, password, email1, email2, email3, cuit, usuario, foto) VALUES (:codcli, :sucadm, :nombre, :password, :email1, :email2, :email3, :cuit, :usuario, :foto)");

		$stmt->bindParam(":codcli", $datos["codcli"], PDO::PARAM_STR);
		$stmt->bindParam(":sucadm", $datos["sucadm"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":email1", $datos["email1"], PDO::PARAM_STR);
		$stmt->bindParam(":email2", $datos["email2"], PDO::PARAM_STR);
		$stmt->bindParam(":email3", $datos["email3"], PDO::PARAM_STR);
		$stmt->bindParam(":cuit", $datos["cuit"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		//$stmt->bindParam(":ultimo_login", $datos["ultimo_login"], PDO::PARAM_STR);
		//$stmt->bindParam(":fecha_alta", $datos["fecha_alta"], PDO::PARAM_STR);
		//$stmt->bindParam(":totalcars", $datos["totalcars"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
					MOSTRAR CLIENTE
	=============================================*/

	static public function mdlMostrarClientes($tabla,$item,$valor){

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
	EDITAR CLIENTE DESDE CLIENTES
	=============================================*/
	
	static public function mdlEditarCliente($tabla, $datos){

		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET sucadm = :sucadm, nombre = :nombre, password = :password, email1 = :email1, email2 = :email2, email3 = :email3, cuit = :cuit, usuario = :usuario, foto = :foto WHERE codcli = :codcli");

		
		$stmt->bindParam(":codcli", $datos["codcli"], PDO::PARAM_INT);
		$stmt->bindParam(":sucadm", $datos["sucadm"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":email1", $datos["email1"], PDO::PARAM_STR);
		$stmt->bindParam(":email2", $datos["email2"], PDO::PARAM_STR);
		$stmt->bindParam(":email3", $datos["email3"], PDO::PARAM_STR);
		$stmt->bindParam(":cuit", $datos["cuit"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
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
	EDITAR CLIENTE DESDE USUARIOS
	=============================================*/
	
	static public function mdlEditarClienteUser($tabla, $datos){

		//var_dump($datos);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, email = :email, cuit = :cuit, usuario = :usuario, foto = :foto WHERE codcli = : codcli");

		$stmt->bindParam(":codcli", $datos["codcli"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":cuit", $datos["cuit"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
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
	BORRAR CLIENTES DESDE USUARIOS
	=============================================*/

	static public function mdlBorrarCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE codcli = :codcli");

		$stmt->bindParam(":codcli", $datos, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	SUMA CANTIDAD DE CLIENTES
	=============================================*/

	static public function mdlSumaClientes($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(codcli) AS totcli FROM $tabla");	
		
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;	
	}

	/*=============================================
	= ACTUALIZA CANTIDAD DE CARS DEL CLIENTE      =
	=============================================*/
	
	static public function mdlActualizaCarCliente($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE codcli = :codcli");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":codcli", $valor, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR TOTAL DE CARS DEL CLIENTE
	=============================================*/

	static public function mdlMostrarTotClientes($tabla, $item, $valor, $orden){
			
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	=            ACTUALIZAR CLIENTE                 =
	=============================================*/

	static public function mdlActualizarCliente($tabla, $item1, $valor1, $item2, $valor2){

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
	REVISA SI EL CLIENTE TIENE CAR
	=============================================*/

	static public function mdlCarCliente($tabla, $itemcli, $valorcli){
		//var_dump($itemcli);
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $itemcli :$itemcli");	
		
		$stmt->bindParam(":".$itemcli, $valorcli, PDO::PARAM_STR);

		return $stmt -> fetch();

		// if($stmt->execute()){

		// 	return "ok";

		// }else{

		// 	return "error";

		// }

		$stmt -> close();

		$stmt = null;

	}

}