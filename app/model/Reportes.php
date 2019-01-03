<?php
class Reportes{

	public function reportProductos($smg){
		?>
		<form name="f1" action="" method="post"  >
                    <p>Reporte Emitido el <b><?php echo date('d-m-Y'); ?></b> a las <b><?php echo date('H:m:s') ?></b></p>
                    <br />
		<table width="100%" style="border:solid 1px #09C;" cellpadding="0" cellspacing="0">
			<tr>
				<td height="33" colspan="4" align="center" bgcolor="#09C" style="color:#FFF"> <b>OPERACIONES</b></td>
			</tr>					
			<tr>
				<td width="7%" align="right">Producto :</td>
				<td width="46%" align="left" >
                        <input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" size="62"/> 
                </td>
                
                <td width="9%" align="right">Categoria :&nbsp;</td>
				<td width="38%" align="left" >
                <?php 
				$msg =new Msgbox();
				$obj = new Categorias($msg);
				$array_cat = $obj->getCategorias(0, 999999);
				 ?>
                <select name="categorias" id="categorias">
                    <option value="">- Seleccione Categoria -</option> <?php
					for($i=0;$i<count($array_cat);$i++){ ?>
						<option value="<?php echo $array_cat[$i]['id']?>">
							<?php echo $array_cat[$i]['nombre']?>
						</option> 
					<?php } ?>
                </select>
                </td>
			</tr>
			<tr>
				<td align="right">Precio:</td>
				<td align="left" >
                        <select name="signo" id="signo" style="width:150px;">
                            <option value="=">=</option>
                            <option value="&gt;">&gt;</option>	
                            <option value="&lt;">&lt;</option>						
                        </select> &nbsp;A&nbsp; 
                        <input type="text" class="ui-widget-content ui-corner-all" name="precio" id="precio" style="width:45px;" />
                </td>
                <td></td>
                <td> <input type="button"  value="BUSCAR" class="button" style="margin-right:20px" onclick="searchProductos()" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  value="IMPRIMIR" class="button" style="margin-right:20px" onclick="window.print();" /></td>
			 </tr>	
			 <tr><td>&nbsp;</td></tr>
            </table>
            
             <br />
            <table cellspacing="1" cellpading="1" class="listado">
              <thead>
                    <tr class="head">
                        <th class="titulo">Producto</th>
                        <th class="titulo">Categoria</th> 
                        <th class="titulo">Precios: Público -  Privado -  Extranjero</th> 
                   </tr>
                </thead>
                <tbody id="listado_prods">
                    <tr class="fila2">
                      <td colspan="4" align="center">Seleccione Filtros</td></tr>
                </tbody>
                      
       	 </table>
         </form>
		<?php
	}
	
	public function reportPedidos(){
		?>
		<form name="f1" action="" method="post"  >
                    <p>Reporte Emitido el <b><?php echo date('d-m-Y'); ?></b> a las <b><?php echo date('H:m:s') ?></b></p>
                    <br />
		<table width="100%" style="border:solid 1px #09C;" cellpadding="0" cellspacing="0">
			<tr>
				<td height="33" colspan="4" align="center" bgcolor="#09C" style="color:#FFF"> <b>OPERACIONES</b></td>
			</tr>					
			<tr>
			  <td height="19" align="right">&nbsp;</td>
			  <td align="left" >&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="left" >&nbsp;</td>
		  </tr>
			<tr>
				<td height="32" align="right">Nº de Pedido:</td>
				<td align="left" >
                        <input type="text" name="numero" id="numero" class="input" style="width:290px"/> 
                </td>
                
                <td align="right">Estado :</td>
				<td align="left" >
                <select name="estado" id="estado" style="width:200px">
                        <option value="">- Seleccione</option>
                        <option value="P">Pendiente</option>
                        <option value="F">Finalizado</option>
                  </select>
                </td>
			</tr>
			<tr>
				<td height="28" align="right">Entre las fechas :</td>
				<td align="left" >
                      &nbsp;&nbsp;de 
                  <input type="text" name="fechai" id="fechai"  value="" size="12" class="input" style="width:120px; margin-right:5px;"> 
                      &nbsp;&nbsp;&nbsp;hasta  <input type="text" name="fechaf" id="fechaf"  value="" size="12" class="input" style="width:120px; margin-right:5px;">
						 
                </td>
                <td></td>
                <td> <input type="button"  value="BUSCAR" class="button" style="margin-right:20px" onclick="searchPedidos()" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  value="IMPRIMIR" class="button" style="margin-right:20px" onclick="window.print();" /></td>
		  </tr>	
			 <tr><td>&nbsp;</td></tr>
          </table>
          <br />
            <table cellspacing="1" cellpading="1" class="listado">
              <thead>
                    <tr class="head">
                    	<th class='titulo'>Nº Pedido </th>
                        <th class='titulo'>Cliente </th>
                        <th class='titulo'>Monto</th>
                        <th class='titulo'>Fecha de Compra </th>
                        <th class='titulo'>Estado del pedido</th>
                        <th class='titulo'>Opciones </th>
                   </tr>
                </thead>
                <tbody id="listado_pedidos">
                    <tr class="fila2"><td colspan="6" style="padding:6px" align="center">Seleccione Filtros</td></tr>
                </tbody>
                      
       	 </table>
         </form>
		<?php
		}

