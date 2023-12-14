DELIMITER //

SET TIME_ZONE             = '-04:00';
ALTER DATABASE ADMIN CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
SET NAMES 'utf8mb4' COLLATE 'utf8mb4_spanish_ci';
SET collation_connection  = 'utf8mb4_spanish_ci';

CREATE TABLE ADMIN.SS_TEMPRESAS (
  ID_EMRESA               INT AUTO_INCREMENT PRIMARY KEY,  
  COD_EMPRESA             VARCHAR(5),
  NUM_RUTEMP              INT,
  COD_DVEMP               CHAR(1),
  NOM_RAZSOC              VARCHAR(40),
  NOM_DIRECC              VARCHAR(40),
  COD_COMUNA              VARCHAR(5),
  IND_CONSOLIDA           VARCHAR(2),
  IND_TIPEST              CHAR(1),
  COD_SERSAL              VARCHAR(5),
  IND_DEPMUN              CHAR(1),
  IND_URBRUR              CHAR(1),
  IND_RED                 CHAR(1),
  COD_USUARI              VARCHAR(60),
  IND_ESTADO              CHAR(1),
  FEC_AUDITA              DATE,
  COD_ESTABLRH            VARCHAR(5),
  NUM_TELEFONO            VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_spanish_ci; 


INSERT INTO ADMIN.SS_TEMPRESAS
(`ID_EMRESA`, `COD_EMPRESA`, `NUM_RUTEMP`, `COD_DVEMP`, `NOM_RAZSOC`, `NOM_DIRECC`, `COD_COMUNA`, `IND_CONSOLIDA`, `IND_TIPEST`, `COD_SERSAL`, `IND_DEPMUN`, `IND_URBRUR`, `IND_RED`, `COD_USUARI`, `IND_ESTADO`, `FEC_AUDITA`, `COD_ESTABLRH`, `NUM_TELEFONO`) VALUES
(1, '029',  NULL, NULL, 'HOME', NULL, NULL, NULL, NULL, '029',  NULL, NULL, NULL, NULL, 'V',  NULL, NULL, NULL),
(2, '800',  NULL, NULL, 'DIALISIS BAYO DIAL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V',  NULL, NULL, NULL),
(3, '801',  NULL, NULL, 'ANATOMIA PATOLOGIA', NULL, NULL, NULL, '', '029',  NULL, NULL, NULL, NULL, 'V',  NULL, NULL, NULL);

CREATE TABLE ADMIN.GG_TGPACTE (
  ID_INGRESO              INT AUTO_INCREMENT PRIMARY KEY,  
  COD_RUTPAC              INT(10),
  COD_DIGVER              CHAR(1),
  NOM_NOMBRE              VARCHAR(25),
  NOM_APEPAT              VARCHAR(20),
  NOM_APEMAT              VARCHAR(20),
  FEC_NACIMI              DATE,
  IND_TISEXO              CHAR(1),
  IND_ESTCIV              CHAR(1),
  NOM_NPADRE              VARCHAR(31),
  NOM_NMADRE              VARCHAR(31),
  NOM_PAREJA              VARCHAR(35),
  IND_GRUCRO              CHAR(1),
  IND_TIPPAC              CHAR(1),
  COD_GRUSAN              VARCHAR(10),
  IND_ETN                 VARCHAR(2),
  OCUPACION               VARCHAR(30),
  LUGAR_TRAB              VARCHAR(30),
  NOM_DIRECC              VARCHAR(100),
  COD_COMUNA              VARCHAR(15),
  IND_URBRUR              VARCHAR(1),
  COD_PAIS                VARCHAR(3),
  COD_RUTTIT              INT(10),
  COD_USRCREA             VARCHAR(60),
  FEC_USRCREA             DATE,
  COD_USUARI              VARCHAR(60),
  FEC_AUDITA              DATE,
  IND_ESTADO              CHAR(1),
  EMAIL                   VARCHAR(65),
  IND_FAX                 VARCHAR(10),
  IND_PERCETN             VARCHAR(2),
  COD_FACSAN              VARCHAR(2),
  IND_RECNAC              VARCHAR(1),
  COD_RUTREF              INT(10),
  COD_DIGREF              VARCHAR(1),
  IND_REFER               VARCHAR(1),
  IND_RUT                 VARCHAR(10),
  NUM_FICHAE              INT,
  IND_PERCAPITA           VARCHAR(1),
  EMP_PERCAPITA           VARCHAR(3),
  ALERGIAS                VARCHAR(30),
  CREDENCIAL              VARCHAR(10),
  INTG_PART_MULT          VARCHAR(1),
  NUM_TELEFO1_2           VARCHAR(12),
  NUM_TELEFO2_2           VARCHAR(12),
  NUM_CELULAR_2           VARCHAR(12),
  NUM_TELEFO1             VARCHAR(12),
  NUM_TELEFO2             VARCHAR(12),
  NUM_CELULAR             VARCHAR(12),
  COD_SISTEMA             VARCHAR(10),
  COD_SISTEMAUDITA        VARCHAR(10),
  COD_REGION              VARCHAR(2),
  COD_CIUDAD              VARCHAR(15),
  NUM_CASA                VARCHAR(15),
  COD_VIADIRECCION        VARCHAR(2),
  IND_CONDPRAIS           VARCHAR(1),
  NOM_RESTODIRECC         VARCHAR(300),
  CP_ID_CATOCUPAPAC       INT(2) DEFAULT 0,
  IND_NIVELINSTRUC        INT(1) DEFAULT 0,
  REP_LEGAL               VARCHAR(300),
  ID_EXTRANJERO           VARCHAR(15),
  IND_TIPOIDENTIFICA      INT(1) DEFAULT 0,
  IND_EXTRANJERO          INT(1) DEFAULT 0,
  NUM_IDENTIFICACION      VARCHAR(30),
  TIP_IDENTIFICACION      INT(1),
  FEC_VENCEPASPORT        DATE,
  IND_CORTEINTERA         INT(1) DEFAULT 0,
  COD_OCUPACION           VARCHAR(5),
  ID_FONASA               VARCHAR(30),
  FEC_IDFONASA            DATE,
  NOM_SOCIAL              VARCHAR(50),
  IND_TRANS               INT(1),
  IND_SENAME              INT(1) DEFAULT 0,
  COD_NACIONALIDAD        VARCHAR(3),
  EDAD_GESTA_SEMANA       DECIMAL(5,2),
  EDAD_GESTA_DIAS         DECIMAL(5,2),
  EDAD_CORREGIDA_SEMANA   DECIMAL(5,3),
  EDAD_CORREGIDA_DIAS     DECIMAL(5,2),
  IND_PREMATURO           INT(1),
  ID_OCUPACION            INT(2),
  IND_CATOCUPANEW         INT(1),
  IND_NIVEL_EDUCACIONAL   INT,
  IND_POBLACION_MIGRANTE  INT,
  PESO                    DECIMAL(3,1),
  TALLA                   INT,
  IMC                     DECIMAL(3,1),
  EDADGESTACIONAL         INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_spanish_ci; 

CREATE TABLE ADMIN.GU_TPERMISOS (
  PER_ID                INT NOT NULL AUTO_INCREMENT,
  PER_NOMBRE            VARCHAR(80),
  PER_ESTADO            INT(5),
  PRIMARY KEY           (PER_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_spanish_ci; 

INSERT INTO ADMIN.GU_TPERMISOS (`PER_ID`, `PER_NOMBRE`, `PER_ESTADO`) VALUES (1,'ADMIN',1);


CREATE TABLE ADMIN.GU_TMENUPRINCIPAL (
  MENP_ID               INT NOT NULL AUTO_INCREMENT,
  MENP_NOMBRE           VARCHAR(100),
  MENP_ESTADO           INT(5),
  MENP_RUTA             VARCHAR(80),
  MENP_IDPADRE          INT(5),
  MENP_TIPO             INT(5),
  MENP_ORDER            INT,
  MENP_FRAME            INT,
  MENP_ICON             VARCHAR(150),
  MENP_THEME            INT(1),
  MENP_ISTOKEN          INT(1),
  MENP_PARAM            VARCHAR(200),
  PRIMARY KEY           (MENP_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_spanish_ci; 

INSERT INTO ADMIN.GU_TMENUPRINCIPAL (MENP_ID,MENP_NOMBRE,MENP_ESTADO,MENP_RUTA,MENP_IDPADRE,MENP_TIPO,MENP_ORDER,MENP_FRAME,MENP_ICON,MENP_THEME,MENP_ISTOKEN,MENP_PARAM) 
VALUES (0, 'BDU PACIENTES', 1, 'app_defaul_bdu', 0, 1, NULL, 3, 'fa fa-id-card', 1, NULL, NULL); //


CREATE TABLE ADMIN.GU_TMENPTIENEPER (
  ID_MPTP               INT NOT NULL AUTO_INCREMENT,
  PER_ID                INT(5) NOT NULL,
  MENP_ID               INT(5) NOT NULL,
  IND_ESTADO            INT(1),
  PRIMARY KEY           (ID_MPTP)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_spanish_ci; 


CREATE TABLE ADMIN.FE_USERS (
  ID_UID                          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PID                             INT(10) UNSIGNED DEFAULT '0',
  TSTAMP                          INT(10) UNSIGNED DEFAULT '0',
  USERNAME                        VARCHAR(50) NOT NULL,
  PASSWORD                        VARCHAR(60) NOT NULL,
  USERGROUP                       TEXT,
  DISABLE                         TINYINT(3) UNSIGNED DEFAULT '0' NOT NULL,
  STARTTIME                       INT(10) UNSIGNED DEFAULT '0',
  ENDTIME                         INT(10) UNSIGNED DEFAULT '0',
  NAME                            VARCHAR(80) NOT NULL,
  FIRST_NAME                      VARCHAR(50) NOT NULL,
  MIDDLE_NAME                     VARCHAR(50) NOT NULL,
  LAST_NAME                       VARCHAR(50) NOT NULL,
  ADDRESS                         VARCHAR(255),
  TELEPHONE                       VARCHAR(20) NOT NULL,
  FAX                             VARCHAR(20),
  EMAIL                           VARCHAR(80),
  CRDATE                          INT(10) UNSIGNED DEFAULT '0',
  CRUSER_ID                       INT(10) UNSIGNED DEFAULT '0',
  LOCKTODOMAIN                    VARCHAR(50),
  DELETED                         TINYINT(3) UNSIGNED DEFAULT '0',
  UC                              BLOB,
  TITLE                           VARCHAR(40),
  ZIP                             VARCHAR(10),
  CITY                            VARCHAR(50),
  COUNTRY                         VARCHAR(40),
  WWW                             VARCHAR(80),
  COMPANY                         VARCHAR(80),
  IMAGE                           TEXT,
  TSCONFIG                        TEXT,
  FE_CRUSER_ID                    INT(10) UNSIGNED DEFAULT '0',
  LASTLOGIN                       INT(10) UNSIGNED DEFAULT '0',
  IS_ONLINE                       INT(10) UNSIGNED DEFAULT '0',
  TX_EXTBASE_TYPE                 VARCHAR(255),
  FELOGIN_REDIRECTPID             TEXT,
  FELOGIN_FORGOTHASH              VARCHAR(80),
  TX_CHCFORUM_AIM                 TEXT,
  TX_CHCFORUM_YAHOO               TEXT,
  TX_CHCFORUM_MSN                 TEXT,
  TX_CHCFORUM_CUSTOMIM            TEXT,
  MAILHASH                        VARCHAR(60),
  ACTIVATED_ON                    INT(10) UNSIGNED DEFAULT '0',
  PSEUDONYM                       VARCHAR(50),
  GENDER                          INT(10) UNSIGNED DEFAULT '0',
  DATE_OF_BIRTH                   INT(10) UNSIGNED DEFAULT '0',
  LANGUAGE                        CHAR(2),
  ZONE                            VARCHAR(45),
  STATIC_INFO_COUNTRY             CHAR(3),
  TIMEZONE                        FLOAT DEFAULT '0',
  DAYLIGHT                        TINYINT(3) UNSIGNED DEFAULT '0',
  MOBILEPHONE                     VARCHAR(20),
  GTC                             TINYINT(3) UNSIGNED DEFAULT '0',
  PRIVACY                         TINYINT(3) UNSIGNED DEFAULT '0',
  STATUS                          INT(10) UNSIGNED DEFAULT '0',
  BY_INVITATION                   TINYINT(3) UNSIGNED DEFAULT '0',
  COMMENTS                        TEXT,
  MODULE_SYS_DMAIL_HTML           TINYINT(3) UNSIGNED DEFAULT '0',
  MODULE_SYS_DMAIL_CATEGORY       INT(10) UNSIGNED DEFAULT '0',
  TX_EXTERNALIMPORTTUT_CODE       VARCHAR(10),
  TX_EXTERNALIMPORTTUT_DEPARTMEN  TEXT,
  TX_EXTERNALIMPORTTUT_HOLIDAYS   INT(10) UNSIGNED DEFAULT '0',
  TX_INTRANETSSAN_APELLIDOPATERN  TEXT,
  TX_INTRANETSSAN_APELLIDOMATERN  TEXT,
  TX_INTRANETSSAN_CLAVEUNICA      TEXT,
  TX_INTRANETSSAN_OBLIGACAMBIARC  INT(10) UNSIGNED DEFAULT '0',
  TX_INTRANETSSAN_PREFERENCIA     VARCHAR(255),
  TX_INTRANETSSAN_RUN             BIGINT(12),
  TX_INTRANETSSAN_DV              CHAR(1),
  PRIMARY KEY (ID_UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_spanish_ci; 


CREATE TABLE ADMIN.GU_TUSUTIENEPER (
  ID_UTP                        INT AUTO_INCREMENT PRIMARY KEY,  
  PER_ID                        INT(5),
  ID_UID                        INT(10),
  IND_ESTADO                    INT(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_spanish_ci; 



CREATE TABLE ADMIN.GU_TUSUXEMPRESA (
  ID_UXE                        INT AUTO_INCREMENT PRIMARY KEY,  
  ID_UID                        INT(10),
  COD_ESTABL                    INT(5),
  IND_ESTADO                    INT(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_spanish_ci; 





DELIMITER //