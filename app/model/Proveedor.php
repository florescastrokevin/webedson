<?php
class Proveedor{
	private $_id, $_nombre;
	public function __construct($id = 0){
		$this->_id = $id;
		if($this->_id > 0){
			
			$sql = " SELECT * FROM proveedores WHERE id_proveedor = '".$this->_id."'";
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 			
				$this->_nombre	=	$row['nombre_proveedor'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
}
?>