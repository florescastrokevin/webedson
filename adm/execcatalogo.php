<?php
include("inc.aplication_top.php");
if(isset($_GET) && !empty($_GET['action'])){	
	ini_set('memory_limit', '512M');
	set_time_limit(0);
	$_SESSION['countpag']=1; //variable session cuenta las paginas del PDF
	$idparent = $_SESSION['categoria']; // obtengo el GET de id_categoria que se guarda en una session
	ob_start(); //inicio de conversor de html en variable $html
	printlist($idparent); // function recursiva imprime todo el catalogo
	$html= ob_get_clean();	 // fin de conversor de html 
	
	
	//echo $html;
	
	
	require_once(_util_."html2pdf/html2pdf.class.php"); // clase para convertir a PDF
	try{
		$html2pdf = new HTML2PDF('P', 'A4', 'fr'); // constructor 
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($html);
		$html2pdf->Output('exemple00.pdf', 'I'); // I:browser , D:descarga
		unset($_SESSION['countpag']); // despues de crear el PDF elimino la session de cuenta paginas de PDF
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}
}					
?>