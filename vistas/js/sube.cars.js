$(function(){
	$('#sube-cars').submit(function(){

		var comprobar = $("#cars").val().length;

		if(comprobar > 0){

			var formulario = $('#sube-cars');

			var archivos = new FormData();

			//var url = "../ajax/sube.cars.ajax.php";

			for(var i = 0; i < (formulario.find('input[type=file]').length); i++){

				archivos.append((formulario.find('input[type="file"]:eq('+i+')').attr("name")),((formulario.find('input[type="file"]:eq('+i+')')[0]).files[0]));
			}
			
			$.ajax({

				url:"ajax/sube.cars.ajax.php",
				method: "POST",
				data: archivos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){

					if(respuesta == "ok"){

						$('#respuestacar').html('<label style="padding-top:20px; color:green;">Importación de CARS exitosa</label>');
						return false;

					}else{

						$('#respuestacar').html('<label style="padding-top:20px; color:green;">La Importación ha fallado</label>');
						return false;

					}

				}

			});

			return false;

		}else{

			alert('Selecciona el archivo a importar');

			return false;
		}	

	});

});