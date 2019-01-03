<?php
class CategoriaBlog{
	
	private $_id, $_titulo, $_parent;
	
	public function __construct($id = 0){
		$this->_id = $id;
	
		if($this->_id > 0){
			 
			$sql = " SELECT * FROM categorias_blog WHERE id_categoria_blog = '".$this->_id."'";
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 	
				$this->_titulo 	 = $row['titulo_categoria_blog'];
				$this->_parent	 = $row['id_parent_categoria_blog'];
			}       
			
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
}?>