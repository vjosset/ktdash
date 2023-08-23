<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
	echo "User Agent: " . $_SERVER['HTTP_USER_AGENT'] . "<br/><br/>";
	//$bi = get_browser(null, true);
	//echo "Browser: " . $bi->browser . "<br/>";
	//echo "Platform: " . $bi->platform . "<br/>";
	
	//print_r($bi);
	
	$p = 'sdgdfg';
	echo hash('sha256', $p);
	
	for ($i = 0; $i < 100; $i++) {
		echo CommonUtils\shortId(7) . "<br/>";
	}
?>
<br/><br/>
<?php

?>