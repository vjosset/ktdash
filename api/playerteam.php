<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    header('Content-Type: application/json');
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested PlayerTeam
			GETPlayerTeam();
			break;
		case "POST":
			// Create or update a PlayerTeam
			POSTPlayerTeam();
			break;
		case "DELETE":
			// Delete the PlayerTeam
			DELETEPlayerTeam();
			echo "{ \"success\": \"OK\" }";
			break;
        default:
            // Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

	function GETPlayerTeam() {
        //Check if authenticated
        if (!Session::IsAuth()) {
			//Not authenticated
            header('HTTP/1.0 401 Not logged in');
			die("Not logged in");
        }

        // Get the current player
        $player = Session::CurrentPlayer();
		
		$playerid = $_REQUEST["playerid"];
		$playerteamid = $_REQUEST["playerteamid"];
		
		if ($playerid != $player->playerid) {
			// Mismatch/invalid
            header('HTTP/1.0 403 Invalid PlayerID');
			die("Invalid PlayerID");
		}
		
		// Get the player team
		$pt = PlayerTeam::FromDB($playerid, $playerteamid);
		
		// Load its operatives
		$pt->loadOperatives();
		
		// Done
		echo json_encode($pt);
	}

	function POSTPlayerTeam() {
		global $dbcon;
		
        //Check if authenticated
        if (!Session::IsAuth()) {
			//Not authenticated
            header('HTTP/1.0 401 Not logged in');
			die("Not logged in");
        }

        // Get the current player
        $player = Session::CurrentPlayer();
		
		// Parse the requested PlayerTeam
		$pt = new PlayerTeam();
		$ptinput = json_decode($_REQUEST["playerteam"]);
		
		// Copy the values
		$pt->playerid = $ptinput->playerid;
		$pt->playerteamid = $ptinput->playerteamid;
		$pt->playerteamname = $ptinput->playerteamname;
		$pt->factionid = $ptinput->factionid;
		$pt->killteamid = $ptinput->killteamid;
		
		echo "Input: ".json_encode($ptinput);
		
		// Validate the player id
		if ($player->playerid != $pt->playerid) {
            header('HTTP/1.0 403 Invalid PlayerID');
			die("Invalid PlayerID");
		}
		
		// Save the PlayerTeam
		$pt->DBSave();
		
		// Delete the PlayerTeam's old operatives
		$sql = "DELETE FROM PlayerTeamOperative WHERE playerid = ? AND playerteamid = ?;";
		$cmd = $dbcon->prepare($sql);
		$paramtypes = "ss";
		
		$params = array();
		$params[] =& $paramtypes;
		$params[] =& $playerid;
		$params[] =& $playerteamid;
		
		// Delete the old operatives from DB
		call_user_func_array(array($cmd, "bind_param"), $params);
		$cmd->execute();
		
		// Save the PlayerTeam's new operatives
		for ($opnum = 0; $opnum < count($ptinput->operatives); $opnum++) {
			$pop = new PlayerTeamOperative();
			$popinput = $ptinput->operatives[$opnum];
			
			// Copy the values
			$pop->playerid = $ptinput->playerid;
			$pop->playerteamid = $ptinput->playerteamid;
			$pop->playerteamopid = $popinput->playerteamopid;
			$pop->opname = $popinput->opname;
			$pop->factionid = $popinput->factionid;
			$pop->killteamid = $popinput->killteamid;
			$pop->fireteamid = $popinput->fireteamid;
			$pop->opid = $popinput->opid;
			$pop->wepids = $popinput->wepids; // Should be a comma-separated string of wepids
			
			// Commit this operative to DB
			$pop->DBSave();
			
			// Add this operative to the PlayerTeam (for output)
			$pt->operatives[] = $pop;
		}
		
		// Done
		echo json_encode($pt);
	}
	
	function DELETEPlayerTeam() {
		global $dbcon;
		
        // Check if authenticated
        if (!Session::IsAuth()) {
			// Not authenticated
            header('HTTP/1.0 401 Not logged in');
			die("Not logged in");
        }

        // Get the current player
        $player = Session::CurrentPlayer();
		
		$playerid = $_REQUEST["playerid"];
		$playerteamid = $_REQUEST["playerteamid"];
		
		if ($playerid != $player->playerid) {
			// Mismatch/invalid
            header('HTTP/1.0 403 Invalid PlayerID');
			die("Invalid PlayerID");
		}
		
		// Get the playerteam to delete
		$pttodelete = PlayerTeam::FromDB($playerid, $playerteamid);
		
		// Delete the PlayerTeam
		$pttodelete->DBDelete();
	}

/*
Sample PlayerTeam input for POST:

{
    "playerid": "vince",
    "playerteamid": "EB",
    "playerteamname": "EdgeBearers",
    "factionid": "IMP",
    "killteamid": "SM",
    "operatives": [
        {
            "playerid": "vince",
            "playerteamid": "EB",
            "playerteamopid": "00",
            "opname": "Sgt Remus Steelhand",
            "factionid": "IMP",
            "killteamid": "SM",
            "fireteamid": "DW",
            "opid": "SGT",
            "wepids": "DWBG,CG,F"
        },
        {
            "playerid": "vince",
            "playerteamid": "EB",
            "playerteamopid": "01",
            "opname": "XIV - Pall Miro",
            "factionid": "IMP",
            "killteamid": "SM",
            "fireteamid": "DW",
            "opid": "HGNR",
            "wepids": "IHB,F"
        },
        {
            "playerid": "vince",
            "playerteamid": "EB",
            "playerteamopid": "02",
            "opname": "VII - Prioris",
            "factionid": "IMP",
            "killteamid": "SM",
            "fireteamid": "DW",
            "opid": "FTR",
            "wepids": "IP,PW"
        },
        {
            "playerid": "vince",
            "playerteamid": "EB",
            "playerteamopid": "03",
            "opname": "XV - Sabine",
            "factionid": "IMP",
            "killteamid": "SM",
            "fireteamid": "DW",
            "opid": "WAR",
            "wepids": "DWBG,PW"
        },
        {
            "playerid": "vince",
            "playerteamid": "EB",
            "playerteamopid": "04",
            "opname": "XVI - Iona",
            "factionid": "IMP",
            "killteamid": "SM",
            "fireteamid": "DW",
            "opid": "GNR",
            "wepids": "DWBG,CG,F"
        }
    ]
}
*/

?>
