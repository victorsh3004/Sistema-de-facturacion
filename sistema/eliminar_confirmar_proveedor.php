<?php 
	session_start();
	if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)  {
		header("location:./");
	}
	include "../conexion.php";


if (!empty($_POST)) {

	if (!$_POST['idproveedor']) {
		header("location: lista_proveedor.php");
		mysqli_close($conection);
		exit;
	}
	$idproveedor = $_POST['idproveedor'];

	$query_update = mysqli_query($conection, "UPDATE proveedor SET estatus = 0 WHERE codproveedor=$idproveedor");
	mysqli_close($conection);

	if($query_update){
		header("location: lista_proveedor.php");	
		mysqli_close($conection);
	}else{
		echo "Error al eliminar";
	}	

}

if (empty($_REQUEST['id'])) {
	header("location: lista_proveedor.php");
}else{
	
 
	$idproveedor = $_REQUEST['id'];

	$query = mysqli_query($conection, "SELECT * FROM proveedor WHERE codproveedor= $idproveedor");
	mysqli_close($conection);
	$result =mysqli_num_rows($query);

	if ($result > 0) {
	 	while ($data = mysqli_fetch_array($query)) {
	 		
	 		$proveedor = $data['proveedor'];
	 		$contacto  = $data['contacto'];
	 		$direccion = $data['direccion'];
	 	}
	 }else{
	 	header ("location: lista_proveedor.php");
	 }
}


 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>
	<title>Eliminar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<i class="fas fa-truck fa-7x" style="color: #db4242;"></i> 
			<br>
			<h2>¿Está seguro de eliminar el siguiente registro?</h2>
			<p>Proveedor: <span> <?php echo $proveedor; ?> </span></p>
			<p>Contacto: <span> <?php echo $contacto; ?> </span></p>
			<p>Dirección: <span> <?php echo $direccion; ?> </span></p>
			
			<form method="post" action="">
				<input type="hidden" name="idproveedor" value=" <?php echo $idproveedor; ?> ">
				<a href="lista_proveedor.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
				<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>
			</form>

		</div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>