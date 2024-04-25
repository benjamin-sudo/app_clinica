$(document).ready(function(){
    //ejemplo tiempo en milisegundos 
    /*
        var inicio          =   Date.now();
        console.log("inicio ->  ",inicio);
        var dias            =   (2*86400000);
        var transcurso      =   inicio + dias; 
        console.log("tiempo en milisegundos ->",transcurso);
        let date            =   new Date(transcurso);
        let day             =   date.getDate();
        let month           =   date.getMonth()+1;
        let year            =   date.getFullYear();
        if(month < 10){
            console.log(`${day}-0${month}-${year}`);
        } else {
            console.log(`${day}-${month}-${year}`);
        }
    */
    var todayDate           =   new Date().getDate();
    $("#date_tabla").datetimepicker({
        format              :   'DD-MM-YYYY',
        //minDate             :   new Date(new Date().setDate((todayDate)-(30))),
        maxDate             :   new Date(),
        locale              :   'es-us',
        icons               :   {
                                    time        :   "fa fa-clock-o"         ,
                                    date        :   "fa fa-calendar"        ,
                                    up          :   "fa fa-chevron-up"      ,
                                    down        :   "fa fa-chevron-down"    ,
                                    previous    :   "fa fa-chevron-left"    ,
                                    next        :   "fa fa-chevron-right"   ,
                                    today       :   "fa fa-screenshot"      ,
                                    clear       :   "fa fa-trash"           ,
                                    close       :   "fa fa-remove"          ,
                                }
    }).on('dp.change',function(e){  update_main(0);  });

    $("#viwes_punto_entrega").selectpicker();
    $("#viwes_origen_solicitud").selectpicker();
    //falta configurar frasco en loalstronge
    //setup_web_print();
    //ws load envio - recepcion
    //load_envio_a_recepcion_ws(0);
});

function test_envio(){
    //console.log("load_confirma_envio_recepcion");
    $("#load_confirma_envio_recepcion").submit();
}

function changeviwes_origen_solicitud(_this){
    update_main(0);
}

function changeviwes_punto_entrega(_this){
    update_main(0);
}

function consulta_(value){
    /*
        console.log("-----------------------------------");
        console.log("value      ->",value,"             ");
        console.log("-----------------------------------");
    */

    $.ajax({ 
        type		:   "POST",
        url		    :   "ssan_spab_gestionlistaquirurgica/consulta_hoja_faph",
        dataType	:   "json",
	    beforeSend  :   function(xhr)   { 
                                            //console.log(xhr);
                                        },
	    data		:                   { 
                                            value :value
                                        },
        error		:   function(errro)	{  
                                            console.log(errro); 
                                            console.log(errro.responseText);
                                            jError("Error del aplicativo","e-SISSAN"); 
                                        },
        success		:   function(aData)	{   
                                            console.log("---------our update_main ------");
                                            console.log("       ->",aData,"<-           ");
                                            console.log("-------------------------------");
                                        }, 
    });
}

function update_main(value){
    $('.popover').popover('hide');
    var IND_TEMPLETE    =   $("#IND_TEMPLETE").val();
    var ind_ruta        =   IND_TEMPLETE    ===     "ssan_libro_biopsias_listaxusuarios"
                                            ?       "ssan_libro_biopsias_listaxusuarios/update_main_ususarios"
                                            :       "ssan_libro_biopsias_listaexterno1/update_main";
    /*
        console.log("------------------------------------------------");
        console.log("ind_ruta                   ->  ",ind_ruta);
        console.log("numFecha                   ->  ",$("#numFecha").val());
        console.log("viwes_punto_entrega        ->  ",$("#viwes_punto_entrega").val() );
        console.log("viwes_origen_solicitud     ->  ",$("#viwes_origen_solicitud").val());
        console.log("-----------------------------------------------");
        console.log("   11.07.2023 -> revision para acreditacion    ");
        console.log("-----------------------------------------------");
    */
    $('#loadFade').modal('show');
    $.ajax({ 
        type		:   "POST",
        url		    :   ind_ruta,
        dataType	:   "json",
	    beforeSend  :   function(xhr)   { 
                                            //console.log(xhr);
                                        },
	    data		:                   { 
                                            fecha_inicio        :   $("#numFecha").val(),
                                            fecha_final         :   $("#numFecha").val(),
                                            OPTION              :   1,
                                            pto_entrega         :   0,
                                            origen_sol          :   0,
                                            ind_template        :   "ssan_libro_biopsias_listaexterno1",
                                        },
        error		:   function(errro)	{  
                                            console.log("errro          ->  ",errro); 
                                            console.log("responseText   ->  ",errro.responseText);
                                            $('#loadFade').modal('hide');
                                            jError("Error en el listado de anatom&iacute;a patol&oacute;gica","e-SISSAN"); 
                                        },
        success		:   function(aData)	{   
                                            console.log("   |   ",ind_ruta);
                                            console.log("   |   ",aData);
                                            $('#loadFade').modal('hide');
                                            $(".LISTA_BODY_1,.LISTA_BODY_2,.NO_INFORMACION,.li_lista_externo_rce").remove();
                                            $("#LI_LISTA_MAIN").append(aData.STATUS_OUT.html_exteno);
                                            $("[data-toggle='tooltip']").tooltip();
                                            console.log("IND_TEMPLETE           ->      ",IND_TEMPLETE);
                                            if(IND_TEMPLETE == "ssan_libro_biopsias_listaexterno1"){
                                                let viwes_punto_entrega = $("#viwes_punto_entrega").val();
                                                if (viwes_punto_entrega != '0'){
                                                    console.log("viwes_punto_entrega    ->  ",viwes_punto_entrega);
                                                    $(".li_lista_externo_rce").hide();
                                                    $(".rotulo_"+viwes_punto_entrega).show();
                                                }
                                            }

                                        }, 
    });
}