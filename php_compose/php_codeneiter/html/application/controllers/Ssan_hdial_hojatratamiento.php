<?php

class Ssan_hdial_hojatratamiento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_hdial_hojatratamiento_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data = [];
        $this->load->css("assets/Ssan_hdial_hojatratamiento/css/styles.css");
        $this->load->js("assets/Ssan_hdial_hojatratamiento/js/javascript.js");
        $this->load->view('Ssan_hdial_hojatratamiento/Ssan_hdial_hojatratamiento_view',$data);
    }

    
}
