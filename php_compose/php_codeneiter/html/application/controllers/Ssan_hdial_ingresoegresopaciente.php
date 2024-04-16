<?php

defined("BASEPATH") OR exit("No direct script access allowed");

//require_once APPPATH . '/third_party/mpdf/mpdf.php';

class Ssan_hdial_ingresoegresopaciente extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pdf');
        $this->load->model("Ssan_hdial_ingresoegresopaciente_model");
        $this->load->model("Ssan_hdial_asignacionpaciente_model");
        $this->load->model("ssan_bdu_creareditarpaciente_model");
    }

    public function index(){
        $this->output->set_template('blank');
        $this->load->css("assets/Ssan_hdial_ingresoegresopaciente/css/styles.css");
        $this->load->js("assets/Ssan_hdial_ingresoegresopaciente/js/javascript.js");
        $empresa = $this->session->userdata("COD_ESTAB");
        $data_ini = [];
        $data_ini = $this->Ssan_hdial_ingresoegresopaciente_model->load_busqueda_rrhhdialisis(['empresa' => $empresa, 'ind_opcion' => 1 ]);
        $htmlBusquedaPacientes = $this->BusquedaPacientesIngreso_v2(true);
        $data_ini['htmlBusquedaPacientes'] = $htmlBusquedaPacientes;
        $liListadomaquinaspaciente = $this->pacientexMaquina(true);
        $data_ini['li_listadopacientemaquina'] = $liListadomaquinaspaciente;
        $this->load->view('Ssan_hdial_ingresoegresopaciente/Ssan_hdial_ingresoegresopaciente_view',$data_ini);
    }


    public function pacientexMaquina($returnData = false) {
        $empresa                =   $this->session->userdata("COD_ESTAB");
        $status                 =   true;
        $estados                =   '1';
        $ul                     =   '';
        $html                   =   '';
        $arr_cupos_ocupados     =   [];
        $aPaci                  =   $this->Ssan_hdial_asignacionpaciente_model->GetPacientesxCupo($empresa);
        if (count($aPaci)>0) {
            foreach($aPaci as $i => $r) {
                $html_btn       =   '
                                        <div class="dropdown">
                                            <button class="btn btn-primary btn-small dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="width: -webkit-fill-available;">
                                                <i class="fa fa-user-o" aria-hidden="true"></i>' . $r['NOMPAC'] . '
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li class="dropdown-item">
                                                    <a href="javascript:liberarCupo(' . $r['ID_CUPO'] . ',' . $r['MKN'] . ',' . $r['TRN'] . ')">
                                                        <i class="bi bi-person-slash"></i>&nbsp;&nbsp;LIBERAR CUPO 
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    ';
                $v_id_input     =   "CUPO_" . $r['MKN'] . "_" . $r['TRN'];
                $v_mkn          =   $r['MKN'];
                $arr_cupos_ocupados[$v_mkn][] = [
                    'html'      =>  $html_btn,
                    'value'     =>  $v_id_input,
                ];
            }
        }
        $aData                  =   $this->Ssan_hdial_asignacionpaciente_model->ListadoMaquinasDialisis($empresa,$estados);
        if (count($aData)>0){
            foreach ($aData as $i => $row) {
                $num    =   $i + 1;
                $mkn    =    $row['ID'];
                $html   .=  $this->load->view('Ssan_hdial_ingresoegresopaciente/li_listadomaquinasporpaciente',[
                    'num'   =>  $num,
                    'row'   =>  $row,
                    'pac'   =>  array_key_exists($mkn,$arr_cupos_ocupados)?$arr_cupos_ocupados[$mkn]:[],
                ],true);
            }
        } else {
            $html   =   '';
        }
        if($returnData) {
            return $html;
        } else {
            $this->output->set_output(json_encode([
                'html'                  =>  $html,
                'aData'                 =>  $aData, 
                'aPaci'                 =>  $aPaci,
                'arr_cupos_ocupados'    =>  $arr_cupos_ocupados,
            ]));
        }
    }

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
            }
            
            
            //FINAL DE MAQUINA 
            //BUSQUEDA DE PACIENTES YA ASIGNADOS A CUPOS
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
        } else {
            $html = '<tr><td colspan="6" style="text-align:center"><b>SIN MAQUINAS</b></td></tr>';
            $TABLA[] = array("id_html" => "LISTA_MAQUINA", "opcion" => "append", "contenido" => $html);
        }
        $this->output->set_output(json_encode($TABLA));
    }

    public function BusquedaPacientesIngreso_v2($returnData = false){
        #if (!$this->input->is_ajax_request()) { show_404(); }
        $empresa        =   $this->session->userdata("COD_ESTAB");
        $html           =   '';
        $numFichae      =   '';
        $rutPac         =   '';
        $estados        =   '1';
        $conIngreso	    =   '0';
        $aData          =   $this->Ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDial($empresa, $estados, $numFichae, $rutPac, $conIngreso);
        if(count($aData)>0){
            foreach ($aData as $i => $row){
                $rut_pac_s  =   explode("-",$row['RUTPAC']); 
                $rut_pac_s  =   $rut_pac_s[0];
                $html .=    '<tr>
                                <td>' . ($i + 1) . '</td>
                                <td>' .$row['RUTPAC']. '</td>
                                <td>' . $row['NOM_COMPLETO'] . '
                                    <input type="hidden" id="nombre_' . $row['ID_INGRESO'] . '"     name="nombre_' . $row['ID_INGRESO'] . '"    value="' . $row['NOM_APELLIDO'] . '"/>
                                    <input type="hidden" id="edad_' . $row['ID_INGRESO'] . '"       name="edad_' . $row['ID_INGRESO'] . '"      value="' . $row['TXTEDAD'] . '"/>
                                    <input type="hidden" id="telefono_' . $row['ID_INGRESO'] . '"   name="telefono_' . $row['ID_INGRESO'] . '"  value="' . $row['CELULAR'] . '"/>
                                    <input type="hidden" id="rut_' . $row['ID_INGRESO'] . '"        name="rut_' . $row['ID_INGRESO'] . '"       value="' . $row['RUTPAC'] . '"/>
                                </td>
                                <td>' . $row['TXTEDAD'] . '</td>
                                <td>' . $row['FINGRESO'] . '</td>
                                <td>' . $row['FINGRESO_HISTO'] . '</td>
                                <td>
                                    <div class="bg-success text-white" style="border-radius: 9px; text-align: -webkit-center;">'.$row['TXTESTADO'].'</div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-wrench"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li><a class="dropdown-item" href="javascript:iPesoseco('.$row['NUM_FICHAE'].')"><i class="fa fa-info" aria-hidden="true"></i>&nbsp;Informaci&oacute;n H. Diaria</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="javascript:js_imprimiringeg('.$row['ID_FORMULARIO'].','.$row['ID_INGRESO'].')"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;<b>PDF</b> Ingreso Enfermer&iacute;a</a></li>
                                            <li><a class="dropdown-item" href="javascript:js_cBUSQUEDAHANTERIOR('.$row['NUM_FICHAE'].',1)"><i class="bi bi-file-pdf"></i>&nbsp;Ver Hojas Diarias</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="javascript:egresar('.$row['ID_INGRESO'].','.$row['NUM_FICHAE'].')"><i class="fa fa-user-times" aria-hidden="true"></i> Egresar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>';
            }
        } else {
            $html = '<tr><td colspan="8" style="text-align:center"><b>SIN PACIENTES</b></td></tr>';
        }
        if($returnData) {
            return $html;
        } else {
            $this->output->set_output(json_encode(['html' => $html]));
        }
    }

    public function iMedico_PesoSeco() {
        if(!$this->input->is_ajax_request()) {  show_404();  }
        $empresa                    =   $this->session->userdata("COD_ESTAB");
        $numfichae                  =   $this->input->post('numfichae');
        $status                     =   true;
        $html                       =   '';
        $TXTACCESOVAS_2             =   '';
        $TXTACCESOVAS_1             =   '';
        $NUM_DIASVAS_1              =   '';
        $NUM_DIASVAS_2              =   '';
        $FEC_DIASVAS_1              =   '';
        $FEC_DIASVAS_2              =   '';
        $NUM_TROCAR_ARTERIAL        =   '';
        $NUM_TROCAR_VENOSO          =   '';
        $NUM_HEPARINA_INICIO        =   '';
        $NUM_HEPARINA_MAN           =   '';
        $NUM_QT                     =   '';
        $NUM_QB                     =   '';
        $NUM_QD                     =   '';
        $NUM_UFMAX                  =   '';
        $NUM_K                      =   '';
        $NUM_NA                     =   '';
        $NUM_CONCENTRADO            =   '';
        $NUM_PESOSECO               =   '';
        $SCRIPT                     =   '';
        $aData                      =   $this->Ssan_hdial_asignacionpaciente_model->ModelInformacionComplementaria($empresa,$numfichae);    
        if(count($aData)>0){
            $TXTACCESOVAS_1         =   $aData[0]['TXTACCESOVAS_1'];
            $NUM_DIASVAS_1          =   $aData[0]['NUM_DIASVAS_1'];
            $TXTACCESOVAS_2         =   $aData[0]['TXTACCESOVAS_2'];
            $NUM_DIASVAS_2          =   $aData[0]['NUM_DIASVAS_2'];
            $FEC_DIASVAS_1          =   $aData[0]['FEC_DIASVAS_1'];
            $FEC_DIASVAS_2          =   $aData[0]['FEC_DIASVAS_2'];
            $NUM_TROCAR_ARTERIAL    =   $aData[0]['NUM_TROCAR_ARTERIAL'];
            $NUM_TROCAR_VENOSO      =   $aData[0]['NUM_TROCAR_VENOSO'];
            $NUM_HEPARINA_INICIO    =   $aData[0]['NUM_HEPARINA_INICIO'];
            $NUM_HEPARINA_MAN       =   $aData[0]['NUM_HEPARINA_MAN'];
            $NUM_QT                 =   $aData[0]['NUM_QT'];
            $NUM_QB                 =   $aData[0]['NUM_QB'];
            $NUM_QD                 =   $aData[0]['NUM_QD']; 
            $NUM_UFMAX              =   $aData[0]['NUM_UFMAX']; 
            $NUM_K                  =   $aData[0]['NUM_K']; 
            $NUM_NA                 =   $aData[0]['NUM_NA']; 
            $NUM_CONCENTRADO        =   $aData[0]['NUM_CONCENTRADO']; 
            //INICIO
            $NUM_PESOSECO           =   $aData[0]['NUM_PESOSECO']; 
        }
        
        $html.='
            <form id="Formimedico" name="Formimedico">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><b>INDICACIONES MEDICAS</b></h5>
                    </div>
                    <div class="grid_informacion_dialisis">
                        <div class="grid_informacion_dialisis2">
                            <label for="QT"><b>ACCESO VASCULAR 1</b></label>
                            <input type="text" class="form-control input-sm"  id="TXT_ACCESOVAS_1"   name="TXT_ACCESOVAS_1" value="'.$TXTACCESOVAS_1.'">
                            <div class="grid_acceso_vascular">
                                <div class="grid_acceso_vascular1">
                                    <label for="QT"><b> FECHA 1</b></label>
                                    <input type="date" class="form-control" id="FEC_DIAS_1" name="FEC_DIAS_1" value="'.$FEC_DIASVAS_1.'" min="'.date("Y-m-d", strtotime("-30 years")).'" max="'.date("Y-m-d").'">
                                </div>
                                <div class="grid_acceso_vascular2">
                                    <label for="num_dias_1"><b>N&deg;  DE DIAS</b></label>
                                    <br>
                                    <h5 style="margin-top: 6px;margin-right: 10px;margin-left: 6px;"><div id="num_dias_2">'.$NUM_DIASVAS_1.'</div></h5>
                                </div>
                            </div>
                        </div>
                        <div class="grid_informacion_dialisis2">&nbsp;</div>
                        <div class="grid_informacion_dialisis3">
                            <label for="QT"><b>ACCESO VASCULAR 2</b></label>
                            <input type="text" class="form-control input-sm"  id="TXT_ACCESOVAS_2"   name="TXT_ACCESOVAS_2" value="'.$TXTACCESOVAS_2.'">
                            <div class="grid_acceso_vascular">
                                <div class="grid_acceso_vascular1">
                                    <label for="QT"><b> FECHA 2</b></label>       
                                    <input type="date" class="form-control" id="FEC_DIAS_2" name="FEC_DIAS_2" value="'.$FEC_DIASVAS_2.'" min="'.date("Y-m-d", strtotime("-30 years")).'" max="'.date("Y-m-d").'">
                                </div>
                                <div class="grid_acceso_vascular2">
                                    <label for="num_dias_1"><b>N&deg;  DE DIAS</b></label>
                                    <br>
                                    <h5 style="margin-top: 6px;margin-right: 10px;margin-left: 6px;"><div id="num_dias_2">'.$NUM_DIASVAS_2.'</div></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>  
                    <div class="content">
                        <div class="contenedor">
                            <div class="form-group">
                                <label for="QT"><b>TROCAR <br>(ARTERIAL)</b></label>
                                <input type="text"  placeholder="ARTERIAL" class="form-control input-sm"    id="NUM_ARTERIAL" name="NUM_ARTERIAL"   STYLE="WIDTH: 90PX;"  value="'.$NUM_TROCAR_ARTERIAL.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                            </div>
                            <div class="form-group">
                                <label for="QT"><b>TROCAR <br>(VENOSO)</b></label>
                                <input type="text"  placeholder="VENOSO" class="form-control input-sm"      id="NUM_VENOSO"   name="NUM_VENOSO"     STYLE="WIDTH: 90PX;" value="'.$NUM_TROCAR_VENOSO.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                            </div>
                            <div class="form-group">
                                <label for="QT"><b>HEPARINA <br>(I)</b></label>
                                <input type="text"  placeholder="INICIO" class="form-control input-sm"      id="NUM_INICIO" name="NUM_INICIO"   STYLE="WIDTH: 90PX;" value="'.$NUM_HEPARINA_INICIO.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                            </div>
                            <div class="form-group">
                                <label for="QT"><b>HEPARINA <br>(M)</b></label>
                                <input type="text"  placeholder="VENOSO" class="form-control input-sm"      id="NUM_MANTENCION"   name="NUM_MANTENCION"     STYLE="WIDTH: 90PX;" value="'.$NUM_HEPARINA_MAN.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                            </div>
                            <div class="form-group">
                                <label for="QT"><br><b>QT</b></label>
                                <input type="text"  placeholder="QT" class="form-control input-sm"          id="NUM_QT" name="NUM_QT" STYLE="WIDTH: 75PX;" value="'.$NUM_QT.'"  onKeyPress="return num_coma(event, this)" style="width: 90px;"/>
                            </div>
                            <div class="form-group">
                                <label for="QB"><br><b>QB</b></label>
                                <input type="text"  placeholder="QB" class="form-control input-sm"          id="NUM_QB" name="NUM_QB" STYLE="WIDTH: 75PX;" value="'.$NUM_QB.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                            </div>
                            <div class="form-group">
                                <label for="QD"><br><b>QD</b></label>
                                <input type="text"  placeholder="QD" class="form-control input-sm"          id="NUM_QD" name="NUM_QD" STYLE="WIDTH: 75PX;" value="'.$NUM_QD.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                            </div>
                            <div class="form-group">
                                <label for="MAX"><br><b>UF MAX</b></label>
                                <input type="text"  placeholder="UF MAX" class="form-control input-sm"      id="NUM_UFMAX" name="NUM_UFMAX" STYLE="WIDTH: 75PX;" value="'.$NUM_UFMAX.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                            </div>
                            <div class="form-group">
                                <label for="K"><br><b>K</b></label>
                                <input type="text"  placeholder="K" class="form-control input-sm"           id="NUM_K" name="NUM_K" STYLE="WIDTH: 75PX;" value="'.$NUM_K.'"  onKeyPress="return num_coma(event, this)" style="width: 90px;"/>
                            </div>
                            <div class="form-group">
                                <label for="Na"><br><b>Na</b></label>
                                <input type="text"  placeholder="Na" class="form-control input-sm"          id="NUM_NA" name="NUM_NA" STYLE="WIDTH: 75PX;" value="'.$NUM_NA.'"  onKeyPress="return num(event)" style="width: 90px;"/> 
                            </div>
                            <div class="form-group">
                                <label for="CONCENTRADO"><br><b>CONCENTRADO</b></label>
                                <input type="text"  placeholder="CONCENTRADO" class="form-control input-sm" id="NUM_CONCENTRADO" name="NUM_CONCENTRADO" STYLE="WIDTH: 120PX;" value="'.$NUM_CONCENTRADO.'" /> 
                            </div>
                            <div class="form-group">
                                <label for="Na"><br><b>Peso Seco(gr)</b></label>
                                <input type="text"  placeholder="-" class="form-control input-sm"           id="input_pesoSeco" name="input_pesoSeco" STYLE="WIDTH: 75PX;" value="'.$NUM_PESOSECO.'"  onKeyPress="return num_coma(event, this)" style="width: 90px;"/> 
                            </div>
                        </div>    
                    </div>
                </div>
            </form>
            ';     
       
        $this->output->set_output(json_encode([
            'status'    =>  true,
            'html'      =>  $html,
            'aData'     =>  $aData
        ]));
    }  

    public function guardaInformacionimedico_2(){
        if(!$this->input->is_ajax_request()) { show_404(); }
        $transaccion            =   [];
        $return                 =   true;
        $empresa                =   $this->session->userdata("COD_ESTAB");
        $contrasena             =   $this->input->post('contrasena');
        $numfichae              =   $this->input->post('numfichae');
        $form                   =   $this->input->post('form');
        $valida                 =   $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($contrasena);
        if(count($valida)>0){
            $usuarioh           =   explode("-",$valida[0]['USERNAME']);  
            $session            =   $usuarioh[0];
            $transaccion        =   $this->Ssan_hdial_asignacionpaciente_model->ModelguardaInformacionimedico_2([
                "empresa"       =>  $this->session->userdata("COD_ESTAB"),
                "session"       =>  explode("-",$this->session->userdata('USERNAME'))[0],
                "numfichae"     =>  $numfichae,
                "form"          =>  $form
            ]);
        } else {
            $return             =   false;        
        }
        $this->output->set_output(json_encode([
            'status'            =>  $return,
            'transaccion'       =>  $transaccion,
            'v_firma'           =>  $valida
        ]));
    }

    public function busqueda_informacion_cie10(){
        if (!$this->input->is_ajax_request()){ show_404(); }
        $v_resultados           =   [];
        $status                 =   false;
        $query                  =   $this->input->post('query');
        if (!empty($query) && strlen($query) > 2) {
            $v_resultados = $this->Ssan_hdial_asignacionpaciente_model->buscar_diagnosticos($query);
            if (!empty($v_resultados)){ $status = true; }
        }
        $this->output->set_output(json_encode(array(
            'status'            =>  $status,
            'resultados'        =>  $v_resultados
        )));
    }

    public function busqueda_pacientes_parametos(){
        if (!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $v_num_fichae = '';
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
        $b_existe_ingreso = false;
        $respuesta_paciente = $this->ssan_bdu_creareditarpaciente_model->getPacientesUnico($numFichae, $identifier, $codEmpresa, $isnal, $pasaporte, $tipoEx);
        if (count($respuesta_paciente)>0){
            $a_ingreso_valido = $this->Ssan_hdial_asignacionpaciente_model->busqueda_paciente_ingresos(['empresa' => $empresa, 'num_fichae' => $respuesta_paciente[0]['NUM_FICHAE']]);
            if (count($a_ingreso_valido)>0){
                $b_existe_ingreso = true;
            } else {
                $html_card_paciente = $this->load->view('ssan_bdu_creareditarpaciente/html_card_pacienteunico',['info_bdu'=>$respuesta_paciente],true); 
                $html_card_formularioingreso = $this->load->view('Ssan_hdial_ingresoegresopaciente/html_form_ingresodialisis',[],true); 
            }                 
        } else {
            $status = false;
        }
        $this->output->set_output(json_encode([
            'status' => $status,
            'v_num_fichae' => $v_num_fichae,
            'b_existe_ingreso' => $b_existe_ingreso,
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

    public function BusquedaMaquinasDeDialisis_old(){
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
            }
            
            
            
            
            
            //FINAL DE MAQUINA 
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
        if (!$this->input->is_ajax_request()){  show_404(); }
        $empresa    =   $this->session->userdata("COD_ESTAB");
        $ID         =   $this->input->post('ID');
        $html       =   '';
        $html       .=  '<div class="card">
                            <div class="header">
                                <h4 class="title"><b>DATOS DEL PACIENTE</b></h4>
                                <p class="category">Informaci&oacute;n Basica</p>
                            </div>
                            <div class="content">
                                 <dl class="row">

                                     <div class="grid_egresa_paciente">
                                        <div class="grid_egresa_paciente1">
                                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                                            <b> ' . $this->input->post('NOMBRE_PAC') . '</b>
                                        </div>
                                        <div class="grid_egresa_paciente2">
                                            <i class="fa fa-id-card-o" aria-hidden="true"></i>
                                            <b>' . $this->input->post('RUT_PAC') . '</b>
                                        </div>
                                        <div class="grid_egresa_paciente3">
                                            <i class="fa fa-mobile" aria-hidden="true"></i>
                                            <b> ' . $this->input->post('CELULAR') . '</b>
                                        </div>
                                        <div class="grid_egresa_paciente4">
                                            <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                                            ' . $this->input->post('EDAD') . ' Años
                                        </div>
                                    </div>
                                    <hr>
                                    <dt class="col-sm-12" style="text-align:center">
                                        <hr>
                                            <h4 class="title"><b>TIPO DE EGRESO:</b></h4>
                                            <select id="num_egreso" name="egreso"  onchange="js_tipoTraslado(this.value)" class="form-control">
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
        //$TABLA[] = array("id_html" => "BODYXMAQUINA", "opcion" => "append", "contenido" => $html);
        $this->output->set_output(json_encode([
            'html' => $html
        ]));
    }

    public function EgresaPaciente() {
        if (!$this->input->is_ajax_request()) {  show_404();   }
        $empresa        =   $this->session->userdata("COD_ESTAB");
        $transaccion    =   '';
        $return         =   '';
        $password       =   $this->input->post('password');
        $numIgreso      =   $this->input->post('numIgreso');
        $id_egreso      =   $this->input->post('id_egreso');
        $num_fichae     =   $this->input->post('numfichae');
        $valida         =   $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
        if (count($valida)) {
            $return         =   true;
            $usuarioh       =   explode("-", $_SESSION['USERNAME']); //Rut Del Usuario        
            $session        =   $usuarioh[0];
            $transaccion    =   $this->Ssan_hdial_asignacionpaciente_model->ModelEgresaPaciente($empresa, $session, $numIgreso, $id_egreso, $num_fichae);
        } else {
            $return     =   false;
        }
        $this->output->set_output(json_encode([
            "validez"       =>  $return,
            "transaccion"   =>  $transaccion,
            "sql"           =>  '',
        ]));
    }

    public function addcupoPaciente() {
        if (!$this->input->is_ajax_request()) {  show_404();   }
        $empresa        =   $this->session->userdata("COD_ESTAB");
        $MKN            =   $this->input->post('MKN');
        $GRP            =   $this->input->post('GRP');
        $html           =   '';
        //busqueda de pacientes que no tengas cupo asignado
        $rutPac         =   '';
        $numFichae      =   '';
        $estados        =   '1';
        $conIngreso     =   '1';
        $aData          =   $this->Ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDial($empresa, $estados, $numFichae, $rutPac, $conIngreso);
        $html           =   '<div class="card">
                                <h5 class="card-header"><b>SELECCIONE PACIENTE A ASIGNAR CUPO</b></h5>
                                <div class="card-body">
                                    <select id="idPaciente" name="idPaciente" class="form-control" onchange="js_idPac(this.id)">
                                    <option value="0"> Seleccione ...</option> ';
                                    if (count($aData) > 0) {
                                        foreach ($aData as $row) {
                                            $html.='<option value="' . $row['ID_INGRESO'] . '#' . $row['NUM_FICHAE'] . '">' . $row['NOM_APELLIDO'] . '</option>';
                                        }
                                    } else {
                                        $html.='<option value="0"> SIN PACIENTES ...</option>';
                                    }
                                    $html.='
                                    </select>
                                </div>
                            </div>';
        $this->output->set_output(json_encode([
            'html'      =>  $html
        ]));
    }

    public function TraeDatIng(){
        if (!$this->input->is_ajax_request()){ show_404(); }
        $txtBuscar  =   $this->input->post('txtBuscar');
        $ed         =   $this->input->post('ed');//contiene origen a editar
        $row        =   $this->ssan_hdial_ingresoegresopaciente_model->Cons_ingresoPac($txtBuscar, $this->empresa);
        $html       =   '';
        $exito      =   '';
        $nfichaeee  =   '';
        $ssss       =   0;

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
        #$valida = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
        $valida = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
        if (count($valida)>0) {
            $return = true;
            $usuarioh = explode("-", $valida->USERNAME); //Rut Del Usuario que firma       
            $session = $usuarioh[0];
            $transaccion = $this->Ssan_hdial_asignacionpaciente_model->ModeleliminaPacientexCupo($empresa, $session, $ID_CUPO, $MKN, $TRN);
        } else {
            $return = false;
        }

        $this->output->set_output(json_encode([
            "validez" => $return,
            "transaccion" => $transaccion
        ]));
    }

    public function guardaPacientexCupo() {
        if (!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $transaccion = [];
        $return = true;
        $password = $this->input->post('password');
        $datoPac = explode("#", $this->input->post('datoPac'));
        $numfichae = $datoPac[1];
        $numingreso = $datoPac[0];
        $MKN = $this->input->post('MKN');
        $GRP = $this->input->post('GRP');
        $DIAS = $this->input->post('DIAS');
        #$valida = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
        $valida = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
        if ($valida) {
            $usuarioh = explode("-", $valida->USERNAME); //Rut Del Usuario que firma       
            $session = $usuarioh[0];
            $transaccion = $this->Ssan_hdial_asignacionpaciente_model->ModelNuevoPacientexCupo($empresa, $session, $numfichae, $numingreso, $MKN, $GRP, $DIAS);
        } else {
            $return = false;
        }
        $this->output->set_output(json_encode([
            'status' => $return,
            'transaccion' => $transaccion,
            'valida' => $valida
        ]));
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
        if (!$this->input->is_ajax_request()) {  show_404();  }

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
        $arr_codcie10       =   $this->input->post('arr_codificacion');
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

    public function pdf_ingresoenfermeria(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $ID_FORMULARIO      =   $this->input->post('ID_FORMULARIO');
        $ID_INGRESO         =   $this->input->post('ID_INGRESO'); 
        $status             =   true;
        $aData              =   $this->Ssan_hdial_asignacionpaciente_model->informacio_formularioingreso([
                                    'ID_FORMULARIO' => $ID_FORMULARIO,
                                    'ID_INGRESO'    => $ID_INGRESO
                                ]);
        $html               =   $this->load->view('Ssan_hdial_ingresoegresopaciente/pdf_ingresoenfe',[
                                    'aData'     =>  $aData['arr_formulario'],
                                    'cie_10'    =>  $aData['arr_cie10']
                                ],true);
        $this->pdf->pdf->WriteHTML($html);
        $out                =   $this->pdf->pdf->Output('archivo','S');
        $base64_pdf         =   base64_encode($out);
        $this->output->set_output(json_encode([
            'aData'         =>  $aData,
            'base64_pdf'    =>  $base64_pdf,
            'html'          =>  $html,
            'id'            =>  $id,
            'status'        =>  $status
        ]));
    }

    function pdf_por_servicio(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                 =   true;
        $empresa                =   $this->session->userdata("COD_ESTAB");
        $date                   =   $this->input->post('date');
        $all_restriciones       =   $this->input->post('all_restriciones');
        $arr_numhospitaliza     =   $this->input->post('arr_numhospitaliza');  
        $txt_name_pdf           =   'LISTADO RESTRICIONES.pdf';
        $dompdf                 =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        $dompdf->AddPage();
        $html                   =   "hola";
        $dompdf->WriteHTML($html);
        $dompdf->SetHTMLFooter('MODULO DE CONTROL DE ACCESO');
        $out                    =   $dompdf->Output($txt_name_pdf,'S');
        $base64_pdf             =   base64_encode($out);
        $this->output->set_output(json_encode([
            'html'              =>  $html,
            'restriciones'      =>  $bd_restricion,
            'status'            =>  $status,
            'PDF_MODEL'         =>  $base64_pdf,
        ]));
    }


    function calendario_hermodialisis(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                 =   false;
    
        $this->output->set_output(json_encode([
            'status'            =>  $status,
        ]));
    }
}