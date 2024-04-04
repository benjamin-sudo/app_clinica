<style>
    .form-control[type="date"]              {
        cursor                              :   pointer;
    }
    
    .grid_ingreso_enfermeria                {
        display                             :   grid;
        grid-template-columns               :   1fr 2fr;
        gap                                 :   8px;
    }
    
    .grid_unoxcuatro                        {
        display                             :   grid;
        grid-template-columns               :   1fr 1fr 2fr 1fr;
        gap                                 :   8px;
    }
    
    .featured-header                        {
        grid-column                         :   1 / span 2;
    }

    .grid_acceso_vascular                   {
        display                             :   grid;
        grid-template-columns               :   110px 1fr 2fr auto 1fr;
        gap                                 :   8px;
        margin-top                          :   8px;
    }

    .grid_diuresis                          {
        display                             :   grid;
        grid-template-columns               :   auto 3fr auto 1fr;
        gap                                 :   8px;
        margin-top                          :   8px;
    }

    .grid_antecenteshermo                   {
        display                             :   grid;
        grid-template-columns               :   70px 1fr 1fr 1fr auto 1fr;
        gap                                 :   8px;
        margin-top                          :   8px;
    }

    .grid_sub_hepatina                      {
        display                             :   grid;
        grid-template-columns               :   auto 1fr auto 1fr;
        gap                                 :   8px;
    }

    .grid_btn_final                         {
        display                             :   grid;
        grid-template-columns               :   1fr auto 1fr;
        gap                                 :   8px;
        margin-top                          :   10px;
    }

    .class_input_error                      {
        border-color                        :   red;
    }
