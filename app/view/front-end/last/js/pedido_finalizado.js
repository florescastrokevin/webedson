console.log('cargando pedido finalizado...');

function guardarFechaEspecialFinalizado() {
	var cliente = $('#id_cliente').val();/*NO SE NECESITA YA QUE DESTINATARIO ESTA UNIDO AL CLIENTE*/
	var destinatario = $('#id_destinatario').val();
	var fecha = $('#fecha_especial').val();
	var tipo = $('#id_tipo_destinatario').val();
	var ocasion = $('#id_ocasion').val();

	$('.form-group input, .form-group textarea, .form-group select').removeClass('form-control-danger');
	$('.form-group input, .form-group textarea, .form-group select').parent().removeClass('has-danger');
	$('.form-group input, .form-group textarea, .form-group select').parent().find('div.form-control-feedback').text('');

	if (tipo=='') {
		$('#id_tipo_destinatario').addClass('form-control-danger');
		$('#id_tipo_destinatario').parent().addClass('has-danger');
		$('#id_tipo_destinatario').parent().find('div.form-control-feedback').text('Debe seleccionar una opción');
		$('#id_tipo_destinatario').focus();
		return false;
	}
	if (ocasion=='') {
		$('#id_ocasion').addClass('form-control-danger');
		$('#id_ocasion').parent().addClass('has-danger');
		$('#id_ocasion').parent().find('div.form-control-feedback').text('Debe seleccionar una opción');
		$('#id_ocasion').focus();
		return false;
	}

	var action = 'terminaCompletarFechaEspecial';
	$.ajax({
        type:"POST",
        cache: false,
        url: "ajax.php",
        data: {action:action, tipo:tipo, ocasion:ocasion, fecha:fecha, destinatario:destinatario},
        success: function(data) {
            if(data!=''){
                console.log('supuestamente MAL, data: '+data);
            }else{
            	$('#completaFechaEspecial').modal('hide');
                console.log('supuestamente BIEN, data: '+data);
                swal({
					type: 'success',
					title: 'Listo!',
					text: 'Nueva fecha especial registrada!',
					showCloseButton: false,
			  		showCancelButton: false,
			  		focusConfirm: false,
			  		showConfirmButton: true,
			  		allowEscapeKey: false,
			  		allowOutsideClick: false
				}).then((result) => {
				  if (result.value) {
				    location.href = _url_web_+"seccion/cuenta/fechas-especiales";
				  }
				})
            }
        }
	});
	
	return false;
}