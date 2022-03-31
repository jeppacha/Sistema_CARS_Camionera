<?php

class ControladorClientes{

	/*=============================================
	CREAR CLIENTES
	=============================================*/
	
	static public function ctrCrearCliente(){

		if(isset($_POST["nuevoCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCliente"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevoCodCli"]) &&
			   preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/', $_POST["nuevoEmail"]) &&
			   //preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"]) &&
			   preg_match('/^[-0-9 ]+$/', $_POST["nuevoCuit"])){

			   	$itemCli = "codcli";
              	$valorCli = $_POST["nuevoCodCli"];

              	$verCliente = ControladorClientes::ctrMostrarClientes($itemCli, $valorCli);

              	if($verCliente = "ok"){

              		echo '<script>

					swal({
						type: "error",
						title: "¡El cliente ya existe en la base de datos!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result) => {
							if(result.value){
								window.location = "clientes";
							}
						})
					 </script> '; 
              	}

			   	$ruta = "";

				if(isset($_FILES["nuevaFotoCli"]["tmp_name"])){

					//var_dump($_FILES["nuevaFoto"]["tmp_name"]);

					list($ancho, $alto) = getimagesize($_FILES["nuevaFotoCli"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DODE VAMOS A GUARDAR LA FOTO O LOGO
					=============================================*/

					$directorio = "vistas/img/clientes/".$_POST["nuevoUsuarioCli"];

					if(file_exists($directorio)){

					}else{

						mkdir($directorio, 0755);

					}
					/*=============================================
					SEGUN EL FORMATO APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["nuevaFotoCli"]["type"] == "image/jpeg"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/clientes/".$_POST["nuevoUsuarioCli"]."/".$aleatorio.".jpg";

			   			$origen = imagecreatefromjpeg($_FILES["nuevaFotoCli"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagejpeg($destino, $ruta);

			   		}

			   		if($_FILES["nuevaFotoCli"]["type"] == "image/png"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/clientes/".$_POST["nuevoUsuarioCli"]."/".$aleatorio.".png";

			   			$origen = imagecreatefrompng($_FILES["nuevaFotoCli"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagepng($destino, $ruta);

			   		}

				}

				$tabla = "clientes";

				$encriptar = crypt($_POST["nuevaPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datos = array("codcli" => $_POST["nuevoCodCli"],
							   "sucadm" => $_POST["nuevaSucAdm"],
							   "nombre" => $_POST["nuevoCliente"],
							   "password" => $encriptar,
							   "email1" => $_POST["nuevoEmail1"],
							   "cuit" => $_POST["nuevoCuit"],
							   "usuario" => $_POST["nuevoUsuarioCli"],
							   "foto" => $ruta); 

				$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);
				//var_dump($respuesta);
				if($respuesta == "ok"){
					echo '<script>

						swal({
							type: "success",
							title: "¡El Cliente ha sido guardado correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false,
						}).then((result) => {
							if(result.value){
								window.location = "clientes";
							}
						})
						</script> ';
				}

			}else{

				echo '<script>

					swal({
						type: "error",
						title: "¡El cliente no puede ir vacio o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result) => {
							if(result.value){
								window.location = "clientes";
							}
						})
					 </script> '; 

			}

		}

	}

	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function ctrMostrarClientes($item, $valor){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);

		return $respuesta;
		
	}

	/*=============================================
	MOSTRAR CLIENTES en ALTA DE CARS
	=============================================*/

	static public function ctrMostrarClientesCar(){

		$item = "codcli";
		$valor = $_POST["nuevoCodCli"];
		$orden = "codcli";

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor, $orden);

		if($respuesta == "error"){

			// return $respuesta;
			echo 'swal({
						type: "error",
						title: "¡El cliente no existe, debe cargarlo primero!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result) => {
							if(result.value){
								window.location = "clientes";
							}
						})
					 </script> ';
			return $respuesta;
		}else{
			return $respuesta;
		}
	}

	/*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function ctrEditarCliente(){

		if(isset($_POST["editarCliente"])){

			if(preg_match('/^[-.a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCliente"])){

				if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/', $_POST["editarEmail"])){

					if(preg_match('/^[-0-9 ]+$/', $_POST["editarCuit"])){

					   	$ruta = $_POST["fotoActualCli"];
					   	$passwordActual = $_POST["passwordActualCli"];

					   	if(isset($_FILES["editarFotoCli"]["tmp_name"]) && !empty($_FILES["editarFotoCli"]["tmp_name"])){

					   		list($ancho, $alto) = getimagesize($_FILES["editarFotoCli"]["tmp_name"]);

					   		$nuevoAncho = 500;
					   		$nuevoAlto = 500;

					   		// CREAMOS EL DIRECTORIO PARA GUARDAR LA FOTO DEL USUARIO

					   		$directorio = "vistas/img/clientes/".$_POST["editarUsuario"];

					   		// PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD

					   		if(!empty($_POST["fotoActualCli"])){

					   			unlink($_POST["fotoActualCli"]);
					   		
					   		}else{

					   			mkdir($directorio, 0755);			   			
					   		}

					   		// DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR  DEFECTO DE PHP

					   		if($_FILES["editarFotoCli"]["type"] == "image/jpeg"){

					   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

					   			$aleatorio = mt_rand(100, 999);

				 	   			$ruta = "vistas/img/clientes/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

					   			$origen = imagecreatefromjpeg($_FILES["editarFotoCli"]["tmp_name"]);

					   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					   			imagejpeg($destino, $ruta);

					   		}

							if($_FILES["editarFotoCli"]["type"] == "image/png"){

					   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

					   			$aleatorio = mt_rand(100, 999);

					   			$ruta = "vistas/img/clientes/".$_POST["editarUsuario"]."/".$aleatorio.".png";

					   			$origen = imagecreatefrompng($_FILES["editarFotoCli"]["tmp_name"]);

					   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					   			imagepng($destino, $ruta);
						   			
						   	}
		 			   
					   	}
					   	
					   	if($_POST["editarPasswordCli"] != ""){

							if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPasswordCli"])){

								$encriptar = crypt($_POST["editarPasswordCli"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
							
							}else{

								echo '		 
									swal({
									 	type: "error",
									 	title: "¡La Contraseña no puede llevar caracteres especiales!",
									 	showConfirmButton: true,
									 	confirmButtonText: "Cerrar",
									 	closeOnConfirm: false

									 	}).then((result)=>{

											if(result.value){
											
												window.location = "clientes";
											
											}
										
										})


								</script>'; 
							}

						}else{

							$encriptar = $passwordActual;
						}

						$tabla = "clientes";
						//var_dump($ruta);
						$datos = array("codcli" => $_POST["editarCodCli"],
									   "sucadm" => $_POST["actualSucAdm"],
									   "nombre" => $_POST["editarCliente"],
									   "password" => $encriptar,
									   "email1" => $_POST["editarEmail1"],
									   "cuit" => $_POST["editarCuit"],
									   "usuario" => $_POST["editarUsuarioCl"],
									   "foto" => $ruta);

						$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

						if($respuesta == "ok"){

							echo '<script>

								swal({
									type: "success",
									title: "¡El Cliente ha sido cambiado correctamente",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false,
								}).then((result) => {
									if(result.value){
								
										window.location = "clientes";
									}
								
								})
								
								</script> ';
						}

					}else{

						echo '<script>

							swal({
								type: "error",
								title: "¡El CUIT del Cliente no cumple con la norma de AFIP",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
								}).then((result) => {
									if(result.value){
										window.location = "clientes";
									}
								})
							 </script> ';
					}

				}else{

					echo '<script>

						swal({
							type: "error",
							title: "¡El Mail del Cliente no cumple con la norma de correo electrónico",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
							}).then((result) => {
								if(result.value){
									window.location = "clientes";
								}
							})
						 </script> ';
				}

			}else{

				echo '<script>

					swal({
						type: "error",
						title: "¡El Nombre de Cliente no puede ir vacio o llevar caracteres especiales, es numérico!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result) => {
							if(result.value){
								window.location = "clientes";
							}
						})
					 </script> ';
			}

		}

	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	
	static public function ctrBorrarCliente(){

		if(isset($_GET["idCliente"])){

			$tabla = "clientes";
			$datos = $_GET["idCliente"];

			//var_dump($datos);

			$respuesta = ModeloClientes::mdlBorrarCliente($tabla, $datos);

			if($respuesta == "ok"){
				echo '<script>

					swal({
						type: "success",
						title: "¡El Cliente ha sido Eliminado correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false,
					}).then((result) => {
						if(result.value){
							window.location = "clientes";
						}
					})
					</script> ';
			}else{
				echo '<script>

					swal({
						type: "error",
						title: "¡El Cliente NO ha sido Eliminado",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false,
					}).then((result) => {
						if(result.value){
							window.location = "clientes";
						}
					})
					</script> ';
			}
		
		}

	}

	/*=============================================
	ELIMINAR CLIENTE DESDE USUARIOS
	=============================================*/

	static public function ctrBorrarClienteUs(){

		if(isset($_GET["perfil"])){

			$tabla = "clientes";
			$datos = $_GET["codcli"];

			if($_GET["fotoCliente"] != ""){
				
				unlink($_GET["fotoCliente"]);
				rmdir('vistas/img/clientes/'.$_GET["usuario"]);

			}

			$respuesta = ModeloClientes::mdlBorrarClienteUs($tabla, $datos);

			if($respuesta == "ok"){

				echo '<script>

					swal({
					 	type: "success",
					 	title: "¡El Cliente han sido Borrado correctamente!",
					 	showConfirmButton: true,
					 	confirmButtonText: "Cerrar",
					 	closeOnConfirm: false

					 	}).then((result)=>{

							if(result.value){
							
								window.location = "usuarios";

							
							}
						
						})

				</script>';

				

			}

		}

	}

	/*=============================================
	SUMA CANTIDAD DE CLIENTES
	=============================================*/

	static public function ctrSumaClientes(){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlSumaClientes($tabla);

		return $respuesta;

	}
	
	/*=============================================
	MOSTRAR TOTAL DE CARS DE CLIENTES
	=============================================*/

	static public function ctrMostrarTotCLientes($item, $valor, $orden){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarTotClientes($tabla, $item, $valor, $orden);

		return $respuesta;
		
	}

	/*=============================================
	EDITAR UN CLIENTE
	=============================================*/

	static public function ctrEditarUnCliente(){

		if(isset($_POST["editarCliente"])){

			if(preg_match('/^[-.a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCliente"])){

				if(preg_match('/^[-0-9 ]+$/', $_POST["editarCuit"])){

					if($_POST["editarEmail1"] != ""){

						if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/', $_POST["editarEmail1"])){

							$mailbien = 1;

						}else{

							$mailbien = 0;
							echo '<script>

								swal({
									type: "error",
									title: "¡El Primer Mail del Cliente no cumple con la norma de correo electrónico",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
									}).then((result) => {
										if(result.value){
											window.location = "modcliente";
										}
									})
								 </script> ';
						}

					}

					if($_POST["editarEmail2"] != ""){

						if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/', $_POST["editarEmail2"])){

							$mailbien = 1;

						}else{

							$mailbien = 0;
							echo '<script>

								swal({
									type: "error",
									title: "¡El Segundo Mail del Cliente no cumple con la norma de correo electrónico",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
									}).then((result) => {
										if(result.value){
											window.location = "modcliente";
										}
									})
								 </script> ';
						}

					}

					if($_POST["editarEmail3"] != ""){

						if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/', $_POST["editarEmail3"])){

							$mailbien = 1;

						}else{

							$mailbien = 0;
							echo '<script>

								swal({
									type: "error",
									title: "¡El Tercer Mail del Cliente no cumple con la norma de correo electrónico",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
									}).then((result) => {
										if(result.value){
											window.location = "modcliente";
										}
									})
								 </script> ';
						}

					}

					if($mailbien > 0){

					   	$ruta = $_POST["fotoActualCli"];
					   	$passwordActual = $_POST["passwordActualCli"];

					   	if(isset($_FILES["editarFotoCli"]["tmp_name"]) && !empty($_FILES["editarFotoCli"]["tmp_name"])){

					   		list($ancho, $alto) = getimagesize($_FILES["editarFotoCli"]["tmp_name"]);

					   		$nuevoAncho = 500;
					   		$nuevoAlto = 500;

					   		// CREAMOS EL DIRECTORIO PARA GUARDAR LA FOTO DEL USUARIO

					   		$directorio = "vistas/img/clientes/".$_POST["editarUsuario"];

					   		// PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD

					   		if(!empty($_POST["fotoActualCli"])){

					   			unlink($_POST["fotoActualCli"]);
					   		
					   		}else{

					   			mkdir($directorio, 0755);			   			
					   		}

					   		// DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR  DEFECTO DE PHP

					   		if($_FILES["editarFotoCli"]["type"] == "image/jpeg"){

					   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

					   			$aleatorio = mt_rand(100, 999);

				 	   			$ruta = "vistas/img/clientes/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

					   			$origen = imagecreatefromjpeg($_FILES["editarFotoCli"]["tmp_name"]);

					   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					   			imagejpeg($destino, $ruta);

					   		}

							if($_FILES["editarFotoCli"]["type"] == "image/png"){

					   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

					   			$aleatorio = mt_rand(100, 999);

					   			$ruta = "vistas/img/clientes/".$_POST["editarUsuario"]."/".$aleatorio.".png";

					   			$origen = imagecreatefrompng($_FILES["editarFotoCli"]["tmp_name"]);

					   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					   			imagepng($destino, $ruta);
						   			
						   	}
		 			   
					   	}
					   	
					   	if($_POST["editarPasswordCli"] != ""){

							if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPasswordCli"])){

								$encriptar = crypt($_POST["editarPasswordCli"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
							
							}else{

								echo '		 
									swal({
									 	type: "error",
									 	title: "¡La Contraseña no puede llevar caracteres especiales!",
									 	showConfirmButton: true,
									 	confirmButtonText: "Cerrar",
									 	closeOnConfirm: false

									 	}).then((result)=>{

											if(result.value){
											
												window.location = "modcliente";
											
											}
										
										})


								</script>'; 
							}

						}else{

							$encriptar = $passwordActual;
						}

						$tabla = "clientes";
						//var_dump($ruta);
						$datos = array("codcli" => $_POST["editarCodCli"],
									   "sucadm" => $_POST["actualSucAdm"],
									   "nombre" => $_POST["editarCliente"],
									   "password" => $encriptar,
									   "email1" => $_POST["editarEmail1"],
									   "email2" => $_POST["editarEmail2"],
									   "email3" => $_POST["editarEmail3"],
									   "cuit" => $_POST["editarCuit"],
									   "usuario" => $_POST["editarUsuarioCl"],
									   "foto" => $ruta);

						$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

						if($respuesta == "ok"){

							echo '<script>

								swal({
									type: "success",
									title: "¡El Cliente ha sido cambiado correctamente",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false,
								}).then((result) => {
									if(result.value){
								
										window.location = "modcliente";
									}
								
								})
								
								</script> ';
						}

					}

				}else{

						echo '<script>

							swal({
								type: "error",
								title: "¡El CUIT del Cliente no cumple con la norma de AFIP",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
								}).then((result) => {
									if(result.value){
										window.location = "modcliente";
									}
								})
							 </script> ';
				}

			}else{

				echo '<script>

					swal({
						type: "error",
						title: "¡El Nombre de Cliente no puede ir vacio o llevar caracteres especiales, es numérico!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result) => {
							if(result.value){
								window.location = "modcliente";
							}
						})
					 </script> ';
			}

		}

	}

}
