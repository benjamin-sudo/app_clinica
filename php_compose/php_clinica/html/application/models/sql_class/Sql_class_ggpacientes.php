<?php
defined("BASEPATH") or exit("No direct script access allowed");
class sql_class_ggpacientes extends CI_Model {

    var $own         = 'ADMIN';
    var $pabellon    = 'PABELLON';
    var $ownGu       = 'GUADMIN';

    public static function sqlBuscaRutLocalFacil($oracle_tablespace, $codRutPac){
        $sql = "
                Select  MAX(num_nficha) as numfichalocalmax from $oracle_tablespace.GG_TFICHA
		where
		cod_empresa= '$codRutPac'
                       
                ";
        //error_log('sql '.$sql);
        return $sql;
    }

    public function sqlObtieneNCORPAC($oracle_tablespace, $cod_empresa){
        $sql = "Select NUM_CORREL as NUM_CORREL from $oracle_tablespace.GG_TCORREL
		   where
		   cod_empresa= '$cod_empresa' and  ID_CORREL='CORPAC' ";
        return $sql;
    }

    public function sqlConsultaPacienteNEW($oracle_own, $numFichaE, $identifier = '', $codEmpresa, $isnal, $pasaporte  = '', $tipoEx  = '') {
        $wheBusca = '';
        if ($codEmpresa == '29') { $codEmpresa = '029'; }
        if ($isnal == '') { $isnal = 0; }
    
        #SI VIENE NUM_FICHA_E MANDA
        if (!empty($numFichaE)) {
            $wheBusca = " A.NUM_FICHAE = '$numFichaE' AND ";
        } else {
            //1 nacional
            if ($isnal == '1') {
                if (!empty($identifier)) {
                    $wheBusca = " A.COD_RUTPAC = '$identifier' AND (A.IND_EXTRANJERO IN (1,0) OR A.IND_EXTRANJERO IS NULL) AND ";
                }
            } else {
                if ($tipoEx == '2') {
                    $wheBusca = " A.COD_RUTPAC = '$identifier' AND A.IND_EXTRANJERO = 1 AND ";
                } else if ($tipoEx == '1') {
                    if (!empty($pasaporte)) {
                        $pasaporte = strtoupper(trim($pasaporte));
                        $wheBusca = " UPPER(A.NUM_IDENTIFICACION) = '$pasaporte' AND A.IND_EXTRANJERO = 1 AND ";
                    }
                }
            }
        }
    
        #DISTINCT 
        $sQuery = "SELECT
                    M.NUM_FICHAE AS FALLECIDO,
                    '1' AS RNUM,
                    '1' AS RESULT_COUNT,
                    A.NUM_FICHAE AS NUM_FICHAEPACTE,
                    (CASE 
                        WHEN FLOOR(TIMESTAMPDIFF(MONTH, A.FEC_NACIMI, CURDATE()) / 12) <> 0 THEN 
                            FLOOR(TIMESTAMPDIFF(MONTH, A.FEC_NACIMI, CURDATE()) / 12) 
                        ELSE 
                            (CASE 
                                WHEN MOD(TIMESTAMPDIFF(MONTH, A.FEC_NACIMI, CURDATE()), 12) <> 0 THEN 
                                    MOD(TIMESTAMPDIFF(MONTH, A.FEC_NACIMI, CURDATE()), 12) 
                                ELSE 
                                    DATEDIFF(CURDATE(), A.FEC_NACIMI) 
                            END) 
                    END) AS EDAD,
                    A.COD_RUTPAC,
                    A.COD_DIGVER,
                    A.NUM_IDENTIFICACION,
                    A.FEC_VENCEPASPORT,
                    A.IND_EXTRANJERO,
                    A.TIP_IDENTIFICACION,
                    DATE_FORMAT(A.FEC_NACIMI, '%d-%m-%Y') AS FEC_NACIMI,
                    A.IND_TISEXO,
                    A.NUM_FICHAE,
                    A.NOM_NOMBRE,
                    A.NOM_APEPAT,
                    A.NOM_APEMAT,
                    (SELECT 
                        E.NUM_NFICHA 
                     FROM $oracle_own.SO_TCPACTE E 
                     WHERE  
                        E.NUM_FICHAE = A.NUM_FICHAE AND E.COD_EMPRESA= '$codEmpresa') AS NUM_NFICHA,
                    A.NOM_SOCIAL,
                    A.NUM_FICHAE,
                    IFNULL(A.IND_RECNAC, '0') AS IND_RECNAC,
                    A.COD_RUTPAC AS RUTPAC,
                    A.COD_DIGVER AS DIGVERPAC,
                    A.NOM_NOMBRE AS NOMBREPAC,
                    A.NOM_APEPAT AS APEPATPAC,
                    A.NOM_APEMAT AS APEMATPAC,
                    DATE_FORMAT(A.FEC_NACIMI, '%Y-%m-%d') AS FECHANACTO,
                    A.IND_TISEXO AS IND_TISEXO,
                    CASE 
                        WHEN A.IND_TISEXO = 'M' THEN 'MASCULINO'
                        WHEN A.IND_TISEXO = 'F' THEN 'FEMENINO'
                        ELSE 'NO ESPECIFICADO'
                    END AS TIPO_SEXO,
                    A.IND_ETN,
                    A.IND_PERCETN,
                    A.IND_ESTCIV,
                    A.NOM_PAREJA,
                    A.NOM_NPADRE,
                    A.NOM_NMADRE,
                    A.COD_PAIS,
                    A.COD_REGION AS REGION,
                    A.COD_COMUNA,
                    A.COD_CIUDAD,
                    A.COD_VIADIRECCION,
                    A.NOM_DIRECC,
                    A.NUM_CASA AS NCASAL,
                    A.NOM_RESTODIRECC,
                    CASE WHEN A.IND_URBRUR = 'U' THEN 'URBANO' ELSE 'RURAL' END AS DES_SECTOR,
                    A.IND_URBRUR,
                    A.NUM_CELULAR,
                    A.EMAIL,
                    A.IND_FAX,
                    A.COD_RUTTIT,
                    A.NUM_TELEFO1 AS FONO1,
                    A.COD_GRUSAN,
                    A.COD_FACSAN,
                    A.IND_TIPPAC,
                    A.IND_CONDPRAIS,
                    A.IND_TRANS,
                    A.COD_NACIONALIDAD,
                    DATE_FORMAT(A.FEC_IDFONASA, '%d/%m/%Y') AS FEC_IDFONASA,
                    A.IND_RUT,
                    A.IND_REFER,
                    A.OCUPACION,
                    A.LUGAR_TRAB,
                    A.IND_ESTCIV,
                    A.COD_VIADIRECCION AS VIAGENERAL,
                    IFNULL(A.IND_CONDPRAIS, '0') AS IND_CONDPRAIS,
                    IFNULL(G.COD_FAMILIA, '') AS COD_FAMILIA,
                    IFNULL(SUBSTR(G.COD_FAMILIA, 1, 2), '-') AS SECTOR,
                    F.NOM_DIRECC AS DIRECLOCAL,
                    F.NUM_TELEFO1 AS FONO2,
                    F.NUM_TELEFO1_2 AS CELLOCAL,
                    F.NUM_CASA AS LCASAL,
                    F.COD_COMUNAL AS COMUNALOCAL,
                    F.COD_CIUDADL AS CIUDADLOCAL,
                    F.NOM_CONTACTO,
                    F.DIRECC_CONTACTO,
                    F.TELEFO_CONTACTO,
                    F.TELEFO_CONTACTO_2 AS CELCONTACTO,
                    COD_SECTOR,
                    F.COD_VIADIRECCION AS VIADIREL,
                    IFNULL(NUM_CORPAC, 0) AS ESOPACTE,
                    F.COD_VIADIRECCION AS VIA,
                    F.NUM_CORPAC,
                    F.NUM_NFICHA AS FLOCAL,
                    IFNULL(G.FEC_ELIMIN, NULL) AS FECHA_ELIMINACION,
                    CASE 
                        WHEN G.IND_ESTADO = 'E' THEN 'ELIMINADO'
                        WHEN G.IND_ESTADO = 'V' THEN 'INSCRITO'
                        ELSE '-'
                    END AS INSCRITO,
                    CASE 
                        WHEN M.IND_ESTADO = 'V' THEN 'FALLECIDO'
                        ELSE 'VIVO'
                    END AS MUERTO,
                    A.REP_LEGAL,
                    A.IND_PREMATURO,
                    A.EDAD_GESTA_SEMANA, 
                    A.EDAD_GESTA_DIAS, 
                    A.EDAD_CORREGIDA_SEMANA, 
                    A.EDAD_CORREGIDA_DIAS,
                    A.IND_NIVEL_EDUCACIONAL,
                    A.IND_POBLACION_MIGRANTE,
                    (SELECT 
                        IND_PREVIS 
                     FROM 
                        $oracle_own.SO_TTITUL C 
                     WHERE A.COD_RUTTIT = C.COD_RUTTIT) AS IND_PREVIS,
                    CASE 
                        WHEN A.TIP_IDENTIFICACION = '1' THEN 'PASAPORTE'
                        WHEN A.TIP_IDENTIFICACION = '2' THEN 'DNI'
                        ELSE 'NO INFORMADO'
                    END AS TXT_IDENTIFACION,
                    DATE_FORMAT(FEC_VENCEPASPORT, '%d/%m/%Y') AS FECVENCEPASPORT,
                    A.IND_CORTEINTERA AS PRILONCO
                FROM
                    $oracle_own.GG_TGPACTE A
                LEFT JOIN $oracle_own.SO_TCPACTE F ON A.NUM_FICHAE = F.NUM_FICHAE AND F.COD_EMPRESA = '$codEmpresa' AND F.IND_ESTADO = 'V'
                LEFT JOIN $oracle_own.IN_TMIEMBROS G ON F.COD_RUTPAC = G.COD_RUTPAC AND F.COD_EMPRESA = G.COD_EMPRESA AND G.IND_ESTADO = 'V'
                LEFT JOIN $oracle_own.GG_TPACFALLECIDO M ON A.NUM_FICHAE = M.NUM_FICHAE AND M.IND_ESTADO = 'V'
                WHERE
                    $wheBusca
                    A.IND_ESTADO = 'V';
                ";
    
        return $sQuery;
    }
    

