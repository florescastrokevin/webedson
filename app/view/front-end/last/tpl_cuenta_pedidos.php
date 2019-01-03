    <?php 
      $ubigeo = new Ubigeos($msg);    
      $pais = $ubigeo->getPaises();

      $cliente = $cuenta->getCliente();
      $query = new Consulta("SELECT * FROM clientes WHERE id_cliente = '".$cliente->__get('_id')."'");
      $rowc = $query->VerRegistro(); 
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
              <table class="table table-hover margin-bottom-none">
                <thead>
                  <tr>
                    <th># Pedido</th>
                    <th>Fecha de Envío</th>
                    <th>Estado</th>
                    <th>Monto</th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $obp = new Pedidos();
                $pedidos = $obp->getNotificarPedidosXCliente($cuenta->getCliente()->__get('_id'));

                if( count($pedidos)  > 0 ){  
                   foreach( $pedidos as $row){ ?>

                  <tr>
                    <td><a class="text-bold navi-link" href="#">Nº&nbsp;<?php echo $row['id']?></a></td>
                    <td><?php echo $row['fecha']?></td>
                    <td><span class="text-success"><?php echo $row['estado']?></span></td>
                    <td><span class="text-medium">$<?php echo number_format($obp->PedidosMonto($row['id']),2)?></span></td>
                    <td class="text-center columna-opciones">
                      <a href="seccion/cuenta/pedido-detalle/<?php echo $row['id'] ?>" class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver Detalle"><i class="icon-search"></i></a>
                      <a href="#" onclick="verFotoPedido('<?php echo _imgs_.'foto_recibir_regalo'?>')" class="text-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Fotografía"><i class="icon-camera"></i></a>
                    </td>
                  </tr>

                   <?php }
                }else{
                  echo '<p>Aún no tiene pedidos pagados</p>';
                }
                ?>
                </tbody>
              </table>
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