<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Modulo del Cliente:

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
      
      <li class="active">Modulo de Clientes</li>

    </ol>
    
  </section>

  <section class="content">

    <div class="box">

      <div class="box-body">
       
        <table class="table table-bordered table-striped dt-responsive tablas">
          
          <thead>
            
            <tr>
              
              <th style="width: 10px">#</th>
              <th style="width: 150px">Nombre/Razón Social</th>
              <th style="width: 30px">Codigo Cliente</th>
              <th>Admin Sucursal</th>
              <th style="width: 200px">Email 1</th>
              <th style="width: 200px">Email 2</th>
              <th style="width: 200px">Email 3</th>
              <th>C.U.I.T.</th>
              <th>Usuario</th>
              <th>Foto/Logo</th>
              <th>Último Login</th>
              <th>Acciones</th>

            </tr>

          </thead>

          <tbody>

            <?php

            $item = "usuario";
            $valor = $_SESSION['usuario'];
            //$orden = "usuario";

            $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);

            //var_dump($cliente);

            //foreach ($clientes as $key => $value) {

              if($cliente["ultimo_login"] != 0){

                $ultlog = date("d/m/yy H:m:s", strtotime($cliente["ultimo_login"]));

              }else{

                $ultlog = $cliente["ultimo_login"];

              }
              
              echo '<tr>

              <td style="width:10px">'.$cliente["id"].'</td>
              
              <td>'.$cliente["nombre"].'</td>

              <td>'.$cliente["codcli"].'</td>';

              $itemOff = "id";
              $valorOff = $cliente["sucadm"];

              $oficina = ControladorSucursal::ctrMostrarSucursales($itemOff, $valorOff);

              echo '<td style="width:100px">'.$oficina["denom"].'</td>
              
              <td>'.$cliente["email1"].'</td>

              <td>'.$cliente["email2"].'</td>

              <td>'.$cliente["email3"].'</td>

              <td>'.$cliente["cuit"].'</td>

              <td>'.$cliente["usuario"].'</td>';

              if($cliente["foto"] != ""){

                echo '<td><img src="'.$cliente["foto"].'" class="img-thumbnail" width="40px"></td>';
                
              }else{

                echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
                
              }

              echo '<td>'.$ultlog.'</td>

              <td>
              
              <div class="btn-group">';

              if($_SESSION["usuario"] == $cliente["usuario"]){

                  echo '<button class="btn btn-warning btnEditarCliente" idCliente="'.$cliente["id"].'" oficina="'.$cliente["sucadm"].'" data-toggle="modal" data-target="#modalEditarCliente" title="Editar Cliente"><i class="fa fa-pencil"></i></button>';

              }
              
              echo '</div>
              
              </td>

              </tr>';

            //}

            ?>
            
          </tbody>

        </table>

      </div>

    </div>

  </section>

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

                  <input type="text" class="form-control input-lg" name="editarEmail1" id="editarEmail1" value="">
                  
                </div>
                
              </div>

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                  <input type="text" class="form-control input-lg" name="editarEmail2" id="editarEmail2" value="">
                  
                </div>
                
              </div>

              <div class="form-group">
                
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                  <input type="text" class="form-control input-lg" name="editarEmail3" id="editarEmail3" value="">
                  
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
          $crearUsuario -> ctrEditarUnCliente();

          ?>

        </form>

      </div>

    </div>

  </div>



