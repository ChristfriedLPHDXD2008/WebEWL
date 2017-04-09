<?php

require_once "config.php";
require_once __BACKEND__ . "/Constructor.php";
require_once __BACKEND__ . "/dbConn.php";
require_once __BACKEND__ . "/Login.php";
$_constr = Constructor::getInstance();

$_constr->view = "view";
if (@$_GET[0] == "admin") {
	
	$login = new Login();
	
	if (!$login->checkLogin())
		$_constr->view = "login";
	else
		$_constr->view = "admin";
}

$_constr->build();

