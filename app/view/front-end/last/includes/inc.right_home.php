<div id="catVistas">
    <h3>Regalos por ocasión:</h3>
    <ul>
        <?php
        $oca = new Ocasiones();
		$ocasiones = $oca->getOcasiones();
		if( count($ocasiones) > 0 ){
			foreach( $ocasiones as $ocasion ){
				?>
                 <li>
                    <a href="<?php echo _url_web_ . 'Regalos_de_'.$ocasion['nombre']?>">
                        <span class="colorA1"><?php echo $ocasion['nombre'];?></span><!--<span class="colorA2"></span>-->
                    </a>
                </li>
                <?php
			}
		}		
		?>
    </ul>
</div>
<div id="dCatalogo">
    <h3>DESCARGA TU CATÁLOGO:</h3>
    <form id="form-download-catalogo" onsubmit="return validate_descarga(this)" method="post" >
        <ul>
            <li>
                <input type="text" name="name_catalogo" id="name_catalogo" value="" placeholder=" Tu Nombre aquí...">
            </li>
            <li>
                <input type="text" name="mail_catalogo" id="mail_catalogo" value="" placeholder=" Tu Mail aquí...">
            </li>
        </ul>
        <input type="submit" id="btnDescarga" value="">
    </form>
</div>