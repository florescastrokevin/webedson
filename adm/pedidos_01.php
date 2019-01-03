<?php include("inc.aplication_top.php");

include(_includes_."admin/inc.header.php"); 
$ubigeo = new Ubigeos();
$distritos = $ubigeo->getDistritosConCobertura(1401); 
?>

<body>
	<div id="dw-window"> 
    	<div id="dw-admin">
            <div id="dw-menu">
               <!-- Menu -->
               <?php include(_includes_."admin/inc.top.php"); ?>
            </div>
            <div id="dw-page">
                <div id="dw-cuerpo">
                    <h1>Administrar Pedidos
                        <div id="filtro" title="Opciones de Filtrado">
                                <form name="form" class="form_filtro" id="filtro" onSubmit="return validate_search(this)">
                                	<ul>
                                    	<li><label>Nro Pedido:</label><input class="text ui-widget-content ui-corner-all" type="text" name="pedido" value=""></li>
                                        <li><label>Estado:</label><select name="estado" class="noestile" id="estado" style="width:160px">
                                                                    <option value="">- Elija Estado -</option>
                                                                    <option value="Registrado">Registrado</option>
                                                                    <option value="Solicitado">Solicitado</option>
                                                                    <option value="Confirmado">Confirmado</option>
                                                                    <option value="Pagado">Pagado</option>
                                                                    <option value="PagadoBoleta">Pagado Boleta</option>
                                                                    <option value="Pagado-IPN">Pagado-IPN</option>
                                                                    <option value="Pendiente">Pendiente</option>
                                                                    <option value="Entregado">Entregado</option>
                                                                    <option value="DireccionError">Direcci贸n Incorrecta</option>
                                                                    <option value="PersonaNoUbicada">Persona no ubicada</option>
                                                                </select>
                                        
                                        </li>
                                        <li><label>Cliente:</label><input class="text ui-widget-content ui-corner-all" type="text" name="cliente" value=""></li>
                                        <li><label>Distrito:</label>
                                                <select name="distrito" class="noestile" id="distrito" style="width:200px">
                                                 <option value="">- Elija distrito -</option>   
												   <?php foreach ($distritos as $distrito):?>
                                                    <option value="<?php echo $distrito['id'];?>"><?php echo $distrito['nombre'];?></option>   
                                                   <?php endforeach;?>    
                                                </select>
                                        </li>
                                        <li><label>Fecha Desde:</label><input class="text ui-widget-content ui-corner-all" type="text" name="fecha_envio_init" id="fecha_envio_init" value=""></li>  
                                        
                                        <li><label>Fecha Hasta:</label><input class="text ui-widget-content ui-corner-all" type="text" name="fecha_envio_fin" id="fecha_envio_fin" value=""></li>                                                                     
                                    </ul>
                                </form>
                        </div>
                        <span class="operations">
                           
                            <a href="<?php echo $_SERVER['PHP_SELF']?>">
                                <em>Listar</em>
                                <span></span>
                            </a>
                            <a id="btn_filtro">
                                <em>Filtros</em>
                                <span></span>
                            </a> 
                            <?php if($_GET['action'] != 'edit' ){?>
                            <a id="resumen">
                                <em>Resumen pedidos</em>
                                <span></span>
                            </a>  
   							<?php }?>                                            
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=new">
                                <em>Nuevo Pedido</em>
                                <span></span>
                            </a>
                             
                        </span>
                    </h1>
                    <?php
                    
					$obj = new Ubigeos();
					
					
					$nombreParam=array_keys($_GET);
					$valuesParam=array_values($_GET);
					for ( $i=0 ; $i<count($nombreParam); $i++ ){
						if((!empty($valuesParam[$i])) && ($valuesParam[$i]!="Buscar") && ($valuesParam[$i]!="pag")){
							$gets[$nombreParam[$i]] = $valuesParam[$i];
						}
					}
					if(count($gets)>0){
					?>
                    <form name="form" class="select_filtro" id="select_filtro" onSubmit="return validate_search(this)">
                    <?php if(!$_GET['action']){ ?>
                    
                    <?php if(count($gets)>0):?>
                        	
                    <div class="ffiltros">
                    	<?php foreach($gets as $key=>$val):?>
                        <ul>                        
                        		<li class="head"><?php echo $key?>:</li>
                                <input type="hidden" name="<?php echo $key?>" value="<?php echo $val?>">
                                
								<?php $val = ($key=='distrito')?$obj->get_name_distrito($val):$val?>
                                <li class="ellipsis"><?php echo $val?></li>
                        </ul>
                        <?php endforeach;?>
                         <!--<input type="submit" name="buscar" class="buscar_filtro" value="Buscar">	-->
                    </div>  
                    
                        <?php endif;?>        
                                     
                   
                    <?php }?>
                    </form>
                    <br class="clear"><br class="clear">
                  <?php }else{ ?>
                  <form name="form" class="select_filtro" id="select_filtro" onSubmit="return validate_search(this)">
                  	<!--<input type="submit" name="buscar" class="buscar_filtro" style="display:none;" value="Buscar">-->
                  </form>
                  <?php }?>
                    
                   <?php echo $msgbox->getMsgbox(); ?>
                   <?php
				$obj =  new Pedidos($msgbox);
				if($_GET['action']){
					$accion = $_GET['action']."Pedidos";	
					$obj->$accion();
				}else{
					$obj->listPedidos();
				}
				?>	
                </div>
            </div> 
			                       
        </div>
    </div>

</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>