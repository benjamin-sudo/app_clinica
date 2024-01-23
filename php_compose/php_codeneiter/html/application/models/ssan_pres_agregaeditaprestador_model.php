<?php

defined("BASEPATH") OR exit("No direct script access allowed");
//require_once(APPPATH . '/models/ClassFonasa/libsp/nusoapwsf.php');
class Ssan_pres_agregaeditaprestador_model extends CI_Model {

    var $tableSpace     =   "ADMIN";
    var $ownGu          =   "GUADMIN";

    public function __construct() {
        parent::__construct();
        $this->load->model("sql_class/sqlclass_archivo");
        $this->load->model("sql_class/sql_class_prestadores");
        $this->load->helper('text');
        $this->db = $this->load->database('oracle_conteiner',true);
    }

    public function cargatipo(){
        return [
            //'sql' => $this->db->query($this->sql_class_prestadores->cargartipo()),
            'sql' => 'nada'
        ];
    }
    
    //validamos clave codeigniter.
    public function validaClave($clave){
        $query = $this->db->query($this->sql_class_prestadores->sqlValidaClave($clave));
        return $query->result_array();
    }

    //Validamos clave typo.
    public function validaClaveTypo($clave){
        $this->conex = $this->load->database('mysql', TRUE);
        $query = $this->conex->query($this->sqlclass_archivo->sqlValidaClaveTypo($clave));
        return $query->result_array();
    }

    public function buscar($rutfin){
        $query = $this->db->query($this->sql_class_prestadores->buscar($rutfin));
        return $query->result_array();
    }

    public function cargaprof($id)
    {
        $query = $this->db->query($this->sql_class_prestadores->cargaprof($id));
        return $query->result_array();
    }

    public function consultaPrestador($rutfin)
    {
        $query = $this->db->query($this->sql_class_prestadores->consultaPrestador($rutfin));
        return $query->result_array();
    }

    public function consultaPrestadorxEmp($rutfin, $codemp)
    {
        $query = $this->db->query($this->sql_class_prestadores->consultaPrestadorxEmp($rutfin, $codemp));
        return $query->result_array();
    }
    public function consultaIniciales($iniciales)
    {
        $query = $this->db->query($this->sql_class_prestadores->consultaIniciales($iniciales));
        return $query->result_array();
    }
    public function consultaprofxestab($rutfin, $codemp)
    {
        $query = $this->db->query($this->sql_class_prestadores->consultaprofxestab($rutfin, $codemp));
        return $query->result_array();
    }
    public function guardarPrestador($rutfin, $digrut, $nombres, $appat, $apmat, $tprof, $prof, $email, $telefono, $iniciales, $rutUsClave, $codemp)
    {

        $this->db->trans_start();

        $dataUs = array(
            'COD_RUTPRO' => $rutfin,
            'COD_DIGVER' => $digrut,
            'NOM_NOMBRE' => strtoupper($nombres),
            'NOM_APEPAT' => strtoupper($appat),
            'NOM_APEMAT' => strtoupper($apmat),
            'EMAILMED' => $email,
            'NUM_TELEFOMED' => $telefono,
            'COD_TPROFE' => $prof,
            'IND_ESTADO' => 'V',
            'COD_EMPRESA' => $codemp,
            'COD_TPROFENEW' => $tprof
        );

        $mprestador = $this->consultaPrestador($rutfin);
        if ($mprestador) {
            //MODIFICO EL PRESTADOR
            $this->db->set('COD_USUARI', $rutUsClave);
            $this->db->set('FEC_AUDITA', 'SYSDATE');
            $this->db->where('COD_RUTPRO', $rutfin);
            $this->db->update($this->own . '.GG_TPROFESIONAL', $dataUs);
        } else {
            //CREA EL PRESTADOR
            $this->db->set('COD_PROMED', strtoupper($iniciales));
            $this->db->set('COD_USRCREA', $rutUsClave);
            $this->db->set('FEC_USRCREA', 'SYSDATE');
            $this->db->insert($this->own . '.GG_TPROFESIONAL', $dataUs);
        }

        $profxemp = $this->consultaPrestadorxEmp($rutfin, $codemp);
        if ($profxemp) {
            $this->db->set('IND_ESTADO', 'V');
            $this->db->where('COD_RUTPRO', $rutfin);
            $this->db->where('COD_EMPRESA', $codemp);
            $this->db->update($this->own . '.AP_TPROFXESTABL');
        } else {
            $dataUp = array(
                'COD_RUTPRO' => $rutfin,
                'COD_USRCREA' => $rutUsClave,
                'COD_EMPRESA' => $codemp,
                'FEC_USRCREA' => 'SYSDATE', //solo cuando se edita
                'IND_ESTADO' => 'V'
            );
            $this->db->where('COD_RUTPRO', $rutfin);
            $this->db->insert($this->own . '.AP_TPROFXESTABL', $dataUp);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }


}