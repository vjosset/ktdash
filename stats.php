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
			$pagekeywords = "";
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
								<i class="fas fa-users"></i> <?php echo number_format($row->UserCount30Minute) ?>
								<i class="fas fa-bolt"></i> <?php echo number_format($row->EventCount30Minute) ?>
								<?php
							}
						}
					?>
				</h1>
			</div>
			<span class="small p-0"><?php echo date("Y-m-d H:i:s") ?></span>
		</div>
		
		<div class="p-2">
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
							<tr><th><?php echo $row->CountType ?></th><td style="text-align: right;"><?php echo number_format($row->Count) ?></td></tr>
							<?php
						}
					}
					
					echo "</table>";
				?>
			</div>
			<br/>
			
			<!-- Signups -->
			<div class="line-top-light">
				<h2>Stats</h2>
				<?php
					$sql = "SELECT CAST(datestamp AS Date) AS Date, SUM(CASE WHEN action = 'signup' THEN 1 ELSE 0 END) AS SignupCount, COUNT(DISTINCT userip) AS UserCount, COUNT(DISTINCT userip) AS UserCount, SUM(CASE WHEN eventtype = 'page' THEN 1 ELSE 0 END) AS PageViews FROM Event WHERE userip != '68.80.166.102' AND datestamp > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -7 day) GROUP BY CAST(datestamp AS Date) ORDER BY 1 DESC;";
					$cmd = $dbcon->prepare($sql);
					
					// Load the stats
					$cmd->execute();
					
					echo "<table style=\"width: 100%;\">";
					echo "<tr><th>Date</th><th style=\"text-align: right;\">S</th><th style=\"text-align: right;\">U</th><th style=\"text-align: right;\">P</th></tr>";

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<tr>
								<th><?php echo $row->Date ?></th>
								<td style="text-align: right;"><?php echo number_format($row->SignupCount) ?></td>
								<td style="text-align: right;"><?php echo number_format($row->UserCount) ?></td>
								<td style="text-align: right;"><?php echo number_format($row->PageViews) ?></td>
							</tr>
							<?php
						}
					}
					
					echo "</table>";
				?>
			</div>
			<br/>
			
			<!-- Recent Portraits (Data) -->
			<div class="line-top-light">
				<h2>Recent Portraits</h2>
				<?php
					$sql = "
						SELECT MAX(E.datestamp) AS datestamp, COUNT(*) AS Count, U.username, U.userid, R.rosterid, R.rostername
						FROM Event E INNER JOIN User U ON U.userid = E.userid INNER JOIN Roster R ON R.rosterid = E.var1
						WHERE E.action IN ('portrait', 'opportrait') AND E.userip != '68.80.166.102' AND E.label = 'custom'
						GROUP BY U.username, U.userid, R.rosterid, R.rostername
						ORDER BY 1 DESC LIMIT 20";
					$cmd = $dbcon->prepare($sql);
						
					// Load the stats
					$cmd->execute();
					
					echo "<ul>";

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<li><strong><?php echo $row->datestamp ?><br/></strong>
							<a href="/r/<?php echo $row->rosterid ?>/g" target="_blank"><?php echo $row->rostername ?></a>
							by
							<a href="/u/<?php echo $row->userid ?>" target="_blank"><?php echo $row->username ?></a>
							(<?php echo number_format($row->Count) ?>)
							</li>
							<?php
						}
					}
					
					echo "</ul>";
				?>
			</div>
			<br/>
			
			<!-- Event Log -->
			<div class="line-top-light">
				<h2>Event Log</h2>
				<?php
					$sql = "SELECT * FROM EventLogView WHERE ActionLog != '' AND userip != '68.80.166.102' ORDER BY 1 DESC LIMIT 200";
					$cmd = $dbcon->prepare($sql);
						
					// Load the stats
					$cmd->execute();

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<strong><?php echo explode(' ', $row->datestamp)[1] ?></strong><br/>
							<?php echo $row->ActionLog ?><br/>
							<?php
						}
					}
				?>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>