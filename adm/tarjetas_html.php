<?php 
//$detalle = $obj_pedido->__get("_detalle");
//$total_detalle = count($detalle);
 
 
if( $total_pedidos > 0){
    for( $x = 0; $x < $total_pedidos; $x++){
        $id_pedido = $ids[$x];
        if($id_pedido > 0){
            
            $obj_pedido = new Pedido($id_pedido);
            $cliente = $obj_pedido->getCliente();
            $carrito = $obj_pedido->getCarrito(); 
            $destinatario = $obj_pedido->getDestinatario();
            $productos = $carrito->getContent(); ?>

<page style="font-size:14pt"> 
    <div style="margin-top:70px;width:100%;color:#222;height:400px;line-height:19px"><?php echo $destinatario->__get('_dedicatoria'); ?></div> 
    <div style="color:#777;text-align:center;width:100%;font-size:12px;padding-left:4px"><?php echo $id_pedido; ?></div>
</page><?php 
        }
        $id_pedido = 0;
    } 
}
?>