// JavaScript Document
$(document).ready(function(e){
	alert('addcarrito en js.js')
	/*** INICIO OPEN MODAL ***/
	/*** se modifico: validate_login,validate_olvidastePassword,addCuenta ***/
	$(".addCarrito").on('click',function(){
		//var data = $('.modal-detalle-carrito:visible').length;
		//alert(data);
	    $.ajax({
            type  : "POST",
            url   : _tpl_+"includes/inc.encarrito.php",
            //url   : _url_web_+'ajax.php?action=login',
            //data  : $(this).parent('form.form').serialize(),
            data  : $(this).parent().parent('form.form').serialize(),
          	success: function(data) {
          		updateCestaAjax( 'listCesta' , null , null , null );
          		//Verificamos si un modal esta abierto => 0:el modal no esta visible ; 1: el modal esta visible
          		if($('.modal-detalle-carrito:visible').length == 0){ 
					$('.modal-detalle-carrito').modal('show');
				}
                $('.modal-detalle-carrito .modal-container').html('');
                $('.modal-detalle-carrito .modal-container').append(data);
                
            },
            beforeSend: function(objeto){
            	//$(".modal-detalle-carrito .modal-container-contenido").text('');
            	 //$('.modal-container').modal('hide');
            },
            complete: function(){
            	$('#mas_regalos_popup ul#listado_catalogo li').hover(function(){
					$(this)
						.find('.btn_detalle, .btn_compra')
						.stop()
						.fadeIn();		
				},function(){
						$(this)
							.find('.btn_detalle, .btn_compra')
							.hide();
				});
				var Wbtn = $('.btn_detalle').innerWidth();
				Wli  = $('#listado_catalogo li.limasregalos').innerWidth(); 
				left = (Wli - Wbtn)/2;
					
				$('.limasregalos .btn_detalle, .limasregalos .btn_compra').css({opacity:0.8, left: left});
				$('.btn_detalle, .btn_compra').hover(function(){
					$(this)
						.stop()
						.animate({
							opacity:1
						});
				},function(){
					$(this)
						.stop()
						.animate({
							opacity:0.8
						});
				});
				$('#continuarComprando, #verCarrito').css({opacity:0.8});
				$('#continuarComprando, #verCarrito').hover(function(){
					$(this).stop().animate({opacity:1});
				}, function(){
					$(this).stop().animate({opacity:0.8});
				})
            }
	    });
	    return false;
	});

	$(".realizarcompraquick").on("click",function(){
        var login = parent.$("#logueadoquick").val();
		if(login==1){
			window.location = _url_web_+'seccion/pedido/envio';
		}else{   
			$('.modal-detalle-carrito').modal('hide');	
			$('.modal-login-rapido').modal('show');
			$("#popup_acceso form input:first").focus();
		}
	});

	$('.close-modal-container').on('click', function(ev) {
	    var modal  = $(this).data('modal');
	    $('.'+modal).modal('hide');
	});
	/*** FIN OPEN MODAL ***/

	/*** INICIO AGREGAR COMPLEMENTO A UN PRODUCTO DETALLE ***/
	$(".btn_anadir").on('click',function(){
		
		var src = $(this).parent().find('.a_imagen img').attr('src');
		var name_complemento = $(this).parent().find('.nameProd').text();
		var precio = $(this).parent().find('input[name=precio]').val();
		var opcion = $(this).parent().parent().parent().parent().parent().parent().find('input[name=opcion]').val();
		var valor = $(this).parent().find('input[name=id_valor]').val();
		complemento = '<li id="'+valor+'"><div class="wrap_agregado">&nbsp;<img src="'+src+'" alt="" /></div>';
		complemento+= '<span>'+name_complemento+' $<b>'+precio+'</b> </span>';
		complemento+= '<a class="eliminar_prod">x Eliminar</a>';		
		complemento+= '</li>';
		//$("#prod_agregado ul").append(complemento);
		var $opt = $('form[name=envio_carrito] .opciones_'+valor+'');
		var cantidad_valor = 1;
		if( $opt.val() != undefined  ){
			cantidad_valor = parseInt($opt.val()) + 1;
			$opt.val(cantidad_valor); 
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
		
		addComplemento(complemento);
	});

	function addComplemento(complemento) {
		$("#prod_agregado ul").append(complemento); 
        $('.eliminar_prod').on('click', function() {
            $(this).parent().remove();
			var valor = $(this).parent().attr('id');
			var $opt = $('form[name=envio_carrito] .opciones_'+valor+'');		
			var cantidad_valor = 1;
			
			if( $opt.val() > 1  ){
				cantidad_valor = parseInt($opt.val()) - 1;
				$opt.val(cantidad_valor); 
			}else{
				$opt.remove();
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

	$(".eliminar_prod").on('click',function(){
		alert('hola mundoasdfasdfasdf');
		/*
		$(this).parent().remove();
		var valor = $(this).parent().attr('id');
		var $opt = $('form[name=envio_carrito] .opciones_'+valor+'');		
		var cantidad_valor = 1;
		
		if( $opt.val() > 1  ){
			cantidad_valor = parseInt($opt.val()) - 1;
			$opt.val(cantidad_valor); 
		}else{
			$opt.remove();
		}		
		var precio_temp = 0;
		$("#prod_agregado ul li").each(function(i, e) {	
			precio_temp += parseFloat($(this).find('span b').text());				
        });		
		var precio = $("#detalle_descripcion input[name=precio_producto]").val();		
		var precio_total = (parseFloat(precio) + parseFloat(precio_temp)) * $("#cant").val();		
		$("#precio_btn span#precio_temp").text('Precio: $'+precio_total.toFixed(2));	
		*/	
	});

	/*** INICIO AGREGAR COMPLEMENTO A UN PRODUCTO DETALLE ***/


	/*** INICIO MOSTRAR EL MAPA DE UN DISTRITO ***/
    $(".distritoMapa").change(function(){
        id_distrito = $(this).val();
		$.ajax({
			type:"GET",
			cache:false,
			url: _url_web_+"ajax.php?action=newUbicacionMapa",
			data:{ id_distrito: id_distrito},
			success: function(data) {
			//alert(data);				
			  $(".container-envio-mapa").text('');
              $(".container-envio-mapa").html(data);
			}
    	});
		return false;
    });
    /*** FIN MOSTRAR EL MAPA DE UN DISTRITO ***/

	/*** INICIO MODAL ASIGNAR FECHA ESPECIAL ***/
	$('.agregar-fecha-especial').on('click', function(ev) {
	      var nombre_destinatario  = $(this).data('nombres');
	      var id_destinatario  = $(this).data('id-destinatario');
	      var id_cliente  = $(this).data('id-cliente');
	      //alert(id_destinatario);
	      $(".modal-agregar-fecha-especial #id_cliente").val( id_cliente );
	      $(".modal-agregar-fecha-especial #id_destinatario").val( id_destinatario );
	      $(".modal-agregar-fecha-especial .nombre_destinatario").text( nombre_destinatario );
	});
	/*** INICIO MODAL ASIGNAR FECHA ESPECIAL ***/

	$(".buscar_destinatario_envio").autocomplete({
        source: "search.php?tipe=destinatario_envio",
        minLength: 2,
        select: function( event, ui ) {
            cargardatosEnvio(ui.item.id, 1);
        }
  	});
  	
	$("#buscar_destinatario").autocomplete({
        source: "search.php?tipe=destinatario",
        minLength: 2,
        select: function( event, ui ) {
            cargardatos(ui.item.id, 1);
        }
  	});
  	$('.nueva-fecha-especial').on('click', function(ev) {
        $this = $(this);
		$.ajax({
			type:"GET",
			cache:false,
			url: _url_web_+"ajax.php?action=newClienteDestinatario",
			data: $("#form-add-fechas-especiales").serialize(),
			success: function(data) {				
			  $(".container-body-fechas-especiales").text('');
              $("#id_destinatario,#fecha_especial,#buscar_destinatario,#id_tipo_destinatario,#id_ocasion").val('');
              $(".container-body-fechas-especiales").html(data);
			}
    	});
		return false;
    });
	$('.guardar-fecha-especial').on('click', function(ev) {
        //alert('guardando');
        $this = $(this);
		$.ajax({
			type:"GET",
			cache:false,
			url: _url_web_+"ajax.php?action=addClienteDestinatario",
			data: $("#form-fechas-especiales").serialize(),
			success: function(data) {				
				$(".container-fechas-especiales").animate({opacity:0},'fast',function(){
				  	$(this).hide(); 
					mensaje  = 'Felicidades se ha registrado correctamente una fecha especial !!!';
				  	$(".container-fechas-especiales").html(mensaje).show().animate({opacity:1},'fast');
				})
			}
    	});
		return false;
    });
    /* cambio de idioma chat */
    setTimeout( function () {
            $('#purechat-name-submit').val('Iniciar Chat');
            $('#purechat-name-submit').attr("onclick", "iniciarChat()");
            $('.please-entername').each(function () {
                    $(this).text("Porfavor ingrese su nombre");
            });
            $('.btn-expand').each(function () {
                    $(this).attr("title", "Expandir");
            });
            $('.btn-collapse').each(function () {
                    $(this).attr("title", "Disminuir");
            });
        }, 2000
    );
		
    setInterval(function () {
 
        $('.purechat-widget-title-link').each(function () {
            if ($(this).text().indexOf("Chatting with") != -1) {
                $(this).text($(this).text().replace("Chatting with", "Chateando con"));
                $(this).text($(this).title().replace("Chatting with", "Chateando con"));
            }
            if ($(this).text().indexOf("Chat Closed") != -1) {
                $(this).text($(this).text().replace("Chat Closed", "Chat cerrado"));
                $(this).text($(this).title().replace("Chat Closed", "Chat cerrado"));
            }
        });

        $('.purechat-message-note').each(function () {

            // purechat-widget-title-link
            if ($(this).text().indexOf("An operator has not yet connected.") != -1)
                    $(this).text("Un operador te atendera pronto");
            if ($(this).text().indexOf("has joined the chat!") != -1)
                    $(this).text($(this).text().replace("has joined the chat!", "entró al chat!"));
            if ($(this).text().indexOf("has left the chat!") != -1)
                    $(this).text($(this).text().replace("has left the chat!", "ha abandonado el chat!"));
            if ($(this).text().indexOf("Thanks for") != -1)
                    $(this).text("Gracias por chatear con nosotros.");
            if ($(this).text().indexOf("An operator will be right with you! Feel free to hide this box and navigate around the site.") != -1)
                    $(this).text($(this).text().replace("An operator will be right with you! Feel free to hide this box and navigate around the site.", "Hola cómo podemos ayudarte?"));
            $(".purechat-send-form-message").focus();
        });
    }, 100);
	
	// --- BOTON VOLVER PEDIDO --// 
	$("#btn_volver").click(function(){
		history.back(1);
	})
	
	// --- VALIDATION LIBRO RECLAMO --//
	if( $("input[name='persona_natural']:checked").val()==2 ){ // Persona Natural
		$('#razon_social').attr("readonly",false);						
	}else{ // Persona Juridica
		$('#razon_social').attr("readonly",true);						
	}
	
	// --- TIME PICKER , FECHA HORA --- ///
	$('#fecha_hora').datetimepicker('setDate', (new Date()) ).datetimepicker({
		minDate: 0,
		controlType: 'select',
		dateFormat: 'dd/mm/yy',
		timeFormat: "hh:mm tt"
	});	
	//$('#fecha_hora')
	
	// ---  PARA VISA -- //
	$('#verified-visa').click(function(){		
		window.open($(this).attr('href'),'',"width=606,height=402,resisable=no,menubar=no,titlebar=yes");
		return false;
	})
	
	// ---SELECT ENVIO CESTA ---//
	$("#slc_envio_cesta").change(function(){
		var precio_envio = $(this).find('option:selected').attr('title');		
		$("#flete .porcalcular span").text(precio_envio);
		var total = parseFloat($("#total_precio #subT").text().replace('$',''));
		
		var tc = parseFloat($("#cambio").val());
		
		var total_cp = (parseFloat(precio_envio.replace('$','')) + total).toFixed(2) ;
		
		//alert('$'+(parseFloat(precio_envio.replace('$',''))+total).toFixed(2));
			
		$("#numdolar span").html('$'+(parseFloat(precio_envio.replace('$',''))+total).toFixed(2) );
		$("#numsol span").html('S/.'+((parseFloat(precio_envio.replace('$',''))+total)*tc).toFixed(2) );
	})

	// --- VALIDATION VER CARRITO --- //
	var url = window.location.toString();
	var cadena = url.split('?code=');
	var cadena_pago = url.split('?step=');	
	var step = '';	
	if( cadena.length > 0 && cadena[1]!=undefined ){
		step = parseInt(cadena[1]);
	}else if( cadena_pago.length > 0 && cadena_pago[1]!=undefined ){
		step = cadena_pago[1];
	}	
	if(step=='confirmacion' || step > 0){	
		$("#header #carrito").removeClass('move');
	}		
	
	// --- MENU, SUBMENU, FILTROS --- //
	$("#header #carrito").hover(function(e){
		$("#header #nav").css('z-index',1);
		},function(){
		$("#header #nav").css('z-index',2);
	})
	
			
	
	function msieversion(){
      var ua = window.navigator.userAgent
      var msie = ua.indexOf ( "MSIE " )

      if ( msie > 0 ){      // If Internet Explorer, return version number
         return parseInt (ua.substring (msie+5, ua.indexOf (".", msie )))
      }else{                 // If another browser, return 0
         return 0
     }
   }

   $(".ordenar_por").change(function(){
		
		var contenedor = $(this).parent("form");		
		var optorder = $(this).val();		
		var url = document.URL;		
		var busqRegex = /\?q=/;
		var busqRegexo = /&o=/;
		var urlsend = $("#urlq").val();
		if(url.match(busqRegex)){			
			var tmpq = url.split('?q=');			
			if(url.match(busqRegexo)){				
				var tmpqo = url.split('&o=');
				var newurl = tmpqo[0] +'&o='+  optorder;
			}else{
				var newurl = urlsend +'?q='+ tmpq[1] +'&o='+  optorder;
			}		
			location.href = newurl;		
		}else if( optorder == "Seleccione" ){
						
		}else{
			contenedor.submit();
		}		
	});

   // --- OPEN SANS FONT --- //
	WebFontConfig = {
		google: { families: [ 'Open+Sans:700:latin' ] }
	};
	(function() {
		var wf = document.createElement('script');
		wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
		  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(wf, s);
	})(); 

	// --- HOVER FOOTER SOCIAL --- //
	$("#fSocial ul li a img").css({opacity:0.8});
	$("#fSocial ul li a img").hover(function(){
		$(this)
			.stop()
			.animate({
				opacity:1
			},50);
	},function(){
		$(this)
			.stop()
			.animate({
				opacity:0.8
			});
	})

	// *---- HOVER PROD ---- //

	var Wbtn = $('.btn_detalle').innerWidth();
        Wli  = $('#listado_catalogo li').innerWidth(); 
        left = (Wli - Wbtn)/2;

	$('.btn_detalle, .btn_compra , #realizarcompra').css({opacity:0.8, left: left});
	$('.btn_detalle, .btn_compra , #realizarcompra').hover(function(){
            $(this)
                .stop()
                .animate({
                        opacity:1
                });
	},function(){
            $(this)
                .stop()
                .animate({
                        opacity:0.8
                });
	});
	$('ul#listado_catalogo li').hover(function(){
            $(this).find('.btn_detalle, .btn_compra').stop().fadeIn();		
	},function(){
            $(this).find('.btn_detalle, .btn_compra').hide();
	});

	// --- DETALLE PRODUCTO --- //
	if($("#detalle_imagenes ul li").length>1){
		$('#detalle_imagenes ul').bxSlider({
		  pause:10000,
		  pagerCustom: '#detalle_thumbs',
		  controls: false,
		  auto: true
		});
	}

	// --- DETALLE AÑADIR --- //
	if ( $('#agregar_regalo ul li').length > 3 ){
		$('#agregar_regalo ul').bxSlider({
			slideWidth: 180,
			minSlides:3,
			maxSlides:3,
			moveSlides: 1,
			slideMargin: 5,
			pager: false
		});
	}else{
		$('#agregar_regalo ul').width('560').css('margin-left',25);
	}

	$('.btn_anadir, #btn_agregar_carrito').css({opacity:0.8});
	$('.btn_anadir, #btn_agregar_carrito').hover(function(){
		$(this).stop().animate({opacity:1});
	}, function(){
		$(this).stop().animate({opacity:0.8});
	})

	
	// -- SCRIPT ONLY NUMBER -- //
	$(".solo_numero").keydown(function(){
			if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 		
			(event.keyCode == 65 && event.ctrlKey === true) || 			
			(event.keyCode >= 35 && event.keyCode <= 39)) {
			 return;
			}
			else {	
			if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
			event.preventDefault(); 
			}   
			}
	});	
	
	// -- CANTIDAD DETALLE -- //
	$("#cant").keyup(function(){			
		var precio_temp = 0;
		$("#prod_agregado ul li").each(function(i, e) {			
           precio_temp += parseFloat($(this).find('span b').text());	
        });
		var precio = $("#detalle_descripcion input[name=precio_producto]").val();		
		var precio_total = (parseFloat(precio) + parseFloat(precio_temp))*$("#cant").val();		
		$("#precio_btn span#precio_temp").text('Precio: $'+precio_total.toFixed(2));		
	})
	
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
		alert('test');
		var cantidad = $(this).val();
		if(cantidad>0){		
			var li = $(this).parent();
			var pu = li.prev().children().text().replace('$','');
			var newst = (pu * cantidad).toFixed(2);		
			li.next().children().text('$'+newst);		
			var id = li.parent().eq(0).find('.info_cesta .eliminar').attr('id');		
			var sum_subtotal = 0;
			$("#tabla_cont > li > ul > li.td4").each(function(i,e) {
			   sum_subtotal += parseFloat($(this).children().text().replace('$',''));		 
			});		
			$("#total_precio #subT .boxright span").text('$'+sum_subtotal.toFixed(2));		
			options = id.split(parseFloat(id));
			
			var precio_envio = '0';
			
			if( $("#slc_envio_cesta option:selected").attr('title')!= undefined ){
				precio_envio = $("#slc_envio_cesta option:selected").attr('title');
			}
			
			var total = parseFloat(sum_subtotal);		
			var tc = parseFloat($("#cambio").val());		
			var total_cp = (parseFloat(precio_envio.replace('$','')) + total).toFixed(2);
						
			$("#numdolar span").html('$'+(parseFloat(precio_envio.replace('$',''))+total).toFixed(2) );
			$("#numsol span").html('S/.'+((parseFloat(precio_envio.replace('$',''))+total)*tc).toFixed(2) );
			
			updateCestaAjax( 'CantidadCesta' , id , cantidad , options[1] );
		}else{
			$(this).val('');
		}
	});
	
	// -- ELIMINAR -- //
	$(".eliminar a").click(function(){
		$(this).parent().parent().parent().parent().parent().remove();
		var id = $(this).parent().attr('id');
		var sum_subtotal = 0;
			
			
		
		if( $("#tabla_cont > li").length >= 0 ){
			
			$("#tabla_cont > li > ul > li.td4").each(function(i,e) {
			   sum_subtotal += parseFloat($(this).children().text().replace('$',''));		 
			});	
				
			$("#total_precio #subT .boxright span").text('$'+sum_subtotal.toFixed(2));
			
			var precio_envio = '0';
			
			if( $("#slc_envio_cesta option:selected").attr('title')!= undefined ){
				precio_envio = $("#slc_envio_cesta option:selected").attr('title');
			}
			
			
			var total = parseFloat(sum_subtotal);		
			var tc = parseFloat($("#cambio").val());		
			var total_cp = (parseFloat(precio_envio.replace('$','')) + total).toFixed(2);
						
			$("#numdolar span").html('$'+(parseFloat(precio_envio.replace('$',''))+total).toFixed(2) );
			$("#numsol span").html('S/.'+((parseFloat(precio_envio.replace('$',''))+total)*tc).toFixed(2) );
			
			updateCestaAjax( 'deleteCesta' , id , null , null );
		}
		
		if( $("#tabla_cont > li").length == 0 ){
			
			$("#tabla_cont > li > ul > li.td4").each(function(i,e) {
			   sum_subtotal += parseFloat($(this).children().text().replace('$',''));		 
			});	
			$("#total_precio #subT .boxright span").text('$'+sum_subtotal.toFixed(2));
			$("#total_precio .tpBox:not(:eq(0))").remove();
			$("#total_precio .btn-submit").remove();
			
		}
		
		
	});

	function cargardatosEnvio(datos,id) {
	    var listadatos = new Array();
	    listadatos = datos.split('+');
	    //var cadena=listadatos[1];
	    //alert(cadena);
	    $("#nombre").val(listadatos[1]);  
	    $("#apellidos").val(listadatos[2]);   
	    $("#telefono").val(listadatos[3]);  
	    //$("#direccion").val(listadatos[4]);   
	    //$("#referencia").val(listadatos[5]);  
	    //var cadena=listadatos[6]; //latitud_destinatario
	    //var cadena=listadatos[7]; //longitud_destinatario
	    //var cadena=listadatos[8]; //fecha_full_destinatario
	    //alert(cadena);

	}

	function cargardatos(datos,id) {
	    var listadatos = new Array();
	    listadatos = datos.split('+');
	    var cadena=listadatos[0];
	    $("#id_destinatario").val(cadena);
	}	
	
	function updateCestaAjax( action , id , k , opciones ){
		
		$("#carrito #countCar").text('');
		$("#loader_car").show();
		$.get('ajax.php',{section:'cesta' , action : action , id:id , cantidad:k , opciones:opciones},function(data){			
			$("#header #carrito").html(data);			
			$("#loader_car").hide();
		});
	}
	
	//-- AÑADIR COMPLETENTO -- //
	$(".btn_anadir___").click(function(){
		
		var src = $(this).parent().find('.a_imagen img').attr('src');
		var name_complemento = $(this).parent().find('.nameProd').text();
		var precio = $(this).parent().find('input[name=precio]').val();
		var opcion = $(this).parent().parent().parent().parent().parent().parent().find('input[name=opcion]').val();
		var valor = $(this).parent().find('input[name=id_valor]').val();
		
		complemento = '<li id="'+valor+'"><div class="wrap_agregado">&nbsp;<img src="'+src+'" alt="" /></div>';
		complemento+= '<span>'+name_complemento+' $<b>'+precio+'</b> </span>';
		complemento+= '<a class="eliminar_prod">x Eliminar</a>';		
		complemento+= '</li>';
		
		$("#prod_agregado ul").append(complemento);
		
		var $opt = $('form[name=envio_carrito] .opciones_'+valor+'');
		var cantidad_valor = 1;
		
		if( $opt.val() != undefined  ){
			cantidad_valor = parseInt($opt.val()) + 1;
			$opt.val(cantidad_valor); 
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
			
		
	})
	
	// -- ELIMINAR COMPLEMENTO -- //
	$(".eliminar_prod___").on('click',function(){
		$(this).parent().remove();
		var valor = $(this).parent().attr('id');
		var $opt = $('form[name=envio_carrito] .opciones_'+valor+'');		
		var cantidad_valor = 1;
		
		if( $opt.val() > 1  ){
			cantidad_valor = parseInt($opt.val()) - 1;
			$opt.val(cantidad_valor); 
		}else{
			$opt.remove();
		}		
		var precio_temp = 0;
		$("#prod_agregado ul li").each(function(i, e) {	
			precio_temp += parseFloat($(this).find('span b').text());				
        });		
		var precio = $("#detalle_descripcion input[name=precio_producto]").val();		
		var precio_total = (parseFloat(precio) + parseFloat(precio_temp)) * $("#cant").val();		
		$("#precio_btn span#precio_temp").text('Precio: $'+precio_total.toFixed(2));		
	});
	
	// --- BOX DETALLE Y COSTOS --- //
	$('#cont_costo').hide();
	$("#detalles_costo #tabs h4").click(function(){
		$(this)
			.addClass('active')
			.siblings()
				.removeClass('active');

		var id  = $(this).attr('rel');
		$('#'+id)
			.show()
			.siblings()
				.hide();
	});

	/*TIPO DE COMPROBANTE*/
	$("#comprobante").change(function () {
	  var str = $(this).val();
	  if(str=='Boleta'){
	  	$("#caja1").show();
		$("#caja2").hide();
	  }else{
		 $("#caja2").show();
		 $("#caja1").hide();
	  }
	}).trigger('change');
    
	
	$("#continuarComprando").on('click',function(){
            $.fancybox.close();
	});

	// --- POPUP EN CARRITO --- //
	$(".addCarrito___").on('click',function(){ 
		//alert($(this).parent().find('input').val());
		var prod = $(this).parent().find('input').val();
		$.fancybox.showLoading();
		$this = $(this);
		
		$.ajax({
			type:"POST",
			cache:false,
			url:_tpl_+"includes/inc.encarrito.php",
			data: $this.parents('form.form').serialize(),
			success: function(data) {				
				
				updateCestaAjax( 'listCesta' , null , null , null );
				
				$.fancybox.hideLoading();
				$.fancybox({
					content		: data,
					width		: 580,
					fitToView	: false,
					autoSize	: true,
					closeClick	: false,
					closeBtn 	: true,
					padding 	: 20,		
					'autoDimensions':true,
					'scrolling':'no',
					afterShow	: function(){			
						$('#mas_regalos_popup ul#listado_catalogo li').hover(function(){
							$(this)
								.find('.btn_detalle, .btn_compra')
									.stop()
									.fadeIn();		
						},function(){
							$(this)
								.find('.btn_detalle, .btn_compra')
									.hide();
						});
						var Wbtn = $('.btn_detalle').innerWidth();
						Wli  = $('#listado_catalogo li.limasregalos').innerWidth(); 
						left = (Wli - Wbtn)/2;
					
						$('.limasregalos .btn_detalle, .limasregalos .btn_compra').css({opacity:0.8, left: left});
						$('.btn_detalle, .btn_compra').hover(function(){
							$(this)
								.stop()
								.animate({
									opacity:1
								});
						},function(){
							$(this)
								.stop()
								.animate({
									opacity:0.8
								});
						});
						$('#continuarComprando, #verCarrito').css({opacity:0.8});
						$('#continuarComprando, #verCarrito').hover(function(){
							$(this).stop().animate({opacity:1});
						}, function(){
							$(this).stop().animate({opacity:0.8});
						})
    				}
				});
				
			}
    	});
		return false;
	});

	// --- ACTIVE FORMAS DE PAGO --- //
	$('.formas_pago').click(function(){
		cleanMsgError();
		$(this)
			.addClass('active')
			.siblings()
				.removeClass('active');

		$(this)
			.find('input:radio')
			.attr("checked", "checked");
	});

	// --- BTN VER MAS DETALLE --- //
	if($('#detalles_costo').length>0){
		var topUbica = $('#detalles_costo').position().top;
		$('.btn_vertodos').click(function(){
			$('html, body')
				.animate({
					scrollTop: topUbica + 120
				}, 'slow');
		});
	}
	
	
	/* LOGIN POPUP	*/
	$(".popup").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '100%',
		height		: '100%',
		autoSize	: true,
		closeClick	: false,
		closeBtn	: false,
		padding		: 0,
		/*
		beforeShow: function() {
			//$.fancybox.close();
			alert('hola');
    	},*/
		afterShow	: function(){	
			$("#popup_acceso form input:first").focus();
		}
		
	});
	
	/* BTN CLOSE POPUP LOGIN */	
	$("#btn_close").on("click",function(){
		//no esta funcional
		$.fancybox.close();
	})

	/*  LOGIN RAPDIO PEDIDO*/
	$(".popuprapido").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: true,
		closeClick	: false,
		closeBtn	: false,
		padding		: 0,
		afterShow	: function(){	
			$("#popup_acceso form input:first").focus();
		}
	});
	
	
	/* MENSAJES DEDICATORIA POP UP */
	$(".mensajes").fancybox({
		maxWidth	: 500,
		maxHeight	: 660,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: true,
		closeBtn	: false,
		padding		: 0
	});
	
	/* PREVIEW TARJETA */
	$(".tarjeta").fancybox({
		maxWidth	: 438,
		maxHeight	: 320,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: true,
		closeClick	: false,
		closeBtn	: true,
		padding		: 0
	});
	
	/* VALIDATE COMBO MENSAJES */
	$("#mensajes_plantillas").on("change",function () {
		$("#loading").show();
		$("#mensajes").html('<br/>Cargando...');
		
		if($(this).val() != ""){
		
		$.get("ajax.php",{id:$(this).val(),action:'listMensajes'},function(data){
			$("#loading").hide();
			
			if($.isArray(data)){
				
				if( data.length > 0 ){
					var html = '<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div><div class="viewport"><div class="overview"><ul id="listmesajes">';
					$.each(data, function(i, item) {
						html+='<li><a title="Click para agregar a tarjeta">'+item.descripcion+'</a></li>';
					})		
					html+='</ul></div></div>';
				}else{
					html = "<br/>No se encontraron mensajes";
				}						
			}
			$("#mensajes").html(html);
			
			/* SCROLL BAR MENSAJES */
			$('#mensajes').tinyscrollbar({ sizethumb: 30 });
			
		},'json');
		
		}else{
			$("#loading").hide();
			$("#mensajes").html('<br/>Eliga una de las opciones');		
		}
		
		
	});
	/* LIsT MENSAJES */
	$("#listmesajes li").on("click",function(){ /*VALIDAR USO*/
		$.fancybox.close();
		var txt = $(this).find("a").text();
		$("#dedicatoria").val(txt);
		$.post("ajax.php",{mensaje:txt},function(data){
			
		})
	})

	$("#realizarcompraquick___").on("click",function(){
                var login = parent.$("#logueadoquick").val();
		if(login==1){
                    
			window.location = _url_web_+'seccion/pedido/envio';
		}else{   
			$.fancybox({
				type : 'ajax',
				href : 'ajax.php?action=loginRapido',
				maxWidth	: 800,
				maxHeight	: 600,
				fitToView	: false,
				autoSize	: true,
				closeClick	: false,
				closeBtn	: false,
				padding		: 0,
				afterShow	: function(){	
					$("#popup_acceso form input:first").focus();
				}
			});
			
		}
	})

	$("#buscarblog").keydown(function(e){
		var q = this.value;
		if( e.keyCode==13 ){
			window.location = 'blog/q='+q;
		}
	})
	
	$("#btnBuscarblog").click(function(){
		var q = $("#buscarblog").val();
		window.location = 'blog/q='+q;
		
	})
	
});


