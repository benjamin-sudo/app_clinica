<input type="hidden" id="ind_pagina" name="ind_pagina" value="edicionsolicitudbiopsia"/>

<div class="grid_head_notificacion">
    <div class="grid_head_body1">
        <div class="GRID_LIBRO_BIOPSIAS_II_MAIN1">
            <h4 class="title" style="color:#e34f49;margin-left:13px;">
                <i class="fa fa-exclamation" aria-hidden="true"></i>
                <b id="txt_titulo_general">&nbsp;EDICI&Oacute;N SOLICITUDES DE ANATOM&Iacute;A PATOL&Oacute;GICA</b>
            </h4>
        </div>
    </div>
    <div class="grid_head_body2" style=""> 
        <div class="btn-group" style="padding-right:24px;">
            <button type="button" class="btn btn-success btn-fill" id="btn_update_analitica" onclick="update_etapaanalitica_cancer_edicion()">
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-danger btn-fill" id="btn_exel_closew" onclick="js_limpia_regustros()" style="display: none">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>

<hr style="margin: 0px 0px 0px 0px">

<div class="grid_body_notificacion">
    <div class="grid_body_notificacion1">
        <div class="card card_pading">
            <div class="grid_row_busqueda">
                <div class="grid_row_busqueda1">
                    <h5 class="title"><i class="fa fa-search" style="color:#888888;" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">B&Uacute;SQUEDA ANATOMIA</b></h5>
                    <p style="margin-bottom: 0px;">Seleccione solicitud de anatomia para edici&oacute;n de informaci&oacute;n</p>
                </div>
                <div class="grid_row_busqueda2">
                    <div class="grid_pabel_tipo_busqueda">
                        <div class="grid_pabel_tipo_busqueda2">
                            <input type="radio" name="ind_tipo_busqueda" id="busqueda_por_paciente" style="display:block;cursor:pointer;margin: 6px 0px 5px 0px;" checked="" onclick="js_vista_opcion_busqueda(this.id)" value="1">
                        </div>
                        <div class="grid_pabel_tipo_busqueda1">
                            <label for="busqueda_por_paciente" style="cursor:pointer;color:#888888;">PACIENTE</label>
                        </div>
                        <div class="grid_pabel_tipo_busqueda4">
                            <input type="radio" name="ind_tipo_busqueda" id="busqueda_por_n_biosia" style="display:block;cursor:pointer;margin: 6px 0px 5px 0px;" onclick="js_vista_opcion_busqueda(this.id)" value="2">
                        </div>
                        <div class="grid_pabel_tipo_busqueda3">
                             <label for="busqueda_por_n_biosia" style="cursor:pointer;color:#888888;">N&deg; DE BIOPSIA</label>
                        </div>
                    </div>
                </div>
                <div class="grid_row_busqueda3">
                    <input type="text" name="slc_automplete_biopsia" id="slc_automplete_biopsia" class="form-control input-sm solo_numero_busquedas" value="" disabled size="35" max="35" maxlength="35" />
                    <!--
                        <input type="text" name="slc_automplete_biopsia" id="slc_automplete_biopsia" class="form-control input-sm solo_numero_busquedas" value="" disabled>
                    -->
                </div>
            </div>
        </div>
    </div>
    <div class="grid_body_notificacion2">
        <div class="get_table_gestion"></div> 
    </div>
</div>





<div class="modal fade" id="Dv_verdocumentos" style=" z-index: 1602;overflow-y: scroll;" data-backdrop="static">  
    <div class="modal-dialog modal_xl_900" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" style="color:#e34f49"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></h3>
            </div>
            <div class="modal-body" id="HTML_PDF_ANATOMIA_PATOLOGICA"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-fill btn-sm btn-danger "  data-dismiss="modal">CIERRA VENTANA</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal_historial_cambios" style=" z-index: 1602;overflow-y: scroll;" data-backdrop="static">  
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" style="color:#e34f49"><i class="fa fa-database" aria-hidden="true"></i></h3>
            </div>
            <div class="modal-body" id="html_historial_cambios2"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-fill btn-sm btn-danger "  data-dismiss="modal">CIERRA VENTANA</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_modifica_fechas" style=" z-index: 1602;overflow-y: scroll;" data-backdrop="static">  
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" style="color:#e34f49"><b>EDICI&Oacute;N DE FECHAS</b></h3>
            </div>
            <div class="modal-body" id="html_modifica_fechas"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-fill btn-sm btn-danger "  data-dismiss="modal">CIERRA VENTANA</button>
            </div>
        </div>
    </div>
</div>

<section>
    <div class="modal fade" id="modal_edita_macro" style=" z-index: 1602;overflow-y: scroll;" data-backdrop="static">  
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" style="color:#e34f49"><b>EDICI&Oacute;N FECHA MICROSCOPIA</b></h3>
                </div>
                <div class="modal-body" id="html_edita_macro">
                    <div class="grid_fecha_hora">
                        <div class="grid_fecha_hora1">
                        <input type="date" class="form-control input-sm grupo_time_pab" id="new_fecha_macrocopica" name="new_fecha_macrocopica" min="<?php echo date('Y-m-d', strtotime('-1 month'));?>" max="<?php echo date('Y-m-d');?>" value="">
                        </div>
                        <div class="grid_fecha_hora2">
                            <input type="time" class="form-control input-sm" style="width: 115px;" id="new_hora_macrocopica" name="new_hora_macrocopica" maxlength="5" size="5" value="">
                        </div>
                        <div class="grid_fecha_hora3">
                            <button type="button" class="btn btn-success btn-fill" id="btn_update_macrocopica">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-fill btn-sm btn-danger "  data-dismiss="modal">CIERRA VENTANA</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section>

    <div class="modal fade" id="modal_pdf_notificacion_cancer">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">&nbsp;PDF&nbsp;</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="html_pdf_notificacion_cancer"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edicion_numero_biopsia">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 95%; width: 95%;">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">&nbsp;EDICI&Oacute;N ANATOM&Iacute;A PATOL&Oacute;GICA&nbsp;</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="html_edicion_numero_biopsia"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>
