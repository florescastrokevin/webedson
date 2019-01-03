 <?php 
$secciones = new Secciones($cuenta, $pedido);
$cu = new Cuenta($cliente);

if(isset($_GET['custom'])&&!empty($_GET['custom'])){ $_GET['code'] = $_GET['custom']; }
$obj_pedido = new Pedido($_GET['code']);

if( $obj_pedido->getMetodoPago()->__get('_id') == 1 ) { 
    $mensaje_pago = "Gracias por su compra. <br />El Pago via Paypal se realizó con exito "; 
    Pedido::notificarPedido($obj_pedido);
}
if( $obj_pedido->getMetodoPago()->__get('_id') == 2 ) {
    $mensaje_pago = "Gracias por su compra. <br />Pague su compra haciendo una transferencia bancaria o depositando el monto total al siguiente número de cuenta: ";
    Pedido::notificarPedido($obj_pedido);
} 
if( $obj_pedido->getMetodoPago()->__get('_id') == 7 ) {
    $mensaje_pago = "Gracias por su compra. <br />Pague su compra haciendo una transferencia bancaria o depositando el monto total al siguiente número de cuenta: ";
    Pedido::notificarPedido($obj_pedido);
} 
$carrito = $cuenta->getCliente()->getCarrito();
$obj_ocaciones = new Ocasiones();
$ocasiones = $obj_ocaciones->getOcasiones();
$destinatarios = Destinatarios::getTiposDestinatarios();
list($a,$b,$c)= explode("-",substr($pedido->getDestinatario()->__get("_fecha_hora"), 0, 10)); // 2018-02-16
?>
<div class="offcanvas-wrapper offcanvas-pedido-finalizado">
      <!-- Page Title-->
      <!-- <div class="page-title">
        <div class="container">
          <div class="column">
            <h1>Pedido Finalizado</h1>
          </div>
          <div class="column">
            <ul class="breadcrumbs">
              <li><a href="<?php echo _url_web_ ?>">Inicio</a>
              </li>
              <li class="separator">&nbsp;</li>
              <li>Pedido Realizado</li>
            </ul>
          </div>
        </div>
      </div> -->
      <!-- Page Content-->
      <div class="container padding-top-1x">
        <div class="row">
          <div class="col text-center">
            <span class="numero-pedido-finalizado">Pedido Nro. <?php echo $pedido->getId() ?></span>
          </div>
        </div>
      </div>
      <div class="container padding-bottom-1x">
        <div class="card text-center">
          <div class="card-body padding-top-2x">
            <h3 class="card-title  text-bold">¡Pedido realizado con éxito!</h3>
            <p class="card-text">Gracias por su compra.</p>
            <p class="card-text">Pague su compra haciendo una transferencia bancaria o depositando el monto total al siguiente número de cuenta:</p>
            <br>
            <dl class="row">
              <dt class="col-sm-6 text-center border-top text-bold">
                <img class="fp_img1" src="<?php echo _catalogo_ . $pedido->getMetodoPago()->__get('_imagen'); ?>"/>
              </dt>
              <dd class="col-sm-6 margin-bottom-0 text-left">
                <?php echo str_replace('../', '', nl2br($pedido->getMetodoPago()->__get('_descripcion'))); ?>
              </dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col">
            <hr>
            <div class="card margin-bottom-2x">
              <div class="card-body">
                  <h3 class="card-title text-bold text-left">Fechas especiales:</h3>
                  <div class="padding-bottom-1x mb-2">

                    <form action="" method="post" name="form-fechas-especiales" id="form-fechas-especiales" enctype="multipart/form-data" class="form-inline">
                    <div class="row container-fechas-especiales">
                      
                      <div class="col-md-12">
                          <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $cuenta->getCliente()->__get('_id') ?>">
                          <input type="hidden" name="id_destinatario" id="id_destinatario" value="<?php echo $_SESSION['destinatario']['id'] ?>">
                          <input type="hidden" name="fecha_especial" id="fecha_especial" value="<?php echo $a.'/'.$b.'/'.$c ?>">
                              <br>
                              <p>Sr(a): <b><?php echo ucwords ($cuenta->getCliente()->__get('_usuario')) ?></b> guarde esta fecha <b><?php echo fecha_long(substr($pedido->getDestinatario()->__get("_fecha_hora"), 0, 10)) ?></b> como una fecha especial y reciba <b>Promociones un día como hoy</b>. Además puede agregar otras fechas especiales para recibir más ofertas.</p>
                      </div>
                      <div class="col-md-12 padding-top-1x">
                        <div class="row justify-content-md-center">
                            <div class="col-md-6">
                                <div class="form-group row">
                                  <label class="col-4 col-form-label" for="text-input">Tipo de Destinatario:</label>
                                  <div class="col-8">
                                    <select name="id_tipo_destinatario" id="id_tipo_destinatario" class="form-control">
                                      <option value="">Elegir un tipo de destinatario</option>
                                      <?php foreach ($destinatarios as $destinatario){?>
                                          <option value="<?php echo $destinatario['id'];?>"><?php echo ucwords($destinatario['nombre']) ?></option>   
                                      <?php } ?> 
                                    </select>
                                    <div class="form-control-feedback"></div>
                                  </div>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                  <label class="col-4 col-form-label" for="text-input">Ocación:</label>
                                  <div class="col-8">
                                    <select name="id_ocasion" id="id_ocasion" class="form-control">
                                      <option value="">Elegir una ocasión</option>
                                      <?php foreach ($ocasiones as $ocasion){?>
                                          <option value="<?php echo $ocasion['id'];?>"><?php echo ucwords($ocasion['nombre']) ?></option>   
                                      <?php } ?>
                                    </select>
                                    <div class="form-control-feedback"></div>
                                  </div>
                                </div>   
                            </div>
                        </div>
                      </div>
                      
                      <div class="col-md-12 text-center">
                          <button onclick="guardarFechaEspecialFinalizado()" type="button" class="btn btn-success">Guardar Fecha Especial</button>
                      </div>
                    </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


 <!--      <div class="container">
   <div class="row">
     <div class="col">
       <p class="numero-pedido-finalizado">Pedido Nro. <?php echo $pedido->getId() ?></p>
     </div>
   </div>
 </div>
 <div class="container padding-bottom-3x mb-2">
   <div class="row">
     <div class="col-xl-6 col-lg-6">
     <h4>Pedido:</h4>
     <p class="text-uppercase text-muted" style="letter-spacing: normal;">A continuación le detallamos su pedido.</p>
     <?php //include(_tpl_includes_ . "inc.cesta.php"); ?>     
   
     </div>
 
     <div class="col-xl-6 col-lg-6">
       <h4>Datos de Entrega: </h4>
       <hr>
       <br>
       <h6><span class=  text-bold">Forma de Envio:</span> DELIVERY</h6>
       <h6><span class=  text-bold">Datos del Destinatario:</span></h6>
       <br>
       <div class="row">
         <div class="col-md-6">
           <dl class="row">
               <dt class="col-sm-5 text-right border-top text-bold">Nombres:</dt>
               <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_nombre"); ?></dd>
               <dt class="col-sm-5 text-right border-top text-bold">Apellidos:</dt>
               <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_apellidos"); ?></dd>
               <dt class="col-sm-5 text-right border-top text-bold">Teléfono:</dt>
               <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_telefono"); ?></dd>
           </dl>
         </div>
         <div class="col-md-6">
           <dl class="row">
               <dt class="col-sm-5 text-right border-top text-bold">Distrito:</dt>
               <dd class="col-sm-7 margin-bottom-0"><?php echo str_replace('Ã‘', 'Ñ', $pedido->getDestinatario()->__get("_distrito")->__get('_nombre')); ?> , Lima, Perú</dd>
               <dt class="col-sm-5 text-right border-top text-bold">Dirección:</dt>
               <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_direccion"); ?></dd>
               <dt class="col-sm-5 text-right border-top text-bold">Referencia:</dt>
               <dd class="col-sm-7 margin-bottom-0"><?php echo $pedido->getDestinatario()->__get("_referencia"); ?></dd>
           </dl>
         </div>
       </div>
       
       <h6><span class=  text-bold">Fecha de Entrega: </span><?php echo fecha_hora_sql_html($pedido->getDestinatario()->__get("_fecha_hora")); ?></h6>
       
       <h6><span class=  text-bold">Dedicatoria de la tarjeta: </span></h6> 
       <span><?php echo nl2br(str_replace("  ", '&nbsp;&nbsp;', $pedido->getDestinatario()->__get("_dedicatoria"))); ?></span>
       <br><br>
       <h4>Datos de Pago: </h4>
       <hr>
       <br>
       <h6><span class=  text-bold">Comprobante de Pago: </span><?php echo $pedido->getComprobantePago()->__get("_tipo"); ?></h6>
       <?php if ($pedido->getComprobantePago()->__get("_tipo") == "Boleta") { ?>
       <h6><span class=  text-bold">DNI: </span><?php echo $pedido->getComprobantePago()->__get("_dni"); ?></h6>
       <h6><span class=  text-bold">Nombre: </span><?php echo $pedido->getComprobantePago()->__get("_nombre"); ?></h6>
       <h6><span class=  text-bold">Dirección: </span><?php echo $pedido->getComprobantePago()->__get("_direccionb"); ?></h6>
       <?php } else { ?>
       <h6><span class=  text-bold">Razón social: </span><?php echo $pedido->getComprobantePago()->__get("_razon_social"); ?></h6>
       <h6><span class=  text-bold">RUC: </span><?php echo $pedido->getComprobantePago()->__get("_ruc"); ?></h6>
       <h6><span class=  text-bold">Dirección: </span><?php echo $pedido->getComprobantePago()->__get("_direccionf"); ?></h6>
       <?php } ?>
       <br>
       <h6><span class=  text-bold">Forma de Pago: </span></h6>
       <dl class="row">
           <dt class="col-sm-4 text-center border-top text-bold padding-top-1x padding-bottom-1x">
             <img class="fp_img1" src="<?php echo _catalogo_ . $pedido->getMetodoPago()->__get('_imagen'); ?>"/>
           </dt>
           <dd class="col-sm-8 margin-bottom-0">
             <?php echo str_replace('../', '', nl2br($pedido->getMetodoPago()->__get('_descripcion'))); ?>
           </dd>
       </dl>
     </div>
   </div>
 </div>
  -->

      

      

    <!-- FIN PAGINA -->
<?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>


<?php
/* OJO ESTE METODO ES PARA ELIMINAR EL CARRITO POR LO QUE DEBERIA ESTAR EN INDEX, POR EL MOMENTO SE QUEDA EN LA VISTA PERO DEBE CAMBIARSE DE LUGAR */
$cuenta->getCliente()->getCarrito()->reset(TRUE);
unset($_SESSION['donregalo_pedido']);  
?>