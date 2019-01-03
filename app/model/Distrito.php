<?php

class Distrito{
	

	private $_id, $_nombre, $_tarifa_envio;	

	public function __construct($id = 0){		

		$this->_id = $id;		

		if($this->_id > 0){
			 

                    $sql = "SELECT * FROM distritos WHERE id_distrito = '".$this->_id."'";

                    $query = new Consulta($sql);


                    if($row = $query->VerRegistro()){ 
                            $this->_nombre  =  $row['nombre_distrito'];
                            $this->_tarifa_envio  =  $row['tarifa_envio_distrito'];
                    }

		}					

	}	

	public function __get($attribute){
		return	$this->$attribute;
	}


    public function __set($field, $valor){
		$this->$field = $value;

	}

	

}

 ?>