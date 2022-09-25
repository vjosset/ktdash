<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested user id
	$uid = $_REQUEST['uid'];
	if ($uid == null || $uid == '') {
		$uid = $_REQUEST['utid'];
	}
	if ($uid == null || $uid == '') {
		$uid = Session::CurrentUser()->userid;
	}
	
	if ($uid == null || $uid == '') {
		// No user id specified, not logged in
		//	No idea what they expect to see here; send them to login page
		header("Location: /login.htm");
		exit;
	}
	
	$myUser = User::FromDB($uid);
	$myUser->loadUserTeams();
	$myTeams = $myUser->userteams;
	$me = Session::CurrentUser();
	$ismine = $me != null && $me->userid == $uid;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $killteam->killteamname . " | " . $faction->factionname;
		$pagedesc  = $killteam->description;
		$pageimg   = "https://ktdash.app/img/portraits/". $factionid . "/" . $killteamid . "/" . $killteamid . ".png";
		$pageurl   = "https://ktdash.app/killteam.php?fa=" . $factionid . "&kt=" . $killteamid;
		
		include "og.php"
		?>
		
		<title>
		<?php
		echo $ismine ? "My" : $myUser->username
		?> Teams | KTDash.app</title>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initUserTeams(GetQS('uid'));">
		<?php include "topnav.shtml" ?>
			
		<!-- Dialogs -->
		<?php include "templates/dialogs.shtml" ?>
		
		<h1 class="orange"><span class="fas fa-users fa-fw"></span>&nbsp;My Teams</h1>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<br/>
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Teams...
			</div>
		</h3>
		<br/>
		<!-- Show this player's teams -->
		<div class="container-fluid" ng-hide="loading">
			<div ng-if="myTeams.length < 1" >
				<span ng-if="MODE == 'MyTeams'">You don't have any Teams yet.</span>
				<span ng-if="MODE == 'UserTeams'">This user doesn't have any Teams yet.</span>
			</div>
			<div>
				<span class="float-start">
					Build a <a href="#" ng-click="initNewTeam();">new team</a>
					or import a <a href="sampleteams.htm">pre-built team</a>
				</span>
				<span class="float-end">
					<i id="myteamshelpbutton" class="far fa-question-circle fa-fw" onclick="$('#myteamshelp').modal('show');"></i>
				</span>
			</div>
			<br/>
			
			<div ng-repeat="myTeam in myTeams track by $index">
				<div class="row">
					<div class="col-7">
						<h3 style="display: inline;"><a href="/userteam.php?utid={{ myTeam.userteamid }}">{{myTeam.userteamname}}</a></h3>
					</div>
					<div class="col-5" style="text-align: right;">
						<a class="float-end" ng-href="/killteam.php?fa={{myTeam.factionid}}&kt={{myTeam.killteamid}}">{{myTeam.killteamname}}</a><br/>
						<i class="fas fa-arrow-up fa-fw" ng-click="moveTeamUp(team, $index);"></i>
						<i class="fas fa-arrow-down fa-fw" ng-click="moveTeamDown(team, $index);"></i>
						<a href="/userteam.php?utid={{ myTeam.userteamid }}"><i class="fas fa-edit fa-fw" ng-click="initRenameTeam(team);"></i></a>
						<i class="fas fa-share-square fa-fw" ng-click="trackEvent('myTeams', 'getshareurl'); showShareTeam(team);"></i>
						<i class="far fa-copy fa-fw" ng-click="cloneTeam(team, $index);"></i>
						<!-- i class="fas fa-print fa-fw" ng-click="initPrintTeam(team);"></i -->
						<i class="fas fa-trash-alt fa-fw" ng-click="initDeleteTeam(team);"></i>
					</div>
				</div>
				<div>
					{{ myTeam.opList }}
				</div>
				<hr ng-if="!$last" style="margin-left: 10px; margin-right: 10px;" />
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>