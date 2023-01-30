/*
----------------------------------------
|         CREACIÓN Y SELECCION         |
----------------------------------------
*/

-- DROP DATABASE IF EXISTS `db_skeleton`;

-- CREATE DATABASE IF NOT EXISTS `db_skeleton` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- USE `db_skeleton`;

/*
----------------------------------------
|          TABLAS PRINCIPALES          |
----------------------------------------
*/

/* TABLA Estados */

CREATE TABLE IF NOT EXISTS tbl_status(
	idstatus 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	status 		VARCHAR(25) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Paises*/

CREATE TABLE IF NOT EXISTS tbl_countries(
	idcountry	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	country 	VARCHAR(45) NULL,
	badge 		VARCHAR(35) NOT NULL,
	isocode 	VARCHAR(5) NOT NULL,
	idstatus  INT NOT NULL,

	CONSTRAINT FK_countries_idstatus FOREIGN KEY (idstatus) REFERENCES tbl_status (idstatus)

)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Niveles de Usuario*/

CREATE TABLE IF NOT EXISTS tbl_levels(
  idlvl 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  level 	VARCHAR(10) NULL,
  alias		VARCHAR(30) NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Fotos de Perfil*/

CREATE TABLE IF NOT EXISTS tbl_profilepics(
	idpic 		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name 			VARCHAR(15) NOT NULL,
	format 		VARCHAR(12) NOT NULL,
	picture 	BLOB NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA idiomas */

CREATE TABLE IF NOT EXISTS tbl_languages(
	idlang 		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	language	VARCHAR(15) NOT NULL,
	lancode		VARCHAR(3) NOT NULL,
	lanicon 	VARCHAR(15) NOT NULL,
	idstatus  INT NOT NULL,

	CONSTRAINT FK_languages_idstatus FOREIGN KEY (idstatus) REFERENCES tbl_status (idstatus)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Usuarios*/

CREATE TABLE IF NOT EXISTS tbl_users(
	iduser				INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name 					VARCHAR(45) NOT NULL,
	idlvl 				INT NOT NULL,
	email 				VARCHAR(70) NOT NULL,
	pass					VARCHAR(100) NOT NULL,
	token 				VARCHAR(70) NULL,
	tokendate 		DATETIME NULL,
	registertype 	VARCHAR(8) NOT NULL,
	registermail	INT NOT NULL DEFAULT 0,
	forgetpass		INT NOT NULL DEFAULT 0,
	idlang				INT NOT NULL,
  idpic					INT NOT NULL DEFAULT 1,
  idstatus			INT NOT NULL,
  idcountry 		INT NOT NULL,

	CONSTRAINT FK_users_idlvl FOREIGN KEY (idlvl) REFERENCES tbl_levels (idlvl),
	CONSTRAINT FK_users_idlang FOREIGN KEY (idlang) REFERENCES tbl_languages (idlang),
  CONSTRAINT FK_users_idpic FOREIGN KEY (idpic) REFERENCES tbl_profilepics (idpic),
  CONSTRAINT FK_users_idstatus FOREIGN KEY (idstatus) REFERENCES tbl_status (idstatus),
  CONSTRAINT FK_users_idcountry FOREIGN KEY (idcountry) REFERENCES tbl_countries (idcountry)

)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Cookies*/

CREATE TABLE IF NOT EXISTS tbl_cookies(
	email			VARCHAR(60) NOT NULL,
	pass			VARCHAR(60) NOT NULL,
  sessiontoken	VARCHAR(125) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Soporte técnico*/

CREATE TABLE IF NOT EXISTS tbl_supports(
	idsupport	INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  iduser		INT NOT NULL,
  subject		VARCHAR(100) NOT NULL,
  mssg			VARCHAR(2000) NOT NULL,
  response	VARCHAR(2000) NOT NULL,
  sendmail	BOOLEAN NOT NULL,
  idstatus 	INT NOT NULL,

  CONSTRAINT FK_supports_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE,
  CONSTRAINT FK_supports_idstatus FOREIGN KEY (idstatus) REFERENCES tbl_status (idstatus)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Historial de entradas de usuarios */

CREATE TABLE IF NOT EXISTS tbl_inputs(
	idinput		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iduser		INT NOT NULL,
  indate		DATETIME NOT NULL DEFAULT NOW(),

  CONSTRAINT FK_inputs_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Historial de salidas de usuarios */

CREATE TABLE IF NOT EXISTS tbl_outputs(
	idoutput	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iduser		INT NOT NULL,
  outdate		DATETIME NOT NULL DEFAULT NOW(),

	CONSTRAINT FK_outputs_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Registros de cron.php */

CREATE TABLE IF NOT EXISTS tbl_logscron(
	idlog			INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  idstatus 	INT NOT NULL,
  message		VARCHAR(100) NOT NULL,

  CONSTRAINT FK_logscron_idstatus FOREIGN KEY (idstatus) REFERENCES tbl_status (idstatus)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*
	Tabla de registro de bienvenida a nueva versión

	Esta tabla se usa para actualizar información del usuario al iniciar sesión
	en una nueva versión del sistema, el uso de esta tabla es opcional y ha sido creada
	para fines de seguimiento de usuarios.
*/

CREATE TABLE IF NOT EXISTS tbl_welcome(
	iduser				INT NOT NULL,
  infoprofile		TINYINT NOT NULL,
  dateinfo			DATE NOT NULL,
  welcome				TINYINT NOT NULL,
  datewelcome		DATE NULL,
  actionwelcome	VARCHAR(50) NULL,

  CONSTRAINT FK_welcome_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;