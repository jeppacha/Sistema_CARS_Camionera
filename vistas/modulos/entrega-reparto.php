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
                  
            <div class="col-xs-4">';

              if(isset($_GET["repnro"])){
                
                echo'<h1>Entrega de Reparto Nro: '.$_GET["repnro"].'</h1>';

              } 
            echo'
                    
            </div>';

          }else{
              
            echo '
                  
            <div class="col-xs-4">';

              if(isset($_GET["repnro"])){
                
                echo'<h1>Entrega de Reparto Nro: '.$_GET["repnro"].'</h1>';

              } 
            echo'         
            </div>';            
                
          }

        echo'
          <div class="col-xs-4"></div>
          <div class="col-xs-4" style="padding-right: 0px">

            <button class="btn btn-primary btnVolver" title="Volver a Repartos" padding="15px"><p>Volver a Repartos</p></button>

          </div>

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
              <th style="width: 60px">Accion</th>
              <th>Fecha Entrega</th>
              
            </tr>

          </thead>

          <tbody>
            
            <?php 

              if(isset($_GET["repnro"])){

                $item = "repnro";
                $valor = $_GET["repnro"];
                $item1 = "deliv";

                if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Operador"){

                  $repartos = ControladorRepartos::ctrEntregaRepartoAdm($item, $valor);

                }else{

                  $repartos = ControladorRepartos::ctrEntregaReparto($item, $valor, $item1);
                }
                foreach ($repartos as $key => $value) {

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
              
                    <td style="width:40px">'.$value["nguia"].'</td>

                    <td style="width:40px">'.$value["codcli"].'</td>
              
                    <td style="width:60px">'.$fecharep.'</td>';

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

                        echo '<td style="width:60px"><img src="vistas/img/cars/default/defaultjpg.png" class="img-thumbnail" width="40px"></td>';
                      }

                    }else{

                      echo '<td width="60px"></td>';

                    }

                    if($value["deliv"] != null){
                      
                      if($value["deliv"] == 1){

                        echo '<td style="width:60px"><button class="btn btn-success disabled">Entregada</button></td>';

                      }else{

                        echo '<td style="width:60px">

                        <button class="btn btn-danger disabled">No Entregada</button>
                        
                        <button class="btn btn-primary btnMotivo" motirepnro="'.$value["repnro"].'" motinguia="'.$value["nguia"].'" data-toggle="modal" data-target="#modalMotivo" padding="25px">Motivo NO Entregada</button>

                        </td>';

                      
                      }

                    }else{

                      echo '<td style="width:80px"></td>';

                    }

                    echo '
                    <td style="width:110px">

                      <div class="btn-group">';
                        //var_dump($value["deliv"]);
                        if($value["deliv"] == null){

                          if($codcli != null){

                            if(strcmp($codcli,$value["codcli"]) === 0){

                              echo '<button class="btn btn-success btnEntregaccli buscarCars" repnro="'.$value["repnro"].'" nguia="'.$value["nguia"].'" repnrocar="'.$value["repnro"].'" nguiacar="'.$value["nguia"].'" data-toggle="modal" data-target="#modalEntregaccli" title="Rinde Guia" padding="15px"><p>Rinde Guia</p></button>';

                            }

                          }else{

                            echo '<button class="btn btn-success btnEntregascli" repnrosc="'.$value["repnro"].'" nguiasc="'.$value["nguia"].'" data-toggle="modal" data-target="#modalEntregascli" title="Rinde Guia" padding="15px"><p>Rinde Guia</p></button>';
                        
                          }  

                        }else{

                          if($_SESSION["perfil"] == "Administrador"){

                            if($codcli != null){

                              if(strcmp($codcli,$value["codcli"]) === 0){

                                echo '<button class="btn btn-success btnEntregaccli buscarCars" repnro="'.$value["repnro"].'" nguia="'.$value["nguia"].'" repnrocar="'.$value["repnro"].'" nguiacar="'.$value["nguia"].'" data-toggle="modal" data-target="#modalEntregaccli" title="Rinde Guia" padding="15px"><p>Rinde Guia</p></button>';

                              }

                            }else{

                              echo '<button class="btn btn-success btnEntregascli" repnrosc="'.$value["repnro"].'" nguiasc="'.$value["nguia"].'" data-toggle="modal" data-target="#modalEntregascli" title="Rinde Guia" padding="15px"><p>Rinde Guia</p></button>';
                          
                            }
                            
                          }else{

                            if($value["deliv"] == 1){

                              echo '<button class="btn btn-success disabled" title="Rinde Guia" padding="15px"><p>Rinde Guia</p></button>';

                            }else{

                              echo '<button class="btn btn-success disabled" title="Rinde Guia" padding="15px"><p>Rinde Guia</p></button>';

                            }

                          }

                        }

                      echo '  
                      </div>

                    </td>

                    <td style="width:100px">'.$fecharen.'</td>

                  </tr>';
  
                }

              }

            ?>

          </tbody>

        </table>

      </div>

    </div>

  </section>

