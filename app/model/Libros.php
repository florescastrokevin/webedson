<?php
class Libros
{
	private $_msgbox;
	
	public function __construct($msg='',Usuario $user)
	{
		$this->_msgbox = $msg;
		$this->_usuario = $user;
	}
	
	public function newLibros()
	{
		$query = new Consulta("SELECT * FROM libros");
		
		Form::getForm($query,"new","libros.php");
	}
	
	public function addLibros()
	{
		$query = new Consulta("INSERT INTO libros VALUES ('','".$_POST['titulo_libro']."')");
		
		$this->_msgbox->setMsgbox('Libro grabado correctamente.',2);
		location("libros.php");
	}
	
	public function editLibros()
	{
		$query = new Consulta("SELECT * FROM libros WHERE id_libro = '".$_GET['id']."'");
		
		Form::getForm($query,"edit","libros.php");
	}
	
	public function updateLibros()
	{
		$query = new Consulta("UPDATE libros SET titulo_libro = '".$_POST['titulo_libro']."'
									WHERE id_libro = '".$_GET['id']."'");
		
		$this->_msgbox->setMsgbox('Libro actualizado correctamente.',2);
		location("libros.php");
	}
	
	public function deleteLibros()
	{
		$query = new Consulta("DELETE FROM libros
									WHERE id_libro = '".$_GET['id']."'");
		
		$this->_msgbox->setMsgbox('Libro eliminado correctamente.',2);
		location("libros.php");
	}
	
	public function listLibros()
	{
		$query = new Consulta("SELECT * FROM libros");
		
		
		echo Listado::VerListado($query,"libros.php","","",$this->_usuario);
	}

	function getLibros()
	{
		$query = new Consulta("SELECT * FROM libros");
		while($row = $query->VerRegistro())
		{
			$datos[] = array(
				'id' 	 => $row['id_libro'],
				'titulo' => $row['titulo_libro']
			);	
		}
		return $datos;
	}


        
}
 ?>