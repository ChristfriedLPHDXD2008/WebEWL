<?php

#header('Content-Type: application/json');

try {
	require_once "./../config.php";
	require_once __BACKEND__ . "/dbConn.php";
	require_once __BACKEND__ . "/Login.php";
	$login = new Login(true);
}
catch (Exception $e) {
	die(json_encode(["error" => $e->getMessage(), "error_code" => $e->getCode()]));
}

if (!$login->checkLogin())
	die(json_encode(["error" => "not logged in"]));