/*** INICIO MODAL AGREGAR FECHA ESPECIAL ***/
function validarAgregarFechaEspecial(form) {
	/*
    var email_cliente = form.email_cliente.value;    
    var email_amigo = form.email_amigo.value; 
    var url_enviar_amigo = $(".url_enviar_amigo").html();
    //alert(url_enviar_amigo);

    var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    if (email_cliente == "") {
        $(".mensaje-recomendar-amigo").text('Ingresar su correo electrónico');
        $("#email_cliente_recomendado").focus();      
        return false;
    }
    if (!email_cliente.match(emailRegex)) {
        $(".mensaje-recomendar-amigo").text('Ingresar un correo electrónico válido');
        $("#email_cliente_recomendado").focus();      
        return false;
    }
    if (email_amigo == "") {
        $(".mensaje-recomendar-amigo").text('Ingresar el correo electrónico de su amigo');
        $("#email_amigo_recomendado").focus();      
        return false;
    }
    if (!email_amigo.match(emailRegex)) {
        $(".mensaje-recomendar-amigo").text('Ingresar el correo electrónico de su amigo válido');
        $("#email_amigo_recomendado").focus();         
        return false;
    }
    if(document.getElementById('privacidad_recomendado').checked == false){
        $(".mensaje-recomendar-amigo").text('Debe aceptar los Términos y Condiciones.');
        return false;
    }
    */
    //var ruta=$("#ruta_web").val();
    $.ajax({     
              type  : "GET", 
              url   : "ajax.php?action=addClienteDestinatario",
              data  : $("#form-add-fecha-especial").serialize(),
              success: function(data) {
              		/*
                    $("#fecha_especial").val(date('d/m/Y')); 
                    $("#id_tipo_destinatario").val('');  
                    $("#id_ocasion").val('');
                    */
                    $('.modal-agregar-fecha-especial').modal('hide');
              		$(".container-body-fechas-especiales").text('');
                    $(".container-body-fechas-especiales").html(data);
                    //var URLactual = window.location;
                    //window.location.replace(URLactual);
                    /*
                    setTimeout(function(){
                        //$('.modal-agregar-fecha-especial').modal('hide');
                        var URLactual = window.location;
                      	window.location.replace(URLactual);
                    },5000)
                    */
              },
              beforeSend: function(objeto){
                                 
              },
              complete: function(){                
              }
    });
    
    return false;
}
/*** FIN MODAL AGREGAR FECHA ESPECIAL ***/

