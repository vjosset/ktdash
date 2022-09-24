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
		
		if ($utid == null || $utid == '') {
			// No killteam id passed in, return all this user's teams (if they are logged in)
			
			if (!Session::IsAuth()) {
				// Not logged in - Return error				
				header('HTTP/1.0 401 Unauthorized - You are not logged in"');
				die();
			} else {
				// Logged in - Get this user's teams
				$u = Session::CurrentUser();
				$u->loadUserTeams();
				$uts = $u->userteams;
				echo json_encode($uts);
			}
		} else {
			// Return the requested user team
			$userteam = UserTeam::GetUserTeam($utid);
			echo json_encode($userteam);
		}
    }
?>
