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
				$custrosterportraitpath = "../img/customportraits/user_{$r->userid}/roster_{$r->rosterid}/roster_{$r->rosterid}.jpg";
				if (file_exists($custrosterportraitpath)) {
					// File was found; read it and serve it
					$filepath = $custrosterportraitpath;
				
					// Read the found file and serve it
					$thumb = imagecreatefromstring(file_get_contents($filepath));
					header('Content-Type: image/jpg');
					header('Content-Disposition: filename="' . $r->rostername . '.jpg"');
					imagejpeg($thumb);
				} else {
					// File not found, serve the generic portrait for this roster
					$filepath = "../img/portraits/{$r->factionid}/{$r->killteamid}/{$r->killteamid}.png";
				
					// Read the found file and serve it
					$thumb = imagecreatefromstring(file_get_contents($filepath));
					header('Content-Type: image/png');
					header('Content-Disposition: filename="' . $r->rostername . '.png"');
					imagepng($thumb);
				}
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
						$custrosterportraitpath = "../img/customportraits/user_{$r->userid}/roster_{$r->rosterid}/roster_{$r->rosterid}.jpg";
						if (file_exists($custrosterportraitpath)) {
							unlink($custrosterportraitpath);
						}
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
						if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
							// File failed to upload
							$phpFileUploadErrors = array(
								0 => 'There is no error, the file uploaded with success',
								1 => 'File is too large', // 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
								2 => 'File is too large', // 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
								3 => 'The uploaded file was only partially uploaded',
								4 => 'No file was uploaded',
								6 => 'Missing a temporary folder',
								7 => 'Failed to write file to disk.',
								8 => 'A PHP extension stopped the file upload.',
							);
							header("HTTP/1.0 400 " . $phpFileUploadErrors[$_FILES['file']['error']]);
							die();
						}
						
						$filesize = $_FILES["file"]["size"];
						$tmpext = explode('.', $filename);
						$fileext = strtolower(end($tmpext));
						
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
							
							// Scale the image
							$img = imagescale($img, 900);
							
							// Resize the image
							$thumb = Utils::ResizeImage($img, 900, 600);
							
							// Output the image
							echo $thumb;
							
							// Save the file
							
							$custrosterportraitfolderpath = "../img/customportraits/user_{$r->userid}/roster_{$r->rosterid}";
							$custrosterportraitimgpath = $custrosterportraitfolderpath . "/roster_{$r->rosterid}.jpg";
							if (!is_dir($custrosterportraitfolderpath)) {
								mkdir($custrosterportraitfolderpath, 0777, true);
							}
							
							if (!imagejpeg($thumb, $custrosterportraitimgpath) ) {
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
