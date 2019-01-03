<?php 
class Ajax{
	private $_idioma;
	private $_cuenta;
	
	public function __construct(Idioma $idioma , Cuenta $cuenta = NULL){
            $this->_idioma = $idioma ;
            $this->_cuenta = $cuenta;
	}

	public function newUbicacionMapaAjax(){ 
		$latitud = Ubigeos::getDistritoCoordenada($_GET['id_distrito'],'latitud_distrito_coordenada');
		$longitud = Ubigeos::getDistritoCoordenada($_GET['id_distrito'],'longitud_distrito_coordenada');
		?>
            <div class="row">
                <p class="nota"><strong>Nota:</strong> Ayudenos a tener su ubicación más exacta deslizando el icono del mapa.</p>
            </div>
            <div class="row">
                <div id="mi_ubic" style="width:100%;height:393px;margin-top:15px"></div>
                <input type="hidden" id="lat_pos" name="lat_pos" value="<?php echo $latitud ?>">
                <input type="hidden" id="lng_pos" name="lng_pos" value="<?php echo $longitud ?>">
            </div>
            <script type="text/javascript">
            	$(document).ready(function(e){
                    var lat, lng;
                    ($("#lat_pos").val() === "") ? lat = -12.0928092 : lat = $("#lat_pos").val();
                    ($("#lng_pos").val() === "") ? lng = -77.0268028 : lng = $("#lng_pos").val();
                    
                    var myPos = new google.maps.LatLng(lat, lng);
                    var mapOptions = {
                        center: myPos,
                        zoom:14,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    
                    var map = new google.maps.Map(document.getElementById('mi_ubic'), mapOptions);
                    var input = (document.getElementById('address'));
                    
                    var autocomplete = new google.maps.places.Autocomplete(input);

                    autocomplete.bindTo('bounds', map);
                    var infowindow = new google.maps.InfoWindow();
                    var markerNew = new google.maps.Marker({

                        map: map,
                        draggable: true,
                        icon: new google.maps.MarkerImage('app/view/front-end/last/imgs/icon_location.png'),
                        position: new google.maps.LatLng(lat, lng)

                    });

                    google.maps.event.addListener(markerNew, 'mouseout', toggleBounce);
                    google.maps.event.addListener(autocomplete, 'place_changed', function() {

                        infowindow.close();
                        markerNew.setVisible(false);
                        //            input.className = '';
                        var place = autocomplete.getPlace();
                        if (!place.geometry) {
                            // Inform the user that the place was not found and return.
                            input.className = 'notfound';
                            return;
                        }

                        // If the place has a geometry, then present it on a map.
                        if (place.geometry.viewport) {
                            map.fitBounds(place.geometry.viewport);
                        } else {
                            map.setCenter(place.geometry.location);
                            map.setZoom(14);  // Why 17? Because it looks good.
                        }

                        markerNew.setPosition(place.geometry.location);
                        toggleBounce();
                        markerNew.setVisible(true);

                        var address = '';
                        if (place.address_components) {
                            address = [
                                        (place.address_components[0] && place.address_components[0].short_name || ''),
                                        (place.address_components[1] && place.address_components[1].short_name || ''),
                                        (place.address_components[2] && place.address_components[2].short_name || '')
                            ].join(' ');
                        }
                        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                        infowindow.open(map, markerNew);
                    });

                    /*Animación para seleccionar ubicación*/
                    google.maps.event.addListener(map, 'click', function(e) {
                        placeMarker(e.latLng, map);
                    });

                    $("#address").keypress(function(e) {
                        if (e.keyCode == 13) {
                            e.stopPropagation();
                            return false;
                        }
                    });

                    function placeMarker(position, map) {
                        markerNew.setMap(null)
                        markerNew.setMap(null);
                        markerNew = new google.maps.Marker({
                            map: map,
                            draggable: true,
                            icon: new google.maps.MarkerImage('app/view/front-end/last/imgs/icon_location.png'),
                            position: position
                        });

                        google.maps.event.addListener(markerNew, 'mouseout', toggleBounce);//map.panTo(position); Efecto movimiento con el click
                    }

                    function toggleBounce() {
                        //Capturo lo posicion al mover el icono del mapa
                        var count = 0;
                        $.each(markerNew.getPosition(), function(i, v) {
                            if (count == 0) {//LB
                                $("#lat_pos").val(v);
                            } else if (count == 1) {//KB
                                $("#lng_pos").val(v);
                                return false;
                            }
                            count++;
                        });
                    }
                });                          
            </script>
		<?php 
	}
	
	public function resumenPedidoAjax(){
		$filtro_estado = ($_GET['estado'])?" AND estado_pedido='".$_GET['estado']."'":'';
		$filtro_pedido = ($_GET['pedido'])?" AND id_pedido='".$_GET['pedido']."'":'';
		$filtro_distrito = ($_GET['distrito'])?" AND id_distrito='".$_GET['distrito']."'":'';
		$filtro_cliente = ($_GET['cliente'])?" AND CONCAT(nombre_cliente,' ', apellidos_cliente) LIKE '%".$_GET['cliente']."%'":'';
		$filtro_fecha_envio = ($_GET['fecha_envio_init'])?" AND fecha_full_destinatario BETWEEN DATE '".fecha_hora_html_sql($_GET['fecha_envio_init'])."' AND DATE '".fecha_hora_html_sql($_GET['fecha_envio_fin'])."'":'';
		
		$query = new Consulta("
                        SELECT nombre_producto,COUNT(*) AS total
                        FROM pedidos_productos 
                        INNER JOIN productos USING(id_producto) 
                        WHERE id_pedido IN(SELECT id_pedido
                        FROM pedidos 
                        INNER JOIN clientes USING (id_cliente) 
                        INNER JOIN pedidos_destinatarios USING(id_pedido) 
                        INNER JOIN distritos USING(id_distrito)	
                        WHERE 1=1 ".$filtro_estado. $filtro_pedido . $filtro_distrito . $filtro_cliente . $filtro_fecha_envio ."
                        GROUP BY id_pedido)
                        GROUP BY nombre_producto");
		while($row = $query->VerRegistro()){
			$data[] = array(	
				'total'		=> $row['total'],	
				'nombre'   	=> $row['nombre_producto']	
			);	
		};
		if(count($data) != 0){
			echo json_encode($data);
		}else{
			echo "[ ]";
		}	
	
	}	
	
	public function ordenarBlogAjax(){
            foreach($_GET['list_item'] as $position => $item){
                $type_val = explode("|",$item);
                if($type_val[1] == 'catblog'){
                    new Consulta("UPDATE categorias_blog SET orden_categoria_blog = $position WHERE id_categoria_blog = $type_val[0]");	
                }else{
                    new Consulta("UPDATE post SET orden_post = $position WHERE id_post = $type_val[0]");
                }
            }
	}
	
	public function ordenarImagenesAjax(){
            foreach($_GET['list_item'] as $position => $item){
                $type_val = explode("|",$item);
                $id_imagen_producto = $type_val[0];
                $id_producto = $type_val[1];
                new Consulta("UPDATE productos_imagenes SET orden_producto_imagen = $position WHERE id_producto_imagen = $id_imagen_producto");
            }
	}
	
	public function ordenarPaginasAjax(){
		foreach($_GET['list_item'] as $position => $item){
			$type_val = explode("|",$item);
			new Consulta("UPDATE paginas SET orden_pagina = $position WHERE id_pagina = $type_val[0]");
		}
	}
	
	public function ordenarMensajeAjax(){
		foreach($_GET['list_item'] as $position => $item){
			$type_val = explode("|",$item);
			new Consulta("UPDATE mensajes SET orden_mensaje = $position WHERE id_mensaje = $type_val[0]");
		}
	}
	
	public function ordenarTiposMensajeAjax(){
		foreach($_GET['list_item'] as $position => $item){
			$type_val = explode("|",$item);
			new Consulta("UPDATE tipos_mensajes SET orden_tipo_mensaje = $position WHERE id_tipo_mensaje = $type_val[0]");
		}
	}
	
	public function ordenarFormaPagoAjax(){
		foreach($_GET['list_item'] as $position => $item){
			$type_val = explode("|",$item);
			new Consulta("UPDATE metodo_pago SET orden_metodo_pago = $position WHERE id_metodo_pago = $type_val[0]");
		}
	}
	
	//public function ordenar	
	public function ordenarCatProdAjax(){

		foreach($_GET['list_item'] as $position => $item){

			$type_val = explode("|",$item);

			

			if($type_val[1] == 'cat'){

				$objc  = new Categoria($type_val[0], $this->_idioma);

				$query = new Consulta("UPDATE  categorias SET orden_categoria = $position 

											WHERE id_categoria = $type_val[0] AND id_parent = '".$objc->__get("_parent")."'"); 	

			}else{

				$obju  = new Producto($type_val[0], $this->_idioma);

				$query = new Consulta("UPDATE  productos SET orden_producto = $position 

											WHERE id_producto = $type_val[0] 

											AND id_categoria = '".$obju->__get("_categoria")->__get("_id")."'"); 		

											

			}

		}

	}


	public function moveItemAjax(){
		
		$idcat = $_GET['id'];	
		
		foreach($_GET['item'] as $item){
			$type_val = explode("|",$item);
			if($type_val[1]=="prod"){
				// ACTUALIZACION A PRODUCTOS
				new Consulta("UPDATE productos SET id_categoria = $idcat WHERE id_producto = $type_val[0]"); 
				
			}else{
				// ACTUALIZACION A CATEGORIAS
				new Consulta("UPDATE categorias SET id_parent = $idcat WHERE id_categoria = $type_val[0]"); 
			}
		}
	}
	
	public function autocompleteCategoriasAjax(){
		$obj_cat = new Categorias();
		$data =  $obj_cat->getCategoriaXCriterio($_GET['term']);
		if(count($data) != 0){
			echo encode_json($data);
		}else{
			echo "[ ]";
		}			
	}
	
	public function viewUserAjax(){
		if($_GET['id']){
			$obj = new Usuario($_GET['id']);
		?>
        
       	<ul id="datos_usuario">
       		 <li><label>Nombre:</label> <div class="value_field"><?php echo $obj->getNombre(); ?></div></li>
             <li><label>Apellidos:</label> <div class="value_field"><?php echo $obj->getApellidos(); ?></div></li>
             <li><label>Cargo:</label> <div class="value_field"><?php echo $obj->getRol()->getNombre(); ?></div></li>
             <li><label>Email:</label> <div class="value_field"><?php echo $obj->getEmail(); ?></div></li>
             <li><label>Login:</label> <div class="value_field"><?php echo $obj->getLogin(); ?></div></li>
       	</ul>
		<?php
		}
	}
			
	public function reportePedidosAjax(){
		$where = '';
		if($_POST['numero'] != ""){
			$q 	   = str_replace($espacio, "(.*)", $_POST['numero']);
			$where = "AND codigos_pedido REGEXP '$q' ";
		}
		$where .= ($_POST['estado'] != "") ? " AND id_estado_pedido = '".$_POST['estado']."'" : "";	
		$where .= ($_POST['fechai'] != "") ? " AND fecha_pedido BETWEEN   '".formato_date("/",$_POST['fechai'])."' AND  '".formato_date("/",$_POST['fechaf'])."'" : "";	
		
		$queryp = new Consulta("SELECT * FROM pedidos WHERE id_pedido > 0 ".$where);  
		
		
		$y = 1;
		if($queryp -> NumeroRegistros() > 0){
                    $costo_total_pedidos = 0;
			while($rowp = $queryp->VerRegistro()){
				$cliente = new ClienteAdmin($rowp['id_cliente']);
				$pedidos = new Pedidos();
				?>
                <tr class="row <?php echo ($y % 2 == 0) ? 'odl' : ''; ?>">
		    <td><img src="<?php echo _icons_."ps.gif"?>" /> <?php echo $rowp['codigos_pedido'] ?></td>
                    <td> <?php echo $cliente->__get("_nombre")." ".$cliente->__get("_apellidos") ?></td>
                    <td align="center"> <?php echo number_format($pedidos->PedidosMonto($rowp['id_pedido']),2);?></td>
                    <td align="center"><?php echo formato_slash('-',$rowp['fecha_pedido'])?>  </td>
                    <td align="center"><?php if($rowp['id_estado_pedido'] == "P"){ echo "<font color='#FF0000'>Pendiente</font>";}else{ echo "<font color='#009900'>Finalizado</font>"; } ?></td>
                    <td align="center"> <a href="pedidos.php?action=edit&id=<?php echo $rowp['id_pedido'] ?>"><img src="<?php echo _icons_."zoom.png" ?>" /></a></td>
		</tr>
				 
				<?php 
                $y++;
                $costo_total_pedidos = $costo_total_pedidos + $pedidos->PedidosMonto($rowp['id_pedido']);
			}
                        ?>
                 <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#CCCCCC">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b>MONTO TOTAL DE PEDIDOS</b></td>
                    <td style="color:darkblue; font: bold 16px Arial;">S/. <?php echo number_format($costo_total_pedidos,2); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                
		<?php
                }else{
		?><tr class="fila2"><td colspan="6" align="center" style="color:#D04320;">No se encontrarón registros con estos datos!</td></tr><?php	
		}	
	}
		
	public function reporteProductosAjax(){
		$where = '';
		if($_POST['nombre'] != ""){
			$q 	   = str_replace($espacio, "(.*)", $_POST['nombre']);
			$where = "AND nombre_producto REGEXP '$q' ";
		}
		$where .= ($_POST['categorias'] != "") ? " AND id_categoria = '".$_POST['categorias']."'" : "";	
		$where .= ($_POST['precio'] != "") ? " AND p.precio_publico ".$_POST['signo']." '".$_POST['precio']."'" : "";	
		
		$queryp = new Consulta("SELECT * FROM productos p, productos_idiomas pi WHERE p.id_producto=pi.id_producto AND p.id_producto > 0 ".$where); 
		
		echo "SELECT * FROM productos p, productos_idiomas pi WHERE p.id_producto=pi.id_producto AND p.id_producto > 0 ".$where; 

		$y = 1;
		if($queryp -> NumeroRegistros() > 0){
			while($rowp = $queryp->VerRegistro()){
				$cat = new Categoria($rowp['id_categoria'],$this->_idioma);
				$producto = new Producto($rowp['id_producto'], $this->_idioma);
				
				?>
				<tr class="row <?php echo ($y % 2 == 0) ? 'odl' : ''; ?>">
					<td><img src="<?php echo _icons_."ps.gif"?>" /> <?php echo $rowp['nombre_producto'] ?></td>
                    <td> <?php echo $cat->__get("_nombre") ?></td>
                    <td align="center"> S/. <?php echo $rowp['precio_publico'] ?> &nbsp;-&nbsp; S/. <?php echo $rowp['precio_privado'] ?> &nbsp;-&nbsp; S/. <?php echo $rowp['precio_extranjero'] ?></td>
				</tr>
				 
				<?php 
                $y++;                   	
			}
		}else{
		?><tr class="fila2"><td colspan="6" align="center" style="color:#D04320;">No se encontrarón registros con estos datos!</td></tr><?php	
		}	
	}
	
	public function saveRelacionAjax(){
		$querys = new Consulta("SELECT * FROM productos_relacionados 
										WHERE id_producto = '".$_POST['id']."' 
											AND id_producto_relacionado = '".$_POST['id_p']."'");
		if($querys->NumeroRegistros() > 0){														
			$query = new Consulta("DELETE FROM productos_relacionados WHERE id_producto = '".$_POST['id']."' 
											AND id_producto_relacionado = '".$_POST['id_p']."'");
		}else{
			$query = new Consulta("INSERT INTO productos_relacionados 
											VALUES('".$_POST['id']."','".$_POST['id_p']."')");
		}
	}
	
	public function addInsumoAjax(){
		$datos = $_SESSION['list_insumos'];
		$datos[] = array($_POST['id'],$_POST['nombrei'],$_POST['cant']);
		$_SESSION['list_insumos'] = $datos;
		$prod = new Productos();
		$prod->insumosXProductoNuevo();
	}
	
	public function editInsumoAjax(){
		$datos = $_SESSION['list_insumos'];
		$id = $_POST['id'];
		echo  $datos[$id][0]."::".$datos[$id][1]."::".$datos[$id][2]."::".$id."::";
		
	}
	
	public function editInsuAjax(){
		$datos = $_SESSION['list_insumos'];
		$ida = $_POST['ida'];
		$datos[$ida] = array($_POST['id'],$_POST['nombrei'],$_POST['cant']);
		$_SESSION['list_insumos'] = $datos;
		$prod = new Productos();
		$prod->insumosXProductoNuevo();
	}
	
	public function deleteInsumoAjax(){
		$datos = $_SESSION['list_insumos'];
		$id = $_POST['id'];
		unset($datos[$id]);
		$array = array_values($datos);
		$_SESSION['list_insumos'] = $array;
		$prod = new Productos();
		$prod->insumosXProductoNuevo();
	}
	
	public function addproveedorAjax(){
		?>
        <fieldset>
        	<legend>Añadir Proveedor</legend>
            <label><strong>Nombre Proveedor : </strong></label><input name="nombre_proveedorpop" id="nombre_proveedorpop" type="text" size="50" maxlength="50" class='text ui-widget-content ui-corner-all' /><br /><br />
            <div align="center">
            	<input name="cerrar" type="button" value="Cerrar" class="cerrar" />&nbsp;&nbsp;<input name="guardar" type="button" value="Guardar" class="guardarproveedor" />
            </div>
        </fieldset>
        <?php
	}
	
	public function addprovAjax(){
		if($_POST['nombre']!=''){
			$query = new Consulta("INSERT INTO proveedores (nombre_proveedor) VALUES ('".$_POST['nombre']."')");
			echo $query->nuevoId()."-".$_POST['nombre'];
		}else{
			echo "0";
		}
	}
	
	public function addtipoinsumoAjax(){
		?>
        <fieldset>
        	<legend>Añadir Tipo Insumo</legend>
            <label><strong>Tipo Insumo : </strong></label><input name="nombre_tipo_insumopop" id="nombre_tipo_insumopop" type="text" size="50" maxlength="50" class='text ui-widget-content ui-corner-all' /><br /><br />
            <div align="center">
            	<input name="cerrar" type="button" value="Cerrar" class="cerrar" />&nbsp;&nbsp;<input name="guardar" type="button" value="Guardar" class="guardartipoinsumo" />
            </div>
        </fieldset>
        <?php
	}
	
	public function addtipoinAjax(){
		if($_POST['nombre']!=''){
			$query = new Consulta("INSERT INTO tipos_insumos (nombre_tipo_insumo) VALUES ('".$_POST['nombre']."')");
			echo $query->nuevoId()."-".$_POST['nombre'];
		}else{
			echo "0";
		}
	}
	
	public function delComplementosXProductoAjax(){
		$idp = $_GET['idp'];
		$id = $_GET['id'];
		$query = new Consulta("DELETE FROM productos_complementos WHERE id_complemento = '".$id."' AND id_producto = '".$idp."'");
		if($query){ echo 1; } else {echo 0;}
	}
	
	public function addComplementosXProductoAjax(){
		$idp = $_GET['idp'];
		$id = $_GET['id'];
		$query = new Consulta("INSERT INTO productos_complementos VALUES ('','".$idp."','".$id."')");
		if($query){ echo 1; } else {echo 0;}
	}	
	
	// complementos list por producto
	public function listComplementosXProductoAjax(){
		if( $_GET['cat']!='' ){
			$prod = new Productos();
			
			$cmp['select'] = $prod->getProductosByCatXComplementosSelected($_GET['id']);
			$cmp['all'] = $prod->getProductosByCatXComplementos($_GET['cat']);
						
			echo json_encode($cmp);
		}else{
			echo '[ ]';
		}
	}
	
	//update Password Cuenta ajax
	public function updatePasswordCuentaAjax(){
		$cliente = $this->_cuenta->getCliente();
		$query = new Consulta("SELECT password_cliente FROM clientes WHERE id_cliente = '".$cliente->__get('_id')."'");
		$row = $query->VerRegistro(); 
		
		$pass_actual = str_replace("'",'',comillas_inteligentes(encriptar($_POST['password_actual'])));
		
		//echo 'PASS ACTUAL : '.$pass_actual. ' PASS BDD : ' . $row['password_cliente'];
		//echo var_dump($_POST);
		if( $pass_actual == $row['password_cliente'] ){
		   $query = new Consulta("UPDATE clientes SET password_cliente=".comillas_inteligentes(encriptar($_POST['password_nuevo']))." 				
			WHERE id_cliente='".$cliente->__get("_id")."' ");
		   if($query){
			echo 1;  
		   }	
		}else{
			//Error: No coincide el password actual
			echo 0;
		}
	}
	
	//update Cuenta ajax
	public function updateCuentaAjax(){
		$cliente = $this->_cuenta->getCliente();							
		$query = new Consulta("UPDATE clientes SET  nombre_cliente = ".comillas_inteligentes($_POST['nombre'])." ,
        apellidos_cliente = ".comillas_inteligentes($_POST['apellidos'])." , 
        telefono_cliente = ".comillas_inteligentes($_POST['phone'])." , 
        direccion_cliente = ".comillas_inteligentes($_POST['direccion'])." , 
        ciudad_cliente = ".comillas_inteligentes($_POST['ciudad'])." , 
        pais_cliente = ".comillas_inteligentes($_POST['pais'])."  
        WHERE id_cliente = '".$cliente->__get('_id')."'");
	}
	
	//add Cuenta ajax
	public function addCuentaAjax(){

		$query_ver = new Consulta("SELECT * FROM clientes WHERE email_cliente=".comillas_inteligentes($_GET['email'])." AND password_cliente = ''");
		
		if ( $query_ver->NumeroRegistros() > 0 ){			
				// el cliente existe en la BDD, su email , seguro pidio descarga de catalogo
				$referer = "";
				$referer = $_SESSION['donregalo_flujo'];
				$inicio = $_SESSION['donregalo_inicio'];
			    
				$row = $query_ver->verRegistros();				
				
				$id = $row[0];
				$sigacceso = $row[2] + 1;
				
				if(isset($_GET['password'])&&!empty($_GET['password'])){
					$password = $_GET['password'];
				}else{
					$password = randomPassword();
				}
				
				
				$query=new Consulta("UPDATE clientes SET 
											nombre_cliente = ".comillas_inteligentes($_GET['nombres']).",
											apellidos_cliente = ".comillas_inteligentes($_GET['apellidos']).",
											password_cliente = '".encriptar($password)."',
											telefono_cliente = ".comillas_inteligentes($_GET['telefono']).",
											direccion_cliente = ".comillas_inteligentes($_GET['direccion']).",
											ciudad_cliente = ".comillas_inteligentes($_GET['ciudad']).",
											pais_cliente = ".comillas_inteligentes($_GET['pais']).",
											pagina_referencia_cliente = '".$referer."',
											pagina_inicio_cliente = '".$inicio."' WHERE id_cliente = '".$id."'");
											
				new Consulta("UPDATE clientes_informacion SET 
											ultimo_acceso_cliente = '".date('Y-m-d H:i:s')."',
											numero_accesos_cliente = '".$sigacceso."',
											fecha_ultima_modificacion =  '".date('Y-m-d H:i:s')."'
											WHERE id_cliente = '".$id."'");
											
					$cliente = $this->_cuenta->getCliente();	
					$prods = count($cliente->getCarrito()->getContent());
					$cliente->__set('_logeado',TRUE);
                    $cliente->__set('_id',$id);
                    $cliente->__set('_nombre',$_GET['nombres']);
                    $cliente->__set('_usuario',$_GET['nombres']." ".$_GET['apellidos']);				
                    $cliente->__set('_email',$_GET['email']);
                    $cliente->sumaIngreso();			

                    $subject = " Registro en ".NOMBRE_SITIO;
                    $msg = "			

                            BIENVENIDO A ".NOMBRE_SITIO."

                            Estimado(a) ".$_GET['nombres']." ".$_GET['apellidos']." su cuenta a sido creada:

                            Datos de tu Cuenta
                            --------------------------------------
                            Usuario: ".$_GET['email']." 
                            Contraseña: ".$password."

                            Con estos datos de acceso podras ingresar a tu cuenta en nuestro sitio web "._url_web_."seccion/cuenta (".NOMBRE_SITIO.")


                            Atte
                            ".NOMBRE_SITIO."

                            Telf. ".TELEFONO."
                            ".EMAIL_PEDIDOS."
                            "._url_web_."

                            ";				
                            @mail($_GET['email'],$subject,$msg,"from: ".EMAIL_CONTACTENOS);	                            
                            unset($_SESSION['register']);
							
							
							if( $prods > 0 ){
								//se va a pedido
								echo 2;
							}else if( $prods == 0 ){
								// se va a cuenta
								echo 1;
							}
				
				
			
		}else if($query_ver->NumeroRegistros() == 0){
		
                    $referer = "";
                    $referer = $_SESSION['donregalo_flujo'];
                    $inicio = $_SESSION['donregalo_inicio'];
                    
					if(isset($_GET['password'])&&!empty($_GET['password'])){
						$password = $_GET['password'];
					}else{
						$password = randomPassword();
					}
					
                    $query=new Consulta("INSERT INTO clientes VALUES('','',
														".comillas_inteligentes($_GET['nombres']).",
														".comillas_inteligentes($_GET['apellidos']).",
														".comillas_inteligentes($_GET['email']).",
														'".encriptar($password)."',
														".comillas_inteligentes($_GET['telefono']).",
														".comillas_inteligentes($_GET['direccion']).",
														".comillas_inteligentes($_GET['ciudad']).",
														".comillas_inteligentes($_GET['pais']).",
														'0',
														'".$referer."',
														'".$inicio."')");
                    $id=$query->nuevoId();	
                    $objeto_user_agent = new UserAgent();				
                    $query_i = new Consulta("INSERT INTO clientes_informacion VALUES('".$id."',
																														 '".date('Y-m-d H:i:s')."',
									'1',
																														 '".date('Y-m-d H:i:s')."',
																														 '".date('Y-m-d H:i:s')."',
																														 '0','".$objeto_user_agent->getBrowserName()."','".$objeto_user_agent->getOs()."','".$objeto_user_agent->getUserAgentString()."')");
       
                    
		$cliente = $this->_cuenta->getCliente();	
		$prods = count($cliente->getCarrito()->getContent());
		$cliente->__set('_logeado',TRUE);
                    $cliente->__set('_id',$id);
                    $cliente->__set('_nombre',$_GET['nombres']);
                    $cliente->__set('_usuario',$_GET['nombres']." ".$_GET['apellidos']);				
                    $cliente->__set('_email',$_GET['email']);
                    $cliente->sumaIngreso();			

                    $subject = " Registro en ".NOMBRE_SITIO;
                    $msg = "			

                            BIENVENIDO A ".NOMBRE_SITIO."

                            Estimado(a) ".$_GET['nombres']." ".$_GET['apellidos']." su cuenta a sido creada:

                            Datos de tu Cuenta
                            --------------------------------------
                            Usuario: ".$_GET['email']." 
                            Contraseña: ".$password."

                            Con estos datos de acceso podras ingresar a tu cuenta en nuestro sitio web "._url_web_."seccion/cuenta (".NOMBRE_SITIO.")


                            Atte
                            ".NOMBRE_SITIO."

                            Telf. ".TELEFONO."
                            ".EMAIL_PEDIDOS."
                            "._url_web_."

                            ";				
                            @mail($_GET['email'],$subject,$msg,"from: ".EMAIL_CONTACTENOS);	                            
                            unset($_SESSION['register']);
							
							
							if( $prods > 0 ){
								//se va a pedido
								echo 2;
							}else if( $prods == 0 ){
								// se va a cuenta
								echo 1;
							}
							
			
		}else{
			
			
				$_SESSION['register']['nombre']=$_GET['nombres'];
				$_SESSION['register']['apellidos']=$_GET['apellidos'];								
				$_SESSION['register']['email']=$_GET['email'];
				$_SESSION['register']['telefono']=$_GET['telefono'];							
				$_SESSION['register']['direccion']=$_GET['direccion'];
				$_SESSION['register']['ciudad']=$_GET['ciudad'];
				$_SESSION['register']['pais']=$_GET['pais'];
				
				echo 0;								
		}
	}
	
	public function isLogueadoAjax(){
		return $this->_cuenta->getCliente()->getLogeado();
	}
	
	//login acceso ajax
	public function accesoAjax(){
		$email = $_GET['email_login'];
		$password = $_GET['password_login'];
		
		$sql = "SELECT * FROM clientes 
			WHERE email_cliente=".comillas_inteligentes($email)." AND 
				  password_cliente=".comillas_inteligentes(encriptar($password));
		
		$query = new Consulta($sql);
		$row   = $query->VerRegistro();
		
		$prods = count($this->_cuenta->getCliente()->getCarrito()->getContent());	
		$intencion = $_GET['intencion'];	
		
		// cuando hay productos en el carrito
		if($query->NumeroRegistros() > 0 && $prods > 0 && $intencion == 2){
			
			$cliente = $this->_cuenta->getCliente();			
			$this->_cuenta->setData($row['id_cliente']);			
			$cliente->setLogeado(TRUE);
			$cliente->sumaIngreso();
			echo 2;
			
		// cuando no hay producto en el carrito	o solo quiero ver mi perfil
		}else if( $query->NumeroRegistros() > 0 && $intencion == 1){
			
			$cliente = $this->_cuenta->getCliente();			
			$this->_cuenta->setData($row['id_cliente']);			
			$cliente->setLogeado(TRUE);
			$cliente->sumaIngreso();
			echo 1;
			
		}else{						
			echo 0;
		}
	}
	
	// olvidaste password ajax
	public function sendOlvidastePasswordAjax(){
		$sql = "SELECT * FROM clientes WHERE email_cliente=".comillas_inteligentes($_GET['email_olvidaste_password'])."";
		$query=new Consulta($sql);
		if($query->NumeroRegistros()==1){
			$row=$query->VerRegistro();
			$email=$row['email_cliente'];
			$subject="Datos de Cuenta - ".NOMBRE_SITIO;
			$msg="
			Estimado(a) ".$row['nombre_cliente']." ".$row['apellidos_cliente'].". 
			A continuación le recordamos los datos de acceso a ".NOMBRE_SITIO.":
			
			Email: ".$row['email_cliente']." 
			Contraseña: ".desencriptar($row['password_cliente'])."			
			
			
			Atte
			".NOMBRE_SITIO."
			
			"._url_web_."	
						
			";	
			//echo desencriptar($row['password_cliente']);
			@mail($email,$subject,$msg,"from: ".EMAIL_PEDIDOS );	
			//echo "Se enviaron sus datos de acceso correctamente a su e-mail";
			//$this->setNotificacion("Sus datos de acceso fueron enviados a la bandeja de su correo electronico.", 2);
			echo 1;
										
		}else{
			//$this->setNotificacion("El correo no existe en nustra base de datos", 1);
			echo 0;
		}
	}
	
	//olvidaste password Popups	
	public function olvidastePasswordAjax(){
	   ?>
       <div id="franja-top"></div>
       <div id="popup_acceso" class="olvidaste"><a id="btn_close"></a>
       <h2>¿Olvidaste tu Password?</h2>
            <form method="get" id="olvidaste-password-form" onsubmit="return validate_olvidastePassword(this)">
            	<ul><li>
                <label>Email:</label><br/>
                <input type="text" name="email_olvidaste_password" id="email_olvidaste_password"></li>
                </ul>
                <input type="hidden" name="action" value="sendOlvidastePassword">
                <input type="submit" id="enviar_password" value="">
            </form>
       </div>
       <script type="text/javascript">
       	$(document).ready(function(e){
			/* BTN CLOSE POPUP LOGIN */	
			$("#btn_close").on("click",function(){
				$.fancybox.close();
			});
		});
       </script>
       <?php
	}
	
	
	//registro paso 1 registro rapido 
	public function loginRapidoAjax(){
	   $ubigeo = new Ubigeos($msg);		
	   $pais = $ubigeo->getPaises();
	   
	   ?>
       <div id="franja-top"></div>
       <div id="popup_acceso" class="registro"><a id="btn_close"></a>
       <h2>Tus Datos:</h2>
            <p>Por favor ingresa tus datos <strong>o si ya eres cliente logueate  <a href="ajax.php?action=login" class="popup fancybox.ajax">aquí</a></strong></p>
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
            <form method="get" id="registro-form" onsubmit="return validate_login_rapido(this,addCuenta)">
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
        <?php
	}

	//Logins Popups	
	public function loginAjax(){
           // include(_tpl_includes_."inc.header.php"); ?>       
       <div id="franja-top"></div>
       <div id="popup_acceso" class="login"><a id="btn_close"></a>
       <h2>Entrar aquí:</h2>
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
            <a href="ajax.php?action=registrarse" class="popup fancybox.ajax marron">Soy nuevo cliente, registrate aquí</a><br/>
            <a href="ajax.php?action=olvidastePassword" class="popup fancybox.ajax">¿Olvidaste tu password?</a><br/>
       </div>
       <script type="text/javascript">
       	$(document).ready(function(e){
			/* BTN CLOSE POPUP LOGIN */	
			$("#btn_close").on("click",function(){
				$.fancybox.close();
			});
		});
       </script>
        <?php
	}
	
	// Registrarse Popup
	public function registrarseAjax(){
	   $ubigeo = new Ubigeos($msg);		
	   $pais = $ubigeo->getPaises();
	   
	   ?>
       <div id="franja-top"></div>
       <div id="popup_acceso" class="registro"><a id="btn_close"></a>
       <h2>Soy nuevo cliente, regístrate aquí:</h2>
            <form method="get" id="registro-form" onsubmit="return validate_registro(this,addCuenta)">
            	<div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label for="nombre">Nombres:<span class="inf">*</span></label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" value="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label for="telefono">&nbsp;&nbsp;Teléfono:<span class="inf">*</span>&nbsp;</label>
                                    <input type="text" class="form-control" name="telefono" id="telefono" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label for="email">Email:<span class="inf">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label for="direccion">&nbsp;&nbsp;Dirección:<span class="inf">*</span></label>
                                    <input type="text" class="form-control" id="direccion" name="direccion">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="mensaje">Mensaje:<span class="inf">*</span>&nbsp;&nbsp;</label>
                                <textarea class="form-control" rows="3" cols="74" name="mensaje" id="mensaje"></textarea>
                            </div>
                        </div>
                        <div class="text-center margin-top-20">
                            <input type="submit" class="button-submit" value="Enviar Mensaje">
                        </div> 
            	<!--
            	<ul>
                <li><label>Nombres:</label><b>*</b><br/>
                <input type="text" name="nombres" id="nombres"></li>
                <li><label>Apellidos:</label><b>*</b><br/>
                <input type="text" name="apellidos" id="apellidos"></li>
                <li><label>Email:</label><b>*</b><br/>
                <input type="text" name="email" id="email"></li>
                <li><label>Password:</label><b>*</b><br/>
                <input type="password" name="password" id="password"></li>
                <li><label>Repetir Password:</label><b>*</b><br/>
                <input type="password" name="repeat_password" id="repeat_password"></li>
                </ul>
                <ul>
                <li><label>Télefono:</label><b>*</b><br/>
                <input type="text" name="telefono" id="telefono"></li>
                <li><label>Dirección:</label><b>*</b><br/>
                <input type="text" name="direccion" id="direccion"></li>
                <li><label>Ciudad:</label><b>*</b><br/>
                <input type="text" name="ciudad" id="ciudad"></li>
                <li><label>País:</label><b>*</b><br/>
                <select name="pais" id="pais"><option value="">Elegir País...</option>
				 <?php for($i=0;$i<count($pais);$i++){  ?>
                   <option value="<?php echo $pais[$i]['id_pais']?>"><?php echo $pais[$i]['nombre']?></option>
                 <?php }?>
                </select>
                </li>
                </ul>
                <input type="hidden" name="action" value="sendRegistrarse">
                <br class="cleaner"><br/>
                <input type="submit" id="registrarse" value="">
            -->
            </form>
            <br/>
       </div>
       <script type="text/javascript">
       	$(document).ready(function(e){
			/* BTN CLOSE POPUP LOGIN */	
			$("#btn_close").on("click",function(){
				$.fancybox.close();
			});
		});
       </script>
        <?php
	}
	
	
	// CLIENTE add Descarga Catalogo
	public function addClienteAjax(){
		
		$referer = "";
		$referer = $_SESSION['donregalo_flujo'];
		$inicio = $_SESSION['donregalo_inicio'];
                   
		$query = new Consulta("SELECT * FROM clientes WHERE email_cliente = ".comillas_inteligentes($_GET['mail_catalogo'])."");
		if( $query->NumeroRegistros() > 0 ){
			new Consulta("UPDATE clientes SET observacion_cliente = 'Cliente se envió url de catalogo' WHERE email_cliente = '".$_GET['mail_catalogo']."'");
			
		}else{
			new Consulta("INSERT INTO clientes VALUES ( '',
													".comillas_inteligentes($_GET['name_catalogo']).",
													'',
													".comillas_inteligentes($_GET['mail_catalogo']).",
													'', 
													'',
													'',
													'',
													'',
													'Cliente se envió url de catalogo',
													'".$referer."',
													'".$inicio."')");
				
		}
		
		
		$subject = " Envío de catalogo - ".NOMBRE_SITIO;
		$msg = "			

				BIENVENIDO A ".NOMBRE_SITIO."

				Estimado(a) ".$_GET['nombres'].", a continuacion el link para que pueda descargar el catalogo de ".NOMBRE_SITIO.":

				<a href=\"www.donregalo.php/descargarcatalogo.php\">Link de descarga<a>
				
				Atte
				".NOMBRE_SITIO."

				Telf. ".TELEFONO."
				".EMAIL_PEDIDOS."
				"._url_web_."

				";				
				@mail($_GET['email'],$subject,$msg,"from: ".EMAIL_CONTACTENOS);

		
		
		
		echo 1;
		
	}
	
	// CESTA 
	public function deleteCestaAjax(){
            $carrito = $this->_cuenta->getCliente()->getCarrito();					
            $carrito->DeleteProducto($_GET['id']);
            $this->listCestaAjax();
	}
	
	public function cantidadCestaAjax(){		
		
            $optiones = deCadenaToArrayOpcionesCarrito($_GET['opciones']);		
            $carrito = $this->_cuenta->getCliente()->getCarrito();
            $carrito->AddProducto($_GET['id'], $optiones, 0, $_GET['cantidad']);
            $this->listCestaAjax();
	}
	
	public function listCestaAjax(){
		$carrito = $this->_cuenta->getCliente()->getCarrito();					
		$content = $carrito->getContent();		
		$total_c = $carrito->count_Content();
		echo $total_c;	
	}
	public function listBagShopAjax()
	{
		$carrito = $this->_cuenta->getCliente()->getCarrito();					
		$content = $carrito->getContent();		
		$total_c = $carrito->count_Content();
		?>
		<div class="contenedor-detalle-bag-shop">
		<?php
		reset($content);
        while( list($key,) = each( $content ) ){
            $producto = new Producto((int)$key ,$idioma);						
            $precio = $producto->__get("_precio_producto");
            $imagenes = $producto->__get("_imagenes");
            $IND = preg_replace("/[{}]/","",$key);
            $complementos = $content[$key]['opciones'];
            $preciocmp = 0;  ?>
			<div class="row row-detalle">
		        <div class="col-3">
		          <a href="<?php echo str_replace(" ","-",$producto->__get("_nombre"))?>">
		          	<?php if ($imagenes[0]['thumbnail']!=""){ ?>
		          		<img class="img-bag-shop" src="<?php echo _catalogo_ ?>basecatalogo.png" style="background-image: url(<?php echo _catalogo_ . $imagenes[0]['thumbnail']?>) ;" alt="Product">
		          	<?php }else{ ?>
		          		<img class="img-bag-shop" src="<?php echo _catalogo_ ?>basecatalogo.png" style="background-image: url(<?php echo _imgs_ . "not_image_disponible_thumb.jpg"?>) ;" alt="Product">
		          	<?php } ?>
		          </a>
		        </div>
		        <div class="col-5 col-detalles-bag-shop">
		          <span class="nombre-producto-bag-shop"><?php echo $producto->__get("_nombre")?></span>
		          <p class="cantidad-producto-bag-shop">Cantidad: &nbsp;
                    <span>
                        <i class="fas fa-minus-circle"></i>&nbsp;
                        <?php echo $content[$key]['cantidad'];?>&nbsp;
                        <i class="fas fa-plus-circle"></i>
                    </span>
                </p>
		          <?php if(is_array($complementos) && count($complementos)>0 ): ?>
		          <div class="adicional-producto-bag-shop">
		          	  <?php   
	                    foreach( $complementos as $id=>$cantidad ):
	                    $prod = new Producto( $id );
	                    $imgsc = $prod->__get("_imagenes");
	                    $preciocmp += $prod->__get("_precio_producto") * $cantidad;
	                  ?>
		              <img src="<?php echo _catalogo_ . $imgsc[0]['thumbnail']?>" alt=""> 
		              <span><?php echo $cantidad;?> <?php echo $prod->__get("_nombre")?></span>
		              <br>
		              <?php endforeach;?>
		          </div>
		          <?php endif;?>
		        </div>
		        <div class="col-3 col-monto-bag-shop">
		          <div class="row">
		            <div class="col text-left"> 
		              <span>$<?php echo number_format(($precio + $preciocmp) * $content[$key]['cantidad'],2)?></span><br>
                      <span>S/<?php echo number_format((($precio + $preciocmp) * $content[$key]['cantidad'])*TIPO_CAMBIO,2)?></span>
		            </div>
		          </div>
		        </div>
                <div class="col-1 col-delete-bag-shop">
                  <div class="row">
                    <div class="col text-left"> 
                      <a onclick="eliminarItemCarrito()"><i class="far fa-trash-alt"></i></a>
                    </div>
                  </div>
                </div>
	        </div>
	    
		<?php
		}
		?>
		</div>
		<div class="row row-total-bag-shop">
	      <div class="col-12">
	        <dl>
	          <dt>Subtotal :</dt>
	          <dd><span>S/.<?php echo number_format($carrito->getAmount()*TIPO_CAMBIO, 2); ?></span>&nbsp; $<?php echo number_format($carrito->getAmount(), 2); ?></dd>
	        </dl>
	      </div>
	      <div class="col-12 text-center">
	        <!-- <a class="btn btn-comprar-bag-shop" href="<?php echo _url_web_ ?>seccion/cesta">COMPRAR</a> -->
	        <?php if ($total_c > 0): ?>
	        <a class="btn btn-comprar-bag-shop" onclick="realizarCompra()">COMPRAR</a>
	        <?php endif ?>
	      </div>
	    </div>
		<?php
	}
	
	// RECLAMACION 
	public function sendMailReclamacionAjax(){
		
		$subject = " Se ha enviado una reclamacion - ".NOMBRE_SITIO;
		
		$msg.= "\nTipo de persona: ".($_GET['persona_natural'])?'Persona Natural':'Persona Juridica';
		$msg.= "\nNombres y Apellidos: ".$_GET['nombres'];
		$msg.= "\nDoc. Identidad: ".($_GET['tipo_documento'])?'DNI':'RUC';
		$msg.= "\nNumero de documento: ".$_GET['numero_documento'];
		
		if($_GET['persona_natural']==2)
			$msg.= "\nRazón Social: ".$_GET['razon_social'];
				
		$msg.= "\nDomicilio: ".$_GET['direccion2'];		
		$msg.= "\nDistrito: ".$_GET['distrito'];		
		$msg.= "\nEmail: ".$_GET['email'];
		
		if($_GET['menor_edad']==1){
			$msg.= "\nMenor de Edad: SI";
			$msg.= "\nDatos del padre o madre tutor:";
			$msg.= "\nNombres y Apellidos: ".$_GET['nombres_tutor'];
			$msg.= "\nDNI/CE: ".$_GET['documento_tutor'];
		}
		
		
		if($_GET['tipo_solicitud']==1){
			$msg.= "\nTipo de solicitud: RECLAMO";
		}else{
			$msg.= "\nTipo de solicitud: QUEJA";
		}
		
		if( $_GET['contrato']==1 ){
			$msg.= "\nBien contratado: PRODUCTO";
		}else{
			$msg.= "\nBien contratado: SERVICIO";
		}
		
		if( $_GET['comprobante_pago']==1 ){
			$msg.= "\nComprobrante de Pago: FACTURA";
		}else if( $_GET['comprobante_pago']==2 ){
			$msg.= "\nComprobrante de Pago: BOLETA";
		}else if( $_GET['comprobante_pago']==3 ){
			$msg.= "\nComprobrante de Pago: RECIBO";
		}else if( $_GET['comprobante_pago']==4 ){
			$msg.= "\nComprobrante de Pago: SIN COMPROBANTE";
		}
		
		$msg.="\nNumero de Comprobante:".$_GET['documento_numero_pago'];
		
		if( $_GET['sedes']==0 ){
			$msg.="\nSede: NINGUNO";
		}else if( $_GET['sedes']==3 ){
			$msg.="\nSede: PRINCIPAL";
		}
		
		
		$msg.="\nDescripcion del servicio:".$_GET['descripcion_servicio'];
		$msg.="\nDescripcion de la reclamcion:".$_GET['descripcion_reclamacion'];		
		
						
		if(mail(EMAIL_RECLAMACIONES,$subject,$msg,"from: ". $_GET['email'])){
			echo 1;
		}else{
			echo 0;
		}
		
	}
	
	// listar mensajes de tipo n 
	public function listMensajesAjax(){
		
		$data = array();
		
		$query = new Consulta("SELECT * FROM mensajes WHERE id_tipo_mensaje = '".$_GET['id']."'");
		while($rowm = $query->VerRegistro()){
			$data[] = array(
                            'id'=>$rowm['id_mensaje'],
                            'descripcion'=>$rowm['descripcion_mensaje']
                            );
		}
		
		echo json_encode($data);
	}
        
    public function generarGuiasAjax(){
            $ids_pedidos = $_GET["pedidos"];
            $ids = explode(",",$ids_pedidos);
            $total_pedidos = count($ids);
            
            $time = time();
            ob_start();
            include(_panel_admin_.'guias_entrega_html.php');
            $content = ob_get_clean();
            $nombre_archivo = _files_guias_entrega_."guia-entrega-".$time.".pdf";
            $ruta_archivo = _url_guias_entrega_."guia-entrega-".$time.".pdf";
            // convert in PDF
            require_once(_util_.'html2pdf/html2pdf.class.php');
            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'es');
                $html2pdf->writeHTML($content);
                $html2pdf->Output($nombre_archivo,'F');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            } 
            
            //$seguimientos = Seguimientos::getSeguimientosPorEmpresa($id_empresa);
            if($total_pedidos > 0){   
                //for($i=0; $i < $total_seguimientos; $i++ ){ ?>
                    <div style="border:1px dotted #ccc;border-radius:5px;padding:5px;margin-top:8px;background-color:rgb(224, 238, 246)  ">
                        <div style="color:green">Descargar archivo de PDF <a target="_blank" href="<?php echo $ruta_archivo ?>">Click Aquí</a></div>
                        
                    </div> <?php
               // }
            }else{
                
                echo "No hay datos";
            }
        }
        
    public function generarTarjetasAjax(){
        $ids_pedidos = $_GET["pedidos"];
        $ids = explode(",",$ids_pedidos);
        $total_pedidos = count($ids);

        $time = time();
        ob_start();
        include(_panel_admin_.'tarjetas_html.php');
        $content = ob_get_clean();
        $nombre_archivo = _files_guias_entrega_."tarjeta-A6-".$time.".pdf";
        $ruta_archivo = _url_guias_entrega_."tarjeta-A6-".$time.".pdf";
        // convert in PDF
        require_once(_util_.'html2pdf/html2pdf.class.php');
        try
        {
            $html2pdf = new HTML2PDF('P', 'A6', 'es');
            $html2pdf->writeHTML($content);
            $html2pdf->Output($nombre_archivo,'F');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        } 

        //$seguimientos = Seguimientos::getSeguimientosPorEmpresa($id_empresa);
        if($total_pedidos > 0){   
            //for($i=0; $i < $total_seguimientos; $i++ ){ ?>
                <div style="border:1px dotted #ccc;border-radius:5px;padding:5px;margin-top:8px;background-color:rgb(224, 238, 246)  ">
                    <div style="color:green">Descargar archivo de PDF <a target="_blank" href="<?php echo $ruta_archivo ?>">Click Aquí</a></div>

                </div> <?php
           // }
        }else{

            echo "No hay datos";
        }
    }
    
    public function asignarMovilidadAjax(){ 
        
        $sql = "UPDATE pedidos SET id_chofer='".$_GET["id_chofer"]."' WHERE id_pedido IN (".$_GET["pedidos"].") ";
        $query = new Consulta($sql);
 
        if($_GET["pedidos"] !="" ){   
            //for($i=0; $i < $total_seguimientos; $i++ ){ ?>
                <div style="border:1px dotted #ccc;border-radius:5px;padding:5px;margin-top:8px;background-color:rgb(224, 238, 246)  ">
                    <div style="color:green">El chofer fue asignado a los pedidos seleccionados (<?php echo $_GET["pedidos"] ?>)</div>
                </div> <?php
           // }
        }else{

            echo "No hay datos";
        }
    }
    
    public function cambiarEstadoAjax(){ 
        
        $sql = "UPDATE pedidos SET estado_pedido='".$_GET["id_estado"]."' WHERE id_pedido IN (".$_GET["pedidos"].") ";
        $query = new Consulta($sql);
 
        if($_GET["pedidos"] !="" ){   
            //for($i=0; $i < $total_seguimientos; $i++ ){ ?>
                <div style="border:1px dotted #ccc;border-radius:5px;padding:5px;margin-top:8px;background-color:rgb(224, 238, 246)  ">
                    <div style="color:green">Se cambiaron los estados a los pedidos seleccionados (<?php echo $_GET["pedidos"] ?>)</div>
                </div> <?php
           // }
        }else{

            echo "No hay datos";
        }
    }
    
    public function buscarClienteAjax(){
        
        $espacio = " ";
        $q = str_replace($espacio, "(.*)", utf8_encode($_GET['term']));
		$queryc  = new Consulta("SELECT * FROM clientes WHERE CONCAT(nombre_cliente,' ',apellidos_cliente) REGEXP '$q' LIMIT 0,20");
	
		//	$sOutput = '{';
		//	$sOutput .= 'query: '."'".$_GET['query']."',";
		//	$sOutput .= 'suggestions: [ ';
		while ($row = $queryc->VerRegistro())
		{
	            $retorno = $row['nombre_cliente'].' '.$row['apellidos_cliente'];
	            $sOutput[] = array(
	                "id"    => $row['id_cliente'],
	                "nombre"=>  $retorno
	                    );
		}
			
		//$sOutput = substr_replace( $sOutput, "", -1 );
		//$sOutput .= '] }';
		//echo $sOutput;
        echo json_encode($sOutput);
    }
    
    public function getInsumosPorProductoAjax(){
        
        $id_producto = $_GET["id_producto"];
        $obj_producto = new Producto($id_producto);
        if(is_object($obj_producto)){
            $insumos = $obj_producto->__get("_insumos");
            $total_insumos = count($insumos);
            if($total_insumos > 0){
                foreach ($insumos as $key=>$value){ ?>
                    <div style="border:1px dotted #ccc;border-radius:5px;padding:5px;margin-top:8px;background-color:rgb(224, 238, 246)">
                        <div style="color:green;display: inline-block;width:80%"><?php echo $value[0] ?></div>
                        <div style="color:green;display:inline-block;width:15%"> <?php echo $value[1] ?></div> 
                    </div> <?php
                } 
            }
        }else{
            
        }
    } 

    //*** INICO FECHAS ESPECIALES ***//

    //INICIO AGREGAR UNA FECHA ESPECIAL (PAGO FINALIZADO)
    public function nuevoClienteDestinatarioAjax(){
		$sql_destinatario = "INSERT INTO destinatarios VALUES ('','".$_GET['id_cliente']."','".$_GET['nombre_destinatario']."','".$_GET['apellidos_destinatarios']."','".$_GET['telefono_destinatario']."','".addslashes($_GET['direccion_destinatario'])."','".addslashes($_GET['referencia_destinatario'])."')";
        $query_destinatario = new Consulta($sql_destinatario);
		$id_destinatario = $query_destinatario->nuevoId();
		$_GET['id_destinatario'] = $id_destinatario;
		self::addClienteDestinatarioAjax();
	}

	public function eliminarFechaEspecialAjax()
	{
		$sql = "DELETE FROM fechas_especiales WHERE id_fecha_especial = ".$_POST['id']." ";
		$query = new Consulta($sql);

	}

	public function addClienteDestinatarioAjax(){
		list($a,$b,$c)= explode("/",$_GET['fecha_especial']); // 13/02/2018
		$fecha_especial = $c.'-'.$b.'-'.$a;
		$query = new Consulta("INSERT INTO fechas_especiales VALUES ('','".$_GET['id_destinatario']."','".$_GET['id_tipo_destinatario']."','".$_GET['id_ocasion']."','".$fecha_especial."')");
		self::getFechasEspecialesAjax();
	}	

	public function getFechasEspecialesAjax(){
		$cuenta = $_SESSION["donregalo"];
		$fechas_especiales = Cliente::getFechasEspecialesClientes($cuenta->getCliente()->__get('_id'));
        $i=1;
        if (is_array($fechas_especiales) && count($fechas_especiales)>0) {
        foreach ($fechas_especiales as $key => $fecha_especial) { ?>
            <tr class="info">
                <td ><?php echo $i ?></td>
                <td ><?php echo $fecha_especial['nombre_destinatario'].' '.$fecha_especial['apellidos_destinatarios'] ?></td> 
                <td ><?php echo $fecha_especial['nombre_tipo_destinatario'] ?></td> 
                <td ><?php echo $fecha_especial['nombre_ocasion'] ?></td> 
                <td ><?php echo $fecha_especial['telefono_destinatario'] ?></td> 
                <td >
                	<?php if ($fecha_especial['fecha_especial']!='') {
                        echo fecha_short($fecha_especial['fecha_especial']);
                    }else{ ?>
                        <a class="agregar-fecha-especial" data-toggle="modal" data-target=".modal-agregar-fecha-especial" data-nombres="<?php echo $fecha_especial['nombre_destinatario'].' '.$fecha_especial['apellidos_destinatarios'] ?>" data-id-cliente="<?php echo $cuenta->getCliente()->__get('_id') ?>" data-id-destinatario="<?php echo $fecha_especial['id_destinatario'] ?>">
                            <button type="button" class="btn btn-success">Asignar</button>
                        </a>
                    <?php } ?>
                </td>
            </tr> 
        <?php $i++; } } ?>
        <script type="text/javascript">
        $(document).ready(function(e){
			/*** INICIO MODAL ASIGNAR FECHA ESPECIAL ***/
			$('.agregar-fecha-especial').on('click', function(ev) {
			      var nombre_destinatario  = $(this).data('nombres');
			      var id_destinatario  = $(this).data('id-destinatario');
			      var id_cliente  = $(this).data('id-cliente');
			      alert(id_destinatario);
			      $(".modal-agregar-fecha-especial #id_cliente").val( id_cliente );
			      $(".modal-agregar-fecha-especial #id_destinatario").val( id_destinatario );
			      $(".modal-agregar-fecha-especial .nombre_destinatario").text( nombre_destinatario );
			});
			/*** INICIO MODAL ASIGNAR FECHA ESPECIAL ***/
		});
		</script>
	<?php }

	public function addClienteFechaEspecialAjax()
	{
		$cliente = $_POST['cliente'];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$direccion = $_POST['direccion'];
		$referencia = $_POST['referencia'];
		$telefono = $_POST['telefono'];
		$destinatario = $_POST['destinatario'];
		$ocasion = $_POST['ocasion'];
		$fecha = $_POST['fecha'];
		// list($a,$b,$c)= explode("-",$_GET['fecha']); // 13/02/2018
		// $fecha_especial = $c.'-'.$b.'-'.$a;
		// $fecha = $fecha_especial;
		$sql_destinatario = "INSERT INTO destinatarios VALUES ('',".$cliente.",'".$nombre."','".$apellido."','".$telefono."','".addslashes($direccion)."','".addslashes($referencia)."')";
        $query_destinatario = new Consulta($sql_destinatario);
		$id_destinatario = $query_destinatario->nuevoId();
		$sql="INSERT INTO fechas_especiales (id_destinatario, id_tipo_destinatario, id_ocasion, fecha_especial) 
		VALUES (".$id_destinatario.", ".$destinatario.", ".$ocasion.", '".$fecha."') ";
		$query = new Consulta($sql);
	}

	public function terminaCompletarFechaEspecialAjax()
	{
		$tipo = $_POST['tipo'];
		$ocasion = $_POST['ocasion'];
		$fecha = $_POST['fecha'];
		$destinatario = $_POST['destinatario'];
		$sql="INSERT INTO fechas_especiales (id_destinatario, id_tipo_destinatario, id_ocasion, fecha_especial) 
		VALUES (".$destinatario.", ".$tipo.", ".$ocasion.", '".$fecha."') ";
		$query = new Consulta($sql);
	}

	public function verDetalleFechaEspecialAjax()
	{
		$objFechaEspecial = new FechaEspecial($_POST['id']);
		?>
		<div class="row">
	        <div class="col-md-6">
	          <div class="form-group">
	            <label>Nombre:</label>
	            <input readonly="readonly" type="text" class="form-control form-control-rounded form-control-sm" value="<?php echo $objFechaEspecial->__get('_destinatario')->__get('_nombre') ?>">
	          </div>   
	        </div>
	        <div class="col-md-6">
	          <div class="form-group">
	            <label>Apellido:</label>
	            <input readonly="readonly" type="text" class="form-control form-control-rounded form-control-sm" value="<?php echo $objFechaEspecial->__get('_destinatario')->__get('_apellido') ?>">
	          </div>   
	        </div>

	        <div class="col-md-12">
	          <div class="form-group">
	            <label>Direccion:</label>
	            <textarea readonly="readonly" rows="1" class="form-control form-control-rounded form-control-sm"><?php echo $objFechaEspecial->__get('_destinatario')->__get('_direccion') ?></textarea>
	          </div>   
	        </div>
	        <div class="col-md-12">
	          <div class="form-group">
	            <label>Referencia:</label>
	            <textarea readonly="readonly" rows="1" class="form-control form-control-rounded form-control-sm"><?php echo $objFechaEspecial->__get('_destinatario')->__get('_referencia') ?></textarea>
	          </div>   
	        </div>

	        <div class="col-md-6">
	          <div class="form-group">
	            <label>Telefono:</label>
	            <input readonly="readonly" type="tel" class="form-control form-control-rounded form-control-sm" value="<?php echo $objFechaEspecial->__get('_destinatario')->__get('_telefono') ?>">
	          </div>      
	        </div>
	        <div class="col-md-6">
	          <div class="form-group">
	            <label>Destinatario:</label>
	            <input readonly="readonly" class="form-control form-control-rounded form-control-sm" value="<?php echo $objFechaEspecial->__get('_tipo_destinatario')->__get('_nombre') ?>">
	          </div>      
	        </div>
	        
	        <div class="col-md-6">
	          <div class="form-group">
	            <label>Ocasión:</label>
	            <input readonly="readonly" class="form-control form-control-rounded form-control-sm" value="<?php echo $objFechaEspecial->__get('_ocasion')->__get('_nombre') ?>">
	          </div>      
	        </div>
	        <div class="col-md-6">
	          <div class="form-group">
	            <label>Fecha:</label>
	            <input readonly="readonly" class="form-control form-control-rounded form-control-sm fecha-especial" value="<?php echo get_fecha_sql_a_html($objFechaEspecial->__get('_fecha')) ?>">
	          </div>
	        </div>
	    </div>
		<?php
	}

	public function validaSiEstoyLogeadoAjax()
	{
		if ($_SESSION['donregalo']->getCliente()->getLogeado() == FALSE) {
			/*SI NO SE ENCUENTRA LOGEADO*/
			echo "2";
		}else if ($_SESSION['donregalo']->getCliente()->getLogeado() == TRUE) {
			/*SI SE ENCUENTRA LOGEADO*/
			echo "1";
		}
	}
	
    
}