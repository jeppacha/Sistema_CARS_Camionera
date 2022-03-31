<div id="back"></div>

<div class="login-box">
  
  <div class="login-logo">
    
    <img src="vistas/img/plantilla/logo-camio-grande.png" class="img-responsive" style="padding: 30px 75px 0px 75px">
  
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    
    <p class="login-box-msg">Ingresar al Sistema</p>

    <form method="post">

      <div class="form-group has-feedback">

          <span class="glyphicon glyphicon-users form-control-feedbac"></span>

          <select class="form-control input-lg" name="loginPerfil" id="loginPerfil">

            <option value="">Seleccionar Perfil</option>

            <option value="Administrador">Administrador</option>

            <option value="Operador">Operador</option>

            <option value="Fletero">Repartidor</option>

            <option value="Cliente">Cliente</option>

          </select>

      </div>
      <div class="form-group has-feedback">
        
        <input type="text" class="form-control input-lg" placeholder="Usuario" name="ingUsuario" required>
        
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      
      </div>
      
      <div class="form-group has-feedback">
        
        <input type="password" class="form-control input-lg" placeholder="Contraseña" name="ingPassword" autocomplete="off" required>
        
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      
      </div>
      
      <div class="row">
        
        <div class="col-xs-4">
          
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>

        </div>

      </div>

      <?php


        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuario();

      ?>

    </form>

  </div>

</div>

