/*
-----------------------------------------
|       PROCEDIMIENTOS ALMACENADOS      |
-----------------------------------------
*/

-- USE `db_skeleton`;

DROP PROCEDURE IF EXISTS sp_getlvl;
DELIMITER //
CREATE PROCEDURE sp_getlvl( _id INT, _idstatus INT )
BEGIN
	SELECT
		n.level
	FROM
		tbl_users u
	INNER JOIN
		tbl_levels n ON u.idlvl = n.idlvl
	WHERE
		u.iduser = _id AND idstatus = _idstatus;
END //


DROP PROCEDURE IF EXISTS sp_userinfo;
DELIMITER //
CREATE PROCEDURE sp_userinfo( _id INT )
BEGIN
	SELECT
		u.iduser,
		u.name,
        u.email,
		l.level,
		l.alias,
        u.idlvl,
        u.idlang,
        i.lancode,
        i.lanicon,
        p.picture,
        e.btbadge,
        e.status,
        u.idstatus,
        u.idcountry,
        c.country,
        DATE_FORMAT(u.created_at, '%d/%m/%Y | %H:%m:%s') AS 'created_at',
        DATE_FORMAT(u.updated_at, '%d/%m/%Y | %H:%m:%s') AS 'updated_at',
        DATE_FORMAT(u.deleted_at, '%d/%m/%Y | %H:%m:%s') AS 'deleted_at'
	FROM
		tbl_users u
	INNER JOIN
		tbl_levels l ON u.idlvl = l.idlvl
	INNER JOIN
		tbl_languages i ON u.idlang = i.idlang
	INNER JOIN
		tbl_profilepics p ON u.idpic = p.idpic
	INNER JOIN
		tbl_status e ON u.idstatus = e.idstatus
	INNER JOIN
		tbl_countries c ON u.idcountry = c.idcountry
	WHERE
		u.iduser = _id;
END //


DROP PROCEDURE IF EXISTS sp_updtuser;
DELIMITER //
CREATE PROCEDURE sp_updtuser(
    _name 		VARCHAR(45),
    _level 		INT,
    _lang		INT,
    _status 	INT,
    _country	INT,
    _iduser		INT
)
BEGIN
	UPDATE
		tbl_users
	SET
		name = _name,
        idlvl = _level,
        idlang = _lang,
        idstatus = _status,
        idcountry = _country,
        updated_at = NOW()
	WHERE
		iduser = _iduser;
END //


DROP PROCEDURE IF EXISTS sp_userlist;
DELIMITER //
CREATE PROCEDURE sp_userlist( _idlvl INT, _idcountry INT )
BEGIN
	DECLARE _lvl INT;

	IF _idlvl <> 1 THEN
		SET _lvl = _idlvl;
	ELSE
		SET _lvl = 0;
	END IF;

	SELECT
		u.iduser,
		u.name,
		u.email,
        i.language,
        n.level,
        n.alias,
        u.registertype,
        s.btbadge,
        s.status,
        c.idcountry,
        c.country,
        DATE_FORMAT(u.created_at, '%d/%m/%Y | %H:%m:%s') AS 'created_at',
        DATE_FORMAT(u.updated_at, '%d/%m/%Y | %H:%m:%s') AS 'updated_at',
        DATE_FORMAT(u.deleted_at, '%d/%m/%Y | %H:%m:%s') AS 'deleted_at'
	FROM
		tbl_users u
	INNER JOIN
		tbl_countries c ON u.idcountry = c.idcountry
	INNER JOIN
		tbl_languages i ON u.idlang = i.idlang
	INNER JOIN
		tbl_status s ON u.idstatus = s.idstatus
	INNER JOIN
		tbl_levels n ON u.idlvl = n.idlvl
	WHERE
		IF(_lvl <> 0, c.idcountry = _idcountry, c.idcountry);
END //


