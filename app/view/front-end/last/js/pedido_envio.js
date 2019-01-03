$("#destinatario_nombre").autocomplete({
     source: "search.php?tipe=destinatario_envio",
     minLength: 2,
     select: function( event, ui ) {
         cargardatosEnvio(ui.item.id, 1);
     }
});
function cargardatosEnvio(datos,id) {
    var listadatos = new Array();
    listadatos = datos.split('+');
    $("#destinatario_nombre").val(listadatos[1]);  
    $("#destinatario_apellidos").val(listadatos[2]);   
    $("#destinatario_telefono").val(listadatos[3]);  
}

function verSugerencias() {
   $('#verSugerencias').modal('show');
}

function fillMensaje(obj) {
   $('#destinatario_dedicatoria').text($(obj).text());
   $('#verSugerencias').modal('hide');
}

function verTarjeta() {
   //$('#destinatario_dedicatoria').text();
   $('#verTarjeta').modal('show');
}

function showMapa(argument) {
  var id_distrito = $("destinatario_distrito").val();

  $('.form-group #destinatario_distrito').removeClass('form-control-danger');
  $('.form-group #destinatario_distrito').parent().removeClass('has-danger');
  $('.form-group #destinatario_distrito').parent().find('div.form-control-feedback').text('');

  if (id_distrito=='') {
    $('#destinatario_distrito').addClass('form-control-danger');
    $('#destinatario_distrito').parent().addClass('has-danger');
    $('#destinatario_distrito').parent().find('div.form-control-feedback').text('Seleccione un distrito');
    $('#destinatario_distrito').focus();
    return false;
  }
  $.ajax({
      type:"GET",
      cache:false,
      url: _url_web_+"ajax.php?action=newUbicacionMapa",
      data:{ id_distrito: id_distrito},
      success: function(data) {
         console.log(data);          
         $(".container-envio-mapa").text('');
         $(".container-envio-mapa").html(data);
      }
   });
   $('.toggle-mapa').attr('onclick','hideMapa()');
   return false;
}

function hideMapa() {
  $(".container-envio-mapa").text('');
  $(".container-envio-mapa").html('');
  $('.toggle-mapa').attr('onclick','showMapa()');
}
/*$(".distritoMapa").change(function(){
 id_distrito = $(this).val();
 $.ajax({
    type:"GET",
    cache:false,
    url: _url_web_+"ajax.php?action=newUbicacionMapa",
    data:{ id_distrito: id_distrito},
    success: function(data) {
       console.log(data);          
       $(".container-envio-mapa").text('');
       $(".container-envio-mapa").html(data);
    }
 });
 return false;
});*/

function validate_entrega(form) {
  var nombre = $('#destinatario_nombre').val();
  var fecha = $('#datepicker').val();
  var hora = $('#destinatario_hora').val();
  var distrito = $('#destinatario_distrito').val();
  var direccion = $('#destinatario_direccion').val();
  $('.form-group input, .form-group textarea, .form-group select').removeClass('form-control-danger');
  $('.form-group input, .form-group textarea, .form-group select').parent().removeClass('has-danger');
  $('.form-group input, .form-group textarea, .form-group select').parent().find('div.form-control-feedback').text('');
  if (nombre=='') {
    $('#destinatario_nombre').addClass('form-control-danger');
    $('#destinatario_nombre').parent().addClass('has-danger');
    $('#destinatario_nombre').parent().find('div.form-control-feedback').text('Ingrese un nombre válido');
    $('#destinatario_nombre').focus();
    return false;
  }
  if (fecha=='') {
    $('#datepicker').addClass('form-control-danger');
    $('#datepicker').parent().addClass('has-danger');
    $('#datepicker').parent().find('div.form-control-feedback').text('Ingrese una fecha válida');
    $('#datepicker').focus();
    return false;
  }
  if (hora=='') {
    $('#destinatario_hora').addClass('form-control-danger');
    $('#destinatario_hora').parent().addClass('has-danger');
    $('#destinatario_hora').parent().find('div.form-control-feedback').text('Ingrese una hora válida');
    $('#destinatario_hora').focus();
    return false;
  }
  if (distrito=='') {
    $('#destinatario_distrito').addClass('form-control-danger');
    $('#destinatario_distrito').parent().addClass('has-danger');
    $('#destinatario_distrito').parent().find('div.form-control-feedback').text('Ingrese una hora válida');
    $('#destinatario_distrito').focus();
    return false;
  }
  if (direccion=='') {
    $('#destinatario_direccion').addClass('form-control-danger');
    $('#destinatario_direccion').parent().addClass('has-danger');
    $('#destinatario_direccion').parent().find('div.form-control-feedback').text('Ingrese una dirección válida');
    $('#destinatario_direccion').focus();
    return false;
  }
  return true;
}