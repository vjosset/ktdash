<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			// Get the requested roster/user team
			header('Content-Type: application/json');
			GETRoster();
			break;
		case "POST":
			// Create a new roster/user team
			header('Content-Type: application/json');
			POSTRoster();
			break;
		case "DELETE":
			// Delete an existing roster/user team
			DELETERoster();
			break;
        default:
            // Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETRoster() {
		// Get the requested roster
		$rid = $_REQUEST['rid'];
		$uid = $_REQUEST['uid'];
		
		if ($rid == null || $rid == '') {
			// No roster id passed in, return the specified user's roster
			
			if ($uid == null || $uid == '') {
				// Use the current user as the user whose rosters to return
				if (!Session::IsAuth()) {
					// Not logged in - Return error				
					header('HTTP/1.0 401 Unauthorized - You are not logged in');
					die();
				} else {
					$uid = Session::CurrentUser()->userid;
				}
			}
			
			// Get the rosters for this user
			$u = User::FromDB($uid);
			$u->loadRosters();
			echo json_encode($u->rosters);
		} else {
			// Return the requested roster
			echo json_encode(Roster::GetRoster($rid));
		}
    }
	
	function POSTRoster() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the submitted roster
			$r = Roster::FromJSON(file_get_contents('php://input'));
				
			// Force the user id on the roster to be the current user
			$r->userid = $u->userid;
				
			// Validate the roster's faction and killteam
			$kt = KillTeam::FromDB($r->factionid, $r->killteamid);
			
			if ($kt == null) {
				// Faction or killteam don't exist
				header('HTTP/1.0 404 Faction or Killteam not found');
				die();
			}
			
			// Check if this team exists
			if ($r->rosterid == null || $r->rosterid == "") {
				// No user team ID, create a new one
				$r->rosterid = CommonUtils\shortId();
				
				// Always put new rosters first, pushing all other rosters down
				// [TBD]
				
				// Now save this team to DB
				$r->DBInsert();
				
				// Now get a fresh copy from DB
				$r = Roster::GetRoster($r->rosterid);
				
				// Done
				echo json_encode($r);
			}
			else {
				// Submitted roster has an ID, check if this user owns it
				$tempr = Roster::GetRoster($r->rosterid);
				
				if ($tempr == null || $tempr->userid != $u->userid) {
					// Roster not found or belongs to someone else		
					header('HTTP/1.0 404 Roster not found');
					die();
				} else {
					// Roster exists and belongs to this user, good to update
					//	Can't change faction or kill team on a roster - Overwrite submitted values
					$r->factionid = $temput->factionid;
					$r->killteamid = $temput->killteamid;
					
					// Commit to DB
					$r->DBUpdate();
					
					// Now get a fresh copy from DB
					$r = Roster::GetRoster($r->rosterid);
					
					// Done
					echo json_encode($r);
				}
			}
		}
	}
	
	function DELETERoster() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the requested roster
			$rid = $_REQUEST['utid'];
			$r = Roster::FromDB($rid);
			
			// Validate the roster's owner
			if ($r->userid == $u->userid) {
				// Current user owns this roster, OK to delete
				$r->DBDelete();
				
				// Load the roster's operatives so we can delete them
				$r->loadOperatives();
				foreach($r->operatives as $op) {
					$op->DBDelete();
				}
				
				// Done
				echo "OK";
			} else {
				// Roster belongs to someone else
				header('HTTP/1.0 404 Roster not found');
				die();
			}
		}
	}
?>
