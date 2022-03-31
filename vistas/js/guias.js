+/*=============================================
=          ENTREGA GUIA CON CAR               =
=============================================*/
$(document).on("click",".btnEntregaccli",function(){

	var nguia = $(this).attr("nguia");
	var repnro = $(this).attr("repnro");
	
	//console.log("nguia",nguia);
	var datos = new FormData();
	datos.append("nguia", nguia);
	datos.append("repnro", repnro);
	$.ajax({

	 	url:"ajax/guias.ajax.php",
	  	method: "POST",
	  	data: datos,
	  	cache: false,
	  	contentType: false,
	  	processData: false,
	  	dataType: "json",
	  	success: function(respuesta){
	  		//console.log("respuesta", respuesta);
	  		$("#editarGuiacc").val(respuesta["nguia"]);
	  		$("#editarFecRepar").val(respuesta["repfec"]);
	  		$("#codclicc").val(respuesta["codcli"]);
	  		$("#repnrocc").val(respuesta["repnro"]);
	  		$("#cuitfle").val(respuesta["cuitfle"]);
	  		$("#sucuradm").val(respuesta["codoff"]);
	  	}

	});

	var nguiacar = $(this).attr("nguiacar");
	var repnrocar = $(this).attr("repnrocar");
	//console.log("nguiacar",nguiacar);
	//console.log("repnrocar",repnrocar);
	var datos = new FormData();

	datos.append("nguiacar", nguiacar);
	datos.append("repnrocar", repnrocar);

	$.ajax({

		url:"ajax/cars.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuestacar){

			//console.log("respuestacar", respuestacar);
			$("#buscarAdmin").val(respuestacar["id_sucadm"]);
			$("#buscarNombre").val(respuestacar["nombre"]);
			$("#buscarOrg").val(respuestacar["org"]);
			$("#buscarDst").val(respuestacar["dst"]);
			$("#buscarRemitente").val(respuestacar["nomrem"]);
			$("#buscarDestinatario").val(respuestacar["nomdes"]);			
		}

	});

})

/*=============================================
=          ENTREGA GUIA SIN CAR               =
=============================================*/
$(document).on("click",".btnEntregascli",function(){

	var nguiasc = $(this).attr("nguiasc");
	var repnrosc = $(this).attr("repnrosc");
	
	//console.log("nguiasc",nguiasc);
	var datos = new FormData();
	datos.append("nguiasc", nguiasc);
	datos.append("repnrosc", repnrosc);
	$.ajax({

	 	url:"ajax/guias.ajax.php",
	  	method: "POST",
	  	data: datos,
	  	cache: false,
	  	contentType: false,
	  	processData: false,
	  	dataType: "json",
	  	success: function(respuesta){
	  		//console.log("respuesta", respuesta);
	  		$("#editarGuiasc").val(respuesta["nguia"]);
	  		$("#editarFecReparsc").val(respuesta["repfec"]);

	  		$("#repnrosc").val(respuesta["repnro"]);
	  		$("#cuitflesc").val(respuesta["cuitfle"]);
	  		$("#sucuradmsc").val(respuesta["codoff"]);
	  		$("#codclisc").val(respuesta["codcli"]);


	  	}

	})

})

/*=============================================
=          MOTIVO DE NO ENTREGA DE GUIA       =
=============================================*/
$(document).on("click",".btnMotivo",function(){

	var motinguia = $(this).attr("motinguia");
	var motirepnro = $(this).attr("motirepnro");
	
	//console.log("motinguia",motinguia);
	var datos = new FormData();
	datos.append("motinguia", motinguia);
	datos.append("motirepnro", motirepnro);
	$.ajax({

	 	url:"ajax/guias.ajax.php",
	  	method: "POST",
	  	data: datos,
	  	cache: false,
	  	contentType: false,
	  	processData: false,
	  	dataType: "json",
	  	success: function(respuesta){
	  		//console.log("respuesta", respuesta);
	  		$("#muestraGuia").val(respuesta["nguia"]);
	  		$("#muestraFecha").val(respuesta["repfec"]);
	  		$("#motivoNoEntrega").val(respuesta["motivo"]);

	  	}

	})

})

/*=============================================
REVISAR GUIA REPETIDA
=============================================*/

$("#nuevaGuia").change(function(){

	$(".alert-warning").remove();

	var guia = $(this).val();

	var datos = new FormData();
	datos.append("validarGuia", guia);

	$.ajax({

		url:"ajax/guias.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			if(respuesta){

				$("#nuevoGuia").parent().after('<div class="alert-warning">La Guia ya Existe</div>');
				$("#nuevoGuia").val("");

			}

		}

	})

})