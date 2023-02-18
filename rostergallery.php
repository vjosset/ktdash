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
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = $myRoster->rostername . " - " . ($myRoster->userid == 'prebuilt' ? "Pre-Built " : "") . $myRoster->killteamname . " KillTeam" . ($myRoster->userid == 'prebuilt' ? "" : (" by " . $myRoster->username)) . " - Gallery";
			$pagedesc  = $pagedesc  = $myRoster->rostername . ($myRoster->userid == 'prebuilt' ? "" : (" by " . $myRoster->username)) . ": \r\n" . ($myRoster->notes == '' ? $myRoster->oplist : $myRoster->notes);
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
							<li><a class="pointer dropdown-item p-1" ng-click="showShareRosterGallery(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Share Roster"><i class="fas fa-share-square fa-fw"></i> Share Roster Gallery</a></li>
							<li><a class="pointer dropdown-item p-1 navloader" href="/r/<?php echo $myRoster->rosterid ?>"><i class="fas fa-users fa-fw"></i> Go To Roster</a></li>
						</ul>
					</div>
				</div>
			</div>
			<span ng-if="myRoster.spotlight == 1"><i class="fas fa-star fa-fw text-small" data-bs-toggle="tooltip" data-bs-placement="top" title="Spotlight"></i></span>
			<a href="/fa/<?php echo $myRoster->factionid ?>/kt/<?php echo $myRoster->killteamid ?>"><?php echo $myRoster->killteamname ?></a>
			<?php
				if (!$ismine) { ?>
				by&nbsp;<a class="navloader" href="/u/<?php echo $myRoster->username ?>"><span class="badge bg-dark"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $myRoster->username ?></span></a>
			<?php }
			?>
		</div>
		<?php
		if ($myRoster->notes != '') {
			?>
			<p><?php echo $myRoster->notes ?></p>
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
			<div class="ng-cloak col-12 col-md-6 col-lg-4 col-xl-3 m-0 p-0 pointer"
				style="overflow: hidden;"
				ng-click="showPhoto(myRoster.rostername, '/api/rosterportrait.php?rid=' + myRoster.rosterid);"
				>
				<img id="rosterportrait_{{ myRoster.rosterid }}"
					src="/api/rosterportrait.php?rid=<?php echo $myRoster->rosterid ?>"
					alt="{{ myRoster.rostername }}"
					title="{{ myRoster.rostername }}"
					style="height: 100%; width: 100%; min-height: 150px; max-height: 400px; object-fit:cover; object-position:50% 0%; display:block;" />
			</div>
			<div class="ng-cloak col-12 col-md-6 col-lg-4 col-xl-3 m-0 p-0 pointer" ng-repeat="operative in myRoster.operatives | orderBy: 'seq' track by $index" style="overflow: hidden;"
				ng-click="showPhoto(operative.opname, '/api/operativeportrait.php?roid=' + operative.rosteropid);"
				>
				<h4 class="orange m-0 p-0">{{ operative.opname }}</h4>
				<div class="orange">{{ operative.optype }}</div>
				<img id="opportrait_{{operative.rosteropid}}"
					ng-src="/api/operativeportrait.php?roid={{ operative.rosteropid }}"
					alt="{{ operative.opname }}"
					title="{{ operative.opname }}"
					style="height: 100%; width: 100%; min-height: 150px; max-height: 400px; object-fit:cover; object-position:50% 0%; display:block;" />
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>