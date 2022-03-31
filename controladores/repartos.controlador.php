<?php 

class ControladorRepartos{

	/*=============================================
	MOSTRAR REPARTOS
	=============================================*/

	static public function ctrMostrarRepartos($item, $valor){

		$tabla = "hrepartos";

		$respuesta = ModeloRepartos::mdlMostrarRepartos($tabla, $item, $valor);
		
		return $respuesta;

	}

	/*=============================================
	VER REPARTOS
	=============================================*/

	static public function ctrVerRepartos($item, $valor){
//var_dump($valor);

		$tabla = "hrepartos";
			
		$respuesta = ModeloRepartos::mdlVerRepartos($tabla, $item, $valor);
		
		return $respuesta;

	}

	/*=============================================
	SUMA CANTIDAD DE REPARTOS
	=============================================*/

	static public function ctrSumaRepFle($item, $valor){

		$tabla = "hrepartos";

		$respuesta = ModeloRepartos::mdlSumaRepFle($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	ENTREGAR REPARTOS
	=============================================*/

	static public function ctrEntregaReparto($item, $valor, $item1){
		//var_dump($valor);
		$tabla = "repartos";
			
		$respuesta = ModeloRepartos::mdlEntregaReparto($tabla, $item, $valor, $item1);
			
		return $respuesta;

	}

	/*=============================================
	ENTREGAR REPARTOS ADMINISTRADOR
	=============================================*/

	static public function ctrEntregaRepartoAdm($item, $valor){
		//var_dump($valor);
		$tabla = "repartos";
			
		$respuesta = ModeloRepartos::mdlEntregaRepartoAdm($tabla, $item, $valor);
			
		return $respuesta;

	}

	/*=============================================
	MOSTRAR GUIA
	=============================================*/

	static public function ctrMostrarGuia($item, $valor, $item1, $valor1){

		$tabla = "repartos";

		$respuesta = ModeloRepartos::mdlMostrarGuia($tabla, $item, $valor, $item1, $valor1);
		
		return $respuesta;

	}

	/*=============================================
	ENTREGAR GUIA CON CAR
	=============================================*/

	static public function ctrEntregaGuiacc(){

		if(isset($_POST["editarGuiacc"])){

			$ruta = "";

			if(strcmp($_POST["entregacc"],"si")==0){

				if($_FILES["nuevaFoto"]["tmp_name"] == ""){

					echo '

					<script>

						swal({
						 	type: "error",
						 	title: "¡La Foto del CAR no puede estar vacia!",
						 	showConfirmButton: true,
						 	confirmButtonText: "Cerrar",
						 	closeOnConfirm: false

						}).then((result)=>{

							if(result.value){
								
								window.location = "repartos";
								
							}
							
						})

					</script>';

				}else{

					//echo($_FILES['nuevaFoto']["tmp_name"]);

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
					
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR EL CAR
					=============================================*/

					$directorio = "vistas/img/cars/".$_POST["codclicc"];

					if(file_exists($directorio)){

					}else{

						mkdir($directorio, 0777, true);

					}	
					chmod($directorio, 0777);
					/*=============================================
					SEGUN EL FORMATO APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/cars/".$_POST["codclicc"]."/".$aleatorio.".jpg";

			   			echo($ruta);
			   			chmod($directorio."/".$aleatorio.".jpg", 0777);
			   			$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagejpeg($destino, $ruta);

			   		}

			   		if($_FILES["nuevaFoto"]["type"] == "image/png"){

			   			// GUARDAMOS LA IMAGEN EN EL DIRECTORIO

			   			$aleatorio = mt_rand(100, 999);

			   			$ruta = "vistas/img/cars/".$_POST["codclicc"]."/".$aleatorio.".png";
			   			chmod($directorio."/".$aleatorio.".png", 0777);
			   			$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagepng($destino, $ruta);

			   		}

			
					$tabla = "repartos";

					if(isset($_POST["entregacc"])){
						//var_dump($_POST["entrega"]);
						if(strcmp($_POST["entregacc"],"si")==0){
							
							date_default_timezone_set('America/Argentina/Mendoza');
							$deliv = 1;
							$fechadeliv = date('Y-m-d');;

						}else{

							$deliv = 0;
							$fechadeliv = "";

						}
						
					}
					if($deliv === 1){
						
						$datos = array(	"codoff" => $_POST["sucuradm"],
										"cuitfle" => $_POST["cuitfle"],
										"repnro" => $_POST["repnrocc"],
										"repfec" => $_POST["editarFecRepar"],
										"fecdeliv" => $fechadeliv,
										"nguia" => $_POST["editarGuiacc"],
										"codcli" => $_POST["codclicc"],
										"deliv" => $deliv,
								    	"fotocar" => $ruta);

						$respuesta = ModeloRepartos::mdlEntregaGuiacc($tabla, $datos);

						if($respuesta == "ok"){

							$tablacar = "tb_cars";

							$datocar = array("codcli" => $_POST["codclicc"],
											 "id_sucadm" => $_POST['buscarAdmin'],
											 "nombre" => $_POST['buscarNombre'],
											 "nguia" => $_POST['editarGuiacc'],
											 "org" => $_POST['buscarOrg'],
											 "dst" => $_POST['buscarDst'],
											 "nomrem" => $_POST['buscarRemitente'],
											 "nomdes" => $_POST['buscarDestinatario'],
											 "frecib" => $_POST['editarFecRepar'],
											 "reparto" => $_POST['repnrocc'],
											 "pdf" => $ruta,
											 "estado" => $deliv,
											 "fdeliv" => $fechadeliv);
							//var_dump($datocar);
							$respuestacar = ModeloCars::mdlActualizaCar($tablacar, $datocar);

							if($respuestacar == "ok"){

								$tablahrep = 'hrepartos';

								$itemhrep1 = "codoff";
								$valorh1 = $_POST["sucuradm"];
								$itemhrep2 = "repnum";
								$valorh2 = $_POST["repnrocc"];

								$mirarinde = ModeloRepartos::mdlMiraRinde($tablahrep, $itemhrep1, $valorh1, $itemhrep2, $valorh2);

								if($mirarinde["guiarend"] == null){

									$guias = 1;

								}else{

									if($mirarinde["guiarend"]<$mirarinde["cantg"]){

										$guias = ($mirarinde["guiarend"]+1);

									}
									
								}

						
								$itemguia = "guiarend";
								$datosguia = array("codoff" => $_POST["sucuradm"],
												   "repnum" => $_POST["repnrocc"],
												   "guiarend" => $guias);

								$actualizahrep = ModeloRepartos::mdlActualizaHreparto($tablahrep, $datosguia);

								if($actualizahrep != "ok"){

									echo '

									<script>

										swal({
										 	type: "error",
										 	title: "¡Cantidad de guias no actualizada!",
										 	showConfirmButton: true,
										 	confirmButtonText: "Cerrar",
										 	closeOnConfirm: false

										}).then((result)=>{

											if(result.value){
												
												window.location = "repartos";
												
											}
											
										})

									</script>';
									
								}								

								echo '

								<script>

									swal({
									 	type: "success",
									 	title: "¡La Guia ha sido actualizada correctamente!",
									 	showConfirmButton: true,
									 	confirmButtonText: "Cerrar",
									 	closeOnConfirm: false

									}).then((result)=>{

										if(result.value){
											
											window.location = "repartos";
											
										}
										
									})

								</script>';	

							}

						}

					}

				}

			}

			if(strcmp($_POST["entregacc"],"no")==0){
				//var_dump($_POST["txtDescripcion"]);
				//if($_POST["txtDescripcion"] == null){
				if($_POST["txtDescripcion"] == ""){

					echo '

					<script>

						swal({
						 	type: "error",
						 	title: "¡El Motivo de NO Entrega NO puede estar vacio!",
						 	showConfirmButton: true,
						 	confirmButtonText: "Cerrar",
						 	closeOnConfirm: false

						}).then((result)=>{

							if(result.value){
								
								window.location = "repartos";
								
							}
							
						})

					</script>';

				}else{

					$ruta = "";
					$tabla = "repartos";
					$deliv = 0;
					$fechadeliv = "";

					$datos = array(	"repnro" => $_POST["repnrocc"],
								"nguia" => $_POST["editarGuiacc"],
								"deliv" => $deliv,
						    	"motivo" => $_POST["txtDescripcion"]);

					$respuesta = ModeloRepartos::mdlNoEntregaGuia($tabla, $datos);

					if($respuesta == "ok"){

						$tablahrep = 'hrepartos';

						$itemhrep1 = "codoff";
						$valorh1 = $_POST["sucuradm"];
						$itemhrep2 = "repnum";
						$valorh2 = $_POST["repnrocc"];

						$mirarinde = ModeloRepartos::mdlMiraRinde($tablahrep, $itemhrep1, $valorh1, $itemhrep2, $valorh2);

						if($mirarinde["guiarend"] == null){

							$guias = 1;

						}else{

							if($mirarinde["guiarend"]<$mirarinde["cantg"]){

								$guias = ($mirarinde["guiarend"]+1);

							}

						}

						$itemguia = "guiarend";
						$datosguia = array("codoff" => $_POST["sucuradm"],
										   "repnum" => $_POST["repnrocc"],
										   "guiarend" => $guias);

						$actualizahrep = ModeloRepartos::mdlActualizaHreparto($tablahrep, $datosguia);

						if($actualizahrep != "ok"){

							echo '

							<script>

								swal({
								 	type: "error",
								 	title: "¡Cantidad de guias no actualizada!",
								 	showConfirmButton: true,
								 	confirmButtonText: "Cerrar",
								 	closeOnConfirm: false

								}).then((result)=>{

									if(result.value){
										
										window.location = "repartos";
										
									}
									
								})

							</script>';
						}						

						echo '

						<script>

							swal({
							 	type: "success",
							 	title: "¡La Guia ha sido actualizada correctamente!",
							 	showConfirmButton: true,
							 	confirmButtonText: "Cerrar",
							 	closeOnConfirm: false

							}).then((result)=>{

								if(result.value){
									
									window.location = "repartos";
									
								}
								
							})

						</script>';

					}

				}

			}

		}

	}

	/*=============================================
	ENTREGAR GUIA SIN CAR
	=============================================*/

	static public function ctrEntregaGuiasc(){

		if(isset($_POST["editarGuiasc"])){

			$tabla = "repartos";

			$ruta = "";

			if(isset($_POST["entregasc"])){
				//var_dump($_POST["entrega"]);
				if(strcmp($_POST["entregasc"],"si")==0){
					
					date_default_timezone_set('America/Argentina/Mendoza');
					$deliv = 1;
					$fechadeliv = date('Y-m-d');

					$datosc = array("codoff" => $_POST["sucuradmsc"],
								"cuitfle" => $_POST["cuitflesc"],
								"repnro" => $_POST["repnrosc"],
								"repfec" => $_POST["editarFecReparsc"],
								"fecdeliv" => $fechadeliv,
								"nguia" => $_POST["editarGuiasc"],
								"codcli" => $_POST["codclisc"],
								"deliv" => $deliv,
						    	"fotocar" => $ruta);

					$respuestasc = ModeloRepartos::mdlEntregaGuiasc($tabla, $datosc);

					if($respuestasc == "ok"){

						$tablahrep = 'hrepartos';

						$itemhrep1 = "codoff";
						$valorh1 = $_POST["sucuradmsc"];
						$itemhrep2 = "repnum";
						$valorh2 = $_POST["repnrosc"];

						$mirarinde = ModeloRepartos::mdlMiraRinde($tablahrep, $itemhrep1, $valorh1, $itemhrep2, $valorh2);

						if($mirarinde["guiarend"] == null){

							$guias = 1;

						}else{

							if($mirarinde["guiarend"]<$mirarinde["cantg"]){

								$guias = ($mirarinde["guiarend"]+1);

							}

						}

						$itemguia = "guiarend";
						$datosguia = array("codoff" => $_POST["sucuradmsc"],
										   "repnum" => $_POST["repnrosc"],
										   "guiarend" => $guias);

						$actualizahrep = ModeloRepartos::mdlActualizaHreparto($tablahrep, $datosguia);

						if($actualizahrep != "ok"){

							echo '

							<script>

								swal({
								 	type: "error",
								 	title: "¡Cantidad de guias no actualizada!",
								 	showConfirmButton: true,
								 	confirmButtonText: "Cerrar",
								 	closeOnConfirm: false

								}).then((result)=>{

									if(result.value){
										
										window.location = "repartos";
										
									}
									
								})

							</script>';

						}						

						echo '

						<script>

							swal({
							 	type: "success",
							 	title: "¡La Guia ha sido actualizada correctamente!",
							 	showConfirmButton: true,
							 	confirmButtonText: "Cerrar",
							 	closeOnConfirm: false

							}).then((result)=>{

								if(result.value){
									
									window.location = "repartos";
									
								}
								
							})

						</script>';

					}

				}else{

					$deliv = 0;
					$fechadeliv = "";

					if($_POST["txtSinCliente"] == ""){

						echo '

						<script>

							swal({
							 	type: "error",
							 	title: "¡El Motivo de NO Entrega NO puede estar vacio!",
							 	showConfirmButton: true,
							 	confirmButtonText: "Cerrar",
							 	closeOnConfirm: false

							}).then((result)=>{

								if(result.value){
									
									window.location = "repartos";
									
								}
								
							})

						</script>';

					}else{

						$datosc = array("repnro" => $_POST["repnrosc"],
								"nguia" => $_POST["editarGuiasc"],
								"deliv" => $deliv,
						    	"motivo" => $_POST["txtSinCliente"]);

						$respuestasc = ModeloRepartos::mdlNoEntregaGuia($tabla, $datosc);

						if($respuestasc == "ok"){

							$tablahrep = 'hrepartos';

							$itemhrep1 = "codoff";
							$valorh1 = $_POST["sucuradmsc"];
							$itemhrep2 = "repnum";
							$valorh2 = $_POST["repnrosc"];

							$mirarinde = ModeloRepartos::mdlMiraRinde($tablahrep, $itemhrep1, $valorh1, $itemhrep2, $valorh2);

							if($mirarinde["guiarend"] == null){

								$guias = 1;

							}else{

								if($mirarinde["guiarend"]<$mirarinde["cantg"]){

									$guias = ($mirarinde["guiarend"]+1);

								}

							}

							$itemguia = "guiarend";
							$datosguia = array("codoff" => $_POST["sucuradmsc"],
											   "repnum" => $_POST["repnrosc"],
											   "guiarend" => $guias);

							$actualizahrep = ModeloRepartos::mdlActualizaHreparto($tablahrep, $datosguia);

							if($actualizahrep != "ok"){

								echo '

								<script>

									swal({
									 	type: "error",
									 	title: "¡Cantidad de guias no actualizada!",
									 	showConfirmButton: true,
									 	confirmButtonText: "Cerrar",
									 	closeOnConfirm: false

									}).then((result)=>{

										if(result.value){
											
											window.location = "repartos";
											
										}
										
									})

								</script>';

							}							

							echo '

							<script>

								swal({
								 	type: "success",
								 	title: "¡La Guia ha sido actualizada correctamente!",
								 	showConfirmButton: true,
								 	confirmButtonText: "Cerrar",
								 	closeOnConfirm: false

								}).then((result)=>{

									if(result.value){
										
										window.location = "repartos";
										
									}
									
								})

							</script>';

						}

					}

				}

			}

		}

	}

	/*=============================================
	SUMA CANTIDAD DE GUIAS
	=============================================*/

	static public function ctrSumaGuiasFle($item, $valor){

		$tabla = "repartos";

		$respuesta = ModeloRepartos::mdlSumaGuiasFle($tabla, $item, $valor);

		return $respuesta;

	}	

}

