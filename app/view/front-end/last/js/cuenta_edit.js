console.log('cargando cuenta_edit.js...');
function editAcountData() {
	var nombre = $('.form-group #nombre').val();
	var apellidos = $('.form-group #apellidos').val();
	var email = $('.form-group #email').val();
	var phone = $('.form-group #phone').val();
	var direccion = $('.form-group #direccion').val();
	var ciudad = $('.form-group #ciudad').val();
	var pais = $('.form-group #pais').val();
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

	$('.form-group input').removeClass('form-control-danger');
	$('.form-group input').parent().removeClass('has-danger');
	$('.form-group input').parent().find('div.form-control-feedback').text('');

	if(nombre == "") {
		$('.form-group #nombre').addClass('form-control-danger');
		$('.form-group #nombre').parent().addClass('has-danger');
		$('.form-group #nombre').parent().find('div.form-control-feedback').text('Ingrese un Nombre válido');
		$('.form-group #nombre').focus();
		return false;
	}
	if(apellidos == "") {
		$('.form-group #apellidos').addClass('form-control-danger');
		$('.form-group #apellidos').parent().addClass('has-danger');
		$('.form-group #apellidos').parent().find('div.form-control-feedback').text('Ingrese un Apellido válido');
		$('.form-group #apellidos').focus();
		return false;
	}
	// if(email == "") {
	// 	$('.form-group #email').addClass('form-control-danger');
	// 	$('.form-group #email').parent().addClass('has-danger');
	// 	$('.form-group #email').parent().find('div.form-control-feedback').text('Ingrese un Email válido');
	// 	$('.form-group #email').focus();
	// 	return false;
	// }
	// if(!email.match(emailRegex)) {
	// 	$('.form-group #email').addClass('form-control-danger');
	// 	$('.form-group #email').parent().addClass('has-danger');
	// 	$('.form-group #email').parent().find('div.form-control-feedback').text('Ingrese un Email válido');
	// 	$('.form-group #email').focus();
	// 	return false;
	// }
	if(phone == ""){
		$('.form-group #phone').addClass('form-control-danger');
		$('.form-group #phone').parent().addClass('has-danger');
		$('.form-group #phone').parent().find('div.form-control-feedback').text('Ingrese un Teléfono válido');
		$('.form-group #phone').focus();
		return false;
	}
	if(direccion == "" ){
		$('.form-group #direccion').addClass('form-control-danger');
		$('.form-group #direccion').parent().addClass('has-danger');
		$('.form-group #direccion').parent().find('div.form-control-feedback').text('Ingrese una Dirección válida');
		$('.form-group #direccion').focus();
		return false;
	}
	if(ciudad == "" ){
		$('.form-group #ciudad').addClass('form-control-danger');
		$('.form-group #ciudad').parent().addClass('has-danger');
		$('.form-group #ciudad').parent().find('div.form-control-feedback').text('Ingrese una Ciudad válida');
		$('.form-group #ciudad').focus();
		return false;
	}
	if(pais == "" ){
		$('.form-group #pais').addClass('form-control-danger');
		$('.form-group #pais').parent().addClass('has-danger');
		$('.form-group #pais').parent().find('div.form-control-feedback').text('Ingrese un País válido');
		$('.form-group #pais').focus();
		return false;
	}
	var action = 'updateCuenta';
	$.ajax({
        type:"POST",
        cache: false,
        url: "ajax.php",
        data: {action:action,nombre:nombre,apellidos:apellidos,phone:phone,direccion:direccion,ciudad:ciudad,pais:pais},
        success: function(data) {
            if(data!=''){
                console.log('supuestamente MAL'+data);
            }else{
                console.log('supuestamente BIEN'+data);
                swal("Listo!", "Datos editados!", "success");
            }
        }
	});
	
	return false;
}