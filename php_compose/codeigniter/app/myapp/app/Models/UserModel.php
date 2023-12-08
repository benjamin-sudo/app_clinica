<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function ini_contendido(){
        $db     =   db_connect();
        $sql    =   "SELECT 
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
        $menuData           =   $db->query($sql)->getResultArray();
        $menu               =   [];
        foreach($menuData as $row) {
            $menuId         =   $row['main_id'];
            $subMenuId      =   $row['sub_id'];
            $extensionId    =   $row['ext_id'];
            // Organizar en estructura jerárquica
            if (!isset($menu[$menuId])) {
                $menu[$menuId] = [
                    'data'          => $row, // Datos del menú principal
                    'submenus'      => []
                ];
            }
            if ($subMenuId && !isset($menu[$menuId]['submenus'][$subMenuId])) {
                $menu[$menuId]['submenus'][$subMenuId] = [
                    'data'          => $row, // Datos del submenu
                    'extensions'    => []
                ];
            }
            if ($extensionId) {
                $menu[$menuId]['submenus'][$subMenuId]['extensions'][$extensionId] = $row; // Datos de la extensión
            }
        }

        // Variable para almacenar el HTML
        $html = "";
        foreach ($menu as $mainId => $mainMenu) {
            // Acceder a los datos del menú principal
            $mainData = $mainMenu['data'];
            // Generar el HTML para el menú principal
            $html .= "<div class='card'  style='margin-bottom: 8px;'>";
            $html .= "<div class='card-body'>";
            $html .= "<h5 class='card-title' style='color:#888888;'><i class='fa fa-list' aria-hidden='true'></i><b>&nbsp;" . htmlspecialchars($mainData['main_nombre']) . "</b></h5>";
            // Generar la lista de submenús y sus extensiones
            $html .= "<ul class='list-group'>";
            foreach ($mainMenu['submenus'] as $subMenuId => $subMenu) {
                // Acceder a los datos del submenú
                $subData = $subMenu['data'];
                // Aquí agregas el nombre del submenú
                $html .= "<b>" . htmlspecialchars($subData['sub_nombre']) . "</b><ul>";
                // Acceder a los datos de las extensiones
                foreach ($subMenu['extensions'] as $extensionId => $extension) {
                    $html .= "<li><i class='bi bi-box-seam'></i>&nbsp;" . htmlspecialchars($extension['ext_nombre']) . "</li>";
                }
                $html .= "</ul></li>"; // Cerrar la lista del submenú
            }
            $html .= "</ul>";
            $html .= "</div>";
            $html .= "</div>";
        }
        #Consulta para roles creados
        $query1 = $db->query("SELECT * FROM ADMIN.GU_TPERMISOS WHERE PER_ESTADO IN (1,2,3) ")->getResult();
        #Consulta por establecimientos
        $query2 = $db->query("SELECT * FROM ADMIN.SS_TEMPRESAS WHERE IND_ESTADO = 'V' ")->getResultArray();
        return $output = [
            'menu_principal'    =>  array_values($menu), // Convertir a array para un mejor formato JSON
            'menuData'          =>  $menuData,
            'roles_creados'     =>  $query1,
            'arr_empresas'      =>  $query2,
            'html'              =>  $html,
        ];
    }

    public function buscaExtArch($aData){
        $db         = db_connect();
        $rutaactual = $aData['rutaactual'];
        return $db->query("select A.MENP_RUTA from ADMIN.GU_TMENUPRINCIPAL A WHERE A.MENP_RUTA='$rutaactual'")->getResult();
    }

    public function grabarExt($v_post){
        $opt                    =   $v_post['opt'];
        $nombre                 =   $v_post['nomExt'];
        $rutaactual             =   $v_post['nomArch'];
        $check                  =   $v_post['bool_checked']=="true"?1:0;
        $arrPrivilegios         =   $v_post['arr_permisos']; 
        $tip                    =   $v_post['extension_principal'];  
        $listarMenup            =   $v_post['listarMenup'];
        $db     =   \Config\Database::connect();
        $db->transStart();
        $data   =   [
            'MENP_NOMBRE'   => $nombre,
            'MENP_ESTADO'   => $check,
            'MENP_TIPO'     => $tip,
            'MENP_IDPADRE'  => $listarMenup,
            'MENP_RUTA'     => $rutaactual,
            'MENP_FRAME'    => 3
        ];
        $constructora = $db->table('ADMIN.GU_TMENUPRINCIPAL');
        $constructora->insert($data);

        $idSeq  = $db->insertID();
        $idExt  = $idSeq;
        $count  = count($arrPrivilegios);

        if ($count > 0) {
            $sigMen = 0;
            while ($sigMen <= 2) {
                for ($i = 0; $i < $count; $i++) {
                    $idPer  = $arrPrivilegios[$i];
                    $res = $db->query("select PER_ID  FROM ADMIN.GU_TMENPTIENEPER WHERE PER_ID = $idPer AND MENP_ID = $idExt ")->getResult();
                    if (count($res)>0){
                        $builder = $db->table('ADMIN.GU_TMENPTIENEPER');
                        $builder->set('IND_ESTADO', 1);
                        $builder->where('PER_ID', $idPer);
                        $builder->where('MENP_ID', $idExt);
                        $builder->update();
                    } else {
                        $data   =   [
                                        //'ID_MPTP'     => $idSeqPriv,
                                        'MENP_ID'       => $idExt,
                                        'PER_ID'        => $idPer,
                                        'IND_ESTADO'    => 1
                                    ];
                        $constructora = $db->table('ADMIN.GU_TMENPTIENEPER');
                        $constructora->insert($data);
                    }
                }

                if ($listarMenup != 0 && $sigMen == 0) {
                    $idExt = $idSeq;
                } else if ($sigMen == 1) {
                    $query = $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt]);
                    $idPadre1 = $query->getResultArray();
                    if ($idPadre1) {
                        $idExt = $idPadre1[0]['MENP_IDPADRE'];
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
        return true;
    }

    public function creaPrivilegio($nombre) {
        $db     =   \Config\Database::connect();
        $db->transStart();
        $data   =   [
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
            'ingreso_paciente' => $query->getResult(),
            'hospitalizado' => $query1->getResult(),
            'num' => $num
        );
    }
}
?>
