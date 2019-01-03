<?php 
class Insumos{
    private $_msgbox;
    public function __construct($msg='')
    {
		$this->_msgbox = $msg;
    }

    public function nuevoInsumos(){
		?>
        <script type="text/javascript">			
		function valida_id_proveedor(){ 					
			if(document.id_proveedornew.id_proveedor.value==""){
				alert('ERROR: El campo  proveedor debe llenarse');
				document.id_proveedornew.id_proveedor.focus(); 
				return false;
			}						
								
			if(document.id_proveedornew.id_tipo_insumo.value==""){
				alert('ERROR: El campo  tipo insumo debe llenarse');
				document.id_proveedornew.id_tipo_insumo.focus(); 
				return false;
			}						
								
			if(document.id_proveedornew.nombre_insumo.value==""){
				alert('ERROR: El campo nombre insumo debe llenarse');
				document.id_proveedornew.nombre_insumo.focus(); 
				return false;
			}						
								
			if(document.id_proveedornew.precio_insumo.value==""){
				alert('ERROR: El campo precio insumo debe llenarse');
				document.id_proveedornew.precio_insumo.focus(); 
				return false;
			}						
			if(document.id_proveedornew.stock_insumo.value==""){
				alert('ERROR: El campo stock insumo debe llenarse');
				document.id_proveedornew.stock_insumo.focus(); 
				return false;
			}						
			document.id_proveedornew.action="insumos.php?action=add";
			document.id_proveedornew.submit();
		}			
		</script>  
			<fieldset id='form'>
			<legend> Nuevo Registro</legend>			
			<form name='id_proveedornew' method='post' action='' enctype="multipart/form-data" > 
 
				<div class='button-actions'>
					<input type='reset' name='cancelar' value='CANCELAR' class='button' >  
					<input type='button' name='actualizar' value='GUARDAR' onclick='return valida_id_proveedor()' class='button'><br clear='all' />
  				</div>
				<ul> 
					<li><label> Proveedor: </label><input type='text' name='nombre_proveedors' id="nombre_proveedors" value='' class='text ui-widget-content ui-corner-all' size='60'  maxlength="512" autocomplete="off">&nbsp;&nbsp;<a href="ajax.php?action=addproveedor" class="addproveedor fancybox.ajax"><img src="../aplication/webroot/imgs/icons/icon_add.png" /></a><input name="id_proveedor" id="id_proveedor" type="hidden" value="0" /></li> 
					<li><label> Tipo Insumo: </label><input type='text' name='nombre_tipo_insumo' id="nombre_tipo_insumo" value='' class='text ui-widget-content ui-corner-all' size='60'  maxlength="512" autocomplete="off">&nbsp;&nbsp;<a href="ajax.php?action=addtipoinsumo" class="addtipoinsumo fancybox.ajax"><img src="../aplication/webroot/imgs/icons/icon_add.png" /></a><input name="id_tipo_insumo" id="id_tipo_insumo" type="hidden" value="0" /></li> 
					<!--<li><label> Parent: </label><input type='text' name='insumo_padre'  value='' class='text ui-widget-content ui-corner-all' size='60'  maxlength="512"><input name="id_parent" id="id_parent" type="hidden" value="0" /><input name="id_parent" type="hidden" value="" /></li> -->
					<li><label> Nombre Insumo: </label><input type='text' name='nombre_insumo' value='' class='text ui-widget-content ui-corner-all' size='60'  maxlength="512" autocomplete="off" /></li> 
					<li><label> Precio Insumo: </label><input type="text" name="precio_insumo" id="precio_insumo" value="0.00" size="12" class="text ui-widget-content ui-corner-all" autocomplete="off"/></li> 
					<li><label> Imagen Insumo: </label><input type='file' name='imagen_insumo' value='' class='text ui-widget-content ui-corner-all'>&nbsp;</li> 
					<li><label> Stock Insumo: </label><input type='text' name='stock_insumo' dir='rtl' value='' class='num' size="10"  autocomplete="off"></li> 
					</ul>
				</form>
			</fieldset>
        <?php
    }
    
