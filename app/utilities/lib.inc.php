<?php
//define('CODIGO_TIENDA','422239909');

//// DESARROLLO
//define('URL_FORMULARIO_VISA','http://qas.multimerchantvisanet.com/formularioweb/formulariopago.asp');
//define('URL_WSGENERAETICKET_VISA','http://qas.multimerchantvisanet.com/wsgenerareticket/wseticket.asmx?wsdl');
//define('URL_WSCONSULTAETICKET_VISA','http://qas.multimerchantvisanet.com/wsconsulta/wsconsultaeticket.asmx?wsdl');
//// CALIDAD
//define('URL_FORMULARIO_VISA','http://qas.posmultimerchantvisa.com/formularioweb/formulariopago.asp');
//define('URL_WSGENERAETICKET_VISA','http://qas.posmultimerchantvisa.com/WSGenerarEticket/WSEticket.asmx?wsdl');
//define('URL_WSCONSULTAETICKET_VISA','http://qas.posmultimerchantvisa.com/WSConsulta/WSConsultaEticket.asmx?wsdl');
//// PRODUCCI�N
/*define('URL_FORMULARIO_VISA','https://www.multimerchantvisanet.com/formularioweb/formulariopago.asp');
define('URL_WSGENERAETICKET_VISA','https://www.multimerchantvisanet.com/WSGenerarEticket/WSEticket.asmx?wsdl');
define('URL_WSCONSULTAETICKET_VISA','https://www.multimerchantvisanet.com/WSConsulta/WSConsultaEticket.asmx?wsdl');
  */  

function noCache() {
  header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
}

function htmlRedirecFormAnt($CODTIENDA, $NUMORDEN, $MOUNT){
	$html='<Html>
	<head>
	<title>Pagina prueba Visa</title>
	</head>
	<Body onload="fm.submit();">

	<form name="fm" method="post" action="'.URL_FORMULARIO_VISA.'">
	    <input type="hidden" name="CODTIENDA" value="#CODTIENDA#" /><BR>
	    <input type="hidden" name="NUMORDEN" value="#NUMORDEN#" /><BR>
	    <input type="hidden" name="MOUNT" value="#MOUNT#" /><BR>
	</form>
	</Body>
	</Html>';

	$html=ereg_replace("#CODTIENDA#",$CODTIENDA,$html);
	$html=ereg_replace("#NUMORDEN#",$NUMORDEN,$html);
	$html=ereg_replace("#MOUNT#",$MOUNT,$html);

	return $html;
}

