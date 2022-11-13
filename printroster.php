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
		header("Location: /rosters.php");
		exit;
	}
	$myRoster->loadKillTeam();
	$me = Session::CurrentUser();
	$ismine = $me != null && $me->userid == $myRoster->userid;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = $myRoster->rostername . " - Print Roster";
			$pagedesc  = $myRoster->rostername . " - Print Roster";
			$pageimg   = "https://ktdash.app/api/rosterportrait.php?rid={$myRoster->rosterid}";
			$pageurl   = "https://ktdash.app/printroster.php?rid={$myRoster->rosterid}";
			include "og.php";
		?>
	</head>
	<body>
		<div class="orange container-fluid m-0 p-0">
			<h2 class="m-0 p-0">
				<?php echo $myRoster->rostername ?>
				(<?php echo $myRoster->killteam->killteamname ?>)
			</h2>
		</div>
		<a href="https://ktdash.app/roster.php?rid=<?php echo $myRoster->rosterid ?>">https://ktdash.app/roster.php?rid=<?php echo $myRoster->rosterid ?></a>
		<br/><br/>
		
		<div class="row" style="page-break-after: always;">
			<div class="col-8">
				<!-- Roster Summary -->
				<div>
					<?php
					foreach ($myRoster->operatives as $op)
					{
					?>
						<div class="px-1">
							<h6 class="d-inline"><?php echo $op->opname ?></h6> <?php echo $op->optype ?>
							<br/>
							
							<?php
							$firstwep = true;
							foreach ($op->weapons as $wep)
							{
								if (!$firstwep) {
									echo ", ";
								}
								$firstwep = false;
								
								switch ($wep->weptype) {
									case "R":
										echo "&#x2295;";
										break;
									case "M":
										echo "&#x2694;";
										break;
									default:
										echo "&#x26ED;";
										break;
								}
								echo $wep->wepname;
							}
							
							if (count($op->equipments) > 0)
							{
								echo "<br/>";
								$firsteq = true;
								foreach ($op->equipments as $eq)
								{
									if (!$firsteq) {
										echo ", ";
									}
									$firsteq = false;
									echo $eq->eqname;
									if ($eq->eqpts > 0) {
										echo " (" . $eq->eqpts . " EP)";
									}
								}
							}
							echo "<br/><br/>";
							?>
						</div>
					<?php
					}
					?>
				</div>
			</div>
			<div class="col-4 text-end">
				<!-- Roster QR Code -->
				<img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=https://ktdash.app/roster.php?rid=<?php echo $myRoster->rosterid ?>" />
			</div>
		</div>
		
		<div class="p-0 m-1 container-fluid">
		<!-- Show this roster and its operatives -->
		<?php
		foreach($myRoster->operatives as $op)
		{
		?>
			<div class="px-1" style="page-break-inside: avoid; page-break-before: auto;">
				<div class="row">
					<div class="col-7">
						<!-- Operative Name -->
						<h2><?php echo $op->opname ?></h2>
					</div>
					<div class="col-5 text-end">
						<!-- Operative Type -->
						<?php echo $op->optype ?><br/>
						<!-- Wounds Tracker -->
						<h6 class="d-inline">W:</h6>
						<?php
						for ($i = 0; $i < $op->W; $i++)
						{
							?><input type="checkbox" /><?php
						}
						?>
					</div>
				</div>
				
				<!-- Keywords -->
				<em class="text-tiny"><?php echo $op->keywords ?></em>
				
				<!-- Operative Stats -->
				<div class="row">
					<h5 class="col-2 orange text-center">M</h5>
					<h5 class="col-2 orange text-center">APL</h5>
					<h5 class="col-2 orange text-center">GA</h5>
					<h5 class="col-2 orange text-center">DF</h5>
					<h5 class="col-2 orange text-center">SV</h5>
					<h5 class="col-2 orange text-center">W</h5>
				</div>
				<div class="row">
					<h5 class="col-2 text-center"><?php echo replacedistance($op->M)   ?></h5>
					<h5 class="col-2 text-center"><?php echo $op->APL ?></h5>
					<h5 class="col-2 text-center"><?php echo $op->GA  ?></h5>
					<h5 class="col-2 text-center"><?php echo $op->DF  ?></h5>
					<h5 class="col-2 text-center"><?php echo $op->SV  ?></h5>
					<h5 class="col-2 text-center"><?php echo $op->W   ?></h5>
				</div>
				
				<!-- Weapons -->
				<div class="px-1">
					<table width="100%" class="line-top-light">
						<thead>
							<tr>
								<td>
									<h6>Weapons</h6>
								</td>
								<td class="text-center">
									<h6>&nbsp;&nbsp;A&nbsp;&nbsp;</h6>
								</td>
								<td class="text-center">
									<h6>&nbsp;&nbsp;BS&nbsp;&nbsp;</h6>
								</td>
								<td class="text-center">
									<h6>&nbsp;&nbsp;D&nbsp;&nbsp;</h6>
								</td>
							</tr>
						</thead>
						
						<!-- Weapons (Regular + Equipment) -->
						<?php
						$weapons = [];
						foreach ($op->weapons as $wep) {
							$weapons[] = $wep;
						}
						foreach ($op->equipments as $eq) {
							if ($eq->eqtype == 'Weapon') {
								$weapons[] = $eq->weapon;
							}
						}
						foreach($weapons as $wep)
						{
							if (count($wep->profiles) == 1)
							{
								?>
								<tr>
									<td width="70%">
									<?php
									switch ($wep->weptype) {
										case "R":
											echo "&#x2295;";
											break;
										case "M":
											echo "&#x2694;";
											break;
										default:
											echo "&#x26ED;";
											break;
									}
									
									echo $wep->wepname;
									if ($wep->profiles[0]->SR != "")
									{
										echo " <em>(" . replaceDistance($wep->profiles[0]->SR) . ")</em>";
									}
									?>
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;<?php echo $wep->profiles[0]->A ?>&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;&nbsp;<?php echo $wep->profiles[0]->BS ?>&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;<?php echo $wep->profiles[0]->D ?>&nbsp;&nbsp;
									</td>
								</tr>
								<?php
							}
							else
							{
								?>
								<tr>
									<td colspan="4">
									<?php
									switch ($wep->weptype) {
										case "R":
											echo "&#x2295;";
											break;
										case "M":
											echo "&#x2694;";
											break;
										default:
											echo "&#x26ED;";
											break;
									}
									
									echo $wep->wepname;
									if ($wep->SR != "") {
										echo " <em>(" . replaceDistance($wep->SR) . ")</em>";
									}
									?>
									</td>
								</tr>
								<?php
								foreach($wep->profiles as $pro)
								{
								?>
									<tr>
										<td>
											&nbsp;&nbsp;&nbsp;&nbsp;
											- <?php echo $pro->name ?>
											<em><?php echo replaceDistance($pro->SR) ?></em>
										</td>
										<td class="text-center h6">
											&nbsp;&nbsp;<?php echo $pro->A ?>&nbsp;&nbsp;
										</td>
										<td class="text-center h6">
											&nbsp;&nbsp;&nbsp;<?php echo $pro->BS ?>&nbsp;&nbsp;
										</td>
										<td class="text-center h6">
											&nbsp;&nbsp;<?php echo $pro->D ?>&nbsp;&nbsp;
										</td>
									</tr>
								<?php
								}
							}
						}
						?>
					</table>
				</div>
				
				<!-- Abilities -->
				<?php
				if (count($op->abilities) > 0)
				{
				?>
					<div class="line-top-light px-1 m-0">
						<h6>Abilities</h6>
						<?php
						if (count($op->abilities) > 1 || strlen($op->abilities[0]->description) > 500)
						{
						?>
							<div style="columns: 200px 2;">
						<?php
						}
						else
						{
						?>
							<div>
						<?php
						}
						
						
						foreach($op->abilities as $ab)
						{
						?>
							<div class="px-1">
								<strong><?php echo $ab->title ?>: </strong>
								<p class="d-inline px-2" style="text-align:justify;"><?php echo replaceDistance($ab->description) ?></p>
							</div>
						<?php
						}
						
						// Close the div for abilities
						echo "</div>";
						?>
					</div>
				<?php
				}
				?>
				
				<!-- Unique Actions -->
				<?php
				if (count($op->uniqueactions) > 0)
				{
				?>
					<div class="line-top-light px-1 m-0">
						<h6>Unique Actions</h6>
						<?php
						if (count($op->uniqueactions) > 1 || strlen($op->uniqueactions[0]->description) > 500)
						{
						?>
							<div style="columns: 200px 2;">
						<?php
						}
						else
						{
						?>
							<div>
						<?php
						}
						
						
						foreach($op->uniqueactions as $ua)
						{
						?>
							<div class="px-1">
								<strong><?php echo $ua->title ?> (<?php echo $ua->AP ?> AP): </strong>
								<p class="d-inline px-2" style="text-align:justify;"><?php echo replaceDistance($ab->description) ?></p>
							</div>
						<?php
						}
						
						// Close the div for unique actions
						echo "</div>";
						?>
					</div>
				<?php
				}
				?>
				
				<!-- Equipment -->
				<?php
				if (count($op->equipments) > 0)
				{
				?>
					<div class="line-top-light px-1 m-0">
						<h6>Equipment</h6>
						<?php
						if (count($op->equipments) > 1 || strlen($op->equipments[0]->eqdescription) > 500)
						{
						?>
							<div style="columns: 200px 2;">
						<?php
						}
						else
						{
						?>
							<div>
						<?php
						}
						
						
						foreach($op->equipments as $eq)
						{
						?>
							<div class="px-1">
								<strong>
								<?php
									echo $eq->eqname;
									if ($eq->eqpts > 0) {
										echo " (" . $eq->eqpts . " EP)";
									}
									echo ":"
								?></strong>
								<p class="d-inline px-2" style="text-align:justify;"><?php echo replaceDistance($eq->eqdescription) ?></p>
							</div>
						<?php
						}
						
						// Close the div for unique actions
						echo "</div>";
						?>
					</div>
				<?php
				}
				?>
				
				<br/><br/>
			</div>
			<?php
		}
		?>
		</div>
	</body>
</html>