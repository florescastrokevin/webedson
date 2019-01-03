$(document).ready(function() {
	//TreeView.init();
	/*handleJqueryFileUpload();*/
	reloadTree();
	$('#btn-new-producto').hide(100);
});
var id_detalle = 0;


function handleJqueryFileUpload(id) {
	clase = "Productos";
	accion = "editProductoTabImagenes";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id},
        complete: function (a) {
        	$('#nav-tab-5').html(a.responseText);
        	/*inicializoeljqueryfileuploader*/
        	$("#fileupload").fileupload({
		        autoUpload: !1,
		        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
		        maxFileSize: 1000000,
		        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
		    }), $("#fileupload").fileupload("option", "COLOR_REDirect", window.location.href.replace(/\/[^\/]*$/, "/cors/result.html?%s")), $("#fileupload").bind("fileuploadadd", function(e, l) {
		        $('#fileupload [data-id="empty"]').hide()
		    }), $("#fileupload").bind("fileuploadfail", function(e, l) {
		        0 === $('.files tr:not([data-id="empty"])').length - l.originalFiles.length && $('#fileupload [data-id="empty"]').show()
		    }), $.support.cors && $.ajax({
		        type: "HEAD"
		    }).fail(function() {
		        $('<div class="alert alert-danger"/>').text("Upload server currently unavailable - " + new Date).appendTo("#fileupload")
		    }), $("#fileupload").addClass("fileupload-processing"), $.ajax({
		        url: $("#fileupload").fileupload("option", "url"),
		        dataType: "json",
		        context: $("#fileupload")[0]
		    }).always(function() {
		        $(this).removeClass("fileupload-processing")
		    }).done(function(e) {
		        $(this).fileupload("option", "done").call(this, $.Event("done"), {
		            result: e
		        })
		    })
		    /*inicializoeljqueryfileuploader*/
        }
    });
    
}
function showDataOfProducto(id) {
	// getCategoriaActual(id);
	getTabDescripcion(id);
	getTabInsumos(id);
	getTabComplementos(id);
	getTabFiltros(id);
	handleJqueryFileUpload(id);
}
function getTabFiltros(id) {
	clase = "Productos";
	accion = "editProductoTabFiltro";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id},
        complete: function (a) {
        	$('#nav-tab-2').html(a.responseText);
        	$(".filtro-principal").select2({
				placeholder: 'Seleccione un Filtro',
				minimumResultsForSearch: 0,
				allowClear: true
			});
			$(".filtro-secundario").select2({
				placeholder: 'Seleccione un Sub Filtro',
				minimumResultsForSearch: 0,
				allowClear: true
			});
			$('.filtro-principal').on('change', function (e) {
				updateProFiltros(1);
			});
			$('.filtro-secundario').on('change', function (e) {
				updateProFiltros(2);
			});
        }
    });
}
function getTabComplementos(id) {
	clase = "Productos";
	accion = "editProductoTabComplementos";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id},
        complete: function (a) {
        	$('#nav-tab-4').html(a.responseText);
        	$(".check-complemento").change(function() {
        		actualizarProductosComplementos();
			}); 
        }
    });
}
function getTabInsumos(id) {
	clase = "Productos";
	accion = "editProductoTabInsumos";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id},
        complete: function (a) {
        	$('#nav-tab-3').html(a.responseText);
        	$('.check-insumo, .cantidad-insumo').change(function(){
        		actualizarProductosInsumos();
        	})
        }
    });
}
function getTabDescripcion(id) {
	clase = "Productos";
	accion = "editProductoTabDescription";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id},
        beforeSend:function (objet) {
        	$('#contenido-producto').closest(".panel").addClass("panel-loading");
        	$('#contenido-producto').prepend('<div class="panel-loader"><span class="spinner-small"></span></div>');
        },
        complete: function (a) {
        	$('#nav-tab-1').html(a.responseText);
        	$('#contenido-producto').closest(".panel").removeClass("panel-loading");
        	$('#contenido-producto').find(".panel-loader").remove();

        	$('input[name="edit_nombre"], input[name="edit_url"], textarea[name="edit_descripcion_corta"], textarea[name="edit_descripcion"], input[name="edit_precio"], input[name="edit_cantidad"], input[name="edit_activo"], input[name="edit_destacado"], input[name="edit_is_complemento"]').change(function() {
        		actualizarDescripcionProducto();
        	})

        }
    });
}

