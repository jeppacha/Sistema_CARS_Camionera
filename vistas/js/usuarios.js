/*=============================================
SUBIENDO FOTO DEL USUARIO
=============================================*/

$(".nuevaFoto").change(function(){

	var imagen = this.files[0];

	/*=============================================
	VALIDA FORMATO DE LA IMAGEN
	=============================================*/
	
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

		$(".nuevaFoto").val("");

		swal({

		 	type: "error",
		 	
		 	title: "¡La imagen debe estar en formato JPG o PNG!",
		 	
		 	confirmButtonText: "¡Cerrar!"

		 	});


	}else if(imagen["size"] > 5000000){

		$(".nuevaFoto").val("");

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

			$(".previsualizar").attr("src", rutaImagen);

		})

	}

})

/*=============================================
=          EDITAR USUARIO                    =
=============================================*/
$(document).on("click",".btnEditarUsuario",function(){
 
	var idUsuario = $(this).attr("idUsuario");
	
	var usuario = $(this).attr("usuario");
	 
	var datos = new FormData();
	datos.append("idUsuario", idUsuario);
	
	$.ajax({

	 	url:"ajax/usuarios.ajax.php",
	 	method: "POST",
	 	data: datos,
	 	cache: false,
	 	contentType: false,
	 	processData: false,
	 	dataType: "json",
	 	success: function(respuesta){

	 		//console.log("respuesta", respuesta);
	 		// $("#idUsuario").val(respuesta["id"]);
	 		$("#editarId").val(respuesta["id"]);
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarUsuario").val(respuesta["usuario"]);
			$("#actualSucursal").val(respuesta["id_oficina"]);
			$("#editarPerfil").html(respuesta["perfil"]);
			$("#editarPerfil").val(respuesta["perfil"]);
			$("#passwordActual").val(respuesta["password"]);
			$("#fotoActual").val(respuesta["foto"]);
			$("#editarEstado").val(respuesta["estado"]);
			$("#editarUltimo_loguin").val(respuesta["ultimo_loguin"]);
			$("#editarFecha_alta").val(respuesta["fecha_alta"]);
			id_oficina = respuesta["id_oficina"];

			//console.log("foto", respuesta["foto"]);
			if(respuesta["foto"] != ""){

				$(".previsualizar").attr("src", respuesta["foto"]);

			}else{

				$(".previsualizar").attr("src","vistas/img/usuarios/default/anonymous.png");

			}

			if(respuesta["usuario"] == ""){

				$(".editaUsuario").removeAttr("readonly");
			
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
	 		//console.log("respuestasuc",respuestasuc);
	 		$("#editarSucursal").val(respuestasuc["denom"]);

	 	}

	});

})

/*=============================================
ACTIVAR USUARIO
=============================================*/

$(document).on("click",".btnActivar",function(){

	var idUsuario = $(this).attr("idUsuario");
	var estadoUsuario = $(this).attr("estadoUsuario");
	//console.log("estadoUsuario", estadoUsuario); 
	var datos = new FormData();
	datos.append("activarId", idUsuario); 
	datos.append("activarUsuario", estadoUsuario); 

	$.ajax({

		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){

			if(window.matchMedia("(max-width:767px)").matches){
				swal({
					title: "El Usuario ha sido actualizado",
					type: "success",
					confirmButtonText: "¡Cerrar!"
				}).then(function(result){
					if(result.value){

						window.location = "usuarios";

					}

				});

			}

		}

	})

	if(estadoUsuario == 0){

		$(this).removeClass('btn-success');
		$(this).addClass('btn-danger');
		$(this).html('Inactivo');
		$(this).attr('estadoUsuario',1);
	
	}else{

		$(this).addClass('btn-success');
		$(this).removeClass('btn-danger');
		$(this).html('Activo');
		$(this).attr('estadoUsuario',0);

	}

})

/*=============================================
REVISAR USUARIO REPETIDO
=============================================*/

$("#nuevoUsuario").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarUsuario", usuario);

	$.ajax({

		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			if(respuesta){

				$("#nuevoUsuario").parent().after('<div class="alert-warning">Este Usuario ya existe en Sistema</div>');

				$("#nuevoUsuario").val(""); 
			}
		}

	})

})

/*=============================================
ELIMINAR USUARIO
=============================================*/

$(document).on("click",".btnEliminarUsuario",function(){

	var perfil = $(this).attr("perfil");
	
	var idUsuario = $(this).attr("idUsuario");
	// var offices = $(this).attr()
	var fotoUsuario = $(this).attr("fotoUsuario");
	var usuario = $(this).attr("usuario");
	var userCodcli = $(this).attr("codcli")
	var fotoCliente = "";

	var datos = new FormData();
	datos.append("userCodcli", userCodcli);

	$.ajax({

	 	url:"ajax/clientes.ajax.php",
	 	method: "POST",
	 	data: datos,
	 	cache: false,
	 	contentType: false,
	 	processData: false,
	 	dataType: "json",
	 	success: function(respuesta){
	 		//console.log(respuesta["foto"]);
	 		fotoCliente = respuesta["foto"];

		}

	});


	//console.log("codcli",codcli);
	if(perfil === "Cliente"){
		// console.log("codcli",codcli);
		// console.log("perfil",perfil);
		//console.log("fotoCliente",fotoCliente);
		swal({
		title: '¿Está seguro de borrar el usuario?',
		text: "¡ ATENCION:  Ésta acción también eliminará los CARS!    Si no lo está, puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Borrar Usuario'
		}).then((result)=>{

			if(result.value){
			
				window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario+"&perfil="+perfil+"&codcli="+codcli+"&fotoCliente="+fotoCliente;

			}

		})

	}else{
		//console.log("No Cliente",codcli);

		swal({
		title: '¿Está seguro de borrar el usuario?',
		text: "¡Si no lo está, puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Borrar Usuario'
		}).then((result)=>{

			if(result.value){
			
				window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;

			}

		})

	}
	
})

