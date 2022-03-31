<div class="content-wrapper">
  
  <section class="content-header">
      
    <h1>

      Entrega Repartos
        
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Entrega Repartos</li>

    </ol>


    <?php
      
      echo '
      <div class="box box-success">

        <div class="box-header">';

          if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Operador"){

            echo '
                  
            <div class="col-xs-4">
                    
              <h1>Repartos de todos los Fleteros</h1>
              
            </div>';

          }else{
              
            echo '
                  
            <div class="col-xs-4">
                
              <h1>Administrar Repartos del Fletero:</h1> 
                     
            </div>            
                
            <div class="col-xs-4">
                
              <div class="box box-widget widget-user">
                  
                <div class="widget-user-header bg-aqua-active">
                    
                  <h3 class="widget-user-username">'.$_SESSION["nombre"].'</h3>
                    
                  <h5 class="widget-user-desc">C.U.I.T Fletero: '.$_SESSION["cuitfle"].'</h5>
                  
                </div>
                  
                <div class="widget-user-image">';

                  if($_SESSION["foto"] != null){
                    
                    echo '<img class="img-circle" src="'.$_SESSION["foto"].'" alt="User Avatar">';

                  }else{

                    echo '<img class="img-circle" src="vistas/img/fleteros/default/default_fletero.png" alt="User Avatar">';

                  }
                echo'  
                </div>
                  
                <div class="box-footer">
                    
                  <div class="row">';
                           
                    $cant = 0;
                    $item = "cuitfle";
                    $valor = $_SESSION["cuitfle"];

                    $RepFle = ControladorRepartos::ctrSumaRepFle($item, $valor);

                    echo '
                    <div class="col-sm-12 border-left">

                      <div class="description-block">
                          
                        <h5 class="description-header">'.$RepFle["totrep"].'</h5>
                          
                        <span class="description-text">Repartos sin Rendir</span>
                        
                      </div>

                    </div>
                                           
                  </div>
                    
                </div>
                
              </div>

            </div>

            <a href="vistas/modulos/descargar-repartos.php?reporte=reporte&fletero='.$_SESSION["usuario"].'&cuitfle='.$_SESSION["cuitfle"].'&nombre='.$_SESSION["nombre"].'">
                      
              <button class="btn btn-success pull-right" style="margin-top: 5px">Descargar repartos en Excel</button>

            </a>';

          }

        echo'

        </div>
          
      </div>';

    ?>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablas">
          
          <thead>
            
            <tr>
              
              <th style="width: 10px">#</th>
              <th>Guia</th>
              <th>Codcli</th>
              <th>Fecha Reparto</th>
              <th>CAR</th>
              <th style="width: 60px">Estado</th>
              <th style="width: 130px">Acciones</th>
              <th>Fecha Entrega</th>
              
            </tr>

          </thead>

          <tbody>
            
            <?php 

              // if($_SESSION["perfil"] == "Fletero"){

              //   $item = "cuitfle";
              //   $valor = $_SESSION["cuitfle"];

              //   $repartos = ControladorRepartos::ctrVerRepartos($item, $valor);

              // }else{

              //   $item = null;
              //   $valor = null;

              //   $repartos = ControladorRepartos::ctrVerRepartos($item, $valor);

              // }
              if(isset($_GET["repnro"])){

                $item = "repnro";
                $valor = $_GET["repnro"];

                $repartos = ControladorRepartos::ctrEntregaReparto($item, $valor);
            
                foreach ($repartos as $key => $value) {

                  if(strcmp($value["cuitfle"] , "33531122599") === 0){

                  }else{

                    if($value["repfec"] != 0){

                      $fecharep = date("d/m/Y", strtotime($value["repfec"]));
                    
                    }else{

                      $fecharep = $value["repfec"];
                    }

                    if($value["fecdeliv"] != 0){

                      $fecharen = date("d/m/Y", strtotime($value["fecdeliv"]));

                    }else{

                      $fecharen = $value["fecdeliv"];

                    }

                    echo '

                    <tr>

                      <td style="width:10px">'.($key+1).'</td>
                
                      <td style="width:60px">'.$value["nguia"].'</td>

                      <td style="width:60px">'.$value["codcli"].'</td>
                
                      <td style="width:80px">'.$fecharep.'</td>';

                      $tabla = "clientes";
                      $itemcli = "codcli";
                      $valorcli = $value["codcli"];
                      $codcli = null;

                      $clientecar = ModeloClientes::mdlMostrarClientes($tabla, $itemcli, $valorcli);
                      
                      //$clientecar = ContoladorCliente::ctrCarClientes($itemcli, $valorcli);
                      if(isset($clientecar["codcli"])){
                      //if(strcmp($clientecar["codcli"],$valorcli) === 0){

                        $codcli = $clientecar["codcli"];    
                        if($value["fotocar"] != ""){ 

                          echo '<td style="width:60px"><img src="'.$value["fotocar"].'" class="img-thumbnail" width="40px"></td>';
                            
                        }else{

                          echo '<td style="width:60px"><img src="vistas/img/cars/default/defaultpdf.png" class="img-thumbnail" width="40px"></td>';
                        }

                      }else{

                        echo '<td width="60px"></td>';

                      }

                      if($value["deliv"] != null){
                        
                        if($value["deliv"] == 1){

                          echo '<td style="width:80px"><button class="btn btn-success disabled">Entregada</button></td>';

                        }else{

                          echo '<td style="width:80px"><button class="btn btn-danger disabled">No Entregada</button></td>';

                        }

                      }else{

                        echo '<td style="width:80px"></td>';

                      }

                      echo '
                      <td style="width:110px">

                        <div class="btn-group">';
                          //var_dump($value["deliv"]);
                          if($value["deliv"] != null){

                            if($value["deliv"] == 1){

                              echo '<button class="btn btn-success disabled" padding="10px">
                              <p>GUIA ENTREGADA</p></button>';

                              echo '<button class="btn btn-danger disabled" padding="10px">
                              <p>GUIA NO ENTREGADA</p></button>';

                            }else{

                              echo '<button class="btn btn-success disabled" padding="10px">
                              <p>GUIA ENTREGADA</p></button>';

                              echo '<button class="btn btn-danger disabled" padding="10px">
                              <p>GUIA NO ENTREGADA</p></button>';

                            }

                          }else{
                            //var_dump($codcli);
                            if($codcli != null){

                              if(strcmp($codcli,$value["codcli"]) === 0){

                                echo '<button class="btn btn-success btnEntregada" repnro="'.$value["repnro"].'" title="Entregar Guia" padding="10px">
                                  <input type="file" class="nuevaFotoFle" name="nuevaFoto"><p></p></button>';

                                echo '<button class="btn btn-danger btnNoEntregada" nguia="'.$value["nguia"].'" repnro="'.$value["repnro"].'" padding="10px">
                                <p>GUIA NO ENTREGADA</p></button>';

                              }

                            }else{

                              echo '<button class="btn btn-success" repnro="'.$value["repnro"].'" padding="10px">
                              <p>GUIA ENTREGADA</p></button>';

                              echo '<button class="btn btn-danger btnNoEntregada" nguia="'.$value["nguia"].'" repnro="'.$value["repnro"].'" padding="10px">
                              <p>GUIA NO ENTREGADA</p></button>';
                          
                            }

                          }

                        echo '  
                        </div>

                      </td>

                      <td style="width:100px">'.$fecharen.'</td>

                    </tr>';
    
                  }

                }

              }

            ?>

          </tbody>

        </table>

      </div>

    </div>

  </section>

</div>

<!-- <?php 

  // $entregaReparto = new ControladorRepartos();
  // $entregaReparto -> ctrEntregaReparto();

 ?> -->