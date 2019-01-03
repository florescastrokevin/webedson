// JavaScript Document

var item_producto = 1; 
$(document).ready(function(){
	               
	$("#add-cliente").click(
            function(){

                if($("#nombre_cliente").val() == ""){
                        alert("Ingrese el nombre de cliente");
                        $("#nombre_cliente").focus();
                        return false;
                }
                if($("#apellidos_cliente").val() == ""){
                        alert("Ingrese los apellidos");
                        $("#apellidos_cliente").focus();
                        return false;
                }
                if($("#email_cliente").val() == "" && $("#telefono_cliente").val() == ""){
                        alert("Ingrese e-mail o el teléfono del cliente");
                        $("#email_cliente").focus();
                        return false;
                }
                var padre = $(this).parent("form");
                $.post("procesa_ajax.php",{
                        nombre_cliente:$("#nombre_cliente").val(),
                        apellidos_cliente:$("#apellidos_cliente").val(),
                        email_cliente:$("#email_cliente").val(),
                        password_cliente:$("#password_cliente").val(),
                        telefono_cliente:$("#telefono_cliente").val(),
                        direccion_cliente:$("#direccion_cliente").val(),
                        ciudad_cliente:$("#ciudad_cliente").val(),
                        id_pais:$("#id_pais").val(),
                        observacion_ciente:$("#observacion_cliente").val()                    
                },
                function(data){
                    $(padre).empty().append(" <h2>Se Registró al cliente con éxito. </h2> <br /><br /><br /><br /> <h3>Por favor espere le estamos redirigiendo al formulario...</h3> <br /><br /><br /><br /><br /><br /> <br /><br />[ <a href='#'>Cerrar</a> ]").show("slow");
                    var cliente = $("#nombre_cliente").val()+' '+$("#apellidos_cliente").val();
                    $("#buscar_cliente").val(cliente); 
                    $("#ids_cliente").val(data);
                    $('#ModalAddCliente').modal('hide');
                    //setTimeout(document.location='pedidos.php?action=new',3600);
                        //$(padre).fadeOut("fast");
                        //$("#nombre_rubro").val("");
                });
        });	
        
        $(document).on("click", ".open-modal-insumos", function (){
            $("#listado_insumos").empty();
            $("#listado_insumos").html("<img src='../aplication/webroot/imgs/icons/load.gif'>")
            var id_producto  = $(this).data('id');
            var nombre_producto = $(this).data('nombre');
            $(".modal-body #id_empresa").val( id_producto );
            $(".modal-title").html(nombre_producto);
            $.get("ajax.php",			   	
                { action:'getInsumosPorProducto',id_producto:id_producto},function(data){ 
                    $("#listado_insumos").empty(); 
                    $("#listado_insumos").append(data);
                })
        }); 
        
	// --- SELECT COMBO COMPLEMENTOS --- //
	$("#cmp_productos").change(function(){
		var id  = $("#id_producto").val();
		$this = $(this);
		listAjaxComplementos(  $this.val() , id )		
	})
	
	$(".checksensible li input:checkbox").click(function(e){	
		e.stopPropagation();
	})
		
	$(".checksensible li").click(function(e){
            var check = $(this).find(':checkbox');		
            if(check.is(":checked")){
                check.attr("checked",false);
            }else{
                check.attr("checked",true);
            }
	})
	
	$(".dialog-form").dialog({
		autoOpen: false,
		height: 350,
		width: 450,
		resizable:false,
		buttons: {			
			Guardar: function() {	
				$.post('ajax_atributos.php', 'action=editAtributo&'+$("#popup_editar_atributos").serialize(),function(data){
					$( ".listAttr li[id="+$("#id_atributo").val()+"]" ).fadeOut(300,function(){
						$(this).show().html( data );					
					})
				});
				$( this ).dialog( "close" );
			},
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});	
	
	
	$("#prefijo").change(function(){		
		if ($("#prefijo option:selected").val() ==0){
			$("#prefijo").focus()
		}else{
			$("input[name=precio_valor_atributo]").focus();		
		}		
	})
	
	$("#valor_atributo").change(function(){
		if ($("#valor_atributo option:selected").val() ==0){
			$("#valor_atributo").focus()
		}else{
			$("#prefijo").focus()
		}	
	})
	
	
	$("#insumos_pro" ).autocomplete({
		source: "search.php?tipo=insumos",
		minLength: 1,
		select: function( event, ui ) {
			var ids = ui.item.id;
			var datas = ids.split("-");
			$("#id_insumo").val(datas[0]);
		}
	});
	$("#agregarinsumo").click(function(){
		var nombre = $("#insumos_pro").val();
		var idnombre = $("#id_insumo").val();
		var cantidad = $("#cant_insumo").val();
		if(idnombre==''){
			alert('Error. Verifique los datos ingresados.');
		}
		else{
			$.ajax({
				type:"POST",
				url:"ajax.php?action=addInsumo",
				data:{ id: idnombre, nombrei: nombre, cant: cantidad },
				success: function(result){
					$('#lista_insumos').html(result);
					$("#insumos_pro").val('');
					$("#id_insumo").val('');
					$("#cant_insumo").val(1);
					
					$(".editar_insumo").click(function(){
						var idin = $(this).attr("id");
						$.ajax({
							type:"POST",
							url:"ajax.php?action=editInsumo",
							data:{ id: idin },
							success: function(dato2){
								var bin = dato2.split('::');
								$("#insumos_pro").val(bin[1]);
								$("#id_insumo").val(bin[0]);
								$("#cant_insumo").val(bin[2]);
								$("#id_edit_in").val(bin[3]);
							}
						});
							
					});
					$(".eliminar_insumo").click(function(){
						var idin = $(this).attr("data-id");
						if(confirm("Desea eliminar este insumo?")){
							$.ajax({
								type:"POST",
								url:"ajax.php?action=deleteInsumo",
								data:{ id: idin },
								success: function(result){
									$('#lista_insumos').html(result);
									setTimeout(function(){
										location.reload();
									},500);
								}
							});
						}
					});
				}
			});
		}
	});
	$(".editar_insumo").click(function(){
		var idin = $(this).attr("id");
		$.ajax({
			type:"POST",
			url:"ajax.php?action=editInsumo",
			data:{ id: idin },
			success: function(dato2){
				var bin = dato2.split('::');
				$("#insumos_pro").val(bin[1]);
				$("#id_insumo").val(bin[0]);
				$("#cant_insumo").val(bin[2]);
				$("#id_edit_in").val(bin[3]);
				$("#editarinsumo").show(0);
				$("#agregarinsumo").hide(0);
			}
		});
			
	});
	$("#editarinsumo").click(function(){
		var nombre		= $("#insumos_pro").val();
		var idnombre	= $("#id_insumo").val();
		var cantidad	= $("#cant_insumo").val();
		var idanterior	= $("#id_edit_in").val();
		if(idnombre==''){
			alert('Error. Verifique los datos ingresados.');
		}
		else{
			$.ajax({
				type:"POST",
				url:"ajax.php?action=editInsu",
				data:{ id: idnombre, nombrei: nombre, cant: cantidad, ida: idanterior },
				success: function(result){
					$('#lista_insumos').html(result);
					$("#insumos_pro").val('');
					$("#id_insumo").val('');
					$("#cant_insumo").val(1);
					$("#editarinsumo").hide(0);
					$("#agregarinsumo").show(0);
					$(".editar_insumo").click(function(){
						var idin = $(this).attr("id");
						$.ajax({
							type:"POST",
							url:"ajax.php?action=editInsumo",
							data:{ id: idin },
							success: function(dato2){
								var bin = dato2.split('::');
								$("#insumos_pro").val(bin[1]);
								$("#id_insumo").val(bin[0]);
								$("#cant_insumo").val(bin[2]);
								$("#id_edit_in").val(bin[3]);
							}
						});
							
					});
					$(".eliminar_insumo").click(function(){
						var idin = $(this).attr("data-id");
						if(confirm("Desea eliminar este insumo?")){
							$.ajax({
								type:"POST",
								url:"ajax.php?action=deleteInsumo",
								data:{ id: idin },
								success: function(result){
									$('#lista_insumos').html(result);
									setTimeout(function(){
										location.reload();
									},500);
								}
							});
						}
					});
				}
			})
		}
	});
	$(".eliminar_insumo").click(function(){
		var idin = $(this).attr("data-id");
		if(confirm("Desea eliminar este insumo?")){
			$.ajax({
				type:"POST",
				url:"ajax.php?action=deleteInsumo",
				data:{ id: idin },
				success: function(result){
					$('#lista_insumos').html(result);
					setTimeout(function(){
						location.reload();
					},500);
				}
			});
		}
	});	
	$("#nombre_proveedors").autocomplete({
		source: "search.php?tipo=proveedores",
		minLength: 1,
		select: function( event, ui ) {
			var ids = ui.item.id;
			var datas = ids.split("-");
			$("#id_proveedor").val(datas[0]);
		}
	});
	$("#nombre_tipo_insumo").autocomplete({
		source: "search.php?tipo=tipo_insumo",
		minLength: 1,
		select: function( event, ui ) {
			var ids = ui.item.id;
			var datas = ids.split("-");
			$("#id_tipo_insumo").val(datas[0]);
		}
	});	
	
	$(".del").click(function(){
		$(this).parent().remove();
		if($(".ffiltros li").length==0){$(".buscar_filtro").hide();}
	})
	
	//$( "#saldo_cliente" ).dialog( "open" );
	
	$(".show_prods").click(function(){
		$(".prods[id="+$(this).attr("id")+"]").dialog( "open" );
	})
	
	$(".form_filtro input").keyup(function(e){
		if(e.keyCode==13){
			$(".form_filtro").submit();
		}
	})
		
	$("#resumen").click(function(){
		$('<div id="container_resumen">').dialog({
            modal: false,
            open: function(){
			    $this = $(this);
				$.ajax({
					type:'GET',
					url: 'ajax.php',
					data: $('.select_filtro').serialize()+'&action=resumenPedido',
					beforeSend: function(){						
					  						
						$this.html('<img src="../aplication/webroot/imgs/loading.gif">');
					},
					error: function(xml, status, error) {
						$this.html('<p><strong>Error Code:</strong> '+status+'</p><p><strong>Explanation:</strong> '+error+'</p>');					
					},success: function(data){						
						if($.isArray(data)){
							var html = "<h2>Resúmen de Pedido</h2><ul id=\"resumen\">";
							$.each(data, function(i, item) {
								html+="<li class=\"cantidad\">"+item.total+"</li><li class=\"nombre\">"+item.nombre+"</li>";
							});
							html += "</ul>";
							$this.html(html);
						}else{
							$this.html('<p><strong>Error Code:</strong> '+status+'</p><p><strong>Explanation:</strong>No se encuentran productos</p>');
						}
					},dataType:"json"
				});
            },
            close: function(event, ui) {
                    $(this).remove();
            },
            height: 400,
            width: 300,
            title: 'Resúmen',
			buttons: {
				Cerrar: function() {
					$( this ).dialog( "close" );
				}				
			}
        });

        return false;
	})
		
	$("#filtro").dialog({
		open: function( event, ui ) {
			if($(".ffiltros input[name=pedido]").size()){
				$(".form_filtro input[name=pedido]").val($(".ffiltros input[name=pedido]").val());
			}			
			if($(".ffiltros input[name=estado]").size()){				
				var estado = $(".ffiltros input[name=estado]").val()
				$(".form_filtro select[name=estado]").find("option[value="+estado+"]").attr("selected","selected");
			}
						
			if($(".ffiltros input[name=cliente]").size()){
				$(".form_filtro input[name=cliente]").val($(".ffiltros input[name=cliente]").val());
			}
			
			if($(".ffiltros input[name=distrito]").size()){				
				var distrito = $(".ffiltros input[name=distrito]").val()
				$(".form_filtro select[name=distrito]").find("option[value="+distrito+"]").attr("selected","selected");
			}
			
			if($(".ffiltros input[name=fecha_envio_init]").size()){
				$(".form_filtro input[name=fecha_envio_init]").val($(".ffiltros input[name=fecha_envio_init]").val());
			}
			
			if($(".ffiltros input[name=fecha_envio_fin]").size()){
				$(".form_filtro input[name=fecha_envio_fin]").val($(".ffiltros input[name=fecha_envio_fin]").val())
			}
			
		},
		autoOpen: false,
		height: 400,
		width: 400,
		resizable:false,
		buttons: {
			'Buscar':function(){
				//window.location = 'pedidos.php?'+$(".form_filtro").serialize();
				/*var html = "";
				var $pedido = $(".form_filtro input[name=pedido]");
				var $estado = $(".form_filtro select[name=estado] option:selected");
				var $cliente = $(".form_filtro input[name=cliente]");
				var $distrito = $(".form_filtro select[name=distrito] option:selected");
				var $fechai = $(".form_filtro input[name=fecha_envio_init]");
				var $fechaf = $(".form_filtro input[name=fecha_envio_fin]");
				
				if( $pedido.val() !="" ){
					html +='<ul><li class="head">pedido:</li>';
					html +='<input type="hidden" name="pedido" value="'+$pedido.val()+'">';
					html +='<li class="ellipsis">'+$pedido.val()+'</li></ul>';
				}
				if( $estado.val() !="" ){
					html +='<ul><li class="head">estado:</li>';
					html +='<input type="hidden" name="estado" value="'+$estado.val()+'">';
					html +='<li class="ellipsis">'+$estado.text()+'</li></ul>';
				}
				if( $cliente.val() !="" ){
					html +='<ul><li class="head">cliente:</li>';
					html +='<input type="hidden" name="cliente" value="'+$cliente.val()+'">';
					html +='<li class="ellipsis">'+$cliente.val()+'</li></ul>';
				}
				if( $distrito.val() !="" ){
					html +='<ul><li class="head">distrito:</li>';
					html +='<input type="hidden" name="distrito" value="'+$distrito.val()+'">';
					html +='<li class="ellipsis">'+$distrito.text()+'</li></ul>';
				}
				if( $fechai.val() !="" ){
					html +='<ul><li class="head">fecha Inicio:</li>';
					html +='<input type="hidden" name="fecha_envio_init" value="'+$fechai.val()+'">';
					html +='<li class="ellipsis">'+$fechai.val()+'</li></ul>';
				}
				if( $fechaf.val() !="" ){
					html +='<ul><li class="head">fecha Termino:</li>';
					html +='<input type="hidden" name="fecha_envio_fin" value="'+$fechaf.val()+'">';
					html +='<li class="ellipsis">'+$fechaf.val()+'</li></ul>';
				}
				if (html != ""){
					$("#select_filtro").html('<div class="ffiltros">'+html+'<input type="submit" name="buscar" class="buscar_filtro" value="Buscar"></div>')
					$(".buscar_filtro").show(1,function(){ $( "button, input:submit, input:reset, input:button" ).button(); });
				}
				
				$(".form_filtro").each(function(){
                   this.reset(); 
                });
				$( this ).dialog( "close" );
				*/
				$(".form_filtro").submit();

			},
			Cerrar: function() {
				$( this ).dialog( "close" );
			}				
		}
	})
		
	$(".ui-menu li a").click(function(){
		if ( $(this).text() == "Fecha Compra" || $(this).text() == "Fecha Envío" ){
			$("#q").datepicker({
				dateFormat: 'yy-mm-dd',
			});
		}else{
			$("#q").datepicker("destroy");
			$("#q").val('');
		}
		$("#q").focus();
	})
	
	if( $("#action_filtro option:selected").val() == 'fecha_envio' || $("#action_filtro option:selected").val() == 'fecha_compra' ){
            $("#q").datepicker({
                    dateFormat: 'yy-mm-dd',
            });
	}
	
	$("#q").keyup(function(e){
		//alert(e.keyCode)
	})
    
    $("#radio").buttonset();

    $('.row_h').click('mouseover',function(){
        $(this).attr('bgcolor','#FEF4D8');
    })

    $('.row_h').click('mouseout',function(){
        $(this).attr('bgcolor','#C9C9C9');
    })

    tinymce.init({
        selector: '#descripcion_producto',
        height: 400,
        theme: 'modern',
        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,safari,advlink,imagemanager",
        theme_advanced_buttons1 : "bold,italic,underline,|,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "tablecontrols,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,code,|,forecolor,|,insertimage,image",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        
	theme_advanced_resizing : true
    });
	
    var dates = $('#fechai, #fechaf').datepicker({
        showOn: "button",
        buttonImage: "../aplication/webroot/imgs/icons/calendar.png",
        buttonImageOnly: true,
		maxDate: 0,
        dateFormat: 'dd/mm/yy',
        onSelect: function(selectedDate) {
                var option = this.id == "fechai" ? "minDate" : "maxDate";
                var instance = $(this).data("datepicker");
                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                dates.not(this).datepicker("option", option, date);
        }
    });
	
	$('#fecha').datepicker({		
		 buttonImage: "../aplication/webroot/imgs/calendar.png",
		 buttonImageOnly: true,
		 dateFormat: 'dd/mm/yy'
	});
	$('#txt_hora,.time').timepicker({
		showPeriod: true,
 	    showLeadingZero: true
	});
	$("#btn_filtro").click(function(){	
		$("#filtro").dialog( "open" ).show();	
	})

	var startDateTextBox = $('#fecha_envio_init');
	var endDateTextBox = $('#fecha_envio_fin');
	
	startDateTextBox.datetimepicker({ 
		onClose: function(dateText, inst) {
			if (endDateTextBox.val() != '') {
				var testStartDate = startDateTextBox.datetimepicker('getDate');
				var testEndDate = endDateTextBox.datetimepicker('getDate');
				if (testStartDate > testEndDate)
					endDateTextBox.datetimepicker('setDate', testStartDate);
			}
			else {
				endDateTextBox.val(dateText);
			}
		},
		onSelect: function (selectedDateTime){
			endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
		},
		dateFormat: 'dd/mm/yy'
		,
		timeFormat: "hh:mm tt"	
	});
	endDateTextBox.datetimepicker({ 
		onClose: function(dateText, inst) {
			if (startDateTextBox.val() != '') {
				var testStartDate = startDateTextBox.datetimepicker('getDate');
				var testEndDate = endDateTextBox.datetimepicker('getDate');
				if (testStartDate > testEndDate)
					startDateTextBox.datetimepicker('setDate', testEndDate);
			}
			else {
				//dateText = new Date(2013, 05, 8, 11, 15),
				startDateTextBox.val(dateText);
			}
		},
		onSelect: function (selectedDateTime){
			startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
		},
		dateFormat: 'dd/mm/yy'
		,
		timeFormat: "hh:mm tt"	
	});	
	
	$('.date').datepicker({
		 showOn: "button",
		 buttonImage: "../aplication/webroot/imgs/calendar.png",
		 buttonImageOnly: true,
		 dateFormat: 'yy/mm/dd'
		 });
	
	$(".solo_numero").keyup(function(){
      if ($(this).val() != '')
         $(this).val($(this).attr('value').replace(/[^0-9]/g, ""));
    });
	
	 $('.edit').editable('ajax.php?action=ConfirmarSaldoCliente', {
        indicator : 'Guardando...',
        tooltip   : '',
        callback : function(data) {
            ConfirmarRecarga(data);
        }
    });
	 
	 //$('.edit2').editable('ajax.php?action=ingresarSaldoCliente', {
         //indicator : 'Guardando...',
         //tooltip   : '',
	////	  cancel    : 'Cancel',
        // submit    : 'OK',
     //});
	 
	$("#images a").click( function(){
		
		var descripcion = $(this).attr("rel");
		var title = $(this).attr("title");		
		var id = $(this).attr("rev");		
		
		$("#imgp").hide();
		$("#imgp").attr("src", title).fadeIn('slow'); 
		
		$("#title_img").hide();
		$("#idimg").val(id);
		$("#title_img").val(descripcion).fadeIn('slow'); 
	});	
	 	 
	$("#listadoul").sortable({
	  handle : '.handle',
	  update : function () {
		var action = ($("#listadoul").attr('title')=='')?'ordenarCatProd':$("#listadoul").attr('title');
		var order = $('#listadoul').sortable('serialize');
		pintar();
		$.get("ajax.php?"+order,{action:action},function(data){  });
	  }
	});
	
	$("#sorter_imgs").sortable({
	    update : function () {
			var action = 'ordenarImagenes';
			var order = $('#sorter_imgs').sortable('serialize');
			$.get("ajax.php?"+order,{action:action},function(data){  });
		  }
	})
	
	
	$("#listadoul li") 
	$('.chk_horario').click(function(){

	   if($(this).is(":checked")){
		   $.get('ajax.php',{action:'saveHorarios', id:$(this).val()},function(data){
			   
		});
		   $(this).parent().attr('bgcolor','#8DB9DC');
	   }else{
		  $.get('ajax.php',{action:'deleteHorarios', id:$(this).val()},function(data){});
		  $(this).parent().attr('bgcolor','#C9C9C9');
	   }
		
 })	
	
	
	$('.tooltip').tipsy({gravity: 'n',fade: true});
	
	
	$( "button, input:submit, input:reset, input:button" ).button();
	
	//$( "select:not(.noestile)" ).combobox();
	
	$(".noestile").change(function(){
		
		if ($(".noestile option:selected").val() == 'Entregado'){
		
		var texto = $("textarea[name=comentarios]").val().split('hemos');
		var nombre = texto[0] ;		
		var mensaje = nombre + ' Su pedido ha sido entregado satisfactoriamente. \r\rATENTAMENTE \r----------- \rhttp://www.donregalo.pe \r';
		$("textarea[name=comentarios]").val(mensaje);
		}
	})
	
	$("input:file").filestyle({ 
          image: "../aplication/webroot/imgs/admin/examinar.jpg",
          imageheight : 27,
          imagewidth : 92,
          width : 143
      });
	  
	
	 setInterval(function() {
		 $(".notification").fadeOut(200);
	}, 3000);
	
	
	$(".prods").dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		resizable:false,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$("#info_user").dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		resizable:false,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});	
	
	$("#allcategoriasMove").dialog({
		autoOpen: false,
		height: 500,
		width: 350,
		resizable:false,
		buttons: {
			Mover : function(){
				
				var select = Array();				
				$(".options input:checked").each(function(index, element) {
                    select.push(this.value);
                });
								
				var catescogio = 0;
				catescogio = $("#allcategoriasMove input:checked").val();
				
				if( select.length == 0 ){
					alert("No ha seleccionado un item para mover a la categoria");
					return false;
				}
				
				if( catescogio == undefined ){
					alert("No ha seleccionado la categoria donde se movera el item");
					return false;
				}
				
				$this = $(this);
				
				$.get('ajax.php',{action:'moveItem','item[]':select, id:catescogio},function (data){
					$(".options input:checked").each(function(index,element){
						$(this).parent().parent().fadeOut('fast',function(){ $(this).remove(); })
					});
					$this.dialog( "close" );
				})
				
				
			},
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});	
	
	$("#saldo_cliente").dialog({
		autoOpen: false,
		height: 390,
		width: 370,
		resizable:false,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});	
	
	$("#ver_horario").dialog({
		autoOpen: false,
		height: 770,
		width: 550,
		resizable:false,
		buttons: {
                    Cerrar: function() {
                        $( this ).dialog( "close" );
                    }
		}
	});	 
	
	$('#welcome a').hover(function(){
		$(this).find('img').animate({top:'-5px'},{queue:false,duration:110});
	}, function(){
		$(this).find('img').animate({top:'0px'},{queue:false,duration:110});
	});
	
	$('#fecha_envio,.datetime').datetimepicker({
		dateFormat: 'dd/mm/yy',
		timeFormat: "hh:mm tt"	
	});
	
	$("#print_pedidos").change(function () {
    if ($(this).is(':checked')) {
        //$("input[type=checkbox]").prop('checked', true); //todos los check
        $("input[type=checkbox]").prop('checked', true); //solo los del objeto #diasHabilitados
    } else {
        //$("input[type=checkbox]").prop('checked', false);//todos los check
        $("input[type=checkbox]").prop('checked', false);//solo los del objeto #diasHabilitados
    }
});

 
});

