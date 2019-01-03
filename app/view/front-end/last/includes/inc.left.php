<?php $obj_cate_padre = $menu_navegacion_left[0];
$lista_sub_cate = $menu_navegacion_left[1];
$filtros = $menu_navegacion_left[2];
 ?>
<div class="col-xl-3 col-lg-4 order-lg-1">
    <!-- <button class="sidebar-toggle position-left" data-toggle="modal" data-target="#modalShopFilters"><i class="icon-layout"></i></button> -->

	<div id="pagLeft">

		<div id="boxCat">
            <?php if ($obj_cate_padre): ?>    
           	<h2><?php echo strtoupper($obj_cate_padre->__get('_nombre')) ?></h2>
            <?php if ($lista_sub_cate){ ?>
            <ul>
                <?php foreach ($lista_sub_cate as $subcate): ?>

                    <?php $obj_subcate = new Categoria($subcate) ?>
                <li>
                    <a href=""><?php echo $obj_subcate->__get('_nombre') ?></a>
                </li>
                <?php endforeach ?>
            </ul>
            <?php }else{ /*EN EL CASO DE QUE NO HAYAN SUB PINTO UN BR*/?>
            <br>
            <?php } ?>
            <?php endif ?>
            <?php if ($filtros): ?>
            <h2>FILTROS</h2>
            <ul>
                <?php foreach ($filtros as $filtro): ?>
                <?php $obj_filtro = new Filtro($filtro) ?>
                <li>
                    <a href=""><?php echo $obj_filtro->__get('_nombre') ?></a>
                </li>
                <?php endforeach ?>
            </ul>
            <?php endif ?>
        </div>
    </div>
</div>