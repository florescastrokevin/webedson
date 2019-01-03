<?php 
$cobertura = new Ubigeos();
$distritos = $cobertura->getDistritosConCobertura();
$obj_formas_pago = new FormasPago();
$formas_pago = $obj_formas_pago->getFormasPago();
?>
<div id="myDeliveryNav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav('myDeliveryNav')">&times;</a>
    <ul class="distritos"> <?php 
    foreach($distritos as $key => $value){  ?>
        <li class="fila">
            <div class="nombre"> <?php echo ucwords(strtolower(substr($value['nombre'], 0, 20))) ?></div> <div class="tarifa"> <?php echo $value['tarifa']  ?></div>
        </li>  <?php 
    }  ?>
     </ul>
</div>
<div id="myPagosNav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav('myPagosNav')">&times;</a>
    <ul class="distritos"> <?php 
    foreach($formas_pago as $key => $value){  ?>
        <li class="fila2" >
            <h5><?php echo ucwords(strtolower(substr($value['nombre'], 0, 30))) ?></h5>
            <p class="descripcion_pago"> <?php echo $value['descripcion']  ?></p>
        </li>  <?php 
    }  ?>
     </ul>
</div>
<ul id="slide-right">
    <li class="titulo"><a href="javascript:void(0)" class=""  onclick="openNav('myDeliveryNav')" ><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span></a></li>
    <li class="titulo"><a href="javascript:void(0)" class=""  onclick="openNav('myPagosNav')" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span></a></li>
</ul>  

