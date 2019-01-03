/* JAVASCRIP QUE SE UTILIZA PARA EL CARRITO */
updateCestaAjax( 'listCesta' , null , null , null );
updateBagShopAjax( 'listBagShop' , null , null , null );

function addShopBag(item) {
	var data = $(item).attr("data").split(",");
	var action = data[0];
	var id = data[1];
	var cantidad = data[2];
	if( $('.modal-detalle-carrito:visible').length ){ 
		$('#loader-detalle-carrito').addClass('display');
		$.ajax({
	        type  : "POST",
	        url   : _tpl_+"includes/inc.encarrito.php",
	        data  : {action:action,id:id,cantidad:cantidad},
	      	success: function(data) {
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
	        data  : {action:action,id:id,cantidad:cantidad},
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


function updateCestaAjax( action , id , k , opciones ){
	console.log('actualizando cesta icono');
	$.get('ajax.php',{section:'cesta' , action : action , id:id , cantidad:k , opciones:opciones},function(data){
		$("#carrito .count").html(data);			
	});
}
function updateBagShopAjax( action , id , k , opciones ) {
	console.log('actualizando cesta detalle');
	$.get('ajax.php',{section:'cesta' , action : action , id:id , cantidad:k , opciones:opciones},function(data){
		$("#bag-shop .cuerpo-bag-shop-cal").html(data);			
	});
}

/* JAVASCRIPT QUE SE USA PARA EL CARRITO */
/* JAVASCRIPT QUE SE USA PARA VALIDAR CREDENCIALES (LOGIN) */
function loginNormal() {
	$('.site-backdrop').trigger('click');
	$('.modal-login').modal('show');
	$('.modal-login #entrar_login').attr('onclick','loginDonRegalo(1)');
}

function loginDonRegalo(intencion) {
	var email_login = $('#login-form #email_login').val();
	var password_login = $('#login-form #password_login').val();
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
	
	$.ajax({
		type:"GET",
		cache:false,
		url:"ajax.php?action=acceso&intencion="+intencion,
		data: $('#login-form').serialize(),
		success: function(data) {
			if(data=='1'){
				// cliente registrado pero sin productos en la cesta
				$("#email_login").parent().removeClass('has-danger');
				$("#password_login").parent().removeClass('has-danger');
				$('.modal-login').modal('hide');
				$('.modal-redireccionar').modal('show');
				$('.modal-redireccionar .titulo-header').html('');
				$('.modal-redireccionar .modal-container').html('<br><p>Redirigiendo a su cuenta ...</p><br>');
				var contenido = 'Ingresar aquí: ';
				$('.modal-redireccionar .titulo-header').append(contenido);
				setTimeout(function(){
					location.reload(true);
				},3000)
			}else if (data=='2'){
				$("#email_login").parent().removeClass('has-danger');
				$("#password_login").parent().removeClass('has-danger');
				// cliente registrado pero con productos en la cesta
				$("#popup_acceso form input").val('');
				var url = document.URL;	
				$('.modal-login').modal('hide');
				$('.modal-redireccionar').modal('show');
				$('.modal-redireccionar .titulo-header').html('');
				$('.modal-redireccionar .modal-container').html('<br><p>Redirigiendo a pedido ...</p><br>');
				var contenido = 'Ingresar aquí: ';
				$('.modal-redireccionar .titulo-header').append(contenido);
				setTimeout(function(){
					if(url.match(/pedido/))	{	
						document.forms["cesta"].submit();
					}else{
						window.location = _url_web_+'seccion/pedido';
					}
				},3000)
			}else{
				$("#email_login").parent().addClass('has-danger');
				$("#password_login").parent().addClass('has-danger');
				$("#email_login").focus();
			}		
			
		},beforeSend: function() {
			$('#entrar_login').html('<i class="fas fa-spinner fa-spin"></i>').addClass('login-disable');
		},complete: function () {
			$('#entrar_login').html('INGRESAR').removeClass('login-disable');
		}
	});
	return false;
}
$('#login-form').submit(function(e){
    e.preventDefault();
    //loginDonRegalo();
});
 /* JAVASCRIPT QUE SE USA PARA VALIDAR CREDENCIALES (LOGIN) */

 /*PARA REGISTRAR*/
 $("#registro-form").submit(function(e){
    e.preventDefault();
    alert('validando');
    var action = 'addCuenta';
	var nombres = $("#registro-form #nombres").val();
	var apellidos = $("#registro-form #apellidos").val();
	var email = $("#registro-form #email").val();
		
	var password = $("#registro-form #password").val();
	var repeat_password = $("#registro-form #repeat_password").val();
	
	var telefono = $("#registro-form #telefono").val(); 
	var direccion = $("#registro-form #direccion").val(); 
	var ciudad = $("#registro-form #ciudad").val(); 
	var pais = $("#registro-form #pais").val(); 
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
	if(password != undefined && password == "") {

		$(".img_error").remove();
		$("#popup_acceso form input").removeClass("error");
		$("#password").addClass('error').before('<div class="img_error"></div>');
		$("#password").focus();
		return false;
	}
	if(password != undefined && repeat_password == "") {
		
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

	//eval('action()');
	addCuenta();
	return false;
 });

 function addCuenta(){
	var data = ($('.modal-registrarse:visible').length > 0)?$("form#registro-form").serialize():$("form.registro-rapido-form").serialize();
	$.ajax({
			type:"GET",
			cache:false,
			url:"ajax.php",
			//data: t("#registro-form").serialize()+'&action=addCuenta',
			data: data+'&action=addCuenta',
			success: function(data) {
				if(data=='1'){
					// cliente registrado sin productos en la cesta
					$("#popup_acceso form input").val('');
					$('.modal-registrarse').modal('hide');
					$('.modal-redireccionar').modal('show');
	                $('.modal-redireccionar .modal-container').html('');
	                $('.modal-redireccionar .titulo-header').html('Soy nuevo cliente, regístrate aquí:');
	                var contenido = '<br><p>Redirigiendo a su cuenta ...</p><br>';
	                $('.modal-redireccionar .modal-container').append(contenido);
					setTimeout(function(){
						$("body").animate({opacity:0},500,function(){
							window.location=_url_web_+'seccion/cuenta/edit';
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
 /*PARA REGISTRAR*/

 /*VALIDA SI ESTOY REGISTRADO AL SISTEMA Y DEPENDIENDO DE ESO*/
 /*ME VA DIRIGIR A COMPRAR O ME VA MOSTRAR EL LOGIN */
function realizarCompra() {
	$.ajax({
		type:"GET",
		cache:false,
		url:"ajax.php",
		data: "action=validaSiEstoyLogeado",
		success: function(data) {
			if (data==1) {
				location.href = _url_web_+'seccion/pedido';
			}else if(data==2){
				$('.modal-detalle-carrito').modal('hide');/*si lo hace desde modal comprar*/
				$('.close-bag-shop').trigger('click');/*si lo hace desde carrito izquierda*/
				/*espero un momento antes de mostrar el modal*/
				setTimeout(function(){ 
					$('.modal-login').modal('show');
					$('.modal-login #entrar_login').attr('onclick','loginDonRegalo(2)');
				}, 450);
			}
		},beforeSend: function() {
			$('.realizar-compra-inc-encarrito').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-spinner fa-spin"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').attr("onclick","");
		},complete: function () {
			$('.realizar-compra-inc-encarrito').html('Realiza tu Compra <i class="fas fa-long-arrow-alt-right"></i>').removeClass('login-disable').attr("onclick","realizarCompra()");
		}	
	});
}
  /*VALIDA SI ESTOY REGISTRADO AL SISTEMA Y DEPENDIENDO DE ESO*/
 /*ME VA DIRIGIR A COMPRAR O ME VA MOSTRAR EL LOGIN */

 function ventanaLogin(intencion) {
 	if (intencion==1) {/*si intencion es uno quiere decir que desea pagar por lo tanto se manda a pasarela de compra*/
 		$('.modal-login').modal('show');
 	}else if(intencion==2){/*el ususuario simplemente esta haciendo login por lo tanto se dirige a home*/

 	}
 }


 /*BUSQUEDA*/
$('.activa-busqueda').click(function () {
	
	if ($('form.site-search').hasClass('search-visible')){
        $('form.site-search').removeClass( "search-visible" );
    }else{
        $('form.site-search').addClass( "search-visible" );
    }
})

$('#buscar_donregalo').keypress(function(e) {
	if(e.which == 13) {
		window.location.href = _url_web_+"b/"+$(this).val();
	}
});

$('#buscar_donregalo_movil').keypress(function(e) {
	if(e.which == 13) {
		window.location.href = _url_web_+"b/"+$(this).val();
	}
});