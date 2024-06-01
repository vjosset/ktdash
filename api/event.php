<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    switch ($_SERVER['REQUEST_METHOD']) {
		case "POST":
			// Save the specified event
			POSTEvent();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }
	
	function POSTEvent() {
		global $dbcon;
		
		$sql = "INSERT INTO Event (userid, eventtype, action, label, var1, var2, var3, url, userip, sessiontype, useragent, referrer) ";
		$sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		$user = Session::CurrentUser();
		$paramtypes = "ssssssssssss";
		$params = array();
		$userid = ($user == null ? '[anon]' : $user->userid);
		$params[] = $userid; // userid
		
		$params[] = substr(getIfSet($_REQUEST['t']), 0, 50); // eventtype
		$params[] = substr(getIfSet($_REQUEST['a']), 0, 45); // action
		$params[] = substr(getIfSet($_REQUEST['l']), 0, 45); // label
		
		$params[] = substr(getIfSet($_REQUEST['v1']), 0, 45); // var1
		$params[] = substr(getIfSet($_REQUEST['v2']), 0, 45); // var2
		$params[] = substr(getIfSet($_REQUEST['v3']), 0, 45); // var3
		
		$params[] = substr(getIfSet($_REQUEST['u']), 0, 500); // url
		
		$params[] = $_SERVER['REMOTE_ADDR']; // userip
		
		$params[] = substr(getIfSet($_REQUEST['s']), 0, 50); // sessiontype
		$params[] = substr(getIfSet($_SERVER['HTTP_USER_AGENT']), 0, 500); // sessiontype
		
		$params[] = substr(getIfSet($_REQUEST['r']), 0, 500); // referrer

		$cmd = $dbcon->prepare($sql);
		//call_user_func_array(array($cmd, "bind_param"), $params);
		$cmd->bind_param($paramtypes, ...$params);
		$cmd->execute();

		echo "OK";
	}
?>
