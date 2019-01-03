<?php
class Sintagmas
{
	private $_msgbox;
	
	public function __construct($msg='')
	{
		$this->_msgbox = $msg; 
	}
	
	public function newSintagmas()
	{
		$query = new Consulta("SELECT * FROM sintagmas");		
		Form::getForm($query,"new","sintagmas.php");
	}
	
	public function addSintagmas()
	{
		$query = new Consulta("INSERT INTO sintagmas VALUES ('','".$_POST['nombre_sintagma']."')");		
		$this->_msgbox->setMsgbox('Sintagma grabado correctamente.',2);
		location("Sintagmas.php");
	}
	
	public function editSintagmas()
	{
		$query = new Consulta("SELECT * FROM sintagmas WHERE id_sintagma = '".$_GET['id']."'");
		Form::getForm($query,"edit","sintagmas.php");
	}
	
	public function updateSintagmas()
	{
		$query = new Consulta("UPDATE sintagmas SET nombre_sintagma = '".$_POST['nombre_sintagma']."', descripcion_sintagma = '".$_POST['descripcion_sintagma']."' WHERE id_sintagma = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Sintagma actualizado correctamente.',2);
		location("Sintagmas.php");
	}
	
	public function deleteSintagmas()
	{
		$query = new Consulta("DELETE FROM sintagmas WHERE id_sintagma = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Sintagma eliminado correctamente.',2);
		location("Sintagmas.php");
	}
	
	public function listSintagmas()
	{
		$query = new Consulta("SELECT * FROM sintagmas");
		echo Listado::VerListado($query,"sintagmas.php","","",$this->_usuario);
	}

	function getSintagmas()
	{
		$query = new Consulta("SELECT * FROM sintagmas");
		while($row = $query->VerRegistro())
		{
			$datos[] = array(
				'id' 	 => $row['id_sintagma'],
				'nombre' => $row['nombre_sintagma'],
                                'descripcion' => $row['descripcion_sintagma']
			);	
		}
		return $datos;
	}


        
}
 ?>