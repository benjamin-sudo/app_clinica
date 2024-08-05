<?php

class Ssan_libro_listadocancer extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_listadocancer_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data = [];
        $this->load->css("assets/ssan_libro_listadocancer/css/styles.css");
        $this->load->js("assets/ssan_libro_listadocancer/js/javascript.js");
        $this->load->view('ssan_libro_listadocancer/ssan_libro_listadocancer_view',$data);
    }
    
}
?>