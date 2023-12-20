<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Constructor extends CI_Controller {

    public function index()  {
        //echo "<br>";
        //$host = $_SERVER['HTTP_HOST'];
        //$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        //echo $base = "http://" . $host . $uri . "/";
        //log_message('info', 'USER_INFO ' . 'entrando al aplicativo --> '.date('d-m-Y'));
        $this->load->view('inicio');
    }

    public function login(){
        if(!$this->input->is_ajax_request()) {  show_404(); }
        $status     =   true;
        $user       =   strtoupper(str_replace(".","",$this->input->post('user')));
        $password   =   $this->input->post('password');
        $access     =   $this->input->post('access');


        $this->output->set_output(json_encode([
            'status'    =>  true,
            'post'      =>  $user,
        ]));
    }

    public function login0(){
       // if (!$this->input->is_ajax_request()) {  show_404(); }

        $this->output->set_output(json_encode([
            'opcion'=> 'llogin 2',
            'status' => true
        ]));
    }
}
?>







