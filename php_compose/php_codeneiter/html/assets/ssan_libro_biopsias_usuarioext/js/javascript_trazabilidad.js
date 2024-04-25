//solo llama del primer nivel
function js_htraxabilidad(id_anatomia){
    $('#loadFade').modal('show');
    $.ajax({ 
        type		:   "POST",
        url		    :   "ssan_libro_biopsias_usuarioext/vista_trazabilidad_sistema",
        dataType	:   "json",
	    beforeSend  :   function(xhr)   { },
	    data		:                   { 
                                            id_anatomia     :   id_anatomia,
                                        },
        error		:   function(errro)	{  
                                            const tiempoUnix            =   Math.floor(Date.now()/1000);
                                            console.log("Time           ->  ",tiempoUnix);
                                            console.log("errro          ->  ",errro); 
                                            console.log("responseText   ->  ",errro.responseText);
                                            $('#loadFade').modal('hide');
                                            jError("Error en el listado de anatom&iacute;a patol&oacute;ica","e-SISSAN"); 
                                        },
        success		:   function(aData)	{   
                                            console.error("return       ->  ",aData);
                                            $('#loadFade').modal('hide');
                                            if (aData.status){
                                                $("#html_trazabilidad_biopsias").html(aData.html);
                                                $("#modal_trazabilidad_biopsias").modal({backdrop:'static',keyboard:false}).modal("show");
                                            }
                                        }, 
    });
}