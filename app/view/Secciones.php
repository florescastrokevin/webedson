<?php 
class Secciones{	
	
	private $_cuenta;
	private $_pedido;
	private $_paypalCar = '';
	
	public function __construct( Cuenta $cuenta = NULL , Pedido $pedido = NULL){
		$this->_cuenta = $cuenta;
		$this->_pedido = $pedido;
	}
		
	public function setPaypalCar(){
		
		$carrito = $this->_cuenta->getCliente()->getCarrito();
		$content = $carrito->getContent();
		$i = 1;
		
		reset($content);
		
		//pre($content);
		
		while( list($key,) = each( $content ) ){
		$opc_paypal = '';
		$producto = new Producto((int)$key);
		$precio = $producto->__get("_precio_producto");
		$opciones = $content[$key]['opciones'];
		$preciocmp = 0;
		$cmopts= 0;
		//paypal -> productos complementos
		if(is_array($opciones) && count($opciones)>0 ):
		
			//$opc_paypal.= '<input type="hidden" name="on'.($i-1).'" value="Complementos">';
			
			foreach( $opciones as $id=>$cantidad ):
				
				$po = new Producto($id);				
				$preciocmp += $po->__get("_precio_producto") * $cantidad;
				//$opc_paypal.= '<input type="hidden" name="on0'.$cmopts.'" value="'.utf8_encode($po->__get("_nombre")).'">';
				//$opc_paypal.= '<input type="hidden" name="os'.$cmopts.'" value="'.round( ($po->__get("_precio_producto") * $cantidad)  , 2 ).'">';		
			//$cmopts++;
			endforeach;
		
		endif; 
		// sin complementos
		$this->_paypalCar.= '
			<input type="hidden" name="item_number_'.$i.'" value="'.$i.'">
			<input type="hidden" name="item_name_'.$i.'" value="'.utf8_encode($producto->__get("_nombre")).'">
			'.$opc_paypal.'<input type="hidden" name="quantity_'.$i.'" value="'.$content[$key]['cantidad'].'">
			<input type="hidden" name="amount_'.$i.'" value="'.round($precio + $preciocmp,2) .'">';
		$i++;
		}
		
	}
	
	public function VerCarrito( $view = '' ){
				
				$carrito = $this->_cuenta->getCliente()->getCarrito();
				$content = $carrito->getContent();
				
				$f = ($view=='cesta')?'':'_c';
				
				
				
				if(is_array($content) && sizeof($content) > 0){?>
                   	 	<input type="hidden" id="cambio" value="<?php echo TIPO_CAMBIO?>">
                        <div id="tabla">
                            <ul id="tabla_top">
                                <li class="td1<?php echo $f?>">Producto</li>
                                <li class="td2<?php echo $f?>"><?php echo ($view=='cesta')?'Precio Unitario':'Pre. Unit.'?></li>
                                <li class="td3<?php echo $f?>"><?php echo ($view=='cesta')?'Cantidad':'Cant.'?></li>
                                <li class="td4<?php echo $f?>">Subtotal</li>
                            </ul>
                            <ul id="tabla_cont">
                                <?php 
									$totalP = 0;			
									reset($content);
									while( list($key,) = each( $content ) ){
									$producto = new Producto((int)$key ,$idioma);
									$precio = $producto->__get("_precio_producto");
									$imagenes = $producto->__get("_imagenes");
									$opciones = $content[$key]['opciones'];
									$preciocmp = 0;
							    ?>
                                <li>
                                    <ul>
                                        <li class="td1<?php echo $f?> alignLeft">
                                            <div class="img_cesta<?php echo $f?>">
													<?php
                                                    $img = ($view=='cesta')?$imagenes[0]['middle']:$imagenes[0]['thumbnail'];
                                                    ?>
                                                &nbsp;<a href="<?php echo str_replace(" ","-",$producto->__get("_nombre"));?>"><img alt="" src="<?php echo _catalogo_ . $img?>" /></a>
                                            </div>
                                            <div class="info_cesta<?php echo $f?>">
                                                <div class="nameCar"><?php echo $producto->__get("_nombre")?></div>
                                                <?php if(is_array($opciones) && count($opciones)>0 ): ?>
                                                <!-- INICIA OPCIONES -->   
                                                <div class="prod_agregado">
                                                    <ul>
                                                        <?php foreach( $opciones as $id=>$cantidad ):
														
																$prod = new Producto( $id );
																$imgsc = $prod->__get("_imagenes");
																$preciocmp += $prod->__get("_precio_producto") * $cantidad;
														
														?>
                                                        <li>
                                                            <div class="wrap_agregado">
                                                            
                                                                &nbsp;<img src="<?php echo _catalogo_ . $imgsc[0]['middle']?>" alt="" />
                                                            </div>
                                                            <span><?php echo $cantidad;?> <?php echo $prod->__get("_nombre")?></span>
                                                        </li>
                                                        <?php endforeach;?>
                                                    </ul>
                                                </div>
                                                 <!-- FIN OPCIONES -->	
                                                <?php endif;?>
                                                <?php if($view=='cesta'){?>
                                                <span class="eliminar" id="<?php echo $key?>"><a href="javascript:;">x eliminar</a></span>
                                                <?php }?>
                                            </div>
                                        </li>
                                        <li class="td2<?php echo $f?>">
                                            <span class="precio_prod">$<?php echo number_format($precio + $preciocmp,2)?></span>
                                        </li>
                                        <li class="td3<?php echo $f?>">
                                            <?php if($view=='cesta'){?>
                                            <input type="text" class="solo_numero kcarro" value="<?php echo $content[$key]['cantidad']?>" />
                                            <?php }else{?>
                                            <span><?php echo $content[$key]['cantidad']?></span>
                                            <?php }?>
                                        </li>
                                        <li class="td4<?php echo $f?>">
                                            <span class="subtotal">$<?php echo number_format(($precio + $preciocmp) * $content[$key]['cantidad'],2)?></span>
                                        </li>
                                    </ul>
                                </li>
                				<?php 
									}
								?>                
                            </ul>
                        </div>
                        
                        <div id="total_precio<?php echo $f?>">
                            <?php                            
								$ubigeo = new Ubigeos();
								$distritos = $ubigeo->getDistritosConCobertura(1401);							
							?>                            
                            <div class="tpBox" id="subT">
                                <div class="tp boxright"><span>$<?php echo number_format($carrito->getAmount(),2)?></span></div>
                                <div class="tp textright">Subtotal:</div>
                            </div>
                            
                            <?php if($view=='cesta'){ /*?>
                            <div class="tpBox" id="subT">
                            	<div class="tp boxright combo">
                                
								<select id="slc_envio_cesta" name="distrito">
                                    <option value="">Elegir distrito ..</option>
                                    <?php foreach ($distritos as $distrito):?>
                                        <option <?php if( $_SESSION['envio']['distrito'] == $distrito['id'] ){echo 'selected="selected"'; $tarifa = $distrito['tarifa'];}?> title="$<?php echo $distrito['tarifa'];?>"   value="<?php echo $distrito['id'];?>"><?php echo str_replace('Ã‘','Ñ',$distrito['nombre']);?></option>   
                                    <?php endforeach;?>          
                                </select> <b>Lima, Perú</b>
                                </div>
                                <div class="tp textright txt">Delivery:</div>
                                
                            </div>
                        	 <?php */}?>
                            
                           
                            <?php if($view=='cesta'){/*?> 
                            <div class="tpBox" id="flete">
                               
                                <div class="tp porcalcular boxright"><span><?php echo (!empty($tarifa))?'$'.$tarifa:'por calcular';?></span></div>
                                <div class="tp textright flete">Gastos de envío (Flete):</div>
                            </div> 
                            
                           
                           <?php
                           */
						   
						   $total_dolares = number_format(($tarifa+$carrito->getAmount()),2);
						   $total_soles = number_format((($tarifa+$carrito->getAmount())*TIPO_CAMBIO),2);
						   
						   
						   ?>
                           
                            
                            <div class="tpBox" id="flete">
                                <div id="numdolar" class="tp total_dolares boxright"><span class="pre">$<?php echo $total_dolares?></span></div>
                                <div class="tp textright">Total ($):</div>
                            </div> 
                             
                             <div class="tpBox" id="flete">
                                <div id="numsol"class="tp total_soles boxright"><span class="pre">S/.<?php echo $total_soles?></span></div>
                                <div class="tp textright">Total (S/.):</div>
                            </div> 
                               
								<?php
								}else{
								
								$lugar = str_replace('Ã‘','Ñ',$this->_pedido->getDestinatario()->__get('_distrito')->__get('_nombre'));
								$tarifa = $this->_pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio');

								?>
                                
                                <div class="tp boxright"><span>$ <?php echo number_format($tarifa,2)?></span></div>                                <div class="tp textright flete">Gastos de envío (<?php echo $lugar?>):</div>
                            
                            	<div class="tpBox confirm" id="flete">				                	
				                    <div class="tp boxright totalprecio"><span>$ <?php echo number_format(($carrito->getAmount() + $tarifa),2);?></span></div>
                                    <div class="tp textright flete totaltxt">Total ($):</div>
				                </div>
                                <div class="tpBox confirm" id="flete">				                	
				                    <div class="tp boxright totalprecio"><span>S/. <?php echo number_format((($carrito->getAmount() + $tarifa )*TIPO_CAMBIO ),2);?></span></div>
                                    <div class="tp textright flete totaltxt">Total (S/.):</div>
				                </div>
								<?php
								}
								?>
                            <div class="btn-submit"><input type="submit" name="button" id="realizarcompra" value=""/></div>
                        </div>
                    <?php }else{?>
                    	
                        <div id="tabla">
                            <ul id="tabla_top">
                                <li class="td1">Producto</li>
                                <li class="td2">Precio Unitario</li>
                                <li class="td3">Cantidad</li>
                                <li class="td4">Subtotal</li>
                            </ul>
                            <ul id="tabla_cont">
                                                                
                				                
                            </ul>
                        </div>
                        
                        <div id="total_precio">
                                                        
                            <div class="tpBox" id="subT">
                                <div class="tp boxright"><span>$0.00</span></div>
                                <div class="tp textright">Subtotal:</div>
                            </div>                         
                        </div>
                       
                       
                       
                        
                    <?php }
                  
	}
	
