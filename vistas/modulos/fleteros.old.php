<div class="content-wrapper">
  
  <section class="content-header">
      
    <h1>

      Administrar Fleteros
        
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Fleteros</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarFletero">

          Agregar Fletero
        
        </button>
        
      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablas">
          
          <thead>
            
            <tr>
              
              <th style="width: 10px">#</th>
              <th>C.U.I.T</th>
              <th>Foto</th>
              <th>Nombre</th>
              <th>Usuario</th>
              <th>Oficina</th>
              <th>Estado</th>
              <th>Último Login</th>
              <th>Acciones</th>

            </tr>

          </thead>

          <tbody>
            
            <?php 

              $item = null;
              $valor = null;
              
              $usuarios = ControladorFleteros::ctrMostrarFletero($item, $valor);

              foreach ($usuarios as $key => $value) {

                if($value["ultimo_login"] != 0){

                  $ultlog = date("d/m/Y H:m:s", strtotime($value["ultimo_login"]));

                }else{

                  $ultlog = $value["ultimo_login"];

                }

                echo '<tr>

                  <td style="width:10px">'.($key+1).'</td>
              
                  <td style="width:60px">'.$value["cuitfle"].'</td>';

                  if($value["foto"] != ""){ 

                     echo '<td style="width:50px"><img src="'.$value["foto"].'" class="img-thumbnail" width="40px"></td>';
                    
                  }else{

                    echo '<td style="width:50px"><img src="vistas/img/fleteros/default/default_fletero.png" class="img-thumbnail" width="40px"></td>';
                  }

                  echo '
              
                  <td style="width:80px">'.$value["nombre"].'</td>

                  <td style="width:80px">'.$value["usuario"].'</td>';

                  $itemOff = "id";
                  $valorOff = $value["sucadm"];

                  $oficina = ControladorSucursal::ctrMostrarSucursales($itemOff, $valorOff);

                  echo '<td style="width:100px">'.$oficina["denom"].'</td>';
        
                  if($_SESSION["perfil"] == "Administrador"){

                    if($value["estado"] != 0){

                      echo '<td style="width:60px"><button class="btn btn-success btn-xs btnActivarFle" idFletero="'.$value["id"].'" estadoFletero="0">Activo</button></td>';

                    }else{

                      echo '<td style="width:60px"><button class="btn btn-danger btn-xs btnActivarFle" idFletero="'.$value["id"].'" estadoFletero="1">Inactivo</button></td>';

                    }

                  }else{

                    if($value["estado"] != 0){

                      echo '<td style="width:60px"><button class="btn btn-success btn-xs disabled">Activo</button></td>';

                    }else{

                      echo '<td style="width:60px"><button class="btn btn-danger btn-xs disabled">Inactivo</button></td>';

                    }

                  }

                  echo '

                  <td style="width:100px">'.$ultlog.'</td>
              
                  <td style="width:110px">

                    <div class="btn-group">';

                      if($_SESSION["perfil"] == "Administrador"){
                        
                        echo '<button class="btn btn-warning btnEditarFletero" data-toggle="modal" data-target="#modalEditarFletero" idFletero="'.$value["id"].'" fotoFletero="'.$value["foto"].'" usuario="'.$value["usuario"].'" perfil="'.$value["perfil"].'" oficina="'.$value["sucadm"].'" title="Editar Fletero"><i class="fa fa-pencil"></i></button>

                        <button class="btn btn-danger btnEliminarFletero" idFletero="'.$value["id"].'" fotoFletero="'.$value["foto"].'" usuario="'.$value["usuario"].'" perfil="'.$value["perfil"].'" title="Eliminar Fletero"><i class="fa fa-times"></i></button>';

                      }

                      if($_SESSION["perfil"] == "Operador"){

                        echo '<button class="btn btn-warning btnEditarFletero" idFletero="'.$value["id"].'" fotoFletero="'.$value["foto"].'" usuario="'.$value["usuario"].'" perfil="'.$value["perfil"].'" oficina="'.$value["sucadm"].'" data-toggle="modal" data-target="#modalEditarFletero" title="Editar Fletero"><i class="fa fa-pencil"></i></button>';

                      }

                      if($_SESSION["perfil"] == "Fletero"){
                      
                        if($_SESSION["usuario"] == $value["usuario"]){
                          
                          echo '<button class="btn btn-warning btnEditarFletero" idFletero="'.$value["id"].'" fotoFletero="'.$value["foto"].'" usuario="'.$value["usuario"].'" perfil="'.$value["perfil"].'" oficina="'.$value["sucadm"].'" data-toggle="modal" data-target="#modalEditarFletero" title="Editar Fletero"><i class="fa fa-pencil"></i></button>';

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
MODAL AGREGAR FLETERO 
===================================-->

<div id="modalAgregarFletero" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
  
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!-- =================================
          CABEZA DEL MODAL  
        ===================================-->

        <div class="modal-header" style="background:#3c8dbc; color: white">
  
          <h4 class="modal-title">Agregar Fletero</h4>
  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
  
        </div>

        <!-- =================================
          CUERPO DEL MODAL 
        ===================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL CUIT -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoCuit" placeholder="Ingrese C.U.I.T." required>

              </div>
          
            </div>
            
            <!-- ENTRADA PARA EL NOMBRE -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoFletero" placeholder="Ingrese Nombre" required>

              </div>
          
            </div>

            <!-- ENTRADA PARA EL USUARIO -->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" id="nuevoUsuarioFle" name="nuevoUsuarioFle" placeholder="Ingrese Usuario" required>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA CONTRASEÑA  -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="password" class="form-control input-lg" name="nuevaPasswordFle" placeholder="Ingrese Clave" required>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA EL PERFIL  -->        

            <div class="form-group">

              <div class="sucur col-xs-12" style="padding-left: 0px">
                
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

            <!-- ENTRADA PARA SUBIR FOTO  -->        

            <div class="form-group">

              <div class="panel">SUBIR FOTO</div>

              <input type="file" class="nuevaFotoFle" name="nuevaFotoFle">

              <p class="help-block">Peso máximo del archivo 3 MB</p>

              <img src="vistas/img/fleteros/default/default_fletero.png" class="img-thumbnail previsualizarFle" width="100px">

            </div>

          </div>

        </div>

        <!-- =================================
          PIE DEL MODAL 
        ===================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Fletero</button>

        </div>

        <?php

          $crearFletero = new ControladorFleteros();
          $crearFletero -> ctrCrearFletero();

        ?>

      </form>

    </div>

  </div>

</div>

<!-- =================================
MODAL EDITAR FLETERO 
===================================-->

<div id="modalEditarFletero" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
  
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!-- =================================
          CABEZA DEL MODAL  
        ===================================-->

        <div class="modal-header" style="background:#3c8dbc; color: white">
  
          <h4 class="modal-title">Editar Fletero</h4>
  
          <button type="button" class="close" data-dismiss="modal">&times;</button>
  
        </div>

        <!-- =================================
          CUERPO DEL MODAL 
        ===================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL CUIT -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>

                <input type="text" class="form-control input-lg" id="editarCuit" name="editarCuit" value="" required>

              </div>
          
            </div>
            
            <!-- ENTRADA PARA EL NOMBRE -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg" id="editarFletero" name="editarFletero" value="" required>

              </div>
          
            </div>

            <!-- ENTRADA PARA EL USUARIO -->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" id="editarUsuarioFle" name="editarUsuarioFle" value="" required readonly>
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA CONTRASEÑA  -->        

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="password" class="form-control input-lg editarPasswordFle" name="editarPasswordFle" placeholder="Ingrese Nueva Clave" required>

                <input type="hidden" id="passwordFleActual" name="passwordFleActual">
                 
              </div>
            
            </div>

            <!-- ENTRADA PARA LA SUCURSAL  -->        

            <div class="form-group">

              <div class="sucur col-xs-12" style="padding-left: 0px">
                
                <div class="input-group">
                    
                  <span class="input-group-addon"><i class="fa fa-industry"></i></span>

                  <input type="text" class="form-control input-lg" id="editarSucAdm" name="editarSucAdm" value="" readonly>
                  <input type="hidden" id="actualSucursalAdm" name="actualSucursalAdm"> 
                
                </div>

              </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO  -->        

            <div class="form-group">

              <div class="panel">SUBIR FOTO</div>

              <input type="file" class="nuevaFotoFle" name="editarFotoFle">

              <p class="help-block">Peso máximo del archivo 3 MB</p>

              <img src="vistas/img/fleteros/default/default_fletero.png" class="img-thumbnail previsualizarFle" width="100px">

              <input type="hidden" name="fotoFletero" id="fotoFletero">

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

          $editarFletero = new ControladorFleteros();
          $editarFletero -> ctrEditarFletero();

        ?>

      </form>

    </div>

  </div>

</div>

<!-- <?php  

  //$borrarFletero = new ControladorFleteros();
  //$borrarFletero -> ctrBorrarFletero();

?> -->