<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

Utils::SetApiHeaders();
header("Access-Control-Allow-Methods: OPTIONS, GET");

switch ($_SERVER['REQUEST_METHOD']) {
	case "GET":
		//Get the requested killteam
		GETKillteam();
		break;
	default:
		//Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function GETKillteam()
{
	// Get the requested killteam id
	$factionid = getIfSet($_REQUEST['fa']);
	$killteamid = getIfSet($_REQUEST['kt']);
	$edition = getIfSet($_REQUEST['edition']);

	// Validate Input
	if (strlen($factionid) > 10 || strlen($killteamid) > 10) {
		header("HTTP/1.0 400 Invalid Input");
		die();
	}

	if ($killteamid == null || $killteamid == '') {
		// No killteam id passed in, return all killteams
		$killteams = Killteam::GetKillteams($edition);
		echo json_encode($killteams);
	} else {
		// Return the requested killteam
		$killteam = Killteam::GetKillteam($factionid, $killteamid);
		echo json_encode($killteam);
	}
}
