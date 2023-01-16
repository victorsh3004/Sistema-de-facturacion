<?php
	session_start();
		
	include "../conexion.php";

	if(!empty($_POST)){
		$alert='';
		if (empty($_POST['nombre'])  || empty($_POST['telefono']) || empty($_POST['direccion'])  ) {
			$alert='<p class="msg_error"> Todos los campos son obligatorios. </p>';
		}else{
			
			$dni 		= $_POST['dni'];
			$nombre  	= $_POST['nombre'];
			$telefono   = $_POST['telefono'];
			$direccion  = $_POST['direccion'];
			$usuario_id = $_SESSION['idUser'];
 
			$result=0;
			
			if (is_numeric($dni) and $dni != 0) {
				$query = mysqli_query($conection,"SELECT * FROM cliente WHERE nit = '$dni'");	
				$result = mysqli_fetch_array($query);			
			}

			if ($result > 0) {
				
				$alert='<p class="msg_error"> El dni ya existe. </p>';
			}else{
				$dni = 0;
								
				$query_insert = mysqli_query($conection,"INSERT INTO cliente(nit,nombre,telefono,direccion,usuario_id) VALUES ('$dni','$nombre','$telefono','$direccion','$usuario_id')");
				if($query_insert){
					$alert='<p class="msg_save"> cliente creado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al guardar cliente. </p>';
				}

			}			
		}
		mysqli_close($conection);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>
	<title>Registro cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1><i class="fas fa-user-plus"></i> Registro cliente</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<label for="dni">DNI</label>
				<input type="number" name="dni" id="dni" placeholder="Numero de DNI">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
				<label for="telefono">Teléfono</label>
				<input type="number" name="telefono" id="telefono" placeholder="Teléfono">
				<label for="direccion">Dirección</label>
				<input type="text" name="direccion" id="direccion" placeholder="Ingrese dirección">
			
				<button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Cliente</button>
			</form>
		</div>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>