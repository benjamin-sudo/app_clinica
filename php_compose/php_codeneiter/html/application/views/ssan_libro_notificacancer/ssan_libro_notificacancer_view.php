<input type="hidden" id="ind_pagina" name="ind_pagina" value="notificacancer"/>

<div class="grid_head_notificacion">
    <div class="grid_head_body1">
        <div class="GRID_LIBRO_BIOPSIAS_II_MAIN1">
            <h4 class="title" style="color:#e34f49;margin-left:13px;">
                <i class="fa fa-check" aria-hidden="true"></i>
                <b id="txt_titulo_general">NOTIFICACI&Oacute;N DE C&Aacute;NCER A SERVICIOS</b>
            </h4>
        </div>
    </div>
    <div class="grid_head_body3"  style=" text-align: end;">
         <div class="btn-group">
            <button type="button" class="btn btn-info btn-fill" id="btn_update_analitica" onclick="listado_notifica_cancer(<?php echo date('Y');?>)">
                <i class="fa fa-list-ul" aria-hidden="true"></i>
            </button>
         </div>
    </div>
    <div class="grid_head_body2" style=""> 
        <div class="btn-group">
            <button type="button" class="btn btn-success btn-fill" id="btn_update_analitica" onclick="update_etapaanalitica_cancer_edicion()">
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
        </div>
        <button type="button" class="btn btn-danger btn-fill" id="btn_exel_closew" onclick="js_limpia_regustros()" style="display: none">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
        </button>
    </div>
</div>
<hr style="margin: 0px 0px 0px 0px">
<div class="grid_body_notificacion">
    <div class="grid_body_notificacion1">
        <div class="card card_pading">
            <div class="grid_row_busqueda">
                <div class="grid_row_busqueda1">
                    <h5 class="title"><i class="fa fa-search" style="color:#888888;" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">B&Uacute;SQUEDA ANATOMIA</b></h5>
                    <p>Seleccione solicitud con diagn&oacute;stico de c&aacute;ncer</p>
                </div>
                <div class="grid_row_busqueda2">
                    <div class="grid_pabel_tipo_busqueda">
                        <div class="grid_pabel_tipo_busqueda2">
                            <input type="radio" name="ind_tipo_busqueda" id="busqueda_por_paciente" style="display:block;cursor:pointer;margin: 6px 0px 5px 0px;" checked="" onclick="js_vista_opcion_busqueda(this.id)" value="1">
                        </div>
                        <div class="grid_pabel_tipo_busqueda1">
                            <label for="busqueda_por_paciente" style="cursor:pointer;color:#888888;">PACIENTE / RUN</label>
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
                </div>
            </div>
        </div>
    </div>
    <div class="grid_body_notificacion2">
        <div class="get_table_gestion"></div> 
    </div>
</div>

<div class="modal fade" id="modal_notificacion_cancer">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">NOTIFICACI&Oacute;N DE CANCER</b></h4>
            </div>
            <div class="modal-body" id="html_notificacion_cancer"></div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                       <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-fill" id="btn_envia_correo">
                       <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pdf_notificacion_cancer">
    <div class="modal-dialog modal_xl_900">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h3 class="modal-title" style="color:#e34f49"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></h3>
            </div>
            <div class="modal-body" id="html_pdf_notificacion_cancer"></div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                       <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
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

<div class="modal fade" id="modal_listado_notificado">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="margin: 0px 0px 0px 0px;"><b style="color:#e34f49">LISTADO NOTIFICACI&Oacute;N DE C&Aacute;NCER</b></h4>
            </div>
            <div class="modal-body" id="html_listado_notificado"></div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">
                       <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>