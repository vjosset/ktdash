<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	header("000PageStart: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
	
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
	
	header("105GetRoster: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
	$myRoster = Roster::GetRoster($rid);
	header("110GotRoster: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
	if ($myRoster == null) {
		// Roster not found
		//	Send them to My Rosters I guess?
		header("Location: /u");
		exit;
	}
	header("115LoadFaction: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
	$myRoster->loadFaction();
	header("120LoadKillTeam: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
	$myRoster->loadKillTeam();
	header("125LoadFireTeams: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
	$myRoster->killteam->loadFireteams();
	header("130GetSessionUser: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
	$me = Session::CurrentUser();
	header("135GotSessionUser: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
	$ismine = $me != null && $me->userid == $myRoster->userid;
	
	if (!$ismine) {
		// Anonymous or a user viewing another user's roster, increment the viewcount
		global $dbcon;
		$sql = "UPDATE Roster SET viewcount = viewcount + 1 WHERE rosterid = ?";
		
		$cmd = $dbcon->prepare($sql);
		$paramtypes = "s";
		$params = array();
		$params[] =& $paramtypes;
		$params[] =& $rid;

		call_user_func_array(array($cmd, "bind_param"), $params);
		$cmd->execute();
	}
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
		</style>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRoster('<?php echo $myRoster->rosterid ?>');">
		<!--
			style="
			background-color: rgba(32, 32, 32, 0.9);
			background-attachment:fixed;
			background-image: url(/api/rosterportrait.php?rid=<?php echo $myRoster->rosterid ?>);
			background-position: top center;
			background-size: cover;
			background-blend-mode: multiply;" -->
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
		<script type="text/javascript">
			// Pre-load roster data straight on this page instead of XHR round-trip to the API
			document.body.setAttribute("myRoster", JSON.stringify(<?php echo json_encode($myRoster) ?>));
			
			// Pre-load current user
			document.body.setAttribute("currentuser", JSON.stringify(<?php echo json_encode($me) ?>));
		</script>
		
		<div class="orange container-fluid">
			<div class="row">
				<h1 class="pointer col-11 m-0 p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Killteam Composition" ng-click="showrosterkillteaminfo(myRoster);">
					<span ng-bind="myRoster.rostername"><?php echo $myRoster->rostername ?></span>
					<sup><i class="h5 fas fa-info-circle fa-fw"></i></sup>
				</h1>
				<div class="h3 col-1 m-0 p-0 align-text-top text-end">
					<div class="btn-group">
						<a role="button" id="rosteractions_{{ myRoster.rosterid }}" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-ellipsis-h fa-fw"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="rosteractions_{{ myRoster.rosterid }}">
							<?php
								if (!$ismine) {
										?>
										<li><a class="pointer dropdown-item p-1 navloader" href="/r/{{ myRoster.rosterid }}/g" data-bs-toggle="tooltip" data-bs-placement="top" title="Gallery"><i class="fas fa-images fa-fw"></i> Photo Gallery</a></li>
										<?php
									// Not my roster - Offer to import if logged in
									if ($me != null) {
										// User is logged in
										?>
										<li><a class="pointer dropdown-item p-1" ng-click="cloneRoster(myRoster);"><i class="fas fa-file-import fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Import Roster"></i> Import Roster</a></li>
										<?php
									} else {
										// User is not logged in
										?>
										<li><a href="/login.htm" class="pointer dropdown-item p-1"><i class="fas fa-lock fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Log in to import"></i> Log In to Import</a></li>
										<?php
									}
								} else {
							?>
										<li><a class="pointer dropdown-item p-1" ng-click="initAddOp(myRoster);"><i class="far fa-plus-square fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Operative"></i> Add Operative</a></li>
										<li><a class="pointer dropdown-item p-1" ng-click="initEditRoster(myRoster);"><i class="fas fa-edit fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Name and Description"></i> Edit Name and Description</a></li>
										<li ng-if="myRoster.edition == 'kt21' && settings['shownarrative'] == 'y'"><a class="pointer dropdown-item p-1" ng-click="initEditRosterNarr(myRoster);"><i class="fas fa-edit fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Narrative Info"></i> Narrative Info</a></li>
										<li><a class="pointer dropdown-item p-1" ng-click="deploy(myRoster);"><i class="fas fa-exclamation fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Deploy"></i> Deploy</a></li>
										<li><a class="pointer dropdown-item p-1" ng-click="initUploadRosterPortrait(myRoster)" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Portrait"><i class="fas fa-camera fa-fw"></i> Edit Roster Portrait</a></li>
										<li><a class="pointer dropdown-item p-1 navloader" href="/r/{{ myRoster.rosterid }}/g" data-bs-toggle="tooltip" data-bs-placement="top" title="Gallery"><i class="fas fa-images fa-fw"></i> Photo Gallery</a></li>
										<li><a class="pointer dropdown-item p-1" ng-click="showpopup(myRoster.rostername, getRosterTextDescription(myRoster));"><i class="fas fa-file-alt fa-fw"></i> Get Text Description</a></li>
										<!-- <li><a class="pointer dropdown-item p-1" onclick="$('#myrosterhelpmodal').modal('show');te('roster', 'help');"><i class="far fa-question-circle fa-fw" id="myrosterhelpbutton"></i> Help</a></li> -->
										<li><a class="pointer dropdown-item p-1" ng-click="trackEvent('myRosters', 'getshareurl'); showShareRoster(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Share Roster"><i class="fas fa-share-square fa-fw"></i> Share Roster</a></li>
										<li><a class="pointer dropdown-item p-1" ng-click="cloneRoster(myRoster, $index);" data-bs-toggle="tooltip" data-bs-placement="top" title="Clone Roster"><i class="far fa-copy fa-fw"></i> Clone Roster</a></li>
										<!-- li><a class="pointer dropdown-item p-1" href="/printroster.php?rid={{ myRoster.rosterid }}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Roster"><i class="fas fa-print fa-fw"></i> Print Roster</a></li -->
										<li><a class="pointer dropdown-item p-1" ng-click="console.log('click1');initPrintRoster(myRoster);console.log('click2');"><i class="fas fa-print fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Roster"></i> Print Roster</a></li>
										<li><a class="pointer dropdown-item p-1" ng-click="initDeleteRoster(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Roster"><i class="fas fa-trash-alt fa-fw"></i> Delete Roster</a></li>
							<?php
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			<div>
				<a class="navloader" ng-href="/fa/<?php echo $myRoster->factionid ?>/kt/<?php echo $myRoster->killteamid ?>">
					<span ng-if="myRoster.spotlight == 1"><i class="fas fa-star fa-fw text-small" data-bs-toggle="tooltip" data-bs-placement="top" title="Spotlight"></i></span>
					<?php echo $myRoster->killteamname ?> <sup><?php echo $myRoster->edition ?></sup>
					<span ng-show="totalEqPts(myRoster) > 0">({{ totalEqPts(myRoster) }} {{ myRoster.killteamid.endsWith('NPO') ? ' Wounds' : 'EP' }})</span>
					<?php if (!$ismine) { ?>
					by&nbsp;<a class="navloader" href="/u/<?php echo $myRoster->username ?>"><span class="badge bg-dark"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $myRoster->username ?></span></a>
					<?php }?>
				</a>
			</div>
		</div>
		
		<!-- Help Box -->
		<div class="modal fade oswald" id="myrosterhelpmodal" tabindex="-1" role="dialog" aria-labelledby="myrosterhelpmodallabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content dark">
					<div class="modal-header orange">
						<h5 class="modal-title cinzel" id="myrosterhelpmodallabel"><i class="pointer far fa-question-circle fa-fw"></i> My Roster - Help</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="m-0 modal-body dark">
						Manage your Roster and Operatives here.
						<br/>
						<img width="100%" src="/img/RosterHelp.jpg" /><br/>
						<h6 class="d-inline fa-fw">1:</h6>&nbsp;&nbsp;<i class="fas fa-edit fa-fw"></i> Change Operative Portrait</br>
						<h6 class="d-inline fa-fw">2:</h6>&nbsp;&nbsp;<i class="fas fa-arrow-up fa-fw"></i> Move Operative Up</br>
						<h6 class="d-inline fa-fw">3:</h6>&nbsp;&nbsp;<i class="fas fa-arrow-down fa-fw"></i> Move Operative Down</br>
						<h6 class="d-inline fa-fw">4:</h6>&nbsp;&nbsp;<i class="fas fa-edit fa-fw"></i> Edit Operative (name, weapons, and equipment)</br>
						<h6 class="d-inline fa-fw">5:</h6>&nbsp;&nbsp;<i class="fas fa-trash-alt fa-fw"></i> Delete Operative
					</div>
				</div>
			</div>
		</div>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<br/>
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Roster...
			</div>
		</h3>
		
		<!-- Show this roster and its operatives -->
		<div class="ng-cloak p-0 m-1" ng-hide="loading">
			<div ng-if="myRoster.operatives == null || myRoster.operatives.length == 0">
				This roster does not have any operatives yet
				<?php 
				if ($ismine) {
				?>
				<a href="" ng-click="initAddOp(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Operative">add one now</a>!
				<?php
				}
				?>
			</div>
			
			<!--
			<i class="fas fa-eye fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="View Count"></i> {{ myRoster.viewcount }}
			<i class="fas fa-file-import fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Import Count"></i> {{ myRoster.importcount }}
			-->
			
			<!-- Show this roster's operatives -->
			<div class="row p-0 m-0">
				<div class="col-12 col-md-6 col-xl-4 col-xxl-3 p-0" ng-repeat="operative in myRoster.operatives | orderBy: 'seq' track by $index">
					<?php include "templates/op_card.shtml" ?>
				</div>
			</div>
		</div>
		<?php
			include "footer.shtml";
		?>
	</body>
</html>