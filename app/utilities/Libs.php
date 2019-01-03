<?php
function paginar($actual, $total, $por_pagina, $enlace){
  $total_paginas = ceil($total/$por_pagina);
  $anterior = $actual - 1;
  $posterior = $actual + 1;
  
  $f = isset($_GET['filtro']) && !empty($_GET['filtro']) ? "&filtro=pagfech" : "";
  
  
  if ($actual>1)
    $texto = "<a href=\"$enlace$anterior$f\">&laquo;</a>";
  else
    $texto = "<a href='#'>&laquo;</a>";
  for ($i=1; $i<$actual; $i++)
    $texto .= "<a href=\"$enlace$i$f\">$i</a> ";
  $texto   .= "<b>$actual</b>";
  for ($i=$actual+1; $i<=$total_paginas; $i++)
    $texto .= "<a href=\"$enlace$i$f\">$i</a> ";
  if ($actual<$total_paginas)
    $texto .= "<a href=\"$enlace$posterior$f\">&raquo;</a>";
  else
    $texto .= "<a href='#'>&raquo;</a>";
  return $texto;
}

function sql_htm($string) {
    $xml_str = mb_convert_encoding($string, "UTF-8", "ISO-8859-1");
    return $xml_str;
}

function url_frienly($url, $tipo) {
    if ($tipo == 1) {
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $url = utf8_decode($url);
        $url = strtr($url, utf8_decode($originales), $modificadas);
        $url = strtolower($url);
        $url = preg_replace('/[^ A-Za-z0-9_-]/', '', $url);
        return str_replace(" ", "-", strtolower($url));
    } else if ($tipo == 2) {
        $url = preg_replace('/[^ A-Za-z0-9_-]/', '', $url);
        return str_replace("-", " ", strtolower($url));
    }
}

function aasort(&$array, $key) {
    $sorter = array();
    $ret = array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }

    $ca = 0;
    foreach ($ret as $key => $value) {
        foreach ($value as $key1 => $value1) {
            $arr[$ca][$key1] = $ret[$key][$key1];
        }
        $ca++;
    }
    $array = $arr;
}

function custom_sort($a,$b) {
          return $a['some_sub_var']>$b['some_sub_var'];
     }

function paginar_blog($actual, $total, $por_pagina, $enlace){
	$total_paginas = ceil($total/$por_pagina);
	$anterior = $actual - 1;
	$posterior = $actual + 1;
  
  
  if ($actual>1)
    $texto = "<span class=\"active\"><a href=\"$enlace$anterior$order\">< Anterior</a></span><ul>";
  else
    $texto = '<span><a href="javascript:;">< Anterior</a></span><ul>';
    
  for ($i=1; $i<$actual; $i++){
    $texto .= "<li><a href=\"$enlace$i$order\">$i</a></li>";
  }
  
  $texto   .= "<li class=\"active\"><a href=\"javascript:;\">$actual</a></li>";
  
  
  	for ($i=$actual+1; $i<=$total_paginas; $i++){
		$texto .= "<li><a href=\"$enlace$i$order\">$i</a></li>";
	}
  
  
  if ($actual<$total_paginas)
    $texto .= "</ul><span class=\"active\"><a href=\"$enlace$posterior$order\">Siguiente ></a></span>";
  else
    $texto .= "</ul><span><a href=\"javascript:;\">Siguiente ></a></span>";	
  return $texto;
}

function paginar_URL($actual, $total, $por_pagina, $enlace){
   
   
    if($_GET['cat']){
		$obj_cat = new Categoria($_GET['cat']);
		$nombre_cat =  str_replace(" ","-",$obj_cat->__get('_nombre'))."_";
		$enlace = $nombre_cat;
	}else if( $_GET['n']=='Regalos' ){
		$enlace = 'Regalos_';
	}
  
	//FILTROS
	$url = $_SERVER["QUERY_STRING"];
	$filtro = $_GET['filtro'];
	
	if( $filtro !="" && preg_match("/_de_/i",$url)){ 
		$param = explode('&o=',$filtro);
		$enlace .= 'de_'.$param[0].'_';
	}	
	else if( $filtro !="" && preg_match("/_para_decir_/i", $url)){
		$param = explode('&o=',$filtro);
		$enlace .= 'para_decir_'.$param[0].'_';
	}
	else if( $filtro !="" && preg_match("/_para_/i", $url) ){
		$param = explode('&o=',$filtro);
		$enlace .= 'para_'.$param[0].'_';
	}
	else if( $filtro !="" && preg_match("/_/i", $url)){
		$param = explode('&o=',$filtro);
		$enlace .= $param[0].'_';
	}
	
	// SEARCH 
	//echo $url;
	/*if( preg_match("/q=/i",$url) ){
		$param = explode('q=',$url);
		//pre($param);
		$q = $param[1];
		$enlace='index.php?q='.$q.'_';
	}*/
		
  	// ORDER
	if( isset($_GET['o']) && !empty($_GET['o']) ){
	  $order = '?o='.$_GET['o'];
	}
  
	$total_paginas = ceil($total/$por_pagina);
	$anterior = $actual - 1;
	$posterior = $actual + 1;
  
  
  if ($actual>1)
    $texto = "<span class=\"active\"><a href=\"$enlace$anterior$order\">< Anterior</a></span><ul>";
  else
    $texto = '<span><a href="javascript:;">< Anterior</a></span><ul>';
  
  if( $total_paginas >= 5 ){
	  $k = (($posterior-3)<=0)?1:($posterior-3);
	  $k = (($total_paginas-3)<$actual) ?$total_paginas - 5: $k ;
  }else{
  	$k = 1;
  }
 for ($i=$k; $i<$actual; $i++){
    $texto .= "<li><a href=\"$enlace$i$order\">$i</a></li>";
  }
  
  $texto   .= "<li class=\"active\"><a href=\"javascript:;\">$actual</a></li>";
  
  if( $total_paginas > 5 ){
	$j=0;
	for ($i=$actual+1; $i<=$total_paginas; $i++){
		if( $i > 3 && $i<= $total_paginas - 3 ){
			if($j==0)
			$texto .= '<li>. . .</li>';
			else
			$texto .= '<li style="display:none;"><a>.</a></li>';
			$j++;
		}else {
			$texto .= "<li><a href=\"$enlace$i$order\">$i</a></li>";
		}
	}
  }else{
  	for ($i=$actual+1; $i<=$total_paginas; $i++){
		$texto .= "<li><a href=\"$enlace$i$order\">$i</a></li>";
	}
  }
  
  if ($actual<$total_paginas)
    $texto .= "</ul><span class=\"active\"><a href=\"$enlace$posterior$order\">Siguiente ></a></span>";
  else
    $texto .= "</ul><span><a href=\"javascript:;\">Siguiente ></a></span>";
	
	$texto .= '<span class="active"><a href="'.$enlace.'1'.$order.'_all">mostrar todos</a></span>';
  return $texto;
}