function valida_pedidos(){
 
    var pedido = eval(document.pedidos);
    var id_cliente = pedido.buscar_cliente.value;
    var estado_pedido = pedido.estado_pedido.value;
    var id_metodo_pago = pedido.id_metodo_pago.value;
    var nombre_destinatario = pedido.nombre_destinatario.value;
    var apellidos_destinatario = pedido.apellidos_destinatario.value;
    var fecha_envio_destinatario = pedido.fecha_envio_destinatario.value;
    var direccion_destinatario = pedido.direccion_destinatario.value;
    var id_distrito = pedido.id_distrito.value;
    //alert("hola"+pedido.id_cliente.value);
    if( id_cliente == "" ){ 
            alert("Ingrese el Cliente");
            pedido.id_cliente.focus();
            return false;
    }else if(estado_pedido == " "){ 
            alert("Ingrese el estado de pedido");
            pedido.estado_pedido.focus();
            return false;
    }else if(id_metodo_pago == " "){ 
            alert("Ingrese el metodo de pago");
            pedido.id_metodo_pago.focus();
            return false;
    }else if(nombre_destinatario == ""){ 
            alert("Ingrese el nombre del destinatario");
            pedido.nombre_destinatario.focus();
            return false;
    }else if(apellidos_destinatario == ""){ 
            alert("Ingrese apellidos del destinatario");
            pedido.apellidos_destinatario.focus();
            return false;
    }else if(fecha_envio_destinatario == ""){ 
            alert("Ingrese el fecha de envio del pedido");
            pedido.fecha_envio_destinatario.focus();
            return false;
    }else if(id_distrito == " "){ 
            alert("Ingrese el distrito de destinatario");
            //document.productos.precio_producto.focus();
            return false;
    }else if(direccion_destinatario == " "){ 
            alert("Ingrese la direccion del destinatario");
            pedido.direccion_destinatario.focus();
            return false;
    }else{
        document.pedidos.action="pedidos.php?action=addAdmin";
        document.pedidos.submit();   
    }
}

