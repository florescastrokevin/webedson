<?php

function zoom_imagen($img, $w, $h,$nombre){

	   $tratar ="<img src='app/publicroot/imgs/catalogo/".$img."' width='".$w."' height='".$h."'\" id='imgp'  style=\"margin:8px 3px 3px 3px\"  onClick=\"showPic('this')\" />";
		return $tratar;
	}
function zoom_imagen_($img, $w, $h,$d){
		$tratar = "<a href=\"#\">";
	   $tratar .="<img src=\""._img_file_."?imagen=".$img."&w=".$w."&h=".$h."\"  style=\"margin:8px 3px 3px 3px\" id='imgp'  onClick=\"showPic('this')\" title=\"app/publicroot/imgs/catalogo/".$img."\"  /></a>";
		return $tratar;
	}
	function zoom($img, $w, $h,$m){
		$tratar = "<a href=\"#\" title=\"app/publicroot/imgs/catalogo/".$img."\" >";
	   $tratar .="<img src=\""._img_file_."?imagen=".$img."&w=".$w."&h=".$h."\"  style=\"border:1px solid #000000;".$m."\" 
	   				/></a>";
		return $tratar;
	}
function resize_imagen($img, $w, $h, $url){
		$tratar = "<a href=\"".$url."\"   >";
	   $tratar .="<img src=\""._img_file_."?imagen=".$img."&w=".$w."&h=".$h."\" /></a>";
		return $tratar;
	}
	

?>