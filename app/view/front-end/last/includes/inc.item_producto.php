<?php
$item_producto = new Producto($id_item_producto, $idioma);
$imagenes_item_producto = $item_producto->__get("_imagenes");		
    ?>         
<!-- Product-->
  <div class="grid-item">
    <div class="product-card">
      <div class="product-badge text-danger">
        <?php if ($item_producto->__get("_dscto") != ""): ?>
            <?php echo number_format($item_producto->__get("_dscto"),2); ?>%
        <?php endif ?>
      </div>

        <div class="product-thumb">
            <?php
            if(count($imagenes_item_producto)>0   && file_exists(_link_file_ . 'middle_'.$imagenes_item_producto[0]['imagen'] ) ){?>
                <a href="p/<?php echo str_replace(" ","-",$item_producto->__get("_url"));?>">
                    <!-- <img class="redimencionada" src="<?php echo _catalogo_ . 'middle_'.$imagenes_item_producto[0]['imagen']; ?>" alt="Product"> -->
                    <img class="redimencionada" src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url(<?php echo _catalogo_ . 'middle_'.$imagenes_item_producto[0]['imagen']; ?>) ;" alt="Product">
                </a>
            <?php }else{  ?>
                <a href="#">
                    <img class="redimencionada" src="<?php echo _catalogo_?>basecatalogo.png" alt="Product" style="background-image: url(<?php echo _catalogo_?>not_image_disponible.jpg);">
                    <!-- <img class="redimencionada" src="<?php echo _catalogo_?>not_image_disponible.jpg" alt="Product"> -->
                </a>
                <?php
            } ?>    
        </div>                 


        <div class="card-text-content">
            <h3 class="product-title">
                <a href="p/<?php echo str_replace(" ","-",$item_producto->__get("_url"));?>" class="btn_detalle"><?php echo $item_producto->__get("_nombre") ?></a>
            </h3>

            <h4 class="product-price">       
            <?php if( $item_producto->__get("_dscto") != "" ){?> 
            <del>$<?php echo number_format($item_producto->__get("_precio_old"),2); ?></del>
            $<?php echo number_format($item_producto->__get("_precio_producto"),2); ?>
            <br/>
            <?php }else{?>
            $<?php echo number_format($item_producto->__get("_precio_producto"),2); 
            }?>
            (s/.<?php echo number_format($item_producto->__get("_precio_producto")*TIPO_CAMBIO,2); ?>)
            </h4>
        </div>

        <div class="text-center">
            <a class="btn btn-outline-success btn-sm addCarrito" data="add,<?php echo $item_producto->__get("_id")?>,1" onclick="addShopBag(this)">Comprar</a>
        </div>
                
            
<!--     
      <form name="envio_carrito" class="form">
        
        <div class="product-buttons">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="id_producto" value="">
            <input type="hidden" name="cantidad" value="1">
        </div>

      </form> -->
        
      
    </div>
  </div>