<?php

defined('BASEPATH') or exit('No direct script access allowed');
class inicio extends CI_Controller {

    public function index()  {

    }

    public function login(){
        //if (!$this->input->is_ajax_request()) {  show_404(); }
    
        
        $this->output->set_output(json_encode([
            'status' => true
        ]));
    }
    

}
?>