        public function reportTutorias(){
		?>
		<form name="f1" action="" method="post"  >
                    <p>Reporte Emitido el <b><?php echo date('d-m-Y'); ?></b> a las <b><?php echo date('H:m:s') ?></b></p>
                    <br />
		<table width="100%" style="border:solid 1px #09C;" cellpadding="0" cellspacing="0">
			<tr>
				<td height="33" colspan="4" align="center" bgcolor="#09C" style="color:#FFF"> <b>OPERACIONES</b></td>
			</tr>
			<tr>
			  <td height="19" align="right">&nbsp;</td>
			  <td align="left" >&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="left" >&nbsp;</td>
		  </tr>
			<tr>
				<td height="32" align="right">Estado :</td>
				<td align="left" >
                        <select name="estado" id="estado" style="width:200px">
                        <option value="">- Seleccione</option>
                        <option value="F">Finalizado</option>
                        <option value="A">Programado</option>
                        <option value="E">Espera de pago</option>
                        <option value="P">Pendiente</option>
                  </select>
                </td>

                <td align="right"></td>
				<td align="left" >
                
                </td>
			</tr>
			<tr>
				<td height="28" align="right">Entre las fechas :</td>
				<td align="left" >
                      &nbsp;&nbsp;de
                  <input type="text" name="fechai" id="fechai"  value="" size="12" class="input" style="width:120px; margin-right:5px;">
                      &nbsp;&nbsp;&nbsp;hasta  <input type="text" name="fechaf" id="fechaf"  value="" size="12" class="input" style="width:120px; margin-right:5px;">

                </td>
                <td></td>
                <td> <input type="button"  value="BUSCAR" class="button" style="margin-right:20px" onclick="searchTutorias()" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  value="IMPRIMIR" class="button" style="margin-right:20px" onclick="window.print();" /></td>
		  </tr>
			 <tr><td>&nbsp;</td></tr>
          </table>
          <br />
            <table cellspacing="1" cellpading="1" class="listado">
              <thead>
                    <tr class="head">
                        <th class='titulo'>Cliente </th>
                        <th class='titulo' width="120">Titulo Tutoria </th>
                        <th class='titulo' width="90">Fecha Tutoria </th>
                        <th class='titulo' width="120">Hora Tutoria </th>
                        <th class='titulo' width="100">Estado Tutoria</th>
                        <th class='titulo' width="60">Monto</th>
                   </tr>
                </thead>
                <tbody id="listado_tutorias">
                    <tr class="fila2"><td colspan="6" style="padding:6px" align="center">Seleccione Filtros</td></tr>
                </tbody>

       	 </table>
         </form>
		<?php
		}
		
