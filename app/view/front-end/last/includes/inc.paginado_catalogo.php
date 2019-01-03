<?php 
        $move=FALSE
?>
<!-- Shop Toolbar-->
<div class="shop-toolbar padding-bottom-1x mb-2">
  <div class="column">
    <div class="shop-sorting">
        <form name="orden_inferior" method="get">
            <label for="sorting">Ordenar por:</label>

            <select <?php echo $action;?> class="ordenar_por form-control" id="o" name="o">
            <option>Seleccione</option>
                <option value="menor-mayor" <?php if($_GET['o']=='menor-mayor'){echo 'selected="selected"';}?>>Menor Precio</option>
                <option value="mayor-menor" <?php if($_GET['o']=='mayor-menor'){echo 'selected="selected"';}?>>Mayor Precio</option>
            </select>
            <span class="text-muted float-right">Mostrando:&nbsp;
            <span>
                <?php 
                    echo ($catalogo->total_items()==0)?'0':($_GET['pag']==1?'1':$catalogo->_items_x_pagina()*($_GET['pag']-1));?> - 
                <?php if($catalogo->total_items()>($_GET['pag']*$catalogo->_items_x_pagina)){
                    echo $_GET['pag']*$catalogo->_items_x_pagina;
                }else{ 
                    echo $catalogo->total_items();
                }?> 
                de 
                <?php 
                    echo $catalogo->total_items();
                ?> items
            </span>
            <?php if($catalogo->total_items()!=0){?>
            <?php 
            if(isset($_GET['see']) && !empty($_GET['see'])){
                    $param = '_'.$_GET['see'];
            }

            $url =  $_SERVER["QUERY_STRING"]; 
            
            //echo $url;
            $action  = '';
            if(preg_match('/q=/',$url)){                            
                $q = end(explode('q=',$url));
                if( preg_match('/&o=/',$q) ){
                    $q = sacar($url, 'q=', '&o');
                }
            ?>
            <input type="hidden" name="url" id="urlq" value="<?php echo _url_web_?>">
            <input type="hidden" name="q" id="btt" value="<?php echo $q?>">
                <?php
            }else{
                $param = '';
            }
            ?>
        </form>
    </div>
  </div>
  <div class="column">
    <!-- <div class="shop-view"><a class="grid-view active" href="shop-grid-ls.html"><span></span><span></span><span></span></a><a class="list-view" href="shop-list-ls.html"><span></span><span></span><span></span></a></div> -->
  </div>
</div>


<?php }?>
