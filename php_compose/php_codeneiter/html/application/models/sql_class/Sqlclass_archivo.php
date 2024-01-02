<?php

defined("BASEPATH") or exit("No direct script access allowed");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sqlclass_archivo
 *
 * @author esteban.diaz
 */
class sqlclass_archivo extends CI_Model
{

    var $own = 'ADMIN';
    var $ownGu = 'GUADMIN';

    public function sqlValidaClave($clave)
    {
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

    public function citasAPS($empresa, $fecha, $profesional, $idSol)
    {

        if ($idSol) {
            $estado = ',(SELECT UNIQUE AR_ID_ESTADO FROM ' . $this->own . '.AR_TDETSOLICITUD D WHERE D.AR_ID_SOLICITUD = ' . $idSol . ' AND D.NUM_FICHAE = C.NUM_FICHAE) ESTADO';
            $obsNoE = ',(SELECT AR_OBSVNOENCONTRADA FROM ' . $this->own . '.AR_TDETSOLICITUD D WHERE D.AR_ID_SOLICITUD = ' . $idSol . ' AND D.NUM_FICHAE = C.NUM_FICHAE) AR_OBSVNOENCONTRADA';
        } else {
            $estado = ",'' ESTADO";
            $obsNoE = ",'' AR_OBSVNOENCONTRADA";
        }

        $sQuery = "SELECT
                    A.ad_numfolio,
                    A.COD_RUTPRO,
                    C.COD_RUTPAC,
                    C.COD_DIGVER,
                    to_char(A.AD_FHADMISION,'hh24:mi') HOR_CITACION,
                    to_char(A.AD_FHADMISION,'hh24:mi')  HORA,
                    A.AD_FHADMISION,
                    A.NUM_FICHAE,
                    B.NUM_NFICHA,
                    (SELECT COD_FAMILIA FROM ADMIN.IN_TMIEMBROS C WHERE C.COD_RUTPAC = b.COD_RUTPAC AND C.COD_EMPRESA =  B.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,
                    C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' ||  C.NOM_APEMAT NOMBRE_PAC,
                    E.AR_ID_ESTADO ESTADO_GLOB,
                    E.COD_RUTPRO PROF_UBIC,
                    E.COD_SERVIC SERV_UBIC,
                    E.AR_USUREG,
                    E.AR_FECHREG,
                    E.AR_USUEDIT,
                    E.AR_FECHEDIT 
                    $estado
                    $obsNoE
                  FROM
                    $this->own.urg_tadmision A,
                    $this->own.SO_TCPACTE B,
                    $this->own.GG_TGPACTE C,
                    $this->own.AR_TESTADOFICHA_AR E
                  WHERE
                    A.AD_FHADMISION BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') AND
                    A.PR_PROFEDIT = $profesional AND
                    A.COD_EMPRESA = $empresa AND
                    A.ad_activa = 1 AND
                    A.AD_PROCEDENCIA = 58 AND
                    A.NUM_FICHAE = C.NUM_FICHAE AND
                    A.NUM_FICHAE = B.NUM_FICHAE AND
                    A.COD_EMPRESA = B.COD_EMPRESA AND
                    B.NUM_FICHAE = E.NUM_FICHAE(+) AND
                    B.COD_EMPRESA = E.COD_EMPRESA(+)
                  ORDER BY  to_char(A.AD_FHADMISION,'hh24:mi')  ASC";

        return $sQuery;
    }

    public function citasHospital($empresa, $fecha, $profesional, $idSol, $codEspec)
    {

        if ($idSol) {
            $estado = ',(SELECT AR_ID_ESTADO FROM ' . $this->own . '.AR_TDETSOLICITUD D WHERE D.AR_ID_SOLICITUD = ' . $idSol . ' AND D.NUM_FICHAE = C.NUM_FICHAE) ESTADO';
            $obsNoE = ',(SELECT AR_OBSVNOENCONTRADA FROM ' . $this->own . '.AR_TDETSOLICITUD D WHERE D.AR_ID_SOLICITUD = ' . $idSol . ' AND D.NUM_FICHAE = C.NUM_FICHAE) AR_OBSVNOENCONTRADA';
        } else {
            $estado = ",'' ESTADO";
            $obsNoE = ",'' AR_OBSVNOENCONTRADA";
        }

        $sQuery2 = "select 
                    D.COD_RUTPRO,
                    C.COD_RUTPAC,
                    C.COD_DIGVER,
                    A.FEC_CITACI,
                    B.NUM_FICHAE,
                    B.NUM_NFICHA,
                    (SELECT COD_FAMILIA FROM $this->own.IN_TMIEMBROS C WHERE C.COD_RUTPAC = B.COD_RUTPAC AND C.COD_EMPRESA =  B.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,
                    C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' ||  C.NOM_APEMAT NOMBRE_PAC,
                    G.AR_ID_ESTADO ESTADO_GLOB,
                    G.COD_RUTPRO PROF_UBIC,
                    G.COD_SERVIC SERV_UBIC,
                    G.AR_USUREG,
                    G.AR_FECHREG,
                    G.AR_USUEDIT,
                    G.AR_FECHEDIT,
                    TO_CHAR(A.fec_citaci , 'hh24:mi') HORA
                    $estado
                    $obsNoE
                    from 
                    admin.so_tecitas a,
                    $this->own.SO_TCPACTE B,
                    $this->own.GG_TGPACTE C,
                    $this->own.GG_TPROFESIONAL D, 
                    admin.gg_tbloque e,
                    admin.gg_tagenda f,
                    $this->own.AR_TESTADOFICHA_AR G
                   where D.COD_RUTPRO = $profesional and a.cod_especi='$codEspec' and
                   a.fec_citaci between to_date ('$fecha 00:00','dd/mm/yyyy hh24:mi') and to_date ('$fecha 23:59','dd/mm/yyyy hh24:mi')  and
                    A.NUM_CORPAC = B.NUM_CORPAC AND
                    a.cod_empresa=b.cod_empresa and
                    B.NUM_FICHAE = C.NUM_FICHAE AND
                    B.COD_EMPRESA = $empresa AND
                    a.ind_estado='V' AND
                    D.COD_PROMED = A.COD_PROMED AND
                    a.num_correl=e.num_cita(+) AND
                    a.cod_empresa=e.cod_empresa(+) AND
                    e.num_corage=f.num_corage(+) AND
                    e.cod_empresa=f.cod_empresa(+) AND
                    B.NUM_FICHAE = G.NUM_FICHAE(+) AND
                    B.COD_EMPRESA = G.COD_EMPRESA(+)";
        if ($empresa == 100) {
            $sQuery2 .= " UNION ALL
                    SELECT
                    A.COD_RUTPRO,
                    C.COD_RUTPAC,
                    C.COD_DIGVER,
                    A.FEC_CITACION,
                    A.NUM_FICHAE,
                    B.NUM_NFICHA,
                    (SELECT COD_FAMILIA FROM ADMIN.IN_TMIEMBROS C WHERE C.COD_RUTPAC = A.COD_RUTPAC AND C.COD_EMPRESA =  B.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,
                    C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' ||  C.NOM_APEMAT NOMBRE_PAC,
                    E.AR_ID_ESTADO ESTADO_GLOB,
                    E.COD_RUTPRO PROF_UBIC,
                    E.COD_SERVIC SERV_UBIC,
                    E.AR_USUREG,
                    E.AR_FECHREG,
                    E.AR_USUEDIT,
                    E.AR_FECHEDIT,
                    A.HOR_CITACION HORA,
                    '' ESTADO,
                    '' AR_OBSVNOENCONTRADA
                  FROM
                    ADMIN.AP_TCITACION A,
                    ADMIN.SO_TCPACTE B,
                    ADMIN.GG_TGPACTE C,
                    ADMIN.AR_TESTADOFICHA_AR E
                  WHERE
                    A.FEC_CITACION BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') AND
                    A.COD_RUTPRO = $profesional AND
                    A.COD_EMPRESA = $empresa AND
                    A.IND_ESTADO = 'V' AND
                    A.NUM_FICHAE = C.NUM_FICHAE AND
                    A.NUM_FICHAE = B.NUM_FICHAE AND
                    A.COD_EMPRESA = B.COD_EMPRESA AND
                    B.NUM_FICHAE = E.NUM_FICHAE(+) AND
                    B.COD_EMPRESA = E.COD_EMPRESA(+)
                  ORDER BY HORA ASC";
        }


$sQuery="select

D.COD_RUTPRO,

C.COD_RUTPAC,

C.COD_DIGVER,

A.FEC_CITACI,

B.NUM_FICHAE,

B.NUM_NFICHA,

(SELECT COD_FAMILIA FROM $this->own.IN_TMIEMBROS C WHERE C.COD_RUTPAC = B.COD_RUTPAC AND C.COD_EMPRESA =  B.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,

C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' ||  C.NOM_APEMAT NOMBRE_PAC,

G.AR_ID_ESTADO ESTADO_GLOB,

G.COD_RUTPRO PROF_UBIC,

G.COD_SERVIC SERV_UBIC,

G.AR_USUREG,

G.AR_FECHREG,

G.AR_USUEDIT,

G.AR_FECHEDIT,

TO_CHAR(A.fec_citaci , 'hh24:mi') HORA

$estado

$obsNoE

from

admin.so_tecitas a,

$this->own.SO_TCPACTE B,

$this->own.GG_TGPACTE C,

$this->own.GG_TPROFESIONAL D,

admin.gg_tbloque e,

admin.gg_tagenda f,

$this->own.AR_TESTADOFICHA_AR G

where D.COD_RUTPRO = $profesional and a.cod_especi='$codEspec' and

a.fec_citaci between to_date ('$fecha 00:00','dd/mm/yyyy hh24:mi') and to_date ('$fecha 23:59','dd/mm/yyyy hh24:mi')  and

A.NUM_CORPAC = B.NUM_CORPAC AND

a.cod_empresa=b.cod_empresa and

B.NUM_FICHAE = C.NUM_FICHAE AND

B.COD_EMPRESA = $empresa AND

a.ind_estado='V' AND

D.COD_PROMED = A.COD_PROMED AND

a.num_correl=e.num_cita(+) AND

a.cod_empresa=e.cod_empresa(+) AND

e.num_corage=f.num_corage(+) AND

e.cod_empresa=f.cod_empresa(+) AND

B.NUM_FICHAE = G.NUM_FICHAE(+) AND

B.COD_EMPRESA = G.COD_EMPRESA(+)

union all

select

D.COD_RUTPRO,

C.COD_RUTPAC,

C.COD_DIGVER,

A.CI_FECCITACION FEC_CITACI,

B.NUM_FICHAE,

B.NUM_NFICHA,

(SELECT COD_FAMILIA FROM admin.IN_TMIEMBROS C WHERE C.COD_RUTPAC = B.COD_RUTPAC AND C.COD_EMPRESA =  B.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,

C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' ||  C.NOM_APEMAT NOMBRE_PAC,

G.AR_ID_ESTADO ESTADO_GLOB,

G.COD_RUTPRO PROF_UBIC,

G.COD_SERVIC SERV_UBIC,

G.AR_USUREG,

G.AR_FECHREG,

G.AR_USUEDIT,

G.AR_FECHEDIT,

TO_CHAR(A.CI_FECCITACION , 'hh24:mi') HORA

 $estado
 $obsNoE

from

admin.ae_tcitacion a,

admin.SO_TCPACTE B,

admin.GG_TGPACTE C,

admin.GG_TPROFESIONAL D,

admin.ae_tbloque e,

admin.ae_tagenda f,

admin.AR_TESTADOFICHA_AR G

where 

D.COD_RUTPRO = '$profesional' and f.cod_especi='$codEspec' and

a.CI_FECCITACION between to_date ('$fecha 00:00','dd/mm/yyyy hh24:mi') and to_date ('$fecha 23:59','dd/mm/yyyy hh24:mi')  and

A.num_fichae = B.num_fichae AND

a.cod_empresa=b.cod_empresa and

B.NUM_FICHAE = C.NUM_FICHAE AND

B.COD_EMPRESA = '106' AND

a.ind_estado=1 AND

f.id_profesional = d.id_profesional AND

a.bl_id_bloque=e.bl_id_bloque(+) AND

a.cod_empresa=e.cod_empresa(+) AND

e.ag_id_agenda=f.ag_id_agenda(+) AND

e.cod_empresa=f.cod_empresa(+) AND

B.NUM_FICHAE = G.NUM_FICHAE(+) AND

B.COD_EMPRESA = G.COD_EMPRESA(+)";

if ($empresa == 100) {

$sQuery .= " UNION ALL

SELECT

A.COD_RUTPRO,

C.COD_RUTPAC,

C.COD_DIGVER,

A.FEC_CITACION,

A.NUM_FICHAE,

B.NUM_NFICHA,

(SELECT COD_FAMILIA FROM ADMIN.IN_TMIEMBROS C WHERE C.COD_RUTPAC = A.COD_RUTPAC AND C.COD_EMPRESA =  B.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,

C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' ||  C.NOM_APEMAT NOMBRE_PAC,

E.AR_ID_ESTADO ESTADO_GLOB,

E.COD_RUTPRO PROF_UBIC,

E.COD_SERVIC SERV_UBIC,

E.AR_USUREG,

E.AR_FECHREG,

E.AR_USUEDIT,

E.AR_FECHEDIT,

A.HOR_CITACION HORA,

'' ESTADO,

'' AR_OBSVNOENCONTRADA

FROM

ADMIN.AP_TCITACION A,

ADMIN.SO_TCPACTE B,

ADMIN.GG_TGPACTE C,

ADMIN.AR_TESTADOFICHA_AR E

WHERE

A.FEC_CITACION BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') AND

A.COD_RUTPRO = $profesional AND

A.COD_EMPRESA = $empresa AND

A.IND_ESTADO = 'V' AND

A.NUM_FICHAE = C.NUM_FICHAE AND

A.NUM_FICHAE = B.NUM_FICHAE AND

A.COD_EMPRESA = B.COD_EMPRESA AND

B.NUM_FICHAE = E.NUM_FICHAE(+) AND

B.COD_EMPRESA = E.COD_EMPRESA(+)

ORDER BY HORA ASC";
}
//echo $sQuery;
        return $sQuery;
    }

    public function fichasSoli($idSolicitud, $empresa)
    {

        $sQuery = "SELECT
                    C.COD_RUTPAC,
                    C.COD_DIGVER,
                    B.AR_FECHSOLICITUD,
                    A.NUM_FICHAE,
                    D.NUM_NFICHA,
                    (SELECT COD_FAMILIA FROM $this->own.IN_TMIEMBROS C WHERE C.COD_RUTPAC = A.COD_RUTPAC AND C.COD_EMPRESA =  B.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,
                    C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' ||  C.NOM_APEMAT NOMBRE_PAC,
                    E.AR_ID_ESTADO ESTADO_GLOB,
                    E.COD_RUTPRO PROF_UBIC,
                    E.COD_SERVIC SERV_UBIC,
                    E.AR_USUREG,
                    E.AR_FECHREG,
                    E.AR_USUEDIT,
                    E.AR_FECHEDIT,
                    B.COD_RUTPRO,
                    A.AR_ID_ESTADO ESTADO,
                    A.AR_OBSVNOENCONTRADA,
                    to_char(B.AR_FECHSOLICITUD,'dd/mm/yyyy') AS AR_FECHSOLICITUD,
                    (SELECT TO_CHAR(AD_FHADMISION,'HH24:MI') FROM ADMIN.URG_TADMISION F WHERE A.NUM_FICHAE = F.NUM_FICHAE AND B.COD_EMPRESA = F.COD_EMPRESA AND F.AD_ACTIVA = 1 AND F.AD_PROCEDENCIA = 58 AND B.AR_FECHSOLICITUD = F.AD_FHADMISION AND ROWNUM=1) HORA
                   FROM
                    $this->own.AR_TDETSOLICITUD A,
                    $this->own.AR_TSOLICITUD B,
                    $this->own.GG_TGPACTE C,
                    $this->own.SO_TCPACTE D,
                    $this->own.AR_TESTADOFICHA_AR E
                   WHERE
                    C.NUM_FICHAE = D.NUM_FICHAE AND
                    D.COD_EMPRESA = B.COD_EMPRESA AND
                    A.AR_ID_SOLICITUD = $idSolicitud AND
                    A.NUM_FICHAE = E.NUM_FICHAE(+) AND
                    A.AR_ID_SOLICITUD = B.AR_ID_SOLICITUD AND
                    A.NUM_FICHAE = C.NUM_FICHAE(+) AND
                    E.COD_EMPRESA(+) = $empresa AND
                    B.COD_EMPRESA = $empresa
                    order by A.AR_ID_DETSOL asc";

        return $sQuery;
    }

    public function sqlProfesionales($empresa)
    {

        if ($empresa == 303) {
            $fitroEmp = "A.COD_RUTPRO IN (SELECT COD_RUTPRO FROM $this->own.AP_TBLOQUEOAGENDA WHERE COD_EMPRESA = $empresa)";
        } else {
            $fitroEmp = "A.COD_PROMED IN (SELECT COD_PROMED FROM $this->own.GG_TAGENDA WHERE COD_EMPRESA = $empresa )";
        }

        $sQuery = "SELECT
                    A.COD_RUTPRO,   A.NOM_NOMBRE ||' ' || A.NOM_APEPAT ||' ' || A.NOM_APEMAT NOM_PROFE,A.NOM_APEPAT,
                    C.DES_TIPOATENCION,A.COD_DIGVER,C.IND_TIPOATENCION
                    FROM
                    $this->own.GG_TPROFESIONAL A,
                    $this->own.GG_TPROFESION B,
                    $this->own.AP_TTIPOATENCION C                       
                    WHERE
                    A.IND_ESTADO = 'V' AND
                    A.COD_TPROFE = B.COD_TPROFE AND
                    B.IND_TIPOATENCION = C.IND_TIPOATENCION AND
                    $fitroEmp
                    GROUP BY
                    C.IND_TIPOATENCION,A.COD_RUTPRO, A.COD_DIGVER,A.NOM_APEPAT, A.NOM_APEMAT, A.NOM_NOMBRE, C.DES_TIPOATENCION,A.NOM_APEPAT
                    UNION ALL
                    SELECT
                    A.COD_RUTPRO,   A.NOM_NOMBRE ||' ' || A.NOM_APEPAT ||' ' || A.NOM_APEMAT NOM_PROFE,A.NOM_APEPAT,
                    C.DES_TIPOATENCION,A.COD_DIGVER,C.IND_TIPOATENCION
                    FROM
                    $this->own.GG_TPROFESIONAL A,
                    $this->own.GG_TPROFESION B,
                    $this->own.AP_TTIPOATENCION C,
                    $this->own.AP_TPROFXESTABL D                        
                    WHERE
                    A.IND_ESTADO = 'V' AND
                    D.IND_ESTADO = 'V' AND
                    A.COD_RUTPRO = D.COD_RUTPRO AND
                    A.COD_TPROFE = B.COD_TPROFE AND
                    B.IND_TIPOATENCION = C.IND_TIPOATENCION AND
                    D.COD_EMPRESA = $empresa    
                    GROUP BY
                    C.IND_TIPOATENCION,A.COD_RUTPRO, A.COD_DIGVER,A.NOM_APEPAT, A.NOM_APEMAT, A.NOM_NOMBRE, C.DES_TIPOATENCION,A.NOM_APEPAT
                    ORDER BY
                    IND_TIPOATENCION,  NOM_APEPAT";

        return $sQuery;
    }

    function sqlBuscaHist($NumFicha, $RutPaciente, $empresa)
    {

        if (empty($NumFicha)) {
            $xFiltro = " GG.COD_RUTPAC = '$RutPaciente' ";
        } else if (empty($RutPaciente)) {
            $xFiltro = " AR.NUM_NFICHA = $NumFicha ";
        } else {
            $xFiltro = " AR.NUM_NFICHA = $NumFicha AND GG.COD_RUTPAC = '$RutPaciente' ";
        }

        $sQuery = "SELECT       
                    AR.NUM_NFICHA,        
                    AR.PROFTRASLADA,
                    C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' || C.NOM_APEMAT  NOM_PROT, 
                    E.NAME NOM_FEUS,     
                    F.NAME FUN_SACA,           
                    AR.COD_RUTPRO,        
                    B.NOM_NOMBRE ||' ' || B.NOM_APEPAT ||' ' || B.NOM_APEMAT NOM_PRO,            
                    AR.COD_SERVIC,
                    (SELECT D.NOM_SERVIC FROM $this->own.GG_TSERVICIO D,  $this->own.GG_TSERVICIOXEMP E WHERE D.COD_SERVIC = AR.COD_SERVIC AND  D.ID_SERDEP = E.ID_SERDEP AND  E.COD_EMPRESA = AR.COD_EMPRESA) NOM_SERVIC,              
                    EST.AR_DESCRIPCIONEST,
                    AR.AR_ID_ESTADO,
                    AR.COD_USUREG,    
                    TO_CHAR(AR.FECH_REG,'dd/mm/yyyy / hh24:mi') FECHAREG,
                    TO_CHAR(D.AR_FECHSOLICITUD, 'dd/mm/yyyy') FECH_SOL,
                    GG.COD_RUTPAC ||'-' || GG.COD_DIGVER RUT_PACIENTE,            
                    GG.NOM_NOMBRE ||' ' || GG.NOM_APEPAT ||' ' ||  GG.NOM_APEMAT GG_NOM_NOMBRES,
                    D.AR_MOTIVOSOL
                FROM
                    $this->own.AR_HISTMOVFICHAS AR,    
                    $this->own.GG_TPROFESIONAL B,
                    $this->own.AR_ESTADOS EST,        
                    $this->own.GG_TGPACTE GG,
                    $this->own.GG_TPROFESIONAL C,
                    $this->own.AR_TSOLICITUD D,
                    $this->ownGu.FE_USERS E,
                    $this->ownGu.FE_USERS F
                WHERE        
                    AR.COD_EMPRESA = $empresa AND 
                    AR.COD_RUTPRO = B.COD_RUTPRO(+) AND
                    D.AR_ID_SOLICITUD(+) = AR.AR_IDSOL AND
                    AR.AR_ID_ESTADO = EST.AR_ID_ESTADO AND 
                    AR.NUM_FICHAE = GG.NUM_FICHAE AND
                    C.COD_RUTPRO(+) = AR.PROFTRASLADA AND
                    AR.PROFTRASLADA = E.TX_INTRANETSSAN_RUN(+) AND
                    E.DISABLE(+) = 0 AND
                    AR.FUNC_SACA = F.TX_INTRANETSSAN_RUN(+) AND
                    F.DISABLE(+) = 0 AND
                    $xFiltro
                    ORDER BY AR.AR_ID_HIST DESC";
        //error_log($sQuery);
        return $sQuery;
    }

    public function sqlbuscaFuncResp($rutFun)
    {

        $sQuery = "SELECT UNIQUE
                    AR_NOMUSU
                   FROM 
                    $this->own.AR_USURETIRA
                   WHERE 
                    regexp_substr(AR_RUTUSU, '[^-]+', 1, 1) = '$rutFun' AND AR_NOMUSU IS NOT NULL";

        return $sQuery;
    }

    public function numPendientes($empresa)
    {

        $sQuery = "SELECT COUNT(AR_NEWSOL) AS NUMS FROM ADMIN.AR_TSOLICITUD WHERE AR_NEWSOL = 1 AND COD_EMPRESA= $empresa";

        return $sQuery;
    }

    public function sqlUnitServ($empresa, $codServ = '')
    {

        if (!empty($codServ)) {
            $servic = "A.COD_SERVIC = '$codServ' AND";
        } else {
            $servic = "";
        }

        $sQuery = "SELECT 
                    A.COD_SERVIC,
                    A.NOM_SERVIC
                FROM
                    $this->own.GG_TSERVICIO A,
                    $this->own.GG_TSERVICIOXEMP B
                WHERE
                    A.ID_SERDEP = B.ID_SERDEP AND
                    A.IND_SERDEP = 'D' AND
                    B.COD_EMPRESA = $empresa AND
                    $servic
                    A.IND_ESTADO = 'V'
                    AND B.IND_ARCHIVO = '1'                 
                    UNION ALL
                    SELECT 
                    DISTINCT(COD_SERVICIO),
                    B.NOM_SERVIC
                    FROM 
                    $this->own.HO_TCAMA A,
                    $this->own.GG_TSERVICIO B 
                    WHERE COD_EMPRESA  = '$empresa' AND
                    $servic    
                    A.COD_SERVICIO = B.COD_SERVIC
                    UNION ALL
                    SELECT                    
                    COD_SERVIC,
                    NOM_SERVIC
                    FROM
                    $this->own.AR_TSERVICIOS
                    WHERE
                    IND_ESTADO = 1
                    ORDER BY NOM_SERVIC ASC";

        return $sQuery;
    }

    public function selectDependencias($empresa, $codServ = '')
    {

        if (!empty($codServ)) {
            $servic = "A.COD_SERVIC = '$codServ' AND";
        } else {
            $servic = "";
        }

        $sQuery = "SELECT 
                    A.COD_SERVIC,
                    A.NOM_SERVIC
                FROM
                    $this->own.GG_TSERVICIO A,
                    $this->own.GG_TSERVICIOXEMP B
                WHERE
                    A.ID_SERDEP = B.ID_SERDEP AND
                    A.IND_SERDEP = 'D' AND
                    B.COD_EMPRESA = $empresa AND
                    $servic
                    A.IND_ESTADO = 'V'
                    AND B.IND_ARCHIVO = '1'
                    ORDER BY NOM_SERVIC ASC";

        return $sQuery;
    }

    public function selectOtrServicios($empresa, $codServ)
    {

        if (!empty($codServ)) {
            $filtro = "COD_SERVIC = '$codServ' AND";
        } else {
            $filtro = "";
        }

        if (!empty($empresa)) {
            $filtro .= "COD_EMPRESA = '$empresa' AND";
        } else {
            $filtro .= "";
        }

        $sQuery = "SELECT                    
                    COD_SERVIC,
                    NOM_SERVIC
                    FROM
                    ADMIN.AR_TSERVICIOS
                    WHERE
                    $filtro
                    IND_ESTADO = 1";

        return $sQuery;
    }

    function selectUnidadesSol($empresa, $codServ = '')
    {

        if (!empty($codServ)) {
            $servic = "B.COD_SERVIC = '$codServ' AND";
        } else {
            $servic = "";
        }

        $sQuery = "SELECT 
                    DISTINCT(COD_SERVICIO),
                    B.NOM_SERVIC
                    FROM 
                    $this->own.HO_TCAMA A,
                    $this->own.GG_TSERVICIO B 
                    WHERE COD_EMPRESA  = '$empresa' AND
                    $servic    
                    A.COD_SERVICIO = B.COD_SERVIC
                    ORDER BY B.NOM_SERVIC ASC";

        return $sQuery;
    }

    public function sqlTraeFichas($nFicha, $rut, $dv, $nombre, $apePate, $apeMate, $empresa, $numPag, $pastport)
    {
        $where = '';
        if (!empty($nFicha)) {
            $where .= " A.NUM_NFICHA = '$nFicha' AND ";
        }
        if (!empty($rut)) {
            $where .= " A.COD_RUTPAC = '$rut' AND B.COD_DIGVER = '$dv' AND ";
        }
        if (!empty($pastport)) {
            $where .= " B.NUM_IDENTIFICACION = '$pastport' AND ";
        }

        $nombreSq = "";
        $apePateSq = "";
        $apeMateSq = "";
        if (!empty($nombre)) {
            $nombreSq = " B.NOM_NOMBRE LIKE '$nombre%' AND ";
        }
        if (!empty($apePate)) {
            $apePateSq = " B.NOM_APEPAT LIKE '$apePate%' AND ";
        }
        if (!empty($apeMate)) {
            $apeMateSq = " B.NOM_APEMAT LIKE '$apeMate%' AND ";
        }

        $sQuery = "
                SELECT * FROM (
                SELECT  ROWNUM  AS registro,
                    A.COD_RUTPAC,
                    B.COD_DIGVER,
                    A.NUM_NFICHA,
                    B.NOM_NOMBRE,
                    B.NOM_APEPAT,
                    B.NOM_APEMAT,
                    to_char(B.FEC_NACIMI,'dd/mm/yyyy') AS FEC_NACIMI,
                    B.NUM_FICHAE,
                    B.IND_CORTEINTERA PRILONCO,
                    B.NUM_IDENTIFICACION
                FROM 
                    $this->own.SO_TCPACTE A,
                    $this->own.GG_TGPACTE B
                WHERE 
                    $where
                    $nombreSq
                    $apePateSq
                    $apeMateSq
                    A.COD_EMPRESA = $empresa AND
                    A.NUM_FICHAE = B.NUM_FICHAE ) 
                    WHERE registro BETWEEN ($numPag - 1) * 10 + 1 
                    AND  $numPag * 10";
        //error_log($sQuery);
        return $sQuery;
    }

    public function cuentaTraeFichas($nFicha, $rut, $dv, $nombre, $apePate, $apeMate, $empresa, $pastport)
    {
        $where = '';
        if (!empty($nFicha)) {
            $where .= " A.NUM_NFICHA = '$nFicha' AND ";
        }
        if (!empty($rut)) {
            $where .= " A.COD_RUTPAC = '$rut' AND B.COD_DIGVER = '$dv' AND ";
        }
        if (!empty($pastport)) {
            $where .= " B.NUM_IDENTIFICACION = '$pastport' AND ";
        }

        $nombreSq = "";
        $apePateSq = "";
        $apeMateSq = "";
        if (!empty($nombre)) {
            $nombreSq = " B.NOM_NOMBRE LIKE '$nombre%' AND ";
        }
        if (!empty($apePate)) {
            $apePateSq = " B.NOM_APEPAT LIKE '$apePate%' AND ";
        }
        if (!empty($apeMate)) {
            $apeMateSq = " B.NOM_APEMAT LIKE '$apeMate%' AND ";
        }

        $sQuery = "SELECT COUNT(A.COD_RUTPAC) NREGISTROS
                FROM 
                    $this->own.SO_TCPACTE A,
                    $this->own.GG_TGPACTE B
                WHERE 
                    $where
                    $nombreSq
                    $apePateSq
                    $apeMateSq
                    A.COD_EMPRESA = $empresa AND
                    A.NUM_FICHAE = B.NUM_FICHAE";

        return $sQuery;
    }

    public function sqlDatosPact($nFichaE, $empresa, $tipo)
    {

        if ($tipo == 1) {
            $where = 'B.NUM_FICHAE=' . $nFichaE . ' AND ';
        } else if ($tipo == 3) {
            $where = 'B.COD_RUTPAC=' . $nFichaE . ' AND ';
        } else {
            $where = 'A.NUM_NFICHA=' . $nFichaE . ' AND ';
        }

        $sQuery = "SELECT 
                    B.COD_RUTPAC,
                    B.COD_DIGVER,
                    A.NUM_NFICHA,
                    B.NOM_NOMBRE,
                    B.NOM_APEPAT,
                    B.NOM_APEMAT,
                    to_char(B.FEC_NACIMI,'dd/mm/yyyy') AS FEC_NACIMI,
                    B.NUM_FICHAE,
                    B.IND_TISEXO,
                    B.IND_CONDPRAIS,
                    C.NOM_ESTCIV,
                    E.NOM_PREVIS,
                    B.NOM_NPADRE,
                    B.NOM_NMADRE,
                    B.NOM_PAREJA,
                    B.NUM_TELEFO1,
                    B.NUM_CELULAR,
                    B.NOM_DIRECC,
                    F.NOM_COMUNA,
                    B.OCUPACION,
                    A.NOM_CONTACTO,
                    A.TELEFO_CONTACTO,
                    A.NUM_NFICHA FICHALOCAL,
                    G.NOM_ETN,
                    H.NOM_RAZSOC,
                    H.NUM_RUTEMP RUT_ESTABL,
                    H.COD_DVEMP DV_ESTABL,
                    (SELECT COD_FAMILIA FROM $this->own.IN_TMIEMBROS C WHERE C.COD_RUTPAC = B.COD_RUTPAC AND C.COD_EMPRESA =  A.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,
                    I.AR_ID_ESTADO,
                    B.REP_LEGAL,
                    B.COD_RUTPAC || '-' || B.COD_DIGVER RUT_PAC,
                    B.NOM_NOMBRE ||' ' || B.NOM_APEPAT ||' ' || B.NOM_APEMAT NOMBRE_PAC,
                    B.NUM_IDENTIFICACION,
                    DECODE(J.NOM_PAIS,NULL,'NO DECLARADA',J.NOM_PAIS) NACIONALIDAD,
                    B.NOM_SOCIAL
                FROM 
                    $this->own.SO_TCPACTE A, 
                    $this->own.GG_TGPACTE B,
                    $this->own.GG_TESTCIV C,
                    $this->own.SO_TTITUL D,
                    $this->own.GG_TDATPREV E,
                    $this->own.GG_TCOMUNA F,
                    $this->own.GG_TETNIA G,
                    $this->own.SS_TEMPRESAS H,
                    $this->own.AR_TESTADOFICHA_AR I,
                    $this->own.GG_TPAIS J
                WHERE 
                    $where
                    B.COD_NACIONALIDAD = J.COD_PAIS(+) AND
                    A.NUM_FICHAE = I.NUM_FICHAE(+) AND
                    A.NUM_FICHAE = B.NUM_FICHAE AND
                    B.IND_ESTCIV = C.COD_ESTCIV(+) AND
                    B.COD_RUTTIT = D.COD_RUTTIT(+) AND
                    D.IND_PREVIS = E.IND_PREVIS(+) AND
                    B.COD_COMUNA = F.COD_COMUNA(+) AND
                    B.IND_ETN = G.IND_ETN(+) AND
                    A.COD_EMPRESA = H.COD_EMPRESA AND
                    A.COD_EMPRESA = I.COD_EMPRESA(+) AND
                    A.COD_EMPRESA = $empresa";

        return $sQuery;
    }

    //Consultas Entrega de Fichas Clinicas

    function solicitudes($empresa, $fecha, $profesional)
    {

        $prof = '';
        $prof2 = '';
        if ($profesional != 'all') {
            $prof = 'C.COD_RUTPRO = ' . $profesional . ' AND ';
            $prof2 = 'D.COD_RUTPRO = ' . $profesional . ' AND ';
        }
        //        if ($empresa != 303) {
        //            $sQuery = "SELECT UNIQUE
        //                    C.COD_RUTPRO,   C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' || C.NOM_APEMAT NOM_PROFE,
        //                    '' AR_MOTIVOSOL,
        //                    '' COD_ESPECI,
        //                    '' SERVICIO,
        //                    '' COD_SERVIC,
        //                    '' AR_NEWSOL,
        //                    '' COD_SERVIC,
        //                    D.NOM_TPROFE NOMBRE_POLI
        //                   FROM
        //                    $this->own.AP_TAGENDA A,
        //                    $this->own.AP_TDAGENDA B,
        //                    $this->own.GG_TPROFESIONAL C,
        //                    $this->own.GG_TPROFESION D
        //                   WHERE
        //                    C.COD_TPROFE = D.COD_TPROFE AND
        //                    A.NUM_AGENDA = B.NUM_AGENDA AND
        //                    A.COD_RUTPRO = C.COD_RUTPRO AND
        //                    A.IND_ESTADO = 'V' AND
        //                    B.IND_ESTADO = 'V' AND
        //                    $prof
        //                    B.COD_EMPRESA = $empresa AND
        //                    C.COD_RUTPRO IN (SELECT A.COD_RUTPRO FROM $this->own.AP_TCITACION A WHERE
        //                    A.FEC_CITACION BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') AND
        //                    A.COD_EMPRESA = B.COD_EMPRESA AND
        //                    A.IND_ESTADO = 'V' and ind_agendanueva=0)"
        //                    . "UNION ALL
        //                    SELECT UNIQUE
        //                    C.COD_RUTPRO,   C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' || C.NOM_APEMAT NOM_PROFE,
        //                    '' AR_MOTIVOSOL,
        //                    '' COD_ESPECI,
        //                    '' SERVICIO,
        //                    '' COD_SERVIC,
        //                    '' AR_NEWSOL,
        //                    '' COD_SERVIC,
        //                    D.NOM_TPROFE NOMBRE_POLI
        //                   FROM
        //                    $this->own.AP_BLOQUEAGENDA A,
        //                    $this->own.AP_TAGENDA_RECURSO B,
        //                    $this->own.GG_TPROFESIONAL C,
        //                    $this->own.GG_TPROFESION D
        //                   WHERE
        //                    C.COD_TPROFE = D.COD_TPROFE AND
        //                    A.ID_COD_RECURSO = B.ID_COD_RECURSO AND
        //                    B.COD_RUTPRO = C.COD_RUTPRO AND
        //                    A.IND_ESTADO = 1 AND
        //                    B.IND_ESTADO = 1 AND
        //                    $prof
        //                    A.COD_EMPRESA = $empresa AND
        //                    B.COD_RUTPRO IN (SELECT X.COD_RUTPRO FROM ADMIN.AP_TCITACION X WHERE
        //                    X.FEC_CITACION BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') AND
        //                    X.COD_EMPRESA = A.COD_EMPRESA AND
        //                    X.IND_ESTADO = 'V' and ind_agendanueva=1) ORDER BY 1 ASC";
        //        } else {
        $sQuery = "SELECT UNIQUE
                    C.COD_RUTPRO,   C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' || C.NOM_APEMAT NOM_PROFE,
                    '' AR_MOTIVOSOL,
                    '' COD_ESPECI,
                    '' SERVICIO,
                    '' AR_NEWSOL,
                    '' COD_SERVIC,
                    D.NOM_TPROFE NOMBRE_POLI
                   FROM
                    ADMIN.AP_TAGENDA A,
                    ADMIN.AP_TBLOQUE  B,
                    ADMIN.GG_TPROFESIONAL C,
                    ADMIN.GG_TPROFESION D,
                    admin.AP_TCITACIONADMISION e,
                    ADMIN.URG_TADMISION f
                   WHERE
                    C.COD_TPROFE = D.COD_TPROFE AND
                    A.NUM_AGENDA = B.NUM_AGENDA AND
                    A.COD_RUTPRO = C.COD_RUTPRO AND
                    b.num_Citacion=E.IND_TCITACION and
                    b.cod_empresa=e.cod_empresa and
                    e.ind_admision=f.ad_id_admision and
                    A.IND_ESTADO = 'V' AND
                    B.IND_ESTADO = 'V' AND
                    $prof
                    f.AD_FHADMISION BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') AND
                    A.COD_EMPRESA = B.COD_EMPRESA AND
                    f.AD_ACTIVA = 1 AND f.AD_PROCEDENCIA = 58 and
                    B.COD_EMPRESA = $empresa                                         
                UNION ALL                
                    SELECT UNIQUE
                    C.COD_RUTPRO,   C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' || C.NOM_APEMAT NOM_PROFE,
                    '' AR_MOTIVOSOL,
                    '' COD_ESPECI,
                    '' SERVICIO,
                    '' AR_NEWSOL,
                    '' COD_SERVIC,
                    E.NOM_TPROFE NOMBRE_POLI
                   FROM
                    ADMIN.AP_TAGENDA_BLOQUE  A,
                    ADMIN.AP_BLOQUEAGENDA  B,
                    ADMIN.GG_TPROFESIONAL C,
                    ADMIN.AP_TAGENDA_RECURSO D,
                    ADMIN.GG_TPROFESION E,
                    ADMIN.URG_TADMISION F,
                    ADMIN.AP_TCITAXPACIENTE g
                   WHERE
                    C.COD_TPROFE = E.COD_TPROFE AND
                    A.ID_NUMAGENDA = B.ID_NUMAGENDA AND
                    A.ID_COD_RECURSO = D.ID_COD_RECURSO AND
                    C.COD_RUTPRO = D.COD_RUTPRO AND
                    a.num_citacion=g.num_citacion and
                    a.cod_empresa=g.cod_empresa and
                    g.ad_id_admision=f.AD_ID_ADMISION and
                    B.IND_ESTADO = 1 AND
                    $prof2
                    B.COD_EMPRESA = $empresa  and
                    f.AD_FHADMISION BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') and
                    f.AD_ACTIVA = 1 AND f.AD_PROCEDENCIA = 58";
        //        }

        return $sQuery;
    }

    function buscaNotif($empresa)
    {

        $sQuery = "SELECT COUNT(AR_NOTIF) AS NUMS FROM ADMIN.AR_TSOLICITUD WHERE AR_NOTIF = 1 AND COD_EMPRESA= $empresa";

        return $sQuery;
    }

    function solicitudesHospitales($empresa, $fecha, $profesional, $codEspec = '')
    {

        $prof = '';
        $prof2 = '';
        if ($profesional != 'all') {
            $prof = 'AND b.cod_rutpro = ' . $profesional;
            $prof2 = 'C.COD_RUTPRO = ' . $profesional . ' AND ';
        }

        if (!empty($codEspec)) {
            $espec = "a.COD_ESPECI = '$codEspec' and";
        } else {
            $espec = "";
        }

        $sQuery2 = "select 
                    '' SERVICIO,
                    '' COD_SERVIC,
                    '' AR_NEWSOL,
                    a.poli COD_ESPECI, 
                    c.nom_especi nombre_poli, 
                    b.COD_RUTPRO,
                    a.cod_promed codigo, 
                    ' ' AR_MOTIVOSOL,
                    b.nom_nombre ||' '||b.nom_apepat ||' '||b.nom_apemat NOM_PROFE
                    from( select /* +RULE */ a.COD_ESPECI poli, a.cod_promed, sum(decode(a.ind_causal,'I',1,0)) ic, sum(decode(a.ind_causal,'C',1,0)) co , decode(c.am_pm,'AM','AM','') horario_am, 
                    decode(c.am_pm,'PM','PM','') horario_pm, case when c.ind_tipoagenda='0' and c.ind_exthor='0' then 'Institucional' when c.ind_tipoagenda='0' and c.ind_exthor='1' then 'Inst. 500 espec' when 
                    c.ind_tipoagenda='0' and c.ind_exthor='2' then 'Inst. Cons. Llamada' when c.ind_tipoagenda='0' and c.ind_exthor='3' then 'Plan 33000' when c.ind_tipoagenda='1'  then 'Compra Servicio' end TIPO_AGENDA  
                    from $this->own.so_tecitas a, $this->own.gg_tbloque b,$this->own.gg_tagenda c, $this->own.GG_TPROFESIONAL D Where D.COD_PROMED = A.COD_PROMED AND a.ind_estado = 'V'    and a.cod_empresa = '$empresa'    and 
                    b.fec_bloque between to_date('$fecha 00:00','dd/mm/yyyy hh24:mi')  and to_date('$fecha 23:59','dd/mm/yyyy hh24:mi') and $espec
                    a.num_correl = b.num_cita    and a.cod_empresa = b.cod_empresa  and b.num_corage=c.num_corage and b.cod_empresa = C.cod_empresa 
                    group by a.cod_especi, a.cod_promed, c.am_pm ,c.ind_tipoagenda,c.ind_exthor
                    Union All 
                    select /* +RULE */ a.COD_ESPECI poli, a.cod_promed, sum(decode(a.ind_causal,'I',1,0)) ic, sum(decode(a.ind_causal,'C',1,0)) co, decode(a.am_pm,'AM','AM','') horario_am, 
                    decode(a.am_pm,'PM','PM','') horario_pm, case when a.ind_tipocita='0' and a.ind_exthor='0' then 'Institucional' when a.ind_tipocita='0' and a.ind_exthor='1' then 'Inst. 500 espec' when a.ind_tipocita='0' and a.ind_exthor='2' then 'Inst. Cons. Llamada' 
                    when a.ind_tipocita='0' and a.ind_exthor='3' then 'Plan 33000' when a.ind_tipocita='1'  then 'Compra Servicio' end TIPO_AGENDA 
                    from $this->own.so_tecitas a,$this->own.GG_TPROFESIONAL D 
                    Where  D.COD_PROMED = A.COD_PROMED AND  a.ind_estado = 'V'    and a.cod_empresa = '$empresa' and $espec
                    a.fec_citaci between to_date('$fecha 00:00','dd/mm/yyyy hh24:mi')  and to_date('$fecha 23:59','dd/mm/yyyy hh24:mi')    and a.ind_espontanea ='1' 
                    group by a.cod_especi, a.cod_promed, a.am_pm,a.ind_tipocita,a.ind_exthor) a, $this->own.gg_tprofesional b, $this->own.gg_tespec c 
                    where a.cod_promed=b.cod_promed and a.poli = C.cod_especi $prof group by a.poli, a.cod_promed,b.nom_nombre,b.nom_apepat,b.nom_apemat,c.nom_especi,b.COD_RUTPRO";
        if ($empresa == 100) {
            $sQuery2 .= " UNION ALL
                    SELECT UNIQUE
                    '' SERVICIO,
                    '' COD_SERVIC,
                    '' AR_NEWSOL,
                    '' COD_ESPECI,
                    D.NOM_TPROFE NOMBRE_POLI,
                    C.COD_RUTPRO,   
                    C.COD_PROMED,
                    '' AR_MOTIVOSOL,
                    C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' || C.NOM_APEMAT NOM_PROFE
                   FROM
                    $this->own.AP_BLOQUEAGENDA A,
                    $this->own.AP_TAGENDA_RECURSO B,
                    $this->own.GG_TPROFESIONAL C,
                    $this->own.GG_TPROFESION D
                   WHERE
                    A.ID_COD_RECURSO = B.ID_COD_RECURSO AND
                    B.COD_RUTPRO = C.COD_RUTPRO AND
                    C.COD_TPROFE = D.COD_TPROFE AND
                    A.IND_ESTADO = 1 AND
                    B.IND_ESTADO = 1 AND
                    $prof2
                    A.COD_EMPRESA = $empresa AND
                    B.COD_RUTPRO IN (SELECT X.COD_RUTPRO FROM ADMIN.AP_TCITACION X WHERE
                    X.FEC_CITACION BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') AND
                    X.COD_EMPRESA = A.COD_EMPRESA AND
                    X.IND_ESTADO = 'V' and ind_agendanueva=1) ORDER BY 1 ASC";
        }



        $sQuery="SELECT '' SERVICIO,

         '' COD_SERVIC,

         '' AR_NEWSOL,

         a.poli COD_ESPECI,

         c.nom_especi nombre_poli,

         b.COD_RUTPRO,

         a.cod_promed codigo,

         ' ' AR_MOTIVOSOL,

         b.nom_nombre || ' ' || b.nom_apepat || ' ' || b.nom_apemat NOM_PROFE

    FROM (  SELECT                                                 /* +RULE */

                  a.COD_ESPECI poli,

                   a.cod_promed,

                   SUM (DECODE (a.ind_causal, 'I', 1, 0)) ic,

                   SUM (DECODE (a.ind_causal, 'C', 1, 0)) co,

                   DECODE (c.am_pm, 'AM', 'AM', '') horario_am,

                   DECODE (c.am_pm, 'PM', 'PM', '') horario_pm,

                   CASE

                      WHEN c.ind_tipoagenda = '0' AND c.ind_exthor = '0'

                      THEN

                         'Institucional'

                      WHEN c.ind_tipoagenda = '0' AND c.ind_exthor = '1'

                      THEN

                         'Inst. 500 espec'

                      WHEN c.ind_tipoagenda = '0' AND c.ind_exthor = '2'

                      THEN

                         'Inst. Cons. Llamada'

                      WHEN c.ind_tipoagenda = '0' AND c.ind_exthor = '3'

                      THEN

                         'Plan 33000'

                      WHEN c.ind_tipoagenda = '1'

                      THEN

                         'Compra Servicio'

                   END

                      TIPO_AGENDA

              FROM ADMIN.so_tecitas a,

                   ADMIN.gg_tbloque b,

                   ADMIN.gg_tagenda c,

                   ADMIN.GG_TPROFESIONAL D

             WHERE     D.COD_PROMED = A.COD_PROMED

                   AND a.ind_estado = 'V'

                   AND a.cod_empresa = $empresa

                   AND b.fec_bloque BETWEEN TO_DATE ('$fecha 00:00',

                                                     'dd/mm/yyyy hh24:mi')

                                        AND TO_DATE ('$fecha 23:59',

                                                     'dd/mm/yyyy hh24:mi')

                   AND a.num_correl = b.num_cita

                   AND a.cod_empresa = b.cod_empresa

                   AND b.num_corage = c.num_corage

                   AND b.cod_empresa = C.cod_empresa

          GROUP BY a.cod_especi,

                   a.cod_promed,

                   c.am_pm,

                   c.ind_tipoagenda,

                   c.ind_exthor

          UNION ALL

            SELECT                                                 /* +RULE */

                  a.COD_ESPECI poli,

                   a.cod_promed,

                   SUM (DECODE (a.ind_causal, 'I', 1, 0)) ic,

                   SUM (DECODE (a.ind_causal, 'C', 1, 0)) co,

                   DECODE (a.am_pm, 'AM', 'AM', '') horario_am,

                   DECODE (a.am_pm, 'PM', 'PM', '') horario_pm,

                   CASE

                      WHEN a.ind_tipocita = '0' AND a.ind_exthor = '0'

                      THEN

                         'Institucional'

                      WHEN a.ind_tipocita = '0' AND a.ind_exthor = '1'

                      THEN

                         'Inst. 500 espec'

                      WHEN a.ind_tipocita = '0' AND a.ind_exthor = '2'

                      THEN

                         'Inst. Cons. Llamada'

                      WHEN a.ind_tipocita = '0' AND a.ind_exthor = '3'

                      THEN

                         'Plan 33000'

                      WHEN a.ind_tipocita = '1'

                      THEN

                         'Compra Servicio'

                   END

                      TIPO_AGENDA

              FROM ADMIN.so_tecitas a, ADMIN.GG_TPROFESIONAL D

             WHERE     D.COD_PROMED = A.COD_PROMED

                   AND a.ind_estado = 'V'

                   AND a.cod_empresa = $empresa

                   AND a.fec_citaci BETWEEN TO_DATE ('$fecha 00:00',

                                                     'dd/mm/yyyy hh24:mi')

                                        AND TO_DATE ('$fecha 23:59',

                                                     'dd/mm/yyyy hh24:mi')

                   AND a.ind_espontanea = '1'

          GROUP BY a.cod_especi,

                   a.cod_promed,

                   a.am_pm,

                   a.ind_tipocita,

                   a.ind_exthor

          union all

          SELECT                                                 /* +RULE */

                  c.COD_ESPECI poli,

                   d.cod_promed,

                  -- SUM (DECODE (a.ind_causal, 'I', 1, 0)) ic,

                   --SUM (DECODE (a.ind_causal, 'C', 1, 0)) co,

                   SUM( (select DECODE(AC.GR_ID,1,1,3,1,0) 

                   from ADMIN.GG_TACTIVIDADES_AE ac, ADMIN.AE_TGRUPOACTV gra where AC.GR_ID=GRA.GR_ID and ac.cod_actividad = b.COD_ACTIVIDAD)) ic,

                   SUM( (select DECODE(AC.GR_ID,2,1,6,1,0) 

                   from ADMIN.GG_TACTIVIDADES_AE ac, ADMIN.AE_TGRUPOACTV gra where AC.GR_ID=GRA.GR_ID and ac.cod_actividad = b.COD_ACTIVIDAD)) ic,

                   DECODE (c.AG_TIPO_HORARIO, 'M', 'AM', '') horario_am,

                   DECODE (c.AG_TIPO_HORARIO, 'T', 'PM', '') horario_pm,

                   decode(c.ag_tipo,1,'Institucional',2,'Compra de Servicio')

                      TIPO_AGENDA

              FROM ADMIN.ae_tcitacion a,

                   ADMIN.ae_tbloque b,

                   ADMIN.ae_tagenda c,

                   ADMIN.GG_TPROFESIONAL D

             WHERE     D.id_profesional = c.id_profesional

                   AND a.ind_estado = 1

                   AND a.cod_empresa = $empresa

                   AND b.BL_FECBLOQUE BETWEEN TO_DATE ('$fecha 00:00',

                                                     'dd/mm/yyyy hh24:mi')

                                        AND TO_DATE ('$fecha 23:59',

                                                     'dd/mm/yyyy hh24:mi')

                   AND a.BL_ID_BLOQUE = b.BL_ID_BLOQUE

                   AND a.cod_empresa = b.cod_empresa

                   AND b.AG_ID_AGENDA = c.AG_ID_AGENDA

                   AND b.cod_empresa = C.cod_empresa

          GROUP BY c.cod_especi,

                   d.cod_promed,

                   DECODE (c.AG_TIPO_HORARIO, 'M', 'AM', '') ,

                   DECODE (c.AG_TIPO_HORARIO, 'T', 'PM', '') ,

                   c.ag_tipo        

                   ) a,

         ADMIN.gg_tprofesional b,

         ADMIN.gg_tespec c

   WHERE     a.cod_promed = b.cod_promed

         AND a.poli = C.cod_especi

        $prof
     --    AND b.cod_rutpro = 7923441

GROUP BY a.poli,

         a.cod_promed,

         b.nom_nombre,

         b.nom_apepat,

         b.nom_apemat,

         c.nom_especi,

         b.COD_RUTPRO
         
         order by  a.poli";




        return $sQuery;
    }

    function solicitudesProg($empresa, $fecha, $idSol)
    {


        $sQuery = "SELECT 
                    A.COD_RUTPRO,
                    A.COD_SERVIC,
                    A.AR_NUMFICHAS NFICHAS,
                    A.AR_MOTIVOSOL,
                    A.AR_FECHSOLICITUD,
                    B.NOM_APEPAT ||' ' || B.NOM_APEMAT ||' ' ||  B.NOM_NOMBRE NOM_PROFE,
                    (SELECT C.NOM_SERVIC FROM $this->own.GG_TSERVICIO C, $this->own.GG_TSERVICIOXEMP D WHERE D.ID_SERDEP = C.ID_SERDEP AND  C.COD_SERVIC = A.COD_SERVIC AND D.COD_EMPRESA = A.COD_EMPRESA AND rownum = 1) SERVICIO,
                    A.AR_ID_SOLICITUD,
                    A.AR_TIPOSOLICITUD,
                    A.AR_UNITRECEPCIONA,
                    A.AR_USUARETIRAR,
                    A.AR_TIPOSOLI
                   FROM
                    $this->own.AR_TSOLICITUD A,
                    $this->own.GG_TPROFESIONAL B   
                   WHERE
                    A.AR_FECHSOLICITUD BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') AND
                    A.COD_EMPRESA = $empresa AND
                    A.AR_ID_SOLICITUD = $idSol AND
                    A.COD_RUTPRO = B.COD_RUTPRO(+)";

        return $sQuery;
    }

    function solicitudesNoProg($empresa, $fecha, $profesional, $noProg, $codEspec = '', $idSol = '')
    {

        $prof = '';
        if ($profesional != 'all') {
            if ($profesional != 0) {
                $prof = ' AND B.COD_RUTPRO = ' . $profesional . ' ';
            }
        }

        $idSo = '';
        if (!empty($idSol)) {
            $idSo = " AND A.AR_ID_SOLICITUD = $idSol ";
        }

        if (!empty($codEspec)) {
            $filtroEspec = " AND A.COD_SERVIC = '$codEspec'";
        } else {
            $filtroEspec = "";
        }

        if ($noProg == 1) {
            $filtroTipo = " AND A.AR_TIPOSOLICITUD = 1";
        } else if ($noProg == 0) {
            $filtroTipo = " AND A.AR_TIPOSOLICITUD = 0";
        } else {
            $filtroTipo = "";
        }

        if (!empty($fecha)) {
            $fech = "A.AR_FECHSOLICITUD BETWEEN TO_DATE('$fecha 00:00','dd/mm/yy hh24:mi') AND TO_DATE('$fecha 23:59','dd/mm/yy hh24:mi') AND";
        } else {
            $fech = 'AR_NEWSOL = 1 AND';
        }

        $sQuery = "SELECT 
                    A.COD_RUTPRO,
                    A.COD_SERVIC,
                    A.AR_NUMFICHAS NFICHAS,
                    A.AR_MOTIVOSOL,
                    to_char(A.AR_FECHSOLICITUD,'dd/mm/yyyy') AS AR_FECHSOLICITUD,
                    B.NOM_NOMBRE ||' ' || B.NOM_APEPAT ||' ' || B.NOM_APEMAT  NOM_PROFE,
                    (SELECT C.NOM_SERVIC FROM $this->own.GG_TSERVICIO C, $this->own.GG_TSERVICIOXEMP D WHERE D.ID_SERDEP = C.ID_SERDEP AND  C.COD_SERVIC = A.COD_SERVIC AND D.COD_EMPRESA = A.COD_EMPRESA AND ROWNUM = 1) SERVICIO,
                    A.AR_ID_SOLICITUD,
                    A.AR_USUARETIRAR,
                    to_char(A.AR_FECHRESPUESTA,'dd/mm/yyyy') AR_FECHRESPUESTA,
                    A.AR_ID_ESTADO,
                    A.AR_TIPOSOLICITUD,
                    A.AR_FECHDEVOLUCION,
                    A.AR_NEWSOL
                   FROM
                    $this->own.AR_TSOLICITUD A,
                    $this->own.GG_TPROFESIONAL B 
                   WHERE
                    $fech
                    A.COD_EMPRESA = $empresa AND
                    A.COD_RUTPRO = B.COD_RUTPRO(+)
                    $prof 
                    $filtroTipo
                    $filtroEspec
                    $idSo";

        return $sQuery;
    }

    function buscaRespuesta($idSol)
    {
        $sQuery = "SELECT 
                    to_char(A.AR_FECHRESPUESTA,'dd/mm/yyyy') AR_FECHRESPUESTA,
                    A.AR_OBSRESPUESTA,
                    A.AR_USURESPONDE,
                    B.NOM_NOMBRE ||' ' || B.NOM_APEPAT ||' ' || B.NOM_APEMAT  NOM_PROFE,
                    to_char(A.AR_FECHUSURESPUESTA,'dd/mm/yyyy - hh24:mi') AR_FECHUSURESPUESTA 
                   FROM 
                    $this->own.AR_TSOLICITUD A,
                    $this->own.GG_TPROFESIONAL B
                   WHERE  
                    A.AR_ID_SOLICITUD = $idSol AND 
                    A.AR_USURESPONDE IS NOT NULL AND
                    A.AR_USURESPONDE = B.COD_RUTPRO(+)";

        return $sQuery;
    }

    function buscaEstadosFichas($numFichaE = '', $empresa, $NumFicha = '', $RutPaciente = '')
    {

        if (!empty($RutPaciente) && !empty($NumFicha)) {
            $xFiltro = " F.NUM_NFICHA = $NumFicha AND H.COD_RUTPAC = $RutPaciente  AND ";
        } else if (!empty($RutPaciente)) {
            $xFiltro = " H.COD_RUTPAC = $RutPaciente AND ";
        } else if (!empty($NumFicha)) {
            $xFiltro = " F.NUM_NFICHA = $NumFicha AND ";
        } else {
            $xFiltro = " A.NUM_FICHAE =  $numFichaE AND ";
        }

        $sQuery = "SELECT
                    A.AR_IDESTFICHAC,
                    A.COD_RUTPRO,
                    C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' || C.NOM_APEMAT NOMBRE_PROF,
                    A.COD_SERVIC,
                    (SELECT C.NOM_SERVIC FROM ADMIN.GG_TSERVICIO C, ADMIN.GG_TSERVICIOXEMP D WHERE D.ID_SERDEP = C.ID_SERDEP AND  C.COD_SERVIC = A.COD_SERVIC AND D.COD_EMPRESA = A.COD_EMPRESA AND ROWNUM = 1)  NOM_SERVIC,
                    A.AR_ID_ESTADO,
                    B.AR_DESCRIPCIONEST,
                    DECODE(A.AR_FECHEDIT,NULL,TO_CHAR(A.AR_FECHREG,'dd-mm-YYYY / hh24:mi'),TO_CHAR(A.AR_FECHEDIT,'dd-mm-YYYY / hh24:mi')) AR_FECHREG,
                    DECODE(A.AR_USUEDIT,NULL,A.AR_USUREG,A.AR_USUEDIT) AR_USUREG,
                    A.COD_EMPRESA,
                    H.NUM_FICHAE,
                    E.NOM_ESTABL,
                    A.ID_SOLICITUD,
                    F.NUM_NFICHA,
                    (SELECT COD_FAMILIA FROM ADMIN.IN_TMIEMBROS C WHERE C.COD_RUTPAC = H.COD_RUTPAC AND C.COD_EMPRESA =  A.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,
                    TO_CHAR(G.AR_FECHSOLICITUD,'dd-mm-YYYY') FECH_SOLICITUD,
                    H.COD_RUTPAC,
                    H.COD_RUTPAC || '-' || H.COD_DIGVER RUT_PAC,
                    H.NOM_NOMBRE ||' ' || H.NOM_APEPAT ||' ' || H.NOM_APEMAT NOMBRE_PAC,
                    G.AR_MOTIVOSOL
                   FROM
                    $this->own.AR_TESTADOFICHA_AR A,
                    $this->own.AR_ESTADOS B,
                    $this->own.GG_TPROFESIONAL C,
                    $this->own.GG_TESTABL E,
                    $this->own.SO_TCPACTE F,
                    $this->own.AR_TSOLICITUD G,
                    $this->own.GG_TGPACTE H
                   WHERE
                    $xFiltro
                    A.COD_EMPRESA = $empresa AND
                    F.NUM_FICHAE = H.NUM_FICHAE AND
                    A.ID_SOLICITUD = G.AR_ID_SOLICITUD AND
                    A.AR_ID_ESTADO = B.AR_ID_ESTADO AND
                    A.COD_RUTPRO = C.COD_RUTPRO(+) AND
                    A.COD_EMPRESA = E.COD_ESTABL AND
                    A.COD_EMPRESA = F.COD_EMPRESA AND
                    A.NUM_FICHAE = F.NUM_FICHAE";

        return $sQuery;
    }

    function citasSolAps($fecha, $empresa, $rut, $codEsp = '', $nFicha = '')
    {

        if (!empty($rut)) {
            $SQLrut = 'B.COD_RUTPRO = ' . $rut . ' AND';
            $SQLrut1 = 'F.COD_RUTPRO = ' . $rut . ' AND ';
        } else {
            $SQLrut = '';
            $SQLrut1 = '';
        }

        if (!empty($nFicha)) {
            $xFicha = 'B.NUM_NFICHA = ' . $nFicha . ' AND';
        } else {
            $xFicha = '';
        }

        if (!empty($codEsp)) {
            $xPoli = 'a.COD_POLI = ' . $codEsp . ' AND';
        } else {
            $xPoli = '';
        }

        $sQuery = "SELECT UNIQUE
                    F.NOM_NOMBRE ||' ' || F.NOM_APEPAT ||' ' ||  F.NOM_APEMAT NOMBRE_PROF, 
                    'SOME' NOM_ESPECI,
                    C.COD_RUTPAC,
                    C.COD_DIGVER,
                    F.COD_RUTPRO RUTPRO,
                    F.COD_DIGVER DV,
                    B.NUM_NFICHA,
                    h.NOM_POLI,
                    C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' ||  C.NOM_APEMAT NOMBRE_PAC,
                    ' ' AM_PM,
                    to_char(a.AD_FHADMISION,'hh24:mi') HORA,
                    (SELECT COD_FAMILIA FROM ADMIN.IN_TMIEMBROS C WHERE C.COD_RUTPAC = b.COD_RUTPAC AND C.COD_EMPRESA =  B.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA
                  FROM
                    ADMIN.urg_tadmision A,
                    ADMIN.AP_TCITAXPACIENTE d,
                    ADMIN.SO_TCPACTE B,
                    ADMIN.GG_TGPACTE C,
                    ADMIN.GG_TPROFESIONAL F,
                    admin.AP_TAGENDA_BLOQUE g,
                    admin.ap_tpoli h
                  WHERE
                    A.AD_FHADMISION BETWEEN TO_DATE('$fecha 00:00','dd-mm-yyyy hh24:mi') AND TO_DATE('$fecha 23:59','dd-mm-yyyy hh24:mi') AND
                    $SQLrut1
                    $xFicha
                    $xPoli
                    A.PR_PROFEDIT = F.COD_RUTPRO AND 
                    A.COD_EMPRESA = $empresa AND
                    A.ad_procedencia = 58 AND
                    B.NUM_FICHAE = A.NUM_FICHAE AND
                    A.COD_EMPRESA = B.COD_EMPRESA AND
                    A.NUM_FICHAE = C.NUM_FICHAE and
                    a.ad_id_admision=d.ad_id_admision and
                    a.cod_empresa=d.cod_empresa and
                    d.num_citacion=g.num_citacion and
                    d.cod_empresa=g.cod_empresa and
                    g.cod_actividad=to_number(h.cod_poli)
                    ORDER BY HORA ASC";

        return $sQuery;
    }

    function citasSolNoProg($codSol)
    {

        $sQuery = "SELECT
                    D.NOM_NOMBRE ||' ' || D.NOM_APEPAT ||' ' ||  D.NOM_APEMAT NOMBRE_PROF,
                    (select F.NOM_SERVIC from ADMIN.GG_TSERVICIO F, ADMIN.GG_TSERVICIOXEMP G where B.COD_SERVIC = F.COD_SERVIC AND F.ID_SERDEP = G.ID_SERDEP AND G.COD_EMPRESA = B.COD_EMPRESA) NOM_ESPECI,
                    C.COD_RUTPAC,
                    C.COD_DIGVER,
                    H.NUM_NFICHA,
                    C.NOM_NOMBRE ||' ' || C.NOM_APEPAT ||' ' ||  C.NOM_APEMAT NOMBRE_PAC,
                    D.COD_RUTPRO RUTPRO,
                    D.COD_DIGVER DV,
                    ' ' AM_PM,
                    TO_CHAR(A.AR_FECHREG , 'hh24:mi') HORA,
                    (SELECT COD_FAMILIA FROM ADMIN.IN_TMIEMBROS C WHERE C.COD_RUTPAC = A.COD_RUTPAC AND C.COD_EMPRESA =  B.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA
                   FROM
                    $this->own.AR_TDETSOLICITUD A,
                    $this->own.AR_TSOLICITUD B,
                    $this->own.GG_TGPACTE C,
                    $this->own.GG_TPROFESIONAL D,
                    $this->own.SO_TCPACTE H
                   WHERE
                    H.NUM_FICHAE = C.NUM_FICHAE AND
                    H.COD_EMPRESA = B.COD_EMPRESA AND
                    A.AR_ID_SOLICITUD = B.AR_ID_SOLICITUD AND
                    A.NUM_FICHAE = C.NUM_FICHAE AND
                    B.COD_RUTPRO = D.COD_RUTPRO(+) AND
                    B.AR_TIPOSOLICITUD <> 2 AND
                    A.AR_ID_SOLICITUD = $codSol
                    ORDER BY HORA ASC";

        return $sQuery;
    }

    //sql impresion de tarjeton

    function citasSolHosp($fecha, $empresa, $rut, $codEsp)
    {

        if (!empty($rut)) {
            $SQLrut1 = ' and D.COD_RUTPRO = ' . $rut . '  ';
        } else {
            $SQLrut1 = '';
        }

        if (!empty($codEsp)) {
            $espec = " and h.COD_ESPECI = '$codEsp' ";
        } else {
            $espec = "";
        }
        
        $sQuery2 = "SELECT 
                        a.NUM_NFICHA,
                        c.COD_RUTPAC,
                        C.COD_DIGVER,
                        replace(to_char(c.COD_RUTPAC,'99,999,999'),',','.') || ' - ' || C.COD_DIGVER rut, 
                        C.NOM_NOMBRE || ' ' || C.NOM_APEPAT ||' '|| C.NOM_APEMAT nombre,
                        G.NOM_COMUNA,
                        nvl(c.num_telefo1,C.num_celular) fono,
                        (case when (trunc(months_between(a.fec_citaci,C.FEC_NACIMI)/12))<>0 then     
                        trunc(months_between(a.fec_citaci,C.FEC_NACIMI)/12) || ' A' else (case when (trunc(months_between(a.fec_citaci,C.FEC_NACIMI)- (trunc(months_between(a.fec_citaci,C.FEC_NACIMI)/12))*12))<>0 then            
                        trunc(months_between(a.fec_citaci,C.FEC_NACIMI)- (trunc(months_between(a.fec_citaci,C.FEC_NACIMI)/12))*12) || ' M'       Else            trunc(((months_between(a.fec_citaci,C.FEC_NACIMI)-           
                        (trunc(months_between(a.fec_citaci,C.FEC_NACIMI)/12))*12)-trunc(months_between(a.fec_citaci,C.FEC_NACIMI)-(trunc(months_between(a.fec_citaci,C.FEC_NACIMI)/12))*12))*30) || ' D' end ) end ) Edad,
                        a.ind_previs,
                        a.IND_CAUSAL CONSULTA, 
                        a.num_interc,
                        TO_CHAR(A.fec_citaci , 'hh24:mi') HORA,
                        nvl(E.am_pm,A.AM_PM) AM_PM, 
                        DECODE(XX.IND_AUGE,'1','SI','NO') AUGE, 
                        round(a.fec_citaci- xx.fec_recep,0) tiempo,
                        D.NOM_NOMBRE ||' ' || D.NOM_APEPAT ||' ' ||  D.NOM_APEMAT NOMBRE_PROF,
                        D.COD_RUTPRO,
                        H.NOM_ESPECI,
                        I.NOM_TPROFE,
                        J.NOM_GRUPO,
                        H.COD_ESPECI,
                        decode(NVL(E.IND_TIPOAGENDA,IND_TIPOCITA),0,'INSTITUCIONAL',1,'COMPRA DE SERVICIOS') TIPO_AGENDA
                        from 
                        (select c.*, a.num_fichae, a.num_nficha from  admin.so_tcpacte a, $this->own.so_tecitas c
                            where  
                            a.num_corpac=c.num_corpac and
                            a.cod_empresa=c.cod_empresa and a.ind_estado='V') a,
                        $this->own.GG_TGPACTE C,
                        $this->own.GG_TPROFESIONAL D, (SELECT F.*, E.NUM_CITA FROM  $this->own.gg_tbloque e, $this->own.gg_tagenda f WHERE E.NUM_CORAGE=F.NUM_CORAGE AND E.COD_EMPRESA=F.COD_EMPRESA) E,
                        $this->own.GG_TESPEC H,
                        $this->own.gg_tcomuna g,
                        admin.so_tinterconsulta xx,
                        $this->own.GG_TPROFESION I,       
                        $this->own.GG_TGRUESP J
                       where 
                        H.COD_GRUPO = J.COD_GRUPO AND
                        D.COD_TPROFE = I.COD_TPROFE AND
                        A.COD_ESPECI = H.COD_ESPECI AND
                        a.fec_citaci between to_date ('$fecha 00:00','dd/mm/yyyy hh24:mi') and to_date ('$fecha 23:59','dd/mm/yyyy hh24:mi')  AND                        
                        a.NUM_FICHAE = C.NUM_FICHAE AND
                        a.ind_estado='V' AND
                        a.COD_EMPRESA = $empresa AND
                        $SQLrut1
                        $espec
                        D.COD_PROMED = A.COD_PROMED and
                        a.num_correl=e.num_cita(+) and
                        a.cod_empresa=e.cod_empresa(+) and                       
                        g.cod_comuna=C.cod_comuna and
                        a.num_fichae=xx.num_fichae(+) and
                        a.num_interc=xx.num_interconsulta(+)
                        ORDER BY AM_PM,A.fec_citaci ASC";


$sQuery="SELECT a.NUM_NFICHA,

       c.COD_RUTPAC,

       C.COD_DIGVER,

          REPLACE (TO_CHAR (c.COD_RUTPAC, '99,999,999'), ',', '.')

       || ' - '

       || C.COD_DIGVER

          rut,

       C.NOM_NOMBRE || ' ' || C.NOM_APEPAT || ' ' || C.NOM_APEMAT nombre,

       G.NOM_COMUNA,

       NVL (c.num_telefo1, C.num_celular) fono,

       (CASE

           WHEN (TRUNC (MONTHS_BETWEEN (a.fec_citaci, C.FEC_NACIMI) / 12)) <>

                   0

           THEN

              TRUNC (MONTHS_BETWEEN (a.fec_citaci, C.FEC_NACIMI) / 12)

              || ' A'

           ELSE

              (CASE

                  WHEN (TRUNC (

                           MONTHS_BETWEEN (a.fec_citaci, C.FEC_NACIMI)

                           - (TRUNC (

                                 MONTHS_BETWEEN (a.fec_citaci, C.FEC_NACIMI)

                                 / 12))

                             * 12)) <> 0

                  THEN

                     TRUNC (

                        MONTHS_BETWEEN (a.fec_citaci, C.FEC_NACIMI)

                        - (TRUNC (

                              MONTHS_BETWEEN (a.fec_citaci, C.FEC_NACIMI)

                              / 12))

                          * 12)

                     || ' M'

                  ELSE

                     TRUNC (

                        ( (MONTHS_BETWEEN (a.fec_citaci, C.FEC_NACIMI)

                           - (TRUNC (

                                 MONTHS_BETWEEN (a.fec_citaci, C.FEC_NACIMI)

                                 / 12))

                             * 12)

                         - TRUNC (

                              MONTHS_BETWEEN (a.fec_citaci, C.FEC_NACIMI)

                              - (TRUNC (

                                    MONTHS_BETWEEN (a.fec_citaci,

                                                    C.FEC_NACIMI)

                                    / 12))

                                * 12))

                        * 30)

                     || ' D'

               END)

        END)

          Edad,

       a.ind_previs,

       a.IND_CAUSAL CONSULTA,

       a.num_interc,

       TO_CHAR (A.fec_citaci, 'hh24:mi') HORA,

       NVL (E.am_pm, A.AM_PM) AM_PM,

       DECODE (XX.IND_AUGE, '1', 'SI', 'NO') AUGE,

       ROUND (a.fec_citaci - xx.fec_recep, 0) tiempo,

       D.NOM_NOMBRE || ' ' || D.NOM_APEPAT || ' ' || D.NOM_APEMAT NOMBRE_PROF,

       D.COD_RUTPRO,

       H.NOM_ESPECI,

       I.NOM_TPROFE,

       J.NOM_GRUPO,

       H.COD_ESPECI,

       DECODE (NVL (E.IND_TIPOAGENDA, IND_TIPOCITA),

               0, 'INSTITUCIONAL',

               1, 'COMPRA DE SERVICIOS')

          TIPO_AGENDA, a.fec_citaci

  FROM (SELECT c.*, a.num_fichae, a.num_nficha

          FROM admin.so_tcpacte a, admin.so_tecitas c

                            WHERE

                            a.num_corpac=c.num_corpac AND

                            a.cod_empresa=c.cod_empresa AND a.ind_estado='V') a,

                        admin.GG_TGPACTE C,

                        admin.GG_TPROFESIONAL D, (SELECT F.*, E.NUM_CITA FROM  admin.gg_tbloque e, admin.gg_tagenda f WHERE E.NUM_CORAGE=F.NUM_CORAGE AND E.COD_EMPRESA=F.COD_EMPRESA) E,

                        admin.GG_TESPEC H,

                        admin.gg_tcomuna g,

                        admin.so_tinterconsulta xx,

                        admin.GG_TPROFESION I,

                        admin.GG_TGRUESP J

                       WHERE

                        H.COD_GRUPO = J.COD_GRUPO AND

                        D.COD_TPROFE = I.COD_TPROFE AND

                        A.COD_ESPECI = H.COD_ESPECI AND

                        a.fec_citaci BETWEEN TO_DATE ('$fecha 00:00','dd/mm/yyyy hh24:mi') AND TO_DATE ('$fecha 23:59','dd/mm/yyyy hh24:mi')  AND

                        a.NUM_FICHAE = C.NUM_FICHAE AND

                        a.ind_estado='V' AND

                        a.COD_EMPRESA = $empresa 

                        $SQLrut1

                        $espec
 
                      and 
                       

                        D.COD_PROMED = A.COD_PROMED AND

                        a.num_correl=e.num_cita(+) AND

                        a.cod_empresa=e.cod_empresa(+) AND

                        g.cod_comuna=C.cod_comuna AND

                        a.num_fichae=xx.num_fichae(+) AND

                        a.num_interc=xx.num_interconsulta(+)                       

                 union all

               /* Formatted on 29-10-2021 19:12:39 (QP5 v5.139.911.3011) */

SELECT    /* +RULE */ aa.NUM_NFICHA,

       pacte.COD_RUTPAC,

       pacte.COD_DIGVER,

          REPLACE (TO_CHAR (pacte.COD_RUTPAC, '99,999,999'), ',', '.')

       || ' - '

       || pacte.COD_DIGVER

          rut,

       pacte.NOM_NOMBRE || ' ' || pacte.NOM_APEPAT || ' ' || pacte.NOM_APEMAT nombre,

       G.NOM_COMUNA,

       NVL (pacte.num_telefo1, pacte.num_celular) fono,

       (CASE

           WHEN (TRUNC (MONTHS_BETWEEN (b.BL_FECBLOQUE, pacte.FEC_NACIMI) / 12)) <>

                   0

           THEN

              TRUNC (MONTHS_BETWEEN (b.BL_FECBLOQUE, pacte.FEC_NACIMI) / 12)

              || ' A'

           ELSE

              (CASE

                  WHEN (TRUNC (

                           MONTHS_BETWEEN (b.BL_FECBLOQUE, pacte.FEC_NACIMI)

                           - (TRUNC (

                                 MONTHS_BETWEEN (b.BL_FECBLOQUE, pacte.FEC_NACIMI)

                                 / 12))

                             * 12)) <> 0

                  THEN

                     TRUNC (

                        MONTHS_BETWEEN (b.BL_FECBLOQUE, pacte.FEC_NACIMI)

                        - (TRUNC (

                              MONTHS_BETWEEN (b.BL_FECBLOQUe, pacte.FEC_NACIMI)

                              / 12))

                          * 12)

                     || ' M'

                  ELSE

                     TRUNC (

                        ( (MONTHS_BETWEEN (b.BL_FECBLOQUE, pacte.FEC_NACIMI)

                           - (TRUNC (

                                 MONTHS_BETWEEN (b.BL_FECBLOQUE, pacte.FEC_NACIMI)

                                 / 12))

                             * 12)

                         - TRUNC (

                              MONTHS_BETWEEN (b.BL_FECBLOQUE,pacte.FEC_NACIMI)

                              - (TRUNC (

                                    MONTHS_BETWEEN (b.BL_FECBLOQUE,

                                                    pacte.FEC_NACIMI)

                                    / 12))

                                * 12))

                        * 30)

                     || ' D'

               END)

        END)

          Edad,

       a.ind_previs,

        (select DECODE(AC.GR_ID,1,'I',2,'C',3,'I',5,'EXAMENES',6, 'PROCEDIMIENTO CONTROL',7,'EXAMEN CONTROL') 

        from admin.GG_TACTIVIDADES_AE ac, admin.AE_TGRUPOACTV gra where AC.GR_ID=GRA.GR_ID and ac.cod_actividad = b.COD_ACTIVIDAD) CONSULTA,

       xx.num_interconsulta num_interc,

       TO_CHAR (b.BL_FECBLOQUE, 'hh24:mi') HORA,

        decode(c.ag_tipo_horario,'M','AM','T','PM')  AM_PM,

       DECODE (XX.IND_AUGE, '1', 'SI', 'NO') AUGE,

       ROUND (b.BL_FECBLOQUE - xx.fec_recep, 0) tiempo,

       D.NOM_NOMBRE || ' ' || D.NOM_APEPAT || ' ' || D.NOM_APEMAT NOMBRE_PROF,

       D.COD_RUTPRO,

       H.NOM_ESPECI,

       i.NOM_TPROFE,

       J.NOM_GRUPO,

       H.COD_ESPECI,

       decode(c.ag_tipo,1,'Institucional',2,'Compra de Servicio')          TIPO_AGENDA, b.BL_FECBLOQUE FEC_CITACI                                           

FROM ADMIN.ae_tcitacion a,

ADMIN.ae_tbloque b,

ADMIN.ae_tagenda c,

ADMIN.GG_TPROFESIONAL D,

admin.GG_TESPEC H,

admin.GG_TGPACTE pacte,

admin.gg_tcomuna g,

admin.so_tinterconsulta xx,

admin.GG_TGRUESP J,

admin.GG_TPROFESION I,

admin.so_tcpacte aa

WHERE     D.id_profesional = c.id_profesional

AND a.BL_ID_BLOQUE = b.BL_ID_BLOQUE

AND a.cod_empresa = b.cod_empresa

AND b.AG_ID_AGENDA = c.AG_ID_AGENDA

AND b.cod_empresa = C.cod_empresa

AND a.num_fichae = aa.num_fichae

AND a.cod_empresa = aa.cod_empresa

and a.num_fichae=pacte.num_fichae

and pacte.cod_comuna=g.cod_comuna(+)

and c.cod_especi=h.cod_especi

and h.cod_grupo=j.cod_grupo

and a.id_sic=xx.id_sic(+)

and a.CI_ID_CITACION=xx.num_cita(+)

and D.COD_TPROFE = I.COD_TPROFE

AND a.ind_estado = 1

AND a.cod_empresa = $empresa

AND b.BL_FECBLOQUE BETWEEN TO_DATE ('$fecha 00:00',

                                 'dd/mm/yyyy hh24:mi')

                    AND TO_DATE ('$fecha 23:59',

                                 'dd/mm/yyyy hh24:mi')                                
$SQLrut1
$espec                       

                        ORDER BY AM_PM,fec_citaci ASC";
        return $sQuery;
    }

    function citasHospIm($fecha, $empresa, $rut, $codEsp, $nFicha)
    {

        if (!empty($rut)) {
            $SQLrut = 'B.COD_RUTPRO = ' . $rut . ' AND';
            $SQLrut1 = 'D.COD_RUTPRO = ' . $rut . ' AND ';
        } else {
            $SQLrut = '';
            $SQLrut1 = '';
        }

        if (!empty($nFicha)) {
            $xFicha = 'B.NUM_NFICHA = ' . $nFicha . ' AND';
            $xFicha1 = 'H.NUM_NFICHA = ' . $nFicha . ' AND';
        } else {
            $xFicha = '';
            $xFicha1 = '';
        }

        if (!empty($codEsp)) {
            $SQLrut1 .= 'H.COD_ESPECI = \'' . $codEsp . '\' AND';
        } else {
            $SQLrut1 = '';
        }

        
        $sQuery="SELECT D.NOM_NOMBRE || ' ' || D.NOM_APEPAT || ' ' || D.NOM_APEMAT NOMBRE_PROF,

        H.NOM_ESPECI,
 
        B.COD_RUTPAC,
 
        C.COD_DIGVER,
 
        B.NUM_NFICHA,
 
        C.NOM_NOMBRE || ' ' || C.NOM_APEPAT || ' ' || C.NOM_APEMAT NOMBRE_PAC,
 
        NVL (f.am_pm, A.AM_PM) AM_PM,
 
        TO_CHAR (A.fec_citaci, 'hh24:mi') HORA
 
   FROM admin.so_tecitas a,
 
        admin.SO_TCPACTE B,
 
        admin.GG_TGPACTE C,
 
        admin.GG_TPROFESIONAL D,
 
        admin.gg_tbloque e,
 
        admin.gg_tagenda f,
 
        admin.GG_TESPEC H
 
 WHERE A.COD_ESPECI = H.COD_ESPECI
 
        AND a.fec_citaci BETWEEN TO_DATE ('$fecha 00:00',
 
                                          'dd/mm/yyyy hh24:mi')
 
                             AND TO_DATE ('$fecha 23:59',
 
                                          'dd/mm/yyyy hh24:mi')
 
        AND A.NUM_CORPAC = B.NUM_CORPAC
 
        AND a.cod_empresa = b.cod_empresa
 
        AND B.NUM_FICHAE = C.NUM_FICHAE
 
        AND B.COD_EMPRESA = $empresa
 
        AND 
         $SQLrut1
 
         $xFicha
 
            D.COD_PROMED = A.COD_PROMED
 
        AND a.num_correl = e.num_cita(+)
 
        AND a.cod_empresa = e.cod_empresa(+)
 
        AND e.num_corage = f.num_corage(+)
 
        AND e.cod_empresa = f.cod_empresa(+)
 
 UNION ALL
 
 SELECT D.NOM_NOMBRE || ' ' || D.NOM_APEPAT || ' ' || D.NOM_APEMAT NOMBRE_PROF,
 
        F.NOM_SERVIC NOM_ESPECI,
 
        A.COD_RUTPAC,
 
        C.COD_DIGVER,
 
        H.NUM_NFICHA,
 
        C.NOM_NOMBRE || ' ' || C.NOM_APEPAT || ' ' || C.NOM_APEMAT NOMBRE_PAC,
 
        ' ' AM_PM,
 
        TO_CHAR (A.AR_FECHREG, 'hh24:mi') HORA
 
   FROM admin.AR_TDETSOLICITUD A,
 
        admin.AR_TSOLICITUD B,
 
        admin.GG_TGPACTE C,
 
        admin.SO_TCPACTE H,
 
        admin.GG_TPROFESIONAL D,
 
        admin.GG_TSERVICIO F
 
 WHERE B.AR_FECHSOLICITUD BETWEEN TO_DATE ('$fecha 00:00',
 
                                            'dd/mm/yyyy hh24:mi')
 
                               AND TO_DATE ('$fecha 23:59',
 
                                            'dd/mm/yyyy hh24:mi')
 
        AND A.AR_ID_SOLICITUD = B.AR_ID_SOLICITUD
 
        AND A.NUM_FICHAE = C.NUM_FICHAE
 
        AND B.COD_EMPRESA = $empresa
 
        AND 
        $SQLrut
 
        $xFicha1
 
            C.NUM_FICHAE = H.NUM_FICHAE
 
        AND H.COD_EMPRESA = B.COD_EMPRESA
 
        AND B.COD_RUTPRO = D.COD_RUTPRO(+)
 
        AND B.AR_TIPOSOLICITUD <> 2
 
        AND B.COD_SERVIC = F.COD_SERVIC(+)
 
 UNION ALL
 
 SELECT d.NOM_NOMBRE || ' ' || d.NOM_APEPAT || ' ' || d.NOM_APEMAT NOMBRE_PROF,
 
        h.NOM_ESPECI,
 
        g.COD_RUTPAC,
 
        d.COD_DIGVER,
 
        b.NUM_NFICHA,
 
        g.NOM_NOMBRE || ' ' || g.NOM_APEPAT || ' ' || g.NOM_APEMAT NOMBRE_PAC,
 
        DECODE (e.AG_TIPO_HORARIO,  'M', 'AM',  'T', 'PM') AM_PM,
 
        TO_CHAR (A.BL_FECBLOQUE, 'hh24:mi') HORA
 
   FROM admin.ae_tbloque a,
 
        admin.ae_tcitacion f,
 
        admin.ae_tagenda e,
 
        admin.GG_TACTIVIDADES_AE ACT,
 
        ADMIN.AE_TGRUPOACTV GRUACT,
 
        admin.gg_tprofesional d,
 
        admin.so_tcpacte b,
 
        admin.gg_tespec h,
 
        admin.gg_tgpacte g
 
 WHERE     a.bl_id_bloque = f.bl_id_bloque
 
        AND a.cod_empresa = f.cod_empresa
 
        AND a.ag_id_agenda = e.ag_id_agenda
 
        AND a.cod_empresa = e.cod_empresa
 
        AND a.cod_actividad = act.cod_actividad
 
        AND a.COD_actividad = ACT.COD_ACTIVIDAD
 
        AND GRUACT.GR_ID = ACT.GR_ID
 
        AND e.id_profesional = d.id_profesional
 
        AND b.num_fichae = f.num_fichae
 
        AND b.cod_empresa = f.cod_empresa
 
        AND e.cod_especi = h.cod_especi
 
        AND f.num_fichae = g.num_fichae
 
        AND a.cod_empresa = $empresa
 
        and 
        $SQLrut1
 
        $xFicha
 
        a.BL_FECBLOQUE BETWEEN TO_DATE ('$fecha 00:00',
 
                                            'dd/mm/yyyy hh24:mi')
 
                               AND TO_DATE ('$fecha 23:59',
 
                                            'dd/mm/yyyy hh24:mi')
 
        AND a.ind_estado = 1
 
        AND f.ind_estado = 1
 
        AND e.ind_estado = 1      
 
 ORDER BY HORA ASC";
  


        return $sQuery;
    }

    function buscaEspecialidad($codEspe)
    {

        $sQuery = "SELECT
                    NOM_ESPECI
                   FROM
                    $this->own.GG_TESPEC
                   WHERE
                    COD_ESPECI = '$codEspe'";

        return $sQuery;
    }

    function UsuariosFeUser($rut)
    {

        $rut = strtoupper($rut);

        $sQuery = "SELECT 
                    FIRST_NAME ||' ' || MIDDLE_NAME ||' ' || LAST_NAME NOMBRE_USER
                   FROM 
                    $this->ownGu.FE_USERS 
                   WHERE 
                    USERNAME = '$rut'
                UNION ALL
                  SELECT 
                    AR_NOMUSU NOMBRE_USER
                   FROM 
                    $this->own.AR_USURETIRA
                   WHERE 
                    UPPER(AR_RUTUSU) = '$rut' AND
                    AR_ESTADO = 1";

        return $sQuery;
    }

    function UsuariosFeUser2($rut)
    {

        $sQuery = "SELECT 
                    NAME , MIDDLE_NAME, LAST_NAME ,
                     TX_INTRANETSSAN_DV
                   FROM 
                      fe_users  
                   WHERE 
                    TX_INTRANETSSAN_RUN = '$rut'";
        

        return $sQuery;
    }
    function UsuariosUsuRetira($rut)
    {

        $rut = strtoupper($rut);

        $sQuery = "SELECT
                    AR_NOMUSU NOMBRE_USER
                  FROM
                    $this->own.AR_USURETIRA 
                  WHERE
                    AR_ESTADO = 1 AND
                    UPPER(AR_RUTUSU) = '$rut'";

        return $sQuery;
    }

    function funcionariosFichero($empresa, $ind = '')
    {

        $indEstado = "";
        if ($ind != 1) {
            $indEstado = " AND IND_ESTADO = 1";
        }

        $sQuery = "SELECT DISTINCT
                    B.USERNAME,
                    A.FU_CODFUNC,
                    B.FIRST_NAME || ' ' || B.MIDDLE_NAME || ' ' || B.LAST_NAME NOMBRE,
                    A.IND_ESTADO,                    
                    TO_CHAR(A.FECH_CREA,'dd-mm-YYYY / hh24:mi') FECH_CREA
                   FROM
                     $this->own.AR_TFUNCIONARIOXFICHAS A,
                     $this->ownGu.FE_USERS B
                   WHERE
                    UPPER(TO_CHAR(A.FU_CODFUNC)) = UPPER(TO_CHAR(B.TX_INTRANETSSAN_RUN)) AND
                    B.DISABLE = 0 AND
                    COD_EMPRESA = $empresa 
                    $indEstado
                    ORDER BY NOMBRE ASC";

        return $sQuery;
    }

    function funcXFichero($rut, $empresa)
    {
        $sQuery = "SELECT
                    A.FU_CODFUNC
                   FROM
                    ADMIN.AR_TFUNCIONARIOXFICHAS A
                   WHERE
                    A.FU_CODFUNC = $rut AND 
                    A.COD_EMPRESA = $empresa";

        return $sQuery;
    }

    function buscaFichasSolicitud($idSolicitud, $numFichaE)
    {

        $sQuery = "SELECT 
                    AR_ID_DETSOL 
                   FROM 
                    $this->own.AR_TDETSOLICITUD 
                   WHERE AR_ID_SOLICITUD = $idSolicitud AND 
                    NUM_FICHAE = $numFichaE";

        return $sQuery;
    }

    function traeMonit($empresa, $estado, $fecha1, $fecha2, $profesional = '', $servic = '')
    {

        if (!empty($estado)) {
            $xFiltr = " AND AR.AR_ID_ESTADO = $estado ";
        } else {
            $xFiltr = " AND AR.AR_ID_ESTADO IN (9,2,3,6) ";
        }

        $sQuery = "SELECT       
                    CC.NUM_NFICHA,        
                    GG.COD_RUTPAC || '-' || GG.COD_DIGVER RUT_PAC,
                    GG.NOM_APEPAT ||' ' || GG.NOM_APEMAT ||' ' ||  GG.NOM_NOMBRE NOM_NOMBRES,
                    AR.AR_ID_ESTADO,
                    (SELECT COD_FAMILIA FROM $this->own.IN_TMIEMBROS C WHERE C.COD_RUTPAC = GG.COD_RUTPAC AND C.COD_EMPRESA =  CC.COD_EMPRESA AND C.IND_ESTADO='V' AND rownum = 1) COD_FAMILIA,
                    AR.COD_RUTPRO,
                    PR.NOM_NOMBRE || ' ' || PR.NOM_APEPAT || ' ' || PR.NOM_APEMAT NOMBRE_PROF,
                    AR.COD_SERVIC,
                    (SELECT NOM_SERVIC FROM ADMIN.GG_TSERVICIO F, ADMIN.GG_TSERVICIOXEMP G WHERE  AR.COD_SERVIC = F.COD_SERVIC AND F.ID_SERDEP = G.ID_SERDEP  AND G.COD_EMPRESA = CC.COD_EMPRESA) NOM_SERVIC,
                    AR.ID_SOLICITUD,
                    TO_CHAR(S.AR_FECHSOLICITUD,'dd-mm-YYYY') AR_FECHSOLICITUD,
                    DECODE(AR.AR_FECHEDIT,NULL,TO_CHAR(AR.AR_FECHREG,'dd-mm-YYYY / hh24:mi'),TO_CHAR(AR.AR_FECHEDIT,'dd-mm-YYYY / hh24:mi')) AR_FECHREG,
                    DECODE(AR.AR_USUEDIT,NULL,AR.AR_USUREG,AR.AR_USUEDIT) AR_USUREG,
                    FU.NAME,
                    FU2.NAME NAME_EDIT
                    FROM
                    $this->own.AR_TESTADOFICHA_AR AR,
                    $this->own.GG_TPROFESIONAL PR,
                    $this->own.GG_TGPACTE GG,
                    $this->own.SO_TCPACTE CC,
                    $this->own.AR_TSOLICITUD S,
                    $this->ownGu.FE_USERS FU,
                    $this->ownGu.FE_USERS FU2   
                    WHERE        
                    AR_USUREG = FU.TX_INTRANETSSAN_RUN(+) AND
                    AR_USUEDIT = FU2.TX_INTRANETSSAN_RUN(+) AND
                    FU.DISABLE(+) = 0 AND
                    FU2.DISABLE(+) = 0 AND
                    S.AR_ID_SOLICITUD = AR.ID_SOLICITUD AND                    
                    CC.NUM_FICHAE= GG.NUM_FICHAE AND
                    CC.COD_EMPRESA = $empresa AND
                    AR.AR_FECHEDIT between to_date ('$fecha1 00:00','dd/mm/yyyy hh24:mi') and to_date ('$fecha2 23:59','dd/mm/yyyy hh24:mi') AND
                    AR.COD_RUTPRO = PR.COD_RUTPRO(+) AND
                    AR.NUM_FICHAE= GG.NUM_FICHAE AND 
                    AR.COD_EMPRESA = CC.COD_EMPRESA 
                    $xFiltr
                    ORDER BY GG.NOM_NOMBRE";

        return $sQuery;
    }

    function traeMonitHistorial($empresa, $estado, $fecha1, $fecha2, $profesional = '', $servic = '')
    {

        if (!empty($estado)) {
            $xFiltr = " AND AR.AR_ID_ESTADO = $estado ";
        } else {
            $xFiltr = " AND AR.AR_ID_ESTADO IN (9,2,3,6) ";
        }

        if (!empty($profesional)) {
            $xFiltr .= " AND AR.COD_RUTPRO = $profesional ";
        }
        if (!empty($servic)) {
            $xFiltr .= " AND AR.COD_SERVIC = '$servic' ";
        }


        $sQuery = "SELECT CC.NUM_NFICHA,
                        GG.COD_RUTPAC || '-' || GG.COD_DIGVER RUT_PAC,
                        GG.NOM_APEPAT || ' ' || GG.NOM_APEMAT || ' ' || GG.NOM_NOMBRE NOM_NOMBRES,
                        AR.AR_ID_ESTADO,
                        (SELECT COD_FAMILIA FROM ADMIN.IN_TMIEMBROS C WHERE     C.COD_RUTPAC = GG.COD_RUTPAC AND C.COD_EMPRESA = CC.COD_EMPRESA AND C.IND_ESTADO='V' AND ROWNUM = 1) COD_FAMILIA,
                        AR.COD_RUTPRO,
                        PR.NOM_NOMBRE || ' ' || PR.NOM_APEPAT || ' ' || PR.NOM_APEMAT NOMBRE_PROF,
                        AR.COD_SERVIC,
                        F.NOM_SERVIC,
                        AR.AR_IDSOL,
                        TO_CHAR (S.AR_FECHSOLICITUD, 'dd-mm-YYYY') AR_FECHSOLICITUD,
                        TO_CHAR (AR.FECH_REG, 'dd-mm-YYYY / hh24:mi') AR_FECHREG,
                        AR.COD_USUREG AR_USUREG,
                        FU.NAME,
                        E.AR_DESCRIPCIONEST
                   FROM $this->own.AR_HISTMOVFICHAS AR,
                        $this->own.GG_TPROFESIONAL PR,
                        $this->own.GG_TGPACTE GG,
                        $this->own.SO_TCPACTE CC,
                        $this->own.GG_TSERVICIO F,
                        $this->own.GG_TSERVICIOXEMP G,
                        $this->own.AR_TSOLICITUD S,                            
                        $this->own.AR_ESTADOS E,                            
                        $this->ownGu.FE_USERS FU
                   WHERE     
                        COD_USUREG = FU.TX_INTRANETSSAN_RUN(+)
                        AND FU.DISABLE(+) = 0
                        AND S.AR_ID_SOLICITUD = AR.AR_IDSOL
                        AND AR.FECH_REG BETWEEN TO_DATE ('$fecha1 00:00','dd/mm/yyyy hh24:mi') AND TO_DATE ('$fecha2 23:59', 'dd/mm/yyyy hh24:mi')
                        AND CC.NUM_FICHAE = GG.NUM_FICHAE
                        AND AR.COD_SERVIC = F.COD_SERVIC
                        AND F.ID_SERDEP = G.ID_SERDEP
                        AND G.COD_EMPRESA = CC.COD_EMPRESA
                        AND CC.COD_EMPRESA = $empresa
                        AND AR.COD_RUTPRO = PR.COD_RUTPRO
                        AND AR.NUM_FICHAE = GG.NUM_FICHAE
                        AND AR.AR_ID_ESTADO = E.AR_ID_ESTADO                        
                        AND AR.COD_EMPRESA = CC.COD_EMPRESA
                        $xFiltr
                        ORDER BY GG.NOM_NOMBRE";

        return $sQuery;
    }

    public function traeConfig($empresa)
    {
        $sQuery = "SELECT 
                    AR_TIPETIQUET,
                    COD_EMPRESA
                    FROM 
                    ADMIN.AR_CONFIG A 
                    WHERE COD_EMPRESA  = '$empresa'";

        return $sQuery;
    }

    //Informe estadistico

    function traeEstadosFich()
    {

        $sQuery = "SELECT 
                AR_ID_ESTADO,
                AR_DESCRIPCIONEST
                FROM
                $this->own.AR_ESTADOS 
                WHERE
                AR_TIPO_ESTADO IN ('1,2','2')";

        return $sQuery;
    }

    function serviciosHist()
    {
        $sQuery = "SELECT UNIQUE
                COD_SERVIC
                FROM
                $this->own.AR_HISTMOVFICHAS 
                WHERE 
                COD_SERVIC IS NOT NULL";

        return $sQuery;
    }
}
