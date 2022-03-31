<?php

require_once "../controladores/cars.controlador.php";
require_once "../modelos/cars.modelo.php";

class AjaxCars{

	/*=============================================
	=            EDITAR CAR                  =
	=============================================*/

	public $idCar;

	public function ajaxEditarCar(){

		$item = "id";
		$valor = $this->idCar;
		$orden = "id";

		$respuesta = ControladorCars::ctrMostrarCars($item, $valor, $orden);

		echo json_encode($respuesta);

	}

	/*=============================================
	=           BUSCAR CAR                  =
	=============================================*/

	public $nguiacar;
	public $repnrocar;

	public function ajaxBuscarCar(){

		$item1 = "nguia";
		$valor1 = $this->nguiacar;
		
		$item2 = "reparto";
		$valor2 = $this->repnrocar;

		$respuesta = ControladorCars::ctrBuscarCarsRep($item1, $valor1, $item2, $valor2);

		echo json_encode($respuesta);

	}

}

/*=============================================
=            EDITAR CAR                  =
=============================================*/

if(isset($_POST["idCar"])){

	$editar = new AjaxCars();
	$editar -> idCar = $_POST["idCar"];
	$editar -> ajaxEditarCar();

}

/*=============================================
=            BUSCAR  CAR                      =
=============================================*/

if(isset($_POST["nguiacar"])){

	$editar = new AjaxCars();
	$editar -> nguiacar = $_POST["nguiacar"];
	$editar -> repnrocar = $_POST["repnrocar"];
	$editar -> ajaxBuscarCar();

}