	public function productosDestacados(){
		$obj = new Productos();
		$prod = $obj->getProductosDestacados();    
		
		$param = explode('n=',$_SERVER['QUERY_STRING']);
        $href = $param[1];
		      
	?> 
        <div class="pageTop">
        <h2>PRODUCTOS DESTACADOS</h2>
        <div id="compartir">
            <div id="goglemas">
            <div class="g-plusone" data-size="medium" data-href="<?php echo _url_web_ . $href?>"></div>
            </div>
            <div id="fb">
                <div class="fb-like" data-href="<?php echo _url_web_ . $href?>" data-layout="button_count"  data-width="450" data-show-faces="false" data-send="false"></div>
                <div id="fb-root"></div>
            </div>
            <div id="tw">
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo _url_web_ . $href?>" data-lang="es">Twittear</a>
            </div>
        </div>
        </div>
        <div id="destacados">
        <ul id="listado_catalogo">
            <?php            
                foreach ($prod as $p):
                    $producto = new Producto($p['id'],$idioma);
                    $imagenes = $producto->__get("_imagenes");
			?>
            <li>               
                    <div class="imgdestacado">
                        <?php
						if(count($imagenes)>0  && file_exists(_link_file_ . 'middle_'.$imagenes[0]['imagen'] )){?>						
						<a href="<?php echo str_replace(" ","-",$producto->__get("_nombre")); ?>">
                        &nbsp;<img src="<?php echo _catalogo_ . 'middle_'.$imagenes[0]['imagen']; ?>"/>
						</a>
						<?php }else{
						?>
						<a href="<?php echo str_replace(" ","-",$producto->__get("_nombre")); ?>">
                        &nbsp;<img src="<?php echo _catalogo_ ?>not_image_disponible.jpg" />
						</a>
						<?php
						} ?>  
                    </div>
                    <div class="nameProd"><?php echo $producto->__get("_nombre");?></div>
                    <div class="priceProd">
                        <?php if( $producto->__get("_dscto") != "" ){?>                       
                        <span class="oldPrice">$<?php echo $producto->__get("_precio_old");?></span>
                        <span class="desc">-<?php echo $producto->__get("_dscto")?>%</span>
                        <br/>
                        <?php }?>
                        <span>$<?php echo number_format($producto->__get("_precio_producto"),2); ?></span>
                        <span class="soles">(s/.<?php echo number_format($producto->__get("_precio_producto")*TIPO_CAMBIO,2); ?>)</span>
                    </div>
                    <a href="<?php echo str_replace(" ","-",$producto->__get("_nombre")); ?>" class="btn_detalle"></a>
                    <form name="envio_carrito" class="form">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id_producto" value="<?php echo $producto->__get("_id")?>">
                    <input type="hidden" name="cantidad" value="1">
                    
                    <a href="#add-<?php echo str_replace(" ","-",$producto->__get("_nombre")); ?>" class="addCarrito btn_compra various fancybox.ajax" value =""></a>  
                    </form>
            </li>
            <?php endforeach;?>
		</ul>                    
        </div>
    <?php    
	}
	
	public function loMasBuscado(){
		?>
        <div class="pageTop">
        <h2>LO MAS BUSCADO</h2>
        </div>
        <div id="masbuscados">
        	<?php
			$arr = Busquedas::getTopBusqueda();
			if(is_array($arr)&&count($arr) > 0 ){
				
					for ($i = 0; $i < count($arr); $i++) {
						$cad.='<a id="q' . url_frienly($arr[$i]['id'], 1) . '" href="'._url_web_.'?q=' . str_replace(' ','+',$arr[$i]['texto_busqueda_top']) . '"><span>' . utf8_decode(str_replace('-',' ',$arr[$i]['texto_busqueda_top'])) . '</span></a> | ';
					}
				
				echo substr($cad,0,-2);
				
			}
			?>
        </div>
        <?php
	}
	
	public function productosConOfertas(){
		
		$obj = new Productos();
        $prod = $obj->getProductosOfertas();          
	?> 
       
        <div class="pageTop">
        <h2>OFERTAS</h2>
        </div>
        <div id="destacados">
        <ul id="listado_catalogo">
            <?php            
                foreach ($prod as $p):
                    $producto = new Producto($p['id'],$idioma);
                    $imagenes = $producto->__get("_imagenes");
			?>
            <li>               
                    <div class="imgdestacado">
                        <?php
						if(count($imagenes)>0  && file_exists(_link_file_ . 'middle_'.$imagenes[0]['imagen'] )){?>						
						<a href="<?php echo str_replace(" ","-",$producto->__get("_nombre")); ?>">
                        &nbsp;<img src="<?php echo _catalogo_ . 'middle_'.$imagenes[0]['imagen']; ?>"/>
						</a>
						<?php }else{
						?>
						<a href="<?php echo str_replace(" ","-",$producto->__get("_nombre")); ?>">
                        &nbsp;<img src="<?php echo _catalogo_ ?>not_image_disponible.jpg" />
						</a>
						<?php
						} ?>  
                    </div>
                    <div class="nameProd"><?php echo $producto->__get("_nombre");?></div>
                    <div class="priceProd">
                        <?php if( $producto->__get("_dscto") != "" ){?>                       
                        <span class="oldPrice">$<?php echo $producto->__get("_precio_old");?></span>
                        <span class="desc">-<?php echo $producto->__get("_dscto")?>%</span>
                        <br/>
                        <?php }?>
                        <span>$<?php echo number_format($producto->__get("_precio_producto"),2); ?></span>
                         <span class="soles">(s/.<?php echo number_format($producto->__get("_precio_producto")*TIPO_CAMBIO,2); ?>)</span>
                    </div>
                    <a href="<?php echo str_replace(" ","-",$producto->__get("_nombre")); ?>" class="btn_detalle"></a>
                    <form name="envio_carrito" class="form">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id_producto" value="<?php echo $producto->__get("_id")?>">
                    <input type="hidden" name="cantidad" value="1">
                    
                    <a href="#add-<?php echo str_replace(" ","-",$producto->__get("_nombre")); ?>" class="addCarrito btn_compra various fancybox.ajax" value =""></a>  
                    </form>
            </li>
            <?php endforeach;?>
		</ul>                    
        </div>
    <?php  
		
	}
	
