<?php
include("inc.aplication_top.php");
$ajax = new Ajax($idioma , $cuenta);
if(isset($_GET['action'])){
	$accion = $_GET['action']."Ajax";	
	$ajax->$accion();
}elseif(isset($_POST['action'])){
    $accion = $_POST['action']."Ajax";   
    $ajax->$accion();
}elseif(isset($_POST['mensaje']) && !empty($_POST['mensaje'])){
    if($cuenta->getCliente()->getLogeado()==FALSE){ 
        header("location: "._url_web_."seccion/cuenta?linkF=2"); 
    }else{	
        if($cuenta->getCliente()->getCarrito()->count_Content() == 0){ header("location: "._url_web_."seccion/cesta");}	
        if(!isset($_SESSION['donregalo_pedido']) || empty($_SESSION['donregalo_pedido']) || !(is_object($_SESSION['donregalo_pedido']))){
            header("location: "._url_web_."seccion/cesta");	
        }else{		
            if( isset($_POST['mensaje']) && !empty($_POST['mensaje']) ){
                $pedido->getDestinatario()->__set('_dedicatoria',$_POST['mensaje']);
                $_SESSION['envio']['dedicatoria'] = $_POST['mensaje'];
            }
        }
    }
    
}

?>