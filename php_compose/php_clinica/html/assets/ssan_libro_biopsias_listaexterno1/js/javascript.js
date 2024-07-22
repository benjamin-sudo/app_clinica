$(document).ready(function(){
    var todayDate           =   new Date().getDate();
    $("#date_tabla").datetimepicker({
        format              :   'DD-MM-YYYY',
        //minDate           :   new Date(new Date().setDate((todayDate)-(30))),
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
    }).on('dp.change',function(e){ update_main(0); });
    $("#viwes_punto_entrega").selectpicker();
    $("#viwes_origen_solicitud").selectpicker();
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
                                            jError("Error del aplicativo","CLinica Libre"); 
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
    var ind_ruta        =   IND_TEMPLETE === "ssan_libro_biopsias_listaxusuarios"
                                ?   "ssan_libro_biopsias_listaxusuarios/update_main_ususarios"
                                :   "ssan_libro_biopsias_listaexterno1/update_main";
    /*
        console.log("   ---------------------------------------------------------------------------     ");
        console.log("   ind_ruta                   ->  ",ind_ruta);
        console.log("   numFecha                   ->  ",$("#numFecha").val());
        console.log("   viwes_punto_entrega        ->  ",$("#viwes_punto_entrega").val() );
        console.log("   viwes_origen_solicitud     ->  ",$("#viwes_origen_solicitud").val());
        console.log("   ---------------------------------------------------------------------------     ");
    */
        
    $.ajax({ 
        type		:   "POST",
        url		    :   ind_ruta,
        dataType	:   "json",
	    beforeSend  :   function(xhr)   { 
                                            console.log(" xhr ",xhr);
                                            $('#loadFade').modal('show');
                                        },
	    data		:                   { 
                                            fecha_inicio    :   $("#numFecha").val(),
                                            fecha_final     :   $("#numFecha").val(),
                                            OPTION          :   1,
                                            pto_entrega     :   0,
                                            origen_sol      :   0,
                                            ind_template    :   "ssan_libro_biopsias_listaexterno1",
                                        },
        error		:   function(errro)	{  
                                           $('#loadFade').modal('hide');
                                            console.log("errro   ->  ",errro); 
                                            jError("Error en el listado de anatom&iacute;a patol&oacute;gica","CLinica Libre");
                                        },
        success		:   function(aData)	{   
                                            console.log("   ************************************    ");
                                            console.log("   aData           ->   ",aData,"          ");
                                            console.log("   ind_ruta        ->   ",ind_ruta,"       ");
                                            console.log("   IND_TEMPLETE    ->   ",IND_TEMPLETE,"   ");
                                            console.log("   ************************************    ");
                                            $('#loadFade').modal('hide');
                                            $(".LISTA_BODY_1,.LISTA_BODY_2,.NO_INFORMACION,.li_lista_externo_rce").remove();
                                            $("#LI_LISTA_MAIN").append(aData.STATUS_OUT.html_exteno);
                                            //$("[data-toggle='tooltip']").tooltip();
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