<?php
class Atributo{
	
	private $_id, $_nombre;
	
	public function __construct($id = 0){
		$this->_id = $id;	
		
		if($this->_id > 0){
			 
			$sql = " SELECT * FROM atributos WHERE id_atributo = '".$this->_id."'";
			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 			
				$this->_nombre 	 = $row['nombre_atributo'];			
			}
			
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
} ?>