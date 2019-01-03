<?php include("inc.aplication_top.php");
include(_tpl_panel_includes_."inc.header.php"); 

//echo 'CAT:'.$_SESSION['categoria'];

$idcat = (isset($_GET['cat'])) ? $_GET['cat'] : $_SESSION['categoria'];
$_SESSION['categoria'] = $idcat;
?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
 
<script>
$(document).ready(function(){
    $('#myTable').DataTable( {
        "lengthMenu": [[120, 240, 360, -1], [120, 240, 360, "All"]],
        language:{
	    "sProcessing":     "Procesando...",
	    "sLengthMenu":     "Mostrar _MENU_ Servicios",
	    "sZeroRecords":    "No se encontraron resultados",
	    "sEmptyTable":     "Ningún dato disponible en esta tabla",
	    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix":    "",
	    "sSearch":         "Buscar:",
	    "sUrl":            "",
	    "sInfoThousands":  ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
	        "sFirst":    "Primero",
	        "sLast":     "Último",
	        "sNext":     "Siguiente",
	        "sPrevious": "Anterior"
	    },
	    "oAria": {
	        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	    }
	} 
    } );
    
});
</script>
<body>
	<div id="dw-window"> 
    	<div id="dw-admin">
            <div id="dw-menu">
               <!-- Menu -->
               <?php include(_tpl_panel_includes_."inc.top.php"); ?>
            </div>
            <div id="dw-page">
                <div id="dw-cuerpo">
                    <h1>Administrar Productos
                        <span class="operations">
                            <a href="javascript:moveProductos();">
                                <em>Mover a</em>
                                <span></span>
                            </a>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list">
                                <em>Listar</em>
                                <span></span>
                            </a>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?actioncat=new">
                                <em>Nueva Categoria</em>
                                <span></span>
                            </a>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=new">
                                <em>Nuevo Producto</em>
                                <span></span>
                            </a>
                        </span>
                    </h1>
                    <?php echo $msgbox->getMsgbox(); ?>
                	<?php
				$obj_categoria =  new Categoria($idcat, $idioma);
				$obj_c = new Categorias($msgbox);
				$obj   = new Productos($idioma, $msgbox, $sesion->getUsuario());
				?>
                <?php if($idcat > 0){ ?>
                        <div id="nav"><?php 				
                            $navegador = new Navegador($idioma);
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
					$accion = $_GET['actioncat']."Categorias";	
					$obj_c->$accion($obj_categoria->__get('_id'));
					if($_GET['actioncat'] == 'add' || $_GET['actioncat'] == 'update' || $_GET['actioncat'] == 'delete'){
						$obj->listProductos($obj_categoria->__get('_id'));
					}
				}
                // Create new product
				if(!isset($_GET['actioncat'])){
					if($_GET['action']){
						$accion = $_GET['action']."Productos";	
						$obj->$accion($obj_categoria->__get('_id'));
					}else{
						$obj->listProductos($obj_categoria->__get('_id'));
					}
				}?>
                </div>
            </div> 
        </div>
    </div>
</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>