    public static function sqlObtieneNfichaLocal($oracle_tablespace, $cod_empresa)
    {
        $sql = "Select  MAX(num_nficha) as numfichalocalmax from $oracle_tablespace.GG_TFICHA
		   where
		   cod_empresa= '$cod_empresa' ";
        //error_log('sql '.$sql);
        return $sql;
    }

    public static function sqlUpdateNfichaLocal($oracle_tablespace, $cod_empresa, $num_nficha)
    {

        $sql = "Update $oracle_tablespace.GG_TFICHA set " .
            "num_nficha= '$num_nficha' " .
            "where " .
            "cod_empresa= '$cod_empresa' ";
        return $sql;
    }

    public static function sqlTraeDatosTitularxRut($oracle_own, $rut){
        $sQuery = "SELECT
                        C.COD_RUTPAC,
                        C.COD_DIGVER,
                        B.COD_RUTTIT, 
                        B.COD_DIGVER, 
                        B.NOM_NOMBRE,
                        B.NOM_APEPAT,
                        B.NOM_APEMAT,
                        B.IND_PREVIS,
                        B.NUM_RUTINS,
                        B.IND_ESTADO,
                        D.NOM_INSEMP,
                        A.NOM_PREVIS
                    FROM
                        ADMIN.GG_TDATPREV     A,
                        ADMIN.SO_TTITUL       B,
                        ADMIN.GG_TGPACTE      C,
                        ADMIN.GG_TINSEMP      D
                    WHERE
                        A.IND_PREVIS    = B.IND_PREVIS
                    AND
                        B.COD_RUTTIT    = C.COD_RUTTIT
                    AND  
                        B.NUM_RUTINS    = D.COD_RUTINS
                    AND
                        C.NUM_FICHAE    = '$rut'
                    AND
                        A.IND_ESTADO    = 'V' 
                ";
        return $sQuery;
    }