/*** INICIO MODAL NUEVA FECHA ESPECIAL ***/
function validarNuevaFechaEspecial(form) {

    //var ruta=$("#ruta_web").val();
    $.ajax({     
              type  : "GET", 
              url   : "ajax.php?action=nuevoClienteDestinatario",
              data  : $("#form-nueva-fecha-especial").serialize(),
              success: function(data) {
              		$('.modal-nueva-fecha-especial').modal('hide');
              		$(".container-body-fechas-especiales").text('');
                    //$("#fecha_especial").val(date('d/m/Y')); 
                    //$("#id_tipo_destinatario").val('');  
                    //$("#id_ocasion").val('');
                    //var URLactual = window.location;
                    //window.location.replace(URLactual);

                    $(".container-body-fechas-especiales").html(data);
                 
              },
              beforeSend: function(objeto){
                                 
              },
              complete: function(){                
              }
    });
    
    return false;
}
/*** FIN MODAL NUEVA FECHA ESPECIAL ***/

function iniciarChat() {
	setTimeout(function () {
		$('.purechat-message-note').text('Hola en que podemos ayudarte');
	}, 100);
}



function show_menor_edad(){
	
	if( $("input[name='menor_edad']:checked").val()==1 ){
		$('#nombres_tutor').focus();				
		$('#nombres_tutor').attr("readonly",false);		
		$('#documento_tutor').attr("readonly",false);						
	}else{
		$('#nombres_tutor').attr("readonly",true);		
		$('#documento_tutor').attr("readonly",true);						
		
	}
}

