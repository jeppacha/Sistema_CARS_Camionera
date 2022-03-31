<?php 

require_once "../controladores/repartos.controlador.php";
require_once "../modelos/repartos.modelo.php";


class AjaxGuias{

	/*=============================================
	=            ENTREGA DE GUIA CON CAR          =
	=============================================*/
	
	public $nguia;
	public $repnro;

	public function ajaxEntregaGuia(){

		$item = "nguia";
		$valor = $this->nguia;

		$item1 = "repnro";
		$valor1 = $this->repnro;

		$respuesta = ControladorRepartos::ctrMostrarGuia($item, $valor, $item1, $valor1);

		echo json_encode($respuesta);

	}

	/*=============================================
	=            ENTREGA DE GUIA SIN CAR          =
	=============================================*/
	
	public $nguiasc;
	public $repnrosc;

	public function ajaxEntregaGuiasc(){

		$item = "nguia";
		$valor = $this->nguiasc;

		$item1 = "repnro";
		$valor1 = $this->repnrosc;

		$respuesta = ControladorRepartos::ctrMostrarGuia($item, $valor, $item1, $valor1);

		echo json_encode($respuesta);

	}

	/*=============================================
	=            MOTIVO DE NO ENTREGA DE GUIA     =
	=============================================*/
	
	public $motinguia;
	public $motirepnro;

	public function ajaxMotivoNoEntrega(){

		$item = "nguia";
		$valor = $this->motinguia;

		$item1 = "repnro";
		$valor1 = $this->motirepnro;

		$respuesta = ControladorRepartos::ctrMostrarGuia($item, $valor, $item1, $valor1);

		echo json_encode($respuesta);

	}

	/*=============================================
	=      VALIDAR GUIA                           =
	=============================================*/

	public $validarGuia;

	public function ajaxValidarGuia(){

		$item = "nguia";
		$valor = $this->validarGuia;
		$orden = "id";

		$respuesta = ControladorCars::ctrMostrarCars($item, $valor, $orden);
		
		echo json_encode($respuesta);

	}

}

/*=============================================
=            ENTREGA DE GUIA CON CAR          =
=============================================*/
if(isset($_POST["nguia"])){

	$entrega = new AjaxGuias();
	$entrega -> nguia = $_POST["nguia"];
	$entrega -> repnro = $_POST["repnro"];
	$entrega -> ajaxEntregaGuia();

}

/*=============================================
=            ENTREGA DE GUIA SIN CAR          =
=============================================*/
if(isset($_POST["nguiasc"])){

	$entrega = new AjaxGuias();
	$entrega -> nguiasc = $_POST["nguiasc"];
	$entrega -> repnrosc = $_POST["repnrosc"];
	$entrega -> ajaxEntregaGuiasc();

}

/*=============================================
=           MOTIVO NO ENTREGA DE GUIA         =
=============================================*/
if(isset($_POST["motinguia"])){

	$noentrega = new AjaxGuias();
	$noentrega -> motinguia = $_POST["motinguia"];
	$noentrega -> motirepnro = $_POST["motirepnro"];
	$noentrega -> ajaxMotivoNoEntrega();

}

/*=============================================
=      VALIDAR GUIA                           =
=============================================*/

if(isset($_POST["validarGuia"])){

	$valUsuario = new AjaxGuias();
	$valUsuario -> validarGuia = $_POST["validarGuia"];
	$valUsuario -> ajaxValidarGuia();

}
