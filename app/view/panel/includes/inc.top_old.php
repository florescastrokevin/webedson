<?php
if($sesion->getUsuario()->getLogeado() === TRUE){		
	$secciones = $sesion->getUsuario()->getSeccionesId();
	$modulos   = explode(",",$sesion->getUsuario()->getModulos());
	sort($modulos);
}else{
	$secciones = array($modulos);
}
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="index.php"><img src="<?php echo _tpl_panel_imgs_."icon.png" ?>" ></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav"> <?php 
	if(is_array($modulos)){ 		
            $seccions = new Secciones();
            reset($modulos);
            $index = 1;
            foreach ($modulos as $key => $value) {
                $modulo = new Modulo($value);  ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $modulo->getNombre(); ?> <span class="caret"></span></a><?php
                $sections = $seccions->getSeccionesPorModulo($modulo->getId());
                $total = count($sections);
                if ($total > 0){ ?>
                <ul class="dropdown-menu"> <?php
                    for ($s = 0; $s < $total; $s++) {
                        if (in_array($sections[$s]['id'], $secciones)) {
                            $self = explode("/", $_SERVER['PHP_SELF']);
                            $self = end($self);
                            if (preg_match("/reporte.php/", $sections[$s]['url'])) { ?>
                                <li><a href="<?php echo $sections[$s]['url'] ?>">  <?php echo $sections[$s]['nombre'] ?> </a></li><?php
                            } else {
                                if (preg_match("/" . $self . "/", $sections[$s]['url'])) { ?>
                                    <li  class="active"><a href="<?php echo $sections[$s]['url'] ?>"><?php echo $sections[$s]['nombre'] ?></a></li> <?php } else { ?>
                                    <li><a href="<?php echo $sections[$s]['url'] ?>">  <?php echo $sections[$s]['nombre'] ?> </a></li><?php
                                }
                            }
                        }
                    }  ?>
                </ul><?php
                }?>
                </li> <?php
            } 
	} ?> 
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo $_SERVER['PHP_SELF']."?action=logout" ?>" class="salir">Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

 <ul class="dropdown">
 
    	 
        <li class="last"></li>
    </ul>
<!--<div class="actions">
    <a href="index.php" class="user">Administrador - <?php echo $sesion->getUsuario()->getNombre() ?></a>
    <a href="<?php echo $_SERVER['PHP_SELF']."?action=logout" ?>" class="salir">Salir</a>
</div>
<div class="develoweb">
	<a href="http://www.develoweb.net" target="_blank"><img src="../aplication/webroot/imgs/admin/develoweb.png" /></a>
</div>-->