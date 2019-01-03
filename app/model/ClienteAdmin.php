<?php
class ClienteAdmin{
	
	private $_id, $_nombre , $_apellidos, $_email, $_telefono, $_nac, $_uni, $_especialidad, $_ciudad, $_pagina_referencia, $_pagina_inicio, $_observacion, $_saldo, $_tipo, $_comportamiento;
	 
	public function __construct($id = 0){
		$this->_id = $id;
		if($this->_id > 0){
			$sql = "SELECT * FROM clientes WHERE id_cliente = '".$this->_id."'";
			
			$query = new Consulta($sql);
			if($query->NumeroRegistros() > 0 ){
				$row = $query->VerRegistro();
				$this->_nombre    	 = $row["nombre_cliente"];
				$this->_apellidos 	 = $row["apellidos_cliente"] ;
				$this->_telefono  	 = $row["telefono_cliente"];
				$this->_email     	 = $row["email_cliente"];
                                $this->_pagina_referencia= $row["pagina_referencia_cliente"];
				$this->_pagina_inicio 	 = $row["pagina_inicio_cliente"];
				$this->_observacion 	 = $row["observacion_cliente"];
				$this->_ciudad	 	 = $row["ciudad_cliente"];
				$this->_obs	 	 = $row["observacion_cliente"];
				$this->_saldo	 	 = $row["saldo_cliente"];
				$this->_tipo	 	 = $row["id_tipo"];
			}
		}
	}
	
	public function __set($field, $value){
		$this->$field = $value;
	}
	
	public function __get($field){
		return $this->$field;
	}
	
		
	public function getComportamiento(){
		$sql = "SELECT * FROM clientes_informacion WHERE id_cliente ='".$this->_id."'";
		$query = new Consulta($sql);
		if($query->NumeroRegistros() > 0 ){
			$row = $query->VerRegistro();
			$this->_comportamiento["ultimo_acceso"]     	= $row["ultimo_acceso_cliente"];
			$this->_comportamiento["numero_accesos"]    	= $row["numero_accesos_cliente"];
			$this->_comportamiento["fecha_ingreso"]   	= $row["fecha_ingreso_cliente"] ;
			$this->_comportamiento["fecha_ultima_modificacion"]    = $row["fecha_ultima_modificacion"];				
			$this->_comportamiento["notificacion_producto"] = $row["notificacion_producto_cliente"];
			$this->_comportamiento["navegador"] 		= $row["navegador_cliente_informacion"];
			$this->_comportamiento["sistema_operativo"] 	= $row["sistema_operativo_cliente_informacion"];
			$this->_comportamiento["agente_completo"] = $row["agente_completo_cliente_informacion"];
		}
		return $this->_comportamiento;
	}
}
?>