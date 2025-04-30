<?php

namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\Log\Logger;

class UserModel extends Model {

    protected $table = 'ADMIN.FE_USERS';
    protected $primaryKey = 'USERNAME';
    protected $allowedFields = ['ID_UID','USERNAME', 'PASSWORD', 'NAME'];
    protected $returnType = 'array';
    public function __construct() {
        parent::__construct();
    }

    public function verificacionsuperuser($username, $password)  {
        $sql = "SELECT ID_UID, USERNAME, PASSWORD, NAME, FIRST_NAME, LAST_NAME, USERGROUP, EMAIL 
                FROM ADMIN.FE_USERS 
                WHERE USERNAME = ?";
        $query = $this->db->query($sql, [$username]);

        if ($query->getNumRows() > 0) {
            $user = $query->getRow();
            if (password_verify($password, $user->PASSWORD)) {
                return [
                    'status' => true,
                    'user' => $user
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Contraseña incorrecta'
                ];
            }
        } else {
            return [
                'status' => false,
                'message' => 'Usuario no encontrado'
            ];
        }
    }

    public function ini_contendido(){
        $db = db_connect();
        $sql = "SELECT 
                        m.MENP_ID as main_id, m.MENP_NOMBRE as main_nombre, m.MENP_ESTADO as main_estado, m.MENP_RUTA as main_ruta, m.MENP_IDPADRE as main_idpadre, m.MENP_TIPO as main_tipo, m.MENP_ORDER as main_order, m.MENP_FRAME as main_frame, m.MENP_ICON as main_icon, m.MENP_THEME as main_theme, m.MENP_ISTOKEN as main_istoken, m.MENP_PARAM as main_param,
                        sm.MENP_ID as sub_id, sm.MENP_NOMBRE as sub_nombre, sm.MENP_ESTADO as sub_estado, sm.MENP_RUTA as sub_ruta, sm.MENP_IDPADRE as sub_idpadre, sm.MENP_TIPO as sub_tipo, sm.MENP_ORDER as sub_order, sm.MENP_FRAME as sub_frame, sm.MENP_ICON as sub_icon, sm.MENP_THEME as sub_theme, sm.MENP_ISTOKEN as sub_istoken, sm.MENP_PARAM as sub_param,
                        ex.MENP_ID as ext_id, ex.MENP_NOMBRE as ext_nombre, ex.MENP_ESTADO as ext_estado, ex.MENP_RUTA as ext_ruta, ex.MENP_IDPADRE as ext_idpadre, ex.MENP_TIPO as ext_tipo, ex.MENP_ORDER as ext_order, ex.MENP_FRAME as ext_frame, ex.MENP_ICON as ext_icon, ex.MENP_THEME as ext_theme, ex.MENP_ISTOKEN as ext_istoken, ex.MENP_PARAM as ext_param
                    FROM 
                        ADMIN.GU_TMENUPRINCIPAL m 
                        LEFT JOIN ADMIN.GU_TMENUPRINCIPAL sm ON sm.MENP_IDPADRE = m.MENP_ID AND sm.MENP_FRAME = 3
                        LEFT JOIN ADMIN.GU_TMENUPRINCIPAL ex ON ex.MENP_IDPADRE = sm.MENP_ID AND ex.MENP_FRAME = 3
                    WHERE 
                        m.MENP_ESTADO = 1 AND m.MENP_FRAME = 3 AND m.MENP_IDPADRE = 0;
                    ";
        $menuData = $db->query($sql)->getResultArray();
        $menu = [];
        foreach($menuData as $row) {
            $menuId = $row['main_id'];
            $subMenuId = $row['sub_id'];
            $extensionId = $row['ext_id'];
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
        //*************************************** */
        // Variable para almacenar el HTML
        $html   =   "";
        foreach ($menu as $mainId => $mainMenu){
            #Acceder a los datos del menú principal
            $mainData = $mainMenu['data'];
            #Generar el HTML para el menú principal
            $html .=    "<div class='card' style='margin-bottom: 8px;'>";
            $html .=    "<div class='card-body'>";
            $html .=    "<h4 class='card-title' style='color:#888888;'>";
                $html .=    "<a href='javascript:editarExt(".$mainData['main_id'].",0)'><i class='fa fa-cog' aria-hidden='true'></i></a>&nbsp;" ;
                $html .=    htmlspecialchars($mainData['main_nombre']);
            $html .=    "&nbsp;<b style='font-size: 10px;'>(".htmlspecialchars($mainData['main_id']).")</b></h4>";
            #Generar la lista de submenús y sus extensiones
            $html   .= "<ul class='list-group'>";
            foreach ($mainMenu['submenus'] as $subMenuId => $subMenu){
                #Acceder a los datos del submenú
                $subData    =   $subMenu['data'];
                #Aquí agregas el nombre del submenú
                $html   .=  "<h5 style='color:#888888;margin-left: 10px;'>";
                $html   .=  "<a href='javascript:editarExt(".$subData['sub_id'].",1)'><i class='bi bi-menu-button-wide-fill'></i></a>&nbsp;".htmlspecialchars($subData['sub_nombre'])."";
                $html   .=  "&nbsp;<b style='font-size: 10px;'>(".htmlspecialchars($subData['sub_id']).")</b></h5>";
                $html   .=  "<ul class='no-bullet'>";
                #Acceder a los datos de las extensiones
                foreach ($subMenu['extensions'] as $extensionId => $extension) {
                    $html   .=  "<li><h6 style='color:#888888;margin-left: 15px;'><a href='javascript:editarExt(".$extension['ext_id'].",2)'>";
                    $html   .=  "<i class='bi bi-wrench-adjustable-circle-fill'></i></a>&nbsp;".htmlspecialchars($extension['ext_nombre'])."&nbsp;<b style='font-size: 10px;'>(".htmlspecialchars($extension['ext_id']).")</b></h6>";
                    $html   .=  "</li>";
                }
                $html .= "</ul>"; // Cerrar la lista del submenú
            }
            $html .= "</ul>";
            $html .= "</div>";
            $html .= "</div>";
        }
        return $output  = [
            'menu_principal' => array_values($menu), // Convertir a array para un mejor formato JSON
            'menuData' => $menuData,
            'roles_creados' => $db->query("SELECT * FROM ADMIN.GU_TPERMISOS WHERE PER_ESTADO IN (1,2,3) ")->getResultArray(),
            'arr_empresas' => $db->query("SELECT * FROM ADMIN.SS_TEMPRESAS WHERE IND_ESTADO = 'V' ")->getResultArray(),
            'html' => $html,
        ];
    }

    public function ini_contendido_1() {
        $db = db_connect();
        $sql = "SELECT 
                    m.MENP_ID as main_id, m.MENP_NOMBRE as main_nombre, m.MENP_ESTADO as main_estado, m.MENP_RUTA as main_ruta, m.MENP_IDPADRE as main_idpadre, m.MENP_TIPO as main_tipo, m.MENP_ORDER as main_order, m.MENP_FRAME as main_frame, m.MENP_ICON as main_icon, m.MENP_THEME as main_theme, m.MENP_ISTOKEN as main_istoken, m.MENP_PARAM as main_param,
                    sm.MENP_ID as sub_id, sm.MENP_NOMBRE as sub_nombre, sm.MENP_ESTADO as sub_estado, sm.MENP_RUTA as sub_ruta, sm.MENP_IDPADRE as sub_idpadre, sm.MENP_TIPO as sub_tipo, sm.MENP_ORDER as sub_order, sm.MENP_FRAME as sub_frame, sm.MENP_ICON as sub_icon, sm.MENP_THEME as sub_theme, sm.MENP_ISTOKEN as sub_istoken, sm.MENP_PARAM as sub_param,
                    ex.MENP_ID as ext_id, ex.MENP_NOMBRE as ext_nombre, ex.MENP_ESTADO as ext_estado, ex.MENP_RUTA as ext_ruta, ex.MENP_IDPADRE as ext_idpadre, ex.MENP_TIPO as ext_tipo, ex.MENP_ORDER as ext_order, ex.MENP_FRAME as ext_frame, ex.MENP_ICON as ext_icon, ex.MENP_THEME as ext_theme, ex.MENP_ISTOKEN as ext_istoken, ex.MENP_PARAM as ext_param
                FROM 
                    ADMIN.GU_TMENUPRINCIPAL m 
                    LEFT JOIN ADMIN.GU_TMENUPRINCIPAL sm ON sm.MENP_IDPADRE = m.MENP_ID AND sm.MENP_FRAME = 3
                    LEFT JOIN ADMIN.GU_TMENUPRINCIPAL ex ON ex.MENP_IDPADRE = sm.MENP_ID AND ex.MENP_FRAME = 3
                WHERE 
                    m.MENP_ESTADO = 1 AND m.MENP_FRAME = 3 AND m.MENP_IDPADRE = 0;";
        
        $menuData = $db->query($sql)->getResultArray();
        $menu = [];
    
        foreach ($menuData as $row) {
            $menuId = $row['main_id'];
            $subMenuId = $row['sub_id'];
            $extensionId = $row['ext_id'];
    
            // Organizar en estructura jerárquica
            if (!isset($menu[$menuId])) {
                $menu[$menuId] = [
                    'data' => $row, // Datos del menú principal
                    'submenus' => []
                ];
            }
    
            if ($subMenuId && !isset($menu[$menuId]['submenus'][$subMenuId])) {
                $menu[$menuId]['submenus'][$subMenuId] = [
                    'data' => $row, // Datos del submenú
                    'extensions' => []
                ];
            }
    
            if ($extensionId) {
                $menu[$menuId]['submenus'][$subMenuId]['extensions'][$extensionId] = $row; // Datos de la extensión
            }
        }
    
        // Generación del HTML
        $html = "";
        foreach ($menu as $mainId => $mainMenu) {
            $mainData = $mainMenu['data'];
    
            $html .= "<div class='card' style='margin-bottom: 8px;'>";
            $html .= "<div class='card-body'>";
            $html .= "<h3 class='card-title' style='color:#888888;'>";
            $html .= "<a href='javascript:editarExt(" . $mainData['main_id'] . ",0)'><i class='bi bi-pencil'></i></a>";
            $html .= htmlspecialchars($mainData['main_nombre']);
            $html .= "</h3>";
    
            // Generar la lista de submenús y sus extensiones
            $html .= "<ul class='list-group'>";
            foreach ($mainMenu['submenus'] as $subMenuId => $subMenu) {
                $subData = $subMenu['data'];
                $html .= "<h5 style='color:#888888;margin-left: 10px;'>";
                $html .= "<a href='javascript:editarExt(" . $subData['sub_id'] . ",1)'><i class='bi bi-pencil'></i></a>" . htmlspecialchars($subData['sub_nombre']);
                $html .= "</h5>";
    
                $html .= "<ul class='no-bullet'>";
                foreach ($subMenu['extensions'] as $extensionId => $extension) {
                    $html .= "<li><h6 style='color:#888888;margin-left: 15px;'><a href='javascript:editarExt(" . $extension['ext_id'] . ",2)'>";
                    $html .= "<i class='bi bi-pencil'></i></a>&nbsp;" . htmlspecialchars($extension['ext_nombre']) . "</h6></li>";
                }
                $html .= "</ul>"; // Cerrar la lista del submenú
            }
            $html .= "</ul>";
            $html .= "</div>";
            $html .= "</div>";
        }
    
        return $output = [
            'menu_principal' => array_values($menu), // Convertir a array para un mejor formato JSON
            'menuData' => $menuData,
            'roles_creados' => $db->query("SELECT * FROM ADMIN.GU_TPERMISOS WHERE PER_ESTADO IN (1,2,3)")->getResultArray(),
            'arr_empresas' => $db->query("SELECT * FROM ADMIN.SS_TEMPRESAS WHERE IND_ESTADO = 'V'")->getResultArray(),
            'html' => $html,
        ];
    }

    function ini_contendido_old4() {
        $db = db_connect();
        $sql = "SELECT 
                    m.MENP_ID as main_id, m.MENP_NOMBRE as main_nombre, m.MENP_ESTADO as main_estado, m.MENP_RUTA as main_ruta, m.MENP_IDPADRE as main_idpadre, m.MENP_TIPO as main_tipo, m.MENP_ORDER as main_order, m.MENP_FRAME as main_frame, m.MENP_ICON as main_icon, m.MENP_THEME as main_theme, m.MENP_ISTOKEN as main_istoken, m.MENP_PARAM as main_param,
                    sm.MENP_ID as sub_id, sm.MENP_NOMBRE as sub_nombre, sm.MENP_ESTADO as sub_estado, sm.MENP_RUTA as sub_ruta, sm.MENP_IDPADRE as sub_idpadre, sm.MENP_TIPO as sub_tipo, sm.MENP_ORDER as sub_order, sm.MENP_FRAME as sub_frame, sm.MENP_ICON as sub_icon, sm.MENP_THEME as sub_theme, sm.MENP_ISTOKEN as sub_istoken, sm.MENP_PARAM as sub_param,
                    ex.MENP_ID as ext_id, ex.MENP_NOMBRE as ext_nombre, ex.MENP_ESTADO as ext_estado, ex.MENP_RUTA as ext_ruta, ex.MENP_IDPADRE as ext_idpadre, ex.MENP_TIPO as ext_tipo, ex.MENP_ORDER as ext_order, ex.MENP_FRAME as ext_frame, ex.MENP_ICON as ext_icon, ex.MENP_THEME as ext_theme, ex.MENP_ISTOKEN as ext_istoken, ex.MENP_PARAM as ext_param
                FROM 
                    ADMIN.GU_TMENUPRINCIPAL m 
                    LEFT JOIN ADMIN.GU_TMENUPRINCIPAL sm ON sm.MENP_IDPADRE = m.MENP_ID AND sm.MENP_FRAME = 3
                    LEFT JOIN ADMIN.GU_TMENUPRINCIPAL ex ON ex.MENP_IDPADRE = sm.MENP_ID AND ex.MENP_FRAME = 3
                WHERE 
                    m.MENP_ESTADO = 1 AND m.MENP_FRAME = 3 AND m.MENP_IDPADRE = 0;";
        $menuData = $db->query($sql)->getResultArray();
    
        // Depuración inicial para verificar los datos obtenidos
        //echo "<pre>";
        //print_r($menuData);
        //echo "</pre>";
    
        $menu = [];
        foreach($menuData as $row) {
            $menuId = $row['main_id'];
            $subMenuId = $row['sub_id'];
            $extensionId = $row['ext_id'];
    
            // Verificación de las claves
            if (!isset($row['main_id']) || !isset($row['main_nombre'])) {
                echo "Error: Faltan datos principales en la fila.";
                continue;
            }
    
            if (!isset($menu[$menuId])) {
                $menu[$menuId] = [
                    'data' => [
                        'id' => $row['main_id'],
                        'nombre' => $row['main_nombre'],
                        'estado' => $row['main_estado'],
                        'ruta' => $row['main_ruta'],
                        'idpadre' => $row['main_idpadre'],
                        'tipo' => $row['main_tipo'],
                        'order' => $row['main_order'],
                        'frame' => $row['main_frame'],
                        'icon' => $row['main_icon'],
                        'theme' => $row['main_theme'],
                        'istoken' => $row['main_istoken'],
                        'param' => $row['main_param'],
                    ],
                    'submenus' => []
                ];
            }
    
            if ($subMenuId && !isset($menu[$menuId]['submenus'][$subMenuId])) {
                $menu[$menuId]['submenus'][$subMenuId] = [
                    'data' => [
                        'id' => $row['sub_id'],
                        'nombre' => $row['sub_nombre'],
                        'estado' => $row['sub_estado'],
                        'ruta' => $row['sub_ruta'],
                        'idpadre' => $row['sub_idpadre'],
                        'tipo' => $row['sub_tipo'],
                        'order' => $row['sub_order'],
                        'frame' => $row['sub_frame'],
                        'icon' => $row['sub_icon'],
                        'theme' => $row['sub_theme'],
                        'istoken' => $row['sub_istoken'],
                        'param' => $row['sub_param'],
                    ],
                    'extensions' => []
                ];
            }
    
            if ($extensionId) {
                $menu[$menuId]['submenus'][$subMenuId]['extensions'][$extensionId] = [
                    'id' => $row['ext_id'],
                    'nombre' => $row['ext_nombre'],
                    'estado' => $row['ext_estado'],
                    'ruta' => $row['ext_ruta'],
                    'idpadre' => $row['ext_idpadre'],
                    'tipo' => $row['ext_tipo'],
                    'order' => $row['ext_order'],
                    'frame' => $row['ext_frame'],
                    'icon' => $row['ext_icon'],
                    'theme' => $row['ext_theme'],
                    'istoken' => $row['ext_istoken'],
                    'param' => $row['ext_param'],
                ];
            }
        }
    
        $html = "";
        foreach ($menu as $mainId => $mainMenu) {
            $mainData = $mainMenu['data'];
            $html .= "<div class='card' style='margin-bottom: 8px;'>";
            $html .= "<div class='card-body'>";
            $html .= "<h3 class='card-title' style='color:#888888;'>";
            $html .= "<a href='javascript:editarExt(" . $mainData['id'] . ",0)'><i class='bi bi-pencil'></i></a>";
            $html .= htmlspecialchars($mainData['nombre']);
            $html .= "</h3>";
            $html .= "<ul class='list-group'>";
            foreach ($mainMenu['submenus'] as $subMenuId => $subMenu) {
                $subData = $subMenu['data'];
                $html .= "<h5 style='color:#888888;margin-left: 10px;'>";
                $html .= "<a href='javascript:editarExt(" . $subData['id'] . ",1)'><i class='bi bi-pencil'></i></a>" . htmlspecialchars($subData['nombre']);
                $html .= "</h5>";
                $html .= "<ul class='no-bullet'>";
                foreach ($subMenu['extensions'] as $extensionId => $extension) {
                    $html .= "<li><h6 style='color:#888888;margin-left: 15px;'><a href='javascript:editarExt(" . $extension['id'] . ",2)'><i class='bi bi-pencil'></i></a>&nbsp;" . htmlspecialchars($extension['nombre']) . "</h6></li>";
                }
                $html .= "</ul>";
            }
            $html .= "</ul>";
            $html .= "</div>";
            $html .= "</div>";
        }
    
        return $output = [
            'menu_principal' => array_values($menu), // Convertir a array para un mejor formato JSON
            'menuData' => $menuData,
            'roles_creados' => $db->query("SELECT * FROM ADMIN.GU_TPERMISOS WHERE PER_ESTADO IN (1,2,3)")->getResultArray(),
            'arr_empresas' => $db->query("SELECT * FROM ADMIN.SS_TEMPRESAS WHERE IND_ESTADO = 'V'")->getResultArray(),
            'html' => $html,
        ];
    }

    public function ini_contendido_old3() {
        $db     =   db_connect();
        $sql    =   "SELECT 
                        m.MENP_ID as main_id, m.MENP_NOMBRE as main_nombre, m.MENP_ESTADO as main_estado, m.MENP_RUTA as main_ruta, m.MENP_IDPADRE as main_idpadre, m.MENP_TIPO as main_tipo, m.MENP_ORDER as main_order, m.MENP_FRAME as main_frame, m.MENP_ICON as main_icon, m.MENP_THEME as main_theme, m.MENP_ISTOKEN as main_istoken, m.MENP_PARAM as main_param,
                        sm.MENP_ID as sub_id, sm.MENP_NOMBRE as sub_nombre, sm.MENP_ESTADO as sub_estado, sm.MENP_RUTA as sub_ruta, sm.MENP_IDPADRE as sub_idpadre, sm.MENP_TIPO as sub_tipo, sm.MENP_ORDER as sub_order, sm.MENP_FRAME as sub_frame, sm.MENP_ICON as sub_icon, sm.MENP_THEME as sub_theme, sm.MENP_ISTOKEN as sub_istoken, sm.MENP_PARAM as sub_param,
                        ex.MENP_ID as ext_id, ex.MENP_NOMBRE as ext_nombre, ex.MENP_ESTADO as ext_estado, ex.MENP_RUTA as ext_ruta, ex.MENP_IDPADRE as ext_idpadre, ex.MENP_TIPO as ext_tipo, ex.MENP_ORDER as ext_order, ex.MENP_FRAME as ext_frame, ex.MENP_ICON as ext_icon, ex.MENP_THEME as ext_theme, ex.MENP_ISTOKEN as ext_istoken, ex.MENP_PARAM as ext_param,
                        p.PER_ID as permiso_id, p.PER_NOMBRE as permiso_nombre
                    FROM 
                        ADMIN.GU_TMENUPRINCIPAL m 
                        LEFT JOIN ADMIN.GU_TMENUPRINCIPAL sm ON sm.MENP_IDPADRE = m.MENP_ID AND sm.MENP_FRAME = 3
                        LEFT JOIN ADMIN.GU_TMENUPRINCIPAL ex ON ex.MENP_IDPADRE = sm.MENP_ID AND ex.MENP_FRAME = 3
                        LEFT JOIN ADMIN.GU_TMENPTIENEPER mp ON mp.MENP_ID = m.MENP_ID
                        LEFT JOIN ADMIN.GU_TPERMISOS p ON p.PER_ID = mp.PER_ID
                    WHERE 
                        m.MENP_ESTADO = 1 AND m.MENP_FRAME = 3 AND m.MENP_IDPADRE = 0;";
        $menuData = $db->query($sql)->getResultArray();
        $menu = [];
        foreach($menuData as $row) {
            $menuId =   $row['main_id'];
            $subMenuId =   $row['sub_id'];
            $extensionId =   $row['ext_id'];
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
    
        // Generar el HTML
        $html   =   "";
        foreach ($menu as $mainId => $mainMenu){
            $mainData = $mainMenu['data'];
            $html .=    "<div class='card' style='margin-bottom: 8px;'>";
            $html .=    "<div class='card-body'>";
            $html .=    "<h3 class='card-title' style='color:#888888;'>";
            $html .=    "<a href='javascript:editarExt(".$mainData['main_id'].",0)'><i class='bi bi-pencil'></i></a>" ;
            $html .=    htmlspecialchars($mainData['main_nombre']);
            $html .=    "</h3>";
    
            $html   .= "<ul class='list-group'>";
            foreach ($mainMenu['submenus'] as $subMenuId => $subMenu){
                $subData    =   $subMenu['data'];
                $html   .=  "<h5 style='color:#888888;margin-left: 10px;'>";
                $html   .=  "<a href='javascript:editarExt(".$subData['sub_id'].",1)'><i class='bi bi-pencil'></i></a>".htmlspecialchars($subData['sub_nombre'])."";
                $html   .=  "</h5>";
    
                $html   .=  "<ul class='no-bullet'>";
                foreach ($subMenu['extensions'] as $extensionId => $extension) {
                    $html   .=  "<li><h6 style='color:#888888;margin-left: 15px;'><a href='javascript:editarExt(".$subData['ext_id'].",2)'>";
                    $html   .=  "<i class='bi bi-pencil'></i></a>&nbsp;" . htmlspecialchars($extension['ext_nombre'])."</h6>";
                    $html   .=  "</li>";
                }
                $html       .= "</ul>";
            }
            $html   .=  "</ul>";
            $html   .=  "</div>";
            $html   .=  "</div>";
        }
    
        return $output  = [
            'menu_principal'    =>  array_values($menu), 
            'menuData'          =>  $menuData,
            'roles_creados'     =>  $db->query("SELECT * FROM ADMIN.GU_TPERMISOS WHERE PER_ESTADO IN (1,2,3) ")->getResultArray(),
            'arr_empresas'      =>  $db->query("SELECT * FROM ADMIN.SS_TEMPRESAS WHERE IND_ESTADO = 'V' ")->getResultArray(),
            'html'              =>  $html,
        ];
    }

    public function buscaExtArch($aData){
        $db = db_connect();
        $rutaactual = $aData['rutaactual'];
        return $db->query("SELECT A.MENP_RUTA from ADMIN.GU_TMENUPRINCIPAL A WHERE A.MENP_RUTA='$rutaactual'")->getResult();
    }

    public function creaPrivilegio($nombre) {
        $db = \Config\Database::connect();
        $db->transStart();
        $data = [
                    'PER_NOMBRE' => $nombre,
                    'PER_ESTADO' => 3
                ];
        $constructora = $db->table('ADMIN.GU_TPERMISOS');
        $constructora->insert($data);
        $db->transComplete();
        return true;
    }

    public function actualiza_Privilegio($aData) {
        $db = \Config\Database::connect();
        $db->transStart();
        $builder = $db->table('ADMIN.GU_TPERMISOS');
        $builder->set('PER_ESTADO',$aData['v_bool']);
        $builder->where('MENP_ID', $aData['PER_ID']);
        $builder->update();
        $db->transComplete();
        return [
            'status' => true,
            'adata' => $aData
        ];
    }

    public function findByTk($id,$num){
        $db = db_connect();
        $query = $db->query("SELECT 
                                I.*,
                                CASE WHEN EXPIRA_TICKER > NOW() THEN 'success' ELSE 'warning' END   AS STATUS_EXPIRACION,
                                CASE WHEN EXPIRA_TICKER > NOW() THEN 
                                    'VISITA DE PACIENTE EN CURSO'
                                ELSE 
                                    'TIEMPO EXPIRADO' 
                                END                                                                 AS TXT_TITULO,
                                TIMESTAMPDIFF(DAY, NOW(), I.EXPIRA_TICKER)                          AS DAYS_DIFF,
                                DATE_FORMAT(I.DATE_CREA,'%d-%m-%Y %H:%i:%s')                        AS DATE_INICIOVISITA_F,
                                DATE_FORMAT(I.EXPIRA_TICKER,'%d-%m-%Y %H:%i:%s')                    AS EXPIRA_TICKER_F
                            FROM 
                                ADMIN.HALL_INGRESOPPACTE I 
                            WHERE 
                                I.ID_INGRESO = ? ", 
                            [$id]); 

        $query1 = $db->query("SELECT 
                                V.*
                            FROM 
                                ADMIN.HALL_VISITASPACIENTES V 
                            WHERE 
                                V.NUM_HOSPITALIZADO = ? AND  V.ID_INGRESO = ?", 
                            [$num,$id]); 
        return array(
            'ingreso_paciente'  =>  $query->getResult(),
            'hospitalizado'     =>  $query1->getResult(),
            'num'               =>  $num
        );
    }

    public function valida_cuenta_esissan_anatomia($aData){
        $run_gestion = $aData['run']."-".$aData['dv'];
        $status_existe = true;
        $getResultArray = [];
        $arr_privilegios = [];
        $arr_empresa = [];
        $db = db_connect();
        $get_fe_users = $db->query("SELECT * FROM ADMIN.FE_USERS WHERE TX_INTRANETSSAN_RUN = ".$aData['run'])->getResultArray();
        if(count($get_fe_users)>0){
            $arr_privilegios = $db->query("SELECT * FROM ADMIN.GU_TUSUTIENEPER WHERE IND_ESTADO = 1 AND ID_UID =".$get_fe_users[0]['ID_UID'])->getResultArray();
            $arr_empresa = $db->query("SELECT * FROM ADMIN.GU_TUSUXEMPRESA WHERE IND_ESTADO = 1 AND ID_UID =".$get_fe_users[0]['ID_UID'])->getResultArray();
        } else {
            $status_existe = false;    
        }
        return [
            'status' =>  true,
            'arr_privilegios' => $arr_privilegios,
            'arr_empresa' =>  $arr_empresa,
            'getResultArray' =>  $get_fe_users,
            'status_existe' => $status_existe, 
            'date' => date("d-m-Y"),
            'run_gestion' => $run_gestion
        ];
    }

    public function grabaUsu($aData){
        $status = true;
        $name = $aData['post']['nombres']." ".$aData['post']['apepate']." ".$aData['post']['apemate'];
        $arr_run = str_replace('.','',$aData['post']['user']);
        $logger = service('logger'); 
        $db = \Config\Database::connect();
        $db->transStart();
        $dataUs = [
            #'ID_UID' => $uID,
            'USERNAME' => trim($arr_run),
            'NAME' =>  $name, 
            'FIRST_NAME' => $aData['post']['nombres'],
            'MIDDLE_NAME' => $aData['post']['apepate'], 
            'LAST_NAME' => $aData['post']['apemate'],
            'EMAIL' => $aData['post']['email'],
            'TELEPHONE' => 0,
            'DISABLE' => $aData['post']['activo'], //activo
            'STATUS' => $aData['post']['superUser'], //superUser 
            'TX_INTRANETSSAN_RUN' => trim(explode("-",$arr_run)[0]),
            'TX_INTRANETSSAN_DV' => trim(explode("-",$arr_run)[1]),
            'DAYLIGHT' =>  1
        ];
        $v_actualiza_pass = $aData['post']['actualiza_pass'];
        if ($v_actualiza_pass == 1) {
            $hash = password_hash($aData['post']['pass'], PASSWORD_BCRYPT);
            $dataUs['PASSWORD'] = $hash;
            $dataUs['LOCKTODOMAIN'] = $hash;
        }
        #**************************************************************
        #$logger->info("-------------------------------------------");
        #$logger->info("v_actualiza_pass : {$v_actualiza_pass}  ");
        #$logger->info(json_encode($dataUs));
        #**************************************************************
        $last_id = 0;
        $arr_username = $db->query("SELECT ID_UID FROM ADMIN.FE_USERS WHERE USERNAME = '".$arr_run."'")->getResultArray();
        if(count($arr_username)>0){
            $last_id = $arr_username[0]['ID_UID'];
            $constructora = $db->table('ADMIN.FE_USERS');
            $constructora->set($dataUs);
            $constructora->where('ID_UID',$last_id);
            $updated = $constructora->update();
        } else {
            $constructora = $db->table('ADMIN.FE_USERS');
            $constructora->insert($dataUs);
            $last_id = $db->insertID();
        }
        //privilegios
        $arrPrivilegios = $aData['post']['arrPrivilegios'];
        if(count($arrPrivilegios)>0){
            $constructora0 = $db->table('ADMIN.GU_TUSUTIENEPER');
            $constructora0->set(['IND_ESTADO' => 0]);
            $constructora0->where('ID_UID',$last_id);
            $constructora0->update();
            foreach($arrPrivilegios as $i => $row){
                $get_tusutieneper = $db->query("SELECT ID_UTP FROM ADMIN.GU_TUSUTIENEPER WHERE PER_ID = $row AND ID_UID = ".$last_id)->getResultArray();
                /*
                $logger->info("-------------------------------------------");
                $logger->info("get_tusutieneper ");
                $logger->info(json_encode($get_tusutieneper));
                */
                if (count($get_tusutieneper)>0){
                    $v_id_utp = $get_tusutieneper[0]['ID_UTP'];
                    $logger->info("v_id_utp : {$v_id_utp}  ");
                    $constructora3 = $db->table('ADMIN.GU_TUSUTIENEPER');
                    $constructora3->set('IND_ESTADO',1);
                    $constructora3->where('ID_UTP',$v_id_utp);
                    $constructora3->update();
                } else {
                    $constructora2 = $db->table('ADMIN.GU_TUSUTIENEPER');
                    $constructora2->insert(['ID_UID'=>$last_id,'PER_ID'=>$row,'IND_ESTADO'=>1]);
                }
            }
        }

        //establecimientos
        $arrEmpresas = $aData['post']['arrEmpresas'];
        //var_dump($arrEmpresas);
        //var_dump(count($arrEmpresas));
        if(count($arrEmpresas)>0){
            $constructora4 = $db->table('ADMIN.GU_TUSUXEMPRESA');
            $constructora4->set(['IND_ESTADO' => 0]);
            $constructora4->where('ID_UID',$last_id);
            $constructora4->update();
            //var_dump($arrEmpresas);
            $logger->info("-------------------------------------------");
            $logger->info("arrEmpresas");
            $logger->info(json_encode($arrEmpresas));
            foreach($arrEmpresas as $i => $row){
                $get_arrEmpresas = $db->query("SELECT ID_UXE FROM ADMIN.GU_TUSUXEMPRESA WHERE COD_ESTABL IN (".$row.") AND ID_UID = ".$last_id)->getResultArray();
                if (count($get_arrEmpresas)>0){
                    $constructora5 = $db->table('ADMIN.GU_TUSUXEMPRESA');
                    $constructora5->set(['IND_ESTADO' => 1]);
                    $constructora5->where('ID_UXE',$get_arrEmpresas[0]['ID_UXE']);
                    $constructora5->update();
                } else {
                    $constructora6 = $db->table('ADMIN.GU_TUSUXEMPRESA');
                    $constructora6->insert(['ID_UID'=>$last_id,'COD_ESTABL'=>$row,'IND_ESTADO'=>1]);
                }
            }
        }
        $db->transComplete();
        return [
            'last_id' =>  $last_id,
            'user' =>  $arr_run,
            'status' =>  $status,
        ];
    }


    public function obtenerPermisosHeredados($idMen) {
        $db = db_connect();
        $permisos = [];
        $visitados = [];

        while ($idMen != 0 && !in_array($idMen, $visitados)) {
            $visitados[] = $idMen;
            $padre = $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idMen])->getRowArray();
            if ($padre && $padre['MENP_IDPADRE'] != 0) {
                $idMen = $padre['MENP_IDPADRE'];
                $permisosPadre = $db->query("SELECT PER_ID FROM ADMIN.GU_TMENPTIENEPER WHERE MENP_ID = ? AND IND_ESTADO = 1", [$idMen])->getResultArray();
                foreach ($permisosPadre as $permiso) {
                    if (!in_array($permiso, $permisos)) {
                        $permisos[] = $permiso;
                    }
                }
            } else {
                $idMen = 0;
            }
        }
        return $permisos;
    }
    


