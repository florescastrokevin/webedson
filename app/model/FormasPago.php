<?php

class FormasPago {
	
	private $metodoPago;
	private $_msgbox;
	
	public function __construct(Msgbox $msg = Null){		
		$this->_msgbox  = $msg ;		
	}
	
	
	public function newFormasPago(){
		?>
        <fieldset id="form">
        	<legend>Nuevo Metodo de Pago</legend>
        	<form action="" method="post" name="metodoPago" enctype="multipart/form-data"> 
            	
            	<div class="button-actions">
                	<input type="button" name="" value="GUARDAR" onclick="return valida_metodo_pago('add','')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
                               	
                <li><label> Nombre Forma de Pago : </label>
                <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="nombre_metodo_pago"></li>
                
                <li><label> Porcentaje metodo Pago : </label>
                <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="porcentaje_metodo_pago"></li>	
               
                <li><label> Activo metodo de Pago : </label> 
                <div id="radio">                
                    <input type="radio" id="radio1" name="activo_metodo_pago" value="S" checked="checked"/><label for="radio1">Si</label>
                    <input type="radio" id="radio2" name="activo_metodo_pago" value="N" /><label for="radio2">No</label>
                </div><br/><br/><br/>
                </li>     
                				
                <li><label> Descripci&oacute;n metodo de Pago : </label> <textarea name="descripcion" class="text ui-widget-content ui-corner-all tinymce" rows="18" cols="124"></textarea></li>              
                
                <li><label> T&eacute;rminos y Condiciones : </label> <textarea name="terminos_y_condiciones" class="text ui-widget-content ui-corner-all tinymce" rows="18" cols="124"></textarea></li>     
                 
                 
                <li><label> Imagen Metodo de pago: </label>
                <input type="file" size="50"  class="text ui-widget-content ui-corner-all" name="imagen_metodo_pago">
                </li>
                 
                </ul>
        	</form>
        </fieldset>        
		<?php
	}
	
	
	public function editFormasPago(){
		
		$formaPago = $this->getFormaPago($_GET['id']);
		
		?>
        <fieldset id="form">
        	<legend>Editar Metodo de Pago</legend>
        	<form action="" method="post" name="metodoPago" enctype="multipart/form-data"> 
            	<div class="button-actions">
                	<input type="button" name="" value="GUARDAR" onclick="return valida_metodo_pago('update','<?php echo $_GET['id'] ?>')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
                <li><label> Nombre Forma de Pago : </label>
                <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="nombre_metodo_pago" value="<?php echo $formaPago[0]['nombre']?>"></li>
                
                <li><label> Porcentaje metodo Pago : </label>
                <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="porcentaje_metodo_pago" value="<?php echo $formaPago[0]['porcentaje']?>"></li>	
               
                <li><label> Activo metodo de Pago : </label> 
                <div id="radio">                
                    <input type="radio" id="radio1" name="activo_metodo_pago" value="S" <?php if($formaPago[0]['estado'] == 'S') echo 'checked="checked"' ?>/><label for="radio1">Si</label>
                    <input type="radio" id="radio2" name="activo_metodo_pago" value="N" <?php if($formaPago[0]['estado'] == 'N') echo 'checked="checked"' ?> /><label for="radio2">No</label>
                </div>
                </li><br/><br/><br/>
                
                <li><label> Descripci&oacute;n metodo de Pago : </label> 
                <textarea name="descripcion_metodo_pago" class="text ui-widget-content ui-corner-all tinymce" rows="18" cols="124"><?php echo $formaPago[0]['descripcion']?></textarea></li>			          
                
                 <li><label> T&eacute;rminos y Condiciones : </label> <textarea name="terminos_y_condiciones" class="text ui-widget-content ui-corner-all tinymce" rows="18" cols="124"><?php echo $formaPago[0]['terminos']?></textarea></li>     
                 
                 
                <li><label> Imagen Metodo de pago: </label>
                <input type="file" size="50"  class="text ui-widget-content ui-corner-all" name="imagen_metodo_pago">
                </li>                 
                </ul>
                
                <div align="center" class="img_categoria">
                	<img src="<?php echo _catalogo_.$formaPago[0]['imagen'] ?>" />
                </div>
                
        	</form>
        </fieldset>        
		<?php
	}
	
