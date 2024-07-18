<?php

class Ssan_hdial_agendadialisis extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_hdial_agendadialisis_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_hdial_agendadialisis/css/styles.css");
        $this->load->js("assets/Ssan_hdial_agendadialisis/js/javascript.js");
        $this->load->view('Ssan_hdial_agendadialisis/Ssan_hdial_agendadialisis_view',$data);
    }
}