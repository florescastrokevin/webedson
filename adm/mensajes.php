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
                    <h1>Administrar Mensajes Dedicatoria
                        <span class="operations">
                            <a href="<?php echo $_SERVER['PHP_SELF']?>">
                                <em>Listar</em>
                                <span></span>
                            </a>
                            <a href="<?php echo $_SERVER['PHP_SELF']?>?action=nuevo">
                                <em>Nuevo</em>
                                <span></span>
                            </a>
                        </span>
                    </h1>
					<?php echo $msgbox->getMsgbox();
                    $obj =  new Mensajes($msgbox);
					if($_GET['action']){
                    	$accion = $_GET['action']."Mensajes";	
                        $obj->$accion();
                    }else{
                    	$obj->listMensajes();	
                    }
					?>	
                </div>
            </div> 
			                       
        </div>
    </div>
</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>