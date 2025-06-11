<?php

class Ssan_libro_biopsias_usuarioext extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pdf');
        $this->load->model("Ssan_hdial_ingresoegresopaciente_model");
        $this->load->model("Ssan_libro_biopsias_usuarioext_model");
        #$this->load->model("ssan_spab_gestionlistaquirurgica_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $empresa = $this->session->userdata("COD_ESTAB");
        $responde = [];
        $date_from = date("d-m-Y");
        $date_to = date("d-m-Y");
        $session = explode("-",$this->session->userdata('USERNAME'))[0];
        $responde = [];
        $responde = $this->Ssan_libro_biopsias_usuarioext_model->CARGA_LISTA_MISSOLICITUDES_ANATOMIA([
            "COD_EMPRESA" => $empresa,
            "USR_SESSION" => $session,
            "DATE_FROM" => $date_from,
            "DATE_TO" => $date_to,
            "LODA_X_SISTEMAS" => 2, //SOLO USUARIO EXTERNO
        ]);
        $responde['HTML_SOLICITUDEAP'] = $responde['HTML_SOLICITUDEAP']['NUEVAS_SOLICITUDES'];
        $this->load->css("assets/ssan_libro_biopsias_usuarioext/css/styles.css");
        $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/javascript.js");
        $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/anatomia_patologica.js"); #js formulario anatomia
        $this->load->view('ssan_libro_biopsias_usuarioext/ssan_libro_biopsias_usuarioext_view',$responde);
    }

    public function recarga_html_listaanatomiapatologica(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $date_from = $this->input->post("fecha_from");
        $date_to = $this->input->post("fecha_to");
        $idtabs = $this->input->post('idtabs');
        $value = $this->input->post('value');
        #SOLICITUDES DEL CLIENTE 
        #GET_LISTA_ANOTOMIAPATOLOGICA
        $session_arr = explode("-",$this->session->userdata('USERNAME'));
	    $session = $session_arr[0];
        $responde = $this->Ssan_libro_biopsias_usuarioext_model->CARGA_LISTA_MISSOLICITUDES_ANATOMIA([
            "COD_EMPRESA" => $empresa,
            "USR_SESSION" => $session,
            "DATE_FROM" => $date_from,
            "DATE_TO" => $date_to,
            "LODA_X_SISTEMAS" => 2, //SOLO USUARIO EXTERNO
        ]);
        #OUT TO VIWES
        $this->output->set_output(json_encode([
            "DATE_FROM" => $date_from,
            "DATE_TO" => $date_to,
            "HTML_LISTAS" => $responde,
        ]));
    }

    #elimina el usuario
    public function desabilita_solicitud_simple_ext(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $session = explode("-",$this->session->userdata("USERNAME"));
        $idanatomia = $this->input->post('idanatomia');
        $contrasena = $this->input->post('contrasena');
        $status = true;
        $aData = '';
        $valida = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($contrasena);
        if(count($valida)>0){
            $aData = $this->Ssan_libro_biopsias_usuarioext_model->get_elimina_solicitud_anatomia_ext($empresa,$session,$idanatomia,$valida);
        } else {
            $status = false;
        }
        $this->output->set_output(json_encode(array(
            'STATUS_OUT' => $aData,
            'STATUS_PASS' => $status,
            'valida' => $valida,
        )));
    }

    #FUNCION QUE GRABA LA SOLICITUD 
    public function RECORD_ANATOMIA_PATOLOGICA_EXT(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $contrasena = $this->input->post('contrasena');
        $accesdata = $this->input->post('accesdata');
        $session_arr = explode("-",$this->session->userdata('USERNAME'));
	    $session = $session_arr[0];
        $return = $this->Ssan_libro_biopsias_usuarioext_model->MODEL_RECORD_ANATOMIA_PATOLOGICA_EXT($session,$accesdata);
        $TABLA["MODEL_RETURN"] = $return;
        $TABLA["STATUS"] = $return["STATUS"];
        $TABLA["ID_ANATOMIA"] = $return["ID_ANATOMIA"];
        $TABLA["GET_FRAME"] = false;
        $TABLA["VIEWS_PDF"] = false;
        $this->output->set_output(json_encode($TABLA));
    }
   
    public function index_(){
        $this->output->set_template("Theme_blank");
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_tabla = 823;
        $DATA = $this->Ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        $this->load->view("ssan_spab_coordepabellonenfe_new/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS",array('DATA'=>$DATA));
    }

    public function new_nueva_solicitud_anatomia_ext(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $session_arr = explode("-",$this->session->userdata('USERNAME'));
        $NUM_FICHAE = $this->input->post('NUM_FICHAE');
        $ADMISION = $this->input->post('ADMISION');
        $session = $session_arr[0];
        $DATA_CURSOR =   $this->Ssan_libro_biopsias_usuarioext_model->data_pre_nuevasoliciud_anatomia(array(
            "COD_EMPRESA" => $empresa,
            "USR_SESSION" => $session,
            "DATE_FROM" => date("d-m-Y"),
            "DATE_TO" => date("d-m-Y"),
            "NUM_FICHAE" => $NUM_FICHAE,
            "ADMISION" => $ADMISION,
        ));
        $html = $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/NUEVO_PACIENTE_SOLICITUD",$DATA_CURSOR,true);
        $this->output->set_output(json_encode([
            "GET_HTML" =>  $html,
            "SALIDA_DIRECTA" =>  true,
            "DATA_INFO" =>  $DATA_CURSOR,
        ]));
    }


    public function vista_trazabilidad_sistema(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $html = '';
        $token = md5($this->input->post("id_anatomia"));
        $aData = $this->ssan_libro_biopsias_usuarioext_model->load_info_ap(array('token'=>$token));
        $html = $this->load->view("ssan_libro_biopsias_usuarioext/html_informacion_biospia_v2",array('cursor'=>$aData["return_bd"]),true);
        $this->output->set_output(json_encode(array(
            'status' => $status,
            'html' => $html
        )));
    }

    public function RECARGA_LISTA_ANATOMIA(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $date_from = $this->input->post("date_from");
        $date_to = $this->input->post("date_to");
        $TABLA["SALIDA_DIRECTA"] = $date_from." ".$date_to;
        $this->output->set_output(json_encode($TABLA));
    }
    
    #BUSQUEDA DE PACIENTE - GLOBAL
    public function NUEVA_SOLICITUD_ANATOMIA3(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa =   $this->session->userdata("COD_ESTAB");
        $session_arr =   explode("-",$this->session->userdata('USERNAME'));
	    $session =   $session_arr[0];
        $DATA_CURSOR =   $this->ssan_libro_biopsias_usuarioext_model->DATA_PRE_NUEVASOLICIUD_ANATOMIA(array(
                "COD_EMPRESA" => $empresa,
                "USR_SESSION" => $session,
                "DATE_FROM" =>  date("d-m-Y"),
                "DATE_TO" =>  date("d-m-Y"),
            )
        );
        $TABLA["GET_HTML"] = $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/NUEVO_PACIENTE_SOLICITUD",$DATA_CURSOR,true);
        $TABLA["DATA_INFO"] = true;
        $TABLA["SALIDA_DIRECTA"] = true;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function nueva_solicitud_anatomia(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $session_arr = explode("-",$this->session->userdata('USERNAME'));
	    $session = $session_arr[0];
        $IND_SOLICITUD = $this->input->post("NUEVA_SOLICITD");
        #$DATA_CURSOR = '';
        $DATA_CURSOR = $this->ssan_libro_biopsias_usuarioext_model->DATA_PRE_NUEVASOLICIUD_ANATOMIA(
                array(
                "COD_EMPRESA" => $empresa,
                "USR_SESSION" => $session,
                "DATE_FROM" => date("d-m-Y"),
                "DATE_TO" => date("d-m-Y"),
            )
        );
        //$TABLA["GET_HTML"] = $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/NUEVO_PACIENTE_SOLICITUD",$DATA_CURSOR,true);
        $TABLA["GET_HTML"] = "";
        $TABLA["DATA_CURSOR"] = $DATA_CURSOR;
        $this->output->set_output(json_encode($TABLA));
    }
    
    #FUNCION QUE INICIA SOLICITUD DE ANATOMA PATOLOGICA EN EL EXTERIOR CON PACIENTE
    public function HTML_SOLICITUD_ANATOMIA(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $DATA = array(
            'NUM_FICHAE' => $this->input->post("NUM_FICHAE"),
            'ID_SERV' => $this->input->post("ID_SERV"),
            'ID_MEDICO' => $this->input->post("ID_MEDICO"),
        );
        $TABLA["GET_HTML_ANATOMIA"] = $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/FROM_APATOLOGICA_EXT",$DATA,true);
    }

    public function get_cambio_fecha(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $txt_error = '';
        $return_data = [];
        $id = $this->input->post('id'); 
        $pass = $this->input->post('pass'); 
        $fecha = $this->input->post('fecha'); 
        $valida = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($pass);
        if (count($valida)>0){
            $return_data = $this->Ssan_libro_biopsias_usuarioext_model->get_cambio_fecha2(array(
                'cod_empresa' =>  $this->session->userdata("COD_ESTAB"),
                'id' =>  $id,
                'valida' =>  $valida,
                'fecha' =>  $fecha,
            ));
        } else {
            $status = false;
            $txt_error = 'Error en la firma simple';
        }
        $this->output->set_output(json_encode(array(
            'valida' => $valida,
            'status' =>  $status,
            'return' =>  $return_data,
            'txt_error' =>  $txt_error,
        )));
    }

    
    public function FORMULARIO_ANATOMIA_PATOLOGICA_V2(){
        if(!$this->input->is_ajax_request()) { show_404(); }
        $empresa = $this->session->userdata('COD_ESTAB');
        $IND_GESPAB = $this->input->post('IND_GESPAB');
        $ZONA_PAB = $this->input->post('ZONA_PAB');
        $ID_SERDEP = $this->input->post('IND_ESPECIALIDAD');
        $aData = $this->Ssan_libro_biopsias_usuarioext_model->main_form_anatomiapatologica(array(
            "COD_EMPRESA" =>  $empresa,
            "V_CALL_FASE" =>  0,
            "V_IND_EXTERNO" =>  0,
            "V_IND_SISTEMA" =>  0,
            "PA_ID_PROCARCH" =>  $this->input->post('PA_ID_PROCARCH'),
            "IND_GESPAB" =>  $this->input->post('IND_GESPAB'),
            "ZONA_PAB" =>  $this->input->post('ZONA_PAB'),
            "IND_ADMISION" =>  0,
            "ID_SERDEP" =>  $ID_SERDEP, 
        ));
        #INFO_ROTULADO
        $array_rotulado = [];
        if(count($aData["DATA_ROTULADO"])>0){
            foreach($aData["DATA_ROTULADO"]  as $i  => $fila){
                $array_rotulado[$i] = array("value"=>$fila["ID_ROTULADO"],"name"=>$fila["TXT_OBSERVACION"]);
            }
        }
        
        #AUTOCOMPLETE
        $INSER_INTO = '';
        $data_autocomplete = [];
        if($aData["DATA_AUTOCOMPLETE"]>0){
            foreach ($aData["DATA_AUTOCOMPLETE"] as $x => $row){
                #$INSER_INTO .= " INSERT INTO PABELLON.PB_NMUESTRA_AUTOCOMPLETADO (ID_AUTOCOMPLETADO,TXT_CHARACTER,TXT_REALNAME,IND_ESTADO) VALUES (".$row["ID_AUTOCOMPLETADO"].",'".$row["TXT_CHARACTER"]."',".$row["TXT_REALNAME"].",1); ";
                $data_autocomplete[] = array("character"=>$row['TXT_CHARACTER'],"realName"=>($x+1));
            }
        }

        $html = $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/FROM_APATOLOGICA_EXT",array(
            "COD_ESTAB" => $this->session->userdata("COD_ESTAB"),//
            //PACIENTE
            "NUM_FICHAE" => $this->input->post('NUM_FICHAE'),//
            "RUT_PACIENTE" => $this->input->post('RUT_PACIENTE'),//
            //PROFESIONAL
            "ID_MEDICO" =>  $this->input->post('ID_MEDICO'),
            "RUT_MEDICO" =>  $this->input->post('RUT_MEDICO'),
            //INFO SOLICITUD
            "IND_TIPO_BIOPSIA" =>  $this->input->post('IND_TIPO_BIOPSIA'),
            "TXT_TIPO_BIOPSIA" =>  $this->input->post('TXT_BIOPSIA'),
            "IND_ESPECIALIDAD" =>  $this->input->post('IND_ESPECIALIDAD'),
            "PA_ID_PROCARCH" =>  $this->input->post('PA_ID_PROCARCH'),//
            "AD_ID_ADMISION" =>  null,
            "IND_FRAME" =>  0,
            "CALL_FROM" =>  $this->input->post('CALL_FROM'),
            //GESPAB
            "ID_GESPAB" =>  $this->input->post('ID_GESPAB'),
            //DATA
            "DATA" =>  null,
            //ZONA DE ROTULADO
            "ZONA_PABELLON" =>  $ZONA_PAB,
            "ARRAY_ROTULADO" =>  $array_rotulado,
            "ARRAY_AUTOCOMPLETE" =>  array("NOMBRE_ANATOMIA"=>$data_autocomplete),
            //DATA GENERAL BASE DE DATOS 
            "ARRAY_BD" =>  $aData,
        ),true);
        $this->output->set_output(json_encode(array(
            'HTML_FINAL' => $html,
            'ARRAY_BD' => $aData,
            'ID_SERDEP' => $ID_SERDEP,  
            'array_rotulado' => $array_rotulado,
            'INSER_INTO' => $INSER_INTO,
        )));
    }

    #EN TRASPORTE + GPS
    public function confirma_trasporte(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa = $this->session->userdata('COD_ESTAB');
        $id_anatomia = $this->input->post('id_anatomia');
        $array_muestras = $this->input->post('array_muestras');
        $usuarioh = explode("-",$this->session->userdata("USERNAME"));
        $TXT_ERROR = '';
        $DATA = '';
        $STATUS = true;
        $password = $this->input->post('password');
        $valida = $this->Ssan_libro_biopsias_usuarioext_model->validaClave($password);
        if(count($valida)>0){
            $DATA = $this->Ssan_libro_biopsias_usuarioext_model->get_confirma_trasporte([
                "COD_EMPRESA" =>  $empresa,
                "SESSION" =>  $usuarioh[0], 
                "ID_ANATOMIA" =>  $id_anatomia,
                "ARRAY" =>  $array_muestras,
                "DATA_FIRMA" =>  $valida,
            ]);
        } else {
            $TXT_ERROR = 'Error en firma simple';
            $STATUS = false;
        }

        $this->output->set_output(json_encode([
            'PASS' => $password,
            'GET_BD' =>  $DATA,
            'DATA_FIRMA' => $valida,
            'RETURN' => $STATUS,
            'TXT_ERROR' => $TXT_ERROR,
            'STATUS' => $STATUS,
        ]));
    }

    #CUSTODIA EN 
    public function fn_confirma_custodia(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa = $this->session->userdata('COD_ESTAB');
        $DATA = '';
        $id_anatomia = $this->input->post('id_anatomia');
        $array_muestras = $this->input->post('array_muestras');
        $usuarioh = explode("-",$this->session->userdata("USERNAME"));
        $TXT_ERROR = '';
        $STATUS = true;
        $password = $this->input->post('password');
        $valida = $this->Ssan_libro_biopsias_usuarioext_model->validaClave($password);
        if(count($valida)>0){
            $DATA = $this->Ssan_libro_biopsias_usuarioext_model->get_confirma_custodia(array(
                        "COD_EMPRESA" => $empresa,
                        "SESSION" =>  $usuarioh[0], 
                        "ID_ANATOMIA" => $id_anatomia,
                        "ARRAY" =>  $array_muestras,
                        "DATA_FIRMA" => $valida,
                    ));
        } else {
            $TXT_ERROR = 'Error en firma simple';
            $STATUS = false;
        }
        $this->output->set_output(json_encode([
            'PASS' => $password,
            'GET_BD' => $DATA,
            'DATA_FIRMA' => $valida,
            'RETURN' => $STATUS,
            'TXT_ERROR' => $TXT_ERROR,
            'STATUS' => $STATUS,
        ]));
    }

    
    #################################
    #GESTOR UNICO DE PDF DE ANATOMIA#
    #################################
    public function BLOB_PDF_ANATOMIA_PATOLOGICA(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $STATUS = true;
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_tabla = $this->input->post('id');
        $DATA = $this->Ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(["COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla]);
        $txt_name_pdf = 'SOLICITUD DE ANATOMIA.pdf';
        $dompdf = new mPDF('','',0,'',15,15,16,16,9,9,'L');
        $html_firma = '';
        $HTML_BIOPSIAS = '';
        $DATA_FIRST = false;
        if(count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"][0])>0){
            $DATA_FIRST = true;
            $HTML_BIOPSIAS = $this->load->view("ssan_libro_biopsias_usuarioext/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS",array('DATA'=>$DATA,'FIRMA'=>$html_firma),true);
            $dompdf->WriteHTML($HTML_BIOPSIAS);
            $dompdf->SetHTMLFooter('SOLICITUD DE ANATOMIA PATOLOGICA - M.ANATOMICA');
        }
        if(count($DATA["P_AP_MUESTRAS_CITOLOGIA"][0])>0){
            if ($DATA_FIRST){  $dompdf->AddPage();    }
            $HTML_CITOLOGIA = $this->load->view("ssan_libro_biopsias_usuarioext/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS_CITO",array('DATA'=>$DATA,'FIRMA'=>$html_firma),true);
            $dompdf->WriteHTML($HTML_CITOLOGIA);
            $dompdf->SetHTMLFooter('SOLICITUD DE ANATOMIA PATOLOGICA - M.CITOLOGIA');
        }
        $base64_pdf = base64_encode($dompdf->Output($txt_name_pdf,'S'));
        $this->output->set_output(json_encode([
            'STATUS' =>  $STATUS,
            'DATA_RETURN' => $DATA,
            'empresa' =>  $empresa,
            'ID_RETURN' =>  $id_tabla,
            'IND_TEMPLATE' => 1,
            'HTML_BIOPSIAS' => $HTML_BIOPSIAS,
            'HTML_CITOLOGIA' => $HTML_CITOLOGIA,
            'PDF_MODEL' => $base64_pdf,
            'PDF_MODEL_DATA' => $base64_pdf,
        ])); 
    }
    
    public function pdf_recepcion_anatomia_pat_ok(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_tabla = $this->input->post('id');
        $DATA = $this->Ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        $txt_name_pdf = 'RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA:'.$id_tabla.'.pdf';
        $cod_functionario_entrega = '';
        $cod_functionario_recibe = '';       
        /*
        $partes = explode("#", $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_USER_TRASPORTE_FIRMA']);
        $subPartes = explode("-", $partes[1]);
        $cod_functionario_entrega = $this->validaciones->encodeNumber($subPartes[0].'&'.$empresa);
        $partes2 = explode("#", $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_USER_RECPCIONA_FIRMA']);
        $subPartes2 = explode("-", $partes2[1]);
        $cod_functionario_recibe = $this->validaciones->encodeNumber($subPartes2[0].'&'.$empresa);
        */
        #horizontal
        $dompdf = new mPDF("en-GB-x","Letter-L","","",10,10,10,10,6,3);
        $dompdf->AddPage();
        $html = $this->load->view("ssan_libro_biopsias_listagespab/pdf_recepcion_conforme_v2",array(
            "DATA" => $DATA,
            "empresa" => $empresa,
            "cod_functionario_entrega" => $cod_functionario_entrega,
            "cod_functionario_recibe" => $cod_functionario_recibe
        ),true);
        $dompdf->WriteHTML($html);
        $dompdf->SetHTMLFooter('RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA');
        $out = $dompdf->Output($txt_name_pdf,'S');
        $base64_pdf = base64_encode($out);
        $TABLA = [];
        $TABLA["HTML"] = $html;
        $TABLA["IND_TEMPLATE"] = 1;
        $TABLA["PDF_MODEL"] = $base64_pdf;
        $TABLA["PDF_MODEL_DATA"] = $base64_pdf;
        $TABLA["STATUS"] = true;
        $TABLA["DATA_RETURN"] = $DATA;
        $TABLA["ID_RETURN"] = $id_tabla;
        $this->output->set_output(json_encode($TABLA));
    }
}