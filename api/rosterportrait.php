<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

Utils::SetApiHeaders();

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
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function GETRosterPortrait()
{
	global $dbcon;

	// Get the requested roster
	$rid = $_REQUEST['rid'];
	$log = "";

	if ($rid == null || $rid == '' || strlen($rid) > 10) {
		// No rosterid specified - fail
		header('HTTP/1.0 404 Invalid rosterid');
		die();
	} else {
		// Try to find this roster
		$log .= "GR:" . microtime(true);
		$r = Roster::GetRosterRow($rid);
		$log .= "-" . microtime(true);

		if ($r != null) {
			// Check if this roster has a custom portrait
			$custrosterportraitpath = "../img/customportraits/user_{$r->userid}/roster_{$r->rosterid}/roster_{$r->rosterid}.jpg";
			$log .= "CF:" . microtime(true);
			if (file_exists($custrosterportraitpath)) {
				$log .= "-Y" . microtime(true);
				// File was found; read it and serve it
				$filepath = $custrosterportraitpath;

				header('Timings: ' . $log);

				if ($r->hascustomportrait != 1) {
					// Update the operative's "hascustomportrait" field
					global $dbcon;
					$sql = "UPDATE Roster SET hascustomportrait = 1 WHERE rosterid = ?";
					$cmd = $dbcon->prepare($sql);
					$paramtypes = "s";
					$params = array();
					$params[] =& $paramtypes;
					$params[] =& $r->rosterid;
					call_user_func_array(array($cmd, "bind_param"), $params);
					$cmd->execute();
				}

				// Read the found file and serve it
				//$thumb = imagecreatefromstring(file_get_contents($filepath));
				header('Content-Type: image/jpeg');
				//header('Cache-Control: max-age=604800');
				header('Content-Disposition: inline; filename="' . str_replace("\r\n", " ", $r->rostername) . '.jpg"');
				echo file_get_contents($filepath);
			} else {
				$log .= "-N" . microtime(true);
				// File not found, serve the generic portrait for this roster

				if ($r->hascustomportrait != 0) {
					// Update the roster's "hascustomportrait" field
					global $dbcon;
					$sql = "UPDATE Roster SET hascustomportrait = 0 WHERE rosterid = ?";
					$cmd = $dbcon->prepare($sql);
					$paramtypes = "s";
					$params = array();
					$params[] =& $paramtypes;
					$params[] =& $r->rosterid;
					call_user_func_array(array($cmd, "bind_param"), $params);
					$cmd->execute();
				}

				$filepath = "../img/portraits/{$r->factionid}/{$r->killteamid}/{$r->killteamid}.jpg";

				// Check if file exists
				if (!file_exists($filepath)) {
					header('HTTP/1.0 404 Portrait not found');
					die();
				}

				header('HTTP/1.0 302 Default Roster Portrait');
				header("Location: /img/portraits/{$r->factionid}/{$r->killteamid}/{$r->killteamid}.jpg");
			}
		} else {
			// Roster not found - Serve nothing?
			header('HTTP/1.0 404 Roster not found');
			die();
		}
	}
}

function DELETERosterPortrait()
{
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

		if ($rid == null || $rid == '' || strlen($rid) > 10) {
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

					if ($r->hascustomportrait != 0) {
						// Update the roster's "hascustomportrait" field
						global $dbcon;
						$sql = "UPDATE Roster SET hascustomportrait = 0 WHERE rosterid = ?";
						$cmd = $dbcon->prepare($sql);
						$paramtypes = "s";
						$params = array();
						$params[] =& $paramtypes;
						$params[] =& $r->rosterid;
						call_user_func_array(array($cmd, "bind_param"), $params);
						$cmd->execute();
					}

					// Done
					echo "OK";
				}
			}
		}
	}
}

function POSTRosterPortrait()
{
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

		if ($rid == null || $rid == '' || strlen($rid) > 10) {
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
					if (!isset($_FILES["file"])) {
						header("HTTP/1.0 400 No file uploaded");
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
						header("HTTP/1.0 400 " . $phpFileUploadErrors[$_FILES['file']['error']]);
						die();
					}

					$filesize = $_FILES["file"]["size"];
					$fileext = strtolower(pathinfo($filename)['extension']);

					// Save the resized image
					if (!in_array($fileext, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'))) {
						header('HTTP/1.0 400 Invalid File Extension');
						die();
					} else if ($filesize > 10485760) {
						header('HTTP/1.0 400 Max portrait size is 5 MB');
						die();
					} else {
						// Get the uploaded image
						$img = imagecreatefromstring(file_get_contents($tempname));

						// Get the image orientation so uploads don't go sideways
						if (function_exists('exif_read_data')) {
							// Suppress warning with "@"; some images can't have exif and there's no way to tell until we try but it puts warnings in the log
							$exif = @exif_read_data($tempname);
							if ($exif && isset($exif['Orientation'])) {
								$orientation = $exif['Orientation'];
								if ($orientation != 1) {
									$deg = 0;
									switch ($orientation) {
										case 3:
											$deg = 180;
											break;
										case 6:
											$deg = 270;
											break;
										case 8:
											$deg = 90;
											break;
									}

									if ($deg) {
										// Rotate it back to proper orientation
										$img = imagerotate($img, $deg, 0);
									}

									// Rewrite the rotated image back to the disk as $filename 
									imagejpeg($img, $tempname, 95);
								}
							}
						}

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

						if (!imagejpeg($thumb, $custrosterportraitimgpath)) {
							// Failed to save the image
							header("HTTP/1.0 500 Could not save portrait");
							die();
						} else {
							if ($r->hascustomportrait != 1) {
								// Update the roster's "hascustomportrait" field
								global $dbcon;
								$sql = "UPDATE Roster SET hascustomportrait = 1 WHERE rosterid = ?";
								$cmd = $dbcon->prepare($sql);
								$paramtypes = "s";
								$params = array();
								$params[] =& $paramtypes;
								$params[] =& $r->rosterid;
								call_user_func_array(array($cmd, "bind_param"), $params);
								$cmd->execute();
							}
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
