ALTER SESSION SET CONTAINER         =  FREEPDB1;
ALTER SESSION SET CURRENT_SCHEMA    =  ADMIN;

CREATE TABLE ADMIN.HD_DIASSEMANA (
    ID_NDIA                 NUMBER,
    TXT_NDIA                VARCHAR2(50 BYTE),
    IND_ESTADO              NUMBER,
    TXT_NDIACORTO           VARCHAR2(50 BYTE),
    PRIMARY KEY (ID_NDIA)
);

CREATE TABLE ADMIN.HD_FREACIONESAD (
    ID_FREACION             NUMBER NOT NULL,
    ID_RADVERSA             NUMBER NOT NULL,
    IDHOJADIARIA            NUMBER NOT NULL,
    TXT_OBSERVACIONES       VARCHAR2(500 BYTE),
    IND_ESTADO              NUMBER(5),
    COD_USRCREA             VARCHAR2(50 BYTE),
    FEC_USRFEC              DATE,
    COD_USRAUDITA           VARCHAR2(50 BYTE),
    FEC_USRAUDITA           DATE,
    PRIMARY KEY (ID_FREACION)
);

CREATE TABLE ADMIN.HD_HISTO_TDHOJADIARIA (
    ID_TDHOJADIARIA          NUMBER NOT NULL,
    NUM_FICHAE               VARCHAR2(50 BYTE),
    NUM_CITACION             NUMBER,
    AD_ID_ADMISION           NUMBER,
    NUM_PESOSECO             NUMBER,
    NUM_HDPESOANTERIOR       NUMBER,
    NUM_PESOPREDIALISIS      NUMBER,
    NUM_INTERDIALISIS        NUMBER,
    NUM_UFPROGRAMADA         NUMBER,
    NUM_PESOPOSTDIALISIS     NUMBER,
    NUM_PESOINTERDIALISIS    NUMBER,
    USR_CREA                 VARCHAR2(50 BYTE),
    FEC_CREA                 DATE,
    USR_AUDITA               VARCHAR2(50 BYTE),
    FEC_AUDITA               DATE,
    NUM_ALZAINTERDIALISIS    NUMBER,
    TXTACCESOVAS_1           VARCHAR2(150 BYTE),
    NUM_DIASVAS_1            NUMBER,
    TXTACCESOVAS_2           VARCHAR2(150 BYTE),
    NUM_DIASVAS_2            NUMBER,
    NUM_TROCAR_ARTERIAL      NUMBER,
    NUM_TROCAR_VENOSO        NUMBER,
    NUM_HEPARINA_INICIO      NUMBER,
    NUM_HEPARINA_MAN         NUMBER,
    NUM_QT                   VARCHAR2(50 BYTE),
    NUM_QB                   NUMBER,
    NUM_QD                   NUMBER,
    NUM_UFMAX                NUMBER,
    NUM_K                    VARCHAR2(50 BYTE),
    TXT_OBSMEDICAS           VARCHAR2(500 BYTE),
    TXT_ENFERMERIA           VARCHAR2(500 BYTE),
    NUM_CI_FILTRO            NUMBER,
    NUM_CI_ARTERIAL          NUMBER,
    NUM_CI_VENOSA            NUMBER,
    NUM_PS_FILTRO            NUMBER,
    NUM_PS_ARTERIAL          VARCHAR2(50 BYTE),
    NUM_PS_VENOSO            NUMBER,
    TXT_TESTPOTENCIA         VARCHAR2(500 BYTE),
    NUM_USO_FILTRO           NUMBER,
    NUM_V_RESIDUAL           NUMBER,
    NUM_V_ARTERIAL           NUMBER,
    NUM_V_VENOSA             NUMBER,
    NUM_NA                   NUMBER,
    NUM_CONCENTRADO          VARCHAR2(500 BYTE),
    ID_RMDIALISIS            NUMBER,
    IND_PACIENTE_CORRECTO    NUMBER,
    IND_CLINEAS              NUMBER,
    IND_CFILTRO              NUMBER,
    NUM_T_MONITOR            VARCHAR2(30 BYTE),
    NUM_CONDUCTIVIDAD        NUMBER,
    NUM_TEST_RESIDUOS        NUMBER,
    IND_HIPOTENSION          NUMBER,
    IND_CALOFRIO             NUMBER,
    IND_FIEBRE               NUMBER,
    IND_ICVASCULAR           NUMBER,
    IND_BACTEREMIA           NUMBER,
    IND_HEPATITIS_B          NUMBER,
    IND_HEPATITIS_C          NUMBER,
    IND_MDPROCEDIMIENTO      NUMBER,
    ID_TIPOVIA               NUMBER,
    DATE_REALIZAHD           DATE,
    DATE_FHEGRESO            DATE,
    IND_R_RFIBRAS            NUMBER(5),
    IND_C_RFIBRAS            NUMBER(5),
    IND_R_PIROGENOS          NUMBER(5),
    FEC_DIASVAS_1            DATE,
    FEC_DIASVAS_2            DATE,
    NUM_TOTALUFCONSEGIDA     NUMBER,
    NUM_VOLSANGREACOMULADA   NUMBER,
    IND_DESIFCACCIONMAQUINA  NUMBER,
    IND_DIALIZADORDIAL       NUMBER,
    IND_HDESTADO             NUMBER,
    NUM_KT_V                 NUMBER,
    ID_HISTO_DHOJADIARIA     NUMBER(10),
    COD_HIST_USRCREA         VARCHAR2(50 BYTE),
    FEC_HIST_CREA            DATE,
    DES_AUDITA               VARCHAR2(300 BYTE),
    NUM_IP_EQUIPO            VARCHAR2(20 BYTE),
    PRIMARY KEY (ID_TDHOJADIARIA)
);


