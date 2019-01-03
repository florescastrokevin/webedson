<?php 
class Tipo{
	
	private $_id,  $_tipo;
	
	public function __construct($id = 0){
		
		$this->_id = $id;
		
		if($this->_id > 0){
			 
			$sql = "SELECT * FROM tipos WHERE id_tipo = '".$this->_id."'";
			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_tipo  =  $row['tipo'];
				
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
	
}

?>