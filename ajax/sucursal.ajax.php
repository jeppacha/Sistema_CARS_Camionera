<?php

require_once "../controladores/sucursal.controlador.php";
require_once "../modelos/sucursal.modelo.php";

class AjaxSucursal{

	/*=============================================
	=            EDITAR CAR                  =
	=============================================*/

	public $oficina;

	public function ajaxEditarSucursal(){

		$item = "id";
		$valor = $this->oficina;

		$respuesta = ControladorSucursal::ctrMostrarSucursales($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	=            BUSCAR SUCURSAL ORG EN ALTA CAR      =
	=============================================*/

	public $sucOrg;

	public function ajaxBuscarOrgSucursal(){

		$item = "id";
		$valor = $this->sucOrg;

		$respuestaOrg = ControladorSucursal::ctrMostrarSucursales($item, $valor);

		echo json_encode($respuestaOrg);

	}

	/*=============================================
	=            BUSCAR SUCURSAL DST EN ALTA CAR      =
	=============================================*/

	public $sucDst;

	public function ajaxBuscarDstSucursal(){

		$item = "id";
		$valor = $this->sucDst;

		$respuestaDst = ControladorSucursal::ctrMostrarSucursales($item, $valor);

		echo json_encode($respuestaDst);

	}

}

/*=============================================
=            EDITAR CAR                  =
=============================================*/

if(isset($_POST["oficina"])){

	$editar = new AjaxSucursal();
	$editar -> oficina = $_POST["oficina"];
	$editar -> ajaxEditarSucursal();

}

/*=============================================
=            Buscar Origen en CAR                  =
=============================================*/

if(isset($_POST["origen"])){

	$editar = new AjaxSucursal();
	$editar -> sucOrg = $_POST["origen"];
	$editar -> ajaxBuscarOrgSucursal();

}

/*=============================================
=            Buscar Destino en CAR                  =
=============================================*/

if(isset($_POST["destino"])){

	$editar = new AjaxSucursal();
	$editar -> sucDst = $_POST["destino"];
	$editar -> ajaxBuscarDstSucursal();

}