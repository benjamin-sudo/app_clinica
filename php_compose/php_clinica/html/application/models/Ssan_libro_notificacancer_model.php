<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class ssan_libro_notificacancer_model extends CI_Model {

    var $own = "ADMIN";
    var $ownGu = "GUADMIN";
    var $ownPab = "ADMIN";

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('session',true);
    }
    /*
        $DATA["cod_empresa"],
        $DATA["busq"],
        $DATA["txt_bus"],
        $DATA["arr_ids_anatomia"]
    */
    public function get_histo_data($DATA) {
        $search_term = $DATA["txt_bus"];
        $cod_empresa = $DATA["cod_empresa"];
        #$sql = "CALL ADMIN.GET_HISTO_DATA_PROC(?, ?)";
        $sql = $DATA["busq"] == '2' ? "CALL ADMIN.LOAD_BUSQX_PARAMETROS_ALT(?, ?)":"CALL ADMIN.GET_HISTO_DATA_PROC(?, ?)";
        $query = $this->db->query($sql, array($search_term, $cod_empresa));
        return [
            'status' => true,
            'C_LISTA_ANATOMIA_BUS' => $query->result_array(),
        ];
    }

    public function get_histo_data_old($DATA) {
        $search_term = $DATA["txt_bus"];
        $cod_empresa = $DATA["cod_empresa"]; 
        $sql = "SELECT 
                    (SELECT COUNT(M.ID_NMUESTRA) FROM ADMIN.PB_HISTO_NMUESTRAS M
                    WHERE M.ID_SOLICITUD_HISTO = P.ID_SOLICITUD_HISTO AND M.IND_ESTADO = 1) AS N_MUESTRAS_TOTAL,
                    P.IND_SOLICITUD_EDITADA,
                    CASE WHEN P.IND_CONF_CANCER = 1 THEN 
                        CASE WHEN P.IND_NOTIFICACANCER = '' THEN '#f0ad4e' 
                            WHEN P.IND_NOTIFICACANCER = '0' THEN '#f0ad4e'
                            WHEN P.IND_NOTIFICACANCER = '1' THEN '#87CB16'
                            ELSE '#FF0000' END
                    ELSE '#FF0000' END AS COLOR_ESTADO_CANCER,
                    CASE WHEN P.IND_CONF_CANCER = 1 THEN 
                        CASE WHEN P.IND_NOTIFICACANCER = '' THEN 'NO NOTIFICADO'
                            WHEN P.IND_NOTIFICACANCER = '0' THEN 'NO NOTIFICADO'
                            WHEN P.IND_NOTIFICACANCER = '1' THEN 'NOTIFICADO'
                            ELSE 'NO INFORMADA' END
                    ELSE 'SIN DIAGNOSTICO DE CANCER' END AS TXT_ESTADO_CANCER,
                    P.NUM_NOF_CANCER,
                    P.COD_ESTABLREF,
                    P.ID_SOLICITUD_HISTO AS ID_ANATOMIA,
                    DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i') AS FEC_EMISION,
                    CONCAT(L.COD_RUTPAC, '-', L.COD_DIGVER) AS RUTPACIENTE,
                    L.IND_TISEXO,
                    L.COD_RUTPAC,
                    FLOOR(TIMESTAMPDIFF(MONTH, L.FEC_NACIMI, NOW()) / 12) AS NUMEDAD,
                    DATE_FORMAT(L.FEC_NACIMI, '%d-%m-%Y') AS NACIMIENTO,
                    FLOOR(TIMESTAMPDIFF(MONTH, L.FEC_NACIMI, NOW()) / 12) AS EDAD,
                    CONCAT(UPPER(L.NOM_NOMBRE), ' ', UPPER(L.NOM_APEPAT), ' ', UPPER(L.NOM_APEMAT)) AS NOMBRE_COMPLETO,
                    CONCAT(SUBSTR(UPPER(L.NOM_NOMBRE), 1, 1), '.', UPPER(L.NOM_APEPAT), ' ', UPPER(L.NOM_APEMAT)) AS TXTNOMCIRUSMALL,
                    CONCAT(UPPER(L.NOM_NOMBRE), ' ', UPPER(L.NOM_APEPAT), ' ', SUBSTR(UPPER(L.NOM_APEMAT), 1, 1)) AS TXTPRIMERNOMBREAPELLIDO,
                    CASE P.IND_TIPO_BIOPSIA
                        WHEN '1' THEN 'SI'
                        WHEN '2' THEN 'CONTEMPORANEA'
                        WHEN '3' THEN 'DIFERIDA'
                        WHEN '4' THEN 'BIOPSIA + CITOLOGÍA'
                        WHEN '6' THEN 'CITOLOGÍA PAP'
                        WHEN '5' THEN 'SOLO CITOLOGÍA'
                        ELSE 'NO INFORMADO' END AS TIPO_DE_BIOPSIA,
                    DATE_FORMAT(P.DATE_INICIOREGISTRO, '%Y') AS YEAR_TOMA_MUESTRA,
                    P.NUM_INTERNO_AP,
                    P.NUM_CO_CITOLOGIA,
                    P.NUM_CO_PAP
                FROM 
                    ADMIN.GG_TGPACTE L,
                    ADMIN.PB_SOLICITUD_HISTO P,
                    ADMIN.GG_TPROFESIONAL G
                WHERE
                    P.NUM_FICHAE = L.NUM_FICHAE AND
                    P.COD_RUTPRO = G.COD_RUTPRO AND
                    (P.COD_EMPRESA = '$cod_empresa' OR P.COD_ESTABLREF = '$cod_empresa') AND
                    P.IND_ESTADO = 1 AND 
                    P.ID_HISTO_ESTADO = 4 AND
                    (
                        UPPER(CONCAT(L.NOM_NOMBRE, L.NOM_APEPAT, L.NOM_APEMAT)) LIKE CONCAT('%', UPPER(?), '%')
                    )
                ORDER BY P.DATE_INICIOREGISTRO;
        ";
        $query = $this->db->query($sql, array($search_term));
        return [
            'status' => true,
            'C_LISTA_ANATOMIA_BUS' => $query->result_array(),
        ];
    }

    #busqueda resultados 
    public function busqueda_solicitudes_ap_old($DATA){
        $this->db->trans_start();
        $sql = "CALL ADMIN.LOAD_BUSQX_PARAMETROS(?, ?, ?, ?)";
        $bindings = array(
            $DATA["cod_empresa"],
            $DATA["busq"],
            $DATA["txt_bus"],
            $DATA["arr_ids_anatomia"]
        );
        $query = vsprintf(str_replace("?","%s",$sql), array_map(function($value) { return $this->db->escape($value); }, $bindings));
        $multi_query = $this->db->conn_id->multi_query($query);
        $arr_data = [];
        if ($multi_query) {
            do {
                if ($result = $this->db->conn_id->store_result()){
                    $arr_data[] = $result->fetch_all(MYSQLI_ASSOC);
                    $result->free();
                }
            } while ($this->db->conn_id->more_results() && $this->db->conn_id->next_result());
        } else {
            $error = $this->db->conn_id->error;
            //log_message('error', 'Error en la consulta: ' . $error);
            $this->db->trans_complete();
            return [
                'status' => false,
                'error' => $error,
                'DATA' => $DATA,
            ];
        }
        $this->db->trans_complete();
        return [
            'status' => true,
            'C_LISTA_ANATOMIA_BUS' => $arr_data,
            'DATA' => $DATA,
        ];
    }



    /*
    UPPER (G.NOM_NOMBRE||' '|| G.NOM_APEPAT ||' '|| G.NOM_APEMAT) AS PROFESIONAL,
    SUBSTR (UPPER (G.NOM_NOMBRE), 1, 1)||'.'||UPPER (G.NOM_APEPAT)||' '||UPPER (G.NOM_APEMAT) AS NOM_PROFE_CORTO,
    G.NOM_APEPAT||' '|| G.NOM_APEMAT ||' '|| G.NOM_NOMBRE AS PROFESIONAL_2,
    G.COD_RUTPRO||'-'|| G.COD_DIGVER AS RUT_PROFESIOAL,  
    */
    public function load_lista_anatomiapatologica_model($DATA){
        $result = [];
        $v_ids_anatomia = explode(",",$DATA['v_ids_anatomia']); 
        $cod_empresa = $DATA['cod_empresa']; 
        $this->db->trans_start();
        $this->db->select(['


        P.IND_CONF_CANCER,
        P.IND_NOTIFICACANCER,

        CASE WHEN P.IND_CONF_CANCER = 1 THEN 
            CASE WHEN P.IND_NOTIFICACANCER = "" THEN "NO NOTIFICADO"
                WHEN P.IND_NOTIFICACANCER = "0" THEN "NO NOTIFICADO" 
                WHEN P.IND_NOTIFICACANCER = "1" THEN "NOTIFICADO"
                ELSE "NO INFORMADA" END
        ELSE "SIN DIAGNOSTICO DE CANCER" END AS TXT_ESTADO_CANCER,

        DATE_FORMAT(P.DATE_FECHA_DIAGNOSTICO,"%d-%m-%Y %H:%i") AS DATE_FECHA_DIAGNOSTICO,
        DATE_FORMAT(P.DATE_FECHA_DIAGNOSTICO,"%d-%m-%Y") AS FECHA_DIAGNOSTICO,
        DATE_FORMAT(P.DATE_FECHA_DIAGNOSTICO,"%H:%i") AS HORA_DIAGNOSTICO,

        P.ID_SOLICITUD_HISTO AS ID_SOLICITUD,
        CONCAT(UPPER(G.NOM_NOMBRE), " ", UPPER(G.NOM_APEPAT), " ", UPPER(G.NOM_APEMAT)) AS PROFESIONAL2,
        DATE_FORMAT(P.LAST_DATE_AUDITA, "%Y%m%d") AS LAST_DATE_AUDITA_MOMENT,
        P.ID_HISTO_ZONA AS ID_HISTO_ZONA,
        CASE
            WHEN P.ID_HISTO_ZONA IN (0,"") THEN "callout_enproceso"
            WHEN P.ID_HISTO_ZONA = "1" THEN "callout_macroscopia"      
            WHEN P.ID_HISTO_ZONA = "2" THEN "callout_enproceso"
            WHEN P.ID_HISTO_ZONA = "6" THEN "callout_sala_tecnicas"
            WHEN P.ID_HISTO_ZONA = "7" THEN "callout_sala_patologo"
            WHEN P.ID_HISTO_ZONA = "8" THEN "callout_sala_reporte_finalizado"
            ELSE "callout_default"
        END AS STYLE_HISTO_ZONA,
        CASE
            WHEN P.ID_HISTO_ZONA IN (0,"") THEN "SALA DE RECEPCIÓN | MACROSCÓPICA"
            WHEN P.ID_HISTO_ZONA = "1" THEN "SALA MACROSCOPICA"      
            WHEN P.ID_HISTO_ZONA = "2" THEN "SALA PROCESO"
            WHEN P.ID_HISTO_ZONA = "4" THEN "SALA INCLUSIÓN"
            WHEN P.ID_HISTO_ZONA = "5" THEN "PROCESAMIENTO - SALA PROCESO" 
            WHEN P.ID_HISTO_ZONA = "6" THEN "SALA DE TECNICAS (TECNOLOGO)" 
            WHEN P.ID_HISTO_ZONA = "7" THEN "OFICINA PATOLOGO" 
            WHEN P.ID_HISTO_ZONA = "8" THEN "FINALIZADO" 
            ELSE "NO INFORMADO"  
        END AS TXT_HISTO_ZONA,
        CASE P.IND_TIPO_BIOPSIA
            WHEN "1" THEN "SI"
            WHEN "2" THEN "CONTEMPORANEA"
            WHEN "3" THEN "DIFERIDA"
            WHEN "4" THEN "BIOPSIA + CITOLOGÍA"
            WHEN "6" THEN "CITOLOGÍA PAP"
            WHEN "5" THEN "SOLO CITOLOGÍA"
            ELSE "NO INFORMADO"
        END AS TIPO_DE_BIOPSIA,

        (SELECT COUNT(M.ID_NMUESTRA) 
            FROM ADMIN.PB_HISTO_NMUESTRAS M
            WHERE M.ID_SOLICITUD_HISTO = P.ID_SOLICITUD_HISTO) AS N_MUESTRAS_TOTAL,
        CASE 
            WHEN P.IND_USOCASSETTE = "1" THEN "SI"
            WHEN P.IND_USOCASSETTE = "0" THEN "NO"
            ELSE "--"
        END AS TXT_USOCASSETTE,
        DATE_FORMAT(P.DATE_INICIOREGISTRO, "%d-%m-%Y %H:%i") AS DATE_FECHA_REALIZACION,
        P.IND_SALA_PROCESO AS IND_SALA_PROCESO,
        DATE_FORMAT(P.LAST_DATE_AUDITA, "%d-%m-%Y %H:%i") AS LAST_DATE_AUDITA,
        P.COD_ESTABLREF AS COD_ESTABLREF,
        P.NUM_INTERNO_AP AS NUM_INTERNO_AP,
        P.NUM_CO_CITOLOGIA AS NUM_CO_CITOLOGIA,
        P.NUM_CO_PAP AS NUM_CO_PAP,
        P.IND_TIPO_BIOPSIA AS IND_TIPO_BIOPSIA,
        CONCAT(L.COD_RUTPAC, "-", L.COD_DIGVER) AS RUTPACIENTE,
        
        CONCAT(UPPER(L.NOM_NOMBRE), " ", UPPER(L.NOM_APEPAT), " ", UPPER(L.NOM_APEMAT)) AS NOMBRE_COMPLETO,
        DATE_FORMAT(L.FEC_NACIMI, "%d-%m-%Y") AS NACIMIENTO,
        G.COD_RUTPRO AS COD_RUTPRO,
        G.COD_DIGVER AS DV,
        CONCAT(SUBSTR(UPPER(A.NOM_NOMBRE), 1, 1), ".", UPPER(A.NOM_APEPAT), " ", UPPER(A.NOM_APEMAT)) AS NOM_PROFE_CORTO,
        
        CASE WHEN P.IND_TIPO_BIOPSIA IN (5,6) THEN 0 ELSE 1 END AS INF_PDF_MACRO,
        CASE
            WHEN P.COD_ESTABLREF = ' . $this->db->escape($cod_empresa) . ' THEN (
                SELECT G.NOM_RAZSOC
                FROM ADMIN.SS_TEMPRESAS G
                WHERE G.COD_EMPRESA = P.COD_EMPRESA
                LIMIT 1
            )
            ELSE ""
        END AS TXT_EMPRESA_DERIVADO,
        (SELECT COUNT(M.ID_SOLICITUD_HISTO) FROM
            ADMIN.PB_MAIN_BLG_ANATOMIA M
            WHERE
            M.ID_SOLICITUD_HISTO IN (P.ID_SOLICITUD_HISTO) 
            AND 
            M.IND_ESTADO IN (1)) AS N_IMAGE_VIEWS']);
        $this->db->from('ADMIN.PB_SOLICITUD_HISTO P');
        $this->db->join('ADMIN.GG_TPROFESIONAL A', 'A.COD_RUTPRO = P.COD_RUTPRO');
        $this->db->join('ADMIN.GG_TGPACTE L', 'L.NUM_FICHAE = P.NUM_FICHAE');
        $this->db->join('ADMIN.GG_TPROFESIONAL G', 'G.COD_RUTPRO = P.COD_RUTPRO');
        $this->db->where_in('P.ID_SOLICITUD_HISTO', $v_ids_anatomia);
        $this->db->where('P.ID_HISTO_ESTADO', 4);
        $this->db->where('P.IND_ESTADO', 1);
        $this->db->group_start();
        $this->db->where_in('P.COD_EMPRESA', $cod_empresa);
        $this->db->or_where_in('P.COD_ESTABLREF', $cod_empresa);
        $this->db->group_end();
        $this->db->order_by('P.DATE_INICIOREGISTRO', 'ASC');
        $query_lista_anatomia = $this->db->get();
        $lista_anatomia = $query_lista_anatomia->result_array();
        $result[':C_LISTA_ANATOMIA'] = $lista_anatomia;
        $this->db->trans_complete();
        return [
            'HTML_LI' =>  $this->load->view($DATA["v_get_sala"] == "edicionsolicitudbiopsia" ? 
                "ssan_libro_notificacancer/html_tabla_edicion_solicitud" : 
                "ssan_libro_notificacancer/html_tabla_panel_cancer", ["cursor"=>$result,"info_post"=>$DATA], true),
            'n_resultado' => count($result[":C_LISTA_ANATOMIA"]),
            'BD' =>  $result,
            'STATUS' =>  true,
            'status_bd' =>  true,
            'V_DATA' =>  $DATA,
        ];
        
    }
    
    public function load_gestion_notificacion_cancer($DATA){
        $result = [];
        return array ('HTML_LI' =>  $this->load->view("ssan_libro_notificacancer/html_inicio_notificacion_correo",array('cursor'=>$result),true));
    }
    
    public function get_valida_notificacion_conjunta($DATA){
        $this->db->trans_start();
        $this->db->where('ID_SOLICITUD_HISTO', $DATA['ID_ANATOMIA']);
        $arr_update = array(  
            "IND_NOTIFICACANCER" => 1,
            "DATE_NOTIFICACANCER" => 'NOW()', 
            "IND_TIPO_NOTIFICACION" => 1,
            "ID_UID_NOTIFICA_CANCER" => $DATA["DATA_FIRMA"]["user_1"]->ID_UID,
            "ID_UID_RC_NOTIFICA_CANCER" => $DATA["DATA_FIRMA"]["user_2"]->ID_UID,
            "LAST_USR_AUDITA" => $DATA["SESSION"],
            "LAST_DATE_AUDITA" => 'NOW()',
        ); 
        $this->db->set($arr_update, '', false);
        $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO');
        $this->db->trans_complete();
        return [
            'statuts' => true,  
        ];
    }
    
    public function load_edicion_solicitud($DATA){
        $this->db->trans_start();
        $param          =   array(
                                #DATA IN
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["cod_empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_ID_BIOPSIA',
                                    'value'     =>  $DATA["id_biopsia"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #CURSORES OUT
                                array( 
                                    'name'      =>  ':C_RETURN_GESTION',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_HISTORIAL_MODIFICACIONES',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
             
             );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_EDICION_SOLCIITUD_AP',$param);
        $this->db->trans_complete();
        return array(
            'status'                            =>  true,
            'html_out'                          =>  $this->load->view("ssan_libro_notificacancer/html_edicion_numero_biopsia",array('cursor'=>$result),true),
            'data_bd'                           =>  $result,
        );
    }

    public function update_numero_biopsias($DATA) {
        $this->db->trans_start();
        $v_ind_tipo_biopsia = $DATA["ind_tipo_biopsia"];
        $v_new_num_interno = $DATA["new_num_interno"]; 
        $v_id_biopsia = $DATA["id_biopsia"];  
        $v_cod_empresa = $DATA["cod_empresa"];   
        $v_ind_cambio = $DATA["ind_cambio"];    
        $V_NUM_INTERNO_OUT = 0;
        $V_TIPO_EDICION = 0;

        # BIOPSIA + CITOLOGIA
        if ($v_ind_tipo_biopsia == '4') {
            if ($v_ind_cambio == '1') {
                $v_sql = "SELECT 
                            P.ID_SOLICITUD_HISTO  
                        FROM 
                            ADMIN.PB_SOLICITUD_HISTO P 
                        WHERE 
                            P.NUM_INTERNO_AP = ?  
                            AND P.COD_EMPRESA = ?  
                            AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) 
                            AND P.IND_TIPO_BIOPSIA IN (2, 3, 4)";
                $arr_data = $this->db->query($v_sql, [$v_new_num_interno, $v_cod_empresa])->result_array();
                $V_NUM_INTERNO_OUT = count($arr_data) > 0 ? $arr_data[0]['ID_SOLICITUD_HISTO'] : '-1';
                $V_TIPO_EDICION = 1;
            } else {
                $v_sql = "SELECT 
                            P.NUM_CO_PAP 
                        FROM 
                            ADMIN.PB_SOLICITUD_HISTO P 
                        WHERE 
                            P.NUM_INTERNO_AP = ?  
                            AND P.COD_EMPRESA = ?  
                            AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) 
                            AND P.IND_TIPO_BIOPSIA IN (4, 5)";
                $arr_data = $this->db->query($v_sql, [$v_new_num_interno, $v_cod_empresa])->result_array();
                $V_NUM_INTERNO_OUT = count($arr_data) > 0 ? $arr_data[0]['NUM_CO_PAP'] : '-1';
                $V_TIPO_EDICION = 2;
            }
        }

        # CONTEMPORANEA Y DIFERIDA  
        if ($v_ind_tipo_biopsia == '2' || $v_ind_tipo_biopsia == '3') {
            $v_sql = "SELECT 
                        P.ID_SOLICITUD_HISTO  
                    FROM 
                        ADMIN.PB_SOLICITUD_HISTO P 
                    WHERE 
                        P.NUM_INTERNO_AP = ?  
                        AND P.COD_EMPRESA = ?  
                        AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) 
                        AND P.IND_TIPO_BIOPSIA IN (2, 3, 4)";
            $arr_data = $this->db->query($v_sql, [$v_new_num_interno, $v_cod_empresa])->result_array();
            $V_NUM_INTERNO_OUT = count($arr_data) > 0 ? $arr_data[0]['ID_SOLICITUD_HISTO'] : '-1';
            $V_TIPO_EDICION = 1;
        }
        # CITOLOGIA
        if ($v_ind_tipo_biopsia == '5') {
            $v_sql = "SELECT 
                        P.NUM_CO_PAP 
                    FROM 
                        ADMIN.PB_SOLICITUD_HISTO P 
                    WHERE 
                        P.NUM_INTERNO_AP = ?  
                        AND P.COD_EMPRESA = ?  
                        AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) 
                        AND P.IND_TIPO_BIOPSIA IN (4, 5)";
            $arr_data = $this->db->query($v_sql, [$v_new_num_interno, $v_cod_empresa])->result_array();
            $V_NUM_INTERNO_OUT = count($arr_data) > 0 ? $arr_data[0]['NUM_CO_PAP'] : '-1';
            $V_TIPO_EDICION = 2;
        }
        # PAP
        if ($v_ind_tipo_biopsia == '6') {
            $v_sql = "SELECT 
                        P.NUM_CO_CITOLOGIA 
                    FROM 
                        ADMIN.PB_SOLICITUD_HISTO P 
                    WHERE 
                        P.NUM_INTERNO_AP = ?  
                        AND P.COD_EMPRESA = ?  
                        AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) 
                        AND P.IND_TIPO_BIOPSIA IN (4, 5)";
            $arr_data = $this->db->query($v_sql, [$v_new_num_interno, $v_cod_empresa])->result_array();
            $V_NUM_INTERNO_OUT = count($arr_data) > 0 ? $arr_data[0]['NUM_CO_CITOLOGIA'] : '-1';
            $V_TIPO_EDICION = 3;
        }
    
        if ($V_NUM_INTERNO_OUT != '-1') {
            return [
                'DATA' => $DATA,
                'status' => false,
            ];
        }
        $data = [
            'LAST_USR_AUDITA' => $DATA['arr_user'][0]['ID_UID'],
            'LAST_DATE_AUDITA' => date('Y-m-d H:i:s'),
            'IND_SOLICITUD_EDITADA' => 1
        ];
        switch ($V_TIPO_EDICION) {
            case 1:
                $data['NUM_INTERNO_AP'] = $v_new_num_interno;
                break;
            case 2:
                $data['NUM_CO_CITOLOGIA'] = $v_new_num_interno;
                break;
            case 3:
                $data['NUM_CO_PAP'] = $v_new_num_interno;
                break;
            default:
                return false; 
        }
        $this->db->where_in('ID_SOLICITUD_HISTO', $v_id_biopsia);
        $this->db->update('ADMIN.PB_SOLICITUD_HISTO', $data);
        $this->db->trans_complete();
        return [
            'DATA' => $DATA,
            'status' => $this->db->trans_status()
        ];
    }

    
    public function listado_notificado_cancer($DATA){
        $this->db->trans_start();
        $param          =   array(
                                #DATA IN
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["cod_empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_IND_OPCION',
                                    'value'     =>  $DATA["ind_opcion"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_IND_YEAR',
                                    'value'     =>  $DATA["ind_year"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_DATE_INICIO',
                                    'value'     =>  $DATA["date_fecha_inicio"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_DATE_FINAL',
                                    'value'     =>  $DATA["date_fecha_final"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #CURSORES OUT
                                array( 
                                    'name'      =>  ':C_LISTADO_CANCER',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LISTADO_NOTF_CANCER',$param);
        $this->db->trans_complete();
        return array(
            'status'                            =>  true,
            'data_bd'                           =>  $result,
            'get'                               =>  $DATA,
        );
    }
    
    public function model_update_fecha_diagnostico($DATA){
        $this->db->trans_start();
        $date_fecha_diagnostico = date('Y-m-d H:i:s', strtotime($DATA['new_fecha_diagnostico'] . ' ' . $DATA['new_hora_diagnostico'] . ':00'));
        $update_data = [
            "DATE_FECHA_DIAGNOSTICO" => $date_fecha_diagnostico,
            "LAST_USR_AUDITA" => explode("-",$this->session->userdata("USERNAME"))[0],
            "LAST_DATE_AUDITA" => date('Y-m-d H:i:s'), 
            "IND_SOLICITUD_EDITADA" => 1
        ];
        $this->db->where_in('ID_SOLICITUD_HISTO', $DATA['id_biopsia']);
        $this->db->update('ADMIN.PB_SOLICITUD_HISTO', $update_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return [
                'status' => false,
                'message' => 'Error updating record'
            ];
        } else {
            return [
                'status' => true,
                'message' => 'Record updated successfully'
            ];
        }
    }

    public function model_update_date_notificacancer($DATA){
        $this->db->trans_start();
        $param          =   array(
                                #DATA IN
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["cod_empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_CONTRASENA',
                                    'value'     =>  $DATA["constrasena"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_ID_BIOPSIA',
                                    'value'     =>  $DATA["id_biopsia"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_DATE_FECHA',
                                    'value'     =>  $DATA["new_fecha_notifica_cancer"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_HORA_FECHA',
                                    'value'     =>  $DATA["new_hora_notifica_cancer"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_SESSION',
                                    'value'     =>  explode("-",$this->session->userdata("USERNAME"))[0],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #CURSORES OUT
                                array( 
                                    'name'      =>  ':C_HISTO_LOGS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','UPDATE_FECHA_CANCER',$param);
        $this->db->trans_complete();
        return array(
            'status'                            =>  true,
            'data_bd'                           =>  $result,
        );
    }

    public function model_record_elimina_definitivamente($DATA){
        $this->db->trans_start();
        $id_biopsia = $DATA['id_biopsia'];
        $session = $DATA['arr_user'][0]['ID_UID'];
        $update_data = [
            'IND_ESTADO' => 0,
            'NUM_INTERNO_AP' => null,
            'NUM_CO_CITOLOGIA' => null,
            'NUM_CO_PAP' => null,
            'LAST_USR_AUDITA' => $session,
            'LAST_DATE_AUDITA' => date('Y-m-d H:i:s')
        ];
        $this->db->where('ID_SOLICITUD_HISTO', $id_biopsia);
        $this->db->update('ADMIN.PB_SOLICITUD_HISTO', $update_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return [
                'status' => false,
                'message' => 'Error updating record'
            ];
        } else {
            return [
                'status' => true,
                'message' => 'Record updated successfully'
            ];
        }
    }

    public function model_record_fecha_toma_muestra($data) {
        $this->db->trans_start();
        $cod_empresa = $data['cod_empresa'];
        $id_biopsia = $data['id_biopsia'];
        $fecha_solicitud = $data['fecha_solicitud'];
        $hora_solicitud = $data['hora_solicitud'];
        $session = '0'; 
        $date_inicio_registro = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $fecha_solicitud) . ' ' . $hora_solicitud . ':00'));
        $update_data = [
            'DATE_INICIOREGISTRO' => $date_inicio_registro,
            'LAST_USR_AUDITA' => $session,
            'LAST_DATE_AUDITA' => date('Y-m-d H:i:s'), 
            'IND_SOLICITUD_EDITADA' => 1
        ];
        $this->db->where_in('ID_SOLICITUD_HISTO', $id_biopsia);
        $this->db->update('ADMIN.PB_SOLICITUD_HISTO', $update_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return [
                'status' => false,
                'message' => 'Error updating record'
            ];
        } else {
            return [
                'status' => true,
                'message' => 'Record updated successfully'
            ];
        }
    }
    


}
