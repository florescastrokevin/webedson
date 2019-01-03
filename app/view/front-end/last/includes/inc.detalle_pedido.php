<?php  
include("../../../../../inc.aplication_top.php");
$secciones = new Secciones($cuenta, $pedido);
$cu = new Cuenta($cliente);
$pedido_detalle = new Pedido($_POST['id']);
$id_pedido = $pedido_detalle->getId();
$contenidoCarrito = $pedido_detalle->getCarrito()->getContent();
$carrito = $cuenta->getCliente()->getCarrito();
/*echo "<pre>";
echo var_dump($contenidoCarrito);*/
?>
<p class="historial-numero-pedido">Pedido Nro. <?php echo $id_pedido; ?></p>
    <div class="row">
      <div class="col-md-7">

        <p class="text-bold margin-top-1x">Pedido:</p>

        <?php 
        $carrito = $pedido_detalle->getCarrito();
		$obj_forma_pago = new FormasPago();
		$content = $carrito->getContent();
		$view = '';
		$f = ($view=='cesta')?'':'_c';
		if(is_array($content) && sizeof($content) > 0){ ?>
		    <input type="hidden" id="cambio" value="<?php echo TIPO_CAMBIO?>">
		    <table class="table table-hover" id="table">
		        <thead id="tabla_top">
		            <tr>
		                <td class="td1<?php echo $f?>">Producto</td>
		                <td class="td2<?php echo $f?>"><?php echo ($view=='cesta')?'Precio Unitario':'Pre. Unit.'?></td>
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
		                    <a href="<?php echo str_replace(" ","-",$producto->__get("_nombre"));?>"><img class="img" src="<?php echo _catalogo_ . $img?>"></a> &nbsp; <span class="text-bold"><?php echo $producto->__get("_nombre")?></span>
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
		    </table>

		    <div id="total_precio<?php echo $f?>">
		        <?php                            
		        $ubigeo = new Ubigeos();
		        $distritos = $ubigeo->getDistritosConCobertura(1401); ?>   
		        <dl class="row margin-bottom-0" id="subT">
		            <dt class="col-sm-8 text-right font-size-22 text-gray">SubTotal:</dt>
		            <dd class="col-sm-4 margin-bottom font-size-26 margin-bottom-0 margin-top-0 text-gray">$<?php echo number_format($carrito->getAmount(),2)?></dd>
		        </dl>
		        
		        <?php if($view=='cesta'){
			   
		            $total_dolares = number_format(($tarifa+$carrito->getAmount()),2);
		            $total_soles = number_format((($tarifa+$carrito->getAmount())*TIPO_CAMBIO),2); ?>
		            <dl class="row margin-bottom-0" id="flete">
		                <dt class="col-sm-8 text-right font-size-22 text-gray">Total ($):</dt>
		                <dd class="col-sm-4 font-size-26 margin-bottom-0 margin-top-0 text-gray">$<?php echo $total_dolares?></dd>
		            </dl>

		            <dl class="row margin-bottom-0" id="flete">
		                <dt class="col-sm-8 text-right font-size-22 text-gray">Total (S/.):</dt>
		                <dd class="col-sm-4 font-size-26 margin-bottom-0 margin-top-0 text-gray">S/.<?php echo $total_soles?></dd>
		            </dl>
		         
		            <?php
		            }else{
		            $lugar = str_replace('Ã‘','Ñ',$pedido_detalle->getDestinatario()->__get('_distrito')->__get('_nombre'));
		            $tarifa = $pedido_detalle->getDestinatario()->__get('_distrito')->__get('_tarifa_envio');
		            ?>
		            <dl class="row margin-bottom-0">
		                <dt class="col-sm-8 text-right font-size-22 text-gray">Costo por envío (<?php echo $lugar?>):</dt>
		                <dd class="col-sm-4 font-size-26 margin-bottom-0 margin-top-0 text-gray">$<?php echo number_format($tarifa,2)?></dd>
		            </dl>

		            <dl class="row confirm margin-bottom-0" id="flete">
		                <dt class="col-sm-8 text-right font-size-22 text-gray">Total ($):</dt>
		                <dd class="col-sm-4 totalprecio font-size-26 margin-bottom-0 margin-top-0 text-gray">$<?php echo number_format(($carrito->getAmount() + $tarifa),2);?></dd>
		            </dl>
		            
		            <dl class="row confirm margin-bottom-0" id="flete">
		                <dt class="col-sm-8 text-right font-size-24 text-gray-2">Total (S/.):</dt>
		                <dd class="col-sm-4 totalprecio font-size-26 margin-bottom-0 margin-top-0 text-gray-2">S/. <?php echo number_format((($carrito->getAmount() + $tarifa )*TIPO_CAMBIO ),2);?></dd>
		            </dl>

		            <?php
		            } ?>
		    </div>
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

		<?php } ?>
      </div>



      <div class="col-md-5">
      	<?php $destinatario = $pedido_detalle->getDestinatario();
      	$Comprobante = $pedido_detalle->getComprobantePago();
		$metodo = $pedido_detalle->getMetodoPago(); 
        ?>
        <p class="titulo-cuenta-modal">DATOS DE ENTREGA</p>
        <p class="texto-3-cuenta-modal">Forma de Envio: <span>DELIVERY</span></p>
        <p class="sub-titulo-cuenta-modal">DATOS DE DESTINATARIO</p>
        <div class="row">
          <div class="col-sm-6">
            <p class="texto-2-cuenta-modal">Nombre: <span><?php echo $destinatario->__get('_nombre') ?></span></p>
            <p class="texto-2-cuenta-modal">Apellidos: <span><?php echo $destinatario->__get("_apellidos"); ?></span></p>
            <p class="texto-2-cuenta-modal">Teléfono: <span><?php echo $destinatario->__get("_telefono"); ?></span></p>
          </div>
          <div class="col-sm-6">
            <p class="texto-2-cuenta-modal">Distrito: <span><?php echo str_replace('Ã‘', 'Ñ', $destinatario->__get("_distrito")->__get('_nombre')); ?> , Lima, Perú</span></p>
            <p class="texto-2-cuenta-modal">Dirección: <span><?php echo $destinatario->__get("_direccion"); ?></span></p>
            <p class="texto-2-cuenta-modal">Referencia: <span><?php echo $destinatario->__get("_referencia"); ?></span></p>
          </div>
        </div>
        <p class="texto-3-cuenta-modal">Feha de Entrega: <span><?php echo fecha_hora_sql_html($destinatario->__get("_fecha_hora")); ?></span></p>
        <p class="texto-3-cuenta-modal">Dedicatoria: <span><?php echo $destinatario->__get("_dedicatoria"); ?></span></p>
        <p class="sub-titulo-cuenta-modal">DATOS DE PAGO</p>
        <p class="texto-3-cuenta-modal">Comprobante de pago: <span><?php echo $Comprobante->__get("_tipo"); ?></span></p>
        <?php if ($Comprobante->__get("_tipo") == "Boleta") { ?>
        <p class="texto-3-cuenta-modal">DNI: <span><?php echo $Comprobante->__get("_dni"); ?></span></p>
        <p class="texto-3-cuenta-modal">Nombre: <span><?php echo $Comprobante->__get("_nombre"); ?></span></p>
        <p class="texto-3-cuenta-modal">Dirección: <span><?php echo $Comprobante->__get("_direccionb"); ?></span></p>
        <?php } else { ?>
        <p class="texto-3-cuenta-modal">Razón social: </span><?php echo $Comprobante->__get("_razon_social"); ?></p>
        <p class="texto-3-cuenta-modal">RUC: </span><?php echo $Comprobante->__get("_ruc"); ?></p>
        <p class="texto-3-cuenta-modal">Dirección: </span><?php echo $Comprobante->__get("_direccionf"); ?></p>
        <?php } ?>
        <p class="sub-titulo-cuenta-modal">FORMA DE PAGO</p>
        <dl class="row">
            <dt class="col-sm-4 text-right border-top text-bold">
              <img class="fp_img1" src="<?php echo _catalogo_ . $metodo->__get('_imagen'); ?>"/>
            </dt>
            <dd class="col-sm-8 margin-bottom-0">
              <?php echo str_replace('../', '', nl2br($metodo->__get('_descripcion'))); ?>
            </dd>
        </dl>
      </div>
    </div>