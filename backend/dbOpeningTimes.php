<?php

class dbOpeningTimes extends dbConn
{
	private static $_instance = null;
	
	public function __construct()
	{
		parent::__construct();
		self::$_instance = $this;
	}
	
	static public function getInstance()
	{
		if (self::$_instance === null)
			self::$_instance = new self;
		return self::$_instance;
	}
	
	public function getOpeningTimes() {
		$stmt = self::$_db->prepare("SELECT * FROM opening_times");
		return $stmt->execute() && !$stmt->rowCount() > 0 ? false : $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function updateOpeningTimes($days) {
	
	}
}