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
                    'data'      => $row, // Datos del menú principal
                    'submenus'  => []
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

        //*************************************** */
        // Variable para almacenar el HTML
        $html   =   "";
        foreach ($menu as $mainId => $mainMenu){
            //Acceder a los datos del menú principal
            $mainData = $mainMenu['data'];
            //Generar el HTML para el menú principal
            $html .=    "<div class='card' style='margin-bottom: 8px;'>";
            $html .=    "<div class='card-body'>";

            $html .=    "<h3 class='card-title' style='color:#888888;'>";
                $html .=    "<a href='javascript:editarExt(".$mainData['main_id'].")'><i class='bi bi-pencil'></i></a>" ;
                $html .=    htmlspecialchars($mainData['main_nombre']);
            $html .=    "</h3>";
            // Generar la lista de submenús y sus extensiones
            $html   .= "<ul class='list-group'>";
            foreach ($mainMenu['submenus'] as $subMenuId => $subMenu){
                // Acceder a los datos del submenú
                $subData    =   $subMenu['data'];
                // Aquí agregas el nombre del submenú
                $html   .=  "<h5 style='color:#888888;margin-left: 10px;'>";
                $html   .=  "<a href='javascript:editarExt(".$subData['sub_id'].")'><i class='bi bi-pencil'></i></a>".htmlspecialchars($subData['sub_nombre'])."";
                $html   .=  "</h5>";
                
                $html   .=  "<ul class='no-bullet'>";
                // Acceder a los datos de las extensiones
                foreach ($subMenu['extensions'] as $extensionId => $extension) {
                    $html   .=  "<li><h6 style='color:#888888;margin-left: 15px;'><a href='javascript:editarExt(".$subData['ext_id'].")'>";
                    $html   .=  "<i class='bi bi-pencil'></i></a>&nbsp;" . htmlspecialchars($extension['ext_nombre'])."</h6>";
                    $html   .=  "</li>";
                }
                $html       .= "</ul>"; // Cerrar la lista del submenú
            }
            
            $html   .=  "</ul>";
            $html   .=  "</div>";
            $html   .=  "</div>";
        }

        return $output  = [
            'menu_principal'    =>  array_values($menu), // Convertir a array para un mejor formato JSON
            'menuData'          =>  $menuData,
            'roles_creados'     =>  $db->query("SELECT * FROM ADMIN.GU_TPERMISOS WHERE PER_ESTADO IN (1,2,3) ")->getResultArray(),
            'arr_empresas'      =>  $db->query("SELECT * FROM ADMIN.SS_TEMPRESAS WHERE IND_ESTADO = 'V' ")->getResultArray(),
            'html'              =>  $html,
        ];
    }


    public function buscaExtArch($aData){
        $db = db_connect();
        $rutaactual = $aData['rutaactual'];
        return $db->query("select A.MENP_RUTA from ADMIN.GU_TMENUPRINCIPAL A WHERE A.MENP_RUTA='$rutaactual'")->getResult();
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
        $run_gestion            =   $aData['run']."-".$aData['dv'];
        $status_existe          =   true;
        $getResultArray         =   [];
        $arr_privilegios        =   [];
        $arr_empresa            =   [];
        $db                     =   db_connect();
        $get_fe_users           =   $db->query("SELECT * FROM ADMIN.FE_USERS WHERE TX_INTRANETSSAN_RUN = ".$aData['run'])->getResultArray();
        if(count($get_fe_users)>0){
            $arr_privilegios    =   $db->query("SELECT * FROM ADMIN.GU_TUSUTIENEPER WHERE IND_ESTADO = 1 AND ID_UID =".$get_fe_users[0]['ID_UID'])->getResultArray();
            $arr_empresa        =   $db->query("SELECT * FROM ADMIN.GU_TUSUXEMPRESA WHERE IND_ESTADO = 1 AND ID_UID =".$get_fe_users[0]['ID_UID'])->getResultArray();
        } else {
            $status_existe      =   false;    
        }
        return [
            'status'            =>  true,
            'arr_privilegios'   =>  $arr_privilegios,
            'arr_empresa'       =>  $arr_empresa,
            'getResultArray'    =>  $get_fe_users,
            'status_existe'     =>  $status_existe, 
            'date'              =>  date("d-m-Y"),
            'run_gestion'       =>  $run_gestion
        ];
    }

    public function grabaUsu($aData){
        $status                     =   true;
        $name                       =   $aData['post']['nombres']." ".$aData['post']['apepate']." ".$aData['post']['apemate'];
        $arr_run                    =   str_replace('.','',$aData['post']['user']);
        $db                         =   \Config\Database::connect();
        $db->transStart();
        $hash                       =   password_hash($aData['post']['pass'],PASSWORD_BCRYPT);
        $dataUs                     =   array(
            //'ID_UID'              =>  $uID,
            'USERNAME'              =>  trim($arr_run),
            'NAME'                  =>  $name, 
            'FIRST_NAME'            =>  $aData['post']['nombres'],
            'MIDDLE_NAME'           =>  $aData['post']['apepate'], 
            'LAST_NAME'             =>  $aData['post']['apemate'],
            'EMAIL'                 =>  $aData['post']['email'],
            'TELEPHONE'             =>  0,
            'PASSWORD'              =>  $hash,
            'LOCKTODOMAIN'          =>  $hash,
            'DISABLE'               =>  $aData['post']['activo'],       //activo
            'STATUS'                =>  $aData['post']['superUser'],    //superUser 
            'TX_INTRANETSSAN_RUN'   =>  trim(explode("-",$arr_run)[0]),
            'TX_INTRANETSSAN_DV'    =>  trim(explode("-",$arr_run)[1]),
            'DAYLIGHT'              =>  1
        );
        //**************************************************************
        $last_id            =   0;
        $arr_username       =   $db->query("SELECT ID_UID FROM ADMIN.FE_USERS WHERE USERNAME = ".$arr_run)->getResultArray();
        if(count($arr_username)>0){
            $last_id        =   $arr_username[0]['ID_UID'];
            $constructora   =   $db->table('ADMIN.FE_USERS');
            $constructora->set($dataUs);
            $constructora->where('ID_UID',$last_id);
            $updated        =   $constructora->update();
        } else {
            $constructora   =   $db->table('ADMIN.FE_USERS');
            $constructora->insert($dataUs);
            $last_id        =   $db->insertID();
        }
        
        //privilegios
        $arrPrivilegios                 =   $aData['post']['arrPrivilegios'];
        if(count($arrPrivilegios)>0){
            $constructora0              =   $db->table('ADMIN.GU_TUSUTIENEPER');
            $constructora0->set(['IND_ESTADO' => 0]);
            $constructora0->where('ID_UID',$last_id);
            $constructora0->update();
            foreach($arrPrivilegios as $i => $row){
                $get_tusutieneper       =   $db->query("SELECT ID_UTP FROM ADMIN.GU_TUSUTIENEPER WHERE PER_ID IN (".$row.") AND ID_UID  = ".$last_id)->getResultArray();
                if (count($get_tusutieneper)>0){
                    $constructora3      =   $db->table('ADMIN.GU_TUSUTIENEPER');
                    $constructora3->set(['IND_ESTADO' => 1]);
                    $constructora3->where('ID_UTP',$get_tusutieneper[0]['ID_UTP']);
                    $constructora3->update();
                } else {
                    $constructora2      =   $db->table('ADMIN.GU_TUSUTIENEPER');
                    $constructora2->insert(['ID_UID'=>$last_id,'PER_ID'=>$row,'IND_ESTADO'=>1]);
                }
            }
        }

        //establecimientos
        $arrEmpresas                    =   $aData['post']['arrEmpresas'];
        if(count($arrEmpresas)>0){
            $constructora4              =   $db->table('ADMIN.GU_TUSUXEMPRESA');
            $constructora4->set(['IND_ESTADO' => 0]);
            $constructora4->where('ID_UID',$last_id);
            foreach($arrEmpresas as $i => $row){
                $get_arrEmpresas        =   $db->query("SELECT ID_UXE FROM ADMIN.GU_TUSUXEMPRESA WHERE COD_ESTABL IN (".$row.") AND ID_UID = ".$last_id)->getResultArray();
                if (count($get_arrEmpresas)>0){
                    $constructora5      =   $db->table('ADMIN.GU_TUSUXEMPRESA');
                    $constructora5->set(['IND_ESTADO' => 1]);
                    $constructora5->where('ID_UXE',$get_arrEmpresas[0]['ID_UXE']);
                    $constructora5->update();
                } else {
                    $constructora6      =    $db->table('ADMIN.GU_TUSUXEMPRESA');
                    $constructora6->insert(['ID_UID'=>$last_id,'COD_ESTABL'=>$row,'IND_ESTADO'=>1]);
                }
            }
        }
        $db->transComplete();
        return  [
                    'last_id'   =>  $last_id,
                    'user'      =>  $arr_run,
                    'status'    =>  $status,
                ];
    }

    public function buscaExtEdit($aData){
        $db         =   db_connect();
        $id         =   $aData['idMen'];
        $query      =   $db->query("SELECT 
                                        MENP_ID, 
                                        MENP_NOMBRE, 
                                        MENP_RUTA, 
                                        MENP_IDPADRE, 
                                        MENP_TIPO, 
                                        MENP_ESTADO 
                                    FROM 
                                        ADMIN.GU_TMENUPRINCIPAL 
                                    WHERE 
                                        MENP_ID         =   ".$id)->getResultArray();
        

        $SQL        =   "SELECT 
                            A.MENP_ID,
                            A.PER_ID,
                            B.PER_NOMBRE,
                            B.PER_ESTADO 
                        FROM 
                            ADMIN.GU_TMENPTIENEPER A, 
                            ADMIN.GU_TPERMISOS B 
                        WHERE 
                            A.MENP_ID = ".$id." AND PER_ESTADO = 1 AND A.PER_ID = B.PER_ID AND IND_ESTADO = 1";


        $query2     =   $db->query("SELECT 
                                        A.MENP_ID,
                                        A.PER_ID,
                                        B.PER_NOMBRE,
                                        B.PER_ESTADO 
                                    FROM 
                                        ADMIN.GU_TMENPTIENEPER A,
                                        ADMIN.GU_TPERMISOS B 
                                    WHERE 
                                        A.MENP_ID       =   ".$id."     AND 
                                        B.PER_ESTADO    =   1           AND
                                        A.PER_ID        =   B.PER_ID    AND 
                                        A.IND_ESTADO    =   1 ")->getResultArray();

        return  [
                    'id' =>  $id,
                    'SQL' =>  $SQL,
                    'gu_tmenuprincipal' =>  $query,
                    'arr_permisos' =>  $query2,
                ];                    
    }


    public function grabarExt($v_post){
        $opt                    =   $v_post['opt'];
        $nombre                 =   $v_post['nomExt'];
        $rutaactual             =   $v_post['nomArch'];
        $check                  =   $v_post['bool_checked']=="true"?1:0;
        $arrPrivilegios         =   $v_post['arr_permisos']; 
        $tip                    =   $v_post['extension_principal'];  
        $listarMenup            =   $v_post['listarMenup'];
        $db                     =   \Config\Database::connect();
        $db->transStart();
        $data                   =   [
                                        'MENP_NOMBRE'   => $nombre,
                                        'MENP_ESTADO'   => $check,
                                        'MENP_TIPO'     => $tip,
                                        'MENP_IDPADRE'  => $listarMenup,
                                        'MENP_RUTA'     => $rutaactual,
                                        'MENP_FRAME'    => 3
                                    ];
        $constructora = $db->table('ADMIN.GU_TMENUPRINCIPAL');
        $constructora->insert($data);
        $idSeq  =   $db->insertID();
        $idExt  =   $idSeq;
        $count  =   count($arrPrivilegios);
        if ($count > 0) {
            $sigMen     =   0;
            while ($sigMen <= 2) {
                foreach ($arrPrivilegios as $key => $idPer) {
                    $res = $db->query("select PER_ID  FROM ADMIN.GU_TMENPTIENEPER WHERE PER_ID = $idPer AND MENP_ID = $idExt ")->getResult();
                    if (count($res)>0){
                        $builder = $db->table('ADMIN.GU_TMENPTIENEPER');
                        $builder->set('IND_ESTADO', 1);
                        $builder->where('PER_ID', $idPer);
                        $builder->where('MENP_ID', $idExt);
                        $builder->update();
                    } else {
                        $data   =   [
                                        'MENP_ID'       =>  $idExt,
                                        'PER_ID'        =>  $idPer,
                                        'IND_ESTADO'    =>  1
                                    ];
                        $constructora = $db->table('ADMIN.GU_TMENPTIENEPER');
                        $constructora->insert($data);
                    }
                }
                if ($listarMenup != 0 && $sigMen == 0) {
                    $idExt      =   $idSeq;
                } else if ($sigMen == 1) {
                    $idPadre1   =   $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getResultArray();
                    if ($idPadre1){
                        $idExt  =   $idPadre1[0]['MENP_IDPADRE'];
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

    public function editando_extension($aData){
        $idExt              =   $aData['post']['idMen'];
        $nombre             =   $aData['post']['nombre'];
        $listarMenup        =   $aData['post']['listarMenup'];
        $tip                =   $aData['post']['extension_principal'];    
        $check              =   $aData['post']['check'];
        $arrPrivilegios     =   $aData['post']['arrPrivilegios'];
        $bool_checked       =   $aData['post']['bool_checked'];
        //*********************************************************/
        $db                 =   \Config\Database::connect();
        $db->transStart();
        $obj_update         =   $db->table('ADMIN.GU_TMENUPRINCIPAL');
        $obj_update->set([
            'MENP_NOMBRE'   =>  $nombre,
            'MENP_ESTADO'   =>  $check,
            'MENP_TIPO'     =>  $tip,
            'MENP_IDPADRE'  =>  $listarMenup,
            'MENP_FRAME'    =>  3
        ]);
        $obj_update->where('MENP_ID',$idExt);
        $obj_update->update();
        //******************************************************** */
        $count              =   count($arrPrivilegios);
        if ($count > 0) {
            $sigMen = 0;
            while ($sigMen <= 2) { //Pasa 3 veces si se detectan menus padres // 
                if ($sigMen == 0) {
                    $db->table('ADMIN.GU_TMENPTIENEPER')->set('IND_ESTADO',0)->where('MENP_ID',$idExt)->update();
                }
                foreach ($arrPrivilegios as $key => $idPer) {
                    $res            =   $db->query("SELECT PER_ID FROM ADMIN.GU_TMENPTIENEPER WHERE PER_ID = $idPer AND MENP_ID = $idExt ")->getResultArray();
                    if (count($res) > 0) {
                        // Actualizar el registro existente
                        $builder1   =   $db->table('ADMIN.GU_TMENPTIENEPER');
                        $builder1->set('IND_ESTADO', 1)
                            ->where('PER_ID', $idPer)
                            ->where('MENP_ID', $idExt)
                            ->update();
                    } else {
                        // Insertar un nuevo registro
                        $data = [
                            //'ID_MPTP'  => $idSeqPriv, // Descomentar si es necesario
                            'MENP_ID'    => $idExt,
                            'PER_ID'     => $idPer,
                            'IND_ESTADO' => 1
                        ];
                        $builder2 = $db->table('ADMIN.GU_TMENPTIENEPER');
                        $builder2->insert($data);
                    }
                }
                if ($listarMenup != 0 && $sigMen == 0) {
                    $idExt      =   $listarMenup;
                } else if ($sigMen == 1) {
                    $idPadre1   =   $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getResultArray();
                    if ($idPadre1) {
                        $idExt  =   $idPadre1[0]['MENP_IDPADRE'];
                    } else {
                        break;
                    }
                } else {
                    break;
                }
                $sigMen++;
            }
        }
        return  [
            "data"      =>  $aData,
            "status"    =>  true
        ];
    }
}
?>