<?php 
class TipoMensaje{

	private $_id,$_nombre;
	
	public function __construct($id = 0){

		$this->_id = $id;
		if($this->_id > 0){
			$sql = "SELECT * FROM tipos_mensajes WHERE id_tipo_mensaje = '".$this->_id."'";
			$query = new Consulta($sql);
			if($row = $query->VerRegistro()){ 
				$this->_id  =  $row['id_tipo_mensaje'];
				$this->_nombre  =  $row['nombre_tipo_mensaje'];
			}
		}	
	}
	public function __get($attribute){
		return	$this->$attribute;
	}
}