    public function sqlExisteDatosLocales($ownf,$numFichae, $codEmpresa)
    {
        $sQuery = " 
            
                SELECT 
                    COUNT(*) AS NUM
                FROM $this->own.SO_TCPACTE F
                
                WHERE 
                        F.NUM_FICHAE    = $numFichae
                    AND F.COD_EMPRESA   = '" . $codEmpresa . "'
                ";
        return $sQuery;
    }


    public function sqlTraeDatosLocalesPac($mysql_db, $Ficha_e, $empresa_cod)
{
    $sQuery = "
        SELECT
            A.COD_RUTPAC,
            F.NUM_NFICHA AS NUM_NFICHA,
            F.NOM_DIRECC AS DIRECLOCAL,
            F.NUM_CASA AS LNCASA,
            F.NUM_TELEFO1 AS FONO2,
            F.NUM_TELEFO1_2 AS CELLOCAL,
            F.NOM_CONTACTO,
            F.DIRECC_CONTACTO,
            F.TELEFO_CONTACTO,
            F.TELEFO_CONTACTO_2 AS CELCONTACTO,
            
            (SELECT 
                IF(G.IND_ESTADO = 'E', '', COALESCE(SUBSTRING(G.COD_FAMILIA, 1, 2), '-'))
            FROM $mysql_db.IN_TMIEMBROS G
            WHERE 
                F.COD_RUTPAC = G.COD_RUTPAC AND
                F.COD_EMPRESA = G.COD_EMPRESA AND
                G.IND_ESTADO = 'V'
            LIMIT 1) AS COD_SECTOR,
             
            (SELECT COD_FAMILIA 
            FROM $mysql_db.IN_TMIEMBROS B
            WHERE 
                F.COD_RUTPAC = B.COD_RUTPAC AND
                F.COD_EMPRESA = B.COD_EMPRESA AND
                B.IND_ESTADO = 'V'
            LIMIT 1) AS COD_FAMILIA,

            F.COD_VIADIRECCION AS VIA,
            F.NUM_CASA AS NCASA,
            F.NUM_CORPAC,
            
            F.COD_CIUDADL,
            F.COD_COMUNAL,
            F.COD_REGIONL,
            
            A.REP_LEGAL,
            A.OCUPACION
        FROM
            $mysql_db.GG_TGPACTE A,
            $mysql_db.SO_TCPACTE F
        WHERE
            F.NUM_FICHAE = $Ficha_e
        AND F.COD_EMPRESA = '" . $empresa_cod . "'
        AND A.NUM_FICHAE = F.NUM_FICHAE
    ";

    return $sQuery;
}


