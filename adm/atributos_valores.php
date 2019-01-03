<?php include("inc.aplication_top.php");
include(_includes_."admin/inc.header.php"); ;
if(isset($_GET['id1'])){$_SESSION['ida'] = $_GET['id1'];} 
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
                    <h1>Adiministrar Atributos
                        <span class="operations">
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list">
                                <em>Listar</em>
                                <span></span>
                            </a>                         
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=new">
                                <em>Nuevo Valor</em>
                                <span></span>
                            </a>
                        </span>
                    </h1>
			<?php echo $msgbox->getMsgbox(); ?>
            <div id="nav">
            	<?php $atributo = new Atributo($_SESSION['ida']);?>
                <a href="atributos.php">Atributos</a>
            	>  <?php echo $atributo->__get("_nombre");?> </a>
			</div>
			<?php
				$obj =  new AtributosValores( $msgbox, $sesion->getUsuario()  );
				if($_GET['action']){
					$accion = $_GET['action']."AtributosValores";	
					$obj->$accion($_SESSION['ida']);
				}else{
					$obj->listAtributosValores($_SESSION['ida']);
				}
				?>
                 </div>
            </div> 
			                       
        </div>
    </div>

</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>