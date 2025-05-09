<input type="hidden" id="hd_tipotabs" name="hd_tipotabs" value="1">
<input type="hidden" id="NUM_FASE" name="NUM_FASE" value="2"/>
<input type="hidden" id="IND_TEMPLETE" name="IND_TEMPLETE" value="ssan_libro_biopsias_ii_fase"/>
<input type="hidden" id="get_sala" name="get_sala" value="sala_recepcion_muestras"/>
<input type="hidden" id="SERVER_NAME" name="SERVER_NAME" value="<?php echo $_SERVER['SERVER_NAME'];?>"/>
<input type="hidden" id="date_inicio" name="date_inicio" value="<?php echo date("m/d/Y",strtotime($date_inicio));?>"/>
<input type="hidden" id="date_final" name="date_final" value="<?php echo $date_final>$date_inicio?date("m/d/Y",strtotime($date_final)):date("m/d/Y",strtotime($date_inicio));?>"/>
<input type="hidden" id="empresa" name="empresa" value="<?php echo $this->session->userdata("COD_ESTAB");?>"/>
<input type="button" id="ws_button" name="ws_button" value="test ws" onclick="js_test_ws()" style="display: none"/>
<form id="load_ingreso_etapa_analitica" method="post" action="#"></form>
<form id="load_anuncios_anatomia_patologica" method="post" action="#"></form>
<div class="info_userdata" data-userdata="<?php echo htmlspecialchars(json_encode($this->session->userdata),ENT_QUOTES,'UTF-8');?>"></div>
<div class="GRID_LIBRO_BIOPSIAS_II_MAIN">
    <div class="GRID_LIBRO_BIOPSIAS_II_MAIN1">
        <h4 class="title" style="color:#e34f49;margin-left:20px;"><b>RECEPCI&Oacute;N DE MUESTRAS</b></h4>
    </div>
    <div class="GRID_LIBRO_BIOPSIAS_II_MAIN1 _CENTER">&nbsp;</div>
    <div class="GRID_LIBRO_BIOPSIAS_II_MAIN3 grid_left">
        <div class="btn-group" style="padding:6px;">
            <button type="button" class="btn btn-success btn-fill" id="BTN_UPDATE_PANEL_1" onclick="UPDATE_PANEL()">
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-info btn-fill" id="BTN_POP_START" onclick="js_min_clavesesissan()" style="displaY:none">
                <i class="fa fa-users" aria-hidden="true"></i>&nbsp;PERFIL CLINICA LIBRE
            </button>
            <button type="button" class="btn btn-warning btn-fill" id="BTN_POP_START" onclick="js_gestion_html()" style="displaY:none">
                <i class="fa fa-address-card" aria-hidden="true"></i>&nbsp; 2.- PRESTADORES 
            </button>
            <button type="button" class="btn btn-primary btn-fill" id="btn_gestion_tomademuestraxuser" onclick="js_gestion_tomademuestraxuser()">
                <i class="fa fa-users" aria-hidden="true"></i>&nbsp;USUARIOS POR TOMA DE MUESTRA
            </button>
        </div>
    </div>
