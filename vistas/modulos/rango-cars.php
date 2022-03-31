<div id="back"></div>

<div class="login-box">
  
  <div class="login-logo">
    
    <img src="vistas/img/plantilla/gestion-remitos-conformados.png" class="img-responsive" style="padding: 30px 75px 0px 75px">
  
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    
    <p class="login-box-msg">Descarga de Cars por Rango</p>

    <form method="post">

      <div class="form-group has-feedback">

          <span class="glyphicon glyphicon-users form-control-feedbac"></span>

          <select class="form-control input-lg" name="sucursalCar" id="sucursalCar">

            <option value="">Seleccionar Sucursal</option>

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
      <div class="form-group has-feedback">
        
        <input type="text" class="form-control input-lg" placeholder="CUIT/CUIL del Cliente" name="clienteCar" id="clienteCar" required>
        
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      
      </div>
            
      <div class="input-group date">
                  
        <button type="button" class="btn btn-default btn-lg" id="daterange-btn">

          <span>

            <i class="fa fa-calendar"></i> Rango de Fechas a Seleccionar

          </span>

          <i class="fa fa-caret-down"></i>

        </button>
    
      </div>
      
      <!--<div class="row">
        
        <div class="col-xs-4">
          
          <button type="submit" class="btn btn-primary btn-block btn-flat">Confirmar</button>

        </div>

      </div>-->

      <!--<?php


        //$login = new ControladorUsuarios();
        //$login -> ctrIngresoUsuario();

      ?>-->

    </form>

  </div>

</div>

