<?php
	echo "User Agent: " . $_SERVER['HTTP_USER_AGENT'] . "<br/><br/>";
	$bi = get_browser(null, true);
	echo "Browser: " . $bi->browser . "<br/>";
	echo "Platform: " . $bi->platform . "<br/>";
	
	print_r($bi);
?>