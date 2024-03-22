<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested roster id
	$rid = getIfSet($_REQUEST['r'], '');
	if ($rid == null || $rid == '') {
		$rid = getIfSet($_REQUEST['rid']);
	}
	if ($rid == null || $rid == '') {
		$rid = getIfSet($_REQUEST['rosterid']);
	}
	
	$myRoster = Roster::GetRoster($rid);
	if ($myRoster == null) {
		// Roster not found
		//	Send them to My Rosters I guess?
		header("Location: /u");
		exit;
	}
	$myRoster->loadFaction();
	$myRoster->loadKillTeam();
	$myRoster->killteam->loadFireteams();
	$me = Session::CurrentUser();
	$ismine = $me != null && $me->userid == $myRoster->userid;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = $myRoster->rostername . " " . ($myRoster->userid == 'prebuilt' ? "" : (" by " . $myRoster->username));
			$pagedesc  = $myRoster->killteamname . " KillTeam" . ($myRoster->userid == 'prebuilt' ? "" : (" by " . $myRoster->username)) . ":\r\n" . $myRoster->notes;
			$pagekeywords = "Prebuilt,sample,rosters,teams,import," . $myRoster->rostername . "," . $myRoster->killteamname . "," . $myRoster->username;
			$pageimg   = "https://ktdash.app/api/rosterportrait.php?rid={$myRoster->rosterid}";
			$pageurl   = "https://ktdash.app/r/{$myRoster->rosterid}";
			include "og.php";
		?>
		
	<?php
		if (count($myRoster->operatives) > 0)
		{
		?>
		<link rel="preload" href="/api/operativeportrait.php?roid=<?php echo $myRoster->operatives[0]->rosteropid ?>" as="image">
		<?php
		}
	?>
	
		<style>
		<?php include "css/styles.css"; ?>
		<?php
		/*
			Overriding card CSS styles for different card sizes for class "opcard"

			Poker 	- Vertical: 		width: 5.0in !important; height: 7.0in !important;
			Bridge 	- Vertical: 		width: 4.5in !important; height: 7.0in !important;
			Tarot 	- Vertical: 		width: 5.5in !important; height: 9.5in !important;
			Tarot 	- Horizontal: 	width: 9.5in !important; height: 5.5in !important;
		*/
		$cardsize = getIfSet($_REQUEST['cardsize'], 'PV');
		$cardwidth = '5.0in';
		$cardheight = '7.0in';
		$cardcols = 3;
		switch ($cardsize) {
			case 'TV':
				// Tarot Vertical
				$cardwidth 	= '5.5in';
				$cardheight = '9.5in';
				$cardcols 	= 4;
				break;
			case 'TH':
				// Tarot Horizontal
				$cardwidth 	= '9.5in';
				$cardheight = '5.5in';
				$cardcols 	= 6;
				break;
			case 'BV':
				// Bridge Vertical
				$cardwidth 	= '4.5in';
				$cardheight = '7.0in';
				$cardcols 	= 3;
				break;
			default:
				// Default - Treat as Poker Vertical
				$cardwidth 	= '5.0in';
				$cardheight = '7.0in';
				$cardcols 	= 3;
				break;
		}

		// Spit out the overriding styles
		?>
@media print {
	.opcard {
		width: <?php echo $cardwidth ?> !important; height: <?php echo $cardheight ?> !important;
	}
}
		</style>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRosterForPrint('<?php echo $myRoster->rosterid ?>');">
		<script type="text/javascript">
			// Pre-load roster data straight on this page instead of XHR round-trip to the API
			document.body.setAttribute("myRoster", JSON.stringify(<?php echo json_encode($myRoster) ?>));
			
			// Pre-load current user
			document.body.setAttribute("currentuser", JSON.stringify(<?php echo json_encode($me) ?>));
		</script>
		
		<!-- Show this roster and its operatives -->
		<div class="ng-cloak p-0 m-1" ng-hide="loading" style="display: block;">
			<div ng-if="myRoster.operatives == null || myRoster.operatives.length == 0">
				This roster does not have any operatives
			</div>
			
			<!-- Show this roster's operatives -->
			<div class="row d-block" ng-if="myRoster.operatives != null && myRoster.operatives.length > 0">
				<ANY class="row nopagebreak" ng-repeat="operative in myRoster.operatives | orderBy: 'seq' track by $index">

					<!-- Operative Card - Front -->
					<div class="col-<?php echo $cardcols ?> m-2 p-0">
						<?php include "templates/op_card.shtml" ?>
					</div>

					<!-- Operative Card - Back -->
					<div ng-if="(operative.abilities && operative.abilities.length > 0) || (operative.uniqueactions && operative.uniqueactions.length > 0)" class="col-<?php echo $cardcols ?> m-2 p-0">
						<div class="m-1 ng-cloak card darkcard opcard" ng-if="!operative.hidden">
							<div class="m-1 p-0 card-body small">
								<div class="m-0 p-0" ng-if="operative.abilities && operative.abilities.length > 0">
									<h6 class="line-bottom-light">Abilities</h6>
									<div class="m-0 p-0" ng-repeat="ab in operative.abilities">
										<strong>{{ ab.title }}:</strong>
										<span ng-bind-html="ab.description"></span>
									</div>
								</div>
								<div class="m-0 p-0" ng-if="operative.uniqueactions && operative.uniqueactions.length > 0">
									<h6 class="line-bottom-light">Unique Actions</h6>
									<div class="m-0 p-0" ng-repeat="ua in operative.uniqueactions">
										<strong>{{ ua.title }} ({{ ua.AP }} AP):</strong>
										<span ng-bind-html="ua.description"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</ANY>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>