/*
-----------------------------------------
|       PROCEDIMIENTOS ALMACENADOS      |
-----------------------------------------
*/

USE `db_thisframework`;


DROP PROCEDURE IF EXISTS sp_getlvl;
DELIMITER //
CREATE PROCEDURE sp_getlvl( _id INT )
BEGIN
	SELECT
		n.level
	FROM
		tbl_users u
	INNER JOIN
		tbl_levels n ON u.idlvl = n.idlvl
	WHERE
		u.iduser = _id AND idstate = 1;
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
        u.position,
        p.picture,
        e.state
	FROM
		tbl_users u
	INNER JOIN
		tbl_levels l ON u.idlvl = l.idlvl
	INNER JOIN
		tbl_profilepics p ON u.idpic = p.idpic
	INNER JOIN
		tbl_states e ON u.idstate = e.idstate
	WHERE
		u.iduser = _id;
END //


DROP PROCEDURE IF EXISTS sp_updtuser;
DELIMITER //
CREATE PROCEDURE sp_updtuser(
    _name 		VARCHAR(45),
    _position	VARCHAR(70),
    _iduser		INT
)
BEGIN
	UPDATE
		tbl_users
	SET
		name = _name,
        position = _position
	WHERE
		iduser = _iduser;
END //


DROP PROCEDURE IF EXISTS sp_userlist;
DELIMITER //
CREATE PROCEDURE sp_userlist()
BEGIN
	SELECT
		u.iduser,
		u.name,
		u.email,
		u.position,
        n.level,
        s.state
	FROM
		tbl_users u
	INNER JOIN
		tbl_states s ON u.idstate = s.idstate
	INNER JOIN
		tbl_levels n ON u.idlvl = n.idlvl;
END //


DROP PROCEDURE IF EXISTS sp_useregister;
DELIMITER //
CREATE PROCEDURE sp_useregister(
	_name			VARCHAR(45),
	_email			VARCHAR(70),
	_pass			VARCHAR(100),
	_position		VARCHAR(70),
	_mailregister	INT,
	_state			INT
)
BEGIN
	INSERT INTO
		`tbl_users`
	VALUES
		(NULL, _name, 3, _email, _pass, _position, NULL, NULL, _mailregister, 1, _state);
END //


DROP PROCEDURE IF EXISTS sp_supportrequest;
DELIMITER //
CREATE PROCEDURE sp_supportrequest(
	_iduser		INT,
    _subject	VARCHAR(100),
    _mssg		VARCHAR(2000)
)
BEGIN
	INSERT INTO tbl_supports VALUES (NULL, _iduser, _subject, _mssg, '', 0, 5);
END //


DROP PROCEDURE IF EXISTS sp_supportlist;
DELIMITER //
CREATE PROCEDURE sp_supportlist()
BEGIN
	SELECT
		s.idsupport,
		u.name,
		u.email,
		u.position,
        l.level,
		s.subject,
		s.idstate,
		e.state
	FROM
		tbl_supports s
	INNER JOIN 
		tbl_users u ON s.iduser = u.iduser
	INNER JOIN
		tbl_states e ON s.idstate = e.idstate
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
        s.response
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
	UPDATE tbl_supports SET response = _res, idstate = 7 WHERE idsupport = _id;
END //