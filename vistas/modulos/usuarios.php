<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar Usuarios

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
      <li class="active">Administrar Usuarios</li>

    </ol>
    
  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
          
          Agregar Usuario

        </button>

      </div>
        
      <div class="box-body">
       
        <table class="table table-bordered table-striped dt-responsive tablas">
          
          <thead>
            
            <tr>
              
              <th style="width: 10px">#</th>
              <th>Nombre</th>
              <th>Usuario</th>
              <th>Foto</th>
              <th>Perfil</th>
              <td>Oficina</td>
              <th>Estado</th>
              <th>Último Login</th>
              <th>Acciones</th>

            </tr>

          </thead>

          <tbody>

            <?php

              $item = null;
              $valor = null;

              $usuarios = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

              foreach ($usuarios as $key => $value) {

                if($value["ultimo_login"] != 0){

                  $ultlog = date("d/m/Y H:m:s", strtotime($value["ultimo_login"]));

                }else{

                  $ultlog = $value["ultimo_login"];

                }

                echo '<tr>

                  <td style="width:10px">'.($key+1).'</td>
              
                  <td style="width:150px">'.$value["nombre"].'</td>
              
                  <td style="width:80px">'.$value["usuario"].'</td>';
              
                  if($value["foto"] != ""){ 

                     echo '<td style="width:60px"><img src="'.$value["foto"].'" class="img-thumbnail" width="40px"></td>';
                    
                  }else{

                    echo '<td style="width:60px"><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
                  }
              
                  echo '<td style="width:150px">'.$value["perfil"].'</td>';

                  $itemOff = "id";
                  $valorOff = $value["id_oficina"];

                  $oficina = ControladorSucursal::ctrMostrarSucursales($itemOff, $valorOff);

                  echo '<td style="width:100px">'.$oficina["denom"].'</td>';
        
                  if($_SESSION["perfil"] == "Administrador"){

                    if($value["estado"] != 0){

                      echo '<td style="width:60px"><button class="btn btn-success btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="0">Activo</button></td>';

                    }else{

                      echo '<td style="width:60px"><button class="btn btn-danger btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="1">Inactivo</button></td>';

                    }

                  }else if($_SESSION["perfil"] == "Operador"){

                    if($value["estado"] != 0){

                      echo '<td style="width:60px"><button class="btn btn-success btn-xs disabled">Activo</button></td>';

                    }else{

                      echo '<td style="width:60px"><button class="btn btn-danger btn-xs disabled">Inactivo</button></td>';

                    }

                  }  

                echo '

                  <td style="width:100px">'.$ultlog.'</td>';
                  
                  // <td>'.$value["codcli_legajo"].'</td>
              
                echo '  <td style="width:110px">
              
                    <div class="btn-group">';

                      if($_SESSION["perfil"] == "Operador"){

                        if($value["perfil"] != "Administrador"){

                          echo '<button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value["id"].'" fotoUsuario="'.$value["foto"].'" usuario="'.$value["usuario"].'" perfil="'.$value["perfil"].'" oficina="'.$value["id_oficina"].'" data-toggle="modal" data-target="#modalEditarUsuario" title="Editar Usuario"><i class="fa fa-pencil"></i></button>';

                        }
                        
                      }else{
                      
                        echo '<button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value["id"].'" fotoUsuario="'.$value["foto"].'" usuario="'.$value["usuario"].'" perfil="'.$value["perfil"].'" oficina="'.$value["id_oficina"].'" data-toggle="modal" data-target="#modalEditarUsuario" title="Editar Usuario"><i class="fa fa-pencil"></i></button>';
                      }

                      if($_SESSION["perfil"] == "Administrador"){
                        
                        echo '<button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["id"].'" fotoUsuario="'.$value["foto"].'" usuario="'.$value["usuario"].'" perfil="'.$value["perfil"].'" title="Eliminar Usuario"><i class="fa fa-times"></i></button>';
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
MODAL AGREGAR USUARIO 
===================================-->

<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
  
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!-- =================================
          CABEZA DEL MODAL  
        ===================================-->

        <div class="modal-header" style="background:#3c8dbc; color: white">
  
          <h4 class="modal-title">Agregar Usuario</h4>
  
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

                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingrese Nombre" required>

              </div>
          
            </div>

            <!-- ENTRADA PARA EL USUARIO -->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoUsuario" placeholder="Ingrese Usuario" id="nuevoUsuario" required>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA CONTRASEÑA  -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="password" class="form-control input-lg" name="nuevaPassword" placeholder="Ingrese Clave" autocomplete="off" required>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA EL PERFIL  -->        

            <div class="form-group">

            	<div class="col-xs-6" style="padding-left: 0px">
              
              	<div class="input-group">
                
                	<span class="input-group-addon"><i class="fa fa-users"></i></span>

                	<select class="form-control input-lg" name="nuevoPerfil" id="nuevoPerfil">
                  
	                  <option value="">Selecionar Perfil</option>
                    <?php
                      
                      if($_SESSION["perfil"] == "Administrador"){
	                    
                        echo '<option value="Administrador">Administrador</option>
                              <option value="Operador">Operador</option>';
                      
                      }else{
                      
                        echo '<option value="Operador">Operador</option>';
                      
                      }
                    
                    ?>
	                  
                	</select> 
              
              	</div>

              </div>

              <div class="sucur col-xs-6" style="padding-right: 0px">
                
                <div class="input-group">
                    
                  <span class="input-group-addon"><i class="fa fa-industry"></i></span>

                  <select class="form-control input-lg" name="nuevaSucursal" id="nuevaSucursal">
                    
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

            <!-- ENTRADA PARA SUBIR FOTO o LOGO  -->        

            <div class="form-group">

              <div class="panel">SUBIR FOTO o LOGO</div>

              <input type="file" class="nuevaFoto" name="nuevaFoto">

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

          <button type="submit" class="btn btn-primary">Guardar Usuario</button>

        </div>

        <?php

          $crearUsuario = new ControladorUsuarios();
          $crearUsuario -> ctrCrearUsuario();

        ?>

      </form>

    </div>

  </div>

</div>

<!-- =================================
MODAL EDITAR USUARIO
===================================-->

<div id="modalEditarUsuario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
  
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

      <!-- CABEZA DEL MODAL -->

        <div class="modal-header" style="background:#3c8dbc; color: white">
  
          <h4 class="modal-title">Editar Usuario</h4>
  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
  
        </div>

        <!-- CUERPO DEL MODAL -->

        <div class="modal-body">

          <div class="box-body">
            
            <!-- ENTRADA PARA EL NOMBRE -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>

                <input type="hidden" id="editarId" name="editarId">
                <input type="hidden" name="editarEstado" id="editarEstado" value="">
                <input type="hidden" name="editarUltimo_login" id="editarUltimo_login">
                <input type="hidden" name="EditarFecha_alta" id="EditarFecha_alta">
                
              </div>
          
            </div>

            <!-- ENTRADA PARA EL USUARIO -->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                
                <input type="text" class="form-control input-lg editaUsuario" id="editarUsuario" name="editarUsuario" value="" required readonly>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA CONTRASEÑA  -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="password" class="form-control input-lg editarPassword" id="editarPassword" name="editarPassword" placeholder="Ingrese nueva Clave" autocomplete="off" required>

                <input type="hidden" id="passwordActual" name="passwordActual">
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA EL PERFIL  -->        

            <div class="form-group">

              <div class="col-xs-6" style="padding-left: 0px">
              
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-users"></i></span>

                  <input type="text" class="form-control input-lg" id="editarPerfil" name="editarPerfil" value="" readonly>
                
                </div>

              </div>

              <div class="cajaEditaSucur col-xs-6" style="padding-right: 0px">
                
                <div class="input-group">
                    
                  <span class="input-group-addon"><i class="fa fa-industry"></i></span>

                  <input type="text" class="form-control input-lg" id="editarSucursal" name="editarSucursal" value="" readonly>
                  <input type="hidden" id="actualSucursal" name="actualSucursal">
                               
                </div>

              </div>

            </div>

            <!-- ENTRADA PARA LA FOTO  -->        

            <div class="form-group">

              <div class="panel">CAMBIAR FOTO</div>

              <input type="file" class="nuevaFoto" name="editarFoto">

              <p class="help-block">Peso máximo del archivo 5 MB</p>

              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="fotoActual" id="fotoActual">

            </div>
            
          </div>

        </div>

        <!-- PIE DEL MODAL -->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Cambios</button>

        </div>

        <?php

          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();

        ?>

      </form>

    </div>

  </div>

</div>

<?php

  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario -> ctrBorrarUsuario();

  // $borrarCars = new ControladorCars();
  // $borrarCars -> ctrBorrarCarUs();

  // $borrarCliente = new ControladorClientes();
  // $borrarCliente -> ctrBorrarClienteUs();


?>
