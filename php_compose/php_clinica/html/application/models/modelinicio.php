<?php

class modelinicio extends CI_Model {

    var $own = 'ADMIN';
    var $ownGu = 'ADMIN';

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
        $ID_UID = '';
        $status = false;
        $status_empresa = false;
        $arr_empresa = [];
        $txt_empresa_default = '';
        $cod_empresa_default = '';
        $row = [];
        $menu = [];
        $sql = "SELECT ID_UID, USERNAME, PASSWORD, NAME, FIRST_NAME, LAST_NAME, USERGROUP, EMAIL FROM ADMIN.FE_USERS WHERE USERNAME = ?";
        $query = $this->db->query($sql,array($user));
        if ($query->num_rows()>0) {
            $row = $query->row();
            if (password_verify($pass,$row->PASSWORD)) {
                $status = true;
                $ID_UID = $row->ID_UID;
                $row = $row;
                $menu = $this->load_menuxuser($ID_UID);
            }
            #activo 
            if ($status){
                $arr_empresa = $this->db->query("SELECT 
                        A.*,
                        'TEST' AS NOM_ESTAB 
                        FROM 
                        ADMIN.GU_TUSUXEMPRESA A 
                        WHERE 
                        A.IND_ESTADO = 1 
                        AND 
                        A.ID_UID = $ID_UID ")->result_array();
                if (count($arr_empresa)>0) {
                    $status_empresa = true;
                    $txt_empresa_default = $arr_empresa[0]['NOM_ESTAB'];
                    $cod_empresa_default = $arr_empresa[0]['COD_ESTABL'];
                }
            }
        } 
        return [
            'row' => $row, 
            'menu' => $menu,
            'status' => $status,
            'status_empresa' => $status_empresa,
            'arr_empresa' => $arr_empresa,
            'txt_empresa_default' => $txt_empresa_default,
            'cod_empresa_default' => $cod_empresa_default
        ];
    }

    #13957520-2
    public function load_menuxuser($ID_UID) {
        $menu = [];
        $parentMap = [];
        $allPermissions = [];
        #id con permisos abuelos
        $all_permisosabuelo = [];
        $all_permisoshijo = [];
        $all_permisosnieto = [];
        # Obtén los permisos del usuario
        $menu_hierarchy = [];
        $arr_abuelos_sistema = [];
        $arr_hijo_sub_menu = [];
        $arr_nieto_extension = [];
        $menu_hierarchy = [];
        #acceso total
        $arr_acceso_submenus = [];
        $arr_user_permisos = $this->arr_menu_xuser($ID_UID);
        
        if(count($arr_user_permisos) > 0) {
            foreach ($arr_user_permisos as $row) {
                switch ($row['NIVEL_MENU']) {
                    case 'Abuelo':
                        $all_permisosabuelo[] = $row['MENP_ID'];
                        $menu_hierarchy[$row['MENP_ID']] = [
                            'menu' => $row,
                            'submenus' => []
                        ];
                        break;
                    case 'Hijo':
                        $arr_hijo_sub_menu[$row['MENP_ID']] = $row['MENP_ID'];
                        if (isset($menu_hierarchy[$row['MENP_IDPADRE']])) {
                            $menu_hierarchy[$row['MENP_IDPADRE']]['submenus'][$row['MENP_ID']] = [
                                'menu' => $row,
                                'extension' => []
                            ];
                        }
                        break;
                    case 'Nieto':
                        $arr_nieto_extension[$row['MENP_ID']] = $row['MENP_ID'];
                        foreach ($menu_hierarchy as &$abuelo) {
                            if (isset($abuelo['submenus'][$row['MENP_IDPADRE']])) {
                                $abuelo['submenus'][$row['MENP_IDPADRE']]['extension'][$row['MENP_ID']] = $row;
                            }
                        }
                        break;
                }
            }
            # Verificar abuelos sin submenus para otorgar acceso total
            foreach ($menu_hierarchy as $id_abue => &$abuelo) {
                if (empty($abuelo['submenus'])) {
                    $abuelo['access_total'] = true; 
                    $arr_acceso_submenus[] = $id_abue;
                } 
            }
        }

        log_message('error', 'arr_user_permisos');
        log_message('error', print_r($arr_user_permisos,true));
        log_message('error', 'menu_hierarchy');
        log_message('error', print_r($menu_hierarchy,true));
        //arr_hijo_sub_menu
        $menuData = $this->db->query($this->arr_menu_default())->result_array();
        if (count($menuData) > 0) {
            foreach ($menuData as $aux => $row) {
                $menuId = $row['MAIN_ID'];
                $subMenuId = isset($row['SUB_ID']) ? $row['SUB_ID'] : null;
                $extensionId = isset($row['EXT_ID']) ? $row['EXT_ID'] : null;
                # Verificar si el usuario tiene permiso para ver este menú principal o es padre de un elemento con permiso
                if (in_array($menuId,$all_permisosabuelo)){
                    # Menú principal
                    if (!isset($menu[$menuId])) {
                        $menu[$menuId] = [
                            'data' => [
                                'MAIN_ID' => $row['MAIN_ID'],
                                'MAIN_NOMBRE' => $row['MAIN_NOMBRE'],
                                'MAIN_ICON' => $row['MAIN_ICON'],
                                'MAIN_RUTA' => $row['MAIN_RUTA']
                            ],
                            'submenus' => []
                        ];
                    }
                    # Submenús
                    if ($subMenuId && (!isset($menu[$menuId]['submenus'][$subMenuId]) && (in_array($menuId,$arr_acceso_submenus) || in_array($subMenuId,$arr_hijo_sub_menu) ))) {
                        $menu[$menuId]['submenus'][$subMenuId] = [
                            'data' => [
                                'SUB_ID' => $row['SUB_ID'],
                                'SUB_NOMBRE' => $row['SUB_NOMBRE'],
                                'SUB_RUTA' => $row['SUB_RUTA']
                            ],
                            'extensions' => []
                        ];
                    }
                    # Extensiones
                    if ($subMenuId && $extensionId && (!isset($menu[$menuId]['submenus'][$subMenuId]['extensions'][$extensionId]) && (in_array($menuId,$arr_acceso_submenus)  || in_array($extensionId,$arr_nieto_extension)))) {
                        $menu[$menuId]['submenus'][$subMenuId]['extensions'][$extensionId] = [
                            'EXT_ID' => $row['EXT_ID'],
                            'EXT_NOMBRE' => $row['EXT_NOMBRE'],
                            'EXT_RUTA' => $row['EXT_RUTA']
                        ];
                    }

                }
            }
        }
        return [
            'arr_menu' => $menu,
            'arr_user_permisos' => $arr_user_permisos
        ];
    }

