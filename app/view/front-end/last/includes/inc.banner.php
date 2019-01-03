<?php 
$obj_banners = new Banners();
$banners = $obj_banners->getBanners();
?>
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators"><?php
        if(is_array($banners) && count($banners) > 0){
            $class_active = "";
            foreach($banners as $key => $value){
                if($key == 0){ $class_active = "active"; }else{$class_active = "";}?> 
        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key ?>" class="<?php $class_active; ?>"></li><?php
                }
        } ?>
    </ol>
    <div class="carousel-inner"> <?php
        if(is_array($banners) && count($banners) > 0){
                foreach($banners as $key => $value){
                    if($key == 0){ $class_active = "active"; }else{$class_active = "";}?>
        <div class="carousel-item <?php echo $class_active; ?>"><a href="<?php echo $value['enlace'] ?>"><img class="d-block w-100" src="<?php echo _catalogo_.$value['imagen'] ?>" /></a></div>
                <?php
                }
        } ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


