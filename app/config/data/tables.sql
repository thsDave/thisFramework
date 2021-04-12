/*
----------------------------------------
|         CREACIÓN Y SELECCION         |
----------------------------------------
*/

DROP DATABASE IF EXISTS `db_thisframework`;

CREATE DATABASE IF NOT EXISTS `db_thisframework` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `db_thisframework`;

/*
----------------------------------------
|          TABLAS PRINCIPALES          |
----------------------------------------
*/


/*TABLA Niveles de Usuario*/

CREATE TABLE IF NOT EXISTS tbl_levels(
  idlvl 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  level 	VARCHAR(20) NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA Estados */

CREATE TABLE IF NOT EXISTS tbl_states(
	idstate		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	state 		VARCHAR(25) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Fotos de Perfil*/

CREATE TABLE IF NOT EXISTS tbl_profilepics(
	idpic		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name		VARCHAR(15) NOT NULL,
	format		VARCHAR(12) NOT NULL,
	picture		BLOB NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Usuarios*/

CREATE TABLE IF NOT EXISTS tbl_users(
	iduser			INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name 			VARCHAR(45) NOT NULL,
	idlvl 			INT NOT NULL,
	email 			VARCHAR(70) NOT NULL,
	pass			VARCHAR(100) NOT NULL,
	position		VARCHAR(70) NOT NULL,
	token 			VARCHAR(70) NULL,
	tokendate 		DATETIME NULL,
	registermail	INT NOT NULL DEFAULT 0,
    idpic			INT NOT NULL DEFAULT 1,
    idstate			INT NOT NULL,

	CONSTRAINT FK_users_idlvl FOREIGN KEY (idlvl) REFERENCES tbl_levels (idlvl),
    CONSTRAINT FK_users_idpic FOREIGN KEY (idpic) REFERENCES tbl_profilepics (idpic),
    CONSTRAINT FK_users_idstate FOREIGN KEY (idstate) REFERENCES tbl_states (idstate)

)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Cookies*/

CREATE TABLE IF NOT EXISTS tbl_cookies(
	email			VARCHAR(60) NOT NULL,
	pass			VARCHAR(60) NOT NULL,
    sessiontoken	VARCHAR(125) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Comentarios*/

CREATE TABLE IF NOT EXISTS tbl_comments(
	idcomment	INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    iduser		INT NOT NULL,
    comment		VARCHAR(200) NOT NULL,
    dcomment	DATE NOT NULL,
    tcomment	TIME NOT NULL,

    CONSTRAINT FK_comments_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Soporte técnico*/

CREATE TABLE IF NOT EXISTS tbl_supports(
	idsupport	INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    iduser		INT NOT NULL,
    subject		VARCHAR(100) NOT NULL,
    mssg		VARCHAR(2000) NOT NULL,
    response	VARCHAR(2000) NOT NULL,
    sendmail	BOOLEAN NOT NULL,
    idstate 	INT NOT NULL,

    CONSTRAINT FK_supports_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE,
    CONSTRAINT FK_supports_idstate FOREIGN KEY (idstate) REFERENCES tbl_states (idstate)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Registros de Entradas de usuarios */

CREATE TABLE IF NOT EXISTS tbl_inputs(
	idinput		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    iduser		INT NOT NULL,
    indate		DATETIME NOT NULL DEFAULT NOW(),

    CONSTRAINT FK_inputs_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Registros de salidas */

CREATE TABLE IF NOT EXISTS tbl_outputs(
	idoutput	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    iduser		INT NOT NULL,
    outdate		DATETIME NOT NULL DEFAULT NOW(),

    CONSTRAINT FK_outputs_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Registros de cron.php */

CREATE TABLE IF NOT EXISTS tbl_logscron(
	idlog		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idstate 	INT NOT NULL,
    message		VARCHAR(100) NOT NULL,

    CONSTRAINT FK_logscron_idstate FOREIGN KEY (idstate) REFERENCES tbl_states (idstate)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;