// --- LIST COMBO COMPLEMENTOS ---//
	function listAjaxComplementos( cat , id ){
		
		$list = $("#list_productos_complementos");
		$list_selected  = $("#complementos_seleccionados");
		
		$.ajax({
				type:'GET',
				url: 'ajax.php',
				data: {cat : cat , id : id ,  action:'listComplementosXProducto'},
				beforeSend: function(){
					$("#load_complemento").html('<img src="../aplication/webroot/imgs/bx_loader.gif">');					
				},
				error: function(xml, status, error) {
					$list.html('<p><strong>Error Code:</strong> '+status+'</p><p><strong>Explanation:</strong> '+error+'</p>');					
				},success: function(data){						
					
					$("#load_complemento").html('');
					
					var data_all = Array();
					var data_selected = Array();
					
					data_all = data['all'];
					data_selected = data['select'];
					
					
					if($.isArray(data_selected)){
						var htmls = "";
						$.each(data_selected, function(i, item) {						
							
							htmls+='<li><b>'+item.nombre+'</b>';
							htmls+='<input type="hidden" name="schk[]" value="'+item.idselect+'">';
							htmls+='<img id="'+item.idselect+'" src="../aplication/webroot/imgs/admin/delete.png" onclick="delete_cmp('+id+','+item.idselect+','+cat+')"></li>';
							
						});
						//htmls+='</ul>';
						$list_selected.html(htmls);
					}else{
						
					}
					
					
					if($.isArray(data_all)){
							
						
						if( data_all.length > 0 ){
						
						var html = "<strong>Productos:</strong><br class=\"clear\"><ul>";
						
							$.each(data_all, function(i, item) {							
								
								var checked = '';
								$.each(data_selected, function(j, item2) {							
									if( item2.idselect == item.id ){
										checked = 'checked = "checked"';
									}
								});
								
								html+="<li><input "+checked+" onclick=\"chk_cmp(this,"+id+","+item.id+" , "+cat+")\" type=\"checkbox\">"+item.nombre+"</li>";
								//html+=((i+1)%5==0)?'</ul><ul>':'';
							});
						
						html +='</ul>';
						
						}else{
							html = "<strong>Productos:</strong><br class=\"clear\"><br/>No Productos disponibles";
						}
						
						$list.html(html);
					}else{
						$list.html('<strong>Productos:</strong><br><br>Seleccione la categoria');
					}
				},dataType:"json"
			})
		
	}