	public function reportProductosVendidos($idioma, $smg){
			
			$sql = new Consulta("SELECT pi.id_producto, pi.nombre_producto, p.precio_publico, p.precio_privado, p.precio_extranjero, count(pp.id_producto) AS total
                                 FROM productos p, productos_idiomas pi, pedidos pe, pedidos_productos pp
                                 WHERE p.id_producto = pi.id_producto
                                 AND pe.id_pedido = pp.id_pedido
                                 AND p.id_producto = pp.id_producto
                                 GROUP BY 1 , 2, 3
                                 ORDER BY 4 DESC");
		    
		?>
		<form name="f1" action="" method="post"  >
		 <p>Reporte Emitido el <b><?php echo date('d-m-Y'); ?></b> a las <b><?php echo date('H:m:s') ?></b></p>
                 <br />
        <input type="button"  value="IMPRIMIR" class="button" style="margin-right:20px" onclick="window.print();" />
        <br />
            <table cellspacing="1" cellpading="1" class="listado">
              <thead>
                    <tr class="head">
                        <th class="titulo">Solucionario</th>
                        <th class="titulo">Precios: Público -  Privado -  Extranjero</th> 
                        <th class="titulo">Nº de veces comprado</th>
                        <th class="titulo">Ver Datos del Solucionario</th> 
                   </tr>
              </thead>
                <tbody>
                <?php 
				$x=0;
				while($row=$sql->VerRegistro()) {?>
                    <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?>">
                      <td><?php echo $row['nombre_producto'] ?></td>
                      <td align="center">S/. <?php echo $row['precio_publico'] ?> &nbsp;-&nbsp; S/. <?php echo $row['precio_privado'] ?> &nbsp;-&nbsp; S/. <?php echo $row['precio_extranjero'] ?></td>
                      <td align="center"><?php echo $row['total'] ?> Veces</td>
                      <td align="center"><a href="solucionarios.php?id=<?php echo $row['id_producto'] ?>&action=edit"><img src="<?php echo _icons_ ?>view.gif" border="0" /></a></td>
                   </tr>
                <?php $x++;} ?>   
                </tbody>
                      
       	 </table>
</form>
		<?php
	}
		
	public function reportClientesCompras($idioma, $smg){
			
            $sql = new Consulta("SELECT c.id_cliente, c.nombre_cliente, c.apellidos_cliente, COUNT( c.id_cliente ) AS total
                     FROM  pedidos p, clientes c 
                     WHERE  c.id_cliente = p.id_cliente
                     GROUP BY 1,2,3
                     ORDER BY 4 DESC");

		?>
		<form name="f1" action="" method="post"  >
		  <p>Reporte Emitido el <b><?php echo date('d-m-Y'); ?></b> a las <b><?php echo date('H:m:s') ?></b></p>
                    <br />
           <input type="button"  value="IMPRIMIR" class="button" style="margin-right:20px" onclick="window.print();" /><br />
            <table cellspacing="1" cellpading="1" class="listado">
              <thead>
                    <tr class="head">
                        <th class="titulo">Cliente</th>
                        <th class="titulo">Nº de Pedidos</th> 
                        <th class="titulo">Ver Datos de Cliente</th> 
                   </tr>
              </thead>
                <tbody>
                <?php 
				$x=0;
				while($row=$sql->VerRegistro()) {?>
                    <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?>">
                      <td><?php echo $row['nombre_cliente'] ?> <?php echo $row['apellidos_cliente'] ?></td>
                      <td align="center"><?php echo $row['total'] ?> Pedidos</td>
                      <td align="center"><a href="clientes.php?action=edit&id=<?php echo $row['id_cliente'] ?>"><img src="<?php echo _icons_ ?>view.gif" border="0" /></a></td>
                   </tr>
                <?php $x++;} ?>   
                </tbody>
                      
       	 </table>
</form>
		<?php
	}

        public function reportHistorialRecargas(){

		if(!isset($_GET['pag'])){ $_GET['pag'] = 1; }
		$tampag = 20;
		$reg1 = ($_GET['pag']-1) * $tampag;


                if($_GET['q'] != ''){
			$q = $_GET['q'];
			$like_n  = " AND  CONCAT(c.nombre_cliente, ' ', c.apellidos_cliente) LIKE '%".$q."%'";

		}

		$sql = "SELECT   c.id_cliente, c.nombre_cliente, c.apellidos_cliente, h.monto_recarga, h.fecha_recarga, h.hora_recarga
                                 FROM   clientes c, recargas_clientes h
                                 WHERE  c.id_cliente = h.id_cliente ".$like_n." 
                              
                                 ORDER BY 5,6 DESC";

		$queryt= new Consulta($sql);
		$num=$queryt->NumeroRegistros();
		$limit=$sql_pag." LIMIT ".$reg1.",".$tampag."";

		$sql .= $limit ;

		$Query = new Consulta($sql);	 ?>
        <div id="content-area">

            <p>Reporte Emitido el <b><?php echo date('d-m-Y'); ?></b> a las <b><?php echo date('H:m:s') ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  value="IMPRIMIR" class="button" style="margin-right:20px" onclick="window.print();" /></p>
                    <br />

		<table  cellspacing="1" cellpading="1"   class='listado' >
			<thead>
            <tr class="head">
				
                                <th class='titulo'>Cliente </th>
				<th class='titulo' align="center">Monto Recargado </th>
				<th class='titulo' align="center">Fecha Recarga </th>
				<th class='titulo' align="center">Hora Recarga </th>
				
			</tr>
			</thead>
            <tbody>
			<?php
		$x=1;
		$z=0;
		while ($row = mysql_fetch_array($Query->Consulta_ID)){?>
			<tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?>">
				
                                <td align="left" class='celda'> <?php echo $row['apellidos_cliente']?>, <?php echo $row['nombre_cliente']?></td>
				<td align="center" class='celda'>  <?php echo number_format($row['monto_recarga'],2); ?> </td>
                                <td align="center" class='celda'> <?php echo fecha_long($row['fecha_recarga'])?> </td>
				<td align="center" class='celda'> <?php echo $row['hora_recarga'] ?> </td>
				
            </tr>
			<?php
			if($x==0){$x++;}else{$x=0;}
			$z++;
		}?>
        </tbody>
		</table>
		</div>
		<?php

		if( $num > $tampag ){ echo paginar($_GET['pag'], $num, $tampag, "pedidos.php?pag="); }
	}
		
}
?>