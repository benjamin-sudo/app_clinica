<h4 class="title" style="color:#e34f49;margin:0px;margin-left:12px;">
    <i class="nav-icon fa fa-tint" aria-hidden="true"></i>&nbsp;<b>INGRESO DE PACIENTES TURNOS EN DIALISIS - RRHH - MAQUINAS </b>
</h4>
<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 8px;">
    <li class="nav-item" role="presentation">
        <button class="nav-link active btn_listado_paciente" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
            <i class="bi bi-person-wheelchair"></i>&nbsp;LISTADO DE PACIENTES&nbsp;
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
            <i class="bi bi-person-vcard-fill"></i>&nbsp;RRHH&nbsp;
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
            <i class="bi bi-h-circle-fill"></i>&nbsp;LISTADO DE MAQUINAS&nbsp;
        </button>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="bi bi-gear-fill"></i>&nbsp;&nbsp;OPCIONES</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="javascript:nuevoPacienteAgresado(1)"><i class="bi bi-universal-access-circle"></i>&nbsp;NUEVO INGREGO A PACIENTE PARA TRATAMIENTO DE HERMODIALISIS</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="javascript:js_nuevo_prestador_dialisis(1)"><i class="bi bi-person-vcard"></i>&nbsp;NUEVO PROFESIONAL PARA HERMODIALISIS</a></li>
        </ul>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <div class="grid_panel_paciente">
            <div class="grid_panel_paciente1">
                <h4 style="margin-bottom: 0px;"><b>LISTADO DE PACIENTES DI&Aacute;LISIS</b></h4>
                <p style="margin-bottom: 0px;">LISTA PACIENTES INGRESADOS A SU ESTABLECIMIENTO</p> 
            </div>
            <div class="grid_panel_paciente2">
                <p style="margin-bottom: 0px;"><b>BUSCAR</b>&nbsp;<i class='fa fa-search icon-4x'></i></p> 
                <input type="text" id="searchTermIng2" class="form-control" style="width: auto;margin-bottom:6px;" onkeyup="doSearch(2)"></b>
            </div>
            <div class="grid_panel_paciente3">
                <button type="button" class="btn btn-success btn-fill" id="btn_update_analitica" onclick="busquedaPacientes()" style="margin-top: 24px;">
                    <i class="bi bi-bootstrap-reboot"></i>
                </button>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th width="2%" >N&deg;</th>
                    <th width="10%">RUN</th>
                    <th width="29%">APELLIDO NOMBRE</th>
                    <th width="6%" >EDAD</th>
                    <th width="14%">INGRESO</th>
                    <th width="20%">INGRESO HISTORICO</th>
                    <th width="14%">ESTADO</th>
                    <th width="5%">OPCI&Oacute;N</th>
                </tr>
            </thead>
            <tbody id="LISTA_PACIENTES"><?php echo $htmlBusquedaPacientes;?></tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
        <div class="grid_panel_paciente">
            <div class="grid_panel_paciente1">
                <h4 style="margin-bottom: 0px;"><b>M&Aacute;QUINAS DE DI&Aacute;LISIS</b></h4>
                <p style="margin-bottom: 8px;">LISTA M&Aacute;QUINAS DI&Aacute;LISIS POR ESTABLECIMIENTO</p> 
            </div>
            <div class="grid_panel_paciente2">
                <button type="button" class="btn btn-primary" onclick="busquedaPacientesxMaquina()">
                    <i class="bi bi-arrow-up-square-fill"></i>&nbsp;&nbsp;ACTUALIZACI&Oacute;N
                </button>
            </div>
        </div>
        <div class="list-group" id="listado_maquinasporpaciente">
            <?php echo $li_listadopacientemaquina;?>
        </div>
    </div>
    <div class="tab-pane fade margen_tabs" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0" style="padding: 2px;margin-top: 2px;margin-left: 30px;margin-right: 30px;">
        <div id="IND_RRHH"><?php echo $html_out;?></div>
    </div>
