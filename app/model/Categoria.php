<?php
class Categoria{
	private $_id, $_idioma, $_nombre, $_titulo, $_imagen, $_parent, $_descripcion, $_tags, $_estado, $_url;
	public function __construct($id = 0, Idioma $idioma = Null){
		$this->_id = $id;
		$this->_idioma = $idioma;
		
		if($this->_id > 0){
			 
			$sql = " SELECT * FROM categorias WHERE id_categoria = '".$this->_id."'";
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 			
                            $this->_nombre 	 = $row['nombre_categoria'];
                            $this->_titulo 	 = $row['titulo_categoria'];
                            $this->_descripcion  = $row['descripcion_categoria'];
                            $this->_imagen 	 = $row['imagen_categoria'];
                            $this->_parent	 = $row['id_parent'];
                            $this->_estado	 = $row['estado'];
                            $this->_url		 = $row['url_categoria'];
			}
                        
			$sqlt = "SELECT * FROM tags WHERE id_categoria = '".$this->_id."'";
			$queryt = new Consulta($sqlt);
			if($queryt->NumeroRegistros() > 0){
				while($rowt = $queryt->VerRegistro()){
					$this->_tags[] = array(
						'id'         => $rowt['id_tag'],
						'texto'      => $rowt['texto_tag'],
						'descripcion'=> $rowt['descripcion_tag']
					);
				}
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
}?>