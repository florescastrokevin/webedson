<?php
class Ofertas{
	
	private $_msgbox;
	private $_usuario;
	
	public function __construct(Msgbox $msg = NULL, Usuario $user = NULL)
	{
		$this->_msgbox = $msg;
		$this->_usuario = $user;		
	}

	public function newOfertas(){
		$query_ofertas=new Consulta("SELECT * FROM ofertas ");
		$not_in="";
		while($row_qo=$query_ofertas->VerRegistro())
		if($not_in==""){ $not_in=$row_qo['id_producto']; }else{ $not_in.=",".$row_qo['id_producto']; }
		if($not_in==""){$not_in=0;}		
		$query_prods = new Consulta("SELECT * FROM productos WHERE id_producto NOT IN(".$not_in.") AND is_complemento=0 AND estado_producto = 1");
	?>
    <fieldset id="form">
        <legend>Nueva Oferta</legend>
        <form action="" method="post" name="ofertas"> 
            <div class="button-actions">
                <input type="submit" name="" value="GUARDAR" onclick="return validar_ofertas('add','<?php echo $id?>')"  />
                <input type="reset" name="" value="CANCELAR" />
            </div>            
            <ul>
                <li><label> Producto </label>
                <input type="hidden" name="moneda" id="moneda" value="<?php echo _moneda_?>">
                <select name="producto" id="change_price">
                        <option value="">- Seleccione Producto - </option><?php
                        while($row_prods=$query_prods->VerRegistro()){ ?>
                            <option  dir="<?php echo $row_prods['precio_producto']?>" value="<?php echo $row_prods['id_producto']?>">
                            <?php echo $row_prods['nombre_producto']." &nbsp;  "._moneda_.number_format($row_prods['precio_producto'],2)?></option> <?php					
                        } ?>
                    </select> &nbsp;
                 <input type="text" name="precio_normal" id="precio_normal"  readonly="readonly" class="text ui-widget-content ui-corner-all JQprecio precio" />
               
                </li>
                <li>
                <label>Precio Oferta:</label>
                <input type="text" name="precio_oferta" id="precio_oferta" readonly="readonly" class="text ui-widget-content ui-corner-all JQprecio compare precio">
              
                </li>
            </ul>
        </form>
    </fieldset>
  
<?php		
	}
	
	public function addOfertas(){
		$sq=new Consulta("SELECT * FROM ofertas WHERE id_producto='".$_POST['producto']."'");	
		$insert= new Consulta("INSERT INTO ofertas VALUES('','".$_POST['producto']."','".clear_precio($_POST['precio_oferta'])."','".date('Y-m-d')."','".date('Y-m-d')."')");				
		$this->_msgbox->setMsgbox('Se Ingreso Oferta Correctamente.',2);
		location("ofertas.php?action=list");	
	}
	
