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
			// Create or update a roster
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
		$rid = getIfSet($_REQUEST['rid']);
		$uid = getIfSet($_REQUEST['uid']);
		
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
			
			// If this is a copy/clone/import
			if (getIfSet($_REQUEST["clone"]) == "1") {
				// Clone/import existing team
				
				// Prepare a new rosterid
				$newrosterid = CommonUtils\shortId(5);
				
				// Get the original roster
				$origrosterid = getIfSet($_REQUEST['rid']);
				$origroster = Roster::GetRoster($origrosterid);
				$roster = Roster::GetRoster($origrosterid);
				
				$selfclone = $roster->userid == $u->userid;
				if ($selfclone) {
					// This is a clone of an existing roster for the current user - Rename the team "Copy"
					$roster->rostername = "Copy of " . $roster->rostername;
				}
				
				// Update its values for the current user and new roster id
				$roster->rosterid = $newrosterid;
				$roster->userid = $u->userid;
				
				// If self-clone, copy the roster's portrait if it exists
				if ($selfclone) {
					$origrosterfolderpath = "../img/customportraits/user_{$u->userid}/roster_{$origrosterid}";
					$origrosterportraitfile = $origrosterfolderpath . "/roster_{$origrosterid}.jpg";
					if (is_dir($origrosterfolderpath)) {
						// Copy the roster directory
						$newrosterfolderpath = "../img/customportraits/user_{$u->userid}/roster_{$newrosterid}";
						$newrosterportraitfile = $newrosterfolderpath . "/roster_{$newrosterid}.jpg";
						mkdir($newrosterfolderpath, 0777, true);
						
						if (file_exists($origrosterportraitfile)) {
							// Copy the roster portrait
							copy($origrosterportraitfile, $newrosterportraitfile);
						}
					}
				}
				
				// Put this cloned roster at the end of the list
				$roster->seq = 10000;
				
				// Commit this roster
				$roster->DBInsert();
				
				// Update all operatives
				foreach($roster->operatives as $op) {
					$origopid = $op->rosteropid;
					$origrosterid = $op->rosterid;
					
					$op->rosteropid = CommonUtils\shortId(5);
					$op->userid = $u->userid;
					$op->rosterid = $newrosterid;
					
					// Commit this operative
					$op->DBInsert();
					
					if ($selfclone) {
						// Copy this operative's portrait if it exists
						$origrosterfolderpath = "../img/customportraits/user_{$u->userid}/roster_{$origrosterid}";
						$origopfile = $origrosterfolderpath . "/op_{$origopid}.jpg";
						$newrosterfolderpath = "../img/customportraits/user_{$u->userid}/roster_{$newrosterid}";
						$newopfile = $newrosterfolderpath . "/op_{$op->rosteropid}.jpg";
						if (file_exists($origopfile)) {
							// Copy the roster portrait
							copy($origopfile, $newopfile);
						}
					}
				}
				
				// Reorder all rosters
				$u->reorderRosters();
				
				// Now get a fresh copy from DB
				$roster = Roster::GetRoster($roster->rosterid);
				
				// All done
				echo json_encode($roster);
			} else if (getIfSet($_REQUEST["swapseq"]) == "1") {
				// Swap the Seqs for two rosters (moveup/movedown)
				
				// Get the user id
				$uid = $u->userid;
				
				// Get the opid and seq for roster 1
				$seq1 = getIfSet($_REQUEST["seq1"]);
				$rid1 = getIfSet($_REQUEST["rid1"]);
				
				// Get the opid and seq for roster 2
				$seq2 = getIfSet($_REQUEST["seq2"]);
				$rid2 = getIfSet($_REQUEST["rid2"]);
				
				global $dbcon;
				$sql = "UPDATE Roster SET seq = ? WHERE userid = ? AND rosterid = ?;";
				
				// Roster 1
				$cmd = $dbcon->prepare($sql);
				$paramtypes = "sss";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $seq1;
				$params[] =& $uid;
				$params[] =& $rid1;

				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();
				
				// Roster 2
				$cmd = $dbcon->prepare($sql);
				$paramtypes = "sss";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $seq2;
				$params[] =& $uid;
				$params[] =& $rid2;

				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();
					
				// Finally re-sort the rosters
				$u->reorderRosters();
				
				header('Content-Type: text/plain');
				echo "OK";
			} else {
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
					$r->rosterid = CommonUtils\shortId(5);
					
					// Make sure rosters are in seq order
					$u->reorderRosters();
					
					// Rosters are now ordered by Seq, starting at 0
					// Now we can insert this new team as Seq = -1 so new teams are always first
					$r->seq = -1;
					
					// Now save this team to DB
					$r->DBInsert();
					
					// Now re-sort the rosters
					$u->reorderRosters();
					
					// Now get a fresh copy from DB
					$r = Roster::GetRoster($r->rosterid);
					
					// Done
					echo json_encode($r);
				}
				else {
					// Submitted roster has an ID, check if this user owns it
					$tempr = Roster::GetRoster($r->rosterid);
					
					if ($tempr == null) {
						// Roster not found or belongs to someone else		
						header('HTTP/1.0 404 Roster not found');
						die();
					} else {
						// Roster exists and belongs to this user, good to update
						//	Can't change faction or kill team on an existing roster - Overwrite submitted values
						$r->factionid = $tempr->factionid;
						$r->killteamid = $tempr->killteamid;
						
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
			$rid = getIfSet($_REQUEST['rid']);
			$r = Roster::FromDB($rid);
			
			// Validate the roster's owner
			if ($r->userid == $u->userid) {
				// Current user owns this roster, OK to delete
				
				// Delete this roster's portrait if it exists
				$custrosterportraitpath = "../img/customportraits/user_{$r->userid}/roster_{$r->rosterid}/roster_{$r->rosterid}.jpg";
				if (file_exists($custrosterportraitpath)) {
					unlink($custrosterportraitpath);
				}
				
				// Load the roster's operatives so we can delete them
				$r->loadOperatives();
				foreach($r->operatives as $ro) {
					$custrosteropportraitpath = "../img/customportraits/user_{$r->userid}/roster_{$r->rosterid}/op_{$ro->rosteropid}.jpg";
					
					$ro->DBDelete();
					
					// Delete this operative's portrait if it exists
					if (file_exists($custrosteropportraitpath)) {
						unlink($custrosteropportraitpath);
					}
				}
				
				// Now delete the custom portrait folder
				$custrosterportraitfolder = "../img/customportraits/user_{$r->userid}/roster_{$r->rosterid}";
				if (is_dir($custrosterportraitfolder)) {
					rmdir($custrosterportraitfolder);
				}
				
				// Delete this roster
				$r->DBDelete();
				
				// Now re-sort the rosters
				$u->reorderRosters();
				
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
