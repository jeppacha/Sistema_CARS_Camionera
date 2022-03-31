/*=============================================
SUBIENDO FOTO DEL FLETERO
=============================================*/

$(".nuevaFotoFle").change(function(){

	var imagen = this.files[0];

	/*=============================================
	VALIDA FORMATO DE LA IMAGEN
	=============================================*/
	
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

		$(".nuevaFotoFle").val("");

		swal({

		 	type: "error",
		 	
		 	title: "¡La imagen debe estar en formato JPG o PNG!",
		 	
		 	confirmButtonText: "¡Cerrar!"

		 	});


	}else if(imagen["size"] > 5000000){

		$(".nuevaFotoFle").val("");

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

			$(".previsualizarFle").attr("src", rutaImagen);

		})

	}

})

/*=============================================
=          EDITAR FLETERO                    =
=============================================*/
$(document).on("click",".btnEditarFletero",function(){

	var idFletero = $(this).attr("idFletero");
	//console.log("idFletero", idFletero);
	var datos = new FormData();
	datos.append("idFletero", idFletero);

	$.ajax({

		url:"ajax/fleteros.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			//console.log("respuesta",respuesta);
			$("#editarCuit").val(respuesta["cuitfle"]);
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarUsuario").val(respuesta["usuario"]);
			$("#actualSucursal").val(respuesta["sucadm"]);
			$("#passwordActual").val(respuesta["password"]);
			$("#fotoActual").val(respuesta["foto"]);
			
			if(respuesta["foto"] != ""){
				
				$(".previsualizarFle").attr("src",respuesta["foto"]);

			}else{

				$(".previsualizarFle").attr("src","vistas/img/fleteros/default/default_fletero.png");

			}

			if(respuesta["usuario"] == ""){

				$(".editarUsuario").removeAttr("readonly");
			
			}

			if(respuesta["password"] != ""){
				//console.log("password", respuesta["password"]);
				$(".editarPassword").removeAttr("required");

				$(".editarPassword").attr("placeholder","Ingrese nueva Clave, si desea cambiarla");

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

	 		$("#editarSucursal").val(respuestasuc["denom"]);

	 	}

	});
})

/*=============================================
ACTIVAR FLETERO
=============================================*/

$(document).on("click",".btnActivarFle",function(){

	var idFletero = $(this).attr("idFletero");
	var estadoFletero = $(this).attr("estadoFletero");
	//console.log("estadoFletero", estadoFletero); 
	var datos = new FormData();
	datos.append("activarId", idFletero); 
	datos.append("activarFletero", estadoFletero); 

	$.ajax({

		url:"ajax/fleteros.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){

			if(window.matchMedia("(max-width:1280px)").matches){
				swal({
					title: "El fletero ha sido actualizado",
					type: "success",
					confirmButtonText: "¡Cerrar!"
				}).then(function(result){
					if(result.value){

						window.location = "fleteros";

					}

				});

			}

		}

	})

	if(estadoFletero == 0){

		$(this).removeClass('btn-success');
		$(this).addClass('btn-danger');
		$(this).html('Inactivo');
		$(this).attr('estadoFletero',1);
	
	}else{

		$(this).addClass('btn-success');
		$(this).removeClass('btn-danger');
		$(this).html('Activo');
		$(this).attr('estadoFletero',0);

	}

})

/*=============================================
REVISAR USUARIO FLETERO REPETIDO
=============================================*/

$("#nuevoUsuario").change(function(){

	$(".alert").remove();

	var fletero = $(this).val();

	var datos = new FormData();
	datos.append("validarFletero", fletero);

	$.ajax({

		url:"ajax/fleteros.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			if(respuesta){

				$("#nuevoUsuario").parent().after('<div class="alert-warning">Este Fletero ya existe en Sistema</div>');

				$("#nuevoUsuario").val(""); 
			}
		}

	})

})

/*=============================================
ELIMINAR FLETERO
=============================================*/

$(document).on("click",".btnEliminarFletero",function(){

	var idFletero = $(this).attr("idFletero");
	
	var fotoFletero = $(this).attr("fotoFletero");

	var usuario = $(this).attr("usuario");

	swal({
		title: '¿Está seguro de borrar al Fletero?',
		text: "¡Si no lo está, puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: '¡Si!, Borrar Fletero'
	}).then((result)=>{

		if(result.value){
			
			window.location = "index.php?ruta=fleteros&idFletero="+idFletero+"&usuario="+usuario+"&fotoFletero="+fotoFletero;

		}

	})

})


