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

	$abilities = [];

	// Now move the abilities around to make it take less room and not repeat the obvious
	for ($opnum = 0; $opnum < count($myRoster->operatives); $opnum++) {
		$op = $myRoster->operatives[$opnum];
		if ($op->abilities && count($op->abilities) > 0) {
			// This operative has abilities
			for ($opabnum = 0; $opabnum < count($op->abilities); $opabnum++) {
				$ab = $op->abilities[$opabnum];

				if (strlen($ab->description) > 700) {
					// Find if this ability is already in the list of common long abilities
					$found = false;
					for ($abnum = 0; $abnum < count($abilities); $abnum++) {
						if ($abilities[$abnum]->title == $ab->title) {
							// Same ability, already in the list of common long abilities
							$found = true;
							break;
						}
					}

					if (!$found) {
						// This ability is not in the list of common long abilities, add it
						$abilities[] = json_decode(json_encode($ab));
					}

					// Clear this operative's ability description to make room
					$ab->description = "(See Abilities below)";
				}
			}
		}
	}
	
	// Now move the unique actions around to make it take less room and not repeat the obvious
	for ($opnum = 0; $opnum < count($myRoster->operatives); $opnum++) {
		$op = $myRoster->operatives[$opnum];
		if ($op->uniqueactions && count($op->uniqueactions) > 0) {
			// This operative has uniqueactions
			for ($opuanum = 0; $opuanum < count($op->uniqueactions); $opuanum++) {
				$ua = $op->uniqueactions[$opuanum];

				if (strlen($ua->description) > 400) {
					// Find if this ability is already in the list of common long uniqueactions
					$found = false;
					for ($uanum = 0; $uanum < count($uniqueactions); $uanum++) {
						if ($uniqueactions[$uanum]->title == $ua->title) {
							// Same unique action, already in the list of common long uniqueactions
							$found = true;
							break;
						}
					}

					if (!$found) {
						// This uniqueaction is not in the list of common long uniqueactions, add it
						$uniqueactions[] = json_decode(json_encode($ua));
					}

					// Clear this operative's uniqueaction description to make room
					$ua->description = "(See Unique Actions below)";
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = $myRoster->rostername . " - Print Roster";
			$pagedesc  = $myRoster->rostername . " - Print Roster";
			$pagekeywords = "";
			$pageimg   = "https://ktdash.app/api/rosterportrait.php?rid={$myRoster->rosterid}";
			$pageurl   = "https://ktdash.app/printroster.php?rid={$myRoster->rosterid}";
			include "og.php";
		?>
		<link rel="stylesheet" href="/css/bootstrap-print.min.css">
		<style>
		<?php include "css/styles.css"; ?>
		<?php if(getIfSet($_REQUEST['cols']) == "1") { ?>
		@media print {
			body {
				zoom: 100% !important;
			}
		}
		<?php } ?>
		</style>
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
			<div class="col-4">
				<!-- Roster QR Code -->
				<img src="https://image-charts.com/chart?cht=qr&chs=150x150&chl=https://ktdash.app/roster.php?rid=<?php echo $myRoster->rosterid ?>" />
			</div>
		</div>
		
		<div class="p-0 m-1 container-fluid<?php if (getIfSet($_REQUEST['cols']) == "2") echo " twocols"; ?>">
		<!-- Show this roster and its operatives -->
		<?php
		foreach($myRoster->operatives as $op)
		{
		?>
			<div class="px-1" style="page-break-inside: avoid; page-break-before: auto; border: 1px solid #000;">
				<div class="row p-0 m-0">
					<div class="col-7 p-0 m-0">
						<!-- Operative Name -->
						<h2><?php echo $op->opname ?></h2>
					</div>
					<div class="col-5 p-0 m-0 text-end">
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
				<em class="small"><?php echo htmlentities($op->keywords, ENT_HTML5  , 'UTF-8') ?></em>
				
				<div class="row p-0 m-0">
						<div class="col-3 m-0 p-0 pointer h-100" style="overflow: hidden;">
							<!-- Operative Portrait -->
							<img
								src="/api/operativeportrait.php?roid=<?php echo $op->rosteropid ?>"
								style="border: 1px solid #EEE; width: 100%; min-height: 140px; max-height: 140px; object-fit:cover; object-position:50% 0%; display:block;" />
						</div>
						<div class="col-9">
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
						</div>
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
											<?php if ($pro->SR != "") {?>
											<em>(<?php echo replaceDistance($pro->SR) ?>)</em>
											<?php
											}
											?>
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
								<p class="d-inline px-2" style="text-align: justify;"><?php echo replaceDistance($ab->description) ?></p>
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
								<p class="d-inline px-2" style="text-align: justify;"><?php echo replaceDistance($ua->description) ?></p>
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
								?></strong>
								<?php if ($eq->eqtype != 'Weapon') {
								echo ":";
								?>
								
								<p class="d-inline px-2" style="text-align: justify;"><?php echo replaceDistance($eq->eqdescription) ?></p>
								<?php
								} else {
									echo " <em>(See Weapons)</em>";
								}
								?>
							</div>
						<?php
						}
						
						// Close the div for equipment content
						echo "</div>";
						?>
					</div>
				<?php
				}
				?>
				
				<!-- Notes -->
				<?php
				if ($op->notes != null && $op->notes != "")
				{
				?>
					<div class="line-top-light px-1 m-0">
						<h6>Notes</h6>
						<p class="d-inline px-2" style="text-align:justify;"><?php echo htmlspecialchars($op->notes) ?></p>
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

		<?php
			if (count($abilities) > 0) {
			?>
			<br/><br/>
			<!-- Common Abilities -->
			<div class="p-0 m-0" style="page-break-inside: avoid; page-break-before:auto;">
				<h2>Abilities</h2>
				<div class="p-1 twocols">
					<?php
						for ($abnum = 0; $abnum < count($abilities); $abnum++) {
							$ab = $abilities[$abnum];
						?>
						<h3><?php echo $ab->title ?>: </h3>
						<?php echo replacedistance($ab->description) ?>
						<hr/>
						<?php
						}
					?>
				</div>
			</div>
		<?php
		}
		?>
		<?php
			if (count($uniqueactions) > 0) {
			?>
			<br/><br/>
			<!-- Common uniqueactions -->
			<div class="p-0 m-0" style="page-break-inside: avoid; page-break-before:auto;">
				<h2>Unique Actions</h2>
				<div class="p-1 twocols">
					<?php
						for ($uanum = 0; $uanum < count($uniqueactions); $uanum++) {
							$ua = $uniqueactions[$uanum];
						?>
						<div  style="page-break-inside: avoid; page-break-before:auto;">
							<h4><?php echo $ua->title ?> (<?php echo $ua->AP ?> AP): </h4>
							<?php echo replacedistance($ua->description) ?>
							<hr/>
						</div>
						<?php
						}
					?>
				</div>
			</div>
		<?php
		}
		?>
	</body>
</html>