</div>
<div class="dv_derivar" id="" style="margin-top:-5px;"> 
    <div class="GRID_LIBRO_MAIN_SOLICITUD">
        <div class="GRID_LIBRO_MAIN_SOLICITUD1">
            <div class="CSS_GRID_CALENDARIO_OPEN">
                <div class="CSS_GRID_CALENDARIO_OPEN3">&nbsp;</div>
                <div class="CSS_GRID_CALENDARIO_OPEN1">
                    <div class="card class_FIRST" style="padding: 10px 15px 15px 15px;">
                        <div class="header">
                            <h5 class="title">
                                <i class="fa fa-calendar" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">FECHA INICIAL</b>
                            </h5>
                        </div>
                        <div class="content" style="margin-top:-18px;"> 
                            <div style="overflow:hidden;">
                                <div class="form-group d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom: -20px;">
                                            <div id="fecha_out"></div>
                                        </div>
                                        <div class="col-md-12 LOAD_CALENDARIO" id="LOAD_CALENDARIO">
                                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="CSS_GRID_CALENDARIO_OPEN2">&nbsp;</div>
                <div class="CSS_GRID_CALENDARIO_OPEN3">&nbsp;</div>
                <div class="CSS_GRID_CALENDARIO_OPEN4">
                    <div class="card" style="padding: 10px 15px 15px 15px;">
                        <div class="header">
                            <h5 class="title"><i class="fa fa-calendar" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">FECHA FIN</b></h5>
                        </div>
                        <div class="content" style="margin-top:-18px;"> 
                            <div style="overflow:hidden;">
                                <div class="form-group d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom: -20px;">
                                            <div id="fecha_out2"></div>
                                        </div>
                                        <div class="col-md-12 LOAD_CALENDARIO" id="LOAD_CALENDARIO2">
                                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="CSS_GRID_CALENDARIO_OPEN5">&nbsp;</div>
            </div>
        </div>
        <div class="GRID_LIBRO_MAIN_SOLICITUD1">
            <div class="CCS_BODY_LIBROBIOPSIA12" style="margin-left:0px;margin-right:8px;">
                <div class="CSS_GRID_CIRUGIA_HEAD_FASE2">
                    <div class="div_1">
                        <li class="gespab_group list-group-item list-group-item-primary active" style="border-radius: 7px 7px 0px 0px;">
                            <b style="margin-right:10px;margin-left:10px;"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>&nbsp;RECEPCI&Oacute;N DE MUESTRAS EN TRASPORTE</b> 
                        </li>
                    </div>
                    <div class="div_2">&nbsp;</div>
                    <div class="div_3">&nbsp;</div>
                </div>
                <ul class="list-group" style="margin-bottom:0px;padding:9px;margin-top:-9px;" id="LI_LISTA_MAIN">
                    <li class="gespab_group list-group-item list-group-item-default active" style="border-radius: 0px 4px 0px 0px;">
                        <div class="CSS_GRID_CIRUGIA_FASE_1">
                            <div class="text-center"><b>N&deg;</b></div>
                            <div class=""><b>PACIENTE</b></div>
                            <div class=""><b>PROFESIONAL</b></div>
                            <div class=""><b>ESTADO</b></div>
                            <div class="" style="text-align:center;"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                            <div class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></div>
                        </div>  
                    </li>
                    <?php echo $html_externo;?>
                </ul>
            </div>  
        </div>
    </div>
</div>