    public function arr_menu_xuser($ID_UID){
        $sql = "SELECT 
                    M.MENP_ID, 
                    M.MENP_IDPADRE,
                    CASE 
                        WHEN M.MENP_IDPADRE = 0 THEN 'Abuelo'
                        WHEN (SELECT P.MENP_IDPADRE 
                            FROM ADMIN.GU_TMENUPRINCIPAL P 
                            WHERE P.MENP_ID = M.MENP_IDPADRE) = 0 THEN 'Hijo'
                        ELSE 'Nieto'
                    END AS NIVEL_MENU 
                FROM 
                        ADMIN.GU_TUSUTIENEPER A
                    JOIN ADMIN.GU_TPERMISOS B ON A.PER_ID = B.PER_ID
                    JOIN ADMIN.GU_TMENPTIENEPER C ON A.PER_ID = C.PER_ID
                    JOIN ADMIN.GU_TMENUPRINCIPAL M ON C.MENP_ID = M.MENP_ID
                WHERE 
                        A.ID_UID = $ID_UID
                    AND A.IND_ESTADO = 1
                    AND M.MENP_ESTADO = 1
                    AND C.IND_ESTADO = 1
                    AND B.PER_ESTADO IN (1,3)
                    AND M.MENP_FRAME = 3
                ORDER BY 
                    M.MENP_ID, M.MENP_IDPADRE ASC;
                ";
        return $this->db->query($sql)->result_array();;
    }

   
    public function arr_menu_default(){
        $sql = "SELECT 
                    M.MENP_ID AS MAIN_ID, 
                    M.MENP_NOMBRE AS MAIN_NOMBRE, 
                    M.MENP_ESTADO AS MAIN_ESTADO, 
                    M.MENP_RUTA AS MAIN_RUTA, 
                    M.MENP_IDPADRE AS MAIN_IDPADRE, 
                    M.MENP_TIPO AS MAIN_TIPO, 
                    M.MENP_ORDER AS MAIN_ORDER, 
                    M.MENP_FRAME AS MAIN_FRAME, 
                    M.MENP_ICON AS MAIN_ICON, 
                    M.MENP_THEME AS MAIN_THEME, 
                    M.MENP_ISTOKEN AS MAIN_ISTOKEN, 
                    M.MENP_PARAM AS MAIN_PARAM,
                    
                    SM.MENP_ID AS SUB_ID, 
                    SM.MENP_NOMBRE AS SUB_NOMBRE, 
                    SM.MENP_ESTADO AS SUB_ESTADO, 
                    SM.MENP_RUTA AS SUB_RUTA, 
                    SM.MENP_IDPADRE AS SUB_IDPADRE, 
                    SM.MENP_TIPO AS SUB_TIPO, 
                    SM.MENP_ORDER AS SUB_ORDER, 
                    SM.MENP_FRAME AS SUB_FRAME, 
                    SM.MENP_ICON AS SUB_ICON, 
                    SM.MENP_THEME AS SUB_THEME, 
                    SM.MENP_ISTOKEN AS SUB_ISTOKEN, 
                    SM.MENP_PARAM AS SUB_PARAM,
                    
                    EX.MENP_ID AS EXT_ID, 
                    EX.MENP_NOMBRE AS EXT_NOMBRE, 
                    EX.MENP_ESTADO AS EXT_ESTADO, 
                    EX.MENP_RUTA AS EXT_RUTA, 
                    EX.MENP_IDPADRE AS EXT_IDPADRE, 
                    EX.MENP_TIPO AS EXT_TIPO, 
                    EX.MENP_ORDER AS EXT_ORDER, 
                    EX.MENP_FRAME AS EXT_FRAME, 
                    EX.MENP_ICON AS EXT_ICON, 
                    EX.MENP_THEME AS EXT_THEME, 
                    EX.MENP_ISTOKEN AS EXT_ISTOKEN, 
                    EX.MENP_PARAM AS EXT_PARAM
                FROM 
                    ADMIN.GU_TMENUPRINCIPAL M 
                    LEFT JOIN 
                    ADMIN.GU_TMENUPRINCIPAL SM ON SM.MENP_IDPADRE = M.MENP_ID AND SM.MENP_FRAME = 3
                    LEFT JOIN 
                    ADMIN.GU_TMENUPRINCIPAL EX ON EX.MENP_IDPADRE = SM.MENP_ID AND EX.MENP_FRAME = 3
                WHERE 
                    M.MENP_ESTADO = 1 AND 
                    M.MENP_FRAME = 3 AND 
                    M.MENP_IDPADRE = 0 
                ";
        return $sql;
    }



