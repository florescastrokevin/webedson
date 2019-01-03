<?php
class Expresion{
	
	private $_id, $_nombre, $_descripcion, $_orden, $_visitas;
	
	public function __construct($id = 0){
		$this->_id = $id;
		
		if($this->_id > 0){
			 
			$sql = "SELECT * FROM expresiones WHERE id_expresion = '".$this->_id."'";
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_nombre      =  $row['nombre_expresion'];
                                $this->_descripcion =  $row['descripcion_expresion'];
                                $this->_orden       =  $row['orden_expresion'];
                                $this->_visitas     =  $row['visitas_expresion'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
	
}
 ?>