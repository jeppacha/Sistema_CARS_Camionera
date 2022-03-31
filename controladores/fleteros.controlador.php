<?php

class ControladorFleteros{
	
	/*=============================================
	MOSTRAR FLETEROS
	=============================================*/

	static public function ctrMostrarFletero($item, $valor){

		$tabla = "fleteros";

		$respuesta = ModeloFleteros::mdlMostrarFleteros($tabla, $item, $valor);
		
		return $respuesta;

	}

	/*=============================================
	CREAR FLETERO
	=============================================*/
	
	static public function ctrCrearFletero(){

		if(isset($_POST["nuevoUsuario"])){
			
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevaPassword"]) &&
			   preg_match('/^[-0-9 ]+$/', $_POST["nuevoCuit"])){

			   	$ruta = "";

				if(isset($_FILES["nuevaFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DODE VAMOS A GUARDAR LA FOTO O LOGO
					=============================================*/

					$directorio = "vistas/img/fleteros/".$_POST["nuevoUsuario"];

					if(file_exists($directorio)){

					}else{

						mkdir($directorio, 0755);

					}
					/*=============================================
					SEGUN EL FORMATO APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/fleteros/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";

			   			$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagejpeg($destino, $ruta);

			   		}

			   		if($_FILES["nuevaFoto"]["type"] == "image/png"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/fleteros/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";

			   			$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagepng($destino, $ruta);

			   		}

				}

				$tabla = "fleteros";

				$encriptar = crypt($_POST["nuevaPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datos = array("cuitfle" => $_POST["nuevoCuit"],
							   "nombre" => $_POST["nuevoNombre"],
							   "usuario" => $_POST["nuevoUsuario"],
							   "sucadm" => $_POST["nuevaSucursal"],
							   "password" => $encriptar,
							   "estado" => 0,
							   "perfil" => "Fletero",
							   "foto" => $ruta); 

				$respuesta = ModeloFleteros::mdlIngresarFletero($tabla, $datos);
				//var_dump($respuesta);
				if($respuesta == "ok"){
					echo '<script>

						swal({
							type: "success",
							title: "¡El Fletero ha sido guardado correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false,
						}).then((result) => {
							if(result.value){
								window.location = "fleteros";
							}
						})
						</script> ';
				}

			}else{

				echo '<script>

					swal({
						type: "error",
						title: "¡El Fletero no puede ir vacio o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result) => {
							if(result.value){
								window.location = "fleteros";
							}
						})
					 </script> '; 

			}

		}

	}

	/*=============================================
	EDITAR FLETEROS
	=============================================*/

	static public function ctrEditarFletero(){

		if(isset($_POST["editarUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				
			   	$ruta = $_POST["fotoActual"]; 
			   	$sucursal = $_POST["actualSucursal"];
			   	$passwordActual = $_POST["passwordActual"];

			   	if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

			   		list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

			   		$nuevoAncho = 500;
			   		$nuevoAlto = 500;

			   		// CREAMOS EL DIRECTORIO PARA GUARDAR LA FOTO DEL USUARIO

			   		$directorio = "vistas/img/fleteros/".$_POST["editarUsuario"];

			   		// PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD

			   		if(!empty($_POST["fotoActual"])){

			   			unlink($_POST["fotoActual"]);
			   		
			   		}else{

			   			mkdir($directorio, 0755);			   			
			   		}

			   		// DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR  DEFECTO DE PHP

			   		if($_FILES["editarFoto"]["type"] == "image/jpeg"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

		 	   			$ruta = "vistas/img/fleteros/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

			   			$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagejpeg($destino, $ruta);

			   		}

					if($_FILES["editarFoto"]["type"] == "image/png"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/fleteros/".$_POST["editarUsuario"]."/".$aleatorio.".png";

			   			$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagepng($destino, $ruta);
				   			
				   	}
 			   
			   	}

				if($_POST["editarPassword"] != ""){

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

						$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					
					}else{

						echo '

						<script>		 
						
							swal({
							 	type: "error",
							 	title: "¡La Contraseña no puede llevar caracteres especiales!",
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

				}else{

					$encriptar = $passwordActual;

				}

				$tabla = "fleteros";
				
				$datos = array ("cuitfle" => $_POST["editarCuit"],
								"nombre" => $_POST["editarNombre"],
								"usuario" => $_POST["editarUsuario"],
								"sucadm" => $sucursal,
								"password" => $encriptar,
								"perfil" => "Fletero",
								"foto" => $ruta);
				//var_dump($datos);
				$respuesta = ModeloFleteros::mdlEditarFletero($tabla, $datos);
				//var_dump($respuesta);
				if($respuesta == "ok"){

					echo '

						<script>

							swal({
							 	type: "success",
							 	title: "¡El Fletero ha sido actualizado correctamente!",
							 	showConfirmButton: true,
							 	confirmButtonText: "Cerrar",
							 	closeOnConfirm: false

							}).then((result)=>{

								if(result.value){
									
									window.location = "fleteros";
									
								}
								
							})

						</script>';

				} 
			
			}else{

				echo

					'<script>

					swal({
					 	type: "error",
					 	title: "¡El nombre no puede ir vacio o con caracteres especiales!",
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
	BORRAR FLETEROS
	=============================================*/
	static public function ctrBorrarFletero(){

		if(isset($_GET["idFletero"])){

			$tabla = "fleteros";
			$datos = $_GET["idFletero"];

			if($_GET["fotoFletero"] != ""){

				unlink($_GET["fotoFletero"]);
				rmdir('vistas/img/fleteros/'.$_GET["usuario"]);

			}

			$respuesta = ModeloFleteros::mdlBorrarFletero($tabla, $datos);

			if($respuesta == "ok"){

				echo '

				<script>

					swal({
					 	type: "success",
					 	title: "¡El Fletero ha sido Borrado correctamente!",
					 	showConfirmButton: true,
					 	confirmButtonText: "Cerrar",
					 	closeOnConfirm: false

					}).then((result)=>{

						if(result.value){
							
							window.location = "fleteros";
							
						}
						
					})

				</script>';

			}

		}

	}
	
}