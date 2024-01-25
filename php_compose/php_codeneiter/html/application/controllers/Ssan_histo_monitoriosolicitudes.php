<?php

class Ssan_histo_monitoriosolicitudes extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_histo_monitoriosolicitudes_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_histo_monitoriosolicitudes/css/styles.css");
        $this->load->js("assets/Ssan_histo_monitoriosolicitudes/js/javascript.js");
        $this->load->view('Ssan_histo_monitoriosolicitudes/Ssan_histo_monitoriosolicitudes_view',$data);
    }

}
?>