    public function editInsumos(){
		$insumo = new Insumo($_GET['id']);
		/*$query = new Consulta("SELECT * FROM insumos WHERE id_insumo = '".$_GET['id']."'");
		Form::getForm($query, "edit", "insumos.php",'','','img');*/
		?>
        <script type="text/javascript">
			function load_imgs(){ 
				document.id_proveedor.imagen_insumo.value=""; 			   				
			}
			function valida_id_proveedor(){ 					
				if(document.id_proveedoredit.id_proveedor.value==""){
					alert('ERROR: El campo  proveedor debe llenarse');
					document.id_proveedoredit.id_proveedor.focus(); 
					return false;
				}
				
				if(document.id_proveedoredit.id_tipo_insumo.value==""){
					alert('ERROR: El campo  tipo insumo debe llenarse');
					document.id_proveedoredit.id_tipo_insumo.focus(); 
					return false;
				}						
									
				if(document.id_proveedoredit.nombre_insumo.value==""){
					alert('ERROR: El campo nombre insumo debe llenarse');
					document.id_proveedoredit.nombre_insumo.focus(); 
					return false;
				}						
									
				if(document.id_proveedoredit.precio_insumo.value==""){
					alert('ERROR: El campo precio insumo debe llenarse');
					document.id_proveedoredit.precio_insumo.focus(); 
					return false;
				}						
									
				if(document.id_proveedoredit.stock_insumo.value==""){
					alert('ERROR: El campo stock insumo debe llenarse');
					document.id_proveedoredit.stock_insumo.focus(); 
					return false;
				}						
				document.id_proveedoredit.action="insumos.php?action=update&id=<?php echo $_GET['id'];?>";
				document.id_proveedoredit.submit();
			}			
		</script>  
        <fieldset id='form'>
        <legend> Editar Registro</legend>			
        	<form name='id_proveedoredit' method='post' action='' enctype="multipart/form-data" > 

            <div class='button-actions'>
                <input type='reset' name='cancelar' value='CANCELAR' class='button' >  
                <input type='button' name='actualizar' value='ACTUALIZAR' onclick='return valida_id_proveedor()' class='button'><br clear='all' />
            </div>
            <ul> 
                <li><label> Proveedor: </label><input type='text' name='nombre_proveedors' id="nombre_proveedors" class='text ui-widget-content ui-corner-all' size='60'  maxlength="512" autocomplete="off" value="<?php echo $insumo->__get("_proveedor")->__get("_nombre");?>" />&nbsp;&nbsp;<a href="ajax.php?action=addproveedor" class="addproveedor fancybox.ajax"><img src="../aplication/webroot/imgs/icons/icon_add.png" /></a><input name="id_proveedor" id="id_proveedor" type="hidden" value="<?php echo $insumo->__get("_proveedor")->__get("_id");?>" /></li>
                <li><label> Tipo Insumo: </label><input type='text' name='nombre_tipo_insumo' id="nombre_tipo_insumo" value='<?php echo $insumo->__get("_tipo_insumo")->__get("_nombre");?>' class='text ui-widget-content ui-corner-all' size='60'  maxlength="512" autocomplete="off" />&nbsp;&nbsp;<a href="ajax.php?action=addtipoinsumo" class="addtipoinsumo fancybox.ajax"><img src="../aplication/webroot/imgs/icons/icon_add.png" /></a><input name="id_tipo_insumo" id="id_tipo_insumo" type="hidden" value="<?php echo $insumo->__get("_tipo_insumo")->__get("_id");?>" /></li>
                <!--<li><label> Parent: </label><input type='text' name='id_parent' class='text ui-widget-content ui-corner-all' placeholder="Insumo" /></li>-->
                <li><label> Nombre Insumo: </label><input type='text' name='nombre_insumo' value='<?php echo $insumo->__get("_nombre");?>' class='text ui-widget-content ui-corner-all' size='59'  maxlength=512  autocomplete="off" ></li> 
                <li><label> Precio Insumo: </label><input type="text" name="precio_insumo" id="precio_insumo" value="<?php echo $insumo->__get("_precio");?>" size="12" class="text ui-widget-content ui-corner-all" ></li> 
                <li><label> Imagen Insumo: </label><input type='file' name='imagen_insumo' value=''  class='text ui-widget-content ui-corner-all' />&nbsp;</li> 
                <li><label> Stock Insumo: </label><input type='text' name='stock_insumo' dir='rtl'  value='<?php echo $insumo->__get("_stock");?>' onKeyPress='return validnum(event)' class='num' size="5"  autocomplete="off" ></li> 
                </ul>
                <div align="center">
                	<img src="../app/publicroot/imgs/catalogo/<?php echo ($insumo->__get("_imagen")!=''?$insumo->__get("_imagen"):'no_imagen.png');?>" />
                </div>
            </form>
        </fieldset>
        <?php
    } 
    
