<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    header('Content-Type: application/json');
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the operatiev
			GETOperative();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETOperative() {
		// Get the requested filters
		$killteamid = $_REQUEST['killteamid'];
		$opid = $_REQUEST['opid'];
		
		if ($opid != '') {
			// Return requested operative
			$ops = Operative::GetOperative($opid);
		} else if ($killteamid != '') {
			// Return operatives in the requested faction
			$ops = Operative::GetOperatives($killteamid);
		} else {
			// Return all operatives
			$ops = Operative::GetOperatives();
		}
		
		echo json_encode($ops);
    }
?>
