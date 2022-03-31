<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=cars","root","");

		$link->exec("set names utf-8");

		return $link;

	}

}
