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

    public function login_modelo($user,$pass) {
        $status =   false;
        $row = [];
        $menu = [];
        $ID_UID = '';
        $sql = "SELECT ID_UID, USERNAME, PASSWORD, NAME, FIRST_NAME, LAST_NAME, USERGROUP, EMAIL FROM ADMIN.FE_USERS WHERE USERNAME = ?";
        $query = $this->db->query($sql,array($user));
        if ($query->num_rows()>0){
            $row = $query->row();
            if (password_verify($pass,$row->PASSWORD)){
                $status = true;
                $ID_UID = $row->ID_UID;
                $row = $row;
                $menu = $this->load_menuxuser($ID_UID);
            } 
        } 
        return [
            'row' => $row, 
            'menu' => $menu,
            'status' => $status
        ];
    }

    public function load_menuxuser($ID_UID){
        $sql    =   "SELECT 
                        M.MENP_ID AS MAIN_ID, M.MENP_NOMBRE AS MAIN_NOMBRE, M.MENP_ESTADO AS MAIN_ESTADO, M.MENP_RUTA AS MAIN_RUTA, M.MENP_IDPADRE AS MAIN_IDPADRE, M.MENP_TIPO AS MAIN_TIPO, M.MENP_ORDER AS MAIN_ORDER, M.MENP_FRAME AS MAIN_FRAME, M.MENP_ICON AS MAIN_ICON, M.MENP_THEME AS MAIN_THEME, M.MENP_ISTOKEN AS MAIN_ISTOKEN, M.MENP_PARAM AS MAIN_PARAM,
                        SM.MENP_ID AS SUB_ID, SM.MENP_NOMBRE AS SUB_NOMBRE, SM.MENP_ESTADO AS SUB_ESTADO, SM.MENP_RUTA AS SUB_RUTA, SM.MENP_IDPADRE AS SUB_IDPADRE, SM.MENP_TIPO AS SUB_TIPO, SM.MENP_ORDER AS SUB_ORDER, SM.MENP_FRAME AS SUB_FRAME, SM.MENP_ICON AS SUB_ICON, SM.MENP_THEME AS SUB_THEME, SM.MENP_ISTOKEN AS SUB_ISTOKEN, SM.MENP_PARAM AS SUB_PARAM,
                        EX.MENP_ID AS EXT_ID, EX.MENP_NOMBRE AS EXT_NOMBRE, EX.MENP_ESTADO AS EXT_ESTADO, EX.MENP_RUTA AS EXT_RUTA, EX.MENP_IDPADRE AS EXT_IDPADRE, EX.MENP_TIPO AS EXT_TIPO, EX.MENP_ORDER AS EXT_ORDER, EX.MENP_FRAME AS EXT_FRAME, EX.MENP_ICON AS EXT_ICON, EX.MENP_THEME AS EXT_THEME, EX.MENP_ISTOKEN AS EXT_ISTOKEN, EX.MENP_PARAM AS EXT_PARAM
                    FROM 
                        $OWN.GU_TMENUPRINCIPAL M 
                        LEFT JOIN $OWN.GU_TMENUPRINCIPAL SM ON SM.MENP_IDPADRE = M.MENP_ID AND SM.MENP_FRAME = 3
                        LEFT JOIN $OWN.GU_TMENUPRINCIPAL EX ON EX.MENP_IDPADRE = SM.MENP_ID AND EX.MENP_FRAME = 3
                    WHERE 
                        M.MENP_ESTADO = 1 AND 
                        M.MENP_FRAME = 3 AND 
                        M.MENP_IDPADRE = 0
                    ";
        #var_dump($sql);
        $menuData = $this->db->query($sql)->result_array();
        $menu = [];
        if(count($menuData)>0){
            foreach($menuData as $row) {
                $menuId = $row['main_id'];
                $subMenuId = $row['sub_id'];
                $extensionId = $row['ext_id'];
                // Organizar en estructura jerárquica
                if (!isset($menu[$menuId])) {
                    $menu[$menuId] = [
                        'data'          =>  $row, // Datos del menú principal
                        'submenus'      =>  []
                    ];
                }
                if ($subMenuId && !isset($menu[$menuId]['submenus'][$subMenuId])) {
                    $menu[$menuId]['submenus'][$subMenuId] = [
                        'data'          =>  $row, // Datos del submenu
                        'extensions'    =>  []
                    ];
                }
                if ($extensionId) {
                    $menu[$menuId]['submenus'][$subMenuId]['extensions'][$extensionId] = $row; // Datos de la extensión
                }
            }
        }
        return $menu;
    
        /*
        $sql_permisos    = "SELECT 
                                P.ID_UTP,
                                P.PER_ID,
                                P.ID_UID,
                                P.IND_ESTADO 
                            FROM 
                                ADMIN.GU_TUSUTIENEPER P 
                            WHERE 
                                P.ID_UID IN (10) AND 
                                P.IND_ESTADO IN (1)
                            ";
        */
    }

    public function model_consultaporusuario($username){
        $status = true;
        $sql = "SELECT 
                    F.ID_UID, 
                    F.PID, 
                    F.TSTAMP, 
                    F.USERNAME, 
                    F.PASSWORD, 
                    F.USERGROUP, 
                    F.DISABLE, 
                    F.STARTTIME, 
                    F.ENDTIME, 
                    F.NAME, 
                    F.FIRST_NAME, 
                    F.MIDDLE_NAME, 
                    F.LAST_NAME, 
                    F.ADDRESS, 
                    F.TELEPHONE, 
                    F.FAX, 
                    F.EMAIL, 
                    F.CRDATE, 
                    F.CRUSER_ID, 
                    F.LOCKTODOMAIN, 
                    F.DELETED, 
                    F.UC, 
                    F.TITLE, 
                    F.ZIP, 
                    F.CITY, 
                    F.COUNTRY, 
                    F.WWW, 
                    F.COMPANY, 
                    F.IMAGE, 
                    F.TSCONFIG, 
                    F.FE_CRUSER_ID, 
                    F.LASTLOGIN, 
                    F.IS_ONLINE, 
                    F.TX_EXTBASE_TYPE, 
                    F.FELOGIN_REDIRECTPID, 
                    F.FELOGIN_FORGOTHASH, 
                    F.TX_CHCFORUM_AIM, 
                    F.TX_CHCFORUM_YAHOO, 
                    F.TX_CHCFORUM_MSN, 
                    F.TX_CHCFORUM_CUSTOMIM, 
                    F.MAILHASH, 
                    F.ACTIVATED_ON, 
                    F.PSEUDONYM, 
                    F.GENDER, 
                    F.DATE_OF_BIRTH, 
                    F.LANGUAGE, 
                    F.ZONE, 
                    F.STATIC_INFO_COUNTRY, 
                    F.TIMEZONE, 
                    F.DAYLIGHT, 
                    F.MOBILEPHONE, 
                    F.GTC, 
                    F.PRIVACY, 
                    F.STATUS, 
                    F.BY_INVITATION, 
                    F.COMMENTS, 
                    F.MODULE_SYS_DMAIL_HTML, 
                    F.MODULE_SYS_DMAIL_CATEGORY, 
                    F.TX_EXTERNALIMPORTTUT_CODE, 
                    F.TX_EXTERNALIMPORTTUT_DEPARTMEN, 
                    F.TX_EXTERNALIMPORTTUT_HOLIDAYS, 
                    F.TX_INTRANETSSAN_APELLIDOPATERN, 
                    F.TX_INTRANETSSAN_APELLIDOMATERN, 
                    F.TX_INTRANETSSAN_CLAVEUNICA, 
                    F.TX_INTRANETSSAN_OBLIGACAMBIARC, 
                    F.TX_INTRANETSSAN_PREFERENCIA, 
                    F.TX_INTRANETSSAN_RUN, 
                    F.TX_INTRANETSSAN_DV
                FROM 
                    $own.FE_USERS F
                WHERE
                    F.USERNAME IN ('$username')
                ";
        return $this->db->query($sql)->result_array();
    }

    public function creaCodigoFirma($username, $codigo, $firma, $datetime){
        $this->db->trans_start();
        $dataFun = array(
            'MAILHASH' => strtolower($firma),
            'FELOGIN_FORGOTHASH' => $codigo,
            'FELOGIN_REDIRECTPID' => $datetime
        );
        $this->db->where('USERNAME', $username);
        $this->db->update($this->own . '.FE_USERS', $dataFun);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function getValidaCodigo($codVerif,$username){
        $query = $this->db->query("SELECT FELOGIN_FORGOTHASH, FELOGIN_REDIRECTPID AS FH_HOY FROM $this->own.FE_USERS WHERE UPPER(USERNAME) = UPPER('$username') AND FELOGIN_FORGOTHASH = '$codVerif'");
        return $query->result_array();
    }

    public function confirmaCambioFirma($username)  {
        $query = $this->db->query("SELECT MAILHASH FROM $this->own.FE_USERS WHERE USERNAME ='$username'");
        $cl = $query->row();
        $this->db->trans_start();
        $this->db->set('TX_INTRANETSSAN_CLAVEUNICA', $cl->MAILHASH);
        $this->db->set('MAILHASH','');
        $this->db->where('USERNAME', $username);
        $this->db->update($this->own . '.FE_USERS');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function Consultaexistefirma($pwsimple1, $username){
        $query = $this->db->query("SELECT USERNAME from $this->own.FE_USERS WHERE TX_INTRANETSSAN_CLAVEUNICA = UPPER('$pwsimple1') AND UPPER(USERNAME) <> UPPER('$username')");
        return $query->result_array();
    }

    public function tradatos_usu($iuid){
        $query = $this->db->query("SELECT USERNAME,FIRST_NAME,NAME,MIDDLE_NAME,LAST_NAME,TELEPHONE,EMAIL,TX_INTRANETSSAN_CLAVEUNICA,PASSWORD,TX_INTRANETSSAN_CLAVEUNICA,MAILHASH from $this->own.FE_USERS where ID_UID=$iuid");
        return $query->result_array();
    }
}
