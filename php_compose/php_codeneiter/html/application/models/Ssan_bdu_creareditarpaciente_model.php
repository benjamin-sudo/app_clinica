<?php
defined("BASEPATH") OR exit("No direct script access allowed");
//require_once(APPPATH . '/models/ClassFonasa/libsp/nusoapwsf.php');
class ssan_bdu_creareditarpaciente_model extends CI_Model {

    var $tableSpace     =   "ADMIN";
    var $ownGu          =   "GUADMIN";

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('oracle_conteiner',true);
        $this->load->helper('text');
        $this->load->model("sql_class/sql_class_ggpacientes");
        $this->load->model("sql_class/sqlclass_archivo");
        $this->load->model("sql_class/sql_class_pabellon");
    }

    public function graba_rut_extranjero($numfichae,$rut,$dv) {
        $this->db->trans_start();
        $UpdateNfichaLocal	= array('COD_RUTPAC' => $rut, "COD_DIGVER" => $dv);
        $this->db->where('NUM_FICHAE',$numfichae);
        $this->db->update($this->tableSpace.'.GG_TGPACTE',$UpdateNfichaLocal);
        $this->db->trans_complete();
        return $this->db->trans_status();
    } 
                    
    public function validaClave($clave) {
        $query = $this->db->query($this->sql_class_pabellon->sqlValidaClave($clave));
        return $query->row();
    }

    public function getTraeDatosLocalesPac($Ficha_e, $empresa_cod) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeDatosLocalesPac($this->tableSpace, $Ficha_e, $empresa_cod));
        return $query->result_array();
    }

    public function getPacientes($numFichaE, $identifier, $codEmpresa, $isnal, $pasaporte, $tipoEx, $nombre, $apellidoP, $apellidoM, $LIM_INI, $templete) {
        /*
          error_log("--------------------------------------");
          error_log("---------->".$numFichaE);
          error_log("---------->".$identifier);
          error_log("---------->".$codEmpresa);
          error_log("---------->".$isnal);
          error_log("---------->".$pasaporte);
          error_log("---------->".$tipoEx);
          error_log("---------->".$nombre);
          error_log("---------->".$apellidoP);
          error_log("---------->".$apellidoM);
          error_log("-------------------------------------");
         */
        if ($identifier == '' and $pasaporte == ''){
          $query =  $this->db->select('G.NUM_FICHAE            FALLECIDO,
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

    public function getBusquedaDatosExtranjero($empresa, $numfichae) {
        $query = $this->db->query($this->sql_class_pabellon->sqlBusquedaDatosExtranjero($empresa, $numfichae));
        return $query->row();
    }

    public function getPacientesUnico($numFichae, $identifier, $codEmpresa, $isnal, $pasaporte, $tipoEx) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlConsultaPacienteNEW($this->tableSpace, $numFichae, $identifier, $codEmpresa, $isnal, $pasaporte, $tipoEx));
        return $query->result_array();
    }

    public function getTraeGenero() {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeGenero($this->tableSpace));
        return $query->result_array();
    }

    public function getTraeEtnia() {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeEtnia($this->tableSpace));
        return $query->result_array();
    }

    public function getTraeEstadoCivil() {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeEstadoCivil($this->tableSpace));
        return $query->result_array();
    }

    public function getTraePais() {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraePais($this->tableSpace));
        return $query->result_array();
    }

    public function getTraeRegionXCodigo() {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeRegionXCodigo($this->tableSpace));
        return $query->result_array();
    }

    public function getTraeGrupoSangre() {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeGrupoSangre($this->tableSpace));
        return $query->result_array();
    }

    public function getTraeFactorSangre() {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeFactorSangre($this->tableSpace));
        return $query->result_array();
    }

    public function getTraePrevision($restric) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraePrevision($this->tableSpace, $restric));
        return $query->result_array();
    }

    public function getTraeEmpresa() {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeEmpresa($this->tableSpace));
        return $query->result_array();
    }

    public function getTraeCiudadAll($Region) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeCiudadAll($this->tableSpace, $Region));
        return $query->result_array();
    }

    public function sqlTraeCodigoComuna($Region) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeCodigoComuna($this->tableSpace, $Region));
        return $query->result_array();
    }

    public function getValidaDNI_PASAPORTE($codEmpresa, $txtNumero, $numID) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlValidaDNI_PASAPORTE($this->tableSpace, $codEmpresa, $txtNumero, $numID));
        return $query->result_array();
    }

    public function getValidaRutFonasa($codEmpresa, $txtNumero) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlValidaRutFonasa($this->tableSpace, $codEmpresa, $txtNumero));
        return $query->result_array();
    }

    public function getValidaIdUnico($codEmpresa, $txtNumero) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlValidaIdUnico($this->tableSpace, $codEmpresa, $txtNumero));
        return $query->result_array();
    }

    public function traeDatosTitularxRut($identifier) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqltraeDatosTitularxRut($this->tableSpace, $identifier));
        return $query->result_array();
    }

    public function getTraePrevisionPacienteNfichaE($numfichae) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlTraePrevisionPacienteNfichaE($this->tableSpace, $numfichae));
        return $query->result_array();
    }

    public function ConsultaFicLoal($fLPaciente, $codEmpresa) {
        $query = $this->db->query($this->sql_class_ggpacientes->sqlConsultaFicLoal($this->tableSpace, $fLPaciente, $codEmpresa));
        return $query->result_array();
    }

    public function GestorDatosBDU($codEmpresa, $session, $isNew, $isNal, $RN, $numFichae, $IDselect, $txtNumero, $RutMon, $FORM, $rutTitul, $Previ, $nuevaNFicha) {
        $this->db->trans_start();
        $actualiza_local = '';
        $cod_titulocompara = '';
        $rut = '';

        //$isNal 1      //NACIONAL , 0 EXTRANJERO 
        //$isNew 1      //NUEVO , 0 PASADO (DEBE VENIR CON NUM_FICHAE)        
        //GG_TGPACTE    //DATOS GENERALES 
        //SO_TCPACTE    //DATOS LOCALES 
        //SO_TTITUL     //DATOS PREVISIONALES
        //PERCAPITA
        if ($isNew == 0) {
            $creaProtocolo      =   array(
                'COD_USUARI'    =>  $session, 
                'FEC_AUDITA'    => 'SYSDATE'
            );
        } else {
            
            $query		        =   $this->db->query($this->sql_class_pabellon->busquedaLastNumfichae());
            $LastNumfichae      =   $query->result_array();
	        $RnumFichae         =   $LastNumfichae[0]['NUM_CORREL'];
            $numFichae          =   ($RnumFichae + 1);
            $TransResulta       =   $this->db->query($this->sql_class_pabellon->UpdateLastNumfichae($numFichae));

            if ($TransResulta){
                error_log("------------------------------------>Grabado Fichae<---------------------------------");
            } else {
                error_log("------------------------------------>Query failed Fichae<----------------------------");
                ///$this->db->trans_rollback();
            }

            $creaProtocolo = array(
                'COD_USRCREA'   =>      $session,
                //'FEC_USRCREA'   =>      'SYSDATE',
                'NUM_FICHAE'    =>      $numFichae,
                'IND_ESTADO'    =>      'V'
            );
        }

        foreach ($FORM as $infObject => $Object) {
            if ($infObject == 'DatosGenerales') {
                $datosGenerales = $Object[0]['Form_Datosgenerales'];
                foreach ($datosGenerales as $i => $From){
                    /*
                    error_log("-----------------------------------------------------------------------------------------");
                    error_log("---------------- (NAME:".$From['name'].")  --- VALUE (".$From['value'].") ---------------");
                    error_log("-----------------------------------------------------------------------------------------");
                    */
                    if ($From['name'] == 'txtrutpac') {
                       // $creaProtocolo = array_merge($creaProtocolo, array('COD_RUTPAC' => $From['value']));
                        $rut = $From['value'];
                    }
                    if ($From['name'] == 'txtdvpac') {
                        $creaProtocolo = array_merge($creaProtocolo, array('COD_DIGVER' => $From['value']));
                    }
                    if ($From['name'] == 'txtruttitular') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('COD_RUTTIT' => $From['value']));
                    }
                    //INI SOLO EXTRANJEROS
                    if ($From['name'] == 'txt_extranjero') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('IND_EXTRANJERO' => strtoupper(trim($From['value']))));
                    }
                    if ($From['name'] == 'ind_extranjero') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('TIP_IDENTIFICACION' => $From['value']));
                    }
                    if ($From['name'] == 'txtNumIdentiExtra') {
                        $creaProtocolo = array_merge($creaProtocolo, array('NUM_IDENTIFICACION' => strtoupper(trim($From['value']))));
                    }
                    if ($From['name'] == 'txtFecvencePasport') {
                        $creaProtocolo = array_merge($creaProtocolo, array('FEC_VENCEPASPORT' => "TO_DATE('" . $From['value'] . "','DD/MM/YYYY')"));
                    }
                    //FIN SOLO EXTRANJEROS
                    if ($From['name'] == 'txtNombre') {
                        $creaProtocolo = array_merge($creaProtocolo, array('NOM_NOMBRE' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtNombreSocial') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NOM_SOCIAL' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtApellidoPaterno') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NOM_APEPAT' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtApellidoMaterno') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NOM_APEMAT' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtFechaNacimineto') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('FEC_NACIMI' => "TO_DATE('" . $From['value'] . "','DD/MM/YYYY')"));
                    }
                    if ($From['name'] == 'cboGenero') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('IND_TISEXO' => $From['value']));
                    }
                    if ($From['name'] == 'cboEtnia1') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('IND_ETN' => $From['value']));
                    }
                    if ($From['name'] == 'cboEtnia2') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('IND_PERCETN' => $From['value']));
                    }
                    if ($From['name'] == 'cboEstadoCivil') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('IND_ESTCIV' => $From['value']));
                    }
                    if ($From['name'] == 'txtPareja') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NOM_PAREJA' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtPadre') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NOM_NPADRE' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtMadre') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NOM_NMADRE' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'cboPais') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('COD_PAIS' => $From['value']));
                    }

		    /*agregado 25.06.2018*/
                    if ($From['name'] == 'cboNacionalidad') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('COD_NACIONALIDAD' => $From['value']));
                    }
                    if ($From['name'] == 'txtFecvence_fonasa') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('FEC_IDFONASA' => "TO_DATE('".$From['value']."','DD/MM/YYYY')"));
                    }
                    /*agregado 25.06.2018*/

                    if ($From['name'] == 'cboRegion') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('COD_REGION' => $From['value']));
                    }
                    if ($From['name'] == 'cboComuna') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('COD_COMUNA' => $From['value']));
                    }
                    if ($From['name'] == 'cboCiudad') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('COD_CIUDAD' => $From['value']));
                    }
                    if ($From['name'] == 'cboviadire') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('COD_VIADIRECCION' => $From['value']));
                    }
                    if ($From['name'] == 'txtDireccion') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NOM_DIRECC' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtNum_dire') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NUM_CASA' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtdire_resto') {
                       // $creaProtocolo = array_merge($creaProtocolo, array('NOM_RESTODIRECC' => $From['value']));
                    }
                    if ($From['name'] == 'cboProcedencia') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('IND_URBRUR' => $From['value']));
                    }
                    if ($From['name'] == 'txtTelefono') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NUM_TELEFO1' => $From['value']));
                    }
                    if ($From['name'] == 'txtCelular') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('NUM_CELULAR' => $From['value']));
                    }
                    if ($From['name'] == 'txtEmail') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('EMAIL' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'cboGrupoSangre') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('COD_GRUSAN' => $From['value']));
                    }
                    if ($From['name'] == 'cboFactorSangre') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('COD_FACSAN' => $From['value']));
                    }
                    if ($From['name'] == 'cboTippac') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('IND_TIPPAC' => $From['value']));
                    }
                    if ($From['name'] == 'rdoprais') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('IND_CONDPRAIS' => $From['value']));
                    }
                    if ($From['name'] == 'rdotrans') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('IND_TRANS' => $From['value']));
                    }
                    //Last Agregado 
                    if ($From['name'] == 'txtRepLegal') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('REP_LEGAL' => $From['value']));
                    }
                    if ($From['name'] == 'txtOcupacion') {
                        //$creaProtocolo = array_merge($creaProtocolo, array('OCUPACION' => $From['value']));
                    }
                    
                    //agregado 20-09-2021
                    if ($From['name'] == 'ind_nivel_educacional') {
                        $creaProtocolo = array_merge($creaProtocolo, array('IND_NIVEL_EDUCACIONAL' => $From['value']));
                    }
                    if ($From['name'] == 'ind_poblacion_migrante') {
                        $creaProtocolo = array_merge($creaProtocolo, array('IND_POBLACION_MIGRANTE' => $From['value']));
                    }
                    
                    
                }

                if ($isNew == 0) {
                    //FALTA GUARDA EN EL HISTORIAL
                    $this->db->where('NUM_FICHAE = ' . $numFichae);
                    $this->db->update($this->tableSpace . '.GG_TGPACTE', $creaProtocolo);
                } else {
                    $this->db->insert($this->tableSpace . '.GG_TGPACTE', $creaProtocolo);
                }
            } else if ($infObject == 'DatosLocales') {
                $datosLocales = $Object[0]['FormDatoslocales'];
                
                
                
                if ($isNew == 1) {
                    $actualiza_local = '0';
                    $creaDatosLocales = array('IND_ESTADO' => 'V', 'COD_USRCREA' => $session, 'FEC_USRCREA' => 'SYSDATE', 'NUM_FICHAE' => $numFichae, 'COD_EMPRESA' => $codEmpresa);
                    error_log("DATOS LOCALES ES NUEVO");
                } else {
                    error_log("----------------------------------------");
                    $query	    =   $this->db->query($this->sql_class_ggpacientes->sqlExisteDatosLocales($this->tableSpace, $numFichae, $codEmpresa));
		            $query2     =   $query->result_array();
                    if ($query2[0]['NUM'] == '0') {
                        $actualiza_local = '0';
                        $creaDatosLocales = array('IND_ESTADO' => 'V', 'COD_USRCREA' => $session, 'FEC_USRCREA' => 'SYSDATE', 'NUM_FICHAE' => $numFichae, 'COD_EMPRESA' => $codEmpresa, 'COD_SISTEMA' => '58');
                        error_log("DATOS LOCALES NO TIENE DATOS LOCALES");
                    } else {
                        $actualiza_local = '1';
                        $creaDatosLocales = array('IND_ESTADO' => 'V', 'COD_USUARI' => $session, 'FEC_AUDITA' => 'SYSDATE', 'NUM_FICHAE' => $numFichae, 'COD_EMPRESA' => $codEmpresa, 'COD_SISTEMAUDITA' => '58');
                        error_log("DATOS LOCALES TIENE");
                    }
                }

                foreach ($datosLocales as $i => $From) {
                    //***************************************************************************************************************************************************  
                    if ($From['name'] == 'txtrutpac') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('COD_RUTPAC' => $From['value']));
                    }
                    if ($From['name'] == 'cboRegionLocal') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('COD_REGIONL' => $From['value']));
                    }
                    if ($From['name'] == 'cboCiudadLocal') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('COD_CIUDADL' => $From['value']));
                    }
                    if ($From['name'] == 'cboComunaLocal') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('COD_COMUNAL' => $From['value']));
                    }
                    if ($From['name'] == 'cboviadireLocal') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('COD_VIADIRECCION' => $From['value']));
                    }
                    if ($From['name'] == 'txtDireccionLocal') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('NOM_DIRECC' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtNum_direLocal') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('NUM_CASA' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtTelefonoLocal') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('NUM_TELEFO1' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtCelularLocal') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('NUM_TELEFO1_2' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtNombreContacto') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('NOM_CONTACTO' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtDireccionContacto') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('DIRECC_CONTACTO' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtNum_direContacto') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('NUM_CASA' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtTelefonoContacto') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('TELEFO_CONTACTO' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    if ($From['name'] == 'txtCelularContacto') {
                        $creaDatosLocales = array_merge($creaDatosLocales, array('TELEFO_CONTACTO_2' => quotes_to_entities(strtoupper($From['value']))));
                    }
                    //***************************************************************************************************************************************************   
                }

                //Actualizar el numero de ficha
                if ($nuevaNFicha == 'NUEVA') {
                    $query                  =   $this->db->query($this->sql_class_ggpacientes->sqlObtieneNfichaLocal($this->tableSpace, $codEmpresa));
                    $nficha_local           =   $query->result_array();
                    $fhl                    =   $nficha_local[0]['NUMFICHALOCALMAX'] + 1;
                    $UpdateNfichaLocal      =   array('NUM_NFICHA' => $fhl);
                    $this->db->where('COD_EMPRESA', $codEmpresa);
                    $this->db->update($this->tableSpace . '.GG_TFICHA', $UpdateNfichaLocal);
                    $creaDatosLocales       =   array_merge($creaDatosLocales, array('NUM_NFICHA' => $fhl));
                } else {
                    $creaDatosLocales       =   array_merge($creaDatosLocales, array('NUM_NFICHA' => $nuevaNFicha));
                }
                //actualizar el numero de ficha

                if ($actualiza_local == '1') {
                    $sQueryPHist1	    =   '';
                    $campo1		    =   '';
                    $campo2		    =   '';
                    $campo3		    =   '';
                    $query		    =   $this->db->query($this->sql_class_ggpacientes->sqlinfoDatoLocalxHistorial($this->tableSpace,$numFichae,$codEmpresa));
                    $infoDatoLocalxHist     =   $query->result_array();
  
                    $dirCC		    =	$infoDatoLocalxHist[0]['DIRECC_CONTACTO'];
                    $dirCC		    =	str_replace("'","",$dirCC);
		    
                    //$fecFEC_AUDITA	    =   $infoRecetaxHist[0]['FEC_AUDITA'];
                    
			$SO_THISTCPACTE		=   array(
			    'COD_RUTPAC'	=>  $infoDatoLocalxHist[0]['COD_RUTPAC'], 
			    'NUM_CORPAC'	=>  $infoDatoLocalxHist[0]['NUM_CORPAC'],
			    'NUM_NFICHA'	=>  $infoDatoLocalxHist[0]['NUM_NFICHA'],
			    'NUM_AFICHA'	=>  $infoDatoLocalxHist[0]['NUM_AFICHA'],
			    'IND_ESTPAC'	=>  $infoDatoLocalxHist[0]['IND_ESTPAC'],
			    'COD_SERULA'	=>  $infoDatoLocalxHist[0]['COD_SERULA'],
			    'NUM_CORHOS'	=>  $infoDatoLocalxHist[0]['NUM_CORHOS'],
			    'COD_ULTSER'	=>  $infoDatoLocalxHist[0]['COD_ULTSER'],
			    'IND_ARCHIVO'	=>  $infoDatoLocalxHist[0]['IND_ARCHIVO'],
			    'COD_USRCREA'	=>  $infoDatoLocalxHist[0]['COD_USRCREA'],
			    'FEC_USRCREA'	=>  "TO_DATE('".$infoDatoLocalxHist[0]['FEC_USRCREA']."','DD-MM-YYYY HH24:MI:SS')",
			    'COD_USUARI'	=>  $rut,
			    'FEC_AUDITA'	=>  'SYSDATE',
			    'IND_ESTADO'	=>  $infoDatoLocalxHist[0]['IND_ESTADO'],
			    'COD_EMPRESA'	=>  $infoDatoLocalxHist[0]['COD_EMPRESA'],
			    'NOM_DIRECC'	=>  $infoDatoLocalxHist[0]['NOM_DIRECC'],
			    'NOM_CONTACTO'	=>  $infoDatoLocalxHist[0]['NOM_CONTACTO'],
			    'DIRECC_CONTACTO'   =>  $dirCC,
			    'NUM_FICHAE'	=>  $infoDatoLocalxHist[0]['NUM_FICHAE'],
			    'IND_IMPRES'	=>  $infoDatoLocalxHist[0]['IND_IMPRES'],
			    'NUM_TELEFO1_2'	=>  $infoDatoLocalxHist[0]['NUM_TELEFO1_2'],
			    'TELEFO_CONTACTO_2'	=>  $infoDatoLocalxHist[0]['TELEFO_CONTACTO_2'],
			    'NUM_TELEFO1'	=>  $infoDatoLocalxHist[0]['NUM_TELEFO1'],
			    'TELEFO_CONTACTO'	=>  $infoDatoLocalxHist[0]['TELEFO_CONTACTO'],
			    'COD_SISTEMA'	=>  $infoDatoLocalxHist[0]['COD_SISTEMA'],
			    'COD_SISTEMAUDITA'	=>  $infoDatoLocalxHist[0]['COD_SISTEMAUDITA'],
			    'COD_SECTOR'	=>  $infoDatoLocalxHist[0]['COD_SECTOR'],
			    'COD_FAMILIA'	=>  $infoDatoLocalxHist[0]['COD_FAMILIA'],
			    'NUM_CASA'		=>  $infoDatoLocalxHist[0]['NUM_CASA'],
			    'COD_VIADIRECCION'	=>  $infoDatoLocalxHist[0]['COD_VIADIRECCION'],
			    'COD_COMUNAL'	=>  $infoDatoLocalxHist[0]['COD_COMUNAL'],
			    'COD_CIUDADL'	=>  $infoDatoLocalxHist[0]['COD_CIUDADL'],
			);
			
			if ($infoDatoLocalxHist[0]['FEC_ULTASI'] != '')    {
			    $SO_THISTCPACTE	=   array_merge($SO_THISTCPACTE,array('FEC_ULTASI' => "TO_DATE('".$infoDatoLocalxHist[0]['FEC_ULTASI']."','DD-MM-YYYY HH24:MI:SS')"));
			}
			if ($infoDatoLocalxHist[0]['FEC_ULTSER'] != '')   {
			    $SO_THISTCPACTE	=   array_merge($SO_THISTCPACTE,array('FEC_IMPRES' => "TO_DATE('".$infoDatoLocalxHist[0]['FEC_ULTSER']."','DD-MM-YYYY HH24:MI:SS')"));
			}
			if ($infoDatoLocalxHist[0]['FEC_IMPRES'] != '')   {
			    $SO_THISTCPACTE	=   array_merge($SO_THISTCPACTE,array('FEC_ULTSER' => "TO_DATE('".$infoDatoLocalxHist[0]['FEC_IMPRES']."','DD-MM-YYYY HH24:MI:SS')"));
			}
			
			$this->db->insert($this->tableSpace . '.SO_THISTCPACTE', $SO_THISTCPACTE);
			
			
                    $this->db->where('COD_EMPRESA', $codEmpresa);
                    $this->db->where('NUM_FICHAE', $numFichae);
                    $this->db->update($this->tableSpace . '.SO_TCPACTE', $creaDatosLocales);
		    
                } else {
		    
                    $query		            =   $this->db->query($this->sql_class_ggpacientes->sqlObtieneNCORPAC($this->tableSpace, $codEmpresa));
                    $LastNCORPAC	        =   $query->result_array();
                    if(isset($LastNCORPAC[0]['NUM_CORREL'])) {
                        $NUM_CORREL	        =   $LastNCORPAC[0]['NUM_CORREL'] + 1;
                        $UpdateNfichaLocal  =   array('NUM_CORREL' => $NUM_CORREL, 'COD_SISTEMA' => '58');
                        $this->db->where('ID_CORREL','CORPAC');
                        $this->db->where('COD_EMPRESA',$codEmpresa);
                        $this->db->update($this->tableSpace.'.GG_TCORREL', $UpdateNfichaLocal);
                    } else {
                        $NUM_CORREL	        =   '1';
                        $UpdateNfichaLocal  =   array('COD_EMPRESA' => $codEmpresa, 'NUM_CORREL' => $NUM_CORREL, 'ID_CORREL' => 'CORPAC', 'COD_SISTEMA' => '58');
                        $this->db->insert($this->tableSpace.'.GG_TCORREL', $UpdateNfichaLocal);
                    }
                    
                    $creaDatosLocales = array_merge($creaDatosLocales, array('NUM_CORPAC' => $NUM_CORREL));
                    $this->db->insert($this->tableSpace.'.SO_TCPACTE', $creaDatosLocales);
		        }

		
            } else if ($infObject == 'DatosPrevisionales') {
                if ($Previ == 1) {
                    $creaDatosPrevi             = array();
                    $rutTitular                 = '';
                    $datosProfesionales         = $Object[0]['From_Previsiones'];
                    foreach ($datosProfesionales as $i => $From) {
                        if ($From['name'] == 'txtRuttit') {
                            $creaDatosPrevi = array_merge($creaDatosPrevi, array('COD_RUTTIT' => quotes_to_entities(strtoupper($From['value']))));
                            $rutTitular = $From['value'];
                        }
                        if ($From['name'] == 'txtDvtit') {
                            $creaDatosPrevi = array_merge($creaDatosPrevi, array('COD_DIGVER' => quotes_to_entities(strtoupper($From['value']))));
                        }
                        if ($From['name'] == 'txtNombretit') {
                            $creaDatosPrevi = array_merge($creaDatosPrevi, array('NOM_NOMBRE' => quotes_to_entities(strtoupper($From['value']))));
                        }
                        if ($From['name'] == 'txtApellidoPaternotit') {
                            $creaDatosPrevi = array_merge($creaDatosPrevi, array('NOM_APEPAT' => quotes_to_entities(strtoupper($From['value']))));
                        }
                        if ($From['name'] == 'txtApellidoMaternotit') {
                            $creaDatosPrevi = array_merge($creaDatosPrevi, array('NOM_APEMAT' => quotes_to_entities(strtoupper($From['value']))));
                        }
                        if ($From['name'] == 'cboPrevision') {
                            $creaDatosPrevi = array_merge($creaDatosPrevi, array('IND_PREVIS' => quotes_to_entities(strtoupper($From['value']))));
                        }
                        if ($From['name'] == 'cboEmpresaPrevision') {
                            $creaDatosPrevi = array_merge($creaDatosPrevi, array('NUM_RUTINS' => quotes_to_entities(strtoupper($From['value']))));
                        }
                    }
		    
                    $query = $this->db->query($this->sql_class_ggpacientes->sqlTraeDatosTitularxRut($this->tableSpace, $rutTitular));
                    $LastNCORPAC= $query->result_array();
                    if (count($LastNCORPAC)>0) {
                        $cod_titulocompara = $LastNCORPAC[0]['COD_RUTTIT'];
                    } else {
                        $cod_titulocompara = '';
                    }

		    
                    if ($cod_titulocompara == '') {
                        $creaDatosPrevi = array_merge($creaDatosPrevi, array('COD_USRCREA'  =>  $session));
                        $creaDatosPrevi = array_merge($creaDatosPrevi, array('FEC_USRCREA'  =>  'SYSDATE'));
                        $creaDatosPrevi = array_merge($creaDatosPrevi, array('COD_USUARI'   =>  $session));
                        $creaDatosPrevi = array_merge($creaDatosPrevi, array('FEC_AUDITA'   =>  'SYSDATE'));
                        $creaDatosPrevi = array_merge($creaDatosPrevi, array('IND_ESTADO'   =>  'V'));
                        $this->db->insert($this->tableSpace . '.SO_TTITUL', $creaDatosPrevi);
                    } else {
                        $creaDatosPrevi = array_merge($creaDatosPrevi, array('FEC_USRCREA'  =>  'SYSDATE'));
                        $creaDatosPrevi = array_merge($creaDatosPrevi, array('COD_USUARI'   =>  $session));
                        $creaDatosPrevi = array_merge($creaDatosPrevi, array('FEC_AUDITA'   =>  'SYSDATE'));
                        $this->db->where('COD_RUTTIT', $rutTitul);
                        $this->db->update($this->tableSpace . '.SO_TTITUL', $creaDatosPrevi);
                    }
                    
                    
                }
            }
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status() . "#" . $numFichae;
    }

   
    //AQUi EMPIEZA LA MAGIA 
    public function getbusquedaCertificadoFONASA($elrut, $eldv) {

        $respuesta = "";
        $descr_error = "";
        $fecha_nacimiento = "";
        $fecha = "";
        $hayactualiza = "";
        $oParametros = "";
        $des_codigobloqueo = "";
        $rutafilifonosa = "";
        $rut = "";
        $cabezeraFonasa = "";

        $param_CertificadorPrevisional = array('queryTO' => array('tipoEmisor' => 10, 'tipoUsuario' => 1));
        $param_CertificadorPrevisional += array('entidad' => '61955100');
        $param_CertificadorPrevisional += array('claveEntidad' => '6195');
        $param_CertificadorPrevisional += array('rutBeneficiario' => $elrut);
        $param_CertificadorPrevisional += array('dgvBeneficiario' => $eldv);
        $param_CertificadorPrevisional += array('canal' => 10);

        $p_CertificadorPrevisional = array('query' => $param_CertificadorPrevisional);
        $wsdl = APPPATH . 'models/ClassFonasa/CertificadoPrevisional.wsdl';
        $request = array('parameters' => $p_CertificadorPrevisional);
        $client = new nusoap_client($wsdl, true, '');
        $err = $client->getError();
        $ind_previ = '';
        if ($err) {
            $respuesta.='<h2>Mensaje de error</h2><pre>' . $err . '</pre>';
        }
        $resultado = $client->call(
                'getCertificadoPrevisional', $request, 'http://certificadorprevisional.fonasa.gov.cl.ws/', 'http://certificadorprevisional.fonasa.gov.cl.ws/getCertificadoPrevisional', false, true
        );

        if ($client->fault) {
            $respuesta.='<h2>Mensaje de error</h2><pre>FALLO CLIENTE COMUNICACION</pre>';
        } else {
            //Check for errors
            $err = $client->getError();
            if ($err) {
                // Display the error
                $respuesta .= '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                //print_r($resultado);
                if ($resultado != null) {
                    $oParametros = new stdClass();
                    $fecha = $resultado['getCertificadoPrevisionalResult']['replyTO']['fecha'];
                    $fecaux = substr($fecha, 0, 8);
                    $hor_aux = substr($fecha, 8, 14);
                    $ano = substr($fecaux, 0, 4);
                    $mes = substr($fecaux, 4, 2);
                    $dia = substr($fecaux, 6, 2);
                    $fecha_consulta = $dia . "/" . $mes . "/" . $ano;
                    $Hora = substr($hor_aux, 0, 2);
                    $min = substr($hor_aux, 2, 2);
                    $ss = substr($hor_aux, 4, 2);
                    $hora_consulta = $Hora . ":" . $min . ":" . $ss;

                    $oParametros->replyTOFecha = $fecha_consulta . ' ' . $hora_consulta;
                    $cod_estado = $resultado['getCertificadoPrevisionalResult']['replyTO']['estado']; //0:exito,9:error del servicio,-1:error conectividad con servico externo,-2:error interno,-3el rut n es beneficiario,-4 el rut no exiet en fonasa
                    $oParametros->replyTOEstado = $cod_estado;

                    switch ($cod_estado) {
                        case "-1":
                            $accion = 0;
                            //error en conetividad con servicio externo
                            $cod_cybl = '1';
                            $descr_error = $resultado['getCertificadoPrevisionalResult']['replyTO']['errorM'];
                            break;
                        case "-2":
                            $accion = 0;
                            //error interno
                            $cod_cybl = '2';
                            $descr_error = $resultado['getCertificadoPrevisionalResult']['replyTO']['errorM'];
                            break;
                        case "-3":
                            $accion = 0;
                            //rut no es beneficiario o no esta registrado en fonasa
                            $cod_cybl = '3';
                            $descr_error = $resultado['getCertificadoPrevisionalResult']['replyTO']['errorM'];
                            break;
                        case "-4" :
                            $accion = 0;
                            //rut no registrado
                            $cod_cybl = '4';
                            $descr_error = $resultado['getCertificadoPrevisionalResult']['replyTO']['errorM'];
                            break;
                        case "9" :
                            $accion = 0;
                            //rut no registrado
                            $cod_cybl = '9';
                            $descr_error = $resultado['getCertificadoPrevisionalResult']['replyTO']['errorM'];
                            break;
                        case "-31" :
                            $accion = 0;
                            //rut no registrado
                            $cod_cybl = '31';
                            $descr_error = 'ERROR DE CONECTIVIDAD';
                            break;
                        case "0";
                            $accion = 1;
                            break;
                    }


                    $oParametros->replyTOError = $descr_error;
                    $ind_previ = '';
                    $hayactualiza = 0;
                    //$oTit = parent::executeSelect(SqlFonasa::sqlgetTitular($this->tableSpace, $elrut), 2);
                    $oTit = $this->db->query($this->sql_class_ggpacientes->sqlgetTitular($this->tableSpace, $elrut))->result_array();
                    if (sizeof($oTit) > '0') {
                        $rut = $oTit[0]["RUTITULAR"];
                        if ($rut != '') {
                            $oTitPrevi = $this->db->query($this->sql_class_ggpacientes->sqlEsTitularSSAN($this->tableSpace, $rut))->result_array();
                            //$oTitPrevi        = parent::executeSelect(SqlFonasa::sqlEsTitularSSAN($this->tableSpace, $rut), 2); //consulta alctual prevision en SSAN
                            if (sizeof($oTitPrevi) > 0) {
                                $ind_previ = $oTitPrevi[0]["CAMPO1"];
                            }
                        } else {
                            $ind_previ = 'SP';
                        }
                    } else {
                        //Sin Titular Asignado
                        $ind_previ = 'SP';
                        $hayactualiza = 1;
                    }

                    $oParametros->bTOTramo = $ind_previ;

                    if (isset($resultado['getCertificadoPrevisionalResult']['numeroCarga'])) {
                        $contador = $resultado['getCertificadoPrevisionalResult']['numeroCarga'];
                    } else {
                        $contador = 0;
                    }

                    if (isset($resultado['getCertificadoPrevisionalResult']['codigoprais'])) {
                        $prais = $resultado['getCertificadoPrevisionalResult']['codigoprais'];
                    } else {
                        $prais = '000';
                    }

                    if (isset($resultado['getCertificadoPrevisionalResult']['descprais'])) {
                        $des_prais = $resultado['getCertificadoPrevisionalResult']['descprais'];
                    } else {
                        $des_prais = 'NO BENEFICIARIO';
                    }

                    $oParametros->NumeroCarga = $contador;
                    $oParametros->CodigoPrais = $prais;
                    if ($prais == '000') {
                        $des_prais = 'NO BENEFICIARIO';
                    }
                    $oParametros->Des_Prais = $des_prais;


                    if (isset($resultado['getCertificadoPrevisionalResult']['afiliadoTO']['tramo'])) {
                        $tramo = $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['tramo'];
                        $tramows = $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['tramo'];
                    } else {
                        $tramo = '';
                        $tramows = '';
                    }
                    if ($accion == 1) {

                        $cod_cybl = $resultado['getCertificadoPrevisionalResult']['codcybl'];
                        $des_codigobloqueo = $resultado['getCertificadoPrevisionalResult']['coddesc'];

                        //$ind_previ = $tramo;
                        if ($tramo != '') {
                            $oParametros->AfiliadoTramo = $tramo;
                            if ($ind_previ != $tramo) {
                                $hayactualiza = 1;
                            }
                            $tramo = 'FONASA ' . $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['tramo'];
                        } else {
                            if ($cod_cybl == '01903') {
                                //bloueado por cotizacion
                                if ($prais == '111') {
                                    $oParametros->AfiliadoTramo = 'R';
                                } else {
                                    $oParametros->AfiliadoTramo = 'BF';
                                }
                                $tramo = $des_codigobloqueo;
                                $hayactualiza = 1;
                            } else {
                                //es isapre u otro
                                if ($ind_previ != '') {
                                    //es isapre u otro
                                    $ind_previ = '';
                                    $oParametros->AfiliadoTramo = $tramows;
                                    $hayactualiza = 1;
                                } else {
                                    //no existe en base titutl
                                    $oParametros->AfiliadoTramo = $tramows;
                                    $hayactualiza = 1;
                                }
                            }
                        }

                        $prais = $prais . ' - ' . $des_prais;




                        $folio = $resultado['getCertificadoPrevisionalResult']['folio'];
                        $oParametros->Folio = $folio;
                        $oParametros->CodBloqueo = $cod_cybl;
                        $oParametros->Des_CodBloqueo = $des_codigobloqueo;
                        $oParametros->CdgIsapre = $resultado['getCertificadoPrevisionalResult']['cdgIsapre'];
                        $oParametros->DesIsapre = $resultado['getCertificadoPrevisionalResult']['desIsapre'];

                        $respuesta .='<table width="681" id="newspaper-a" class="table table-striped table-inverse">
                                            <thead>
                                                <th colspan="2" width="681" class="info" style="text-align:center">CERTIFICADO CONSULTA - ' . $des_codigobloqueo . '</th>
                                            <tbody>
                                        </table>
                                        <table border="1" class="table table-striped table-inverse">
                                            <tr class="alt2">
                                                <td class="info" colspan="2"><b>DATOS CONSULTA FONASA<b></td><tr>
                                                <tr class=""><td class="formulario" width="191">[N Folio]</td><td width="478" class="formulario">' . $folio . '</td>
                                            <tr>
                                            <tr class="">
                                                <td class="formulario" width="191">[Fecha Emision]</td>
                                                <td width="478" class="formulario">' . $fecha_consulta . '</td>
                                            <tr>
                                        ';

                        $fec_nacimi = $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['fechaNacimiento'];
                        $fecha_nacimiento = explode("-", $fec_nacimi);
                        $dia_nacimi = $fecha_nacimiento[2];
                        $mes_nacimi = $fecha_nacimiento[1];
                        $ano_nacimi = $fecha_nacimiento[0];
                        $fec_afiliado_vac = $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['fecnac'];
                        $rutafilifonosa = $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['rutafili'];
                        $fecha = "";

                        if (isset($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['fecha'])) {
                            $fecha = $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['fecha'];
                        } else {
                            $fecha = "NO INFORMADA";
                        }
                        //beneficiario
                        $oParametros->bTORut = $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['rutbenef'];
                        $oParametros->bTORutDv = $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['dgvbenef'];
                        $oParametros->bTONombres = utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['nombres']);
                        $oParametros->bTOApell1 = utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['apell1']);
                        $oParametros->bTOApell2 = utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['apell2']);
                        $oParametros->bTOSexo = $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['generoDes'];
                        $oParametros->bTOFecNacimi = $fec_nacimi;
                        $oParametros->bTOFecFall = $fecha;
                        $oParametros->bTONacionalidad = $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['desNacionalidad'];
                        $oParametros->bTODireccion = utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['direccion']);
                        $oParametros->bTOCodRegion = $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['cdgRegion'];
                        $oParametros->bTOCodComuna = $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['cdgComuna'];
                        $oParametros->bTOTelefono = $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['telefono'];
                        //afiliado
                        $fecha_nacimiento = explode("-", $fec_afiliado_vac);
                        $dia_nacimi_afi = $fecha_nacimiento[2];
                        $mes_nacimi_afi = $fecha_nacimiento[1];
                        $ano_nacimi_afi = $fecha_nacimiento[0];
                        $oParametros->AfiliadoRut = $rutafilifonosa;
                        $oParametros->AfiliadoRutDv = $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['dgvafili'];
                        $oParametros->AfiliadoNombres = utf8_encode($resultado['getCertificadoPrevisionalResult']['afiliadoTO']['nombres']);
                        $oParametros->AfiliadoApell1 = utf8_encode($resultado['getCertificadoPrevisionalResult']['afiliadoTO']['apell1']);
                        $oParametros->AfiliadoApell2 = utf8_encode($resultado['getCertificadoPrevisionalResult']['afiliadoTO']['apell2']);
                        $oParametros->Afiliadofecnac = $dia_nacimi_afi . '/' . $mes_nacimi_afi . '/' . $ano_nacimi_afi;
                        $oParametros->AfiliadoSexo = $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['genero'];
                        $oParametros->AfiliadoFoCdEstado = $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['cdgEstado'];
                        $oParametros->AfiliadoFoEstado = $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['desEstado'];


                        $respuesta.='<tr class="info"><td class="infocama" colspan="2"><b>DATOS BENEFICIARIO<b></td><tr>
                                        <tr ><td class="formulario">[Rut Beneficiado]</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['rutbenef'] . '-' . $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['dgvbenef'] . '</td><tr>
                                        <tr ><td class="formulario">[Nombre Beneficiado]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['nombres']) . '</td><tr>
                                        <tr ><td class="formulario">[Apellido Paterno Beneficiado]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['apell1']) . '</td><tr>
                                        <tr ><td class="formulario">[Apellido Materno Beneficiado]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['apell2']) . '</td><tr>
                                        <tr ><td class="formulario">[Nacimiento Beneficiado]</td><td class="formulario">' . $dia_nacimi . '/' . $mes_nacimi . '/' . $ano_nacimi . '</td><tr>
                                        <tr ><td class="formulario">[Sexo]</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['generoDes'] . '</td><tr>
                                        <tr ><td class="formulario">[Fecha Fallecimiento]</td><td class="formulario">' . $fecha . '</td><tr>
                                        <tr ><td class="formulario">[Nacionalidad]</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['desNacionalidad'] . '</td><tr>
                                        <tr ><td class="formulario">[Direcci&oacute;n]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['direccion']) . '</td><tr>
                                        <tr ><td class="formulario">[Regi&oacute;n]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['desRegion']) . '</td><tr>
                                        <tr ><td class="formulario">[Comuna]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['desComuna']) . '</td><tr>
                                        <tr ><td class="formulario">[Tel&eacute;fono]</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['beneficiarioTO']['telefono'] . '</td><tr>
                                        <tr class="info"><td class="infocama" colspan="2"><b>DATOS AFILIADO<b></td><tr>
                                        <tr ><td class="formulario">[Rut Afiliado]</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['rutafili'] . '-' . $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['dgvafili'] . '</td><tr>
                                        <tr ><td class="formulario">[Nombres]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['afiliadoTO']['nombres']) . '</td><tr>
                                        <tr ><td class="formulario">[Apellido Paterno]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['afiliadoTO']['apell1']) . '</td><tr>
                                        <tr ><td class="formulario">[Apellido Materno]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['afiliadoTO']['apell2']) . '</td><tr>
                                        <tr ><td class="formulario">[Nacimiento]</td><td class="formulario">' . $dia_nacimi_afi . '/' . $mes_nacimi_afi . '/' . $ano_nacimi_afi . '</td><tr>
                                        <tr ><td class="formulario">[Tramo]</td><td class="formulario"><b>' . $tramo . '<b></td><tr>
                                        <tr ><td class="formulario">[G&eacute;nero]</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['generoDes'] . '</td><tr>
                                        <tr ><td class="formulario">[PRAIS]</td><td class="formulario"><b>' . $prais . '<b></td><tr>
                                        <tr ><td class="formulario">[N&uacute;mero de Cargas]</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['numeroCarga'] . '</td><tr>
                                        <tr ><td class="formulario">[Estado]</td><td class="formulario"><b>' . $resultado['getCertificadoPrevisionalResult']['afiliadoTO']['desEstado'] . '<b></td><tr>';

                        if ($resultado['getCertificadoPrevisionalResult']['codcybl'] == '01901') {
                            $respuesta .= ' <tr ><td class="formulario">[C&oacute;digo Isapre]</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['cdgIsapre'] . '</td><tr>
                                            <tr ><td class="formulario">[Descripci&oacute;n Isapre]</td><td class="formulario"><b>' . $resultado['getCertificadoPrevisionalResult']['desIsapre'] . '<b></td><tr>';
                        }

                        $respuesta .= '<tr class="info"><td class="infocama" colspan="2"><b>CARGAS DEL AFILIADO <b></td><tr>';
                        if ($contador == 1) {
                            $respuesta .= '<tr ><td class="formulario">[Rut ]</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO']['rutcarga'] . '-' . $resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO']['dgvcarga'] . '</td><tr>
                                                <tr ><td class="formulario">[Nombres]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO']['nombres']) . '</td><tr>
                                                <tr ><td class="formulario">[Apellido Paterno]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO']['apell1']) . '</td><tr>
                                                <tr ><td class="formulario">[Apellido Materno]</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO']['apell2']) . '</td><tr>
                                                ';
                        } else {
                            if ($contador <> 0) {
                                $idcarga = 1;
                                for ($rango = 0; $rango < $contador; $rango++) {
                                    $respuesta .= '	<tr ><td class="formulario">[Rut  ' . $idcarga . ']</td><td class="formulario">' . $resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO'][$rango]['rutcarga'] . '-' . $resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO'][$rango]['dgvcarga'] . '</td><tr>
                                                <tr ><td class="formulario">[Nombres  ' . $idcarga . ']</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO'][$rango]['nombres']) . '</td><tr>
                                                <tr ><td class="formulario">[Apellido Paterno  ' . $idcarga . ']</td><td class="formulario">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO'][$rango]['apell1']) . '</td><tr>
                                                <tr ><td class="formulario">[Apellido Materno ' . $idcarga . ']</td><td class="infocama">' . utf8_encode($resultado['getCertificadoPrevisionalResult']['listCargas']['CargasTO'][$rango]['apell2']) . '</td><tr>
                                            ';
                                    $idcarga++;
                                }
                            }
                        }
                        $respuesta .= '</table>';
                    } else {
                        //else accion != 1
                        //print_r($resultado);
                        $folio = '-';
                        $hayactualiza = 0;
                        $rut = '';
                        $rutafilifonosa = '';
                        $oParametros = null;
                        $des_codigobloqueo = null;
                        $respuesta .= '<table width="681" id="newspaper-a" class="table table-striped table-inverse">
                                            <thead>
                                                <th colspan="2" width="681" align="center">RESPUESTA CONSULTA - ' . $descr_error . '</th>
                                            <tbody>
                                        </table>
                                        <table border="1" class="table table-striped table-inverse">
                                            <tr class="alt2"><td class="infocama" colspan="2"><b>DATOS CONSULTA FONASA<b></td><tr>
                                            <tr class=""><td class="formulario" width="191">[N Folio]</td><td width="478" class="formulario">' . $folio . '</td><tr>
                                            <tr class=""><td class="formulario" width="191">[Fecha Emisi&oacute;n]</td><td width="478" class="formulario">' . $fecha_consulta . '</td><tr>
                                        </table>
                                        ';
                    }
                }//fin resultado != null
            }//fin si error 
        }//fin respuesta
        //$fonasa["respuesta"]    = $respuesta;
        $fonasa["estado"] = $hayactualiza;
        $fonasa["datosXws"] = $oParametros;
        $fonasa["ruttit"] = $rut;
        $fonasa["ruttitfo"] = $rutafilifonosa;
        $fonasa["titulof"] = $des_codigobloqueo;
        $fonasa["tablaFon"] = $respuesta;

        return $fonasa;
    }

    
    
    
    public function get_ActualizaFonasa($elrut,$eldg,$oParametros,$usergraba) {
        $fecha                      =   $oParametros->replyTOFecha;
        $ind_previs                 =   '';
        $ind_fallecido              =   0;
        $cod_estado                 =   $oParametros->replyTOEstado; //0:exito,9:error del servicio,-1:error conectividad con servico externo,-2:error interno,-3el rut n es beneficiario,-4 el rut no exiet en fonasa
        switch ($cod_estado) {
            case "-1":
                $accion = 0;
                //error en conetividad con servicio externo
                $cod_cybl = '1';
                break;
            case "-2":
                $accion = 0;
                //error interno
                $cod_cybl = '2';
                break;
            case "-3":
                $accion = 0;
                $cod_cybl = '3';
                break;
            case "-4" :
                $accion = 0;
                //rut no registrado
                $cod_cybl = '4';
                break;
            case "9" :
                $accion = 0;
                //rut no registrado
                $cod_cybl = '9';
                break;
            case "0";
                $accion = 1;
                break;
        }
        
        //**********************************************************************
        #BUSCA SI ES PACIENTE ESTA EN LA BD DE SSAN
        $grabo                      =   0;
        $descr_error                =   $oParametros->replyTOError;
        $rut                        =   '0';//sin titular asignado
        $existetit                  =   0;
        $updtitular                 =   '';//pa algo
        $elrut                      =   trim($elrut); //Elimina espacio en blanco
        $oTit                       =   $this->db->query($this->sql_class_ggpacientes->sqlgetTitular($this->tableSpace,$elrut))->result_array();
        if (count($oTit)>'0'){
            $rut                    =   $oTit[0]["RUTITULAR"];
            if ($rut!='0'){
                $existetit          =   1;
            }
            $espacientessan         =   1;
        } else {
            //no es paciente registrado
            $espacientessan         =   0;
        }
        $rut                        =   trim($rut);
        #data fonasa con datos
        if ($accion == 1) {
            $this->db->trans_start();
            $folio                  =   isset($oParametros->Folio)?$oParametros->Folio:'';
            $cod_cybl               =   isset($oParametros->CodBloqueo)?$oParametros->CodBloqueo:'';
            $des_codigobloqueo      =   isset($oParametros->Des_CodBloqueo)?$oParametros->Des_CodBloqueo:'';
            $cond_prais             =   isset($oParametros->CodigoPrais)?$oParametros->CodigoPrais:'';
            //actaulizacion de genereo por Fonasa
            $ind_tisexo             =   isset($oParametros->bTOIdSexo)?$oParametros->bTOIdSexo:'';
            $condprais              =   $cond_prais=='111'?1:0;
            #actualiza datos generares prais
            if($espacientessan == '1') {
                $update_pacte           =   array(
                    "IND_CONDPRAIS"     =>  $condprais, 
                    "COD_USUARI"        =>  $usergraba,
                    "IND_TISEXO"        =>  $ind_tisexo,
                    "FEC_AUDITA"        =>  'SYSDATE',
                );
                $this->db->where('COD_RUTPAC',$elrut);
                $this->db->update($this->tableSpace.'.GG_TGPACTE',$update_pacte);
            }
            #busca rut titular
            $bloqueo_pacte              =   0;
            #si bloqueo es aceptado se actualiza informacion
            #SqlFonasaDao::sqlCodBloqueoFo
            $oBloq                      =   $this->db->query("SELECT IND_TIPOBLOQUEO AS CAMPO1 FROM  ADMIN.GG_TBLOQFONASA WHERE COD_BLOQUEO IN ($cod_cybl) AND IND_TIPOBLOQUEO IS NOT NULL ")->result_array();
            if(count($oBloq)>0){
                $tipobloqueo            =   $oBloq[0]['CAMPO1'];
                switch ($tipobloqueo) {
                    case "1": //isapre
                        $bloqueo_pacte  =   1;
                        $rutempresa     =   '61955100';
                        break;
                    case "2"://fallecido
                        $bloqueo_pacte  =   2;
                        break;
                    case "3": //indipendiente, cancela
                        $bloqueo_pacte  =   1;
                        break;
                    case "4": //FONASA
                        $bloqueo_pacte  =   0;
                        $rutempresa     =   '61603000';
                        break;
                    case "5": //capredena
                        $bloqueo_pacte  =   1;
                        $rutempresa     =   '61108000';
                        break;
                    case "6": //dipreca
                        $bloqueo_pacte  =   1;
                        $rutempresa     =   '61513000';
                        break;
                }//FIN SWITCH
            } else {
                $num = (int) $cod_cybl;
                if ($num < 1900) {//BLOQUEO DE FONSASA 4
                    $bloqueo_pacte                  =   1;
                    $arr_insert_tblofonasa          =   array(
                        "COD_BLOQUEO"               =>  $cod_cybl,
                        "DES_BLOQUEO"               =>  $des_codigobloqueo,
                        "IND_TIPOBLOQUEO"           =>  '4',
                    );
                    $this->db->insert($this->tableSpace.'.GG_TBLOQFONASA',$arr_insert_tblofonasa);
                }
            }
            
            if ($bloqueo_pacte == "0") {
                if ($cod_cybl == '00110') {   $bloqueo_pacte = 1;  }
                if ($cod_cybl == '00131') {   $bloqueo_pacte = 1;  }
            }
            
            $existetitafil              =   0;
            if ($bloqueo_pacte == "1") {
                $rutafili               =   $oParametros->AfiliadoRut; //rut del titular
                $dgvafili               =   $oParametros->AfiliadoRutDv;
                $nombretit              =   trim(utf8_decode($oParametros->AfiliadoNombres)); //nombre del titular
                $nombretit              =   str_replace("'", "", $nombretit);
                $apell1tit              =   trim(utf8_encode($oParametros->AfiliadoApell1)); //ape1 del titular
                $apell2tit              =   trim(utf8_encode($oParametros->AfiliadoApell2)); //ape1 del titular
                $ind_previs             =   trim($oParametros->AfiliadoTramo); //tramo fonasa
                $fecnacto_afiliado      =   $oParametros->Afiliadofecnac;
                $genero                 =   $oParametros->AfiliadoSexo;
                $nombretit              =   utf8_encode($nombretit);
                $apell1tit              =   utf8_encode($apell1tit);
                $apell2tit              =   utf8_encode($apell2tit);
                $rutafili               =   trim($rutafili);
                
                //consulta titutal														
                //error_log('es titular...'.$existetit.$ind_previs);
                
                $oTit                                   =   $this->db->query($this->sql_class_ggpacientes->sqlEsTitularSSAN($this->tableSpace, $rutafili))->result_array();
                if(count($oTit)>0){
                    $estitul                            =   $oTit[0]["CAMPO1"];
                    $existetitafil                      =   1;
                    #SqlFonasaDao::sqlInfoTitularSSAN
                    $infoTit                            =   $this->db->query($this->sql_class_ggpacientes->sqlInfoTitularSSAN($this->tableSpace,$rutafili))->result_array();
                    #grabamos historial del titular
                    if(count($infoTit)>0){
                        $arr_so_thist_titul             =   array(
                            "COD_RUTTIT"                =>  $rutafili,
                            "COD_DIGVER"                =>  $infoTit[0]["CAMPO2"],
                            "NOM_NOMBRE"                =>  $infoTit[0]["CAMPO3"],
                            "NOM_APEPAT"                =>  $infoTit[0]["CAMPO4"],
                            "NOM_APEMAT"                =>  $infoTit[0]["CAMPO5"],
                            "IND_PREVIS"                =>  $infoTit[0]["CAMPO6"],
                            "NUM_RUTINS"                =>  $infoTit[0]["CAMPO7"],
                            "IND_ESTADO"                =>  $infoTit[0]["CAMPO8"],
                            "COD_USRCREA"               =>  $infoTit[0]["CAMPO9"],
                            "FEC_USRCREA"               =>  "TO_DATE('".$infoTit[0]["CAMPO10"]."','DD/MM/YYYY hh24:mi:ss')",  
                            "COD_USUARI"                =>  $infoTit[0]["CAMPO11"],
                            "FEC_AUDITA"                =>  "TO_DATE('".$infoTit[0]["CAMPO12"]."','DD/MM/YYYY hh24:mi:ss')",  
                            "FEC_VENCLA"                =>  "TO_DATE('".$infoTit[0]["CAMPO13"]."','DD/MM/YYYY hh24:mi:ss')", 
                            "NUM_RUTEMP"                =>  $infoTit[0]["CAMPO14"],
                            "CAN_PACIEN"                =>  $infoTit[0]["CAMPO15"],
                            "COD_ESTABL"                =>  $infoTit[0]["CAMPO16"],
                            "COD_EMPRESA"               =>  $infoTit[0]["CAMPO17"],
                            "CREDENCIAL"                =>  $infoTit[0]["CAMPO18"],
                            "DES_BLOQUEO"               =>  $infoTit[0]["CAMPO19"],
                            "FEC_MODIFICA"              =>  "TO_DATE('".$infoTit[0]["CAMPO20"]."','DD/MM/YYYY hh24:mi:ss')", 
                        );
                        $this->db->insert($this->tableSpace.'.SO_THIST_TITUL',$arr_so_thist_titul);
                    }
                } else {
                    #ver si el rut esta registrado como titutal
                    $oTitelrut                          =   $this->db->query($this->sql_class_ggpacientes->sqlEsTitularSSAN($this->tableSpace,$rut))->result_array();
                    if (count($oTitelrut)>'0'){
                        $existetitafil                  =   1;
                        $infoTit                        =   $this->db->query($this->sql_class_ggpacientes->sqlInfoTitularSSAN($this->tableSpace,$rut))->result_array();
                        #grabamos historial del titular
                        if(count($infoTit)>0){
                            $arr_so_thist_titul             =   array(
                                "COD_RUTTIT"                =>  $rutafili,
                                "COD_DIGVER"                =>  $infoTit[0]["CAMPO2"],
                                "NOM_NOMBRE"                =>  $infoTit[0]["CAMPO3"],
                                "NOM_APEPAT"                =>  $infoTit[0]["CAMPO4"],
                                "NOM_APEMAT"                =>  $infoTit[0]["CAMPO5"],
                                "IND_PREVIS"                =>  $infoTit[0]["CAMPO6"],
                                "NUM_RUTINS"                =>  $infoTit[0]["CAMPO7"],
                                "IND_ESTADO"                =>  $infoTit[0]["CAMPO8"],
                                "COD_USRCREA"               =>  $infoTit[0]["CAMPO9"],
                                "FEC_USRCREA"               =>  "TO_CHAR('".$infoTit[0]["CAMPO10"]."','DD/MM/YYYY hh24:mi:ss')",  
                                "COD_USUARI"                =>  $infoTit[0]["CAMPO11"],
                                "FEC_AUDITA"                =>  "TO_CHAR('".$infoTit[0]["CAMPO12"]."','DD/MM/YYYY hh24:mi:ss')",  
                                "FEC_VENCLA"                =>  "TO_DATE('".$infoTit[0]["CAMPO13"]."','DD/MM/YYYY hh24:mi:ss')",
                                "NUM_RUTEMP"                =>  $infoTit[0]["CAMPO14"],
                                "CAN_PACIEN"                =>  $infoTit[0]["CAMPO15"],
                                "COD_ESTABL"                =>  $infoTit[0]["CAMPO16"],
                                "COD_EMPRESA"               =>  $infoTit[0]["CAMPO17"],
                                "CREDENCIAL"                =>  $infoTit[0]["CAMPO18"],
                                "DES_BLOQUEO"               =>  $infoTit[0]["CAMPO19"],
                                "FEC_MODIFICA"              =>  "TO_CHAR('".$infoTit[0]["CAMPO20"]."','DD/MM/YYYY hh24:mi:ss')", 
                            );
                            $this->db->insert($this->tableSpace.'.SO_THIST_TITUL',$arr_so_thist_titul);
                        }
                    } else {
                        $existetitafil                      = 0;
                    }
                }
                
                if ($ind_previs == '') {  $ind_previs = 'SP';  }
                
                $grabo              =   1;
                switch ($ind_previs) {//paciente es fonasa
                    case "A":
                    case "B":
                    case "C":
                    case "D":
                        //verificar si es titular
                        if ($rutafili == $rut) {//es titular, se actualiza solo el tramo
                                #SqlFonasaDao::sqlEsTitularSSAN
                                $oExiste                        =   $this->db->query($this->sql_class_ggpacientes->sqlEsTitularSSAN($this->tableSpace,$rutafili))->result_array();
                            if(count($oExiste)>0) {
                                $arr_update_so_ttitul           =   array(
                                    "IND_PREVIS"                =>  $ind_previs,
                                    "DES_BLOQUEO"               =>  $des_codigobloqueo,
                                    "NUM_RUTINS"                =>  '61603000',
                                    "COD_USUARI"                =>  $usergraba,
                                    "NOM_APEMAT"                =>  $apell2tit,
                                    "NOM_NOMBRE"                =>  $nombretit,
                                    "NOM_APEPAT"                =>  $apell1tit,
                                    "IND_ESTADO"                =>  'V',
                                    "FEC_AUDITA"                =>  'SYSDATE',
                                );
                                $this->db->where('COD_RUTTIT',$rut);
                                $this->db->update($this->tableSpace.'.SO_TTITUL',$arr_update_so_ttitul);
                                error_log('actualizazo rut..: ' . $rut);
                            } else {
                                #SE AGREGA A TABLA TITUL
                                $arr_insert_so_ttitul           =   array(
                                    "COD_RUTTIT"                =>  $rutafili,
                                    "COD_DIGVER"                =>  $dgvafili,
                                    "NOM_NOMBRE"                =>  $nombretit,
                                    "NOM_APEPAT"                =>  $apell1tit,
                                    "NOM_APEMAT"                =>  $apell2tit,
                                    "IND_PREVIS"                =>  $ind_previs,
                                    "NUM_RUTINS"                =>  '61603000',
                                    "IND_ESTADO"                =>  'V',
                                    "DES_BLOQUEO"               =>  $des_codigobloqueo,
                                    "COD_USRCREA"               =>  $usergraba,
                                    "FEC_USRCREA"               =>  'SYSDATE',
                                    "COD_USUARI"                =>  $usergraba,
                                    "FEC_AUDITA"                =>  'SYSDATE',
                                );
                                $this->db->insert($this->tableSpace.'.SO_TTITUL',$arr_insert_so_ttitul);
                            }
                        } else {
                            #actualizar gg_tcpacte y verificar que existe el nuevo titular en la tabla so_titul
                            #actualiza gg_tgpacte
                            if ($espacientessan == '1') {
                                $update_pacte           =   array(
                                    "COD_RUTTIT"        =>  $rutafili, 
                                    "COD_USUARI"        =>  $usergraba,
                                    "FEC_AUDITA"        =>  'SYSDATE',
                                );
                                $this->db->where('COD_RUTPAC',$elrut);
                                $this->db->update($this->tableSpace.'.GG_TGPACTE',$update_pacte);
                            }
                            
                            $oExiste                            =   $this->db->query($this->sql_class_ggpacientes->sqlTitularSSAN($this->tableSpace, $rutafili))->result_array();
                            if ($oExiste[0]["EXISTE"]==0){
                               
                                $arr_insert_so_ttitul           =   array(
                                    "COD_RUTTIT"                =>  $rutafili,
                                    "COD_DIGVER"                =>  $dgvafili,
                                    "NOM_NOMBRE"                =>  $nombretit,
                                    "NOM_APEPAT"                =>  $apell1tit,
                                    "NOM_APEMAT"                =>  $apell2tit,
                                    "IND_PREVIS"                =>  $ind_previs,
                                    "NUM_RUTINS"                =>  '61603000',
                                    "IND_ESTADO"                =>  'V',
                                    "DES_BLOQUEO"               =>  $des_codigobloqueo,
                                    "COD_USRCREA"               =>  $usergraba,
                                    "FEC_USRCREA"               =>  'SYSDATE',
                                    "COD_USUARI"                =>  $usergraba,
                                    "FEC_AUDITA"                =>  'SYSDATE',
                                );
                                $this->db->insert($this->tableSpace.'.SO_TTITUL',$arr_insert_so_ttitul);
                                $grabo++;
                            } else {
                                $arr_update_so_ttitul           =   array(
                                    "IND_PREVIS"                =>  $ind_previs,
                                    "DES_BLOQUEO"               =>  $des_codigobloqueo,
                                    "NUM_RUTINS"                =>  '61603000',
                                    "COD_USUARI"                =>  $usergraba,
                                    "NOM_APEMAT"                =>  $apell2tit,
                                    "NOM_NOMBRE"                =>  $nombretit,
                                    "NOM_APEPAT"                =>  $apell1tit,
                                    "IND_ESTADO"                =>  'V',
                                    "FEC_AUDITA"                =>  'SYSDATE',
                                );
                                $this->db->where('COD_RUTTIT',$rutafili);
                                $this->db->update($this->tableSpace.'.SO_TTITUL',$arr_update_so_ttitul);
                            }
                        }//fin rut == rutafili
                        break;
                    default:
                        #pacientes es isapre, capredena,dipreca U OTRO
                        #acuualiza condicion PRAIS
                        if ($rutafili == $rut) {//es titular, se actualiza prevision
                            if ($tipobloqueo == "1") {//es isapre
                                $updtitular = "I";
                            } else {//convencional dipreca capedena otra
                                if ($ind_previs == 'SP') {
                                    
                                } else {
                                    $updtitular = "O";
                                }
                            }
                            $arr_update_so_ttitul           =   array(
                                "IND_PREVIS"                =>  $ind_previs,
                                "DES_BLOQUEO"               =>  $des_codigobloqueo,
                                "NUM_RUTINS"                =>  '61603000',
                                "COD_USUARI"                =>  $usergraba,
                                "NOM_APEMAT"                =>  $apell2tit,
                                "NOM_NOMBRE"                =>  $nombretit,
                                "NOM_APEPAT"                =>  $apell1tit,
                                "IND_ESTADO"                =>  'V',
                                "FEC_AUDITA"                =>  'SYSDATE',
                            );
                            $this->db->where('COD_RUTTIT',$rutafili);
                            $this->db->update($this->tableSpace.'.SO_TTITUL',$arr_update_so_ttitul);
                            
                        } else {
                            if ($tipobloqueo == "1") {//es isapre
                                $updtitular                 =   "I";
                            } else {//convencional dipreca capedena otra
                                if ($ind_previs == 'SP') {
                                    $updtitular             =   $ind_previs;
                                } else {
                                    $updtitular             =   "O";
                                }
                            }
                            //actualizar gg_tcpacte y verificar que existe el nuevo titular en la tabla so_titul
                            if ($espacientessan == '1') {
                               $update_pacte                =   array(
                                    "COD_RUTTIT"            =>  $rutafili, 
                                    "COD_USUARI"            =>  $usergraba,
                                    "FEC_AUDITA"            =>  'SYSDATE',
                                );
                                $this->db->where('COD_RUTPAC',$elrut);
                                $this->db->update($this->tableSpace.'.GG_TGPACTE',$update_pacte);
                            }
                            
                            
                            $oExiste                            =   $this->db->query($this->sql_class_ggpacientes->sqlTitularSSAN($this->tableSpace, $rutafili))->result_array();
                            $Titular                            =   $oExiste[0]["EXISTE"];
                            if ($Titular == '0') {
                                $arr_insert_so_ttitul           =   array(
                                    "COD_RUTTIT"                =>  $rutafili,
                                    "COD_DIGVER"                =>  $dgvafili,
                                    "NOM_NOMBRE"                =>  $nombretit,
                                    "NOM_APEPAT"                =>  $apell1tit,
                                    "NOM_APEMAT"                =>  $apell2tit,
                                    "IND_PREVIS"                =>  $ind_previs,
                                    "NUM_RUTINS"                =>  '61603000',
                                    "IND_ESTADO"                =>  'V',
                                    "DES_BLOQUEO"               =>  $des_codigobloqueo,
                                    "COD_USRCREA"               =>  $usergraba,
                                    "FEC_USRCREA"               =>  'SYSDATE',
                                    "COD_USUARI"                =>  $usergraba,
                                    "FEC_AUDITA"                =>  'SYSDATE',
                                );
                                $this->db->insert($this->tableSpace.'.SO_TTITUL',$arr_insert_so_ttitul);
                            } else {
                                $arr_update_so_ttitul           =   array(
                                    "IND_PREVIS"                =>  $ind_previs,
                                    "DES_BLOQUEO"               =>  $des_codigobloqueo,
                                    "COD_USUARI"                =>  $usergraba,
                                    "NOM_APEMAT"                =>  $apell2tit,
                                    "NOM_NOMBRE"                =>  $nombretit,
                                    "NOM_APEPAT"                =>  $apell1tit,
                                    "IND_ESTADO"                =>  'V',
                                    "FEC_AUDITA"                =>  'SYSDATE',
                                );
                                $this->db->where('COD_RUTTIT',$rut);
                                $this->db->update($this->tableSpace.'.SO_TTITUL',$arr_update_so_ttitul);
                            }
                        }//fin else $rutafili == $rut
                        break;
                }
            }
            
            #beneficiario fallecido
            if ($bloqueo_pacte == "2") {
                $fec_fallece            =   $oParametros->bTOFecFall;
                $ind_fallecido          =   1;
                
                if ($fec_fallece == '' || $fec_fallece == "NO INFORMADA"){
                    
                    
                } else {
                    $fecha_fall             =   explode("-", $fec_fallece);
                    $horaconsulta           =   @date("H:i:s");
                    $fallecexfonasa         =   $fecha_fall[2] . '/' . $fecha_fall[1] . '/' . $fecha_fall[0];
                    #actualizamos 
                    if ($existetit == '1') {
                        $arr_update_so_ttitul           =   array(
                            "IND_PREVIS"                =>  'SP',
                            "DES_BLOQUEO"               =>  $des_codigobloqueo,
                            "COD_USUARI"                =>  $usergraba,
                            "IND_ESTADO"                =>  'V',
                            "FEC_AUDITA"                =>  'SYSDATE',
                        );
                        $this->db->where('COD_RUTTIT',$rut);
                        $this->db->update($this->tableSpace.'.SO_TTITUL',$arr_update_so_ttitul);
                    }

                    #agregamos datos del bloqueo a historial
                    $arr_insert_thbloqueotitular       =   array(
                        "COD_RUTTIT"                    =>  $rut,
                        "COD_RUTPAC"                    =>  $elrut,
                        "FEC_CONSULTA"                  =>  'SYSDATE',
                        "COD_BLOQUEO"                   =>  $cod_cybl,
                        "DES_BLOQUEO"                   =>  $des_codigobloqueo,
                        "FEC_FALLECE"                   =>  "TO_CHAR('$fallecexfonasa $horaconsulta','DD-MM-YYYY hh24:mi:ss')",
                        "IND_ESTADO"                    =>  "V",
                        "COD_USRCREA"                   =>  $usergraba,
                        "FEC_USRCREA"                   =>  'SYSDATE',
                        "COD_USUARI"                    =>  $usergraba,
                        "FEC_AUDITA"                    =>  'SYSDATE',
                    );
                    $this->db->insert($this->tableSpace.'.SO_THBLOQUEOTITULAR',$arr_insert_thbloqueotitular);
                }
            }
            
            if ($bloqueo_pacte == "0") {
                #paciente bloqueado por fonasa
                #paciente bloqueado,sin prevision (SP)
                if ($existetit == '1') {
                    $arr_update_so_ttitul           =   array(
                        "IND_PREVIS"                =>  trim($oParametros->AfiliadoTramo), #/tramo fonasa
                        "DES_BLOQUEO"               =>  $des_codigobloqueo,
                        "COD_USUARI"                =>  $usergraba,
                        "FEC_AUDITA"                =>  'SYSDATE',
                        "IND_ESTADO"                =>  'V',
                    );
                    $this->db->where('COD_RUTTIT',$rut);
                    $this->db->update($this->tableSpace.'.SO_TTITUL',$arr_update_so_ttitul);
                }
                
                $arr_insert_so_thbloqueotitular     =   array(
                    "COD_RUTTIT"                    =>  $rut,
                    "COD_RUTPAC"                    =>  $elrut,
                    "FEC_CONSULTA"                  =>  'SYSDATE',
                    "COD_BLOQUEO"                   =>  $cod_cybl,
                    "DES_BLOQUEO"                   =>  $des_codigobloqueo,
                    "IND_ESTADO"                    =>  'V',
                    "COD_USRCREA"                   =>  $usergraba,
                    "FEC_USRCREA"                   =>  'SYSDATE',
                );
                $this->db->insert($this->tableSpace.'.SO_THBLOQUEOTITULAR',$arr_insert_so_thbloqueotitular);
            }
        #fin accion 1    
        } else {
            if ($existetit == '1') {
                $arr_update_so_ttitul           =   array(
                    "IND_PREVIS"                =>  'SP',
                    "DES_BLOQUEO"               =>  $des_codigobloqueo,
                    "COD_USUARI"                =>  $usergraba,
                    "FEC_AUDITA"                =>  'SYSDATE',
                    "IND_ESTADO"                =>  'V',
                );
                $this->db->where('COD_RUTTIT',$rut);
                $this->db->update($this->tableSpace.'.SO_TTITUL',$arr_update_so_ttitul);
            }
            
            
            $arr_insert_so_thbloqueotitular     =   array(
                "COD_RUTTIT"                    =>  $rut,
                "COD_RUTPAC"                    =>  $elrut,
                "FEC_CONSULTA"                  =>  'SYSDATE',
                "COD_BLOQUEO"                   =>  $cod_cybl,
                "DES_BLOQUEO"                   =>  $des_codigobloqueo,
                "IND_ESTADO"                    =>  'V',
                "COD_USRCREA"                   =>  $usergraba,
                "FEC_USRCREA"                   =>  'SYSDATE',
            );
            $this->db->insert($this->tableSpace.'.SO_THBLOQUEOTITULAR',$arr_insert_so_thbloqueotitular);
        }

        $tra                                    =   $updtitular;
        
        if (empty($tra)) {      $tra            =   $ind_previs==''?'SP':$ind_previs;  }
        if (empty($tra)) {      $tra            =   'SP'; }
        
        $this->db->trans_complete();
        return array(
            "ind_fallecido"                     =>  $ind_fallecido,
            "tramoFon"                          =>  $tra,
            "transaccion"                       =>  $this->db->trans_status()
        );
    }



}