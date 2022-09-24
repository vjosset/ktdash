<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    header('Content-Type: application/json');
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested roster/user team
			GETUserTeam();
			break;
		case "POST":
			//Create a new roster/user team
			POSTUserTeam();
			break;
		case "PUT":
			//Update an existing roster/user team
			PUTUserTeam();
			break;
		case "DELETE":
			//Delete an existing roster/user team
			DELETEUserTeam();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETUserTeam() {
		// Get the requested user team
		$utid = $_REQUEST['utid'];
		$uid = $_REQUEST['uid'];
		
		sleep(1);
		
		if ($utid == null || $utid == '') {
			// No killteam id passed in, return the specified user's teams
			
			if ($uid == null || $uid == '') {
				// Use the current user as the user whose teams to return
				if (!Session::IsAuth()) {
					// Not logged in - Return error				
					header('HTTP/1.0 401 Unauthorized - You are not logged in"');
					die();
				} else {
					$uid = Session::CurrentUser()->userid;
				}
			}
			
			// Get the teams for this user
			$u = User::FromDB($uid);
			$u->loadUserTeams();
			echo json_encode($u->userteams);
		} else {
			// Return the requested user team
			echo json_encode(UserTeam::GetUserTeam($utid));
		}
    }
	
	function DELETEUserTeam() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the requested user team
			$utid = $_REQUEST['utid'];
			$ut = UserTeam::GetUserTeam($utid);
			
			// Validate the team's owner
			if ($ut->userid == $u->userid) {
				// Current user owns this team, OK to delete
				$ut->DBDelete();
				
				// Delete operatives
				foreach($ut->operatives as $op) {
					$op->DBDelete();
				}
				echo "OK";
			} else {
				// Team belongs to someone else
				header('HTTP/1.0 401 Unauthorized - This team does not belong to you"');
				die();
			}
		}
	}
?>
