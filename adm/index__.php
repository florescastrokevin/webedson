<?php include("inc.aplication_top.php");

// Recordar por 30 dias la cuenta.
if($_POST){
	if($_POST['recordar_si_MKD'] == 'si')
	{
		setcookie ("pass_MKD", "$_POST[password]", time () + 2592000);
		setcookie ("email_MKD", "$_POST[login]", time () + 2592000);
	}else{
		setcookie ("pass_MKD", "", time () + 604800);
		setcookie ("email_MKD", "", time () + 604800);
	}
} 

include(_tpl_panel_includes_."inc.header.php"); 
?>
<body>
    <?php include(_tpl_panel_includes_."inc.slide.php"); ?>
        <?php include(_tpl_panel_includes_."inc.top.php"); ?>
	<div id="dw-window"> 
    	<div id="dw-admin">
            <div id="dw-page">
                <div id="dw-cuerpo">
                	 <?php $sesion->inicio($msgbox);?>
                </div>
            </div> 
			                       
        </div>
    </div>

</body>
</html>
<?php include("inc.aplication_bottom.php"); ?>