    public function arr_menu_xuser2($ID_UID){
        $sql = "SELECT 
                    M.MENP_ID, 
                    M.MENP_IDPADRE 
                FROM 
                    ADMIN.GU_TUSUTIENEPER A
                    JOIN ADMIN.GU_TPERMISOS B ON A.PER_ID = B.PER_ID
                    JOIN ADMIN.GU_TMENPTIENEPER C ON A.PER_ID = C.PER_ID
                    JOIN ADMIN.GU_TMENUPRINCIPAL M ON C.MENP_ID = M.MENP_ID
                WHERE A.ID_UID = $ID_UID
                    AND A.IND_ESTADO = 1
                    AND M.MENP_ESTADO = 1
                    AND C.IND_ESTADO = 1
                    AND B.PER_ESTADO IN (1,3)
                    AND M.MENP_FRAME = 3
                ORDER BY M.MENP_ID, M.MENP_ORDER ASC";
        return $sql;
    }
    
  


    public function busca_menu2($iuid){
        $sql = "SELECT 
                    SUBQUERY.MENP_ID, 
                    SUBQUERY.MENP_NOMBRE, 
                    SUBQUERY.MENP_ICON 
                FROM (
                SELECT DISTINCT 
                    D.MENP_ID, 
                    D.MENP_ICON, 
                    D.MENP_NOMBRE, 
                    D.MENP_RUTA, 
                    D.MENP_IDPADRE, 
                    D.MENP_TIPO, 
                    D.MENP_ESTADO, 
                    D.MENP_ORDER
                FROM 
                    ADMIN.GU_TUSUTIENEPER A
                    INNER JOIN ADMIN.GU_TPERMISOS B ON A.PER_ID = B.PER_ID 
                    INNER JOIN ADMIN.GU_TMENPTIENEPER C ON A.PER_ID = C.PER_ID 
                    INNER JOIN ADMIN.GU_TMENUPRINCIPAL D ON C.MENP_ID = D.MENP_ID
                WHERE 
                    A.ID_UID = $iuid AND
                    A.IND_ESTADO = 1 AND
                    D.MENP_ESTADO = 1 AND
                    C.IND_ESTADO = 1 AND
                    D.MENP_TIPO = 1 AND
                    B.PER_ESTADO IN (1,3) AND
                    D.MENP_FRAME = 3
                ) AS SUBQUERY 
                ORDER BY SUBQUERY.MENP_NOMBRE ASC
            ";
        return $sql;
    }


     

 


