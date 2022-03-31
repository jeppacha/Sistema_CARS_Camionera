/*=============================================
VARIABLE DE LOCAL STORAGE
=============================================*/

if(localStorage.getItem("capturarRango") != null){

	// var rango = localStorage.getItem("capturarRango");
	// //console.log("rango",rango);

	// $("#daterange-btn span").html(rango);

	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));

}else{

	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de Fechas a Seleccionar');

}

/*=============================================
SUBIENDO PDF DEL REMITO CONFORMADO (CARS)
=============================================*/

$(".nuevoPdf").change(function(){

	var imagen = this.files[0];

	//console.log("imagen", imagen);
	/*=============================================
	VALIDA FORMATO DE LA IMAGEN
	=============================================*/
	if(imagen["type"] == "image/jpeg"){

		if(imagen["size"] > 5000000){

			$(".nuevoPdf").val("");

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

	}else if(imagen["type"] == "image/png"){

		if(imagen["size"] > 5000000){

			$(".nuevoPdf").val("");

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

	}else if(imagen["type"] == "application/pdf"){

		if(imagen["size"] > 5000000){

			$(".nuevoPdf").val("");

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
				//console.log("rutaImagen", rutaImagen);
				$(".previsualizar").attr("src", rutaImagen);

			})

		}

	}else{

		$(".nuevoPdf").val("");

		swal({

	 		type: "error",
	 	
	 		title: "¡La imagen debe estar en formato PNG, JPG o PDF!",
	 	
	 		confirmButtonText: "¡Cerrar!"

	 	});
	
	}



})

/*=============================================
EDITAR CARS
=============================================*/

$(".tablas").on("click",".btnEditarCar",function(){

	var idCar = $(this).attr("idCar");

	//var editrecib = "";
	//var editentreg = "";

	//console.log("idCar", idCar);

	var datos = new FormData();

	datos.append("idCar", idCar);

	$.ajax({

		url:"ajax/cars.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			//console.log("respuesta", respuesta);
			$("#editarCodCli").val(respuesta["codcli"]);
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarGuia").val(respuesta["nguia"]);
			$("#actualOrg").val(respuesta["org"]);
			$("#actualDst").val(respuesta["dst"]);
			$("#editarRemitente").val(respuesta["nomrem"]);
			$("#editarDestinatario").val(respuesta["nomdes"]);			
			$("#editarFechaGuia").val(moment(respuesta["frecib"]).format('DD/MM/YYYY'));
			$("#editarFechaEntrega").val(moment(respuesta["fdeliv"]).format('DD/MM/YYYY'));
			$("#pdfActual").val(respuesta["pdf"]);

			if(respuesta["pdf"] != ""){

				$(".previsualizar").attr("src", respuesta["pdf"]);
			}
		}

	});

	var origen = $(this).attr("origen");

	var datosOrg = new FormData();
	datosOrg.append("origen", origen);

	$.ajax({

	 	url:"ajax/sucursal.ajax.php",
	 	method: "POST",
	 	data: datosOrg,
	 	cache: false,
	 	contentType: false,
	 	processData: false,
	 	dataType: "json",
	 	success: function(respuestaOrg){

	 		$("#editarOrg").val(respuestaOrg["denom"]);

	 	}

	});

	var destino = $(this).attr("destino");

	var datosDst = new FormData();
	datosDst.append("destino", destino);

	$.ajax({

	 	url:"ajax/sucursal.ajax.php",
	 	method: "POST",
	 	data: datosDst,
	 	cache: false,
	 	contentType: false,
	 	processData: false,
	 	dataType: "json",
	 	success: function(respuestaDst){

	 		$("#editarDst").val(respuestaDst["denom"]);

	 	}

	});

})

/*=============================================
ELIMINAR CAR
=============================================*/

$(".tablas").on("click",".btnEliminarCar",function(){

	var idCar = $(this).attr("idCar");
	var fotoPdf = $(this).attr("fotoPdf");
	var codcli = $(this).attr("codcli");

	swal({
		title: '¿Está seguro de borrar el CAR?',
		text: "¡Si no lo está, puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, Borrar Car!'
	}).then((result)=>{

		if(result.value){
			
			window.location = "index.php?ruta=alta-cars&idCar="+idCar+"&codcli="+codcli+"&fotoPdf="+fotoPdf;

		}
	})
})

/*=============================================
RANGO DE FECHAS
=============================================*/

$('#daterange-btn').daterangepicker({
    ranges   : {
      	'Hoy'            : [moment(), moment()],
      	'Ayer'           : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      	'Últimos 7 Días' : [moment().subtract(6, 'days'), moment()],
      	'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
      	'Mes Actual'  	 : [moment().startOf('month'), moment().endOf('month')],
      	'Mes Pasado'  	 : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
},
function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');
    //console.log("fechaInicial",fechaInicial);
    var fechaFinal = end.format('YYYY-MM-DD');
    //console.log("fechaFinal",fechaFinal);

    var capturarRango = $("#daterange-btn span").html();
    //console.log("capturarRango",capturarRango);

    localStorage.setItem("capturarRango", capturarRango); 

    window.location = "index.php?ruta=cars-clientes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

  }

)

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("capturarRango");
	localStorage.clear();

	window.location = "rango-cars";

})


/*=============================================
CAPTURAR DIA DE HOY
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function(){

	//console.log($(this).attr("data-range-key"));
	var textoHoy = $(this).attr("data-range-key");

	if(textoHoy == "Hoy"){

		var d = new Date();
		//console.log("d", d);

		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();

		if(mes < 10){
			if(dia < 10){
				var fechaInicial = año+"-0"+mes+"-0"+dia;
				var fechaFinal = año+"-0"+mes+"-0"+dia;
			}else{
				var fechaInicial = año+"-0"+mes+"-"+dia;
				var fechaFinal = año+"-0"+mes+"-"+dia;
			}
		}else{
			if(dia < 10){
				var fechaInicial = año+"-"+mes+"-0"+dia;
				var fechaFinal = año+"-"+mes+"-0"+dia;
			}else{
				var fechaInicial = año+"-"+mes+"-"+dia;
				var fechaFinal = año+"-"+mes+"-"+dia;
			}
		}		

		localStorage.setItem("capturarRango", "Hoy");

		window.location = "index.php?ruta=cars-clientes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

	}

})

/*=============================================
IMPRIMIR CARS
=============================================*/

$(".tablas").on("click", ".btnImprimirCar", function(){

	var guianro = $(this).attr("guianro");

	window.open("extensiones/tcpdf/pdf/carspdf.php?guianro="+guianro, "_blank");


})

/*=============================================
IMPRIMIR RANGO DE CARS
=============================================*/

$(".tablas").on("click", ".btnRangoCar", function(){

	var guianro = $(this).attr("guianro");

	window.open("extensiones/tcpdf/pdf/carspdf.php?guianro="+guianro, "_blank");


})

/*=============================================
EDITAR CARS
=============================================*/

$(document).on("click",".btnBuscarCar",function(){

	var nguia = $(this).attr("nguia");
	var repnro = $(this).attr("repnro");

	var datos = new FormData();

	datos.append("nguia", nguia);
	datos.append("repnro", repnro);

	$.ajax({

		url:"ajax/cars.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			//console.log("respuesta", respuesta);
			$("#buscarNombre").val(respuesta["nombre"]);
			$("#buscarOrg").val(respuesta["org"]);
			$("#buscarDst").val(respuesta["dst"]);
			$("#buscarRemitente").val(respuesta["nomrem"]);
			$("#buscarDestinatario").val(respuesta["nomdes"]);			
		}

	});

})