</style>
<div class="card">
    <div class="card-header">
        <b>INGRESO DE ENFERMERIA</b>
        <br>
        <i>Unidad de Hemodi&aacute;lisis</i>
    </div>
    <div class="card-body">
        <div class="grid_ingreso_enfermeria">
            <div class="card-header featured-header" style="margin-top:-15px;">
                <b>1. ANTECEDENTES PERSONALES</b>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Antecedentes Quir&uacute;rgicos
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_antecedente_qx" value="" required="">
            </div>
            <div class="grid_ingreso_enfermeria1">
                Antecedentes Al&eacute;rgicos
            </div>
            <div class="grid_ingreso_enfermeria2">
                <select class="form-select" aria-label="Seleccione ..." id="ingreso_enfe_antenecentealergia" onclick="js_cambio_atencedentes()">
                    <option value="">Seleccione ... </option>
                    <option value="1">Si</option>
                    <option value="2">No</option>
                    <option value="3">No Sabe</option>
                </select>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Alimentos
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_alimento_alergia"  required="" disabled value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Medicamentos
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_medicamento_alergia"  required="" disabled value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Otros
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_otro_alergia"  required="" disabled value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Diagn&oacute;stico de ingreso
            </div>
            <div class="grid_ingreso_enfermeria2">
                <label for="resultadosBusqueda" style="color:#888888;">
                    <i class="bi bi-database"></i>&nbsp;BUSCADOR CIE:10
                </label>
                <input class="form-control" id="resultadosBusqueda" name="resultadosBusqueda">
                <br>
                <ul class="list-group" id="ind_ciediez_selecionados">
                    <li class="list-group-item sin_resultadocie10"><b><i>SIN CIE-10 SELECCIONADOS ...</i></b></li>
                </ul>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Establecimiento al que se deriva en caso de urgencia  
        	</div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_persona_urgencia" value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Grupo sangu&iacute;neo
            </div>
            <div class="grid_ingreso_enfermeria2">
                <select name="cboGrupoSangre" id="cboGrupoSangre" class="form-select">
                    <option value="">SELECCIONE...</option>
                    <option value="NS">NO SABE</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Factor Sangre	
            </div>
            <div class="grid_ingreso_enfermeria2">
                <select name="cboFactorSangre" id="cboFactorSangre" class="form-select">
                    <option value="">SELECCIONE...</option>
                    <option value="NS">NO SABE</option>
                    <option value="1">RH(+)</option>
                    <option value="0">RH(-)</option>
                </select>
            </div>
            <div class="card-header featured-header" style="margin-top:-5px;">
                <b>2. EXAMEN F&Iacute;SICO GENERAL</b>
            </div>
            <div class="featured-header">
                <div class="grid_unoxcuatro">
                    <div class="grid_unoxcuatro1">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Peso</span>
                            <input type="text" class="form-control" placeholder="kg" aria-label="kg" id="num_kilogramos" >
                        </div>
                    </div>
                    <div class="grid_unoxcuatro2">
                        <div class="input-group mb-3">
                            <span class="input-group-text">FC</span>
                            <input type="text" class="form-control" placeholder="mn" aria-label="mn" id="num_frecuenciacardiaca">
                        </div>
                    </div>
                    <div class="grid_unoxcuatro3">
                        <div class="input-group mb-3">
                            <span class="input-group-text">P/A</span>
                            <input type="text" class="form-control" placeholder="D" aria-label="D" id="nun_presiondistolica">
                            <span class="input-group-text">/</span>
                            <input type="text" class="form-control" placeholder="S" aria-label="S" id="num_presionsistolica">
                        </div>
                    </div>
                    <div class="grid_unoxcuatro4">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Talla</span>
                            <input type="text" class="form-control" placeholder="kg" aria-label="kg">
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Movilidad	
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_movilidad" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Nutrici&oacute;n	
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_nutricion" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Grado de conciencia 
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_gradoconciencia" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Estado de la piel
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_estadodelapiel" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Conjuntivas
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_conjuntivas" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Yugulares
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_yugulares" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Extremidades
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_extremidades" required value=""> 
            </div>
        </div>
        <div class="grid_acceso_vascular">
            <div class="grid_acceso_vascular1">Acceso Vascular</div>
            <div class="grid_acceso_vascular2">FAV</div>
            <div class="grid_acceso_vascular3">
                <input type="text" class="form-control" id="txt_fav" name="txt_fav" value="" required="">
            </div>
            <div class="grid_acceso_vascular4">Fecha</div>
            <div class="grid_acceso_vascular5">
                <input type="date" class="form-control" id="fecha_fav" name="fecha_fav" value="" min="<?php echo date("Y-m-d", strtotime("-30 years"));?>" max="<?php echo date("Y-m-d");?>">
            </div>
        </div>
        <div class="grid_acceso_vascular">
            <div class="grid_acceso_vascular1"></div>
            <div class="grid_acceso_vascular2">Gorotex</div>
            <div class="grid_acceso_vascular3">
                <input type="text" class="form-control" id="txt_gorotex" name="txt_gorotex" value="" required="">
            </div>
            <div class="grid_acceso_vascular4">Fecha</div>
            <div class="grid_acceso_vascular5">
                <input type="date" class="form-control" id="fecha_gorotex" name="fecha_gorotex" value="" min="<?php echo date("Y-m-d", strtotime("-30 years"));?>" max="<?php echo date("Y-m-d");?>">
            </div>
        </div>
        <div class="grid_acceso_vascular">
            <div class="grid_acceso_vascular1"></div>
            <div class="grid_acceso_vascular2">Cat&eacute;ter</div>
            <div class="grid_acceso_vascular3">
                <input type="text" class="form-control" id="txt_cateter" name="txt_cateter" value="" required="">
            </div>
            <div class="grid_acceso_vascular4">Fecha</div>
            <div class="grid_acceso_vascular5">
                <input type="date" class="form-control" id="fecha_gorotex" name="fecha_gorotex" value="" min="<?php echo date("Y-m-d", strtotime("-30 years"));?>" max="<?php echo date("Y-m-d");?>">
            </div>
        </div>
        <div class="grid_diuresis">
            <div class="grid_diuresis1">Diuresis</div>
            <div class="grid_diuresis2" style="text-align: -webkit-right;">
                <select class="form-select" name="slc_diuresis" id="slc_diuresis" style="width:115px;">
                    <option value="">...</option>
                    <option value="1">SI</option>
                    <option value="0">NO</option>
                </select>
            </div>
            <div class="grid_diuresis3">Fecha</div>
            <div class="grid_diuresis4">
                <input type="date" class="form-control" id="fecha_diuresis" name="fecha_diuresis" value="" min="<?php echo date("Y-m-d", strtotime("-30 years"));?>" max="<?php echo date("Y-m-d");?>">
            </div>
        </div>
        <div class="grid_acceso_vascular">
            <div class="grid_acceso_vascular1">Ant&iacute;genos</div>
            <div class="grid_acceso_vascular2">HVC</div>
            <div class="grid_acceso_vascular3">
                <input type="text" class="form-control" id="txt_hvc" name="txt_hvc" value="" required="">
            </div>
            <div class="grid_acceso_vascular4">Fecha</div>
            <div class="grid_acceso_vascular5">
                <input type="date" class="form-control" id="fecha_fav" name="fecha_fav" value="" min="<?php echo date("Y-m-d", strtotime("-30 years"));?>" max="<?php echo date("Y-m-d");?>">
            </div>
        </div>
        <div class="grid_acceso_vascular">
            <div class="grid_acceso_vascular1">&nbsp;</div>
            <div class="grid_acceso_vascular2">HIV</div>
            <div class="grid_acceso_vascular3">
                <input type="text" class="form-control" id="txt_hiv" name="txt_hiv" value="" required="">
            </div>
            <div class="grid_acceso_vascular4">Fecha</div>
            <div class="grid_acceso_vascular5">
                <input type="date" class="form-control" id="fecha_hiv" name="fecha_hiv" value="" min="<?php echo date("Y-m-d", strtotime("-30 years"));?>" max="<?php echo date("Y-m-d");?>">
            </div>
        </div>
        <div class="grid_acceso_vascular">
            <div class="grid_acceso_vascular1">&nbsp;</div>
            <div class="grid_acceso_vascular2">HBSAG</div>
            <div class="grid_acceso_vascular3">
                <input type="text" class="form-control" id="txt_hbsag" name="txt_hbsag" value="" required="">
            </div>
            <div class="grid_acceso_vascular4">Fecha</div>
            <div class="grid_acceso_vascular5">
                <input type="date" class="form-control" id="fecha_hbsag" name="fecha_hbsag" value="" min="<?php echo date("Y-m-d", strtotime("-30 years"));?>" max="<?php echo date("Y-m-d");?>">
            </div>
        </div>
        <div class="card-header featured-header" style="margin-top:-5px;">
            <b>3. ANTECEDENTES HEMODI&Aacute;ISIS</b>
        </div>
        <div class="grid_antecenteshermo">
            <div class="grid_antecenteshermo1">QB</div>
            <div class="grid_antecenteshermo2">
                <input type="text" class="form-control" id="txt_antecenteshermo_qb" required="" value="">
            </div>
            <div class="grid_antecenteshermo3">Heparina</div>
            <div class="grid_antecenteshermo4">
                <div class="grid_sub_hepatina">
                    <div class="grid_sub_hepatina1">I</div>
                    <div class="grid_sub_hepatina1">
                        <input type="text" value="" class="form-control" required="" id="txt_hepatina_i">
                    </div>
                    <div class="grid_sub_hepatina1">M</div>
                    <div class="grid_sub_hepatina1">
                        <input type="text" value="" class="form-control" required="" id="txt_hepatina_m" >
                    </div>
                </div>
            </div>
            <div class="grid_antecenteshermo5">1&deg; Dosis HVB</div>
            <div class="grid_antecenteshermo6">
                <input type="text" class="form-control" id="txt_dosisi_hvb" required="" value="">
            </div>
        </div>
        <div class="grid_antecenteshermo">
            <div class="grid_antecenteshermo1">QD</div>
            <div class="grid_antecenteshermo2">
                <input type="text" class="form-control" id="txt_antecenteshermo_qd" required="" value="">
            </div>
            <div class="grid_antecenteshermo3">Ba&ntilde;o K+/Na</div>
            <div class="grid_antecenteshermo4">
                <input type="text" class="form-control" id="txt_bano_kna" required="" value="">
            </div>
            <div class="grid_antecenteshermo5">2&deg; Dosis HVB</div>
            <div class="grid_antecenteshermo6">
                <input type="text" class="form-control" id="txt_2da_dosis_hvb" required="" value="">
            </div>
        </div>
        <div class="grid_antecenteshermo">
            <div class="grid_antecenteshermo1">Peso seco</div>
            <div class="grid_antecenteshermo2">
                <input type="text" class="form-control" id="txt_antecenteshermo_pesoseco" required="" value="">
            </div>
            <div class="grid_antecenteshermo3">Concentrado</div>
            <div class="grid_antecenteshermo4">
                <input type="text" class="form-control" id="txt_antecenteshermo_concentrado" required="" value="">
            </div>
            <div class="grid_antecenteshermo5">2&deg; Dosis HVB</div>
            <div class="grid_antecenteshermo6">
                <input type="text" class="form-control" id="txt_3da_dosis_hvb" required="" value="">
            </div>
        </div>
        <div class="grid_antecenteshermo">
            <div class="grid_antecenteshermo1">&nbsp;</div>
            <div class="grid_antecenteshermo2">&nbsp;</div>
            <div class="grid_antecenteshermo3">&nbsp;</div>
            <div class="grid_antecenteshermo4">&nbsp;</div>
            <div class="grid_antecenteshermo5">1&deg; refuerzo HVB</div>
            <div class="grid_antecenteshermo6">
                <input type="text" class="form-control" id="txt_dosis_refuerzo_hvb" required="" value="">
            </div>
        </div>
        <div class="card-header featured-header" style="margin-top:-5px;">
            <b>4. OBSERVACIONES</b>
        </div>
        <textarea class="form-control" id="txt_observaciones_finales" name="txt_observaciones_finales" required="" rows="3" style="margin-top: 10px;"></textarea>
        <div class="grid_btn_final">
            <div class="grid_btn_final1">&nbsp;</div>
            <div class="grid_btn_final2">
                <button type="text" class="btn btn-success" onclick="js_guarda_ingreso()"><i class="bi bi-floppy2-fill"></i>&nbsp;INGRESO PROGRAMA HEMODI&Aacute;ISIS</button>
            </div>
            <div class="grid_btn_final3">&nbsp;</div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
    let timer;
    $("#resultadosBusqueda").autocomplete({
        source      :   [], // Fuente inicial vacía
        autoFocus   :   true,
        select      :   function(event,ui)  {
                                                console.log("ui.item        :   ",ui.item);
                                                $(".sin_resultadocie10").remove();
                                                $("#resultadosBusqueda").val('');
                                                let html_li = add_li_diagnostico(ui.item);
                                                $("#ind_ciediez_selecionados").html(html_li);
                                            },
        minLength   :   3,
    }).autocomplete("instance")._renderItem = function(ul,item){
        var term    =   this.term.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
        var re      =   new RegExp("(" + term + ")", "gi");
        var t       =   item.label.replace(re, "<b>$1</b>");
        return $("<li>").append("<div>" + t + "</div>").appendTo(ul);
    };
    $('#resultadosBusqueda').on('keyup', function(e) {
        let valorInput  = $(this).val().trim();
        if (valorInput.length >= 3) {
            realizarBusqueda(valorInput);
        } else {
            $("#resultadosBusqueda").autocomplete("option", "source", []);
        }
    });
});

