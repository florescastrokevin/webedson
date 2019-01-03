<?php 

class Catalogo{

	private $_items_x_pagina = 48;
    private $_filtro;
	private $_numero_items = 0;
        
	function __construct(){ }

	public function Contenido(){

		
		if(isset($_GET['see']) && !empty($_GET['see'])){
			$this->_items_x_pagina = 100;
		}
		
		
		if(!isset($_GET['pag'])){ $_GET['pag'] = 1; }
		$tampag = $this->_items_x_pagina;
		$reg1 	= ($_GET['pag']-1) * $tampag;
		$tmplweb= "index.php?cat=".$_GET['cat'];
		$del = (int)$reg1 + 1;
		$hasta 	= $reg1 + $this->_items_x_pagina;

		//INICIALIZO VARIABLES DE SOPORTE
		$fromC  = "";
		$fromP  = "";
		$where = "";
		$filtroC = ""; 
		$filtroP = "";
                //filtro
                
                //echo "--->>> <pre>";
		//pre($this->_filtro);
				
		$filtro_id_parent = "";
		//$this->_filtro = $_SESSION['catalogo_filtro']; 
		if( is_array($this->_filtro) && count($this->_filtro) > 0 ){
		
                    $campoF = ", ".$this->_filtro["nombre_id"]." ";
                    $fromF = ", ".$this->_filtro["tabla"]." f ";

                    $filtroF = " AND f.".$this->_filtro["nombre_id"]." = '".$this->_filtro["id"]."' AND p.id_producto = f.id_producto ";

                    $nombreFiltro = " INNER JOIN ".$this->_filtro["tabla"]." USING(id_producto) ";
                    $filtroDato = " AND ".$this->_filtro["nombre_id"]." = '".$this->_filtro["id"]."' ";
                    //echo "!".$_GET['cat']."!";
                    $filtro_id_parent = $this->obtenerSubCategorias($_GET['cat']); // verificamos si el filtro esta aplicando a la categoria con subcategorias
			
		}
 
		//verifico si ha sido una busqueda
		if(isset($_GET['q'])){

                    Busquedas::addBusqueda($_GET['q']);

                    $filtroC = "AND CONCAT(c.nombre_categoria,' ',c.descripcion_categoria) LIKE '%".$_GET['q']."%' ";
                    $filtroP = "AND CONCAT(p.nombre_producto,' ',p.descripcion_producto,' ',p.descripcion_corta_producto,' ',p.tags_producto ) LIKE '%".$_GET['q']."%' AND p.estado = 1 ";



                    //descripcion_corta_producto , descripcion_producto , 

                    /*

                    //verifico si es que se filtrarà por tag
                    $tag = str_replace("+"," ",$_GET['q']);
                    //$filtroT = "AND pt.texto_tag LIKE '%".$_GET['q']."%' ";
                    $fromT .= ", productos_tags pt ";
                    $filtroT.= " OR pt.texto_producto_tag LIKE '%".$tag."%' AND
                                            pt.id_producto = p.id_producto and
                                            p.id_producto != 0 ";

                    */
		}

		//verifico si hay filtro por categoria
		$cCat = "";
		$pCat = "";
		if(isset($_GET['cat'])){
			if($filtro_id_parent != ""){  // si existe filtro de ocasion, expresion, tipo, destinatario
				$url = $_SERVER["QUERY_STRING"];
				$largo = strlen($url);
				if($url[$largo-1]!='_'){
					$pCat = " AND p.id_categoria IN ".$filtro_id_parent." ";
				}
			}else{                        
				$pCat = " AND p.id_categoria= '".$_GET['cat']."' ";
			}
			$cCat = " AND c.id_parent = '".$_GET['cat']."' ";
		} 

		//armo los parametros para filtrar por defecto las ofertas si es que no hay VARIABLES GET
		if(!isset($_GET['cat']) && !isset($_GET['j']) && !isset($_GET['q'])){
                    $cCat  = " AND c.id_parent = '0' ";
                    $pCat  = " AND p.id_categoria = '0' ";
		}

		if(isset($_GET['q'])){
            //$cCat = " AND id_parent = '-1' ";
			if($_GET['o']=='menor-mayor' || !isset($_GET['o'])){
				$orden = "ORDER BY p.precio_producto ASC";
			}else{
				$orden = "ORDER BY p.precio_producto DESC";
			}
		}else{
			$orden = "GROUP BY p.id_producto ORDER BY p.orden_producto ASC";
		}

		$sqlc ="SELECT c.id_categoria FROM categorias c ".$fromC."
                        WHERE  c.id_categoria != 0 										
                                ".$filtroC."
                                ".$cCat."
                        GROUP BY c.id_categoria
                        ORDER BY c.orden_categoria";
		

		$sqlp = "SELECT p.id_producto, p.id_categoria ".$campoF." FROM productos p  ".$fromP." ".$fromT." ".$fromF."
                         WHERE  p.id_producto != 0
						 AND p.estado_producto = 1
						 AND p.is_complemento = 0				 						
                                ".$where."
                                ".$filtroP."
                                ".$pCat."
                                ".$filtroT."
                                ".$filtroF."
                        		".$orden;
 
		//pre($prods);
		if(!isset($_GET['q'])){ // para que no ordene automaticamente porque sino se perdera el resultado de la busqueda
			$prods = $this->mostrarProductosByCat($nombreFiltro, $filtroDato);
			$prods = $this->ordenarProductos($prods);
		}else{ 
                    $queryp = new Consulta($sqlp);	

                    $prods = array();
                    while($rowp = $queryp->VerRegistro()){
                            $prods[] = array( 'id' =>	$rowp['id_producto']);
                    }
		}
		
		//pre($prods);
		
		$this->_numero_items = count($prods);
		
		//echo $this->_numero_items;
		
		$content = array($cats, $prods, $reg1, $hasta, $_GET['pag']);

		//pre($content);
		
		return $content;

	}

	

