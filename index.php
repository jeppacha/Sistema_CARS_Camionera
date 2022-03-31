<?php

	require_once "controladores/plantilla.controlador.php";
	require_once "controladores/usuarios.controlador.php";
	require_once "controladores/fleteros.controlador.php";
	require_once "controladores/cars.controlador.php";
	require_once "controladores/clientes.controlador.php";
	require_once "controladores/sucursal.controlador.php";
	require_once "controladores/archivo.controlador.php";
	require_once "controladores/repartos.controlador.php";

	require_once "modelos/usuarios.modelo.php";
	require_once "modelos/cars.modelo.php";
	require_once "modelos/clientes.modelo.php";
	require_once "modelos/sucursal.modelo.php";
	require_once "modelos/archivo.modelo.php";
	require_once "modelos/fleteros.modelo.php";
	require_once "modelos/repartos.modelo.php";

	$plantilla = new ControladorPlantilla();
	$plantilla -> ctrPlantilla();