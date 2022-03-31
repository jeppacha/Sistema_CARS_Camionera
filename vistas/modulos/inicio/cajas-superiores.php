<?php

$clientes = ControladorClientes::ctrSumaClientes(); 
$cars = ControladorCars::ctrSumaTotalCars();
$users = ControladorUsuarios::ctrSumaTotalUsuarios();

?>


<div class="col-lg-4 col-xs-12">
  <!-- small box -->
  <div class="small-box bg-aqua">

    <div class="inner">

      <h3><?php echo number_format($clientes["totcli"],0); ?></h3>

      <p>Clientes</p>

    </div>

    <div class="icon">

      <i class="ion ion-android-contacts"></i>

    </div>

    <a href="clientes" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>

  </div>

</div>
<!-- ./col -->

<div class="col-lg-4 col-xs-12">
  <!-- small box -->
  <div class="small-box bg-green">

    <div class="inner">

      <h3><?php echo number_format($cars["totcar"],0); ?></h3>

      <p>CARS de Clientes</p>

    </div>

    <div class="icon">

      <i class="ion ion-stats-bars"></i>

    </div>

    <a href="cars-clientes" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>

  </div>

</div>
<!-- ./col -->

<div class="col-lg-4 col-xs-12">
  <!-- small box -->
  <div class="small-box bg-yellow">

    <div class="inner">

      <h3><?php echo number_format($users["totuser"],0); ?></h3>

      <p>Usuarios Registrados</p>

    </div>

    <div class="icon">

      <i class="ion ion-person-add"></i>

    </div>

    <a href="usuarios" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>

  </div>

</div>
<!-- ./col -->

<!-- <div class="col-lg-3 col-xs-6">
  
  <div class="small-box bg-red">

    <div class="inner">

      <h3>65</h3>

      <p>Unique Visitors</p>

    </div>

    <div class="icon">

      <i class="ion ion-pie-graph"></i>

    </div>

    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>

  </div>

</div> -->