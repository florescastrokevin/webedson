<?php include("inc.aplication_top.php");

include(_includes_."admin/inc.header.php"); 
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
                    <h1>Administrar Horarios de Tutores
                        <span class="operations">
                            <a href="<?php echo $_SERVER['PHP_SELF']?>">
                                <em>Listar</em>
                                <span></span>
                            </a>
                            
                        </span>
                    </h1>
                    <?php echo $msgbox->getMsgbox(); ?>
                	 <?php
					$obj = new Usuarios($msgbox);
					if($_GET['action']){
						$act = $_GET['action']."Uusarios";
						$obj->$act();
					}else{
						$obj->listUsuariosHorarios();
					}
					?>
                </div>
            </div> 
			                       
        </div>
    </div>

</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>