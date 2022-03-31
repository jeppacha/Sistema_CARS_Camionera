<?php 

require_once "../controladores/repartos.controlador.php";
require_once "../modelos/repartos.modelo.php";


class AjaxReparto{

	/*=============================================
	=            ENTREGA DE GUIA                  =
	=============================================*/
	
	public $idGuia;

	static public function ajaxEntregaGuia(){

		$item = "id";
		$valor = $this->idGuia;

		$respuesta = ControladorRepartos::ctrMostrarGuia($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
=            ENTREGA DE GUIA                  =
=============================================*/
if(isset($_POST["idGuia"])){

	$entrega = new AjaxReparto();
	$entrega -> idGuia = $_POST["idGuia"];
	$entrega -> ajaxEntregaGuia();

} 



