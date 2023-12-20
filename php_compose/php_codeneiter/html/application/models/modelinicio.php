<?php

class modelinicio extends CI_Model {

    var $own = 'ADMIN';
    var $ownGu = 'GUADMIN';

    public function __construct(){
        parent::__construct();
    }




    public function trae_login($user, $pass, $access = '') {
        $sql = "SELECT ID_UID, NAME, USERNAME,FIRST_NAME,MIDDLE_NAME,LAST_NAME,EMAIL,TELEPHONE, LOCKTODOMAIN,LASTLOGIN,DAYLIGHT from 
        $this->ownGu.FE_USERS WHERE DISABLE = 0 AND USERNAME='$user' 
            AND (PASSWORD='" . md5($pass) . "' OR LOCKTODOMAIN='" . md5($pass) . "')";

        $query  = $this->db->query($sql);
        return $query->result_array();
    }

}
