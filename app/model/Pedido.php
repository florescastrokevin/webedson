<?php
require_once(_model_."Main.php");
require_once(_model_."MetodoPago.php");
require_once(_model_.'PedidoDestinatario.php');
require_once(_model_.'ComprobantePago.php');
require_once(_model_.'Cliente.php');
require_once(_model_.'Carrito.php');

class Pedido{
	
	private $_id;
    private $_metodo_pago;      
	private $_estado;        
	private $_fecha;
	private $_carrito;        
	private $_destinatario;
	private $_comprobante_pago;
	private $_chofer;
	/* para VISA */
	private $_estado_pedido;
	private $_estado_compra;
	private $_codigo_accion;
	private $_fecha_compra;
	private $_set_comprador;
	private $_codigo_tienda;
	private $_numero_tarjeta; 
	
	public function __construct($id = 0){			
           
            $this->_id = $id;
            if($this->_id > 0){ // si existe, leer de la base de datos
                $sql = "SELECT * FROM pedidos WHERE id_pedido = '".$this->_id."'"; 
	
                $query = new Consulta($sql);
                if($query->NumeroRegistros() > 0 ){
                    $row = $query->VerRegistro();
                    $this->_cliente  	 = new Cliente($row["id_cliente"]);                    
                    $this->_metodo_pago  = new MetodoPago($row["id_metodo_pago"]);
                    $this->_destinatario = new PedidoDestinatario($this->_id); 
                    $this->_comprobante_pago = new ComprobantePago($this->_id);                
                    $this->_carrito      = new Carrito($this->_id);
                    $this->_estado    	 = $row["estado_pedido"];
                    $this->_fecha  	 = $row["fecha_pedido"];				
                    $this->_codigo     	 = $row["codigo_pedido"];				
                }
            }else{ // por sesion, asignar datos y registrar pedido              
                $sqlPedido = "INSERT INTO pedidos 
                                VALUES('',
                               '',
                               '0',
                               'Registrado',
                               '',
                               '".date('Y-m-d H:i:s')."',							  
                               '')";
                $query = new Consulta($sqlPedido);
                $this->_id = $query->nuevoId();
                $this->_estado	= "Registrado";
                $this->_fecha	= date('Y-m-d H:i:s');
                $this->_destinatario = new PedidoDestinatario();
                //$this->_cliente = new Cliente($row["id_cliente"]);
                //$this->_carrito = new Carrito($row["id_cliente"]);
            } 			
	}
        
	
        public function setCliente($cliente){ 
            $sql = "UPDATE pedidos SET id_cliente = '".$cliente->__get('_id')."' WHERE id_pedido = '".$this->_id."' ";
            $query = new Consulta($sql);
            $this->_cliente = $cliente; 
           
        }
        
        public function setCodigo(){ 
            $sql = "UPDATE pedidos SET codigo_pedido = '".$this->_id."' WHERE id_pedido = '".$this->_id."' ";
            $query = new Consulta($sql);
            $this->_cliente = $cliente; 
           
        }
     
	public function setCarrito($carrito){ 
            
            $this->_carrito = $carrito;
            
			// -- ACTUALIZA PEDIDOS CANTIDADES Y STOCK -- //
			
			$sql_clear = new Consulta("DELETE FROM pedidos_productos WHERE id_pedido = '".$this->_id."'");
            $j = 0;
            $productos = $this->_carrito->getContent();
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
                                                        '".$this->_id."',
                                                        '".$key."',
                                                        '".$productos[$key]['cantidad']."',
                                                        '".$precio."')"; 
                    $query_productos_pedidos = new Consulta($sql_productos_pedidos);								
                    $id_pedido_producto = $query_productos_pedidos->nuevoId();
					
					
					//pre($productos);
					
