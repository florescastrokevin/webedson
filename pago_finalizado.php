<?php include("inc.aplication_top.php");
if($cuenta->getCliente()->getLogeado()==FALSE){ header("location: cuenta.php?linkF=2"); }else{
if($cuenta->getCliente()->getCarrito()->count_Content() == 0){ header("location: cesta.php");}
}
//Defino mi clase pedido
if(!isset($_SESSION['donregalo_pedido']) || empty($_SESSION['donregalo_pedido']) || !(is_object($_SESSION['donregalo_pedido']))){		
        if(!$_GET['code']){ $_SESSION['donregalo_pedido'] = new Pedido(); }
        //header('location:index.php');
        echo 'se va a redirigir al home';
}else{
        $pedido = $_SESSION['donregalo_pedido'];		
} 
	
$secciones = new Secciones($cuenta, $pedido);
$cu = new Cuenta($cliente); 

if(isset($_POST['custom'])&&!empty($_POST['custom'])){
	$_GET['code'] = $_POST['custom'];
}
$obj_pedido = new Pedido($_GET['code']);

if( $obj_pedido->getMetodoPago()->__get('_id') == 1 ) { //Paypal
    $mensaje_pago = "Gracias por su compra. <br />El Pago via Paypal se realizó con exito "; 
    Secciones::notificarPedido($obj_pedido);
}
if( $obj_pedido->getMetodoPago()->__get('_id') == 2 ) {
    $mensaje_pago = "Gracias por su compra. <br />Pague su compra haciendo una transferencia bancaria o depositando el monto total al siguiente número de cuenta: ";
    Secciones::notificarPedido($obj_pedido);
} 
if( $obj_pedido->getMetodoPago()->__get('_id') == 7 ) {
    $mensaje_pago = "Gracias por su compra. <br />Pague su compra haciendo una transferencia bancaria o depositando el monto total al siguiente número de cuenta: ";
    Secciones::notificarPedido($obj_pedido);
} 
include(_tpl_includes_."inc.header.php"); ?>


<body>
	<!-- INICIA WRAPPER -->
	<div id="wrapper">
		<div class="line"></div>
		<!-- INICIA HEADER -->
		<?php include(_tpl_includes_."inc.top.php");?>
		<!-- FIN HEADER -->
		
            <!-- INICIA PAGINA -->
            	<?php $secciones->Finalizado(); ?>
            <!-- FIN PAGINA -->
        
		<!-- INICIA BOTTOM -->
		<?php include(_tpl_includes_."inc.bottom.php"); ?>
		<!-- FIN BOTTOM -->
	</div>
	<div id="radiusbottom"></div>
	<!-- FIN WRAPPER -->
	<!-- INICIA FOOTER -->
	<?php include(_tpl_includes_."inc.footer.php"); ?>
	<!-- FIN FOOTER -->
</body>
</html>
<?php 

$cuenta->getCliente()->getCarrito()->reset(TRUE);
unset($_SESSION['donregalo_pedido']);

//unset($_SESSION['envio']);
//unset($_SESSION['pago']);
?>