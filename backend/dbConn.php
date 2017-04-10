<?php

require_once __DIR__ . "/../config.php";

class dbConn
{
	protected static $_db_host = DB_HOST;
	protected static $_db_name = DB_NAME;
	protected static $_db_user = DB_USER;
	protected static $_db_pass = DB_PASS;
	protected static $_db;
	private static $_instance = null;
	private static $json;
	
	protected function __construct($json = false)
	{
		self::$json = $json;
		try {
			self::$_db = new PDO(
				"mysql:host=" . self::$_db_host . ";dbname=" . self::$_db_name,
				self::$_db_user, self::$_db_pass
			);
			self::$_db->exec("set names UTF-8");
		} catch (PDOException $e){
			error_reporting(0);
			header('HTTP/1.1 500 Internal Server Error', true, 500);
			$error = "Datenbank __construct() fehlgeschlagen.";
			if ($json)
			{
				header('Content-Type: application/json');
				die(json_encode(["error" => "$error", "error_code" => $e->getCode()]));
			}
			die("<h1>500 Internal Server Error</h1><span>$error</span>");
		}
		self::$_instance = $this;
		return true;
	}
	
	static public function getInstance($json = false)
	{
		if (self::$_instance === null)
			self::$_instance = new dbConn($json);
		return self::$_instance;
	}
	
	static public function getConnection($json = false)
	{
		self::getInstance($json);
		return self::getPdo();
	}
	
	protected static function getPdo()
	{
		if (is_null(self::$_db)) {
			die("Datenbankverbindung unmöglich.");
		}
		return self::$_db;
	}
	
	public function getLastInsertID() { return self::$_db->lastInsertId(); }
}