    public static function sqlConsultaFicLoal($oracle_own, $fLPaciente, $codEmpresa)
    {
        $sQuery = "
                SELECT
                    A.NUM_FICHAE,
                    B.NOM_NOMBRE,
                    B.NOM_APEPAT,
                    B.NOM_APEMAT,
                    B.COD_DIGVER,
                    B.COD_RUTPAC
                FROM
                    $oracle_own.SO_TCPACTE A,
                    $oracle_own.GG_TGPACTE B
                WHERE
                        A.COD_EMPRESA   = '$codEmpresa'
                    AND A.NUM_NFICHA    = $fLPaciente
                    AND A.NUM_FICHAE    = B.NUM_FICHAE";
        return $sQuery;
    }

    public function sqlTraePrevisionPaciente($oracle_own, $rut)
    {

        $sQuery = "
                        SELECT
                            A.IND_PREVIS,
                            A.NOM_PREVIS,
                            B.NOM_NOMBRE,
                            B.NOM_APEPAT,
                            B.NOM_APEMAT,
                            D.NOM_INSEMP,
                            B.COD_RUTTIT,
                            B.COD_DIGVER
                        FROM
                            $oracle_own.GG_TDATPREV     A,
                            $oracle_own.SO_TTITUL       B,
                            $oracle_own.GG_TGPACTE      C,
                            $oracle_own.GG_TINSEMP      D
                        WHERE
                            A.IND_PREVIS    = B.IND_PREVIS
                        AND B.COD_RUTTIT    = C.COD_RUTTIT
                        AND B.NUM_RUTINS    = D.COD_RUTINS
                        AND C.COD_RUTPAC    = '" . $rut . "'
                        AND A.IND_ESTADO    = 'V'
                        ";
        return $sQuery;
    }

    public function sqlTraePrevisionPacienteNfichaE($oracle_own, $numFichaE)
    {
        $sQuery = "
                    SELECT
                        A.IND_PREVIS,
                        A.NOM_PREVIS,
                        B.NOM_NOMBRE,
                        B.NOM_APEPAT,
                        B.NOM_APEMAT,
                        D.NOM_INSEMP,
                        B.COD_RUTTIT,
                        B.COD_DIGVER
                    FROM
                        $oracle_own.GG_TDATPREV A,
                        $oracle_own.SO_TTITUL B,
                        $oracle_own.GG_TGPACTE C,
                        $oracle_own.GG_TINSEMP D
                    WHERE
                        A.IND_PREVIS = B.IND_PREVIS
                    AND B.COD_RUTTIT = C.COD_RUTTIT
                    AND B.NUM_RUTINS = D.COD_RUTINS
                    AND C.NUM_FICHAE = '" . $numFichaE . "'
                    AND A.IND_ESTADO = 'V'
                    ";
        return $sQuery;
    }

    //**************************************************************************
    public static function sqlValidaDNI_PASAPORTE($oracle_own, $codEmpresa, $num_dni, $numID)
    {
        $sQuery = "
                    SELECT
                        G.NUM_FICHAE                    AS NUMFICHAE
                    FROM
                        $oracle_own.GG_TGPACTE          G
                    WHERE
                        G.IND_EXTRANJERO                = 1           AND
                        G.TIP_IDENTIFICACION            = '$numID'    AND
                        G.NUM_IDENTIFICACION            = '$num_dni'    
                ";
        return $sQuery;
    }

    public static function sqlValidaRutFonasa($oracle_own, $codEmpresa, $numFonasa)
    {
        $sQuery = "
                    SELECT
                        G.NUM_FICHAE                    AS NUMFICHAE
                    FROM
                        $oracle_own.GG_TGPACTE          G
                    WHERE
                        G.IND_EXTRANJERO                = 1                 AND
                        G.COD_RUTPAC                    = '$numFonasa'      
                ";
        return $sQuery;
    }

