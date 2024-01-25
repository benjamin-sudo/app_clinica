<?php

class Ssan_libro_notificacancer extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_notificacancer_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $this->load->css("assets/Ssan_libro_notificacancer/css/styles.css");
        $this->load->js("assets/Ssan_libro_notificacancer/js/javascript.js");
        $this->load->view('Ssan_libro_notificacancer/Ssan_libro_notificacancer_view',$data);
    }

}
?>