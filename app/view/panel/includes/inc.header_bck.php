<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>  ADMINISTRACION - <?php echo NOMBRE_SITIO; ?> </title>
<?php //if( basename($_SERVER['PHP_SELF']) == 'clientes.php' ){ ?>
    <link type="text/css" rel="stylesheet" href="<?php echo _tpl_panel_css_ ?>bootstrap.min.css"/>
<?php //}?> 
<link rel="stylesheet" type="text/css" href="<?php echo _tpl_panel_css_ ?>admin.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo _tpl_js_ ?>fancybox/jquery.fancybox.css?v=2.0.6" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo _tpl_panel_css_ ?>jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo _tpl_panel_css_ ?>jquery.ui.timepicker.css" />


<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>-->
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>jquery-ui.min.js"></script>
<!--<script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>-->
<!--<script type="text/javascript" src="../aplication/webroot/js/admin/jquery-ui/js/jquery-ui-1.8.13.custom.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>popper.min.js"></script>-->
<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>jquery.formatCurrency-1.4.0.js"></script>
<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>jquery.formatCurrency.all.js"></script> 

<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>jquery.tipsy.js"></script>
<!--<script type="text/javascript" src="../aplication/webroot/js/admin/combobox.js"></script>-->
<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>filestyle.js"></script>
<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>jquery.jeditable.mini.js"></script>
<!--
<script type="text/javascript" src="../aplication/webroot/js/jquery.ui.timepicker.js"></script>
<script type="text/javascript" src="../aplication/webroot/js/fancybox/jquery.fancybox.js?v=2.0.6"></script>
<script type="text/javascript" src="../aplication/webroot/js/fancybox/jquery.easing-1.3.pack.js"></script>
-->

<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>admin.js"></script> 
<?php if( basename($_SERVER['PHP_SELF']) == 'pedidos.php' && $_GET["action"] == "new" ){ ?>
<script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>autocompletar.js"></script> 
<?php }?> 
</head>