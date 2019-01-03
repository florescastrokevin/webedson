<?php

require_once(_model_."Expresion.php");

class Destinatarios 
{
	private $_msgbox;
	
	public function __construct($msg='')
	{
		$this->_msgbox = $msg;
		$this->_usuario = $user;
	}

	public function getSearchDestinatariosEnvio($q,$id_cliente){
      	$sql = 'SELECT CONCAT_WS("+",id_destinatario,nombre_destinatario,apellidos_destinatarios,telefono_destinatario,direccion_destinatario,referencia_destinatario) AS info_destinatario,CONCAT(nombre_destinatario," ",apellidos_destinatarios) AS nombre FROM destinatarios WHERE id_cliente = '.$id_cliente.' AND nombre_destinatario LIKE "'.$q.'%" ';

        $query = new Consulta($sql);
        $items;
        while($row = $query->VerRegistro()){
            $items[$row['nombre']] = $row['info_destinatario'];
        }
        return $items;    
    }

	public function getSearchDestinatariosEnvio___($q,$id_cliente){
      	$sql = 'SELECT CONCAT_WS("+",id_destinatario,nombre_destinatario,apellidos_destinatarios,telefono_destinatario,direccion_destinatario, referencia_destinatario,latitud_destinatario,longitud_destinatario,fecha_full_destinatario) AS info_destinatario,CONCAT(nombre_destinatario," ",apellidos_destinatarios) AS nombre FROM destinatarios WHERE id_cliente ='.$id_cliente.' AND nombre_destinatario LIKE "'.$q.'%" ';

        $query = new Consulta($sql);
        $items;
        while($row = $query->VerRegistro()){
            $items[$row['nombre']] = $row['info_destinatario'];
        }
        return $items;  
    }

	public function getSearchDestinatarios($q,$id_cliente){
      	$sql = 'SELECT id_destinatario,nombre_destinatario,apellidos_destinatarios FROM destinatarios WHERE id_cliente = '.$id_cliente.' AND nombre_destinatario LIKE "'.$q.'%" ';

        $query = new Consulta($sql);
        $items;
        while($row = $query->VerRegistro()){
            $items[$row['nombre_destinatario'].' '.$row['apellidos_destinatarios']] = $row['id_destinatario'];
        }
        return $items;  
    }
	
	public function newDestinatarios()
	{
		$query = new Consulta("SELECT * FROM destinatarios");
		Form::getForm($query,"new","destinatarios.php");
	}
	
	public function addDestinatarios()
	{
		$query = new Consulta("INSERT INTO destinatarios VALUES ('','".$_POST['nombre_destinatario']."','".$_POST['descripcion_destinatario']."','','')");
		$this->_msgbox->setMsgbox('Destinatario grabado correctamente.',2);
		location("destinatarios.php");
	}
	
	public function editDestinatarios()
	{
		$query = new Consulta("SELECT * FROM destinatarios WHERE id_destinatario = '".$_GET['id']."'");
		Form::getForm($query,"edit","destinatarios.php");
	}
	
	public function updateDestinatarios()
	{
		$query = new Consulta("UPDATE destinatarios 
                                        SET nombre_destinatario = '".$_POST['nombre_destinatario']."',
                                            descripcion_destinatario = '".$_POST['descripcion_destinatario']."'
                                        WHERE id_destinatario = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Destinatario actualizado correctamente.',2);
		location("destinatarios.php");
	}
	
	public function deleteDestinatarios()
	{
		$query = new Consulta("DELETE FROM destinatarios WHERE id_destinatario = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Destinatario eliminado correctamente.',2);
		location("destinatarios.php");
	}
	
	public function listDestinatarios()
	{
		$query = new Consulta("SELECT * FROM destinatarios");
		echo Listado::VerListado($query,"destinatarios.php","","",$this->_usuario);
	}
	
	public function getDestinatarios()
	{
		$query = new Consulta("SELECT * FROM destinatarios");
		while($row = $query->VerRegistro())
		{
			$datos[] = array(
				'id' 	 => $row['id_destinatario'],
				'nombre' => $row['nombre_destinatario'],
				'descripcion' => $row['descripcion_destinatario']
			);	
		}
		
		return $datos;
	}
	
	public function getDestinatariosByCat( $id_cat ){
		
		if(empty($id_cat)){
			return $datos;
		}
		$sql = "SELECT * FROM productos INNER JOIN productos_destinatarios USING(id_producto) INNER JOIN destinatarios USING(id_destinatario) WHERE productos.id_categoria='".$id_cat."'";
		
		$query = new Consulta($sql);
		while($row = $query->VerRegistro()){
			$datos[] = array(
				'id' 	 => $row['id_destinatario'],
				'nombre' => $row['nombre_destinatario'],
				'descripcion' => $row['descripcion_destinatario']
			);	
		}		
		return $datos;
	}
	
	public function getDestinatariosByCatRec($idcat){
		$sql = "SELECT * FROM productos
				INNER JOIN productos_destinatarios USING(id_producto)
				INNER JOIN destinatarios USING(id_destinatario)
				WHERE productos.id_categoria='".$idcat."' GROUP BY id_destinatario";
		$query = new Consulta($sql);
		if($query->NumeroRegistros()==0){
			$datos = array();
			$query2 = new Consulta("SELECT id_categoria FROM categorias WHERE id_parent='".$idcat."'");
			while($row = $query2->VerRegistro()){
				$datos = array_merge($datos,$this->getDestinatariosByCatRec($row['id_categoria']));
			}
			return $datos;
		}else{
			while($row = $query->VerRegistro()){
				$datoss[] = array(
					'id' 	 => $row['id_destinatario'],
					'nombre' => $row['nombre_destinatario'],
					'descripcion' => $row['descripcion_destinatario']
				);	
			}
			return $datoss;
		}
	}

	static public function getTiposDestinatarios()
	{
		$query = new Consulta("SELECT * FROM tipos_destinatarios ORDER BY orden_tipo_destinatario ASC");
		while($row = $query->VerRegistro())
		{
			$datos[] = array(
				'id' 	 => $row['id_tipo_destinatario'],
				'nombre' => $row['nombre_tipo_destinatario']
			);	
		}
		
		return $datos;
	}

        
}
 ?>