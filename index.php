<?php

require_once "config.php";
require_once __BACKEND__ . "/Constructor.php";
require_once __BACKEND__ . "/dbConn.php";
require_once __BACKEND__ . "/Login.php";
$_constr = Constructor::getInstance();

$_constr->view = "view";
if (@$_GET[0] == "admin") {
	
	try {
		$login = new Login();
	} catch (Exception $e) {
		die("<h1>500 Internal Server Error<br></h1>" . $e->getMessage());
	}
	
	if (!$login->checkLogin())
		$_constr->view = "login";
	else
		$_constr->view = "admin";
}

$_constr->build();

