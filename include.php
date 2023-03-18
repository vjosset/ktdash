<?php
	session_start();
	
    //Put all includes here, so that actual pages only need to include this include.php file
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/db.php';
    
    require_once $root . '/../common/include.php';
    
    require_once $root . '/classes/utils.php';
    require_once $root . '/classes/weaponprofile.php';
    require_once $root . '/classes/weapon.php';
	require_once $root . '/classes/ploy.php';
	require_once $root . '/classes/equipment.php';
	require_once $root . '/classes/ability.php';
	require_once $root . '/classes/uniqueaction.php';
    require_once $root . '/classes/operative.php';
    require_once $root . '/classes/fireteam.php';
    require_once $root . '/classes/killteam.php';
	require_once $root . '/classes/faction.php';
	require_once $root . '/classes/user.php';
	require_once $root . '/classes/session.php';
	require_once $root . '/classes/roster.php';
	require_once $root . '/classes/rosteroperative.php';
	require_once $root . '/classes/tacop.php';
	
	function replacedistance($input) {
		$output = $input;
		$output = str_replace('[TRI]', '&#x25B2;', $output);
		$output = str_replace('[CIRCLE]', '&#x2B24;', $output);
		$output = str_replace('[SQUARE]', '&#9632;', $output);
		$output = str_replace('[PENT]', '&#x2B1F;', $output);
		
		// Done
		return $output;
	}
	
	function getIfSet(&$value, $default = "")
	{
		return isset($value) ? $value : $default;
	}
?>
