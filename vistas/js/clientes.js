
/*=============================================
SUBIENDO FOTO/LOGO DEL CLIENTE
=============================================*/

$(".editarFotoCli").change(function(){

	var imagen = this.files[0];

	/*=============================================
	VALIDA FORMATO DE LA IMAGEN
	=============================================*/
	
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

		$(".editarFotoCli").val("");

		swal({

		 	type: "error",
		 	
		 	title: "¡La imagen debe estar en formato JPG o PNG!",
		 	
		 	confirmButtonText: "¡Cerrar!"

		 	});


	}else if(imagen["size"] > 5000000){

		$(".editarFotoCli").val("");

		swal({

		 	type: "error",

		 	title: "¡La imagen debe ser menor a 5 Mb!",

		 	confirmButtonText: "¡Cerrar!"

		 	});

	}else{

		var datosImagen = new FileReader;

		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(event){

			var rutaImagen = event.target.result;

			$(".visualizaCli").attr("src", rutaImagen);

		})

	}

})

/*=============================================
=          EDITAR CLIENTE                   =
=============================================*/
$(document).on("click",".btnEditarCliente",function(){

	//console.log("entre"); 
	var idCliente = $(this).attr("idCliente");
	//console.log("idUsuario", idUsuario); 
	var datos = new FormData();
	datos.append("idCliente", idCliente);

	$.ajax({

	 	url:"ajax/clientes.ajax.php",
	 	method: "POST",
	 	data: datos,
	 	cache: false,
	 	contentType: false,
	 	processData: false,
	 	dataType: "json",
	 	success: function(respuesta){

	 		//console.log("respuesta", respuesta);
			$("#idCliente").val(respuesta["id"]);
			$("#editarCodCli").val(respuesta["codcli"]);
			$("#actualSucAdm").val(respuesta["sucadm"]);
			$("#editarCliente").val(respuesta["nombre"]);
			$("#passwordActualCli").val(respuesta["password"]);
			$("#editarEmail1").val(respuesta["email1"]);
			$("#editarEmail2").val(respuesta["email2"]);
			$("#editarEmail3").val(respuesta["email3"]);
			$("#editarCuit").val(respuesta["cuit"]);
			$("#editarUsuarioCl").val(respuesta["usuario"]);
			$("#fotoActualCli").val(respuesta["foto"]);
			

			if(respuesta["foto"] != ""){

			 	$(".visualizaCli").attr("src", respuesta["foto"]);

			}else{

				$(".visualizaCli").attr("src", "vistas/img/usuarios/default/anonymous.png");
			}

			if(respuesta["usuario"] == ""){

				$(".editarUsuarioCl").removeAttr("readonly");

			}
			
			if(respuesta["password"] != ""){
				//console.log("password", respuesta["password"]);
				$(".editarPasswordCli").removeAttr("required");
				$(".editarPasswordCli").attr("placeholder","Ingrese nueva Clave, si desea cambiarla");

			}

		}

	});

	var oficina = $(this).attr("oficina");

	var datosSuc = new FormData();
	datosSuc.append("oficina", oficina);

	$.ajax({

	 	url:"ajax/sucursal.ajax.php",
	 	method: "POST",
	 	data: datosSuc,
	 	cache: false,
	 	contentType: false,
	 	processData: false,
	 	dataType: "json",
	 	success: function(respuestasuc){
//console.log("sucursal", respuestasuc["denom"]);
	 		$("#editarSucAdm").val(respuestasuc["denom"]);

	 	}

	});

})

/*=============================================
REVISAR QUE EXISTE EL CLIENTE
=============================================*/

$("#nuevoCodCli").change(function(){

	$(".alert-warning").remove();

	var cliente = $(this).val();

	var datos = new FormData();
	datos.append("validarCliente", cliente);

	$.ajax({

		url:"ajax/clientes.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			if(respuesta){

				$("#nuevoNombre").val(respuesta["nombre"]); 

			}else{

				$("#nuevoCodCli").parent().after('<div class="alert-warning">El Cliente NO existe, debe cargarlo primero</div>');
				$("#nuevoCodCli").val("");

			}

		}

	})

})
