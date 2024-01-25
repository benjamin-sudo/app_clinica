<?php

class Ssan_libro_salamacroscopia extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_salamacroscopia_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_libro_salamacroscopia/css/styles.css");
        $this->load->js("assets/Ssan_libro_salamacroscopia/js/javascript.js");
        $this->load->view('Ssan_libro_salamacroscopia/Ssan_libro_salamacroscopia_view',$data);
    }

}
?>