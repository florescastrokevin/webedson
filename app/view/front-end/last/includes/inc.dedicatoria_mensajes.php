<?php
include("../../../../../inc.aplication_top.php");
?>
<div id="cuadro_tarjeta">
<div id="pagina">
	<div class="pageTop">
	<h2>Sugerencias de Mensaje </h2><div class="txtopciones"> | Elige algunas de las opciones</div> <div id="btn_close"></div>
    <select id="mensajes_plantillas">
    	<option value="">Libreta de mensajes</option>
		<?php
        $tiposMsj = TiposMensaje::getTiposMensaje();
		if( count($tiposMsj) > 0 ){
			foreach( $tiposMsj as $tm ){
			?>
          	<option value="<?php echo $tm['id']?>"><?php echo $tm['nombre']?></option>  
            <?php
			}
		}
		?>
    </select>
    <div id="loading"></div>
    <br class="clear"/>
    <div id="mensajes">
    	<br/>Eliga una de las opciones
    </div>
    </div>
</div>
</div>