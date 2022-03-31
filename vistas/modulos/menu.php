<aside class="main-sidebar">

	<section class="sidebar">

		<ul class="sidebar-menu">

			<?php

			if($_SESSION["perfil"] == "Administrador"){

				echo '<li class="active">
					<a href="inicio">
						<i class="fa fa-home"></i>
						<span>Inicio</span>
					</a>
				</li>';
			}

			if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Operador"){

				echo '
				<li>
					<a href="usuarios">
						<i class="fa fa-user"></i>
						<span>Usuarios</span>
					</a>
				</li>
				<li class="treeview">
					<a href="">
						<i class="fa fa-truck"></i>
						<span>Fleteros</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						
						<li>
							<a href="fleteros">
								<i class="fa fa-circle-o"></i>
								<span>Alta de Fleteros</span>
								</a>
						</li>

						<li>
							<a href="repartos">
								<i class="fa fa-circle-o"></i>
								<span>Repartos de Fleteros</span>
							</a>
						</li>
						
						<li>
							<a href="sube-reparto">
								<i class="fa fa-circle-o"></i>
								<span>Subir Repartos</span>
							</a>
						</li>

					</ul>
				
					<li>					
						<a href="clientes">
						
							<i class="fa fa-users"></i>
						
							<span>Clientes</span>
					
						</a>
				
					</li>

				</li>

				<li class="treeview">
					<a href="">
						<i class="fa fa-id-card-o"></i>
						<span>Cars</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="cars-clientes">
								<i class="fa fa-circle-o"></i>
								<span>Cars de Clientes</span>
							</a>
						</li>
						<li>
							<a href="alta-cars">
								<i class="fa fa-circle-o"></i>
								<span>Alta de Cars Clientes</span>
							</a>
						</li>';
						
						if($_SESSION["perfil"] == "Administrador"){
							echo '<li>
								<a href="rango-cars">
									<i class="fa fa-bar-chart"></i>
									<span>Descarga de Cars</span>
								</a>
							</li>';
						}

						echo '
						<li>
							<a href="sube-bases">
								<i class="fa fa-circle-o"></i>
								<span>Subir Bases</span>
							</a>
						</li>
												
					</ul>
				</li>';

			}

			if($_SESSION["perfil"] == "Fletero"){
				echo '
				<li class="treeview">
					<a href="">
						<i class="fa fa-truck"></i>
						<span>Fleteros</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="fleteros">
								<i class="fa fa-circle-o"></i>
								<span>Modificacion de Fleteros</span>
							</a>
						</li>
						<li>
							<a href="repartos">
								<i class="fa fa-circle-o"></i>
								<span>Repartos de Fleteros</span>
							</a>
						</li>						
					</ul>

				</li>';

			}

			if($_SESSION["perfil"] == "Cliente"){
			
				echo'
			
				<li class="treeview">
					<a href="">
						<i class="fa fa-id-card-o"></i>
						<span>Cars</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">

						<li>					
							<a href="modcliente">
								<i class="fa fa-users"></i>
								<span>Actualiza Datos Cliente</span>
							</a>
						</li>
						<li>
							<a href="cars-clientes">
								<i class="fa fa-circle-o"></i>
								<span>Cars de Clientes</span>
							</a>
						</li>										
					</ul>
				</li>';
			}
		?>
		</ul>
	
	</section>

</aside>