function show_empresa(){
	if( $("input[name='persona_natural']:checked").val()==2 ){ // Persona Natural
		$('#razon_social').attr("readonly",false);						
	}else{ // Persona Juridica
		$('#razon_social').attr("readonly",true);						
	}
}

// Listado de COMBOS 1
function show_provincia(data){
			
}

function show_distrito(data){
		
}



function validate_form_reclamo( form ){
	var nombres = form.nombres.value;
	var domicilio = form.direccion2.value;
	var numero_documento = form.numero_documento.value;
	var razon_social = form.razon_social.value;
	var telefono = form.telefonos2.value;
	var distrito = form.distrito.value;
	var email = form.email.value;
	var nombres_tutor = form.nombres_tutor.value;
	var documento_tutor = form.documento_tutor.value;
	var documento_numero_pago = form.documento_numero_pago.value;
	var sedes = form.sedes.value;
	var descripcion_servicio = form.descripcion_servicio.value; 
	var descripcion_reclamacion = form.descripcion_reclamacion.value; 
	
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
		
	if( $("input[name='persona_natural']:checked").val()==1 ){}else{ 
	// Persona Juridica
		if( razon_social == "" ){
			alert('Ingrese su razón social');
			form.razon_social.focus();
			return false;
		}					
	}
	
	if( nombres == "" ){
		alert('Ingrese su nombre y apellido');
		form.nombres.focus();
		return false;
	}if( numero_documento == "" ){
		alert('Ingrese su numero de documento');
		form.numero_documento.focus();
		return false;
	}if( domicilio == "" ){
		alert('Ingrese su domicilio');
		form.domicilio.focus();
		return false;
	}if( telefono == "" ){
		alert('Ingrese su telefono');
		form.telefono.focus();
		return false;
	}if( distrito == "--" ){
		alert('Seleccione su distrito');
		form.distrito.focus();
		return false;
	}if( email == " " ){
		alert('Ingrese su email');
		form.email.focus();
		return false;
	}if(!email.match(emailRegex)) {
		alert('Ha ingresado un email inválido');
		form.email.focus();
		return false;
	}
	
	if( $("input[name='menor_edad']:checked").val()==1 ){
		if( nombres_tutor == " " ){
			alert('Ingrese el nombre del tutor');
			form.nombres_tutor.focus();
			return false;
		}if( documento_tutor == " " ){
			alert('Ingrese el documento del tutor');
			form.documento_tutor.focus();
			return false;
		}
	}
	

	
	if( documento_numero_pago == " " ){
		alert('Ingrese el numero del comprobante de pago');
		form.documento_numero_pago.focus();
		return false;
	}if( descripcion_servicio == " " ){
		alert('Ingrese la descripcion del servicio');
		form.descripcion_servicio.focus();
		return false;
	}if( descripcion_reclamacion == " " ){
		alert('Ingrese la descripcion del reclamo');
		form.descripcion_reclamacion.focus();
		return false;
	}
		
	if(!$("input[name='condicion']").is(":checked")){
		alert('Debe seleccionar el check final del confirmación');
		$("input[name='condicion']").focus();
		return false;
	}
	
	
	$.fancybox.showLoading();
	
	$.ajax({
			type:"GET",
			cache:false,
			url:"ajax.php",
			data: $("#form_reclamacion").serialize(),
			success: function(data) {
				if(data=='1'){
					$.fancybox.hideLoading();
					$("#form_reclamacion input,#form_reclamacion textarea").val('');
					
					$.fancybox({
						content	: '<div id="franja-top"></div><div id="popup_acceso" class="olvidaste"><a id="btn_close"></a><h2>Envío de Reclamación</h2><br/><br/>Se envió email correctamente<br/><br/></div>',
						padding		: 0,
						closeBtn	: false						
					});
					setTimeout(function(){
						$.fancybox.close();
					},3000)
				}
			}
	});
	
	return false;
	
}

