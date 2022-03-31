<?php

require_once "../controladores/fleteros.controlador.php";
require_once "../modelos/fleteros.modelo.php";

class AjaxFleteros{

	/*=============================================
	=            EDITAR FLETEROS                 =
	=============================================*/

	public $idFletero;

	public function ajaxEditarFletero(){

		$item = "id";
		$valor = $this->idFletero;
		
		$respuesta = ControladorFleteros::ctrMostrarFletero($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	=            ACTIVAR FLETEROS                 =
	=============================================*/

	public $activarFletero;
	public $activarId;

	public function ajaxActivarFletero(){

		$tabla = "fleteros";

		$item1 = "estado";
		$valor1 = $this->activarFletero;

		$item2 ="id";
		$valor2 =  $this->activarId;

		$respuesrta = ModeloFleteros::mdlActualizarFletero($tabla, $item1, $valor1, $item2, $valor2);
	
	}

	/*=============================================
	=      VALIDAR NO REPETIR USUARIO FLETERO            =
	=============================================*/

	public $validarFletero;

	public function ajaxValidarFletero(){

		$item = "usuario";
		$valor = $this->validarFletero;
		$orden = "id";

		$respuesta = ControladorFleteros::ctrMostrarFletero($item, $valor, $orden);

		echo json_encode($respuesta);

	}	

}

/*=============================================
=            EDITAR FLETERO                  =
=============================================*/

if(isset($_POST["idFletero"])){

	$editar = new AjaxFleteros();
	$editar -> idFletero = $_POST["idFletero"];
	$editar -> ajaxEditarFletero();

}

/*=============================================
=            ACTIVAR FleteroS                 =
=============================================*/

if(isset($_POST["activarFletero"])){

	$activarFletero = new AjaxFleteros();
	$activarFletero -> activarFletero = $_POST["activarFletero"];
	$activarFletero -> activarId = $_POST["activarId"];
	$activarFletero -> ajaxActivarFletero();

}

/*=============================================
=      VALIDAR NO REPETIR Fletero             =
=============================================*/

if(isset($_POST["validarFletero"])){

	$valFletero = new AjaxFleteros();
	$valFletero -> validarFletero = $_POST["validarFletero"];
	$valFletero -> ajaxValidarFletero();

}