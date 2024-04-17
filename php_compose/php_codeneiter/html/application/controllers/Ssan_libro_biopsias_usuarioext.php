<?php

class Ssan_libro_biopsias_usuarioext extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("ssan_libro_biopsias_usuarioext_model");
        #$this->load->model("ssan_spab_gestionlistaquirurgica_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $empresa        =   $this->session->userdata("COD_ESTAB");
        $data = [];
        $this->load->css("assets/Ssan_libro_biopsias_usuarioext/css/styles.css");
        $this->load->js("assets/Ssan_libro_biopsias_usuarioext/js/javascript.js");
        $this->load->view('Ssan_libro_biopsias_usuarioext/Ssan_libro_biopsias_usuarioext_view',$data);
    }

    public function index_(){
        $this->output->set_template("Theme_blank");
        $empresa        =   $this->session->userdata("COD_ESTAB");
        $id_tabla       =   823;
        $DATA           =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        $this->load->view("ssan_spab_coordepabellonenfe_new/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS",array('DATA'=>$DATA));
    }

    public function vista_trazabilidad_sistema(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status         =   true;
        $html           =   '';
        $token          =   md5($this->input->post("id_anatomia"));
        $aData          =   $this->ssan_libro_biopsias_usuarioext_model->load_info_ap(array('token'=>$token));
        $html           =   $this->load->view("ssan_libro_biopsias_usuarioext/html_informacion_biospia_v2",array('cursor'=>$aData["return_bd"]),true);
        $this->output->set_output(json_encode(array(
            'status'    =>  $status,
            'html'      =>  $html,
        )));
    }

    public function RECARGA_LISTA_ANATOMIA(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $date_from                      =   $this->input->post("date_from");
        $date_to                        =   $this->input->post("date_to");
        $TABLA["SALIDA_DIRECTA"]        =   $date_from." ".$date_to;
        $this->output->set_output(json_encode($TABLA));
    }
    
    #BUSQUEDA DE PACIENTE - GLOBAL
    public function NUEVA_SOLICITUD_ANATOMIA3(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $session_arr                    =   explode("-",$this->session->userdata('USERNAME'));
	    $session                        =   $session_arr[0];
        $DATA_CURSOR                    =   $this->ssan_libro_biopsias_usuarioext_model->DATA_PRE_NUEVASOLICIUD_ANATOMIA(array(
                "COD_EMPRESA"           =>  $empresa,
                "USR_SESSION"           =>  $session,
                "DATE_FROM"             =>  date("d-m-Y"),
                "DATE_TO"               =>  date("d-m-Y"),
            )
        );
        $TABLA["GET_HTML"]              =   $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/NUEVO_PACIENTE_SOLICITUD",$DATA_CURSOR,true);
        $TABLA["DATA_INFO"]             =   true;
        $TABLA["SALIDA_DIRECTA"]        =   true;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function nueva_solicitud_anatomia(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $session_arr                    =   explode("-",$this->session->userdata('USERNAME'));
	    $session                        =   $session_arr[0];
        $IND_SOLICITUD                  =   $this->input->post("NUEVA_SOLICITD");
        #$DATA_CURSOR                   =   '';
        $DATA_CURSOR                    =   $this->ssan_libro_biopsias_usuarioext_model->DATA_PRE_NUEVASOLICIUD_ANATOMIA(
                array(
                "COD_EMPRESA"           =>  $empresa,
                "USR_SESSION"           =>  $session,
                "DATE_FROM"             =>  date("d-m-Y"),
                "DATE_TO"               =>  date("d-m-Y"),
            )
        );
        //$TABLA["GET_HTML"]            =   $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/NUEVO_PACIENTE_SOLICITUD",$DATA_CURSOR,true);
        $TABLA["GET_HTML"]              =   "";
        $TABLA["DATA_CURSOR"]           =   $DATA_CURSOR;
        $this->output->set_output(json_encode($TABLA));
    }
    
    #FUNCION QUE INICIA SOLICITUD DE ANATOMA PATOLOGICA EN EL EXTERIOR CON PACIENTE
    public function HTML_SOLICITUD_ANATOMIA(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $DATA                           =   array(
            'NUM_FICHAE'                =>  $this->input->post("NUM_FICHAE"),
            'ID_SERV'                   =>  $this->input->post("ID_SERV"),
            'ID_MEDICO'                 =>  $this->input->post("ID_MEDICO"),
        );
        $TABLA["GET_HTML_ANATOMIA"]     =   $this->load->view("ssan_libro_biopsias_usuarioext/FORMULARIOS/FROM_APATOLOGICA_EXT",$DATA,true);
    }

    public function get_cambio_fecha(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                         =   true;
        $txt_error                      =   '';
        $id                             =   $this->input->post('id'); 
        $pass                           =   $this->input->post('pass'); 
        $fecha                          =   $this->input->post('fecha'); 
        $return_data                    =   $this->ssan_libro_biopsias_usuarioext_model->get_cambio_fecha(array(
            'cod_empresa'               =>  $this->session->userdata("COD_ESTAB"),
            'id'                        =>  $id,
            'pass'                      =>  $pass,
            'fecha'                     =>  $fecha,
        ));
        if (count($return_data['data_bd'][':C_STATUS'])>0){
            $status                     =   false;
            $txt_error                  =   $return_data['data_bd'][':C_STATUS'][0]['TXT_ERROR'];
        }
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return'                    =>  $return_data,
            'txt_error'                 =>  $txt_error,
        )));
    }

}
