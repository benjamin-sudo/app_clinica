<?php

class Ssan_libro_edicionsolicitudbiopsia extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_edicionsolicitudbiopsia_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_libro_edicionsolicitudbiopsia/css/styles.css");
        $this->load->js("assets/Ssan_libro_edicionsolicitudbiopsia/js/javascript.js");
        $this->load->view('Ssan_libro_edicionsolicitudbiopsia/Ssan_libro_edicionsolicitudbiopsia_view',$data);
    }

}
?>