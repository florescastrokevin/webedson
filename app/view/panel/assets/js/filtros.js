$(document).ready(function() {
	//TreeView.init();
	reloadTree();
});
var id_detalle = 0;

function showDataOfFiltro(id) {
	clase = "Filtros";
	accion = "editFiltroData";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,id:id},
        beforeSend:function (objet) {
        	$('#contenedor-editar-filtro').closest(".panel").addClass("panel-loading");
        	$('#contenedor-editar-filtro').prepend('<div class="panel-loader"><span class="spinner-small"></span></div>');
        },
        complete: function (a) {
        	$('#contenedor-editar-filtro').html(a.responseText);
        	$('#contenedor-editar-filtro').closest(".panel").removeClass("panel-loading");
        }
    });
}
function updateFiltro() {

	// if ($('#update_activo').is( ":checked" )) {
	// 	activo = '1';
	// }else{
	// 	activo = '0';
	// }
	id = $('input[name="update_id"]').val();
	nombre = $('input[name="update_nombre"]').val();
	url = $('input[name="update_url"]').val();
	/*descripcion = $('textarea[name="update_descripcion"]').val();*/
	clase = "Filtros";
	accion = "updateFiltroTree";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,nombre:nombre,url:url,id:id},
        beforeSend:function (objet) {
        	$('#contenedor-editar-filtro').closest(".panel").addClass("panel-loading");
        	$('#contenedor-editar-filtro').prepend('<div class="panel-loader"><span class="spinner-small"></span></div>');
        },
        complete: function (a) {
        	$('#contenedor-editar-filtro').closest(".panel").removeClass("panel-loading");
        	$('#contenedor-editar-filtro').find(".panel-loader").remove();
        	reloadTree();
        }
    });
}
function modalNewFiltro(parent) {
	$('input[name="new_parent"]').val(parent);
	$('#modal-new').modal('show');
}
function saveNewFiltro() {
	/*if ($('#new_activo').is( ":checked" )) {
		activo = '1';
	}else{
		activo = '0';
	}*/
	nombre = $('input[name="new_nombre"]').val();
	url = $('input[name="new_url"]').val();
	/*descripcion = $('textarea[name="new_descripcion"]').val();*/
	parent = $('input[name="new_parent"]').val();
	if (nombre=='' || url=="" /*|| descripcion==''*/) {
		return false;
	}
	clase = "Filtros";
	accion = "saveFiltroTree";
	$.ajax({
        type: "post",
        url: ajax_url+"dw-admin/ajax.php",
        data: {clase:clase,action:accion,nombre:nombre,url:url,parent:parent},
        beforeSend:function (objet) {
        },
        complete: function (a) {
        	console.log(a.responseText);
        	reloadTree();
        	$('#modal-new').modal('hide');
        	$('input[name="new_nombre"],input[name="new_url"],input[name="new_parent"]').val('');
        }
    });
}
function reloadTree() {
	clase = "Filtros";
	accion = "treeFiltros";
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
			     	  if (id_detalle===data.node.li_attr.identifica) {

			     	  }else{
			     	  	id_detalle = data.node.li_attr.identifica;
			          	showDataOfFiltro(data.node.li_attr.identifica);
			     	  }
			     }
			);
        }
    });
}