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

    public function login_modelo($user, $pass) {
        $sql = "SELECT USERNAME, PASSWORD, NAME, FIRST_NAME, LAST_NAME, USERGROUP, EMAIL FROM ADMIN.FE_USERS WHERE USERNAME = ?";
        $query = $this->db->query($sql, array($user));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (password_verify($pass, $row->PASSWORD)){
                return ['status' => true, 'row' => $row];
            } else {
                return ['status' => false, 'row' => []];
            }
        } else {
            return ['status' => false, 'row' => []];
        }
    }
}
