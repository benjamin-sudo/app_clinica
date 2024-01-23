<?php

class ssan_pres_agregaeditaprestador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("ssan_pres_agregaeditaprestador_model");
    }

    public function index(){
        $this->output->set_template('blank');
        $data       =   [
                            'USERNAME'  =>  $this->session->userdata('USERNAME'),
                            'COD_ESTAB' =>  $this->session->userdata('COD_ESTAB')
                        ];
        $this->load->css("assets/ssan_pres_agregaeditaprestador/css/styles.css");
        $this->load->js("assets/ssan_pres_agregaeditaprestador/js/javascript.js");
        $this->load->view('ssan_pres_agregaeditaprestador/ssan_pres_agregaeditaprestador_view',$data);
    }
}

?>
