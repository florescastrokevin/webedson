<?php //include(_tpl_includes_."inc.header.php");

$carrito = $cuenta->getCliente()->getCarrito();
$content = $carrito->getContent();
$view = 'cesta';
$f = ($view=='cesta')?'':'_c';
            
?>
<div class="offcanvas-wrapper">
		<div class="container padding-bottom-3x padding-top-2x mb-1">
			<!-- INICIA CARRITO -->			
      <form method="post" id="cesta" action="<?php echo _url_web_.'seccion/pedido';?>">	
      <input type="hidden" name="logeado" id="logeado" value="<?php echo $cuenta->getCliente()->getLogeado()?>"> <?php
      if(is_array($content) && sizeof($content) > 0){ ?>
        <div id="carrito_compras" class="table-responsive shopping-cart">
          <input type="hidden" id="cambio" value="<?php echo TIPO_CAMBIO?>">
          <table id="tabla" class="table">
            <thead>
              <tr id="tabla_top">
                <th class="td1<?php echo $f?>">PRODUCTO</th>
                <th class="td2<?php echo $f?> text-center"><?php echo ($view=='cesta')?'PRECIO UNITARIO':'PRE. UNIT.'?></th>
                <th class="td3<?php echo $f?> text-center"><?php echo ($view=='cesta')?'CANTIDAD':'CANT.'?></th>
                <th class="text-center">SUBTOTAL</th>
                <th class="text-center">
                  <!-- <a class="btn btn-sm btn-outline-danger" href="#">LIMPIAR CARRITO</a> -->
                </th>
              </tr>
            </thead>
            <tbody id="tabla_cont">
                  <?php 
                    $totalP = 0;			
                    reset($content);
                    while( list($key,) = each( $content ) ){
                    $producto = new Producto((int)$key ,$idioma);
                    $precio = $producto->__get("_precio_producto");
                    $imagenes = $producto->__get("_imagenes");
                    $opciones = $content[$key]['opciones'];
                    $preciocmp = 0;   ?>
                <tr>
                  <td class="td1<?php echo $f?>">
                    <div class="product-item">
                      <?php $img = ($view=='cesta')?$imagenes[0]['middle']:$imagenes[0]['thumbnail']; ?>
                      <a class="product-thumb" href="<?php echo str_replace(" ","-",$producto->__get("_nombre"));?>">
                        <img src="<?php echo _catalogo_ . $img?>" alt="Product">
                      </a>
                      <div class="info_cesta<?php echo $f?> product-info">
                        <h4 class="product-title"><a class="nameCar"><?php echo $producto->__get("_nombre")?></a></h4>
                        <?php if(is_array($opciones) && count($opciones)>0 ): ?>
                        <!-- INICIA OPCIONES -->   
                        <div class="prod_agregado">
                            
                            <?php foreach( $opciones as $id=>$cantidad ):
                                    $prod = new Producto( $id );
                                    $imgsc = $prod->__get("_imagenes");
                                    $preciocmp += $prod->__get("_precio_producto") * $cantidad; ?>

                                <span><h5 class="icon-check text-success">&nbsp;&nbsp;&nbsp;</h5><img style="width: 35px;" src="<?php echo _catalogo_ . $imgsc[0]['middle']?>" alt="adicional"> <?php echo $cantidad;?> <?php echo $prod->__get("_nombre")?></span>
                                <!-- <li>
                                    <div class="wrap_agregado">
                                        &nbsp;<img src="<?php echo _catalogo_ . $imgsc[0]['middle']?>" alt="" />
                                    </div>
                                    <span><?php echo $cantidad;?> <?php echo $prod->__get("_nombre")?></span>
                                </li> -->
                            <?php  
                            endforeach;?>
                            
                        </div>
                        <!-- FIN OPCIONES -->  
                        <?php endif;?>
                        
                      </div>
                    </div>
                  </td>
                  <td class="td2<?php echo $f?> text-center text-lg text-medium">
                    <div class="count-input">
                      <span class="precio_prod">$<?php echo number_format($precio + $preciocmp,2)?></span>
                    </div>
                  </td>
                  <td class="td3<?php echo $f?> text-center text-lg text-medium">
                    <?php if($view=='cesta'){?>
                    <input type="text" class="form-control form-control-sm solo_numero kcarro" value="<?php echo $content[$key]['cantidad']?>" />
                    <?php }else{?>
                    <span><?php echo $content[$key]['cantidad']?></span>
                    <?php }?>
                  </td>
                  <td class="td4<?php echo $f?> text-center text-lg text-medium">
                    <span class="subtotal">$<?php echo number_format(($precio + $preciocmp) * $content[$key]['cantidad'],2)?></span>
                  </td>
                  <td class="text-center"><a class="eliminar remove-from-cart" href="javascript:;" data-toggle="tooltip" title="Eliminar Producto" id="<?php echo $key?>"><i class="icon-cross"></i></a></td>
                </tr>
                
            <?php } ?>                
            </tbody>
          </table>
        </div>
        <div class="shopping-cart-footer" id="total_precio<?php echo $f?>">
          <div class="column text-lg">
            <?php                            
            $ubigeo = new Ubigeos();
            $distritos = $ubigeo->getDistritosConCobertura(1401); ?>                            
            <div class="tpBox" id="subT">
                Subtotal: <span class="text-medium">$<?php echo number_format($carrito->getAmount(),2)?></span><br>
            </div>

            <?php if($view=='cesta'){

            $total_dolares = number_format(($tarifa+$carrito->getAmount()),2);
            $total_soles = number_format((($tarifa+$carrito->getAmount())*TIPO_CAMBIO),2); ?>
            <div class="tpBox" id="flete">
                Total ($): <span class="text-medium" id="numdolar" >$<?php echo $total_dolares?></span>
            </div>
            <div class="tpBox" id="flete">
                Total (S/.): <span class="text-medium" id="numsol">S/.<?php echo $total_soles?></span><br>
            </div><?php

            }else{
            $lugar = str_replace('Ã‘','Ñ',$pedido->getDestinatario()->__get('_distrito')->__get('_nombre'));
            $tarifa = $pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio');

            ?>
                
            <div class="tp boxright">
              <span>$ <?php echo number_format($tarifa,2)?></span>
            </div>
            <div class="tp textright flete">  
              Gastos de envío (<?php echo $lugar?>):
            </div>
            <div class="tpBox confirm" id="flete">				                	
            <div class="tp boxright totalprecio"><span>$ <?php echo number_format(($carrito->getAmount() + $tarifa),2);?></span>
            </div>
              <div class="tp textright flete totaltxt">Total ($):</div>
            </div>
            <div class="tpBox confirm" id="flete">				                	
                <div class="tp boxright totalprecio"><span>S/. <?php echo number_format((($carrito->getAmount() + $tarifa )*TIPO_CAMBIO ),2);?></span>
                </div>
                <div class="tp textright flete totaltxt">Total (S/.):</div>
            </div> <?php
            } ?>
          </div>
        </div>
        <div class="shopping-cart-footer">
          <div class="column"><a class="btn btn-outline-secondary" href="shop-grid-ls.html"><i class="icon-arrow-left"></i>&nbsp;Seguir Comprando</a></div>
          <div class="column btn-submit">
            <button type="submit" class="btn btn-success">Realizar Compra</button></div>
        </div>
        <?php }else{ ?>
        	
        <div class="table-responsive shopping-cart">
          <table class="table">
            <thead>
              <tr>
                <th>PRODUCTO</th>
                <th class="text-center">CANTIDAD</th>
                <th class="text-center">PRECIO UNITARIO</th>
                <th class="text-center">SUBTOTAL</th>
                <th class="text-center"><a class="btn btn-sm btn-outline-danger" href="#">LIMPIAR CARRITO</a></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
        <div class="shopping-cart-footer">
          <div class="column">
            
          </div>
          <div class="column text-lg">Subtotal: <span class="text-medium">$0.00</span></div>
        </div>
        <div class="shopping-cart-footer">
          <div class="column"><a class="btn btn-outline-secondary" href="shop-grid-ls.html"><i class="icon-arrow-left"></i>&nbsp;Seguir Comprando</a></div>
          <div class="column btn-submit">
            <a type="submit" class="btn btn-success" name="button" id="realizarcompra" value="">Realizar Compra</a></div>
        </div>
        <?php } ?>
      </form>
    </div>

  <!-- FIN CARRITO -->

<?php include(_tpl_includes_ . "inc.bottom.php"); ?>
</div>
<!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
<!-- Backdrop-->
<div class="site-backdrop"></div>