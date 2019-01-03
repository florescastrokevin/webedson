<?php

require_once(_model_."Expresion.php");

class Expresiones 
{
	private $_msgbox;
	
	public function __construct($msg='')
	{
		$this->_msgbox = $msg;
		$this->_usuario = $user;
	}
	
	public function newExpresiones()
	{
		$query = new Consulta("SELECT * FROM expresiones");
		Form::getForm($query,"new","expresiones.php");
	}
	
	public function addExpresiones()
	{
		$query = new Consulta("INSERT INTO expresiones VALUES ('','".$_POST['nombre_expresion']."','".$_POST['descripcion_expresion']."','','')");
		$this->_msgbox->setMsgbox('Autor grabado correctamente.',2);
		location("expresiones.php");
	}
	
	public function editExpresiones()
	{
		$query = new Consulta("SELECT * FROM expresiones WHERE id_expresion = '".$_GET['id']."'");
		Form::getForm($query,"edit","expresiones.php");
	}
	
	public function updateExpresiones()
	{
		$query = new Consulta("UPDATE expresiones 
                                        SET nombre_expresion = '".$_POST['nombre_expresion']."',
                                            descripcion_expresion = '".$_POST['descripcion_expresion']."'
                                        WHERE id_expresion = '".$_GET['id']."'");
		
		$this->_msgbox->setMsgbox('Autor actualizado correctamente.',2);
		location("expresiones.php");
	}
	
	public function deleteExpresiones()
	{
		$query = new Consulta("DELETE FROM expresiones WHERE id_expresion = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Autor eliminado correctamente.',2);
		location("expresiones.php");
	}
	
	public function listExpresiones()
	{
		$query = new Consulta("SELECT * FROM expresiones");
		
		echo Listado::VerListado($query,"expresiones.php","","",$this->_usuario);
	}
	
	
	public function getCat( $idcat ){
		$obj_cat = new Categorias();
		$cats = $obj_cat->getCategorias('',$idcat);
		if(count($cats)>0){
			foreach ( $cats  as  $cat1):
				$this->getCat($cat1['id']);
			endforeach;
		}else{
			return $cats;
		}
	}
	
	
	public function getExpresionesByCat($id_cat){
		if ( empty($id_cat)){
			return $datos;
		}
		$sql = "SELECT * FROM productos INNER JOIN productos_expresiones USING(id_producto) INNER JOIN expresiones USING(id_expresion) WHERE productos.id_categoria='".$id_cat."'";		
		//echo $sql;
		$query = new Consulta($sql);
		while($row = $query->VerRegistro()){
			$datos[] = array(
				'id' 	 => $row['id_expresion'],
				'nombre' => $row['nombre_expresion'],
				'descripcion' => $row['descripcion_expresion']
			);	
		}		
		return $datos;
		
		
	}
	
	public function getExpresionesByCatRec($idcat){
		$datoss = array();
		$sql = "SELECT * FROM productos
				INNER JOIN productos_expresiones USING(id_producto)
				INNER JOIN expresiones USING(id_expresion)
				WHERE productos.id_categoria='".$idcat."'  GROUP BY id_expresion";				
				
		$query = new Consulta($sql);
		if($query->NumeroRegistros()==0){
			$datos = array();
			$query2 = new Consulta("SELECT id_categoria FROM categorias WHERE id_parent='".$idcat."'");
			while($row = $query2->VerRegistro()){
				$datos = array_merge($datos,$this->getExpresionesByCatRec($row['id_categoria']));
			}
			return $datos;
		}else{
			while($row = $query->VerRegistro()){
				$datoss[] = array(
					'id' 	 => $row['id_expresion'],
					'nombre' => $row['nombre_expresion'],
					'descripcion' => $row['descripcion_expresion']
				);	
			}
			return $datoss;
		}
	}
	
	
	public function getExpresiones()
	{
		$query = new Consulta("SELECT * FROM expresiones");
		while($row = $query->VerRegistro())
		{
			$datos[] = array(
				'id' 	 => $row['id_expresion'],
				'nombre' => $row['nombre_expresion'],
				'descripcion' => $row['descripcion_expresion']
			);	
		}
		
		return $datos;
	}

        
}
 ?>