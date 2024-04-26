<div 
    class               =   "info_userdata" 
    data-fecha_inicio   =   "<?php echo date("m/d/Y",$date_inicio);?>"
    data-fecha_final    =   "<?php echo date("m/d/Y",$date_final);?>"
    data-getdata        =   "<?php echo htmlspecialchars(json_encode($V_DATA),ENT_QUOTES,'UTF-8');?>"
    data-userdata       =   "<?php echo htmlspecialchars(json_encode($this->session->userdata),ENT_QUOTES,'UTF-8');?>"
></div>

<?php
    #echo isset($_cookie['id_anatomia'])?$_cookie['id_anatomia']:'';
    #echo "<br>";
    #echo date("d-m-Y H:i:s",time()-3600);
    #var_dump($_cookie); 
    #echo "<hr>";
    #var_dump($V_DATA);
    #echo "<hr>";
    #echo $status_bd;
    #echo "<hr>";
    #echo $val_estado;
    #echo "<hr>";
    #echo $ind_opcion;
    #echo "<hr>";
    #var_dump($BD); 
?>

<input type="hidden"    id="get_sala"           name="get_sala"     value="<?php echo $txt_sala;?>"/>
<input type="hidden"    id="SERVER_NAME"        name="SERVER_NAME"  value="<?php echo $_SERVER['SERVER_NAME'];?>"/>

<form id="load_ingreso_etapa_analitica"         method="post"       action="#"></form>
<form id="load_anuncios_anatomia_patologica"    method="post"       action="#"></form>
<form id="get_termino_sala_macroscopia"         method="post"       action="#"></form>
<form id="update_chat_x_hoja"                   method="post"       action="#"></form>

<div class="grid_head_body">
    <div class="grid_head_body1">
        <div class="GRID_LIBRO_BIOPSIAS_II_MAIN1">
            <h4 class="title" style="color:#e34f49;margin-left:13px;"><b id="txt_titulo_general"><?php echo $txt_titulo;?></b></h4>
        </div>
    </div>
    <div class="grid_head_body2">
        <?php echo $cookie;?>
        <div class="form-check" style="display:none">
            <label class="form-check-label" for="tipo_busqueda2">&nbsp;ETIQUETA&nbsp;
                <input class="form-check-input radio_busqueda" type="radio" name="tipo_busqueda" id="tipo_busqueda2"  style="display:inline;cursor:pointer;" value="1" checked>
            </label>
        </div>
    </div>
    <div class="grid_head_body5">
        <?php echo $ind_busqueda;?>
        <div class="form-check" style="display:none">
            <label class="form-check-label" for="tipo_busqueda1">&nbsp;PACIENTE&nbsp;
                <input class="form-check-input radio_busqueda" type="radio" name="tipo_busqueda" id="tipo_busqueda1" style="display:inline;cursor:pointer;" value="2" >
            </label>
        </div>
    </div>
    <div class="grid_head_body3" style="text-align:center;">
        <div class="grid_busqueda" style="display:none">
            <div class="opcion_bsq_etiqueta" >
                1.- OPCI&Oacute;N B&Uacute;SQUEDA POR ETIQUETA | <?php echo date("d-m-Y");?>
            </div>
            <div class="opcion_bsq_persona" style="display: none">
                2.- OPCI&Oacute;N B&Uacute;SQUEDA POR ETIQUETA | <?php echo date("d-m-Y");?>
            </div>
        </div>
    </div>
    <div class="grid_head_body4" style="text-align: end;">
        <div class="btn-group" style="padding-right:24px;">
            <button type="button" class="btn btn-success btn-fill"          id="btn_update_analitica"   onclick="update_etapaanalitica()">
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
            <?php if($txt_sala == 'analitica'){?>
                <!-- firma del patologo -->
                <button type="button" class="btn btn-danger btn-fill"       id="btn_update_analitica"    onclick="js_gestion_firma()">
                    <i class="fa fa-id-card-o" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-active btn-fill"       id="btn_test_anatomia"       onclick="js_test_ap()" style="display: none">
                    <i class="fa fa-archive" aria-hidden="true"></i>
                </button>
            <?php } ?>
            <?php if($txt_sala == 'analitica' || $txt_sala == 'salamacroscopia'){?>
            <button type="button" class="btn btn-primary btn-fill"          id="btn_update_analitica"   onclick="js_star_plantillas(0,'')">
                <i class="fa fa-comment" aria-hidden="true"></i>
            </button>
            <?php } ?>
            <button type="button" class="btn btn-info btn-fill"             id="btn_exel_final"         onclick="get_excel()">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-warning btn-fill"          id="btn_exel_closew"        onclick="ver_imagenes_min()">
                <i class="fa fa-arrows-h" aria-hidden="true"></i>
            </button>
        </div>
    </div>  
