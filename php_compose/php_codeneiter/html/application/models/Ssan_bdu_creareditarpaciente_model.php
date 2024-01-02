<?php
defined("BASEPATH") OR exit("No direct script access allowed");
//require_once(APPPATH . '/models/ClassFonasa/libsp/nusoapwsf.php');

class ssan_bdu_creareditarpaciente_model extends CI_Model {

    var $tableSpace     =   "ADMIN";
    var $ownGu          =   "GUADMIN";

    public function __construct() {
        parent::__construct();
        #$this->load->model("sql_class/sql_class_ggpacientes");
        #$this->load->model("sql_class/sqlclass_archivo");
        #$this->load->model("sql_class/sql_class_pabellon");
    }

    public function getPacientes($numFichaE, $identifier, $codEmpresa, $isnal, $pasaporte, $tipoEx, $nombre, $apellidoP, $apellidoM, $LIM_INI, $templete){

        if ($identifier == '' and $pasaporte == ''){
            $query =  $this->db->select('   
                                            G.NUM_FICHAE            FALLECIDO,
                                            A.COD_PAIS,
                                            A.NUM_IDENTIFICACION,
                                            A.FEC_VENCEPASPORT,
                                            A.COD_RUTPAC,
                                            A.COD_DIGVER,
                                            A.NOM_NOMBRE,
                                            A.NOM_APEPAT,
                                            A.NOM_APEMAT,
                                            A.FEC_NACIMI,
                                            A.IND_TISEXO,
                                            A.NUM_FICHAE,
                                            A.IND_EXTRANJERO,
                                            F.NUM_NFICHA,
                                            COUNT(*) OVER () RESULT_COUNT
                                        ');
            $this->db->from($this->tableSpace . '.GG_TGPACTE A');
	
            if ($templete == 1 || $templete == 4 || $templete == 5) {
                //OPCION BUSCA TODO TEMPLETE GENERAL = 1
                $this->db->join($this->tableSpace . '.SO_TCPACTE F', ' F.NUM_FICHAE = A.NUM_FICHAE AND F.COD_EMPRESA =' . $codEmpresa, 'LEFT');
            } else {
                //SOLO BUSCA FICHA LOCAL templete solo fichaLocal  = 2
                $this->db->join($this->tableSpace . '.SO_TCPACTE F', ' F.NUM_FICHAE = A.NUM_FICHAE', 'LEFT');
                $this->db->where('F.COD_EMPRESA', $codEmpresa);
            }
            $this->db->join($this->tableSpace . '.GG_TPACFALLECIDO G', ' G.NUM_FICHAE = A.NUM_FICHAE', 'LEFT');
        	$this->db->where('A.IND_ESTADO','V');
            /*
            $this->db->join($this->tableSpace.".SO_TCPACTE F"       ,"F.NUM_FICHAE = A.NUM_FICHAE AND F.NUM_FICHAE  = A.NUM_FICHAE AND F.NUM_FICHAE IS NULL ", 'left');
            $this->db->join($this->tableSpace.".IN_TMIEMBROS G"     ,"G.COD_RUTPAC = F.COD_RUTPAC AND F.COD_EMPRESA = G.COD_EMPRESA AND G.IND_ESTADO = 'V' ", 'left');
            $this->db->join($this->tableSpace.".GG_TPACFALLECIDO M" ,"M.NUM_FICHAE = A.NUM_FICHAE AND M.IND_ESTADO  = 'V' ", 'left');
            */
            if(!empty($nombre) || !empty($apellidoP) || !empty($apellidoM)){
                if(!empty($nombre)){
                    $nombre	    =	str_replace("'", "&#39;", $nombre);
                    $this->db->like('A.NOM_NOMBRE', trim($nombre), 'both');
                }
                if(!empty($apellidoP)){
                    $apellidoP	    =	str_replace("'", "&#39;", $apellidoP);
                    $this->db->like('A.NOM_APEPAT', trim($apellidoP), 'both');
                }
                if(!empty($apellidoM)){
                    $apellidoM	    =	str_replace("'", "&#39;", $apellidoM);
                    $this->db->like('A.NOM_APEMAT', trim($apellidoM), 'both');
                }
            }
	        $this->db->limit(10,($LIM_INI - 1)*10);
            $query = $this->db->get();
        } else {
            $query = $this->db->query($this->sql_class_ggpacientes->sqlConsultaPacienteNEW($this->tableSpace, $numFichaE, $identifier, $codEmpresa, $isnal, $pasaporte, $tipoEx));
        }
        return $query->result_array();
    }



}