function validate_filtro_ventas( form ){
	var fechai = $("#fechai").val();
	var fechaf = $("#fechaf").val();
	
	if( fechai == "" ){
		$("#fechai").focus();
		return false;
	}
	if( fechaf == "" ){
		$("#fechaf").focus();
		return false;
	}
	
	form.submit();
}
	
function moveProductos(){
	if(!$(".options input:checkbox").is(":checked")){
		alert('Primero debes de seleccionar los categorias a mover');
	}else{
		$( "#allcategoriasMove ul li input" ).attr('checked',false);
		$( "#allcategoriasMove" ).dialog( "open" );
	}
}	

function delete_cmp( idp , id , cat ){
	$.ajax({
		type:'GET',
		url: 'ajax.php',
		data: {idp:idp , id:id , action:'delComplementosXProducto'},
		beforeSend: function(){
					$("#load_complemento").html('<img src="../aplication/webroot/imgs/bx_loader.gif">');					
		},
		error: function(xml, status, error) {
			$list.html('<p><strong>Error Code:</strong> '+status+'</p><p><strong>Explanation:</strong> '+error+'</p>');					
		},success: function(data){						
			if(parseInt(data)==1){
				listAjaxComplementos( cat , idp )
			}else{
				alert('Error: No se pudo borrar complemento');
			}
		}
	})
}