<section>
    <!--  ZONA DE MODALES -->
    <div class="modal fade" id="modal_busqueda" data-backdrop="static">
        <div class="modal-dialog modal-md" style="    width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <h5 class="modal-title">B&Uacute;SQUEDA</h5>
                </div>
                <div class="modal-body" id="html_modal_busqueda">
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <b>NUMERO DE SOLICITUD<b>
                            <input type="text" id="busq_numsolicitud"  class="form-control" maxlength="300">           
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <b>NUMERO DE MUESTRA<b>
                            <input type="text" id="busq_nummuestra"  class="form-control" maxlength="300">           
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <b>RUT PACIENTE</b>
                            <div class="input-group" id="dv_rutform">
                            <span class="input-group-addon" id="basic-addon1" style="cursor: pointer" onclick="busqueda_paciente_histo();">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                            <input class="form-control heigthh" type="text" id="busq_rutpac" name="busq_rutpac" onkeypress="" maxlength="13">                         
                            <span id="ErrorRutBUSQUEDA_" style="display: none;"></span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                        <a class="btn btn-primary btn-fill btn-sm" style="width: 98px;padding: 1px;margin-top: 2px;" href="javascript:buscar_buscador()" data-toggle="tooltip" data-placement="top" title="" data-original-title="trae información.">
                            <i class="fa fa-search" aria-hidden="true"></i></a>         
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12" id="div_html_buscador">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_comenzar" data-backdrop="static">
        <div class="modal-dialog modal-md" style="    width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div id="headd1" style="text-align:center">
                <h5 class="modal-title">FAVOR INDICAR PROCESO A REALIZAR</h5>
                    <center>
                        <div style="width: 390px;">
                            <select class="selectpicker" id="Sl_accion_a_realizar"  onchange="Sl_accion_a_realizar();">
                                <option value=""    >SELECCIONE...</option>
                                <option value="100" >SOLO CONSULTAR</option>
                                <option value="1"   >RECEPCIONAR MUESTRAS (AP)</option>
                            </select>
                        </div>
                    </center>
                </div>
                <div id="headd2" style="text-align:center;display:none;margin-top: 20px;">  </div>
                <div id="headd3" style="text-align:center;display:none;margin-top: 20px;">  </div>
                <div class="modal-body" id="html_modal_comenzar"> </div>
                <div>
                <table class='table'>
                    <tr id='tr_btn_guardar_1' style="display:none">     
                        <td colspan="7" >
                            <center><a class="btn btn-success btn-fill btn-sm" style="width: 300px;padding: 1px;margin-top: 2px;" href="javascript:Guardar_proceso(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="">
                            <i class="fa fa-save" aria-hidden="true"></i> FINALIZAR PROCESO</a></center>
                        </td>
                    </tr>
                    <tr id='cls_preg_2' style='display:none'>     
                        <td colspan="7" style="text-align:center">
                            <h3>Estimado usuario veo que tiene muestras sin marcar. </h3>
                            <div style="margin-bottom:20px;font-size:20px;"><br>-Al Finalizar el sistema procesara las muestras marcadas y las no marcadas las dejara inactivas.    
                            <center>
                            </div>
                            <a class="btn btn-success btn-fill btn-sm" style="width: 300px;padding: 1px;margin-top: 2px;" href="javascript:Guardar_proceso(1)" data-toggle="tooltip" data-placement="top" title="" data-original-title="">
                            <i class="fa fa-check" aria-hidden="true"></i>(1) PROCESAR SOLICITUD</a>
                            </center>
                        </td>
                    </tr> 
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_historial_MUESTRA" data-backdrop="static">
        <div class="modal-dialog modal-md" style="    width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <h5 class="modal-title">HISTORIAL MUESTRA N&deg;<span id="txt_pop_num_muestra_hist"></span></h5>
                </div>
                <div class="modal-body" id="html_modal_historial_MUESTRA"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_infosolicitud_MUESTRA" data-backdrop="static">
        <div class="modal-dialog modal-md" style="    width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <h5 class="modal-title">INFORMACI&Oacute;N</h5>
                </div>
                <div class="modal-body" id="html_modal_infosolicitud_MUESTRA"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Adjuntaimg_modal" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <h5 class="modal-title">Adjuntar Archivo</h5>
                </div>
                <div class="modal-body" id="html_Adjuntaimg"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdf_modal" data-backdrop="static">
        <div class="modal-dialog modal-md" style="    width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ADJUNTOS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" id="html_adjuntos"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdf_modalSOLICITUD" data-backdrop="static">
        <div class="modal-dialog modal-md" style="    width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body" id="html_adjuntosSOLICITUD">
                    <ul role="tablist" class="nav nav-tabs" style="margin-top: 10px;">
                        <li role="presentation" class="active">
                            <a id="TAB_PDF_SOLICITUD" href="#tb_TAB_PDF_SOLICITUD" data-toggle="tab" onclick="">PDF SOLICITUD </a>
                        </li>    
                        <li>
                            <a id="TAB_PDF_SOLICITUD2"  href="#tb_TAB_PDF_SOLICITUD2" data-toggle="tab" onclick="">PDF SEGUNDA HOJA</a>
                        </li>      
                    </ul>
                    <div class="tab-content">
                        <div id="tb_TAB_PDF_SOLICITUD" class="tab-pane active ">
                            ...1...
                        </div>
                        <div id="tb_TAB_PDF_SOLICITUD2" class="tab-pane">
                            ...2...
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_INFORMACION_HISTORIAL">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="title" style="color:#e34f49"><b>HISTORIAL DE MUESTRAS</b></h4>
                </div>
                <div class="modal-body" id="HTML_INFORMACION_HISTORIAL"></div>
                <div class="modal-footer" style="text-align:end;">
                    <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade class_gestion_tomamuestraxuser" id="modal_gestion_tomamuestraxuser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="title" style="color:#e34f49"><b>MUESTRAS POR USUARIO</b></h4>
                </div>
                <div class="modal-body" id="html_gestion_tomamuestraxuser"></div>
                <div class="modal-footer" style="text-align:end;">
                    <div class="grid_opt_new_user">
                        <div class="grid_opt_new_user1" style="text-align: justify;">
                            <button type="button" class="btn btn-warning btn-fill" id="btn_nueva_plantilla" onclick="js_new_userx()">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;NUEVO&nbsp;USUARIO&nbsp;
                            </button>
                        </div>
                        <div class="grid_opt_new_user2">
                            <button type="button" class="btn btn-fill btn-danger" data-dismiss="modal">
                                <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade class_new_userxtomamuestra" id="modal_new_userxtomamuestra">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="title" style="color:#e34f49"><b>NUEVO USUARIO</b></h4>
                </div>
                <div class="modal-body" id="html_new_userxtomamuestra">
                    <div class="grid_new_user_x_servicio">
                        <div class="grid_new_user_x_servicio1">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style=""><i class="fa fa-user"></i><b>RUN</b></span>
                                <input type="text" id="rut_profesional" name="rut_profesional" class="form-control input-sm" style="width:101px;" onkeypress="validar(event)">
                            </div>
                        </div>
                        <div class="grid_new_user_x_servicio2" style="text-align: center">
                            <button type="button" class="btn btn-xs btn-success btn-fill" id="btn_valida_profesional" onclick="valida_profesional()">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-success btn-fill" id="btn_limpia_panel" onclick="js_limpia_panel()" style="display:none"> 
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="grid_new_user_x_servicio3">
                            <select name="ind_servicios" id="ind_servicios" data-width="100%" data-container="body" class="selectpicker" data-selected-text-format="count" data-live-search="true" multiple title="Seleccione..." onclick="js_cambio_punto_entrega(this)">
                            </select> 
                        </div>
                    </div>
                    <div class="grid_informacion_paciente info_profesional_x_toma" data-data="">
                        <div class="grid_informacion_paciente1" >
                            <div class="card" style="min-height:125px;">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td style="height: 40px">
                                                <div>
                                                    <h6 class="my-0">RUN PROFESIONAL:</h6>
                                                    <small class="text-muted" id="numidentificador"></small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="height: 40px">
                                            <td>
                                                <div>
                                                    <h6 class="my-0">NOMBRE PROFESIONAL:</h6>
                                                    <small class="text-muted" id="nombreLabel"></small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="height: 40px">
                                            <td>
                                                <div>
                                                    <h6 class="my-0">PROFESI&Oacute;N:</h6>
                                                    <small class="text-muted" id="profesionLabel"></small>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="grid_informacion_paciente2">
                            <ul class="list-group pto_entrega_x_usuario">
                                <li class="list-group-item sin_puntos_cargados"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;SIN PUNTOS DE ENTREGA</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align:end;">
                    <div class="grid_opt_new_user">
                        <div class="grid_opt_new_user1" style="text-align: justify;"></div>
                        <div class="grid_opt_new_user2">
                            <button type="button" class="btn btn-success btn-fill" id="btn_guarda_infoxususario">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-fill btn-danger" data-dismiss="modal">
                                <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="FLEX_CONTAINER" style="display:none">
        <div class="FLEX_CONTAINER1">
            <div class="card" style="min-height:125px;">
                <div class="content text-center">
                    <div style="background-color: transparent !important;">
                        <div class="font_15" style="margin-bottom: 32px;"><b>EN SOLICITUD (1)</b></div>
                    </div>
                    <hr style="margin-top:10px;margin-bottom:10px">
                    <div style="background-color: transparent !important;">
                        <div style=" height: 50px;color: #575dfb;font-size: 40px;font-weight: bold;" id="dv_html_diashabiles" data-valor="253">0</div>                   
                    </div>
                </div>
            </div>
        </div>
        <div class="FLEX_CONTAINER2">
            <div class="card" style="min-height: 125px;">
                <div class="content text-center">
                    <div style="background-color: transparent !important;">
                        <div class="font_15" style="margin-bottom: 32px;"><b>RECEPCIONADA HORARIO NO HABIL (2)</b></div>
                    </div>
                    <hr style="margin-top:10px;margin-bottom:10px">
                    <div style="background-color: transparent !important;">
                        <div style=" height: 50px;color: #575dfb;font-size: 40px;font-weight: bold;" id="dv_html_diashabiles" data-valor="253">0</div>                   
                    </div>
                </div>
            </div>
        </div>
        <div class="FLEX_CONTAINER3">
            <div class="card" style="min-height: 125px;">
                <div class="content text-center">
                    <div style="background-color: transparent !important;">
                        <div class="font_15" style="margin-bottom: 32px;"><b>NO RECEPCIONADA HORARIO NO HABIL (3)</b></div>
                    </div>
                    <hr style="margin-top:10px;margin-bottom:10px">
                    <div style="background-color: transparent !important;">
                        <div style=" height: 50px;color: #575dfb;font-size: 40px;font-weight: bold;" id="dv_html_diashabiles" data-valor="253">0</div>                   
                    </div>
                </div>
            </div>
        </div>  
        <div class="FLEX_CONTAINER4">
            <div class="card" style="min-height: 125px;">
                <div class="content text-center">
                    <div style="background-color: transparent !important;">
                        <div class="font_15" style="margin-bottom: 20px;"><b>RECEPCIONADA POR PERSONAL QUE TRASLADA (EN TRASLADO) (4)</b></div>
                    </div>
                    <hr style="margin-top:10px;margin-bottom:10px">
                    <div style="background-color: transparent !important;">
                        <div style=" height: 50px;color: #575dfb;font-size: 40px;font-weight: bold;" id="dv_html_diashabiles" data-valor="253">0</div>                   
                    </div>
                </div>
            </div>
        </div>
        <div class="FLEX_CONTAINER5">
            <div class="card" style="min-height: 125px;">
                <div class="content text-center">
                    <div style="background-color: transparent !important;">
                        <div class="font_15" style="margin-bottom: 20px;"><b>NO RECEPCIONADA POR PERSONAL QUE TRASLADA (5)</b></div>
                    </div>
                    <hr style="margin-top:10px;margin-bottom:10px">
                    <div style="background-color: transparent !important;">
                        <div style=" height: 50px;color: #575dfb;font-size: 40px;font-weight: bold;" id="dv_html_diashabiles" data-valor="253">0</div>                   
                    </div>
                </div>
            </div>
        </div>
        <div class="FLEX_CONTAINER6">
            <div class="card" style="min-height: 125px;">
                <div class="content text-center">
                    <div style="background-color: transparent !important;">
                        <div class="font_15" style="margin-bottom: 32px;"><b>RECEPCIONADA EN ANATOMIA PATOLOGICA (6)</b></div>
                    </div>
                    <hr style="margin-top:10px;margin-bottom:10px">
                    <div style="background-color: transparent !important;">
                        <div style=" height: 50px;color: #575dfb;font-size: 40px;font-weight: bold;" id="dv_html_diashabiles" data-valor="253">0</div>                   
                    </div>
                </div>
            </div>
        </div>  
        <div class="FLEX_CONTAINER7">
            <div class="card" style="min-height: 125px;">
                <div class="content text-center">
                    <div style="background-color: transparent !important;">
                        <div class="font_15" style="margin-bottom: 20px;"><b>NO RECEPCIONADA EN ANATOMIA PATOLOGICA (7)</b></div>
                    </div>
                    <hr style="margin-top:10px;margin-bottom:10px">
                    <div style="background-color: transparent !important;">
                        <div style=" height: 50px;color: #575dfb;font-size: 40px;font-weight: bold;" id="dv_html_diashabiles" data-valor="253">0</div>                   
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_info_html">
        <div class="modal-dialog modal_xl_900">
            <div class="modal-content">
                <div class="modal-header">		
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-circle" aria-hidden="true"></i> -  <b>RRHH</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"  style="margin-top: -30px;">
                        <span aria-hidden="true" style="color: darkgray;">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="html_info_html"></div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger btn-sm btn-fill"     id="btn_cierra_ventana" data-dismiss="modal">
                            <i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <div class="modal fade class_clave_esissan_ap" id="modal_clave_esissan_ap">
        <div class="modal-dialog modal_xl_900">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="title" style="color:#e34f49"><b>GESTI&Oacute;N DE PERFIL DE ANATOM&Iacute;A PATOL&Oacute;GICA</b></h4>
                </div>
                <div class="modal-body" id="html_clave_esissan_ap"></div>
                <div class="modal-footer" style="text-align:end;">
                    <div class="grid_opt_new_user">
                        <div class="grid_opt_new_user1" style="text-align: justify;">&nbsp;</div>
                        <div class="grid_opt_new_user2">
                            <button type="button" class="btn btn-fill btn-danger" data-dismiss="modal">
                                <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_new_subrotulo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="title" style="color:#e34f49"><b>SUB GRUPO A PUNTO DE ROTULADO</b></h4>
                </div>
                <div class="modal-body" id="html_new_subrotulo"></div>
                <div class="modal-footer" style="text-align:end;">
                    <div class="btn-group">
                        <button type="button" class="btn btn-fill btn-danger" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-fill" id="btn_subrotulo">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Dv_verdocumentos">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">&nbsp;PDF&nbsp;</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="PDF_VERDOC"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_INFORMACION_ETIQUETA">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49"><i class="fa fa-wpforms" aria-hidden="true"></i>&nbsp;GESTI&Oacute;N DE MUESTRAS</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="HTML_INFORMACION_ETIQUETA"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>