	public function editOfertas(){ 
		
		$id    = $_GET['id'];
		$query = new Consulta("SELECT * FROM ofertas o, productos p 
								WHERE o.id_producto = p.id_producto AND
									  o.id_oferta	  = '".$id."'");

		$row = $query->VerRegistro();
		?>
        <fieldset id="form">
        	<legend>Modificar Oferta</legend>
        	<form action="" method="post" name="ofertas"> 
            	<div class="button-actions">
                	<input type="submit" name="" value="GUARDAR" onclick="return validar_ofertas('update','<?php echo $id?>')"  />
               		<input type="reset" name="" value="CANCELAR" />
                </div>
                <ul>
                    <li><label> Precio Normal: </label>
                    <input type="hidden" name="moneda" id="moneda" value="<?php echo _moneda_?>">
                    <input  type="text" id="precio_normal" name="precio_normal" readonly="readonly" value="<?php echo $row['precio_producto']?>" class="text ui-widget-content ui-corner-all JQprecio readonly precio"/>
                    </li>
                    <li><label> Precio Oferta: </label>
                    <input type="text" id="precio_oferta"  name="precio_oferta" class="text ui-widget-content ui-corner-all JQprecio compare precio" value="<?php echo $row['precio_oferta']?>"> 
                    </li>                   
                </ul>
        	</form>
        </fieldset>
		<?php		
	}
	
	public function updateOfertas(){		
			$Query=new Consulta(" 	UPDATE ofertas
									SET precio_oferta='".clear_precio($_POST['precio_oferta'])."'
									WHERE id_oferta='".$_GET['id']."'");
																				
			$this->_msgbox->setMsgbox('La actualizacion se llevo correctamente.',2);
			location("ofertas.php?action=list");
	}	


	public function deleteOfertas(){
		
		$query = new Consulta("DELETE FROM ofertas WHERE id_oferta = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Se elimino el registro correctamente.',2);
		location("ofertas.php?action=list");	
	}

	public function listOfertas(){					

		$query = new Consulta("SELECT * FROM productos p, ofertas o WHERE o.id_producto=p.id_producto AND p.is_complemento=0 AND estado_producto = 1 GROUP BY p.id_producto ORDER BY o.id_oferta");  
		?>
         <div id="content-area">
            <input type="hidden" name="moneda" id="moneda" value="<?php echo _moneda_?>">
            <table cellspacing="1" cellpading="1" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left">Producto</th>
                        <th align="left">Precio Normal</th>
                        <th align="left">Precio Oferta</th>
                        <th align="center" width="100" class="titulo">Opciones</th>
                   </tr>
                </thead>
            	<tbody>
			 <?php
			 $y = 1;
				while($rowo = $query->VerRegistro()){
					?>
					 <tr class="row <?php if($y%2==0) echo 'odl'; ?>"  >
                     <td align="left" class="celda"><img src="<?php echo _admin_ ?>icon-ofertas.png" class="handle"> <?php echo $rowo['nombre_producto'] ?></td>
                     <td align="left" class="celda JQprecio"><?php echo $rowo['precio_producto']?></td>
                     <td align="left" class="celda JQprecio"><?php echo $rowo['precio_oferta']?></td>
                     <td align="center">
						<a href="#" onclick="mantenimiento('ofertas.php','<?php echo $rowo['id_oferta'] ?>','edit')" class="tooltip" original-title="Editar">
						<img src="<?php echo _admin_ ?>edit.png"></a> &nbsp; 
						<a href="#" onclick="mantenimiento('ofertas.php','<?php echo $rowo['id_oferta'] ?>','delete')" class="tooltip" original-title="Eliminar">
						<img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;
                     </td>
					</tr>
				<?php
					$y++;
				}
                ?>
            	</tbody>
            </table>	
			<?php		
	}
	
	public function getAllOfertas(){
		$sqlp = "SELECT p.id_producto
				 FROM productos p, ofertas o
					 WHERE o.id_producto=p.id_producto
						GROUP BY p.id_producto
						ORDER BY o.id_oferta";					
		$queryp= new Consulta($sqlp);
		while($row = $queryp->VerRegistro()){
			$data[] =  array ( 'producto' => new Producto($row['id_producto']));
		}
		return $data;
	}
	
	public function getOfertas(){
		$sqlp = "SELECT o.id_oferta, p.nombre_producto, p.precio_producto , o.precio_oferta
				 FROM productos p, ofertas o
					 WHERE o.id_producto=p.id_producto
						GROUP BY p.id_producto
						ORDER BY o.id_oferta";					
		$queryp= new Consulta($sqlp);
		while($row = $queryp->VerRegistro()){
			$array[] = array(
				'id' => $row['id_producto']
			);			
		}
		return $array;
	}
	
	public function nameProdOferta( $id_oferta ){
		
			$queryp= new Consulta("SELECT o.id_oferta, p.nombre_producto, p.precio_producto , o.precio_oferta
						 FROM productos p, ofertas o
							 WHERE o.id_producto=p.id_producto
							 AND o.id_oferta = '".$id_oferta."'");
			$row = $queryp->VerRegistro();
			return $row['nombre_producto'];
				
	}
	
}

?>