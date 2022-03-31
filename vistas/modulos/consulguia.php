<div class="content-wrapper">

  <section class="content-header">

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
      <li class="active">Consulta de Guias</li>

    </ol>

    <br>
    <br>

    <?php
      
      echo '
      <div class="box box-success">

        <div class="box-header">';

          if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Operador"){

            echo '
                  
            <div class="col-xs-11">
                    
              <h1>Consulta de Guias</h1>
              
            </div>';

          }else if($_SESSION["perfil"] == "Fletero"){
              
            echo '
                  
            <div class="col-xs-4">
                
              <h1>Consulta de Guias de:</h1> 
                     
            </div>            
                
            <div class="col-xs-4">
                
              <div class="box box-widget widget-user">
                  
                <div class="widget-user-header bg-aqua-active">
                    
                  <h3 class="widget-user-username">'.$_SESSION["nombre"].'</h3>
                    
                  <h5 class="widget-user-desc">C.U.I.T Repartidor: '.$_SESSION["usuario"].'</h5>
                  
                </div>
                  
                <div class="widget-user-image">
                    
                  <img class="img-circle" src="'.$_SESSION["foto"].'" alt="User Avatar">
                  
                </div>
                  
                <div class="box-footer">
                    
                  <div class="row">';
                           
                    $cant = 0;
                    $item = "cuitfle";
                    $valor = $_SESSION["usuario"];
                    

                    $GuiasFle = ControladorRepartos::ctrSumaGuiasFle($item, $valor);

                    echo '
                    <div class="col-sm-12 border-left">

                      <div class="description-block">
                          
                        <h5 class="description-header">'.$GuiasFle["totguia"].'</h5>
                          
                        <span class="description-text">GUIAS Totales</span>
                        
                      </div>

                    </div>
                                           
                  </div>
                    
                </div>
                
              </div>

            </div>

            <a href="vistas/modulos/descargar-guiasfle.php?reporte=reporte&fletero='.$_SESSION["usuario"].'&cuitfle='.$_SESSION["usuario"].'&nombre='.$_SESSION["nombre"].'">
                      
              <button class="btn btn-success pull-right" style="margin-top: 5px">Descargar Listado en Excel</button>

            </a>';

          }
/*--------------------------
          echo'
          <a href="vistas/modulos/descargar-guias.php?reporte=reporte&cliente='.$_SESSION["usuario"].'&codcli='.$_SESSION["codcli"].'&nombre='.$_SESSION["nombre"].'">
                    
            <button class="btn btn-success pull-right" style="margin-top: 5px">Descargar Listado en Excel</button>

          </a>';
---------------------------*/

        echo'

        </div>
          
      </div>';

    ?>

  </section>

  <section class="content">

    <div class="box">

      <br>
             
      <div class="box-body">
       
        <table class="table table-bordered table-striped dt-responsive tablas">
          
          <thead>
            
            <tr>
              
              <th style="width: 10px">#</th>
              <th style="width: 25px">Suc</th>
              <th style="width: 30px">Guia</th>
              <th style="width: 90px">Remit</th>
              <th style="width: 90px">Destinat</th>
              <th style="width: 25px">Recibida</th>
              <th style="width: 25px">Entregada</th>
              <th style="width: 10px">Org</th>
              <th style="width: 10px">Dst</th>
              <th style="width: 20px">Acciones</th>

            </tr>

          </thead>

          <tbody>

            <?php

              if($_SESSION["perfil"] == "Administrador"){

                if(isset($_GET["fechaInicial"])){

                  $fechaInicial = $_GET["fechaInicial"];
                  $fechaFinal = $_GET["fechaFinal"];
                  $sucursal = $_POST['sucursalCar'];
                  $codcli = $_POST['clienteCar'];

                  $cars = ControladorRepartos::ctrRangoFechasCars($fechaInicial, $fechaFinal,$sucursal,$codcli);

                }else{

                  $fechaInicial = null;
                  $fechaFinal = null;
                  $sucursal = null;
                  $codcli = null;

                  $cars = ControladorCars::ctrRangoFechasCars($fechaInicial, $fechaFinal,$sucursal,$codcli);                  
                }

              }else if($_SESSION["perfil"] == "Operador"){

                $item = null;
                $valor = null;
                $orden = "fdeliv";

                $cars = ControladorCars::ctrMostrarCars($item, $valor, $orden);

              }else{

                $item = "codcli";
                $valor = $_SESSION["codcli"];
                $orden = "fdeliv";
                
                $cars = ControladorCars::ctrMostrarCarsCl($item, $valor, $orden);
                
              }

              //var_dump($cars);
              foreach ($cars as $key => $value) {
                
                $recibe = date("d/m/Y", strtotime($value["frecib"]));
                if($value["fdeliv"] == ""){

                  $entrega = "00/00/0000";

                }else{
                  
                  $entrega = date("d/m/Y", strtotime($value["fdeliv"]));  

                }
                
                echo '
                <tr>
              
                  <td>'.($key+1).'</td>';

                  $itemSuc = "id";
                  $valorSuc = $value["id_sucadm"]; 

                  $suc = ControladorSucursal::ctrMostrarSucursales($itemSuc, $valorSuc);

                  echo '<td>'.$suc["denom"].'</td>
                  
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

                  echo '<td>'.$dst["codoff"].'</td>';

                  if($entrega != "00/00/0000"){
                  echo' 
                    <td>
                    
                      <div class="btn-group">

                        <button class="btn btn-info btnImprimirCar" idCars="'.$value["id"].'" fotoCar="'.$value["pdf"].'" guianro="'.$value["nguia"].'" title="Imprimir o Descargar CAR"><i class="fa fa-print"></i></button>
                            
                      </div>
                    
                    </td>';

                  }else{

                    echo '<td></td>';

                  }

                echo '</tr>';

              }

            ?>
            
          </tbody>

        </table>

      </div>

    </div>

  </section>

</div>

