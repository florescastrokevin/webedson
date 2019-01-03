console.log('cuenta_pedido_edit');
function changePassword() {
	var password_actual = $('.form-group #password_actual').val();
	var password_nuevo = $('.form-group #password_nuevo').val();
	var password_repeat_nuevo = $('.form-group #password_repeat_nuevo').val();

	$('.form-group input').removeClass('form-control-danger');
	$('.form-group input').parent().removeClass('has-danger');
	$('.form-group input').parent().find('div.form-control-feedback').text('');

	if(password_actual == "") {
		$('.form-group #password_actual').addClass('form-control-danger');
		$('.form-group #password_actual').parent().addClass('has-danger');
		$('.form-group #password_actual').parent().find('div.form-control-feedback').text('Ingrese su contraseña actual.');
		$('.form-group #password_actual').focus();
		return false;
	}
	if(password_nuevo == "") {
		$('.form-group #password_nuevo').addClass('form-control-danger');
		$('.form-group #password_nuevo').parent().addClass('has-danger');
		$('.form-group #password_nuevo').parent().find('div.form-control-feedback').text('Ingrese una nueva contraseña');
		$('.form-group #password_nuevo').focus();
		return false;
	}
	if(password_repeat_nuevo == "") {
		$('.form-group #password_repeat_nuevo').addClass('form-control-danger');
		$('.form-group #password_repeat_nuevo').parent().addClass('has-danger');
		$('.form-group #password_repeat_nuevo').parent().find('div.form-control-feedback').text('Repita la nueva contraseña.');
		$('.form-group #password_repeat_nuevo').focus();
		return false;
	}
	if( password_nuevo != password_repeat_nuevo ){
		$('.form-group #password_repeat_nuevo').addClass('form-control-danger');
		$('.form-group #password_repeat_nuevo').parent().addClass('has-danger');
		$('.form-group #password_repeat_nuevo').parent().find('div.form-control-feedback').text('Las contraseñas deben ser iguales.');
		$('.form-group #password_repeat_nuevo').focus();	
		return false;
	}

	var action ='updatePasswordCuenta'
	$.ajax({
        type:"POST",
        cache:false,
        url:"ajax.php",
        data: {action:action,password_actual:password_actual,password_nuevo:password_nuevo,password_repeat_nuevo:password_repeat_nuevo},
        success: function(data) {
        	console.log(data);
            if(data=='1'){
                swal("Listo!", "Contraseña modificada!", "success");
                $('.form-group #password_actual').val('');
            }else{
                swal("Incorrecto!", "Revise su contraseña actual!", "error");
            }
        }
	});
}