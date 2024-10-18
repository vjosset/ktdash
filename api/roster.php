<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;
global $perf;

Utils::SetApiHeaders();
header("Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE");

header("GlobalStart: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));

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
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function GETRoster()
{
	// Get the requested roster
	$rid = getIfSet($_REQUEST['rid']);
	$uid = getIfSet($_REQUEST['uid']);
	$loadrosterdetail = getIfSet($_REQUEST['loadrosterdetail']);

	$randomspotlight = getIfSet($_REQUEST['randomspotlight']);

	// Validate Input
	if (strlen($rid) > 10 || strlen($uid) > 10 || strlen($loadrosterdetail) > 2 || strlen($randomspotlight) > 1) {
		header("HTTP/1.0 400 Invalid Input");
		die();
	}

	if ($randomspotlight == "1") {
		// Select a random spotlighted roster
		global $dbcon;
		$sql = "SELECT rosterid FROM Roster WHERE spotlight = 1 ORDER BY RAND() LIMIT 1";
		$cmd = $dbcon->prepare($sql);
		// Load the stats
		$cmd->execute();

		if ($result = $cmd->get_result()) {
			while ($row = $result->fetch_object()) {
				$rid = $row->rosterid;
			}
		}
	}

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
		$u->loadRosters($loadrosterdetail);
		header("GlobalEnd: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
		echo json_encode($u->rosters);
	} else {
		// Return the requested roster
		global $perf;
		$perf = floor(microtime(true) * 1000) . " - API::Roster::GetRoster()\r\n";
		$r = Roster::GetRoster($rid);

		if ($r != null) {
			if ($loadrosterdetail > 0) {
				$r->loadKillTeam();
			}
			// Increment the view count
			$u = Session::CurrentUser();
			$skipviewcount = getIfSet($_REQUEST['skipviewcount']);
			if ($skipviewcount != '1' && (!Session::IsAuth() || $u->userid != $r->userid)) {
				// Anonymous or a user viewing another user's roster, increment the viewcount
				global $dbcon;
				$sql = "UPDATE Roster SET viewcount = viewcount + 1 WHERE rosterid = ?";

				$cmd = $dbcon->prepare($sql);
				$paramtypes = "s";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $rid;

				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();
			}

			$r->perf = $perf;
			header("GlobalEnd: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
			echo json_encode($r);
		} else {
			header("HTTP/1.0 404 Not found - Could not find roster with id \"$rid\"");
			die();
		}
	}
}

function POSTRoster()
{
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
			$newrosterid = Roster::GetNewRosterId();

			// Get the original roster
			$origrosterid = getIfSet($_REQUEST['rid']);

			// Validate Input
			if (strlen($origrosterid) > 10) {
				header("HTTP/1.0 400 Invalid Input");
				die();
			}

			$origroster = Roster::GetRoster($origrosterid);
			$roster = Roster::GetRoster($origrosterid);

			$selfclone = $roster->userid == $u->userid;
			if ($selfclone) {
				// This is a clone of an existing roster for the current user - Rename the team "Copy"
				$roster->rostername = "Copy of " . $roster->rostername;
			}

			$newrostername = getIfSet($_REQUEST["rostername"]);
			if ($newrostername != "") {
				$roster->rostername = $newrostername;
			}

			// Update its values for the current user and new roster id
			$roster->rosterid = $newrosterid;
			$roster->userid = $u->userid;

			// Mark the cloned team as not spotlighted
			$roster->spotlight = 0;

			// If self-clone or portrait copy is allowed, copy the roster's portrait if it exists
			if ($selfclone || $origroster->portraitcopyok == 1) {
				$origrosterfolderpath = "../img/customportraits/user_{$origroster->userid}/roster_{$origrosterid}";
				$origrosterportraitfile = $origrosterfolderpath . "/roster_{$origrosterid}.jpg";
				if (is_dir($origrosterfolderpath)) {
					// Copy the roster directory
					$newrosterfolderpath = "../img/customportraits/user_{$roster->userid}/roster_{$newrosterid}";
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
			foreach ($roster->operatives as $op) {
				$origopid = $op->rosteropid;
				$origrosterid = $op->rosterid;

				$op->rosteropid = RosterOperative::GetNewRosterOpId();
				$op->userid = $u->userid;
				$op->rosterid = $newrosterid;

				// Commit this operative
				$op->DBInsert();

				if ($selfclone || $origroster->portraitcopyok == 1) {
					// Copy this operative's portrait if it exists
					$origrosterfolderpath = "../img/customportraits/user_{$origroster->userid}/roster_{$origrosterid}";
					$origopfile = $origrosterfolderpath . "/op_{$origopid}.jpg";
					$newrosterfolderpath = "../img/customportraits/user_{$op->userid}/roster_{$newrosterid}";
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

			// Increment the import count on this roster
			if (!$selfclone) {
				global $dbcon;
				$sql = "UPDATE Roster SET importcount = importcount + 1 WHERE rosterid = ?";

				$cmd = $dbcon->prepare($sql);
				$paramtypes = "s";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $origrosterid;

				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();
			}

			// All done
			echo json_encode($roster);
		} else if (getIfSet($_REQUEST["setseq"]) == "1") {
			// Update the seq for this roster
			// Get the user id
			$uid = $u->userid;

			// Get the new seq for this roster
			$newseq = getIfSet($_REQUEST["seq"]);
			$rid = getIfSet($_REQUEST["rid"]);

			global $dbcon;
			$sql = "UPDATE Roster SET seq = ? WHERE userid = ? AND rosterid = ?;";

			$cmd = $dbcon->prepare($sql);
			$paramtypes = "sss";
			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $newseq;
			$params[] =& $uid;
			$params[] =& $rid;

			call_user_func_array(array($cmd, "bind_param"), $params);
			$cmd->execute();

			// Finally re-sort the rosters
			$u->reorderRosters();

			// Get the new seq for this roster
			$r = Roster::GetRosterRow($rid);

			header('Content-Type: text/plain');
			echo $r->seq;
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

			// Validate Input
			if (strlen($seq1) > 3 || strlen($rid1) > 10 || strlen($seq2) > 3 || strlen($rid2) > 10) {
				header("HTTP/1.0 400 Invalid Input");
				die();
			}

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

			echo '{"success": "OK"}';
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
				$r->rosterid = Roster::GetNewRosterId();

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
			} else {
				// Submitted roster has an ID, check if this user owns it
				$tempr = Roster::GetRosterRow($r->rosterid);

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

function DELETERoster()
{
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

		if ($r == null) {
			// Roster not found
			header('HTTP/1.0 404 Roster not found');
			die();
		}

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
			foreach ($r->operatives as $ro) {
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
			echo '{"success": "OK"}';
		} else {
			// Roster belongs to someone else
			header('HTTP/1.0 404 Roster not found');
			die();
		}
	}
}
