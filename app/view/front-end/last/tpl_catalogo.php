    <?php
    $param = explode('n=', $_SERVER['QUERY_STRING']);
    $href = $param[1];
    ?>
    <div class="offcanvas-wrapper">
    <?php include(_tpl_includes_."inc.navegacion.php") ?>
      
      <section>
          <?php include (_tpl_includes_ . "inc.top_catalogo.php"); ?>
      </section>      
      <div class="container padding-bottom-3x mb-1">
        <div class="row">
          <!-- Products-->
          
            
            <!-- Products Grid-->
            <?php 
            $rows = 0;
            $row_categorias = 0;
            $row_productos = 0;


            if( isset($_GET['q'])){
                $catalogo->__set('_items_x_pagina',1000);
            }
            
            $catalogo->__set("_filtro",$filtro);
                    
            if ($lista_productos) {
                $content = $lista_productos;
            }else{
                $content = $catalogo->Contenido(); 
            }
            $cats  = $content[0];
            $prods = $content[1];
            $desde = $content[2];
            $hasta = $content[3];
            $pag   = $content[4];
            
            //Validation 
            $row_productos = $prods;
            $row_categorias = $cats;
            
            $x = 0;     

            //suma de productos y categorias
            $rows = sizeof($cats) + sizeof($prods);

            //saco en cuantas paginas salen de la cantidad de actegorias, segun items por pagina
            $pagscat = ceil(sizeof($cats) / $catalogo->items_en_pagina());  

            //primer registro de categoria 
            $preg_cats = ($pag - 1) * $catalogo->items_en_pagina() ;

            //si la pagina actual es menor o igual a las paginas de la categoria 
            if($pag <= $pagscat){   
                $y = 0;     
            }else{      
                $cat_rest = sizeof($cats) - $preg_cats;             
                $pagsprod = ceil(sizeof($prods) / $catalogo->items_en_pagina());    
                $preg_prods = ($pag-1)* $catalogo->items_en_pagina();
                $y = $cat_rest - ($cat_rest + $cat_rest);   
            }

            //si existe un array de items en categorias o productos 
                    
            if(count($cats)>0 || count($prods)>0){ 
                $h1 = "Don Regalo";
                if(isset($_GET['q'])){
                        $tt = '<p class="txtresult" >Resultados de la Búsqueda:</br></p><br/>'; 
                        $h1 = $_GET['q'];
                        $idstyle='id="pagSearch"';
                        $css = 'style="background:url('._tpl_imgs_.'bg_h1_cat.jpg)"';
                }else if($_GET['n']=='Regalos'){ 
                        //echo $_SERVER['QUERY_STRING'];
                        $h1 = str_replace('_',' ',end(explode('=',$_SERVER['QUERY_STRING']))); 
                        $idstyle = 'id="pagRight"'; 
                        $css = 'style="background:url('._tpl_imgs_.'bg_h1_cat.jpg)"';

                }else{
                        $categoria = new Categoria($_GET['cat']);  
                        $h1 = explode('=',$_SERVER['QUERY_STRING']);
                        $h1 = str_replace('_',' ',str_replace('-',' ',end($h1))); 
                        $idstyle = 'id="pagRight"';                 
                        $imagen = ($categoria->__get("_imagen")!="" && file_exists(_link_file_.$categoria->__get("_imagen")))?_catalogo_.$categoria->__get("_imagen"):_tpl_imgs_.'bg_h1_cat.jpg';
                        $css = 'style="background:url('.$imagen.'); background-size: cover"';
                }?>
                
            <div class="col-xl-9 col-lg-8 order-lg-2 padding-bottom-1x">

                <div <?php echo $idstyle?>>         
                <?php echo $tt;?>

                <?php
                    if (is_array($prods) && count($prods)>0){ ?>                       
                        <div class="isotope-grid cols-3 mb-2">

                          <div class="gutter-sizer"></div>
                          <div class="grid-sizer"></div>
                        <?php
                            for($c = $desde; $c < $hasta; $c++){ 
                                if(isset($prods[$y])) {               
                                    $id_item_producto= $prods[$y];
                                    include(_tpl_includes_."inc.item_producto.php");
                                    $y++;
                                    $linea++;                                           
                                } 
                                $x++;
                                $row_productos++;   
                            }  ?>
                        </div>
                        <?php             
                    } ?>
                    </div>
                    <?php
                    if (is_array($cats) && count($cats) > 0){       
                    }
            }          
            
            $pagina = $_GET['pag'] - 1;
            ?>  
            <div class="clear"></div>
            <input type="hidden" id="total_v" value="<?php echo $rows ?>" />
            <input type="hidden" id="desde_v" value="<?php echo (($pagina * 2) + 1) ?>" />
            <input type="hidden" id="total_page" value="<?php echo ($pagina * 2) ?>" />

            
            <!-- Pagination-->
            <!-- <nav class="pagination">
              <div class="column text-right">
                <ul class="pages">
                  <li class="active"><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li>...</li>
                  <li><a href="#">12</a></li>
                </ul>
              </div>
              <div class="column text-left hidden-xs-down"><a class="btn btn-outline-secondary btn-sm" href="#">SIGUIENTE&nbsp;<i class="icon-arrow-right"></i></a></div>
            </nav> -->
          </div>
            <?php include (_tpl_includes_ . "inc.left.php"); ?>
          </div>
        </div>
      </div>
    <?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>

