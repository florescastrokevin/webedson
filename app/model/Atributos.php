<?php 
class Atributos{
		
	private $_msgbox;
	private $_usuario;
	
	public function __construct(Msgbox $msg = NULL, Usuario $user = NULL)
	{
		$this->_msgbox = $msg;
		$this->_usuario = $user;		
	}
	
	public function newAtributos(){
		$query = new Consulta("SELECT * FROM atributos");
		Form::getForm($query, "new", "atributos.php");
	} 	
		
	
	public function addAtributos() {
		 $query = new Consulta("INSERT INTO atributos VALUES('','" . $_POST['nombre_atributo']."')");
		 $this->_msgbox->setMsgbox('Se grabo correctamente el Atributo.',2);	
         location("atributos.php");
    }
		
		
	public function editAtributos(){
		$query = new Consulta("SELECT * FROM atributos WHERE id_atributo = '".$_GET['id']."'");
		Form::getForm($query, "edit", "atributos.php");
	} 
	
    public function updateAtributos() {
		$query = new Consulta("UPDATE atributos SET nombre_atributo='" . $_POST['nombre_atributo'] . "'
                                     	        WHERE id_atributo = '" . $_GET['id'] . "'");
          
		$this->_msgbox->setMsgbox('Se actualizo correctamente el Atributo.',2);	
        location("atributos.php");
    }
	
	public function deleteAtributos(){
		$query = new Consulta("DELETE FROM atributos WHERE id_atributo = '" . $_GET['id'] . "'");
		$this->_msgbox->setMsgbox('Se elimino correctamente el Atributo.',2);	
        location("atributos.php");
	}
	
	public function listAtributos(){
		$query = new Consulta("SELECT id_atributo, nombre_atributo FROM atributos ");  
		?>
         <div id="content-area">
            <table cellspacing="1" cellpading="1" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left">Atributos</th>
                        <th align="center" width="100" class="titulo">Opciones</th>
                   </tr>
                </thead>
            </table>	
            <ul id="listadoul">
			 <?php
			 $y = 1;
				while($rowa = $query->VerRegistro()){
					?>
					 <li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="list_item_<?php echo $rowa['id_atributo']."|attr"; ?>">
						<div class="data"> <img src="<?php echo _admin_ ?>folder.png" class="handle">   <?php echo $rowa['nombre_atributo'] ?></div>
						<div class="options"> 
							
							<a title="Editar" class="tooltip" href="#" onclick="mantenimiento('atributos.php','<?php echo $rowa['id_atributo'] ?>','edit')">
							<img src="<?php echo _admin_ ?>edit.png"></a> &nbsp;
                            <a title="Eliminar" class="tooltip" onClick="mantenimiento('atributos.php','<?php echo $rowa['id_atributo'] ?>','delete')"  href="#"> <img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;
                           <a title="Ver Valores" class="tooltip"
                           href="#"
                      onclick="mantenimiento_det('atributos.php?action=listValores','<?php echo $rowa['id_atributo']?>')" 
                           
                           ><img src="<?php echo _icons_ ?>zoom.png"></a>&nbsp;
                            </div>
						 </li>
				<?php
					$y++;
					}
	} 
	
	public function getNombre( $id ){	
		$query = new Consulta(" SELECT * FROM atributos WHERE id_atributo = '".$id."'");
		$row = $query->VerRegistro();
		$nombre = $row['nombre_atributo'];
		return $nombre;	
	}
	
	public function IdMax(){		
		$query = new Consulta(" SELECT MAX(id_atributo) FROM atributos ");
		$row = $query->VerRegistro();
		$id = $row['MAX(id_atributo)'];	
		return $id;	
	}
	
	public function getAtributos(){
		$sql   = " SELECT * FROM atributos";
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$datos[] = array(
				'id' 		=> $row['id_atributo'],
				'nombre' 	=> $row['nombre_atributo']
			);
		}
		return $datos;	
	} 
	
	/*
	 *
	 *  ATRIBUTOS VALORES
	 *
	 */
	
	
	
	
	public function newValoresAtributos(){
		?>        
        <fieldset id="form">
        	<legend>Nuevo Registro</legend>
        	<form action="" method="post" name="valores_atributos" enctype="multipart/form-data"> 
            	
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return valida_valores_atributos('addValores','<?php echo $_GET['id1']?>')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
                    <li><label>Nombre del Valor: </label>
                    <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="nombre_valor_atributo"></li>
                    
                    <li><label>Imagen del Valor: </label>
                    <input type="file" class="text ui-widget-content ui-corner-all" size="59" name="imagen_atributo_valo"></li>
                    
                </ul>
        	</form>
        </fieldset>        
        <?php		
	} 	
		
	
	public function addValoresAtributos() {
		
		 if(isset($_FILES['imagen_atributo_valor']) && $_FILES['imagen_atributo_valor']['name'] != "" ){	
		 
		 
		 define("NAMETHUMB", "/tmp/thumbtemp");				
		$ext = explode('.',$_FILES['imagen_atributo_valor']['name']);
		$nombre_file = time().sef_string($ext[0]);
		$type_file = typeImage($_FILES['imagen_atributo_valor']['type']);				
		$nombre = $nombre_file . $type_file;
		 
    	 $thumbnail = new ThumbnailBlobFile($_FILES['imagen_atributo_valor'],NAMETHUMB,'../app/publicroot/imgs/catalogo/cpmtos_');
		 $thumbnail->setQuality(100);
		 $thumbnail->CreateThumbnail(80,80,$nombre);
		
		 $query = new Consulta("INSERT INTO atributos_valores VALUES('','".$_GET['id1']."','".$_POST['nombre_valor_atributo']."','cpmtos_".$nombre."')");
		 
		 }
		 $this->_msgbox->setMsgbox('Se grabo correctamente el Valor para este Atributo.',2);
		 location($_SERVER['PHP_SELF']."?action=listValores&id1=".$_GET['id1']);
    }	
		