	public function mostrarProductosByCat($nombreFiltro, $filtroDato){
		
		//echo 'ID CAT : '.$_GET['cat'].'<br/>';
		
		return $this->prodByCat($_GET['cat'], $nombreFiltro, $filtroDato);
	}
	
	public function prodByCat($idcat, $nombreFiltro, $filtroDato){
		$sql = "SELECT id_producto FROM productos ".$nombreFiltro."
				WHERE productos.estado = 1 AND productos.id_categoria='".$idcat."' AND is_complemento = 0 AND estado_producto = 1 ".$filtroDato;
		//echo $sql;
		$query = new Consulta($sql);
		if($query->NumeroRegistros()==0){
			$datos = array();
			$query2 = new Consulta("SELECT id_categoria FROM categorias WHERE id_parent='".$idcat."'");
			while($row = $query2->VerRegistro()){
				$datos = array_merge($datos,$this->prodByCat($row['id_categoria'],$nombreFiltro, $filtroDato));
			}
			return $datos;
		}else{
			while($row = $query->VerRegistro()){
				$datoss[] = array(
					'id' 	 => $row['id_producto']
				);	
			}
			return $datoss;
		}
	}
	
	public function ordenarProductos($prod){
		$datos = array();
		$nprod = count($prod);
		if( $nprod==0 ){ return $datos; }
		for($i=0;$i<$nprod;$i++){
			$ids .= $prod[$i]['id'].",";
		}
		
		//pre($prod);
		
		$ids = trim($ids,",");
		if($_GET['o']=='menor-mayor'){
			$orden = "ORDER BY precio_producto ASC";
		}else if($_GET['o']=='mayor-menor'){
			$orden = "ORDER BY precio_producto DESC";
		}else{
			$orden = "ORDER BY orden_producto ASC";
		}
		if(isset($_GET['q']) && !isset($_GET['prod']) && !isset($_GET['cat'])){
			$filtro = " AND nombre_producto LIKE '%".trim($_GET['q'],"s")."%'";
		}
		$sql = "SELECT * FROM productos WHERE id_producto IN (".$ids.") AND is_complemento = 0 AND estado_producto = 1 ".$filtro." ".$orden;
		
		//echo $sql;
		
		$query = new Consulta($sql);
		while($row = $query->verRegistro()){
			$datos[] = array(
					'id'	=>	$row['id_producto']
				);	
		}
		return $datos;
	}
	
