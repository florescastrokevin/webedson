<?php
class Mensajes{
	private $_msgbox;
    public function __construct($msg=''){
		$this->_msgbox = $msg;
    }
	
	public function nuevoMensajes(){		
		$tiposmsg = new TiposMensaje();
		$tipos = $tiposmsg->getTiposMensaje();
		?>
        <fieldset id="form">
        	<legend>Nuevo Mensaje</legend>
        	<form action="" method="post" name="mensajes" enctype="multipart/form-data"> 
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return valida_mensajes('add','')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
					
                    <li><label> Tipo Mensaje: </label> <select name="tipo_mensaje">
                    	<?php 
						if( count($tipos)>0 ){
							foreach($tipos as $tip){
								?>
                                <option value="<?php echo $tip['id']?>"><?php echo $tip['nombre']?></option>
                                <?php
							}
						}
						?>                        
                    </select></li>                   
                    <li><label> Descripción Mensaje: </label><textarea type="file" cols="50" rows="5"   class="text ui-widget-content ui-corner-all tinymce" name="descripcion_mensaje"></textarea>
                </ul>
        	</form>
        </fieldset>
        <?php
    }
	public function editMensajes(){		
		$mensaje = new Mensaje($_GET['id']);
		$tiposmsg = new TiposMensaje();
		$tipos = $tiposmsg->getTiposMensaje();
		?>
        <fieldset id="form">
        	<legend>Nuevo Mensaje</legend>
        	<form action="" method="post" name="mensajes" enctype="multipart/form-data"> 
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return valida_mensajes('update','<?php echo $_GET['id']?>')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
					
                    <li><label> Tipo Mensaje: </label> <select name="tipo_mensaje">
                    	<?php 
						if( count($tipos)>0 ){
							foreach($tipos as $tip){
								?>
                                <option <?php if( $mensaje->__get('_tipo')->__get('_id') ==  $tip['id']){ echo 'selected';}?>  value="<?php echo $tip['id']?>"><?php echo $tip['nombre']?></option>
                                <?php
							}
						}
						?>                        
                    </select></li>                   
                    <li><label> Descripción Mensaje: </label><textarea type="file" cols="50" rows="5"   class="text ui-widget-content ui-corner-all tinymce" name="descripcion_mensaje"><?php echo $mensaje->__get('_descripcion')?></textarea>
                </ul>
        	</form>
        </fieldset>
        <?php
    }
	public function addMensajes(){
		$query = new Consulta("INSERT INTO mensajes VALUES ('','".$_POST['tipo_mensaje']."','".$_POST['descripcion_mensaje']."','0')");		$this->_msgbox->setMsgbox('El mensaje se grabo correctamente.',2);
		location("mensajes.php");		
	}
	public function updateMensajes(){
		
		$query = new Consulta("UPDATE mensajes SET 
                                            id_tipo_mensaje = '".$_POST['tipo_mensaje']."',
											descripcion_mensaje = '".$_POST['descripcion_mensaje']."'
                                        WHERE id_mensaje = '".$_GET['id']."'");										
	;		$this->_msgbox->setMsgbox('El mensaje se se actualizo correctamente.',2);
		location("mensajes.php");		
	}
		
	public function deleteMensajes(){
		new Consulta("DELETE FROM mensajes WHERE id_mensaje = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('El mensaje se elimino correctamente.',2);
		location("mensajes.php");		
	}	
	public function listMensajes(){
		if(!isset($_GET['pag'])){$_GET['pag'] = 1;}
        $tampag = 20;
        $reg1 = ($_GET['pag'] - 1) * $tampag;
        $sql = "SELECT id_mensaje, nombre_tipo_mensaje , descripcion_mensaje FROM mensajes INNER JOIN tipos_mensajes USING (id_tipo_mensaje) ORDER BY  nombre_tipo_mensaje";
        $queryt = new Consulta($sql);
        $num = $queryt->NumeroRegistros();
        $limit = $sql_pag . " LIMIT " . $reg1 . "," . $tampag . "";
        $sql.= $limit;
        $query = new Consulta($sql);
        echo Listado::Simple($query, "mensajes.php");
	}
}
?>