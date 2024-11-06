<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;

	Utils::SetApiHeaders();
  header("Access-Control-Allow-Methods: OPTIONS, POST");
	
	switch ($_SERVER['REQUEST_METHOD']) {
		case "POST":
			// Update roster's operative order
			POSTRosterOpSeq();
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
	
	function POSTRosterOpSeq() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();

			// Get the input
      $seqs = json_decode(file_get_contents('php://input'));

      $roster = Roster::GetRoster($seqs->rosterid);
      if ($roster == null) {
        header('HTTP/1.0 404 Roster not found');
        die();
      } else {
        if ($roster->userid != $u->userid) {
          // This roster belongs to someone else - Fail
          header('HTTP/1.0 404 Roster not found');
          die();
        } else {
          global $dbcon;

          // Parse the operative IDs and their orders
          foreach($seqs->operatives as $op) {
            $sql = "UPDATE RosterOperative SET seq = ? WHERE rosteropid = ? AND rosterid = ? AND userid = ?;";
            
            $cmd = $dbcon->prepare($sql);

            $paramtypes = "isss";

            $params = array();
            $params[] =& $paramtypes;
            $params[] =& $op->seq;
            $params[] =& $op->rosteropid;
            $params[] =& $roster->rosterid;
            $params[] =& $roster->userid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();
          }

          // Now reorder the whole roster
          $roster->reorderOperatives();

          // All done
          echo '{"success": "OK"}';
        }
      }
		}
	}
