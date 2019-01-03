<?php 
/* mas regalos que te pueden gustar*/
$cat = $obj_producto->__get("_categoria")->__get("_id");
$lista_mas_regalos = Productos::getProductosRecomendados(3,$cat);
?>

        <!-- Related Products Carousel-->
        <h3 class="text-center margin-top-1x">Más regalos que te puedan gustar</h3>
        <!-- Carousel-->
          
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel owl-carousel-mas-regalos">
                        

                    <?php foreach ($lista_mas_regalos as $row):
                    $objPro = new Producto($row['id']);
                    $imgs = $objPro->__get("_imagenes");
                    ?>

                    <!-- Product-->
                        <div class="grid-item">
                            <div class="product-card">

                                <?php if ($imgs[0]['middle']){ ?>
                                    <a class="product-thumb" href="<?php echo str_replace(" ", "-", $objPro->__get("_nombre")); ?>">
                                        <img class="imagen-mas-regalos" src="<?php echo _catalogo_ . 'baseencarrito.png'; ?>" style="background-image: url('<?php echo _catalogo_ . $imgs[0]['middle'] ?>');" /> 
                                         
                                    </a>
                                <?php }else{ ?>
                                    <a class="product-thumb" href="<?php echo str_replace(" ", "-", $objPro->__get("_nombre")); ?>">
                                        <img class="imagen-mas-regalos" src="<?php echo _catalogo_ . 'baseencarrito.png'; ?>" style="background-image: url('<?php echo _catalogo_ ?>not_image_disponible.jpg');"/>  
                                    </a>
                                <?php } ?>

                              <h3 class="product-title">
                                <a href="<?php echo $objPro->__get("_nombre"); ?>"><?php echo $objPro->__get("_nombre"); ?></a>
                              </h3>
                              <h4 class="product-price">
                                <?php if ($objPro->__get("_dscto") != "") { ?>
                                    <span class="oldPrice">$<?php echo $objPro->__get("_precio_old"); ?></span>
                                    <span class="desc">-<?php echo $objPro->__get("_dscto") ?>%</span>
                                <?php } ?>
                                $<?php echo number_format($objPro->__get("_precio_producto"), 2);?>


                              </h4>
                              
                              <div class="text-center">
                                  <a class="btn btn-outline-success btn-sm" data="add,<?php echo $objPro->__get("_id")?>,1" onclick="addShopBag(this)">Comprar</a>
                              </div>

                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <script>
            $('.owl-carousel').owlCarousel({
                nav:false,
                autoplayTimeout: 4000,
                margin: 30,
                loop: false,
                dots: false,
                autoplay: true,
                responsive:{
                    0:{
                        items:1
                    },
                    630:{
                        items:2
                    },
                    991:{
                        items:3
                    }
                } 
            })
        </script>

