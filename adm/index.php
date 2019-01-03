<?php include("inc.aplication_top.php");
// Recordar por 30 dias la cuenta.
if($_POST){
    if($_POST['recordar_si_MKD'] == 'si')
    {
        setcookie ("pass_MKD", "$_POST[password]", time () + 2592000);
        setcookie ("email_MKD", "$_POST[login]", time () + 2592000);
    }else{
        setcookie ("pass_MKD", "", time () + 604800);
        setcookie ("email_MKD", "", time () + 604800);
    }
}
if ($_GET['section']) {
    switch ($_GET['section']) {
        case 'home':
            $template = "home";
            $js = "home";
            break;
        case 'configuracion':
            $lista_config = Configuration::getConfiguracion();
            $template = "configuracion";
            $js = "configuracion";
            break;
        case 'usuarios':
            $lista_usu = Usuarios::getUsuarios();
            $template = "usuarios";
            $js = "usuarios";
            break;
        case 'categorias':
            $template = "categorias";
            $js = "categorias";
            break;
        case 'ocasiones':
            $template = "ocasiones";
            $js = "ocasiones";
            break;
        case 'productos':
            $template = "productos";
            $js = "productos";
            break;
        case 'filtros':
            $template = "filtros";
            $js = "filtros";
            break;
        case 'categorias_filtros':
            if ($_GET['action']) {
                switch($_GET['action']){             
                    default:   
                        $lista_usu = Usuarios::getUsuarios(); 
                        $template = "ocasiones";
                        $js = "ocasiones";
                    break; 
                }
            }
            $lista_cate_filtro = CategoriasFiltros::getCategoriasFiltros();
            $lista_categorias = CategoriasFiltros::getCategoriasPadre('default');
            $lista_filtros = CategoriasFiltros::getFiltrosHijo('default');
            $template = "categorias_filtros";
            $js = "categorias_filtros";
            break;
        default:
            $template = "home";
            $js = "home";
            break;
    }
}else{
    $template = "home";
    $js = "home";
}
/*echo var_dump($lista_config);
die();*/
?>


<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v4.1/admin/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 21 Jun 2018 19:18:34 GMT -->
    <head>
        <?php include(_tpl_panel_includes_."inc.header.php"); ?>
    </head>
    <body>
        <!-- begin #page-loader -->
        <div id="page-loader" class="fade show"><span class="spinner"></span></div>
        <!-- end #page-loader -->
        
        <!-- begin #page-container -->
        <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
            <!-- begin #header #top #web -->
            
            <!-- end #header -->
            <?php include(_tpl_panel_includes_."inc.top.php"); ?>
            <!-- begin #sidebar -->
            <?php include(_tpl_panel_includes_."inc.menu.php"); ?>
            <!-- end #sidebar -->
            
            <!-- begin #content -->
            <?php include(_tpl_panel_template_.$template.".php"); ?>
            <!-- end #content -->
            
            <!-- begin scroll to top btn -->
            <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
            <!-- end scroll to top btn -->
        </div>
        <!-- end page container -->
        <?php include(_tpl_panel_includes_."inc.bottom.php"); ?>
        <script src="<?php echo _admin_assets_js.$js?>.js"></script>
        <script>
            $(document).ready(function() {
                App.init();
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v4.1/admin/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 21 Jun 2018 19:19:12 GMT -->
</html>