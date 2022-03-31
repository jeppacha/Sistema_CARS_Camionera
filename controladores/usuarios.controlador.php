<?php

class ControladorUsuarios{

	/*=============================================
	INGRESO USUARIOS
	=============================================*/
	
	static public function ctrIngresoUsuario(){

		if(isset($_POST["ingUsuario"])){

			if(strcmp($_POST["loginPerfil"],"Administrador")==0 || strcmp($_POST["loginPerfil"],"Operador")==0){

				if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && 
				   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

					$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				   	$tabla = "usuarios";
				   	$item = "usuario";
				   	$valor = $_POST["ingUsuario"];

				   	$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

				   //var_dump($respuesta["usuario"]);

				   	if($respuesta["usuario"] == $_POST["ingUsuario"]){

				   		if($respuesta["password"] == $encriptar){

				   			if($respuesta["perfil"] == $_POST["loginPerfil"]){

				   				if($respuesta["estado"] == 1){
					   	
							   		$_SESSION["iniciarSesion"] = "ok";
							   		$_SESSION["id"] = $respuesta["id"];
									$_SESSION["nombre"] = $respuesta["nombre"];
									$_SESSION["usuario"] = $respuesta["usuario"];
									$_SESSION["perfil"] = $respuesta["perfil"];
									$_SESSION["id_oficina"] = $respuesta["id_oficina"];
									$_SESSION["foto"] = $respuesta["foto"];

									/*=============================================
									=         REGISTRAR ULTIMO LOGIN             =
									=============================================*/
									
									
									//$fecha = date('d-m-Y');
									$fecha = date('Y-m-d');
									$hora = date('H:i:s');

									$fechaActual = $fecha.' '.$hora;

									$item1 = "ultimo_login";
									$valor1 = $fechaActual;

									$item2 = "id";
									$valor2 = $respuesta["id"];

									$ultimoLoguin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

									if($ultimoLoguin == "ok"){

										 echo '<script>
										
											window.location = "inicio";
									
										</script>';	
									
									}

							   	}else{

							   		echo '<br><div class="alert alert-danger">¡El Usuario NO está ACTIVO!</div>';

							   	}

							}else{

								echo '<br><div class="alert alert-danger">¡El Perfil de Usuario NO es el correcto!</div>';

							}

						}else{

							echo '<br><div class="alert alert-danger">¡La Password del Usuario es erronea!</div>';

						}

				   	}else{

				   		echo '<br><div class="alert alert-danger">El Usuario NO existe para este Perfil</div>';

				   	}

				}

			}

			if(strcmp($_POST["loginPerfil"],"Cliente")==0){

				if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && 
			   	   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

					$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				   	$tabla = "clientes";
				   	$item = "usuario";
				   	$valor = $_POST["ingUsuario"];
				   	$orden = "id";

				   	$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor, $orden);

				   //var_dump($respuesta["usuario"]);

				   	if($respuesta["usuario"] == $_POST["ingUsuario"]){

				   		if($respuesta["password"] == $encriptar){

					   		$_SESSION["iniciarSesion"] = "ok";
					   		$_SESSION["id"] = $respuesta["id"];
							$_SESSION["nombre"] = $respuesta["nombre"];
							$_SESSION["usuario"] = $respuesta["usuario"];
							$_SESSION["sucadm"] = $respuesta["sucadm"];
							$_SESSION["foto"] = $respuesta["foto"];
							$_SESSION["perfil"] = "Cliente";
							$_SESSION["codcli"] = $respuesta["codcli"];

							/*=============================================
							=         REGISTRAR ULTIMO LOGIN             =
							=============================================*/
						
							date_default_timezone_set('America/Argentina/Mendoza');
							//$fecha = date('d-m-Y');
							$fecha = date('Y-m-d');
							$hora = date('H:i:s');

							$fechaActual = $fecha.' '.$hora;

							$item1 = "ultimo_login";
							$valor1 = $fechaActual;

							$item2 = "id";
							$valor2 = $respuesta["id"];

							$ultimoLoguin = ModeloClientes::mdlActualizarCliente($tabla, $item1, $valor1, $item2, $valor2);

							if($ultimoLoguin == "ok"){

								echo '<script>
							
									window.location = "inicio";
						
								</script>';	
						
							}

						}else{

							echo '<br><div class="alert alert-danger">¡La Password del Usuario es erronea!</div>';

						}

					}else{

						echo '<br><div class="alert alert-danger">El Usuario NO existe para este Perfil</div>';

					}

				}

			}

			if(strcmp($_POST["loginPerfil"],"Fletero")==0){

				if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && 
				   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

					$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				   	$tabla = "fleteros";
				   	$item = "usuario";
				   	$valor = $_POST["ingUsuario"];

				   	$respuesta = ModeloFleteros::mdlMostrarFleteros($tabla, $item, $valor);

				   //var_dump($respuesta["usuario"]);

				   	if($respuesta["usuario"] == $_POST["ingUsuario"]){

				   		if($respuesta["password"] == $encriptar){

					   		$_SESSION["iniciarSesion"] = "ok";
					   		$_SESSION["id"] = $respuesta["id"];
							$_SESSION["cuitfle"] = $respuesta["cuitfle"];
							$_SESSION["nombre"] = $respuesta["nombre"];
							$_SESSION["usuario"] = $respuesta["usuario"];
							$_SESSION["sucadm"] = $respuesta["sucadm"];
							$_SESSION["foto"] = $respuesta["foto"];
							$_SESSION["perfil"] = "Fletero";

							/*=============================================
							=         REGISTRAR ULTIMO LOGIN             =
							=============================================*/
							
							date_default_timezone_set('America/Argentina/Mendoza');
							//$fecha = date('d-m-Y');
							$fecha = date('Y-m-d');
							$hora = date('H:i:s');

							$fechaActual = $fecha.' '.$hora;

							$item1 = "ultimo_login";
							$valor1 = $fechaActual;

							$item2 = "id";
							$valor2 = $respuesta["id"];

							$ultimoLoguin = ModeloFleteros::mdlActualizarFletero($tabla, $item1, $valor1, $item2, $valor2);

							if($ultimoLoguin == "ok"){

								echo '<script>
								
									window.location = "inicio";
							
								</script>';	
							
							}

						}else{

							echo '<br><div class="alert alert-danger">¡La Password del Usuario es erronea!</div>';

						}

					}else{

						echo '<br><div class="alert alert-danger">El Usuario NO existe para este Perfil</div>';

					}

				}

			}

		}
 
	}

	/*=============================================
	REGISTRO DE USUARIOS
	=============================================*/

	static public function ctrCrearUsuario(){

		if(isset($_POST["nuevoUsuario"])){
			//var_dump($_POST["nuevoUsuario"]);
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nuevoNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/',$_POST["nuevoUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/',$_POST["nuevaPassword"])){

			   	$ruta = "";

				if(isset($_FILES["nuevaFoto"]["tmp_name"])){

					//var_dump($_FILES["nuevaFoto"]["tmp_name"]);

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DODE VAMOS A GUARDAR LA FOTO O LOGO
					=============================================*/

					$directorio = "vistas/img/usuarios/".$_POST["nuevoUsuario"];

					mkdir($directorio, 0755, true);

					/*=============================================
					SEGUN EL FORMATO APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";

			   			$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagejpeg($destino, $ruta);

			   		}

			   		if($_FILES["nuevaFoto"]["type"] == "image/png"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";

			   			$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagepng($destino, $ruta);

			   		}

				}
				
				$tabla = "usuarios";

				$encriptar = crypt($_POST["nuevaPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datos = array(	"nombre" => $_POST["nuevoNombre"],
								"usuario" => $_POST["nuevoUsuario"],
								"password" => $encriptar,
								"perfil" => $_POST["nuevoPerfil"],
								"id_oficina" => $_POST["nuevaSucursal"],
						    	"foto" => $ruta,
						    	"estado" => 1);


				var_dump($datos);
				$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
				
				if($respuesta == "ok"){

					echo 

						'<script>

							swal({
							 	type: "success",
							 	title: "¡El usuario ha sido guardado correctamenta!",
							 	showConfirmButton: true,
							 	confirmButtonText: "Cerrar",
							 	closeOnConfirm: false
							 }).then((result)=>{

								if(result.value){
									
									window.location = "usuarios";
									
								}
								
							})

						</script>'; 

				}else{

					echo 

						'<script>

							swal({
							 	type: "error",
							 	title: "¡El usuario NO ha sido guardado correctamenta!",
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

				echo 

				'<script>

					swal({
					 	type: "error",
					 	title: "¡El usuario no puede ir vacio o con caracteres especiales!",
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
	MOSTRAR USUARIOS
	=============================================*/

	static public function ctrMostrarUsuario($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAR USUARIOS
	=============================================*/

	static public function ctrEditarUsuario(){

		if(isset($_POST["editarNombre"])){

			if(preg_match('/^[-.a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				
			   	$ruta = $_POST["fotoActual"]; 
			   	$sucursal = $_POST["actualSucursal"];

			   	if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

			   		list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

			   		$nuevoAncho = 500;
			   		$nuevoAlto = 500;

			   		// CREAMOS EL DIRECTORIO PARA GUARDAR LA FOTO DEL USUARIO

			   		$directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

			   		// PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD

			   		if(!empty($_POST["fotoActual"])){

			   			unlink($_POST["fotoActual"]);
			   		
			   		}else{

			   			mkdir($directorio, 0755, true);			   			
			   		}

			   		// DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR  DEFECTO DE PHP

			   		if($_FILES["editarFoto"]["type"] == "image/jpeg"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

		 	   			$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

			   			$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagejpeg($destino, $ruta);

			   		}

					if($_FILES["editarFoto"]["type"] == "image/png"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";

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

					$encriptar = $_POST["passwordActual"];

				}

				//$estado = $_POST["$editarEstado"];
				//$ultimolog = $_POST["$editarUltimo_loguin"];
				
				$tabla = "usuarios";
				
				$datos = array ("id" => $_POST["editarId"],
								"nombre" => $_POST["editarNombre"],
								"password" => $encriptar,
								"foto" => $ruta);
								//"estado" => $estado,
								//"ultimo_login" => $ultimolog);

				var_dump($datos);
				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
				var_dump($respuesta);
				if($respuesta == "ok"){

					echo '

						<script>

							swal({
							 	type: "success",
							 	title: "¡El usuario ha sido actualizado correctamente!",
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
	BORRAR USUARIO
	=============================================*/

	static public function ctrBorrarUsuario(){
 
		if(isset($_GET["idUsuario"])){

			$tabla = "usuarios";
			$datos = $_GET["idUsuario"];
			//var_dump($_GET["fotoUsuario"]);
			// if($_GET["perfil"] != "Cliente"){

				if($_GET["fotoUsuario"] != ""){

					unlink($_GET["fotoUsuario"]);
					rmdir('vistas/img/usuarios/'.$_GET["usuario"]);

				}

			// }

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == "ok"){

				echo '<script>

					swal({
					 	type: "success",
					 	title: "¡El usuario ha sido Borrado correctamente!",
					 	showConfirmButton: true,
					 	confirmButtonText: "Cerrar",
					 	closeOnConfirm: false

					 	}).then((result)=>{

							if(result.value){
							
								window.location = "index.php?ruta=usuarios&perfil="+perfil+"&codcli="+codcli+"&usuario="+usuario;

							
							}
						
						})

				</script>';

			}

		}

	}

	/*=============================================
	SUMA TOTAL DE USUARIOS
	=============================================*/

	static public function ctrSumaTotalUsuarios(){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlSumaTotalUsuarios($tabla);

		return $respuesta;
	}
			
}