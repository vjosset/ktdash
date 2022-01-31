<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    header('Content-Type: application/json');
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested faction
			GETFaction();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETFaction() {
		// Get the requested faction id
		$factionid = $_REQUEST['factionid'];
		
		if ($factionid == null || $factionid == '') {
			// No faction id passed in, return all factions
			$factions = Faction::GetFactions();
			echo json_encode($factions);
		} else {
			// Return the requested faction
			$faction = Faction::GetFaction($factionid);
			echo json_encode($faction);
		}
    }
?>
