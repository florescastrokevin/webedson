    <?php $ubigeo = new Ubigeos($msg);    
      $pais = $ubigeo->getPaises();

      $cliente = $cuenta->getCliente();
      $query = new Consulta("SELECT * FROM clientes WHERE id_cliente = '".$cliente->__get('_id')."'");
      $rowc = $query->VerRegistro(); 

      $destinatario = $obj_pedido->getDestinatario();
      if (is_object($destinatario->__get('_distrito'))) {
          $tarifa = $destinatario->__get('_distrito')->__get('_tarifa_envio');
          $nombreDIS = str_replace('Ã‘', 'Ñ', $destinatario->__get('_distrito')->__get('_nombre'));
          $ubigeos = new Ubigeos();
          $ubigeos->set_ubigeo($destinatario->__get('_distrito')->__get('_id'));
      } else {
          $tarifa = '0.00';
          $nombreDIS = 'Por Calcular';
      }
    ?>
  
    <div class="offcanvas-wrapper">
      <!-- Page Content-->
      <div class="container padding-bottom-3x padding-top-2x mb-2">
        <div class="row">
          <div class="col-lg-4">
            <?php include(_tpl_includes_ . 'inc.menu_cuenta.php');?>
          </div>
          <div class="col-lg-8">
            <div class="padding-top-2x mt-2 hidden-lg-up"></div>
            <div class="table-responsive">
                <h1>Pedido Nº <?php echo $obj_pedido->getId() ?></h1>
                <div id="fecha_pedido"><b>Fecha: </b><?php echo fecha_hora_sql_html($obj_pedido->getFecha()) ?></div>
              </div>  
              <?php $query_productos = new Consulta("SELECT * FROM pedidos_productos WHERE id_pedido='" . $obj_pedido->getId() . "'");
              $subtotal = 0;
              if ($query_productos->NumeroRegistros() > 0) {
              ?>
              <table class="table table-hover" id="table">
                <thead id="tabla_top">
                    <tr>
                        <td>Producto</td>
                        <td>Pre. Unit.</td>
                        <td class="text-center">Cant</td>
                        <td>Subtotal</td>
                    </tr>
                </thead>   
                <tbody id="tabla_cont">
                    <?php  
                    while ($row = $query_productos->VerRegistro()) {  
                    $prod = new Producto($row['id_producto']);
                    $precio = $prod->__get("_precio_producto");
                    $imagenes = $prod->__get("_imagenes");
                    $img_thumb = (file_exists(_link_file_ . $imagenes[0]['thumbnail'])) ? $imagenes[0]['thumbnail'] : 'not_image_disponible_thumb.jpg';
                    ?>
                    <tr>
                      <td class="alignLeft">
                        <img class="img" src="<?php echo _catalogo_ . $img_thumb ?>"> &nbsp; <span class="text-bold"><?php echo $prod->__get("_nombre") ?></span>
                        <?php 
                        $query_prod_cmp = new Consulta("SELECT * FROM pedidos_productos_opciones WHERE id_pedido_producto = '" . $row['id_pedido_producto'] . "'");
                        if ($query_prod_cmp->NumeroRegistros() > 0): ?>
                        <br>
                        <ul>
                            <?php while ($rowcmp = $query_prod_cmp->VerRegistro()) { 
                            $prod = new Producto( $rowcmp['producto_opcion'] );
                            $imgsc = $prod->__get("_imagenes");
                            $preciocmp += $prod->__get("_precio_producto") * $cantidad; ?>   
                            <li class="list-icon">
                                <i class="icon-plus text-success text-bold"></i>&nbsp;<img src="<?php echo _catalogo_ . $imgsc[0]['middle']?>" class="img" style="max-width: 38px">&nbsp; <?php echo $cantidad;?> <?php echo $prod->__get("_nombre")?>
                            </li>
                            <?php } ?>
                        </ul> 
                        <?php endif ?>
                      </td>
                      <td class="alignLeft text-muted">$<?php echo number_format($precio + $preciocmp, 2) ?></td>
                      <td class="alignLeft text-bold text-center"><?php echo $row['cantidad_pedido_producto'] ?></td>
                      <td class="alignLeft text-bold">$<?php echo number_format(($precio + $preciocmp) * $row['cantidad_pedido_producto'], 2) ?></td>
                    </tr>
                    <?php 
                    $subtotal += ($precio + $preciocmp) * $row['cantidad_pedido_producto'];
                    } ?>
                </tbody>

                <tfoot>
                  <tr>
                    <td colspan="3" class="text-right">SubTotal:</td>
                    <td class="text-right">$<?php echo number_format($subtotal, 2) ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="text-right">Costo por envío (<?php echo $nombreDIS; ?>):</td>
                    <td class="text-right">$<?php echo number_format($tarifa,2)?></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="text-right">Total ($):</td>
                    <td class="text-right">$<?php echo number_format(($subtotal + $tarifa),2);?></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="text-right">Total (S/.):</td>
                    <td class="text-right text-bold">S/.<?php echo number_format((($subtotal + $tarifa )*TIPO_CAMBIO ),2);?></td>
                  </tr>
              </tfoot>

              </table>

              <?php          
                  while ($row = $query_productos->VerRegistro()) { 

                      $prod = new Producto($row['id_producto']);
                      $precio = $prod->__get("_precio_producto");
                      $imagenes = $prod->__get("_imagenes");

                      $preciocmp = 0;

                      $img_thumb = (file_exists(_link_file_ . $imagenes[0]['thumbnail'])) ? $imagenes[0]['thumbnail'] : 'not_image_disponible_thumb.jpg';
                      ?>

                      <li>
                          <ul>
                              <li class="td1_c alignLeft">
                                  <div class="img_cesta_c">
                                      &nbsp;<img alt="" src="<?php echo _catalogo_ . $img_thumb ?>" />
                                  </div>
                                  <div class="info_cesta_c">
                                      <div class="nameCar"><?php echo $prod->__get("_nombre") ?></div>

                                      <?php
                                      $query_productos_cmp = new Consulta("SELECT * FROM pedidos_productos_opciones WHERE id_pedido_producto = '" . $row['id_pedido_producto'] . "'");

                                      if ($query_productos_cmp->NumeroRegistros() > 0) {
                                          ?>
                                          <div class="prod_agregado">
                                              <ul>
                                                  <?php
                                                  while ($rowcmp = $query_productos_cmp->VerRegistro()) {

                                                      $prodcmp = new Producto($rowcmp['producto_opcion']);
                                                      $imgcmp = $prodcmp->__get("_imagenes");

                                                      $preciocmp += $prodcmp->__get("_precio_producto") * $rowcmp['producto_opcion_valor'];

                                                      $img_thumb_cmp = (file_exists(_link_file_ . $imgcmp[0]['thumbnail'])) ? $imgcmp[0]['thumbnail'] : 'not_image_disponible_thumb.jpg';
                                                      ?>
                                                      <li>
                                                          <div class="wrap_agregado">
                                                              &nbsp;<img src="<?php echo _catalogo_ . $img_thumb_cmp ?>" alt="" />
                                                          </div>
                                                          <span><?php echo $rowcmp['producto_opcion_valor']; ?> <?php echo $prodcmp->__get("_nombre") ?></span>
                                                      </li>
                                                  <?php } ?>
                                              </ul>
                                          </div>
                                          <?php
                                      }
                                      ?>
                                  </div>
                              </li>
                              <li class="td2_c">
                                  <span class="precio_prod">$<?php echo number_format($precio + $preciocmp, 2) ?></span>
                              </li>
                              <li class="td3_c">
                                  <span><?php echo $row['cantidad_pedido_producto'] ?></span>
                              </li>
                              <li class="td4_c">


                                  <span class="subtotal">$<?php echo number_format(($precio + $preciocmp) * $row['cantidad_pedido_producto'], 2) ?></span>
                              </li>
                          </ul>
                      </li>

                      <?php
                      $subtotal += ($precio + $preciocmp) * $row['cantidad_pedido_producto'];
                  }
              }
              ?>
              <?php //echo var_dump($obj_pedido) ?>
            </div>
            <hr>
            <div class="text-right"><a class="btn btn-link-primary margin-bottom-none" href="#"><i class="icon-download"></i>&nbsp;Order Details</a></div>
          </div>
        </div>
      </div>
   

    <!-- FIN PAGINA -->
<?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>