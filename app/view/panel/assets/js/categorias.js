$(document).ready(function() {
	//TreeView.init();
	reloadTree();
});
var id_detalle = 0;

function showDataOfCategoria(id) {
	clase = "Categorias";
	accion = "editCategoriaData";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id},
        beforeSend:function (objet) {
        	$('#contenedor-editar-categoria').closest(".panel").addClass("panel-loading");
        	$('#contenedor-editar-categoria').prepend('<div class="panel-loader"><span class="spinner-small"></span></div>');
        },
        complete: function (a) {
        	$('#contenedor-editar-categoria').html(a.responseText);
        	$('#contenedor-editar-categoria').closest(".panel").removeClass("panel-loading");
        }
    });
}
function updateCategoria() {

	if ($('#update_activo').is( ":checked" )) {
		activo = '1';
	}else{
		activo = '0';
	}
	id = $('input[name="update_id"]').val();
	nombre = $('input[name="update_nombre"]').val();
	titulo = $('input[name="update_titulo"]').val();
	descripcion = $('textarea[name="update_descripcion"]').val();
	url = $('input[name="update_url"]').val();
	clase = "Categorias";
	accion = "updateCategoriaTree";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,nombre:nombre,titulo:titulo,descripcion:descripcion,url:url,activo:activo,id:id},
        beforeSend:function (objet) {
        	$('#contenedor-editar-categoria').closest(".panel").addClass("panel-loading");
        	$('#contenedor-editar-categoria').prepend('<div class="panel-loader"><span class="spinner-small"></span></div>');
        },
        complete: function (a) {
        	$('#contenedor-editar-categoria').closest(".panel").removeClass("panel-loading");
        	$('#contenedor-editar-categoria').find(".panel-loader").remove();
        	reloadTree();
        }
    });
}
function modalNewCategoria(parent) {
	$('input[name="new_parent"]').val(parent);
	$('#modal-new').modal('show');
}
function saveNewCategoria() {
	if ($('#new_activo').is( ":checked" )) {
		activo = '1';
	}else{
		activo = '0';
	}
	nombre = $('input[name="new_nombre"]').val();
	titulo = $('input[name="new_titulo"]').val();
	descripcion = $('textarea[name="new_descripcion"]').val();
	parent = $('input[name="new_parent"]').val();
	if (nombre=='' || titulo=="" || descripcion=='') {
		return false;
	}
	clase = "Categorias";
	accion = "saveCategoriaTree";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,nombre:nombre,titulo:titulo,descripcion:descripcion,activo:activo,parent:parent},
        beforeSend:function (objet) {
        },
        complete: function (a) {
        	console.log(a.responseText);
        	reloadTree();
        	$('#modal-new').modal('hide');
        	$('input[name="new_nombre"],input[name="new_titulo"],textarea[name="new_descripcion"],input[name="new_parent"]').val('');
        }
    });
}
function reloadTree() {
	clase = "Categorias";
	accion = "treeCategorias";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion},
        complete: function (a) {
        	console.log(a)
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
			     	  if (id_detalle===data.node.li_attr.identifica) {

			     	  }else{
			     	  	id_detalle = data.node.li_attr.identifica;
			          	showDataOfCategoria(data.node.li_attr.identifica);
			     	  }
			     }
			);
        }
    });
}