<?php include("inc.aplication_top.php");

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
                    <h1>Administrar Pedidos
                        <span class="operations">
                            <a href="<?php echo $_SERVER['PHP_SELF']?>">
                                <em>Listar</em>
                                <span></span>
                            </a>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list&filtro=pagfech">
                                <em>Listar Pagados</em>
                                <span></span>
                            </a>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=new">
                                <em>Nuevo Pedido</em>
                                <span></span>
                            </a>
                             
                        </span>
                    </h1>
                     <?php echo $msgbox->getMsgbox(); ?>
                   <?php
				$obj =  new Pedidos($msgbox);
				if($_GET['action']){
					$accion = $_GET['action']."Pedidos";	
					$obj->$accion();
				}else{
					$obj->listPedidosCompleto();
				}
				?>	
                </div>
            </div> 
			                       
        </div>
    </div>

</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>