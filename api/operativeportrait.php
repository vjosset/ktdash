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
		
		// Validate Input
		if (strlen($roid) > 10) {
            header("HTTP/1.0 400 Invalid Input");
			die();
		}
		
		if ($roid == null || $roid == '') {
			// No rosteropid specified - Look for default roster to use
			$fa = getIfSet($_REQUEST['fa'], '');
			$kt = getIfSet($_REQUEST['kt'], '');
			$ft = getIfSet($_REQUEST['ft'], '');
			$op = getIfSet($_REQUEST['op'], '');
			
			if ($fa == '' || $kt == '' || $ft == '' || $op == '') {
				// Missing at least one input
				header('HTTP/1.0 404 Invalid rosteropid');
				die();
			} else {
				// Got all inputs, find the appropriate custom portrait to use by defaut for this operative
				
			}
		} else {
			// Try to find this roster operative
			$ro = RosterOperative::GetRosterOperative($roid);
			
			if ($ro != null) {
				// Check if this operative has a custom portrait
				$custopportraitpath = "../img/customportraits/user_{$ro->userid}/roster_{$ro->rosterid}/op_{$ro->rosteropid}.jpg";
				if (file_exists($custopportraitpath)) {
					// File was found; read it and serve it
					$filepath = $custopportraitpath;
					
					// Read the found file and serve it
					if ($ro->hascustomportrait != 1) {
						// Update the operative's "hascustomportrait" field
						global $dbcon;
						$sql = "UPDATE RosterOperative SET hascustomportrait = 1 WHERE rosteropid = ?";
						$cmd = $dbcon->prepare($sql);
						$paramtypes = "s";
						$params = array();
						$params[] =& $paramtypes;
						$params[] =& $ro->rosteropid;
						call_user_func_array(array($cmd, "bind_param"), $params);
						$cmd->execute();
					}
				} else {
					// Custom file not found, serve the generic portrait for this operative
					$filepath = "../img/portraits/{$ro->factionid}/{$ro->killteamid}/{$ro->fireteamid}/{$ro->opid}.jpg";
					
					// Check if file exists
					if (!file_exists($filepath)) {
						header('HTTP/1.0 404 Portrait not found');
						die();
					}
						
					// No custom portrait for this operative
					if ($ro->hascustomportrait != 0) {
						// Update the operative's "hascustomportrait" field
						global $dbcon;
						$sql = "UPDATE RosterOperative SET hascustomportrait = 0 WHERE rosteropid = ?";
						$cmd = $dbcon->prepare($sql);
						$paramtypes = "s";
						$params = array();
						$params[] =& $paramtypes;
						$params[] =& $ro->rosteropid;
						call_user_func_array(array($cmd, "bind_param"), $params);
						$cmd->execute();
					}
				}
				header('Content-Type: image/jpeg');
				header('Content-Disposition: inline; filename="' . str_replace("\r\n", " ", $ro->opname) . '.jpg"');
				//header('Cache-Control: max-age=604800');
				echo file_get_contents($filepath);
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
			
			if ($roid == null || $roid == '' || strlen($roid) > 10) {
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
						if (file_exists($custopportraitpath)) {
							unlink($custopportraitpath);
						}
						
						// Success
						// Update the operative's "hascustomportrait" field
						global $dbcon;
						$sql = "UPDATE RosterOperative SET hascustomportrait = 0 WHERE rosteropid = ?";
						$cmd = $dbcon->prepare($sql);
						$paramtypes = "s";
						$params = array();
						$params[] =& $paramtypes;
						$params[] =& $ro->rosteropid;
						call_user_func_array(array($cmd, "bind_param"), $params);
						$cmd->execute();
						
						// Done
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
			
			if ($roid == null || $roid == '' || strlen($roid) > 10) {
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
						// Get the submitted image and validate it, then resize and save it
						if (!isset($_FILES["file"])) {
							// No file uploaded
							header("HTTP/1.0 400 No portrait image uploaded");
							die();
						}
					
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
							if ($_FILES['file']['error'] >= 0 && $_FILES['file']['error'] < 9) {
								header("HTTP/1.0 400 " . $phpFileUploadErrors[$_FILES['file']['error']]);
							} else {
								header("HTTP/1.0 400 Could not upload portrait image");
							}
							die();
						}
						$filesize= $_FILES['file']['size'];
						$fileext = strtolower(pathinfo($filename)['extension']);
						
						// Save the resized image
						if (!in_array($fileext, array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF'))) {
							header('HTTP/1.0 400 Invalid File Extension');
							die();
						} else if($filesize > 10485760) {
							header('HTTP/1.0 400 Max portrait size is 5 MB');
							die();
						} else {
							// Get the uploaded image
							$img = imagecreatefromstring(file_get_contents($tempname));
							
							// Scale the image
							$img = imagescale($img, 900);
							
							// Resize the image
							$thumb = Utils::ResizeImage($img, 900, 600);
							
							echo $thumb;
							
							// Save the file
							$custopportraitfolderpath = "../img/customportraits/user_{$ro->userid}/roster_{$ro->rosterid}";
							$customopportraitimgpath = $custopportraitfolderpath . "/op_{$ro->rosteropid}.jpg";
							if (!is_dir($custopportraitfolderpath)) {
								mkdir($custopportraitfolderpath, 0777, true);
							}
							
							if (!imagejpeg($thumb, $customopportraitimgpath) ) {
								// Failed to save the image
								header("HTTP/1.0 500 Could not save portrait");
								die();
							} else {
								// Success
								// Update the operative's "hascustomportrait" field
								global $dbcon;
								$sql = "UPDATE RosterOperative SET hascustomportrait = 1 WHERE rosteropid = ?";
								$cmd = $dbcon->prepare($sql);
								$paramtypes = "s";
								$params = array();
								$params[] =& $paramtypes;
								$params[] =& $ro->rosteropid;
								call_user_func_array(array($cmd, "bind_param"), $params);
								$cmd->execute();
								
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
