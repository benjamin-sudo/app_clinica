<?php
class Testmodel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database('session'); 
    }

    public function test() {
        return "Test success!";
    }
}