CREATE TABLE ADMIN.HD_HISTOELIMINAHOJA(
    ID_HISTOELIMINA         NUMBER NOT NULL,
    NUM_FICHAE              NUMBER,
    ID_TDHOJADIARIA         NUMBER,
    AD_ID_ADMISION          NUMBER,
    COD_EMPRESA             VARCHAR2(50 BYTE),
    USR_FIRMA               VARCHAR2(50 BYTE),
    IND_ESTADO              NUMBER,
    COD_USRCREA             VARCHAR2(50 BYTE),
    DATE_CREA               DATE,
    IND_MOTIVO              NUMBER,
    PRIMARY KEY (ID_HISTOELIMINA)
);

CREATE TABLE ADMIN.HD_IMEDICO(
    ID_IMEDICO            NUMBER                   NOT NULL,
    NUM_FICHAE            VARCHAR2(50 BYTE)        NOT NULL,
    COD_USRCREA           VARCHAR2(50 BYTE),
    FEC_USRCREA           DATE,
    COD_USRAUDITA         VARCHAR2(50 BYTE),
    FEC_USRAUDITA         DATE,
    IND_ESTADO            NUMBER(1),
    TXTACCESOVAS_2        VARCHAR2(255 BYTE),
    NUM_DIASVAS_1         NUMBER(10),
    TXTACCESOVAS_1        VARCHAR2(255 BYTE),
    NUM_DIASVAS_2         NUMBER(10),
    NUM_ARTERIAL          NUMBER(10),
    NUM_VENOSO            NUMBER(10),
    NUM_INICIO            NUMBER(10),
    NUM_MANTENCION        NUMBER(10),
    NUM_QT                NUMBER(10),
    NUM_QB                NUMBER(10),
    NUM_QD                NUMBER(10),
    NUM_UFMAX             NUMBER(10),
    NUM_K                 NUMBER(10),
    NUM_NA                VARCHAR2(50 BYTE),
    NUM_CONCENTRADO       VARCHAR2(255 BYTE),
    NUM_HEPARINA_MAN      NUMBER(10),
    NUM_HEPARINA_INICIO   NUMBER(10),
    NUM_TROCAR_VENOSO     NUMBER(10),
    NUM_TROCAR_ARTERIAL   NUMBER(10),
    NUM_PESOSECO          NUMBER,
    FEC_DIASVAS_1         DATE,
    FEC_DIASVAS_2         DATE,
    PRIMARY KEY (ID_IMEDICO)
);


