<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	
	// Get the specified roster operative
	$roid = getIfSet($_REQUEST['roid'], '');
	
	if ($roid == null || $roid == '') {
		// Invalid Roster Operative ID
		// Operative not found - Go to user's roster
		header("Location: /rosters.php");
		exit;
	}
	
	// Get the operative
	$ro = RosterOperative::GetRosterOperative($roid);
	
	if ($ro == null) {
		// Invalid Roster Operative ID
		// Operative not found - Go to user's roster
		header("Location: /rosters.php");
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $ro->opname . " - Print Operative";
		$pagedesc  = "All KillTeam 2021 factions";
		$pageimg   = "https://ktdash.app/api/operativeportrait.php?roid=" . $roid;
		$pageurl   = "https://ktdash.app/printop.php?roid=" . $roid;
		
		include "og.php"
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initPrintOp('<?php echo $roid ?>');">
		<?php include "topnav.shtml" ?>
		
		<h1 class="cinzel orange noprint"><?php echo $ro->opname ?></h1>
		
		<!-- loadWaiter -->
		<h3 class="center noprint" ng-show="loading">
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Operative...
			</div>
		</h3>
		
		<div class="ng-cloak" ng-hide="loading">
			<div ng-if="settings['display'] == 'card'">
				<?php include "templates/op_card.shtml" ?>
			</div>
			<div ng-if="settings['display'] == 'list'">
				<?php include "templates/op_list.shtml" ?>
			</div>
		</div>
		
		<div class="ng-cloak" ng-hide="loading">
			<div class="card cdarkcard opcard p-2">
				<div ng-repeat="ab in operative.abilities" class="px-1">
					<h6>{{ ab.title }}</h6>
					<span ng-bind-html="ab.description" class="text-tiny" style="text-align:justify;"></span>
				</div>
				<div ng-repeat="ua in operative.uniqueactions" class="px-1">
					<h6>{{ ua.title }} ({{ ua.AP }} AP)</h6>
					<span ng-bind-html="ua.description" class="text-tiny" style="text-align:justify;"></span>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>