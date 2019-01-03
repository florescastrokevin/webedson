<?php

$obj_producto = new Producto($id_producto);
$imagenes = $obj_producto->__get("_imagenes");
$complementos = $obj_producto->__get("_complementos");

$param = explode('n=', $_SERVER['QUERY_STRING']);
$href = $param[1];
//$producto = new Producto($_GET['prod']);
//$imagenes = $obj_producto->__get("_imagenes");
$imagen = _catalogo_ . $imagenes[0]['big'];
?>        
    <!-- Off-Canvas Wrapper-->
    <div class="offcanvas-wrapper">

      <?php include(_tpl_includes_."inc.navegacion.php") ?>
      
      <!-- Page Content-->
      <div class="container padding-bottom-3x mb-1">
        <div class="row">
          <!-- Poduct Gallery-->
          <div class="col-md-6">
            <!-- Aqui solo va ir el titulo del producto y el precio pero cuando estamos en movil -->
            <div class="titulo-producto-detalle-solo-movil">   
                <p><?php echo $obj_producto->__get("_nombre"); ?></p>
                <span>
                    $<?php echo number_format($obj_producto->__get("_precio_producto"), 2); ?> 
                    <span class="text-muted">
                        (s/.<?php echo number_format($obj_producto->__get("_precio_producto") * TIPO_CAMBIO, 2); ?>)
                    </span>
                </span> 
           </div>
            <div class="product-gallery">
              <div class="gallery-wrapper">
                <?php 
                if (count($imagenes) > 0) {
                    $count = 0;
                    foreach ($imagenes as $imagen):

                        if ($imagen['big'] != "" && file_exists(_link_file_ . $imagen['big'])) {
                            $imagen = _catalogo_ . $imagen['big'];
                        } else {
                            $imagen = _catalogo_ . 'not_image_disponible.jpg';
                        }
                        ?> 
                        <div class="gallery-item <?php if($count==0){echo "active";} ?>"><a href="<?php echo $imagen ?>" data-hash="item<?php echo $count;?>" data-size="1000x667"></a></div>                 
                        <?php
                        $count++;
                    endforeach;
                } else { ?>
                    <div class="gallery-item active"><a href="<?php echo _catalogo_ . 'not_image_disponible.jpg' ?>" data-hash="item<?php echo $count;?>" data-size="1000x667"></a></div>
                <?php } ?>
              </div>
              <div class="product-carousel owl-carousel">
                <?php 
                if (count($imagenes) > 0) {
                    $count = 0;
                    foreach ($imagenes as $imagen):

                        if ($imagen['big'] != "" && file_exists(_link_file_ . $imagen['big'])) {
                            $imagen = _catalogo_ . $imagen['big'];
                        } else {
                            $imagen = _catalogo_ . 'not_image_disponible.jpg';
                        }
                        ?> 
                        <div data-hash="item<?php echo $count;?>"><img src="<?php echo $imagen ?>" alt="Producto"></div>             
                        <?php
                        $count++;
                    endforeach;
                } else { ?>
                    <div data-hash="item<?php echo $count;?>"><img src="<?php echo _catalogo_ . 'not_image_disponible.jpg' ?>" alt="Producto"></div>
                <?php } ?>
              </div>
              <ul class="product-thumbnails">
                <?php 
                if (count($imagenes) > 0) {
                    $count = 0;
                    foreach ($imagenes as $imagen):

                        if ($imagen['thumbnail'] != "" && file_exists(_link_file_ . $imagen['thumbnail'])) {
                            $imagen = _catalogo_ . $imagen['thumbnail'];
                        } else {
                            $imagen = _catalogo_ . 'not_image_disponible_thumb.jpg';
                        }
                        ?>

                        <li class="<?php if($count==0){echo "active";} ?>"><a href="<?php echo $_GET['n'] ?>#item<?php echo $count;?>"><img src="<?php echo $imagen ?>" alt="Producto"></a></li>                 
                        <?php
                        $count++;
                    endforeach;
                } else { ?>
                    <li class="<?php if($count==0){echo "active";} ?>"><a href="<?php echo $_GET['n'] ?>#item<?php echo $count;?>"><img src="<?php echo _catalogo_ . 'not_image_disponible_thumb.jpg' ?>" alt="Producto"></a></li>
                <?php } ?>
              </ul>
            </div>
            <!-- REDES SOCIALES COMPARTIR  -->
            <div class="d-flex flex-wrap justify-content-between remove-movil">
              <div class="entry-share mt-2 mb-2">
                <span class="text-muted">Share:</span>
                <div class="share-links">
                    <a class="social-button shape-circle sb-facebook" href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="socicon-facebook"></i></a>
                    <a class="social-button shape-circle sb-twitter" href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="socicon-twitter"></i></a>
                    <a class="social-button shape-circle sb-instagram" href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="socicon-instagram"></i></a>
                    <a class="social-button shape-circle sb-google-plus" href="#" data-toggle="tooltip" data-placement="top" title="Google +"><i class="socicon-googleplus"></i></a>
                </div>
              </div>
            </div>
          </div>
          <!-- Product Info-->
          <div class="col-md-6" id="detalle_descripcion"> 
            <div class="padding-top-2x mt-2 hidden-md-up remove-movil"></div>

            <h2 class="text-normal remove-movil"><?php echo $obj_producto->__get("_nombre"); ?></h2>
            <span class="h2 d-block remove-movil">   
                $<?php echo number_format($obj_producto->__get("_precio_producto"), 2); ?> 
               <span class="text-muted">
                    (s/.<?php echo number_format($obj_producto->__get("_precio_producto") * TIPO_CAMBIO, 2); ?>)
               </span> 
           </span>
            <p class="text-muted description-short">
                <?php echo $obj_producto->__get("_descripcion_corta") ?>
            </p>
            <hr class="mb-3">
            <?php  
            if (isset($complementos) && count($complementos) > 0) { ?>
                <div class="slider-adicionales">
                    <p class="text-bold">COMPLEMENTOS</p>
                    <p>Si deseas, puedes añadir a tu regalo:</p>
                    <input type="hidden" name="opcion" value="<?php echo $opciones[$x]['id']; ?>">
                    <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;loop&quot;: true, &quot;margin&quot;: 30, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 4000, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:2,&quot;margin&quot;: 10},&quot;630&quot;:{&quot;items&quot;:2},&quot;991&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}} }">
                    <?php
                        foreach ($complementos as $cmp):
                            $prod = new Producto($cmp['id']);
                            $imgscmp = $prod->__get("_imagenes"); ?>
                                <div class="content_agregar text-center">
                                    <div class="a_imagen">
                                        <img class="img" src="<?php echo _catalogo_ . $imgscmp[0]['thumbnail'] ?>" alt="" />
                                    </div>
                                    <div class="nameProd"><?php echo $prod->__get("_nombre"); ?></div>
                                    <div class="priceProd text-bold">
                                        <span class="precio_add" id="precio_detalle">
                                            $<?php echo $prod->__get("_precio_producto"); ?>
                                        </span>
                                        <span class="soles">
                                            (S/.<?php echo number_format($prod->__get("_precio_producto") * TIPO_CAMBIO, 2); ?>)
                                        </span>
                                    </div>
                                    <input type="hidden" name="precio" value="<?php echo $prod->__get("_precio_producto"); ?>">
                                    <input type="hidden" name="id_valor" value="<?php echo $cmp['id']; ?>">
                                    <input type="hidden" name="cantidad_valor" cantidad="<?php echo $prod->__get("_stock"); ?>">
                                    <input type="hidden" name="precio_producto" value="<?php echo number_format($obj_producto->__get("_precio_producto"), 2); ?>">
                                    <button class="btn btn-sm btn-success btn_anadir btn-less-height">Agregar</button>
                                </div>

                        <?php endforeach; ?>                                              

                    </div>
                </div>

            <?php } ?>
            <hr class="mt-3">
            <div id="box_agregar_carrito">

                <form name="envio_carrito" id="producto_mas_adicionales" class="form" method="post">

                    <span class="nombre_producto"><?php echo $obj_producto->__get("_nombre"); ?>: $<?php echo number_format($obj_producto->__get("_precio_producto"), 2); ?></span>
                    <span class="soles costo_producto">&nbsp; (s/.<?php echo number_format($obj_producto->__get("_precio_producto") * TIPO_CAMBIO, 2); ?>)</span>                       
                    <input type="hidden" name="id_producto" value="<?php echo $obj_producto->__get("_id"); ?>">                        
                    <input type="hidden" name="action" value="add">                         
                    <div id="prod_agregado">
                        <ul>
                            
                        </ul>
                    </div>

                    <hr>

                    <div id="precio_btn" class="d-flex flex-wrap justify-content-between">
                        <div class="container">
                            <div class="row justify-content-center align-items-center">
                                <div class="col">
                                    <span>Cant: &nbsp;
                                        <select class="form-control form-control-sm"  name="cantidad" id="cant" style="display: inline-block; max-width: 80px;">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="col">
                                    <span class="text-bold" id="precio_temp">Subtotal: $<?php echo number_format($obj_producto->__get("_precio_producto"), 2); ?></span>
                                    &nbsp;
                                </div>
                                <div class="col remove-movil">
                                    <a class="btn btn-success-dark btn-sm addCarritoDetalle" data="add,<?php echo $obj_producto->__get("_id")?>,1" onclick="addShopBagAdicionales(this)">Agregar al Carrito</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="cont-btn-addcarrito-solo-movil">
                        <a class="addCarritoDetalle" data="add,<?php echo $obj_producto->__get("_id")?>,1" onclick="addShopBagAdicionales(this)"><i class="fas fa-shopping-cart"></i> AGREGAR AL CARRITO</a>
                    </div>
                </form>
            </div>
            <hr>    
        </div>


        <!-- Product Tabs-->
        <div class="col-md-12 product-tabs">
            <div class="row padding-top-1x mb-3">
              <div class="col-lg-6 margin-bottom-1x">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item"><a class="nav-link active" href="#description" data-toggle="tab" role="tab">Descripción</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <?php echo $obj_producto->__get("_descripcion"); ?>
                  </div>

                </div>
              </div>
                
              <div class="col-lg-6">
                
                <?php /*Consulta para traer productos que pueden desear*/ 
                $cat = $obj_producto->__get("_categoria")->__get("_id");
                $querymr = new Consulta("SELECT * FROM productos WHERE id_categoria = '" . $cat . "' AND is_complemento=0 AND estado_producto = 1 ORDER BY RAND() LIMIT 0,4"); 
                ?>

                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item"><a class="nav-link active" href="#description" data-toggle="tab" role="tab">Más regalos que te pueden gustar</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <div class="row">
                        <?php while ($row = $querymr->VerRegistro()) {
                        $producto_recomendado = new Producto($row['id_producto']);
                        $imgs = $producto_recomendado->__get("_imagenes");
                        ?>
                        <div class="col-sm-6 margin-bottom-1x">
                            <div class="card card-te-recomendamos text-center">
                                <?php if ($imgs[0]['middle']){ ?>
                                    <a class="product-thumb" href="<?php echo str_replace(" ", "-", $producto_recomendado->__get("_nombre")); ?>">
                                        <img src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url('<?php echo _catalogo_ . $imgs[0]['middle'] ?>');" alt="" /> 
                                         
                                    </a>
                                <?php }else{ ?>
                                    <a class="product-thumb" href="<?php echo str_replace(" ", "-", $producto_recomendado->__get("_nombre")); ?>">
                                        <img src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url('<?php echo _catalogo_ ?>not_image_disponible.jpg');" />  
                                    </a>
                                <?php } ?>

                              <div class="card-body">

                                <a class="product-title-in-card" href="<?php echo $producto_recomendado->__get("_nombre"); ?>"><?php echo $producto_recomendado->__get("_nombre"); ?></a>

                                <h4 class="product-price">
                                    <?php if ($producto_recomendado->__get("_dscto") != "") { ?>
                                        <span class="oldPrice">$<?php echo $producto_recomendado->__get("_precio_old"); ?></span>
                                        <span class="desc">-<?php echo $producto_recomendado->__get("_dscto") ?>%</span>
                                    <?php } ?>
                                    $<?php echo number_format($producto_recomendado->__get("_precio_producto"), 2);?>


                                </h4>
                                <div class="product-buttons">
                                    <a href="<?php echo str_replace(" ", "-", $producto_recomendado->__get("_nombre")); ?>" class="btn_detalle"></a>
                                    <div class="text-center">
                                        <a class="btn btn-outline-success btn-sm addCarrito" data="add,<?php echo $producto_recomendado->__get("_id")?>,1" onclick="addShopBag(this)">Comprar</a>
                                    </div>
                                </div>

                              </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        
                    </div>
                  </div>

                </div>
              </div>

            </div>
        </div>
        <!-- END Product Tabs-->

        <!-- Prod Just For Movil -->
        <div class="contenedor-owl-carousel-mas-productos-just-movil">
            <?php /*Consulta para traer productos que pueden desear*/ 
            $cat = $obj_producto->__get("_categoria")->__get("_id");
            $querymr = new Consulta("SELECT * FROM productos WHERE id_categoria = '" . $cat . "' AND is_complemento=0 AND estado_producto = 1 ORDER BY RAND() LIMIT 0,4"); 
            ?>
            <div class="owl-carousel owl-carousel-mas-productos-just-movil">
                <?php while ($row = $querymr->VerRegistro()) {
                $producto_recomendado = new Producto($row['id_producto']);
                $imgs = $producto_recomendado->__get("_imagenes");
                ?>
                <div class="item">
                    <?php if ($imgs[0]['middle']){ ?>
                        <a class="product-thumb" href="<?php echo str_replace(" ", "-", $producto_recomendado->__get("_nombre")); ?>">
                            <img src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url('<?php echo _catalogo_ . $imgs[0]['middle'] ?>');" alt="" /> 
                             
                        </a>
                    <?php }else{ ?>
                        <a class="product-thumb" href="<?php echo str_replace(" ", "-", $producto_recomendado->__get("_nombre")); ?>">
                            <img src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url('<?php echo _catalogo_ ?>not_image_disponible.jpg');" />  
                        </a>
                    <?php } ?>
                    <a class="product-title-in-card" href="<?php echo $producto_recomendado->__get("_nombre"); ?>"><?php echo $producto_recomendado->__get("_nombre"); ?></a>   
                    <h4 class="product-price">
                        <?php if ($producto_recomendado->__get("_dscto") != "") { ?>
                            <span class="oldPrice">$<?php echo $producto_recomendado->__get("_precio_old"); ?></span>
                            <span class="desc">-<?php echo $producto_recomendado->__get("_dscto") ?>%</span>
                        <?php } ?>
                        $<?php echo number_format($producto_recomendado->__get("_precio_producto"), 2);?>
                    </h4>
                    <div class="product-buttons">
                        <a href="<?php echo str_replace(" ", "-", $producto_recomendado->__get("_nombre")); ?>" class="btn_detalle"></a>
                        <div class="text-center">
                            <a class="btn btn-outline-success btn-sm addCarrito" data="add,<?php echo $producto_recomendado->__get("_id")?>,1" onclick="addShopBag(this)">Comprar</a>
                        </div>
                    </div>
                    
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- END Prod Just For Movil -->

      </div>

    </div>

    <!-- FIN PAGINA -->
<?php include(_tpl_includes_ . "inc.bottom.php"); ?>

    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->

    <!-- Photoswipe container-->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="pswp__bg"></div>
      <div class="pswp__scroll-wrap">
        <div class="pswp__container">
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
          <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
            <button class="pswp__button pswp__button--share" title="Share"></button>
            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
            <div class="pswp__preloader">
              <div class="pswp__preloader__icn">
                <div class="pswp__preloader__cut">
                  <div class="pswp__preloader__donut"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
            <div class="pswp__share-tooltip"></div>
          </div>
          <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
          <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
          <div class="pswp__caption">
            <div class="pswp__caption__center"></div>
          </div>
        </div>
      </div>
    </div>


    <div class="site-backdrop"></div>