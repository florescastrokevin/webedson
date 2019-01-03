<?php
require_once(_model_.'Pedido.php');
require_once(_model_.'Catalogo.php');

class Pedidos{

    private $_msgbox;
	
	//private $_costo_envio = 7.00;
	public function __construct($msg='')
	{
            $this->_msgbox = $msg;
	}
	
	function newPedidos(){
            
            $clientes = new Clientes();
            $arrayc   = $clientes->getClientesLimit(30);
            
            $distritos = new Ubigeos();
            $arrayd   = $distritos->getDistritosConCobertura();

            $fpago  = new FormasPago();
            $arrayf = $fpago->getFormasPago();
            
            $productos = Catalogo::getProductos();
            
            $ubigeo = new Ubigeos();		
            $paises = $ubigeo->getPaises();
?>

            <fieldset id='form'>
                <legend> Nuevo Pedido</legend>	
                <!-- Modal -->
                        <div class="modal fade" id="ModalAddCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Nuevo Cliente</h4>
                              </div>
                              <div class="modal-body">
                                <form name='frm_notificar' id='frm_notificar' action='pedidos.php?action=new' > 
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>Nombre:</label> <input type='text' name='nombre_cliente' id='nombre_cliente' class='form-control' /> </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>Apellidos:</label> <input type='text' name='apellidos_cliente' id='apellidos_cliente' class='form-control' /></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>E-mail:</label> <input type='text' name='email_cliente' id='email_cliente' class='form-control'/></div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>Password:</label> <input type='text' name='password_cliente' id='password_cliente' class='form-control' /></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>Telefono:</label> <input type='text' name='telefono_cliente' id='telefono_cliente' class='form-control' /></div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>Dirección:</label> <input type='text' name='direccion_cliente' id='direccion_cliente' class='form-control' /></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>País:</label> <?php echo Form::select($paises, "pais", "id_pais", "nombre"); ?></div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>Ciudad:</label> <input type='text' name='ciudad_cliente' id='ciudad_cliente' class='form-control'/></div>                  
                                    </div>                                
                                    <div class="form-group"><label>Observación:</label> <input type='text' name='observacion_cliente' id='observacion_cliente' class='form-control' /> </div>
                                     
                                </form> 
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" id="add-cliente">Agregar Cliente</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- fin de modal -->    
                    <form name='pedidos' method='post' action='' >
                        
                        <div class='button-actions'>
                            <input type='reset' name='cancelar' value='CANCELAR' class='button' >  
                            <input type='button' name='actualizar' value='GUARDAR' onclick='return valida_pedidos()' class='button'><br clear='all' />
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6" style="background-color:#f4f4f4;min-height:500px " >
                                <div class="form-inline">
                                    <h4> Datos del Cliente: </h4>
                                    <label> Cliente: </label>
                                    <?php //echo Form::select($arrayc, "cliente", "id", "usuario"); ?>   
                                    <input type="text" name="buscar_cliente" id="buscar_cliente" class="form-control" >                                
                                    <a href='#inline' data-toggle="modal" data-target="#ModalAddCliente" ><img src='../aplication/webroot/imgs/icons/customers.png'/></a>
                                    <input type="hidden" name="id_cliente" id="ids_cliente" value="0">
                                </div>
                                
                                <div class="row col-xs-12 col-sm-12 col-md-12"><br><h4> Datos del Pedido: </h4></div>
                                <div class="row">
                                    <div  class="col-xs-12 col-sm-12 col-md-6 form-group" >
                                        <label> Estado del Pedido: </label>
                                        <select name='estado_pedido' id='estado_pedido' class="form-control">
                                            <option value=' '> Seleccione Estado</option>
                                            <option value='Registrado'> Registrado </option>
                                            <option value="Solicitado">Solicitado</option>
                                            <option value="Confirmado">Confirmado</option>
                                            <option value="Pagado">Pagado</option>
                                            <option value="PagadoBoleta">Pagado Boleta</option>
                                            <option value="Pagado-IPN">Pagado-IPN</option>
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="Entregado">Entregado</option>
                                            <option value="DireccionError">Dirección Incorrecta</option>
                                            <option value="PersonaNoUbicada">Persona no ubicada</option>
                                        </select>            
                                    </div>
                                    <div  class="col-xs-12 col-sm-12 col-md-6 form-group" >
                                        <label> Metodo Pago: </label>
                                        <?php echo Form::select($arrayf, "metodo_pago", "id", "nombre");      ?>
                                    </div>
                                </div>  
                                
                                <div class="row col-xs-12 col-sm-12 col-md-12">
                                    <h4>Datos de Facturación: </h4>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 form-inline"> 
                                        <select name="tipo_documento" class="form-control">
                                            <option value="">Tipo</option>
                                            <option value="ruc">RUC</option>
                                            <option value="dni">DNI</option>
                                        </select>
                                        <input type='text' name='documento_facturacion' value='' class='form-control' >    
                                        </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 form-group">
                                        
                                        <input type='text' name='razon_social' value='' class='form-control' placeholder="Razon social o Nombre" >    
                                    </div>
                                </div>
                                
                                <div class="row col-xs-12 col-sm-12 col-md-12">
                                    <h4> Productos: </h4>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 form-inline" id="items_productos">
                                        <?php echo Form::select($productos, "producto", "id", "item");      ?>
                                        <input type='text' name='cantidad_producto' id="cantidad_producto" value='1' class='form-control' style="width:40px"  maxlength=2 >
                                        <input type='button' name='add_producto' id='add_producto' value='Agregar' onclick='addProducto()' class='button btn btn-default'>
                                        <br>  <br>    
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6" style='background-color:#DFEFF6;min-height:500px' >
                             
                                <h4> Datos de Envío (Destinatario): </h4> 
                                <div class="row">
                                    <div  class="col-xs-12 col-sm-6 col-md-6 form-group" ><label> Nombre: </label><input type='text' name='nombre_destinatario' value='' class='form-control' maxlength=20 ></div>
                                    <div  class="col-xs-12 col-sm-6 col-md-6 form-group" ><label> Apellidos: </label><input type='text' name='apellidos_destinatario' value='' class='form-control' maxlength=20 ></div>
                                </div> 
                                <div class="row">
                                    <div  class="col-xs-12 col-sm-6 col-md-6 form-group" ><label> Telefono: </label><input type='text' name='telefono_destinatario' value='' class='form-control'maxlength=20 ></div>
                                    <div  class="col-xs-12 col-sm-6 col-md-6 form-group" ><label> Fecha y hora de envío: </label><input type='text' name='fecha_envio_destinatario' id="fecha_envio" value='' placeholder="14/02/2017 09:00 am" class="form-control" ></div>
                                </div>
                                <div class="row">
                                    <div  class="col-xs-12 col-sm-6 col-md-6 form-group" ><label> Distrito: </label> <?php echo Form::select($arrayd, "distrito", "id", "nombre");      ?></div>
                                    <div  class="col-xs-12 col-sm-6 col-md-6 form-group" ><label> Dirección: </label><input type='text' name='direccion_destinatario' value='' class='form-control' ></div>
                                </div>  
                                <div class="row">
                                    <div  class="col-xs-12 col-sm-6 col-md-6 form-group" ><label> Referencia: </label><textarea name='referencia_destinatario' value='' class='form-control' style="height:100px;"> </textarea></div>
                                    <div  class="col-xs-12 col-sm-6 col-md-6 form-group" ><label> Dedicatoria: </label><textarea name='dedicatoria_destinatario' value='' class='form-control' style="height:100px;" ></textarea> </div>
                                </div>              
                                <div class="row">
                                    <div  class="col-xs-12 col-sm-12 col-md-12 form-group" ><label>Adicional:</label><textarea name="adicional_change" class='form-control' id="adicional_change" style="height:50px;"></textarea></div>
                                </div>    
                                
                            </div>
                        </div>
                        
                    </form>
                </fieldset>
                
                <br />
            <?php
            
//            $sql = "SELECT id_pedido, id_cliente, estado_pedido, id_metodo_pago, fecha_pedido, codigo_pedido FROM pedidos";
//            $query = new Consulta($sql);
//            
//            $clientes   = new Clientes();
//            $arrayc = $clientes->getClientes();
//            $c = Form::select($arrayc,"cliente","id","usuario");
//            
//            $fpago   = new FormasPago();
//            $arrayf = $fpago->getFormasPago();
//            $fp = Form::select($arrayf,"metodo_pago","id","nombre");
//            $matrix	= array(1 => $c,3 => $fp);
//                
//            Form::getForm($query,"new",'pedidos.php', $matrix );
            
        }
        					
