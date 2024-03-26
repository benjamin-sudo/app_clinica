<h4 class="title" style="color:#e34f49;margin:0px;margin-left:12px;">
    <i class="nav-icon fa fa-tint" aria-hidden="true"></i>&nbsp;<b>INGRESO DE PACIENTES TURNOS EN DIALISIS Y RRHH</b>
</h4>
<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 8px;">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
            <i class="bi bi-person-vcard-fill"></i>&nbsp;RRHH
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link btn_listado_paciente" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true" onclick="busquedaPacientes()">
            <i class="bi bi-person-wheelchair"></i>&nbsp;LISTADO DE PACIENTES
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
            <i class="bi bi-h-circle-fill"></i>&nbsp;LISTADO DE MAQUINAS
        </button>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">OPCIONES</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="javascript:js_nuevo_prestador_dialisis(1)"><i class="bi bi-person-vcard"></i>&nbsp;NUEVO PROFESIONAL</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-universal-access-circle"></i>&nbsp;NUEVO INGREGO A PACIENTE</a></li>
        </ul>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade margen_tabs show active" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0" style="padding: 2px;margin-top: 2px;margin-left: 30px;margin-right: 30px;">
        <div id="IND_RRHH"><?php echo $html_out;?></div>
    </div>
    <div class="tab-pane fade " id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <div class="grid_panel_paciente">
            <div class="grid_panel_paciente1">
                <h2 style="margin-top: 0px;margin-bottom: 0px;"><b>PACIENTE EN DIALISIS</b></h2>
                <p>LISTA PACIENTES INGRESADOS</p> 
            </div>
            <div class="grid_panel_paciente2">
                <p style="margin-bottom: 0px;"><b>BUSCAR</b>&nbsp;<i class='fa fa-search icon-4x'></i></p> 
                <input type="text" id="searchTermIng2" class="form-control"  style="width: auto;" onkeyup="doSearch(2)"></b>
            </div>
        </div>
        <table class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th class="subtitulo_formulario2" width="2%" >N&deg;</th>
                    <th class="subtitulo_formulario2" width="10%">RUN</th>
                    <th class="subtitulo_formulario2" width="29%">APELLIDO NOMBRE</th>
                    <th class="subtitulo_formulario2" width="6%" >EDAD</th>
                    <th class="subtitulo_formulario2" width="14%">INGRESO</th>
                    <th class="subtitulo_formulario2" width="10%">INGRESO HISTORICO</th>
                    <th class="subtitulo_formulario2" width="14%">ESTADO</th>
                    <th class="subtitulo_formulario2" width="15%">OPCI&Oacute;N</th>
                </tr>
            </thead>
            <tbody id="LISTA_PACIENTES"></tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
        <table width="100%" style="margin-top: 14px;">
            <tr>
                <td width="80%">
                    <h2 style="margin-bottom: 0px;margin-top: 0px;margin-left: 10px;"><b>M&Aacute;QUINAS DE DI&Aacute;LISIS</b></h2>
                    <p style="margin-left: 10px;">LISTA MAQUINAS DI&Aacute;LISIS POR ESTABLECIMIENTO</p> 
                </td>
                <td width="20%" style="text-align:right"></td>
            </tr>
        </table>
        <table class="table table-striped" width="100%" >
            <thead>
                <tr>
                    <th class="subtitulo_formulario2" width="2%" >N&deg;</th>
                    <th class="subtitulo_formulario2" width="40%">MAQUINA (CODIGO)</th>
                    <th class="subtitulo_formulario2" width="20%">FOLIO MAQUINA</th>
                    <th class="subtitulo_formulario2" width="10%">ESTADO</th>
                    <th class="subtitulo_formulario2" width="15%">N&deg; PACIENTE</th>
                    <th class="subtitulo_formulario2" width="13%">OPCI&Oacute;N</th>
                </tr>
            </thead>
            <tbody id="LISTA_MAQUINA"> </tbody>
        </table>
    </div>
</div>

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

    <div class="modal fade" id="PACIENTEXCUPO">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><b>AGREGAR PACIENTE POR CUPO</b></h4>
                </div>
                <div class="modal-body" id="HTML_PACIENE"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger  btn-sm" data-dismiss="modal">CIERRA VENTANA (NO GRABA)</button>
                    <button type="button" class="btn btn-primary btn-sm" id="NUEVOPACIENTEXCUPO">GRABA PACIENTE</button>
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

    <div class="modal fade" id="MODAL_INFOHOJADIARIA">
        <div class="modal-dialog modal_imedico">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-title"><b>- INFORMACI&Oacute;N DE HOJA DIARIA </b></h3></div>
                <div class="modal-body" id="BODY_INFOHOJADIARIA"></div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="busquedaMes2"></div>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-danger btn-fill btn-wd"  data-dismiss="modal"><i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA </button>
                            <button type="button" class="btn btn-success btn-fill btn-wd" id="btn_guardar"><i class="bi bi-x-square-fill"></i> GUARDAR INFORMACI&Oacute;N </button>
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
</section>

<!--  ZONA INPUT INGRESO DE PACIENTE -->
<input type="hidden" id="TOKEN_PDF" name="TOKEN_PDF" value="<?php echo $TOKEN_SESSION;?>"/>
<input type="hidden" id="TOKEN_ONE" name="TOKEN_ONE" value="<?php echo $TOKEN_ONE;?>"/>
<input type="hidden" id="empresa" name="empresa" value="<?php echo $this->session->userdata("COD_ESTAB");?>">
<div class= "info_userdata" data-userdata="<?php echo htmlspecialchars(json_encode($this->session->userdata),ENT_QUOTES,'UTF-8');?>"></div>
