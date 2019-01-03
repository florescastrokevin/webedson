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
<div class="offcanvas-wrapper">

      <!-- Page Content-->
      <form action="<?php echo _url_web_."seccion/pedido/confirmacion"; ?>" method="post" id="compra2" onsubmit="return validate_pago(this);">
      <input type="hidden" name="state" value="pago">
        <div class="container padding-bottom-3x mb-2 padding-top-1x">
          <div class="row">
            <!-- Checkout Adress-->
            <div class="col-xl-10">
              <div class="checkout-steps">
                <a><span class="steps-d">3. Confirmar Pedido</span><span class="steps-m">3</span></a>
                <a class="active"><span class="angle"></span>2. Datos de Pago</a>
                <a class="completed" href="<?php echo _url_web_ ?>seccion/pedido"><span class="angle"></span><span class="steps-d">1. Datos de Entrega</span><span class="steps-m">1</span></a>
              </div>
            </div>
            
            <div class="col-xl-6 col-lg-6">
              <h4>Forma de Pago: </h4>
              <h3 class="widget-title">Elige la forma de pago</h3>

              <?php foreach ($formasPago as $formaPago): ?>
              <input type="hidden" value="<?php echo $formaPago['nombre'] ?>" id="nombre_met_envio_<?php echo $formaPago['id'] ?>" name="nombre_met_<?php echo $formaPago['id'] ?>">
              <div class="custom-control custom-radio custom-radio-card">
                <input class="custom-control-input" type="radio" name="pago" id="envio_<?php echo $formaPago['id'] ?>" <?php if ($_SESSION['pago']['id'] == $formaPago['id']) echo 'checked="checked"'; ?> value="<?php echo $formaPago['id'] ?>"  >
                <label class="custom-control-label" for="envio_<?php echo $formaPago['id'] ?>">
              </div>
              <div class="forma-de-pago-card <?php if ($_SESSION['pago']['id'] == $formaPago['id']) echo 'activo-defecto'; ?>"> 
                <label for="envio_<?php echo $formaPago['id'] ?>"><img alt="" class="fp_img1" src="<?php echo _tpl_imgs_ . $formaPago['icono'] ?>"></label>
              </div>
              <?php endforeach ?>

            </div>

            <div class="col-xl-6 col-lg-6">
              <h4>Comprobante de Pago: </h4>
              <h3 class="widget-title">Elige el tipo de Comprobante de Pago</h3>
              <div class="row">
                <div class="col-sm-8">
                  <div class="form-group">
                    <label for="checkout-fn">Comprobante: <span class="text-danger">*</span></label>
                    <select class="form-control" name="comprobante" id="comprobante">
                        <option value="Ninguno" <?php if ($_SESSION['pago']['tipo'] == 'Ninguno') echo 'selected="selected"'; ?>>NINGUNO</option>
                        <option value="Boleta" <?php if ($_SESSION['pago']['tipo'] == 'Boleta') echo 'selected="selected"'; ?>>BOLETA</option>
                        <option value="Factura" <?php if ($_SESSION['pago']['tipo'] == 'Factura') echo 'selected="selected"'; ?>>FACTURA</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="caja1">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="checkout-fn">DNI: </label>
                      <input type="text" class="form-control" name="dni" id="dni" value="<?php echo $_SESSION['pago']['dni_boleta'] ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="checkout-fn">Nombre: <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $_SESSION['pago']['nombre_boleta'] ?>">
                      <div class="form-control-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="checkout-fn">Dirección: </label>
                      <input type="text" class="form-control" name="direccionb" id="direccionb" value="<?php echo $_SESSION['pago']['direccion_boleta'] ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div id="caja2">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="checkout-fn">Razón Social: <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="razonsocial" id="razonsocial" value="<?php echo $_SESSION['pago']['razon_social'] ?>">
                      <div class="form-control-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="checkout-fn">Ruc: <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="ruc" id="ruc" maxlength="11" value="<?php echo $_SESSION['pago']['ruc'] ?>">
                      <div class="form-control-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="checkout-fn">Dirección: <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="direccionf" id="direccionf" value="<?php echo $_SESSION['pago']['direccionf'] ?>">
                      <div class="form-control-feedback"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="col-xl-12 col-lg-12 padding-top-1x">
              <div class="row">
                <div class="col-6 text-right">
                  <a class="btn btn-outline-secondary remove-tablet" href="<?php echo _url_web_ ?>seccion/cesta"><i class="icon-arrow-left"></i><span class="">&nbsp;Regresar al Carrito</span></a>
                </div>
                <div class="col-md-6 text-continuar">
                  <button type="submit" class="btn btn-verde-donregalo" id="btn_continuar"><span class="">Seguir&nbsp;</span><i class="icon-arrow-right"></i></button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </form>

    </div>
    
    <!-- FIN PAGINA -->
<?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>