    public function arr_menuxuser($ID_UID) {
        $sql = "SELECT 
                    M.MENP_ID AS MAIN_ID, 
                    M.MENP_NOMBRE AS MAIN_NOMBRE, 
                    M.MENP_ESTADO AS MAIN_ESTADO, 
                    M.MENP_RUTA AS MAIN_RUTA, 
                    M.MENP_IDPADRE AS MAIN_IDPADRE, 
                    M.MENP_TIPO AS MAIN_TIPO, 
                    M.MENP_ORDER AS MAIN_ORDER, 
                    M.MENP_FRAME AS MAIN_FRAME, 
                    M.MENP_ICON AS MAIN_ICON, 
                    M.MENP_THEME AS MAIN_THEME, 
                    M.MENP_ISTOKEN AS MAIN_ISTOKEN, 
                    M.MENP_PARAM AS MAIN_PARAM,
                    
                    SM.MENP_ID AS SUB_ID, 
                    SM.MENP_NOMBRE AS SUB_NOMBRE, 
                    SM.MENP_ESTADO AS SUB_ESTADO, 
                    SM.MENP_RUTA AS SUB_RUTA, 
                    SM.MENP_IDPADRE AS SUB_IDPADRE, 
                    SM.MENP_TIPO AS SUB_TIPO, 
                    SM.MENP_ORDER AS SUB_ORDER, 
                    SM.MENP_FRAME AS SUB_FRAME, 
                    SM.MENP_ICON AS SUB_ICON, 
                    SM.MENP_THEME AS SUB_THEME, 
                    SM.MENP_ISTOKEN AS SUB_ISTOKEN, 
                    SM.MENP_PARAM AS SUB_PARAM,
                    
                    EX.MENP_ID AS EXT_ID, 
                    EX.MENP_NOMBRE AS EXT_NOMBRE, 
                    EX.MENP_ESTADO AS EXT_ESTADO, 
                    EX.MENP_RUTA AS EXT_RUTA, 
                    EX.MENP_IDPADRE AS EXT_IDPADRE, 
                    EX.MENP_TIPO AS EXT_TIPO, 
                    EX.MENP_ORDER AS EXT_ORDER, 
                    EX.MENP_FRAME AS EXT_FRAME, 
                    EX.MENP_ICON AS EXT_ICON, 
                    EX.MENP_THEME AS EXT_THEME, 
                    EX.MENP_ISTOKEN AS EXT_ISTOKEN, 
                    EX.MENP_PARAM AS EXT_PARAM
                FROM 
                    ADMIN.GU_TMENUPRINCIPAL M 
                    LEFT JOIN 
                    ADMIN.GU_TMENUPRINCIPAL SM ON SM.MENP_IDPADRE = M.MENP_ID AND SM.MENP_FRAME = 3
                    LEFT JOIN 
                    ADMIN.GU_TMENUPRINCIPAL EX ON EX.MENP_IDPADRE = SM.MENP_ID AND EX.MENP_FRAME = 3
                WHERE 
                    M.MENP_ESTADO = 1 AND 
                    M.MENP_FRAME = 3 AND 
                    M.MENP_IDPADRE = 0 
                    AND EXISTS (SELECT 1 
                            FROM ADMIN.GU_TUSUTIENEPER P 
                            WHERE P.PER_ID = M.MENP_ID AND 
                                  P.ID_UID = $ID_UID AND 
                                  P.IND_ESTADO = 1)";
        return $sql;
    }


