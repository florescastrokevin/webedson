<?php
class Categorias{
	private $_idioma, $_msgbox;
	
	public function __construct(Msgbox $msg = NULL){
		$this->_idioma = $idioma ;
		$this->_msgbox = $msg ;
	}
	
	public function newCategorias(){  ?>
        <fieldset id="form">
        	<legend>Nueva Categoria</legend>
        	<form action="" method="post" name="categorias" enctype="multipart/form-data"> 
            	
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return valida_categorias('add','')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
					
                    <li><label> Nombre Categoria: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="nombre_categoria"></li>
                    <li><label> Titulo Categoria: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="titulo_categoria"></li> 
                    <li><label> Imagen Categoria: </label><input type="file" size="50"  class="text ui-widget-content ui-corner-all" name="imagen_categoria"></li>
                    <li><label> Descripción Categoria: </label><textarea type="file" cols="50" rows="5"   class="text ui-widget-content ui-corner-all" name="descripcion_categoria"></textarea>
                    <li><label> Activo: </label><input type="checkbox" id="estact" checked="" onclick="estadoactivo()"  class="text ui-widget-content ui-corner-all" name="estado"></li>
                </ul>
        
        	</form>
        </fieldset>
		<?php
	}
	
	public function editCategorias(){		
		$obj = new Categoria($_GET['id'], $this->_idioma);		
		?>
        <fieldset id="form">
        	<legend>Editar Categoria</legend>
        	<form action="" method="post" name="categorias"  enctype="multipart/form-data"> 
            	
            	<div class="button-actions">
                	<input type="submit" name="" value="ACTUALIZAR" onclick="return valida_categorias('update','<?php echo $_GET['id'] ?>&ide=<?php echo $_GET['id'] ?>')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
                    <li><label> Nombre Categoria: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="50" name="nombre_categoria"  value="<?php echo $obj->__get("_nombre") ?>" ></li>
                    <li><label> Titulo Categoria: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="50" name="titulo_categoria"  value="<?php echo $obj->__get("_titulo") ?>" ></li>
                    <li><label> Imagen Categoria: </label> <input type="file"   class="text ui-widget-content ui-corner-all" size="50" name="imagen_categoria"></li>
                    <li><label> Descripción Categoria: </label> <textarea type="file" cols="50" rows="5"  class="text ui-widget-content ui-corner-all" name="descripcion_categoria"><?php echo $obj->__get("_descripcion") ?></textarea></li>
                    <?php if($obj->__get("_estado") == '1') $est = 'checked="checked"'; else $est = ''; ?>
                    <li><label> Activo: </label><input  type="checkbox" <?= $est; ?> id="estact" onclick="estadoactivo()" class="text ui-widget-content ui-corner-all" name="estado"></li>
                </ul>

                
                <div align="center" class="img_categoria">
                	<img src="../aplication/utilities/img.php?imagen=<?php echo $obj->__get('_imagen') ?>&w=160&h=140" />
                </div>
            	</form>
         </fieldset>
		<?php
	}
	