function add_li_diagnostico(_value){
    console.log("***********************************");
    console.log("_value -> ",_value);
    var nuevaTarjeta    =   `<li class="list-group-item item_`+_value.value+`">
                                <div clas="grid_cieselecionados">
                                    <div clas="grid_cieselecionados1">`+_value.value+`</div>
                                    <div clas="grid_cieselecionados2">`+_value.label+`</div>
                                    <div clas="grid_cieselecionados3">
                                        <button type="button" class="btn btn-danger btn_small" id="item_`+_value.value+`" onclick="js_deletecie(this.id)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>`;


                            
    return nuevaTarjeta;
}

function js_deletecie(_id){
    console.log("delete -> ",_id);
}

function realizarBusqueda(query) {
    console.log("   ------------------------");
    console.log("       query  ->  ", query,"  ");
    console.log("   ------------------------");
    $.ajax({
        type        :   "POST",
        url         :   "ssan_hdial_ingresoegresopaciente/busqueda_informacion_cie10",
        dataType    :   "json",
        data        :   { query: query },
        error       :   function(error) {
                                            console.log(error);
                                            jAlert("Comuniquese con el administrador", "CLINICA LIBRE CHILE");
                                            $('#resultadosBusqueda').prop('disabled', false);
                                        },
        success     :   function(aData) {
                                            console.log("busqueda_informacion_cie10 ->", aData);
                                            if (aData.status && aData.resultados.length > 0) {
                                                let datosAutocomplete = aData.resultados.map(function(item) {
                                                    return {
                                                        label: item.CODIGO_DG_BASE + ' : ' + item.DESCRIPCION,
                                                        value: item.CODIGO_DG_BASE
                                                    };
                                                });
                                                $("#resultadosBusqueda").autocomplete("option", "source", datosAutocomplete);
                                                $("#resultadosBusqueda").autocomplete("search", $("#resultadosBusqueda").val().trim());
                                            } else {
                                                $("#resultadosBusqueda").autocomplete("option", "source", []);
                                            }
                                        },
    });
}

