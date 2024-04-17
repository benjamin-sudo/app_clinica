<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class ssan_spab_gestionlistaquirurgica extends CI_Controller {

   function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model("ssan_spab_gestionlistaquirurgica_model");
        $this->load->model("ssan_libro_biopsias_usuarioext_model");
        $this->load->model("ssan_libro_biopsias_listagespab_model");
        $this->load->library('validaciones');
    }
    
    public function index(){
        $this->load->js("assets/ssan_spab_gestionlistaquirurgica/js/javascript.js");
        $this->load->css("assets/ssan_spab_gestionlistaquirurgica/css/styles.css");
        $this->load->js("assets/themes/wsocket_io/2_3_0/socket.io.dev.js");
        $BOOLEANO                               =   $this->input->get('external_call',true);
        if ($BOOLEANO){
            $template                           =   $this->input->get('template',true);
            $this->output->set_template("Theme_blank");
            $this->load->helper('url');
            #DATA MOMENTOS
            $this->load->js("assets/themes/lightboot/js/jquery.validate.min.js");
            $this->load->js("assets/themes/lightboot/js/moment.min.js");
            $this->load->js("assets/themes/lightboot/js/bootstrap-datetimepicker.js");
            if($template == 1){
                #HTML GET
                #PASE QUIRUGICO
                $this->load->view("ssan_spab_gestionlistaquirurgica/PDFS/FORMULARIOS_HTML/HTML_SOLICITUDPASE",array(
                    //INFO SOLICIUD
                    "INFO_ASA"                  =>  $this->input->get('asa',true),
                    "IND_ESPECIALIDAD"          =>  $this->input->get('indespecialidad',true),
                    "IND_UNIDAD"                =>  $this->input->get('unidad',true),
                    //PACIENTE
                    "NUM_FICHAE"                =>  $this->input->get('num_fichae',true),
                    "RUT_PACIENTE"              =>  $this->input->get('rutpac',true),
                    //PROFESIONAL
                    "COD_MEDICO"                =>  $this->input->get('rutprof',true),
                    //EMPRESA SOLICITUD
                    "COD_EMPRESA"               =>  $this->input->get('codempresa',true),
                    //ADMIN.SS_TSISTEMAS
                    "PA_ID_PROCARCH"            =>  $this->input->get('pa_id_procarch',true),//*
                    //INFO CITA RCE ESPECIALIDAES
                    "NUM_CORREL"                =>  $this->input->get('numcorrel',true),//*
                    "COD_EMPRESA_RCE"           =>  $this->input->get('codempresacita',true),//*
                    //INFORMACION ANEXA
                    "CALL_FROM"                 =>  1,//0: INTERNO,1:DESDE EXTERNO
                    "ID_UNICO_ESPECIALIDAD"     =>  1,
                ));
            } else if ($template == 2){
                $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/javascript.js");
                $this->load->js("assets/ssan_spab_protocolodeurgencia/js/javascript_aux.js");
                #LLAMADA EXTERNA DE IFRAME
                $aData                                      =   $this->ssan_libro_biopsias_usuarioext_model->main_form_anatomiapatologica(array(
                                                                "COD_EMPRESA"       =>  $this->input->get('codempresa',true),
                                                                "V_CALL_FASE"       =>  0,
                                                                "V_IND_EXTERNO"     =>  1,
                                                                "V_IND_SISTEMA"     =>  0,
                                                                "IND_GESPAB"        =>  0,
                                                                "ZONA_PAB"          =>  0,
                                                                "PA_ID_PROCARCH"    =>  $this->input->get('pa_id_procarch',true),
                                                                "IND_ADMISION"      =>  $this->input->get('num_admision',true),
                                                                "ID_SERDEP"         =>  $this->input->get('unidad_sol',true), 
                                                            ));
                #PUNTO DE ENTREGA
                $array_rotulado                             =   [];
                if(count($aData["DATA_ROTULADO"])>0){
                    foreach($aData["DATA_ROTULADO"]  as $i  => $fila){
                        $array_rotulado[$i]                 =   array("value"=>$fila["ID_ROTULADO"],"name"=>$fila["TXT_OBSERVACION"]);
                    }
                }
                #AUTOCOMPLETE
                $data_autocomplete                          =   [];
                if($aData["DATA_AUTOCOMPLETE"]>0){
                    foreach ($aData["DATA_AUTOCOMPLETE"] as $x => $row){
                        $data_autocomplete[]                =   array("character"=>$row['TXT_CHARACTER'],"realName"=>($x+1));
                    }
                }
                
                #SOLICITUD ANATOMIA
                $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/FROM_APATOLOGICA_EXT",array(
                    "COD_ESTAB"                             =>  $this->input->get('codempresa',true),//
                    //PACIENTE
                    "NUM_FICHAE"                            =>  $this->input->get('num_fichae',true),//
                    "RUT_PACIENTE"                          =>  $this->input->get('rutpac',true),//
                    //PROFESIONAL
                    "ID_MEDICO"                             =>  null,
                    "RUT_MEDICO"                            =>  $this->input->get('rutprof',true),
                    //INFO SOLICITUD
                    "IND_TIPO_BIOPSIA"                      =>  $aData["P_ANATOMIA_PATOLOGICA_MAIN"]!=null?$aData["P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TIPO_BIOPSIA"]:$this->input->get('tipobiopsia',true),
                    "TXT_TIPO_BIOPSIA"                      =>  $aData["P_ANATOMIA_PATOLOGICA_MAIN"]!=null?$aData["P_ANATOMIA_PATOLOGICA_MAIN"][0]["TIPO_DE_BIOPSIA"]:$this->input->get('txtbiopsia',true),
                    "IND_ESPECIALIDAD"                      =>  $this->input->get('unidad_sol',true),//unidad de solicitud
                    "PA_ID_PROCARCH"                        =>  $this->input->get('pa_id_procarch',true),//
                    "AD_ID_ADMISION"                        =>  $this->input->get('num_admision',true),//,
                    "IND_FRAME"                             =>  1, //frame
                    "CALL_FROM"                             =>  1, //llama externa
                    //GESPAB
                    "ID_GESPAB"                             =>  null,
                    //DATA
                    "DATA"                                  =>  $aData,
                    //ZONA DE ROTULADO
                    "ZONA_PABELLON"                         =>  null,//zona de pabellon - 
                    //ARRAY
                    "ARRAY_ROTULADO"                        =>  $array_rotulado,
                    "ARRAY_AUTOCOMPLETE"                    =>  array("NOMBRE_ANATOMIA"=>$data_autocomplete),
                    //DATA GENERAL BASE DE DATOS 
                    "ARRAY_BD"                              =>  $aData,
                    "ARRAY_GET"                             =>  array("GET"=>$this->input->get()),
                ));
            }
        #BUSQUEDA DEL MODULO PRINCIPAL
        } else {
            $this->output->set_template("theme_principal/lightboot");
            if(!isset($_COOKIE['num_comuna'])){
                $cookie_target1                 =   array(
                                                    'name'      =>  'num_comuna',
                                                    'value'     =>  '5',
                                                    'expire'    =>  86500,
                                                    'secure'    =>  false
                                                );
                $this->input->set_cookie($cookie_target1);
            } 
            if(!isset($_COOKIE['num_fila'])){
                $cookie_target2                 =   array(
                                                    'name'      =>  'num_fila',
                                                    'value'     =>  '5',
                                                    'expire'    =>  86500,
                                                    'secure'    =>  false
                                                );
                $this->input->set_cookie($cookie_target2);
            }
            $empresa                            =   $this->session->userdata("COD_ESTAB");
            $responde                           =   $this->ssan_spab_gestionlistaquirurgica_model->CARGA_LISTA_PASESQUIRUGICO(
                array(
                    "COD_EMPRESA"               =>  $empresa,
                    "DATE_FROM"                 =>  date("d-m-Y"),
                    "DATE_TO"                   =>  date("d-m-Y"),
                )
            );
            $this->load->view("ssan_spab_gestionlistaquirurgica/ssan_spab_gestionlistaquirurgica_view",$responde);
        }
    }
     
    #INFORMACION
    public function get_prestadores(){
        if (!$this->input->is_ajax_request()) { show_404(); }
        $html                   =   '';
        #$this->output->set_template("theme_principal/lightboot");
        #$this->load->js("assets/ssan_pre_gestionarprestador/js/javascript.js");
        #$this->load->css("assets/ssan_pre_gestionarprestador/css/styles.css");
        //$html                   .=  '<script src="assets/ssan_pre_gestionarprestador/js/javascript.js" type="text/javascript"></script>';
        $data['em_presa']       =   $this->session->userdata("COD_ESTAB");
        $data['tok_G']          =   null;
        $data['usu_ario']       =   $this->session->userdata("USERNAME");
        $data['traeprof']       =   [];
        $data['cargatipo']      =   $this->ssan_libro_biopsias_usuarioext_model->get_html_anatomia();
        //echo '<script src="assets/ssan_pre_gestionarprestador/js/javascript.js" type="text/javascript"></script>';
        $html                   .=  '<script src="assets/ssan_pre_gestionarprestador/js/javascript.js" type="text/javascript"></script>';
        $html                   .=  $this->load->view("ssan_pre_gestionarprestador/ssan_pre_gestionarprestador_view",$data,true);
        $this->output->set_output(json_encode(array(
            'html'              =>  $html,
            'js_'               =>  '',
        )));
    }
    
    #GET HTML
    public function get_prestadores2(){
        if (!$this->input->is_ajax_request()) { show_404(); }
        $html                   =   '';
        #$this->output->set_template("theme_principal/lightboot");
        #$this->load->js("assets/ssan_pre_gestionarprestador/js/javascript.js");
        #$this->load->css("assets/ssan_pre_gestionarprestador/css/styles.css");
        //$html                   .=  '<script src="assets/ssan_pre_gestionarprestador/js/javascript.js" type="text/javascript"></script>';
        $data['em_presa']       =   $this->session->userdata("COD_ESTAB");
        $data['tok_G']          =   null;
        $data['usu_ario']       =   $this->session->userdata("USERNAME");
        $data['traeprof']       =   [];
        #$this->load->js("assets/ssan_pre_gestionarprestador/js/javascript.js");
        echo '<script src="assets/ssan_pre_gestionarprestador/js/javascript.js" type="text/javascript"></script>';
        $data['cargatipo']      =   $this->ssan_libro_biopsias_usuarioext_model->get_html_anatomia();
        $this->load->view("ssan_pre_gestionarprestador/ssan_pre_gestionarprestador_view",$data);
    }
    
    public function consulta_hoja_faph(){
       if(!$this->input->is_ajax_request()){ show_404(); }
        $responde                           =   $this->ssan_libro_biopsias_usuarioext_model->get_hoja_faph($this->input->post("value"));
        $this->output->set_output(json_encode(array(
            'return'                        =>  $responde,
        )));
    }
    
    #RECARGA + HTML LISTA ANATOMIA PATOLOGICA
    public function recarga_html_listaanatomiapatologica(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $date_from                      =   $this->input->post("fecha_from");
        $date_to                        =   $this->input->post("fecha_to");
        $idtabs                         =   $this->input->post('idtabs');
        $value                          =   $this->input->post('value');
        #SOLICITUDES DEL CLIENTE 
        #GET_LISTA_ANOTOMIAPATOLOGICA
        $session_arr                    =   explode("-",$this->session->userdata('USERNAME'));
	    $session                        =   $session_arr[0];
        $responde                       =   $this->ssan_libro_biopsias_usuarioext_model->CARGA_LISTA_MISSOLICITUDES_ANATOMIA(
            array(
                "COD_EMPRESA"           =>  $empresa,
                "USR_SESSION"           =>  $session,
                "DATE_FROM"             =>  $date_from,
                "DATE_TO"               =>  $date_to,
                "LODA_X_SISTEMAS"       =>  2, //SOLO USUARIO EXTERNO
            )
        );
        #OUT TO VIWES
        $TABLA["DATE_FROM"]             =   $date_from;
        $TABLA["DATE_TO"]               =   $date_to;
        $TABLA["HTML_LISTAS"]           =   $responde;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function vista_historial(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $STATUS                             =   true;
        $empresa                            =   $this->session->userdata('COD_ESTAB');
        $id_anatomia                        =   $this->input->post('id_anatomia');
        $arr                                =   [];
        $DATA                               =	$this->ssan_libro_biopsias_usuarioext_model->busqueda_historial(array("ID_ANATOMIA"=>$id_anatomia));
        if (count($DATA)>0){
            foreach($DATA as $i => $row){
                $arr[$row['ID_NUM_CARGA']]    =  $row;
            }
        } else {
            $STATUS                           =   false;
        }
        $html                                 =   'INFORMACION DE LA MUESTRA NUMERO :'.$id_anatomia.'<hr>';
        //foreach ($arr as $i => $fila){
            $html                             .=   '
                <div class="CSS_GRID_HISTORIAL">
                    <div class="CSS_GRID_HISTORIAL1">
                        <div class="card">
                            <div class="content">
                                <div style="background-color: transparent !important;">
                                    <div class="font_15"><b>CREACI&Oacute;N</b></div>
                                </div>
                                <hr style="margin-top:10px;margin-bottom:10px">
                                <div style="background-color: transparent !important;">
                                    CREADO POR : NOMBRE MEDICO <br>
                                    RUT: MEDICO<br>
                                    FECHA/HORA : '.date("d-m-Y").'
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="CSS_GRID_HISTORIAL2">
                        <div class="card">
                            <div class="content">
                                <div style="background-color: transparent !important;">
                                    <div class="font_15"><b>TRASPORTE</b></div>
                                </div>
                                <hr style="margin-top:10px;margin-bottom:10px">
                                <div style="background-color: transparent!important;">
                                    <div style="background-color: transparent !important;">
                                    TRASPORTADO POR : NOMBRE MEDICO <br>
                                    RUT: MEDICO<br>
                                    FECHA/HORA: '.date("d-m-Y").'
                                </div>                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="CSS_GRID_HISTORIAL3">
                        <div class="card">
                            <div class="content">
                                <div style="background-color: transparent !important;">
                                    <div class="font_15"><b>RECEPCI&Oacute;N</b></div>
                                </div>
                                <hr style="margin-top:10px;margin-bottom:10px">
                                <div style="background-color: transparent !important;">
                                    <div style="background-color: transparent !important;">
                                        RECEPCIONADO : NOMBRE MEDICO <br>
                                        RUT: MEDICO<br>
                                        FECHA/HORA: '.date("d-m-Y").'
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        //}
        $this->output->set_output(json_encode(array(
            'NO_ORDENADO'                   =>  $DATA,
            'ORDENADO'                      =>  $arr,
            'HTML_OUT'                      =>  $html,
            'STATUS'                        =>  $STATUS,
        )));
    }
    
    #CUSTODIA EN 
    public function fn_confirma_custodia(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa                            =   $this->session->userdata('COD_ESTAB');
        $DATA                               =   '';
        $id_anatomia                        =   $this->input->post('id_anatomia');
        $array_muestras                     =   $this->input->post('array_muestras');
        $usuarioh                           =   explode("-",$this->session->userdata("USERNAME"));
        $TXT_ERROR                          =   '';
        $STATUS                             =   true;
        $password                           =   $this->input->post('password');
        $valida                             =	$this->ssan_libro_biopsias_usuarioext_model->sqlValidaClave($password);
        if (count($valida)>0){
            $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->get_confirma_custodia(
                                                array(
                                                    "COD_EMPRESA"   =>  $empresa,
                                                    "SESSION"       =>  $usuarioh[0], 
                                                    "ID_ANATOMIA"   =>  $id_anatomia,
                                                    "ARRAY"         =>  $array_muestras,
                                                    "DATA_FIRMA"    =>  $valida,
                                                ));
        } else {
            $TXT_ERROR                      =   'Error en firma simple';
            $STATUS                         =   false;
        }
        $this->output->set_output(json_encode(array(
            'PASS'                          =>  $password,
            'GET_BD'                        =>  $DATA,
            'DATA_FIRMA'                    =>  $valida,
            'RETURN'                        =>  $STATUS,
            'TXT_ERROR'                     =>  $TXT_ERROR,
            'STATUS'                        =>  $STATUS,
        )));
    }
    
    #EN TRASPORTE + GPS
    public function confirma_trasporte(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa                            =   $this->session->userdata('COD_ESTAB');
        $id_anatomia                        =   $this->input->post('id_anatomia');
        $array_muestras                     =   $this->input->post('array_muestras');
        $usuarioh                           =   explode("-",$this->session->userdata("USERNAME"));
        $TXT_ERROR                          =   '';
        $DATA                               =   '';
        $STATUS                             =   true;
        $password                           =   $this->input->post('password');
        $valida                             =	$this->ssan_libro_biopsias_usuarioext_model->sqlValidaClave($password);
        if(count($valida)>0){
            $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->get_confirma_trasporte(
                                                array(
                                                    "COD_EMPRESA"   =>  $empresa,
                                                    "SESSION"       =>  $usuarioh[0], 
                                                    "ID_ANATOMIA"   =>  $id_anatomia,
                                                    "ARRAY"         =>  $array_muestras,
                                                    "DATA_FIRMA"    =>  $valida,
                                                ));
        } else {
            $TXT_ERROR                      =   'Error en firma simple';
            $STATUS                         =   false;
        }
        $this->output->set_output(json_encode(array(
            'PASS'                          =>  $password,
            'GET_BD'                        =>  $DATA,
            'DATA_FIRMA'                    =>  $valida,
            'RETURN'                        =>  $STATUS,
            'TXT_ERROR'                     =>  $TXT_ERROR,
            'STATUS'                        =>  $STATUS,
        )));
    }
    
    #EN RECEPCION
    public function confirma_recepcion(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa                            =   $this->session->userdata('COD_ESTAB');
        $id_anatomia                        =   $this->input->post('id_anatomia');
        $array_muestras                     =   $this->input->post('array_muestras');
        $n_interno                          =   $this->input->post('n_interno');
        $n_interno_2                        =   $this->input->post('n_interno_2');
        $ind_tipo_biopsia                   =   $this->input->post('ind_tipo_biopsia'); 
        $usuarioh                           =   explode("-",$this->session->userdata("USERNAME"));
        #$num_memo_notificacion             =   true;
        $TXT_ERROR                          =   '';
        $DATA                               =   '';
        #$valida                            =   '';
        $STATUS                             =   true;
        $arr_errores                        =   array();
        $arr_password                       =   $this->input->post('pass');
        $valida                             =	$this->ssan_libro_biopsias_usuarioext_model->sqlValidaClave_doble($arr_password);
        count($valida['user_1'])>0?'':array_push($arr_errores,"Error en la firma del usuario de trasporte");
        count($valida['user_2'])>0?'':array_push($arr_errores,"Error en la firma del usuario de recepci&oacute;n");
        if(count($arr_errores)>0){
            $TXT_ERROR                      =   implode("<br>",$arr_errores);
            $STATUS                         =   false;
        } else {
            $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->get_confirma_recepcion(array(
                                                    "COD_EMPRESA"       =>  $empresa,
                                                    "SESSION"           =>  $usuarioh[0], 
                                                    "ID_ANATOMIA"       =>  $id_anatomia,
                                                    "ARRAY"             =>  $array_muestras,
                                                    "DATA_FIRMA"        =>  $valida,
                                                    "n_interno"         =>  $n_interno,
                                                    "n_interno_2"       =>  $n_interno_2,
                                                    "ind_tipo_biopsia"  =>  $ind_tipo_biopsia,
                                                ));
        }
        $this->output->set_output(json_encode(array(
            'ERRORES'       =>  $arr_errores,
            'PASS'          =>  $arr_password,
            'GET_BD'        =>  $DATA,
            'DATA_FIRMA'    =>  $valida,
            'RETURN'        =>  $STATUS,
            'TXT_ERROR'     =>  $TXT_ERROR,
            'STATUS'        =>  $STATUS,
        )));
    }
   
    public function informa_x_correo(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        //$DATA                         =   null;
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf                   =   'RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA:'.$id_tabla.'.pdf';
        #verical 
        //$dompdf                       =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        #horizontal
        $dompdf                         =   new mPDF("en-GB-x","Letter-L","","",10,10,10,10,6,3);
        $dompdf->AddPage();
        $dompdf->WriteHTML($this->load->view("ssan_libro_biopsias_listagespab/pdf_recepcion_conforme",array('DATA'=>$DATA,"empresa"=>$empresa),true));
        $dompdf->SetHTMLFooter('RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA');
        $out                            =   $dompdf->Output($txt_name_pdf,'S');
        $base64_pdf                     =   base64_encode($out);
        $userEmail                      =   'benjamin.castillo@araucanianorte.cl,jorge.mora@araucanianorte.com'; 
        ##############################################################
        #$userEmail                     =   'bolivarleeo@hotmail.com'; 
        #$userEmail                     =   'benjamin.castillo03@gmail.com';
        ##############################################################
        $subject                        =   'NUEVA RECEPCION';
        $config                         =   array(
                                                'protocol'      => 'smtp',
                                                'smtp_host'     => 'smtp.office365.com',
                                                'smtp_port'     =>  587,
                                                'smtp_user'     => 'benjamin.castillo@araucanianorte.cl',
                                                'smtp_pass'     => 'ssan.1988',
                                                'smtp_timeout'  =>  4,
                                                'mailtype'      => 'html',
                                                'charset'       => 'iso-8859-1'
                                            );
        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        $this->email->from('benjamin.castillo@araucanianorte.cl','SISTEMA DE ANATOM&Iacute;A PATOL&Oacute;GICA - NUEVA RECEPCI&Oacute;N');//no borrar (correo remitente)
        $data = array('NUM_ANATOMICO' => $id_tabla);
        $this->email->to($userEmail);
        $this->email->subject($subject); // replace it with relevant subject 
        $body = $this->load->view('ssan_libro_biopsias_ii_fase/email_test.php',$data,TRUE);
        $this->email->message($body);
        #$this->email->attach($dompdf->Output($txt_name_pdf,'S'));
        $this->email->attach($out,'attachment','RECEPCION ANATOMIA - '.$id_tabla.'.pdf','application/pdf');
        $this->email->send();

        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["IND_MAIL"]              =   $userEmail;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $this->output->set_output(json_encode($TABLA));
    }
    
    #editando para multriplice solicitudes sean procesadas
    public function informacion_x_muestra_grupal(){
        if (!$this->input->is_ajax_request()){  show_404(); }
        $empresa                            =   $this->session->userdata('COD_ESTAB');
        $html                               =   '';
        //$from                             =   $this->input->post('from');
        //$opcion                           =   $this->input->post('opcion');
        $ARR_CASETE_ORD                     =   [];
        $data_main                          =   [];
        $get_etiqueta                       =   $this->input->post('get_etiqueta');
        $vista                              =   $this->input->post('vista');
        $NUM_FASE                           =   $this->input->post('NUM_FASE');
        $IND_MODAL                          =   $this->input->post('MODAL');
        $array_data                         =   $this->input->post('array_data');
        #LEYENDA
        $data_return                        =   '';
        $DATA                               =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_INFOXMUESTRAANATOMIACA(
                                                array(
                                                    "COD_EMPRESA"               =>  $empresa,
                                                    "TXTMUESTRA"                =>  $get_etiqueta,
                                                    "NUM_FASE"                  =>  $NUM_FASE,
                                                    "ARR_DATA"                  =>  count($array_data["array_anatomia"])>0?implode(",",$array_data["array_anatomia"]):'null', 
                                                ));
        ###
        $ARR_GENTIONMSJ                                                         =   [];
        if (count($DATA["P_ANATOMIA_PATOLOGICA_MAIN"])>0){
            $arr_muestra_muestras                                               =   [];
            $arr_muestras_citologia                                             =   [];
            $arr_info_linea_tiempo                                              =   [];
            if (count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"])>0){
                foreach ($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $arr_muestras_anatomica_row)  {
                    $arr_muestra_muestras[$arr_muestras_anatomica_row['ID_SOLICITUD_HISTO']][]          =   $arr_muestras_anatomica_row;
                }
            }
            if (count($DATA["P_AP_MUESTRAS_CITOLOGIA"])>0){
                foreach ($DATA["P_AP_MUESTRAS_CITOLOGIA"] as $i => $arr_muestras_citologica_row)        {
                    $arr_muestras_citologia[$arr_muestras_citologica_row['ID_SOLICITUD_HISTO']][]       =   $arr_muestras_citologica_row;
                } 
            }
            #ordena data para templetate template_logs_anatomia
            $log_adverso                                                                                =   [];
            if (count($DATA['P_INFO_LOG_ADVERSOS'])>0){
                foreach($DATA['P_INFO_LOG_ADVERSOS'] as $i => $log_adv){ 
                    $log_adverso[$log_adv['ID_NUM_CARGA'].'_'.$log_adv['ID_NMUESTRA']]                  =   $log_adv;
                }
            }
            if(count($DATA["P_AP_INFORMACION_ADICIONAL"])>0){
                foreach ($DATA["P_AP_INFORMACION_ADICIONAL"] as $i => $arr_linea_tiempo_logs_row)       {
                    $ID_SOLICITUD_HISTO                                                                 =   $arr_linea_tiempo_logs_row['ID_SOLICITUD_HISTO'];
                    $ID_NUM_CARGA                                                                       =   $arr_linea_tiempo_logs_row['ID_NUM_CARGA'];
                    $ID_NMUESTRA                                                                        =   $arr_linea_tiempo_logs_row['ID_CASETE']==''?$arr_linea_tiempo_logs_row['TXT_BACODE']:$arr_linea_tiempo_logs_row['ID_CASETE'];
                    $id_compuesta                                                                       =   $ID_NUM_CARGA.'_'.$ID_NMUESTRA;
                    $data_main[]                                                                        =   $arr_linea_tiempo_logs_row;
                    $arr_info_linea_tiempo[$ID_SOLICITUD_HISTO][$ID_NUM_CARGA][$ID_NMUESTRA][]          =   array(
                                                                                                                    'MAIN'          =>  $arr_linea_tiempo_logs_row ,
                                                                                                                    'ERROR_LOG'     =>  array_key_exists($id_compuesta,$log_adverso)?$log_adverso[$id_compuesta]:[]
                                                                                                                );
                }
            }
            #falta los log 
            foreach($DATA["P_ANATOMIA_PATOLOGICA_MAIN"] as $i => $row){
                $id_anatomia                =   $row["ID_SOLICITUD"];
                $html                       =   $this->load->view("ssan_libro_biopsias_listagespab/ssan_libro_biopsias_listagespab_view_pre_all",array(
                                                    "VIEWS"                             =>  $vista,
                                                    "DATA"                              =>  $row,
                                                    "FIRST"                             =>  $get_etiqueta,
                                                    "FASE"                              =>  $NUM_FASE,
                                                    "P_ANATOMIA_PATOLOGICA_MUESTRAS"    =>  empty($arr_muestra_muestras[$id_anatomia])?[]:$arr_muestra_muestras[$id_anatomia],
                                                    "P_AP_MUESTRAS_CITOLOGIA"           =>  empty($arr_muestras_citologia[$id_anatomia])?[]:$arr_muestras_citologia[$id_anatomia],
                                                    //"P_AP_INFORMACION_ADICIONAL"      =>  empty($arr_info_linea_tiempo[$id_anatomia])?[]:$arr_info_linea_tiempo[$id_anatomia],
                                                    "HTML_LOGS"                         =>  $this->load->view("ssan_libro_etapaanalitica/template_logs_anatomia",array("ID_SOLICITUD"=>$id_anatomia,'P_AP_INFORMACION_ADICIONAL'=>empty($arr_info_linea_tiempo[$id_anatomia])?[]:$arr_info_linea_tiempo[$id_anatomia]),true),
                                                ),true);
                
                $ARR_GENTIONMSJ[]           =   array(
                    'ID_AP'                 =>  $id_anatomia,
                    'ID_TABS'               =>  'TABS_'.$id_anatomia,
                    'TXT_TITULO'            =>  'N&deg;&nbsp;<b>'.$id_anatomia.'</b>',
                    'HTML'                  =>  $html,
                );
            }
        }
        
        #ID_SOLICITUD
        $NUM_ANATOMIA                       =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];
        if($IND_MODAL){
            $TXT_GO_BACODE                  =   $NUM_FASE==1?'TRASPORTE | CUSTODIA':$NUM_FASE==2?'PARA RECEPCI&Oacute;N':'VISUALIZACI&Oacute;N';
            $TABS_HTML                      =   '
                <script>
                    $(document).ready(function(){
                        $("#get_etiqueta_modal").keypress(function(e){if(e.which==13){ 
                            busqueda_etiquera_modal(0); 
                        }});
                        $("#UL_TABS_MUESTRA").on("shown.bs.tab",function(e){
                            //console.log("target -> ",e.target);
                            //console.log("target -> ",e.relatedTarget);
                            $(".popover").popover("hide");
                        });
                        document.getElementById("get_etiqueta_modal").focus();
                        $("#UL_TABS_MUESTRA li:first-child a").tab("show");
                        console.log("------------------------------------------------");
                        console.log("la arrogancia          ->  '.$TXT_GO_BACODE.'   ");
                        console.log("buscar la etiqueta     ->                       ");
                        console.log("------------------------------------------------");
                    });
                </script>
                
                <!--
                    '.$TXT_GO_BACODE.' | F:'.$NUM_FASE.'
                -->
                
                <div class="CSS_GRID_ETIQUETA_HEARD" style=" margin-bottom:15px;">
                    <div class="CSS_GRID_ETIQUETA_HEARD1 FLEX_CENTER">
                        <fieldset class="fieldset_local">
                            <legend class="legend"><i class="fa fa-search" aria-hidden="true"></i> ETIQUETAS</legend>
                            <div id="date_tabla2" class="input-group" style="width:200px;padding:8px;">
                                <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                                <input type="text" class="form-control input-sm" id="get_etiqueta_modal" name="get_etiqueta_modal"  value=""/>
                                <span class="input-group-addon" >
                                    <a href="javascript:busqueda_etiquera_modal(2)" style="opacity:0.5;color:#000;">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </a>
                                </span>
                             </div>
                             <script>document.getElementById("get_etiqueta_modal").focus();</script>
                        </fieldset>
                    </div>
                    <div class="CSS_GRID_ETIQUETA_HEARD2 FLEX_CENTER" style="text-align:end">';  
                    #
                    switch($NUM_FASE){
                        case 0:
                            $TABS_HTML  .=  '   <i class="fa fa-eye" aria-hidden="true"></i>    ';
                            break;
                        case 1:
                            #<!--&nbsp;TRASPORTE MASIVO-->
                            #<!--&nbsp;CUSTODIA MASIVO-->  
                            $TABS_HTML  .=  '
                                                <div class="btn-group-vertical" id="btn_masivo" style="display:none">
                                                    <a class="btn btn-fill btn-primary" style="text-align:end;" href="javascript:confirma_custodia_all(1)">
                                                        TODO - CUSTODIA MASIVO&nbsp;<i class="fa fa-inbox" aria-hidden="true"></i>
                                                    </a>
                                                    <a class="btn btn-fill btn-success" style="text-align:end;" href="javascript:confirma_trasporte_all(1)">
                                                        TODO - TRASPORTE MASIVO&nbsp;<i class="fa fa-truck" aria-hidden="true"></i>
                                                    </a> 
                                                </div>
                                            ';
                           break;
                        case 2:
                           $TABS_HTML   .=  '   
                                                <div class="btn-group" id="btn_masivo" style="display:none">
                                                    <button class="btn btn-xs btn-fill btn-success" onclick="confirma_recepcion_all(1)" style="width:auto;height:35px;">
                                                        <i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;RECEPCI&Oacute;N MASIVA
                                                    </button>
                                                </div>     
                                            ';
                            break;
                    }
            $TABS_HTML .=   '</div>
                </div>';
            #GESTOR DE TABS
            $TABS_HTML                  .=   ' <div id="MAIN_TABS_MUESTRA">';
            if(count($ARR_GENTIONMSJ)>0){
                $HTML_MENSAJE_LU        =   '';
                $HTML_MENSAJE_DIV       =   '';
                foreach($ARR_GENTIONMSJ as $i => $row){
                    $ID_INICO           =   $row['ID_TABS'];
                    $class_active       =   $i==0?'active':'';
                    $HTML_MENSAJE_LU    .=  '<li class="nav-item '.$class_active.' all_solicitudes_custodia all_solicitudes_trasporte all_solicitudes_recepcion li_histo_'.$row['ID_AP'].' " id="'.$row['ID_AP'].'">
                                                <a class="nav-link" data-toggle="tab" href="#'.$ID_INICO.'" role="tab">'.$row['TXT_TITULO'].'</b></a>
                                            </li>';
                    $HTML_MENSAJE_DIV  .=  '<div class="tab-pane '.$class_active.' tab_histo_'.$row['ID_AP'].'"  id="'.$ID_INICO.'" role="tabpanel">'.$row['HTML'].'</div>';
                }
                $TABS_HTML              .=  '<ul class="nav nav-tabs" role="tablist" id="UL_TABS_MUESTRA">'.$HTML_MENSAJE_LU.'</ul>';
                $TABS_HTML              .=  '<div class="tab-content" id="TABS_TAB_PANEL">'.$HTML_MENSAJE_DIV.'</div>';
            } 
            $TABS_HTML                  .=   '</div>';
        } else {
            $TABS_HTML                  =   $html;
        }
        
        #out json 
        $this->output->set_output(json_encode(array(
            'STATUS'                        =>  count($DATA['P_ERROR'])>0?false:true,
            'NUM_ANAT'                      =>  $NUM_ANATOMIA,
            'IND_MODAL'                     =>  $IND_MODAL,
            'RETURN'                        =>  $data_return,
            'BUSQ'                          =>  $get_etiqueta,
            'EMPRESA'                       =>  $empresa,
            'DATA'                          =>  $DATA,
            'HTML_VIWE'                     =>  $html,
            'HTML_OUT'                      =>  $TABS_HTML,
            'DATA_GET'                      =>  $array_data,
            'data_main'                     =>  $data_main,
            'ARR_CASETE_ORD'                =>  $ARR_CASETE_ORD,
            'P_AP_INFORMACION_ADICIONAL'    =>  $DATA["P_AP_INFORMACION_ADICIONAL"],
        )));
    }
    
    public function informacion_x_muestra(){
        if (!$this->input->is_ajax_request()){  show_404(); }
        $empresa                            =   $this->session->userdata('COD_ESTAB');
        $get_etiqueta                       =   $this->input->post('get_etiqueta');
        $vista                              =   $this->input->post('vista');
        $from                               =   $this->input->post('from');
        $opcion                             =   $this->input->post('opcion');
        $NUM_FASE                           =   $this->input->post('NUM_FASE');
        $IND_MODAL                          =   $this->input->post('MODAL');
        $array_data                         =   $this->input->post('array_data');
        //**********************************************************************
        //************************ LEYENDA *************************************
        //**********************************************************************
        $data_return                        =   '';
        $DATA                               =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_INFOXMUESTRAANATOMIACA(
                                                    array(
                                                        "COD_EMPRESA"       =>  $empresa,
                                                        "TXTMUESTRA"        =>  $get_etiqueta,
                                                        "NUM_FASE"          =>  $NUM_FASE,
                                                    ));
        $html                               =   $this->load->view("ssan_libro_biopsias_listagespab/ssan_libro_biopsias_listagespab_view_pre",
                                                    array(
                                                        "VIEWS"             =>  $vista,
                                                        "DATA"              =>  $DATA,
                                                        "FIRST"             =>  $get_etiqueta,
                                                        "FASE"              =>  $NUM_FASE
                                                    ),true);
        
        $NUM_ANATOMIA                       =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];
        //**********************************************************************
        if($IND_MODAL){
            $TXT_GO_BACODE                  =   $NUM_FASE==1?'TRASPORTE | CUSTODIA ':$NUM_FASE==2?'PARA RECEPCI&Oacute;N':'VISUALIZA';
            $TABS_HTML                      =   '
                
                <script>
                    $(document).ready(function(){
                        
                        $("#get_etiqueta_modal").keypress(function(e){if(e.which==13){ 
                            busqueda_etiquera_modal(0); 
                        }});
                        $("#UL_TABS_MUESTRA").on("shown.bs.tab",function(e){
                            //console.log("target -> ",e.target);
                            //console.log("target -> ",e.relatedTarget);
                            $(".popover").popover("hide");
                        });
                        
                        document.getElementById("get_etiqueta_modal").focus();
                        $("#UL_TABS_MUESTRA li:first-child a").tab("show");
                    });
                </script>

                <div class="CSS_GRID_ETIQUETA_HEARD" style=" margin-bottom:15px;">
                    <div class="CSS_GRID_ETIQUETA_HEARD1 FLEX_CENTER">
                        <fieldset class="fieldset_local">
                            <legend class="legend">B&Uacute;SQUEDA '.$TXT_GO_BACODE.' | F:'.$NUM_FASE.'</legend>
                            <div id="date_tabla2" class="input-group" style="width:200px;padding:8px;">
                                <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                                <input type="text" class="form-control input-sm" id="get_etiqueta_modal" name="get_etiqueta_modal"  value=""/>
                                <span class="input-group-addon" >
                                    <a href="javascript:busqueda_etiquera_modal(2)" style="opacity:0.5;color:#000;">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </a>
                                </span>
                             </div>
                             <script>document.getElementById("get_etiqueta_modal").focus();</script>
                        </fieldset>
                    </div>
                    <div class="CSS_GRID_ETIQUETA_HEARD2 FLEX_CENTER">';  
                    //**********************************************************************    
                    switch($NUM_FASE){
                        case 0:
                            $TABS_HTML  .=  '<i class="fa fa-eye" aria-hidden="true"></i>';
                            break;
                        case 1:
                            $TABS_HTML  .=  '  
                                                <div class="btn-group" id="btn_masivo" style="display:none" >
                                                    <button class="btn btn-xs btn-fill btn-warning" onclick="confirma_custodia_all(1)" style="width:auto;height:35px;">
                                                        <i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;CUSTODIA MASIVA 
                                                    </button>
                                                    <button class="btn btn-xs btn-fill btn-info" onclick="confirma_trasporte_all(1)" style="width:auto;height:35px;">
                                                        <i class="fa fa-truck" aria-hidden="true"></i>&nbsp;<b>TRASPORTE MASIVA</b>
                                                    </button>
                                                </div>     
                                            ';
                            break;
                        case 2:
                           $TABS_HTML  .=   '   
                                                <div class="btn-group" id="btn_masivo" style="display:none" >
                                                    <button class="btn btn-xs btn-fill btn-success" onclick="confirma_recepcion_all(1)" style="width:auto;height:35px;">
                                                        <i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;<b>RECEPCI&Oacute;N MASIVA</b>
                                                    </button>
                                                </div>     
                                            ';
                            break;
                    }
                    //**********************************************************************
            $TABS_HTML .=   '</div>
                </div>';
            $TABS_HTML .=   ' <div id="MAIN_TABS_MUESTRA">';
            $TABS_HTML .=   '   <ul role="tablist" class="nav nav-tabs" id="UL_TABS_MUESTRA">
                                    <li role="presentation">
                                        <a href="#TABS_'.$NUM_ANATOMIA.'" aria-controls="TABS_'.$NUM_ANATOMIA.'" role="tab" data-toggle="tab">N&deg;&nbsp;'.$NUM_ANATOMIA.'</a>
                                    </li>';
            //SOLICITUDES EN ESPERA
            if (isset($array_data["array_anatomia"])){
                foreach ($array_data["array_anatomia"] as $i => $raw){
                    $TABS_HTML .=   $raw!=$NUM_ANATOMIA ?'
                                    <li role="presentation" class="class_pendiente_'.$raw.'" id="tabs_pendiente_'.$raw.'">
                                        <a href="#TABS_'.$raw.'" aria-controls="TABS_'.$raw.'" role="tab" data-toggle="tab"  onclick="js_busqueda_pendiente('.$raw.',this)" >N&deg;&nbsp;'.$raw.'</a>
                                    </li>':''; 
                }
            } else {
                $TABS_HTML      .=   '';
            }
            $TABS_HTML          .=   '
                                </ul>
                                <div class="tab-content" id="TABS_TAB_PANEL">
                                    <div role="tabpanel" class="tab-pane" id="TABS_'.$NUM_ANATOMIA.'">'.$html.'</div>
                                </div>';
            
            $TABS_HTML      .=   '</div>';
            
        } else {
            $TABS_HTML      =   $html;
        }
        #OUT
        $this->output->set_output(json_encode(array(
            'STATUS'                        =>  count($DATA['P_ERROR'])>0?false:true,
            'NUM_ANAT'                      =>  $NUM_ANATOMIA,
            'MODAL'                         =>  $IND_MODAL,
            'RETURN'                        =>  $data_return,
            'BUSQ'                          =>  $get_etiqueta,
            'EMPRESA'                       =>  $empresa,
            'DATA'                          =>  $DATA,
            'HTML_VIWE'                     =>  $html,
            'HTML_OUT'                      =>  $TABS_HTML,
            'DATA_GET'                      =>  $array_data,
        )));
    }
    
    
    public function ind_margenes_unicos_frasco_pequeno($centrado){
        $_CONFI                 =   [];
        if($centrado=='1')      {
            $_CONFI             =   array(
                                        'FO1'       =>  260,//1
                                        'FOY'       =>  10,//2
                                        'FOBODY'    =>  350,//4 lineax
                                        'FO2'       =>  290,//3
                                        'FOY2'      =>  20,
                                        'FIRST_X'   =>  20
                                    );
        } else if ($centrado=='2'){
            $_CONFI             =   array(
                                        'FO1'       =>  260,//*
                                        'FOY'       =>  40,
                                        'FOBODY'    =>  350,//paddin texto
                                        'FO2'       =>  290,
                                        'FOY2'      =>  50,
                                        'FIRST_X'   =>  50,
                                    );
        } else if ($centrado=='4'){
            $_CONFI             =   array(
                                        'FO1'       =>  210,//*
                                        'FOY'       =>  25,
                                        'FOBODY'    =>  300,//paddin texto
                                        'FO2'       =>  240,
                                        'FOY2'      =>  35,
                                        'FIRST_X'   =>  35,
                                    );
        } else if ($centrado=='5'){
            $_CONFI             =   array(
                                        'FO1'       =>  120,
                                        'FOY'       =>  5,
                                        'FOBODY'    =>  210,
                                        'FO2'       =>  150,
                                        'FOY2'      =>  15,
                                        'FIRST_X'   =>  15
                                    );
        } else if ($centrado=='6'){
            $_CONFI             =   array(
                                        'FO1'       =>  250,
                                        'FOY'       =>  50,
                                        'FOBODY'    =>  350,
                                        'FO2'       =>  290,
                                        'FOY2'      =>  60,
                                        'FIRST_X'   =>  60
                                    );  
            
            
        } else if ($centrado=='7'){
            $v_eje_fila         =   20;     #EJE FILA 
            $v_eje_comuna       =   175;    #EJE COLUMNA
            $_CONFI             =   array(
                                        'FO1'       =>  $v_eje_fila,   
                                        'FOY'       =>  $v_eje_comuna,  
                                        'FO2'       =>  $v_eje_fila+30,
                                        'FOY2'      =>  $v_eje_comuna+10,
                                        'FOBODY'    =>  $v_eje_fila+85,
                                        'FIRST_X'   =>  $v_eje_comuna+10
                                    );
            
        } else if ($centrado=='8'){
            #$_COOKIE['num_fila'];       #EJE FILA 
            $v_eje_fila         =   $this->input->cookie('num_fila',true); 
            #$_COOKIE['num_comuna'];    #EJE COLUMNA
            $v_eje_comuna       =   $this->input->cookie('num_comuna',true); 
            $_CONFI             =   array(
                                        'FO1'       =>  $v_eje_fila,   
                                        'FOY'       =>  $v_eje_comuna,  
                                        'FO2'       =>  $v_eje_fila+30,
                                        'FOY2'      =>  $v_eje_comuna+10,
                                        'FOBODY'    =>  $v_eje_fila+85,
                                        'FIRST_X'   =>  $v_eje_comuna+10
                                    );
        } else {
            $_CONFI             =   array(
                                        'FO1'       =>  5,
                                        'FOY'       =>  5,
                                        'FOBODY'    =>  90,
                                        'FO2'       =>  35,
                                        'FOY2'      =>  15,
                                        'FIRST_X'   =>  15
                                    );
        }
        return $_CONFI;
    } 
    
    #get 
    public function get_genera_cookie(){
        if (!$this->input->is_ajax_request()){  show_404(); }
        $status                     =   true;
        $v_num_comuna               =   $this->input->post('v_num_comuna');
        $v_num_fila                 =   $this->input->post('v_num_fila');
        
        #
        delete_cookie('num_comuna');
        delete_cookie('num_fila');
        $cookie_target1             =   array(
                                        'name'      =>  'num_comuna',
                                        'value'     =>  $v_num_comuna,
                                        'expire'    =>  86500,
                                        'secure'    =>  false
                                    );
        $this->input->set_cookie($cookie_target1);
        
        $cookie_target2             =   array(
                                        'name'      =>  'num_fila',
                                        'value'     =>  $v_num_fila,
                                        'expire'    =>  86500,
                                        'secure'    =>  false
                                    );  
        $this->input->set_cookie($cookie_target2);
        $this->output->set_output(json_encode(array(
            'stattus'               =>  $status,
            '_COOKIE'               =>  $_COOKIE,
        )));
    }
    
    #FRASCO PEQUENO EN CASETE
    public function main_etiqueta_pequena_casete($MAIN_ANATOMIA,$main_row,$centrado,$arr_li_muestras){
        $_CONFI                 =   $this->ind_margenes_unicos_frasco_pequeno($centrado);
        $TXT_CASETE             =   $MAIN_ANATOMIA['IND_USOCASSETTE']==1?'SI':'NO';
        //$INFO_GESPAB          =   '';
        //$INFO_RCE             =   '';
        $ID_BACODE              =   'C'.$main_row['ID_CASETE'];
        #IDENTIFICA PROCEDENCIA
            $info_linea_4       =   '';
        if($MAIN_ANATOMIA["PA_ID_PROCARCH"] == '63' || $MAIN_ANATOMIA["PA_ID_PROCARCH"] == '65'){
            $info_linea_4       =   $MAIN_ANATOMIA["TXT_PROCEDENCIA"];
        } else if($MAIN_ANATOMIA["PA_ID_PROCARCH"] == '31'){
            $info_linea_4       =   $MAIN_ANATOMIA['INFO_GESPAB'];
        } else {
            $info_linea_4       =   $MAIN_ANATOMIA["TXT_PROCEDENCIA"];
        }
        
        #CONTAR PALABRAS
        $v_count_strlen         =   strlen(implode(',',$arr_li_muestras));
        $texto_muestras         =   implode(',',$arr_li_muestras);
        $texto_muestras         =   substr($texto_muestras,0,35);
        
        #NUMERO CORRELATIVO
        $v_correlativo          =   '';
        if($MAIN_ANATOMIA["NUM_INTERNO_AP"] != 0){
            $v_margenes         =   '';
            if($centrado        ==  '1')      {
                $v_margenes     =   array('mr_x'=>270,'mr_y'=>160);
            }   else if ($centrado  =='2'){
                $v_margenes     =   array('mr_x'=>270,'mr_y'=>270);
            }   else if ($centrado  =='4'){
                $v_margenes     =   array('mr_x'=>220,'mr_y'=>170);
            }   else {
                $v_margenes     =   array('mr_x'=>10,'mr_y'=>140);
            }
            $v_correlativo      =   '^FT'.$v_margenes['mr_x'].','.$v_margenes['mr_y'].' 
                                    ^ACR,20,10
                                    ^FR^FH\^FD'.$MAIN_ANATOMIA["NUM_INTERNO_AP"].'^FS';
        }
        $zpl_zebra              =   '
                                    ^XA
                                        ^CI28
                                        ^FO'.$_CONFI['FO1'].','.$_CONFI['FOY'].'
                                        ^GB380,215,3^FS
                                        ^FO'.$_CONFI['FO2'].','.$_CONFI['FOY2'].',2
                                        ^BY2
                                        ^A0N,20,20
                                        ^BCR,50,Y,N,N
                                        ^FD'.$ID_BACODE.'^FS
                                        '.$v_correlativo;
        $zpl_zebra              .=  '                                    
                                        ^FS
                                        ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']).'               ^A0N,25,17^FD'.$main_row['TXT_HOSPITAL_ETI'].'^FS
                                        ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+25).'            ^A0N,25,15^FD'.$MAIN_ANATOMIA['NOMBRE_COMPLETO'].'^FS
                                        ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+50).'            ^A0N,25,15^FD'.$MAIN_ANATOMIA['RUTPACIENTE'].'|'.$MAIN_ANATOMIA['NACIMIENTO'].'|F:'.$MAIN_ANATOMIA['FICHAL'].'^FS
                                        ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+75).'            ^A0N,25,15^FD'.$info_linea_4.'^FS
                                        ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+100).'           ^A0N,25,15^FDDR:'.$MAIN_ANATOMIA['PROFESIONAL'].'^FS
                                        ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+125).'           ^A0N,25,15^FD'.$MAIN_ANATOMIA['TIPO_DE_BIOPSIA'].'^FS';
        #$zpl_zebra             .=  '   ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+150).'           ^A0N,25,15^FD'.$main_row['TXT_MUESTRA'].'^FS';
        $zpl_zebra              .=  '   ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+150).'           ^A0N,25,15^FD'.$texto_muestras.'^FS';
        $zpl_zebra              .=  '
                                        ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+175).'           ^A0N,25,15^FDCASETE:'.$TXT_CASETE.'^FS
                                    ^XZ
                                ';
        return $zpl_zebra;
    }
    
    public function test_etiquetas_frasco_publico($row,$main,$centrado){
        $TXT_CASETE             =   $main['IND_USOCASSETTE']==1?'SI':'NO';
        $NUM_ML                 =   $row['NUM_ML']==0?'':' |'.$row['NUM_ML']."ml";
        $ID_BACODE              =   $main['IND_USOCASSETTE']==1?'C'.$row['ID_CASETE']:'A'.$row['ID_NMUESTRA'];
        $_CONFI                 =   $this->ind_margenes_unicos_frasco_pequeno($centrado);
        #IDENTIFICA PROCEDENCIA
            $info_linea_4           =   '';
        if($main["PA_ID_PROCARCH"]  == '63' || $main["PA_ID_PROCARCH"] == '65'){
            $info_linea_4           =   $main["TXT_PROCEDENCIA"];
        } else if($main["PA_ID_PROCARCH"] == '31'){
            $info_linea_4           =   $main['INFO_GESPAB'];
        } else {
            $info_linea_4           =   $main["TXT_PROCEDENCIA"];
        }
        
        #NUMERO CORRELATIVO
        $v_correlativo              =   '';
        if ($main["NUM_INTERNO_AP"] != 0){
            $v_margenes             =   '';
            if($centrado        ==  '1')      {
                $v_margenes         =   array('mr_x'=>270,'mr_y'=>160);
            }   else if ($centrado  =='2'){
                $v_margenes         =   array('mr_x'=>270,'mr_y'=>270);
            }   else if ($centrado  =='4'){
                $v_margenes         =   array('mr_x'=>220,'mr_y'=>170);
            }   else {
                $v_margenes         =   array('mr_x'=>10,'mr_y'=>140);
            }
            $v_correlativo          =   '
                                        ^FT'.$v_margenes['mr_x'].','.$v_margenes['mr_y'].' 
                                        ^ACR,20,10
                                        ^FR^FH\^FD'.$main["NUM_INTERNO_AP"].'^FS';
        }
        $zpl_zebra                  =   '
                                        ^XA
                                            ^CI28
                                            ^FO'.$_CONFI['FO1'].','.$_CONFI['FOY'].' ^GB380,215,3  ^FS
                                            ^FO'.$_CONFI['FO2'].','.$_CONFI['FOY2'].',2
                                            ^BY2
                                            ^A0N,20,20
                                            ^BCR,50,Y,N,N
                                            ^FD'.$ID_BACODE.'^FS
                                            '.$v_correlativo.'
                                            ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']).'       ^A0N,25,17^FD'.$row['TXT_HOSPITAL_ETI'].'^FS
                                            ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+25).'    ^A0N,25,15^FD'.$main['NOMBRE_COMPLETO'].'^FS
                                            ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+50).'    ^A0N,25,15^FD'.$main['RUTPACIENTE'].'|'.$main['NACIMIENTO'].'|F:'.$main['FICHAL'].'^FS
                                            ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+75).'    ^A0N,25,15^FD'.$info_linea_4.'^FS
                                            ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+100).'   ^A0N,25,15^FDDR:'.$main['PROFESIONAL'].'^FS
                                            ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+125).'   ^A0N,25,15^FD'.$main['TIPO_DE_BIOPSIA'].'^FS
                                            ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+150).'   ^A0N,25,15^FD'.$row['TXT_MUESTRA'].'^FS
                                            ^FO'.$_CONFI['FOBODY'].','.($_CONFI['FIRST_X']+175).'   ^A0N,25,15^FDCASETE:'.$TXT_CASETE.$NUM_ML.'^FS
                                        ^XZ
                                    ';
        return $zpl_zebra;
    }
    
    #################################################
    #SOLICITUD DE : ANATOMIA PATOLOGICA 
    #PACIENTE + SERVICIO + FORMULARIO + GET = PDF
    #MODAL 50%
    ##################################################
    public function new_nueva_solicitud_anatomia_ext(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                                =   $this->session->userdata("COD_ESTAB");
        $session_arr                            =   explode("-",$this->session->userdata('USERNAME'));
        $NUM_FICHAE                             =   $this->input->post('NUM_FICHAE');
        $ADMISION                               =   $this->input->post('ADMISION');
        $session                                =   $session_arr[0];
        $DATA_CURSOR                            =   $this->ssan_libro_biopsias_usuarioext_model->data_pre_nuevasoliciud_anatomia(array(
                "COD_EMPRESA"                   =>  $empresa,
                "USR_SESSION"                   =>  $session,
                "DATE_FROM"                     =>  date("d-m-Y"),
                "DATE_TO"                       =>  date("d-m-Y"),
                "NUM_FICHAE"                    =>  $NUM_FICHAE,
                "ADMISION"                      =>  $ADMISION,
            ));
        $TABLA["GET_HTML"]                      =   $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/NUEVO_PACIENTE_SOLICITUD",$DATA_CURSOR,true);
        $TABLA["DATA_INFO"]                     =   $DATA_CURSOR;
        $TABLA["SALIDA_DIRECTA"]                =   true;
        $this->output->set_output(json_encode($TABLA));
    }

    public function php_generar_zpl_to_pdf(){
        $zpl                                    =   $this->input->post('txt_zpl');
        $V_TAMANO_ETIQUETA                      =   $this->input->post('V_TAMANO_ETIQUETA'); 
        $curl                                   =   curl_init();
        // adjust print density (8dpmm), label width (4 inches), label height (6 inches), and label index (0) as necessary
        curl_setopt($curl,CURLOPT_URL,$V_TAMANO_ETIQUETA==1?"http://api.labelary.com/v1/printers/8dpmm/labels/1.95x1.1/0/":"http://api.labelary.com/v1/printers/8dpmm/labels/4x2.8/0/");
        curl_setopt($curl,CURLOPT_POST,TRUE);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $zpl);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($curl,CURLOPT_HTTPHEADER, array("Accept:application/pdf")); // omit this line to get PNG images back
        $result                                 =   curl_exec($curl);
        $this->output->set_output(base64_encode($result));
    }
    
    public function imprime_etiqueta_gespab(){
        if(!$this->input->is_ajax_request()) { show_404(); }
        $HTML                                   =   '';
        $HTML_MAIN                              =   '';
        $ZPL_DATA                               =   '';
        $ROW_DATA                               =   [];
        $ARR_CASETE_ORD                         =   [];
        //$count_main                           =   0;
        $empresa                                =   $this->session->userdata("COD_ESTAB");
        $ID_ATATOMIA                            =   $this->input->post('id_anatomia');
        $ind_centrado                           =   $this->input->post('ind_centrado');
        $cookie_target1                         =   array(
                                                        'name'      =>  'num_comuna',
                                                        'value'     =>  $this->input->post('num_comuna'),
                                                        'expire'    =>  86500,
                                                        'secure'    =>  false
                                                    );
        $this->input->set_cookie($cookie_target1);
        $cookie_target2                         =   array(
                                                        'name'      =>  'num_fila',
                                                        'value'     =>  $this->input->post('num_fila'),
                                                        'expire'    =>  86500,
                                                        'secure'    =>  false
                                                    );
        $this->input->set_cookie($cookie_target2);
        $DATA                                   =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array(
                                                        "COD_EMPRESA"                       =>  $empresa,
                                                        "ID_HISTO"                          =>  $ID_ATATOMIA
                                                    ));
        $count_main                             =   (count($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'])+count($DATA['P_AP_MUESTRAS_CITOLOGIA']));
        if($count_main>0){
            #$P_ANATOMIA_PATOLOGICA_MAIN                =   $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0];
            #MUESTRAS ANATOMIACA
            if(count($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'])>0){
                $P_ANATOMIA_PATOLOGICA_MAIN             =   $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0];
                $IND_USOCASSETTE                        =   $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_USOCASSETTE'];
                if($IND_USOCASSETTE == 1){
                    foreach($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'] as $i => $row){ 
                        $ARR_CASETE_ORD[$row['NUM_CASSETTE']][]     =   $row; 
                    }
                    foreach($ARR_CASETE_ORD  as $y => $data_casete){
                        $arr_li_muestras        =   [];
                        foreach($data_casete as $z => $row){
                            array_push($arr_li_muestras,$row['TXT_MUESTRA']);
                        }
                        $main_row                       =   $ARR_CASETE_ORD[$y][0];
                        $ZPL_DATA                       =   $data_casete[0]['NUM_CASSETTE']==2?
                                                                $this->main_etiqueta_pequena_casete($P_ANATOMIA_PATOLOGICA_MAIN,$main_row,$ind_centrado,$arr_li_muestras):
                                                                $this->main_etiqueta_pequena_casete($P_ANATOMIA_PATOLOGICA_MAIN,$main_row,$ind_centrado,$arr_li_muestras);
                        $HTML_MAIN                      .=  $ZPL_DATA;
                        $ROW_DATA['GESPAB_'.$i]         =   $ZPL_DATA;
                    }
                } else {
                    foreach($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'] as $i => $row){
                        $ZPL_DATA                       =   $row['IND_ETIQUETA']==2?
                                                                //$this->main_etiqueta_mediana_v1($ID_ATATOMIA,$P_ANATOMIA_PATOLOGICA_MAIN,$row,$count_main)
                                                                $this->main_etiqueta_mediana_v2($ID_ATATOMIA,$P_ANATOMIA_PATOLOGICA_MAIN,$row,$count_main):
                                                                $this->test_etiquetas_frasco_publico($row,$P_ANATOMIA_PATOLOGICA_MAIN,$ind_centrado);
                        $HTML_MAIN                     .=   $ZPL_DATA;
                        $ROW_DATA['ANATOMICA_'.$i]      =   $ZPL_DATA;
                    }
                }
            }
            #CITOLOGIA
            if(count($DATA['P_AP_MUESTRAS_CITOLOGIA'])>0){
                foreach($DATA['P_AP_MUESTRAS_CITOLOGIA'] as $i => $row){
                    $ZPL_DATA                           =   $row['IND_ETIQUETA']==2?
                                                                //$this->main_etiqueta_mediana_v1($ID_ATATOMIA,$P_ANATOMIA_PATOLOGICA_MAIN,$row,$count_main)
                                                                $this->main_etiqueta_mediana_v2($ID_ATATOMIA,$P_ANATOMIA_PATOLOGICA_MAIN,$row,$count_main):
                                                                $this->test_etiquetas_frasco_publico($row,$P_ANATOMIA_PATOLOGICA_MAIN,$ind_centrado);
                    $HTML_MAIN                          .=  $ZPL_DATA;
                    $ROW_DATA['CITOLOGICA_'.$i]         =   $ZPL_DATA;
                }
            }
        }
        #OUT
        $TABLA["STATUS"]                                =   true;
        $TABLA["NUM_MUESTRA"]                           =   $count_main;
        $TABLA["ROW"]                                   =   $ROW_DATA;
        $TABLA["DATA"]                                  =   $DATA;
        $TABLA["DATA_ZPL"]                              =   $ZPL_DATA;
        $TABLA["HTML_FINAL"]                            =   $HTML;
        $TABLA["ZPL_FINAL_OUT"]                         =   $HTML_MAIN;
        $TABLA["ARR_CASETE_ORD"]                        =   $ARR_CASETE_ORD;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function visualizacion_etiqueta_cu(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $empresa                            =   $this->session->userdata("COD_ESTAB");
        $html                               =   '';
        $ROW_DATA                           =   '';
        $IND_USOCASSETTE                    =   '';
        $ind_ord                            =   '';
        $MAIN_ANATOMIA                      =   '';
        $arr_li_muestras                    =   '';
        $ARR_CASETE_ORD                     =   [];
        #CONF ETIQUETA
        $ind_centrado                       =   $this->input->post('CONFIG_FRASCO');
        $ID_ATATOMIA                        =   $this->input->post('id');
        $V_TAMANO_ETIQUETA                  =   $this->input->post('V_TAMANO_ETIQUETA'); 
        #$DATA                              =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$ID_ATATOMIA));
        #P.PA_ID_PROCARCH = 31              =   ID_TABLA
        #P.PA_ID_PROCARCH = 36              =   ID_HISTO   
        #P.PA_ID_PROCARCH = 63              =   ID_ADMISION
        $cookie_target1                     =   array(
                                                    'name'      =>  'num_comuna',
                                                    'value'     =>  $this->input->post('num_comuna'),
                                                    'expire'    =>  86500,
                                                    'secure'    =>  false
                                                );
        $this->input->set_cookie($cookie_target1);
        $cookie_target2                         =   array(
                                                        'name'      =>  'num_fila',
                                                        'value'     =>  $this->input->post('num_fila'),
                                                        'expire'    =>  86500,
                                                        'secure'    =>  false
                                                    );
        $this->input->set_cookie($cookie_target2);
        $DATA                                   =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array(
            "COD_EMPRESA"                       =>  $empresa,
            "ID_HISTO"                          =>  $ID_ATATOMIA
        ));
        $count_main                             =   (count($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'])+count($DATA['P_AP_MUESTRAS_CITOLOGIA']));
        if(count($count_main)>0){
            if(count($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'])>0){
                $MAIN_ANATOMIA                  =   $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0];
                $html                          .=   '<div class="CSS_HASHTAG_2">';
                $IND_USOCASSETTE                =   $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_USOCASSETTE'];
                
                $html                          .=   '
                                                    <div class="card" style="margin-bottom: 5px;">
                                                        <div class="header">
                                                            <div class="grid_titulo_etiquetas_mu">
                                                                <div class="grid_titulo_etiquetas_mu1">
                                                                    <h4 class="title">
                                                                        <b>M. ANATOMICA | '.count($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS']).'</b>
                                                                    </h4>
                                                                </div>
                                                                <div class="grid_titulo_etiquetas_mu2" style="text-align: -webkit-right;">
                                                                    <button type="button" class=" btn btn-xs btn-success btn-fill" id="btn_genera_pdf" onclick="js_recorre_zpl()" style="margin-right: 30px;">
                                                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="content" style="margin-top:-20px;">
                                                            <div class="">
                                                                ';
                if($IND_USOCASSETTE == 1) {
                    foreach($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'] as $i => $row){ 
                        $ARR_CASETE_ORD[$row['NUM_CASSETTE']][]     =   $row; 
                    }
                    if(count($ARR_CASETE_ORD)>0){
                        $li_muestras                =   '';
                        $html                      .=   '
                                                            <div class="CSS_GRID_HEAD_CASETE">
                                                                <div class="CSS_GRID_HEAD_CASETE1 text-center"><b>N&deg;</b></div>
                                                                <div class="CSS_GRID_HEAD_CASETE1 text-center"><i class="fa fa-file-o" aria-hidden="true"></i></div>
                                                                <div class="CSS_GRID_HEAD_CASETE1 "><b style="margin-left:7px;">OBSERVACI&Oacute;N</b></div>
                                                                <div class="CSS_GRID_HEAD_CASETE1 "><i class="fa fa-print" aria-hidden="true" style="margin-left:20px;"></i></div>
                                                            </div>
                                                            <hr style="margin:0px 0px">
                                                        ';
                        foreach($ARR_CASETE_ORD  as $y => $data_casete){
                            $arr_li_muestras        =   [];
                            foreach($data_casete as $z => $row){
                                $li_muestras        .=  "<li>".$row['TXT_MUESTRA']."</li>";
                                array_push($arr_li_muestras,$row['TXT_MUESTRA']);
                            }
                            $num_aux                =   ($y+1);
                            $count_muestra          =   count($data_casete);
                            $STYLE                  =   $y%2==0?'':'CSS_GRUPO';
                            $ind_ord[]              =   $data_casete[0];
                            $main_row               =   $ARR_CASETE_ORD[$y][0];
                            $html                  .=   '<div class="CSS_GRID_VIEWS_CASETE '.$STYLE.'">
                                                                <div class="CSS_GRID_VIEWS_CASETE1 text-center">'.$y.'</div>
                                                                <div class="CSS_GRID_VIEWS_CASETE2 ">'.$data_casete[0]['NUM_CASSETTE'].'/'.$data_casete[0]['ID_CASETE'].'</div>
                                                                <div class="CSS_GRID_VIEWS_CASETE3 " style="<!--margin-left: -30px;-->"><ul class="ul_class">'.$li_muestras.'</ul></div>
                                                                <div class="CSS_GRID_VIEWS_CASETE4 ">'; 
                            $html                   .=              '
                                                                        <button 
                                                                            type                        =   "button" 
                                                                            class                       =   "btn btn-xs btn-info btn-fill arr_zpl" 
                                                                            id                          =   "BTN_ZPL_'.$row['ID_NMUESTRA'].'" 
                                                                            data-zpl                    =   "'.htmlspecialchars(json_encode(array(
                                                                            'TAMANO_ETIQUETA'           =>  2,
                                                                            'NUMERO_MUESTRA'            =>  $data_casete[0]['NUM_CASSETTE'],
                                                                            'BODY_ZPL'                  =>  $data_casete[0]['NUM_CASSETTE']==2?
                                                                                                            $this->main_etiqueta_pequena_casete($MAIN_ANATOMIA,$main_row,$ind_centrado,$arr_li_muestras):
                                                                                                            $this->main_etiqueta_pequena_casete($MAIN_ANATOMIA,$main_row,$ind_centrado,$arr_li_muestras),
                                                                            )),ENT_QUOTES,'UTF-8').'"
                                                                            onclick                     =   "hashtag_small(this.id)">
                                                                            <i class="fa fa-barcode" aria-hidden="true"></i>
                                                                        </button>
                                                                    ';
                            
                            $html                   .=          '</div>
                                                            </div>    
                                                        ';
                            $li_muestras            =   '';
                        }
                    }
                    #asignar id unico al casete
                    #mostrar en la etiqueta mediana o grande
                } else {
                    foreach($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'] as $i => $row){
                            $n                          =   ($i+1);
                            $STYLE                      =   $i%2==0?'CSS_GRUPO':'';
                            $html                      .=   '   <div class="CSS_GRID_VIEWS_HASHTAG '.$STYLE.'">
                                                                    <div class="text-center">'.$row['N_MUESTRA'].'</div>
                                                                    <div class="text-center">'.$row['ID_NMUESTRA'].'</div>
                                                                    <div class="">'.$row['TXT_MUESTRA'].'</div>
                                                                    <div class="">'.$row['TXT_ETIQUETA'].'</div>
                                                                    <div class="" id="plz_'.$row['ID_NMUESTRA'].'">';
                            $html                      .=   '           
                                                                        <button 
                                                                            type                        =   "button" 
                                                                            class                       =   "btn btn-xs btn-info btn-fill arr_zpl" 
                                                                            id                          =   "BTN_ZPL_'.$row['ID_NMUESTRA'].'" 
                                                                            data-zpl                    =   "'.htmlspecialchars(json_encode(array(
                                                                            'TAMANO_ETIQUETA'           =>  $row['IND_ETIQUETA'],
                                                                            'NUMERO_MUESTRA'            =>  $row['ID_NMUESTRA'],
                                                                            'BODY_ZPL'                  =>  $row['IND_ETIQUETA']==2?
                                                                                                            //$this->main_etiqueta_mediana_v1($ID_ATATOMIA,$MAIN_ANATOMIA,$row,$count_main):
                                                                                                            $this->main_etiqueta_mediana_v2($ID_ATATOMIA,$MAIN_ANATOMIA,$row,$count_main)
                                                                                                            :
                                                                                                            $this->test_etiquetas_frasco_publico($row,$MAIN_ANATOMIA,$ind_centrado),
                                                                            )),ENT_QUOTES,'UTF-8').'"
                                                                            onclick                     =   "hashtag_small(this.id)">
                                                                            <i class="fa fa-barcode" aria-hidden="true"></i>
                                                                        </button>
                                                            ';
                            $html                      .=   '       </div>
                                                                </div>    
                                                            ';
                            $ROW_DATA['GESPAB_'.$i]    =   $row;
                        }
                }
                    $html                       .=               '</div>
                                                            </div>
                                                        </div>';
                    $html                         .=   ' </div>';
            }
            //********************************************************************
            if(count($DATA['P_AP_MUESTRAS_CITOLOGIA'])>0){
                $html                         .=   '
                                                    <div class="card" style="margin-bottom: 5px;">
                                                        <div class="header">
                                                            <h4 class="title" style="margin-bottom:5px"><b>CITOL&Oacute;GICAS | '.count($DATA['P_AP_MUESTRAS_CITOLOGIA']).'</b></h4>
                                                        </div>
                                                        <div class="content" style="margin-top:-20px;">
                                                            <div class="">
                                                                ';
                            foreach($DATA['P_AP_MUESTRAS_CITOLOGIA'] as $i => $row){
                                $n                              =   ($i+1);
                                $STYLE                          =   $i%2==0?'CSS_GRUPO':'';
                                    $html                      .=   '<div class="CSS_GRID_VIEWS_HASHTAG2 '.$STYLE.'">
                                                                        <div class="text-center">'.$row['N_MUESTRA'].'</div>
                                                                        <div class="text-center">'.$row['ID_NMUESTRA'].'</div>
                                                                        <div >'.$row['TXT_MUESTRA'].'</div>
                                                                        <div class="text-center">'.$row['NUM_ML'].'ml</div>
                                                                        <div >'.$row['TXT_ETIQUETA'].'</div>
                                                                        <div class="text-center" id="plz_'.$row['ID_NMUESTRA'].'">';
                                    
                                    $html                      .=       '<button 
                                                                            type                        =   "button" 
                                                                            class                       =   "btn btn-xs btn-info btn-fill arr_zpl" 
                                                                            id                          =   "BTN_ZPL_'.$row['ID_NMUESTRA'].'" 
                                                                            data-zpl                    =   "'.htmlspecialchars(json_encode(array(
                                                                            'TAMANO_ETIQUETA'           =>  $row['IND_ETIQUETA'],        
                                                                            'NUMERO_MUESTRA'            =>  $row['ID_NMUESTRA'],
                                                                            'BODY_ZPL'                  =>  $row['IND_ETIQUETA']==2?
                                                                                                            //$this->main_etiqueta_mediana_v1($ID_ATATOMIA,$MAIN_ANATOMIA,$row,$count_main):
                                                                                                            $this->main_etiqueta_mediana_v2($ID_ATATOMIA,$MAIN_ANATOMIA,$row,$count_main)
                                                                                                            :
                                                                                                            $this->test_etiquetas_frasco_publico($row,$MAIN_ANATOMIA,$ind_centrado),
                                                                            )),ENT_QUOTES,'UTF-8').'"
                                                                            onclick                     =   "hashtag_small(this.id)">
                                                                            <i class="fa fa-barcode" aria-hidden="true"></i>
                                                                        </button>';
                                    
                                    $html                      .=       '</div>    
                                                                    </div>';
                            }
                $html                      .=               '</div>
                                                        </div>
                                                    </div>';
            }
        } else {
            $html                           =       'NA';
        }
        #OUT
        $this->output->set_output(json_encode(array(
            'STATUS'            =>  true,
            'IND_ORDENADO'      =>  $ind_ord,
            'ARR_CASETE_ORD'    =>  $ARR_CASETE_ORD,
            'IND_USOCASSETTE'   =>  $IND_USOCASSETTE,
            'STATUS_OUT'        =>  $ID_ATATOMIA,
            'GET_HTML'          =>  $html,
            'INFO'              =>  $ROW_DATA,
            'MAIN_ANATOMIA'     =>  $MAIN_ANATOMIA,
            'DATA_TOTAL'        =>  $DATA,
            'arr_li_muestras'   =>  $arr_li_muestras,
            'cookie'            =>  $_COOKIE,
        )));
    }
    
    
    
    public function main_etiqueta_mediana_v2($ID_ATATOMIA,$DATA,$DATA_ETIQUETA,$count_main){
            //***********************************************************************
            $TXT_HOSPITAL                       =   'HOSPITAL DR. MAURICIO HEYERMANN';
            $SYSDATE                            =   date('d-m-Y h:m');
            $PA_ID_PROCARCH                     =   $DATA['PA_ID_PROCARCH'];  
            $NOMBRE_PACIENTE                    =   $DATA['NOMBRE_COMPLETO'];   
            $NOMBRE_SERVICIO                    =   $DATA['NOMBRE_SERVICIO'];
            $RUT_PROFESIONAL                    =   $DATA['RUT_PROFESIOAL']; 
            $PROFESIONAL                        =   $DATA['PROFESIONAL']; 
            $RUTPACIENTE                        =   $DATA['RUTPACIENTE']; 
            $NACIMIENTO                         =   $DATA['NACIMIENTO'];  
            $NUMEDAD                            =   $DATA['NUMEDAD'];  
            $FICHAL                             =   $DATA['FICHAL'];   
            $TXT_PREVISION                      =   $DATA['TXT_PREVISION'];
            //$hex                              =   $this->str2hex($txt);
            /*
            $TXT_DIAGNOSTICO                    =   $DATA['TXT_DIAGGESPAB']; 
            $INFO_GESPAB                        =   $DATA['TXT_SALAPAB'].'|'.$DATA['TXT_FECIRU'];
            */
            $INFO_RCE                           =   $DATA["PA_ID_PROCARCH"];
            $TXT_DIAGNOSTICO                    =   '';
            $INFO_GESPAB                        =   '';
            $INFO_GESPAB                        =   isset($DATA["INFO_GESPAB"])?$DATA["INFO_GESPAB"]:''; 
            //$TXT_DIAGNOSTICO                  =   $this->str2hex($DATA['TXT_DIAGNOSTICO']);
            $ID_TABLA                           =   $DATA['ID_TABLA'];
            $TIPO_DE_BIOPSIA                    =   $DATA['TIPO_DE_BIOPSIA'];
            $N_MUESTRA                          =   $DATA_ETIQUETA['N_MUESTRA']; 
            $ID_NMUESTRA                        =   $DATA_ETIQUETA['ID_NMUESTRA'];
            $TXT_NMUESTRA                       =   $DATA_ETIQUETA['TXT_MUESTRA'];
            $ID_ANATOMIA                        =   $DATA['ID_SOLICITUD'];
            $clave                              =   md5('clave_del_usuario');
            #$clave                             =   md5('clave_del_usuario');
            #$img_logo_100                       =   $DATA['COD_EMPRESA']=='106'?$this->img_logo_106():'';
            $img_logo_100                       =   '';
            if ($DATA['COD_EMPRESA'] == '100'){
                $img_logo_100                   =   $this->img_logo_100();
            } else if ($DATA['COD_EMPRESA']     ==  '106'){
                $img_logo_100                   =   $this->img_logo_106();
            }
            $txt_info_vertical                  =   '';
            #$txt_info_vertical                  =   $PA_ID_PROCARCH.'|'.$ID_TABLA.'|'.$ID_ANATOMIA.'|'.$SYSDATE;
            $NOMBRE_PACIENTE2                   =   '';
            $zpl_zebra                          =   '^XA 
                                                        ^CI28 
                                                        ^FX -- LIMITE SUPERIOR --
                                                        ^LT-30
                                                        ^LS30

                                                        ^FX -- SECCION SUPERIOR CON LOGO, NOMBRE Y DIRECCION --
                                                        ^CF0,40
                                                        ^FO50,'.$img_logo_100.'

                                                        ^FX -- LATERAL IZQUIERDO --
                                                        ^FT800,50
                                                        ^ACR,20,10
                                                        ^FR^FH\^FD ORIGEN:'.$txt_info_vertical.' ^FS

                                                        ^FX -- QR FROM PDF TO --
                                                        ^FO600,40^BQN,2,5,M,7^FDQA,https://esissan.cl/ssan_libro_biopsias_listagespab?id=725&m=710&id='.$ID_ANATOMIA.'/^FS

                                                        ^FX -- SEGUNDA SECCION DERECHA CON LA INFORMACION DEL PACIENTE --
                                                        ^CFA,30
                                                        ^FO50,195^FD'.$NOMBRE_PACIENTE2.'^FS
                                                        ^FO50,225^FD'.$NOMBRE_PACIENTE.'^FS
                                                        ^FO50,255^FD'.$RUTPACIENTE.'|'.$NACIMIENTO.'|Edad:'.$NUMEDAD.'^FS
                                                        ^FO50,285^FDFICHA:'.$FICHAL.'^FS
                                                        ^FO50,315^FD'.$TXT_PREVISION.'^FS
                                                        ^FO50,345^FDDr/a:'.$PROFESIONAL.'^FS
                                                        ^FO50,375^FD'.$INFO_GESPAB.'^FS
                                                        ^FO50,405^FD'.$TXT_DIAGNOSTICO.'^FS
                                                            
                                                        ^FX -- CODIGO DE BARRA --
                                                        ^FO50,440
                                                        ^BY3
                                                        ^BCN,80,Y,N,N
                                                        ^FDA'.$ID_NMUESTRA.'^FS

                                                        ^FX -- INFORMACION MUESTRA INDIVIDUAL --
                                                        ^CF0,30^FO410,440^FD'.$TIPO_DE_BIOPSIA.'^FS
                                                        ^CF0,30^FO410,470^FD'.$TXT_NMUESTRA.'^FS
                                                        ^CF0,30^FO410,500^FD1'.$N_MUESTRA.'^FS

                                                    ^XZ';
        return $zpl_zebra;
    }
    
    public function img_logo_106(){
        return     '
                        40^GFA,4350,4350,50, 0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC000007FFF8000000000000000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC000007FFFFFFFE0000FFFF0000040000000004000030000000000C0300000000800000000000080000000000
                        00000007FFFC000007FFFFFFFE0001FFFE000000000000000400001000000000040200000000000000000000040000000000
                        00000007FFFC000007FFFFFFFE0001FFFE000000000000000400000000000000000200000000004000000000020000000000
                        00000007FFFC000007FFFDFFFE0001FFFE000000010000000400000000000000020200000000002000000000000000000000
                        00000007FFFC000007FFF01FFE0003FFFC000020010000000400000000000000020200000000002000000000000000000000
                        00000007FFFC000007FF4011FE0003FFFC000020010000000400000000000000000200000000002000000000000800000000
                        00000007FFFC000007FF0001FE0003FFF8080420010000400400000000000000010200000000002000080000010800000000
                        00000007FFFC000007FFB801FE0007FFF8000020010000000400000000000000000200000004002000000000000000000000
                        00000007FFFC000007FFC0E3FE0007FFF8000020010000000400000000000000000200000000002000000000000000000000
                        00000007FFFC000007FBC003FE000FFFF0000000000000000400010200000000408204000000000000000000000000000000
                        00000007FFFC000007F1C00E26000FFFF0000000000000000400000000000000800200000000004000000000020000000000
                        00000007FFFC000007F0000006000FFFF0000000000000000400000000000000000200000000000000000000040000000000
                        00000007FFFC000007F8000006000FFFF0000000000000000400000008000001000201000000000000000000000800000000
                        00000007FFFC0000079FF0000E000FFFE0000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC000007C0000006001FFFE0000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC000007E1700E02001FFFE0000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC00000438000002001FFFC0000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC00000703C00002003FFFC0000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC000007E0001802003FFFC0000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC0000077E000FDE007FFF80000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC0000070180000E007FFF80000000000000000000000000000000000000000000000000000000000000000000
                        00000007FFFC000007FF20001E007FFF800FFE000007FE00001FFFFFFFE00000FFC00000FFFFFE0000FF800003FFE0000000
                        00000007FFFC000007F0C887FE00FFFF000FFE0000FFFFE0001FFFFFFFE0000FFFFC0000FFFFFFC000FF800003FFF0000000
                        00FFFFFFFFFFFFFFFFF798C0FE00FFFF000FFE0001FFFFF8001FFFFFFFE0003FFFFF0000FFFFFFF000FF800007FFF0000000
                        00FFFFFFFFFFFFFFFFFF38F03E00FFFE000FFE0003FFFFFC001FFFFFFFE0007FFFFF8000FFFFFFF800FF800007FFF0000000
                        00FFFFFFFFFFFFFFFFF878FE3E01FFFE000FFE000FFFFFFE001FFFFFFFE000FFFFFFC000FFFFFFFC00FF800007FFF8000000
                        00FFFFFFFFFFFFFFFFC1F8FFFE01FFFE000FFE001FFFFFFF001FFFFFFFE001FFFFFFE000FFFFFFFC00FF80000FFFF8000000
                        00FFFFFFFFFFFFFFFFE7F8FFFE03FFFC000FFE003FFFFFFF801FFFFFFFE003FFFFFFF000FFFFFFFE00FF80000FFFF8000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE03FFFC000FFE007FFFFFFFC01FFFFFFFE007FFFFFFF800FFFFFFFF00FF80000FFFF8000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE03FFFC000FFE00FFFFFFFFE00007FF80000FFFFFFFFC00FFE01FFF00FF80001FFFFC000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE07FFF8000FFE00FFFFFFFFF00003FF00001FFF807FFC00FFC007FF80FF80001FFFFC000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE07FFF8000FFE00FFFFFFFFF00003FF00001FFE001FFE00FFC003FF80FF80003FFFFC000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE07FFF0000FFE00FFFE07FFF80003FF00003FFC000FFE00FFC003FF80FF80003FF7FE000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE07FFF0000FFE01FFF803FFF80003FF00003FF80007FF00FFC003FF80FF80003FE7FE000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE0FFFF0000FFE01FFF801FFF80003FF00007FF00003FF00FFC003FF80FF80007FE7FF000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE0FFFF0000FFE01FFF001FFF80003FF00007FF00003FF80FFC003FF80FF80007FE3FF000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE0FFFF0000FFE03FFF00000000003FF00007FE00003FF80FFC003FF80FF8000FFC3FF000000
                        00FFFFFFFFFFFFFFFFFFF8FFFE1FFFE0000FFE03FFE00000000003FF00007FE00001FF80FFC007FF00FF8000FFC1FF800000
                        00FFFFFFFFFFFFFFFFFFF8FFFE1FFFE0000FFE03FFE00000000003FF00007FE00001FF80FFC007FF00FF8000FFC1FF800000
                        00FFFFFFFFFFFFFFFFFFF8FFFE1FFFC0000FFE03FFE00000000003FF00007FE00001FF80FFC01FFE00FF8001FF81FF800000
                        00000007FFFE000007FFF8FFFE3FFFC0000FFE03FFE00000000003FF00007FE00001FF80FFFFFFFE00FF8001FF80FFC00000
                        00000007FFFC000007FFF8FFFE3FFFC0000FFE03FFE00000000003FF00007FE00001FF80FFFFFFFC00FF8003FF80FFC00000
                        00000007FFFC000007FFF8FFFE3FFF80000FFE03FFE00000000003FF00007FE00001FF80FFFFFFF800FF8003FF00FFE00000
                        00000007FFFC000007FFF8FFFE7FFF80000FFE03FFE00000000003FF00007FE00001FF80FFFFFFE000FF8003FF007FE00000
                        00000007FFFC000007FFF8FFFE7FFF00000FFE03FFE00000000003FF00007FE00001FF80FFFFFF8000FF8003FE007FF00000
                        00000007FFFC000007FFF8FFFFFFFF00000FFE03FFE00000000003FF00007FE00001FF80FFFFFF0000FF8007FE003FF00000
                        00000007FFFC000007FFF8FFFFFFFF00000FFE03FFF00000000003FF00007FE00003FF80FFC7FF0000FF8007FE003FF00000
                        00000007FFFC000007FFF8FFFFFFFE00000FFE01FFF001FFF80003FF00007FF00003FF80FFC7FF0000FF8007FF007FF00000
                        00000007FFFC000007FFF8FFFFFFFE00000FFE01FFF801FFF80003FF00007FF00003FF00FFC3FF8000FF800FFFFFFFF00000
                        00000007FFFC000007FFF8FFFFFFFE00000FFE01FFFC03FFF80003FF00003FF80007FF00FFC3FF8000FF800FFFFFFFF80000
                        00000007FFFC000007FFF8FFFFFFFC00000FFE00FFFF0FFFF00003FF00003FFE000FFE00FFC1FFC000FF801FFFFFFFF80000
                        00000007FFFC000007FFF8FFFFFFFC00000FFE00FFFFFFFFF00003FF00001FFF003FFE00FFC0FFC000FF801FFFFFFFFC0000
                        00000007FFFC000007FFF8FFFFFFFC00000FFE00FFFFFFFFE00003FF00000FFFE1FFFC00FFC0FFE000FF801FFFFFFFFC0000
                        00000007FFFC000007FFF8FFFFFFF800000FFE007FFFFFFFE00003FF000007FFFFFFFC00FFC07FE000FF803FFFFFFFFC0000
                        00000007FFFC000007FFF8FFFFFFF800000FFE003FFFFFFFC00003FF000007FFFFFFF800FFC07FF000FF803FFFFFFFFE0000
                        00000007FFFC000007FFF8FFFFFFF800000FFE003FFFFFFF800003FF000003FFFFFFF000FFC03FF000FF803FF0000FFE0000
                        00000007FFFC000007FFF8FFFFFFF800000FFE001FFFFFFF000003FF000001FFFFFFE000FFC03FF800FF807FF00007FF0000
                        00000007FFFC000007FFF8FFFFFFF000000FFE0007FFFFFE000003FF000000FFFFFFC000FFC03FFC00FF807FE00007FF0000
                        00000007FFFC000007FFF8FFFFFFF000000FFE0003FFFFFC000003FF0000003FFFFF0000FFC01FFC00FF80FFE00003FF0000
                        00000007FFFC000007FFF8FFFFFFF000000FFE0000FFFFF0000003FF0000000FFFFE0000FFC00FFE00FF80FFE00003FF8000
                        00000007FFFC000007FFF8FFFFFFE000000FFE00003FFFC0000003FF00000003FFF00000FFC00FFF00FF80FFC00003FF8000
                        00000007FFFC000007FFF8FFFFFFE000000FFE000007FE00000003FF000000007F800000FFC007FF00FF81FFC00001FFC000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                        ^FS
                    ';
    }    
    
    public function img_logo_100(){
         return     '
                    40^GFA,9380,9380,67, 
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000198C0000000000000000
                    0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000072110E000000000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000064A1991700000000000000
                    0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000B4A1051400000000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000EB4A1052218000000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000AF40800A210000000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000C5000000622C00000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000002040000000024800000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000003C4000000003D800000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000038600000000001000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000024400000000001030000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000220000000000000D0000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000002200000000000001F2000000000
                    0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000011C000000000000027000000000
                    000000003FFF0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000008000000000000002C000000000
                    00000003FFFFF00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000E0000000000000008C00000000
                    0000001FFFFFFE000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000800000000000000001800000000
                    000000FFF007FFC00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000006C00000000000000002000000000
                    000003FE00001FF00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000007E00000000000000002180000000
                    00000FF0000003FC0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000003000000000000000000180000000
                    00001FC0000000FE0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001000000000000000000100000000
                    00003E000000001F00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000300000000000000000003C0000000
                    0000FC000000000FC000000000000000000000000000000000000000000000000000000000000000000000000000000000000000018000000000000000000390000000
                    0001F00000000003E00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000E000000000000000000068000000
                    0003E00000000001F0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000C0000000
                    0007C00000000000F8000000000000000000000000000000000000000000000000000000000000000000000000000000000000001C0000000000000000000080000000
                    000F8000000000007C00000000000000000000000000000000000000000000000000000000000000000000000000000000000000220000000000000000000040000000
                    001E0000000000003E0000000000000000000000000000000000000000000000000000000000000000000000000000000000000021000000000000000000000C000000
                    003C0000000000001F00000000000000000000000000000000000000000000000000000000000000000000000000000000000000180000000000000000000010000000
                    007C0000000000000F80000000000000000000000000000000000000000000000000000000000000000000000000000000000000060000000000200000000007C00000
                    007800000000000007C0000000000000000000000000000000000000000000000000000000000000000000000000000000000000F80000000000300000000008C00000
                    00F000000000000003C0000000000000000000000000000000000000000000000000000000000000000000000000000000000000980000000000380000000008800000
                    01E000000000000001E000180C1F81FC3FC7FFC181800000000000000000000000000000000000000000000000000000000000007000000000003C000000000F000000
                    01E000000000000000E0001C0E7FE3FE7FEFFFC3C1800000000000000000000000000000000000000000000000000000000000003000000000003C0000000000000000
                    03C000000000000000F0001C0EE07307707E1C03C180000000000000000000000000000000000000000000000000000000000001D000000000003E0000000001E00000
                    03800000000000000070001C0FC03703703E0C07E1800000000000000000000000000000000000000000000000000000000000026000000000003F0000000002C00000
                    078000FFFFE000000078001C0FC03BC0707E0C0661800000000000000000000000000000000000000000000000000000000000022000000000003F8000000001800000
                    070000FFFFF000000038001FFF8039FE7FEE0C0E71800000000000000000000000000000000000000000000000000000000000032000000000001FC000000001800000
                    0F0000FFFFF80000003C001C0FC0383F7FCE0C0FF1800000000000000000000000000000000000000000000000000000000000006000000000001FC000000001000000
                    0E0000FFFFF80000001C001C0FC03E0370060C1FF9800000000000000000000000000000000000000000000000000000000000020000000000001FE000000080000000
                    1E0000FFFFFC0000001E001C0EE0770370060C181980000000000000000000000000000000000000000000000000000000000000C000000000001FF000000700000000
                    1C0000FFFFFC0000001E001C0E79E38770060C381DFE0000000000000000000000000000000000000000000000000000000000000000000000001FF800003F00E80000
                    1C0000FCFCFC0000000E001C0E3FC1FE70060C300FFF00000000000000000000000000000000000000000000000000000000000000000000001E1FFC0001FE00A80000
                    3C00000001FC01F8000E00000000000000000000000000000000000000000000000000000000000000000000000000000000000C80000000003F1FFC0007FC00800000
                    3800000001FC03F8000F0000000000000000000000000000000000000000000000000000000000000000000000000000000000018000000000331FFE003FFC00000000
                    3800000001FC03F8000700000000000000000000001E00001E000003C00000000000000000000000000000000000000000000000000000000FF19FFF00FFF8003C0000
                    3800000001FC03F8000700000000000000000000001E00001E000003C0000000000000000000000000000000000000000000000F000000001DF19FFF87FFF0001C0000
                    7800000001FC03F8000700000000000000000000001E00001E000003C0000000000000000000000000000000000000000000000A00000001D8F19FFFFFFFF000300000
                    7800000001FC03F80007800000000000000000000000000000000003C000000000000000000000000000000000000000000000020000001FCCFF9FFFFFFFE000600000
                    7000000001FC03F80007800000000000000000000000000000000003C000000000000000000000000000000000000000000000010000007FECFF1FFFFFFFC000000000
                    7000000000F8000000078038FE1FE01FF80E0070E7DE07FC0E03FE03CFE003FC1E00380FF00C39C7F07E007FC071FC061FC00000000001FB7CC01FFFFFFFC000000000
                    70000EFFFDFDF9FBF803803FFF3FF03FFE1E0071EFDE1FFF1E0FFF03DFF80FFE1E00783FFC1EFDEFF9FF81FFF077FF077FE000100000199BFFC01FFFFFFF8000000000
                    70003FFFFFFDFFFFF803803FFFFFF87C7F1E0071FFDE3FFF1E1FFF83FCFC3F1F0F00787C7E1FF9FE7FCFC3E0F87F9F87F1F0001100007F9FFF001FFFFFFF00000C0000
                    70003FFFFFFDFFFFF803803F07E078F00F1E0071FC1E7C079E3E03C3E03C3C078F00F0F01E1F81F83F03C780787C0787C078000F0003E6CF98003FFFFFFF0000480000
                    70007FFFFFFDFFFFF803803E03C078F00F1E0071F01E78079E7C01E3C01E7803C780F1E00F1F01F01E01E780387803C780780000000F63CF8001FFFFFFFE0000500000
                    7000FFFFFFFDFFFFF803803C03C03C000F1E0071E01EF803DE7801E3C01E7001C781E1C0071E01E01E01E000387803C700780000005C63660007FFFFFFFC0000200000
                    7000FFFFFFFDFFFFF807803C03C03C003F1E0071E01EF0001E7800F3C01EF001C381E3C0079E01E01E01E000F87003C70038000003FDB360003FFFFFFFFC0000400000
                    7000FEFFFDFDF9FBF807803C03C03C3FFF1E0071E01EF0001EF000F3C01EFFFFE3C1C3FFFF9E01E01E01E0FFF87003C7003800001FBFB70000FFFFFFFFF80000380000
                    78007C0000F800000007803C03C03CFFFF1E0071E01EF0001EF000F3C01EFFFFE1C3C3FFFF9E01E01E01E3FFF87003C7003800003DB63E0007FFFFFFFFF00000240000
                    7800FE0001FC03F80007003C03C03DFE0F1E00F1E01EF0001E7800F3C01EF00001E383C0001E01E01E01E7C0387003C70038000261F7F8003FFFFFFFFFF00000300000
                    3800FE0001FC03F80007003C03C03DE00F1E00F1E01EF0039E7801F3C01EF00000E783C0001E01E01E01EF00387003C70038000F61FFC000FFFFFFFFFFF00000000000
                    3800FE0001FC03F80007003C03C03DE00F1F00F1E01EF8039E7801E3C01EF001C0E701C0071E01E01E01EF00787003C70038000FE0DE0007FFFFFFFFFFF80000700000
                    3800FE0001FC03F80007003C03C03DE01F0F01F1E01E78079E3C03E3C01E7803C0FF01E00F1E01E01E01EF00787003C70038000FF1C00007FFFFFFFFFFFC0000800000
                    3C00FE0001FC03F8000F003C03C03DF07F0F83F1E01E7E0F9E3F07C3C01E3C07807E00F81E1E01E01E01EF81F87003C700380005FFC003E07FFFFFFFFFFC0000800000
                    3C00FE0001FC03F8000E003C03C03CFFFFCFFFF1E01E3FFF1E1FFF83C01E1FFF007E007FFC1E01E01E01E7FFFE7003C700380007FE001FFE0FFFFFFFFFFE0000000000
                    1C007C0000F80000000E003C03C03C7FE7C3FE71E01E0FFC1E07FE03C01E0FFE003C003FF81E01E01E01E3FF3F7003C70038000760007FFFC0FFFFFFFFFF0000E00000
                    1E007EFCFDFC0000001E00000000001F0180F800000003F00000F800000001F0003C0007C00000000000007804000000000000060003FFFFFC1FFFFFFFFF8000080000
                    0E00FFFFFFFC0000001C000000000000000000000000000000000000000000000038000000000000000000000000000000000006001FFFFFFF81FFFFFFFF8000000000
                    0E00FFFFFFFC0000003C000000000000000000000000000000000000000000000078000000000000000000000000000000000000007FFFFFFFF81FFFFFFFC000C00000
                    0F007FFFFFFC0000003C0000000000000000000000000000000000000000000000F000000000000000000000000000000000000003FFFFFFFFFF8FFFFFFFE000000000
                    07007FFFFFFC000000780000000000000000000000000000000000000000000007F00000000000000000000000000000000000001FFFFFFFFFFFCFFFFFFFF001800000
                    07803FFFFFFC000000780000000000000000000000000000000000000000000007E0000000000000000000000000000000000000FFFFFFFFFFFFCFFFFFFFF800200000
                    03C00EFFFDFC000000F0000000000000000000000000000000000000000000000300000000000000000000000000000000000001FFFFFFFFFFFFCFFFFFFFF802200000
                    03C000000000000000F0000000000000000000000000000000000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFEFFFC7FFFC01E00000
                    01E000000000000001E0000000000000000000000000000000000000000000000000000030000000000000000000000000000001FFFFFFFFFFFFEFFFC07FFE00000000
                    00E000000000000001E0000000000000000000000000000000000000000000000000000C70000000000000000000000000000000FFFFFFFFFFFFEFFF9C0FFF00000000
                    00F000000000000003C0000000000000000000000000000000000000000000000000001CF0000000000030000000000000000000FFFFFFFFFFFFEFFF3FC1FF80000000
                    007800000000000007800000000000000000000000000000000000000000000000000038E0000000000030000000000000000000FFFFFFFFFFFFEFFF3FF81F80000000
                    003C0000000000000F000000000000000000000000000000000000000000000000000079C00000000000600000000000000000007FFFFFFFFFFFEFFE7FFF81C0000000
                    003E0000000000001F0000000000000000000000000000000000000000000000000000F3C00600000000E00000000000061000003FFFFFFFFFFFEFFCFFFFF800000000
                    001F0000000000003E0000000000000000000000000000000000000000000000000000F7800600000000C000000000000E3000003FFFFFFFFFFFEFFCFFFFFF80000000
                    000F8000000000007C0000000000000000000000000000000000000000000000000001E78004000000018000000000000F0000001FFFFFFFFFFFEFF9FFFFFFF0000000
                    0007C00000000000F800000000000000000000000000000000000000000000000000036F0000000000018000800000007E0000001FFFFFFFFFFFEFF3FFFFFFFC000000
                    0003F00000000003F00000000000000000000000000000000000000000000000000006DB0C007021C00F1C01C1C04380700000000FFFFFFFFFFFEFF3FFFFFFFC000000
                    0000F80000000007C00000000000000000000000000000000000000000000000000006D71C18F363C5DF3C01E3C5CF8030C0000007FFFFFFFFFFEFE7FFFFFFF8000000
                    00007E000000001F80000000000000000000000000000000000000000000000000000CF63431B7C6CFB66C03E6CFBD806180000007FFFFFFFFFFEFCFFFFFFFF0000000
                    00003F000000003F00000000000000000000000000000000000000000000000000000DE66C3377FCCF666C036CDFFB006180000003FFFFFFFFFFE7CFFFFFFFE0000000
                    00000FE0000001FC000000000000000000000000000000000000000000000000000019EC796F6EED9F6ED8066D9D93004700000001FFFFFFFFFFE79FFFFFFFE0000000
                    000007F8000007F8000000000000000000000000000000000000000000000000000019CCE27E6C0D9E6CD806C9B83600CF00000000FFFFFFFFFFE7BFFFFFFFC0000000
                    000001FF80007FE00000000000000000000000000000000000000000000000000000300CECF6DC0FB67CF00D9FB03E00DA000000007FFFFFFFFFE73FFFFFFF80000000
                    0000007FFFFFFF800000000000000000000000000000000000000000000000000000300CF8E7980FB676E00F8FF03F00F6000000007FFFFFFFFFE67FFFFFFF00000000
                    0000000FFFFFFC000000000000000000000000000000000000000000000000000000600C21C31004E626401E0CE0130060000000003FFFFFFFFFE4FFFFFFFE00000000
                    00000001FFFFE0000000000000000000000000000000000000000000000000000000600807800000020000180000000000000000001FFFFFFFFFE4FFFFFFFC00000000
                    0000000003F00000000000000000000000000000000000000000000000000000000000000F0000000000003000000000000000000007FFFFFFFFE1FFFFFFF800000000
                    0000000000000000000000000000000000000000000000000000000000000000000000001B0000000000003000000000000000000003FFFFFFFFE3FFFFFFF000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000360000000000006000000000000000000001FFFFFFFFE3FFFFFFE000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000260000000000006000000000000000000000FFFFFFFFE7FFFFFF8000000000
                    0000000000000000000000000000000000000000000000000000000000000000000000007C00000000000040000000000000000000003FFFFFFFFFFFFFFF0000000000
                    0000000000000000000000000000000000000000000000000000000000000000000000003800000000000040000000000000000000001FFFFFFFFFFFFFFC0000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000007FFFFFFFFFFFFF80000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000003FFFFFFFFFFFFE00000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000FFFFFFFFFFFF800000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000003FFFFFFFFFFE000000000000
                    0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000007FFFFFFFFF8000000000000
                    0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001FFFFFFFFC0000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001FFFFFFE00000000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001FFFFC000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000181E3C03E180000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001FFFFFFFFFEF800000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001FFFFFFFFFFF800000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000018000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000C0FDC0FF8EF0C2000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000081B97D28E99B1F000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000FB9D730D69D70F000
                    0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000002A090100288280000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000F8FC1F0C20413E000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001DCC0330E204137000
                    0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000018680301E206121800
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000182F83F13206121800
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001828003BF206121800
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001868021BFA06121800
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001FCFC3F61BF7F3F000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000F0FC0E403F1C3C000
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000FFFFFFFFFFFFFF800
                    000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000FFFFFFFFFFFFFF800
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
                    ^FS
            ';
    }    
    
    
    
    public function main_etiqueta_mediana_v1($ID_ATATOMIA,$DATA,$DATA_ETIQUETA,$count_main){
            $TXT_HOSPITAL                       =   'HOSPITAL DR. MAURICIO HEYERMANN';
            $SYSDATE                            =   date('d-m-Y h:m');
            $PA_ID_PROCARCH                     =   $DATA['PA_ID_PROCARCH'];  
            $NOMBRE_PACIENTE                    =   $DATA['TXTNOMCIRUSMALL'];   
            $NOMBRE_SERVICIO                    =   $DATA['NOMBRE_SERVICIO'];    
            $PROFESIONAL                        =   $DATA['PROFESIONAL']; 
            $RUT_PROFESIONAL                    =   $DATA['COD_RUTPRO'].'-0'; 
            $RUTPACIENTE                        =   $DATA['RUTPACIENTE']; 
            $NACIMIENTO                         =   $DATA['NACIMIENTO'];  
            $NUMEDAD                            =   $DATA['NUMEDAD'];  
            $FICHAL                             =   $DATA['FICHAL'];   
            $TXT_PREVISION                      =   $DATA['TXT_PREVISION'];
            //$hex                              =   $this->str2hex( $txt );
            $TXT_DIAGNOSTICO                    =   $DATA['TXT_DIAGNOSTICO']; 
            //$TXT_DIAGNOSTICO                  =   $this->str2hex($DATA['TXT_DIAGNOSTICO']);
            $ID_TABLA                           =   $DATA['ID_TABLA'];
            $TIPO_DE_BIOPSIA                    =   $DATA['TIPO_DE_BIOPSIA']; 
            $N_MUESTRA                          =   $DATA_ETIQUETA['N_MUESTRA']; 
            $ID_NMUESTRA                        =   $DATA_ETIQUETA['ID_NMUESTRA'];
            $TXT_NMUESTRA                       =   $DATA_ETIQUETA['TXT_MUESTRA'];
            //******************************************************************
            $zpl_zebra                          =   '
                ^XA
                    ^LT-25
                    ^LS25
                    ^FT750,50^ACR,18,10^FR^FH\^FDORIGEN:'.$PA_ID_PROCARCH.' - '.$SYSDATE.'^FS
                    
                    ^FX ---- SECCION SUPERIOR CON LOGO, NOMBRE Y DIRECCION
                    ^CF0,40
                    '.$this->img_gobierno_().'
                    ^FO240,50^FDANATOMIA PATOLOGICA^FS
                    ^CF0,25
                    ^FO240,90^FD'.$TXT_HOSPITAL.'^FS
                    ^FO240,115^FD'.$NOMBRE_SERVICIO.'^FS
                    ^FO240,140^FD'.$PROFESIONAL.'^FS
                    ^FO240,165^FD'.$RUT_PROFESIONAL.'^FS
                    ^FO50,220^GB650,3,3^FS

                    ^FX ---- SEGUNDA SECCION DERECHA CON LA INFORMACION DEL PACIENTE
                    ^CFA,20
                    ^FO50,230^FD'.$NOMBRE_PACIENTE.'^FS
                    ^FO50,250^FD'.$RUTPACIENTE.'^FS
                    ^FO50,270^FD'.$NACIMIENTO.' Edad:'.$NUMEDAD.' A\A5OS ^FS
                    ^FO50,290^FDFicha:'.$FICHAL.'^FS
                    ^FO50,310^FD'.$TXT_PREVISION.'^FS
                    ^FO50,330^GB650,3,3^FS

                    ^FX ---- SEGUNDA SECCION IZQUIERDA CON LA INFORMACION DE LA CIRUGIA
                    ^CFA,20
                    ^FO430,230^FD_^FD'.$TXT_DIAGNOSTICO.'^FS
                    ^FO430,250^FDFecha:'.date('d-m-Y H:m').'^FS
                    ^FO430,270^FDProtocolo:'.$ID_TABLA.'^FS
                    ^FO430,290^FDAnatomia:'.$ID_ATATOMIA.'^FS
                    ^FO430,310^FDMuestra:'.$ID_NMUESTRA.'^FS

                    ^FX Tercera seccion con codigo de barras.
                    ^BY4,2,70
                    ^FO50,350^BC^FD'.$ID_NMUESTRA.'^FS

                    ^CF0,30
                    ^FO430,355^FD'.$TIPO_DE_BIOPSIA.'^FS
                    ^CF0,30
                    ^FO430,385^FD'.$TXT_NMUESTRA.'^FS
                    ^CF0,30
                    ^FO430,415^FD'.$N_MUESTRA.'/'.$count_main.'^FS
                        
                ^XZ
            ';
        return $zpl_zebra;
    }
    
    
    /*
        ^FO500,250
        ^BQN,2,3
        ^FDhttps://www.esissan.cl/pabellon_classpdf/pdf2?id=41018&estab=106^FS
    */
    
    function hex2str( $hex ) {
        return pack('H*', $hex);
    }

    function str2hex( $str ) {
        return array_shift( unpack('H*', $str) );
    }
    
    public function img_gobierno_(){
        $img = '
                ^FO50,
                    50^GFA,3410,3410,22,FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFE7FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFE03FFFFFFFFF81FFFF8FE7FFF3FFFFFFFFFC0
                    FFFFFFFC01FFFFFFFFF81FFFF8FE7FFF3FFFFFFFFFC0
                    FFFFFFF801BFFFFFFFF8F84040C061F820FFFFFFFFC0
                    FFFFFFC0000FFFFFFFF87000408040F020FFFFFFFFC0
                    FFFFFF800007FFFFFFF8120C089E40F324FFFFFFFFC0
                    FFFFFF0000073FFFFFFE100C089E4CF320FFFFFFFFC0
                    FFFFCF0000061FFFFFFB900E089E40F320FFFFFFFFC0
                    FFFF8780000C0FFFFFF8100E188040F020FFFFFFFFC0
                    FFFF8380001811FFFFF8180E188041F020FFFFFFFFC0
                    FFFF00FC019C10FFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFC1FE001E10FFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFE0EF0018107FFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFE0C00018107FFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFF0100000007FFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFF0000000007FFFF81FCFFF9FFFFFFFFFFFFFFFC0
                    FFFFE0000000003FFFF81FCFFF9FFFFFFFFFFFFFFFC0
                    FFFFC0200000003FFFF8F04CCC1FFFFFFFFFFFFFFFC0
                    FFFF80000000003FFFF8704CC81FFFFFFFFFFFFFFFC0
                    FFFF00000000003FFFF81E4CC99FFFFFFFFFFFFFFFC0
                    FFFE00E00010003FFFFE104CC99FFFFFFFFFFFFFFFC0
                    FFFC01E08810003FFFFB904CC99FFFFFFFFFFFFFFFC0
                    FFF003E02000003FFF781044081FFFFFFFFFFFFFFFC0
                    FFF007C00000083FFFF81044081FFFFFFFFFFFFFFFC0
                    FFF007C00000083FFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFC0FC00010003FFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFE27C00010043FFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFC67E00038003FFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFF8F0F0007C003FFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFF9F8038700207FFFFC3FFFFFFFFF0FFC27FFFFFFC0
                    FFFD9E0050006C7FFFFC3FFFFFFFFF0FFC27FFCFFFC0
                    FFFD18007000447FFFF83802660020883C2618000FC0
                    FFCC00000000024FFFF81802640020883C0408000FC0
                    FF8C400184001287FFF919F2647F248F3C0409CC4FC0
                    FF1C0000000001C7FFF0198264F024803C04C9CC0FC0
                    FE1C0000000001E3FFF01982647024883C8409CC0FC0
                    FF8040700170100FFFF18982040024883C8409C00FC0
                    FFE1E03088601E1FFFF38982060024883CC419C20FC0
                    FFFBE00000001E7FFFFFFFFFFDFFFEFFFFFFFFFFFFC0
                    FFFFF7068D86FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFDFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8FFF23FF9FCFEFFFFFFFE3FC0
                    FFFFFFFFFFFFFFFFFFF83FF23FF9FCDF0FFFFFFE3FC0
                    FFFFFFFFFFFFFFFFFFF8020200801C070802400043C0
                    FFFFFFFFFFFFFFFFFFF8001000C00C860802000043C0
                    FFFFFFFFFFFFFFFFFFF8401084C80C060902180843C0
                    FFFFFFFFFFFFFFFFFFF8401004C00C060100000843C0
                    FFFFFFFFFFFFFFFFFFF8000204C00C064100400843C0
                    FFFFFFFFFFFFFFFFFFFFFE0FFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFE0FFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8423F9FFFFE3FFCFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8423F9F9FFE3FFCFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8420010002021E0C3FFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8020010000000E081FFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8020C9098060CE481FFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8020C9098060CE481FFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8120C90800600E081FFFFFFC0
                    FFFFFFFFFFFFFFFFFFF9120C90800621E0C1FFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFDFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF81F9FFCFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8179FFCFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8E09920FFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8209900FFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFC18990CFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFB00990CFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8008800FFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFF8208820FFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFC0
                    ^FS
                ';
        return $img;
    }
    
    // ******************************************
    // FINAL DE LA SOLICITUD               
    // HTML DE FORMULARIO DE ANATOMIA PATOLOGICA
    public function FORMULARIO_ANATOMIA_PATOLOGICA_V3(){
        if(!$this->input->is_ajax_request()) { show_404(); }
        $TABLA["HTML_FINAL"]                    =   $HTML;
        $this->output->set_output(json_encode($TABLA));
    }
    // ******************************************
    // FINAL DE LA SOLICITUD               
    // HTML DE FORMULARIO DE ANATOMIA PATOLOGICA
    // ******************************************
    public function FORMULARIO_ANATOMIA_PATOLOGICA_V2(){
        if(!$this->input->is_ajax_request()) { show_404(); }
        $empresa                                    =   $this->session->userdata('COD_ESTAB');
        $IND_GESPAB                                 =   $this->input->post('IND_GESPAB');
        $ZONA_PAB                                   =   $this->input->post('ZONA_PAB');
        $ID_SERDEP                                  =   $this->input->post('IND_ESPECIALIDAD'); 
        $aData                                      =   $this->ssan_libro_biopsias_usuarioext_model->main_form_anatomiapatologica(array(
                                                            "COD_EMPRESA"       =>  $empresa,
                                                            "V_CALL_FASE"       =>  0,
                                                            "V_IND_EXTERNO"     =>  0,
                                                            "V_IND_SISTEMA"     =>  0,
                                                            "PA_ID_PROCARCH"    =>  $this->input->post('PA_ID_PROCARCH'),
                                                            "IND_GESPAB"        =>  $this->input->post('IND_GESPAB'),
                                                            "ZONA_PAB"          =>  $this->input->post('ZONA_PAB'),
                                                            "IND_ADMISION"      =>  0,
                                                            "ID_SERDEP"         =>  $ID_SERDEP, 
                                                        ));
        #INFO_ROTULADO
        $array_rotulado                             =   [];
        if(count($aData["DATA_ROTULADO"])>0){
            foreach($aData["DATA_ROTULADO"]  as $i  => $fila){
                $array_rotulado[$i]                 =   array("value"=>$fila["ID_ROTULADO"],"name"=>$fila["TXT_OBSERVACION"]);
            }
        }
        #AUTOCOMPLETE
        $INSER_INTO                                 =   '';
        $data_autocomplete                          =   [];
        if($aData["DATA_AUTOCOMPLETE"]>0){
            foreach ($aData["DATA_AUTOCOMPLETE"] as $x => $row){
                #$INSER_INTO                       .=   " INSERT INTO PABELLON.PB_NMUESTRA_AUTOCOMPLETADO (ID_AUTOCOMPLETADO,TXT_CHARACTER,TXT_REALNAME,IND_ESTADO) VALUES (".$row["ID_AUTOCOMPLETADO"].",'".$row["TXT_CHARACTER"]."',".$row["TXT_REALNAME"].",1); ";
                $data_autocomplete[]                =   array("character"=>$row['TXT_CHARACTER'],"realName"=>($x+1));
            }
        }
        $html                                       =   $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/FROM_APATOLOGICA_EXT",array(
            "COD_ESTAB"                             =>  $this->session->userdata("COD_ESTAB"),//
            //PACIENTE
            "NUM_FICHAE"                            =>  $this->input->post('NUM_FICHAE'),//
            "RUT_PACIENTE"                          =>  $this->input->post('RUT_PACIENTE'),//
            //PROFESIONAL
            "ID_MEDICO"                             =>  $this->input->post('ID_MEDICO'),
            "RUT_MEDICO"                            =>  $this->input->post('RUT_MEDICO'),
            //INFO SOLICITUD
            "IND_TIPO_BIOPSIA"                      =>  $this->input->post('IND_TIPO_BIOPSIA'),
            "TXT_TIPO_BIOPSIA"                      =>  $this->input->post('TXT_BIOPSIA'),
            "IND_ESPECIALIDAD"                      =>  $this->input->post('IND_ESPECIALIDAD'),
            "PA_ID_PROCARCH"                        =>  $this->input->post('PA_ID_PROCARCH'),//
            "AD_ID_ADMISION"                        =>  null,
            "IND_FRAME"                             =>  0,
            "CALL_FROM"                             =>  $this->input->post('CALL_FROM'),
            //GESPAB
            "ID_GESPAB"                             =>  $this->input->post('ID_GESPAB'),
            //DATA
            "DATA"                                  =>  null,
            //ZONA DE ROTULADO
            "ZONA_PABELLON"                         =>  $ZONA_PAB,
            "ARRAY_ROTULADO"                        =>  $array_rotulado,
            "ARRAY_AUTOCOMPLETE"                    =>  array("NOMBRE_ANATOMIA"=>$data_autocomplete),
            //DATA GENERAL BASE DE DATOS 
            "ARRAY_BD"                              =>  $aData,
        ),true);
        $this->output->set_output(json_encode(array(
            'HTML_FINAL'                            =>  $html,
            'ARRAY_BD'                              =>  $aData,
            'ID_SERDEP'                             =>  $ID_SERDEP,  
            'array_rotulado'                        =>  $array_rotulado,
            'INSER_INTO'                            =>  $INSER_INTO,
        )));
    }
    
    #FUNCION QUE GRABA LA SOLICITUD 
    public function RECORD_ANATOMIA_PATOLOGICA_EXT(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $contrasena                     =   $this->input->post('contrasena');
        $accesdata                      =   $this->input->post('accesdata');
        $session_arr                    =   explode("-",$this->session->userdata('USERNAME'));
	    $session                        =   $session_arr[0];
        $return                         =   $this->ssan_libro_biopsias_usuarioext_model->MODEL_RECORD_ANATOMIA_PATOLOGICA_EXT($session,$accesdata);
        $TABLA["STATUS"]                =   $return["STATUS"];
        $TABLA["ID_ANATOMIA"]           =   $return["ID_ANATOMIA"];
        $TABLA["MODEL_RETURN"]          =   $return;
        $TABLA["GET_FRAME"]             =   false;
        $TABLA["VIEWS_PDF"]             =   false;
        $this->output->set_output(json_encode($TABLA));
    }
   
    #BLOB PDF DE ANATOMIA PATOLOGICA EXTERNO
    public function BLOB_PDF_ANATOMIA_PATOLOGICA(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        #$id_tabla                      =   821;
        $HTML_BIOPSIAS                  =   '';
        $HTML_CITOLOGIA                 =   '';
        $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        $DATA_FIRST                     =   false;
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf                   =   'SOLICITUD DE ANATOMIA.pdf';
        $dompdf                         =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        #firma digital
        $rutUsuario                     =   explode("-",$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['RUT_PROFESIOAL']);
        $codeContents                   =   'https://www.esissan.cl/validador?p=' . $this->validaciones->encodeNumber($rutUsuario[0] . '&' . $empresa);
        #firma digital
        $rutUsuario                     =   explode("-",$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['RUT_PROFESIOAL']);
        $rutProfesional                 =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['RUT_PROFESIOAL'];
        $profesional                    =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['PROFESIONAL'];
        $profesion                      =   '-';

        $html_firma                     =   '<table>
                                                <tr>
                                                    <td valign="top">
                                                        <barcode class="barcode" code="'.$codeContents.'" type="QR" height="0" text="1" size="1"/>
                                                    </td>
                                                    <td valign="top">
                                                        <br>
                                                        <b>FIRMADO DIGITALMENTE</b>
                                                        <p style="margin-top:20px;display: inline-block;">' . strtoupper($rutProfesional) . '</p>
                                                        <p style="margin-bottom:0px;display: inline-block;">' . strtoupper($profesional) . '</p>
                                                        <p style="margin-bottom:0px;display: inline-block;">' . strtoupper($profesion) . '</p>
                                                    </td>
                                                </tr>
                                            </table>';


        if(count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"][0])>0){
            $DATA_FIRST                 =   true;
            $HTML_BIOPSIAS              =   $this->load->view("ssan_spab_coordepabellonenfe_new/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS",array('DATA'=>$DATA,'FIRMA'=>$html_firma),true);
            $dompdf->WriteHTML($HTML_BIOPSIAS);
            $dompdf->SetHTMLFooter('SOLICITUD DE ANATOMIA PATOLOGICA - M.ANATOMICA');
        }
        if(count($DATA["P_AP_MUESTRAS_CITOLOGIA"][0])>0){
            $dompdf->AddPage();
            $HTML_CITOLOGIA             =   $this->load->view("ssan_spab_coordepabellonenfe_new/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS_CITO",array('DATA'=>$DATA,'FIRMA'=>$html_firma),true);
            $dompdf->WriteHTML($HTML_CITOLOGIA);
            $dompdf->SetHTMLFooter('SOLICITUD DE ANATOMIA PATOLOGICA - M.CITOLOGIA');
        }
        $base64_pdf                     =   base64_encode($dompdf->Output($txt_name_pdf,'S'));
        #$TABLA["codeContents"]          =   $html_firma;
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $TABLA["HTML_BIOPSIAS"]         =   $HTML_BIOPSIAS;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function etiqueta_main(){
        $text                           =   $this->input->get("text");
        $OPTION                         =   array(
                                                    'text'              =>  $text,
                                                    'barHeight'         =>  "60", 
                                                    'withQuietZones'    =>  false,
                                                    'drawText'          =>  false,//oculta numero
                                                    'stretchText'       =>  true,
                                                );
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $this->output->set_output(Zend_Barcode::render('code128','image',$OPTION,array()));
    }
    
    #PDF RECEPCION ANATOMIA
    public function pdf_recepcion_anatomia_pat_ok(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        //$DATA                         =   null;
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf                   =   'RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA:'.$id_tabla.'.pdf';
        //$dompdf                       =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        #verical 
        $partes                         =   explode("#", $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_USER_TRASPORTE_FIRMA']);
        $subPartes                      =   explode("-", $partes[1]);
        $cod_functionario_entrega       =   $this->validaciones->encodeNumber($subPartes[0].'&'.$empresa);
        $partes2                        =   explode("#", $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_USER_RECPCIONA_FIRMA']);
        $subPartes2                     =   explode("-", $partes2[1]);
        $cod_functionario_recibe        =   $this->validaciones->encodeNumber($subPartes2[0].'&'.$empresa);
        #horizontal
        $dompdf                         =   new mPDF("en-GB-x","Letter-L","","",10,10,10,10,6,3);
        $dompdf->AddPage();
        #$dompdf->WriteHTML($this->load->view("ssan_libro_biopsias_listagespab/pdf_recepcion_conforme",array('DATA'=>$DATA,"empresa"=>$empresa),true));
        $html                           =   $this->load->view("ssan_libro_biopsias_listagespab/pdf_recepcion_conforme_v2",array(
            "DATA"                      =>  $DATA,
            "empresa"                   =>  $empresa,
            "cod_functionario_entrega"  =>  $cod_functionario_entrega,
            "cod_functionario_recibe"   =>  $cod_functionario_recibe
        ),true);
        $dompdf->WriteHTML($html);
        $dompdf->SetHTMLFooter('RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA');
        $out                            =   $dompdf->Output($txt_name_pdf,'S');
        $base64_pdf                     =   base64_encode($out);
        /*
        #$userEmail                     =   'benjamin.castillo@araucanianorte.cl'; 
        $userEmail                      =   'benjamin.castillo03@gmail.com'; 
        $subject                        =   'NUEVA RECEPCION';
        $config                         =   array(
                                                'protocol'          =>  'sendmail',
                                                'smtp_host'         =>  'your domain SMTP host',
                                                'smtp_port'         =>  25,
                                                'smtp_user'         =>  'SMTP Username',
                                                'smtp_pass'         =>  'SMTP Password',
                                                'smtp_timeout'      =>  '4',
                                                'mailtype'          =>  'html',
                                                'charset'           =>  'iso-8859-1'
                                            );
        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        $this->email->from('noresponder@araucanianorte.cl','SISTEMA DE ANATOM&Iacute;A PATOL&Oacute;GICA - NUEVA RECEPCI&Oacute;N');//no borrar (correo remitente)
        $data                           =   array( 
                                                'NUM_INFORME'       =>   'NUM_INFORME',
                                                'PERIODO'           =>   'PERIODO',
                                                'TIPO_INFORME'      =>   'TIPO_INFORME'
                                            );
        $this->email->to($userEmail);
        $this->email->subject($subject); // replace it with relevant subject 
        $body                           =   $this->load->view('ssan_libro_biopsias_ii_fase/email_notificacion.php',$data,TRUE);
        $this->email->message($body);
        #$this->email->attach($dompdf->Output($txt_name_pdf,'S'));
        $this->email->attach($out,'attachment','RECEPCION ANATOMIA - '.$id_tabla.'.pdf','application/pdf');
        $this->email->send();
        */
        $TABLA["HTML"]                  =   $html;
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $this->output->set_output(json_encode($TABLA));
    }
    
    #PDF RECEPCION ANATOMIA
    public function pdf_recepcion_anatomia_pat_ok_old(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        //$DATA                         =   null;
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf                   =   'RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA:'.$id_tabla.'.pdf';
        #verical 
        //$dompdf                       =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        #horizontal
        $dompdf                         =   new mPDF("en-GB-x","Letter-L","","",10,10,10,10,6,3);
        $dompdf->AddPage();
        $dompdf->WriteHTML($this->load->view("ssan_libro_biopsias_listagespab/pdf_recepcion_conforme",array('DATA'=>$DATA,"empresa"=>$empresa),true));
        $dompdf->SetHTMLFooter('RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA');
        $out                            =   $dompdf->Output($txt_name_pdf,'S');
        $base64_pdf                     =   base64_encode($out);
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $this->output->set_output(json_encode($TABLA));
    }

    #pdf rechazo 
    #from usuario ext |  
    public function pdf_informerechazo_ap(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        #$id_tabla                      =   2410;
        #$DATA                          =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->load_info_rechazo(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        #$DATA                          =   null;
        #$DATA_FIRST                    =   false;
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf                   =   'RECHAZO ANATOMIA PATOLOGIA '.$id_tabla.' .pdf';
        $dompdf                         =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        $dompdf->AddPage();
        $dompdf->WriteHTML($this->load->view("ssan_libro_biopsias_listagespab/pdf_informerechazo",array('DATA'=>$DATA,"empresa"=>$empresa),true));
        $dompdf->SetHTMLFooter('RECHAZO ILEGIBILIDAD DE BIOPSIA');
        $base64_pdf                     =   base64_encode($dompdf->Output($txt_name_pdf,'S'));
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function BLOB_PDF_ANATOMIA_PATOLOGICA_ETIQUETAS(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        //$id_tabla                     =   2410;
        $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        $DATA_FIRST                     =   false;
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf                   =   'SOLICITUD DE ANATOMIA.pdf';
        $dompdf                         =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        if(count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"][0])>0){
            $DATA_FIRST                 =   true;
            $dompdf->WriteHTML($this->load->view("ssan_spab_coordepabellonenfe_new/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS",array('DATA'=>$DATA),true));
            $dompdf->SetHTMLFooter('SOLICITUD DE ANATOMIA PATOLOGICA CITOLOGIA EDITADA');
        }
        if(count($DATA["P_AP_MUESTRAS_CITOLOGIA"][0])>0){
            $dompdf->AddPage();
            $dompdf->WriteHTML($this->load->view("ssan_spab_coordepabellonenfe_new/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS_CITO",array('DATA'=>$DATA),true));
            $dompdf->SetHTMLFooter('SOLICITUD DE ANATOMIA PATOLOGICA CITOLOGIA');
        }
        $base64_pdf                     =   base64_encode($dompdf->Output($txt_name_pdf,'S'));
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $this->output->set_output(json_encode($TABLA));
    }
    
    // *************************************************************************
    // PEPARACION DE SOLICITUD : NUEVO PASE QUIRUGICO 
    // PACIENTE + SERVICIO + FORMULARIO + GET = PDF  
    // MODAL 50%
    // *************************************************************************
    public function le_nueva_solicitud(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        //error_log("----------------------------------------------------------------------");
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $session_arr                    =   explode("-",$this->session->userdata('USERNAME'));
	$session                        =   $session_arr[0];
        $ADMISION                       =   $this->input->post('ADMISION');
        $NUM_FICHAE                     =   $this->input->post('NUM_FICHAE');
        $DATA_CURSOR                    =   $this->ssan_libro_biopsias_usuarioext_model->DATA_PRE_NUEVASOLICIUD_ANATOMIA(
                array(
                "COD_EMPRESA"           =>  $empresa,
                "USR_SESSION"           =>  $session,
                "DATE_FROM"             =>  date("d-m-Y"),
                "DATE_TO"               =>  date("d-m-Y"),
            )
        );
        $TABLA["DATA_INFO"]             =   $DATA_CURSOR;
        $TABLA["GET_HTML"]              =   $this->load->view("ssan_spab_gestionlistaquirurgica/PDFS/FORMULARIOS_HTML/HTML_NUEVASOLICITUD_PACIENTE",$DATA_CURSOR,true);
        $TABLA["SALIDA_DIRECTA"]        =   true;
        $this->output->set_output(json_encode($TABLA));
    }
    
    //**************************************************************************
    // FINAL DE LA SOLICITUD               
    // HTML DE FORMULARIO DE ANATOMIA PATOLOGICA
    public function ETAPA_2_GESTIONPASE(){
        if(!$this->input->is_ajax_request()) { show_404(); }
        $empresa                            =   $this->session->userdata("COD_ESTAB");
        $INFO_ASA                           =   $this->input->post('INFO_ASA');
        $NUM_FICHAE                         =   $this->input->post('NUM_FICHAE');
        $RUT_PACIENTE                       =   $this->input->post('RUT_PACIENTE');
        $IND_ESPECIALIDAD                   =   $this->input->post('IND_ESPECIALIDAD');
        $ID_UNICO_ESPECIALIDAD              =   $this->input->post('ID_UNICO_ESPECIALIDAD');
        $COD_MEDICO                         =   $this->input->post('COD_MEDICO'); 
        $IND_UNIDAD                         =   $this->input->post('IND_UNIDAD'); 
        $IND_IFRAME                         =   1;
        if($INFO_ASA == 1 || $INFO_ASA == 2){
            $TABLA["HTML_FINAL"]            =   $this->load->view("ssan_spab_gestionlistaquirurgica/PDFS/FORMULARIOS_HTML/HTML_SOLICITUDPASE",array(
                //INFO SOLICIUD
                "INFO_ASA"                  =>  $INFO_ASA,
                "IND_ESPECIALIDAD"          =>  $IND_ESPECIALIDAD,
                "IND_UNIDAD"                =>  $IND_UNIDAD,
                //PACIENTE
                "NUM_FICHAE"                =>  $NUM_FICHAE,
                "RUT_PACIENTE"              =>  $RUT_PACIENTE,
                //PROFESIONAL
                "COD_MEDICO"                =>  $COD_MEDICO,
                //EMPRESA SOLICITUD
                "COD_EMPRESA"               =>  $empresa,
                "CALL_FROM"                 =>  0,
                "ID_UNICO_ESPECIALIDAD"     =>  $ID_UNICO_ESPECIALIDAD,
                "NUM_CORREL"                =>  $this->input->post('NUM_CORREL'),
                "COD_EMPRESA_RCE"           =>  $this->input->post('COD_EMPRESA_RCE'),  
                "PA_ID_PROCARCH"            =>  $this->input->post('PA_ID_PROCARCH'),  
            ),true);
        } else {
            //**************** FALTA CODIFICACION RUTA 2 ***********************
            if ($IND_IFRAME == 1){
                //CREACION DE IC PARA CONFIRMACION DIAGNOSTICA     
                //$RUTA                     =   "https://www.esissan.cl/ssan_crearinterconsulta_iframe?rutPac=14333726&menu=3&establ=029&rutprof=18643863&fundiadiag=&codespeci=";
                $RUTA                       =   "https://10.5.183.210/ssan_crearinterconsulta_iframe?rutPac=".$RUT_PACIENTE."&menu=3&establ=".$empresa."&rutprof=".$COD_MEDICO."&fundiadiag=&codespeci=".$IND_ESPECIALIDAD;
                $IFRAME                     =   '<iframe src="'.$RUTA.'" frameborder="0" style="overflow:hidden;height:650px;width:100%;"></iframe>';
            } else {
                //CREACION IC PARA INTERVENCION QUIRURGICA
                //$RUTA                     =   "https://www.esissan.cl/ssan_crearinterconsulta_iframe?rutPac=14333726&menu=4&establ=029&rutprof=18643863&fundiadiag=&codespeci=";
                $RUTA                       =   "https://10.5.183.210/ssan_crearinterconsulta_iframe?rutPac=".$RUT_PACIENTE."&menu=4&establ=".$empresa."&rutprof=".$COD_MEDICO."&fundiadiag=&codespeci=".$IND_ESPECIALIDAD;
                $IFRAME                     =   '<iframe src="'.$RUTA.'" frameborder="0" style="overflow:hidden;height:650px;width:100%;"></iframe>';
            }
            $TABLA["HTML_FINAL"]            =   $IFRAME;
        }
        $this->output->set_output(json_encode($TABLA));
    }
    
    //
    public function ETAPA_3_GESTIONPASE(){
        if(!$this->input->is_ajax_request()) { show_404(); }
        //NOM_GRUPO
        $ID_PASEQUIRUGICO               =   $this->input->post('ID_PASE');
        $RUT_PACIENTE                   =   $this->input->post('COD_RUTPAC');
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $COD_MEDICO                     =   $this->input->post('COD_MEDICO');
        $IND_ESPECIALIDAD               =   $this->input->post('IND_SERVICIO');
        $RUTA                           =   "https://10.5.183.210/ssan_crearinterconsulta_iframe?rutPac=".$RUT_PACIENTE."&menu=4&establ=".$empresa."&rutprof=".$COD_MEDICO."&fundiadiag=&codespeci=".$IND_ESPECIALIDAD;
        $IFRAME                         =   '<iframe src="'.$RUTA.'" frameborder="0" style="overflow:hidden;height:650px;width:100%;"></iframe>';
        $TABLA["DATA_1"]                =   $this->input->post('DATA_SOL');
        $TABLA["DATA_2"]                =   $this->input->post('DATA_SOL2');
        $TABLA["HTML_FINAL"]            =   $IFRAME;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function recarga_html_listae(){
        if(!$this->input->is_ajax_request()) { show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $fecha                          =   $this->input->post('fecha');
        
        $idtabs                         =   $this->input->post('idtabs');
        $value                          =   $this->input->post('value');
        $responde                       =   $this->ssan_spab_gestionlistaquirurgica_model->CARGA_LISTA_PASESQUIRUGICO(
            array(
                "COD_EMPRESA"           =>  $empresa,
                "DATE_FROM"             =>  $fecha,
                "DATE_TO"               =>  $fecha,
            )
        );
        $TABLA["DATE_FROM"]             =   $fecha;
        $TABLA["DATE_TO"]               =   $fecha;
        $TABLA["HTML_LISTAS"]           =   $responde;
        $this->output->set_output(json_encode($TABLA));
    }
    
    
    #LABURANDO
    public function le_pasaapendiente(){
        if (!$this->input->is_ajax_request()) { show_404(); }
        $empresa                    =   $this->session->userdata("COD_ESTAB");
        $ID_PASEQX                  =   $this->input->post('ID_PASEQX');
        $DATA_PAC                   =   $this->input->post('DATA_PAC');
        $TABLA["RECUPERA"]          =   $DATA_PAC;
        $TABLA["GET_HTML"]          =   $this->load->view("ssan_spab_gestionlistaquirurgica/PDFS/FORMULARIOS_HTML/HTML_PASEAPENDIENTES",$DATA_PAC,true);
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function nuevo_pasequirugico(){
        if (!$this->input->is_ajax_request()) { show_404(); }
        $empresa                    =   $this->session->userdata("COD_ESTAB");
        $password                   =   $this->input->post('contrasena');
        $FORM_CODIGO                =   $this->input->post('FORM_CODIGO');
        $valida                     =   $this->ssan_spab_gestionlistaquirurgica_model->validaClave($password);
        $txt_error                  =   '';
        $return                     =   '';
        $ID_PASE                    =   '';
        //*********************************************************************
        if($valida){
            $usuarioh               =   explode("-",$valida->USERNAME); //rut del user  
            $session                =   $usuarioh[0];
            $responde               =   $this->ssan_spab_gestionlistaquirurgica_model->GRB_NUEVO_PASEQUIRUGICO($empresa,$session,$FORM_CODIGO);
            $txt_error              =   'Solicitud de pase quirúrgico Creado';
            $return                 =   $responde["STATUS"];
            $ID_PASE                =   $responde["ID_PASE"];
        } else {
            $txt_error              =   'Error en firma simple';
            $return                 =   false;
        }
        //**********************************************************************
        $TABLA["ID_PASE"]           =  $ID_PASE;
        $TABLA["TXT_ERROR"]         =  $txt_error;
        $TABLA["STATUS"]            =  $return;
        $TABLA["SALIDA_DIRECTA"]    =  true;
        //**********************************************************************
        $this->output->set_output(json_encode($TABLA));
    }

    public function salida_clob(){
        $return_data                =   $this->ssan_spab_gestionlistaquirurgica_model->get_lista_clob();
        $RETURN["img"]              =   $return_data[":RETURN_CURSOR"];
        $this->output->set_output(json_encode($RETURN));
    }
    
    public function PDF_PASEQUIRUGICO() {
       if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                    =   $this->session->userdata("COD_ESTAB");
        $id                         =   $this->input->post('id');
        $IND_TEMPLATE               =   $this->input->post('IND_TEMPLATE'); 
        $DATA                       =   $this->ssan_spab_gestionlistaquirurgica_model->DATA_PDF_PASEQUIRUGICO(
            array(
                "COD_EMPRESA"       =>  $empresa,
                "ID"                =>  $id,
            )
        );
        require_once APPPATH        .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf               =   '_.pdf';
        $dompdf                     =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        $HTML_VIEW                  =   $this->load->view("ssan_spab_gestionlistaquirurgica/PDFS/PDF_TEMPLATE_PASEQUIRUGICO",$DATA,true);
        $dompdf->WriteHTML($HTML_VIEW);
        $dompdf->SetHTMLFooter('INSCRIPCI&Oacute;N LISTA DE ESPERA QUIR&Uacute;RGICA');
        /*
        $dompdf->AddPage();
        $dompdf->WriteHTML($this->load->view("ssan_spab_gestionlistaquirurgica/PDFS/PDF_TEMPLATE_IPD",$DATA,true));
        $dompdf->SetHTMLFooter('SOLICITUD DE INFORE IPD');
        */
        $base64_pdf                 =   base64_encode($dompdf->Output($txt_name_pdf,'S'));
        $TABLA["PDF_MODEL"]         =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]    =   $base64_pdf;
        $TABLA["HTML_VIEW"]         =   $HTML_VIEW;
        $TABLA["STATUS"]            =   true;
        $TABLA["RETURN_DATA"]       =   $DATA;
        $TABLA["ID_POST"]           =   $id;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function new_gestiondeimagenes_fetch_json(){
        error_log("---------------------".date("d-m-Y H:i:s")."-------------------------");
        $return_data = $this->ssan_spab_gestionlistaquirurgica_model->getSQLPrueba();
        //print_r($_FILES);
        //$TABLA[] = array("id_html" => "",     "opcion" => "console" , "contenido"  => null);     
        //$TABLA[] = array("id_html" => "",     "opcion" => "console" , "contenido"  => file_get_contents($_FILES["inpFile"]["tmp_name"])); 
        $RETURN["img"] =  file_get_contents($_FILES["inpFile"]["tmp_name"]);
        $this->output->set_output(json_encode($RETURN));
    }
    
    public function new_gestiondeimagenes_ajax(){
        error_log("---------------------".date("d-m-Y H:i:s")."-------------------------");
        $return_data = $this->ssan_spab_gestionlistaquirurgica_model->getSQLPrueba();
        // $return_data = $this->ssan_spab_gestionlistaquirurgica_model->getSQLPrueba2();
        //print_r(var_dump($_FILES["inpFile"]["tmp_name"]));
        //$file = file_get_contents($_FILES["inpFile"]["tmp_name"]);
        //print_r($_POST);
        $TABLA[] = array("id_html" => "",     "opcion" => "console" , "contenido"  => "hola");     
        //$TABLA[] = array("id_html" => "",     "opcion" => "console" , "contenido"  => file_get_contents($_FILES["inpFile"]["tmp_name"])); 
        $this->output->set_output(json_encode($TABLA));
    }
    
    
    public function new_gestiondeimagenes_fetch(){
        error_log("---------------------".date("d-m-Y H:i:s")."-------------------------");
        $return_data        =   $this->ssan_spab_gestionlistaquirurgica_model->getSQLPrueba();
        //$return_data      =   $this->ssan_spab_gestionlistaquirurgica_model->getSQLPrueba2();
        //print_r(var_dump($_FILES));
        //$file             =   file_get_contents($_FILES["inpFile"]["tmp_name"]);
        //print_r($_FILES["inpFile"]["tmp_name"]);
        $TABLA[]            =   array("id_html" => "",     "opcion" => "console" , "contenido"  => $return_data);     
        //$TABLA[]          =   array("id_html" => "",     "opcion" => "console" , "contenido"  => file_get_contents($_FILES["inpFile"]["tmp_name"])); 
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function gestiondeimagenes(){
        $date = date("d-m-Y H:i:s");
        error_log("---------------------".$date."-------------------------");
        $return_data = $this->ssan_spab_gestionlistaquirurgica_model->getSQLPrueba();
        //print_r(var_dump($_FILES));
        //$file = file_get_contents($_FILES["inpFile"]["tmp_name"]);
        //print_r($file);
        $TABLA[] = array("id_html" => "",     "opcion" => "console" , "contenido"  => "#");         
        $this->output->set_output(json_encode($TABLA));
    }
   
    public function GestionEspecialidadesAsignadas() {
        if (!$this->input->is_ajax_request()) { show_404(); }
        $usuarioh      = explode("-", $_SESSION['USERNAME']); //rut del usuario        
        $session       = $usuarioh[0];
        $empresa       = $this->session->userdata('COD_ESTAB');
        $listado       = $this->institucionales_model->getListasInstitucionales($empresa,$session);
        $especialidades = $this->institucionales_model->sqlespecialidadesiq();
        foreach ($especialidades as &$pre){
        $TABLA[] = array("id_html" => "especialidad",     "opcion" => "append" , "contenido"  => '<option value="'.$pre["VALUE"].'">'.$pre["OPCION"].'</option>');         
        }
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function FORMULARIO_PASEQUIRUGICO(){
        if (!$this->input->is_ajax_request()) { show_404(); }
        $TABLA["PDF_MODEL"] = 'SIN INFORMACION';
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function busquedaPreListadeEspera(){
        if (!$this->input->is_ajax_request()) { show_404(); }
            $empresa        = $this->session->userdata('COD_ESTAB');
            $especialidad   = $this->input->post('especialidad');
            $listado        = $this->institucionales_model->busquedaListaPreInterconsulta($empresa,$especialidad);
            $html           = '';
            $DATA           = '';
            if (count($listado)>0){
            foreach ($listado as $i => $l){
                $html = '';
                $DATA.= '<b>ESPECIALIDAD :</b>'.$l["NOM_ESPECIALIDAD"]."<br>";
                $DATA.= '<b>EDAD :</b>'.$l["CAMPO5"]."<br>";
                $DATA.= '<b>AUGE :</b>'.$l["CAMPO8"]."<br>";
                $DATA.= '<b>NSP :</b>'.$l["CUENTA_NSP"]."<br>";
                $DATA.= '<b>ESTABLECIMIENTO :</b>'.$l["ESTABLOR"]."<br>";
                $DATA.= '<b>DIAS DE ESPERA :</b>'.$l["DIASESPERA"]."<br>";
                $DATA.= '<b>CIE10 :</b>'.$l["CAMPO9"]."<br>";
                $DATA.= '<b>RESOLICION :</b>'.$l["CAMPO15"]."<br>";
                $DATA.= '<b>COD. IQ :</b>'.$l["CODIGOIQ"]."<br>";
                $DATA.= '<b>MOTIVO. IQ :</b>'.$l["MOTIVOIQ"]."<br>";
                
                $html.='<tr class="formulario" id="tr_'.$l["CAMPO1"].'">';
                    $html.='<td>'.$l['CAMPO18'].'</td>';
                    $html.='<td>'.$l['CAMPO2'].'-'.$l['CAMPO3'].'</td>';
                    $html.='<td>'.$l['CAMPO6'].'</td>';
                    $html.='<td>'.$l['TIPOINTERVENCION'].'</td>';
                    $html.='<td style="text-align:center">'
                            . '<div style="text-aling:center">'
                                . "<a href='#' id='examplepopover_".$l["CAMPO1"]."' onClick='buscaIC(this.id)'; title='<b>INFO. DE INTERCONSULTA</b>' data-toggle='popover' data-placement='left' data-content='$DATA'><i class='fa fa-info fa-3x'></i></a>"
                            . '</div> '
                        . '</td>';
                    $html.='<td>';
                    $html.='<div class="dropdown">
                       <button class="btn btn-primary dropdown-toggle btn-xs" style="width:120px;height:35px;" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fa fa-cog"></i> <span style="font-size: 10px">Seleccione</span>
                         <span class="caret"></span>
                       </button>
                       <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                          <li><a href="#" onclick="confirma('.$l["CAMPO1"].','.$l["CAMPO19"].')"   ><i class="fa fa-cog"></i> CONFIRMAR</a></li>
                          <li><a href="#" onclick="cancela('.$l["CAMPO1"].')"><i class="fa fa-cog" ></i> RECHAZAR</a></li>
                       </ul>
                     </div>';
                $html.='</td></tr>';        
                $TABLA[] = array("id_html" => "listaEspecialidad", "opcion" => "append", "contenido"  => $html);
                $DATA='';
            }
        } else {
        $TABLA[] = array("id_html" => "listaEspecialidad",     "opcion" => "append" , "contenido"  => '<tr class="formulario"><td   colspan="6" style="text-align:center">SIN INFORMACION</tr></td>');     
        }
        $this->output->set_output(json_encode($TABLA));
    }
    
    
    public function informacionIC(){
        if (!$this->input->is_ajax_request()) { show_404(); }
        $empresa       = $this->session->userdata('COD_ESTAB');
        $ic            = $this->input->post('especialidad');
        $info          = $this->institucionales_model->buscainfoIC($empresa,$ic);
        $data          = '';
        if (count($info)>0){
            $data ='CON INFORMACION';
        } else {
            $data ='SIN INFORMACION';
        }
        $this->output->set_output($data);
    }
    
    public function guardaICxListaesperaIQ(){
            if (!$this->input->is_ajax_request()) { show_404(); }
            $empresa           = $this->session->userdata('COD_ESTAB');
            $ic                 = $this->input->post('IC');
            $NFICHA             = $this->input->post('NFICHA');
            $txt_bitacora       = $this->input->post('txt_bitacora');
            $CLAVE              = $this->input->post('CLAVE');
            $valida            = $this->institucionales_model->validaClave($CLAVE);
          if ($valida){
                $rut            = $valida->USERNAME;
                $rutm           = explode("-", $rut);
                $rutUs          = $rutm[0];
                $nombre         = $valida->NAME . ' ' . $valida->MIDDLE_NAME . ' ' . $valida->LAST_NAME;
                $return         = $this->institucionales_model->pasaAlistadeEsperaMasBitacora($ic,$txt_bitacora,$rutUs,$empresa,$NFICHA);
                if ($return) {
                   $datos[]     = array("id_html" => "",        "opcion" => "jAlert",      "contenido"  => "La interconsulta N&deg;<b>".$ic."</b> Ha pasado a lista de espera quirúrgica");
                   $datos[]     = array("id_html" => "",        "opcion" => "dialogClose", "contenido"  => "CONFIMAR");  
                   $datos[]     = array("id_html" => "tr_".$ic, "opcion" => "remove",      "contenido"  => "");  
                } else {
                   $datos[]     = array("id_html" => "", "opcion" => "jAlert", "contenido"  => "Error - Confirmar con administrador");  
                } 
          } else {
                   $datos[]     = array("id_html" => "", "opcion" => "jAlert", "contenido"  => " Firma Incorrecta", "Restricci\u00f3n");   
          }
          $this->output->set_output(json_encode($datos));
    }
    
    public function mejor_jefe_del_mundo(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        
    $html='
    ^XA
^XA ^FO0,0^GFA,45962,45962,98, 0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000000000007F000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000007FC000000000000000000FF800000000000
000000000000000000000000000000000000000000000000000007FFFFE000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001FFE00000000000000003FFFFF8000000000
000003FFF00000000007FFC000000000FFFC00000000000000007FFFFFFE0000000000000000000FFFFFFFFF0000000000000000007FFC00000000000000000003FFFFFFFFF0000000000000000000001FFF0000000000000003FFFFFFF800000000
000003FFF8000000000FFFC000000000FFFE0000000000000003FFFFFFFFC000000000000000001FFFFFFFFFF00000000000000000FFFE00000000000000000003FFFFFFFFFF800000000000000000003FFF000000000000001FFFFFFFFF00000000
000003FFF8000000000FFFE000000001FFFE000000000000000FFFFFFFFFF000000000000000001FFFFFFFFFFC0000000000000000FFFE00000000000000000003FFFFFFFFFFF80000000000000000003FFE000000000000007FFFFFFFFF80000000
000003FFFC000000000FFFE000000001FFFE000000000000003FFFFFFFFFFC00000000000000001FFFFFFFFFFF8000000000000000FFFE00000000000000000003FFFFFFFFFFFF0000000000000000003FFE00000000000001FFFFFFFFFF80000000
000003FFFC000000001FFFE000000001FFFC00000000000000FFFFFFFFFFFF00000000000000001FFFFFFFFFFFC000000000000000FFFE00000000000000000003FFFFFFFFFFFFE000000000000000003FFE00000000000007FFFFFFFFFF80000000
000001FFFC000000001FFFE000000001FFFC00000000000001FFFFFFFFFFFF80000000000000001FFFFFFFFFFFF000000000000000FFFE00000000000000000003FFFFFFFFFFFFF800000000000000007FFC0000000000000FFFFFFFFFFF80000000
000001FFFE000000001FFFF000000003FFFC00000000000007FFFFFFFFFFFFE0000000000000001FFFFFFFFFFFF800000000000000FFFE00000000000000000003FFFFFFFFFFFFFE00000000000000007FFC0000000000001FFFFFFFFFFF80000000
000001FFFE000000001FFFF000000003FFF80000000000000FFFFFFFFFFFFFF0000000000000001FFFFFFFFFFFFC00000000000000FFFE00000000000000000003FFFFFFFFFFFFFF80000000000000007FFC0000000000007FFFFFFFFFFF80000000
000000FFFE000000003FFFF000000003FFF80000000000001FFFFFFFFFFFFFF8000000000000001FFFFFFFFFFFFE00000000000000FFFE00000000000000000003FFFFFFFFFFFFFFC0000000000000007FF8000000000000FFFFFFFFFFFF80000000
000000FFFE000000003FFFF800000003FFF80000000000003FFFFFFFFFFFFFFC000000000000001FFFFFFFFFFFFF00000000000000FFFE00000000000000000003FFFFFFFFFFFFFFE000000000000000FFF8000000000000FFFFFFFFFFFF80000000
000000FFFF000000003FFFF800000007FFF8000000000000FFFFFFFFFFFFFFFE000000000000001FFFFFFFFFFFFF80000000000000FFFE00000000000000000003FFFFFFFFFFFFFFF800000000000000FFF8000000000001FFFFFFFFFFFF80000000
000000FFFF000000007FFFF800000007FFF0000000000000FFFFFFFFFFFFFFFF000000000000001FFFFFFFFFFFFF80000000000000FFFE00000000000000000003FFFFFFFFFFFFFFFC00000000000000FFF0000000000003FFFFFFFFFFFF80000000
0000007FFF000000007FFFF800000007FFF0000000000001FFFFFF8001FFFFFF800000000000001FFFFFFFFFFFFFC0000000000000FFFE00000000000000000003FFFFFFFFFFFFFFFE00000000000000FFF0000000000003FFFFF0001FFF80000000
0000007FFF000000007FFFFC0000000FFFF0000000000003FFFFF800001FFFFFC00000000000001FFF80003FFFFFE0000000000000FFFE00000000000000000003FFF00003FFFFFFFF00000000000001FFF0000000000007FFFF800001FF80000000
0000007FFF800000007FFFFC0000000FFFE0000000000007FFFFE0000007FFFFE00000000000001FFF800003FFFFE0000000000000FFFE00000000000000000003FFF0000007FFFFFF80000000000001FFE000000000000FFFFE0000003F80000000
0000003FFF80000000FFFFFC0000000FFFE000000000000FFFFF80000001FFFFE00000000000001FFF800000FFFFE0000000000000FFFE00000000000000000003FFF0000000FFFFFF80000000000001FFE000000000000FFFF80000000F80000000
0000003FFF80000000FFFFFC0000000FFFE000000000000FFFFF000000007FFFF00000000000001FFF8000003FFFF0000000000000FFFE00000000000000000003FFF00000001FFFFFC0000000000001FFE000000000000FFFF00000000780000000
0000003FFFC0000000FFFFFE0000001FFFE000000000001FFFFC000000003FFFF80000000000001FFF8000001FFFF0000000000000FFFE00000000000000000003FFF000000007FFFFE0000000000003FFC000000000001FFFE00000000000000000
0000003FFFC0000001FFFFFE0000001FFFC000000000003FFFF8000000001FFFF80000000000001FFF8000000FFFF0000000000000FFFE00000000000000000003FFF000000001FFFFF0000000000003FFC000000000001FFFE00000000000000000
0000001FFFC0000001FFFFFE0000001FFFC000000000003FFFF0000000000FFFFC0000000000001FFF8000000FFFF8000000000000FFFE00000000000000000003FFF000000000FFFFF0000000000003FFC000000000001FFFC00000000000000000
0000001FFFC0000001FFFFFF0000001FFFC000000000007FFFE00000000007FFFE0000000000001FFF80000007FFF8000000000000FFFE00000000000000000003FFF0000000003FFFF8000000000003FFC000000000001FFFC00000000000000000
0000001FFFE0000001FFFFFF0000003FFF8000000000007FFFC00000000003FFFE0000000000001FFF80000007FFF8000000000000FFFE00000000000000000003FFF0000000001FFFF8000000000007FF8000000000001FFFC00000000000000000
0000000FFFE0000003FFFFFF0000003FFF800000000000FFFF800000000001FFFE0000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF0000000000FFFFC000000000007FF8000000000003FFF800000000000000000
0000000FFFE0000003FFFFFF0000003FFF800000000000FFFF800000000001FFFF0000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF0000000000FFFFC000000000007FF8000000000003FFF800000000000000000
0000000FFFF0000003FFFFFF8000003FFF800000000001FFFF000000000000FFFF0000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF00000000007FFFE000000000007FF0000000000003FFF800000000000000000
00000007FFF0000007FFFFFF8000007FFF000000000001FFFE0000000000007FFF8000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF00000000003FFFE00000000000FFF0000000000003FFFC00000000000000000
00000007FFF0000007FFFFFF8000007FFF000000000003FFFE0000000000007FFF8000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF00000000001FFFE00000000000FFF0000000000003FFFC00000000000000000
00000007FFF0000007FFFFFFC000007FFF000000000003FFFC0000000000003FFFC000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF00000000001FFFF00000000000FFE0000000000001FFFC00000000000000000
00000007FFF8000007FFDFFFC00000FFFF000000000003FFFC0000000000003FFFC000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF00000000000FFFF00000000000FFE0000000000001FFFC00000000000000000
00000003FFF800000FFFDFFFC00000FFFE000000000007FFF80000000000003FFFC000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF00000000000FFFF00000000000FFC0000000000001FFFE00000000000000000
00000003FFF800000FFFCFFFC00000FFFE000000000007FFF80000000000001FFFC000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF000000000007FFF000000000000000000000000001FFFF00000000000000000
00000003FFFC00000FFFCFFFE00000FFFE000000000007FFF00000000000001FFFE000000000001FFF80000003FFF8000000000000FFFE00000000000000000003FFF000000000007FFF800000000000000000000000001FFFF80000000000000000
00000001FFFC00001FFF8FFFE00001FFFC000000000007FFF00000000000001FFFE000000000001FFF80000007FFF8000000000000FFFE00000000000000000003FFF000000000007FFF800000000000000000000000000FFFFC0000000000000000
00000001FFFC00001FFF87FFE00001FFFC00000000000FFFF00000000000000FFFE000000000001FFF80000007FFF0000000000000FFFE00000000000000000003FFF000000000003FFF800000000000000000000000000FFFFE0000000000000000
00000001FFFC00001FFF87FFE00001FFFC00000000000FFFE00000000000000FFFE000000000001FFF80000007FFF0000000000000FFFE00000000000000000003FFF000000000003FFF8000000000000000000000000007FFFF8000000000000000
00000001FFFE00001FFF07FFF00001FFFC00000000000FFFE00000000000000FFFE000000000001FFF8000000FFFF0000000000000FFFE00000000000000000003FFF000000000003FFF8000000000000000000000000007FFFFC000000000000000
00000000FFFE00003FFF07FFF00003FFF800000000000FFFE00000000000000FFFF000000000001FFF8000001FFFE0000000000000FFFE00000000000000000003FFF000000000003FFFC000000000000000000000000003FFFFF000000000000000
00000000FFFE00003FFF03FFF00003FFF800000000000FFFE000000000000007FFF000000000001FFF8000003FFFE0000000000000FFFE00000000000000000003FFF000000000001FFFC000000000000000000000000003FFFFFC00000000000000
00000000FFFE00003FFF03FFF80003FFF800000000001FFFC000000000000007FFF000000000001FFF8000007FFFC0000000000000FFFE00000000000000000003FFF000000000001FFFC000000000000000000000000001FFFFFF00000000000000
000000007FFF00007FFE03FFF80003FFF000000000001FFFC000000000000007FFF000000000001FFF800000FFFFC0000000000000FFFE00000000000000000003FFF000000000001FFFC000000000000000000000000000FFFFFFC0000000000000
000000007FFF00007FFE03FFF80007FFF000000000001FFFC000000000000007FFF000000000001FFF800003FFFF80000000000000FFFE00000000000000000003FFF000000000001FFFC0000000000000000000000000007FFFFFF0000000000000
000000007FFF00007FFE01FFF80007FFF000000000001FFFC000000000000007FFF000000000001FFF80000FFFFF80000000000000FFFE00000000000000000003FFF000000000001FFFC0000000000000000000000000003FFFFFFC000000000000
000000007FFF80007FFC01FFFC0007FFF000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFFFF00000000000000FFFE00000000000000000003FFF000000000001FFFC0000000000000000000000000001FFFFFFF000000000000
000000003FFF8000FFFC01FFFC0007FFE000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFFFE00000000000000FFFE00000000000000000003FFF000000000001FFFC0000000000000000000000000000FFFFFFF800000000000
000000003FFF8000FFFC00FFFC000FFFE000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFFFC00000000000000FFFE00000000000000000003FFF000000000001FFFC00000000000000000000000000007FFFFFFE00000000000
000000003FFF8000FFFC00FFFC000FFFE000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFFF800000000000000FFFE00000000000000000003FFF000000000001FFFC00000000000000000000000000001FFFFFFF80000000000
000000001FFFC001FFF800FFFE000FFFC000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFFF000000000000000FFFE00000000000000000003FFF000000000001FFFC00000000000000000000000000000FFFFFFFE0000000000
000000001FFFC001FFF800FFFE001FFFC000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFFC000000000000000FFFE00000000000000000003FFF000000000001FFFC000000000000000000000000000003FFFFFFF0000000000
000000001FFFC001FFF8007FFE001FFFC000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFF8000000000000000FFFE00000000000000000003FFF000000000001FFFC000000000000000000000000000000FFFFFFF8000000000
000000000FFFC001FFF0007FFF001FFFC000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFE0000000000000000FFFE00000000000000000003FFF000000000001FFFC0000000000000000000000000000007FFFFFFE000000000
000000000FFFE003FFF0007FFF001FFF8000000000001FFFC000000000000007FFF000000000001FFFFFFFFFF80000000000000000FFFE00000000000000000003FFF000000000001FFFC0000000000000000000000000000001FFFFFFF000000000
000000000FFFE003FFF0003FFF003FFF8000000000001FFFC000000000000007FFF000000000001FFFFFFFFFF80000000000000000FFFE00000000000000000003FFF000000000001FFFC00000000000000000000000000000007FFFFFF800000000
000000000FFFE003FFF0003FFF003FFF8000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFC0000000000000000FFFE00000000000000000003FFF000000000001FFFC00000000000000000000000000000001FFFFFFC00000000
0000000007FFF007FFE0003FFF803FFF0000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFE0000000000000000FFFE00000000000000000003FFF000000000001FFFC000000000000000000000000000000007FFFFFE00000000
0000000007FFF007FFE0003FFF803FFF0000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFF0000000000000000FFFE00000000000000000003FFF000000000001FFFC000000000000000000000000000000001FFFFFF00000000
0000000007FFF007FFE0001FFF807FFF0000000000001FFFC000000000000007FFF000000000001FFFFFFFFFFF8000000000000000FFFE00000000000000000003FFF000000000003FFF80000000000000000000000000000000007FFFFF80000000
0000000003FFF00FFFE0001FFF807FFF0000000000001FFFE000000000000007FFF000000000001FFF8007FFFF8000000000000000FFFE00000000000000000003FFF000000000003FFF80000000000000000000000000000000001FFFFF80000000
0000000003FFF80FFFC0001FFFC07FFE0000000000001FFFE00000000000000FFFE000000000001FFF8001FFFFC000000000000000FFFE00000000000000000003FFF000000000003FFF800000000000000000000000000000000007FFFFC0000000
0000000003FFF80FFFC0000FFFC0FFFE0000000000000FFFE00000000000000FFFE000000000001FFF80007FFFE000000000000000FFFE00000000000000000003FFF000000000003FFF800000000000000000000000000000000003FFFFC0000000
0000000003FFF80FFFC0000FFFC0FFFE0000000000000FFFE00000000000000FFFE000000000001FFF80003FFFE000000000000000FFFE00000000000000000003FFF000000000007FFF800000000000000000000000000000000000FFFFE0000000
0000000001FFFC1FFF80000FFFE0FFFC0000000000000FFFF00000000000000FFFE000000000001FFF80001FFFF000000000000000FFFE00000000000000000003FFF000000000007FFF0000000000000000000000000000000000007FFFE0000000
0000000001FFFC1FFF80000FFFE0FFFC0000000000000FFFF00000000000001FFFE000000000001FFF80000FFFF800000000000000FFFE00000000000000000003FFF000000000007FFF0000000000000000000000000000000000003FFFF0000000
0000000001FFFC1FFF800007FFE1FFFC00000000000007FFF00000000000001FFFC000000000001FFF800007FFF800000000000000FFFE00000000000000000003FFF00000000000FFFF0000000000000000000000000000000000001FFFF0000000
0000000000FFFC3FFF800007FFE1FFFC00000000000007FFF80000000000001FFFC000000000001FFF800007FFFC00000000000000FFFE00000000000000000003FFF00000000000FFFE0000000000000000000000000000000000000FFFF0000000
0000000000FFFE3FFF000007FFF1FFF800000000000007FFF80000000000003FFFC000000000001FFF800003FFFE00000000000000FFFE00000000000000000003FFF00000000001FFFE00000000000000000000000000000000000007FFF8000000
0000000000FFFE3FFF000003FFF1FFF800000000000007FFF80000000000003FFF8000000000001FFF800001FFFE00000000000000FFFE00000000000000000003FFF00000000001FFFE00000000000000000000000000000000000007FFF8000000
00000000007FFE3FFF000003FFF3FFF800000000000003FFFC0000000000003FFF8000000000001FFF800001FFFF00000000000000FFFE00000000000000000003FFF00000000003FFFC00000000000000000000000000000000000007FFF8000000
00000000007FFF7FFE000003FFFBFFF800000000000003FFFC0000000000007FFF8000000000001FFF800000FFFF80000000000000FFFE00000000000000000003FFF00000000007FFFC00000000000000000000000000000000000003FFF8000000
00000000007FFF7FFE000003FFFBFFF000000000000003FFFE000000000000FFFF0000000000001FFF8000007FFF80000000000000FFFE00000000000000000003FFF00000000007FFF800000000000000000000000000000000000003FFF8000000
00000000007FFF7FFE000001FFFBFFF000000000000001FFFF000000000000FFFF0000000000001FFF8000007FFFC0000000000000FFFE00000000000000000003FFF0000000000FFFF800000000000000000000000000000000000003FFF8000000
00000000003FFFFFFE000001FFFFFFF000000000000001FFFF000000000001FFFF0000000000001FFF8000003FFFC0000000000000FFFE00000000000000000003FFF0000000001FFFF000000000000000000000000000000000000003FFF8000000
00000000003FFFFFFC000001FFFFFFE000000000000000FFFF800000000003FFFE0000000000001FFF8000003FFFE0000000000000FFFE00000000000000000003FFF0000000003FFFF000000000000000000000000000000000000003FFF8000000
00000000003FFFFFFC000000FFFFFFE000000000000000FFFFC00000000003FFFE0000000000001FFF8000001FFFF0000000000000FFFE00000000000000000003FFF0000000007FFFE000000000000000000000000000000000000003FFF8000000
00000000001FFFFFFC000000FFFFFFE0000000000000007FFFE00000000007FFFC0000000000001FFF8000000FFFF0000000000000FFFE00000000000000000003FFF000000000FFFFE000000000000000000000000000000000000003FFF8000000
00000000001FFFFFF8000000FFFFFFE0000000000000007FFFF0000000000FFFFC0000000000001FFF8000000FFFF8000000000000FFFE00000000000000000003FFF000000001FFFFC000000000000000000000000000080000000007FFF8000000
00000000001FFFFFF8000000FFFFFFC0000000000000003FFFF8000000001FFFF80000000000001FFF80000007FFFC000000000000FFFE00000000000000000003FFF000000007FFFF80000000000000000000000000001E0000000007FFF0000000
00000000001FFFFFF80000007FFFFFC0000000000000003FFFFC000000003FFFF00000000000001FFF80000007FFFC000000000000FFFE00000000000000000003FFF00000001FFFFF00000000000000000000000000003F000000000FFFF0000000
00000000000FFFFFF80000007FFFFFC0000000000000001FFFFE00000000FFFFF00000000000001FFF80000003FFFE000000000000FFFE00000000000000000003FFF00000007FFFFF00000000000000000000000000003FC00000001FFFF0000000
00000000000FFFFFF00000007FFFFF80000000000000000FFFFF80000001FFFFE00000000000001FFF80000001FFFE000000000000FFFE00000000000000000003FFF0000001FFFFFE00000000000000000000000000003FF00000003FFFF0000000
00000000000FFFFFF00000003FFFFF800000000000000007FFFFE0000007FFFFC00000000000001FFF80000001FFFF000000000000FFFE00000000000000000003FFF000001FFFFFFC00000000000000000000000000003FFE0000007FFFE0000000
000000000007FFFFF00000003FFFFF800000000000000007FFFFF800003FFFFF800000000000001FFF80000000FFFF800000000000FFFE00000000000000000003FFF00007FFFFFFF800000000000000000000000000003FFFC00001FFFFE0000000
000000000007FFFFE00000003FFFFF800000000000000003FFFFFF0003FFFFFF800000000000001FFF80000000FFFF800000000000FFFFFFFFFFFFC00000000003FFFFFFFFFFFFFFF000000000000000000000000000003FFFFC000FFFFFC0000000
000000000007FFFFE00000003FFFFF000000000000000001FFFFFFFFFFFFFFFF000000000000001FFF800000007FFFC00000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFFFFFE000000000000000000000000000003FFFFFFFFFFFFFC0000000
000000000003FFFFE00000001FFFFF000000000000000000FFFFFFFFFFFFFFFE000000000000001FFF800000003FFFE00000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFFFFF8000000000000000000000000000003FFFFFFFFFFFFF80000000
000000000003FFFFE00000001FFFFF0000000000000000007FFFFFFFFFFFFFFC000000000000001FFF800000003FFFE00000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFFFFF0000000000000000000000000000003FFFFFFFFFFFFF00000000
000000000003FFFFC00000001FFFFE0000000000000000003FFFFFFFFFFFFFF8000000000000001FFF800000001FFFF00000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFFFFE0000000000000000000000000000003FFFFFFFFFFFFE00000000
000000000003FFFFC00000000FFFFE0000000000000000001FFFFFFFFFFFFFE0000000000000001FFF800000001FFFF00000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFFFF80000000000000000000000000000003FFFFFFFFFFFFC00000000
000000000001FFFFC00000000FFFFE00000000000000000007FFFFFFFFFFFFC0000000000000001FFF800000000FFFF80000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFFFE00000000000000000000000000000003FFFFFFFFFFFF800000000
000000000001FFFF800000000FFFFE00000000000000000003FFFFFFFFFFFF80000000000000001FFF8000000007FFFC0000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFFFC00000000000000000000000000000003FFFFFFFFFFFF000000000
000000000001FFFF800000000FFFFC00000000000000000000FFFFFFFFFFFE00000000000000001FFF8000000007FFFC0000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFFE000000000000000000000000000000001FFFFFFFFFFFE000000000
000000000000FFFF8000000007FFFC000000000000000000007FFFFFFFFFF800000000000000001FFF8000000003FFFE0000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFF8000000000000000000000000000000000FFFFFFFFFFF8000000000
000000000000FFFF8000000007FFFC000000000000000000001FFFFFFFFFE000000000000000001FFF8000000003FFFF0000000000FFFFFFFFFFFFE00000000003FFFFFFFFFFC00000000000000000000000000000000003FFFFFFFFFE0000000000
000000000000FFFF0000000007FFF80000000000000000000003FFFFFFFF8000000000000000001FFF8000000001FFFE0000000000FFFFFFFFFFFFE00000000003FFFFFFFFFC000000000000000000000000000000000000FFFFFFFFF80000000000
0000000000007FFF0000000003FFF800000000000000000000007FFFFFFC0000000000000000000FFF8000000000FFFE00000000007FFFFFFFFFFFC00000000003FFFFFFFF800000000000000000000000000000000000000FFFFFFFC00000000000
00000000000000000000000000000000000000000000000000000FFFFFC00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000FFFFFC000000000000
0000000000000000000000000000000000000000000000000000000FE000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000FC00000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000FFFFF000000000000000000000000000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000000FFFFFFFF0000000000000000001FFFFFFFFFFFC0000000000000001FFFFFFF000000000000FFFFFFFFFFFFFFFF8000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFF800000000000000003FFFFFFFFFFFE000000000000000FFFFFFFFE00000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFF00000000000000003FFFFFFFFFFFE000000000000003FFFFFFFFF80000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFC0000000000000003FFFFFFFFFFFE00000000000000FFFFFFFFFFC0000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFF0000000000000003FFFFFFFFFFFE00000000000003FFFFFFFFFFC0000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFC000000000000003FFFFFFFFFFFE00000000000007FFFFFFFFFFC0000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFE000000000000003FFFFFFFFFFFE0000000000001FFFFFFFFFFFC0000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFF000000000000003FFFFFFFFFFFE0000000000003FFFFFFFFFFFC0000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFF800000000000003FFFFFFFFFFFE0000000000007FFFFFFFFFFFC0000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFC00000000000003FFFFFFFFFFFE000000000000FFFFFFFFFFFFC0000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFE00000000000003FFFFFFFFFFFE000000000000FFFFFFFFFFFFC0000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFE00000000000003FFFFFFFFFFFE000000000001FFFFFFFFFFFFC0000000001FFFFFFFFFFFFFFFFC000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFF00000000000003FFFFFFFFFFFE000000000003FFFFFC003FFFC0000000001FFFFFFFFFFFFFFFF8000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFC001FFFFFF00000000000003FFF000000000000000000003FFFFC00001FFC00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000FFFFF80000000000003FFF000000000000000000007FFFF0000007FC00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF800003FFFF80000000000003FFF000000000000000000007FFFC0000000FC00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF800000FFFF80000000000003FFF00000000000000000000FFFF800000007800000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000007FFFC0000000000003FFF00000000000000000000FFFF000000001000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000003FFFC0000000000003FFF00000000000000000000FFFE000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000003FFFC0000000000003FFF00000000000000000001FFFE000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFFC0000000000003FFF00000000000000000001FFFC000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFFC0000000000003FFF00000000000000000001FFFC000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFFC0000000000003FFF00000000000000000001FFFC000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFFC0000000000003FFF00000000000000000001FFFC000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFFC0000000000003FFF00000000000000000001FFFC000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFFC0000000000003FFF00000000000000000001FFFC000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFFC0000000000003FFF00000000000000000001FFFC000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFFC0000000000003FFF00000000000000000001FFFC000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFF80000000000003FFF00000000000000000001FFFE000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFF80000000000003FFF00000000000000000001FFFE000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000003FFF80000000000003FFF00000000000000000000FFFF000000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000003FFF80000000000003FFF00000000000000000000FFFF800000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000007FFF00000000000003FFF00000000000000000000FFFFC00000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF800000FFFF00000000000003FFF00000000000000000000FFFFE00000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF800000FFFE00000000000003FFF000000000000000000007FFFF80000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF800003FFFE00000000000003FFF000000000000000000007FFFFC0000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF800007FFFC00000000000003FFF000000000000000000003FFFFF0000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80001FFFF800000000000003FFF000000000000000000001FFFFFC000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8001FFFFF800000000000003FFF000000000000000000001FFFFFF000000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFF000000000000003FFF000000000000000000000FFFFFFC00000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFE000000000000003FFFFFFFFFFF00000000000007FFFFFF00000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFC000000000000003FFFFFFFFFFF00000000000003FFFFFFC0000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFF0000000000000003FFFFFFFFFFF80000000000001FFFFFFF0000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFE0000000000000003FFFFFFFFFFF80000000000000FFFFFFF8000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFF8000000000000003FFFFFFFFFFF800000000000007FFFFFFE000000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFE000000000000003FFFFFFFFFFF800000000000001FFFFFFF800000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFF000000000000003FFFFFFFFFFF800000000000000FFFFFFFE00000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFC00000000000003FFFFFFFFFFF8000000000000003FFFFFFF00000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFE00000000000003FFFFFFFFFFF8000000000000000FFFFFFFC0000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFF00000000000003FFFFFFFFFFF80000000000000007FFFFFFE0000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFF80000000000003FFFFFFFFFFF80000000000000001FFFFFFF0000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFFC0000000000003FFFFFFFFFFF000000000000000007FFFFFF8000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000FFFFFFE0000000000003FFFFFFFFFFF000000000000000001FFFFFFC000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF800003FFFFE0000000000003FFF000000000000000000000000007FFFFFE000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000007FFFF0000000000003FFF000000000000000000000000001FFFFFF000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000003FFFF0000000000003FFF0000000000000000000000000007FFFFF800000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000000FFFF8000000000003FFF0000000000000000000000000001FFFFFC00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000007FFF8000000000003FFF00000000000000000000000000007FFFFC00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000003FFF8000000000003FFF00000000000000000000000000003FFFFE00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000003FFFC000000000003FFF00000000000000000000000000000FFFFE00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000001FFFC000000000003FFF000000000000000000000000000007FFFF00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000001FFFC000000000003FFF000000000000000000000000000003FFFF00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000001FFFC000000000003FFF000000000000000000000000000001FFFF00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000001FFFE000000000003FFF000000000000000000000000000000FFFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000000FFFE000000000003FFF0000000000000000000000000000007FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000000FFFE000000000003FFF0000000000000000000000000000007FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000000FFFE000000000003FFF0000000000000000000000000000003FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000000FFFE000000000003FFF0000000000000000000000000000003FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000000FFFE000000000003FFF0000000000000000000000000000003FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000001FFFE000000000003FFF0000000000000000000000000000003FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000001FFFC000000000003FFF0000000000000000000000000000003FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000001FFFC000000000003FFF0000000000000000000000000000003FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000001FFFC000000000003FFF0000000000000000000000000000003FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000003FFFC000000000003FFF0000000000000000000000000000003FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000007FFFC000000000003FFF0000000000000000000000000000003FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000007FFF8000000000003FFF00000000000000000001E0000000007FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000000FFFF8000000000003FFF00000000000000000001F0000000007FFF80000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000001FFFF8000000000003FFF00000000000000000001FC00000000FFFF00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF8000007FFFF0000000000003FFF00000000000000000001FF00000001FFFF00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF800001FFFFF0000000000003FFF00000000000000000001FFC0000003FFFF00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFF80000FFFFFE0000000000003FFF00000000000000000001FFF800000FFFFE00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFFC0000000000003FFFFFFFFFFFF00000000001FFFF80003FFFFE00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFFC0000000000003FFFFFFFFFFFF80000000001FFFFFFFFFFFFFC00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFF80000000000003FFFFFFFFFFFF80000000001FFFFFFFFFFFFFC00000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFF00000000000003FFFFFFFFFFFF80000000001FFFFFFFFFFFFF800000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFE00000000000003FFFFFFFFFFFF80000000001FFFFFFFFFFFFF000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFFC00000000000003FFFFFFFFFFFF80000000001FFFFFFFFFFFFE000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFF800000000000003FFFFFFFFFFFF80000000001FFFFFFFFFFFFC000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFE000000000000003FFFFFFFFFFFF80000000001FFFFFFFFFFFF8000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFFC000000000000003FFFFFFFFFFFF80000000001FFFFFFFFFFFF0000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFF0000000000000003FFFFFFFFFFFF80000000000FFFFFFFFFFFC0000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFFC0000000000000003FFFFFFFFFFFF800000000003FFFFFFFFFF00000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000001FFFFFFFFFE00000000000000003FFFFFFFFFFFF800000000000FFFFFFFFFC00000000000000000007FFF0000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000000FFFFFFFFF000000000000000003FFFFFFFFFFFF8000000000001FFFFFFFE000000000000000000003FFE0000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000FFFFFF00000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000003FFC000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000000000000000000000000000000000000FFFF80000000000000000000000000FFFFC000000000000000000003FFFF0000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000000FFFFFFFE0000000000000000000000001FFFFFFC00000000000000000000000FFFFFFE0000000000000000007FFFFFF800000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000001FFFFFFFFF00000000000000000000000FFFFFFFF8000000000000000000000FFFFFFFFE00000000000000003FFFFFFFF00000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFE0000000000000000000003FFFFFFFFE000000000000000000003FFFFFFFFF8000000000000001FFFFFFFFFC0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFF800000000000000000001FFFFFFFFFF80000000000000000000FFFFFFFFFF8000000000000007FFFFFFFFFC0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFE00000000000000000007FFFFFFFFFFE0000000000000000003FFFFFFFFFF800000000000001FFFFFFFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFF8000000000000000000FFFFFFFFFFFF8000000000000000007FFFFFFFFFF800000000000003FFFFFFFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFC000000000000000003FFFFFFFFFFFFC00000000000000001FFFFFFFFFFF800000000000007FFFFFFFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFE000000000000000007FFFFFFFFFFFFF00000000000000003FFFFFFFFFFF80000000000001FFFFFFFFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFF00000000000000001FFFFFFFFFFFFFF80000000000000007FFFFFFFFFFF80000000000003FFFFFFFFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFF80000000000000003FFFFFFFFFFFFFFC000000000000000FFFFFFFFFFFF80000000000003FFFFFFFFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFC0000000000000007FFFFFFFFFFFFFFE000000000000001FFFFFFFFFFFF80000000000007FFFFFFFFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFC000000000000000FFFFFFFFFFFFFFFF000000000000001FFFFFFFFFFFF8000000000000FFFFFFFFFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFE000000000000001FFFFFFF00FFFFFFF800000000000003FFFFFE01FFFF8000000000001FFFFFF007FFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFF000000000000003FFFFFE00007FFFFFC00000000000007FFFFC00007FF8000000000001FFFFF00001FFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80003FFFFF000000000000003FFFFF000000FFFFFC00000000000007FFFF000000FF8000000000003FFFF8000003FE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800007FFFF000000000000007FFFFC0000003FFFFE0000000000000FFFFC0000001F8000000000003FFFE0000000FE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800001FFFF80000000000000FFFFF80000000FFFFF0000000000000FFFF8000000078000000000007FFFC00000003C0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800000FFFF80000000000001FFFFE000000003FFFF8000000000000FFFF0000000030000000000007FFF800000001C0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000007FFF80000000000001FFFFC000000001FFFF8000000000001FFFE0000000000000000000007FFF00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000007FFF80000000000003FFFF8000000000FFFFC000000000001FFFC000000000000000000000FFFF00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000003FFF80000000000003FFFF00000000007FFFE000000000001FFFC000000000000000000000FFFE00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000003FFF80000000000007FFFE00000000003FFFE000000000001FFFC000000000000000000000FFFE00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000003FFFC0000000000007FFFC00000000003FFFF000000000001FFFC000000000000000000000FFFE00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000001FFFC000000000000FFFF800000000001FFFF000000000003FFFC000000000000000000000FFFE00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000001FFF8000000000000FFFF000000000000FFFF000000000003FFFC000000000000000000000FFFE00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000001FFF8000000000001FFFF000000000000FFFF800000000003FFFC000000000000000000000FFFE00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000001FFF8000000000001FFFE0000000000007FFF800000000003FFFC000000000000000000000FFFE00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000003FFF8000000000003FFFE0000000000003FFFC00000000001FFFC000000000000000000000FFFE00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000003FFF8000000000003FFFC0000000000003FFFC00000000001FFFC000000000000000000000FFFF00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000003FFF8000000000003FFFC0000000000003FFFC00000000001FFFE000000000000000000000FFFF00000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000003FFF0000000000007FFF80000000000001FFFC00000000001FFFE000000000000000000000FFFF80000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000007FFF0000000000007FFF80000000000001FFFE00000000001FFFF0000000000000000000007FFFC0000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000007FFF0000000000007FFF00000000000000FFFE00000000000FFFF8000000000000000000007FFFE0000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800000FFFE0000000000007FFF00000000000000FFFE00000000000FFFFC000000000000000000007FFFF0000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800001FFFE000000000000FFFF00000000000000FFFE00000000000FFFFF000000000000000000003FFFF8000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800003FFFC000000000000FFFE00000000000000FFFF000000000007FFFF800000000000000000003FFFFE000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800007FFFC000000000000FFFE000000000000007FFF000000000007FFFFE00000000000000000001FFFFF000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80001FFFF8000000000000FFFE000000000000007FFF000000000003FFFFF80000000000000000001FFFFFC00000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000FFFFF0000000000000FFFE000000000000007FFF000000000001FFFFFE0000000000000000000FFFFFF00000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFE0000000000000FFFE000000000000007FFF000000000001FFFFFF80000000000000000007FFFFFC0000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFC0000000000001FFFC000000000000007FFF000000000000FFFFFFE0000000000000000003FFFFFF0000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFF80000000000001FFFC000000000000007FFF0000000000007FFFFFF8000000000000000001FFFFFFC000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFF00000000000001FFFC000000000000007FFF0000000000003FFFFFFE000000000000000000FFFFFFF000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFE00000000000001FFFC000000000000007FFF0000000000001FFFFFFF8000000000000000007FFFFFFC00000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFF00000000000001FFFC000000000000007FFF00000000000007FFFFFFE000000000000000003FFFFFFF00000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFC0000000000001FFFC000000000000007FFF80000000000003FFFFFFF000000000000000001FFFFFFFC0000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFF0000000000001FFFC000000000000003FFF80000000000001FFFFFFFC000000000000000007FFFFFFE0000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFF8000000000001FFFC000000000000003FFF800000000000007FFFFFFE000000000000000003FFFFFFF8000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFC000000000001FFFC000000000000003FFF000000000000001FFFFFFF800000000000000000FFFFFFFC000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFE000000000001FFFC000000000000003FFF000000000000000FFFFFFFC000000000000000003FFFFFFE000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFF000000000001FFFC000000000000007FFF0000000000000003FFFFFFE000000000000000000FFFFFFF800000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFF800000000001FFFC000000000000007FFF0000000000000000FFFFFFF8000000000000000003FFFFFFC00000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF801FFFFFFFC00000000001FFFC000000000000007FFF00000000000000003FFFFFFC000000000000000000FFFFFFE00000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800007FFFFE00000000001FFFC000000000000007FFF00000000000000000FFFFFFE0000000000000000007FFFFFF00000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800001FFFFE00000000001FFFC000000000000007FFF000000000000000003FFFFFE0000000000000000001FFFFFF80000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000007FFFF00000000001FFFE000000000000007FFF000000000000000000FFFFFF00000000000000000007FFFFFC0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000001FFFF00000000001FFFE000000000000007FFF0000000000000000003FFFFF80000000000000000001FFFFFC0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000000FFFF80000000000FFFE000000000000007FFF0000000000000000000FFFFFC00000000000000000007FFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000007FFF80000000000FFFE000000000000007FFE00000000000000000007FFFFC00000000000000000001FFFFF0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000007FFF80000000000FFFE00000000000000FFFE00000000000000000001FFFFE00000000000000000000FFFFF0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000003FFF80000000000FFFF00000000000000FFFE00000000000000000000FFFFE000000000000000000003FFFF8000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000003FFFC0000000000FFFF00000000000000FFFE000000000000000000003FFFF000000000000000000001FFFF8000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000001FFFC00000000007FFF00000000000000FFFE000000000000000000001FFFF000000000000000000000FFFF8000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000001FFFC00000000007FFF80000000000001FFFC000000000000000000000FFFF0000000000000000000007FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000001FFFC00000000007FFF80000000000001FFFC000000000000000000000FFFF8000000000000000000003FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000001FFFC00000000007FFF80000000000003FFFC0000000000000000000007FFF8000000000000000000003FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000001FFFC00000000003FFFC0000000000003FFF80000000000000000000007FFF8000000000000000000001FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000001FFFC00000000003FFFC0000000000007FFF80000000000000000000003FFF8000000000000000000001FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000001FFFC00000000003FFFE0000000000007FFF80000000000000000000003FFF8000000000000000000001FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000001FFFC00000000001FFFF000000000000FFFF00000000000000000000003FFF8000000000000000000001FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000001FFFC00000000001FFFF000000000000FFFF00000000000000000000003FFF8000000000000000000001FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000003FFFC00000000000FFFF800000000001FFFF00000000000000000000003FFF8000000000000000000001FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000003FFFC00000000000FFFFC00000000003FFFE00000000000000000000003FFF8000000000000000000001FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000003FFF8000000000007FFFE00000000007FFFE00000000000000000000003FFF8000000000000000000001FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000007FFF8000000000007FFFE00000000007FFFC00000000000000000000003FFF8000000000000000000001FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000000FFFF8000000000003FFFF0000000000FFFF8000000000001C0000000007FFF80000000000E0000000003FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000001FFFF0000000000003FFFFC000000003FFFF8000000000001E0000000007FFF00000000000F8000000003FFFC000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000003FFFF0000000000001FFFFE000000007FFFF0000000000003F800000000FFFF00000000000FC000000007FFF8000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF8000007FFFF0000000000000FFFFF00000000FFFFF0000000000003FE00000001FFFF00000000000FF00000000FFFF8000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF800001FFFFE0000000000000FFFFFC0000003FFFFE0000000000003FF80000003FFFF00000000000FFE0000001FFFF8000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFF80000FFFFFE00000000000007FFFFF000000FFFFFC0000000000003FFF000000FFFFE00000000000FFF8000003FFFF0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFFC00000000000003FFFFFE00007FFFFF80000000000003FFFF00003FFFFE00000000000FFFF80001FFFFF0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFF800000000000001FFFFFFF01FFFFFFF00000000000003FFFFF807FFFFFC00000000000FFFFFE03FFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFF000000000000000FFFFFFFFFFFFFFFE00000000000003FFFFFFFFFFFFF800000000000FFFFFFFFFFFFFE0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFF0000000000000007FFFFFFFFFFFFFFC00000000000003FFFFFFFFFFFFF800000000000FFFFFFFFFFFFFC0000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFE0000000000000003FFFFFFFFFFFFFF800000000000003FFFFFFFFFFFFF000000000000FFFFFFFFFFFFF80000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFFC0000000000000001FFFFFFFFFFFFFF000000000000003FFFFFFFFFFFFE000000000000FFFFFFFFFFFFF00000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFF00000000000000000FFFFFFFFFFFFFE000000000000003FFFFFFFFFFFFC000000000000FFFFFFFFFFFFE00000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFE000000000000000003FFFFFFFFFFFFC000000000000003FFFFFFFFFFFF8000000000000FFFFFFFFFFFFC00000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFFC000000000000000001FFFFFFFFFFFF0000000000000001FFFFFFFFFFFF0000000000000FFFFFFFFFFFF800000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFF00000000000000000007FFFFFFFFFFC0000000000000001FFFFFFFFFFFC0000000000000FFFFFFFFFFFE000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFFC00000000000000000001FFFFFFFFFF000000000000000007FFFFFFFFFF800000000000003FFFFFFFFFFC000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000003FFFFFFFFFF0000000000000000000007FFFFFFFFC000000000000000001FFFFFFFFFE000000000000000FFFFFFFFFF0000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000001FFFFFFFFF00000000000000000000001FFFFFFFF00000000000000000003FFFFFFFF00000000000000001FFFFFFFF80000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000000FFFFFFFC0000000000000000000000001FFFFFF0000000000000000000003FFFFFF8000000000000000001FFFFFFC00000000000000000000000000000000000000000000000000000
000000000000000000000000000000000000000000000000000000000000000000000000000000000001FFFE000000000000000000000000FFFE0000000000000000000007FFF8000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
^FS^XZ

^XZ
    ';
    
    $this->output->set_output(json_encode(array('ZPL'=>$html)));
    }
    
    /*\
    |*|
    |*|  DESCARGA EXCEL 
    |*|  DESDE CONTROLLER
    |*|  FORZAMOS A LA DESCARGA
    |*|
    \*/
    
    public function load_excel(){
        $this->load->library('excel');  
        $VALUE  =   $this->input->get('id');
        //**********************************************************************
        //******************** CUERPO DEL EXCEL ********************************
        //**********************************************************
        $this->excel->setActiveSheetIndex(0);         
        $this->excel->getActiveSheet()->setTitle('PRUEBA EXCEL');         
        $this->excel->getActiveSheet()->setCellValue('A1','UN POCO DE TEXTO -> '.$VALUE);         
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);         
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);         
        $this->excel->getActiveSheet()->mergeCells('A1:J1');           
        header('Content-Type: application/vnd.ms-excel');         
        header('Content-Disposition: attachment;filename="nombredelfichero.xls"');
        header('Cache-Control: max-age=0');//no cache         
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');         
        //FORZAMOS A LA DESCARGA        
        $objWriter->save('php://output');
    }
    
    #ADD 04-03-2022
    public function get_confirma_rechazo_muestras(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $data_produccion                =   [];
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_anatomia                    =   $this->input->post('id_anatomia');
        $usuarioh                       =   explode("-",$this->session->userdata("USERNAME"));
        $contrasena                     =   $this->input->post('contrasena'); 
        $array_muestras                 =   $this->input->post('array_muestras'); 
        $TXT_GLOBAL                     =   $this->input->post('TXT_GLOBAL');
        $valida                         =   $this->ssan_libro_biopsias_usuarioext_model->sqlvalidaclave($contrasena);
        if(count($valida)>0){
            $data_produccion            =   $this->ssan_libro_biopsias_usuarioext_model->model_confirma_rechazo_muestras(array(
                "ID_ANATOMIA"           =>  $id_anatomia,
                "COD_EMPRESA"           =>  $empresa,
                "SESSION"               =>  $usuarioh[0], 
                "ARRAY"                 =>  $array_muestras,
                "DATA_FIRMA"            =>  $valida,
                "TXT_GLOBAL"            =>  $TXT_GLOBAL,
            ));
        } else {
            $status                     =   false;
        }
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'data_produccion'           =>  $data_produccion,
        )));
    }
    
    ########################################################################
    #LEYENDA
    ########################################################################
    #CONTEMPOREANA          :   2
    #DIFERIDA               :   3
    #BIOPSIA + CITOLOGIA    :   4   =   V_LAST_NUMERO     
    ########################################################################
    #BIOPSIA + CITOLIGIA    :   4                 
    #CITOLOGIA              :   5   =   NUM_CO_CITOLOGIA  
    ########################################################################
    #PAP                    :   6   =   NUM_CO_PAP 
    ########################################################################
    public function ultimo_numero_disponible(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $ind_tipo_biopsia               =   $this->input->post('tipo_biopsia'); 
        $data_number                    =   $this->ssan_libro_biopsias_usuarioext_model->model_ultimo_numero_disponible(array(
            "val_empresa"               =>  $empresa,
            "ind_tipo_biopsia"          =>  $ind_tipo_biopsia,
        ));
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'data_numero'               =>  $data_number,
        )));
    }
    
    public function ultimo_numero_disponible_citologia(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $ind_tipo_biopsia               =   $this->input->post('tipo_biopsia'); 
        $data_number                    =   $this->ssan_libro_biopsias_usuarioext_model->model_ultimo_numero_disponible_citologia(array(
            "val_empresa"               =>  $empresa,
            "ind_tipo_biopsia"          =>  $ind_tipo_biopsia,
        ));
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'data_numero'               =>  $data_number,
        )));
    }
    
    public function fn_gestion_tomamuestraxuser(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $data_number                    =   $this->ssan_libro_biopsias_usuarioext_model->model_gestion_tomamuestraxuser(array(
            "val_empresa"               =>  $empresa,
        ));
        $html                           =   $this->load->view('ssan_libro_biopsias_listagespab/html_lista_usuariosxtomademuestra',$data_number,true);
        $this->output->set_output(json_encode(array(
            'html_out'                  =>  $html,
            'status'                    =>  $status,
            'data_numero'               =>  $data_number,
        )));
    }
    
    public function fn_valida_profesional(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $run                            =   $this->input->post('run');
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $data_number                    =   $this->ssan_libro_biopsias_usuarioext_model->model_asignacion_muestra_x_user(array(
            "val_empresa"               =>  $empresa,
            "rut_profesional"           =>  $run,
        ));
        $option                         =   '';
        if(count($data_number["DATA"][":P_ALL_TOMAS_MUESTRA"])>0){
            foreach($data_number["DATA"][":P_ALL_TOMAS_MUESTRA"] as $i => $row){
                $option                .=   '<option value="'.$row['ID_ROTULADO'].'" data-info="'.htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8').'">'.$row['TXT_OBSERVACION'].'</option>';
            }
        }
        $this->output->set_output(json_encode(array(
            'data_number'               =>  $data_number,
            'option'                    =>  $option,
            'status'                    =>  $status,
            'run'                       =>  $run,
            'info_prof'                 =>  $data_number["DATA"][":P_INFO_PROFESIONAL"],
            'data_rotulo'               =>  $data_number["DATA"][":P_USER_TOMA_MUESTRA"] 
        )));
    }
    
    public function record_userxrotulo(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $ind_servicios                  =   $this->input->post('ind_servicios');
        $ind_proesional                 =   $this->input->post('ind_proesional');
        $data_number                    =   $this->ssan_libro_biopsias_usuarioext_model->model_record_userxrotulo(array(
            "ind_servicios"             =>  $ind_servicios,
            "ind_proesional"            =>  $ind_proesional,
        ));
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
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
        $valida                         =   $this->ssan_libro_biopsias_usuarioext_model->sqlvalidaclave($contrasena);
        if(count($valida)>0){
            $data_number                =   $this->ssan_libro_biopsias_usuarioext_model->model_record_rotulos_por_usuario(array(
                "ind_servicios"         =>  $ind_servicios,
                "ind_proesional"        =>  $ind_proesional,
                "session"               =>  explode("-",$this->session->userdata('USERNAME'))[0],
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
    
    public function ver_valida_firma_simple(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $contrasena                     =   $this->input->post('contrasena');
        $valida                         =   $this->ssan_libro_biopsias_usuarioext_model->sqlvalidaclave($contrasena);
        $this->output->set_output(json_encode(array(
            'contrasena'                =>  $contrasena,
            'status'                    =>  $status,
            'valida'                    =>  $valida,
        )));
    }
    ###################################################
    #clave rapida esissan
    #12.01.2023
    ###################################################
    public function fn_gestion_clave_esissan(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $html                           =   $this->load->view('ssan_libro_biopsias_listagespab/html_gestion_clave_esissan',[],TRUE);
        $this->output->set_output(json_encode(array(
            'html_out'                  =>  $html,
            'status'                    =>  $status,
        )));
    }

    public function fn_valida_cuenta_esissan(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $run                            =   $this->input->post('run');
        $dv                             =   $this->input->post('dv');
        $data_return                    =   $this->ssan_libro_biopsias_usuarioext_model->valida_cuenta_esissan_anatomia(array(
            "ind_opcion"                =>  1,
            "empresa"                   =>  $empresa,
            "run"                       =>  $run,
            "dv"                        =>  $dv,
        ));
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return_bd'                 =>  $data_return,
        )));
    }

    public function fn_gestion_perfil(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $return                         =   [];
        $status_firma                   =   true;
        $contrasena                     =   $this->input->post('contrasena'); 
        $user                           =   str_replace(".","",$this->input->post('user'));
        $nombres                        =   strtoupper($this->input->post('nombres'));
        $apepate                        =   strtoupper($this->input->post('apepate'));
        $apemate                        =   strtoupper($this->input->post('apemate'));
        $email                          =   $this->input->post('email');
        $actualiza_pass                 =   $this->input->post('actualiza_pass');  
        $pass                           =   md5($this->input->post('pass'));
        $arrPrivilegios                 =   $this->input->post('arrPrivilegios');
        $arrEmpresas                    =   $this->input->post('arrEmpresas');
        $uID                            =   $this->input->post('uID');
        $activo                         =   $this->input->post('activo');
        $superUser                      =   $this->input->post('superUser');
        $arr_fe_user                    =   $this->ssan_libro_biopsias_usuarioext_model->sqlvalidaclave($contrasena);
        if(count($arr_fe_user)>0){
            if(empty($this->input->post('pass'))){
                $changePw               =   0;
            } else {
                $changePw               =   1;
            }
            $return                     =   $this->ssan_libro_biopsias_usuarioext_model->grabaUsu($user,$nombres,$apepate,$apemate,$email,$pass,$arrPrivilegios,$arrEmpresas,$uID,$changePw,$activo,$superUser,$actualiza_pass,$arr_fe_user);
        } else {
            $status_firma               =   false;
        }
        $this->output->set_output(json_encode(array(
            'status'                    =>  $return,
            'uID'                       =>  $uID,
            'status_firma'              =>  $status_firma,
        )));
    }

    #17.10.2023
    public function nuevo_punto_toma_muestra(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status                         =   true;
        $data_return                    =   [];
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $clave                          =   $this->input->post('clave');
        $txt_nombresubtuoi              =   $this->input->post('txt_nombresubtuoi');
        $ID_ROTULADO                    =   $this->input->post('ID_ROTULADO');
        $valida_user                    =   $this->ssan_libro_biopsias_usuarioext_model->sqlvalidaclave($clave);
        if (count($valida_user)>0){
            $data_return                =   $this->ssan_libro_biopsias_usuarioext_model->record_newsubpunto_tomamuestra(array(
                "empresa"               =>  $empresa,
                "txt_nombresubtuoi"     =>  $txt_nombresubtuoi,
                "ID_ROTULADO"           =>  $ID_ROTULADO,
                'uid'                   =>  $valida_user
            ));
        } else {
            $status                     =   false;
        }
        $this->output->set_output(json_encode(array(
            'esissan'                   =>  $status,
            'return_bd'                 =>  $data_return,
        )));
    }

    public function busqueda_lista_sub(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $data_return                    =   [];
        $status                         =   true;
        $ID_ROTULADO                    =   $this->input->post('ID_ROTULADO');
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $data_return                    =   $this->ssan_libro_biopsias_usuarioext_model->busqueda_lista_sub(array(
            "empresa"                   =>  $empresa,
            "ID_ROTULADO"               =>  $ID_ROTULADO,
        ));
        $this->output->set_output(json_encode(array(
            'esissan'                   =>  $status,
            'return_bd'                 =>  $data_return,
        )));
    }

    public function delete_sub_punto(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $data_return                    =   [];
        $status                         =   true;
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_sub_grupo                   =   $this->input->post('id_sub_grupo');
        $clave                          =   $this->input->post('clave');
        $valida_user                    =   $this->ssan_libro_biopsias_usuarioext_model->sqlvalidaclave($clave);
        if (count($valida_user)>0){
            $data_return                =   $this->ssan_libro_biopsias_usuarioext_model->delete_sub_punto(array(
                "empresa"               =>  $empresa,
                "id_sub_grupo"          =>  $id_sub_grupo,
                "uid"                   =>  $valida_user
            ));
        } else {
            $status                     =   false;
        }
        $this->output->set_output(json_encode(array(
            'esissan'                   =>  $status,
            'return_bd'                 =>  $data_return,
        )));
    }

    public function marca_pto_toma_muestra(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $data_return                    =   [];
        $status                         =   true;
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_toma_muestras               =   $this->input->post('id_toma_muestras');
        $ind_marca                      =   $this->input->post('ind_marca');
        $clave                          =   $this->input->post('clave');
        $valida_user                    =   $this->ssan_libro_biopsias_usuarioext_model->sqlvalidaclave($clave);
        if(count($valida_user)>0){
            $data_return                =   $this->ssan_libro_biopsias_usuarioext_model->model_marca_pto_toma_muestra(array(
                "empresa"               =>  $empresa,
                "id_toma_muestras"      =>  $id_toma_muestras,
                "ind_marca"             =>  $ind_marca,
                "uid"                   =>  $valida_user
            ));
        } else {
            $status                     =   false;
        }
        $this->output->set_output(json_encode(array(
            'esissan'                   =>  $status,
            'return_bd'                 =>  $data_return,
        )));
    }

    public function update_nombre_pto(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $data_return                    =   [];
        $status                         =   true;
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id                             =   $this->input->post('id');
        $nombre                         =   $this->input->post('nombre');
        $clave                          =   $this->input->post('clave');
        $valida_user                    =   $this->ssan_libro_biopsias_usuarioext_model->sqlvalidaclave($clave);
        if(count($valida_user)>0){
            $data_return                =   $this->ssan_libro_biopsias_usuarioext_model->model_update_nombre_pto(array(
                "empresa"               =>  $empresa,
                "id"                    =>  $id,
                "nombre"                =>  $nombre,
                "uid"                   =>  $valida_user
            ));
        } else {
            $status                     =   false;
        }
        $this->output->set_output(json_encode(array(
            'esissan'                   =>  $status,
            'return_bd'                 =>  $data_return,
        )));
    }
}