<?php
class Clientes{
	
	private $_msgbox;
	
	public function __construct($msg='')
	{
		$this->_msgbox = $msg;
	}
		
	public function editClientes(){ 

            $obj = new Cliente($_GET['id']);
            $comportamiento = $obj->getComportamiento(); ?>
            <fieldset id="form">
                <legend> Edición</legend>			
                <form enctype="multipart/form-data" action="clientes.php?action=update&id=<?php echo $_GET['id'] ?>" method="post" name="informaciones"> 
                    <div class="button-actions">
                        <input type="reset" class="button" value="CANCELAR" name="cancelar">  
                        <input type="submit" class="button" value="ACTUALIZAR" name="actualizar">
                    </div>
                    <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="row">
                            <ul style="margin:5px;background-color:#EEFFEE;padding:10px 15px">
                                <li class="form-group"><label> Nombre: </label>  <?php echo $obj->__get("_nombre")." ". $obj->__get("_apellidos")?></li>                    
                                <li class="form-group"><label> E-mail: </label> <?php echo $obj->__get("_email")?></li>                          
                                <li class="form-group"><label> Telefono: </label> <?php echo $obj->__get("_telefono")?><br></li>
                                <li class="form-group"><label> Ciudad - Pais: </label> <?php echo $obj->__get("_ciudad")?><br></li>           
                                <li class="form-group"><label> Año Nacimiento: </label> <?php echo $obj->__get("_nac")?><br></li>                     
                                <li> --- </li>
                                <li class="form-group"><label>Fecha Registro: </label> <?php echo $comportamiento["fecha_ingreso"]?><br></li>
                                <li class="form-group"><label>De Donde Vino: </label> <?php echo $obj->__get("_pagina_referencia")?><br></li>                    
                                <li class="form-group"><label>A Donde llego: </label> <?php echo $obj->__get("_pagina_inicio")?><br></li>  
                                
                                <li> --- </li>
                                <li class="form-group"><label>Accesos: </label> <?php echo $comportamiento["numero_accesos"]?><br></li>
                                <li class="form-group"><label>Navegador Usado: </label> <?php echo $comportamiento["navegador"]?><br></li>
                                <li class="form-group"><label>Sistema Operativo: </label> <?php echo $comportamiento["sistema_operativo"]?><br></li>
                                <li class="form-group"><label> Observación: </label> <?php echo $obj->__get("_observacion") ?></li>      
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9"> 
                         
                            <?php 
                            $transacciones = $obj->getPedidos();
                            $total_transacciones = count($transacciones);
                            ?>
                            <h4>Transacciones</h4>
                            <table class="listado">
                                <thead>
                                    <tr class="head">
                                        <th class="titulo">Pedido</th>
                                        <th class="titulo">Fecha Pedido</th>
                                        <th class="titulo">Fecha Entrega</th>
                                        <th class="titulo">Fecha Entrega</th>
                                        <th class="titulo">Estado</th>
                                    </tr>
                                </thead>
                                <tbody><?php 
                                for($x=0; $x < $total_transacciones; $x++){ ?>
                                    <tr class="row">
                                        <td><?php echo $transacciones[$x]["id"] ?></td>
                                        <td><?php echo $transacciones[$x]["fecha_pedido"] ?></td>
                                        <td><?php echo $transacciones[$x]["fecha_entrega"] ?></td>
                                        <td><?php echo $transacciones[$x]["metodo_pago"] ?></td>
                                        <td><?php echo $transacciones[$x]["estado"] ?></td>
                                    </tr><?php
                                } ?>    
                                </tbody>
                            </table>
                        
                            <br><br>
                            <h4>Fechas Especiales</h4>
                            
                            <br><br>
                            <h4>Usuarios Coincidentes</h4>
                         
                    </div>
                     </div>
                    
		</form>	
            </fieldset>
            <?php
	}
	