CREATE TABLE ADMIN.HD_LCUPOSXMAQUINA (
    ID_RCUPO            NUMBER NOT NULL,
    ID_RMDIALISIS       NUMBER NOT NULL,
    ID_GRUPO            NUMBER,
    ID_TURNO            NUMBER,
    COD_CREA            VARCHAR2(50 BYTE),
    DATE_CREA           DATE,
    IND_ESTADO          NUMBER,
    PRIMARY KEY (ID_RCUPO)
);

CREATE TABLE ADMIN.HD_NPACIENTEXCUPO (
    ID_CUPOXPACIENTE    NUMBER NOT NULL,
    COD_EMPRESA         VARCHAR2(50 BYTE),
    NUM_FICHAE          NUMBER,
    NUM_INGRESO         NUMBER,
    ID_RMDIALISIS       NUMBER,
    ID_TURNOSXDIAS      NUMBER,
    COD_USRCREA         VARCHAR2(25 BYTE),
    DATE_CREA           DATE,
    IND_ESTADO          NUMBER,
    COD_AUDITA          VARCHAR2(50 BYTE),
    FEC_AUDITA          DATE,
    PRIMARY KEY (ID_CUPOXPACIENTE)
);

CREATE TABLE ADMIN.HD_RADVERSA (
    ID_RADVERSA         NUMBER NOT NULL,
    TXT_RADVERSA        VARCHAR2(255 BYTE),
    IND_ESTADO          NUMBER(10),
    PRIMARY KEY (ID_RADVERSA)
);

CREATE TABLE ADMIN.HD_REGEDICION (
    ID_PEDICION      NUMBER                       NOT NULL,
    IND_PERMISO      NUMBER,
    IND_ESTADO       NUMBER,
    ID_TCORECION     NUMBER,
    COD_USRCREA      VARCHAR2(50 BYTE),
    FEC_USRFEC       DATE,
    ID_TDHOJADIARIA  NUMBER,
    AD_ACTIVA        NUMBER,
    COD_TLLAVE       VARCHAR2(50 BYTE),
    PRIMARY KEY (ID_PEDICION)
);

CREATE TABLE ADMIN.HD_RHERMOPROFE (
    ID_RPROFE        NUMBER                       NOT NULL,
    COD_RUTPAC       VARCHAR2(50 BYTE),
    IND_FUNCION      NUMBER,
    IND_ESTADO       NUMBER,
    USR_CREA         VARCHAR2(50 BYTE),
    DATE_CREA        DATE,
    USR_AUDITA       VARCHAR2(50 BYTE),
    DATE_AUDTITA     DATE,
    IND_HDESTAPA     NUMBER,
    ID_TDHOJADIARIA  NUMBER,
    PRIMARY KEY (ID_RPROFE)
);


CREATE TABLE ADMIN.HD_RMDIALISIS(
    ID_RMDIALISIS           NUMBER,
    COD_RMDIALISIS          VARCHAR2(50 BYTE),
    NOM_RMDIALISIS          VARCHAR2(100 BYTE),
    IND_ESTADO              NUMBER,
    NUM_SERIE               VARCHAR2(50 BYTE),
    NUM_LORE                VARCHAR2(50 BYTE),
    COD_EMPRESA             VARCHAR2(50 BYTE),
    NOM_CORTO               VARCHAR2(50 BYTE),
    PRIMARY KEY (ID_RMDIALISIS)
);

CREATE TABLE ADMIN.HD_RRHHDIALISIS (
    ID_RRHH                 NUMBER NOT NULL,
    COD_RUTPRO              NUMBER,
    ID_PROFESIONAL          NUMBER,
    IND_ESTADO              NUMBER,
    COD_USERCREA            VARCHAR2(50 BYTE),
    DATE_CREA               DATE,
    COD_EMPRESA             VARCHAR2(50 BYTE),
    COD_AUDITA              VARCHAR2(50 BYTE),
    FEC_AUDITA              DATE,
    PRIMARY KEY (ID_RRHH)
);

