  <div class="content-wrapper">

    <section class="content-header">

      <h1>

        INICIO

        <small>Panel de Control</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

        <li class="active">Tablero</li>

      </ol>

    </section>

    <section class="content">

      <div class="row">
        
        <?php

          if($_SESSION["perfil"] == "Administrador"){

            include "inicio/cajas-superiores.php";

          }

        ?>

      </div>

      <div class="col-lg-12">
        
        <?php

          if($_SESSION["perfil"] == "Operador" || $_SESSION["perfil"] == "Cliente" || $_SESSION["perfil"] == "Fletero"){

            echo '<div class="box box-success">

            <div class="box-header">

            <h1>Bienvenid@ '.$_SESSION["nombre"].'</h1>

            </div>

            </div>';

          }

        ?>

      </div>

    </section>

  </div>

