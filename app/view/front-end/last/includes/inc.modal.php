<!-- INICIO MODAL CONATYINER LOGIN -->
<div class="modal fade modal-login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-400 modal-sm" role="document">
    <div class="modal-content  pages-iframe-total">
        <div class="modal-header position-relative" style="background-image: url(<?php echo _tpl_imgs_ ?>line.jpg);">
          <h3 class="text-white">Ingresar</h3 >
          <button type="button" class="close text-white" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-container text-center">
          <div id="franja-top"></div>
          <div id="popup_acceso" class="popup_acceso">
            <div class="ingreso-con-redes-sociales padding-top-1x"><!--ingreso con redes-->
              <p class="text-muted text-normal">Ingresa tambien con</p>
              <!-- <div class="row">
                <div class="col-6">
                  <a href=""><img src="<?php echo _tpl_imgs_ ?>boton-facebook.png" alt=""></a>
                </div>
                <div class="col-6">
                  <a href=""><img src="<?php echo _tpl_imgs_ ?>boton-google.png" alt=""></a>
                </div>
              </div> -->
              <button type="button" onclick="loginFB(); return false;" class="btn btn-facebook logeo_facebook btn-sm">
                <i class="socicon-facebook"></i>&nbsp;&nbsp; <span class="face">Facebook</span>
              </button>
            </div>
            <hr class="margin-bottom-1x">
            <form method="get" id="login-form">
                <div class="form-group text-left">
                  <label for="email_login">Email: </label>
                  <input class="form-control form-control-sm form-control-rounded" type="email" name="email_login" id="email_login" value="" required="required">
                </div>
                <div class="form-group text-left">
                  <label for="password_login">Password: </label>
                  <input class="form-control form-control-sm form-control-rounded" type="password" name="password_login" id="password_login" value="" required="required">
                </div>
                <input type="hidden" name="action" value="acceso">
                <button type="button" class="btn btn-primary btn-success btn-sm form-control" id="entrar_login" onclick="">Ingresar</button>
            </form>
            <div class="olvidaste-contrasena">
              <a data-toggle="modal" data-target=".modal-olvidaste-password" data-modal="modal-login" class="close-modal-container text-muted">¿Olvidaste tu Contraseña?</a>
            </div>
            
          </div>
        </div>
        <div class="modal-footer text-center">
          <a data-toggle="modal" data-target=".modal-registrarse" data-modal="modal-login" class="close-modal-container text-muted">Soy cliente nuevo, <span class="text-success">Registrarme</span></a><br/>

        </div>
    </div>
  </div>
</div>
<!-- INICIO MODAL CONTAINER LOGIN -->

<!-- INICIO MODAL CONTAINER RECUPERAR PASSWORD -->
<div class="modal fade modal-olvidaste-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-400 modal-sm" role="document">
    <div class="modal-content  pages-iframe-total">
        <div class="modal-header position-relative" style="background-image: url(<?php echo _tpl_imgs_ ?>line.jpg);">
          <h3 class="text-white">Recuperar Contraseña</h3 >
          <button type="button" class="close text-white" aria-label="Close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="modal-container">
            <div id="popup_acceso" class="olvidaste">
              <form method="get" id="olvidaste-password-form" onsubmit="return validate_olvidastePassword(this)">
                  <div class="form-group">
                    <label for="email_olvidaste_password">Email: </label>
                    <input class="form-control" type="text" name="email_olvidaste_password" id="email_olvidaste_password">
                  </div>
                  <div class="form-group text-center">
                    <input type="hidden" name="action" value="sendOlvidastePassword">
                    <input class="btn btn-sm btn-success" type="submit" id="enviar_password" value="Enviar">
                  </div>
              </form>
            </div>
          </div>
        </div>
        
    </div>
  </div>
</div>
<!-- FIN MODAL CONTAINER RECUPERAR PASSWORD -->

