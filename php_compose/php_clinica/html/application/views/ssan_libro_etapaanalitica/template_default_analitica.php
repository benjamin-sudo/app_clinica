
<input type="hidden" id="id_anatomia"       name="id_anatomia"      value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>"/>
<input type="hidden" id="NAMESESSION"       name="NAMESESSION"      value="<?php echo $this->session->userdata["NAMESESSION"];?>"/>
<input type="hidden" id="USERNAME"          name="USERNAME"         value="<?php echo $this->session->userdata["USERNAME"];?>"/>
<input type="hidden" id="unique"            name="unique"           value="<?php echo $this->session->userdata["unique"];?>"/>

<div class="info_userdata" data-userdata="<?php echo htmlspecialchars(json_encode($this->session->userdata));?>"></div>

<div class="grid_body_form_analitica">
    <div class="grid_body_form_analitica1">
        <div class="card" id="card_informacio_paciente" style="margin-bottom: 5px">
            <div class="header" style="margin-left: 14px;margin-top: 12px;margin-bottom:-7px;">
                <h5 class="title"><i class="fa fa-user-o" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">PACIENTE</b></h5>
            </div>
            <div class="content card-body" style="padding: 10px">
                <div class="table-responsive" style="margin-bottom:-5px;margin-top:0px;">
                    <table class="table table-striped table-sm" style="margin-bottom: 0px;">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <small><b style="color:#888888;">NOMBRE DEL PACIENTE</b></small><br>
                                    <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXTNOMCIRUSMALL"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small><b style="color:#888888;">RUN</b></small><br>
                                    <small class="text-muted" id="rutLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["COD_RUTPAC"]."-".$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["COD_DIGVER"]." ".$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_IDENTIFICACION"];?> </small>
                                </td>
                                <td>
                                    <small><b style="color:#888888;">SEXO</b></small><br>
                                    <small class="text-muted" id="sexoLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TISEXO"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <small><b style="color:#888888;">F.&nbsp;NACIMIENTO</b></small><br>
                                    <small class="text-muted" id="edadLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NACIMIENTO"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <small><b style="color:#888888;">N&deg;&nbsp;FICHA LOCAL</b></small><br>
                                    <small class="text-muted" id="FichaLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FICHAL"];?></small>
                                </td>
                            </tr>
                            <tr> 
                                <td colspan="2">
                                    <small><b style="color:#888888;">PREVISI&Oacute;N</b></small><br>
                                    <small class="text-muted" id="previsionLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_PREVISION"];?></small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card" id="card_tiempos_anatomia_patologica" style="margin-bottom:5px">
            <div class="header" style="margin-left: 22px;margin-top: 14px;margin-bottom: 10px;">
                <h5 class="title"><i class="fa fa-calendar" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">SOLICITUD</b></h5>
            </div>
            <div class="content card-body" style="padding: 10px;">
                <table width="100%" class="table table-striped table-sm" style="margin-bottom: -2px;margin-top: -18px;"> 
                    <tbody id="tabla_biopsia">
                         <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">TIPO DE BIOPSIA</b></small><br>
                                <small class="text-muted" id="nombreLabel3">
                                    <?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TIPO_DE_BIOPSIA"];?>
                                    <input type="hidden" id="IND_TIPO_BIOPSIA" name="IND_TIPO_BIOPSIA" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TIPO_BIOPSIA"];?>"/>
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">FECHA TOMA MUESTRA</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_TOMA_MUESTRA"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">SOLICITANTE</b></small>
                                <br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["PROFESIONAL"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">SERVICIO</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NOMBRE_SERVICIO"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">ORIGEN SISTEMA</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_PROCEDENCIA"];?></<small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card" id="card_logs_muestras" style="margin-bottom: 5px">
            <div class="header" style="margin-left: 22px;margin-top: 14px;margin-bottom: 10px;">
                <h5 class="title"><i class="fa fa-database" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">EVENTOS</b></h5>
            </div>
            <hr style="margin: 0px">
            <div class="" style="padding:4px;">
                <?php echo $html_log;?>
            </div>
        </div>
    </div>
    <div class="grid_body_form_analitica2">
        <?php #echo $get_sala;?>
        <?php if ($get_sala == 'salamacroscopia'){     ?>
            <?php echo $this->load->view("ssan_libro_etapaanalitica/html_salamacro_descmuestra",[],true); ?>
        <?php } else if ($get_sala == 'sala_tecnologo'){ ?> 
            <?php echo $this->load->view("ssan_libro_etapaanalitica/html_new_sala_proceso",[],true); ?>
        <?php } else if ($get_sala == 'analitica'){ ?> 
            <?php echo $this->load->view("ssan_libro_etapaanalitica/templete_etapa_analitica",[],true); ?>
        <?php } else if ($get_sala == 'sala_proceso'){ ?>
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
                                        <input id="date_fecha_inicio_sala_proceso" name="date_fecha_inicio_sala_proceso" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TIME_DIA"];?>">
                                        <span class="input-group-addon" style="cursor:pointer;cursor:pointer;margin-top:6px;margin-left:15px;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                                    </div>
                                </td>
                                <td>
                                    <small><b style="color:#888888;">HORA</b></small><br>
                                    <input style="width:100px;" type="time" class="form-control input-sm" id="hrs_star_sala_proceso" name="hrs_star_sala_proceso" maxlength="5" size="5"  value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TIME_HORA"];?>">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="grid_sala_de_procesos_tiempo2">
                    
                </div>
                <div class="grid_sala_de_procesos_tiempo3">
                    <?php if ($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["VAL_HISTO_ZONA"] == 5) { ?> 
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
                                            <input id="date_fecha_final_sala_proceso" name="date_fecha_final_sala_proceso" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TIME_DIA_FINAL"];?>">
                                            <span class="input-group-addon" style="cursor:pointer;margin-top: 6px;margin-left:15px;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                                        </div>
                                    </td>
                                    <td>
                                        <small><b style="color:#888888;">HORA</b></small><br>
                                        <input style="width:100px;" type="time" class="form-control input-sm" id="hrs_end_sala_proceso" name="hrs_end_sala_proceso" maxlength="5" size="5" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TIME_HORA_FINAL"];?>">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="grid_sala_de_procesos_tiempo">
                <div class="grid_sala_de_procesos_tiempo1">
                    <div class="card" id="card_registro_medico4" style="margin-bottom:5px;padding:8px;">
                        <h6 class="title" style="margin: 8px 0px 12px 0px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">INFORMACI&Oacute;N COMPLEMENTARIA</b>
                        </h6>
                        <hr style="margin: 0px">
                        <table style="width: 100%;">
                            <tr>
                                <td width="100%">
                                    <small><b style="color:#888888;">TIPO DE PROCESO</b></small><br>
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="ind_tipo_proceso" id="ind_tipo_proceso" data-width="98%" tabindex="-98">
                                        <option value=""> -- </option>
                                        <option value="1">PROCESO CORTO</option>
                                        <option value="2">PROCESO LARGO</option>
                                    </select> 
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="grid_sala_de_procesos_tiempo2">&nbsp;</div>
            </div>
        <?php   } else if ($get_sala == 'administrativo'){ ?>    
            <?php echo $this->load->view("ssan_libro_etapaanalitica/html_panel_administrativo",[],true); ?>
        <?php   }   else    {   ?>
                <b>TEMPLETE NO IDENTIFICADO</b>
                <br>
                <?php echo $get_sala;?>
        <?php } ?>

    </div>
    <!-- display:none -->
    <div class="grid_body_form_analitica3">
        <div class="card" id="card_informacion_main_anatomia" style="margin-bottom:5px;">
            <div class="header" style="margin-left: 22px;margin-top: 14px;margin-bottom: 10px;">
                <h5 class="title"><i class="fa fa-file-o" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">FOMULARIO</b></h5>
            </div>
            <div class="content card-body" style="padding: 10px;">
                <table width="100%" class="table table-striped table-sm" style="margin-bottom:-5px;margin-top:-20px;"> 
                    <tbody id="tabla_biopsia">
                        <?php  if ($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_INTERNO_AP"] != '0')    { ?>
                        <tr>
                            <td colspan="2">
                                <small><b style="color:#888888;">N&deg; BIOPSIA</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_INTERNO_AP"];?></small>
                            </td>
                        </tr>
                        <?php   }  ?>  
                        
                        <?php  if ($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_CO_PAP"] != '')    { ?>
                        <tr>
                            <td colspan="2">
                                <small><b style="color:#888888;">N&deg; PAP</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_CO_PAP"];?></small>
                            </td>
                        </tr>
                        <?php   }  ?>  
                        <?php  if ($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_CO_CITOLOGIA"] != '')    { ?>
                        <tr>
                            <td colspan="2">
                                <small><b style="color:#888888;">N&deg; CITOL&Oacute;GICO</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_CO_CITOLOGIA"];?></small>
                            </td>
                        </tr>
                        <?php   }  ?>   
                        <tr>
                            <td colspan="2">
                                <small><b style="color:#888888;">NOTIFICACI&Oacute;N DE CANCER</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_NOTIF_CANCER"];?></small>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <small><b style="color:#888888;">SITIO DE EXTRACCI&Oacute;N</b></small><br>
                                <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_SITIOEXT"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <small><b style="color:#888888;">UBICACI&Oacute;N</b></small><br>
                                <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_UBICACION"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <small><b style="color:#888888;">TAMA&Ntilde;O</b></small><br>
                                <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_TAMANNO"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <small><b style="color:#888888;">TIPO DE LESI&Oacute;N</b></small><br>
                                <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_TIPOSESION"];?></small>
                            </td>
                            <td width="50%">
                                <small><b style="color:#888888;">ASPECTO</b></small><br>
                                <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_ASPECTO"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <small><b style="color:#888888;">ANT. PREVIOS</b></small><br>
                                <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_ANT_PREVIOS"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="2">
                                <small><b style="color:#888888;">DESC. BIOPSIA</b></small><br>
                                <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_BIPSIA"]==''?'NO INFORMADO':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_BIPSIA"];?></small>
                            </td>
                        </tr> 
                        <tr> 
                             <td colspan="2">
                                <small><b style="color:#888888;">DESC. CITOLOG&Iacute;A</b></small><br>
                                <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_CITOLOGIA"]==''?'NO INFORMADO':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_CITOLOGIA"];?></small>
                            </td>
                        </tr> 
                        <tr>
                             <td colspan="2">
                                <small><b style="color:#888888;">OBSERVACIONES</b></small><br>
                                <small class="text-muted" id="nombreLabel"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_OBSERVACIONES"]==''?'NO INFORMADO':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_OBSERVACIONES"];?></small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card" id="card_logs_chat" style="margin-bottom: 5px">
            <div class="header" style="margin-left: 22px;margin-top: 14px;margin-bottom: 10px;">
                <h5 class="title"><i class="fa fa-weixin" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">MENSAJES</b></h5>
            </div>
            <hr style="margin: 0px">
            <div id="body_chat" class="body_chat my_custom_scrollbar" style="padding:4px;">
                <ul id="lista_chat" class="list-group list-group-flush" style="margin-bottom:0px" data-mensajes="<?php echo htmlspecialchars(json_encode($data_bd[":C_CHAT_ANATOMIA"]),ENT_QUOTES,'UTF-8');?>"> 
                    <?php if(count($data_bd[":C_CHAT_ANATOMIA"])>0){?>
                    <!--
                        <?php foreach($data_bd[":C_CHAT_ANATOMIA"] as $i => $row){ ?>
                            <a href="#" class="list-group-item list-group-item-action" style="padding:0px;">
                                <div class="grid_body_li_chat">
                                    <div class="grid_cell chat_user"><div class="cell_content"><small><b style="color:#888888;"><?php echo $row["TXT_USER"];?></b></small></div></div>
                                    <div class="grid_cell chat_time" style=" text-align:end;"><div class="cell_content"><small><b style="color:#888888;"><?php echo $row["CHAR_DATE_CREA"];?></b></small></div></div>
                                    <div class="grid_cell chat_menj"><div class="cell_content"><?php echo $row["TXT_CHAT_ANATOMIA"];?></div></div>
                                </div>
                            </a>
                        <?php } ?>
                    -->
                    <?php } else { ?>
                        <a href="#" class="list-group-item list-group-item-action" style="text-align: center">
                            &nbsp;<i class="fa fa-exclamation" aria-hidden="true"></i>
                            &nbsp;<b>SIN MENSAJES</b>
                        </a>
                    <?php }  ?>
                </ul>
            </div>
            <hr style="margin: 0px">
            <div class="footer_chat" style="padding:4px;" id="">
               <div class="" style="padding:4px;">
                    <div class="grid_opciones_chat">
                        <div class="grid_opciones_chat1">
                            <textarea 
                                class       =   "form-control input-sm" 
                                name        =   "txt_enviar_mensaje" 
                                id          =   "txt_enviar_mensaje" 
                                cols        =   "10" 
                                rows        =   "2" 
                                style       =   "width:100%;" 
                                maxlength   =   "450"></textarea>
                        </div>
                        <div class="grid_opciones_chat2">
                            <button type="button" class="btn btn-fill btn-primary btn-xs btn-success" style="height: 48px;" onclick="js_envia_chat(0)">
                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>&nbsp;Enviar
                            </button>
                        </div>
                    </div>
                    <div class="grid_escribiendo">
                        <div class="grid_escribiendo1">&nbsp;</div>
                        <div class="grid_escribiendo2" id="txt_escribiendo" style="text-align:center;display:none;">
                            <i class="fa fa-commenting parpadea" aria-hidden="true" style="color:#ccc;display:none;"></i>
                            &nbsp;
                            <b class="parpadea" style="color:#ccc;">Escribiendo...</b>
                        </div>
                        <div class="grid_escribiendo3">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php #echo $get_sala;?>
