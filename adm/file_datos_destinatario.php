<?php 
include("inc.aplication_top.php");
if (isset($_GET['action'])){	
	
	new Consulta("UPDATE pedidos_destinatarios SET  
            nombre_destinatario = '".$_POST['nombre']."',
            telefono_destinatario = '".$_POST['telefono']."' , 
            fecha_destinatario = '".$_POST['fecha']."' , 
            hora_destinatario = '".$_POST['hora']."' , 
            direccion_destinatario = '".$_POST['direccion']."' , 
            referencia_destinatario = '".$_POST['referencia']."',
            id_distrito = '".$_POST['distrito']."',
            dedicatoria_destinatario = '".$_POST['dedicatoria']."'
            WHERE id_pedido = '".$_POST['id']."'");
	
	
}

?>