function chk_cmp( chk , idp , id , cat ){
		
		if(chk.checked == 1){
			$.ajax({
				type:'GET',
				url: 'ajax.php',
				beforeSend: function(){
					$("#load_complemento").html('<img src="../aplication/webroot/imgs/bx_loader.gif">');					
				},
				data: {idp:idp , id:id , action:'addComplementosXProducto'},
				error: function(xml, status, error) {
					$list.html('<p><strong>Error Code:</strong> '+status+'</p><p><strong>Explanation:</strong> '+error+'</p>');					
				},success: function(data){						
					if(parseInt(data)==1){
						listAjaxComplementos( cat , idp )
					}else{
						alert('Error: No se pudo añadir complemento');
					}
				}
			})
		}else{
			delete_cmp( idp , id , cat );
		}
		
	}

function pintar(){
		$("#listadoul li").each(function(x) {
			$(this).removeClass("fila1").removeClass("fila2");
			var w = 0;
			if(x%2==0){w = 2;}else{w = 1;}
			$(this).addClass("fila"+w);
		});
	}	

function validate_search(form){
	window.location = 'pedidos.php'+$(".form_filtro").serialize();
}

function grabar_datos_destinatario( id ){
	var nombre = $("#nombre").val();
	var telefono = $("#telefono").val();
	var fecha = $("#fecha").val();
	var hora = $("#txt_hora").val();
	var direccion = $("#direccion_change").val();
	var distrito = $("#distrito_change option:selected").val();
	var referencia = $("#referencia_change").val();
	var dedicatoria = $("#dedicatoria_change").val();
	
	
	$("#proccess").text('Grabando ... ');
	
	$.post('file_datos_destinatario.php?action=pedidoDatos',{id:id,direccion:direccion, distrito:distrito, referencia:referencia,  dedicatoria:dedicatoria,nombre:nombre,telefono:telefono,fecha:fecha,hora:hora} ,function(data){
           
		$("#proccess").text('Grabado!!!');
		setTimeout(function(){
			$("#proccess").text('');
		},1000)
	});		
	
}

