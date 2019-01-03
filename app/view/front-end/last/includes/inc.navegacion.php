
<?php

if (isset($_GET['modulo']) && !empty($_GET['modulo']) && $_GET["modulo"] =="pagina") { 
    Paginas::NavegacionFront($_GET['pagina']);
} else if ((isset($_GET['section']) && !empty($_GET['section']))) {
    if ($_GET['section'] == 'blog') {
        echo '<a href="#">Inicio</a>' . '<img src="<?php echo _tpl_imgs_ ?>nav.png">' . ucwords($_GET['section']);
    } else {
        echo '<a href="#">Productos</a>' . '<img src="<?php echo _tpl_imgs_ ?>nav.png">' . ucwords($_GET['section']);
    }
} else {

    $navegador = new NavegadorFront($idioma);
    $idp = isset($_GET['prod']) ? $_GET['prod'] : 0;
    $idc = isset($_GET['cat']) ? $_GET['cat'] : 0;
    $id_actual = $idp > 0 ? $idp : $idc;
    $navegador->bucleCatTrail($idc, $idp);
    echo $navegador->display($id_actual);
}
