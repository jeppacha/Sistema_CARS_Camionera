<div class="content-wrapper">

  <section class="content-header">
    <h1>

      Administrar CARS
      
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar CARS</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        
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
