<?php

header('Content-Type: application/json');

try {
	require_once "./../config.php";
	require_once __BACKEND__ . "/dbConn.php";
	require_once __BACKEND__ . "/Login.php";
	require_once __BACKEND__ . "/OpeningTimes.php";
	$login = new Login(true);
	$optim = new OpeningTimes(true);
}
catch (Exception $e) {
	die(json_encode(["error" => $e->getMessage(), "error_code" => $e->getCode()]));
}

if (!$login->checkLogin())
	die(json_encode(["error" => "Nicht (mehr) angemeldet.", "error_code" => 42]));

$data = json_decode(file_get_contents('php://input'), true);
if (empty($data)) die(json_encode(["error" => "Keine Daten übermittelt.", "error_code" => 48]));

$days = [];
foreach ($data as $alt => $time)
	$days[substr($alt, 1, 1)][substr($alt, 2, 1)] = $time;

$exec = $optim->updateOpeningTimes($days);
if ($exec !== true)
	die(json_encode(["error" => "Daten wurden nicht gespeichert.", "error_code" => 50]));

die(json_encode(["success" => "Daten gespeichert."]));
