<?php include("inc.aplication_top.php");
include(_tpl_panel_includes_."inc.header.php"); 
$idcat = (isset($_GET['cat'])) ? $_GET['cat'] : $_SESSION['categoria'];
$_SESSION['categoria'] = $idcat;
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
                    <h1>Administrar Blog
                        <span class="operations">
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list">
                                <em>Listar</em>
                                <span></span>
                            </a>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?actioncat=new">
                                <em>Nueva Categoria Blog</em>
                                <span></span>
                            </a>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=new">
                                <em>Nuevo Post</em>
                                <span></span>
                            </a>
                        </span>
                    </h1>
                    <?php echo $msgbox->getMsgbox(); ?>
                	<?php
				$obj_categoria =  new CategoriaBlog($idcat);
				$obj_c = new CategoriasBlog($msgbox);
				$obj   = new Posts($msgbox);
				?>
                <?php if($idcat > 0){ ?>
                        <div id="nav"><?php 				
                            $navegador = new NavegadorBlog();
                            $idp = isset($_GET['id']) ? $_GET['id'] : 0;
                            $idc = $idcat;
                            $ide = isset($_GET['ide'])  ? $_GET['ide']  : 0;
                            $id_actual = $idp > 0 ? $idp : $idc;
                            $navegador->bucleCatTrail($idc, $idp, $ide);		
                            echo  $navegador->display($id_actual);
                        ?>
                        </div>
				<?php
				}
				if($_GET['actioncat']){
					$accion = $_GET['actioncat']."CategoriasBlog";	
					$obj_c->$accion($obj_categoria->__get('_id'));
					if($_GET['actioncat'] == 'add' || $_GET['actioncat'] == 'update' || $_GET['actioncat'] == 'delete'){
						$obj->listPost($obj_categoria->__get('_id'));
					}
				}
                // Create new product
				if(!isset($_GET['actioncat'])){
					if($_GET['action']){
						$accion = $_GET['action']."Post";	
						$obj->$accion($obj_categoria->__get('_id'));
					}else{
						$obj->listPost($obj_categoria->__get('_id'));
					}
				}?>
                </div>
            </div> 
        </div>
    </div>
</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>