    // STEP ENTREGA
    public function Entrega(){
		
		$ubigeo = new Ubigeos();
		$distritos = $ubigeo->getDistritosConCobertura(1401);	
		if(isset($_POST['distrito'])) $_SESSION['envio']['distrito'] = $_POST['distrito'];
		
	?>	
		<div id="pagina">
			<div class="pageTop">
				<h1><img src="aplication/webroot/imgs/ico_compra.jpg" alt="" /> Realizar Compra - Paso 1:</h1>
				<ol>
					<li class="active hover"><a>Datos De Entrega</a></li>
					<li><a>Datos De Pago</a></li>
					<li><a>Confirmar Pedido</a></li>
				</ol>
			</div>			
			<form name="envio" action="pedido.php?step=pago" method="post" id="compra1" onsubmit=" return validate_entrega(this);">
                <input type="hidden" name="mapa_latitud" id="mapa_latitud" value="-12.1028477"> 
                <input type="hidden" name="mapa_lontitud" id="mapa_lontitud" value="-77.0373537,15"> 
            
            <input type="hidden" name="state" value="envio">
            
	            <div class="cuerpo_sec" id="cd_sec">
	            	<h3>Datos del destinatario:</h3>
	                <p>Ingrese los datos a quien deseas que le llegue el regalo:</p>
	                <div id="cd_inputs">
	                	<ul id="inputs_envio">
                        <li>
                        <label for="nombre">Nombres: <em>*</em></label><br/><input type="text" name="nombre" id="nombre" value="<?php echo $_SESSION['envio']['nombre'];?>" /></li>
	                	<li>
                        <label for="apellidos">Apellidos: <em>*</em></label><br/><input type="text" name="apellidos" id="apellidos" value="<?php echo $_SESSION['envio']['apellidos'];?>" /></li>
	                	<li>
                        <label for="telefono">Teléfono: <em>*</em></label><br/><input type="text" name="telefono" id="telefono" value="<?php echo $_SESSION['envio']['telefono'];?>" />
                        </li>	
	                </div>
                    <br/><br/>
                    <h3>Fecha y hora de entrega:</h3>
	                <p>Ingrese la fecha y hora que desea que llegue su regalo:</p>
                    <div id="cd_inputs">
	                	<ul id="inputs_envio">
                        <li>
                        <label for="nombre">Fecha y hora: <em>*</em></label><br/><input type="text" readonly="readonly" name="fecha_hora" id="fecha_hora" value="<?php echo fecha_hora_sql_html($_SESSION['envio']['fecha_hora']);?>" /><br/><p class="nota"><strong>Nota:</strong> La hora que nos indica en este registro es tomada como referencia, la movilidad puede llegar 1/2 hora más temprano a 1/2 hora después de la hora que nos indique.
                        <br/></p></li>
                        </ul>
	                </div>
                    
	            </div>
	            <div class="cuerpo_sec cuerpo_sec2" id="cd_sec">
	            	<h3>Dirección del destinatario :</h3>
	            	<p>Ingrese la dirección donde llegará el regalo:</p>
	            	<div id="cd_inputs">
	            		<ul id="inputs_envio">
                        <li>
                        <label>Distrito: <em>*</em></label> <br/>
	                	<select name="distrito">
	                		<option value="">Elegir distrito ..</option>
							<?php foreach ($distritos as $distrito):?>
								<option <?php if( $_SESSION['envio']['distrito'] == $distrito['id'] ){echo 'selected="selected"';}?>   value="<?php echo $distrito['id'];?>"><?php echo str_replace('Ã‘','Ñ',$distrito['nombre']);?></option>   
                            <?php endforeach;?>          
	                	</select> <b>Lima, Perú</b></li>
	                	 <p class="nota"><strong>Nota:</strong> Indicar correctamente el distrito. </p>
                        <li>
                        
                         
                        <label for="direccion">Dirección: <em>*</em></label><br/>
                        <textarea name="direccion" id="direccion" class="direccion" /><?php echo $_SESSION['envio']['direccion'];?></textarea>
                        
                        <p class="nota"><strong>Nota:</strong> Indique si es casa o empresa.</p>
                        
                       </li>	
                        <li>
                        <label for="referencia">Referencia: <em>*</em></label><br/>
                        <textarea name="referencia" id="referencia" class="referencia" /><?php echo $_SESSION['envio']['referencia'];?></textarea><br/>
                        <p class="nota"><strong>Nota:</strong> Indicar correctamente las calles, avenidas principales, colegios, etc que sirva como referencia.</p>
                        </li>	
                        </ul>
	            	</div>
	            </div>                
                <div class="cuerpo_sec cuerpo_sec2" id="cd_sec">
                	<br/>
	            	<h3>Dedicatoria de la tarjeta :</h3>
	            	<p>Ingrese un texto para la dedicatoria del regalo, recuerda colocar tus iniciales a la parte final de la dedicatoria:</p>
	            	<div id="cd_inputs">
	            		<ul id="inputs_envio">
                        <li>
                        <label for="dedicatoria">Dedicatoria: <em>*</em></label><br/>
                        <textarea name="dedicatoria" maxlength="281" id="dedicatoria" class="dedicatoria" /><?php echo $_SESSION['envio']['dedicatoria'];?></textarea>
                        <p class="notaobs">Contador de caracteres (máximo 281)</p>                        
                        <p class="nota"><strong><a class="fancybox.ajax mensajes" href="dedicatoria_mensajes.php">¿Sin inspiración? Prueba nuestras sugerencias.</a></strong> </p>
                        <br/>
                        <!-- <p class="see"><a class="fancybox.ajax tarjeta" href="preview.php"><img src="<?php echo _imgs_ . 'tarjeta.png'?>"> Ver como queda mi tarjeta</a></p> -->
                        
                        
                        </li>	
                        </ul>
	            	</div>                    
	            </div>
                <?php
                $direccion_latitud="-12.1028477";
                $direccion_longitud="-77.0373537,15";
                ?>
                <div style="clear: both;">
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJq-y2QxyZn_chMbmzNt0AHynzwQmeGP4" type="text/javascript">
                    </script>    
                    <div id="map_canvas" style="height: 350px;"></div>
                </div>
                
	            <div class="cleaner"></div>
	            <div id="btn"><input type="submit" name="" id="btn_continuar" value="" /></div>
            </form>
			<div class="cleaner"></div>
		</div>
        <script type="text/javascript">
                                        // When the window has finished loading create our google map below
                                        google.maps.event.addDomListener(window, 'load', init);

                                        function openInfoWindow(marker) {
                                            var markerLatLng = marker.getPosition();
                                        
                                            $("#mapa_latitud").val(markerLatLng.lat());
                                            $("#mapa_lontitud").val(markerLatLng.lng());
                                            alert(markerLatLng.lat()+'|'+markerLatLng.lng());
                                        }
                             
                                        function init() {
                                          
                                            var mapOptions = {
                                     
                                                zoom: 15,
                                                //center: new google.maps.LatLng(-12.080051, -76.970566), 
                                                center: new google.maps.LatLng(<?php echo $direccion_latitud ?>,<?php echo $direccion_longitud ?>),
                                                scrollwheel: false,
                                               
                                            };

                                            var mapElement = document.getElementById('map_canvas');
                                            var map = new google.maps.Map(mapElement, mapOptions);                

                                            var marker = new google.maps.Marker({
                                                //position: new google.maps.LatLng(-12.080051, -76.970566),
                                                position: new google.maps.LatLng(<?php echo $direccion_latitud ?>,<?php echo $direccion_longitud ?>),
                                                draggable: true,
                                                map: map,
                                                title: '<?//php echo NOMBRE_SITIO;?>',
                                                //icon: 'images/bg_cursor.png'
                                            });

                                            /********** INICIO ******************/
                                           
                                            var infowindow = new google.maps.InfoWindow({
                                              //content:"ARTEMESA!"
                                              content : "<p style='text-align: center;margin: 0px;font-weight: bold;'>DON REGALO</p>"
                                                        
                                            });

                                            infowindow.open(map,marker);

                                            google.maps.event.addListener(marker, 'dragend', function(){ openInfoWindow(marker); });
                                            google.maps.event.addListener(marker, 'click', function(){ openInfoWindow(marker); });
                                            /********** FIN ******************/
                                        }
        </script>
		<?php
	} 
        
