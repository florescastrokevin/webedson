$(document).ready(function(){

    $('#buscar_cliente').autocomplete({  
        minLength: 0,
        source:'ajax.php?action=buscarCliente',
        focus: function( event, ui ) {
            $("#buscar_cliente" ).val(ui.item.nombre); 
            return false;
        },
        select: function (event, ui) {
            $('#buscar_cliente').val(ui.item.nombre); 
            $('#ids_cliente').val(ui.item.id);
            return false;
        } 
    })
    $('#buscar_cliente').autocomplete( "instance" )._renderItem = function( ul, item ) {

            return $( "<li>" )
            .append( "<div>" + item.nombre  + "</div>" )
            .appendTo( ul );
        }; 
});


