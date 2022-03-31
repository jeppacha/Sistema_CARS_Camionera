<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar Alta de Cars

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        
      <li class="active">Administrar Alta de Cars</li>

    </ol>
    
  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCars">
          
          Agregar Cars

        </button>

      </div>
        
      <div class="box-body">
       
        <table class="table table-bordered table-striped dt-responsive tablas">
          
          <thead>
            
            <tr>
              
              <th style="width: 10px">#</th>
              <th style="width: 10px">Cod-Cli</th>
              <th style="width: 150px">Nombre</th>
              <th>Guia</th>
              <th>Org</th>
              <th>Dst</th>
              <th>Remitente</th>
              <th>Destinatario</th>
              <th>Fecha Guia</th>
              <th>PDF</th>
              <th>Fecha Entrega</th>
              <th>Acciones</th>

            </tr>

          </thead>

          <tbody>

            <?php

              if(isset($_GET["fechaInicial"])){

                $fechaInicial = $_GET["fechaInicial"];
                $fechaFinal = $_GET["fechaFinal"];

              }else{

                $fechaInicial = null;
                $fechaFinal = null;

              }
              
              $cars = ControladorCars::ctrRangoFechasCars($fechaInicial, $fechaFinal);
              //var_dump($cars);
              
              foreach ($cars as $key => $value) {

              if($value["frecib"] != 0){
                $recib = date("d/m/yy", strtotime($value["frecib"]));
              }else{
                $recib = $value["frecib"];
              }
              if($value["fdeliv"] != 0){
                $entreg = date("d/m/yy", strtotime($value["fdeliv"]));
              }else{
                $entreg = $value["fdeliv"];
              }  
                echo ' 
                  <tr>
              
                    <td>'.($key+1).'</td>
                    
                    <td>'.$value["codcli"].'</td>
                    
                    <td>'.$value["nombre"].'</td>

                    <td>'.$value["nguia"].'</td>';

                    $itemOrg = "id";
                    $valorOrg = $value["org"];

                    $org = ControladorSucursal::ctrMostrarSucursales($itemOrg, $valorOrg);

                    echo '<td>'.$org["codoff"].'</td>';

                    $itemDst = "id";
                    $valorDst = $value["dst"];

                    $dst = ControladorSucursal::ctrMostrarSucursales($itemDst, $valorDst);

                    echo '<td>'.$dst["codoff"].'</td>
                    
                    <td>'.$value["nomrem"].'</td>
                    
                    <td>'.$value["nomdes"].'</td>

                    <td>'.$recib.'</td>';
                    
                    
                    if($value["pdf"] != ""){

                       echo '<td><img src="'.$value["pdf"].'" class="img-thumbnail" width="40px"></td>';
                    
                    }else{

                      echo '<td><img src="vistas/img/cars/default/defaultjpg.png" class="img-thumbnail" width="40px"></td>';
                    }
              
                    echo'

                    <td>'.$entreg.'</td>
                    
                    <td>
                    
                      <div class="btn-group">

                        <button class="btn btn-warning btnEditarCar" idCar="'.$value["id"].'" origen="'.$value["org"].'" destino="'.$value["dst"].'" data-toggle="modal" data-target="#modalEditarCars" title="Editar CAR"><i class="fa fa-pencil"></i></button>';

                        if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarCar" idCar="'.$value["id"].'" fotoPdf="'.$value["pdf"].'" codcli="'.$value["codcli"].'" title="Eliminar CAR"><i class="fa fa-times"></i></button>';

                        } 

                        echo '   
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

<!-- =================================
MODAL AGREGAR CARS
===================================-->

