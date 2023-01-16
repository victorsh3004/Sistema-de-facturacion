<?php 
	session_start();
	if ($_SESSION['rol'] != 1 and $_SESSION['rol']!=2) {
		header("location:./");
	}
	include "../conexion.php";


if (!empty($_POST)) {
	if (empty($_POST['idcliente'])) {
		header("location: lista_cliente.php");
		mysqli_close($conection);
	}
	$idcliente = $_POST['idcliente'];

	//$query_delete = mysqli_query($conection, "DELETE FROM usuario WHERE idusuario = $idusuario");
	$query_update = mysqli_query($conection, "UPDATE cliente SET estatus = 0 WHERE idcliente=$idcliente");
	mysqli_close($conection);

	if($query_update){
		header("location: lista_cliente.php");	
	}else{
		echo "Error al eliminar";
	}	

}

if (empty($_REQUEST['id'])) {
	header("location: lista_cliente.php");
}else{
	 
	$idcliente = $_REQUEST['id'];

	$query = mysqli_query($conection, "SELECT * FROM cliente
											WHERE idcliente = $idcliente");
	mysqli_close($conection);
	$result =mysqli_num_rows($query);

	if ($result > 0) {
	 	while ($data = mysqli_fetch_array($query)) {
	 		// code...
	 		$dni = $data['nit'];
	 		$nombre = $data['nombre'];
	 	}
	 }else{
	 	header ("location: lista_cliente.php");
	 }
}


 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>
	<title>Eliminar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<i class="fas fa-user-times fa-7x" style="color: #db4242;"></i>
			<br>
			<h2>¿Está seguro de eliminar el siguiente registro?</h2>
			<p>DNI: <span> <?php echo $dni; ?> </span></p>
			<p>Nombre: <span> <?php echo $nombre; ?> </span></p>
			
			<form method="post" action="">
				<input type="hidden" name="idcliente" value=" <?php echo $idcliente; ?> ">
				<a href="lista_cliente.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
				<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>
			</form>

		</div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>