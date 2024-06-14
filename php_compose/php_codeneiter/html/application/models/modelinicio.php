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
                        m.MENP_ID as main_id, m.MENP_NOMBRE as main_nombre, m.MENP_ESTADO as main_estado, m.MENP_RUTA as main_ruta, m.MENP_IDPADRE as main_idpadre, m.MENP_TIPO as main_tipo, m.MENP_ORDER as main_order, m.MENP_FRAME as main_frame, m.MENP_ICON as main_icon, m.MENP_THEME as main_theme, m.MENP_ISTOKEN as main_istoken, m.MENP_PARAM as main_param,
                        sm.MENP_ID as sub_id, sm.MENP_NOMBRE as sub_nombre, sm.MENP_ESTADO as sub_estado, sm.MENP_RUTA as sub_ruta, sm.MENP_IDPADRE as sub_idpadre, sm.MENP_TIPO as sub_tipo, sm.MENP_ORDER as sub_order, sm.MENP_FRAME as sub_frame, sm.MENP_ICON as sub_icon, sm.MENP_THEME as sub_theme, sm.MENP_ISTOKEN as sub_istoken, sm.MENP_PARAM as sub_param,
                        ex.MENP_ID as ext_id, ex.MENP_NOMBRE as ext_nombre, ex.MENP_ESTADO as ext_estado, ex.MENP_RUTA as ext_ruta, ex.MENP_IDPADRE as ext_idpadre, ex.MENP_TIPO as ext_tipo, ex.MENP_ORDER as ext_order, ex.MENP_FRAME as ext_frame, ex.MENP_ICON as ext_icon, ex.MENP_THEME as ext_theme, ex.MENP_ISTOKEN as ext_istoken, ex.MENP_PARAM as ext_param
                    FROM 
                        $own.GU_TMENUPRINCIPAL m 
                        LEFT JOIN $own.GU_TMENUPRINCIPAL sm ON sm.MENP_IDPADRE = m.MENP_ID AND sm.MENP_FRAME = 3
                        LEFT JOIN $own.GU_TMENUPRINCIPAL ex ON ex.MENP_IDPADRE = sm.MENP_ID AND ex.MENP_FRAME = 3
                    WHERE 
                        m.MENP_ESTADO = 1 AND 
                        m.MENP_FRAME = 3 AND 
                        m.MENP_IDPADRE = 0
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
        $sql_permisos    = "
                            SELECT 
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
