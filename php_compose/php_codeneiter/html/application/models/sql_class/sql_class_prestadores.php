<?php

class sql_class_prestadores extends CI_Model {

    var $own = 'ADMIN';
    var $ownGu = 'GUADMIN';

    public function sqlValidaClave($clave){
        $clave = strtolower($clave);
        $sQuery = "SELECT 
                    USERNAME,
                    NAME,
                    MIDDLE_NAME, 
                    LAST_NAME,
                    TELEPHONE,
                    EMAIL
                 FROM 
                    $this->ownGu.FE_USERS 
                 WHERE 
                 LOWER(to_char(TX_INTRANETSSAN_CLAVEUNICA)) = '" . strtolower($clave) . "' AND DISABLE = 0";

        return $sQuery;
    }

    //Hace una consulta que permite traer el prestador desde bd
    public function buscar($rutfin){
        $sQuery = "
          SELECT
            A.NOM_NOMBRE,
            A.NOM_APEPAT,
            A.NOM_APEMAT,
            A.EMAILMED,
            A.NUM_TELEFOMED,
            A.COD_TPROFE,
            B.IND_TIPOATENCION
            FROM
            ADMIN.GG_TPROFESIONAL   A,
            ADMIN.GG_TPROFESION     B
            WHERE
            A.COD_RUTPRO = $rutfin AND
            A.COD_TPROFE = B.COD_TPROFE";

        return $sQuery;
    }

    //OBTIENE EL TIPO DE PROFESIONAL EN LA CONSULTA
    public function cargartipo(){
        $sQuery = "
            SELECT 
            IND_TIPOATENCION, 
            DES_TIPOATENCION 
            FROM 
            $this->own.AP_TTIPOATENCION 
            WHERE IND_ESTADO='V'";
        return $sQuery;
    }

    //OBTIENE EL PROFESIONAL DE LA CONSULTA
    public function cargaprof($id)
    {

        $sQuery = "
            SELECT 
            COD_TPROFE, 
            NOM_TPROFE FROM 
            $this->own.GG_TPROFESION 
            WHERE 
            IND_TIPOATENCION= $id 
            AND IND_ESTADO='V'";

        return $sQuery;
    }

    public function consultaPrestador($rutfin)
    {

        $sQuery = "
                SELECT 
                COD_RUTPRO 
                FROM 
                $this->own.GG_TPROFESIONAL 
                WHERE 
                COD_RUTPRO = $rutfin";

        return $sQuery;
    }

    public function consultaPrestadorxEmp($rutfin, $codemp)
    {

        $sQuery = "
                SELECT 
                COD_RUTPRO
                FROM 
                $this->own.AP_TPROFXESTABL 
                WHERE 
                COD_RUTPRO = $rutfin AND COD_EMPRESA = $codemp";

        return $sQuery;
    }
    //Se valida si la cleve es correcta
    public function sqlValidaClavetypo($clave)
    {
        $clave = strtolower($clave);

        $sQuery = "SELECT 
                    USERNAME,
                    NAME,
                    MIDDLE_NAME,
                    LAST_NAME 
                 FROM 
                    fe_users 
                 WHERE 
                 LOWER(TX_INTRANETSSAN_CLAVEUNICA) = '" . strtolower($clave) . "' AND DISABLE = 0";

        return $sQuery;
    }

    public function traeprof($empresa)
    {

        $sQuery = " SELECT 
        G.NOM_APEPAT || ' ' || G.NOM_APEMAT || ' ' || G.NOM_NOMBRE NOMBREPROF, 
        G.COD_RUTPRO COD, 
        H.COD_TPROFE PROF
        FROM 
        $this->own.GG_TPROFESIONAL G,
        $this->own.AP_TTIPOATENCION H
        WHERE 
        G.COD_TPROFE = H.COD_TPROFE AND
        G.COD_EMPRESA = '$empresa'";

        return $sQuery;
    }