DROP PROCEDURE IF EXISTS sp_useregister;
DELIMITER //
CREATE PROCEDURE sp_useregister(
	_name			VARCHAR(45),
	_email			VARCHAR(70),
	_pass			VARCHAR(100),
	_lang 			INT,
	_level  		INT,
	_mailregister	INT,
	_status			INT,
	_accesstype 	VARCHAR(8),
	_country 		INT
)
BEGIN
	INSERT INTO
		`tbl_users`
	VALUES
		(NULL, _name, _level, _email, _pass, NULL, NULL, _accesstype, _mailregister, 0, _lang, 1, _status, _country, NOW(), NOW(), NULL);
END //


DROP PROCEDURE IF EXISTS sp_newuser;
DELIMITER //
CREATE PROCEDURE sp_newuser(
	_name			VARCHAR(45),
	_email			VARCHAR(70),
	_pass			VARCHAR(100),
	_lang 			INT,
	_level  		INT,
	_country 		INT
)
BEGIN
	INSERT INTO
		`tbl_users`
	VALUES
		(NULL, _name, _level, _email, _pass, NULL, NULL, 'form', 1, 0, _lang, 1, 1, _country, NOW(), NOW(), NULL);

	SELECT LAST_INSERT_ID() AS iduser;
END //


DROP PROCEDURE IF EXISTS sp_supportrequest;
DELIMITER //
CREATE PROCEDURE sp_supportrequest(
	_iduser		INT,
    _subject	VARCHAR(100),
    _mssg		VARCHAR(2000)
)
BEGIN
	INSERT INTO tbl_supports VALUES (NULL, _iduser, _subject, _mssg, '', 0, 3, NOW(), NOW(), NULL);
END //


DROP PROCEDURE IF EXISTS sp_supportlist;
DELIMITER //
CREATE PROCEDURE sp_supportlist()
BEGIN
	SELECT
		s.idsupport,
		u.name,
		u.email,
        l.level,
		s.subject,
		s.mssg,
		CASE WHEN s.response = '' THEN 'Pendente de respuesta' ELSE s.response END AS 'response',
		s.idstatus,
		e.btbadge,
		e.status,
		DATE_FORMAT(s.created_at, '%d/%m/%Y | %H:%m:%s') AS 'created_at',
        DATE_FORMAT(s.updated_at, '%d/%m/%Y | %H:%m:%s') AS 'updated_at',
        DATE_FORMAT(s.deleted_at, '%d/%m/%Y | %H:%m:%s') AS 'deleted_at'
	FROM
		tbl_supports s
	INNER JOIN
		tbl_users u ON s.iduser = u.iduser
	INNER JOIN
		tbl_status e ON s.idstatus = e.idstatus
    INNER JOIN
		tbl_levels l ON u.idlvl = l.idlvl;
END //


DROP PROCEDURE IF EXISTS sp_getsupportreq;
DELIMITER //
CREATE PROCEDURE sp_getsupportreq( _id INT )
BEGIN
	SELECT
		s.idsupport,
		u.name,
		s.subject,
		s.mssg,
        s.response,
		DATE_FORMAT(s.created_at, '%d/%m/%Y | %H:%m:%s') AS 'created_at',
        DATE_FORMAT(s.updated_at, '%d/%m/%Y | %H:%m:%s') AS 'updated_at',
        DATE_FORMAT(s.deleted_at, '%d/%m/%Y | %H:%m:%s') AS 'deleted_at'
	FROM
		tbl_supports s
	INNER JOIN
		tbl_users u ON s.iduser = u.iduser
	WHERE
		s.idsupport = _id;
END //

DROP PROCEDURE IF EXISTS sp_savesupportres;
DELIMITER //
CREATE PROCEDURE sp_savesupportres( _id INT, _res VARCHAR(2000) )
BEGIN
	UPDATE tbl_supports SET response = _res, idstatus = 5, updated_at = NOW() WHERE idsupport = _id;
END //