    public function getMenuPermissions($menuId, $menuType) {
        $db = db_connect();
    
        // Obtener permisos directos del menú
        $sqlDirectPermissions = "
            SELECT pm.PER_ID
            FROM ADMIN.GU_TMENPTIENEPER pm
            WHERE pm.MENP_ID = ? AND pm.IND_ESTADO = 1
        ";
        $directPermissions = $db->query($sqlDirectPermissions, [$menuId])->getResultArray();
        $directPermissions = array_column($directPermissions, 'PER_ID');
    
        // Si es un submenú o extensión, obtener permisos del padre
        if ($menuType == 1 || $menuType == 2) {
            $parentMenuId = $db->query("
                SELECT MENP_IDPADRE
                FROM ADMIN.GU_TMENUPRINCIPAL
                WHERE MENP_ID = ?", [$menuId])->getRowArray()['MENP_IDPADRE'];
    
            if ($parentMenuId) {
                $parentPermissions = $db->query("
                    SELECT pm.PER_ID
                    FROM ADMIN.GU_TMENPTIENEPER pm
                    WHERE pm.MENP_ID = ? AND pm.IND_ESTADO = 1", [$parentMenuId])->getResultArray();
                $parentPermissions = array_column($parentPermissions, 'PER_ID');
                $directPermissions = array_merge($directPermissions, $parentPermissions);
            }
        }
    
        // Si es una extensión, obtener permisos del abuelo
        if ($menuType == 2) {
            $grandParentMenuId = $db->query("
                SELECT MENP_IDPADRE
                FROM ADMIN.GU_TMENUPRINCIPAL
                WHERE MENP_ID = ?", [$parentMenuId])->getRowArray()['MENP_IDPADRE'];
    
            if ($grandParentMenuId) {
                $grandParentPermissions = $db->query("
                    SELECT pm.PER_ID
                    FROM ADMIN.GU_TMENPTIENEPER pm
                    WHERE pm.MENP_ID = ? AND pm.IND_ESTADO = 1", [$grandParentMenuId])->getResultArray();
                $grandParentPermissions = array_column($grandParentPermissions, 'PER_ID');
                $directPermissions = array_merge($directPermissions, $grandParentPermissions);
            }
        }
    
        return array_unique($directPermissions);
    }
    


    public function buscaExtEdit($aData) {
        $db = db_connect();
        $id = $aData['idMen'];
    
        // Consulta para gu_tmenuprincipal
        $query = $db->query("SELECT 
                                MENP_ID, 
                                MENP_NOMBRE, 
                                MENP_RUTA, 
                                MENP_IDPADRE, 
                                MENP_TIPO, 
                                MENP_ESTADO 
                            FROM 
                                ADMIN.GU_TMENUPRINCIPAL 
                            WHERE 
                                MENP_ID = ? AND MENP_ESTADO = 1", [$id])->getResultArray();
    
        // Consulta para arr_permisos
        $SQL = "SELECT 
                    E.ID_MPTP,
                    E.PER_ID,
                    E.MENP_ID,
                    E.IND_ESTADO  
                FROM 
                    ADMIN.GU_TMENPTIENEPER E 
                WHERE 
                    E.MENP_ID = ? AND E.IND_ESTADO = 1";
    
        $query2 = $db->query($SQL, [$id])->getResultArray();
    
        return [
            'id' => $id,
            'SQL' => $SQL,
            'gu_tmenuprincipal' => $query,
            'arr_permisos' => $query2,
        ];                    
    }
  

    public function get_obtenerPermisosHeredados($menuId) {
        $db = db_connect();
        $directPermissions = [];
        $logger = service('logger'); // Obtener la instancia del logger
        // Consulta para obtener información del menú principal
        $arr_menuprincipal = $db->query("SELECT 
                                            MENP_ID, 
                                            MENP_NOMBRE, 
                                            MENP_RUTA, 
                                            MENP_IDPADRE, 
                                            MENP_TIPO, 
                                            MENP_ESTADO 
                                        FROM 
                                            ADMIN.GU_TMENUPRINCIPAL 
                                        WHERE 
                                            MENP_ID = ? AND MENP_ESTADO = 1", [$menuId])->getResultArray();

        if (!empty($arr_menuprincipal)) {
            $menuInfo = $arr_menuprincipal[0];
            $menuType = $menuInfo['MENP_TIPO'];
            $parentMenuId = $menuInfo['MENP_IDPADRE'];
            $directPermissions = $db->query("SELECT 
                                                A.MENP_ID,
                                                A.PER_ID,
                                                B.PER_NOMBRE,
                                                B.PER_ESTADO 
                                            FROM 
                                                ADMIN.GU_TMENPTIENEPER A,
                                                ADMIN.GU_TPERMISOS B 
                                            WHERE 
                                                A.MENP_ID =  ?
                                            AND B.PER_ESTADO IN (1,2,3) 
                                            AND A.PER_ID = B.PER_ID 
                                            AND A.IND_ESTADO IN (1)",[$menuId])->getResultArray();

            /*
            #Función para obtener permisos de un menú dado
            $getPermissions = function($menuId) use ($db) {
                $permissions = $db->query("SELECT pm.PER_ID  FROM ADMIN.GU_TMENPTIENEPER pm  WHERE pm.MENP_ID = ? AND pm.IND_ESTADO = 1", [$menuId])->getResultArray();
                return array_column($permissions, 'PER_ID');
            };
            #Obtener permisos directos del menú
            $directPermissions  =   $getPermissions($menuId);
            #Obtener permisos del padre si es submenú o extensión
            if ($menuType == 1 || $menuType == 2) {
                if ($parentMenuId) {
                    $parentPermissions = $getPermissions($parentMenuId);
                    $logger->info("a - parentMenuId = {$parentMenuId} -  parentPermissions " . json_encode($parentPermissions) . " ");
                    $directPermissions = array_merge($directPermissions, $parentPermissions);
                }
            }
            #Obtener permisos del abuelo si es extensión
            if ($menuType == 2 && $parentMenuId) {
                $grandParentMenuId = $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL  WHERE MENP_ID = ?", [$parentMenuId])->getRowArray()['MENP_IDPADRE'];
                if ($grandParentMenuId && $grandParentMenuId != 0) {
                    $logger->info("b - parentMenuId = {$parentMenuId} -  grandParentMenuId  " . json_encode($grandParentMenuId) . " ");
                    $grandParentPermissions = $getPermissions($grandParentMenuId);

                    $logger->info("  grandParentPermissions  " . json_encode($grandParentPermissions) . " ");
                    $directPermissions = array_merge($directPermissions, $grandParentPermissions);
                }
            }
            #Eliminar duplicados
            $directPermissions = array_unique($directPermissions);
            */

        }
        return [
            'arr_menuprincipal' => $arr_menuprincipal,
            'directPermissions' => array_values($directPermissions) // Asegurarse de devolver un array indexado
        ];
    }
    
    #$tip = $aData['post']['tipo_de_extension'];
    #leyeda tip de  $aData['post']['tipo_de_extension'];
        #0 = sistema principal  -   abuelo
        #1 = submenu            -   padre 
        #2 = extesion           -   hijo

    #$listarMenup = $aData['post']['ind_extension_padre'];
    # cuando es = 0 , cero significa es abuelo y tiene queheredar hacia abajo 
    # cuando trae un numero, es de quien hereda segun el tipo de tipo_de_extension . calcular si hay que subir un nivel o 2 if 
    
    //use CodeIgniter\Log\Logger;
    public function editando_extension_last($aData) {
        $db = \Config\Database::connect();
        $logger     =   service('logger'); // Obtener la instancia del logger
        $db->transStart();
        try {
            $idExt          =   $aData['post']['idMen'];
            $nombre         =   $aData['post']['nombre'];
            $tip            =   $aData['post']['tipo_de_extension'];
            $listarMenup    =   $aData['post']['ind_extension_padre'];
            $check          =   $aData['post']['check'];
            $arrPrivilegios =   $aData['post']['arrPrivilegios'];

            $logger->info("*****************************************************************************");
            $logger->info(" Extensión:      =   {$idExt},       Nombre  = {$nombre},    Tipo = {$tip}   ");
            $logger->info(" listarMenup     =   {$listarMenup}, check   = {$check}                      ");
            $logger->info(" arrPrivilegios  =   " . json_encode($arrPrivilegios) . "                    ");
    
            $v_padre = 0;
            if ($tip != 0) {
                $arr_idPadre = $db->query("SELECT MENP_IDPADRE, MENP_TIPO FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getRowArray();
                $v_padre = $arr_idPadre['MENP_IDPADRE'];
                $logger->info("Padre encontrado: MENP_IDPADRE = {$v_padre}");
            }
    
            $db->table('ADMIN.GU_TMENUPRINCIPAL')->set([
                'MENP_NOMBRE' => $nombre,
                'MENP_ESTADO' => $check,
                'MENP_TIPO' => $tip,
                'MENP_IDPADRE' => $v_padre,
                'MENP_FRAME' => 3
            ])->where('MENP_ID', $idExt)->update();
    
            if ($db->error()['code']) {
                $logger->error("Error en la actualización de ADMIN.GU_TMENUPRINCIPAL: " . $db->error()['message']);
                throw new \Exception($db->error()['message']);
            }
    
            $logger->info("Actualización de ADMIN.GU_TMENUPRINCIPAL exitosa para MENP_ID = {$idExt}");
    
            // Marcar permisos actuales como inactivos
            $sqlUpdate = "UPDATE ADMIN.GU_TMENPTIENEPER SET IND_ESTADO = 0 WHERE MENP_ID = ?";
            $db->query($sqlUpdate, [$idExt]);
    
            if ($db->error()['code']){
                $logger->error("Error en la actualización de permisos: " . $db->error()['message']);
                throw new \Exception($db->error()['message']);
            }
    
            // Insertar o actualizar permisos
            foreach ($arrPrivilegios as $perId) {
                $sqlCheck = "SELECT ID_MPTP  FROM ADMIN.GU_TMENPTIENEPER WHERE MENP_ID = ? AND PER_ID = ?";
                $existingPermission = $db->query($sqlCheck, [$idExt, $perId])->getRowArray();
                if ($db->error()['code']) {
                    $logger->error("Error en la verificación de permisos: " . $db->error()['message']);
                    throw new \Exception($db->error()['message']);
                }
    
                if ($existingPermission) {
                    // Actualizar permiso existente
                    $sqlUpdatePermission = "UPDATE ADMIN.GU_TMENPTIENEPER  SET IND_ESTADO = 1  WHERE ID_MPTP = ?";
                    $db->query($sqlUpdatePermission, [$existingPermission['ID_MPTP']]);
                    if ($db->error()['code']) {
                        $logger->error("Error en la actualización de permisos: " . $db->error()['message']);
                        throw new \Exception($db->error()['message']);
                    }
                } else {
                    // Insertar nuevo permiso
                    $sqlInsert = "INSERT INTO ADMIN.GU_TMENPTIENEPER (MENP_ID, PER_ID, IND_ESTADO) VALUES (?, ?, 1)";
                    $db->query($sqlInsert, [$idExt, $perId]);
                    if ($db->error()['code']) {
                        $logger->error("Error en la inserción de permisos: " . $db->error()['message']);
                        throw new \Exception($db->error()['message']);
                    }
                }
            }
    
            $logger->info("Permisos actualizados exitosamente para MENP_ID = {$idExt}");
            // Heredar permisos según el tipo de menú
            //******************************************************
            $this->heredarPermisos($db, $idExt, $arrPrivilegios, $tip);
            //******************************************************

            $db->transComplete();
            if ($db->transStatus() === false) {
                $logger->error("Error en la transacción");
                throw new \Exception("Transaction failed");
            }
            $logger->info("Transacción completada exitosamente para MENP_ID = {$idExt}");
            $logger->info("*****************************************************************************");
            return [
                "data" => $aData,
                "status" => true,
                "error" => "",
            ];
        } catch (\Exception $e) {
            $db->transRollback();
            $logger->error("Excepción capturada: " . $e->getMessage());
            return [
                "data" => $aData,
                "status" => false,
                "error" => $e->getMessage(),
            ];
        }
    }
    
    private function heredarPermisos($db, $menuId, $permissions, $menuType) {
        $logger = service('logger'); // Obtener la instancia del logger
    
        $logger->info("heredarPermisos -> menuId = {$menuId} , permissions => " . json_encode($permissions) . " , menuType => {$menuType}");
    
        if ($menuType == 0) { // Si es un menú principal (Abuelo), heredar permisos a submenús y extensiones
            $subMenus = $db->query("SELECT MENP_ID FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_IDPADRE = ?", [$menuId])->getResultArray();
            foreach ($subMenus as $subMenu) {
                $logger->info("  -  Heredando Abuelo/Menu a hijo - Sub Menu  = {$subMenu['MENP_ID']}");
                $this->actualizarPermisos($db, $subMenu['MENP_ID'], $permissions, false);
                $extensions = $db->query("SELECT MENP_ID FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_IDPADRE = ?", [$subMenu['MENP_ID']])->getResultArray();
                foreach ($extensions as $extension) {
                    $logger->info("Heredando permisos a la extensión MENP_ID = {$extension['MENP_ID']}");
                    $this->actualizarPermisos($db, $extension['MENP_ID'], $permissions, false);
                }
            }
        }
    
        if ($menuType == 2) { // Si es una extensión, heredar permisos al padre y abuelo
            $parentMenuId = $db->query("SELECT MENP_IDPADRE  FROM ADMIN.GU_TMENUPRINCIPAL  WHERE MENP_ID = ?", [$menuId])->getRowArray()['MENP_IDPADRE'];
            if ($parentMenuId) {
                $logger->info("La extensión  = {$menuId} su sub-menu padre es MENP_IDPADRE = {$parentMenuId} ,  Heredando hacia arriba los permisos " . json_encode($permissions) . "");
                // Actualizar permisos del padre
                $this->actualizarPermisos($db, $parentMenuId, $permissions, true);
                $grandParentMenuId = $db->query("SELECT MENP_IDPADRE  FROM ADMIN.GU_TMENUPRINCIPAL  WHERE MENP_ID = ?", [$parentMenuId])->getRowArray()['MENP_IDPADRE'];
                // Buscar permisos del abuelo y combinarlos
                if ($grandParentMenuId && $grandParentMenuId != 0) {
                    $logger->info("Heredando permisos al abuelo/extension  MENP_IDPADRE = {$grandParentMenuId}");
                    // Actualizar permisos del abuelo
                    $this->actualizarPermisos($db, $grandParentMenuId, $permissions, true);
                }
            }
        }
    
        if ($menuType == 1) { // Si es un submenú (Hijo), heredar permisos al padre y a sus propias extensiones
            $parentMenuId = $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL   WHERE MENP_ID = ?", [$menuId])->getRowArray()['MENP_IDPADRE'];
            if ($parentMenuId) {
                $logger->info("Heredando permisos al padre MENP_IDPADRE = {$parentMenuId}");
                // Actualizar permisos del padre
                $this->actualizarPermisos($db, $parentMenuId, $permissions, true);
            }
            $extensions = $db->query("SELECT MENP_ID FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_IDPADRE = ?", [$menuId])->getResultArray();
            foreach ($extensions as $extension) {
                $logger->info("Heredando permisos a la extensión MENP_ID = {$extension['MENP_ID']}");
                $this->actualizarPermisos($db, $extension['MENP_ID'], $permissions, false);
            }
        }
    }
    
    private function actualizarPermisos($db, $menuId, $permissions, $merge = false) {
        $logger = service('logger'); // Obtener la instancia del logger
    
        // Si mergear es verdadero, obtener los permisos existentes y combinarlos
        if ($merge) {
            $existingPermissions = $db->query("SELECT PER_ID  FROM ADMIN.GU_TMENPTIENEPER  WHERE MENP_ID = ? AND IND_ESTADO = 1", [$menuId])->getResultArray();
            $existingPermissions = array_column($existingPermissions, 'PER_ID');
            $permissions = array_unique(array_merge($permissions, $existingPermissions));
        }
    
        // Marcar permisos actuales como inactivos
        $sqlUpdate = "UPDATE ADMIN.GU_TMENPTIENEPER SET IND_ESTADO = 0  WHERE MENP_ID = ?";
        $db->query($sqlUpdate, [$menuId]);
    
        if ($db->error()['code']) {
            $logger->error("Error en la actualización de permisos para MENP_ID = {$menuId}: " . $db->error()['message']);
            throw new \Exception($db->error()['message']);
        }
    
        // Insertar o actualizar permisos
        foreach ($permissions as $perId) {
            $sqlCheck = "SELECT ID_MPTP  FROM ADMIN.GU_TMENPTIENEPER   WHERE MENP_ID = ? AND PER_ID = ?";
            $existingPermission = $db->query($sqlCheck, [$menuId, $perId])->getRowArray();
            $logger->info("sqlCheck  menuId = {$menuId}: perId =  {$perId} === " . json_encode($existingPermission) . "  } ");
            if ($db->error()['code']) {
                $logger->error("Error en la verificación de permisos para MENP_ID = {$menuId}: " . $db->error()['message']);
                throw new \Exception($db->error()['message']);
            }
            if ($existingPermission) {
                // Actualizar permiso existente
                $sqlUpdatePermission = "UPDATE ADMIN.GU_TMENPTIENEPER SET IND_ESTADO = 1  WHERE ID_MPTP = ?";
                $db->query($sqlUpdatePermission, [$existingPermission['ID_MPTP']]);
    
                if ($db->error()['code']) {
                    $logger->error("Error en la actualización de permisos para MENP_ID = {$menuId}: " . $db->error()['message']);
                    throw new \Exception($db->error()['message']);
                }
            } else {
                // Insertar nuevo permiso
                $sqlInsert = "INSERT INTO ADMIN.GU_TMENPTIENEPER (MENP_ID, PER_ID, IND_ESTADO) VALUES (?, ?, 1)";
                $db->query($sqlInsert, [$menuId, $perId]);
                if ($db->error()['code']) {
                    $logger->error("Error en la inserción de permisos para MENP_ID = {$menuId}: " . $db->error()['message']);
                    throw new \Exception($db->error()['message']);
                }
            }
        }
    }

    public function editando_extension_old($aData) {
        $idExt = $aData['post']['idMen'];
        $nombre = $aData['post']['nombre'];
        //$listarMenup = $aData['post']['ind_extension_padre'];
        $tip = $aData['post']['tipo_de_extension'];
        $check = $aData['post']['check'];
        $arrPrivilegios = $aData['post']['arrPrivilegios'];
        $bool_checked = $aData['post']['bool_checked'];
        $db = \Config\Database::connect();
        $logger = service('logger'); // Obtener la instancia del logger
        $db->transStart();
        $arr_idPadre = $db->query("SELECT MENP_IDPADRE, MENP_TIPO FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getRowArray();
        $listarMenup = $arr_idPadre['MENP_IDPADRE'];
        $db->table('ADMIN.GU_TMENUPRINCIPAL')->set([
            'MENP_NOMBRE'   => $nombre,
            'MENP_ESTADO'   => $check,
            'MENP_TIPO'     => $tip,
            'MENP_IDPADRE'  => $listarMenup,
            'MENP_FRAME'    => 3
        ])->where('MENP_ID', $idExt)->update();
        /*
        $logger->info("**************************************************************************** ");
        $logger->info("*******************      editando_extension_old     ************************ ");
        $logger->info(" Extension:      =   {$idExt},       Nombre  = {$nombre},    Tipo = {$tip}   ");
        $logger->info(" Padre           =   {$listarMenup}, check   = {$check}                      ");
        $logger->info(" arrPrivilegios  =   " . json_encode($arrPrivilegios) . "                    ");
        $logger->info("**************************************************************************** ");
        */
        $count = count($arrPrivilegios);
        #$logger->info("**************************************************************************** ");
        #$logger->info("0 .- count(arrPrivilegios) = {$count} ");
        if ($count > 0) {
            $sigMen = 0;
            while ($sigMen <= 2) {
                #$logger->info("1 .- sigMen = {$sigMen} ");
                if ($sigMen == 0) {
                    #$logger->info("2 .- update ADMIN.GU_TMENPTIENEPER a cero = {$sigMen} ");
                    $db->table('ADMIN.GU_TMENPTIENEPER')->set('IND_ESTADO', 0)->where('MENP_ID', $idExt)->update();
                }
                foreach ($arrPrivilegios as $aux => $idPer) {
                    #$logger->info("3 .- idPer = {$idPer} ");
                    #$logger->info("4 .- idExt = {$idExt} ");
                    $res = $db->query("SELECT ID_MPTP FROM ADMIN.GU_TMENPTIENEPER WHERE PER_ID = ? AND MENP_ID = ?", [$idPer, $idExt])->getResultArray();
                    #$logger->info("5 .- res = " . json_encode($res) . "  ");
                    if (count($res)>0){
                        #$logger->info("5.0 .- Update = {$v_id_mptp} ");
                        $v_id_mptp = $res[0]['ID_MPTP'];
                        $db->table('ADMIN.GU_TMENPTIENEPER')
                        ->set('IND_ESTADO', 1)
                        ->where('ID_MPTP', $v_id_mptp)
                        ->update();
                        /*
                        $db->table('ADMIN.GU_TMENPTIENEPER')
                        ->set('IND_ESTADO', 1)
                        ->where('PER_ID', $idPer)
                        ->where('MENP_ID', $idExt)
                        ->update();
                        */
                    } else {
                        #$logger->info("5.1 .- idExt = {$idExt} - idPer = {$idPer}  ");
                        $data = [
                            'MENP_ID' => $idExt,
                            'PER_ID' => $idPer,
                            'IND_ESTADO' => 1
                        ];
                        $db->table('ADMIN.GU_TMENPTIENEPER')->insert($data);
                    }
                }

                if ($listarMenup != 0 && $sigMen == 0) {
                    $idExt = $listarMenup;
                    #$logger->info("6 .- cambio de .- idExt = {$idExt} x listarMenup = {$listarMenup}  ");
                } else if ($sigMen == 1) {
                    $idPadre1 = $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getResultArray();
                    #$logger->info("8 .- en segunda vuelta " . json_encode($idPadre1) . "  ");
                    if (count($idPadre1)>0) {
                        $idExt = $idPadre1[0]['MENP_IDPADRE'];
                        #$listarMenup = $idExt;
                        #$logger->info("9 .-idPadre1  cambio de .- idExt = {$idExt}  ");
                    } else {
                        break;
                    }
                } else {
                    break;
                }
                $sigMen++;
                #$logger->info("10 .- new sigMen {$sigMen}  ");
            }
        }
        #$logger->info("*****************************************************************************");
        $db->transComplete();
        return [
            "data" => $aData,
            "status" => $db->transStatus()
        ];
    }

    /*
    public function editando_extension_old($aData) {
        $idExt = $aData['post']['idMen'];
        $nombre = $aData['post']['nombre'];
        //$listarMenup = $aData['post']['ind_extension_padre'];
        $tip = $aData['post']['tipo_de_extension'];
        $check = $aData['post']['check'];
        $arrPrivilegios = $aData['post']['arrPrivilegios'];
        $bool_checked = $aData['post']['bool_checked'];
        $db = \Config\Database::connect();
        $logger = service('logger'); // Obtener la instancia del logger
        $db->transStart();
        $arr_idPadre = $db->query("SELECT MENP_IDPADRE, MENP_TIPO FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getRowArray();
        $listarMenup = $arr_idPadre['MENP_IDPADRE'];
        $db->table('ADMIN.GU_TMENUPRINCIPAL')->set([
            'MENP_NOMBRE'   => $nombre,
            'MENP_ESTADO'   => $check,
            'MENP_TIPO'     => $tip,
            'MENP_IDPADRE'  => $listarMenup,
            'MENP_FRAME'    => 3
        ])->where('MENP_ID', $idExt)->update();
           
        #$logger->info("**************************************************************************** ");
        #$logger->info("*******************      editando_extension_old     ************************ ");
        #$logger->info(" Extension:      =   {$idExt},       Nombre  = {$nombre},    Tipo = {$tip}   ");
        #$logger->info(" Padre           =   {$listarMenup}, check   = {$check}                      ");
        #$logger->info(" arrPrivilegios  =   " . json_encode($arrPrivilegios) . "                    ");
        #$logger->info("**************************************************************************** ");
        
        $count = count($arrPrivilegios);
        if ($count > 0) {
            $sigMen = 0;
            while ($sigMen <= 2) {
                if ($sigMen == 0) {
                    $db->table('ADMIN.GU_TMENPTIENEPER')->set('IND_ESTADO', 0)->where('MENP_ID', $idExt)->update();
                }
                foreach ($arrPrivilegios as $aux => $idPer) {
                    $res = $db->query("SELECT PER_ID FROM ADMIN.GU_TMENPTIENEPER WHERE PER_ID = ? AND MENP_ID = ?", [$idPer, $idExt])->getResultArray();
                    if (count($res) > 0) {
                        $db->table('ADMIN.GU_TMENPTIENEPER')
                        ->set('IND_ESTADO', 1)
                        ->where('PER_ID', $idPer)
                        ->where('MENP_ID', $idExt)
                        ->update();
                    } else {
                        $data = [
                            'MENP_ID' => $idExt,
                            'PER_ID' => $idPer,
                            'IND_ESTADO' => 1
                        ];
                        $db->table('ADMIN.GU_TMENPTIENEPER')->insert($data);
                    }
                }
                
                if ($listarMenup != 0 && $sigMen == 0) {
                    $idExt = $listarMenup;
                } else if ($sigMen == 1) {
                    $idPadre1 = $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getResultArray();
                    if ($idPadre1) {
                        $idExt = $idPadre1[0]['MENP_IDPADRE'];
                        $listarMenup = $idExt;
                    } else {
                        break;
                    }
                } else {
                    break;
                }
                $sigMen++;
            }

        }
        $db->transComplete();
        return [
            "data" => $aData,
            "status" => $db->transStatus()
        ];
    }
    */








}
?>