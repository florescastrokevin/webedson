
      <?php $ubigeo = new Ubigeos($msg);    
        $pais = $ubigeo->getPaises();
  
        $cliente = $cuenta->getCliente();
        $query = new Consulta("SELECT * FROM clientes WHERE id_cliente = '".$cliente->__get('_id')."'");
        $rowc = $query->VerRegistro(); 
      ?>
  <div class="offcanvas-wrapper">

      <div class="container padding-bottom-3x padding-top-2x mb-2">
        <div class="row">
          <div class="col-lg-4">
            <?php include(_tpl_includes_ . 'inc.menu_cuenta.php');?>
          </div>
          <div class="col-lg-8">
            <div class="contenedor-titulo-menu-usuario">
              <span class="titulo-menu-usuario">Mis Datos Personales</span>
            </div>
            <hr class="margin-bottom-1x">
            <div class="padding-top-2x mt-2 hidden-lg-up"></div>
            <form class="row" method="post" name="registro-form" id="registro-form">    
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nombre">Nombres</label>
                  <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $rowc['nombre_cliente']?>">
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="apellidos">Apellidos</label>
                  <input class="form-control" type="text" name="apellidos" id="apellidos" value="<?php echo $rowc['apellidos_cliente']?>">
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input class="form-control" type="email" name="email" id="email" value="<?php echo $rowc['email_cliente']?>" disabled>
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="phone">Teléfono</label>
                  <input class="form-control" type="text" name="phone" id="phone" value="<?php echo $rowc['telefono_cliente']?>">
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="direccion">Dirección</label>
                  <input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $rowc['direccion_cliente']?>">
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="ciudad">Ciudad</label>
                  <input class="form-control" type="text" name="ciudad" id="ciudad" value="<?php echo $rowc['ciudad_cliente']?>">
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="pais">País</label>
                  <select class="form-control" name="pais" id="pais">
                     <option value="">Elegir País...</option>
                   <?php for($i=0;$i<count($pais);$i++){  ?>
                     <option <?php echo ($rowc['pais_cliente']==$pais[$i]['id_pais'])? 'selected="selected"' : ''?>  value="<?php echo $pais[$i]['id_pais']?>"><?php echo $pais[$i]['nombre']?></option>
                   <?php }?>
                  </select> 
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              
              <div class="col-12">
                <hr class="mt-2 mb-3">
                <div class="text-center">
                  <button class="btn btn-success" type="button" name="button" onclick="editAcountData()">Actualizar Perfil</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    <!-- FIN PAGINA -->
<?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>