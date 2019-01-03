<?php

require_once(_model_."Ocasion.php");

class Ocasiones 
{
	private $_msgbox;
	
	public function __construct($msg='')
	{
		$this->_msgbox = $msg;
		$this->_usuario = $user;
	}
	
	public function newOcasiones()
	{
		$query = new Consulta("SELECT * FROM ocasiones");
		Form::getForm($query,"new","ocasiones.php");
	}
	
	public function addOcasiones()
	{
		$query = new Consulta("INSERT INTO ocasiones VALUES ('','".$_POST['nombre_ocasion']."','".$_POST['descripcion_ocasion']."','','')");
		$this->_msgbox->setMsgbox('Ocasion grabado correctamente.',2);
		location("ocasiones.php");
	}
	
	public function editOcasiones()
	{
		$query = new Consulta("SELECT * FROM ocasiones WHERE id_ocasion = '".$_GET['id']."'");
		Form::getForm($query,"edit","ocasiones.php");
	}
	
	public function updateOcasiones()
	{
		$query = new Consulta("UPDATE ocasiones 
                                        SET nombre_ocasion = '".$_POST['nombre_ocasion']."',
                                            descripcion_ocasion = '".$_POST['descripcion_ocasion']."'
                                        WHERE id_ocasion = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Ocasion actualizado correctamente.',2);
		location("ocasiones.php");
	}
	
	public function deleteOcasiones()
	{
		$query = new Consulta("DELETE FROM ocasiones WHERE id_ocasion = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Ocasion eliminado correctamente.',2);
		location("ocasiones.php");
	}
	
	public function listOcasiones()
	{
		$query = new Consulta("SELECT * FROM ocasiones");
		echo Listado::Simple($query,"ocasiones.php","","",$this->_usuario);
	}
	
	
	public function getOcasionesByCat( $id_cat ){		
		
		if(empty($id_cat)){
			return $datos;
		}
		//$sql = "SELECT * FROM productos_ocasiones INNER JOIN ocasiones USING(id_ocasion) WHERE id_categoria IN (".$ids_cats.") GROUP BY id_ocasion";		
		$sql = "SELECT * FROM productos INNER JOIN productos_ocasiones USING(id_producto) INNER JOIN ocasiones USING(id_ocasion) WHERE productos.id_categoria='".$id_cat."'";
		//echo $sql;
		
		$query = new Consulta($sql);
		while($row = $query->VerRegistro()){
			$datos[] = array(
				'id' 	 => $row['id_ocasion'],
				'nombre' => $row['nombre_ocasion'],
				'descripcion' => $row['descripcion_ocasion']
			);	
		}		
		return $datos;
	}
	
	public function getOcasionesByCatRec($idcat){
		$datoss = array();
		$sql = "SELECT * FROM productos
				INNER JOIN productos_ocasiones USING(id_producto)
				INNER JOIN ocasiones USING(id_ocasion)
				WHERE productos.id_categoria='".$idcat."' GROUP BY id_ocasion";
		$query = new Consulta($sql);
		if($query->NumeroRegistros()==0){
			$datos = array();
			$query2 = new Consulta("SELECT id_categoria FROM categorias WHERE id_parent='".$idcat."'");
			while($row = $query2->VerRegistro()){
				$datos = array_merge($datos,$this->getOcasionesByCatRec($row['id_categoria']));
			}
			return $datos;
		}else{
			while($row = $query->VerRegistro()){
				$datoss[] = array(
					'id' 	 => $row['id_ocasion'],
					'nombre' => $row['nombre_ocasion'],
					'descripcion' => $row['descripcion_ocasion']
				);	
			}
			return $datoss;
		}
	}
	
	
	public function getOcasiones()
	{
		$query = new Consulta("SELECT * FROM ocasiones ORDER BY orden_ocasion ASC");
		while($row = $query->VerRegistro())
		{
			$datos[] = array(
				'id' 	 => $row['id_ocasion'],
				'nombre' => $row['nombre_ocasion'],
				'descripcion' => $row['descripcion_ocasion']
			);	
		}
		
		return $datos;
	}

	static public function treeOcasiones()
	{
		$query = new Consulta("SELECT * FROM ocasiones ORDER BY orden_ocasion ASC");
		while($row = $query->VerRegistro())
		{
			$datos[] = array(
				'id' 	 => $row['id_ocasion'],
				'nombre' => $row['nombre_ocasion'],
				'descripcion' => $row['descripcion_ocasion']
			);	
			?>
			<ul>
	            <li data-jstree='{"opened":true ,"icon" : "fas fa-star text-yellow-lighter fa-lg"}'  identifica="<?php echo $row['id_ocasion'] ?>">
	                <?php echo $row['nombre_ocasion'] ?>
	            </li>
	        </ul>
	        <?php
		}
	}

	static public function editOcasionData()
    {
    	if ($_POST['id']) {
	    	$obj_oca = new Ocasion($_POST['id']);
	    	?>
	    	<form id="edit-ocasion" method="post">
	    		<input type="hidden" value="<?php echo $obj_oca->__get('_id') ?>" name="update_id"> 
	            <div class="form-group row m-b-15">
	                <label class="col-form-label col-md-3">Nombre</label>
	                <div class="col-md-9">
	                    <input type="text" name="update_nombre" class="form-control" placeholder="" value="<?php echo $obj_oca->__get('_nombre') ?>" />
	                </div>
	            </div>
	            <div class="form-group row m-b-15">
	                <label class="col-form-label col-md-3">Url</label>
	                <div class="col-md-9">
	                    <input type="text" name="update_url" class="form-control" placeholder="" value="<?php echo $obj_oca->__get('_url') ?>" />
	                </div>
	            </div>
	            <div class="form-group row m-b-15">
	                <label class="col-form-label col-md-3">Descripción</label>
	                <div class="col-md-9">
	                    <textarea type="text" name="update_descripcion" class="form-control" rows="7"><?php echo $obj_oca->__get('_descripcion') ?></textarea>
	                </div>
	            </div>
	            <a class="btn btn-green text-white" onclick="updateOcasion()">Actualizar</a>
	        </form>
        <?php }
    }
    static public function updateOcasionTree()
    {
    	$sql="UPDATE ocasiones SET 
    	nombre_ocasion = '".$_POST['nombre']."', 
    	url_ocasion = '".$_POST['url']."', 
    	descripcion_ocasion = '".$_POST['descripcion']."'
    	WHERE id_ocasion = ".$_POST['id']."  ";
    	$query=new Consulta($sql);
    }
    static public function saveOcasionTree()
    {
    	$sql="INSERT INTO ocasiones (nombre_ocasion, url_ocasion, descripcion_ocasion) VALUES('".$_POST['nombre']."', '".$_POST['url']."', '".$_POST['descripcion']."') ";
    	$query=new Consulta($sql);
    }
        
}
 ?>