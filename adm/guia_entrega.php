<?php
/**
 * HTML2PDF Library - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2016 Laurent MINGUET
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

    // get the HTML
    ob_start();
    include('guia_entrega_html.php');
    $content = ob_get_clean();
    $nombre_archivo = "recibo-".$this->_id.".pdf";
    // convert in PDF
    require_once('../aplication/utilities/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'es');
        $html2pdf->writeHTML($content);
        $html2pdf->Output($nombre_archivo,'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
