<?php include("inc.aplication_top.php");

$obj = new Ajax($idioma);

if($_GET['action']){
	$accion = $_GET['action']."Ajax";

	$obj->$accion();

}

$clase = $_POST['clase'];
$action = $_POST['action'];
if (class_exists($clase)) {
	$obj_clase = new $clase;
	if ($action) {
		$obj_clase::$action();
	}
}

?>	