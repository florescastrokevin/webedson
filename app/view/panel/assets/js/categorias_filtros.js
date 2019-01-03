var handleAjaxConsoleLog=function(a, e) {
}

,
handleEditableFormAjaxCall=function() {

    var clase = "Ocasiones";/*porductos*/
    var accion = "listOcasiones";/*editar*/

    $.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion},
        complete: function (a) {
            handleAjaxConsoleLog(a, this)
        }
    })
}

,
handleEditableFieldConstruct=function() {
    $('.table-tr-data .cf-nombre').each(function() {
        $.fn.editable.defaults.mode="inline",
        $.fn.editable.defaults.inputclass="form-control input-sm",
        $.fn.editable.defaults.url="/post",
        $(this).editable();
    });
    $('.table-tr-data .cf-url').each(function() {
        $.fn.editable.defaults.mode="inline",
        $.fn.editable.defaults.inputclass="form-control input-sm",
        $.fn.editable.defaults.url="/post",
        $(this).editable();
    });
    clase = 'CategoriasFiltros';
    action = 'getCategoriasPadre';
    $.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:action},
        complete: function (a) {
        },
        success: function(data){
            valores = JSON.parse(data);
            $('.table-tr-data .cf-categoria').each(function() {
                $.fn.editable.defaults.mode="inline",
                $.fn.editable.defaults.inputclass="form-control input-sm",
                $.fn.editable.defaults.url="/post",
                $(this).editable( {
                    prepend:"not selected", source: valores
                }
                );
            });
        },error: function (e) {
            console.log(e);
        }
    });
    
    clase = 'CategoriasFiltros';
    action = 'getFiltrosHijo';
    $.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:action},
        complete: function (a) {
        },
        success: function(data){
            valores = JSON.parse(data);
            $('.table-tr-data a.cf-filtro').each(function() {
                $.fn.editable.defaults.mode="inline",
                $.fn.editable.defaults.inputclass="form-control input-sm",
                $.fn.editable.defaults.url="/post",
                $(this).editable( {
                    prepend:"not selected", source: valores
                }
                );
            });
        },error: function (e) {
            console.log(e);
        }
    });

}

,
FormEditable=function() {
    "use strict";
    return {
        init:function() {
            handleEditableFieldConstruct(),
            handleEditableFormAjaxCall()
        }
    }
}

();

$(document).ready(function() {
    FormEditable.init();

    $('.table-tr-data a').each(function() {
        $(this).on('hidden', function(e, reason) {
            if(reason === 'save') {

                var padre = $(this).closest('tr');
                var clase = 'CategoriasFiltros';
                var action = 'UpdateCategoriasFiltros';
                var nombre = $(this).closest('tr').find('.cf-nombre').text();
                var categoria = $(this).closest('tr').find('.cf-categoria').text();
                var filtro = $(this).closest('tr').find('.cf-filtro').text();
                var url = $(this).closest('tr').find('.cf-url').text();
                var id = $(this).closest('tr').attr("data-id");
                $.ajax({
                    type: "post",
                    url: ajax_url+"dw-admin/ajax.php",
                    data: {clase:clase,action:action,nombre:nombre,categoria:categoria,filtro:filtro,url:url,id:id},
                    complete: function (a) {
                        console.log('sdfsdf');
                    },
                    success: function(data){
                        console.log('sdfdsfsdf');
                    },
                    error: function (e) {
                        console.log('sdfdsfsdf');
                    }
                })
            } 
        });
    });

});

function showModalNewCategoriaFiltro() {
    $('#modal-new').modal('show');
}
function saveNewCategoriaFiltro() {
    var nombre = $('input[name="new_nombre"]').val();
    var url = $('input[name="new_url"]').val();
    var categoria = $('select[name="new_categoria"] option:selected').val();
    var filtro = $('select[name="new_filtro"] option:selected').val();
    var clase = 'CategoriasFiltros';
    var action = 'addCategoriaFiltro';
    $.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:action,nombre:nombre,categoria:categoria,filtro:filtro,url:url},
        complete: function (a) {
            console.log(a);
        },
        success: function(data){
            console.log(data);
            location.reload(true);
        },
        error: function (e) {
            console.log(e);
        }
    })
}

function deleteRow(id) {
    var clase = "CategoriasFiltros";
    var action = "deleteRow";
    $.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:action,id:id},
        success: function (data) {
            console.log(data)
            location.reload(true);
        }
    })
}