    public function traeprof2($empresa)
    {

        $sQuery = "   SELECT A.COD_RUTPRO AS COD,
        A.NOM_APEPAT || ' ' || A.NOM_APEMAT || ' ' || A.NOM_NOMBRE
           AS NOMBREPROF,
        C.DES_TIPOATENCION,
        A.COD_DIGVER,
        C.IND_TIPOATENCION AS PROF
        FROM  
        $this->own.GG_TPROFESIONAL A,
        $this->own.GG_TPROFESION B,
        $this->own.AP_TTIPOATENCION C,
        $this->own.AP_TPROFXESTABL D
        WHERE A.IND_ESTADO = 'V'
                AND A.COD_TPROFE = B.COD_TPROFE
                AND B.IND_TIPOATENCION = C.IND_TIPOATENCION
                AND A.COD_RUTPRO = D.COD_RUTPRO
                AND D.COD_EMPRESA = '$empresa'
                AND D.IND_ESTADO = 'V'
        GROUP BY C.IND_TIPOATENCION,
                A.COD_RUTPRO,
                A.COD_DIGVER,
                A.NOM_APEPAT,
                A.NOM_APEMAT,
                A.NOM_NOMBRE,
                C.DES_TIPOATENCION
        ORDER BY C.IND_TIPOATENCION, A.NOM_APEPAT";

        return $sQuery;
    }


    public function traeactividadtrazadora($rutfin, $empresa, $codfin)
    {

        $sQuery = "SELECT a.cod_poli codpoli,
           a.nom_poli nombre,
           NVL (b.ind_estado, a.ind_estado) ind_estado,
           DECODE (NVL (b.cod_poli, 0), 0, 'N', 'S') asignado
            FROM ADMIN.ap_tpoli a,
                $this->own.ap_tpolixprofesional b,
                $this->own.ap_ttipatexpoli c
            WHERE     a.cod_poli = b.cod_poli(+)
                AND a.cod_poli = c.cod_poli
                AND c.ind_tipoatencion = '$codfin'
                AND b.cod_rutpro(+) = '$rutfin'
                AND b.cod_empresa(+) = '$empresa'
             ORDER BY a.nom_poli";
        return $sQuery;
    }

    public function consultaprof($rutfin, $empresa)
    {

        $sQuery = "SELECT 
            C.IND_TIPOATENCION AS PROF
        FROM  
            ADMIN.GG_TPROFESIONAL A,
            ADMIN.GG_TPROFESION B,
            ADMIN.AP_TTIPOATENCION C,
            ADMIN.AP_TPROFXESTABL D
        WHERE A.IND_ESTADO = 'V'
                AND A.COD_TPROFE = B.COD_TPROFE
                AND B.IND_TIPOATENCION = C.IND_TIPOATENCION
                AND A.COD_RUTPRO = D.COD_RUTPRO
                AND D.COD_EMPRESA = '$empresa'
                AND D.IND_ESTADO = 'V'
                AND A.COD_RUTPRO = $rutfin
        GROUP BY C.IND_TIPOATENCION,
                A.COD_RUTPRO,
                A.COD_DIGVER,
                A.NOM_APEPAT,
                A.NOM_APEMAT,
                A.NOM_NOMBRE,
                C.DES_TIPOATENCION
        ORDER BY C.IND_TIPOATENCION, A.NOM_APEPAT";
        return $sQuery;
    }

    public function consultaIniciales($iniciales)
    {

        $sQuery = "SELECT count(*) AS NUMERO FROM ADMIN.GG_TPROFESIONAL WHERE  COD_PROMED LIKE '$iniciales%'";

        return $sQuery;
    }
    public function consultaprofxestab($rutfin, $codemp)
    {

        $sQuery = "SELECT IND_ESTADO FROM ADMIN.AP_TPROFXESTABL  WHERE COD_RUTPRO = '$rutfin' AND COD_EMPRESA = '$codemp' AND IND_ESTADO = 'V'";

        return $sQuery;
    }

}
