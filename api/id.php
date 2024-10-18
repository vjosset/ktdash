<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

Utils::SetApiHeaders(false);
header("Access-Control-Allow-Methods: OPTIONS");

switch ($_SERVER['REQUEST_METHOD']) {
	case "GET":
		//Get the requested thing
		GETID();
		break;
	default:
		//Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function GETID()
{
	// Return a shortid
	$out = CommonUtils\shortId();

	echo $out;
}