function htmlRedirecFormEticket($ETICKET){
	$html='<Html>
	<head>
	<title>Pagina prueba Visa</title>
	</head>
	<Body onload="fm.submit();">

	<form name="fm" method="post" action="'.URL_FORMULARIO_VISA.'">
	    <input type="hidden" name="ETICKET" value="#ETICKET#" /><BR>
	</form>
	</Body>
	</Html>';

	$html= str_replace("#ETICKET#", $ETICKET, $html);

	return $html;
}

	
	//Funcion que recupera el valor de uno de los mensajes XML de respuesta
	function RecuperaMensaje($xmlDoc,$iNumMensaje){
		$strReturn = "";
			
			$xpath = new DOMXPath($xmlDoc);
			$nodeList = $xpath->query("//mensajes/mensaje[@id='" . $iNumMensaje . "']");
			
			$XmlNode= $nodeList->item(0);
			
			if($XmlNode==null){
				$strReturn = "";
			}else{
				$strReturn = $XmlNode->nodeValue;
			}
			return $strReturn;
	}
	
	//Funcion de ejemplo que obtiene la cantidad de operaciones
	function CantidadOperaciones($xmlDoc, $eTicket){
		$cantidaOpe= 0;
		$xpath = new DOMXPath($xmlDoc);
		$nodeList = $xpath->query('//pedido[@eticket="' . $eTicket . '"]', $xmlDoc);
		
		$XmlNode= $nodeList->item(0);
		
		if($XmlNode==null){
			$cantidaOpe= 0;
		}else{
			$cantidaOpe= $XmlNode->childNodes->length;
		}
		return $cantidaOpe; 
	}
	
	//Funcion que recupera el valor de uno de los campos del XML de respuesta
	function RecuperaCampos($xmlDoc,$sNumOperacion,$nomCampo){
			$strReturn = "";
			
			$xpath = new DOMXPath($xmlDoc);
			$nodeList = $xpath->query("//operacion[@id='" . $sNumOperacion . "']/campo[@id='" . $nomCampo . "']");
			
			$XmlNode= $nodeList->item(0);
			
			if($XmlNode==null){
				$strReturn = "";
			}else{
				$strReturn = $XmlNode->nodeValue;
			}
			return $strReturn;
	}
	//Funcion que muestra en pantalla los parଥtros de cada operacion
	//asociada al N� de pedido consultado
	function PresentaResultado($xmlDoc, $iNumOperacion){
			//ESTA FUNCION ES SOLAMENTE UN EJEMPLO DE COMO ANALIZAR LA RESPUESTA
			$sNumOperacion = "";
	
			$sNumOperacion = $iNumOperacion;
	
			$strValor = "";
			$strValor = $strValor . "<LI> Respuesta: " . RecuperaCampos($xmlDoc, $sNumOperacion, "respuesta") . "<BR>";
			$strValor = $strValor . "<LI> estado: " . RecuperaCampos($xmlDoc, $sNumOperacion, "estado") . "<BR>";
			$strValor = $strValor . "<LI> cod_tienda: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_tienda") . "<BR>";
			$strValor = $strValor . "<LI> nordent: " . RecuperaCampos($xmlDoc, $sNumOperacion, "nordent") . "<BR>";
			$strValor = $strValor . "<LI> cod_accion: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_accion") . "<BR>";
			$strValor = $strValor . "<LI> pan: " . RecuperaCampos($xmlDoc, $sNumOperacion, "pan") . "<BR>";
			$strValor = $strValor . "<LI> nombre_th: " . RecuperaCampos($xmlDoc, $sNumOperacion, "nombre_th") . "<BR>";
			$strValor = $strValor . "<LI> ori_tarjeta: " . RecuperaCampos($xmlDoc, $sNumOperacion, "ori_tarjeta") . "<BR>";
			$strValor = $strValor . "<LI> nom_emisor: " . RecuperaCampos($xmlDoc, $sNumOperacion, "nom_emisor") . "<BR>";
			$strValor = $strValor . "<LI> eci: " . RecuperaCampos($xmlDoc, $sNumOperacion, "eci") . "<BR>";
			$strValor = $strValor . "<LI> dsc_eci: " . RecuperaCampos($xmlDoc, $sNumOperacion, "dsc_eci") . "<BR>";
			$strValor = $strValor . "<LI> cod_autoriza: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_autoriza") . "<BR>";
			$strValor = $strValor . "<LI> cod_rescvv2: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_rescvv2") . "<BR>";
			$strValor = $strValor . "<LI> imp_autorizado: " . RecuperaCampos($xmlDoc, $sNumOperacion, "imp_autorizado") . "<BR>";
			$strValor = $strValor . "<LI> fechayhora_tx: " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_tx") . "<BR>";
			$strValor = $strValor . "<LI> fechayhora_deposito: " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_deposito") . "<BR>";
			$strValor = $strValor . "<LI> fechayhora_devolucion: " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_devolucion") . "<BR>";
			$strValor = $strValor . "<LI> dato_comercio: " . RecuperaCampos($xmlDoc, $sNumOperacion, "dato_comercio") . "<BR>";
	
			echo($strValor);
	}
	
	//Funcion de ejemplo que obtiene la cantidad de mensajes
	function CantidadMensajes($xmlDoc){
		$cantMensajes= 0;
		$xpath = new DOMXPath($xmlDoc);
		$nodeList = $xpath->query('//mensajes', $xmlDoc);
		
		$XmlNode= $nodeList->item(0);
		
		if($XmlNode==null){
			$cantMensajes= 0;
		}else{
			$cantMensajes= $XmlNode->childNodes->length;
		}
		return $cantMensajes; 
	}
	
	//Funcion que recupera el valor del Eticket
	function RecuperaEticket($xmlDoc){
		$strReturn = "";
			
			$xpath = new DOMXPath($xmlDoc);
			$nodeList = $xpath->query("//registro/campo[@id='ETICKET']");
			
			$XmlNode= $nodeList->item(0);
			
			if($XmlNode==null){
				$strReturn = "";
			}else{
				$strReturn = $XmlNode->nodeValue;
			}
			return $strReturn;
	}
	
	
	function descripcion_visa( $cod_accion ){ 
		
		switch( $cod_accion ){
			case '101': $mensaje = 'Operaci�n Denegada. Tarjeta Vencida.'; break;
			case '102': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '104': $mensaje = 'Operaci�n Denegada. Operacion no permitida para esta tarjeta.'; break;
			case '106': $mensaje = 'Operaci�n Denegada. Intentos de pin excedidos.'; break;
			case '107': $mensaje = 'Operaci�n Denegada. Contactar con el emisor.'; break;
			case '108': $mensaje = 'Operaci�n Denegada. Exceso de actividad.'; break;
			case '109': $mensaje = 'Operaci�n Denegada. Identificaci�n inv�lida de establecimiento.'; break;
			case '110': $mensaje = 'Operaci�n Denegada. Operacion no permitida para esta tarjeta.'; break;
			case '111': $mensaje = 'Operaci�n Denegada. El monto de la transacci�n supera el valor m�ximo permitido para operaciones virtuales.'; break;
			case '112': $mensaje = 'Operaci�n Denegada. Se requiere clave.'; break;
			case '116': $mensaje = 'Operaci�n Denegada. Fondos insuficientes.'; break;
			case '117': $mensaje = 'Operaci�n Denegada. Clave incorrecta.'; break;
			case '118': $mensaje = 'Operaci�n Denegada. Tarjeta Inv�lida.'; break;
			case '119': $mensaje = 'Operaci�n Denegada. Exceso de intentos de ingreso de PIN.'; break;
			case '121': $mensaje = 'Operaci�n Denegada.'; break;
			case '126': $mensaje = 'Operaci�n Denegada. PIN inv�lido.'; break;
			case '129': $mensaje = 'Operaci�n Denegada. Tarjeta no operativa.'; break;			
			case '180': $mensaje = 'Operaci�n Denegada. Tarjeta inv�lida.'; break;
			case '181': $mensaje = 'Operaci�n Denegada. Tarjeta con restricciones de D�bito.'; break;
			case '182': $mensaje = 'Operaci�n Denegada. Tarjeta con restricciones de Cr�dito.'; break;
			case '183': $mensaje = 'Operaci�n Denegada. Error de sistema.'; break;
			case '190': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '191': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '192': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '199': $mensaje = 'Operaci�n Denegada. Operaci�n Denegada.'; break;
			case '201': $mensaje = 'Operaci�n Denegada. Tarjeta Vencida.'; break;
			case '202': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '204': $mensaje = 'Operaci�n Denegada. Operaci�n no permitida para esta tarjeta.'; break;
			case '206': $mensaje = 'Operaci�n Denegada. Exceso de intentos de ingreso de PIN.'; break;
			case '207': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '208': $mensaje = 'Operaci�n Denegada. Tarjeta Perdida.'; break;
			case '209': $mensaje = 'Operaci�n Denegada. Tarjeta Robada..'; break;
			case '263': $mensaje = 'Operaci�n Denegada. Error en el env�o de par�metros.'; break;
			case '264': $mensaje = 'Operaci�n Denegada. Banco Emisor no esta disponible para realizar la autenticaci�n.'; break;
			case '265': $mensaje = 'Operaci�n Denegada. Password de tarjeta habiente incorrecto.'; break;
			case '266': $mensaje = 'Operaci�n Denegada. Tarjeta Vencida.'; break;
			case '280': $mensaje = 'Operaci�n Denegada. Clave err�nea.'; break;
			case '290': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '300': $mensaje = 'Operaci�n Denegada. N�mero de pedido del comercio duplicado. Favor no atender.'; break;
			case '306': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '401': $mensaje = 'Operaci�n Denegada. Tienda inhabilitada.'; break;
			case '402': $mensaje = 'Operaci�n Denegada. Tienda con rango de IP no valido.'; break;
			case '403': $mensaje = 'Operaci�n Denegada. Tarjeta no autenticada.'; break;
			case '404': $mensaje = 'Operaci�n Denegada. El monto de la transacci�n supera el valor m�ximo permitido.'; break;
			case '405': $mensaje = 'Operaci�n Denegada. La tarjeta ha superado la cantidad m�xima de transacciones en el d�a.'; break;
			case '406': $mensaje = 'Operaci�n Denegada. La tienda ha superado la cantidad m�xima de transacciones en el d�a.'; break;
			case '407': $mensaje = 'Operaci�n Denegada. El monto de la transacci�n no llega al m�nimo permitido.'; break;
			case '408': $mensaje = 'Operaci�n Denegada. CVV2 no coincide.'; break;
			case '409': $mensaje = 'Operaci�n Denegada. CVV2 no procesado por Banco.'; break;
			case '410': $mensaje = 'Operaci�n Denegada. CVV2 no procesado por no ingresado.'; break;
			case '411': $mensaje = 'Operaci�n Denegada. CVV2 no procesado por Banco.'; break;
			case '412': $mensaje = 'Operaci�n Denegada. CVV2 no reconocido por Banco.'; break;
			case '413': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '414': $mensaje = 'Operaci�n Denegada.'; break;
			case '415': $mensaje = 'Operaci�n Denegada.'; break;
			case '416': $mensaje = 'Operaci�n Denegada.'; break;
			case '417': $mensaje = 'Operaci�n Denegada.'; break;
			case '418': $mensaje = 'Operaci�n Denegada.'; break;
			case '419': $mensaje = 'Operaci�n Denegada.'; break;
			case '420': $mensaje = 'Operaci�n Denegada. Tarjeta no es VISA.'; break;
			case '421': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '422': $mensaje = 'Operaci�n Denegada. El comercio no est� configurado para usar este medio de pago.'; break;
			case '423': $mensaje = 'Operaci�n Denegada. Se cancel� el proceso de pago / Cancelled checkout.'; break;
			case '424': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '425': $mensaje = 'Operaci�n Denegada. Pa�s emisor incorrecto.'; break;
			case '666': $mensaje = 'Operaci�n Denegada. Problemas de comunicaci�n. Intente mas tarde.'; break;
			case '807': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '900': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '904': $mensaje = 'Operaci�n Denegada. Formato de mensaje err�neo.'; break;
			case '909': $mensaje = 'Operaci�n Denegada. Error de sistema.'; break;			
			case '910': $mensaje = 'Operaci�n Denegada. Error de sistema.'; break;
			case '912': $mensaje = 'Operaci�n Denegada. Emisor no disponible.'; break;
			case '913': $mensaje = 'Operaci�n Denegada. Transmisi�n duplicada.'; break;
			case '916': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '928': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '940': $mensaje = 'Operaci�n Denegada. Transacci�n anulada previamente.'; break;
			case '941': $mensaje = 'Operaci�n Denegada. Transacci�n ya anulada previamente.'; break;
			case '942': $mensaje = 'Operaci�n Denegada.'; break;
			case '943': $mensaje = 'Operaci�n Denegada. Datos originales distintos.'; break;
			case '945': $mensaje = 'Operaci�n Denegada. Referencia repetida.'; break;
			case '946': $mensaje = 'Operaci�n Denegada. Operaci�n de anulaci�n en proceso.'; break;
			case '947': $mensaje = 'Operaci�n Denegada. Comunicaci�n duplicada.'; break;
			case '948': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '949': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;
			case '965': $mensaje = 'Operaci�n Denegada. Contactar con emisor.'; break;		
			
		}
		
		
		return utf8_encode($mensaje);
	}
	
	
?>
