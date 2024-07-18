<div class="grid_sala_de_procesos_tiempo">
    <div class="grid_sala_de_procesos_tiempo1">
        <div class="card" id="card_registro_medico4" style="margin-bottom:5px;padding:8px;">
            <h6 class="title" style="margin: 8px 0px 12px 0px;">
                <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                <b style="color:#888888;">INICIO SALA DE PROCESO</b>
            </h6>
            <hr style="margin: 0px">
            <table>
                <tr>
                    <td>
                        <small><b style="color:#888888;">FECHA</b></small>
                        <br>
                        <div id="calendar_inicio_sala_proceso" class="input-group row_calendar" style="width:140px;margin-right:10px;">
                            <input id="date_fecha_inicio_sala_proceso" name="date_fecha_inicio_sala_proceso" type="text" class="form-control input-sm" value="<?php echo $bd[":P_SALA_PROCESO"][0]["TIME_DIA"];?>">
                            <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                        </div>
                    </td>
                    <td>
                        <small><b style="color:#888888;">HORA</b></small><br>
                        <input style="width: 90px;" type="time" class="form-control input-sm" id="hrs_star_sala_proceso" name="hrs_star_sala_proceso" maxlength="5" size="5"  value="<?php echo $bd[":P_SALA_PROCESO"][0]["TIME_HORA"];?>">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="grid_sala_de_procesos_tiempo2">
        <!--  
            <?php echo $bd[":P_SALA_PROCESO"][0]["VAL_HISTO_ZONA"];?>  
        -->
    </div>
    <div class="grid_sala_de_procesos_tiempo3">
        <?php if ($bd[":P_SALA_PROCESO"][0]["VAL_HISTO_ZONA"] == 5) { ?> 
            <div class="card" id="card_registro_medico4" style="margin-bottom:5px;padding:8px;">
                <h6 class="title" style="margin: 8px 0px 12px 0px;">
                    <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                    <b style="color:#888888;">FINAL SALA DE PROCESO</b>
                </h6>
                <hr style="margin: 0px">
                <table>
                    <tr>
                        <td>
                            <small><b style="color:#888888;">FECHA</b></small>
                            <br>
                            <div id="calendar_final_sala_proceso" class="input-group row_calendar" style="width:140px;margin-right:10px;">
                                <input id="date_fecha_final_sala_proceso" name="date_fecha_final_sala_proceso" type="text" class="form-control input-sm" value="<?php echo $bd[":P_SALA_PROCESO"][0]["TIME_DIA_FINAL"];?>">
                                <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                            </div>
                        </td>
                        <td>
                            <small><b style="color:#888888;">HORA</b></small><br>
                            <input style="width: 90px;" type="time" class="form-control input-sm" id="hrs_end_sala_proceso" name="hrs_end_sala_proceso" maxlength="5" size="5"  value="<?php echo $bd[":P_SALA_PROCESO"][0]["TIME_HORA_FINAL"];?>">
                        </td>
                    </tr>
                </table>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    $("#calendar_inicio_sala_proceso,#calendar_final_sala_proceso").datetimepicker({
        format              :   'DD-MM-YYYY',
        //minDate           :   new Date(new Date().setDate((new Date().getDate())-(30))),
        //maxDate           :   new Date(),
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
        console.log("e=>",e);  
    });
</script>