    public function arr_menu_filtrado2($iuid) {
        $own = "ADMIN";
        $sql = "SELECT 
                    M.MENP_ID AS MAIN_ID, 
                    M.MENP_NOMBRE AS MAIN_NOMBRE, 
                    M.MENP_ESTADO AS MAIN_ESTADO, 
                    M.MENP_RUTA AS MAIN_RUTA, 
                    M.MENP_IDPADRE AS MAIN_IDPADRE, 
                    M.MENP_TIPO AS MAIN_TIPO, 
                    M.MENP_ORDER AS MAIN_ORDER, 
                    M.MENP_FRAME AS MAIN_FRAME, 
                    M.MENP_ICON AS MAIN_ICON, 
                    M.MENP_THEME AS MAIN_THEME, 
                    M.MENP_ISTOKEN AS MAIN_ISTOKEN, 
                    M.MENP_PARAM AS MAIN_PARAM,
                    
                    SM.MENP_ID AS SUB_ID, 
                    SM.MENP_NOMBRE AS SUB_NOMBRE, 
                    SM.MENP_ESTADO AS SUB_ESTADO, 
                    SM.MENP_RUTA AS SUB_RUTA, 
                    SM.MENP_IDPADRE AS SUB_IDPADRE, 
                    SM.MENP_TIPO AS SUB_TIPO, 
                    SM.MENP_ORDER AS SUB_ORDER, 
                    SM.MENP_FRAME AS SUB_FRAME, 
                    SM.MENP_ICON AS SUB_ICON, 
                    SM.MENP_THEME AS SUB_THEME, 
                    SM.MENP_ISTOKEN AS SUB_ISTOKEN, 
                    SM.MENP_PARAM AS SUB_PARAM,
                    
                    EX.MENP_ID AS EXT_ID, 
                    EX.MENP_NOMBRE AS EXT_NOMBRE, 
                    EX.MENP_ESTADO AS EXT_ESTADO, 
                    EX.MENP_RUTA AS EXT_RUTA, 
                    EX.MENP_IDPADRE AS EXT_IDPADRE, 
                    EX.MENP_TIPO AS EXT_TIPO, 
                    EX.MENP_ORDER AS EXT_ORDER, 
                    EX.MENP_FRAME AS EXT_FRAME, 
                    EX.MENP_ICON AS EXT_ICON, 
                    EX.MENP_THEME AS EXT_THEME, 
                    EX.MENP_ISTOKEN AS EXT_ISTOKEN, 
                    EX.MENP_PARAM AS EXT_PARAM
                FROM 
                    $own.GU_TMENUPRINCIPAL M 
                    LEFT JOIN $own.GU_TMENUPRINCIPAL SM ON SM.MENP_IDPADRE = M.MENP_ID AND SM.MENP_FRAME = 3
                    LEFT JOIN $own.GU_TMENUPRINCIPAL EX ON EX.MENP_IDPADRE = SM.MENP_ID AND EX.MENP_FRAME = 3
                    JOIN $own.GU_TMENPTIENEPER C ON C.MENP_ID = M.MENP_ID
                    JOIN $own.GU_TUSUTIENEPER A ON A.PER_ID = C.PER_ID
                    JOIN $own.GU_TPERMISOS B ON A.PER_ID = B.PER_ID
                WHERE 
                        M.MENP_ESTADO = 1 
                    AND M.MENP_FRAME = 3 
                    AND A.ID_UID = $iuid
                    AND A.IND_ESTADO = 1
                    AND C.IND_ESTADO = 1
                    AND B.PER_ESTADO = 3
                    AND (M.MENP_IDPADRE = 0 OR M.MENP_IDPADRE IN (
                        SELECT MENP_ID 
                        FROM $own.GU_TMENUPRINCIPAL 
                        WHERE MENP_ID IN (
                            SELECT C.MENP_ID 
                            FROM $own.GU_TMENPTIENEPER C 
                            JOIN $own.GU_TUSUTIENEPER A ON A.PER_ID = C.PER_ID 
                            WHERE A.ID_UID = $iuid 
                            AND A.IND_ESTADO = 1 
                            AND C.IND_ESTADO = 1
                        )
                    ))
                ORDER BY M.MENP_ID, M.MENP_ORDER ASC";
        return $sql;
    }


