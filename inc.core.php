<?php 	

    //    include($_SERVER['DOCUMENT_ROOT']."/donregalo/app/inc.config.php");
	include("app/inc.config.php");
	
	define("_ruta_",$_config['server']['host']);
	define("_includes_",$_config['server']['host']."app/includes/");
	define("_url_web_",$_config['server']['url']);
	define("_url_actual_",$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
    $ruta_templates = _ruta_."app/view/front-end/".$_config['site']['tpl']."/";
    $url_templates = _url_web_."app/view/front-end/".$_config['site']['tpl']."/";
    define("_tpl_",$ruta_templates);
	define("_tpl_includes_",_tpl_."includes/");
    define("_tpl_css_",$url_templates."css/");
    define("_tpl_customize_",$url_templates."customizer/");
    define("_tpl_js_",$url_templates."js/");
    define("_tpl_imgs_",$url_templates."imgs/");
    define("_tpl_icons_",_tpl_imgs_."icons/");

    define("_tpl_resources_", "app/view/front-end/last/");
    
    define("_tpl_panel_",$_config['server']['host']."app/view/panel/");
    define("_tpl_panel_includes_",$_config['server']['host']."app/view/panel/includes/");
    define("_tpl_panel_js_",$_config['server']['url']."app/view/panel/js/");
    define("_tpl_panel_css_",$_config['server']['url']."app/view/panel/css/");
    define("_tpl_panel_imgs_",$_config['server']['url']."app/view/panel/imgs/");
        
	define("_imgsfile_",$_config["server"]["host"]."app/publicroot/imgs/");
	define("_imgs_",$_config["server"]["url"]."app/publicroot/imgs/");
	define("_catalogo_",$_config["server"]["url"]."app/publicroot/imgs/catalogo/");
	define("_link_file_",$_config['sitio']['host']."app/publicroot/imgs/catalogo/");
	define("_icons_",_imgs_."icons/");
	define("_admin_",_imgs_."admin/");
	define("_flash_",$_config["server"]["url"]."app/publicroot/flash/");
	
	define("_inc_mod_admin_","../aplication/includes/admin/");
	define("_js_admin_","../aplication/webroot/js/");
	
		
	define("_model_",$_config["server"]["host"]."app/model/");
	define("_view_",$_config["server"]["host"]."app/view/");
	define("_util_",$_config["server"]["host"]."app/utilities/");
	
	define('_moneda_' , '$');
	define('_currency_' , 'USD');
	
	define("_img_file_","app/utilities/img.php");
	define("_imagen_","ap/utilities/imagen.php");
	define("_imgs_prod_","app/publicroot/imgs/catalogo/");
	define("_language_",$_config["server"]["host"]."app/language/");
	define("_panel_admin_",$_config["server"]["host"]."dw-admin/");	
    define("_files_guias_entrega_",$_config["server"]["host"]."app/publicroot/archivos/guias_entrega/");	        		
    define("_url_guias_entrega_",$_config["server"]["url"]."app/publicroot/archivos/guias_entrega/");

    define("_admin_assets_",$_config['server']['url']."app/view/panel/assets/");
    define("_tpl_panel_template_",$_config['server']['host']."app/view/panel/template/");
    define("_admin_assets_js",$_config['server']['url']."app/view/panel/assets/js/");