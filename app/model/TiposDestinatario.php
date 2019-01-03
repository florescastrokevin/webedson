<?php

class TiposDestinatario{

	
	private $_id;

    private $_nombre;

	private $_descripcion;

	private $_orden;


	public function __construct($id = 0){

            $this->_id = $id;

            if($this->_id > 0){ // si existe, leer de la base de datos

                $sql = "SELECT * FROM tipos_destinatarios WHERE id_tipo_destinatario = '".$this->_id."' ";			
				
                $query = new Consulta($sql);

                if($query->NumeroRegistros() > 0 ){

                    $row = $query->VerRegistro();
					
					$this->_nombre  	  = $row["nombre_tipo_destinatario"];                    
					
                    $this->_descripcion   = $row["descripcion_tipo_destinatario"];
					
					$this->_orden		  = $row["orden_tipo_destinatario"];

                }                 

            }            

	}	

	

	// Function Recuperar destinatario

	public function __get($attribute){

		return	$this->$attribute;

	}	

	// editar destiantario

	public function __set($field, $value){

		$this->$field = $value;

	}

	

}

?>