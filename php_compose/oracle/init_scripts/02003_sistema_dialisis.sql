ALTER SESSION SET CONTAINER         =  FREEPDB1;
ALTER SESSION SET CURRENT_SCHEMA    =  ADMIN;

---------------------------
-- FORMULARIO DE INGRESO --
---------------------------

CREATE SEQUENCE ADMIN.SEQ_HDIAL_PACIENTEDIALISIS
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;

CREATE TABLE ADMIN.HD_TINGRESO (
    ID_NUMINGRESO       NUMBER,
    NUM_FICHAE          NUMBER,
    ID_SIC              NUMBER,
    COD_EMPRESA         VARCHAR2(10 BYTE),
    COD_USRCREA         VARCHAR2(10 BYTE),
    FEC_CREA            DATE,
    IND_ESTADO          NUMBER,
    FEC_INGRESO         DATE,
    DATE_EGRESO         DATE,
    ID_ESTADOHD         NUMBER,
    DATE_HISTOINGRESO   DATE,
    FEC_AUDITA          DATE,
    COD_AUDITA          VARCHAR2(50 BYTE),
    ID_EGRESO           NUMBER,
    ID_INGRESOHD        NUMBER,
    PRIMARY KEY (ID_NUMINGRESO)
);

-- FORMULARIO DE INGRESO --
CREATE SEQUENCE ADMIN.SEQ_FORMULARIOINGRESO
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;

CREATE TABLE ADMIN.HD_FORMULARIOINGRESO(
    ID_INGRESOHD            NUMBER NOT NULL,
    NUM_FICHAE              NUMBER,
    TXT_NAME                VARCHAR2(512 BYTE),
    COD_CREA                VARCHAR2(50 BYTE),
    TXT_NOMBRECREA          VARCHAR2(500 BYTE),
    DATE_CREA               DATE,
    IND_ESTADO              NUMBER,
    COD_EMPRESA             VARCHAR2(50 BYTE),
    TXT_ANTECEDENTESQX      VARCHAR2(500 BYTE),
    IND_ANTALERGICOS        NUMBER(1),
    TXT_ALIMENTOS           VARCHAR2(500 BYTE),
    TXT_MEDICAMENTOS        VARCHAR2(500 BYTE),
    TXT_OTROS               VARCHAR2(500 BYTE),
    TXT_LLAMAR_URGENCIA     VARCHAR2(500 BYTE), 
    IND_GRUPO_SANGUINEO     VARCHAR2(10 BYTE), 
    IND_FACTOR_SANGRE       VARCHAR2(10 BYTE), 
    TXT_KILOGRAMOS          VARCHAR2(256 BYTE), 
    TXT_FRECUENCIAC         VARCHAR2(256 BYTE), 
    TXT_PDISTOLICA          VARCHAR2(256 BYTE), 
    TXT_PSISTOLICA          VARCHAR2(256 BYTE), 
    TXT_TALLA               VARCHAR2(256 BYTE), 
    TXT_MOVILIDAD           VARCHAR2(500 BYTE), 
    TXT_NUTRICION           VARCHAR2(500 BYTE), 
    TXT_GRADOCONCIENCIA     VARCHAR2(500 BYTE),
    TXT_ESTADOPIEL          VARCHAR2(500 BYTE), 
    TXT_CONJUNTIVAS         VARCHAR2(500 BYTE), 
    TXT_YUGULARES           VARCHAR2(500 BYTE), 
    TXT_EXTREMIDADES        VARCHAR2(500 BYTE), 
    TXT_FAV                 VARCHAR2(256 BYTE), 
    DATE_FAV                DATE,
    TXT_GOROTEX             VARCHAR2(256 BYTE), 
    DATE_GOROTEX            DATE,
    TXT_CATETER             VARCHAR2(256 BYTE), 
    DATE_CATETER            DATE,
    IND_DIURESIS            VARCHAR2(10 BYTE), 
    DATE_DIURESIS           DATE,
    TXT_HVC                 VARCHAR2(256 BYTE), 
    DATE_HVC                DATE,
    TXT_HIV                 VARCHAR2(256 BYTE), 
    DATE_HIV                DATE,
    TXT_HBSAG               VARCHAR2(256 BYTE), 
    DATE_HBSAG              DATE,
    TXT_QB                  VARCHAR2(256 BYTE), 
    TXT_HEPARINA_I          VARCHAR2(256 BYTE), 
    TXT_HEPARINA_M          VARCHAR2(256 BYTE), 
    TXT_1RA_DOSIS_HVB       VARCHAR2(256 BYTE), 
    TXT_QD                  VARCHAR2(256 BYTE), 
    TXT_BANO_KNA            VARCHAR2(256 BYTE), 
    TXT_2DA_DOSIS_HVB       VARCHAR2(256 BYTE), 
    TXT_PESOSECO            VARCHAR2(256 BYTE), 
    TXT_CONCENTRADO         VARCHAR2(256 BYTE), 
    TXT_3DA_DOSIS_HVB       VARCHAR2(256 BYTE), 
    TXT_REFUERZO_HVB        VARCHAR2(256 BYTE), 
    TXT_OBSERVACIONES       VARCHAR2(1000 BYTE),
    TXT_NAME_AUDITA         VARCHAR2(512 BYTE),
    COD_AUDITA              VARCHAR2(50 BYTE),
    DATE_AUDITA             DATE,
    PRIMARY KEY (ID_INGRESOHD)
);


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