	public function addCategorias($cat=0){
		if(isset($_FILES['imagen_categoria']) && ($_FILES['imagen_categoria']['name'] != "")){
			
			$obj  = new Upload();
			$destino = "../app/publicroot/imgs/catalogo/";
			
			$name = strtolower(date("ymdhis").$_FILES['imagen_categoria']['name']);
			$temp = $_FILES['imagen_categoria']['tmp_name'];
			$type = $_FILES['imagen_categoria']['type'];
			$size = $_FILES['imagen_categoria']['size'];
			
			$obj->upload_imagen($name, $temp, $destino, $type, $size);
		}
		$query = new Consulta("INSERT INTO  categorias 
                                        VALUES ('','".$_POST['nombre_categoria']."','".$_POST['titulo_categoria']."','".$_POST['descripcion_categoria']."','".$name."','".$cat."','".$this->orderCategorias($cat)."','".$_POST['estado']."')");
		
		$this->_msgbox->setMsgbox('La categoria se grabo correctamente.',2);
		location("productos.php");
	}
	
	public function orderCategorias($parent=0){
		$query = new Consulta("SELECT MAX(orden_categoria) max_orden 
									FROM categorias WHERE id_parent = '".$parent."'");
		
		$row   = $query->VerRegistro();
		return (int)($row['max_orden']+1);
	}
	
	public function updateCategorias($cat=0){
		$update = "";
		if(isset($_FILES['imagen_categoria']) && ($_FILES['imagen_categoria']['name'] != "")){
			
			$obj  = new Upload();
			$destino = "../app/publicroot/imgs/catalogo/";
			
			$name = strtolower(date("ymdhis").$_FILES['imagen_categoria']['name']);
			$temp = $_FILES['imagen_categoria']['tmp_name'];
			$type = $_FILES['imagen_categoria']['type'];
			$size = $_FILES['imagen_categoria']['size'];
			
			$obj->upload_imagen($name, $temp, $destino, $type, $size);
			$update = " imagen_categoria = '".$name."' ,";
			
		}
			
		$query = new Consulta("UPDATE categorias SET ".$update." 
                                            nombre_categoria = '".$_POST['nombre_categoria']."',
                                            titulo_categoria = '".$_POST['titulo_categoria']."',
                                            descripcion_categoria = '".$_POST['descripcion_categoria']."',
                                            estado = '".$_POST['estado']."'
                                        WHERE id_categoria = '".$_GET['id']."'");	
									
					
		$this->_msgbox->setMsgbox('La categoria se actualizo correctamente.',2);
		location("productos.php");
	}
	
	public function deleteCategorias($cat = 0){
		$query = new Consulta("DELETE FROM  categorias WHERE id_categoria = '".$_GET['id']."'");

		
		$this->_msgbox->setMsgbox('La categoria se elimino con exito.',2);
		location("productos.php");
	}
	
	public function getCategoriaXCriterio($cad){
		$sql = "SELECT * FROM categorias WHERE nombre_categoria LIKE '%$cad%'";
					
		$query = new Consulta($sql);
		$data;
		while($row = $query->VerRegistro()){
			$data[] = array(
				'id'		=> $row['id_categoria'],
				'value' 	=> $row['nombre_categoria']
			);
		}
		return $data;
	}
	
	
	
	function verificaCodigoCategorias($cod = ''){
		$query = new Consulta("SELECT * FROM categorias WHERE codigo_categoria = '".$cod."' AND codigo_categoria <> '' ");
		if($query->NumeroRegistros() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function getCategorias($id = "", $id_parent = 999999){

            $retorno = array();
			
			$where = $id != "" ? " AND id_categoria = '".$id."' " : "";
            $where .= $id_parent != 999999 ? " AND id_parent = '".$id_parent."' " : "";
//categoria 2, es desayunos
            $sql = "SELECT * FROM categorias WHERE estado = '1'  ".$where. " ORDER BY orden_categoria ASC";
			
            $query=new Consulta($sql);
            $retorno;
            while($row = $query->VerRegistro()){			
                $retorno[] = array(
                    'id'          =>	$row['id_categoria'],
                    'nombre'	  =>	$row['nombre_categoria'],
                    'titulo'	  =>	$row['titulo_categoria'],
                    'imagen'	  =>	$row['imagen_categoria'],
                    'id1'	  	  =>	$row['id_parent']				
                );
            }
            return $retorno;		
	}
        
        function getAllCategorias(){
 

            $sql = "SELECT * FROM categorias ORDER BY orden_categoria ASC";

            $query=new Consulta($sql);
            $retorno;
            while($row = $query->VerRegistro()){			
                $retorno[] = array(
                    'id'          =>	$row['id_categoria'],
                    'nombre'	  =>	$row['nombre_categoria'],
                    'titulo'	  =>	$row['titulo_categoria'],
                    'imagen'	  =>	$row['imagen_categoria'],
                    'id1'	  	  =>	$row['id_parent']				
                );
            }
            return $retorno;		
	}
        
    static public function getIdByName($nombre){
        $sql = "SELECT id_categoria FROM categorias WHERE nombre_categoria = '".trim($nombre)."' ";
        $query = new Consulta($sql);
        $row = $query->VerRegistro();
        return $row['id_categoria'];            
    }

    static public function getCategoriasForTree($id = "", $id_parent){

            $retorno = array();
			
            $where = $id_parent != 999999 ? " WHERE id_parent = '".$id_parent."' " : "";
			$where .= $id != "" ? " AND id_categoria = '".$id."' " : "";

            $sql = "SELECT * FROM categorias ".$where. " ORDER BY orden_categoria ASC";
			
            $query=new Consulta($sql);
            $retorno;
            while($row = $query->VerRegistro()){			
                $retorno[] = array(
                    'id'          =>	$row['id_categoria'],
                    'nombre'	  =>	$row['nombre_categoria'],
                    'titulo'	  =>	$row['titulo_categoria'],
                    'imagen'	  =>	$row['imagen_categoria'],
                    'id1'	  	  =>	$row['id_parent']				
                );
            }
            return $retorno;		
	}

    static public function treeCategorias()
    {
    	$lista_categorias = Categorias::getCategoriasForTree('',0);
    	foreach ($lista_categorias as $cate) {
    		$obj_cate = new Categoria($cate['id']);
    		$lista_subcategorias = Categorias::getCategoriasForTree('',$obj_cate->__get('_id'));
    		?>
    		<ul>
                <li data-jstree='{"opened":true <?php echo (!$lista_subcategorias)?',"icon" : "fas fa-folder fa-lg"':'' ?>}'  identifica="<?php echo $obj_cate->__get('_id') ?>">
                    <?php echo $obj_cate->__get('_nombre') ?>

                    <?php if ($lista_subcategorias): ?>	
                    <ul>
					    <?php foreach ($lista_subcategorias as $subcat): ?>
					    <?php $obj_sub_cat = new Categoria($subcat['id']) ?>
					    	<li data-jstree='{ "icon" : "fas fa-arrow-right fa-lg text-info" }' identifica="<?php echo $obj_sub_cat->__get('_id') ?>">
					    		<?php echo $obj_sub_cat->__get('_nombre') ?>
					    	</li>
					    <?php endforeach ?>
					</ul>
                    <?php endif ?>

                </li>
            </ul>
    		<?php
    	}
    }
    static public function editCategoriaData()
    {
    	if ($_POST['id']) {
	    	$obj_cate = new Categoria($_POST['id']);
	    	?>
	    	<?php if ($obj_cate->__get('_parent')==0): ?>
    		<button class="btn btn-xs btn-success m-b-10" onclick="modalNewCategoria(<?php echo $obj_cate->__get('_id') ?>)">Nueva Sub-Categoria &nbsp;&nbsp;&nbsp;<i class="fas fa-plus"></i></button>
	    	<?php endif ?>
	    	<form id="edit-categoria" method="post">
	    		<input type="hidden" value="<?php echo $obj_cate->__get('_id') ?>" name="update_id"> 
	            <div class="form-group row m-b-15">
	                <label class="col-form-label col-md-3">Nombre</label>
	                <div class="col-md-9">
	                    <input type="text" name="update_nombre" class="form-control" placeholder="" value="<?php echo $obj_cate->__get('_nombre') ?>" />
	                </div>
	            </div>
	            <div class="form-group row m-b-15">
	                <label class="col-form-label col-md-3">Titulo</label>
	                <div class="col-md-9">
	                    <input type="text" name="update_titulo" class="form-control" placeholder="" value="<?php echo $obj_cate->__get('_titulo') ?>" />
	                </div>
	            </div>
	            <div class="form-group row m-b-15">
	                <label class="col-form-label col-md-3">Descripción</label>
	                <div class="col-md-9">
	                    <textarea type="text" name="update_descripcion" class="form-control" rows="7"><?php echo $obj_cate->__get('_descripcion') ?></textarea>
	                </div>
	            </div>
	            <div class="form-group row m-b-15">
	                <label class="col-form-label col-md-3">Url</label>
	                <div class="col-md-9">
	                    <input type="text" name="update_url" class="form-control" placeholder="" value="<?php echo $obj_cate->__get('_url') ?>" />
	                </div>
	            </div>
	            <div class="form-group row m-b-10">
	                <label class="col-md-3 col-form-label">Activo</label>
	                <div class="col-md-9 p-t-3">
	                    <div class="switcher switcher-success">
	                        <input type="checkbox" name="update_activo" id="update_activo" <?php echo ($obj_cate->__get('_estado')==1)? 'checked=""':'' ?> value="1">
	                        <label for="update_activo"></label>
	                    </div>
	                </div>
	            </div>
	            <a class="btn btn-green text-white" onclick="updateCategoria()">Actualizar</a>
	        </form>
        <?php }
    }
    static public function updateCategoriaTree()
    {
    	$sql="UPDATE categorias SET 
    	nombre_categoria = '".$_POST['nombre']."', 
    	titulo_categoria = '".$_POST['titulo']."', 
    	descripcion_categoria = '".$_POST['descripcion']."',
    	url_categoria = '".$_POST['url']."',
    	estado = ".$_POST['activo']." WHERE id_categoria = ".$_POST['id']."  ";
    	$query=new Consulta($sql);
    }
    static public function saveCategoriaTree()
    {
    	$sql="INSERT INTO categorias (nombre_categoria, titulo_categoria, descripcion_categoria, estado, id_parent) VALUES('".$_POST['nombre']."', '".$_POST['titulo']."', '".$_POST['descripcion']."', ".$_POST['activo'].", ".$_POST['parent'].") ";
    	$query=new Consulta($sql);
    }
}
?>