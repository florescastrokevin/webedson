<?php
class Sintagma{
	
	private $_id, $_nombre, $_descripcion;
	
	public function __construct($id = 0){
		$this->_id = $id;
		
		if($this->_id > 0){
			 
			$sql = "SELECT * FROM sintagmas WHERE id_sintagma = '".$this->_id."'";
			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_nombre  =  $row['nombre_sintagma'];
                                $this->_descripcion=  $row['descripcion_sintagma'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
	
}
 ?>