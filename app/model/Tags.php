<?php
class tags{ 

	private $_msgbox;
	public function __construct($msg=''){
		$this->_msgbox = $msg;
		$this->_usuario = $user;
	}
	
	public function newTags(){		 

        $obj_categorias   = new Categorias($this->_msgbox);
		$array_categorias = $obj_categorias->getAllCategorias();
		
		$c = Form::select($array_categorias,"categoria","id","nombre");
		
		$matrix	= array(1 => $c);
        
		$obj_sintagmas   = new Sintagmas($this->_msgbox);
		
		$array_sintagmas = $obj_sintagmas->getSintagmas();
		
		$s = Form::select($array_sintagmas,"sintagma","id","nombre");
		
        $matrix	= array(1 => $c, 2=>$s);
		
		$query = new Consulta("SELECT id_tag, id_categoria, id_sintagma, texto_tag FROM tags");
		
		Form::getForm($query,"new","tags.php",$matrix);

	}

	

	public function addTags()

	{

            $query = new Consulta("INSERT INTO tags VALUES ('','".$_POST['id_categoria']."','".$_POST['id_sintagma']."','".$_POST['texto_tag']."','','')");

            $this->_msgbox->setMsgbox('tag grabada correctamente.',2);

            location("tags.php");

	}

	

	public function editTags()

	{       

            

            

		$tag = new tag($_GET['id']); 

		$obj_categorias   = new categorias($this->_msgbox); 

		$array_categorias = $obj_categorias->getAllCategorias();

        $c = Form::select($array_categorias,"categoria","id","nombre" ,$tag->__get('_categoria')->__get('_id'));

        $obj_sintagmas   = new Sintagmas($this->_msgbox);

		$array_sintagmas = $obj_sintagmas->getSintagmas();

        $s = Form::select($array_sintagmas,"sintagma","id","nombre" ,$tag->__get('_sintagma')->__get('_id'));

		$matrix	= array(1 => $c,2=>$s);
           

		$query = new Consulta("SELECT id_tag, id_categoria, id_sintagma, texto_tag FROM tags WHERE id_tag = '".$_GET['id']."'");

		Form::getForm($query,"edit","tags.php",$matrix);

	}

	

	public function updateTags()

	{

		$query = new Consulta("UPDATE tags SET 

                                                texto_tag    = '".$_POST['texto_tag']."', 

                                                id_categoria = '".$_POST['id_categoria']."', 

                                                id_sintagma  = '".$_POST['id_sintagma']."'

                                       WHERE id_tag = '".$_GET['id']."'");

		

		$this->_msgbox->setMsgbox('tag actualizada correctamente.',2);

		location("tags.php");

	}

	

	public function deleteTags()

	{

		$query = new Consulta("DELETE FROM tags

									WHERE id_tag = '".$_GET['id']."'");

		

		$this->_msgbox->setMsgbox('tag eliminada correctamente.',2);

		location("tags.php");

	}

	

	public function listTags()

	{

		$query = new Consulta("SELECT t.id_tag, c.nombre_categoria, s.nombre_sintagma, t.texto_tag FROM tags t, categorias c, sintagmas s 

                                    WHERE   t.id_categoria = c.id_categoria AND

                                            t.id_sintagma = s.id_sintagma

                                    ORDER BY c.nombre_categoria, t.texto_tag");

		

		echo Listado::Simple($query,"tags.php","","");

	}


	public function getTags()

	{

		$query = new Consulta("SELECT * FROM tags u ,categorias t where u.id_categoria=t.id_categoria order by 2");

		while($row = $query->VerRegistro())

		{

			$datos[] = array(

				'id' 	 => $row['id_tag'],

				'texto' => $row['texto_tag'],

				'id_categoria' => $row['id_categoria'],

				'categoria' => $row['categoria']

			);	

		}

		

		return $datos;

	}

        

        public function getTagsPorCategoria($id_categoria){
		
			// Como se le agrego una categoria mas a productos
			// llamo a una categoria anterior para que no se pierdan los tags
			$obj_cat_tmp = new Categoria($id_categoria);
			$id_categoria = $obj_cat_tmp->__get('_parent');
		
		$query = new Consulta("SELECT * FROM tags u ,categorias t where u.id_categoria=t.id_categoria AND t.id_categoria = '".$id_categoria."' order by 2");

		while($row = $query->VerRegistro()){

			$datos[] = array(

				'id' 	 => $row['id_tag'],

				'texto' => $row['texto_tag'],

				'id_categoria' => $row['id_categoria'],

				'categoria' => $row['categoria']

			);	

		}

		

		return $datos;

	}

        

        public function getTagsGenericos()

	{

		$query = new Consulta("SELECT * FROM tags  where id_categoria = '0' ");

		while($row = $query->VerRegistro())

		{

			$datos[] = array(

				'id' 	 => $row['id_tag'],

				'texto' => $row['texto_tag'],

				'id_categoria' => $row['id_categoria'],

				'categoria' => $row['categoria']

			);	

                        

		}

		

		return $datos;

	}

	

}

 ?>