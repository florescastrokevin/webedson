<?php
class Productos{
	
	private $_idioma, $_msgbox;
	
	public function __construct(Idioma $idioma = Null, Msgbox $msg = Null, Usuario $user = Null){
		$this->_idioma  = $idioma ;
		$this->_msgbox  = $msg ;
		$this->_usuario = $user;
	}
	
	public function newProductos(){
            
            $obj_tags = new Tags($this->_msgbox); 
            $tags = $obj_tags->getTagsPorCategoria($_SESSION['categoria']);	

            $obj_tags = new Tags($this->_msgbox); 
            $tagg = $obj_tags->getTagsGenericos();

            $obj_ocasiones = new Ocasiones();
            $ocasiones = $obj_ocasiones->getOcasiones();
            $tocasiones = count($ocasiones);
			
            $obj_destinatarios = new Destinatarios();
            $destinatarios = $obj_destinatarios->getDestinatarios();
            $tdestinatarios = count($destinatarios);
			
            $obj_tipos = new Tipos();
            $tipos = $obj_tipos->getTipos();
            $ttipos = count($tipos);
			
            $obj_expresiones = new Expresiones();
            $expresiones = $obj_expresiones->getExpresiones();
            $texpresiones = count($expresiones); ?>
            <fieldset id="form">
        	<legend>Nuevo Producto</legend>
        	<form action="" method="post" name="productos" > 
            	<div class="button-actions">
                    <input type="button" name="" value="GUARDAR" onclick="return valida_productos('add','')"  />
                    <input type="reset" name="" value="CANCELAR" />
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6" style="background-color:#f4f4f4">
                        <h4> Datos del Producto:</h4>  
                        <div class="row">
                            <div class=" col-xs-12 col-sm-12 col-md-12 form-group">
                                <label> Nombre Producto : </label>
                                <input type="text" class="form-control" name="nombre">
                            </div>	
                        </div>
                        <div class="form-group"><label> Descripcion Corta : </label>
                            <textarea name="descripcion_corta" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <div class=" col-xs-12 col-sm-12 col-md-12 form-group">
                                <label> Descripcion : </label> 
                                <textarea name="descripcion" class="form-control" rows="18"></textarea>
                            </div>  
                        </div>
                        <div class="form-inline">
                            <label>Precio:</label>
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputAmount">Precio (en dolares)</label>
                                <div class="input-group">
                                  <div class="input-group-addon">$</div>
                                  <input type="text" class="form-control"  dir="rtl"  name="precio_producto" id="exampleInputAmount" placeholder="10">
                                  <div class="input-group-addon">.00</div>
                                </div>
                            </div> 
                            <label>Stock: </label><input type="text" class="form-control solo_numero" size="11" dir="rtl" name="stock_producto">
                        </div>	 
                        <div class="row ">
                            <br><div class="form-group col-xs-12 col-sm-12 col-md-12"><label>Marcar como Destacado : </label> 
                                <div id="radio">                
                                    <input type="radio" id="radio1" name="destacado_producto" value="1" /> <label for="radio1">Si</label>
                                    <input type="radio" id="radio2" name="destacado_producto" value="0" /> <label for="radio2">No</label>                    
                                </div>   
                            </div>
                            <div class="form-group col-xs-12 col-sm-12 col-md-12"><label>Estado : </label> 
                                <div id="radio2">                
                                    <input type="radio" name="estado_producto" value="1"  checked="checked" /> <span style="color: #37c630"><b>Activo</b></span>
                                    <input type="radio" name="estado_producto" value="0" /> <span style="color:#f30e20"><b>Oculto</b></span>
                                </div>          
                            </div> 
                            <div class="form-group col-xs-12 col-sm-12 col-md-12"><label>Es complemento : </label> 
                                <div id="radio2">                
                                    <input type="radio" name="complemento_producto" value="1" /> Si
                                    <input type="radio" name="complemento_producto" value="0" /> No
                                </div>          
                            </div>  
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6" style="background-color:#dbecf3">
                        <h4> Insumos del Producto:</h4>
                        <div id="conte_insumos" class="row">
                            <div class="detalle_insumo col-xs-12 col-sm-12 col-md-12 form-inline">
                                <label>Insumo :</label> <input name="insumos_pro" id="insumos_pro" type="text"  maxlength="50" class="form-control" style="width:65%" />
                                <input name="cant_insumo" id="cant_insumo" type="text" maxlength="10" class="form-control" value="1" style="width:10%" /><input name="id_insumo" type="hidden" id="id_insumo" value="" />&nbsp;&nbsp;&nbsp;<input name="id_edit_in" id="id_edit_in" type="hidden" value="" />
                                <input name="agregar" type="button" value="Agregar" id="agregarinsumo" class="btn btn-submit" />
                                <input name="editar" type="button" value="Editar Insumo" id="editarinsumo" style="display:none;" />
                            </div>
                            <div class="lista_insumos col-xs-12 col-sm-12 col-md-12" id="lista_insumos">
                                <?php $this->insumosXProductoNuevo()?>
                            </div>
                        </div>
                        <h4>Complementos del Producto</h4>
                        <div id="conte_insumos" class="col-xs-12 col-sm-12 col-md-12"><?php $this->complementosXProducto(); ?></div>
                        <h4>Filtros</h4>
                        <ul class="checksensible col-xs-12 col-sm-6 col-md-3">
                            <li><b> Ocasiones:</b></li>
                            <?php     
                            foreach( $ocasiones as $id=>$nombre ){  ?> 
                                <li> <?php //echo $id; ?> 
                                    <input type='checkbox' name="ocasiones[]" value="<?php echo $nombre['id']?>" /> 
                                    <input type="hidden" name="<?php echo $nombre['id']?>" value="<?php echo $nombre['nombre']?>" />
                                    <?php echo $nombre['nombre']?> 
                                </li>  <?php
                            }  ?>
                        </ul> 
                        <ul class="checksensible col-xs-12 col-sm-6 col-md-3">
                            <li><b> Destinatarios:</b></li> <?php 
                            foreach( $destinatarios as $id=>$nombre ){   ?> 
                                <li> <?php //echo $id; ?> 
                                    <input type='checkbox' name="destinatarios[]" value="<?php echo $nombre['id']?>" /> 
                                    <input type="hidden" name="<?php echo $nombre['id']?>" value="<?php echo $nombre['nombre']?>" />
                                    <?php echo $nombre['nombre']?> 
                                </li> <?php 
                            } ?>
                        </ul>
                        <ul class="checksensible col-xs-12 col-sm-6 col-md-3">
                            <li><b> Expresiones:</b></li>  <?php 
                            foreach( $expresiones as $id=>$nombre ){ ?> 
                                <li> <?php //echo $id; ?> 
                                    <input type='checkbox' name="expresiones[]" value="<?php echo $nombre['id']?>" /> 
                                    <input type="hidden" name="<?php echo $nombre['id']?>" value="<?php echo $nombre['nombre']?>" />
                                    <?php echo $nombre['nombre']?> 
                                </li> <?php
                            } ?>
                        </ul>
                        <ul class="checksensible col-xs-12 col-sm-6 col-md-3">
                            <li><b> Tipos:</b></li> <?php 
                            foreach( $tipos as $id=>$nombre ){ ?> 
                                <li> <?php //echo $id; ?> 
                                    <input type='checkbox' name="tipos[]" value="<?php echo $nombre['id']?>" /> 
                                    <input type="hidden" name="<?php echo $nombre['id']?>" value="<?php echo $nombre['nombre']?>" />
                                    <?php echo $nombre['nombre']?> 
                                </li>  <?php
                            }  ?>
                        </ul>
                    </div>    
                </div>     
                <h3> Tags:</h3>
                <div style="height:auto;overflow:hidden"> <?php
                    $score = 0;
                    if(count($tags)>0){
                        foreach( $tags as $id=>$nombre ){
                            if($score == 0){ echo " <ul style='float:left;width:270px' > "; }  ?> 
                            <li> <?php //echo $id; ?> 
                                    <input type='checkbox' name="tags[]" value="<?php echo utf8_decode($nombre['texto'])?>" /> 
                                    <?php echo utf8_decode($nombre['texto'])?> 
                            </li>
                            <?php
                            //echo $score."|".($score%14);
                            if($score > 14 ){ echo " </ul>"; $score = 0; }else{ $score++; }
                        } 
                    }

                    $score = 0;                 
                    foreach( $tagg as $idg=>$nombreg ){
                        //if( is_array($tags_producto) && in_array($nombreg['id'],$tags_producto) ){ $checked = "checked='checked'"; }
                        if($score == 0){ echo " <ul style='float:left;width:270px'> "; } ?> 
                        <li> <?php //echo $idg; ?> 
                            <input type='checkbox' name="tags[]" value="<?php echo utf8_decode($nombreg['texto'])?>" /> <?php echo utf8_decode($nombreg['texto'])?>
                        </li>
                        <?php
                        if($score > 14 || $score==count($tagg)){ echo " </ul>"; $score = 0; }else{ $score++; }
                        $checked = "";
                    }
                    ?>
                </div>                                    
        	</form>
            </fieldset> <?php
	}
	