	public function editValoresAtributos(){
		$av = new AtributoValor($_GET['id2']);
		?>        
        <fieldset id="form">
        	<legend>Nuevo Registro</legend>
        	<form action="" method="post" name="valores_atributos" enctype="multipart/form-data"> 
            	
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return valida_valores_atributos('updateValores','<?php echo $_GET['id1'] ."&id2=".$_GET['id2'] ?>')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
                    <li><label>Nombre del Valor: </label>
                    <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="nombre_valor_atributo" value="<?php echo $av->__get("_valor_atributo_valor")?>"></li>
                    
                    
                    <li><label>Imagen del Valor: </label>
                    <input type="file" class="text ui-widget-content ui-corner-all" size="59" name="imagen_atributo_valor"></li>
                    
                    <?php if( $av->__get("_imagen_atributo_valor") != "" ){?>
					<div align='center'><br>
                    	<img src="../aplication/utilities/img.php?imagen=<?php echo $av->__get("_imagen_atributo_valor")?>&w=200&h=120">
                    </div>
					<?php }?>
                    
                </ul>
        	</form>
        </fieldset>        
        <?php
	} 
	
    public function updateValoresAtributos() {
		
		if(isset($_FILES['imagen_atributo_valor']) && $_FILES['imagen_atributo_valor']['name'] != "" ){	
		 
		define("NAMETHUMB", "/tmp/thumbtemp");				
		$ext = explode('.',$_FILES['imagen_atributo_valor']['name']);
		$nombre_file = time().sef_string($ext[0]);
		$type_file = typeImage($_FILES['imagen_atributo_valor']['type']);				
		$nombre = $nombre_file . $type_file;
		 
    	 $thumbnail = new ThumbnailBlobFile($_FILES['imagen_atributo_valor'],NAMETHUMB,'../app/publicroot/imgs/catalogo/cpmtos_');
		 $thumbnail->setQuality(100);
		 $thumbnail->CreateThumbnail(80,80,$nombre);		 
		 $update = ", imagen_atributo_valor='cpmtos_".$nombre."'";			 
		 }
		
		$query = new Consulta("UPDATE atributos_valores SET id_atributo='" . $_GET['id1'] . "',
			                                                    valor_atributo_valor='" . $_POST['nombre_valor_atributo']."'
																".$update."
                                     	                    WHERE id_atributo_valor = '" . $_GET['id2'] . "'");
		$this->_msgbox->setMsgbox('Se actualizo correctamente el Valor para este Atributo.',2);	
		location($_SERVER['PHP_SELF']."?action=listValores&id1=".$_GET['id1']);
	 }
	
	
	public function deleteValoresAtributos(){	
		
		$atributo_valor = new AtributoValor($_GET['id1']);
		$id_atributo = $atributo_valor->__get("_id_atributo");
		$query = new Consulta("DELETE FROM productos_atributos WHERE id_atributo = '".$_GET['id']."'");
		$query = new Consulta("DELETE FROM atributos_valores WHERE id_atributo_valor = '" . $_GET['id1'] . "'");
		
		$this->_msgbox->setMsgbox('Se elimino correctamente el Valor de este Atributo.',2);					
		location($_SERVER['PHP_SELF']."?action=listValores&id1=".$_GET['id']);
	}
	
	public function listValoresAtributos(){
      
		$query = new Consulta("SELECT  id_atributo_valor,valor_atributo_valor FROM atributos_valores av WHERE id_atributo='".$_GET['id1']."'");  
		?>
         <div id="content-area">
            <table cellspacing="1" cellpading="1" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left">Atributos</th>
                        <th align="center" width="100" class="titulo">Opciones</th>
                   </tr>
                </thead>
            </table>	
            <ul id="listadoul">
			 <?php
			 $y = 1;
				while($rowa = $query->VerRegistro()){
					?>
					 <li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="list_item_<?php echo $rowa['id_atributo_valor']."|attrv"; ?>">
						<div class="data"> <img src="<?php echo _admin_ ?>file.png" class="handle">   <?php echo $rowa['valor_atributo_valor'] ?></div>
						<div class="options">                             
							<a title="Editar" class="tooltip" href="<?php $_SERVER['PHP_SELF']?>?action=editValores&id1=<?php echo $_GET['id1']?>&id2=<?php echo $rowa['id_atributo_valor']?>">
							<img src="<?php echo _admin_ ?>edit.png"></a> &nbsp;
							<a title="Eliminar" class="tooltip" onClick="mantenimiento('atributos.php','<?php echo $_GET['id1'] ?>&id1=<?php echo $rowa['id_atributo_valor']?>','deleteValores')"  href="#"> <img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;
                        
                            </div>
						 </li>
				<?php
					$y++;
					}	
		
	} 
	
	
	
	public function getAtributosValores(){
		$sql   = " SELECT * FROM atributos_valores";
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$datos[] = array(
				'id' 		=> $row['id_atributo_valor'],
				'nombre' 	=> $row['valor_atributo_valor']
			);
		}
		return $datos;	
	} 
	
	
}
?>