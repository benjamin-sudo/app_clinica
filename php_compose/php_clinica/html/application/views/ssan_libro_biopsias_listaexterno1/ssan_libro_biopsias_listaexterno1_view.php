<input type="hidden" id="NUM_FASE" name="NUM_FASE" value="1"/>
<input type="hidden" id="IND_TEMPLETE" name="IND_TEMPLETE" value="ssan_libro_biopsias_listaexterno1"/>
<div class="header" style="padding-top:0;">
    <h4 class="title" style="color:#e34f49;margin-bottom:10px;"><b>TOMA DE MUESTRA | ROTULADO | CUSTODIA O TRASPORTE | ADMINISTRADOR</b></h4>
</div>

<hr style="margin:0px 0px 0px 0px">

<div class="css_rotulado_externo">
    <div class="css_rotulado_externo1"> 
        <!-- data-width="370px" -->
        <b style="color:#888888;">ORIGEN DEL SISTEMA *</b><br>
        <select class="selectpicker" data-width="100%" class="form-control input-sm" data-selected-text-format="count" data-size="8" data-live-search="true" name="viwes_origen_solicitud" id="viwes_origen_solicitud" onchange="changeviwes_origen_solicitud(this)">
            <?php
                echo $ind_opcion == 0 ? '<option value="0">TODOS LOS ORIGEN DE SOLICITUD</option>':'';
                if(count($return_bd[":C_DATA_ORIGEN_SIS"])>0){
                    foreach($return_bd[":C_DATA_ORIGEN_SIS"] as $i => $row ){
                        echo '<option value="'.$row["A"].'">'.$row["B"].'</option>';
                    }
                }
            ?>
        </select>
    </div>
    <div class="css_rotulado_externo5">
        <b style="color:#888888;">TODOS LOS TOMA DE MUESTRA *</b><br>
        <select class="selectpicker" data-width="100%" class="form-control input-sm"  data-selected-text-format="count" data-size="8" data-live-search="true" name="viwes_punto_entrega" id="viwes_punto_entrega" onchange="changeviwes_punto_entrega(this)">
            <?php
                echo $ind_opcion == 0 ? '<option value="0">TODOS PUNTO TOMA DE MUESTRA</option>':'';
                if(count($return_bd[":C_DATA_PUNTOS_ENTREGA"])>0){
                    foreach($return_bd[":C_DATA_PUNTOS_ENTREGA"] as $i => $row ){
                        echo '<option value="'.$row["V_ID_ROTULADO"].'">'.$row["V_TXT_OBSERVACION"].'</option>';
                    }
                } 
            ?>
        </select>
    </div>
    <div class="css_rotulado_externo2"> 
        <b style="color:#888888;">FECHA</b>
        <div id="date_tabla" class="input-group row_calendar" style="width:140px;">
            <input type="text" class="form-control input-sm" value="<?php echo $date_inicio;?>" id="numFecha" name="numFecha"/>
            <span class="input-group-addon input-group-text" style="cursor:pointer;" id="basic-addon1"><span class="fa fa-calendar"></span></span>
        </div>
    </div>
    <div class="css_rotulado_externo3 _CENTER">
        <input type="hidden" class="form-control input-sm" id="get_etiqueta" name="get_etiqueta" value="">
    </div>
    <div class="css_rotulado_externo4" style="text-align:inherit;"> 
        <b style="color:#888888;">OPCIONES</b><br>
        <div class="btn-group">
            <button type="button" class="btn btn-success btn-fill" id="BTN_DELETE_AP_GESPAB" onclick="update_main()">
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-info btn-fill" id="BTN_recepcion_custodia_masiva" onclick="recepcion_custodia_masiva()">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;CUSTODIA/TRASPORTE
            </button>
            <button type="button" class="btn btn-warning btn-fill" id="BTN_" onclick="js_config_etiqueta()">
                <i class="fa fa-question-circle-o" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-danger btn-fill" id="btn_" onclick="js_permiso_zebra()">
                <i class="fa fa-code" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>

