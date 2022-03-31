<?php

class ControladorSucursal{

	/*=============================================
	MOSTRAR SUCURSALES
	=============================================*/

	static public function ctrMostrarSucursales($item, $valor){

		$tabla = "sucursales";

		$respuesta = ModeloSucursales::mdlMostrarSucursales($tabla, $item, $valor);
		//var_dump($respuesta);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR UNA SUCURSAL
	=============================================*/

	static public function ctrMostrarSucursal(){

		$item = "id";
		$valor = $_POST["editarSucursal"];

		$tabla = "sucursales";

		$respuesta = ModeloSucursales::mdlMostrarSucursales($tabla, $item, $valor);

		return $respuesta;

	}

}



                    