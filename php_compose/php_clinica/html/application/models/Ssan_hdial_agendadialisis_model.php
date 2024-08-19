<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Ssan_hdial_agendadialisis_model extends CI_Model {

    var $tableSpace     =   "ADMIN";
    var $own            =   "ADMIN";
    var $ownGu          =   "GUADMIN";

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('session',true);
        date_default_timezone_set('America/Santiago');
    }
    
}