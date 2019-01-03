<?php
class Cliente extends Main{
	
	private $_id;
	private $_logeado = FALSE;
	private $_usuario = "Visitante";
	private $_nombre = "";
	private $_apellidos = "";
	private $_email;
	private $_telefono;
	public  $_carrito;
	public  $_pedido;
	private $_back;	
	private $_direccion;
	private $_ciudad;
	private $_pais;
	private $_pagina_referencia;
	private $_pagina_inicio;
	private $_observacion;
        private $_comportamiento;
	
	 
	public function __construct($id = 0){
		$this->_id = $id;
		if($this->_id > 0){
			$sql = "SELECT * FROM clientes WHERE id_cliente = '".$this->_id."'";			
			$query = new Consulta($sql);
			if($query->NumeroRegistros() > 0 ){
				$row = $query->VerRegistro();
				$this->_usuario     = $row["nombre_cliente"].' '.$row["apellidos_cliente"] ;
				$this->_nombre      = $row["nombre_cliente"];
				$this->_apellidos   = $row["apellidos_cliente"] ;
				$this->_telefono    = $row["telefono_cliente"];				
				$this->_email       = $row["email_cliente"];
				$this->_direccion   = $row["direccion_cliente"];
				$this->_ciudad      = $row["ciudad_cliente"];
				$this->_pais        = $row["pais_cliente"];
                $this->_pagina_referencia = $row["pagina_referencia_cliente"];
				$this->_pagina_inicio = $row["pagina_inicio_cliente"];
				$this->_observacion = $row["observacion_cliente"];
			}
		}
		$this->_carrito = new Carrito();		
		$this->_back = '';
		$this->_destino = '';			
			
	}
	
	public function __set($field, $value){
		$this->$field = $value;
	}
	
	public function __get($field){
		return $this->$field;
	}
	 
	public function getCarrito(){
		return $this->_carrito; 
	}	
	
	function setLogeado($valor){
		$this->_logeado = $valor;
	}
		
	public function getLogeado(){
            return $this->_logeado;
	}
		
	public function sumaIngreso(){
            $sq = new Consulta("SELECT MAX(numero_accesos_cliente) 
                                                            FROM clientes_informacion WHERE id_cliente='".$this->_id."'");

            $rultimo = $sq->VerRegistro();			
            $ua      = $rultimo[0]+1;	
            $sql_info="UPDATE clientes_informacion 
                                    SET ultimo_acceso_cliente='".date('Y-m-d H:i:s')."',
                                            numero_accesos_cliente='".$ua."'
                                    WHERE id_cliente='".$this->_id."'";

            $query_info = new Consulta($sql_info);	
	}
        
        static public function CantidadPedidos($id_cliente){
            $sql = "SELECT count(id_pedido) as cantidad FROM pedidos WHERE id_cliente = '".$id_cliente."' 
                    AND (estado_pedido = '%Pagado%' OR estado_pedido = 'Entregado')
                    GROUP BY id_cliente ";
            $query = new Consulta($sql);
            $row = $query->VerRegistro();
            $datos = $row['cantidad'];
            return $datos;
        }
        
        static public function getUltimoPedido($id_cliente){
            $sql = "SELECT DATE_FORMAT(fecha_pedido,'%d-%m-%Y') as fecha FROM pedidos WHERE id_cliente ='".$id_cliente."' and estado_pedido = 'Entregado' LIMIT 0,1 ";
            $query = new Consulta($sql);
            $row = $query->verRegistro();
            $ultima_fecha = $row["fecha"];
            return $ultima_fecha;
        }
        
        static public function getCantidadTransacciones($id_cliente){
            $sql = "SELECT count(*) as total FROM pedidos WHERE id_cliente ='".$id_cliente."'  GROUP BY id_cliente ";
            $query = new Consulta($sql);
            $row = $query->verRegistro();
            $transacciones = $row["total"];
            return $transacciones;
        }
        
        public function getPedidos(){
            $sql = "SELECT *, DATE_FORMAT(fecha_pedido,'%d-%m-%Y') as fecha_pedido, pd.fecha_full_destinatario as fecha_entrega, estado_pedido 
                    FROM pedidos_destinatarios pd
                    INNER JOIN pedidos USING(id_pedido)
                    INNER JOIN metodo_pago USING(id_metodo_pago)
                    WHERE 
                        id_cliente = '".$this->_id."'
                    GROUP BY id_pedido ";
            $query = new Consulta($sql);
            while($row = $query->verRegistro()){
                $datos[] = array(
                    "id"           => $row["id_pedido"],
                    "fecha_pedido" => $row["fecha_pedido"],
                    "fecha_entrega"=> $row["fecha_entrega"],
                    "metodo_pago"  => $row["nombre_metodo_pago"],
                    "estado"       => $row["estado_pedido"]
                );
            } 
            return $datos;
        }
        
        static public function getUltimoProducto($id_cliente){
            $sql = "SELECT id_producto, nombre_producto FROM pedidos
                    INNER JOIN pedidos_productos USING(id_pedido)
                    INNER JOIN productos USING (id_producto)
                    WHERE id_cliente ='".$id_cliente."' 
                    GROUP BY id_producto 
                    ORDER BY fecha_pedido DESC
                    LIMIT 0,1";
            $query = new Consulta($sql);
            $row = $query->verRegistro();
            $producto = $row["nombre_producto"];
            return $producto;
        }
        
        static public function getProductosComprados($id_cliente){
            $sql = "SELECT * FROM pedidos
                        INNER JOIN pedidos_productos USING(id_pedido)
                        INNER JOIN productos USING (id_producto)
                    WHERE id_cliente ='".$id_cliente."'  GROUP BY id_producto ";
            $query = new Consulta($sql);
            $row = $query->verRegistro();
            $transacciones = $row["total"];
            return $transacciones;
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

	static public function getFechasEspecialesClientes($id_cliente){
      
        $sql = "SELECT * FROM destinatarios 
                LEFT JOIN fechas_especiales USING (id_destinatario)
                LEFT JOIN ocasiones USING (id_ocasion)
                LEFT JOIN tipos_destinatarios USING (id_tipo_destinatario)
                WHERE id_cliente='".$id_cliente."' ";               
        

        $query = new Consulta($sql);
            $cliente;
            while($row = $query->VerRegistro()){
                $cliente[] = array(
                    'id_destinatario'          => $row["id_destinatario"],
                    'fecha_especial'           => $row["fecha_especial"],
                    'nombre_destinatario'      => $row["nombre_destinatario"],
                    'apellidos_destinatarios'  => $row["apellidos_destinatarios"],
                    'telefono_destinatario'    => $row["telefono_destinatario"],
                    'direccion_destinatario'   => $row["direccion_destinatario"],
                    'referencia_destinatario'  => $row["referencia_destinatario"],
                    'nombre_ocasion'           => $row["nombre_ocasion"],
                    'nombre_tipo_destinatario' => $row["nombre_tipo_destinatario"],
                    'id_fecha_especial'        => $row["id_fecha_especial"]
                );
            }
            return $cliente;
    }
}