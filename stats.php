<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	$me = Session::CurrentUser();
	if ($me == null || $me->userid != 'vince') {
		// They shouldn't be here
		header('HTTP/1.0 403 Not Authorized');
		header("Location: https://ktdash.app/rosters.php");
		die();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = "Stats";
			$pagedesc  = "Stats";
			$pageimg   = "";
			$pageurl   = "https://ktdash.app/stats.php";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl">
		<?php
			include "topnav.shtml";
		?>
		
		<div class="orange container-fluid">
			<div class="row">
				<h1 class="col-6 m-0 p-1">
					<a class="navloader" onclick="window.location.reload();">Stats</a>
				</h1>
				<h1 class="col-6 m-0 p-1 text-end h2">
					<!-- Activity -->
					<?php
						$sql = "SELECT COUNT(DISTINCT userid, userip) AS UserCount30Minute, COUNT(*) AS EventCount30Minute FROM Event WHERE userip != '68.80.166.102' AND datestamp > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -30 minute);";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<i class="fas fa-users"></i> <?php echo $row->UserCount30Minute ?>
								<i class="fas fa-bolt"></i> <?php echo $row->EventCount30Minute ?>
								<?php
							}
						}
					?>
				</h1>
			</div>
		</div>
		
		<div class="p-2">
			<div style="columns: 2;">
				<!-- Signups -->
				<div>
					<h2>Signups</h2>
					<?php
						$sql = "SELECT CAST(datestamp AS Date) AS Date, COUNT(*) AS SignupCount FROM Event WHERE datestamp > DATE_ADD(CURRENT_DATE, INTERVAL -6 day) AND eventtype = 'session' AND action = 'signup' AND userip != '68.80.166.102' GROUP BY CAST(datestamp AS Date) ORDER BY 1 DESC";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();
						
						echo "<table style=\"width: 100%;\">";

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<tr><th><?php echo $row->Date ?></th><td style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->SignupCount ?></td></tr>
								<?php
							}
						}
						
						echo "</table>";
					?>
				</div>
				
				<!-- Totals -->
				<div>
					<h2>Totals</h2>
					<?php
						$sql =
							"SELECT 'Users' AS CountType, COUNT(*) AS Count FROM User WHERE userid NOT IN ('prebuilt', 'vince') UNION
							SELECT 'Rosters', COUNT(*) AS RosterCount FROM Roster WHERE userid NOT IN ('prebuilt', 'vince') UNION
							SELECT 'RosterOps', COUNT(*) AS RosterOpCount FROM RosterOperative WHERE userid NOT IN ('prebuilt', 'vince')";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();
						
						echo "<table style=\"width: 100%;\">";

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<tr><th><?php echo $row->CountType ?></th><td style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->Count ?></td></tr>
								<?php
							}
						}
						
						echo "</table>";
					?>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>