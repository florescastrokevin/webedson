<?php
class HistorialCesta{
	
	private $_id , $_id_producto , $_explorador , $_nombre_producto , $_precio_producto , $_fecha , $_so;
		
	public function __construct($id){
		if($id>0){
			$this->_id = $id;
			$query = new Consulta("SELECT * FROM historial_cesta WHERE id_historial_cesta = '".$this->_id."'");
			$row = $query->VerRegistro();
			$this->_id_producto = $row['id_producto'];
			$this->_explorador = $row['explorador_historial_cesta'];
			$this->_so = $row['so_historial_cesta'];
			$this->_nombre_producto = $row['nombre_producto_historial_cesta'];
			$this->_precio_producto = $row['precio_producto_historial_cesta'];
			$this->_fecha = $row['fecha_historial_cesta'];
		}
	}
	
	static public function add(){
		$producto = new Producto($_POST['id_producto']);
		$xplorador = getBrowser();
		$query = new Consulta("INSERT INTO historial_cesta VALUES ('',
                                        '".$_POST['id_producto']."',
                                        '".$xplorador['name'].' '.$xplorador['version']."',
                                        '".getOs()."',
                                        '".$producto->__get('_nombre')."',
                                        '".$producto->__get('_precio_producto')."',
                                        '".date('y-m-d H:i:s')."')");
	}	
	
	public function __get( $atribute ){
		return $this->$atribute;
	}
}
?>