<?php
include("inc.aplication_top.php");
?>        
<script>
	
	function nl2br (str, is_xhtml) {
		var cadena = "";		
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
		cadena =  (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2').replace(/  /g,'&nbsp;&nbsp;');
		return cadena;
	}

	$(document).ready(function(e) {
		var txt = parent.$("#dedicatoria").val();
		
		console.log(nl2br(txt));
		
		$("#cuerpo-preview p").html(nl2br(txt));
	});
</script>
<div id="cuerpo-preview">
	<div id="btn_close"></div>
	<p><?php echo $_SESSION['envio']['dedicatoria'];?></p>
</div>
<script type="text/javascript">
       	$(document).ready(function(e){
			/* BTN CLOSE POPUP LOGIN */	
			$("#btn_close").on("click",function(){
				$.fancybox.close();
			});
		});
</script>