<?php

require_once __BACKEND__ . "/dbConn.php";

class Login
{
	private static $_db;
	public function __construct()
	{
		self::$_db = dbConn::getConnection();
	}
	
	public function checkLogin()
	{
		if (isset($_POST["logout"])) { $this->logout(); return false; };
		
		$error = null;
		$_SESSION["from"] = $_SERVER["REQUEST_URI"];
		
		if (isset($_SESSION[SESS_UID]))
		{
			if ($this->validateSession())
			{
				$this->getUsersData();
				return true;
			}
		}
		
		if ($_POST["auto"]??false && $_POST["string"]??false &&
			isset($_COOKIE[C_LogStr.Cs_UID]) && isset($_COOKIE[C_LogStr.Cs_FPH]))
		{
			$fingerprint = $_POST["string"];
			if ($this->validateKeeperCookie($fingerprint))
			{
				$this->loginUID($_COOKIE[C_LogStr.Cs_UID]);
				header('Refresh: 0');
				return true;
			}
			else
			{
				$this->clearLogin();
				header('Refresh: 0');
				return false;
			}
		}
		
		if (isset($_POST["login"]))
		{
			if (empty($_POST["password"]) || empty($_POST["username"]))
			{
				if (empty($_POST["password"]) && empty($_POST["username"])) $error = 1;
				else if (empty($_POST["username"])) $error = 2;
				else $error = 3;
			}
			if ($error !== null) {
				$_SESSION["login-error"] = true;
				return false;
			}
			if ($this->login($_POST["username"], $_POST["password"], $_POST["keep"]??false, $_POST["string"]??false))
			{
				$this->getUsersData();
				header('Refresh: 0');
				return true;
			}
		}
		return false;
	}
	
	protected function login($username, $password, $keep = false, $fingerprint = false)
	{
		if (is_null(trim($username)) || is_null(trim($password))) return false;
		
		$stmt = self::$_db->prepare("SELECT UID FROM users WHERE username=:u AND password=:p");
		$stmt->bindParam(":u", $username);
		$stmt->bindParam(":p", $password);
		if ($stmt->execute() && $stmt->rowCount() == 1)
		{
			$_SESSION[SESS_UID] = $stmt->fetch(PDO::FETCH_COLUMN);
			
			$session_id = session_id();
			$lastsession = $session_id;
			
			$stmt = self::$_db->prepare("UPDATE users SET session=:s, lastsession=:l WHERE UID=:uid AND username=:u AND password=:p");
			$stmt->bindParam(":s", $session_id);
			$stmt->bindParam(":l", $lastsession);
			$stmt->bindParam(":uid", $_SESSION[SESS_UID]);
			$stmt->bindParam(":u", $username);
			$stmt->bindParam(":p", $password);
			if ($stmt->execute() && $stmt->rowCount() == 1)
			{
				$this->getUsersData();
				
				if ($keep && $fingerprint != false) {
					$this->setKeeper($fingerprint);
				}
				header("Location: " . $_SESSION["from"]);
				die();
			}
		}
		$_SESSION["login-error"] = true;
		return false;
	}
	
	protected function loginUID($uid)
	{
		$session_id = session_id();
		$_SESSION[SESS_UID] = $uid;
		
		$stmt = self::$_db->prepare("UPDATE users SET session=:s, lastsession=:s WHERE UID=:u");
		$stmt->bindParam(":s", $session_id);
		$stmt->bindParam(":u", $uid);
		if ($stmt->execute() && $stmt->rowCount() == 1)
		{
			$this->getUsersData();
			header("Location: " . $_SESSION["from"]??"/");
			die();
		}
	}
	
	private function logout()
	{
		$session_id = session_id();
		$stmt = self::$_db->prepare("UPDATE users SET session=null WHERE session=:s");
		$stmt->bindParam(":s", $session_id);
		$stmt->execute();
		$this->clearLogin();
		header("Location: " . $_SERVER["REQUEST_URI"]);
		die();
	}
	