<hr style="margin: 10px 0px 0px 0px;">

<ul id="LI_LISTA_MAIN" class="list-group" style="margin-bottom:0px;padding:9px;">
    <div class="CSS_GRID_EXTERNO_HEAD">
        <div class="div_1">
            <li class="gespab_group list-group-item list-group-item-primary active text-center" style="border-radius: 7px 7px 0px 0px;">
                <b class="text-center">RCE - EXTERNO</b> 
            </li>
        </div>
        <div class="div_2 text-center">&nbsp;</div>
        <div class="div_3">
            <li class="gespab_group list-group-item list-group-item-primary active text-center" style="border-radius: 7px 7px 0px 0px;">
                <b class="text-center">HERRAMIENTAS</b>
            </li>
        </div>
    </div>
    <li class="gespab_group list-group-item list-group-item-default active">
        <div class="CSS_GRID_PUNTO_ENTREGA_EXT">
            <div class="text-center"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
            <div class=""><b>INFO PACIENTE</b></div>
            <div class=""><b>DIAG/CX PROP</b></div>
            <div class=""><b>MEDICO</b></div>
            <div class=""><b>ANATOMIA</b></div>
            <div class="text-center"><b>ESTADO&nbsp;|&nbsp;MUESTRAS</b></div>
            <div class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></div>
            <div class="text-center"><i class="fa fa-archive" aria-hidden="true"></i></div>
            <div class="text-center"><i class="fa fa-print" aria-hidden="true"></i></div>
            <div class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            <div class="text-center"><i class="fa fa-check" aria-hidden="true"></i></div>
        </div>
    </li>
    <?php echo $html_externo["html_exteno"];?>
</ul>

