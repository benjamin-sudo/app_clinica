
function js_htraxabilidad(id_anatomia){
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_usuarioext/vista_trazabilidad_sistema",
        dataType : "json",
	    beforeSend : function(xhr) { $('#loadFade').modal('show'); },
	    data : {  id_anatomia : id_anatomia,  },
        error : function(errro)	{  
            $('#loadFade').modal('hide');
            jError("Error en el listado de anatom&iacute;a patol&oacute;ica","Clinica libre"); 
        },
        success : function(aData) {   
            //console.error("return -> ",aData);
            $('#loadFade').modal('hide');
            if (aData.status){
                $("#html_trazabilidad_biopsias").html(aData.html);
                $("#modal_trazabilidad_biopsias").modal("show");
            }
        }, 
    });
}
