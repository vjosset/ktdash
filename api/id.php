<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

header('Access-Control-Allow-Origin: *');
header('Content-Type: text/plain');

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
