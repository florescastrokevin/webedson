<?php include("inc.aplication_top.php");

$operador = (!empty($_GET['action'])) ? $_GET['action'] : 'list' ;
switch( $operador ){
	case 'add': case 'delete': case 'update':  
		$o =  new HistorialesCesta( $msgbox, $sesion->getUsuario() );
		$class = ucfirst(get_class($o));
		$accion = $operador.$class;
		$o->$accion();			
	break;
	default:
		$obj =  new HistorialesCesta( $msgbox, $sesion->getUsuario() );
		$class = ucfirst(get_class($obj));
		$accion = $operador.$class;
	break;
}

include(_tpl_panel_includes_."inc.header.php"); 
?>
<body>
	<div id="dw-window"> 
    	<div id="dw-admin">
            <div id="dw-menu">
               <!-- Menu -->
               <?php include(_tpl_panel_includes_."inc.top.php"); ?>
            </div>
            <div id="dw-page">
                <div id="dw-cuerpo">
                    <h1>Administrar Historial Cesta
                        <span class="operations">
                            <a href="<?php echo $_SERVER['PHP_SELF']?>">
                                <em>Listar</em>
                                <span></span>
                            </a>
                            
                        </span>
                    </h1>
					<?php 
					echo $msgbox->getMsgbox();
					$obj->$accion();
					?>	
                </div>
            </div> 
			                       
        </div>
    </div>
</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>