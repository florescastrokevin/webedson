// -- CANTIDAD FOCUS ---//
$(".kcarro").focusout(function(e) {
   var cantidad = $(this).val();
   if(cantidad>0){	
   	$(this).val(cantidad)
   }else{
   	$(this).val('')
   }
});

// -- UPDATE CANTIDAD CARRITO --//	
$(".kcarro").keyup(function(e){
	var cantidad = $(this).val();
	if(cantidad>0){		
		var td = $(this).parent();
		var pu = td.prev().children().children().text().replace('$','');
		var newst = (pu * cantidad).toFixed(2);		

		td.next().children().text('$'+newst);		
		var id = td.parent().find('.eliminar').attr('id');	
			
		var sum_subtotal = 0;
		$("#tabla_cont > tr > td.td4").each(function(i,e) {
		   sum_subtotal += parseFloat($(this).children().text().replace('$',''));		 
		});

		$("#total_precio > div > #subT > span").text('$'+sum_subtotal.toFixed(2));
		var options;		
		options = id.split(parseFloat(id));
		var precio_envio = '0';
		
		if( $("#slc_envio_cesta option:selected").attr('title')!= undefined ){
			precio_envio = $("#slc_envio_cesta option:selected").attr('title');
		}
		
		var total = parseFloat(sum_subtotal);		
		var tc = parseFloat($("#cambio").val());		
		var total_cp = (parseFloat(precio_envio.replace('$','')) + total).toFixed(2);
					
		$("#numdolar").html('$'+(parseFloat(precio_envio.replace('$',''))+total).toFixed(2) );
		$("#numsol").html('S/.'+((parseFloat(precio_envio.replace('$',''))+total)*tc).toFixed(2) );
		updateCestaAjax( 'CantidadCesta' , id , cantidad , options[1] );
	}else{
		$(this).val('');
	}
	updateBagShopAjax( 'listBagShop' , null , null , null );
});


$(".eliminar").click(function(){
	var id = $(this).attr('id');
	$(this).parent().parent().remove();
	var sum_subtotal = 0;

	if( $("#tabla_cont > tr").length >= 0 ){
		
		$("#tabla_cont > tr > td.td4").each(function(i,e) {
		   sum_subtotal += parseFloat($(this).children().text().replace('$',''));		 
		});	
			
		$("#total_precio > div > #subT > span").text('$'+sum_subtotal.toFixed(2));
		
		var precio_envio = '0';
		
		if( $("#slc_envio_cesta option:selected").attr('title')!= undefined ){
			precio_envio = $("#slc_envio_cesta option:selected").attr('title');
		}
		
		var total = parseFloat(sum_subtotal);		
		var tc = parseFloat($("#cambio").val());		
		var total_cp = (parseFloat(precio_envio.replace('$','')) + total).toFixed(2);
					
		$("#numdolar").html('$'+(parseFloat(precio_envio.replace('$',''))+total).toFixed(2) );
		$("#numsol").html('S/.'+((parseFloat(precio_envio.replace('$',''))+total)*tc).toFixed(2) );
		
		updateCestaAjax( 'deleteCesta' , id , null , null );
	}
	
	if( $("#tabla_cont > tr").length == 0 ){
		$("#tabla_cont > tr > td.td4").each(function(i,e) {
		   sum_subtotal += parseFloat($(this).children().text().replace('$',''));		 
		});	
		$("#total_precio > div > #subT > span").text('$'+sum_subtotal.toFixed(2));
		$("#total_precio .tpBox:not(:eq(0))").remove();
		$("#total_precio .btn-submit").remove();
		
	}
	updateBagShopAjax( 'listBagShop' , null , null , null );
});