    public function addInsumos() {
		
		$destino = '../app/publicroot/imgs/catalogo/';
        $update = '';
        if (isset($_FILES['imagen_insumo']['name']) && $_FILES['imagen_insumo']['name'] != "") {
            $nombre = $_FILES['imagen_insumo']['name'];
            $tamano = $_FILES['imagen_insumo']['size'];
            $tarchivo = $_FILES['imagen_insumo']['type'];
            $temp = $_FILES['imagen_insumo']['tmp_name'];
            if (move_uploaded_file($temp, $destino . $nombre)) {
                $update = $nombre;
            }
        }
		
        $query = new Consulta("INSERT INTO insumos VALUES('','".$_POST['id_proveedor']."','".$_POST['id_tipo_insumo']."',".(($_POST['id_parent']==0)?"NULL":$_POST['id_parent']).",'".$_POST['nombre_insumo']."','".$_POST['precio_insumo']."','".$update."','".$_POST['stock_insumo']."')");
        $this->_msgbox->setMsgbox('Insumo agregado actualizado correctamente.',2);
        location("insumos.php");
    }
    
    public function updateInsumos() {
		$destino = '../app/publicroot/imgs/catalogo/';
        $update = '';
        if (isset($_FILES['imagen_insumo']['name']) && $_FILES['imagen_insumo']['name'] != "") {
            $nombre = $_FILES['imagen_insumo']['name'];
            $tamano = $_FILES['imagen_insumo']['size'];
            $tarchivo = $_FILES['imagen_insumo']['type'];
            $temp = $_FILES['imagen_insumo']['tmp_name'];
            if (move_uploaded_file($temp, $destino . $nombre)) {
                $update = ",imagen_insumo='".$nombre."'";
            }
        }
        $query = new Consulta("UPDATE insumos SET 	id_proveedor='".$_POST['id_proveedor']."',
													id_tipo_insumo='".$_POST['id_tipo_insumo']."',
													
													nombre_insumo='".$_POST['nombre_insumo']."',
													precio_insumo='".$_POST['precio_insumo']."',
													stock_insumo='".$_POST['stock_insumo']."'
													".$update."
													WHERE id_insumo='" . $_GET['id'] . "'");
        $this->_msgbox->setMsgbox('Insumo actualizado correctamente.',2);
        location("insumos.php");
    }
	
    public function deleteInsumos(){
        $sql = "DELETE FROM insumos WHERE id_insumo = '".$_GET['id']."' ";
        $query = new Consulta($sql);
        location("insumos.php");
    }
	
    public function listInsumos(){
        
	if (!isset($_GET['pag'])) {
            $_GET['pag'] = 1;
        }
        $tampag = 150;
        $reg1 = ($_GET['pag'] - 1) * $tampag;
        $sql = "SELECT id_insumo, id_insumo as id, nombre_insumo, precio_insumo, stock_insumo, nombre_proveedor, nombre_tipo_insumo FROM insumos 
INNER JOIN proveedores USING(id_proveedor)
INNER JOIN tipos_insumos USING(id_tipo_insumo) 
        ORDER BY nombre_insumo";
        $queryt = new Consulta($sql);
        $num = $queryt->NumeroRegistros();
        $limit = $sql_pag . " LIMIT " . $reg1 . "," . $tampag . "";
        $sql.= $limit;
        $query = new Consulta($sql);
        echo Listado::Simple($query, "insumos.php");
	
    } 
	
    static public function getInsumos(){
        $sql   = " SELECT * FROM insumos ORDER BY nombre_insumo";
        $query = new Consulta($sql);

        while($row = $query->VerRegistro()){
                $datos[] = array(
                        'id' 		=> $row['id_insumo'],
                        'stock' 	=> $row['stock_insumo'],
                        'nombre' 	=> $row['nombre_insumo']
                );
        }
        return $datos;	
    } 
}
?>