	public function getNovedadesLeft(){
		$sql = "SELECT * FROM productos 
					WHERE novedad_producto = '1' AND is_complemento = 0 AND estado_producto = 1 ORDER BY RAND()  LIMIT 0,1";
		$queryp = new Consulta($sql);	
		while($rown = $queryp->VerRegistro()){
			$prods[] = array(
				'id' => $rown['id_producto']
			);														
		}
		return $prods;	
	}
	
	public function getNovedades($ini, $fin){
		$sql = "SELECT * FROM productos WHERE novedad_producto = '1' AND is_complemento = 0 estado_producto = 1 LIMIT $ini, $fin";
		$queryp = new Consulta($sql);	
		while($rown = $queryp->VerRegistro()){
			$prods[] = array(
				'id'		 => $rown['id_producto']
			);														
		}
		return $prods;	
	}
	
	public function getTotalNovedades(){
		$query = new Consulta("SELECT * FROM productos WHERE novedad_producto = '1' AND is_complemento = 0 AND estado_producto = 1");
		return $query->NumeroRegistros();	
	}
        
	public static function VerificarSubcategorias($id_categoria_parent){
		
		$existen_sc;
		$sql = "SELECT * FROM categorias WHERE id_parent = '".$id_categoria_parent."'";
		$query = new Consulta($sql);
		
		if($query->NumeroRegistros() > 0){
			while($row = $query->VerRegistro()){
				$existen_sc[] = array(
					'id'        =>  $row['id_categoria'],
					'nombre'    =>  $row['nombre_categoria'],
					'descripcion'=> $row['descripcion_categoria'],
					'orden'     =>  $row['orden_categoria'],
					'id_parent' =>  $row['id_parent']                        
				);
				
			}
		}  
		return $existen_sc;
	}
        
	static public function getProductos(){
		
		$existen_sc;
		$sql = "SELECT * FROM productos p, categorias c WHERE p.id_categoria = c.id_categoria AND p.is_complemento = 0 AND p.estado_producto = 1 ORDER BY p.id_categoria";
		$query = new Consulta($sql);
		if($query->NumeroRegistros() > 0){
			while($row = $query->VerRegistro()){
				$existen_sc[] = array(
					'id'        =>  $row['id_producto'],
					'nombre'    =>  $row['nombre_producto'],
					'descripcion'=> $row['descripcion_producto'],
					'orden'     =>  $row['orden_producto'],
					'item'      =>  $row['nombre_categoria'].' &raquo  '.$row['nombre_producto'],
					'id_parent' =>  $row['id_categoria']                        
				);
				
			}
		}  
		return $existen_sc;
	}
	
	static public function existeCategoriasConEn($patron){

		$sql = "SELECT * FROM categorias WHERE nombre_categoria = '".$patron."' ";
                $query = new Consulta($sql);
		$registros = $query->NumeroRegistros();
		return 	$registros;	

	}
        
	public function items_en_pagina(){
		return $this->_items_x_pagina;
	}
	
	public function total_items(){
		return $this->_numero_items;
	}
        
	public function __set($field, $value){
		$this->$field = $value;
	}
	
	public function __get($field){
		return $this->$field;
	}
        
	public function obtenerSubCategorias($id_parent){
		
		/*$url = $_SERVER["QUERY_STRING"];
		$largo = strlen($url);*/
		
		$return = "";
/*		if($url[$largo-1]!='_'){*/
			$sql = "SELECT GROUP_CONCAT(id_categoria SEPARATOR ',') AS ids FROM categorias WHERE id_parent = '".$id_parent."'";/*
		}
		else{*/
			/*$sql = "SELECT GROUP_CONCAT(id_categoria SEPARATOR ',') AS ids FROM categorias WHERE id_parent IN (SELECT GROUP_CONCAT(id_categoria SEPARATOR ',') FROM categorias WHERE id_parent IN ('".$id_parent."'))";
//		}*/
		$query = new Consulta($sql);
		if( $query->NumeroRegistros() > 0 ){
			$data = $query->VerRegistro();
			$return = "(".$data['ids'].")";
		}
		/*
		
		
		
		$sql = "SELECT id_categoria FROM categorias WHERE id_parent = '".$id_parent."' ";
		$query = new Consulta($sql);
		if( $query->NumeroRegistros() > 0 ){
			$i = 0;
			$return = "(";
			while($row = $query->VerRegistro()){
			   if($i == 0){
				   $return .= $row["id_categoria"];
			   }else{
				   $return .= ",".$row["id_categoria"];
			   }

			   $i++;
		   }
		   $return .= ")";
		}*/
		
		return $return;
		
	}
        
