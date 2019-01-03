<?php //include(_tpl_includes_."inc.header.php");

$carrito = $cuenta->getCliente()->getCarrito();
$content = $carrito->getContent();
$view = 'cesta';
$f = ($view=='cesta')?'':'_c';
            
$ubigeo = new Ubigeos();
$distritos = $ubigeo->getDistritosConCobertura(1401); 
if(isset($_POST['distrito'])) $_SESSION['envio']['distrito'] = $_POST['distrito'];
?>

<div class="offcanvas-wrapper">

  <form name="envio" action="<?php echo _url_web_."seccion/pedido/pago";?>" method="post" id="compra1" onsubmit=" return validate_entrega(this);">
    <input type="hidden" name="mapa_latitud" id="mapa_latitud" value="-12.1028477"> 
    <input type="hidden" name="mapa_lontitud" id="mapa_lontitud" value="-77.0373537,15"> 
    <input type="hidden" name="state" value="envio">
    <div class="container padding-bottom-3x mb-2 padding-top-1x">
      <div class="row">
        <!-- Checkout Adress-->
        <div class="col-xl-10">
          <div class="checkout-steps">
            <a><span class="steps-d">3. Confirmar Pedido</span><span class="steps-m">3</span></a>
            <a><span class="angle"></span><span class="steps-d">2. Datos de Pago</span><span class="steps-m">2</span></a>
            <a class="active"><span class="angle"></span>1. Datos de Entrega</a>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <h4>Datos del Destinatario: </h4>
          <h3 class="widget-title">Ingrese los datos de quien recibirá el regalo.</h3>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="destinatario_nombre">Nombres: <span class="text-danger">*</span></label>
                <input class="form-control form-control-rounded form-control-sm" type="text" name="nombre" id="destinatario_nombre" value="<?php echo $_SESSION['envio']['nombre'];?>">
                <div class="form-control-feedback"></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="destinatario_apellidos">Apellidos: </label>
                <input class="form-control form-control-rounded form-control-sm" type="text" name="apellidos" id="destinatario_apellidos" value="<?php echo $_SESSION['envio']['apellidos'];?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="destinatario_telefono">Teléfono: <span class="text-danger">*</span><br><span class="text-muted">(Solo se llamará en casos de emergencia)</span></label>
                <input class="form-control form-control-rounded form-control-sm" type="text" name="telefono" id="destinatario_telefono" value="<?php echo $_SESSION['envio']['telefono'];?>">
              </div>
            </div>
          </div>

          <h4>Fecha y hora de entrega: </h4>
          <h3 class="widget-title">Ingrese la fecha y hora que desea que llegue su regalo</h3>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="datepicker">Fecha : <span class="text-danger">*</span></label>
                <input class="form-control form-control-rounded form-control-sm" type="date" name="fecha" id="datepicker" value="<?php echo $_SESSION['envio']['fecha'];?>">
                <div class="form-control-feedback"></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="destinatario_hora">Hora : <span class="text-danger">*</span></label>
                <select name="hora" id="destinatario_hora" class="form-control form-control-rounded form-control-sm" placeholder="--:--">
                  <?php $hora = $_SESSION['envio']['hora'] ?>
                  <option value="">Seleccione una hora..</option>
                  <option value="07:00:00"<?php echo ($hora=='07:00:00') ? 'selected' : '' ; ?>>07:00 AM - 08:00 AM</option>
                  <option value="08:00:00"<?php echo ($hora=='08:00:00') ? 'selected' : '' ; ?>>08:00 AM - 09:00 AM</option>
                  <option value="09:00:00"<?php echo ($hora=='09:00:00') ? 'selected' : '' ; ?>>09:00 AM - 10:00 AM</option>
                  <option value="10:00:00"<?php echo ($hora=='10:00:00') ? 'selected' : '' ; ?>>10:00 AM - 11:00 AM</option>
                  <option value="11:00:00"<?php echo ($hora=='11:00:00') ? 'selected' : '' ; ?>>11:00 AM - 12:00 AM</option>
                  <option value="12:00:00"<?php echo ($hora=='12:00:00') ? 'selected' : '' ; ?>>12:00 AM - 01:00 PM</option>
                  <option value="13:30:00"<?php echo ($hora=='13:30:00') ? 'selected' : '' ; ?>>01:00 PM - 02:00 PM</option>
                  <option value="14:00:00"<?php echo ($hora=='14:00:00') ? 'selected' : '' ; ?>>02:00 PM - 03:00 PM</option>
                  <option value="15:00:00"<?php echo ($hora=='15:00:00') ? 'selected' : '' ; ?>>03:00 PM - 04:00 PM</option>
                  <option value="16:00:00"<?php echo ($hora=='16:00:00') ? 'selected' : '' ; ?>>04:00 PM - 05:00 PM</option>
                  <option value="17:00:00"<?php echo ($hora=='17:00:00') ? 'selected' : '' ; ?>>05:00 PM - 06:00 PM</option>
                  <option value="18:00:00"<?php echo ($hora=='18:00:00') ? 'selected' : '' ; ?>>06:00 PM - 07:00 PM</option>
                  <option value="19:00:00"<?php echo ($hora=='19:00:00') ? 'selected' : '' ; ?>>07:00 PM - 08:00 PM</option>
                </select>
                <div class="form-control-feedback"></div>
              </div>
            </div>
            <!-- <div class="col-sm-12">
              <p class="text-warning">
                <span class="text-bold">Nota:</span> La hora que nos indica en este registro es tomada como referencia, la movilidad puede llegar 1/2 hora más temprano a 1/2 hora después de la hora que nos indique. 
              </p>
            </div> -->
          </div>
        </div>

        <div class="col-xl-6 col-lg-6">
          <h4>Dirección del destinatario: </h4>
          <h3 class="widget-title">Ingrese la dirección donde llegará el regalo</h3>
          <div class="row">
            <!-- <div class="col-sm-12">
              <p class="text-warning">
                <span class="text-bold">Nota:</span> Indicar correctamente su dirección y distrito para evitar que no se pueda realizar la entrega. 
              </p>
            </div> -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="estinatario_distrito">Distrito: <span class="text-danger">*</span></label>
                <select class="form-control form-control-rounded form-control-sm distritoMapa" id="destinatario_distrito" name="distrito">
                  <option value="">Elegir distrito ..</option>
                  <?php foreach ($distritos as $distrito): ?>
                    <option <?php if( $_SESSION['envio']['distrito'] == $distrito['id'] ){echo 'selected="selected"';}?>   value="<?php echo $distrito['id'];?>"><?php echo str_replace('Ã‘','Ñ',$distrito['nombre']);?></option>
                  <?php endforeach ?>
                </select>
                <div class="form-control-feedback"></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Dirección: <span class="text-danger">*</span></label>
                <input class="form-control form-control-rounded form-control-sm" type="text" name="direccion" id="destinatario_direccion" value="<?php echo $_SESSION['envio']['direccion'];?>">
                <div class="form-control-feedback"></div>
              </div>
            </div>
          </div>
          
          <div class="row justify-content-sm-center">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="destinatario_referencia">Referencia: <span class="text-danger">*</span></label>
                <textarea class="form-control form-control-rounded form-control-sm" type="text" name="referencia" id="destinatario_referencia"><?php echo $_SESSION['envio']['referencia'];?></textarea>
              </div>
            </div>
            <div class="col-sm-12 text-center">
              <a onclick="showMapa()" class="toggle-mapa btn btn-success btn-outline-success"><i class="fas fa-map-marker-alt"></i> Dejanos tu ubicación exacta</a>
            </div>
            <div class="col-sm-12">
              <div class="container-envio-mapa">
                
              </div>
            </div>
          </div>
          <br>
          <h4>Dedicatoria de la tarjeta: </h4>

          <h3 class="widget-title">Ingrese un texto para la dedicatoria del regalo, recuerda colocar tus iniciales a la parte final de la dedicatoria</h3>
          <div class="row justify-content-sm-center">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="destinatario_dedicatoria">Dedicatoria: <span class="text-danger">*</span></label>
                <textarea class="form-control form-control-rounded form-control-sm" rows="5" name="dedicatoria" maxlength="281" id="destinatario_dedicatoria"><?php echo $_SESSION['envio']['dedicatoria'];?></textarea>
                <p class="notaobs">Contador de caracteres (máximo 281)</p>
                <a onclick="verSugerencias()" class="cursor-pointer text-bold text-success">¿Sin inspiración? Prueba nuestras sugerencias.</a>
              </div>
            </div>
            <div class="col-sm-12">
              <p onclick="verTarjeta()">(posiblemente no va)<i class="icon-image"></i></p>
            </div>
          </div>
        </div>
        <div class="col-xl-12 col-lg-12 padding-top-1x">
          <div class="row">
            <div class="col-6 text-right">
              <a class="btn btn-outline-secondary remove-tablet" href="<?php echo _url_web_ ?>seccion/cesta"><i class="icon-arrow-left"></i><span class="">&nbsp;Regresar al Carrito</span></a>
            </div>
            <div class="col-md-6 text-continuar">
              <button type="submit" class="btn btn-verde-donregalo" id="btn_continuar"><span class="">Siguiente&nbsp;</span><i class="icon-arrow-right"></i></button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </form>


    <!-- FIN PAGINA -->
  <?php include(_tpl_includes_ . "inc.bottom.php"); ?>
