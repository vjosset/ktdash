<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
	global $perf;
    
    switch ($_SERVER['REQUEST_METHOD']) {
		case "POST":
			// Create or update a roster
			header('Content-Type: application/json');
			POSTRosterSpotlight();
			break;
        default:
            // Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }
	
	function POSTRosterSpotlight() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			if ($u->userid != 'vince') {
				// Not vince - Return error				
				header('HTTP/1.0 401 Unauthorized - You are not logged in');
				die();
			} else {
				$rid = getIfSet($_REQUEST["rid"]);
				$on = getIfSet($_REQUEST["on"]);
				
				global $dbcon;
				
				$sql = "UPDATE Roster SET spotlight = ? WHERE rosterid = ?;";
				
				// Roster 1
				$cmd = $dbcon->prepare($sql);
				$paramtypes = "ss";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $on;
				$params[] =& $rid;

				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();
				
				echo '{"success": "ok"}';
			}	
		}
	}
?>
