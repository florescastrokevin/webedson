    <div class="offcanvas-wrapper">
      <!-- Page Content-->
      <!-- Main Slider-->
      <section class="hero-slider" style="background-color: #aaedd5/*url(<?php echo _tpl_resources_ ?>imgs/banner-donregalon.jpg)*/;">
        <div class="owl-carousel large-controls dots-inside" data-owl-carousel="{ &quot;nav&quot;: true, &quot;dots&quot;: true, &quot;loop&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 7000 }">
          <div class="item">
            <div class="container padding-top-1x">
              <div class="row justify-content-center align-items-center">
                <div class="col-lg-5 col-md-6 padding-bottom-2x text-center">
                  <div class="from-bottom">
                    <div class="h1 text-left text-bold mb-2 pt-1">Oso Cariñosito</div>
                    <div class="h2 text-left text-semibold mb-4 pb-1">En oferta a solo: $37.99</div>
                  </div>
                  <a class="btn btn-home-ver-oferta scale-up delay-1" href="">Ver Ofertas</a>
                </div>
                <div class="col-md-6 padding-top-3x mb-3"><img class="d-block mx-auto" src="<?php echo _tpl_resources_ ?>imgs/osobanner.png" alt=""></div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="container padding-top-1x">
              <div class="row justify-content-center align-items-center">
                <div class="col-lg-5 col-md-6 padding-bottom-2x text-center">
                  <div class="from-bottom">
                    <div class="h1 text-left text-bold mb-2 pt-1">Desayuno San Valentin</div>
                    <div class="h2 text-left text-semibold mb-4 pb-1">En oferta a solo: $37.99</div>
                  </div>
                  <a class="btn btn-home-ver-oferta scale-up delay-1" href="">Ver Ofertas</a>
                </div>
                <div class="col-md-6 padding-top-3x mb-3"><img class="d-block mx-auto" src="<?php echo _tpl_resources_ ?>imgs/desayunobanner.png" alt=""></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Featured Products Carousel-->
      <section class="container padding-top-3x padding-bottom-2x">
        <h2 class="text-center mb-30 titulo-home">Más Populares</h2>
        <div class="owl-carousel carousel-productos-destacados" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;margin&quot;: 0, &quot;stagePadding&quot;: 0, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:2},&quot;576&quot;:{&quot;items&quot;:3},&quot;768&quot;:{&quot;items&quot;:3},&quot;991&quot;:{&quot;items&quot;:4},&quot;1200&quot;:{&quot;items&quot;:6}} }">
          <?php foreach ($lista_destacado as $pro): ?>
          <?php $objPro = new Producto($pro['id']) ?>

          <div class="grid-item">
            <div class="product-card">
              <?php $img = $objPro->__get('_imagenes')?>
              <?php $imagenPro = $img[0]['middle']; ?>
              <a class="product-thumb" href="">
                <img src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url(<?php echo _catalogo_ ?><?php echo $imagenPro ?>);" alt="Product">
              </a>
              <div class="card-text-content">
                  <a class="product-title" href="DESAYUNO-MELOSO" ><?php echo $objPro->__get('_nombre') ?></a>
                  <!-- <h4 class="product-price">
                    <del><?php echo $objPro->__get('_precio_old') ?></del><?php echo $objPro->__get('_precio_producto') ?>
                  </h4> -->
              </div>
              <!-- <div class="text-center">
                  <a class="btn btn-outline-success btn-sm addCarrito" data="add,<?php echo $objPro->__get("_id")?>,1" onclick="addShopBag(this)">Comprar</a>
              </div> -->
            </div>
          </div>
          <!-- Product-->
          <?php endforeach ?>
        </div>
      </section>
  
      <section class="section-mas-buscados padding-top-1x padding-bottom-2x">

        <div class="container">
          <h2 class="text-center mb-30 titulo-home">Más buscados</h2>
          <div class="owl-carousel div-carousel-mas-buscados" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;margin&quot;: 20, &quot;stagePadding&quot;: 3, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:2},&quot;576&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:2},&quot;991&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:4}} }">
            <div class="grid-item">
              <div class="tarjeta">
                <div class="tarjeta-top text-center">
                  <img src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url(<?php echo _catalogo_ ?>middle_1465246741desayunoparapapa.jpg);">
                </div>
                <div class="tarjeta-bottom">
                  <p>Por ser una fecha especial</p>
                  <p>Cumpleaños</p>
                </div>
              </div>
            </div>

            <div class="grid-item">
              <div class="tarjeta">
                <div class="tarjeta-top text-center">
                  <img src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url(<?php echo _catalogo_ ?>middle_1465246741desayunoparapapa.jpg);">
                </div>
                <div class="tarjeta-bottom">
                  <p>Por ser una fecha especial</p>
                  <p>Cumpleaños</p>
                </div>
              </div>
            </div>

            <div class="grid-item">
              <div class="tarjeta">
                <div class="tarjeta-top text-center">
                  <img src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url(<?php echo _catalogo_ ?>middle_1465246741desayunoparapapa.jpg);">
                </div>
                <div class="tarjeta-bottom">
                  <p>Por ser una fecha especial</p>
                  <p>Cumpleaños</p>
                </div>
              </div>
            </div>

            <div class="grid-item">
              <div class="tarjeta">
                <div class="tarjeta-top text-center">
                  <img src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" style="background-image: url(<?php echo _catalogo_ ?>middle_1465246741desayunoparapapa.jpg);">
                </div>
                <div class="tarjeta-bottom">
                  <p>Por ser una fecha especial</p>
                  <p>Cumpleaños</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section>
        <div class="container">
          <div class="row padding-top-2x padding-bottom-2x">
            <div class="col-sm-7 d-flex home-contenedor-informativo-text">
              <div class="justify-content-center align-self-center">
                <p class="">¿Buscando el regalo ideal?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur voluptates quidem voluptate optio, molestias dignissimos. Nisi maxime assumenda quaerat aliquid illo voluptatum iste veniam expedita minima itaque. Quisquam, inventore, dolore.</p>
              </div>
            </div>
            <div class="col-sm-5">
              <img src="<?php echo _imgs_ ?>testhome.jpg" alt="">
            </div>
          </div>
          <hr>
          <div class="row padding-top-2x padding-bottom-2x">
            <div class="col-sm-5">
              <img src="<?php echo _imgs_ ?>testhome2.jpg" alt="">
            </div>
            <div class="col-sm-7 d-flex home-contenedor-informativo-text">
              <div class="justify-content-center align-self-center">
                <p class="">¡Sorprende! <span>a esa presona especial.</span></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur voluptates quidem voluptate optio, molestias dignissimos. Nisi maxime assumenda quaerat aliquid illo voluptatum iste veniam expedita minima itaque. Quisquam, inventore, dolore.</p>
              </div>
            </div>
          </div>
          <hr>
          <div class="row padding-top-2x padding-bottom-2x">
            <div class="col-sm-7 d-flex home-contenedor-informativo-text">
              <div class="justify-content-center align-self-center">
                <p class="">No importa el motivo... <br><span>Fabríca el momento ideal</span></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur voluptates quidem voluptate optio, molestias dignissimos. Nisi maxime assumenda quaerat aliquid illo voluptatum iste veniam expedita minima itaque. Quisquam, inventore, dolore.</p>
              </div>
            </div>
            <div class="col-sm-5">
              <img src="<?php echo _imgs_ ?>testhome3.jpg" alt="">
            </div>
          </div>
        </div>
      </section>
      
      <?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>
