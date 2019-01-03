<?php 
include("inc.aplication_top.php");
	
$operador = (!empty($_GET['action'])) ? $_GET['action'] : 'list' ;
switch( $operador ){
	case 'add': case 'delete': case 'update':  
		$o =  new Ofertas( $msgbox, $sesion->getUsuario() );
		$class = ucfirst(get_class($o));
		$accion = $operador.$class;
		$o->$accion();			
	break;
	default:
		$obj =  new Ofertas( $msgbox, $sesion->getUsuario() );
		$class = ucfirst(get_class($obj));
		$accion = $operador.$class;
	break;
}

//include(_includes_."admin/inc.header_default.php");
//include(_inc_mod_admin_. basename($_SERVER['PHP_SELF'],'.php')."/inc.header.php");
include(_tpl_panel_includes_."inc.header.php");
?>
</head>
<body>
	<div id="dw-window"> 
    	<div id="dw-admin">
            <div id="dw-menu">
               <!-- Menu -->
               <?php include(_tpl_panel_includes_."inc.top.php"); ?>
            </div>
            <div id="dw-page">
                <div id="dw-cuerpo">
                    <h1>Ofertas
                        <span class="operations">
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list">
                                <em>Listar</em>
                                <span></span>
                            </a>
                             <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=new">
                                <em>Nuevo</em>
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