<?php
	session_start();
	include "../conexion.php";
	

	if(!empty($_POST)){
		$alert='';
		if (empty($_POST['nombre'])  || empty($_POST['telefono']) || empty($_POST['direccion'])  ) {

			$alert='<p class="msg_error"> Todos los campos son obligatorios. </p>';
		}else{
			

			$idcliente 	= $_POST['id'];
			$dni  		= $_POST['nit'];
			$nombre 	= $_POST['nombre'];
			$telefono   = $_POST['telefono'];
			$direccion  = $_POST['direccion'];
			
			$result = 0;

			if (is_numeric($dni) and $dni != 0) {
						
			$query = mysqli_query($conection,"SELECT * FROM cliente 
													WHERE (nit = '$dni' AND idcliente != $idcliente)");

				$result = mysqli_fetch_array($query);
				$result = count((array)$result);
			}
			
			if($result > 0){
				$alert='<p class="msg_error"> El DNI ya existe, ingrese otro</p>';
			}else{
				if ($dni == '') {
					$dni = 0;
				}

				$sql_update = mysqli_query($conection, "UPDATE cliente 
																SET nit = '$dni', nombre = '$nombre', telefono = '$telefono', direccion ='$direccion'  
																WHERE idcliente=$idcliente");
								
				if($sql_update){
					$alert='<p class="msg_save"> cliente actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el cliente. </p>';
				}
			}			
		}
	}

	//Mostrar datos
	
	//empty -> no existe 

	if (empty($_REQUEST['id'])){
		
		header('Location: lista_cliente.php');
		mysqli_close($conection);
	}

	//validamos que el usuario si exista en la DB
	$idcliente = $_REQUEST['id'];
	
	$sql = mysqli_query($conection,"SELECT * FROM cliente WHERE idcliente = $idcliente and estatus=1");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_cliente.php');
	}else{
		while ($data = mysqli_fetch_array($sql)) {
			
			$idcliente 	= $data['idcliente'];
			$nit 		= $data['nit'];
			$nombre		= $data['nombre'];
			$telefono	= $data['telefono'];
			$direccion	= $data['direccion'];
			// $us_rol		= $data['usuario_id'];			
		}
	}



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>
	<title>Actualizar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1><i class="far fa-edit"></i> Actualizar Cliente</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="id" value=" <?php echo $idcliente; ?> ">
				<label for="nit">DNI</label>
				<input type="number" name="nit" id="nit" placeholder="DNI" value="<?php echo $nit; ?>">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
				<label for="telefono">telefono</label>
				<input type="text" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono; ?>">
				<label for="direccion"></label>
				<input type="text" name="direccion" id="direccion" placeholder="Direccion" value="<?php echo $direccion; ?>">
				
				<button type="submit" class="btn_save"><i class="far fa-edit"></i> Actualizar usuario</button>
			</form>
		</div>

	</section> 

	<?php include "includes/footer.php"; ?>
</body>
</html>