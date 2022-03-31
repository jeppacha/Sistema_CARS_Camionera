<?php 

class controladorArchivo{

	/*=============================================
	SUBE ARCHIVO DE CLIENTES
	=============================================*/
	
	static public function ctrSubirClientes(){

		if(isset($_FILES["cliente"])){
			
		    $cliename = $_FILES["cliente"]["name"];
		    //var_dump($cliename);
		    if($cliename == ""){

		    	echo '<script>

				 	swal({
				 	 	type: "error",
				 	 	title: "¡Seleccione un Archivo para subir!",
				 	 	showConfirmButton: true,
				 	 	confirmButtonText: "Cerrar",
				 	 	closeOnConfirm: false

				 	 	}).then((result)=>{

				 			if(result.value){
							
				 				window.location = "sube-bases";
							
				 			}
						
				 		})

				 </script>';

		    }else{

			    $subname = substr($cliename, 8,1);
			    //var_dump($subname);
			   	if($_POST["baseSucursal"] == "#"){

			   		echo '<script>

					 	swal({
					 	 	type: "error",
					 	 	title: "¡Seleccione la Sucursal a la que pertenece!",
					 	 	showConfirmButton: true,
					 	 	confirmButtonText: "Cerrar",
					 	 	closeOnConfirm: false

					 	 	}).then((result)=>{

					 			if(result.value){
								
					 				window.location = "sube-bases";
								
					 			}
							
					 		})

					 </script>';

				}else{
			   		//var_dump($_POST["carSucursal"]);
				    $sucursal = $_POST["baseSucursal"];

				    if(strcmp($subname,$sucursal) === 0){

				    	if(isset($_FILES["cliente"]["tmp_name"])){

				    		$directorio = "vistas/archivos/clientes/".$_POST["baseSucursal"];

			    			if(file_exists($directorio)){

			    			}else{
			    				
			    				mkdir($directorio, 0755);

							}

							$archCliOrigen = $_FILES["cliente"]["tmp_name"];

							date_default_timezone_set('America/Argentina/Mendoza');
								
							$fecha = date('Y-m-d');

							$nomarchi = substr($cliename, 0,-4);

							$archivo = $nomarchi.$fecha;

							$archCliDestino = "vistas/archivos/clientes/".$_POST["baseSucursal"]."/".$archivo.".asc";
							
							if(copy($archCliOrigen, $archCliDestino)){

						    	if(file_exists($archCliDestino)){

							    	$clien = fopen($archCliDestino, "r");

							    	$tabla = "clientes";

							    	$subio = 0;
							    	
							    	while ($data = fgetcsv($clien, 1000, ",")){
							    		//var_dump($data);
							    		if(isset($data[1])){

							    			$item = "codcli";
							    			$valor = $data[1];
							    			$orden = "codcli";
							    			
							    			$revisa = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor, $orden);
							    			if($revisa == ""){
							    				//var_dump($data[6]);
							    				$respuesta = ModeloArchivo::mdlSubirClientes($tabla, $data);

							    				$subio++;

							    			}

							    			$data[6]="";
							    		}

									}

									if($subio > 0){

										if($respuesta == "ok"){

											echo '<script>

											 	swal({
											 	 	type: "success",
											 	 	title: "¡El Archivo ha subido Correctamente!",
											 	 	showConfirmButton: true,
											 	 	confirmButtonText: "Cerrar",
											 	 	closeOnConfirm: false

											 	 	}).then((result)=>{

											 			if(result.value){
														
											 				window.location = "inicio";
														
											 			}
													
											 		})

											 </script>';

										}else{

											echo '<script>

											 	swal({
											 	 	type: "error",
											 	 	title: "¡El Archivo NO pudo ser procesado!",
											 	 	showConfirmButton: true,
											 	 	confirmButtonText: "Cerrar",
											 	 	closeOnConfirm: false

											 	 	}).then((result)=>{

											 			if(result.value){
														
											 				window.location = "inicio";
														
											 			}
													
											 	})

											 </script>';

										}

									}else{

										echo '<script>

										 	swal({
										 	 	type: "error",
										 	 	title: "¡No Hay datos para Actualizar!",
										 	 	showConfirmButton: true,
										 	 	confirmButtonText: "Cerrar",
										 	 	closeOnConfirm: false

										 	 	}).then((result)=>{

										 			if(result.value){
													
										 				window.location = "sube-bases";
													
										 			}
												
										 		})


										 </script>';

									}

							    }else{

							    	echo '<script>

									 	swal({
									 	 	type: "error",
									 	 	title: "¡No Existe archivo archCarDestino!",
									 	 	showConfirmButton: true,
									 	 	confirmButtonText: "Cerrar",
									 	 	closeOnConfirm: false

									 	 	}).then((result)=>{

									 			if(result.value){
												
									 				window.location = "sube-bases";
												
									 			}
											
									 		})


									 </script>';
							    }

						    }else{

						    	echo '<script>

								 	swal({
								 	 	type: "error",
								 	 	title: "¡Falló COPY!",
								 	 	showConfirmButton: true,
								 	 	confirmButtonText: "Cerrar",
								 	 	closeOnConfirm: false

								 	 	}).then((result)=>{

								 			if(result.value){
											
								 				window.location = "sube-bases";
											
								 			}
										
								 		})


								 </script>';

						    }

				    	}else{

				    		echo '<script>

							 	swal({
							 	 	type: "error",
							 	 	title: "¡El Archivo Temporal no encontrado!",
							 	 	showConfirmButton: true,
							 	 	confirmButtonText: "Cerrar",
							 	 	closeOnConfirm: false

							 	 	}).then((result)=>{

							 			if(result.value){
										
							 				window.location = "sube-bases";
										
							 			}
									
							 		})


							 </script>';

				    	}

					}else{

						echo '<script>

						 	swal({
						 	 	type: "error",
						 	 	title: "¡El Archivo a subir NO pertenece a la Sucursal!",
						 	 	showConfirmButton: true,
						 	 	confirmButtonText: "Cerrar",
						 	 	closeOnConfirm: false

						 	 	}).then((result)=>{

						 			if(result.value){
									
						 				window.location = "sube-bases";
									
						 			}
								
						 		})


						 </script>';

					}

				} 

			} 

		}

	}

	/*=============================================
	SUBE ARCHIVO DE CARS
	=============================================*/
	
	static public function ctrSubirCars(){

		if(isset($_FILES["cars"])){
			
		    $carsname = $_FILES["cars"]["name"];
		    //var_dump($carsname);
		    if($carsname == ""){

		    	echo '<script>

				 	swal({
				 	 	type: "error",
				 	 	title: "¡Seleccione un Archivo para subir!",
				 	 	showConfirmButton: true,
				 	 	confirmButtonText: "Cerrar",
				 	 	closeOnConfirm: false

				 	 	}).then((result)=>{

				 			if(result.value){
							
				 				window.location = "sube-bases";
							
				 			}
						
				 		})

				 </script>';

		    }else{

			    $subnamecar = substr($carsname, 8,1);
			    //var_dump($subnamecar);
			   	if($_POST["carSucursal"] == "#"){

			   		echo '<script>

					 	swal({
					 	 	type: "error",
					 	 	title: "¡Seleccione la Sucursal a la que pertenece!",
					 	 	showConfirmButton: true,
					 	 	confirmButtonText: "Cerrar",
					 	 	closeOnConfirm: false

					 	 	}).then((result)=>{

					 			if(result.value){
								
					 				window.location = "sube-bases";
								
					 			}
							
					 		})

					 </script>';

				}else{
			   		//var_dump($_POST["carSucursal"]);
				    $sucursal = $_POST["carSucursal"];

				    if(strcmp($subnamecar,$sucursal) === 0){
				    	//var_dump($sucursal);
				    	if(isset($_FILES["cars"]["tmp_name"])){

				    		$directorio = "vistas/archivos/cars/".$_POST["carSucursal"];

			    			if(file_exists($directorio)){

			    			}else{

			    				mkdir($directorio, 0755);

							}

							$archCarOrigen = $_FILES["cars"]["tmp_name"];

							date_default_timezone_set('America/Argentina/Mendoza');
								
							$fecha = date('Y-m-d');

							$nomarchi = substr($carsname, 0,-4);

							$archivo = $nomarchi.$fecha;

							$archCarDestino = "vistas/archivos/cars/".$_POST["carSucursal"]."/".$archivo.".asc";
							
							if(copy($archCarOrigen, $archCarDestino)){

						    	if(file_exists($archCarDestino)){

							    	$car = fopen($archCarDestino, "r");
							    	//var_dump($car);
							    	$tabla = "tb_cars";
							    	$tablacli = "clientes";
							    	$subio = 0;
							    	
							    	while ($datacar = fgetcsv($car, 1000, ",")){
							    		//var_dump($datacar);
							    		if(isset($datacar[0])){

							    			// COMPRUEBO SI EL CLIENTE DEL REGISTRO EXISTE, SI NO EXISTE NO GRABO EL REGISTRO Y LO INFORMO
							    			$tablacli = "clientes";
							    			$itemcli = "codcli";
							    			$valorcli = $datacar[1];
							    			$orden = "id";

							    			$existecli = ModeloClientes::mdlMostrarClientes($tablacli, $itemcli, $valorcli, $orden);
							    			//var_dump($existecli);
							    			if($existecli != ""){

								    			$item = "nguia";
								    			$valor = $datacar[4];
								    			$revisa = ModeloCars::mdlBuscarCars($tabla, $item, $valor);
								    			if($revisa == ""){

								    				$traercliente = ModeloClientes::mdlMostrarClientes($tablacli, $itemcli, $valorcli, $orden);
								    				//var_dump($traercliente["totalcars"]);
								    				$carsclien = $traercliente["totalcars"] + 1;
								    				//var_dump($carsclien);
								    				$tablacli = "clientes";
								    				$item1 = "totalcars";
								    				$valor1 = $carsclien;

								    				$totcarcli = ModeloClientes::mdlActualizaCarCliente($tablacli, $item1, $valor1, $valorcli);
								    				
								    				$respuesta = ModeloArchivo::mdlSubirCars($tabla, $datacar);

								    				$subio++;

								    			}

								    		}

							    		}

									}

									if($subio > 0){

										if($respuesta == "ok"){

											echo '<script>

											 	swal({
											 	 	type: "success",
											 	 	title: "¡El Archivo ha subido Correctamente!",
											 	 	showConfirmButton: true,
											 	 	confirmButtonText: "Cerrar",
											 	 	closeOnConfirm: false

											 	 	}).then((result)=>{

											 			if(result.value){
														
											 				window.location = "sube-bases";
														
											 			}
													
											 		})


											 </script>';

										}else{

											echo '<script>

											 	swal({
											 	 	type: "error",
											 	 	title: "¡El Archivo NO pudo ser procesado!",
											 	 	showConfirmButton: true,
											 	 	confirmButtonText: "Cerrar",
											 	 	closeOnConfirm: false

											 	 	}).then((result)=>{

											 			if(result.value){
														
											 				window.location = "sube-bases";
														
											 			}
													
											 		})


											 </script>';

										}

									}else{

										echo '<script>

										 	swal({
										 	 	type: "error",
										 	 	title: "¡No Hay datos para Actualizar!",
										 	 	showConfirmButton: true,
										 	 	confirmButtonText: "Cerrar",
										 	 	closeOnConfirm: false

										 	 	}).then((result)=>{

										 			if(result.value){
													
										 				window.location = "sube-bases";
													
										 			}
												
										 		})


										 </script>';

									}

							    }else{

							    	echo '<script>

									 	swal({
									 	 	type: "error",
									 	 	title: "¡No Existe archivo archCarDestino!",
									 	 	showConfirmButton: true,
									 	 	confirmButtonText: "Cerrar",
									 	 	closeOnConfirm: false

									 	 	}).then((result)=>{

									 			if(result.value){
												
									 				window.location = "sube-bases";
												
									 			}
											
									 		})


									 </script>';
							    }

						    }else{

						    	echo '<script>

								 	swal({
								 	 	type: "error",
								 	 	title: "¡Falló COPY!",
								 	 	showConfirmButton: true,
								 	 	confirmButtonText: "Cerrar",
								 	 	closeOnConfirm: false

								 	 	}).then((result)=>{

								 			if(result.value){
											
								 				window.location = "sube-bases";
											
								 			}
										
								 		})


								 </script>';

						    }

				    	}else{

				    		echo '<script>

							 	swal({
							 	 	type: "error",
							 	 	title: "¡El Archivo Temporal no encontrado!",
							 	 	showConfirmButton: true,
							 	 	confirmButtonText: "Cerrar",
							 	 	closeOnConfirm: false

							 	 	}).then((result)=>{

							 			if(result.value){
										
							 				window.location = "sube-bases";
										
							 			}
									
							 		})


							 </script>';

				    	}

					}else{

						echo '<script>

						 	swal({
						 	 	type: "error",
						 	 	title: "¡El Archivo a subir NO pertenece a la Sucursal!",
						 	 	showConfirmButton: true,
						 	 	confirmButtonText: "Cerrar",
						 	 	closeOnConfirm: false

						 	 	}).then((result)=>{

						 			if(result.value){
									
						 				window.location = "sube-bases";
									
						 			}
								
						 		})


						 </script>';

					}

				} 

			} 

		}

	}

	/*=============================================
	SUBE ARCHIVO DE REPARTOS
	=============================================*/
	static public function ctrSubirReparto(){
		
		if(isset($_FILES["reparto"])){

			$repname = $_FILES["reparto"]["name"];
			//$repname = repM123456.zip - Nombre del Archivo de Subida
			//var_dump($repname);
			if($repname == ""){

				echo '<script>

				 	swal({
				 	 	type: "error",
				 	 	title: "¡Seleccione un Archivo para subir!",
				 	 	showConfirmButton: true,
				 	 	confirmButtonText: "Cerrar",
				 	 	closeOnConfirm: false

				 	 	}).then((result)=>{

				 			if(result.value){
							
				 				window.location = "sube-reparto";
							
				 			}
						
				 		})

				</script>';

			}else{

				$subnamerep = substr($repname, 3,1);
			    //$subnamerep = M - Sucursal
			   	//var_dump($subnamerep);
			   	if($_POST["repSucursal"] == "#"){

			   		echo '<script>

					 	swal({
					 	 	type: "error",
					 	 	title: "¡Seleccione la Sucursal a la que pertenece!",
					 	 	showConfirmButton: true,
					 	 	confirmButtonText: "Cerrar",
					 	 	closeOnConfirm: false

					 	 	}).then((result)=>{

					 			if(result.value){
								
					 				window.location = "sube-reparto";
								
					 			}
							
					 		})

					 </script>';

				}else{
					$sinextension = substr($repname, 0, -4);
					//var_dump($sinextension);
					//$exrtension = repM123456
					$subrepnum = substr($sinextension, 4);
					//var_dump($subrepnum);
					//$subrepnum = 131375 - Nro del Reaprto
					
					$sucursal = $_POST["repSucursal"];
					
				    if(strcmp($subnamerep,$sucursal) === 0){
				    	//var_dump($sucursal);
				    	if(isset($_FILES["reparto"]["tmp_name"])){

				    		$directorio = "vistas/archivos/repartos/".$_POST["repSucursal"];

				    		$archivo = $directorio."/".$repname;
				    		//var_dump($archivo);
				    		//$directorio = vistas/archivos/repartos/M/131375

				    		$existe = 0;
							$existeh = 0;

			    			if(file_exists($archivo)){

			    				$archexis = substr($repname, 0,-4);

			    				$archexish = "h".substr($repname, 0,-4);

			    				unlink($directorio."/".$repname); //Archivo zip

			    				if(file_exists($directorio."/".$archexis.".asc")){
			    					unlink($directorio."/".$archexis.".asc"); //repM123456
			    				}
			    				if(file_exists($directorio."/".$archexish.".asc")){
			    					unlink($directorio."/".$archexish.".asc"); //hrepM123456
			    				}
			    				if(file_exists($directorio."/subecars".$subnamerep.".asc")){
			    					unlink($directorio."/subecars".$subnamerep.".asc"); //subecarsM
			    				}
			    				if(file_exists($directorio."/fleteros".$subnamerep.".asc")){
			    					unlink($directorio."/fleteros".$subnamerep.".asc"); //fleterosM
								}
			    				if(file_exists($directorio."clientes".$subnamerep.".asc")){
			    					unlink($directorio."/clientes".$subnamerep.".asc"); //clientesM
			    				}
			    				$existe = 1;
			    				$existeh = 1;

			    			}

							$archRepOrigen = $_FILES["reparto"]["tmp_name"];

							$nomarchi = $sinextension;
							//$nomarchi = repM123456
							$nomrepart = "h".$sinextension;
							//$nomrepart = hrepM123456
							$archRepDestino = "vistas/archivos/repartos/".$_POST["repSucursal"]."/".$nomarchi.".zip";
							
							if(copy($archRepOrigen, $archRepDestino)){

								if(file_exists($archRepDestino)){

									$zip = new ZipArchive;
									// Asumiendo que este script está en el mismo directorio del zip, de lo contrario
									// puedes darle la ruta absoluta del archivo 
									$res = $zip->open($archRepDestino);

									if ($res === TRUE) {
									  	
									  	$zip->extractTo($directorio);
									  	
									  	$zip->close();

									  	//chmod($directorio."/*.asc", 777);

									  	$archrep = $nomarchi.".asc";
									  	//$nomarchi = repM131375
									  	//$archrep = vistas/archivos/repartos/M/123456/repM123456.asc
									  	$archead = $nomrepart.".asc";
									  	//archead = vistas/archivos/repartos/M/123456/hrepM123456.asc
									  	//var_dump($archead);
									  	$cabezarep = fopen("vistas/archivos/repartos/".$_POST["repSucursal"]."/".$nomrepart.".asc", "r");
									  	//var_dump($cabezarep);
									  	
									  	$tablahrep = "hrepartos";

									  	while ($datahrep = fgetcsv($cabezarep, 1000, ",")){
									    		//var_dump($datahrep);
											
									    	if(isset($datahrep[0])){

									    		$itemh1 = "codoff";
									    		$itemh2 = "repnum";
									    		$valorh1 = $datahrep[1];
									    		$valorh2 = $datahrep[3];

									    		$exishrep = ModeloArchivo::mdlMostrarRegistroH($tablahrep, $itemh1, $valorh1, $itemh2, $valorh2);

									    		if($exishrep != ""){

													$itemhrep1 = "codoff";
													$itemhrep2 = "repnum";
													$datoreph1 = $datahrep[1];
													$datoreph2 = $datahrep[3];
 
											  		$borrareph = ModeloArchivo::mdlBorrarRegistroH($tablahrep, $itemhrep1, $datoreph1, $itemhrep2, $datoreph2);
											  		//var_dump($borrareph);
											  		if($borrareph = "ok"){

											  			$respuestah = ModeloArchivo::mdlSubirHreparto($tablahrep, $datahrep);

									    			}

									    		}else{

									    			$respuestah = ModeloArchivo::mdlSubirHreparto($tablahrep, $datahrep);
									    			//var_dump($respuestah);

									    		}

										   	}

										}

										$rep = fopen("vistas/archivos/repartos/".$_POST["repSucursal"]."/".$nomarchi.".asc", "r"); //abre el archivo en solo lectura

								    	//var_dump($rep);
								    	$tabla = "repartos";
								    	
								    	$subio = 0;

								    	while ($datarep = fgetcsv($rep, 1000, ",")){
								    		//var_dump($datarep);
								    		if(isset($datarep[0])){

								    			$item1 = "codoff";
									    		$item2 = "repnro";
									    		$item3 = "nguia";
									    		$valor1 = $datarep[1];
									    		$valor2 = $datarep[3];
									    		$valor3 = $datarep[5];

									    		$exisrep = ModeloArchivo::mdlMostrarRegistro($tabla, $item1, $valor1, $item2, $valor2, $item3, $valor3);

									    		if($exisrep != ""){

													$itemrep1 = "codoff";
													$itemrep2 = "repnro";
													$itemrep3 = "nguia";
													$datorep1 = $datarep[1];
													$datorep2 = $datarep[3];
													$datorep3 = $datarep[5];
 
											  		$borrarep = ModeloArchivo::mdlBorrarRegistro($tabla, $itemrep1, $datorep1, $itemrep2, $datorep2, $itemrep3, $datorep3);
											  		//var_dump($borrarep);
											  		if($borrarep = "ok"){

											  		 	$respuesta = ModeloArchivo::mdlSubirReparto($tabla, $datarep);

										    			if($respuesta == "ok"){

												    		$subio++;
											    		//var_dump($subio);

												    	}
			
									    		 	}

									    		}else{
										    		//var_dump($datarep);
										    		$respuesta = ModeloArchivo::mdlSubirReparto($tabla, $datarep);
										    		//var_dump($respuestah);

									    			if($respuesta == "ok"){

											    		$subio++;
											    		//var_dump($subio);

											    	}

											    }

								    		}

										}


								    	if(file_exists($directorio."clientes".$subnamerep.".asc")){
											
											$clientes = fopen("vistas/archivos/repartos/".$_POST["repSucursal"]."/clientes".$_POST["repSucursal"].".asc", "r");

											$tablacli = "clientes";

											while ($datacli = fgetcsv($clientes, 1000, ",")) {
													
												if(isset($datacli[0])){

													$itemclie = "codcli";
													$datoscli = $datacli[1];

													$exiscli = ModeloClientes::mdlMostrarClientes($tablacli, $itemclie, $datoscli);

													if($exiscli != ""){

														$canticar = $exiscli["totalcars"];
														$borracli = ModeloClientes::mdlBorrarCliente($tablacli, $datoscli);

														if($borracli == "ok"){

															$respuestacli = Modeloclientes::mdlIngresarCliente($tablacli, $datacli);


												    		$item1 = "totalcars";
												    		$valor1 = $canticar;
												    		$valorcli = $datacli[1];

												    		$totcarcli = ModeloClientes::mdlActualizaCarCliente($tablacli, $item1, $valor1, $valorcli);

														}

													}else{

														$respuestacli = Modeloclientes::mdlIngresarCliente($tablacli, $datacli);

													}

												}
													
											}

										}

										if(file_exists($directorio."/fleteros".$subnamerep.".asc")){
											
											$fleteros = fopen("vistas/archivos/repartos/".$_POST["repSucursal"]."/fleteros".$_POST["repSucursal"].".asc", "r");

											$tablafle = "fleteros";

											while ($dataflet = fgetcsv($fleteros, 1000, ",")) {

												if(isset($dataflet[0])){

													$itemfle = "cuitfle";
													$datosfle = $dataflet[1];

													$exisfle = ModeloFleteros::mdlMostrarFleteros($tablafle, $itemfle, $datosfle);
													//var_dump($exisfle);
													if($exisfle != ""){

													 	$borrafle = ModeloFleteros::mdlBorrarFletero($tablafle, $datosfle);

														if($borrafle == "ok"){

													 		$respuestafle = ModeloFleteros::mdlIngresarFleteros($tablafle, $dataflet);

													 	}

													}else{

													 	$respuestafle = ModeloFleteros::mdlIngresarFleteros($tablafle, $dataflet);

													}

												}	
													
											}

										}

										if(file_exists($directorio."/subecars".$subnamerep.".asc")){

											$car = fopen("vistas/archivos/repartos/".$_POST["repSucursal"]."/subecars".$_POST["repSucursal"].".asc", "r");

											$tabla = "tb_cars";
									    	
									    	$subiocar = 0;
									    	
									    	while ($datacar = fgetcsv($car, 1000, ",")){
									    		//var_dump($datacar);
									    		if(isset($datacar[0])){

									    			// COMPRUEBO SI EL CLIENTE DEL REGISTRO EXISTE, SI NO EXISTE NO GRABO EL REGISTRO Y LO INFORMO
									    			// $tablacli = "clientes";
									    			// $itemcli = "codcli";
									    			// $valorcli = $datacar[1];
									    			
									    			// $existecli = ModeloClientes::mdlMostrarClientes($tablacli, $itemcli, $valorcli);
									    			// //var_dump($existecli);
									    			// if($existecli != ""){

									    			$item1 = "codcli";
									    			$item2 = "nguia";
									    			$item3 = "reparto";
									    			$valor1 = $datacar[1];
									    			$valor2 = $datacar[4];
									    			$valor3 = $datacar[12];
									    			
									    			$revisa = ModeloArchivo::mdlBuscarCarsArch($tabla, $item1, $valor1, $item2, $valor2, $item3, $valor3);
									    			//var_dump($revisa);
									    			if($revisa != ""){

									    				$itemCar1 = "codcli";
									    				$itemCar2 = "nguia";
									    				$itemCar3 = "reparto";
									    				$datoCar1 = $datacar[1];
									    				$datoCar2 = $datacar[4];
									    				$datoCar3 = $datacar[12];

									    				$borraCar = ModeloCars::mdlBorrarCarArch($tabla, $itemCar1, $datoCar1, $itemCar2, $datoCar2, $itemCar3, $datoCar3);

									    				if($borraCar == "ok"){

									    					$respuestacar = ModeloArchivo::mdlSubirCars($tabla, $datacar);
										    				
									    				}

									    			}else{
									    				//var_dump($datacar);
									    				// $traercliente = ModeloClientes::mdlMostrarClientes($tablacli, $itemcli, $valorcli);
									    				// //var_dump($traercliente["totalcars"]);
									    				// $carsclien = $traercliente["totalcars"] + 1;
									    				// //var_dump($carsclien);
									    				// $tablacli = "clientes";
									    				// $item1 = "totalcars";
									    				// $valor1 = $carsclien;

									    				// $totcarcli = ModeloClientes::mdlActualizaCarCliente($tablacli, $item1, $valor1, $valorcli);
									    				
									    				$respuestacar = ModeloArchivo::mdlSubirCars($tabla, $datacar);
									    				//var_dump($respuestacar);
									    				$subiocar++;

									    			}

										    		//}

									    		}

									  		}

									  	}

										if($subio > 0){

											if($respuesta == "ok"){

												echo '<script>

												 	swal({
												 	 	type: "success",
												 	 	title: "¡El Archivo ha subido Correctamente!",
												 	 	showConfirmButton: true,
												 	 	confirmButtonText: "Cerrar",
												 	 	closeOnConfirm: false

												 	 	}).then((result)=>{

												 			if(result.value){
															
												 				window.location = "sube-reparto";
															
												 			}
														
												 		})

												</script>';

											}else{

												echo '<script>

												 	swal({
												 	 	type: "error",
												 	 	title: "¡El Archivo NO pudo ser procesado! Avise a Sistemas",
												 	 	showConfirmButton: true,
												 	 	confirmButtonText: "Cerrar",
												 	 	closeOnConfirm: false

												 	 	}).then((result)=>{

												 			if(result.value){
															
												 				window.location = "sube-reparto";
															
												 			}
														
												 		})


												 </script>';

											}

										}else{

											echo '<script>

											 	swal({
											 	 	type: "error",
											 	 	title: "¡No Hay datos para Actualizar!",
											 	 	showConfirmButton: true,
											 	 	confirmButtonText: "Cerrar",
											 	 	closeOnConfirm: false

											 	 	}).then((result)=>{

											 			if(result.value){
														
											 				window.location = "sube-reparto";
														
											 			}
													
											 		})


											 </script>';

										}
									  
									} else {
									  
									  echo '<script>

										 	swal({
										 	 	type: "error",
										 	 	title: "¡No fue posible abrir archivo ZIP!",
										 	 	showConfirmButton: true,
										 	 	confirmButtonText: "Cerrar",
										 	 	closeOnConfirm: false

										 	 	}).then((result)=>{

										 			if(result.value){
													
										 				window.location = "sube-reparto";
													
										 			}
												
										 		})

										</script>';
									}

								}

							}

							$archexis = substr($repname, 0,-4);

			    			$archexish = "h".substr($repname, 0,-4);

							unlink($directorio."/".$archexis.".asc"); //repM123456

		    				unlink($directorio."/".$archexish.".asc"); //hrepM123456
		    				
		    				if(file_exists($directorio."/subecars".$subnamerep.".asc")){
		    					unlink($directorio."/subecars".$subnamerep.".asc"); //subecarsM
		    				}
		    				if(file_exists($directorio."/fleteros".$subnamerep.".asc")){
		    					//unlink($directorio."/fleteros".$subnamerep.".asc"); 
		    					//fleterosM
							}
		    				if(file_exists($directorio."/clientes".$subnamerep.".asc")){
		    					unlink($directorio."/clientes".$subnamerep.".asc"); //clientesM
		    				}

						}

					}else {
									  
					  	echo '<script>

						 	swal({
						 	 	type: "error",
						 	 	title: "¡OJO aca esta el error!",
						 	 	showConfirmButton: true,
						 	 	confirmButtonText: "Cerrar",
						 	 	closeOnConfirm: false

						 	 	}).then((result)=>{

						 			if(result.value){
									
						 				window.location = "sube-reparto";
									
						 			}
								
						 		})

						</script>';
					}

				}

			}

		}

	}

	/*=============================================
	SUBE ARCHIVO DE FLETEROS
	=============================================*/
	
	static public function ctrSubirFletero(){

		if(isset($_FILES["fletero"])){
			
		    $flename = $_FILES["fletero"]["name"];
		    //var_dump($cliename);
		    if($flename == ""){

		    	echo '<script>

				 	swal({
				 	 	type: "error",
				 	 	title: "¡Seleccione un Archivo para subir!",
				 	 	showConfirmButton: true,
				 	 	confirmButtonText: "Cerrar",
				 	 	closeOnConfirm: false

				 	 	}).then((result)=>{

				 			if(result.value){
							
				 				window.location = "sube-bases";
							
				 			}
						
				 		})

				 </script>';

		    }else{

			    $subname = substr($flename, 8,1);
			    //var_dump($subname);
			   	if($_POST["fleSucursal"] == "#"){

			   		echo '<script>

					 	swal({
					 	 	type: "error",
					 	 	title: "¡Seleccione la Sucursal a la que pertenece!",
					 	 	showConfirmButton: true,
					 	 	confirmButtonText: "Cerrar",
					 	 	closeOnConfirm: false

					 	 	}).then((result)=>{

					 			if(result.value){
								
					 				window.location = "sube-bases";
								
					 			}
							
					 		})

					 </script>';

				}else{
			   		//var_dump($_POST["carSucursal"]);
				    $sucursal = $_POST["fleSucursal"];

				    if(strcmp($subname,$sucursal) === 0){

				    	if(isset($_FILES["fletero"]["tmp_name"])){

				    		$directorio = "vistas/archivos/fleteros/".$_POST["fleSucursal"];

			    			if(file_exists($directorio)){

			    			}else{
			    				
			    				mkdir($directorio, 0755);

							}

							$archFleOrigen = $_FILES["fletero"]["tmp_name"];

							date_default_timezone_set('America/Argentina/Mendoza');
								
							$fecha = date('Y-m-d');

							$nomarchi = substr($flename, 0,-4);

							$archivo = $nomarchi.$fecha;

							$archFleDestino = "vistas/archivos/Fleteros/".$_POST["fleSucursal"]."/".$archivo.".asc";
							
							if(copy($archFleOrigen, $archFleDestino)){

						    	if(file_exists($archFleDestino)){

							    	$flete = fopen($archFleDestino, "r");

							    	$tabla = "fleteros";

							    	$subio = 0;
							    	
							    	while ($data = fgetcsv($flete, 1000, ",")){
							    		//var_dump($data);
							    		if(isset($data[1])){

							    			$item = "cuitfle";
							    			$valor = $data[1];
							    			
							    			
							    			$revisa = ModeloFleteros::mdlMostrarFleteros($tabla, $item, $valor);
							    			if($revisa == ""){
							    				//var_dump($data[6]);
							    				$respuesta = ModeloArchivo::mdlSubirFleteros($tabla, $data);

							    				$subio++;

							    			}

							    			//$data[6]="";
							    		}

									}

									if($subio > 0){

										if($respuesta == "ok"){

											echo '<script>

											 	swal({
											 	 	type: "success",
											 	 	title: "¡El Archivo ha subido Correctamente!",
											 	 	showConfirmButton: true,
											 	 	confirmButtonText: "Cerrar",
											 	 	closeOnConfirm: false

											 	 	}).then((result)=>{

											 			if(result.value){
														
											 				window.location = "fleteros";
														
											 			}
													
											 		})

											 </script>';

										}else{

											echo '<script>

											 	swal({
											 	 	type: "error",
											 	 	title: "¡El Archivo NO pudo ser procesado!",
											 	 	showConfirmButton: true,
											 	 	confirmButtonText: "Cerrar",
											 	 	closeOnConfirm: false

											 	 	}).then((result)=>{

											 			if(result.value){
														
											 				window.location = "sube-reparto";
														
											 			}
													
											 	})

											 </script>';

										}

									}else{

										echo '<script>

										 	swal({
										 	 	type: "error",
										 	 	title: "¡No Hay datos para Actualizar!",
										 	 	showConfirmButton: true,
										 	 	confirmButtonText: "Cerrar",
										 	 	closeOnConfirm: false

										 	 	}).then((result)=>{

										 			if(result.value){
													
										 				window.location = "sube-reparto";
													
										 			}
												
										 		})


										 </script>';

									}

							    }else{

							    	echo '<script>

									 	swal({
									 	 	type: "error",
									 	 	title: "¡No Existe archivo archFleDestino!",
									 	 	showConfirmButton: true,
									 	 	confirmButtonText: "Cerrar",
									 	 	closeOnConfirm: false

									 	 	}).then((result)=>{

									 			if(result.value){
												
									 				window.location = "sube-reparto";
												
									 			}
											
									 		})


									 </script>';
							    }

						    }else{

						    	echo '<script>

								 	swal({
								 	 	type: "error",
								 	 	title: "¡Falló COPY!",
								 	 	showConfirmButton: true,
								 	 	confirmButtonText: "Cerrar",
								 	 	closeOnConfirm: false

								 	 	}).then((result)=>{

								 			if(result.value){
											
								 				window.location = "sube-reparto";
											
								 			}
										
								 		})


								 </script>';

						    }

				    	}else{

				    		echo '<script>

							 	swal({
							 	 	type: "error",
							 	 	title: "¡El Archivo Temporal no encontrado!",
							 	 	showConfirmButton: true,
							 	 	confirmButtonText: "Cerrar",
							 	 	closeOnConfirm: false

							 	 	}).then((result)=>{

							 			if(result.value){
										
							 				window.location = "sube-reparto";
										
							 			}
									
							 		})


							 </script>';

				    	}

					}else{

						echo '<script>

						 	swal({
						 	 	type: "error",
						 	 	title: "¡El Archivo a subir NO pertenece a la Sucursal!",
						 	 	showConfirmButton: true,
						 	 	confirmButtonText: "Cerrar",
						 	 	closeOnConfirm: false

						 	 	}).then((result)=>{

						 			if(result.value){
									
						 				window.location = "sube-reparto";
									
						 			}
								
						 		})


						 </script>';

					}

				} 

			} 

		}

	}

}