<script>
$(document).ready(function(){
    star_collapse();
    //star_mictrofono();
    <?php   if(count($data_bd[":C_CHAT_ANATOMIA"])>0){ ?>
        //update_mensajes_chat();
    <?php   }   ?> 
    <?php   if ($get_sala == 'analitica'){ ?>
        //console.error("etapa analitica ->   ",500);
    <?php   }   ?>

    <?php   if ($get_sala == 'sala_tecnologo'){ ?>

        $('.lista_gestion_tecnologo a:first').tab('show')
        $("#ind_estado_olga").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_ESTADIO_OLGA_TEC"];?>');
        $("#ind_color_taco").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_COLOR_TACO"];?>');
        $(".selectpicker").selectpicker();
        $(".star_calendar").datetimepicker({
            format : 'DD-MM-YYYY',
            //minDate : new Date(new Date().setDate((new Date().getDate())-(30))),
            //maxDate : new Date(),
            locale : 'es-us',
            icons : {
                        time : "fa fa-clock-o" ,
                        date : "fa fa-calendar" ,
                        up : "fa fa-chevron-up" ,
                        down : "fa fa-chevron-down" ,
                        previous : "fa fa-chevron-left" ,
                        next : "fa fa-chevron-right" , 
                        today : "fa fa-screenshot" ,
                        clear : "fa fa-trash" ,
                        close : "fa fa-remove",
                    }
        }).on('dp.change',function(e){  
            console.log("e  -> ",e," <-  ");
        });
        let arr_tecnicas = $("#tecnicas_realizadas").data("prestacion");
        if(arr_tecnicas.length>0){
            let arr_x_muestra = [];
            let json = arr_tecnicas.reduce((acc,fila)=>{ !acc[fila.ID_NMUESTRA]?acc[fila.ID_NMUESTRA]=[]:'';acc[fila.ID_NMUESTRA].push(fila); return acc; },{});
            for(let i in json) {
                let arr_tecnicas = [];
                json[i].forEach(function(fila,indice,array){ arr_tecnicas.push(fila.ID_TECNICA_AP);});
                $('#prestaciones_'+i).selectpicker('val',arr_tecnicas);
            }
        }

    <?php   }   ?>

    <?php   if ($get_sala == 'sala_proceso'){ ?>
        $("#calendar_inicio_sala_proceso,#calendar_final_sala_proceso").datetimepicker({
            format : 'DD-MM-YYYY',
            //minDate : new Date(new Date().setDate((new Date().getDate())-(30))),
            maxDate : new Date(),
            locale : 'es-us',
            icons : {
                        time : "fa fa-clock-o" ,
                        date : "fa fa-calendar" ,
                        up : "fa fa-chevron-up" ,
                        down : "fa fa-chevron-down" ,
                        previous : "fa fa-chevron-left" ,
                        next : "fa fa-chevron-right" , 
                        today : "fa fa-screenshot" ,
                        clear : "fa fa-trash" ,
                        close : "fa fa-remove",
                    }
        }).on('dp.change',function(e){  
            console.log("e=>",e);  
        });
        $(".selectpicker").selectpicker();
    <?php   }   ?>
    <?php   if ($get_sala == 'administrativo'){ ?>
        //console.log("load js administrativo");
        $(".selectpicker").selectpicker();
        $(".row_calendar").datetimepicker({
            format              :   'DD-MM-YYYY',
            minDate             :   new Date(new Date().setDate((new Date().getDate())-(30))),
            maxDate             :   new Date(),
            locale              :   'es-us',
            icons               :   {
                                        time : "fa fa-clock-o" ,
                                        date : "fa fa-calendar" ,
                                        up : "fa fa-chevron-up" ,
                                        down : "fa fa-chevron-down" ,
                                        previous : "fa fa-chevron-left" ,
                                        next : "fa fa-chevron-right" , 
                                        today : "fa fa-screenshot" ,
                                        clear : "fa fa-trash" ,
                                        close : "fa fa-remove",
                                    }
        }).on('dp.change',function(e){  
            console.log("e=>",e);  
        });
    <?php  } ?>
        
});
</script>

<?php 
    function conversorSegundosHoras($tiempo_en_segundos) {
        $horas      =   floor($tiempo_en_segundos/3600);
        $minutos    =   floor(($tiempo_en_segundos-($horas*3600))/60);
        $segundos   =   $tiempo_en_segundos-($horas * 3600)-($minutos*60);
        return array("horas"=>$horas, "minutos"=> $minutos,"segundos"=>$segundos);
    }
?>