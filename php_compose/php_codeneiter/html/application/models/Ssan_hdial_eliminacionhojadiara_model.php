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

    public function hojaactiva($AD_ID_ADMISION){
        $query  =   $this->db->query('SELECT AD_ID_ADMISION FROM ADMIN.URG_TADMISION WHERE AD_ACTIVA = 1 AND AD_ID_ADMISION ='.$AD_ID_ADMISION);
        return $query->result_array();
    }
    
    public function new_get_busquedatoken($origen_,$numfichae,$usuario){
        $this->load->library("autentificacion");
        $COD_ESTABL_G               =   $this->session->userdata("COD_ESTAB");
        $USARNAME_G                 =   explode("-",$this->session->userdata("USERNAME"));
        $origen                     =   $origen_;//NUM
            $return                     =   $this->autentificacion->getToken($COD_ESTABL_G,$usuario,$origen,'',$numfichae);
        $TOKEN_SESSION              =   '';
        $TOKEN_ONE                  =   '';
        if($return->status){
            $TOKEN_SESSION          =   '&token='.''.$return->access_token;
            $TOKEN_ONE              =   $return->access_token; 
        } 
        return array(
                'TOKEN_SESSION'         =>  $TOKEN_SESSION,
                'TOKEN_ONE'             =>  $TOKEN_ONE,
                'STATUS'                =>  true,
        );
    }
    
    public function al_dia_hojaactiva($NUMFICHAE,$FECHA){
        $query  =   $this->db->query(
                "
                    SELECT 
                        H.ID_TDHOJADIARIA, 
                        H.NUM_FICHAE, 
                        (
                            SELECT 
                                U.AD_ID_ADMISION
                            FROM 
                                ADMIN.URG_TADMISION U
                            WHERE
                                U.AD_ID_ADMISION = H.AD_ID_ADMISION
                            AND 
                                U.AD_ACTIVA = 1
                        )  
                        AS ADMISION_ACTIVA,
                        H.NUM_CITACION 
                    FROM 
                        ADMIN.HD_TDHOJADIARIA H
                    WHERE 
                        H.NUM_FICHAE IN ($NUMFICHAE)  
                    AND 
                        H.DATE_REALIZAHD 
                    BETWEEN 
                        TO_DATE('$FECHA 00:00:00','DD-MM-YYYY hh24:mi:ss') 
                    AND 
                        TO_DATE('$FECHA 23:59:00','DD-MM-YYYY hh24:mi:ss') 
                ");
        
        return $query->result_array();
    }
    
    //falta hoja diaria en proceso.
    
    public function eliminahojadiaria($empresa,$session_firma,$session_login,$IDHOJADIARIA,$AD_ID_ADMISION,$NUMFICHAE,$IND_MOTIVO){
        $this->db->trans_start();
        //**********************************************************************
        //HISTORIAL DE ELIMINACION 
        $HISTO_ELIMINA      =   $this->db->sequence($this->own,'SEQ_HD_HISTOELIMINAHOJA');
        $HISTORIAL_CLINICO  =   array(
                                        'ID_HISTOELIMINA'       =>  $HISTO_ELIMINA,
                                        'NUM_FICHAE'            =>  $NUMFICHAE,
                                        'ID_TDHOJADIARIA'       =>  $IDHOJADIARIA,
                                        'AD_ID_ADMISION'        =>  $AD_ID_ADMISION,
                                        'COD_EMPRESA'           =>  $empresa,
                                        'USR_FIRMA'             =>  $session_firma,
                                        'IND_ESTADO'            =>  1,
                                        'COD_USRCREA'           =>  $session_login,  
                                        'DATE_CREA'             =>  'SYSDATE',
                                        'IND_MOTIVO'            =>  $IND_MOTIVO,
                                    );
        $this->db->insert($this->own.'.HD_HISTOELIMINAHOJA',$HISTORIAL_CLINICO);
        //**********************************************************************
        
        //**********************************************************************
        $UpdTurno               =   array('AD_ACTIVA'=> 0);
        $this->db->where('AD_ID_ADMISION', $AD_ID_ADMISION);
        $this->db->update($this->own.'.URG_TADMISION', $UpdTurno);
        //**********************************************************************
   
        $this->db->trans_complete();
        return $this->db->trans_status(); 
   }




    
}