	public function addFormasPago(){
		if(isset($_FILES['imagen_metodo_pago']) && ($_FILES['imagen_metodo_pago']['name'] != "")){
			
			$obj  = new Upload();
			$destino = "../app/publicroot/imgs/catalogo/";
			
			$name = strtolower(date("ymdhis").$_FILES['imagen_metodo_pago']['name']);
			$temp = $_FILES['imagen_metodo_pago']['tmp_name'];
			$type = $_FILES['imagen_metodo_pago']['type'];
			$size = $_FILES['imagen_metodo_pago']['size'];
			
			$obj->upload_imagen($name, $temp, $destino, $type, $size);
		}
		$query = new Consulta("INSERT INTO metodo_pago 
									VALUES ('','".$_POST['nombre_metodo_pago']."','".$_POST['porcentaje_metodo_pago']."','".$_POST['activo_metodo_pago']."','".$_POST['nombre_metodo_pago']."','".$_POST['descripcion_metodo_pago']."','".$_POST['terminos_y_condiciones']."','".$name."','0')");		
		$this->_msgbox->setMsgbox('El metodo de pago se grabo correctamente.',2);
		location("formas_pago.php");
	}
	
	public function updateFormasPago(){
		$update = "";
		if(isset($_FILES['imagen_metodo_pago']) && ($_FILES['imagen_metodo_pago']['name'] != "")){
			
			$obj  = new Upload();
			$destino = "../app/publicroot/imgs/catalogo/";
			
			$name = strtolower(date("ymdhis").$_FILES['imagen_metodo_pago']['name']);
			$temp = $_FILES['imagen_metodo_pago']['tmp_name'];
			$type = $_FILES['imagen_metodo_pago']['type'];
			$size = $_FILES['imagen_metodo_pago']['size'];
			
			$obj->upload_imagen($name, $temp, $destino, $type, $size);
			$update = " imagen_metodo_pago = '".$name."' ,";
			
		}
			
		$query = new Consulta("UPDATE metodo_pago SET ".$update." 
						
						nombre_metodo_pago = '".$_POST['nombre_metodo_pago']."' , 
						porcentaje_metodo_pago = '".$_POST['porcentaje_metodo_pago']."',
						activo_metodo_pago = '".$_POST['activo_metodo_pago']."' , 
						alias_metodo_pago = '".$_POST['nombre_metodo_pago']."' , 
						descripcion_metodo_pago = '".$_POST['descripcion_metodo_pago']."',
						terminos_condiciones = '".$_POST['terminos_y_condiciones']."' 
						
						WHERE id_metodo_pago = '".$_GET['id']."'");		
					
		$this->_msgbox->setMsgbox('El metodo de pago se actualiz�� correctamente.',2);
		location("formas_pago.php");
	}	
	
	public function listFormasPago(){		
		
		$sqlp = "SELECT * FROM metodo_pago ORDER BY orden_metodo_pago ASC";							
		$queryp = new Consulta($sqlp);	
		?>
        <div id="content-area">
            <table cellspacing="1" cellpading="1" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left">Formas de Pago</th>
                        <th align="center" width="100" class="titulo">Opciones</th>
                   </tr>
                </thead>
            </table>	
            <ul id="listadoul" title="ordenarFormaPago">
			 <?php				
				$y = 1;
				while($rowp = $queryp->VerRegistro()){
					?>
					 <li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="list_item_<?php echo $rowp['id_metodo_pago']."|mapgo"; ?>">
						 <div class="data"> <img src="<?php echo _admin_ ?>file.png" class="handle">   <?php echo $rowp['nombre_metodo_pago'] ?></div>
						 <div class="options">
							<a class="tooltip move" title="Ordenar ( Click + Arrastrar )"><img src="<?php echo _admin_ ?>move.png" class="handle"></a>&nbsp;
                            <a title="Editar" class="tooltip" href="formas_pago.php?id=<?php echo $rowp['id_metodo_pago'] ?>&action=edit">
							<img src="<?php echo _admin_ ?>edit.png"></a> &nbsp;
							<a title="Eliminar" class="tooltip" onClick="mantenimiento('formas_pago.php','<?php echo $rowp['id_metodo_pago'] ?>','delete')"  href="#"> <img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;                      
                         </div>
						 </li>
				<?php
					$y++;
					}
				?>
             </ul>
        </div>
        <?php
		
	}	
					
	public function getFormasPago($id = 0){
		if($id == 1 || $id == 2){
			//$qq = "AND id_metodo_pago <> 1 AND id_metodo_pago <> 2 AND id_metodo_pago <> 4";
		}else{
			//$qq = "AND id_metodo_pago <> 3";
		}
		$sql="SELECT * FROM metodo_pago WHERE activo_metodo_pago='S' ORDER BY orden_metodo_pago ASC".$qq;
		$query=new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$this->envios[] = array(
                            'id'			=>	$row[0],
                            'nombre'		=>	$row[1],
                            'porcentaje'	=>	$row[2],
                            'estado'		=>	$row[3],
                            'class'			=>	$row[4],
                            'descripcion'	=>	$row[5],
                            'terminos'		=>	$row[6],
                            'imagen'		=>	$row[7],
                            'icono'			=>  $row[9]
			);					
		}	
		
		return 	$this->envios;
	}
	
	public function classFormaPago($class, $amount, $shipping, $detail){
        
		if(isset($class) && !empty($class)){
		
			switch($class){
                            
                            case 'DEPOSITO O TRANSFERENCIA':	
                               // echo 'aca';
                                    require_once(_model_."TransferenciaBancaria.php");
                                    $this->metodoPago = new Transferencia($amount, $shipping);									
                            break; 
                                                    
                            case 'Paypal':
                                    require_once(_model_."Paypal.php");					
                                    $this->metodoPago = new Paypal($amount, $shipping,  $detail);
                            break;	

                            case 'SCOTIABANK':				
                                    require_once(_model_."TransferenciaBancaria.php");
                                    $this->metodoPago = new Transferencia($amount, $shipping);
                            break;
                            case 'BBVA':				
                                    require_once(_model_."TransferenciaBancaria.php");
                                    $this->metodoPago = new Transferencia($amount, $shipping);
                            break;
                            case 'INTERBANK DEPOSITO O TRANSFERENCIA ':				
                                    require_once(_model_."TransferenciaBancaria.php");
                                    $this->metodoPago = new Transferencia($amount, $shipping);
                            break;
                        
                            case 'Transferencia Internacional':				
                                    require_once(_model_."WesterUnion.php");
                                    $this->metodoPago = new WesterUnion($amount, $shipping);
                            break;                        					
			}			
		}
	}
	
	public function getObjPago(){
		return $this->metodoPago;
	}
	
	public function generarBoton($id_pedido){				
            $formulario = $this->metodoPago->generaFormulario($id_pedido);
            return $formulario; 
	}
	
	
	
	public function getFormaPago($id=0){
		$sql="SELECT * FROM metodo_pago WHERE id_metodo_pago='".$id."'";
		$query=new Consulta($sql);
		while($row = $query->VerRegistro()){
			$this->pago[] = array(
                            'id'			=>  $row[0],
                            'nombre'		=>	$row[1],
                            'porcentaje'	=>	$row[2],
                            'estado'		=>	$row[3],
                            'class'         =>	$row[4],
                            'descripcion'	=>	$row[5],
							'terminos'		=>	$row[6],
                            'imagen'		=>	$row[7]							
			);					
		}	
		return 	$this->pago;
	}
	
	public function datosPago(){
		/*$datos="";
		
		$datos .= $this->metodoPago->getBanco()."<br>";
		$datos .= "Numero de Cuenta : ".$this->metodoPago->getnCuenta()."<br>";	
				
		return $datos;*/
	}
	
}

?>