function paginar_catalogo($actual, $total, $por_pagina, $enlace) {
  $total_paginas = ceil($total/$por_pagina);
  $anterior = $actual - 1;
  $posterior = $actual + 1;
  	$texto = " " ;
	if ($actual>1)  
   $texto .= '<a  class="scroll_left" href="'.$enlace.$anterior.'"><img src="app/publicroot/imgs/arrow_previous.png"  alt="" /></a>';
  else
   $texto .= '<a class="scroll_left" href="#"><img src="app/publicroot/imgs/arrow_previous.png"  alt="" /></a>';
		$texto .= " ";
  for ($i=1; $i<$actual; $i++)
    $texto .= " <a href=\"$enlace$i\">$i</a>  ";
  	$texto .= "<a id='active_paginado'>$actual</a> ";
 for ($i=$actual+1; $i<=$total_paginas; $i++)
    $texto .= " <a href=\"$enlace$i\">$i</a> ";
	$texto .= " ";
  if ($actual<$total_paginas)
    $texto .= '<a class="scroll_righ" href="'.$enlace.$posterior.'"><img src="app/publicroot/imgs/arrow_next.png" alt="" /></a>';
  else
    $texto .= '<a class="scroll_righ" href="#"><img src="app/publicroot/imgs/arrow_next.png" alt="" /></a>';
	
  return $texto;
}

function isNaN( $var ) {
     return preg_match("/^[-]?[0-9]+([\.][0-9]+)?$/", $var);
}

function sacar($TheStr, $sLeft, $sRight){
    $pleft = strpos($TheStr, $sLeft, 0);
    if ($pleft !== false){
        $pright = strpos($TheStr, $sRight, $pleft + strlen($sLeft));
        if ($pright !== false) {
            return (substr($TheStr, $pleft + strlen($sLeft), ($pright - ($pleft + strlen($sLeft)))));
        }
    }
    return '';
}

function cleanArray($array, $campo){
  if(is_array($array) && count($array)>0){
  foreach ($array as $sub){
    $cmp[] = $sub[$campo];
  }
  $unique = (is_array($cmp)&&(count($cmp)>0))?array_unique($cmp):array();
  foreach ($unique as $k => $campo){
    $resultado[] = $array[$k];
  }
  return $resultado;
  }else{
	return array(); 
  }
}

function comillas_inteligentes($valor){
    // Retirar las barras
    if (get_magic_quotes_gpc()) {
        $valor = stripslashes($valor);
    }

    // Colocar comillas si no es entero
    if (!is_numeric($valor)) {
        $valor = "'" . mysqli_real_escape_string(Conexion::getInstance(),$valor) . "'";
    }
	
	//utilizar con sprintf($consulta)
    return $valor;
}

function set_horafecha_html_a_sql($fecha,$hora,$TIME_DEFAULT=FALSE){
	$time = $hora;	
	$nfecha=explode('/',$fecha);
	$dia=$nfecha[0];
	$mes=$nfecha[1];
	$axo=$nfecha[2];
	
	if($TIME_DEFAULT){ $time = '23:59:59'; }
	
	$ufecha=$axo."-".$mes."-".$dia." ".$time;
	return date("Y-m-d H:i:s",strtotime($ufecha));
}
function get_hora_sql_a_html($fecha){
	$bloques = explode(" ",$fecha);
	return $bloques[1];
}
function get_fecha_sql_a_html($fecha){
	if ($fecha!='') {
		$bloques = explode(" ",$fecha);
		$nfecha=explode('-',$bloques[0]);
		$dia=$nfecha[2];
		$mes=$nfecha[1];
		$axo=$nfecha[0];
		
		return $dia."/".$mes."/".$axo;
	}
}

function fecha_hora_html_sql($fecha_full,$TIME_DEFAULT=FALSE){
	$fecha_full = trim($fecha_full);	
	$fecha_hora = explode(' ',$fecha_full);	
	
	
	$time = $fecha_hora[1]." ".$fecha_hora[2];	
	$nfecha=explode('/',$fecha_full);
	$dia=$nfecha[0];
	$mes=$nfecha[1];
	$axo=explode(' ',$nfecha[2]);
	
	if($TIME_DEFAULT){ $time = '23:59:59'; }
	
	$ufecha=$axo[0]."-".$mes."-".$dia." ".$time;
	
	
	return date("Y-m-d H:i:s",strtotime($ufecha)); 	
}

function fecha_hora_sql_html($fecha_full){
	if( $fecha_full != "" ){
		return date("d/m/Y h:i a",strtotime( $fecha_full ));
	}else{
		return "";
	}
}

