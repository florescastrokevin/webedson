<?php

require_once(_model_."Tipo.php");

class Tipos 
{
	private $_msgbox;
	
	public function __construct($msg='')
	{
		$this->_msgbox = $msg;
		$this->_usuario = $user;
	}
	
	public function newTipos()
	{
		$query = new Consulta("SELECT * FROM Tipos");
		Form::getForm($query,"new","tipos.php");
	}
	
	public function addTipos()
	{
		$query = new Consulta("INSERT INTO tipos VALUES ('','".$_POST['nombre_tipo']."','".$_POST['descripcion_tipo']."','','')");
		$this->_msgbox->setMsgbox('Tipo grabado correctamente.',2);
		location("tipos.php");
	}
	
	public function editTipos()
	{
		$query = new Consulta("SELECT * FROM tipos WHERE id_tipo = '".$_GET['id']."'");
		Form::getForm($query,"edit","tipos.php");
	}
	
	public function updateTipos()
	{
		$query = new Consulta("UPDATE tipos 
                                        SET nombre_tipo = '".$_POST['nombre_tipo']."',
                                            descripcion_tipo = '".$_POST['descripcion_tipo']."'
                                        WHERE id_tipo = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Tipo actualizado correctamente.',2);
		location("tipos.php");
	}
	
	public function deleteTipos()
	{
		$query = new Consulta("DELETE FROM tipos WHERE id_tipo = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Tipo eliminado correctamente.',2);
		location("tipos.php");
	}
	
	public function listTipos()
	{
		$query = new Consulta("SELECT * FROM tipos");
		echo Listado::Simple($query,"tipos.php","","",$this->_usuario);
	}
	
	public function getTiposByCat($id_cat){
		
		if ( empty($id_cat)){
			return $datos;
		}
		
		$sql = "SELECT * FROM productos INNER JOIN productos_tipos USING(id_producto) INNER JOIN tipos USING(id_tipo) WHERE productos.id_categoria='".$id_cat."'";		
		$query = new Consulta($sql);
		while($row = $query->VerRegistro()){
			$datos[] = array(
				'id' 	 => $row['id_tipo'],
				'nombre' => $row['nombre_tipo'],
				'descripcion' => $row['descripcion_expresion']
			);	
		}		
		return $datos;
	}
	
	public function getTiposByCatRec($idcat){
		
		$sql = "SELECT * FROM productos
				INNER JOIN productos_tipos USING(id_producto)
				INNER JOIN tipos USING(id_tipo)
				WHERE productos.id_categoria='".$idcat."' GROUP BY id_tipo";
		$query = new Consulta($sql);
		if($query->NumeroRegistros()==0){
			$datos = array();
			$query2 = new Consulta("SELECT id_categoria FROM categorias WHERE id_parent='".$idcat."'");
			while($row = $query2->VerRegistro()){
				$datos = array_merge($datos,$this->getTiposByCatRec($row['id_categoria']));
			}
			return $datos;
		}else{
			while($row = $query->VerRegistro()){
				$datoss[] = array(
					'id' 	 => $row['id_tipo'],
					'nombre' => $row['nombre_tipo'],
					'descripcion' => $row['descripcion_expresion']
				);	
			}
			return $datoss;
		}
	}
	
	public function getTipos()
	{
		$query = new Consulta("SELECT * FROM tipos");
		while($row = $query->VerRegistro())
		{
			$datos[] = array(
				'id' 	 => $row['id_tipo'],
				'nombre' => $row['nombre_tipo'],
				'descripcion' => $row['descripcion_tipo']
			);	
		}
		
		return $datos;
	}

        
}
 ?>