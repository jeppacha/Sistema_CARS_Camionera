<?php

 session_start();
 
?>

<!DOCTYPE html>
<html  lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Camionera Mendocina | Cars</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="vistas/img/plantilla/logo-titulo1.png">

  <!--=====================================
  PLUGIN DE CCS
  ======================================-->

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  
  <!-- AdminLTE Skins. -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">

  <!-- DataRange Picker-->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- Morris.js - Charts -->
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">

  <!--=====================================
  PLUGIN DE JAVASCRIPT
  ======================================-->

  <!-- jQuery 3 -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
  
  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  
  <!-- FastClick -->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  
  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>

    <!-- DataTables -->
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>

  <!-- SweetAlert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>

  <!-- InputMask -->
  <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>

  <!-- DataRange Picker  página oficial: https://www.daterangepicker.com/-->
  <!-- <script src="vistas/bower_components/moment/min/moment.min.js"></script> -->
  <script src="vistas/bower_components/moment/moment.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Morris.js - Charts -->
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>

  <!-- ChartJS - https://www.chartjs.org/ -->

  <script src="vistas/bower_components/chart.js/Chart.js"></script>
     
<!--=====================================
CUERPO DEL DOCUMENTO
======================================-->
</head>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
<!-- Site wrapper -->


  <?php

    if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){

      echo '<div class="wrapper">';

        /*=============================================
        CABECERA
        =============================================*/

        include "vistas/modulos/cabecera.php";

        /*=============================================
        MENU
        =============================================*/

        include "vistas/modulos/menu.php";

        /*=============================================
        CONTENIDO
        =============================================*/
        if(isset($_GET["ruta"])){

          if($_GET["ruta"] == "inicio" ||
             $_GET["ruta"] == "usuarios" ||
             $_GET["ruta"] == "fleteros" ||
             $_GET["ruta"] == "entrega-reparto" ||
             $_GET["ruta"] == "clientes" ||
             $_GET["ruta"] == "modcliente" ||
             $_GET["ruta"] == "cars" ||
             $_GET["ruta"] == "alta-cars" ||
             $_GET["ruta"] == "cars-clientes" ||
             $_GET["ruta"] == "rango-cars" ||
             $_GET["ruta"] == "sube-bases" ||
             $_GET["ruta"] == "sube-reparto" ||
             $_GET["ruta"] == "repartos" ||
             $_GET["ruta"] == "salir"){

            include "vistas/modulos/".$_GET["ruta"].".php";

          }else{

            include "vistas/modulos/404.php";
            
          }

        }else{

          include "vistas/modulos/inicio.php";

        }
        

        /*=============================================
        FOOTER
        =============================================*/

        include "vistas/modulos/footer.php";

      echo '</div>';

    }else{

      include "vistas/modulos/login.php";
    }

  ?>

<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/fleteros.js"></script>
<script src="vistas/js/repartos.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/cars.js"></script>
<script src="vistas/js/guias.js"></script>

</body>
</html>