    public static function sqlValidaIdUnico($oracle_own, $codEmpresa, $numfichae)
    {

        $sQuery = " 
                    SELECT
                        G.NUM_FICHAE        AS NUMFICHAE
                    FROM
                        $oracle_own.GG_TGPACTE  G
                    WHERE
                        G.IND_EXTRANJERO    = 1 AND
                        G.NUM_FICHAE        = '$numfichae'   
                    ";

        return $sQuery;
    }
    //**************************************************************************
    public static function sqlTraeCodigoComuna($oracle_own, $codRegion)
    {
        $sQuery = "
                        SELECT
                            C.NOM_REGION        REGION,
                            B.NOM_PROVIN        PROVINCIA,
                            A.NOM_COMUNA        CIUDAD,
                            A.COD_COMUNA        CODIGO
                        FROM
                            $oracle_own.GG_TPROVIN B
                           ,$oracle_own.GG_TREGION C 
                           ,$oracle_own.GG_TCOMUNA A
                        WHERE
                                C.COD_REGION    = '$codRegion'       
                           AND  C.COD_REGION    = B.COD_REGION    
                           AND  B.COD_PROVIN    = A.COD_PROVIN 
                         ORDER BY A.NOM_COMUNA   

           ";
        //error_log($sQuery);
        return $sQuery;
    }

    public static function sqlTraeCiudadAll($oracle_own, $codRegion)
    {
        $sQuery = "
                    SELECT
                        A.COD_CIUDAD CODIGO,
                        A.NOM_CIUDAD CIUDAD
                    FROM
                        $oracle_own.GG_TCIUDAD A
                    WHERE 
                        A.COD_REGION =  '$codRegion'
                    ORDER BY A.NOM_CIUDAD           
                        
	        ";
        //error_log($sQuery);
        return $sQuery;
    }

    public static function sqlTraeComuna($oracle_own, $cod_comuna)
    {
        $sQuery = "
                SELECT
                    NOM_COMUNA
                FROM
                    $oracle_own.GG_TCOMUNA
                WHERE
                    COD_COMUNA = '$cod_comuna'
                  ";
        return $sQuery;
    }

    public static function sqlTraeGenero($oracle_own)
    {
        $sQuery = "SELECT
                    IND_SEXO,
                    NOM_SEXO
               FROM
               $oracle_own.GG_TSEXO
                    WHERE
                    IND_ESTADO = 'V'";
        return $sQuery;
    }

    public static function sqlTraeEtnia($oracle_own)
    {
        $sQuery = "SELECT
                        IND_ETN,
                        NOM_ETN
		FROM
                        $oracle_own.GG_TETNIA
		WHERE
                        IND_ESTADO = 'V'
                        AND IND_ETN NOT IN('11','12')
                        ORDER BY
                        NOM_ETN";
        return $sQuery;
    }

    public static function sqlTraeEstadoCivil($oracle_own)
    {
        $sQuery = "SELECT
		COD_ESTCIV,
		NOM_ESTCIV
		FROM
		$oracle_own.GG_TESTCIV
		WHERE
		IND_ESTADO = 'V'";

        return $sQuery;
    }

    public static function sqlTraePais($oracle_own)
    {
        $sQuery = "
                SELECT
                    COD_PAIS,
                    NOM_PAIS
		FROM
                    $oracle_own.GG_TPAIS
		WHERE
                    IND_ESTADO = 'V'
                    ORDER BY NOM_PAIS
                    
                ";

        return $sQuery;
    }


    public static function sqlComunaEst($oracle_own, $empresa)
    {
        $sQuery = "SELECT
                        COD_COMUNA
		            FROM
                        $oracle_own.GG_TESTABL
		            WHERE
                        COD_ESTABL = $empresa";

        return $sQuery;
    }


    public static function sqlTraeRegionXCodigo($oracle_own)
    {
        $sQuery = "SELECT
                    COD_REGION,
                    NOM_REGION
                    FROM
                        $oracle_own.GG_TREGION
                    WHERE
                        IND_ESTADO = 'V' ";

        return $sQuery;
    }

    public static function sqlTraeGrupoSangre($oracle_own)
    {
        $sQuery = "SELECT
		IND_GRUSAN,
		NOM_GRUSAN
		FROM
		$oracle_own.GG_TGRUSAN
		WHERE
		IND_ESTADO = 'V'";

        return $sQuery;
    }

