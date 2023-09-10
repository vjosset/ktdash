<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
	echo "User Agent: " . $_SERVER['HTTP_USER_AGENT'] . "<br/><br/>";
	//$bi = get_browser(null, true);
	//echo "Browser: " . $bi->browser . "<br/>";
	//echo "Platform: " . $bi->platform . "<br/>";
	
	//print_r($bi);
	
	$p = 'asfdjhasdf';
	//echo hash('sha256', $p);
	
	echo password_hash($p, PASSWORD_DEFAULT);
	echo "<br/><br/>";
	echo hash('sha256', $p);
?>
<br/><br/>
<?php

?>