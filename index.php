<?php
include("inc.aplication_top.php");  
$action = $_GET["action"]; /* solo se usa en el blog*/
$lista_destacado = Productos::getProductosDestacados();
$tpl = "tpl_home.php";
$js = "home";
if($_SERVER['QUERY_STRING']){
    $modulo = $_GET['modulo'];
    switch ($modulo) {
        case 'categoria':
            $catalogo = new Catalogo;
            if ($_GET['suburl']) {
                $lista_productos = $catalogo->getCatalogoPorCategoria($_GET['suburl']);
            }else{
                $lista_productos = $catalogo->getCatalogoPorCategoria($_GET['url']);
            }
            $menu_navegacion_left = $catalogo->getMenuNavegacionProductos('c',$_GET['url']);
            // echo var_dump($menu_navegacion_left);
            // die();
            $tpl = "tpl_catalogo.php";
            $js = "catalogo";
        break;
        case 'filtro':
            if ($_GET['suburl']) {
                $catalogo = new Catalogo;
                $lista_productos = $catalogo->getCatalogoPorFiltro($_GET['suburl']);
            }else{
                $catalogo = new Catalogo;
                $lista_productos = $catalogo->getCatalogoPorFiltro($_GET['url']);
            }
            $menu_navegacion_left = $catalogo->getMenuNavegacionProductos('f',$_GET['url']);
            $tpl = "tpl_catalogo.php";
            $js = "tpl_catalogo";
            break;
        case 'busqueda':
            $catalogo = new Catalogo;
            $lista_productos = $catalogo->getCatalogoPorBusqueda($_GET['url']);
            // echo "<pre>";
            // echo var_dump($lista_productos);
            // die();
            $tpl = "tpl_busqueda.php";
            $js = "tpl_busqueda";
            break;
        case 'producto':
            $id_producto = Productos::getIdByUrl($_GET['url']);
            $tpl = "tpl_catalogo_detalle_producto.php";
            $js = "catalogo_detalle_producto";
            break;
        case 'blog':
            if ($_GET['url']) {
                $tpl = "tpl_blog_detalle.php";
                $js = "blog_detalle";
            }else{
                $tpl = "tpl_blog_home.php";
                $js = "blog_home";
            }
            break;
        case 'nosotros':
            $tpl = "tpl_nosotros.php";
            $js = "";
            break;
        case 'como-comprar':
            $tpl = "tpl_como_comprar.php";
            $js = "";
            break;
        case 'delivery':
            $tpl = "tpl_delivery.php";
            $js = "";
            break;
        case 'formas-pago':
            $tpl = "tpl_formas_pago.php";
            $js = "";
            break;
        case 'libro-de-reclamaciones':
            $tpl = "tpl_libro_reclamaciones.php";
            $js = "";
            break;
        case 'devoluciones':
            $tpl = "tpl_devoluciones.php";
            $js = "";
            break;
        case 'politica-y-privacidad':
            $tpl = "tpl_politica_privacidad.php";
            $js = "";
            break;
        case 'terminos-y-condiciones':
            $tpl = "tpl_terminos_condiciones.php";
            $js = "";
            break;
        case "M&aacute;s buscados";
            $secciones->loMasBuscado();  
            break;   
        case "pagina":
            $id_pagina = Paginas::getIdByURL($_GET["accion"]);
            if($id_pagina > 0){
                $obj_pagina = new Pagina($id_pagina); 
                $titulo =  $obj_pagina->__get('_titulo').' - '.NOMBRE_SITIO;
                $descripcion = $obj_pagina->__get('_descripcion');
                $_GET['pagina'] = $id_pagina;
            }
            
            if(preg_match('/lo mas buscado/',$nombre)){     
                $_GET['section'] = 'M&aacute;s buscados';
                $titulo = "Lo Regalos mas Buscados en Lima, Perú ".' - '.NOMBRE_SITIO;
                $descripcion = "Lo Regalos y Detalles mas Buscados en Lima, Perú ".' - '.NOMBRE_SITIO;
            }
            if(preg_match('/Libro-de-Reclamaciones/i',$_GET['n'])){
                Paginas::libroReclamaciones();  
            }else{ 
               $tpl = "tpl_pagina.php"; 
            }
            break;
        case "notificacion":
            switch($_GET["accion"]){
                case 'paypal';
                    Paypal::notificacion();
                break;
                default :
                break;
            }
            break;
        case "pedido":
            if($cuenta->getCliente()->getLogeado()==FALSE){ 
                header("location: "._url_web_."seccion/cuenta?linkF=2"); /*tengo pedido en carrito*/
            }else{
                if($cuenta->getCliente()->getCarrito()->count_Content() == 0){ header("location: "._url_web_."seccion/cesta");} 
                if(!isset($_SESSION['donregalo_pedido']) || empty($_SESSION['donregalo_pedido']) || !(is_object($_SESSION['donregalo_pedido']))){   /*defino mi clase pedido */ 
                    $_SESSION['donregalo_pedido'] = new Pedido();            
                    $pedido = $_SESSION['donregalo_pedido'];
                    $pedido->setCliente($cuenta->getCliente());
                    $pedido->setCarrito($cuenta->getCliente()->getCarrito());
                }else{
                    $pedido = $_SESSION['donregalo_pedido'];        
                }
                //asigno nuevamente el carrito por si han habido cambios, tambien a cliente
                $pedido->setCarrito($cuenta->getCliente()->getCarrito());
                $pedido->setCliente($cuenta->getCliente());
                switch($_GET["accion"]){
                    case 'finalizado';
                        $tpl = "tpl_pedido_finalizado.php";
                        $js = "pedido_finalizado";
                    break;    
                    case 'confirmado':                     
                        $pedido->setEstado("Confirmado");
                        header("location:"._url_web_."seccion/pedido/finalizado/".$pedido->getId()."");
                        //$tpl = "tpl_pedido_pago.php";
                    break;
                    case 'confirmacion':
                        if( $_POST['state'] == 'pago' ){
                            $pedido->setMetodoPago($_POST["pago"]);
                            $pedido->setComprobantePago();
                            $pedido->setCodigo();
                            $pedido->setEstado("Solicitado");
                        }   
                        $tpl = "tpl_pedido_confirmar.php";   
                        $js = "pedido_confirmar";                        
                    break;
                    case 'pago':                
                        $pedido->setEstado("Registrado");
                        if( $_POST['state'] == 'envio' ){
                            $pedido->setDestinatario();
                        }
                        $tpl = "tpl_pedido_pago.php";
                        $js = "pedido_pago";
                    break; 
                    default;
                        $subtitulo = "DATOS DE ENVIO";
                        $tpl = "tpl_pedido_envio.php";
                        $js = "pedido_envio";
                    break;      
                }
            }
            break;  
        case "cuenta";
            if( $cuenta->getCliente()->getLogeado() == FALSE){
                switch( $_GET['accion'] ){
                    case 'registro':
                        $tpl = "tpl_cuenta_lregistro.php";
                    break;
                    case 'login':
                        $tpl = "tpl_cuenta_login.php";
                    break;
                    case 'password-recuperar':
                        $tpl = "tpl_cuenta_password_recuperar.php";
                    break;
                    default:
                        $tpl = "tpl_cuenta_login.php";
                    break;   
                }
            }else if($cuenta->getCliente()->getLogeado() == TRUE){ 
                $cuenta->getCliente()->getCarrito()->RestaurarCarrito();
                
                switch( $_GET['accion'] ){
                    case 'salir':
                        $cuenta->cerrarSession();
                        header("Location:"._url_web_);
                    break;
                    case 'login':
                        $tpl = "tpl_cuenta_login.php";
                    break;
                    case 'password-edit':
                        $tpl = "tpl_cuenta_password_edit.php";
                        $js = "cuenta_password_edit";
                    break;    
                    case 'password-update': 
                        $cuenta->passwordUpdate();
                        header("Location:"._url_web_."seccion/cuenta");
                    break;
                    case 'pedido-detalle':
                        $obj_pedido = new Pedido($_GET['code']);
                        $tpl = "tpl_cuenta_pedidos_detalle.php";
                    break;
                    case 'pedidos':
                        $tpl = "tpl_cuenta_pedidos.php";
                        $js = "cuenta_pedidos";
                    break;
                    case 'edit';
                        $tpl = "tpl_cuenta_edit.php";
                        $js = "cuenta_edit";
                    break;   
                    case 'fechas-especiales';
                        $tpl = "tpl_cuenta_fechas_especiales.php";
                        $js = "cuenta_fechas_especiales";
                    break;   
                    default: 
                        $tpl = "tpl_cuenta_dashboard.php";
                    break;
                } 
            }
            break; 
        case "cesta"; 
            $tpl = "tpl_cesta.php";
            $js = "cesta";
            break;
        case "blog";
            if( isset($_GET['nl']) ){

                $param = end(explode('/',$_GET['nl'])); 
                $idcatblog = CategoriasBlog::getIdByNameBlog(str_replace('-',' ',$param));

                if( $_GET['nl']=='' || $_GET['nl']=='/'  ){
                    $_GET['action'] = 'list';
                    $_GET['pagb'] = 1;
                    $titulo = "Blog ".' - '.NOMBRE_SITIO;
                    $descripcion = "Blog de Regalos y Detalles ".' - '.NOMBRE_SITIO;
                }else if(isNaN($param)){
                    $_GET['pagb'] = $param;
                    $_GET['action'] = 'list';
                    $temp = explode('/',$_GET['nl']);
                    if(count($temp)>2){
                        $_GET['catb'] = CategoriasBlog::getIdByNameBlog(str_replace('-',' ',$temp[1]));
                    }
                }
                else if( $idcatblog > 0 ){
                    $_GET['catb'] = $idcatblog;     
                    $_GET['action'] = 'list';   
                }else{
                    $temp = explode('/',$_GET['nl']);
                    if(count($temp)>2){
                        $_GET['catb'] = CategoriasBlog::getIdByNameBlog(str_replace('-',' ',$temp[1]));
                    }
                    $_GET['action'] = 'detail'; 
                }

                if(preg_match('/q=/',$_GET['nl'])){     
                    $q = end(explode('/q=',$_GET['nl']));
                    $_GET['qb'] = $q;
                    $_GET['action'] = 'list';
                }
            }

            $tpl = 'tpl_blog_home.php';
            $js = 'blog_home';
            break;
        default:
            $obj_categoria = '';
            $obj_producto = '';
            
            if($_SERVER['QUERY_STRING'] && $_GET['n'] && !empty($_GET['n']) || 
                $_GET['cat'] && !empty($_GET['cat'])  || 
                $_GET['fb_action_ids'] && !empty($_GET['fb_action_ids'])){

                if($_GET['o']){//Reescribir para el ordenamiento
                //  $_GET['o'] = 'mayor-menor';
                    if(preg_match('/_all/',$_GET['o'])){
                        list($o,$mostrar) = explode('_',$_GET['o']);
                        if( !empty($mostrar)  ){
                            $_GET['o'] = $o;
                            $_GET['see'] = $mostrar;
                        }
                    }
                    $urltemp = explode("&o=",$_SERVER['QUERY_STRING']);
                    $_SERVER['QUERY_STRING'] = $urltemp[0];
                }
                //echo 'URL TOTAL '.$_SERVER['QUERY_STRING'].'<br/>';
                if( $_GET['fb_action_ids'] ){
                    //echo 'ENVIO GET FB';
                    $urltemp = explode("&fb_action_ids=",$_SERVER['QUERY_STRING']);
                    $_SERVER['QUERY_STRING'] = $urltemp[0];
                }

                if( preg_match("/&/i",$_SERVER['QUERY_STRING']) ){ // validando el  $_GET['n']		
                    if( preg_match("/&utm_source=/i",$_SERVER['QUERY_STRING']) ){
                        $tmpn = explode("&utm_source=",$_GET['n']);
                        $_GET['n'] = $tmpn[0];				
                    }else		
                    $_GET['n'] = end(explode("=",$_SERVER['QUERY_STRING']));
                } 

                //Validando "en" 
                $get_n = $_GET['n'];
                $get_cat = explode("-en-",$_GET['n']);

                if(!empty($get_cat[1])){
                    // Validando categoria con "EN"
                    $get_cat_con_en = $get_cat[0].'-en-'.$get_cat[1]; // juntamon el primero y el segundo elemento del array por que pueden haber 3
                    $nombre_get = str_replace("-"," ",$get_cat_con_en);        
                    $categoria_con_en = Catalogo::existeCategoriasConEn($nombre_get);  

                    if( $categoria_con_en > 0 ){ 
                        $get_cat[0] = $get_cat_con_en;            
                        if($get_cat[2]){ // validamos si es que existe el segundo "en" para ponerselo a la categoria
                            $_GET['en'] = " en ".str_replace("-"," ",$get_cat[2]); 
                        }else{
                            $_GET['en'] = "";
                        }
                    }else{
                         $_GET['en'] = " en ".str_replace("-"," ",$get_cat[1]);
                    } 
                }else{       
                    $_GET['en'] = "";        
                }

                $get_cat = explode("_",$get_cat[0]);  
                $_GET['n'] = $get_cat[0];
                // fin fe "EN"

                // VALIDACION DE mostrar todos  
                if(preg_match('/_all/', $_SERVER['QUERY_STRING'])){
                    $_GET['see'] = 'all'; 
                }
                /*if( $get_cat[2]!="" ){
                    $_GET['see'] = $get_cat[2];	
                    echo $get_cat[2];
                }*/ 
                $nombre = str_replace("-"," ",$_GET['n']);
                //echo 'NOMBRE:'.$nombre;

                if($_GET['cat'] && !empty($_GET['cat'])){         
                    $idcategoria = $_GET['cat'];
                }else{
                    $idcategoria  = Categorias::getIdByName($nombre);        
                }

                $id_categoria = $idcategoria != "" ? $idcategoria : 999999;
                if( $id_categoria != 999999 ){ 
                    $obj_categoria = new Categoria($id_categoria);
                    //$titulo =  $nombre.$_GET['en'].' '.$obj_categoria->__get('_titulo').' - '.NOMBRE_SITIO;
                    $titulo = str_replace("_"," ",str_replace("-"," ",$get_n).' '.$obj_categoria->__get('_titulo')).' - '.NOMBRE_SITIO;
                    $descripcion = $titulo.'. '.$obj_categoria->__get('_descripcion');         
                    $_GET['cat'] = $id_categoria;      	
                }       

                $_GET['pag'] = ( count($get_cat)==1 )?1: (( $get_cat[1]=='0' )?1: ((isNaN(end($get_cat)))?end($get_cat):1));
                if( (int)$get_cat[1] > 0 ){ $filtro = 0; } // eliminamos filtro si no es númerico

                if( $obj_categoria == '' ){
                    $id_producto = Productos::getIdByName($nombre);
                    if($id_producto > 0){
                        $obj_producto = new Producto($id_producto); 
                        $titulo =  $nombre.' - '.NOMBRE_SITIO;
                        $descripcion = $obj_producto->__get('_descripcion');
                        $_GET['prod'] = $id_producto;
                    }

                    if($_GET['filtro']){ //si no hay categoria y si hay filtro
                        $titulo =  ucfirst($get_cat[0]).' '.$get_cat[1].' '.$_GET['filtro'].' - '.NOMBRE_SITIO;
                        $descripcion = $titulo." - ";
                    }
                }
            }else if(isset($_GET['q'])){
                $bs = str_replace("+"," ",$_GET['q']);
                $titulo = $bs.' - '.NOMBRE_SITIO;
                $descripcion = $bs.", ".$descripcion;
            }
            
            if( $id_producto && $id_producto > 0 ){
                $tpl = "tpl_catalogo_detalle_producto.php";
                $js = "catalogo_detalle_producto";
            }elseif($modulo == "ofertas"){ 
                $titulo = "Regalos Economicos - Regalos en Oferta ".' - '.NOMBRE_SITIO;
                $descripcion = "Ofertas de Regalos y Detalles en Lima Perú ".' - '.NOMBRE_SITIO;
                $tpl = "tpl_catalogo_ofertas.php"; 	

            }else{   /* catalogo */ 
                $rows = 0;
                $catalogo = new Catalogo();
                $filtro = $catalogo->getFiltro();
                $_SESSION['catalogo_filtro'] = $filtro;
                if( is_array($filtro) && count($filtro) > 0 ){
                    $catalogo->asignarFiltro($filtro);
                }
                //$this->listado($rows); 
                $pagina = $_GET['pag'] - 1;
                $tpl = "tpl_catalogo.php"; 
                $js = "tpl_catalogo";
                if(!isset($_GET['q'])){ $margin = 'margin-left:200px;'; }						
            }
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include(_tpl_includes_."inc.header.php"); ?>
    </head>
    <body>
        <!--cabecera-->
        <?php include(_tpl_includes_ . "inc.top.php"); ?>
        <?php include(_tpl_.$tpl); ?>


        <?php include(_tpl_includes_."inc.modal.php"); ?>
        <!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
        <script type="text/javascript" src="<?php echo _tpl_js_ ?>vendor.min.js"></script>
        <script type="text/javascript" src="<?php echo _tpl_js_ ?>scripts.min.js"></script>
        <script type="text/javascript" src="<?php echo _tpl_js_ ?>datepicker.js"></script>
        <script type="text/javascript" src="<?php echo _tpl_js_ ?>sweet.js"></script>
        <script type="text/javascript" src="<?php echo _tpl_js_ ?>jquery-ui.js"></script>
        <!-- Customizer scripts-->
        <script type="text/javascript" src="<?php echo _tpl_js_ ?>general.js"></script>
        <script type="text/javascript" src="<?php echo _tpl_js_.$js ?>.js"></script>
    </body>
</html>

