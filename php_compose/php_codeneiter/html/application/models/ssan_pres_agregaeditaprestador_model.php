<?php

defined("BASEPATH") OR exit("No direct script access allowed");
//require_once(APPPATH . '/models/ClassFonasa/libsp/nusoapwsf.php');
class ssan_pres_agregaeditaprestador_model extends CI_Model {

    var $tableSpace     =   "ADMIN";
    var $ownGu          =   "GUADMIN";

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('oracle_conteiner',true);
        $this->load->helper('text');
    }
    
}