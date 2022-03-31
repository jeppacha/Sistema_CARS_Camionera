<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Reportes de CARS

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
      <li class="active">Reportes de CARS</li>

    </ol>
    
  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button type="botton" class="btn btn-default" id="daterange-btn2">
          
          <span>
            
            <i class="fa fa-calendar"></i> Rango de Fechas

            <i class="fa fa-caret-down"></i>

          </span>

        </button>

        <div class="box-tools pull-right">

          <?php

            if(isset($_GET["fechaInicial"])){

              echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte&fechaInicial="'.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'">';
            
            }else{

              echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte">';

            }

          ?>

          <button class="btn btn-success" style="margin-top: 5px">Descargar Reporte en Excel</button>

        </div>

      </div>
        
      <div class="box-body">
       
        <div class="row">
          
          <div class="col-xs-12">
            
            <?php

              include "reportes/grafico-cars.php";

            ?>
          
          </div>

        </div>

        <div class="col-md-6 col-xs-12">
          
          <?php 

            include "reportes/clientes-mas-envios.php";

          ?>

        </div>

        <div class="col-md-6 col-xs-12">
          
          <?php 

            include "reportes/cars-origen.php";

          ?>

        </div>

        <div class="col-md-6 col-xs-12">
          
          <?php 

            include "reportes/cars-destino.php";

          ?>

        </div>

      </div>

    </div>

  </section>

</div>


