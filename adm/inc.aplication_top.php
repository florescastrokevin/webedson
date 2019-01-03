<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("../inc.core.php");
function my_autoloader($class) {
	if(file_exists( _model_.$class.'.php'  )){
		include _model_.$class.'.php';
	}
}
spl_autoload_register('my_autoloader');
require_once(_util_."ThumbnailBlobArray.php");
require_once(_util_."ThumbnailBlob.php");
require_once(_util_."ThumbnailBlobFile.php");

require_once(_util_."Upload.php");
require_once(_util_."Libs.php");
require_once(_util_."tags_html.php");

$link = new Conexion($_config['bd']['server'],$_config['bd']['user'],$_config['bd']['password'],$_config['bd']['name']);		
session_start();	
		
//idioma
if($_SESSION['idioma']){
	$idioma = $_SESSION['idioma'];
}else{
	$idioma = new Idioma(); 
}
//cuando hay que cambiar idioma
if(isset($_GET['switch'])){$idioma->switchs($_GET['switch']);}
//incluimos el archivo de variables del idioma
define("ID_IDIOMA",$idioma->__get('_id'));

$sesion = new Sesion($idioma); 
if(isset($_POST['login']) && isset($_POST['password']) && !empty($_POST['login']) &&!empty($_POST['password'])){
	$sesion->validaAcceso($_POST['login'], $_POST['password']);
}	
if($_GET['action']=="logout"){ $sesion->logout(); }


//msgbox
if(!(isset($_SESSION['msg']))){
	$msgbox = new Msgbox();
}else{
	$msgbox = $_SESSION['msg'];
}

$config_site = new Configuration($msgbox, $sesion->getUsuario());
$configs = $config_site->getData();

foreach($configs as $clave=>$valor){
	define($clave,$valor);
}

if(!is_object($sesion->getUsuario()->getRol()) && !preg_match("/login.php/",$_SERVER['PHP_SELF'])){header("location:login.php");} 
if($sesion->getUsuario()->getLogeado()==FALSE && !preg_match("/login.php/",$_SERVER['PHP_SELF'])){ header("location:login.php"); }
?>