	private function validateSession()
	{
		$session_id = session_id();
		$stmt = self::$_db->prepare("SELECT UID FROM users WHERE username=:u AND session=:s");
		$stmt->bindParam(":u", $_SESSION[SESS_Username]);
		$stmt->bindParam(":s", $session_id);
		if ($stmt->execute() && $stmt->rowCount() == 1)
		{
			$gatheredUID = $stmt->fetch(PDO::FETCH_COLUMN);
			if ($gatheredUID == $_SESSION[SESS_UID])
				return true;
		}
		return false;
	}
	
	public function clearLogin()
	{
		$_SESSION = [];
		unset($_SESSION);
		session_reset();
		setcookie(C_LogStr.Cs_UID, '', 0, '/');
		setcookie(C_LogStr.Cs_FPH, '', 0, '/');
		unset($_COOKIE[C_LogStr.Cs_UID]);
		unset($_COOKIE[C_LogStr.Cs_FPH]);
	}
	
	private function getUsersData()
	{
		$session_id = session_id();
		$stmt = self::$_db->prepare("SELECT username, name, email, admin FROM users WHERE UID=:u AND session=:s");
		$stmt->bindParam(":u", $_SESSION[SESS_UID]);
		$stmt->bindParam(":s", $session_id);
		if ($stmt->execute() && $stmt->rowCount() == 1)
		{
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			foreach ($res as $key=>$value)
			{
				$_SESSION[$key] = $value;
			}
			//print_r($_SESSION);
		}
	}
	
	public function setKeeper($fingerprint)
	{
		$session_id = session_id();
		$stmt = self::$_db->prepare("SELECT keepers FROM users WHERE UID=:u AND session=:s");
		$stmt->bindParam(":u", $_SESSION[SESS_UID]);
		$stmt->bindParam(":s", $session_id);
		if (!$stmt->execute() || $stmt->rowCount() != 1) return false;
		
		$json = $stmt->fetch(PDO::FETCH_COLUMN);
		$keepers = json_decode($json, true);
		
		if (is_array($keepers))
			foreach ($keepers as $time=>$hash)
				if (strtotime($time) < strtotime('-20 days') || $hash == $fingerprint)
					unset($keepers[$time]);
		
		$keepers[date(DATETIME)] = $fingerprint;
		$keepers = array_slice($keepers, -5, 5, true);
		
		$json = json_encode($keepers, true);
		$stmt = self::$_db->prepare("UPDATE users SET keepers=:k WHERE UID=:u AND session=:s");
		$stmt->bindParam(":k", $json);
		$stmt->bindParam(":u", $_SESSION[SESS_UID]);
		$stmt->bindParam(":s", $session_id);
		if ($stmt->execute() && $stmt->rowCount() == 1) {
			setcookie(C_LogStr.Cs_UID, $_SESSION[SESS_UID], time() + 60*60*24*14, '/');
			setcookie(C_LogStr.Cs_FPH, $fingerprint, time() + 60*60*24*14, '/');
			return true;
		}
		return false;
	}
	
	private function validateKeeperCookie($fingerprint)
	{
		$keeperUserID = $_COOKIE[C_LogStr.Cs_UID]?? null;
		$keeperCookie = $_COOKIE[C_LogStr.Cs_FPH]?? null;
		$stmt = self::$_db->prepare("SELECT keepers FROM users WHERE UID=:u");
		$stmt->bindParam(":u", $keeperUserID);
		
		if ($stmt->execute() && $stmt->rowCount() == 1) {
			$json = $stmt->fetch(PDO::FETCH_COLUMN);
			$keepers = json_decode($json, true);
			
			if (is_array($keepers))
				foreach ($keepers as $time => $hash)
					if (strtotime($time) > strtotime('-14 days') && $hash == $keeperCookie)
						if ($hash == $fingerprint && $hash == $keeperCookie)
							return true;
		}
		return false;
	}
}