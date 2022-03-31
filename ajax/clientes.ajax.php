<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

class AjaxClientes{

	/*=============================================
	=            EDITAR CLIENTES                  =
	=============================================*/

	public $idCliente;

	public function ajaxEditarCliente(){

		$item = "id";
		$valor = $this->idCliente;
		
		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	BUSCA CLIENTE PARA SER ELIMINADO DESDE USUARIOS
	=============================================*/

	public $userCodcli;

	public function ajaxBuscaCliente(){

		$item = "codcli";
		$valor = $this->userCodcli;
		$orden = "codcli";

		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor, $orden);

		echo json_encode($respuesta);

	}

	/*=============================================
	=      VALIDAR CLIENTE                        =
	=============================================*/

	public $validarCliente;

	public function ajaxValidarCliente(){

		$item = "codcli";
		$valor = $this->validarCliente;

		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

		echo json_encode($respuesta);

	}	

	
}

/*=============================================
=            EDITAR CLIENTE              =
=============================================*/

if(isset($_POST["idCliente"])){

	$cliente = new AjaxClientes();
	$cliente -> idCliente = $_POST["idCliente"];
	$cliente -> ajaxEditarCliente();

}

/*=============================================
BUSCA CLIENTE PARA SER ELIMINADO DESDE USUARIOS
=============================================*/

if(isset($_POST["userCodcli"])){

	$cliente = new AjaxClientes();
	$cliente -> userCodcli = $_POST["userCodcli"];
	$cliente -> ajaxBuscaCliente();

}

/*=============================================
=      VALIDAR CLIENTE                        =
=============================================*/

if(isset($_POST["validarCliente"])){

	$valUsuario = new AjaxClientes();
	$valUsuario -> validarCliente = $_POST["validarCliente"];
	$valUsuario -> ajaxValidarCliente();

}