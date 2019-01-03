// JavaScript Document

$(document).ready(function(){
	               

	$(".addproveedor").fancybox({
		maxWidth	: 500,
		maxHeight	: 400,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: true,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		afterShow	: function(){
			$( "button, input:submit, input:reset, input:button" ).button();
			$(".cerrar").click(function(){
				$.fancybox.close();
			});
			$(".guardarproveedor").click(function(){
				var nombreprov = $("#nombre_proveedorpop").val();
				$.ajax({
					type : "POST",
					data:{nombre : nombreprov},
					url:"ajax.php?action=addprov",
					success: function(datos){
						//alert(datos);
						var variable = datos.split('-');
						if(variable[0]=='0'){
							alert("Error, verifique si los datos son correctos");
						}else{
							$("#id_proveedor").val(variable[0])
							$("#nombre_proveedors").val(variable[1]);
							setTimeout(function(){
								$.fancybox.close();
							},500);
						}
					}
				});
			});
			
		}
	});
	$(".addtipoinsumo").fancybox({
		maxWidth	: 500,
		maxHeight	: 400,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: true,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		afterShow	: function(){
			$( "button, input:submit, input:reset, input:button" ).button();
			$(".cerrar").click(function(){
				$.fancybox.close();
			});
			$(".guardartipoinsumo").click(function(){
				var nombretipoinsu = $("#nombre_tipo_insumopop").val();
				$.ajax({
					type : "POST",
					data:{nombre : nombretipoinsu},
					url:"ajax.php?action=addtipoin",
					success: function(datos){
						//alert(datos);
						var variable = datos.split('-');
						if(variable[0]=='0'){
							alert("Error, verifique si los datos son correctos");
						}else{
							$("#id_tipo_insumo").val(variable[0])
							$("#nombre_tipo_insumo").val(variable[1]);
							setTimeout(function(){
								$.fancybox.close();
							},500);
						}
					}
				});
			});
			
		}
	});
	
});