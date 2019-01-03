<?php

class Paypal{
	
	var $form;
	var $urlProcess;
    var $notify_url;
	var $cmd; 
	var $business;
	var $item_name;
	var $amount;
	var $shipping;
	var $currency_code;
	var $retorno;
	var $cancel_return;
	var $logo;
	
	function Paypal($amount, $shipping, $detail, $tipo=""){
		$url = _url_web_;
        $this->urlProcess="https://www.sandbox.paypal.com/cgi-bin/webscr";
        $this->notify_url = _url_web_.'paypal_ipn.php';
		//$url = _url_web_;
		//$this->urlProcess="https://secure.paypal.com/cgi-bin/webscr";
		$this->cmd		="_xclick";
		//$this->business	= "vanetino@gmail.com";
        $this->business = "pedidos@dkasaimport.com";
		$this->item_name= utf8_decode($detail);//detalle de la compra
		$this->amount 	= $amount;
		$this->shipping = $shipping;
		$this->currency_code = "USD";
		$this->retorno	= $url."pago_finalizado.php";
		$this->cancel_return = $url;
		$this->logo = _tpl_imgs_."logo.png";
	}
	
	function generaFormulario($id_pedido, $img="",$id_form=""){
		
		$boton = '<div class="row"><div class="col-6 text-right"> <button type="button" onclick="" id="btn_volver" class="btn btn-outline-secondary remove-tablet"><i class="icon-arrow-left"></i><span class="">&nbsp;Regresar</span></button></div><div class="col-md-6 text-continuar"><button type="submit" value="" name="btncomprar" id="btn_confirmar" class="btn_confirmar_pedido btn btn-verde-donregalo" title="Pagar en Paypal"><i class="socicon-paypal"></i><span class="">&nbsp;Pagar en Paypal&nbsp;</span><i class="icon-arrow-right"></i></button></div></div>';
				
		$this->form='
		<form name="checkout_confirmation" id="'.$id_form.'" action="'.$this->urlProcess.'" method="post">
		<input type="hidden" name="rm"  value="2" />                   
		<input type="hidden" name="custom" value="'.$id_pedido.'">
        <input type="hidden" name="cmd" value="_cart" />
        <input type="hidden" name="upload" value="1">  
		<input type="hidden" name="country" value="PE">  
		<input type="hidden" name="lc" value="PE">  
		'.$this->item_name.'
		<input type="hidden" name="business" value="'.$this->business.'">
		<input type="hidden" name="shipping_1" value="'.number_format($this->shipping,2).'">		
		<input type="hidden" name="currency_code" value="'.$this->currency_code.'">
		<input type="hidden" name="image_url" value="'.$this->logo.'">
        <input type="hidden" name="notify_url" value="'.$this->notify_url.'" />
		<input type="hidden" name="return" value="'.$this->retorno.'">
        <input type="hidden" name="cancel_return" value="'.$this->cancel_return.'">
		<input type="hidden" name="cbt" value="Presione aqui para guardar su pedido y regresar a Don Regalo">                 
        <input type="hidden" name="bn" value="DonRegalo">
		'.$boton.'
	</form>';		
		
		return $this->form;
	}
        
    static public function preparaDetalle($carrito){
            //$carrito = $this->_cuenta->getCliente()->getCarrito();
            $content = $carrito->getContent();
            $i = 1;
            $return = '';
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
                $return.= '
                    <input type="hidden" name="item_number_'.$i.'" value="'.$i.'">
                    <input type="hidden" name="item_name_'.$i.'" value="'.utf8_encode($producto->__get("_nombre")).'">
                    '.$opc_paypal.'<input type="hidden" name="quantity_'.$i.'" value="'.$content[$key]['cantidad'].'">
                    <input type="hidden" name="amount_'.$i.'" value="'.round($precio + $preciocmp,2) .'">';
                $i++;
            }
        return $return;    
    }
        
    static public function notificacion(){

        $payaltest = false; //cambialo a false para realizar transacciones reales, de lo contrario utiliza sandbox.
        $req = 'cmd=_notify-validate';
        $fullipnA = array();

        foreach ($_POST as $key => $value){
            $fullipnA[$key] = $value;
            $encodedvalue = urlencode(stripslashes($value));
            $req .= "&$key=$encodedvalue";
        }

        $fullipn = Array2Str(" : ", "\n", $fullipnA);

        if (!$payaltest){
            $url ='https://www.paypal.com/cgi-bin/webscr';	
        }else{	
            $url ='https://www.sandbox.paypal.com/cgi-bin/webscr'; 	
        }

        $curl_result=$curl_err='';
        $fp = curl_init();
        curl_setopt($fp, CURLOPT_URL,$url);
        curl_setopt($fp, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($fp, CURLOPT_POST, 1);
        curl_setopt($fp, CURLOPT_POSTFIELDS, $req);
        curl_setopt($fp, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
        curl_setopt($fp, CURLOPT_HEADER , 0); 
        curl_setopt($fp, CURLOPT_VERBOSE, 1);
        curl_setopt($fp, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($fp, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($fp);
        $curl_err = curl_error($fp);
        curl_close($fp);

        // Variables enviadas por Paypal
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $payment_status = $_POST['payment_status'];
        $payment_amount = $_POST['mc_gross'];
        $payment_currency = $_POST['mc_currency'];
        $txn_id = $_POST['txn_id'];
        $receiver_email = $_POST['receiver_email'];
        $payer_email = $_POST['payer_email'];
        $txn_type = $_POST['txn_type'];
        $pending_reason = $_POST['pending_reason'];
        $payment_type = $_POST['payment_type'];
        $custom_key = $_POST['custom'];

        if (strcmp ($response, "VERIFIED") == 0){
            // Verifico el estado de la orden
            if ($payment_status != "Completed"){
                TransLog("El pago no fue aceptado por paypal - Estado del Pago: $payment_status");
                StopProcess();
            }
            if($_POST['custom'] && !empty($_POST['custom']) && $_POST['custom'] > 0){
                $pedido = new Pedido($_POST['custom']);
                if($_POST['payment_status'] == 'Completed'){
                    $pedido->setEstado("Pagado-IPN");
                    Pedido::notificarPedido($pedido);
                    //Secciones::notificarPedido($pedido);
                }
            }
            //todo bien hasta ahora, la transacción ha sido confirmada por lo tanto puedo realizar mis tareas, 
            //actualizar DB, stock, acreditar cómputos, activar cuentas etc etc
            TransLog("Pago Correcto - $fullipn"); //notifico al webmaster

        }else{ //la transacción es invalida NO se puedo cobrarle al cliente.
            TransLog("Pago Inválido - $fullipn");
        }
    }   
}