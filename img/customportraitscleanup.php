<?php

	echo "Starting...\r\n";
	$root = "/var/www/ktdash.app/img/customportraits";
	
	//Get the directories in the root
	$users = scandir($root);
	foreach($users as $user) {
		//echo "   Checking " . $user . "\r\n";
		if (strpos($user, "user") === 0) {
			// This is a user directory, get their rosters
			$rosters = scandir($root . "/" . $user);
			foreach ($rosters as $roster) {
				$imgs = scandir($root . "/" . $user . "/" . $roster);
				foreach ($imgs as $img) {
					if (strpos($img, "roster_") === 0 && strpos($img, ".jpg") > 0) {
						// This is a custom portrait for a Roster
						$rid = str_replace(".jpg", "", str_replace("roster_", "", $img));
						//echo "            Updating roster " . $rid . "\r\n";
						echo "UPDATE Roster SET hascustomportrait = 1 WHERE rosterid = '$rid' AND hascustomportrait != 1;\r\n";
					} else if (strpos($img, "op_") === 0 && strpos($img, ".jpg") > 0) {
						// This is a custom portrait for a RosterOperative
						$roid = str_replace(".jpg", "", str_replace("op_", "", $img));
						//echo "            Updating operative " . $roid . "\r\n";
						echo "UPDATE RosterOperative SET hascustomportrait = 1 WHERE rosteropid = '$roid' AND hascustomportrait != 1;\r\n";
					}
				}
			}
		}
	}
	
?>