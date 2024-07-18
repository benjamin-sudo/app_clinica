<h4 class="title" style="color:#e34f49;margin-left:13px;margin-bottom: 11px;">
    <i class="fa fa-check" aria-hidden="true"></i><b id="txt_titulo_general">LISTADO DE CANCER</b>
</h4>
<div class="grid_listado_cancer card">
    <div class="grid_listado_cancer1"></div>
    <div class="grid_listado_cancer2 return_table"></div>
    <div class="grid_listado_cancer3"></div>
</div>

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


</section>