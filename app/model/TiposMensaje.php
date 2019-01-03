<?php
class TiposMensaje{
	private $_msgbox;
    public function __construct($msg=''){
		$this->_msgbox = $msg;
    }
	public function nuevoTiposMensaje(){	
		?>
        <fieldset id="form">
        	<legend>Nuevo Tipo Mensaje</legend>
        	<form action="" method="post" name="mensajes" enctype="multipart/form-data"> 
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return valida_tipo_mensajes('add','')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
					<li><label> Nombre Tipo Mensaje: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="nombre_tipo_mensaje"></li>
                </ul>
        	</form>
        </fieldset>
        <?php
    }
	public function editTiposMensaje(){	
		$tipom = new TipoMensaje($_GET['id']);		
		?>
        <fieldset id="form">
        	<legend>Editar Tipo Mensaje</legend>
        	<form action="" method="post" name="mensajes" enctype="multipart/form-data"> 
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return valida_tipo_mensajes('update','<?php echo $_GET['id'] ?>')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
					<li><label> Nombre Tipo Mensaje: </label> <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="nombre_tipo_mensaje" value="<?php echo $tipom->__get("_nombre")?>"></li>
                </ul>
        	</form>
        </fieldset>
        <?php
    }
	public function addTiposMensaje(){
		$query = new Consulta("INSERT INTO tipos_mensajes VALUES ('','".$_POST['nombre_tipo_mensaje']."','0')");		
		$this->_msgbox->setMsgbox('El tipo de mensaje se grabo correctamente.',2);
		location("tiposmensaje.php");		
	}
	public function updateTiposMensaje(){
		$query = new Consulta("UPDATE tipos_mensajes SET 
                                            nombre_tipo_mensaje = '".$_POST['nombre_tipo_mensaje']."'
                                        WHERE id_tipo_mensaje = '".$_GET['id']."'");	
									
					
		$this->_msgbox->setMsgbox('El tipo de mensaje se actualizo correctamente.',2);
		location("tiposmensaje.php");
	}	
	static public function getTiposMensaje(){
		$sql = "SELECT * FROM tipos_mensajes ORDER BY orden_tipo_mensaje ASC";
		$query = new Consulta($sql);
		$data;
		while($row = $query->VerRegistro()){
			$data[] = array(
				'id'		=> $row['id_tipo_mensaje'],
				'nombre' 	=> $row['nombre_tipo_mensaje']
			);
		}
		return $data;
	}	
	public function deleteTiposMensaje(){
		new Consulta("DELETE FROM tipos_mensajes WHERE id_tipo_mensaje = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('El tipo de mensaje se elimino correctamente.',2);
		location("tiposmensaje.php");		
	}	
	public function listTiposMensaje(){
		if(!isset($_GET['pag'])){$_GET['pag'] = 1;}
        $tampag = 20;
        $reg1 = ($_GET['pag'] - 1) * $tampag;
        $sql = "SELECT id_tipo_mensaje, nombre_tipo_mensaje FROM tipos_mensajes ";
        $queryt = new Consulta($sql);
        $num = $queryt->NumeroRegistros();
        $limit = $sql_pag . " LIMIT " . $reg1 . "," . $tampag . "";
        $sql.= $limit;
        $query = new Consulta($sql);
        echo Listado::Simple($query, "tiposmensaje.php");
	}
	
}