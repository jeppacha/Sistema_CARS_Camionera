<div class="content-wrapper">

  <section class="content-header">

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
      <li class="active">Administrar Cars</li>

    </ol>

    <?php 

      if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Operador"){

        echo '
                    
        <h1>Cars de todos los Clientes</h1>';

      }else{

        echo '
                  
        <h1>Administrar Cars del Cliente:</h1> 
                     
        <div class="box box-widget widget-user">
                  
          <div class="widget-user-header bg-aqua-active">
                  
            <h3 class="widget-user-username">'.$_SESSION["nombre"].'</h3>
                  
            <h5 class="widget-user-desc">Codigo Cliente: '.$_SESSION["codcli"].'</h5>
                
          </div>
                
          <div class="widget-user-image">
                  
            <img class="img-circle" src="'.$_SESSION["foto"].'" alt="User Avatar">
                
          </div>
                
          <div class="box-footer">
                  
            <div class="row">';
                    
              $cant = 0;
              $item = "codcli";
              $valor = $_SESSION["codcli"];
              $orden = "id";

              $CarsCli = ControladorCars::ctrSumaCarsCli($item, $valor);

              echo '
              <div class="col-sm-12 border-left">

                <div class="description-block">
                        
                  <h5 class="description-header">'.$CarsCli["totcar"].'</h5>
                        
                  <span class="description-text">CARS Totales</span>
                      
                </div>

              </div>
                                         
            </div>
                  
          </div>
              
        </div>';

      }

     ?>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border"></div>

        <?php

          if($_SESSION["perfil"] == "Cliente"){
            
            echo '
            <div class="box-tools pull-right">

              <a href="vistas/modulos/descargar-cars.php?reporte=cars&codcli='.$_SESSION['codcli'].'">
            
                <button class="btn btn-success" style="margin-top: 5px">Descargar Listado en Excel</button>

              </a>

            </div>';
          
          }else{

            echo '
            <div class="box-tools pull-right">

              <a href="vistas/modulos/descargar-cars.php?reporte=cars">
            
                <button class="btn btn-success" style="margin-top: 5px">Descargar Listado en Excel</button>

              </a>

            </div>';

          }

        ?>

      </div>
        
      <div class="box-body">

        <table class="table table-bordered table-striped tablas">
          
          <thead>
            
            <tr>
              
              <th style="width: 10px">#</th>
              <th>Nombre</th>
              <th>Guia</th>
              <th>Remitente</th>
              <th>Restinatario</th>
              <th>Recibida</th>
              <th>Entregada</th>
              <th>Org</th>
              <th>Dst</th>
              <th>Acciones</th>

            </tr>

          </thead>

          <tbody>

            <?php

              if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Operador"){

                $item = null;
                $valor = null;
                $orden = "codcli";

                $cars = ControladorCars::ctrMostrarCars($item, $valor, $orden);

              }else{

                $item = "codcli";
                $valor = $_SESSION["codcli"];
                $orden = "codcli";

                $cars = ControladorCars::ctrMostrarCarsCl($item, $valor, $orden);

              }
              foreach ($cars as $key => $value) {

                $recibe = date("d/m/yy", strtotime($value["frecib"]));
                $entrega = date("d/m/yy", strtotime($value["fdeliv"]));

                echo '
                <tr>
              
                  <td>'.($key+1).'</td>
                  
                  <td>'.$value["nombre"].'</td>

                  <td>'.$value["nguia"].'</td>

                  <td>'.$value["nomrem"].'</td>

                  <td>'.$value["nomdes"].'</td>

                  <td>'.$recibe.'</td>

                  <td>'.$entrega.'</td>';

                  $itemOrg = "id";
                  $valorOrg = $value["org"];

                  $org = ControladorSucursal::ctrMostrarSucursales($itemOrg, $valorOrg);

                  echo '<td>'.$org["codoff"].'</td>';

                  $itemDst = "id";
                  $valorDst = $value["dst"];

                  $dst = ControladorSucursal::ctrMostrarSucursales($itemDst, $valorDst);

                  echo '<td>'.$dst["codoff"].'</td>
                  
                  <td>
                  
                    <div class="btn-group">

                      <button class="btn btn-info btnImprimirCar" idCars="'.$value["id"].'" fotoCar="'.$value["pdf"].'" guianro="'.$value["nguia"].'" title="Imprimir o Descargar CAR"><i class="fa fa-print"></i></button>

                      <button class="btn btn-success"title="Ver CAR"><i class="fa fa-eye" ></i></button>
                          
                    </div>
                  
                  </td>

                </tr>';

              }

            ?>
            
          </tbody>

        </table>

      </div>

    </div>

  </section>

</div>

