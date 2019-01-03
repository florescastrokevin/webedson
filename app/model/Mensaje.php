<?php 
class Mensaje{

	private $_id,$_descripcion, $_tipo;
	
	public function __construct($id = 0){

		$this->_id = $id;
		if($this->_id > 0){
			$sql = "SELECT * FROM mensajes WHERE id_mensaje = '".$this->_id."'";
			$query = new Consulta($sql);
			if($row = $query->VerRegistro()){ 
				$this->_descripcion  =  $row['descripcion_mensaje'];
				$this->_tipo = new TipoMensaje($row['id_tipo_mensaje']);
			}
		}	
	}
	public function __get($attribute){
		return	$this->$attribute;
	}
}