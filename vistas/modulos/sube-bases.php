<!-- <script src="vistas/js/sube.cars.js"></script> -->
<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Subir Bases de Datos

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
      <li class="active">Subir Bases de Datos</li>

    </ol>
    
  </section>

  <section class="content">

    <div class="box box-primary">

      <div class="box-header with-border">

        <div class="box-tools pull-right"></div>

      </div>
        
      <div class="box-body">
       
        <div class="col-md-6 col-xs-12">

          <div class="box box-success">
  
            <div class="box-header with-border">
    
              <h2 class="box-title" style="font-size: 250%">Subir Clientes</h2>
              <h5>Solo se subiran los CLIENTES que tengan activado el informe de CARS en Sistema Camionera</h5>

            </div>

          </div> 

          <div class="formulario">
            
            <form action="sube-bases" class="formularioCliente" method="post" enctype="multipart/form-data">
              
              <br>

              <div class="col-xs-8">

                <input type="file" name="cliente" class="form-control">

              </div>

              <div class="col-xs-4">

                <select class="form-control" name="baseSucursal" id="baseSucursal">
                      
                  <option value="">Selecionar Sucursal</option>
                    
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

              <input type="submit" value="Subir Archivo Clientes" class="btn btn-primary" name="enviaClie">
              <?php 

                $archiClie = new ControladorArchivo();
                $archiClie -> ctrSubirClientes();

              ?>
              
            </form>

          </div>               

        </div>      

        <div class="col-md-6 col-xs-12">

          <div class="box box-warning">
  
            <div class="box-header with-border">
    
              <h2 class="box-title" style="font-size: 250%">Subir CARS</h2>
              <h5>Solo se subiran los CARS de clientes que ya existan en base de datos</h5>

            </div>

          </div> 

          <div class="formulario">
            
            <form action="sube-bases" class="formularioCars" method="post" enctype="multipart/form-data" id="sube-cars">
              
              <br>

              <div class="col-xs-8">

                <input type="file" name="cars" id="cars" class="form-control">

              </div>

              <div class="col-xs-4">

                <select class="form-control" name="carSucursal" id="carSucursal">
                      
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

              <input type="submit" value="Subir Archivo CARS" class="btn btn-primary" name="enviaCar" id="enviaCar">

              <div id=respuestacar></div>

              <?php 

                $archiCar = new ControladorArchivo();
                $archiCar -> ctrSubirCars();

              ?>

            </form>

          </div>               

        </div>

      </div>

    </div>

  </section>

</div>


