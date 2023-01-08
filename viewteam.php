<?php
	// Convert old team format to new roster format
	// Look for common links (Vince's teams)
	
	// /viewteam.php?importteam=Phobos|IMP|PHO|PHO/RVRSGT/Sergeant/SIBP,CK|PHO/INFCOM/Comms/MBC,F|PHO/INFVOX/Voxbreaker/MBC,F|PHO/INCMRK/Marksman/SMBC,F|PHO/INFVET/Veteran/CBC,CB|PHO/INFSAB/Sabot/MBC,RE,F
	$import = $_REQUEST["importteam"];
	if ($import == null || $import == "") {
		$import = "Nah";
	}
	
	$params = explode("|", $import);
	
	switch(strtoupper($params[0])) {
		// MINE
		case "PHOBOS":
		case "BLADEREACH":
			// Bladereach
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://ktdash.app/r/BR");
			break;
		case "INTERDICTORS":
			// Interdictors (Deathwatch)
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://ktdash.app/r/INTER");
			break;
		case "VOX BELLI":
			// Vox Belli (Ecclisiarchy/SOB)
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://ktdash.app/r/VOX");
			break;
			
		// PREBUILT
		case "SHOVEL SQUAD":
			// Shovel Squad (Veteran Guard)
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://ktdash.app/r/PB-VGSHOV");
			break;
		case "CONSECRATORS":
			// Grey Knights/Consecrators
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://ktdash.app/r/PB-GK");
			break;
		case "VOSS PRIME HUNTER CLADE";
			// Voss Prime Hunter Clade
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://ktdash.app/r/PB-AMVP");
			break;
		case "TALON SQUAD";
			// Deathwatch/Talon Squad
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://ktdash.app/r/PB-DWTS");
			break;
		case "PAPA'S NECRONIOS":
			// Necrons/Tomb World/Papa's Necronios
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://ktdash.app/r/PB-NECTW");
			break;
		
		// OTHERS
		case "CHUCK'S HIVE FLEET":
			// Chuck's Hive Fleet
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: https://ktdash.app/r/9RKcO");
			break;
		default:
			// No match found, send them home
			header("HTTP/1.1 404 Not Found");
			header("Location: https://ktdash.app/");
			break;
	}
	
?>
	