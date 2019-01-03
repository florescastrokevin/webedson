<?php
class Insumo{
	private $_id, $_proveedor, $_tipo_insumo, $_parent, $_nombre, $_precio, $_imagen, $_stock;
	public function __construct($id = 0){
		$this->_id = $id;
		if($this->_id > 0){
			
			$sql = " SELECT * FROM insumos WHERE id_insumo = '".$this->_id."'";
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 			
				$this->_proveedor	= new Proveedor($row['id_proveedor']);
				$this->_tipo_insumo	= new TipoInsumo($row['id_tipo_insumo']);
				$this->_parent		= $row['id_parent'];
				$this->_nombre		= $row['nombre_insumo'];
				$this->_precio		= $row['precio_insumo'];
				$this->_imagen		= $row['imagen_insumo'];
				$this->_stock		= $row['stock_insumo'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
}
?>