<!-- INICIO MODAL CONTAINER REGISTRO RAPIDO -->
<!-- <div class="modal fade modal-login-rapido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-800" role="document">
    <div class="modal-content  pages-iframe-total">
        <div class="modal-header position-relative">
          <button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-container">
          <?php
            $ubigeo = new Ubigeos($msg);    
            $pais = $ubigeo->getPaises();
          ?>
          <div id="franja-top"></div>
          <div id="popup_acceso" class="registro">
              <h2>Tus Datos:</h2>
              <p>Por favor ingresa tus datos 
                <strong>o si ya eres cliente logueate
                  <a data-toggle="modal" data-target=".modal-login" data-modal="modal-login-rapido" class="close-modal-container">aquí</a>
                </strong>
              </p>
              <button type="button" onclick="loginFB(); return false;" class="btn btn-general-button btn-general-button-face logeo_facebook" style="margin-bottom: 4px;margin-bottom: 4px;cursor: pointer;
                background: rgb(52, 95, 157) none repeat scroll 0% 0%;
                width: 100%;border: 0px none;text-align: left;color: white;padding: 4px 12px;text-align: left;border-radius: 4px;
                box-shadow: 3px 4px 0px 0px rgb(9, 55, 121);
                -webkit-transition: all 0.5s ease-out;
                -moz-transition: all 0.5s ease-out;
                -o-transition: all 0.5s ease-out;
                transition: all 0.5s ease-out;">
                <i class="fa fa-facebook"></i><span class="face">Entrar con mi Facebook</span> <i class="fa fa-chevron-right"></i>
              </button>
              <div class="row">
                  <div class="col-md-5"><hr style="border-top: 1px solid #77c3ed;"></div><div class="col-md-2" style="text-align: center;margin-top: 9px;">o</div><div class="col-md-5" style=""><hr style="border-top: 1px solid #77c3ed;"></div>  
              </div>
              <form method="get" id="registro-rapido-form" class="registro-rapido-form" onsubmit="return validate_login_rapido(this,addCuenta)">
                <ul>
                  <li><label>Nombres:</label><b>*</b><br/>
                  <input type="text" name="nombres" id="nombres"></li>
                  <li><label>Apellidos:</label><b>*</b><br/>
                  <input type="text" name="apellidos" id="apellidos"></li>
                  <li><label>Email:</label><b>*</b><br/>
                  <input type="text" name="email" id="email"></li>
                  </ul>
                  <ul>
                  <li><label>Télefono:</label><b>*</b><br/>
                  <input type="text" name="telefono" id="telefono"></li>
                  <li><label>País:</label><b>*</b><br/>
                  <select name="pais" id="pais"><option value="">Elegir País...</option>
                    <?php for($i=0;$i<count($pais);$i++){  ?>
                     <option value="<?php echo $pais[$i]['id_pais']?>" <?php if($pais[$i]['id_pais'] == '167'){ echo 'selected="selected"';}?>  ><?php echo $pais[$i]['nombre']?></option>
                    <?php }?>
                  </select> 
                  </li>
                  <li><label>Ciudad:</label><b>*</b><br/>
                  <input type="text" name="ciudad" id="ciudad"></li>
                </ul>
                <input type="hidden" name="action" value="sendRegistrarse">
                <br class="cleaner"><br/>
                <input type="submit" id="continuar" value="">
              </form>
              <br/>
          </div>
        </div>
    </div>
  </div>
</div> -->
<!-- FIN MODAL CONTAINER REGISTRO RAPIDO -->