</div>

<!-- =================================
MODAL ENTREGA GUIA CON CLIENTE CAR
===================================-->

<div id="modalEntregaccli" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
  
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

      <!-- CABEZA DEL MODAL -->

        <div class="modal-header" style="background:#3c8dbc; color: white">
  
          <h4 class="modal-title">Guia con CAR de Cliente</h4>
  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
  
        </div>

        <!-- CUERPO DEL MODAL -->

        <div class="modal-body">

          <div class="box-body">
            
            <!-- ENTRADA PARA LA GUIA -->        

            <div class="form-group">

              <div class="col-xs-6" style="padding-left: 0px">
              
                <div class="input-group">
                
                  <label for="guia">Guia Nro</label>

                  <input type="text" class="form-control input-lg" style="font-weight: bold" id="editarGuiacc" name="editarGuiacc" value="" readonly>

                  <input type="hidden" id="codclicc" name="codclicc">
                  <input type="hidden" id="repnrocc" name="repnrocc">
                  <input type="hidden" id="cuitfle" name="cuitfle">
                  <input type="hidden" id="sucuradm" name="sucuradm">
                  <input type="hidden" id="buscarAdmin" name="buscarAdmin">
                  <input type="hidden" id="buscarNombre" name="buscarNombre">
                  <input type="hidden" id="buscarOrg" name="buscarOrg">
                  <input type="hidden" id="buscarDst" name="buscarDst">
                  <input type="hidden" id="buscarRemitente" name="buscarRemitente">
                  <input type="hidden" id="buscarDestinatario" name="buscarDestinatario">
                
                </div>

              </div>

              <div class="col-xs-6" style="padding-left: 0px">
              
                <div class="input-group">
                
                  <label for="fecharepar">Fecha del Reparto</label>

                  <input type="text" class="form-control input-lg" style="font-weight: bold" id="editarFecRepar" name="editarFecRepar" value="" readonly>
                  
                </div>

              </div>
          
            </div>

            <div class="form-group">
              <div class="col-xs-6" style="padding-left: 0px">
                <div class="radio">
                  <br>
                  <label style="font-weight: bold" >
                  <input type="radio" class="entrega" name="entregacc" id="entregadacc" value="si" checked>
                  Guia Entregada</label>
                </div>
              </div>
              <div class="col-xs-6" style="padding-left: 0px">
                <div class="radio">
                  <br>
                  <label style="font-weight: bold" >
                  <input type="radio" class="entrega" name="entregacc" id="noentregadacc" value="no">
                  Guia NO Entregada</label>
                </div>
              </div>
            </div>

            <div class="form-group">

              <br>
              <label for="txtDescripcion">¿Por que NO se entregó?:</label>
              <br>
              <textarea id="txtDescripcion" name="txtDescripcion" value="" rows="3" cols="38" style="resize: both;" disabled></textarea>
                 
            </div>
            
          </div>

          <div class="form-group">

            <input type="file" class="nuevaFoto" name="nuevaFoto" id="nuevaFoto" accept="image/*" capture="camera">

            <p class="help-block">Peso máximo del archivo 5 MB</p>

            <img src="vistas/img/cars/default/defaultjpg.png" class="img-thumbnail previsualizar" width="100px">

          </div>

        </div>

        <!-- PIE DEL MODAL -->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Cambios</button>

        </div>

        <?php

          $entregaGuiacc = new ControladorRepartos();
          $entregaGuiacc -> ctrEntregaGuiacc();

        ?>

      </form>

    </div>

  </div>

</div>

<!-- =================================
MODAL ENTREGA GUIA SIN CLIENTE CAR
===================================-->

