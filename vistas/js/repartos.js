/*=============================================
=          EDITAR REPARTO                    =
=============================================*/
$(document).on("click",".btnEntregaReparto",function(){
//$(".btnEntregaReparto").click(function(){
	var repnro = $(this).attr("repnro");

	window.location = "index.php?ruta=entrega-reparto&repnro="+repnro;
	

})

/*=============================================
=          VOLVER                    =
=============================================*/
$(document).on("click",".btnVolver",function(){

	window.location = "repartos";

})

