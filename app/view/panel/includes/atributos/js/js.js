$(document).ready(function(e) {
    
	var Sregion = 'es-US';	
	
	switch($("#moneda").val()){
		case '$':
			Sregion = 'es-US'	
		break;
		case 'S/.':
			Sregion = 'es-PE'	
		break;
	}
	
	$(".JQprecio").formatCurrency({region: Sregion,roundToDecimalPlace: -1, eventOnDecimalsEntered: true})
			.focus(function(){
				$(this).formatCurrency({region: Sregion,roundToDecimalPlace: -1, eventOnDecimalsEntered: true})
			})
			.keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 16: break; // Shift
						case 17: break; // Ctrl
						case 18: break; // Alt
						case 27: this.value = ''; break; // Esc: clear entry
						case 35: break; // End
						case 36: break; // Home
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({roundToDecimalPlace: -1, eventOnDecimalsEntered: true, region: Sregion});
					}
				}
			}).bind('decimalsEntered', function(e, cents) {
				if (String(cents).length > 2) {
					$(this).formatCurrency();
				}				
			}).blur(function(e){
				e.stopImmediatePropagation()
				$(this).formatCurrency({region: Sregion ,roundToDecimalPlace:2 });
			}).keydown(function(){				
				if ( event.keyCode == 46 || event.keyCode == 190  || event.keyCode == 110|| event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				// Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				// Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
				 // let it happen, don't do anything
				 return;
				}
				else {
				// Ensure that it is a number and stop the keypress
					if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault(); 
					}   
				}
			});	
			
			$( "button, input:submit, input:reset, input:button" ).button();
			
			$("input:file").filestyle({ 
			  image: "../aplication/webroot/imgs/admin/examinar.jpg",
			  imageheight : 27,
			  imagewidth : 92,
			  width : 143
		  });
});

function valida_atributos(){
	if ($("#atributos option:selected").val() ==0){
		alert("Seleccione un atributo")
		$("#atributos").focus();
		return false;
	}if ($("#valor_atributo option:selected").val() ==0){
		alert("Seleccione un valor")
		$("#valor_atributo").focus();
		return false;
	}
	
	switch  ( $("#prefijo option:selected").val() ){
		case  '0' : 
			alert("Seleccione un prefijo")
			$("#prefijo").focus();
			return false;
		break;
	}
			
	$.post('ajax_atributos.php','action=addAtributo&'+$("#asignacion_atributos").serialize(),function(data){	
		 $("#listadoul.listAttr").html(data);
		 
		$('#asignacion_atributos').each (function(){
		  this.reset();
		  $("input[name=precio_valor_atributo]").removeAttr("style").removeAttr("disabled");
		  $(".JQprecio").formatCurrency({region: 'es-PE',roundToDecimalPlace: -1, eventOnDecimalsEntered: true})
		});
		
		
	});
	pintar()
}

function cargarValores(){	
	id = $("#atributos option:selected").val();
	$("#valor_atributo option").remove();
	if ( id == 0){
		$("#valor_atributo").append('<option value="0">Seleccione Valor...</option>');
	}else{
		$.post('ajax_atributos.php',{action:'cargaValores', id_atributo:id},function(data){	
			if ( data!=null ){
				$("#valor_atributo").append('<option value="0">Seleccione Valor...</option>').focus();
				$.each(data, function(key, value) {
				  $("#valor_atributo").append('<option value="'+value.id+'">'+value.nombre+'</option>');
				});
			}else{
				$("#valor_atributo").append('<option value="0">No items</option>');
			}
		},'json');
	}
}

function deleteAtributo( idpav , idpa ){
	$.post('ajax_atributos.php',{action:'deleteAtributo', idpav:idpav , idpa:idpa},function(data){			
		$( ".listAttr li[id="+idpav+"]" ).fadeOut(300,function(){ pintar() });				
	});	
}

function popupAtributo( id ){
	
	producto = $(".listAttr li[id="+id+"]").find(".data.att0").text();
	atributo = $(".listAttr li[id="+id+"]").find(".data.att1").text();
	valor = $(".listAttr li[id="+id+"]").find(".data.att2").text();
	prefijo = $(".listAttr li[id="+id+"]").find(".data.att3").text();
	precio = $(".listAttr li[id="+id+"]").find(".data.att4").text();
	stock = $(".listAttr li[id="+id+"]").find(".data.att5").text();
	
	$("#pop_up_prefijo").val(prefijo);
	$("#pop_up_stock").val(stock);
	$("#pop_up_precio").val(precio);
	$("#nav_pop_up").text( producto +" > "+ atributo)
	$("#id_atributo").val(id);
	$("#producto").val(producto);
	$("#valor").val(valor);
	$("#atributo").val(atributo);
	$(".dialog-form").dialog( "open" );
}

function mantenimiento(url,id,opcion){
	
	if(opcion!="delete" && opcion != 'deleteValores' ){
		 
		location.replace(url+'?action='+opcion+'&id='+id);			
	
	}else if(opcion=="delete" || opcion=='deleteValores'){ 
		if(!confirm("Esta Seguro que desea Eliminar el Registro")){
			return false;	
		}else{
			location.replace(url+'?action='+opcion+'&id='+id);			
		}		
	}
}


function mantenimiento_det(url, id1){	
	location.replace(url+'&id1='+id1);			
}

function valida_valores_atributos(opcion, id){
	
	if(document.valores_atributos.nombre_valor_atributo.value==""){
		alert(" ERROR: Por favor el valor del atributo");
		document.valores_atributos.nombre_valor_atributo.focus();
		return false;
	}else{	
		document.valores_atributos.action='atributos.php?action='+opcion+'&id1='+id;
		document.valores_atributos.submit();
	}
}