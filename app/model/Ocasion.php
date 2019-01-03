<?php
class Ocasion{
	
	private $_id, $_nombre, $_descripcion, $_orden, $_visitas, $_url;
	
	public function __construct($id = 0){
		$this->_id = $id;
		
		if($this->_id > 0){
			 
			$sql = "SELECT * FROM ocasiones WHERE id_ocasion = '".$this->_id."'";
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_nombre      =  $row['nombre_ocasion'];
                $this->_descripcion =  $row['descripcion_ocasion'];
                $this->_orden       =  $row['orden_ocasion'];
                $this->_visitas     =  $row['visitas_ocasion'];
                $this->_url     	=  $row['url_ocasion'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
	
}
 ?>