</div>

<!-- INICIO BLOQUE MODAL MOSTRAR SUGERENCIA -->
<div class="modal fade" id="verSugerencias" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">SUGERENCIAS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col">
              <div class="accordion" id="accordion1" role="tablist">
                <div class="card">
                  <div class="card-header" role="tab">
                    <h6><a href="#collapseOne" data-toggle="collapse" class="collapsed" aria-expanded="false">Aniversario</a></h6>
                  </div>
                  <div class="collapse" id="collapseOne" data-parent="#accordion1" role="tabpanel" style="">
                    <div class="card-body">
                      <div class="border">
                        <a onclick="fillMensaje(this)">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo error dolorem et magnam eius, illum dignissimos odio, iusto aliquam commodi saepe laborum amet illo enim. Enim animi, ad adipisci tenetur.</a>
                      </div>
                      <br>
                      <div class="border">
                        <a onclick="fillMensaje(this)">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non assumenda, impedit dolor fugiat molestiae ex recusandae officia facere maiores excepturi reprehenderit illo odit, ea, rem quam accusantium obcaecati sit? Cum!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio recusandae debitis ducimus doloremque iure ullam iste sunt, dolorum harum id mollitia incidunt architecto corrupti, assumenda dignissimos ipsam vel, fuga a!</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" role="tab">
                    <h6><a class="collapsed" href="#collapseTwo" data-toggle="collapse">Agradecimiento</a></h6>
                  </div>
                  <div class="collapse" id="collapseTwo" data-parent="#accordion1" role="tabpanel">
                    <div class="card-body">
                      <div class="border">
                        <a onclick="fillMensaje(this)">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo error dolorem et magnam eius, illum dignissimos odio, iusto aliquam commodi saepe laborum amet illo enim. Enim animi, ad adipisci tenetur.</a>
                      </div>
                      <br>
                      <div class="border">
                        <a onclick="fillMensaje(this)">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non assumenda, impedit dolor fugiat molestiae ex recusandae officia facere maiores excepturi reprehenderit illo odit, ea, rem quam accusantium obcaecati sit? Cum!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio recusandae debitis ducimus doloremque iure ullam iste sunt, dolorum harum id mollitia incidunt architecto corrupti, assumenda dignissimos ipsam vel, fuga a!</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" role="tab">
                    <h6><a class="collapsed" href="#collapseThree" data-toggle="collapse" aria-expanded="false">Amor</a></h6>
                  </div>
                  <div class="collapse" id="collapseThree" data-parent="#accordion1" role="tabpanel" style="">
                    <div class="card-body">
                      <div class="border">
                        <a onclick="fillMensaje(this)">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo error dolorem et magnam eius, illum dignissimos odio, iusto aliquam commodi saepe laborum amet illo enim. Enim animi, ad adipisci tenetur.</a>
                      </div>
                      <br>
                      <div class="border">
                        <a onclick="fillMensaje(this)">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non assumenda, impedit dolor fugiat molestiae ex recusandae officia facere maiores excepturi reprehenderit illo odit, ea, rem quam accusantium obcaecati sit? Cum!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio recusandae debitis ducimus doloremque iure ullam iste sunt, dolorum harum id mollitia incidunt architecto corrupti, assumenda dignissimos ipsam vel, fuga a!</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- FIN BLOQUE MODAL MOSTRAR SUGERENCIA -->


<!-- INICIO BLOQUE MODAL PREVISUALIZAR TARJETA -->
<div class="modal fade" id="verTarjeta" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>
<!-- FIN BLOQUE MODAL PREVISUALIZAR TARJETA -->


<!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
<!-- Backdrop-->
<div class="site-backdrop"></div>
    

