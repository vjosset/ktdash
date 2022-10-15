<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested roster's portrait
			GETRosterPortrait();
			break;
		case "POST":
			//Create a new roster portrait
			POSTRosterPortrait();
			break;
		case "DELETE":
			//Delete an existing roster portrait
			DELETERosterPortrait();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETRosterPortrait() {
		// Get the requested roster
		$rid = $_REQUEST['rid'];
		
		if ($rid == null || $rid == '') {
			// No rosterid specified - fail
			header('HTTP/1.0 404 Invalid rosterid');
			die();
		} else {
			// Try to find this roster
			$r = Roster::GetRoster($rid);
			
			if ($r != null) {
				// Check if this roster has a custom portrait
				if (file_exists("../img/rosterportraits/{$rid}.jpg")) {
					// File was found; read it and serve it
					$filepath = "../img/rosterportraits/{$rid}.jpg";
				} else {
					// File not found, serve the generic portrait for this roster
					$filepath = "../img/portraits/{$r->factionid}/{$r->killteamid}/{$r->killteamid}.png";
				}
				
				// Read the found file and serve it
				$thumb = imagecreatefromstring(file_get_contents($filepath));
				header('Content-Type: image/png');
				imagepng($thumb);
			} else {
				// Roster not found - Serve nothing?
				header('HTTP/1.0 404 Roster not found');
				die();
			}
		}
    }
	
	function DELETERosterPortrait() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the requested roster
			$rid = $_REQUEST['rid'];
			
			if ($rid == null || $rid == '') {
				// No rosterid specified - fail
				header('HTTP/1.0 404 Invalid rosterid');
				die();
			} else {
				// Try to find this roster
				$r = Roster::GetRoster($rid);
				if ($r == null) {
					header('HTTP/1.0 404 Roster not found');
					die();
				} else {
					if ($r->userid != $u->userid) {
						// This roster belongs to someone else - Fail
						header('HTTP/1.0 404 Roster not found');
						die();
					} else {
						// Delete the portrait for this roster
						unlink("../img/rosterportraits/{$rid}.jpg");
						echo "OK";
					}
				}
			}
		}
	}
	
	function POSTRosterPortrait() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the requested roster
			$rid = $_REQUEST['rid'];
			
			if ($rid == null || $rid == '') {
				// No rosterid specified - fail
				header('HTTP/1.0 404 Invalid rosterid');
				die();
			} else {
				// Try to find this roster
				$r = Roster::GetRoster($rid);
				if ($r == null) {
					header('HTTP/1.0 404 Roster not found A');
					die();
				} else {
					if ($r->userid != $u->userid) {
						// This roster belongs to someone else - Fail
						header('HTTP/1.0 404 Operative not found B');
						die();
					} else {
						// Get the submitted image and validate it, then resize and save it
						$filename = $_FILES["file"]["name"];
						$tempname = $_FILES["file"]["tmp_name"];
						$filesize= $_FILES['file']['size'];
						$fileext = strtolower(end(explode('.', $filename)));
						
						// Save the resized image
						if (!in_array($fileext, array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF'))) {
							header('HTTP/1.0 400 Invalid File Extension');
							die();
						} else if($filesize > 2097152) {
							header('HTTP/1.0 400 Max portrait size is 2 MB');
							die();
						} else {
							// Get the uploaded image
							$img = imagecreatefromstring(file_get_contents($tempname));
							
							// Resize the image
							$thumb = Utils::ResizeImage($img, 300, 200);
							
							echo $thumb;
							
							// Save the file
							if (!is_dir("../img/rosterportraits")) {
								mkdir("../img/rosterportraits");
							}
							$filepath = "../img/rosterportraits/" . $rid . ".jpg";
							if (!imagejpeg($thumb, $filepath) ) {
								// Failed to save the image
								header("HTTP/1.0 500 Could not save portrait");
								die();
							} else {
								// Done
								echo "OK";
							}
							
							// Free up memory
							imagedestroy($thumb);
						}
					}
				}
			}
		}
	}
?>