</div>
<!-- ZONA -->
<section>
    <div class="modal fade" id="TURNOXMAQUINA">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><b><div id="NOM_MAQUINA"></div></b></h4>
                </div>
                <div class="modal-body" id="BODYXMAQUINA"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">CIERRA VENTANA (NO GRABA)</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="TURNOXMAQUINA">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><b><div id="NOM_MAQUINA"></div> </b></h4>
                </div>
                <div class="modal-body" id="BODYXMAQUINA"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">CIERRA VENTANA (NO GRABA)</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="MODAL_HD_ANTERIORES">
        <div class="modal-dialog modal_ANTERIORES">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-title"><b>- HIST&Oacute;RICO DE HOJA DIARIA </b></h3></div>
                <div class="modal-body" id="BODY_HD_ANTERIORES"></div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="busquedaMes"></div>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> <i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
    <div class="modal fade" id="modal_nuevo_prestador_rrhh">
        <div class="modal-dialog modal_imedico">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b>NUEVO RRHH - DI&Aacute;LISIS</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="html_nuevo_prestador_rrhh"></div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-square-fill"></i>&nbsp;&nbsp;CERRAR VENTANA
                        </button>
                        <button type="button" class="btn btn-success" id="btn_guarda_infoxususario" disabled="">
                            <i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;&nbsp;GUARDAR RRHH
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal_nuevo_ingreso_paciente">
        <div class="modal-dialog  modal-lg modal_imedico modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b>INGRESO DE PACIENTE DE DI&Aacute;LISIS</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="html_nuevo_ingreso_paciente">
                    <div class="nuevo_ingreso_pacientehd">
                        <div class="nuevo_ingreso_pacientehd1">
                            <div class="card">
                                <div class="grid_ingreso_run">
                                    <div class="grid_ingreso_run1">
                                        <div class="card-body" style="padding: 10px;">
                                            <span class="input-group-addon" id="basic-addon1">
                                                <i class="fa fa-user-md"></i>&nbsp;<b>RUN PACIENTE</b>
                                            </span>
                                            <input type="text" id="rut_paciente" name="rut_paciente" class="form-control input-sm" style="width:115px;">
                                        </div>
                                    </div>
                                    <div class="grid_ingreso_run2">
                                        <button type="button" class="btn btn-success btn-small btn-fill" id="btn_valida_paciente" onclick="js_grabadatosPaciente()" style="margin-top:23px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="div_pacienteindentificado position-sticky" style="top: 0;">&nbsp;</div>
                        </div>
                        <div class="nuevo_ingreso_pacientehd2">&nbsp;</div>
                        <div class="nuevo_ingreso_pacientehd3 formulario_ingreso"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-square-fill"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- modal-dialog-scrollable -->
    <div class="modal fade" id="MODAL_INFOHOJADIARIA">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">INFORMACI&Oacute;N DE HOJA DIARIA</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="BODY_INFOHOJADIARIA"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;</button>
                    <button type="button" class="btn btn-success" id="btn_guardar"><i class="bi bi-floppy"></i>&nbsp;GUARDAR INFORMACI&Oacute;N</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_informes_pdf">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">PDF</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="html_informes_pdf"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_egresa_paciente">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">EGRESO DE PACIENTE</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="html_egresa_paciente"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="PACIENTEXCUPO">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">AGREGAR PACIENTE POR CUPO</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="HTML_PACIENE"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;</button>
                    <button type="button" class="btn btn-primary" id="NUEVOPACIENTEXCUPO">
                        <span class="spinner_btn spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                        <i class="bi bi-floppy"></i>&nbsp;GRABA PACIENTE
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ZONA INPUT INGRESO DE PACIENTE -->
    <input type="hidden" id="empresa" name="empresa" value="<?php echo $this->session->userdata("COD_ESTAB");?>">
    <input type="hidden" id="TOKEN_PDF" name="TOKEN_PDF" value="<?php echo $TOKEN_SESSION;?>"/>
    <input type="hidden" id="TOKEN_ONE" name="TOKEN_ONE" value="<?php echo $TOKEN_ONE;?>"/>
    <div class= "info_userdata" data-userdata="<?php echo htmlspecialchars(json_encode($this->session->userdata),ENT_QUOTES,'UTF-8');?>"></div>
</section>