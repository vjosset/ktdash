<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			// Make the test directories
			global $dbcon;
			
			// Make the root directory for custom portraits
			mkdir("../img/customportraits");
			
			// Get all operatives
			$sql = "SELECT userid, rosterid, rosteropid FROM RosterOperative;";
			$cmd = $dbcon->prepare($sql);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {
					// Check if this roster has a custom portrait
					$newrosterfolderpath = "../img/customportraits/user_" . $row->userid . "/roster_" . $row->rosterid;
					$oldrosterimgpath = "../img/rosterportraits/" . $row->rosterid . ".jpg";
					if (file_exists($oldrosterimgpath)) {
						// There is a portrait for this roster; create the appropriate directory for it
						mkdir($newrosterfolderpath, 0777, true);
						
						// Now copy the old portrait to the new folder
						copy($oldrosterimgpath, $newrosterfolderpath . "/roster_" . $row->rosterid . ".jpg");
					}
					
					// Check if this operative has a custom portrait
					$oldopimgpath = "../img/opportraits/" . $row->rosteropid . ".jpg";
					if (file_exists($oldopimgpath)) {
						// There is a portrait for this roster; copy it to its new place
						mkdir($newrosterfolderpath, 0777, true);
						$newopimgpath = "../img/customportraits/user_" . $row->userid . "/roster_" . $row->rosterid . "/op_" . $row->rosteropid . ".jpg";
						copy($oldopimgpath, $newopimgpath);
					}
                }
            }
			
			break;
	}
?>
