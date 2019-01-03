<?php
class Destinatario{
	
	private $_id; 
	private $_cliente; 
	private $_nombre; 
	private $_apellido; 
	private $_telefono;
	private $_direccion;
	private $_referencia;
	
	public function __construct($id = 0){
		$this->_id = $id;
		
		if($this->_id > 0){
			 
			$sql = "SELECT * FROM destinatarios WHERE id_destinatario = '".$this->_id."'";
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_cliente		=  $row['id_cliente'];
                $this->_nombre		=  $row['nombre_destinatario'];
                $this->_apellido	=  $row['apellidos_destinatarios'];
                $this->_telefono	=  $row['telefono_destinatario'];
                $this->_direccion	=  $row['direccion_destinatario'];
                $this->_referencia	=  $row['referencia_destinatario'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
	
}
 ?>