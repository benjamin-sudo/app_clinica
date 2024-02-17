<?php

class Ssan_hdial_ingresoegresopaciente extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_hdial_ingresoegresopaciente_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_hdial_ingresoegresopaciente/css/styles.css");
        $this->load->js("assets/Ssan_hdial_ingresoegresopaciente/js/javascript.js");
        
        $this->load->js("assets/recursos/wsocket_io/4_6_0/socket.io.min.js");

        $this->load->view('Ssan_hdial_ingresoegresopaciente/Ssan_hdial_ingresoegresopaciente_view',$data);
    }
}