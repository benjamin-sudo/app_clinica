ALTER SESSION SET CONTAINER = FREEPDB1;
ALTER SESSION SET CURRENT_SCHEMA = ADMIN;

/
CREATE OR REPLACE PACKAGE ADMIN.PROCE_ANATOMIA_PATOLOGIA AS
    PROCEDURE GET_INFOPRESOLICITUD(
        V_COD_EMPRESA           IN VARCHAR2,
        V_USR_SESSION           IN VARCHAR2,
        C_LISTADOSERVICIOS      OUT SYS_REFCURSOR,
        C_LISTADOMEDICOS        OUT SYS_REFCURSOR,
        C_ESPECIALIDADES        OUT SYS_REFCURSOR
    );
END PROCE_ANATOMIA_PATOLOGIA;

/
CREATE OR REPLACE PACKAGE BODY ADMIN.PROCE_ANATOMIA_PATOLOGIA AS
    PROCEDURE GET_INFOPRESOLICITUD  (
        V_COD_EMPRESA               IN VARCHAR2,
        V_USR_SESSION               IN VARCHAR2,
        C_LISTADOSERVICIOS          OUT SYS_REFCURSOR,
        C_LISTADOMEDICOS            OUT SYS_REFCURSOR,
        C_ESPECIALIDADES            OUT SYS_REFCURSOR
    ) IS
    BEGIN
  
    
    OPEN C_ESPECIALIDADES FOR 
    SELECT
        A.COD_GRUPO                                                                                           AS VALUE,
        A.ID_GRUPO                                                                                              AS ID_VALUE,
        A.NOM_GRUPO                                                                                           AS OPCION
    FROM
        ADMIN.GG_TGRUESP                                                                                  A, 
        ADMIN.SO_TMOTICIQ                                                                                 B
    WHERE    
        A.IND_ESTADO                                                                                          = 'V' 
        AND A.COD_GRUPO                                                                                    = B.COD_ESPEC 
        AND A.COD_GRUPO                                                                                    <> 'NOAP'
    GROUP BY 
        A.COD_GRUPO,
        A.ID_GRUPO,
        A.NOM_GRUPO 
    ORDER BY A.NOM_GRUPO;
    

    
    OPEN C_LISTADOSERVICIOS FOR 
          SELECT  * 
    FROM (
        SELECT  
            GG_TSERVICIO.ID_SERDEP                                            AS ID, 
            GG_TSERVICIO.NOM_SERVIC                                           AS TXT_DES
        FROM 
            ADMIN.GG_TSERVICIO, 
            ADMIN.GG_TSERVICIOXEMP 
        WHERE 
            GG_TSERVICIOXEMP.ID_SERDEP                                        = GG_TSERVICIO.ID_SERDEP 
            AND (GG_TSERVICIOXEMP.IND_MED                                     = '1' OR GG_TSERVICIO.ID_SERDEP IN('268','266'))
            AND GG_TSERVICIOXEMP.COD_EMPRESA                                  IN (V_COD_EMPRESA)
            AND GG_TSERVICIO.IND_SERDEP                                       = 'S'
        UNION 
            SELECT A.ID_SERDEP                                                AS ID,
            A.NOM_SERVIC                                                      AS TXT_DES 
            FROM  ADMIN.GG_TSERVICIO A, ADMIN.GG_TSERVICIOXEMP B
            WHERE  A.ID_SERDEP=B.ID_SERDEP
            AND B.COD_EMPRESA IN (V_COD_EMPRESA) AND IND_MED=1 AND
            ((IND_SERDEP='S' AND AF_ID_AREAFUNCIONAL IS NOT NULL) OR  IND_SERDEP='D')
            AND A.ID_SERDEP NOT IN (229)
        ) ORDER   BY TXT_DES;
    

    OPEN C_LISTADOMEDICOS FOR 
    SELECT 
        A.COD_RUTPRO,  
        A.ID_PROFESIONAL                                                                                                     AS ID_PRO,
        A.COD_DIGVER                                                                                                           AS COD_DIGVER,
        UPPER(A.NOM_APEPAT)||' ' ||UPPER(A.NOM_APEMAT)||' ' ||UPPER(A.NOM_NOMBRE)    AS NOM_PROFE,
        C.DES_TIPOATENCION                                                                                                AS DES_TIPOATENCION,
        B.COD_TPROFE                                                                                                          AS COD_TPROFE,
        B.NOM_TPROFE                                                                                                          AS NOM_TPROFE,
        C.IND_TIPOATENCION                                                                                                  AS IND_TIPOATENCION
    FROM 
        ADMIN.GG_TPROFESIONAL   A,
        ADMIN.GG_TPROFESION     B,
        ADMIN.AP_TTIPOATENCION  C,
        ADMIN.AP_TPROFXESTABL   D
    WHERE     
        A.IND_ESTADO            = 'V'
        AND D.IND_ESTADO        = 'V'
        AND A.COD_TPROFE        = B.COD_TPROFE
        AND B.IND_TIPOATENCION  = C.IND_TIPOATENCION
        AND A.COD_RUTPRO        = D.COD_RUTPRO
        AND D.COD_EMPRESA       IN (V_COD_EMPRESA)
    ORDER BY 
        C.IND_TIPOATENCION, 
        A.NOM_APEPAT;
        
  END;

END PROCE_ANATOMIA_PATOLOGIA;
/

COMMIT;

/






