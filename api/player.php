<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    header('Content-Type: application/json');
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			//Get the requested player
			GETPlayer();
			break;
		case "POST":
			//Create a new player
			POSTPlayer();
			break;
        default:
            //Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
            break;
    }

	function GETPlayer() {
		$myplayer = null;
		if (Session::IsAuth()) {
			//Player is authenticated
			$myplayer = Session::CurrentPlayer();
		}
		
		//Get the requested player id
		$playername = urldecode($_REQUEST['playername']);
		
		//Get the search term
		$term = $_REQUEST['term'];
		
		if ($term && $term != "") {
			//Search players
			$players = Player::SearchPlayers($term);
			
			//Done
			echo json_encode($players);
		} else {
			if ($playername == null) {
				header("HTTP/1.0 404 Not Found - The player you requested was not found");
			}
			//Find the playerid for the specified playername
			$playerid = (Player::FromName($playername))->playerid;

			$myplayerid = $myplayer->playerid;
			
			//If no player id was passed in, assume my player id
			if ($playerid == null) {
				header("HTTP/1.0 404 Not Found - The player you requested was not found");
			}
			
			//Validate the player ID
			if (!CommonUtils\isValidId($playerid)) {
				//Player doesn't exist, return 404
				header("HTTP/1.0 404 Not Found - The player you requested was not found");
			} else {
				//Get the player
				if ($playerid != $myplayerid) {
					$u = Player::FromDB($playerid);
				} else {
					$u = $myplayer;
				}
				
				//Check if this player actually exists
				if ($u == null) {
					//Player doesn't exist, return 404
					header("HTTP/1.0 404  Not Found - The player you requested was not found");
				} else {
					//Player exists, clean up the output and spit it out
					//Remove the passhash from the output
					unset($u->passhash);

					//Remove the email from the output
					unset($u->email);

					//Player's submissions
					if ($_REQUEST['getsubmissions'] == '1') {
						//Get the submissions for this player
						$u->submissions = Article::GetArticles(null, $playerid, 1, 100, null, null, false, 0, '');
						if ($u->submissions == null) {
							$u->submissions = [];
						}
					}
					
					//Player stats
					if ($_REQUEST['getstats'] == '1') {
						//Get the player's stats
						$u->stats = $u->getStats();
					}
					
					//Saved articles
					if ($_REQUEST['getbookmarks'] == '1' && $playerid == $myplayerid) {
						//Get the player's saved articles
						$u->bookmarks = $u->getBookmarks();
					}
					
					//Output the player
					echo $u->toJson();
				}
			}
		}
	}

	function POSTPlayer() {
		$playername = $_REQUEST['playername'];
		$password = $_REQUEST['password'];
		$confirmpassword = $_REQUEST['confirmpassword'];

		if ($confirmpassword != $password) {
            header('HTTP/1.0 500 Server Error - Passwords do not match');
            die();
		}

		//Create a new player
		$temp = Player::NewPlayer($playername, $password);

		//Sign this player in
		$p = Session::Login($_REQUEST['playername'], $_REQUEST['password']);

		//Done
		echo $p->toJson();
	}
?>
