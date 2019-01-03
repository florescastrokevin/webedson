<?php
class Libro{
	
	private $_id, $_titulo;
	
	public function __construct($id = 0){
		$this->_id = $id;
		
		if($this->_id > 0){
			 
			$sql = "SELECT * FROM libros WHERE id_libro = '".$this->_id."'";
			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_titulo  =  $row['titulo_libro'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
	
}
 ?>