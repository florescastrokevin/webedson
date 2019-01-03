<?php
class Choferes{
	private $_idioma, $_msgbox;
	
	public function __construct(Msgbox $msg = NULL){
		$this->_idioma = $idioma ;
		$this->_msgbox = $msg ;
	}
	
	public function newChoferes(){  ?>
        <fieldset id="form">
        	<legend>Nuevo Chofer</legend>
        	<form action="" method="post" name="choferes" enctype="multipart/form-data"> 
            	
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return valida_choferes('add','')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
					
                    <li><label> Nombre Chofer: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="nombre_chofer"></li>
                    <li><label> Titulo Chofer: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="titulo_chofer"></li> 
                    <li><label> Imagen Chofer: </label><input type="file" size="50"  class="text ui-widget-content ui-corner-all" name="imagen_chofer"></li>
                    <li><label> Descripción Chofer: </label><textarea type="file" cols="50" rows="5"   class="text ui-widget-content ui-corner-all" name="descripcion_chofer"></textarea>
                    <li><label> Activo: </label><input type="checkbox" id="estact" checked="" onclick="estadoactivo()"  class="text ui-widget-content ui-corner-all" name="estado"></li>
                </ul>
        
        	</form>
        </fieldset>
		<?php
	}
	
	public function editChoferes(){		
		$obj = new Chofer($_GET['id'], $this->_idioma);		
		?>
        <fieldset id="form">
        	<legend>Editar Chofer</legend>
        	<form action="" method="post" name="choferes"  enctype="multipart/form-data"> 
            	
            	<div class="button-actions">
                	<input type="submit" name="" value="ACTUALIZAR" onclick="return valida_choferes('update','<?php echo $_GET['id'] ?>&ide=<?php echo $_GET['id'] ?>')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
               	 
                    <li><label> Nombre Chofer: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="50" name="nombre_chofer"  value="<?php echo $obj->__get("_nombre") ?>" ></li>
                    <li><label> Titulo Chofer: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="50" name="titulo_chofer"  value="<?php echo $obj->__get("_titulo") ?>" ></li>
                    <li><label> Imagen Chofer: </label> <input type="file"   class="text ui-widget-content ui-corner-all" size="50" name="imagen_chofer"></li>
                    <li><label> Descripción Chofer: </label> <textarea type="file" cols="50" rows="5"  class="text ui-widget-content ui-corner-all" name="descripcion_chofer"><?php echo $obj->__get("_descripcion") ?></textarea></li>
                    <?php if($obj->__get("_estado") == '1') $est = 'checked="checked"'; else $est = ''; ?>
                    <li><label> Activo: </label><input  type="checkbox" <?= $est; ?> id="estact" onclick="estadoactivo()" class="text ui-widget-content ui-corner-all" name="estado"></li>
                </ul>
                    
                   
                
                <div align="center" class="img_chofer">
                	<img src="../aplication/utilities/img.php?imagen=<?php echo $obj->__get('_imagen') ?>&w=160&h=140" />
                </div>
            	</form>
         </fieldset>
		<?php
	}
	
	public function addChoferes($cat=0){
		if(isset($_FILES['imagen_chofer']) && ($_FILES['imagen_chofer']['name'] != "")){
			
			$obj  = new Upload();
			$destino = "../app/publicroot/imgs/catalogo/";
			
			$name = strtolower(date("ymdhis").$_FILES['imagen_chofer']['name']);
			$temp = $_FILES['imagen_chofer']['tmp_name'];
			$type = $_FILES['imagen_chofer']['type'];
			$size = $_FILES['imagen_chofer']['size'];
			
			$obj->upload_imagen($name, $temp, $destino, $type, $size);
		}
		$query = new Consulta("INSERT INTO  choferes 
                                        VALUES ('','".$_POST['nombre_chofer']."','".$_POST['titulo_chofer']."','".$_POST['descripcion_chofer']."','".$name."','".$cat."','".$this->orderChoferes($cat)."','".$_POST['estado']."')");
		
		$this->_msgbox->setMsgbox('La chofer se grabo correctamente.',2);
		location("productos.php");
	}
	
	public function orderChoferes($parent=0){
		$query = new Consulta("SELECT MAX(orden_chofer) max_orden 
									FROM choferes WHERE id_parent = '".$parent."'");
		
		$row   = $query->VerRegistro();
		return (int)($row['max_orden']+1);
	}
	
	public function updateChoferes($cat=0){
		$update = "";
		if(isset($_FILES['imagen_chofer']) && ($_FILES['imagen_chofer']['name'] != "")){
			
			$obj  = new Upload();
			$destino = "../app/publicroot/imgs/catalogo/";
			
			$name = strtolower(date("ymdhis").$_FILES['imagen_chofer']['name']);
			$temp = $_FILES['imagen_chofer']['tmp_name'];
			$type = $_FILES['imagen_chofer']['type'];
			$size = $_FILES['imagen_chofer']['size'];
			
			$obj->upload_imagen($name, $temp, $destino, $type, $size);
			$update = " imagen_chofer = '".$name."' ,";
			
		}
			
		$query = new Consulta("UPDATE choferes SET ".$update." 
                                            nombre_chofer = '".$_POST['nombre_chofer']."',
                                            titulo_chofer = '".$_POST['titulo_chofer']."',
                                            descripcion_chofer = '".$_POST['descripcion_chofer']."',
                                            estado = '".$_POST['estado']."'
                                        WHERE id_chofer = '".$_GET['id']."'");	
									
					
		$this->_msgbox->setMsgbox('La chofer se actualizo correctamente.',2);
		location("productos.php");
	}
	
	public function deleteChoferes($cat = 0){
		$query = new Consulta("DELETE FROM  choferes WHERE id_chofer = '".$_GET['id']."'");

		
		$this->_msgbox->setMsgbox('La chofer se elimino con exito.',2);
		location("productos.php");
	}
	
 

	function getChoferes(){

            $retorno = array();
            $sql = "SELECT * FROM choferes c, transportes t WHERE c.id_transporte = t.id_transporte GROUP BY c.id_chofer ORDER BY nombre_chofer";
            $query=new Consulta($sql);
            $retorno;
            while($row = $query->VerRegistro()){			
                $retorno[] = array(
                    'id'          =>	$row['id_chofer'],
                    'transporte'  =>	$row['nombre_transporte'],
                    'dni'	  =>	$row['dni_chofer'],
                    'nombre'	  =>	$row['nombre_chofer'],
                    'apellidos'	  =>	$row['apellidos_chofer'],
                    'telefono'	  =>	$row['telefono_chofer'],
                    'foto'	  =>	$row['foto_chofer']				
                );
            }
            return $retorno;		
	}

}
?>