<?php
include("inc.aplication_top.php");
include(_includes_."inc.header.php");
$secciones = new Secciones();
?>
<body>
	<!-- INICIA WRAPPER -->
	<div id="wrapper">
		<div class="line"></div>
		<!-- INICIA HEADER -->
		<?php include(_includes_."inc.top.php");?>
		<!-- FIN HEADER -->
		<!-- INICIA PAGINA -->
		<div id="pagina">	
                <div class="pageTop">               	
                    <div id="navegacion">
                        
                        <a href="<?php echo _url_web_;?>"> Inicio</a>
                        <img src="aplication/webroot/imgs/nav.png"><?php if(isset($_GET['catb'])&&!empty($_GET['catb'])){
							echo '<a href="'._url_web_.'blog">Blog</a><img src="aplication/webroot/imgs/nav.png">';
							$catblog =new CategoriaBlog($_GET['catb']);
							echo $catblog->__get('_titulo');
						}else{
							echo 'Blog';
						}?>
                        
                    </div>				
                    <div id="compartir">
                    
                    <?php
                    $url = _url_web_ . 'blog';
                    if(isset($_GET['catb'])&&!empty($_GET['catb'])){
                            $catblog =new CategoriaBlog($_GET['catb']);
                            $url.= '/'.str_replace(' ','-',$catblog->__get('_titulo'));
                    }
                    if(isset($_GET['action'])&&!empty($_GET['action'])&&$_GET['action']=='detail'){
                            $nombre = end(explode('/',$_GET['nl']));
                            $url.= '/'.$nombre;
                    }
                    if(preg_match('/q=/',$_GET['nl'])){		
                            $q = end(explode('/q=',$_GET['nl']));
                            $url.= '/q='.$q;
                    }
                    ?>
                    
                    
                    <!--
                    <div class="addthis_toolbox addthis_default_style ">
                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                    <a class="addthis_button_tweet"></a>
                    <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
                    <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-524c9f6e3c4e8caa"></script>
                    -->
                    
                    <!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-524c9f6e3c4e8caa"></script>
<!-- AddThis Button END -->
                    
                    	<!--<div id="goglemas">
                        <div class="g-plusone" data-size="medium" data-href="<?php echo $url ?>"></div>
                        </div>
                        
                        <div id="fb">                            
                            <div class="fb-like" data-href="<?php echo $url ?>" data-layout="button_count"  data-width="450" data-show-faces="false" data-send="false"></div>
                            <div id="fb-root"></div>
                        </div>
                        
                        <div id="tw">
                            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url ?>" data-lang="es">Twittear</a>
                        </div>-->
                        
                    </div>                				
                </div>                    
                <?php include(_includes_ . 'inc.rightblog.php');?>
                <h2>BLOG DE DON REGALO</h2>	            
                <br/>
				<div id="cuerpo-blog">
				<?php 	
				if( $_GET['action'] == 'list' ){
					$secciones->BlogList( $_GET['catb'] );
				}else if( $_GET['action'] == 'detail' ){
					$secciones->BlogDetail(end(explode('/',$_GET['nl'])));
				}				
				?>
            	</div>
			<div class="cleaner"></div>
		</div>
		<!-- FIN PAGINA -->
		<!-- INICIA BOTTOM -->
		<?php include(_includes_."inc.bottom.php"); ?>
		<!-- FIN BOTTOM -->
	</div>
	<!-- FIN WRAPPER -->
	<!-- INICIA FOOTER -->
	<?php include(_includes_."inc.footer.php"); ?>
	<!-- FIN FOOTER -->
	<!-- Google Code para etiquetas de remarketing -->
<!--------------------------------------------------
Es posible que las etiquetas de remarketing todavía no estén asociadas a la información de identificación personal o que estén en páginas relacionadas con las categorías delicadas. Para obtener más información e instrucciones sobre cómo configurar la etiqueta, consulte http://google.com/ads/remarketingsetup.
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 980406501;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/980406501/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

</body>
</html>