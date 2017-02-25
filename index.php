<?php

require_once "config.php";
require_once __BACKEND__ . "/Constructor.php";
$_constr = Constructor::getInstance();

$_constr->view = "view";
$_constr->build();

