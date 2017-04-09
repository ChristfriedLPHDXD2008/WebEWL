<?php

$constructor = Constructor::getInstance();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, min-width=400, min-device-width=400, initial-scale=1" />
    <meta name="description" content="Pax et Bonum. Eine Welt Laden e.V." />
    <meta name="keywords" content="Eine Welt Laden, Pax et bonum, Bischofswerda, Dresden, Kaffee, Fair Trade" />
    <meta name="author" content="Medienwerkstatt Bishofswerda" />
	<title><?=$constructor->title?></title>
<?php

if (!empty($constructor->cssfiles))
	foreach ($constructor->cssfiles as $cssfile) {
		echo "\t<link rel=\"stylesheet\" href=\"/styles/css/" . $cssfile . "\" />\r\n";
	}
	
if (!empty($constructor->jsfiles))
	foreach ($constructor->jsfiles as $jsfile) {
		echo "\t<script type=\"text/javascript\" src=\"/js/" . $jsfile . "\"></script>\r\n";
	}
	
?>
</head>
<body>
<div id="wrapper">
<?php require_once "$constructor->modfile"; ?>
</div>
</body>
</html>
