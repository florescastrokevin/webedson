<?php
require_once _model_.'CategoriaBlog.php';

class Post{	
	private $_id, $_categoria, $_titulo, $_descripcion , $_destacado ,   $_tags , $_fecha;	
	public function __construct($id = 0){
		$this->_id = $id;		
		
		if($this->_id > 0){			 
			$sql = " SELECT * FROM post WHERE id_post = '".$this->_id."'";			
			$query = new Consulta($sql);			
			if($row = $query->VerRegistro()){ 				
				$this->_titulo 	   	= $row['titulo_post'];
				$this->_categoria   = new CategoriaBlog($row['id_categoria_blog']);
				$this->_descripcion = $row['descripcion_post'];
				$this->_fecha = $row['fecha_post'];	
				$this->_tags	= $row['tags_post'];
				$this->_destacado = $row['destacado_post'];
			}
			
		}

	}
	public function __get($attribute){
		return	$this->$attribute;
	}
}
?>