<div class="PANEL_MAIN">
    <div class="DIV_LEFT">
        <h4 class="title" style="color : #e34f49;margin-left: 20px;margin-bottom:10px;">
            <b>PANEL DE SOLICITUD EXTERNO DE ANATOM&Iacute;A PATOL&Oacute;GICA</b>
        </h4>
    </div>
    <div class="DIV_RIGHT">
        <div class="btn-group">
            <button type="button" class="btn btn-success btn-fill" id="BTN_UPDATE_PANEL_1" onclick="ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(2);">
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-info btn-fill" id="btn_informacion_sistema" onclick="js_busquedapacientes(1)" style="display:none">
                <i class="fa fa-user-plus" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-warning btn-fill" id="btn_informacion_sistema" onclick="$(&quot;#MODAL_INFO_SIS&quot;).modal(&quot;show&quot;);" style="display: none">
                <i class="fa fa-question-circle-o" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-info btn-fill" id="btn_informacion_sistema" onclick="nueva_solicitud_anatomia(null,null)">
                <i class="fa fa-user-plus" aria-hidden="true"></i><b>&nbsp;NUEVA&nbsp;SOLICITUD&nbsp;ANATOMIA&nbsp;(SIN&nbsp;CITA)</b>
            </button>
        </div>
    </div>
</div>

<hr style="margin: 0px 0px 8px 0px;">

<div class="grid_body_panel">
    <div class="grid_body_panel1" style="padding: 10px;">
        <div class="card" id="card_fechas">
            <div class="card-body">
                <h5 class="card-title"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>FECHA</b></h5>
                <br>
                <h6 class="">Seleccione fecha</h6>
                <div class="content" style="margin-bottom: 20px;">
                    <div id="fecha_out"></div>
                </div>
                <div class="grid_buton">
                    <div class="grid_buton1">&nbsp;</div>
                    <div class="grid_buton1"> 
                        <div class="btn-group">
                            <button type="button" class="btn btn-small btn-success btn-fill" id="plan_1" onclick="ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(1)" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="ACTUALIZAR DIA">
                                <i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;
                            </button>
                            <button type="button" class="btn btn-small btn-warning btn-fill" style="display: none" id="plan_2" onclick="ver_calendario(1)" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="VER CALENDARIO">
                                <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
                            </button>
                            <button type="button" class="btn btn-small btn-info btn-fill" id="plan_1" onclick="nueva_solicitud_anatomia(null,null)" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="NUEVA SOLICITUD">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;
                            </button>
                        </div>
                    </div>
                    <div class="grid_buton1">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid_body_panel2" style="padding: 10px;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">MIS SOLICITUDES ANATOM&Iacute;A PATOL&Oacute;GICA</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="card" style="margin-top: 8px;">
                    <div class="grid_panel_header">
                        <div class="grid_panel_header1">
                            <h5 class="title"><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;<b>LISTADO DE NUEVAS SOLICITUDES</b></h5>
                        </div>
                        <div class="grid_panel_header2">
                            <h5 id="txt_fecha_panel_5" style="margin: 0px 0px 0px 0px;"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b><?php echo date("d-m-Y");?></b></h5>
                        </div>
                    </div>
                    <table class="table table-striped" id="TABLE_ID_5" style="margin-bottom: 0px;">
                        <thead>
                            <tr>
                                <th width="2%"  scope="col" style="height: 40px;">#</th>
                                <th width="20%" scope="col">INFO. PACIENTE</th>
                                <th width="20%" scope="col">INFO. MEDICO</th>
                                <th width="20%" scope="col">DATOS SOLICITUD</th>
                                <th width="15%" scope="col" style="text-align: center">ESTADO</th>
                                <th width="15%" scope="col" style="text-align: center">FECHA</th>
                                <th width="4%"  scope="col" style="text-align: center"><i class="fa fa-info-circle" aria-hidden="true"></i></th>
                                <th width="4%"  scope="col" style="text-align: center"><i class="fa fa-cog" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody id="RETURN_DATA_5">
                            <?php echo $HTML_SOLICITUDEAP;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>    

<section>
    
    <div class="modal fade" id="MODAL_INICIO_SOLICITUD_ANATOMIA">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="title" style="color:#e34f49">
                        <b>SOLICITUD ANATOM&Iacute;A PATOL&Oacute;GICA</b>
                        <p class="category">Divida un flujo complicado en varios pasos</p>
                    </h4>
                </div>
                <div class="modal-body" id="HTML_SOLICITUD_ANATOMIA"></div>
                <div class="modal-footer" style="text-align: start;">
                    <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_PDF_ANATOMIA_PATOLOGICA">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><b>PDF</b></h3>
                </div>
                <div class="modal-body" id="HTML_PDF_ANATOMIA_PATOLOGICA"></div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-fill btn-sm" data-dismiss="modal">CIERRA VENTANA</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_CALENDARIO_RESUMENSOLICITUDES">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><b>PDF</b></h3>
                </div>
                <div class="modal-body" id="HTML_CALENDARIO_RESUMENSOLICITUDES"></div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-fill btn-sm" data-dismiss="modal">CIERRA VENTANA</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_INFO_SIS">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><b>INFORMACI&Oacute;N</b></h3>
                </div>
                <div class="modal-body" id="HTML_MODAL_INFO_SIS">
                    <div class="alert alert-success" role="alert">
                        <b>B&Uacute;SQUEDA DE SOLICITUDES DESDE | GESPAB - RCE - EXTERNO</b>
                    </div>
                    <div class="alert alert-danger" role="alert">
                        THIS IS A DANGER ALERT—CHECK IT OUT! 
                    </div>
                    <div class="alert alert-warning" role="alert">
                        THIS IS A WARNING ALERT—CHECK IT OUT!
                    </div>
                    <div class="alert alert-info" role="alert">
                        THIS IS A INFO ALERT—CHECK IT OUT!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-fill btn-sm" data-dismiss="modal">CIERRA VENTANA</button>
                </div>
            </div>
        </div>
</div>

    <div class="modal fade" id="MODAL_BUSQUEDA_PACIENTE">
        <div class="modal-dialog modal_xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><b>BUSQUEDA_PACIENTE</b></h3>
                </div>
                <div class="grid_panel_paciente">
                    <div class="grid_pabel1">
                        <div class="modal-body" id="HTML_BUSQUEDA_PACIENTE"></div>
                    </div>
                    <div class="grid_pabel2">
                        <div class="modal-body" id="HTML_BUSQUEDA_PACIENTE2">
                            <div class="card" id="card_lista_pacientes">
                                <div class="header">
                                    <h4 class="title"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;&nbsp;<b>LISTA DE PACIENTES</b></h4>
                                    <p>Lista de pacientes para actividad grupal </p>
                                </div>
                                <div class="content">
                                    <div class="alert alert-danger" role="alert" id="alerta_sin_paciente">
                                        Sin pacientes selecionados
                                    </div>
                                    <ul class="list-group" id="ul_lista_pacientes" style="margin-bottom:0px;" style="display: none"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-fill btn-sm" data-dismiss="modal">x</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Dv_verdocumentos" style=" z-index: 1602;overflow-y: scroll;" data-backdrop="static">  
        <div class="modal-dialog modal-xl3" style="width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><b>PDF DOCUMENTOS</b></h3>
                </div>
                <div class="modal-body" id="PDF_VERDOC"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-fill btn-sm btn-danger "  data-dismiss="modal">CIERRA VENTANA</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_edita_fecha" style=" z-index: 1602;overflow-y: scroll;" data-backdrop="static">  
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><b style="color : #e34f49;">EDITA FECHA SOLICITUD</b></h3>
                </div>
                <div class="modal-body" id="html_edita_fecha">
                    <!-- Date input field -->
                    <div class="grid_edita_fecha">
                        <div class="grid_edita_fecha1">
                            <label for="date">NUEVA FECHA DE SOLICITUD</label>
                            <input type="date" class="form-control input-sm" id="date" name="date" style="width: 122px;" value=""/>
                        </div>
                        <div class="grid_edita_fecha1">
                            <button type="button" id="btn_confirmar_fecha" class="btn btn-info btn-xs  btn-fill" style="display: inline-block;">
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