</div>
<hr style="margin: 8px 0px 10px 0px">
<div class="grid_etapaanalitica">
    <div class="grid_etapaanalitica_1">
        <ul role="tablist" class="nav nav-tabs tabs_main_analitica" role="menu" >
            <li role="presentation" style="cursor:pointer;">
                <a data-toggle="tab" href="#_panel_por_fecha"   class="_panel_por_fecha" data-titulo="B&Uacute;SQUEDA POR RANGO DE FECHAS" data-zona_li="busqueda_por_fecha"><i class="fa fa-calendar" aria-hidden="true"></i></a>
            </li>
            <li role="presentation" style="cursor:pointer;" id="li_panel_por_gestion"> <!-- display:none; -->
                <a data-toggle="tab" href="#_panel_por_gestion" class="_panel_por_gestion" data-titulo="B&Uacute;SQUEDA POR GESTI&Oacute;N" data-zona_li="busqueda_por_gestion"><i class="fa fa-search" aria-hidden="true"></i></a>
            </li>
            <li role="presentation panel_bacode" style="cursor:pointer;display:none;" id="li_panel_bacode_1">
                <a data-toggle="tab" href="#_busqueda_bacode"   class="_busqueda_bacode" data-titulo="B&Uacute;SQUEDA CODIGO DE BARRAS" data-zona_li="busqueda_por_codigo"><i class="fa fa-barcode" aria-hidden="true"></i></a>
            </li>
            <li role="presentation" style="cursor:pointer;display:none;" id="_busqueda_xpersona" >
                <a data-toggle="tab" href="#_busqueda_xpersona" class="li_busqueda_xpersona" data-titulo="B&Uacute;SQUEDA POR PERSONA" data-zona_li="busqueda_por_persona"><i class="fa fa-id-card-o" aria-hidden="true"></i></a>
            </li>
            <li role="presentation" class="dropdown" id="dropdown_opcionesgen">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;<span class="caret"></span></a>
                <ul class="dropdown-menu pull-center">
                    <li class="dropdown-header" style="border-left:1px solid #ececec;">&nbsp;</li>
                    <li class="dropdown-header" style="border-left:1px solid #ececec;">&nbsp;ETAPA ANAL&Iacute;TICA</li>
                    <li class="dropdown-header" style="border-left:1px solid #ececec;"><a href="javascript:update_etapaanalitica()"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;ACTUALIZAR LISTADO PRINCIPAL</a></li>
                    <li class="dropdown-header" style="border-left:1px solid #ececec;"><a href="javascript:get_excel()"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;EXCEL PRODUCCI&Oacute;N</a></li>
                    <li class="dropdown-header" style="border-left:1px solid #ececec;"><a href="javascript:delete_cookie()"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;ELIMINAR COOKIE</a></li>
                    <li class="dropdown-header" style="border-left:1px solid #ececec;"><a href="javascript:ver_cookie()"><i class="fa fa-beer" aria-hidden="true"></i>&nbsp;VER COOKIE</a></li>
                </ul>
            </li>
        </ul>
        <div class="tab-content">
            <div id="_panel_por_gestion" class="tab-pane fade">
                <div class="card" style="margin-bottom:0px;margin-top:-4px;padding:9px;">
                   <div class="grid_card_botonhistorial">
                        <div class="grid_card_botonhistorial1">
                            <div class="grid_pabel_tipo_busqueda">
                                <div class="grid_pabel_tipo_busqueda2">
                                    <input type="radio" name="ind_tipo_busqueda" id="busqueda_por_paciente" style="display:block;cursor:pointer;margin: 0px 0px 5px 0px;" checked="" onclick="js_vista_opcion_busqueda(this.id)" value="1">
                                </div>
                                <div class="grid_pabel_tipo_busqueda1">
                                    <label for="busqueda_por_paciente" style="cursor:pointer;color:#888888;">PACIENTE/RUN</label>
                                </div>
                                <div class="grid_pabel_tipo_busqueda4">
                                    <input type="radio" name="ind_tipo_busqueda" id="busqueda_por_n_biosia" style="display:block;cursor:pointer;margin: 0px 0px 5px 0px;" onclick="js_vista_opcion_busqueda(this.id)" value="2">
                                </div>
                                <div class="grid_pabel_tipo_busqueda3">
                                     <label for="busqueda_por_n_biosia" style="cursor:pointer;color:#888888;">N&deg; DE BIOPSIA</label>
                                </div>
                            </div>
                        </div>
                        <div class="grid_card_botonhistorial2">
                            <button type="button" class="btn btn-warning btn-fill" id="btn_historial" onclick="js_viwes_historial()" style="display:none">
                                <i class="fa fa-history" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <!--  -->
                    <input type="text" name="slc_automplete_biopsia" id="slc_automplete_biopsia" class="form-control input-sm solo_numero_busquedas" value="">
                </div>
                <!--
                <ul class="list-group list-group-flush" style="margin-bottom:0px;margin-top:-10px;">
                    <li class="list-group-item active" role="button" data-toggle="collapse" data-parent="#panel_altrapriopidad" href="#panel_altrapriopidad" aria-expanded="true" aria-controls="collapseOne">
                        <div class="grid_li_panel_central">
                            <div class="grid_li_panel_central1">Termino de solicitud</div> 
                            <div class="grid_li_panel_central2" style="text-align:end">
                                <i id="icono_panel_altrapriopidad" class="fa fa-sort-desc" aria-hidden="true" style="cursor:pointer;color:#fff;"></i>
                            </div> 
                        </div>
                    </li>
                    <div id="panel_altrapriopidad" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <li class="list-group-item" >
                            <div class="grid_li_panel_central">
                                <div class="grid_li_panel_central1" for="ind_rechazadas">Rechazada</div>
                                <div class="grid_li_panel_central2" style="text-align:-webkit-right;">
                                    <input type="checkbox" name="ind_filto_busqueda" id="ind_rechazadas" value="1" checked />
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" >
                            <div class="grid_li_panel_central">
                                <div class="grid_li_panel_central1" for="ind_terminadas">Terminadas</div>
                                <div class="grid_li_panel_central2" style="text-align:-webkit-right;">
                                    <input type="checkbox" name="ind_filto_busqueda" id="ind_terminadas" name="ind_filto_busqueda" value="1" checked />
                                </div>
                            </div>
                        </li>
                    </div>
                </ul>
                -->
            </div>
            <div id="_busqueda_bacode" class="tab-pane fade">
                <div class="grid_busqueda_bacode">
                    <div class="grid_busqueda_bacode1">&nbsp;</div>
                    <div class="grid_busqueda_bacode2">
                        <h6 class="title" style="margin-bottom:4px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;;margin-left:-7px;">ESC&Aacute;NER C&Oacute;DIGO</b>
                        </h6>
                        <div id="date_tabla_4" class="input-group" style="width:201px;">
                            <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                            <input type="text" id="get_etiqueta" name="get_etiqueta" class="focus_etiqueta form-control input-sm" autofocus="autofocus" value="" />
                            <span class="input-group-addon" >
                                <a href="javascript:busqueda_etiquera_analitica(0,'',{})" style="opacity:0.5;color:#000;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card" style="margin-bottom:6px;">
                    <div class="header">
                        <h5 class="title">
                            <i class="fa fa-search" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">HISTORIAL</b>
                        </h5>
                    </div>
                    <hr style="margin: 5px">
                    <div style="padding: 4px"> 
                        <ul class="list-group list-group-flush ul_lista_cod_encontrados" style="margin-bottom: 0px; padding: 0px">
                            <li class="list-group-item sin_buq_x_codigo"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;SIN B&Uacute;SQUEDA</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="_busqueda_xpersona" class="tab-pane fade">
                <div class="card" style="margin-bottom:6px;margin-top:-5px;padding:12px;">
                   <div class="grid_card_botonhistorial">
                        <div class="grid_card_botonhistorial1">
                            <h4 style="margin:0px 0px 0px 0px;">
                                <i style="color:#888888;" class="fa fa-search-plus" aria-hidden="true"></i>&nbsp;
                                <b style="color:#888888;">PACIENTE</b>
                            </h4>
                            <small><p>Minimo 3 Caracteres</p></small>
                        </div>
                        <div class="grid_card_botonhistorial2">
                            <button type="button" class="btn btn-warning btn-fill" id="btn_historial" onclick="js_viwes_historial()" style="display: none">
                                <i class="fa fa-history" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <input type="text" name="busuqeda_personas" id="busuqeda_personas" size="60" class="form-control input-sm" maxlength="60" value="" autocomplete="off">
                </div>
            </div>
            <div id="_panel_por_fecha" class="tab-pane fade ">
                <div class="card" style="margin-bottom:6px;margin-top:-5px;">
                    <div class="header" style="margin-bottom:15px;">
                        <h5 class="title">
                            <h5 class="title">
                                <i class="fa fa-calendar" style="color:#888888;" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">FECHA INICIO</b>
                            </h5>
                        </h5>
                    </div>
                    <div class="content" style="margin-top:-18px;"> 
                        <div style="overflow:hidden;">
                            <div class="form-group d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom:-20px;">
                                        <div id="fecha_out"></div>
                                    </div>
                                    <div class="col-md-12 LOAD_CALENDARIO" id="LOAD_CALENDARIO">
                                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                                        <span class="sr-only">Cargando ...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="margin-bottom: 0px;">
                    <div class="header" style="margin-bottom: 15px;">
                        <h5 class="title"><i class="fa fa-calendar" style="color:#888888;" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">FECHA FIN</b></h5>
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
        </div>
    </div>
    
    <div class="grid_etapaanalitica_2"> 
        <div class="grid_titulo_panel_main">
            <div class="grid_titulo_panel_main1">
                <!--
                <h5 style="margin-bottom:4px;">
                    <i class="fa fa-align-justify" aria-hidden="true" style="color:#888888;"></i>&nbsp;
                    <b style="color:#888888;">ANATOM&Iacute;A PAT&Oacute;LOGICA</b>
                </h5>
                -->
                <a href="#">N&deg; DE RESULTADOS&nbsp;<span class="badge n_resultados_panel" style="background-color:dodgerblue;"><?php echo $n_resultado;?></span></a>
            </div>
            <div class="grid_titulo_panel_main4">&nbsp;</div>
            <div class="grid_titulo_panel_main5">&nbsp;<!-- filtro de busqueda --></div>
            <div class="grid_titulo_panel_main3">
                <!-- dropup -->
                <div class="grid_filtro_panel_por_fecha">
                    <select class="selectpicker show-tick " multiple data-selected-text-format="count" data-size="11" name="ind_filtro_busqueda_xfechas" id="ind_filtro_busqueda_xfechas" data-width="100%" tabindex="-98">
                        <optgroup label="LISTA COMPLETA" data-max-options="1">
                            <option value="0" >TODAS LAS CATEGORIAS</option>
                        </optgroup>
                        <optgroup label="FILTRO POR ESTADO" data-max-options="8">
                            <option value="9" >SALA DE RECEPCI&Oacute;N | MACROSC&Oacute;PICA</option>
                            <option value="1" >SALA MACROSCOPICA</option>
                            <option value="2" >SALA PROCESO</option>
                            <option value="3" >SALA INCLUSI&Oacute;N</option>
                            <option value="4" >PROCESAMIENTO - SALA PROCESO</option>
                            <option value="5" >PROCESAMIENTO - SALA PROCESO | PROCESO</option>
                            <option value="6" >SALA DE TECNICAS (TECNOLOGO)</option>
                            <option value="7" >OFICIA PATOLOGO</option>
                            <option value="8" >FINALIZADO</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="grid_titulo_panel_main3">&nbsp;
                <div class="btn-group">
                    <button type="button" class="grid_filtro_panel_por_fecha btn btn-warning btn-fill"       id="delete_filtros"     onclick="js_desabilita_filtro_busqueda()">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="grid_titulo_panel_main2" style="text-align: -webkit-right;">
                <select id="ind_order_by" name="ind_order_by" style="width:auto;" class="form-control input-sm" onchange="update_etapaanalitica()">
                    <option value="0">N&deg; BIOPSIA - N&deg; CITOL&Oacute;GICO - N&deg; PAP</option>
                    <option value="1">N&deg; CITOL&Oacute;GICO - N&deg; PAP - N&deg; BIOPSIA</option>
                    <option value="2">N&deg; PAP - N&deg; BIOPSIA - N&deg; CITOL&Oacute;GICO</option>
                    <option value="3">FECHA DE TOMA DE MUESTRA</option>
                </select>
                <!--
                    <div id="txt_busqueda_titulo"></div>
                -->
            </div>
        </div>
        <hr style="margin: 8px 0px 10px 0px">
        <ul class="list-group lista_etapa_analitica busqueda_por_fecha" id="busqueda_por_fecha" style="padding-right:5px;">
            <?php echo $HTML_LI["return_html"];?> 
        </ul>
        <ul class="list-group lista_etapa_analitica busqueda_por_gestion" id="busqueda_por_gestion" style="padding-right:5px;">
            <?php echo $HTML_LI["return_por_gestion"];?> 
        </ul>
        <ul class="list-group lista_etapa_analitica busqueda_por_codigo" id="busqueda_por_codigo" style="padding-right:5px;">
            <?php echo $HTML_LI["return_por_codigo"];?> 
        </ul>
        <ul class="list-group lista_etapa_analitica busqueda_por_persona" id="busqueda_por_persona" style="padding-right:5px;">
            <?php echo $HTML_LI["return_por_persona"];?> 
        </ul>
    </div>
    <div class="grid_etapaanalitica_3" style="display:none"> 
        <div class="card" style="margin-bottom: 6px;">
            <div class="header" style="margin-bottom: 15px;">
                <h5 class="title"><i class="fa fa-file-image-o" aria-hidden="true"></i>&nbsp;<b>IMAGENES</b></h5>
            </div>
            <div style="margin-top: -30px;" id="html_imagenes"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="MODAL_FORMULARIO_ANALITICA">
    <div class="modal-dialog modal_xl_900">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">ETAPA&nbsp;ANAL&Iacute;TICA</b></h4>
            </div>
            <div class="modal-body" id="HTML_FORMULARIO_ANALITICA"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1">
                        <button type="button" class="btn btn-warning btn-fill" id="btn_exel_final" onclick="get_excel()">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn2">
                        <button type="button" class="btn btn-info btn-fill" id="btn_guardado_previo">
                            <i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp;GUARDADO&nbsp;PREVIO&nbsp;
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn3">
                        <button type="button" class="btn btn-success btn-fill" id="btn_finaliza_rce_anatomia" disabled>
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;FINALIZA&nbsp;REPORTE&nbsp;
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_descipcion_muestras">
    <div class="modal-dialog modal_xl_900">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;">
                    <b style="color:#e34f49">SALA MACROSC&Oacute;PICA</b>
                </h4>
            </div>
            <div class="modal-body" id="html_descipcion_muestras"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1">&nbsp;&nbsp;</div>
                    <div class="grid_modal_footer_btn2">&nbsp;</div>
                    <div class="grid_modal_footer_btn3">
                        <button type="button" class="btn btn-success btn-fill" id="btn_graba_descipcion_muestras">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_sala_tecnicas">
    <div class="modal-dialog modal_xl_900">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">SALA T&Eacute;CNICAS</b></h4>
            </div>
            <div class="modal-body" id="html_sala_tecnicas"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1">&nbsp;</div>
                    <div class="grid_modal_footer_btn2">
                        <button type="button" class="btn btn-info btn-fill" id="btn_previo_sala_tecnicas">
                            <i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp;GUARDADO&nbsp;PREVIO&nbsp;
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn3">
                        <button type="button" class="btn btn-success btn-fill" id="btn_graba_tecnicas">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;TERMINO&nbsp;INFORME
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_informacion_adminisrativo">
    <div class="modal-dialog modal_xl_900">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">INFORMACI&Oacute;N COMPLEMENTARIA</b></h4>
            </div>
            <div class="modal-body" id="html_informacion_adminisrativo"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1">&nbsp;</div>
                    <div class="grid_modal_footer_btn2">&nbsp;</div>
                    <div class="grid_modal_footer_btn3">
                        <button type="button" class="btn btn-success btn-fill" id="btn_informacion_adminisrativo">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pdf_fullscreen">
    <div class="modal-dialog modal_xl_pdf">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">PDF</b></h4>
            </div>
            <div class="modal-body" id="html_pdf_fullscreen"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1">&nbsp;</div>
                    <div class="grid_modal_footer_btn2">&nbsp;</div>
                    <div class="grid_modal_footer_btn3">&nbsp;</div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_perfil_administrativo">
    <div class="modal-dialog modal_xl_900">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">PERFIL ADMINISTRATIVO</b></h4>
            </div>
            <div class="modal-body" id="html_perfil_administrativo"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1">&nbsp;</div>
                    <div class="grid_modal_footer_btn2">&nbsp;</div>
                    <div class="grid_modal_footer_btn3">
                        <button type="button" class="btn btn-success btn-fill" id="btn_perfil_administrativo">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_star_sala_proceso">
    <div class="modal-dialog modal_xl_900">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">SALA DE PROCESO</b></h4>
            </div>
            <div class="modal-body" id="html_star_sala_proceso"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1">&nbsp;</div>
                    <div class="grid_modal_footer_btn2">&nbsp;</div>
                    <div class="grid_modal_footer_btn3">
                        <button type="button" class="btn btn-success btn-fill" id="btn_star_sala_proceso">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal_plantillas_macro_micro">
    <div class="modal-dialog modal_plantillas">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">DESCRIPCI&Oacute;N DE MUESTRAS + PLANTILLAS</b></h4>
            </div>
            <div class="modal-body" id="html_plantillas_macro_micro"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1" style="text-align: initial;">
                        <button type="button" class="btn btn-warning btn-fill" id="btn_nueva_plantilla">
                            <i class="fa fa-certificate" aria-hidden="true"></i>&nbsp;NUEVA&nbsp;PLANTILLA
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn2">&nbsp;</div>
                    <div class="grid_modal_footer_btn3">&nbsp;
                        <button type="button" class="btn btn-success btn-fill" id="btn_guarda_descripcion">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_nueva_plantilla">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">NUEVA PLANTILLA</b></h4>
            </div>
            <div class="modal-body" id="html_nueva_plantilla"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1">&nbsp;</div>
                    <div class="grid_modal_footer_btn2">&nbsp;</div>
                    <div class="grid_modal_footer_btn3">
                        <button type="button" class="btn btn-success btn-fill" id="btn_new_plantilla_individual">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_gestion_firma_patologo">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">FIRMA DEL PAT&Oacute;LOGO</b></h4>
            </div>
            <div class="modal-body" id="html_gestion_firma_patologo"></div>
            <div class="modal-footer">
                <div class="grid_modal_footer_btn">
                    <div class="grid_modal_footer_btn1">&nbsp;</div>
                    <div class="grid_modal_footer_btn2">&nbsp;</div>
                    <div class="grid_modal_footer_btn3"></div>
                    <div class="grid_modal_footer_btn4">
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="button" id="test_pdf" value="test pdf" onclick="test_pdf(768)" style="display: none"> 

