<?php
class Posts{
	
	private $_msgbox;
	
	public function __construct(Msgbox $msg = Null){
		$this->_msgbox  = $msg ;
	}
	
	public function newPost(){
		?>
            <fieldset id="form">
        	<legend>Nuevo Post</legend>
        	<form action="" method="post" name="post" > 
            	<div class="button-actions">
                    <input type="button" name="" value="GUARDAR" onclick="return valida_post('add','')"  />
                    <input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
                    <li><label> Titulo Post : </label>
                    <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="titulo_post"></li>	
                  	
                    <li><label> Descripcion Post : </label> <textarea name="descripcion_post" class="text ui-widget-content ui-corner-all tinymce" rows="18" cols="124"></textarea></li>                
                    
                    
                    <li><label> Destacado Post : </label> <input type="radio" name="destacado_post" value="1">Si <input type="radio" name="destacado_post" value="0">No<br/></li>                
                    
                    
                    <li><label>Fecha Post : </label> 
                       <input type="text" class="text ui-widget-content ui-corner-all datetime" size="20" name="fecha_post"></li>	      			  
                   <li><label> Tags Post : </label> <textarea name="tags_post" class="text ui-widget-content ui-corner-all" rows="5" cols="124"></textarea></li>     
                </ul>
        	</form>
            </fieldset>
        
		<?php
	}
		
	public function addPost($cat=0){
		
		$query = new Consulta("INSERT INTO post VALUES ('','".$cat."',
                                          '".$_POST['titulo_post']."',
                                          '".$_POST['descripcion_post']."',
										  '".$_POST['destacado_post']."',
                                          '".fecha_hora_html_sql($_POST['fecha_post'])."',															
                                          '".$_POST['tags_post']."',
										  '".$this->orderPost($cat)."')");
		        
		$this->_msgbox->setMsgbox('Post grabado correctamente',2);
		location("publicaciones.php?cat=".$cat);
		
	}
	
	public function editPost(){
	    $obj = new Post($_GET['id']);
		?>
		<fieldset id="form">
        	<legend>Editar Post</legend>
        	<form action="" method="post" name="post" > 
            	
            	<div class="button-actions">
                    <input type="reset" class="button" value="CANCELAR" name="cancelar">  
                    <input type="button" class="button" onclick="return valida_post('update','<?php echo $_GET['id'] ?>')" value="ACTUALIZAR" name="actualizar">	
                </div>
                <ul>
                
                <li><label> Titulo Post : </label>
                    <input type="text" class="text ui-widget-content ui-corner-all" size="59" name="titulo_post" value="<?php echo $obj->__get("_titulo")?>"></li>	
                  	
                <li><label> Descripcion Post : </label> <textarea name="descripcion_post" class="text ui-widget-content ui-corner-all tinymce" rows="18" cols="124"><?php echo $obj->__get("_descripcion")?></textarea></li>                
                
                
                  <li><label> Destacado Post : </label> <input type="radio" name="destacado_post" value="1" <?php if($obj->__get('_destacado')=='1')echo 'checked="checked"';?>   >Si <input type="radio" name="destacado_post" value="0" <?php if($obj->__get('_destacado')=='0')echo 'checked="checked"';?> >No<br/></li>                
                
                
                <li><label>Fecha Post : </label> 
                   <input type="text" class="text ui-widget-content ui-corner-all datetime" size="20" name="fecha_post" value="<?php echo fecha_hora_sql_html($obj->__get("_fecha"))?>"></li>	      			  
               <li><label> Tags Post : </label> <textarea name="tags_post" class="text ui-widget-content ui-corner-all" rows="5" cols="124"><?php echo $obj->__get("_tags")?></textarea></li>     
                </ul>  
        	</form>
        </fieldset>
		<?php

	}
	
