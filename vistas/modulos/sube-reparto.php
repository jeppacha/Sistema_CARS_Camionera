<!-- <script src="vistas/js/sube.cars.js"></script> -->
<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Subir Datos de Repartos

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
      <li class="active">Subir Datos de Repartos</li>

    </ol>
    
  </section>

  <section class="content">

    <div class="box box-primary">

      <div class="box-header with-border">

        <div class="box-tools pull-right"></div>

      </div>
        
      <div class="box-body">
       
        <div class="col-md-6 col-xs-12">

          <div class="box box-warning">
  
            <div class="box-header with-border">
    
              <h2 class="box-title" style="font-size: 250%">Subir REPARTOS</h2>
              <h5>Solo se subiran los Repartos</h5>

            </div>

          </div> 

          <div class="formulario">
            
            <form action="sube-reparto" class="formularioCars" method="post" enctype="multipart/form-data" id="sube-repar">
              
              <br>

              <div class="col-xs-8">

                <input type="file" name="reparto" id="reparto" class="form-control">

              </div>

              <div class="col-xs-4">

                <select class="form-control" name="repSucursal" id="repSucursal">
                      
                  <option value="#">Selecionar Sucursal</option>
                    
                  <?php
                      
                    $item = null;
                    $valor = null;

                    $sucursales = ControladorSucursal::ctrMostrarSucursales($item, $valor);

                    foreach ($sucursales as $key => $value) {
                        
                      echo '<option value="'.$value["codoff"].'">'.$value["denom"].'</option>';
                      
                    }
                    
                  ?>
                    
                </select>

                <br>

              </div>

              <br>

              <!-- <button type="submit" class="btn btn-primary">Subir Archivo CARS</button> -->

              <input type="submit" class="btn btn-primary" value="Subir Archivo REPARTO" name="enviaRep" id="enviaRep">

              <div id=respuestarep></div>

              <?php 

                $archiRep = new ControladorArchivo();
                $archiRep -> ctrSubirReparto();

              ?>

            </form>

          </div>               

        </div>

        <div class="col-md-6 col-xs-12">

          <div class="box box-warning">
  
            <div class="box-header with-border">
    
              <h2 class="box-title" style="font-size: 250%">Subir FLETEROS</h2>
              <h5>Solo se subiran los Fleteros</h5>

            </div>

          </div> 

          <div class="formulario">
            
            <form action="sube-reparto" class="formularioCars" method="post" enctype="multipart/form-data" id="sube-fletero">
              
              <br>

              <div class="col-xs-8">

                <input type="file" name="fletero" id="fletero" class="form-control">

              </div>

              <div class="col-xs-4">

                <select class="form-control" name="fleSucursal" id="fleSucursal">
                      
                  <option value="#">Selecionar Sucursal</option>
                    
                  <?php
                      
                    $item = null;
                    $valor = null;

                    $sucursales = ControladorSucursal::ctrMostrarSucursales($item, $valor);

                    foreach ($sucursales as $key => $value) {
                        
                      echo '<option value="'.$value["codoff"].'">'.$value["denom"].'</option>';
                      
                    }
                    
                  ?>
                    
                </select>

                <br>

              </div>

              <br>

              <!-- <button type="submit" class="btn btn-primary">Subir Archivo CARS</button> -->

              <input type="submit" class="btn btn-primary" value="Subir Archivo FLETERO" name="enviaFle" id="enviaFle">

              <div id=respuestafle></div>

              <?php 

                $archiFle = new ControladorArchivo();
                $archiFle -> ctrSubirFletero();

              ?>

            </form>

          </div>               

        </div>        

      </div>

    </div>

  </section>

</div>


