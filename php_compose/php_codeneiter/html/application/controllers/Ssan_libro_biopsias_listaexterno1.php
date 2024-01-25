<?php

class Ssan_libro_biopsias_listaexterno1 extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_biopsias_listaexterno1_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_libro_biopsias_listaexterno1/css/styles.css");
        $this->load->js("assets/Ssan_libro_biopsias_listaexterno1/js/javascript.js");
        $this->load->view('Ssan_libro_biopsias_listaexterno1/Ssan_libro_biopsias_listaexterno1_view',$data);
    }

}
?>