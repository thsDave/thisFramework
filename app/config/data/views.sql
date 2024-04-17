/*
----------------------------------
|       CREACIÓN DE VISTAS      |
---------------------------------
*/

-- USE `db_skeleton`;

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
		DATE_FORMAT(c.created_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'created_at',
		DATE_FORMAT(c.updated_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'updated_at',
		DATE_FORMAT(c.deleted_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'deleted_at',
		s.status,
		s.btbadge
	FROM
		tbl_countries c
	INNER JOIN
		tbl_status s ON c.idstatus = s.idstatus;

-- ---------------------------------- --
-- --------- [ tbl_status ] --------- --
-- ---------------------------------- --

CREATE VIEW v_status AS
	SELECT
		idstatus,
		status,
		btbadge,
		CASE WHEN showfield = 1 THEN 'showing' ELSE 'hidden' END AS 'showfield',
		DATE_FORMAT(created_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'created_at'
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
		DATE_FORMAT(l.created_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'created_at',
		DATE_FORMAT(l.updated_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'updated_at',
		DATE_FORMAT(l.deleted_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'deleted_at',
		s.status,
		s.btbadge
	FROM
		tbl_languages l
	INNER JOIN
		tbl_status s ON l.idstatus = s.idstatus;

-- ---------------------------------- --
-- --------- [ tbl_levels ] --------- --
-- ---------------------------------- --

CREATE VIEW v_levels AS
	SELECT
		idlvl,
		level,
		alias,
		CASE WHEN showfield = 1 THEN 'showing' ELSE 'hidden' END AS 'showfield',
		DATE_FORMAT(created_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'created_at'
	FROM
		tbl_levels;

-- ------------------------------------ --
-- --------- [ tbl_logs ] ------------- --
-- ------------------------------------ --

CREATE VIEW v_logs AS
	SELECT
		l.idlog,
		l.description,
		l.idaction,
		a.action,
		a.btbadge,
		l.iduser,
		u.name,
		u.email,
		DATE_FORMAT(l.created_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'created_at'
	FROM
		tbl_logs l
	INNER JOIN
		tbl_actions a ON l.idaction = a.idaction
	INNER JOIN
		tbl_users u ON l.iduser = u.iduser;

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
		DATE_FORMAT(p.created_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'created_at',
		s.status,
		s.btbadge
	FROM
		tbl_profilepics p
	INNER JOIN
		tbl_status s ON p.idstatus = s.idstatus;

-- --------------------------------- --
-- --------- [ tbl_users ] --------- --
-- --------------------------------- --

CREATE VIEW v_users AS
	SELECT
		u.iduser,
		u.name,
		u.idlvl,
		u.email,
		u.pass,
		u.token,
		u.tokendate,
        u.registertype,
        u.registermail,
        u.forgetpass,
        u.idlang,
        u.idpic,
        u.idstatus,
        u.idcountry,
        DATE_FORMAT(u.created_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'created_at',
		DATE_FORMAT(u.updated_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'updated_at',
		DATE_FORMAT(u.deleted_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'deleted_at',
        n.level,
        n.alias,
        i.language,
        s.status,
        s.btbadge,
        c.country
	FROM
		tbl_users u
	INNER JOIN
		tbl_countries c ON u.idcountry = c.idcountry
	INNER JOIN
		tbl_languages i ON u.idlang = i.idlang
	INNER JOIN
		tbl_status s ON u.idstatus = s.idstatus
	INNER JOIN
		tbl_levels n ON u.idlvl = n.idlvl;

-- ------------------------------------ --
-- --------- [ tbl_supports ] --------- --
-- ------------------------------------ --

CREATE VIEW v_supports AS
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
		DATE_FORMAT(s.created_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'created_at',
		DATE_FORMAT(s.updated_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'updated_at',
		DATE_FORMAT(s.deleted_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'deleted_at'
	FROM
		tbl_supports s
	INNER JOIN
		tbl_users u ON s.iduser = u.iduser
	INNER JOIN
		tbl_status e ON s.idstatus = e.idstatus
    INNER JOIN
		tbl_levels l ON u.idlvl = l.idlvl;

-- ---------------------------------- --
-- --------- [ tbl_actions ] --------- --
-- ---------------------------------- --

CREATE VIEW v_actions AS
	SELECT
		idaction,
		action,
		btbadge,
		CASE WHEN showfield = 1 THEN 'showing' ELSE 'hidden' END AS 'showfield',
		DATE_FORMAT(created_at, '📅 %d/%m/%Y ⌚ %H:%m:%s') AS 'created_at'
	FROM
		tbl_actions;