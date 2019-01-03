<?php

class Fecha{
	
	var $date; 	
	
	function Fecha($date){
		
	}
	
	static public function formatoDate($comodin,$fecha){
		$nfecha=explode($comodin,$fecha);
		$dia=$nfecha[0];
		$mes=$nfecha[1];
		$axo=$nfecha[2];
		$ufecha=$axo."-".$mes."-".$dia;
		return $ufecha;
	}

	function formatoSlash($comodin,$fecha){
		$nfecha=explode($comodin,$fecha);
		$dia=$nfecha[2];
		$mes=$nfecha[1];
		$axo=$nfecha[0];
		$ufecha=$dia."/".$mes."/".$axo;
		return $ufecha;
	}
}

 ?>