CREATE SEQUENCE ADMIN.SEQ_RRHH_DIALISIS
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;

CREATE TABLE ADMIN.HD_TDHOJADIARIA (
    ID_TDHOJADIARIA          NUMBER               NOT NULL,
    NUM_FICHAE               VARCHAR2(50 BYTE),
    NUM_CITACION             NUMBER,
    AD_ID_ADMISION           NUMBER,
    NUM_PESOSECO             NUMBER,
    NUM_HDPESOANTERIOR       NUMBER,
    NUM_PESOPREDIALISIS      NUMBER,
    NUM_INTERDIALISIS        NUMBER,
    NUM_UFPROGRAMADA         NUMBER,
    NUM_PESOPOSTDIALISIS     NUMBER,
    NUM_PESOINTERDIALISIS    NUMBER,
    USR_CREA                 VARCHAR2(50 BYTE),
    FEC_CREA                 DATE,
    USR_AUDITA               VARCHAR2(50 BYTE),
    FEC_AUDITA               DATE,
    NUM_ALZAINTERDIALISIS    NUMBER,
    TXTACCESOVAS_1           VARCHAR2(150 BYTE),
    NUM_DIASVAS_1            NUMBER,
    TXTACCESOVAS_2           VARCHAR2(150 BYTE),
    NUM_DIASVAS_2            NUMBER,
    NUM_TROCAR_ARTERIAL      NUMBER,
    NUM_TROCAR_VENOSO        NUMBER,
    NUM_HEPARINA_INICIO      NUMBER,
    NUM_HEPARINA_MAN         NUMBER,
    NUM_QT                   VARCHAR2(50 BYTE),
    NUM_QB                   NUMBER,
    NUM_QD                   NUMBER,
    NUM_UFMAX                NUMBER,
    NUM_K                    VARCHAR2(50 BYTE),
    TXT_OBSMEDICAS           VARCHAR2(500 BYTE),
    TXT_ENFERMERIA           VARCHAR2(500 BYTE),
    NUM_CI_FILTRO            NUMBER,
    NUM_CI_ARTERIAL          NUMBER,
    NUM_CI_VENOSA            NUMBER,
    NUM_PS_FILTRO            NUMBER,
    NUM_PS_ARTERIAL          VARCHAR2(50 BYTE),
    NUM_PS_VENOSO            NUMBER,
    TXT_TESTPOTENCIA         VARCHAR2(500 BYTE),
    NUM_USO_FILTRO           NUMBER,
    NUM_V_RESIDUAL           NUMBER,
    NUM_V_ARTERIAL           NUMBER,
    NUM_V_VENOSA             NUMBER,
    NUM_NA                   NUMBER,
    NUM_CONCENTRADO          VARCHAR2(500 BYTE),
    ID_RMDIALISIS            NUMBER,
    IND_PACIENTE_CORRECTO    NUMBER,
    IND_CLINEAS              NUMBER,
    IND_CFILTRO              NUMBER,
    NUM_T_MONITOR            VARCHAR2(30 BYTE),
    NUM_CONDUCTIVIDAD        NUMBER,
    NUM_TEST_RESIDUOS        NUMBER,
    IND_HIPOTENSION          NUMBER,
    IND_CALOFRIO             NUMBER,
    IND_FIEBRE               NUMBER,
    IND_ICVASCULAR           NUMBER,
    IND_BACTEREMIA           NUMBER,
    IND_HEPATITIS_B          NUMBER,
    IND_HEPATITIS_C          NUMBER,
    IND_MDPROCEDIMIENTO      NUMBER,
    ID_TIPOVIA               NUMBER,
    DATE_REALIZAHD           DATE,
    DATE_FHEGRESO            DATE,
    IND_R_RFIBRAS            NUMBER(5),
    IND_C_RFIBRAS            NUMBER(5),
    IND_R_PIROGENOS          NUMBER(5),
    FEC_DIASVAS_1            DATE,
    FEC_DIASVAS_2            DATE,
    NUM_TOTALUFCONSEGIDA     NUMBER,
    NUM_VOLSANGREACOMULADA   NUMBER,
    IND_DESIFCACCIONMAQUINA  NUMBER,
    IND_DIALIZADORDIAL       NUMBER,
    IND_HDESTADO             NUMBER,
    NUM_KT_V                 NUMBER,
    TXTUFACOMULADA_UM        NUMBER               DEFAULT 0,
    NUM_UFPROGRAMADA_UM      NUMBER               DEFAULT 0,
    NUM_TOTALUFCONSEGIDA_UM  NUMBER               DEFAULT 0,
    NUM_UFMAX_UM             NUMBER               DEFAULT 0,
    PRIMARY KEY (ID_TDHOJADIARIA)
);

