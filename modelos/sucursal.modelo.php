<?php

require_once "conexion.php";

class ModeloSucursales{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function mdlMostrarSucursales($tabla, $item, $valor){

		if($item != null){
			//var_dump($valor);
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt ->execute();

			return $stmt -> fetch();

			$stmt -> close();

			$stmt = null;

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt ->execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;

		}

	}

}