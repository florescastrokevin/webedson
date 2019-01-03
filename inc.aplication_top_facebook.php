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