/*
----------------------------------
|       CREACIÓN DE VISTAS      |
---------------------------------
*/

-- USE `db_skeleton`;

-- ----------------------------------- --
-- --------- [ tbl_cookies ] --------- --
-- ----------------------------------- --

CREATE VIEW v_cookies AS
SELECT
	email,
	pass,
	sessiontoken,
	timestamp
FROM
	tbl_cookies;

-- ------------------------------------- --
-- --------- [ tbl_countries ] --------- --
-- ------------------------------------- --

CREATE VIEW v_countries AS
	SELECT
		c.idcountry,
		c.country,
		c.badge,
		c.isocode,
		c.idstatus,
		c.timestamp,
		s.status,
		s.btbadge
	FROM
		tbl_countries c
	INNER JOIN
		tbl_status s ON c.idstatus = s.idstatus
	WHERE
		c.idstatus <> 11;

-- ---------------------------------- --
-- --------- [ tbl_status ] --------- --
-- ---------------------------------- --

CREATE VIEW v_status AS
	SELECT
		idstatus,
		status,
		btbadge,
		timestamp
	FROM
		tbl_status;

-- ------------------------------------- --
-- --------- [ tbl_languages ] --------- --
-- ------------------------------------- --

CREATE VIEW v_languages AS
	SELECT
		l.idlang,
		l.language,
		l.lancode,
		l.lanicon,
		l.idstatus,
		l.timestamp,
		s.status,
		s.btbadge
	FROM
		tbl_languages l
	INNER JOIN
		tbl_status s ON l.idstatus = s.idstatus
	WHERE
		l.idstatus <> 11;

-- ---------------------------------- --
-- --------- [ tbl_levels ] --------- --
-- ---------------------------------- --

CREATE VIEW v_levels AS
	SELECT
		idlvl,
		level,
		alias,
		timestamp
	FROM
		tbl_levels;

-- ------------------------------------ --
-- --------- [ tbl_logscron ] --------- --
-- ------------------------------------ --

CREATE VIEW v_logscron AS
	SELECT
		idlog,
		idstatus,
		message,
		timestamp
	FROM
		tbl_logscron;

-- --------------------------------------- --
-- --------- [ tbl_profilepics ] --------- --
-- --------------------------------------- --

CREATE VIEW v_profilepics AS
	SELECT
		p.idpic,
		p.name,
		p.format,
		p.picture,
		p.idstatus,
		p.timestamp,
		s.status,
		s.btbadge
	FROM
		tbl_profilepics p
	INNER JOIN
		tbl_status s ON p.idstatus = s.idstatus
	WHERE
		p.idstatus <> 11;

-- --------------------------------- --
-- --------- [ tbl_users ] --------- --
-- --------------------------------- --

-- CREATE VIEW v_users AS SELECT u.iduser, u.name, u.idlvl, u.email, u.pass, u.token, u.tokendate, u.registertype, u.registermail, u.forgetpass, u.idlang, u.idpic, u.idstatus, u.idcountry, u.timestamp, s.status, s.btbadge FROM tbl_users u INNER JOIN tbl_status s ON u.idstatus = s.idstatus WHERE u.idstatus <> 11;

CREATE VIEW v_users AS
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
        u.timestamp
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
		u.idstatus <> 11;

-- ------------------------------------ --
-- --------- [ tbl_supports ] --------- --
-- ------------------------------------ --

-- CREATE VIEW v_supports AS SELECT sp.idsupport, sp.iduser, sp.subject, sp.mssg, sp.response, sp.sendmail, sp.idstatus, sp.timestamp, s.status, s.btbadge FROM tbl_supports sp INNER JOIN tbl_status s ON sp.idstatus = s.idstatus WHERE sp.idstatus <> 11;

CREATE VIEW v_supports AS
	SELECT
		s.idsupport,
		u.name,
		u.email,
        l.level,
		s.subject,
		s.mssg,
		s.response,
		s.idstatus,
		e.btbadge,
		e.status,
		s.timestamp
	FROM
		tbl_supports s
	INNER JOIN
		tbl_users u ON s.iduser = u.iduser
	INNER JOIN
		tbl_status e ON s.idstatus = e.idstatus
    INNER JOIN
		tbl_levels l ON u.idlvl = l.idlvl
	WHERE
		u.idstatus <> 11;