function validate_login_rapido( form , action ){
	
	var nombres = form.nombres.value;
	var apellidos = form.apellidos.value;
	var email = form.email.value;
	var telefono = form.telefono.value; 
	var ciudad = form.ciudad.value; 
	var pais = form.pais.value; 
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
		
	$(".img_error").html('');
	
	if(nombres == "") {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#nombres").addClass('error').before('<div class="img_error"></div>');
		$("#nombres").focus();
		return false;
	}
	if(apellidos == "") {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#apellidos").addClass('error').before('<div class="img_error"></div>');
		$("#apellidos").focus();
		return false;
	}
	if(email == "") {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#email").addClass('error').before('<div class="img_error"></div>');
		$("#email").focus();
		return false;
	}
	if(!email.match(emailRegex)) {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#email").addClass('error').before('<div class="img_error"></div>');
		$("#email").focus();
		return false;
	}
	if( telefono == "" ){
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#telefono").addClass('error').before('<div class="img_error"></div>');
		$("#telefono").focus();
		return false;
	}
	if( pais == "" ){
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#pais").addClass('error').before('<div class="img_error"></div>');
		$("#pais").focus();
		return false;
	}
	if( ciudad == "" ){
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#ciudad").addClass('error').before('<div class="img_error"></div>');
		$("#ciudad").focus();
		return false;
	}
	
	
	$(".img_error").remove();
	$("#registro-form input").removeClass("error");
		
	eval('action()');
	
	return false;
	
}

