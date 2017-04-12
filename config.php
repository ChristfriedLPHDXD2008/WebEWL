<?php

# Zeitzone und -format
date_default_timezone_set("Europe/Berlin");
define('DATETIME', 'Y-m-d H:i:s');

# Session
session_name("__SessID");
session_start();

# Verzeichnisse
define("__BACKEND__",	__DIR__ . "/backend");
define("__FRONTEND__",	__DIR__ . "/frontend");
define("__SECURE__",	__DIR__ . "/secure");
define("__STYLES__",	__DIR__ . "/styles/css");
define("__JSCRIPT__",	__DIR__ . "/js");

# Datenbank
require_once __SECURE__ . "/dbData.php";

# Seitentitel
define("TITLE",			"Pax et Bonum - Eine Welt Laden e.V.");
define("TITLE_ADMIN",	"Pax et Admin - Eine Welt Laden e.V.");

# CSS- und Javascript-Dateien
define("CSS_Bootstrap",	"bootstrap.css");
define("CSS_styles",	"stylesheet.css");
define("CSS_login",		"login.css");
define("CSS_admin",		"admin.css");
define("JS_jQuery",		"jquery-3.2.0.min.js");
define("JS_Bootstrap",	"bootstrap.min.js");
define("JS_fngrprnt",	"fingerprint2.min.js");
define("JS_javascript",	"javascript.js");
define("JS_login",		"login.js");
define("JS_admin",		"admin.js");

# Cookienamen und -konfiguration
define('SESS_UID',		'UID');
define('SESS_Username',	'username');
define('CTime',			time() + (60 * 60 * 24 * 30 * 3));
define('C_LogStr',		'__u_kLg');
define('Cs_UID',		'_uid');
define('Cs_FPH',		'_fph');

# Funktionen
function print_array($array) { echo "<pre>" . print_r($array, true) . "</pre>"; }
function decodetime($time) { return date("G:i", strtotime($time)); }