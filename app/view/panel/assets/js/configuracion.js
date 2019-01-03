var handleAjaxConsoleLog=function(a, e) {
    // console.log(a);
    // console.log(e);
    /*var i,
    n=[];
    n.push(a.type.toUpperCase()+' url = "'+a.url+'"');
    for(var t in a.data) {
        if(a.data[t]&&"object"==typeof a.data[t]) {
            i=[];
            for(var o in a.data[t])i.push(o+': "'+a.data[t][o]+'"');
            i="{ "+i.join(", ")+" }"
        }
        else i='"'+a.data[t]+'"';
        n.push(t+" = "+i)
    }
    n.push("RESPONSE: status = "+e.status),
    e.responseText&&($.isArray(e.responseText)?(n.push("["), $.each(e.responseText, function(a, e) {
        n.push("{value: "+e.value+', text: "'+e.text+'"}')
    }
    ), n.push("]")):n.push($.trim(e.responseText))),
    n.push("--------------------------------------\n"),
    $("#console").val(n.join("\n")+$("#console").val())*/
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
    // $.mockjaxSettings.responseTime=500,
    // $.mockjax( {
    //     url:"/post", response:function(a) {
    //         handleAjaxConsoleLog(a, this)
    //     }
    // }
    // )
}

,
handleEditableFieldConstruct=function() {
    $.fn.editable.defaults.mode="inline",
    $.fn.editable.defaults.inputclass="form-control input-sm",
    $.fn.editable.defaults.url="/post",
    $("#id1").editable(),
    $("#id2").editable(),
    $("#id3").editable(),
    $("#id4").editable(),
    $("#id5").editable(),
    $("#id6").editable(),
    $("#id7").editable(),
    $("#id8").editable(),
    $("#id9").editable(),
    $("#id10").editable(),
    $("#id11").editable(),
    $("#id12").editable(),
    $("#id13").editable(),
    $("#id14").editable(),
    $("#id15").editable(),
    $("#id16").editable(),
    $("#id17").editable(),
    $("#id18").editable(),
    $("#id19").editable(),
    $("#id20").editable();
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
                valor = $(this).text();
                clase = $(this).attr('data-clase');
                action = $(this).attr('data-action');
                id = $(this).attr('data-id');
                $.ajax({
                    type: "post",
                    url: ajax_url+"dw-admin/ajax.php",
                    data: {clase:clase,action:action,valor:valor,id:id},
                    complete: function (a) {
                    },
                    success: function(data){
                        console.log(data)
                    },error: function (e) {
                        console.log(e);
                    }
                })
            } 
        });
    });

});