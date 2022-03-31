/*=============================================
VARIABLE DE LOCAL STORAGE
=============================================*/

// if(localStorage.getItem("capturarRango2") != null){

// 	// var rango = localStorage.getItem("capturarRango");
// 	// //console.log("rango",rango);

// 	// $("#daterange-btn span").html(rango);

// 	$("#daterange-btn2 span").html(localStorage.getItem("capturarRango2"));

// }else{

// 	$("#daterange-btn2 span").html('<i class="fa fa-calendar"></i> Rango de Fecha');

// }

/*=============================================
RANGO DE FECHAS
=============================================*/

// $('#daterange-btn2').daterangepicker(
//   {
//     ranges   : {
//       'Hoy'       : [moment(), moment()],
//       'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//       'Últimos 7 Días' : [moment().subtract(6, 'days'), moment()],
//       'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
//       'Mes Actual'  : [moment().startOf('month'), moment().endOf('month')],
//       'Mes Pasado'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//     },
//     startDate: moment(),
//     endDate  : moment()
//   },
//   function (start, end) {
//     $('#daterange-btn2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

//     var fechaInicial = start.format('YYYY-MM-DD');
//     //console.log("fechaInicial",fechaInicial);
//     var fechaFinal = end.format('YYYY-MM-DD');
//     //console.log("fechaFinal",fechaFinal);

//     var capturarRango2 = $("#daterange-btn2 span").html();
//     //console.log("capturarRango",capturarRango);

//     localStorage.setItem("capturarRango2", capturarRango2); 

//     window.location = "index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

//   }

// )

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

// $(".daterangepicker.opensright .range_inputs .cancelBtn").on("click", function(){

// 	localStorage.removeItem("capturarRango2");
// 	localStorage.clear();

// 	window.location = "reportes";

// })


/*=============================================
CAPTURAR DIA DE HOY
=============================================*/

// $(".daterangepicker.opensright .ranges li").on("click", function(){

// 	//console.log($(this).attr("data-range-key"));
// 	var textoHoy = $(this).attr("data-range-key");

// 	if(textoHoy == "Hoy"){

// 		var d = new Date();
// 		//console.log("d", d);

// 		var dia = d.getDate();
// 		var mes = d.getMonth()+1;
// 		var año = d.getFullYear();

// 		if(mes < 10){
// 			if(dia < 10){
// 				var fechaInicial = año+"-0"+mes+"-0"+dia;
// 				var fechaFinal = año+"-0"+mes+"-0"+dia;
// 			}else{
// 				var fechaInicial = año+"-0"+mes+"-"+dia;
// 				var fechaFinal = año+"-0"+mes+"-"+dia;
// 			}
// 		}else{
// 			if(dia < 10){
// 				var fechaInicial = año+"-"+mes+"-0"+dia;
// 				var fechaFinal = año+"-"+mes+"-0"+dia;
// 			}else{
// 				var fechaInicial = año+"-"+mes+"-"+dia;
// 				var fechaFinal = año+"-"+mes+"-"+dia;
// 			}
// 		}		

// 		localStorage.setItem("capturarRango2", "Hoy");

// 		window.location = "index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

// 	}

// })