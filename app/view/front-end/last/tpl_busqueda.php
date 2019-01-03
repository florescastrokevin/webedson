    <?php
    $param = explode('n=', $_SERVER['QUERY_STRING']);
    $href = $param[1];
    ?>
    <div class="offcanvas-wrapper">
    <?php include(_tpl_includes_."inc.navegacion.php") ?>
      
      <div class="container padding-bottom-3x mb-1">
        <div class="row">
          <div class="col-lg-12 padding-bottom-3x">
              <h4>Resultado de Búsqueda: "<?php echo $_GET['url'] ?>"</h4>
              <br>
              <hr>
          </div>  
          <!-- Products-->
          
            
            <!-- Products Grid-->
            <?php 
            $rows = 0;
            $row_categorias = 0;
            $row_productos = 0;


            if( isset($_GET['q'])){
                $catalogo->__set('_items_x_pagina',1000);
            }
            $content = array();
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
                    $h1 = $_GET['q'];
                }else if($_GET['n']=='Regalos'){ 
                    //echo $_SERVER['QUERY_STRING'];
                    $h1 = str_replace('_',' ',end(explode('=',$_SERVER['QUERY_STRING'])));
                }else{
                    $h1 = explode('=',$_SERVER['QUERY_STRING']);
                    $h1 = str_replace('_',' ',str_replace('-',' ',end($h1)));             
                }?>
                
            <div class="col-xl-12 col-lg-12 order-lg-2 padding-bottom-1x">
                <div>         

                <?php
                    if (is_array($prods) && count($prods)>0){ ?>                       
                        <div class="isotope-grid cols-4 mb-2">

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
                    }else{
                        ?><h3>No se encontraron resultados para la búsqueda</h3><?php
                    } ?>
                </div>
                <?php
            }          
            
            $pagina = $_GET['pag'] - 1;
            ?>  
                <div class="clear"></div>

            </div>
        </div>
      </div>
    <?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>