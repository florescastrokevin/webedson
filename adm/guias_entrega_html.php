<style type="text/css">
<!--

-->
</style>
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

<page style="font-size:10pt">
    <table style="width:100%">
    	<tr>
            <td style="width:60%;text-align:left"><img src="<?php echo _imgs_ ?>logo.png" style="border:0px;width:150px"></td>
            <td style="width:40%">
                 <table style="background-color:white;color:#666;">
                    <tr><td colspan="3"><span style="font-weight:bold;font-size:11pt;color:#222">Pedido # <?php echo $obj_pedido->getId(); ?></span><br></td></tr> 	
                    <tr style="font-size:9pt">
                        <td>Teléfonos.:</td>
                        <td>(01) 535-1616 / 988 130 362</td> 
                    </tr>
                    <tr style="font-size:9pt">
                        <td colspan="2">Calle la Habana 595 Of. 2A - San Isidro - Lima </td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td>Chofer:</td>
                        <td>Mario Mariano C. (DNI: 65439876) <?php //echo $obj_pedido->__get("_usuario")->getNombre().' '.$obj_pedido->__get("_usuario")->getApellidos(); ?></td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td>Hora de Entrega:</td>
                        <td style="color:#111"><?php echo fecha_hora_sql_html($destinatario->__get("_fecha_hora")); ?></td> 
                    </tr>
                </table>
            </td>
    	</tr>
    </table> 
    
    <h5>Datos de Envío (RECIBE)</h5>
    <table style="width:100%;background-color:#999"> 
        <tr style="background-color:#f4f4f4">
            <td style="width:190px;padding:5px"><b>Nombres:</b><br> <?php echo $destinatario->__get("_nombre").' '.$destinatario->__get("_apellidos"); ?> </td>
            <td style="width:350px;padding:5px"><b>Dirección:</b><br><?php echo $destinatario->__get("_direccion"); ?> </td>
            <td style="width:150px;padding:5px"><b>Distrito:</b><br><?php echo $destinatario->__get("_distrito")->__get("_nombre"); ?></td>
        </tr>
        <tr style="background-color:#f4f4f4;">
            <td colspan="2" style="width:540px;padding:5px"><b>Referencia:</b><br> <?php echo $destinatario->__get("_referencia"); ?> </td>
            <td style="width:150px;padding:5px"><b>Teléfono:</b><br> <?php echo $destinatario->__get("_telefono"); ?> </td>
        </tr> 
    </table>
    
    <h5>Datos del Cliente (ENVÍA)</h5>
    <table  style="width:100%;background-color:#999"> 
        <tr style="background-color:#f4f4f4">
            <td style="width:560px;padding:5px"><b>Nombres:</b> <?php echo $cliente->__get("_nombre").' '.$cliente->__get("_apellidos"); ?> </td>
            <td style="width:150px;padding:5px"><b>Telefono:</b> <?php echo $cliente->__get("_telefono"); ?> </td></tr>
    </table> 
    <h5>Detalle de Compra</h5>
    <table style="width:100%;background-color:#999">
        <thead>
        <tr class="head" style="background-color:#f4f4f4">
            <th style="width:70px;padding:5px">Cantidad</th>
            <th style="width:640px;padding:5px">Descripción</th>
            <!--<th style="width:100px;padding:5px">Precio</th>-->
            <!--<th style="width:115px;padding:5px">Total </th>-->
       </tr>
       </thead>
       <tbody>
    <?php  
    $j = 0;
    $priceTotal = 0;	
    $item = 1;			
    reset($productos);
        while( list($key,) = each( $productos ) ){	

            $preciocmp = 0;
            $producto = new Producto($key);
            $subtotal += $productos[$key]['cantidad'] * $productos[$key]['precio'];	
            $precio = $productos[$key]['precio'];    ?>
        <tr style="background-color:#f4f4f4">
            <td style="padding:5px;text-align:right"><?php  echo $productos[$key]['cantidad']; ?></td>
            <td align="left" style="padding:5px"> <?php  echo $producto->__get('_nombre');  

            $query_productos_cmp = new Consulta("SELECT * FROM pedidos_productos_opciones WHERE id_pedido_producto = '".$productos[$key]['id_pedido_producto']."'");
            if( $query_productos_cmp->NumeroRegistros() > 0 ){ ?>
                    <div class="prod_agregado">
                        <ul><?php
                            while( $rowcmp = $query_productos_cmp->VerRegistro() ){

                            $prodcmp = new Producto($rowcmp['producto_opcion']);
                            $imgcmp = $prodcmp->__get("_imagenes");
                            $preciocmp += $prodcmp->__get("_precio_producto")*$rowcmp['producto_opcion_valor'];
                            $img_thumb_cmp = (file_exists(_link_file_ . $imgcmp[0]['thumbnail'])) ? $imgcmp[0]['thumbnail'] : 'not_image_disponible_thumb.jpg';?>
                            <li>
                                <span> <?php echo $rowcmp['producto_opcion_valor'];?> <?php echo $prodcmp->__get("_nombre")?></span>
                            </li> 
                            <?php }?>
                        </ul>
                    </div> <?php
            }  ?>
            </td>
<!--        <td style="padding:5px;text-align:right">$ <?php echo number_format($precio + $preciocmp, 2); ?></td>                                -->
            <!--<td style="padding:5px;width:115px;text-align:right">$ <?php $priceTotal += (($precio+$preciocmp) * $productos[$key]['cantidad']); echo number_format((($precio+$preciocmp) * $productos[$key]['cantidad']),2); ?> </td>-->
        </tr> <?php 
        $atributo_precio = 0;
        $i++;
        } ?>
        </tbody>
    </table>
    <br>
    <br>   
    <table>
        <tr><td><b>Adicionales</b></td></tr>
        <tr><td> - <?php echo $destinatario->__get("_adicional"); ?>.</td></tr> 
    </table>
    <br><br>    
    <table>
        <tr><td><b>DON REGALO</b></td></tr>
        <tr><td> www.donregalo.pe</td></tr>
        <tr><td> Telf. Lima: (01) 535 1616</td></tr>
    </table>
    
</page><?php 
        }
        $id_pedido = 0;
    } 
}
?>