function openNav(idNav) {
    document.getElementById(idNav).style.width = "210px";
}

/* Set the width of the side navigation to 0 */
function closeNav(idNav) {
    document.getElementById(idNav).style.width = "0";
}


function addProducto(){
    if($('#id_producto').val() != " "){
        var id_producto = $('#id_producto').val();
        var nombre_producto = $('#id_producto option:selected').text();
        var cantidad_producto = $('#cantidad_producto').val();  
        $('#add_producto').parent().append('<div class="item item_'+item_producto+' form-group"><label># '+item_producto+' </label><input type="hidden" name="id_producto[]" value="'+id_producto+'" ><input type="text" name="nombre_producto[]" value="'+nombre_producto+'" class="form-control" size="59" ><input type="text" name="cantidad_producto[]" value="'+cantidad_producto+'" class="form-control" size="2"><span onClick="javascript:del_prod(\'item_'+item_producto+'\')"> X </span></div>');
        item_producto ++;                
    }else{
            alert("Por favor escoge Producto");                
            $('#id_producto').focus();
            return false;                
    }            
}

function del_prod(classe){
    var clase = "."+classe;
    $(clase).remove();
    item_producto --;   
    
}

function search_cliente(){
	var r = window.prompt('Buscar Cliente - Ingresa (apellido, nombre, email, universidad, especialidad)','');
	if(r != null){
		location.href = 'clientes.php?q='+r;
	}
}

function search_cliente_recarga(){
	var r = window.prompt('Buscar Cliente - Ingresa (Apellido o Nombre)','');
	if(r != null){
		location.href = 'historial_recargas.php?q='+r;
	}
}

function view_user(user){
	$.get('ajax.php',{action:'viewUser', id:user},function(data){
		$( "#info_user" ).html( data );
		$( "#info_user" ).dialog( "open" );
	});
}

function valida_tipo_mensajes(opcion, id){
	var nombre_tipo_mensaje = document.mensajes.nombre_tipo_mensaje;
	if(nombre_tipo_mensaje.value == ""){ 
		alert("Ingrese el titulo");
		nombre_tipo_mensaje.focus();
		return false;
	}
	
	document.mensajes.action="tiposmensaje.php?action="+opcion+"&id="+id;
	document.mensajes.submit();
}

function valida_mensajes(opcion, id){	
	document.mensajes.action="mensajes.php?action="+opcion+"&id="+id;
	document.mensajes.submit();
}


function valida_post(opcion, id){
	var titulo_post = document.post.titulo_post;	
	if(titulo_post.value == ""){ 
		alert("Ingrese el titulo");
		titulo_post.focus();
		return false;
	}
	
	document.post.action="publicaciones.php?action="+opcion+"&id="+id;
	document.post.submit();
}

function valida_productos(opcion, id){
	var nombre = document.productos.nombre;
	
	if(nombre.value == ""){ 
		alert("Ingrese el titulo");
		nombre.focus();
		return false;
	}else if(document.productos.descripcion_corta.value == ""){ 
		alert("Ingrese una descripcion corta");
		document.productos.descripcion_corta.focus();
		return false;
	}else if(document.productos.precio_producto.value == ""){ 
		alert("Ingrese el precio del producto");
		document.productos.precio_producto.focus();
		return false;
	}
	
	document.productos.action="productos.php?action="+opcion+"&id="+id;
	document.productos.submit();
}	

function valida_metodo_pago(opcion, id){
	var nombre = document.metodoPago.nombre_metodo_pago;	
	
	if(nombre.value == ""){ 
		alert("Ingrese el nombre del Metodo de pago");
		nombre.focus();
		return false;
	}
	
	document.metodoPago.action="formas_pago.php?action="+opcion+"&id="+id;
	document.metodoPago.submit();
}


function valida_categorias_blog(opcion, id){
	var nombre = document.categorias_blog.titulo_categoria_blog;
	/*if(nombre.length > 0){
		for(i = 0; i< nombre.length; i++){
			if(nombre[i].value == ""){ 
				alert("Ingrese el nombre de la categoria");
				nombre[i].focus();
				return false;
			}
		}
	}else{*/
		if(nombre.value == ""){ 
			alert("Ingrese el titulo de la categoria");
			nombre.focus();
			return false;
		}
	//}
	
	document.categorias_blog.action="publicaciones.php?actioncat="+opcion+"&id="+id;
	document.categorias_blog.submit();
}

function valida_categorias(opcion, id){
	
	var nombre = document.categorias.nombre_categoria;
	/*if(nombre.length > 0){
		for(i = 0; i< nombre.length; i++){
			if(nombre[i].value == ""){ 
				alert("Ingrese el nombre de la categoria");
				nombre[i].focus();
				return false;
			}
		}
	}else{*/
		if(nombre.value == ""){ 
			alert("Ingrese el nombre de la categoria");
			nombre.focus();
			return false;
		}
	//}
	
	document.categorias.action="productos.php?actioncat="+opcion+"&id="+id;
	document.categorias.submit();
}	

var testresults
function checkemail(value){
	var str = value
	var filter=/^.+@.+\..{2,3}$/
		if (filter.test(str))
		testresults=true
	else{
		alert("Por favor ingrese un e-mail valido...");
		testresults=false
	}
	return (testresults)
}


function mantenimiento(url,id,opcion){
	if(opcion!="delete"){ 
		location.replace(url+'?action='+opcion+'&id='+id);			
	}else if(opcion=="delete"){
		if(!confirm("Esta Seguro que desea Eliminar el Registro")){
			return false;	
		}else{
			location.replace(url+'?action='+opcion+'&id='+id);			
		}		
	}
}

