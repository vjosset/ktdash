<?php
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
		header("Location: /rosters.php");
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
			$pagetitle = $myRoster->rostername . " - Gallery - " . ($ismine ? "" : (" by " . $myRoster->username));
			$pagedesc  = $myRoster->rostername . " - Gallery " . ($myRoster->userid == 'prebuilt' ? "Pre-Built " : "") . $myRoster->killteamname . " KillTeam: \r\n" . $myRoster->oplist;
			$pageimg   = "https://ktdash.app/api/rosterportrait.php?rid={$myRoster->rosterid}";
			$pageurl   = "https://ktdash.app/rostergallery.php?rid={$myRoster->rosterid}";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRosterGallery('<?php echo $myRoster->rosterid ?>');"
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
		
		<div class="orange container-fluid">
			<div class="row">
				<div class="col-11 m-0 p-0">
					<h1>
						<a href="/roster.php?rid=<?php echo $myRoster->rosterid ?>"><?php echo $myRoster->rostername ?></a>
					</h1>
				</div>
				<div class="col-1 m-0 p-0 align-text-top text-end">
					<div class="btn-group">
						<a class="h3" role="button" id="dashactions" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-ellipsis-h fa-fw"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dashactions">
							<li><a class="pointer dropdown-item p-1 navloader" href="/roster.php?rid=<?php echo $myRoster->rosterid ?>"><i class="fas fa-users fa-fw"></i> Go To Roster</a></li>
						</ul>
					</div>
				</div>
			</div>
			<?php if (!$ismine) { ?>
			by&nbsp;<a class="navloader" href="/rosters.php?uid=<?php echo $myRoster->userid ?>"><span class="badge bg-dark"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $myRoster->username ?></span></a>
			<?php }
			?>
		</div>
		
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
			<div class="col-12 col-md-6 col-lg-4 col-xl-3 m-0 p-0 pointer"
				style="overflow: hidden;"
				ng-click="showPhoto(myRoster.rostername, '/api/rosterportrait.php?rid=' + myRoster.rosterid);"
				>
				<img id="rosterportrait_{{ myRoster.rosterid }}"
					src="/api/rosterportrait.php?rid={{ myRoster.rosterid }}"
					style="height: 100%; width: 100%; min-height: 150px; max-height: 400px; object-fit:cover; object-position:50% 0%; display:block;" />
			</div>
			<div class="col-12 col-md-6 col-lg-4 col-xl-3 m-0 p-0 pointer" ng-repeat="operative in myRoster.operatives | orderBy: 'seq' track by $index" style="overflow: hidden;"
				ng-click="showPhoto(operative.opname, '/api/operativeportrait.php?roid=' + operative.rosteropid);"
				>
				<img id="opportrait_{{operative.rosteropid}}"
					src="/api/operativeportrait.php?roid={{ operative.rosteropid }}"
					style="height: 100%; width: 100%; min-height: 150px; max-height: 400px; object-fit:cover; object-position:50% 0%; display:block;" />
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>