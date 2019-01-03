<?php
class Visa{	
	
	private $_amount;	
	private $_shipping;
	private $_id;
	private $_fecha;
	private $_form;
	private $_codigo_tienda;
	private $_terminos_condiciones;
	
	public function __construct($amount=0, $shipping=0 , $id_pedido=0){
		$this->_id = $id_pedido;
		$this->_amount = $amount;
		$this->_shipping = $shipping;
		$query = new Consulta("SELECT * FROM metodo_pago WHERE alias_metodo_pago = 'Visa'");
		$row = $query->VerRegistro();
		$this->_codigo_tienda = CODIGO_TIENDA;
		$this->_terminos_condiciones = $row['terminos_condiciones']; 
		//$this->estado('PRODUCCIÓN');
	}
	
	
	public function estado( $estado = 'PRODUCCIÓN'  ){
		switch( $estado ){
			case 'PRODUCCIÓN':
				define('URL_FORMULARIO_VISA','https://www.multimerchantvisanet.com/formularioweb/formulariopago.asp');
				define('URL_WSGENERAETICKET_VISA','https://www.multimerchantvisanet.com/WSGenerarEticket/WSEticket.asmx?wsdl');
				define('URL_WSCONSULTAETICKET_VISA','https://www.multimerchantvisanet.com/WSConsulta/WSConsultaEticket.asmx?wsdl');
			break;
			
			case 'DESARROLLO':
				define('URL_FORMULARIO_VISA','http://qas.multimerchantvisanet.com/formularioweb/formulariopago.asp');
				define('URL_WSGENERAETICKET_VISA','http://qas.multimerchantvisanet.com/wsgenerareticket/wseticket.asmx?wsdl');
				define('URL_WSCONSULTAETICKET_VISA','http://qas.multimerchantvisanet.com/wsconsulta/wsconsultaeticket.asmx?wsdl');
			break;
			
			case 'CALIDAD':
				define('URL_FORMULARIO_VISA','http://qas.multimerchantvisanet.com/formularioweb/formulariopago.asp');
				define('URL_WSGENERAETICKET_VISA','http://qas.multimerchantvisanet.com/wsgenerareticket/wseticket.asmx?wsdl');
				define('URL_WSCONSULTAETICKET_VISA','http://qas.multimerchantvisanet.com/wsconsulta/wsconsultaeticket.asmx?wsdl');
			break;
		}	
		
		//define('CODIGO_TIENDA',$this->_codigo_tienda);
		
	}
	
		
	public function renderXML(){
		$xmlIn  = "";
		$xmlIn .= "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
		$xmlIn .= "<nuevo_eticket>";
		$xmlIn .= "	<parametros>";
		$xmlIn .= "		<parametro id=\"CANAL\">3</parametro>";
		$xmlIn .= "		<parametro id=\"PRODUCTO\">1</parametro>";
		$xmlIn .= "		";
		$xmlIn .= "		<parametro id=\"CODTIENDA\">" . CODIGO_TIENDA . "</parametro>";
		$xmlIn .= "		<parametro id=\"NUMORDEN\">" . $this->_id . "</parametro>";
		$xmlIn .= "		<parametro id=\"MOUNT\">" . number_format( ($this->_amount + $this->_shipping),2) . "</parametro>";
		$xmlIn .= "		<parametro id=\"DATO_COMERCIO\">JOSE</parametro>";
		$xmlIn .= "	</parametros>";
		$xmlIn .= "</nuevo_eticket>";
				    
			//echo $xmlIn;
			//Se asigna la url del servicio
			//En producción cambiará la URL
			$servicio= URL_WSGENERAETICKET_VISA;
			
			//Invocación al web service
			$client = new SoapClient($servicio);
			//print_r($client->GeneraEticket);
			//exit;
			//parametros de la llamada
			$parametros=array(); 
			$parametros['xmlIn']= $xmlIn;
			//Aqui captura la cadena de resultado
			$result = $client->GeneraEticket($parametros);
			//Muestra la cadena recibida
			//echo 'Cadena de respuesta: ' . $result->GeneraEticketResult . '<br>' . '<br>';
			
			//Aqui carga la cadena resultado en un XMLDocument (DOMDocument)
			$xmlDocument = new DOMDocument();
			
			if ($xmlDocument->loadXML($result->GeneraEticketResult)){
				/////////////////////////[MENSAJES]////////////////////////
				//Ejemplo para determinar la cantidad de mensajes en el XML
				$iCantMensajes= CantidadMensajes($xmlDocument);
				//echo 'Cantidad de Mensajes: ' . $iCantMensajes . '<br>';
				
				//Ejemplo para mostrar los mensajes del XML 
				for($iNumMensaje=0;$iNumMensaje < $iCantMensajes; $iNumMensaje++){
					echo 'Mensaje #' . ($iNumMensaje +1) . ': ';
					echo RecuperaMensaje($xmlDocument, $iNumMensaje+1);
					echo '<BR>';
				}
				/////////////////////////[MENSAJES]////////////////////////
				
				if ($iCantMensajes == 0){
					$Eticket= RecuperaEticket($xmlDocument);
					//echo 'Eticket: ' . $Eticket;
					
					$html= htmlRedirecFormEticket($Eticket);
					echo $html;
					
					exit;
				}
						
			}else{
				echo "Error cargando XML";
			}	
		
		
	}
	
	public function getTerminosYCondiciones(){
		return $this->_terminos_condiciones;
	}
	
	public function generaFormulario($id_pedido){			
		
		$this->_form='		
		<script>
		function validate_visa(form){
			if ( $("#term").is(":checked") ){
				document.visa_confirmation.submit();
			}else{
				alert("Debe de aceptar los terminos y condiciones para poder comprar en '.NOMBRE_SITIO.'");
				$("#term").focus();
				return false;
			}
		}
		</script>		
		<form name="visa_confirmation" id="visa_confirmation" action="'._url_web_."visa.php?step=pago".'" onsubmit="return validate_visa(this)" method="post">
			<input type="hidden" name="pedido" value="'.$id_pedido.'">
			<input type="hidden" name="amount" value="'.$this->_amount.'">
			<input type="hidden" name="shipping" value="'.$this->_shipping.'">	
			<input type="submit" id="btn_confirmar" value="">
		</form>';
		return $this->_form;	
	//$pedido->procesaPedido();					
	//header("Location: compra_realizada.php");
	}	
	
	public function __get($atributo){
		return $this->$atributo;
	}
	
	
}

?>