<div id="modalAgregarCars" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
  
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!-- =================================
          CABEZA DEL MODAL  
        ===================================-->

        <div class="modal-header" style="background:#3c8dbc; color: white">
  
          <h4 class="modal-title">Agregar Cars</h4>
  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
  
        </div>

        <!-- =================================
          CUERPO DEL MODAL 
        ===================================-->

        <div class="modal-body">

          <div class="box-body">
            
            <!-- ENTRADA PARA EL CODIGO DE CLIENTE -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoCodCli" id="nuevoCodCli" placeholder="Ingrese Codigo de Cliente" required>

              </div>
          
            </div>

            <!-- ENTRADA PARA EL NOMBRE -->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoNombre" id="nuevoNombre" value="" required readonly>
 
              </div>
            
            </div>

            <!-- ENTRADA PARA GUIA -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="nuevaGuia" id="nuevaGuia" placeholder="Ingrese Nro de ODT" required>
                 
              </div>
            
            </div>

            <div class="col-xs-5 row">

              <!-- ENTRADA PARA ORIGEN -->
              
              <div class="form-group">
              
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-industry"></i></span>

                  <select class="form-control input-lg" name="nuevoOrg" id="nuevoOrg" required>
                    
                    <option value="">Origen</option>
                      
                    <?php
                        
                      $item = null;
                      $valor = null;

                      $sucursales = ControladorSucursal::ctrMostrarSucursales($item, $valor);

                      foreach ($sucursales as $key => $value) {
                          
                        echo '<option value="'.$value["id"].'">'.$value["codoff"].'     ' .$value["denom"].'</option>';
                        
                      }
                      
                    ?>
                      
                  </select>
                   
                </div>
              
              </div>

              <!-- ENTRADA PARA DESTINO -->

              <div class="form-group">
              
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-industry"></i></span>

                  <select class="form-control input-lg" name="nuevoDst" id="nuevoDst" required>
                    
                    <option value="">Destino</option>
                      
                    <?php
                        
                      $item = null;
                      $valor = null;

                      $sucursales = ControladorSucursal::ctrMostrarSucursales($item, $valor);

                      foreach ($sucursales as $key => $value) {
                          
                        echo '<option value="'.$value["id"].'">'.$value["codoff"]. '    ' .$value["denom"].'</option>';
                        
                      }
                      
                    ?>
                      
                  </select>
                   
                </div>
              
              </div>

            </div>

            <!-- ENTRADA PARA REMITENTE  -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoRemitente" placeholder="Ingrese Remitente" required>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA DESTINATARIO  -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoDestinatario" placeholder="Ingrese Destinatario" required>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA FECHA DE GUIA  -->

            <div class="form-group">

              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                
                <input type="text" class="form-control input-lg" name="nuevaFechaGuia" placeholder="Ingrese Fecha de ODT" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required>
                
              </div>
              
            </div>

            <!-- ENTRADA PARA FECHA DE ENTREGA  -->

            <div class="form-group">

              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                
                <input type="text" class="form-control input-lg" name="nuevaFechaEntrega" placeholder="Ingrese fecha de Entrega" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required>
                
              </div>
              
            </div>

            <!-- ENTRADA PARA SUBIR PDF del CAR  -->        

            <div class="form-group">

              <div class="panel">SUBIR PDF de CAR</div>

              <input type="file" class="nuevoPdf" name="nuevoPdf">

              <p class="help-block">Peso máximo del archivo 5 MB</p>

              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

            </div>

          </div>

        </div>

        <!-- =================================
          PIE DEL MODAL 
        ===================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar CAR</button>

        </div>

        <?php
            
            $crearCar = new ControladorCars();
            $crearCar -> ctrCrearCar();
          
        ?>

      </form>

    </div>

  </div>

</div>

<!-- =================================
MODAL EDITAR CARS
===================================-->

<div id="modalEditarCars" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
  
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!-- =================================
          CABEZA DEL MODAL  
        ===================================-->

        <div class="modal-header" style="background:#3c8dbc; color: white">
  
          <h4 class="modal-title">Editar Cars</h4>
  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
  
        </div>

        <!-- =================================
          CUERPO DEL MODAL 
        ===================================-->

        <div class="modal-body">

          <div class="box-body">
            
            <!-- ENTRADA PARA EL CODIGO DE CLIENTE -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" name="editarCodCli" id="editarCodCli" value="" readonly>

              </div>
          
            </div>

            <!-- ENTRADA PARA EL NOMBRE -->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" name="editarNombre" id="editarNombre" value="" required>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA GUIA -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="editarGuia" id="editarGuia" value="" readonly>
                 
              </div>
            
            </div>

            <div class="col-xs-5 row">

              <!-- ENTRADA PARA ORIGEN -->
              
              <div class="form-group">
              
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-industry"></i></span>

                  <input type="text" class="form-control input-lg" id="editarOrg" name="editaOrg" value="" readonly>
                  <input type="hidden" id="actualOrg" name="actualOrg">
                   
                </div>
              
              </div>

              <!-- ENTRADA PARA DESTINO -->

              <div class="form-group">
              
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-industry"></i></span>

                  <input type="text" class="form-control input-lg" id="editarDst" name="editaDst" value="" readonly>
                  <input type="hidden" id="actualDst" name="actualDst">
                   
                </div>
              
              </div>

            </div>

            <!-- ENTRADA PARA REMITENTE  -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="editarRemitente" id="editarRemitente" value="" required>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA DESTINATARIO  -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="editarDestinatario" id="editarDestinatario" value="" required>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA FECHA DE GUIA  -->

            <div class="form-group">

              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                
                <!-- <input type="text" class="form-control input-lg" name="editarFechaGuia" id="editarFechaGuia" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required> -->
                <input type="text" class="form-control input-lg" name="editarFechaGuia" id="editarFechaGuia" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required>
                
              </div>
              
            </div>

            <!-- ENTRADA PARA FECHA DE ENTREGA  -->

            <div class="form-group">
            
              <!-- <label>Date masks:</label> -->

              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                
                <!-- <input type="text" class="form-control input-lg" name="editarFechaEntrega" id="editarFechaEntrega" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required> -->
                <input type="text" class="form-control input-lg" name="editarFechaEntrega" id="editarFechaEntrega" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required>
                
              </div>
              
            </div>

            <!-- ENTRADA PARA SUBIR PDF del CAR  -->        

            <div class="form-group">

              <div class="panel">SUBIR PDF/JPG o PNG de CAR</div>

              <input type="file" class="nuevoPdf" name="editarPdf">

              <p class="help-block">Peso máximo del archivo 5 MB</p>

              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="pdfActual" id="pdfActual">

            </div>

          </div>

        </div>

        <!-- =================================
          PIE DEL MODAL 
        ===================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Cambios</button>

        </div>

        <?php

          $editarCar = new ControladorCars();
          $editarCar -> ctrEditarCar();

        ?>

      </form>

    </div>

  </div>

</div>

<?php

  $borrarCar = new ControladorCars();
  $borrarCar -> ctrBorrarCar();

?>
 