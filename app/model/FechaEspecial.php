<?php

class FechaEspecial{

	
	private $_id;

    private $_destinatario;

	private $_tipo_destinatario;

	private $_ocasion;

	private $_fecha;


	public function __construct($id = 0){

            $this->_id = $id;

            if($this->_id > 0){ // si existe, leer de la base de datos

                $sql = "SELECT * FROM fechas_especiales WHERE id_fecha_especial = '".$this->_id."' ";			
				
                $query = new Consulta($sql);

                if($query->NumeroRegistros() > 0 ){

                    $row = $query->VerRegistro();
					
					$this->_destinatario  	 	= new Destinatario($row["id_destinatario"]);                    

                    $this->_tipo_destinatario   = new TiposDestinatario($row["id_tipo_destinatario"]);

                    $this->_ocasion   	 		= new Ocasion($row["id_ocasion"]);
					
					$this->_fecha				= $row["fecha_especial"];

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