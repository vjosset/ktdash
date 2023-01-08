<?php
	echo "User Agent: " . $_SERVER['HTTP_USER_AGENT'] . "<br/><br/>";
	$bi = get_browser(null, true);
	echo "Browser: " . $bi->browser . "<br/>";
	echo "Platform: " . $bi->platform . "<br/>";
	
	print_r($bi);
?>
<br/><br/>
<?php
echo preg_match('/[^a-zA-Z0-9_]/', "vince") . "<br/>";
echo preg_match('/[^a-zA-Z0-9_]/', "v.nce") . "<br/>";
echo preg_match('/[^a-zA-Z0-9_]/', "v/e") . "<br/>";
echo preg_match('/[^a-zA-Z0-9_]/', "vi e") . "<br/>";
?>