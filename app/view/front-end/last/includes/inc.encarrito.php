<?php
include("../../../../../inc.aplication_top.php");
$complementos = array();
if ($_POST['opciones']) {
    foreach ($_POST['opciones'] as $key => $value) {
        if ($complementos[$value]) {
            $complementos[$value]+=1;
        }else{
            $complementos[$value]=1;
        }
    }
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            $cuenta->getCliente()->getCarrito()->AddProducto($_POST['id'], $complementos, 0, $_POST['cantidad']);
            HistorialCesta::add();
            break;
    }
}
$obj_producto = new Producto($_POST['id']);
$imagenes = $obj_producto->__get("_imagenes");
$preciocmp = 0;

//echo var_dump($_POST);
//$complementos = $_POST['opciones'];
/*echo var_dump($newArray);
die();*/
?>

    <div class="row margin-bottom-1x">
        <div class="col-sm-4 text-center">
            <img class="text-center imagen-inc-encarrito" src="<?php echo _catalogo_ . 'basecatalogo.png'; ?>" alt="agregada a carrito" style="background-image: url('<?php echo _catalogo_ . $imagenes[0]['middle'] ?>');"/>
        </div>
        <div class="col-sm-8">
            <h4><?php echo $obj_producto->__get("_nombre") ?></h4>
            <p>Cantidad: <?php echo $_POST['cantidad']; ?></p>
            <?php if (isset($complementos) && count($complementos) > 0){ ?>
                <ul style="list-style: none">
                <?php foreach ($complementos as $id => $cantidad):
                    if ($cantidad>0) {
                        $prod_cmp = new Producto($id);
                        $imgs_cmp = $prod_cmp->__get("_imagenes");
                        $preciocmp += $prod_cmp->__get("_precio_producto") * $cantidad; ?>
                        <li>
                            <span>
                                <i class="icon-check text-success"></i>
                                <img src="<?php echo _catalogo_ . $imgs_cmp[0]['thumbnail'] ?>" alt="" />
                            &nbsp;&nbsp;<?php echo $cantidad; ?>&nbsp;<?php echo $prod_cmp->__get("_nombre") ?>
                            </span>
                        </li>
                    <?php }
                endforeach; ?>
                </ul>
            <?php } ?>
            <?php $precio_total = ($preciocmp + $obj_producto->__get("_precio_producto")) * $_POST['cantidad']; ?>
            <h4 class="text-muted">Precio: $<?php echo number_format($precio_total, 2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="precio-soles-inc-encarrito">S/. <?php echo number_format($precio_total*TIPO_CAMBIO, 2) ?></span></h4>
            <div class="row">
                <div class="col-12">
                    <a class="btn btn-sm btn-secondary float-right ver-carrito-inc-encarrito" href="<?php echo _url_web_ ?>seccion/cesta" id="verCarrito">Revisar Carrito <i class="fas fa-shopping-cart"></i></a>
                </div>
                <div class="col-12">
                    <!-- <a class="realizarcompraquick btn btn-sm btn-danger text-center float-right realizar-compra-inc-encarrito" href="<?php echo _url_web_ ?>seccion/pedido">Realiza tu Compra <i class="fas fa-long-arrow-alt-right"></i></a> -->
                    <a class="realizarcompraquick btn btn-sm btn-danger text-center float-right realizar-compra-inc-encarrito" onclick="realizarCompra()">Realiza tu Compra <i class="fas fa-long-arrow-alt-right"></i></a>
                </div>
            </div>
        </div>

    </div>

    <hr>
    <div id="mas_regalos_popup">
        <?php 
        $items_mas_regalos = 3;
        include(_tpl_includes_."inc.mas_regalos.php") 
        ?>
    </div>