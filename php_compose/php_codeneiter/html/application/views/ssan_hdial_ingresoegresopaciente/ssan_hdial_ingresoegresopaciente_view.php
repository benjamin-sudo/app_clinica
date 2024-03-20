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
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

    --.-- 1

  </div>
  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

    --.-- 2
    
  </div>
  <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">

    --.-- 3

  </div>
</div>

<br>

<div class="container-fluid">
    <div>
    <ul class="nav nav-pills  nav-justified" role="tablist">
        <li role="presentation" class="active"> <a href="#PACIENTES"    aria-controls="PACIENTES" 	role="tab"  data-toggle="tab">LISTA PACIENTES</a></li>
        <li role="presentation"><a href="#PABELLONES"   aria-controls="PABELLONES" 	role="tab"  data-toggle="tab">LISTAS DE MAQUINAS</a></li>
        <li role="presentation"><a href="#IND_RRHH"     aria-controls="IND_RRHH" 	role="tab"  data-toggle="tab" id="li_busqueda_rrhh" onclick="js_busqueda_rrhh(1)">RRHH</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"> OPCIONES<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="javascript:nuevoPacienteAgresado(1)"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;NUEVO INGRESO PACIENTE</a></li>
                <li><a href="javascript:js_nuevo_prestador_dialisis(1)"><i class="fa fa-h-square" aria-hidden="true"></i>&nbsp;NUEVO PROFESIONAL DIALISIS</a></li>
            </ul>
        </li>
    </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="IND_RRHH"></div>
            <div role="tabpanel" class="tab-pane active" id="PACIENTES">
                <div id="imp__imprimePdfIng" style="display:none">
                <form id="imp_formulario_ing_enf">
                    <table id="" class="table_parapdf" width="100%" >
                        <tr>
                            <td style="text-align: center;"  colspan="4"> <b><span class="Titt">INGRESO DE ENFERMERIA</span></b> <p class="category"><span class="Titt2">Unidad de Hemodiálisis</span></p></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <p><u><b>1. ANTECEDENTES PERSONALES</b></u></p>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Nombre Paciente:</b></td><td><input id="imp_Nompaciente" required type="text" value=""  class=" limp" /></td>  
                            <td><b>Rut Paciente:</b></td><td><input id="imp_Rutpac" required  type="text" value=""  class=" limp"  /></td>                        
                        </tr>
                         <tr>                      
                            <td><b>Previsi&oacute;n:</b></td><td><input id="imp_PrevPac" required type="text" value=""  class=" limp" /></td>  
                            <td><b>Edad:</b></td><td><input id="imp_EdadPac" required  type="text" value=""  class=" limp"  /> </td>                        
                        </tr>
                        <tr>
                            <td style="width: 150px;padding:10px;"></td>
                            <td style="width: 330px;"></td>
                            <td style="width: 85px;"></td>
                            <td style="width: 127px;"></td>
                        </tr>
                        <tr> 
                            <td ><b>Antecedentes Quirúrgicos:</b></td><td colspan="3"><input id="imp_Resp_IngEnf_Dial_541" type="text" value=""  class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td><b>Antecedentes Alérgicos:</b><input type="hidden" id="imp_Resp_IngEnf_Dial_542" class="limp"></td><td  colspan="3"> 
                                <div class="col-xs-9">
                                    <label id="RESPUESTA_Resp_IngEnf_Dial_542"></label>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"><b>Alimentos: </b></td><td  colspan="3"><input id="imp_Resp_IngEnf_Dial_543" type="text" value=""  class=" limp" required /></td>
                        </tr>
                        <tr >
                            <td style="text-align: right;"><b>Medicamentos: </b></td><td colspan="3"><input id="imp_Resp_IngEnf_Dial_544" type="text" value="" class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"><b>Otros: </b></td><td colspan="3"><input id="imp_Resp_IngEnf_Dial_545" type="text" value="" class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td><u><b>Diagnóstico de ingreso:</b></u> <input type="hidden" id="imp_Resp_IngEnf_Dial_546" value="0" class=""></td><td colspan="3">
                                <div id="">
                                    <table id="imp_Cod_cie10_1">

                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Establecimiento al que se deriva en caso de urgencia:</b></td><td colspan="3"><input id="imp_Resp_IngEnf_Dial_547" type="text" value="" class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td><b>Grupo sanguíneo:</b></td><td><input id="imp_Resp_IngEnf_Dial_548" type="text" value=""  class=" limp" required /></td>
                            <td colspan="2"><b>RH:</b> <input id="imp_Resp_IngEnf_Dial_549" type="text" value=""  class=" limp" required /></td>
                        </tr>
                    </table> 

                    <table class="table_parapdf" width="100%">

                        <tr>
                            <td colspan="8">
                                <p><u><b>2. EXAMEN FISICO GENERAL</b></u></p>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Peso:</b></td><td><input id="imp_Resp_IngEnf_Dial_550" type="text" value=""  class=" limp" required /></td>
                            <td><b>FC:</b> </td><td><input id="imp_Resp_IngEnf_Dial_551" type="text" value=""  class=" limp" required /></td>
                            <td><b>P/A:</b></td><td><input id="imp_Resp_IngEnf_Dial_552" type="text" value=""  class=" limp" required style="width: 25px;" /><input id="imp_Resp_IngEnf_Dial_553" type="text" value="" placeholder="Dis" class=" limp" required style="width: 25px;"/></td>
                            <td><b>Talla:</b></td><td><input id="imp_Resp_IngEnf_Dial_554" type="text" value=""  class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Movilidad:</b></td><td  colspan="6"><input id="imp_Resp_IngEnf_Dial_555" type="text" value=""  class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Nutrición:</b></td><td  colspan="6"><input id="imp_Resp_IngEnf_Dial_556" type="text" value=""  class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Grado de conciencia:</b></td><td  colspan="6"><input id="imp_Resp_IngEnf_Dial_557" type="text" value=""  class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Estado de la piel:</b></td><td  colspan="6"><input id="imp_Resp_IngEnf_Dial_558" type="text" value=""  class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Conjuntivas:</b></td><td  colspan="6"><input id="imp_Resp_IngEnf_Dial_559" type="text" value=""  class=" limp" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Yugulares:</b></td><td  colspan="6"><input id="imp_Resp_IngEnf_Dial_560" type="text" value=""  class=" limp" required /></td>
                        </tr>                     
                        <tr>
                            <td  colspan="2"><b>Extremidades:</b></td><td colspan="6"><textarea id="imp_Resp_IngEnf_Dial_561" class=" limp" required rows="3"></textarea></td>
                        </tr>
                    </table>

                    <table  class="table_parapdf" width="100%">
                        <tr>
                            <td><b>Acceso Vascular</b></td><td><b>FAV:</b></td><td><input id="imp_Resp_IngEnf_Dial_562" type="text" value=""  class=" limp" required /></td>
                            <td><b>Fecha:</b></td><td><input id="imp_Resp_IngEnf_Dial_563" type="text" value=""  class=" limp" required /></td>                          
                        </tr>
                        <tr>
                            <td>    </td><td><b>Gorotex:</b></td><td><input id="imp_Resp_IngEnf_Dial_564" type="text" value=""  class=" limp" required /></td>
                            <td><b>Fecha:</b></td><td><input id="imp_Resp_IngEnf_Dial_565" type="text" value=""  class=" limp" required /></td>                          
                        </tr>
                        <tr>
                            <td>    </td><td><b>Catéter:</b></td><td><input id="imp_Resp_IngEnf_Dial_566" type="text" value=""  class=" limp" required /></td>
                            <td><b>Fecha:</b></td><td><input id="imp_Resp_IngEnf_Dial_567" type="text" value=""  class=" limp" required /></td>                          
                        </tr>
                        <tr>
                            <td colspan="2"><b>Diuresis</b><input type="hidden" id="imp_Resp_IngEnf_Dial_568" class=" limp"></td><td>    
                                 <div class="col-xs-9">
                                    <label id="RESPUESTA_Resp_IngEnf_Dial_568"></label>

                                </div>
                            </td>
                            <td><b>Volumen:</b></td><td><input id="imp_Resp_IngEnf_Dial_569" type="text" value=""  class=" limp" required /></td>                          
                        </tr>

                        <tr>
                            <td><b>Antígenos</b></td><td><b>HVC:</b></td><td><input id="imp_Resp_IngEnf_Dial_570" type="text" value=""  class=" limp" required /></td>
                            <td><b>Fecha:</b></td><td><input id="imp_Resp_IngEnf_Dial_571" type="text" value=""  class=" limp" required /></td>                          
                        </tr>
                        <tr>
                            <td>  </td><td><b>HIV:</b></td><td><input id="imp_Resp_IngEnf_Dial_572" type="text" value=""  class=" limp" required /></td>
                            <td><b>Fecha:</b></td><td><input id="imp_Resp_IngEnf_Dial_573" type="text" value=""  class=" limp" required /></td>                          
                        </tr>
                        <tr>
                            <td>  </td><td><b>HBSAG:</b></td><td><input id="imp_Resp_IngEnf_Dial_574" type="text" value=""  class=" limp" required /></td>
                            <td><b>Fecha:</b></td><td><input id="imp_Resp_IngEnf_Dial_575" type="text" value="" class=" limp" required /></td>                          
                        </tr>
                    </table>

                    <table  class="table_parapdf" width="100%">

                        <tr>
                            <td colspan="8">
                                <p><u><b>3. ANTECEDENTES HEMODIALISIS</b></u></p>
                            </td>
                        </tr>
                        <tr>
                            <td><b>QB:</b></td><td><input id="imp_Resp_IngEnf_Dial_576" type="text" value=""  class=" limp" required /></td>
                            <td><b>Heparina:</b></td><td>
                                <div class="col-xs-9">

                                    I : <label><input id="imp_Resp_IngEnf_Dial_577" type="text" value=""  class=" limp" required /></label>
                                    <br>M :  <label><input id="imp_Resp_IngEnf_Dial_590" type="text" value=""  class=" limp" required /></label>

                                </div>

                            </td>
                            <td><b>1° Dosis HVB:</b></td><td><input id="imp_Resp_IngEnf_Dial_578" type="text" value=""  class=" limp" required /></td>                            
                        </tr>

                        <tr>
                            <td><b>QD:</b></td><td><input id="imp_Resp_IngEnf_Dial_579" type="text" value=""  class=" limp" required /></td>
                            <td><b>Baño K+/Na:</b></td><td>
                                <input id="imp_Resp_IngEnf_Dial_580" type="text" value="" class=" limp" required /> 
                            </td>
                            <td><b>2° Dosis HVB:</b></td><td><input id="imp_Resp_IngEnf_Dial_581" type="text" value=""  class=" limp" required /></td>                            
                        </tr>
                        <tr>
                            <td><b>Peso seco:</b></td><td><input id="imp_Resp_IngEnf_Dial_582" type="text" value=""  class=" limp" required /></td>
                            <td><b>Concentrado:</b></td><td>
                                <input id="imp_Resp_IngEnf_Dial_583" type="text" value=""  class=" limp" required /> 
                            </td>
                            <td><b>3° Dosis HVB:</b></td><td><input id="imp_Resp_IngEnf_Dial_584" type="text" value=""  class=" limp" required /></td>                            
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td><b>1° refuerzo HVB:</b></td><td><input id="imp_Resp_IngEnf_Dial_585" type="text" value=""  class=" limp" required /></td>                            
                        </tr>
                    </table>
                    <table class="table_parapdf" width="100%">
                        <tr>
                            <td colspan="8">
                                <p><u><b>4. OBSERVACIONES</b></u></p>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="4"><textarea id="imp_Resp_IngEnf_Dial_586" class=" limp" required  rows="8"></textarea></td>
                        </tr>
                        <tr>
                            <td><b>Enfermera:</b></td><td><input id="imp_Resp_IngEnf_Dial_587" required  type="text" value=""  class=" limp"  /></td>

                            <td><b>Fecha:</b></td><td><input id="imp_Resp_IngEnf_Dial_588" required type="text" value=""  class=" limp" /></td>                          
                        </tr>
                        <tr>
                            <td><b>Establecimiento Reg:</b></td><td><input id="imp_Estabreg" required  type="text" value=""  class=" limp"  /></td>                        
                            <td></td><td></td>                          
                        </tr>
                    </table>
                </form>
            </div> 
                <div class="container">
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
            </div>

            <div role="tabpanel" class="tab-pane" id="PABELLONES">
                <div class="container">
                    <table width="100%">
                        <tr>
                            <td width="80%">
                                <h2 style="margin-bottom: 0px; margin-top: 0px"><b>MAQUINAS DE DIALISIS</b></h2>
                                <p>LISTA MAQUINAS DIALISIS POR ESTABLECIMIENTO</p> 
                            </td>
                            <td width="20%" style="text-align:right"> </td>
                        </tr>
                    </table>
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                <th class="subtitulo_formulario2" width="2%" >N&deg;</th>
                                <th class="subtitulo_formulario2" width="40%">MAQUINA (CODIGO)</th>
                                <th class="subtitulo_formulario2" width="20%">FOLIO MAQUINA</th>
                                <th class="subtitulo_formulario2" width="10%">ESTADO</th>
                                <th class="subtitulo_formulario2" width="15%">N&deg; PACIENTE</th>
                                <th class="subtitulo_formulario2" width="13%"><!-- OPCI&Oacute;N--></th>
                            </tr>
                        </thead>
                        <tbody id="LISTA_MAQUINA"> </tbody>
                    </table>
                </div>
            </div>
            <!--
            <div role="tabpanel" class="tab-pane" id="TURNOS"></div>
            -->
            <div role="tabpanel" class="tab-pane" id="MAQUIXTUR">
                <div id="PACIENTEXMAQUINA"></div>
            </div>

        </div>
    </div>
