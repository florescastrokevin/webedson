console.log('cargando.. cuentas_fechas_especiales.js');
function addFechaEspecial(id) {
	$('#newFecha').modal('show');
}

function completaFechaEspecial(id_destinatario,nombre_destinatario) {
	$('#completaFechaEspecial .nombre_destinatario').text(nombre_destinatario);
	$('#completaFechaEspecial #asignar-id-destinatario').val(id_destinatario);
	$('#completaFechaEspecial').modal('show');
}


function deleteFecha(id,dom) {
	var action = 'eliminarFechaEspecial';
	swal({
	  title: '¿Seguro?',
	  text: "Se eliminará la fecha especial.",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, elimínalo!'
	}).then((result) => {
	  if (result.value) {
	  	$.ajax({
	        type:"POST",
	        cache:false,
	        url:"ajax.php",
	        data: {action:action,id:id},
	        success: function(data) {
	        	if (data!='') {
	        		console.log(data);
	        	}else{
				    swal({
						type: 'success',
						title: 'Eliminado!',
						text: 'El registro a sido eliminado!',
						showCloseButton: false,
				  		showCancelButton: false,
				  		focusConfirm: false,
				  		showConfirmButton: true,
				  		allowEscapeKey: false,
				  		allowOutsideClick: false
					}).then((result) => {
					  if (result.value) {
					    location.reload(true)
					  }
					})
	        	}
	        }
		});
	    
	  }
	})
}

function addClienteFechaEspecial() {
	
	var nombre = $('#nuevo-nombre-fespecial').val();
	var apellido = $('#nuevo-apellido-fespecial').val();
	var direccion = $('#nuevo-direccion-fespecial').val();
	var referencia = $('#nuevo-referencia-fespecial').val();
	var telefono = $('#nuevo-telefono-fespecial').val();
	var destinatario = $('#nuevo-destinatario-fespecial').val();
	var ocasion = $('#nuevo-ocasion-fespecial').val();
	var fecha = $('#nuevo-fecha-fespecial').val();
	var cliente = $('#nuevo-id-cliente').val();

	$('.form-group input, .form-group textarea, .form-group select').removeClass('form-control-danger');
	$('.form-group input, .form-group textarea, .form-group select').parent().removeClass('has-danger');
	$('.form-group input, .form-group textarea, .form-group select').parent().find('div.form-control-feedback').text('');

	if (nombre=='') {
		$('#nuevo-nombre-fespecial').addClass('form-control-danger');
		$('#nuevo-nombre-fespecial').parent().addClass('has-danger');
		$('#nuevo-nombre-fespecial').parent().find('div.form-control-feedback').text('Ingrese un Nombre válido');
		$('#nuevo-nombre-fespecial').focus();
		return false;
	}
	if (apellido=='') {
		$('#nuevo-apellido-fespecial').addClass('form-control-danger');
		$('#nuevo-apellido-fespecial').parent().addClass('has-danger');
		$('#nuevo-apellido-fespecial').parent().find('div.form-control-feedback').text('Ingrese un Apellido válido');
		$('#nuevo-apellido-fespecial').focus();
		return false;
	}
	if (direccion=='') {
		$('#nuevo-direccion-fespecial').addClass('form-control-danger');
		$('#nuevo-direccion-fespecial').parent().addClass('has-danger');
		$('#nuevo-direccion-fespecial').parent().find('div.form-control-feedback').text('Ingrese una Dirección válida');
		$('#nuevo-direccion-fespecial').focus();
		return false;
	}
	if (referencia=='') {
		$('#nuevo-referencia-fespecial').addClass('form-control-danger');
		$('#nuevo-referencia-fespecial').parent().addClass('has-danger');
		$('#nuevo-referencia-fespecial').parent().find('div.form-control-feedback').text('Ingrese una Referencia válida');
		$('#nuevo-referencia-fespecial').focus();
		return false;
	}
	if (telefono=='') {
		$('#nuevo-telefono-fespecial').addClass('form-control-danger');
		$('#nuevo-telefono-fespecial').parent().addClass('has-danger');
		$('#nuevo-telefono-fespecial').parent().find('div.form-control-feedback').text('Ingrese un número telefónico válido');
		$('#nuevo-telefono-fespecial').focus();
		return false;
	}
	if (destinatario=='') {
		$('#nuevo-destinatario-fespecial').addClass('form-control-danger');
		$('#nuevo-destinatario-fespecial').parent().addClass('has-danger');
		$('#nuevo-destinatario-fespecial').parent().find('div.form-control-feedback').text('Seleccione un Destinatario válido');
		$('#nuevo-destinatario-fespecial').focus();
		return false;
	}
	if (ocasion=='') {
		$('#nuevo-ocasion-fespecial').addClass('form-control-danger');
		$('#nuevo-ocasion-fespecial').parent().addClass('has-danger');
		$('#nuevo-ocasion-fespecial').parent().find('div.form-control-feedback').text('Seleccione una Ocasion válida');
		$('#nuevo-ocasion-fespecial').focus();
		return false;
	}
	if (fecha=='') {
		$('#nuevo-fecha-fespecial').addClass('form-control-danger');
		$('#nuevo-fecha-fespecial').parent().addClass('has-danger');
		$('#nuevo-fecha-fespecial').parent().find('div.form-control-feedback').text('Seleccione una Fecha válida');
		$('#nuevo-fecha-fespecial').focus();
		return false;
	}

	var action = 'addClienteFechaEspecial';
	$.ajax({
        type:"POST",
        cache: false,
        url: "ajax.php",
        data: {action:action, cliente:cliente, nombre:nombre, apellido:apellido, direccion:direccion, referencia:referencia, telefono:telefono, destinatario:destinatario, ocasion:ocasion, fecha:fecha},
        success: function(data) {
            if(data!=''){
                console.log('supuestamente MAL'+data);
            }else{
            	$('#newFecha').modal('hide');
                console.log('supuestamente BIEN'+data);
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
				    location.reload(true)
				  }
				})
            }
        }
	});
	
	return false;
}

