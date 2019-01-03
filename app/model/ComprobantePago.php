<?php
class ComprobantePago{
	private $_id;
	private $_idpedido;
	private $_tipo;
	private $_nombre;
	private $_direccionb;
	private $_dni;
	
	private $_razon_social;
	private $_ruc;	
	private $_direccionf;
	private $_direccion_entrega;
        private $_id_pedido;
	
	public function ComprobantePago($id=0){
		$this->_id_pedido = $id;	
     	
		if($this->_id_pedido > 0){	   
			$sqlp = "SELECT * FROM pedidos_pagos WHERE id_pedido ='".$this->_id_pedido."'";			
			$queryp = new Consulta($sqlp);
			if($row = $queryp->VerRegistro()){				
				$this->_idpedido = $row['id_pedido'];	
				$this->_nombre = $row['nombre_pago'];	
				$this->_tipo = $row['tipo_pago'];
				$this->_dni = $row['dni_pago'];
								
				if ($this->_tipo == "Boleta"){ 
					$this->_direccionb = $row['direccion_pago'];
				}else{
					$this->_direccionf = $row['direccion_pago'];	
				}
				
				$this->_razon_social = $row['razon_social_pago'];
				$this->_ruc = $row['ruc_pago'];	
				$this->_direccion_entrega = $row['_direccion_entrega'];			
				}			
		}
	}
	
	// Function Recuperar ComprobantePago
	public function __get($attribute){
		return	$this->$attribute;
	}	
	// editar ComprobantePago
	public function __set($field, $value){
		$this->$field = $value;
	}
	
}

?>