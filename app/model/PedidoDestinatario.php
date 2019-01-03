<?php

class PedidoDestinatario{

	

	private $_id;

    private $_nombre;

	private $_apellidos;

	private $_telefono;

	private $_fecha_hora;

	private $_direccion;

	private $_distrito;

	private $_referencia;

	private $_dedicatoria;

    private $_id_pedido;

	private $_adicional;
	

	public function __construct($id_pedido = 0){

            $this->_id_pedido = $id_pedido;

            if($this->_id_pedido > 0){ // si existe, leer de la base de datos

                $sql = "SELECT * FROM pedidos_destinatarios WHERE id_pedido = '".$this->_id_pedido."' ";			
				

                $query = new Consulta($sql);

                if($query->NumeroRegistros() > 0 ){

                    $row = $query->VerRegistro();

                    $this->_id           = $row["id_cliente_destinatario"]; 
					
					$this->_nombre  	 = $row["nombre_destinatario"];                    

                    $this->_apellidos    = $row["apellidos_destinatario"] ;

                    $this->_telefono   	 = $row["telefono_destinatario"];
					
					$this->_fecha_hora	=  $row["fecha_full_destinatario"];
                  //  $this->_fecha  	 = $row["fecha_destinatario"];				

                   // $this->_hora     	 = $row["hora_destinatario"];

                    $this->_adicional    = $row["adicional_destinatario"];
					
					$this->_direccion    = $row["direccion_destinatario"];

                    $this->_distrito     = new Distrito($row["id_distrito"]);

                    $this->_referencia   = $row["referencia_destinatario"];

                    $this->_dedicatoria  = $row["dedicatoria_destinatario"];

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