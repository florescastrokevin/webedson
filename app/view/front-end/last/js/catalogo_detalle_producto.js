console.log('catalogo_detalle_producto');

$(".btn_anadir").on('click',function(){
	var src = $(this).parent().find('.a_imagen img').attr('src');
	var name_complemento = $(this).parent().find('.nameProd').text();
	var precio = $(this).parent().find('input[name=precio]').val();
	var opcion = $(this).parent().parent().parent().parent().parent().parent().find('input[name=opcion]').val();
	var valor = $(this).parent().find('input[name=id_valor]').val();

	var complemento = '<li id="'+valor+'"><div class="wrap_agregado"><button type="button" class="close eliminar_prod" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> &nbsp;<img src="'+src+'" alt="adicional" />&nbsp;&nbsp;&nbsp;';
	complemento+= '<span>'+name_complemento+' $<b>'+precio+'</b> </span>';
	complemento+= '';		
	complemento+= '</div></li>';
	
	//$("#prod_agregado ul").append(complemento);
	addComplemento(complemento);
	
	var topt = $('form[name=envio_carrito] .opciones_'+valor+'');
	var cantidad_valor = 1;
	
	if( topt.val() != undefined  ){
		cantidad_valor = parseInt(topt.val()) + 1;
		topt.val(cantidad_valor); 
	}else{
		$("form[name=envio_carrito]").append('<input type="hidden" class="opciones_'+valor+'" name="opciones['+valor+']" value="'+cantidad_valor+'">');
	}
	
	
	var precio_temp = 0;
	
	
	$("#prod_agregado ul li").each(function(i, e) {		
		precio_temp += parseFloat($(this).find('span b').text());	
    });
	
	var precio = $("#detalle_descripcion input[name=precio_producto]").val();
	
	var precio_total = (parseFloat(precio) + parseFloat(precio_temp)) * $("#cant").val();
	
	$("#precio_btn span#precio_temp").text('Precio: $'+precio_total.toFixed(2));
	
	
	if( $("#prod_agregado ul li").length >0){
		$("form[name=envio_carrito] #cant")
	}else{
		
	}
		
	
});

function addComplemento(complemento) {
	$("#prod_agregado ul").append(complemento); 
    $('.eliminar_prod').on('click', function() {
        $(this).parent().parent().remove();
		var valor = $(this).parent().attr('id');
		var topt = $('form[name=envio_carrito] .opciones_'+valor+'');		
		var cantidad_valor = 1;
		if( topt.val() > 1  ){
			cantidad_valor = parseInt($opt.val()) - 1;
			topt.val(cantidad_valor); 
		}else{
			topt.remove();
		}		
		var precio_temp = 0;
		$("#prod_agregado ul li").each(function(i, e) {	
			precio_temp += parseFloat($(this).find('span b').text());				
        });		
		var precio = $("#detalle_descripcion input[name=precio_producto]").val();		
		var precio_total = (parseFloat(precio) + parseFloat(precio_temp)) * $("#cant").val();		
		$("#precio_btn span#precio_temp").text('Precio: $'+precio_total.toFixed(2));	
    }); 
}

function addShopBagAdicionales(item) {
	var data = $(item).attr("data").split(",");
	var action = data[0];
	var id = data[1];
	//var cantidad = data[2];
	/* aqui la cantidad puede variar*/
	var cantidad = $('#cant').val();
	var adicionales = [];
	$('#prod_agregado ul li').each(function (e) {
		adicionales.push($(this).attr('id'));
	})

	// var opciones = [];
	// for(var i=0;i<adicionales.length;i++){
	//  	var identificador = adicionales[i];
	//  	if (opciones[identificador]) {
	//  		//alert('existe');
	//  		var valor_actual = opciones[identificador];
	//  		var valor_nuevo = valor_actual + 1;
	//  		opciones[identificador] = valor_nuevo;
	//  	}else{
	//  		//alert('no existe');
	//  		opciones[identificador] = 1;
	//  	}
	// }
	// myArrClean = opciones.filter(Boolean);
	// console.log(myArrClean);

	if( $('.modal-detalle-carrito:visible').length ){ 
		$('#loader-detalle-carrito').addClass('display');
		$.ajax({
	        type  : "POST",
	        url   : _tpl_+"includes/inc.encarrito.php",
	        data  : {action:action,id:id,cantidad:cantidad,opciones:adicionales},
	      	success: function(data) {
	      		// updateCestaAjax( 'listCesta' , null , null , null );
	      		// updateBagShopAjax( 'listBagShop' , null , null , null );
	      		//Verificamos si un modal esta abierto => 0:el modal no esta visible ; 1: el modal esta visible
	      		updateCestaAjax( 'listCesta' , null , null , null );
	      		updateBagShopAjax( 'listBagShop' , null , null , null );
	            $('.modal-detalle-carrito .modal-container').html(data);
	            $('.owl-carousel-mas-regalos').owlCarousel({
	            	nav: false,
	            	dots: true,
	            	margin: 30,
	            	responsive: {
	            		0: {
	            			items: 1
	            		},
	            		576: {
	            			items: 2
	            		},
	            		768: {
	            			items: 3
	            		},
	            		991: {
	            			items: 4
	            		},
	            		1200: {
	            			items: 4
	            		}
	            	}
	            });
	        },
	        beforeSend: function(objeto){
	        },
	        complete: function(){
	        	setTimeout(function() {$('#loader-detalle-carrito').removeClass('display');}, 500);
	        }
	    });
	}else{
	    $.ajax({
	        type  : "POST",
	        url   : _tpl_+"includes/inc.encarrito.php",
	        data  : {action:action,id:id,cantidad:cantidad,opciones:adicionales},
	      	success: function(data) {
	      		updateCestaAjax( 'listCesta' , null , null , null );
	      		updateBagShopAjax( 'listBagShop' , null , null , null );
	      		$('.modal-detalle-carrito').modal('show');
	            $('.modal-detalle-carrito .modal-container').html(data);
	            $('.owl-carousel-mas-regalos').owlCarousel({
	            	nav: false,
	            	dots: true,
	            	margin: 30,
	            	responsive: {
	            		0: {
	            			items: 1
	            		},
	            		576: {
	            			items: 2
	            		},
	            		768: {
	            			items: 3
	            		},
	            		991: {
	            			items: 4
	            		},
	            		1200: {
	            			items: 4
	            		}
	            	}
	            });
	        },
	        beforeSend: function(objeto){
	        },
	        complete: function(){
	        }
	    });
	}

    
    return false;
}

$('.owl-carousel-mas-productos-just-movil').owlCarousel({
	nav: true,
	dots: false,
	margin: 30,
	items: 1,
	navText: ';'
});
