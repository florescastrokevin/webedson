<?php

class MetodoPago {
	
    private $_id;
    private $_nombre;
    private $_activo;
    private $_descripcion;
    private $_imagen;

    public function __construct($id = 0){		

        $this->_id = $id;
        if($this->_id > 0){
            $sql = "SELECT * FROM metodo_pago WHERE id_metodo_pago = '".$this->_id."'";			
            $query = new Consulta($sql);
            if($query->NumeroRegistros() > 0 ){
                $row = $query->VerRegistro();
                $this->_nombre  	 = $row["nombre_metodo_pago"] ;
                $this->_activo    	 = $row["activo_metodo_pago"];
                $this->_descripcion  = $row["descripcion_metodo_pago"];
                $this->_imagen       = $row["imagen_metodo_pago"];
            }
        }		
    }

    public function __get($field){
        return $this->$field;
    }
}

?>