	public function addProductos($cat=0){
 		$query = new Consulta("INSERT INTO productos VALUES ('','".$this->_usuario->getId()."','".$cat."',
          '".$_POST['nombre']."',
          '".$_POST['descripcion_corta']."',
          '".$_POST['descripcion']."',															
          '".$_POST['precio_producto']."',
          '".$_POST['destacado_producto']."',	
		  '".$_POST['stock_producto']."','','".$_POST['complemento_producto']."',1,
          '".$this->orderProductos($cat)."','".$_POST['estado_producto']."')");
		$id = $query->nuevoId();
		//	Ingresamos los insumos utilizados para este producto.
		$datos = $_SESSION['list_insumos'];
		//$datos[] = array($_POST['id'],$_POST['nombrei'],$_POST['cant']);
		$ndatos = count($datos);
		for($k=0;$k<$ndatos;$k++){
			new Consulta("INSERT INTO productos_insumos VALUES ('".$id."','".$datos[$k][0]."','".$datos[$k][2]."')");
		}
		unset($_SESSION['list_insumos']);
		//Insertando tags 
        if($_POST['tags']){                   
			for($i = 0; $i < count($_POST['tags']); $i++) 
                $value .= $_POST['tags'][$i].',';  
			new Consulta("UPDATE productos SET tags_producto='".trim($value,',')."' WHERE id_producto = '".$id."' ");
		}

		//busco el id_parent si es que existe:
        $id_parent = 999999;
        if($cat > 0){
            $obj_categoria = new Categoria($cat);
            $id_parent = $obj_categoria->__get("_parent");
        }
        
        //Insertando ocasiones 
        if($_POST['ocasiones']){
            $sql_delete_tags = new Consulta("DELETE FROM productos_ocasiones WHERE id_producto = '".$id."' ");
            for($i = 0; $i < count($_POST['ocasiones']); $i++)
            {   
                $query = new Consulta("INSERT INTO productos_ocasiones VALUES ('".$id."','".$_POST['ocasiones'][$i]."','".$id_parent."')");
            }
        } 
        
        //Insertando destinatarios 
        if($_POST['destinatarios']){
            $sql_delete_tags = new Consulta("DELETE FROM productos_destinatarios WHERE id_producto = '".$id."' ");
            for($i = 0; $i < count($_POST['destinatarios']); $i++)
            {   
                $query = new Consulta("INSERT INTO productos_destinatarios VALUES ('".$id."','".$_POST['destinatarios'][$i]."','".$id_parent."')");
            }
        }
        
        //Insertando expresiones 
        if($_POST['expresiones']){
            $sql_delete_tags = new Consulta("DELETE FROM productos_expresiones WHERE id_producto = '".$id."' ");
            for($i = 0; $i < count($_POST['expresiones']); $i++)
            {   
                $query = new Consulta("INSERT INTO productos_expresiones VALUES ('".$id."','".$_POST['expresiones'][$i]."','".$id_parent."')");
            }
        }
        
        //Insertando tipos 
        if($_POST['tipos']){
            $sql_delete_tags = new Consulta("DELETE FROM productos_tipos WHERE id_producto = '".$id."' ");
            for($i = 0; $i < count($_POST['tipos']); $i++)
            {   
                $query = new Consulta("INSERT INTO productos_tipos VALUES ('".$id."','".$_POST['tipos'][$i]."','".$id_parent."')");
            }
        }
		
        //init update complementos
        new Consulta("DELETE FROM productos_complementos WHERE id_producto = '".$id."' ");		
        if( isset($_POST['complementos']) && count($_POST['complementos'])>0 ){
                foreach($_POST['complementos'] as $cmp){
                        new Consulta("INSERT INTO productos_complementos VALUES ('','".$id."', '".$cmp."')");
                }			
        } 
		$this->_msgbox->setMsgbox('Producto grabado correctamente',2);
		location("productos.php?cat=".$cat);
	}
	
	public function editProductos(){
           
            $obj_tags = new Tags($this->_msgbox); 
            $tagg = $obj_tags->getTagsGenericos();
		
            $obj_ocasiones = new Ocasiones();
            $ocasiones = $obj_ocasiones->getOcasiones();
            $tocasiones = count($ocasiones);

            $obj_destinatarios = new Destinatarios();
            $destinatarios = $obj_destinatarios->getDestinatarios();
            $tdestinatarios = count($destinatarios);

            $obj_tipos = new Tipos();
            $tipos = $obj_tipos->getTipos();
            $ttipos = count($tipos);

            $obj_expresiones = new Expresiones();
            $expresiones = $obj_expresiones->getExpresiones();
            $texpresiones = count($expresiones);
		
	       $tags = $obj_tags->getTagsPorCategoria($_SESSION['categoria']);
	       $obj = new Producto($_GET['id'], $this->_idioma);  
            
            if(!isset($_SESSION['list_insumos'])){
                $datosin = $obj->__get("_insumos");
                $_SESSION['list_insumos'] = $datosin;
            }
            //$datos[] = array($_POST['id'],$_POST['nombrei'],$_POST['cant']); ?>
		<fieldset id="form">
        	<legend>Editar Producto</legend>
        	<form action="" method="post" name="productos" > 
            	<div class="button-actions">
                    <input type="reset" class="button" value="CANCELAR" name="cancelar">  
                    <input type="button" class="button" onclick="return valida_productos('update','<?php echo $_GET['id'] ?>')" value="ACTUALIZAR" name="actualizar">	
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6" style="background-color:#f4f4f4">
                        <h4> Datos del Producto:</h4>
                        <div class="row">
                            <div class=" col-xs-12 col-sm-12 col-md-12 form-group">
                                <label> Nombre Producto : </label>
                                <input type="text" class="form-control"  name="nombre" value="<?php echo $obj->__get("_nombre")?>">
                            </div>	
                        </div>
                        <div class="form-group"><label> Descripcion Corta : </label>
                            <textarea name="descripcion_corta" class="form-control" rows="5"><?php echo $obj->__get("_descripcion_corta")?></textarea>
                        </div>
                        <div class="row">
                            <div class=" col-xs-12 col-sm-12 col-md-12 form-group">
                                <label> Descripcion : </label> 
                                <textarea name="descripcion" class="form-control" id="descripcion_producto" rows="18">
                                <?php echo $obj->__get("_descripcion")?>
                                </textarea>
                            </div>  
                        </div>
                                        
                        <div class="form-inline">
                            <label>Precio:</label>
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputAmount">Precio (en dolares)</label>
                                <div class="input-group">
                                  <div class="input-group-addon">$</div>
                                  <input type="text" class="form-control"  dir="rtl"  name="precio_producto" id="exampleInputAmount" placeholder="10" value="<?php echo $obj->__get("_precio_producto")?>">
                                  <div class="input-group-addon">.00</div>
                                </div>
                            </div> 
                            <label>Stock: </label><input type="text" value="<?php echo $obj->__get("_stock")?>" class="form-control solo_numero" size="11" dir="rtl" name="stock_producto">
                            
                        </div>	 
                        <div class="row ">
                            <br><div class="form-group col-xs-12 col-sm-12 col-md-12"><label>Marcar como Destacado : </label> 
                                <div id="radio">                
                                    <input type="radio" id="radio1" name="destacado_producto" value="1" <?php if($obj->__get("_destacado") == 1) echo 'checked="checked"' ?>/> <label for="radio1">Si</label>
                                    <input type="radio" id="radio2" name="destacado_producto" value="0" <?php if($obj->__get("_destacado") == 0) echo 'checked="checked"' ?> /> <label for="radio2">No</label>                    
                                </div>   
                            </div>
                            
                            <div class="form-group col-xs-12 col-sm-12 col-md-12"><label>Estado : </label> 
                                <div id="radio2">                
                                    <input type="radio" name="estado_producto" value="1" <?php if($obj->__get("_estado") == 1) echo 'checked="checked"' ?> /> <span style="color: #37c630"><b>Activo</b></span>
                                    <input type="radio" name="estado_producto" value="0" <?php if($obj->__get("_estado") == 0) echo 'checked="checked"' ?>/> <span style="color:#f30e20"><b>Oculto</b></span>
                                </div>          
                            </div> 
 
                            <div class="form-group col-xs-12 col-sm-12 col-md-12"><label>Es complemento : </label> 
                                <div id="radio2">                
                                    <input type="radio" name="complemento_producto" <?php if($obj->__get('_is_complemento')==1){echo 'checked="checked"';}?> value="1" /> Si
                                    <input type="radio" name="complemento_producto" <?php if($obj->__get('_is_complemento')==0){echo 'checked="checked"';}?> value="0" /> No
                                </div>          
                            </div>  
                        </div>
                        <h4>Complementos del Producto</h4>
                        <div id="conte_insumos" class="row"> <?php $this->complementosXProducto(); ?> </div>
                        
                         <h4>Filtros</h4>
                        <ul class="checksensible col-xs-12 col-sm-6 col-md-3">
                        <li><b> Ocasiones:</b></li>
                        <?php     
                        $ocasiones_producto = $obj->__get('_ocasiones_id');
                        foreach( $ocasiones as $id=>$nombre ){  
                            if( is_array($ocasiones_producto) && in_array($nombre['id'],$ocasiones_producto) ){ $checked = "checked='checked'"; }
                            ?> 
                            <li> <?php //echo $id; ?> 
                                <input type='checkbox' name="ocasiones[]" value="<?php echo $nombre['id']?>"  id="chk-<?php echo $nombre['id']?>" <?php echo $checked; ?>/>                           
                                <label for="chk-<?php echo $nombre['id']?>"><?php echo $nombre['nombre']?> </label>
                            </li>  <?php
                             $checked = "";
                                            }?>
                        </ul>                   
                     
                    <ul  class="checksensible col-xs-12 col-sm-6 col-md-3">
                        <li><b> Destinatarios:</b></li>
                    <?php 
					$destinatarios_producto = $obj->__get('_destinatarios_id');
                    foreach( $destinatarios as $id=>$nombre ){   
					if(is_array($destinatarios_producto)&&in_array($nombre['id'],$destinatarios_producto)){$checked = "checked='checked'";}
					?> 
                        <li> <?php //echo $id; ?> 
                            <input type='checkbox' name="destinatarios[]" value="<?php echo $nombre['id']?>" <?php echo $checked; ?>/>
							<?php echo $nombre['nombre']?> 
                        </li> <?php 
                    	 $checked = "";
					} ?>
                    </ul>    
                    <ul class="checksensible col-xs-12 col-sm-6 col-md-3">
                        <li><b> Expresiones:</b></li>
                    <?php 
					$expresiones_producto = $obj->__get('_expresiones_id');
                    foreach( $expresiones as $id=>$nombre ){
					if(is_array($expresiones_producto)&&in_array($nombre['id'],$expresiones_producto)){$checked = "checked='checked'";}
						?> 
                        <li> <?php //echo $id; ?> 
                            <input type='checkbox' name="expresiones[]" value="<?php echo $nombre['id']?>" <?php echo $checked; ?>/>
							<?php echo $nombre['nombre']?> 
                        </li>
                        <?php
                   	 $checked = "";
				    } ?>
                    </ul>   
                    
                    <ul class="checksensible col-xs-12 col-sm-6 col-md-3">
                        <li><b> Tipos:</b></li>
                    <?php 
					$tipos_producto = $obj->__get('_tipos_id');				
                    foreach( $tipos as $id=>$nombre ){ 
					if(is_array($tipos_producto)&&in_array($nombre['id'],$tipos_producto)){$checked = "checked='checked'";}
					?> 
                        <li> <?php //echo $id; ?> 
                            <input type='checkbox' name="tipos[]" value="<?php echo $nombre['id']?>" <?php echo $checked; ?>/> 
                            <?php echo $nombre['nombre']?> 
                        </li>
                        <?php
                    	 $checked = "";
					}  ?>
                    </ul>
                        
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6" style="background-color:#dbecf3">
                        <h4> Insumos del Producto:</h4>
                        <div id="conte_insumos" class="row">
                            <div class="lista_insumos col-xs-12 col-sm-12 col-md-12" id="lista_insumos">
                                <?php //$this->insumosXProductoNuevo()?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12" id="cp_seleccionados">
                                <table class="listado display table table-striped table-hover" style="background-color:#f5f5f5" style="min-height:500px" id="myTable" >
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody><?php 
                                $obj_insumos = new Insumos();
                                $insumos = $obj_insumos->getInsumos();
                                $total_insumos = count($insumos);
                                $producto_insumos_completo = $obj->__get("_insumos"); 
                                for($i = 0; $i < $total_insumos; $i++){
                                    $cantidad = 1;
                                    $checked = "";
                                    if(is_array($producto_insumos_completo[$insumos[$i]["id"]])){ 
                                        $checked = "checked='checked'";
                                        $cantidad = $producto_insumos_completo[$insumos[$i]["id"]][1];
                                    } ?>
                                    
                                    <tr>
                                        <td class="td-padding-5"><input type="checkbox" name="insumos[]" value="<?php echo $insumos[$i]["id"] ?>" id="ichk-<?php echo $insumos[$i]["id"] ?>" <?php echo $checked; ?>></td>
                                        <td class="td-padding-5"><label for="ichk-<?php echo $insumos[$i]["id"] ?>"><?php echo $insumos[$i]["nombre"] ?></label></td>
                                        <td class="td-padding-5"><input type="text" name="cantidad_insumos_<?php echo $insumos[$i]["id"] ?>" value="<?php echo $cantidad ?>" size="1" dir="rtl" onkeydown="increment(event, this)" ></td>
                                    </tr> <?php
                                } ?>
                                    </tbody>
                                </table><br><br>
                            </div>
                        </div> 
                        
                       
                    </div> 
                </div>   
                 
<!--                    <h3> Tags:</h3>
                    <div style="height:auto;overflow:hidden" class="checksensible">
					<?php
                   
				    $tags_producto = $obj->__get('_tags_nombre');  
                   
				    $score = 0;
					if(count($tags)!=0){
						foreach( $tags as $id=>$nombre ){
							if( is_array($tags_producto) && in_array($nombre['texto'],$tags_producto) ){ $checked = "checked='checked'"; }
							if($score == 0){ echo " <ul style='float:left;width:270px' class=\"checksensible\" > "; } ?> 
							<li> <?php //echo $id; ?> 
								<input type='checkbox' name="tags[]" value="<?php echo utf8_decode($nombre['texto'])?>" <?php echo $checked; ?> id="tag_<?php echo $nombre['id'] ?>"  class="chboxx" /> <?php echo utf8_decode($nombre['texto'])?>
							   
							</li>
							<?php
							if($score > 14){ echo " </ul>"; $score = 0; }else{ $score++; }
							$checked = "";
						} 
					}
                    $score = 0;                 
					if(count($tagg)!=0){
						foreach( $tagg as $idg=>$nombreg ){
							if( is_array($tags_producto) && in_array($nombreg['texto'],$tags_producto) ){ $checked = "checked='checked'"; }
							if($score == 0){ echo " <ul style='float:left;width:270px'> "; } ?> 
							<li> <?php //echo $idg; ?> 
								<input type='checkbox' name="tags[]" value="<?php echo $nombreg['texto']?>" <?php echo $checked; ?> id="tag_<?php echo $nombre['id'] ?>" class="chboxx" /> <?php echo $nombreg['texto']?>
							</li>
							<?php
							if($score > 16){ echo " </ul>"; $score = 0; }else{ $score++; }
							$checked = "";
						}
					}
					?>
                    
                    </div>
                   
                    
                    -->                
                  <div class="button-actions">
                    <input type="reset" class="button" value="CANCELAR" name="cancelar">  
                    <input type="button" class="button" onclick="return valida_productos('update','<?php echo $_GET['id'] ?>')" value="ACTUALIZAR" name="actualizar">	
                </div>
        	</form>
        </fieldset> <?php
	}
	
