<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Modulo de Clientes

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
      
      <li class="active">Modulo de Clientes</li>

    </ol>
    
  </section>

  <section class="content">

    <div class="box">

      <?php 

      if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Operador"){

        echo 
        
        '<div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
        
        Agregar Cliente

        </button>

        </div>';

      }

      ?>
      
      <div class="box-body">
       
        <table class="table table-bordered table-striped dt-responsive tablas">
          
          <thead>
            
            <tr>
              
              <th style="width: 10px">#</th>
              <th style="width: 150px">Nombre/Razón Social</th>
              <th style="width: 30px">Codigo Cliente</th>
              <th>Admin Sucursal</th>
              <th style="width: 200px">Email</th>
              <th>C.U.I.T.</th>
              <th>Usuario</th>
              <th>Foto/Logo</th>
              <th>Último Login</th>
              <th>Acciones</th>

            </tr>

          </thead>

          <tbody>

            <?php

            $item = null;
            $valor = null;
            $orden = "nombre";

            $clientes = ControladorClientes::ctrMostrarClientes($item, $valor, $orden);

            foreach ($clientes as $key => $value) {

              if($value["ultimo_login"] != 0){

                $ultlog = date("d/m/yy H:m:s", strtotime($value["ultimo_login"]));

              }else{

                $ultlog = $value["ultimo_login"];

              }
              
              echo '<tr>

              <td style="width:10px">'.($key+1).'</td>
              
              <td>'.$value["nombre"].'</td>

              <td>'.$value["codcli"].'</td>';

              $itemOff = "id";
              $valorOff = $value["sucadm"];

              $oficina = ControladorSucursal::ctrMostrarSucursales($itemOff, $valorOff);

              echo '<td style="width:100px">'.$oficina["denom"].'</td>
              
              <td>'.$value["email1"].'</td>

              <td>'.$value["cuit"].'</td>

              <td>'.$value["usuario"].'</td>';

              if($value["foto"] != ""){

                echo '<td><img src="'.$value["foto"].'" class="img-thumbnail" width="40px"></td>';
                
              }else{

                echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
                
              }

              echo '<td>'.$ultlog.'</td>

              <td>
              
              <div class="btn-group">';

              if($_SESSION["perfil"] == "Administrador"){

                echo

                '<button class="btn btn-warning btnEditarCliente" idCliente="'.$value["id"].'" oficina="'.$value["sucadm"].'" data-toggle="modal" data-target="#modalEditarCliente" title="Editar Cliente"><i class="fa fa-pencil"></i></button>

                <button class="btn btn-danger btnBorrarCliente" idCliente="'.$value["id"].'"><i class="fa fa-times"></i></button>';

              }else if($_SESSION["perfil"] == "Operador"){

                echo

                '<button class="btn btn-warning btnEditarCliente" idCliente="'.$value["id"].'" oficina="'.$value["sucadm"].'" data-toggle="modal" data-target="#modalEditarCliente" title="Editar Cliente"><i class="fa fa-pencil"></i></button>';

              }else{

                if($_SESSION["codcli_legajo"] == '.$value["codcli"].'){

                  echo '<button class="btn btn-warning btnEditarCliente" idCliente="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCliente" title="Editar Cliente"><i class="fa fa-pencil"></i></button>';

                }

              }
              
              echo '</div>
              
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
MODAL AGREGAR CLIENTE
===================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!-- =================================
          CABEZA DEL MODAL  
          ===================================-->

          <div class="modal-header" style="background:#3c8dbc; color: white">
            
            <h4 class="modal-title">Agregar Cliente</h4>
            
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
          </div>

        <!-- =================================
          CUERPO DEL MODAL 
          ===================================-->

          <div class="modal-body">

            <div class="box-body">

              <?php 

              // $itemCli = null;
              // $valorCli = null;

              // $verCliente = ControladorClientes::ctrMostrarClientes($itemCli, $valorCli);

              ?>            
              <!-- ENTRADA PARA EL NOMBRE -->        

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>

                  <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingrese Nombre / Razón Social" required>

                </div>
                
              </div>

              <!-- ENTRADA PARA EL CODIGO DE CLIENTE -->

              <div class="form-group">

                <div class="col-xs-6" style="padding-left: 0px">

                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>

                    <input type="text" class="form-control input-lg" name="nuevoCodCli" id="nuevoCodCli" placeholder="Ingrese el código del Cliente" required> 
                    
                  </div>

                </div>

                <!-- ENTRADA PARA LA SUCURSAL QUE ADMINISTRA -->

                <div class="sucur col-xs-6" style="padding-right: 0px">

                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-industry"></i></span>

                    <select class="form-control input-lg" name="nuevaSucAdm" id="nuevaSucAdm">
                      
                      <option value="">Selecionar Sucursal</option>
                      
                      <?php
                      
                      $item = null;
                      $valor = null;

                      $sucursales = ControladorSucursal::ctrMostrarSucursales($item, $valor);

                      foreach ($sucursales as $key => $value) {
                        
                        echo '<option value="'.$value["id"].'">'.$value["denom"].'</option>';
                        
                      }
                      
                      ?>
                      
                    </select> 
                    
                  </div>

                </div>

              </div>

              <br>
              <br>
              <br>

              <!-- ENTRADA PARA EL USUARIO -->

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>

                  <input type="text" class="form-control input-lg" name="nuevoUsuarioCli" placeholder="Ingrese Usuario" id="nuevoUsuarioCli" required>
                  
                </div>
                
              </div>

              <!-- ENTRADA PARA CONTRASEÑA  -->        

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                  <input type="password" class="form-control input-lg" name="nuevaPasswordCli" placeholder="Ingrese Clave" required>
                  
                </div>
                
              </div>

              <!-- ENTRADA PARA MAIL  -->        

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                  <input type="text" class="form-control input-lg" name="nuevoEmail1" placeholder="Ingrese el Mail del Cliente" required>
                  
                </div>
                
              </div>

              <!-- ENTRADA PARA CUIT  -->        

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-qrcode"></i></span>

                  <input type="text" class="form-control input-lg" name="nuevoCuit" placeholder="Ingrese el C.U.I.T del Cliente" required>
                  
                </div>
                
              </div>

              <!-- ENTRADA PARA SUBIR FOTO o LOGO  -->        

              <div class="form-group">

                <div class="panel">SUBIR FOTO o LOGO</div>

                <input type="file" class="nuevaFotoCli" name="nuevaFotoCli">

                <p class="help-block">Peso máximo del archivo 5 MB</p>

                <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail visualizaCli" width="100px">

              </div>

            </div>

          </div>

        <!-- =================================
          PIE DEL MODAL 
          ===================================-->

          <div class="modal-footer">

            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">Guardar Cliente</button>

          </div>

          <?php

          $crearUsuario = new ControladorClientes();
          $crearUsuario -> ctrCrearCliente();

          ?>

        </form>

      </div>

    </div>

  </div>

<!-- =================================
MODAL EDITAR CLIENTE
===================================-->

<div id="modalEditarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!-- =================================
          CABEZA DEL MODAL  
          ===================================-->

          <div class="modal-header" style="background:#3c8dbc; color: white">
            
            <h4 class="modal-title">Editar Cliente</h4>
            
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
          </div>

        <!-- =================================
          CUERPO DEL MODAL 
          ===================================-->

          <div class="modal-body">

            <div class="box-body">
              
              <!-- ENTRADA PARA EL NOMBRE -->        

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>

                  <input type="text" class="form-control input-lg" name="editarCliente" id="editarCliente" value="" required>

                </div>
                
              </div>

              <!-- ENTRADA PARA EL CODIGO DE CLIENTE -->

              <div class="form-group">

                <div class="col-xs-6" style="padding-left: 0px">

                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>

                    <input type="text" class="form-control input-lg" name="editarCodCli" id="editarCodCli" value="" readonly> 
                    
                  </div>

                </div>

                <!-- ENTRADA PARA LA SUCURSAL QUE ADMINISTRA -->

                <div class="sucur col-xs-6" style="padding-right: 0px">

                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-industry"></i></span>

                    <input type="text" class="form-control input-lg" id="editarSucAdm" name="editarSucAdm" value="" readonly>
                    <input type="hidden" id="actualSucAdm" name="actualSucAdm">
                    
                  </div>

                </div>

              </div>

              <br>
              <br>
              <br>

              <!-- ENTRADA PARA EL USUARIO -->

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>

                  <input type="text" class="form-control input-lg editarUsuarioCl" name="editarUsuarioCl" id="editarUsuarioCl" value="" readonly>
                  
                </div>
                
              </div>

              <!-- ENTRADA PARA CONTRASEÑA  -->        

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                  <input type="password" class="form-control input-lg editarPasswordCli" name="editarPasswordCli" placeholder="Ingrese Clave" required>

                  <input type="hidden" id="passwordActualCli" name="passwordActualCli">
                  
                </div>
                
              </div>

              <!-- ENTRADA PARA MAIL  -->        

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                  <input type="text" class="form-control input-lg" name="editarEmail1" id="editarEmail1" required>
                  
                </div>
                
              </div>

              <!-- ENTRADA PARA CUIT  -->        

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-qrcode"></i></span>

                  <input type="text" class="form-control input-lg" name="editarCuit" id="editarCuit" required>
                  
                </div>
                
              </div>

              <!-- ENTRADA PARA SUBIR FOTO o LOGO  -->        

              <div class="form-group">

                <div class="panel">SUBIR FOTO o LOGO</div>

                <input type="file" class="editarFotoCli" name="editarFotoCli">

                <p class="help-block">Peso máximo del archivo 5 MB</p>

                <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail visualizaCli" width="100px">

                <input type="hidden" name="fotoActualCli" id="fotoActualCli">

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

          $crearUsuario = new ControladorClientes();
          $crearUsuario -> ctrEditarCliente();

          ?>

        </form>

      </div>

    </div>

  </div>



