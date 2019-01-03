<?php
class CategoriasBlog{
	
	private $_msgbox;
	
	public function __construct(Msgbox $msg = NULL){
		$this->_msgbox = $msg;
	}
	
	public function newCategoriasBlog(){  ?>
        <fieldset id="form">
        	<legend>Nueva Categoria Blog</legend>
        	<form action="" method="post" name="categorias_blog" enctype="multipart/form-data"> 
            	
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return valida_categorias_blog('add','')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
                    <li><label> Titulo Categoria Blog: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="titulo_categoria_blog"></li> 
                </ul>
        	</form>
        </fieldset>
		<?php
	}
	
	public function editCategoriasBlog(){		
		$obj = new CategoriaBlog($_GET['id']);		
		?>
        <fieldset id="form">
        	<legend>Editar Categoria</legend>
        	<form action="" method="post" name="categorias_blog"  enctype="multipart/form-data"> 
            	
            	<div class="button-actions">
                	<input type="submit" name="" value="ACTUALIZAR" onclick="return valida_categorias_blog('update','<?php echo $_GET['id'] ?>&ide=<?php echo $_GET['id'] ?>')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>                
                    <li><label> Titulo Categoria Blog: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="50" name="titulo_categoria_blog"  value="<?php echo $obj->__get("_titulo") ?>" ></li>
                </ul>
            	</form>
         </fieldset>
		<?php
	}
	
	public function addCategoriasBlog($cat=0){
		
		$query = new Consulta("INSERT INTO  categorias_blog 
                                        VALUES ('','".$_POST['titulo_categoria_blog']."','".$cat."','".$this->orderCategoriasBlog($cat)."')");
		
		$this->_msgbox->setMsgbox('La categoria blog se grabo correctamente.',2);
		location("publicaciones.php");
	}
	
	public function orderCategoriasBlog($parent=0){
		$query = new Consulta("SELECT MAX(orden_categoria_blog) max_orden 
									FROM categorias_blog WHERE id_parent_categoria_blog = '".$parent."'");
		
		$row   = $query->VerRegistro();
		return (int)($row['max_orden']+1);
	}
	
	public function updateCategoriasBlog($cat=0){
		
		$query = new Consulta("UPDATE categorias_blog SET 
                                            titulo_categoria_blog = '".$_POST['titulo_categoria_blog']."'
                                        WHERE id_categoria_blog = '".$_GET['id']."'");	
									
					
		$this->_msgbox->setMsgbox('La categoria blog se actualizo correctamente.',2);
		location("publicaciones.php");
	}
	
	public function deleteCategoriasBlog($cat = 0){
		$query = new Consulta("DELETE FROM  categorias_blog WHERE id_categoria_blog = '".$_GET['id']."'");

		
		$this->_msgbox->setMsgbox('La categoria blog se elimino con exito.',2);
		location("publicaciones.php");
	}
	
	function getCategoriasBlog($id = "", $id_parent = 999999){
            $retorno = array();			
			$where = $id != "" ? " id_categoria_blog = '".$id."' " : "";
            $where .= $id_parent != 999999 ? " id_parent_categoria_blog = '".$id_parent."' " : "";

            $sql = "SELECT * FROM categorias_blog WHERE ".$where. " ORDER BY orden_categoria_blog ASC";
			
            $query=new Consulta($sql);
            $retorno;
            while($row = $query->VerRegistro()){			
                $retorno[] = array(
                    'id'          =>	$row['id_parent_categoria_blog'],
                    'titulo'	  =>	$row['titulo_categoria_blog'],
                    'id1'	  =>	$row['id_parent_categoria_blog']				
                );
            }
            return $retorno;		
	}
       
        static public function getIdByNameBlog($nombre){
            $sql = "SELECT id_categoria_blog FROM categorias_blog WHERE titulo_categoria_blog = '".trim($nombre)."' ";
            $query = new Consulta($sql);
            $row = $query->VerRegistro();
            return $row['id_categoria_blog'];            
        }

}
?>