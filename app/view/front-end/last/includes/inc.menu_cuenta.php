<?php 
$obp_pedido = new Pedidos();
$numPedidos = count($obp_pedido->getNotificarPedidosXCliente($cuenta->getCliente()->__get('_id')));
$list_fechas_esp = Cliente::getFechasEspecialesClientes($cliente->__get('_id'));
$numFechasEspeciales = count($list_fechas_esp);
$active = 'active';
$accion = $_GET['accion'];
?>
<aside class="user-info-wrapper">
  <!-- <div class="user-cover" style="background-image: url(<?php echo _tpl_resources_ ?>img/account/user-cover-img.jpg);">
    <div class="info-label" data-toggle="tooltip" title="You currently have 290 Reward Points to spend"><i class="icon-medal"></i>290 points</div>
  </div> -->
  <div class="user-info">
    <div class="user-avatar">
      <a class="edit-avatar" href="#"></a><img src="<?php echo _tpl_resources_ ?>img/account/user-ava-sm.png" alt="User">
    </div>
    <div class="user-data">
      <h4><?php echo $cuenta->getCliente()->__get("_nombre") ?></h4><span>Joined February 06, 2017</span>
    </div>
  </div>
</aside>
<nav class="list-group">
  <a class="list-group-item with-badge <?php echo ($accion=='pedidos')? $active : ''; ?>" href="<?php echo _url_web_."seccion/cuenta/pedidos"?>">
  	<i class="icon-bag"></i>Historial de Pedido<span class="badge badge-primary badge-pill"><?php echo $numPedidos ?></span></a>
  </a>
  <a class="list-group-item with-badge <?php echo ($accion=='fechas-especiales')? $active : ''; ?>" href="<?php echo _url_web_."seccion/cuenta/fechas-especiales"?>"><i class="icon-heart"></i>Fechas Especiales<span class="badge badge-primary badge-pill"><?php echo $numFechasEspeciales ?></span></a>
  <a class="list-group-item <?php echo ($accion=='edit')? $active : ''; ?>" href="<?php echo _url_web_."seccion/cuenta/edit"?>"><i class="icon-head"></i>Mis Datos Personales</a>
  <a class="list-group-item <?php echo ($accion=='password-edit')? $active : ''; ?>" href="<?php echo _url_web_."seccion/cuenta/password-edit"?>"><i class="icon-lock"></i>Cambiar mi Contraseña</a>
</nav>

<!--     
<li><a href="<?php echo _url_web_."seccion/cuenta/edit"?>" <?php echo ($accion=='edit')? $active : ''; ?>>Mis Datos Personales</a></li>
<li><a href="<?php echo _url_web_."seccion/cuenta/fechas-especiales"?>" <?php echo ($accion=='fechas-especiales')? $active : ''; ?>>Fechas Especiales</a></li>
<li><a href="<?php echo _url_web_."seccion/cuenta/password-edit"?>" <?php echo ($accion=='password-edit')? $active : ''; ?>>Cambiar mi Password</a></li>
<li><a href="<?php echo _url_web_."seccion/cuenta/pedidos"?>" <?php echo ($accion=='pedidos')? $active : ''; ?>>Historial de Pedido</a></li>
</ul>
<a href="<?php echo _url_web_."seccion/cuenta/salir" ?>" id="salir"><span>x</span> Salir</a> 
-->