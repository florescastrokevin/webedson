<?php
//$pedido = $this->_pedido;
$carrito = $cuenta->getCliente()->getCarrito();
$obj_forma_pago = new FormasPago();
?>
<?php
$carrito = $cuenta->getCliente()->getCarrito();
$content = $carrito->getContent();
$view = '';
$f = ($view=='cesta')?'':'_c';
if(is_array($content) && sizeof($content) > 0){ ?>
    <input type="hidden" id="cambio" value="<?php echo TIPO_CAMBIO?>">
    <table class="table table-hover" id="table">
        <thead id="tabla_top">
            <tr>
                <td class="td1<?php echo $f?>">Producto</td>
                <td class="td2<?php echo $f?>"><?php echo ($view=='cesta')?'Precio Unitario':'Pre.&nbsp;Unit.'?></td>
                <td class="td3<?php echo $f?> text-center"><?php echo ($view=='cesta')?'Cantidad':'Cant.'?></td>
                <td class="td4<?php echo $f?>">Subtotal</td>
            </tr>
        </thead>   
        <tbody id="tabla_cont">
            <?php 
                $totalP = 0;          
                reset($content); 
            /*INICIO DEL WHILE*/
            while ( list($key,) = each( $content ) ) { 
                $producto = new Producto((int)$key ,$idioma);
                $precio = $producto->__get("_precio_producto");
                $imagenes = $producto->__get("_imagenes");
                $opciones = $content[$key]['opciones'];
                $preciocmp = 0; ?>
            <tr>
                <td class="td1<?php echo $f?> alignLeft">
                    <?php $img = ($view=='cesta')?$imagenes[0]['middle']:$imagenes[0]['thumbnail'];?>
                    <a href="p/<?php echo str_replace(" ","-",$producto->__get("_url"));?>">
                        <img class="img" src="<?php echo _catalogo_ . $img?>">
                    </a> &nbsp; 
                        <span class="text-bold"><?php echo $producto->__get("_nombre")?></span>
                    <?php if (is_array($opciones) && count($opciones)>0): ?>
                    <br>
                    <ul>
                        <?php foreach ($opciones as $id=>$cantidad):  
                        $prod = new Producto( $id );
                        $imgsc = $prod->__get("_imagenes");
                        $preciocmp += $prod->__get("_precio_producto") * $cantidad; ?>   
                        <li class="list-icon">
                            <i class="icon-plus text-success text-bold"></i>&nbsp;<img src="<?php echo _catalogo_ . $imgsc[0]['middle']?>" class="img" style="max-width: 38px">&nbsp; <?php echo $cantidad;?> <?php echo $prod->__get("_nombre")?>
                        </li>
                        <?php endforeach ?>
                    </ul> 
                    <?php endif ?>
                </td>
                <td class="td2<?php echo $f?> alignLeft text-muted">
                    $<?php echo number_format($precio + $preciocmp,2)?>
                </td>
                <td class="td3<?php echo $f?> alignLeft text-bold text-center">
                    <?php echo $content[$key]['cantidad']?>
                </td>
                <td class="td4<?php echo $f?> alignLeft text-bold">
                    $<?php echo number_format(($precio + $preciocmp) * $content[$key]['cantidad'],2)?>
                </td>
            </tr>
            <?php } /*FIN DEL WHILE */?>
        </tbody>

        <tfoot>
            <tr>
              <td colspan="3" class="text-left">SubTotal:</td>
              <td class="text-right">$<?php echo number_format($carrito->getAmount(),2)?></td>
            </tr>
            <?php if($view=='cesta'){
            $total_dolares = number_format(($tarifa+$carrito->getAmount()),2);
            $total_soles = number_format((($tarifa+$carrito->getAmount())*TIPO_CAMBIO),2); ?>
            ?>
            <tr>
              <td colspan="3" class="text-left">Total ($):</td>
              <td class="text-right">$<?php echo $total_dolares?></td>
            </tr>
            <tr>
              <td colspan="3" class="text-left">Total (S/.):</td>
              <td class="text-right">S/.<?php echo $total_soles?></td>
            </tr>
            <?php }else{
            $lugar = str_replace('Ã‘','Ñ',$pedido->getDestinatario()->__get('_distrito')->__get('_nombre'));
            $tarifa = $pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio');?>
            <tr>
              <td colspan="3" class="text-left">Costo por envío (<?php echo $lugar?>):</td>
              <td class="text-right">$<?php echo number_format($tarifa,2)?></td>
            </tr>
            <tr>
              <td colspan="3" class="text-left">Total ($):</td>
              <td class="text-right">$<?php echo number_format(($carrito->getAmount() + $tarifa),2);?></td>
            </tr>
            <tr>
              <td colspan="3" class="text-left">Total (S/.):</td>
              <td class="text-right text-bold">S/.<?php echo number_format((($carrito->getAmount() + $tarifa )*TIPO_CAMBIO ),2);?></td>
            </tr>
            <?php
            } ?>
        </tfoot>
    </table>
<?php }else{?>
    <table class="table">
        <thead>
            <tr>
                <th class="td1">Producto</th>
                <th class="td2">Precio Unitario</th>
                <th class="td3">Cantidad</th>
                <th class="td4">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr id="tabla_cont">
                
            </tr>
        </tbody>
    </table>
    <table id="total_precio">
        <tr id="subT">
            <td>$0.00</td>
            <td>Subtotal:</td>
        </tr>
    </table>

<?php }