CREATE TABLE ADMIN.HD_TDSIGNOSVITALES (
    ID_TDSIGNOSVITALES   NUMBER NOT NULL,
    ID_TDHOJADIARIA      NUMBER,
    DATE_HORA            DATE,
    NUM_PARTERIAL_S      VARCHAR2(50 BYTE),
    NUM_PULSO            NUMBER,
    NUM_TMONITOR         VARCHAR2(50 BYTE),
    NUM_QBPROG           NUMBER,
    NUM_QBEFEC           NUMBER,
    NUM_PA               NUMBER,
    NUM_PV               NUMBER,
    NUM_PTM              NUMBER,
    NUM_COND             NUMBER,
    NUM_UFH              NUMBER,
    NUM_TAZAUFH          NUMBER,
    TXT_INGRESO          VARCHAR2(50 BYTE),
    TXTOBSERVACIONES     VARCHAR2(300 BYTE),
    USR_CREA             VARCHAR2(50 BYTE),
    DATE_CREA            DATE,
    IND_ESTADO           NUMBER,
    NUM_PARTERIAL_D      VARCHAR2(50 BYTE),
    IND_TOMASIGNO        NUMBER,
    NUM_UFACOMULADA      NUMBER,
    COD_AUDITA           VARCHAR2(50 BYTE),
    DATE_AUDITA          DATE,
    NUM_TPACIENTE        NUMBER,
    NUM_UFACOMULADA_UM   NUMBER DEFAULT 0,
    NUM_UFPROGRAMADA_UM  NUMBER DEFAULT 0,
    PRIMARY KEY (ID_TDSIGNOSVITALES)
);

CREATE TABLE ADMIN.HD_TINGRESO (
    ID_NUMINGRESO      NUMBER,
    NUM_FICHAE         NUMBER,
    ID_SIC             NUMBER,
    COD_EMPRESA        VARCHAR2(10 BYTE),
    COD_USRCREA        VARCHAR2(10 BYTE),
    FEC_CREA           DATE,
    IND_ESTADO         NUMBER,
    FEC_INGRESO        DATE,
    DATE_EGRESO        DATE,
    ID_ESTADOHD        NUMBER,
    DATE_HISTOINGRESO  DATE,
    FEC_AUDITA         DATE,
    COD_AUDITA         VARCHAR2(50 BYTE),
    ID_EGRESO          NUMBER,
    PRIMARY KEY (ID_NUMINGRESO)
);

CREATE TABLE ADMIN.HD_TPRODIALISIS (
    ID_TPRODIALISIS     INTEGER,
    DATE_TPROINICIO     DATE,
    DATE_TPROFINAL      DATE,
    COD_HDACTIVIDAD     NUMBER,
    IND_ESTADO          NUMBER,
    NUM_FICHAE          VARCHAR2(50 BYTE),
    PRIMARY KEY (ID_TPRODIALISIS)
);

