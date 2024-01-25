<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Ssan_hdial_eliminacionhojadiara_model extends CI_Model {

    var $tableSpace     =   "ADMIN";
    var $own            =   "ADMIN";
    var $ownGu          =   "GUADMIN";

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('oracle_conteiner',true);
    }
    
}