	function editPedidos(){ 
                        
            $pedido = new Pedido($_GET['id']);  ?>            
                <fieldset id="form">
                    <legend> PEDIDO Nº <?php echo $pedido->getId() ?></legend>
            
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <h4>Carrito de Compras</h4>
                            <table cellspacing="0" cellpading="0" class="listado">
                                 <thead>
                                 <tr class="head">
                                    <th align="left" class="titulo">DESCRIPCION</th>
                                    <th style="text-align:right" class="titulo">PRECIO</th>
                                    <th style="text-align:right" class="titulo">CANT</th>
                                    <th style="text-align:right" class="titulo">TOTAL </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $j = 0;
                                $carrito = $pedido->getCarrito();
                                $productos = $carrito->getContent();
                                $priceTotal = 0;	
                                $item = 1;			
                                reset($productos);
                                while( list($key,) = each( $productos ) ){	

                                    $preciocmp = 0;

                                    $producto = new Producto($key);
                                    $subtotal += $productos[$key]['cantidad'] * $productos[$key]['precio'];	
                                    $precio = $productos[$key]['precio'];    ?>
                                <tr class="row <?php echo ($i % 2 == 0) ? 'odl' : ''; ?>">
                                    <td align="left" class="celda"> <?php  echo $producto->__get('_nombre');  

                                    $query_productos_cmp = new Consulta("SELECT * FROM pedidos_productos_opciones WHERE id_pedido_producto = '".$productos[$key]['id_pedido_producto']."'");
                                    if( $query_productos_cmp->NumeroRegistros() > 0 ){  ?>
                                            <div class="prod_agregado">
                                                <ul>
                                                    <?php
                                                    while( $rowcmp = $query_productos_cmp->VerRegistro() ){

                                                    $prodcmp = new Producto($rowcmp['producto_opcion']);
                                                    $imgcmp = $prodcmp->__get("_imagenes");	

                                                    $preciocmp += $prodcmp->__get("_precio_producto")*$rowcmp['producto_opcion_valor'];

                                                    $img_thumb_cmp = (file_exists(_link_file_ . $imgcmp[0]['thumbnail'])) ? $imgcmp[0]['thumbnail'] : 'not_image_disponible_thumb.jpg' ;	

                                                    ?>
                                                    <li>
                                                            <span><?php echo $rowcmp['producto_opcion_valor'];?> <?php echo $prodcmp->__get("_nombre")?></span>
                                                    </li> 
                                                    <?php }?>
                                                </ul>
                                            </div>
                                            <?php

                                    } 
                                    ?>
                                    </td>
                                    <td align="right" class="celda">$ <?php echo number_format($precio + $preciocmp, 2); ?></td>                                
                                    <td align="right" class="celda"><?php  echo $productos[$key]['cantidad']; ?></td>
                                    <td align="right" class="celda">$ <?php $priceTotal += (($precio+$preciocmp) * $productos[$key]['cantidad']); echo number_format((($precio+$preciocmp) * $productos[$key]['cantidad']),2); ?> </td>
                                </tr> <?php 
                                $atributo_precio = 0;
                                $i++;
                                } ?>
                                 
                                <tr class="dContenido">
                                   <td align="right" colspan="3"><strong>SubTotal :</strong></td>
                                   <td align="right"><b> USD$ <?php 	$total = ($priceTotal); echo  number_format($total,2); ?>  </b></td>
                              </tr>
                                <tr class="dContenido">
                                   <td align="right" colspan="3"><b>Envio :</b> </td>
                                   <td align="right"><b> USD$ <?php echo number_format($pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio'),2);?> </b></td>
                              </tr>
                                <tr class="dContenido">
                                    <td align="right" colspan="3"> <strong>Monto Total :</strong></td>
                                    <td align="right"> <b>USD$ <?php $total = ($priceTotal + $pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio')); echo number_format($total,2); ?></b></td>
                                </tr> 
                                </tbody>
                            </table><br><br>
                            <h4>Datos de Facturación</h4>
                            <p><label>Forma de Pago: </label> <?php echo $pedido->getMetodoPago()->__get('_nombre') ?></p>
                            <h6></h6>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>Nombre: </label> <?php echo $pedido->getComprobantePago()->__get("_nombre"); ?></div>
                                <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>DNI: </label> <?php echo $pedido->getComprobantePago()->__get("_dni"); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>Ruc: </label> <?php echo $pedido->getComprobantePago()->__get("_ruc"); ?></div>
                                <div class="col-xs-12 col-sm-6 col-md-6 form-group"><label>Razon Social: </label> <?php echo $pedido->getComprobantePago()->__get("_razon_social"); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-12 form-group"><label>Dirección: </label> <?php echo $pedido->getComprobantePago()->__get("_direccionb"); ?></div>
                            </div>
                    </div><?php
                $distritos = new Ubigeos();
                $arrayd   = $distritos->getDistritosConCobertura();
                $id_cliente = new Clientes(); ?>
                        <div class="col-xs-12 col-sm-6 col-md-6" style="background-color:#ddeff8">
                        <form name="f1" method="post" action="pedidos.php?action=update&id=<?php echo $pedido->getId() ?>" >
                            <div class="row col-md-12"><h4>Datos del Cliente</h4></div>
                            <div class="row">
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Nombre:</label>
                                <input class="form-control" type="text" name="nombre" id="nombre_cliente" value="<?php echo $pedido->getCliente()->__get('_nombre') ?> "></div>
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Apellidos:</label>
                                <input class="form-control" type="text" width="30" name="apellidos" id="apellidos" value="<?php echo $pedido->getCliente()->__get('_apellidos') ?> "></div>
                            </div>
                            <div class="row">
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Teléfono:</label>
                                <input class="form-control" type="text" width="15" name="telefono" id="telefono" value="<?php echo $pedido->getCliente()->__get('_telefono') ?>"></div>
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Correo:</label>
                                <input class="form-control" type="text" width="15" name="telefono" id="telefono" value="<?php echo $pedido->getCliente()->__get('_email') ?>"></div>
                            </div>
                            <div class="row col-md-12"><h4>Datos del Destinatario abc</h4></div>
                            <div class="row">
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Nombre:</label>
                                    <input class="form-control" type="text" width="30" name="nombre" id="nombre" value="<?php echo $pedido->getDestinatario()->__get('_nombre')?> "></div>
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Apellidos:</label>
                                    <input class="form-control" type="text" width="30" name="apellidos" id="apellidos" value="<?php echo $pedido->getDestinatario()->__get('_apellidos') ?> ">	</div>
                            </div>
                            <div class="row">
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Teléfono:</label>
                                    <input class="form-control" type="text" width="15" name="telefono" id="telefono" value="<?php echo $pedido->getDestinatario()->__get('_telefono') ?>"></div>
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Fecha y Hora:</label>
                                    <input class="form-control" type="text" name="fecha" class="datetime" id="fecha_envio" value="<?php echo date("d/m/Y h:i a",strtotime($pedido->getDestinatario()->__get('_fecha_hora'))); ?>"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group">
                                    <label>Distrito:</label>
                                    <select name="distrito_change" id="distrito_change" class="form-control">
                                        <?php foreach ( $arrayd  as $dist ): ?>
                                        <option <?php if( $pedido->getDestinatario()->__get('_distrito')->__get('_id') == $dist['id'] ) echo 'selected="selected"';?>   value="<?php echo $dist['id']?>"><?php echo $dist['nombre']?>	</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Dirección:</label>
                                    <textarea class="form-control"   rows="5" name="direccion_change" id="direccion_change"><?php echo $pedido->getDestinatario()->__get('_direccion');?></textarea>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Referencia:</label>
                        <textarea  class="form-control" rows="5" name="referencia_change" id="referencia_change"><?php echo $pedido->getDestinatario()->__get('_referencia');?></textarea></div>
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group"><label>Adicional:</label>
                                <textarea class="form-control" rows="5" name="adicional_change" id="adicional_change"><?php echo $pedido->getDestinatario()->__get('_adicional')?></textarea></div>
                            </div>
                            <div class="row">
                                <div class="col-sx-12 col-sm-12 col-md-12 form-group"><label>Dedicatoria:</label>
                                    <textarea class="form-control"  rows="5" name="dedicatoria_change" id="dedicatoria_change" ><?php echo $pedido->getDestinatario()->__get('_dedicatoria')?></textarea>
                                </div>
                            </div>   
                            <div class="row col-md-12"><h4>Notificación al Cliente</h4></div>
                            <div class="row">   
                                <div class="col-sx-12 col-sm-12 col-md-12 form-group">
                                    <textarea name="comentarios" class="form-control"  rows="10" >
                    Sr(a) <?php echo $pedido->getCliente()->__get('_nombre'); ?> <?php echo $pedido->getCliente()->__get('_apellidos') ?> hemos recibido los datos del pago via <?php echo $pedido->getMetodoPago()->__get('_nombre')?>,  su Nº de pedido  es  <?php echo $pedido->getId(); ?>  y todo esta conforme. 
                    
                    Su pedido esta siendo procesado.
                    

ATENTAMENTE
-----------
http://www.donregalo.pe
                    </textarea></div>
                            </div>
                            <div class="row">
                                <div class="col-sx-12 col-sm-6 col-md-6 form-group">
                                    <label>Estado del Pedido:</label> 
                                    <select class="noestile" name="estado" id="estado" style="width:200px">
                                        <option value="Registrado" <?php if($pedido->getEstado() == "Registrado") echo 'selected="selected"'; ?>>Registrado</option>
                                        <option value="Solicitado" <?php if($pedido->getEstado() == "Solicitado") echo 'selected="selected"'; ?>>Solicitado</option>
                                        <option value="Confirmado" <?php if($pedido->getEstado() == "Confirmado") echo 'selected="selected"'; ?>>Confirmado</option>
                                        <option value="Pagado"     <?php if($pedido->getEstado() == "Pagado")     echo 'selected="selected"'; ?>>Pagado</option>
                                        <option value="PagadoBoleta" <?php if($pedido->getEstado() == "PagadoBoleta")     echo 'selected="selected"'; ?>>Pagado Boleta</option>
                                        <option value="Pagado-IPN" <?php if($pedido->getEstado() == "Pagado-IPN")     echo 'selected="selected"'; ?>>Pagado-IPN</option>
                                        <option value="Pendiente"  <?php if($pedido->getEstado() == "Pendiente")  echo 'selected="selected"'; ?>>Pendiente</option>
                                        <option value="Entregado"  <?php if($pedido->getEstado() == "Entregado")  echo 'selected="selected"'; ?>>Entregado</option>
                                        <option value="DireccionError"  <?php if($pedido->getEstado() == "DireccionError")  echo 'selected="selected"'; ?>>Dirección Incorrecta</option>
                                        <option value="PersonaNoUbicada"  <?php if($pedido->getEstado() == "PersonaNoUbicada")  echo 'selected="selected"'; ?>>Persona no ubicada</option>
                                        <option value="Cta. Personal"  <?php if($pedido->getEstado() == "Cta. Personal")  echo 'selected="selected"'; ?>>Cta. Personal</option>
                                    </select>
                                </div>
                                <div class="col-sx-12 col-sm-6 col-md-6 form-inline">
                                    <label></label>
                                    <input type="button" name="cancel" value="CANCELAR" class="button btn btn-default" onclick="javascript:window.history.go(-1)" />
                                <input type="submit" name="actualizar" value="ACTUALIZAR" class="button btn btn-primary"  />
                                </div>
                            </div>
            </form>
                    </div>
                </div>        
            
    </fieldset><?php
	}

	function deletePedidos(){
		$Query= new Consulta("DELETE FROM pedidos_pagos WHERE id_pedido='".$_GET['id']."'");
		$Query= new Consulta("DELETE FROM pedidos_destinatarios WHERE id_pedido='".$_GET['id']."'");
		$Query= new Consulta("DELETE FROM pedidos WHERE id_pedido='".$_GET['id']."'");
		$Query= new Consulta("DELETE FROM pedidos_productos WHERE id_pedido='".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Se elimino el registro Correctamente',2);		
		location("pedidos.php");
	}
	
	function updatePedidos(){
		
		$fecha_hora = fecha_hora_html_sql($_POST['fecha']); 
		//$_POST['fecha']
		
		new Consulta("UPDATE pedidos_destinatarios SET  
                                nombre_destinatario = '".$_POST['nombre']."',
                                apellidos_destinatario= '".$_POST['apellidos']."',
                                telefono_destinatario = '".$_POST['telefono']."' , 
                                fecha_full_destinatario = '".$fecha_hora."' , 													
                                direccion_destinatario = '".$_POST['direccion_change']."' , 
                                referencia_destinatario = '".$_POST['referencia_change']."',
                                id_distrito = '".$_POST['distrito_change']."',
                                dedicatoria_destinatario = '".$_POST['dedicatoria_change']."',
                                adicional_destinatario = '".$_POST['adicional_change']."'
                                WHERE id_pedido = '".$_GET['id']."'");
													

		$query = new Consulta("SELECT id_cliente FROM pedidos WHERE id_pedido='".$_GET['id']."'");
		$row = $query->VerRegistro();
	
		$queryC = new Consulta("SELECT email_cliente FROM clientes WHERE id_cliente='".$row['id_cliente']."'");
		$rowC=$queryC->VerRegistro();
	
		$email=$rowC['email_cliente'];
		
		switch ( $_POST['estado'] ):
			case 'Entregado':
				$subject="Envio de Pedido - ". NOMBRE_SITIO ;
			break;
			default:
				$subject="Verificación Transacción - ". NOMBRE_SITIO ;		
			break;
		endswitch;		
		
		//@mail($email,$subject,$_POST['comentarios'],"from: ".EMAIL_PEDIDOS);		
		
		$Query= new Consulta("UPDATE pedidos SET estado_pedido = '".$_POST['estado']."'
						  WHERE id_pedido='".$_GET['id']."'");
                $pedido = new Pedido($_GET['id']);
                $pedido->generarGuiaEntrega();
		$this->_msgbox->setMsgbox('La actualizacion se realizo Correctamente',2);
		location("pedidos.php");
}

	function listPedidos(){
		
		if(!isset($_GET['pag'])){ $_GET['pag'] = 1; } 
		$tampag = 100;
		$reg1 = ($_GET['pag']-1) * $tampag;	 
		//$filtro_estado = isset($_GET['filtro']) && !empty($_GET['filtro']) ? "AND p.estado_pedido like '%Pagado%' " : "";
		
		
		if (isset($_GET['pedido']) && !empty($_GET['pedido'])){
				$filtro = "AND "."p.id_pedido like '%".$_GET['pedido']."%'";
		}
		if (isset($_GET['estado']) && !empty($_GET['estado'])){
				$filtro_estado = "AND "."p.estado_pedido = '".$_GET['estado']."'";
		}
		if (isset($_GET['cliente']) && !empty($_GET['cliente'])){
				$cliente = " AND CONCAT(c.nombre_cliente,' ', c.apellidos_cliente) LIKE '%".$_GET['cliente']."%'";
		}
		if (isset($_GET['producto']) && !empty($_GET['producto'])){
				
				$id_producto= $_GET['producto'];
				$producto_pedido = new Productos();
				$productos_pedidos = $producto_pedido->getAllProductosPedidos($_GET['producto']);
				$filtro_pp = implode(',',$productos_pedidos );
				$filtro_pedido_producto= " AND p.id_pedido IN ( ".$filtro_pp." )";
	
		}
		if( isset($_GET['distrito']) || isset($_GET['fecha_envio_init'])){
			$from_pedidos_destinatarios = ', pedidos_destinatarios pd';
		}
		if (isset($_GET['distrito']) && !empty($_GET['distrito'])){
				
				$from_pedidos_destinatarios_dis = ', distritos d';				
				$filtro_pedidos_destinatarios_dis = " AND d.id_distrito = '".$_GET['distrito']."' AND d.id_distrito = pd.id_distrito AND pd.id_pedido = p.id_pedido";		
		}
		if (isset($_GET['fecha_envio_init']) && !empty($_GET['fecha_envio_init'])){			
			$fechai = fecha_hora_html_sql($_GET['fecha_envio_init']); 
			$fechaf = fecha_hora_html_sql($_GET['fecha_envio_fin']); 	
			$filtro_pedidos_destinatarios = " AND pd.fecha_full_destinatario BETWEEN DATE '".$fechai."' AND DATE '".$fechaf."' AND pd.id_pedido = p.id_pedido";			
			$orden_fecha = ", fecha_full_destinatario ASC";	
		}
		
    	         
		$sql = "SELECT c.nombre_cliente, c.apellidos_cliente, p.id_pedido, DATE_FORMAT(p.fecha_pedido,'%d-%m-%Y %H:%i:%s') as Fecha, p.codigo_pedido, p.estado_pedido".$cads."
				FROM pedidos p, clientes c".$from_pedidos_destinatarios. $from_pedidos_destinatarios_dis."
				WHERE c.id_cliente=p.id_cliente ".$filtro_pedido_producto. $filtro_estado . $filtro_producto.$filtro_pedidos_destinatarios . $filtro_pedidos_destinatarios_dis . $cliente ."
                                GROUP BY p.id_pedido
                                ORDER BY  p.id_pedido DESC ". $orden_fecha;
		//echo $sql; 
				
		$queryt= new Consulta($sql);	 
		$num   = $queryt->NumeroRegistros();	
		$limit = $sql_pag." LIMIT ".$reg1.",".$tampag."";
		
		$sql .= $limit ;		

		//echo $sql;

		$Query = new Consulta($sql);
                
                $obj_choferes = new Choferes();
                $choferes = $obj_choferes->getChoferes();
                $total_choferes = count($choferes);
                ?> 
            <div id="content-area">
                <!-- Modal -->
                <script>
                    $(document).ready(function(){ 
                        $(document).on("click", ".item-acciones", function(){ //para pasar los datos al modal al momento de escoger opcion                             
                            var selected = '';  
                            var cantidad = 0; 
                            var concatenar = "";
                            $(".resultado_accion").empty(); 
                            $("#select_choferes").css("display","none");
                            $("#select_estados").css("display","none");
                            $('.chk-pedido').each(function(){
                                if (this.checked){
                                    selected += concatenar + $(this).val(); 
                                    cantidad ++;
                                    concatenar = ",";
                                }
                            }); 
                            if (selected != ''){
                                //alert('Has seleccionado: '+selected);
                                $('#pedidos_seleccionados').val(selected);
                                var input_accion_masiva  = $(this).data('accion');
                                var texto_accion_masiva  = $(this).data('texto');
                                $("#accion_masiva").val( input_accion_masiva );
                                $(".texto-accion").html(texto_accion_masiva);
                                $(".texto-cantidad").html(cantidad);
                                $(".texto-pedidos").html(selected);
                                if(input_accion_masiva === "asignarMovilidad"){ $("#select_choferes").css("display","block"); }
                                if(input_accion_masiva === "cambiarEstado"){ $("#select_estados").css("display","block"); }
                                
                            }else{
                                alert('Debes seleccionar al menos una opción.');
                                return false;
                            }
                        }); 
                        $("#confirmar_accion").click(function(){    // para pasar los datos al confirmar accion
                            $(".resultado_accion").html("<div style='width:98%;text-align:center'><b>Procesando Acción... </b><br><br><img src='<?php echo _imgs_ ?>bx_loader.gif'></div>");
                            
                            $.get('ajax.php',{  
                                action:$('#accion_masiva').val(), 
                                pedidos:$('#pedidos_seleccionados').val(),
                                id_chofer:$("#choferes").val(),
                                id_estado:$("#estado_pedido").val()  
                            },function(data){
                                $(".resultado_accion").empty(); 
                                $(".resultado_accion").append(data);
                                $(".resultado_accion").html(data);
                                //window.location.href = "http://www.servianuncios.info/"+url_page;
                                //console.log(data);//se puede poner algo
                            }); 
                        });
                        
                        
                    });
                </script>    
                <form name="form-acciones" id="form-acciones" action="post">
                    <div class="modal fade" id="modal-acciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog  modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel"><b><span class="texto-accion">accion</span></b></h3>
                          </div>
                          <div class="modal-body">
                              <p><span>Se selecionaron <b><span class="texto-cantidad">0</span></b> Pedido(s)</span>, los números son: <br><br> </p> 
                              <p><b><span class="texto-pedidos">0</span></b> </p><br>
                              <div id="select_choferes" style="display:none">
                                  <select name="choferes" id="choferes" class="form-control">
                                        <option value="0">Seleccionar Chofer</option><?php
                                    for($c = 0; $c < $total_choferes; $c++){ ?>
                                        <option value="<?php echo $choferes[$c]["id"] ?>"><?php echo $choferes[$c]["nombre"].' '. $choferes[$c]["apellidos"] ?> (<?php echo $choferes[$c]["transporte"] ?>)</option>
                                        <?php
                                    } ?>
                                    </select>
                                </div>
                              <div id="select_estados" style="display:none">
                                  <select name='estado_pedido' id='estado_pedido' class="form-control">
                                        <option value=' '> Seleccione Estado</option> 
                                        <option disabled="disabled">--------------------</option>
                                        <option value="Entregado">Entregado</option>
                                        <option disabled="disabled">--------------------</option>
                                        <option value="Pagado">Pagado</option>
                                        <option value="Pagado-IPN">Pagado-IPN (Paypal)</option>
                                        <option disabled="disabled">--------------------</option>
                                        <option value="DireccionError">Dirección Incorrecta</option>
                                        <option value="PersonaNoUbicada">Persona no ubicada</option>
                                    </select>      
                              </div>
                              <p class="resultado_accion"><h5></h5></p>
                              <input type="hidden" name="pedidos_seleccionados" id="pedidos_seleccionados" value="" >
                              <input type="hidden" name="accion_masiva" id="accion_masiva" value="" > 
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="confirmar_accion">Confirmar</button>
                          </div>
                        </div>
                      </div>
                    </div>  
                </form>
		<table  cellspacing="0" cellpading="0"   class='listado' >	
                    <thead>
			<h4><?php echo "Hay ".$num." pedidos seleccionados";?></h4>
                        <tr class="head">
                            <th class='titulo'><input type="checkbox" name="print_pedidos" id="print_pedidos">
                                <div id="acciones-masivas">
                                    <a href="#">Opc <i class="glyphicon glyphicon-chevron-down "></i></a>
                                     <ul> 
                                         <li><a href="#inline" class="item-acciones" data-toggle="modal" data-target="#modal-acciones" data-texto="Imprimir Guias" data-accion="generarGuias" >Imprimir Guías</a></li>
                                         <li><a href="#inline" class="item-acciones" data-toggle="modal" data-target="#modal-acciones" data-texto="Imprimir Tarjetas" data-accion="generarTarjetas" >Imprimir Tarjetas</a></li>
                                         <li><a href="#inline" class="item-acciones" data-toggle="modal" data-target="#modal-acciones" data-texto="Asignar Movilidad" data-accion="asignarMovilidad">Asignar Movilidad</a></li>
                                         <li><a href="#inline" class="item-acciones" data-toggle="modal" data-target="#modal-acciones" data-texto="Cambiar Estado" data-accion="cambiarEstado" >Cambiar Estado</a></li>
                                     </ul>
                                </div> 
                            </th>
                            <th class='titulo'>Cliente </th>
                            <th class='titulo' align="center">Monto  </th>
                            <th class='titulo' align="center" style="width: 80px;">Fecha Compra </th>
                            <th class='titulo' align="center">Estado </th>
                            <th class='titulo' align="center">Destino </th>                            
                            <th class='titulo' align="center">Fecha Envio  </th>
                            <th class='titulo' align="center">Forma de Pago  </th> 
                            
                            <th class='titulo' align="center">Opciones </th>
                        </tr>
                    </thead>
                <tbody> <?php
		$x = 1;
		$z = 0;
			
		while ($row = $Query->verRegistro()){
                    
                    $destinatario = new PedidoDestinatario($row['id_pedido']);
                    $class_estado = "";
                    $marcar_fila = "";
                    if(preg_match("/Pagado/",$row['estado_pedido'])){
                         $class_estado = "font-pagado";
                         $marcar_fila = "fila-pagado";
                    }
                    if(preg_match("/PagadoBoleta/",$row['estado_pedido'])){
                         $class_estado = "font-pagado";
                         $marcar_fila = "fila-pagado-boleta";
                    }   ?>	
                    <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?> <?php echo $marcar_fila; ?>">
                        <td align="left" class='celda'><input type="checkbox" name="print_pedido_<?php echo $row['id_pedido'] ?>" class="chk-pedido" value="<?php echo $row['id_pedido'] ?>" id="print_pedido_<?php echo $row['id_pedido'] ?>"> <label for="print_pedido_<?php echo $row['id_pedido'] ?>"><?php echo $row['codigo_pedido']?></label></td>
                        <td align="left" class='celda'> <?php echo strtoupper($row['nombre_cliente']).' '.strtoupper($row['apellidos_cliente'])?>
                        <br/>
                        
                        <ul class="view_productos"> <?php
							
                            $pedido = new Pedido($row['id_pedido']);
                            $j = 0;
                            $carrito = $pedido->getCarrito();
                            $productos = $carrito->getContent();
                            //$pedidos_productos = $productos['id_pedido_producto'];
                            $priceTotal = 0;	
                            $item = 1;										
                            if ( count($productos) > 0 ){
                            reset($productos);	
                            while( list($key,) = each( $productos ) ){
                                    $producto = new Producto($key);
                                    ?>
                                <li><?php  echo $productos[$key]['cantidad']." | ". $producto->__get('_nombre'); ?></li> 
                                <?php          							
                                    $query_productos_cmp = new Consulta("SELECT * FROM pedidos_productos_opciones WHERE id_pedido_producto = '".$productos[$key]['id_pedido_producto']."'");

                                    if( $query_productos_cmp->NumeroRegistros() > 0 ){ ?>
                                        <div class="prod_agregado">
                                            <ul>
                                                <?php
                                                while( $rowcmp = $query_productos_cmp->VerRegistro() ){
                                                $prodcmp = new Producto($rowcmp['producto_opcion']);  ?>
                                                <li>
                                                        <span><?php echo $rowcmp['producto_opcion_valor'];?> <?php echo $prodcmp->__get("_nombre")?></span>
                                                </li>
                                                <?php }?>
                                            </ul>
                                        </div> <?php
                                    }
				}
                            }else{ ?>
                                <li>Sin productos<li>  <?php
                            }	 ?>
                        </ul>
                        
                        
                        </td>
                        <td align="center" class='celda'> $<?php echo number_format(Pedidos::PedidosMonto($row['id_pedido']),2); ?> </td>
                        <td align="center" class='celda'><?php  $fecha_compra = date("d/m/Y h:i A",strtotime($row['Fecha'])); echo $fecha_compra ?></td>
                        <td align="left" class='celda <?php echo $class_estado ?>'> <?php echo $row['estado_pedido'] ?> </td>
                        <td align="left" class='celda'> <?php if($destinatario->__get('_id') != 0){ echo $destinatario->__get('_distrito')->__get('_nombre'); } ?></td>
                        <td align="left" class='celda'> <?php if($destinatario->__get('_id') != 0){ 
                            $fecha_hora = date("d/m/Y h:i A",strtotime($destinatario->__get('_fecha_hora'))); 
                            echo  $fecha_hora;
                         } ?></td>
                        <td align="left" class='celda'><?php echo substr($pedido->getMetodoPago()->__get('_nombre'),0,25) ?> </td>
                        <td align="center">			
                            <a href='pedidos.php?id=<?php echo $row['id_pedido']?>&action=edit' title="Ver Pedido"><img src="<?php echo _tpl_icons_ ?>zoom.png" border="0" /></a>	&nbsp;&nbsp;
                            <a href='<?php echo _url_web_."aplication/webroot/archivos/guias_entrega/guia-entrega-".$row['id_pedido'];?>.pdf' title="Imprimir Guia" download='guia-entrega-<?php echo $row['id_pedido'];?>.pdf'><img src="<?php echo _tpl_icons_ ?>ps.gif" border="0" /></a>
                           <!-- <a href='pedidos.php?id=<?php echo $row['id_pedido']?>&action=delete') onclick="return validar_delete()" title="Eliminar Pedido"><img  src="<?php echo _icons_ ?>button_drop.png" border="0" /></a> -->
                        </td>
                    </tr>
                    
					<?php						
                if($x==0){$x++;}else{$x=0;}
                $z++;
		}?>
                </tbody>
		</table>
        
        
            </div>
        <div class="nav-bottom">     
		<?php		
		
		$params = (isset($_GET)&&!empty($_GET)) ? http_build_query($_GET) : '';
		$params = substr($params, 0, -1);		
		if( $num > $tampag ){ echo paginar($_GET['pag'], $num, $tampag, "pedidos.php?".$params); }	
		?>
        </div>
        <?php
	}
	
	public static function PedidosMonto($id){
		(float)$monto = 0;
		$queryP = new Consulta("SELECT * FROM pedidos WHERE id_pedido = '".$id."'"); 	
		$rowP = $queryP -> VerRegistro();
			
		$sql = "SELECT * FROM pedidos_productos pp, productos p 
			WHERE pp.id_pedido='".$id."' AND pp.id_producto=p.id_producto ";			
		$query = new Consulta($sql);
		while($row=$query->VerRegistro()){	
			$sq_opciones="  SELECT * FROM pedidos_productos_opciones WHERE id_pedido_producto = '".$row['id_pedido_producto']."' ";								
			$query_opciones = new Consulta($sq_opciones);
			
			$atributo_precio = 0;
					
			while($rop=$query_opciones->VerRegistro()){							
				
				if ($rop['prefijo_precio'] == '+') {			  	
					$atributo_precio += $rop['producto_opcion_precio'] * $rop['producto_opcion_valor'];
				} else {
					$atributo_precio -= $rop['producto_opcion_precio'] * $rop['producto_opcion_valor'];
				}				
			}
			
			$precio = $row['precio_final_pedido_producto'] + $atributo_precio;

			$monto+=($row['cantidad_pedido_producto'] * $precio);
			
			$atributo_precio = 0;
		}
		
		$query_envio = new Consulta("SELECT * FROM pedidos_destinatarios WHERE id_pedido = '".$id."'");
		$row_envio = $query_envio -> VerRegistro();
		
		$distrito = new Distrito($row_envio['id_distrito']);							
		return ($monto + $distrito->__get("_tarifa_envio"));
	}
	
	static public function TotalProductosPedido( $id ){
		$query=new Consulta("SELECT * FROM pedidos_productos WHERE id_pedido='".$id."' ");		
		while($row = $query->VerRegistro()){
			$cantidad+= $row['cantidad_pedido_producto'];
		}	
		
		return $cantidad;
	}
	
	/*function PedidosMonto($id){
		(float)$monto=0;
		$queryP = new Consulta("SELECT * FROM pedidos WHERE id_pedido = '".$id."'"); 	
		$rowP = $queryP -> VerRegistro();
			
		$sql="SELECT * FROM pedidos_productos pp, productos p 
			WHERE pp.id_pedido='".$id."' AND pp.id_producto=p.id_producto ";			
		$query=new Consulta($sql);
		while($row=$query->VerRegistro()){	
			$sq_opciones=" SELECT * FROM pedidos_productos_opciones 
								WHERE id_pedido_producto = '".$row['id_pedido_producto']."' ";								
			$query_opciones = new Consulta($sq_opciones);
			
			while($rop=$query_opciones->VerRegistro()){							
				
				if ($rop['prefijo_precio'] == '+') {			  	
					$atributo_precio += $rop['producto_opcion_precio'];
				} else {
					$atributo_precio -= $rop['producto_opcion_precio'];
				}
			}
			$precio = $row['precio_final_pedido_producto'];
			$precio = $precio + $atributo_precio;

			$monto+=($row['cantidad_pedido_producto'] * $precio);
			
			$atributo_precio = 0;
		}
		
		
							
		return ($monto + $this->_costo_envio);
	}*/
	
	public function getPedidosXOrden($orden=0){

		$sql = new Consulta("SELECT DATEDIFF(CURDATE(),fecha_pedido)as tiempo_restante, id_pedido,fecha_pedido, estado_pedido FROM pedidos WHERE codigo_pedido = '".$orden."'  ORDER BY fecha_pedido DESC");
		
		while($row = $sql->VerRegistro())
		{
			$datos[] = array(
				'id' 	          => $row['id_pedido'],
				'fecha'           => $row['fecha_pedido'],
				'tiempo_restante' => $row['tiempo_restante'],
				'estado'          => $row['estado_pedido']
			);	
		}
		
		return $datos;
	
	}
        
        public function getCantidadPedidos(){
            $fecha_actual = date("Y-m-d"); 
            $inicio_axo = date("Y")."-01-01"; 
            $sql = new Consulta("select count(*) AS cantidad, DATE_FORMAT(fecha_pedido,'%Y,%m') as mes from pedidos where (estado_pedido like '%Pagado%' OR estado_pedido = 'Entregado') and fecha_pedido BETWEEN '".$inicio_axo."' AND '".$fecha_actual."' GROUP BY MONTH(fecha_pedido)");
            while($row = $sql->VerRegistro())
            {
                $datos[] = array(
                    'mes' 	  => $row['mes'],
                    'cantidad'=> $row['cantidad']
                );	
            }
            return $datos;
            
        }
        
        public function getUltimosPedidos(){
            $sql = "SELECT DATE_FORMAT(pd.fecha_full_destinatario,'%d-%b-%Y %H:%i:%s')as fecha, p.fecha_pedido, p.id_pedido, p.estado_pedido, d.nombre_distrito 
                    FROM pedidos p, clientes c, pedidos_destinatarios pd, distritos d
                    WHERE 
                        p.id_cliente = c.id_cliente AND
                        p.id_pedido = pd.id_pedido AND
                        pd.id_distrito = d.id_distrito AND
                        p.estado_pedido LIKE '%Pagado%'
                    GROUP BY p.id_pedido    
                    ORDER BY fecha_pedido DESC LIMIT 0,10";
            $query = new Consulta($sql);
            while($row = $query->VerRegistro())
            {
                $datos[] = array(
                    'id'        => $row['id_pedido'],
                    'fecha'     => $row['fecha'],
                    'distrito'  => $row['nombre_distrito'],
                    'estado'    => $row['estado_pedido']
                );	
            }
            return $datos;
	}
        
        public function getProximosAEntregarPedidos(){
            $sql = "SELECT DATE_FORMAT(pd.fecha_full_destinatario,'%d-%b-%Y %H:%i:%s')as fecha, p.fecha_pedido, p.id_pedido, p.estado_pedido, d.nombre_distrito 
                    FROM pedidos p, clientes c, pedidos_destinatarios pd, distritos d
                    WHERE 
                        p.id_cliente = c.id_cliente AND
                        p.id_pedido = pd.id_pedido AND
                        pd.id_distrito = d.id_distrito AND
                        p.estado_pedido LIKE '%Pagado%' AND
                        pd.fecha_full_destinatario BETWEEN NOW() AND (CURDATE() + INTERVAL 5 DAY)   
                    GROUP BY p.id_pedido    
                    ORDER BY pd.fecha_full_destinatario ASC LIMIT 0,10";
            $query = new Consulta($sql);
            while($row = $query->VerRegistro())
            {
                $datos[] = array(
                    'id'        => $row['id_pedido'],
                    'fecha'     => $row['fecha'],
                    'distrito'  => $row['nombre_distrito'],
                    'estado'    => $row['estado_pedido']
                );	
            }
            return $datos;
	}
	
        public function getProductosXPedidos($array_pedidos){
            $sql = "SELECT DISTINCT pp.id_producto, sum(pp.cantidad_pedido_producto) as cantidad, p.nombre_producto, precio_producto
                    FROM productos p, pedidos_productos pp  
                    WHERE p.id_producto = pp.id_producto AND pp.id_pedido IN (".$array_pedidos.") 
                    GROUP BY pp.id_producto 
                    ORDER BY p.nombre_producto"; 
            $query = new Consulta($sql);
            while($row = $query->VerRegistro()){
                $datos[] = array(
                    "id_producto" => $row["id_producto"], 
                    "nombre" => $row["nombre_producto"], 
                    "precio" => $row["precio_producto"], 
                    "cantidad" => $row["cantidad"]
                );
            }
            return $datos;
        }
        
	public function getNotificarPedidosXCliente($idc=0){

		$sql = new Consulta("SELECT DATEDIFF(CURDATE(),fecha_pedido)as tiempo_restante, id_pedido,fecha_pedido, codigo_pedido, estado_pedido FROM pedidos WHERE  id_cliente = '".$idc."' ORDER BY fecha_pedido DESC");
		
      
		while($row = $sql->VerRegistro())
		{
			$datos[] = array(
				'id' 	          => $row['id_pedido'],
				'fecha'           => fecha_hora_sql_html($row['fecha_pedido']),
				'tiempo_restante' => $row['tiempo_restante'],
				'codigo'          => $row['codigo_pedido'],
				'estado'          => $row['estado_pedido']
			
			);	
		}
		
		return $datos;

		
	}
	
	public function getNotificarPedidosTotalesXCliente($idc=0){

		$sql = new Consulta("SELECT DATEDIFF(CURDATE(),fecha_pedido)as tiempo_restante, id_pedido,fecha_pedido, codigo_pedido, estado_pedido FROM pedidos WHERE  id_cliente = '".$idc."' ORDER BY fecha_pedido DESC");
		
      
		while($row = $sql->VerRegistro())
		{
			$datos[] = array(
				'id' 	          => $row['id_pedido'],
				'fecha'           => $row['fecha_pedido'],
				'tiempo_restante' => $row['tiempo_restante'],
				'codigo'          => $row['codigo_pedido'],
				'estado'          => $row['estado_pedido']
			
			);	
		}
		
		return $datos;
	
	}
	
	public function montoPedidos($id){
		(float)$monto=0;		
		$sql="SELECT * FROM pedidos_productos pp, productos p 
			WHERE pp.id_pedido='".$id."' AND pp.id_producto=p.id_producto ";			
		$query=new Consulta($sql);
		while($row=$query->VerRegistro()){
			$sq_opciones=" SELECT * FROM pedidos_productos_opciones 
								WHERE id_pedido_producto = '".$row['id_pedido_producto']."' ";								
			$query_opciones = new Consulta($sq_opciones);
			
			while($rop=$query_opciones->VerRegistro()){							
				
				if ($rop['prefijo_precio'] == '+') {			  	
					$atributo_precio += $rop['producto_opcion_precio'];
				} else {
					$atributo_precio -= $rop['producto_opcion_precio'];
				}
			}
			$precio = $row['precio_final_pedido_producto'];
			$precio = $precio + $atributo_precio;

			$monto+=($row['cantidad_pedido_producto'] * $precio);
			
			$atributo_precio = 0;
		}
		return  $monto;
	}
	
	public function getUltimoId(){
		$query = new Consulta("SELECT MAX(id_pedido) id FROM pedidos");
		$row   = $query->VerRegistro();
		return  $row['id'];
	}
	
	public function getUltimoCode(){
		$queryI = new Consulta("INSERT INTO codigos VALUES('','')");
		return $queryI->nuevoId();
	}  
        
        static public function addPedido($pedido){
                
            $t = 0;
            $envio = 7.00;
            $orderID = ( (int)self::getUltimoCode() + 1 );
            $carrito = $pedido->getCarrito();
            $cliente = $pedido->getCliente();
            
            $sqlPedido = "INSERT INTO pedidos 
                            VALUES('',
                                       '".$cliente->__get("_id")."',
                                       '0',    
                                       'Solicitado',
                                       '".$pedido->getMetodoPago()."',
                                       '".date('Y-m-d H:i:s')."',							  
                                       '".$orderID."')";

            $queryPedido = new Consulta($sqlPedido);
            $IdPedido = $queryPedido->nuevoId();

            $j = 0;
            $productos = $carrito->getContent();
            reset($productos);
            while( list($key,) = each( $productos )){	

                $sql = "SELECT * FROM productos WHERE id_producto='".(int) $key . "' ";

                $query = new Consulta($sql);
                if($query->NumeroRegistros() > 0){							
                    $row = $query->VerRegistro();	

                    //OBTIENE PRECIO DE SI ES QUE HAY OFERTAS
                    if (!verifica_oferta((int)$key)){
                        $precio = $row['precio_producto'];	
                    }else{
                        $precio = verifica_oferta((int)$key);					
                    }

                    $precio_anterior = 0;
                    $producto = new Producto((int)$key, $idioma);

                    //INSERTO PRODUCTO POR PRODUCTO                        
                    $sql_productos_pedidos = " INSERT INTO pedidos_productos 
                                                VALUES( '',
                                                        '".$IdPedido."',
                                                        '".$key."',
                                                        '".$productos[$key]['cantidad']."',
                                                        '".$precio."')"; 
                    $query_productos_pedidos = new Consulta($sql_productos_pedidos);								
                    $id_pedido_producto = $query_productos_pedidos->nuevoId();

                }
            }
//                    $sql_destinatario = "INSERT INTO pedidos_destinatarios VALUES ('',
//                                    '".$IdPedido."',
//                                    '".$pedido->getDestinatario()->__get("_nombre")."',
//                                    '".$pedido->getDestinatario()->__get("_apellidos")."',
//                                    '".$pedido->getDestinatario()->__get("_telefono")."',
//                                    '".$pedido->getDestinatario()->__get("_fecha")."',
//                                    '".$pedido->getDestinatario()->__get("_hora")."',
//                                    '".$pedido->getDestinatario()->__get("_direccion")."',
//                                    '".$pedido->getDestinatario()->__get("_distrito")."',
//                                    '".$pedido->getDestinatario()->__get("_referencia")."',
//                                    '".$pedido->getDestinatario()->__get("_dedicatoria")."')";
            //                    $queryPedido = new Consulta($sql_destinatario); 
            
           
            
        }
        
        public function addAdminPedidos(){
            
            $sqlPedido = "INSERT INTO pedidos 
                            VALUES('',
                                       '".$_POST['id_cliente']."',
                                       '0',
                                       '".$_POST['estado_pedido']."',
                                       '".$_POST['id_metodo_pago']."',
                                       '".date('Y-m-d H:i:s')."',							  
                                       '')";

            $queryPedido = new Consulta($sqlPedido);
            $id_pedido = $queryPedido->nuevoId();
//            echo "<pre>";
//            print_r($_POST);
//            echo "</pre>";
            foreach( $_POST['id_producto'] as $key => $value ){	

                $sql = "SELECT * FROM productos WHERE id_producto='".(int) $value . "' ";

                $query = new Consulta($sql);
                if($query->NumeroRegistros() > 0){							
                    $row = $query->VerRegistro();	

                    //OBTIENE PRECIO DE SI ES QUE HAY OFERTAS
                    
                    if (!verifica_oferta($value)){
                        $precio = $row['precio_producto'];	
                    }else{
                        $precio = verifica_oferta($value);					
                    }
                    $precio = $row['precio_producto'];
                    $precio_anterior = 0;
                    $producto = new Producto((int)$value, $idioma);

                    //INSERTO PRODUCTO POR PRODUCTO                        
                    $sql_productos_pedidos = " INSERT INTO pedidos_productos 
                                                VALUES( '',
                                                        '".$id_pedido."',
                                                        '".$value."',
                                                        '".$_POST['cantidad_producto'][$key]."',
                                                        '".$precio."')"; 
                    $query_productos_pedidos = new Consulta($sql_productos_pedidos);								
                    $id_pedido_producto = $query_productos_pedidos->nuevoId();	

                }
            }
            
			$fecha_hora = fecha_hora_html_sql($_POST['fecha_envio_destinatario']); 
			
			 $sql_destinatario = "INSERT INTO pedidos_destinatarios VALUES ('',
                                    '".$id_pedido."',
                                    '".$_POST['id_distrito']."',
                                    '".$_POST['nombre_destinatario']."',
                                    '".$_POST['apellidos_destinatario']."',
                                    '".$_POST['telefono_destinatario']."',
                                    '".$_POST['direccion_destinatario']."',
                                    '".$_POST['referencia_destinatario']."',
                                    '".$_POST['dedicatoria_destinatario']."',
									'".$_POST['adicional_change']."',
									'".$fecha_hora."'  						
									)";
            $queryDestinatario = new Consulta($sql_destinatario); 
            $queryp = new Consulta("UPDATE pedidos SET codigo_pedido = '".$id_pedido."' WHERE id_pedido='".$id_pedido."'");
            $pedido = new Pedido($id_pedido);
            $pedido->generarGuiaEntrega();
             
            location("pedidos.php");
        }
        
        function listPedidosCompleto(){
		
		if(!isset($_GET['pag'])){ $_GET['pag'] = 1; } 
		$tampag = 200;
		$reg1 = ($_GET['pag']-1) * $tampag;	 
		$campana = $_GET["campana"];
		$sql = "SELECT c.nombre_cliente, p.id_pedido, DATE_FORMAT(p.fecha_pedido,'%d-%m-%Y %H:%i:%s') as Fecha, p.codigo_pedido, p.estado_pedido
				FROM pedidos p, clientes c, pedidos_destinatarios pd
				WHERE 	c.id_cliente = p.id_cliente AND 
					p.id_pedido = pd.id_pedido AND
					p.estado_pedido like '%Pagado%' AND
					pd.fecha_full_destinatario like '%".$campana."%'
                                GROUP BY p.id_pedido
                                ORDER BY  p.id_pedido DESC  ";
		//echo $sql; 							
		$queryt= new Consulta($sql);	 
		$num   = $queryt->NumeroRegistros();	
		$limit = $sql_pag." LIMIT ".$reg1.",".$tampag."";
		
		$sql .= $limit ;		

		$Query = new Consulta($sql);	 ?>
		<b>Selecciona Fecha de Campaña: </b>
		<a href="pedidos_detalle.php?campana=2017-02-14">14 Febrero 2017</a> | 
		<a href="pedidos_detalle.php?campana=2017-05-08">Dia de la Madre 2017</a> |
		<a href="pedidos_detalle.php?campana=2017-06-18">Dia del Padre 2017</a> 	
               <div id="content-area">			
		<table  cellspacing="1" cellpading="1"   class='listado' >	
                    <thead>
                        <tr class="head">
                            <th class='titulo'>Nº Pedido </th>
                            <th class='titulo'>Cliente </th>
                            <th class='titulo' align="center">Producto  </th>  
                            <th class='titulo' align="center">Distrito </th>
                            <th class='titulo' align="center">Dirección </th>
			    <th class='titulo' align="center">Destinatario </th>
                            <th class='titulo' align="center">Dedicatoria </th>                            
                            <th class='titulo' align="center">Fecha Envio  </th>
                        </tr>
                    </thead>
                <tbody> <?php
		$x = 1;
		$z = 0;
		while ($row = mysqli_fetch_array($Query->Consulta_ID)){
                    
                    $destinatario = new PedidoDestinatario($row['id_pedido']);
                    $class_estado = "";
                    $marcar_fila = ""; 
                    
                    	$sqls = "SELECT  *		
				FROM pedidos_productos pp, productos p
				WHERE pp.id_pedido = '".$row['id_pedido']."' AND 
					pp.id_producto = p.id_producto					
                                GROUP BY p.id_producto ";
		 							
			$querys= new Consulta($sqls);	 
			$nums = $querys->NumeroRegistros(); ?>	
                    <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?> <?php echo $marcar_fila; ?>">
                        <td align="left" class='celda'> <?php echo $row['codigo_pedido']?></td>
                        <td align="left" class='celda'> <?php echo $row['nombre_cliente']." ".$row['apellidos_cliente']?></td>
                        <td align="left" class='celda'> <?php 
                        while ($rows = mysqli_fetch_array($querys->Consulta_ID)){                        
                        	echo " - ".$rows['nombre_producto']."<br/>";                        
                        }                        
                        ?></td> 
                         <td align="left" class='celda'> <?php echo $destinatario->__get('_distrito')->__get('_nombre'). "<br/>";  ?></td>
                         <td align="left" class='celda'> <?php echo $destinatario->__get('_direccion'); ?></td>
                         <td align="left" class='celda'> <?php echo $destinatario->__get('_nombre')." ".$destinatario->__get('_apellidos') ." - ".$destinatario->__get('_telefono'); ?></td>
                         <td align="left" class='celda'> <?php if($destinatario->__get('_id') != 0){ 
                         echo $destinatario->__get('_dedicatoria');
                         
                         } ?></td>
                        <td align="left" class='celda'> <?php if($destinatario->__get('_id') != 0){ echo $destinatario->__get('_fecha_hora')." ".$destinatario->__get('_hora'); } ?></td>
                        
                    </tr> <?php						
                if($x==0){$x++;}else{$x=0;}
                $z++;
		}?>
                </tbody>
		</table>
            </div>
		<?php	
		 
		if( $num > $tampag ){ echo paginar($_GET['pag'], $num, $tampag, "pedidos.php?pag="); }	
	}
	
	function listPedidosInsumos(){ 
		 	 
            $campana = $_GET["campana"];
            $sql = "SELECT p.id_pedido FROM pedidos p,  pedidos_destinatarios pd
                    WHERE   p.id_pedido = pd.id_pedido AND 
                            p.estado_pedido like '%Pagado%' AND
                            pd.fecha_full_destinatario like '%".$campana."%'
                    GROUP BY p.id_pedido
                    ORDER BY  p.id_pedido DESC  "; 		
            $query = new Consulta($sql); 
            $total = $query->NumeroRegistros();
            $i = 0; 
            $in = "";
            while($row = $query->VerRegistro()){
                if($i == 0 ){ $in .= $row["id_pedido"]; }else{ $in .= ",".$row["id_pedido"]; }
                $i++;
            } 

            $productos = $this->getProductosXPedidos($in); 
            $total_productos = count($productos)?>
            <!-- Modal -->
            <div class="modal fade" id="modal-insumos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Insumos</h4>
                  </div>
                  <div class="modal-body">
                      <div id="listado_insumos"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="modal fade" id="modal-filtro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Filtros</h4>
                  </div>
                  <div class="modal-body">
                    <b>Selecciona Fecha de Campaña: </b>
                    <a href="pedidos_insumos.php?campana=2017-02-14">14 Febrero 2017</a> | 
                    <a href="pedidos_insumos.php?campana=2017-05-14">Dia de la Madre 2017</a> |
                    <a href="pedidos_insumos.php?campana=2017-06-18">Dia del Padre 2017</a> |
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div>
                </div>
              </div>
            </div>

                <fieldset id="form">
                    <legend>Para ver datos primero filtra</legend>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6" style="background-color:#f4f4f4"><?php 
                        if($_GET['campana']){ ?>	
                            <h4> Pedidos X Producto: <?php echo $total; ?></h4>
                            <table cellspacing="1" cellpading="1" class="listado">	
                                <thead>
                                    <tr class="head"> 
                                        <th class='titulo' align="center" >Id  </th> 
                                        <th class='titulo' align="center">Producto  </th>  
                                        <th class='titulo' align="center">Cant </th> 
                                    </tr>
                                </thead>
                                <tbody> <?php
                                $x = 1;
                                $z = 0;
                                for ($i = 0; $i < $total_productos; $i++){ 
                                    $class_estado = "";
                                    $marcar_fila = "";    ?>	
                                    <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?> <?php echo $marcar_fila; ?>">
                                        <td align="left" class='celda'>  <?php echo $productos[$i]['id_producto']?></td>
                                        <td align="left" class='celda'> <a href="#" class="open-modal-insumos" data-toggle="modal" data-target="#modal-insumos" data-id="<?php echo $productos[$i]['id_producto']?>" data-nombre="<?php echo $productos[$i]['nombre']?>" > <?php echo $productos[$i]['nombre']?></a></td>
                                        <td align="left" class='celda'> <?php echo $productos[$i]['cantidad']?></td>
                                    </tr> <?php						
                                    if($x==0){$x++;}else{$x=0;}
                                    $z++;
                                }?>
                                </tbody>
                            </table> 
                            <br><br>
                        <h4>Pedidos X Distrito</h4>
                        <!-- pedidos por distrito -->
                        <?php  
                        $sqld= "SELECT count( DISTINCT pd.id_pedido) as total, d.id_distrito, d.nombre_distrito 
                        FROM pedidos p, pedidos_destinatarios pd, distritos d
                        WHERE p.id_pedido = pd.id_pedido 
                        AND pd.id_pedido IN (".$in.") 
                        AND pd.id_distrito = d.id_distrito
                        GROUP BY pd.id_distrito
                        ORDER BY d.nombre_distrito"; 
                        //echo $sqld;
                        $query = new Consulta($sqld);
                        $treg = $query->NumeroRegistros();

                    if($_GET["campana"]){  ?>
                        <table  cellspacing="1" cellpading="1" class="listado">	
                        <thead>
                            <tr class="head"> 
                                <th class='titulo' align="center">Id  </th> 
                                <th class='titulo' align="center">Nombre </th>  
                                <th class='titulo' align="center">Cant </th> 
                                <th class='titulo' align="center">Pedidos </th>
                            </tr>
                        </thead>
                        <tbody> <?php
                        $x = 1;
                        $z = 0;
                        while ($row = mysqli_fetch_array($query->Consulta_ID)){ 
                            $class_estado = "";
                            $marcar_fila = "";
                            $pedid = "";
                            $p = 0;  
                            $sqldi = "SELECT DISTINCT id_pedido  FROM pedidos_destinatarios 
                                WHERE id_pedido IN (".$in.") AND
                                id_distrito = '".$row['id_distrito']."'
                                GROUP BY id_pedido  "; 
                            $querydi = new Consulta($sqldi);
                            while($rowdi = $querydi->VerRegistro()){
                                $sql_prods = "SELECT GROUP_CONCAT(p.nombre_producto SEPARATOR ', ') as prodocs FROM pedidos_productos pp, productos p WHERE pp.id_producto = p.id_producto AND pp.id_pedido = '".$rowdi["id_pedido"]."' ";
                                $query_prods = new Consulta($sql_prods);
                                $row_prods = $query_prods->VerRegistro();
                                if($p == 0 ){ $pedid .= "<b>".$rowdi["id_pedido"]."</b><span style='color:#999'>[".$row_prods['prodocs']."]</span>"; }else{ $pedid .= ",<b>".$rowdi["id_pedido"]."</b><span style='color:#999'>[".$row_prods['prodocs']."]</span>"; }
                                $p++;
                            }  ?>	
                            <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?> <?php echo $marcar_fila; ?>">
                                <td align="left" class='celda'> <?php echo $row['id_distrito']?></td> 
                                <td align="left" class='celda'>  <?php echo $row['nombre_distrito']?></td> 
                                <td align="left" class='celda'>  <?php echo $row['total']?></td> 
                                <td align="left" class='celda'>  (<?php echo $pedid; ?>)</td> 
                            </tr> <?php						
                        if($x==0){$x++;}else{$x=0;}
                        $z++;
                        }?>
                        </tbody>
                    </table> <?php 
                    } ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6" style="background-color:#DDDDFF;min-height:500px"> <?php
                            
                            $i = 0; 
                            $in_productos = "";
                            for($j = 0; $j < $total_productos; $j++){
                                //if($i == 0 ){ $in_productos .= $productos[$j]["id_producto"]; }else{ $in_productos .= ",".$productos[$j]["id_producto"]; }
                                //$array_productos[$productos[$j]["id_producto"]] = array( "cantidad" => $productos[$j]["cantidad"] );
                                $i++;
                                $sql_insumos = "SELECT  i.id_insumo, i.nombre_insumo, sum(pi.cantidad) as cantidad  FROM productos_insumos pi, insumos i
                                WHERE pi.id_insumo = i.id_insumo AND pi.id_producto = '".$productos[$j]["id_producto"]."' GROUP BY i.id_insumo    ";
                                $query_insumos = new Consulta($sql_insumos);
                                while ($row = $query_insumos->VerRegistro()) {
                                    $cantidad = $productos[$j]["cantidad"] * $row["cantidad"];
                                    $array_insumos[$row["id_insumo"]]["nombre"] = $row["nombre_insumo"];
                                    $array_insumos[$row["id_insumo"]]["cantidad"] += $row["cantidad"] * $productos[$j]["cantidad"]; 
                                    //echo " <br>".$productos[$j]["nombre"];
                                }
                                
                            }   
//                            
//                            echo "<pre>";
//                            print_r($array_insumos);
//                            echo "</pre>";
//                            
                            
                            ?>
                            <h4>Insumos </h4>  
                            <table  cellspacing="1" cellpading="1"  class="listado">	
                                <thead>
                                    <tr class="head"> 
                                        <th class='titulo' align="center">Insumo </th> 
                                        <th class='titulo' align="center">Cantidad</th> 
                                        <th class='titulo' align="center">Total </th> 
                                    </tr>
                                </thead>
                                <tbody> <?php 
                                    $x = 1; 
                                    foreach ($array_insumos as $key=>$value){ ?>
                                    <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?>">
                                        <td class='celda' align="left"><?php echo $value["nombre"] ?></td>
                                        <td class='celda' align="center"><?php echo $value["cantidad"] ?></td>
                                        <td class='celda' align="center"><?php echo $value["cantidad"] ?>  </td>
                                    </tr>   <?php 
                                        if($x == 0){ $x++; }else{ $x=0; }
                                    } ?>
                                </tbody>
                            </table>
                        </div> 
                        <br>
            <?php } ?> 
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8" style="background-color:#DFEFF6;min-height:500px ">
                        <!-- Cuidado con data duplicada-->
                    <?php 

                    $sqld= "SELECT id_producto, id_pedido, COUNT(*) 
                    FROM pedidos_productos 
                    WHERE id_pedido IN (".$in.")
                    GROUP BY id_producto, id_pedido HAVING COUNT(*)>1 
                    ORDER BY id_producto, id_pedido"; 

                    $query = new Consulta($sqld);
                    $treg = $query->NumeroRegistros();

                    if($_GET["campana"] > 0){ ?>
                    <h4> Cuidado con estos datos que se duplican</h4>
                    <table  cellspacing="1" cellpading="1"  class="listado" style="border:1px solid #d4d4d4;">	
                        <thead>
                            <tr class="head"> 
                                <th class='titulo' align="center">id_pedido </th> 
                                <th class='titulo' align="center">id_producto  </th>  
                            </tr>
                        </thead>
                        <tbody> <?php
                        $x = 1;
                        $z = 0;
                        while ($row = mysqli_fetch_array($query->Consulta_ID)){ 
                            $class_estado = "";
                            $marcar_fila = "";    ?>	
                            <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?> <?php echo $marcar_fila; ?>">
                                <td align="left" class='celda'> <?php echo $row['id_pedido']?></td> 
                                <td align="left" class='celda'>  <?php echo $row['id_producto']?></td> 
                            </tr> <?php						
                        if($x==0){$x++;}else{$x=0;}
                        $z++;
                        }?>
                        </tbody>
                    </table>  
                        <?php 
                    } ?>   
                    </div> 
                    <div class="col-xs-12 col-sm-4 col-md-4" style="background-color:#f4f4f4;min-height:500px "> <?php 
                if($_GET['id_producto']){
                    $sql = "SELECT * FROM productos_insumos pi, insumos i
                            WHERE pi.id_insumo = i.id_insumo AND 
                            id_producto = '".$_GET['id_producto']."' ";
                    $Query = new Consulta($sql);	 

                    $obj_producto = new Producto($_GET['id_producto']); ?>
                    <h4>Insumos <?php $obj_producto->__get("_nombre")." (" .$_GET['cantidad']. ")"; ?></h4>
                    <table  cellspacing="1" cellpading="1" style="border:1px solid #c4c4c4; " class="listado">	
                        <thead>
                            <tr class="head"> 
                                <th class='titulo' align="center">Cant </th> 
                                <th class='titulo' align="center">Insumo  </th> 
                                <th class='titulo' align="center">Total </th> 
                            </tr>
                        </thead>
                        <tbody> <?php
                        $x = 1;
                        $z = 0;
                        while ($row = mysqli_fetch_array($Query->Consulta_ID)){ 
                            $class_estado = "";
                            $marcar_fila = "";  ?>	
                            <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?> <?php echo $marcar_fila; ?>">
                                <td align="left" class='celda'> <?php echo $row['cantidad']?></td> 
                                <td align="left" class='celda'>  <?php echo $row['nombre_insumo']?></td>
                                <td align="left" class='celda'>  <?php echo $row['cantidad'] * $_GET['cantidad'] ?></td>
                            </tr> <?php						
                        if($x==0){$x++;}else{$x=0;}
                        $z++;
                        }?>
                        </tbody>
                    </table> <?php 
                    } ?>
                    </div>    
                </div>    
            </fieldset> <?php
	}
        
        /*
    Este metodo generar el PDF de la guía de entrega y se usa en en Pedidos->addAdminPedidos, Pedidos->updatePedidos(), Secciones->confirmacion()
    */    
                        
}