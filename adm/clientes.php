<?php include("inc.aplication_top.php");
include(_tpl_panel_includes_."inc.header.php");  ?>
<body>
	<div id="dw-window"> 
    	<div id="dw-admin">
            <div id="dw-menu">
               <!-- Menu -->
               <?php include(_tpl_panel_includes_."inc.top.php"); ?>
            </div>
            <div id="dw-page">
                <div id="dw-cuerpo">
                    <h1>Clientes
                        <span class="operations">
                            <a href="<?php echo $_SERVER['PHP_SELF']?>">
                                <em>Listar</em>
                                <span></span>
                            </a>
                             <a href="javascript:;" onClick="search_cliente()">
                                <em>Buscar Cliente</em>
                                <span></span>
                            </a>
                        </span>
                    </h1> 
                    <?php echo $msgbox->getMsgbox(); 
                        $obj = new Clientes($msgbox);
                        if($_GET['action']){
                                $act = $_GET['action']."Clientes";
                                $obj->$act();
                        }else{
                                $obj->listCRMClientes();
                        }
                    ?>
                </div>
            </div> 
        </div>
    </div>
</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>