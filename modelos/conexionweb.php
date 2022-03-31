<?php

class Conexion{

	public function conectar(){

		$link = new PDO("mysql:host=sql109.epizy.com;dbname=epiz_26823608_cars","epiz_26823608","tI5btsFUmwHitF");

		$link->exec("set names utf-8");

		return $link;

	}

}