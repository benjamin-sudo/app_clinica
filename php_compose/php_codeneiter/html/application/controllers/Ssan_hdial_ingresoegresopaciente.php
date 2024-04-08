<?php

class Ssan_hdial_ingresoegresopaciente extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_hdial_ingresoegresopaciente_model");
        $this->load->model("Ssan_hdial_asignacionpaciente_model");
        $this->load->model("ssan_bdu_creareditarpaciente_model");
    }

    public function index(){
        $this->output->set_template('blank');
        $this->load->css("assets/Ssan_hdial_ingresoegresopaciente/css/styles.css");
        $this->load->js("assets/Ssan_hdial_ingresoegresopaciente/js/javascript.js");
        $empresa = $this->session->userdata("COD_ESTAB");
        $data_ini = $this->Ssan_hdial_ingresoegresopaciente_model->load_busqueda_rrhhdialisis([
            'empresa' => $empresa,
            'ind_opcion' => 1,
        ]);
        $this->load->view('Ssan_hdial_ingresoegresopaciente/Ssan_hdial_ingresoegresopaciente_view',$data_ini);
    }

    public function busqueda_informacion_cie10(){
        if (!$this->input->is_ajax_request()){ show_404(); }
        $v_resultados = [];
        $status = false;
        $query = $this->input->post('query');
        if (!empty($query) && strlen($query) > 2) {
            $v_resultados = $this->Ssan_hdial_asignacionpaciente_model->buscar_diagnosticos($query);
            if (!empty($v_resultados)) {
                $status = true;
            }
        }
        $this->output->set_output(json_encode(array(
            'status' => $status,
            'resultados' => $v_resultados
        )));
    }

    public function busqueda_pacientes_parametos() {
        if (!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $html = '';
        $html_card_paciente = '';
        $html_card_formularioingreso = '';
        $accesdata = [];
        $codEmpresa = $this->session->userdata("COD_ESTAB");
        $OPCION = $this->input->post('OPCION');
        $DV = $this->input->post('DV');
        $LFICHA = $this->input->post('LFICHA');
        $numFichae = '';
        $identifier = $this->input->post('RUTPAC');
        $isnal = '1';
        $pasaporte = '1';
        $tipoEx = '1';
        $respuesta_paciente = [];
        $respuesta_paciente = $this->ssan_bdu_creareditarpaciente_model->getPacientesUnico($numFichae, $identifier, $codEmpresa, $isnal, $pasaporte, $tipoEx);
        if (count($respuesta_paciente)>0){
            #informacion del cie10
            $html_card_paciente = $this->load->view('ssan_bdu_creareditarpaciente/html_card_pacienteunico',['info_bdu'=>$respuesta_paciente],true); 
            $html_card_formularioingreso = $this->load->view('Ssan_hdial_ingresoegresopaciente/html_form_ingresodialisis',[],true); 
        } else {
            $status = false;
        }
        $this->output->set_output(json_encode([
            'status' => $status,
            'respuesta_paciente' => $respuesta_paciente,
            'html_card_paciente' => $html_card_paciente,
            'html_card_formularioingreso' => $html_card_formularioingreso
        ]));
    }

    public function get_nuevo_prestador_dialisis() {
        if (!$this->input->is_ajax_request()) {  show_404();   }
        $html                           =   $this->load->view("ssan_hdial_ingresoegresopaciente/html_nuevo_profesional_dialisis",[],true);
        $this->output->set_output(json_encode(array(
            'out_html'                  =>  $html
        )));
    }

    public function html_lista_rrhhdialisis(){
        if(!$this->input->is_ajax_request()) {  show_404();   }
        $html                           =   '';
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $aData                          =   $this->Ssan_hdial_ingresoegresopaciente_model->load_busqueda_rrhhdialisis(array(
                                                'empresa'       =>  $empresa,
                                                'ind_opcion'    =>  1,
                                            )); 
        $this->output->set_output(json_encode(array(
            'html'                      =>  $aData["html_out"],
            'out_html'                  =>  $aData
        )));
    }

    public function get_eliminar_user(){
        if(!$this->input->is_ajax_request()) {  show_404();   }
        $status                         =   true;
        $status_firma                   =   true;
        $contrasena                     =   $this->input->post('contrasena');
        $cod_rutpro                     =   $this->input->post('cod_rutpro');
        $valida                         =   $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($contrasena);
        if(count($valida)>0){
            $data_number                =   $this->Ssan_hdial_ingresoegresopaciente_model->model_elimina_rrhh(array(
                "cod_rutpro"            =>  $cod_rutpro,
                "session"               =>  explode("-",$this->session->userdata('USERNAME'))[0],
                "empresa"               =>  $this->session->userdata("COD_ESTAB"),
            ));
        } else {
            $status_firma               =   false;
        }
        $this->output->set_output(json_encode(array(
            'status_firma'              =>  $status_firma,
            'status'                    =>  $status
        )));
    }
    
    public function fn_valida_profesional(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $run                            =   $this->input->post('run');
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $data_number                    =   $this->Ssan_hdial_ingresoegresopaciente_model->model_asignacion_muestra_x_user(array(
            "val_empresa"               =>  $empresa,
            "rut_profesional"           =>  $run,
        ));
        $this->output->set_output(json_encode(array(
            'data_number'               =>  $data_number,
            'status'                    =>  $status,
            'run'                       =>  $run,
            'info_prof'                 =>  $data_number["DATA"][":P_INFO_PROFESIONAL"],
            'ind_existe'                =>  $data_number["DATA"][":P_RETURN_LOGS"],
        )));
    }
    
    public function record_rotulos_por_usuario(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $ind_servicios                  =   $this->input->post('ind_servicios');
        $ind_proesional                 =   $this->input->post('info_prof');
        $contrasena                     =   $this->input->post('contrasena');
        $status_firma                   =   true;
        $data_number                    =   '';
        $valida                         =   $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($contrasena);
        if(count($valida)>0){
            $data_number                =   $this->Ssan_hdial_ingresoegresopaciente_model->model_record_rotulos_por_usuario(array(
                "ind_proesional"        =>  $ind_proesional,
                "session"               =>  explode("-",$this->session->userdata('USERNAME'))[0],
                "empresa"               =>  $this->session->userdata("COD_ESTAB"),
            ));
        } else {
            $status_firma               =   false;
        }
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'status_firma'              =>  $status_firma,
            'data_number'               =>  $data_number,
        )));
    }
    #################
    #code old
    #################
    public function BusquedaMaquinasDeDialisis(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $estados                        =   '1';
        $MKN                            =   '';
        $BTN                            =   '';
        $aData                          =   $this->Ssan_hdial_asignacionpaciente_model->ListadoMaquinasDialisis($empresa, $estados);
        $TABLA[]                        =   array("id_html" => "LISTA_MAQUINA", "opcion" => "html", "contenido" => "");
        
        if(count($aData)>0){
            foreach ($aData as $i => $row) {
                $MKN = $row['ID'];
                $html = '<tr>
                            <td>' . ($i + 1) . ''
                        . '<input type="hidden" name="nom_' . $row['ID'] . '" id="nom_' . $row['ID'] . '" value="' . $row['NOMDIAL'] . '"/>'
                        . '<input type="hidden" name="ser_' . $row['ID'] . '" id="ser_' . $row['ID'] . '" value="' . $row['SERIE'] . '"/>
                            </td>
                            <td>' . $row['NOMDIAL'] . ' <b>(' . $row['SERIE'] . ')</b></td>
                            <td>' . $row['COD'] . '</td>
                            <td>' . $row['TXTESTADO'] . '</td>
                            <td>  -  </td>
                            <td>
                                <!--
                                    <div class="btn-group">
                                        <a class="btn btn-primary" href="#"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
                                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                              <span class="fa fa-caret-down" title="-"></span>
                                            </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#"><i class="fa fa-pencil fa-fw"></i>Editar</a></li>
                                            <li><a href="#"><i class="fa fa-trash-o fa-fw"></i>Egresar</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Informaci&oacute;n</a></li>
                                        </ul>
                                    </div>
                                -->
                            </td>
                            </tr>
                            <tr>
                                <td colspan="6">';

                $html.='        
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-target="#collapseOne_' . $i . '" href="#" data-toggle="collapse">
                                    <i class="fa fa-file-text" aria-hidden="true"></i> &nbsp;&nbsp; HOJAS HEMODIALISIS X MAQUINA
                                <b class="caret"></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne_' . $i . '" class="panel-collapse collapse">
                        <div class="panel-body">
                                            
                        <table class="table table-striped table-sm" style="width:100%">
                            <tbody>
                                <!--
                                    <tr>
                                        <td colspan="4" style="text-align:center"><b> - MAQUINA (' . $MKN . ')</b></td>
                                    </tr>
                                -->
                                <tr>
                                    <td colspan="2" style="text-align:center"> 
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i><b>- GRUPO 1 (LUNES - MIERCOLES - VIERNES)</b>
                                        &nbsp;
                                        <!--
                                            <a class="btn btn-info btn-sm btn-fill btn-wd" href="javascript:asigarTurno(' . $MKN . ',1)">
                                                <i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp;TURNO&nbsp;(' . $MKN . ')
                                            </a>
                                        -->
                                        <input type="hidden" id="MKN_' . $MKN . '_1" name="MKN_' . $MKN . '_1" value="0"/>
                                        <input type="hidden" id="MKN_' . $MKN . '_1" name="MKN_' . $MKN . '_1" value="2"/>
                                        <input type="hidden" id="MKN_' . $MKN . '_1" name="MKN_' . $MKN . '_1" value="4"/>
                                    </td>
                                    <td colspan="2" style="text-align:center"> 
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i><b>- GRUPO 2 (MARTES - JUEVES - SABADO)</b>
                                        &nbsp;
                                        <!--
                                            <a class="btn btn-info btn-sm btn-fill btn-wd" href="javascript:asigarTurno(' . $MKN . ',2)">
                                                <i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp;TURNO&nbsp;(' . $MKN . ')
                                            </a>
                                        -->
                                        <input type="hidden" id="MKN_' . $MKN . '_2" name="MKN_' . $MKN . '_2" value="1"/>
                                        <input type="hidden" id="MKN_' . $MKN . '_2" name="MKN_' . $MKN . '_2" value="3"/>
                                        <input type="hidden" id="MKN_' . $MKN . '_2" name="MKN_' . $MKN . '_2" value="5"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:10%;text-align:center"><b>-HOJA 1</b></td>
                                    <td style="width:40%;text-align:left">
                                        <div id="CUPO_' . $MKN . '_1">
                                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(' . $MKN . ',1,1)" style="width: 340px;">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 1
                                            </a>
                                        </div>
                                    </td>
                                    <td style="width:10%;text-align:center"><b>-HOJA 1</b></td>
                                    <td style="width:40%;text-align:left">
                                        <div id="CUPO_' . $MKN . '_4">
                                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(' . $MKN . ',4,2)" style="width: 340px;">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 1
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center"><b>-HOJA 2</b></td>
                                    <td style="text-align:left">
                                        <div id="CUPO_' . $MKN . '_2">
                                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(' . $MKN . ',2,1)" style="width: 340px;">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 2 
                                            </a>
                                        </div>    
                                    </td>
                                    <td style="text-align:center"><b>-HOJA 2</b></td>
                                    <td style="text-align:left">
                                        <div id="CUPO_' . $MKN . '_5">
                                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(' . $MKN . ',5,2)" style="width: 340px;">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 2
                                            </a>
                                        </div>    
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center"><b>-HOJA 3</b></td>
                                    <td style="text-align:left">
                                        <div id="CUPO_' . $MKN . '_3">
                                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(' . $MKN . ',3,1)" style="width: 340px;">
                                              <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 3 
                                            </a>
                                        </div>
                                    </td>
                                    <td style="text-align:center"><b>-HOJA 3</b></td>
                                    <td style="text-align:left">
                                        <div id="CUPO_' . $MKN . '_6">
                                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(' . $MKN . ',6,2)" style="width: 340px;">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 3 
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                

                                <!-- AGREGADO 16.04.2020 POR PANDEMIA -->
                                <tr>
                                    <td style="text-align:center"><b>-HOJA 4</b></td>
                                    <td style="text-align:left">
                                        <div id="CUPO_' . $MKN . '_7">
                                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(' . $MKN . ',7,1)" style="width: 340px;">
                                              <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 4 
                                            </a>
                                        </div>
                                    </td>
                                    <td style="text-align:center"><b>-HOJA 4</b></td>
                                    <td style="text-align:left">
                                        <div id="CUPO_' . $MKN . '_8">
                                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(' . $MKN . ',8,2)" style="width: 340px;">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 4 
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
       
            ';

                $html.= '</td>
        </tr> ';
                $TABLA[] = array("id_html" => "LISTA_MAQUINA", "opcion" => "append", "contenido" => $html);
            }//FINAL DE MAQUINA 
            //BUSQUEDA DE PACIENTES YA ASIGNADOS A CUPOS
            //**************************************************************************************
            $aPaci = $this->Ssan_hdial_asignacionpaciente_model->GetPacientesxCupo($empresa);
            if (count($aPaci) > 0) {
                foreach ($aPaci as $i => $r) {
                    $BTN = '<div class="btn-group btn-group-sm">
                            <a class="btn btn-primary btn-fill btn-wd" href="#" style="width: 340px;">
                                <i class="fa fa-user-o" aria-hidden="true"></i>'
                            . $r['NOMPAC'] . '
                            </a>
                            <a class="btn btn-primary btn-fill dropdown-toggle" data-toggle="dropdown" href="#">
                              <span class="fa fa-caret-down" title="-"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!--
                                <li><a href="#"><i class="fa fa-pencil fa-fw"></i>Cambio de Cupo</a></li>
                                -->
                                <li><a href="javascript:liberarCupo(' . $r['ID_CUPO'] . ',' . $r['MKN'] . ',' . $r['TRN'] . ')"><i class="fa fa-trash-o fa-fw"></i>Liberar Cupo</a></li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Ver Hojas Dias</a></li>
                            </ul>
                        </div>';
                    $TABLA[] = array("id_html" => "CUPO_" . $r['MKN'] . "_" . $r['TRN'], "opcion" => "html", "contenido" => $BTN);
                }
            }
            //**************************************************************************************
        } else {
            $html = '<tr><td colspan="6" style="text-align:center"><b>SIN MAQUINAS</b></td></tr>';
            $TABLA[] = array("id_html" => "LISTA_MAQUINA", "opcion" => "append", "contenido" => $html);
        }

        $this->output->set_output(json_encode($TABLA));
    }

    public function gestormaquinaxturno(){
        if (!$this->input->is_ajax_request()){ show_404(); }
        
        $empresa = $this->session->userdata("COD_ESTAB");
        $html = '';
        $calendar = '';
        $headings = array('<b>DOMINGO</b>', '<b>LUNES</b>', '<b>MARTES</b>', '<b>MIERCOLES</b>', '<b>JUEVES</b>', '<b>VIERNES</b>', '<b>SABADO</b>');
        $calendar.='
                        <ul role="tablist" class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="#agency" data-toggle="tab">1R TURNO</a>  </li>
                            <li><a href="#company"  data-toggle="tab">2DO TURNO</a></li>
                            <li><a href="#style"    data-toggle="tab">3R TURNO</a> </li>
                            <li><a href="#settings" data-toggle="tab">4TO TURNO</a></li>
                            <!--
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> NUEVO TURNO <span class="caret"></span></a>
                                    <ul class="dropdown-menu"> <li><a href="javascript:nuevoTURNO(1)"><i class="fa fa-user-plus" aria-hidden="true"></i> NUEVO TURNO</a></li></ul>
                                </li>
                            -->
                        </ul>
                        <div class="tab-content">
                            <div id="agency" class="tab-pane active">
                                We2 ...
                            </div>
                            <div id="company" class="tab-pane">
                                We...
                            </div>
                            <div id="style" class="tab-pane">
                               Explore...
                            </div>
                            <div id="settings" class="tab-pane">
                                Explore2...
                            </div>
                        </div>
                        
                <script>
                <!--$("#exampleAccordion").collapse({toggle:false});-->
                </script>
                ';
        $TABLA[] = array("id_html" => "BODYXMAQUINA", "opcion" => "append", "contenido" => $calendar);
        $this->output->set_output(json_encode($TABLA));
    }

    public function controller_egresopaciente() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $empresa = $this->session->userdata("COD_ESTAB");
        $ID = $this->input->post('ID');
        $html = '';
        $html.='<div class="card">
                            <div class="header">
                                <h4 class="title"><b>DATOS DEL PACIENTE</b></h4>
                                <p class="category">Informaci&oacute;n Basica</p>
                            </div>
                            <div class="content">
                                 <dl class="row">
                                    <dt class="col-sm-2"><i class="fa fa-user-circle" aria-hidden="true"></i></dt>
                                    <dd class="col-sm-10"><b>- ' . $this->input->post('NOMBRE_PAC') . '</b></dd>
                                    <dt class="col-sm-2"><i class="fa fa-id-card-o" aria-hidden="true"></i></dt>
                                    <dd class="col-sm-10"><b>- ' . $this->input->post('RUT_PAC') . '</b></dd>
                                    <dt class="col-sm-2"><i class="fa fa-mobile" aria-hidden="true"></i></dt>
                                    <dd class="col-sm-10"><b>- ' . $this->input->post('CELULAR') . '</b></dd>
                                    <dt class="col-sm-2"><i class="fa fa-birthday-cake" aria-hidden="true"></i></dt>
                                    <dd class="col-sm-10"><b>- ' . $this->input->post('EDAD') . '</b></dd>
                                    <hr>
                                    <dt class="col-sm-12" style="text-align:center">
                                        <hr>
                                            <h4 class="title"><b>TIPO DE EGRESO:</b></h4>
                                            <select id="num_egreso" name="egreso" onchange="js_tipoTraslado(this.value)">
                                                <option value="" >--</option>
                                                <option value="1">TRASLADO PERMANENTE</option>
                                                <option value="2">TRASLADO TRANSITORIO</option>
                                                <option value="3">FALLECIMIENTO</option>
                                                <option value="4">PERITONEO</option>
                                                <option value="5">TRASPLANTE</option>
                                            </select>
                                        <hr>
                                    </dt>
                                    <dt class="col-sm-12" style="text-align:center">
                                         <button type="button" class="btn btn-info" onclick="E_INGRESODIAL(' . $ID . ',' . $this->input->post('numfichae') . ')"> EGRESO PROGRAMA HEMODIALISIS </button>
                                    </dt>
                                </dl>
                            </div>
                        </div>
                        ';

        $TABLA[] = array("id_html" => "BODYXMAQUINA", "opcion" => "append", "contenido" => $html);
        $this->output->set_output(json_encode($TABLA));
    }

    public function EgresaPaciente() {
        if (!$this->input->is_ajax_request()) {  show_404();   }
        $empresa = $this->session->userdata("COD_ESTAB");
        $transaccion = '';
        $return = '';
        $password = $this->input->post('password');
        $numIgreso = $this->input->post('numIgreso');
        $id_egreso = $this->input->post('id_egreso');
        $num_fichae = $this->input->post('numfichae');
        $valida = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
        if ($valida) {
            $return = true;
            $usuarioh = explode("-", $_SESSION['USERNAME']); //Rut Del Usuario        
            $session = $usuarioh[0];
            $transaccion = $this->Ssan_hdial_asignacionpaciente_model->ModelEgresaPaciente($empresa, $session, $numIgreso, $id_egreso, $num_fichae);
        } else {
            $return = false;
        }
        $TABLA[0] = array("validez" => $return);
        $TABLA[1] = array("transaccion" => $transaccion);
        $TABLA[3] = array("sql" => '');
        $this->output->set_output(json_encode($TABLA));
    }

    public function pacientexMaquina() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $empresa = $this->session->userdata("COD_ESTAB");
        $TABLA[] = array("id_html" => "PACIENTEXMAQUINA", "opcion" => "html", "contenido" => '');
        $estados = '1';
        $ul = '';
        $aData = $this->Ssan_hdial_asignacionpaciente_model->ListadoMaquinasDialisis($empresa, $estados);
        if (count($aData) > 0) {
            foreach ($aData as $i => $row) {
                $ul = '';
            }
        }
        $TABLA[] = array("id_html" => "PACIENTEXMAQUINA", "opcion" => "append", "contenido" => $empresa);
        $this->output->set_output(json_encode($TABLA));
    }

    public function addcupoPaciente() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $empresa = $this->session->userdata("COD_ESTAB");
        $MKN = $this->input->post('MKN');
        $GRP = $this->input->post('GRP');
        $html = '';
        //busqueda de pacientes que no tengas cupo asignado
        $rutPac = '';
        $numFichae = '';
        $estados = '1';
        $conIngreso = '1';

        $aData = $this->Ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDial($empresa, $estados, $numFichae, $rutPac, $conIngreso);
        $html .= '<div class="card">
                    <div class="header">
                        <h4 class="title"><b>SELECCIONE PACIENTE A ASIGNAR CUPO</b></h4>
                        <p class="category">Informaci&oacute;n Basica</p>
                    </div>
                    <dt class="col-sm-12" style="text-align:center">
                        <select id="idPaciente" name="idPaciente" class="form-control" onchange="js_idPac(this.id)">
                            <option value="0"> Seleccione ...</option> ';
        if (count($aData) > 0) {
            foreach ($aData as $row) {
                $html.='<option value="' . $row['ID_INGRESO'] . '#' . $row['NUM_FICHAE'] . '">' . $row['NOM_APELLIDO'] . '</option>';
            }
        } else {
            $html.='<option value="0"> SIN PACIENTES ...</option>';
        }
        $html.='</select>
                            </dt>
                            <hr>
                            <div class="content">
                                <dl class="row">
                                <!--
                                   <dt class="col-sm-2"><i class="fa fa-id-card-o" aria-hidden="true"></i></dt>
                                   <dd class="col-sm-10">&nbsp;&nbsp;</dd>
                                   <dt class="col-sm-2"><i class="fa fa-mobile" aria-hidden="true"></i></dt>
                                   <dd class="col-sm-10">&nbsp;&nbsp;</dd>
                                   <dt class="col-sm-2"><i class="fa fa-birthday-cake" aria-hidden="true"></i></dt>
                                   <dd class="col-sm-10">&nbsp;&nbsp;</dd>
                                   <hr>
                                -->
                                </dl>
                            </div>
                        </div>
                    ';

        $TABLA[] = array("id_html" => "HTML_PACIENE", "opcion" => "append", "contenido" => $html);
        $this->output->set_output(json_encode($TABLA));
    }

    public function TraeDatIng() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $txtBuscar = $this->input->post('txtBuscar');
        $ed = $this->input->post('ed');//contiene origen a editar
        $row = $this->ssan_hdial_ingresoegresopaciente_model->Cons_ingresoPac($txtBuscar, $this->empresa);
        $html = '';
        $exito = '';
        $nfichaeee = '';
         $ssss=0;
        if ($row) {
            //TRAER ULTIMO REGISTRO Y PREGUNTAR
            //si cuenta con ingreso ==> no debo mostrar formulario
            //si cuenta con egreso==>traer informacion de formulario aplicado anterior mente, con posibilidad de volver a crear un nuevo ingreso
            //si no tiene ingreso, mostrar formulario vacio, con posibilidades de crear ingreso
            //si cuenta con ingreso en oto hospital, no debo dejar aberir formulario
            if ($row[0]['ID_EGRESO'] == '' && $ed=='') {//solo cuenta con ingreso
                //   $html.='<script>$("#Dv_form_IngEnf").show();</script>';
                //
                 $row[0]['ID_INGRESO'];//origen
                
                $html.='<script>Limpiar1();$("#Dv_form_IngEnf").hide();$("#dv_mnj_frm").html("<div class=\'alert alert-danger\' style=\'margin-left: 38px;    margin-right: 38px; \'><span>\"El paciente ya cuenta con un INGRESO.<br><a onclick=\'js_grabadatosPaciente('.$row[0]['ID_INGRESO'].');\'  style=\'cursor:pointer\'>Editar Ultimo Registro</a>\"</span></div>");$("#dv_mnj_frm").show().fadeOut("slow").fadeIn("slow");</script>';
                $exito = 0;
                $ssss=0;
                //  break;
            } else {//cuenta con un egreso, por lo tanto puede crear un nuevo ingreso
                //pero trae respustas del formulario anterior
                // $html.='<script>$("#ind_ing").val('.$row['ID_INGRESO'].');</script>';
                $row[0]['ID_INGRESO'];
                $row[0]['COD_EMPRESA'];
                $row[0]['DATE_EGRESO'];
                $row[0]['ID_ESTADOHD'];
                $row[0]['NUM_FICHAE'];

                $nfichaeee = $row[0]['NUM_FICHAE'];
                $exito = 1;
                //traer datos obtenidos en formulario anterior
$ssss=0;
                $aData22 = $this->ssan_hdial_ingresoegresopaciente_model->TraeREspxProg($nfichaeee, $this->empresa);
                if (count($aData22) > 0) {
                    foreach ($aData22 as $i => $row22) {
                        $ress_sul = '';



                        $row22['ID_CAMPXPROG'];
                        $row22['RESULTADO'];
                        //$html.='<script>console.log("' . $row22['RESULTADO'] . '");</script>';

                        if ($row22['ID_CAMPXPROG'] == 542 || $row22['ID_CAMPXPROG'] == 546 || $row22['ID_CAMPXPROG'] == 568 ) {//|| $row22['ID_CAMPXPROG'] == 577


                            if ($row22['ID_CAMPXPROG'] == 542) {
                                $ssss=$row22['RESULTADO'];
                                $html.='<script>$("#Rdo_infenf_Ant_Alerg_' . $row22['RESULTADO'] . '").prop("checked", true);</script>';
//                             $ress_sul='';
//                             if($row22['RESULTADO']==1){  $ress_sul='SI';   }
//                              if($row22['RESULTADO']==2){  $ress_sul='NO';   }
//                               if($row22['RESULTADO']==3){  $ress_sul='NO SABE';   }
//                              $html.='<script>$("#RESPUESTA_Resp_IngEnf_Dial_542").html("<b>[</b> '.$ress_sul.' <b>]</b>");</script>'; 
                            }


                            if ($row22['ID_CAMPXPROG'] == 546) {//diagnosicos cie
                            
                                $row22['COD_DIAGNO_CIE'];
                                        $row22['DESCRIPCION'];                               
                        $html.='<script>$( "<tr id=\'TR_Cie10_'.$row22['COD_DIAGNO'].'\'><td>  <p>' . $row22['COD_DIAGNO_CIE'] . ' - ' . $row22['DESCRIPCION'] . '</p><input type=\'hidden\' value=\''.$row22['COD_DIAGNO'].'\' id=\'Hd_Cie10_'.$row22['COD_DIAGNO'].'\'></td><td><a style=\'padding: 1px;background-color: #c91f25;\' class=\'btn btn-small btn-success\' onclick=\'EliminaFilaCie10('.$row22['COD_DIAGNO'].');select_2();\'><i class=\'fa fa-times icon-large\'></i></a></td></tr>" ).appendTo( "#Cod_cie10_1" );</script>';
                
                                
                            }


                            if ($row22['ID_CAMPXPROG'] == 568) {
                                $html.='<script>$("#Rdo_Diuesis_' . $row22['RESULTADO'] . '").prop("checked", true);</script>';
                                 $html.='<script>$("#Resp_IngEnf_Dial_' . $row22['ID_CAMPXPROG']. '").val(' . $row22['RESULTADO'] . ');</script>';

//                              if($row22['RESULTADO']==1){  $ress_sul='SI';   }
//                              if($row22['RESULTADO']==2){  $ress_sul='NO';   }                               
//                              $html.='<script>$("#RESPUESTA_Resp_IngEnf_Dial_568").html("<b>[</b> '.$ress_sul.' <b>]</b>");</script>'; 
                            }
//                            if ($row22['ID_CAMPXPROG'] == 577) {
//                                $html.='<script>$("#Rdo_QQB_' . $row22['RESULTADO'] . '").prop("checked", true);</script>';
//
//
////                              if($row22['RESULTADO']==1){  $ress_sul='I';   }
////                              if($row22['RESULTADO']==2){  $ress_sul='M';   }                               
////                              $html.='<script>$("#RESPUESTA_Resp_IngEnf_Dial_577").html("<b>[</b> '.$ress_sul.' <b>]</b>");</script>'; 
//                            }
                        } else {
                            
                             $cadena_old=$row22['RESULTADO'] ;
                       // $cadena_nueva = eregi_replace("[\n|\r|\n\r]", '', $cadena_old);
                        
                         $sustituye = array("\r\n", "\n\r", "\n", "\r");
                        $cadena_nueva = str_replace($sustituye, "", $cadena_old);
                            
                            $html.='<script>$("#Resp_IngEnf_Dial_' . $row22['ID_CAMPXPROG'] . '").val("' .$cadena_nueva . '");</script>';
                             $html.='<script>$("#r_espuesta_' . $row22['ID_CAMPXPROG'] . '_old").val("' .$cadena_nueva . '");</script>';
//                     $html.='<script>$("#imp_Resp_IngEnf_Dial_'.$row22['ID_CAMPXPROG'].'").val("'.$row22['RESULTADO'].'");</script>';
                        }
                    }
                }
                
                
            }
        } else {
            $exito = 1;
        }
        if ($exito == 1) {
            $html.='<script>$("#Dv_form_IngEnf").show();</script>';
            $html.='<script>$("#dv_mnj_frm").html("")</script>';
            
            if($ed!=''){
                $html.='<script>$("#spn_BtnEdi").html("<a class=\'btn btn-primary\' onclick=\'grab('.$ed.');\'><i class=\'\'></i> EDITAR</a>");</script>';
                $html.='<script>$("#spn_BtnGrab").html("");</script>';
            }else{
                $html.='<script>$("#spn_BtnEdi").html("");</script>';
                $html.='<script>$("#spn_BtnGrab").html("<button type=\'submit\' class=\'btn btn-success\'><i class=\'pe-7s-diskette\'></i> INGRESO PROGRAMA HEMODIALISIS </button>");</script>';
            }
           
        }

        
        if($ssss!=0){
            $html.='<script>selec_(542,'.$ssss.');</script>';
        }
        //$html.='<script>$("#Btn_imp_imng").html("<a class=\'btn btn-info\' href=\'javascript:imprimePdrf()\' aria-label=\'Print\'><i class=\'fa fa-search\' aria-hidden=\'true\'></i> IMPRIMIR</a>")</script>';
        $this->output->set_output($html);
    }

    public function TraeDatIng_IMP() {
        if (!$this->input->is_ajax_request()){ show_404(); }
        $txtBuscar = $this->input->post('txtBuscar');
        $row = $this->ssan_hdial_ingresoegresopaciente_model->Cons_ingresoPac($txtBuscar, $this->empresa);
        $html = '';
        $exito = '';
        $nfichaeee = '';
       // $html.='<script>console.log("-------------1");</script>';
        if ($row) {
           // $html.='<script>console.log("-------------2");</script>';


            //TRAER ULTIMO REGISTRO Y PREGUNTAR
            //si cuenta con ingreso ==> no debo mostrar formulario
            //si cuenta con egreso==>traer informacion de formulario aplicado anterior mente, con posibilidad de volver a crear un nuevo ingreso
            //si no tiene ingreso, mostrar formulario vacio, con posibilidades de crear ingreso
            //si cuenta con ingreso en oto hospital, no debo dejar aberir formulario
            //solo cuenta con ingreso
          //  $html.='<script>console.log("-------------3");</script>';

            //   $html.='<script>$("#Dv_form_IngEnf").show();</script>';
            //   $html.='<script>$("#dv_mnj_frm").html("<div class=\'alert alert-danger\' style=\'margin-left: 38px;    margin-right: 38px; \'><span>\"El paciente ya cuenta con un INGRESO.\"</span></div>");$("#dv_mnj_frm").show().fadeOut("slow").fadeIn("slow");</script>';
            $exito = 0;
            //  break;
            //cuenta con un egreso, por lo tanto puede crear un nuevo ingreso
            //pero trae respustas del formulario anterior
            // $html.='<script>$("#ind_ing").val('.$row['ID_INGRESO'].');</script>';
         //   $html.='<script>console.log("-------------4");</script>';
            $row[0]['ID_INGRESO'];
            $row[0]['COD_EMPRESA'];
            $row[0]['DATE_EGRESO'];
            $row[0]['ID_ESTADOHD'];
            $row[0]['NUM_FICHAE'];

            $nfichaeee = $row[0]['NUM_FICHAE'];
            $exito = 1;
            //traer datos obtenidos en formulario anterior
//$ssss=0;
 
            $NOM_NOMBRE='';
            $NOM_PREVIS='';
            $FEC_NACIMI='';
            $NOM_NOMBRE='';
            $NOM_APEPAT='';
            $NOM_APEMAT='';
            $NOM_ESTABL='';
            $COD_RUTPAC='';
            $COD_DIGVER='';
            $edad='';

            $aData22 = $this->ssan_hdial_ingresoegresopaciente_model->TraeREspxProg($nfichaeee, $this->empresa);
            if (count($aData22) > 0) {
                foreach ($aData22 as $i => $row22) {
                 //   $html.='<script>console.log("-------------5");</script>';
                    $ress_sul = '';
        
                    if($NOM_NOMBRE==''){
                        $NOM_PREVIS=$row22['NOM_PREVIS'];
                        $FEC_NACIMI=$row22['FEC_NACIMI'];
                        //_____________Edad_____________
                        $dias = explode("/", $FEC_NACIMI, 3);
                        $dias = mktime(0, 0, 0, $dias[1], $dias[0], $dias[2]);
                        $edad = (int) ((time() - $dias) / 31556926 );
                        //_____________Edad_____________

                        $NOM_NOMBRE= $row22['NOM_NOMBRE'];
                        $NOM_APEPAT=$row22['NOM_APEPAT'];
                        $NOM_APEMAT=$row22['NOM_APEMAT'];
                        $NOM_ESTABL=$row22['NOM_ESTABL'];

                        $COD_RUTPAC=$row22['COD_RUTPAC'];
                        $COD_DIGVER=$row22['COD_DIGVER'];

                        $html.='<script>$("#imp_Rutpac").val("' .  $COD_RUTPAC . '-'.$COD_DIGVER . '");</script>';
                        $html.='<script>$("#imp_Nompaciente").val("' . $NOM_NOMBRE . ' ' . $NOM_APEPAT . ' ' . $NOM_APEMAT . '");</script>';
                        $html.='<script>$("#imp_PrevPac").val("' . $NOM_PREVIS . '");</script>';
                        $html.='<script>$("#imp_EdadPac").val("' . $edad . ' Años");</script>';
                        $html.='<script>$("#imp_Estabreg").val("' . $NOM_ESTABL.'");</script>';
             
                    }
            
                    $row22['ID_CAMPXPROG'];
                    $row22['RESULTADO'];
                   // $html.='<script>console.log("' . $row22['RESULTADO'] . '");</script>';
                    if ($row22['ID_CAMPXPROG'] == 542 || $row22['ID_CAMPXPROG'] == 546 || $row22['ID_CAMPXPROG'] == 568 ) {//|| $row22['ID_CAMPXPROG'] == 577
                        if ($row22['ID_CAMPXPROG'] == 542) {
                            //$html.='<script>$("#Rdo_infenf_Ant_Alerg_'.$row22['RESULTADO'].'").prop("checked", true);</script>'; 
                            $ress_sul = '';
                            if ($row22['RESULTADO'] == 1) {
                                //$ssss=1;
                                $ress_sul = 'SI';
                               
                            }
                            if ($row22['RESULTADO'] == 2) {
                               //  $ssss=2;
                                $ress_sul = 'NO';
                                
                            }
                            if ($row22['RESULTADO'] == 3) {
                                // $ssss=3;
                                $ress_sul = 'NO SABE';
                                 
                            }
                            if ($row22['RESULTADO'] != 1 && $row22['RESULTADO'] != 2 && $row22['RESULTADO'] != 3) {
                                $ress_sul = '____';
                            }
                            $html.='<script>$("#RESPUESTA_Resp_IngEnf_Dial_542").html("<b>[</b> ' . $ress_sul . ' <b>]</b>");</script>';
                        }


                        if ($row22['ID_CAMPXPROG'] == 546) {//diagnosicos cie
                            $row22['COD_DIAGNO_CIE'];
                            $row22['DESCRIPCION'];                               
                            $html.='<script>$( "<p>' . $row22['COD_DIAGNO_CIE'] . ' - ' . $row22['DESCRIPCION'] . '</p>" ).appendTo( "#imp_Cod_cie10_1" );</script>';
                        }


                        if ($row22['ID_CAMPXPROG'] == 568) {
                            //$html.='<script>$("#Rdo_Diuesis_'.$row22['RESULTADO'].'").prop("checked", true);</script>'; 
                            if ($row22['RESULTADO'] == 1) {
                                $ress_sul = 'SI';
                            }
                            if ($row22['RESULTADO'] == 2) {
                                $ress_sul = 'NO';
                            }
                            if ($row22['RESULTADO'] != 1 && $row22['RESULTADO'] != 2) {
                                $ress_sul = '____';
                            }
                            $html.='<script>$("#RESPUESTA_Resp_IngEnf_Dial_568").html("<b>[</b> ' . $ress_sul . ' <b>]</b>");</script>';
                        }

//                        if ($row22['ID_CAMPXPROG'] == 577) {
//                             $html.='<script>$("#Rdo_QQB_'.$row22['RESULTADO'].'").prop("checked", true);</script>';
//                             $html.='<script>$("#imp_Rdo_QQB_'.$row22['RESULTADO'].'").prop("checked", true);</script>';
//                            if ($row22['RESULTADO'] == 1) {
//                                $ress_sul = 'I';
//                            }
//                            if ($row22['RESULTADO'] == 2) {
//                                $ress_sul = 'M';
//                            }
//                            if ($row22['RESULTADO'] != 1 && $row22['RESULTADO'] != 2) {
//                                $ress_sul = '____';
//                            }
//                            $html.='<script>$("#RESPUESTA_Resp_IngEnf_Dial_577").html("<b>[</b> ' . $ress_sul . ' <b>]</b>");</script>';
//                        }

                    } else {
                        //$html.='<script>console.log("-------------6");</script>';
                        //$html.='<script>$("#Resp_IngEnf_Dial_'.$row22['ID_CAMPXPROG'].'").val("'.$row22['RESULTADO'].'");</script>';
                        $cadena_old=$row22['RESULTADO'] ;
                        // $cadena_nueva = eregi_replace("[\n|\r|\n\r]", '', $cadena_old);
                        $sustituye = array("\r\n", "\n\r", "\n", "\r");
                        $cadena_nueva = str_replace($sustituye, "", $cadena_old);
                        $html.='<script>$("#imp_Resp_IngEnf_Dial_' . $row22['ID_CAMPXPROG'] . '").val("' . $cadena_nueva . '");</script>';
                    }
                }
            }

        
        // $html.='<script>console.log("-------------7");</script>';
        } else {
            $exito = 1;
           // $html.='<script>console.log("-------------8");</script>';
        }
        if ($exito == 1) {
            //$html.='<script>$("#Dv_form_IngEnf").show();</script>';
            //$html.='<script>$("#dv_mnj_frm").html("")</script>';
            //$html.='<script>console.log("-------------9");</script>';
        }

        //$html.='<script>$("#Btn_imp_imng").html("<a class=\'btn btn-info\' href=\'javascript:imprimePdrf()\' aria-label=\'Print\'><i class=\'fa fa-search\' aria-hidden=\'true\'></i> IMPRIMIR</a>")</script>';
        $html.='<script>imprimePdrf();</script>';
        //$html.='<script>console.log("-------------10");</script>';
        $this->output->set_output($html);
    }

    public function BusquedaPacientesIngreso() {
        if(!$this->input->is_ajax_request()){  show_404();  }
	    $empresa = $this->session->userdata("COD_ESTAB");
        $html = '';
        $numFichae = '';
        $rutPac = '';
        $estados = '1';
        $conIngreso	= '0';
        $aData = $this->Ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDial($empresa, $estados, $numFichae, $rutPac, $conIngreso);
        //$TABLA[] = array("id_html" => "LISTA_PACIENTES", "opcion" => "console", "contenido" => $aData);
        if(count($aData) > 0) {
            foreach ($aData as $i => $row) {
                $rut_pac_s = explode("-",$row['RUTPAC']); //rut del usuario        
                $rut_pac_s = $rut_pac_s[0];

                $html = '
                   <tr>
                        <td>' . ($i + 1) . '</td>
                        <td>' .$row['RUTPAC']. '</td>
                        <td>' . $row['NOM_APELLIDO'] . '
                            <input type="hidden" id="nombre_' . $row['ID_INGRESO'] . '"     name="nombre_' . $row['ID_INGRESO'] . '"    value="' . $row['NOM_APELLIDO'] . '"/>
                            <input type="hidden" id="edad_' . $row['ID_INGRESO'] . '"       name="edad_' . $row['ID_INGRESO'] . '"      value="' . $row['TXTEDAD'] . '"/>
                            <input type="hidden" id="telefono_' . $row['ID_INGRESO'] . '"   name="telefono_' . $row['ID_INGRESO'] . '"  value="' . $row['CELULAR'] . '"/>
                            <input type="hidden" id="rut_' . $row['ID_INGRESO'] . '"        name="rut_' . $row['ID_INGRESO'] . '"       value="' . $row['RUTPAC'] . '"/>
                        </td>
                        <td>' . $row['TXTEDAD'] . '</td>
                        <td>' . $row['FINGRESO'] . '</td>
                        <td>' . $row['FINGRESO_HISTO'] . '</td>
                        <td>' . $row['TXTESTADO'] . '</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-primary" href="#">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                </a>
                                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="fa fa-caret-down" title="-"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:iPesoseco(' . $row['NUM_FICHAE'] . ')"><i class="fa fa-info" aria-hidden="true"></i> Informacion H. Diaria</a></li>
                                    <li class="divider"></li>     
                                    <!--
                                    <li><a href="javascript:iMedico(' . $row['NUM_FICHAE'] . ')"><i class="fa fa-info-circle" aria-hidden="true"></i> Informaci&oacute;n Medico</a></li>
                                    <li><a href="javascript:iEnfermeria(' . $row['ID_INGRESO'] . ',' . $row['NUM_FICHAE'] . ')"><i class="fa fa-wpforms" aria-hidden="true"></i> I. Enfermeria</a></li>
                                    <li class="divider"></li>   
                                    -->    
                                    <li><a href="javascript:js_imprimiringeg(' . $rut_pac_s . ')"><i class="fa fa-print" aria-hidden="true"></i> Ingreso Enfermeria</a></li>
                                    <li><a href="javascript:js_cBUSQUEDAHANTERIOR(' . $row['NUM_FICHAE'] . ',1)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Ver Hojas Diarias</a></li>
                                    <li class="divider"></li>
                                    <li><a href="javascript:egresar(' . $row['ID_INGRESO'] . ',' . $row['NUM_FICHAE'] . ')"><i class="fa fa-user-times" aria-hidden="true"></i> Egresar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr> 
                ';
                //<li><a href="javascript:js_cBUSQUEDAHANTERIOR('.$row['NUM_FICHAE'].',1)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Ver Hojas Diarias</a></li>  
                $TABLA[] = array("id_html" => "LISTA_PACIENTES", "opcion" => "append", "contenido" => $html);
            }
        } else {
            $html = '<tr><td colspan="8" style="text-align:center"><b>SIN PACIENTES</b></td></tr>';
            $TABLA[] = array("id_html" => "LISTA_PACIENTES", "opcion" => "append", "contenido" => $html);
        }
        $this->output->set_output(json_encode($TABLA));
    }

    public function guardaNuevoPacienteIngreso() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $empresa = $this->session->userdata("COD_ESTAB");
        $transaccion = '';
        $return = '';
        $numfichae = $this->input->post('NumFichae');
        $password = $this->input->post('password');
        $valida = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
        if ($valida) {
            $return = true;
            $usuarioh = explode("-", $_SESSION['USERNAME']); //Rut Del Usuario        
            $session = $usuarioh[0];
            $transaccion = $this->Ssan_hdial_asignacionpaciente_model->ModelNuevoPacienteIngreso($empresa, $session, $numfichae);
        } else {
            $return = false;
        }
        $TABLA[0] = array("validez" => $return);
        $TABLA[1] = array("transaccion" => $transaccion);
        $TABLA[3] = array("sql" => '');
        $this->output->set_output(json_encode($TABLA));
    }

    public function eliminaPacientexCupo() {
        $empresa = $this->session->userdata("COD_ESTAB");
        $transaccion = '';
        $return = '';
        $password = $this->input->post('password');
        $ID_CUPO = $this->input->post('ID_CUPO');
        $MKN = $this->input->post('MKN');
        $TRN = $this->input->post('TRN');
        $valida = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
        if ($valida) {
            $return = true;
            $usuarioh = explode("-", $valida->USERNAME); //Rut Del Usuario que firma       
            $session = $usuarioh[0];
            $transaccion = $this->Ssan_hdial_asignacionpaciente_model->ModeleliminaPacientexCupo($empresa, $session, $ID_CUPO, $MKN, $TRN);
        } else {
            $return = false;
        }
        $TABLA[0] = array("validez" => $return);
        $TABLA[1] = array("transaccion" => $transaccion);
        $TABLA[3] = array("sql" => '');
        $this->output->set_output(json_encode($TABLA));
    }

    public function guardaPacientexCupo() {
        if (!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $transaccion = '';
        $return = '';
        $password = $this->input->post('password');
        $datoPac = explode("#", $this->input->post('datoPac'));
        $numfichae = $datoPac[1];
        $numingreso = $datoPac[0];
        $MKN = $this->input->post('MKN');
        $GRP = $this->input->post('GRP');
        $DIAS = $this->input->post('DIAS');

        $valida = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
        if ($valida) {
            $return = true;
            $usuarioh = explode("-", $valida->USERNAME); //Rut Del Usuario que firma       
            $session = $usuarioh[0];
            $transaccion = $this->Ssan_hdial_asignacionpaciente_model->ModelNuevoPacientexCupo($empresa, $session, $numfichae, $numingreso, $MKN, $GRP, $DIAS);
        } else {
            $return = false;
        }
        $TABLA[0] = array("validez" => $return);
        $TABLA[1] = array("transaccion" => $transaccion);
        $TABLA[3] = array("sql" => '');
        $this->output->set_output(json_encode($TABLA));
    }

    public function autocompletar2() {
        //llamada info dejamos pasar
        $html = '';
        if ($this->input->is_ajax_request() && $this->input->post('value')) {
            $abuscar = strtoupper($this->security->xss_clean($this->input->post("value")));
            $sexo = $this->input->post('value');
            $sqlfrecuencia = 'N';
            $search = $this->ssan_crearinterconsulta_model->buscaDiagnostico($sexo, $sqlfrecuencia, $abuscar);
            //si search es distinto de false significa que hay resultados
            //y los mostramos con un loop foreach
            $html .= '<a class="autocomplete-jquery-item autocomplete-jquery-mark" onclick="$(\'.autocomplete-jquery-results\').hide();Cod_o_Text(2);" data-id="0"><b>CODIGO - DESCRIPCION DIAGNOSTICA ( CERRAR VENTANA  [X])</b></a>';
            if ($search) {
                $i = 0;
                foreach ($search as $fila) {
                    $i++;
                    if ($fila['IND_GES'] == 0) {
                        $html .= '<a class="autocomplete-jquery-item" onclick="  onClickDiagnostico2(\'' . $fila['COD_DIAGNO_CIE'] . '\',\'' . $fila['DESCRIPCION'] . '\',\'' . $fila['COD'] . '\',0);select_2();" data-id="' . $i . '">' . $fila['COD_DIAGNO_CIE'] . ' - ' . $fila['DESCRIPCION'] . '</a>';
                    } else if ($fila['IND_GES'] == 1) {
                        $html .= '<a class="autocomplete-jquery-item" onclick=" onClickDiagnostico2(\'' . $fila['COD_DIAGNO_CIE'] . '\',\'' . $fila['DESCRIPCION'] . '\',\'' . $fila['COD'] . '\',1);select_2();" data-id="' . $i . ')">' . $fila['COD_DIAGNO_CIE'] . ' - ' . $fila['DESCRIPCION'] . ' <img style="width: 30px;padding-bottom: 3px;" src="assets/ssan_seleccionarinterconsulta/img/ges.png"></a>';
                        //habGes('.$fila['COD'].');
                    }
                }
            }
        }
        $this->output->set_output($html);
    }

    public function Graba_Respuesta_2() {//segundo formulario
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $clave = $this->input->post('Clave');
        $Sl_Hipo_sion1 = $this->input->post('Sl_Hipo_sion1');
        $Sl_Hipo_sion2 = $this->input->post('Sl_Hipo_sion2');
        $Sl_Hipo_sion3 = $this->input->post('Sl_Hipo_sion3');
        $Sl_Ca_frio1 = $this->input->post('Sl_Ca_frio1');
        $Sl_Ca_frio2 = $this->input->post('Sl_Ca_frio2');
        $Sl_Ca_frio3 = $this->input->post('Sl_Ca_frio3');
        $Sl_F_bre1 = $this->input->post('Sl_F_bre1');
        $Sl_F_bre2 = $this->input->post('Sl_F_bre2');
        $Sl_F_bre3 = $this->input->post('Sl_F_bre3');
        $Sl_Inf_catt1 = $this->input->post('Sl_Inf_catt1');
        $Sl_Inf_catt2 = $this->input->post('Sl_Inf_catt2');
        $Sl_Inf_catt3 = $this->input->post('Sl_Inf_catt3');
        $Sl_Bact_meia1 = $this->input->post('Sl_Bact_meia1');
        $Sl_Bact_meia2 = $this->input->post('Sl_Bact_meia2');
        $Sl_Bact_meia3 = $this->input->post('Sl_Bact_meia3');
        $Sl_Hep_b1 = $this->input->post('Sl_Hep_b1');
        $Sl_Hep_b2 = $this->input->post('Sl_Hep_b2');
        $Sl_Hep_b3 = $this->input->post('Sl_Hep_b3');
        $Sl_Hep_c1 = $this->input->post('Sl_Hep_c1');
        $Sl_Hep_c2 = $this->input->post('Sl_Hep_c2');
        $Sl_Hep_c3 = $this->input->post('Sl_Hep_c3');
        $Sl_mrtes_pro1 = $this->input->post('Sl_mrtes_pro1');
        $Sl_mrtes_pro2 = $this->input->post('Sl_mrtes_pro2');
        $Sl_mrtes_pro3 = $this->input->post('Sl_mrtes_pro3');

        $valida = $this->ssan_hdial_ingresoegresopaciente_model->validaClave($clave);
        if ($valida) {//si esta todo ok puedo grabar
            $rut = $valida->USERNAME;
            $rutm = explode("-", $rut);
            $RUTFir = $rutm[0];
            $DIGFir = $rutm[1];
            $nombrefir = $valida->NAME . ' ' . $valida->MIDDLE_NAME . ' ' . $valida->LAST_NAME;
//            $returnINSERTFuncion = $this->ssan_hdial_ingresoegresopaciente_model->INSERT_GuardaDatos($RUTFir,$DIGFir,$nombrefir);
//            if ($returnINSERTFuncion) {
//                $html_out.= '<script>jAlert("Los datos fueron grabados.  ","ODONTO");</script>';
//            } else {
//                $html_out.= '<script>jAlert("Error al grabar","ODONTO");</script>';
//            }
            $html_out .= '<script>jAlert("Respuestas Guardadas OK", "Restricci\u00f3n");</script>';
        } else {//error en la firma
            $html_out .= '<script>jAlert("Firma Incorrecta", "Restricci\u00f3n");</script>';
        }
        $this->output->set_output($html_out);
    }

    public function Graba_Respuesta() {
        if (!$this->input->is_ajax_request()){ show_404(); }
        $html_out = '';
        $ed = $this->input->post('ed');
        $clave = $this->input->post('Clave');
        $fic_e = $this->input->post('fic_e');
        $Resp_IngEnf_Dial = $this->input->post('Resp_IngEnf_Dial');
        $Cie10Agrupados = $this->input->post('Cie10Agrupados');
        $fecha_histo = $this->input->post('fec_histo');
        $valida = $this->ssan_hdial_ingresoegresopaciente_model->validaClave($clave);
        if ($valida) {//si esta todo ok puedo grabar
            $rut = $valida->USERNAME;
            $rutm = explode("-", $rut);
            $RUTFir = $rutm[0];
            $DIGFir = $rutm[1];
            $nombrefir = $valida->NAME . ' ' . $valida->MIDDLE_NAME . ' ' . $valida->LAST_NAME;
            $transaccion = $this->ssan_hdial_ingresoegresopaciente_model->ModelNuevoPacienteIngreso($ed,$this->usuario, $this->empresa, $RUTFir, $DIGFir, $nombrefir, $fic_e, $Resp_IngEnf_Dial, $Cie10Agrupados, $fecha_histo);
            if ($transaccion) {
                $html_out.= '<script>jAlert("Los datos fueron grabados.","FORMULARIO");</script>';
                $html_out.= '<script>Limpiar1();$("#Rut_form").val("");$("#nuevoProfesional").modal("hide");busquedaPacientes();busquedaPacientesxMaquina(); $("#r_espuesta_543_old").val("");  $("#r_espuesta_544_old").val("");   $("#r_espuesta_545_old").val(""); </script>';
            } else {
                $html_out.= '<script>jAlert("Error al grabar RESPUESTAS","FORMULARIO");</script>';
            }
        } else {//error en la firma
            $html_out .='<script>jAlert("Firma Incorrecta", "Restricci\u00f3n");</script>';
        }
        $this->output->set_output($html_out);
    }

    public function fn_guarda_ingresohermodialisis(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status             =   true;
        $v_num_unico        =   '';
        $empresa            =   $this->session->userdata("COD_ESTAB");
        $v_num_fichae       =   $this->input->post('v_num_fichae');
        $arr_envio          =   $this->input->post('arr_envio');
        $arr_codcie10       =   $this->input->post('arr_codcie10');
        $v_contrasena       =   $this->input->post('contrasena');
        $user_respon        =   $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($v_contrasena);
        if(count($user_respon)>0){
            $search         =   $this->Ssan_hdial_asignacionpaciente_model->model_ingreso_paciente([
                                    'empresa'       =>  $empresa,
                                    'user_respon'   =>  $user_respon,
                                    'v_num_fichae'  =>  $v_num_fichae,
                                    'arr_envio'     =>  $arr_envio,
                                    'arr_codcie10'  =>  $arr_codcie10
                                ]);
            $v_num_unico    =  $search['id_ingreso_dialisis'];      
        } else {
            $status         =   false;
        }
        $this->output->set_output(json_encode([
            'v_num_unico'   =>  $v_num_unico,
            'user_respon'   =>  $user_respon,
            'status'        =>  $status,
            'search'        =>  $search,
            'post'          =>  $_POST,
        ]));
    }
}