    public static function sqlTraeFactorSangre($oracle_own)
    {
        $sQuery = "SELECT
		IND_FACSAN,
		NOM_FACSAN
		FROM
		$oracle_own.GG_TFACSAN
		WHERE
		IND_ESTADO = 'V'";
        return $sQuery;
    }


    public static function sqlTraePrevision($oracle_own, $restric)
    {

        if ($restric == 1) {
            $restric = "WHERE NOM_PREVIS <> 'PRAIS'";
        }

        $sQuery = "SELECT
		IND_PREVIS,
		NOM_PREVIS
		FROM
		$oracle_own.GG_TDATPREV
		" . $restric . "
		ORDER BY
		NOM_PREVIS";
        return $sQuery;
    }

    public static function sqlTraeEmpresa($oracle_own)
    {
        $sQuery = "SELECT
                    COD_RUTINS,
                    NOM_INSEMP
                FROM
		$oracle_own.GG_TINSEMP
		WHERE
                    IND_TIPO <> 'A'
                    ORDER BY
                    NOM_INSEMP";
        return $sQuery;
    }

    public static function sqlCheckDependiente($oracle_own, $rut)
    {
        $sQuery = "SELECT
					    COUNT(*) cuenta_dependiente
					FROM
					    $oracle_own.SO_TTITUL
					WHERE
					    COD_RUTTIT= $rut
					AND IND_ESTADO= 'V'";
        return $sQuery;
    }

    /**
     * Metodo que consulta si el titular existe
     * @param unknown_type $oracle_own
     * @param unknown_type $cod_rutafiliado
     * @return string
     */
    public static function sqlExisteTitular($oracle_own, $cod_rutafiliado)
    {
        $sQuery = "SELECT
					    ROUND(sysdate-fec_audita) dias
					FROM
					    $oracle_own.SO_TTITUL
					WHERE
					    COD_RUTTIT= $cod_rutafiliado
					AND IND_ESTADO= 'V'";
        return $sQuery;
    }

    /**
     * Metodo que consulta a isapre
     * @param unknown_type $oracle_own
     * @param unknown_type $isapre
     * @return string
     */
    public static function sqlGetIsapre($oracle_own, $isapre)
    {
        $sQuery = "SELECT
					    IND_TIPO,
					    COD_RUTINS
					FROM
					    $oracle_own.GG_TINSEMP
					WHERE
					    DES_INSTITUCION LIKE '%$isapre%'";
        return $sQuery;
    }
    /**
     *  bUSCA EL RUT DEL TITUTAL DE PACIENTE
     */
    public static function sqlgetTitular($oracle_own, $rutpacte)
    {
        $sQuery = "SELECT 
                            nvl(cod_ruttit,'0') AS RUTITULAR	
                            FROM $oracle_own.GG_TGPACTE
                            WHERE
                            COD_RUTPAC = $rutpacte";
        return $sQuery;
    }

    /**
     *  bUSCA EL RUT DEL TITUTAL DE PACIENTE
     */
    public static function sqlgetPaciente($oracle_own, $identificador, $tipo)
    {

        $where = '';
        if ($tipo == 0 || $tipo == 2) {
            // RUN NACIONAL
            $where .= "COD_RUTPAC = $identificador";
        } else if ($tipo == 1) {
            // PASAPORTE
            $where .= "NUM_IDENTIFICACION = '$identificador'";
        }

        $sQuery = "SELECT 
                    NOM_NOMBRE,
                    NOM_APEPAT,
                    NOM_APEMAT	
                   FROM $oracle_own.GG_TGPACTE
                   WHERE
                    $where";
        return $sQuery;
    }