<section>
    <div class="modal fade" id="MODAL_TEST_ETIQUETA">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="title" style="color:#e34f49">
                        <b>PRUEBA ETIQUETAS | ZEBRA ZD420</b>
                    </h4>
                </div>
                <div class="modal-body" id="HTML_TEST_ETIQUETA">
                    <div class="GRID_CONF_EQUIQUETA">
                        <div class="GRID_CONF_EQUIQUETA1">
                            <div class="card" style="margin: 0px 0px 0px 0px;">
                                <div class="header">
                                    <h4 class="title"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;<b>MEDIANA</b></h4>
                                    <p></p>
                                </div>
                                <div class="content" style="display: flex;justify-content: center;">
                                    <div style="overflow:hidden;">
                                        <div class="form-group d-flex justify-content-center">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="">
                                                        <a href="javascript:imprimirEtiqueta2(1)" style="opacity:0.5;color:#000;">
                                                            <i class="fa fa-barcode fa-4x" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="_CENTER3">
                                                            <b>MEDIANA&nbsp;(1)</b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="GRID_CONF_EQUIQUETA2">
                            <div class="card" style="margin: 0px 0px 0px 0px;">
                                <div class="header">
                                    <h4 class="title"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;<b>PEQUE&Ntilde;A</b></h4>
                                    <p></p>
                                </div>
                                <div class="content">
                                    <div style="overflow:hidden;">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="">
                                                        <!--
                                                            <a href="javascript:imprimirEtiqueta2(2)" style="opacity:0.5;color:#000;">
                                                                <i class="fa fa-barcode fa-4x" aria-hidden="true"></i>
                                                            </a> 
                                                        -->
                                                        <button type="button" class="btn btn-default btn-fill" id="test_equiqueta_left" style="height: 60px;width: 96px;" onclick="imprimirEtiqueta2(2)">
                                                            <i class="fa fa-barcode fa-4x" style="margin-left:-65px;" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="">
                                                        <b>PEQUE&Ntilde;A&nbsp;(LEFT)</b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="">
                                                        <!--
                                                            <a href="javascript:imprimirEtiqueta2(3)" style="opacity:0.5;color:#000;">
                                                                <i class="fa fa-barcode fa-4x" aria-hidden="true"></i>
                                                            </a>
                                                        -->
                                                        <button type="button" class="btn btn-default btn-fill" id="test_equiqueta_left" style="height:60px;width:96px;" onclick="imprimirEtiqueta2(3)">
                                                            <i class="fa fa-barcode fa-4x"  style="margin-left:-30px;" aria-hidden="true"></i>
                                                        </button>
                                                        <div class="">
                                                            <b>PEQUE&Ntilde;A&nbsp;(CENTER)</b> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer" style="text-align:end;">
                    <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_INFO_APLICATIVO">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="title" style="color:#e34f49">
                        <b>CONFIGURACI&Oacute;N DE ETIQUETA</b>
                    </h4>
                </div>
                <div class="modal-body" id="HTML_INFO_APLICATIVO">
                    <?php echo $this->load->view("ssan_libro_biopsias_listaexterno1/html_configuracion_frasco",[],true);?>
                </div>
                <div class="modal-footer" style="text-align:end;">
                    <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="MODAL_INFORME_EVENTOS_ADVERSOS">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="title" style="color:#e34f49">
                        <b>INFORMACI&Oacute;N DE ANTECEDENTES ADVERSOS</b>
                    </h4>
                </div>
                <div class="modal-body" id="HTML_INFORME_EVENTOS_ADVERSOS"></div>
                <div class="modal-footer" style="text-align:end;">
                    <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container_2" style="display:none" >
        <div class="item-a">HEADER</div>
        <div class="item-b">MAIN</div>
        <div class="item-c">SIDEBAR</div>
        <div class="item-d">FOOTER</div>
    </div>

    <div class="modal fade" id="modal_vista_zpl_to_pdf">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="title" style="color:#e34f49">
                        <b>ETIQUETA EN PDF</b>
                    </h4>
                </div>
                <div class="modal-body" id="html_vista_zpl_to_pdf">
                    <ul class="nav nav-tabs" role="tablist" id="ul_nav_tabs"></ul>
                    <div class="tab-content" id="tabs_tab_panel"></div>
                </div>
                <div class="modal-footer" style="text-align:end;">
                    <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-success btn-fill" id="BTN_DELETE_AP_GESPAB" onclick="consulta_(1927)" style="display:none">HOJA FAPH</button>
    <a href="#" class="btn-flotante" style="display:none">CONEXI&Oacute;N WEBSOCKET</a>
    <div class= "info_userdata" data-userdata="<?php echo htmlspecialchars(json_encode($this->session->userdata),ENT_QUOTES,'UTF-8');?>"></div>
    <form id="load_confirma_envio_recepcion" method="post" action="#"></form>
    <button type="button" class="btn btn-success btn-fill" id="btn_" onclick="test_envio()" style="display:none">TEST ENVIO</button>

    <style>
        @media(min-width    :   900px){
            .modal_xl_traza   {
                width       :   98%;
                height      :   85%;
                max-width   :   90%;
            }
        }
    </style>

    <div class="modal fade" id="modal_trazabilidad_biopsias">
        <div class="modal-dialog modal_xl_traza">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="title" style="color:#e34f49"><i class="fa fa-database" aria-hidden="true"></i>&nbsp;<b>TRAZABILIDAD DE BIOPSIAS</b></h4>
                </div>
                <div class="modal-body" id="html_trazabilidad_biopsias"></div>
                <div class="modal-footer" style="text-align:end;">
                    <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_FORM_ANATOMIA_PATOLOGICA">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">&nbsp;PDF&nbsp;</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="HTML_ANATOMIA_PATOLOGICA"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>
    
</section>

<section>
    <div class="modal fade" id="MODAL_INFORMACION_ETIQUETA">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">GESTI&Oacute;N DE MUESTRAS ANATOM&Iacute;A</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="HTML_INFORMACION_ETIQUETA"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>