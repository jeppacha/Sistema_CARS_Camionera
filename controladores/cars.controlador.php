<?php 

class ControladorCars{

	/*=============================================
	CREAR CARS
	=============================================*/
	
	static public function ctrCrearCar(){

		if(isset($_POST["nuevoCodCli"])){

			if(preg_match('/^[0-9]+$/', $_POST["nuevoCodCli"])){
				
				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])){

					if(preg_match('/^[0-9]+$/', $_POST["nuevaGuia"])){

						if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoRemitente"])){

							if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoDestinatario"])){

								$ruta = "";

								if(isset($_FILES["nuevoPdf"]["tmp_name"])){

									//var_dump($_FILES["nuevoPdf"]["tmp_name"]);

									list($ancho, $alto) = getimagesize($_FILES["nuevoPdf"]["tmp_name"]);

									$nuevoAncho = 500;
									$nuevoAlto = 500;

									/*=============================================
									CREAMOS EL DIRECTORIO DODE VAMOS A GUARDAR LA FOTO O LOGO
									=============================================*/

									$directorio = "vistas/img/cars/".$_POST["nuevoCodCli"];

									mkdir($directorio, 0755);

									/*=============================================
									SEGUN EL FORMATO APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
									=============================================*/

									if($_FILES["nuevoPdf"]["type"] == "image/jpeg"){

							   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

							   			$aleatorio = $_POST["nuevaGuia"];

							   			$ruta = "vistas/img/cars/".$_POST["nuevoCodCli"]."/".$aleatorio.".jpg";

							   			$origen = imagecreatefromjpeg($_FILES["nuevoPdf"]["tmp_name"]);

							   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

							   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

							   			imagejpeg($destino, $ruta);

							   		}

									if($_FILES["nuevoPdf"]["type"] == "image/png"){

								   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

								   			$aleatorio = $_POST["nuevaGuia"];

								   			$ruta = "vistas/img/cars/".$_POST["nuevoCodCli"]."/".$aleatorio.".png";

								   			$origen = imagecreatefrompng($_FILES["nuevoPdf"]["tmp_name"]);

								   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

								   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

								   			imagepng($destino, $ruta);
								   			
								   	}

									if($_FILES["nuevoPdf"]["type"] == "application/pdf"){

							   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

							   			$aleatorio = $_POST["nuevaGuia"];

							   			$ruta = "vistas/img/cars/".$_POST["nuevoCodCli"]."/".$aleatorio.".pdf";

							   			$origen = $_FILES["nuevoPdf"]["tmp_name"];

							   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

							   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

							   			imagejpeg($destino, $ruta);

							   		}

							   		
							   	   	$tabla = "tb_cars";
							   	   	// //$fecha1 = $_POST["nuevaFechaGuia"];
							   	   	// $date1 = DateTime::createFromFormat('m/d/Y', $_POST["nuevaFechaGuia"]);
							   	   	// //$fecha2 = $_POST["nuevaFechaEntrega"];
							   	   	// $date2 = DateTime::createFromFormat('m/d/Y', $_POST["nuevaFechaEntrega"]);
							   	   	// $recibefecha = $date1->format('Y-m-d');
							   	   	// $entregafecha = $date2->format('Y-m-d');
							   	   	//$recibe = date("yy/mm/dd", strtotime($_POST["nuevaFechaGuia"]));
							   		//$entrega = date("yy/mm/dd", strtotime($_POST["nuevaFechaEntrega"]));

							   		$datos = array("codcli" => $_POST["nuevoCodCli"],
												   "nombre" => $_POST["nuevoNombre"],
												   "nguia" => $_POST["nuevaGuia"],
												   "org" => $_POST["nuevoOrg"],
												   "dst" => $_POST["nuevoDst"],
												   "nomrem" => $_POST["nuevoRemitente"],
				   		    			   		   "nomdes" => $_POST["nuevoDestinatario"],
							    			   	   "frecib" => $_POST["nuevaFechaGuia"],
								    			   "fdeliv" => $_POST["nuevaFechaEntrega"],
							    				   "pdf" => $ruta,);
									var_dump($datos);
									$respuesta = ModeloCars::mdlIngresarCars($tabla, $datos);

									if($respuesta == "ok"){
										echo '<script>

											swal({
												type: "success",
												title: "¡El CARS ha sido guardado correctamente",
												showConfirmButton: true,
												confirmButtonText: "Cerrar",
												closeOnConfirm: false,
												}).then((result) => {
													if(result.value){
														window.location = "alta-cars";
													}
											})
											</script> ';
									}

								}else{

									echo '<script>

										swal({
											type: "error",
											title: "¡El archivo PDF no puede ir vacio!",
											showConfirmButton: true,
											confirmButtonText: "Cerrar",
											closeOnConfirm: false
											}).then((result) => {
												if(result.value){
													window.location = "alta-cars";
												}
											})
										</script> ';

								}

							}else{

								echo '<script>

									swal({
										type: "error",
										title: "¡El Destinatario no puede ir vacio o llevar caracteres especiales!",
										showConfirmButton: true,
										confirmButtonText: "Cerrar",
										closeOnConfirm: false
										}).then((result) => {
											if(result.value){
												window.location = "alta-cars";
											}
										})
									 </script> '; 

							}

						}else{

							echo '<script>

								swal({
									type: "error",
									title: "¡El Remitente no puede ir vacio o llevar caracteres especiales!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
									}).then((result) => {
										if(result.value){
											window.location = "alta-cars";
										}
									})
								 </script> '; 

						}

					}else{

						echo '<script>

							swal({
								type: "error",
								title: "¡El Nro de Guia no puede ir vacio o llevar caracteres especiales!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
								}).then((result) => {
									if(result.value){
										window.location = "alta-cars";
									}
								})
							 </script> ';
					
					}

				}else{

					echo '<script>

						swal({
							type: "error",
							title: "¡El Nombre del Cliente no puede ir vacio o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
							}).then((result) => {
								if(result.value){
									window.location = "alta-cars";
								}
							})
						 </script> ';
				
				}

			}else{

				echo '<script>

					swal({
						type: "error",
						title: "¡El Codigo del Cliente no puede ir vacio o distinto de Números!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result) => {
							if(result.value){
								window.location = "alta-cars";
							}
						})
					 </script> ';
			
			}

		}
	
	}

	/*=============================================
	MOSTRAR CARS
	=============================================*/
	
	static public function ctrMostrarCars($item, $valor, $orden){

		$tabla = "tb_cars";

		$respuesta = ModeloCars::mdlMostrarCars($tabla, $item, $valor, $orden);
		//var_dump($respuesta);
		return $respuesta;

	}

	/*=============================================
	RANGO CARS
	=============================================*/
	
	static public function ctrRangoCars($item, $valor, $orden){

		$tabla = "tb_cars";

		$respuesta = ModeloCars::mdlRangoCars($tabla, $item, $valor, $orden);
		//var_dump($respuesta);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR CARS
	=============================================*/
	
	static public function ctrBuscarCarsRep($item1, $valor1, $item2, $valor2){

		$tabla = "tb_cars";

		$respuesta = ModeloCars::mdlBuscarCarsRep($tabla, $item1, $valor1, $item2, $valor2);
		//var_dump($respuesta);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR CARS EN CARS-CLIENTES
	=============================================*/
	
	static public function ctrMostrarCarsCl($item, $valor, $orden){

		$tabla = "tb_cars";

		$respuesta = ModeloCars::mdlMostrarCarsCl($tabla, $item, $valor, $orden);
		//var_dump($respuesta);
		return $respuesta;

	}

	/*=============================================
	EDITAR CARS
	=============================================*/

	static public function ctrEditarCar(){

		if(isset($_POST["editarGuia"])){
			var_dump($_POST["editarNombre"]);
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .-]+$/', $_POST["editarNombre"])){

				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .-]+$/', $_POST["editarRemitente"])){

					if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .-]+$/', $_POST["editarDestinatario"])){

						$ruta = $_POST["pdfActual"];
						$origen = $_POST["actualOrg"];
						$destino = $_POST["actualDst"];

						if(isset($_FILES["editarPdf"]["tmp_name"]) && !empty($_FILES["editarPdf"]["tmp_name"])){

							//var_dump($_FILES["editarPdf"]["tmp_name"]);

							list($ancho, $alto) = getimagesize($_FILES["editarPdf"]["tmp_name"]);

							$nuevoAncho = 500;
							$nuevoAlto = 500;

							/*=============================================
							CREAMOS EL DIRECTORIO DODE VAMOS A GUARDAR LA FOTO O LOGO
							=============================================*/

							$directorio = "vistas/img/cars/".$_POST["editarCodCli"];

							/*=============================================
							PRIMERO PREGUNTAMOS SI EXISTE LA FOTO EN LA BD
							=============================================*/

							if(!empty($_POST["pdfActual"])){

								unlink($_POST["pdfActual"]);
							
							}else{

								mkdir($directorio, 0755);

							}

							/*=============================================
							SEGUN EL FORMATO APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
							=============================================*/

							if($_FILES["editarPdf"]["type"] == "image/jpeg"){

					   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

					   			$aleatorio = mt_rand(100, 999);

					   			$ruta = "vistas/img/cars/".$_POST["editarCodCli"]."/".$aleatorio.".jpg";

					   			$origen = imagecreatefromjpeg($_FILES["editarPdf"]["tmp_name"]);

					   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					   			imagejpeg($destino, $ruta);

					   		}

							if($_FILES["editarPdf"]["type"] == "image/png"){

					   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

					   			$aleatorio = mt_rand(100, 999);

					   			$ruta = "vistas/img/cars/".$_POST["editarCodCli"]."/".$aleatorio.".png";

					   			$origen = imagecreatefrompng($_FILES["editarPdf"]["tmp_name"]);

					   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					   			imagepng($destino, $ruta);
						   			
						   	}

							if($_FILES["editarPdf"]["type"] == "applications/pdf"){

					   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

					   			$aleatorio = $_POST["nuevaGuia"];

					   			$ruta = "vistas/img/cars/".$_POST["editarCodCli"]."/".$aleatorio.".pdf";

					   			$origen = imagecreatefromjpeg($_FILES["editarPdf"]["tmp_name"]);

					   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					   			imagejpeg($destino, $ruta);

					   		}

					   	}

				   	   	$tabla = "tb_cars";

				   		$datos = array("codcli" => $_POST["editarCodCli"],
									   "nombre" => $_POST["editarNombre"],
									   "nguia" => $_POST["editarGuia"],
									   "org" => $origen,
									   "dst" => $destino,
									   "nomrem" => $_POST["editarRemitente"],
	   		    			   		   "nomdes" => $_POST["editarDestinatario"],
				    			   	   "frecib" => $_POST["editarFechaGuia"],
					    			   "fdeliv" => $_POST["editarFechaEntrega"],
				    				   "pdf" => $ruta,);
						//var_dump($datos["pdf"]);
						$respuesta = ModeloCars::mdlEditarCar($tabla, $datos);

						if($respuesta == "ok"){
							echo '<script>

								swal({
									type: "success",
									title: "¡El CARS ha sido Actualizado correctamente",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false,
									}).then((result) => {
										if(result.value){
											window.location = "alta-cars";
										}
								})
								</script> ';
						}

					}else{

						echo '<script>

							swal({
								type: "error",
								title: "¡El Destinatario no puede ir vacio o llevar caracteres especiales!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
								}).then((result) => {
									if(result.value){
										window.location = "alta-cars";
									}
								})
							</script> '; 

					}

				}else{

					echo '<script>

						swal({
							type: "error",
							title: "¡El Remitente no puede ir vacio o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
							}).then((result) => {
								if(result.value){
									window.location = "alta-cars";
								}
							})
						</script> '; 

				}

			}else{

				echo '<script>

					swal({
						type: "error",
						title: "¡El Nombre del Cliente no puede ir vacio o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result) => {
							if(result.value){
								window.location = "alta-cars";
							}
						})
					</script> ';
			}

		}

	}

	/*=============================================
	BORRAR CARS
	=============================================*/

	static public function ctrBorrarCar(){
 
		if(isset($_GET["idCar"])){

			$tabla = "tb_cars";
			$datos = $_GET["idCar"];

			if($_GET["pdf"] != ""){

				unlink($_GET["fotoPdf"]);
				rmdir('vistas/img/cars/'.$_GET["codcli"]);

			}

			$respuesta = ModeloCars::mdlBorrarCar($tabla, $datos);

			if($respuesta == "ok"){

				echo '<script>

					swal({
					 	type: "success",
					 	title: "¡El CAR ha sido Borrado correctamenta!",
					 	showConfirmButton: true,
					 	confirmButtonText: "Cerrar",
					 	closeOnConfirm: false

					 	}).then((result)=>{

							if(result.value){
							
								window.location = "alta-cars";
							
							}
						
						})

				</script>'; 

			} 
		
		}

	}

	/*=============================================
	BORRAR CARS
	=============================================*/

	static public function ctrBorrarCarUs(){

		if(isset($_GET["codcli"])){

			$tablacar = "tb_cars";
			$datoscar = $_GET["codcli"];

			$files = glob('vistas/img/cars/'.$_GET["codcli"].'/*'); //obtenemos todos los nombres de los ficheros
			foreach($files as $file){
			    if(is_file($file))
			    unlink($file); //elimino el fichero
			}

			rmdir('vistas/img/cars/'.$_GET["codcli"]);

			$respuesta = ModeloCars::mdlBorrarCarsUs($tablacar, $datoscar);
			//var_dump($respuesta);
			if($respuesta == "ok"){

				echo '<script>

						swal({
						 	type: "success",
						 	title: "¡Los CARS del Cliente han sido Borrados correctamente!",
						 	showConfirmButton: true,
						 	confirmButtonText: "Cerrar",
						 	closeOnConfirm: false

						 	}).then((result)=>{

								if(result.value){
								
									window.location = "index.php?ruta=usuarios&perfil="+perfil+"&codcli="+codcli;
								
								}
							
							})

					</script>';

			}

		}

	}

	/*=============================================
	SUMA CANTIDAD DE CARS
	=============================================*/

	static public function ctrSumaTotalCars(){

		$tabla = "tb_cars";

		$respuesta = ModeloCars::mdlSumaTotalCars($tabla);

		return $respuesta;

	}

	/*=============================================
	SUMA CANTIDAD DE CARS
	=============================================*/

	static public function ctrSumaCarsCli($item, $valor){

		$tabla = "tb_cars";

		$respuesta = ModeloCars::mdlSumaCarsCli($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	RANGO DE FECHAS
	=============================================*/
	
	static public function ctrRangoFechasCars($fechaInicial, $fechaFinal,$sucursal,$codcli){

		$tabla = "tb_cars";

		$respuesta = ModeloCars::mdlRangoFechasCars($tabla, $fechaInicial, $fechaFinal,$sucursal,$codcli);

		return $respuesta;

	}

	/*=============================================
	NORMALIZA FECHAS
	=============================================*/

	static public function normaliza_fecha($date){

		if(!empty($date)){
			$var = explode('/',str_replace('/','-',$date));
			return "$var[2]-$var[1]-$var[0]";
		}

	}

	/*=============================================
 	DESCARGA EN EXCEL 
	=============================================*/
	static public function ctrDescargarReporte(){
		 
		if(isset($_GET["reporte"])){

			$tabla = "tb_cars";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$cars = ModeloCars::mdlRangoFechasCars($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;
				$orden = "nombre";

				$cars = ModeloCars::mdlMostrarCars($tabla, $item, $valor, $orden);

			}


			/*=============================================
			CREAMOS EL ARCHIVO EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			// header('Expires : 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel");
			header("Cache-Control: cache, must-revalidate");
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public");
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 

				<tr>
				<td style='font-weight:bold; border:1px solid #eee;'>Cod CLIENTE</td>
				<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE/RAZ SOC</td>
				<td style='font-weight:bold; border:1px solid #eee;'>SUC ADMIN</td>
				<td style='font-weight:bold; border:1px solid #eee;'>GUIA NRO</td>
				<td style='font-weight:bold; border:1px solid #eee;'>ORIGEN</td>
				<td style='font-weight:bold; border:1px solid #eee;'>DESTINO</td>
				<td style='font-weight:bold; border:1px solid #eee;'>REMITENTE</td>
				<td style='font-weight:bold; border:1px solid #eee;'>DESTINATARIO</td>
				<td style='font-weight:bold; border:1px solid #eee;'>RECIBIDA</td>
				<td style='font-weight:bold; border:1px solid #eee;'>ENTREGADA</td>
				</tr>");

				foreach ($cars as $row => $item) {  

					$sucadm = ModeloSucursales::mdlMostrarSucursales("sucursales", "id", $item["id_sucadm"]);
					$org = ModeloSucursales::mdlMostrarSucursales("sucursales", "id", $item["org"]);
					$dst = ModeloSucursales::mdlMostrarSucursales("sucursales", "id", $item["dst"]);
					
					echo utf8_decode(

						"<tr>
							<td style='border:1px solid #eee;'>".$item["codcli"]."</td>
							<td style='border:1px solid #eee;'>".$item["nombre"]."</td>
							<td style='border:1px solid #eee;'>".$sucadm["denom"]."</td>
							<td style='border:1px solid #eee;'>".$item["nguia"]."</td>
							<td style='border:1px solid #eee;'>".$org["denom"]."</td>
							<td style='border:1px solid #eee;'>".$dst["denom"]."</td>
							<td style='border:1px solid #eee;'>".$item["nomrem"]."</td>
							<td style='border:1px solid #eee;'>".$item["nomdes"]."</td>
							<td style='border:1px solid #eee;'>".$item["frecib"]."</td>
							<td style='border:1px solid #eee;'>".$item["fdeliv"]."</td>

						</tr>");
				}

			echo "</table>";	

		}

	}

	/*=============================================
 	DESCARGA EN EXCEL DE UN CLIENTE 
	=============================================*/
	static public function ctrDescargarCarsCli(){
		 
		if(isset($_GET["reporte"])){

			$tabla = "tb_cars";

			$item = "codcli";
			$valor = $_GET["codcli"];
			
			$carsCli = ModeloCars::mdlMostrarCarsCl($tabla, $item, $valor);

			/*=============================================
			CREAMOS EL ARCHIVO EXCEL
			=============================================*/
			
			$Name = "cars-".$_GET["cliente"].'.xls';

			// header('Expires : 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel");
			header("Cache-Control: cache, must-revalidate");
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public");
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'>

				<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>Remitos Conformados del CLIENTE:</td>
				</tr>

				<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>".$_GET["codcli"]."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$_GET["nombre"]."</td>
				</tr>

				<tr>
					
				</tr> 

				<tr>
				
				<td style='font-weight:bold; border:1px solid #eee;'>GUIA NRO</td>
				<td style='font-weight:bold; border:1px solid #eee;'>ORIGEN</td>
				<td style='font-weight:bold; border:1px solid #eee;'>DESTINO</td>
				<td style='font-weight:bold; border:1px solid #eee;'>REMITENTE</td>
				<td style='font-weight:bold; border:1px solid #eee;'>DESTINATARIO</td>
				<td style='font-weight:bold; border:1px solid #eee;'>RECIBIDA</td>
				<td style='font-weight:bold; border:1px solid #eee;'>ENTREGADA</td>
				</tr>");

				foreach ($carsCli as $row => $item) {  

					$sucadm = ModeloSucursales::mdlMostrarSucursales("sucursales", "id", $item["id_sucadm"]);
					$org = ModeloSucursales::mdlMostrarSucursales("sucursales", "id", $item["org"]);
					$dst = ModeloSucursales::mdlMostrarSucursales("sucursales", "id", $item["dst"]);
					
					echo utf8_decode(

						"<tr>
							
							<td style='border:1px solid #eee;'>".$item["nguia"]."</td>
							<td style='border:1px solid #eee;'>".$org["denom"]."</td>
							<td style='border:1px solid #eee;'>".$dst["denom"]."</td>
							<td style='border:1px solid #eee;'>".$item["nomrem"]."</td>
							<td style='border:1px solid #eee;'>".$item["nomdes"]."</td>
							<td style='border:1px solid #eee;'>".$item["frecib"]."</td>
							<td style='border:1px solid #eee;'>".$item["fdeliv"]."</td>

						</tr>");
				}

			echo "</table>";	

		}

	}

}