	// STEP PAGO
	public function Pago(){
			?>
            <div id="pagina">
            <div class="pageTop">
				<h1><img src="aplication/webroot/imgs/ico_compra.jpg" alt="" /> Realizar Compra - Paso 2:</h1>
				<ol>
					<li class="hover"><a href="pedido.php">Datos De Entrega</a></li>
					<li class="active"><a>Datos De Pago</a></li>
					<li><a>Confirmar Pedido</a></li>
				</ol>
			</div>	
            <form action="pedido.php?step=confirmacion" method="post" id="compra2" onsubmit="return validate_pago(this);">
				 <input type="hidden" name="state" value="pago">
                
                <div id="cd2_cuerpo">
					<!--SECCION 1-->
					<div class="cuerpo_sec" id="cd_sec">
						<h3>Comprobante de pago:</h3>
						<p>El comprobante sólo se le enviará a su correo:</p>

						<div id="cd_inputs">
							<label>Comprobante: <em>*</em></label><br/>                            
                            
                            <select name="comprobante" id="comprobante">
                                <option value="Boleta" <?php if($_SESSION['pago']['tipo']=='Boleta')echo 'selected="selected"';?>>BOLETA</option>
                                <option value="Factura" <?php if($_SESSION['pago']['tipo']=='Factura')echo 'selected="selected"';?>>FACTURA</option>
                            </select><br/>
							
                            <div id="caja1">
				<ul id="inputs_envio">
                                <li><label for="nombre">DNI: <em>*</em></label><br/><input type="text" name="dni" id="dni" value="<?php echo $_SESSION['pago']['dni_boleta']?>" /></li>
                                <li><label for="nombre">Nombre: <em>*</em></label><br/><input type="text" name="nombre" id="nombre" value="<?php echo $_SESSION['pago']['nombre_boleta']?>" /></li>
                                <li><label for="direccion">Dirección: <em>*</em></label><br/><input type="text" name="direccionb" id="direccionb" value="<?php echo $_SESSION['pago']['direccion_boleta']?>" /></li></ul>
                                <br>				<p><b><font size="2" color="red">Elige tu opci&oacute;n de pago</font> &gt;&gt;&gt;</b></p>
                                <p><font size="2" color="red">Y dale click en Continuar.</font></p>
                            </div>			
                            <div id="caja2">
								<ul id="inputs_envio"><li>
                                <label for="razonsocial">Razon Social: <em>*</em></label><br/><input type="text" name="razonsocial" id="razonsocial" value="<?php echo $_SESSION['pago']['razon_social']?>" /></li><li>
								<label for="ruc">RUC: <em>*</em></label><br/><input type="text" name="ruc" id="ruc" value="<?php echo $_SESSION['pago']['ruc']?>" /></li><li>
								<label for="direccion1">Dirección: <em>*</em></label><br/><input type="text" name="direccionf" id="direccionf" value="<?php echo $_SESSION['pago']['direccionf']?>" /></li><li></ul>
							</div>
						</div>
					</div>
					<!--FIN SECCION-->

					<!--SECCION 2-->
					<div class="cuerpo_sec cuerpo_sec2" id="cd_sec2">
						<h3>Forma de pago:</h3>
						<p>Elige la Forma de Pago:</p><br/>
						
                        <?php
                        $fp = new FormasPago();
                        $formasPago = $fp->getFormasPago();							
                        $i = 0;
                        foreach($formasPago as $formaPago):
							?>                                
                            <div class="formas_pago <?php if( $_SESSION['pago']['id'] == $formaPago['id'] ) echo ' active';?>">                                
                                
                                <div class="fp1">
                                <div class="option">
                                <input name="pago" type="radio" id="envio_0" <?php if( $_SESSION['pago']['id'] == $formaPago['id'] ) echo 'checked="checked"';?>  value="<?php echo $formaPago['id']?>" />
                                <img alt="" class="fp_img1" src="<?php echo _catalogo_.$formaPago['imagen']?>" />
                                </div>
                                </div>
                                <div class="fp2">
                                <?php echo str_replace('../','',nl2br($formaPago['descripcion']))?>
                                </div>
								<div class="cleaner"></div>                                
                            </div>    
                            <?php
                        endforeach;							
			?> 
                        
                        </div>
					<!--FIN SECCION 2-->
					<div class="cleaner"></div>
					<!--BOTONES-->
					<div id="btn" style="width: 50%; margin-top: -48%;">
                    <input onclick="" type="button" id="btn_volver" value="">
                    <input type="submit" name="" id="btn_continuar" value="" />
                    </div>
				</div>
			</form>  
            <div class="cleaner"></div> 
           </div>         
			<?php			
	}
    
