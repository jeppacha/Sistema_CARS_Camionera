<header class="main-header">
	
	<!--=====================================
		LOGOTIPO
	======================================-->
	
	<a href="inicio" class="logo">
		
		<!-- Logo Mini -->
		<span class="logo-mini">			

			<img src="vistas/img/plantilla/logo-camio-chico1.png" class="img-responsive" style="padding: 10px">
		 
		</span>
		
		<!-- Logo Normal -->
		 
		<span class="logo-lg">			
		
			<img src="vistas/img/plantilla/logo-camio-grande1.png" class="img-responsive" style="padding: 0px 20px">
		
		</span>
	
	</a>

	<!--=====================================
		BARRA DE NAVEGACION
	======================================-->
	<nav class="navbar navbar-static-top" role="navigation">
		
		<!-- Boton de Navegacion -->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
		
			<span class="sr-only">Toggle navigation</span>
		
		</a>
		
		<!-- Perfil de Usuario -->
		<div class="navbar-custom-menu">
		
			<ul class="nav navbar-nav">
		
				<li class="dropdown user user-menu">
		
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">

						<!-- <img src="vistas/img/usuarios/default/anonymous.png" class="user-image"> -->
						<?php

							if($_SESSION["foto"] != ""){
								echo '<img src="'.$_SESSION["foto"].'" class="user-image">';
							}else{
								echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';
							}

						?>
		 
						<span class="hidden-xs"><?php echo $_SESSION["nombre"]; ?></span>
		
					</a>
					<!-- Dropdown toglle-->
		
					<ul class="dropdown-menu">
		
						<li class="user-body">
		
							<div class="pull-right">
		
								<a href="salir" class="btn btn-debault btn-flat">Salir</a>
		
							</div>
		
						</li>
		
					</ul>
		
				</li>
		
			</ul>
		
		</div>

	</nav>
	
</header>