</div>





<div class="modal fade" id="nuevoProfesional">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><b>NUEVO INGRESO PACIENTE</b></h3>
            </div>
            <div class="modal-body">
                <table id="bootstrap-table2" class="table" width="100%">
                    <tbody id="resultadoBusqueda">
                        <tr>
                            <td width="30%"><b>RUN Paciente</b></td>
                            <td width="40%">
                                <!--class="form-control input-sm"-->
                                <!--onblur="js_grabadatosPaciente-->
                                <input type="text" name="Rut_form" id="Rut_form" value="" maxlength="12" onkeypress="" onblur="" placeholder="11.111.111-1" required=""  class="form-control valid" >  <span class="alert_err" id="ErrorRutVF" style="display: none;color: #ea4848;font-weight: bold;"></span><input type="hidden" value="0" id="Hdd_RtInc"/>
                                <input type="hidden" value="" id="fic_e"/>
                            </td>
                            <td width="20%">
                                <a class="btn btn-info" href="javascript:js_grabadatosPaciente()" aria-label="Delete">
                                    <i class="fa fa-search" aria-hidden="true"></i> BUSQUEDA
                                </a>
                                <span id="Btn_imp_imng"></span>
                                <!--                                
                                    <a class="btn btn-info" href="javascript:$('#dv_notif_reac_adv').toggle();" aria-label="Delete">
                                        <i class="fa fa-search" aria-hidden="true"></i> VER FORM NOTIF. DE REACIONES ADVERSAS
                                    </a>
                                -->
                            </td>                            
                        </tr>                          
                    </tbody>
                </table>
                <div id="resultadoBusqueda_post"></div>
            </div>
            <div id="dv_mnj_frm" style="display:none"> </div>
            <div class="modal-body">
            <div id="Dv_form_IngEnf" class="card" style="display:none; ">
                
                <form id="formulario_ing_enf" onsubmit="return grab();" >
                <table id="" class="table" width="100%">
                    <tr>
                        <td style="text-align: center;"  colspan="4"> <h4 class="title"><b>INGRESO DE ENFERMERIA</b></h4> <p class="category">Unidad de Hemodiálisis</p></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <p><b>1. ANTECEDENTES PERSONALES</b></p>
                        </td>
                    </tr>
                    <tr> 
                        <td><b>Antecedentes Quirúrgicos:</b></td><td colspan="3"><input id="Resp_IngEnf_Dial_541" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr>
                        <td><b>Antecedentes Alérgicos:</b><input type="hidden" id="Resp_IngEnf_Dial_542" class="limp"></td><td  colspan="3"> 
                            <div class="col-xs-9">         
                                <input type="radio"  onclick="selec_(542,1);" name="Rdo_infenf_Ant_Alerg" id="Rdo_infenf_Ant_Alerg_1" value="1" required aria-required="true">
                                <label for="Rdo_infenf_Ant_Alerg_1"><span></span> Si</label>         
                            </div> 
                            <div class="col-xs-9" >                
                                <input type="radio" onclick="selec_(542,2);" name="Rdo_infenf_Ant_Alerg" id="Rdo_infenf_Ant_Alerg_2" value="2">
                                <label for="Rdo_infenf_Ant_Alerg_2"><span></span> No</label>
                                &nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="col-xs-9">                
                                <input type="radio" onclick="selec_(542,3);" name="Rdo_infenf_Ant_Alerg" id="Rdo_infenf_Ant_Alerg_3" value="3">
                                <label for="Rdo_infenf_Ant_Alerg_3"><span></span> No Sabe</label>
                                &nbsp;&nbsp;&nbsp;
                            </div>
                        </td>
                    </tr>
                    
                    <tr   id="TR_Aliments" >
                        <td style="text-align: right;"><b>Alimentos:</b><input type="hidden" id="r_espuesta_543_old" value=""></td><td  colspan="3"><input id="Resp_IngEnf_Dial_543" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr  id="TR_Medicamnts">
                        <td style="text-align: right;"><b>Medicamentos:</b><input type="hidden" id="r_espuesta_544_old" value=""></td><td colspan="3"><input id="Resp_IngEnf_Dial_544" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr   id="Tr_Otrss">
                        <td style="text-align: right;"><b>Otros:</b><input type="hidden" id="r_espuesta_545_old" value=""></td><td colspan="3"><input id="Resp_IngEnf_Dial_545" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr>
                        <td><b>Diagn&oacute;stico de ingreso:</b> <input type="hidden" id="Resp_IngEnf_Dial_546" value="0" class=""></td><td colspan="3">
                            <div class="content2">
                                <input type="hidden" id="codDiagnostico" value="">
                                <input type="text" name="autocompletar" id="nomcie10" onkeypress="return alfanumericoSpace(event);" data-source="ssan_hdial_ingresoegresopaciente/autocompletar2" onpaste="return false" class="autocompletar" style="width:50%;margin-bottom: 0;" placeholder="DIAGNOSTICO CIE10">
                                <div class="autocomplete-jquery-results" id="muestralista" style="display:none;background: #e0f0ff;">
                                </div>
                            </div><!-- content --> 
                            <div id="">
                                <table id="Cod_cie10_1">
                                    
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Establecimiento al que se deriva en caso de urgencia:</b></td><td colspan="3"><input id="Resp_IngEnf_Dial_547" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr>
                        <td><b>Grupo sanguíneo:</b></td><td><input id="Resp_IngEnf_Dial_548" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>RH:</b></td><td><input id="Resp_IngEnf_Dial_549" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                </table> 

                <table id="" class="table" width="100%">

                    <tr>
                        <td colspan="8">
                            <p><b>2. EXAMEN FISICO GENERAL</b></p>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Peso:</b></td><td><input id="Resp_IngEnf_Dial_550" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>FC:</b></td><td><input id="Resp_IngEnf_Dial_551" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>P/A:</b></td><td><div class="col-md-4"><input id="Resp_IngEnf_Dial_552" type="text" value="" placeholder="Sis" class="form-control valid limp" required /></div><div class="col-md-4"><input id="Resp_IngEnf_Dial_553" type="text" value="" placeholder="Dis" class="form-control valid limp" required /></div></td>
                        <td><b>Talla:</b></td><td><input id="Resp_IngEnf_Dial_554" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Movilidad:</b></td><td  colspan="6"><input id="Resp_IngEnf_Dial_555" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Nutrición:</b></td><td  colspan="6"><input id="Resp_IngEnf_Dial_556" type="text" value="" class="form-control valid limp" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Grado de conciencia:</b></td><td  colspan="6"><input id="Resp_IngEnf_Dial_557" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Estado de la piel:</b></td><td  colspan="6"><input id="Resp_IngEnf_Dial_558" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Conjuntivas:</b></td><td  colspan="6"><input id="Resp_IngEnf_Dial_559" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Yugulares:</b></td><td  colspan="6"><input id="Resp_IngEnf_Dial_560" type="text" value=""  class="form-control valid limp" required /></td>
                    </tr> 
                    
                    <tr>
                        <td  colspan="2"><b>Extremidades:</b></td><td colspan="6"><textarea id="Resp_IngEnf_Dial_561" class="form-control valid limp" required  rows="3"></textarea></td>
                    </tr>
                </table>

                <table id="" class="table" width="100%">
                    <tr>
                        <td><b>Acceso Vascular</b></td><td><b>FAV:</b></td><td><input id="Resp_IngEnf_Dial_562" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>Fecha:</b></td><td><input id="Resp_IngEnf_Dial_563" type="text" value=""  class="form-control valid limp" required /></td>                          
                    </tr>
                    <tr>
                        <td>    </td><td><b>Gorotex:</b></td><td><input id="Resp_IngEnf_Dial_564" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>Fecha:</b></td><td><input id="Resp_IngEnf_Dial_565" type="text" value=""  class="form-control valid limp" required /></td>                          
                    </tr>
                    <tr>
                        <td>    </td><td><b>Catéter:</b></td><td><input id="Resp_IngEnf_Dial_566" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>Fecha:</b></td><td><input id="Resp_IngEnf_Dial_567" type="text" value=""  class="form-control valid limp" required /></td>                          
                    </tr>
                    <tr>
                        <td><b>Diuresis</b><input type="hidden" id="Resp_IngEnf_Dial_568" class=" limp"></td><td>                        
                            <div class="col-xs-9">         
                                <input type="radio" onclick="selec_(568,1);" name="Rdo_Diuesis" id="Rdo_Diuesis_1" value="1">
                                <label for="Rdo_Diuesis_1"><span></span> Si</label>         
                            </div> 
                        </td><td>

                            <div class="col-xs-9">                
                                <input type="radio" onclick="selec_(568,2);"  name="Rdo_Diuesis" id="Rdo_Diuesis_2" value="2">
                                <label for="Rdo_Diuesis_2"><span></span> No</label>
                                &nbsp;&nbsp;&nbsp;
                            </div>
                        </td>
                        <td><b>Volumen:</b></td><td><input id="Resp_IngEnf_Dial_569" type="text" value=""  class="form-control valid limp" required /></td>                          
                    </tr>

                    <tr>
                        <td><b>Antígenos</b></td><td><b>HVC:</b></td><td><input id="Resp_IngEnf_Dial_570" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>Fecha:</b></td><td><input id="Resp_IngEnf_Dial_571" type="text" value=""  class="form-control valid limp" required /></td>                          
                    </tr>
                    <tr>
                        <td>  </td><td><b>HIV:</b></td><td><input id="Resp_IngEnf_Dial_572" type="text" value="" class="form-control valid limp" required /></td>
                        <td><b>Fecha:</b></td><td><input id="Resp_IngEnf_Dial_573" type="text" value=""  class="form-control valid limp" required /></td>                          
                    </tr>
                    <tr>
                        <td>  </td><td><b>HBSAG:</b></td><td><input id="Resp_IngEnf_Dial_574" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>Fecha:</b></td><td><input id="Resp_IngEnf_Dial_575" type="text" value=""  class="form-control valid limp" required /></td>                          
                    </tr>
                </table>

                <table id="" class="table" width="100%">

                    <tr>
                        <td colspan="8">
                            <p><b>3. ANTECEDENTES HEMODIALISIS</b></p>
                        </td>
                    </tr>
                    <tr>
                        <td><b>QB:</b></td><td><input id="Resp_IngEnf_Dial_576" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>Heparina:</b></td><td>
                            <label><span></span> I</label> <input id="Resp_IngEnf_Dial_577" type="text" value=""  class="form-control valid limp" required /> 
                             <label><span></span> M</label> <input id="Resp_IngEnf_Dial_590" type="text" value=""  class="form-control valid limp" required /> 
                        </td>
                        <td><b>1° Dosis HVB:</b></td><td><input id="Resp_IngEnf_Dial_578" type="text" value=""  class="form-control valid limp" required /></td>                            
                    </tr>

                    <tr>
                        <td><b>QD:</b></td><td><input id="Resp_IngEnf_Dial_579" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>Baño K+/Na:</b></td><td>
                            <input id="Resp_IngEnf_Dial_580" type="text" value=""  class="form-control valid limp" required /> 
                        </td>
                        <td><b>2° Dosis HVB:</b></td><td><input id="Resp_IngEnf_Dial_581" type="text" value=""  class="form-control valid limp" required /></td>                            
                    </tr>
                    <tr>
                        <td><b>Peso seco:</b></td><td><input id="Resp_IngEnf_Dial_582" type="text" value=""  class="form-control valid limp" required /></td>
                        <td><b>Concentrado:</b></td><td>
                            <input id="Resp_IngEnf_Dial_583" type="text" value="" class="form-control valid limp" required /> 
                        </td>
                        <td><b>3° Dosis HVB:</b></td><td><input id="Resp_IngEnf_Dial_584" type="text" value="" class="form-control valid limp" required /></td>                            
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b>1° refuerzo HVB:</b></td><td><input id="Resp_IngEnf_Dial_585" type="text" value=""  class="form-control valid limp" required /></td>                            
                    </tr>
                </table>

                <table id="" class="table" width="100%">

                    <tr>
                        <td colspan="8">
                            <p><b>4. OBSERVACIONES</b></p>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="4"><textarea id="Resp_IngEnf_Dial_586" class="form-control valid limp" required  rows="3"></textarea></td>
                    </tr>
                    <tr>
                        <td><b>Enfermera:</b></td><td><input id="Resp_IngEnf_Dial_587" required  type="text" value=""  class="form-control valid limp"  /></td>
                        
                        <td><b>Fecha:</b></td><td><input id="Resp_IngEnf_Dial_588" required type="text" value="" class="form-control valid limp" /></td>                          
                    </tr>
                    <tr>
                        <td colspan="4">
                    <dt class="col-sm-12" style="text-align:center">
                    
                     <span id="spn_BtnGrab"></span>
                  
                   <span id="spn_BtnEdi"></span>  
                    
                    </dt>
                    </td>
                    </tr>
                </table>
                    </form>
                <button type="" class="btn btn-danger" onclick="Limpiar1();"><i class="pe-7s-trash"></i> LIMPIAR </button>

            </div>
            </div>
                  
    
            
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

<!--  ZONA INPUT INGRESO DE PACIENTE -->
<input type="hidden" id="TOKEN_PDF" name="TOKEN_PDF" value="<?php echo $TOKEN_SESSION;?>"/>
<input type="hidden" id="TOKEN_ONE" name="TOKEN_ONE" value="<?php echo $TOKEN_ONE;?>"/>
<input type="hidden" id="empresa" name="empresa" value="<?php echo $this->session->userdata("COD_ESTAB");?>">
<div class= "info_userdata" data-userdata="<?php echo htmlspecialchars(json_encode($this->session->userdata),ENT_QUOTES,'UTF-8');?>"></div>
