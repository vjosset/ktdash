<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested operative's portrait
			GETRosterOperativePortrait();
			break;
		case "POST":
			//Create a new operative portrait
			POSTRosterOperativePortrait();
			break;
		case "DELETE":
			//Delete an existing operative portrait
			DELETERosterOperativePortrait();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETRosterOperativePortrait() {
		// Get the requested operative
		$roid = $_REQUEST['roid'];
		
		if ($roid == null || $roid == '') {
			// No rosteropid specified - fail
			header('HTTP/1.0 404 Invalid rosteropid');
			die();
		} else {
			// Try to find this operative
			$ro = RosterOperative::GetRosterOperative($roid);
			
			if ($ro != null) {
				// Check if this operative has a custom portrait
				$custopportraitpath = "../img/customportraits/user_{$ro->userid}/roster_{$ro->rosterid}/op_{$ro->rosteropid}.jpg";
				if (file_exists($custopportraitpath)) {
					// File was found; read it and serve it
					$filepath = $custopportraitpath;
				} else {
					// File not found, serve the generic portrait for this operative
					$filepath = "../img/portraits/{$ro->factionid}/{$ro->killteamid}/{$ro->fireteamid}/{$ro->opid}.jpg";
				}
				
				// Read the found file and serve it
				$thumb = imagecreatefromstring(file_get_contents($filepath));
				header('Content-Type: image/jpg');
				header('Content-Disposition: filename="' . $ro->opname . '.jpg"');
				imagejpeg($thumb);
			} else {
				// Operative not found - Serve nothing?
				header('HTTP/1.0 404 Operative not found');
				die();
			}
		}
    }
	
	function DELETERosterOperativePortrait() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the requested operative
			$roid = $_REQUEST['roid'];
			
			if ($roid == null || $roid == '') {
				// No rosteropid specified - fail
				header('HTTP/1.0 404 Invalid rosteropid');
				die();
			} else {
				// Try to find this operative
				$ro = RosterOperative::GetRosterOperative($roid);
				if ($ro == null) {
					header('HTTP/1.0 404 Operative not found');
					die();
				} else {
					if ($ro->userid != $u->userid) {
						// This operative belongs to someone else - Fail
						header('HTTP/1.0 404 Operative not found');
						die();
					} else {
						// Delete the portrait for this operative
						$custopportraitpath = "../img/customportraits/user_{$ro->userid}/roster_{$ro->rosterid}/op_{$ro->rosteropid}.jpg";
						unlink($custopportraitpath);
						echo "OK";
					}
				}
			}
		}
	}
	
	function POSTRosterOperativePortrait() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();
			
			// Get the requested operative
			$roid = $_REQUEST['roid'];
			
			if ($roid == null || $roid == '') {
				// No rosteropid specified - fail
				header('HTTP/1.0 404 Invalid rosteropid');
				die();
			} else {
				// Try to find this operative
				$ro = RosterOperative::GetRosterOperative($roid);
				if ($ro == null) {
					header('HTTP/1.0 404 Operative not found A');
					die();
				} else {
					if ($ro->userid != $u->userid) {
						// This operative belongs to someone else - Fail
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
							
							// Scale the image
							$img = imagescale($img, 600);
							
							// Resize the image
							$thumb = Utils::ResizeImage($img, 600, 400);
							
							echo $thumb;
							
							// Save the file
							$custopportraitfolderpath = "../img/customportraits/user_{$ro->userid}/roster_{$ro->rosterid}";
							$customopportraitimgpath = $custopportraitfolderpath . "/op_{$ro->rosteropid}.jpg";
							if (!is_dir($custopportraitfolderpath)) {
								mkdir($custopportraitfolderpath);
							}
							
							if (!imagejpeg($thumb, $customopportraitimgpath) ) {
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