        public function getFiltro(){
            
            $return = array();
            $url = $_SERVER["QUERY_STRING"];
            if(preg_match("/_de_/i",$url)){ //ocasión  
			              
                if(preg_match('/&fb_action_ids=/',$_SERVER['QUERY_STRING'])){
					
			$palabratemp = explode("&fb_action_ids=",$url);
			$_GET['filtro'] = $palabratemp[0];
			$palabra = str_replace("_"," ",end(explode("_de_",$palabratemp[0])));
		}else{
			
			$palabra = @str_replace("_"," ",end(explode("_de_",$url)));
			$_GET['filtro'] = $palabra;
		
		}
			
		if(preg_match('/&o=/i',$palabra)){
			list($palabra,$orden) = explode('&o=',$palabra);
		}												
		if(preg_match("/ /i",$palabra)) {
			$param = explode(' ',$palabra);
			$palabra = $param[0];
			$_GET['filtro'] = $param[0];
		}
		//echo "PALABRA : ".$palabra;
		$query = new Consulta("SELECT * FROM ocasiones WHERE nombre_ocasion = '".$palabra."'");
		$row = $query->VerRegistro();
		$return["tabla"] = "productos_ocasiones";
		$return["nombre_id"] = "id_ocasion";
		$return["id"] = $row["id_ocasion"];
			
				 
				
            }elseif(preg_match("/_para_decir_/i", $url)){ // expreciones
               
                if(preg_match('/&fb_action_ids=/',$_SERVER['QUERY_STRING'])){}else{
                    $palabra = str_replace("-"," ",str_replace("_"," ",end(explode("_para_decir_",$url))));

                        //echo 'Palabra real: ' .$palabra.'<br/>';

                        $_GET['filtro'] =  str_replace(" ","-",$palabra);			   	
                        if(preg_match('/&o=/i',$palabra)){
                                list($palabra,$orden) = explode('&o=',$palabra);
                        }								
                        if(preg_match("/ /i",$palabra)) {
                                $param = explode(' ',$palabra);
                                $palabra = $param[0].' '.$param[1].' '.$param[2].' '.$param[3];
                                $_GET['filtro'] = str_replace(" ","-",$param[0].' '.$param[1]);
                        }

                    $query = new Consulta("SELECT * FROM expresiones WHERE nombre_expresion = '".$palabra."'");
                    $row = $query->VerRegistro();
                    $return["tabla"] = "productos_expresiones";
                    $return["nombre_id"] = "id_expresion";
                    $return["id"] = $row["id_expresion"];	
                }
							
            }elseif(preg_match("/_para_/i", $url)){ //destinatario
                
                if(preg_match('/&fb_action_ids=/',$_SERVER['QUERY_STRING'])){}else{

                    $palabra = str_replace("_"," ",end(explode("_para_",$url)));
                    $_GET['filtro'] =  str_replace(" ","-",$palabra);
                    if(preg_match('/&o=/i',$palabra)){
                            list($palabra,$orden) = explode('&o=',$palabra);
                    }								
                    if(preg_match("/ /i",$palabra)) {
                            $param = explode(' ',$palabra);
                            $palabra = $param[0];
                            $_GET['filtro'] = $param[0];
                    }

                    $query = new Consulta("SELECT * FROM destinatarios WHERE nombre_destinatario = '".$palabra."'");
                    $row = $query->VerRegistro();
                    $return["tabla"] = "productos_destinatarios";
                    $return["nombre_id"] = "id_destinatario";
                    $return["id"] = $row["id_destinatario"];
				
                }
				
            }elseif(preg_match("/_/i", $url)){ // tipo de regalos
                
                //	echo "QUERY_STRING : ".$_SERVER['QUERY_STRING'];
				
                if(preg_match('/fb_action_ids=|&utm_source=/',$_SERVER['QUERY_STRING'])){

                        //echo "FB o ";
                        //echo "google";

                }else{
                        $palabra = explode("_",$url);
                        $palabra = end($palabra);	
                        $palabra = str_replace("_"," ",$palabra);
                        $param = explode('_',$url);
                        if( count($param)==2 ){					
                                if( (int)$param[1] == 0 ){
                                        $_GET['filtro']= $param[1];
                                }else{
                                        $_GET['filtro']= '';	
                                }					
                        }
                        if( count($param) == 3 ){
                                $_GET['filtro'] = $param[1];
                                $palabra = $param[1];
                        }

                        $query = new Consulta("SELECT * FROM tipos WHERE nombre_tipo = '".$palabra."'");
                        $row = $query->VerRegistro();
                        $return["tabla"] = "productos_tipos";
                        $return["nombre_id"] = "id_tipo";
                        $return["id"] = $row["id_tipo"];
                }
				
            } 
            
            return $return;
        }
        
	
	public function asignarFiltro($filtro){
		$this->_filtro = $filtro;
	} 
	
