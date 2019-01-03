<?php
$total_c = 0;
$carrito = $cuenta->getCliente()->getCarrito();
$content = $carrito->getContent();
$total_c = $carrito->count_Content();
?>
<!-- carrito derecha -->
<div class="offcanvas-bag-shop" id="bag-shop">
  <div class="row row-cabecera-bag-shop">
    <div class="col col-bag-shop-title">
      <span class="title-bag-shop"><i class="pe-7s-cart" style="font-weight: 700"></i> Carrito de Compras </span>
      <span class="close-bag-shop"><a><i class="icon-arrow-left"></i></a></span>
    </div>
  </div>
  <div class="cuerpo-bag-shop-cal">
    <!-- contenido del carrito -->
  </div>

</div>
<!-- Show filter modals -->
<div class="modal fade" id="modalShopFilters" tabindex="-1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Filtros</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <!-- Widget Categories-->
        <section class="widget widget-categories">
          <h3 class="widget-title">Ocasiones Especiales</h3>
          <ul>
            <li><a href="#">Aniversarios</a></li>
            <li><a href="#"></a></li>
            <li><a href="#"></a></li>
            <li><a href="#"></a></li>
            <li class="has-children"><a href="#">Flores</a><span>(1138)</span>
              <ul>
                <li><a href="#">Women's</a><span>(508)</span>
                  <ul>
                    <li><a href="#">Sneakers</a></li>
                    <li><a href="#">Heels</a></li>
                    <li><a href="#">Loafers</a></li>
                    <li><a href="#">Sandals</a></li>
                  </ul>
                </li>
                <li><a href="#">Girl's Shoes</a><span>(110)</span></li>
              </ul>
            </li>
            <li class="has-children"><a href="#">Clothing</a><span>(2356)</span>
              <ul>
                <li><a href="#">Men's</a><span>(937)</span>
                  <ul>
                    <li><a href="#">Shirts &amp; Tops</a></li>
                    <li><a href="#">Shorts</a></li>
                    <li><a href="#">Swimwear</a></li>
                    <li><a href="#">Pants</a></li>
                  </ul>
                </li>
                <li><a href="#">Kid's Clothing</a><span>(386)</span></li>
              </ul>
            </li>
            <li class="has-children"><a href="#">Bags</a><span>(420)</span>
              <ul>
                <li><a href="#">Handbags</a><span>(180)</span></li>
              </ul>
            </li>
            <li class="has-children"><a href="#">Accessories</a><span>(874)</span>
              <ul>
                <li><a href="#">Sunglasses</a><span>(211)</span></li>
                <li><a href="#">Hats</a><span>(195)</span></li>
              </ul>
            </li>
          </ul>
        </section>
        <!-- Widget Price Range-->
        <section class="widget">
          <h3 class="widget-title">Price Range</h3>
          <select class="form-control">
            <option>0 - $100</option>
            <option>$100 - $200</option>
          </select>
        </section>
        <!-- Widget Brand Filter-->
        <section class="widget">
          <h3 class="widget-title">Filter by Brand</h3>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="adidas">
            <label class="custom-control-label" for="adidas">Adidas&nbsp;<span class="text-muted">(254)</span></label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="bilabong">
            <label class="custom-control-label" for="bilabong">Bilabong&nbsp;<span class="text-muted">(39)</span></label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="klein">
            <label class="custom-control-label" for="klein">Calvin Klein&nbsp;<span class="text-muted">(128)</span></label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="nike">
            <label class="custom-control-label" for="nike">Nike&nbsp;<span class="text-muted">(310)</span></label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="bahama">
            <label class="custom-control-label" for="bahama">Tommy Bahama&nbsp;<span class="text-muted">(42)</span></label>
          </div>
        </section>
        <!-- Widget Size Filter-->
        <section class="widget">
          <h3 class="widget-title">Filter by Size</h3>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="xl">
            <label class="custom-control-label" for="xl">XL&nbsp;<span class="text-muted">(208)</span></label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="l">
            <label class="custom-control-label" for="l">L&nbsp;<span class="text-muted">(311)</span></label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="m">
            <label class="custom-control-label" for="m">M&nbsp;<span class="text-muted">(485)</span></label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="s">
            <label class="custom-control-label" for="s">S&nbsp;<span class="text-muted">(213)</span></label>
          </div>
        </section>
        <!-- Promo Banner-->
        <section class="promo-box" style="background-image: url(img/banners/02.jpg);">
          <!-- Choose between .overlay-dark (#000) or .overlay-light (#fff) with default opacity of 50%. You can overrride default color and opacity values via 'style' attribute.--><span class="overlay-dark" style="opacity: .45;"></span>
          <div class="promo-box-content text-center padding-top-3x padding-bottom-2x">
            <h4 class="text-light text-thin text-shadow">New Collection of</h4>
            <h3 class="text-bold text-light text-shadow">Sunglassess</h3><a class="btn btn-sm btn-primary" href="#">Shop Now</a>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>
<!-- Off-Canvas Category Menu-->
<div class="offcanvas-container" id="shop-categories">
  <div class="offcanvas-header">
    <h3 class="offcanvas-title">Categorias</h3>
  </div>
  <nav class="offcanvas-menu">
    <ul class="menu">
      <li class="has-children">
        <span>
          <a href="#">Flores</a>
          <span class="sub-menu-toggle"></span>
        </span>
        <ul class="offcanvas-submenu">
          <li class="has-children">
            <span>
              <a href="#">Ocasiones</a>
              <span class="sub-menu-toggle"></span>
            </span>
            <ul class="offcanvas-submenu">
              <li><a href="#">Arreglo para Aniversarios</a></li>
              <li><a href="#">Flores para Cumpleaños</a></li>
              <li><a href="#">Mejorate Pronto</a></li>
              <li><a href="#">Aniversario</a></li>
            </ul>
          </li>
          <li class="has-children">
            <span>
              <a href="#">Arreglos Florales</a>
              <span class="sub-menu-toggle"></span>
            </span>
            <ul class="offcanvas-submenu">
              <li><a href="#">Variados</a></li>
              <li><a href="#">Con Rosas</a></li>
              <li><a href="#">Con Girasoles</a></li>
            </ul>
          </li>
          <li class="has-children">
            <span>
              <a href="#">Ramo de Rosas</a>
              <span class="sub-menu-toggle"></span>
            </span>
            <ul class="offcanvas-submenu">
              <li><a href="#">De Rosas</a></li>
              <li><a href="#">De Tulipanes</a></li>
              <li><a href="#">Variados Ramo</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="has-children"><span><a href="#">Desayunos</a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
          <li><a href="#">Sandals</a></li>
          <li><a href="#">Flats</a></li>
          <li><a href="#">Sneakers</a></li>
          <li><a href="#">Heels</a></li>
          <li><a href="#">View All</a></li>
        </ul>
      </li>
      <li class="has-children"><span><a href="#">Peluches</a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
          <li><a href="#">Shirts &amp; Tops</a></li>
          <li><a href="#">Pants</a></li>
          <li><a href="#">Jackets</a></li>
          <li><a href="#">View All</a></li>
        </ul>
      </li>
      <li class="has-children"><span><a href="#">Para Hombre</a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
          <li><a href="#">Dresses</a></li>
          <li><a href="#">Shirts &amp; Tops</a></li>
          <li><a href="#">Shorts</a></li>
          <li><a href="#">Swimwear</a></li>
          <li><a href="#">View All</a></li>
        </ul>
      </li>
      <li class="has-children"><span><a href="#">Ocaciones</a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
          <li><a href="#">Boots</a></li>
          <li><a href="#">Sandals</a></li>
          <li><a href="#">Crib Shoes</a></li>
          <li><a href="#">Loafers</a></li>
          <li><a href="#">View All</a></li>
        </ul>
      </li>

    </ul>
  </nav>
</div>
<!-- Off-Canvas Mobile Menu-->
<div class="offcanvas-container" id="mobile-menu">
  <!-- <a class="account-link" href="<?php echo _url_web_."seccion/cuenta/edit"?>"> -->
    <a class="account-link" onclick="loginNormal()">
    <?php if ($cuenta->getCliente()->getLogeado()){ ?>
    <div class="user-ava">
    <img src="app/view/front-end/last/img/account/user-ava-sm.png" alt="Daniel Adams">
    </div>
    <div class="user-info">
        <h6 class="user-name">Kevin Flores Castro</h6><span class="text-sm text-white opacity-60"></span>
    </div>
    <?php }else{ ?>
    <div class="user-ava">
    <i class="fas fa-user-circle" style="font-size: 31px;
    color: white;"></i>
    </div>
    <div class="user-info">
        <h6 class="user-name">Ingresar / Registrarse</h6><span class="text-sm text-white opacity-60"></span>
    </div>
    <?php } ?>
  </a>
  <nav class="offcanvas-menu offcanvas-donregalo">
    <a href="" class="d-block">Arreglos Florales <span><i class="icon-plus"></i></span></a>
    <ul class="menu-donregalo">
      <li class="li-donregalo"><a href="">Arreglos para Aniversario</a></li>
      <li class="li-donregalo"><a href="">Flores para Cumpleaños</a></li>
      <li class="li-donregalo"><a href="">Mejorate Pronto</a></li>
      <li class="li-donregalo"><a href="">Aniversario Institucional</a></li>
      <li class="li-donregalo"><a href="">Variados</a></li>
    </ul>
    <a href="" class="d-block">Ocasiones Especiales<span><i class="icon-plus"></i></span></a>
    <ul class="menu-donregalo">
      <li class="li-donregalo"><a href="">Cumpleaños</a></li>
      <li class="li-donregalo"><a href="">Aniversarios</a></li>
      <li class="li-donregalo"><a href="">Condolencias</a></li>
    </ul>
    <!-- <ul class="menu">
      <li class="has-children"><span><a><span>Arreglos Florales</span></a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
          <li><a href="">Cumpleaños</a></li>
          <li><a href="">Para Hombre</a></li>
          <li><a href="">Aniversario</a></li>
          <li><a href="">Condolencias</a></li>
          <li><a href="">Ofertas</a></li>
        </ul>
      </li>
      <li class="has-children"><span><a><span>Categorias</span></a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
            <li><a href="<?php echo _url_web_."flores"?>">Flores</a></li>
            <li><a href="<?php echo _url_web_."desayunos"?>">Desayunos</a></li>
            <li><a href="<?php echo _url_web_."peluches"?>">Peluches</a></li>
            <li><a href="<?php echo _url_web_."canastas"?>">Canastas</a></li>
        </ul>
      </li>
    </ul> -->
  </nav>
</div>

<!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
<header class="navbar navbar-stuck" style="/*background-image: url(<?php echo _tpl_resources_ ?>imgs/background-nav.png); background-repeat: repeat-x;*/ background-color: #ffffff; background-image: url(<?php echo _tpl_resources_ ?>imgs/line.jpg); background-repeat: repeat-x; background-position: top; ">
  <!-- Search-->
  <form class="site-search" method="get">
    <input type="text" id="buscar_donregalo_movil" name="site_search" placeholder="Escribe para Buscar...">
    <div class="search-tools"><span class="clear-search">Limpiar</span><span class="close-search"><i class="icon-cross"></i></span></div>
  </form>
  <div class="container container-top">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-5 col-md-5 col-sm-3 col menu-top-left">
        <span class="opciones-en-responsive">
          <a class="offcanvas-toggle menu-toggle" href="#mobile-menu" data-toggle="offcanvas"></a>
          <span class="xs-none"><i class="fab fa-whatsapp"></i></span>&nbsp;
          <span class="numero-whatsapp xs-none">977174485</span>&nbsp;&nbsp;
        </span>
        <ul class="ul-menu-top">
          <li><a href="<?php echo _url_web_ ?>c/flores">FLORES</a></li>
          <li><a href="<?php echo _url_web_ ?>c/desayunos">DESAYUNOS</a></li>
          <li><a href="<?php echo _url_web_ ?>c/peluches">PELUCHES</a></li>
          <li><a href="<?php echo _url_web_ ?>c/canastas">CANASTAS</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-6 col text-center" style="padding-right: 0px; padding-left: 0px;">
        <a href=""><img class="logo-top" src="app/view/front-end/last/imgs/logo-top.png" alt="Don Regalo"></a>
      </div>
      <div class="col-lg-5 col-md-5 col-sm-3 col text-right">
          <div class="opciones-menu-top-derecha">
            <i class="icon-search activa-busqueda"></i>
            <input class="input-menu-top sm-none" type="text" id="buscar_donregalo" placeholder="Buscar..">&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="sm-none"><i class="fab fa-whatsapp"></i></span>&nbsp;
            <span class="numero-whatsapp sm-none">977174485</span>&nbsp;&nbsp;
            <?php if ($cuenta->getCliente()->getLogeado()){ ?>
            <span class="sm-none">
              <i class="">
                <img src="app/view/front-end/last/img/account/user-ava-sm.png" alt="User" style="width: 35px;">
                <ul class="lista-opciones-usuario-top">
                  <li class="text-uppercase"><?php echo $cuenta->getCliente()->__get("_nombre") ?></li>
                  <li class="separator"></li>
                  <li><a href="<?php echo _url_web_."seccion/cuenta/edit"?>">Mis Datos Personales</a></li>
                  <li><a href="<?php echo _url_web_."seccion/cuenta/password-edit"?>">Cambiar mi Password</a></li>
                  <li><a href="<?php echo _url_web_."seccion/cuenta/pedidos"?>">Historial de Pedido</a></li>
                  <li><a href="<?php echo _url_web_."seccion/cuenta/fechas-especiales"?>">Fechas Especiales</a></li>
                  <li class="separator"></li>
                  <li><a href="<?php echo _url_web_."seccion/cuenta/salir"; ?>"> <i class="fas fa-sign-out-alt"></i> Salir</a></li>
                </ul>
              </i>
            </span>&nbsp;&nbsp;
            <?php }else{ ?>
            <span class="sm-none">
              <i class="fas fa-user-circle">
                <ul class="lista-opciones-usuario-top">
                  <li class="text-uppercase">
                    <input type="hidden" id="logueadoquick" value="0">
                    <span><a onclick="loginNormal()">Entra Aquí</a></span>
                  </li>
                </ul>
              </i>
            </span>&nbsp;&nbsp;
            <?php } ?>
            
            <?php if (basename($_SERVER['PHP_SELF']) == 'pago_finalizado') { ?>
                <div id="carrito">
                  <span><i class="pe-7s-cart"></i></span>
                  <span class="cantidad-items-menu-top">(0)</span>
                </div>
            <?php } else { ?> 
                <div id="carrito">
                  <a href="cart.html"></a>
                  <i class="pe-7s-cart"></i>
                  <span class="count"><?php echo $total_c; ?></span>
                </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="contenedor-menu-top-ocasiones">
    <div class="container">
      <div class="row justify-content-center">
        <ul class="lista-menu-top-ocasiones">
          <li>
            <a href="<?php echo _url_web_ ?>f/cumpleanos"><i class="fas fa-birthday-cake"></i>&nbsp;&nbsp; Cumpleaños</a>
          </li>
          <li>
            <a href="<?php echo _url_web_ ?>f/destinatario/para-hombre"><i class="fab fa-black-tie"></i>&nbsp;&nbsp; Para Hombre</a>
          </li>
          <li>
            <a href="<?php echo _url_web_ ?>f/aniversario"><i class="fab fa-fort-awesome-alt"></i>&nbsp;&nbsp; Aniversario</a>
          </li>
          <li>
            <a href="<?php echo _url_web_ ?>f/condolencias"><i class="fas fa-ribbon"></i>&nbsp;&nbsp; Condolencias</a>
          </li>
          <li>
            <a href="<?php echo _url_web_ ?>f/ofertas"><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp; Ofertas</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>
<!-- Off-Canvas Wrapper-->


<?php
$obj_cat = new Categorias($msgbox);
$cats = $obj_cat->getCategorias('', 0);
?>