<div id="modalEntregascli" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
  
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

      <!-- CABEZA DEL MODAL -->

        <div class="modal-header" style="background:#3c8dbc; color: white">
  
          <h4 class="modal-title">Guia sin CAR de Cliente</h4>
  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
  
        </div>

        <!-- CUERPO DEL MODAL -->

        <div class="modal-body">

          <div class="box-body">
            
            <!-- ENTRADA PARA LA GUIA -->        

            <div class="form-group">

              <div class="col-xs-6" style="padding-left: 0px">
              
                <div class="input-group">
                
                  <label for="guia">Guia Nro</label>

                  <input type="text" class="form-control input-lg" style="font-weight: bold" id="editarGuiasc" name="editarGuiasc" value="" readonly>

                  <input type="hidden" id="repnrosc" name="repnrosc">
                  <input type="hidden" id="cuitflesc" name="cuitflesc">
                  <input type="hidden" id="sucuradmsc" name="sucuradmsc">
                  <input type="hidden" id="codclisc" name="codclisc" value="">
                
                </div>

              </div>

              <div class="col-xs-6" style="padding-left: 0px">
              
                <div class="input-group">
                
                  <label for="fecharepar">Fecha del Reparto</label>

                  <input type="text" class="form-control input-lg" style="font-weight: bold" id="editarFecReparsc" name="editarFecReparsc" value="" readonly>
                
                </div>

              </div>
          
            </div>

            <div class="form-group">

              <div class="col-xs-6" style="padding-left: 0px">

                <div class="radio">

                  <br>

                  <label style="font-weight: bold" >

                  <input type="radio" class="entregasc" name="entregasc" id="entregadasc" value="si" checked>

                  Guia Entregada</label>

                </div>

              </div>

              <div class="col-xs-6" style="padding-left: 0px">
              
                <div class="radio">
              
                  <br>
              
                  <label style="font-weight: bold">
              
                  <input type="radio" class="entregasc" name="entregasc" id="noentregadasc" value="no">
              
                  Guia NO Entregada</label>
              
                </div>
              
              </div>
            
            </div>

            <div class="form-group">

              <br>
            
              <label for="txtSinCliente">¿Por que NO se entregó?:</label>
            
              <br>
            
              <textarea id="txtSinCliente" name="txtSinCliente" value="" rows="3" cols="38 style="resize: both;" disabled></textarea>
                 
            </div>
            
          </div>

        </div>

        <!-- PIE DEL MODAL -->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Cambios</button>

        </div>

        <?php

          $entregaGuiasc = new ControladorRepartos();
          $entregaGuiasc -> ctrEntregaGuiasc();

        ?> 

      </form>

    </div>

  </div>

</div>

<!-- =================================
MODAL MOTIVO DE NO ENTREGA DE GUIA
===================================-->

<div id="modalMotivo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
  
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

      <!-- CABEZA DEL MODAL -->

        <div class="modal-header" style="background:#3c8dbc; color: white">
  
          <h4 class="modal-title">MOTIVO DE NO ENTREGA</h4>
  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
  
        </div>

        <!-- CUERPO DEL MODAL -->

        <div class="modal-body">

          <div class="box-body">
            
            <!-- ENTRADA PARA LA GUIA -->        

            <div class="form-group">

              <div class="col-xs-6" style="padding-left: 0px">
              
                <div class="input-group">
                
                  <label for="guia">Guia Nro</label>

                  <input type="text" class="form-control input-lg" style="font-weight: bold" id="muestraGuia" name="muestraGuia" value="" readonly>
                
                </div>

              </div>

              <div class="col-xs-6" style="padding-left: 0px">
              
                <div class="input-group">
                
                  <label for="fecharepar">Fecha del Reparto</label>

                  <input type="text" class="form-control input-lg" style="font-weight: bold" id="muestraFecha" name="muestraFecha" value="" readonly>
                
                </div>

              </div>
          
            </div>

            <div class="form-group">

              <br>
            
              <label for="motivoNoEntrega">¿Por que NO se entregó?:</label>
            
              <br>
            
              <textarea name="motivoNoEntrega" id="motivoNoEntrega" value="" rows="3" cols="80" style="resize: both;" disabled></textarea>
                 
            </div>
            
          </div>

        </div>

        <!-- PIE DEL MODAL -->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Salir</button>

        </div>

      </form>

    </div>

  </div>

</div>

<!-- ================================================= -->
<script>
  
  $(function(){

    $(".entrega").click(function(){
      
      if($(this).val()=="no"){

        $("#txtDescripcion").removeAttr("disabled");
        
        $("#txtDescripcion").focus();
      
      }else{

        $("#txtDescripcion").addAttr("readonly");
        
        $("#txtDescripcion").attr("disabled","disabled");
      
      }

      if($(this).val()=="si"){

        $("#txtDescripcion").addAttr("readonly");
        $("#txtDescripcion").attr("disabled","disabled");
      
      }else{

        $("#txtDescripcion").removeAttr("disabled");
        
        $("#txtDescripcion").focus();      

      }

    })

  })

</script>

<script>
  
  $(function(){

    $(".entregasc").click(function(){
      
      if($(this).val()=="no"){

        $("#txtSinCliente").removeAttr("disabled");
        
        $("#txtSinCliente").focus();
      
      }else{

        $("#txtSinCliente").addAttr("readonly");
        
        $("#txtSinCliente").attr("disabled","disabled");
      
      }

      if($(this).val()=="si"){

        $("#txtSinCliente").addAttr("readonly");
        $("#txtSinCliente").attr("disabled","disabled");
      
      }else{

        $("#txtSinCliente").removeAttr("disabled");
        
        $("#txtSinCliente").focus();      

      }

    })

  })

</script>