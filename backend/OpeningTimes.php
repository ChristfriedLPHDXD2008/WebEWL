<?php

class OpeningTimes
{
	private static $_db;
	public function __construct($json = false)
	{
		self::$_db = dbConn::getConnection($json);
	}
	
	public function getOpeningTimes() {
		$stmt = self::$_db->prepare("SELECT * FROM opening_times");
		return $stmt->execute() && !$stmt->rowCount() > 0 ? false : $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function updateOpeningTimes($days) {
		
		$exec = "";
		foreach ($days as $did => $day) {
			$query = "UPDATE opening_times SET ";
			$count = count($day);
			$i = 1;
			foreach ($day as $num => $value) {
				switch ($num) {
					case 1:
						$value = str_pad(str_replace(":", "", $value), 4, "0", STR_PAD_LEFT);
						if (is_numeric($value))
							$query .= "opening='" . $value . "'";
						break;
					case 2:
						$value = str_pad(str_replace(":", "", $value), 4, "0", STR_PAD_LEFT);
						if (is_numeric($value))
							$query .= "closing='" . $value . "'";
						break;
					case 3:
						$query .= "manual=";
						if (empty(trim($value)) || $value == null || strtolower($value) == "null")
							$query .= "NULL";
						else $query .= "'" . $value . "'";
						break;
				}
				if ($i != $count) $query .= ",";
				$i++;
			}
			$query .= " WHERE DID=" . $did . "; ";
			$exec .= $query;
		}
		
		$stmt = self::$_db->prepare($exec);
		if ($stmt->execute() && $stmt->rowCount() > 0)
			return true;
		
		return false;
	}
}