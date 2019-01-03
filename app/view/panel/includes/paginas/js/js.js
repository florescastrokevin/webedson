// JavaScript Document
$(document).ready(function(){
	
	 	
	$("#listadoul").sortable({
	  handle : '.handle',
	  update : function () {
		var order = $('#listadoul').sortable('serialize');
		pintar();
		$.get("ajax.php?"+order,{action:'ordenarPaginas',modulo:'paginas'},function(data){
			
		});
	  }
	});
		
	
	tinyMCE.init({
			mode:"specific_textareas",
			editor_selector : "tinymce",
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,safari,advlink,imagemanager",
			theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|fontsizeselect",
theme_advanced_buttons2 : "tablecontrols,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,code,|,forecolor,|,insertimage,image",
theme_advanced_buttons3 : "",
theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			width : "580px",
			height: '400px'
	});
	
	
	$("input[type=reset]").click(function(){
		history.back()
	})
	
	
	$('.tooltip').tipsy({gravity: 'n',fade: true});
	
		
	$( "button, input:submit, input:reset, input:button" ).button();
		
	$("input:file").filestyle({ 
         // image: "../aplication/webroot/imgs/admin/examinar.jpg",
          imageheight : 21,
          imagewidth : 92,
          width : 143
     });
	
	
	$(".dialog-form").dialog({
		autoOpen: false,
		height: 410,
		width: 450,
		resizable:false,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});	
	
	
	
	$('.welcome a').hover(function(){
		$(this).find('img').animate({top:'-5px'},{queue:false,duration:110});
	}, function(){
		$(this).find('img').animate({top:'0px'},{queue:false,duration:110});
	});
	
	setInterval(function() {
		 $(".notification").fadeOut(200);
	}, 3000);
	
});

function pintar(){
	$("#listadoul li").each(function(x) {
		$(this).removeClass("fila1").removeClass("fila2");
		var w = 0;
		if(x%2==0){w = 2;}else{w = 1;}
		$(this).addClass("fila"+w);
	});
}	

function mantenimiento(url,id,opcion){
	if(opcion!="delete"){ 
		location.replace(url+'?action='+opcion+'&id='+id);			
	}else if(opcion=="delete"){
		if(!confirm("Esta Seguro que desea Eliminar el Registro")){
			return false;	
		}else{
			location.replace(url+'?action='+opcion+'&id='+id);			
		}		
	}
}

function validnum(e) { 
	tecla = (document.all) ? e.keyCode : e.which; 
	//alert(tecla)
    if (tecla == 8 || tecla == 46 || tecla == 0) return true; //Tecla de retroceso (para poder borrar) 
    // dejar la l�nea de patron que se necesite y borrar el resto 
    //patron =/[A-Za-z]/; // Solo acepta letras 
     patron = /[\d]/; // Solo acepta n�meros
    //patron = /\w/; // Acepta n�meros y letras 
    //patron = /\D/; // No acepta n�meros 
    // patron = /[\d.-]/; numeros el punto y el signo -
    te = String.fromCharCode(tecla); 
    return patron.test(te);  
	// uso  onKeyPress="return validnum(event)"
}

function view_cliente(cliente){
	$.get('ajax.php',{action:'viewCliente', modulo:'clientes' ,  id:cliente},function(data){
		$( "#info_cliente" ).html( data );
		$( "#info_cliente" ).dialog( "open" );
	});
}

function search_cliente(){
	var r = window.prompt('Buscar Cliente - Ingresa (apellido, nombre, email)','');
	if(r != null){		
		location.href = 'index.php?modulo=clientes&q='+r;
	}
}