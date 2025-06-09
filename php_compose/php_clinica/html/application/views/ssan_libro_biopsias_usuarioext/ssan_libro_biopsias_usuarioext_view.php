
<div class="PANEL_MAIN">
    <div class="DIV_LEFT">
        <h4 class="title" style="color : #e34f49;margin-left: 20px;margin-bottom:10px;"><b>PANEL DE SOLICITUD ANATOM&Iacute;A PATOL&Oacute;GICA</b></h4>
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
                <i class="fa fa-user-plus" aria-hidden="true"></i><b>&nbsp;NUEVA&nbsp;SOLICITUD&nbsp;ANATOMIA&nbsp;</b>
            </button>
        </div>
    </div>
</div>
<div class="grid_body_panel">
    <div class="grid_body_panel1" style="padding: 10px;">
        <div class="card" id="card_fechas">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>FECHA</b>
                </h5>
                <br>
                <h6 class="">Seleccione fecha</h6>
                <div class="content" style="margin-bottom: 20px;">
                    <div id="fecha_out"></div>
                </div>
                <hr>
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
                                <th width="20%" scope="col">INFO PACIENTE</th>
                                <th width="20%" scope="col">INFO MEDICO</th>
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
<?php #echo date('Y-m-d H:i:s'); ?>
<section>
    <div class="modal fade" id="MODAL_INICIO_SOLICITUD_ANATOMIA">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">
                        <i class="fa fa-wpforms" aria-hidden="true"></i>&nbsp;SOLICITUD ANATOM&Iacute;A PATOL&Oacute;GICA</b>
                    </h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="HTML_SOLICITUD_ANATOMIA"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_CALENDARIO_RESUMENSOLICITUDES">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b>PDF</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                                    <p>Lista de pacientes para actividad grupal</p>
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

    <div class="modal fade" id="Dv_verdocumentos">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 95%; width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49"><i class="fa fa-wpforms" aria-hidden="true"></i>&nbsp;PDF</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="PDF_VERDOC"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-fill" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CIERRA&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edita_fecha">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">
                        <i class="fa fa-wpforms" aria-hidden="true"></i>&nbsp;NUEVA FECHA DE SOLICITUD</b>
                    </h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="html_edita_fecha">
                    <div class="grid_edita_fecha">
                        <div class="grid_edita_fecha1">
                            <label for="date">NUEVA FECHA DE SOLICITUD</label>
                            <input type="date" class="form-control input-sm" id="date" name="date" style="width: 122px;" value=""/>
                        </div>
                        <div class="grid_edita_fecha1">
                            <button type="button" id="btn_confirmar_fecha" class="btn btn-success" style="display: inline-block;margin-top: 30px;">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_PDF_ANATOMIA_PATOLOGICA">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">&nbsp;PDF&nbsp;</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="HTML_PDF_ANATOMIA_PATOLOGICA"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_nuevo_paciente">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;NUEVO PACIENTE</b>
                    </h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="html_nuevo_paciente">

                    <table class="table" cellspacing="0" width="94%">
                        <tr class="formulario">
                            <td width="33%"><label class="control-label"><b>RUN</b>&nbsp;</td>
                            <td width="67%">
                                <div class="grid_inscribe_visitante">
                                    <div class="grid_inscribe_visitante1"><input type="text" class="form-control input-sm" id="txt_new_run" name="txt_new_run" style="width:120px;"></div>
                                    <div class="grid_inscribe_visitante2">
                                        <button type="button" class="btn btn-info btn-fill" id="btn_incribe_visita" style="margin-bottom:2px;">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td><b>Nombres</b></td>
                            <td>
                                <input type="text" class="form-control input-sm" id="txtNombre" name="txtNombre" value="" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="25">
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td><b>Apellido Paterno</b></td>
                            <td>
                                <input type="text" class="form-control input-sm" id="txtApellidoPaterno" value="" name="txtApellidoPaterno" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="20">
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>
                                <b>Apellido materno</b>
                            </td>
                            <td>
                                <input type="text" class="form-control input-sm" id="txtApellidoMaterno" name="txtApellidoMaterno" value=""  style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="20">
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>
                                <b>Fecha de nacimiento</b>
                            </td>
                            <td>
                                <input type="date" class="form-control input-sm" id="txtFechaNacimineto" name="txtFechaNacimineto" max="<?php echo date('Y-m-d');?>" min="<?php echo date('Y-m-d', strtotime('-120 years'));?>" style="width: 132px;">
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>
                                <b>Sexo</b>
                            </td>
                            <td> 
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rdosexo" id="rdosexo1" value="M" checked>
                                    <label class="form-check-label" for="rdosexo1">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rdosexo" id="rdosexo0"  value="F">
                                    <label class="form-check-label" for="rdosexo0">Femenino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rdosexo" id="rdosexo3"  value="N">
                                    <label class="form-check-label" for="rdosexo3">No Determinado</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rdosexo" id="rdosexo4"  value="D">
                                    <label class="form-check-label" for="rdosexo4">Desconocido</label>
                                </div>
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>
                                <b>Estado Civil</b>
                            </td>
                            <td> 
                                <select class="form-select" id="estado_civil" name="estado_civil" class="form-control">
                                    <option value="0">Seleccione</option>
                                    <option value="S">Soltero</option>
                                    <option value="C">Casado</option>
                                    <option value="V">Viudo</option>
                                    <option value="O">Conviviente</option>
                                    <option value="E">Separado</option>
                                    <option value="E">Divorciado</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="formulario" >
                            <td>
                                <b>Direcci&oacute;n</b>
                            </td>
                            <td>
                                <input type="text" class="form-control input-sm" name="txtDireccion" id="txtDireccion" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="100">
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>
                                <b>N&deg;</b>
                            </td>
                            <td>
                                <input type="text" class="form-control input-sm" name="txtNum_dire"  id="txtNum_dire" onKeyPress="return IsNumber(event);" style="width: 64%;" maxlength="6">
                                0 Para "s/n". 
                            </td>
                        </tr>

                        <tr class="formulario">
                            <td><b>Celular</b></td>
                            <td>
                                <input type="text" class="form-control input-sm" name="t_celular" id="t_celular" onKeyPress="return IsNumber(event);" style="width: 64%;" maxlength="9">
                            </td>
                        </tr>
                        <tr class="formulario" >
                            <td>
                                <b>Calidad Previsional</b>
                            </td>
                            <td>
                                <select class="form-select" name="cboTippac" id="cboTippac" class="spetit" onChange="revisaTitular()" style="width: 70%;">
                                    <option value="T">TITULAR</option>
                                    <option value="D">DEPENDIENTE O CARGA</option>
                                </select> 
                            </td>
                        </tr>
                        <tr class="formulario" style="display:none">
                            <td>
                                <b>Condici&oacute;n PRAIS</b>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rdoprais" id="rdoprais1" name="rdoprais" value="1">
                                    <label class="form-check-label" for="rdoprais1">S&iacute;</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rdoprais" id="rdoprais0"  value="0" checked>
                                    <label class="form-check-label" for="rdoprais0">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr class="formulario" id="trRutTitular" style="display:none">
                            <td>
                                <b>RUN Titular</b>
                            </td>
                            <td>
                                <div class="grid_run_titular">
                                    <div class="grid_run_titular1">
                                        <label for="txtRuttit">RUT:</label>
                                        <input type="text" class="form-control input-sm" name="txtRuttit" id="txtRuttit" onKeyPress="return IsNumber(event);" size="8" maxlength="8" style="width: 120px;">
                                    </div>
                                    <div class="grid_run_titular2"><b>-</b></div>
                                    <div class="grid_run_titular3"> 
                                        <label for="txtDvtit">DV:</label>
                                        <input type="text" class="form-control input-sm" name="txtDvtit" id="txtDvtit" onKeyPress="return IsDigitoVerificador(event);" size="1" maxlength="1" style="width: 55px;">
                                    </div>
                                </div>
                                <input type="button" name="btnConsultarPacientePrevisionales" id="btnConsultarPacientePrevisionales" onClick="buscaTitular();" value="Buscar" style="display:none">
                            </td>
                        </tr>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                    <button type="button" class="btn btn-small btn-success btn-fill" id="btn_confirmanuevopaciente" disabled>
                        <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;NUEVO&nbsp;PACIENTE
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<input type="hidden"  id="cod_empresa" name="cod_empresa" value="<?php echo $this->session->userdata("COD_ESTAB");?>"/>
