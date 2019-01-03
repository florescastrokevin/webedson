<?php
$pag = isset($_GET['pag']) ? $_GET['pag'] : 1;  
$url = basename($_SERVER['PHP_SELF'])."?";
$url .= isset($_GET['cat']) ? "cat=".$_GET['cat']."&" : "";
$url .= isset($_GET['q']) ? "q=".$_GET['q']."&" : "";
$url .= isset($_GET['promociones']) ? "promociones&" : "";
$url .= "pag=";	
?>
<div class="paginadorRight" align="right"><?php echo paginar_URL($pag, $rows, $catalogo->_items_x_pagina, $url);?></div>
		