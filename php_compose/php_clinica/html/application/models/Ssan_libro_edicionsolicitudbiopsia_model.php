<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Ssan_libro_edicionsolicitudbiopsia_model extends CI_Model {

    var $tableSpace = "ADMIN";
    var $own = "ADMIN";
    var $ownGu = "GUADMIN";
    var $pabellon = "ADMIN";

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('session',true);
    }

    public function load_tiempo_macrocopica($data_controller) {
        $id_biopsia = $data_controller['id_biopsia'];
        $query = $this->db->query("SELECT 
                                        DATE_FORMAT(P.DATE_MACROSCOPIA, '%d-%m-%Y %H:%i') AS FECHA_MACRO_MAIN,
                                        DATE_FORMAT(P.DATE_MACROSCOPIA, '%Y-%m-%d') AS FECHA_MACRO,
                                        DATE_FORMAT(P.DATE_MACROSCOPIA, '%H:%i') AS HORA_MACRO
                                    FROM 
                                        ADMIN.PB_SOLICITUD_HISTO P  
                                    WHERE  
                                        P.ID_SOLICITUD_HISTO IN ($id_biopsia)");
    
        $query2 = $this->db->query("SELECT 
                                        DATE_FORMAT(MAX(M.DATE_AUDITA), '%d-%m-%Y %H:%i:%s') AS FECHA_MACRO_MUESTRAS
                                    FROM 
                                        ADMIN.PB_HISTO_NMUESTRAS M
                                    WHERE 
                                        M.ID_SOLICITUD_HISTO IN ($id_biopsia)
                                        AND M.IND_ESTADO IN (1)
                                    LIMIT 1 ");
        return [
            'arr_main' => $query->result_array(),
            'arr_muestra' => $query2->result_array(),
        ];
    }
    

    public function record_macrocopica_model($DATA) {
        $this->db->trans_start();
        $date_macroscopia = date('Y-m-d H:i:s', strtotime($DATA["v_date_fecha"] . ':00'));
        $update_data = [
            "DATE_MACROSCOPIA" => $date_macroscopia,
            "LAST_USR_AUDITA" => $DATA["session"],
            "LAST_DATE_AUDITA" => date('Y-m-d H:i:s'),
            "IND_SOLICITUD_EDITADA" => 1
        ];
        $this->db->where('ID_SOLICITUD_HISTO', $DATA["id_anatomia"]);
        $this->db->update('ADMIN.PB_SOLICITUD_HISTO', $update_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return [
                'status' => false,
                'message' => 'Error updating record'
            ];
        } else {
            return [
                'status' => true,
                'message' => 'Record updated successfully'
            ];
        }
    }
}