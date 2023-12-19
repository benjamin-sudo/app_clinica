<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Constructor extends CI_Controller {

    public function index()  {
        
        //echo "<br>";

        //$host       =   $_SERVER['HTTP_HOST'];
        //$uri        =   rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        //echo $base  =   "http://" . $host . $uri . "/";
        
        $this->load->view('inicio');
    }

    public function login(){
        //if (!$this->input->is_ajax_request()) {  show_404(); }
    

        $this->output->set_output(json_encode([
            'status' => true
        ]));
    }

}
?>







