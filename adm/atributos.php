<?php 
include("inc.aplication_top.php");
	
$operador = (!empty($_GET['action'])) ? $_GET['action'] : 'list' ;
switch( $operador ){
	case 'add': case 'delete': case 'update':  case 'addValores': case 'deleteValores': case 'updateValores':
		$a =  new Atributos( $msgbox, $sesion->getUsuario() );
		$class = ucfirst(get_class($a));
		$accion = $operador.$class;
		$a->$accion();			
	break;
	default:
		$obj =  new Atributos( $msgbox, $sesion->getUsuario() );
		$class = ucfirst(get_class($obj));
		$accion = $operador.$class;
	break;
}

include(_includes_."admin/inc.header_default.php");
include(_inc_mod_admin_. basename($_SERVER['PHP_SELF'],'.php')."/inc.header.php");


if(isset($_GET['id']) || isset($_GET['id1'])){
	$id = ($_GET['id'])? $_GET['id'] : $_GET['id1'];
	$_SESSION['ida'] = $id;
}
else if ( strpos($_GET['action'],"Valores")!==FALSE ){}
else{ $_SESSION['ida']= ""; }


?>
</head>
<body>
	<div id="dw-window"> 
    	<div id="dw-admin">
            <div id="dw-menu">
               <!-- Menu -->
               <?php include(_includes_."admin/inc.top.php"); ?>
            </div>
            <div id="dw-page">
                <div id="dw-cuerpo">
                    <h1>Atributos
                        <span class="operations">
                            <?php if( $_SESSION['ida']=="" ){?>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list">
                                <em>Listar</em>
                                <span></span>
                            </a>    
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=new">
                                <em>Nuevo Atributo</em>
                                <span></span>
                            </a>
                            <?php }else{?>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=listValores&id1=<?php echo $_SESSION['ida']?>">
                                <em>Listar</em>
                                <span></span>
                            </a> 
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=newValores&id1=<?php echo $_SESSION['ida']?>">
                                <em>Nuevo Valor</em>
                                <span></span>
                            </a>
                            <?php }?>
                        </span>
                    </h1>                    
                    <?php if( $_SESSION['ida']!="" ){?>
                        <div id="nav">
                            <?php $atributo = new Atributo($_SESSION['ida']);?>
                            <a href="atributos.php">Atributos</a>
                            > <?php echo $atributo->__get("_nombre");?></a>
                        </div>			
					<?php } ?>
                    
                    <?php   						
						//echo $msgbox->getMsgbox();
						$obj->$accion();
					?>	
                    
                </div>
            </div> 
			                       
        </div>
    </div>

</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>