function validate_busqueda(form){
	var q = form.q.value;
	if(q==""){
		return false;
	}else{
		return true;
	}
}

jQuery.preloadImages = function()
{
  for(var i = 0; i<arguments.length; i++)
  {
    jQuery("<img>").attr("src", arguments[i]);
  }
}



function validate_pedido( form ){
	var logeado = form.logeado.value;
	if(logeado){
		form.submit();
	}else{
		$.fancybox({
			type : 'ajax',
			href : 'ajax.php?action=loginRapido',
			maxWidth	: 800,
			maxHeight	: 600,
			fitToView	: false,
			autoSize	: true,
			closeClick	: false,
			closeBtn	: false,
			padding		: 0,
			afterShow	: function(){	
				$("#popup_acceso form input:first").focus();
			}
		});
	}
	return false;
}

function addCuenta(){
	alert('test');
	var data = ($('.modal-registrarse:visible').length > 0)?$("form.registro-form").serialize():$("form.registro-rapido-form").serialize();
	$.ajax({
			type:"GET",
			cache:false,
			url:"ajax.php",
			//data: $("#registro-form").serialize()+'&action=addCuenta',
			data: data+'&action=addCuenta',
			success: function(data) {
				if(data=='1'){
					// cliente registrado sin productos en la cesta
					$("#popup_acceso form input").val('');
					$('.modal-registrarse').modal('hide');
					$('.modal-redireccionar').modal('show');
	                $('.modal-redireccionar .modal-container').html('');
	                var contenido = '<div id="franja-top"></div><div id="popup_acceso" class="registro"><h2>Soy nuevo cliente, regístrate aquí:</h2><br/><br/>Redirigiendo a su cuenta ...<br/><br/></div>';
	                $('.modal-redireccionar .modal-container').append(contenido);
					setTimeout(function(){
						$("body").animate({opacity:0},500,function(){
							window.location=_url_web_+'seccion/cuenta';
						})	
						$('.modal-redireccionar').modal('hide');					
					},3000)
				}else if(data=='2'){
					// cliente registrado pero con productos en la cesta
					$("#popup_acceso form input").val('');
					$('.modal-login-rapido').modal('hide');
					$('.modal-registrarse').modal('hide');
					$('.modal-redireccionar').modal('show');
	                $('.modal-redireccionar .modal-container').html('');
	                var contenido = '<div id="franja-top"></div><div id="popup_acceso" class="login"><h2>Entrar aquí:</h2><br/><br/>Redirigiendo a pedido ...<br/><br/></div>';
	                $('.modal-redireccionar .modal-container').append(contenido);
					setTimeout(function(){
						$("body").animate({opacity:0},500,function(){
							window.location=_url_web_+'seccion/pedido/envio';
						})	
						$('.modal-redireccionar .modal-container').modal('hide');
					},3000)
				}else{
					$("#email").addClass('error').before('<div class="img_error"></div>');					
					$("#email").focus();
				}
			}
	});
}
function updateCuenta(){
	$("#loading_cuenta").show();	
	$.ajax({
			type:"GET",
			cache:false,
			url:"ajax.php",
			data: $("#registro-form").serialize()+'&action=updateCuenta',
			success: function(data) {
				if(data=='1'){
					$("#loading_cuenta").hide();
					$("#txtrptacuenta").show();
					setTimeout(function(){
						$("#txtrptacuenta").fadeOut('fast');
					},2000);
				}else{
					
				}
			}
	});
}

function validate_descarga ( form ){
	var name_catalogo = form.name_catalogo.value;
	var mail_catalogo = form.mail_catalogo.value;
	
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
	$(".img_error").html('');
	if(name_catalogo == "") {
		$(".img_error").remove();
		$("#dCatalogo form li").removeClass("error");
		$("#name_catalogo").parent().addClass('error').children().before('<div class="img_error"></div>');
		$("#name_catalogo").focus();
		return false;
	}if(mail_catalogo == "") {
		$(".img_error").remove();
		$("#dCatalogo form li").removeClass("error");
		$("#mail_catalogo").parent().addClass('error').children().before('<div class="img_error"></div>');
		$("#mail_catalogo").focus();
		return false;
	}if(!mail_catalogo.match(emailRegex)) {
		$(".img_error").remove();
		$("#dCatalogo form li").removeClass("error");
		$("#mail_catalogo").parent().addClass('error').children().before('<div class="img_error"></div>');
		$("#mail_catalogo").focus();
		return false;
	}
	
	$(".img_error").remove();
	$("#dCatalogo form li").removeClass("error");
	
	$.fancybox.showLoading();
	
	$.ajax({
			type:"GET",
			cache:false,
			url:"ajax.php",
			data: $("#form-download-catalogo").serialize()+'&action=addCliente',
			success: function(data) {
				if(data=='1'){
					$.fancybox.hideLoading();
					$.fancybox({
						content	: '<div id="franja-top"></div><div id="popup_acceso" class="olvidaste"><a id="btn_close"></a><h2>Descarga tu catalogo</h2><br/><br/>Hola '+$("#name_catalogo").val()+', se ha enviado al email '+$("#mail_catalogo").val()+' un enlace para que puede descargar el catalogo de Don Regalo, <br/><br/>Gracias.<br/><br/></div>',
						padding		: 0,
						closeBtn	: false						
					});
					$("#form-download-catalogo input").val('');
					setTimeout(function(){
						$.fancybox.close();
					},10000)
				}
			}
	});
	
	return false;
}

