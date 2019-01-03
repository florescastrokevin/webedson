<?php
class TipoInsumo{
	private $_id, $_nombre;
	public function __construct($id = 0){
		$this->_id = $id;
		if($this->_id > 0){
			
			$sql = " SELECT * FROM tipos_insumos WHERE id_tipo_insumo = '".$this->_id."'";
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 			
				$this->_nombre		= $row['nombre_tipo_insumo'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
}
?>