	// STEP CONFIRMACION
	public function Confirmacion( ){
		$pedido = $this->_pedido;
		$carrito = $this->_cuenta->getCliente()->getCarrito();
		$obj_forma_pago  = new FormasPago();
					 
		?>
        <div id="pagina">
			<div class="pageTop">
				<h1><img src="aplication/webroot/imgs/ico_compra.jpg" alt="" /> Realizar Compra - Paso 3:</h1>
				<ol>
					<li class="hover"><a href="pedido.php">Datos De Entrega</a></li>
					<li class="hover"><a href="pedido.php?step=pago">Datos De Pago</a></li>
					<li class="active"><a>Confirmar Pedido</a></li>
				</ol>
			</div>
			<!--<form action="" method="post" id="compra2" onsubmit="">-->
				<div id="cd2_cuerpo">
					<!--SECCION 1-->
					<div class="cuerpo_sec" id="cd_sec">
						<h3>Pedido:</h3>
						<p>Revisa tu pedido antes de efectuar la compra. Los Gastos de Envío han sido calculados en base a tus Datos de Envío.</p>
						<div id="carrito_compras_paso3">
                            <?php $this->VerCarrito();?>
				        </div>
						
                  <?php       
                        switch ( $pedido->getMetodoPago()->__get('_nombre') ){
						  case 'Paypal':							
							$this->setPaypalCar();
							$detail = $this->_paypalCar;
							$direc_envio = '';
							$direc_fac = '';
						  break;
						  
						  case 'Visa':						
							
							$visa = new Visa();						
							$term.= '<h3>T&eacute;rminos y Condiciones : </h3><div id="terminos_condiciones">'.$visa->getTerminosYCondiciones().'</div>';
							$term.= '<div id="terminos_visa">';
							$term.= '<input type="checkbox" id="term" name="term"> Acepto todos los términos y condiciones.';
							$term.= '</div>';					
						  break;
					}
		
		
		?>
                        
                        
                        <?php echo $term;?>
					</div>
					<!--FIN SECCION-->

					<!--SECCION 2-->
					<div class="cuerpo_sec cuerpo_sec2" id="datos">
						<h3>Datos de Entrega: <a title="Editar" class="editarPedido" href="pedido.php">Editar</a></h3> 
						<p><b>Forma de Envio:</b> DELIVERY</p>
	                    <p><b>Datos de Quien recibe el regalo:</b></p>
 
	                    <table width="439" border="0">
	                    	<tr>
	                    		<td width="66" align="right" valign="top">Nombres:</td>
	                    		<td width="97" valign="top"> <?php echo $pedido->getDestinatario()->__get("_nombre");?></td>
	                    		<td align="right" valign="top" >Distrito:</td>
	                    		<td><?php echo str_replace('Ã‘','Ñ',$pedido->getDestinatario()->__get("_distrito")->__get('_nombre'));?> , Lima, Perú</td>
	                    	</tr>                            
                            <tr>
	                    		<td align="right"   valign="top">Apellidos:</td>
	                    		<td valign="top"><?php echo $pedido->getDestinatario()->__get("_apellidos");?></td>
	                    		<td width="61" align="right" valign="top" >Dirección:</td>
	                    		<td width="197">
								<?php echo $pedido->getDestinatario()->__get("_direccion");?>
                                </td>
                                
	                    	</tr>
	                    	<tr>
	                    		<td align="right" valign="top">Teléfono:</td>
	                    		<td valign="top"><?php echo $pedido->getDestinatario()->__get("_telefono");?></td>
	                    		<td width="61" align="right" valign="top" >Referencia:</td>
	                    		<td width="197"><?php echo $pedido->getDestinatario()->__get("_referencia");?></td>
	                    	</tr>
	                    </table>
                        <p><b>Fecha de Entrega:</b> <?php echo fecha_hora_sql_html($pedido->getDestinatario()->__get("_fecha_hora"));?></p>
                        
                       
                        <p style="float:left;"><b>Dedicatoria de la tarjeta: </b> <div class="msjededicatoria"><?php echo nl2br(str_replace("  ",'&nbsp;&nbsp;',$pedido->getDestinatario()->__get("_dedicatoria")));?></div></p>
                        
                       
                        
	                    <br /><br /><br /><br /><br />
	                  	<h3>Datos de Pago: <a title="Editar" class="editarPedido" href="pedido.php?step=pago">Editar</a></h3>                         
                        <table width="438" border="0" class="comprobantefix">
					  		<tr>
					  			<td width="131" align="left"><strong>Comprobante de Pago:</strong></td>
					  			<td width="297" valign="top"><?php echo $pedido->getComprobantePago()->__get("_tipo");?></td>
					  		</tr>
					  		<?php  if ($pedido->getComprobantePago()->__get("_tipo") == "Boleta"){ ?>
                            <tr>
					  			<td align="right">DNI:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_dni");?></td>
					  		</tr>
                            <tr>
					  			<td align="right">Nombre:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_nombre");?></td>
					  		</tr>
					  		<tr>
					  			<td align="right">Dirección:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_direccionb");?></td>
					  		</tr>
                            <?php }else{?>
                            <tr>
					  			<td align="right">Razón social:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_razon_social");?></td>
					  		</tr>
					  		<tr>
					  			<td align="right">RUC:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_ruc");?></td>
					  		</tr>
                            <tr>
					  			<td align="right">Dirección:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_direccionf");?></td>
					  		</tr>
                            <?php }?>
		              	</table>
                    <div class="fomaspagofix">
                        <p><strong>Forma de Pago:</strong></p>
                        <div class="formas_pago">
                            <div class="fp1">
                                <img class="fp_img1" src="<?php echo _catalogo_.$pedido->getMetodoPago()->__get('_imagen');?>"/>
                            </div>
                            <div class="fp2">
                                <?php echo str_replace('../','',nl2br($pedido->getMetodoPago()->__get('_descripcion')));?>
                            </div>
                            <div class="cleaner"></div>
                        </div>
                    </div>
                    </div>
                    <!--FIN SECCION 2-->
                    <div class="cleaner"></div>
                    <!--BOTONES-->                    
                <div id="btn"><?php 	
                    $obj_forma_pago->classFormaPago($pedido->getMetodoPago()->__get('_nombre'),number_format( $carrito->getAmount(),2), number_format($pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio'),2), $detail);
                    echo $obj_forma_pago->generarBoton($pedido->getId()); ?>                  
                </div>
            </div>
                <!--</form>-->
            <div class="cleaner"></div>
            </div> <?php
            $pedido->generarGuiaEntrega();
	}
	
	// FINALIZADO
	public function Finalizado(){
	
	$pedido = $this->_pedido;
	$carrito = $this->_cuenta->getCliente()->getCarrito();
	
	?>
    <div id="pagina">
			<div class="pageTop">
				<h1><img src="aplication/webroot/imgs/ico_compra.jpg" alt="" /> Pedido realizado con éxito!</h1>
			</div>
			<!--<form action="" method="post" id="compra2" onsubmit="">-->
				
                <div id="cd2_cuerpo">
					<!--SECCION 1-->
                    	<br/>
                        <div id="msje_finalizado">
                            <p><h2>Gracias por su compra.</h2></p>
                            <p>Pague su compra haciendo una transferencia bancaria o depositando el monto total al siguiente número de cuenta:</p>
                            <div class="formas_pago">
                            <div class="fp1">
                                <img class="fp_img1" src="<?php echo _catalogo_.$pedido->getMetodoPago()->__get('_imagen');?>"/>
                            </div>
                            <div class="fp2">
                                <?php echo str_replace('../','',nl2br($pedido->getMetodoPago()->__get('_descripcion')));?>
                            </div>
                            </div>
                        </div>
                        <br class="cleaner"/>
                    	
                        
					<div class="cuerpo_sec" id="cd_sec">
						<h3>Pedido Nro. <?php echo $pedido->getId()?></h3>
                        <p>A continuación le detallamos su pedido.</p>
						<div id="carrito_compras_paso3">
                            <?php $this->VerCarrito();?>
				        </div>
						
					</div>
					<!--FIN SECCION-->

					<!--SECCION 2-->
					<div class="cuerpo_sec cuerpo_sec2" id="datos">
						<h3>Datos de Entrega:</h3>
						<p><b>Forma de Envio:</b> DELIVERY</p>
	                    <p><b>Datos de Quien recibe el regalo:</b></p>
                        
	                    <table width="439" border="0">
	                    	<tr>
	                    		<td width="66" align="right" valign="top">Nombres:</td>
	                    		<td width="97" valign="top"> <?php echo $pedido->getDestinatario()->__get("_nombre");?></td>
	                    		<td align="right" valign="top" >Distrito:</td>
	                    		<td><?php echo str_replace('Ã‘','Ñ',$pedido->getDestinatario()->__get("_distrito")->__get('_nombre'));?> , Lima, Perú</td>
	                    	</tr>                            
                            <tr>
	                    		<td align="right"   valign="top">Apellidos:</td>
	                    		<td valign="top"><?php echo $pedido->getDestinatario()->__get("_apellidos");?></td>
	                    		<td width="61" align="right" valign="top" >Dirección:</td>
	                    		<td width="197"><?php echo $pedido->getDestinatario()->__get("_direccion");?></td>
                                
	                    	</tr>
	                    	<tr>
	                    		<td align="right" valign="top">Teléfono:</td>
	                    		<td valign="top"><?php echo $pedido->getDestinatario()->__get("_telefono");?></td>
	                    		<td width="61" align="right" valign="top" >Referencia:</td>
	                    		<td width="197"><?php echo $pedido->getDestinatario()->__get("_referencia");?></td>
	                    	</tr>
	                    </table>
                        <p><b>Fecha de Entrega:</b> <?php echo fecha_hora_sql_html($pedido->getDestinatario()->__get("_fecha_hora"));?></p>
                        
                      
                        <p><b>Dedicatoria de la tarjeta: </b> <?php echo $pedido->getDestinatario()->__get("_dedicatoria");?></p>
                        
                       
                        
	                    <br /><br />
	                  	<h3>Datos de Pago:</h3>                        
                        <table width="438" border="0" class="comprobantefix">
					  		<tr>
					  			<td width="131" align="right"><b>Comprobante de Pago:</b></td>
					  			<td width="297" valign="top"><?php echo $pedido->getComprobantePago()->__get("_tipo");?></td>
					  		</tr>
					  		<?php  if ($pedido->getComprobantePago()->__get("_tipo") == "Boleta"){ ?>
                            <tr>
					  			<td align="right">DNI:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_dni");?></td>
					  		</tr>
                            <tr>
					  			<td align="right">Nombre:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_nombre");?></td>
					  		</tr>
					  		<tr>
					  			<td align="right">Dirección:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_direccionb");?></td>
					  		</tr>
                            <?php }else{?>
                            <tr>
					  			<td align="right">Razón social:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_razon_social");?></td>
					  		</tr>
					  		<tr>
					  			<td align="right">RUC:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_ruc");?></td>
					  		</tr>
                            <tr>
					  			<td align="right">Dirección:</td>
					  			<td><?php echo $pedido->getComprobantePago()->__get("_direccionf");?></td>
					  		</tr>
                            <?php }?>
		              	</table>
              			<div class="fomaspagofix">
                        <p><strong>Forma de Pago:</strong></p>
                        <div class="formas_pago">
		                    <div class="fp1">
		                        <img class="fp_img1" src="<?php echo _catalogo_.$pedido->getMetodoPago()->__get('_imagen');?>"/>
		                    </div>
		                    <div class="fp2">
		                        <?php echo str_replace('../','',nl2br($pedido->getMetodoPago()->__get('_descripcion')));?>
		                    </div>
		                    <div class="cleaner"></div>
	                	</div>
                        </div>
					</div>
                                                  
					<!--FIN SECCION 2-->
					<div class="cleaner"></div>
				</div>
                
                <!--BOTONES-->                    
                <div id="btn">   
                    <input type="button" id="seguir_comprando" onclick="window.location='index.php'" value="">    
                </div>
                <!-- FIN BOTONES-->     
                
			<!--</form>-->
			<div class="cleaner"></div>
		</div>
    <?php
	}
	
	
	
	
	// -- CUENTA ACCESS -- //
	public function loginCuenta(){
	?>
       <br/>
       <div id="panelCuenta">
           <div id="popup_acceso" class="login">
           <h2>Entrar aquí:</h2>
                <form method="get" id="login-form" onsubmit="return validate_login(this)">
                    <ul><li>
                    <label>Email:</label><br/>
                    <input type="text" name="email_login" id="email_login"></li><li>
                    <label>Password:</label><br />
                    <input type="password" name="password_login" id="password_login"></li>
                    </ul>
                    <input type="hidden" name="action" value="acceso">
                    <input type="submit" id="entrar_login" value="">
                </form>
                <br/>
                <a href="ajax.php?action=olvidastePassword" class="popup fancybox.ajax">¿Olvidaste tu password?</a><br/>
                <a href="ajax.php?action=registrarse" class="popup fancybox.ajax">Soy nuevo cliente, registrate aquí</a><br/>
           </div>
       </div>
       <br/><br/><br/>
    <?php
	}
	
	// -- CUENTA EDIT -- //
	public function editCuenta(){
	
	$ubigeo = new Ubigeos($msg);		
    $pais = $ubigeo->getPaises();
	
	$cliente = $this->_cuenta->getCliente();
	$query = new Consulta("SELECT * FROM clientes WHERE id_cliente = '".$cliente->__get('_id')."'");
	$rowc = $query->VerRegistro();
	
	?>
    <div class="pageTop"><h1><img src="aplication/webroot/imgs/ico_datos.jpg" alt="" />Mis datos Personales</h1></div>
    <div id="micuenta">
        <div id="pagLeft">
            <div id="boxCuentaLeft">
                <?php include(_includes_ . 'inc.menu_cuenta.php');?>
            </div>
        </div>
        <div id="pagRight">
            <div id="datosPersonales">
                <form action="" method="post" name="registro-form" id="registro-form" onsubmit="return validate_registro(this,updateCuenta)">                
                    <div class="table_reg">
                        <div class="colum_reg">
                            <ul class="datos">
                            <li>
                            <label>Nombres: <em>*</em></label><br/><input type="text" name="nombres" id="nombres" value="<?php echo $rowc['nombre_cliente']?>" class="txt" /></li>
                            <li>
                            <label>Apellidos:<em>*</em></label><br/><input type="text" name="apellidos" id="apellidos" value="<?php echo $rowc['apellidos_cliente']?>"/></li>
                            <li><label>Email: <em>*</em></label><br/><input type="text" name="email" id="email" value="<?php echo $rowc['email_cliente']?>"/></li>
                            <li><label>Teléfono: <em>*</em></label><br/><input type="text" name="telefono" id="telefono" class="txt" value="<?php echo $rowc['telefono_cliente']?>"/></li>
                            </ul>	
                        </div>
                        <div class="colum_reg">
                            <ul class="datos">
                            <li>
                            <label>Dirección: <em>*</em></label><br/><input type="text" name="direccion" id="direccion" value="<?php echo $rowc['direccion_cliente']?>"/></li>
                            <li>
                            <label>Ciudad: <em>*</em></label><br/><input type="text" name="ciudad" id="ciudad" value="<?php echo $rowc['ciudad_cliente']?>"/></li>
                            <li><label>País: <em>*</em></label><br/>
                            <select name="pais" id="pais">
                               <option value="">Elegir País...</option>
                             <?php for($i=0;$i<count($pais);$i++){  ?>
                               <option <?php echo ($rowc['pais_cliente']==$pais[$i]['id_pais'])? 'selected="selected"' : ''?>  value="<?php echo $pais[$i]['id_pais']?>"><?php echo $pais[$i]['nombre']?></option>
                             <?php }?>
                            </select> 
                            </li>
                            </ul>
                        </div>
                    </div>
                    <div id="txtrptacuenta">Cambios realizados</div>
                    <div id="loading_cuenta"></div>
                    <div align="center">
                        <input type="button" name="button" id="btn_cancelar" onclick="javascript:window.location='cuenta.php'" value="" />
                        <input type="submit" name="button" id="btn_guardar" value="" />
                    </div>
                </form>
            </div>
        </div>
    </div> 
    <div class="cleaner"></div>
    <?php	
	}
	
	// -- CUENTA VIEW -- //
	public function viewCuenta(){
	?>
        <div class="pageTop"><h1>Mi Cuenta</h1></div>
        <div id="micuenta">
            <div id="pagLeft">
                <div id="boxCuentaLeft">
                    <?php include(_includes_ . 'inc.menu_cuenta.php');?>
                </div>
            </div>
            <div id="pagRight">
                <?php
                $obp = new Pedidos();
				$pedidos = $obp->getNotificarPedidosXCliente($this->_cuenta->getCliente()->__get('_id'));
				?>
                <p>Total de pedidos : <?php echo count($pedidos)?></p>
                <ul id="iconsCuenta">
                    <li><a href="cuenta.php?action=edit" id="c1">MIS DATOS PERSONALES</a></li>
                    <li><a href="cuenta.php?action=editPassword" id="c2">CAMBIAR PASSWORD</a></li>
                    <li><a href="cuenta.php?action=historialPedido" id="c3">HISTORIAL DE PEDIDO</a></li>
                </ul>
            </div>
        </div> 
        <div class="cleaner"></div>
    <?php	
	}
	
	// -- CUENTA SALIR -- //
	public function salirCuenta(){
		$this->_cuenta->getCliente()->__set("_logeado",FALSE);
		$this->_cuenta->getCliente()->__set("_id",'');
		$this->_cuenta->getCliente()->__set("_usuario",'Visitante');
		$this->_cuenta->getCliente()->__set("_email",'');
		unset($_SESSION['envio']);
		unset($_SESSION['pago']);
		//$this->_cuenta->getCliente()->__get("_carrito")->reset(TRUE);
	}
	
	// -- CUENTA EDIT PASSWORD -- //
	public function editPasswordCuenta(){
	?>
    <div class="pageTop"><h1><img src="aplication/webroot/imgs/ico_pass.jpg" alt="" /> Cambiar mi Password</h1></div>
			<div id="micuenta">
				<div id="pagLeft">
					<div id="boxCuentaLeft">
						<?php include(_includes_ . 'inc.menu_cuenta.php');?>
					</div>
				</div>
				<div id="pagRight">
					<div id="datosPersonales">
						<form action="" method="post" name="registro-form" id="registro-form" onsubmit="return updatePasswordCuenta(this)">                
			                <div class="table_pass">
				                    <ul class="datos"><li>
                                    <label>Password Actual: <em>*</em></label><br/><input type="text" name="password_actual" id="password_actual"></li>
                                    <li>
				                    <label>Nuevo Password: <em>*</em></label><br/><input type="password" name="password_nuevo" id="password_nuevo"></li>
                                    <li>
				                    <label>Repetir Nuevo Password: <em>*</em></label><br/><input type="password" name="password_repeat_nuevo" id="password_repeat_nuevo"></li>
                                    </ul>
                            </div>
                            <div id="txtrptacuenta">Cambios realizados</div>
                            <div id="loading_cuenta"></div>
                            <div align="center">
			                	<input type="button" name="button" id="btn_cancelar" onclick="window.location='cuenta.php'" value="" />
			               		<input type="submit" name="button" id="btn_guardar" value="" />
			               </div>
			            </form>
					</div>
				</div>
	        </div> 
			<div class="cleaner"></div>
    <?php
	}
	
	// -- CUENTA HISTORIAL PEDIDO -- //
	public function historialPedidoCuenta(){
	?>
    <div class="pageTop"><h1><img src="aplication/webroot/imgs/ico_his.jpg" alt="" /> Historial de pedidos</h1></div>			
			<div id="micuenta">
				<div id="pagLeft">
					<div id="boxCuentaLeft">
						<?php include(_includes_ . 'inc.menu_cuenta.php');?>
					</div>
				</div>
				<div id="pagRight">
					<div id="tabla">
			            <ul id="tabla_his">
			            	<?php
                            $obp = new Pedidos();
							$pedidos = $obp->getNotificarPedidosXCliente($this->_cuenta->getCliente()->__get('_id'));
							
							if( count($pedidos)  > 0 ){	
							
							foreach( $pedidos as $row){
							?>
                            <li>
			            		<ul>
			            			<li class="tdh1">
					                    <div id="important">Pedido Nº <?php echo $row['id']?></div>
										<a href="cuenta.php?action=historialPedido&id=<?php echo $row['id']?>" class="btn_detalle_his"></a>
			            			</li>
			            			<li class="tdh2">
			            				<span><?php echo $row['fecha']?></span>
			            			</li>
			            			<li class="tdh3">
			            				<span>Estado: <?php echo $row['estado']?></span>
			            			</li>
			            			<li class="tdh4">
			            				<div id="important">$ <?php echo number_format($obp->PedidosMonto($row['id']),2)?>
                                        <br /> <span>
                                        
                                        <?php
										
										$cantidad = Pedidos::TotalProductosPedido($row['id']);
										
                                        if( $cantidad > 1 ){
											echo $cantidad.' productos';
										}else{
											echo '1 producto';
										}
										
										?>
                                        
                                        </span></div>
			            			</li>
			            		</ul>
			            	</li>
                            <?php }
							}else{
							echo 'Aún no tiene pedidos pagados';
							}
							?>
                            
			            </ul>
		            </div>
				</div>
	        </div> 
			<div class="cleaner"></div>
    <?php	
	} 
	
	// -- CUENTA DETAIL HISTORIAL PEDIDO -- //
	public function detailHistorialPedidoCuenta(){	
		
		$pedido = new Pedido( $_GET['id'] );
		$id_pedido = $pedido->getId();
		?>
        
        <div class="pageTop"><h1><img src="aplication/webroot/imgs/ico_his.jpg" alt="" /> Pedido Nº <?php echo $id_pedido?></h1>
        <div id="fecha_pedido"><b>Fecha: </b><?php echo fecha_hora_sql_html($pedido->getFecha())?></div>
        </div>			
			<div id="micuenta">
				<div id="pagLeft">
					<div id="boxCuentaLeft">
						<?php include(_includes_ . 'inc.menu_cuenta.php');?>
					</div>
				</div>
				<div id="pagRight">
					<div id="cd2_cuerpo">
					<!--SECCION 1-->
					<div class="cuerpo_sec" id="cd_sec">
						<h3>Pedido:</h3>
						<p>Revisa tu pedido antes de efectuar la compra. Los Gastos de Envío han sido calculados en base a tus Datos de Envío.</p>
						<div id="carrito_compras_paso3">
				            <div id="tabla">
					            <ul id="tabla_top">
					            	<li class="td1_c">PRODUCTO</li>
					                <li class="td2_c">PRECIO UNIT.</li>
					                <li class="td3_c">CANT.</li>
					                <li class="td4_c">SUBTOTAL</li>
					            </ul>
					            <ul id="tabla_cont">                               
					            	
                                    <?php
                                    $query_productos = new Consulta("SELECT * FROM pedidos_productos WHERE id_pedido='".$id_pedido."'");
									$subtotal = 0;
									if( $query_productos->NumeroRegistros() > 0 ){		
									while( $row = $query_productos->VerRegistro() ){
									
									
									
									
									$prod = new Producto($row['id_producto']);
									$precio = $prod->__get("_precio_producto");
									$imagenes = $prod->__get("_imagenes");
									
									
									$preciocmp = 0;
																		
									$img_thumb = (file_exists(_link_file_ . $imagenes[0]['thumbnail'])) ? $imagenes[0]['thumbnail'] : 'not_image_disponible_thumb.jpg' ;
									
									?>
                                    
                                    <li>
					            		<ul>
					            			<li class="td1_c alignLeft">
					            				<div class="img_cesta_c">
						                    		&nbsp;<img alt="" src="<?php echo _catalogo_ . $img_thumb?>" />
					            				</div>
					            				<div class="info_cesta_c">
							                    	<div class="nameCar"><?php echo $prod->__get("_nombre")?></div>
							                    	
                                                    <?php
                                                    
													$query_productos_cmp = new Consulta("SELECT * FROM pedidos_productos_opciones WHERE id_pedido_producto = '".$row['id_pedido_producto']."'");
													
													if( $query_productos_cmp->NumeroRegistros() > 0 ){														
														?>
														<div class="prod_agregado">
															<ul>
																<?php
                                                                while( $rowcmp = $query_productos_cmp->VerRegistro() ){
																
																$prodcmp = new Producto($rowcmp['producto_opcion']);
																$imgcmp = $prodcmp->__get("_imagenes");	
																
																$preciocmp += $prodcmp->__get("_precio_producto") * $rowcmp['producto_opcion_valor'];
																
																$img_thumb_cmp = (file_exists(_link_file_ . $imgcmp[0]['thumbnail'])) ? $imgcmp[0]['thumbnail'] : 'not_image_disponible_thumb.jpg' ;	
																	
																?>
                                                                <li>
																	<div class="wrap_agregado">
																		&nbsp;<img src="<?php echo _catalogo_ . $img_thumb_cmp?>" alt="" />
																	</div>
																	<span><?php echo $rowcmp['producto_opcion_valor'];?> <?php echo $prodcmp->__get("_nombre")?></span>
																</li>
                                                                <?php }?>
															</ul>
														</div>
														<?php
														
													}
													
													?>
					            				</div>
					            			</li>
					            			<li class="td2_c">
					            				<span class="precio_prod">$<?php echo number_format($precio + $preciocmp,2)?></span>
					            			</li>
					            			<li class="td3_c">
					            				<span><?php echo $row['cantidad_pedido_producto']?></span>
					            			</li>
					            			<li class="td4_c">
					            				
                                                
                                                <span class="subtotal">$<?php echo number_format(($precio + $preciocmp) * $row['cantidad_pedido_producto'],2)?></span>
					            			</li>
					            		</ul>
					            	</li>
                                    
                                    <?php
									
									$subtotal += ($precio + $preciocmp) * $row['cantidad_pedido_producto'];
									
									}
									}
									?>
                                    
					            </ul>
				            </div>
				            <div id="total_precio_c">
				           	    <div class="tpBox" id="subT">				                	
				                    <div class="tp boxright"><span>$<?php echo number_format($subtotal,2)?></span></div>
                                    <div class="tp textright">Subtotal:</div>
				                </div>
				                
                                <?php
                               
							    $destinatario = $pedido->getDestinatario();
								
							    if(is_object($destinatario->__get('_distrito'))){
									$tarifa = $destinatario->__get('_distrito')->__get('_tarifa_envio');	
									$nombreDIS = str_replace('Ã‘','Ñ',$destinatario->__get('_distrito')->__get('_nombre'));
									$ubigeos = new Ubigeos();
									$ubigeos->set_ubigeo( $destinatario->__get('_distrito')->__get('_id') );
								}else{
									$tarifa = '0.00';
									$nombreDIS = 'Por Calcular';
								}
								
																
								?>
                                
                                <div class="tpBox" id="flete">				                	
				                    <div class="tp boxright"><span>$<?php echo $tarifa;?></span></div>
                                    <div class="tp textright flete">Gastos de envío (<?php echo $nombreDIS;?>):</div>
				                </div>
				                  <div class="tpBox confirm" id="flete">				                	
				                    <div class="tp boxright"><span>$<?php echo number_format($subtotal + $tarifa,2)?></span></div>
                                    <div class="tp textright flete totaltxt">Total ($):</div>
				                  </div>
                                   <div class="tpBox confirm" id="flete">				                	
				                    <div class="tp boxright totalprecio"><span>S/. <?php echo number_format((( $subtotal + $tarifa )*TIPO_CAMBIO ),2);?></span></div>
                                    <div class="tp textright flete totaltxt">Total (S/.):</div>
				                </div>
				            </div>
				        </div>
						
					</div>
					<!--FIN SECCION-->

					<!--SECCION 2-->
					<div class="cuerpo_sec cuerpo_sec3" id="datos">
						<h3>Datos de Envío:</h3>
						<p><b>Forma de Envio:</b> DELIVERY</p>
	                    <p><b>Dirección de Envio:</b></p>
	                    
	                    
	                    <table width="335" border="0">
	                    	<tr>
	                    		<td width="66" align="right">Nombres:</td>
	                    		<td width="97"> <?php echo $destinatario->__get('_nombre')?></td>
	                    	</tr>
	                    	<tr>
	                    		<td align="right" >Apellidos:</td>
	                    		<td><?php echo $destinatario->__get('_apellidos')?></td>
	                    	</tr>
	                    	<tr>
	                    		<td align="right">Teléfono:</td>
	                    		<td><?php echo $destinatario->__get('_telefono')?></td>
	                    	</tr>
	                    	<tr>
	                    		<td align="right" >Distrito:</td>
	                    		<td>
								
								<?php echo (is_object($destinatario->__get('_distrito')))?str_replace('Ã‘','Ñ',$destinatario->__get('_distrito')->__get('_nombre')):''?>, Lima , Perú</td>
	                    	</tr>
                            <tr>
	                    		<td width="61" align="right" valign="top" >Dirección:</td>
	                    		<td width="197"><?php echo $destinatario->__get('_direccion')?></td>
	                    	</tr>
                            
                            <?php
							
							//$distrito = $destinatario->__get('_distrito')->__get('_id');
							//$ubigeos = new Ubigeos();
							//$ubigeos->set_ubigeo($distrito);
													
							?>
                            
	                    	
	                    	<tr>
	                    		<td align="right">Referencia: </td>
	                    		<td><?php echo $destinatario->__get('_referencia')?></td>
	                    	</tr>	                    	
	                    </table>
                        
                        <p><b>Fecha y hora de entrega:</b>  <?php echo fecha_hora_sql_html($destinatario->__get('_fecha_hora'))?></p>
 
 
 						<p><b>Dedicatoria:</b>  <?php echo $destinatario->__get('_dedicatoria')?></p>
                                               
	                    <br /><br />
	                  	<h3>Datos de Pago:</h3>
					  	
                        <?php
                        
						$comprobante = $pedido->getComprobantePago();
						$metodo = $pedido->getMetodoPago();
						
						//echo 'CC'.$comprobante->__get("_tipo");
						
						//pre($metodo);
						
						?>
                        
                        <table width="335" border="0">
					  		<tr>
					  			<td width="131" align="right"><strong>Comprobante de Pago:</strong></td>
					  			<td valign="top"><?php echo $metodo->__get("_nombre")?></td>
					  		</tr>
					  		
                            <?php if( $comprobante->__get("_tipo") == 'Boleta' ){?>
                            <tr>
					  			<td align="right">DNI:</td>
					  			<td><?php echo $comprobante->__get("_dni")?></td>
					  		</tr>
                            <tr>
					  			<td align="right">Nombre:</td>
					  			<td><?php echo $comprobante->__get("_nombre")?></td>
					  		</tr>
					  		<tr>
					  			<td align="right" valign="top">Dirección:</td>
					  			<td><?php echo $comprobante->__get("_direccionb")?></td>
					  		</tr>
                            <?php }else{ ?>
                             <tr>
					  			<td align="right">Razón social:</td>
					  			<td><?php echo $comprobante->__get("_razon_social")?></td>
					  		</tr>
					  		<tr>
					  			<td align="right" valign="top">RUC:</td>
					  			<td><?php echo $comprobante->__get("_ruc")?></td>
					  		</tr>
                            <tr>
					  			<td align="right" valign="top">Dirección Factura:</td>
					  			<td><?php echo $comprobante->__get("_direccionf")?></td>
					  		</tr>
                            <?php } ?>
                            
                           
				  		</table>
                            
                           
                           
                           <div class="fomaspagofix">
                            <p><strong>Forma de Pago:</strong></p>
                            <div class="formas_pago">
                                <?php if(is_object($metodo)){?>
                                <div class="fp1">
                                    <img class="fp_img1" src="<?php echo _catalogo_ . $metodo->__get('_imagen')?>">
                                </div>
                                <div class="fp2">
                                	<?php echo str_replace('../','',nl2br($metodo->__get('_descripcion')))?>
                                </div>
                                <div class="cleaner"></div>
                                <?php }?>
                            </div>
                            </div>
		                    
		                   
	                
					</div>
					<!--FIN SECCION 2-->
					<div class="cleaner"></div>
					
				</div>
				</div>
	        </div> 
			<div class="cleaner"></div>
        
        <?php
	}
	
    static public function notificarPedido($pedido){
		
        $carrito = $pedido->getCarrito();
        $cliente = $pedido->getCliente();
		$productos = $pedido->getCarrito()->getContent();
		$priceTotal = 0;
		while( list($key,) = each( $productos ) ){
			$producto = new Producto($key); 
            $precio = $productos[$key]['precio']; 
			$preciocmp = 0;
			$query_productos_cmp = new Consulta("SELECT * FROM pedidos_productos_opciones WHERE id_pedido_producto = '".$productos[$key]['id_pedido_producto']."'");			
			if( $query_productos_cmp->NumeroRegistros() > 0 ){	
				while( $rowcmp = $query_productos_cmp->VerRegistro() ){
					$prodcmp = new Producto($rowcmp['producto_opcion']);
					$preciocmp += $prodcmp->__get("_precio_producto") * $rowcmp['producto_opcion_valor'];
				}
			}
			$priceTotal += (($precio+$preciocmp) * $productos[$key]['cantidad']);
			
		}
		

        //DATOS PARA ENVIAR EMAIL AL CLIENTE
		
	$message = "Estimado (a) ".$pedido->getCliente()->__get("_nombre")." ".$pedido->getCliente()->__get("_apellidos")." gracias por comprar en DON REGALO.\r\r";

$total = ($priceTotal + $pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio'));

if( $pedido->getMetodoPago()->__get('_id') == 1 ) { $mensaje_pago = "\r El pago a paypal se hizo satisfactoriamente. \r"; }
if( $pedido->getMetodoPago()->__get('_id') == 2 || $pedido->getMetodoPago()->__get('_id') == 7 ) {
	
	$mensaje_pago  = "PARA REALIZAR EL ENVIO REALIZAR EL PAGO DE:\r";		
	$mensaje_pago .= "\r - Monto Total: DOLARES USD$	" . number_format($total,2); 	
	$mensaje_pago .= "\r - Monto Total: SOLES S/. " . number_format($total * TIPO_CAMBIO,2);
	$mensaje_pago .= "\r\rA ".strip_tags(nl2br(clean_tyncme(strtoupper($pedido->getMetodoPago()->__get('_descripcion')))));
	$mensaje_pago .= "\r\rLUEGO CONFIRMAR EL PEDIDO A ESTE NUMERO 5351616 / 943113807 \r O AL CORREO ".EMAIL_PEDIDOS;
}

	
$message .= $mensaje_pago;

$message .= "


		
SU PEDIDO ES EL NUMERO: ".$pedido->getId()." 

FECHA DE ENVIO: ".$pedido->getDestinatario()->__get('_fecha_hora')."		
				
ITEM | CANTIDAD |       PRODUCTO      =>       MONTO	
------------------------------------------------------------------------------------------------";
	
	$j = 1; 
	$productos = $pedido->getCarrito()->getContent();
        reset($productos);
        $priceTotal = 0;
		while( list($key,) = each( $productos ) ){
             
            $producto = new Producto($key); 
            $precio = $productos[$key]['precio']; 
			
			$preciocmp = 0;
			
                
$message .= "
".$j .".-    |    ".$productos[$key]['cantidad']."   | ".$producto->__get('_nombre')." ";
			
			$query_productos_cmp = new Consulta("SELECT * FROM pedidos_productos_opciones WHERE id_pedido_producto = '".$productos[$key]['id_pedido_producto']."'");			
			if( $query_productos_cmp->NumeroRegistros() > 0 ){	
						while( $rowcmp = $query_productos_cmp->VerRegistro() ){
							$prodcmp = new Producto($rowcmp['producto_opcion']);
							$preciocmp += $prodcmp->__get("_precio_producto") * $rowcmp['producto_opcion_valor'];
						$message .= '
						__________('.$rowcmp['producto_opcion_valor'].' x '.$prodcmp->__get("_nombre").')';
						}
			}
			
			$priceTotal += (($precio+$preciocmp) * $productos[$key]['cantidad']);
			
			$message .= " => USD $" .number_format((($precio+$preciocmp) * $productos[$key]['cantidad']),2);
		$j++;
	}			
		
$message .= " 		
------------------------------------------------------------------------------------------------
Total en Productos => $ " . number_format($priceTotal,2)."
------------------------------------------------------------------------------------------------
";	

$monto = $carrito->getAmount();	 	
$message .= " COSTO DE ENVIO (".$pedido->getDestinatario()->__get('_distrito')->__get('_nombre').") => USD$ ".number_format($pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio'),2)."
";

$message .= " FORMA DE PAGO => ".$pedido->getMetodoPago()->__get('_nombre')." \r";
$message .= "------------------------------------------------------------------------------------------------";

$message .= "

Telf. 5351616 / 943113807
http://www.donregalo.pe
DON REGALO SRL

Lleva felicidad en cada regalo...

";		
		
	
		/*
        //liberar en el host
        if(!@mail($pedido->getCliente()->__get("_email"), "Pedido ".$pedido->getId()." - ".NOMBRE_SITIO, $message, "from: ".EMAIL_PEDIDOS."")){ echo "Error al enviar el email" ; }		

        if(!@mail(EMAIL_PEDIDOS, "Pedido ".$pedido->getId()." - ".NOMBRE_SITIO, $message, "from: Administrador ".NOMBRE_SITIO)){
             echo "Error al enviar el email" ;
       }
       */
    }
	
	
	// -- BLOG -- //
	public function BlogList($cat = 0){
		if (!isset($_GET['pagb'])) {
            $_GET['pagb'] = 1;
        }
		
		if($cat>0){ 
			$where = "WHERE id_categoria_blog = '".$cat."'"; 
			$catblog =new CategoriaBlog($cat);
			$nombrecat = str_replace(' ','-',$catblog->__get('_titulo')).'/'; 
		}
		
		$tampag = 18;
        $reg1 = ($_GET['pagb'] - 1) * $tampag;
		$limit = " LIMIT " . $reg1 . "," . $tampag . "";
		
		if( isset($_GET['qb'])&&!empty($_GET['qb']) ){			
			$filtroq = "WHERE CONCAT(titulo_post,' ',descripcion_post,' ',tags_post) LIKE '%".$_GET['qb']."%' ";
			$limit ='';
			BusquedasBlog::addBusquedaBlog(comillas_inteligentes($_GET['qb']));
		}
		
        
        $sql = "SELECT * FROM post ".$where. $filtroq . " ORDER BY fecha_post DESC";
        $queryt = new Consulta($sql);
        $num = $queryt->NumeroRegistros();
        
        $sql.= $limit;
		
		//echo $sql;
		
        $query = new Consulta($sql);
		?>        
        <ul id="listblog">
        <?php
		while( $row = $query->VerRegistro() ){
			
			$catblogurl =new CategoriaBlog($row['id_categoria_blog']);
			$nombrecaturl = str_replace(' ','-',$catblogurl->__get('_titulo')).'/'; 
			
			?>
            <li>
            	<h3><a href="blog/<?php echo $nombrecaturl.str_replace(' ','-',$row['titulo_post'])?>"><?php echo $row['titulo_post']?></a></h3>
                <div class="fecha"><?php echo date('F j, Y. g:i a',strtotime($row['fecha_post']))?></div>
                <div class="descripcion_post">
                	<?php echo limitarPalabras(str_replace('../','',$row['descripcion_post']),180);?>
                </div>
                <br class="cleaner">
                <a href="blog/<?php echo $nombrecaturl.str_replace(' ','-',$row['titulo_post'])?>" class="btn-leermas"></a>
            </li>
            <?php
		}
		?>
        </ul>
        <div class="paginador">
        <div class="paginadorRight">        
        <?php if( ($num > $tampag ) &&  empty($_GET['qb'])){ echo paginar_blog($_GET['pagb'], $num, $tampag, "blog/".$nombrecat); } ?>
        </div>
        </div>        
        <?php	
	}
	public function BlogDetail($nombre){
		$id = Posts::getIdByName(str_replace('-',' ',$nombre));
		$post = new Post($id);
		?>        
        <ul id="listblog">       
            <li>
            	<h1><?php echo $post->__get('_titulo')?></h1>
                <div class="fecha"><?php echo date('F j, Y. g:i a',strtotime($post->__get('_fecha')))?></div>
                <div class="descripcion_post">
                	<?php echo str_replace('../','',$post->__get('_descripcion'));?>
                </div>                
            </li>
        </ul>  
        <?php
	}    
   
} ?>