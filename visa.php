<?php
include("inc.aplication_top.php");
if( isset($_GET['step']) && !empty($_GET['step'])){	
	require_once(_util_.'lib.inc.php');
	ini_set("display_errors", 1);
	ini_set('date.timezone', 'America/Lima'); 
	$tipo_cambio = TIPO_CAMBIO;	
	
	switch( $_GET['step'] ){
		case 'pago':
			
			if($cuenta->getCliente()->getLogeado()==FALSE){header("location: index.php?seccion=cuenta&linkF=2");}
			if (!isset($_POST['amount']) && !empty($_POST['amount'])){header("location: "._url_web_."seccion/cesta");}
			
			if($cuenta->getCliente()->getLogeado()==TRUE){
									
					$total = number_format( $pedido->getCarrito()->getAmount(),2);
					$shipping = number_format($pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio')/$tipo_cambio,2);
					$id = $pedido->getId();					
					$visa = new Visa($total,$shipping,$id);
					$visa->estado('CALIDAD');
					$visa->renderXML();
			}
			
		break;
		case 'respuesta':
			
			$total = number_format( $pedido->getCarrito()->getAmount(),2);
			$shipping = number_format($pedido->getDestinatario()->__get('_distrito')->__get('_tarifa_envio')/$tipo_cambio,2);
			$id = $pedido->getId();			
			$visa = new Visa($total,$shipping,$id);
			$visa->estado('CALIDAD');	
			
			if (isset($_POST["eticket"])) {
		
				$eTicket= $_POST["eticket"];
				$codTienda = CODIGO_TIENDA;
		
				$xmlIn = "";
				
				$xmlIn = $xmlIn . "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
				$xmlIn = $xmlIn . "<consulta_eticket>";
				$xmlIn = $xmlIn . "	<parametros>";
				$xmlIn = $xmlIn . "		<parametro id=\"CODTIENDA\">";
				$xmlIn = $xmlIn . $codTienda;//Aqui se asigna el Cò£¨§o de tienda
				$xmlIn = $xmlIn . "</parametro>";
				$xmlIn = $xmlIn . "		<parametro id=\"ETICKET\">";
				$xmlIn = $xmlIn . $eTicket;//Aqui se asigna el eTicket
				$xmlIn = $xmlIn . "</parametro>";
				$xmlIn = $xmlIn . "	</parametros>";
				$xmlIn = $xmlIn . "</consulta_eticket>";	
				
				
				$servicio= URL_WSCONSULTAETICKET_VISA; 
				$client = new SoapClient($servicio);			
				$parametros=array();
				$parametros['xmlIn']= $xmlIn;			
				$result = $client->ConsultaEticket($parametros);			
				$xmlDocument = new DOMDocument();
				if ($xmlDocument->loadXML($result->ConsultaEticketResult)) {							
							
					$pedido = $_SESSION['sisdw_pedido'];						
					
					$pedido->setEstadoPedido(RecuperaCampos($xmlDocument, 1, "respuesta"));			
					$pedido->setEstadoCompra(RecuperaCampos($xmlDocument, 1, "estado"));
					$pedido->setCodigoAccion(RecuperaCampos($xmlDocument, 1, "cod_accion"));
					$pedido->setFecha(RecuperaCampos($xmlDocument, 1, "fechayhora_tx"));
					$pedido->setComprador(RecuperaCampos($xmlDocument, 1, "nombre_th"));
					$pedido->setCodigoTienda(RecuperaCampos($xmlDocument, 1, "cod_tienda"));
					$pedido->setNumeroTarjeta(RecuperaCampos($xmlDocument, 1, "pan"));
					
					?>
					<script>
					location.replace("pago_finalizado.php");
					</script>
					<?php
				}else{
					echo "Error";
				}
			}else{
				echo 'Pagina de respuesta de VISA , No se envio ningun S_POST';
				exit();
			}
			
			
			
		break;
	}	
}


?>