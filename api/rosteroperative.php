<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    header('Content-Type: application/json');
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested operative
			GETRosterOperative();
			break;
		case "POST":
			//Create a new operative
			POSTRosterOperative();
			break;
		case "PUT":
			//Update an existing operative (also uses the "POST" method)
			POSTRosterOperative();
			break;
		case "DELETE":
			//Delete an existing operative
			DELETERosterOperative();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETRosterOperative() {
		// Get the requested operative
		$utoid = $_REQUEST['utoid'];
		
		if ($utoid == null || $utoid == '') {
			// No rosteropid specified - fail
			header('HTTP/1.0 404 Invalid rosteropid/utoid');
			die();
		} else {
			// Try to find this operative
			$uto = RosterOperative::GetRosterOperative($utoid);
			if ($uto == null) {
				header('HTTP/1.0 404 Operative not found');
				die();
			} else {
				echo json_encode($uto);
			}
		}
    }
	
	function DELETERosterOperative() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the requested operative
			$utoid = $_REQUEST['utoid'];
			
			if ($utoid == null || $utoid == '') {
				// No rosteropid specified - fail
				header('HTTP/1.0 404 Invalid rosteropid/utoid');
				die();
			} else {
				// Try to find this operative
				$uto = RosterOperative::GetRosterOperative($utoid);
				if ($uto == null) {
					header('HTTP/1.0 404 Operative not found A');
					die();
				} else {
					if ($uto->userid != $u->userid) {
						// This operative belongs to someone else - Fail
						header('HTTP/1.0 404 Operative not found B');
						die();
					} else {
						$uto->DBDelete();
						echo "OK";
					}
				}
			}
		}
	}
	
	function POSTRosterOperative() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the requested operative from the input JSON
			$newop = RosterOperative::FromJSON(file_get_contents('php://input'));
			echo "Puttting or Posting operative " . $newop->rosteropid;
			$utoid = $newop->rosteropid;
			
			if ($utoid == null || $utoid == '') {
				// No rosteropid specified - fail
				header('HTTP/1.0 404 Invalid rosteropid/utoid');
				die();
			} else {
				// Try to find this operative
				$uto = RosterOperative::GetRosterOperative($utoid);
				echo "UTO: " + json_encode($uto);
				if ($uto == null) {
					header('HTTP/1.0 404 Operative not found A');
					die();
				} else {
					if ($uto->userid != $u->userid) {
						// This operative belongs to someone else - Fail
						header('HTTP/1.0 404 Operative not found B');
						die();
					} else {
						// Got the operative - Now find its updates
						echo "Got operative " + json_encode($newop);
						
						// Check the team this operative should be added to
						$ut = Roster::GetRoster($newop->rosterid);
						if ($ut == null || $ut->userid != $u->userid) {
							// User team not found or belongs to someone else
							header('HTTP/1.0 404 Operative not found C');
							die();
						} else {
							// All good
							if ($newop->rosteropid == null || $newop->rosterid == "") {
								$newop->rosteropid = CommonUtils\shortId();
							}
							
							// Make sure they're assigned correctly
							$newop->userid = $u->userid;
							
							// Validate the faction and killteam
							if ($newop->factionid != $ut->factionid || $newop->killteamid != $ut->killteamid) {
								header('HTTP/1.0 401 Invalid operative for this killteam');
								die();
							} else {
								// Done
								$newop->DBSave();
								echo json_encode($newop);
							}
						}
						
					}
				}
			}
		}
	}
?>
