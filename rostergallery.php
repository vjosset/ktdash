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
	$me = Session::CurrentUser();
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
			$pagetitle = $myRoster->rostername . " " . ($myRoster->userid == 'prebuilt' ? "" : (" by " . $myRoster->username)) . " - Gallery";
			$pagedesc  = $myRoster->killteamname . " KillTeam" . ($myRoster->userid == 'prebuilt' ? "" : (" by " . $myRoster->username)) . ":\r\n" . $myRoster->notes;
			$pagekeywords = "Gallery,Photos,Miniatures,Prebuilt,sample,rosters,teams,import," . $myRoster->rostername . "," . $myRoster->killteamname . "," . $myRoster->username;
			$pageimg   = "https://ktdash.app/api/rosterportrait.php?rid={$myRoster->rosterid}";
			$pageurl   = "https://ktdash.app/r/{$myRoster->rosterid}/g";
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
	<body ng-app="kt" class="ng-cloak" ng-controller="ktCtrl" ng-init="initRosterGallery();"
		style="
			background-color: rgba(32, 32, 32, 0.9);
			background-attachment:fixed;
			background-image: url(/api/rosterportrait.php?rid=<?php echo $myRoster->rosterid ?>);
			background-position: top center;
			background-size: cover;
			background-blend-mode: multiply;">
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
				<div class="col-11 m-0 p-0">
					<h1>
						<a class="navloader" href="/r/<?php echo $myRoster->rosterid ?>"><?php echo $myRoster->rostername ?></a>
					</h1>
				</div>
				<div class="col-1 m-0 p-0 align-text-top text-end">
					<div class="btn-group">
						<a class="h3" role="button" id="gallactions" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-ellipsis-h fa-fw"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="gallactions">
							<?php if ($ismine) { ?>
							<li><a class="pointer dropdown-item p-1" ng-click="initUploadRosterPortrait(myRoster)" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Portrait"><i class="fas fa-camera fa-fw"></i> Edit Roster Portrait</a></li>
							<?php } ?>
							<li><a class="pointer dropdown-item p-1" ng-click="showShareRosterGallery(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Share Roster"><i class="fas fa-share-square fa-fw"></i> Share Roster Gallery</a></li>
							<li><a class="pointer dropdown-item p-1 navloader" href="/r/<?php echo $myRoster->rosterid ?>"><i class="fas fa-users fa-fw"></i> Go To Roster</a></li>
							<?php if ($me != null && $me->userid == 'vince') { ?>
							<li><a class="pointer dropdown-item p-1" ng-if="myRoster.spotlight == 1" ng-click="toggleSpotlight(myRoster, 0);"><i class="fas fa-star fa-fw text-small" data-bs-toggle="tooltip" data-bs-placement="top" title="Spotlight"></i></i> Spotlight Off</a></li>
							<li><a class="pointer dropdown-item p-1" ng-if="myRoster.spotlight == 0" ng-click="toggleSpotlight(myRoster, 1);"><i class="fas fa-star fa-fw text-small" data-bs-toggle="tooltip" data-bs-placement="top" title="Spotlight"></i></i> Spotlight On</a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<span ng-if="myRoster.spotlight == 1"><i class="fas fa-star fa-fw text-small" data-bs-toggle="tooltip" data-bs-placement="top" title="Spotlight"></i></span>
			<a class="navloader" href="/fa/<?php echo $myRoster->factionid ?>/kt/<?php echo $myRoster->killteamid ?>"><?php echo $myRoster->killteamname ?></a>
				by&nbsp;<a class="navloader" href="/u/<?php echo $myRoster->username ?>"><span class="badge bg-dark"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $myRoster->username ?></span></a>
		</div>
		<?php
		if ($myRoster->notes != '') {
			?>
			<p style="max-height: 200px; overflow:auto;">
				<?php echo preg_replace("/\r\n|\r|\n/", '<br/>', htmlentities($myRoster->notes)) ?>
			</p>
			<?php
		}
		?>
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<br/>
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Gallery...
			</div>
		</h3>
		
		<div class="row p-0 m-0 ng-cloak" ng-hide="loading">
			<!-- Roster Portrait -->
			<div class="ng-cloak col-12 col-md-6 col-lg-4 col-xl-3 m-0 p-0" style="overflow: hidden;border: 1px solid #eee;">
				<img id="rosterportrait_{{ myRoster.rosterid }}"
					src="/api/rosterportrait.php?rid=<?php echo $myRoster->rosterid ?>"
					alt="{{ myRoster.rostername }}"
					title="{{ myRoster.rostername }}"
					style="height: 100%; width: 100%; min-height: 150px; max-height: 400px; object-fit:cover; object-position:50% 0%; display:block;"
					ng-click="showPhoto(myRoster.rostername, '/api/rosterportrait.php?rid=' + myRoster.rosterid);"
					class="pointer" />
			</div>
			
			<!-- Operative Portraits -->
			<div class="ng-cloak col-12 col-md-6 col-lg-4 col-xl-3 m-0 p-0" ng-repeat="operative in myRoster.operatives | orderBy: 'seq' track by $index" style="overflow: hidden; border: 1px solid #eee;">
				<h4 class="orange m-0 p-1 row">
					<div class="col-10 p-0 m-0 d-inline">
						{{ operative.opname }}
					</div>
					<?php if ($ismine) { ?>
						<div class="col-2 p-0 m-0 text-end">
							<a class="pointer p-1" ng-click="initUploadOpPortrait(operative)" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Portrait"><i class="fas fa-camera fa-fw"></i></a>
						</div>
					<?php }?>
				</h4>
				<div class="orange p-1">{{ operative.optype }}</div>
				<div class="p-0 m-0 pointer">
					<img id="opportrait_{{operative.rosteropid}}"
						ng-src="/api/operativeportrait.php?roid={{ operative.rosteropid }}"
						alt="{{ operative.opname }}"
						title="{{ operative.opname }}"
						style="height: 100%; width: 100%; min-height: 150px; max-height: 400px; object-fit:cover; object-position:50% 0%; display:block;"
						ng-click="showPhoto(operative.opname, '/api/operativeportrait.php?roid=' + operative.rosteropid);" />
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>