    /**
     * metodo para consultar cod bloqueo
     */
    public static function sqlCodBloqueoFo($oracle_own, $cod_cybl)
    {
        $sQuery = "SELECT
					    ind_tipobloqueo AS CAMPO1
					FROM
					    $oracle_own.GG_TBLOQFONASA
					WHERE
					    COD_BLOQUEO = '$cod_cybl' and
						ind_tipobloqueo is not null";
        return $sQuery;
    }
    public static function sqlEsTitularSSAN($oracle_own, $cod_rutafiliado)
    {
        /*if ($cod_rutafiliado == '')
			''$cod_rutafiliado = 0;*/
        $sQuery = "SELECT
					    IND_PREVIS AS CAMPO1
					FROM
					    $oracle_own.SO_TTITUL
					WHERE
					    COD_RUTTIT= '$cod_rutafiliado'
					";
        return $sQuery;
    }
    public static function sqlTitularSSAN($oracle_own, $cod_rutafiliado)
    {
        /*if ($cod_rutafiliado == '')
			''$cod_rutafiliado = 0;*/
        $sQuery = "SELECT
					    count(COD_RUTTIT) AS EXISTE
					FROM
					    $oracle_own.SO_TTITUL
					WHERE
					    COD_RUTTIT= $cod_rutafiliado
					";
        return $sQuery;
    }
    
    
    public static function sqlInfoTitularSSAN($oracle_own, $cod_rutafiliado) {
        $sQuery = "SELECT
                        COD_RUTTIT AS CAMPO1,
                        COD_DIGVER AS CAMPO2,
                        NOM_NOMBRE AS CAMPO3,
                        NOM_APEPAT AS CAMPO4,
                        NOM_APEMAT AS CAMPO5,
                        IND_PREVIS AS CAMPO6,
                        nvl(NUM_RUTINS,0) AS CAMPO7,
                        IND_ESTADO AS CAMPO8,
                        COD_USRCREA AS CAMPO9,
                        to_char(FEC_USRCREA,'dd/mm/yyyy hh24:mi:ss') AS CAMPO10,
                        COD_USUARI AS CAMPO11,
                        to_char(FEC_AUDITA,'dd/mm/yyyy hh24:mi:ss') AS CAMPO12,
                        to_char(FEC_VENCLA,'dd/mm/yyyy') AS CAMPO13,
                        nvl(NUM_RUTEMP,0) AS CAMPO14,
                        nvl(CAN_PACIEN,0) AS CAMPO15,
                        COD_ESTABL AS CAMPO16,
                        COD_EMPRESA AS CAMPO17,
                        CREDENCIAL AS CAMPO18,
                        DES_BLOQUEO AS CAMPO19,
                        to_char(SYSDATE,'dd/mm/yyyy hh24:mi:ss') AS CAMPO20
                    FROM
                        $oracle_own.SO_TTITUL
                    WHERE
                        COD_RUTTIT= $cod_rutafiliado  ";
        return $sQuery;
    }

    public static function sqlinfoDatoLocalxHistorial($mysql_db, $nfichaE, $codEmpresa)
    {
        $sQuery = "
            SELECT 
                COD_RUTPAC,
                NUM_CORPAC,
                NUM_NFICHA,
                NUM_AFICHA,
                IND_ESTPAC,
                COD_SERULA,
                
                DATE_FORMAT(FEC_ULTASI, '%d-%m-%Y %H:%i:%s') AS FEC_ULTASI,
                NUM_CORHOS,
                DATE_FORMAT(FEC_ULTSER, '%d-%m-%Y %H:%i:%s') AS FEC_ULTSER,
                COD_ULTSER,
                IND_ARCHIVO,
                DATE_FORMAT(FEC_IMPRES, '%d-%m-%Y %H:%i:%s') AS FEC_IMPRES,
                
                COD_USRCREA,
                DATE_FORMAT(FEC_USRCREA, '%d-%m-%Y %H:%i:%s') AS FEC_USRCREA,
                COD_USUARI,
                DATE_FORMAT(FEC_AUDITA, '%d-%m-%Y %H:%i:%s') AS FEC_AUDITA,
                
                IND_ESTADO,
                COD_EMPRESA,
                NOM_DIRECC,
                NOM_CONTACTO,
                DIRECC_CONTACTO,
                NUM_FICHAE,
                IND_IMPRES,
                NUM_TELEFO1_2,
                TELEFO_CONTACTO_2,
                NUM_TELEFO1,
                TELEFO_CONTACTO,
                COD_SISTEMA,
                COD_SISTEMAUDITA,
                COD_SECTOR,
                COD_FAMILIA,
                NUM_CASA,
                COD_VIADIRECCION,
                COD_COMUNAL,
                COD_CIUDADL
            FROM
                $mysql_db.SO_TCPACTE
            WHERE
                COD_EMPRESA = '$codEmpresa' AND NUM_FICHAE = $nfichaE";
        return $sQuery;
    }
    
    public function busquedaLastNumfichae(){  
        $sql= "select /*+ RULE */ NUM_CORREL  from ADMIN.gg_tcorrel WHERE id_correl= 'NUM_FICHAE'  for update";//busca el ultimo num_fichae ocupado
        return $sql;
    }
}
   

