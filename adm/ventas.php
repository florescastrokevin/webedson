<?php include("inc.aplication_top.php");

$operador = (!empty($_GET['action'])) ? $_GET['action'] : 'dashboard' ;
switch( $operador ){
	case 'add': case 'delete': case 'update':  
            $o =  new Ventas( $msgbox, $sesion->getUsuario() );
            $class = ucfirst(get_class($o));
            $accion = $operador.$class;
            $o->$accion();			
	break;
	default:
            $obj =  new Ventas( $msgbox, $sesion->getUsuario() );
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
                    <style>
                        #dw-cuerpo h1{position:relative; cursor:pointer  }
                        #dw-cuerpo h1 i{font-size:0.8em;position:absolute;top:5px;left:55px   }
                        #dw-cuerpo h1 .menu-venta{position: absolute; left:0px; top: 20px; z-index:9; display:none; background-color:#fff   }
                        #dw-cuerpo .menu-venta li{font-size:0.8rem; list-style:none; border-bottom:1px solid #e5e5e5 }
                        #dw-cuerpo h1:hover{color:#337ab7}
                        #dw-cuerpo h1:hover .menu-venta{display:block}
                        #dw-cuerpo .menu-venta li a{display: block; padding:10px; text-decoration:none  }
                        #dw-cuerpo .menu-venta li a:hover{background-color:#EEEEAA }
                        
                    </style>
                    <h1>Ventas <i class="glyphicon glyphicon-chevron-down"></i>
                        <ul class="menu-venta">
                            <li><a href="ventas.php?action=volumen">Volumen de Compra</a></li>
                            <li><a href="ventas.php?action=monto">Monto de Compra</a></li>
                            <li><a href="ventas.php?action=fechas">Fechas Especiales</a></li>
                            <li><a href="ventas.php?action=entrega">Días (x) Entrega</a></li>
                        </ul>
<!--                        <span class="operations">
                            <a href="<?php echo $_SERVER['PHP_SELF']?>">
                                <em>Listar</em>
                                <span></span>
                            </a>
                        </span>-->
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