<?php 

require_once "../../controladores/cars.controlador.php";
require_once "../../modelos/cars.modelo.php";
require_once "../../controladores/sucursal.controlador.php";
require_once "../../modelos/sucursal.modelo.php";

$reporte = new ControladorCars;
$reporte -> ctrDescargarReporte();