<!-- INICIO MODAL CONTAINER REGISTRO -->
<div class="modal fade modal-registrarse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-800" role="document">
    <div class="modal-content  pages-iframe-total">
        <div class="modal-header position-relative" style="background-image: url(<?php echo _tpl_imgs_ ?>line.jpg);">
          <h3 class="text-white">Registro de Cliente</h3 >
          <button type="button" class="close text-white" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php
          $ubigeo = new Ubigeos($msg);    
          $pais = $ubigeo->getPaises();
        ?>
        <div class="modal-body">
          <div class="modal-container">
            <div id="popup_acceso" class="registro">
              <form method="get" id="registro-form" class="registro-form">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-6">
                      <div class="form-group">
                          <label>Nombres:<span class="inf">*</span></label>
                          <input type="text" class="form-control form-control-sm form-control-rounded" name="nombres" id="nombres" required="required">
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                      <div class="form-group">
                          <label>Télefono:<span class="inf">*</span></label>
                          <input type="text" class="form-control form-control-sm form-control-rounded" id="telefono" name="telefono" required="required">
                      </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label>Apellidos:<span class="inf">*</span>&nbsp;</label>
                            <input type="text" class="form-control form-control-sm form-control-rounded" name="apellidos" id="apellidos" required="required">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <div class="form-group">
                          <label>Dirección:<span class="inf">*</span></label>
                          <input type="text" class="form-control form-control-sm form-control-rounded" id="direccion" name="direccion" required="required">
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label>Email:<span class="inf">*</span></label>
                            <input type="email" class="form-control form-control-sm form-control-rounded" id="email" name="email" required="required">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label>Ciudad:<span class="inf">*</span></label>
                            <input type="text" class="form-control form-control-sm form-control-rounded" id="ciudad" name="ciudad" required="required">
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label>Password:<span class="inf">*</span></label>
                            <input type="password" class="form-control form-control-sm form-control-rounded" id="password" name="password" required="required">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label>País:<span class="inf">*</span></label>
                            <select name="pais" id="pais" class="form-control form-control-sm form-control-rounded" required="required">
                              <option value="">Elegir País...</option>
                              <?php for($i=0;$i<count($pais);$i++){  ?>
                                <option value="<?php echo $pais[$i]['id_pais']?>"><?php echo $pais[$i]['nombre']?></option>
                              <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label for="password">Repetir Password:<span class="inf">*</span>&nbsp;&nbsp;</label>
                        <input type="password" class="form-control" id="repeat_password" name="repeat_password">
                    </div>
                </div>
                <div class="text-center margin-top-1x">
                    <!-- <p>addCuenta</p> -->
                    <input type="hidden" name="action" value="sendRegistrarse">
                    <input type="submit" class="button-submit btn btn-sm btn-success" value="Regístrame">
                </div>
              </form>
              <br/>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<!-- FIN MODAL CONTAINER REGISTRO -->

<!-- INICIO MODAL CONTAINER DETALLE CARRITO -->
<div class="modal fade modal-detalle-carrito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-600 modal-lg" role="document">
    <div id="loader-detalle-carrito" class="align-items-center"><img src="<?php echo _tpl_imgs_ ?>loader.gif" alt=""></div>
    <div class="modal-content pages-iframe-total">
        <div class="modal-header position-relative padding-bottom-0">
          <h3>Producto añadido a tu Carrito</h3>
          <button type="button" class="close text-white" aria-label="Close" data-dismiss="modal">
            <span aria-hidden="true"><i class="far fa-times-circle cerrar-modal"></i></span>
          </button>
        </div>
        <div class="modal-container modal-body padding-top-1x">
          
        </div>
    </div>
  </div>
</div>
<!-- FIN MODAL CONTAINER DETALLE CARRITO -->

<!-- INICIO MODAL CONTAINER DIRECCIONADOR -->
<div class="modal fade modal-redireccionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-400" role="document">
    <div class="modal-content  pages-iframe-total">
        <div class="modal-header position-relative" style="background-image: url(<?php echo _tpl_imgs_ ?>line.jpg);">
          <h3 class="text-white titulo-header"></h3 >
          <button type="button" class="close text-white" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-container"></div>
    </div>
  </div>
</div>
<!-- FIN MODAL CONTAINER DIRECCIONADOR -->


<!-- modal -->
<div class="modal fade" id="orderDetails" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalle de Pedido</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        

      </div>
    </div>
  </div>
</div>
