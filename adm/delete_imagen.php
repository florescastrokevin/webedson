<?php
	include("inc.aplication_top.php");
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	if($_GET['opcion'] == 'eventos'){
		$sql = " DELETE FROM eventos_imagenes WHERE id_evento_imagen = '".$id."' ";
		$query = new Consulta($sql);
	}
	else if($_GET['opcion'] == 'prensa'){
		$sql = " DELETE FROM prensa_imagenes WHERE id_prensa_imagen = '".$id."' ";
		$query = new Consulta($sql);
	}
	else if($_GET['opcion'] == 'obras'){
		$sql = " DELETE FROM obras_imagenes WHERE id_obra_imagen = '".$id."' ";
		$query = new Consulta($sql);
	}
	else if($_GET['opcion'] == 'prod'){
		$sql = " DELETE FROM productos_imagenes WHERE id_producto_imagen = '".$id."' ";
		$query = new Consulta($sql);
	}
	echo "Se eliminaron correctamente la(s) imagenes";
?>