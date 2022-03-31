<?php

  $item = null;
  $valor = null;
  $orden = "dst";

  $destino = ControladorCars::ctrMostrarCars($item, $valor, $orden);
  $sucursal = ControladorSucursal::ctrMostrarSucursales($item, $valor);
  //var_dump($sucursal);
  $arrayDestino = array();
  $arrayListaSuc1 = array();
  
  foreach ($destino as $key => $valueDestino) {
    //var_dump($valueDestino["origen"]);
    foreach ($sucursal as $key => $valueSucursal) {
      //var_dump($valueSucursal["codoff"]);
      if($valueSucursal["id"] === $valueDestino["dst"]){
        //var_dump($valueSucursal["id"]);
        array_push($arrayDestino, $valueSucursal["codoff"]);

        $arrayListaSuc1 = array($valueSucursal["codoff"] => 1);
        
      }
      //*var_dump($arrayDestino);
      //var_dump($arrayListaSuc1);
    }

    foreach ($arrayListaSuc1 as $key => $value) {
        
        $sumaTotSucur[$key] += $value;

    }

  }
  
  $noRepiteSucur1 = array_unique($arrayDestino);
?>


<div class="box box-primary">
	
	<div class="box-header with-border">
		
		<h3 class="box-title">Cars destino</h3>

	</div>

	<div class="box-body">
		
		<div class="chart-responsive">
			
			<div class="chart" id="bar-chart2" style="height: 300px;"></div>


		</div>

	</div>

</div>

<script>
	
//BAR CHART
var bar = new Morris.Bar({
  element: 'bar-chart2',
  resize: true,
  data: [
  <?php

    foreach ($noRepiteSucur1 as $value) {
    	//var_dump($sumaTotSucur1[$value]);
      echo "
        {y: '".$value."', a: '".$sumaTotSucur[$value]."'},";

    }
     
  ?>
  ],
  barColors: ['#5591EB'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['CARS'],
  postUnits: ' Unidades',
  hideHover: 'auto'
});

</script>