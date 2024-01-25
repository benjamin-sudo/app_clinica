<?php

class Ssan_libro_biopsias_usuarioext extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        //$this->load->model("Ssan_libro_biopsias_usuarioext_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_libro_biopsias_usuarioext/css/styles.css");
        $this->load->js("assets/Ssan_libro_biopsias_usuarioext/js/javascript.js");
        $this->load->view('Ssan_libro_biopsias_usuarioext/Ssan_libro_biopsias_usuarioext_view',$data);
    }
}
