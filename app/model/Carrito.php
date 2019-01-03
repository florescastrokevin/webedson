<?php

  class Carrito {
  	 	 private $IdCar, $Total, $Content, $cliente, $Amount, $weight , $descuento = 0, $_id_pedido ;
		  	
	
    public function __construct($id_pedido = 0) {
        
        $this->_id_pedido = $id_pedido;
        if($this->_id_pedido > 0){ // si existe, leer de la base de datos
            $sql = "SELECT * FROM pedidos_productos WHERE id_pedido = '".$this->_id_pedido."'";			
            
            $query = new Consulta($sql);
            if($query->NumeroRegistros() > 0 ){
                while ($row = $query->VerRegistro()){
                    $this->Content[$row['id_producto']]['id_pedido_producto'] = $row['id_pedido_producto'];
					$this->Content[$row['id_producto']]['id'] = $row['id_producto'];
                    $this->Content[$row['id_producto']]['cantidad'] = $row['cantidad_pedido_producto'];
                    $this->Content[$row['id_producto']]['precio']   = $row['precio_final_pedido_producto']; 
                }
            }
        }
    }
            
    function CarritoCompras(){ //Genera un identificador para el carrito
        $date = date('YmdHis');
        $this->IdCar = $date;
    }
		
	 
	// Cuando el cliente registrado abandono el carrito y luego retorno a compra
	
	
	function RestaurarCarrito(){ 			
			
    	if(empty($this->cliente) && $this->cliente=="") return 0;
		     
	  	if($this->Content){
    		
                reset($this->Content);
        	while (list($id_producto, ) = each($this->Content)){
		
                    $cantidad = $this->Content[$id_producto]['cantidad'];
                    $textura  = isset($this->Content[$id_producto]['textura'])?$this->Content[$id_producto]['textura']:0;
                    $prods    = new Consulta("SELECT id_producto FROM clientes_cesta 
                                            WHERE id_cliente = '" . (int)$this->cliente . "' AND
                                             id_producto = '" . $id_producto . "' AND
                                             id_textura = '".$textura."' ");

                    if($prods->NumeroRegistros()==0){
                            $insert = new Consulta("INSERT INTO clientes_cesta 
                            (id_cliente, id_producto, id_textura, cantidad_cliente_cesta, fecha_ingreso_cliente_cesta) 
              VALUES('".(int)$this->cliente."', '".$id_producto."', '".$textura."', '".$cantidad."', '".date('Y-m-d')."')");					

                            if($this->Content[$id_producto]['opciones']){
                                    reset($this->Content[$id_producto]['opciones']);

                                    while(list($option, $value) = each($this->Content[$id_producto]['opciones'])){

                                            $opciones = new Consulta("INSERT INTO clientes_cesta_opciones 
                                            (id_cliente, id_producto, id_producto_atributo, id_producto_atributo_valor) VALUES 
                                            ('". (int)$this->cliente ."', '". $id_producto ."', '". (int)$option ."', '". (int)$value ."')");
                                    }
                            }
                    }else{
                            $productos = new Consulta("UPDATE clientes_cesta SET 
                                                            cantidad_cliente_cesta = '" . $cantidad . "',
                                                            id_textura = '".$textura."'								 
                                                    WHERE id_cliente = '" . (int)$this->cliente . "' AND
                                                            id_producto = '" . $id_producto . "' ");
                    }
       		}
      	}

    // reset per-session cart Content, but not the database Content
          $this->reset(FALSE);

          $prods_query = new Consulta("SELECT id_producto, cantidad_cliente_cesta FROM clientes_cesta WHERE id_cliente = '" . (int)$this->cliente . "'");
          while ($prods = $prods_query->VerRegistro()) {
            $this->Content[$prods['id_producto']] = array('cantidad' => $prods['cantidad_cliente_cesta']);
    // opciones
            $opciones_query = new Consulta("SELECT id_producto_atributo, id_producto_atributo_valor FROM clientes_cesta_opciones WHERE id_cliente = '" . (int)$this->cliente . "' and id_producto = '" . $prods['id_producto'] . "'");
            while ($opciones = $opciones_query->VerRegistro()) {
              $this->Content[$prods['id_producto']]['opciones'][$opciones['id_producto_atributo']] = $opciones['id_producto_atributo_valor'];
            }
          }
          $this->cleanup();
        }

		
		
		
		
		/* AGREGAR NUEVOS PRODUCTOS AL CARRITO DE COMPRAS*/
		
		function AddProducto($id_producto, $opciones='', $textura=0, $cantidad='1'){ 
			//echo " textura ".$textura."<br />";
			//echo 'IDANT:'.$id_producto;
			$id_producto = $textura > 0 ? $id_producto."(".$textura.")" : $id_producto ;
			
			$id_producto = get_uid_producto($id_producto, $opciones);
			$textura = explode("(",$id_producto);
			$textura = (int)$textura[1];
			
			//echo "IDPOST:".$id_producto;
			if($this->VerificaProducto($id_producto)){
				$this->UpdateCantidad($id_producto, $opciones, $textura, $cantidad);
			}else{	
				//if($cantidad==''){$cantidad=1;}
				/* INGRESO DE PRODUCTOS A LA SESION */	
				
				$this->Content[$id_producto]['cantidad'] = $cantidad;
				if(isset($textura) && $textura > 0)
				{  
					$this->Content[$id_producto]['textura'] = 'rojo';
				}
				 
				/* INGRESO DE PRODUCTOS A LA TABLA CLIENTES CESTA */
				if($this->cliente!="" && $this->cliente <> 0 ){
					
					$sql="INSERT INTO clientes_cesta  
					VALUES('','".$this->cliente."','".$id_producto."','".$textura."','".$cantidad."','".$precio_final."','".date('Y-m-d')."')";
					$query=new Consulta($sql);					
				}				
				
				//print_r($opciones);
				if ( is_array($opciones) ){
					reset($opciones);
				  	while (list($option, $value) = each($opciones)) {
				  								
						/* INRGESO DE OPCIONES A LA SESSION */
						$this->Content[$id_producto]['opciones'][$option] = $value;
					
						/* INGRESO DE PRODUCTOS A LA TABLA OPCIONES DE LOS PRODUCTOS EN LA CESTA*/
					
						if($this->cliente!="" &&  $this->cliente <> 0){
					 		$sq_opciones = new Consulta("INSERT INTO clientes_cesta_opciones 
												VALUES ('','".$this->cliente."', '".$id_producto."', '".$option."', '".$value."') ");
						}						
				  	}
				}			
			}
			$this->cleanup();
		}
		
		
		
		
	
	/*     LIMPIA EL CARRITO LOS PRODUCTOS REGISTRADOS PERO QUE TIENEN COMO CANTIDAD < 1       */
		
	function cleanup() {
     	
            reset($this->Content);
            while (list($key,) = each($this->Content)) {
        	if ($this->Content[$key]['cantidad'] < 1) {
          		unset($this->Content[$key]);
				
				// elimina de la base de datos
          		if (!empty($this->cliente)) {
            		$s = new Consulta("delete FROM clientes_cesta WHERE id_cliente = '" .(int)$this->cliente . "' and id_producto ='" . $key . "'");
            		$s = new Consulta("delete FROM clientes_cesta_opciones WHERE id_cliente = '" . (int)$this->cliente."' and id_producto = '" . $key . "'");
          		}
                    }
                }
        }	
		
		
		
		// ACTUALIZA LA CANTIDAD DE PRODUCTO				
				
		function UpdateCantidad($id_producto,  $opciones='', $textura=0, $cantidad = ''){
			
			$id_producto_string = get_uid_producto($id_producto, $opciones);
		  	$id_producto = get_id_producto($id_producto_string);
			$id_producto_num= (int)$id_producto;	
		  	if(is_numeric($id_producto_num) && isset($this->Content[$id_producto_string]) && is_numeric($cantidad)) {
	
		//cantidad	
			$this->Content[$id_producto_string] = array('cantidad' => $cantidad);
		//textura
			if(!empty($textura) && isset($textura))
			{  
				$this->Content[$id_producto_string]['textura'] = $textura;
			}
		
		// update database
				if(!empty($this->cliente)) $sq=new Consulta("update clientes_cesta set cantidad_cliente_cesta = '" . (int)$cantidad . "' WHERE id_cliente = '" . (int)$this->cliente . "' and id_producto = '" . $id_producto_string . "'");
		
				if(is_array($opciones)) {
					reset($opciones);
					while (list($option, $value) = each($opciones)) {
						
						$this->Content[$id_producto_string]['opciones'][$option] = $value;
						
		// update database
						if (!empty($this->cliente)) {
							$sq=new Consulta("update clientes_cesta_opciones set id_producto_atributo_valor = '" . (int)$value . "' WHERE id_cliente = '" . (int)$this->cliente . "' and id_producto = '" . $id_producto_string . "' and id_producto_atributo = '" . (int)$option . "'");
						}
					}
				}
			}		
		}	
		
		
		
		/*             ELIMINA PRODUCTO               */
			
		function DeleteProducto($id_producto){			
			unset($this->Content[$id_producto]);				
			if($this->cliente!=0 && !empty($this->cliente)){
				$sql="DELETE FROM clientes_cesta WHERE id_producto='".$id_producto."' AND id_cliente='".$this->cliente."'";
				$query=new Consulta($sql);
				$sql="DELETE FROM clientes_cesta WHERE id_producto='".$id_producto."' AND id_cliente='".$this->cliente."'";
				$query=new Consulta($sql);
			}
		}
		
			
		function VerificaProducto($id_producto){			
			if($this->Content[$id_producto]){
				return true;						
			}else{
				return false;				
			}				
		}
		
		function setDescuento($dscto){
			$this->descuento = $dscto;
		}
	
		
		function VaciarCarrito(){
			$this->Content=0;
			//$this->descuento=0;
		}
		
		function getDescuento(){
			return $this->descuento;
		}
		
		function envioEmail(){			
			if(is_array($this->Content) && sizeof($this->Content) > 0){					
$mens = 

"
------------------------------------------------------------------------------------------------
Email de Confirmacion de Pedido ".NOMBRE_SITIO."



		 				              DETALLE DE LA ORDEN 
------------------------------------------------------------------------------------------------
Item | Cantidad |             Producto          =>               Monto	
------------------------------------------------------------------------------------------------

".
$message .= " => " .number_format(($precio * $cliente->carrito->Content[$key]['cantidad']),2);
"

------------------------------------------------------------------------------------------------
Total en Productos => " . number_format($this->getAmount(),2)."
------------------------------------------------------------------------------------------------
";
				
				$j = 0;					
				reset($this->Content);
				while( list($key,) = each( $this->Content ) ){	
					$producto = new Producto((int)$key);						
					$precio = $producto->getPrecio();					
					
					$sql_productos_pedidos = " INSERT INTO pedidos 
				VALUES('','".$this->IdPedido."','".$key."','".$this->Content[$key]['cantidad']."','".$precio."')"; 
				$query_productos_pedidos = new Consulta($sql_productos_pedidos);
					
					
				}
			}
		}
		
		function GetContent() {
                    return $this->Content;
		}
		
		
		function verCarrito($cuenta,$idioma){ 
                    if(is_array($this->Content) && sizeof($this->Content) > 0){	?>             
            <div id="cesta"> 
            <div id="cesta_u"></div>            
            <div id="cesta_c">
            <span class="title_cesta">Cesta de Compras</span><br class="clear">   
			<form name="cesta" method="post" action="" style="margin-left:auto; margin-right:auto; width:850px;">                 
                
                 <div class="micta_head_blk direc_bold" style="margin-left:auto; margin-right:auto; float:none; width:100%; margin-top:10px;">
                    <div class="thead">
                    	<div class="c1 id"></div>
                        <div class="c2 descripcion">PRODUCTO</div>
                        <div class="c3 precio">PRECIO UNITARIO</div>
                        <div class="c4 cantidad">CANTIDAD</div>
                        <div class="c5 total">SUBTOTAL</div>                        
                   </div>
                   <br class="clear">
                   <hr />
            	</div>      
                
                
                 <?php
                        $j = 0;		
                        $totalP = 0;			
                        reset($this->Content);
                        while( list($key,) = each( $this->Content ) ){	
                                $producto = new Producto((int)$key ,$idioma);						
                                $precio = $producto->__get("_precio_producto")	
                                ?><div class="bg_cesta direc_head" id="<?php echo $key?>"> 
                                <div class="quitar_cesta">
                                    <div align="center">
                                        <div class="contents">
                            <a href="javascript:delete_unico_producto('<?php echo $key?>','<?php echo $this->Content[$key]['cantidad'] ?>')"><img src="aplication/webroot/imgs/btn_quitar.png"></a>
							<input type="hidden" name="id[]" value="<?php echo (int)$key?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="productos_cesta"> 
                                <div class="imagen">
							<?php $imagenes = $producto->__get("_imagenes");
                                                    if ($imagenes[0]['thumbnail']==""){
									?>
                                    <table width="100%" height="100%">
                                        <tr><td valign="middle" align="center">
                                        <img src="aplication/webroot/imgs/imagen_no_disponible.jpg" class="img_lst" width="100" >
                                        </td></tr>                
                                        </table>
									<?php
                                }else{
									?>
                                     <table width="100%" height="100%">
                                         <tr>
                                             <td valign="middle" align="center">
                                                 <a href="<?php echo str_replace(" ","-",$producto->__get("_nombre"))?>">
                                 <img src="<?php echo _img_file_;?>?imagen=<?php echo $imagenes[0]['imagen']; ?>&w=125&h=105"/>                                 </a>
                                 </tr></td></table>
                                    <?php
                                }  ?>

                                 </div>
				<div class="descripcion"> <br>
                                    <a href="<?php echo str_replace(" ","-",$producto->__get("_nombre"))?>" > <?php echo $producto->__get("_nombre")?> </a> <?php
														
                                             ?>	
                                    </div>
                            </div>	 
                        
                        <div class="precio_unico" id="precio_uni<?php echo $j;?>">
                        	<div class="contents">$
							<?php echo number_format($precio,2);?>
                            </div>
                        </div>                        
						<div class="cantidad_cesta">
							<div class="contents">
							<input type="hidden" name="id_producto[]"  value="<?php echo $key?>"/>
							<input type="hidden" name="textura[]"  value="<?php echo $this->Content[$key]['textura'] ?>"/>
							<input type="text" id="canti<?php echo $j ?>" name="cantidad[]" value="<?php echo $this->Content[$key]['cantidad'] ?>" size="6"  dir="<?php echo $j?>" class="cant" onkeyup="calcular('<?php echo $j?>',this.value);">
							
							<input type="hidden" id="cantih<?php echo $j ?>" value="<?php echo $this->Content[$key]['cantidad'] ?>" />
							</div>
						</div>	
						
						<div class="precio_unit_carro" id="precio_unit<?php echo $j;?>">
							<div class="contents">								
								<?php $prize = number_format($precio * $this->Content[$key]['cantidad'],2); ?>
                                <span class="color_cesta"><?php echo "$ ".$prize;?>	</span>							
							</div>
						</div> 						
						<br class="clear">					
						<?php														
						$j++;							
				 ?></div><hr class="h<?php echo (int)$key;?>" />	 <?php } ?>	
			
			<br class="clear">
            <br class="clear">	
           
            <div class="tresult">
                <div class="total direc_bold_final">$ <?php echo number_format($this->getAmount(),2); ?></div>
                <div class="sub_total direc_subtitulo">Subtotal Productos:</div>  
            </div>  
            <br /><br /><br />
            <a id="boton_realizar_pedido" href="<?php echo _url_web_."pedido/envio"?>?linkF=3" title="Realizar Pago"></a>          
             <a class="btn_continuar_compra" href="index.php"><img src="aplication/webroot/imgs/btn_continuar_compra.png"></a>                
             <br /><br /><br /><br /><br />
           
            <input type="hidden" value="<?php echo $j?>" name="totpro" id="totpro" />            			
			</form>
            </div>
            <div id="cesta_d"></div>
		</div> <?php
		}else{ ?>
		
		<div id="cesta">
	        <div id="cesta_u"></div>            
            <div id="cesta_c">
            <span class="title_cesta">Cesta de Compras</span><br class="clear">   
			<form name="cesta" method="post" action=""> 	
				<div class="bg_cesta">  
				  <br /><br /><br /> <h1><div align="center" class="vacio">LA CESTA ESTA VACIA  <br /> SELECCIONE UN PRODUCTO PARA COMPRAR</div></h1> <br /><br /><br />
			</div>
			<div class="clear"></div>					
			</form>
            </div>
            <div id="cesta_d"></div>
		</div>
				<?php	
			}		
		}
		
		
		
		
		function reset($reset_database = FALSE) {
	
		  $this->Content = array();
		  $this->total = 0;
		  $this->descuento = 0;
	
		  if ($this->cliente && $reset_database) {
			$sq = new Consulta("delete FROM clientes_cesta WHERE id_cliente = '" . (int)$this->cliente . "'");
			$sq_ = new Consulta("delete FROM clientes_cesta_opciones WHERE id_cliente = '" . (int)$this->cliente . "'");
		  }
		}	
		
		
		
		
		function getAmount(){
			
			$monto_cesta = 0;		
			if(is_array($this->Content)){
				reset($this->Content);					
				while(list($key,)= each($this->Content)){
					$sql="SELECT precio_producto FROM productos WHERE id_producto='".$key."' ";
					//echo $sql;
					$query=new Consulta($sql);
					$row=$query->VerRegistro();	
					$precio=$row['precio_producto'];
					$precio_anterior=0;
					
					//derifica oferta
					
					$oferta = verifica_oferta_prod_conf($key);	
					if($oferta){				
						$precio_anterior = $precio;
						$precio = $oferta;
					}
					
					//verifica opciones
					//$precio += $this->atributo_precio($key);
					
					
					/*if($row['id_impuesto']!=0){								
						$precio = calcula_impuesto($precio, $row['id_impuesto']);
					}
					*/
					
					//print_r($this->Content[$key]['cantidad']);
					//echo "asdasd".$val;
					
					/*
					for ($i=0;$i<count($this->Content[$key]['cantidad']);$i++){
						
					}*/
					
					
					// si tiene opciones calcula monto ... solo donregalo
					$opciones = $this->Content[$key]['opciones'];
					
					if( is_array($opciones) && count($opciones)>0 ){
						$mount_opcion = 0;
						foreach( $opciones as $id=>$cantidad ){
							$prod = new Producto($id);
							$mount_opcion += $prod->__get("_precio_producto") * $cantidad;
						}
						$precio += $mount_opcion;
					}
					
					
					
					$monto_cesta += ($precio * $this->Content[$key]['cantidad']);
					//echo $monto_cesta;
				}				
			}				
				$this->Amount = $monto_cesta;
				return $this->Amount;					
		}
		
		
		
		
		function count_Content(){  // ibtiene el numero total de los items en el carrito 
		  $total_items = 0;
			  if (is_array($this->Content)) {
				reset($this->Content);
				while (list($id_producto, ) = each($this->Content)) {
				  $total_items += $this->get_cantidad($id_producto);
				}
			  }
	
		  return $total_items;
		}

    function get_cantidad($id_producto) {
		  if (isset($this->Content[$id_producto])) {
			return $this->Content[$id_producto]['cantidad'];
		  } else {
			return 0;
		  }
    }
		
		
		
    function SetCustomer($idCustomer){
            $this->cliente = $idCustomer;
    }
		
    public function atributo_precio($id_producto) {
		  $atributo_precio = 0;
	
			if (isset($this->Content[$id_producto]['opciones'])){
				reset($this->Content[$id_producto]['opciones']);
				while (list($option, $value) = each($this->Content[$id_producto]['opciones'])) {
			
			  		$atributos = new Consulta("SELECT precio_producto_atributo_valor, prefijo_producto_atributo_valor 
			  								FROM productos_atributos_valores 
											WHERE id_producto_atributo = '" . (int)$option . "' AND												
												id_producto_atributo_valor = '" . (int)$value . "'");
												
			  		$attribute_price = $atributos->VerRegistro();
			  		if ($attribute_price['prefijo_producto_atributo_valor'] == '+') {			  	
						$atributo_precio += $attribute_price['precio_producto_atributo_valor'];
			  		} else {
						$atributo_precio -= $attribute_price['precio_producto_atributo_valor'];
			  		}
				}
			}

      		return 0;
    	}
		
		
		function GetCustomer(){
			return $this->cliente;
		}				
		
		function GetPeso(){
				
			$peso_cesta=0;		
			if(is_array($this->Content)){
				reset($this->Content);
					
				while(list($key,)= each($this->Content)){
					$sql="SELECT peso_producto FROM productos WHERE id_producto='".$key."' ";
					$query=new Consulta($sql);
					$row=$query->VerRegistro();	
					$peso=$row['peso_producto'];					
					$peso_cesta += ($peso * $this->Content[$key]['cantidad']);
				}				
			}				
			$this->weight = $peso_cesta;
			return $this->weight;					
		}
		
		function GetPrecioPeso(){
				
			$peso_cesta=0;		
			if(is_array($this->Content)){
				reset($this->Content);
					
				while(list($key,)= each($this->Content)){
					$sql="SELECT precio_peso_producto FROM productos WHERE id_producto='".$key."' ";
					$query=new Consulta($sql);
					$row=$query->VerRegistro();	
					$preso=$row['precio_peso_producto'];					
					$peso_cesta += ($preso * $this->Content[$key]['cantidad']);
				}				
			}				
			$this->weight = $peso_cesta;
			return $this->weight;					
		}
  	}
?>