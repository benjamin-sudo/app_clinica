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
                $html .=    "<a href='javascript:editarExt(".$mainData['main_id'].",0)'><i class='bi bi-pencil'></i></a>" ;
                $html .=    htmlspecialchars($mainData['main_nombre']);
            $html .=    "</h3>";
            // Generar la lista de submenús y sus extensiones
            $html   .= "<ul class='list-group'>";
            foreach ($mainMenu['submenus'] as $subMenuId => $subMenu){
                // Acceder a los datos del submenú
                $subData    =   $subMenu['data'];
                // Aquí agregas el nombre del submenú
                $html   .=  "<h5 style='color:#888888;margin-left: 10px;'>";
                $html   .=  "<a href='javascript:editarExt(".$subData['sub_id'].",1)'><i class='bi bi-pencil'></i></a>".htmlspecialchars($subData['sub_nombre'])."";
                $html   .=  "</h5>";
                
                $html   .=  "<ul class='no-bullet'>";
                // Acceder a los datos de las extensiones
                foreach ($subMenu['extensions'] as $extensionId => $extension) {
                    $html   .=  "<li><h6 style='color:#888888;margin-left: 15px;'><a href='javascript:editarExt(".$subData['ext_id'].",2)'>";
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
        $arr_run =   str_replace('.','',$aData['post']['user']);
        $db =   \Config\Database::connect();
        $db->transStart();
        $hash =   password_hash($aData['post']['pass'],PASSWORD_BCRYPT);
        $dataUs =   array(
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
        $arr_username       =   $db->query("SELECT ID_UID FROM ADMIN.FE_USERS WHERE USERNAME = '".$arr_run."'")->getResultArray();
        
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
                $get_tusutieneper = $db->query("SELECT ID_UTP FROM ADMIN.GU_TUSUTIENEPER WHERE PER_ID IN (".$row.") AND ID_UID  = ".$last_id)->getResultArray();
                if (count($get_tusutieneper)>0){
                    $constructora3 = $db->table('ADMIN.GU_TUSUTIENEPER');
                    $constructora3->set(['IND_ESTADO' => 1]);
                    $constructora3->where('ID_UTP',$get_tusutieneper[0]['ID_UTP']);
                    $constructora3->update();
                } else {
                    $constructora2 = $db->table('ADMIN.GU_TUSUTIENEPER');
                    $constructora2->insert(['ID_UID'=>$last_id,'PER_ID'=>$row,'IND_ESTADO'=>1]);
                }
            }
        }

        //establecimientos
        $arrEmpresas = $aData['post']['arrEmpresas'];
        if(count($arrEmpresas)>0){
            $constructora4 = $db->table('ADMIN.GU_TUSUXEMPRESA');
            $constructora4->set(['IND_ESTADO' => 0]);
            $constructora4->where('ID_UID',$last_id);
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
        return  [
                    'last_id'   =>  $last_id,
                    'user'      =>  $arr_run,
                    'status'    =>  $status,
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
                    E.MENP_ID = ?
                    AND 
                    E.IND_ESTADO = 1";
    
        $query2 = $db->query($SQL, [$id])->getResultArray();
    
        return [
            'id' => $id,
            'SQL' => $SQL,
            'gu_tmenuprincipal' => $query,
            'arr_permisos' => $query2,
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


    /*
    public function editando_extension_last($aData) {
        $idExt = $aData['post']['idMen'];
        $nombre = $aData['post']['nombre'];
        $listarMenup = $aData['post']['ind_extension_padre'];
        $tip = $aData['post']['tipo_de_extension'];
        $check = $aData['post']['check'];
        $arrPrivilegios = $aData['post']['arrPrivilegios'];
        $bool_checked = $aData['post']['bool_checked'];
        $db = \Config\Database::connect();
        $db->transStart();

        $db->table('ADMIN.GU_TMENUPRINCIPAL')
           ->set([
                'MENP_NOMBRE' => $nombre,
                'MENP_ESTADO' => $check,
                'MENP_TIPO' => $tip,
                'MENP_IDPADRE' => $listarMenup,
                'MENP_FRAME' => 3
            ])
           ->where('MENP_ID', $idExt)
           ->update();

        $count = count($arrPrivilegios);
        if ($count > 0) {
            $sigMen = 0;
            while ($sigMen <= 2) {
                if ($sigMen == 0) {
                    $db->table('ADMIN.GU_TMENPTIENEPER')->set('IND_ESTADO', 0)->where('MENP_ID', $idExt)->update();
                }
                foreach ($arrPrivilegios as $idPer) {
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
                } elseif ($sigMen == 1) {
                    $idPadre1 = $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getResultArray();
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
        return [
            "data" => $aData,
            "status" => $db->transStatus()
        ];
    }
    */

 
        
    #$tip = $aData['post']['tipo_de_extension'];
    #leyeda tip de  $aData['post']['tipo_de_extension'];
        #0 = sistema principal  -   abuelo
        #1 = submenu            -   padre 
        #2 = extesion           -   hijo

    #$listarMenup = $aData['post']['ind_extension_padre'];
    # cuando es = 0 , cero significa es abuelo y tiene queheredar hacia abajo 
    # cuando trae un numero, es de quien hereda segun el tipo de tipo_de_extension . calcular si hay que subir un nivel o 2 if 

    public function editando_extension_last($aData) {
        $idExt = $aData['post']['idMen'];
        $nombre = $aData['post']['nombre'];
        $tip = $aData['post']['tipo_de_extension'];
        $listarMenup = $aData['post']['ind_extension_padre'];
        $check = $aData['post']['check'];
        $arrPrivilegios = $aData['post']['arrPrivilegios'];
        $bool_checked = $aData['post']['bool_checked'];
    
        $db = \Config\Database::connect();
        $db->transStart();
    
        $v_padre = 0;
        if ($tip != 0) {
            $arr_idPadre = $db->query("SELECT MENP_IDPADRE, MENP_TIPO FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getRowArray();
            $v_padre = $arr_idPadre['MENP_IDPADRE'];
        }
    
        $db->table('ADMIN.GU_TMENUPRINCIPAL')
            ->set([
                'MENP_NOMBRE' => $nombre,
                'MENP_ESTADO' => $check,
                'MENP_TIPO' => $tip,
                'MENP_IDPADRE' => $v_padre,
                'MENP_FRAME' => 3
            ])
            ->where('MENP_ID', $idExt)
            ->update();
    
        // Desheredar permisos si es necesario
        $this->desheredarPermisos($db, $idExt, $tip);
        
        // Actualizar permisos
        $this->actualizarPermisos($db, $idExt, $arrPrivilegios);
    
        // Heredar permisos y propagar según el tipo
        if ($tip == 0) {
            // Es un abuelo, propagar permisos hacia abajo
            $this->propagarPermisosHaciaAbajo($db, $idExt, $arrPrivilegios);
        } else if ($tip == 1) {
            // Es un submenú, heredar permisos hacia arriba y hacia abajo
            $this->heredarPermisos($db, $idExt, $arrPrivilegios);
            $this->propagarPermisosHaciaAbajo($db, $idExt, $arrPrivilegios);
        } else if ($tip == 2) {
            // Es una extensión, heredar permisos hacia arriba
            $this->heredarPermisos($db, $idExt, $arrPrivilegios);
        }
    
        $db->transComplete();
        return [
            "data" => $aData,
            "status" => $db->transStatus()
        ];
    }
    
    private function desheredarPermisos($db, $idExt, $tip) {
        if ($tip == 0) {
            // Desactivar permisos propagados a todos los hijos y descendientes
            $this->desactivarPermisosHaciaAbajo($db, $idExt);
        } else if ($tip == 1 || $tip == 2) {
            // Desactivar permisos heredados de los padres
            $this->desactivarPermisosHaciaArriba($db, $idExt);
        }
    }
    
    private function desactivarPermisosHaciaArriba($db, $idExt) {
        $visitados = [];
        while ($idExt != 0 && !in_array($idExt, $visitados)) {
            $visitados[] = $idExt;
            $idPadre = $db->query("SELECT MENP_IDPADRE FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getRowArray();
            if ($idPadre && $idPadre['MENP_IDPADRE'] != 0) {
                $idExtPadre = $idPadre['MENP_IDPADRE'];
                $db->table('ADMIN.GU_TMENPTIENEPER')->set('IND_ESTADO', 0)->where('MENP_ID', $idExtPadre)->update();
                $idExt = $idExtPadre;
            } else {
                $idExt = 0;
            }
        }
    }
    
    private function desactivarPermisosHaciaAbajo($db, $idExt) {
        $hijos = $db->query("SELECT MENP_ID FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_IDPADRE = ?", [$idExt])->getResultArray();
        foreach ($hijos as $hijo) {
            $idHijo = $hijo['MENP_ID'];
            $db->table('ADMIN.GU_TMENPTIENEPER')->set('IND_ESTADO', 0)->where('MENP_ID', $idHijo)->update();
            $this->desactivarPermisosHaciaAbajo($db, $idHijo);
        }
    }
    
    private function actualizarPermisos($db, $idExt, $arrPrivilegios) {
        // Desactivar todos los permisos actuales
        $db->table('ADMIN.GU_TMENPTIENEPER')->set('IND_ESTADO', 0)->where('MENP_ID', $idExt)->update();
    
        // Activar los nuevos permisos
        foreach ($arrPrivilegios as $idPer) {
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
    }
    
    private function heredarPermisos($db, $idExt, $arrPrivilegios, $profundidad = 0, $maxProfundidad = 10) {
        if ($profundidad > $maxProfundidad) {
            log_message('debug', 'Máxima profundidad alcanzada en heredarPermisos: ' . $profundidad);
            return;
        }
    
        $visitados = [];
        while ($idExt != 0 && !in_array($idExt, $visitados)) {
            log_message('debug', 'Herencia de permisos para menú: ' . $idExt . ' a profundidad: ' . $profundidad);
            $visitados[] = $idExt;
            $idPadre = $db->query("SELECT MENP_IDPADRE, MENP_TIPO FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_ID = ?", [$idExt])->getRowArray();
            
            if ($idPadre && $idPadre['MENP_IDPADRE'] != 0) {
                $idExtPadre = $idPadre['MENP_IDPADRE'];
                $permisosPadre = $db->query("SELECT PER_ID FROM ADMIN.GU_TMENPTIENEPER WHERE MENP_ID = ? AND IND_ESTADO = 1", [$idExtPadre])->getResultArray();
                foreach ($permisosPadre as $permiso) {
                    $res = $db->query("SELECT PER_ID FROM ADMIN.GU_TMENPTIENEPER WHERE PER_ID = ? AND MENP_ID = ?", [$permiso['PER_ID'], $idExt])->getResultArray();
                    if (count($res) == 0) {
                        $data = [
                            'MENP_ID' => $idExt,
                            'PER_ID' => $permiso['PER_ID'],
                            'IND_ESTADO' => 1
                        ];
                        $db->table('ADMIN.GU_TMENPTIENEPER')->insert($data);
                    }
                }
            } else {
                $idExt = 0;
            }
        }
    
        if ($idExt != 0) {
            $this->heredarPermisos($db, $idExt, $arrPrivilegios, $profundidad + 1, $maxProfundidad);
        }
    }
    
    private function propagarPermisosHaciaAbajo($db, $idExt, $arrPrivilegios) {
        log_message('debug', 'Propagando permisos hacia abajo para menú: ' . $idExt);
        $hijos = $db->query("SELECT MENP_ID FROM ADMIN.GU_TMENUPRINCIPAL WHERE MENP_IDPADRE = ?", [$idExt])->getResultArray();
        foreach ($hijos as $hijo) {
            $idHijo = $hijo['MENP_ID'];
            foreach ($arrPrivilegios as $idPer) {
                $res = $db->query("SELECT PER_ID FROM ADMIN.GU_TMENPTIENEPER WHERE PER_ID = ? AND MENP_ID = ?", [$idPer, $idHijo])->getResultArray();
                if (count($res) == 0) {
                    $data = [
                        'MENP_ID' => $idHijo,
                        'PER_ID' => $idPer,
                        'IND_ESTADO' => 1
                    ];
                    $db->table('ADMIN.GU_TMENPTIENEPER')->insert($data);
                }
            }
            // Recursivamente propagar a los hijos
            $this->propagarPermisosHaciaAbajo($db, $idHijo, $arrPrivilegios);
        }
    }
    
    

}
?>