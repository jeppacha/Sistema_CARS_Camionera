<?php

	error_reporting(0);
	if(isset($_GET["fechaInicial"])){

        $fechaInicial = $_GET["fechaInicial"];
        $fechaFinal = $_GET["fechaFinal"];

    }else{

        $fechaInicial = null;
        $fechaFinal = null;

    }
      
    $cars = ControladorCars::ctrRangoFechasCars($fechaInicial, $fechaFinal);
    //var_dump($cars);

    $arrayFechas = array();
      
    foreach ($cars as $key => $value) {

    	//var_dump($value["fdeliv"]);

    	$fecha = substr($value["fdeliv"],0,7);

    	//Se ingresan las fechas en el arrayFechas

    	array_push($arrayFechas, $fecha);

    	//var_dump($arrayFechas);
    	$arrayTotCar = array($fecha=>1);

    	foreach ($arrayTotCar as $key => $value) {
    		
    		$sumaCarMes[$key] += $value;

    	}

    }

    $noRepetirFecha = array_unique($arrayFechas);

?>



<!--============================
GRAFICO DE CARS 
=============================-->

<div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
		<i class="fa fa-th"></i>

		<h3 class="box-title">Gráfico de CARS Entregados</h3>

	</div>

	<div class="box-body border-radius-none nuevoGraficoCars">
		
		<div class="chart" id="line-chart-cars" style="height: 250px;"></div>

	</div>

</div>

<script>

var line = new Morris.Line({
    element          : 'line-chart-cars',
    resize           : true,
    data             : [

    <?php

	    if($noRepetirFecha != null){

	    	foreach ($noRepetirFecha as $key) {

	    		echo "{ y: '".$key."', cars: ".$sumaCarMes[$key]." },";
	    	
	    	}
	      
	        echo "{ y: '".$key."', cars: ".$sumaCarMes[$key]." }";

	    }else{

	    	echo "{ y: '0' cars: '0'}";

	    }
    ?>
    
    ],
    xkey             : 'y',
    ykeys            : ['cars'],
    labels           : ['Cars'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    gridTextSize     : 10
  });

</script>