/*
 *   
        $sQuery = "     
                 SELECT
                    A.COD_DIGVER                                                                AS DIGVERPAC,
                    A.NOM_NOMBRE                                                                AS NOMBREPAC,
                    A.NOM_APEPAT                                                                AS APEPATPAC,
                    A.NOM_APEMAT                                                                AS APEMATPAC,
                    TO_CHAR(A.FEC_NACIMI, 'DD/MM/YYYY')                                         AS FECHANACTO,
                    
                    CASE WHEN A.IND_URBRUR='U' THEN 'URBANO' ELSE 'RURAL' END                   AS DES_SECTOR,
                    
                    A.IND_TISEXO                                                                AS IND_TISEXO,
                    DECODE(A.IND_TISEXO,'M','MASCULINO','F','FEMENINO','NO ESPECIFICADO')       AS TIPO_SEXO,
                    A.IND_ETN,
                    A.IND_PERCETN,
                    A.IND_ESTCIV,
                    A.NOM_PAREJA,
                    A.NOM_NPADRE,
                    A.NOM_NMADRE,
                    A.NOM_DIRECC,
                    A.COD_COMUNA,
                    A.NUM_TELEFO1                                                               AS FONO1,

                    A.NUM_CELULAR,
                    A.EMAIL,
                    A.IND_FAX,
                    A.IND_TIPPAC,
                    A.COD_RUTTIT,
                    A.COD_GRUSAN,
                    A.COD_FACSAN,
                    A.IND_URBRUR,
                    A.COD_RUTPAC rutpac,
                    F.NUM_NFICHA ,
                    F.NOM_DIRECC direclocal,
                    F.NUM_TELEFO1 fono2,
                    F.NUM_TELEFO1_2 cellocal,
                    F.NOM_CONTACTO,
                    F.DIRECC_CONTACTO,
                    F.TELEFO_CONTACTO,
                    F.TELEFO_CONTACTO_2 celcontacto,
                    NVL(A.IND_RECNAC,'0')                                                       AS IND_RECNAC,
                    A.IND_RUT,
                    A.IND_REFER,
                    A.COD_PAIS,
                    A.OCUPACION,
                    A.LUGAR_TRAB,
                    A.IND_ESTCIV,
                    A.NUM_FICHAE num_fichaepacte,
                    A.COD_REGION region,
                    A.COD_CIUDAD ciudad,
                    A.NUM_CASA,
                    A.COD_VIADIRECCION,
                    NVL(A.IND_CONDPRAIS,'0') IND_CONDPRAIS,
                    A.NOM_RESTODIRECC,
                    COD_SECTOR,
                    DECODE(G.IND_ESTADO,'E','',NVL(G.COD_FAMILIA,'')) COD_FAMILIA,
                    F.NUM_CASA ncasal,
                    F.COD_VIADIRECCION viadirel,
                    nvl(NUM_CORPAC,0) esopacte,
                    F.COD_VIADIRECCION via,
                    A.COD_VIADIRECCION viageneral,
                    F.NUM_CASA ncasa,
                    F.NUM_CORPAC,
                    F.NUM_NFICHA flocal,
                    DECODE(G.IND_ESTADO,'E','',nvl(SUBSTR(G.COD_FAMILIA,1,2), '-')) SECTOR,
                    f.cod_comunal comunaLocal,
                    f.cod_ciudadl ciudadLocal,
                    NVL(G.FEC_ELIMIN,NULL) FECHA_ELIMINACION,
                    NVL(decode(G.ind_estado,'E','ELIMINADO','V','INSCRITO'),'-') INSCRITO,
                    NVL(decode(M.IND_ESTADO,'V','FALLECIDO'),'VIVO')                                            MUERTO,
                    A.REP_LEGAL,
                    (SELECT IND_PREVIS FROM $oracle_own.SO_TTITUL C WHERE A.COD_RUTTIT = C.COD_RUTTIT )         IND_PREVIS,
                    IND_EXTRANJERO,
                    NUM_IDENTIFICACION,
                    TIP_IDENTIFICACION,
                    to_char(FEC_VENCEPASPORT,'dd/mm/yyyy') FECVENCEPASPORT,
                    A.IND_CORTEINTERA PRILONCO,A.ID_FONASA IDFONASA,to_char(FEC_IDFONASA,'dd/mm/yyyy')          FECIDFONASA

                FROM
                        $oracle_own.Gg_Tgpacte                          A, 
                        $oracle_own.So_Tcpacte                          F,
                        $oracle_own.in_tmiembros                        G,
                        $oracle_own.GG_TPACFALLECIDO                    M
                WHERE

                    $wheBusca
                    A.NUM_FICHAE        = F.NUM_FICHAE(+)   AND
                    F.COD_EMPRESA(+)    = '$codEmpresa'     AND
                    F.IND_ESTADO(+)     = 'V'               AND
                    F.COD_RUTPAC        = G.COD_RUTPAC(+)   AND
                    F.COD_EMPRESA       = G.COD_EMPRESA(+)  AND 
                    G.IND_ESTADO(+)     = 'V'               AND
                    A.NUM_FICHAE        = M.NUM_FICHAE(+)   AND
                    M.IND_ESTADO(+)     = 'V' 

            ";
        
 */