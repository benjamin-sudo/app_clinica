<?php

class modelinicio extends CI_Model {

    var $own    = 'ADMIN';
    var $ownGu  = 'GUADMIN';

    public function __construct(){
        parent::__construct();
        $this->load->database('session'); 
    }

    public function _index(){
        try {
            $this->db->select('1');
            $this->db->get();
            return true; // Connection is successful
        } catch (Exception $e) {
            log_message('error', 'Database connection failed: ' . $e->getMessage());
            return false; // Connection failed
        }
    }


    public function trae_login($user, $pass, $access = '') {
        $sql = "SELECT ID_UID, NAME, USERNAME,FIRST_NAME,MIDDLE_NAME,LAST_NAME,EMAIL,TELEPHONE, LOCKTODOMAIN,LASTLOGIN,DAYLIGHT from 
        $this->ownGu.FE_USERS WHERE DISABLE = 0 AND USERNAME='$user' 
            AND (PASSWORD='" . md5($pass) . "' OR LOCKTODOMAIN='" . md5($pass) . "')";
        $query  = $this->session->query($sql);
        return $query->result_array();
    }

}
