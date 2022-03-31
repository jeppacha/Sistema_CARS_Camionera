<?php

  $item = null;
  $valor = null;
  $orden = "org";

  $origen = ControladorCars::ctrMostrarCars($item, $valor, $orden);
  $sucursal = ControladorSucursal::ctrMostrarSucursales($item, $valor);
  //var_dump($sucursal);
  $arrayOrigen = array();
  $arrayListaSuc = array();
  
  foreach ($origen as $key => $valueOrigen) {
    //var_dump($valueOrigen["origen"]);
    foreach ($sucursal as $key => $valueSucursal) {
      //var_dump($valueSucursal["codoff"]);
      if($valueSucursal["id"] === $valueOrigen["org"]){

        array_push($arrayOrigen, $valueSucursal["codoff"]);

        $arrayListaSuc = array($valueSucursal["codoff"] => 1);
        
      }

    }

    foreach ($arrayListaSuc as $key => $value) {
        
        $sumaTotxSucur[$key] += $value;

    }

  }
  
  $noRepiteSucur = array_unique($arrayOrigen);

?>


<div class="box box-success">
	
	<div class="box-header with-border">
		
		<h3 class="box-title">Cars Origen</h3>

	</div>

	<div class="box-body">
		
		<div class="chart-responsive">
			
			<div class="chart" id="bar-chart1" style="height: 300px;"></div>


		</div>

	</div>

</div>

<script>
	
//BAR CHART
var bar = new Morris.Bar({
  element: 'bar-chart1',
  resize: true,
  data: [

  <?php

    foreach ($noRepiteSucur as $value) {
      
      echo "{y: '".$value."', a: '".$sumaTotxSucur[$value]."'},";
    }
     
  ?>

  ],
  barColors: ['#49C13D'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['CARS'],
  postUnits: ' Unidades',
  hideHover: 'auto'
});

</script>