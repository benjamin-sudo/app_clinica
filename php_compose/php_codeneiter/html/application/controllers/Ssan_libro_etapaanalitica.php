<?php

class Ssan_libro_etapaanalitica extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_etapaanalitica_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_libro_etapaanalitica/css/styles.css");
        $this->load->js("assets/Ssan_libro_etapaanalitica/js/javascript.js");
        $this->load->view('Ssan_libro_etapaanalitica/Ssan_libro_etapaanalitica_view',$data);
    }

}
?>