<?php 

include("inc.aplication_top.php");

$respuesta = "";						
$id_cliente = $cuenta->findByEmail($_POST['email']);

if($id_cliente == 0){
    $cuenta->registrarClienteFacebook();
}else{  
    $cuenta->cuentaClienteFacebook($id_cliente);
} 

if($cuenta->getCliente()->getLogeado() ){
	if($cuenta->getCliente()->getCarrito()->count_Content()==0){
		if($id_cliente == 0){
            $respuesta = _url_web_.'seccion/cuenta';
        }else{
            $respuesta = $_GET["URLactual"];
        }
	}else{
		$respuesta = _url_web_.'seccion/pedido/envio';
		//$respuesta = $_GET["URLactual"];
	}
}else{
	$respuesta = $_GET["URLactual"];
}

echo $respuesta;