<div id="get_html_pdf"></div>
<div id="respuesta_familia"></div>
<div id="get_html_macroscopica"></div>
<span id="nombre_nomina"></span>

<!-- PDF 2 
    ;
-->
<div class="modal fade" id="Dv_verdocumentos" style="z-index: 1602;overflow-y: scroll;" data-backdrop="static">  
    <div class="modal-dialog modal-xl3" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header"><button type="button" class="close" data-dismiss="modal"  aria-hidden="true">&times;</button>
                <h3 class="modal-title"><b>PDF DOCUMENTOS</b></h3>
            </div>
            <div class="modal-body" id="PDF_VERDOC"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-fill btn-sm" data-dismiss="modal">CIERRA VENTANA</button>
            </div>
        </div>
    </div>
</div>

<!--
<hr>
<table style="width:100%;margin: 0px 0px 0px 0px" >
    <tbody>
        <tr style="margin: 0px 0px 0px 0px">
             <td style="width: 10%;text-align: right;"> 
                 <img 
                     alt                     =   "64x164" 
                     class                   =   "img-thumbnail" 
                     data-src                =   "64x164" 
                     src                     =   "/assets/ssan_libro_biopsias_usuarioext/img/logo_100.png" 
                     data-holder-rendered    =   "true" 
                     style                   =   "width:90px;height:80px;margin: 0px 0px 0px 0px">
             </td>
             <td style="width: 90%;text-align: center">
                 <img 
                     alt                     =   "200x110" 
                     class                   =   "img-thumbnail" 
                     data-src                =   "200x110" 
                     src                     =   "c" 
                     data-holder-rendered    =   "true" 
                     style                   =   "width:400px;height:75px;">
                 <br style="margin: 0px 0px 0px 0px">
                 <h6 style="margin: 0px 0px 0px 0px">DR: nbenjamin castillo sepulveda | ANATOMO PATOLOGO</h6>
             </td>
        </tr>
    </tbody>
 </table>
-->