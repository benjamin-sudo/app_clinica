<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Ssan_libro_edicionsolicitudbiopsia_model extends CI_Model {

    var $tableSpace = "ADMIN";
    var $own = "ADMIN";
    var $ownGu = "GUADMIN";
    var $pabellon = "ADMIN";

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('oracle_conteiner',true);
    }


    public function load_tiempo_macrocopica($data_controller){
        $id_biopsia = $data_controller['id_biopsia'];
        $query = $this->db->query("SELECT 
                                        TO_CHAR(P.DATE_MACROSCOPIA,'DD-MM-YYYY HH24:MI') AS FECHA_MACRO_MAIN
                                    FROM 
                                        $this->pabellon.PB_SOLICITUD_HISTO P  
                                    WHERE  
                                        P.ID_SOLICITUD_HISTO IN ($id_biopsia) 
                                    ");

        $query2 = $this->db->query("SELECT 
                                        TO_CHAR(MAX(M.DATE_AUDITA), 'DD-MM-YYYY HH24:MI:SS') AS FECHA_MACRO_MUESTRAS
                                    FROM 
                                        $this->pabellon.PB_HISTO_NMUESTRAS M
                                    WHERE 
                                        M.ID_SOLICITUD_HISTO IN ($id_biopsia) 
                                    AND 
                                        M.IND_ESTADO IN (1)
                                    AND 
                                        ROWNUM = 1
                                    ");
        return [
            'arr_main'      =>  $query->result_array(),
            'arr_muestra'   =>  $query2->result_array(),
        ];
    }

    function record_macrocopica_model($DATA){
        $this->db->trans_start();
        $this->db->where('ID_SOLICITUD_HISTO',$DATA["id_anatomia"]);
        $this->db->update($this->pabellon.'.PB_SOLICITUD_HISTO',array(
            "DATE_MACROSCOPIA"      =>  "TO_DATE('".$DATA["v_date_fecha"].":00','DD-MM-YYYY hh24:mi:ss')",
            "LAST_USR_AUDITA"       =>  $DATA["session"],
            "LAST_DATE_AUDITA"      =>  'SYSDATE',
            "IND_SOLICITUD_EDITADA" =>  "1"
        ));
        $this->db->trans_complete();
        return [
            'status' => true,
        ];
    }

}