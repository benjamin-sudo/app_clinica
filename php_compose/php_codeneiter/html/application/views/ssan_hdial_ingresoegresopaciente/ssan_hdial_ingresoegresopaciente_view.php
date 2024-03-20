<h4 class="title" style="color:#e34f49;margin:0px;margin-left:12px;">
    <i class="nav-icon fa fa-tint" aria-hidden="true"></i>&nbsp;<b>INGRESO DE PACIENTES TURNOS EN DIALISIS Y RRHH</b>
</h4>

<hr>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">LISTADO PACIENTES</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">LISTADO DE MAQUINAS</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">MI RRHH</button>
  </li>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">OPCIONES</a>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="#">NUEVO INGREGO A PACIENTE</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="#">NUEVO PROFESIONAL</a></li>
    </ul>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

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
                <th class="subtitulo_formulario2" width="29%">Apellido Nombre</th>
                <th class="subtitulo_formulario2" width="6%" >Edad</th>
                <th class="subtitulo_formulario2" width="14%">Ingreso</th>
                <th class="subtitulo_formulario2" width="10%">Ingreso Historico</th>
                <th class="subtitulo_formulario2" width="14%">Estado</th>
                <th class="subtitulo_formulario2" width="15%">OPCI&Oacute;N</th>
            </tr>
        </thead>
        <tbody id="LISTA_PACIENTES"></tbody>
    </table>



  </div>
  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

    --.-- 2
    
  </div>
  <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">

    --.-- 3

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
                            <div id="busquedaMes"/></div>
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
                            <div id="busquedaMes2"/></div>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-danger btn-fill btn-wd"  data-dismiss="modal"><i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA </button>
                            <button type="button" class="btn btn-success btn-fill btn-wd" id="btn_guardar"><i class="fa fa-check-square" aria-hidden="true"></i> GUARDAR INFORMACI&Oacute;N </button>
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
                    <h3 class="modal-title"><b>NUEVO RRHH</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="html_nuevo_prestador_rrhh"></div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="busquedaMes2"/></div>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-danger btn-fill btn-wd"  data-dismiss="modal"><i class="fa fa-window-close-o" aria-hidden="true"></i>&nbsp;CIERRA VENTANA</button>
                            <button type="button" class="btn btn-success btn-fill btn-wd" id="btn_guarda_infoxususario" disabled="">
                                <i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;GUARDAR RRHH
                            </button>
                        </div>
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
