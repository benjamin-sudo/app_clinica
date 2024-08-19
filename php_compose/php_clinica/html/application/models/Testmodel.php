<?php
class Testmodel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Santiago');
        $this->load->database('session'); 
        
    }

    public function test() {
        return "Test success!";
    }
}
