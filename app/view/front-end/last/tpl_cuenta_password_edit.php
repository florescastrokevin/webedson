<body>
    <?php include(_tpl_includes_ . "inc.top.php"); ?>
    <div class="offcanvas-wrapper" style="/*background: url(<?php echo _tpl_resources_?>imgs/bg_page.jpg) fixed repeat #f1f1f1*/">
      <!-- INICIA PAGINA -->
      <?php $ubigeo = new Ubigeos($msg);    
        $pais = $ubigeo->getPaises();
  
        $cliente = $cuenta->getCliente();
        $query = new Consulta("SELECT * FROM clientes WHERE id_cliente = '".$cliente->__get('_id')."'");
        $rowc = $query->VerRegistro(); 
      ?>
      
      <!-- Page Content-->
      <div class="container padding-bottom-3x padding-top-2x mb-2">
        <div class="row">
          <div class="col-lg-4">
            <?php include(_tpl_includes_ . 'inc.menu_cuenta.php');?>
          </div>
          <div class="col-lg-8">
            <div class="contenedor-titulo-menu-usuario">
              <span class="titulo-menu-usuario">Cambiar mi Contraseña</span>
            </div>
            <hr class="margin-bottom-1x">
            <form class="row" method="post" >    
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account-fn">Password Actual</label>
                  <input class="form-control" type="password" name="password_actual" id="password_actual">
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account-fn">Nuevo Password</label>
                  <input class="form-control" type="password" name="password_nuevo" id="password_nuevo">
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account-fn">Repetir Nuevo Password</label>
                  <input class="form-control" type="password" name="password_repeat_nuevo" id="password_repeat_nuevo">
                  <div class="form-control-feedback"></div>
                </div>
              </div>
              <div class="col-12">
                <hr class="mt-2 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                  <div class="custom-control custom-checkbox d-block">
                  </div>
                  <input class="btn btn-success margin-right-none" type="button" onclick="changePassword()" value="Actualizar contraseña">
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