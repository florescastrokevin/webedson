<?php 
require_once _model_.'Sintagma.php';
class Tag{
	
	private $_id, $_categoria, $_sintagma, $_texto, $_orden, $_visitas;
	
	public function __construct($id = 0){
		
		$this->_id = $id;
		
		if($this->_id > 0){
			 
			$sql = "SELECT * FROM tags WHERE id_tag = '".$this->_id."'";
			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_texto       =  $row['texto_tag'];
				$this->_categoria= new Categoria($row['id_categoria']);
                                $this->_sintagma = new Sintagma($row['id_sintagma']);
                                $this->_orden         =  $row['orden_tag'];
                                $this->_visitas      =  $row['visitas_tag'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
	
}

?>