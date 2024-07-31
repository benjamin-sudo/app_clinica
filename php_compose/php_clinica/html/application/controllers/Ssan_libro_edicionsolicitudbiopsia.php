<?php

class Ssan_libro_edicionsolicitudbiopsia extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_edicionsolicitudbiopsia_model");
        $this->load->model("ssan_libro_etapaanalitica_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data = [];
        $this->empresa = $this->session->userdata("COD_ESTAB");
        #$this->load->css("assets/Ssan_libro_edicionsolicitudbiopsia/css/styles.css");
        #$this->load->js("assets/Ssan_libro_edicionsolicitudbiopsia/js/javascript.js");
        $this->load->js("assets/ssan_libro_notificacancer/js/javascript.js");
        $this->load->css("assets/ssan_libro_notificacancer/css/styles.css");
        $this->load->view('Ssan_libro_edicionsolicitudbiopsia/Ssan_libro_edicionsolicitudbiopsia_view',$data);
    }

    public function html_edicion_macrocopica(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $id_biopsia = $this->input->post('id_biopsia');
        $return_data = [];
        $return_data = $this->Ssan_libro_edicionsolicitudbiopsia_model->load_tiempo_macrocopica(array(
            'cod_empresa' => $this->session->userdata("COD_ESTAB"),
            'id_biopsia' => $id_biopsia,
        ));
        $this->output->set_output(json_encode(array(
            'return_data' => $return_data,
            'status' =>  $status,
            'id_biopsia' => $id_biopsia
        )));
    }
    
    public function record_macrocopica(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $return = [];
        $txt_error = '';
        $contrasena = $this->input->post('constrasena');
        $id_anatomia = $this->input->post('id_biopsia');
        $v_date_fecha_hora = $this->input->post('v_date_fecha_hora'); 
        $arr_user = $this->ssan_libro_etapaanalitica_model->sqlvalidaclave($contrasena);
        if(count($arr_user)>0){
            $return =   $this->Ssan_libro_edicionsolicitudbiopsia_model->record_macrocopica_model(array( 
                'id_anatomia' => $id_anatomia,
                'v_date_fecha' => $v_date_fecha_hora,
                'session' => explode("-",$this->session->userdata("USERNAME"))[0],
            ));
        } else {
            $status = false;
            $txt_error = "Error en la firma simple";  
        }
        $this->output->set_output(json_encode(array(
            'return' =>  $return,
            'status' =>  $status,
            'txt_error' =>  $txt_error,
        )));
    }

}
?>