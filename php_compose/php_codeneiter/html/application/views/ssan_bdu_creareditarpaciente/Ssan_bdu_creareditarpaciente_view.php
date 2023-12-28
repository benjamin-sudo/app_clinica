<div class="grid_cabecera_bdu">
    <div class="grid_cabecera_bdu1">
        <h4 class="title" style="color:#e34f49;margin:0px;">
            <b>GESTOR &Uacute;NICO DE PACIENTES</b>
        </h4>
    </div>
    <div class="grid_cabecera_bdu1">
        <?php echo date('d-m-Y');?>
    </div>
</div>

<hr>

<div class="grid_body_bdu">
    <div class="card grid_body_bdu1">

        <table class="table table-striped" width="100%">
            <tr class="success">
                <td style="width:40%;text-align: right;">
                    <div id="titulo_nombre"><b>PACIENTE/EDITAR</b></div>
                </td>
                <td style="width:60%">
                    <div class="dropdown" id="btn_crear">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>  <b>AGREGAR/EDITAR PACIENTE</b>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:FormModal(1,'')"><i class="fa fa-user-circle"       aria-hidden="true"></i>&nbsp;PACIENTE NACIONAL</a></li>
                            <li><a href="javascript:FormModal(0,'')"><i class="fa fa-universal-access"  aria-hidden="true"></i>&nbsp;PACIENTE EXTRANJERO</a></li>
                            <li><a href="javascript:FormModal(3,'')"><i class="fa fa-child"             aria-hidden="true"></i>&nbsp;PACIENTE R.N</a></li>
                            <li><a href="javascript:nuevo_reciennacido()"><i class="fa fa-child"        aria-hidden="true"></i>&nbsp;PACIENTE R.N 2</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr id="trTipo">
                <td style="width:186px;text-align: right;">Tipo de Paciente:</td>
                <td>
                    <input type="radio" name="tipPac" value="0" id="checkReNacido"  onclick="cambiaTip(0)" checked/>
                    <label style="cursor:pointer" for="checkReNacido"><img class="shadow"> Con RUN Nacional</label> 
                    &nbsp; 
                    <input type="radio" name="tipPac" value="1" id="checkExtranjero" onclick="cambiaTip(1)">
                    <label style="cursor:pointer" for="checkExtranjero"><img class="shadow">Extranjero</label> 
                </td>
            </tr>
            <tr id="trEx" style="display: none;" >
                <td style="text-align: right;">Tipo Documento :</td>
                <td>
                    <select id="tipoEx" onchange="cambiaDoc(this.value);" style="width:210px">
                        <option value="1">Pasaporte/DNI Pa&iacute;s Origen</option>
                        <option value="2">ID Provisorio Fonasa</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td id="nameType" style="text-align: right;">RUN</td>
                <td>
                    <input type="text" id="rut" class="form-control">
                    <input type="text" id="dni" style="display: none;" maxlength="20">
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
            <table class="table table-striped" width="100%">
                <thead>
                    <tr class="info">
                        <td colspan="6" > Informaci&oacute;n de Pacientes</td>
                        <td colspan="4"> Total Resultados <span class="badge" id="nresultados"></span></td>
                    </tr>
                </thead>
                <thead>
                    <tr class="info">
                        <td width="1%"   >N&deg;</td>
                        <td width="15%"  >Run/ID Fonasa</td>
                        <td width="10%"  >DNI/Pasaporte</td>
                        <td width="8%"   >F.Local</td>
                        <td width="15%"  >Nombres</td>
                        <td width="15%"  >Apellido Paterno</td>
                        <td width="15%"  >Apellido Materno</td>
                        <td width="9%"   >Nacimiento</td>
                        <td width="5%"   >PAIS</td>
                        <td width="7%"   style="width:10%;text-align:center">Opci&oacute;n</td>
                    </tr>
                </thead>    
                <tbody id="resultados"></tbody>
            </table>
            <div class="row">
                <div class="col-xs-1 center-block">
                    <center>
                        <div style="text-align:center;" align="center">  
                            <div id="new_paginacion" style="display: none;"></div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>


<section>
    <div class="modal fade bs-example-modal-lg" id="modalPaciente">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="tituloModal"><div id="titulo_bdu"></div> </h3>
                </div>
                <div class="modal-body" id="HTML_DIALOGO"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger  btn-sm" data-dismiss="modal"><i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA</button>
                    <button type="button" class="btn btn-primary btn-sm disabled" id="Btn_bdu">
                        <div id="txt_bdu"></div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExtranjero">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="tituloModal"><B>CERTIFICADO EXTRANJERO</B></h3>
                </div>
                <div class="modal-body" id="HTML_PDF"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger  btn-sm" data-dismiss="modal"><i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA</button>
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


<!--------------------  RECIEN NACIDO ---------------------->
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
<!--------------------  RECIEN NACIDO ---------------------->


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



<div id="dialogo_prestacion"></div>
<div id="respuesta"></div>
<input type="hidden" id="indTemplateNum" name="indTemplateNum" value="1"/>
<input type="text" id="USERNAME" name="USERNAME" value="<?php echo $USERNAME; ?>"/>
<input type="text" id="COD_ESTAB" name="COD_ESTAB" value="<?php echo $COD_ESTAB; ?>"/>





</section>





