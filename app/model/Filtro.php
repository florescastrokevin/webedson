<?php
class Filtro{
	private $_id, $_idioma, $_nombre, $_parent, $_url;
	public function __construct($id = 0, Idioma $idioma = Null){
		$this->_id = $id;
		$this->_idioma = $idioma;
		
		if($this->_id > 0){
			 
			$sql = " SELECT * FROM filtros WHERE id_filtro = '".$this->_id."'";
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 			
                $this->_nombre 	 = $row['nombre_filtro'];
                $this->_url  	 = $row['url_filtro'];
                $this->_parent	 = $row['id_parent'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
}?>