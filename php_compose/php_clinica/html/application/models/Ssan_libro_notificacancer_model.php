<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class ssan_libro_notificacancer_model extends CI_Model {

    var $own        =   "ADMIN";
    var $ownGu      =   "GUADMIN";
    var $ownPab     =   "ADMIN";

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

        $sql = $DATA["busq"] == '2' ? "CALL ADMIN.LOAD_BUSQX_PARAMETROS_ALT(?, ?)": "CALL ADMIN.GET_HISTO_DATA_PROC(?, ?)";
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
        $query = vsprintf(str_replace("?", "%s", $sql), array_map(function($value) { return $this->db->escape($value); }, $bindings));
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
    

    #CONSULTA_MAIN
    public function load_lista_anatomiapatologica_model($DATA){
        $this->db->trans_start();
        #INICIO EN LA CONSULTA
        $param          =   array(
                                #DATA IN
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["cod_empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_USR_SESSION',
                                    'value'     =>  $DATA["usr_session"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_IND_FIRST',
                                    'value'     =>  '0',
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #FILTROS O IDS A BUSCAR
                                array( 
                                    'name'      =>  ':V_ARR_DATA',
                                    'value'     =>  $DATA["v_tipo_de_busqueda"]=='#_panel_por_gestion'?$DATA["v_ids_anatomia"]:$DATA["v_ids_anatomia"],
                                    #'value'    =>  '0',
                                    'length'    =>  1000,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #CURSORES OUT
                                array( 
                                    'name'      =>  ':C_LISTA_ANATOMIA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_HISTORIAL_M',
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
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_BUSQ_EDICION_POST',$param);
        $this->db->trans_complete();
        return array (
            'HTML_LI'                           =>  $this->load->view($DATA["v_get_sala"] == "edicionsolicitudbiopsia" ? 
                                                        "ssan_libro_notificacancer/html_tabla_edicion_solicitud": 
                                                        "ssan_libro_notificacancer/html_tabla_panel_cancer",
                                                    array('cursor'=>$result,'info_post'=>$DATA),true),
            'n_resultado'                       =>  count($result[":C_LISTA_ANATOMIA"]),
            'BD'                                =>  $result,
            'STATUS'                            =>  true,
            'status_bd'                         =>  true,
            'V_DATA'                            =>  $DATA,
        );
        //$this->load->view(,array('cursor'=>$result,'info_post'=>$DATA),true),
    }
    
    public function load_gestion_notificacion_cancer($DATA){
        $result = [];
        return array ('HTML_LI' =>  $this->load->view("ssan_libro_notificacancer/html_inicio_notificacion_correo",array('cursor'=>$result),true));
    }
    
    public function get_valida_notificacion_conjunta($DATA){
        $this->db->trans_start();
        $this->db->where('ID_SOLICITUD_HISTO',$DATA['ID_ANATOMIA']);
        $arr_update                         =   array(  
            #ROW NEW 24.10.2022
            "IND_NOTIFICACANCER"            =>  1,
            "DATE_NOTIFICACANCER"           =>  'SYSDATE',
            "IND_TIPO_NOTIFICACION"         =>  1,
            "ID_UID_NOTIFICA_CANCER"        =>  $DATA["DATA_FIRMA"]["user_1"]->ID_UID,
            "ID_UID_RC_NOTIFICA_CANCER"     =>  $DATA["DATA_FIRMA"]["user_2"]->ID_UID,
            "LAST_USR_AUDITA"               =>  $DATA["SESSION"],
            "LAST_DATE_AUDITA"              =>  "SYSDATE",
        ); 
        $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',$arr_update);
        $this->db->trans_complete();
        return array(
            'statuts' => true,  
        );
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
    
    public function update_numero_biopsias($DATA){
        $this->db->trans_start();
        $param = array(
                        #DATA IN
                        array( 
                            'name'      =>  ':V_COD_EMPRESA',
                            'value'     =>  $DATA["cod_empresa"],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':V_PASS',
                            'value'     =>  $DATA["pass"],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':V_IND_TIPO_BIOPSIA',
                            'value'     =>  $DATA["ind_tipo_biopsia"],
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
                            'name'      =>  ':V_NEW_NUMERO',
                            'value'     =>  $DATA["new_num_interno"],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':V_SESSION',
                            'value'     =>  explode("-",$this->session->userdata("USERNAME"))[0],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':V_IND_CAMBIO',
                            'value'     =>  $DATA["ind_cambio"],
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
        $result = $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','UPDATE_NUMERO_BIOPSIA',$param);
        $this->db->trans_complete();
        return array(
            'status' =>  true,
            'data_bd' =>  $result,
        );
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
                                    'value'     =>  $DATA["new_fecha_diagnostico"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_HORA_FECHA',
                                    'value'     =>  $DATA["new_hora_diagnostico"],
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
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','UPDATE_FECHA_DIAGNOSTICO',$param);
        $this->db->trans_complete();
        return array(
            'status'                            =>  true,
            'data_bd'                           =>  $result,
        );
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
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DELETE_BIOPSIA_DESDE_AP',$param);
        $this->db->trans_complete();
        return array(
            'status'                            =>  true,
            'data_bd'                           =>  $result,
        );
    }

    public function model_record_fecha_toma_muestra($DATA){
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
                                    'value'     =>  $DATA["fecha_solicitud"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_HORA_FECHA',
                                    'value'     =>  $DATA["hora_solicitud"],
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
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','UPDATE_TOMAMUESTRA',$param);
        $this->db->trans_complete();
        return array(
            'status'                            =>  true,
            'data_bd'                           =>  $result,
        );
    }

}
