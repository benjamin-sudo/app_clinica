<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class sql_class_hdial extends CI_Model {

    var $own         = 'ADMIN';
    var $pabellon    = 'PABELLON';
    var $ownGu       = 'GUADMIN';
    
    public function sqlgetbusquedaTabsMes($empresa,$indEstado){
        $sQuery = "SELECT 
                        H.ID_RMDIALISIS             AS ID, 
                        H.COD_RMDIALISIS, 
                        H.NOM_RMDIALISIS            AS TXT_DIAL, 
                        H.IND_ESTADO, 
                        H.NUM_SERIE, 
                        H.NUM_LORE, 
                        H.COD_EMPRESA
                    FROM  
                        $this->own.HD_RMDIALISIS H
                    WHERE
                            H.COD_EMPRESA           = '$empresa'  
                        AND H.IND_ESTADO            = 1 
                ";
         return $sQuery;
    }
    
    public function sql_Listadopermisosgenerados($empresa,$estados){
                
        $sQuery = "SELECT 
                    H.ID_PEDICION,
                    H.IND_PERMISO,
                    H.IND_ESTADO,
                    H.ID_TCORECION,
                    H.COD_USRCREA,
                    H.FEC_USRFEC,
                    H.ID_TDHOJADIARIA,
                    H.AD_ACTIVA
                FROM 
                    $this->own.HD_REGEDICION H
                    
                ";
        //$this->own.HD_RMDIALISIS H
        return $sQuery;
    }
    
    public function sqlbusquedaListadoPacienteHDial($empresa,$estados,$numFichae,$rutPac,$conIngresoC){
        
        $where          = '';
        if($conIngresoC == '1'){
        $where.=   "AND H.NUM_FICHAE NOT IN(
                        SELECT 
                            Z.NUM_FICHAE
                        FROM 
                            $this->own.HD_NPACIENTEXCUPO Z
                        WHERE 
                            Z.IND_ESTADO = 1 and Z.COD_EMPRESA = '$empresa'
                        )  
                    ";   
        }
        $sQuery = "SELECT 
                        H.ID_NUMINGRESO                                             AS ID_INGRESO, 
                        H.NUM_FICHAE                                                AS NUM_FICHAE,

                        H.ID_INGRESOHD                                              AS ID_FORMULARIO,

                        H.ID_SIC, 
                        H.COD_EMPRESA, 
                        H.COD_USRCREA, 
                        H.FEC_CREA, 
                        H.IND_ESTADO,
                        TO_CHAR(H.FEC_INGRESO, 'DD-MM-YYYY')                        AS FINGRESO,
                        H.DATE_HISTOINGRESO                                         AS FINGRESO_HISTO,
                        DECODE(H.IND_ESTADO,
                                            '1','VIGENTE',
                                            '2','ELIMINADO',
                                            '3','EGRESADO',
                                            'NO INFORMADO')                         AS TXTESTADO,

                        G.COD_RUTPAC||'-'||G.COD_DIGVER                             AS RUTPAC,
                        TRUNC(MONTHS_BETWEEN(SYSDATE,G.FEC_NACIMI)/12)              AS TXTEDAD,
                        G.NUM_CELULAR                                               AS CELULAR,
                        G.NOM_APEPAT||' '||G.NOM_APEMAT||' '||G.NOM_NOMBRE          AS NOM_APELLIDO,
                        G.NOM_NOMBRE||' '||G.NOM_APEPAT||' '||G.NOM_APEMAT          AS NOM_COMPLETO
                    FROM 
                        $this->own.HD_TINGRESO              H, 
                        $this->own.GG_TGPACTE               G
                    WHERE
                        H.COD_EMPRESA                       = '$empresa'
                    AND G.NUM_FICHAE                        = H.NUM_FICHAE
                        $where
                    AND H.IND_ESTADO                        = 1

                ";
         return $sQuery;
    }
    
    public function sqlNumDialEgresos($empresa,$numIgreso,$numfichae){
        $sQuery = "SELECT 
                        H.ID_CUPOXPACIENTE, 
                        H.COD_EMPRESA, 
                        H.NUM_FICHAE, 
                        H.NUM_INGRESO, 
                        H.ID_RMDIALISIS, 
                        H.ID_TURNOSXDIAS, 
                        H.COD_USRCREA, 
                        H.DATE_CREA, 
                        H.IND_ESTADO, 
                        H.COD_AUDITA, 
                        H.FEC_AUDITA
                    FROM 
                        $this->own.HD_NPACIENTEXCUPO H
                    WHERE
                        H.NUM_INGRESO   = $numIgreso
                        AND
                        NUM_FICHAE      = $numfichae
                        AND
                        IND_ESTADO      = 1
            ";
        return $sQuery ;
    }

    public function sqlPacientesxCupo($empresa){
        
        $sQuery = "SELECT 
                        H.ID_CUPOXPACIENTE                                          AS ID_CUPO,
                        UPPER(G.NOM_APEPAT||' '||G.NOM_APEMAT||' '|| G.NOM_NOMBRE)  AS NOMPAC,
                        G.COD_RUTPAC||'-'||G.COD_DIGVER                             AS RUTPAC,
                        TO_CHAR(G.FEC_NACIMI, 'DD-MM-YYYY')                         AS NACIMIENTO,
                        G.NUM_FICHAE                                                AS NUM_FICHAE,
                       
                        H.COD_EMPRESA                                               AS EMPRESA, 
                        H.NUM_INGRESO                                               AS NUM_INGRESO, 
                        H.ID_RMDIALISIS                                             AS MKN, 
                        H.ID_TURNOSXDIAS                                            AS TRN, 
                        H.COD_USRCREA, 
                        H.DATE_CREA, 
                        H.IND_ESTADO                                                AS IND_ESTADO
                    FROM 
                        $this->own.HD_NPACIENTEXCUPO                                H, 
                        $this->own.GG_TGPACTE                                       G
                    WHERE 
                            H.COD_EMPRESA                                           = '$empresa' 
                        AND G.NUM_FICHAE                                            = H.NUM_FICHAE
                        AND H.IND_ESTADO                                            = 1
                    ORDER BY MKN, TRN       
                ";
        return $sQuery;
    }
    
    public function profActvNuevaAgenda($empresa) {
        $sQuery = "
            SELECT
                A.COD_RUTPRO,  
                UPPER(A.NOM_APEPAT)||' '||UPPER(A.NOM_APEMAT)||' '||UPPER(A.NOM_NOMBRE)                 AS NOM_PROFE,
                C.DES_TIPOATENCION                                                                      AS DES_TIPOATENCION,
                A.COD_DIGVER                                                                            AS COD_DIGVER,
                B.COD_TPROFE                                                                            AS COD_TPROFE,
                B.NOM_TPROFE                                                                            AS NOM_TPROFE,
                C.IND_TIPOATENCION                                                                      AS IND_TIPOATENCION
            FROM
                $this->own.GG_TPROFESIONAL         A,
                $this->own.GG_TPROFESION           B,
                $this->own.AP_TTIPOATENCION        C,
                $this->own.AP_TPROFXESTABL         D
            WHERE
                A.IND_ESTADO                        =   'V'                   AND
                D.IND_ESTADO                        =   'V'                   AND
                A.COD_TPROFE                        =   B.COD_TPROFE          AND
                B.IND_TIPOATENCION                  =   C.IND_TIPOATENCION    AND
                A.COD_RUTPRO                        =   D.COD_RUTPRO          AND
                D.COD_EMPRESA                       =   '$empresa'
            ORDER BY
                C.IND_TIPOATENCION, A.NOM_APEPAT
            ";
        return $sQuery;
    }
    
    public function sqlPacientesxCupoxDia($empresa,$fecha,$num_Maquina){
        
        /* (SELECT 
                NUM_NFICHA 
            FROM 
                $this->own.SO_TCPACTE P
            WHERE 
                P.COD_RUTPAC    = G.COD_RUTPAC AND 
                P.COD_EMPRESA   = '$empresa')                           AS F_LOCAL,
        */
        $sQuery = "
                SELECT 
                    'NO INICIADO'                                               AS HRS_INICIO,
                    ''                                                          AS FECHA_DIAL,
                    ''                                                          AS ID_TDHOJADIARIA,
                    ''                                                          AS AD_ADMISION,
                    ''                                                          AS AD_CIERRE,
                    '' AS F_LOCAL,
                    UPPER(G.NOM_APEPAT||' '||G.NOM_APEMAT||' '|| G.NOM_NOMBRE)  AS NOMPAC,
                    G.COD_RUTPAC||'-'||G.COD_DIGVER                             AS RUTPAC,
                    TO_CHAR(G.FEC_NACIMI, 'DD-MM-YYYY')                         AS NACIMIENTO,
                    G.NUM_FICHAE                                                AS NUMFICHAE,

                    H.ID_CUPOXPACIENTE                                          AS ID_CUPO, 
                    H.COD_EMPRESA                                               AS EMPRESA, 
                    H.NUM_INGRESO                                               AS NUM_INGRESO,
                    H.ID_RMDIALISIS                                             AS MKN, 
                    H.ID_TURNOSXDIAS                                            AS TRN, 
                    H.COD_USRCREA, 
                    H.DATE_CREA, 
                    H.IND_ESTADO                                                AS IND_ESTADO
                    ,T.ID_NDIA                                                  AS DIA
                FROM 
                
                     ADMIN.HD_NPACIENTEXCUPO                                    H 
                    ,ADMIN.GG_TGPACTE                                           G
                    ,ADMIN.HD_TURNODIALISIS                                     T
                   
                WHERE 
                        H.COD_EMPRESA       = $empresa 
                    AND G.NUM_FICHAE        = H.NUM_FICHAE
                    AND H.ID_TURNOSXDIAS    = T.ID_TURNOSXDIAS 
                    AND H.ID_RMDIALISIS     = $num_Maquina
                    AND T.ID_NDIA           =   (
                                                    SELECT DECODE(RTRIM(LTRIM(TO_CHAR(TO_DATE('$fecha'),'DAY','NLS_DATE_LANGUAGE=SPANISH'))), 
                                                        'LUNES',        0, 
                                                        'MARTES',       1, 
                                                        'MIÉRCOLES',    2, 
                                                        'JUEVES',       3, 
                                                        'VIERNES',      4, 
                                                        'SÁBADO',       5, 
                                                        'DOMINGO',      6
                                                    )                   AS NUM_DIA
                                                    FROM DUAL
                                                )
                    ORDER BY MKN,TRN
                ";
        return $sQuery;
        
    }
    
    public function proBusquedaHoradiaria($empresa,$fecha,$num_Maquina){
        /*
           (SELECT   
                NUM_NFICHA  FROM   $this->own.SO_TCPACTE P
            WHERE 
                P.COD_RUTPAC    = G.COD_RUTPAC AND 
                P.COD_EMPRESA   = '$empresa') AS F_LOCAL,
                            
         */
        $sQuery = "
            
                SELECT 
                 
                    TO_CHAR(AD.AD_FHADMISION,'HH24:MI')                         AS HRS_INICIO,
                    TO_CHAR(AD.AD_FHADMISION, 'DD-MM-YYYY')                     AS FECHA_DIAL,
                    HD.ID_TDHOJADIARIA                                          AS ID_TDHOJADIARIA,
                    AD.AD_ID_ADMISION                                           AS AD_ADMISION,
                    CI.CI_ID_CIERRE                                             AS AD_CIERRE,
                    ''                                                          AS F_LOCAL,
                    UPPER(G.NOM_APEPAT||' '||G.NOM_APEMAT||' '|| G.NOM_NOMBRE)  AS NOMPAC,
                    G.COD_RUTPAC||'-'||G.COD_DIGVER                             AS RUTPAC,
                    TO_CHAR(G.FEC_NACIMI, 'DD-MM-YYYY')                         AS NACIMIENTO,
                    G.NUM_FICHAE                                                AS NUMFICHAE,
                    H.ID_CUPOXPACIENTE                                          AS ID_CUPO, 
                    H.COD_EMPRESA                                               AS EMPRESA, 
                    H.NUM_INGRESO                                               AS NUM_INGRESO,
                    H.ID_RMDIALISIS                                             AS MKN, 
                    H.ID_TURNOSXDIAS                                            AS TRN, 
                    H.COD_USRCREA, 
                    H.DATE_CREA, 
                    H.IND_ESTADO                                                AS IND_ESTADO,
                    ''                                                          AS DIA
                FROM 
                
                     ADMIN.HD_NPACIENTEXCUPO                                    H 
                    ,ADMIN.GG_TGPACTE                                           G
                    ,ADMIN.HD_TDHOJADIARIA                                      HD 
                    ,ADMIN.URG_TADMISION                                        AD
                    ,ADMIN.URG_TCIERRE                                          CI 
                   
                WHERE 
                            AD.AD_FHADMISION BETWEEN TO_DATE('$fecha 00:00:00','DD-MM-YYYY hh24:mi:ss') AND TO_DATE('$fecha 23:59:59','DD-MM-YYYY hh24:mi:ss') 
                        AND H.COD_EMPRESA                                        = $empresa 
                        AND HD.ID_RMDIALISIS                                    = $num_Maquina
                        AND AD.AD_ID_ADMISION                                   = CI.AD_ID_ADMISION(+)
                        AND AD.AD_ID_ADMISION                                   = HD.AD_ID_ADMISION 
                        AND AD.NUM_FICHAE                                       = HD.NUM_FICHAE 
                        AND H.NUM_FICHAE                                        = HD.NUM_FICHAE                          
                        AND G.NUM_FICHAE                                        = H.NUM_FICHAE
                    ";
    
             return $sQuery;
    }
    
    public function proBusquedaHoradiaria_profActvNuevaAgenda($empresa,$fecha,$num_Maquina){ 
        $sQuery =" 
            SELECT 
                CASE 
                    WHEN TO_CHAR(SYSDATE,'DD-MM') = TO_CHAR(G.FEC_NACIMI,'DD-MM')   
                    THEN '1' ELSE '0'
                END                                                                     AS IND_AYER,
                TO_CHAR (AD.AD_FHADMISION,'HH24:MI')                                    AS HRS_INICIO,
                TO_CHAR (AD.AD_FHADMISION,'DD-MM-YYYY')                                 AS FECHA_DIAL,
                HD.ID_TDHOJADIARIA                                                      AS ID_TDHOJADIARIA,
                AD.AD_ID_ADMISION                                                       AS AD_ADMISION,
                CI.CI_ID_CIERRE                                                         AS AD_CIERRE,
                UPPER (G.NOM_APEPAT || ' ' || G.NOM_APEMAT || ' ' || G.NOM_NOMBRE)      AS NOMPAC,
                G.COD_RUTPAC || '-' || G.COD_DIGVER                                     AS RUTPAC,
                TO_CHAR (G.FEC_NACIMI, 'DD-MM-YYYY')                                    AS NACIMIENTO,
                G.NUM_FICHAE                                                            AS NUMFICHAE,
                H.ID_CUPOXPACIENTE                                                      AS ID_CUPO,
                H.COD_EMPRESA                                                           AS EMPRESA,
                H.NUM_INGRESO                                                           AS NUM_INGRESO,
                H.ID_RMDIALISIS                                                         AS MKN,
                H.ID_TURNOSXDIAS                                                        AS TRN,
                H.COD_USRCREA,
                H.DATE_CREA,
                H.IND_ESTADO                                                            AS IND_ESTADO,
                NULL                                                                    AS DIA,
                HD.IND_HDESTADO                                                         AS CIERREHD
            FROM 
                ADMIN.HD_NPACIENTEXCUPO         H,
                ADMIN.GG_TGPACTE                G,
                ADMIN.HD_TDHOJADIARIA           HD,
                ADMIN.URG_TADMISION             AD,
                ADMIN.URG_TCIERRE               CI
           WHERE 
                AD.AD_FHADMISION 
                                BETWEEN 
                                    TO_DATE ('$fecha 00:00:00','DD-MM-YYYY hh24:mi:ss')
                                AND 
                                    TO_DATE ('$fecha 23:59:59','DD-MM-YYYY hh24:mi:ss')
                AND H.COD_EMPRESA                                               = $empresa
                AND HD.ID_RMDIALISIS                                            = $num_Maquina
                AND AD.AD_ID_ADMISION                                           = CI.AD_ID_ADMISION(+)
                AND AD.AD_ID_ADMISION                                           = HD.AD_ID_ADMISION
                AND AD.NUM_FICHAE                                               = HD.NUM_FICHAE
                AND H.NUM_FICHAE                                                = HD.NUM_FICHAE
                AND G.NUM_FICHAE                                                = H.NUM_FICHAE 
                AND H.IND_ESTADO                                                = 1
                AND AD.AD_ACTIVA                                                = 1
        UNION 
            SELECT
                NULL                                                            AS IND_AYER,
                NULL                                                            AS HRS_INICIO,
                NULL                                                            AS FECHA_DIAL,
                NULL                                                            AS ID_TDHOJADIARIA,
                NULL                                                            AS AD_ADMISION,
                NULL                                                            AS AD_CIERRE,
                UPPER(G.NOM_APEPAT||' '||G.NOM_APEMAT||' '||G.NOM_NOMBRE)       AS NOMPAC,
                G.COD_RUTPAC || '-' || G.COD_DIGVER                             AS RUTPAC,
                TO_CHAR (G.FEC_NACIMI, 'DD-MM-YYYY')                            AS NACIMIENTO,
                G.NUM_FICHAE                                                    AS NUMFICHAE,
                H.ID_CUPOXPACIENTE                                              AS ID_CUPO,
                H.COD_EMPRESA                                                   AS EMPRESA,
                H.NUM_INGRESO                                                   AS NUM_INGRESO,
                H.ID_RMDIALISIS                                                 AS MKN,
                H.ID_TURNOSXDIAS                                                AS TRN,
                H.COD_USRCREA,
                H.DATE_CREA,
                H.IND_ESTADO                                                    AS IND_ESTADO,
                T.ID_NDIA                                                       AS DIA,
                NULL                                                            AS CIERREHD
                
            FROM 
                ADMIN.HD_NPACIENTEXCUPO     H,
                ADMIN.GG_TGPACTE            G,
                ADMIN.HD_TURNODIALISIS      T
            WHERE     
                    H.COD_EMPRESA           =   $empresa
                AND H.COD_EMPRESA           =   T.COD_EMPRESA
                AND H.ID_RMDIALISIS         =   T.ID_RMDIALISIS
                AND G.NUM_FICHAE            =   H.NUM_FICHAE
                AND H.ID_TURNOSXDIAS        =   T.ID_TURNOSXDIAS
                AND H.IND_ESTADO            =   1
                AND T.IND_ESTADO            =   1
                
                AND (
                    SELECT 
                        AD.AD_ID_ADMISION||'#'||TO_CHAR(AD.AD_FHADMISION,'HH24:MI')||'#'||HD.ID_TDHOJADIARIA 
                    FROM  
                        ADMIN.URG_TADMISION     AD, 
                        ADMIN.HD_TDHOJADIARIA   HD 
                    WHERE  
                            AD.AD_FHADMISION  
                                BETWEEN 
                            TO_DATE('$fecha 00:00:00','DD-MM-YYYY hh24:mi:ss') 
                                AND 
                            TO_DATE('$fecha 23:59:59','DD-MM-YYYY hh24:mi:ss') 
                        AND 
                            G.NUM_FICHAE        = HD.NUM_FICHAE 
                        AND 
                            HD.AD_ID_ADMISION   = AD.AD_ID_ADMISION 
                        AND
                            AD.AD_ACTIVA        = 1
                    )                                                          IS NULL 
                AND H.ID_RMDIALISIS                                            = $num_Maquina
                AND T.ID_NDIA                                                  = (SELECT DECODE(
                                                                                    RTRIM(
                                                                                        LTRIM(
                                                                                            TO_CHAR(TO_DATE('$fecha'),
                                                                                                'DAY',
                                                                                                'NLS_DATE_LANGUAGE=SPANISH'))),
                                                                                                'LUNES',        0,
                                                                                                'MARTES',       1,
                                                                                                'MIÉRCOLES',    2,
                                                                                                'JUEVES',       3,
                                                                                                'VIERNES',      4,
                                                                                                'SÁBADO',       5,
                                                                                                'DOMINGO',      6) AS NUM_DIA
                                                                                   FROM DUAL)   
                ";
                return $sQuery;
    }        

    public function proBuscaHojaDiaria($empresa,$fecha,$num_Maquina){ 
    
        $sQuery =" 
            SELECT 
                TO_CHAR (AD.AD_FHADMISION, 'HH24:MI')                                   AS HRS_INICIO,
                TO_CHAR (AD.AD_FHADMISION, 'DD-MM-YYYY')                                AS FECHA_DIAL,
                HD.ID_TDHOJADIARIA                                                      AS ID_TDHOJADIARIA,
                AD.AD_ID_ADMISION                                                       AS AD_ADMISION,
                CI.CI_ID_CIERRE                                                         AS AD_CIERRE,
                UPPER (G.NOM_APEPAT || ' ' || G.NOM_APEMAT || ' ' || G.NOM_NOMBRE)      AS NOMPAC,
                G.COD_RUTPAC || '-' || G.COD_DIGVER                                     AS RUTPAC,
                TO_CHAR (G.FEC_NACIMI, 'DD-MM-YYYY')                                    AS NACIMIENTO,
                G.NUM_FICHAE                                                            AS NUMFICHAE,
                H.ID_CUPOXPACIENTE                                                      AS ID_CUPO,
                H.COD_EMPRESA                                                           AS EMPRESA,
                H.NUM_INGRESO                                                           AS NUM_INGRESO,
                H.ID_RMDIALISIS                                                         AS MKN,
                H.ID_TURNOSXDIAS                                                        AS TRN,
                H.COD_USRCREA,
                H.DATE_CREA,
                H.IND_ESTADO                                                            AS IND_ESTADO,
                NULL                                                                    AS DIA,
                HD.IND_HDESTADO                                                         AS CIERREHD
            FROM 
                ADMIN.HD_NPACIENTEXCUPO         H,
                ADMIN.GG_TGPACTE                G,
                ADMIN.HD_TDHOJADIARIA           HD,
                ADMIN.URG_TADMISION             AD,
                ADMIN.URG_TCIERRE               CI
           WHERE 
                    AD.AD_FHADMISION 
                                BETWEEN 
                                    TO_DATE ('$fecha 00:00:00','DD-MM-YYYY hh24:mi:ss')
                                AND 
                                    TO_DATE ('$fecha 23:59:59','DD-MM-YYYY hh24:mi:ss')
                AND H.COD_EMPRESA                                               = $empresa
                AND HD.ID_RMDIALISIS                                            = $num_Maquina
                AND AD.AD_ID_ADMISION                                           = CI.AD_ID_ADMISION
                AND AD.AD_ID_ADMISION                                           = HD.AD_ID_ADMISION
                AND AD.NUM_FICHAE                                               = HD.NUM_FICHAE
                AND H.NUM_FICHAE                                                = HD.NUM_FICHAE
                AND G.NUM_FICHAE                                                = H.NUM_FICHAE 
                AND H.IND_ESTADO                                                = 1
                AND AD.AD_ACTIVA                                                = 1
                ";
        return $sQuery;
    }

    
    public function proBuscaHojaDiaria_HD($HD){ 
        
        $sQuery =" 
                    SELECT 
                        TO_CHAR (AD.AD_FHADMISION, 'HH24:MI')                                   AS HRS_INICIO,
                        TO_CHAR (AD.AD_FHADMISION, 'DD-MM-YYYY')                                AS FECHA_DIAL,
                        HD.ID_TDHOJADIARIA                                                      AS ID_TDHOJADIARIA,
                        AD.AD_ID_ADMISION                                                       AS AD_ADMISION,
                        CI.CI_ID_CIERRE                                                         AS AD_CIERRE,
                        UPPER (G.NOM_APEPAT || ' ' || G.NOM_APEMAT || ' ' || G.NOM_NOMBRE)      AS NOMPAC,
                        G.COD_RUTPAC || '-' || G.COD_DIGVER                                     AS RUTPAC,
                        TO_CHAR (G.FEC_NACIMI, 'DD-MM-YYYY')                                    AS NACIMIENTO,
                        G.NUM_FICHAE                                                            AS NUMFICHAE,
                        H.ID_CUPOXPACIENTE                                                      AS ID_CUPO,
                        H.COD_EMPRESA                                                           AS EMPRESA,
                        H.NUM_INGRESO                                                           AS NUM_INGRESO,
                        H.ID_RMDIALISIS                                                         AS MKN,
                        H.ID_TURNOSXDIAS                                                        AS TRN,
                        H.COD_USRCREA,
                        H.DATE_CREA,
                        H.IND_ESTADO                                                            AS IND_ESTADO,
                        NULL                                                                    AS DIA,
                        HD.IND_HDESTADO                                                         AS CIERREHD

                    FROM 
                        ADMIN.HD_NPACIENTEXCUPO                                                 H,
                        ADMIN.GG_TGPACTE                                                        G,
                        ADMIN.HD_TDHOJADIARIA                                                   HD,
                        ADMIN.URG_TADMISION                                                     AD,
                        ADMIN.URG_TCIERRE                                                       CI
                    WHERE 
                    
                            AD.AD_ID_ADMISION                                                   = CI.AD_ID_ADMISION(+)
                        AND AD.AD_ID_ADMISION                                                   = HD.AD_ID_ADMISION
                        --AND AD.NUM_FICHAE                                                     = HD.NUM_FICHAE
                        AND H.NUM_FICHAE                                                        = HD.NUM_FICHAE
                        AND HD.ID_TDHOJADIARIA                                                  = '$HD'  
                        AND G.NUM_FICHAE                                                        = H.NUM_FICHAE 
                        AND H.IND_ESTADO                                                        = 1
                        AND AD.AD_ACTIVA                                                        = 1
                    ";
        return $sQuery;
    }

    public function sqlbusquedaListadoPacienteHDxMaquinaCAdmision($empresa,$idMaquina,$fechaBusqueda){

            $sQuery = " 
                        SELECT
                            TO_CHAR(AD.AD_FHADMISION,'HH24:MI')                                                                         AS HRS_INICIO,
                            H.AD_ID_ADMISION                                                                                            AS NUMCITA,
                            H.ID_TDHOJADIARIA                                                                                           AS ID_TDHOJADIARIA,
                            UPPER(G.NOM_APEPAT||' '||G.NOM_APEMAT||' '|| G.NOM_NOMBRE)                                                  AS NOMPAC,
                            G.COD_RUTPAC||'-'||G.COD_DIGVER                                                                             AS RUTPAC,
                            TO_CHAR(G.FEC_NACIMI,'DD-MM-YYYY')                                                                          AS NACIMIENTO,
                            G.NUM_FICHAE                                                                                                AS NUMFICHAE,
                            DECODE(G.IND_TISEXO,'M','MASCULINO','F','FEMENINO','NO ESPECIFICADO')                                       AS TXT_SEXO,
                            F.NUM_NFICHA                                                                                                AS F_LOCAL
                        FROM 
                            $this->own.HD_TDHOJADIARIA                          H,
                            $this->own.GG_TGPACTE                               G,
                            $this->own.SO_TCPACTE                               F,
                            $this->own.URG_TADMISION                            AD
                        WHERE 
                            AD.AD_FHADMISION BETWEEN TO_DATE('$fechaBusqueda 00:00:00','DD-MM-YYYY hh24:mi:ss') AND TO_DATE('$fechaBusqueda 23:59:59','DD-MM-YYYY hh24:mi:ss') AND
                            H.AD_ID_ADMISION                                        = AD.AD_ID_ADMISION     AND
                            H.NUM_FICHAE                                            = G.NUM_FICHAE          AND
                            H.NUM_FICHAE                                            = F.NUM_FICHAE          AND
                            F.COD_EMPRESA                                           = $empresa              AND
                            H.ID_RMDIALISIS                                         = $idMaquina
                                
                        ";
        return $sQuery;
    }

    public function sql_FechaEgreso($AD_ID_ADMISION){
            $sQuery = "
                SELECT 
                    H.ID_TDHOJADIARIA,
                    TO_CHAR(H.DATE_REALIZAHD,   'DD-MM-YYYY hh24:mi')           AS FECHA_INICIOHD,
                    TO_CHAR(H.DATE_FHEGRESO,    'DD-MM-YYYY hh24:mi')           AS FECHA_FINALHD,
                    TO_CHAR(H.DATE_REALIZAHD,   'YYYY-MM-DD hh24:mi')           AS FECHA_INICIOHD2,
                    TO_CHAR(H.DATE_FHEGRESO,    'YYYY-MM-DD hh24:mi')           AS FECHA_FINALHD2
                FROM 
                    $this->own.HD_TDHOJADIARIA          H 
                WHERE 
                    H.ID_TDHOJADIARIA   = $AD_ID_ADMISION      
                ";
     return $sQuery;
    }
    public function sql_busquedaEstadoAdmision($AD_ID_ADMISION){
           
        $sQuery="
            
            SELECT
                
                    U.AD_ID_ADMISION, 
                    TO_CHAR(U.AD_FHADMISION,    'DD-MM-YYYY hh24:mi')           AS FEC_ADMISION,
                    TO_CHAR(C.CI_FHCIERRE,      'DD-MM-YYYY hh24:mi')           AS FEC_EGRESO,
                    
                    TO_CHAR(U.AD_FHADMISION,    'hh24:mi')                      AS HR_ADMISION,
                    TO_CHAR(C.CI_FHCIERRE,      'hh24:mi')                      AS HR_EGRESO,
                    
                    U.COD_EMPRESA, 
                    U.AD_NUMFOLIO, 
                    U.TI_ID_TIPINGRESO, 
                    U.TA_ID_TIPACCIDENTE, 
                    U.TA_ID_TIPATENCION, 
                    U.ES_ID_ESTADO, 
                    U.COD_TRANSPORTE, 
                    U.COD_PROCED, 
                    U.AD_PREVISION, 
                    U.ES_ID_ESTAPROC, 
                    U.AD_ACOMPA, 
                    U.AD_FONOACOMP, 
                    U.AD_MOTIVOCONSUL, 
                    U.AD_NUMPAGARE, 
                    U.PR_PROFREG, 
                    U.AD_FHREGISTRO, 
                    U.PR_PROFEDIT, 
                    U.AD_FHEDIT, 
                    U.AD_ID_ESTADOATENCION, 
                    U.PR_NOMBREPROFREG, 
                    U.PR_NOMBREPROFEDIT, 
                    U.AD_ESTADOCIERRETIEMPO, 
                    U.AD_PROCEDENCIA, 
                    U.AD_ACTIVA, 
                    U.AD_FHCREACION, 
                    U.AD_HIPODIAGNO, 
                    U.COD_RUTPRO, 
                    U.AD_FECHORA_ATEN, 
                    U.NUM_FICHAE, 
                    U.AD_RUTTUTOR,
                    U.IND_ESTADODERIVA,

                    C.CI_ID_CIERRE, 
                    C.AD_ID_ADMISION, 
                    C.TD_ID_TIPDERICIERRE, 
                    C.TE_ID_TIPEGRESO, 

                    C.CI_INDIEGRESO, 
                    C.CI_FHCIERRE, 
                    C.CI_FHREGISTRO, 
                    C.PR_PROFREG, 
                    C.CI_TIEMPOCONTROL, 
                    C.CI_INFODERIVACION, 
                    C.PR_NOMBREPROFREG, 
                    C.CI_MEDIOTRANSCIERRE, 
                    C.TD_ID_SERVICIO, 
                    C.CI_OBSDIAGNO, 
                    C.CI_MOTIVONSA, 
                    C.CI_INDREASIGNA, 
                    C.CI_FECATENCIONPROF, 
                    C.CI_CODDESTINM, 
                    C.CI_CODVTRASLADO, 
                    C.CI_PROFEGRESO, 
                    C.CI_DATEUPDATE, 
                    C.CI_MOTIVTRASLADO
                    
            FROM 
                    ADMIN.URG_TADMISION         U,  
                    ADMIN.URG_TCIERRE           C
                    


            WHERE 
                    U.AD_ID_ADMISION    = $AD_ID_ADMISION 
                AND U.AD_ID_ADMISION    = C.AD_ID_ADMISION(+) 
                AND U.AD_ACTIVA         = 1
                
        ";
        return $sQuery;
        
        /*
         (SELECT 
            'Dias: ' 
                || TO_CHAR(DIFERENCIA_DIAS, '00') 
                || ' - ' || TO_CHAR(DIFERENCIA_HORAS, '00') 
                || ':'   || TO_CHAR(DIFERENCIA_MINUTOS, '00') 
                || ':' || TO_CHAR(DIFERENCIA_SEGUNDOS, '00')  
            FROM (

            SELECT 
                FECHA_UNO,
                FECHA_DOS,
                TRUNC((FECHA_DOS - FECHA_UNO)) DIFERENCIA_DIAS,
                TRUNC(MOD((FECHA_DOS - FECHA_UNO) *  24, 24)) DIFERENCIA_HORAS,
                TRUNC(MOD((FECHA_DOS - FECHA_UNO) * (60 * 24), 60)) DIFERENCIA_MINUTOS,
                TRUNC(MOD((FECHA_DOS - FECHA_UNO) * (60 * 60 * 24), 60)) DIFERENCIA_SEGUNDOS
            FROM(
                SELECT 
                    TO_DATE('U.AD_FHADMISION',  'DD.MM.YYYY HH24:MI:SS')    FECHA_UNO,
                    TO_DATE('C.CI_FHCIERRE',    'DD.MM.YYYY HH24:MI:SS')    FECHA_DOS
                FROM DUAL
                )
            )) AS DIFERENCIA_TIEMPO,
        */            
        
    }
    
    
    //(SELECT B.NUM_NFICHA FROM $this->own.SO_TCPACTE B WHERE A.NUM_FICHAE = B.NUM_FICHAE AND B.IND_ESTADO = 'V' AND  B.COD_EMPRESA = '$empresa') AS FICHA_LOCAL,
                        
    
    public function sqlFichalocal($numfichae,$empresa){
        
        $sQuery = " 
                SELECT 
                    B.NUM_NFICHA  AS FICHA_LOCAL
                FROM 
                    ADMIN.SO_TCPACTE B 
                WHERE 
                        B.NUM_FICHAE    = $numfichae
                    AND B.IND_ESTADO    = 'V' 
                    AND B.COD_EMPRESA   = '$empresa'
            ";
        return $sQuery;
    }

    //change 19.04.2021
    public function sqlDatosGeneralesxDial($IDHOJADIARIA){
        $sQuery = " 
                SELECT 
                    (
                        SELECT 
                            U.AD_ID_ADMISION
                        FROM 
                            ADMIN.URG_TADMISION U
                        WHERE
                            U.AD_ID_ADMISION = H.AD_ID_ADMISION
                        AND 
                            U.AD_ACTIVA = 1
                    )                                                                   AS ADMISION_ACTIVA,
    

                    H.FEC_CREA,
                    H.USR_CREA,
                    
                    H.USR_AUDITA,
                    H.FEC_AUDITA,
                    
                    TO_CHAR(H.FEC_CREA,'DD-MM-YYYY hh24:mi')                            AS TXT_FEC_CREA,
                    TO_CHAR(H.FEC_AUDITA,'DD-MM-YYYY hh24:mi')                          AS TXT_FEC_AUDITA,
                      
                    H.ID_TDHOJADIARIA, 
                    H.NUM_FICHAE, 
                    H.NUM_CITACION, 
                    H.AD_ID_ADMISION, 
                    
                    TO_CHAR(H.DATE_REALIZAHD,'DD-MM-YYYY')                              AS FECHA_HEMODIALISIS,
                    TO_CHAR(H.DATE_FHEGRESO,'hh24:mi')                                  AS HORA_DESCONEXION,
 
                    UPPER(G.NOM_APEPAT||' '||G.NOM_APEMAT||' '|| G.NOM_NOMBRE)          AS NOMPAC,
                    G.COD_RUTPAC||'-'||G.COD_DIGVER                                     AS RUTPAC,
                    TO_CHAR(G.FEC_NACIMI,'DD-MM-YYYY')                                  AS NACIMIENTO,   
                    TRUNC(MONTHS_BETWEEN(SYSDATE,G.FEC_NACIMI)/12)                      AS EDAD,
                    G.NOM_DIRECC                                                        AS DIRECCION,
                    G.NUM_TELEFO1_2||' '||G.NUM_TELEFO2_2||' '||G.NUM_CELULAR_2         AS TELEFONOS,
                    G.NUM_CELULAR_2                                                     AS CELULAR,
                    
                    -- INI DATOS DE PROGRAMACION --
                    H.NUM_PESOSECO, 
                    H.NUM_HDPESOANTERIOR, 
                    H.NUM_PESOPREDIALISIS, 
                    H.NUM_INTERDIALISIS, 
                    H.NUM_UFPROGRAMADA  ||' '||DECODE( H.NUM_UFPROGRAMADA_UM,'0','ML','L')   AS NUM_UFPROGRAMADA, 
                    
                    H.NUM_PESOPOSTDIALISIS, 
                    H.NUM_PESOINTERDIALISIS,
                    H.NUM_ALZAINTERDIALISIS,
                    -- FIN DATOS DE PROGRAMACION --
 
                    --INDICACIONES MEDICAS --
                    H.TXTACCESOVAS_1, 
                    H.TXTACCESOVAS_2, 
                    TO_CHAR(H.FEC_DIASVAS_1,'DD-MM-YYYY')                                   AS FEC_DIASVAS_1,
                    TO_CHAR(H.FEC_DIASVAS_2,'DD-MM-YYYY')                                   AS FEC_DIASVAS_2,
                    TRUNC(H.DATE_REALIZAHD-H.FEC_DIASVAS_1)                                 AS NUM_DIASVAS_1,
                    TRUNC(H.DATE_REALIZAHD-H.FEC_DIASVAS_2)                                 AS NUM_DIASVAS_2,
                    --INDICACIONES MEDICAS --

                    H.NUM_TROCAR_ARTERIAL, 
                    H.NUM_TROCAR_VENOSO, 
                    H.NUM_HEPARINA_INICIO, 
                    H.NUM_HEPARINA_MAN, 
                    
                    H.NUM_QT, 
                    H.NUM_QB, 
                    H.NUM_QD, 

                    H.NUM_UFMAX,
                    H.NUM_UFMAX_UM,
                    DECODE(H.NUM_UFMAX_UM,'0','ML','L')                                     AS TXT_NUM_UFMAX_UM, 

                    H.NUM_K,
                    H.NUM_NA,
                    H.NUM_CONCENTRADO,
                    
                    H.TXT_OBSMEDICAS, 
                    H.TXT_ENFERMERIA, 
                     
                    H.NUM_PS_FILTRO, 
                    H.NUM_PS_ARTERIAL, 
                    H.NUM_PS_VENOSO, 

                    DECODE(H.NUM_PS_FILTRO,'1','SI','0','NO','NO DETERMINADO')              AS SL_PS_FILTRO,
                    DECODE(H.NUM_PS_ARTERIAL,'1','SI','0','NO','NO DETERMINADO')            AS SL_PS_ARTERIAL, 
                    DECODE(H.NUM_PS_VENOSO,'1','SI','0','NO','NO DETERMINADO')              AS SL_PS_VENOSA,
                    
                    H.NUM_CI_FILTRO, 
                    
                    H.NUM_V_RESIDUAL,
                    H.NUM_CI_ARTERIAL, 
                    H.NUM_CI_VENOSA,
                    
                    DECODE(H.NUM_CI_FILTRO,'1','L','2','R','3','S','NO DETERMINADO')        AS SL_CI_FILTRO,
                    DECODE(H.NUM_CI_ARTERIAL,'1','L','2','R','3','S','NO DETERMINADO')      AS SL_CI_ARTERIAL, 
                    DECODE(H.NUM_CI_VENOSA,'1','L','2','R','3','S','NO DETERMINADO')        AS SL_CI_VENOSA, 
                    H.TXT_TESTPOTENCIA, 
                    
                    -- FILTRO ---    
                    H.NUM_USO_FILTRO, 
                    
                    H.IND_R_RFIBRAS, 
                    H.IND_C_RFIBRAS, 
                    H.IND_R_PIROGENOS,
                    
                    DECODE(H.IND_R_RFIBRAS,
                    '1','SI',
                    '0','NO',
                    'NO DETERMINADO')                                           AS TXT_R_RFIBRAS,
                     DECODE(H.IND_C_RFIBRAS,
                    '1','SI',
                    '0','NO',
                    'NO DETERMINADO')                                           AS TXT_C_RFIBRAS,
                    
                     DECODE(H.IND_R_PIROGENOS,
                    '1','SI',
                    '0','NO',
                    'NO DETERMINADO')                                           AS TXT_R_PIROGENOS,
                    -- FILTRO ---

                    H.NUM_V_RESIDUAL, 
                    H.NUM_V_ARTERIAL, 
                    H.NUM_V_VENOSA,
                    
                    --TIPO DE VIA --
                    DECODE(H.ID_TIPOVIA,
                            '0','FISTULA ARTERIOVENOSO',
                            '1','CATETER VENOSO CENTRAL',
                            '2','FISTULA PROTESICA',
                            'NO DETERMINADO')                                   AS TXT_ID_TIPOVIA,
                    H.ID_TIPOVIA                                                AS NUM_ID_TIPOVIA,
                    --TIPO DE VIA --
                    
                    -- INI DATOS CREA-AUDITA --
                    H.USR_CREA, 
                    H.FEC_CREA, 
                    H.USR_AUDITA, 
                    H.FEC_AUDITA,
                    -- FIN DATOS CREA-AUDITA --

                    -- INICIO PAUSAS SEGURIDAD 
                    H.IND_HIPOTENSION, 
                    H.IND_CALOFRIO, 
                    H.IND_FIEBRE, 
                    H.IND_ICVASCULAR, 
                    H.IND_BACTEREMIA, 
                    H.IND_HEPATITIS_B, 
                    H.IND_HEPATITIS_C, 
                    H.IND_MDPROCEDIMIENTO, 
                    -- FIN PAUSAS SEGURIDAD 
                    
                    -- INICIO MAQUINA
                    H.ID_RMDIALISIS                                             AS ID_HERMODIALIS,
                    M.NOM_RMDIALISIS                                            AS NOM_RMDIALISIS,
                    M.COD_RMDIALISIS                                            AS COD_RMDIALISIS,
                    -- FINAL MAQUINA
                    
                    H.IND_HDESTADO, 

                    -- INI DATOS DE DECONEXION 
                    H.NUM_TOTALUFCONSEGIDA,
                    H.NUM_VOLSANGREACOMULADA,
                    H.IND_DESIFCACCIONMAQUINA,
                    DECODE(H.IND_DESIFCACCIONMAQUINA,
                        '1','SI',
                        '0','NO',
                        '-')                                                    AS SL_DESIFCACCIONMAQUINA,
                    H.IND_DIALIZADORDIAL,    
                    DECODE(H.IND_DIALIZADORDIAL,
                        '1','LIMPIO',
                        '2','SUCIO',
                        '3','ROTO',
                        '4','MUCHAS FIBRAS COAGULADAS',
                        '-')                                                    AS SL_DIALIZADORDIAL,
                    H.NUM_KT_V,    
                    -- FIN DATOS DE DECONEXION 

                    -- INICIO PAUSAS SEGURIDAD 
                    H.IND_PACIENTE_CORRECTO, 
                    H.IND_CLINEAS, 
                    H.IND_CFILTRO,
                    DECODE(H.IND_PACIENTE_CORRECTO,
                        '1','SI',
                        '0','NO',
                        'NO DETERMINADO')                                       AS TXT_PACIENTE_CORRECTO,
                    DECODE(H.IND_CLINEAS,
                        '1','SI',
                        '0','NO',
                        'NO DETERMINADO')                                       AS TXT_CLINEAS,
                    DECODE(H.IND_CFILTRO,
                        '1','SI',
                        '0','NO',
                        'NO DETERMINADO')                                       AS TXT_CFILTRO,
                    H.NUM_T_MONITOR                                             AS NUM_T_MONITOR, 
                    H.NUM_CONDUCTIVIDAD                                         AS NUM_CONDUCTIVIDAD,
                    H.NUM_TEST_RESIDUOS                                         AS ID_TEST_RESIDUOS,
                    DECODE(H.NUM_TEST_RESIDUOS,
                        '1','REACTIVO',
                        '0','NO REACTIVO',
                        'NO DETERMINADO')                                       AS NUM_TEST_RESIDUOS
                    -- FIN PAUSAS SEGURIDAD
                    
                FROM 
                    $this->own.HD_TDHOJADIARIA                                  H,
                    $this->own.GG_TGPACTE                                       G,
                    $this->own.HD_RMDIALISIS                                    M
                WHERE 
                    H.ID_TDHOJADIARIA   = $IDHOJADIARIA                         AND 
                    H.NUM_FICHAE        = G.NUM_FICHAE                          AND
                    H.ID_RMDIALISIS     = M.ID_RMDIALISIS 

        ";
        return $sQuery;
    }
    
    public function getbusquedadecuposporagendahd($fechaini,$fechafin,$empresa,$num_fichae){
        $sQuery ="
                SELECT  
                        TO_CHAR(A.DATE_REALIZAHD,'DD-MM-YYYY')                  AS FECHA,
                        A.ID_TDHOJADIARIA                                       AS ID_TDHOJADIARIA,
                        COUNT(*)                                                AS NUM_ACTIVIDAS
                FROM 
                        ADMIN.HD_TDHOJADIARIA A
                WHERE 
                            A.DATE_REALIZAHD BETWEEN TO_DATE('$fechaini 00:00','DD/MM/YYYY hh24:mi') AND TO_DATE('$fechafin 23:59','DD/MM/YYYY  hh24:mi') 
                        AND A.NUM_FICHAE = $num_fichae
                GROUP BY 
                       TO_CHAR(A.DATE_REALIZAHD, 'DD-MM-YYYY'),A.ID_TDHOJADIARIA 
                HAVING 
                        COUNT(*)> 0

                ";
        /*
        SELECT  
                TO_CHAR(A.DATE_REALIZAHD,'DD-MM-YYYY')       AS FECHA,
                A.ID_TDHOJADIARIA                                            AS ID_TDHOJADIARIA,
                COUNT(*)                                                          AS NUM_ACTIVIDAS
        FROM 
                ADMIN.HD_TDHOJADIARIA   A,
                ADMIN.URG_TADMISION     AD
        WHERE 
                    A.DATE_REALIZAHD BETWEEN TO_DATE('01/01/2017 00:00','DD/MM/YYYY hh24:mi') AND TO_DATE('01/03/2018 23:59','DD/MM/YYYY  hh24:mi')    AND 
                    A.AD_ID_ADMISION = AD.AD_ID_ADMISION AND 
                    AD.AD_ACTIVA = 1 AND          
                    A.NUM_FICHAE = 44251 
        GROUP BY 
               TO_CHAR(A.DATE_REALIZAHD, 'DD-MM-YYYY'),A.ID_TDHOJADIARIA 
        HAVING 
                COUNT(*)> 0
         */
        return $sQuery;
    }

    public function sqlDatosSignosVitales($IDHOJADIARIA,$ETAPA){
        
        $where = '';
        if ($ETAPA != ''){ $where= '  H.IND_TOMASIGNO = '.$ETAPA.' AND';  }
        
        $sQuery = " 
                    SELECT 
                        H.ID_TDSIGNOSVITALES AS ID, 
                        H.ID_TDHOJADIARIA, 
                        UPPER(SUBSTR(P.NOM_NOMBRE, 1, 1)  
                        ||'.'|| P.NOM_APEPAT   
                        ||' '|| P.NOM_APEMAT)                                   AS TXTNOMBRETB,
                        TO_CHAR(H.DATE_HORA,'HH24:MI')                          AS HORA,
                        H.NUM_PARTERIAL_S, 
                        H.NUM_PARTERIAL_D,
                        H.NUM_PARTERIAL_S||'/'||H.NUM_PARTERIAL_D               AS NUM_PARTERIAL,
                        H.NUM_PULSO,
                        H.NUM_TPACIENTE, 
                        H.NUM_TMONITOR, 
                        H.NUM_QBPROG, 
                        H.NUM_QBEFEC, 
                        H.NUM_PA, 
                        
                        H.NUM_PV, 
                        H.NUM_PTM, 
                        
                        H.NUM_COND, 
                        H.NUM_UFH, 
                        
                        H.NUM_UFACOMULADA||' '||DECODE(H.NUM_UFACOMULADA_UM,'0','ML/HR','L/HR')                                      AS NUM_UFACOMULADA,
                        
                        H.TXT_INGRESO, 
                        H.TXTOBSERVACIONES, 
                        
                        H.USR_CREA, 
                        H.DATE_CREA,
                        
                        H.NUM_TAZAUFH, 
                        
                        DECODE(H.IND_TOMASIGNO,
                                        '1','P',
                                        '3','E',
                                        '')                                     AS IND_INGRESO,
                                        
                        DECODE(H.IND_TOMASIGNO,
                                        '1','PRE-DIALISIS',
                                        '3','POST-DIALISIS',
                                        '')                                     AS TXT_TOMA,
                                        
                        H.IND_TOMASIGNO                                         AS IND_TOMASIGNO,
                        
                        TO_CHAR(H.DATE_CREA,'DD-MM-YYYY HH24:MI')               AS FEC_HORA_GRABA,

                        H.IND_ESTADO
                    FROM 
                        ADMIN.HD_TDSIGNOSVITALES    H, 
                        ADMIN.GG_TPROFESIONAL       P
                    WHERE 
                        H.ID_TDHOJADIARIA   = $IDHOJADIARIA     AND 
                        H.IND_ESTADO        = 1                 AND 
                        $where
                        H.USR_CREA          = P.COD_RUTPRO(+)
                    ORDER BY TO_CHAR(H.DATE_HORA,'HH24:MI')        
                        
            
                    ";
        return $sQuery;
    }
    
    public function sqldatoHojaTratamiento($IDHOJADIARIA){
        
        $sQuery = " 
                SELECT 
                
                    H.ID_TDHOJADIARIA, 
                    H.NUM_FICHAE, 
                    H.NUM_CITACION, 
                    H.AD_ID_ADMISION, 
                    H.NUM_PESOSECO, 
                    H.NUM_HDPESOANTERIOR, 
                    H.NUM_PESOPREDIALISIS, 
                    H.NUM_INTERDIALISIS, 
                    H.NUM_UFPROGRAMADA, 
                    H.NUM_PESOPOSTDIALISIS, 
                    H.NUM_PESOINTERDIALISIS, 
                    H.NUM_ALZAINTERDIALISIS, 

                    H.USR_CREA, 
                    H.FEC_CREA, 
                    H.USR_AUDITA, 
                    H.FEC_AUDITA, 

                    H.TXTACCESOVAS_1, 
                    H.NUM_DIASVAS_1, 
                    H.TXTACCESOVAS_2, 
                    H.NUM_DIASVAS_2, 

                    H.NUM_TROCAR_ARTERIAL, 
                    H.NUM_TROCAR_VENOSO, 
                    H.NUM_HEPARINA_INICIO, 
                    H.NUM_HEPARINA_MAN, 
                    H.NUM_QT, 
                    H.NUM_QB, 
                    H.NUM_QD, 
                    H.NUM_UFMAX, 
                    H.NUM_K, 
                    H.TXT_OBSMEDICAS, 
                    H.TXT_ENFERMERIA, 

                    H.NUM_PS_FILTRO, 
                    H.NUM_PS_ARTERIAL, 
                    H.NUM_PS_VENOSO, 

                    DECODE(H.NUM_PS_FILTRO,'1','SI','0','NO','NO DETERMINADO')          AS SL_CI_FILTRO,
                    DECODE(H.NUM_PS_ARTERIAL,'1','SI','0','NO','NO DETERMINADO')        AS SL_CI_ARTERIAL, 
                    DECODE(H.NUM_PS_VENOSO,'1','SI','0','NO','NO DETERMINADO')          AS SL_CI_VENOSA,


                    H.NUM_CI_FILTRO, 
                    H.NUM_CI_ARTERIAL, 
                    H.NUM_CI_VENOSA, 

                    DECODE(H.NUM_CI_FILTRO,'1','L','2','R','3','S','NO DETERMINADO')    AS SL_CI_FILTRO,
                    DECODE(H.NUM_CI_ARTERIAL,'1','L','2','R','3','S','NO DETERMINADO')  AS SL_CI_ARTERIAL, 
                    DECODE(H.NUM_CI_VENOSA,'1','L','2','R','3','S','NO DETERMINADO')    AS SL_CI_VENOSA, 
                    H.TXT_TESTPOTENCIA, 

                    H.NUM_USO_FILTRO, 
                    H.NUM_V_RESIDUAL, 
                    H.NUM_V_ARTERIAL, 
                    H.NUM_V_VENOSA
                FROM 
                    ADMIN.HD_TDHOJADIARIA H
                WHERE 
                    H.ID_TDHOJADIARIA   = $IDHOJADIARIA
                 ";
        return $sQuery;
    }
    
    public function sqlListadoMaquinasDialisis($empresa,$estados){
        $sQuery =   "SELECT 
                        H.ID_RMDIALISIS             AS ID, 
                        H.COD_RMDIALISIS            AS COD, 
                        H.NOM_RMDIALISIS            AS NOMDIAL, 
                        H.IND_ESTADO, 
                        DECODE(H.IND_ESTADO,
                            '1','HABILITADO', 
                            '2','EN MANTERNCION')   AS TXTESTADO,
                        H.NUM_SERIE                 AS SERIE, 
                        H.NUM_LORE, 
                        H.COD_EMPRESA
                    FROM 
                        ADMIN.HD_RMDIALISIS H
                    WHERE 
                        H.COD_EMPRESA = '$empresa' AND  H.IND_ESTADO IN ($estados)
                  ";
        return $sQuery;
    }
    
    public function sqlListadoTurnosxDiasG(){
        $sQuery = " 
            SELECT 
            
                A.ID_TURNO, 
                B.ID_GRUPO,

                A.TXT_TURNO, 
                C.TXT_NDIACORTO,
                C.TXT_NDIA,

                DECODE(A.ID_TURNO,'1','GRUPO 1','2','GRUPO 2','3','GRUPO 3') AS TXTGRUPO,
                DECODE(B.ID_GRUPO,'1','LUNES - MIERCOLES - VIERNES','2','MARTES - JUEVES - SABADO') AS TXT_GRUPO,
                
                B.HD_TURNOSXDIAS, 
                B.ID_NDIA, 
                B.IND_ESTADO

            FROM 

                ADMIN.HD_TURNOS         A, 
                ADMIN.HD_TURNOSXDIAS    B,
                ADMIN.HD_DIASSEMANA     C

            WHERE 

                A.ID_TURNO              = B.ID_TURNO    AND 
                B.ID_NDIA               = C.ID_NDIA
                
                ORDER BY B.ID_GRUPO,A.ID_TURNO,C.ID_NDIA

            ";
        return $sQuery;
    }
    
    public static function sqlNextValFolio($tableSpace, $codEmpresa, $sistema) {

        $sQuery = "
                SELECT
                        (
                            CASE
                                WHEN MAX(A.AD_NUMFOLIO) IS NULL
                                THEN 1
                                ELSE MAX(A.AD_NUMFOLIO) + 1
                            END
                        ) AS NFOLIO
                FROM
                        " . $tableSpace . ".URG_TADMISION A
                WHERE
                        A.COD_EMPRESA = '" . $codEmpresa . "' AND A.AD_PROCEDENCIA = " . $sistema . " ";
        return $sQuery;
// 		$sQuery = "SELECT
// 					(
// 				        CASE
// 				            WHEN MAX(A.AD_NUMFOLIO) IS NULL
// 				            THEN 1
// 				            ELSE MAX(A.AD_NUMFOLIO) +1
// 				        END) AS NFOLIO
// 					FROM
// 						".$tableSpace.".URG_TADMISION A
// 					WHERE
// 						A.COD_EMPRESA = '".$codEmpresa."'";
// 		return $sQuery;
    }
    
    public static function sqlExisteFolio($tableSpace, $codEmpresa, $sistema, $folio) {

        $sQuery = "SELECT
                            A.AD_NUMFOLIO
                    FROM
                            " . $tableSpace . ".URG_TADMISION A
                    WHERE
                            A.COD_EMPRESA = '" . $codEmpresa . "' AND A.AD_PROCEDENCIA = " . $sistema . " AND A.AD_NUMFOLIO = " . $folio;
        return $sQuery;
        
        
        // 		$sQuery = "SELECT
        // 						(
        // 				        CASE
        // 				            WHEN MAX(A.AD_NUMFOLIO) IS NULL
        // 				            THEN 1
        // 				            ELSE MAX(A.AD_NUMFOLIO) +1
        // 				        END
        //                                              ) AS NFOLIO
        // 					FROM
        // 						".$tableSpace.".URG_TADMISION A
        // 					WHERE
        // 						A.COD_EMPRESA = '".$codEmpresa."'";
        // 		return $sQuery;
    }
    
    public function sqlbusquedaListadoPacienteHDialxMaquina($empresa,$estados,$numFichae,$rutPac,$num_Maquina,$fecha_desde,$fecha_hasta){
        
        $select     = '';
        $From       = '';
        $where      = '';
        
        if ($num_Maquina!=''){
            $select.= "";
            $From.="  $this->own.AP_TAGENDA_RECURSO D,";
            $where.=" AND D.NUM_RECURSO = '$num_Maquina'  AND D.ID_COD_RECURSO = A.ID_COD_RECURSO ";  
        } 
        
        if ($fecha_desde!=''){
           $where.=" AND A.DATE_AGENDAINICIO BETWEEN TO_DATE('$fecha_desde 00:00:00','DD/MM/YYYY hh24:mi:ss') AND TO_DATE('$fecha_hasta 23:59:59','DD/MM/YYYY hh24:mi:ss')"; 
        }
        
        $sQuery = " 
                    SELECT 
                        ''                                                                                                          AS NUM_HERMODIALIS,
                        A.ID_TAGENDA                                                                                                AS NUM_BLOQUE,
                        A.NUM_CITACION                                                                                              AS NUMCITA,
                        F.CI_ID_CIERRE                                                                                              AS ID_CIERRE,
                        C.NUM_CITACION                                                                                              AS NUM_CITAXPACIENTE,
                        C.NUM_INTERCONSULTA                                                                                         AS NUM_INTERCONSULTA,
                        C.AD_ID_ADMISION                                                                                            AS ID_ADMISION,
                        G.NUM_FICHAE                                                                                                AS NUM_FICHAE,
                        
                        (SELECT 
                            ID_TDHOJADIARIA 
                        FROM 
                            $this->own.HD_TDHOJADIARIA p
                        WHERE 
                            P.NUM_FICHAE    = C.NUM_FICHAE 
                            AND 
                            P.NUM_CITACION  = C.NUM_CITACION)                                                                       AS ID_TDHOJADIARIA,
                            
                        TO_CHAR(A.DATE_AGENDAINICIO,'DD-MM-YYYY')                                                                   AS AGE_TO,
                        TO_CHAR(A.DATE_AGENDAFINAL,'DD-MM-YYYY')                                                                    AS AGE_FROM,
                        TO_CHAR(A.DATE_AGENDAINICIO,'HH24:MI')                                                                      AS HRS_INICIO,
                        TO_CHAR(A.DATE_AGENDAFINAL,'HH24:MI')                                                                       AS HRS_FIN,

                        TO_CHAR(A.DATE_AGENDAINICIO,'YYYY-MM-DD')||'T'|| TO_CHAR (A.DATE_AGENDAINICIO, 'HH24:MI')||':00'            AS TXTFULLCALENDARINICIO,
                        TO_CHAR(A.DATE_AGENDAFINAL,'YYYY-MM-DD')||'T'|| TO_CHAR (A.DATE_AGENDAFINAL, 'HH24:MI')||':00'              AS TXTFULLCALENDARFINAL,

                        (A.DATE_AGENDAFINAL-A.DATE_AGENDAINICIO)*(60*24)                                                               DIFERENCIA_MINUTOS,

                        D.NUM_RECURSO                                                                                               AS NUM_RECURSO,

                        UPPER(P.NOM_RMDIALISIS||' ('||P.COD_RMDIALISIS||')')                                                        AS NOMMAC_1,

                        UPPER(G.NOM_APEPAT||' '||G.NOM_APEMAT||' '|| G.NOM_NOMBRE)                                                  AS NOMPAC,
                        G.COD_RUTPAC||'-'||G.COD_DIGVER                                                                             AS RUTPAC,
                        C.NUM_INTERCONSULTA                                                                                         AS INTERCONSULTA,
                        TO_CHAR(G.FEC_NACIMI, 'DD-MM-YYYY')                                                                         AS NACIMIENTO,
                        G.NUM_FICHAE                                                                                                AS NUMFICHAE,
                        DECODE (G.IND_TISEXO,'M','MASCULINO',  'F','FEMENINO','NO ESPECIFICADO')                                    AS TXT_SEXO,
                        
                        (SELECT num_nficha FROM $this->own.so_tcpacte p
                        WHERE p.cod_rutpac = G.COD_RUTPAC AND cod_empresa = '$empresa')                                             AS F_LOCAL,
                            
                        (SELECT A.IND_PREVIS  FROM $this->own.SO_TTITUL A  WHERE A.COD_RUTTIT = G.COD_RUTPAC)                       AS PREVI,

                        TRUNC(MONTHS_BETWEEN(SYSDATE,FEC_NACIMI)/12)                                                                AS EDAD,
                        G.NOM_DIRECC                                                                                                AS DIRECCION,
                        G.NUM_TELEFO1_2||' '||G.NUM_TELEFO2_2||' '||G.NUM_CELULAR_2                                                 AS TELEFONOS,
                        BB.NOM_POLI                                                                                                 AS NOM_ACTIVIDAD,
                        CC.NOM_CICLO                                                                                                AS NOM_CICLO,
                        DECODE(C.IND_PROCEDENCIA,
                                                '11','ATENCION AMBULATORIA',
                                                '12','URGENCIA',
                                                '13','ATENCION CERRADA')                                                            AS TXTPROCEDENCIA,
                        DECODE(C.IND_CSERVICIO, 
                                                '1','SI',
                                                '0','NO')                                                                           AS TXTCSERVICIO,
                        DECODE(C.IND_VSERVICIO, 
                                                '1','SI',
                                                '0','NO')                                                                           AS TXTSSERVICIO
                     
                    FROM 
                        $this->own.GG_TGPACTE                                                                                      G, 
                        $this->own.AP_TCITAXPACIENTE                                                                               C,
                        $this->own.AP_TAGENDA_BLOQUE                                                                               A,
                        $this->own.HD_RMDIALISIS                                                                                   P,
                        $From
                        $this->own.AP_TPOLI                                                                                        BB,
                        $this->own.AP_TPCICLOVIT                                                                                   CC,
                        $this->own.URG_TCIERRE                                                                                     F
                    WHERE 
                    
                            G.NUM_FICHAE        = C.NUM_FICHAE 
                        AND 
                            C.NUM_CITACION      = A.NUM_CITACION
                        AND
                            P.ID_RMDIALISIS     = D.NUM_RECURSO
                        AND 
                            A.COD_ACTIVIDAD     = BB.COD_POLI(+)
                        AND 
                            A.IND_TIPOCITA      = CC.COD_CICLO(+)
                        AND    
                            C.IND_ESTADO        = '1'
                        AND 
                            A.COD_EMPRESA       = '$empresa'
                        AND 
                           C.AD_ID_ADMISION     = F.AD_ID_ADMISION(+)
                        AND 
                            F.CI_ID_CIERRE IS NULL
                            
                        $where
                            
                        ORDER BY TO_CHAR(A.DATE_AGENDAINICIO,'HH24:MI')       
 
                    ";
        return $sQuery;
    }
    
    public function sql_BusquedaRRHHHD($HD,$OP){
        
                $where = '';
                if($OP!=''){ $where.= ' AND B.IND_HDESTAPA ='.$OP;  }
        
                $sm_sql = " 
                        SELECT 
                            B.ID_TDHOJADIARIA                                                           AS ID,
                            A.COD_RUTPRO,
                            A.NOM_NOMBRE,
                            A.NOM_APEPAT,
                            A.NOM_APEMAT, 
                            A.COD_TPROFE,
                            A.COD_RUTPRO||'-'||A.COD_DIGVER                                             AS RUT_COMPLETO,
                            UPPER(SUBSTR(A.NOM_NOMBRE,1,1)
                            || '.'
                            || A.NOM_APEPAT
                            || ' '
                            || A.NOM_APEMAT)                                                            AS TXTNOMBRETB,
                            A.NOM_NOMBRE || ' ' || A.NOM_APEPAT || ' ' || A.NOM_APEMAT                  AS TXTNOMBRE,
                            B.IND_HDESTAPA                                                              AS ID_ETAPA,
                            DECODE(B.IND_HDESTAPA,
                                '1','CONEXION',
                                '2','EVOLUCION',
                                '3','DESCONEXION',
                                'NO INFORMADO')  AS FUNCION       
                        FROM 
                            ADMIN.GG_TPROFESIONAL   A, 
                            ADMIN.HD_RHERMOPROFE    B
                        WHERE
                                A.COD_RUTPRO        = B.COD_RUTPAC 
                            AND B.ID_TDHOJADIARIA   = '$HD' 
                            $where    
                            AND B.IND_ESTADO        = '1' 
                          
                        ";
            return $sm_sql;
    }
    
    public function sqlExisteimedico($empresa,$numfichae){

        $sQuety = " 
                    SELECT 
                       H.ID_IMEDICO                 AS ID, 
                       H.NUM_FICHAE, 
                       H.COD_USRCREA, 
                       H.FEC_USRCREA, 
                       H.COD_USRAUDITA, 
                       H.FEC_USRAUDITA, 
                       H.IND_ESTADO
                    FROM 
                        ADMIN.HD_IMEDICO H
                    WHERE
                        H.NUM_FICHAE = '$numfichae'
                    ";

        return $sQuety;
    }
    
    public function sqlInformacionComplementaria($empresa,$numfichae){
        $sQuety = "SELECT 
                        H.ID_IMEDICO, 
                        H.NUM_FICHAE, 
                        H.COD_USRCREA, 
                        H.FEC_USRCREA, 
                        H.COD_USRAUDITA, 
                        H.FEC_USRAUDITA, 
                        H.IND_ESTADO, 
                    
                        H.TXTACCESOVAS_1, 
                        H.TXTACCESOVAS_2, 
                        
                        --H.NUM_DIASVAS_1,
                        --H.NUM_DIASVAS_2, 
                        
                        TO_CHAR(H.FEC_DIASVAS_1,'YYYY-MM-DD')        AS FEC_DIASVAS_1,
                        TO_CHAR(H.FEC_DIASVAS_2,'YYYY-MM-DD')        AS FEC_DIASVAS_2,
                        
                        TRUNC(sysdate-H.FEC_DIASVAS_1)               AS NUM_DIASVAS_1,
                        TRUNC(sysdate-H.FEC_DIASVAS_2)               AS NUM_DIASVAS_2,
                
                        H.NUM_ARTERIAL, 
                        H.NUM_VENOSO, 
                        H.NUM_INICIO, 
                        H.NUM_MANTENCION, 
                        H.NUM_QT, 
                        H.NUM_QB, 
                        H.NUM_QD, 
                        H.NUM_UFMAX, 
                        H.NUM_K, 
                        H.NUM_NA, 
                        H.NUM_CONCENTRADO, 
                        H.NUM_HEPARINA_MAN, 
                        H.NUM_HEPARINA_INICIO, 
                        H.NUM_TROCAR_VENOSO, 
                        H.NUM_TROCAR_ARTERIAL,
                        H.NUM_PESOSECO 
                    FROM 
                        ADMIN.HD_IMEDICO H
                    WHERE
                        H.NUM_FICHAE = '$numfichae' AND H.IND_ESTADO = 1
                ";
        
            return $sQuety;   
            
            //TRUNC(MONTHS_BETWEEN(SYSDATE,H.FEC_DIASVAS_1)/12)              AS NUM_DIASVAS_1,
            //TRUNC(MONTHS_BETWEEN(SYSDATE,G.FEC_DIASVAS_2)/12)              AS NUM_DIASVAS_2,

    }
    
    public function sqlInformacionComplementariaPesoSeco($empresa,$numfichae){
        $sQuety = " 
                SELECT 
                    H.ID_IMEDICO, 
                    H.NUM_PESOSECO 
                FROM 
                    ADMIN.HD_IMEDICO H
                WHERE
                    H.NUM_FICHAE = '$numfichae' AND IND_ESTADO = 1
                ";
        
            return $sQuety; 
    }
    
    public function sqlDatosReacionesAdversas($hojadiaria){
        $sQuety = " 
            SELECT 
                    H.ID_RADVERSA                                                AS ID,
                    DECODE(H.ID_RADVERSA,
                                     '1', 'emboleaaerea'
                                    ,'2', 'recperitoneo'
                                    ,'3', 'cefalea'
                                    ,'4', 'arritmias'
                                    ,'5', 'homorragia'
                                    ,'6', 'strocar'
                                    ,'7', 'vomitos'
                                    ,'8', 'dabdominal'
                                    ,'9', 'dprecardial'
                                    ,'10','nauseas'
                                    ,'11','parocardio'
                                    ,'12','prurito' 
                                    
                                    ,'13','hipotension' 
                                    ,'14','racidoperacetico' 
                                    ,'15','infeccionsitiocavas' 
                                    ,'16','escalofrio' 
                                    ,'17','rfiebre' 
                                    ,'18','rbacteremia'
                                    ,'19','rhepatitib'
                                    ,'20','rhepatitic'
                                    ,'21','mprocedimiento'
                                    

                                    )                                           AS IDHTML,
                    H.TXT_OBSERVACIONES                                         AS TXTOBS, 
                    H.IND_ESTADO, 
                    H.COD_USRCREA, 
                    H.FEC_USRFEC, 
                    H.COD_USRAUDITA, 
                    H.FEC_USRAUDITA
                FROM 
                    ADMIN.HD_FREACIONESAD H
                WHERE
                    H.IDHOJADIARIA  =   $hojadiaria AND H.IND_ESTADO = '1'
            ";
        return $sQuety; 
     }
     
      public function sqlbusquedaExamenes($fechaini,$fechafin,$empresa,$num_fichae){
            $sql="    
                SELECT  
                    TO_CHAR(M.IE_FHINDICACION,'DD-MM-YYYY')                     AS FECHA,
                    COUNT(M.IE_FHINDICACION)                                    AS NUM_EXAMENES
                FROM  
                    ADMIN.MD_TINIDICAEXAMEN M
                WHERE  
                    M.IE_FHINDICACION BETWEEN TO_DATE('$fechaini 00:00:00','DD-MM-YYYY hh24:mi:ss') AND TO_DATE('$fechafin 23:59:59','DD-MM-YYYY hh24:mi:ss')    
                        AND M.RC_ID_TIPORC  = '56' 
                        AND M.COD_EMPRESA   = '$empresa'   
                        AND M.IE_NUMFICHAE  = $num_fichae
                GROUP 
                    BY TO_CHAR(M.IE_FHINDICACION, 'DD-MM-YYYY'),M.IE_NUMFOLIO
                HAVING  COUNT(*)> 0
            ";
        return $sql;
    }
    
    public function sql_reacionesAdversas($hojadiaria){
        $sql="  
                SELECT 
                    H.ID_RADVERSA                                               AS ID,
                    H.TXT_OBSERVACIONES                                         AS TXTOBS, 
                    R.TXT_RADVERSA                                              AS NAMEREACION,
                    H.IND_ESTADO, 
                    H.COD_USRCREA, 
                    H.FEC_USRFEC, 
                    H.COD_USRAUDITA, 
                    H.FEC_USRAUDITA
                FROM 
                    ADMIN.HD_FREACIONESAD   H,
                    ADMIN.HD_RADVERSA       R
                WHERE
                    H.IDHOJADIARIA          = $hojadiaria   AND 
                    H.IND_ESTADO            = '1'           AND 
                    H.ID_RADVERSA           = R.ID_RADVERSA
                        
                ";
        return $sql;
    }
     
    public function sqlbusquedanombreexamen($fechaini,$fechafin,$empresa,$num_fichae){
        $sql="    
            SELECT  
                M.IE_ID_INDICAEX, 
                M.RC_ID_TIPORC, 
                M.EI_ID_ESTINDI, 
                M.COD_EXAMEN, 
                M.IE_NUMFOLIO, 
                M.IE_FHINDICACION, 
                M.IE_FHREGISTRO, 
                M.PR_PROFREG, 
                TO_CHAR(M.IE_FHINDICACION,'DD-MM-YYYY')                         AS FEC_INDICACION,
                TO_CHAR(M.IE_FHREGISTRO,'DD-MM-YYYY')                           AS FEC_REGISTRO,
                M.IE_NUMFICHAE, 
                M.COD_EMPRESA, 
                M.PR_NOMBREPROFREG, 
                M.PR_NOMBREPROFEJEC, 
                M.IE_ESCRITICO, 
                M.IE_SERVICIO, 
                M.PR_PROFINDICA, 
                M.PR_NOMBREPROFINDICA, 
                M.TC_ID_TIPOCIERRE, 
                M.IE_FECHATOMA, 
                M.IE_FECHALABORATORIO, 
                M.IE_FECHA_ANULACION, 
                M.IE_FECHATOMAINSITU, 
                M.IE_ESTADO_SOLICITUD, 
                M.IE_FEC_CITACION, 
                M.IE_EXISTE_IMG_PACS, 
                M.IE_EXISTE_INFORME, 
                M.IE_FEC_IMG_PACS, 
                M.IE_FEC_INFORME, 
                M.IE_DIAGMED, 
                M.IE_INDGES, 
                M.IE_NUMEX_RCE, 
                M.IND_ESTADOEXAMEN,
                G.DES_EXAMEN                                                    AS DES_EXAMEN,
                G.DES_EXAMEN_ORIGEN                                             AS DES_EXAMEN_ORIGEN,
                G.COD_EXAM_CSBT                                                 AS COD_EXAM_CSBT
            FROM 
                ADMIN.MD_TINIDICAEXAMEN     M,
                ADMIN.GG_TEXAMENIND         G
            WHERE 
                M.IE_FHINDICACION BETWEEN TO_DATE('$fechaini 00:00:00','DD-MM-YYYY hh24:mi:ss')   AND TO_DATE('$fechafin 23:59:59','DD-MM-YYYY hh24:mi:ss')  
            AND M.RC_ID_TIPORC      = '56' 
            AND M.COD_EMPRESA       = '$empresa'   
            AND M.IE_NUMFICHAE      = '$num_fichae' 
            AND M.COD_EXAMEN        = G.COD_EXAMEN
            AND G.IND_ESTADO        = 'V' 
        ";

        return $sql;
    }
    
    public function sqlExisteCierrexAdmision($AD_ID_ADMISION){
        $sQuety = " 
            SELECT
                AD_ID_ADMISION, 
                CI_ID_CIERRE
            FROM
                ADMIN.URG_TCIERRE
            WHERE
                AD_ID_ADMISION = $AD_ID_ADMISION
            ";
        return $sQuety;
    }
    
    public function sqlExisteFuncion($rutpro,$etapa,$hd){
        $sQuety = " 
            SELECT
                ID_RPROFE
            FROM
                ADMIN.HD_RHERMOPROFE
            WHERE
                COD_RUTPAC      = '$rutpro' 
            AND 
                IND_HDESTAPA    = $etapa
            AND
                ID_TDHOJADIARIA = $hd
            ";
        return $sQuety;
    }
    
    public function sql_guardaHistorial_HD($id,$session,$ip_equipo){
        $sQuery = "
            
            INSERT INTO  
                    ADMIN.HD_HISTO_TDHOJADIARIA(
                    
                        ID_TDHOJADIARIA,
                        NUM_FICHAE,
                        NUM_CITACION,
                        AD_ID_ADMISION,
                        NUM_PESOSECO,
                        NUM_HDPESOANTERIOR,
                        NUM_PESOPREDIALISIS,
                        NUM_INTERDIALISIS,
                        NUM_UFPROGRAMADA,
                        NUM_PESOPOSTDIALISIS,
                        NUM_PESOINTERDIALISIS,
                        USR_CREA,
                        FEC_CREA,
                        USR_AUDITA,
                        FEC_AUDITA,
                        NUM_ALZAINTERDIALISIS,
                        TXTACCESOVAS_1,
                        NUM_DIASVAS_1,
                        TXTACCESOVAS_2,
                        NUM_DIASVAS_2,
                        NUM_TROCAR_ARTERIAL,
                        NUM_TROCAR_VENOSO,
                        NUM_HEPARINA_INICIO,
                        NUM_HEPARINA_MAN,
                        NUM_QT,
                        NUM_QB,
                        NUM_QD,
                        NUM_UFMAX,
                        NUM_K,
                        TXT_OBSMEDICAS,
                        TXT_ENFERMERIA,
                        NUM_CI_FILTRO,
                        NUM_CI_ARTERIAL,
                        NUM_CI_VENOSA,
                        NUM_PS_FILTRO,
                        NUM_PS_ARTERIAL,
                        NUM_PS_VENOSO,
                        TXT_TESTPOTENCIA,
                        NUM_USO_FILTRO,
                        NUM_V_RESIDUAL,
                        NUM_V_ARTERIAL,
                        NUM_V_VENOSA,
                        NUM_NA,
                        NUM_CONCENTRADO,
                        ID_RMDIALISIS,
                        IND_PACIENTE_CORRECTO,
                        IND_CLINEAS,
                        IND_CFILTRO,
                        NUM_T_MONITOR,
                        NUM_CONDUCTIVIDAD,
                        NUM_TEST_RESIDUOS,
                        IND_HIPOTENSION,
                        IND_CALOFRIO,
                        IND_FIEBRE,
                        IND_ICVASCULAR,
                        IND_BACTEREMIA,
                        IND_HEPATITIS_B,
                        IND_HEPATITIS_C,
                        IND_MDPROCEDIMIENTO,
                        ID_TIPOVIA,
                        DATE_REALIZAHD,
                        DATE_FHEGRESO,
                        IND_R_RFIBRAS,
                        IND_C_RFIBRAS,
                        IND_R_PIROGENOS,
                        FEC_DIASVAS_1,
                        FEC_DIASVAS_2,
                        NUM_TOTALUFCONSEGIDA,
                        NUM_VOLSANGREACOMULADA,
                        IND_DESIFCACCIONMAQUINA,
                        IND_DIALIZADORDIAL,
                        IND_HDESTADO,
                        NUM_KT_V,

                        COD_HIST_USRCREA,
                        FEC_HIST_CREA,
                        DES_AUDITA,
                        NUM_IP_EQUIPO
                    )  

                    SELECT
                        ID_TDHOJADIARIA,
                        NUM_FICHAE,
                        NUM_CITACION,
                        AD_ID_ADMISION,
                        NUM_PESOSECO,
                        NUM_HDPESOANTERIOR,
                        NUM_PESOPREDIALISIS,
                        NUM_INTERDIALISIS,
                        NUM_UFPROGRAMADA,
                        NUM_PESOPOSTDIALISIS,
                        NUM_PESOINTERDIALISIS,
                        USR_CREA,
                        FEC_CREA,
                        USR_AUDITA,
                        FEC_AUDITA,
                        NUM_ALZAINTERDIALISIS,
                        TXTACCESOVAS_1,
                        NUM_DIASVAS_1,
                        TXTACCESOVAS_2,
                        NUM_DIASVAS_2,
                        NUM_TROCAR_ARTERIAL,
                        NUM_TROCAR_VENOSO,
                        NUM_HEPARINA_INICIO,
                        NUM_HEPARINA_MAN,
                        NUM_QT,
                        NUM_QB,
                        NUM_QD,
                        NUM_UFMAX,
                        NUM_K,
                        TXT_OBSMEDICAS,
                        TXT_ENFERMERIA,
                        NUM_CI_FILTRO,
                        NUM_CI_ARTERIAL,
                        NUM_CI_VENOSA,
                        NUM_PS_FILTRO,
                        NUM_PS_ARTERIAL,
                        NUM_PS_VENOSO,
                        TXT_TESTPOTENCIA,
                        NUM_USO_FILTRO,
                        NUM_V_RESIDUAL,
                        NUM_V_ARTERIAL,
                        NUM_V_VENOSA,
                        NUM_NA,
                        NUM_CONCENTRADO,
                        ID_RMDIALISIS,
                        IND_PACIENTE_CORRECTO,
                        IND_CLINEAS,
                        IND_CFILTRO,
                        NUM_T_MONITOR,
                        NUM_CONDUCTIVIDAD,
                        NUM_TEST_RESIDUOS,
                        IND_HIPOTENSION,
                        IND_CALOFRIO,
                        IND_FIEBRE,
                        IND_ICVASCULAR,
                        IND_BACTEREMIA,
                        IND_HEPATITIS_B,
                        IND_HEPATITIS_C,
                        IND_MDPROCEDIMIENTO,
                        ID_TIPOVIA,
                        DATE_REALIZAHD,
                        DATE_FHEGRESO,
                        IND_R_RFIBRAS,
                        IND_C_RFIBRAS,
                        IND_R_PIROGENOS,
                        FEC_DIASVAS_1,
                        FEC_DIASVAS_2,
                        NUM_TOTALUFCONSEGIDA,
                        NUM_VOLSANGREACOMULADA,
                        IND_DESIFCACCIONMAQUINA,
                        IND_DIALIZADORDIAL,
                        IND_HDESTADO,
                        NUM_KT_V,

                        '$session',
                        SYSDATE,
                        '',
                        '$ip_equipo'

                    FROM 
                        ADMIN.HD_TDHOJADIARIA 
                    WHERE 
                        ID_TDHOJADIARIA = '$id'
         ";
        
        //H.ID_HISTO_DHOJADIARIA,
           return $sQuery;
    }
        
    public function sql_Listadopremisos($empresa,$LLAVE,$estado){
            
            $where  = '';
            if ($estado == '1') { $where.="  H.IND_ESTADO    = 1  AND ";}
        
            $sQuery = "
                SELECT 
                    H.ID_PEDICION                                               AS ID,
                    H.IND_PERMISO                                               AS IND,
                    
                    (SELECT 
                        COUNT(*)
                    FROM 
                        ADMIN.HD_REGEDICION J
                    WHERE
                        J.COD_TLLAVE = '$LLAVE' 
                    AND 
                        J.IND_ESTADO = 1)                                       AS NUM_REDICION,

                    DECODE(H.IND_ESTADO,
                        '1','PENDIENTE',
                        '0','LISTO',
                        'NO INFORMADO')                                         AS TXT_ESTADO,
                        
                    DECODE(H.IND_ESTADO,
                        '1','P',
                        '0','OK',
                        'NO INFORMADO')                                         AS TXT_ESTADO2,
                        
                    DECODE(H.IND_PERMISO,
                        '1','INGRESO DE PACIENTE',
                        '2','HOJA DIARIA',
                        '3','EGRESO DEL PACIENTE',
                        '4','DESHABILITAR HOJA DIARIA',
                        'NO INFORMADO')                                         AS TXT_PERMISO,
                       
                    DECODE(H.IND_PERMISO,
                        '1','INGRESO DE PACIENTE',
                        '2','HOJA DIARIA',
                        '3','EGRESO DEL PACIENTE',
                        '4','DESHABILITAR HOJA DIARIA',
                        'NO INFORMADO')                                         AS TXT_PERMISO
                FROM 
                    ADMIN.HD_REGEDICION         H, 
                    ADMIN.HD_TSISCORECION       I
                WHERE
                    H.ID_TCORECION  = I.ID_TCORECION    AND 
                    $where 
                    I.COD_TLLAVE    = '$LLAVE'
                ORDER BY
                    H.IND_PERMISO
            ";
        return $sQuery;
    }
    
    public function sql_ListadopremisosxHD($empresa,$HD,$LLAVE,$IDCORRECION){
            $sQuery = "
                SELECT 
                    I.ID_TCORECION                                  AS CORRECION,
                    H.ID_PEDICION                                   AS ID,
                    H.IND_PERMISO                                   AS IND,
                    DECODE(H.IND_PERMISO,
                        '1','INGRESO DE PACIENTE',
                        '2','HOJA DIARIA',
                        '3','EGRESO DEL PACIENTE',
                        '4','DESHABILITAR HOJA DIARIA',
                        'NO INFORMADO')                             AS TXT_PERMISO
                        
                FROM 
                    ADMIN.HD_REGEDICION                             H, 
                    ADMIN.HD_TSISCORECION                           I
                    
                WHERE
                    H.ID_TCORECION          = I.ID_TCORECION        AND 
                    H.COD_TLLAVE            = I.COD_TLLAVE          AND 
                    H.IND_ESTADO            = 1                     AND 
                    H.ID_PEDICION           <> $IDCORRECION         AND
                    I.ID_TDHOJADIARIA       = '$HD'                 AND
                    I.COD_TLLAVE            = '$LLAVE'    
                ORDER BY
                    H.IND_PERMISO
            ";
        return $sQuery;
    }
    
    public function sql_ListadoCodigosGenerados($empresa,$estados,$KEY){
        
        $where      = '';
        if($KEY !== ''){  $where.= " H.COD_TLLAVE  = '$KEY' AND "; }
        
        $sQuery = "
                SELECT 
                    H.ID_TCORECION                                                          AS ID,
                    CASE 
                        WHEN 
                            SYSDATE BETWEEN H.DATE_INICIO AND H.DATE_FINAL
                        THEN '1' ELSE '0'
                    END                                                                     AS TIMERANGE,
                    TO_CHAR(H.DATE_INICIO,  'DD-MM-YYYY hh24:mi')                           AS F_INICIO,
                    TO_CHAR(H.DATE_FINAL,   'DD-MM-YYYY hh24:mi')                           AS F_FINAL,

                    H.COD_TLLAVE                                                            AS KEY,
                    H.PA_ID_PROCARCH                                                        AS SIS,
                    H.ID_TDHOJADIARIA                                                       AS HD,
                    H.AD_ACTIVA                                                             AS ACTIVADO,
                    H.IND_ESTADO                                                            AS ESTADO,
                    H.COD_RUTPRO                                                            AS RUTPRO,
                    H.COD_DIGVER,
                    H.COD_RUTPRO||'-'||H.COD_DIGVER                                         AS RUTPAC,
                    (SELECT 
                        COUNT(*)
                    FROM 
                        ADMIN.HD_REGEDICION J
                    WHERE
                        J.COD_TLLAVE = H.COD_TLLAVE 
                    AND 
                        J.IND_ESTADO = 1)                                                   AS NUM_REDICION,
                    
                            UPPER(A.NOM_APEPAT)
                    ||' '|| UPPER(A.NOM_APEMAT)
                    ||' '|| UPPER(A.NOM_NOMBRE)                                             AS NOM_PROFE,
                   
                    TO_CHAR(H.DATE_INICIO,  'YYYY-MM-DD hh24:mi')                           AS F_INICIO2,
                    TO_CHAR(H.DATE_FINAL,   'YYYY-MM-DD hh24:mi')                           AS F_FINAL2,
                    
                    ROUND((H.DATE_FINAL-H.DATE_INICIO)*24,2)                                AS DIFF,
                    
                    TO_CHAR(TRUNC(SYSDATE) + (H.DATE_FINAL -H.DATE_INICIO),'hh24:mi:ss')    AS ELAPSED,

                    TRUNC((    H.DATE_FINAL - H.DATE_INICIO))                               DIFERENCIA_DIAS,
                    TRUNC(MOD((H.DATE_FINAL - H.DATE_INICIO) *  24 , 24))                   DIFERENCIA_HORAS,
                    TRUNC(MOD((H.DATE_FINAL - H.DATE_INICIO) * (60 * 24), 60))              DIFERENCIA_MINUTOS,
                    TRUNC(MOD((H.DATE_FINAL - H.DATE_INICIO) * (60 * 60 * 24), 60))         DIFERENCIA_SEGUNDOS,

                    H.DATE_INICIO,
                    H.DATE_FINAL,
                    H.TXT_OBSERVACION                                                       AS TXTOBSERVACION,
                    H.COD_EMPRESA,
                    
                    H.COD_CORRECEMP                                                         AS COD_CORRECEMP,
                    
                    DECODE(H.COD_CORRECEMP,
                        '100','H.ANGOL',
                        '107','H.CURACAUTIN',
                        '104','H.TRAGUIEN',
                        '100','H.VICTORIA',
                        'TODOS ESTABLECIMIENTOS')                                           AS TXT_EMPRESA_L,
                    
                    H.COD_CREA,
                    H.DATE_CREA
                FROM 
                    $this->own.HD_TSISCORECION                                  H, 
                    $this->own.GG_TPROFESIONAL                                  A
                WHERE
                    H.AD_ACTIVA     = 1                                         AND
                    $where
                    H.COD_RUTPRO    = A.COD_RUTPRO(+)
                   
                ";
         return $sQuery;
    }
    
    public function sqlExisteKey($pass){
        $sQuery=    " 
                        SELECT COUNT(*) AS NUM FROM ADMIN.HD_TSISCORECION WHERE COD_TLLAVE =  '$pass' 
                    " ;
        //error_log($sQuery);
       return $sQuery;
    }
         
}   