    public function busca_menu_filtrado($iuid) {
        $sql = "SELECT 
                    M.MENP_ID, 
                    M.MENP_NOMBRE, 
                    M.MENP_IDPADRE, 
                    M.MENP_ICON, 
                    M.MENP_TIPO, 
                    M.MENP_RUTA, 
                    M.MENP_THEME, 
                    M.MENP_ISTOKEN, 
                    M.MENP_PARAM
                FROM 
                    ADMIN.GU_TUSUTIENEPER A
                JOIN 
                    ADMIN.GU_TPERMISOS B ON A.PER_ID = B.PER_ID
                JOIN 
                    ADMIN.GU_TMENPTIENEPER C ON A.PER_ID = C.PER_ID
                JOIN 
                    ADMIN.GU_TMENUPRINCIPAL M ON C.MENP_ID = M.MENP_ID
                WHERE 
                    A.ID_UID = $iuid
                    AND A.IND_ESTADO = 1
                    AND M.MENP_ESTADO = 1
                    AND C.IND_ESTADO = 1
                    AND B.PER_ESTADO = 3
                    AND M.MENP_FRAME = 3
                ORDER BY 
                    M.MENP_ID, M.MENP_ORDER ASC";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

   
/*


    public function load_menuxuser_old($ID_UID) {
        $menu = [];
        $allPermissions = [];
        $parentMap = [];
        # Búsqueda de los sistemas/abuelo/hijo/nieto
        $sql = $this->arr_menu_xuser($ID_UID);
        $arr_user_permisos = $this->db->query($sql)->result_array();
        #log_message('error', 'arr_user_permisos');
        #log_message('error', print_r($arr_user_permisos, TRUE));
        $menu_hierarchy = [];
        
        if (count($arr_user_permisos) > 0) {
            foreach($arr_user_permisos as $row) {
                if ($row['MENP_IDPADRE'] == 0) {
                    $menu_hierarchy[$row['MENP_ID']] = [
                        'menu' => $row,
                        'children' => [],
                        'acceso_total' => true 
                    ];
                } elseif (isset($menu_hierarchy[$row['MENP_IDPADRE']])) {
                    $menu_hierarchy[$row['MENP_IDPADRE']]['children'][$row['MENP_ID']] = [
                        'menu' => $row,
                        'children' => []
                    ];
                    $menu_hierarchy[$row['MENP_IDPADRE']]['acceso_total'] = false;
                } else {
                    foreach ($menu_hierarchy as &$abuelo) {
                        if (isset($abuelo['children'][$row['MENP_IDPADRE']])) {
                            $abuelo['children'][$row['MENP_IDPADRE']]['children'][$row['MENP_ID']] = [
                                'menu' => $row
                            ];
                            $abuelo['acceso_total'] = false;
                            break;
                        }
                    }
                }
            }
        }
    
      
        
        log_message('error', 'Final menu_hierarchy');
        log_message('error', print_r($menu_hierarchy, TRUE));
        # Cargar todos los menús
        $menuData = $this->db->query($this->arr_menu_default())->result_array();
        if (count($menuData)>0){
            foreach ($menuData as  $aux =>  $row){
                $menuId = $row['MAIN_ID'];
                $subMenuId = isset($row['SUB_ID']) ? $row['SUB_ID'] : null;
                $extensionId = isset($row['EXT_ID']) ? $row['EXT_ID'] : null;
                if (!isset($menu[$menuId])) {
                    $menu[$menuId] = [
                        'data' => $row, // Datos del menú principal
                        'submenus' => []
                    ];
                }
                if ($subMenuId && !isset($menu[$menuId]['submenus'][$subMenuId])) {
                    $menu[$menuId]['submenus'][$subMenuId] = [
                        'data' => $row, // Datos del submenu
                        'extensions' => []
                    ];
                }
                if ($extensionId) {
                    $menu[$menuId]['submenus'][$subMenuId]['extensions'][$extensionId] = $row; // Datos de la extensión
                }
            }
        }
        return [
            'sql' => $sql,
            'arr_menu' => $menu_hierarchy,
            'arr_user_permisos' => $arr_user_permisos,
            'allPermissions' => $allPermissions,
            'parentMap' => $parentMap
        ];
    }
    */

    /*
    public function load_menuxuser_old3($ID_UID){
        #$sql = $this->arr_menu_default();
        $sql = $this->arr_menu_filtrado2($ID_UID);
        $menu = [];
        $menuData = $this->db->query($sql)->result_array();
        if(count($menuData)>0){
            foreach($menuData as $row) {
                $menuId = $row['MAIN_ID'];
                $subMenuId = $row['SUB_ID'];
                $extensionId = $row['EXT_ID'];
                // Organizar en estructura jerárquica
                if (!isset($menu[$menuId])) {
                    $menu[$menuId] = [
                        'data' => $row, // Datos del menú principal
                        'submenus' => []
                    ];
                }
                if ($subMenuId && !isset($menu[$menuId]['submenus'][$subMenuId])) {
                    $menu[$menuId]['submenus'][$subMenuId] = [
                        'data' => $row, // Datos del submenu
                        'extensions' => []
                    ];
                }
                if ($extensionId) {
                    $menu[$menuId]['submenus'][$subMenuId]['extensions'][$extensionId] = $row; // Datos de la extensión
                }
            }
        }
        return $menu;
    }
    */

    /*
    #carga de menu principal
    public function load_menuxuser_last($ID_UID) {
        $menu = [];
        $sql = $this->arr_menu_filtrado2($ID_UID);
        $menuData = $this->db->query($sql)->result_array();
        if (count($menuData) > 0) {
            foreach ($menuData as $row) {
                $menuId = $row['MAIN_ID'];
                $subMenuId = $row['SUB_ID'];
                $extensionId = $row['EXT_ID'];
                // Organizar en estructura jerárquica
                if (!isset($menu[$menuId])) {
                    $menu[$menuId] = [
                        'data' => [
                            'MAIN_ID' => $row['MAIN_ID'],
                            'MAIN_NOMBRE' => $row['MAIN_NOMBRE'],
                            'MAIN_ICON' => $row['MAIN_ICON']
                        ], // Datos del menú principal
                        'submenus' => []
                    ];
                }
    
                if ($subMenuId && !isset($menu[$menuId]['submenus'][$subMenuId])) {
                    $menu[$menuId]['submenus'][$subMenuId] = [
                        'data' => [
                            'SUB_ID' => $row['SUB_ID'],
                            'SUB_NOMBRE' => $row['SUB_NOMBRE'],
                            'SUB_RUTA' => $row['SUB_RUTA']
                        ], // Datos del submenú
                        'extensions' => []
                    ];
                }
    
                if ($extensionId) {
                    $menu[$menuId]['submenus'][$subMenuId]['extensions'][$extensionId] = [
                        'EXT_ID' => $row['EXT_ID'],
                        'EXT_NOMBRE' => $row['EXT_NOMBRE'],
                        'EXT_RUTA' => $row['EXT_RUTA']
                    ]; // Datos de la extensión
                }
            }
        }
        return $menu;
    }
    */

    /*
    public function arr_menu_userid($user_id) {
        $own = "ADMIN";
        $sql = "SELECT 
                    M.MENP_ID AS MAIN_ID, 
                    M.MENP_NOMBRE AS MAIN_NOMBRE, 
                    M.MENP_ESTADO AS MAIN_ESTADO, 
                    M.MENP_RUTA AS MAIN_RUTA, 
                    M.MENP_IDPADRE AS MAIN_IDPADRE, 
                    M.MENP_TIPO AS MAIN_TIPO, 
                    M.MENP_ORDER AS MAIN_ORDER, 
                    M.MENP_FRAME AS MAIN_FRAME, 
                    M.MENP_ICON AS MAIN_ICON, 
                    M.MENP_THEME AS MAIN_THEME, 
                    M.MENP_ISTOKEN AS MAIN_ISTOKEN, 
                    M.MENP_PARAM AS MAIN_PARAM,
                    SM.MENP_ID AS SUB_ID, 
                    SM.MENP_NOMBRE AS SUB_NOMBRE, 
                    SM.MENP_ESTADO AS SUB_ESTADO, 
                    SM.MENP_RUTA AS SUB_RUTA, 
                    SM.MENP_IDPADRE AS SUB_IDPADRE, 
                    SM.MENP_TIPO AS SUB_TIPO, 
                    SM.MENP_ORDER AS SUB_ORDER, 
                    SM.MENP_FRAME AS SUB_FRAME, 
                    SM.MENP_ICON AS SUB_ICON, 
                    SM.MENP_THEME AS SUB_THEME, 
                    SM.MENP_ISTOKEN AS SUB_ISTOKEN, 
                    SM.MENP_PARAM AS SUB_PARAM,
                    EX.MENP_ID AS EXT_ID, 
                    EX.MENP_NOMBRE AS EXT_NOMBRE, 
                    EX.MENP_ESTADO AS EXT_ESTADO, 
                    EX.MENP_RUTA AS EXT_RUTA, 
                    EX.MENP_IDPADRE AS EXT_IDPADRE, 
                    EX.MENP_TIPO AS EXT_TIPO, 
                    EX.MENP_ORDER AS EXT_ORDER, 
                    EX.MENP_FRAME AS EXT_FRAME, 
                    EX.MENP_ICON AS EXT_ICON, 
                    EX.MENP_THEME AS EXT_THEME, 
                    EX.MENP_ISTOKEN AS EXT_ISTOKEN, 
                    EX.MENP_PARAM AS EXT_PARAM
                FROM 
                    $own.GU_TMENUPRINCIPAL M 
                    LEFT JOIN $own.GU_TMENUPRINCIPAL SM ON SM.MENP_IDPADRE = M.MENP_ID AND SM.MENP_FRAME = 3
                    LEFT JOIN $own.GU_TMENUPRINCIPAL EX ON EX.MENP_IDPADRE = SM.MENP_ID AND EX.MENP_FRAME = 3
                WHERE 
                    M.MENP_ESTADO = 1 
                    AND M.MENP_FRAME = 3 
                    AND M.MENP_IDPADRE = 0
                    AND EXISTS (
                        SELECT 1 
                        FROM $own.GU_TUSUTIENEPER P 
                        WHERE P.ID_UID = $user_id 
                        AND P.PER_ID = M.MENP_ID 
                        AND P.IND_ESTADO = 1
                    )
                ORDER BY M.MENP_ORDER ASC
            ";
        return $sql;
    }
    */
    #bring everything
    
    #original
    


    public function busca_menu_22($iuid, $access = ''){
        $sql = "SELECT 
                    MENP_ID, 
                    MENP_NOMBRE, 
                    MENP_ICON 
                FROM (SELECT UNIQUE  
                        D.MENP_ID, 
                        MENP_ICON,
                        D.MENP_NOMBRE,
                        D.MENP_RUTA,
                        D.MENP_IDPADRE,
                        D.MENP_TIPO,
                        D.MENP_ESTADO, 
                        MENP_ORDER
            FROM 
                $this->ownGu.GU_TUSUTIENEPER a, 
                $this->ownGu.GU_TPERMISOS b, 
                $this->ownGu.GU_TMENPTIENEPER  c,
                $this->ownGu.GU_TMENUPRINCIPAL d
            WHERE 
                a.per_id=b.per_id AND
                a.per_id=c.per_id AND 
                id_uid=$iuid AND
                C.MENP_ID=D.MENP_ID AND 
                a.ind_estado=1 AND 
                D.MENP_ESTADO=1 AND 
                c.ind_estado=1 AND 
                MENP_TIPO= 1 AND 
                b.PER_ESTADO = 3 AND 
                MENP_FRAME = 3) 
            ORDER BY MENP_NOMBRE ASC";
        if ($access == 'decomiso') {
            $query = $this->dbFac->query($sql);
        } else {
            $query = $this->db->query($sql);
        }
        return $query->result_array();
    }


    public function busca_menu($iuid, $access = ''){
        $sql = "SELECT MENP_ID, MENP_NOMBRE, MENP_ICON FROM (select unique D.MENP_ID, MENP_ICON,D.MENP_NOMBRE,D.MENP_RUTA,D.MENP_IDPADRE,D.MENP_TIPO,D.MENP_ESTADO, MENP_ORDER
            from $this->ownGu.GU_TUSUTIENEPER a, $this->ownGu.GU_TPERMISOS b, $this->ownGu.GU_TMENPTIENEPER  c,$this->ownGu.GU_TMENUPRINCIPAL d
            where a.per_id=b.per_id and
            a.per_id=c.per_id and id_uid=$iuid and
            C.MENP_ID=D.MENP_ID and a.ind_estado=1
            and D.MENP_ESTADO=1 and c.ind_estado=1 AND MENP_TIPO= 1 AND b.PER_ESTADO = 3 AND MENP_FRAME = 3) ORDER BY MENP_NOMBRE ASC";

        if ($access == 'decomiso') {
            $query = $this->dbFac->query($sql);
        } else {
            $query = $this->db->query($sql);
        }
        return $query->result_array();
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
