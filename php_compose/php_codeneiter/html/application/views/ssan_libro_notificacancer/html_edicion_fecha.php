<div class="grid_edicion_horas" style="<?php echo $ind_opcion=='0'?'':'display:none;';?>">
    <div class="card group_hr_anatomia" style="margin-bottom: 0px;padding: 7px;">
        <h5 class="title" style="margin-bottom: 10px;margin-top:3px;">
            <b style="color:#888888;font-size:12px;"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;FECHA/HORA DIAGN&Oacute;STICO</b>
        </h5>
        <div class="grid_fecha_hora">
            <div class="grid_fecha_hora1">
                <div class="input-group row_calendar" style="width: 125px;" id="fec_ingresopab">
                    <input type="text" class="form-control input-sm grupo_time_pab" id="new_fecha_diagnostico" name="new_fecha_diagnostico"  value="<?php echo $txt_fecha_diag;?>">
                    <span class="input-group-addon" style="cursor:pointer; padding:4px;margin-left: 3px;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="grid_fecha_hora2">
                <input type="time" class="form-control input-sm" style="width: 115px;" id="new_hora_diagnostico" name="new_hora_diagnostico" maxlength="5" size="5"  value="<?php echo $txt_hora_diagnostico;?>">
            </div>
            <div class="grid_fecha_hora3">
                <button type="button" class="btn btn-success btn-fill" id="btn_update_analitica" onclick="js_edita_fecha_emision_informe(<?php echo $id_biopsia;?>)">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="grid_edicion_horas" style="<?php echo $ind_opcion=='1'?'':'display:none;';?>">
    <div class="card group_hr_anatomia" style="margin-bottom: 0px;padding: 7px;">
        <h5 class="title" style="margin-bottom: 10px;margin-top:3px;">
            <b style="color:#888888;font-size:12px;"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;FECHA/HORA NOTIFICACI&Oacute;N DE CANCER</b>
        </h5>
        <div class="grid_fecha_hora">
            <div class="grid_fecha_hora1">
                <div class="input-group row_calendar" style="width: 125px;" id="fec_ingresopab">
                    <input type="text" class="form-control input-sm grupo_time_pab" id="new_fecha_notifica_cancer" name="new_fecha_notifica_cancer"  value="<?php echo $arr_info["TXT_FECHA_CANCER"];?>">
                    <span class="input-group-addon" style="cursor:pointer; padding:4px;margin-left: 3px;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="grid_fecha_hora2">
                <input type="time" class="form-control input-sm" style="width: 115px;" id="new_hora_notifica_cancer" name="new_hora_notifica_cancer" maxlength="5" size="5"  value="<?php echo $arr_info["TXT_HRS_CANCER"];?>">
            </div>
            <div class="grid_fecha_hora3">
                <button type="button" class="btn btn-success btn-fill" id="btn_update_analitica" onclick="js_edita_fecha_notificacion_cancar(<?php echo $id_biopsia;?>)">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="ind_template" name="ind_template"  value="<?php echo $ind_opcion;?>">

<script>
    $(document).ready(function(){
        $(".row_calendar").datetimepicker({
            format              :   'DD-MM-YYYY',
            //minDate           :   new Date(new Date().setDate((new Date().getDate())-(30))),
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
        }).on('dp.change',function(e){
            console.log("-----------change------------>",e.currentTarget.id);
        }).on('dp.show',function(e) { 
            console.log("-----------show-------------->",e.currentTarget.id);
        });
    });
</script>