function reloadTree() {
	clase = "Productos";
	accion = "treeProductos";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion},
        complete: function (a) {
            $("#jstree-default").jstree("destroy")
            $('#jstree-default').html(a.responseText)
            $("#jstree-default").jstree( {
		        core: {
		            themes: {
		                responsive: !1
		            }
		        }
		        , types: {
		            "default": {
		                icon: "fa fa-folder text-warning fa-lg"
		            }
		            , file: {
		                icon: "fa fa-file text-inverse fa-lg"
		            }
		        }
		        , plugins:["types"]
		    }
		    ),
		    $("#jstree-default").on("select_node.jstree", function(e, t) {
		        var a=$("#"+t.selected).find("a");
		        return"#"!=a.attr("href")&&"javascript:;"!=a.attr("href")&&""!=a.attr("href")?("_blank"==a.attr("target")&&(a.attr("href").target="_blank"), document.location.href=a.attr("href"), !1): void 0
		    }
		    )	
		    $("#jstree-default").on("select_node.jstree",
			     function(evt, data){
			     	  if (id_detalle===data.node.li_attr.dataproducto) {

			     	  }else{
			     	  	if (data.node.li_attr.dataproducto) {
			     	  		id_detalle = data.node.li_attr.dataproducto;
			          		showDataOfProducto(data.node.li_attr.dataproducto);	
			     	  	}
			     	  }

			     	  if (data.node.li_attr.categoriapadre){
						$('#btn-new-producto').show(100);
						$('input[name="new_id_categoria"]').val(data.node.li_attr.categoriapadre);
			     	  } else {
			     	  	$('#btn-new-producto').hide(100);
			     	  	$('input[name="new_id_categoria"]').val('');
			     	  }
			     }
			);
        }
    });
}
function updateProFiltros(param){
	var array_select1 = $(".filtro-principal").select2("val");
	var array_select2 = $(".filtro-secundario").select2("val");
	var id = $('#id_producto_for_select').val();
	datos1 = JSON.stringify(array_select1);
	datos2 = JSON.stringify(array_select2);

	clase = "Productos";
	accion = "updateProductosFiltros";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id,datos1:datos1,datos2:datos2},
        complete: function (a) {
        },
        success: function(response) {
        	
        }
    });
}

function eliminarProImg(id) {
	clase = "Productos";
	accion = "deleteProductoImagen";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id},
        complete: function (a) {
        },
        success: function(response) {
        	$('.tr'+response).remove();
        	console.log(response);
        }
    });
}

function actualizarProductosComplementos() {
	var seleccionados = [];
	$(".check-complemento").each(function() {
		var ischecked= $(this).is(':checked');
		if(ischecked){
			seleccionados.push($(this).val());
		}
	});
	datos = JSON.stringify(seleccionados);
	var id = $('#id_producto_for_complement').val();
	clase = "Productos";
	accion = "updateProductosComplementos";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id,datos:datos},
        complete: function (a) {
        },
        success: function(response) {
        }
    });
}

function actualizarProductosInsumos() {
	var array_padre = [];
	$('.tr-producto-insumo').each(function() {
		if ($(this).find('.check-insumo').is(':checked')) {
			var array_hijo = []
			array_hijo = [$(this).find('.check-insumo').val(),$(this).find('.cantidad-insumo').val()];
			array_padre.push(array_hijo);
		}
	})
	datos = JSON.stringify(array_padre);
	var id = $('#id_producto_for_insumos').val();
	clase = "Productos";
	accion = "updateProductosInsumos";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id,datos:datos},
        complete: function (a) {
        },
        success: function(response) {
        	console.log(response);
        }
    });
}

function actualizarDescripcionProducto() {
	var id = $('input[name="edit_id"]').val()
	var nombre = $('input[name="edit_nombre"]').val()
	var descripcion_corta = $('textarea[name="edit_descripcion_corta"]').val()
	var descripcion = $('textarea[name="edit_descripcion"]').val()
	var url = $('input[name="edit_url"]').val()
	var precio = $('input[name="edit_precio"]').val()
	var cantidad = $('input[name="edit_cantidad"]').val()
	if ($('input[name="edit_activo"]').is( ":checked" )) {
		var activo = '1';
	}else{ var activo = '0'; }
	if ($('input[name="edit_destacado"]').is( ":checked" )) {
		var destacado = '1';
	}else{ var destacado = '0'; }
	if ($('input[name="edit_is_complemento"]').is( ":checked" )) {
		var is_complemento = '1';
	}else{ var is_complemento = '0'; }
	clase = "Productos";
	accion = "updateProductosDescripcion";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase, action:accion, id:id, nombre:nombre, url:url, descripcion_corta:descripcion_corta, descipcion:descripcion, precio:precio, cantidad:cantidad, activo:activo, destacado:destacado, is_complemento:is_complemento},
        complete: function (a) {
        },
        success: function(response) {
        	console.log(response);
        }
    });

}

function modalNewProducto() {
	$('#modal-new').modal('show');
}

function saveNewProducto() {
	var categoria = $('input[name="new_id_categoria"]').val()
	var nombre = $('input[name="new_nombre"]').val()
	var descripcion_corta = $('textarea[name="new_descripcion_corta"]').val()
	var descripcion = $('textarea[name="new_descripcion"]').val()
	var precio = $('input[name="new_precio"]').val()
	var cantidad = $('input[name="new_cantidad"]').val()
	if ($('input[name="new_activo"]').is( ":checked" )) {
		var activo = '1';
	}else{ var activo = '0'; }
	if ($('input[name="new_destacado"]').is( ":checked" )) {
		var destacado = '1';
	}else{ var destacado = '0'; }
	if ($('input[name="new_is_complemento"]').is( ":checked" )) {
		var is_complemento = '1';
	}else{ var is_complemento = '0'; }
	clase = "Productos";
	accion = "addProductosTree";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase, action:accion, categoria:categoria, nombre:nombre, descripcion_corta:descripcion_corta, descipcion:descripcion, precio:precio, cantidad:cantidad, activo:activo, destacado:destacado, is_complemento:is_complemento},
        complete: function (a) {
        },
        success: function(response) {
        	console.log(response);
        	reloadTree();
        	$('#modal-new').modal('hide');
        }
    });
}