function finalizaCompletaFechaEspecial() {
	var tipo = $('#asignar-destinatario').val();
	var ocasion = $('#asignar-ocasion').val();
	var fecha = $('#asignar-fecha').val();
	var destinatario = $('#asignar-id-destinatario').val();


	$('.form-group input, .form-group textarea, .form-group select').removeClass('form-control-danger');
	$('.form-group input, .form-group textarea, .form-group select').parent().removeClass('has-danger');
	$('.form-group input, .form-group textarea, .form-group select').parent().find('div.form-control-feedback').text('');


	if (tipo=='') {
		$('#asignar-destinatario').addClass('form-control-danger');
		$('#asignar-destinatario').parent().addClass('has-danger');
		$('#asignar-destinatario').parent().find('div.form-control-feedback').text('Debe seleccionar una opción');
		$('#asignar-destinatario').focus();
		return false;
	}
	if (ocasion=='') {
		$('#asignar-ocasion').addClass('form-control-danger');
		$('#asignar-ocasion').parent().addClass('has-danger');
		$('#asignar-ocasion').parent().find('div.form-control-feedback').text('Debe seleccionar una opción');
		$('#asignar-ocasion').focus();
		return false;
	}
	if (fecha=='') {
		$('#asignar-fecha').addClass('form-control-danger');
		$('#asignar-fecha').parent().addClass('has-danger');
		$('#asignar-fecha').parent().find('div.form-control-feedback').text('Debe seleccionar una fecha');
		$('#asignar-fecha').focus();
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
                console.log('supuestamente MAL'+data);
            }else{
            	$('#completaFechaEspecial').modal('hide');
                console.log('supuestamente BIEN'+data);
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
				    location.reload(true)
				  }
				})
            }
        }
	});
	
	return false;


}

function verDetalleFechaEspecial(id) {
	var action = 'verDetalleFechaEspecial';
	$.ajax({
        type:"POST",
        cache: false,
        url: "ajax.php",
        data: {action:action, id:id},
        success: function(data) {
        	$('#viewFecha .modal-body').html(data);
        	$('#viewFecha').modal('show');
        }
	});
}