CREATE TABLE ADMIN.HD_TSISCORECION (
    ID_TCORECION        NUMBER                       NOT NULL,
    COD_TLLAVE          VARCHAR2(100 BYTE)           NOT NULL,
    PA_ID_PROCARCH      NUMBER,
    AD_ACTIVA           NUMBER,
    IND_ESTADO          NUMBER,
    COD_RUTPRO          VARCHAR2(100 BYTE),
    COD_CREA            VARCHAR2(50 BYTE),
    DATE_CREA           DATE,
    DATE_INICIO         DATE,
    DATE_FINAL          DATE,
    ID_TDHOJADIARIA     NUMBER,
    TXT_OBSERVACION     VARCHAR2(500 BYTE),
    COD_EMPRESA         VARCHAR2(50 BYTE),
    COD_CORRECEMP       VARCHAR2(50 BYTE),
    COD_DIGVER          VARCHAR2(5 BYTE),
    COD_AUDITA          VARCHAR2(50 BYTE),
    FEC_AUDITA          DATE,
    COD_TIME            VARCHAR2(150 BYTE),
    PRIMARY KEY (ID_TCORECION)
);


CREATE TABLE ADMIN.HD_TURNODIALISIS (
    ID_TURNODIALISIS    NUMBER NOT NULL,
    ID_TURNOSXDIAS      NUMBER,
    ID_NDIA             NUMBER,
    ID_RMDIALISIS       NUMBER,
    COD_EMPRESA         VARCHAR2(50 BYTE),
    IND_ESTADO          NUMBER,
    COD_USRCREA         VARCHAR2(50 BYTE),
    DATE_CREA           DATE,
    COD_AUDITA          VARCHAR2(50 BYTE),
    DATE_AUDITA         DATE,
    PRIMARY KEY (ID_TURNODIALISIS)
);


CREATE TABLE ADMIN.HD_TURNOS (
    ID_TURNO            NUMBER NOT NULL,
    TXT_TURNO           VARCHAR2(50 BYTE),
    IND_ESTADO          NUMBER,
    TXT_TURNOCORTO      VARCHAR2(50 BYTE),
    PRIMARY KEY (ID_TURNO)
);

CREATE TABLE ADMIN.HD_TURNOSXDIAS(
    HD_TURNOSXDIAS      NUMBER NOT NULL,
    ID_TURNO            NUMBER,
    ID_NDIA             NUMBER,
    IND_ESTADO          NUMBER,
    PRIMARY KEY (HD_TURNOSXDIAS)
);
COMMIT;
/

-- RECURSO HUMANO --


















-- INICIO DE PROCEDIMIENTOS ALMACENADOS
CREATE OR REPLACE PACKAGE ADMIN.PROCE_GESTION_DIALISIS AS
    PROCEDURE LOAD_DATA_LISTA_RRHH(
        V_COD_EMPRESA               IN VARCHAR2, 
        V_FIRST                     IN VARCHAR2,
        C_RESULT_RRHH               OUT SYS_REFCURSOR,
        C_LOGS                      OUT SYS_REFCURSOR
    );
    PROCEDURE  DATA_VALIDA_PROFESIONAL (
        V_COD_EMPRESA               IN VARCHAR,
        V_RUT_PROFESIONAL           IN VARCHAR,
        P_INFO_PROFESIONAL          OUT SYS_REFCURSOR,
        P_RETURN_LOGS               OUT SYS_REFCURSOR
    );
