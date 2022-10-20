<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested thing
			GETID();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

	function GETID() {
		// Return a shortid
		$chars = ['B', 'C', 'D', 'F', 'G', 'H', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
			
		$out = '';
		$len = 10;
		$blocksize = 1000;
		
		for ($i = 0; $i < $len; $i++) {
			if ($i % $blocksize == 0 && $i > 0) {
				$out .= "-";
			}
			$out .= $chars[rand(0, sizeof($chars) - 1)];
		}
		
		echo $out;
	}

?>

