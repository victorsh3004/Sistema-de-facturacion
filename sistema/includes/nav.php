	<nav>
			<ul>
				<li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
				<?php 
					if ($_SESSION['rol']==1) {
				 ?>

				<li class="principal">
					<a href="#"><i class="fas fa-users"></i> Usuarios</a>
					<ul>
						<li><a href="registro_usuario.php"><i class="fas fa-user-plus"></i> Nuevo Usuario</a></li>
						<li><a href="lista_usuario.php"><i class="fas fa-users"></i> Lista de Usuarios</a></li>
					</ul>
				</li>
				<?php 
					}
				 ?>
				<li class="principal">
					<a href="#"><i class="fas fa-user"></i> Clientes</a>
					<ul>
						<li><a href="registro_cliente.php"><i class="fas fa-user-plus"></i> Nuevo Cliente</a></li>
						<li><a href="lista_cliente.php"><i class="fas fa-users"></i> Lista de Clientes</a></li>
					</ul>
				</li>
				<?php 
					if ($_SESSION['rol']==1 || $_SESSION['rol']==2) {
				 ?>

				<li class="principal">
					<a href="#"><i class="fas fa-truck"></i> Proveedores</a>
					<ul>
						<li><a href="registro_proveedor.php"><i class="far fa-plus-square"></i> Nuevo Proveedor</a></li>
						<li><a href="lista_proveedor.php"><i class="fas fa-users"></i> Lista de Proveedores</a></li>
					</ul>
				</li>
				<?php } ?>
				<li class="principal">
					<a href="#"><i class="fas fa-box"></i> Productos</a>
					<ul>
						<?php 
							if ($_SESSION['rol']==1 || $_SESSION['rol']==2) {
						 ?>
						<li><a href="registro_producto.php"><i class="fas fa-cart-plus"></i> Nuevo Producto</a></li>
						<?php } ?>
						<li><a href="lista_producto.php"><i class="fas fa-list-alt"></i> Lista de Productos</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#"><i class="fas fa-clipboard"></i> Facturas</a>
					<ul>
						<li><a href="#"><i class="far fa-sticky-note"></i> Nuevo Factura</a></li>
						<li><a href="#"><i class="fas fa-th-list"></i> Facturas</a></li>
					</ul>
				</li>
			</ul>
		</nav>