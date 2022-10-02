<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    header('Content-Type: application/json');
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested killteam
			GETKillteam();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETKillteam() {
		// Get the requested killteam id
		$factionid = $_REQUEST['fa'];
		$killteamid = $_REQUEST['kt'];
		
		if ($killteamid == null || $killteamid == '') {
			// No killteam id passed in, return all killteams
			$killteams = Killteam::GetKillteams();
			echo json_encode($killteams);
		} else {
			// Return the requested killteam
			$killteam = Killteam::GetKillteam($factionid, $killteamid);
			echo json_encode($killteam);
		}
    }
?>