DROP PROCEDURE IF EXISTS sp_datareport;
DELIMITER //
CREATE PROCEDURE sp_datareport( _option VARCHAR(15) )
BEGIN
	IF _option = 'users' THEN
		SELECT
			u.name AS 'nombre',
			u.email,
			u.position AS 'cargo',
			v.level AS 'permiso',
			u.registertype AS 'tipo_registro',
			l.language AS 'idioma',
			p.picture AS 'imagen',
			s.status AS 'estado',
			DATE_FORMAT(u.created_at, '%d/%m/%Y | %H:%m:%s') AS 'created_at',
	        DATE_FORMAT(u.updated_at, '%d/%m/%Y | %H:%m:%s') AS 'updated_at',
	        DATE_FORMAT(u.deleted_at, '%d/%m/%Y | %H:%m:%s') AS 'deleted_at'
		FROM
			tbl_users u
		INNER JOIN
			tbl_languages l ON u.idlang = l.idlang
		INNER JOIN
			tbl_profilepics p ON u.idpic = p.idpic
		INNER JOIN
			tbl_status s ON u.idstatus = s.idstatus
		INNER JOIN
			tbl_levels v ON u.idlvl = v.idlvl;
	ELSE IF _option = 'supports' THEN
			SELECT
				u.name AS 'nombre',
				u.email,
				u.position AS 'cargo',
				v.level AS 'permiso',
				u.registertype AS 'tipo_registro',
				l.language AS 'idioma',
				p.picture AS 'imagen',
				s.status AS 'estado',
                sp.subject AS 'asunto',
                sp.mssg AS 'mensaje',
                sp.response AS 'respuesta',
				DATE_FORMAT(sp.created_at, '%d/%m/%Y | %H:%m:%s') AS 'created_at',
		        DATE_FORMAT(sp.updated_at, '%d/%m/%Y | %H:%m:%s') AS 'updated_at',
		        DATE_FORMAT(sp.deleted_at, '%d/%m/%Y | %H:%m:%s') AS 'deleted_at'
			FROM
				tbl_supports sp
			INNER JOIN
				tbl_users u ON sp.iduser = u.iduser
			INNER JOIN
				tbl_languages l ON u.idlang = l.idlang
			INNER JOIN
				tbl_profilepics p ON u.idpic = p.idpic
			INNER JOIN
				tbl_status s ON sp.idstatus = s.idstatus
			INNER JOIN
				tbl_levels v ON u.idlvl = v.idlvl;
		END IF;
    END IF;
END //


DROP PROCEDURE IF EXISTS sp_insertcountry;
DELIMITER //
CREATE PROCEDURE sp_insertcountry(
	_country	VARCHAR(50),
    _badge		VARCHAR(50),
    _isocode	VARCHAR(5)
)
BEGIN
	INSERT INTO tbl_countries VALUES (NULL, _country, _badge, _isocode, 1, NOW(), NOW(), NULL);

	SELECT LAST_INSERT_ID() AS idcountry;
END //


DROP PROCEDURE IF EXISTS sp_insertlanguage;
DELIMITER //
CREATE PROCEDURE sp_insertlanguage(
	_language	VARCHAR(15),
    _lancode	VARCHAR(5),
    _lanicon	VARCHAR(60)
)
BEGIN
	INSERT INTO tbl_languages VALUES (NULL, _language, _lancode, _lanicon, 1, NOW(), NOW(), NULL);

	SELECT LAST_INSERT_ID() AS idlanguage;
END //


DROP PROCEDURE IF EXISTS sp_insertaction;
DELIMITER //
CREATE PROCEDURE sp_insertaction(
	_action		VARCHAR(50),
    _btbadge	VARCHAR(60)
)
BEGIN
	INSERT INTO tbl_actions VALUES (NULL, _action, _btbadge, 1, NOW());

	SELECT LAST_INSERT_ID() AS idaction;
END //