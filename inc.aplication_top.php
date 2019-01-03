<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("inc.core.php");
function my_autoloader($class) {
    if(file_exists( _model_.$class.'.php'  )){ include _model_.$class.'.php'; }
}
spl_autoload_register('my_autoloader');
require_once(_util_."Libs.php");
require_once(_util_."tags_html.php");
require_once(_view_."Secciones.php");

$link = new Conexion($_config['bd']['server'],$_config['bd']['user'],$_config['bd']['password'],$_config['bd']['name']);		
session_start();	

if(!(isset($_SESSION['donregalo']))){
    $cliente = new Cliente();
    $_SESSION['donregalo'] = new Cuenta($cliente);
    $cuenta = $_SESSION['donregalo'];
}else{	
    $cuenta = $_SESSION['donregalo'];
}

if(isset($_SESSION['donregalo_pedido'])){
    $pedido = $_SESSION['donregalo_pedido'];        
}

//idioma
if($_SESSION['idioma']){
    $idioma = $_SESSION['idioma'];
}else{
    $idioma = new Idioma(); 
}

if($_SERVER['HTTP_REFERER']){
    $referer = explode("/", $_SERVER['HTTP_REFERER']);
    $referer = $referer[2];
    
    if(!preg_match("/donregalo.pe/i", $referer)){
        $_SESSION['donregalo_flujo'] = $_SERVER['HTTP_REFERER']; 
        $_SESSION['donregalo_inicio'] = $_SERVER['PHP_SELF'];  
    }      
}

//cuando hay que cambiar idioma
if(isset($_GET['switch'])){$idioma->switchs($_GET['switch']);}
//incluimos el archivo de variables del idioma
define("ID_IDIOMA",$idioma->__get("_id"));
//require_once(_language_.$idioma->__get("_archivo"));

//msgbox
if(!(isset($_SESSION['msg']))){
    $msgbox = new Msgbox();
}else{
    $msgbox = $_SESSION['msg'];
}

//configuracion del sitio
$user = new Usuario();
$config_site = new Configuration($msgbox,$user);
$configs = $config_site->getData();

foreach($configs as $clave=>$valor){
    define($clave,$valor);
}

//Configuración de titulo y URL
$titulo = NOMBRE_SITIO." - Regalos delivery para toda ocasión en Lima Perú";
$descripcion= "Don regalo, Regalos delivery para toda ocasión en Lima Perú, peluches, flores, desayunos, sorpresas, detalles, canastas.  ";