END PROCE_GESTION_DIALISIS;
/
CREATE OR REPLACE PACKAGE BODY ADMIN.PROCE_GESTION_DIALISIS AS
    PROCEDURE LOAD_DATA_LISTA_RRHH(
        V_COD_EMPRESA               IN VARCHAR2, 
        V_FIRST                     IN VARCHAR2,
        C_RESULT_RRHH               OUT SYS_REFCURSOR,
        C_LOGS                      OUT SYS_REFCURSOR
    ) IS

    BEGIN
        OPEN C_RESULT_RRHH FOR
        SELECT
            A.ID_PROFESIONAL                                                                                                        AS ID_PRO, 
            A.COD_RUTPRO,  
            A.COD_DIGVER                                                                                                            AS COD_DIGVER,
            DECODE (C.IND_TIPOATENCION,
            '01','slc_medico',
            '15','slc_medico',
            '02','slc_enfermeria',
            '12','slc_tecpara','no_info')                                                                                           AS HTML_OUT,
            UPPER(A.NOM_APEPAT)||' ' ||UPPER(A.NOM_APEMAT)||' ' ||UPPER(A.NOM_NOMBRE)                                               AS NOM_PROFE,
            C.DES_TIPOATENCION                                                                                                      AS DES_TIPOATENCION,
            B.COD_TPROFE                                                                                                            AS COD_TPROFE,
            B.NOM_TPROFE                                                                                                            AS NOM_TPROFE,
            C.IND_TIPOATENCION                                                                                                      AS IND_TIPOATENCION
        FROM 
            ADMIN.GG_TPROFESIONAL       A,
            ADMIN.GG_TPROFESION         B,
            ADMIN.AP_TTIPOATENCION      C,
            ADMIN.AP_TPROFXESTABL       D,
            ADMIN.HD_RRHHDIALISIS       H
        WHERE 
                A.IND_ESTADO                                 =  'V'
            AND D.IND_ESTADO                                 =  'V'
            AND A.COD_TPROFE                                 =  B.COD_TPROFE
            AND B.IND_TIPOATENCION                           =  C.IND_TIPOATENCION
            AND A.COD_RUTPRO                                 =  D.COD_RUTPRO
            AND D.COD_EMPRESA                                IN (V_COD_EMPRESA)
            AND H.COD_RUTPRO                                 =  A.COD_RUTPRO
            AND H.IND_ESTADO                                 IN (1)
        ORDER BY C.IND_TIPOATENCION, A.NOM_APEPAT;
        
    END;

PROCEDURE  DATA_VALIDA_PROFESIONAL (
    V_COD_EMPRESA               IN VARCHAR,
    V_RUT_PROFESIONAL           IN VARCHAR,
    P_INFO_PROFESIONAL          OUT SYS_REFCURSOR,
    P_RETURN_LOGS               OUT SYS_REFCURSOR
) IS

BEGIN
    OPEN P_RETURN_LOGS FOR 
    SELECT 
        H.ID_RRHH, 
        H.COD_RUTPRO, 
        H.ID_PROFESIONAL, 
        H.IND_ESTADO, 
        H.COD_USERCREA, 
        H.DATE_CREA, 
        H.COD_EMPRESA, 
        H.COD_AUDITA, 
        H.FEC_AUDITA
    FROM 
        ADMIN.HD_RRHHDIALISIS H
    WHERE
        H.COD_EMPRESA IN (V_COD_EMPRESA)
        AND
        H.IND_ESTADO IN (1)
        AND
        H.COD_RUTPRO IN  (V_RUT_PROFESIONAL);
        
    OPEN P_INFO_PROFESIONAL FOR 
    SELECT 
        A.COD_RUTPRO,  
        A.ID_PROFESIONAL                                                                   AS ID_PRO,
        A.COD_DIGVER                                                                       AS COD_DIGVER,
        UPPER(A.NOM_APEPAT)||' ' ||UPPER(A.NOM_APEMAT)||' ' ||UPPER(A.NOM_NOMBRE)          AS NOM_PROFE,
        C.DES_TIPOATENCION                                                                 AS DES_TIPOATENCION,
        B.COD_TPROFE                                                                       AS COD_TPROFE,
        B.NOM_TPROFE                                                                       AS NOM_TPROFE,
        C.IND_TIPOATENCION                                                                 AS IND_TIPOATENCION
    FROM 
        ADMIN.GG_TPROFESIONAL       A,
        ADMIN.GG_TPROFESION         B,
        ADMIN.AP_TTIPOATENCION      C,
        ADMIN.AP_TPROFXESTABL       D
    WHERE 
        A.IND_ESTADO                    IN  ('V')
        AND D.IND_ESTADO                IN  ('V')
        AND A.COD_TPROFE                =   B.COD_TPROFE
        AND B.IND_TIPOATENCION          =   C.IND_TIPOATENCION
        AND A.COD_RUTPRO                =   D.COD_RUTPRO
        AND D.COD_EMPRESA               IN  (V_COD_EMPRESA)
        AND A.COD_RUTPRO                IN  (V_RUT_PROFESIONAL) 
    ORDER BY 
        C.IND_TIPOATENCION, A.NOM_APEPAT;
END;

END PROCE_GESTION_DIALISIS;
/







COMMIT;
/