<?php 
$obj = new Paginas();
$accion = $_GET['action']."Ajax";	
$obj->$accion();
?>	