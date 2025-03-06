<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';

class Utils
{
	static function SetApiHeaders($json = true) {
		// Allow cross-origin credentials (cookie)
		header('Access-Control-Allow-Credentials: true');
		
		// Check allowed origins
		$allowedOrigins = [
			'http://localhost:3000',
			'https://localhost:3000',
			'http://localhost:3001',
			'https://localhost:3002',
			'https://ktdash.app',
			'https://192.168.1.103:3000',
			'https://beta.ktdash.app',
			'https://indocpdf.com',
			'https://localhost:57088'
		];
		$origin = "";
		if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
			$origin = $_SERVER['HTTP_ORIGIN'];
		}
		else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
			$origin = $_SERVER['HTTP_REFERER'];
		} else {
			$origin = $_SERVER['REMOTE_ADDR'];
		}

		if (in_array($origin, $allowedOrigins)) {
				header('Access-Control-Allow-Origin: '. $origin);
		}
		
		// Response content is JSON
		if ($json) {
			header('Content-Type: application/json');
		}
	}
	
	static function ValidName($name) {
		$temp = strtolower($name);
		return !(stripos($temp, 'nigg') || stripos($temp, 'fagg'));
	}

	static function TrackEvent($eventtype, $action, $label, $var1, $var2, $var3, $url, $sessiontype, $referrer)
	{
		global $dbcon;

		$sql = "INSERT INTO Event (userid, eventtype, action, label, var1, var2, var3, url, userip, sessiontype, useragent, referrer) ";
		$sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$user = Session::CurrentUser();
		$paramtypes = "ssssssssssss";
		$params = array();
		$userid = ($user == null ? '[anon]' : $user->userid);
		$params[] = $userid; // userid

		$params[] = $eventtype;
		$params[] = $action;
		$params[] = $label;

		$params[] = $var1;
		$params[] = $var2;
		$params[] = $var3;

		$params[] = $url;

		$params[] = $_SERVER['REMOTE_ADDR']; // userip

		$params[] = $sessiontype;
		$params[] = substr(getIfSet($_SERVER['HTTP_USER_AGENT']), 0, 500); // sessiontype

		$params[] = $referrer;

		//// Skip some events to let the table breathe
		//$run = true;
		//switch (substr(getIfSet($_REQUEST['t']), 0, 50) . '|' . substr(getIfSet($_REQUEST['a']), 0, 45)) {
		//	case 'session|signup': // User sign up
		//	case 'roster|opportrait': // New operative portrait
		//	case 'roster|portrait': // New roster portrait
		//	case 'page|view': // Page views
		//		$run = true;
		//		break;
		//	default:
		//		$run = false;
		//		break;
		//}

		//if ($run) {
			$cmd = $dbcon->prepare($sql);
			//call_user_func_array(array($cmd, "bind_param"), $params);
			$cmd->bind_param($paramtypes, ...$params);
			$cmd->execute();
		//}
	}
	
	static function ResizeImage($source, $tw, $th)
	{
		if ($tw == null || $tw == "") {
			//Invalid width
			$tw = 200;
		}
		if ($th == null || $th == "") {
			//Invalid width
			$th = 200;
		}

		//Get the original image dimensions
		$iw = imagesx($source);
		$ih = imagesy($source);

		//Get the image size ratios
		$ir = $iw / $ih;
		$tr = $tw / $th;

		$sx = 0;
		$sy = 0;

		$tx = 0;
		$ty = 0;

		if ($ir == $tr) {
			//Same ratio
			//Keep width and height
			$ch = $ih;
			$cw = $iw;

			//Set the source center (same as origin)
			$tx = 0;
			$ty = 0;

			//Set the destination center
			$sx = 0;
			$sy = 0;
		} elseif ($ir < $tr) {
			//Source image is skinnier than thumbnail
			//Keep width
			$cw = $iw;
			//Scale the height
			$ch = $iw / $tr;

			//Set the source center
			$tx = 0;
			$ty = 0;

			//Set the destination center
			$sx = 0;
			$sy = 0;
		} else {
			//Source image is shorter than thumbnail
			//Keep height
			$ch = $ih;
			//Scale the width
			$cw = $ih * $tr;

			//Set the source center
			$tx = 0;
			$ty = 0;

			//Set the destination center
			$sx = ($iw - $cw) / 2;
			$sy = 0;
		}

		//Prepare the thumbnail image that will be served (always served as PNG)
		$thumb = imagecreatetruecolor($tw, $th);

		//Resize and crop
		imagecopyresampled(
			$thumb,
			$source,

			$tx,
			$ty,
			$sx,
			$sy,

			$tw,
			$th,
			$cw,
			$ch
		);

		//Return the thumbnail
		return $thumb;
	}
}
