/* Vistas para datatables */

-- tbl_status
CREATE VIEW v_status AS SELECT idstatus, status, timestamp FROM tbl_status;

-- tbl_countries
CREATE VIEW v_countries AS SELECT idcountry, country, badge, isocode, idstatus, timestamp FROM tbl_countries;

-- tbl_levels
CREATE VIEW v_levels AS SELECT idlvl, level, alias, timestamp FROM tbl_levels;

-- tbl_languages
CREATE VIEW v_languages AS SELECT idlang, language, lancode, lanicon, idstatus, timestamp FROM tbl_languages;

-- tbl_users
CREATE VIEW v_users AS SELECT iduser, name, idlvl, email, pass, token, tokendate, registertype, registermail, forgetpass, idlang, idpic, idstatus, idcountry, timestamp FROM tbl_users;

-- tbl_cookies
CREATE VIEW v_cookies AS SELECT email, pass, sessiontoken, timestamp FROM tbl_cookies;

-- tbl_supports
CREATE VIEW v_supports AS SELECT idsupport, iduser, subject, mssg, response, sendmail, idstatus, timestamp FROM tbl_supports;

-- tbl_logscron
CREATE VIEW v_logscron AS SELECT idlog, idstatus, message, timestamp FROM tbl_logscron;