function formato_date($comodin,$fecha){
	$nfecha=explode($comodin,$fecha);
	$dia=$nfecha[0];
	$mes=$nfecha[1];
	$axo=$nfecha[2];
	$ufecha=$axo."-".$mes."-".$dia;
	return $ufecha;
}
function formato_slash($comodin,$fecha){
	$nfecha=explode($comodin,$fecha);
	$dia=$nfecha[2];
	$mes=$nfecha[1];
	$axo=$nfecha[0];
	$ufecha=$dia."/".$mes."/".$axo;
	return $ufecha;
}

function send($text) {
    header("Content-type: text/html; charset=utf-8");
    echo utf8_encode($text);
}

function passcont($psw){
	$txt=strlen($psw);
	$txt1=substr($psw,0,3);
	$txt2=substr($psw,3,3);

}

function impSelect($tabla,$extra,$idd){
	
	if($tabla == "provincias"){		
		$cat = "departamento";
	}else if($tabla == "distritos"){		
		$cat = "provincia";
	}	
	
	$where=" WHERE id_$cat = '".$idd."' ";
		
	$sql="SELECT * FROM ".$tabla." ".$where ;	
	$query = mysql_query($sql); 
	
	$retur = "";
	$retur.= '<select name = "'.$tabla.'" '.$extra.'   >
		<option value="">Seleccionar... </option>';
		while($row = mysql_fetch_array($query)){
			$retur .= " <option value='".$row[0]."' > ".$row[2]." ";
		} 
		//$retur.= $nuevo_valor; 
	$retur .= "</select>";
	// echo  $retur;
	echo $retur ;
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function passencode($password){	
	$newpass = ( md5($password) . '&' . strrev(strlen($password))  );
	return $newpass;	 
}

function passdecode($password ){
	$newpass = strrev($password);
	$newpass = explode('&', $newpass);
	$newpass = $newpass[0];	
	return $newpass;
}

function encriptar($valor){
	$cad=strlen($valor);
	$subcad=ceil($cad/2);
	$prev_valor=substr(strrev($valor),0,$subcad);
	$next_valor=substr(strrev($valor),$subcad,$cad);
	$pcad=$cad*647667904564;	
	$pass=$pcad.'|'.$prev_valor.'$'.$subcad.'|'.$next_valor.'$w3809245n0t9';	
	return str_replace("'","?",$pass);		
}

function desencriptar($valor){
	$cad=strlen($valor);
	$subcad=ceil($cad/2);
	$new_valor=explode("|",$valor);
	
	$pvalor=explode("$",$new_valor[1]);
	$prev_valor=$pvalor[0];
	
	$nvalor=explode("$",$new_valor[2]);
	$next_valor=$nvalor[0];
	
	$pass=strrev($prev_valor.$next_valor);
	return str_replace('?',"'",$pass);		
}
function in_multi_array($needle, $haystack)
{
    $in_multi_array = false;
    if(in_array($needle, $haystack))
    {
        $in_multi_array = true;
    }
    else
    {   
        for($i = 0; $i < sizeof($haystack); $i++)
        {
            if(is_array($haystack[$i]))
            {
                if(in_multi_array($needle, $haystack[$i]))
                {
                    $in_multi_array = true;
                    break;
                }
            }
        }
    }
    return $in_multi_array;
} 

function encode_json($array){
	$array_claves = array_keys($array);
	$filas = count($array, COUNT_RECURSIVE);
	$filas_array = count($array);
	if($filas == 0 or $filas == "")
		return false;
	else{
		if($filas>$filas_array){
			$coma = "";
			for($j=0; $j<$filas_array; $j++){
				$array_claves = array_keys($array[$j]);
				$filas = count($array[$j]);
				$array_array = $array[$j];
				$vector = $vector . $coma .recuperar_array($array_claves,$filas,$array_array);
				$coma=", ";
			}
			$vector = '['.$vector.']';
			return $vector;
		}
		else
		{
		$vector = recuperar_array($array_claves,$filas,$array);
		}			
	}
}

function recuperar_array($array_claves,$filas,$array){
	for($i=0; $i<$filas; $i++){
		$coma=", ";
		if(($i+1)==$filas)
		$coma="";
		$vector= $vector . '"' . $array_claves[$i] . '":"' . eregi_replace("[\n|\r|\n\r]", ' ', utf8_encode($array[$array_claves[$i]])). '"' . $coma;
	}
	$vector="{".$vector."}";
	return $vector;
}
function Month($fecha){
	$nfecha = explode("-",$fecha);
	$dia = $nfecha[2];
	$mes = $nfecha[1];
	$ano = $nfecha[0];
	$meses = array('01' => 'Enero','02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
	return  $meses[$mes]." ".$ano; 
}
function fecha_long($fecha){
	$nfecha = explode("-",$fecha);
	$dia = $nfecha[2];
	$mes = $nfecha[1];
	$ano = $nfecha[0];
	$meses = array('01' => 'Enero','02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
	return  $dia." de ".$meses[$mes]." del ".$ano; 
}
function fecha_short($fecha){
	$nfecha = explode("-",$fecha);
	$dia = $nfecha[2];
	$mes = $nfecha[1];
	$ano = $nfecha[0];
	$meses = array('01' => 'Enero','02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
	return  $dia." de ".$meses[$mes]; 
}
function ext($archivo) {
	$trozos = explode("." , $archivo);
	$ext = $trozos[ count($trozos) - 1];
	return (string) $ext;
}

function formatVideo($video, $w, $h){
	$nvideo = str_replace('width="640" height="385"','width="'.$w.'" height="'.$h.'"',$video);
	$nvideo = str_replace('width="560" height="340"','width="'.$w.'" height="'.$h.'"',$nvideo);
	$nvideo = str_replace('width="480" height="385"','width="'.$w.'" height="'.$h.'"',$nvideo);
	$nvideo = str_replace('allowfullscreen="true"','allowfullscreen="true" wmode="transparent"',$nvideo);
	return $nvideo;
}
function validateUser($id){
	$objca  = new ClienteAdmin($id);
	$plan = $objca->__get("_planes");
	
	if($plan[0]['estado'] == 0){
		return FALSE;
	}else{
		return TRUE;
	}
}

function aumentarMonth($desde, $cant){
	$fecha = $desde;
	return date("Y-m-d", strtotime("$fecha +".$cant." month"));  
}

function updateEstatus(){
	$query = new Consulta("SELECT * FROM clientes_planes WHERE fecha_finaliza < '".date("Y-m-d")."'");
	while($row = $query->VerRegistro()){
		$queryU = new Consulta("UPDATE clientes_planes SET estado = '0' 
										WHERE id_cliente_plan = '".$row['id_cliente_plan']."'");
	}
}

function get_parent( $id_cat = 0 ){
	$sql = "SELECT * FROM categorias WHERE id_parent = '".$id_cat."' ";					
	$query = new Consulta($sql);
	while($row = $query->VerRegistro()){
		$data[$row['id_categoria']] = array("parent_id" => $row['id_parent'], "name" => $row['nombre_categoria']);	
	}
	return $data;
}

function inCategories($id_cat=0){

	$sql = "SELECT * FROM categorias ORDER BY id_categoria";
					
	$query = new Consulta($sql);

	while($row = $query->VerRegistro()){
		$data[$row['id_categoria']] = array("parent_id" => $row['id_parent'], "name" => $row['nombre_categoria']);	
	}
	$array   = $data;
	
	return createTree($array,$id_cat); 
}

function pre( $array ){
	echo "<pre>";
	print_r($array);
	echo "<pre>";
}

function getIdCat0($id){
	$cat = new Categoria($id);
	$parent = $cat->__get("_parent");	
	if($parent==0){ 
		return $cat->__get("_id");		
	} else { 
		return getIdCat0($cat->__get("_parent"));
	}
}

function bucleCat($id,$id_parent){
	$obj = new Categorias();
	$cats = $obj->getCategorias($id,$id_parent);
	
	if (count($cats)>0){
		foreach ( $cats as $cat ){
			$parents[] = array(
				'id'	=>$cat['id'],
				'nombre'=>$cat['nombre'],
				'id1'	=>$cat['id1']
			);
		}
		return $parents;
	}
}

function createTree($array, $currentParent, $currLevel = 0, $prevLevel = -1) {
	foreach ($array as $categoryId => $category) {
		if ($currentParent == $category['parent_id']) {
			
			return $categoryId.",";	
							
			if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
			$currLevel++; 
			createTree ($array, $categoryId, $currLevel, $prevLevel);
			$currLevel--;	 		 	
		}	
	}
}


function getUrlActual(){
	$numero  = count($_GET);
	$tags 	 = array_keys($_GET);
	$valores = array_values($_GET);
	
	for($i=0;$i<$numero;$i++){
			$cad .=$tags[$i]."=".$valores[$i]."&";
	}
	$url = ($cad == '') ? basename($_SERVER['PHP_SELF']) : basename($_SERVER['PHP_SELF']).'?'.substr($cad,0,strlen($cad)-1);
	return $url;
}

function location($url)
{
	echo '<script type="text/javascript">location.href="'.$url.'";</script>';
}

function get_uid_producto($prid, $params){
	$uprid = $prid;
	if ( (is_array($params)) && (!strstr($prid, '{')) ) {			
		while (list($option, $value) = each($params)){				
			$uprid = $uprid . '{' .$option . '}' . $value;
		}
	}
	return $uprid;
}
	
function get_id_producto($uprid) {
    $pieces = explode('{', $uprid);

    return $pieces[0];
}

function limitarPalabras($cadena, $longitud, $elipsis = ' <b>...</b>') {  
    $palabras = explode(' ', $cadena);  
    if (count($palabras) > $longitud)  
    return implode(' ', array_slice($palabras, 0, $longitud)) . $elipsis;  
    else  
    return $cadena;  
} 

function verifica_oferta($id_producto=0){
	$oferta=false;	
	$sql="SELECT precio_oferta FROM ofertas WHERE id_producto='".$id_producto."' ";	
	$query=new Consulta($sql);
	if($query->NumeroRegistros()>0){
		$row=$query->VerRegistro();
		$oferta=$row[0];
	}
	return $oferta;
}

function verifica_oferta_pedido($id_producto, $fecha_limite){
	
	$oferta = 0;	
	
	$sql="SELECT precio_oferta FROM ofertas 
			WHERE id_producto='".$id_producto."' AND
				fecha_termino_oferta >= '".$fecha_limite."' AND 
				fecha_inicio_oferta <= date(now()) ";
	$query = new Consulta($sql);
	if($query->NumeroRegistros() > 0){
		$row = $query->VerRegistro();
		$oferta = $row[0];
	}
	return $oferta;
}

  function verifica_oferta_prod_conf($id_producto=0){
	$oferta=false;
	
	$sql="SELECT precio_oferta FROM ofertas 
			WHERE id_producto='".$id_producto."' ";
	$query=new Consulta($sql);
	if($query->NumeroRegistros()>0){
		$row=$query->VerRegistro();
		$oferta=$row[0];
	}
	return $oferta;
}

	function cantidad_productos_pedido($id_pedido){
		$sql = "SELECT sum(cantidad_pedido_producto) AS cantidad FROM pedidos_productos WHERE id_pedido='".$id_pedido."' GROUP BY id_pedido";
		$query = new Consulta($sql);
		$cantidad = 0;
		while($row = $query->VerRegistro()){
			$cantidad += $row['cantidad'];
		}
		
		return $cantidad; 	
	}
	
	function estado($id){
		$sql = "SELECT nombre_estado_pedido FROM estados_pedidos WHERE id_estado_pedido='".$id."'";
		$query = new Consulta($sql);	
		$row = $query->VerRegistro();
		return $row[0];	
	}
	
	function UTF8toiso8859_11($string) { 
  
     if ( ! ereg("[\241-\377]", $string) ) 
         return $string; 
  
     $UTF8 = array( 
		"\xe0\xb8\x81" => "\xa1", 
		"\xe0\xb8\x82" => "\xa2", 
		"\xe0\xb8\x83" => "\xa3", 
		"\xe0\xb8\x84" => "\xa4", 
		"\xe0\xb8\x85" => "\xa5", 
		"\xe0\xb8\x86" => "\xa6", 
		"\xe0\xb8\x87" => "\xa7", 
		"\xe0\xb8\x88" => "\xa8", 
		"\xe0\xb8\x89" => "\xa9", 
		"\xe0\xb8\x8a" => "\xaa", 
		"\xe0\xb8\x8b" => "\xab", 
		"\xe0\xb8\x8c" => "\xac", 
		"\xe0\xb8\x8d" => "\xad", 
		"\xe0\xb8\x8e" => "\xae", 
		"\xe0\xb8\x8f" => "\xaf", 
		"\xe0\xb8\x90" => "\xb0", 
		"\xe0\xb8\x91" => "\xb1", 
		"\xe0\xb8\x92" => "\xb2", 
		"\xe0\xb8\x93" => "\xb3", 
		"\xe0\xb8\x94" => "\xb4", 
		"\xe0\xb8\x95" => "\xb5", 
		"\xe0\xb8\x96" => "\xb6", 
		"\xe0\xb8\x97" => "\xb7", 
		"\xe0\xb8\x98" => "\xb8", 
		"\xe0\xb8\x99" => "\xb9", 
		"\xe0\xb8\x9a" => "\xba", 
		"\xe0\xb8\x9b" => "\xbb", 
		"\xe0\xb8\x9c" => "\xbc", 
		"\xe0\xb8\x9d" => "\xbd", 
		"\xe0\xb8\x9e" => "\xbe", 
		"\xe0\xb8\x9f" => "\xbf", 
		"\xe0\xb8\xa0" => "\xc0", 
		"\xe0\xb8\xa1" => "\xc1", 
		"\xe0\xb8\xa2" => "\xc2", 
		"\xe0\xb8\xa3" => "\xc3", 
		"\xe0\xb8\xa4" => "\xc4", 
		"\xe0\xb8\xa5" => "\xc5", 
		"\xe0\xb8\xa6" => "\xc6", 
		"\xe0\xb8\xa7" => "\xc7", 
		"\xe0\xb8\xa8" => "\xc8", 
		"\xe0\xb8\xa9" => "\xc9", 
		"\xe0\xb8\xaa" => "\xca", 
		"\xe0\xb8\xab" => "\xcb", 
		"\xe0\xb8\xac" => "\xcc", 
		"\xe0\xb8\xad" => "\xcd", 
		"\xe0\xb8\xae" => "\xce", 
		"\xe0\xb8\xaf" => "\xcf", 
		"\xe0\xb8\xb0" => "\xd0", 
		"\xe0\xb8\xb1" => "\xd1", 
		"\xe0\xb8\xb2" => "\xd2", 
		"\xe0\xb8\xb3" => "\xd3", 
		"\xe0\xb8\xb4" => "\xd4", 
		"\xe0\xb8\xb5" => "\xd5", 
		"\xe0\xb8\xb6" => "\xd6", 
		"\xe0\xb8\xb7" => "\xd7", 
		"\xe0\xb8\xb8" => "\xd8", 
		"\xe0\xb8\xb9" => "\xd9", 
		"\xe0\xb8\xba" => "\xda", 
		"\xe0\xb8\xbf" => "\xdf", 
		"\xe0\xb9\x80" => "\xe0", 
		"\xe0\xb9\x81" => "\xe1", 
		"\xe0\xb9\x82" => "\xe2", 
		"\xe0\xb9\x83" => "\xe3", 
		"\xe0\xb9\x84" => "\xe4", 
		"\xe0\xb9\x85" => "\xe5", 
		"\xe0\xb9\x86" => "\xe6", 
		"\xe0\xb9\x87" => "\xe7", 
		"\xe0\xb9\x88" => "\xe8", 
		"\xe0\xb9\x89" => "\xe9", 
		"\xe0\xb9\x8a" => "\xea", 
		"\xe0\xb9\x8b" => "\xeb", 
		"\xe0\xb9\x8c" => "\xec", 
		"\xe0\xb9\x8d" => "\xed", 
		"\xe0\xb9\x8e" => "\xee", 
		"\xe0\xb9\x8f" => "\xef", 
		"\xe0\xb9\x90" => "\xf0", 
		"\xe0\xb9\x91" => "\xf1", 
		"\xe0\xb9\x92" => "\xf2", 
		"\xe0\xb9\x93" => "\xf3", 
		"\xe0\xb9\x94" => "\xf4", 
		"\xe0\xb9\x95" => "\xf5", 
		"\xe0\xb9\x96" => "\xf6", 
		"\xe0\xb9\x97" => "\xf7", 
		"\xe0\xb9\x98" => "\xf8", 
		"\xe0\xb9\x99" => "\xf9", 
		"\xe0\xb9\x9a" => "\xfa", 
		"\xe0\xb9\x9b" => "\xfb", 
 ); 
  
     $string=strtr($string,$UTF8); 
     return $string; 
 } 
 
 function str_to_upper($str){
    return strtr($str, 
    "abcdefghijklmnopqrstuvwxyz".
    "\xE0\xE1\xE2\xE3\xE4\xE5".
    "\xb8\xe6\xe7\xe8\xe9\xea".
    "\xeb\xeC\xeD\xeE\xeF\xf0".
    "\xf1\xf2\xf3\xf4\xf5\xf6".
    "\xf7\xf8\xf9\xfA\xfB\xfC".
    "\xfD\xfE\xfF",
    "ABCDEFGHIJKLMNOPQRSTUVWXYZ".
    "\xC0\xC1\xC2\xC3\xC4\xC5".
    "\xA8\xC6\xC7\xC8\xC9\xCA".
    "\xCB\xCC\xCD\xCE\xCF\xD0".
    "\xD1\xD2\xD3\xD4\xD5\xD6".
    "\xD7\xD8\xD9\xDA\xDB\xDC".
    "\xDD\xDE\xDF");
}

function clear_precio( $precio ){
	$clear = preg_replace("/[^0-9]/", '', $precio);
	return $clear/100;
}


function clean_tyncme( $texto ){
	$search = array('&OACUTE;', '&EACUTE;', '&UACUTE;' , '&NBSP;' ,'<BR />','&IACUTE;');
	$replace = array('O', 'E', 'U',' ','	
	','I');
	$str = str_replace($search, $replace, $texto);
	return $str;
}




function sef_string($str) {
		// Eliminar entidades HTML
		$search = array('&lt;', '&gt;', '&quot;', '&amp;');
		$str = str_replace($search, '', $str);
		$str = preg_replace('/&(?!#[0-9]+;)/s', '', $str);
	
		// Convertir acentos y tildes
		$search = array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú', 'Ü', 'ü', 'Ñ', 'ñ', '_');
		$replace = array('a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'u', 'u', 'n', 'n', ' ');
		$str = str_replace($search, $replace, strtolower(trim($str)));
	
		// Eliminar todo lo que no sea letras, numeros o espacios y eliminar espacios dobles
		$str = preg_replace("/[^a-zA-Z0-9\s]/", "", $str);
		$str = preg_replace('/\s\s+/', ' ', $str);
	
		// Convertir espacios en guiones
		$str = str_replace(' ', '-', $str);
		return $str;
	}
	
	function typeImage($type){
		$type_file = "" ; 
		switch ( $type ){
			case 'image/jpeg': case 'image/pjpeg':
				$type_file = ".jpg";
			break;
			case 'image/gif':
				$type_file = ".gif";
			break;
			case 'image/png':
				$type_file = ".png";
			break;	
			case 'application/pdf':
				$type_file = ".pdf";
			break;
		}
		return $type_file;
	}
                        
	function deCadenaToArrayOpcionesCarrito( $string ){		
		// convierte de cadena a Array opciones de carrito
		$options = array();
		$temp = explode('{',$string);
		for( $i=1 ; $i<count($temp); $i++ ){
			$k = explode('}',$temp[$i]);
			$options[(int)$temp[$i]] = end($k);
		}
		return $options;
	}
	
	
	function printlist($idcat){
	
	// recorro las categorias imprimiendo los productos de las categorias
	
	$cats0 = bucleCatPDF('',$idcat); // devuelve todas las categorias de la categoria
	if (count($cats0)>0){  // si hay categorias
		foreach ( $cats0 as $cat0 ){
			$prods = getProductsByCat($cat0['id']); // devuelte todos los productos de esa categoria
			if( is_array($prods) && count($prods)>0 ){ // si hay productos en esa categoria 
				$_html = renderCategoriaxProducto($cat0['id']);	// imprime todos los productos de esa categoria
				echo $_html;													// param1: idcat, param2: nombre categoria
			}else{ // si no hay productos en esa categoria
				printlist($cat0['id']);	// paso a la sig. categoria
			}			
		}
	}else{ // si no hay categorias 
		$prods = getProductsByCat($idcat); // prueba suerte si hay productos
		$categoria = new Categoria($idcat); // creo instancia de categoria para crear nombre 
		if( is_array($prods) && count($prods)>0 ){ // si hay productos
			$_html = renderCategoriaxProducto($idcat);	 // imprimo los productos de esa categoria
			echo $_html;
		}
	}	 }
function bucleCatPDF($id,$id_parent){
	$obj = new Categorias();
	$cats = $obj->getCategorias($id,$id_parent);
	
	if (count($cats)>0){
		foreach ( $cats as $cat ){
			$parents[] = array(
				'id'	=>$cat['id'],
				'nombre'=>$cat['nombre'],
				'id1'	=>$cat['id1']
			);
		}
		return $parents;
	}else{
		return NULL;
	} 
}
function getProductsByCat( $idcat ){
	$query = new Consulta("SELECT * FROM productos WHERE id_categoria = '".$idcat."' LIMIT 0,1");
	while($row = $query->VerRegistro()){
		$prods[] = array('id'=>$row['id_producto']);
	}
	return $prods; }
function nave( $idcat ){
	$cate = new Categoria($idcat);
	if ( $cate->__get("_parent")!=""){		
		nave( $cate->__get("_parent") );
		echo '<b style="color:#00ADA4; font-weight:normal;">'.$cate->__get("_nombre").'</b> > ';
	} }
function renderCategoriaxProducto($idcat){
ob_start();
?>
<div style="height:70px; position:relative; width:755px; background:url(<?php echo _imgsfile_?>bg_nav-pdf.jpg) no-repeat left 21px;">
    <div style="bottom:5px; left:36px; width:201px; position:absolute;"><img src="<?php echo _imgsfile_ ?>logo.png" style="height:63px;"></div><!-- logo  -->
    <div style="position: absolute; bottom: 0px; right: 0px; text-align: right; font-size: 26px;">
        <img src="<?php echo _imgsfile_?>ico_phone.jpg"><strong style="font-size:20px;"> <?php echo TELEFONO?></strong><br/>
        <img src="<?php echo _imgsfile_?>world-icon.jpg"><span style="font-size:12px;"> <?php echo _url_web_?></span>
    </div>
</div>
<br>
<div style="background:url(<?php echo _imgsfile_?>line-pdf.jpg) no-repeat; width:755px; height:4px;"></div>

<?php

$page_header = ob_get_clean();	

ob_start();
nave($idcat);
$text_nav = ob_get_clean();	

$navegador = '<br><br><br><br><br>
    <div style="position: relative; width:748px; margin-left:10px; clear:both; margin-top:10px; border-bottom:1px solid #ccc; height:20px; padding-top:13px; font-size:12px; padding-left:5px;">
    	'.substr($text_nav,0,-3).'
    </div>';
	
	$prods = getProductsByCat($idcat); //dame todos los productos de esta categoria
	$count = 0;
	$page = '';	
	if ( count($prods)>0 ){			
	foreach ( $prods as $prod ){		
		if ( $count%3==0 ){ // muestra en una pagina PDF de 3 en 3 productos
			$page .='<page backtop="2mm" backbottom="2mm" backleft="-3mm" backright="0mm">';
			$page .='<page_header>'.$page_header.'</page_header>';
			$page .='<page_footer><div style="height:70px; position:relative; width:755px; background:url('._imgsfile_.'bootom-pdf.jpg) no-repeat;">
    <div style="position:absolute; left:26px; color:#e7e7e7; top:20px;">© '.date('Y').'. '.NOMBRE_SITIO.'. Todos los derechos reservados.<br/>
    Desarrollado por Develoweb
    </div>
    <div style="position: absolute; top: 35px; right: 26px; text-align: right; font-size: 11px; color:#e7e7e7;">Página '.$_SESSION['countpag']++.'</div>
</div></page_footer>';			
			$page .= $navegador;
			$countPages++;
		}
		$producto = new Producto($prod['id']);
		$imagenes = $producto->__get("_imagenes");
		ob_start();
		?>
        <table width="580" border="0" cellspacing="0" cellpadding="0" style="font-size:12px; margin-left:70px; margin-top:20px; margin-bottom:20px;">
      <tr>
        <td width="151" rowspan="7" align="left" valign="top">
        <div style="max-height:220px; margin-right: 10px;  max-width:190px; border:1px solid #aaa; margin-top:5px;">		
		<table style="border-collapse:collapse; width:100%; max-height: 220px;"><tr><td style="vertical-align:middle; text-align:center;">
		<?php if ( ($imagenes[0]['middle']!= "") && file_exists( _ruta_ . _link_file_.$imagenes[0]['middle'] )  ){
			//echo 'Img : '.$imagenes[0]['middle'];
			?>
			<img src="<?php echo _ruta_ . _link_file_.$imagenes[0]['middle'];?>" style="height:120px;">
		<?php }else{
			//echo 'IMagen no disponible';
			?>
			<img src="<?php echo _ruta_ . _link_file_.'not_image_disponible.jpg';?>" style="height:120px;">
		<?php }?>
        </td></tr></table>
        </div>
        </td>
        <td width="12">&nbsp;</td>
        <td height="28" colspan="2" style="font-size:18px;">
		<div style="width:411px;">
		<?php echo $producto->__get("_nombre")?>
        </div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="41" colspan="2">
        <div style="width:411px; margin-bottom:10px;  text-align:justify;">
       	<?php //echo $producto->__get("_descripcion")?>
        </div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="21" colspan="2" valign="middle">
        <?php  if ( $producto->__get("_dscto") !="" ): ?>  
        <div style="color:#FFF; font-size:14px; background:#ed1c24; width:91px; text-align:center;">-<?php echo $producto->__get("_dscto");?>% dcto.</div>
        <?php endif;?>
        </td>
      </tr>     
      <tr>
        <td height="28">&nbsp;</td>
        <td width="80" height="28" valign="bottom" style="font-size:24px;"><div style="color:#ed1c24; width:100px;">
        <?php
        $precio = $producto->__get("_precio_producto");		
		?>
        <?php echo _moneda_ . number_format($precio,2); ?></div></td>
        <td width="345" valign="bottom" style="font-size:14px;">
        
        <?php  if ( $producto->__get("_dscto") !="" ): ?>  
        <div style="color:#000; margin-left:20px; text-decoration:line-through; width:100px;">
			<?php echo _moneda_ . $producto->__get("_precio_old");?>
        </div>
        <?php endif;?>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">
        
        <table style="margin-top:5px;" bordercolor="#aaaaaa" width="103" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <?php if( count($imagenes) > 0 ){?>
            
			<?php foreach( $imagenes as $imagen ):?>
            <td width="50" valign="middle"><div style="border:1px solid #aaa; width:40px; height:40px; padding-top:5px;">            
			<?php if ( ($imagen['thumbnail']!= "") &&  file_exists(_ruta_ . _link_file_.$imagen['thumbnail'])){?>
	            <img src="<?php echo _ruta_ . _link_file_.$imagen['thumbnail'];?>" style="width:35px; height:35px;">
            <?php }else{?>
    	        <img src="<?php echo _ruta_ . _link_file_.'not_image_disponible_thumb.jpg';?>" style="width:35px; height:35px;">
            <?php }?>
            </div></td>
            <td width="5">&nbsp;</td>
            <?php endforeach;?>
            <?php }?>
          </tr>
        </table>
        
        </td>
      </tr>
    </table>
        <?php
		$page .= ob_get_clean();		
		if ( $count%3==0 ){
			$page .='</page>';
			$page .='<br>';
			$page .='<hr style="height:5px; width:600px; margin-left:10px; border:none; border-top:1px dashed #c0c0c0;">';
		}else{
			$page .='<br>';
			$page .='<hr style="height:5px; width:600px; margin-left:10px; border:none; border-top:1px dashed #c0c0c0;">';
		}
		$count++;
	}
	$html .= $page;
	}
	return $html;}
	
	
	function getBrowser(){ 
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";


// Next get the name of the useragent yes seperately and for good reason
if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){ 
$bname = 'Internet Explorer'; 
$ub = "MSIE"; 
} 
elseif(preg_match('/Firefox/i',$u_agent)){ 
$bname = 'Mozilla Firefox'; 
$ub = "Firefox"; 
} 
elseif(preg_match('/Chrome/i',$u_agent)){ 
$bname = 'Google Chrome'; 
$ub = "Chrome"; 
} 
elseif(preg_match('/Safari/i',$u_agent)){ 
$bname = 'Apple Safari'; 
$ub = "Safari"; 
} 
elseif(preg_match('/Opera/i',$u_agent)){ 
$bname = 'Opera'; 
$ub = "Opera"; 
} 
elseif(preg_match('/Netscape/i',$u_agent)){ 
$bname = 'Netscape'; 
$ub = "Netscape"; 
} 

// finally get the correct version number
$known = array('Version', $ub, 'other');
$pattern = '#(?<browser>' . join('|', $known) .
')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
if (!preg_match_all($pattern, $u_agent, $matches)) {
// we have no matching number just continue
}

// see how many we have
$i = count($matches['browser']);
if ($i != 1) {
//we will have two since we are not using 'other' argument yet
//see if version is before or after the name
if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
$version= $matches['version'][0];
}
else {
$version= $matches['version'][1];
}
}
else {
$version= $matches['version'][0];
}

// check if we have a number
if ($version==null || $version=="") {$version="?";}

return array(
	'userAgent' => $u_agent,
	'name' => $bname,
	'version' => $version,
	'pattern' => $pattern
);
} 



function getOs(){
$useragent= strtolower($_SERVER['HTTP_USER_AGENT']);

//winxp
if (strpos($useragent, 'windows nt 5.1') !== FALSE) {
return 'Windows XP';
}
elseif (strpos($useragent, 'windows nt 6.1') !== FALSE) {
return 'Windows 7';
}
elseif (strpos($useragent, 'windows nt 6.0') !== FALSE) {
return 'Windows Vista';
}
elseif (strpos($useragent, 'windows 98') !== FALSE) {
return 'Windows 98';
}
elseif (strpos($useragent, 'windows nt 5.0') !== FALSE) {
return 'Windows 2000';
}
elseif (strpos($useragent, 'windows nt 5.2') !== FALSE) {
return 'Windows 2003 Server';
}
elseif (strpos($useragent, 'windows nt') !== FALSE) {
return 'Windows NT';
}
elseif (strpos($useragent, 'win 9x 4.90') !== FALSE && strpos($useragent, 'win me')) {
return 'Windows ME';
}
elseif (strpos($useragent, 'win ce') !== FALSE) {
return 'Windows CE';
}
elseif (strpos($useragent, 'win 9x 4.90') !== FALSE) {
return 'Windows ME';
}
elseif (strpos($useragent, 'windows phone') !== FALSE) {
return 'Windows Phone';
}
elseif (strpos($useragent, 'iphone') !== FALSE) {
return 'iPhone';
}
// experimental
elseif (strpos($useragent, 'ipad') !== FALSE) {
return 'iPad';
}
elseif (strpos($useragent, 'webos') !== FALSE) {
return 'webOS';
}
elseif (strpos($useragent, 'symbian') !== FALSE) {
return 'Symbian';
}
elseif (strpos($useragent, 'android') !== FALSE) {
return 'Android';
}
elseif (strpos($useragent, 'blackberry') !== FALSE) {
return 'Blackberry';
}
elseif (strpos($useragent, 'mac os x') !== FALSE) {
return 'Mac OS X';
}
elseif (strpos($useragent, 'macintosh') !== FALSE) {
return 'Macintosh';
}
elseif (strpos($useragent, 'linux') !== FALSE) {
return 'Linux';
}
elseif (strpos($useragent, 'freebsd') !== FALSE) {
return 'Free BSD';
}
elseif (strpos($useragent, 'symbian') !== FALSE) {
return 'Symbian';
}
else 
{
return 'Desconocido';
}
}

//función básica para las notificaciones usados en la clase Paypal
function notify_webmaster($message)
{
    $subject="Nuevo Pago";
    $remite="ventas@donregalo.pe";
    $remitente="marketing@donregalo.pe";

    $header .="MIME-Version: 1.0\n"; 
    $header .= "Content-type: text/html; charset=iso-8859-1\n"; 
    $header .="From: ".$remitente."<".$remite.">\n";
    $header .="Return-path: ". $remite."\n";
    $header .="X-Mailer: PHP/". phpversion()."\n";

    mail("proyectos@develoweb.net", $subject, $message,$header);
}
 
//esta funcion puede utilizarse como almacenar en una variable global todas las acciones del script, de esta manera podremos rastrear errors facilmente.
function TransLog($message){	
    notify_webmaster($message);	
}
 
//examina todo el IPN y lo convierte en una cadena de texto
function Array2Str($kvsep, $entrysep, $a){
    $str = "";
    foreach ($a as $k=>$v){
        $str .= "{$k}{$kvsep}{$v}{$entrysep}";
    }
    return $str;
}
 
//para toda la ejecución del programa
function StopProcess(){
    exit;
}
?>