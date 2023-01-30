<?php 
	session_start();
	include "../conexion.php";
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>
	<title>Lista de Ventas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<h1><i class="far fa-newspaper"></i> Lista de Ventas</h1>
		<a href="nueva_venta.php" class="btn_new"><i class="fas fa-user-plus"></i> Nueva venta</a>

		<form action="buscar_venta.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="No. Factura">
			<button type="submit" class="btn_search"> <i class="fas fa-search"></i></button>
		</form>

		<div>
			<h5>Buscar por fecha</h5>
			<form action="buscar_venta.php" method="get" class="form_search_date">
				<label>De: </label>
				<input type="date" name="fecha_de" id="fecha_de" required>
				<label> A </label>
				<input type="date" name="fecha_a" id="fecha_a" required>
				<button type="submit" class="btn_view"><i class="fas fa-search"></i></button>
			</form>
		</div>
	<table>
		<tr>
			<th>No.</th>
			<th>Fecha/Hora</th>
			<th>Cliente</th>
			<th>Vendedor</th>
			<th>Estado</th>
			<th class="textright">Total Factura</th>
			<th class="textright">Acciones</th>
		</tr>

		<?php

		//Paginador
			$sql_register=mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM factura WHERE estatus!=10");
			$result_register = mysqli_fetch_array($sql_register);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 5;

			if (empty($_GET['pagina'])) {
			 	$pagina = 1;
			 } else {
			 	$pagina = $_GET['pagina'];
			 }

			 $desde = ($pagina-1)*$por_pagina;
			 $total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection, "SELECT f.nofactura,f.fecha,f.totalfactura,f.codcliente,f.estatus, 
														u.nombre as vendedor, 
														cl.nombre as cliente,cl.idcliente
													FROM factura f
													INNER JOIN usuario u
													ON f.usuario = u.idusuario
													INNER JOIN cliente cl
													ON f.codcliente = cl.idcliente
													WHERE f.estatus != 10
													ORDER BY f.fecha DESC LIMIT $desde,$por_pagina");
			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			#echo $result;

			if($result > 0){
				while ($data = mysqli_fetch_array($query)){
					if ($data["estatus"]==1) {
						$estado = '<span class="pagada">Pagada</span>';
					}else{
						$estado = '<span class="anulada">Anulada</span>';
					}

		?>
			<tr>
				<td><?php echo $data["nofactura"]; ?></td>
				<td><?php echo $data["fecha"] ?></td>
				<td><?php echo $data["cliente"]; ?></td>
				<td><?php echo $data["vendedor"]; ?></td>
				<td><?php echo $estado; ?></td>
				<td class="textright totalfactura"><span>S/</span><?php echo $data["totalfactura"]; ?></td>
				<td>
					<a class="link_edit" href="editar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="far fa-edit"></i> Editar</a>

					<?php if ($_SESSION['rol']==1 || $_SESSION['rol'] == 2) {
					?>
					<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
					<?php } ?>
				</td>	
			</tr>

		<?php
				}
			}
		?>

	</table>

	<div class="paginador">
		<ul>
			<?php 
			if ($pagina != 1) {
			 	
			 ?>
			<li><a href="?pagina= <?php echo 1; ?>">|<</a></li>
			<li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
			
			<?php 
			} ?>

			<?php 
				for ($i=1; $i <= $total_paginas ; $i++) { 
					
					if ($i == $pagina) {
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
					echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
					}
				}

				if ($pagina!=$total_paginas) {
					
			 ?>

			<li><a href="?pagina=<?php echo $pagina+1; ?>">>></a></li>
			<li><a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
			<?php 
				}
			 ?>
		</ul>	

	</div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>	