<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: OPTIONS, POST");

switch ($_SERVER['REQUEST_METHOD']) {
	case "POST":
		// Save the specified event
		POSTEvent();
		break;
	case "OPTIONS":
		echo "";
		break;
	default:
		//Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function POSTEvent()
{
	Utils::TrackEvent(
		substr(getIfSet($_REQUEST['t']), 0, 50),
		substr(getIfSet($_REQUEST['a']), 0, 45),
		substr(getIfSet($_REQUEST['l']), 0, 45),
		substr(getIfSet($_REQUEST['v1']), 0, 45),
		substr(getIfSet($_REQUEST['v2']), 0, 45),
		substr(getIfSet($_REQUEST['v3']), 0, 45),
		substr(getIfSet($_REQUEST['u']), 0, 500),
		substr(getIfSet($_REQUEST['s']), 0, 50),
		substr(getIfSet($_REQUEST['r']), 0, 500)
	);

	echo "OK";
}
