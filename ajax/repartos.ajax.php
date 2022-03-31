<?php

require_once "../controladores/repartos.controlador.php";
require_once "../modelos/repartos.modelo.php";

class AjaxRepartos{

	/*=============================================
	=            EDITAR REPARTOS                 =
	=============================================*/

	public $repnro;

	static public function ajaxEntregarReparto(){

		$item = "repnro";
		$valor = $this->repnro;
		
		$respuesta = ControladorRepartos::ctrEntregaReparto($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	=            ENTREGAR REPARTOS                 =
	=============================================*/

	public $verepnro;

	static public function ajaxVerReparto(){

		$item = "repnum";
		$valor = $this->verepnro;
		//var_dump($valor);
		$respuesta = ControladorRepartos::ctrVerReparto($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
=            EDITAR REPARTO                  =
=============================================*/

if(isset($_POST["repnro"])){

	$entrega = new AjaxRepartos();
	$entrega -> repnro = $_POST["repnro"];
	$entrega -> ajaxEntregarReparto();

}

/*=============================================
=            ENTREGAR REPARTO                 =
=============================================*/

if(isset($_POST["verepnro"])){
	
	$veentrega = new AjaxRepartos();
	$veentrega -> verepnro = $_POST["verepnro"];
	$veentrega -> ajaxVerReparto();

}