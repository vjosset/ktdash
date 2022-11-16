<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested PDF render
			GETRender();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETRender() {
		// Get the requested input to render (operative card or full roster)
		$scope = getIfSet($_REQUEST["scope"]);
		
		if ($scope != "op" && $scope != "roster") {
            header('HTTP/1.0 400 Invalid Scope');
			die();
		}
		
		$indocAPIKey = "D7C57EED-CCE5-4EB7-A6DA-BF6D0E724366";
		
		if ($scope == "op") {
			// Render the operative card
			// Get the operative
			$roid = getIfSet($_REQUEST["roid"]);
			if ($roid == "" || $roid == null || strlen($roid > 10)) {
				header('HTTP/1.0 400 Invalid Roster Operative ID');
				die();
			}
			
			$op = RosterOperative::GetRosterOperative($roid);
			if ($op == null) {
				header('HTTP/1.0 404 Operative not found');
				die();
			}
			
			// Input is validated, let's build the render URL
			$url = "https://indocpdf.com/api/pdfrender.php?apikey=" . $indocAPIKey . "&showbackground=false&filename=" . urlencode($op->opname) . ".pdf&url=" . urlencode("https://ktdash.app/printop.php?roid=" . $op->rosteropid);
			
			// Get the file content
			$data = file_get_contents($url);
			
			if ($data === false) {
				// Render failed
				header('HTTP/1.0 500 Could not render roster');
				die();
			}
			
			// Spit it out
			header("Content-type: application/pdf");
			header("Content-disposition: inline; filename=" . $op->opname . ".pdf");
			echo $data;
		}
		else if ($scope == "roster") {
			// Render the full roster
			// Get the roster
			$rid = getIfSet($_REQUEST["rid"]);
			if ($rid == "" || $rid == null || strlen($rid > 10)) {
				header('HTTP/1.0 400 Invalid Roster ID');
				die();
			}
			
			$r = Roster::GetRoster($rid);
			if ($r == null) {
				header('HTTP/1.0 404 Roster not found');
				die();
			}
			
			// Input is validated, let's build the render URL
			$url = "https://indocpdf.com/api/pdfrender.php?apikey=" . $indocAPIKey . "&showbackground=false&filename=" . urlencode($r->rostername) . ".pdf&url=" . urlencode("https://ktdash.app/printroster.php?rid=" . $r->rosterid);
			
			// Get the file content
			$data = file_get_contents($url);
			
			if ($data === false) {
				// Render failed
				header('HTTP/1.0 500 Could not render roster');
				die();
			}
			
			// Spit it out
			header("Content-type: application/pdf");
			header("Content-disposition: inline; filename=" . $r->rostername . ".pdf");
			echo $data;
		}
    }
?>