/*=============================================
COLOCA COD CLI O LEGAJO EN ALTA DE USUARIOS
=============================================*/

$("#nuevoPerfil").change(function(){

	var codigo = $(this).val();

	//console.log(codigo);
	$(".sucur").hide();
	$(".cajaCliente_legajo").hide();
	$(".cajaDatosCliente").hide();
	$(".separa").hide();

	if(codigo == "Operador"){

		$(".sucur").show();
		$(".cajaCliente_legajo").show();
		$(".cajaDatosCliente").show();
		//$(".separa").hide();
		
		$(this).parent().parent().parent().parent().children().children().children(".cajaCliente_legajo").html(

			'<br>'+

			'<div class="input-group">'+

				'<span class="input-group-addon"><i class="fa fa-user"></i></span>'+

				'<input type="text" class="form-control input-lg nuevoPerfilOpera" name="nuevoCodcliLegajo" placeholder="Legajo Operador" required>'+

			'</div>'

		)

		$(this).parent().parent().parent().parent().children().children().children(".cajaDatosCliente").html(
				
			'<div class="input-group">'+

				'<br>'+
				'<br>'+
				'<br>'+
				'<br>'+

			'</div>'

		)

	}else if(codigo == "Cliente"){

		$(".cajaCliente_legajo").show();
		$(".cajaDatosCliente").show();
		$(".sucur").hide();
		$(".separa").show();

		$(this).parent().parent().parent().parent().children().children(".separa").html(

			'<div class="input-group">'+

					'<span class="input-group-addon"><i class="fa fa-code"></i></span>'+

					'<input type="text" class="form-control input-lg nuevoPerfilOpera" name="nuevoCodcliCliente" placeholder="Codigo Cliente" required>'+

			'</div>'
				
		)

		$(this).parent().parent().parent().parent().children().children().children(".cajaCliente_legajo").html(

			'<br>'+

			'<div class="input-group">'+

				'<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+

				'<input type="text" class="form-control input-lg" name="nuevoEmailClien" placeholder="Email Cliente" required>'+

			'</div>'

		)

		$(this).parent().parent().parent().parent().children().children().children(".cajaDatosCliente").html(

			'<br>'+
				
			'<div class="input-group">'+

				'<span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>'+

				'<input type="text" class="form-control input-lg" name="nuevoCuitClien" placeholder="C.U.I.T. Cliente" required>'+

			'</div>'

		)

	}else if(codigo == "Administrador"){

		$(".sucur").show();
		$(".pepara").hide();
		$(".cajaDatosCliente").hide();
		$(".cajaCliente_legajo").hide();

		$(this).parent().parent().parent().children(".cajaCliente_legajo").html(

			'<div class="col-xs-6" style:"padding-left:0px">'+

				'<div class="input-group">'+

					// '<select class="form-control input-lg" id="seleccionarOficina" name="seleccionarOficina" requires>'+
					// 	'<option value="">Seleccionar Oficina</option>'+

					'</select>'+
					
				'</div>'+
				
			'</div>'

		)
	}

})

/*=============================================
COLOCA COD CLI O LEGAJO EN EDITAR USUARIOS
=============================================*/

$(document).on("click",".btnEditarUsuario",function(){

	var codigo = $(this).val();

	//console.log(codigo);

	if(codigo == "Operador"){

		//$(this).parent().parent().addClass("col-xs-6");

		$(this).parent().parent().parent().children(".editarCajaCliente_legajo").html(

			'<div class="col-xs-5" style:"padding-left:0px">'+

				'<div class="input-group">'+

					'<input type="text" class="form-control input-lg nuevoPerfilOpera" name="nuevoPerfilOpera" placeholder="Legajo Operador" required>'+

				'</div>'+
				
			'</div>'

		)

	}else if(codigo == "Cliente"){

		//$(this).parent().parent().addClass("col-xs-6");

		$(this).parent().parent().parent().children(".editarCajaCliente_legajo").html(

			'<div class="col-xs-5" style:"padding-left:0px">'+

				'<div class="input-group">'+

					'<span class="input-group-addon"><i class="fa fa-code"></i></span>'+

					'<input type="text" class="form-control input-lg" name="nuevoPerfilClien" placeholder="Codigo Cliente" required>'+

				'</div>'+
				
			'</div>'+

			'<div></div>'+

			'<div class="col-xs-7" style:"padding-left:0px">'+

				'<div class="input-group">'+

					'<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+

					'<input type="text" class="form-control input-lg" name="nuevoEmailClien" placeholder="Email Cliente" required>'+

				'</div>'+
				
			'</div>'+

			'<div class="col-xs-5" style:"padding-rigth:0px">'+

				'<div class="input-group">'+

					'<span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>'+

					'<input type="text" class="form-control input-lg" name="nuevoCuitClien" placeholder="C.U.I.T. Cliente" required>'+

				'</div>'+
				
			'</div>'

		)

	}else if(codigo == "Administrador"){

		$(this).parent().parent().parent().children(".cajaCliente_legajo").html(

			'<div class="col-xs-5" style:"padding-left:0px">'+

				'<div class="input-group">'+

					'<input type="hidden" class="form-control input-lg" id="nuevoPerfilAdmin">'+

				'</div>'+
				
			'</div>'

		)
	}

})