	public function updatePost($cat=0){	   
		$id_post = $_GET['id'];
		
		$query = new Consulta("UPDATE  post SET 
                                             titulo_post      = '".$_POST['titulo_post']."',
                                             descripcion_post = '".$_POST['descripcion_post']."',
                                             fecha_post      = '".fecha_hora_html_sql($_POST['fecha_post'])."',
                                             tags_post     = '".$_POST['tags_post']."'	,
											 destacado_post = '".$_POST['destacado_post']."'	
                                       WHERE id_post = '".$id_post."'");
				
			
                
		$this->_msgbox->setMsgbox('Se actualizo correctamente.',2);
		location("publicaciones.php?cat=".$cat);
	}
	
	public function deletePost($cat=0){
		$query = new Consulta("DELETE  FROM post WHERE id_post = '".$_GET['id']."'");
		
		$this->_msgbox->setMsgbox('Se elimino correctamente.',2);
		location("publicaciones.php?cat=".$cat);
	}
	
	public function listPost($cat=0){
	
		$idc = ($cat > 0) ? $cat : 0;
		
		$sql = " SELECT * FROM categorias_blog 
					WHERE id_parent_categoria_blog  =  ".$idc."					
					ORDER BY orden_categoria_blog ASC";
						
		$query = new Consulta($sql);        
		
		$sqlp = " SELECT * FROM post 
						WHERE id_categoria_blog =  ".$idc."	
						ORDER BY orden_post ASC";	
						
		$queryp = new Consulta($sqlp);	
		?>
        <div id="content-area">
            <table cellspacing="1" cellpading="1" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left">Categorias Blog / Post</th>
                        <th align="center" width="100" class="titulo">Opciones</th>
                   </tr>
                </thead>
            </table>	
            <ul id="listadoul" title="ordenarBlog">
			 <?php
				$y = 1;
				while($row = $query->VerRegistro()){?>
					 <li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="list_item_<?php echo $row['id_categoria_blog']."|catblog"; ?>">
						<div class="data"><img src="<?php echo _admin_ ?>folder.png" class="handle"> <?php echo $row['titulo_categoria_blog'] ?></div>
                                              
						<div class="options">
                                                  
							<a class="tooltip move" title="Ordenar ( Click + Arrastrar )"><img src="<?php echo _admin_ ?>move.png" class="handle"></a>&nbsp;
							<a title="Editar" class="tooltip" href="publicaciones.php?id=<?php echo $row['id_categoria_blog'] ?>&actioncat=edit&ide=<?php echo $row['id_categoria_blog'] ?>"><img src="<?php echo _admin_ ?>edit.png"></a>&nbsp;
							
                            <a title="Eliminar"  href="#" class="tooltip" onClick="mantenimiento_cat('publicaciones.php','<?php echo $row['id_categoria_blog'] ?>','delete&ide=<?php echo $row['id_categoria_blog'] ?>')"><img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;
							<a title="Ver Productos" class="tooltip"  href="publicaciones.php?cat=<?php echo $row['id_categoria_blog'] ?>&action=list"><img src="<?php echo _icons_ ?>zoom.png"></a>&nbsp;                           
                        </div>
                        
						</li>
				<?php
					$y++;
				}
				$y = 1;
				while($rowp = $queryp->VerRegistro()){
					?>
					 <li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="list_item_<?php echo $rowp['id_post']."|post"; ?>">
						<div class="data"> <img src="<?php echo _admin_ ?>file.png" class="handle">   <?php echo $rowp['titulo_post'] ?></div>
						<div class="options">
                                                
							<a class="tooltip move"  title="Ordenar ( Click + Arrastrar )"><img src="<?php echo _admin_ ?>move.png" class="handle"></a>&nbsp;
							<a title="Editar" class="tooltip" href="publicaciones.php?id=<?php echo $rowp['id_post'] ?>&action=edit">
							<img src="<?php echo _admin_ ?>edit.png"></a> &nbsp;
							<a title="Eliminar" class="tooltip" onClick="mantenimiento('publicaciones.php','<?php echo $rowp['id_post'] ?>','delete')"  href="#"> <img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;
						</div>
                        
						</li>
				<?php
					$y++;
					}
				?>
             </ul>
                
             </div>
             
        </div>
        <?php
		
	}
	
	public function orderPost($cat=0){
		$query = new Consulta("SELECT MAX(orden_post) max_orden 
									FROM post WHERE id_post = '".$cat."'");
		
		$row   = $query->VerRegistro();
		return (int)($row['max_orden']+1);
	}
	
	static public function getIdByName($nombre){
		$sql = "SELECT id_post FROM post WHERE titulo_post = '".trim($nombre)."' ";            
		$query = new Consulta($sql);
		$row = $query->VerRegistro();
		return $row['id_post'];            
	}
		
	public function getPostByCat( $cat ){		
		
		$data = array();
		$query = new Consulta("SELECT * FROM post WHERE id_categoria_blog='".$cat."'");
		while( $row = $query->VerRegistro() ){
			$data[] = array(
					'id'		=> $row['id_post'],
					'titulo' 	=> $row['titulo_post']
			 );
		}	
		return $data;
	}
	

}
 ?>