function clearTimeout(){
    setTimeout(function() {
        //console.log("Este mensaje se muestra después de 2 segundos");
    }, 300);
}

var idsDeElementos = [
    'cboFactorSangre',
    'cboGrupoSangre',
    'fecha_diuresis',
    'fecha_fav',
    'fecha_gorotex',
    'fecha_hbsag',
    'fecha_hiv',
    'ingreso_enfe_antenecentealergia',
    'num_frecuenciacardiaca',
    'num_kilogramos',
    'num_presionsistolica',
    'nun_presiondistolica',
    'slc_diuresis',
    'txt_2da_dosis_hvb',
    'txt_3da_dosis_hvb',
    'txt_alimento_alergia',
    'txt_antecedente_qx',
    'txt_antecenteshermo_concentrado',
    'txt_antecenteshermo_pesoseco',
    'txt_antecenteshermo_qb',
    'txt_antecenteshermo_qd',
    'txt_bano_kna',
    'txt_cateter',
    'txt_dosis_refuerzo_hvb',
    'txt_dosisi_hvb',
    'txt_ef_conjuntivas',
    'txt_ef_estadodelapiel',
    'txt_ef_extremidades',
    'txt_ef_gradoconciencia',
    'txt_ef_movilidad',
    'txt_ef_nutricion',
    'txt_ef_yugulares',
    'txt_fav',
    'txt_gorotex',
    'txt_hbsag',
    'txt_hepatina_i',
    'txt_hepatina_m',
    'txt_hiv',
    'txt_hvc',
    'txt_medicamento_alergia',
    'txt_observaciones_finales',
    'txt_otro_alergia',
    'txt_persona_urgencia'
];