CREATE TABLE ADMIN.HD_HISTOELIMINAHOJA (
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

CREATE SEQUENCE ADMIN.SEQ_HDIAL_IMEDICO
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;

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

CREATE SEQUENCE ADMIN.SEQ_HDIAL_NPACIENTEXCUPO
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;


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

CREATE SEQUENCE ADMIN.TRG_HDIAL_RPROFESIONALHEMO
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;

CREATE TABLE ADMIN.HD_RMDIALISIS (
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

COMMIT;
/

Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (1, '10-10-109104-6', 'MAQUINA DIALOG+EVOLUTION 710200C', 0, '227766', 
    NULL, '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (2, '10-10-109104-6', 'MAQUINA DIALOG+EVOLUTION 710200C', 0, '227803', 
    NULL, '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (3, '7SXARL32', 'MAQUINA N°1', 1, '7SXARL32', 
    NULL, '107', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (4, '7SXARL48', 'MAQUINA N°2', 1, '7SXARL48', 
    NULL, '107', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (5, '7SXARL43', 'MAQUINA N°3', 1, '7SXARL43', 
    NULL, '107', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (6, '7SXARL44', 'MAQUINA N°4', 1, '7SXARL44', 
    NULL, '107', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (7, '7SXARL41', 'MAQUINA N°5', 1, '7SXARL41', 
    NULL, '107', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (8, '7XSARL40', 'MAQUINA N°6', 1, '7XSARL40', 
    NULL, '107', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (9, '8V5AKW06', 'MAQUINA RESPALDO', 0, '8V5AKW06', 
    NULL, '107', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (10, '7SXARL49', 'MAQUINA N°1', 1, '7SXARL49', 
    NULL, '104', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (11, '7SXAL33', 'MAQUINA N°2', 1, '7SXAL33', 
    NULL, '104', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (12, '7SXAL51', 'MAQUINA N°3', 1, '7SXAL51', 
    NULL, '104', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (13, '7SXAL29', 'MAQUINA N°4', 1, '7SXAL29', 
    NULL, '104', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (14, '7SXAL34', 'MAQUINA N°5', 1, '7SXAL34', 
    NULL, '104', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (15, '7SXAL35', 'MAQUINA N°6', 1, '7SXAL35', 
    NULL, '104', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (16, '9V5AMA31', 'MAQUINA RESPALDO', 1, '9V5AMA31', 
    NULL, '104', 'RESPALDO');
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (18, '00000', 'MAQUINA SSAN 2', 1, '00000', 
    NULL, '029', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (19, '227767', 'MAQUINA 1', 1, '227767', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (20, '227854', 'MAQUINA 2', 1, '227854', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (21, '227856', 'MAQUINA 3', 1, '227856', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (22, '227855', 'MAQUINA 4', 1, '227855', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (23, '227765', 'MAQUINA 5', 1, '227765', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (24, '227763', 'MAQUINA 6 ', 1, '227763', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (25, '227801', 'MAQUINA 7', 1, '227801', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (26, '227760', 'MAQUINA 8', 1, '227760', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (28, '227764', 'MAQUINA 9', 1, '227764', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (29, '227796', 'MAQUINA 10', 1, '227796', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (30, '227803', 'MAQUINA 11', 1, '227803', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (31, '227849', 'MAQUINA 12', 1, '227849', 
    NULL, '106', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (17, '00000000', 'MAQUINA SSAN', 1, '00000', 
    NULL, '029', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (48, '9SXA1EEA', 'EQUIPO DE HEMODIALISIS N°1', 1, '9SXA1EEA', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (49, '9SXA1EEB', 'EQUIPO DE HEMODIALISIS N°2', 1, '9SXA1EEB', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (50, '9SXA1EEC', 'EQUIPO DE HEMODIALISIS N°3', 1, '9SXA1EEC', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (51, '9SXA1EED', 'EQUIPO DE HEMODIALISIS N°4', 1, '9SXA1EED', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (52, '9SXA1EE8', 'EQUIPO DE HEMODIALISIS N°5', 1, '9SXA1EE8', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (53, '9SXA1EE9', 'EQUIPO DE HEMODIALISIS N°6', 1, '9SXA1EE9', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (32, '9SXA0ZXA', 'EQUIPO DE HEMODIALISIS N°7', 1, '9SXA0ZXA', 
    '200', '100', 'FRESENIUS MEDICAL CARE ');
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (33, '9SXA0ZXB', 'EQUIPO DE HEMODIALISIS N°8', 1, '9SXA0ZXB', 
    '2020', '100', 'FRESENIUS MEDICAL CARE ');
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (34, '9SXA0ZXC', 'EQUIPO DE HEMODIALISIS N°9', 1, '9SXA0ZXC', 
    '2020', '100', 'FRESENIUS MEDICAL CARE ');
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (35, '9SXA0ZXD', 'EQUIPO DE HEMODIALISIS N°10', 1, '9SXA0ZXD', 
    '2020', '100', 'FRESENIUS MEDICAL CARE ');
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (36, '9SXA0ZXE', 'EQUIPO DE HEMODIALISIS N°11', 1, '9SXA0ZXE', 
    '2020', '100', 'FRESENIUS MEDICAL CARE ');
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (37, '9SXA0ZXF', 'EQUIPO DE HEMODIALISIS N°12', 1, '9SXA0ZXF', 
    '2020', '100', 'FRESENIUS MEDICAL CARE ');
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (38, '9SXA0ZXG', 'EQUIPO DE HEMODIALISIS N°13', 1, '9SXA0ZXG', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (39, '9SXA0ZXH', 'EQUIPO DE HEMODIALISIS N°14', 1, '9SXA0ZXH', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (40, '9SXA0ZXJ', 'EQUIPO DE HEMODIALISIS N°15', 1, '9SXA0ZXJ', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (41, '9SXA0ZXK', 'EQUIPO DE HEMODIALISIS N°16', 1, '9SXA0ZXK', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (42, '9SXA0ZXK', 'EQUIPO DE HEMODIALISIS N°17', 1, '9SXA0ZXK', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (43, '9SXA0ZXL', 'EQUIPO DE HEMODIALISIS N°17', 0, '9SXA0ZXL', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (44, '9SXA0ZXN', 'EQUIPO DE HEMODIALISIS N°18', 1, '9SXA0ZXN', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (45, '9SXA0ZXN', 'EQUIPO DE HEMODIALISIS N°18', 0, '9SXA0ZXN', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (46, '9SXA0ZWD', 'EQUIPO DE HEMODIALISIS N°R1', 1, '9SXA0ZWD', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (47, '9SXA0ZWR', 'EQUIPO DE HEMODIALISIS N°R2', 1, '9SXA0ZWR', 
    '2020', '100', NULL);
Insert into ADMIN.HD_RMDIALISIS
   (ID_RMDIALISIS, COD_RMDIALISIS, NOM_RMDIALISIS, IND_ESTADO, NUM_SERIE, 
    NUM_LORE, COD_EMPRESA, NOM_CORTO)
 Values
   (54, '5SXAED14', 'MONITOR - 5SXAED14 2015', 1, '5SXAED14', 
    NULL, '107', NULL);
COMMIT;

/

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

CREATE SEQUENCE ADMIN.SEQ_HDIAL_NUMHOJATRATAMIENTO
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;


CREATE SEQUENCE ADMIN.SEQ_HDIAL_TDSIGNOSVITALES
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;    

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

CREATE SEQUENCE ADMIN.SEQ_HDIAL_TURNODIALISIS
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;

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

CREATE SEQUENCE ADMIN.SEQ_CIE10XINGRESODIAL
    START WITH 0
    MAXVALUE 999999999999999999999999999
    MINVALUE 0
    NOCYCLE
    NOCACHE
    NOORDER;

CREATE TABLE ADMIN.TGCD_INGRESO_CIE_REL (
    ID_RELACION         NUMBER(20) NOT NULL,
    ID_INGRESO          NUMBER(20) NOT NULL,
    ID_DIAGNOSTICO      NUMBER(20) NOT NULL,
    FECHA_DIAGNOSTICO   DATE,
    IND_ESTADO          NUMBER(1),
    PRIMARY KEY         (ID_RELACION)
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
