<div class="grid_cabecera_bdu">
    <div class="grid_cabecera_bdu1">
        <h4 class="title" style="color:#e34f49;margin:0px;margin-left:12px;">
            <i class="fa fa-address-book" aria-hidden="true"></i>&nbsp;<b>GESTOR &Uacute;NICO DE PACIENTES</b>
        </h4>
    </div>
    <div class="grid_cabecera_bdu1">
        <button type="button" class="btn btn-primary" onclick="js_test();" style="display:none">
            <i class="bi bi-prescription"></i>&nbsp;TEST
        </button>
    </div>
    <div class="grid_cabecera_bdu1">
        <div class="dropdown"  id="btn_crear">
            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-person-add"></i>&nbsp;Agregar Nuevo Paciente
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a href="javascript:FormModal(1,'')" class="dropdown-item"><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;PACIENTE NACIONAL</a></li>
                <li><a href="javascript:FormModal(0,'')" class="dropdown-item"><i class="fa fa-universal-access" aria-hidden="true"></i>&nbsp;PACIENTE EXTRANJERO</a></li>
            </div>
        </div>
    </div>
</div>

<div class="grid_body_bdu">
    <div class="card grid_body_bdu1">
        <table class="table table-striped" width="100%" style="margin-bottom:0px;">
            <tr class="success">
                <td colspan="2" style="text-align: center;">
                    <div id="titulo_nombre"><b>B&Uacute;SQUEDA DE PACIENTE</b></div>
                </td>
            </tr>
            <tr id="trTipo">
                <td id="nameType2" style="text-align: right;">Tipo de Paciente</td>
                <td>
                    <input type="radio" name="tipPac" value="0" id="checkReNacido"  onclick="cambiaTip(0)" checked/>
                    <label style="cursor:pointer" for="checkReNacido"><img class="shadow"> Con RUN Nacional</label> 
                    &nbsp; 
                    <input type="radio" name="tipPac" value="1" id="checkExtranjero" onclick="cambiaTip(1)">
                    <label style="cursor:pointer" for="checkExtranjero"><img class="shadow">Extranjero</label> 
                </td>
            </tr>
            <tr id="trEx" style="display: none;" >
                <td style="width:30%;text-align: right;">Tipo Documento:</td>
                <td style="width:70%">
                    <select id="tipoEx" onchange="cambiaDoc(this.value);" style="" class="form-select">
                        <option value="1">Pasaporte/DNI Pa&iacute;s Origen</option>
                        <option value="2">ID Provisorio Fonasa</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td id="nameType" style="text-align: right;">RUN</td>
                <td>
                    <input type="text" id="rut" class="form-control">
                    <input type="text" id="dni" class="form-control" style="display: none;" maxlength="20">
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">Nombre:</td>
                <td><input type="text" id="name" class="form-control"></td>
            </tr>
            <tr>
                <td style="text-align: right;">Apellido Paterno:</td>
                <td><input type="text" id="apellidoP" class="form-control"></td>
            </tr>
            <tr>
                <td style="text-align: right;">Apellido Materno:</td>
                <td><input type="text" id="apellidoM" class="form-control"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    <button type="button" class="btn btn-small btn-primary" onclick="buscar(0,1);" id="btn_buscageneral">
                        <i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR
                    </button>
                    &nbsp; 
                    <button type="button" class="btn btn-small btn-danger" onclick="limpiar(1);" id="btn_limpiageneral">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;LIMPAR
                    </button>
                </td>
            </tr>
        </table>      

    </div>
    <div class="card grid_body_bdu2">
        <div id="result" style="">
            <div class="grid_cabecera_resul">
                <div class="grid_cabecera_resul1"><b>INFORMACI&Oacute;N DE PACIENTES</b></div>
                <div class="grid_cabecera_resul2"><b>TOTAL DE RESULTADOS</b>&nbsp;<span class="badge" id="nresultados">0</span></div>
            </div>
            <table class="table table-striped custom-padding" width="100%">
                <thead>
                    <tr>
                        <td width="15%" style="height: 40px;"><b>RUN/ID FONASA</b></td>
                        <td width="10%"><b>DNI/PASAPORTE</b></td>
                        <td width="8%"><b>F.LOCAL</b></td>
                        <td width="15%"><b>NOMBRES</b></td>
                        <td width="15%"><b>APELLIDO PATERNO</b></td>
                        <td width="15%"><b>APELLIDO MATERNO</b></td>
                        <td width="9%"><b>NACIMIENTO</b></td>
                        <td width="5%"><b>PAIS</b></td>
                        <td width="7%" style="width:10%;text-align:center"><b>OPCI&Oacute;N</b></td>
                    </tr>
                </thead>    
                <tbody id="resultados"></tbody>
            </table>
            <div class="grid_contenedo_paginado">
                <div class="grid_contenedo_paginado1">&nbsp;</div>
                <div class="grid_contenedo_paginado1"><div class="btn-group anatomia_pagination" id="new_paginacion"></div></div>
                <div class="grid_contenedo_paginado1">&nbsp;</div>
            </div>
        </div>
    </div>
</div>

<section>
    <div class="modal fade" id="modalPaciente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="tituloModal"><div id="titulo_bdu"></div></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="HTML_DIALOGO"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CIERRA VENTANA</button>
                    <button type="button" class="btn btn-primary disabled" id="Btn_bdu">
                        <div id="txt_bdu"></div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExtranjero">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">&nbsp;CERTIFICADO EXTRANJERO&nbsp;</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="HTML_PDF"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_percapita">
        <div class="modal-dialog modal-xl3">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="tituloModal"><B>API PERCAPITA</B></h3>
            </div>
            <div class="modal-body" id="HTML_PERCAPITA"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger  btn-sm" data-dismiss="modal">&nbsp;<i class="fa fa-window-close-o" aria-hidden="true"></i>&nbsp;CIERRA&nbsp;VENTANA</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_RECIEN_NACIDO">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="tituloModal"><b>FORMULARIO RECIEN NACIDO</b></h3>
            </div>
            <div class="modal-body" id="HTML_FORM_RN"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger  btn-sm" data-dismiss="modal">&nbsp;<i class="fa fa-window-close-o" aria-hidden="true"></i>&nbsp;CIERRA&nbsp;VENTANA</button>
                </div>
            </div>
        </div>
    </div>

    <div id="respuesta"></div>
    <div id="dialogo_prestacion"></div>
    <input type="hidden" name="indTemplateNum"  id="indTemplateNum"     value="1"/>
    <input type="hidden" name="USERNAME"        id="USERNAME"           value="<?php echo $USERNAME; ?>"/>
    <input type="hidden" name="COD_ESTAB"       id="COD_ESTAB"          value="<?php echo $COD_ESTAB; ?>"/>

</section>