	public function updateProductos($cat=0){	   
            $id_producto = $_GET['id'];  

            $query = new Consulta("UPDATE  productos SET 
                                    nombre_producto   = '".$_POST['nombre']."',
                                    descripcion_producto = '".$_POST['descripcion']."',
                                    descripcion_corta_producto= '".$_POST['descripcion_corta']."',
                                    precio_producto   = '".$_POST['precio_producto']."',	
                                    destacado_producto= '".$_POST['destacado_producto']."'	,													
                                    stock_producto    = '".$_POST['stock_producto']."'	,
                                    is_complemento    = '".$_POST['complemento_producto']."' ,
                                    estado            = '".$_POST['estado_producto']."'	 													
                                WHERE id_producto     = '".$id_producto."'");
				
		if($_POST['insumos']){
                    new Consulta("DELETE FROM productos_insumos WHERE id_producto = '".$id_producto."' ");
                    for($i = 0; $i < count($_POST['insumos']); $i++){ 
                        $campo_cantidad = "cantidad_insumos_".$_POST['insumos'][$i];
                        $query = new Consulta("INSERT INTO productos_insumos VALUES ('".$id_producto."','".$_POST['insumos'][$i]."','".$_POST[$campo_cantidad]."')");
                        //$query = new Consulta("INSERT INTO productos_insumos VALUES ('".$id_producto."','".$_POST['insumos'][$i]."', '".$cat."') ");
                    }		
		}

//                //	Ingresamos los insumos utilizados para este producto.
//		$datos = $_SESSION['list_insumos'];
//		//$datos[] = array($_POST['id'],$_POST['nombrei'],$_POST['cant']);
//		$ndatos = count($datos);
//		for($k=0;$k<$ndatos;$k++){
//			new Consulta("INSERT INTO productos_insumos VALUES ('".$id_producto."','".$datos[$k][0]."','".$datos[$k][2]."')");
//		}
//		unset($_SESSION['list_insumos']);
//		//init update tags	
		
		//Insertando tags 
		if($_POST['tags']){                   
			for($i = 0; $i < count($_POST['tags']); $i++) 
				$value .= $_POST['tags'][$i].',';  
			new Consulta("UPDATE productos SET tags_producto='".trim($value,',')."' WHERE id_producto = '".$id_producto."' ");
		}
		
		
		//init update ocasiones
		new Consulta("DELETE FROM productos_ocasiones WHERE id_producto = '".$id_producto."' ");		
		if($_POST['ocasiones']){			
			for($i = 0; $i < count($_POST['ocasiones']); $i++){ 
				$query = new Consulta("INSERT INTO productos_ocasiones
							VALUES ('".$id_producto."',
									'".$_POST['ocasiones'][$i]."',
									'".$cat."') ");
			}		
		}
		
		//init update destinatarios
		new Consulta("DELETE FROM productos_destinatarios WHERE id_producto = '".$id_producto."' ");		
		if($_POST['destinatarios']){			
			for($i = 0; $i < count($_POST['destinatarios']); $i++){ 
				$query = new Consulta("INSERT INTO productos_destinatarios
							VALUES ('".$id_producto."',
									'".$_POST['destinatarios'][$i]."',
									'".$cat."') ");
			}		
		}
		
		//init update expresiones
		new Consulta("DELETE FROM productos_expresiones WHERE id_producto = '".$id_producto."' ");		
		if($_POST['expresiones']){			
			for($i = 0; $i < count($_POST['expresiones']); $i++){ 
				$query = new Consulta("INSERT INTO productos_expresiones
							VALUES ('".$id_producto."',
									'".$_POST['expresiones'][$i]."',
									'".$cat."') ");
			}		
		}		
		//init update expresiones
		new Consulta("DELETE FROM productos_tipos WHERE id_producto = '".$id_producto."' ");		
		if($_POST['tipos']){
			for($i = 0; $i < count($_POST['tipos']); $i++){ 
				$query = new Consulta("INSERT INTO productos_tipos
							VALUES ('".$id_producto."',
									'".$_POST['tipos'][$i]."',
									'".$cat."') ");
			}		
		}
		
		//init update complementos
		new Consulta("DELETE FROM productos_complementos WHERE id_producto = '".$_GET['id']."' ");		
		if( isset($_POST['complementos']) && count($_POST['complementos'])>0 ){
			foreach($_POST['complementos'] as $cmp){
				new Consulta("INSERT INTO productos_complementos VALUES ('','".$_GET['id']."', '".$cmp."')");
			}			
		}
		
		
                
		$this->_msgbox->setMsgbox('Se actualizo correctamente.',2);
                location("productos.php?cat=".$cat);
	}
	
	public function deleteProductos($cat=0){
		$query = new Consulta("DELETE  FROM productos WHERE id_producto = '".$_GET['id']."'");
		$query = new Consulta("DELETE  FROM productos_imagenes WHERE id_producto = '".$_GET['id']."'");
		
		$this->_msgbox->setMsgbox('Se elimino correctamente.',2);
		location("productos.php?cat=".$cat);
	}
	
	public function listProductos($cat=0){
		unset($_SESSION['list_insumos']);
		
		
		$idc = ($cat > 0) ? $cat : 0;
		
		$sql = " SELECT * FROM categorias 
					WHERE id_parent  =  ".$idc."					
					ORDER BY orden_categoria ASC";
						
		$query = new Consulta($sql);        
		
		$sqlp = " SELECT * FROM productos 
						WHERE id_categoria =  ".$idc."													
						AND estado_producto = 1
						ORDER BY orden_producto ASC";	
						
		$queryp = new Consulta($sqlp);	
		?>
        <div id="content-area">
            <table cellspacing="1" cellpading="1" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left">Categorias / Productos</th>
                        <th align="left">Descripción</th>
                        <th align="center" width="100" class="titulo">Opciones</th>
                   </tr>
                </thead>
            </table>	
            <ul id="listadoul" title="ordenarCatProd">
			 <?php
				$y = 1;
				while($row = $query->VerRegistro()){?>
					 <li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="list_item_<?php echo $row['id_categoria']."|cat"; ?>">
						<div class="data"><img src="<?php echo _admin_ ?>folder.png" class="handle"> <?php echo $row['nombre_categoria'] ?></div>
                                                <div class="data"> <?php echo substr($row['descripcion_categoria'], 0, 50) ?>...</div>
						<div class="options">
                                                    <?php if ($this->_usuario->getRol()->getNombre() == "Administrador") {?>
							<a class="tooltip move" title="Ordenar ( Click + Arrastrar )"><img src="<?php echo _admin_ ?>move.png" class="handle"></a>&nbsp;
							<a title="Editar" class="tooltip" href="productos.php?id=<?php echo $row['id_categoria'] ?>&actioncat=edit&ide=<?php echo $row['id_categoria'] ?>"><img src="<?php echo _admin_ ?>edit.png"></a>&nbsp;
							<a title="Eliminar"  href="#" class="tooltip" onClick="mantenimiento_cat('productos.php','<?php echo $row['id_categoria'] ?>','delete&ide=<?php echo $row['id_categoria'] ?>')"><img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;
							<a title="Ver Productos" class="tooltip"  href="productos.php?cat=<?php echo $row['id_categoria'] ?>&action=list"><img src="<?php echo _icons_ ?>zoom.png"></a>&nbsp;
                            
                             <input title="mover Categoria a" type="checkbox" name="move[]" value="<?php echo $row['id_categoria']?>|cat">
                            
						  <?php }else{?>
                                                        <a title="Ver Productos" class="tooltip"  href="productos.php?cat=<?php echo $row['id_categoria'] ?>&action=list"><img src="<?php echo _icons_ ?>zoom.png"></a>&nbsp;



                                                        <?php } ?>
                                                </div>
						</li>
				<?php
					$y++;
				}
				$y = 1;
				while($rowp = $queryp->VerRegistro()){
					?>
					 <li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="list_item_<?php echo $rowp['id_producto']."|prod"; ?>">
						<div class="data"> <img src="<?php echo _admin_ ?>file.png" class="handle">   <?php echo $rowp['nombre_producto'] ?></div>
						<div class="options">
                                                    <?php if ($this->_usuario->getRol()->getNombre() == "Administrador") {?>
							<a class="tooltip move"  title="Ordenar ( Click + Arrastrar )"><img src="<?php echo _admin_ ?>move.png" class="handle"></a>&nbsp;
							<a title="Editar" class="tooltip" href="productos.php?id=<?php echo $rowp['id_producto'] ?>&action=edit">
							<img src="<?php echo _admin_ ?>edit.png"></a> &nbsp;
							<a title="Eliminar" class="tooltip" onClick="mantenimiento('productos.php','<?php echo $rowp['id_producto'] ?>','delete')"  href="#"> <img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;
							
                            <a title="Imagenes" class="tooltip" href="productos.php?id=<?php echo $rowp['id_producto'] ?>&action=imagenes"> <img src="<?php echo _admin_ ?>photo_upload.png"></a>&nbsp;
                            
                            <!--<a title="Relacionar" class="tooltip" href="productos.php?id=<?php echo $rowp['id_producto'] ?>&action=relacionar"> <img src="<?php echo _admin_ ?>relations.png"></a>&nbsp;-->
                           
                           <input title="mover Productos a" type="checkbox" name="move[]" value="<?php echo $rowp['id_producto']?>|prod">
                           
                           <!-- <a title="Añadir atributo" class="tooltip" href="productos.php?id=<?php echo $rowp['id_producto'] ?>&action=atributos"> <img src="<?php //echo _admin_ ?>add_atribute.png"></a>&nbsp;-->
                           
                            
                            
							<?php }else{?>
                                                        
                                                        <?php } ?>
                                                </div>
						 </li>
				<?php
					$y++;
					}
				?>
             </ul>
             
             <div id="allcategoriasMove" title="Seleccione la categoria donde moverá el item">
             	<strong>Categorias </strong><br/><br/>
				
				
                <input type="radio" name="select_move_categoria" value="0"><strong>Raíz</strong><br/><br/>
				
				<?php 
					$categorias = new Categorias();
					$cats = $categorias->getCategorias('',0);
				?>
                <ul>
                	<?php 
					foreach( $cats as $cat ){
					
							
							//VALIDATION NO CHECK
							/*$catst2 = $categorias->getCategorias('',$cat['id']);
	                        if( count($catst2)>0 ){
								?>
                                <li><input type="radio"  name="select_move_categoria" value="<?php echo $cat['id']?>"><strong><?php echo $cat['nombre']?></strong>
								<?php	
							}else{*/
								?>
                                <li><input type="radio"  name="select_move_categoria" value="<?php echo $cat['id']?>"><strong><?php echo $cat['nombre']?></strong>
								<?php
							//}
						
					?>
                    
                    	<?php
						$cats2 = $categorias->getCategorias('',$cat['id']);
                        if( count($cats2)>0 ){
							?>
							<ul>
                            <?php foreach($cats2 as $cat2){?>                            
                            
							<?php
                            	                            
							//VALIDATION NO CHECK
							/*$catst3 = $categorias->getCategorias('',$cat2['id']);
	                        if( count($catst3)>0 ){
								?>
                                <li><strong><?php echo $cat2['nombre']?></strong>
								<?php	
							}else{*/
								?>
                                <li><input type="radio"  name="select_move_categoria" value="<?php echo $cat2['id']?>"><strong><?php echo $cat2['nombre']?></strong>
								<?php
							//}  
                            ?>    
                            
                            		
                                    
                                    <?php
									$cats3 = $categorias->getCategorias('',$cat2['id']);
									if( count($cats3)>0 ){
										?>
										<ul>
										<?php foreach($cats3 as $cat3){?>
										
                                        
                                        
                                        
                                        <li><input type="radio"  name="select_move_categoria" value="<?php echo $cat3['id']?>"><?php echo $cat3['nombre']?>
										
											
											
											
										
										</li>
										<?php
										}
										?>
										</ul>						
									<?php
									
									}
													
                             ?>   
                                
                            
                            </li>
                            <?php
							}
							?>
							</ul>						
                        <?php
						
                        }
						
						?>
                    </li>
                    	
                    <?php 
					}
					?>
                </ul>
                
             </div>
             
        </div>
        <?php
		
	}	
	
	public function getProductos(){
		$sql = "SELECT * FROM productos WHERE id_usuario  = '".$this->_usuario->getId()."' AND estado_producto = 1 ORDER BY orden_producto";
		$query_p = new Consulta($sql);
		while($row_p = $query_p->VerRegistro()){
			$data[] = array(
				'id'		=> $row_p['id_producto'],
				'nombre' 	=> $row_p['nombre_producto'],
			);
		}
		return $data;
	}

	public function getTotalProductosHome(){
		$sql = "SELECT * FROM productos ORDER BY fecha_ingreso DESC LIMIT 0,9 ";
				
		$query_p = new Consulta($sql);
		return $query_p->NumeroRegistros();
	}
	
	public function getTotalProductosrelacion($id=0){
		$sql = "SELECT * 
				FROM productos p, productos_relacionados pr WHERE p.id_producto=pr.id_producto AND p.id_producto ='".$id."'";
				
		$query_p = new Consulta($sql);
		return $query_p->NumeroRegistros();
	}
	
	public function getProductosRelacion($id=0, $i=0, $f=0){
			
		$sql = "SELECT * FROM productos_relacionados WHERE id_producto ='".$id."' ORDER BY id_producto DESC   LIMIT $i,$f";	
		
		$query = new Consulta($sql);

		while($row = $query->VerRegistro()){
			$data[] = array(
				'id'		=> $row['id_producto_relacionado']	
			);
		}
		return $data;
	}
	
	public function getProductosOfertas(){
		$sql = "SELECT * FROM ofertas";	
		$query = new Consulta($sql);

		while($row = $query->VerRegistro()){
			$data[] = array(
				'id'		=> $row['id_producto']	
			);
		}
		return $data;
	}
	 
	static public function getProductosDestacados($cantidad=6){
		$sql = "SELECT * FROM productos WHERE destacado_producto ='1' AND estado = 1 AND is_complemento=0 AND estado_producto = 1 ORDER BY RAND() LIMIT 0,$cantidad";
		//$sql = "SELECT * FROM productos WHERE destacado_producto ='1' AND is_complemento=0 AND estado_producto = 1 ORDER BY id_categoria ASC";	
		$query = new Consulta($sql);

		while($row = $query->VerRegistro()){
			$data[] = array(
				'id'		=> $row['id_producto']	
			);
		}
		return $data;
	}
	

	public function orderProductos($cat=0){
		$query = new Consulta("SELECT MAX(orden_producto) max_orden 
									FROM productos WHERE id_categoria = '".$cat."' AND estado_producto = 1");
		
		$row   = $query->VerRegistro();
		return (int)($row['max_orden']+1);
	}
	
	function imagenesProductos($cat){
		
		ini_set("memory_limit","50M");
		
		if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
			
			//$ftmp   = $_FILES['image']['tmp_name'];
			//$nombre = time().$_FILES['image']['name'];
			//$fname  = '../app/publicroot/imgs/catalogo/'.$nombre; 
			
			//if(isset($_FILES['image']) && $_FILES['image']['name'] != "" ){		
				
			$ext = explode('.',$_FILES['image']['name']); 
			$nombre_file = time().sef_string($ext[0]);
			$type_file = typeImage($_FILES['image']['type']);				
			$nombre = $nombre_file . $type_file;
			
			
			define("NAMETHUMB", "/tmp/thumbtemp");
			$thumbnail = new ThumbnailBlob(NAMETHUMB,'../app/publicroot/imgs/catalogo/thumb_');
			$thumbnail->CreateThumbnail(60,60,$nombre);	
			
			define("NAMETHUMB", "/tmp/thumbtemp");
			$thumbnail = new ThumbnailBlob(NAMETHUMB,'../app/publicroot/imgs/catalogo/big_');
			$thumbnail->CreateThumbnail(630,576,$nombre);		
			
			define("NAMETHUMB", "/tmp/thumbtemp");
			$thumbnail = new ThumbnailBlob(NAMETHUMB,'../app/publicroot/imgs/catalogo/middle_');
			$thumbnail->CreateThumbnail(250,250,$nombre);				
			//}
				
			//if(move_uploaded_file($ftmp, $fname)){			
				$queryU = new Consulta("INSERT INTO productos_imagenes VALUES('','".$_GET['id']."', '".'thumb_'.$nombre."', '".'big_'.$nombre."', '".'middle_'.$nombre."','".$nombre."','')"); 							 
			//} ?>
			<script> location.replace("productos.php?id=<?php echo $_GET['id'] ?>&action=imagenes") </script> <?php
		}
		$obj = new Producto($_GET['id'], $this->_idioma);
		$imagenes = $obj->__get("_imagenes");
		 ?>
		<div id="mantinance">
			<fieldset id="form">				
				<legend> Galeria de Imagenes </legend> 
				<form name="f1" id="f1" method="post" enctype="multipart/form-data" action="productos.php?id=<?php echo $_GET['id'] ?>&action=imagenes"   >
				<div id="iframe">
					<div class="ileft_img" >	
						<label for="imagen">Imagen : </label>
						<input id="file" type="file" name="image" size="31" />
					</div>
					<div class="iright_img"> <button onclick="return valida_imgs('galeria')" class="button">SUBIR IMAGEN</button> </div>
					<div class="both"></div>					
				</div>					
				
				<div id="images">					
					<div class="lefti" id="sorter_imgs" > <?php  
						if(is_array($imagenes) && count($imagenes) > 0){
							for($i=0; $i < count($imagenes); $i++){ ?>
								<div id="list_item_<?php echo $imagenes[$i]['id'];?>|<?php echo $_GET['id']?>" class="imagen<?php echo $imagenes[$i]['id'];?>"> 
									<input type="checkbox" name="chkimag" value="<?php echo $imagenes[$i]['id'];?>"/>
									<a title="../app/publicroot/imgs/catalogo/<?php echo "middle_".$imagenes[$i]['imagen'];?>">
									<?php echo $imagenes[$i]['imagen'];?> </a>
								</div> <?php
							}  
						} ?>
						<p id="msg_delete"> </p>						
	 				</div>	
					<div class="righti" id="imgs"><?php if(!empty($imagenes[0]['imagen'])){ ?>
						<table width="100%" height="100%">
                        	<tr><td valign="middle" align="center"><img src="../app/publicroot/imgs/catalogo/<?php echo "middle_".$imagenes[0]['imagen'];?>" id="imgp"/></td></tr>
                        </table><?php 
						}else{	
							echo "<BR><BR><BR><BR><BR><BR><H3> SIN IMAGENES </H3>";
						} ?>
					</div><br clear="all" />
					<div class="bottom"><img src="<?php echo _icons_?>arrow_ltr.gif" border="0" height="13"/> Para eliminar una imagen activa su(s) respectiva(s) casilla de verificacion y haz cilck en [ <span onclick="javascript: delete_imagen('prod')" >ELIMINAR </span>  ].
					</div>
				</div>			
			</form>
			</fieldset>	
		</div> <?php		
	}
	
	
	function relacionarProductos($cat){
		
		$obj = new Producto($_GET['id'], $this->_idioma);
		$imagenes = $obj->__get("_imagenes");
		 ?>
		<div id="mantinance">
			<fieldset id="form">				
				<legend> Relaciones de productos </legend> 
				<form name="f1" id="f1" method="post"  action="productos.php?id=<?php echo $_GET['id'] ?>&action=relacionar"   >
                <input type="hidden" name="id_producto" id="id_producto" value="<?php echo $_GET['id'] ?>" />
				<div id="iframe">
					<div class="ileft_img" >	
						<label for="imagen">Categorias : </label>
						<?php 				
				$sql_prods = " SELECT * FROM categorias";				
				$query_prods = new Consulta($sql_prods); ?>
                <select name="categorias" id="categorias" onChange="cargarProducto();">
                    <option value="0">Seleccione Categoria...</option> <?php
					while($row_prods=$query_prods->VerRegistro()){ ?>
						<option value="<?php echo $row_prods['id_categoria']?>" <?php if($row_prods['id_categoria']==$_POST['categorias']){ echo "selected";}?>>
						<?php echo $row_prods['nombre_categoria']?>
						</option> 
					<?php	} ?>
                </select>
                <input type="submit" name="btn_buscar" value="Filtrar" />
					</div>
					
					<div class="both"></div>					
				</div>					
			
		 <div id="contenedor">              	
        
        <br clear="all" />  
         
        <table cellspacing="1" cellpading="1" class="listado">
           <thead>
		      <tr class="head">
                 <th align="center" width="117" class="titulo">Relacionar</th>
                 <th class="titulo" colspan="2">Productos</th>     
              </tr>
           </thead>
                        
         <?php        
         if(isset($_POST['categorias'])){ 
		             		
		    $sqlp = " SELECT * FROM productos 
				      WHERE id_categoria =  ".$_POST['categorias']." 
					  AND id_producto NOT IN('".$_GET['id']."')
				      AND estado_producto = 1
					  ORDER BY orden_producto ASC";
						  	
		    $queryp = new Consulta($sqlp);				  
        ?>
       	<?php
		$y = 1;
		if($queryp -> NumeroRegistros() > 0){
			while($rowp = $queryp->VerRegistro()){
				$producto = new Producto($rowp['id_producto'],$this->_idioma);
				
				
				$querys = new Consulta("SELECT * FROM productos_relacionados 
										WHERE id_producto = '".$_GET['id']."' 
										AND id_producto_relacionado = '".$producto->__get("_id")."'");
				?>
				<tr class="row <?php echo ($y % 2 == 0) ? 'odl' : ''; ?>" <?php if($querys->NumeroRegistros() > 0){ ?> style="background:#D5FFD5" <?php }?>>
					<td align="center"> <input type="checkbox" name="chkimag" <?php if($querys->NumeroRegistros() > 0){ echo 'checked="checked"'; }?> value="<?php echo $producto->__get("_id");?>" onclick="saveRelacion(this.value)"/></td>
					<td width="36" align="center">
                    <!--<img src="../app/publicroot/imgs/catalogo/<?php echo $producto->__get("_imagen") ?>" width="54" height="85">-->
                    </td>
					<td width="78" valign="middle">&nbsp; <?php echo $rowp['nombre_producto'] ?></td>
				</tr>
				 
			<?php 
			$y++;                   	
		}
	}else{
		?><tr class="fila2"><td colspan="3" align="center" style="color:#B53E15;">No hay solucionarios en esta categoria!</td></tr>
		<?php	
	}
		 }
	?>
                        
                     
                      
        </table>
   
             
  
                
					<br clear="all" /><br clear="all" /><br clear="all" />
					<div class="bottom"><img src="<?php echo _icons_?>arrow_ltr.gif" border="0" height="13"/> Para relacionar un producto sellecciones el check del producto (s), respectivamente(s) .
					</div>
 </div>  			
			</form>
			</fieldset>	
            
		</div> <?php		
	}
        
    static public function getIdByName($nombre){
        
        $sql = "SELECT id_producto FROM productos WHERE nombre_producto = '".trim($nombre)."' AND estado_producto = 1 ";            
        $query = new Consulta($sql);
        $row = $query->VerRegistro();
        return $row['id_producto'];            
    }

    static public function getIdByUrl($url){
        
        $sql = "SELECT id_producto FROM productos WHERE url_producto = '".trim($url)."' AND estado_producto = 1 ";    
        $query = new Consulta($sql);
        $row = $query->VerRegistro();
        return $row['id_producto'];            
    }
		
		
	public function atributosProductos(){
		$obj = new Producto($_GET['id'], $this->_idioma);
		$imagenes = $obj->__get("_imagenes");
		
		$obj_atr = new Atributos( $this->_msgbox , $this->_usuario );
		$atributos = $obj_atr->getAtributos();
		 ?>
		<div id="mantinance">
			<fieldset id="form">				
				<legend> Asignacion de Atributos </legend>                 
                <form action="" method="post" name="asignacion_atributos" id="asignacion_atributos" >             	
            	<input type="hidden" name="moneda" id="moneda" value="<?php echo _moneda_?>">
                <div class="button-actions">
                	<input type="button" name="" value="GUARDAR" onclick="return valida_atributos()"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
               	
                <li><label> Atributo : </label>
                <select name="atributos" id="atributos" class="noestile" onChange="cargarValores();">
                    <option value="0">Seleccione Atributo...</option> <?php
					foreach ( $atributos as $atributo ):?>
						<option value="<?php echo $atributo['id']?>"><?php echo $atributo['nombre']?></option> 
					<?php endforeach; ?>
                    
                </select>                
                </li>	
                <li><label> Valor : </label>
                <select name="valor_atributo" id="valor_atributo" class="noestile">
                    <option value="0">Seleccione Valor...</option>                     
                </select>                
                </li>
                <li><label> Prefijo : </label>
                	<select name="prefijo" id="prefijo" class="noestile">
                    	<option value="0">Seleccione Prefijo...</option>                     
                        <option value="+">Aumenta el precio ( + )</option>
                        <option value="-">Disminuye el precio ( - )</option>
                    </select>
                </li> 
                
                <li><label> Precio : </label>  <input type="text" class="text ui-widget-content ui-corner-all JQprecio precio" dir="rtl" size="23" id="precio_valor_atributo"  name="precio_valor_atributo"></li> 
                
                 <li><label> Stock : </label>  <input type="text" class="text ui-widget-content ui-corner-all solo_numero" dir="rtl" size="23" id="stock_valor_atributo"  name="stock_valor_atributo"></li> 
                 
                </ul>
                <input type="hidden" name="producto" value="<?php echo $_GET['id'];?>">
          		</form>
            <div id="content-area">
            <table cellspacing="1" cellpading="1" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left">Producto</th>
                        <th align="left">Atributo</th>
                        <th align="left">Valor</th>
                        <th align="left">Prefijo</th>
                        <th align="left">Precio</th>
                        <th align="left">Stock</th>
                        <th align="center" width="100" class="titulo">Opciones</th>
                   </tr>
                </thead>
            </table>	
            <ul id="listadoul" class="listAttr">
			 <?php
				$y = 1;
				foreach ( $obj->__get("_atributos") as $atr ):				
					?>
					 <li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="<?php echo $atr['id_pav']?>" >
						<div class="data att0"> <img src="<?php echo _admin_ ?>file.png" class="handle">   <?php echo $obj->__get("_nombre"); ?></div>
                        <div class="data att1"><?php echo $atr['nombre'] ?></div>
						<div class="data att2"><?php echo $atr['valor'] ?></div>
                        <div class="data att3"><?php echo $atr['prefijo'] ?></div>
                        <div class="data att4 JQprecio"><?php echo $atr['precio'] ?></div>
                        <div class="data att5"><?php echo $atr['stock'] ?></div>
                        <div class="options att">
							<a title="Editar" class="tooltip" onClick="popupAtributo('<?php echo $atr['id_pav'] ?>')"  href="#"> <img src="<?php echo _admin_ ?>edit.png"></a>&nbsp;
                            <a title="Eliminar" class="tooltip" onClick="deleteAtributo('<?php echo $atr['id_pav'] ?>','<?php echo $atr['id_pa']?>')"  href="#"> <img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;                           
                             </div>
						 </li>
				<?php
					$y++;
					endforeach;					
				?>
             </ul>
        </div>  
		</fieldset>	
        <div class="dialog-form" title="Editar Atributo">
       	<div id="nav_pop_up"></div>
        <fieldset id="form">				
				<legend>Editar Atributo</legend>
                <form action="" method="post" name="popup_editar_atributos" id="popup_editar_atributos" >  
                	<ul>
                         <li><label> Prefijo : </label>  <input id="pop_up_prefijo" type="text" class="text ui-widget-content ui-corner-all prefijo_atr" dir="rtl" size="23"  name="prefijo_valor_atributo"></li> 
                        
                          <li><label> Precio : </label>  <input  id="pop_up_precio"  type="text" class="text ui-widget-content ui-corner-all JQprecio" dir="rtl" size="23"  name="precio_valor_atributo"></li>  
                        
                        <li><label> Stock : </label>  <input id="pop_up_stock" type="text" class="text ui-widget-content ui-corner-all solo_numero" dir="rtl" size="23"  name="stock_valor_atributo"></li> 
                      
                        <input type="hidden" id="id_atributo" name="id_atributo" value="">
                        <input type="hidden" id="producto" name="producto" value="">
                        <input type="hidden" id="atributo" name="atributo" value="">
                        <input type="hidden" id="valor" name="valor" value=""> 
                    </ul>
                </form>
        </fieldset>	
        </div>
        	
        <?php
	}
	
	public function getProductosByCatXComplementos( $cat ){
		$data = array();
		$query = new Consulta("SELECT * FROM productos WHERE  estado = 1 AND id_categoria='".$cat."' AND estado_producto = 1");
		while( $row = $query->VerRegistro() ){
			$data[] = array(
					'id'		=> $row['id_producto'],
					'nombre' 	=> $row['nombre_producto']
			 );
		}	
		return $data;
	}
	
	public function getProductosByCatXComplementosSelected($id){
		$data = array();
		$sql = "SELECT id_complemento FROM productos_complementos WHERE estado = 1 AND id_producto='".$id."' ORDER BY id_producto_complemento ASC";
		$query = new Consulta($sql);
		while( $row = $query->VerRegistro() ){
			$prod = new Producto($row['id_complemento']);
			$data[] = array(
					'idselect'		=> $row['id_complemento'],
					'nombre'		=> $prod->__get("_nombre")
			 );
		}	
		return $data;
	}
	
	public function getProductosByCat( $cat ){
		$data = array();
		$query = new Consulta("SELECT * FROM productos WHERE id_categoria='".$cat."' AND estado = 1 AND estado_producto = 1");
		while( $row = $query->VerRegistro() ){
			$data[] = array(
					'id'		=> $row['id_producto'],
					'nombre' 	=> $row['nombre_producto']
			);
		}		
		return $data;
	}

	public function getAllProductos(){
	
	$data = array();
		$query = new Consulta("SELECT * FROM productos WHERE estado = 1 AND estado_producto = 1");
		while( $row = $query->VerRegistro() ){
			$data[] = array(
					'id'		=> $row['id_producto'],
					'nombre' 	=> $row['nombre_producto']
			 );
		}		
		
		return $data;
	
	}
	
	public function getAllProductosPedidos($id_producto){
	
	$data = array();
		$query = new Consulta("SELECT id_pedido FROM pedidos_productos WHERE estado = 1 AND id_producto = '".$id_producto."'");
		while( $row = $query->VerRegistro() ){
			array_push($data,$row['id_pedido']);
		}		
		
		return $data;
	}
	public function complementosXProducto(){ ?>   
         
            <div id="cp_seleccionados" class="col-xs-12 col-sm-12 col-md-12">  
                <ul id="complementos_seleccionados">
            	<?php
                    $id = $_GET['id'];
                    $sqlall = "SELECT * FROM productos WHERE is_complemento='1' AND estado_producto = 1 AND estado = 1";				
                    $queryall = new Consulta($sqlall);
                    while($rowpc = $queryall->VerRegistro()){
                        $cmpall[] = array(
                            'id'  => $rowpc['id_producto'],
                            'nombre'  => $rowpc['nombre_producto'],
                        );
                    }

                    $prod2 = new Producto($id);				
                    $cmpselect = $prod2->__get('_complementos');

                    //pre($cmpselect);
                    if(count($cmpall) > 0){					
                        foreach($cmpall as $value){
                            $prod = new Producto($value['id']); ?>
                            <li><input type="checkbox" name="complementos[]"  <?php 
                            foreach( $cmpselect as $key ){
                                if( $key['id'] == $value['id'] ){
                                    echo  'checked="checked"';
                                }
                            }?> value="<?php echo $value['id'];?>" id="chk-<?php echo $value['id'];?>">
                            <label for="chk-<?php echo $value['id'];?>"><b><?php echo $prod->__get("_categoria")->__get("_nombre")?></b> > <?php echo $prod->__get("_nombre")?></label></li><?php
                        }
                    }else{ ?>
                    <li>No tiene ningun complemento</li> <?php
		} ?>
            </ul>
            </div>  <?php 
	}
	
	public function insumosXProductoNuevo(){
            $datos = $_SESSION['list_insumos'];
            $ndatos = count($datos);  ?>
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr class="cabecera">
            <th scope="col" width="10">Cant.</th>
            <th scope="col">Descripción Insumo</th>
            <th scope="col" width="30">Opciones</th>
          </tr>
          <?php for($i=0;$i<$ndatos;$i++){?>
          <tr class="cuerpo <?php if($i%2==0){echo 'par';}?>">
            <td align="center"><?php echo $datos[$i][2];?></td>
            <td align="left"><?php echo $datos[$i][1];?></td>
            <td align="center"><img src="../aplication/webroot/imgs/icons/button_edit.png" class="editar_insumo" id="<?php echo $i;?>" />&nbsp;
            <img src="../aplication/webroot/imgs/icons/button_drop.png" class="eliminar_insumo" data-id="<?php echo $i;?>" /></td>
          </tr>
          <?php }?>
        </table>
        <?php
	}

    static public function getProductosRecomendados($cantidad,$categoria)
    {
        $query = new Consulta("SELECT * FROM productos WHERE id_categoria = '" . $categoria . "' AND is_complemento=0 AND estado_producto = 1 ORDER BY RAND() LIMIT 0,".$cantidad.""); 
        while( $row = $query->VerRegistro() ){
            $data[] = array(
                    'id'        => $row['id_producto'],
                    'nombre'    => $row['nombre_producto']
             );
        }       
        return $data;
    }
    static public function getProductosByCatAll($cat=0)
    {
        $data = array();
        $query = new Consulta("SELECT * FROM productos WHERE id_categoria = ".$cat." ");
        while( $row = $query->VerRegistro() ){
            $data[] = array(
                    'id'        => $row['id_producto'],
                    'nombre'    => $row['nombre_producto']
            );
        }       
        return $data;
    }


	static public function treeProductos(){
        $lista_categorias = Categorias::getCategoriasForTree('',0);
        foreach ($lista_categorias as $cate) {
            $obj_cate = new Categoria($cate['id']);
            $lista_subcategorias = Categorias::getCategoriasForTree('',$obj_cate->__get('_id'));
            ?>
            <ul>
                <li identifica="<?php echo $obj_cate->__get('_id') ?>" categoriapadre="<?php echo $obj_cate->__get('_id') ?>">
                    <?php echo $obj_cate->__get('_nombre') ?>

                    <ul>
                    <?php if ($lista_subcategorias): ?> 
                        <?php foreach ($lista_subcategorias as $subcat): ?>
                        <?php $obj_sub_cat = new Categoria($subcat['id']) ?>
                            <li identifica="<?php echo $obj_sub_cat->__get('_id') ?>" categoriapadre="<?php echo $obj_sub_cat->__get('_id') ?>">
                                <?php echo $obj_sub_cat->__get('_nombre') ?>
                                <ul>
                                    <?php 
                                    $lista_pro = Productos::getProductosByCatAll($obj_sub_cat->__get('_id'));
                                    if ($lista_pro) {
                                        foreach ($lista_pro as $pro) { ?>
                                            <li data-jstree='{ "icon" : "fas fa-gift fa-lg text-green" }' dataproducto='<?php echo $pro['id'] ?>'><?php echo $pro['nombre'] ?></li>
                                        <?php }
                                    }
                                    ?>
                                </ul>
                            </li>
                        <?php endforeach ?>
                    <?php endif ?>
                    <?php /*DEBO BUSCAR SI HAY PRODUCTOS EN ESTA CATEGOTIA PADRE*/
                    $lista_pro = Productos::getProductosByCatAll($obj_cate->__get('_id'));
                    if ($lista_pro) {
                        foreach ($lista_pro as $pro) { ?>
                            <li data-jstree='{ "icon" : "fas fa-gift fa-lg text-green" }' dataproducto='<?php echo $pro['id'] ?>'><?php echo $pro['nombre'] ?><i class="fas fa-star"></i></li>
                        <?php }
                    }
                    ?>
                    </ul>
                
                </li>
                
            </ul>
            <?php
        }
    }

    static public function getComplementosDisponibles(){
        $data = array();
        $query =  new Consulta("SELECT * FROM productos WHERE is_complemento='1' AND estado_producto = 1 AND estado = 1");
        while( $row = $query->VerRegistro() ){
            $data[] = $row['id_producto'];
        }       
        return $data;
    }

    static public function editProductoTabDescription(){
        if ($_POST['id']) {
            $obj_pro = new Producto($_POST['id']);
            ?>
            <form id="edit-categoria" method="post">
                <input type="hidden" value="<?php echo $obj_pro->__get('_id') ?>" name="edit_id"> 
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Nombre</label>
                    <div class="col-md-9">
                        <input type="text" name="edit_nombre" class="form-control" placeholder="" value="<?php echo $obj_pro->__get('_nombre') ?>" />
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Descripción Corta</label>
                    <div class="col-md-9">
                        <textarea type="text" name="edit_descripcion_corta" class="form-control" rows="3"><?php echo $obj_pro->__get('_descripcion_corta') ?></textarea>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Descripción</label>
                    <div class="col-md-9">
                        <textarea type="text" name="edit_descripcion" class="form-control" rows="7"><?php echo $obj_pro->__get('_descripcion') ?></textarea>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Url</label>
                    <div class="col-md-9">
                        <input type="text" name="edit_url" class="form-control" placeholder="" value="<?php echo $obj_pro->__get('_url') ?>" />
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row m-b-10">
                            <label class="col-md-3 col-form-label">Precio</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="text" class="form-control text-right" value="<?php echo $obj_pro->__get('_precio_producto') ?>" name="edit_precio">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row m-b-10">
                            <label class="col-form-label col-md-3">Cantidad</label>
                            <div class="col-md-9">
                                <input type="text" name="edit_cantidad" class="form-control text-right" placeholder="" value="<?php echo $obj_pro->__get('_stock') ?>" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row m-b-10">
                            <label class="col-md-6 col-form-label">Activo <i class="fas fa-star text-success"></i></label>
                            <div class="col-md-6 p-t-3 m-b-10">
                                <div class="switcher switcher-success">
                                    <input type="checkbox" name="edit_activo" id="edit_activo" <?php echo($obj_pro->__get('_estado')=='1')?'checked=""':'' ?> >
                                    <label for="edit_activo"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row m-b-10">
                            <label class="col-md-6 col-form-label">Destacado <i class="fas fa-star text-yellow-lighter"></i></label>
                            <div class="col-md-6 p-t-3 m-b-10">
                                <div class="switcher switcher-warning">
                                    <input type="checkbox" name="edit_destacado" id="edit_destacado" <?php echo($obj_pro->__get('_destacado')=='1')?'checked=""':'' ?> >
                                    <label for="edit_destacado"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row m-b-10">
                            <label class="col-md-6 col-form-label">EsComplemento <i class="fas fa-star text-indigo-lighter"></i></label>
                            <div class="col-md-6 p-t-3 m-b-10">
                                <div class="switcher switcher-indigo">
                                    <input type="checkbox" name="edit_is_complemento" id="edit_is_complemento" <?php echo($obj_pro->__get('_is_complemento')=='1')?'checked=""':'' ?> >
                                    <label for="edit_is_complemento"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </form>
            <div class="text-center">
                <!-- <button class="btn btn-green" onclick="actualizarDescripcionProducto()">Actualizar Producto</button> -->
            </div>
        <?php
        }
    }

    static public function editProductoTabInsumos(){
        if ($_POST['id']) {
            $obj_pro = new Producto($_POST['id']);
            $insumos_utilizados = $obj_pro->__get('_insumos');
            $lista_insumos = Insumos::getInsumos();
            $total_lista_insumos = count($lista_insumos);
            ?>
            <input type="hidden" id="id_producto_for_insumos" value="<?php echo $obj_pro->__get('_id') ?>">
            <div class="table-responsive">
                <table class="table table-striped table-hover m-b-0">
                    <thead>
                        <tr>
                            <th class="width-xs">Seleccionado (Azul)</th>
                            <th>Descripcion</th>
                            <th class="width-xs">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i < $total_lista_insumos; $i++){
                            $cantidad = 1;
                            $checked = "";
                            if(is_array($insumos_utilizados[$lista_insumos[$i]["id"]])){ 
                                $checked = "checked='checked'";
                                $cantidad = $insumos_utilizados[$lista_insumos[$i]["id"]][1];
                            } 
                        ?>
                        <tr class="tr-producto-insumo">
                            <td class="with-checkbox width-xs">
                                <div class="checkbox checkbox-css">
                                    <input type="checkbox" class="check-insumo" value="<?php echo $lista_insumos[$i]['id']?>" id="check<?php echo $lista_insumos[$i]['id']?>" <?php echo $checked ?> />
                                    <label for="check<?php echo $lista_insumos[$i]['id']?>">&nbsp;</label>
                                </div>
                            </td>
                            <td class="with-input-group">
                                <?php echo $lista_insumos[$i]['nombre'] ?>
                            </td>
                            <td class="with-input-group width-xs">
                                <div class="input-group">
                                    <input type="number" class="form-control text-right cantidad-insumo" placeholder="0" value="<?php echo $cantidad ?>"/>
                                    <span class="input-group-addon f-s-14">und</span>
                                </div>
                            </td>
                        </tr> 
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
    }

    static public function editProductoTabComplementos(){
        if ($_POST['id']) {
            $obj_pro = new Producto($_POST['id']);
            $lista_comple_todos = Productos::getComplementosDisponibles();
            $lista_comple_usados = $obj_pro->__get('_complementos');
            $comple_disponible = array();
            foreach ($lista_comple_usados as $comple_usado) {
                array_push($comple_disponible, $comple_usado['id']);
            }
            ?>
            <input type="hidden" id="id_producto_for_complement" value="<?php echo $obj_pro->__get('_id') ?>">
            <div class="table-responsive">
                <table class="table table-striped m-b-0">
                    <thead>
                        <tr>
                            <th class="width-xs">Selecionado(Azul)</th>
                            <th>Pic</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista_comple_todos as $comple): 
                            $obj_comple = new Producto($comple); 
                            $imgs = $obj_comple->__get('_imagenes');
                            $img = _catalogo_.$imgs[0]['thumbnail'];
                            $checked = "";
                            if (in_array($obj_comple->__get('_id'), $comple_disponible)) {
                                $checked = "checked='checked'";
                            }    
                        ?>
                        <tr>
                            <td class="with-checkbox width-xs">
                                <div class="checkbox checkbox-css">
                                    <input type="checkbox" class="check-complemento" value="<?php echo $obj_comple->__get('_id')?>" id="check<?php echo $obj_comple->__get('_id')?>" <?php echo $checked ?> />
                                    <label for="check<?php echo $obj_comple->__get('_id')?>">&nbsp;</label>
                                </div>
                            </td>
                            <td class="with-img">
                                <img src="<?php echo $img ?>" class="img-rounded height-30" title="img" />
                            </td>
                            <td><?php echo $obj_comple->__get('_nombre') ?></td>
                            <td><?php echo($obj_comple->__get('_estado')=='1')?'Activo':'Desactivado' ?></td>
                            <td class="text-right"><?php echo $obj_comple->__get('_stock') ?></td>
                            <td class="text-right">S/ <?php echo $obj_comple->__get('_precio_producto') ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
    }

    static public function insertImageProductos($nombre,$id){
        new Consulta("INSERT INTO productos_imagenes (id_producto,imagen_producto_imagen) VALUES (".$id.",'".$nombre."') ");
    }

    static public function editProductoTabImagenes(){
        if ($_POST['id']) {
            $obj_pro = new Producto($_POST['id']);
            $_SESSION['id_producto_edit'] = $obj_pro->__get('_id');
            $lista_imagenes = $obj_pro->__get('_imagenes');
            ?>
            <h3>Lista de imagenes actuales &nbsp;ID (<?php echo $obj_pro->__get('_id') ?>)</h3>
            <div class="table-responsive">
                <table class="table table-striped m-b-0">
                    <thead>
                        <tr>
                            <th class="width-xs">N°</th>
                            <th>Pre Visualizar</th>
                            <th>File</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($lista_imagenes): ?>
                        <?php foreach ($lista_imagenes as $image): ?>
                        <tr class="tr<?php echo $image['id'] ?>">
                            <td class="width-xs"><?php echo $image['id'] ?></td>
                            <td class="with-img">
                                <img src="<?php echo _imgs_.'files/thumbnail/'.$image['imagen'] ?>" class="img-rounded height-30" title="img" />
                            </td>
                            <td><?php echo $image['imagen'] ?></td>
                            <td><button class="btn btn-xs btn-danger" onclick="eliminarProImg(<?php echo $image['id'] ?>)">Eliminar</button></td>
                        </tr>
                        <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <form id="fileupload" action="<?php echo _imgs_ ?>" method="POST" enctype="multipart/form-data">
                <!-- begin panel -->
                <div class="panel panel-inverse">
                    <!-- begin panel-body -->
                    <div class="panel-body">            
                        <div class="note note-yellow m-b-15">
                            <div class="note-icon f-s-20">
                                <i class="fa fa-lightbulb fa-2x"></i>
                            </div>
                            <div class="note-content">
                                <h4 class="m-t-5 m-b-5 p-b-2">Subir Nuevas Imagenes</h4>
                                <ul class="m-b-5 p-l-25">
                                    <li>Puede arrastrar las imagenes que desea subir.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row fileupload-buttonbar">
                            <div class="col-md-7">
                                <span class="btn btn-primary fileinput-button m-r-3">
                                    <i class="fa fa-plus"></i>
                                    <span>Agregar</span>
                                    <input type="file" name="files[]" multiple directory webkitdirectory mozdirectory>
                                </span>
                                <button type="submit" class="btn btn-primary start m-r-3">
                                    <i class="fa fa-upload"></i>
                                    <span>Subir</span>
                                </button>
                                <button type="reset" class="btn btn-default cancel m-r-3">
                                    <i class="fa fa-ban"></i>
                                    <span>Cancelar Subida</span>
                                </button>
                                <button type="button" class="btn btn-default delete m-r-3">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    <span>Eliminar</span>
                                </button>
                                <!-- The global file processing state -->
                                <span class="fileupload-process"></span>
                            </div>
                            <!-- The global progress state -->
                            <div class="col-md-5 fileupload-progress fade">
                                <!-- The global progress bar -->
                                <div class="progress progress-striped active m-b-0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                </div>
                                <!-- The extended global progress state -->
                                <div class="progress-extended">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                    <!-- end panel-body -->
                    <!-- begin table -->
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th width="10%">PREVIEW</th>
                                <th>FILE INFO</th>
                                <th>UPLOAD PROGRESS</th>
                                <th width="1%"></th>
                            </tr>
                        </thead>
                        <tbody class="files">
                            <tr data-id="empty">
                                <td colspan="4" class="text-center text-muted p-t-30 p-b-30">
                                    <div class="m-b-10"><i class="fa fa-file fa-3x"></i></div>
                                    <div>No file selected</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
                <!-- end panel -->
            </form>
            <?php
        }
    }

    static public function deleteProductoImagen(){
        if ($_POST['id']) {
            new Consulta("DELETE FROM productos_imagenes WHERE id_producto_imagen = ".$_POST['id']." ");
            echo $_POST['id'];
        }
    }

    static public function editProductoTabFiltro(){
        if ($_POST['id']) {
            $obj = new Producto($_POST['id']);
            $lista_filtros_principales = Filtros::getFiltrosForTree('',0);
            $filtros_usados = $obj->__get('_filtros');
            ?>
            <h3>Filtros Asignados a: <?php echo $obj->__get('_nombre') ?></h3>
            <input type="hidden" id="id_producto_for_select" value="<?php echo $obj->__get('_id') ?>">
            <div class="form-group row">
                <label class="col-md-4 col-form-label">Filtros Principales</label>
                <div class="col-md-8">
                    <select class="filtro-principal form-control" multiple="multiple">
                        <?php foreach ($lista_filtros_principales as $principal): ?>
                        <option <?php echo (in_array($principal['id'], $filtros_usados))?'selected="selected"':'' ?> value="<?php echo $principal['id'] ?>"><?php echo $principal['nombre'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label">Sub Filtros</label>
                <div class="col-md-8">
                    <select class="filtro-secundario form-control" multiple="multiple">
                        <?php foreach ($lista_filtros_principales as $principal): ?>
                        <?php $lista_sub = Filtros::getFiltrosForTree('',$principal['id']);?>
                        <?php if (count($lista_sub)>0): ?>
                        <optgroup label="<?php echo $principal['nombre'] ?>">
                        <?php foreach ($lista_sub as $sub): ?>    
                            <option <?php echo (in_array($sub['id'], $filtros_usados))?'selected="selected"':'' ?> value="<?php echo $sub['id'] ?>"><?php echo $sub['nombre'] ?></option>
                        <?php endforeach ?>
                        </optgroup>
                        <?php endif ?>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <?php
        }
    }

    static public function updateProductosFiltros(){
        if ($_POST['id']) {

            $datos1 = json_decode($_POST['datos1']);
            $datos2 = json_decode($_POST['datos2']);
            $array = array_merge($datos1,$datos2);
            /*Elimino las relaciones*/
            new Consulta("DELETE FROM productos_filtros WHERE id_producto = ".$_POST['id']." ");
            /*Ahora Inserto los nuevos filtros*/
            foreach ($array as $value) {
                new Consulta("INSERT INTO productos_filtros (id_producto,id_filtro) VALUES (".$_POST['id'].",".$value.") ");
            }
        }
    }

    static public function updateProductosComplementos(){
        if ($_POST['id']) {
            $datos = json_decode($_POST['datos']);
            /*Elimino las relaciones*/
            new Consulta("DELETE FROM productos_complementos WHERE id_producto = ".$_POST['id']." ");
            /*Ahora Inserto los nuevos complementos*/
            foreach ($datos as $value) {
                new Consulta("INSERT INTO productos_complementos (id_producto,id_complemento) VALUES (".$_POST['id'].",".$value.") ");
            }
        }
    }

    static public function updateProductosInsumos(){
        if ($_POST['id']) {
            $datos = json_decode($_POST['datos']);
            /*Elimino las relaciones*/
            new Consulta("DELETE FROM productos_insumos WHERE id_producto = ".$_POST['id']." ");
            /*Ahora Inserto los nuevos complementos*/
            foreach ($datos as $key => $value) {
                new Consulta("INSERT INTO productos_insumos (id_producto,id_insumo,cantidad) VALUES (".$_POST['id'].",".$value[0].",".$value[1].") ");
            }
        }
    }

    static public function updateProductosDescripcion(){
        if ($_POST['id']) {
            new Consulta("UPDATE productos SET nombre_producto = '".$_POST['nombre']."', url_producto = '".$_POST['url']."', descripcion_corta_producto = '".$_POST['descripcion_corta']."', descripcion_producto = '".$_POST['descipcion']."', precio_producto = ".$_POST['precio'].", stock_producto = ".$_POST['cantidad'].", estado = ".$_POST['activo'].", destacado_producto = ".$_POST['destacado'].", is_complemento = ".$_POST['is_complemento']." WHERE id_producto = ".$_POST['id']." ");
        }
    }

    static public function addProductosTree(){
        if ($_POST['categoria']) {
            new Consulta("INSERT INTO productos (nombre_producto, descripcion_corta_producto, descripcion_producto, precio_producto, stock_producto, estado, destacado_producto, is_complemento,  id_categoria, estado_producto) VALUES('".$_POST['nombre']."', '".$_POST['descripcion_corta']."', '".$_POST['descipcion']."', ".$_POST['precio'].", ".$_POST['cantidad'].", ".$_POST['activo'].", ".$_POST['destacado'].", ".$_POST['is_complemento'].", ".$_POST['categoria'].", 1 ) ");
        }
    }
}?>