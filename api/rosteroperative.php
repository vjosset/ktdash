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
		$roid = getIfSet($_REQUEST['roid']);
		
		if ($roid == null || $roid == '' || strlen($roid) > 10) {
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
				header('Content-Type: application/json');
				echo json_encode($ro);
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
			$roid = getIfSet($_REQUEST['roid']);
			
			if ($roid == null || $roid == '' || strlen($roid) > 10) {
				// No rosteropid specified - fail
				header('HTTP/1.0 404 Invalid rosteropid');
				die();
			} else {
				// Try to find this operative
				$ro = RosterOperative::GetRosterOperativeRow($roid);
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
						
						// Delete this operative's portrait if it exists
						$custrosteropportraitpath = "../img/customportraits/user_{$ro->userid}/roster_{$ro->rosterid}/op_{$ro->rosteropid}.jpg";
						if (file_exists($custrosteropportraitpath)) {
							unlink($custrosteropportraitpath);
						}
						
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
			
			if (getIfSet($_REQUEST["swapseq"]) == "1") {
				// Swap the Seqs for two operatives (moveup/movedown)
				
				// Get the roster id
				$rid = getIfSet($_REQUEST["rid"]);
		
				// Validate Input
				if (strlen($rid) > 10) {
					header("HTTP/1.0 400 Invalid Input");
					die();
				}
				
				$r = Roster::GetRoster($rid);
				
				if ($r == null || $r->userid != $u->userid) {
					// Roster not found or belongs to someone else
					header('HTTP/1.0 404 Roster not found A');
					die();
				}
				
				// Get the opid and seq for op 1
				$seq1  = getIfSet($_REQUEST["seq1"]);
				$roid1 = getIfSet($_REQUEST["roid1"]);
				
				// Get the opid and seq for op 2
				$seq2  = getIfSet($_REQUEST["seq2"]);
				$roid2 = getIfSet($_REQUEST["roid2"]);
				
				// Validate Input
				if (strlen($seq1) > 3 || strlen($roid1) > 10 || strlen($seq2) > 3 || strlen($roid2) > 10) {
					header("HTTP/1.0 400 Invalid Input");
					die();
				}
				
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
			}
			else {
				// Get the new operative from the input JSON
				header("Step1: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
				$newop = RosterOperative::FromJSON(file_get_contents('php://input'));
				
				if ($newop->rosteropid != null || $newop->rosteropid != '') {
					// Try to find this operative
					$ro = RosterOperative::GetRosterOperativeRow($newop->rosteropid);
					
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
				header("Step2: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
				$r = Roster::GetRosterRow($newop->rosterid);
				header("Step3: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
				if ($r == null || $r->userid != $u->userid) {
					// Roster not found or belongs to someone else
					header('HTTP/1.0 404 Roster not found B');
					die();
				} else {
					// All good
					if ($newop->rosteropid == null || $newop->rosterid == "") {
						// No roster operative ID, generate a new one
						$newop->rosteropid = RosterOperative::GetNewRosterOpId();
						
						// This means this is a new operative that was added to the team; set its set to be last in the roster
						$newop->seq = 10000;
						
						// Set its curW based on the the base operative's W
						header("Step4: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
						$baseop = Operative::GetOperative($newop->factionid, $newop->killteamid, $newop->fireteamid, $newop->opid);
						if (is_numeric($baseop->W)) {
							$newop->curW = $baseop->W;
						} else {
							$newop->curW = 0;
						}
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
						header("Step5: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
						header("InjuredIn: " . $newop->isinjured);
						$newop->DBSave();
						
						// Reorder operatives so their seqs are always sequential
						header("Step6: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
						$r->reorderOperatives();
						
						// Get a fresh copy of this operative
						header("Step7: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
						$newop = RosterOperative::GetRosterOperative($newop->rosteropid);
						
						// Done
						header("Step8: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
						header('Content-Type: application/json');
						echo json_encode($newop);
					}
				}
			}
		}
	}
?>
