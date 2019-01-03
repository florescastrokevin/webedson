<?php //include(_tpl_includes_."inc.header.php");
$carrito = $cuenta->getCliente()->getCarrito();
$content = $carrito->getContent();
$view = 'cesta';
$f = ($view=='cesta')?'':'_c';      
?>
<?php
$fp = new FormasPago();
$formasPago = $fp->getFormasPago();
$i = 0;
?>
<div class="offcanvas-wrapper" id="compra3">

      <div class="container padding-bottom-3x mb-2 padding-top-1x">
        <div class="row">
          <!-- Checkout Adress-->
          <div class="col-xl-10">
            <div class="checkout-steps">
              <a class="active">3. Confirmar Pedido</a>
              <a class="completed" href="<?php echo _url_web_ ?>seccion/pedido/pago"></span><span class="angle"></span><span class="steps-d">2. Datos de Pago</span><span class="steps-m">2</span></a>
              <a class="completed" href="<?php echo _url_web_ ?>seccion/pedido"></span><span class="angle"></span><span class="steps-d">1. Datos de Entrega</span><span class="steps-m">1</span></a>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6">
            <h4>Detalle: </h4>
            <hr>
            <br>
            <p class="text-muted" style="letter-spacing: normal;">Revisa tu pedido antes de confirmar la compra. Los gastos de envío son calculados en base al distrito de envío</p>
            <?php include(_tpl_includes_ . "inc.cesta.php"); ?>     

            <?php
            switch ($pedido->getMetodoPago()->__get('_nombre')) {
                case 'Paypal': 
                    $detail = Paypal::preparaDetalle($carrito); 
                    $direc_envio = '';
                    $direc_fac = '';
                    break;

                case 'Visa':

                    $visa = new Visa();
                    $term.= '<h3>T&eacute;rminos y Condiciones : </h3><div id="terminos_condiciones">' . $visa->getTerminosYCondiciones() . '</div>';
                    $term.= '<div id="terminos_visa">';
                    $term.= '<input type="checkbox" id="term" name="term"> Acepto todos los términos y condiciones.';
                    $term.= '</div>';
                    break;
            }
            ?>  
          </div>

          <div class="col-xl-6 col-lg-6">
            <h4>Datos de Entrega: </h4>
            <hr>
            <br>
            <h6><span class="text-bold">Forma de Envio:</span> DELIVERY</h6>
            <h6><span class="sub-titulo-datos-entrega">Datos del Destinatario:</span></h6>
            <br>
            <div class="row">
              <div class="col-md-6">
                <table class="table table-sm">
                  <tbody>
                    <tr>
                      <td class="border-top-0 text-bold w-3">Nombre:</td>
                      <td class="border-top-0"><?php echo $pedido->getDestinatario()->__get("_nombre"); ?></td>
                    </tr>
                    <tr>
                      <td class="border-top-0 text-bold w-3">Apellidos:</td>
                      <td class="border-top-0"><?php echo $pedido->getDestinatario()->__get("_apellidos"); ?></td>
                    </tr>
                    <tr>
                      <td class="border-top-0 text-bold w-3">Teléfono:</td>
                      <td class="border-top-0"><?php echo $pedido->getDestinatario()->__get("_telefono"); ?></td>
                    </tr>
                  </tbody>
                </table>
                <!-- <dl class="row">
                    <dt class="col-sm-5 text-right border-top text-bold">Nombres:</dt>
                    <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_nombre"); ?></dd>
                    <dt class="col-sm-5 text-right border-top text-bold">Apellidos:</dt>
                    <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_apellidos"); ?></dd>
                    <dt class="col-sm-5 text-right border-top text-bold">Teléfono:</dt>
                    <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_telefono"); ?></dd>
                </dl> -->
              </div>
              <div class="col-md-6">
                <table class="table table-sm">
                  <tbody>
                    <tr>
                      <td class="border-top-0 text-bold w-3">Distrito:</td>
                      <td class="border-top-0"><?php echo str_replace('Ã‘', 'Ñ', $pedido->getDestinatario()->__get("_distrito")->__get('_nombre')); ?> , Lima, Perú</td>
                    </tr>
                    <tr>
                      <td class="border-top-0 text-bold w-3">Dirección:</td>
                      <td class="border-top-0"><?php echo $pedido->getDestinatario()->__get("_direccion"); ?></td>
                    </tr>
                    <tr>
                      <td class="border-top-0 text-bold w-3">Referencia:</td>
                      <td class="border-top-0"><?php echo $pedido->getDestinatario()->__get("_referencia"); ?></td>
                    </tr>
                  </tbody>
                </table>
                <!-- <dl class="row">
                    <dt class="col-sm-5 text-right border-top text-bold">Distrito:</dt>
                    <dd class="col-sm-7 margin-bottom-0"><?php echo str_replace('Ã‘', 'Ñ', $pedido->getDestinatario()->__get("_distrito")->__get('_nombre')); ?> , Lima, Perú</dd>
                    <dt class="col-sm-5 text-right border-top text-bold">Dirección:</dt>
                    <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_direccion"); ?></dd>
                    <dt class="col-sm-5 text-right border-top text-bold">Referencia:</dt>
                    <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_referencia"); ?></dd>
                </dl> -->
              </div>
            </div>
            
            <h6><span class="text-bold">Fecha de Entrega: </span><?php echo fecha_hora_sql_html($pedido->getDestinatario()->__get("_fecha_hora")); ?></h6>
            
            <h6>
              <span class="text-bold">Dedicatoria de la tarjeta: </span>
            </h6> 
            <span><?php echo nl2br(str_replace("  ", '&nbsp;&nbsp;', $pedido->getDestinatario()->__get("_dedicatoria"))); ?></span>
            <br><br>
            <h6><span class="sub-titulo-datos-entrega">Datos de Pago:</span></h6>
            <br>
            <h6><span class="text-bold">Comprobante de Pago: </span><?php echo $pedido->getComprobantePago()->__get("_tipo"); ?></h6>
            <?php if ($pedido->getComprobantePago()->__get("_tipo") == "Boleta") { ?>
            <h6><span class="text-bold">DNI: </span><?php echo $pedido->getComprobantePago()->__get("_dni"); ?></h6>
            <h6><span class="text-bold">Nombre: </span><?php echo $pedido->getComprobantePago()->__get("_nombre"); ?></h6>
            <h6><span class="text-bold">Dirección: </span><?php echo $pedido->getComprobantePago()->__get("_direccionb"); ?></h6>
            <?php } else if($pedido->getComprobantePago()->__get("_tipo") == "Factura") { ?>
            <h6><span class="text-bold">Razón social: </span><?php echo $pedido->getComprobantePago()->__get("_razon_social"); ?></h6>
            <h6><span class="text-bold">RUC: </span><?php echo $pedido->getComprobantePago()->__get("_ruc"); ?></h6>
            <h6><span class="text-bold">Dirección: </span><?php echo $pedido->getComprobantePago()->__get("_direccionf"); ?></h6>
            <?php } ?>
            <br>
            <h6><span class="text-bold">Forma de Pago: </span></h6>
            <dl class="row">
                <dt class="col-sm-4 text-center border-top text-bold">
                  <img class="fp_img1 padding-top-1x padding-bottom-1x" src="<?php echo _catalogo_ . $pedido->getMetodoPago()->__get('_imagen'); ?>"/>
                </dt>
                <dd class="col-sm-8 margin-bottom-0">
                  <?php echo str_replace('../', '', nl2br($pedido->getMetodoPago()->__get('_descripcion'))); ?>
                </dd>
            </dl>
          </div>
  
          <?php
          $obj_forma_pago->classFormaPago($pedido->getMetodoPago()->__get('_nombre'), number_format($carrito->getAmount(), 2), number_format($pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio'), 2), $detail);
          ?> 

          <div class="col-xl-12 col-lg-12 padding-top-1x">
            
            <?php echo $obj_forma_pago->generarBoton($pedido->getId()); ?>
            
          </div>

        </div>
      </div>

    </div>

    <!-- FIN PAGINA -->
<?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>


