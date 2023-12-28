<?php

class Ssan_bdu_creareditarpaciente extends CI_Controller {

    function __construct() {
        parent::__construct();

        #$this->load->model("ssan_bdu_creareditarpaciente_model");
        #$this->load->model("ssan_spab_listaprotocoloqx_model");
        #$this->load->model("ssan_his_historialclinico_model");
        #$this->load->library('output');
    }

    public function index(){
        $this->output->set_template('blank');
        $data = [
            'USERNAME'  =>  $this->session->userdata('USERNAME'),
            'COD_ESTAB' =>  $this->session->userdata('COD_ESTAB');
        ];
        $this->load->css("assets/ssan_bdu_creareditarpaciente/css/styles.css");
        $this->load->js("assets/ssan_bdu_creareditarpaciente/js/javascript.js");
        $this->load->view('ssan_bdu_creareditarpaciente/Ssan_bdu_creareditarpaciente_view',$data);
    }

}