	public function getCatalogoPorCategoria($url)
	{
		$sql = "SELECT * FROM productos INNER JOIN categorias ON categorias.id_categoria = productos.id_categoria
		WHERE categorias.url_categoria LIKE '".$url."' AND estado_producto = 1 ";
		$query = new Consulta($sql);
		$prods = array();
		if($query->NumeroRegistros() > 0){
			while($row = $query->VerRegistro()){
				$prods[] = $row['id_producto'];
			}
		}
		$content = array('peluches', $prods, 0, 48, 1);
		return $content;
	}

	public function getCatalogoPorFiltro($url)
	{
		$sql = "SELECT * FROM productos_filtros INNER JOIN filtros ON filtros.id_filtro = productos_filtros.id_filtro WHERE url_filtro LIKE '".$url."' ";
		$query = new Consulta($sql);
		$prods = array();
		if($query->NumeroRegistros() > 0){
			while($row = $query->VerRegistro()){
				$prods[] = $row['id_producto'];
			}
		}
		$content = array('peluches', $prods, 0, 48, 1);
		return $content;
	}

	public function getCatalogoPorBusqueda($url)
	{
		/*El parametro que ha pasado o escrito en el combobox*/
		$source = $url;
		$sane = "";

		// Caracteres prohibidos porque en algunos sistemas operativos no son admitidos como nombre de fichero
		// Obtenida del código fuente de WordPress.org
		$forbidden_chars = array(
		  "?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&",
		  "$", "#", "*", "(", ")" , "|", "~", "`", "!", "{", "}", "%", "+" , chr(0));

		// Caracteres que queremos reemplazar por otros que hacen el texto igualmente legible
		$replace_chars = array(
		  'áéíóúäëïöüàèìòùñ ',
		  'aeiouaeiouaeioun_'
		);

		// Convertimos el texto a analizar a minúsculas
		$source = strtolower($source);

		//Comprobamos cada carácterIdit1611

		for( $i=0 ; $i < strlen($source) ; $i++ ) {
		  $sane_char = $source_char = $source[$i];
		  if ( in_array( $source_char, $forbidden_chars ) ) {
		    $sane_char = "_";
		    $sane .= $sane_char;
		    continue;
		  }
		  $pos = strpos( $replace_chars[0], $source_char);
		  if ( $pos !== false ) {
		    $sane_char = $replace_chars[1][$pos];
		    $sane .= $sane_char;
		    continue;
		  }
		  if ( ord($source_char) < 32 || ord($source_char) > 128 ) {
		    // Todos los caracteres codificados por debajo de 32 o encima de 128 son especiales
		    // Ver http://www.asciitable.com/
		    $sane_char = "_";
		    $sane .= $sane_char;
		    continue;
		  }
		  // Si ha pasado todos los controles, aceptamos el carácter
		  $sane .= $sane_char;
		}
		/*echo "Texto sanitizado : ".$sane;*/
		/*PARA LAS BUSQUEDAS VOY JUNTANDO LOS ID DE PRODUCTOS*/
		/*PRIMERO POR NOMBRE Y URL*/
		$prods = array();
		$sql1 = "SELECT * FROM productos WHERE nombre_producto LIKE '%".$sane."%' OR url_producto LIKE '%".$sane."%' AND estado_producto = 1 ";
		$query = new Consulta($sql1);
		if($query->NumeroRegistros() > 0){
			while($row = $query->VerRegistro()){
				$prods[] = $row['id_producto'];
			}
		}
		/*AHORA BUSCO POR URL DE CATEGORIA CATEGORIA*/
		$sql2 = "SELECT * FROM productos INNER JOIN categorias ON categorias.id_categoria = productos.id_categoria
		WHERE categorias.url_categoria LIKE '%".$sane."%' AND estado_producto = 1 ";
		$query = new Consulta($sql2);
		if($query->NumeroRegistros() > 0){
			while($row = $query->VerRegistro()){
				$prods[] = $row['id_producto'];
			}
		}
		/*AHORA BUSCO POR FILTROS*/
		$sql3 = "SELECT * FROM productos_filtros INNER JOIN filtros ON filtros.id_filtro = productos_filtros.id_filtro WHERE url_filtro LIKE '%".$sane."%' ";
		$query = new Consulta($sql3);
		if($query->NumeroRegistros() > 0){
			while($row = $query->VerRegistro()){
				$prods[] = $row['id_producto'];
			}
		}
		/*AHORA ELIMINO LOS PRODUCTOS REPETIDOS*/
		$prods = array_unique($prods);
		$content = array('peluches', $prods, 0, 48, 1);
		return $content;
	}