					//VERIFICAMOS SI HAY OPCIONES			
					if(is_array($productos[$key]['opciones'])){
						reset($productos[$key]['opciones']);				
						while(list($idcmp, $cantcmp) = each($productos[$key]['opciones'])){
						//echo 'VALOR : '.$cantcmp.'<br/>';
						//echo 'complemento : '.$idcmp.'<br/>';
						
						//  --  TOMANDO COMPLEMENTO COMO PRODUCTO -- //
						$pcmp = new Producto($idcmp);
						
										
						
							$sql_ppo = "INSERT INTO pedidos_productos_opciones 
							VALUES('','".$id_pedido_producto."','".$idcmp."','".$cantcmp."','".$pcmp->__get('_precio_producto')."','+')";
							$query_ppo = new Consulta($sql_ppo);					
						}										
					}
					

                }
            }         
        }
       
	public function setEstado($estado){
            $this->_estado = $estado;
            $sql = "UPDATE pedidos SET estado_pedido = '".$estado."' WHERE id_pedido = '".$this->_id."' ";
            $query = new Consulta($sql);
	}
   
       
	public function setMetodoPago($id_metodo_pago){ 
			$_SESSION['pago']['id'] = $id_metodo_pago;
            $this->_metodo_pago = new MetodoPago($id_metodo_pago); 
            $sql = "UPDATE pedidos SET id_metodo_pago = '".$id_metodo_pago."' WHERE id_pedido = '".$this->_id."' ";
            $query = new Consulta($sql);
        }
        
        public function setDestinatario(){ 
           
           // if( $this->_estado == "Registrado" ){
                $distrito = new Distrito($_POST['distrito']);    
               
                $_SESSION['envio']['nombre'] = $_POST['nombre'];
                $_SESSION['envio']['apellidos'] = $_POST['apellidos'];
                $_SESSION['envio']['telefono'] = $_POST['telefono'];
                $_SESSION['envio']['fecha'] = $_POST['fecha'];
                $_SESSION['envio']['hora'] = $_POST['hora'];
                $fecha = $_POST['fecha']; 
                $hora = $_POST['hora']; 
                if( $_POST['fecha'] != "" && $hora = $_POST['hora']){
                        //$_SESSION['envio']['fecha_hora'] = set_horafecha_html_a_sql ($fecha_hora,$hora); // show session
                        $_SESSION['envio']['fecha_hora'] = $_POST['fecha'].' '.$_POST['hora'];
                        //$fecha_hora = set_horafecha_html_a_sql($fecha,$hora); // save in bdd
                        $fecha_hora = $_POST['fecha'].' '.$_POST['hora'];
                }else{
                        $fecha_hora = '';
                }



                $_SESSION['envio']['direccion'] = $_POST['direccion'];
                $_SESSION['envio']['distrito'] = $_POST['distrito'];
                $_SESSION['envio']['referencia'] = $_POST['referencia'];
                $_SESSION['envio']['dedicatoria'] = $_POST['dedicatoria'];				

		        $this->_destinatario->__set('_nombre',$_POST['nombre']);
                $this->_destinatario->__set('_apellidos',$_POST['apellidos']);
                $this->_destinatario->__set('_telefono',$_POST['telefono']);
                $this->_destinatario->__set('_fecha_hora',$fecha_hora);
                //$this->_destinatario->__set('_direccion',$_POST['telefono']);
		        $this->_destinatario->__set('_direccion',$_POST['direccion']);
                $this->_destinatario->__set('_distrito',$distrito);			
                $this->_destinatario->__set('_referencia',$_POST['referencia']);
                $this->_destinatario->__set('_dedicatoria',$_POST['dedicatoria']);	
                //$this->_estinatario = $destinatario; 
		// $fecha_hora = $_POST['fecha_hora'];
                /*
               $sql = "INSERT INTO pedidos_destinatarios VALUES ('','".$this->_id."','".$_POST['distrito']."','0','".$_POST['nombre']."','".$_POST['apellidos']."','".$_POST['telefono']."','".addslashes($_POST['direccion'])."','".addslashes($_POST['referencia'])."','".addslashes($_POST['dedicatoria'])."','','".$fecha_hora."','','')";
               */

               $sql_destinatario = "INSERT INTO destinatarios VALUES ('','".$this->_cliente->__get('_id')."','".$_POST['nombre']."','".$_POST['apellidos']."','".$_POST['telefono']."','".addslashes($_POST['direccion'])."','".addslashes($_POST['referencia'])."')";
               $query_destinatario = new Consulta($sql_destinatario);

               $id_destinatario = $query_destinatario->nuevoId();
               
               $sql = "INSERT INTO pedidos_destinatarios VALUES ('','".$this->_id."','".$id_destinatario."','".$_POST['distrito']."','".$_POST['nombre']."','".$_POST['apellidos']."','".$_POST['telefono']."','".addslashes($_POST['direccion'])."','".addslashes($_POST['referencia'])."','".addslashes($_POST['dedicatoria'])."','','".$_POST['lat_pos']."','".$_POST['lng_pos']."','".$fecha_hora."')";
               $query = new Consulta($sql);

               $_SESSION['destinatario']['id'] = $id_destinatario;
          
        }
        
        
	public function setComprobantePago(){ 
            
            $comprobante = new ComprobantePago();
            $comprobante->__set('_tipo',$_POST['comprobante']);
            $this->_comprobante_pago = $comprobante;
            
            if($_POST['comprobante'] == "Boleta"){
                    
					$_SESSION['pago']['tipo'] = 'Boleta';
					$_SESSION['pago']['nombre_boleta'] = $_POST['nombre'];
					$_SESSION['pago']['direccion_boleta'] = $_POST['direccionb'];
					$_SESSION['pago']['dni_boleta'] = $_POST['dni'];
					
					$comprobante->__set('_nombre',$_POST['nombre']);
                    $comprobante->__set('_direccionb',$_POST['direccionb']);
					$comprobante->__set('_dni',$_POST['dni']);
            }

            if($_POST['comprobante'] == "Factura"){
				
					$_SESSION['pago']['tipo'] = 'Factura';
					
					$_SESSION['pago']['nombre_factura'] = $_POST['nombre'];
					$_SESSION['pago']['razon_social'] = $_POST['razonsocial'];
					$_SESSION['pago']['ruc'] = $_POST['ruc'];
					$_SESSION['pago']['direccionf'] = $_POST['direccionf'];
					
					
                    $comprobante->__set('_nombre',$_POST['nombre']);
                    $comprobante->__set('_razon_social',$_POST['razonsocial']);
                    $comprobante->__set('_ruc',$_POST['ruc']);
                    $comprobante->__set('_direccionf',$_POST['direccionf']);
                    //$comprobante->__set('_direccion_entrega',$_POST['direccion_entrega_doc']);			
            }	
		
            if ( $this->getComprobantePago()->__get("_tipo") == "Factura" ){
                $direccion_pago = $this->getComprobantePago()->__get("_direccionf");
            }else{
                $direccion_pago = $this->getComprobantePago()->__get("_direccionb");
            }
            $sql_clear = new Consulta("DELETE FROM pedidos_pagos WHERE id_pedido = '".$this->_id."'");
            $sql_comprobante = "INSERT INTO pedidos_pagos VALUES('',
                                '".$this->_id."',
                                '".$this->getComprobantePago()->__get("_nombre")."',
                                '".$direccion_pago."',
                                '".$this->getComprobantePago()->__get("_razon_social")."',
								'".$this->getComprobantePago()->__get("_ruc")."',
								'".$this->getComprobantePago()->__get("_dni")."','',											
                                '".$this->getComprobantePago()->__get("_tipo")."')";
            $queryPedido = new Consulta($sql_comprobante);
            $this->_comprobante_pago = $comprobante; 
           
        }
	public function setComentario($var){ $this->comentario = $var; }
        
	public function getId(){ return $this->_id; }
	public function getMetodoPago(){ return $this->_metodo_pago; }
	public function getComentario(){ return $this->comentario; }
	public function getDestinatario(){ return $this->_destinatario; }
	public function getCarrito(){ return $this->_carrito; }
	public function getEstado(){ return $this->_estado; }
	public function getComprobantePago(){ return $this->_comprobante_pago;}
	public function getCliente(){  return $this->_cliente; }
	
	
	/* para visa */
	public function setEstadoPedido( $param ){$this->_estado_pedido = $param;}
	public function setEstadoCompra( $param ){$this->_estado_compra = $param;}
	public function setCodigoAccion( $param ){$this->_codigo_accion = $param;}
	public function setFecha( $param ){$this->_fecha = $param;}
	public function setComprador( $param ){$this->_set_comprador = $param;}
	public function setCodigoTienda( $param ){$this->_codigo_tienda = $param;}
	public function setNumeroTarjeta( $param ){ $this->_numero_tarjeta = $param; }
	
	
	public function getFecha(){ return $this->_fecha;}
	public function getEstadoPedido(){ return $this->_estado_pedido;}
	public function getEstadoCompra(){ return $this->_estado_compra;}
	public function getCodigoAccion(){ return $this->_codigo_accion;}
	public function getFechaCompra(){ return $this->_fecha_compra;}
	public function getComprador(){ return $this->_set_comprador;}
	public function getCodigoTienda(){ return $this->_codigo_tienda; }
	public function getNumeroTarjeta(){ return $this->_numero_tarjeta; }
	
        
        public function clearSelf(){
            
            $this->_id = 0;
            $this->_carrito = 0;
            $this->_codigo = 0;
            $this->_fecha = 0;
            $this->_metodo_pago = 0;
            $this->_comprobante_pago = 0;
            $this->_destinatario = 0;
            $this->_estado = "";
            
        }
    

    /*
    Este metodo generar el PDF de la guía de entrega y se usa en en Pedidos->addAdminPedidos, Pedidos->updatePedidos(), Secciones->confirmacion()
    */    
    public function generarGuiaEntrega(){
        ob_start();
        include(_panel_admin_.'guia_entrega_html.php');
        $content = ob_get_clean();
        $nombre_archivo = _files_guias_entrega_."guia-entrega-".$this->_id.".pdf";
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
"._url_web_."
DON REGALO SRL

Lleva felicidad en cada regalo...

";		
		
		//echo 'MENSASE : '.$message;
		
		//if(!@mail('jjhoncv@hotmail.com', "Pedido - ".NOMBRE_SITIO, $message, "from: ".EMAIL_PEDIDOS."")){ echo "Error al enviar el email" ; }	
		
		
        if(!@mail($pedido->getCliente()->__get("_email"), "Pedido ".$pedido->getId()." - ".NOMBRE_SITIO, $message, "from: ".EMAIL_PEDIDOS."")){ echo "Error al enviar el email" ; }		

        if(!@mail(EMAIL_PEDIDOS, "Pedido ".$pedido->getId()." - ".NOMBRE_SITIO, $message, "from: Administrador ".NOMBRE_SITIO)){
             echo "Error al enviar el email" ;
       }
    }
}