	public	function updateClientes(){
            $query = new Consulta("UPDATE clientes
                                    SET observacion_cliente='".$_POST['observacion']."'
                                    WHERE id_cliente='".$_GET['id']."'");	
            $this->_msgbox->setMsgbox('La actualizacion se realizo Correctamente',2);
            location("clientes.php");
	}

	public function deleteClientes(){
		$Query= new Consulta("DELETE FROM clientes WHERE id_cliente='".$_GET['id']."'");
		$Query= new Consulta("DELETE FROM clientes_informacion WHERE id_cliente='".$_GET['id']."'");

		echo "<br><div id='error'>Se elimino el registro Correctamente </div><br>";
		$this->listClientes();
	}

	public function listClientes(){
		
            if(!isset($_GET['pag'])){ $_GET['pag'] = 1; } 
            $tampag = 100;
            $reg1 = ($_GET['pag']-1) * $tampag;	  

            if($_GET['q'] != ''){
                $q = $_GET['q'];
                $like_n  = " AND CONCAT(c.nombre_cliente, ' ', c.apellidos_cliente) LIKE '%".$q."%'";
                $like_e  = " OR c.email_cliente LIKE '%".$q."%'   ";			
            } 
            
            $orden = "";
            if($_GET['orden'] && !empty($_GET['orden'])){
                $orden = " ".$_GET['orden'].", " ;
            }

            $sql = "SELECT  c.id_cliente, CONCAT(c.nombre_cliente,' ',c.apellidos_cliente) AS Cliente, 
                        c.email_cliente AS Email,
                        DATE_FORMAT(ci.fecha_ingreso_cliente,'%d-%m-%Y %H:%i:%s') AS Registro,
                        p.nombre_pais AS Pais,   
                        c.ciudad_cliente AS Ciudad                                                     
                    FROM clientes c, clientes_informacion ci, pais p
                    WHERE c.id_cliente = ci.id_cliente AND
                            p.id_pais = c.pais_cliente
                        ".$like_n." 
                        ".$like_e."
                    GROUP BY c.id_cliente 
                    ORDER BY ".$orden." c.id_cliente DESC,ci.fecha_ingreso_cliente ";

            $queryt= new Consulta($sql);	 

            $num=$queryt->NumeroRegistros();	
            $limit=$sql_pag." LIMIT ".$reg1.",".$tampag."";

            $sql .= $limit ;		
            $query= new Consulta($sql);	
            echo Listado::Simple($query,"clientes.php");
		
            if( $num > $tampag ){ echo "<div align='center' class='nav-bottom'>".paginar($_GET['pag'], $num, $tampag, "clientes.php?pag=")."</div>"; }	
	}
	
	public function getClientePorId($id){
            $query = new Consulta("SELECT * FROM clientes WHERE id_cliente ='".$id."'");
            $cliente;
            while($row = $query->VerRegistro()){
                $cliente[] = array(
                    'id'	  		 => $row["id_cliente"],
                    'nombre'    	 => $row["nombre_cliente"],
                    'apellidos' 	 => $row["apellidos_cliente"],
                    'telefono'  	 => $row["telefono_cliente"],
                    'email'      	 => $row["email_cliente"],
                    'direccion'		 => $row["direccion_cliente"],
                    'ciudad'		 => $row["ciudad_cliente"],
                    'pais'	     	 => $row["pais_cliente"]				
                );
            }
            return $cliente;
	}
	
	public function getClientes(){
            $query = new Consulta("SELECT * FROM clientes");
            $cliente;
            while($row = $query->VerRegistro()){
                $cliente[] = array(
                    'id'	  		 => $row["id_cliente"],
                    'nombre'	  		 => $row["nombre_cliente"],
                    'apellidos'	  		 => $row["apellidos_cliente"],
                    'usuario'	  		 => $row["nombre_cliente"].' '.$row["apellidos_cliente"]
                );
            }
            return $cliente;
	}
	
	public function getClientesLimit($limit = 30){
            $query = new Consulta("SELECT * FROM clientes  ORDER BY id_cliente DESC LIMIT 0,".$limit."");
            $cliente;
            while($row = $query->VerRegistro()){
                $cliente[] = array(
                    'id'	  		 => $row["id_cliente"],
                    'nombre'	  		 => $row["nombre_cliente"],
                    'apellidos'	  		 => $row["apellidos_cliente"],
                    'usuario'	  		 => $row["nombre_cliente"].' '.$row["apellidos_cliente"]
                );
            }
            return $cliente;
	}
        
        static public function addClienteAdmin(){
            $objeto_user_agent = new UserAgent();
		
            $sql = "INSERT INTO clientes VALUES('','".$_POST['nombre_cliente']."','".$_POST['apellidos_cliente']."','".$_POST['email_cliente']."','".$_POST['password_cliente']."','".$_POST['telefono_cliente']."','".$_POST['direccion_cliente']."','".$_POST['ciudad_cliente']."','".$_POST['id_pais']."','".$_POST['observaciones_cliente']."','TELEFONO','')";
            $query = new Consulta($sql);
            $id = $query->nuevoId();
            $query_i = new Consulta("INSERT INTO clientes_informacion VALUES('".$id."','".date('Y-m-d H:i:s')."', '1','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','0','".$objeto_user_agent->getBrowserName()."','".$objeto_user_agent->getOs()."','".$objeto_user_agent->getUserAgentString()."')");
            
            echo $id;
        } 
        
        public function listCRMClientes(){
		
            if(!isset($_GET['pag'])){ $_GET['pag'] = 1; } 
            $tampag = 100;
            $reg1 = ($_GET['pag']-1) * $tampag;	

            if($_GET['q'] != ''){
                $q = $_GET['q'];
                $like_n  = " AND CONCAT(c.nombre_cliente, ' ', c.apellidos_cliente) LIKE '%".$q."%'";
                $like_e  = " OR c.email_cliente LIKE '%".$q."%'   ";			
            } 
            
            $orden = "";
            if($_GET['orden'] && !empty($_GET['orden'])){ $orden = " ".$_GET['orden'].", " ; }
            $estado_from = "";
            $estado_where = "";
            if($_GET['estado'] && !empty($_GET['estado'])){
                $estado_from = ", pedidos pe " ;
                $estado_where = " AND pe.id_cliente = c.id_cliente AND pe.estado_pedido LIKE '".$_GET['estado']."%' ";
            }
            
            $sql = "SELECT  c.id_cliente, 
                        CONCAT(c.nombre_cliente,' ',c.apellidos_cliente) AS Cliente, 
                        c.email_cliente AS Email,
                        DATE_FORMAT(ci.fecha_ingreso_cliente,'%d-%m-%Y') AS Registro,
                        p.nombre_pais AS Pais,   
                        c.ciudad_cliente AS Ciudad                                                     
                    FROM clientes c, clientes_informacion ci, pais p ".$estado_from."
                    WHERE c.id_cliente = ci.id_cliente AND
                        p.id_pais = c.pais_cliente
                        ".$estado_where."     
                        ".$like_n." 
                        ".$like_e."
                    GROUP BY c.id_cliente 
                    ORDER BY ".$orden." c.id_cliente DESC,ci.fecha_ingreso_cliente ";
            
            $queryt = new Consulta($sql);	 

            $num = $queryt->NumeroRegistros();	
            $limit=$sql_pag." LIMIT ".$reg1.",".$tampag."";

            $sql .= $limit ;		
            $query= new Consulta($sql);	
            
            $sql_clientes_entregado = "SELECT * FROM clientes c, pedidos p WHERE p.estado_pedido LIKE 'Entregado' AND p.id_cliente = c.id_cliente GROUP BY c.id_cliente";
            $query_clientes_entregado = new Consulta($sql_clientes_entregado);
            $total_clientes_entregado = $query_clientes_entregado->NumeroRegistros();
            
            $sql_clientes_pagado = "SELECT * FROM clientes c, pedidos p WHERE p.estado_pedido LIKE '%Pagado%' AND p.id_cliente = c.id_cliente GROUP BY c.id_cliente";
            $query_clientes_pagado = new Consulta($sql_clientes_pagado);
            $total_clientes_pagado = $query_clientes_pagado->NumeroRegistros();
            
            
            $sql_clientes_confirmado = "SELECT * FROM clientes c, pedidos p WHERE p.estado_pedido LIKE 'Confirmado' AND p.id_cliente = c.id_cliente GROUP BY c.id_cliente";
            $query_clientes_confirmado = new Consulta($sql_clientes_confirmado);
            $total_clientes_confirmado = $query_clientes_confirmado->NumeroRegistros();
            
            $sql_clientes_registrado = "SELECT * FROM clientes c, pedidos p WHERE p.estado_pedido LIKE 'Solicitado' AND p.id_cliente = c.id_cliente GROUP BY c.id_cliente";
            $query_clientes_registrado = new Consulta($sql_clientes_registrado);
            $total_clientes_registrado = $query_clientes_registrado->NumeroRegistros();
            ?>
            <h3> Registrados(<?php echo $num; ?>) => 
                  Entregados: <a href="reporte_clientes.php?estado=Entregado"><?php echo $total_clientes_entregado; ?></a>
                | Confirmados: <a href="reporte_clientes.php?estado=Confirmado"><?php echo $total_clientes_confirmado; ?></a>
                | Solicitados: <a href="reporte_clientes.php?estado=Solicitado"><?php echo $total_clientes_registrado; ?></a>
                | Pagados: <a href="reporte_clientes.php?estado=Pagado"><?php echo $total_clientes_pagado; ?></a></h3>
            <table class='listado' cellpading='1' cellspacing='1' >
                <thead>
                    <tr class='head'>
                        <th class='titulo'><a href='reporte_clientes.php?orden=Cliente'>Cliente</a></th>
                        <th class='titulo'><a href='reporte_clientes.php?orden=Email'>Email</a></th>
                        <th class='titulo'><a href='reporte_clientes.php?orden=Registro'>Registro</a></th>
                        <th class='titulo'><a href='reporte_clientes.php'>Compras / Transac.</a></th>
                        <th class='titulo'><a href='reporte_clientes.php'>Ultima Compra</a></th>
                        <th class='titulo'><a href='reporte_clientes.php'>Ultima Producto Comprado</a></th>
                        <th class='titulo'><a href='reporte_clientes.php?orden=Pais'>Pais</a></th>
                        <th class='titulo'><a href='reporte_clientes.php?orden=Ciudad'>Ciudad</a></th>
                        <th class='titulo' align='center' width='80'>Opciones</th>
                    </tr>
                </thead>
            <tbody> <?php 
            $x=0;
            while($row = $query->VerRegistro()){
                $transacciones = Cliente::getCantidadTransacciones($row["id_cliente"]);
                $ultimo_pedido = Cliente::getUltimoPedido($row["id_cliente"]);
                $ultimo_producto=Cliente::getUltimoProducto($row["id_cliente"]);
                $pedidos =       Cliente::CantidadPedidos($row["id_cliente"]);
                $pedidos = $pedidos > 0 ? $pedidos : 0;
                //$row_bg  = $pedidos > 0 ? " odl-bg" : "";
                if($x==0){ $class = "row";}else{ $class = "row odl";}  ?>
                <tr class='<?php echo $class; ?>'> 
                    <td align=left class=celda><?php echo $row["Cliente"]; ?></td>
                    <td align=left class=celda><?php echo $row["Email"]; ?></td>
                    <td align=left class=celda><?php echo $row["Registro"]; ?></td>
                    <td align=left class=celda><?php echo $pedidos." / ".$transacciones; ?></td>
                    <td align=left class=celda><?php echo $ultimo_pedido; ?></td>
                    <td align=left class=celda><?php echo $ultimo_producto; ?></td>
                    <td align=left class=celda><?php echo $row["Pais"]; ?></td>
                    <td align=left class=celda><?php echo $row["Ciudad"]; ?></td>
                    <td align='center'> 
                        <a href='#' onClick=mantenimiento('reporte_clientes.php',<?php echo $row["id_cliente"]; ?>,'edit') title="CRM 360" class='boton_360 tooltip'><div class="circleBlue">360</div></a> &nbsp; 
                        <!--<a href='#' onClick=mantenimiento('reporte_clientes.php',<?php echo $row["id_cliente"]; ?>,'delete') title=Eliminar class='tooltip'> <img src='<?php echo _imgs_ ?>admin/delete.png' ></a>&nbsp;</td>-->
                </tr><?php 
                if($x==0){$x++;}else{$x=0;}
                 
            }?>
            </tbody> 
        </table>
        <?php if( $num > $tampag ){ echo "<div class='nav-bottom' align='center'>".paginar($_GET['pag'], $num, $tampag, "clientes.php?pag=")."</div>"; }
    }

}
?>