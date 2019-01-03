<?php if($sesion->getUsuario()->getLogeado() === TRUE){       
    $secciones = $sesion->getUsuario()->getSeccionesId();
    $modulos   = explode(",",$sesion->getUsuario()->getModulos());
    sort($modulos);
}else{ $secciones = array($modulos); } ?>
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <a href="javascript:;" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <img src="<?php echo _admin_assets_?>img/user/user-13.jpg" alt="" />
                    </div>
                    <div class="info">
                        <b class="caret pull-right"></b>
                        Edson O.L.
                        <small>Administrador de Contenido</small>
                    </div>
                </a>
            </li>
            <li>
                <ul class="nav nav-profile">
                    <li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="javascript:;"><i class="fa fa-pencil-alt"></i> Send Feedback</a></li>
                    <li><a href="javascript:;"><i class="fa fa-question-circle"></i> Helps</a></li>
                </ul>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav ul-menu-admin">
            <li class="nav-header">Lista de Secciones</li>
            <?php 
            if(is_array($modulos)){         
                $seccions = new Secciones();
                reset($modulos);
                $index = 1;
                foreach ($modulos as $key => $value) {
                    $modulo = new Modulo($value);  ?>
                    <li class="has-sub">
                        <a href="javascript:;"> 
                            <b class="caret"></b>
                            <i class="fas fa-home"></i>
                            <span><?php echo $modulo->getNombre(); ?></span>    
                        </a>
                            <?php
                            $sections = $seccions->getSeccionesPorModulo($modulo->getId());
                            $total = count($sections);
                            if ($total > 0){ ?>
                            <ul class="sub-menu"> <?php
                                for ($s = 0; $s < $total; $s++) {
                                    if (in_array($sections[$s]['id'], $secciones)) {
                                        $self = explode("/", $_SERVER['PHP_SELF']);
                                        $self = end($self);
                                        $self = $_GET['section'];
                                        if (preg_match("/reporte.php/", $sections[$s]['url'])) { ?>
                                            <li><a href="<?php echo $sections[$s]['url'] ?>">  <?php echo $sections[$s]['nombre'] ?> </a></li><?php
                                        } else {
                                            if (preg_match("/" . $self . "/", $sections[$s]['url'])) { ?>
                                                <li  class="active">
                                                    <a href="<?php echo $sections[$s]['url'] ?>"><?php echo $sections[$s]['nombre'] ?></a>
                                                </li> 
                                            <?php } else { ?>
                                                <li>
                                                    <a href="<?php echo $sections[$s]['url'] ?>">  <?php echo $sections[$s]['nombre'] ?> </a>
                                                </li><?php
                                            }
                                        }
                                    }
                                }  ?>
                            </ul><?php
                            }?>
                    </li> <?php
                } 
            } ?>
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>