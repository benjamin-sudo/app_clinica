<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class ssan_libro_biopsias_usuarioext_model extends CI_Model {

    var $ownGu = "ADMIN";
    var $tableSpace = "ADMIN";
    var $own = "ADMIN";
    var $ownPab = "ADMIN";
    var $GESPAB = "ADMIN";

    public function __construct(){
        parent::__construct();
        date_default_timezone_set('America/Santiago');
        $this->db = $this->load->database('session', true);
    }

    public function CARGA_LISTA_MISSOLICITUDES_ANATOMIA($DATA) {
        $this->db->trans_start();
        $CALL_FASE = isset($DATA['CALL_FASE']) ? $DATA['CALL_FASE'] : -1;
        $LODA_X_SISTEMAS = isset($DATA['LODA_X_SISTEMAS']) ? $DATA['LODA_X_SISTEMAS'] : 0;
        $V_COD_EMPRESA = $this->db->escape($DATA["COD_EMPRESA"]);
        $V_USR_SESSION = $this->db->escape($DATA["USR_SESSION"]);
        $V_LOADXZONA = $this->db->escape($LODA_X_SISTEMAS);
        $VAL_FECHA_INICIO = $this->db->escape($DATA["DATE_FROM"]);
        $VAL_FECHA_FINAL = $this->db->escape($DATA["DATE_TO"]);
        $query = "CALL ADMIN.GET_LISTA_ANOTOMIAPATOLOGICA($V_COD_EMPRESA, $V_USR_SESSION, $V_LOADXZONA, $VAL_FECHA_INICIO, $VAL_FECHA_FINAL)";
        $multi_query = $this->db->conn_id->multi_query($query);
        if ($multi_query) {
            $data = [];
            do {
                if ($result = $this->db->conn_id->store_result()) {
                    $data[] = $result->fetch_all(MYSQLI_ASSOC);
                    $result->free();
                }
            } while ($this->db->conn_id->more_results() && $this->db->conn_id->next_result());
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                return [
                    'STATUS' => false,
                    'RESULT' => null
                ];
            } else {
                return [
                    'STATUS' => true,
                    'RESULT' => $data,
                    'ARRAY_RESULT' => empty($data[1]) ? null : $data[1], // Asumiendo que el segundo SELECT es el principal
                    'HTML_SOLICITUDEAP' => $this->RESULTADOS_ANATOMIA($data[1]), // table 
                    'HTML_LI' => $this->LI_RESULTADOS_ANATOMIA($data[1], $CALL_FASE), // en li
                    'DATE_FROM' => $DATA["DATE_FROM"],
                    'DATE_TO' => $DATA["DATE_TO"],
                    'EMPRESA' => $DATA["COD_EMPRESA"],
                ];
            }
        } else {
            $this->db->trans_complete();
            return [
                'STATUS' => false,
                'RESULT' => null
            ];
        }
    }

    public function data_pre_nuevasoliciud_anatomia($DATA) {
        $result = array(
            'STATUS' => true,
            'C_ESPECIALIDADES' => $this->get_especialidades($DATA['COD_EMPRESA'], $DATA['USR_SESSION']),
            'C_LISTADOSERVICIOS' => $this->get_listado_servicios($DATA['COD_EMPRESA']),
            'C_LISTADOMEDICOS' => $this->get_listado_medicos($DATA['COD_EMPRESA']),
        );
        return $result;
    }
    
    public function get_especialidades($cod_empresa, $usr_session) {
        $this->db->select('A.COD_GRUPO AS VALUE, A.ID_GRUPO AS ID_VALUE, A.NOM_GRUPO AS OPCION');
        $this->db->from('ADMIN.GG_TGRUESP A');
        $this->db->join('ADMIN.SO_TMOTICIQ B', 'A.COD_GRUPO = B.COD_ESPEC');
        $this->db->where('A.IND_ESTADO', 'V');
        $this->db->where('A.COD_GRUPO <>', 'NOAP');
        $this->db->group_by(array('A.COD_GRUPO', 'A.ID_GRUPO', 'A.NOM_GRUPO'));
        $this->db->order_by('A.NOM_GRUPO');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_listado_servicios($cod_empresa) {
        $query = $this->db->query("SELECT *
            FROM (
                SELECT  
                    GG_TSERVICIO.ID_SERDEP AS ID, 
                    GG_TSERVICIO.NOM_SERVIC AS TXT_DES
                FROM 
                    ADMIN.GG_TSERVICIO
                JOIN ADMIN.GG_TSERVICIOXEMP ON GG_TSERVICIOXEMP.ID_SERDEP = GG_TSERVICIO.ID_SERDEP 
                WHERE 
                    (GG_TSERVICIOXEMP.IND_MED = '1' OR GG_TSERVICIO.ID_SERDEP IN ('268', '266'))
                    AND GG_TSERVICIOXEMP.COD_EMPRESA IN ('{$cod_empresa}')
                    AND GG_TSERVICIO.IND_SERDEP = 'S'
                UNION 
                SELECT 
                    A.ID_SERDEP AS ID,
                    A.NOM_SERVIC AS TXT_DES 
                FROM 
                    ADMIN.GG_TSERVICIO A
                JOIN ADMIN.GG_TSERVICIOXEMP B ON A.ID_SERDEP = B.ID_SERDEP
                WHERE 
                    B.COD_EMPRESA IN ('{$cod_empresa}')
                    AND B.IND_MED = 1
                    AND (A.IND_SERDEP = 'S' OR A.IND_SERDEP = 'D')
                    AND A.ID_SERDEP NOT IN (229)
            ) AS LISTADOSERVICIOS
            ORDER BY TXT_DES;");
        return $query->result_array();
    }
    
    public function get_listado_medicos($cod_empresa) {
        $this->db->select("A.COD_RUTPRO, A.ID_PROFESIONAL AS ID_PRO, A.COD_DIGVER AS COD_DIGVER, CONCAT(UPPER(A.NOM_APEPAT), ' ', UPPER(A.NOM_APEMAT), ' ', UPPER(A.NOM_NOMBRE)) AS NOM_PROFE, C.DES_TIPOATENCION AS DES_TIPOATENCION, B.COD_TPROFE AS COD_TPROFE, B.NOM_TPROFE AS NOM_TPROFE, C.IND_TIPOATENCION AS IND_TIPOATENCION");
        $this->db->from('ADMIN.GG_TPROFESIONAL A');
        $this->db->join('ADMIN.GG_TPROFESION B', 'A.COD_TPROFE = B.COD_TPROFE');
        $this->db->join('ADMIN.AP_TTIPOATENCION C', 'B.IND_TIPOATENCION = C.IND_TIPOATENCION');
        $this->db->join('ADMIN.AP_TPROFXESTABL D', 'A.COD_RUTPRO = D.COD_RUTPRO');
        $this->db->where('A.IND_ESTADO', 'V');
        $this->db->where('D.IND_ESTADO', 'V');
        $this->db->where_in('D.COD_EMPRESA', $cod_empresa);
        $this->db->order_by('C.IND_TIPOATENCION');
        $this->db->order_by('A.NOM_APEPAT');
        $query = $this->db->get();
        return $query->result_array();
    }



    public function model_busquedasolicitudes_rotulo($data_controller) {
        $v_fecha_inicio = explode("-",$data_controller['data_inicio']);
        $v_data_final = explode("-",$data_controller['data_final']);
        $fecha_inicio = $v_fecha_inicio[2].'-'.$v_fecha_inicio[1].'-'.$v_fecha_inicio[0].' 00:00:00';
        $fecha_final = $v_data_final[2].'-'.$v_data_final[1].'-'.$v_data_final[0].' 23:59:59';
        $cod_empresa = $data_controller['COD_EMPRESA'];
        $num_fase = $data_controller['num_fase'];
        //var_dump($num_fase);
        /*
        if ($num_fase == '1') {
            $cods = [$cod_empresa];
        } else {
            $sql_emp = "SELECT COD_EMPRESA  FROM ADMIN.SS_TEMPRESAS   WHERE IND_ESTADO = 'V'";
            $rows = $this->db->query($sql_emp)->result_array();
            $cods = array_column($rows, 'COD_EMPRESA');
        }
        */
        $cods = [$cod_empresa];
        $placeholders = implode(',', array_fill(0, count($cods), '?'));
        $bindings = array_merge([$fecha_inicio, $fecha_final], $cods );
        $sql = "SELECT 
                    P.ID_ROTULADO                                                                                       AS ID_ROTULADO,
                    P.COD_ESTABLREF                                                                                     AS COD_ESTABLREF,
                    P.ID_SIC                                                                                            AS COD_ESTABLREF,
                    P.IND_DERIVACION_IC                                                                                 AS IND_DERIVACION_IC,
                    P.ID_HISTO_ZONA                                                                                     AS ID_HISTO_ZONA,
                    CONCAT(L.COD_RUTPAC, '-', L.COD_DIGVER)                                                             AS RUTPACIENTE,
                    L.IND_TISEXO                                                                                        AS IND_TISEXO,
                    L.COD_RUTPAC                                                                                        AS COD_RUTPAC,
                    FLOOR(TIMESTAMPDIFF(MONTH, L.FEC_NACIMI, NOW()) / 12)                                               AS NUMEDAD,
                    DATE_FORMAT(L.FEC_NACIMI, '%d-%m-%Y')                                                               AS NACIMIENTO,
                    FLOOR(TIMESTAMPDIFF(MONTH, L.FEC_NACIMI, NOW()) / 12)                                               AS EDAD,
                    CONCAT(UPPER(L.NOM_NOMBRE), ' ', UPPER(L.NOM_APEPAT), ' ', UPPER(L.NOM_APEMAT))                     AS NOMBRE_COMPLETO,
                    CONCAT(SUBSTRING(L.NOM_NOMBRE, 1, 1), '.', UPPER(L.NOM_APEPAT), ' ', UPPER(L.NOM_APEMAT))           AS TXTNOMCIRUSMALL,
                    CONCAT(UPPER(L.NOM_NOMBRE), ' ', UPPER(L.NOM_APEPAT), ' ', UPPER(SUBSTRING(L.NOM_APEMAT, 1, 1)))    AS TXTPRIMERNOMBREAPELLIDO,
                    L.NUM_FICHAE AS NUM_FICHAE,

                    CASE
                    WHEN P.COD_EMPRESA = 1000 THEN
                    (SELECT E.NUM_NFICHA
                    FROM ADMIN.SO_TCPACTE E
                    WHERE E.NUM_FICHAE = P.NUM_FICHAE AND E.COD_EMPRESA = 100 LIMIT 1)
                    ELSE
                    (SELECT E.NUM_NFICHA
                    FROM ADMIN.SO_TCPACTE E
                    WHERE E.NUM_FICHAE = P.NUM_FICHAE AND E.COD_EMPRESA = P.COD_EMPRESA LIMIT 1)
                    END AS FICHAL,

                    (SELECT A.NOM_PREVIS
                    FROM ADMIN.GG_TDATPREV A,
                    ADMIN.SO_TTITUL B,
                    ADMIN.GG_TGPACTE C,
                    ADMIN.GG_TINSEMP D
                    WHERE A.IND_PREVIS = B.IND_PREVIS
                    AND B.COD_RUTTIT = C.COD_RUTTIT
                    AND B.NUM_RUTINS = D.COD_RUTINS
                    AND C.NUM_FICHAE = P.NUM_FICHAE
                    AND A.IND_ESTADO = 'V') AS TXT_PREVISION,

                    CONCAT(UPPER(PRO.NOM_NOMBRE), ' ', UPPER(PRO.NOM_APEPAT), ' ', UPPER(PRO.NOM_APEMAT))   AS NOM_PROFE_CORTO,
                    CONCAT(PRO.NOM_APEPAT, ' ', PRO.NOM_APEMAT, ' ', PRO.NOM_NOMBRE)                        AS NOM_PROFE,
                    CONCAT(PRO.COD_RUTPRO, '-', PRO.COD_DIGVER)                                             AS TXT_RUTPRO,
                    PRO.COD_RUTPRO                                                                          AS ID,
                    PRO.COD_DIGVER                                                                          AS DV,
                    PRO.COD_TPROFE                                                                          AS MEDI,
                    P.PA_ID_PROCARCH AS PA_ID_PROCARCH,
                    CASE WHEN P.PA_ID_PROCARCH = '31' THEN 'PABELLÓN'
                    WHEN P.PA_ID_PROCARCH = '63' THEN 'RCE ESPECIALIDADES'
                    WHEN P.PA_ID_PROCARCH = '65' THEN 'MODULO ANATOMIA'
                    ELSE 'NO INFORMADO' END AS TXT_PROCEDENCIA,
                    P.ID_SERDEP AS ID_SERVICIO,
                    (SELECT S.NOM_SERVIC
                    FROM ADMIN.GG_TSERVICIOXEMP T,
                    ADMIN.GG_TSERVICIO S
                    WHERE T.ID_SERDEP = P.ID_SERDEP
                    AND T.COD_EMPRESA = P.COD_EMPRESA
                    AND S.ID_SERDEP = T.ID_SERDEP LIMIT 1) AS NOMBRE_SERVICIO,
                    P.ID_SOLICITUD_HISTO AS ID_SOLICITUD,
                    UPPER(P.TXT_DIAGNOSTICO) AS TXT_DIAGNOSTICO,
                    DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i') AS FEC_EMISION,
                    DATE_FORMAT(P.FEC_USRCREA, '%d-%m-%Y %H:%i') AS FECHA_SOLICITUD,
                    DATE_FORMAT(P.DATE_INICIOREGISTRO, '%d-%m-%Y %H:%i') AS FECHA_TOMA_MUESTRA,
                    DATE_FORMAT(P.DATE_INICIOREGISTRO, '%H:%i') AS INICIOHORAMIN,
                    CASE P.IND_TIPO_BIOPSIA
                        WHEN '1' THEN 'SI'
                        WHEN '2' THEN 'CONTEMPORANEA'
                        WHEN '3' THEN 'DIFERIDA'
                        WHEN '4' THEN 'BIOPSIA + CITOLOGÍA'
                        WHEN '6' THEN 'CITOLOGÍA PAP'
                        WHEN '5' THEN 'SOLO CITOLOGÍA'  ELSE 'NO INFORMADO'
                    END AS TIPO_DE_BIOPSIA,
                    P.IND_TIPO_BIOPSIA AS IND_TIPO_BIOPSIA,
                    CASE P.IND_ESTADO
                        WHEN '1' THEN 'NUEVA SOLICITUD'
                        WHEN '2' THEN 'ESTADO 1'
                        WHEN '3' THEN 'ESTADO 2'  END AS TXT_ESTADO,
                    P.DES_SITIOEXT,
                    P.DES_UBICACION,
                    P.DES_TAMANNO,
                    CASE P.ID_TIPO_LESION
                        WHEN '1' THEN 'LIQUIDO'
                        WHEN '2' THEN 'ORGANO'
                        WHEN '3' THEN 'TEJIDO'
                        ELSE 'NO INFORMADO' END AS TXT_TIPOSESION,
                    CASE P.ID_ASPECTO
                        WHEN '1' THEN 'INFLAMATORIA'
                        WHEN '2' THEN 'BENIGNA'
                        WHEN '3' THEN 'NEOPLASICA'
                        ELSE 'NO INFORMADO' END AS TXT_ASPECTO,
                    CASE P.ID_ANT_PREVIOS
                        WHEN '1' THEN 'NO'
                        WHEN '2' THEN 'BIOPSIA'
                        WHEN '3' THEN 'CITOLOGIA'
                        ELSE 'NO INFORMADO' END AS TXT_ANT_PREVIOS,
                    P.ID_ANT_PREVIOS,
                    P.NUM_ANTECEDENTES,
                    P.DES_BIPSIA,
                    P.DES_CITOLOGIA,
                    P.DES_OBSERVACIONES,
                    P.NUM_FICHAE,
                    P.COD_USRCREA,
                    P.FEC_USRCREA,
                    P.COD_EMPRESA,
                    P.DES_SITIOEXT,
                    P.DES_UBICACION,
                    P.DES_TAMANNO,
                    P.ID_TIPO_LESION,
                    P.ID_ASPECTO,
                    P.ID_ANT_PREVIOS,
                    P.NUM_ANTECEDENTES,
                    P.DES_BIPSIA,
                    P.DES_CITOLOGIA,
                    P.DES_OBSERVACIONES,
                    P.IND_ESTADO,
                    P.FEC_REVISION,
                    P.ID_TABLA,
                    P.DES_TIPOMUESTRA,
                    P.NUM_SUBNUMERACION,
                    P.COD_USRCREA_TO_MUE,
                    P.FEC_USRCREA_TO_MUE,
                    P.COD_USRCREA_ENV,
                    P.FEC_USRCREA_ENV,
                    P.COD_USRCREA_RECEP,
                    P.FEC_USRCREA_RECEP,
                    P.COD_EMPRESA_RECEP,
                    P.COD_USRCREA_INFORMADA,
                    P.FEC_USRCREA_INFORMADA,
                    P.COD_EMPRESA_INFORMADA,
                    P.ID_ARCHIVO_SUBIDO,
                    P.COD_USRCREA_RECH,
                    P.FEC_USRCREA_RECH,
                    P.COD_EMPRESA_RECH,
                    P.TIPO_RECHAZO,
                    P.OBS_RECHAZO,
                    P.ID_HISTO_ESTADO,
                    CASE P.ID_HISTO_ESTADO
                    WHEN '1' THEN 'NUEVA SOLICITUD'
                    WHEN '2' THEN 'CUSTODIA'
                    WHEN '3' THEN 'TRASPORTE'
                    WHEN '4' THEN 'RECEPCIONADA'
                    WHEN '5' THEN 'RECHAZADA'
                    ELSE 'NO INFORMADA'
                    END AS TXT_HISTO_ESTADO,
                    P.AD_ID_ADMISION,
                    P.ID_SERDEP,
                    P.IND_TIPO_BIOPSIA,
                    P.IND_TEMPLATE,
                    P.DATE_INICIOREGISTRO,
                    P.COD_RUTPRO,
                    CASE P.ID_HISTO_ESTADO
                    WHEN '1' THEN 'NUEVA SOLICITUD'
                    WHEN '2' THEN 'CUSTODIA'
                    WHEN '3' THEN 'TRASPORTE'
                    WHEN '4' THEN 'RECEPCIONADA'
                    WHEN '5' THEN 'RECHAZADA'
                    ELSE 'NO INFORMADO'
                    END AS TXT_HISTO_ESTADO,
                    P.IND_ESTADO_MUESTRAS AS IND_ESTADO_MUESTRAS,
                    P.ID_NUM_CARGA,
                    P.ID_UID,
                    P.LAST_USR_AUDITA,
                    DATE_FORMAT(P.LAST_DATE_AUDITA, '%d-%m-%Y %H:%i') AS LAST_DATE_AUDITA,
                    P.TXT_NAMEAUDITA,
                    E.NOM_RAZSOC

                FROM ADMIN.PB_SOLICITUD_HISTO P
                JOIN ADMIN.GG_TGPACTE L ON L.NUM_FICHAE = P.NUM_FICHAE
                JOIN ADMIN.GG_TPROFESIONAL PRO ON PRO.COD_RUTPRO = P.COD_RUTPRO
                JOIN ADMIN.SS_TEMPRESAS E ON E.COD_EMPRESA = P.COD_EMPRESA
                WHERE P.DATE_INICIOREGISTRO BETWEEN ? AND ?
                AND P.IND_ESTADO = 1 
                AND P.COD_EMPRESA IN ($placeholders)
                ORDER BY
                    P.DATE_INICIOREGISTRO";

        $query    = $this->db->query($sql, $bindings);
        $arr_data = $query->result_array();
        return [
            'html_externo' => $data_controller["ind_template"] == 'ssan_libro_biopsias_listaexterno1' || $data_controller["ind_template"] == 'ssan_libro_biopsias_listaxusuarios'
                ? $this->html_externo_rce(array("data_controller"=>$data_controller,"data"=>$arr_data))
                : $this->LI_RESULTADOS_ANATOMIA($arr_data,$data_controller["num_fase"]),
            'return_bd' => $result,
            'userdata' => $this->session->userdata,
            'ind_opcion' => $data_controller["ind_opcion"], 
            'ind_template' => $data_controller["ind_template"],
            'date_inicio' => $data_controller["data_inicio"],
            'date_final' => $data_controller["data_final"],
            'num_fase' => $num_fase,
        ];
    }

    public function model_busquedasolicitudes_recepcion($data_controller) {
        $v_fecha_inicio = explode("-",$data_controller['data_inicio']);
        $v_data_final = explode("-",$data_controller['data_final']);
        $fecha_inicio = $v_fecha_inicio[2].'-'.$v_fecha_inicio[1].'-'.$v_fecha_inicio[0].' 00:00:00';
        $fecha_final = $v_data_final[2].'-'.$v_data_final[1].'-'.$v_data_final[0].' 23:59:59';
        $cod_empresa = $data_controller['COD_EMPRESA'];
        $num_fase = $data_controller['num_fase'];
        if ($cod_empresa == '029') {
            $sql_emp = "SELECT E.COD_EMPRESA FROM ADMIN.SS_TEMPRESAS E WHERE IND_ESTADO = 'V' ";
        } else {
            $sql_emp = "SELECT E.COD_EMPRESA FROM ADMIN.SS_TEMPRESAS E WHERE IND_ESTADO = 'V' AND E.COD_EMPRESA <> '029'";
        }
        $rows = $this->db->query($sql_emp)->result_array();
        $cods = array_column($rows, 'COD_EMPRESA');
        $placeholders = implode(',', array_fill(0, count($cods), '?'));
        $bindings = array_merge([$fecha_inicio, $fecha_final], $cods );
        $sql = "SELECT 
                    P.ID_ROTULADO                                                                                       AS ID_ROTULADO,
                    P.COD_ESTABLREF                                                                                     AS COD_ESTABLREF,
                    P.ID_SIC                                                                                            AS COD_ESTABLREF,
                    P.IND_DERIVACION_IC                                                                                 AS IND_DERIVACION_IC,
                    P.ID_HISTO_ZONA                                                                                     AS ID_HISTO_ZONA,
                    CONCAT(L.COD_RUTPAC, '-', L.COD_DIGVER)                                                             AS RUTPACIENTE,
                    L.IND_TISEXO                                                                                        AS IND_TISEXO,
                    L.COD_RUTPAC                                                                                        AS COD_RUTPAC,
                    FLOOR(TIMESTAMPDIFF(MONTH, L.FEC_NACIMI, NOW()) / 12)                                               AS NUMEDAD,
                    DATE_FORMAT(L.FEC_NACIMI, '%d-%m-%Y')                                                               AS NACIMIENTO,
                    FLOOR(TIMESTAMPDIFF(MONTH, L.FEC_NACIMI, NOW()) / 12)                                               AS EDAD,
                    CONCAT(UPPER(L.NOM_NOMBRE), ' ', UPPER(L.NOM_APEPAT), ' ', UPPER(L.NOM_APEMAT))                     AS NOMBRE_COMPLETO,
                    CONCAT(SUBSTRING(L.NOM_NOMBRE, 1, 1), '.', UPPER(L.NOM_APEPAT), ' ', UPPER(L.NOM_APEMAT))           AS TXTNOMCIRUSMALL,
                    CONCAT(UPPER(L.NOM_NOMBRE), ' ', UPPER(L.NOM_APEPAT), ' ', UPPER(SUBSTRING(L.NOM_APEMAT, 1, 1)))    AS TXTPRIMERNOMBREAPELLIDO,
                    L.NUM_FICHAE AS NUM_FICHAE,

                    CASE
                    WHEN P.COD_EMPRESA = 1000 THEN
                    (SELECT E.NUM_NFICHA
                    FROM ADMIN.SO_TCPACTE E
                    WHERE E.NUM_FICHAE = P.NUM_FICHAE AND E.COD_EMPRESA = 100 LIMIT 1)
                    ELSE
                    (SELECT E.NUM_NFICHA
                    FROM ADMIN.SO_TCPACTE E
                    WHERE E.NUM_FICHAE = P.NUM_FICHAE AND E.COD_EMPRESA = P.COD_EMPRESA LIMIT 1)
                    END AS FICHAL,

                    (SELECT A.NOM_PREVIS
                    FROM ADMIN.GG_TDATPREV A,
                    ADMIN.SO_TTITUL B,
                    ADMIN.GG_TGPACTE C,
                    ADMIN.GG_TINSEMP D
                    WHERE A.IND_PREVIS = B.IND_PREVIS
                    AND B.COD_RUTTIT = C.COD_RUTTIT
                    AND B.NUM_RUTINS = D.COD_RUTINS
                    AND C.NUM_FICHAE = P.NUM_FICHAE
                    AND A.IND_ESTADO = 'V') AS TXT_PREVISION,

                    CONCAT(UPPER(PRO.NOM_NOMBRE), ' ', UPPER(PRO.NOM_APEPAT), ' ', UPPER(PRO.NOM_APEMAT))   AS NOM_PROFE_CORTO,
                    CONCAT(PRO.NOM_APEPAT, ' ', PRO.NOM_APEMAT, ' ', PRO.NOM_NOMBRE)                        AS NOM_PROFE,
                    CONCAT(PRO.COD_RUTPRO, '-', PRO.COD_DIGVER)                                             AS TXT_RUTPRO,
                    PRO.COD_RUTPRO                                                                          AS ID,
                    PRO.COD_DIGVER                                                                          AS DV,
                    PRO.COD_TPROFE                                                                          AS MEDI,
                    P.PA_ID_PROCARCH AS PA_ID_PROCARCH,
                    CASE WHEN P.PA_ID_PROCARCH = '31' THEN 'PABELLÓN'
                    WHEN P.PA_ID_PROCARCH = '63' THEN 'RCE ESPECIALIDADES'
                    WHEN P.PA_ID_PROCARCH = '65' THEN 'MODULO ANATOMIA'
                    ELSE 'NO INFORMADO' END AS TXT_PROCEDENCIA,
                    P.ID_SERDEP AS ID_SERVICIO,
                    (SELECT S.NOM_SERVIC
                    FROM ADMIN.GG_TSERVICIOXEMP T,
                    ADMIN.GG_TSERVICIO S
                    WHERE T.ID_SERDEP = P.ID_SERDEP
                    AND T.COD_EMPRESA = P.COD_EMPRESA
                    AND S.ID_SERDEP = T.ID_SERDEP LIMIT 1) AS NOMBRE_SERVICIO,
                    P.ID_SOLICITUD_HISTO AS ID_SOLICITUD,
                    UPPER(P.TXT_DIAGNOSTICO) AS TXT_DIAGNOSTICO,
                    DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i') AS FEC_EMISION,
                    DATE_FORMAT(P.FEC_USRCREA, '%d-%m-%Y %H:%i') AS FECHA_SOLICITUD,
                    DATE_FORMAT(P.DATE_INICIOREGISTRO, '%d-%m-%Y %H:%i') AS FECHA_TOMA_MUESTRA,
                    DATE_FORMAT(P.DATE_INICIOREGISTRO, '%H:%i') AS INICIOHORAMIN,
                    CASE P.IND_TIPO_BIOPSIA
                        WHEN '1' THEN 'SI'
                        WHEN '2' THEN 'CONTEMPORANEA'
                        WHEN '3' THEN 'DIFERIDA'
                        WHEN '4' THEN 'BIOPSIA + CITOLOGÍA'
                        WHEN '6' THEN 'CITOLOGÍA PAP'
                        WHEN '5' THEN 'SOLO CITOLOGÍA'  ELSE 'NO INFORMADO'
                    END AS TIPO_DE_BIOPSIA,
                    P.IND_TIPO_BIOPSIA AS IND_TIPO_BIOPSIA,
                    CASE P.IND_ESTADO
                        WHEN '1' THEN 'NUEVA SOLICITUD'
                        WHEN '2' THEN 'ESTADO 1'
                        WHEN '3' THEN 'ESTADO 2'  END AS TXT_ESTADO,
                    P.DES_SITIOEXT,
                    P.DES_UBICACION,
                    P.DES_TAMANNO,
                    CASE P.ID_TIPO_LESION
                        WHEN '1' THEN 'LIQUIDO'
                        WHEN '2' THEN 'ORGANO'
                        WHEN '3' THEN 'TEJIDO'
                        ELSE 'NO INFORMADO' END AS TXT_TIPOSESION,
                    CASE P.ID_ASPECTO
                        WHEN '1' THEN 'INFLAMATORIA'
                        WHEN '2' THEN 'BENIGNA'
                        WHEN '3' THEN 'NEOPLASICA'
                        ELSE 'NO INFORMADO' END AS TXT_ASPECTO,
                    CASE P.ID_ANT_PREVIOS
                        WHEN '1' THEN 'NO'
                        WHEN '2' THEN 'BIOPSIA'
                        WHEN '3' THEN 'CITOLOGIA'
                        ELSE 'NO INFORMADO' END AS TXT_ANT_PREVIOS,
                    P.ID_ANT_PREVIOS,
                    P.NUM_ANTECEDENTES,
                    P.DES_BIPSIA,
                    P.DES_CITOLOGIA,
                    P.DES_OBSERVACIONES,
                    P.NUM_FICHAE,
                    P.COD_USRCREA,
                    P.FEC_USRCREA,
                    P.COD_EMPRESA,
                    P.DES_SITIOEXT,
                    P.DES_UBICACION,
                    P.DES_TAMANNO,
                    P.ID_TIPO_LESION,
                    P.ID_ASPECTO,
                    P.ID_ANT_PREVIOS,
                    P.NUM_ANTECEDENTES,
                    P.DES_BIPSIA,
                    P.DES_CITOLOGIA,
                    P.DES_OBSERVACIONES,
                    P.IND_ESTADO,
                    P.FEC_REVISION,
                    P.ID_TABLA,
                    P.DES_TIPOMUESTRA,
                    P.NUM_SUBNUMERACION,
                    P.COD_USRCREA_TO_MUE,
                    P.FEC_USRCREA_TO_MUE,
                    P.COD_USRCREA_ENV,
                    P.FEC_USRCREA_ENV,
                    P.COD_USRCREA_RECEP,
                    P.FEC_USRCREA_RECEP,
                    P.COD_EMPRESA_RECEP,
                    P.COD_USRCREA_INFORMADA,
                    P.FEC_USRCREA_INFORMADA,
                    P.COD_EMPRESA_INFORMADA,
                    P.ID_ARCHIVO_SUBIDO,
                    P.COD_USRCREA_RECH,
                    P.FEC_USRCREA_RECH,
                    P.COD_EMPRESA_RECH,
                    P.TIPO_RECHAZO,
                    P.OBS_RECHAZO,
                    P.ID_HISTO_ESTADO,
                    CASE P.ID_HISTO_ESTADO
                        WHEN '1' THEN 'NUEVA SOLICITUD'
                        WHEN '2' THEN 'CUSTODIA'
                        WHEN '3' THEN 'TRASPORTE'
                        WHEN '4' THEN 'RECEPCIONADA'
                        WHEN '5' THEN 'RECHAZADA' ELSE 'NO INFORMADA' END AS TXT_HISTO_ESTADO,
                    P.AD_ID_ADMISION,
                    P.ID_SERDEP,
                    P.IND_TIPO_BIOPSIA,
                    P.IND_TEMPLATE,
                    P.DATE_INICIOREGISTRO,
                    P.COD_RUTPRO,
                    CASE P.ID_HISTO_ESTADO
                        WHEN '1' THEN 'NUEVA SOLICITUD'
                        WHEN '2' THEN 'CUSTODIA'
                        WHEN '3' THEN 'TRASPORTE'
                        WHEN '4' THEN 'RECEPCIONADA'
                        WHEN '5' THEN 'RECHAZADA'   ELSE 'NO INFORMADO'  END AS TXT_HISTO_ESTADO,
                    P.IND_ESTADO_MUESTRAS AS IND_ESTADO_MUESTRAS,
                    P.ID_NUM_CARGA,
                    P.ID_UID,
                    P.LAST_USR_AUDITA,
                    DATE_FORMAT(P.LAST_DATE_AUDITA, '%d-%m-%Y %H:%i') AS LAST_DATE_AUDITA,
                    P.TXT_NAMEAUDITA,
                    E.NOM_RAZSOC

                FROM ADMIN.PB_SOLICITUD_HISTO P
                JOIN ADMIN.GG_TGPACTE L ON L.NUM_FICHAE = P.NUM_FICHAE
                JOIN ADMIN.GG_TPROFESIONAL PRO ON PRO.COD_RUTPRO = P.COD_RUTPRO
                JOIN ADMIN.SS_TEMPRESAS E ON E.COD_EMPRESA = P.COD_EMPRESA
                WHERE P.DATE_INICIOREGISTRO BETWEEN ? AND ?
                AND P.IND_ESTADO = 1 
                AND P.COD_EMPRESA IN ($placeholders)
                ORDER BY
                    P.DATE_INICIOREGISTRO";
        $query    = $this->db->query($sql, $bindings);
        $arr_data = $query->result_array();
        return [
            'html_externo' => $data_controller["ind_template"] == 'ssan_libro_biopsias_listaexterno1' || $data_controller["ind_template"] == 'ssan_libro_biopsias_listaxusuarios'
                ? $this->html_externo_rce(array("data_controller"=>$data_controller,"data"=>$arr_data))
                : $this->LI_RESULTADOS_ANATOMIA($arr_data,$data_controller["num_fase"]),
            'return_bd' => $result,
            'userdata' => $this->session->userdata,
            'ind_opcion' => $data_controller["ind_opcion"], 
            'ind_template' => $data_controller["ind_template"],
            'date_inicio' => $data_controller["data_inicio"],
            'date_final' => $data_controller["data_final"],
            'num_fase' => $num_fase,
        ];
    }

    #############################
    # ssan_libro_biopsias_ii_fase 
    # MAIN ANATOMIA PATOLOGICA PRINCIPAL 
    # MAIN MODULO SIN CITA 
    #############################
    public function LI_RESULTADOS_ANATOMIA($ARRAY,$CALL_FASE){
        $HTML = '';
        if(count($ARRAY)>0){
            foreach($ARRAY as $i => $row){
                $num = ($i+1);
                $BTN = '
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu">';

                            if ($CALL_FASE == 1){
                                //******************************************************
                                if ($row['ID_HISTO_ESTADO'] == 1 ){
                                    $BTN .= '<li><a href="javascript:pre_busqueda(3,'.$row['ID_SOLICITUD'].')"><i class="fa fa-chevron-right"></i>EN CUSTODIA / TRASPORTE</a></li>';
                                    $BTN .= '<li class="divider"></li>';
                                }
                                if ($row['ID_HISTO_ESTADO'] == 2){
                                    //historial
                                    //$BTN .= '<li class="historial"><a href="javascript:viws_historial('.$row['ID_SOLICITUD'].')"><i class="fa fa-database" aria-hidden="true"></i>HISTORIAL DE MUESTRAS</a></li>';
                                    //$BTN .= '<li class="divider"></li>';
                                }
                                //******************************************************
                            }  else if ($CALL_FASE == 2){
                                
                                if($row['ID_HISTO_ESTADO'] == 3 || $row['ID_HISTO_ESTADO'] == 1){
                                    $BTN .= '<li><a class="dropdown-item" href="javascript:pre_busqueda(3,'.$row['ID_SOLICITUD'].')"><i class="fa fa-chevron-right"></i>&nbsp;RECEPCI&Oacute;N</a></li>';
                                    $BTN .= '<li class="divider"></li>';
                                } else if($row['ID_HISTO_ESTADO'] == 4){
                                    //IND_ESTADO_MUESTRAS
                                    if ($row['IND_ESTADO_MUESTRAS']!=1){
                                        $BTN .= '<li><a class="dropdown-item" href="javascript:pre_busqueda(3,'.$row['ID_SOLICITUD'].')"><i class="fa fa-chevron-right"></i>&nbsp;RECEPCI&Oacute;N REZAGADAS</a></li>';
                                        //$BTN .= '<li class="divider"></li>';
                                        $BTN .= '<li><a class="dropdown-item" href="javascript:pdf_rechazomuestra('.$row['ID_SOLICITUD'].')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;INFORME DE RECHAZO</a></li>';
                                        //$BTN .= '<li class="divider"></li>';
                                    } else {
                                        $BTN .= '<li><a class="dropdown-item" href="javascript:pdf_recepcion_ok('.$row['ID_SOLICITUD'].')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF RECEPCI&Oacute;N</a></li>';
                                        //$BTN .= '<li><a class="dropdown-item" href="javascript:informar_x_correo('.$row['ID_SOLICITUD'].')"><i class="fa fa-envelope-open" aria-hidden="true"></i>INFORMAR POR CORREO</a></li>';
                                        //$BTN .= '<li class="divider"></li>';
                                    }
                                    //historial
                                    //$BTN              .=      '<li class="historial"><a href="javascript:viws_historial('.$row['ID_SOLICITUD'].')"><i class="fa fa-database" aria-hidden="true"></i>HISTORIAL DE MUESTRAS</a></li>';
                                } else if($row['ID_HISTO_ESTADO'] == 5){
                                    $BTN .= '<li><a class="dropdown-item" href="javascript:pdf_rechazomuestra('.$row['ID_SOLICITUD'].')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF RECHAZADA</a></li>';
                                    $BTN .= '<li><hr class="dropdown-divider"></li>';
                                }
                                
                            } else {
                                $BTN .=  '';
                            }

                            $BTN .= '<li><a class="dropdown-item" href="javascript:GET_PDF_ANATOMIA_PANEL('.$row['ID_SOLICITUD'].')"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF ANATOM&Iacute;A PATOL&Oacute;GICA</a></li>';
                            $BTN .= '
                            </ul>
                        </div>
                        ';
                #ID_HISTO_ESTADO
                $html_tooltip2 = '';
                if($row['ID_HISTO_ESTADO']!=1){
                    $html_tooltip2 = '<div class="grid_tooltip">
                                        <div class="grid_11">'.$row['TXT_HISTO_ESTADO'].'</div>
                                        <div class="grid_12">'.$row['TXT_NAMEAUDITA'].'</div>
                                        <div class="grid_13">RUT</div>
                                        <div class="grid_14">'.$row['LAST_USR_AUDITA'].'</div>
                                        <div class="grid_15">FECHA/HORA</div>
                                        <div class="grid_16">'.$row['LAST_DATE_AUDITA'].'</div>
                                    </div>';
                } 
                $INFORMACION            =   '';
                       if($row['ID_HISTO_ESTADO'] == 1){
                    #('.$row['ID_HISTO_ESTADO'].')
                    $INFORMACION = '<button class="btn btn-xs btn-fill cssmain btn-default parpadea" style="width: 100%;margin:0px 0px 0px 0px;"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;NUEVA SOLICITUD&nbsp;</button>';
                } else if($row['ID_HISTO_ESTADO'] == 2){
                    $INFORMACION = '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;">';
                    $INFORMACION .= '<button class="btn btn-xs btn-fill cssmain btn-warning" style="width: -webkit-fill-available;margin:0px 0px 0px 0px;" data-toggle="tooltip" data-placement="bottom" title=\''.$html_tooltip2.'\' data-html="true"><i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;CUSTODIA</button>';
                    $color_estado = $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado = $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check" aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION .= '<button class="btn btn-xs btn-fill cssmain btn-'.$color_estado.'" style="width: -webkit-fill-available;margin:0px 0px 0px 0px;">'.$txt_estado.'</button>';
                    $INFORMACION .= '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 3){
                    $INFORMACION = '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;">';
                    $INFORMACION .= '<button class="btn btn-xs btn-fill cssmain btn-info parpadea" style="width: -webkit-fill-available;margin:0px 0px 0px 0px;" data-toggle="tooltip" data-placement="bottom" title=\''.$html_tooltip2.'\' data-html="true"><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;EN TRASPORTE</button>';
                    $color_estado = $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado = $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check" aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION .= '<button class="btn btn-xs btn-fill cssmain btn-'.$color_estado.'" style="width: -webkit-fill-available;margin:0px 0px 0px 0px;">'.$txt_estado.'</button>';
                    $INFORMACION .= '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 4){
                    $INFORMACION = '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;">';
                    $INFORMACION .= '<button class="btn btn-xs btn-fill cssmain btn-success" style="width: -webkit-fill-available;margin:0px 0px 0px 0px;" data-toggle="tooltip" data-placement="bottom" title=\''.$html_tooltip2.'\' data-html="true"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;RECEPCIONADA</button>';
                    $color_estado = $row['IND_ESTADO_MUESTRAS']==1?'success':'danger'; 
                    $txt_estado =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check" aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION .= '<button class="btn btn-xs btn-fill cssmain btn-'.$color_estado.'" style="width: -webkit-fill-available;margin:0px 0px 0px 0px;">'.$txt_estado.'</button>';
                    $INFORMACION .= '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 5){
                    $INFORMACION = '<button class="btn btn-xs btn-fill cssmain btn-danger" style="width: 100%;margin:0px 0px 0px 0px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;RECHAZADA</button>';
                } else {
                    $INFORMACION = '<button class="btn btn-xs btn-fill cssmain btn-danger" style="width: 100%;margin:0px 0px 0px 0px;"><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;SIN INFORMACI&Oacute;N</button>';
                }

                $v_txt_derivado = $row['TXT_EMPRESA_DERIVADO']==''?'':'<span class="label label-warning">'.$row['TXT_EMPRESA_DERIVADO'].'</span> | ';
                #html li
                $HTML .= '<li class="gespab_group list-group-item LISTA_BODY_'.$CALL_FASE.'" >
                                            <div class="CSS_GRID_CIRUGIA_FASE_1" 
                                                id =   "DATA_'.$row['ID_SOLICITUD'].'"
                                                data-paciente =   "'.htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8').'">
                                                <div class="text-center">'.$num.'</div>
                                                <div >
                                                    '.$row['NOMBRE_COMPLETO'].'<hr style="margin: 0px 0px 0px 0px;">
                                                    '.$row['RUTPACIENTE'].'<hr style="margin: 0px 0px 0px 0px;">
                                                    <!--   
                                                        N&deg; Ficha: '.$row['FICHAL'].'
                                                        &nbsp;|&nbsp; PA_ID_PROCARCH = '.$row['PA_ID_PROCARCH'].'<br>
                                                        &nbsp;|&nbsp; ID_HISTO_ESTADO = '.$row['ID_HISTO_ESTADO'].'<br>
                                                        &nbsp;|&nbsp; CALL_FASE = '.$CALL_FASE.'
                                                    -->    
                                                 </div>
                                                <div >
                                                    '.$row['NOM_PROFE_CORTO'].'
                                                    <hr style="margin: 0px 0px 0px 0px;">'.$row['TXT_RUTPRO'].'
                                                    <hr style="margin: 0px 0px 0px 0px;"><b>'.$row['NOM_RAZSOC'].'</b>
                                                </div>
                                                <div style="text-align : initial;">
                                                    '.$row['TIPO_DE_BIOPSIA'].'
                                                    <hr style="margin: 0px 0px 4px 0px;">
                                                    '.$row['TXT_PROCEDENCIA'].'
                                                    <hr style="margin: 0px 0px 4px 0px;">
                                                    '.$row['NOMBRE_SERVICIO'].'
                                                </div>
                                                <div style="text-align : initial;">
                                                    '.$INFORMACION.'
                                                    <hr style="margin: 0px 0px 4px 0px;"> 
                                                    <div class="text-center">'.$row['FECHA_SOLICITUD'].'</div>
                                                    <hr style="margin: 0px 0px 4px 0px;"> 
                                                    <div class="text-center">
                                                    '.$v_txt_derivado.' <b>N&deg;:'.$row['ID_SOLICITUD'].'</b> 
                                                    <!--
                                                        <hr> 
                                                        CALL_FASE :&nbsp;|&nbsp;'.$CALL_FASE.'
                                                        <hr> 
                                                        ID_HISTO_ESTADO :&nbsp;|&nbsp;'.$row['ID_HISTO_ESTADO'].'
                                                        <hr> 
                                                        IND_ESTADO_MUESTRAS :&nbsp;|&nbsp;'.$row['IND_ESTADO_MUESTRAS'].'
                                                    -->
                                                    </div> 
                                                </div>
                                                <div>
                                                    <div class="grid_lista_gestion_masivo_li">
                                                        <div class="grid_lista_gestion_masivo_li1">'.$BTN.'</div>
                                                        <div class="grid_lista_gestion_masivo_li2"></div>
                                                        <div class="grid_lista_gestion_masivo_li2">';
                                                        if ($row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2 || $row['ID_HISTO_ESTADO'] == 3 ){
                                                            $style_display_none =   $CALL_FASE==2&&$row['ID_HISTO_ESTADO']==3?'display:none;':'display:none;';
                                                            $HTML .= '
                                                                    <input 
                                                                        type = "checkbox" 
                                                                        class = "form-check-input marcado_custoria_trasporte  marcado_recepcion_masiva checkbox_'.$row['ID_SOLICITUD'].'" 
                                                                        id = "CHEK_'.$row['ID_SOLICITUD'].'" 
                                                                        style = "display:block;cursor:pointer;margin:0px;'.$style_display_none.' " 
                                                                        onchange = "js_muestra_indivual('.$row['ID_SOLICITUD'].');" value="'.$row['ID_SOLICITUD'].'">';
                                                            
                                                            
                                                        } else {
                                                            $HTML       .=      '';
                                                        }
                                            $HTML .= '</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    ';
            }
        } else {
            $HTML           .=      '
                                    <li class="gespab_group NO_INFORMACION list-group-item">
                                        <div class="GRID_NO_INFOPANEL"> 
                                            <div class="GRID_NO_INFOPANEL1">
                                                <i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b>SIN INFORMACI&Oacute;N</b>   
                                            </div>
                                        </div>
                                    </li>
                                    ';
        }
        return $HTML;
    }

    #llamada de externo 
    public function html_externo_rce($data){
        $html = '';
        $btn_traza_visible = $data["data_controller"]["ind_template"] == "ssan_libro_biopsias_listaexterno1"?true:false;
        if(count($data["data"])>0){
            foreach($data["data"] as $i => $row){
                $style_li = '';
                $cirujano1 = '';
                $ARR_ANATOMIA = $row['ID_SOLICITUD'];
                $html_tooltip2 = '';
                if($row['ID_HISTO_ESTADO']!=1){
                    /*
                    $html_tooltip2 = '
                        <div class="grid_tooltip">
                            <div class="grid_11">'.$row['TXT_HISTO_ESTADO'].'</div>
                            <div class="grid_12">'.$row['TXT_NAMEAUDITA'].'</div>
                            <div class="grid_13">RUT</div>
                            <div class="grid_14">'.$row['LAST_USR_AUDITA'].'</div>
                            <div class="grid_15">FECHA/HORA</div>
                            <div class="grid_16">'.$row['LAST_DATE_AUDITA'].'</div>
                        </div>
                    ';
                    */
                    $html_tooltip2 = $row['TXT_HISTO_ESTADO'].'<br> '.$row['TXT_NAMEAUDITA'].',RUT:'.$row['LAST_USR_AUDITA'].' '.$row['LAST_DATE_AUDITA'];
                }

                $INFORMACION = '';
                if($row['ID_HISTO_ESTADO'] == 1){
                    #('.$row['ID_HISTO_ESTADO'].')
                    $INFORMACION    =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;margin-top: 10px;">';       
                    $INFORMACION    .=   '<button class="btn btn-xs btn-fill cssmain btn-default parpadea" style="width: 100%;margin:-10px 0px 0px 0px;"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;NUEVA SOLICITUD&nbsp;</button>';
                    $INFORMACION    .=   '</div>';
                } else  if($row['ID_HISTO_ESTADO'] == 2){
                    $INFORMACION    =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;margin-top: 10px;">';
                    $INFORMACION    .=   '<button class="btn btn btn-xs btn-fill cssmain btn-warning"   data-toggle="tooltip" data-placement="bottom" title=\''.htmlspecialchars($html_tooltip2, ENT_QUOTES).'\' data-html="true"><i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;CUSTODIA</button>';
                    $color_estado       =   $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado         =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check" aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION    .=   '<button class="btn btn btn-xs btn-fill cssmain btn-'.$color_estado.'"  >'.$txt_estado.'</button>';
                    $INFORMACION    .=   '</div>';
                } else  if($row['ID_HISTO_ESTADO'] == 3){
                    $INFORMACION    =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;margin-top: 10px;">';
                    $INFORMACION    .=   '<button class="btn btn btn-xs btn-fill cssmain btn-info parpadea"   data-toggle="tooltip" data-placement="bottom" title=\''.htmlspecialchars($html_tooltip2, ENT_QUOTES).'\' data-html="true"><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;TRASPORTE</button>';
                    $color_estado       =   $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado         =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check" aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION    .=   '<button class="btn btn btn-xs btn-fill cssmain btn-'.$color_estado.'"  >'.$txt_estado.'</button>';
                    $INFORMACION    .=   '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 4){
                    $INFORMACION    =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;margin-top: 10px;">';
                    $INFORMACION    .=   '<button class="btn btn btn-xs btn-fill cssmain btn-success"   data-toggle="tooltip" data-placement="bottom" title=\''.htmlspecialchars($html_tooltip2, ENT_QUOTES).'\' data-html="true"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;RECEPCIONADA</button>';
                    $color_estado       =   $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado         =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check"  aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION    .=   '<button class="btn btn btn-xs btn-fill cssmain btn-'.$color_estado.'"  >'.$txt_estado.'</button>';
                    $INFORMACION    .=   '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 5){
                    $INFORMACION    =   '<button class="btn btn-fill cssmain btn-danger" style="width: 100%;margin:-10px 0px 0px 0px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;RECHAZADA | '.$row['ID_HISTO_ESTADO'].'</button>';
                } else {
                    $INFORMACION    =   '<button class="btn btn-fill cssmain btn-danger" style="width: 100%;margin:-10px 0px 0px 0px;"><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;SIN INFORMACI&Oacute;N | '.$row['ID_HISTO_ESTADO'].'</button>';
                }
                
                $disabled = 'disabled';
                $ID_MAIN_AP = $row['ID_SOLICITUD'];
                ################################################
                $btn_trazabilidad   =   '';
                if ($btn_traza_visible) {
                    #13.07.2023
                    $btn_trazabilidad   .=      '
                                        <button 
                                            type = "button" 
                                            data-toggle = "popover"
                                            data-placement = "left"
                                            class =   "'.$disabled.' btn btn-small btn-fill btn-danger class_htrazabilidad '.$ID_MAIN_AP.'"
                                            id =   "btn_trabilidad_'.$ID_MAIN_AP.'"';
                    $btn_trazabilidad       .=  $ID_MAIN_AP!=''?'onclick = "js_htraxabilidad('.$ID_MAIN_AP.')"':'';
                    $btn_trazabilidad       .= '>
                                        <i class="fa fa-database" aria-hidden="true"></i>
                                    </button>';
                }
                $html               .=  '
                                                <li class="gespab_group list-group-item list-group-item-'.$style_li.' rotulo_'.$row['ID_ROTULADO'].' li_lista_externo_rce">
                                                    <div class="CSS_GRID_PUNTO_ENTREGA_EXT" 
                                                            id              =   "DATA_'.$row['ID_SOLICITUD'].'"
                                                            data-paciente   =   "'.htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8').'"
                                                        >
                                                        <div class="text-center">'.$row['INICIOHORAMIN'].'</div>
                                                        <div class="cirugia_row">
                                                            '.$row['NOMBRE_COMPLETO'].'
                                                            <br>
                                                            <i>'.$row['RUTPACIENTE'].'</i>
                                                        </div>
                                                        <div class="">'.$row['TXT_DIAGNOSTICO'].'</div>
                                                        <div class="">'.$row['NOM_PROFE_CORTO'].'</div>
                                                        <div class="">'.$row['TIPO_DE_BIOPSIA'].'</div>
                                                        <div class="text-center">'.$INFORMACION.'</div>';

                                    #BOTON SOLICITUD DE ANATOMIA PATOLOGICA
                                    $html       .=      '<div class="text-center">';
                                        $html       .=      $btn_trazabilidad;
                                    $html       .=      '</div>';
                                    #BOTON IMPRIME ETIQUETAS INDIVIDUAL
                                    $html       .=      '<div class="text-center">';
                                        $html       .=      '
                                                            <button 
                                                                type                    =   "button" 
                                                                data-toggle             =   "popover"
                                                                data-placement          =   "left"
                                                                class                   =   "'.$disabled.' btn btn-small btn-success btn-fill BTN_IMPRIME_ETIQUETA_ANATOMIA_'.$ID_MAIN_AP.'"
                                                                id                      =   "BTN_IMPRIME_ETIQUETA_ANATOMIA_'.$ID_MAIN_AP.'"';
                                        $html       .=  $ID_MAIN_AP!=''?'onclick        =   "popover_etiquetas(this.id,'.$ID_MAIN_AP.')"':'';
                                        $html       .=      '';
                                        $html       .=      '>
                                                                <i class="fa fa-archive" aria-hidden="true"></i>
                                                            </button>
                                                            ';
                                    $html           .=  '</div>';
                                    #BOTON IMPRIME ETIQUETAS
                                    $html       .=      '<div class="text-center">';
                                    #$html       .=      '-';
                                        $html       .=      '<button 
                                                                type                    =   "button" 
                                                                class                   =   "'.$disabled.' btn btn-small btn-info btn-fill"
                                                                id                      =   "BTN_IMPRIME_ETIQUETA_ANATOMIA"';
                                        $html   .=  $ID_MAIN_AP!=''?'onclick            =   "IMPRIME_ETIQUETA_ANATOMIA('.$ID_MAIN_AP.')"':'';
                                        $html       .=          ' 
                                                                data-toggle             =   "tooltip" 
                                                                data-placement          =   "bottom" 
                                                                title                   =   "Impresi&oacute;n total de etiquetas" 
                                                                data-html               =   "true"
                                                                ';
                                        $html       .=          '>';
                                        $html       .=          '<i class="fa fa-print" aria-hidden="true"></i>
                                                            </button>';
                                    $html       .=      '</div>';
                                    #PDF SOLO ANATOMICO
                                    #'.$disabled.'
                                    $html       .=      '<div class="text-center">
                                                            <button 
                                                                type                    =   "button" 
                                                                class                   =   "btn btn-small btn-warning btn-fill " 
                                                                id                      =   "PRE_GET_PDF_ANATOMIA_PRE"';
                                    #if($disabled!='disabled'){
                                    $html       .=             'onclick                 =   "PRE_GET_PDF_ANATOMIA('.$ID_MAIN_AP.')"';
                                    #}
                                    $html       .=          ' 
                                                                data-toggle             =   "tooltip" 
                                                                data-placement          =   "left" 
                                                                title                   =   "PDF anatom&iacute;a patol&oacute;gica" 
                                                                data-html               =   "true"
                                                                ';
                                    $html       .=         '><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                        ';
                                                        
                                    #CHECKBOX ELIMINAR ANATOMIA
                                    $html       .=      '<div class="text-center">';
                                    //solo nueva solicitud y en custoria
                                    if ($row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2){
                                        //if($row['IND_DERIVACION_IC'] == 0){
                                            $html   .=      '<input 
                                                                type        =   "checkbox" 
                                                                class       =   "form-check-input marcado_custoria_trasporte checkbox_'.$ID_MAIN_AP.'" 
                                                                id          =   "CHEK_'.$ID_MAIN_AP.'" 
                                                                style       =   "display:block;cursor:pointer;margin-left:10px;margin-top:-7px;" 
                                                                onchange    =   "js_muestra_indivual('.$ID_MAIN_AP.');" value="'.$ID_MAIN_AP.'">';
                                        //} else {
                                           //$html       .=  'IC';
                                        //}
                                    } else {
                                        #INFORMACION
                                    }
                                    #$html       .=      $row['ID_HISTO_ZONA'];
                                    #ID_HISTO_ZONA
                                    #if($row['ID_HISTO_ZONA'] == 8){ }
                                    $html       .=      '</div>';
                                    $html       .='</div>
                                            </li>';
            }
        } else {
            $html               =   '<li class="gespab_group NO_INFORMACION list-group-item">
                                        <div class="GRID_NO_INFOPANEL"> 
                                            <div class="GRID_NO_INFOPANEL1">
                                                <i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b> SIN SOLICITUDES | '.$data["data_controller"]["data_inicio"].'</b>   
                                            </div>
                                        </div>
                                    </li>';
        }
        return array(
            'html_exteno' => $html,
            'html_exteno2' => $html,
        );
    }


    /*
    public function carga_lista_rce_externo_ap($data_controller) {
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $data_controller["COD_EMPRESA"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #rut del usuario
                                array( 
                                    'name'      =>  ':V_USR_SESSION',
                                    'value'     =>  $data_controller["usr_session"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #no me acuerdo
                                array( 
                                    'name'      =>  ':V_OPCION', 
                                    'value'     =>  $data_controller["ind_opcion"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es la primera vez 
                                array( 
                                    'name'      =>  ':V_IND_FIRST',
                                    'value'     =>  $data_controller["ind_first"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo inicio
                                array( 
                                    'name'      =>  ':VAL_FECHA_INICIO',
                                    'value'     =>  $data_controller["data_inicio"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo final
                                array( 
                                    'name'      =>  ':VAL_FECHA_FINAL',
                                    'value'     =>  $data_controller["data_final"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es de rce - externo - gespab
                                array( 
                                    'name'      =>  ':VAL_IND_ORIGEN_SIS',
                                    'value'     =>  $data_controller["origen_sol"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #punto de entrega default 0|-1
                                array( 
                                    'name'      =>  ':VAL_IND_PUNTO_ENT',
                                    'value'     =>  $data_controller["pto_entrega"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #SI
                                array( 
                                    'name'      =>  ':VAL_TXT_TEMPLATE',
                                    'value'     =>  $data_controller["ind_template"]=='ssan_libro_biopsias_listaexterno1'?1:2,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #array principal
                                array( 
                                    'name'      =>  ':C_RESULT_LISTA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array puntos de entrega
                                array( 
                                    'name'      =>  ':C_DATA_PUNTOS_ENTREGA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array origen del sistema
                                array( 
                                    'name'      =>  ':C_DATA_ORIGEN_SIS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #status
                                array( 
                                    'name'      =>  ':C_RETURN_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        #lista filtrada por | punto de entrega | origen solicitud
        #llamada desde
        $result = $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_LISTA_AP_EXTERNO_RCE',$param);
        $this->db->trans_complete();
        return [
            'html_externo'  =>  $data_controller["ind_template"] == 'ssan_libro_biopsias_listaexterno1' || $data_controller["ind_template"] == 'ssan_libro_biopsias_listaxusuarios'
                ?   $this->html_externo_rce(array("data_controller"=>$data_controller,"data"=>$result))
                :   $this->LI_RESULTADOS_ANATOMIA($result[":C_RESULT_LISTA"],$data_controller["num_fase"]),
            'return_bd'     =>  $result,
            'userdata'      =>  $this->session->userdata,
            'ind_opcion'    =>  $data_controller["ind_opcion"], 
            'ind_template'  =>  $data_controller["ind_template"],
            'date_inicio'   =>  $data_controller["data_inicio"],
            'date_final'    =>  $data_controller["data_final"],
        ];
    }
    */
    







    public function load_info_ap($data_controller){
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_TOKEN',
                                    'value'     =>  $data_controller['token'],
                                    'length'    =>  100,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':C_MAIN_AP',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':P_ANATOMIA_PATOLOGICA_MUESTRAS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':P_AP_MUESTRAS_CITOLOGIA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_CUSTODIA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_TRASPORTE',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_RECEPCION',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_TERMINOINFO',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_TERMINOINFO_CITO',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),

                                array( 
                                    'name'      =>  ':C_TECNICASAPLICADAS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),

                                array( 
                                    'name'      =>  ':C_NOTIFICACANCER',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_INFOPABELLON',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_RCECLINICO',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_LOGS',
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
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_INFO_ANATOMIA',$param);
        $this->db->trans_complete();
        return array(
            'html_out'                          =>  '',
            'return_bd'                         =>  $result,
        );
    }
     
    public function carga_lista_rotulos_x_user($data_controller){
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $data_controller["COD_EMPRESA"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #rut del usuario
                                array( 
                                    'name'      =>  ':V_USR_SESSION',
                                    'value'     =>  $data_controller["usr_session"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #no me acuerdo
                                array( 
                                    'name'      =>  ':V_OPCION', 
                                    'value'     =>  $data_controller["ind_opcion"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es la primera vez 
                                array( 
                                    'name'      =>  ':V_IND_FIRST',
                                    'value'     =>  $data_controller["ind_first"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo inicio
                                array( 
                                    'name'      =>  ':VAL_FECHA_INICIO',
                                    'value'     =>  $data_controller["data_inicio"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo final
                                array( 
                                    'name'      =>  ':VAL_FECHA_FINAL',
                                    'value'     =>  $data_controller["data_final"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es de rce - externo - gespab
                                array( 
                                    'name'      =>  ':VAL_IND_ORIGEN_SIS',
                                    'value'     =>  0,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #punto de entrega default 0|-1
                                array( 
                                    'name'      =>  ':VAL_IND_PUNTO_ENT',
                                    'value'     =>  0,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #SI
                                array( 
                                    'name'      =>  ':VAL_TXT_TEMPLATE',
                                    'value'     =>  2,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #array principal
                                array( 
                                    'name'      =>  ':C_RESULT_LISTA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array puntos de entrega
                                array( 
                                    'name'      =>  ':C_DATA_PUNTOS_ENTREGA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array origen del sistema
                                array( 
                                    'name'      =>  ':C_DATA_ORIGEN_SIS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #status
                                array( 
                                    'name'      =>  ':C_RETURN_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        
        #var_dump(print_r($param));
        #lista filtrada por | punto de entrega | origen solicitud
        #llamada desde
        #$result                                =   [];
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_LISTA_AP_USERXROTULO_NEW',$param);
        $this->db->trans_complete();
        return array(
            'html_externo'                      =>  $this->html_externo_rce(array("data_controller"=>$data_controller,"data"=>$result)),
            'return_bd'                         =>  $result,
            'userdata'                          =>  $this->session->userdata,
            'date_inicio'                       =>  $data_controller["data_inicio"],
            'date_final'                        =>  $data_controller["data_final"],
            'ind_opcion'                        =>  $data_controller["ind_opcion"], 
            'ind_template'                      =>  $data_controller["ind_template"]
        );
    }
    
    public function carga_lista_rotulos_x_user_update($data_controller) {
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $data_controller["COD_EMPRESA"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #rut del usuario
                                array( 
                                    'name'      =>  ':V_USR_SESSION',
                                    'value'     =>  $data_controller["usr_session"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #no me acuerdo
                                array( 
                                    'name'      =>  ':V_OPCION', 
                                    'value'     =>  $data_controller["ind_opcion"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es la primera vez 
                                array( 
                                    'name'      =>  ':V_IND_FIRST',
                                    'value'     =>  $data_controller["ind_first"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo inicio
                                array( 
                                    'name'      =>  ':VAL_FECHA_INICIO',
                                    'value'     =>  $data_controller["data_inicio"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo final
                                array( 
                                    'name'      =>  ':VAL_FECHA_FINAL',
                                    'value'     =>  $data_controller["data_final"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es de rce - externo - gespab
                                array( 
                                    'name'      =>  ':VAL_IND_ORIGEN_SIS',
                                    'value'     =>  0,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #punto de entrega default 0|-1
                                array( 
                                    'name'      =>  ':VAL_IND_PUNTO_ENT',
                                    'value'     =>  0,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #SI
                                array( 
                                    'name'      =>  ':VAL_TXT_TEMPLATE',
                                    'value'     =>  2,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #array principal
                                array( 
                                    'name'      =>  ':C_RESULT_LISTA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array puntos de entrega
                                array( 
                                    'name'      =>  ':C_DATA_PUNTOS_ENTREGA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array origen del sistema
                                array( 
                                    'name'      =>  ':C_DATA_ORIGEN_SIS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #status
                                array( 
                                    'name'      =>  ':C_RETURN_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        #var_dump(print_r($param));
        #lista filtrada por | punto de entrega | origen solicitud
        #llamada desde
        #$result                                =   [];
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_LISTA_AP_USERXROTULO',$param);
        $this->db->trans_complete();
        return array(
            'html_externo'                      =>  $this->html_externo_rce(array("data_controller"=>$data_controller,"data"=>$result)),
            'return_bd'                         =>  $result,
            'date_inicio'                       =>  $data_controller["data_inicio"],
            'date_final'                        =>  $data_controller["data_final"],
            'ind_opcion'                        =>  $data_controller["ind_opcion"], 
            'ind_template'                      =>  $data_controller["ind_template"],
            #'param'                            =>  $param,
        );
    }
    
   

    public function main_form_anatomiapatologica($DATA) {
        $this->db->trans_start();
        // Parámetros de entrada
        $V_COD_EMPRESA = $DATA["COD_EMPRESA"];
        $V_CALL_FASE = isset($DATA['CALL_FASE']) ? $DATA['CALL_FASE'] : -1;
        $V_IND_SISTEMA = $DATA["V_IND_SISTEMA"];
        $V_IND_GESPAB = $DATA["IND_GESPAB"];
        $V_ZONA_PAB = $DATA["ZONA_PAB"];
        $V_IND_ADMISION = $DATA["IND_ADMISION"];
        $V_PA_ID_PROCARCH = $DATA["PA_ID_PROCARCH"];
        $VAL_ID_SERDEP = isset($DATA['ID_SERDEP']) ? $DATA['ID_SERDEP'] : -1;
    
        $results = array(
            'C_DATA_ROTULADO' => null,
            'C_DATA_ROTULADO_SUB' => null,
            'C_AUTOCOMPLETE_MUESTRAS' => null,
            'C_GETDATAACTIVE' => null,
            'C_RETURN_ESTADOS' => null,
            'P_ANATOMIA_PATOLOGICA_MAIN' => null,
            'P_ANATOMIA_PATOLOGICA_MUESTRAS' => null,
            'P_AP_MUESTRAS_CITOLOGIA' => null,
            'P_LOGS' => null
        );
    
        // Primera consulta para C_DATA_ROTULADO
        if ($V_IND_GESPAB == '1') {
            $sql = "SELECT 
                        P.ID_ROTULADO, 
                        P.COD_EMPRESA, 
                        P.TXT_OBSERVACION, 
                        P.IND_ESTADO, 
                        P.IND_GESPAB, 
                        P.IND_ZONA_GESPAB
                    FROM 
                        ADMIN.PB_INFOROTULADO P
                    WHERE
                        P.COD_EMPRESA = ?
                        AND P.IND_ESTADO = 1
                        AND P.IND_GESPAB = 1
                        AND P.IND_ZONA_GESPAB = ?";
            $query = $this->db->query($sql, array($V_COD_EMPRESA, $V_ZONA_PAB));
            $results['C_DATA_ROTULADO'] = $query->result_array();

        } else {

            if (in_array($V_PA_ID_PROCARCH, array('65', '63'))) {

                $sql = "SELECT COUNT(*) AS V_COUN_ROTULADO FROM ADMIN.PB_INFOROTULADO P WHERE P.COD_EMPRESA = ? AND P.IND_ESTADO = 1 AND P.ID_SERDEP = ?";
                $query = $this->db->query($sql, array($V_COD_EMPRESA, $VAL_ID_SERDEP));
                $V_COUN_ROTULADO = $query->row()->V_COUN_ROTULADO;
    
                if ($V_COUN_ROTULADO == 0) {
                    $sql = "SELECT NOM_SERVIC FROM ADMIN.GG_TSERVICIO WHERE ID_SERDEP = ?";
                    $query = $this->db->query($sql, array($VAL_ID_SERDEP));
                    $V_TXT_TOMA_NUESTRA = 'TOMA MUESTRA ' . $query->row()->NOM_SERVIC;
    
                    $sql = "
                        INSERT INTO ADMIN.PB_INFOROTULADO (COD_EMPRESA, TXT_OBSERVACION, IND_ESTADO, ID_SERDEP, IND_GESPAB) 
                        VALUES (?, ?, 1, ?, 0)";
                    $this->db->query($sql, array($V_COD_EMPRESA, $V_TXT_TOMA_NUESTRA, $VAL_ID_SERDEP));
    
                    $results['C_DATA_ROTULADO'] = array(array(
                        'ID_ROTULADO' => $this->db->insert_id(),
                        'COD_EMPRESA' => $V_COD_EMPRESA,
                        'TXT_OBSERVACION' => $V_TXT_TOMA_NUESTRA,
                        'IND_ESTADO' => 1,
                        'IND_GESPAB' => '',
                        'IND_ZONA_GESPAB' => '',
                        'ID_SERDEP' => $VAL_ID_SERDEP
                    ));
                } else {

                    $sql = "SELECT 
                                P.ID_ROTULADO, 
                                P.COD_EMPRESA, 
                                P.TXT_OBSERVACION, 
                                P.IND_ESTADO, 
                                P.IND_GESPAB, 
                                P.IND_ZONA_GESPAB,
                                P.ID_SERDEP
                            FROM 
                                ADMIN.PB_INFOROTULADO P
                            WHERE
                                P.ID_SERDEP = ? 
                                AND P.COD_EMPRESA = ?";
                        $query = $this->db->query($sql, array($VAL_ID_SERDEP, $V_COD_EMPRESA));
                        $results['C_DATA_ROTULADO'] = $query->result_array();
    
                    $sql = "SELECT 
                                P.ID_ROTULADO_SUB, 
                                P.ID_ROTULADO, 
                                P.COD_EMPRESA, 
                                P.TXT_OBSERVACION, 
                                P.IND_ESTADO, 
                                P.DATE_CREA, 
                                P.ID_UID, 
                                P.DATE_AUDITA, 
                                P.ID_UID_AUDITA
                            FROM 
                                ADMIN.PB_INFOROTULADO_SUB P
                            JOIN ADMIN.PB_INFOROTULADO S ON P.ID_ROTULADO = S.ID_ROTULADO
                            WHERE
                                S.ID_SERDEP = ? 
                                AND P.IND_ESTADO = 1";
                        $query = $this->db->query($sql, array($VAL_ID_SERDEP));
                        $results['C_DATA_ROTULADO_SUB'] = $query->result_array();
                }
            } else {
                $sql = "SELECT 
                            P.ID_ROTULADO, 
                            P.COD_EMPRESA, 
                            P.TXT_OBSERVACION, 
                            P.IND_ESTADO, 
                            P.IND_GESPAB, 
                            P.IND_ZONA_GESPAB,
                            P.ID_SERDEP
                        FROM 
                            ADMIN.PB_INFOROTULADO P
                        WHERE
                            P.COD_EMPRESA = ?
                            AND P.IND_ESTADO = 1
                            AND P.IND_GESPAB = 0";
                    $query = $this->db->query($sql, array($V_COD_EMPRESA));
                    $results['C_DATA_ROTULADO'] = $query->result_array();
            }
    
            $results['P_LOGS'] = array(array(
                'ID_SERDEP' => $VAL_ID_SERDEP,
                'V_PA_ID_PROCARCH' => $V_PA_ID_PROCARCH,
                'V_COUN_ROTULADO' => isset($V_COUN_ROTULADO) ? $V_COUN_ROTULADO : null,
                'V_TXT_TOMA_NUESTRA' => isset($V_TXT_TOMA_NUESTRA) ? $V_TXT_TOMA_NUESTRA : null
            ));
    
            if ($V_IND_ADMISION == '0' || $V_IND_ADMISION == null || $V_IND_ADMISION == '') {
                $V_ID_SOLICITUD_HISTO = '-1';
            } else {
                $sql = "SELECT F_PATOLOGICOXAMISION(?) AS V_ID_SOLICITUD_HISTO";
                $query = $this->db->query($sql, array($V_IND_ADMISION));
                $V_ID_SOLICITUD_HISTO = $query->row()->V_ID_SOLICITUD_HISTO;
            }
    


        if ($V_ID_SOLICITUD_HISTO != '-1') {
                $sql = "SELECT 
                        -- Aquí irían todas las columnas que necesitas obtener
                        P.ID_SOLICITUD_HISTO,
                        P.TXT_DIAGNOSTICO,
                        TO_CHAR(SYSDATE,'DD-MM-YYYY hh24:mi') AS FEC_EMISION,
                        TO_CHAR(P.FEC_USRCREA, 'DD-MM-YYYY hh24:mi') AS FECHA_SOLICITUD,
                        TO_CHAR(P.DATE_INICIOREGISTRO,'DD-MM-YYYY hh24:mi') AS FECHA_TOMA_MUESTRA,
                        -- Añadir el resto de columnas
                    FROM  
                        ADMIN.GG_TGPACTE L,
                        ADMIN.GG_TPROFESIONAL G,
                        ADMIN.PB_SOLICITUD_HISTO P,
                        ADMIN.PB_INFOROTULADO R
                    WHERE
                        P.ID_SOLICITUD_HISTO = ?
                        AND P.ID_ROTULADO = R.ID_ROTULADO
                        AND P.NUM_FICHAE = L.NUM_FICHAE
                        AND P.COD_RUTPRO = G.COD_RUTPRO
                        AND P.IND_ESTADO = 1
                    ORDER BY 
                        P.DATE_INICIOREGISTRO";
                $query = $this->db->query($sql, array($V_ID_SOLICITUD_HISTO));
                $results['P_ANATOMIA_PATOLOGICA_MAIN'] = $query->result_array();
    
                $sql = "SELECT 
                            '0' AS TOTAL_MUESTRAS,
                            CASE V_COD_EMPRESA
                                WHEN '100' THEN 'H.MAURICIO HEYERMANN T.ANGOL'
                                WHEN '106' THEN 'SAN JOSE DE VICTORIA' 
                                WHEN '029' THEN 'SERVICIO DE SALUD ARAUCANIA NORTE'
                                WHEN '1000' THEN 'HOSPITAL MILITAR'
                                ELSE 'SERVICIO DE SALUD ARAUCANIA NORTE'
                            END AS TXT_HOSPITAL_ETI,
                            M.IND_ESTADO_CU,
                            M.ID_NUM_CARGA,
                            NULL AS ID_TABLA,
                            M.IND_ESTADO AS ESTADO,
                            M.ID_NMUESTRA AS ID_NMUESTRA,
                            M.N_MUESTRA AS N_MUESTRA,
                            UPPER(M.TXT_MUESTRA) AS TXT_MUESTRA,
                            M.IND_ESTADO_REG AS IND_ESTADO_REG,
                            M.IND_TIPOMUESTRA AS IND_TIPOMUESTRA, 
                            CASE
                                WHEN M.NUM_CASSETTE IS NULL THEN 0 ELSE M.NUM_CASSETTE
                            END AS NUM_CASSETTE,
                            M.ID_CASETE AS ID_CASETE,
                            CASE
                                WHEN M.NUM_ML IS NULL THEN 0 ELSE M.NUM_ML
                            END AS NUM_ML,
                            DECODE(M.IND_ETIQUETA, '1', 'PEQUEÑO', '2', 'MEDIANO', 'NO INFORMADO') AS TXT_ETIQUETA,
                            CASE
                                WHEN M.IND_ETIQUETA IS NULL THEN 2 ELSE M.IND_ETIQUETA
                            END AS IND_ETIQUETA
                        FROM 
                            ADMIN.PB_HISTO_NMUESTRAS M
                        WHERE
                            M.ID_SOLICITUD_HISTO = ?
                            AND M.IND_TIPOMUESTRA = 1
                            AND M.IND_ESTADO = 1
                        ORDER BY 
                            M.N_MUESTRA";
                    $query = $this->db->query($sql, array($V_ID_SOLICITUD_HISTO));
                    $results['P_ANATOMIA_PATOLOGICA_MUESTRAS'] = $query->result_array();
    
                $sql = "SELECT 
                            '0' AS TOTAL_MUESTRAS,
                            CASE V_COD_EMPRESA
                                WHEN '100' THEN 'H.MAURICIO HEYERMANN T.ANGOL'
                                WHEN '106' THEN 'SAN JOSE DE VICTORIA' 
                                WHEN '029' THEN 'SERVICIO DE SALUD ARAUCANIA NORTE'
                                WHEN '1000' THEN 'HOSPITAL MILITAR'
                                ELSE 'SERVICIO DE SALUD ARAUCANIA NORTE'
                            END AS TXT_HOSPITAL_ETI,
                            M.IND_ESTADO_CU,
                            M.ID_NUM_CARGA,
                            NULL AS ID_TABLA,
                            M.IND_ESTADO AS ESTADO,
                            M.ID_NMUESTRA AS ID_NMUESTRA,
                            M.N_MUESTRA AS N_MUESTRA,
                            UPPER(M.TXT_MUESTRA) AS TXT_MUESTRA,
                            M.IND_ESTADO_REG AS IND_ESTADO_REG,
                            M.IND_TIPOMUESTRA AS IND_TIPOMUESTRA,
                            CASE
                                WHEN M.NUM_CASSETTE IS NULL THEN 0 ELSE M.NUM_CASSETTE
                            END AS NUM_CASSETTE,
                            CASE
                                WHEN M.NUM_ML IS NULL THEN 0 ELSE M.NUM_ML
                            END AS NUM_ML,
                            DECODE(M.IND_ETIQUETA, '1', 'PEQUEÑO', '2', 'MEDIANO', 'NO INFORMADO') AS TXT_ETIQUETA,
                            CASE
                                WHEN M.IND_ETIQUETA IS NULL THEN 2 ELSE M.IND_ETIQUETA
                            END AS IND_ETIQUETA
                        FROM 
                            ADMIN.PB_HISTO_NMUESTRAS M
                        WHERE
                            M.ID_SOLICITUD_HISTO = ?
                            AND M.IND_TIPOMUESTRA = 2
                            AND M.IND_ESTADO = 1
                        ORDER BY 
                            M.N_MUESTRA";
                    $query = $this->db->query($sql, array($V_ID_SOLICITUD_HISTO));
                    $results['P_AP_MUESTRAS_CITOLOGIA'] = $query->result_array();
            }
        }
    
        $sql = "SELECT 
                    P.ID_AUTOCOMPLETADO, 
                    P.TXT_CHARACTER, 
                    P.TXT_REALNAME,
                    P.IND_ESTADO 
                FROM 
                    ADMIN.PB_NMUESTRA_AUTOCOMPLETADO P 
                WHERE 
                    P.IND_ESTADO = 1 
                ORDER BY 
                    P.ID_AUTOCOMPLETADO";
            $query = $this->db->query($sql);
            $results['C_AUTOCOMPLETE_MUESTRAS'] = $query->result_array();

        $this->db->trans_complete();
        return array(
            'STATUS' => $this->db->trans_status(),
            'ID_SERDEP_MODEL' => $ID_SERDEP,
            'DATA_ROTULADO' => empty($results['C_DATA_ROTULADO']) ? null : $results['C_DATA_ROTULADO'],
            'DATA_AUTOCOMPLETE' => empty($results['C_AUTOCOMPLETE_MUESTRAS']) ? null : $results['C_AUTOCOMPLETE_MUESTRAS'],
            'C_RETURN_ESTADOS' => empty($results['C_RETURN_ESTADOS']) ? null : $results['C_RETURN_ESTADOS'],
            'P_ANATOMIA_PATOLOGICA_MAIN' => empty($results['P_ANATOMIA_PATOLOGICA_MAIN']) ? null : $results['P_ANATOMIA_PATOLOGICA_MAIN'],
            'P_ANATOMIA_PATOLOGICA_MUESTRAS' => empty($results['P_ANATOMIA_PATOLOGICA_MUESTRAS']) ? null : $results['P_ANATOMIA_PATOLOGICA_MUESTRAS'],
            'P_AP_MUESTRAS_CITOLOGIA' => empty($results['P_AP_MUESTRAS_CITOLOGIA']) ? null : $results['P_AP_MUESTRAS_CITOLOGIA'],
            'C_DATA_ROTULADO_SUB' => empty($results['C_DATA_ROTULADO_SUB']) ? null : $results['C_DATA_ROTULADO_SUB'],
            'P_LOGS' => empty($results['P_LOGS']) ? null : $results['P_LOGS'],
            'PA_ID_PROCARCH_MODEL' => $DATA["PA_ID_PROCARCH"]
        );
    }
    

    
    public function get_indrotulado_forgespab($DATA){
        return $this->db->query("SELECT 
                                    P.ID_ROTULADO, 
                                    P.COD_EMPRESA, 
                                    P.TXT_OBSERVACION, 
                                    P.IND_ESTADO, 
                                    P.IND_GESPAB, 
                                    P.IND_ZONA_GESPAB
                                FROM 
                                    PABELLON.PB_INFOROTULADO P
                                WHERE
                                        P.COD_EMPRESA IN (".$DATA['COD_EMPRESA'].")
                                    AND 
                                        P.IND_ESTADO IN (1)
                                    AND
                                        P.IND_GESPAB IN (1)
                                    AND
                                        P.IND_ZONA_GESPAB IN ('".$DATA['IND_ZONAGESPAB']."')
                                ")->result_array();
    }
    
    public function get_indrotulado_general($DATA){
        return $this->db->query("
            SELECT 
                P.ID_ROTULADO, 
                P.COD_EMPRESA, 
                P.TXT_OBSERVACION, 
                P.IND_ESTADO, 
                P.IND_GESPAB, 
                P.IND_ZONA_GESPAB
            FROM 
                PABELLON.PB_INFOROTULADO P
            WHERE
                P.COD_EMPRESA IN (".$DATA['COD_EMPRESA'].")
                AND 
                P.IND_ESTADO IN (1)
                AND
                P.IND_GESPAB IN (0)
            ")->result_array();
    }
    
    
    
    public function sqlValidaClave_old($clave){
        $clave	        =   strtolower($clave);
        $SQL            =   "SELECT 
                                ID_UID,
                                USERNAME,
                                NAME,
                                MIDDLE_NAME,
                                LAST_NAME 
                            FROM 
                                $this->ownGu.FE_USERS 
                            WHERE 
                                TO_CHAR(TX_INTRANETSSAN_CLAVEUNICA) IN ('$clave')";
        return $this->db->query($SQL)->row();
    }



    public function sqlValidaClave_doble($arr_password){
        #$this->dbSession = $this->load->database('session', true); 
        $clave1 = strtolower($arr_password[0]["pass1"]);
        $SQL1 = " SELECT 
                    ID_UID,
                    USERNAME,
                    NAME,
                    MIDDLE_NAME,
                    LAST_NAME 
                FROM 
                    $this->own.FE_USERS 
                WHERE 
                TX_INTRANETSSAN_CLAVEUNICA IN ('$clave1') ";
        $clave2 =   strtolower($arr_password[0]["pass2"]);
        $SQL2 = "SELECT 
                    ID_UID,
                    USERNAME,
                    NAME,
                    MIDDLE_NAME,
                    LAST_NAME 
                FROM 
                    $this->own.FE_USERS 
                WHERE 
                TX_INTRANETSSAN_CLAVEUNICA IN ('$clave2') ";
        return array(
            'user_1' => $this->db->query($SQL1)->row(),
            'user_2' => $this->db->query($SQL2)->row(),
        );
    }

    public function validaClave($clave){
        #$this->dbSession = $this->load->database('session', true); 
        $sql = "SELECT
                    ID_UID,
                    USERNAME,
                    NAME,
                    MIDDLE_NAME,
                    LAST_NAME,
                    TELEPHONE,
                    EMAIL
                FROM 
                    ADMIN.FE_USERS
                WHERE 
                    TX_INTRANETSSAN_CLAVEUNICA = ? AND DISABLE = 0";
        $query = $this->db->query($sql,array($clave));
        return $query->result_array();
    }

   
    ######################################
    #LISTA DEL USUARIO QUE ENVIA SOLCITIUD
    #DE TODOS LADOS
    ######################################
    public function RESULTADOS_ANATOMIA($ARRAY){
        $HTML                               =   '';
        $txt_estado                         =   '';
        if(count($ARRAY)>0){
           foreach ($ARRAY as $i => $row){
                #$row['ID_SERVICIO'];
                #$row['ID_SOLICITUD'];
                $HTML .= '<tr id = "DATA_'.$row['ID_SOLICITUD'].'"  data-paciente = "'.htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8').'">
                            <td style="vertical-align: initial;text-align: center;height: 40px"><b>'.($i+1).'</b></td>
                            <td style="vertical-align: initial;">'.$row['NOMBRE_COMPLETO'].'<br>'.$row['RUTPACIENTE'].'</i></td>
                            <td style="vertical-align: initial;">'.$row['PROFESIONAL'].'<br><i>'.$row['RUT_PROFESIOAL'].'</i></td>
                            <td>
                                <div class="grid_vista_resumen">
                                    <div class="grid_vista_resumen1"> '.$row['TIPO_DE_BIOPSIA'].'</div>
                                    <div class="grid_vista_resumen2"> '.$row['TXT_PROCEDENCIA'].'</div>
                                    <div class="grid_vista_resumen3"> '.$row['NOMBRE_SERVICIO'].'</div>
                                </div>
                            </td>
                            <td style="text-align: center;">';
                        #etiqueta estado
                        if ($row['ID_HISTO_ESTADO'] == 5){
                    $txt_estado = '<span class="label label-danger"><i class="fa fa-times" aria-hidden="true"></i>'.$row['TXT_HISTO_ESTADO'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                } else  if ($row['ID_HISTO_ESTADO'] == 4){
                    $txt_estado = '<span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i>'.$row['TXT_HISTO_ESTADO'].'</span>';
                } else {
                    $txt_estado = '<span class="label label-default">'.$row['TXT_HISTO_ESTADO'].'</span>';
                }
                $HTML .= $txt_estado.'</td>
                                        <td style="text-align: center;">';
                                        if( $row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2 || $row['ID_HISTO_ESTADO'] == 3 ){
                                            $HTML   .= '<a href="javascript:js_cambio_fecha('.$row['ID_SOLICITUD'].')">'.$row['FECHA_TOMA_MUESTRA'].'</a>';
                                        } else {
                                            $HTML .= $row['FECHA_TOMA_MUESTRA'];
                                        }
                                        $HTML .='  
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-fill" id="pdf_anatomia_patologica" onclick="GET_PDF_ANATOMIA_PANEL('.$row['ID_SOLICITUD'].')">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                        <td>';
                                $HTML .= '<div class="dropdown">
                                            <button 
                                                class="btn btn-primary dropdown-toggle" 
                                                type="button" 
                                                id="dropdownMenuButton_'.$row['ID_SOLICITUD'].'" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                                <i class="fa fa-folder" aria-hidden="true"></i> 
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_'.$row['ID_SOLICITUD'].'">';
                                            if( $row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2 || $row['ID_HISTO_ESTADO'] == 3 ){
                                                #EN TRASPORTE - #CUSTODIA
                                                $HTML .= '<li><a class="dropdown-item" href="javascript:btn_delete_ap_externo('.$row['ID_SOLICITUD'].')""><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Eliminar Muestra</a></li>';
                                            }   else if($row['ID_HISTO_ESTADO'] == 5){     
                                                #RECHAZADA     
                                                $HTML .= '<li><a class="dropdown-item" href="javascript:local_pdf_rechazomuestra('.$row['ID_SOLICITUD'].')""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Ver rechazo</a></li>';
                                            } else if($row['ID_HISTO_ESTADO'] == 4){    
                                                #YA RECEPCIONADA 
                                                $HTML .= '<li><a class="dropdown-item" href="javascript:pdf_recepcion_ok('.$row['ID_SOLICITUD'].')""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Pdf recepci&oacute;n</a></li>';
                                                #YA PAGADAS
                                                if ($row['IND_VISUALIZACION'] == "1") {
                                                    $HTML .= '<li><a class="dropdown-item" href="javascript:js_pdf_microscopica('.$row['ID_SOLICITUD'].')""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Informe final</a></li>';
                                                }
                                            }
                                    $HTML .= '</ul>
                                    </div>';        
                                    /*                                  
                                    #EN TRASPORTE - #CUSTODIA
                                    if( $row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2 || $row['ID_HISTO_ESTADO'] == 3 ){
                                        $HTML .= '<button type="button" class="btn btn-danger btn-fill" id="pdf_anatomia_patologica" onclick="btn_delete_ap_externo('.$row['ID_SOLICITUD'].')">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </button>';

                                    #RECHAZADA     
                                    } else if($row['ID_HISTO_ESTADO'] == 5){     
                                        $HTML       .= '<button type="button" class="btn btn-danger btn-fill" id="pdf_anatomia_patologica" onclick="local_pdf_rechazomuestra('.$row['ID_SOLICITUD'].')">
                                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                        </button>';
                                    #YA RECEPCIONADA    
                                    } else if($row['ID_HISTO_ESTADO'] == 4){   
                                        $HTML .= '<button type="button" class="btn btn-success btn-fill" id="pdf_anatomia_patologica" onclick="pdf_recepcion_ok('.$row['ID_SOLICITUD'].')">
                                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                </button>';
                                                if ($row['IND_VISUALIZACION'] == "1") {
                                                    $HTML .='<button type="button" class="btn btn-info btn-fill" id="pdf_anatomia_patologica" onclick="js_pdf_microscopica('.$row['ID_SOLICITUD'].')" style="margin-top: 5px;">
                                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                        </button>';
                                                        }
                                    } else {
                                        $HTML .= '-';
                                    }
                                    */                                  
                $HTML .= '</td>
                        </tr>
                        ';
            }
        } else {
                $HTML  = '<tr style="text-align: center;">
                            <td colspan="11" style="text-align: center;height: 40px"><b>SIN RESULTADOS</b></td>
                        </tr>';
        }
        $HTML2          = '<tr style="text-align: center;">
                            <td colspan="11" style="text-align: center;height: 40px"><b>SIN RESULTADOS</b></td>
                        </tr>';
        return array(
            'NUEVAS_SOLICITUDES'    =>  $HTML,
            'VISTA_SOLICITUDES'     =>  $HTML2,
        );
    }
    
    public function LOAD_INFOXMUESTRAANATOMIACA($DATA){
        $result = [];
        $V_ID_HISTO = $this->db->escape($DATA['ARR_DATA']);
        $V_COD_EMPRESA = $this->db->escape($DATA['COD_EMPRESA']);
        $P_ANATOMIA_PATOLOGICA_MAIN = [];
        $multi_query = $this->db->conn_id->multi_query("CALL ADMIN.CONSULTA_UNICA_ANATOMIA($V_ID_HISTO, $V_COD_EMPRESA)");
        if ($multi_query) {
            do {
                if ($result = $this->db->conn_id->store_result()) {
                    $P_ANATOMIA_PATOLOGICA_MAIN = $result->fetch_all(MYSQLI_ASSOC);
                    $result->free();
                }
            } while ($this->db->conn_id->more_results() && $this->db->conn_id->next_result());
        } else {
            $error = $this->db->conn_id->error;
        }
        $this->db->reconnect();

        $P_ANATOMIA_PATOLOGICA_MUESTRAS = [];
        $multi_query = $this->db->conn_id->multi_query("CALL ADMIN.CONSULTA_MUESTRAS_HISTO($V_COD_EMPRESA,$V_ID_HISTO)");
        if ($multi_query) {
            do {
                if ($result = $this->db->conn_id->store_result()) {
                    $P_ANATOMIA_PATOLOGICA_MUESTRAS = $result->fetch_all(MYSQLI_ASSOC);
                    $result->free();
                }
            } while ($this->db->conn_id->more_results() && $this->db->conn_id->next_result());
        } else {
            $error = $this->db->conn_id->error;
        }
        $this->db->reconnect();
        $P_AP_MUESTRAS_CITOLOGIA = [];
        $multi_query = $this->db->conn_id->multi_query("CALL ADMIN.CONSULTA_MUESTRAS_CITO($V_COD_EMPRESA,$V_ID_HISTO)");
        if ($multi_query) {
        do {
        if ($result = $this->db->conn_id->store_result()) {
            $P_AP_MUESTRAS_CITOLOGIA = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
        }
        } while ($this->db->conn_id->more_results() && $this->db->conn_id->next_result());
        } else {
            $error = $this->db->conn_id->error;
        }
        $this->db->reconnect();
        $sql_adversos = "SELECT 
                            P.ID_NMUESTRA,
                            P.ID_ANTECEDENTES_HISTO,  
                            P.ID_ANTECEDENTES_HISTO AS ID_SOLICITUD_HISTO, 
                            P.ID_LINETIMEHISTO, 
                            P.ID_NUM_CARGA, 
                            P.ID_SOLICITUD_HISTO, 
                            P.ID_MOTIVO_DESAC, 
                            P.TXT_EVENTO_OBSERVACION,
                            M.DESCRIPCION
                        FROM 
                            ADMIN.PB_ANTECEDENTES_HISTO P,
                            ADMIN.MOTIVOS_DESACTIVAR_M M
                        WHERE
                            P.ID_SOLICITUD_HISTO IN ($V_ID_HISTO) 
                        AND 
                            P.ID_MOTIVO_DESAC =  M.ID_MOTIVO_DESAC 
                        AND
                            P.IND_ESTADO IN (1)";
        $query = $this->db->query($sql_adversos);
        $results[':P_INFO_LOG_ADVERSOS'] = $query->result_array();

        return [
            'STATUS' =>	true,
            'DATA' => $DATA,
            'P_STATUS' => empty($result[':P_STATUS'])?null:$result[':P_STATUS'],
            'P_ERROR' => empty($result[':P_ERROR'])?null:$result[':P_ERROR'],
            #'P_AP_INFORMACION_ADICIONAL' =>	empty($result[':P_AP_INFORMACION_ADICIONAL'])?null:$result[':P_AP_INFORMACION_ADICIONAL'],
            'P_ANATOMIA_PATOLOGICA_MAIN' =>	$P_ANATOMIA_PATOLOGICA_MAIN,
            'P_ANATOMIA_PATOLOGICA_MUESTRAS' =>	$P_ANATOMIA_PATOLOGICA_MUESTRAS,
            'P_AP_MUESTRAS_CITOLOGIA' => $P_AP_MUESTRAS_CITOLOGIA,
            'P_AP_INFORMACION_ADICIONAL' => [],
            'P_INFO_LOG_ADVERSOS' => empty($result[':P_INFO_LOG_ADVERSOS'])?null:$result[':P_INFO_LOG_ADVERSOS'],
            //'sql_adversos' => $sql_adversos
        ];
    }

    #############################################
    #FALTA LOGICA
    #IND_ESTADO = 1 | 0
    #ID_HISTO_ESTADO = 1 | NUEVA SOLICITUD | 2 = EN CUSTODIA | 3 = TRASPORTE | 4 = RECEPCIONADA 
    #############################################
    public function get_confirma_custodia($DATA) {
        $this->db->trans_start();
        $mivariable = true;
        $arr_histo_ok = [];
        if (count($DATA['ARRAY']) > 0) {
            foreach ($DATA['ARRAY'] as $i => $fila) {
                foreach ($fila as $x => $row) {
                    // NUMERO DE CARGA
                    $ID_CARGA_AP = $this->generate_unique_id($this->ownPab.'.PB_LINETIME_HISTO'); 
                    if (count($row["ARRAY_NMUESTRAS"]) > 0) {
                        foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus) {
                            // $ID_LINETIME_HISTO = $this->generate_unique_id($this->ownPab.'.PB_LINETIME_HISTO'); // No es necesario
                            $ID_ANATOMIA = $DATA["ID_ANATOMIA"];
                            $IND_CASETE = $mus['IND_CASETE'];
                            $ID_MUESTRA = $mus['ID_NMUESTRA'];
                            $arr_linea_tiempo = array(
                                // "ID_LINETIMEHISTO" => $ID_LINETIME_HISTO, // No es necesario
                                "ID_NUM_CARGA" => $ID_CARGA_AP,
                                "ID_SOLICITUD_HISTO" => $row["NUM_HISTO"],
                                "TXT_BACODE" => $mus['ID_NMUESTRA'],
                                "NUM_FASE" => 1, // EN CUSTODIA
                                "IND_CHECKED" => $mus['IN_CHECKED'],
                                "USR_CREA" => $DATA["SESSION"],
                                "FEC_CREA" => date('Y-m-d H:i:s'),
                                "IND_ESTADO" => 1,
                                "ID_UID" => $DATA["DATA_FIRMA"]->ID_UID,
                                "TXT_MUESTRA" => $mus['TXT_MUESTRA'] == '' ? 'NO INFORMADO' : $mus['TXT_MUESTRA'],
                            );
                            $arr_linea_tiempo[$IND_CASETE == 1 ? "ID_CASETE" : "ID_NMUESTRA"] = $ID_MUESTRA;
                            
                            $this->db->insert($this->ownPab . '.PB_LINETIME_HISTO', $arr_linea_tiempo);
                            $ID_LINETIME_HISTO = $this->db->insert_id(); // Obtener el ID autogenerado
        
                            // ACTUALIZA ESTADO DE LA MUESTRA CON EL ULTIMO LINETIME
                            $this->db->where($IND_CASETE == 1 ? 'ID_CASETE' : 'ID_NMUESTRA', $ID_MUESTRA);
                            $this->db->update($this->ownPab . '.PB_HISTO_NMUESTRAS', array(
                                "IND_ESTADO_CU" => $mus['IN_CHECKED'],
                                "ID_NUM_CARGA" => $ID_CARGA_AP,
                                "USR_AUDITA" => $DATA["SESSION"],
                                "DATE_AUDITA" => date('Y-m-d H:i:s')
                            ));
        
                            // ARRAY ANTECEDENTES ADVERSOS
                            if (isset($mus["ARR_EVENTOS_ADVERSOS"])) {
                                foreach ($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv) {
                                    $this->db->insert($this->ownPab . '.PB_ANTECEDENTES_HISTO', array(
                                        "ID_ANTECEDENTES_HISTO" => $this->generate_unique_id($this->ownPab.'.PB_ANTECEDENTES_HISTO'), // Función para generar IDs únicos en MySQL
                                        "ID_LINETIMEHISTO" => $ID_LINETIME_HISTO,
                                        "ID_NUM_CARGA" => $ID_CARGA_AP,
                                        "ID_SOLICITUD_HISTO" => $ID_ANATOMIA,
                                        "ID_NMUESTRA" => $ID_MUESTRA,
                                        "ID_MOTIVO_DESAC" => $adv["IND_MOTIVO"],
                                        "TXT_EVENTO_OBSERVACION" => $adv["TXT_OBSERVACION"],
                                        "IND_ESTADO" => 1
                                    ));
                                }
                            }
                        }
                    }
                    // ACTUALIZA EL ESTADO DE LA SOLICITUD PRINCIPAL
                    array_push($arr_histo_ok, $row["NUM_HISTO"]);
                    $this->db->where('ID_SOLICITUD_HISTO', $row["NUM_HISTO"]);
                    $this->db->update($this->ownPab . '.PB_SOLICITUD_HISTO', array(
                        "ID_HISTO_ESTADO" => 2,
                        "IND_ESTADO_MUESTRAS" => $row["NUM_OK_SAMPLES"],
                        "ID_NUM_CARGA" => $ID_CARGA_AP,
                        "LAST_USR_AUDITA" => $DATA["DATA_FIRMA"]->USERNAME,
                        "LAST_DATE_AUDITA" => date('Y-m-d H:i:s'),
                        "ID_UID_CUSTODIA" => $DATA["DATA_FIRMA"]->ID_UID,
                        "DATE_LAST_CUSTODIA" => date('Y-m-d H:i:s'),
                        "ID_UID" => $DATA["DATA_FIRMA"]->ID_UID,
                        "TXT_NAMEAUDITA" => $DATA["DATA_FIRMA"]->NAME . " " . $DATA["DATA_FIRMA"]->MIDDLE_NAME
                    ));
                }
            }
        }
        return array(
            'STATUS' => $mivariable,
            'HISTO_OK' => $arr_histo_ok,
            'STATUS_BD' => $this->db->trans_complete(),
        );
    }
    

    /*            
    #HOSPITAL ANGOL             –   RECIBE SOLICITUD DE:
        CSF ALEMANIA            -   303
        CSF HUEQUEN             -   301
        PIEDRA DE AGUILA        -   304
        CSF RENAICO             -   300 
        H COLLIPULLI            -   103
        H PUREN                 -   101
        CSF LOS SAUCES          -   102
        CSF LUMACO              -   105
    #HOSPITAL VICTORIA
        CSF VICTORIA            -   318
        H TRAGUIEN              -   104
        H LONQUIMAY             -   108
        H CURACAUTÍN            -   107
        CSF ERCILLA             –   302
    */
    #$_arr_establecimiento_referencia = $this->db->query(" SELECT P.COD_ESTABLREF FROM PABELLON.PB_RED_MAPA_AP P WHERE P.COD_EMPRESA IN ($v_cod_empresa)  AND P.IND_ESTADO IN (1) ")->result_array();
    #$_val_establecimiento_referencia = $_arr_establecimiento_referencia[0]["COD_ESTABLREF"];

    #SOLO TRASPORTE + DERIVACION POR CODIGO
    public function get_confirma_trasporte($DATA) {
        $this->db->trans_start();
        $mivariable = true;
        $arr_histo_ok = [];
        
        // DERIVACION ENTRE EMPRESAS
        $_val_establecimiento_referencia = '';
        if($DATA['COD_EMPRESA'] == '100' || $DATA['COD_EMPRESA'] == '106' || $DATA['COD_EMPRESA'] == '029' || $DATA['COD_EMPRESA'] == '800') {
            $_val_establecimiento_referencia = ''; 
        } else {
            $v_cod_empresa = $DATA['COD_EMPRESA'];
            if ($v_cod_empresa == '303' || $v_cod_empresa == '301' || $v_cod_empresa == '304' || $v_cod_empresa == '300' || 
                $v_cod_empresa == '103' || $v_cod_empresa == '101' || $v_cod_empresa == '102' || $v_cod_empresa == '105') {
                $_val_establecimiento_referencia = '100';
            }
            if ($v_cod_empresa == '318' || $v_cod_empresa == '104' || $v_cod_empresa == '108' || $v_cod_empresa == '107' || $v_cod_empresa == '302') {
                $_val_establecimiento_referencia = '106';
            }
        }
        
        if (count($DATA['ARRAY']) > 0) {
            foreach ($DATA['ARRAY'] as $i => $fila) {
                foreach ($fila as $x => $row) {
                    // NUMERO DE CARGA
                    // Ya no necesitamos generar manualmente $ID_CARGA_AP
                    // Este se generará automáticamente en MySQL con AUTO_INCREMENT
    
                    if (count($row["ARRAY_NMUESTRAS"]) > 0) {
                        foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus) {
                            // Ya no necesitamos generar manualmente $ID_LINETIME_HISTO
                            // Este se generará automáticamente en MySQL con AUTO_INCREMENT
                            
                            $ID_ANATOMIA = $DATA["ID_ANATOMIA"];
                            $IND_CASETE = $mus['IND_CASETE'];
                            $ID_MUESTRA = $mus['ID_NMUESTRA'];
                            
                            $arr_linea_tiempo = array(
                                // "ID_LINETIMEHISTO" => el ID se generará automáticamente,
                                "ID_NUM_CARGA" => $ID_CARGA_AP,
                                "ID_SOLICITUD_HISTO" => $row["NUM_HISTO"],
                                "TXT_BACODE" => $mus['ID_NMUESTRA'],
                                "NUM_FASE" => 2, // EN TRASPORTE
                                "IND_CHECKED" => $mus['IN_CHECKED'],
                                "USR_CREA" => $DATA["SESSION"],
                                "FEC_CREA" => date('Y-m-d H:i:s'),
                                "IND_ESTADO" => 1,
                                "ID_UID" => $DATA["DATA_FIRMA"]->ID_UID,
                                "TXT_MUESTRA" => $mus['TXT_MUESTRA'] == '' ? 'NO INFORMADO' : $mus['TXT_MUESTRA'],
                            );
                            
                            $arr_linea_tiempo[$IND_CASETE == 1 ? "ID_CASETE" : "ID_NMUESTRA"] = $ID_MUESTRA;
                            $this->db->insert($this->ownPab . '.PB_LINETIME_HISTO', $arr_linea_tiempo);
                            // CAMBIA ESTADO DE MUESTRAS
                            $this->db->where($IND_CASETE == 1 ? 'ID_CASETE' : 'ID_NMUESTRA', $ID_MUESTRA);
                            $this->db->update($this->ownPab . '.PB_HISTO_NMUESTRAS', array(
                                "IND_ESTADO_CU" => $mus['IN_CHECKED'],
                                "ID_NUM_CARGA" => $ID_CARGA_AP,
                                "USR_AUDITA" => $DATA["SESSION"],
                                "DATE_AUDITA" => date('Y-m-d H:i:s')
                            ));
                            if (isset($mus["ARR_EVENTOS_ADVERSOS"])) {
                                foreach ($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv) {
                                    $this->db->insert($this->ownPab . '.PB_ANTECEDENTES_HISTO', array(
                                        // "ID_ANTECEDENTES_HISTO" => el ID se generará automáticamente,
                                        "ID_LINETIMEHISTO" => $ID_LINETIME_HISTO,
                                        "ID_NUM_CARGA" => $ID_CARGA_AP,
                                        "ID_SOLICITUD_HISTO" => $ID_ANATOMIA,
                                        "ID_NMUESTRA" => $ID_MUESTRA,
                                        "ID_MOTIVO_DESAC" => $adv["IND_MOTIVO"],
                                        "TXT_EVENTO_OBSERVACION" => $adv["TXT_OBSERVACION"],
                                        "IND_ESTADO" => 1
                                    ));
                                }
                            }
                        }
                    }
                    array_push($arr_histo_ok, $row["NUM_HISTO"]);
                    $this->db->where('ID_SOLICITUD_HISTO', $row["NUM_HISTO"]);
                    $this->db->update($this->ownPab . '.PB_SOLICITUD_HISTO', array(
                        "ID_HISTO_ESTADO" => 3,
                        "DATE_TRASLADO" => date('Y-m-d H:i:s'),
                        "ID_UID_TRASLADO" => $DATA["DATA_FIRMA"]->ID_UID,
                        "ID_USER_TRASLADO" => $DATA["SESSION"],
                        "IND_ESTADO_MUESTRAS" => $row["NUM_OK_SAMPLES"],
                        "ID_NUM_CARGA" => $ID_CARGA_AP,
                        "LAST_USR_AUDITA" => $DATA["DATA_FIRMA"]->USERNAME,
                        "LAST_DATE_AUDITA" => date('Y-m-d H:i:s'),
                        "ID_UID" => $DATA["DATA_FIRMA"]->ID_UID,
                        "TXT_NAMEAUDITA" => $DATA["DATA_FIRMA"]->NAME . " " . $DATA["DATA_FIRMA"]->MIDDLE_NAME,
                        "COD_ESTABLREF" => $_val_establecimiento_referencia
                    ));
                }
            }
        }
        return array(
            'STATUS' => $mivariable,
            'HISTO_OK' => $arr_histo_ok,
            'STATUS_BD' => $this->db->trans_complete(),
        );
    }
    
    
    // Función para generar IDs únicos en MySQL
    private function generate_unique_id($table) {
        $this->db->select_max('ID_LINETIMEHISTO');
        $query = $this->db->get($table);
        $row = $query->row_array();
        return $row['id'] + 1;
    }

    #RECEPCION
    public function get_confirma_recepcion($DATA){
        $this->db->trans_start();
        $status =   true;
        $arr_histo_ok =   [];
        $arr_linea_tiempo =   [];
        $num_interno =   $DATA["n_interno"];
        $n_interno_2 =   $DATA["n_interno_2"];
        $cod_empresa =   $DATA["COD_EMPRESA"];
        $ID_ANATOMIA =   $DATA["ID_ANATOMIA"];
        $IND_TIPO_BIOPSIA =   $DATA["ind_tipo_biopsia"];
        #LOAD
        #BIOPSIA - CITOLOGIA
        if ($IND_TIPO_BIOPSIA == 4){
            $data_num_interno =   $this->db->query("SELECT P.NUM_INTERNO_AP FROM ADMIN.PB_SOLICITUD_HISTO P WHERE P.NUM_INTERNO_AP IN ($num_interno) AND P.COD_EMPRESA IN ($cod_empresa) AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) AND P.IND_TIPO_BIOPSIA IN (2,3,4)")->result_array();
            $data_num_citologia =   $this->db->query("SELECT P.NUM_CO_CITOLOGIA FROM ADMIN.PB_SOLICITUD_HISTO P WHERE P.NUM_CO_CITOLOGIA IN ($n_interno_2) AND P.COD_EMPRESA IN ($cod_empresa) AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) AND P.IND_TIPO_BIOPSIA IN (4,5)")->result_array();
            if(count($data_num_interno) > 0 || count($data_num_citologia) > 0){
                return array(
                    'STATUS' =>  false,
                    'TXT_ERROR' =>  'N&deg; meno notificaci&oacute;n ya existe',
                    'HISTO_OK' =>  null,
                    'STATUS_BD' =>  false,
                    'error_memo' =>  1,
                    'close_modal' =>  0,
                    'count_interno' =>  count($data_num_interno),
                    'count_cotologia' =>  count($data_num_citologia),
                );
            }
        } else {
            if ($IND_TIPO_BIOPSIA == 2 || $IND_TIPO_BIOPSIA == 3){  #CONTEMPORANEA Y DIFERIDA
                $data_num_interno =   $this->db->query("SELECT P.NUM_INTERNO_AP FROM ADMIN.PB_SOLICITUD_HISTO P WHERE P.NUM_INTERNO_AP IN ($num_interno) AND P.COD_EMPRESA IN ($cod_empresa) AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) AND P.IND_TIPO_BIOPSIA IN (2,3,4)")->result_array();
            } else if ($IND_TIPO_BIOPSIA == 5) {   #SOLO CITOLOGIA
                $data_num_interno =   $this->db->query("SELECT P.NUM_CO_CITOLOGIA FROM ADMIN.PB_SOLICITUD_HISTO P WHERE P.NUM_CO_CITOLOGIA IN ($num_interno) AND P.COD_EMPRESA IN ($cod_empresa) AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) AND P.IND_TIPO_BIOPSIA IN (5)")->result_array();
            } else if ($IND_TIPO_BIOPSIA == 6) {   #PAP
                $data_num_interno =   $this->db->query("SELECT P.NUM_CO_PAP FROM ADMIN.PB_SOLICITUD_HISTO P WHERE P.NUM_CO_PAP IN ($num_interno) AND P.COD_EMPRESA IN ($cod_empresa) AND YEAR(P.DATE_INICIOREGISTRO) = YEAR(CURDATE()) AND P.IND_TIPO_BIOPSIA IN (6)")->result_array();
            }
            if(count($data_num_interno) > 0){
                return array(
                    'STATUS' =>  false,
                    'TXT_ERROR' =>  'N&deg; meno notificaci&oacute;n ya existe',
                    'HISTO_OK' =>  null,
                    'STATUS_BD' =>  false,
                    'error_memo' =>  1,
                    'close_modal' =>  0,
                    'count_interno' =>  count($data_num_interno),
                    'count_cotologia' =>  0,
                );
            }
        }
        $data_identifica_estado = $this->db->query("SELECT P.ID_HISTO_ESTADO FROM ADMIN.PB_SOLICITUD_HISTO P WHERE P.ID_SOLICITUD_HISTO IN ($ID_ANATOMIA) AND P.IND_ESTADO IN (1) AND P.ID_HISTO_ESTADO IN (3)")->result_array();
        if (count($data_identifica_estado) > 0){
            if(count($DATA['ARRAY']) > 0){
                foreach($DATA['ARRAY'] as $i => $fila){
                    foreach($fila as $x => $row){
                        #NUMERO DE CARGA DE LA TIME LINE
                        $ID_CARGA_AP                                    =   $this->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'DATABASE_NAME' AND TABLE_NAME = 'PB_LINETIME_HISTO'")->row()->AUTO_INCREMENT;
                        #GESTION DE LAS MUESTAS Y CASET DE ANATOMIA
                        if(count($row["ARRAY_NMUESTRAS"]) > 0){
                            foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus){
                                #AGREGA AL HISTORIAL DE LA MUESTRA
                                $ID_LINETIME_HISTO =   $this->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'DATABASE_NAME' AND TABLE_NAME = 'PB_LINETIME_HISTO'")->row()->AUTO_INCREMENT;
                                $ID_ANATOMIA =   $DATA["ID_ANATOMIA"];
                                $IND_CASETE =   $mus['IND_CASETE'];
                                $ID_MUESTRA =   $mus['ID_NMUESTRA'];
                                $arr_linea_tiempo =   array(
                                    "ID_LINETIMEHISTO" =>  $ID_LINETIME_HISTO,
                                    "ID_NUM_CARGA" =>  $ID_CARGA_AP,
                                    "ID_SOLICITUD_HISTO" =>  $row["NUM_HISTO"],
                                    //"ID_NMUESTRA"                     =>  substr($mus['ID_NMUESTRA'],1),
                                    "TXT_BACODE" =>  $mus['ID_NMUESTRA'],
                                    "NUM_FASE" =>  3,//RECEPCION
                                    "IND_CHECKED" =>  $mus['IN_CHECKED'],
                                    "USR_CREA" =>  $DATA["SESSION"],
                                    "FEC_CREA" =>  date('Y-m-d H:i:s'),
                                    "IND_ESTADO" =>  1,
                                    "ID_UID" =>  $DATA["DATA_FIRMA"]["user_1"]->ID_UID,
                                    "TXT_MUESTRA" =>  $mus['TXT_MUESTRA']==''?'NO INFORMADO':$mus['TXT_MUESTRA'],
                                );
                                array_merge($arr_linea_tiempo,array($IND_CASETE==1?"ID_CASETE":"ID_NMUESTRA"=>$ID_MUESTRA)); 
                                $this->db->insert('PB_LINETIME_HISTO',$arr_linea_tiempo);
                                #CAMBIA ESTADO DE MUESTRAS
                                $this->db->where($IND_CASETE==1?'ID_CASETE':'ID_NMUESTRA',$ID_MUESTRA);
                                $this->db->update('PB_HISTO_NMUESTRAS',array(
                                    "IND_ESTADO_CU" =>  $mus['IN_CHECKED'],
                                    "ID_NUM_CARGA" =>  $ID_CARGA_AP,
                                    "USR_AUDITA" =>  $DATA["SESSION"],
                                    "DATE_AUDITA" =>  date('Y-m-d H:i:s'),
                                ));
                                #ADD EVENTOS ADVERSOS
                                if(isset($mus["ARR_EVENTOS_ADVERSOS"])){
                                    foreach($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv){
                                        $this->db->insert('PB_ANTECEDENTES_HISTO',array(
                                            "ID_ANTECEDENTES_HISTO"     =>  $this->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'DATABASE_NAME' AND TABLE_NAME = 'PB_ANTECEDENTES_HISTO'")->row()->AUTO_INCREMENT,
                                            "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                            "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                            "ID_SOLICITUD_HISTO"        =>  $ID_ANATOMIA,
                                            "ID_NMUESTRA"               =>  $ID_MUESTRA,
                                            "ID_MOTIVO_DESAC"           =>  $adv["IND_MOTIVO"],
                                            "TXT_EVENTO_OBSERVACION"    =>  $adv["TXT_OBSERVACION"],
                                            "IND_ESTADO"                =>  1,
                                        ));
                                    }
                                }
                            }
                        }
                        #CONSULTA SI ESTA EN PABELLON
                        #CITOLOGIA Y CITOLOGIA PAP -> GO TO 
                        $result                         =   $this->db->query("SELECT P.IND_TIPO_BIOPSIA FROM ADMIN.PB_SOLICITUD_HISTO P WHERE P.ID_SOLICITUD_HISTO IN (".$row['NUM_HISTO'].")")->result_array();
                        $ind_zona                       =   $result[0]['IND_TIPO_BIOPSIA']=='6'||$result[0]['IND_TIPO_BIOPSIA']=='5'?'4':'0';
                        #NUMEROS DE ANATOMIA RESUELTOS
                        array_push($arr_histo_ok,$row["NUM_HISTO"]);
                        #MAIN - RECEPCION OK 
                        $this->db->where('ID_SOLICITUD_HISTO',$row["NUM_HISTO"]);
                        $arr_update                     =   array(  
                            "ID_HISTO_ESTADO"           =>  4,//RECEPCION OK
                            "ID_HISTO_ZONA"             =>  $ind_zona,
                            "IND_ESTADO_MUESTRAS"       =>  $row["NUM_OK_SAMPLES"],
                            "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                            "FEC_USRCREA_RECEP"         =>  date('Y-m-d H:i:s'),
                            "COD_USRCREA_RECEP"         =>  $DATA["SESSION"],
                            "COD_SESSION_RECEPCIONA"    =>  $DATA["SESSION"],
                            "ID_UID_TRASPORTE_OK"       =>  $DATA["DATA_FIRMA"]["user_1"]->ID_UID,
                            "ID_UID_RECEPCIONA_OK"      =>  $DATA["DATA_FIRMA"]["user_2"]->ID_UID,
                            "LAST_USR_AUDITA"           =>  $DATA["SESSION"],
                            "LAST_DATE_AUDITA"          =>  date('Y-m-d H:i:s'),
                            //"NUM_INTERNO_AP"          =>  $DATA["n_interno"],
                        ); 
                        
                        #ADD
                        if ($IND_TIPO_BIOPSIA           ==  4){
                            $arr_update                 =   array_merge($arr_update, array('NUM_INTERNO_AP'         => $DATA["n_interno"]));
                            $arr_update                 =   array_merge($arr_update, array('NUM_CO_CITOLOGIA'       => $DATA["n_interno_2"]));
                        } else {
                            if( $IND_TIPO_BIOPSIA == 2 || $IND_TIPO_BIOPSIA == 3 ){
                                $arr_update             =   array_merge($arr_update, array('NUM_INTERNO_AP'         => $DATA["n_interno"]));
                            } else if ($IND_TIPO_BIOPSIA    == 5 ){ 
                                $arr_update             =   array_merge($arr_update, array('NUM_CO_CITOLOGIA'       => $DATA["n_interno"]));
                            } else if ($IND_TIPO_BIOPSIA    == 6 ){
                                $arr_update             =   array_merge($arr_update, array('NUM_CO_PAP'             => $DATA["n_interno"]));
                            } 
                        }
                        $this->db->update('PB_SOLICITUD_HISTO',$arr_update);
                    }
                }
            }
            return [
                'STATUS' =>  $status,
                'TXT_ERROR' =>  '',
                'HISTO_OK' =>  $arr_histo_ok,
                'STATUS_BD' =>  $this->db->trans_complete(),  
            ];
        } else {
            return [
                'STATUS'                        =>  false,
                'TXT_ERROR'                     =>  'La solicitud ha cambiado de estado',
                'HISTO_OK'                      =>  null,
                'STATUS_BD'                     =>  false,
                'error_memo'                    =>  1,
                'close_modal'                   =>  1,
            ];
        }
    }
    
    #rechazo
    public function model_confirma_rechazo_muestras($DATA){
        $this->db->trans_start();
        $mivariable                     =   true;
        $arr_histo_ok                   =   [];
        $txt_observacion_glob           =   $DATA['TXT_GLOBAL'];
        $ID_UID                         =   $DATA['DATA_FIRMA']->ID_UID;
        $ID_ANATOMIA                    =   $DATA['ID_ANATOMIA']; 
        
        #LOAD
        if(count($DATA['ARRAY'])>0){
            foreach($DATA['ARRAY'] as $i => $fila){
                foreach($fila as $x => $row){
                    
                    #NUMERO DE CARGA DE LA TIME LINE
                    $ID_CARGA_AP                            =   $this->db->sequence($this->ownPab,'SEQ_NUM_CARGA_AP');
                    
                    #GESTION DE LAS MUESTAS Y CASET DE ANATOMIA
                    if(count($row["ARRAY_NMUESTRAS"])>0){
                        foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus){
                            
                            #AGREGA AL HISTORIAL DE LA MUESTRA
                            $ID_LINETIME_HISTO              =   $this->db->sequence($this->ownPab,'SEQ_NUM_LINETIME_HISTO');
                            $ID_ANATOMIA                    =   $DATA["ID_ANATOMIA"];
                            $IND_CASETE                     =   $mus['IND_CASETE'];
                            $ID_MUESTRA                     =   $mus['ID_NMUESTRA'];
                            $arr_linea_tiempo               =   array(
                                "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                "ID_SOLICITUD_HISTO"        =>  $row["NUM_HISTO"],
                                //"ID_NMUESTRA"             =>  substr($mus['ID_NMUESTRA'],1),
                                "TXT_BACODE"                =>  $mus['ID_NMUESTRA'],
                                "NUM_FASE"                  =>  4,//RECHAZO
                                "IND_CHECKED"               =>  $mus['IN_CHECKED'],
                                "USR_CREA"                  =>  $DATA["SESSION"],
                                "FEC_CREA"                  =>  'SYSDATE',
                                "IND_ESTADO"                =>  1,
                                "ID_UID"                    =>  $ID_UID,
                                "TXT_MUESTRA"               =>  $mus['TXT_MUESTRA']==''?'NO INFORMADO':$mus['TXT_MUESTRA'],
                            );
                            
                            #IDENTIFICA SI ES MUESTA O CASETE
                            array_merge($arr_linea_tiempo,array($IND_CASETE==1?"ID_CASETE":"ID_NMUESTRA"=>$ID_MUESTRA)); 
                            $this->db->insert($this->ownPab.'.PB_LINETIME_HISTO',$arr_linea_tiempo);

                            #CAMBIA ESTADO DE MUESTRAS
                            #IDENTIFICA SI ES CASETE O MUESTRA INDIVIDUAL
                            $this->db->where($IND_CASETE==1?'ID_CASETE':'ID_NMUESTRA',$ID_MUESTRA);
                            $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array(
                                "IND_ESTADO_CU"             =>  $mus['IN_CHECKED'],
                                "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                "USR_AUDITA"                =>  $DATA["SESSION"],
                                "DATE_AUDITA"               =>  'SYSDATE',
                            ));
                            
                            //var_dump($row["NUM_HISTO"]);
                            
                            #ADD EVENTOS ADVERSOS
                            if(isset($mus["ARR_EVENTOS_ADVERSOS"])){
                                foreach($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv){
                                    $this->db->insert($this->ownPab.'.PB_ANTECEDENTES_HISTO',array(
                                        "ID_ANTECEDENTES_HISTO"     =>  $this->db->sequence($this->own,'SEQ_NUM_ANTECEDENTE_HISTO'),
                                        "ID_SOLICITUD_HISTO"        =>  $row["NUM_HISTO"],
                                        "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                        "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                        "ID_NMUESTRA"               =>  $ID_MUESTRA,
                                        "ID_MOTIVO_DESAC"           =>  $adv["IND_MOTIVO"],
                                        "TXT_EVENTO_OBSERVACION"    =>  $adv["TXT_OBSERVACION"],
                                        "IND_ESTADO"                =>  1,
                                    ));
                                }
                            }
                            #END
                            
                            #ADD ARRAY MUESTRAS
                        }
                    }
                    
                    #CONSULTA SI ESTA EN PABELLON
                    //$result                         =   $this->db->query("SELECT P.IND_TIPO_BIOPSIA FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.ID_SOLICITUD_HISTO IN (".$row['NUM_HISTO'].")")->result_array();
                    //$ind_zona                       =   $result[0]['IND_TIPO_BIOPSIA']=='6'?'4':'0';
                    
                    #NUMEROS DE ANATOMIA RESUELTOS
                    array_push($arr_histo_ok,$row["NUM_HISTO"]);
                    
                    #MAIN - RECHAZO 
                    $this->db->where('ID_SOLICITUD_HISTO',$row["NUM_HISTO"]); 
                    $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',array(
                        "FEC_REVISION"              =>  "SYSDATE",
                        "ID_HISTO_ESTADO"           =>  5,#RECHAZO  
                        //"ID_HISTO_ZONA"           =>  $ind_zona,
                        "IND_ESTADO_MUESTRAS"       =>  $row["NUM_OK_SAMPLES"],
                        "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                        "ID_UID_RECHAZA"            =>  $ID_UID,
                        "TXT_OBS_RECHAZA"           =>  $txt_observacion_glob,
                        "LAST_USR_AUDITA"           =>  $DATA["SESSION"],
                        "LAST_DATE_AUDITA"          =>  "SYSDATE",
                    ));
                    
                }
            }
        }
        return array(
            'STATUS'    =>  $mivariable,
            'HISTO_OK'  =>  $arr_histo_ok,
            'STATUS_BD' =>  $this->db->trans_complete(),  
        );
    }
    
    public function busqueda_historial($DATA){
        return $this->db->query("SELECT 
                                    P.ID_LINETIMEHISTO, 
                                    P.ID_NUM_CARGA, 
                                    P.ID_SOLICITUD_HISTO, 
                                    P.TXT_BACODE, 
                                    P.NUM_FASE, 
                                    P.IND_CHECKED, 
                                    P.USR_CREA, 
                                    P.FEC_CREA, 
                                    P.IND_ESTADO, 
                                    P.ID_NMUESTRA, 
                                    P.ID_UID
                                FROM 
                                    ADMIN.PB_LINETIME_HISTO P
                                WHERE
                                    P.ID_SOLICITUD_HISTO = ".$DATA["ID_ANATOMIA"]."
                                ORDER BY 
                                    P.FEC_CREA")->result_array();
    }
    
    public function LOAD_BUSQUEDA_INFO($DATA){
        return $this->db->query(" SELECT 
                P.ID_SOLICITUD_HISTO, 
                P.NUM_FICHAE, 
                P.COD_USRCREA, 
                P.FEC_USRCREA, 
                P.COD_EMPRESA, 
                P.DES_SITIOEXT, 
                P.DES_UBICACION, 
                P.DES_TAMANNO, 
                P.ID_TIPO_LESION, 
                P.ID_ASPECTO, 
                P.ID_ANT_PREVIOS, 
                P.NUM_ANTECEDENTES, 
                P.DES_BIPSIA, 
                P.DES_CITOLOGIA, 
                P.DES_OBSERVACIONES, 
                P.IND_ESTADO, 
                P.FEC_REVISION, 
                P.ID_TABLA, 
                P.DES_TIPOMUESTRA, 
                P.NUM_SUBNUMERACION, 
                P.COD_USRCREA_TO_MUE, 
                P.FEC_USRCREA_TO_MUE, 
                P.COD_USRCREA_ENV, 
                P.FEC_USRCREA_ENV, 
                P.COD_USRCREA_RECEP, 
                P.FEC_USRCREA_RECEP, 
                P.COD_EMPRESA_RECEP, 
                P.COD_USRCREA_INFORMADA, 
                P.FEC_USRCREA_INFORMADA, 
                P.COD_EMPRESA_INFORMADA, 
                P.ID_ARCHIVO_SUBIDO, 
                P.COD_USRCREA_RECH, 
                P.FEC_USRCREA_RECH, 
                P.COD_EMPRESA_RECH, 
                P.TIPO_RECHAZO, 
                P.OBS_RECHAZO, 
                P.ID_HISTO_ESTADO, 
                P.AD_ID_ADMISION, 
                P.ID_SERDEP, 
                P.PA_ID_PROCARCH, 
                P.IND_TIPO_BIOPSIA, 
                P.IND_TEMPLATE, 
                P.DATE_INICIOREGISTRO, 
                P.COD_RUTPRO, 
                P.TXT_DIAGNOSTICO, 
                P.NUM_PLANTILLA, 
                P.IND_USOCASSETTE, 
                P.IND_INFOPOST
            FROM 
                ADMIN.PB_SOLICITUD_HISTO P
            WHERE
                P.ID_SOLICITUD_HISTO IN (".$DATA['NUM_HISTO'].") ")->result_array();
    }

    #PDF_GLOBAL
    public function LOAD_ANATOMIAPATOLOGICA_PDF($DATA) {
        $this->db->trans_start();
        $V_ID_HISTO = $this->db->escape($DATA["ID_HISTO"]);
        $V_COD_EMPRESA = $this->db->escape($DATA["COD_EMPRESA"]);
        $P_ANATOMIA_PATOLOGICA_MAIN = [];
        $multi_query = $this->db->conn_id->multi_query("CALL ADMIN.CONSULTA_UNICA_ANATOMIA($V_ID_HISTO, $V_COD_EMPRESA)");
        if ($multi_query) {
            do {
                if ($result = $this->db->conn_id->store_result()) {
                    $P_ANATOMIA_PATOLOGICA_MAIN = $result->fetch_all(MYSQLI_ASSOC);
                    $result->free();
                }
            } while ($this->db->conn_id->more_results() && $this->db->conn_id->next_result());
        } else {
            $error = $this->db->conn_id->error;
        }
        $this->db->reconnect();
        $P_ANATOMIA_PATOLOGICA_MUESTRAS = [];
        $multi_query = $this->db->conn_id->multi_query("CALL ADMIN.CONSULTA_MUESTRAS_HISTO($V_COD_EMPRESA,$V_ID_HISTO)");
        if ($multi_query) {
            do {
                if ($result = $this->db->conn_id->store_result()) {
                    $P_ANATOMIA_PATOLOGICA_MUESTRAS = $result->fetch_all(MYSQLI_ASSOC);
                    $result->free();
                }
            } while ($this->db->conn_id->more_results() && $this->db->conn_id->next_result());
        } else {
            $error = $this->db->conn_id->error;
        }
        $this->db->reconnect();
        $P_AP_MUESTRAS_CITOLOGIA = [];
        $multi_query = $this->db->conn_id->multi_query("CALL ADMIN.CONSULTA_MUESTRAS_CITO($V_COD_EMPRESA,$V_ID_HISTO)");
        if ($multi_query) {
        do {
        if ($result = $this->db->conn_id->store_result()) {
            $P_AP_MUESTRAS_CITOLOGIA = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
        }
        } while ($this->db->conn_id->more_results() && $this->db->conn_id->next_result());
        } else {
        $error = $this->db->conn_id->error;
        }
        $this->db->reconnect();

        #GESTOR DE IMAGENES
        $C_IMAGENES_BLOB = $this->db->query("SELECT
               -- I.ID_MAIN AS ID_UNICO_IMAGEN,
                I.ID_HISTO_ZONA AS ID_HISTO_ZONA,
                I.ID_SOLICITUD_HISTO,
                I.COD_EMPRESA,
                I.SIZE_BLG,
                I.CONTEXT_TYPE,
                I.MAIN_BLOB,
                I.IND_ESTADO,
                I.IMG_DATA,
                I.NAME_IMG,
                I.TXT_OBSERVACIONES,
                I.ID_UID,
                I.USR_CREA,
                I.DATE_CREA,
                I.BFILE,
                I.NCLOB
            FROM
                ADMIN.PB_MAIN_BLG_ANATOMIA I
            WHERE
                I.ID_SOLICITUD_HISTO = ?
                AND I.IND_ESTADO = 1
            ORDER BY
                I.DATE_CREA", array($V_ID_HISTO))->result_array();
    
        // GESTOR DE IMAGENES MUESTRAS
        $C_IMAGENES_BLOB_MUESTRAS = $this->db->query("SELECT
               -- I.ID_MAIN AS ID_IMAGEN,
                I.ID_SOLICITUD_HISTO,
                I.COD_EMPRESA,
                I.SIZE_BLG,
                I.CONTEXT_TYPE,
                I.MAIN_BLOB,
                I.IND_ESTADO,
                I.IMG_DATA,
                I.NAME_IMG,
                I.TXT_OBSERVACIONES,
                I.ID_UID,
                I.USR_CREA,
                I.DATE_CREA,
                I.BFILE,
                I.NCLOB,
                I.ID_HISTO_ZONA
            FROM
                ADMIN.PB_IMG_APMUESTRAS I
            WHERE
                I.ID_SOLICITUD_HISTO = ?
                AND I.IND_ESTADO = 1
            ORDER BY
                I.DATE_CREA", array($V_ID_HISTO))->result_array();

        $this->db->trans_complete();
        return array(
            'STATUS' => $this->db->trans_status(),
            'ID_HISTO' => $DATA["ID_HISTO"],
            'COD_EMPRESA' => $DATA["COD_EMPRESA"],
            'HTML_QR' => '',
            'P_ANATOMIA_PATOLOGICA_MAIN' => $P_ANATOMIA_PATOLOGICA_MAIN,
            'P_ANATOMIA_PATOLOGICA_MUESTRAS' => $P_ANATOMIA_PATOLOGICA_MUESTRAS,
            'P_AP_MUESTRAS_CITOLOGIA' => $P_AP_MUESTRAS_CITOLOGIA,
            'C_IMAGENES_BLOB' => $C_IMAGENES_BLOB,
            'C_IMAGENES_BLOB_MUESTRAS' => $C_IMAGENES_BLOB_MUESTRAS,
        );
    }
    
    #PDF RECHAZO
    public function load_info_rechazo($DATA){
        $this->db->trans_start();
        $param = array(
            array( 
                'name' =>  ':V_COD_EMPRESA',
                'value' =>  $DATA["COD_EMPRESA"],
                'length' =>  20,
                'type' =>  SQLT_CHR 
            ),
            array( 
                'name' =>  ':V_ID_HISTO',
                'value' =>  $DATA["ID_HISTO"],
                'length' =>  20,
                'type' =>  SQLT_CHR 
            ),
            array( 
                'name' =>  ':P_ANATOMIA_PATOLOGICA_MAIN',
                'value' =>  $this->db->get_cursor(),
                'length' =>  -1,
                'type' =>  OCI_B_CURSOR
            ),
            array( 
                'name' =>  ':P_ANATOMIA_PATOLOGICA_MUESTRAS',
                'value' =>  $this->db->get_cursor(),
                'length' =>  -1,
                'type' =>  OCI_B_CURSOR
            ),
            array( 
                'name' =>  ':P_AP_MUESTRAS_CITOLOGIA',
                'value' =>  $this->db->get_cursor(),
                'length' =>  -1,
                'type' =>  OCI_B_CURSOR
            ),
            array( 
                'name' =>  ':P_INFO_LOG_ADVERSOS',
                'value' =>  $this->db->get_cursor(),
                'length' =>  -1,
                'type' =>  OCI_B_CURSOR
            ),
        );
        $result = $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_ANATOMIAPATOLOGICA_RECHAZ',$param);
        $this->db->trans_complete();
        return array(
            'STATUS' =>	$this->db->trans_status(),
            'ID_HISTO' => $DATA["ID_HISTO"],
            'COD_EMPRESA' => $DATA["COD_EMPRESA"],
            'P_ANATOMIA_PATOLOGICA_MAIN' =>	empty($result[':P_ANATOMIA_PATOLOGICA_MAIN'])?null:$result[':P_ANATOMIA_PATOLOGICA_MAIN'],
            'P_ANATOMIA_PATOLOGICA_MUESTRAS' =>	empty($result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'])?null:$result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'],
            'P_AP_MUESTRAS_CITOLOGIA' => empty($result[':P_AP_MUESTRAS_CITOLOGIA'])?null:$result[':P_AP_MUESTRAS_CITOLOGIA'],
            'P_INFO_LOG_ADVERSOS' => empty($result[':P_INFO_LOG_ADVERSOS'])?null:$result[':P_INFO_LOG_ADVERSOS'],          
        );
    }
    
    #USUARIO EXTERNO + RCE
    public function MODEL_RECORD_ANATOMIA_PATOLOGICA_EXT($session, $accesdata) {
        $this->db->trans_start();
        $PLZ_ETIQUETA_MEDIANA = [];
        $DATA_TEMPLATE = $accesdata["DATA_TEMPLATE"][0]["DATA"];
        $ID_GESPAB = $DATA_TEMPLATE["ID_GESPAB"];
        $numfichae = $DATA_TEMPLATE["TEMPLATE_NUMFICHAE"];
        $empresa = $DATA_TEMPLATE["TEMPLATE_EMPRESA"] === '' ? $this->session->userdata("COD_ESTAB") : $DATA_TEMPLATE["TEMPLATE_EMPRESA"];
        $TEMPLATE_RUT_PROFESIONAL = $DATA_TEMPLATE["TEMPLATE_RUT_PROFESIONAL"];
        $TEMPLATE_IND_TIPO_BIOPSIA = $DATA_TEMPLATE["TEMPLATE_IND_TIPO_BIOPSIA"];
        $TEMPLATE_IND_ESPECIALIDAD = $DATA_TEMPLATE["TEMPLATE_IND_ESPECIALIDAD"];
        $TEMPLATE_PA_ID_PROCARCH = $DATA_TEMPLATE["TEMPLATE_PA_ID_PROCARCH"];
        $TEMPLATE_AD_ID_ADMISION = $DATA_TEMPLATE["TEMPLATE_AD_ID_ADMISION"];
        $TXT_DIAGNOSTICO = $DATA_TEMPLATE["TXT_DIAGNOSTICO"];
        $TEMPLATE_PLANTILLA = $DATA_TEMPLATE["TEMPLATE_PLANTILLA"];
        $V_BOOLEANO_CASSETTE = $DATA_TEMPLATE["TEMPLATE_USODECASSETTE"];
        $FORM_POST = $DATA_TEMPLATE["TEMPLATE_INFOPOST"];
        $TEMPLATE_IND_ROTULADO = $DATA_TEMPLATE["TEMPLATE_IND_ROTULADO"];
        $TEMPLATE_IND_ROTULADO_SUB = $DATA_TEMPLATE["TEMPLATE_IND_ROTULADO_SUB"];
        $DATE_SOLICITUD = $DATA_TEMPLATE["TEMPLATE_DATE_DMYHM"];
        $TEMPLATE_DATE_SOLICITUD = $DATA_TEMPLATE["TEMPLATE_DATE_SOLICITUD"];
        $TEMPLATE_HRS_SOLICITUD = $DATA_TEMPLATE["TEMPLATE_HRS_SOLICITUD"];
        $template_ind_derivacion = $DATA_TEMPLATE["TEMPLATE_IND_DERIVACION"];
        $template_ind_sic = $DATA_TEMPLATE["TEMPLATE_IND_ID_SIC"];
        // Aseguramos que la fecha se formatee correctamente para MySQL
        $DATE_SOLICITUD = date("Y-m-d H:i:s");
        foreach($accesdata as $infObject => $Object) {
            if($infObject == 'examenHispatologico') {
                $dataSolicitud = array(
                    'NUM_FICHAE' => $numfichae,
                    'COD_USRCREA' => $session,
                    'FEC_USRCREA' => date('Y-m-d H:i:s'),
                    'COD_EMPRESA' => $empresa,
                    'COD_RUTPRO' => $TEMPLATE_RUT_PROFESIONAL,
                    'IND_ESTADO' => 1,
                    'ID_HISTO_ESTADO' => 1,
                    'DATE_INICIOREGISTRO' => $DATE_SOLICITUD,
                    'IND_TEMPLATE' => 1,
                    'IND_TIPO_BIOPSIA' => $TEMPLATE_IND_TIPO_BIOPSIA,
                    'PA_ID_PROCARCH' => $TEMPLATE_PA_ID_PROCARCH,
                    'ID_SERDEP' => $TEMPLATE_IND_ESPECIALIDAD,
                    'AD_ID_ADMISION' => $TEMPLATE_AD_ID_ADMISION,
                    'TXT_DIAGNOSTICO' => $TXT_DIAGNOSTICO,
                    'NUM_PLANTILLA' => $TEMPLATE_PLANTILLA,
                    'IND_USOCASSETTE' => $V_BOOLEANO_CASSETTE,
                    'IND_INFOPOST' => $FORM_POST,
                    'ID_ROTULADO' => $TEMPLATE_IND_ROTULADO,
                    'ID_ROTULADO_SUB' => $TEMPLATE_IND_ROTULADO_SUB
                );
    
                if ($template_ind_derivacion == 1) {
                    $dataSolicitud = array_merge($dataSolicitud, array(
                        "IND_DERIVACION_IC" => 1,
                        "ID_SIC" => $template_ind_sic,
                    ));
                }
    
                if($ID_GESPAB != '') {
                    $dataSolicitud = array_merge($dataSolicitud, array("ID_TABLA" => $ID_GESPAB));
                }
    
                if(isset($Object[0]['listadoHISPATO'])) {
                    $hispatologico = $Object[0]['listadoHISPATO'];
                    foreach ($hispatologico as $i => $datos) {
                        if ($datos['name'] == 'slc_ind_cancer') {
                            $dataSolicitud = array_merge($dataSolicitud, array("IND_NOTIF_CANCER" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_extraInput') {
                            $dataSolicitud = array_merge($dataSolicitud, array("DES_SITIOEXT" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_ubicaInput') {
                            $dataSolicitud = array_merge($dataSolicitud, array("DES_UBICACION" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_tamannoInput') {
                            $dataSolicitud = array_merge($dataSolicitud, array("DES_TAMANNO" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_lesionSelect') {
                            $dataSolicitud = array_merge($dataSolicitud, array("ID_TIPO_LESION" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_aspectoSelect') {
                            $dataSolicitud = array_merge($dataSolicitud, array("ID_ASPECTO" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_ant_previosSelect') {
                            $dataSolicitud = array_merge($dataSolicitud, array("ID_ANT_PREVIOS" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_ant_nMuestasSelect') {
                            $dataSolicitud = array_merge($dataSolicitud, array("NUM_ANTECEDENTES" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_des_BiopsiaInput') {
                            $dataSolicitud = array_merge($dataSolicitud, array("DES_BIPSIA" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_des_CitologiaInput') {
                            $dataSolicitud = array_merge($dataSolicitud, array("DES_CITOLOGIA" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_observTextarea') {
                            $dataSolicitud = array_merge($dataSolicitud, array("DES_OBSERVACIONES" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_des_tipodemuestra') {
                            $dataSolicitud = array_merge($dataSolicitud, array("DES_TIPOMUESTRA" => $datos['value']));
                        }
                        if ($datos['name'] == 'bio_subnumeracion') {
                            $dataSolicitud = array_merge($dataSolicitud, array("NUM_SUBNUMERACION" => $datos['value']));
                        }
                    }
                }
    
                if ($TEMPLATE_PA_ID_PROCARCH == '31' || $TEMPLATE_PA_ID_PROCARCH == '36') {
                    $arr_data = $ID_GESPAB == '' ? [] : $this->db->query("SELECT AP.ID_SOLICITUD_HISTO FROM ADMIN.PB_SOLICITUD_HISTO AP WHERE AP.ID_TABLA=".$ID_GESPAB." ORDER BY AP.ID_SOLICITUD_HISTO")->result_array();
                    if (count($arr_data) > 0) {
                        $ID_BIOPSIA = $arr_data[0]["ID_SOLICITUD_HISTO"];
                        $this->db->where('ID_SOLICITUD_HISTO', $ID_BIOPSIA);
                        $this->db->update('ADMIN.PB_SOLICITUD_HISTO', $dataSolicitud);
                    } else {
                        $this->db->insert('ADMIN.PB_SOLICITUD_HISTO', $dataSolicitud);
                        $ID_BIOPSIA = $this->db->insert_id();
                    }
                } else {
                    $arr_data = $TEMPLATE_AD_ID_ADMISION == '' ? [] : $this->db->query("SELECT AP.ID_SOLICITUD_HISTO FROM ADMIN.PB_SOLICITUD_HISTO AP WHERE AP.AD_ID_ADMISION=".$TEMPLATE_AD_ID_ADMISION." ORDER BY AP.ID_SOLICITUD_HISTO")->result_array();
                    if (count($arr_data) > 0) {
                        $ID_BIOPSIA = $arr_data[0]["ID_SOLICITUD_HISTO"];
                        $this->db->where('ID_SOLICITUD_HISTO', $ID_BIOPSIA);
                        $this->db->update('ADMIN.PB_SOLICITUD_HISTO', $dataSolicitud);
                    } else {
                        $this->db->insert('ADMIN.PB_SOLICITUD_HISTO', $dataSolicitud);
                        $ID_BIOPSIA = $this->db->insert_id();
                    }
                }
    
                $this->db->where('ID_SOLICITUD_HISTO', $ID_BIOPSIA);
                $this->db->where_in('IND_TIPOMUESTRA', array('1', '2'));
                $this->db->update('ADMIN.PB_HISTO_NMUESTRAS', array('IND_ESTADO' => '0', 'USR_AUDITA' => $session, 'DATE_AUDITA' => date('Y-m-d H:i:s')));
    
                if (isset($Object[0]['numero_muestas'])) {
                    $numero_muestas = $Object[0]['numero_muestas'];
                    if (count($numero_muestas) > 0) {
                        foreach ($numero_muestas as $i => $row) {
                            $ARR_MUESTRA = is_null($row['N_MUESTRA']) ? $i + 1 : $row['N_MUESTRA'];
                            $NUMERO_MUESTRA = array(
                                'N_MUESTRA' => $ARR_MUESTRA,
                                'TXT_MUESTRA' => substr($row['TXT_MUESTRA'], 0, 51),
                                'IND_ESTADO' => '1',
                                'IND_ETIQUETA' => $row['IND_ETIQUETA'],
                                'NUM_CASSETTE' => $row['IND_NUMCASSETTE'],
                                'IND_TIPOMUESTRA' => 1,
                            );
    
                            $ID_CASETE = $V_BOOLEANO_CASSETTE == 1 ? $this->db->query("SELECT AP.ID_CASETE AS ID_CASETE FROM ADMIN.PB_HISTO_NMUESTRAS AP WHERE AP.NUM_CASSETTE = ".$row['IND_NUMCASSETTE']." AND AP.ID_SOLICITUD_HISTO = ".$ID_BIOPSIA." AND AP.ID_CASETE IS NOT NULL ORDER BY AP.ID_SOLICITUD_HISTO")->row_array()['ID_CASETE'] : 0;
    
                            if (empty($row['ID_NMUESTRA'])) {
                                $NUMERO_MUESTRA = array_merge($NUMERO_MUESTRA, array(
                                    'ID_NMUESTRA' => NULL, // Esto permitirá que MySQL auto-incremente el ID
                                    'ID_SOLICITUD_HISTO' => $ID_BIOPSIA,
                                    'USR_CREA' => $session,
                                    'DATE_CREA' => date('Y-m-d H:i:s'),
                                    'ID_CASETE' => $ID_CASETE,
                                ));
                                $this->db->insert('ADMIN.PB_HISTO_NMUESTRAS', $NUMERO_MUESTRA);
                            } else {
                                $NUMERO_MUESTRA = array_merge($NUMERO_MUESTRA, array(
                                    'USR_AUDITA' => $session,
                                    'DATE_AUDITA' => date('Y-m-d H:i:s'),
                                    'ID_CASETE' => $ID_CASETE,
                                ));
                                $this->db->where('ID_NMUESTRA', $row['ID_NMUESTRA']);
                                $this->db->update('ADMIN.PB_HISTO_NMUESTRAS', $NUMERO_MUESTRA);
                            }
                        }
                    }
                }
                if (isset($Object[0]['arr_citologia'])) {
                    $arr_citologia = $Object[0]['arr_citologia'];
                    if (count($arr_citologia) > 0) {
                        foreach ($arr_citologia as $i => $row) {
                            $NUMERO_CITOLGIA = array(
                                'N_MUESTRA' => $row['N_MUESTRA'],
                                'TXT_MUESTRA' => substr($row['TXT_MUESTRA'], 0, 51),
                                'IND_ESTADO' => '1',
                                'IND_ETIQUETA' => $row['IND_ETIQUETA'],
                                'NUM_ML' => str_replace('.', ',', $row['NUM_ML']),
                                'IND_TIPOMUESTRA' => 2,
                                'ID_SOLICITUD_HISTO' => $ID_BIOPSIA,
                            );
                            if (!empty($row['ID_NMUESTRA'])) {
                                $NUMERO_CITOLGIA = array_merge($NUMERO_CITOLGIA, array("USR_AUDITA" => $session, "DATE_AUDITA" => date('Y-m-d H:i:s')));
                                $this->db->where('ID_NMUESTRA', $row['ID_NMUESTRA']);
                                $this->db->update('ADMIN.PB_HISTO_NMUESTRAS', $NUMERO_CITOLGIA);
                            } else {
                                $NUMERO_CITOLGIA = array_merge($NUMERO_CITOLGIA, array(
                                    'ID_NMUESTRA' => NULL, // Esto permitirá que MySQL auto-incremente el ID
                                    "USR_CREA" => $session,
                                    "DATE_CREA" => date('Y-m-d H:i:s')
                                ));
                                $this->db->insert('ADMIN.PB_HISTO_NMUESTRAS', $NUMERO_CITOLGIA);
                            }
                        }
                    }
                }
            }
        }
        $this->db->trans_complete();
        return array(
            'STATUS' => true,
            'ID_ANATOMIA' => $ID_BIOPSIA,
            'GET_PLZ' => $PLZ_ETIQUETA_MEDIANA,
        );
    }
    
    
    public function zpl_nuemero_muestra($ID_NMUESTA_AP){
        $VAL_ZPL = 'HTML ->'.$ID_NMUESTA_AP;
        return $VAL_ZPL;
    }

    public function get_hoja_faph($valiable){
        $this->db->trans_start();
        $param  =   array(
                            array( 
                                'name'	=>  ':VAL_FAP_IDCORREL',
                                'value'	=>  $valiable,
                                'length'=>  20,
                                'type'	=>  SQLT_CHR 
                            ),
                            array( 
                                'name'	=>  ':P_RETURN_DATA',
                                'value'	=>  $this->db->get_cursor(),
                                'length'=>  -1,
                                'type'	=>  OCI_B_CURSOR
                            ),
                            array( 
                                'name'	=>  ':P_HISTORIAL',
                                'value'	=>  $this->db->get_cursor(),
                                'length'=>  -1,
                                'type'	=>  OCI_B_CURSOR
                            ),
                            array( 
                                'name'	=>  ':P_STATUS',
                                'value'	=>  $this->db->get_cursor(),
                                'length'=>  -1,
                                'type'	=>  OCI_B_CURSOR
                            ),
                        );
        try { 
	    $result     =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_HOJA_FAPH','CONSULTA_HOJA',$param);
	    if(empty($result)) {
		//throw new Exception('sin datos devueltos');
		$result =   null;
	    }
	} catch (Exception $e) {
	    $return['INFO_RESUL']	    =   false;
	    $return['MSJ_ERROR']	    =   var_dump($e->getMessage());
	    return $return;
	}
	$this->db->trans_complete();
        return array(
			'STATUS' => $this->db->trans_status(),
			'P_RETURN_DATA' => $result[':P_RETURN_DATA'],
            'P_HISTORIAL' => $result[':P_HISTORIAL'],
            'P_STATUS' => $result[':P_STATUS'],
        );
    }
    
    public function model_ultimo_numero_disponible($aData) {
        $v_cod_empresa = $aData['val_empresa'];
        $v_ind_tipo_biopsia =  $aData['ind_tipo_biopsia'];
        $v_last_numero = 0;
        $v_id_anatomia = null;
        $result = [];
        if (in_array($v_ind_tipo_biopsia, [2, 3, 4])) {
            $query = $this->db->query("SELECT 
                                            COALESCE(MAX(NUM_INTERNO_AP), 0) + 1 AS V_LAST_NUMERO
                                        FROM 
                                            ADMIN.PB_SOLICITUD_HISTO
                                        WHERE 
                                            COD_EMPRESA IN (?) 
                                            AND IND_TIPO_BIOPSIA IN (2, 3, 4)
                                            AND YEAR(DATE_INICIOREGISTRO) = YEAR(NOW())
                                            AND NUM_FICHAE IS NOT NULL
            ", [$v_cod_empresa]);
        } elseif ($v_ind_tipo_biopsia == 5) {
            $query = $this->db->query("SELECT 
                                            COALESCE(MAX(NUM_CO_CITOLOGIA), 0) + 1 AS V_LAST_NUMERO
                                        FROM 
                                            ADMIN.PB_SOLICITUD_HISTO
                                        WHERE 
                                            COD_EMPRESA IN (?)
                                            AND IND_TIPO_BIOPSIA IN (4, 5)
                                            AND YEAR(DATE_INICIOREGISTRO) = YEAR(NOW())
                                            AND NUM_FICHAE IS NOT NULL
            ", [$v_cod_empresa]);
        } elseif ($v_ind_tipo_biopsia == 6) {
            $query = $this->db->query("SELECT 
                                            COALESCE(MAX(NUM_CO_PAP), 0) + 1 AS V_LAST_NUMERO
                                        FROM 
                                            ADMIN.PB_SOLICITUD_HISTO
                                        WHERE 
                                            COD_EMPRESA IN (?)
                                            AND IND_TIPO_BIOPSIA = 6
                                            AND YEAR(DATE_INICIOREGISTRO) = YEAR(NOW())
                                            AND NUM_FICHAE IS NOT NULL
            ", [$v_cod_empresa]);
        }
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $v_last_numero = $row->V_LAST_NUMERO;
        }
        return [
            'STATUS' => true,
            'V_LAST_NUMERO' => $v_last_numero,
            'V_IND_TIPO_BIOPSIA' => $v_ind_tipo_biopsia,
            'V_ID_ANATOMIA' => $v_id_anatomia
        ];
    }
    
    public function model_ultimo_numero_disponible_citologia($aData){
        $v_cod_empresa = $aData['val_empresa'];
        $v_ind_tipo_biopsia =  $aData['ind_tipo_biopsia'];
        $v_last_numero = 0;
        $v_id_anatomia = null;
        $query = $this->db->query("SELECT 
                                        COALESCE(MAX(NUM_CO_CITOLOGIA), 0) + 1 AS V_LAST_NUMERO
                                    FROM 
                                        ADMIN.PB_SOLICITUD_HISTO
                                    WHERE 
                                        COD_EMPRESA IN (?) 
                                        AND IND_TIPO_BIOPSIA IN (4, 5)
                                        AND YEAR(DATE_INICIOREGISTRO) = YEAR(NOW())
                                        AND NUM_FICHAE IS NOT NULL
                                ", [$v_cod_empresa]);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $v_last_numero = $row->V_LAST_NUMERO;
        }
        return [
            'V_LAST_NUMERO' => $v_last_numero,
            'V_IND_TIPO_BIOPSIA' => $v_ind_tipo_biopsia,
            'V_ID_ANATOMIA' => $v_id_anatomia
        ];
    }
    
    
    public function model_gestion_tomamuestraxuser($valiable){
        $this->db->trans_start();
        $param              =   array(
                                    array( 
                                        'name'      =>  ':V_COD_EMPRESA',
                                        'value'     =>  $valiable["val_empresa"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':P_ALL_TOMAS_MUESTRA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_STATUS',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                );
        $result             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_USERXTOMAMUESTRA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'	    =>	$this->db->trans_status(),
            'DATA'          =>  $result,
        );
    }
    
    
    public function model_asignacion_muestra_x_user($valiable){
        $this->db->trans_start();
        $param              =   array(
                                    array( 
                                        'name'      =>  ':V_COD_EMPRESA',
                                        'value'     =>  $valiable["val_empresa"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_RUT_PROFESIONAL',
                                        'value'     =>  $valiable["rut_profesional"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':P_INFO_PROFESIONAL',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_ALL_TOMAS_MUESTRA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_USER_TOMA_MUESTRA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_STATUS',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                );
        $result             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_GESTION_USERXANATOMIA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'	    =>	$this->db->trans_status(),
            'DATA'          =>  $result,
        );
    }
    

    public function model_record_rotulos_por_usuario($data){
        $this->db->trans_start();
        $COD_RUTPRO         =   $data['ind_proesional']['COD_RUTPRO'];
        $ID_PRO             =   $data['ind_proesional']['ID_PRO'];
        //all cero
        $this->db->where('COD_RUTPRO',$COD_RUTPRO); 
        $this->db->update($this->ownPab.'.PB_ROTULOXPROFESIONAL',array('IND_ESTADO'=>'0','DATE_AUDITA'=>'SYSDATE','USER_AUDITA'=>$data['session']));
        if(count($data["ind_servicios"])>0){
            foreach($data["ind_servicios"] as $i => $row){
                $array      =   $this->db->query("SELECT P.ID_ROTULOXPROFESIONAL FROM PABELLON.PB_ROTULOXPROFESIONAL P WHERE P.ID_ROTULADO IN ($row) AND P.COD_RUTPRO IN ($COD_RUTPRO) ")->result_array();
                if(count($array)>0){
                    $this->db->where('ID_ROTULOXPROFESIONAL',$array[0]['ID_ROTULOXPROFESIONAL']); 
                    $this->db->update($this->ownPab.'.PB_ROTULOXPROFESIONAL',array('IND_ESTADO'=>'1','DATE_AUDITA'=>'SYSDATE','USER_AUDITA'=>$data['session']));
                } else {
                    $dataPreg1                      =   array(
                        "ID_ROTULOXPROFESIONAL"     =>  $this->db->sequence($this->ownPab,'SEQ_TOMA_MUESTRA_X_USUARIO'),
                        "ID_ROTULADO"               =>  $row,
                        "ID_PROFESIONAL"            =>  $ID_PRO,
                        "COD_RUTPRO"                =>  $COD_RUTPRO,
                        "IND_ESTADO"                =>  1,
                        "USER_CREA"                 =>  $data['session'],
                        "DATE_CREA"                 =>  'SYSDATE'
                    );
                    $this->db->insert($this->ownPab.'.PB_ROTULOXPROFESIONAL', $dataPreg1);
                }
            }
        }
        $this->db->trans_complete();
        return array(
            'STATUS'	    =>	$this->db->trans_status(),
            'DATA'          =>  $data,
        );
    }

   
    #GET      
    public function get_html_anatomia(){
        $sQuery = "
            SELECT 
                IND_TIPOATENCION, 
                DES_TIPOATENCION 
            FROM 
                ADMIN.AP_TTIPOATENCION 
            WHERE 
                IND_ESTADO  IN  ('V')  ";
            $var        =   '';
            $var        .=  '<span style="color: #FF9800;">* </span><label class="control-label">TIPO PROFESIONAL</label>';
            $var        .=  '<select class="form-control" name="tprof" id="tprof" onchange="CARGAPROF();" required>';
            $var        .=  '<option>SELECCIONE EL TIPO DE PROFESIONAL</option>';
            $array      =   $this->db->query($sQuery)->result_array();
            if (count($array)>0){
                foreach ($array as $val) {
                    $var .= '<option value="' . $val['IND_TIPOATENCION'] . '"> ' . $val['DES_TIPOATENCION'] . '</option>';
                }
            }
            $var .= "</select>";
            return $var;
    }
    
    #LIBRO DE BIOPSIA
    /*
    $dataPreg1                                  =   array(     
        //'LB_ID'                               =>  $SEQ_BS_LIBRO_BIOPSIA,
        'ID_SOLICITUD_HISTO'                    =>  $ID_BIOPSIA,
        'NUM_FICHAE'                            =>  $numfichae,
        //'ID_TABLA'                            =>  $id,
        //'LB_N_MUESTRAS'                       =>  $SL_cant_muestras,
        //'LB_TIPOMUESTRA'                      =>  $SL_tipo_muestra,
        'LB_FECHA_TOMAMUESTRA'                  =>  "TO_DATE('".$DATA_SOLICITUD_ANATOMIA."', 'DD-MM-YYYY hh24:mi')",//fecha de la operacion 
        //'LB_POLIPECTOMIA'                     =>  $SL_polipectomia,
        //'LB_EDA_EDB'                          =>  $sl_EDAEDB,
        'LB_RUT_MED_TRATANTE'                   =>  $cod_respo,//rut del primer cirijano
        //'LB_RUT_PABELLONERA'                  =>  $RUT_TENS_RESPONSABLE_0,//LB_RUT_TENS_RESPONSABLE
        //'LB_FECHA_ALMACENAMIENTO'             =>  $txt_fec_ALMACENAMIENTO,
        //'LB_RUT_PROF_ALMACENA'                =>  $RUT_PROF_ALMACENA_0,               
        //'LB_PROF_TRASLADA'                    =>  $RUT_PROF_TRASLADA_0,
        'LB_IND_ESTADO'                         =>  1,
        'LB_FEC_CREA'                           =>  'SYSDATE',
        'LB_USRCREA'                            =>  $session,
        'LB_EMPRESA'                            =>  $empresa,
        'LB_NOTAS'                              =>  '',
        'PA_ID_PROCARCH'                        =>  '31',
    );
    $query2                                     =   $this->db->query("SELECT B.LB_ID AS ID_LBIOP FROM ADMIN.BS_LIBRO_BIOPSIA B WHERE ID_SOLICITUD_HISTO=".$ID_BIOPSIA);
    $arr_lib                                    =   $query2->result_array();
    if(count($arr_lib)>0){
        $this->db->where('LB_ID',$arr_lib[0]['ID_LBIOP']); 
        $this->db->update($this->own.'.BS_LIBRO_BIOPSIA',$dataPreg1);
    } else {
        $dataPreg1                          =   array_merge($dataPreg1, array("LB_ID" => $this->db->sequence($this->own,'SEQ_BS_LIBRO_BIOPSIA') )); 
        $this->db->insert($this->own.'.BS_LIBRO_BIOPSIA', $dataPreg1);
    }
    */
    
    /*
     * if(($row['ID_NMUESTRA']=='')||($row['ID_NMUESTRA']==null)){
                                    $ID_NMUESTA_AP              =   $this->db->sequence($this->ownPab,'SEQ_HISTO_NUMNUESTRAS');
                                    $NUMERO_MUESTRA             =   array_merge($NUMERO_MUESTRA,array(
                                        "ID_NMUESTRA"           =>  $ID_NMUESTA_AP,
                                        'ID_SOLICITUD_HISTO'    =>  $ID_BIOPSIA,
                                        'USR_CREA'              =>  $session,
                                        'DATE_CREA'             =>  'SYSDATE',
                                        'ID_CASETE'             =>  $ID_CASETE,
                                    ));
                                    $this->db->insert($this->ownPab.'.PB_HISTO_NMUESTRAS',$NUMERO_MUESTRA);
                                } else {
                                    $NUMERO_MUESTRA             =   array_merge($NUMERO_MUESTRA,array(
                                        'USR_AUDITA'            =>  $session,
                                        'DATE_AUDITA'           =>  'SYSDATE',
                                        'ID_CASETE'             =>  $ID_CASETE,
                                    )); 
                                    $this->db->where('ID_NMUESTRA',$row['ID_NMUESTRA']); 
                                    $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',$NUMERO_MUESTRA);
                                }
    */

    public function valida_cuenta_esissan_anatomia($data_controller){
        $this->db->trans_start();
        $param          =   array(
                                #IN 
                                array( 
                                    'name'      =>  ':V_OPCION',
                                    'value'     =>  $data_controller['ind_opcion'],
                                    'length'    =>  50,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_EMPRESA',
                                    'value'     =>  $data_controller['empresa'],
                                    'length'    =>  50,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_RUN',
                                    'value'     =>  $data_controller['run'],
                                    'length'    =>  50,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_DV',
                                    'value'     =>  $data_controller['dv'],
                                    'length'    =>  50,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':C_GETUSERS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #out cursores
                                array( 
                                    'name'      =>  ':C_PRIVILEGIOS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_PRIVILEGIOS_USER',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_ESTABLECIMIENTOS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_ESTABLECIMIENTOS_USER',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_PTO_ENREGA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_PTO_ENREGA_USER',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_LOGS',
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
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_CUENTAS_ESISSAN','LOAD_GESTION_USUARIOS',$param);
        $this->db->trans_complete();
        return array(
            'return_bd'                         =>  $result,
        );
    }
    
    public function grabaUsu($user,$nombres,$apepate,$apemate,$email,$pass,$arrPrivilegios,$arrEmpresas,$uID,$changePw,$activo,$superUser,$actualiza_pass,$arr_fe_user) {
        $this->db->trans_start();
        
        $rut            =   explode('-', $user);
        $rutS           =   $rut[0];
        $rutDV          =   $rut[1];
        $name           =   $nombres . ' ' . $apepate . ' ' . $apemate;


        $query0         =   $this->db->query("select USERNAME FROM $this->ownGu.FE_USERS WHERE ID_UID = ".$uID);
        $query0         =   $query0->result_array();

        if ($query0) {
            //Edita si Existe el Usuario
            $dataUp     =   array(
                'FIRST_NAME'            =>  $nombres,
                'MIDDLE_NAME'           =>  $apepate,
                'LAST_NAME'             =>  $apemate,
                'EMAIL'                 =>  $email,
                'NAME'                  =>  $name,
                'DISABLE'               =>  $activo,
                'STATUS'                =>  $superUser,
                'TX_INTRANETSSAN_RUN'   =>  $rutS,
                'TX_INTRANETSSAN_DV'    =>  $rutDV
            );
            if ($actualiza_pass == 1) {
                $this->db->set('PASSWORD', $pass);
                $this->db->set('LOCKTODOMAIN', $pass);
                $this->db->set('DAYLIGHT', 1);
            }
            $this->db->where('ID_UID', $uID);
            $this->db->update($this->ownGu . '.FE_USERS', $dataUp);

        } else {
            //Crea nuevo Usuario


            $uID                        =   $this->db->sequence($this->ownGu, 'SEQ_FE_USERS');
            $dataUs                     =   array(
                'ID_UID'                =>  $uID,
                'USERNAME'              =>  strtoupper($user),
                'FIRST_NAME'            =>  $nombres,
                'MIDDLE_NAME'           =>  $apepate,
                'LAST_NAME'             =>  $apemate,
                'EMAIL'                 =>  $email,
                'TELEPHONE'             =>  0,
                'PASSWORD'              =>  $pass,
                'LOCKTODOMAIN'          =>  $pass,
                'DISABLE'               =>  $activo,
                'NAME'                  =>  $name,
                'STATUS'                =>  $superUser,
                'TX_INTRANETSSAN_RUN'   =>  $rutS,
                'TX_INTRANETSSAN_DV'    =>  $rutDV,
                'DAYLIGHT'              =>  1
            );
            $this->db->insert($this->ownGu . '.FE_USERS', $dataUs);

            
        }


        $this->db->set('IND_ESTADO',0);
        $this->db->where('ID_UID',$uID);
        $this->db->update($this->ownGu.'.GU_TUSUTIENEPER');

        
        for ($i = 0; $i < count($arrPrivilegios); $i++) {
            $idPer      =   $arrPrivilegios[$i]["vDestino"];
            $queryRes   =   $this->db->query("SELECT ID_UTP FROM $this->ownGu.GU_TUSUTIENEPER WHERE PER_ID IN (".$idPer.") AND ID_UID  = ".$uID);
            $queryRes   =   $queryRes->result_array();
            if ($queryRes){
                //Edita Privilegios Existentes
                $this->db->set('IND_ESTADO', 1);
                $this->db->where('ID_UTP', $queryRes[0]['ID_UTP']);
                $this->db->update($this->ownGu . '.GU_TUSUTIENEPER');
            } else {
                //Inserta Nuevos Privilegios 
                $idSeqPriv = $this->db->sequence($this->ownGu, 'SEQ_GU_TUSUTIENEPER');
                $dataUsuPer[$i]     =   array(
                    'ID_UTP'        =>  $idSeqPriv,
                    'ID_UID'        =>  $uID,
                    'PER_ID'        =>  $arrPrivilegios[$i]["vDestino"],
                    'IND_ESTADO'    =>  1,
                );
                $this->db->insert($this->ownGu . '.GU_TUSUTIENEPER', $dataUsuPer[$i]);
            }
        }

        //Actualiza o Agrega Nuevas Empresas al Usuario
        $this->db->set('IND_ESTADO', 0);
        $this->db->where('ID_UID', $uID);
        $this->db->update($this->ownGu . '.GU_TUSUXEMPRESA');
        for ($i = 0; $i < count($arrEmpresas); $i++) {
            $idEmp          =   $arrEmpresas[$i]["vDestinoEstab"];
            $queryResD      =   $this->db->query("SELECT ID_UXE FROM $this->ownGu.GU_TUSUXEMPRESA WHERE COD_ESTABL IN (".$idEmp.") AND ID_UID = ".$uID);
            $queryResD      =   $queryResD->result_array();
            if ($queryResD) {
                //Edita Establecimientos Existentes
                $this->db->set('IND_ESTADO', 1);
                $this->db->where('ID_UXE', $queryResD[0]['ID_UXE']);
                $this->db->update($this->ownGu . '.GU_TUSUXEMPRESA');
            } else {
                //Inserta Nuevos Establecimientos 
                $idSeqEmp = $this->db->sequence($this->ownGu, 'SEQ_GU_TUSUXEMPRESA');
                $dataUsuEmpr[$i]    =   array(
                    'ID_UXE'        =>  $idSeqEmp,
                    'ID_UID'        =>  $uID,
                    'COD_ESTABL'    =>  $arrEmpresas[$i]["vDestinoEstab"],
                    'IND_ESTADO'    =>  1
                );
                $this->db->insert($this->ownGu . '.GU_TUSUXEMPRESA', $dataUsuEmpr[$i]);
            }
        }
        
        /*
        #HISTORIAL
        $data_histo                 =   array(
            'ID_HISUSER'            =>  $this->db->sequence($this->ownGu, 'SEQ_FE_HISUSER'),
            'DATE_CREA'             =>  'SYSDATE',
            'IND_ESTADO'            =>  '1',
            'USERNAME_SESION'       =>  $this->session->userdata("USERNAME"),
            'COD_ESTAB'             =>  $this->session->userdata("COD_ESTAB"),
            'ID_UID_EDITADO'        =>  $uID,
            'ID_UID_FIRMA'          =>  $arr_fe_user->ID_UID,
        );
        $this->db->insert($this->ownGu . '.FE_HISUSER', $data_histo);
        */

        $this->db->trans_complete();
        return $this->db->trans_status();
    }


    public function get_cambio_fecha($DATA){
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
                                    'name'      =>  ':V_PASS',
                                    'value'     =>  $DATA["pass"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_ID',
                                    'value'     =>  $DATA["id"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_NEWFECHA',
                                    'value'     =>  $DATA["fecha"],
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
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','UPDATE_FECHA_TOMADA',$param);
        $this->db->trans_complete();
        return array(
            'status'                            =>  true,
            'data_bd'                           =>  $result,
        );
    }

    public function get_cambio_fecha2($aData) {
        $this->db->trans_start();
        $empresa = $aData['empresa'];
        $V_ID = $aData['id']; 
        $V_DATE_INICIOREGISTRO = $aData['fecha']; 
        $valida = $aData['valida']; 
        $current_date = date('Y-m-d H:i:s');
        $this->db->set('DATE_INICIOREGISTRO', "STR_TO_DATE('$V_DATE_INICIOREGISTRO', '%d-%m-%Y %H:%i')", false);
        $this->db->set('FEC_AUDITA', $current_date);
        // $this->db->set('ID_UID_AUDITA', $valida[0]['ID_UID']); // Descomentarlo si es necesario
        $this->db->where('ID_SOLICITUD_HISTO', $V_ID);
        $this->db->update($this->ownPab . '.PB_SOLICITUD_HISTO');
        $this->db->trans_complete();
        return array(
            'status' => $this->db->trans_status(),
        );
    }

    public function record_newsubpunto_tomamuestra($aData){
        $this->db->trans_start();
        $id_unico = $this->db->sequence($this->own,'SEQ_INFOROTULADO_SUB');
        $this->db->insert($this->ownPab.'.PB_INFOROTULADO_SUB',array(
            'ID_ROTULADO_SUB'   =>  $id_unico,
            'ID_ROTULADO'       =>  $aData['ID_ROTULADO'],
            'COD_EMPRESA'       =>  $aData['empresa'],
            'TXT_OBSERVACION'   =>  $aData['txt_nombresubtuoi'],
            'IND_ESTADO'        =>  "1",
            'DATE_CREA'         =>  "SYSDATE",
            'ID_UID'            =>  $aData['uid']->ID_UID,
        ));
        $this->db->trans_complete();
        return array(
            'status' => $this->db->trans_status(),
        );
    }

    public function busqueda_lista_sub($aData){
        $empresa = $aData['empresa'];
        $ID_ROTULADO = $aData['ID_ROTULADO']; 
        return $this->db->query("SELECT 
                                    S.*,
                                    TO_CHAR(S.DATE_CREA,'DD-MM-YYYY hh24:mi') AS DATE_CREACION 
                                FROM 
                                    PABELLON.PB_INFOROTULADO_SUB S 
                                WHERE  
                                    S.ID_ROTULADO IN ($ID_ROTULADO) AND 
                                    S.IND_ESTADO IN (1) AND 
                                    S.COD_EMPRESA IN ($empresa) 
                                ")->result_array();
    }

    public function delete_sub_punto($aData){
        $this->db->trans_start();
        $empresa = $aData['empresa'];
        $id_sub_grupo = $aData['id_sub_grupo']; 
        $this->db->where('ID_ROTULADO_SUB',$id_sub_grupo);
        $this->db->update($this->ownPab.'.PB_INFOROTULADO_SUB',array(
            "IND_ESTADO"        =>  0,
            "DATE_AUDITA"       =>  'SYSDATE',
            'ID_UID_AUDITA'     =>  $aData['uid']->ID_UID,
        ));
        $this->db->trans_complete();
        return array(
            'status' => $this->db->trans_status(),
        );
    }

    public function model_marca_pto_toma_muestra($aData){
        $this->db->trans_start();
        $this->db->where('ID_ROTULADO',$aData['id_toma_muestras']);
        $this->db->update($this->ownPab.'.PB_INFOROTULADO',array(
            "IND_ESTADISTICA"   =>  $aData['ind_marca'],
            //"DATE_AUDITA"     =>  'SYSDATE',
            //"ID_UID_AUDITA"   =>  $aData['uid']->ID_UID,
        ));
        $this->db->trans_complete();
        return array(
            'status' => $this->db->trans_status(),
        );
    }

    public function model_update_nombre_pto($aData){
        $this->db->trans_start();
        $this->db->where('ID_ROTULADO',$aData['id']);
        $this->db->update($this->ownPab.'.PB_INFOROTULADO',array("TXT_OBSERVACION"=>$aData['nombre']));
        $this->db->trans_complete();
        return array(
            'status' => $this->db->trans_status(),
        );
    }

    public function get_elimina_solicitud_anatomia_ext($empresa, $session, $idanatomia, $valida) {
        $this->db->trans_start();
        $out_borreano = true;
        $txt_out = '';
        $current_date = date('Y-m-d H:i:s');
        $this->db->where('ID_SOLICITUD_HISTO', $idanatomia); 
        $this->db->update($this->GESPAB . '.PB_SOLICITUD_HISTO', array(
            "IND_ESTADO" => 0,
            "ID_UID_CANCELA" => $valida->ID_UID,
            "FEC_CANCELA" => $current_date,
            "LAST_USR_AUDITA" => $session[0],
            "LAST_DATE_AUDITA" => $current_date,
        ));
        $this->db->where('ID_SOLICITUD_HISTO', $idanatomia); 
        $this->db->update($this->GESPAB . '.PB_HISTO_NMUESTRAS', array("IND_ESTADO" => 0));
        $this->db->trans_complete();
        return array(
            'STATUS'     => $out_borreano,
            'ID_ANATOMIA'=> $empresa,
            'TXT_OUT'    => $txt_out,
        );
    }

}



        // ZONA DE CONSULTAS DE ANATOMIA
        /*
        $P_ANATOMIA_PATOLOGICA_MAIN = $this->db->query("SELECT 
                P.COD_EMPRESA,
                CASE
                    WHEN P.ID_ROTULADO_SUB = '' THEN ''
                    ELSE CONCAT(' / ', (
                        SELECT F.TXT_OBSERVACION 
                        FROM ADMIN.PB_INFOROTULADO_SUB F
                        WHERE F.ID_ROTULADO_SUB = P.ID_ROTULADO_SUB LIMIT 1
                    ))
                END AS TXT_SUBDIVISION,
                CASE
                    WHEN P.COD_EMPRESA IN ('100','303','301','304','300','103','102','105') THEN 'H.MAURICIO HEYERMANN T.ANGOL'
                    WHEN P.COD_EMPRESA IN ('106','318','104','108','107','302') THEN 'SAN JOSE DE VICTORIA'
                    ELSE 'SERVICIO DE SALUD ARAUCANIA NORTE'
                END AS TXT_HOSPDERIVADO,
                CASE
                    WHEN P.COD_EMPRESA IN ('100','303','301','304','300','103','102','105') THEN '100'
                    WHEN P.COD_EMPRESA IN ('106','318','104','108','107','302') THEN '106'
                    ELSE '029'
                END AS COD_EMPRESA_DERIVADA,
                CASE
                    WHEN P.COD_ESTABLREF = ? THEN (
                        SELECT G.NOM_RAZSOC
                        FROM ADMIN.SS_TEMPRESAS G
                        WHERE G.COD_EMPRESA = P.COD_EMPRESA LIMIT 1
                    )
                    ELSE ''
                END AS TXT_EMPRESA_DERIVADA,
                IF(P.IND_USOCASSETTE = '1', 'SI', IF(P.IND_USOCASSETTE = '0', 'NO', '--')) AS TXT_USOCASSETTE,
                P.IND_USOCASSETTE,
                P.IND_TEMPLATE AS TXT_PLANTILLA,
                DATE_FORMAT(P.DATE_NOTIFICACANCER, '%d-%m-%Y %H:%i') AS DATE_NOTIFICACANCER,
                (SELECT CONCAT(F.FIRST_NAME, ' ', F.MIDDLE_NAME, ' ', F.LAST_NAME) 
                FROM ADMIN.FE_USERS F
                WHERE F.ID_UID = P.ID_UID_RC_NOTIFICA_CANCER LIMIT 1) AS TXT_NOTIFICA_CANCER,
                (SELECT CONCAT(F.FIRST_NAME, ' ', F.MIDDLE_NAME, ' ', F.LAST_NAME) 
                FROM ADMIN.FE_USERS F
                WHERE F.ID_UID = P.ID_UID_NOTIFICA_CANCER LIMIT 1) AS TXT_RECIBE_NOTIFICA_CANCER,
                CASE
                    WHEN P.ID_HISTO_ZONA = 8 THEN (
                        SELECT F.IMG_DATA 
                        FROM ADMIN.PB_FIRMAMEDICO F
                        WHERE F.IND_ESTADO = 1 AND F.ID_PROFESIONAL = P.ID_PROFESIONAL LIMIT 1
                    )
                    ELSE NULL
                END AS CLOB_FIRMA,
                CASE
                    WHEN P.IND_TIPO_BIOPSIA = 4 AND P.ID_HISTO_ZONA = 8 THEN (
                        SELECT F.IMG_DATA 
                        FROM ADMIN.PB_FIRMAMEDICO F
                        WHERE F.IND_ESTADO = 1 AND F.ID_PROFESIONAL = P.ID_PROFESIONAL_CITOLOGICO LIMIT 1
                    )
                    ELSE NULL
                END AS CLOB_FIRMA_CITO,
                P.IND_CONF_CANCER,
                P.NUM_NOF_CANCER,
                P.IND_CONF_PAG,
                P.TXT_DIAG_CITOLOGIA,
                P.NUM_CO_CITOLOGIA,
                P.NUM_CO_PAP,
                IFNULL(P.NUM_INTERNO_AP, 0) AS NUM_INTERNO_AP,
                P.TXT_CITOLOGICO,
                
                (SELECT CONCAT(UPPER(PAT.NOM_NOMBRE), ' ', UPPER(PAT.NOM_APEPAT), ' ', UPPER(PAT.NOM_APEMAT), '<br>', PAT.COD_RUTPRO, '-', PAT.COD_DIGVER)
                FROM ADMIN.GG_TPROFESIONAL PAT
                WHERE PAT.ID_PROFESIONAL = P.ID_PROFESIONAL LIMIT 1) AS TXT_USER_PATOLOGO,

                (SELECT CONCAT(UPPER(PAT.NOM_NOMBRE), ' ', UPPER(PAT.NOM_APEPAT), ' ', UPPER(PAT.NOM_APEMAT), '<br>', PAT.COD_RUTPRO, '-', PAT.COD_DIGVER)
                FROM ADMIN.GG_TPROFESIONAL PAT
                WHERE PAT.ID_PROFESIONAL = P.ID_PROFESIONAL_CITOLOGICO LIMIT 1) AS TXT_USER_PATOLOGO_CITOLOGICO,

                P.TXT_DESC_MACROSCOPICA AS TXT_DESC_MACROSCOPICA,
                P.TXT_DIADNOSTICO_AP AS TXT_DIADNOSTICO_AP,
                '' AS TXT_DESC_CITOLOGICO,
                P.TXT_DESC_MACROSCOPICA AS TXT_DESC_MACROSCOPICA,
                (SELECT CONCAT(F.FIRST_NAME, ' ', F.MIDDLE_NAME, ' ', F.LAST_NAME, '#', F.USERNAME)
                FROM ADMIN.FE_USERS F
                WHERE F.ID_UID = P.ID_UID_TRASPORTE_OK LIMIT 1) AS TXT_USER_TRASPORTE_FIRMA,
                (SELECT CONCAT(F.FIRST_NAME, ' ', F.MIDDLE_NAME, ' ', F.LAST_NAME, '#', F.USERNAME)
                FROM ADMIN.FE_USERS F
                WHERE F.ID_UID = P.ID_UID_RECEPCIONA_OK LIMIT 1) AS TXT_USER_RECPCIONA_FIRMA,
                P.ID_UID_RECEPCIONA_OK,
                DATE_FORMAT(P.DATE_TRASLADO, '%d-%m-%Y') AS FECHA_TRASLADO,
                DATE_FORMAT(P.DATE_TRASLADO, '%H:%i') AS HORA_TRASLADO,
                P.ID_UID_TRASLADO,
                P.ID_USER_TRASLADO,
                (SELECT CONCAT(F.FIRST_NAME, ' ', F.MIDDLE_NAME, ' ', F.LAST_NAME) 
                FROM ADMIN.FE_USERS F
                WHERE F.ID_UID = P.ID_UID_TRASLADO LIMIT 1) AS TXT_USER_TRASPORTE,
                S.NOM_RAZSOC AS TXT_HOSPITAL_ETI,
                (SELECT CONCAT(F.FIRST_NAME, ' ', F.MIDDLE_NAME, ' ', F.LAST_NAME) 
                FROM ADMIN.PB_LINETIME_HISTO L, ADMIN.FE_USERS F
                WHERE L.ID_SOLICITUD_HISTO = P.ID_SOLICITUD_HISTO
                AND L.IND_ESTADO = 1
                AND L.NUM_FASE = 2
                AND L.ID_UID = F.ID_UID LIMIT 1) AS TXT_USER_TRASPORTE,
                (SELECT CONCAT(F.FIRST_NAME, ' ', F.MIDDLE_NAME, ' ', F.LAST_NAME) 
                FROM ADMIN.PB_LINETIME_HISTO L, ADMIN.FE_USERS F
                WHERE L.ID_SOLICITUD_HISTO = P.ID_SOLICITUD_HISTO
                AND L.IND_ESTADO = 1
                AND L.NUM_FASE = 3
                AND L.ID_UID = F.ID_UID LIMIT 1) AS TXT_USER_RECEPCION,
                (SELECT COUNT(M.ID_NMUESTRA) FROM ADMIN.PB_HISTO_NMUESTRAS M
                WHERE M.ID_SOLICITUD_HISTO = P.ID_SOLICITUD_HISTO
                AND M.IND_ESTADO = 1) AS N_MUESTRAS,
                DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i') AS FEC_EMISION,
                CONCAT(L.COD_RUTPAC, '-', L.COD_DIGVER, ' ', L.NUM_IDENTIFICACION) AS RUTPACIENTE,
                L.COD_RUTPAC AS COD_RUTPAC,
                L.COD_DIGVER AS COD_DIGVER,
                L.NUM_IDENTIFICACION AS NUM_IDENTIFICACION,
                L.IND_TISEXO AS IND_TISEXO,
                FLOOR(TIMESTAMPDIFF(MONTH, L.FEC_NACIMI, NOW()) / 12) AS NUMEDAD,
                DATE_FORMAT(L.FEC_NACIMI, '%d-%m-%Y') AS NACIMIENTO,
                FLOOR(TIMESTAMPDIFF(MONTH, L.FEC_NACIMI, NOW()) / 12) AS EDAD,
                CONCAT(UPPER(L.NOM_NOMBRE), ' ', UPPER(L.NOM_APEPAT), ' ', UPPER(L.NOM_APEMAT), 
                    CASE WHEN L.NOM_SOCIAL IS NULL THEN '' ELSE CONCAT(', social: ', L.NOM_SOCIAL) END) AS NOMBRE_COMPLETO,
                CONCAT(SUBSTR(L.NOM_NOMBRE, 1, 1), '.', UPPER(L.NOM_APEPAT), ' ', UPPER(L.NOM_APEMAT)) AS TXTNOMCIRUSMALL,
                CONCAT(UPPER(L.NOM_NOMBRE), ' ', UPPER(L.NOM_APEPAT), ' ', UPPER(SUBSTR(L.NOM_APEMAT, 1, 1))) AS TXTPRIMERNOMBREAPELLIDO,
                CASE
                    WHEN P.COD_EMPRESA = 1000 THEN (
                        SELECT E.NUM_NFICHA
                        FROM ADMIN.SO_TCPACTE E
                        WHERE E.NUM_FICHAE = P.NUM_FICHAE AND E.COD_EMPRESA = 100 LIMIT 1
                    )
                    ELSE (
                        SELECT E.NUM_NFICHA
                        FROM ADMIN.SO_TCPACTE E
                        WHERE E.NUM_FICHAE = P.NUM_FICHAE AND E.COD_EMPRESA = P.COD_EMPRESA LIMIT 1
                    )
                END AS FICHAL,
                
                (SELECT A.NOM_PREVIS
                FROM ADMIN.GG_TDATPREV A, ADMIN.SO_TTITUL B, ADMIN.GG_TGPACTE C, ADMIN.GG_TINSEMP D
                WHERE A.IND_PREVIS = B.IND_PREVIS
                AND B.COD_RUTTIT = C.COD_RUTTIT
                AND B.NUM_RUTINS = D.COD_RUTINS
                AND C.NUM_FICHAE = P.NUM_FICHAE
                AND A.IND_ESTADO = 'V') AS TXT_PREVISION,

                CONCAT(UPPER(G.NOM_NOMBRE), ' ', UPPER(G.NOM_APEPAT), ' ', UPPER(G.NOM_APEMAT)) AS PROFESIONAL,
                CONCAT(G.NOM_APEPAT, ' ', G.NOM_APEMAT, ' ', G.NOM_NOMBRE) AS PROFESIONAL_2,
                CONCAT(G.COD_RUTPRO, '-', G.COD_DIGVER) AS RUT_PROFESIOAL,
                G.COD_RUTPRO AS ID,
                G.COD_DIGVER AS DV,
                G.COD_TPROFE AS MEDI,
                DATE_FORMAT(P.DATE_INICIOREGISTRO, '%d-%m-%Y %H:%i') AS FECHA_SOLICITUD,
                DATE_FORMAT(P.FEC_USRCREA_RECEP, '%d-%m-%Y') AS FECHA_RECEPCION,
                DATE_FORMAT(P.FEC_USRCREA_RECEP, '%Y') AS FECHA_YEAR_RECEPCION,
                DATE_FORMAT(P.FEC_USRCREA_RECEP, '%H:%i') AS HORA_RECEPCION,
                DATE_FORMAT(P.DATE_FECHA_DIAGNOSTICO, '%d-%m-%Y %H:%i') AS DATE_FECHA_DIAGNOSTICO,
                DATE_FORMAT(P.DATE_IMPRESION_INFORME, '%d-%m-%Y') AS FECHA_IMREPSION_INFORME,
                DATE_FORMAT(P.DATE_ENTREGA_INFORME, '%d-%m-%Y %H:%i') AS FECHA_ENTREGA_INFORME,
                P.PA_ID_PROCARCH,
                CASE
                    WHEN P.PA_ID_PROCARCH = '31' THEN 'PABELLÓN CENTRAL'
                    WHEN P.PA_ID_PROCARCH = '63' THEN 'RCE ESPECIALIDADES'
                    WHEN P.PA_ID_PROCARCH = '65' THEN 'MODULO ANATOMIA'
                    ELSE 'NO INFORMADO'
                END AS TXT_PROCEDENCIA,
                CASE
                    WHEN P.PA_ID_PROCARCH = '31' THEN (
                        SELECT CONCAT(DATE_FORMAT(PP.FEC_INICIO_SOLICITUD, '%d-%m-%Y %H:%i'), ' - ', SS.SALA_DESCRIPCION)
                        FROM ADMIN.PB_TABLAOPERATORIA PP, ADMIN.PB_SALA_PABELLON SS
                        WHERE PP.COD_PABELLON = SS.COD_PABELLON AND PP.ID_TABLA = P.ID_TABLA LIMIT 1
                    )
                    ELSE 'NO INFORMADO'
                END AS INFO_GESPAB,
                '' AS TXT_SALAPAB,
                '' AS TXT_FECIRU,
                P.ID_SERDEP AS ID_SERVICIO,
                CASE
                    WHEN P.COD_EMPRESA IN ('100', '106', '029') THEN (
                        SELECT S.NOM_SERVIC
                        FROM ADMIN.GG_TSERVICIOXEMP T, ADMIN.GG_TSERVICIO S
                        WHERE T.ID_SERDEP = P.ID_SERDEP
                        AND T.COD_EMPRESA = P.COD_EMPRESA
                        AND S.ID_SERDEP = T.ID_SERDEP LIMIT 1
                    )
                    ELSE (
                        SELECT S.NOM_SERVIC
                        FROM ADMIN.GG_TSERVICIOXEMP T, ADMIN.GG_TSERVICIO S
                        WHERE T.ID_SERDEP = P.ID_SERDEP
                        AND T.COD_EMPRESA = P.COD_ESTABLREF
                        AND S.ID_SERDEP = T.ID_SERDEP LIMIT 1
                    )
                END AS NOMBRE_SERVICIO,
                P.ID_SOLICITUD_HISTO AS ID_SOLICITUD,
                P.TXT_DIAGNOSTICO AS TXT_DIAGNOSTICO,
                DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i') AS FEC_EMISION,
                DATE_FORMAT(P.FEC_USRCREA, '%d-%m-%Y %H:%i') AS FECHA_SOLICITUD,
                DATE_FORMAT(P.DATE_INICIOREGISTRO, '%d-%m-%Y %H:%i') AS FECHA_TOMA_MUESTRA,
                CASE P.IND_TIPO_BIOPSIA
                    WHEN '1' THEN 'SI'
                    WHEN '2' THEN 'CONTEMPORANEA'
                    WHEN '3' THEN 'DIFERIDA'
                    WHEN '4' THEN 'BIOPSIA + CITOLOGÍA'
                    WHEN '6' THEN 'CITOLOGÍA PAP'
                    WHEN '5' THEN 'SOLO CITOLOGÍA'
                    ELSE 'NO INFORMADO'
                END AS TIPO_DE_BIOPSIA,
                P.IND_TIPO_BIOPSIA AS IND_TIPO_BIOPSIA,
                CASE P.IND_ESTADO
                    WHEN '1' THEN 'SOLICITUD ACTIVA'
                    WHEN '0' THEN 'SOLICITUD DESHABILITADA'
                    ELSE 'NO INFORMADA'
                END AS TXT_ESTADO,
                P.DES_SITIOEXT,
                P.DES_UBICACION,
                P.DES_TAMANNO,
                CASE P.ID_TIPO_LESION
                    WHEN '1' THEN 'LIQUIDO'
                    WHEN '2' THEN 'ORGANO'
                    WHEN '3' THEN 'TEJIDO'
                    ELSE 'NO INFORMADO'
                END AS TXT_TIPOSESION,
                CASE P.ID_ASPECTO
                    WHEN '1' THEN 'INFLAMATORIA'
                    WHEN '2' THEN 'BENIGNA'
                    WHEN '3' THEN 'NEOPLASICA'
                    ELSE 'NO INFORMADO'
                END AS TXT_ASPECTO,
                CASE P.ID_ANT_PREVIOS
                    WHEN '1' THEN 'NO'
                    WHEN '2' THEN 'BIOPSIA'
                    WHEN '3' THEN 'CITOLOGIA'
                    ELSE 'NO INFORMADO'
                END AS TXT_ANT_PREVIOS,
                P.ID_ANT_PREVIOS,
                P.NUM_ANTECEDENTES,
                P.DES_BIPSIA,
                P.DES_CITOLOGIA,
                P.DES_OBSERVACIONES,
                P.NUM_FICHAE,
                P.COD_USRCREA,
                P.FEC_USRCREA,
                P.COD_EMPRESA,
                P.DES_SITIOEXT,
                P.DES_UBICACION,
                P.DES_TAMANNO,
                P.ID_TIPO_LESION,
                P.ID_ASPECTO,
                P.ID_ANT_PREVIOS,
                P.NUM_ANTECEDENTES,
                P.DES_BIPSIA,
                P.DES_CITOLOGIA,
                P.DES_OBSERVACIONES,
                P.IND_ESTADO,
                P.FEC_REVISION,
                P.ID_TABLA,
                P.DES_TIPOMUESTRA,
                P.NUM_SUBNUMERACION,
                P.COD_USRCREA_TO_MUE,
                P.FEC_USRCREA_TO_MUE,
                P.COD_USRCREA_ENV,
                P.FEC_USRCREA_ENV,
                P.COD_USRCREA_RECEP,
                P.FEC_USRCREA_RECEP,
                P.COD_EMPRESA_RECEP,
                P.COD_USRCREA_INFORMADA,
                P.FEC_USRCREA_INFORMADA,
                P.COD_EMPRESA_INFORMADA,
                P.ID_ARCHIVO_SUBIDO,
                P.COD_USRCREA_RECH,
                P.FEC_USRCREA_RECH,
                P.COD_EMPRESA_RECH,
                P.TIPO_RECHAZO,
                P.OBS_RECHAZO,
                P.ID_HISTO_ESTADO,
                P.AD_ID_ADMISION,
                P.ID_SERDEP,
                P.IND_TIPO_BIOPSIA,
                P.IND_TEMPLATE,
                P.DATE_INICIOREGISTRO,
                P.COD_RUTPRO,
                P.TXT_DIAGNOSTICO,
                P.NUM_PLANTILLA,
                P.IND_USOCASSETTE,
                P.IND_USOCASSETTE
            FROM
                ADMIN.GG_TGPACTE L,
                ADMIN.GG_TPROFESIONAL G,
                ADMIN.PB_SOLICITUD_HISTO P,
                ADMIN.SS_TEMPRESAS S
            WHERE
                P.ID_SOLICITUD_HISTO = ?
                AND P.NUM_FICHAE = L.NUM_FICHAE
                AND P.COD_RUTPRO = G.COD_RUTPRO
                AND S.COD_EMPRESA = P.COD_EMPRESA
                AND P.IND_ESTADO = 1
            ORDER BY
                P.DATE_INICIOREGISTRO
        ", array($V_COD_EMPRESA, $V_ID_HISTO))->result_array();
        */



        

        // MAIN DE MUESTRAS

        /*
        $P_ANATOMIA_PATOLOGICA_MUESTRAS = $this->db->query("SELECT 
                '0' AS TOTAL_MUESTRAS,
                CASE ?
                    WHEN '100' THEN 'H.MAURICIO HEYERMANN T.ANGOL'
                    WHEN '106' THEN 'SAN JOSE DE VICTORIA'
                    WHEN '029' THEN 'SERVICIO DE SALUD ARAUCANIA NORTE'
                    WHEN '800' THEN 'CLINICA ANATOMIA'
                    WHEN '1000' THEN 'HOSPITAL MILITAR'
                    ELSE 'SERVICIO DE SALUD ARAUCANIA NORTE'
                END AS TXT_HOSPITAL_ETI,
                M.IND_ESTADO_CU,
                M.ID_NUM_CARGA,
                NULL AS ID_TABLA,
                M.IND_ESTADO AS ESTADO,
                M.ID_NMUESTRA AS ID_NMUESTRA,
                M.N_MUESTRA AS N_MUESTRA,
                UPPER(M.TXT_MUESTRA) AS TXT_MUESTRA,
                UPPER(M.TXT_DESC_MICROSCOPICA) AS TXT_DESC_MICROSCOPICA,
                UPPER(M.TXT_DESC_MACROSCOPICA) AS TXT_DESC_MACROSCOPICA,
                M.IND_ESTADO_REG AS IND_ESTADO_REG,
                M.IND_TIPOMUESTRA AS IND_TIPOMUESTRA,
                CASE
                    WHEN M.NUM_CASSETTE IS NULL THEN 0 ELSE M.NUM_CASSETTE
                END AS NUM_CASSETTE,
                M.ID_CASETE AS ID_CASETE,
                CASE
                    WHEN M.NUM_ML IS NULL THEN 0 ELSE M.NUM_ML
                END AS NUM_ML,
                CASE M.IND_ETIQUETA
                    WHEN 1 THEN 'PEQUEÑO'
                    WHEN 2 THEN 'MEDIANO'
                    ELSE 'NO INFORMADO'
                END AS TXT_ETIQUETA,
                CASE
                    WHEN M.IND_ETIQUETA IS NULL THEN 2 ELSE M.IND_ETIQUETA
                END AS IND_ETIQUETA,
                IFNULL(M.TXT_DESC_MICROSCOPICA, '') AS TXT_DESC_MICROSCOPICA,
                IFNULL(M.TXT_DESC_MACROSCOPICA, '') AS TXT_DESC_MACROSCOPICA
            FROM
                ADMIN.PB_HISTO_NMUESTRAS M
            WHERE
                M.ID_SOLICITUD_HISTO = ?
                AND M.IND_TIPOMUESTRA = 1
                AND M.IND_ESTADO = 1
            ORDER BY
                M.N_MUESTRA;
        ", array($V_COD_EMPRESA, $V_ID_HISTO))->result_array();
       

        
    
        // AP MUESTRAS CITOLOGIA
        $P_AP_MUESTRAS_CITOLOGIA = $this->db->query("SELECT 
                '0' AS TOTAL_MUESTRAS,
                CASE ?
                    WHEN '100' THEN 'H.MAURICIO HEYERMANN T.ANGOL'
                    WHEN '106' THEN 'SAN JOSE DE VICTORIA'
                    WHEN '029' THEN 'SERVICIO DE SALUD ARAUCANIA NORTE'
                    WHEN '1000' THEN 'HOSPITAL MILITAR'
                    ELSE 'SERVICIO DE SALUD ARAUCANIA NORTE'
                END AS TXT_HOSPITAL_ETI,
                M.IND_ESTADO_CU,
                M.ID_NUM_CARGA,
                NULL AS ID_TABLA,
                M.IND_ESTADO AS ESTADO,
                M.ID_NMUESTRA AS ID_NMUESTRA,
                M.N_MUESTRA AS N_MUESTRA,
                UPPER(M.TXT_MUESTRA) AS TXT_MUESTRA,
                UPPER(M.TXT_DESC_MICROSCOPICA) AS TXT_DESC_MICROSCOPICA,
                UPPER(M.TXT_DESC_MACROSCOPICA) AS TXT_DESC_MACROSCOPICA,
                M.IND_ESTADO_REG AS IND_ESTADO_REG,
                M.IND_TIPOMUESTRA AS IND_TIPOMUESTRA,
                CASE
                    WHEN M.NUM_CASSETTE IS NULL THEN 0 ELSE M.NUM_CASSETTE
                END AS NUM_CASSETTE,
                M.ID_CASETE AS ID_CASETE,
                CASE
                    WHEN M.NUM_ML IS NULL THEN 0 ELSE M.NUM_ML
                END AS NUM_ML,
                CASE M.IND_ETIQUETA
                    WHEN 1 THEN 'PEQUEÑO'
                    WHEN 2 THEN 'MEDIANO'
                    ELSE 'NO INFORMADO'
                END AS TXT_ETIQUETA,
                CASE
                    WHEN M.IND_ETIQUETA IS NULL THEN 2 ELSE M.IND_ETIQUETA
                END AS IND_ETIQUETA,
                IFNULL(M.TXT_DESC_MICROSCOPICA, '') AS TXT_DESC_MICROSCOPICA,
                IFNULL(M.TXT_DESC_MACROSCOPICA, '') AS TXT_DESC_MACROSCOPICA
            FROM
                ADMIN.PB_HISTO_NMUESTRAS M
            WHERE
                M.ID_SOLICITUD_HISTO = ?
                AND M.IND_TIPOMUESTRA = 2
                AND M.IND_ESTADO = 1
            ORDER BY
                M.N_MUESTRA;
        ", array($V_COD_EMPRESA, $V_ID_HISTO))->result_array();
        */


        