function ConfirmarRecarga(datos){
            $(".edit").html("0.00");
            if(!confirm("Esta seguro de realizar la recarga de S/. "+datos.split('-')[2]+".00")){
                return false;
            }else{

                $.post("ajax.php?action=editarSaldoCliente",{data:datos},function(data){
                    $(".edit2").html();
                    $(".edit2").html(data);
                });
                
            }
}


function mantenimiento_cat(url,id,opcion){
	if(!confirm("Esta Seguro que desea Eliminar el Registro")){
		return false;	
	}else{
		location.replace(url+'?actioncat='+opcion+'&id='+id);			
	}		
}

function mantenimiento_det(url, id1){	
	location.replace(url+'?id1='+id1);			
}


function validar_delete(){
	if(!confirm("Esta Seguro que desea Eliminar el Registro")){
		return false;	
	}else{
		return true;	
	}	
}



function validnum(e) { 
	tecla = (document.all) ? e.keyCode : e.which; 
	//alert(tecla)
    if (tecla == 8 || tecla == 46 || tecla == 0) return true; //Tecla de retroceso (para poder borrar) 
    // dejar la l�nea de patron que se necesite y borrar el resto 
    //patron =/[A-Za-z]/; // Solo acepta letras 
     patron = /[\d]/; // Solo acepta n�meros
    //patron = /\w/; // Acepta n�meros y letras 
    //patron = /\D/; // No acepta n�meros 
    // patron = /[\d.-]/; numeros el punto y el signo -
    te = String.fromCharCode(tecla); 
    return patron.test(te);  
	// uso  onKeyPress="return validnum(event)"
}

function validar_tutoria(){
  if(document.f1.tutores.value==0){
	 alert("Asigne un Tutor");
	 return false;  
  }
  document.f1.submit();
}


function valida_usuarios(action,id){ 					
    if(document.usuarios.id_rol.value==""){
            alert('ERROR: El campo  rol debe llenarse');
            document.usuarios.id_rol.focus(); 
            return false;
    }						

    if(document.usuarios.nombre_usuario.value==""){
            alert('ERROR: El campo nombre usuario debe llenarse');
            document.usuarios.nombre_usuario.focus(); 
            return false;
    }						

    if(document.usuarios.apellidos_usuario.value==""){
            alert('ERROR: El campo apellidos usuario debe llenarse');
            document.usuarios.apellidos_usuario.focus(); 
            return false;
    }						

    if(document.usuarios.email_usuario.value==""){
            alert('ERROR: El campo email usuario debe llenarse');
            document.usuarios.email_usuario.focus(); 
            return false;
    }						

    if(document.usuarios.login_usuario.value==""){
            alert('ERROR: El campo login usuario debe llenarse');
            document.usuarios.login_usuario.focus(); 
            return false;
    }						
    if(action=="add"){					
    if(document.usuarios.password_usuario.value==""){
            alert('ERROR: El campo password usuario debe llenarse');
            document.usuarios.password_usuario.focus(); 
            return false;
    }						
    }
    document.usuarios.action="usuarios.php?action="+action+"&id="+id;
    document.usuarios.submit();
}


function removerDiv(HijoE){
	$("#"+HijoE).fadeOut('slow', function() {$(this).remove();}); 
}

function delete_imagen(opcion){
	var f1 = eval("document.f1");
	$("#msg_delete").hide();
	if(f1.chkimag.length > 0){
		for(var i=0; i < f1.chkimag.length; i++){
			if(f1.chkimag[i].checked == 1){			
				var id = f1.chkimag[i].value;
				$(".imagen" + id).fadeOut('slow');
				$("#msg_delete").load("delete_imagen.php?id="+id+"&opcion="+opcion).fadeIn("slow");
				$("#imgp").fadeOut("slow");
			}
		}
	}else{
		if(f1.chkimag.checked == 1){			
			var id = f1.chkimag.value;
			$(".imagen" + id).fadeOut('slow');
			$("#msg_delete").load("delete_imagen.php?id="+id+"&opcion="+opcion).fadeIn("slow");
			$("#imgp").fadeOut("slow");
		}	
	}	 			
}

function saldo_cliente(id, name){
	$.get('ajax.php',{action:'viewSaldoCliente', id:id},function(data){
		
		$( "#saldo_cliente" ).html( data );
		$( "#saldo_cliente" ).dialog( "open" );
		$( "#saldo_cliente" ).attr( "title", name );
	});
}

function verHorario(id){
	$.get('ajax.php',{action:'viewHorario', id:id},function(data){
		
		$( "#ver_horario" ).html( data );
		$( "#ver_horario" ).dialog( "open" );
		$( "#ver_horario" ).attr( "title", name );
	});
}

function searchPedidos(){
	$.post('ajax.php?action=reportePedidos',{numero:$("#numero").val(), estado:$("#estado").val(), fechai:$("#fechai").val(),  fechaf:$("#fechaf").val()} ,function(data){
           
		$("#listado_pedidos").html(data);
	});		
}

function searchProductos(){
	$.post('ajax.php?action=reporteProductos',{nombre:$("#nombre").val(), categorias:$("#categorias").val(), signo:$("#signo").val(), precio:$("#precio").val()} ,function(data){
		$("#listado_prods").html(data);
	});		
}

function searchTutorias(){
	$.post('ajax.php?action=reporteTutorias',{estado:$("#estado").val(), fechai:$("#fechai").val(),  fechaf:$("#fechaf").val()} ,function(data){
		$("#listado_tutorias").html(data);
	});
}


function cargarProducto(){ 
	//var d1,contenedor; 
	alert("hola");
	contenedor = document.getElementById('listado_prods'); 
	d1 = $("#categorias").val(); 
	ajax = nuevoAjax(); 
	ajax.open("GET", "procesa_categoria.php?edo="+d1+"&id="+$("#id_producto").val(),true); 
	ajax.onreadystatechange=function(){ 
		if (ajax.readyState==4) { 
		   contenedor.innerHTML = ajax.responseText 
		} 
	} 
	ajax.send(null)
} 


function saveRelacion(val){
	$.post('ajax.php?action=saveRelacion',{id:$("#id_producto").val(), id_p:val} ,function(data){
			
	});
}

function guardaValor(id){
	
	/*if($('#'+id).is(":checked")){
		$('#CELDA-'+id).attr('bgcolor','#000000');
	}else{
		$('#CELDA-'+id).attr('bgcolor','#C9C9C9');
	}*/
	
}


