<?php
require_once _model_.'Categoria.php';

class Producto{
	
	private $_id, $_idioma, $_categoria, $_nombre, $_descripcion_corta, $_precio_producto, $_imagenes , $_destacado , $_relacionados, $_tags, $_tags_id, $_tags_nombre ,$_ocasiones, $_ocasiones_id , $_destinatarios , $_destinatarios_id , $_expresiones , $_expresiones_id , $_tipos , $_is_complemento ,$_tipos_id, $_insumos , $_dscto , $_precio_old , $_atributos = array() , $_complementos = array() , $_stock;
	public function __construct($id = 0, Idioma $idioma = Null){
		$this->_id = $id;		
		$this->_idioma = $idioma;
		
		if($this->_id > 0){
			 
			$sql = " SELECT * FROM productos WHERE id_producto = '".$this->_id."'";			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				
				$sql_oferta="SELECT * FROM ofertas WHERE id_producto = '".$this->_id."'";
				$rs_oferta=new Consulta($sql_oferta);
				
				$this->_nombre 	   	= $row['nombre_producto'];
				$this->_categoria   = new Categoria($row['id_categoria'], $this->_idioma);
				$this->_descripcion = $row['descripcion_producto'];
				$this->_descripcion_corta = $row['descripcion_corta_producto'];		
				$this->_destacado = $row['destacado_producto'];			
				$this->_stock	= $row['stock_producto'];
				$this->_is_complemento = $row['is_complemento'];
				
				$tmp_tags = $row['tags_producto'];				
				$ttags = array();
				$ttags = explode(',',$tmp_tags);
				
				if(count($ttags)>0){
				   foreach( $ttags as $tgs ){
				   	$this->_tags_nombre[] = $tgs;
				   }
				   //$this->_tags_nombre = 
				}
				
				if( $rs_oferta->NumeroRegistros()>0){
					$row_Of = $rs_oferta->VerRegistro();
					$this->_precio_producto	= $row_Of['precio_oferta'];
					$this->_dscto = 100 - round( ($row_Of['precio_oferta'] * 100 )/$row['precio_producto'] );
					$this->_precio_old = $row['precio_producto'];
				}else{
					$this->_precio_producto	= $row['precio_producto'];	
				}
				
											
			}
			
			
			
			$sql_imgs = " SELECT * FROM productos_imagenes WHERE id_producto = '".$this->_id."' ORDER BY id_producto_imagen ASC";
			$query_imgs = new Consulta($sql_imgs);
			if($query_imgs->NumeroRegistros() > 0){
				while($row_imgs = $query_imgs->VerRegistro()){
					$this->_imagenes[] = array(
							'id'        => $row_imgs['id_producto_imagen'],
							'thumbnail' => $row_imgs['thumb_producto_imagen'],
							'big'       => $row_imgs['big_thumb_imagen'],
							'middle'    => $row_imgs['middle_producto_imagen'],							
							'imagen'    => $row_imgs['imagen_producto_imagen']
					);
				}
			}
			
			 //	Insumos						
			$queryi = new Consulta("SELECT id_insumo, nombre_insumo, cantidad FROM productos_insumos INNER JOIN insumos USING(id_insumo)
WHERE id_producto = '".$this->_id."'");
			if($queryi->NumeroRegistros() > 0){
				while($rowi = $queryi->VerRegistro()){
					$this->_insumos[] = array(
						$rowi['id_insumo'],
						$rowi['nombre_insumo'],
						$rowi['cantidad']
					);
				}
			}
			
			
			
                        //tags						
						/*$queryt = new Consulta("SELECT * FROM productos_tags WHERE id_producto = '".$this->_id."'");
                        if($queryt->NumeroRegistros() > 0){
                            while($rowt = $queryt->VerRegistro()){
                                $this->_tags[] = array(
                                    'id'    => $rowt['id_producto_tag'],
                                    'id_tag'=> $rowt['id_tag'],
                                    'texto' => $rowt['texto_producto_tag']
                                );
                                $this->_tags_id[] = $rowt['id_tag'];
                            }
                        }*/
						
						//ocaciones
						$queryo = new Consulta("SELECT * FROM productos_ocasiones 
												INNER JOIN ocasiones USING (id_ocasion) 
												WHERE id_producto = '".$this->_id."'");
                        if($queryo->NumeroRegistros() > 0){
                            while($rowo = $queryo->VerRegistro()){
                                $this->_ocasiones[] = array(
                                    'id'	=> $rowo['id_ocasion'],
                                    'texto' => $rowo['nombre_ocasion']
                                );
                                $this->_ocasiones_id[] = $rowo['id_ocasion'];
                            }
                        }
						
						//destinatarios
						$queryd = new Consulta("SELECT * FROM productos_destinatarios
												INNER JOIN destinatarios USING (id_destinatario) 
												WHERE id_producto = '".$this->_id."'");
                        if($queryd->NumeroRegistros() > 0){
                            while($rowd = $queryd->VerRegistro()){
                                $this->_destinatarios[] = array(
                                    'id'    => $rowd['id_destinatario'],                                  
                                    'texto' => $rowd['nombre_destinatario']
                                );
                                $this->_destinatarios_id[] = $rowd['id_destinatario'];
                            }
                        }
						
						//expresiones
						$querye = new Consulta("SELECT * FROM productos_expresiones
												INNER JOIN expresiones USING (id_expresion) 
												WHERE id_producto = '".$this->_id."'");
                        if($querye->NumeroRegistros() > 0){
                            while($rowe = $querye->VerRegistro()){
                                $this->_expresiones[] = array(
                                    'id'    => $rowe['id_expresion'],                                  
                                    'texto' => $rowe['nombre_expresion']
                                );
                                $this->_expresiones_id[] = $rowe['id_expresion'];
                            }
                        }
						
						//tipos
						$queryti = new Consulta("SELECT * FROM productos_tipos
												INNER JOIN tipos USING (id_tipo) 
												WHERE id_producto = '".$this->_id."'");
                        if($queryti->NumeroRegistros() > 0){
                            while($rowti = $queryti->VerRegistro()){
                                $this->_tipos[] = array(
                                    'id'    => $rowti['id_tipo'],                                  
                                    'texto' => $rowti['nombre_tipo']
                                );
                                $this->_tipos_id[] = $rowti['id_tipo'];
                            }
                        }
						
						//_ocaciones_id
						//_destinatarios_id
						//_expresiones_id
						//_tipos_id
						
						/*$queryt = new Consulta("SELECT * FROM productos_tags WHERE id_producto = '".$this->_id."'");
                        if($queryt->NumeroRegistros() > 0){
                            while($rowt = $queryt->VerRegistro()){
                                $this->_tags[] = array(
                                    'id'    => $rowt['id_producto_tag'],
                                    'id_tag'=> $rowt['id_tag'],
                                    'texto' => $rowt['texto_producto_tag']
                                );
                                $this->_tags_id[] = $rowt['id_tag'];
                            }
                        }	*/			

			
			


			$query_r = new Consulta("SELECT * FROM productos_relacionados WHERE id_producto = '".$this->_id."'");
			if($query_r->NumeroRegistros() > 0){
				while($rowr = $query_r->VerRegistro()){
					$this->_relacionados[] = array(
							'id'  => $rowr['id_producto_relacionado']
					);
				}
			}
			
			
			$querypc = new Consulta("SELECT * FROM productos_complementos WHERE id_producto = '".$this->_id."'");
			if($querypc->NumeroRegistros() > 0){
				while($rowpc = $querypc->VerRegistro()){
					$this->_complementos[] = array(
							'id'  => $rowpc['id_complemento']
					);
				}
			}
		}					

	}

	

	public function __get($attribute){

		return	$this->$attribute;

	}


	//OBTIENE LAS OPCIONES DE UN PRODUCTO
		
	function opcionesProducto($id){
		if ( class_exists ( 'Atributos' ) ){
			
			$query_pedidos_productos = new Consulta("SELECT * FROM pedidos p , pedidos_productos pp WHERE p.id_pedido = pp.id_pedido AND pp.id_producto = '".$id."' AND p.estado_pedido = 'Pediente'");
			
			$sq = new Consulta("SELECT * FROM productos_atributos pa, atributos a  
				WHERE a.id_atributo  = pa.id_atributo  AND 
						pa.id_producto='".$id."'");					
			$retorno;
			while($row = $sq->VerRegistro()){
				$retorno[] = array(
					'id' => $row['id_producto_atributo'], 
					'id_producto' => $row['id_producto'], 
					'id_atributo' => $row['id_atributo'],
					'nombre_atributo' => $row['nombre_atributo']			
				); 
			}		
			return $retorno;	
		}else
			return array();
	}
	
	function opcionesProductoCarrito($id){
		$sq = new Consulta("SELECT * FROM productos_atributos pa, atributos a  
			WHERE a.id_atributo = pa.id_atributo AND 
					pa.id_producto_atributo='".$id."' ");					
		$retorno;
		while($row = $sq->VerRegistro()){
			$retorno[] = array(
				'id' => $row['id_producto_atributo'], 
				'id_producto' => $row['id_producto'], 
				'id_atributo' => $row['id_atributo'],
				'nombre_atributo' => $row['nombre_atributo']			
			); 
		}		
		return $retorno;	
	}
		
	
	function valorOpcionesProducto($id){
		
		$sq = new Consulta("SELECT * FROM productos_atributos_valores pav, atributos_valores av
							 WHERE pav.id_atributo_valor = av.id_atributo_valor AND
								   pav.id_producto_atributo='".$id."'");			
		$retorno;
		while($row = $sq->VerRegistro()){
			$retorno[] = array(
				'id' 					=> $row['id_producto_atributo_valor'], 
				'id_atributo_valor' 	=> $row['id_atributo_valor'],
				'valor'					=> $row['valor_atributo_valor'],
				'prefijo'				=> $row['prefijo_producto_atributo_valor'],
				'precio'				=> $row['precio_producto_atributo_valor'],
				'stock'					=> $row['stock_producto_atributo_valor'],
				'imagen'				=> $row['imagen_atributo_valor']
					
				
			); 
		}		
		return $retorno;	
	}
	
	function valorAtributo($id){
		$sql = "SELECT * FROM productos_atributos_valores pav, atributos_valores av
							 WHERE pav.id_atributo_valor = av.id_atributo_valor AND
								   pav.id_producto_atributo_valor='".$id."'";
		//echo $sql;		
		$query = new Consulta($sql);
		$retorno;
		while($row = $query->VerRegistro()){
			$retorno[] = array(
					'id' 			=> $row['id_producto_atributo_valor'],
					'id_atributo' 	=> $row['id_atributo'],
					'valor'			=> $row['valor_atributo_valor'],
					'id_idioma'		=> $row['id_idioma']
			);		
		}	
		return $retorno;
	}
	

}

 ?>