function validate_registro( form , action ){
	
	var nombres = form.nombres.value;
	var apellidos = form.apellidos.value;
	var email = form.email.value;
		
	var password = (form.password != undefined)?form.password.value:''; 
	var repeat_password = (form.password != undefined)?form.repeat_password.value:''; 
	
	var telefono = form.telefono.value; 
	var direccion = form.direccion.value; 
	var ciudad = form.ciudad.value; 
	var pais = form.pais.value; 
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

	$(".img_error").html('');
	
	if(nombres == "") {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#nombres").addClass('error').before('<div class="img_error"></div>');
		$("#nombres").focus();
		return false;
	}
	if(apellidos == "") {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#apellidos").addClass('error').before('<div class="img_error"></div>');
		$("#apellidos").focus();
		return false;
	}
	if(email == "") {
	
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#email").addClass('error').before('<div class="img_error"></div>');
		$("#email").focus();
		return false;
	}
	if(!email.match(emailRegex)) {
		
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#email").addClass('error').before('<div class="img_error"></div>');
		$("#email").focus();
		return false;
	}	 
	if(form.password != undefined && password == "") {

		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#password").addClass('error').before('<div class="img_error"></div>');
		$("#password").focus();
		return false;
	}
	if(form.password != undefined && repeat_password == "") {
		
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#repeat_password").addClass('error').before('<div class="img_error"></div>');
		$("#repeat_password").focus();
		return false;
	}
	if( password != repeat_password ){
		
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#password").addClass('error').before('<div class="img_error"></div>');
		$("#repeat_password").addClass('error').before('<div class="img_error"></div>');
		$("#password").focus();		
		return false;
	}
	if( telefono == "" ){
		
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#telefono").addClass('error').before('<div class="img_error"></div>');
		$("#telefono").focus();
		return false;
	}
	if( direccion == "" ){
	
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#direccion").addClass('error').before('<div class="img_error"></div>');
		$("#direccion").focus();
		return false;
	}
	if( ciudad == "" ){
		
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#ciudad").addClass('error').before('<div class="img_error"></div>');
		$("#ciudad").focus();
		return false;
	}
	if( pais == "" ){
		
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#pais").addClass('error').before('<div class="img_error"></div>');
		$("#pais").focus();
		return false;
	}
	
	$(".img_error").remove();
	$("#registro-form input").removeClass("error");

	eval('action()');
	
	return false;
}

// function updatePasswordCuenta( form ){
// 	var password_actual = (form.password_actual != undefined)?form.password_actual.value:''; 
// 	var password_nuevo = (form.password_nuevo != undefined)?form.password_nuevo.value:''; 
// 	var password_repeat_nuevo = (form.password_repeat_nuevo != undefined)?form.password_repeat_nuevo.value:''; 
	
// 	if(form.password_actual!= undefined && password_actual == "") {
// 		$(".img_error").remove();
// 		$("form input").removeClass("error");
// 		$("#password_actual").addClass('error').before('<div class="img_error"></div>');
// 		$("#password_actual").focus();
// 		return false;
// 	}
	
// 	if(form.password_nuevo != undefined && password_nuevo == "") {
// 		$(".img_error").remove();
// 		$("form input").removeClass("error");
// 		$("#password_nuevo").addClass('error').before('<div class="img_error"></div>');
// 		$("#password_nuevo").focus();
// 		return false;
// 	}
// 	if(form.password_repeat_nuevo != undefined && password_repeat_nuevo == "") {
// 		$(".img_error").remove();
// 		$("form input").removeClass("error");
// 		$("#password_repeat_nuevo").addClass('error').before('<div class="img_error"></div>');
// 		$("#password_repeat_nuevo").focus();
// 		return false;
// 	}
// 	if( password_nuevo != password_repeat_nuevo ){
// 		$(".img_error").remove();
// 		$("form input").removeClass("error");
// 		$("#password_nuevo").addClass('error').before('<div class="img_error"></div>');
// 		$("#password_repeat_nuevo").addClass('error').before('<div class="img_error"></div>');
// 		$("#password_nuevo").focus();		
// 		return false;
// 	}
	
// 	$(".img_error").remove();
// 	$("form input").removeClass("error");
	
// 	$("#loading_cuenta").show();
// 	$.ajax({
//                 type:"GET",
//                 cache:false,
//                 url:"ajax.php",
//                 data: $("#registro-form").serialize()+'&action=updatePasswordCuenta',
//                 success: function(data) {
//                         if(data=='1'){
//                                 $("#loading_cuenta").hide();
//                                 $("#txtrptacuenta").show();
//                                 setTimeout(function(){
//                                         $("#txtrptacuenta").fadeOut('fast');
//                                 },2000);
//                         }else{
//                                 $("#password_actual").addClass('error').before('<div class="img_error"></div>');
//                                 $("#password_actual").focus();
//                         }
//                 }
// 	});
	
// 	return false;
	
// }

function validate_olvidastePassword(form){
	var email_olvidaste_password = form.email_olvidaste_password.value;
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
	$(".img_error").html('');
	
	if(email_olvidaste_password == "") {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#email_olvidaste_password").addClass('error').before('<div class="img_error"></div>');
		$("#email_olvidaste_password").focus();
		return false;
	}
	if(!email_olvidaste_password.match(emailRegex)) {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#email_olvidaste_password").addClass('error').before('<div class="img_error"></div>');
		$("#email_olvidaste_password").focus();
		return false;
	}
		
	$(".img_error").remove();
	$("#popup_acceso form input").removeClass("error");
	
	$.ajax({
			type:"GET",
			cache:false,
			url:"ajax.php",
			data: $("#olvidaste-password-form").serialize(),
			success: function(data) {
				if(data=='1'){
					$("#popup_acceso form input").val('');
					$('.modal-olvidaste-password').modal('hide');
					$('.modal-redireccionar').modal('show');
					$('.modal-redireccionar .modal-container').html('');
					var contenido = '<div id="franja-top"></div><div id="popup_acceso" class="olvidaste"><h2>¿Olvidaste tu Password?</h2><br/><br/>Se envió email correctamente<br/><br/></div>';
					$('.modal-redireccionar .modal-container').append(contenido);
					setTimeout(function(){
						//var URLactual = window.location;
                      	//window.location.replace(URLactual);
                      	$('.modal-redireccionar').modal('hide');
					},3000)
				}else{
					$("#email_olvidaste_password").addClass('error').before('<div class="img_error"></div>');					
					$("#email_login").focus();
				}
			}
	});
	return false;
}


