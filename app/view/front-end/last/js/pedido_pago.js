console.log('cargando pedido pago...');
$("#comprobante").change(function () {
  var str = $(this).val();
  if(str=='Boleta'){
  	$("#caja1").show();
	$("#caja2").hide();
  }else if(str=='Factura'){
	 $("#caja2").show();
	 $("#caja1").hide();
  }else{
  	 $("#caja1").hide();
	 $("#caja2").hide();
  }
}).trigger('change');

$('.custom-control-input').click(function () {
	$('.forma-de-pago-card').removeClass('activo-defecto');
	var id = $(this).attr('id');
	$('label[for='+id+']').parent('.forma-de-pago-card ').addClass('activo-defecto');

	var nombre = $('#nombre_met_'+id).val();
	swal({
	  title: '¿Desea continuar?',
	  text: "A seleccionado "+nombre+" como su método de pago",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#2db597',
	  cancelButtonColor: '#e85050',
	  confirmButtonText: 'Si',
	  cancelButtonText: 'Aún no'
	}).then((result) => {
	  if (result.value) {
	    $('#compra2').submit();
	  }
	})
})

function validate_pago(form) {
	var comprobante = $('#comprobante').val();
	var dni = $('#dni').val();
	var nombre = $('#nombre').val();
	var direccionb = $('#direccionb').val();
	var razonsocial = $('#razonsocial').val();
	var ruc = $('#ruc').val();
	var direccionf = $('#direccionf').val();
	var pago = $('input:radio[name=pago]:checked').val();
	var patron = /^\d*$/; 
	$('.form-group input, .form-group textarea, .form-group select').removeClass('form-control-danger');
  	$('.form-group input, .form-group textarea, .form-group select').parent().removeClass('has-danger');
  	$('.form-group input, .form-group textarea, .form-group select').parent().find('div.form-control-feedback').text('');
	if (comprobante == 'Boleta') {
		if (nombre=='') {
			$('#nombre').addClass('form-control-danger');
		    $('#nombre').parent().addClass('has-danger');
		    $('#nombre').parent().find('div.form-control-feedback').text('Ingrese un nombre válido');
		    $('#nombre').focus();
		    return false;
		}
	}else if(comprobante == 'Factura'){
		if (razonsocial=='') {
			$('#razonsocial').addClass('form-control-danger');
		    $('#razonsocial').parent().addClass('has-danger');
		    $('#razonsocial').parent().find('div.form-control-feedback').text('Ingrese una razón social válida');
		    $('#razonsocial').focus();
		    return false;
		}
		if (ruc=='' || ruc.length>11 || !patron.test(ruc) || ruc.length<11) {
			$('#ruc').addClass('form-control-danger');
		    $('#ruc').parent().addClass('has-danger');
		    $('#ruc').parent().find('div.form-control-feedback').text('Ingrese un número ruc válido');
		    $('#ruc').focus();
		    return false;
		}
		if (direccionf=='') {
			$('#direccionf').addClass('form-control-danger');
		    $('#direccionf').parent().addClass('has-danger');
		    $('#direccionf').parent().find('div.form-control-feedback').text('Ingrese una dirección válida');
		    $('#direccionf').focus();
		    return false;
		}
		if (!pago) {
			swal('No olvide seleccionar su forma de pago');
			return false;
		}

	}
	return true;
}