	public function getMenuNavegacionProductos($tipo,$valor)
	{
		/*PARA CREAR EL MENU DE NAVEGACION*/
		/*PRIMERO VEO CUAL ES EL PARAMETRO DE LA URL*/
		/*PUEDE SER C/ F/ B/ ETC*/
		switch ($tipo) {
			case 'c':/*ESTA PASANDO UNA CATEGORIA */
				$sql = "SELECT id_categoria FROM categorias WHERE url_categoria LIKE '".$valor."' ";
				$query = new Consulta($sql);
				$id_cate = '';
				if($query->NumeroRegistros() > 0){
					while($row = $query->VerRegistro()){
						$id_cate = $row['id_categoria'];
					}
				}
				$obj_categoria_padre = new Categoria($id_cate);
				$sub_categorias_hijo = array();
				$sql2 = "SELECT * FROM categorias WHERE id_parent = ".$obj_categoria_padre->__get('_id')." ";
				$query2 = new Consulta($sql2);
				if($query2->NumeroRegistros() > 0){
					while($row2 = $query2->VerRegistro()){
						$sub_categorias_hijo[] = $row2['id_categoria'];
					}
				}
				$lista_filtros = array();
				$sql3 = "SELECT id_filtro FROM filtros";
				$query3 = new Consulta($sql3);
				if($query3->NumeroRegistros() > 0){
					while($row3 = $query3->VerRegistro()){
						$lista_filtros[] = $row3['id_filtro'];
					}
				}
				$result = array($obj_categoria_padre,$sub_categorias_hijo,$lista_filtros);
				return $result;
				break;
			case 'f':/*ESTA PASANDO UN FILTRO */
				$lista_filtros = array();
				$sql3 = "SELECT id_filtro FROM filtros WHERE id_parent <> 0";
				$query3 = new Consulta($sql3);
				if($query3->NumeroRegistros() > 0){
					while($row3 = $query3->VerRegistro()){
						$lista_filtros[] = $row3['id_filtro'];
					}
				}
				$result = array('','',$lista_filtros);
				return $result;
				# code...
				break;
			default:
				# code...
				break;
		}
	}

} 