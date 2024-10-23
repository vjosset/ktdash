<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;

	Utils::SetApiHeaders();
  header("Access-Control-Allow-Methods: OPTIONS, POST");
	
	switch ($_SERVER['REQUEST_METHOD']) {
		case "POST":
			// Update an op's current order
			POSTRosterOpOrder();
			break;
    case "OPTIONS":
      echo "";
      break;
		default:
			// Invalid verb
			header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
			break;
	}
	
	function POSTRosterOpOrder() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the requested op
			$roid = getIfSet($_REQUEST['roid']);
			$order = getIfSet($_REQUEST['order']);
			
			if ($roid == null || $roid == '') {
				// No opid specified or invalid op id - fail
				header('HTTP/1.0 404 Operative not found');
				die();
			} else {
				// Try to find this op
				$op = RosterOperative::FromDB($roid);
				if ($op == null) {
					header('HTTP/1.0 404 Operative not found');
					die();
				} else {
					if ($op->userid != $u->userid) {
						// This op belongs to someone else - Fail
						header('HTTP/1.0 404 Operative not found');
						die();
					} else {
						global $dbcon;

            if ($order != 'engage' && $order != 'conceal') {
              header('HTTP/1.0 400 Invalid order - Must be "conceal" or "engage"');
              die();
            }

						$sql = "UPDATE RosterOperative SET oporder = ? WHERE rosteropid = ?;";
						
						$cmd = $dbcon->prepare($sql);

						$paramtypes = "ss";

						$params = array();
						$params[] =& $paramtypes;
						$params[] =& $order;
						$params[] =& $roid;

						call_user_func_array(array($cmd, "bind_param"), $params);
						$cmd->execute();

						// All done
						echo '{"success": "OK"}';
					}
				}
			}
		}
	}
