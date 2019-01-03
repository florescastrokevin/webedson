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
                    <h1>Reporte Consolidado
                        <span class="operations">
                            <a href="#" data-toggle="modal" data-target="#modal-filtro">
                                <em>Filtro</em>
                                <span></span>
                            </a> 
                            <a href="<?php echo $_SERVER['PHP_SELF']?>?<?php echo $_SERVER['QUERY_STRING']?> ">
                                <em>Actualizar</em>
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
                                $obj->listPedidosInsumos();
                        }
                    ?>	
                </div>
            </div> 
			                       
        </div>
    </div>

</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>