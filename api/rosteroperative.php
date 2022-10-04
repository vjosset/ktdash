<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
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
				header('Content-Type: application/json');
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
						
						// Now re-order operatives so their seqs are always sequential
						$r = Roster::GetRoster($ro->rosterid);
						$r->reorderOperatives();
						header('Content-Type: text/plain');
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
			
			if ($_REQUEST["swapseq"] == "1") {
				// Swap the Seqs for two operatives (moveup/movedown)
				
				// Get the roster id
				$rid = $_REQUEST["rid"];
				
				$r = Roster::GetRoster($rid);
				
				if ($r == null || $r->userid != $u->userid) {
					// Roster not found or belongs to someone else
					header('HTTP/1.0 404 Roster not found');
					die();
				}
				
				// Get the opid and seq for op 1
				$seq1 = $_REQUEST["seq1"];
				$roid1 = $_REQUEST["roid1"];
				
				// Get the opid and seq for op 2
				$seq2 = $_REQUEST["seq2"];
				$roid2 = $_REQUEST["roid2"];
				
				global $dbcon;
				$sql = "UPDATE RosterOperative SET seq = ? WHERE rosterid = ? AND rosteropid = ?;";
				
				// Op 1
				$cmd = $dbcon->prepare($sql);
				$paramtypes = "sss";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $seq1;
				$params[] =& $rid;
				$params[] =& $roid1;

				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();
				
				// Op 2
				$cmd = $dbcon->prepare($sql);
				$paramtypes = "sss";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $seq2;
				$params[] =& $rid;
				$params[] =& $roid2;

				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();
				
				// Finally, reorder operatives
				$r->reorderOperatives();
				
				header('Content-Type: text/plain');
				echo "OK";
			} else {
				// Get the new operative from the input JSON
				$newop = RosterOperative::FromJSON(file_get_contents('php://input'));
				
				if ($newop->rosteropid != null || $newop->rosteropid != '') {
					// Try to find this operative
					$ro = RosterOperative::GetRosterOperative($newop->rosteropid);
					
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
						header("HTTP/1.0 401 Invalid operative for this roster's killteam");
						die();
					} else {
						// Save this operative to DB
						$newop->DBSave();
						
						// Reorder operatives so their seqs are always sequential
						$r->reorderOperatives();
						
						// Get a fresh copy of this operative
						$newop = RosterOperative::GetRosterOperative($newop->rosteropid);
						
						// Done
						header('Content-Type: application/json');
						echo json_encode($newop);
					}
				}
			}
		}
	}
?>
