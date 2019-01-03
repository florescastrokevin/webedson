<?php include("inc.aplication_top.php");

if ( $_POST['action'] == 'addAtributo' ){
	
	
	
	
	$sq=new Consulta("SELECT * FROM productos_atributos
				WHERE id_producto='".$_POST['producto']."' AND
						id_atributo='".$_POST['atributos']."' ");	
			if($sq->NumeroRegistros()==0){
				$insert= new Consulta("INSERT INTO productos_atributos
					VALUES('','".$_POST['producto']."','".$_POST['atributos']."')");							
				$id_pa=$insert->nuevoId();
			}else{
				$row_pa= $sq->VerRegistro();
				$id_pa = $row_pa['id_producto_atributo'];
			}
				
			$sq_pav = new Consulta("SELECT * FROM productos_atributos_valores
				WHERE id_producto_atributo='".$id_pa."' AND
					  id_atributo_valor='".$_POST['valor_atributo']."' ");	
			
			/* valor_atributo = atributos_valores */
			
			if($sq_pav->NumeroRegistros()==0){
				$inser= new Consulta("INSERT INTO productos_atributos_valores
					VALUES('','".$id_pa."','".$_POST['valor_atributo']."', '".$_POST['prefijo']."','".clear_precio($_POST['precio_valor_atributo'])."','".$_POST['stock_valor_atributo']."')");							
					//echo "<div id=error> Se Ingreso el Atributo Correctamente </div><br>";
			}else{
				$inser = "UPDATE productos_atributos_valores SET 
						prefijo_producto_atributo_valor='".$_POST['prefijo']."',
						precio_producto_atributo_valor ='".$_POST['precio_valor_atributo']."',
						stock_producto_atributo_valor ='".$_POST['stock_valor_atributo']."'  
						WHERE id_producto_atributo='".$id_pa."' AND
					  id_atributo_valor='".$_POST['valor_atributo']."'  ";
				$sq_inser = new Consulta($inser);	
				//	echo "<div id=error> Se actualizo el Atributo Correctamente </div><br>";		
			}
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	/*  ---------- */
	
	
	
	/*
	$querypa = new Consulta ( "INSERT INTO productos_atributos VALUE ('','".$_POST['producto']."','".$_POST['atributos']."')");
	$id_pa = mysql_insert_id();
	
	$querypav = new Consulta("INSERT INTO productos_atributos_valores 
						   VALUES ('',
								   '".$id_pa."',
								   '".$_POST['valor_atributo']."',
								   '".$_POST['prefijo']."',
								   '".clear_precio($_POST['precio_valor_atributo'])."',
								   '".$_POST['stock_valor_atributo']."')");
	*/
	$obj = new Producto($_POST['producto'], $idioma);	
	
	
	
	
	
	
	
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
				<a title="Eliminar" class="tooltip" onClick="deleteAtributo('<?php echo $atr['id_pav'] ?>','<?php echo $_POST['producto']?>')"  href="#"> <img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;                           
				 </div>
			 </li>
	<?php
	$y++;
	endforeach;			
				
}

if ( $_POST['action'] == 'deleteAtributo' ){
	//$query = new Consulta(" DELETE FROM productos_atributos WHERE id_producto_atributo = '".$_POST['idpa']."'");
	$query = new Consulta(" DELETE FROM productos_atributos_valores WHERE id_producto_atributo_valor = '".$_POST['idpav']."'");
	
	$obj   = new Producto($_GET['idp']);
	$val   = $obj->updateStock();
	if($val == FALSE){
		$Queryp = new Consulta("DELETE FROM productos_atributos WHERE id_producto='".$_GET['idp']."'");
	}
	
}

if ( $_POST['action'] == 'cargaValores' ){	

	$query = new Consulta(" SELECT * FROM atributos_valores WHERE id_atributo = '".$_POST['id_atributo']."'");
	while ( $row = $query->VerRegistro() ){
		$valores[] = array(
			'id' 	 => $row['id_atributo_valor'],
			'nombre' => $row['valor_atributo_valor']
		);
	}
	echo json_encode($valores);
}

if ( $_POST['action'] == 'editAtributo' ){
	
	$query = new Consulta( "UPDATE productos_atributos_valores SET 
			prefijo_producto_atributo_valor = '".$_POST['prefijo_valor_atributo']."',
			precio_producto_atributo_valor = '".clear_precio($_POST['precio_valor_atributo'])."',
			stock_producto_atributo_valor = '".$_POST['stock_valor_atributo']."'			
			WHERE id_producto_atributo_valor = '".$_POST['id_atributo']."'");	
	?>
    <div class="data att0"> 
    <img src="<?php echo _admin_ ?>file.png" class="handle">   <?php echo $_POST['producto']; ?></div>
    <div class="data att1"><?php echo $_POST['atributo'] ?></div>
    <div class="data att2"><?php echo $_POST['valor'] ?></div>
    <div class="data att3"><?php echo $_POST['prefijo_valor_atributo'] ?></div>
    <div class="data att4 JQprecio"><?php echo $_POST['precio_valor_atributo']?></div>
    <div class="data att5"><?php echo $_POST['stock_valor_atributo'] ?></div>
    <div class="options att">
        <a title="Editar" class="tooltip" onClick="popupAtributo('<?php echo $_POST['id_atributo'] ?>')"  href="#"> 
        <img src="<?php echo _admin_ ?>edit.png"></a>&nbsp;
        <a title="Eliminar" class="tooltip" onClick="deleteAtributo('<?php echo $_POST['id_atributo'] ?>')" href="#"> <img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;                           
    </div>    
    <?php
}
?>