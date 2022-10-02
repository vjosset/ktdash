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
		$roid = $_REQUEST['roid'];
		
		if ($roid == null || $roid == '') {
			// No rosteropid specified - fail
			header('HTTP/1.0 404 Invalid rosteropid');
			die();
		} else {
			// Try to find this operative
			$ro = RosterOperative::GetRosterOperative($roid);
			if ($roid == null) {
				header('HTTP/1.0 404 Operative not found');
				die();
			} else {
				echo json_encode($roid);
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
			$roid = $_REQUEST['roid'];
			
			if ($roid == null || $roid == '') {
				// No rosteropid specified - fail
				header('HTTP/1.0 404 Invalid rosteropid');
				die();
			} else {
				// Try to find this operative
				$ro = RosterOperative::GetRosterOperative($roid);
				if ($ro == null) {
					header('HTTP/1.0 404 Operative not found');
					die();
				} else {
					if ($ro->userid != $u->userid) {
						// This operative belongs to someone else - Fail
						header('HTTP/1.0 404 Operative not found');
						die();
					} else {
						$ro->DBDelete();
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
			
			// Get the new operative from the input JSON
			$newop = RosterOperative::FromJSON(file_get_contents('php://input'));
			
			if ($newop->rosteropid != null || $newop->rosteropid != '') {
				// Try to find this operative
				$ro = RosterOperative::GetRosterOperative($roid);
				
				if ($ro == null) {
					header('HTTP/1.0 404 Operative not found');
					die();
				} else {
					if ($ro->userid != $u->userid) {
						// This operative belongs to someone else - Fail
						header('HTTP/1.0 404 Operative not found');
						die();
					}
				}
			}
			
			// Check the roster this operative should be added to
			$r = Roster::GetRoster($newop->rosterid);
			if ($r == null || $r->userid != $u->userid) {
				// User team not found or belongs to someone else
				header('HTTP/1.0 404 Roster not found');
				die();
			} else {
				// All good
				if ($newop->rosteropid == null || $newop->rosterid == "") {
					// No roster operative ID, generate a new one
					$newop->rosteropid = CommonUtils\shortId();
				}
				
				// Make sure the fields are assigned correctly
				$newop->userid = $u->userid;
				$newop->rosterid = $r->rosterid;
				
				// Validate the faction and killteam
				if ($newop->factionid != $r->factionid || $newop->killteamid != $r->killteamid) {
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
?>
