<?php

class Ssan_libro_salatecnologo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_salatecnologo_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_libro_salatecnologo/css/styles.css");
        $this->load->js("assets/Ssan_libro_salatecnologo/js/javascript.js");
        $this->load->view('Ssan_libro_salatecnologo/Ssan_libro_salatecnologo_view',$data);
    }

}
?>