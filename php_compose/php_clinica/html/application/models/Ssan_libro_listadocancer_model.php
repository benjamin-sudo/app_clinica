<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Ssan_libro_listadocancer_model extends CI_Model {


    var $own = "ADMIN";
    var $ownGu = "GUADMIN";
    var $tableSpace = "ADMIN";
    
    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('session',true);
    }

    
}