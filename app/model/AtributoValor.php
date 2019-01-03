<?php
	class AtributoValor{
		
		private $_id_atributo_valor;
		private $_id_atributo;
		private $_valor_atributo_valor;
		private $_imagen_atributo_valor;
		
		public function __construct($id = 0){
		
		$this->_id_atributo_valor = $id;		
		if($this->_id_atributo_valor > 0){
			
			$query = new Consulta("SELECT * FROM atributos_valores WHERE id_atributo_valor = '".$this->_id_atributo_valor."'");
			
				if($row = $query->VerRegistro()){ 			
					$this->_id_atributo = $row['id_atributo'];
					$this->_valor_atributo_valor = $row['valor_atributo_valor'];
					$this->_imagen_atributo_valor = $row['imagen_atributo_valor'];
				}
			
			}					
		}
		
		public function __get($attribute){
			return	$this->$attribute;
		}
		
	}
	
?>