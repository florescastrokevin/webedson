// JavaScript Document
$(document).ready(function(){
	
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

	
	$("#change_price").change(function(){		
		if ( $("#change_price option:selected").val() != "" ){
			$("#precio_normal").val($("#change_price option:selected").attr("dir")).focus();
			$("#precio_oferta").removeAttr("readonly").focus();
		}else{
			$("#precio_oferta").val('').attr("readonly","readonly");
			$("#precio_normal").val('');
		}
	})
	
	$(".compare").keyup(function(e){
		e.stopImmediatePropagation();		
		
		var e = window.event || e;
		var keyUnicode = e.charCode || e.keyCode;
		if (e !== undefined) {			
			switch (keyUnicode) {
				case 8:  break; //  cursor backspin
				case 46: break; // cursor del
				case 37: break; // cursor left
				case 38: break; // cursor right
				case 39: break; // cursor right
				case 40: break; // cursor down
				default: $(this).focus();
			}
		}		
		
		symbol = $("#moneda").val();	
		precio_oferta = clearNumber($("#precio_oferta").val(),symbol); // limpia todo , solo numeros	
		precio_normal = clearNumber($("#precio_normal").val(),symbol);
				
		if(precio_oferta!=""){
			if( parseFloat(cleanComas(precio_oferta)) >= parseFloat(cleanComas(precio_normal)) ){
				alert("El precio de la oferta tiene que ser menor al precio del producto: "+$("#precio_normal").val() );
				$("#precio_oferta").val('');
			}	
		}		
		
	})
	
	$( "button, input:submit, input:reset, input:button" ).button();
	
});

function cleanComas( num ){		
	if (num!="")
	return num.replace(/,/g, '');
}

function clearNumber(num,symbol){	
	if ( num.indexOf(symbol)!=-1 ){
		var aux = num.split(symbol);
		return aux[1];
	}else
		return "";
		
}

function pasa_precio(Obj, receptor, oferta, moneda){
	if(Obj.value!=""){
		var indice= Obj.selectedIndex;
		var texto=Obj.options[indice].text;
		var precio=texto.split(moneda);
		receptor.value=precio[1];
		receptor.focus();
		oferta.readOnly="";
		oferta.focus();
	}else{
		receptor.value="";
		oferta.value="";
		oferta.readOnly="true";
	}
}
	
function compara_monto(precio_normal, precio_oferta , moneda){	
	solo_precio = precio.value.replace(/\D/g,''); // limpia todo , solo numeros		
	if(solo_precio!=""){
		if(parseFloat(oferta.value)>=parseFloat(solo_precio)){
			alert("El precio de la oferta tiene que ser menor al precio del producto: "+precio.value );
			oferta.value = "";		
		}	
	}		
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

function validar_ofertas(opcion, id){
	if(document.ofertas.precio_oferta.value==""){
		alert(" ERROR: Por favor ingrese el precio");
		document.ofertas.precio_oferta.focus();
		return false;
	}else{
		document.ofertas.action='ofertas.php?action='+opcion+'&id='+id;
		document.ofertas.submit();
	}
}