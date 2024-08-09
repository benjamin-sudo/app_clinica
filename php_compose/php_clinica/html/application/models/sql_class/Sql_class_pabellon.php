<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class sql_class_pabellon extends CI_Model {

    var $own         =	'ADMIN';
    var $pabellon    =	'PABELLON';
    var $ownGu       =	'GUADMIN';
    
    //*********************** NUEVO 03-07-2019 *********************************
    public function sqlbusquedaPabellonescxmenor($empresa){
            $SQL = "
                    SELECT 
                        P.COD_PABELLON,  
                        P.SALA_DESCRIPCION
                    FROM 
                        $this->pabellon.PB_SALA_PABELLON P
                    WHERE 
                            P.COD_EMPRESA	    =   '$empresa' 
                        AND 
                            P.IND_ESTADO	    =   'V'   
                        AND 
                            P.IND_TIPOPABELLON IN ('2') ";
            return   $SQL;
            //ORDER BY IND_ORDER
    }
    
    public function busquedaPabellones_maternidad($empresa){
            $SQL = "
                    SELECT 
                        P.COD_PABELLON,  
                        P.SALA_DESCRIPCION
                    FROM 
                        $this->pabellon.PB_SALA_PABELLON P
                    WHERE 
                            P.COD_EMPRESA	    =   '$empresa' 
                        AND 
                            P.IND_ESTADO	    =   'V' 
                        AND 
                            P.IND_TIPOPABELLON  IN ('3')    
                    ORDER 
                        BY IND_ORDER
		";
	return $SQL;
    }
    //*********************** NUEVO 03-07-2019 *********************************
    
    
    public function sql_existeTipoAnestesia($num_anestesia,$id,$vigente,$empresa){
        $where                          = '';
        if (!$num_anestesia == '')      {   $where.= ' AND P.ID_ANESTESIA     = '.$num_anestesia.' ';     }
        if (!$id            == '')      {   $where.= ' AND P.ID_TABLA         = '.$id.' ';                }
        if ($vigente        == '1')     {   $where.= ' AND P.IND_ESTADO       = 1 ';                      }
        $sQuery =" 
                SELECT 
                    P.ID_TANESTESIAXIC                  AS ID_ANSTXIC, 
                    A.TXT_NOMBREANESTESIA               AS NOM,
                    P.ID_ANESTESIA                      AS ID_ANST, 
                    P.NUM_ORDEN                         AS NUM_ORDEN, 
                    P.ID_TABLA                          AS ID,
                    P.COD_USRCREA, 
                    P.FEC_CREA, 
                    P.COD_AUDITA, 
                    P.FEC_AUDITA, 
                    P.IND_ESTADO
                FROM 
                    $this->pabellon.PB_TANESTESIAXIC    P,
                    $this->pabellon.PB_CODANESTESIA     A
                WHERE 
                    P.ID_ANESTESIA = A.ID_ANESTESIA ".$where ;
        return $sQuery; 
    }
      
    public function sqlbusquedaTipoDeanestesiaPorZona($empresa){
        $sQuery ="  
                SELECT 
                    P.ID_ANESTESIA              AS COD, 
                    P.TXT_NOMBREANESTESIA       AS NOM 
                FROM 
                    PABELLON.PB_CODANESTESIA    P 
                WHERE 
                    P.IND_ESTADO                = 1 
                ";
        return $sQuery;  
    }
       
    /*
     public function sql_existeTipoAnestesia($num_anestesia,$id,$vigente,$empresa){
        $where                      = '';
        if (!$num_anestesia == '')  { $where.= ' AND P.ID_ANESTESIA = '.$num_anestesia.' ';     }
        if (!$id            == '')  { $where.= ' AND P.ID_TABLA       = '.$id.' ';                }
        if ($vigente        == '1') { $where.= ' AND P.IND_ESTADO     = 1 ';                      }
        $sQuery =" 
                SELECT 
                    P.ID_TANESTESIAXIC      AS ID_ANSTXIC, 
                    A.NOM_ANESTESIA         AS NOM,
                    P.ID_ANESTESIA          AS ID_ANST, 
                    P.NUM_ORDEN             AS NUM_ORDEN, 
                    P.ID_TABLA              AS ID,
                    P.COD_USRCREA, 
                    P.FEC_CREA, 
                    P.COD_AUDITA, 
                    P.FEC_AUDITA, 
                    P.IND_ESTADO
                FROM 
                    $this->pabellon.PB_TANESTESIAXIC P,
                    $this->pabellon.PB_TIPOANESTESIA A
                WHERE 
                    P.ID_ANESTESIA = A.ID_ANESTESIA AND A.COD_ESTABL = '$empresa' ".$where ;
        return $sQuery; 
    }
      
    public function sqlbusquedaTipoDeanestesiaPorZona($empresa){
        $sQuery ="  
                    SELECT 
                        P.ID_ANESTESIA AS COD, 
                        P.NOM_ANESTESIA AS NOM 
                    FROM 
                        PABELLON.PB_TIPOANESTESIA P 
                    WHERE 
                        P.COD_ESTABL    ='$empresa' AND 
                        P.IND_ESTADO    =1 
                    ";
        return $sQuery;  
    }
    */
    
    public function sql_busquedaHoraDenevio($empresa){
        $sql ="
                SELECT
                    TO_CHAR(P.DATE_ENVIO    ,'DD-MM-YYYY')                      AS SOLOFECHA,
                    TO_CHAR(SYSDATE         ,'DD-MM-YYYY')                      AS SOLOFECHACTUAL,
                    TO_CHAR(P.DATE_ENVIO    ,'hh24:mi')                         AS HORA,
                    TO_CHAR(SYSDATE         ,'hh24:mi')                         AS HORAACTUAL,
                    TO_CHAR(SYSDATE         ,'DD-MM-YYYY hh24:mi:ss')           AS FECHA_HORAACTUAL,
                    TO_CHAR(P.DATE_ENVIO    ,'hh24mi')                          AS HORA_HM,
                    TO_CHAR(SYSDATE         ,'hh24mi')                          AS HORAACTUAL_HM,
                    P.IND_SOLDIA                                                AS IND_SOLDIA
                FROM 
                    PABELLON.PB_TENVIOSOL  P
                WHERE 
                    P.COD_EMPRESA = '$empresa' 
            ";
        return $sql;   
    }
    
    public function sqlNumeroSuspensionesTabla($ID){
            $sql ="
                    SELECT 
                        P.ID_SUSPENSION,
                        P.TXT_SUSPENSION AS  TXTXSUSPENSION,
                        P.IND_ESTADO,
                        P.COD_EMPRESA,
                        P.COD_USRCREA,
                        P.FEC_USRCREA,
                        P.COD_TESTABL
                    FROM 
                        $this->pabellon.PB_SUSPENCIONES        P, 
                        $this->pabellon.PB_SUSPENSIONXIQ       S
                    WHERE 
                            S.ID_TABLA          = '$ID'              
                        AND S.ID_SUSPENSION     = P.ID_SUSPENSION
                    ORDER 
                        BY P.ID_SUSPENSION
                ";
        return $sql;   
    }
    
    public function sqlbusquedageneraldesuspensiones(){
            $sql ="
                    SELECT 
                        P.ID_SUSPENSION         AS ID,
                        P.TXT_SUSPENSION        AS TXTXSUSPENSION,
                        P.IND_ESTADO,
                        P.COD_EMPRESA,
                        P.COD_USRCREA,
                        P.FEC_USRCREA,
                        P.COD_TESTABL,
                        P.ID_SUBMENU,
                        DECODE(P.ID_SUBMENU,
                                            '1','PACIENTE',
                                            '2','UNIDADES DE APOYO',
                                            '3','ADMINISTRATIVOS',
                                            '4','PREPARACIÓN PREVIA DEL PACIENTE',
                                            '5','EQUIPO QUIRÚRGICO',
                                            '6','INFRAESTRUCTURA',
                                            '7','GREMIALES',
                                            '8','EMERGENCIAS',
                                            '9','ATAQUES DE TERCEROS',
                                            '10','OTROS'
                                            ) AS TXT_SUBMENU
                    FROM 
                        $this->pabellon.PB_SUSPENCIONES        P
                    WHERE 
                        P.IND_ESTADO = 1
                    ORDER 
                        BY P.ID_SUBMENU,P.ID_SUSPENSION 
                ";
        return $sql;   
    }
    
    public function sqlCargafuncionariosSistemaPabellon($empresa){
        
         $sQuery = " SELECT 

                        P.COD_RUTPRO, 
                        P.COD_DIGVER, 
                        P.IND_ESTADO, 
                        P.COD_ESTABL, 
                        P.CONTRASENA, 
                        P.PROFESION, 
                        P.TIPO_PROFESIONAL,
                        P.PERMISOS, 
                        P.EXTERNO,
                        G.NOM_APEPAT ||' '|| G.NOM_APEMAT||' '|| G.NOM_NOMBRE  AS NOMBRE
                    FROM 
                            $this->pabellon.PB_USUARIOS_V  P,
                            $this->own.GG_TGPACTE          G
                    WHERE 
                                P.COD_ESTABL  = '$empresa'
                            AND P.COD_RUTPRO  = G.COD_RUTPAC
                            AND P.IND_ESTADO  = 'V'  ORDER BY   G.NOM_APEPAT ";
         return $sQuery;
    }
    
    public function sqlTraePrevisionPacienteNfichaE($numFichaE) {
        $sQuery = "
                    SELECT
                            A.IND_PREVIS,
                            A.NOM_PREVIS,
                            B.NUM_RUTINS,
                            B.NOM_NOMBRE,
                            B.NOM_APEPAT,
                            B.NOM_APEMAT,
                            D.NOM_INSEMP,
                            B.COD_RUTTIT,
                            B.COD_DIGVER
                    FROM
                            $this->own.GG_TDATPREV     A,
                            $this->own.SO_TTITUL       B,
                            $this->own.GG_TGPACTE      C,
                            $this->own.GG_TINSEMP      D
                    WHERE
                            A.IND_PREVIS    = B.IND_PREVIS
                    AND
                            B.COD_RUTTIT    = C.COD_RUTTIT
                    AND  
                            B.NUM_RUTINS    = D.COD_RUTINS
                    AND
                            C.NUM_FICHAE    = '".$numFichaE."'
                    AND
                            A.IND_ESTADO    = 'V' 
            ";
        return $sQuery;
    }
    
    public static function sqlTraeDatosTitularxRut($oracle_own, $rut) {
        $sql="select distinct 
				A.COD_RUTTIT, 
				A.Cod_Digver, 
				A.Nom_Nombre,
				A.Nom_Apepat,
				A.Nom_Apemat,
				A.IND_PREVIS,
				A.NUM_RUTINS,
		   		A.IND_ESTADO,
                                B.NOM_INSEMP,
                                C.NOM_PREVIS
		   		FROM 
					$oracle_own.SO_TTITUL a,
                                        $oracle_own.GG_TINSEMP b,
                                        $oracle_own.GG_TDATPREV c
				WHERE
					A.COD_RUTTIT = $rut  and
                                        A.NUM_RUTINS = B.COD_RUTINS(+) and
                                        A.IND_PREVIS = C.IND_PREVIS(+)  ";
        return $sql;
    }
    
    /*
    public function sql_CountExisteRRHHaQX($rutPro,$idRRHH,$idQX){
        $sQuery =" SELECT COUNT(*) AS EXISTE WHERE  this->own.GG_TGPACTE   "; 
        return $sQuery;
    }
    */
    
    //hito
    function sqlFechaservidor($val){
	$sQl="SELECT TO_CHAR(SYSDATE,'DD-MM-YYYY hh24:mi') AS FECHA FROM DUAL";
	return $sQl;
    }
   
    function sqlbusquedaallCirugiasXzona(){
       $sQl="
            SELECT 
                P.ID_ORIGEN                         AS COD_PABELLON, 
                P.TXT_ATIPOSOLICITUD                AS SALA_DESCRIPCION
            FROM 
                $this->pabellon.PB_TSOLICITUDPAB    P
            ORDER 
                BY P.ID_ORIGEN
            ";
       return $sQl;
   }
   
   
    
    public function sqlhoraactual(){
        $sQl="SELECT TO_CHAR(SYSDATE, 'hh24:mi') AS HORA FROM DUAL";
        return $sQl;
    }

   public function sql_busquedaplantillasQx($session){
               
            $sm_sql = "
                    SELECT 
                       P.ID_PLANTILLAS_QX           AS ID, 
                       P.PLANTILLA_TITULO           AS TITULO, 
                       P.PLANTILLA_CONTENIDO        AS CONTENIDO, 
                       P.COD_USRCREA, 
                       P.FEC_USRCREA, 
                       P.COD_TESTABL
                    FROM 
                        PABELLON.PB_PLANTILLAS_QX P
                    WHERE
                    
                        P.COD_USRCREA       ='$session'
                    AND P.IND_ESTADO        ='V'";
            return $sm_sql ;
    }
    
    //NUEVO 11.06.2018
    public function sql_descripcionAyudate($id_tabla){
        $sm_sql = " 
        SELECT 
            SUBSTR(A.NOM_NOMBRE, 1, 1)||'.'||A.NOM_APEPAT||' '||A.NOM_APEMAT    AS TXTNOMBRETB,
            A.NOM_NOMBRE||' '||A.NOM_APEPAT||' '||A.NOM_APEMAT                  AS TXTNOMBRE,
            A.COD_RUTPRO||'-'||A.COD_DIGVER                                     AS RUT_COMPLETO,
            P.ID_MDESCRIPCION, 
            P.COD_RUTPRO, 
            P.TXT_DESCRIPCION_QX                                                AS TXT_DES, 
            P.IND_ESTADO, 
            P.COD_RUTCREA, 
            P.DATE_CREA, 
            P.COD_RUTAUDITA, 
            P.DATE_AUDITA, 
            P.ID_TABLA
        FROM 
            ADMIN.GG_TPROFESIONAL                                               A, 
            PABELLON.PB_DESCRIPCION_AYUDANTE                                    P
        WHERE
            P.COD_RUTPRO            = A.COD_RUTPRO  AND 
            P.ID_TABLA              = $id_tabla     AND 
            P.IND_ESTADO            = 1
            ";
        return $sm_sql ;
    }
    //FIN NUEVO 11.06.2018
    
    
    
    public function sql_BusquedaRRHHxTabla($id_tabla){
                $sm_sql = " 
                        SELECT 
                            B.ID_RRHHQX                                                                                                 AS ID,
                            B.ID_INDPAD                                                                                                 AS ID_INDPAD,
                            A.COD_RUTPRO,
                            A.NOM_NOMBRE,
                            A.NOM_APEPAT,
                            A.NOM_APEMAT, 
                            A.COD_TPROFE,
                            A.COD_RUTPRO||'-'||A.COD_DIGVER                                                                             AS RUT_COMPLETO,
                            SUBSTR(A.NOM_NOMBRE,1,1)||'.'||A.NOM_APEPAT||' '||A.NOM_APEMAT						AS TXTNOMBRETB,
                            A.NOM_NOMBRE||' '||A.NOM_APEPAT||' '||A.NOM_APEMAT                                                          AS TXTNOMBRE,
			    
                            DECODE(B.ID_INDPAD,
                                                '1','SI',
                                                '2','DEVOLUCION DE TIEMPO',
                                                '3','NO',
                                                'NO INFORMADO')                                                                         AS TXT_FUNCION,
                                                
                            DECODE(B.ID_INDPAD,
                                                '1','SI',
                                                '2','DEVOLUCION DE TIEMPO',
                                                '3','NO',
                                                'NO INFORMADO')                                                                         AS TXTINDPAD,
                                                
                            C.NOM_TIPORRHH,
                            B.ID_FUNCION_PB,
                            B.ID_TIPO_RRHH,
			    
			    (SELECT G.NOM_TPROFE FROM ADMIN.GG_TPROFESION G WHERE  G.COD_TPROFE =  a.COD_TPROFE)			AS PROFESION,
 
			    (SELECT G.NOM_GRUPO FROM ADMIN.GG_TGRUESP G WHERE G.COD_GRUPO = A.COD_TPROFENEW )				AS ESPECIALIDAD,
			      
                            (SELECT M.NOM_FUNCION FROM PABELLON.PB_FUNCION_AUX  M  WHERE  B.ID_FUNCION_PB = M.ID_TIPO_FUNCION)          AS FUNCION_PABELLON
			    
                        FROM
			
                            ADMIN.GG_TPROFESIONAL   A, 
                            PABELLON.PB_RRHH_QX     B, 
                            PABELLON.PB_TIPORRHH    C 
			    
                        WHERE
			
                                A.COD_RUTPRO        =	B.RUT_PROFESIONAL   
                            AND B.ID_TABLA          =	'$id_tabla'   
                            AND B.IND_ESTADO        =	'1' 
                            AND B.ID_TIPO_RRHH      =	C.ID_TIPO_RRHH 
                        ORDER BY B.ID_TIPO_RRHH
                        ";
            return $sm_sql;
    }
    
    function sqlRegistraConsultaHistorialClinico($cod_empresa,$rut_prestador,$rut_paciente,$hora,$fecha,$ind_rev_regcli,$rut_firma,$firmado_por="",$nunFichae,$sistema,$folio,$token,$tipoacceso){
        $sQuery = "insert into $this->own.AP_TREV_REGCLI ". 
        "(COD_RUT_PRES_CON, COD_RUT_PAC, FECHA, HORA, COD_EMPRESA,IND_REV_REGCLI,FIRMADO_POR,IP_CONSULTA,FEC_CONSULTA,NUM_FICHAE,OA_ID_ORIGENATE,FIRMADO_POR_NOM,RG_FOLIOORIGEN,TOKEN,TIPO_ACCESS) ".
        "values ".
        "($rut_prestador,$rut_paciente,to_date('$fecha','dd/mm/yyyy'),'$hora',$cod_empresa,$ind_rev_regcli,'$rut_firma','$ipcliente',sysdate,$nunFichae,$sistema,'$firmado_por',$folio,'$token',$tipoacceso)";
	return $sQuery;
    }

    /*
    function function sqlseqhistorialclinico_() {
        $sQuery = "SELECT $this->own.SEQ_AP_TREV_REGCLI.nextval CORRELATIVO from dual";
        return $sQuery;
    }
    */
    
    public function sqlbusquedaHistoricoBitacora($IC,$num_fichae,$empresa,$id_sic){
	$SQL_UNION_ALL	=   '';
	if($id_sic!=''){
	    $SQL_UNION_ALL= "   
	      UNION 
		    SELECT P.ID_TBITACORA,
			    P.NUM_INTERCONSULTA,
			    UPPER (P.TXT_TBITACORA) AS TXT_TBITACORA,
			    P.IND_ESTADO,
			    P.USR_CREA,
			       UPPER (G.NOM_APEPAT)
			    || ' '
			    || UPPER (G.NOM_APEMAT)
			    || ' '
			    || UPPER (G.NOM_NOMBRE)
			       AS NOMBRE,
			    P.FEC_CREA,
			    P.USR_AUDIRA,
			    P.FEC_AUDITA,
			    P.ID_INFOPRIORIDAD
		       FROM PABELLON.PB_TBITACORAIC P, ADMIN.GG_TPROFESIONAL G
		      WHERE    
				P.IND_ESTADO	= 1
			    AND P.USR_CREA	= G.COD_RUTPRO(+)
			    AND P.ID_SIC	= $id_sic ";
	}
	$selectSQL="
		SELECT 
		    P.ID_TBITACORA,
		    P.NUM_INTERCONSULTA,
		    UPPER(P.TXT_TBITACORA)                                                      AS TXT_TBITACORA,
		    P.IND_ESTADO,
		    P.USR_CREA,
		    UPPER(G.NOM_APEPAT)||' '||UPPER(G.NOM_APEMAT)||' '||UPPER(G.NOM_NOMBRE)     AS NOMBRE,
		    P.FEC_CREA,
		    P.USR_AUDIRA,
		    P.FEC_AUDITA,
		    P.ID_INFOPRIORIDAD
		FROM 
		    PABELLON.PB_TBITACORAIC     P, 
		    ADMIN.GG_TPROFESIONAL       G
		WHERE    
		
		    P.NUM_INTERCONSULTA         =   '$IC'
		AND P.IND_ESTADO                =   1        
		AND P.USR_CREA                  =   G.COD_RUTPRO(+)
		AND P.COD_EMPRESA               =   '$empresa'
		AND P.NUM_FICHAE                =   '$num_fichae' 
		AND P.ID_SIC IS NULL
		
	    ".$SQL_UNION_ALL ;
	//  ORDER BY FEC_CREA
        //error_log($selectSQL);
        return $selectSQL;
    }

    public function busqueda_interconsulta($empresa,$num_interconsulta){
             $sQuery = "
                    SELECT  
                        j.nom_grupo                 AS nom_especialidad,
                        a.num_interconsulta         AS CAMPO1,
                        a.cod_rutpac                AS CAMPO2,
                        a.cod_digver                AS CAMPO3, 
                        b.ind_tisexo                AS CAMPO4,
                        trunc(months_between(sysdate,b.fec_nacimi)/12) AS CAMPO5,
                        a.des_diagno                AS CAMPO6,
                        f.nom_establ                AS ESTABLOR,
                        f.cod_establ                AS CODORIGEN,
                        trunc(sysdate-a.fec_recep)  AS DIASESPERA,
                        e.nom_establ                AS ESTABREF,
                        a.ind_auge                  AS CAMPO8, 
                        a.cod_cie10                 AS CAMPO9,
                        c.num_nficha                AS CAMPO10,
                        a.cod_establ                AS CAMPO11, 
                        a.cod_empresa               AS CAMPO12, 
                        g.nombre                    AS POLICLINICO, 
                        a.des_espmot                AS CAMPO14, 
                        h.nombre                    AS CAMPO15, 
                        b.cod_rutref                AS CAMPO16, 
                        b.cod_digref                AS CAMPO17, 
                        b.nom_nombre || ' ' || b.nom_apepat || ' ' || b.nom_apemat AS CAMPO18,
                        b.num_fichae                AS CAMPO19, 
                        b.num_telefo1               AS CAMPO20,
                        b.num_celular               AS CAMPO21, 
                        a.num_fichae                AS CAMPO22, 
                        b.nom_direcc ||' ' || b.num_casa AS CAMPO23, 
                        i.nom_comuna                AS CAMPO24,
                        a.cod_especi                AS CAMPO25, 
                        (select   count(*) from admin.so_tintercitaelim u 
                        where 
                                a.num_interconsulta= u.num_interconsulta and 
                                a.cod_empresa= u.cod_empresa and u.cod_eliminacita='0108') AS CUENTA_NSP,
                         g.nombre     AS TIPOINTERVENCION,
                        (select  
                                COD_PRESTACION
                         from
                                 admin.SO_TMOTICIQ m
                         where
                             a.cod_especi = m.cod_motivo    
                         ) AS CODIGOIQ 
                         
                    FROM 
                        admin.so_tinterconsulta a, 
                        admin.gg_tgpacte b, 
                        admin.so_tcpacte c, 
                        admin.gg_tprofesional d, 
                        admin.gg_testabl e, 
                        admin.gg_testabl f, 
                        admin.poli_serv_proc_exa g, 
                        admin.busca_motivo h, 
                        admin.gg_tcomuna i, 
                        ADMIN.GG_TGRUESP J 
                        
                        WHERE 
                            j.cod_grupo=g.espec 
                        AND a.cod_establref= '$empresa' 
                        AND b.ind_estado <> 'E' 
                        AND f.ind_estado <> 'E'
                        AND a.num_interconsulta = '$num_interconsulta'
                        AND a.cod_motivo = '4' 
                        AND g.espec = 'CIRI' 
                        AND b.ind_estado = 'V' 
                        AND c.ind_estado = 'V' 
                        AND a.num_fichae = b.num_fichae 
                        AND a.num_fichae = c.num_fichae 
                        AND a.cod_empresa = c.cod_empresa 
                        AND a.cod_rutpro = d.cod_rutpro 
                        AND a.cod_establ = f.cod_establ 
                        AND a.cod_establref = e.cod_establ 
                        AND a.cod_especi = g.codigo 
                        AND a.cod_motivo = h.codigo 
                        AND b.cod_comuna = i.cod_comuna(+) 
                        
                        ";
             
		return $sQuery;
        }
        
         public function sqlconsultaXbitacora_interconsultas($empresa,$IC,$numfichae){
        
            $selectSQL="   
                            SELECT 

                               P.TXT_TBITACORA  AS TEXTOBITACORA, 
                               P.IND_ESTADO, 
                               P.USR_CREA,        
                               P.FEC_CREA       AS FECHACREA,  
                               P.COD_EMPRESA
                            FROM 

                                PABELLON.PB_TBITACORAIC P,
                                ADMIN.SO_TINTERCONSULTA S,
                                ADMIN.GG_TGPACTE G
                            WHERE 
                                      P.COD_EMPRESA         = '$empresa'
                                AND   S.COD_ESTABL          = '$empresa'
                                AND   P.NUM_INTERCONSULTA   = S.NUM_INTERCONSULTA
                                AND   P.IND_ESTADO          = 1
                                AND   G.NUM_FICHAE          = S.NUM_FICHAE
                                AND   P.NUM_INTERCONSULTA   = $IC
                       ";

           return $selectSQL; 
        } 
        
        
    public function sqlgetListaPreRerefencia($empresa,$especialidad){
        
        $sQuery = "
            SELECT 
               L.NOM_NOMBRE || ' ' || L.NOM_APEPAT || ' ' || L.NOM_APEMAT    AS NOM_PACIENTE,
               P.ID_TABLA AS ID,
               P.COD_RUTPAC, 
               P.COD_DIGVER, 
               P.NUM_FICHAE,
               P.TXT_HIPO_DIAG, 
               P.USR_CREA, 
               P.FEC_CREA, 
               P.NUM_REFERENCIA AS IC,
               P.ID_ASA,
               P.NUM_CITA, 
               P.COD_ESPECIALIDAD
            FROM 

                PABELLON.PB_SOLIQXPOLI P,
                ADMIN.GG_TGPACTE L

            WHERE 

                P.COD_TESTABL               = '$empresa'
                AND  L.COD_RUTPAC           = P.COD_RUTPAC  
                AND P.COD_ESPECIALIDAD      = '$especialidad' ";
        
        
        return $sQuery;
    }
    
    
    public function ListadovistaReferencia($empresa,$usuario){
                        $sql = "SELECT 
                                P.PERMISOS,
                                P.SERVICIO_ASOCIADO,
				P.JEFE_SERVICIO
                            FROM 
				$this->pabellon.PB_USUARIOS_V P 
				WHERE COD_RUTPRO='".$usuario."' AND COD_ESTABL='".$empresa."'";
		return $sql;
                
    }   
    
    public function sqlespecialidadesiq(){
                  $sQuery = "  
                                SELECT
                                    A.COD_GRUPO AS VALUE,
                                    A.NOM_GRUPO AS OPCION
                                FROM
                                    $this->own.GG_TGRUESP A, 
                                    $this->own.SO_TMOTICIQ B
                                WHERE    
                                A.IND_ESTADO        = 'V' 
                                AND A.COD_GRUPO     = B.COD_ESPEC 
                                AND A.COD_GRUPO     <> 'NOAP'
           
                                GROUP BY COD_GRUPO,
                                NOM_GRUPO 
                                ORDER BY NOM_GRUPO

                            ";

            return $sQuery;
    }
    
    public function sqlconsultaXbitacora_parametros($empresa,$ic,$f1,$f2){ 
        
        $where  ='';
        
        if ($ic!='')            {$where.=" AND P.NUM_INTERCONSULTA   = $ic"; }
        if ($f1!='' and $f2!=''){$where.=" AND TO_CHAR(FEC_CREA, 'DD-MM-YYYY') BETWEEN '$f1' AND '$f2' "; }
        
        $selectSQL="
                        SELECT DISTINCT 
                            G.NOM_NOMBRE||' '||G.NOM_APEPAT||' '||G.NOM_APEMAT  AS NOMBRE,
                            S.NUM_FICHAE                                        AS FICHAE,
                            TRUNC(SYSDATE-S.FEC_RECEP)                          AS DIASESPERA,
                            P.NUM_INTERCONSULTA 
                        FROM 
                            PABELLON.PB_TBITACORAIC P,
                            ADMIN.SO_TINTERCONSULTA S,
                            ADMIN.GG_TGPACTE G
                        WHERE 
                                  P.COD_EMPRESA         ='$empresa'
                            AND   S.COD_ESTABL          ='$empresa'
                            AND   P.NUM_INTERCONSULTA   =S.NUM_INTERCONSULTA
                            AND   P.IND_ESTADO          =1
                            AND   G.NUM_FICHAE          =S.NUM_FICHAE
                            $where    
                        ORDER BY DIASESPERA
                        ";

        return $selectSQL;  
    }
    
    
    public function sqlbusquedaPecienteReferenciaEntreFechas($empresa,$espacialidades,$dia_inicio,$dia_final,$ind_ges,$tipo_busqueda,$txt_pato,$GESTION) {
	//ADD EMPRESA 
	if($empresa=='1000'){$empresa='100';}

	$where			    =	'';
	if(!is_null($txt_pato))	    {	$where.= " A.DES_DIAGNO LIKE UPPER('%$txt_pato%')    AND "; }
	if($ind_ges==1)		    {	$where.= " A.IND_AUGE    = '1' AND ";  }  else if ($ind_ges==2){ $where.= " A.IND_AUGE = '0' AND ";  }
	if($GESTION!='')	    {	$where.= " A.IND_GESTION = '$GESTION' AND ";  } 
	
	if ($tipo_busqueda == 1)    {
	    $where		    .= " ((TRUNC(SYSDATE-A.FEC_ACTEXAM)  < 180) OR ( A.IND_NECEXAMENES = 1))  AND  ";
	} else if ($tipo_busqueda == 2){
	    $where		    .= " ((TRUNC(SYSDATE-A.FEC_ACTEXAM)  > 180 OR A.FEC_ACTEXAM IS NULL) AND (A.IND_NECEXAMENES = 0 OR A.IND_NECEXAMENES IS NULL)) AND  ";
	}
        
	$WHERE_BETWEEN		    =	'';
	if ($dia_final == '1798')   {   
	    //$WHERE_BETWEEN	    =	"TRUNC(SYSDATE-A.FEC_RECEP) > $dia_final "; 
	    $WHERE_BETWEEN	    =	"TRUNC(SYSDATE-A.FEC_RECEP) BETWEEN $dia_inicio AND $dia_final ";  
	} else { 
	    $WHERE_BETWEEN	    =	"TRUNC(SYSDATE-A.FEC_RECEP) BETWEEN $dia_inicio AND $dia_final ";  
	}
	
        $updateSQL =	"
			SELECT 
			    A.ID_SIC							AS ID_SIC,
			    TRUNC(SYSDATE-A.FEC_RECEP)                                  AS DIASESPERA,
			    TO_CHAR(A.FEC_RECEP,'YYYY')                                 AS YEAR,
			    J.NOM_GRUPO                                                 AS NOM_ESPECIALIDAD,
			    A.NUM_INTERCONSULTA                                         AS CAMPO1,
			    A.COD_RUTPAC                                                AS CAMPO2,
			    A.COD_DIGVER                                                AS CAMPO3, 
			    B.IND_TISEXO                                                AS CAMPO4,
			    TRUNC(MONTHS_BETWEEN(SYSDATE,B.FEC_NACIMI)/12)              AS CAMPO5,
			    A.DES_DIAGNO                                                AS CAMPO6,
			    F.NOM_ESTABL                                                AS ESTABLOR,
			    F.COD_ESTABL                                                AS CODORIGEN,
			    E.NOM_ESTABL                                                AS ESTABREF,
			    A.IND_AUGE                                                  AS CAMPO8, 
			    A.COD_CIE10                                                 AS CAMPO9,
			    C.NUM_NFICHA                                                AS CAMPO10,
			    A.COD_ESTABL                                                AS CAMPO11, 
			    A.COD_EMPRESA                                               AS CAMPO12, 
			    G.NOMBRE                                                    AS POLICLINICO, 
			    A.DES_ESPMOT                                                AS CAMPO14, 
			    H.NOMBRE                                                    AS CAMPO15, 
			    B.COD_RUTREF                                                AS CAMPO16, 
			    B.COD_DIGREF                                                AS CAMPO17, 
			    B.NOM_NOMBRE || ' ' || B.NOM_APEPAT || ' ' || B.NOM_APEMAT  AS CAMPO18,
			    B.NUM_FICHAE                                                AS CAMPO19, 
			    B.NUM_TELEFO1                                               AS CAMPO20,
			    B.NUM_CELULAR                                               AS CAMPO21, 
			    A.NUM_FICHAE                                                AS CAMPO22, 
			    B.NOM_DIRECC ||' ' || B.NUM_CASA                            AS CAMPO23, 
			    I.NOM_COMUNA                                                AS CAMPO24,
			    A.COD_ESPECI                                                AS CAMPO25, 
			    A.FEC_USRCREA                                               AS FECHACREACIONIC,

			    A.IND_GESTION                                               AS GESTION,
			    A.IND_GESTION_PAB                                           AS GESTION_PAB,
			    A.IND_NECEXAMENES                                           AS NECESITAEXAMENES,
			    A.IND_ASA                                                   AS ASA,
			    A.FEC_ACTEXAM                                               AS FEC_ULTIMOEXA,
			    TRUNC(SYSDATE-A.FEC_ACTEXAM)                                AS DIA_ULTIMOEXA,

			    G.NOMBRE                                                    AS TIPOINTERVENCION,
			    (SELECT COD_PRESTACION FROM $this->own.SO_TMOTICIQ M  
                            WHERE A.COD_ESPECI = M.COD_MOTIVO)                          AS CODIGOIQ 
			FROM
			    $this->own.SO_TINTERCONSULTA                        A, 
			    $this->own.GG_TGPACTE                               B, 
			    $this->own.SO_TCPACTE                               C, 
			    $this->own.GG_TPROFESIONAL                          D, 
			    $this->own.GG_TESTABL                               E, 
			    $this->own.GG_TESTABL                               F, 
			    $this->own.POLI_SERV_PROC_EXA                       G, 
			    $this->own.BUSCA_MOTIVO                             H, 
			    $this->own.GG_TCOMUNA                               I,
			    $this->own.GG_TGRUESP                               J
			WHERE
			    J.COD_GRUPO						= G.ESPEC           AND
			    --A.COD_ESTABLREF					= '$empresa'        AND
			    A.COD_EMPRESA					= '$empresa'        AND    
			    B.IND_ESTADO					<> 'E'              AND
			    F.IND_ESTADO					<> 'E'              AND
			    A.IND_ESTADO					IN ('P','S')        AND
			    A.COD_MOTIVO					= '4'               AND 
			    G.ESPEC						= '$espacialidades' AND
			    B.IND_ESTADO					= 'V'               AND
			    C.IND_ESTADO					= 'V'               AND
			    A.NUM_FICHAE					= B.NUM_FICHAE      AND
			    A.NUM_FICHAE					= C.NUM_FICHAE      AND
			    --A.COD_ESTABLREF					= C.COD_EMPRESA     AND
			    A.COD_EMPRESA					= C.COD_EMPRESA     AND
			    A.COD_RUTPRO					= D.COD_RUTPRO      AND
			    A.COD_ESTABL					= F.COD_ESTABL      AND
			    A.COD_ESTABLREF					= E.COD_ESTABL      AND
			    A.COD_ESPECI					= G.CODIGO          AND
			    A.COD_MOTIVO					= H.CODIGO          AND
			    B.COD_COMUNA					= I.COD_COMUNA(+)   AND
			    
			    $where
			     
			    $WHERE_BETWEEN
				
			ORDER BY DIASESPERA DESC,A.ID_SIC
		";
		/*
		    (SELECT COUNT(*) FROM ADMIN.SO_TINTERCITAELIM U   WHERE   A.NUM_INTERCONSULTA= U.NUM_INTERCONSULTA AND 
                     A.COD_EMPRESA= U.COD_EMPRESA AND U.COD_ELIMINACITA='0108')  AS CUENTA_NSP,
                */
                return $updateSQL; 
    }
    
    //*************** 14-08-2019 nuevo ***********************//
    public function sqlbusquedaPecienteReferenciaEntreFechasxpaginacion($empresa,$espacialidades,$dia_inicio,$dia_final,$ind_ges,$tipo_busqueda,$txt_pato,$GESTION,$numPag) {
	//ADD EMPRESA 
	if($empresa=='1000')	    {	    $empresa='100';	}
	$where		    ='';
	if(!is_null($txt_pato))	    {	    $where  .= " A.DES_DIAGNO LIKE UPPER('%$txt_pato%')    AND "; }
	if($ind_ges	    ==1)    {	    $where  .= " A.IND_AUGE    = '1' AND ";  } else if ($ind_ges==2){ $where.= " A.IND_AUGE = '0' AND ";  }
	if($GESTION	    !='')   {	    $where  .= " A.IND_GESTION = '$GESTION' AND ";  } 
	
	if($tipo_busqueda  == 1)    {
	    $where		    .=	"   ((TRUNC(SYSDATE-A.FEC_ACTEXAM)  < 180) OR ( A.IND_NECEXAMENES = 1))  AND  ";
	} else if ($tipo_busqueda == 2){
	    $where		    .=	"   ((TRUNC(SYSDATE-A.FEC_ACTEXAM)  > 180 OR A.FEC_ACTEXAM IS NULL) AND (A.IND_NECEXAMENES = 0 OR A.IND_NECEXAMENES IS NULL)) AND  ";
	}
        
	$WHERE_BETWEEN		    =	'';
	if($dia_final == '1798')   {   
	    $WHERE_BETWEEN	    =	"   TRUNC(SYSDATE-A.FEC_RECEP) > $dia_final "; 
	} else { 
	    $WHERE_BETWEEN	    =	"   TRUNC(SYSDATE-A.FEC_RECEP) BETWEEN $dia_inicio AND $dia_final ";  
	}
			
	
        $updateSQL		    =	"
		    SELECT * FROM ( 
			SELECT 
			    COUNT(*) OVER ()						   RESULT_COUNT,
			    ROWNUM							AS REGISTRO,
			    A.ID_SIC							AS ID_SIC,
			    TRUNC(SYSDATE-A.FEC_RECEP)                                  AS DIASESPERA,
			    TO_CHAR(A.FEC_RECEP,'YYYY')                                 AS YEAR,
			    J.NOM_GRUPO                                                 AS NOM_ESPECIALIDAD,
			    A.NUM_INTERCONSULTA                                         AS CAMPO1,
			    A.COD_RUTPAC                                                AS CAMPO2,
			    A.COD_DIGVER                                                AS CAMPO3, 
			    B.IND_TISEXO                                                AS CAMPO4,
			    TRUNC(MONTHS_BETWEEN(SYSDATE,B.FEC_NACIMI)/12)              AS CAMPO5,
			    A.DES_DIAGNO                                                AS CAMPO6,
			    F.NOM_ESTABL                                                AS ESTABLOR,
			    F.COD_ESTABL                                                AS CODORIGEN,
			    E.NOM_ESTABL                                                AS ESTABREF,
			    A.IND_AUGE                                                  AS CAMPO8, 
			    A.COD_CIE10                                                 AS CAMPO9,
			    C.NUM_NFICHA                                                AS CAMPO10,
			    A.COD_ESTABL                                                AS CAMPO11, 
			    A.COD_EMPRESA                                               AS CAMPO12, 
			    G.NOMBRE                                                    AS POLICLINICO, 
			    A.DES_ESPMOT                                                AS CAMPO14, 
			    H.NOMBRE                                                    AS CAMPO15, 
			    B.COD_RUTREF                                                AS CAMPO16, 
			    B.COD_DIGREF                                                AS CAMPO17, 
			    B.NOM_NOMBRE || ' ' || B.NOM_APEPAT || ' ' || B.NOM_APEMAT  AS CAMPO18,
			    B.NUM_FICHAE                                                AS CAMPO19, 
			    B.NUM_TELEFO1                                               AS CAMPO20,
			    B.NUM_CELULAR                                               AS CAMPO21, 
			    A.NUM_FICHAE                                                AS CAMPO22, 
			    B.NOM_DIRECC ||' ' || B.NUM_CASA                            AS CAMPO23, 
			    I.NOM_COMUNA                                                AS CAMPO24,
			    A.COD_ESPECI                                                AS CAMPO25, 
			    A.FEC_USRCREA                                               AS FECHACREACIONIC,

			    A.IND_GESTION                                               AS GESTION,
			    A.IND_GESTION_PAB                                           AS GESTION_PAB,
			    A.IND_NECEXAMENES                                           AS NECESITAEXAMENES,
			    A.IND_ASA                                                   AS ASA,
			    A.FEC_ACTEXAM                                               AS FEC_ULTIMOEXA,
			    TRUNC(SYSDATE-A.FEC_ACTEXAM)                                AS DIA_ULTIMOEXA,

			    G.NOMBRE                                                    AS TIPOINTERVENCION,
			    (SELECT 
				COD_PRESTACION 
			    FROM  
				$this->own.SO_TMOTICIQ M  
			    WHERE A.COD_ESPECI = M.COD_MOTIVO)                          AS CODIGOIQ 
			FROM

			    $this->own.SO_TINTERCONSULTA                        A, 
			    $this->own.GG_TGPACTE                               B, 
			    $this->own.SO_TCPACTE                               C, 
			    $this->own.GG_TPROFESIONAL                          D, 
			    $this->own.GG_TESTABL                               E, 
			    $this->own.GG_TESTABL                               F, 
			    $this->own.POLI_SERV_PROC_EXA                       G, 
			    $this->own.BUSCA_MOTIVO                             H, 
			    $this->own.GG_TCOMUNA                               I,
			    $this->own.GG_TGRUESP                               J

			WHERE
			    J.COD_GRUPO						= G.ESPEC           AND
			    A.COD_ESTABLREF					= '$empresa'        AND
			    B.IND_ESTADO					<> 'E'              AND
			    F.IND_ESTADO					<> 'E'              AND
			    A.IND_ESTADO					IN ('P','S')        AND
			    A.COD_MOTIVO					= '4'               AND 
			    G.ESPEC						= '$espacialidades' AND
			    B.IND_ESTADO					= 'V'               AND
			    C.IND_ESTADO					= 'V'               AND
			    A.NUM_FICHAE					= B.NUM_FICHAE      AND
			    A.NUM_FICHAE					= C.NUM_FICHAE      AND
			    A.COD_ESTABLREF					= C.COD_EMPRESA     AND
			    A.COD_RUTPRO					= D.COD_RUTPRO      AND
			    A.COD_ESTABL					= F.COD_ESTABL      AND
			    A.COD_ESTABLREF					= E.COD_ESTABL      AND
			    A.COD_ESPECI					= G.CODIGO          AND
			    A.COD_MOTIVO					= H.CODIGO          AND
			    B.COD_COMUNA					= I.COD_COMUNA(+)   AND

			    $where

			    $WHERE_BETWEEN

			ORDER BY 

			    DIASESPERA DESC,A.ID_SIC
			   			
			) WHERE REGISTRO BETWEEN ($numPag - 1) * 10 + 1 AND $numPag * 10
		    ";
		// --A.COD_EMPRESA					= C.COD_EMPRESA     AND
		// --A.COD_EMPRESA					= '$empresa'        AND    

        return $updateSQL; 
    }
    //*************** 14-08-2019 nuevo ***********************//
    
    
    
    public function sqlValidaClave($clave){
        
        $clave	    = strtolower($clave);

        $sQuery	    = "
                        SELECT 
			    USERNAME,
			    NAME,
			    MIDDLE_NAME,
			    LAST_NAME 
			FROM 
			   $this->ownGu.FE_USERS 
			WHERE 
			TO_CHAR(TX_INTRANETSSAN_CLAVEUNICA) = '" . strtolower($clave) . "'";

        return $sQuery;
    }
    
    public function  sqlbusquedaDatosSolicitud($rut,$empresa){
        $SQL = "
                SELECT 
                    A.NOM_NOMBRE || ' ' || A.NOM_APEPAT || ' ' || A.NOM_APEMAT          AS NOMBRE_PAC,
                    A.COD_RUTPAC                                                        AS CAMPO2,
                    A.COD_DIGVER                                                        AS CAMPO3,
                    TO_CHAR(FEC_NACIMI, 'DD-MM-YYYY')                                   NACIMIENTO,
                    A.NUM_FICHAE                                                        AS CAMPO10,
                    A.IND_TISEXO                                                        AS SEXO,
                    A.NUM_FICHAE                                                        AS FICHAE,
                    (SELECT B.NUM_NFICHA FROM $this->own.SO_TCPACTE B WHERE A.NUM_FICHAE = B.NUM_FICHAE AND B.IND_ESTADO = 'V' AND  B.COD_EMPRESA = '$empresa') AS FICHA_LOCAL,
                    trunc(months_between(sysdate,A.FEC_NACIMI)/12)                      AS CAMPO5
                  FROM 
                    $this->own.GG_TGPACTE A
                  WHERE 
                    A.COD_RUTPAC='$rut'
                   ";
        return $SQL;
    }
    
    public function  sqlbusquedaDatosSolicitudxFichae($numfichae,$empresa){
        $SQL = "
                 
                SELECT 
                    A.NOM_NOMBRE || ' ' || A.NOM_APEPAT || ' ' || A.NOM_APEMAT          AS NOMBRE_PAC,
                    A.COD_RUTPAC                                                        AS CAMPO2,
                    A.COD_DIGVER                                                        AS CAMPO3,
                    TO_CHAR(FEC_NACIMI, 'DD-MM-YYYY')                                   AS NACIMIENTO,
                    A.NUM_FICHAE                                                        AS CAMPO10,
                    A.IND_TISEXO                                                        AS SEXO,
                    A.NUM_FICHAE                                                        AS FICHAE,
                   (SELECT B.NUM_NFICHA FROM 
                        $this->own.SO_TCPACTE B 
                    WHERE 
                        A.NUM_FICHAE = B.NUM_FICHAE 
                    AND 
                        B.IND_ESTADO = 'V' 
                    AND B.COD_EMPRESA = '$empresa')                                     AS FICHA_LOCAL,
                    trunc(MONTHS_BETWEEN(SYSDATE,A.FEC_NACIMI)/12)                      AS CAMPO5
                FROM 
                    $this->own.GG_TGPACTE A
                WHERE 
                     A.NUM_FICHAE   ='$numfichae'
                         
                   ";
        return $SQL;
    }
    
    
    public function sqlbusquedaPacientexFichaLocal($ficha_local,$empresa){
                   
                   
                   $sQuery =" 
                                SELECT 
                                    A.NOM_NOMBRE||' '||A.NOM_APEPAT||' '|| A.NOM_APEMAT                     AS NOMBRE_PAC,
                                    B.COD_RUTPAC                                                            AS CAMPO2,
                                    A.COD_DIGVER                                                            AS CAMPO3,
                                    B.NUM_FICHAE                                                            AS FICHAE,
                                     A.NUM_FICHAE                                                           AS CAMPO10,
                                    DECODE(A.IND_TISEXO,'M','MASCULINO','F','FEMENINO','NO ESPECIFICADO')   AS TIPO_SEXO,
                                    TO_CHAR(A.FEC_NACIMI,'DD/MM/YYYY')                                      AS NACIMIENTO,
                                    TRUNC(MONTHS_BETWEEN(SYSDATE,A.FEC_NACIMI)/12)                          AS CAMPO5,
                                    A.IND_TISEXO                                                            AS SEXO,
                                    A.NOM_DIRECC                                                            AS DIRECCION,
                                    A.NUM_TELEFO1 || ' ' || A.NUM_CELULAR                                   AS FONO_CONTACTO,
                                    B.NUM_NFICHA                                                            AS FICHA_LOCAL
                                FROM 
                                    $this->own.SO_TCPACTE   B,
                                    $this->own.GG_TGPACTE   A
                                WHERE  
                                         B.IND_ESTADO       = 'V' 
                                    AND  B.COD_EMPRESA      = '$empresa' 
                                    AND  B.NUM_NFICHA       = '$ficha_local'
                                    AND  B.NUM_FICHAE       = A.NUM_FICHAE";
                   
                   
                  return $sQuery;  
    } 
                
               
               
               
     public function  sqlbusquedaListaPaciente_histo($session,$empresa,$tipo_est=''){
        $where_estado='';
         if($tipo_est!=''){
              $where_estado=" AND P.IND_ESTADO IN ($tipo_est) ";
        }
      
            $SQL = "
                
                    SELECT 
                    
ID_ARCHIVO_SUBIDO,
TIPO_RECHAZO,
OBS_RECHAZO,


                        COD_USRCREA_TO_MUE,
                            TO_CHAR(P.FEC_USRCREA_TO_MUE, 'DD-MM-YYYY hh:mm') as FEC_USRCREA_TO_MUE,
                        COD_USRCREA_ENV,
                           TO_CHAR(P.FEC_USRCREA_ENV, 'DD-MM-YYYY hh:mm') as FEC_USRCREA_ENV,
                        COD_USRCREA_RECEP,
                            TO_CHAR(P.FEC_USRCREA_RECEP, 'DD-MM-YYYY hh:mm') as FEC_USRCREA_RECEP,
                        COD_EMPRESA_RECEP,
                        COD_USRCREA_INFORMADA,
                           TO_CHAR(P.FEC_USRCREA_INFORMADA, 'DD-MM-YYYY hh:mm') as FEC_USRCREA_INFORMADA,
                        COD_EMPRESA_INFORMADA,

                      TO_CHAR(P.FEC_USRCREA, 'DD-MM-YYYY hh:mm') as FEC_USRCREA,
                        P.ID_SOLICITUD_HISTO                                                                                    AS ID_HISTO,
                        P.DES_OBSERVACIONES                                                                                     AS OBSERVACIONES,
                        P.IND_ESTADO                                                                                            AS ID_ESTADO,
                        DECODE(P.IND_ESTADO,'1','SOLICITUD EN ESPERA','2','SOLICITUD EN PROCESO','3','SOLICITUD FINALIZADA','4','TOMA DE MUESTRA','5','ENVIADA','6','RECEPCIONADA','7','INFORMADA','8','RECHAZADA')    AS DES_ESTADO,
                        A.NOM_NOMBRE || ' ' || A.NOM_APEPAT || ' ' || A.NOM_APEMAT AS NOMBRE_PAC,
                        A.COD_RUTPAC                                                                                            AS CAMPO2,
                        A.COD_DIGVER                                                                                            AS CAMPO3,
                        A.NUM_FICHAE                                                                                            AS FICHAE,
                        TO_CHAR(FEC_NACIMI, 'DD-MM-YYYY')                                                                          NACIMIENTO,
                        A.NUM_FICHAE AS CAMPO10,
                        (SELECT B.NUM_NFICHA FROM $this->own.SO_TCPACTE B WHERE A.NUM_FICHAE = B.NUM_FICHAE AND B.IND_ESTADO = 'V' AND  B.COD_EMPRESA = '$empresa') AS FICHA_LOCAL,
                        TRUNC(MONTHS_BETWEEN(SYSDATE,A.FEC_NACIMI)/12) AS CAMPO5
                      FROM 
                        $this->own.GG_TGPACTE               A,
                        $this->pabellon.PB_SOLICITUD_HISTO  P
                      WHERE 
                            P.NUM_FICHAE  = A.NUM_FICHAE
                        AND P.COD_EMPRESA = '$empresa'
                        AND P.COD_USRCREA = '$session'
                            $where_estado
                       
                        ";    


        return $SQL;
    
    }
    
    public function  sqlBusquedaSolcitudPatologico($id,$empresa,$fechainico,$fechafinal,$id_tabla){

        $where                      = '';

        if(is_numeric($id))         {   $where = " AND P.ID_SOLICITUD_HISTO = '$id' " ;         }
        if(is_numeric($id_tabla))   {   $where = " AND P.ID_TABLA           = '$id_tabla' " ;   }
            
            $SQL = "
                    SELECT
			P.ID_TABLA                                                                                              AS ID_TABLA, 
                        P.ID_SOLICITUD_HISTO                                                                                    AS ID_HISTO,
                        P.NUM_FICHAE, 
                        P.COD_USRCREA, 
                        P.FEC_USRCREA, 
                        P.COD_EMPRESA, 
                        P.DES_SITIOEXT, 
                        P.DES_UBICACION, 
                        P.DES_TAMANNO, 
                        DECODE(P.ID_TIPO_LESION,
                                                '1','LIQUIDO',
                                                '2','&Oacute;RGANO',
                                                '3','TEJIDO')                                                                   TXT_TIPOSESION, 
                        DECODE(P.ID_ASPECTO,
                                                '1','INFLAMATORIA',
                                                '2','BENIGNA',
                                                '3','NEOPL&Aacute;SICA')                                                        TXT_ASPECTO,
                        
                        DECODE(P.ID_ANT_PREVIOS,
                                                '1','NO', 
                                                '2','BIOPSIA ', 
                                                '3','CITOLOG&Iacute;A')                                                         TXT_ANT_PREVIOS,
                        P.ID_ANT_PREVIOS,
                        P.NUM_ANTECEDENTES, 
                        P.DES_BIPSIA,
                        P.DES_CITOLOGIA, 
                        P.DES_OBSERVACIONES, 
                        P.IND_ESTADO, 
                        P.FEC_REVISION,
                        P.IND_ESTADO                                                                                            AS ID_ESTADO,
                        DECODE(P.IND_ESTADO,'1','SOLICITUD EN ESPERA','2','SOLICITUD EN PROCESO','3','SOLICITUD FINALIZADA')    AS DES_ESTADO,
                        A.NOM_NOMBRE || ' ' || A.NOM_APEPAT || ' ' || A.NOM_APEMAT                                              AS NOMBRE_PAC,
                        A.COD_RUTPAC                                                                                            AS CAMPO2,
                        A.COD_DIGVER                                                                                            AS CAMPO3,
                        A.NUM_FICHAE                                                                                            AS FICHAE,
                        TO_CHAR(A.FEC_NACIMI,  'DD-MM-YYYY')                                                                       NACIMIENTO,
                        TO_CHAR(P.FEC_USRCREA, 'DD-MM-YYYY')                                                                       FEC_SOLICITUD,
                        A.NUM_FICHAE                                                                                            AS CAMPO10,
                        
                    CASE 
                        WHEN 
                            $empresa = 1000 
                        THEN 
                            (SELECT B.NUM_NFICHA FROM $this->own.SO_TCPACTE B WHERE A.NUM_FICHAE = B.NUM_FICHAE AND B.IND_ESTADO = 'V' AND  B.COD_EMPRESA = 100)
                        ELSE 
                            (SELECT B.NUM_NFICHA FROM $this->own.SO_TCPACTE B WHERE A.NUM_FICHAE = B.NUM_FICHAE AND B.IND_ESTADO = 'V' AND  B.COD_EMPRESA = '$empresa')
                    END                                                                                                                                                 AS FICHA_LOCAL,

                    --(SELECT B.NUM_NFICHA FROM $this->own.SO_TCPACTE B WHERE A.NUM_FICHAE = B.NUM_FICHAE AND B.IND_ESTADO = 'V' AND  B.COD_EMPRESA = '$empresa') AS FICHA_LOCAL,
                            
                        TRUNC(MONTHS_BETWEEN(SYSDATE,A.FEC_NACIMI)/12) AS CAMPO5
                    FROM 
                        $this->own.GG_TGPACTE               A,
                        $this->pabellon.PB_SOLICITUD_HISTO  P
                    WHERE 
                    
                            P.NUM_FICHAE            = A.NUM_FICHAE
                        AND P.COD_EMPRESA           = '$empresa'
                       
                        $where

                    ";    
            return $SQL;
    }
    
    public function sql_busqudaDeplantillasQx($RutPro){
        
        $SQL = " SELECT 
                       P.ID_PLANTILLAS_QX               AS ID, 
                       UPPER(P.PLANTILLA_TITULO)        AS TITULO, 
                       P.PLANTILLA_CONTENIDO            AS CONTENIDO, 
                       P.COD_USRCREA, 
                       P.FEC_USRCREA, 
                       P.COD_TESTABL
                    FROM 
                        $this->pabellon.PB_PLANTILLAS_QX P
                    WHERE
                    P.COD_USRCREA='$RutPro'   AND IND_ESTADO='V' ";
        
        return $SQL;
    }
    
    
     public function sql_busqudaDeplantillasQxIndividual($id){
             
             $sm_sql = "SELECT 
                            P.ID_PLANTILLAS_QX, 
                            P.PLANTILLA_TITULO, 
                            P.PLANTILLA_CONTENIDO AS CONTENIDO, 
                            P.COD_USRCREA, 
                            P.FEC_USRCREA, 
                            P.COD_TESTABL

                         FROM PABELLON.PB_PLANTILLAS_QX P

                         WHERE

                          P.ID_PLANTILLAS_QX ='$id'"

                         . " AND IND_ESTADO='V'";
            
            
            return $sm_sql ;
             
        }

    
    public function sqlLastModicacionReferencia($num_interconsulta,$empresa){
        $sm_sql = "SELECT NUM_MODIF FROM ADMIN.SO_TINTERCMOD  WHERE NUM_INTERCONSULTA = '$num_interconsulta' AND COD_EMPRESA = '$empresa'  ";
        return $sm_sql;                
    }
        
                
    public function guardoHistorialDeInterconsulta($num_modificacion,$id_ususario,$num_interconsulta,$empresa,$num_fichae){
        
            $sm_sql = "     INSERT INTO ADMIN.SO_TINTERCHIST(
                                        NUM_INTERCONSULTA, 
                                        COD_ESTABL, 
                                        COD_RUTPAC, 
                                        COD_DIGVER, 
                                        NUM_CORPAC, 
                                        NUM_NFICHA, 
                                        COD_ESPECI, 
                                        COD_MOTIVO, 
                                        COD_INTQUIRU, 
                                        COD_PROCED, 
                                        COD_PATESPE, 
                                        FEC_RECEP, 
                                        FEC_CITACI, 
                                        NUM_CITA, 
                                        COD_RECINST, 
                                        COD_CONSRESU, 
                                        COD_OPEPROCE, 
                                        COD_USRCREA, 
                                        FEC_USRCREA, 
                                        COD_USUARI, 
                                        FEC_AUDITA, 
                                        IND_ESTADO, 
                                        COD_EMPRESA, 
                                        COD_ESTABLREF, 
                                        MOTIVO_RECHAZO, 
                                        NUM_FOLIOSIS, 
                                        IND_PROCED, 
                                        COD_ESPEPROCE, 
                                        IND_AUGE, 
                                        DES_HIPODIAG, 
                                        COD_CIE10, 
                                        DES_FUNDADIAG, 
                                        DES_EXAMEN, 
                                        COD_RUTPRO, 
                                        DES_DIAGNO, 
                                        DES_ESPMOT, 
                                        IND_ESPMOT, 
                                        DES_DETDIAGNO, 
                                        IND_ICGES, 
                                        cod_patges, 
                                        NUM_FICHAE, 
                                        DES_ESPPROCEXA, 
                                        IND_DESTINOIC, 
                                        MOTIVO, 
                                        COD_ESTABLCIT, 
                                        COD_ESPECICIT, 
                                        IND_FUNCIONARIO, 
                                        FEC_HOSPITALIZA, 
                                        COD_ELIMINA, 
                                        FEC_AUDITACIT, 
                                        DES_AUDITA,  
                                        COD_ESTABLNOTIFICA, 
                                        COD_USUARINOTIFICA, 
                                        FEC_NOTIFICACITA, 
                                        IND_ASA,
                                        FEC_ACTEXAM,
                                        ID_SIC,
                                        IND_GESTION,
                                        IND_GESTION_PAB,
                                        IND_NECEXAMENES,
                                        NUM_MODIF, 
                                        DES_MODIFICACION, 
                                        FEC_MODIFICACION, 
                                        COD_USRMOD
                                        )
                                    SELECT 
                                        NUM_INTERCONSULTA, 
                                        COD_ESTABL, 
                                        COD_RUTPAC, 
                                        COD_DIGVER, 
                                        NUM_CORPAC, 
                                        NUM_NFICHA, 
                                        COD_ESPECI, 
                                        COD_MOTIVO, 
                                        COD_INTQUIRU, 
                                        COD_PROCED, 
                                        COD_PATESPE, 
                                        FEC_RECEP, 
                                        FEC_CITACI, 
                                        NUM_CITA, 
                                        COD_RECINST, 
                                        COD_CONSRESU, 
                                        COD_OPEPROCE, 
                                        COD_USRCREA, 
                                        FEC_USRCREA, 
                                        COD_USUARI, 
                                        FEC_AUDITA, 
                                        IND_ESTADO, 
                                        COD_EMPRESA, 
                                        COD_ESTABLREF, 
                                        MOTIVO_RECHAZO, 
                                        NUM_FOLIOSIS, 
                                        IND_PROCED, 
                                        COD_ESPEPROCE, 
                                        IND_AUGE, 
                                        DES_HIPODIAG, 
                                        COD_CIE10, 
                                        DES_FUNDADIAG, 
                                        DES_EXAMEN, 
                                        COD_RUTPRO, 
                                        DES_DIAGNO, 
                                        DES_ESPMOT, 
                                        IND_ESPMOT, 
                                        DES_DETDIAGNO, 
                                        IND_ICGES, 
                                        COD_PATGES, 
                                        NUM_FICHAE, 
                                        DES_ESPPROCEXA, 
                                        IND_DESTINOIC, 
                                        MOTIVO, 
                                        COD_ESTABLCIT, 
                                        COD_ESPECICIT, 
                                        IND_FUNCIONARIO, 
                                        FEC_HOSPITALIZA, 
                                        COD_ELIMINA, 
                                        FEC_AUDITACIT, 
                                        DES_AUDITA,
                                        COD_ESTABLNOTIFICA, 
                                        COD_USUARINOTIFICA, 
                                        FEC_NOTIFICACITA, 
                                        IND_ASA,
                                        FEC_ACTEXAM,
                                        ID_SIC,
                                        IND_GESTION,
                                        IND_GESTION_PAB,
                                        IND_NECEXAMENES,
                                        '$num_modificacion','CITACION',SYSDATE,'$id_ususario'
                                    FROM 
                                        $this->own.SO_TINTERCONSULTA 
                                    WHERE 
                                        NUM_INTERCONSULTA = '$num_interconsulta'
                                       
                                        AND COD_EMPRESA   = '$empresa'  
                                    ";
                            // AND NUM_FICHAE    = '$num_fichae'
                  return $sm_sql;                
                        
    }  
                    
                    
                    
                
    public function sqlActualizaNumModificacionInterconsulta($num_interconsulta,$num_cam,$empresa){
            $sm_sql = "UPDATE ADMIN.SO_TINTERCMOD  SET NUM_MODIF='$num_cam' WHERE NUM_INTERCONSULTA='$num_interconsulta' AND COD_EMPRESA= '$empresa' ";
            return $sm_sql;                
    }  
        
    public function sql_Act_FechaExamenes($IC,$FEC_ACT,$session,$empresa,$nfichae){
            //actualiza fecha examenes IC
             $sm_sql = "  		
                     UPDATE ADMIN.SO_TINTERCONSULTA 
                            SET 
                            FEC_ACTEXAM 	= TO_DATE('$FEC_ACT', 'DD/MM/YYYY'), 
                            FEC_AUDITA 		= SYSDATE, 
                            FEC_AUDITACIT 	= SYSDATE, 
                            COD_ESTABLCIT 	= $empresa,  
                            COD_USUARI 		= $session
                      WHERE 
                            NUM_INTERCONSULTA 	= '$IC'
                            AND NUM_FICHAE 	= '$nfichae'
                            AND cod_empresa	= '$empresa' 
                            ";
            return $sm_sql; 
        }
    
    
    public function  sqlbusquedaPrevisionxRut($rut){
                $SQL= "SELECT
                            B.NOM_PREVIS,
                            A.IND_PREVIS
                            FROM
                        $this->own.SO_TTITUL A,
                        $this->own.gg_tdatprev B
                            WHERE
                            A.COD_RUTTIT= '$rut' AND B.ind_previs=A.ind_previs";
                return $SQL;
                        
    }
    
    public function sqlbusquedatipoPaciente($empresa){
        
                        $SQL="SELECT 
                                    P.ID_TIPO_PACIENTE                      AS VALOR, 
                                    P.DES_TIPO_PACIENTE                     AS CONTENIDO
                                    FROM 
                                    $this->pabellon.PB_TIPO_PACIENTE P
                                WHERE 
                                    IND_ESTADO                              ='V'";
                return  $SQL;
    }
    
    
    //***************** BUSQUEDA DE SOLO PABELLON CENTRAL **********************
    public function sqlbusquedaPabellonesXzona($empresa){
	$SQL = "
		SELECT 
		    P.COD_PABELLON,  
		    P.SALA_DESCRIPCION
		FROM 
		    $this->pabellon.PB_SALA_PABELLON P
		WHERE 
			P.COD_EMPRESA	    =   '$empresa' 
		    AND P.IND_ESTADO	    =   'V' 
		    AND P.IND_TIPOPABELLON  IN ('C')    
		ORDER 
		    BY IND_ORDER
		";
	return $SQL;
    }
    
    public function sqlbusquedaPabellonesXzonaDetalle($empresa){
         $SQL = "
                    SELECT 
                        P.COD_PABELLON                                      AS COD, 
                        P.SALA_DESCRIPCION                                  AS TXTDESCRIPCION,
                        DECODE(P.IND_ESTADO,'V','ACTIVO','E','NO ACTIVO')   AS TXTESTADO, 
                        P.IND_ESTADO                                        AS IDESTADO, 
                        P.SALA_DESCRIPCION                                  AS DESCRIPCION, 
                        P.COD_EMPRESA                                       AS EMPRESA, 
                        P.IMPLEMENTACION                                    AS TXT_IMPLEMENTACION, 
                        P.NOM_CORTO                                         AS NOMCORTO
                    FROM 
                       $this->pabellon.PB_SALA_PABELLON P
                    WHERE 
                       P.COD_EMPRESA = '$empresa' AND P.IND_TIPOPABELLON  IN ('C') AND P.IND_ESTADO = 'V'  ";
	return   $SQL;
	//ORDER BY IND_ORDER
    }
    
    
    public function sqlcarga_procedencia($empresa=""){
        $SQL = "SELECT 
                     P.ID_PROCEDENCIA   AS  ID, 
                     P.TIPO_PROCEDENCIA AS  TXT_DES
                FROM 
                    $this->pabellon.PB_APROCEDENCIA P
                WHERE 
                    P.IND_ESTADO=1";   
        return   $SQL;    
        
    }
    
    public function sqlcarga_sub_tipo_paciente($empresa){
        $SQL = "SELECT 
                    P.SUB_TIPOQX AS ID, 
                    P.DES_TIPOQX AS TXT_DES 
                FROM 
                    $this->pabellon.PB_SUBTIPO_QX P
                WHERE
                    P.IND_ESTADO=1";   
        return   $SQL;  
    }
     
    public function sqlcarga_codigos_imei(){
        $SQL="SELECT 
                    COD_PRESTACION,
                    NOM_PRESTACION,
                    FAMILIA_INTERVENCION,
                    NOM_CORTOS
                FROM 
                    $this->own.GG_TPRESTACION
                WHERE
                IND_ESTADO = 'V'
                ORDER BY  
                NOM_PRESTACION
                ";
        return $SQL;
    }
    
    
    public function sqlcomprueba_codigo_imei($imei){
       $SQL ="SELECT  COUNT(*) AS EXISTE FROM  $this->own.GG_TPRESTACION C  WHERE COD_PRESTACION='$imei' ";
       return $SQL; 
    }
    
    /*
    public function sqlcomprueba_procedimientos_imei($empresa,$imei){
        $SQL=" SELECT COUNT(*) AS PROCEDIMIENTOS FROM $this->own.GG_TPRESTA G WHERE G.COD_EMPRESA ='$empresa' AND G.IND_TIPRES='P' AND G.COD_PRESTA = '$imei' ";
        return   $SQL;
    }
    */
    
    /*
    public function sqlcarga_procedimientos_imei($empresa){
        $SQL    =   "SELECT G.COD_PRESTA, G.NOM_CORTOS,G.NOM_LARGOS FROM $this->own.GG_TPRESTA G WHERE G.COD_EMPRESA = '$empresa' AND G.IND_TIPRES='P' AND G.IND_ESTADO = 'V' ";
        return   $SQL;
    }
    */
    
    public function sqlcomprueba_procedimientos_imei($empresa,$imei){
        $SQL="  SELECT 
                    COUNT(*) AS PROCEDIMIENTOS 
                FROM 
                    $this->own.GG_TPRESTA G 
                WHERE 
                    G.COD_EMPRESA    IN ($empresa) AND 
                    G.IND_TIPRES     IN  ('R','P') AND 
                    G.IND_ESTADO     =  'V' AND 
                    G.IND_PABE       =  '1' AND
                    G.COD_PRESTA     =  '$imei' ";
        return   $SQL;
    }
    
    public function sqlcarga_procedimientos_imei($empresa){
        $SQL=" 
                SELECT 
                    G.COD_PRESTA, 
                    G.NOM_CORTOS,
                    G.NOM_LARGOS 
                FROM 
                    ADMIN.GG_TPRESTA G 
                WHERE 
                G.COD_EMPRESA    IN ($empresa) AND 
                G.IND_TIPRES     IN ('R','P') AND 
                G.IND_ESTADO     = 'V' AND 
                G.IND_PABE       = '1'
                ";
        return   $SQL;
    }
    
    
    public function sql_exiteprofesionalMedico($empresa,$rutPro){
       $Sql = " 
                SELECT 
                    ID_TMEDICO  AS ID
                FROM 
                    $this->pabellon.PB_TMEDICOS 
                WHERE 
                    COD_RUTPRO  = '$rutPro'
                AND     
                    COD_EMPRESA = '$empresa'
        ";
        return $Sql;
    }
    
     public function sql_exiteprofesionalEnfe_Matro($empresa,$rutPro){
        
       $Sql = " 
                SELECT 
                    ID_PROFESIONAL_PB   AS ID
                FROM 
                    $this->pabellon.PB_PROFESIONALES 
                WHERE 
                    COD_RUTPAC  = '$rutPro'
                AND     
                    COD_TESTABL = '$empresa'
        ";
        return $Sql;
        
    }
    
    public function sql_exiteprofesional_TNS($empresa,$rutPro){
        
       $Sql = " 
                SELECT 
                    ID_TNS                  AS ID
                FROM 
                    $this->pabellon.PB_TNS 
                WHERE 
                    COD_RUTPAC  = '$rutPro'
                AND     
                    COD_TESTABL = '$empresa'
        ";
        return $Sql;
    }
    
    public function sql_busquedaProfesional($empresa,$rutPro,$TipoPro){
        
        $where = '';
        
        /*
               if ($TipoPro== '1'){
                $where = "  AND GG.COD_TPROFENEW IN ('MEDI','INTG','AN') AND GG.COD_EMPRESA  = '$empresa' ";
        } else if ($TipoPro== '2'){
                $where = "  AND GG.COD_TPROFE IN ('ENFE','MATR') ";
        } else if ($TipoPro== '3'){
                $where = "  AND GG.COD_TPROFE IN ('TPAR','AUXI') ";
        }
        */
        
        $Sql = "
                SELECT 
                        GG.NOM_NOMBRE||' '|| GG.NOM_APEPAT ||' '|| GG.NOM_APEMAT    AS PROFESIONAL,
                        GG.COD_RUTPRO                                               AS ID,
                        GG.COD_DIGVER                                               AS DV,
                        GG.COD_TPROFE                                               AS MEDI,
                        PR.NOM_TPROFE                                               AS TXTPROFESION,
                        PR.DESC_PROFESION                                           AS TXTDESPROFE
                FROM 
                        $this->own.GG_TPROFESIONAL      GG,
                        $this->own.GG_TPROFESION        PR
                WHERE
                            GG.IND_ESTADO               = 'V'
                        AND GG.COD_RUTPRO               = '$rutPro'
                        AND PR.COD_TPROFE               = GG.COD_TPROFE
                        $where
                ORDER 
                    BY GG.NOM_APEPAT";

        return $Sql;
    }
    
    //trabajando 
    public function sql_carga_unidades_clinicas($empresa){
        
        $where              = '';
        //Falto Angol
        if ($empresa        == '106'){  
            //  $where.= ' AND  GG_TSERVICIO.ID_SERDEP IN (80,14,126,145,153,263,57,164,206,19)'; 
        } else if($empresa  == '100'){    
                $where.= ' AND  GG_TSERVICIO.ID_SERDEP IN (40,14,145,190,193,112,263,80,223,263,152,267,268,264,266,297,296) '; 
        }
        
        $Sql= " 
                SELECT  
                    GG_TSERVICIO.ID_SERDEP              AS ID, 
                    GG_TSERVICIO.NOM_SERVIC             AS TXT_DES
                FROM 
                    $this->own.GG_TSERVICIO, 
                    $this->own.GG_TSERVICIOXEMP 
                WHERE 
                        GG_TSERVICIOXEMP.ID_SERDEP      = GG_TSERVICIO.ID_SERDEP 
                    AND (GG_TSERVICIOXEMP.IND_MED       = '1' OR GG_TSERVICIO.id_serdep IN('268','266'))
                    AND GG_TSERVICIOXEMP.COD_EMPRESA    = '$empresa'
                    AND GG_TSERVICIO.IND_SERDEP         ='S'
                 ".$where."
                        
                ORDER BY GG_TSERVICIO.NOM_SERVIC 
                
            ";
        return $Sql;
    }
    
    public function ultima_modificacion($num_interconsulta,$empresa){
            $sm_sql = "SELECT NUM_MODIF FROM $this->own.SO_TINTERCMOD  WHERE NUM_INTERCONSULTA ='$num_interconsulta' AND COD_EMPRESA= '$empresa'  ";
            return $sm_sql;                
    }
    
    public function insertamodificacionInterconsulta($num_interconsulta,$num_cam,$empresa){
            $sm_sql = "Insert Into ADMIN.so_tintercmod (NUM_INTERCONSULTA,NUM_MODIF,COD_EMPRESA) values('$num_interconsulta','1','$empresa')    ";
            return $sm_sql;                
    }
   
    public function sql_guardaHistorialxInterconsulta($num_modificacion,$id_ususario,$num_interconsulta,$empresa,$num_fichae){
        $sm_sql = " INSERT INTO 
                        ADMIN.SO_TINTERCHIST(
                                NUM_INTERCONSULTA, COD_ESTABL, 
                                COD_RUTPAC, COD_DIGVER, 
                                NUM_CORPAC, NUM_NFICHA, 
                                COD_ESPECI, COD_MOTIVO, 
                                COD_INTQUIRU, COD_PROCED, 
                                COD_PATESPE, FEC_RECEP, FEC_CITACI, 
                                NUM_CITA, COD_RECINST, 
                                COD_CONSRESU, COD_OPEPROCE, 
                                COD_USRCREA, FEC_USRCREA, COD_USUARI, 
                                FEC_AUDITA, IND_ESTADO, 
                                COD_EMPRESA, COD_ESTABLREF, 
                                MOTIVO_RECHAZO, NUM_FOLIOSIS, IND_PROCED, 
                                COD_ESPEPROCE, IND_AUGE, 
                                DES_HIPODIAG, COD_CIE10, 
                                DES_FUNDADIAG, DES_EXAMEN, 
                                COD_RUTPRO, DES_DIAGNO, 
                                DES_ESPMOT, IND_ESPMOT, 
                                DES_DETDIAGNO, IND_ICGES, 
                                cod_patges, NUM_FICHAE, 
                                DES_ESPPROCEXA, IND_DESTINOIC, 
                                MOTIVO, COD_ESTABLCIT, 
                                COD_ESPECICIT, IND_FUNCIONARIO, 
                                FEC_HOSPITALIZA, COD_ELIMINA, 
                                FEC_AUDITACIT, DES_AUDITA,  
                                COD_ESTABLNOTIFICA, 
                                COD_USUARINOTIFICA, 
                                FEC_NOTIFICACITA, NUM_MODIF, 
                                DES_MODIFICACION, 
                                FEC_MODIFICACION, COD_USRMOD
                                ) 
                                SELECT NUM_INTERCONSULTA, 
                                COD_ESTABL, COD_RUTPAC, 
                                COD_DIGVER, NUM_CORPAC, 
                                NUM_NFICHA, COD_ESPECI, 
                                COD_MOTIVO, COD_INTQUIRU, 
                                COD_PROCED, COD_PATESPE, 
                                FEC_RECEP, FEC_CITACI, 
                                NUM_CITA, COD_RECINST, 
                                COD_CONSRESU, COD_OPEPROCE, 
                                COD_USRCREA, FEC_USRCREA, 
                                COD_USUARI, FEC_AUDITA, 
                                IND_ESTADO, COD_EMPRESA, 
                                COD_ESTABLREF, MOTIVO_RECHAZO, 
                                NUM_FOLIOSIS, IND_PROCED, 
                                COD_ESPEPROCE, IND_AUGE, 
                                DES_HIPODIAG, COD_CIE10, 
                                DES_FUNDADIAG, DES_EXAMEN, 
                                COD_RUTPRO, DES_DIAGNO, 
                                DES_ESPMOT, IND_ESPMOT, 
                                DES_DETDIAGNO, IND_ICGES, 
                                COD_PATGES, NUM_FICHAE, 
                                DES_ESPPROCEXA, IND_DESTINOIC, MOTIVO, 
                                COD_ESTABLCIT, COD_ESPECICIT, IND_FUNCIONARIO, 
                                FEC_HOSPITALIZA, COD_ELIMINA, FEC_AUDITACIT, 
                                DES_AUDITA,  COD_ESTABLNOTIFICA, COD_USUARINOTIFICA, 
                                FEC_NOTIFICACITA, '$num_modificacion',  'CITACION',  SYSDATE,  '$id_ususario'
                            FROM 
                                ADMIN.so_tinterconsulta 
                            WHERE 
                                num_interconsulta = '$num_interconsulta'
                                AND num_fichae    = '$num_fichae'
                                AND COD_ESTABL    = '$empresa'
                ";
                            
                  return $sm_sql;                
                        
        }  
    
        
        public function sql_guardaHistorialTablaoperatoria($numHisto,$id,$NAMESESSION,$session,$unique){
        $sQuery = " 
           
        INSERT INTO  
                PABELLON.PB_HISTOTABLAOPERATORIA(
                    ID_TABLA, 
                    NUM_FICHAE, 
                    ID_PROGRAMA_CIRUGIA, 
                    ID_TIPO_PACIENTE, 
                    ID_REINTERVENCION, 
                    ID_GES, 
                    ID_TIPO_OP, 
                    ID_SITUACION, 
                    ID_CANCELACION, 
                    ID_PROCEDENCIA, 
                    ID_CAMA, 
                    ID_REPROGRAMACION, 
                    COD_PABELLON, 
                    FEC_INICIO_SOLICITUD, 
                    FEC_FIN_SOLICITUD, 
                    TXT_HIPO_DIAG, 
                    TXT_POSTOPERATORIO, 
                    NUM_DURACION, 
                    COD_UNIDAD, 
                    ID_ANESTESIA, 
                    TXT_INTERVENCION_SC, 
                    ID_NEC_EVA_PREO, 
                    ID_PRD_SAN, 
                    ID_RESER_PRD_SAN, 
                    ID_RAYOS, 
                    ID_TORRE_LAPA, 
                    ID_POST_OPE, 
                    IND_PABELLON, 
                    IND_TXTSOME, 
                    ID_OPERADO, 
                    ID_ORIGEN, 
                    NUM_REFERENCIA, 
                    ID_ASA, 
                    ID_SUSPENSION, 
                    ID_ORIGENSOL, 
                    TXT_DATELLE_SOLICITUD, 
                    IND_COMPRASERVICIO, 
                    TXT_DES_INTERVENCION, 
                    TXT_ALUMNO, 
                    IND_RECUENTO_COMPRESAS, 
                    TXT_RECUENTO_COMPRESAS, 
                    ID_HERIDAS, 
                    TXT_PROFILAXIS, 
                    TXT_DESCRIPCION_QX, 
                    ID_BIOPSIA, 
                    ID_CULTIVO, 
                    ID_ESTADO_TQ, 
                    COD_TESTABL, 
                    FECHA_CREATABLA, 
                    USR_CREA, 
                    FEC_CREA, 
                    USR_AUDITA, 
                    FEC_AUDITA, 
                    COD_USUARIO_FIRMA, 
                    IND_ALUMNO, 
                    NUM_ORDEN, 
                    IND_MATERIALES, 
                    IND_RRHH, 
                    IND_INSUMOS, 
                    IND_INFOPACSUSPEN, 
                    TXT_OTROMOVSUSPENSION, 
                    TXT_INFOPACSUSPEN, 
                    IND_PAD,
                    
                    DATE_INGRESO_PAB, 
                    DATE_INGRESO_QUIROFANO, 
                    DATE_INICIO_ANESTESIA, 
                    DATE_FINAL_ANESTESIA, 
                    DATE_SALIDA_QUIROFANO, 
                    DATE_FINAL_LIMPIEZA, 
                    DATE_TERMINO_INTERVENCION, 
                    DATE_INGRESO_RECUPERACION, 
                    DATE_SALIDA_RECUPERACION,
                    
                    TXT_CIRUPROP,
                    
                    NUM_HISTORIAL,
                    DATE_HISTORIAL,
                    USR_USUARIO_SESSION,
                    USR_FIRMA,
                    SESSION_UNIQUE
                    ) 
                SELECT 
                    ID_TABLA, 
                    NUM_FICHAE, 
                    ID_PROGRAMA_CIRUGIA, 
                    ID_TIPO_PACIENTE, 
                    ID_REINTERVENCION, 
                    ID_GES, 
                    ID_TIPO_OP, 
                    ID_SITUACION, 
                    ID_CANCELACION, 
                    ID_PROCEDENCIA, 
                    ID_CAMA, 
                    ID_REPROGRAMACION, 
                    COD_PABELLON, 
                    FEC_INICIO_SOLICITUD, 
                    FEC_FIN_SOLICITUD, 
                    TXT_HIPO_DIAG, 
                    TXT_POSTOPERATORIO, 
                    NUM_DURACION, 
                    COD_UNIDAD, 
                    ID_ANESTESIA, 
                    TXT_INTERVENCION_SC, 
                    ID_NEC_EVA_PREO, 
                    ID_PRD_SAN, 
                    ID_RESER_PRD_SAN, 
                    ID_RAYOS, 
                    ID_TORRE_LAPA, 
                    ID_POST_OPE, 
                    IND_PABELLON, 
                    IND_TXTSOME, 
                    ID_OPERADO, 
                    ID_ORIGEN, 
                    NUM_REFERENCIA, 
                    ID_ASA, 
                    ID_SUSPENSION, 
                    ID_ORIGENSOL, 
                    TXT_DATELLE_SOLICITUD, 
                    IND_COMPRASERVICIO, 
                    TXT_DES_INTERVENCION, 
                    TXT_ALUMNO, 
                    IND_RECUENTO_COMPRESAS, 
                    TXT_RECUENTO_COMPRESAS, 
                    ID_HERIDAS, 
                    TXT_PROFILAXIS, 
                    TXT_DESCRIPCION_QX, 
                    ID_BIOPSIA, 
                    ID_CULTIVO, 
                    ID_ESTADO_TQ, 
                    COD_TESTABL, 
                    FECHA_CREATABLA, 
                    USR_CREA, 
                    FEC_CREA, 
                    USR_AUDITA, 
                    FEC_AUDITA, 
                    COD_USUARIO_FIRMA, 
                    IND_ALUMNO, 
                    NUM_ORDEN, 
                    IND_MATERIALES, 
                    IND_RRHH, 
                    IND_INSUMOS, 
                    IND_INFOPACSUSPEN, 
                    TXT_OTROMOVSUSPENSION, 
                    TXT_INFOPACSUSPEN, 
                    IND_PAD,
                    
                    DATE_INGRESO_PAB, 
                    DATE_INGRESO_QUIROFANO, 
                    DATE_INICIO_ANESTESIA, 
                    DATE_FINAL_ANESTESIA, 
                    DATE_SALIDA_QUIROFANO, 
                    DATE_FINAL_LIMPIEZA, 
                    DATE_TERMINO_INTERVENCION, 
                    DATE_INGRESO_RECUPERACION, 
                    DATE_SALIDA_RECUPERACION,
                    
                    TXT_CIRUPROP,

                    '$numHisto',
                    SYSDATE,
                    '$session',
                    '$NAMESESSION',
                    '$unique'    
                    
                    FROM 
                        PABELLON.PB_TABLAOPERATORIA 
                    WHERE 
                    ID_TABLA = '$id'
                ";
           return $sQuery;
        }

        public function sql_busquedaLesperaXreferencia($empresa,$especialidad,$rut,$ficha_local,$num_interconsulta,$parametros,$tipo_busqueda){
           
           //SI VIENE con valor 0 no esta definida en la busqueda
           $sql_where='';
           if ($especialidad!=0)         {  $sql_where.=" g.espec             = '$especialidad'        and ";  }
           if ($rut!=0)                  {  $sql_where.=" b.cod_rutpac        = '$rut'                 and ";  }
           if ($ficha_local!=0)          {  $sql_where.=" c.num_nficha        = '$ficha_local'         and ";  }
           if ($num_interconsulta!=0)    {  $sql_where.=" a.num_interconsulta = '$num_interconsulta'   and ";  }
           if ($tipo_busqueda!=0)        {  $sql_where.=" A.IND_ESTADO          in ('P','S')           and ";  }  else {  $sql_where.=" a.ind_estado in ('P','S','R')   and ";  } 
           if ($parametros=='1')         {  $parametros=''; }
           
           $sQuery = " 
                        SELECT 
                            j.COD_GRUPO                                                 as cod_especialidad,
                            j.nom_grupo                                                 as nom_especialidad,
                            a.num_interconsulta                                         AS CAMPO1,
                            a.cod_rutpac                                                AS CAMPO2,
                            a.cod_digver                                                AS CAMPO3, 
                            b.ind_tisexo                                                AS CAMPO4,
                            trunc(months_between(sysdate,b.fec_nacimi)/12)              AS CAMPO5,
                            a.des_diagno                                                AS CAMPO6,
                            f.nom_establ                                                AS ESTABLOR,
                            f.cod_establ                                                AS CODORIGEN,
                            trunc(sysdate-a.fec_recep)                                  AS DIASESPERA,
                            e.nom_establ                                                AS ESTABREF,
                            a.ind_auge                                                  AS CAMPO8, 
                            a.cod_cie10                                                 AS CAMPO9,
                            c.num_nficha                                                AS CAMPO10,
                            a.cod_establ                                                AS CAMPO11, 
                            a.cod_empresa                                               AS CAMPO12, 
                            g.nombre                                                    AS POLICLINICO, 
                            a.des_espmot                                                AS CAMPO14, 
                            h.nombre                                                    AS CAMPO15, 
                            b.cod_rutref                                                AS CAMPO16, 
                            b.cod_digref                                                AS CAMPO17, 
                            b.nom_nombre || ' ' || b.nom_apepat || ' ' || b.nom_apemat  AS CAMPO18,
                            b.num_fichae                                                AS CAMPO19, 
                            b.num_telefo1                                               AS CAMPO20,
                            b.num_celular                                               AS CAMPO21, 
                            a.num_fichae                                                AS CAMPO22, 
                            b.nom_direcc ||' ' || b.num_casa                            AS CAMPO23, 
                            i.nom_comuna                                                AS CAMPO24,
                            a.cod_especi                                                AS CAMPO25, 
                            A.IND_GESTION                                               AS GESTION,
                            A.IND_GESTION_PAB                                           AS GESTION_PAB,
                           
                            (select   count(*)   from   admin.so_tintercitaelim u   where 
                            a.num_interconsulta= u.num_interconsulta and 
                            a.cod_empresa= u.cod_empresa and u.cod_eliminacita='0108')  AS CUENTA_NSP,
                            g.nombre     AS TIPOINTERVENCION,
                            
                            
                            (select COD_PRESTACION  from $this->own.SO_TMOTICIQ m  where  a.cod_especi = m.cod_motivo) AS CODIGOIQ,

                            (select NOM_MOTIVO  from   $this->own.SO_TMOTICIQ m   where  a.cod_especi = m.cod_motivo) AS MOTIVOIQ
                        
                    FROM
                        $this->own.so_tinterconsulta a, 
                        $this->own.gg_tgpacte b, 
                        $this->own.so_tcpacte c, 
                        $this->own.gg_tprofesional d, 
                        $this->own.gg_testabl e, 
                        $this->own.gg_testabl f, 
                        $this->own.poli_serv_proc_exa g, 
                        $this->own.busca_motivo h, 
                        $this->own.gg_tcomuna i,
                        $this->own.GG_TGRUESP J
                    WHERE
                        J.cod_grupo     =g.espec AND
                        a.cod_establref = '$empresa' and
                        b.ind_estado     <> 'E' and 
                        f.ind_estado     <> 'E' and 
                        a.cod_motivo    = '4'  and
                        $sql_where
                        b.ind_estado     = 'V' and 
                        c.ind_estado     = 'V' and 
                        a.num_fichae    = b.num_fichae and 
                        a.num_fichae    = c.num_fichae and 
                        a.cod_empresa    = c.cod_empresa and 
                        a.cod_rutpro    = d.cod_rutpro and 
                        a.cod_establ    = f.cod_establ and 
                        a.cod_establref    = e.cod_establ and
                        a.cod_especi    = g.codigo and 
                        $parametros
                        a.cod_motivo    = h.codigo and 
                        b.cod_comuna    = i.cod_comuna(+)
                        order by DIASESPERA desc
                        ";
          return $sQuery;
        }
         
         
        public function sql_busquedapacientehospitalizado($rut,$empresa,$ficha_local){

                $sql2            ='';                          

                if ($ficha_local!='0') { $sql2.='J.num_nficha='.$ficha_local.' and'; }
                if ($rut!='0')         { $sql2.='J.cod_rutpac = '.$rut.' and';}

                $sm_sql = " 

                            SELECT 
                                    A.COD_RUTPAC                                        AS CAMPO2,
                                    A.COD_DIGVER                                        AS CAMPO3,
                                    NOM_NOMBRE || ' ' || NOM_APEPAT || ' ' ||NOM_APEMAT AS CAMPO18,
                                    J.NUM_NFICHA                                        AS CAMPO10,
                                    D.NOM_SERVIC                                        AS CAMPO4,
                                    E.NOM_SALA                                          AS CAMPO5,
                                    N.DES_NCAMASALA                                     AS CAMPO6,
                                    NUM_CAMAACTUAL                                      AS CAMA,
                                    NUM_HOSPITALIZA                                     AS NUM_HOSPITALIZA,
                                    TO_CHAR(FEC_INGRESO,'DD/MM/YYYY')                   AS FECHA_INGRESO,
                                    J.NUM_FICHAE                                        AS FICHAE
                            FROM 
                                    $this->own.GG_TGPACTE A,
                                    $this->own.HO_THOSPITALIZA B,
                                    $this->own.HO_TCAMA C,
                                    $this->own.GG_TSERDEP D,
                                    $this->own.HO_TSALA E,
                                    $this->own.HO_TNCAMASALA N,
                                    $this->own.SO_TCPACTE J
                            WHERE 
                                    A.NUM_FICHAE        = B.NUM_FICHAE      AND
                                    $sql2
                                    b.cod_empresa       = '$empresa'        AND
                                    B.IND_ESTPACIENTE   = 1                 AND
                                    J.COD_EMPRESA       = B.COD_EMPRESA     AND 
                                    A.NUM_FICHAE        = J.NUM_FICHAE      AND 
                                    B.COD_EMPRESA       = C.COD_EMPRESA(+)  AND
                                    C.NUM_SALA          = E.NUM_SALA(+)     AND
                                    C.NUM_NCAMASALA     = N.NUM_NCAMASALA(+)AND
                                    C.COD_EMPRESA       = D.COD_EMPRESA(+)  AND
                                    B.NUM_CAMAACTUAL    = C.NUM_CAMA(+)     AND
                                    C.COD_SERVICIO      = D.COD_SERVIC(+)  

                    ";

                //A.COD_RUTPAC || '-' || A.COD_DIGVER AS CAMPO1,
            return $sm_sql;                

        }
        
        public function sql_busquedaReintenvencion($numfichae,$empresa){
            
            //BUSQUEDA DE RE-INTERVENCIONES
            
            $sQl=" 
                    SELECT 
                        A.ID_TABLA                                              AS ID,
                        TRUNC(SYSDATE-A.FEC_INICIO_SOLICITUD)                   AS DIAS,
                        A.TXT_POSTOPERATORIO                                    AS DIAGNOTICO,
                        TO_CHAR(A.FEC_INICIO_SOLICITUD, 'DD-MM-YYYY hh24:mi')   AS FECHA_SOLI
                    FROM 
                        PABELLON.PB_TABLAOPERATORIA A 
                    WHERE 
                        TRUNC(SYSDATE-A.FEC_INICIO_SOLICITUD) < 31  
                    AND 
                        A.NUM_FICHAE    = '$numfichae' 
                    AND 
                        A.COD_TESTABL   = '$empresa'
                    AND 
                        A.ID_ESTADO_TQ IN ('15','19','17','27','26')
                    ";
            return $sQl;
        }        
              
        
        
        public function SQLexisteRRHH($id,$rut,$ID_TIPO_RRHH){
            $sql=" SELECT ID_RRHHQX AS ID FROM PABELLON.PB_RRHH_QX WHERE ID_TABLA= $id AND RUT_PROFESIONAL = '$rut' AND ID_TIPO_RRHH = $ID_TIPO_RRHH ";
            return $sql; 
        }
        
        public function sql_existeOftaAnterior($id){
            return " SELECT ID_TOFTA AS ID_OFTA FROM PABELLON.PB_INFO_OFTAMOLOGIA WHERE ID_TABLA=$id "; 
        }

        //Busqueda General Eliminar Dicha Consulta:
        public function sql_busquedaGeneralSolicitudesPabellon($empresa,$tabla,$fecha,$etapa){
    
                    $sql        ='';
                    $cab        ='';
                    $for_fec    ='';
                    
                    if($tabla!=='') {     $sql.=" AND O.ID_TABLA                            = '$tabla'";
                                          $cab=' '
                                                  
                                                . 'O.TXT_RECUENTO_COMPRESAS                 AS TXT_RECUENTO_COMPRESAS,'         
                                                . 'O.ID_TIPO_OP                             AS TIPO,'  
                                                . 'O.ID_REINTERVENCION                      AS REINTERVENCION,'
                                                . 'O.ID_PROGRAMA_CIRUGIA                    AS SUB_TIPOQX, O.IND_CMA, O.ID_PROGRAMA_CIRUGIA AS PROCEDENCIA,'    
                                                . 'O.ID_GES                                 AS GES, '    
                                                . 'O.NUM_DURACION                           AS DURACION, '
                                                . 'O.ID_PRD_SAN                             AS HEMODERIVADO,'
                                                . 'O.ID_RESER_PRD_SAN                       AS TIPO_SANGRE , '
                                                . 'O.ID_RAYOS                               AS RAYOS, '
                                                . 'O.ID_TORRE_LAPA                          AS TORRE_LAPA, '
                                                . 'O.ID_POST_OPE                            AS POST_OPE , '
                                                . 'O.ID_ASA                                 AS ASA, '
                                                . 'O.TXT_DATELLE_SOLICITUD                  AS SITUACION, '
                                                . 'O.ID_ANESTESIA                           AS COD_ANESTESIA, '
                                                . '';
                                          
                    $cab.=" 
                    DECODE(O.ID_PRD_SAN         ,'6','OTRO'
                                                ,'5','CRIOPRECIPITADO'
                                                ,'4','PLAQUETAS'
                                                ,'3','PLASMA'
                                                ,'2','GLÓBULOS ROJOS'
                                                ,'1','NO ESPECIFICADO'
                                                ,'0','NO'
                                                ,'NO ESPECIFICADO')                         AS TXTHERMODERIVADO,
                                                
                    DECODE(O.ID_RESER_PRD_SAN   ,'8','AB I(-)'
                                                ,'7','B III(-)'
                                                ,'6','O A II(-)'
                                                ,'5','O IV(-)'
                                                ,'4','AB I(+)'
                                                ,'3','B III(+)'
                                                ,'2','A II(+)'
                                                ,'1','O IV(+)'
                                                ,'0','NO ESPECIFICADO')                             AS TXTSANGRE,
                                                
                    DECODE(O.ID_TORRE_LAPA      ,'1','SI','0','NO','NO ESPECIFICADO')               AS TXTLAPAROSCOPIA,
                    DECODE(O.ID_POST_OPE        ,'1','SI','0','NO','NO ESPECIFICADO')               AS TXTOPERATORIO,
                    DECODE(O.ID_RAYOS           ,'1','SI','0','NO','NO ESPECIFICADO')               AS TXTRAYOS,
                    DECODE(O.IND_ALUMNO         ,'1','SI'
                                                ,'0','NO'
                                                ,'NO ESPECIFICADO')                                 AS TXTINFOALUMNO,
                                                
                    ";            
                    //||O.TXT_ALUMNO                      
                                 
                    $cab.="DECODE(O.ID_CULTIVO, '1','SI','0','NO','NO ESPECIFICADO')                AS CULTIVOS,";
                    
                    $cab.="DECODE(O.ID_BIOPSIA, '1','SI',
                                                '0','NO',
                                                '2','CONTEMPORANEA',    
                                                '3','DIFERIDA',
                                                'NO ESPECIFICADO')                                  AS BIOPSIA,"; 
                    
                    $cab.="DECODE(O.ID_HERIDAS, '1','LIMPIAS',
                                                '2','CONTAMINADAS',
                                                '3','LIMPIAS CONTAMINADAS',
                                                '4','SUCIAS',
                                                'NO ESPECIFICADO')                                  AS HERIDAS,";  
                    
                    $cab.='O.TXT_PROFILAXIS                                                         AS PROFILAXIS,'
                          . ' UPPER(O.TXT_DESCRIPCION_QX)                                           AS DESCRIPCION_QX, ';
                                         
                                      }
                    if ($fecha!=='') {  $for_fec=  explode('-', $fecha);
                                        if (count($for_fec) == 2){
                                          if ($for_fec[0]=='MM'){
                                              $sql.= " AND TO_CHAR(O.FEC_INICIO_SOLICITUD, 'MM')='$for_fec[1]' ";
                                              //$cab ='(SELECT  COD_MOTIVO FROM PABELLON.PB_SUSPENCIONES S WHERE O.ID_TABLA=S.ID_TABLA) AS SUSPENSION,';   
                                            }
                                        } else {
                                             $sql.= " AND TO_CHAR(O.FEC_INICIO_SOLICITUD, 'DD-MM-YYYY')='$fecha' ";
                                             //$cab ='(SELECT  COD_MOTIVO FROM PABELLON.PB_SUSPENCIONES S WHERE O.ID_TABLA=S.ID_TABLA) AS SUSPENSION,';   
                                        }
                    }
                    
                    
                    if ($etapa!=='') {$sql.=" AND O.ID_ESTADO_TQ='$etapa' ";}
    /*
        O.COD_CIRUJANO, 
    */     
    $sm_sql = "
		SELECT
                
                    DECODE(O.ID_ORIGEN,'1','INSTITUCIONAL','2','PRIVADA','3','URGENCIA','4','PROCEDIMIENTO','5','MATERNIDAD','NO ESPECIFICADO') AS TIPO_OP,
                    DECODE(O.ID_ORIGEN,'1','INSTITUCIONAL','2','PRIVADA','3','URGENCIA','4','PROCEDIMIENTO','5','MATERNIDAD','NO ESPECIFICADO') AS ORIGEN,
                    
                    O.IND_SDERIVADA,
                    O.COD_EMPRESA_DERIVADA,
                        

                    DECODE(O.ID_PROGRAMA_CIRUGIA, 
                                '1', 'HOSP',    
                                '2', 'AMB',          
                                '3', 'HOSP',         
                                '4', 'AMB',    
                                     '')                                                                                                        AS NOM_PROCEDENCIA_COR,
                                     

                    O.ID_PROGRAMA_CIRUGIA,
                    O.IND_CMA,
                                     
                    L.COD_RUTPAC                                                                                                                AS CODRUT,
                    O.ID_TABLA,
                    O.NUM_FICHAE                                                                                                                AS FICHAE,
                    UPPER(L.NOM_NOMBRE) || ' ' || UPPER(L.NOM_APEPAT) || ' ' || UPPER(L.NOM_APEMAT)                                             AS NOMBRE_COMPLETO,
                    L.COD_RUTPAC||'-'||L.COD_DIGVER                                                                                             AS RUTPACIENTE,
                    TRUNC(MONTHS_BETWEEN(SYSDATE,L.FEC_NACIMI)/12)                                                                              AS EDAD,
                    O.COD_UNIDAD                                                                                                                AS COD_UNIDAD,
                    
                    CASE 
                        WHEN 
                            O.COD_TESTABL = 1000 
                        THEN 
                            (SELECT E.NUM_NFICHA FROM ADMIN.SO_TCPACTE E WHERE  E.NUM_FICHAE=O.NUM_FICHAE AND E.COD_EMPRESA=100) 
                        ELSE 
                            (SELECT E.NUM_NFICHA FROM ADMIN.SO_TCPACTE E WHERE  E.NUM_FICHAE=O.NUM_FICHAE AND E.COD_EMPRESA=O.COD_TESTABL) 
                    END                                                                                                                         AS FICHA,

                    --(SELECT E.NUM_NFICHA FROM ADMIN.SO_TCPACTE E WHERE  E.NUM_FICHAE =O.NUM_FICHAE  AND E.COD_EMPRESA=O.COD_TESTABL)            AS FICHA,
                    
                    TO_CHAR(SYSDATE,'DD-MM-YYYY hh24:mi')                                                                                       AS FEC_EMISION, 
                    TO_CHAR(FEC_NACIMI,'DD-MM-YYYY')                                                                                            AS NACIMIENTO,
                     
                    UPPER(O.TXT_HIPO_DIAG)                                                                                                      AS COD_DIAGNO1,
                    UPPER(O.TXT_CIRUPROP)                                                                                                       AS COD_CIRUPROP,
                    UPPER(O.TXT_POSTOPERATORIO)                                                                                                 AS TXT_DIAGPOST,
                    
                    S.NOM_SERVIC,
                    O.TXT_ALUMNO,
                   
                    TO_CHAR(O.FEC_INICIO_SOLICITUD,'hh24:mi')                                                                                   AS HORA_SOLI,
                    TO_CHAR(O.FEC_FIN_SOLICITUD,'hh24:mi')                                                                                      AS HORA_FIN,
                    
                    L.NOM_DIRECC||' '||L.NUM_CASA                                                                                               AS DIRECCION,
                    L.EMAIL                                                                                                                     AS MAIL,
                    L.NUM_CELULAR                                                                                                               AS CELULAR,
                    
                    TO_CHAR(O.FEC_INICIO_SOLICITUD,         'DD-MM-YYYY hh24:mi')                                                               AS FECHA_SOLI,
                    TO_CHAR(O.FEC_FIN_SOLICITUD,            'DD-MM-YYYY hh24:mi')                                                               AS FECHA_FIN,
                    
                    TO_CHAR(O.DATE_INGRESO_PAB,             'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_PAB,                   
                    TO_CHAR(O.DATE_INGRESO_QUIROFANO,       'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_QUIROFANO, 
                    TO_CHAR(O.DATE_INICIO_ANESTESIA,        'DD-MM-YYYY hh24:mi')                                                               AS INICIO_ANESTESIA, 
                    TO_CHAR(O.DATE_FINAL_ANESTESIA,         'DD-MM-YYYY hh24:mi')                                                               AS FINAL_ANESTESIA, 
                    TO_CHAR(O.DATE_SALIDA_QUIROFANO,        'DD-MM-YYYY hh24:mi')                                                               AS SALIDA_QUIROFANO, 
                    TO_CHAR(O.DATE_FINAL_LIMPIEZA,          'DD-MM-YYYY hh24:mi')                                                               AS FINAL_LIMPIEZA, 
                    TO_CHAR(O.DATE_INGRESO_RECUPERACION,    'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_RECUPERACION, 
                    TO_CHAR(O.DATE_TERMINO_INTERVENCION,    'DD-MM-YYYY')                                                                       AS TERMINO_INTERVENCION,
                    TO_CHAR(O.DATE_SALIDA_RECUPERACION,     'DD-MM-YYYY hh24:mi')                                                               AS SALIDA_RECUPERACION,
                        
                    O.NUM_DURACION                                                                                                              AS DURACION,
                    
                    UPPER(O.TXT_DESCRIPCION_QX)                                                                                                 AS DESCRIPCION_QX,

                    TO_CHAR(O.FEC_INICIO_SOLICITUD, 'MM/DD/YYYY')                                                                                  FECHA2,
                    O.ID_OPERADO                                                                                                                AS ESTADO,
                    O.ID_ANESTESIA                                                                                                              AS COD_ANESTESISTA,
                    $cab
                    O.COD_PABELLON                                                                                                              AS N_PABELLON,
                    TO_CHAR(O.FEC_INICIO_SOLICITUD,'DD-MM-YYYY hh24:mi')                                                                           FECHA_OPE,
                    O.ID_TIPO_PACIENTE                                                                                                          AS ID_TIPO_PACIENTE,
                    DECODE(O.ID_TIPO_PACIENTE,'1','PRIORIZADO','2','CONDICIONAL','NO ESPECIFICADO')                                             AS TIPO_PACIENTE,
                    O.FEC_INICIO_SOLICITUD                                                                                                      AS FECHA,
                    O.IND_PABELLON                                                                                                              AS OTROS, 
                    O.USR_CREA                                                                                                                  AS COD_USRCREA,
                    O.NUM_REFERENCIA                                                                                                            AS PACIENTE_REFERENCIA,
		    O.ID_SIC															AS ID_SIC,
		    O.ID_ESTADO_TQ,
                    (SELECT  DES_CORTO FROM PABELLON.PB_ESTADO_TQ E WHERE E.ID_ESTADO_TQ=O.ID_ESTADO_TQ)                                        AS DES_ESTADO,
                    O.IND_TXTSOME                                                                                                               AS TXT_SOME,
                    O.IND_PABELLON                                                                                                              AS TXT_PABELLON,
                    O.NUM_ORDEN                                                                                                                 AS NUM_ORDEN,
                    
                    UPPER(O.TXT_DATELLE_SOLICITUD)                                                                                              AS TXT_DATELLE_SOLICITUD,
                    
                    O.ID_ORIGENSOL,
                    O.IND_MATERIALES                                                                                                            AS CHK_MATERIALES,
                    O.IND_RRHH                                                                                                                  AS CHK_RRHH,
                    O.IND_INSUMOS                                                                                                               AS CHK_INSUMOS,
                    
                    O.FEC_AUDITA,   
                    TO_CHAR(O.FEC_CREA, 'DD-MM-YYYY hh24:mi') AS FECHA_CREACION,
                    
                    O.COD_USUARIO_FIRMA,
                    O.USR_CREA
                    
                FROM
                    PABELLON.PB_TABLAOPERATORIA   O,
                    ADMIN.GG_TSERVICIOXEMP        T,
                    ADMIN.GG_TSERVICIO            S,
                    ADMIN.GG_TGPACTE              L
                WHERE 
                        O.COD_TESTABL               = '$empresa' 
                  AND  (T.ID_SERDEP                 = O.COD_UNIDAD)
                  AND  T.COD_EMPRESA                = '$empresa' 
                  AND  (S.ID_SERDEP                 = T.ID_SERDEP)

                  AND  L.NUM_FICHAE                 = O.NUM_FICHAE
                  $sql
                  ORDER BY FECHA_SOLI
                ";
            // AND PB_TABLAOPERATORIA.FECHA <= SYSDATE
           return $sm_sql;                
        }
        
        /*  
            DECODE(O.IND_CIRUPROP_OD,
                                            '1','SI',
                                            '2','NO',
                                            'NO ESPECIFICADO')                  AS TXT_CIRUPROP_OD,
                    
            DECODE(O.IND_CIRUPROP_OI,
                                    '1','SI',
                                    '2','NO',
                                    'NO ESPECIFICADO')                  AS TXT_CIRUPROP_ID,
                    

        */
        
        public function SQL_OFTA($id){
            
            $sQuery =" 
                SELECT 
                    P.ID_TOFTA,
                    P.NUM_FICHAE,
                    P.ID_TABLA,
                    P.USR_CREA,
                    P.FEC_CREA,
                    P.IND_ESTADO,
                    P.COD_EMPRESA,
                    P.ID_ESTADO_TQ,

                    P.IND_CIRUPROP_OD,
                    P.IND_CIRUPROP_OI,
                    
                    DECODE(P.IND_HIPO_DIAG_OD,'1','X','&nbsp;')                 AS TXT_HIPO_DIAG_OD,
                    DECODE(P.IND_HIPO_DIAG_OI,'1','X','&nbsp;')                 AS TXT_HIPO_DIAG_OI,

                    P.IND_POSTOPERATORIO_OI,
                    P.IND_POSTOPERATORIO_OD,

                    DECODE(P.IND_POSTOPERATORIO_OI,'1','X','&nbsp;')            AS TXT_POSTOPERATORIO_OI,
                    DECODE(P.IND_POSTOPERATORIO_OD,'1','X','&nbsp;')            AS TXT_POSTOPERATORIO_OD,
                    
                    
                    DECODE(P.IND_CIRUPROP_OD,'1','X','&nbsp;')                  AS TXT_CIRUPROP_OD,
                    DECODE(P.IND_CIRUPROP_OI,'1','X','&nbsp;')                  AS TXT_CIRUPROP_OI,
                    
                    P.IND_HIPO_DIAG_OD,
                    P.IND_HIPO_DIAG_OI,
                    
                    P.NUM_PIOOJODERECHO,
                    P.NUM_PIOOJOIZQUIER,
                    
                    P.IND_SEDACION,
                    DECODE(P.IND_SEDACION,'1','SI','0','NO','&nbsp;')           AS TXT_IND_SEDACION,
                    
                    P.IND_VITREO,
                    DECODE(P.IND_VITREO,'1','SI','0','NO','&nbsp;')             AS TXT_IND_VITREO,
                    
                    P.IND_SUTURA,
                    DECODE(P.IND_SUTURA,'1','SI','0','NO','&nbsp;')             AS TXT_SUTURA,
                    
                    P.IND_ANTIBIOTICO,
                    DECODE(P.IND_ANTIBIOTICO,'1','SI','0','NO','&nbsp;')        AS TXT_ANTIBIOTICO,
                    
                    P.IND_INSICION,
                    

                    P.IND_AZULDETRIPAN,
                    DECODE(P.IND_AZULDETRIPAN,'1','SI','0','NO','&nbsp;')       AS TXT_AZULDETRIPAN,
                     

                    P.IND_RHEXIS,
                    DECODE(P.IND_RHEXIS,'1','SI','0','NO','&nbsp;')             AS TXT_RHEXIS,
                    
                    P.IND_CDE_DECIMAL,
                    DECODE(P.IND_CDE_DECIMAL,'','NO INFORMADO',P.IND_CDE_DECIMAL)        AS CDE_DECIMAL,
                    
                    P.IND_FACOESMUL,
                    DECODE(P.IND_FACOESMUL,
                            '1','DIVIDE AND CONQUER',
                            '2','CHIP AND FLIP',
                            '3','FACOCHOP',
                            '4','STOP AND CHOP',
                            '5','OTRA',
                            '&nbsp;')                                           AS TXT_FACOESMUL,

                    P.IND_LENTEINTRAOCULAR,
                    DECODE(P.IND_LENTEINTRAOCULAR,
                            '1','SACO',
                            '2','SURCO',
                            '3','OTRO',
                            '&nbsp;')                                           AS TXT_LENTEINTRAOCULAR,

                            
                    P.IND_RPTERIGION,
                    DECODE(P.IND_RPTERIGION,'1','SI','0','NO','&nbsp;')         AS TXT_RPTERIGION,
                    
                    P.IND_DESCLERAL,
                    DECODE(P.IND_DESCLERAL,'1','SI','0','NO','&nbsp;')          AS TXT_DESCLERAL,
                     
                    P.IND_RCORNEAL,
                    DECODE(P.IND_RCORNEAL,'1','SI','0','NO','&nbsp;')           AS TXT_RCORNEAL,
                    
                    P.IND_ICONJUNTIVA,
                    DECODE(P.IND_ICONJUNTIVA,
                    '1','SUPERIOR',
                    '2','INFERIOR',
                    '3','ROTATORIO',
                    '4','OTRA',
                    '&nbsp;')                                                   AS TXT_DESCLERAL
                FROM 
                    PABELLON.PB_INFO_OFTAMOLOGIA P
                WHERE
                    P.ID_TABLA      = '$id'
            ";
        
            return $sQuery;
        }

        


        public function sqlbusquedaRutprofesional($RUTPRO){
            
             $sQuery =" 
                    SELECT 
                        G.NOM_NOMBRE||' '||G.NOM_APEPAT||' '||G.NOM_APEMAT AS TXTNOMBRE_PRO,
                        G.COD_RUTPRO, 
                        G.COD_DIGVER, 
                        G.COD_TPROFE, 
                        G.COD_USUARI, 
                        G.FEC_AUDITA, 
                        G.IND_ESTADO, 
                        G.COD_EMPRESA, 
                        G.EMAILMED, 
                        G.NUM_TELEFOMED, 
                        G.COD_TPROFENEW, 
                        G.COD_USRCREA, 
                        G.FEC_USRCREA, 
                        G.COD_ESPECIALIDAD
                    FROM 
                        $this->own.GG_TPROFESIONAL G
                    WHERE 
                        G.COD_RUTPRO = '$RUTPRO' AND 
                        G.IND_ESTADO = 'V'
                            
                        ";
            
            return $sQuery;
        }

        public function sql_buscaProfesional($empresa,$codRutpro){
            $sQuery ="  
                        SELECT 
                            P.NOM_NOMBRE||' '|| P.NOM_APEPAT ||' '|| P.NOM_APEMAT       AS NOMBREPROFESIONAL,
                            P.COD_DIGVER                                                AS COD_DIGVER 
                        FROM 
                            $this->own.GG_TPROFESIONAL          P
                        WHERE
                            P.COD_RUTPRO = '$codRutpro' AND P.COD_EMPRESA = '$empresa'
                        ";
            return $sQuery;
        }

    public function sqlBusquedaListaProtocoloQuirugicoOLD($admin,$desde,$hasta,$empresa,$session,$id){

        $where	    =	'';

        if ($id != ''){
            $where  .=	'  P.ID_PROTOCOLO ='.$id;
        } else {
	    if ($session != ''){
                $where.= " TO_DATE (P.FECHA_OPER, 'YYYY/MM/DD') BETWEEN TO_DATE ('$desde', 'DD/MM/YYYY') AND TO_DATE ('$hasta', 'DD/MM/YYYY') AND (P.SESION = '$session' OR COD_CIRUJANO = '$session' ) ";
            } 
        }
            
        $sQuery ="  
                SELECT 
                        P.ID_PROTOCOLO                                                      AS ID, 
                        P.CTA_CTE, 
                        P.RUT_PAC||'-'||P.DV                                                AS RUTPACIENTE, 
                        P.NOMBRE||' '||P.APELLIDO_PAT||' '||P.APELLIDO_MAT                  AS NOMBRE_COMPLETO, 
                        P.FICHA                                                             AS FICHAL, 
                        P.EDAD                                                              AS EDAD, 
                        'NO INFORMADO'                                                      AS SALA_DESCRIPCION,

                        P.PREVISION, 
                        P.COD_UNIDAD, 

                        P.REINTERVENCION, 
                        P.GES, 
                        P.TIPO_OP, 

                        P.OP_ANTERIOR, 
                        P.URGENCIA, 

                        P.COD_CIRUJANO,
                        P.COD_AYUDANTE, 
                        P.COD_CIRUJANO_2,
                        P.COD_CIRUJANO_3, 

                        P.COD_ANESTESISTA,

                        P.PABELLONERO, 
                        P.COD_ENFERMERA, 
                        P.COD_MATRONA,

                        P.COD_PEDIATRA, 
                        P.ARSENALERA,
                        P.COD_AUXANESTESIA,

                        P.ALUMNO, 
                        
                        DECODE(P.COD_TIPOANESTESIA,
                                                '0', 'NO',
                                                '9', 'ESPINAL',
                                                '1', 'NO ESPECIFICADO',
                                                '7', 'LOCAL',
                                                '8', 'GENERAL',
                                                '9', 'ESPINAL',
                                                '10','PERIDURAL',
                                                '11','SEDACION EV',
                                                '12','LOCAL ASISTIDA','NO INFORMADO')       AS COD_TIPOANESTESIA,

                        TO_DATE(P.FECHA_CREACION,  'YYYY/MM/DD')||' -'||P.HORA_INICIO       AS FECHAHORASOLICITUD, 
                        P.FECHA_OPER, 
                        P.HORA_LLEGADA,
                        P.HORA_TERMINO, 
                        UPPER(P.DIAG_PRE)                                                   AS TXTDIAGNOSTICO, 
                        UPPER(P.COD_DIAGPOST)                                               AS TXTDIAGNOSTICO_POST, 
                        P.DESCRIPCION_LESIONES, 
                        P.OPERACION, 
                        P.FECHA_CREACION, 
                        P.FECHA_INDICACION, 
                        P.USUARIO, 
                        P.ID_TABLA, 

                        P.COD_DIAGPOST_2, 

                        P.COD_PRESTACION, 
                        P.DES_INTERVENCION, 

                        P.COD_PRESTACION_2, 
                        P.DES_INTERVENCION2,

                        P.COD_PRESTACION_3, 
                        P.DES_INTERVENCION3,

                        P.PRESTACION_SC,

                        UPPER(P.RECUENTO_COMPRESAS)                                       AS RECUENTO_COMPRESAS, 
                        UPPER(P.DES_RECUENTO_COMPRESAS)                                   AS DES_RECUENTO_COMPRESAS,

                        P.SESION, 
                        P.ORIGEN                                                          AS NOM_ORIGEN, 
                        P.TIPO
                    FROM 
                        $admin.PB_PROTOCOLO P
                    WHERE

                        $where

                        ";
        return $sQuery;
    }
    
    public function sql_icxPorProtocolo($id){
	$sQuery ="   SELECT COUNT(*) NUM FROM $this->pabellon.PB_PROTOCOLOXIC where ID_TABLA=".$id." AND IND_ESTADO=1"; 
	return $sQuery;
    }
           
    public function sqlBusquedaListaProtocoloQuirugico($desde,$hasta,$empresa,$session,$estados){
            
            $where	    = '';
            if($session!=''){
                $where	    .=" AND ( (PR.COD_RUTPRO = '$session') OR (O.USR_CREA = '$session')  ";
                        $where.=" OR    
                                    (  
                                        (
                                            SELECT 
                                                P.RUT_PROFESIONAL
                                            FROM 
                                                PABELLON.PB_RRHH_QX	P
                                            WHERE   
							P.ID_TIPO_RRHH      IN  (2)
                                                AND	P.IND_ESTADO        =   1
                                                AND	P.ID_TABLA          =   O.ID_TABLA
                                                AND	P.RUT_PROFESIONAL   =   '$session'
                                        ) IS NOT NULL
                                    )        
                                ";
                $where.=" )";  
            }
            //*****************************************************************************************************
            
            if ($estados!=''){
                if (count($estados)>1){
                    $where.=" AND O.ID_ESTADO_TQ  = $estados ";
                } else {
                    $where.=" AND O.ID_ESTADO_TQ  IN ($estados)  ";
                } 
            }
            
            //REVISAR EL TO_CHAR EN ENTREMNEDIO
	    
            $sQuery ="
                    SELECT
                        DECODE(O.ID_TIPO_OP,'2','COMPRA DE SERVICIO','')                                                                            AS TXT_LICITACION_LE,
                        O.ID_TABLA                                                                                                                  AS ID,
                        O.NUM_FICHAE                                                                                                                AS FICHAE,
                        O.IND_SDERIVADA,
                        O.COD_EMPRESA_DERIVADA,
                        DECODE(O.ID_TIPO_OP,        
                                '1','INSTITUCIONAL',    
                                '2','COMPRA DE SERVICIO',          
                                '3','PLAN 3300',         
                                '4','PAD',
                                '5','PLAN ESPECIAL',
                                '6','NO APLICA',
                                'NO ESPECIFICADO')												    AS TXT_PROGRAMA_CIRUGIA,
				
                        CASE WHEN NUMTODSINTERVAL(SYSDATE-O.FEC_AUDITA,'day')>NUMTODSINTERVAL(24,'hour') THEN 0 ELSE 1 END                          AS POST_PROTOCOLO,
                        TO_CHAR(O.FEC_AUDITA+3/24,'DD-MM-YYYY hh24:mi')                                                                             AS FECHA_CIERRE,
                        
                        DECODE(O.ID_ORIGEN,        
                                '1', 'INSTITUCIONAL',    
                                '2', 'PRIVADA',          
                                '3', 'URGENCIA',         
                                '4', 'PROCEDIMIENTO',    
                                '5', 'PARTO',
                                     'NO ESPECIFICADO')                                                                                             AS NOM_ORIGEN,
                                     
                        DECODE(O.ID_ORIGEN,        
                                '1', 'INST',    
                                '2', 'PRV',          
                                '3', 'URG',         
                                '4', 'PROC',    
                                '5', 'PART',
                                     'NO ESPECIFICADO')                                                                                             AS NOM_ORIGENABRE,
                        
                        DECODE(O.ID_PROGRAMA_CIRUGIA,        
                                '1', 'MAYOR HOSPITALIZADO',    
                                '2', 'MENOR AMBULATORIO',          
                                '3', 'MENOR HOSPITALIZADO',         
                                '4', 'MAYOR AMBULATORIO',   
                                
                                '5', 'HOSPITALIZADO',   
                                '6', 'ATENCION ABIERTA',   
                                
                        'NO ESPECIFICADO')                                                                                                           AS NOM_PROCEDENCIA,
                        
                        DECODE(O.ID_PROGRAMA_CIRUGIA, 
                                '1', 'HOSP',    
                                '2', 'AMB',          
                                '3', 'HOSP',         
                                '4', 'AMB',  
                                '5', 'HOSP',   
                                '6', ''||' '||DECODE(O.IND_CMA,'1','CMA','2','NO CMA'),   
                                     '')                                                                                                            AS NOM_PROCEDENCIA_COR,
                        CASE 
                            WHEN 
                                M.IND_PROTOCOLO = 1 
                            THEN 
                                DECODE(M.NUM_PROTOCOLO,
                                '1','pabellon_classpdf/pdf2?id='||O.ID_TABLA,
                                '2','pabellon_classpdf/muestraPDF_PARTO?id='||O.ID_TABLA,
                                '3','pabellon_classpdf/muestra_OFTAMOLOGIA?id='||O.ID_TABLA,                                    
                                '#')
                            ELSE 
                                DECODE(M.ID_ESTADO_TQ,
                                '11','pabellon_classpdf/muestraPDF_SUSPENDIDAS?id='||O.ID_TABLA,
                                'pabellon_classpdf/muestraPDF3?id='||O.ID_TABLA)
                        END                                                                                                                         AS RUTA_PROTOCOLO,
                        
                        O.ID_PROGRAMA_CIRUGIA                                                                                                       AS ID_PROGRAMA_CIRUGIA,

                        M.IND_PROTOCOLO,

                        O.ID_ORIGEN                                                                                                                 AS ID_ORIGEN, 
                        O.ID_ESTADO_TQ                                                                                                              AS ID_ESTADO,
                        M.DES_CORTO                                                                                                                 AS TXT_ESTADO,
                        O.ID_ORIGEN_EGRESO                                                                                                          AS ID_ORIGEN_EGRESO, 
                        
                        L.COD_RUTPAC||'-'||L.COD_DIGVER                                                                                             AS RUTPACIENTE,
                        L.IND_TISEXO                                                                                                                AS IND_TISEXO,
                        
                        DECODE(O.ID_OPERADO,'1','OPERADO','0','NO OPERADO','NO ESPECIFICADO')                                                       AS TXT_OPERADO,
                        L.COD_RUTPAC                                                                                                                AS COD_RUTPAC,
                        TRUNC(MONTHS_BETWEEN(SYSDATE,L.FEC_NACIMI)/12)                                                                              AS NUMEDAD,
                        O.ID_TIPO_PACIENTE                                                                                                          AS TIPOSOLICITUD,
                        
                        CASE 
                            WHEN 
                                O.COD_TESTABL = 1000 
                            THEN 
                                (SELECT E.NUM_NFICHA FROM ADMIN.SO_TCPACTE E WHERE  E.NUM_FICHAE=O.NUM_FICHAE AND E.COD_EMPRESA=100) 
                            ELSE 
                                (SELECT E.NUM_NFICHA FROM ADMIN.SO_TCPACTE E WHERE  E.NUM_FICHAE=O.NUM_FICHAE AND E.COD_EMPRESA=O.COD_TESTABL) 
                        END                                                                                                                         AS FICHAL,

                        DECODE(O.ID_TIPO_PACIENTE,'1','PRIORIZADO','2','CONDICIONAL','NO ESPECIFICADO')                                             AS TIPO_PACIENTE,
                        (O.FEC_FIN_SOLICITUD-O.FEC_INICIO_SOLICITUD)*(60*24)                                                                        AS MINCIRUGIA,
                        UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)                                                     AS NOMBRE_COMPLETO,
                        
                        SUBSTR(L.NOM_NOMBRE,1,1)||'.'||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)                                                AS TXTNOMCIRUSMALL,
                        UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(SUBSTR(L.NOM_APEMAT,1,1))                                         AS TXTPRIMERNOMBREAPELLIDO,

                        (SELECT 
                            NOM_SERVIC  
                        FROM 
                            ADMIN.GG_TSERVICIOXEMP T, 
                            ADMIN.GG_TSERVICIO	S 
			WHERE
                            T.ID_SERDEP     =	O.COD_UNIDAD 
                        AND T.COD_EMPRESA   =	'$empresa' 
                        AND S.ID_SERDEP     =	T.ID_SERDEP)                                                                                        AS NOMBRE_SERVICIO,

                        TO_CHAR(O.FEC_INICIO_SOLICITUD,         'HH24')                                                                             AS INICIOHORA,
                        TO_CHAR(O.FEC_INICIO_SOLICITUD,         'HH24:mi')                                                                          AS INICIOHORAMIN,
                        
                        UPPER(O.TXT_HIPO_DIAG)                                                                                                      AS TXTDIAGNOSTICO,
                        UPPER(O.TXT_POSTOPERATORIO)                                                                                                 AS TXTDIAGNOPOST,
                        UPPER(O.TXT_CIRUPROP)                                                                                                       AS COD_CIRUPROP,
  
                        TO_CHAR(O.FEC_INICIO_SOLICITUD,         'DD-MM-YYYY hh24:mi')                                                               AS FECHAHORASOLICITUD,
                        TO_CHAR(O.FEC_FIN_SOLICITUD,            'DD-MM-YYYY hh24:mi')                                                               AS FECHAHORAFINAL,

                        TO_CHAR(O.DATE_INGRESO_PAB,             'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_PAB,                   
                        TO_CHAR(O.DATE_INGRESO_QUIROFANO,       'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_QUIROFANO, 
                        TO_CHAR(O.DATE_INICIO_ANESTESIA,        'DD-MM-YYYY hh24:mi')                                                               AS INICIO_ANESTESIA, 
                        TO_CHAR(O.DATE_FINAL_ANESTESIA,         'DD-MM-YYYY hh24:mi')                                                               AS FINAL_ANESTESIA, 
                        TO_CHAR(O.DATE_SALIDA_QUIROFANO,        'DD-MM-YYYY hh24:mi')                                                               AS SALIDA_QUIROFANO, 
                        TO_CHAR(O.DATE_FINAL_LIMPIEZA,          'DD-MM-YYYY hh24:mi')                                                               AS FINAL_LIMPIEZA, 
                        TO_CHAR(O.DATE_TERMINO_INTERVENCION,    'DD-MM-YYYY hh24:mi')                                                               AS TERMINO_INTERVENCION, 
                        TO_CHAR(O.DATE_INGRESO_RECUPERACION,    'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_RECUPERACION, 
                        TO_CHAR(O.DATE_SALIDA_RECUPERACION,     'DD-MM-YYYY hh24:mi')                                                               AS SALIDA_RECUPERACION,
                        
                        TO_CHAR(O.DATE_INGRESO_PAB,             'hh24:mi')                                                                          AS HRS_INGRESO_PAB,                   
                        TO_CHAR(O.DATE_INGRESO_QUIROFANO,       'hh24:mi')                                                                          AS HRS_INGRESO_QUIROFANO, 
                        TO_CHAR(O.DATE_INICIO_ANESTESIA,        'hh24:mi')                                                                          AS HRS_INICIO_ANESTESIA, 
                        TO_CHAR(O.DATE_FINAL_ANESTESIA,         'hh24:mi')                                                                          AS HRS_FINAL_ANESTESIA, 
                        TO_CHAR(O.DATE_SALIDA_QUIROFANO,        'hh24:mi')                                                                          AS HRS_SALIDA_QUIROFANO, 
                        TO_CHAR(O.DATE_FINAL_LIMPIEZA,          'hh24:mi')                                                                          AS HRS_FINAL_LIMPIEZA, 
                        TO_CHAR(O.DATE_TERMINO_INTERVENCION,    'hh24:mi')                                                                          AS HRS_TERMINO_INTERVENCION, 
                        TO_CHAR(O.DATE_INGRESO_RECUPERACION,    'hh24:mi')                                                                          AS HRS_INGRESO_RECUPERACION, 
                        TO_CHAR(O.DATE_SALIDA_RECUPERACION,     'hh24:mi')                                                                          AS HRS_SALIDA_RECUPERACION,
                        
                        O.DATE_INGRESO_PAB                                                                                                          AS MIN_INGRESO_PAB,                   
                        O.DATE_INGRESO_QUIROFANO                                                                                                    AS MIN_INGRESO_QUIROFANO, 
                        O.DATE_INICIO_ANESTESIA                                                                                                     AS MIN_INICIO_ANESTESIA, 
                        O.DATE_FINAL_ANESTESIA                                                                                                      AS MIN_FINAL_ANESTESIA, 
                        O.DATE_SALIDA_QUIROFANO                                                                                                     AS MIN_SALIDA_QUIROFANO, 
                        O.DATE_FINAL_LIMPIEZA                                                                                                       AS MIN_FINAL_LIMPIEZA, 
                        O.DATE_TERMINO_INTERVENCION                                                                                                 AS MIN_TERMINO_INTERVENCION, 
                        O.DATE_INGRESO_RECUPERACION                                                                                                 AS MIN_INGRESO_RECUPERACION, 
                        O.DATE_SALIDA_RECUPERACION                                                                                                  AS MIN_SALIDA_RECUPERACION,
                                                
                        TO_CHAR(O.FEC_INICIO_SOLICITUD, 'hh24:mi')                                                                                  AS HORASOLICITUD,
                        DECODE(P.NOM_CORTO,'','--',''||P.NOM_CORTO)                                                                                 AS SALA_DESCRIPCION,
                        DECODE(O.NUM_REFERENCIA,'','NO',''||O.NUM_REFERENCIA)                                                                       AS IND_REFERENCIA,
			
			O.ID_SIC														    AS ID_SIC,

                        O.NUM_ORDEN                                                                                                                 AS ORDEN,
                        O.COD_PABELLON                                                                                                              AS COD_PABELLON,
                        P.NOM_CORTO                                                                                                                 AS TXTPABELLON,
                        
                        SUBSTR(PR.NOM_NOMBRE,1,1)||'.'|| PR.NOM_APEPAT||' '|| PR.NOM_APEMAT                                                         AS TXTNOMCIRU,
                        PR.COD_TPROFE                                                                                                               AS COD_TPROFE,
			PR.COD_RUTPRO ||'.'||PR.COD_DIGVER                                                                                          AS RUN_PROFESIONAL,
                        O.IND_TXTSOME                                                                                                               AS TXT_SOME,
                        O.IND_PABELLON                                                                                                              AS TXT_PABELLON,
                        O.NUM_DURACION                                                                                                              AS TIEMPO,
                        
                        O.TXT_HRSENFE                                                                                                               AS TXT_INGRESOPAB,
                        
                        TO_CHAR(O.FEC_AUDITA,        'DD-MM-YYYY hh24:mi')                                                                          AS DATEULTIMAEDICION, 

                        DECODE(O.ID_PRD_SAN         ,'6','OTRO'
                                                    ,'5','CRIOPRECIPITADO'
                                                    ,'4','PLAQUETAS'
                                                    ,'3','PLASMA'
                                                    ,'2','GLOBULOS ROJOS'
                                                    ,'1','NO ESPECIFICADO'
                                                    ,'0','NO'
                                                    ,'NO ESPECIFICADO')                                                                             AS TXTHERMODERIVADO,
                                                    
                        DECODE(O.ID_RESER_PRD_SAN   ,'8','AB I(-)'
                                                    ,'7','B III(-)'
                                                    ,'6','O A II(-)'
                                                    ,'5','O IV(-)'
                                                    ,'4','AB I(+)'
                                                    ,'3','B III(+)'
                                                    ,'2','A II(+)'
                                                    ,'1','O IV(+)'
                                                    ,'0','NO ESPECIFICADO')                                                                         AS TXTSANGRE,
                                                    
                        DECODE(O.ID_TORRE_LAPA      ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTLAPAROSCOPIA,
                        DECODE(O.ID_POST_OPE        ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTOPERATORIO,
                        DECODE(O.ID_RAYOS           ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTRAYOS,
                        O.IND_MATERIALES                                                                                                            AS CHK_MATERIALES,
                        O.IND_RRHH                                                                                                                  AS CHK_RRHH,
                        O.IND_INSUMOS                                                                                                               AS CHK_INSUMOS,
                        O.ID_ASA                                                                                                                    AS ASA,
                        AN.NOM_ANESTESIA                                                                                                            AS TXTANESTESIA,
                        O.IND_PAD                                                                                                                   AS INDPAD,
                        PAT.ID_SOLICITUD_HISTO                                                                                                      AS ID_HISTO
                        
                    FROM 
                        $this->pabellon.PB_SALA_PABELLON                        P,
                        $this->pabellon.PB_TABLAOPERATORIA                      O,
                        $this->pabellon.PB_ESTADO_TQ                            M,
                        $this->pabellon.PB_RRHH_QX                              Q, 
                        $this->own.GG_TGPACTE                                   L,
                        $this->own.GG_TPROFESIONAL                              PR,
                        $this->pabellon.PB_TIPOANESTESIA                        AN,
                        $this->pabellon.PB_SOLICITUD_HISTO                      PAT
                    WHERE
                    
                        O.NUM_FICHAE            = L.NUM_FICHAE
                    AND
                        O.COD_PABELLON          = P.COD_PABELLON(+)
                    AND 
                        O.ID_ANESTESIA          = AN.ID_ANESTESIA(+)
                    AND    
                        O.ID_TABLA              = PAT.ID_TABLA(+)
                    AND    

                        O.ID_TABLA              = Q.ID_TABLA
                    AND 
                        Q.ID_TIPO_RRHH          = 1
                    AND 
                        Q.IND_ESTADO            = 1
                    AND  

                        PR.COD_RUTPRO           = Q.RUT_PROFESIONAL 
                    AND 
                        M.ID_ESTADO_TQ          = O.ID_ESTADO_TQ
                    AND 
                        O.COD_TESTABL           = '$empresa'
                    $where
                    AND 
                        O.FEC_INICIO_SOLICITUD BETWEEN TO_DATE('$desde 00:00:00','DD/MM/YYYY hh24:mi:ss') AND TO_DATE('$hasta 23:59:00','DD/MM/YYYY  hh24:mi:ss') 
                    ORDER BY 
                            
                            O.FEC_INICIO_SOLICITUD ASC,
                            COD_PABELLON,
                            ORDEN,
                            FECHAHORASOLICITUD
                        ";
            //TO_CHAR(O.FEC_INICIO_SOLICITUD,'HH24'),
            //A.DATE_AGENDAINICIO BETWEEN TO_DATE('$fechainicio 00:00', 'DD/MM/YYYY hh24:mi') AND TO_DATE('$fechafinal 23:59', 'DD/MM/YYYY  hh24:mi')
            //TO_CHAR(O.FEC_INICIO_SOLICITUD, 'DD-MM-YYYY') BETWEEN '$desde' AND '$hasta' 
            //(SELECT  DES_CORTO FROM PABELLON.PB_ESTADO_TQ E WHERE E.ID_ESTADO_TQ=O.ID_ESTADO_TQ) AS DES_ESTADO,
              return $sQuery;
        } 
        
        
















	//AGREGADO ****** 22.06.2018 
        public function sql_MAIX($empresa,$desde,$hasta,$mai,$protocolo,$parametro1){
            
            $where = '';
            if($protocolo=='1'){
                $where.=' AND M.IND_PROTOCOLO         = 1 ';
            }
            
            
            $sQuery ="  
                SELECT 
                    A.ID_TABLA                                                                              AS ID,
                    L.COD_RUTPAC||'-'||L.COD_DIGVER                                                         AS RUTPACIENTE,
                    SUBSTR(PR.NOM_NOMBRE,1,1)||'.'|| PR.NOM_APEPAT||' '|| PR.NOM_APEMAT                     AS TXTNOMCIRU,
                    PR.COD_TPROFE                                                                           AS COD_TPROFE,
                    PR.COD_RUTPRO||'-'||PR.COD_DIGVER                                                       AS RUTPROFESIONAL,
                    A.ID_ESTADO_TQ                                                                          AS ID_ESTADO,
                    M.DES_CORTO                                                                             AS TXT_ESTADO,
                        
                    (
                        SELECT 
                            NOM_SERVIC  
                        FROM 
                            ADMIN.GG_TSERVICIOXEMP T, 
                            ADMIN.GG_TSERVICIO S WHERE
                            T.ID_SERDEP     =  A.COD_UNIDAD 
                        AND T.COD_EMPRESA   = '$empresa' 
                        AND S.ID_SERDEP     = T.ID_SERDEP
                    )                                                                                       AS NOMBRE_SERVICIO,
                    
                    TO_CHAR(A.FEC_INICIO_SOLICITUD,'DD-MM-YYYY hh24:mi')                                    AS FECHAHORASOLICITUD,
                    
                    TO_CHAR(A.FEC_FIN_SOLICITUD,   'hh24:mi')                                               AS FECHAHORAFINAL,
                    UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)                 AS NOMBRE_COMPLETO,
                    L.COD_RUTPAC||'-'||L.COD_DIGVER                                                         AS RUTPACIENTE,
                    UPPER(A.TXT_HIPO_DIAG)                                                                  AS TXTDIAGNOSTICO,
                    TRUNC(MONTHS_BETWEEN(SYSDATE,L.FEC_NACIMI)/12)                                          AS NUMEDAD,
                    B.INT_CODIGO                                                                            AS CODIGO_MAI,
                    NVL(C.NOM_PRESTACION,D.NOM_CORTOS)                                                      AS NOMBRE_CODIGO_MAI,
                    B.DES_INTERVENCION,
                    A.FEC_INICIO_SOLICITUD,
                    A.FEC_FIN_SOLICITUD
                    
                FROM 
                    PABELLON.PB_TABLAOPERATORIA                                 A,
                    PABELLON.PB_CODIGOS_INTERVENCION                            B,
                    ADMIN.GG_TPRESTACION                                        C,
                    ADMIN.GG_TPRESTA                                            D,
                    PABELLON.PB_RRHH_QX                                         Q, 
                    ADMIN.GG_TGPACTE                                            L,
                    ADMIN.GG_TPROFESIONAL                                       PR,
                    PABELLON.PB_ESTADO_TQ                                       M
                WHERE     
                        A.ID_TABLA              = B.ID_TABLA
                    AND A.NUM_FICHAE            = L.NUM_FICHAE
                    AND Q.ID_TABLA              = A.ID_TABLA
                    AND Q.ID_TIPO_RRHH          = 1
                    AND Q.IND_ESTADO            = 1
                    AND PR.COD_RUTPRO           = Q.RUT_PROFESIONAL 
                    AND B.INT_CODIGO            = C.COD_PRESTACION(+)
                    AND B.INT_CODIGO            = D.COD_PRESTA(+)
                    AND B.COD_EMPRESA           = D.COD_EMPRESA(+)
                    AND A.COD_TESTABL           = '$empresa'
                    AND M.ID_ESTADO_TQ          = A.ID_ESTADO_TQ
                    $where
                    AND A.FEC_INICIO_SOLICITUD BETWEEN TO_DATE ('$desde 00:00','dd/mm/yyyy hh24:mi') AND TO_DATE('$hasta 23:59','dd/mm/yyyy hh24:mi')
                    AND B.INT_CODIGO IN('$mai')
                ORDER BY 
                    A.FEC_INICIO_SOLICITUD ASC
                           
                "; 
            return $sQuery;
        }
        //FIN AGREGADO 25.06.2018
        
        


        
        
        
        //MODIFICADO  25.06.2018 TAMBIEN -> 19-07-2018
        public function sqlBusquedaListaProtocoloQuirugicoxServicio($desde,$hasta,$empresa,$session,$estados,$serv,$SoloIc,$medico,$soloprotocolo){
            
                    $where = '';
            if($session!= ''){   
		    $where.=" AND (PR.COD_RUTPRO	= '$session' OR O.USR_CREA  = '$session') ";  
            }
            
            if ($estados!=''){
                if (count($estados)>1){
                    $where.=" AND O.ID_ESTADO_TQ        = $estados ";
                } else {
                    $where.=" AND O.ID_ESTADO_TQ	IN ($estados)  ";
                } 
            }
            
            if ($serv != ''){
                    $where.=" AND S.ID_SERDEP           = '$serv' ";
            }
            
            if ($SoloIc == 1){
                    $where.=" AND O.NUM_REFERENCIA IS NOT NULL ";
            }
            
            if ($medico != ''){
                    $where.=" AND Q.RUT_PROFESIONAL     = '$medico' ";
            }
            
            if ($soloprotocolo != ''){
                    $where.=" AND M.IND_PROTOCOLO       = 1 ";
            }
                                    
            //REVISAR EL TO_CHAR EN ENTREMNEDIO
            
            //MAX(O.FEC_INICIO_SOLICITUD),
            
            $sQuery ="
		    SELECT
                        O.ID_TABLA                                                                                                                  AS ID,
                        O.NUM_FICHAE                                                                                                                AS FICHAE,
                        
                        CASE WHEN NUMTODSINTERVAL(SYSDATE-O.FEC_AUDITA,'day')>NUMTODSINTERVAL(30,'hour')THEN 0 ELSE 1 END                           AS POST_PROTOCOLO,
                        TO_CHAR(O.FEC_AUDITA+3/24,'DD-MM-YYYY hh24:mi')                                                                             AS FECHA_CIERRE,
                        

                        DECODE(O.ID_ORIGEN,        
                                '1', 'INSTITUCIONAL',    
                                '2', 'PRIVADA',          
                                '3', 'URGENCIA',         
                                '4', 'PROCEDIMIENTO',    
                                '5', 'PARTO',
                                     'NO ESPECIFICADO')                                                                                             AS NOM_ORIGEN,
                                     
                        DECODE(O.ID_ORIGEN,        
                                '1', 'INST',    
                                '2', 'PRV',          
                                '3', 'URG',         
                                '4', 'PROC',    
                                '5', 'PART','NO ESPECIFICADO')                                                                                      AS NOM_ORIGENABRE,
                                
                        DECODE(O.ID_PROGRAMA_CIRUGIA,        
                                '1', 'MAYOR HOSPITALIZADO',    
                                '2', 'MENOR AMBULATORIO',          
                                '3', 'MENOR HOSPITALIZADO',         
                                '4', 'MAYOR AMBULATORIO',    
                                     '')                                                                                                           AS NOM_PROCEDENCIA,
                             
                        CASE 
                            WHEN 
                                M.IND_PROTOCOLO = 1 
                            THEN 
                                DECODE(M.NUM_PROTOCOLO,
                                '1','pabellon_classpdf/pdf2?id='||O.ID_TABLA,
                                '2','pabellon_classpdf/muestraPDF_PARTO?id='||O.ID_TABLA,
                                '3','pabellon_classpdf/muestra_OFTAMOLOGIA?id='||O.ID_TABLA,                                    
                                '#')
                            ELSE 
                                DECODE(M.ID_ESTADO_TQ,
                                '11','pabellon_classpdf/muestraPDF_SUSPENDIDAS?id='||O.ID_TABLA,
                                'pabellon_classpdf/muestraPDF3?id='||O.ID_TABLA)
                        END                                                                                                                         AS RUTA_PROTOCOLO,
                        M.IND_PROTOCOLO                                                                                                             AS IND_PROTOCOLO,
                        
                        O.ID_PROGRAMA_CIRUGIA                                                                                                       AS ID_PROGRAMA_CIRUGIA,
                        PR.COD_TPROFE                                                                                                               AS COD_TPROFE,
                        O.ID_ORIGEN                                                                                                                 AS ID_ORIGEN, 
                        L.IND_TISEXO                                                                                                                AS IND_TISEXO,
                        
                        L.COD_RUTPAC||'-'||L.COD_DIGVER                                                                                             AS RUTPACIENTE,
                        DECODE(O.ID_OPERADO,'1','OPERADO','0','NO OPERADO','NO ESPECIFICADO')                                                       AS TXT_OPERADO,
                        L.COD_RUTPAC                                                                                                                AS COD_RUTPAC,
                        TRUNC(MONTHS_BETWEEN(SYSDATE,L.FEC_NACIMI)/12)                                                                              AS NUMEDAD,
                        O.ID_TIPO_PACIENTE                                                                                                          AS TIPOSOLICITUD,
                        (SELECT E.NUM_NFICHA FROM ADMIN.SO_TCPACTE E WHERE  E.NUM_FICHAE=O.NUM_FICHAE  AND E.COD_EMPRESA=O.COD_TESTABL)             AS FICHAL,
                        DECODE(O.ID_TIPO_PACIENTE,'1','PRIORIZADO','2','CONDICIONAL','NO ESPECIFICADO')                                             AS TIPO_PACIENTE,
                        (O.FEC_FIN_SOLICITUD -O.FEC_INICIO_SOLICITUD)*(60*24)                                                                       AS MINCIRUGIA,
                        UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)                                                     AS NOMBRE_COMPLETO,
                        
                        SUBSTR(L.NOM_NOMBRE,1,1)||'.'||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)                                                AS TXTNOMCIRUSMALL,
                        
                        UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(SUBSTR(L.NOM_APEMAT,1,1))                                         AS TXTPRIMERNOMBREAPELLIDO,

                        S.NOM_SERVIC                                                                                                                AS NOMBRE_SERVICIO,
                        
                        TO_CHAR(O.FEC_INICIO_SOLICITUD,'HH24')                                                                                      AS INICIOHORA,
                        TO_CHAR(O.FEC_INICIO_SOLICITUD,'HH24:MM')                                                                                   AS INICIOHORAMIN,
                        
                        UPPER(O.TXT_HIPO_DIAG)                                                                                                      AS TXTDIAGNOSTICO,
                        UPPER(O.TXT_POSTOPERATORIO)                                                                                                 AS TXTDIAGNOPOST,
                        UPPER(O.TXT_CIRUPROP)                                                                                                       AS COD_CIRUPROP,

                        TO_CHAR(O.FEC_INICIO_SOLICITUD,     'DD-MM-YYYY hh24:mi')                                                                   AS FECHAHORASOLICITUD,
                        TO_CHAR(O.FEC_FIN_SOLICITUD,        'DD-MM-YYYY hh24:mi')                                                                   AS FECHAHORAFINAL,

                        TO_CHAR(DATE_INGRESO_PAB,           'DD-MM-YYYY hh24:mi')                                                                   AS INGRESO_PAB,                   
                        TO_CHAR(DATE_INGRESO_QUIROFANO,     'DD-MM-YYYY hh24:mi')                                                                   AS INGRESO_QUIROFANO, 
                        TO_CHAR(DATE_INICIO_ANESTESIA,      'DD-MM-YYYY hh24:mi')                                                                   AS INICIO_ANESTESIA, 
                        TO_CHAR(DATE_FINAL_ANESTESIA,       'DD-MM-YYYY hh24:mi')                                                                   AS FINAL_ANESTESIA, 
                        TO_CHAR(DATE_SALIDA_QUIROFANO,      'DD-MM-YYYY hh24:mi')                                                                   AS SALIDA_QUIROFANO, 
                        TO_CHAR(DATE_FINAL_LIMPIEZA,        'DD-MM-YYYY hh24:mi')                                                                   AS FINAL_LIMPIEZA, 
                        TO_CHAR(DATE_TERMINO_INTERVENCION,  'DD-MM-YYYY hh24:mi')                                                                   AS TERMINO_INTERVENCION, 
                        TO_CHAR(DATE_INGRESO_RECUPERACION,  'DD-MM-YYYY hh24:mi')                                                                   AS INGRESO_RECUPERACION, 
                        TO_CHAR(DATE_SALIDA_RECUPERACION,   'DD-MM-YYYY hh24:mi')                                                                   AS SALIDA_RECUPERACION,
                    
			P.NOM_CORTO                                                                                                                 AS TXTPABELLON,
			DECODE(P.NOM_CORTO,'','--',''||P.NOM_CORTO)                                                                                 AS SALA_DESCRIPCION,
			

                        TO_CHAR(O.FEC_INICIO_SOLICITUD, 'hh24:mi')                                                                                  AS HORASOLICITUD,
                        DECODE(O.NUM_REFERENCIA,'','NO',''||O.NUM_REFERENCIA)                                                                       AS IND_REFERENCIA,
                        O.ID_ESTADO_TQ                                                                                                              AS ID_ESTADO,
                        M.DES_CORTO                                                                                                                 AS TXT_ESTADO,
                        O.NUM_ORDEN                                                                                                                 AS ORDEN,
                        O.COD_PABELLON                                                                                                              AS COD_PABELLON,
                        
                        SUBSTR(PR.NOM_NOMBRE,1,1)||'.'|| PR.NOM_APEPAT||' '|| PR.NOM_APEMAT                                                         AS TXTNOMCIRU,
                        O.IND_TXTSOME                                                                                                               AS TXT_SOME,
                        O.IND_PABELLON                                                                                                              AS TXT_PABELLON,
                        O.NUM_DURACION                                                                                                              AS TIEMPO,
                        DECODE(O.ID_PRD_SAN         ,'6','OTRO'
                                                    ,'5','CRIOPRECIPITADO'
                                                    ,'4','PLAQUETAS'
                                                    ,'3','PLASMA'
                                                    ,'2','GLOBULOS ROJOS'
                                                    ,'1','NO ESPECIFICADO'
                                                    ,'0','NO'
                                                    ,'NO ESPECIFICADO')                                                                             AS TXTHERMODERIVADO,
                        DECODE(O.ID_RESER_PRD_SAN   ,'8','AB I(-)'
                                                    ,'7','B III(-)'
                                                    ,'6','O A II(-)'
                                                    ,'5','O IV(-)'
                                                    ,'4','AB I(+)'
                                                    ,'3','B III(+)'
                                                    ,'2','A II(+)'
                                                    ,'1','O IV(+)'
                                                    ,'0','NO ESPECIFICADO')                                                                         AS TXTSANGRE,
                        DECODE(O.ID_TORRE_LAPA      ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTLAPAROSCOPIA,
                        DECODE(O.ID_POST_OPE        ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTOPERATORIO,
                        DECODE(O.ID_RAYOS           ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTRAYOS,
                        O.IND_MATERIALES                                                                                                            AS CHK_MATERIALES,
                        O.IND_RRHH                                                                                                                  AS CHK_RRHH,
                        O.IND_INSUMOS                                                                                                               AS CHK_INSUMOS,
                        O.ID_ASA                                                                                                                    AS ASA,
                        AN.NOM_ANESTESIA                                                                                                            AS TXTANESTESIA,
                        O.IND_PAD                                                                                                                   AS INDPAD
                        
                    FROM 
                        $this->pabellon.PB_SALA_PABELLON                        P,
                        $this->pabellon.PB_TABLAOPERATORIA                      O,
                        $this->pabellon.PB_ESTADO_TQ                            M,
                        $this->pabellon.PB_RRHH_QX                              Q, 
                        $this->own.GG_TGPACTE                                   L,
                        $this->own.GG_TPROFESIONAL                              PR,
                        $this->pabellon.PB_TIPOANESTESIA                        AN,
                        $this->own.GG_TSERVICIOXEMP                             T, 
                        $this->own.GG_TSERVICIO                                 S
                        
                    WHERE
                    
                            O.NUM_FICHAE            = L.NUM_FICHAE
                        AND
                            O.COD_PABELLON          = P.COD_PABELLON(+)
                        AND 
                            O.ID_ANESTESIA          = AN.ID_ANESTESIA(+)
                        AND 
                            T.ID_SERDEP             =  O.COD_UNIDAD 
                        AND  
                            T.COD_EMPRESA           = O.COD_TESTABL
                        AND  
                            S.ID_SERDEP             = T.ID_SERDEP
                        AND    
                            O.ID_TABLA              = Q.ID_TABLA
                        AND 
                            Q.ID_TIPO_RRHH          = 1
                        AND 
                            Q.IND_ESTADO            = 1
                        AND  
                            PR.COD_RUTPRO           = Q.RUT_PROFESIONAL 
                        AND 
                            M.ID_ESTADO_TQ          = O.ID_ESTADO_TQ
                        AND 
                            O.COD_TESTABL           = '$empresa'
                        $where
                        AND 
                            O.FEC_INICIO_SOLICITUD BETWEEN TO_DATE('$desde 00:00', 'DD/MM/YYYY hh24:mi') AND TO_DATE('$hasta 23:59', 'DD/MM/YYYY  hh24:mi') 
                        ORDER BY 
                             O.FEC_INICIO_SOLICITUD ASC,
                            COD_PABELLON,
                            ORDEN,
                            FECHAHORASOLICITUD
                        ";
            
            /*
                select  from  s where 
                TO_CHAR(O.FEC_INICIO_SOLICITUD,'HH24'),
             */
            //A.DATE_AGENDAINICIO BETWEEN TO_DATE('$fechainicio 00:00', 'DD/MM/YYYY hh24:mi') AND TO_DATE('$fechafinal 23:59', 'DD/MM/YYYY  hh24:mi')
            //TO_CHAR(O.FEC_INICIO_SOLICITUD, 'DD-MM-YYYY') BETWEEN '$desde' AND '$hasta' 
            //(SELECT  DES_CORTO FROM PABELLON.PB_ESTADO_TQ E WHERE E.ID_ESTADO_TQ=O.ID_ESTADO_TQ) AS DES_ESTADO,
              return $sQuery;
        } 
        //FIN MODIFICADO



        
        
        
        public function sqlgetBusquedaPabellondeExtrasistema($desde,$hasta,$empresa,$session,$estados,$id_estapa){
            
            $where = '';
            if ($estados != ''){
                $where.=' AND O.ID_ESTADO_TQ  IN ('.$estados.') '; 
            }
            
            $sQuery =" SELECT
                            O.ID_TABLA                                                                          AS  ID,
                            UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)             AS  NOMBRE_COMPLETO,
                            TO_CHAR(O.FEC_INICIO_SOLICITUD, 'DD-MM-YYYY hh24:mi')                                   HORAINICIO2,
                             
                            TO_CHAR(O.FEC_INICIO_SOLICITUD, 'DD-MM-YYYY hh24:mi')                                   FECHAHORASOLICITUD,
                            

                            TO_CHAR(O.FEC_FIN_SOLICITUD,'DD-MM-YYYY hh24:mi')                                       FECHAHORAFINAL,
                            TO_CHAR(O.FEC_CREA,'DD-MM-YYYY hh24:mi')                                                FECHAHORACREA,
                            O.NUM_FICHAE                                                                        AS  FICHAE,
                            TO_CHAR(O.FEC_FIN_SOLICITUD,'HH24:MI')                                                  HORAINICIO,
                            TO_CHAR(O.FEC_CREA,  'HH24:MI')                                                         HORAFINAL,
                            (O.FEC_FIN_SOLICITUD-O.FEC_INICIO_SOLICITUD)*(60*24)                                    MINCIRUGIA,
                            TO_CHAR(O.FEC_INICIO_SOLICITUD,'HH24')                                                  INICIOHORA,
                            UPPER(O.TXT_HIPO_DIAG)                                                              AS  TXTDIAGNOSTICO,
                            TO_CHAR(O.FEC_INICIO_SOLICITUD,'hh24:mi')                                               HORASOLICITUD,
                            O.COD_PABELLON                                                                      AS  COD_PABELLON,
                            O.ID_ESTADO_TQ                                                                      AS  COD_ESTADO,
                            P.SALA_DESCRIPCION                                                                  AS  TXT_PABELLON,
                            M.DES_CORTO                                                                         AS  TXT_ESTADO,
                            
                            SUBSTR(PR.NOM_NOMBRE,1,1)||'.'|| PR.NOM_APEPAT||' '|| PR.NOM_APEMAT                 AS  TXTSOLICITA
                        FROM 
                            $this->pabellon.PB_TABLAOPERATORIA                  O,
                            $this->pabellon.PB_SALA_PABELLON                    P,
                            $this->pabellon.PB_ESTADO_TQ                        M,
                            $this->own.GG_TGPACTE                               L,
                            $this->own.GG_TPROFESIONAL                          PR    
                        WHERE 
                                O.NUM_FICHAE            = L.NUM_FICHAE(+)
                            AND
                                O.FEC_INICIO_SOLICITUD BETWEEN TO_DATE('$desde 00:00', 'DD/MM/YYYY hh24:mi') AND TO_DATE('$hasta 23:59', 'DD/MM/YYYY  hh24:mi')
                            AND
                                O.COD_PABELLON          = P.COD_PABELLON
                            AND
                                O.ID_ORIGEN             = $id_estapa
                            AND 
                                O.COD_TESTABL           = '$empresa'
                            AND 
                                O.COD_USUARIO_FIRMA     = PR.COD_RUTPRO(+)   
                            AND 
                                M.ID_ESTADO_TQ          = O.ID_ESTADO_TQ 
                            $where    
                        ORDER BY 
                            TO_CHAR(O.FEC_INICIO_SOLICITUD,'HH24') ,COD_PABELLON, FECHAHORASOLICITUD        
                      ";
            return $sQuery; 
        }
        
        public function cuenta_cod_intervencionMAI($cod_insumo,$id_tabla,$id_mai){
            $sm_sql = "SELECT INT_CODIGO FROM PABELLON.PB_CODIGOS_INTERVENCION"
                     . " WHERE  "
                     . " ID_TABLA        = '$id_tabla' "
                     . " AND INT_CODIGO  = '$cod_insumo'"
                     . " AND ID_MAI      = '$id_mai' ";
            return $sm_sql;     
        }
        
        public function sql_busquedacodificacionMai($id){
            $sQuery = "
                
                    SELECT
                        A.INT_CODIGO                            AS NUM_CODIGO,
                        B.NOM_PRESTACION			AS NOM_PRESTACION,
                        A.DES_INTERVENCION                      AS NOM_INTERVENCION,
                        A.ID_MAI                                AS COD_UNI,
                        A.ID_MDESCRIPCION                       AS ID_MDESCRIPCION,
                        A.CODIGO_INTERCONSULT                   AS INTERCONSULTA
                    FROM 
                        PABELLON.PB_CODIGOS_INTERVENCION	A,
                        ADMIN.GG_TPRESTACION			B 
                    WHERE
                    
                            A.ID_TABLA                          =   '$id' 
                        AND A.INT_CODIGO                        =   B.COD_PRESTACION(+)
                        AND A.ESTADO                            =   '1'
                                
                    ";
            return $sQuery;
        }  
        
	
        // add 12.09.2018
        public function get_busquedacodificacionMai_ayudante($id,$id_ayudante){
            $sQuery = " 
			SELECT
			    A.INT_CODIGO                            AS  NUM_CODIGO,
			    B.NOM_PRESTACION,
			    A.DES_INTERVENCION                      AS  NOM_INTERVENCION,
			    A.ID_MAI                                AS  COD_UNI,
			    A.CODIGO_INTERCONSULT                   AS  INTERCONSULTA
			FROM 
			    PABELLON.PB_CODIGOS_INTERVENCION        A,
			    ADMIN.GG_TPRESTACION                    B 
			WHERE

				A.ID_TABLA                          =   '$id' 
			    AND A.INT_CODIGO                        =   B.COD_PRESTACION(+)
			    AND A.ESTADO                            =   '1'
			    AND A.ID_MDESCRIPCION                   =   $id_ayudante
                    ";
            return $sQuery;
        }  
        // add 12.09.2018
        
        public function sqlbusquedapausasQx($id){
            $sQuery = " 
			SELECT 
			    NUM_PAUSA                                           AS NUM,
			    TO_CHAR(DATE_HORATOMADA,'DD-MM-YYYY hh24:mi')       AS HORATOMADA,
			    USR_CREA   
			FROM  
			    PABELLON.PB_TIEMPOS_PAUSAS_QX 
			WHERE 
			    ID_TABLA = '$id'
			ORDER 
			    BY NUM_PAUSA
                    ";
            return $sQuery;
        }

        public function sql_dataixPorProtocolo($id,$empresa){
	    $sQuery = "   
			SELECT
			    P.ID_PROXIC                                                 AS ID,
			    P.ID_SIC,
			    S.NUM_INTERCONSULTA                                         AS NUM,
			    S.DES_DIAGNO                                                AS TXT,
			    P.COD_OPCION                                                AS OPT,
			    DECODE(P.COD_OPCION   
				,'0','VUELVE PENDIENTE'
				,'1','RESUELTO'
				,'18','ELIMINADA - CAUSAL 18'
				,'12','ELIMINADA - CAUSAL 12'
				,'NO ESPECIFICADO')                                     AS EST
			FROM 
			    ADMIN.SO_TINTERCONSULTA                                     S, 
			    PABELLON.PB_PROTOCOLOXIC                                    P
			WHERE     
			    P.NUM_INTERCONSULTA     =	S.NUM_INTERCONSULTA
			AND P.COD_EMPRESA           =	S.COD_EMPRESA

			AND P.ID_TABLA              =	'$id'
			AND P.IND_ESTADO            =	1
		    ";
	    return $sQuery;
        }
	
	
        /*
	    AND P.COD_EMPRESA           = '$empresa'
            SELECT 
                S.NUM_INTERCONSULTA AS NUM,
                I.DES_HIPODIAG,
                S.DES_DIAGNO        AS TXT
            FROM 
                ADMIN.SO_TINTERCONSULTA     S, 
                PABELLON.PB_PROTOCOLOXIC    P,
                ADMIN.SO_TINTERCONSULTA      I
            WHERE   
             *   
                P.NUM_INTERCONSULTA     = S.NUM_INTERCONSULTA
            AND P.COD_EMPRESA           = S.COD_EMPRESA
            AND P.NUM_INTERCONSULTA     = I.NUM_INTERCONSULTA
            AND P.COD_EMPRESA           = I.COD_EMPRESA
            AND P.COD_EMPRESA           = '100'
            AND P.ID_TABLA              = '2350'
        */
        
        public function sqldatosParto($id){
            
          $sQuery = "   
                SELECT 
                    P.ID_PARTO                                                      AS ID_PARTO, 
                    P.HRS_PARTO                                                     AS HORA,
                    P.NUM_GESTACIONSEMA,
                    P.NUM_GESTACIONDIAS,
                    P.NUM_GESTACIONSEMA ||' DIAS '||P.NUM_GESTACIONDIAS||' SEMANAS' AS GESTACIONAL,
                    DECODE(P.IND_PARTOACOMPANA,
                                                '1','NO',
                                                '2','PAREJA',
                                                '3','FAMILIAR',
                                                '4','OTRO')                         AS P_ACOMPANADO,
                    P.NUM_APGAR_1 ||' - '|| P.NUM_APGAR_2                           AS NUM_APGAR, 
                    P.IND_PARTOACOMPANA,
                    P.NUM_APGAR_1,
                    P.NUM_APGAR_2,
                    P.NUM_APEGO                                                     AS APEGO,
                    P.IND_TRABAJOPARTO,
                    DECODE(P.IND_TRABAJOPARTO,'1','SI','0','NO','NO ESPECIFICADO')  AS CIRCULAR, 
                    P.IND_SEXO,
                    DECODE(P.IND_SEXO,'F','FEMENINO','M','MASCULINO')               AS TXT_SEXO,                         
                    
                    
                    P.NUM_PESO                                                      AS PESO,  
                    P.NUM_TALLA                                                     AS TALLA, 
                    P.NUM_CC                                                        AS CC, 
                    P.IND_LA                                                        AS LA, 
                    DECODE(P.IND_EPISIOTOMIA,'1','SI','0','NO','NO ESPECIFICADO')   AS EPISIOTOMIA,
                    P.IND_EPISIOTOMIA,
                    P.IND_DESGARROS,
                    DECODE(P.IND_DESGARROS,'1','SI','0','NO','NO ESPECIFICADO')     AS DESGARROS,
		    
		    DECODE(P.IND_USOFORSEP,'1','SI','0','NO','NO ESPECIFICADO')     AS TXT_USO_FORSEP
		    
                FROM 
                    PABELLON.PB_INFOPARTO P
                WHERE 
                    P.ID_TABLA = '$id' AND P.IND_ESTADO = 1

            ";
          
            return $sQuery;
        }

        public function sqlbusqueda_espera_referencia($empresa,$especialidad,$rut,$ficha_local,$num_interconsulta,$parametros,$tipo_busqueda,$buscacodref="0"){
            //ADD EMPRESA 
            if($empresa=='1000'){$empresa='100,106,029';}
        
            
            //SI VIENE CON VALOR 0 NO ESTA DEFINIDA EN LA BUSQUEDA
            $sql_where                      ='';
                    
            if ($especialidad       !=0)    {  $sql_where.=" g.espec             = in ('$especialidad')     AND ";  }
            if ($rut                !=0)    {  $sql_where.=" b.cod_rutpac        = '$rut'                   AND ";  }
            if ($ficha_local        !=0)    {  $sql_where.=" c.num_nficha        = '$ficha_local'           AND ";  }
            if ($num_interconsulta  !=0)    {  $sql_where.=" a.num_interconsulta = '$num_interconsulta'     AND ";  }
            if ($tipo_busqueda      !=0)    {  $sql_where.=" A.IND_ESTADO        in ('P','S')               AND ";  } else {  $sql_where.=" a.ind_estado in ('P','S','R')   and ";  } 
            if ($parametros         =='1')  {  $sql_where.=" A.IND_GESTION       in ('1')                   AND ";  } 
	    
	    $txt_codempresa	    =	    'A.COD_ESTABLREF';
	     if ($buscacodref         =='1'){  
		$txt_codempresa	    =	    'A.COD_ESTABLREF';
		//$sql_where.="    A.COD_ESTABLREF       in ($empresa)               AND ";  
	    } 
	   
            $sQuery = " 
                        SELECT  
			    A.ID_SIC                                                    AS ID_SIC,
                            A.NUM_INTERCONSULTA                                         AS CAMPO1,
                            A.COD_RUTPAC                                                AS CAMPO2,
                            A.COD_DIGVER                                                AS CAMPO3, 
			    TRUNC(SYSDATE-A.FEC_RECEP)                                  AS DIASESPERA,
			    A.DES_DIAGNO                                                AS CAMPO6,
			    A.IND_AUGE                                                  AS CAMPO8,
                            DECODE(A.IND_AUGE,'1','SI','0','NO','NO ESPECIFICADO')      AS NUMAUGE,
                            A.COD_CIE10                                                 AS CAMPO9,
			    A.COD_ESTABL                                                AS CAMPO11, 
                            A.COD_EMPRESA                                               AS CAMPO12,
			    A.DES_ESPMOT                                                AS CAMPO14, 
			    A.NUM_FICHAE                                                AS CAMPO22, 
			    A.FEC_USRCREA                                               AS FECHACREACIONIC,
                            A.COD_ESPECI                                                AS CAMPO25, 
                            A.IND_GESTION                                               AS GESTION,
                            A.IND_ASA                                                   AS ASA,
                            A.FEC_ACTEXAM                                               AS FEC_ULTIMOEXA,
			    TRUNC(SYSDATE-A.FEC_ACTEXAM)                                AS DIA_ULTIMOEXA,
                            A.IND_GESTION                                               AS GESTION,
                            A.IND_GESTION_PAB                                           AS GESTION_PAB,
                            A.IND_NECEXAMENES                                           AS NECESITAEXAMENES,
			    
			    (SELECT 
                                COUNT(*) 
                            FROM 
                                ADMIN.SO_TINTERCITAELIM U   
                            WHERE 
                                A.NUM_INTERCONSULTA =	U.NUM_INTERCONSULTA   
                                AND 
                                A.COD_EMPRESA       =	U.COD_EMPRESA 
                                AND 
                                U.COD_ELIMINACITA   =	'0108')                          AS CUENTA_NSP,
                                
                            (SELECT 
                                    COD_PRESTACION 
                                FROM  
                                    ADMIN.SO_TMOTICIQ M  
                                WHERE 
                                    A.COD_ESPECI    =	M.COD_MOTIVO)                    AS CODIGOIQ,
                                    
                            (SELECT 
                                    NOM_MOTIVO 
                                FROM 
                                    ADMIN.SO_TMOTICIQ M 
                                WHERE 
                                    A.COD_ESPECI    =	M.COD_MOTIVO)                   AS MOTIVOIQ,
				    
				    
			    B.COD_RUTREF                                                AS CAMPO16, 
                            B.COD_DIGREF                                                AS CAMPO17, 
                            B.NOM_NOMBRE || ' ' || B.NOM_APEPAT || ' ' || B.NOM_APEMAT  AS CAMPO18,
			    B.IND_TISEXO                                                AS CAMPO4,
			    TRUNC(MONTHS_BETWEEN(SYSDATE,B.FEC_NACIMI)/12)              AS CAMPO5,
                            B.NUM_FICHAE                                                AS CAMPO19, 
                            B.NUM_TELEFO1                                               AS CAMPO20,
                            B.NUM_CELULAR                                               AS CAMPO21, 
                            B.NOM_DIRECC || ' ' || B.NUM_CASA                           AS CAMPO23, 
			    C.NUM_NFICHA                                                AS CAMPO10,
			    
			    J.NOM_GRUPO                                                 AS NOM_ESPECIALIDAD,
			    J.COD_GRUPO							AS COD_GRUPO,
			    
			    F.NOM_ESTABL                                                AS ESTABLOR,
                            F.COD_ESTABL                                                AS CODORIGEN,
                            E.NOM_ESTABL                                                AS ESTABREF,
                            
			    G.NOMBRE                                                    AS POLICLINICO,
			    G.NOMBRE                                                    AS TIPOINTERVENCION,
			    
                            H.NOMBRE                                                    AS CAMPO15, 
			    I.NOM_COMUNA                                                AS CAMPO24
                            
                            FROM
			    
                                ADMIN.SO_TINTERCONSULTA     A, 
                                ADMIN.GG_TGPACTE            B, 
                                ADMIN.SO_TCPACTE            C, 
                                ADMIN.GG_TPROFESIONAL       D, 
                                ADMIN.GG_TESTABL            E, 
                                ADMIN.GG_TESTABL            F, 
                                ADMIN.POLI_SERV_PROC_EXA    G, 
                                ADMIN.BUSCA_MOTIVO          H, 
                                ADMIN.GG_TCOMUNA            I,
                                ADMIN.GG_TGRUESP            J
				
                            WHERE
				J.cod_grupo         =  g.espec                  AND
                                $txt_codempresa     IN ($empresa)               AND
                                B.IND_ESTADO        <> 'E'                      AND 
                                F.IND_ESTADO        <> 'E'                      AND 
                                A.COD_MOTIVO        =  '4'                      AND
                                $sql_where
                                B.IND_ESTADO        =  'V'			AND 
                                C.IND_ESTADO        =  'V'			AND 
                                A.NUM_FICHAE        =  B.NUM_FICHAE		AND 
                                A.NUM_FICHAE        =  C.NUM_FICHAE		AND 
                                $txt_codempresa     =  C.COD_EMPRESA		AND 
                                A.COD_RUTPRO        =  D.COD_RUTPRO		AND 
                                A.COD_ESTABL        =  F.COD_ESTABL		AND 
                                A.COD_ESTABLREF     =  E.COD_ESTABL		AND
                                A.COD_ESPECI        =  G.CODIGO			AND
                                A.COD_MOTIVO        =  H.CODIGO			AND 
                                B.COD_COMUNA        =  I.COD_COMUNA(+)

                        ORDER 
                            by DIASESPERA DESC
                        ";
            
            //print_r($sQuery);
            
          return $sQuery;
        }
         
         
        public function sqlBusquedaInterconsultaReferencia($empresa,$especialidad,$rut,$ficha_local,$num_interconsulta,$parametros,$tipo_busqueda){
                $sql_where    = '';
                if ($especialidad!='')  {  $sql_where.=" g.espec             = '$especialidad'        and ";  }
                
                //Si pasa un array busca variros Estados
                if ($tipo_busqueda!=''){
                    if (is_array($tipo_busqueda)){
                        
                    } else {
                        $sql_where.="A.ind_estado            = 'L' AND ";
                    }
                }
              
               $sQuery = " 
                        SELECT 
                            j.COD_GRUPO                                         AS cod_especialidad,
                            j.nom_grupo                                         AS nom_especialidad,
                            a.num_interconsulta                                 AS CAMPO1,
                            a.cod_rutpac                                        AS CAMPO2,
                            a.cod_digver                                        AS CAMPO3, 
                            b.ind_tisexo                                        AS CAMPO4,
                            trunc(months_between(sysdate,b.fec_nacimi)/12)      AS CAMPO5,
                            a.des_diagno                                        AS CAMPO6,
                            f.nom_establ                                        AS ESTABLOR,
                            f.cod_establ                                        AS CODORIGEN,
                            trunc(sysdate-a.fec_recep)                          AS DIASESPERA,
                            e.nom_establ                                        AS ESTABREF,
                            a.ind_auge                                          AS CAMPO8, 
                            a.cod_cie10                                         AS CAMPO9,
                            c.num_nficha                                        AS CAMPO10,
                            a.cod_establ                                        AS CAMPO11, 
                            a.cod_empresa                                       AS CAMPO12, 
                            g.nombre                                            AS POLICLINICO, 
                            a.des_espmot                                        AS CAMPO14, 
                            h.nombre                                            AS CAMPO15, 
                            b.cod_rutref                                        AS CAMPO16, 
                            b.cod_digref                                        AS CAMPO17, 
                            b.nom_nombre || ' ' || b.nom_apepat || ' ' || b.nom_apemat AS CAMPO18,
                            b.num_fichae                                        AS CAMPO19, 
                            b.num_telefo1                                       AS CAMPO20,
                            b.num_celular                                       AS CAMPO21, 
                            a.num_fichae                                        AS CAMPO22, 
                            b.nom_direcc ||' ' || b.num_casa                    AS CAMPO23, 
                            i.nom_comuna                                        AS CAMPO24,
                            a.cod_especi                                        AS CAMPO25, 
                            (select   count(*)   from   admin.so_tintercitaelim u   where 
                                    a.num_interconsulta = u.num_interconsulta and 
                                    a.cod_empresa = u.cod_empresa and u.cod_eliminacita='0108') 
                                                                                AS CUENTA_NSP,
                            g.nombre     AS TIPOINTERVENCION,

                            (select COD_PRESTACION  from   admin.SO_TMOTICIQ m  where  a.cod_especi = m.cod_motivo) AS CODIGOIQ,

                            (select NOM_MOTIVO  from   admin.SO_TMOTICIQ m   where  a.cod_especi = m.cod_motivo) AS MOTIVOIQ
                        
                    FROM
                        admin.so_tinterconsulta a, 
                        admin.gg_tgpacte b, 
                        admin.so_tcpacte c, 
                        admin.gg_tprofesional d, 
                        admin.gg_testabl e, 
                        admin.gg_testabl f, 
                        admin.poli_serv_proc_exa g, 
                        admin.busca_motivo h, 
                        admin.gg_tcomuna i,
                        ADMIN.GG_TGRUESP J
                    WHERE
                        J.cod_grupo             = g.espec AND
                        a.cod_establref         = '$empresa' and
                        b.ind_estado            <> 'E' and 
                        f.ind_estado            <> 'E' and 
                        a.cod_motivo            = '4'  and
                        $sql_where
                        b.ind_estado            = 'V' and 
                        c.ind_estado            = 'V' and 
                        a.num_fichae            = b.num_fichae and 
                        a.num_fichae            = c.num_fichae and 
                        a.cod_empresa           = c.cod_empresa and 
                        a.cod_rutpro            = d.cod_rutpro and 
                        a.cod_establ            = f.cod_establ and 
                        a.cod_establref         = e.cod_establ and
                        a.cod_especi            = g.codigo and 
                        a.cod_motivo            = h.codigo and 
                        b.cod_comuna            = i.cod_comuna(+)";
              
               return $sQuery;
        }
       
        public function sql_busquedaEnfemerosPabellon($empresa){
            $sQuery = "
                    SELECT 
                        E.ID_PROFESIONAL_PB                                       AS IDRRHHPROFESIONAL,
                        P.NOM_APEPAT||' '||P.NOM_APEMAT||' '||P.NOM_NOMBRE        AS NOM_PROFESIONAL, 
                        P.COD_RUTPRO                                              AS RUT, 
			P.COD_DIGVER                                              AS DV,
                        P.COD_TPROFE                                              AS COD 
                    FROM 
			ADMIN.GG_TPROFESIONAL       P,
                        PABELLON.PB_PROFESIONALES   E
		    WHERE 
			    E.COD_TESTABL	    = '$empresa' 
                        AND E.IND_ESTADO            = 'V'        
                        AND P.COD_TPROFE	    IN('ENFE','MATR','TMED')
                        AND E.COD_RUTPAC	    = P.COD_RUTPRO
                    ORDER 
                        BY P.NOM_APEPAT
                      ";
            return $sQuery;
        }
        
        public function sqlcarga_equipo_medico_pb($empresa){
            $Sql = "
                    SELECT 
                        M.ID_TMEDICO                                                AS IDRRHMEDICO,
                        GG.NOM_NOMBRE||' '|| GG.NOM_APEPAT ||' '|| GG.NOM_APEMAT    AS PROFESIONAL,
                        GG.NOM_APEPAT||' '|| GG.NOM_APEMAT ||' '|| GG.NOM_NOMBRE    AS PROFESIONAL_2,
                        GG.COD_RUTPRO                                               AS ID,
                        GG.COD_DIGVER                                               AS DV,
                        GG.COD_TPROFE                                               AS MEDI,
                        PR.NOM_TPROFE                                               AS TXTPROFESION,
                        PR.DESC_PROFESION                                           AS TXTDESPROFE
                    FROM 
                        $this->own.GG_TPROFESIONAL      GG,
                        $this->pabellon.PB_TMEDICOS     M,
                        $this->own.GG_TPROFESION        PR
                    WHERE

                            GG.IND_ESTADO               = 'V'
                        AND M.COD_RUTPRO                = GG.COD_RUTPRO
                        AND M.IND_ESTADO                = '1'
                        AND PR.COD_TPROFE               = GG.COD_TPROFE
                        AND M.COD_EMPRESA               = '$empresa' 
                    ORDER 
                        BY GG.NOM_APEPAT";
            return $Sql;
        }

        public function sql_busquedaTensPabellon($empresa){
            $sQuery = " 
                        SELECT 
                                T.ID_TNS                                                    AS IDRRHHTNS,
                                P.NOM_NOMBRE||' '|| P.NOM_APEPAT ||' '|| P.NOM_APEMAT       AS NOM_TNS,
                                P.NOM_APEPAT, 
                                P.NOM_APEMAT, 
                                P.NOM_NOMBRE, 
                                P.COD_RUTPRO, 
                                P.COD_TPROFE,
                                PR.NOM_TPROFE                                               AS TXTPROFESION,
                                PR.DESC_PROFESION                                           AS TXTDESPROFE
                                    
                        FROM 
                                $this->own.GG_TPROFESIONAL          P,
                                $this->pabellon.PB_TNS              T,
                                $this->own.GG_TPROFESION            PR
                        WHERE
                                    (P.COD_TPROFE='TPAR' OR P.COD_TPROFE='AUXI') 
                                AND 
                                    T.COD_TESTABL           =   '".$empresa."' 
                                AND 
                                    T.COD_RUTPAC            =   P.COD_RUTPRO
                                AND
                                    T.IND_ESTADO            =   'V'
                                AND 
                                    PR.COD_TPROFE           =   P.COD_TPROFE
                                ";
            return $sQuery;  
        }
        
        public function busquedaLastNumfichae(){  
            #$sql= "SELECT NUM_CORREL FROM ADMIN.GG_TCORREL WHERE id_correl = 'NUM_FICHAE' FOR UPDATE ";
            $sql = "SELECT MAX(NUM_FICHAE) AS NUM_CORREL FROM ADMIN.GG_TGPACTE";
            return $sql;
        }
                            
        public function UpdateLastNumfichae($num_fichae){
                $sql2= "UPDATE ADMIN.GG_TCORREL set num_correl= $num_fichae  where id_correl= 'NUM_FICHAE'";//se debe actualizar parametro
                return $sql2;
        }
        
        public function sqlbusquedadecuposporagenda($fechainicio,$fechafinal,$empresa){
             $sql ="
                SELECT  
                        TO_CHAR(A.FEC_INICIO_SOLICITUD,'DD-MM-YYYY')                                       AS FECHA,
                        COUNT(*)                                                                           AS NUM_ACTIVIDAS
                FROM 
                        PABELLON.PB_TABLAOPERATORIA A
                WHERE 
                        A.FEC_INICIO_SOLICITUD BETWEEN TO_DATE('$fechainicio 00:00','DD/MM/YYYY hh24:mi') AND TO_DATE('$fechafinal 23:59','DD/MM/YYYY  hh24:mi')
                        AND A.ID_ESTADO_TQ          = '24'
                        AND COD_TESTABL             = '$empresa'
                GROUP BY 
                       TO_CHAR (A.FEC_INICIO_SOLICITUD, 'DD-MM-YYYY')
                HAVING 
                        COUNT (*) > 0
                ";
            return $sql; 
        }
        
        public function getBusquedaListaxRut($rutPac , $empresa, $rutPro , $estados){
            
            $where = '';
            if ($estados!=''){
                $where .=" AND O.ID_ESTADO_TQ  IN ($estados)  ";
            }
            if ($rutPac!=''){
                $where .=" AND L.COD_RUTPAC = '$rutPac' ";
            }
            if ($rutPro!=''){
                 $where .=" AND PR.COD_TPROFE = '$rutPro' ";
            }
            if ($empresa=='100'){
                $where .="  AND  O.COD_TESTABL           IN (100,1000) ";
            }  else {
                $where .="  AND  O.COD_TESTABL           IN ($empresa) ";
            } 
            
            $sQuery ="  
                    SELECT
                        O.ID_TABLA                                                                                                                  AS ID,
                        M.NUM_PROTOCOLO                                                                                                             AS NUM_PROTOCOLO,
                        CASE 
                            WHEN 
                                M.IND_PROTOCOLO = 1 
                            THEN 
                                DECODE(M.NUM_PROTOCOLO,
                                '1','pabellon_classpdf/pdf2?id='||O.ID_TABLA||'&estab='||O.COD_TESTABL,
                                '2','pabellon_classpdf/muestraPDF_PARTO?id='||O.ID_TABLA||'&estab='||O.COD_TESTABL,
                                '3','pabellon_classpdf/muestra_OFTAMOLOGIA?id='||O.ID_TABLA||'&estab='||O.COD_TESTABL,                                    
                                '#')
                            ELSE 
                                DECODE(M.ID_ESTADO_TQ,
                                '11','pabellon_classpdf/muestraPDF_SUSPENDIDAS?id='||O.ID_TABLA,'pabellon_classpdf/muestraPDF3?id='||O.ID_TABLA)
                        END                                                                                                                         AS RUTA_PROTOCOLO,
                        O.NUM_FICHAE                                                                                                                AS FICHAE,
                        DECODE(O.ID_ORIGEN,        
                                '1', 'INSTITUCIONAL',    
                                '2', 'PRIVADA',          
                                '3', 'URGENCIA',         
                                '4', 'PROCEDIMIENTO',    
                                '5', 'PARTO',
                                     'NO ESPECIFICADO')                                                                                             AS NOM_ORIGEN,
                        DECODE(O.ID_ORIGEN,        
                                '1', 'INST',    
                                '2', 'PRV',          
                                '3', 'URG',         
                                '4', 'PROC',    
                                '5', 'PART',
                                     'NO ESPECIFICADO')                                                                                             AS NOM_ORIGENABRE,
                        DECODE(O.ID_PROGRAMA_CIRUGIA,        
                                '1', 'MAYOR HOSPITALIZADO',    
                                '2', 'MENOR AMBULATORIO',          
                                '3', 'MENOR HOSPITALIZADO',         
                                '4', 'MAYOR AMBULATORIO',    
                                     '')                                                                                                           AS NOM_PROCEDENCIA,
                        DECODE(O.ID_PROGRAMA_CIRUGIA, 
                                '1', 'HOSP',    
                                '2', 'AMB',          
                                '3', 'HOSP',         
                                '4', 'AMB',    
                                     '')                                                                                                            AS NOM_PROCEDENCIA_COR,
                        
                        O.ID_PROGRAMA_CIRUGIA                                                                                                       AS ID_PROGRAMA_CIRUGIA,
                        O.ID_ORIGEN                                                                                                                 AS ID_ORIGEN, 
                        O.ID_ESTADO_TQ                                                                                                              AS ID_ESTADO,
                        M.DES_CORTO                                                                                                                 AS TXT_ESTADO,
                        M.ID_ESTADO_TQ                                                                                                              AS ID_ESTADO_TQ,
                        O.ID_ORIGEN_EGRESO                                                                                                          AS ID_ORIGEN_EGRESO, 
                        L.COD_RUTPAC||'-'||L.COD_DIGVER                                                                                             AS RUTPACIENTE,
                        L.IND_TISEXO                                                                                                                AS IND_TISEXO,
                        DECODE(O.ID_OPERADO,'1','OPERADO','0','NO OPERADO','NO ESPECIFICADO')                                                       AS TXT_OPERADO,
                        L.COD_RUTPAC                                                                                                                AS COD_RUTPAC,
                        TRUNC(MONTHS_BETWEEN(SYSDATE,L.FEC_NACIMI)/12)                                                                              AS NUMEDAD,
                        O.ID_TIPO_PACIENTE                                                                                                          AS TIPOSOLICITUD,
                        (SELECT E.NUM_NFICHA FROM ADMIN.SO_TCPACTE E WHERE  E.NUM_FICHAE=O.NUM_FICHAE  AND E.COD_EMPRESA=O.COD_TESTABL)             AS FICHAL,
                        DECODE(O.ID_TIPO_PACIENTE,'1','PRIORIZADO','2','CONDICIONAL','NO ESPECIFICADO')                                             AS TIPO_PACIENTE,
                        (O.FEC_FIN_SOLICITUD-O.FEC_INICIO_SOLICITUD)*(60*24)                                                                        AS MINCIRUGIA,
                        UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)                                                     AS NOMBRE_COMPLETO,
                        
                        SUBSTR(L.NOM_NOMBRE,1,1)||'.'||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)                                                AS TXTNOMCIRUSMALL,
                        UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(SUBSTR(L.NOM_APEMAT,1,1))                                         AS TXTPRIMERNOMBREAPELLIDO,

                        (SELECT 
                            NOM_SERVIC  
                        FROM ADMIN.GG_TSERVICIOXEMP T, 
                             ADMIN. GG_TSERVICIO  S WHERE
                            T.ID_SERDEP     =  O.COD_UNIDAD 
                        AND T.COD_EMPRESA   = '$empresa' 
                        AND S.ID_SERDEP     = T.ID_SERDEP)                                                                                          AS NOMBRE_SERVICIO,

                        TO_CHAR(O.FEC_INICIO_SOLICITUD,'HH24')                                                                                      AS INICIOHORA,
                        TO_CHAR(O.FEC_INICIO_SOLICITUD,'HH24:mi')                                                                                   AS INICIOHORAMIN,
                        
                        UPPER(O.TXT_HIPO_DIAG)                                                                                                      AS TXTDIAGNOSTICO,
                        UPPER(O.TXT_POSTOPERATORIO)                                                                                                 AS TXTDIAGNOPOST,
                        
                        UPPER(O.TXT_CIRUPROP)                                                                                                       AS COD_CIRUPROP,
  
                        TO_CHAR(O.FEC_INICIO_SOLICITUD,         'DD-MM-YYYY hh24:mi')                                                               AS FECHAHORASOLICITUD,
                        TO_CHAR(O.FEC_FIN_SOLICITUD,            'DD-MM-YYYY hh24:mi')                                                               AS FECHAHORAFINAL,

                        TO_CHAR(O.DATE_INGRESO_PAB,             'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_PAB,                   
                        TO_CHAR(O.DATE_INGRESO_QUIROFANO,       'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_QUIROFANO, 
                        TO_CHAR(O.DATE_INICIO_ANESTESIA,        'DD-MM-YYYY hh24:mi')                                                               AS INICIO_ANESTESIA, 
                        TO_CHAR(O.DATE_FINAL_ANESTESIA,         'DD-MM-YYYY hh24:mi')                                                               AS FINAL_ANESTESIA, 
                        TO_CHAR(O.DATE_SALIDA_QUIROFANO,        'DD-MM-YYYY hh24:mi')                                                               AS SALIDA_QUIROFANO, 
                        TO_CHAR(O.DATE_FINAL_LIMPIEZA,          'DD-MM-YYYY hh24:mi')                                                               AS FINAL_LIMPIEZA, 
                        TO_CHAR(O.DATE_TERMINO_INTERVENCION,    'DD-MM-YYYY hh24:mi')                                                               AS TERMINO_INTERVENCION, 
                        TO_CHAR(O.DATE_INGRESO_RECUPERACION,    'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_RECUPERACION, 
                        TO_CHAR(O.DATE_SALIDA_RECUPERACION,     'DD-MM-YYYY hh24:mi')                                                               AS SALIDA_RECUPERACION,
                        
                        TO_CHAR(O.DATE_INGRESO_PAB,           'hh24:mi')                                                                            AS HRS_INGRESO_PAB,                   
                        TO_CHAR(O.DATE_INGRESO_QUIROFANO,     'hh24:mi')                                                                            AS HRS_INGRESO_QUIROFANO, 
                        TO_CHAR(O.DATE_INICIO_ANESTESIA,      'hh24:mi')                                                                            AS HRS_INICIO_ANESTESIA, 
                        TO_CHAR(O.DATE_FINAL_ANESTESIA,       'hh24:mi')                                                                            AS HRS_FINAL_ANESTESIA, 
                        TO_CHAR(O.DATE_SALIDA_QUIROFANO,      'hh24:mi')                                                                            AS HRS_SALIDA_QUIROFANO, 
                        TO_CHAR(O.DATE_FINAL_LIMPIEZA,        'hh24:mi')                                                                            AS HRS_FINAL_LIMPIEZA, 
                        TO_CHAR(O.DATE_TERMINO_INTERVENCION,  'hh24:mi')                                                                            AS HRS_TERMINO_INTERVENCION, 
                        TO_CHAR(O.DATE_INGRESO_RECUPERACION,  'hh24:mi')                                                                            AS HRS_INGRESO_RECUPERACION, 
                        TO_CHAR(O.DATE_SALIDA_RECUPERACION,   'hh24:mi')                                                                            AS HRS_SALIDA_RECUPERACION,
                        
                        O.DATE_INGRESO_PAB                                                                                                          AS MIN_INGRESO_PAB,                   
                        O.DATE_INGRESO_QUIROFANO                                                                                                    AS MIN_INGRESO_QUIROFANO, 
                        O.DATE_INICIO_ANESTESIA                                                                                                     AS MIN_INICIO_ANESTESIA, 
                        O.DATE_FINAL_ANESTESIA                                                                                                      AS MIN_FINAL_ANESTESIA, 
                        O.DATE_SALIDA_QUIROFANO                                                                                                     AS MIN_SALIDA_QUIROFANO, 
                        O.DATE_FINAL_LIMPIEZA                                                                                                       AS MIN_FINAL_LIMPIEZA, 
                        O.DATE_TERMINO_INTERVENCION                                                                                                 AS MIN_TERMINO_INTERVENCION, 
                        O.DATE_INGRESO_RECUPERACION                                                                                                 AS MIN_INGRESO_RECUPERACION, 
                        O.DATE_SALIDA_RECUPERACION                                                                                                  AS MIN_SALIDA_RECUPERACION,
                                                
                        TO_CHAR(O.FEC_INICIO_SOLICITUD, 'hh24:mi')                                                                                  AS HORASOLICITUD,
                        DECODE(P.NOM_CORTO,'','--',''||P.NOM_CORTO)                                                                                 AS SALA_DESCRIPCION,
                        DECODE(O.NUM_REFERENCIA,'','NO',''||O.NUM_REFERENCIA)                                                                       AS IND_REFERENCIA,
                        
                        O.NUM_ORDEN                                                                                                                 AS ORDEN,
                        O.COD_PABELLON                                                                                                              AS COD_PABELLON,
                        P.NOM_CORTO                                                                                                                 AS TXTPABELLON,
                        
                        SUBSTR(PR.NOM_NOMBRE,1,1)||'.'|| PR.NOM_APEPAT||' '|| PR.NOM_APEMAT                                                         AS TXTNOMCIRU,
                        PR.COD_TPROFE                                                                                                               AS COD_TPROFE,
                        O.IND_TXTSOME                                                                                                               AS TXT_SOME,
                        O.IND_PABELLON                                                                                                              AS TXT_PABELLON,
                        O.NUM_DURACION                                                                                                              AS TIEMPO,
                        
                        O.TXT_HRSENFE                                                                                                               AS TXT_INGRESOPAB,
                        
                        TO_CHAR(O.FEC_AUDITA,       'DD-MM-YYYY HH24:MI')									    AS DATEULTIMAEDICION, 

                        DECODE(O.ID_PRD_SAN         ,'6','OTRO'
                                                    ,'5','CRIOPRECIPITADO'
                                                    ,'4','PLAQUETAS'
                                                    ,'3','PLASMA'
                                                    ,'2','GLOBULOS ROJOS'
                                                    ,'1','NO ESPECIFICADO'
                                                    ,'0','NO'
                                                    ,'NO ESPECIFICADO')                                                                             AS TXTHERMODERIVADO,
                                                    
                        DECODE(O.ID_RESER_PRD_SAN   ,'8','AB I(-)'
                                                    ,'7','B III(-)'
                                                    ,'6','O A II(-)'
                                                    ,'5','O IV(-)'
                                                    ,'4','AB I(+)'
                                                    ,'3','B III(+)'
                                                    ,'2','A II(+)'
                                                    ,'1','O IV(+)'
                                                    ,'0','NO ESPECIFICADO')                                                                         AS TXTSANGRE,
						    
                        DECODE(O.ID_TORRE_LAPA      ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTLAPAROSCOPIA,
                        DECODE(O.ID_POST_OPE        ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTOPERATORIO,
                        DECODE(O.ID_RAYOS           ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTRAYOS,
                        O.IND_MATERIALES                                                                                                            AS CHK_MATERIALES,
                        O.IND_RRHH                                                                                                                  AS CHK_RRHH,
                        O.IND_INSUMOS                                                                                                               AS CHK_INSUMOS,
                        O.ID_ASA                                                                                                                    AS ASA,
                        AN.NOM_ANESTESIA                                                                                                            AS TXTANESTESIA,
                        O.IND_PAD                                                                                                                   AS INDPAD,
                        M.IND_PROTOCOLO                                                                                                             AS IND_PROTOCOLO,
                        PAT.IND_ESTADO														    AS ID_ESTADO_HISTO,
			PAT.ID_SOLICITUD_HISTO                                                                                                      AS ID_HISTO
                        
                    FROM 
		    
                        $this->pabellon.PB_SALA_PABELLON                        P,
                        $this->pabellon.PB_TABLAOPERATORIA                      O,
                        $this->pabellon.PB_ESTADO_TQ                            M,
                        $this->pabellon.PB_RRHH_QX                              Q, 
                        $this->own.GG_TGPACTE                                   L,
                        $this->own.GG_TPROFESIONAL                              PR,
                        $this->pabellon.PB_TIPOANESTESIA                        AN,
                        $this->pabellon.PB_SOLICITUD_HISTO                      PAT
			    
                    WHERE
                        O.NUM_FICHAE            = L.NUM_FICHAE
                    AND
                        O.COD_PABELLON          = P.COD_PABELLON(+)
                    AND 
                        O.ID_ANESTESIA          = AN.ID_ANESTESIA(+)
                    AND    
                        O.ID_TABLA              = PAT.ID_TABLA(+)
                    AND    
                        O.ID_TABLA              = Q.ID_TABLA
                    AND 
                        Q.ID_TIPO_RRHH          = 1
                    AND 
                        Q.IND_ESTADO            = 1
                    AND  
                        PR.COD_RUTPRO           = Q.RUT_PROFESIONAL 
                    AND 
                        M.ID_ESTADO_TQ          = O.ID_ESTADO_TQ
                   
                    $where
                        
                    --AND O.FEC_INICIO_SOLICITUD BETWEEN TO_DATE(' 00:00:00', 'DD/MM/YYYY hh24:mi:ss') AND TO_DATE(' 23:59:00', 'DD/MM/YYYY  hh24:mi:ss') 
                    ORDER BY 
                            
                            O.FEC_INICIO_SOLICITUD ASC,
                            COD_PABELLON,
                            ORDEN,
                            FECHAHORASOLICITUD
			    
                        ";
              return $sQuery;
        } 
        
        public function getprotcoloxIC($empresa,$id_tabla){
            
            $sQuery = "
                    SELECT 
                        P.ID_PROXIC, 
                        P.ID_TABLA, 
                        P.ID_SIC, 
                        P.USR_CREA, 
                        P.FEC_CREA, 
                        P.IND_ESTADO, 
                        P.NUM_INTERCONSULTA, 
                        P.COD_EMPRESA
                    FROM 
                        PABELLON.PB_PROTOCOLOXIC P
                    WHERE
                    
                        P.ID_TABLA = $id_tabla 
                        AND 
                        P.IND_ESTADO    = 1
                        
                    ";
                return $sQuery;
        }
        
	
        public function getBusquedaAyudante($desde, $hasta, $empresa, $session){
            
            $where  ='';
            
            $sQuery ="  
                SELECT
                        
                        CASE 
                            WHEN 
                                 M.IND_PROTOCOLO = 1
                            THEN 
                                CASE 
                                    WHEN 
                                        TO_DATE( O.FEC_INICIO_SOLICITUD,'DD-MM-YYYY hh24:mi')  BETWEEN  SYSDATE - 1 AND SYSDATE 
                                    THEN 
                                        '1' 
                                    ELSE 
                                        '0' 
                                END   
                            ELSE 
                                        '0' 
                        END                                                                                                                         AS TIEMPO_CIERRE,
                                                                                                                                                    
                        O.ID_TABLA                                                                                                                  AS ID,
                        O.NUM_FICHAE                                                                                                                AS FICHAE,
                        DECODE(O.ID_ORIGEN,        
                                '1', 'INSTITUCIONAL',    
                                '2', 'PRIVADA',          
                                '3', 'URGENCIA',         
                                '4', 'PROCEDIMIENTO',    
                                '5', 'PARTO','NO ESPECIFICADO')                                                                                     AS NOM_ORIGEN,
                        DECODE(O.ID_ORIGEN,        
                                '1', 'INST',    
                                '2', 'PRV',          
                                '3', 'URG',         
                                '4', 'PROC',    
                                '5', 'PART','NO ESPECIFICADO')                                                                                      AS NOM_ORIGENABRE,
                        DECODE(O.ID_PROGRAMA_CIRUGIA,        
                                '1', 'MAYOR HOSPITALIZADO',    
                                '2', 'MENOR AMBULATORIO',          
                                '3', 'MENOR HOSPITALIZADO',         
                                '4', 'MAYOR AMBULATORIO','')                                                                                        AS NOM_PROCEDENCIA,
                        DECODE(O.ID_PROGRAMA_CIRUGIA, 
                                '1', 'HOSP',    
                                '2', 'AMB',          
                                '3', 'HOSP',         
                                '4', 'AMB','')                                                                                                      AS NOM_PROCEDENCIA_COR,
                        CASE 
                            WHEN 
                                M.IND_PROTOCOLO = 1 
                            THEN 
                                DECODE(M.NUM_PROTOCOLO,
                                '1','pabellon_classpdf/pdf2?id='||O.ID_TABLA,
                                '2','pabellon_classpdf/muestraPDF_PARTO?id='||O.ID_TABLA,
                                '3','pabellon_classpdf/muestra_OFTAMOLOGIA?id='||O.ID_TABLA,                                    
                                '#')
                            ELSE 
                                DECODE(M.ID_ESTADO_TQ,
                                '11','pabellon_classpdf/muestraPDF_SUSPENDIDAS?id='||O.ID_TABLA,'pabellon_classpdf/muestraPDF3?id='||O.ID_TABLA)
                        END                                                                                                                         AS RUTA_PROTOCOLO,
                        O.ID_PROGRAMA_CIRUGIA                                                                                                       AS ID_PROGRAMA_CIRUGIA,
                        O.ID_ORIGEN                                                                                                                 AS ID_ORIGEN, 
                        O.ID_ESTADO_TQ                                                                                                              AS ID_ESTADO,
                        M.DES_CORTO                                                                                                                 AS TXT_ESTADO,
                        O.ID_ORIGEN_EGRESO                                                                                                          AS ID_ORIGEN_EGRESO, 
                        L.COD_RUTPAC||'-'||L.COD_DIGVER                                                                                             AS RUTPACIENTE,
                        L.IND_TISEXO                                                                                                                AS IND_TISEXO,
                        DECODE(O.ID_OPERADO,'1','OPERADO','0','NO OPERADO','NO ESPECIFICADO')                                                       AS TXT_OPERADO,
                        L.COD_RUTPAC                                                                                                                AS COD_RUTPAC,
                        TRUNC(MONTHS_BETWEEN(SYSDATE,L.FEC_NACIMI)/12)                                                                              AS NUMEDAD,
                        O.ID_TIPO_PACIENTE                                                                                                          AS TIPOSOLICITUD,
                        (SELECT E.NUM_NFICHA FROM ADMIN.SO_TCPACTE E WHERE  E.NUM_FICHAE=O.NUM_FICHAE  AND E.COD_EMPRESA=O.COD_TESTABL)             AS FICHAL,
                        DECODE(O.ID_TIPO_PACIENTE,'1','PRIORIZADO','2','CONDICIONAL','NO ESPECIFICADO')                                             AS TIPO_PACIENTE,
                        (O.FEC_FIN_SOLICITUD-O.FEC_INICIO_SOLICITUD)*(60*24)                                                                        AS MINCIRUGIA,
                        UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)                                                     AS NOMBRE_COMPLETO,
                        SUBSTR(L.NOM_NOMBRE,1,1)||'.'||UPPER(L.NOM_APEPAT)||' '||UPPER(L.NOM_APEMAT)                                                AS TXTNOMCIRUSMALL,
                        UPPER(L.NOM_NOMBRE)||' '||UPPER(L.NOM_APEPAT)||' '||UPPER(SUBSTR(L.NOM_APEMAT,1,1))                                         AS TXTPRIMERNOMBREAPELLIDO,
                        (SELECT NOM_SERVIC FROM ADMIN.GG_TSERVICIOXEMP T,   ADMIN.GG_TSERVICIO S WHERE   T.ID_SERDEP =  O.COD_UNIDAD 
                        AND T.COD_EMPRESA = '$empresa' AND S.ID_SERDEP = T.ID_SERDEP)                                                               AS NOMBRE_SERVICIO,
                        UPPER(O.TXT_HIPO_DIAG)                                                                                                      AS TXTDIAGNOSTICO,
                        UPPER(O.TXT_POSTOPERATORIO)                                                                                                 AS TXTDIAGNOPOST,
                        UPPER(O.TXT_CIRUPROP)                                                                                                       AS COD_CIRUPROP,
                        TO_CHAR(O.FEC_INICIO_SOLICITUD,         'HH24')                                                                             AS INICIOHORA,
                        TO_CHAR(O.FEC_INICIO_SOLICITUD,         'HH24:mi')                                                                          AS INICIOHORAMIN,
                        TO_CHAR(O.FEC_INICIO_SOLICITUD,         'DD-MM-YYYY hh24:mi')                                                               AS FECHAHORASOLICITUD,
                        TO_CHAR(O.FEC_FIN_SOLICITUD,            'DD-MM-YYYY hh24:mi')                                                               AS FECHAHORAFINAL,
                        TO_CHAR(O.DATE_INGRESO_PAB,             'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_PAB,                   
                        TO_CHAR(O.DATE_INGRESO_QUIROFANO,       'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_QUIROFANO, 
                        TO_CHAR(O.DATE_INICIO_ANESTESIA,        'DD-MM-YYYY hh24:mi')                                                               AS INICIO_ANESTESIA, 
                        TO_CHAR(O.DATE_FINAL_ANESTESIA,         'DD-MM-YYYY hh24:mi')                                                               AS FINAL_ANESTESIA, 
                        TO_CHAR(O.DATE_SALIDA_QUIROFANO,        'DD-MM-YYYY hh24:mi')                                                               AS SALIDA_QUIROFANO, 
                        TO_CHAR(O.DATE_FINAL_LIMPIEZA,          'DD-MM-YYYY hh24:mi')                                                               AS FINAL_LIMPIEZA, 
                        TO_CHAR(O.DATE_TERMINO_INTERVENCION,    'DD-MM-YYYY hh24:mi')                                                               AS TERMINO_INTERVENCION, 
                        TO_CHAR(O.DATE_INGRESO_RECUPERACION,    'DD-MM-YYYY hh24:mi')                                                               AS INGRESO_RECUPERACION, 
                        TO_CHAR(O.DATE_SALIDA_RECUPERACION,     'DD-MM-YYYY hh24:mi')                                                               AS SALIDA_RECUPERACION,
                        TO_CHAR(O.DATE_INGRESO_PAB,             'hh24:mi')                                                                          AS HRS_INGRESO_PAB,                   
                        TO_CHAR(O.DATE_INGRESO_QUIROFANO,       'hh24:mi')                                                                          AS HRS_INGRESO_QUIROFANO, 
                        TO_CHAR(O.DATE_INICIO_ANESTESIA,        'hh24:mi')                                                                          AS HRS_INICIO_ANESTESIA, 
                        TO_CHAR(O.DATE_FINAL_ANESTESIA,         'hh24:mi')                                                                          AS HRS_FINAL_ANESTESIA, 
                        TO_CHAR(O.DATE_SALIDA_QUIROFANO,        'hh24:mi')                                                                          AS HRS_SALIDA_QUIROFANO, 
                        TO_CHAR(O.DATE_FINAL_LIMPIEZA,          'hh24:mi')                                                                          AS HRS_FINAL_LIMPIEZA, 
                        TO_CHAR(O.DATE_TERMINO_INTERVENCION,    'hh24:mi')                                                                          AS HRS_TERMINO_INTERVENCION, 
                        TO_CHAR(O.DATE_INGRESO_RECUPERACION,    'hh24:mi')                                                                          AS HRS_INGRESO_RECUPERACION, 
                        TO_CHAR(O.DATE_SALIDA_RECUPERACION,     'hh24:mi')                                                                          AS HRS_SALIDA_RECUPERACION,
                        O.DATE_INGRESO_PAB                                                                                                          AS MIN_INGRESO_PAB,                   
                        O.DATE_INGRESO_QUIROFANO                                                                                                    AS MIN_INGRESO_QUIROFANO, 
                        O.DATE_INICIO_ANESTESIA                                                                                                     AS MIN_INICIO_ANESTESIA, 
                        O.DATE_FINAL_ANESTESIA                                                                                                      AS MIN_FINAL_ANESTESIA, 
                        O.DATE_SALIDA_QUIROFANO                                                                                                     AS MIN_SALIDA_QUIROFANO, 
                        O.DATE_FINAL_LIMPIEZA                                                                                                       AS MIN_FINAL_LIMPIEZA, 
                        O.DATE_TERMINO_INTERVENCION                                                                                                 AS MIN_TERMINO_INTERVENCION, 
                        O.DATE_INGRESO_RECUPERACION                                                                                                 AS MIN_INGRESO_RECUPERACION, 
                        O.DATE_SALIDA_RECUPERACION                                                                                                  AS MIN_SALIDA_RECUPERACION,
                        TO_CHAR(O.FEC_INICIO_SOLICITUD, 'hh24:mi')                                                                                  AS HORASOLICITUD,
                        DECODE(P.NOM_CORTO,'','--',''||P.NOM_CORTO)                                                                                 AS SALA_DESCRIPCION,
                        DECODE(O.NUM_REFERENCIA,'','NO',''||O.NUM_REFERENCIA)                                                                       AS IND_REFERENCIA,
                        O.NUM_ORDEN                                                                                                                 AS ORDEN,
                        O.COD_PABELLON                                                                                                              AS COD_PABELLON,
                        P.NOM_CORTO                                                                                                                 AS TXTPABELLON,
                        SUBSTR(PR.NOM_NOMBRE,1,1)||'.'|| PR.NOM_APEPAT||' '|| PR.NOM_APEMAT                                                         AS TXTNOMCIRU,
                        PR.COD_TPROFE                                                                                                               AS COD_TPROFE,
                        O.IND_TXTSOME                                                                                                               AS TXT_SOME,
                        O.IND_PABELLON                                                                                                              AS TXT_PABELLON,
                        O.NUM_DURACION                                                                                                              AS TIEMPO,
                        O.TXT_HRSENFE                                                                                                               AS TXT_INGRESOPAB,
                        TO_CHAR(O.FEC_AUDITA,        'DD-MM-YYYY hh24:mi')                                                                          AS DATEULTIMAEDICION, 
                        DECODE(O.ID_PRD_SAN         ,'6','OTRO'
                                                    ,'5','CRIOPRECIPITADO'
                                                    ,'4','PLAQUETAS'
                                                    ,'3','PLASMA'
                                                    ,'2','GLOBULOS ROJOS'
                                                    ,'1','NO ESPECIFICADO'
                                                    ,'0','NO'
                                                    ,'NO ESPECIFICADO')                                                                             AS TXTHERMODERIVADO,
                        DECODE(O.ID_RESER_PRD_SAN   ,'8','AB I(-)'
                                                    ,'7','B III(-)'
                                                    ,'6','O A II(-)'
                                                    ,'5','O IV(-)'
                                                    ,'4','AB I(+)'
                                                    ,'3','B III(+)'
                                                    ,'2','A II(+)'
                                                    ,'1','O IV(+)'
                                                    ,'0','NO ESPECIFICADO')                                                                         AS TXTSANGRE,
                        DECODE(O.ID_TORRE_LAPA      ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTLAPAROSCOPIA,
                        DECODE(O.ID_POST_OPE        ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTOPERATORIO,
                        DECODE(O.ID_RAYOS           ,'1','SI','0','NO','NO ESPECIFICADO')                                                           AS TXTRAYOS,
                        O.IND_MATERIALES                                                                                                            AS CHK_MATERIALES,
                        O.IND_RRHH                                                                                                                  AS CHK_RRHH,
                        O.IND_INSUMOS                                                                                                               AS CHK_INSUMOS,
                        O.ID_ASA                                                                                                                    AS ASA,
                        AN.NOM_ANESTESIA                                                                                                            AS TXTANESTESIA,
                        O.IND_PAD                                                                                                                   AS INDPAD,
                        PAT.ID_SOLICITUD_HISTO                                                                                                      AS ID_HISTO
                        
                    FROM 
                        $this->pabellon.PB_SALA_PABELLON                        P,
                        $this->pabellon.PB_TABLAOPERATORIA                      O,
                        $this->pabellon.PB_ESTADO_TQ                            M,
                        $this->pabellon.PB_RRHH_QX                              Q, 
                        $this->own.GG_TGPACTE                                   L,
                        $this->own.GG_TPROFESIONAL                              PR,
                        $this->pabellon.PB_TIPOANESTESIA                        AN,
                        $this->pabellon.PB_SOLICITUD_HISTO                      PAT
                    WHERE
                    
                        O.NUM_FICHAE            =   L.NUM_FICHAE
                    AND
                        O.COD_PABELLON          =   P.COD_PABELLON(+)
                    AND 
                        O.ID_ANESTESIA          =   AN.ID_ANESTESIA(+)
                    AND    
                        O.ID_TABLA              =   PAT.ID_TABLA(+)
                    AND    
                        O.ID_TABLA              =   Q.ID_TABLA
                    AND 
                        Q.ID_TIPO_RRHH          IN  (9,2,3,4) 
                    AND 
                        Q.IND_ESTADO            =   1
                    AND  
                        PR.COD_RUTPRO           =   '$session'
                    AND
                        PR.COD_RUTPRO           =   Q.RUT_PROFESIONAL 
                    AND 
                        M.ID_ESTADO_TQ          =   O.ID_ESTADO_TQ
                    AND 
                        O.COD_TESTABL           =   '$empresa'
			    
			$where
			    
                    AND 
                        O.FEC_INICIO_SOLICITUD BETWEEN TO_DATE('$desde 00:00:00','DD/MM/YYYY hh24:mi:ss') AND TO_DATE('$hasta 23:59:00','DD/MM/YYYY hh24:mi:ss') 
                    ORDER BY 
                            O.FEC_INICIO_SOLICITUD ASC,
                            COD_PABELLON,
                            ORDEN,
                            FECHAHORASOLICITUD
                        ";
                return $sQuery;
    }
        
    public function getBusquedaTextoAyudante($session,$id,$des){
        $where              = '';
        if($session !='')   {   $where.= " AND A.COD_RUTPRO = '$session' ";    }
        if($des     !='')   {   $where.= " ";    }
        $sQuery = "
		SELECT
                    A.ID_MDESCRIPCION                                           AS ID,
                    A.TXT_DESCRIPCION_QX                                        AS TXT,
                    B.NOM_APEPAT||' '||B.NOM_APEMAT||' '||B.NOM_NOMBRE          AS TXT_NOMBRE,
                    B.COD_RUTPRO                                                AS RUT
                FROM
                    PABELLON.PB_DESCRIPCION_AYUDANTE                            A,
                    ADMIN.GG_TPROFESIONAL                                       B
                WHERE    
                        A.ID_TABLA                                              = $id
                    AND A.IND_ESTADO                                            = 1   
                    AND A.COD_RUTPRO                                            = B.COD_RUTPRO   
                    $where
                "; 
        return $sQuery;
    }
    
    //***************** NUEVO 24-06-2019 ******************************
    public function sqlInfoicxidsic_x_num_empresa($num_ic,$cod_empresa){
        $sQuery = "
	    SELECT 
		A.IND_AUGE			AS  IND_GES,
		A.COD_ESTABLREF			AS  COD_ESTABLREF,
		A.COD_EMPRESA			AS  COD_EMPRESA
	    FROM 
		ADMIN.SO_TINTERCONSULTA A    
	    WHERE 
		A.NUM_INTERCONSULTA		=   '$num_ic'  
		AND
		A.COD_EMPRESA			=   '$cod_empresa' 
	    ";
        return $sQuery;          
    }
    
    public function sqlInfoicxidsic($id_sic){
        $sQuery = "
	    SELECT 
		A.IND_AUGE			AS  IND_GES,
		A.COD_ESTABLREF			AS  COD_ESTABLREF,
		A.COD_EMPRESA			AS  COD_EMPRESA
	    FROM 
		ADMIN.SO_TINTERCONSULTA A    
	    WHERE 
		A.ID_SIC			=   '$id_sic' 
            ";
        return $sQuery;          
    }
    
    function cuentansppac($numinterconsulta,$cod_estab,$cod_motivo){
        $sQuery = "
	    SELECT 
                COUNT(*)+1			CUENTANSP
            FROM
                ADMIN.SO_TINTERCITAELIM         A, 
                ADMIN.GG_TRECHAZO               B
            WHERE
                
		A.COD_ELIMINACITA               =   B.COD_RECHAZO	    AND
		A.NUM_INTERCONSULTA             =   '$numinterconsulta'	    AND
                A.COD_EMPRESA                   =   '$cod_estab'	    AND
                A.COD_ELIMINACITA               =   '$cod_motivo'	    AND
                A.IND_ESTADO                    =   1			    AND
                B.IND_TIPO                      =   'NSP'
            ";
        return $sQuery;
    }

    function cuentansppac_all($numinterconsulta,$cod_estab,$cod_motivo){
        $sQuery = "
            SELECT 
                COUNT(*)+1			AS  CUENTANSP,
		C.IND_AUGE			AS  IND_GES,
		C.COD_ESTABLREF			AS  COD_ESTABLREF,
		C.COD_EMPRESA			AS  COD_EMPRESA
	    FROM
	    
                ADMIN.SO_TINTERCITAELIM         A, 
                ADMIN.GG_TRECHAZO               B,
		ADMIN.SO_TINTERCONSULTA		C 
		
            WHERE
                
		A.COD_ELIMINACITA               =   B.COD_RECHAZO	    AND
		A.NUM_INTERCONSULTA             =   '$numinterconsulta'	    AND
                A.COD_EMPRESA                   =   '$cod_estab'	    AND
                A.COD_ELIMINACITA               =   '$cod_motivo'	    AND
		A.NUM_INTERCONSULTA		=   C.NUM_INTERCONSULTA	    AND
		A.COD_EMPRESA			=   C.COD_EMPRESA	    AND
		A.IND_ESTADO                    =   1			    AND
                B.IND_TIPO                      =   'NSP'
	    GROUP BY
		C.IND_AUGE,C.COD_ESTABLREF,C.COD_EMPRESA
   
		
            ";
        return $sQuery;
    }
    //***************** NUEVO 24-06-2019 ******************************
 
    
} 