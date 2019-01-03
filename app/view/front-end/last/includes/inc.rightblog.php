<div id="pagRihtBlog">
<div id="boxFilt">
    <h2>Buscar en el Blog:</h2>
    <ul>
    	<li>
        <div id="buscador">
			<input type="text" name="q" class="texto" id="buscarblog" value="" placeholder="Buscar...">
            <input type="submit" class="bton" id="btnBuscarblog" onclick="javascript:;" value="&nbsp;">
		</div></li>
        
    </ul>
</div>    
    <div id="boxFilt" class="blog">
    <h2>Categorias</h2>
    <?php
		
	$catblog2 =new CategoriaBlog($_GET['catb']);
	$nombrecat = $catblog2->__get('_titulo'); 
	
    $catblog = new CategoriasBlog();
    $catsblogs = $catblog->getCategoriasBlog('',0);
    if(count($catsblogs)>0){
    ?>
    <ul>
        <?php foreach($catsblogs as $catsblog):?>
        <li><a <?php if($catsblog['titulo']==$nombrecat) echo 'class="activepag"';?> <?php echo ($nombre==str_replace("-"," ",$catsblog['titulo']))?'class="activepag"':'' ?> href="blog/<?php echo str_replace(" ","-",$catsblog['titulo'])?>"><?php echo $catsblog['titulo']?></a></li>
        <?php endforeach;?>
    </ul>
    <?php
    }
    ?>
</div>

	<div id="boxFilt">
    	<h2>Tags</h2>
        <?php
        $arr = BusquedasBlog::getTopBusquedaBlog(20);
		if(is_array($arr)&&count($arr) > 0 ){
			foreach ($arr as $value) {
				$arr2[] = $value['cantidad_busqueda_blog_top'];
			}
			$min = min(array_values($arr2));
			$max = max(array_values($arr2));
			$spread = $max - $min;
			if ($spread == 0) {
				$spread = 1;
			}
			for ($i = 0; $i < count($arr); $i++){
				$size = 0.8 + ($arr[$i]['cantidad_busqueda_blog_top'] - $min) * (1.3 - 1) / $spread;
				echo '<a id="q' . url_frienly($arr[$i]['id'], 1) . '" style="font-size:' . $size . 'em" href="'._url_web_.'blog/q=' . str_replace(' ','+',$arr[$i]['texto_busqueda_blog_top']) . '"><span>' . utf8_decode(str_replace('-',' ',$arr[$i]['texto_busqueda_blog_top'])) . '</span></a>  ';
			}
		}
		?>
        <a href="#"></a>
    </div>
</div>    

      