/* VALIDATE LOGIN POPUP */
function validate_login(form){	
	
	var email_login = form.email_login.value;
	var password_login = form.password_login.value;
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
	$(".img_error").html('');
	

	if(email_login == "") {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#email_login").addClass('error').before('<div class="img_error"></div>');
		$("#email_login").focus();
	
		
		return false;
	}
	if(!email_login.match(emailRegex)) {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#email_login").addClass('error').before('<div class="img_error"></div>');
		$("#email_login").focus();
		
		
		
		return false;
	}	 
	if(password_login == "") {
		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#password_login").addClass('error').before('<div class="img_error"></div>');
		$("#password_login").focus();
		
		
		return false;
	}
	
	$(".img_error").remove();
	$("#popup_acceso form input").removeClass("error");
	
	$.ajax({
			type:"GET",
			cache:false,
			url:"ajax.php?action=acceso",
			data: $('#login-form').serialize(),
			success: function(data) {
				if(data=='1'){
					// cliente registrado pero sin productos en la cesta
					$('.modal-login').modal('hide');
					$('.modal-redireccionar').modal('show');
					$('.modal-redireccionar .modal-container').html('');
					var contenido = '<div id="franja-top"></div><div id="popup_acceso" class="login"><h2>Entrar aquí:</h2><br/><br/>Redirigiendo a su cuenta ...<br/><br/></div>';
					$('.modal-redireccionar .modal-container').append(contenido);
					setTimeout(function(){
						window.location=_url_web_+'seccion/cuenta';
					},3000)
				}else if ( data == '2' ){
					// cliente registrado pero con productos en la cesta
					$("#popup_acceso form input").val('');
					var url = document.URL;	
					$('.modal-login').modal('hide');
					$('.modal-redireccionar').modal('show');
					$('.modal-redireccionar .modal-container').html('');
					var contenido = '<div id="franja-top"></div><div id="popup_acceso" class="login"><h2>Entrar aquí:</h2><br/><br/>Redirigiendo a pedido ...<br/><br/></div>';
					$('.modal-redireccionar .modal-container').append(contenido);
					setTimeout(function(){
						if(url.match(/pedido/))	{	
							document.forms["cesta"].submit();
						}else{
							window.location = _url_web_+'seccion/pedido';
						}
					},3000)			
				}else{
					$("#email_login").addClass('error').before('<div class="img_error"></div>');
					$("#password_login").addClass('error').before('<div class="img_error"></div>');
					$("#email_login").focus();
				}
			}
	});
	return false;
}

function validate_entrega( form ){
	
	var nombre = form.nombre.value;
	var apellidos = form.apellidos.value;	
	var telefono = form.telefono.value;  
	var fecha_hora = form.fecha_hora.value;
	var distrito = form.distrito.value;
	var direccion = form.direccion.value;
	var referencia = form.referencia.value;
	var dedicatoria = form.dedicatoria.value;		
	
	cleanMsgError();
	
	if( nombre == "" ){
		msgError(form.nombre);
		return false;
	}if( apellidos == "" ){
		msgError(form.apellidos);
		return false;
	}if( telefono == "" ){
		msgError(form.telefono);
		return false;
	}if( fecha_hora == "" ){
		msgError(form.fecha_hora);
		return false;
	}if( distrito == "" ){
		msgError(form.distrito);
		return false;
	}if( direccion == "" ){
		msgError(form.direccion);
		return false;
	}if( referencia == "" ){
		msgError(form.referencia);
		return false;
	}if( dedicatoria == "" ){
		msgError(form.dedicatoria);
		return false;
	}
}

function validate_pago( form ){
	
	var comprobante = form.comprobante.value;
	var pago = form.pago;
	
	cleanMsgError();
	
	if ( comprobante == 'Boleta'){
		var nombre = form.nombre.value;
		var direccionb = form.direccionb.value;
		
		 if( nombre == "" ){
			msgError(form.nombre);
			return false;
		}if( direccionb == "" ){
			msgError(form.direccionb);
			return false;
		}		
	}
	if( comprobante == 'Factura' ){
		var razonsocial = form.razonsocial.value;
		var ruc = form.ruc.value;
		var direccionf = form.direccionf.value;
		
		if( razonsocial == "" ){
			msgError(form.razonsocial);
			return false;
		}if( ruc == "" ){
			msgError(form.ruc);
			return false;
		}if( direccionf == "" ){
			msgError(form.direccionf);
			return false;
		}	
	}
	
	var check = false;
	
	for( i = 0 ; i < pago.length ; i++ ){
		if(pago[i].checked == true ){
			check = true;
			break;
		}
	}
	
	if( check ){
		return true;
	}else{
		for( i = 0 ; i < pago.length ; i++ ){
			msgError(pago[i]);
		}
	}
	
	return false;
	
}


function cleanMsgError(){
	$('.img_error').remove();
	$('input , select , textarea').removeClass('error');
}

function msgError(id){	
	$(id).before('<div class="img_error"></div>').addClass('error');
	$(id).focus();
}


function deleteRow(id, num){
	$(".body-cesta").css("opacity","0.3");
	$(".loading").show();
	$.get('operations.php',{param:'delete-row', id:id}, function(data){
		var resumen = data.split("|");
		$(".articles").text((resumen[1] == 1) ? "1 item" : resumen[1]+" items");
		var total = (parseFloat(resumen[2])).toFixed(2)
		$("#cesta_total h3").html("TOTAL: S/. "+total);
		if(resumen[1] == 0){
			$(".bottom-cesta").remove();
			$("#cesta_compras_content").append('<div class="cesta-nothing"><div class="mensaje_vacio">Su cesta se encuentra vacia</div></div><div align="right" class="btncontinuarcesta"></div>');	
			$(".hide_bottom").hide();
			
		}
		if(resumen[0] == 0){
			$(".info").hide();
		}
		$(".loading").hide();	
		$("#"+num).remove();
		$(".body-cesta").css("opacity","10");						   
	});
}

function openPopup(url, w, h, modo, param){
    $("#TB_window").remove();
    $("body").append("<div id='TB_window'></div>");
    tb_show("", url+"?width="+w+"&height="+h+"&modal="+modo+param, "");
}

function checkTheKey(keyCode){
	if(event.keyCode==13){	
		valida();
		return true ;
	}
	return false ;
}

var testresults
function checkemail(value){
	var str = value
	var filter=/^.+@.+\..{2,3}$/
		if (filter.test(str))
		testresults=true
	else{
		testresults=false
	}
	return (testresults)
}




var scrolling = null;
function scroll_up() {
	var d = document.getElementById('scroller');
	d.scrollTop = d.scrollTop - 5;
	scrolling = window.setTimeout(function() {
		scroll_up();
	}, 50);
}
function scroll_down() {
	var d = document.getElementById('scroller');
	d.scrollTop = d.scrollTop + 5;
	scrolling = window.setTimeout(function() {
		scroll_down();
	}, 50);
}
function stop_scroll() {
	window.clearTimeout(scrolling);
}


function next_productos(v){
	var page = parseInt($(".page_prod").text()) + 1;
	
	if(page <= v){
		$("#load_productos").addClass("loading");
		$(".page_prod").text(page);
		$.get("ajax.php",{pag:page, param:'page_prods'},function(data){
			$("#load_productos").html(data).removeClass("loading");
		});
	}
}

function prev_productos(v){
	var page = parseInt($(".page_prod").text()) - 1;
	if(page > 0){
		$("#load_productos").addClass("loading");
		$(".page_prod").text(page); 
		$.get("ajax.php",{pag:page, param:'page_prods'},function(data){
			$("#load_productos").html(data).removeClass("loading");
		});
	}
}


function next_productos_rel(v,idp){

	var page = parseInt($(".page_prod").text()) + 1;
	
	if(page <= v){
		$("#load_productos_relacionados").addClass("loading");
		$(".page_prod").text(page);
		$.get("ajax.php",{pag:page, param:'page_prods_rel', id:idp},function(data){
			$("#load_productos_relacionados").html(data).removeClass("loading");
		});
	}
	
}

function prev_productos_rel(v,idp){
	
	var page = parseInt($(".page_prod").text()) - 1;
	
	if(page > 0){
		$("#load_productos_relacionados").addClass("loading");
		
		$(".page_prod").text(page); 
		$.get("ajax.php",{pag:page, param:'page_prods_rel', id:idp},function(data){
			$("#load_productos_relacionados").html(data).removeClass("loading");
		});
	}

}