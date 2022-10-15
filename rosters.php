<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested user id
	$uid = $_REQUEST['uid'];
	if ($uid == null || $uid == '') {
		$uid = $_REQUEST['userid'];
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
	$myUser->loadRosters();
	$myRosters = $myUser->rosters;
	$me = Session::CurrentUser();
	$ismine = ($me != null && $me->userid == $uid);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = ($ismine ? "My" : $myUser->username . "'s") . " Rosters";
		
		include "og.php"
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRosters('<?php echo $uid ?>');">
		<?php include "topnav.shtml" ?>
			
		<!-- Dialogs -->
		<?php include "templates/dialogs.shtml" ?>
		
		<h1 class="orange"><span class="fas fa-users fa-fw"></span>&nbsp;<?php echo ($ismine ? "My" : $myUser->username) ?> Rosters</h1>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<br/>
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Rosters...
			</div>
		</h3>
		<br/>
		<!-- Show this player's rosters -->
		<div class="container-fluid" ng-hide="loading">
			<div ng-if="myRosters.length < 1" >
				<span ng-if="MODE == 'MyRosters'">You don't have any Rosters yet.</span>
				<span ng-if="MODE == 'Rosters'">This user doesn't have any Rosters yet.</span>
			</div>
			<?php
				if ($ismine) {
				?>
			<div>
				<span class="float-start">
					Build a <a href="#" ng-click="initNewRoster();">new roster</a>
					or import a <a href="rosters.php?uid=prebuilt">pre-built roster</a>
				</span>
				<span class="float-end">
					<i id="myrostershelpbutton" class="far fa-question-circle fa-fw" onclick="$('#myrostershelp').modal('show');"></i>
				</span>
			</div>
			<br/>
			<br/>
				<?php
			} ?>
			
			<div class="row">
				<div class="col-12 col-md-6 col-xl-4 m-0 p-1" ng-repeat="myRoster in myRosters | orderBy: 'seq'">
					<?php include "templates/roster_list.shtml" ?>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>