function js_guarda_ingreso(){
    let arr_envio = [];
    let v_error = [];
    idsDeElementos.forEach(function(id) {
        var elemento = document.getElementById(id);
        $("#"+id).removeClass('class_input_error');
        if (elemento && elemento.value.trim() === "") {
            v_error.push(id);
            $("#"+id).addClass('class_input_error');
        }  else {
            arr_envio[id] = $("#"+id).val();
        }
    });
    
    console.log("   **********************************  ");
    console.log("   ****    arr_envio -> ",arr_envio,"  ");
    console.log("   **********************************  ");

    if(v_error.length>0){
        console.log("   ********************************   ");
        console.log("   ****    ERRORES     ***");
        console.log("   ********************************   ");
        showNotification('top','center','<i class="bi bi-clipboard-x-fill"></i> Existe informaci&oacute;n incompleta en el registro ',4,'');
    } else {
        
        console.log("   ********************************   ");
        console.log("   ****    para enviar por ajax ***   ");
        console.log("   ********************************   ");

        $.ajax({ 
            type		:   "POST",
            url 		:   "ssan_hdial_ingresoegresopaciente/fn_guarda_ingresohermodialisis",
            dataType    :   "json",
            beforeSend  :   function(xhr){  $('#loadFade').modal('show'); },
            data 		:   { arr_ : arr_envio },
            error		:   function(errro) {  
                                                console.log(errro);
                                                jAlert("Comuniquese con el administrador","CLINICA LIBRE CHILE");
                                                $("#loadFade").modal('hide'); 
                                            },
            success		:   function(aData) {  
                                                $("#loadFade").modal('hide');
                                                console.log("fn_guarda_ingresohermodialisis ->",aData);
                                                if (aData.status){

                                                } else {

                                                }
                                            }, 
        });
    }
}
</script>