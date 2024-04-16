<?php

class Ssan_hdial_hojatratamiento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_hdial_hojatratamiento_model");
        $this->load->model("Ssan_hdial_asignacionpaciente_model");
    }
    
    public function index() {
        $this->output->set_template('blank');
        #$this->load->js("assets/themes/wsocket_io/2_3_0/socket.io.dev.js");
        #$this->load->js("assets/ssan_crearinterconsulta/js/funciones.js");
        $this->load->css("assets/Ssan_hdial_hojatratamiento/css/styles.css");
        $this->load->js("assets/ssan_hdial_hojatratamiento/js/javascript_hd.js");
        $this->load->js("assets/Ssan_hdial_hojatratamiento/js/javascript.js");
        $data                       =   [];
        $estados                    =   '1';
        $empresa                    =   $this->session->userdata("COD_ESTAB");
        $v_arr_maquinas             =   $this->Ssan_hdial_asignacionpaciente_model->ListadoMaquinasDialisis($empresa,$estados);
        $data['arr_maquinas']       =   $v_arr_maquinas;
        #$data['ID_MAQUINA']         =   $v_arr_maquinas[0]['ID'];
        $this->load->view('Ssan_hdial_hojatratamiento/Ssan_hdial_hojatratamiento_view',$data);
    }

    public function cargaCalendarioPacientesHT() {
        if (!$this->input->is_ajax_request()) { show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $EVENTOS                        =   '';
        $numFichae                      =   '';
        $rutPac                         =   '';
        $month                          =   '';
        $year                           =   '';
        $running_day                    =   '';
        $days_in_month                  =   '';
        $numVisitas                     =   '0';
        #$ind_template                  =   '';
        $num_Maquina                    =   $this->input->post("num_Maquina");
        $date                           =   explode("-",$this->input->post("fecha"));
        $fechaBusqueda                  =   $this->input->post("fecha");
        $templete                       =   $this->input->post("templete");
        if(!$this->input->post("ind_template")=='1'){
            $MesWork                    =   explode("#",$this->input->post("MesWork"));
            $month                      =   $MesWork[0];
            $year                       =   $MesWork[1];
            $running_day                =   date('w',mktime('0','0','0',$month,'1',$year));
            $days_in_month              =   date('t',mktime('0','0','0',$month,'1',$year));
            $fecha_desde                =   '01-12-2017';    
            $fecha_hasta                =   $days_in_month.'-12-2017'; 
        } else {
            $fecha_desde                =   $this->input->post("fecha");
            $fecha_hasta                =   $this->input->post("fecha");
        } 
        $TABLA[]                        =   array("id_html"=>"maquina_1","opcion" => "html","contenido"=> "");
        #$estados                       =   '1';
        #$aData                         =   $this->ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDialxMaquina($empresa,$estados,$numFichae,$rutPac,$num_Maquina,$fecha_desde,$fecha_hasta);
        #$aData                         =   $this->ssan_hdial_asignacionpaciente_model->getbusquedaListadoPacienteHDxMaquinaCAdmision($empresa,$num_Maquina,$fechaBusqueda);
        #$aData                         =   $this->ssan_hdial_asignacionpaciente_model->proBusquedaHoradiaria($empresa,$fecha_hasta,$num_Maquina);
        $aData                          =   $this->Ssan_hdial_asignacionpaciente_model->proBusquedaHoradiaria_profActvNuevaAgenda($empresa,$fecha_hasta,$num_Maquina);
        if(count($aData)>0){
            foreach($aData as $row){
                $btn                    =   '';
                $msj                    =   '';
                $input                  =   '';
                $txtHr                  =   $row['HRS_INICIO'];
                $AD_ID_ADMISION         =   $row['AD_ADMISION']; 
                $ID_TDHOJADIARIA        =   $row['ID_TDHOJADIARIA']; 
                $AD_CIERRE              =   $row['AD_CIERRE']; 
                $NUM_FICHAE             =   $row['NUMFICHAE']; 
                $HD_ESTADO              =   $row['CIERREHD'];
                //$F_LOCAL              =   $row['F_LOCAL'];  
                if($AD_ID_ADMISION  == ''){
                        //  cambio 04.04.2020
                        if ($templete == '1' or $templete == '3'){
                            $btn.='<span class="label label-default">               <i class="fa fa-times" aria-hidden="true"></i> NO INICIADO</span>';
                        } else {
                            $btn.='<button class="btn btn-primary btn-fill btn-wd"  onclick="js_primeraDatosProgramacion('.$row["NUMFICHAE"].')"> INICIO <br> PROGRAMACI&Oacute;N </button>';
                        }
                            $msj = '<span class="label label-default">              <i class="fa fa-times" aria-hidden="true"></i> NO INICIADO</span>';
                } else {
                    //cambio 04.04.2020
                    if ($templete == '3'){
                        if ($AD_CIERRE== ''){
                            $msj                 =   '<span class="label label-info">      <i class="fa fa-cog" aria-hidden="true"></i>EN PROCESO</span>';
                        } else {
                            if(($HD_ESTADO == 1)or($HD_ESTADO == '')){
                                $msj             =   '<span class="label label-success">   <i class="fa fa-check" aria-hidden="true"></i>FINALIZADO</span>';  
                            } else {
                                $msj             =   '<span class="label label-warning">   <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>FALTA CIERRE MEDICO</span>'; 
                            }
                        }
                        $btn                    .=  '<button class="btn btn-danger btn-fill btn-wd"   onclick="js_eliminahoja('.$row["NUMFICHAE"].','.$AD_ID_ADMISION.','.$ID_TDHOJADIARIA.')"> ELIMINAR HOJA <br> HEMODI&Aacute;LISIS</button>';
                    } else {
                        if ($AD_CIERRE== ''){
                            $btn.='<button class="btn btn-info btn-fill btn-wd"         onclick="js_inicioProgama('.$row["NUMFICHAE"].','.$AD_ID_ADMISION.','.$ID_TDHOJADIARIA.',0)"> HOJA TRAT.<br> HEMODI&Aacute;LISIS</button>';
                            $msj                = '<span class="label label-info">      <i class="fa fa-cog" aria-hidden="true"></i> EN PROCESO</span>';
                            $input              = '';
                        } else {
                            if(($HD_ESTADO == 1)or($HD_ESTADO == '')){
                            $msj                = '<span class="label label-success">   <i class="fa fa-check" aria-hidden="true"></i> FINALIZADO</span>';  
                            $btn                .='<button class="btn btn-danger btn-fill btn-wd"       onclick="js_pdfHTML('.$ID_TDHOJADIARIA.')"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF <br> HEMODIALISIS</button>';
                            } else {
                            $msj                = '<span class="label label-warning">   <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>FALTA CIERRE MEDICO</span>'; 
                                if ($templete == '1'){
                                    $btn        .='<button class="btn btn-info btn-fill btn-wd"     onclick="js_inicioProgama('.$row["NUMFICHAE"].','.$AD_ID_ADMISION.','.$ID_TDHOJADIARIA.',3)">HOJA TRAT.<br> HEMODIALISIS</button>';    
                                } else {
                                    $btn        .='<button class="btn btn-danger btn-fill btn-wd"   onclick="js_pdfHTML('.$ID_TDHOJADIARIA.')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF <br> HEMODIALISIS</button>';    
                                }
                            }
                        }
                    }
                }
                #########################################################################
                $arr_row        =   htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');
                $txt_cumpleanos =   $row["IND_AYER"] == 1 ?'<br><span class="label label-warning"><i class="fa fa-birthday-cake" aria-hidden="true"></i>&nbsp;FELIZ CUMPEA&Ntilde;OS</span>':''; 
                $html           =   '  
                                    <tr 
                                        id              =   "hd_'.$ID_TDHOJADIARIA.'" 
                                        style           =   "height:90px;" 
                                        >
                                        <td scope="row" class="text-center">
                                            '.$txtHr.'
                                            <input type="hidden" id="AD_ID_ADMISION"            name="AD_ID_ADMISION"               value="'.$AD_ID_ADMISION.'"/>
                                            <input type="hidden" id="AD_CIERRE"                 name="AD_CIERRE"                    value="'.$AD_CIERRE.'"/>
                                            <input type="hidden" id="name_'.$ID_TDHOJADIARIA.'" name="name_'.$ID_TDHOJADIARIA.'"    value="'.$row["NOMPAC"].'"/> 
                                            <div class="hoja_'.$ID_TDHOJADIARIA.' num_fichae_'.$row["NUMFICHAE"].'" data-row="'.$arr_row.'"></div>
                                        </td>
                                        <td>
                                            '.$row["NOMPAC"].'&nbsp;<b>('.$row["RUTPAC"].')</b>&nbsp; 
                                            '.$input.'
                                        </td>
                                        <td>
                                            '.$row["NACIMIENTO"].' '.$txt_cumpleanos.'
                                        </td>
                                        <td class="text-center">'.$ID_TDHOJADIARIA.'</td>
                                        <td>'.$msj.'</td>
                                        <td class="text-center"><div class="content">'.$btn.'</div></td>
                                    </tr>
                                    ';
                $TABLA[]        =   array("id_html"=>"maquina_1","opcion" => "append",    "contenido"=> $html);   
            }
        } else {
            $txtMenjaje=    '
                            <tr>
                                <td colspan="6" style="text-align: center;">
                                    <b><i class="bi bi-x"></i>&nbsp;SIN PACIENTE</b> No se han encontrados pacientes en el turno y m&aacute;quina para el d&iacute;a seleccionado
                                </td>
                            </tr>
                            ';
            $TABLA[]        = array("id_html"=>"maquina_1","opcion"=>"html","contenido"=>$txtMenjaje);   
        }
        $this->output->set_output(json_encode($TABLA));
    }


    public function cargaPacientesHD() {
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                    =   $this->session->userdata("COD_ESTAB");
        $HTML                       =   '';
        $estados                    =   '1';
        $numFichae                  =   '';
        $rutPac                     =   '';
        $num_Maquina                =   '1';
        $fecha_desde                =   $this->input->post('fecha_busqueda');
        $fecha_hasta                =   $this->input->post('fecha_busqueda');
        //**********************************************************************
        $aMaquinas                  =   $this->ssan_hdial_asignacionpaciente_model->ModelbusquedaMaquinas($empresa);
        if(count($aMaquinas)){
            foreach ($aMaquinas as $row){
                $aData              =   $this->ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDialxMaquina($empresa,$estados,$numFichae,$rutPac,$row["ID"],$fecha_desde,$fecha_hasta);
                $TABLA[]            =   array("id_html"=>"maquina_1","opcion" => "console","contenido"=> $aData);
                /* foreach ($aData as $pac){  $TABLA[]= array("id_html"=>"maquina_1","opcion" => "console","contenido"=> $pac["NOMPAC"]); } */
                $TABLA[]            =   array("id_html"=>"maquina_1","opcion" => "console","contenido"=> $row["ID"]);
            }
        } else {
            
        }
        
        /*
        $TABLA[] = array("id_html"=>"maquina_1","opcion" => "console","contenido"=> $aData); 
        if (count($aData)>0){
            foreach ($aData as $row){
                $HTML='<tr>
                            <td>'.$row['HRS_INICIO'].'</td>
                            <td class="td-name">Things that all designers do</td>
                            <td>Most beautiful agenda for the office.</td>
                            <td class="td-number">30/08/2015</td>
                            <td class="td-number">1,225</td>
                            <td></td>
                        </tr>';
                $TABLA[]                    = array("id_html"=>"maquina_1", "opcion" => "append","contenido"=> $HTML); 
            }
        }  else {
                $HTML = '<tr><td colespan="6"> SIN PACIENTES</td></tr>';
                $TABLA[]                    = array("id_html"=>"maquina_1", "opcion" => "append","contenido"=> $HTML); 
        }
        */
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function autocompletar() {
        //llamada info dejamos pasar
        $html = '';
        if ($this->input->is_ajax_request() && $this->input->post('value')) {
            $abuscar        = strtoupper($this->security->xss_clean($this->input->post("value")));
            $sexo           = $this->input->post('value');
            $sqlfrecuencia  = 'N';
            $search         = $this->ssan_crearinterconsulta_model->buscaDiagnostico($sexo, $sqlfrecuencia, $abuscar);
            //si search es distinto de false significa que hay resultados
            //y los mostramos con un loop foreach
            $html .= '<a class="autocomplete-jquery-item autocomplete-jquery-mark" onclick="$(\'.autocomplete-jquery-results\').hide()" data-id="0"><b>CODIGO - DESCRIPCION DIAGNOSTICA ( CERRAR VENTANA  [X])</b></a>';
            if ($search) {
                $i = 0;
                foreach ($search as $fila){
                    $i++;
                    if($fila['IND_GES'] == '0'){
                        $html .= '<a class="autocomplete-jquery-item" onclick="onClickDiagnostico(\'' . $fila['COD_DIAGNO_CIE'] . '\',\'' . $fila['DESCRIPCION'] . '\')" data-id="' . $i . '">' . $fila['COD_DIAGNO_CIE'] . ' - ' . $fila['DESCRIPCION'] . '</a>';
                    }else if($fila['IND_GES'] == '1'){
                        $html .= '<a class="autocomplete-jquery-item" onclick="habGes('.$fila['COD'].'); onClickDiagnostico(\'' . $fila['COD_DIAGNO_CIE'] . '\',\'' . $fila['DESCRIPCION'] . '\');" data-id="' . $i . ')">' . $fila['COD_DIAGNO_CIE'] . ' - ' . $fila['DESCRIPCION'] . ' <img style="width: 30px;padding-bottom: 3px;" src="assets/ssan_seleccionarinterconsulta/img/ges.png"></a>';
                    }
                }
            }
        }
        $this->output->set_output($html);
    }

}