//slide right
$(document).ready(function() {
  $('#slide-right').hover(function() {
    $(this).next().slideToggle();
  });

  $('#slide-right').click(function() {
    $(this).next().animate({width: 'toggle'});
  });
  
  $('#slide-right').click(function() {
    var $lefty = $(this).next();
    $lefty.animate({left: parseInt($lefty.css('left'),10) == 0 ? -$lefty.outerWidth() : 0});
  });

  $('#slide-right').click(function() {
    var $marginLefty = $(this).next();
    $marginLefty.animate({marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ? $marginLefty.outerWidth() : 0});
  });
  
  $('#slide-right').click(function() {
    var $some = $(this).next(),
    someWidth = $some.outerWidth(),
    parentWidth = $some.parent().width();
    $some.animate({width: someWidth === parentWidth ? someWidth/2 : parentWidth - (parseInt($some.css('paddingLeft'),10) + parseInt($some.css('paddingRight'),10))});
  });  
  /*
  $('#hora_envio').timepicker({
        showPeriod: true,
        showLeadingZero: true
  });*/
  
  
  
  
  var Sregion = 'es-US';	
	
	switch($("#moneda").val()){
		case '$':
			Sregion = 'es-US'	
		break;
		case 'S/.':
			Sregion = 'es-PE'	
		break;
	}
	
	$(".JQprecio").formatCurrency({region: Sregion,roundToDecimalPlace: -1, eventOnDecimalsEntered: true})
			.focus(function(){
				$(this).formatCurrency({region: Sregion,roundToDecimalPlace: -1, eventOnDecimalsEntered: true})
			})
			.keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 16: break; // Shift
						case 17: break; // Ctrl
						case 18: break; // Alt
						case 27: this.value = ''; break; // Esc: clear entry
						case 35: break; // End
						case 36: break; // Home
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({roundToDecimalPlace: -1, eventOnDecimalsEntered: true, region: Sregion});
					}
				}
			}).bind('decimalsEntered', function(e, cents) {
				if (String(cents).length > 2) {
					$(this).formatCurrency();
				}				
			}).blur(function(e){
				e.stopImmediatePropagation()
				$(this).formatCurrency({region: Sregion ,roundToDecimalPlace:2 });
			}).keydown(function(){				
				if ( event.keyCode == 46 || event.keyCode == 190  || event.keyCode == 110|| event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				// Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				// Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
				  
				 return;
				}
				else {
				// Ensure that it is a number and stop the keypress
					if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault(); 
					}   
				}
			});	
  
  
  
});



 /* productos atributos */
  
  function valida_atributos(){
	if ($("#atributos option:selected").val() ==0){
		alert("Seleccione un atributo")
		$("#atributos").focus();
		return false;
	}if ($("#valor_atributo option:selected").val() ==0){
		alert("Seleccione un valor")
		$("#valor_atributo").focus();
		return false;
	}
	
	switch  ( $("#prefijo option:selected").val() ){
		case  '0' : 
			alert("Seleccione un prefijo")
			$("#prefijo").focus();
			return false;
		break;
	}
			
	$.post('ajax_atributos.php','action=addAtributo&'+$("#asignacion_atributos").serialize(),function(data){	
		 $("#listadoul.listAttr").html(data);
		 
		$('#asignacion_atributos').each (function(){
		  this.reset();
		  $("input[name=precio_valor_atributo]").removeAttr("style").removeAttr("disabled");
		  $(".JQprecio").formatCurrency({region: 'es-PE',roundToDecimalPlace: -1, eventOnDecimalsEntered: true})
		});
		
		
	});
	pintar()
}

function cargarValores(){	
	id = $("#atributos option:selected").val();
	$("#valor_atributo option").remove();
	if ( id == 0){
		$("#valor_atributo").append('<option value="0">Seleccione Valor...</option>');
	}else{
		$.post('ajax_atributos.php',{action:'cargaValores', id_atributo:id},function(data){	
			if ( data!=null ){
				$("#valor_atributo").append('<option value="0">Seleccione Valor...</option>').focus();
				$.each(data, function(key, value) {
				  $("#valor_atributo").append('<option value="'+value.id+'">'+value.nombre+'</option>');
				});
			}else{
				$("#valor_atributo").append('<option value="0">No items</option>');
			}
		},'json');
	}
}

function deleteAtributo( idpav , idpa ){
	$.post('ajax_atributos.php',{action:'deleteAtributo', idpav:idpav , idpa:idpa},function(data){			
		$( ".listAttr li[id="+idpav+"]" ).fadeOut(300,function(){ pintar() });				
	});	
}

function popupAtributo( id ){
	
	producto = $(".listAttr li[id="+id+"]").find(".data.att0").text();
	atributo = $(".listAttr li[id="+id+"]").find(".data.att1").text();
	valor = $(".listAttr li[id="+id+"]").find(".data.att2").text();
	prefijo = $(".listAttr li[id="+id+"]").find(".data.att3").text();
	precio = $(".listAttr li[id="+id+"]").find(".data.att4").text();
	stock = $(".listAttr li[id="+id+"]").find(".data.att5").text();
	
	$("#pop_up_prefijo").val(prefijo);
	$("#pop_up_stock").val(stock);
	$("#pop_up_precio").val(precio);
	$("#nav_pop_up").text( producto +" > "+ atributo)
	$("#id_atributo").val(id);
	$("#producto").val(producto);
	$("#valor").val(valor);
	$("#atributo").val(atributo);
	$(".dialog-form").dialog( "open" );
}

function estadoactivo(){
            //var chk;
            var estado = document.getElementById('estact').checked;

            if(estado) {
                document.getElementById('estact').value = '1';
            } else{ 
                document.getElementById('estact').value = '0'; }

            //var x = document.getElementById('estact').value;
            //alert(x);
}
function increment(e,field) {
    var keynum

    if(window.event) {// IE 
        keynum = e.keyCode
    } else if(e.which) {// Netscape/Firefox/Opera 
        keynum = e.which
    }
    if (keynum == 38) {
        field.value = parseInt(field.value)+ 1;
        //$("#boton_"+id_servicio).prop( "disabled", false );
    } else if (keynum == 40) {
        field.value = parseInt(field.value) - 1;
    }
    return false;
}
