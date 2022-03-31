<div class="content-wrapper">
  
  <section class="content-header">
      
    <h1>

      Administrar Repartos
        
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Repartos</li>

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
              <th>Reparto</th>
              <th>Fecha</th>
              <th>Fletero</th>
              <th>Guias</th>
              <th>Rendido</th>
              <th>Fecha Rindio</th>
              <th>Acciones</th>

            </tr>

          </thead>

          <tbody>
            
            <?php 

              if($_SESSION["perfil"] == "Fletero"){

                $item = "cuitfle";
                $valor = $_SESSION["cuitfle"];

                $repartos = ControladorRepartos::ctrVerRepartos($item, $valor);
                //var_dump($repartos);
              }else{

                $item = null;
                $valor = null;

                $repartos = ControladorRepartos::ctrVerRepartos($item, $valor);

              }
            
              foreach ($repartos as $key => $value) {

                if(strcmp($value["cuitfle"] , "33531122599") === 0){

                }else{

                  if($value["frepar"] != 0){

                    $fecharep = date("d/m/Y", strtotime($value["frepar"]));
                  
                  }else{

                    $fecharep = $value["frepar"];
                  }

                  if($value["frendir"] != 0){

                    $fecharen = date("d/m/Y", strtotime($value["frendir"]));

                  }else{

                    $fecharen = $value["frendir"];

                  }

                  echo '

                  <tr>

                    <td style="width:10px">'.($key+1).'</td>
              
                    <td style="width:60px">'.$value["repnum"].'</td>
              
                    <td style="width:80px">'.$fecharep.'</td>';

                    $itemfle = "cuitfle";
                    $valorfle = $value["cuitfle"];

                    $nomFletero = ControladorFleteros::ctrMostrarFletero($itemfle, $valorfle);

                    echo '

                    <td style="width:120px">'.$nomFletero["nombre"].'</td>

                    <td style="width:80px">'.$value["cantg"].'</td>';

                    if($value["rendido"] != 0){

                      echo '<td style="width:60px"><button class="btn btn-success btn-xs disabled">Rendido</button></td>';

                    }else{

                      echo '<td style="width:60px"><button class="btn btn-danger btn-xs disabled">Sin Rendir</button></td>';

                    }

                    echo '<td style="width:100px">'.$fecharen.'</td>
              
                    <td style="width:110px">

                      <div class="btn-group">';

                        echo '<button class="btn btn-success btnEntregaReparto" repnro="'.$value["repnum"].'" data-toggle="modal" data-target="#modalEntregaReparto" title="Entregar Reparto" padding="10px"><i class="fa fa-truck" aria-hidden="true"></i>';

                        if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Operador"){

                          echo '<button class="btn btn-warning" title="Rendir Reparto"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>';

                        }

                        if($_SESSION["perfil"] == "Administrador"){
                        
                          echo '<button class="btn btn-danger" title="Eliminar Reparto"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i>';

                        }
                      
                      echo '
                      </div>

                    </td>

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

<!-- <?php 

  // $entregaReparto = new ControladorRepartos();
  // $entregaReparto -> ctrEntregaReparto();

 ?> -->